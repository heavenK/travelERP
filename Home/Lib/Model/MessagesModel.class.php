<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename MessagesModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class MessagesModel extends BaseModel {

    //删除信件
    public function delmsg($messgeid,$uid) {
        if ($messgeid) {
            $data = $this->where("(senduid ='$uid' OR sendtouid ='$uid') AND message_id='$messgeid'")->find();
            if ($data) {
                $this->where("(senduid ='$uid' OR sendtouid ='$uid') AND message_id='$messgeid'")->delete();
                return 'success';
            } else {
                return L('del_msg_error');
            }
        } else {
            return '';
        }
    }

    //发送信件
    public function sendmsg($message,$nickname,$mid) {
        $uModel=D('Users');
        $message=daddslashes(trim($message));
        if (D('Content')->typenums($message)>140) {
            return L('talklong');
        }
        $user=$uModel->getUser("nickname='$nickname'");
        if (!$message) {
            return L('send_msg_null');
        }
        //黑名单
        $isblack=D('Blacklist')->where("user_id='$user[user_id]' AND black_uid='$mid'")->find();
        if ($isblack) {
            return L('blackuser');
        }
        //short url
        if (strpos($message,'://')!==false) {
            if (preg_match_all('~(?:https?\:\/\/)(?:[A-Za-z0-9\_\-]+\.)+[A-Za-z0-9\:]{2,10}(?:\/[\w\d\/=\?%\-\&_\~\`\@\[\]\:\+\#\.]*(?:[^\<\>\'\"\n\r\t\s\x7f-\xff])*)?~',$message,$match)) {
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
        if (strpos($message,'#')!==false) {
            if (preg_match_all('~\#([^\#]+?)\#~',$message,$match)) {
                $tm=D('Topic');
                foreach ($match[1] as $v) {
                    $v = trim($v);
                    $vl = StrLenW($v);
                    if($vl>=1 && $vl<15) {
                        $tags[$v] = $v;
                        $cont_sch[] = "#{$v}#";
                        $cont_rpl[] = "[T]{$v}[/T]";
                        $topics[]=$v;
                    }
                }
            }
        }
        if ($cont_sch && $cont_rpl) {
            $message = str_replace($cont_sch,$cont_rpl,$message);
        }
        if (!$user['user_id']) {
            return L('no_send_user');
        } else {
            if ($user['user_id'] && $message && is_numeric($mid)) {
                $isfollow=D('Friend')->followstatus($user['user_id'],$mid);
                if ($isfollow[$user['user_id']]==2 || $isfollow[$user['user_id']]==3 || $mid==0 || $mid==ADMIN_UID) {
                    $uModel->setInc('priread',"user_id='$user[user_id]'"); //提示
                    $insert['senduid']=$mid;
                    $insert['sendtouid']=$user['user_id'];
                    $insert['messagebody']=$message;
                    $insert['sendtime']=time();
                    $this->add($insert);

                    $plugin= new pluginManager();//初始化插件函数
                    $plugin->do_action('sendmsg');

                    return 'success';
                } else {
                    return L('isnot_follow');
                }
            } else {
                return L('data_error');
            }
        }
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