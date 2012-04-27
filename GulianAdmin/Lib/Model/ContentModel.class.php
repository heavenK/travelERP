<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename ContentModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class ContentModel extends BaseModel {
    public $my;

    //传递参数
    public function setmy($my) {
        $this->my = $my;
    }

    //更新at数目
    public function atreplace($content,$setinc=1) {
        $uModel=D('Users');
        if(strpos($content,'@')!==false) {
            if(preg_match_all('~\@([.-_\w\d\_\-\x7f-\xff]+)(?:[\r\n\t\s ]+|[\xa1\xa1]+)~',($content . ' '),$match)) {
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

    //写入广播
    public function sendmsg($content,$morecontent,$from='网页') {
        $content=daddslashes(getsubstr(trim($content),0,140,false));
        $morecontent=daddslashes(trim($morecontent));
        $uModel=D('Users');

        if (!empty($content)) {
            $content=$this->replace($content); //词语过滤
            $type=$morecontent?'photo':'';
            //@user
            $atreplace=$this->atreplace($content);
            $content=$atreplace['content'];
            //topic
            if (strpos($content,'#')!==false) {
                if (preg_match_all('~\#([^\#]+?)\#~',$content,$match)) {
                    $tm=D('Topic');
                    foreach ($match[1] as $v) {
                        $v = trim($v);
                        $vl = StrLenW($v);
                        if($vl>=1 && $vl<15) {
                            $tags[$v] = $v;
                            $cont_sch[] = "#{$v}#";
                            $cont_rpl[] = "[T]{$v}[/T]";
                            //update topic
                            $topic=$tm->where("topicname='$v'")->find();
                            if (!$topic) {
                                $tpinsert['topicname']=$v;
                                $tpinsert['topictimes']=1;
                                $tm->add($tpinsert);
                            } else {
                                $tm->setInc('topictimes',"topicname='$v'");
                            }
                        }
                    }
                }
            }
            //short url
            if (strpos($content,'://')!==false) {
                if (preg_match_all('~(?:https?\:\/\/)(?:[A-Za-z0-9\_\-]+\.)+[A-Za-z0-9]{2,4}(?:\/[\w\d\/=\?%\-\&_\~\`\@\[\]\:\+\#\.]*(?:[^\<\>\'\"\n\r\t\s\x7f-\xff])*)?~',$content,$match)) {
                    foreach ($match[0] as $v) {
                        $v = trim($v);
                        if(($vl=strlen($v)) < 8 || $vl > 200) {
                            continue ;
                        }
                        $key=$this->IntToABC(time());
                        $url['key']=$key;
                        $url['url']=$v;
                        D('Url')->add($url);
                        $cont_sch[] = "{$v}";
                        $cont_rpl[] = "[U {$key}]{$v}[/U]";
                    }
                }
            }
            //share
            preg_match_all('~(?:https?\:\/\/)(?:[A-Za-z0-9_\-]+\.)+[A-Za-z0-9]{2,4}(?:\/[\w\d\/=\?%\-\&_\~`@\[\]\:\+\#\.]*(?:[^<>\'\"\n\r\t\s])*)?~',$content,$match1);
            if(!empty($match1[0])) {
                $stringlink = implode(glue,$match1[0]);
                if($stringlink != $is_post_url) {
                    $vidoLink = parse_url($stringlink);
                    $vido_host = get_host($vidoLink['host']);
                    $ReturnMusic = preg_match("/\.(mp3|wma)$/i", $stringlink);
                    $ReturnHost = preg_match("/(youku\.com|ku6\.com|sohu\.com|mofile\.com|sina\.com\.cn|tudou\.com)$/i", $vido_host);
                    if($ReturnHost == 1) {
                        if('youku.com' == $vido_host){
                            preg_match_all("/id\_(\w+)[=.]/", $stringlink,$matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $youku = dfopen($stringlink);
                            preg_match("/<title>(.*?) - (.*)<\/title>/",$youku,$title);
                            preg_match_all("/<li class=\"download\"(.*)<\/li>/",$youku,$match2);
                            preg_match("/\|(http\:\/\/g\d\.ykimg\.com\/[^\|]+)\|/",$match2[1][0],$imageurl);
                            $returnImage = $imageurl[1];
                            $returnTitle = $title[1];
                        } elseif('tudou.com' == $vido_host) {
                            preg_match_all("/\/([\w\-]+)\/"."*$/", $stringlink, $matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $tudou = dfopen($stringlink);
                            $tudou = iconv('gbk','UTF-8',$tudou);
                            preg_match("/\<title\>(.+?)\<\/title\>/",$tudou,$title);
                            preg_match_all("/<span class=\"s_pic\">(.*?)<\/span>/",$tudou,$imageurl);
                            $returnImage = $imageurl[1][0];
                            $returnTitle = $title[1];
                        } elseif('ku6.com' == $vido_host) {
                            preg_match_all("/\/([\w\-]+)\.html/", $stringlink,$matches);
                            if(1 > preg_match("/\/index_([\w\-]+)\.html/", $stringlink) && !empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $ku6 = dfopen($stringlink);
                            $ku6 = iconv('gbk','UTF-8',$ku6);
                            preg_match("/<title>(.*?) - (.*)<\/title>/",$ku6,$title);
                            preg_match_all("/<span class=\"s_pic\">(.*)<\/span>/",$ku6,$imageurl);
                            $returnTitle = $title[1];
                            $returnImage = $imageurl[1][0];
                        } elseif('mofile.com' == $vido_host){
                            preg_match_all("/\/([\w\-]+)\.shtml/", $stringlink, $matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $mofile = dfopen($stringlink);
                            preg_match("/<TITLE>(.*?) - (.*)<\/TITLE>/",$mofile,$title);
                            preg_match_all("/thumbpath=\"(.*?)\";/i",$mofile,$imageurl);
                            $returnTitle = $title[2];
                            $returnImage = $imageurl[1][0];
                        } elseif('sina.com.cn' == $vido_host) {
                            preg_match_all("/\/(\d+)\-(\d+)\.html/i", $stringlink, $matches);
                            if(empty($matches[1][0])){
                                preg_match_all("/\/(\d+)\.html/i", $stringlink, $matches);
                            }
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $sina = dfopen($stringlink);
                            preg_match("/\<title\>(.+?)\<\/title\>/",$sina,$title);
                            preg_match_all("/pic: \'(.*?)\',/i",$sina,$imageurl);
                            $returnTitle = $title[1];
                            $returnImage = $imageurl[1][0];
                        } elseif('sohu.com' == $vido_host) {
                            preg_match_all("/\/(\d+)\/"."*$/", $stringlink, $matches);
                            if(!empty($matches[1][0])) {
                                $returnlink = $matches[1][0];
                            }
                            $sohu = dfopen($stringlink);
                            $sohu = iconv('gbk','UTF-8',$sohu);
                            preg_match("/<title>(.*?) - (.*)<\/title>/",$sohu,$title);
                            $returnTitle = $title[1];
                        }
                        $returnImage=$returnImage?$returnImage:__PUBLIC__.'/images/video.gif';
                        $content .= '<p>'.$returnTitle.'</p>';
                        $share="[V h={$vido_host} p={$returnImage}]{$returnlink}[/V]";
                        $type='video';
                    } else if($ReturnMusic == 1) {
                        $share="[M]{$stringlink}[/M]";
                        $type='music';
                    }
                }
            }
            $morecontent.=$share;
            if ($cont_sch && $cont_rpl) {
                $content = str_replace($cont_sch,$cont_rpl,$content);
		    }
            $insert['user_id']=$this->my['user_id'];
            $insert['content_body']=$content;
            $insert['media_body']=$morecontent;
            $insert['type']=$from;
            $insert['filetype']=$type;
            $insert['posttime']=time();
            $insertid=$this->add($insert);
            $uModel->where("user_id='".$this->my['user_id']."'")->setField(array('msg_num','lastcontent','lastconttime'),array(array('exp','msg_num+1'),$content,time()));
            //add content_mention
            $uids=$atreplace['uids'];
            if ($uids) {
                $cm=D('Content_mention');
                foreach($uids as $val) {
                    $cmdata['cid']=$insertid;
                    $cmdata['user_id']=$val;
                    $cmdata['dateline']=time();
                    $cm->add($cmdata);
                }
            }
            $ret=array('ret'=>'success','insertid'=>$insertid);
            return json_encode($ret);
        } else {
            $ret=array('ret'=>'error','insertid'=>0);
            return json_encode($ret);
        }
    }
    //转播
    public function retwit($cid,$retwit,$type='网页') {
        $retwit=daddslashes($this->replace(trim($retwit),0,140,true));
        if ($cid) {
            $data = $this->where("content_id='$cid'")->find();
            if($data) {
                $cid=$data['retid']?$data['retid']:$cid;
                $dt=$this->atreplace($retwit);
                $retwit=$dt['content'];
                $insert['user_id']=$this->my['user_id'];
                $insert['content_body']=$retwit;
                $insert['posttime']=time();
                $insert['retid']=$cid;
                $insert['type']=$type;
                $insertid=$this->add($insert);
                //add content_mention
                $uids=$dt['uids'];
                if ($uids) {
                    $cm=D('Content_mention');
                    foreach($uids as $val) {
                        $cmdata['cid']=$insertid;
                        $cmdata['user_id']=$val;
                        $cmdata['dateline']=time();
                        $cm->add($cmdata);
                    }
                }
                $this->setInc('zftimes',"content_id='$cid'");
                D('Users')->updatemsgnum($this->my['user_id'],'++');
                $ret=array('ret'=>'success','insertid'=>$insertid,'retid'=>$cid);
                return json_encode($ret);
            } else {
                $ret=array('ret'=>'error','insertid'=>0,'retid'=>0);
                return json_encode($ret);
            }
        } else {
            $ret=array('ret'=>'error','insertid'=>0,'retid'=>0);
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
                    //消息数更新
                    if ($data['replyid']) {
                        $this->setDec('replytimes',"content_id='$data[replyid]'");
                    } else {
                        if ($data['retid']) {
                            $this->setDec('zftimes',"content_id='$data[retid]'");
                        }
                        D('Users')->updatemsgnum($data['user_id'],'--');
                    }
                }
                //删除mention
                D('Content_mention')->where("cid='$contentid'")->delete();
                return 'success';
            } else {
                return '删除失败，可能此广播不存在！';
            }
        } else {
            return '删除失败，可能此广播不存在！';
        }
    }
    //评论
    public function doreply($content,$sid,$isret,$type='网页') {
        $cm=D('Comments');
        $uModel=D('Users');

        $content=daddslashes($this->replace(getsubstr(trim($content),0,140,true)));
        if ($sid && $content) {
            $data = $this->where("content_id='$sid'")->find();
            if($data) {
                $dt=$this->atreplace($content,0);
                $content=$dt['content'];
                $insert['user_id']=$this->my['user_id'];
                $insert['content_body']=$content;
                $insert['posttime']=time();
                $insert['replyid']=$sid;
                $insert['type']=$type;
                $insertid=$this->add($insert);
                $this->setInc('replytimes',"content_id='$sid'");
                if ($isret==1) { //转发
                    $this->retwit($sid,$content,$type);
                }
                //tip
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
                $ret=array('ret'=>'数据传输错误！','insertid'=>0);
                return json_encode($ret);
            }
        } else {
            $ret=array('ret'=>'您还没有填写要广播的内容！','insertid'=>0);
            return json_encode($ret);
        }
    }
    //上传图片
    public function uploadpic() {
        import("@.ORG.UploadFile");
        $upload = new UploadFile();
        $upload->maxSize  = 2097152 ;
        $upload->allowExts  = explode(',','jpg,gif,png,jpeg');
        $upload->savePath =  './Public/attachments/photo/';
        $upload->thumb =  true;
        $upload->thumbPrefix   =  'm_,s_';
        $upload->thumbMaxWidth =  '1024,120';
        $upload->thumbMaxHeight = '1024,120';
        $upload->subType = 'date';
        $upload->autoSub = true;
        $upload->saveRule = time;
        $upload->thumbRemoveOrigin = true;
        $uploadurl=__PUBLIC__.'/attachments/photo/'.date('Ymd').'/';
        if($upload->upload()) {
            $uploadList = $upload->getUploadFileInfo();
            if ($this->site['wateropen']==1) { //水印
                import("@.ORG.Image");
                Image::water($uploadList[0]['savepath'].date('Ymd').'/m_'.$uploadList[0]['savename'],9,'',SITE_URL.'/'.$this->my['user_name']);
            }
            $content="[F l=".$uploadurl.'m_'.$uploadList[0]['savename']."]".$uploadurl.'s_'.$uploadList[0]['savename']."[/F]";
            $ret=array('ret'=>'success','img'=>$uploadurl.'s_'.$uploadList[0]['savename'],'name'=>$uploadList[0]['savename'],'content'=>$content);
            return json_encode($ret);
        } else {
            $ret=array('ret'=>'照片上传失败！','img'=>'','name'=>'','content'=>'');
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
            $delreurl=SITE_URL."/".$this->my['user_name'];
            $class='greybox';
            $avatarclass=' greyavatar';
        }
        //宽版还是窄版
        if ($wide==0) {
            $r.='<li class="unlight"><a href="'.SITE_URL.'/'.$user_name.'" title="'.$nickname.'" class="avatar'.$avatarclass.'"><img src="'.$user_head.'" alt="'.$nickname.'" /></a><div class="'.$class.'"><div class="content">';
        } else {
            $r.='<li class="unlight"><div class="'.$class.'"><div class="contentl">';
        }
        //转播
        if ($data['retid']) {
            if ($view==1) { //不显示转播内容
                $r.='<a href="'.SITE_URL.'/'.$user_name.'" class="author '.setvip($user_auth).'" title="'.$user_name.'">'.$nickname.'</a><h5>转播:</h5><span id="ret'.$data['content_id'].'">'.$content.'</span></div>';
            } else {
                $r.='<a href="'.SITE_URL.'/'.$user_name.'" class="author '.setvip($user_auth).'" title="'.$user_name.'">'.$nickname.'</a><h5>转播:</h5><span id="ret'.$data['content_id'].'">'.$content.'</span>'.$data['retbody'].'</div>';
            }
        } else {
            $r.='<a href="'.SITE_URL.'/'.$user_name.'" class="author '.setvip($user_auth).'">'.$nickname.'</a><h6>:</h6><span id="cont'.$data['content_id'].'">'.$content.'</span></div>';
        }
        $r.='<span class="stamp fleft"><a href="'.SITE_URL.'/v/'.$data['content_id'].'" class="ctime" title="'.gmdate('Y年m月d日 H:i',$data['posttime']+8*3600).'">'.timeop($data['posttime']).'</a>&nbsp;通过'.$data['type'].'&nbsp;&nbsp;'.$city.'</span>';
        $r.='<span class="stamp op" style="float:right;white-space:nowrap">';
            if ($this->my['user_id']==$user_id || $this->my['isadmin']>0) {
                $r.='<a href="javascript:void(0)" onclick="delmsg(\''.SITE_URL.'/Space/delmsg/cid/'.$data['content_id'].'\',\'确实要删除此条广播吗?\',this.parentNode.parentNode.parentNode,\''.$delreurl.'\')">删除</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
            }
            if ($data['zftimes']>0) {
                $r.='<a href="javascript:void(0)" onclick="retwit(\''.$data['content_id'].'\')">转播('.$data['zftimes'].')</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
            } else {
                $r.='<a href="javascript:void(0)" onclick="retwit(\''.$data['content_id'].'\')">转播</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
            }

            if ($data['replytimes']>0) {
                $r.='<a href="javascript:void(0)" onclick="'.$pl.'">评论('.$data['replytimes'].')</a>';
            } else {
                $r.='<a href="javascript:void(0)" onclick="'.$pl.'">评论</a>';
            }
            if ($favbtn==1) {
                $r.='&nbsp;&nbsp;|&nbsp;<a class="fav" href="javascript:void(0)" onclick="dofavor(\''.$data['content_id'].'\')" title="添加到我的收藏">收藏</a>';
            } else {
                $r.='&nbsp;&nbsp;|&nbsp;<a class="fav1" href="javascript:void(0)" onclick="delmsg(\''.SITE_URL.'/Space/delfavor/cid/'.$data['content_id'].'\',\'确实要删除此条收藏吗?\',this.parentNode.parentNode.parentNode)" title="删除收藏">收藏</a>';
            }
        $r.='</span>';
        $r.='<div class="clearline"></div>';
        $r.='<span id="reply_'.$data['content_id'].'" class="replyspan"></span></div>';
        $r.='</li>';
        return $r;
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
                    $data[$key]['retbody']='<div class="retwitt"><span id="cont'.$val['content_id'].'" class="times">原文内容已被删除</span><div class="clearline"></div></div>';
                }
            }
        }
        return $data;
    }
    function loadretbody($data,$retid,$wap=0) {
        if ($wap==1) {
            return '<div class="retwitt">
            <p><a href="'.SITE_URL.'/Wap/space/user_name/'.$data['user_name'].'" class="'.setvip($data['user_auth']).'">'.$data['nickname'].'</a><em>:</em><span id="cont'.$retid.'">'.$this->wapubb($data['content_body'].$data['media_body']).'</span></p>
            <p><span class="times">'.timeop($data['posttime']).' '.'通过'.$data['type'].'</span></p><div class="clearline"></div></div>';
        } else if ($wap==2) {//外部调用
            return '<div class="retwitt">
            <p><a href="'.SITE_URL.'/'.$data['user_name'].'" class="'.setvip($data['user_auth']).'" target="_blank">'.$data['nickname'].'</a><em>:</em>'.$this->outubb($data['content_body'].$data['media_body']).'</p>
            <p><span class="times"><a href="'.SITE_URL.'/v/'.$data['content_id'].'" target="_blank">'.timeop($data['posttime']).'</a></span></p><div class="clearline"></div></div>';
        } else {
            return '<div class="retwitt">
            <p><a href="'.SITE_URL.'/'.$data['user_name'].'" class="'.setvip($data['user_auth']).'">'.$data['nickname'].'</a><em>:</em><span id="cont'.$retid.'">'.$this->ubb($data['content_body'].$data['media_body']).'</span></p>
            <p><span class="times"><a href="'.SITE_URL.'/v/'.$data['content_id'].'" title="'.gmdate('Y年m月d日 H:i',$data['posttime']+8*3600).'">'.timeop($data['posttime']).'</a> '.'通过'.$data['type'].'</span><span class="tetime"><a href="'.SITE_URL.'/v/'.$data['content_id'].'/t">原文转播('.$data['zftimes'].')</a>&nbsp;&nbsp;&nbsp;<a href="'.SITE_URL.'/v/'.$data['content_id'].'/r">原文评论('.$data['replytimes'].')</a></span></p><div class="clearline"></div></div>';
        }
    }

    //载入评论
    function loadonereply($data,$wide=0) {
        if ($this->my && $this->my['user_id']!=$data['user_id']) {
            $rep="<a href='javascript:void(0)' class='fright' style='margin-left:5px' onclick=\"replyajaxin('{$data[replyid]}','{$data[user_name]}')\">评论</a>";
        }
        if ($wide==0) {
            if ($this->my && ($this->my['user_id']==$data['user_id'] || $this->my['isadmin']>0)) {
                $rep.='<a href="javascript:void(0)" class="fright" onclick="delmsg(\''.SITE_URL.'/Space/delmsg/cid/'.$data['content_id'].'\',\'确实要删除此条广播吗?\',this.parentNode.parentNode.parentNode.parentNode)">删除</a>';
            }
            return '<li class="lire">
                <div class="images"><a href="'.SITE_URL.'/'.$data['user_name'].'"><img src="'.sethead($data['user_head']).'" width="30px"></a></div>
                <div class="info">
                    <p><a class="username '.setvip($data['user_auth']).'" href="'.SITE_URL.'/'.$data['user_name'].'">'.$data['nickname'].'</a>
                    <span class="setgray">'.timeop($data['posttime']).'&nbsp;&nbsp;通过'.$data['type'].'&nbsp;'.$rep.'</span></p>
                    <p>'.$this->ubb($data['content_body']).'</p>
                </div>
            </li>';
        } else {
            if ($this->my && ($this->my['user_id']==$data['user_id'] || $this->my['isadmin']>0)) {
                $rep.='<a href="javascript:void(0)" class="fright" onclick="delmsg(\''.SITE_URL.'/Space/delmsg/cid/'.$data['content_id'].'\',\'确实要删除此条广播吗?\',this.parentNode.parentNode)">删除</a>';
            }
            return '<li class="unlight">
            <a href="'.SITE_URL.'/'.$data['user_name'].'" title="'.$data['nickname'].'" class="avatar"><img src="'.sethead($data['user_head']).'" alt="'.$data['nickname'].'" /></a>
            <div class="content"><a href="'.SITE_URL.'/'.$data['user_name'].'" class="author">'.$data['nickname'].'</a><h5>评论:</h5>'.$this->ubb($data['content_body']).'</div><span class="stamp" style="float:left">'.timeop($data['posttime']).'&nbsp;&nbsp;通过'.$data['type'].'</span><span class="stamp op" style="float:right;white-space:nowrap">'.$rep.'</span><div class="clearline"></div></li>';
        }
    }

    function wapli($data,$mid,$from,$showspeaker,$showtool=1,$favor=0) {
        $delbtn=$speaker='';
        if ($data['user_id']==$mid) {
            $delbtn="&nbsp;&nbsp;<a href='".SITE_URL."/Wap/delmsg/cid/$data[content_id]/from/".base64_encode($from)."'>删除</a>";
        }
        if ($showspeaker==1) {
            $speaker="<a href='".SITE_URL."/Wap/space/user_name/{$data[user_name]}' class='".setvip($data['user_auth'])."'>$data[nickname]</a> ";
        }
        //转播
        if ($data['retid']) {
            $r.='<h5>转播:</h5>'.$this->wapubb($data['content_body'].$data['media_body'].$data['retbody']).'<div class="clearline"></div>';
        } else {
            $r.=$this->wapubb($data['content_body'].$data['media_body']);
        }
        //收藏
        if ($favor==0) {
            $f.="&nbsp;&nbsp;<a href='".SITE_URL."/Wap/favor/cid/$data[content_id]/from/".base64_encode($from)."'>收藏</a>".$delbtn;
        } else {
            $f.="&nbsp;&nbsp;<a href='".SITE_URL."/Wap/delfavor/cid/$data[content_id]/from/".base64_encode($from)."'>删除</a>";
        }
        if ($showtool==1) {
            $tool="<a href='".SITE_URL."/Wap/ret/cid/$data[content_id]/from/".base64_encode($from)."'>转播($data[zftimes])</a>&nbsp;&nbsp;<a href='".SITE_URL."/Wap/comment/cid/$data[content_id]/from/".base64_encode($from)."'>评论($data[replytimes])</a>".$f;
        }
        return "<li><div>{$speaker}{$r}</div><div class='stamp'>".timeop($data['posttime'])."&nbsp;通过{$data[type]}&nbsp;{$tool}</div></li>";
    }

    //UBB代码及其他替换
    function ubb($text,$site) {
        $shorturl=$this->site['shorturlopen']==1?$this->site['shorturl'].'/':SITE_URL.'/?u=';

        $p= array(
            '/\[AT (.*?)\](.*?)\[\/AT\]/i',
            '/\[F l=(.*?)\](.*?)\[\/F\]/i',
            '/\[V h=(.*?) p=(.*?)\](.*?)\[\/V\]/i',
            '/\[M\](.*?)\[\/M\]/i',
            '/\[U (.*?)\](.*?)\[\/U\]/i',
            '/\[T\](.*?)\[\/T\]/i',
        );
        $rand=randStr(6);
        $r=array(
            "<a href='".SITE_URL."/$1'>$2</a>",
            "<div class='imageshow'><a class='miniImg artZoom' href='javascript:void(0)'><img src='$2'></a>
            <div class='artZoomBox'>
            <div class='tool'><a title='收起' href='javascript:void(0)' class='hideImg'>收起</a><a title='向右转' href='javascript:void(0)' class='imgRight'>向右转</a><a title='向左转' href='javascript:void(0)' class='imgLeft'>向左转</a><a title='查看原图' href='$1' class='viewImg' target='_blank'>查看原图</a></div>
            <div class='clearline'></div>
            <a class='maxImgLink' href='javascript:void(0)'><img src='$1' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"' class='maxImg'></a>
            </div>
            </div>",
            "<div class='media'><img id='img_".$rand."' style='background:url($2) no-repeat;' src='".__PUBLIC__."/images/feedvideoplay.gif' alt='点击播放' onclick=\"showFlash('$1','$3',this,'".$rand."');\"/></div>",
            "<div class='music'><img id='img_".$rand."' src='".__PUBLIC__."/images/music.gif' alt='点击播放' onclick=\"javascript:showFlash('music','$1',this,'".$rand."');\"/></div>",
            "<a href='".$shorturl."$1' target='_blank' title='$2'>".$shorturl."$1</a>",
            "<a href='".SITE_URL."/k/$1'>#$1#</a>",
        );
        $text=preg_replace($p,$r,$text);
        $text=emotionrp($text);
        return $text;
    }
    //外部UBB
    function outubb($text,$site) {
        $shorturl=$this->site['shorturlopen']==1?$this->site['shorturl'].'/':SITE_URL.'/?u=';

        $p= array(
            '/\[AT (.*?)\](.*?)\[\/AT\]/i',
            '/\[F l=(.*?)\](.*?)\[\/F\]/i',
            '/\[V h=(.*?) p=(.*?)\](.*?)\[\/V\]/i',
            '/\[M\](.*?)\[\/M\]/i',
            '/\[U (.*?)\](.*?)\[\/U\]/i',
            '/\[T\](.*?)\[\/T\]/i',
        );
        $rand=randStr(6);
        $r=array(
            "<a href='".SITE_URL."/$1' target='_blank'>$2</a>",
            "<p><a title='查看原图' href='$1' target='_blank'><img src='$2' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"'></a></p>",
            "<img src='$2' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"'/>",
            "<img src='".__PUBLIC__."/images/music.gif'/>",
            "<a href='".$shorturl."$1' target='_blank' title='$2'>".$shorturl."$1</a>",
            "<a href='".SITE_URL."/k/$1' target='_blank'>#$1#</a>",
        );
        $text=preg_replace($p,$r,$text);
        $text=emotionrp($text);
        return $text;
    }
    function wapubb($text) {
        $shorturl=$this->site['shorturlopen']==1?$this->site['shorturl'].'/':SITE_URL.'/?u=';
        $p= array(
            '/\[AT (.*?)\](.*?)\[\/AT\]/i',
            '/\[F l=(.*?)\](.*?)\[\/F\]/i',
            '/\[V h=(.*?) p=(.*?)\](.*?)\[\/V\]/i',
            '/\[M\](.*?)\[\/M\]/i',
            '/\[U (.*?)\](.*?)\[\/U\]/i',
            '/\[T\](.*?)\[\/T\]/i',
        );
        $rand=randStr(6);
        $r=array(
            "<a href='".SITE_URL."/Wap/space/user_name/$1'>$2</a>",
            "<p><a href='$1' target='_blank'><img src='$2' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"' class='photo'></a></p>",
            "分享了视频",
            "分享了音乐",
            "<a href='".$shorturl."$1' target='_blank' title='$2'>".$shorturl."$1</a>",
            "<a href='".SITE_URL."/k/$1'>#$1#</a>",
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
            if($content=="") {
                $content="HTML代码已过滤";
            }
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