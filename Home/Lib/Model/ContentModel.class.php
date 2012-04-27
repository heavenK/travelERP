<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename ContentModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class ContentModel extends BaseModel {

    private function getblacker() {
        $blackuids=array();
        $black=D('Blacklist')->where("black_uid='".$this->my['user_id']."'")->select();
        if ($black) {
            foreach($black as $val) {
                $blackuids[]=$val['user_id'];
            }
        }
        return $blackuids;
    }

    //用户at列表
    private function atuserlist($uname,$unick) {
        if ($uname!=$this->my['user_name']) {
            $atModel=D('Atusers');
            $dt=$atModel->where("user_id='".$this->my['user_id']."' AND (atuname='$uname' OR atnickname='$unick')")->find();
            if ($dt) {
                $atModel->where("`id`='$dt[id]'")->setField(array('atnums','dateline'),array(array('exp','atnums+1'),time()));
            } else {
                $insert['user_id']=$this->my['user_id'];
                $insert['atuname']=$uname;
                $insert['atnickname']=$unick;
                $insert['dateline']=time();
                $atModel->add($insert);
            }
        }
    }

    //更新at数目
    public function atreplace($content,$setinc=1) {
        $uModel=D('Users');
        if(strpos($content,'@')!==false) {
            $content2=str_replace('@',' @',$content);
            if(preg_match_all('~\@([.-_\w\d\_\-\x7f-\xff]+)(?:[\r\n\t\s ]+|[\xa1\xa1]+)~',($content2 . ' '),$match)) {
                if(is_array($match[1]) && count($match[1])) {
                    foreach($match[1] as $k=>$v) {
                        $v = trim($v);
                        if('　'==substr($v,-2)) {
                            $v = substr($v,0,-2);
                        }
                        if($v && strlen($v)<16) {
                           $match[1][$k] = $v;
                        }
                    }
                    $list=implode("','",$match[1]);
                    $row=$uModel->field('user_id,user_name,nickname')->where("user_name IN ('$list') OR nickname IN ('$list')")->select();
                    foreach ($row as $val) {
                        if ($val['nickname']!=$val['user_name']) {
                            //nickname
                            $cont_sch[] = "@{$val[nickname]}";
                            $cont_rpl[] = "[AT {$val[user_name]}]@{$val[nickname]}[/AT]";
                        }
                        //user_name
                        $cont_sch[] = "@{$val[user_name]}";
                        $cont_rpl[] = "[AT {$val[user_name]}]@{$val[nickname]}[/AT]";
                        if ($val['user_name']!=$this->my['user_name']) {
                            $condition[]='user_name="'.$val['user_name'].'"';
                        }
                        $uids[]=$val['user_id'];
                        //atuserlist
                        $this->atuserlist($val['user_name'],$val['nickname']);
                    }
                }
            }
        }
        $uids=array_unique($uids);
        if ($cont_sch && $cont_rpl) {
            $content = str_replace($cont_sch,$cont_rpl,$content);
        }
        if ($condition && $setinc==1) {
            $condition=implode(' OR ',$condition);
            $uModel->setInc('atnum',$condition);//更新提及个数
        }

        return array('content'=>$content,'uids'=>$uids);
    }

    private function attopicurl($content,$isret=1) {
        //at replace
        $atreplace=$this->atreplace($content,$isret);
        $content=$atreplace['content'];
        //short url
        if (strpos($content,'://')!==false) {
            if (preg_match_all('~(?:https?\:\/\/)(?:[A-Za-z0-9\_\-]+\.)+[A-Za-z0-9\:]{2,10}(?:\/[\w\d\/=\?%\-\&_\~\`\@\[\]\:\+\#\.]*(?:[^\<\>\'\"\n\r\t\s\x7f-\xff])*)?~',$content,$match)) {
                foreach ($match[0] as $v) {
                    $v = trim($v);
                    $parse=parse_url($v);
                    if ($parse['host']=='goo.gl' || $parse['host']=='bit.ly' || $parse['host']==$this->site['shorturl']) {
                        $cont_sch[] = "{$v}";
                        $cont_rpl[] = "[U {$v}]{$v}[/U]";
                    } else {
                        if ($this->site['shortserver']<2) {
                            $server=str_replace('http://','',shortserver($this->site['shortserver']));
                            $gourl = get_content($server,str_replace('&amp;','&',$v));
                            $tp = explode('/',$gourl);
                            $key=$tp[3];
                            $serverid=' '.$this->site['shortserver'];
                        } else {
                            $key=$this->IntToABC(time());
                            $serverid='';
                        }
                        $url['key']=$key;
                        $url['url']=$v;
                        D('Url')->add($url);
                        $cont_sch[] = "{$v}";
                        $cont_rpl[] = "[U {$key}{$serverid}]{$v}[/U]";
                    }
                }
            }
        }
        //topic
        if (strpos($content,'#')!==false) {
            if (preg_match_all('~\#([^\#]+?)\#~',$content,$match)) {
                $tm=D('Topic');
                foreach ($match[1] as $v) {
                    $v = str_replace(array('(',')'),'',trim($v));
                    $vl = StrLenW($v);
                    if($vl>=2 && $vl<=15) {
                        $tags[$v] = $v;
                        $cont_sch[] = "#{$v}#";
                        $cont_rpl[] = "[T]{$v}[/T]";
                        $topics[]=$v;
                    }
                }
            }
        }
        //update topic
        $topics=array_unique($topics);
        if ($isret==1) {
            foreach ($topics as $v) {
                $topic=$tm->where("topicname='$v'")->find();
                if (!$topic) {
                    $tpinsert['topicname']=$v;
                    $tpinsert['topictimes']=1;
                    $topicid[]=$tm->add($tpinsert);
                } else {
                    $tm->setInc('topictimes',"topicname='$v'");
                    $topicid[]=$topic['id'];
                }
            }
        }
        if ($cont_sch && $cont_rpl) {
            $cont_sch=array_unique($cont_sch);
            $cont_rpl=array_unique($cont_rpl);
            $content = str_replace($cont_sch,$cont_rpl,$content);
        }
        return array($content,$atreplace,$topicid);
    }

    public function typenums($content) {
        $p='~(?:https?\:\/\/)(?:[A-Za-z0-9\_\-]+\.)+[A-Za-z0-9\:]{2,10}(?:\/[\w\d\/=\?%\-\&_\~\`\@\[\]\:\+\#\.]*(?:[^\<\>\'\"\n\r\t\s\x7f-\xff])*)?~';
        preg_match_all($p,$content,$match);
        if ($match[0]) {
            $webnum=count($match[0]);
        } else {
            $webnum=0;
        }

        if($this->site['shortserver']<=1){
            $shorturl=shortserver($this->site['shortserver']);
        } else {
            $shorturl=$this->site['shorturl'];
        }

        $c=preg_replace($p,$shorturl,$content);
        $len=StrLenW($c)+$webnum*8;
        return $len;
    }

    //写入广播
    public function sendmsg($content,$morecontent,$from='',$condition='') {
        $from=$from?$from:L('fromweb');
        $uModel=D('Users');
        if ($condition) {//mobile,qq,gtalk
            foreach ($condition as $key=>$val) {
                $where[]=$key.'="'.$val.'"';
            }
            $cond=implode(' AND ',$where);
            if ($cond) {
                $user=$uModel->where($cond)->find();
                if (!$user) {
                    $ret=array('ret'=>L('no_exist_user'),'insertid'=>0);
                    return json_encode($ret);
                    exit;
                }
            } else {
                $ret=array('ret'=>L('no_exist_user'),'insertid'=>0);
                return json_encode($ret);
                exit;
            }
        } else {
            $user=$this->my;
        }
        $content=daddslashes(trim($content));
        if ($this->typenums($content)>140) {
            $ret=array('ret'=>L('talklong'),'insertid'=>0);
            return json_encode($ret);
            exit;
        }
        $morecontent=daddslashes(trim($morecontent));
        if ($user['userlock']==2) {
            $ret=array('ret'=>L('user_jingyan'),'insertid'=>0);
            return json_encode($ret);
            exit;
        }
        $content=$this->replace($content); //词语过滤
        if (!empty($content) && $user['user_id']) {
            $type=$morecontent?'photo':'';
            if ($user['lastcontent']==$content) {
                $ret=array('ret'=>L('same_talk'),'insertid'=>0);
                return json_encode($ret);
            }
            //attopicurl replace
            $attopicurl=$this->attopicurl($content);
            $content=$attopicurl[0];
            $atreplace=$attopicurl[1];
            $topicid=$attopicurl[2];
            //share
            preg_match_all('~(?:https?\:\/\/)(?:[A-Za-z0-9_\-]+\.)+[A-Za-z0-9\:]{2,10}(?:\/[\w\d\/=\?%\-\&_\~`@\[\]\:\+\#\.]*(?:[^<>\'\"\n\r\t\s])*)?~',$content,$match1);
            if(!empty($match1[0])) {
                $stringlink = implode(glue,$match1[0]);
                $stringlink = str_replace('[/U]','',$stringlink);
                if($stringlink != $is_post_url) {
                    $vidoLink = parse_url($stringlink);
                    $vido_host = get_host($vidoLink['host']);
                    $ReturnMusic = preg_match("/\.(mp3|wma)$/i", $stringlink);
                    $ReturnFlash = preg_match("/\.(flv|swf)$/i", $stringlink);
                    $ReturnHost = preg_match("/(youku\.com|ku6\.com|sohu\.com|mofile\.com|sina\.com\.cn|tudou\.com|youtube\.com)$/i", $vido_host);
                    if($ReturnHost == 1 && !$ReturnFlash && !$ReturnMusic) {
                        if('youku.com' == $vido_host){
                            $youku = file_get_contents($stringlink);
                            preg_match_all("/<li class=\"download\"(.*)<\/li>/",$youku,$match2);
                            preg_match_all("/id\_(\w+)[=.]/",$stringlink,$matches);//http://v.youku.com/v_show/id_XMjYwNTExOTU2.html
                            if(empty($matches[1][0])){//http://v.youku.com/v_playlist/f6020209o1p0.html
                                preg_match_all("/iku\:\/\/\|video\|http\:\/\/v.youku.com\/v_show\/id\_(.*?)\.html/",$match2[1][0],$matches);
                            }
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            preg_match("/\|(http\:\/\/g\d\.ykimg\.com\/[^\|]+)\|/",$match2[1][0],$imageurl);
                            if (!$imageurl[1]) {
                                preg_match_all('/<a title="转发至新浪微博"(.*?)href="(.*?)pic=(.*?)"(.*?)>/',$youku,$match3);
                                $returnImage = $match3[3][0];
                            } else {
                                $returnImage = $imageurl[1];
                            }
                        } elseif('tudou.com' == $vido_host) {
                            $tudou = file_get_contents($stringlink);
                            $tudou = iconv('gbk','utf-8//IGNORE',$tudou);
                            preg_match_all("/view\/([\w])/",$stringlink,$matches);//http://www.tudou.com/programs/view/H4NhH5nvSgs/
                            preg_match_all("/thumbnail = pic = '(.*?)'/",$tudou,$imageurl); //,thumbnail = pic = 'http://i3.tdimg.com/094/109/402/m25.jpg'
                            if(empty($matches[1][0])){
                                preg_match_all('/icode\:"(.*?)"/',$tudou,$matches);//http://www.tudou.com/playlist/p/l12038429.html
                                preg_match_all('/pic\:"(.*?)"/',$tudou,$imageurl);
                            }
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $returnImage = $imageurl[1][0];
                        } elseif('ku6.com' == $vido_host) {
                            $ku6 = file_get_contents($stringlink);
                            $ku6 = iconv('gbk','UTF-8',$ku6);
                            preg_match_all("/$ns.href = 'http\:\/\/v.ku6.com\/special\/show_([\w\-]+)\/([\w\-]+).html'/", $ku6,$matches);//all
                            if(!empty($matches[2][0])) {
                                $returnlink = $matches[2][0];
                            }
                            preg_match_all("/<span class=\"s_pic\">(.*)<\/span>/",$ku6,$imageurl);
                            $returnImage = $imageurl[1][0];
                        } elseif('mofile.com' == $vido_host){
                            preg_match_all("/\/([\w\-]+)\.shtml/",$stringlink,$matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $mofile = file_get_contents($stringlink);
                            preg_match_all("/thumbpath=\"(.*?)\";/i",$mofile,$imageurl);
                            $returnImage = $imageurl[1][0];
                        } elseif('sina.com.cn' == $vido_host) {
                            preg_match_all("/\/(\d+)\-(\d+)\.html/i",$stringlink,$matches);//http://video.sina.com.cn/v/b/51187154-1854900491.html
                            $sina = file_get_contents($stringlink);
                            preg_match_all("/pic: \'(.*?)\',/i",$sina,$imageurl);
                            $returnImage = $imageurl[1][0];
                            if(empty($matches[1][0])){
                                if ($vidoLink['host']=='video.sina.com.cn') {//http://video.sina.com.cn/p/news/c/v/2011-05-02/131861328229.html
                                    preg_match_all("/swfOutsideUrl:\'http:\/\/you.video.sina.com.cn\/api\/sinawebApi\/outplayrefer.php\/vid=(.*?)\/s\.swf\',/i", $sina, $matches);
                                    preg_match_all("/pic: \'(.*?)\',/i",$sina,$imageurl);
                                    $returnImage = $imageurl[1][0];
                                } else if ($vidoLink['host']=='tv.video.sina.com.cn') {//http://tv.video.sina.com.cn/play/95177.html
                                    preg_match_all("/\/(\d+)\.html/i", $stringlink, $matches);
                                    preg_match_all("/onerror=\"this.src=\'(.*?)\'\"/i",$sina,$imageurl);
                                    $returnImage = $imageurl[1][0];
                                }
                            }
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                        } elseif('sohu.com' == $vido_host) {
                            preg_match_all("/\/(\d+)\/"."*$/",$stringlink,$matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                        } elseif('youtube.com' == $vido_host) {
                            //http://www.youtube.com/watch?v=oyi3_IDM2Kk
                            preg_match_all("/watch\?v=([\w\-]+)/",$stringlink,$matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $youtube = file_get_contents($stringlink);
                            preg_match_all('/<meta property="og:image" content="(.*)">/',$youtube,$imageurl);
                            $returnImage = $imageurl[1][0];
                        }
                        if ($returnlink) {
                            $returnImage=$returnImage?$returnImage:__PUBLIC__.'/images/video.gif';
                            $share="[V h={$vido_host} p={$returnImage}]{$returnlink}[/V]";
                            $type='video';
                        }
                    } else if($ReturnMusic == 1) {
                        $share="[M]{$stringlink}[/M]";
                        $type='music';
                    } else if($ReturnFlash == 1) {
                        $share="[M]{$stringlink}[/M]";
                        $type='video';
                    }
                }
            }
            $morecontent.=$share;
            $insert['user_id']=$user['user_id'];
            $insert['content_body']=$content;
            $insert['media_body']=$morecontent;
            $insert['type']=$from;
            $insert['filetype']=$type;
            $insert['posttime']=time();
            $insertid=$this->add($insert);

            //hook
            $plugin= new pluginManager();//初始化插件函数
            $plugin->do_action('sendtalk');

            $uModel->where("user_id='".$user['user_id']."'")->setField(array('msg_num','lastcontent','lastconttime'),array(array('exp','msg_num+1'),$content,time()));
            //add content_topic
            if (is_array($topicid)) {
                $ct=D('Content_topic');
                foreach($topicid as $val) {
                    $ctdata['topic_id']=$val;
                    $ctdata['content_id']=$insertid;
                    $ct->add($ctdata);
                }
            }
            //add content_mention
            $uids=$atreplace['uids'];
            if ($uids) {
                //黑名单
                $blackuids=$this->getblacker();
                $cm=D('Content_mention');
                foreach($uids as $val) {
                    if (!in_array($val,$blackuids)) {
                        $cmdata['cid']=$insertid;
                        $cmdata['user_id']=$val;
                        $cmdata['dateline']=time();
                        $cm->add($cmdata);
                    }
                }
            }
            if ($type=='photo') {
                $plugin->do_action('photo');
            } else if ($type=='video' || $type=='music') {
                $plugin->do_action('share');
            }
            $ret=array('ret'=>'success','insertid'=>$insertid);
            return json_encode($ret);
        } else {
            $ret=array('ret'=>L('send_talk_error'),'insertid'=>0);
            return json_encode($ret);
        }
    }
    //转播
    public function retwit($cid,$retwit,$type='') {
        $type=$type?$type:L('fromweb');
        if ($this->my['userlock']==2) {
            $ret=array('ret'=>L('user_jingyan'),'insertid'=>0,'retid'=>0);
            return json_encode($ret);
            exit;
        }
        if ($retwit) {
            $retwit=daddslashes(trim($retwit));
            $retwit=$this->replace($retwit);
            if ($this->typenums($retwit)>140) {
                $ret=array('ret'=>L('talklong'),'insertid'=>0,'retid'=>0);
                return json_encode($ret);
                exit;
            }
        }
        if ($cid) {
            $data = $this->where("content_id='$cid'")->find();
            if($data && $this->my['user_id']) {
                $cid=$data['retid']?$data['retid']:$cid;
                //attopicurl replace
                $attopicurl=$this->attopicurl($retwit);
                $retwit=$attopicurl[0];
                $dt=$attopicurl[1];
                $topicid=$attopicurl[2];
                //insert
                $insert['user_id']=$this->my['user_id'];
                $insert['content_body']=$retwit;
                $insert['posttime']=time();
                $insert['retid']=$cid;
                $insert['type']=$type;
                $insertid=$this->add($insert);

                $plugin= new pluginManager();//初始化插件函数
                $plugin->do_action('retwit');//hook

                //add content_topic
                if (is_array($topicid)) {
                    $ct=D('Content_topic');
                    foreach($topicid as $val) {
                        $ctdata['topic_id']=$val;
                        $ctdata['content_id']=$insertid;
                        $ct->add($ctdata);
                    }
                }
                //add content_mention
                $uids=$dt['uids'];
                if ($data['user_id']!=$this->my['user_id']) {
                    $uids[]=$data['user_id'];
                }
                $uids=array_unique($uids);
                if ($uids) {
                    //黑名单
                    $blackuids=$this->getblacker();
                    $cm=D('Content_mention');
                    foreach($uids as $val) {
                        if (!in_array($val,$blackuids)) {
                            $cmdata['cid']=$insertid;
                            $cmdata['user_id']=$val;
                            $cmdata['dateline']=time();
                            $cm->add($cmdata);
                        }
                    }
                }

                $this->setInc('zftimes',"content_id='$cid'");
                D('Users')->updatemsgnum($this->my['user_id'],'++');
                $ret=array('ret'=>'success','insertid'=>$insertid,'retid'=>$cid);

                return json_encode($ret);
            } else {
                $ret=array('ret'=>L('send_talk_error'),'insertid'=>0,'retid'=>0);
                return json_encode($ret);
            }
        } else {
            $ret=array('ret'=>L('send_talk_error'),'insertid'=>0,'retid'=>0);
            return json_encode($ret);
        }
    }
    //删除广播
    public function delmsg($contentid) {
        if ($contentid) {
            $data = $this->where("content_id='$contentid'")->find();
            if ($this->my['isadmin']>0 || $data['user_id']==$this->my['user_id']) {
                if ($data) {
                    $this->where("content_id='$contentid'")->delete();
                    //删除话题
                    $ctp=D('Content_topic');
                    $cdata=$ctp->where("content_id='$contentid'")->select();
                    if (is_array($cdata)) {
                        foreach ($cdata as $val) {
                            D('Topic')->where("id='$val[topic_id]'")->setDec('topictimes');
                        }
                    }
                    $ctp->where("content_id='$contentid'")->delete();
                    //消息数更新
                    if ($data['replyid']) {
                        $this->setDec('replytimes',"content_id='$data[replyid]'");
                    } else {
                        if ($data['retid']) {
                            $this->setDec('zftimes',"content_id='$data[retid]'");
                        }
                        D('Users')->updatemsgnum($data['user_id'],'--');
                    }
                    //删除上传的图片
                    preg_match_all("/\[F l=(.*)\](.*)\[\/F\]/",$data['media_body'],$pics);
                    if (count($pics)==3) {
                        @unlink(ET_ROOT.'/Public/attachments/'.str_replace(ET_URL,'',$pics[1][0]));
                        @unlink(ET_ROOT.'/Public/attachments/'.str_replace(ET_URL,'',$pics[2][0]));
                    }
                }
                //删除mention
                D('Content_mention')->where("cid='$contentid'")->delete();

                $plugin= new pluginManager();//初始化插件函数
                $plugin->do_action('deltalk');//hook
                return 'success';
            } else {
                return L('del_talk_error');
            }
        } else {
            return L('del_talk_error');
        }
    }

    //评论
    public function doreply($content,$sid,$isret,$type='') {
        $type=$type?$type:L('fromweb');
        if ($this->my['userlock']==2) {
            $ret=array('ret'=>L('user_jingyan_reply'),'insertid'=>0);
            return json_encode($ret);
            exit;
        }
        $cm=D('Comments');
        $uModel=D('Users');
        $content=daddslashes(trim($content));
        $content=$this->replace($content);
        if ($this->typenums($content)>140) {
            $ret=array('ret'=>L('talklong'),'insertid'=>0);
            return json_encode($ret);
            exit;
        }
        if ($sid && $content) {
            $data = $this->where("content_id='$sid'")->find();
            if($data && $this->my['user_id']) {
                //黑名单
                $blackuids=$this->getblacker();
                if (in_array($data['user_id'],$blackuids)) {
                    $ret=array('ret'=>L('blackuser'),'insertid'=>0);
                    return json_encode($ret);
                    exit;
                }
                //attopicurl replace
                $attopicurl=$this->attopicurl($content,0);
                $content=$attopicurl[0];
                $dt=$attopicurl[1];
                //insert
                $insert['user_id']=$this->my['user_id'];
                $insert['content_body']=$content;
                $insert['posttime']=time();
                $insert['replyid']=$sid;
                $insert['type']=$type;
                $insertid=$this->add($insert);

                $plugin= new pluginManager();//初始化插件函数
                $plugin->do_action('reply');//hook

                $this->setInc('replytimes',"content_id='$sid'");

                //转发
                if ($isret==1) {
                    $this->retwit($sid,$content,$type);
                }

                //add content_mention
                $uids=$dt['uids'];
                $uids[]=$data['user_id'];
                $uids=array_unique($uids);
                foreach ($uids as $val) {
                    if ($val!=$this->my['user_id']) {
                        $com['user_id']=$val;
                        $com['comment_uid']=$this->my['user_id'];
                        $com['content_id']=$sid;
                        $com['comment_body']=$content;
                        $com['dateline']=time();
                        $cm->add($com);
                        $uModel->setInc('comments',"user_id='$val'");
                    }
                }

                $ret=array('ret'=>'success','insertid'=>$insertid);

                return json_encode($ret);
            } else {
                $ret=array('ret'=>L('data_error'),'insertid'=>0);
                return json_encode($ret);
            }
        } else {
            $ret=array('ret'=>L('talk_null'),'insertid'=>0);
            return json_encode($ret);
        }
    }

    //上传图片
    public function uploadpic($url=0) {
        if ($this->my['user_id']) {
            import("@.ORG.UploadFile");
            $upload = new UploadFile();
            $upload->maxSize  = 2097152 ;
            $upload->allowExts  = explode(',','jpg,gif,png,jpeg');
            $upload->savePath =  ET_ROOT.'/Public/attachments/photo/';
            $upload->thumb =  true;
            if ($url) {
                $upload->outpicurl =  $url;
            }
            $upload->thumbPrefix   =  's_';
            $upload->thumbMaxWidth =  '120';
            $upload->thumbMaxHeight = '120';
            $upload->subType = 'date';
            $upload->autoSub = true;
            $upload->saveRule = time;
            $upload->thumbRemoveOrigin = false;
            $uploadurl='/photo/'.date('Ymd').'/';
            if($upload->upload()) {
                $uploadList = $upload->getUploadFileInfo();
                if ($this->site['wateropen']==1) { //水印
                    import("@.ORG.Image");
                    Image::water($uploadList[0]['savepath'].'/'.$uploadList[0]['savename'],9,'',SITE_URL.'/'.$this->my['user_name']);
                }
                $content="[F l=".$uploadurl.$uploadList[0]['savename']."]".$uploadurl.'s_'.$uploadList[0]['savename']."[/F]";
                $ret=array('ret'=>'success','img'=>__PUBLIC__.'/attachments'.$uploadurl.'s_'.$uploadList[0]['savename'],'name'=>$uploadList[0]['savename'],'content'=>$content);
                return json_encode($ret);
            } else {
                $ret=array('ret'=>L('photo_error'),'img'=>'','name'=>'','content'=>'');
                return json_encode($ret);
            }
        } else {
            $ret=array('ret'=>L('no_login'),'img'=>'','name'=>'','content'=>'');
            return json_encode($ret);
        }
    }

    function loadoneli($data,$favbtn=1,$wide=0,$loadone=0,$view=0) {
        $user_id=$data['user_id'];
        $user_head=sethead($data['user_head']);
        $user_name=$data['user_name'];
        $nickname=$data['nickname'];
        $user_auth=$data['user_auth'];
        $content=$this->ubb($data['content_body']);
        $content.=$this->ubb($data['media_body']);
        $_city=explode(' ',$data['live_city']);
        $city=$_city[1]?'<a href="'.SITE_URL.'/Pub?t=city&c='.$_city[1].'">'.$_city[1].'</a>':'';

        //评论不加载内容
        if ($loadone==0) {
            $pl="replyajax('".$data['content_id']."')";
            $delreurl='';
            $class='';
            $avatarclass='';
        } else {
            $pl="replyajaxbox('".$data['content_id']."')";
            $delreurl=SITE_URL."/".rawurlencode($this->my['user_name']);
            $class='greybox';
            $avatarclass=' greyavatar';
        }
        //宽版还是窄版
        if ($wide==0) {
            $r.='<li class="unlight" id="'.$data['content_id'].'"><a href="'.SITE_URL.'/'.rawurlencode($user_name).'" class="avatar'.$avatarclass.'"><img src="'.$user_head.'" alt="'.$nickname.'" /></a><div class="'.$class.'"><div class="content">';
        } else {
            $r.='<li class="unlight" id="'.$data['content_id'].'"><div class="'.$class.'"><div class="contentl">';
        }
        //转播
        if ($data['retid']) {
            if ($view==1) { //不显示转播内容
                $r.='<a href="'.SITE_URL.'/'.rawurlencode($user_name).'" class="author '.setvip($user_auth).'" '.viptitle($user_auth).'>'.$nickname.'</a><h5>'.L('contret').':</h5><span id="ret'.$data['content_id'].'">'.$content.'</span></div>';
            } else {
                $r.='<a href="'.SITE_URL.'/'.rawurlencode($user_name).'" class="author '.setvip($user_auth).'" '.viptitle($user_auth).'>'.$nickname.'</a><h5>'.L('contret').':</h5><span id="ret'.$data['content_id'].'">'.$content.'</span>'.$data['retbody'].'</div>';
            }
        } else {
            $r.='<a href="'.SITE_URL.'/'.rawurlencode($user_name).'" class="author '.setvip($user_auth).'" '.viptitle($user_auth).'>'.$nickname.'</a><h6>:</h6><span id="cont'.$data['content_id'].'">'.$content.'</span></div>';
        }
        $r.='<span class="stamp fleft"><a href="'.SITE_URL.'/v/'.$data['content_id'].'" class="ctime" title="'.gmdate(L('date').' H:i',$data['posttime']+8*3600).'">'.timeop($data['posttime']).'</a>&nbsp;'.L('tfrom').''.$data['type'].'&nbsp;&nbsp;'.$city.'</span>';
        $r.='<span class="stamp op" style="float:right;white-space:nowrap">';
            if ($this->my['user_id']==$user_id || $this->my['isadmin']>0) {
                $r.='<a href="javascript:void(0)" onclick="delmsg(\''.SITE_URL.'/Space/delmsg/cid/'.$data['content_id'].'\',\''.L('del_talk_confirm').'\',this.parentNode.parentNode.parentNode,\''.$delreurl.'\')">'.L('delete').'</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
            }
            if ($data['zftimes']>0) {
                $r.='<a href="javascript:void(0)" onclick="retwit(\''.$data['content_id'].'\')">'.L('contret').'('.$data['zftimes'].')</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
            } else {
                $r.='<a href="javascript:void(0)" onclick="retwit(\''.$data['content_id'].'\')">'.L('contret').'</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
            }

            if ($data['replytimes']>0) {
                $r.='<a href="javascript:void(0)" onclick="'.$pl.'">'.L('reply').'('.$data['replytimes'].')</a>';
            } else {
                $r.='<a href="javascript:void(0)" onclick="'.$pl.'">'.L('reply').'</a>';
            }
            if ($favbtn==1) {
                $r.='&nbsp;&nbsp;|&nbsp;<a class="fav" href="javascript:void(0)" onclick="dofavor(\''.$data['content_id'].'\')" title="'.L('addfavor').'">'.L('favor').'</a>';
            } else {
                $r.='&nbsp;&nbsp;|&nbsp;<a class="fav1" href="javascript:void(0)" onclick="delmsg(\''.SITE_URL.'/Space/delfavor/cid/'.$data['content_id'].'\',\''.L('del_favor_confirm').'\',this.parentNode.parentNode.parentNode)" title="'.L('del_favor').'">'.L('favor').'</a>';
            }
        $r.='</span>';
        $r.='<div class="clearline"></div>';
        $r.='<span id="reply_'.$data['content_id'].'" class="replyspan"></span></div>';
        $r.='</li>';
        return stripslashes($r);
    }

    //载入转播的内容
    function loadretwitt($data,$wap=0) {
        //转发的ids
        if (is_array($data)) {
            $retids=array();
            foreach ($data as $key=>$val) {
                if ($val['retid']>0) {
                    $retids[]=$val['retid'];
                }
            }
            $retids=array_unique($retids);
            $retid=implode(',',$retids);
        }
        //读取内容
        if ($retid) {
            $content = D('ContentView')->where("content_id IN ($retid)")->select();
            if (is_array($content)) {
                $retdata=array();
                foreach($content as $key=>$val) {
                    $retdata[$val['content_id']]=$val;
                }
            }
            foreach ($data as $key=>$val) {
                if ($retdata[$val['retid']]) {
                    $data[$key]['retbody']=$this->loadretbody($retdata[$val['retid']],$val['content_id'],$wap);
                } else {
                    $data[$key]['retbody']='<div class="retwitt"><span id="cont'.$val['content_id'].'" class="times">'.L('delete_content').'</span><div class="clearline"></div></div>';
                }
            }
        }
        return $data;
    }

    function loadretbody($data,$retid,$wap=0) {
        if ($wap==1) {
            return stripslashes('<div class="retwitt">
            <p><a href="'.SITE_URL.'/Wap/space/user_name/'.rawurlencode($data['user_name']).'" class="author '.setvip($data['user_auth']).'" '.viptitle($data['user_auth']).'>'.$data['nickname'].'</a><em>:</em><span id="cont'.$retid.'">'.$this->wapubb($data['content_body'].$data['media_body']).'</span></p>
            <p><span class="times">'.timeop($data['posttime']).' '.L('tfrom').$data['type'].'</span></p><div class="clearline"></div></div>');
        } else if ($wap==2) {//外部调用
            return stripslashes('<div class="retwitt">
            <p><a href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'" class="author '.setvip($data['user_auth']).'" '.viptitle($data['user_auth']).' target="_blank">'.$data['nickname'].'</a><em>:</em>'.$this->outubb($data['content_body'].$data['media_body']).'</p>
            <p><span class="times"><a href="'.SITE_URL.'/v/'.$data['content_id'].'" target="_blank">'.timeop($data['posttime']).'</a></span></p><div class="clearline"></div></div>');
        } else {
            return stripslashes('<div class="retwitt">
            <p><a href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'" class="author '.setvip($data['user_auth']).'" '.viptitle($data['user_auth']).'>'.$data['nickname'].'</a><em>:</em><span id="cont'.$retid.'">'.$this->ubb($data['content_body'].$data['media_body']).'</span></p>
            <p><span class="times"><a href="'.SITE_URL.'/v/'.$data['content_id'].'" title="'.gmdate(L('date').' H:i',$data['posttime']+8*3600).'">'.timeop($data['posttime']).'</a> '.L('tfrom').$data['type'].'</span><span class="tetime"><a href="'.SITE_URL.'/v/'.$data['content_id'].'/t">'.L('favor_yw').'('.$data['zftimes'].')</a>&nbsp;&nbsp;&nbsp;<a href="'.SITE_URL.'/v/'.$data['content_id'].'/r">'.L('reply_yw').'('.$data['replytimes'].')</a></span></p><div class="clearline"></div></div>');
        }
    }

    //载入评论
    function loadonereply($data,$wide=0) {
        if ($this->my && $this->my['user_id']!=$data['user_id']) {
            $rep="<a href='javascript:void(0)' class='fright' style='margin-left:5px' onclick=\"replyajaxin('{$data[replyid]}','{$data[nickname]}')\">".L('reply')."</a>";
        }
        if ($wide==0) {
            if ($this->my && ($this->my['user_id']==$data['user_id'] || $this->my['isadmin']>0)) {
                $rep.='<a href="javascript:void(0)" class="fright" onclick="delmsg(\''.SITE_URL.'/Space/delmsg/cid/'.$data['content_id'].'\',\''.L('del_talk_confirm').'\',this.parentNode.parentNode.parentNode.parentNode)">'.L('delete').'</a>';
            }
            return stripslashes('<li class="lire">
                <div class="images"><a href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'"><img src="'.sethead($data['user_head']).'" width="30px" height="30px" alt="'.$data['nickname'].'"></a></div>
                <div class="info">
                    <p><a class="username '.setvip($data['user_auth']).'" '.viptitle($data['user_auth']).' href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'">'.$data['nickname'].'</a>
                    <span class="setgray">'.timeop($data['posttime']).'&nbsp;&nbsp;'.L('tfrom').$data['type'].'&nbsp;'.$rep.'</span></p>
                    <p>'.$this->ubb($data['content_body']).'</p>
                </div>
            </li>');
        } else {
            if ($this->my && ($this->my['user_id']==$data['user_id'] || $this->my['isadmin']>0)) {
                $rep.='<a href="javascript:void(0)" class="fright" onclick="delmsg(\''.SITE_URL.'/Space/delmsg/cid/'.$data['content_id'].'\',\''.L('del_talk_confirm').'\',this.parentNode.parentNode)">'.L('delete').'</a>';
            }
            return stripslashes('<li class="unlight">
            <a href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'" class="avatar"><img src="'.sethead($data['user_head']).'" alt="'.$data['nickname'].'" /></a>
            <div class="content"><a href="'.SITE_URL.'/'.rawurlencode($data['user_name']).'" class="author">'.$data['nickname'].'</a><h5>'.L('reply').':</h5>'.$this->ubb($data['content_body']).'</div><span class="stamp" style="float:left">'.timeop($data['posttime']).'&nbsp;&nbsp;'.L('tfrom').$data['type'].'</span><span class="stamp op" style="float:right;white-space:nowrap">'.$rep.'</span><div class="clearline"></div></li>');
        }
    }

    function wapli($data,$mid,$from,$showspeaker,$showtool=1,$favor=0) {
        $delbtn=$speaker='';
        if ($data['user_id']==$mid) {
            $delbtn="&nbsp;&nbsp;<a href='".SITE_URL."/Wap/delmsg/cid/$data[content_id]/from/".base64_encode($from)."'>".L('delete')."</a>";
        }
        if ($showspeaker==1) {
            $speaker="<a href='".SITE_URL."/Wap/space/user_name/".rawurlencode($data['user_name'])."' class='".setvip($data['user_auth'])."' ".viptitle($data['user_auth']).">$data[nickname]</a> ";
        }
        //转播
        if ($data['retid']) {
            $r.='<h5>'.L('contret').':</h5>'.$this->wapubb($data['content_body'].$data['media_body'].$data['retbody']).'<div class="clearline"></div>';
        } else {
            $r.=$this->wapubb($data['content_body'].$data['media_body']);
        }
        //收藏
        if ($favor==0) {
            $f.="&nbsp;&nbsp;<a href='".SITE_URL."/Wap/favor/cid/$data[content_id]/from/".base64_encode($from)."'>".L('favor')."</a>".$delbtn;
        } else {
            $f.="&nbsp;&nbsp;<a href='".SITE_URL."/Wap/delfavor/cid/$data[content_id]/from/".base64_encode($from)."'>".L('delete')."</a>";
        }
        if ($showtool==1) {
            $tool="<a href='".SITE_URL."/Wap/ret/cid/$data[content_id]/from/".base64_encode($from)."'>".L('contret')."($data[zftimes])</a>&nbsp;&nbsp;<a href='".SITE_URL."/Wap/comment/cid/$data[content_id]/from/".base64_encode($from)."'>".L('reply')."($data[replytimes])</a>".$f;
        }
        return stripslashes("<li><div>{$speaker}{$r}</div><div class='stamp'>".timeop($data['posttime'])."&nbsp;".L('tfrom')."{$data[type]}&nbsp;{$tool}</div></li>");
    }

    //UBB代码及其他替换
    function ubb($text) {
        $p= array(
            '/\[AT (.*?)\](.*?)\[\/AT\]/ie',
            '/\[F l=(.*?)\](.*?)\[\/F\]/ie',
            '/\[V h=(.*?) p=(.*?)\](.*?)\[\/V\]/i',
            '/\[M\](.*?)\[\/M\]/i',
            '/\[U (.*?)\](.*?)\[\/U\]/ie',
            '/\[T\](.*?)\[\/T\]/ie',
        );
        $rand=randStr(6);
        $r=array(
            "ubbatrl('\\1','\\2',1)",
            "ubbpic('\\1','\\2','in')",
            "<div class='media'><img id='img_".$rand."' style='background:url($2) no-repeat;' src='".__PUBLIC__."/images/feedvideoplay.gif' alt='".L('click_play')."' onclick=\"showFlash('$1','$3',this,'".$rand."');\"/></div>",
            "<div class='music'><img id='img_".$rand."' src='".__PUBLIC__."/images/music.gif' alt='".L('click_play')."' onclick=\"javascript:showFlash('music','$1',this,'".$rand."');\"/></div>",
            "ubburl('\\1','\\2','".$this->site['shorturl']."')",
            "ubbtopicrl('\\1',1)",
        );
        $text=preg_replace($p,$r,$text);
        $text=emotionrp($text);
        return $text;
    }

    //外部UBB
    function outubb($text,$site) {
        $p= array(
            '/\[AT (.*?)\](.*?)\[\/AT\]/ie',
            '/\[F l=(.*?)\](.*?)\[\/F\]/ie',
            '/\[V h=(.*?) p=(.*?)\](.*?)\[\/V\]/i',
            '/\[M\](.*?)\[\/M\]/i',
            '/\[U (.*?)\](.*?)\[\/U\]/ie',
            '/\[T\](.*?)\[\/T\]/ie',
        );
        $rand=randStr(6);
        $r=array(
            "ubbatrl('\\1','\\2',2)",
            "ubbpic('\\1','\\2','out')",
            "<img src='$2' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"'/>",
            "<img src='".__PUBLIC__."/images/music.gif'/>",
            "ubburl('\\1','\\2','".$this->site['shorturl']."')",
            "ubbtopicrl('\\1',2)",
        );
        $text=preg_replace($p,$r,$text);
        $text=emotionrp($text);
        return $text;
    }
    function wapubb($text) {
        $p= array(
            '/\[AT (.*?)\](.*?)\[\/AT\]/ie',
            '/\[F l=(.*?)\](.*?)\[\/F\]/ie',
            '/\[V h=(.*?) p=(.*?)\](.*?)\[\/V\]/i',
            '/\[M\](.*?)\[\/M\]/i',
            '/\[U (.*?)\](.*?)\[\/U\]/ie',
            '/\[T\](.*?)\[\/T\]/ie',
        );
        $rand=randStr(6);
        $r=array(
            "ubbatrl('\\1','\\2',3)",
            "ubbpic('\\1','\\2','wap')",
            L('share_video'),
            L('share_music'),
            "ubburl('\\1','\\2','".$this->site['shorturl']."')",
            "ubbtopicrl('\\1',3)",
        );
        $text=preg_replace($p,$r,$text);
        $text=emotionrp($text);
        return $text;
    }

    //词语过滤
    function replace($content){
        $replace=$this->site['badwords'];
        $content=strip_tags($content);
        if ($content) {
            $content=clean_html($content);
            $bad = explode("|",$replace);
            @reset($bad);
            for ($i=0;$i<count($bad);$i++) {
                $content= str_replace($bad[$i],"**",$content);
            }
        }
        return $content;
    }

    private function transfer($int, &$a) {
        if($int>26){
            $a[] = $int%26;
            if(floor($int/26)>26){
                return $this->transfer(floor($int/26),$a);
            } else {
                return $a[] = floor($int/26);
            }
        }
        return $a[]=$int;
    }

    private function IntToABC($int) {
        $this->transfer($int, $w);
        $abc=array();
        $s = 1;
        for($i=97; $i<=122; $i++) {
            $abc[$s] = chr($i);
            $s++;
        }
        $result = '';
        for($i=0;$i<count($w); $i++) {
            $w[$i] = $w[$i]==0 ? 1 : $w[$i];
            $result = $abc[$w[$i]].$result;
        }
        return $result;
    }
}
?>