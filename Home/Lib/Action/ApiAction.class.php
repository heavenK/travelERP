<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename ApiAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class ApiAction extends Action {

    public function userpreview() {
        $nickname=$_POST['nickname'];

        if ($nickname) {
            parent::init();
            $user = D('Users')->where("nickname='$nickname'")->find();
            if ($user) {
                if ($user['user_gender']=='男') {
                    $g='<img src="'.__PUBLIC__.'/images/gg.gif" width="12px">&nbsp;';
                } else if ($user['user_gender']=='女') {
                    $g='<img src="'.__PUBLIC__.'/images/mm.gif" width="12px">&nbsp;';
                } else {
                    $g='';
                }
                $isfriend=D('Friend')->followstatus($user['user_id'],$this->my['user_id']);
                $f="<span id='followsp2_".$user['user_id']."'>";
                    if($isfriend[$user['user_id']]==1){
                        $f.="<span class='followbtn'><img src='".__PUBLIC__."/images/fico2.gif'> ".L('already_follow')."&nbsp;|&nbsp;<a href='javascript:void(0)' onclick=\"followop('delfollow/user_name/".rawurlencode($user['user_name'])."','".L('cancel_follow')." {$user[nickname]} ".L('ma')."','jc','".rawurlencode($user['user_name'])."','{$user[nickname]}','{$user[user_id]}','".$isfriend[$user['user_id']]."')\">".L('cancel')."</a></span>";
                    }else if ($isfriend[$user[user_id]]==3){
                        $f.="<span class='followbtn'><img src='".__PUBLIC__."/images/fico.gif'> ".L('follow_followed')."&nbsp;|&nbsp;<a href='javascript:void(0)' onclick=\"followop('delfollow/user_name/".rawurlencode($user['user_name'])."','".L('cancel_follow')." {$user[nickname]} ".L('ma')."','jc','".rawurlencode($user['user_name'])."','{$user[nickname]}','{$user[user_id]}','".$isfriend[$user['user_id']]."')\">".L('cancel')."</a></span>";
                    }else{
                        $f.="<a class='bh' onclick=\"followop('addfollow/user_name/".rawurlencode($user['user_name'])."','','gz','".rawurlencode($user['user_name'])."','{$user[nickname]}','{$user[user_id]}','".$isfriend[$user['user_id']]."')\">".L('have_a_follow')."</a>";
                    }
                $f.="</span>";
                if ($user['user_id']==$this->my['user_id']) {
                    $body2='';
                } else {
                    $body2='<div class="fleft"><input value="'.L('send_message').'" onclick="sendprimsgbox(\''.$user['nickname'].'\')" class="button5">&nbsp;&nbsp;&nbsp;<input value="@'.L('caps_ta').'" onclick="atbox(\''.$user['nickname'].'\',\''.$user['user_id'].'\')" class="button5"></div><div class="fright">'.$f.'</div>';
                }
                if(time()-$user[last_login]<=600){
                    if($user['isadmin']>0){
                        $zxico='<span class="adminico"> '.L('user_online').'</span>';
                    } else {
                        $zxico='<span class="uonlineico"> '.L('user_online').'</span>';
                    }
                } else {
                    $zxico='<span class="uofflineico"> '.L('user_offline').'</span>';
                }
                echo '<div class="body1">
                    <div class="limg"><a href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'" target="_blank"><img src="'.sethead($user['user_head']).'" width="50px" height="50px"></a></div>
                    <div class="linfo">
                        <p>
                        <div class="fleft">
                            <span class="'.setvip($user['user_auth']).'" '.viptitle($user['user_auth']).'><a href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'" target="_blank">'.$user['nickname'].'</a></span>
                        </div>
                        <div class="fright" style="width:90px;font-size:12px">'.$zxico.'</div>
                        <div class="clearline"></div>
                        </p>
                        <p>'.$g.$user['live_city'].'</p>
                        <p>'.L('follow').'<a href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'/following" target="_blank">'.$user['follow_num'].'</a>&nbsp;&nbsp;'.L('follower').'<a href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'/follower" target="_blank">'.$user['followme_num'].'</a>&nbsp;&nbsp;'.L('talk').'<a href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'" target="_blank">'.$user['msg_num'].'</a></p>
                    </div>
                    <div class="clearline"></div>
                    <div class="linfo2">'.L('user_info').'：'.getsubstr($user['user_info']?$user['user_info']:L('nothing_write'),0,35).'</div>
                </div>
                <div class="body2">'.$body2.'</div>';
            } else {
                echo '<div style="height:160px"><br/><br/><br/><center>'.L('loading_error').'</center></div>';
            }
        } else {
            echo '<div style="height:160px"><br/><br/><br/><center>'.L('loading_error').'</center></div>';
        }
    }

    public function getcity() {
        $this->tologin();
        $pid=intval($_GET['pid']);
        $dModel=D('District');

        if ($pid) {
            $districts = $dModel->where("upid='$pid'")->select();
            foreach ($districts as $val) {
                $data.='<option value="'.$val['name'].'">'.$val['name'].'</option>';
            }
            if ($data) {
                $tip=array('ret'=>'success','data'=>$data);
            } else {
                $tip=array('ret'=>'error','data'=>'');
            }
        } else {
            $ct=explode(' ',$this->my['live_city']);
            $tip=array('ret'=>'error','data'=>'');
        }
        echo json_encode($tip);
    }

    public function autoloadtip() {
        $hometipid=intval($_GET['hometipid']);

        if ($hometipid>0) {
            $fuids=array();
            $_fuids=D('Users')->friends($this->my['user_id']);
            if ($_fuids) {
                foreach($_fuids as $val){
                    $fuids[]=$val['fid_jieshou'];
                }
            }
            $fuids[]=$this->my['user_id'];
            $fuids2=implode(',',$fuids);
            $count = D('Content')->where("user_id IN ($fuids2) AND replyid=0 AND content_id>'$hometipid'")->count();
        } else {
            $count=0;
        }

        $tip=array('ret'=>'success','priread'=>$this->my['priread'],'comments'=>$this->my['comments'],'newfollownum'=>$this->my['newfollownum'],'atnum'=>$this->my['atnum'],'tipcount'=>$count);

        echo json_encode($tip);
    }

    public function loadnewmsg() {
        parent::init();
        $hometipid=intval($_GET['hometipid']);
        $ctent=D('Content');

        if ($hometipid>0) {
            $data = D('FollowContentView')->where("(fid_fasong='".$this->my['user_id']."' OR Users.user_id='".$this->my['user_id']."') AND replyid=0 AND content_id>'$hometipid'")->group('content_id')->order("posttime DESC")->select();
            $data=$ctent->loadretwitt($data);

            foreach ($data as $val) {
                $content.=$ctent->loadoneli($val);
            }

            echo json_encode(array("ret"=>"success","data"=>$content));
        } else {
            echo json_encode(array("ret"=>"error","data"=>''));
        }
    }

    public function atuserlist() {
        $this->tologin();
        $keyword=$_POST['keyword'];

        if (!$keyword) {
            $dt=array();
            $dt=D('Atusers')->where("user_id='".$this->my['user_id']."'")->order("dateline DESC")->limit(20)->select();
            foreach($dt as $val) {
                $user[]=$val['atnickname'];
            }
            if ($user) {
                foreach ($user as $val) {
                    $k.= "<li>$val</li>";
                }
                echo $k;
            } else {
                echo '<center>无匹配内容</center>';
            }
        } else {
            $data1=$data2=$dt=array();
            $dt=D('Atusers')->where("user_id='".$this->my['user_id']."' AND atnickname LIKE '%$keyword%'")->order("dateline DESC")->limit(10)->select();
            $umodel=D('Users');
            $data1=$umodel->friends($this->my['user_id']);
            $data2=$umodel->follows($this->my['user_id']);
            foreach ($data1 as $val) {
                $user[]=$val['nickname'];
            }
            foreach ($data2 as $val) {
                $user[]=$val['nickname'];
            }
            foreach($dt as $val) {
                $user[]=$val['atnickname'];
            }
            $user=array_unique($user);
            if ($user) {
                foreach ($user as $val) {
                    if (strpos($val,$keyword)!==false) {
                        $k.= "<li>$val</li>";
                    }
                }
                $k=$k?$k:'<center>无匹配内容</center>';
                echo $k;
            } else {
                echo '<center>无匹配内容</center>';
            }
        }
    }

    public function sendMail($title,$send,$sendto) {
        //标题防止乱码
        $title = iconv("utf-8", "gbk",$title);
        $title = "=?GB2312?B?".base64_encode($title)."?=";

        if ($this->site['mail_mode']==1) {
            import("@.ORG.mail.phpmailer");
            $phpmailer=new PHPMailer();
            $phpmailer->IsSMTP();
            $phpmailer->SMTPAuth   = true;
            $phpmailer->Host       = $this->site['smtp_host'];
            $phpmailer->Port       = $this->site['smtp_port'];
            $phpmailer->Username   = $this->site['smtp_user'];
            $phpmailer->Password   = $this->site['smtp_pass'];
            $phpmailer->AddReplyTo($this->site['smtp_user'],$this->site['sitename']);
            $phpmailer->From       = $this->site['smtp_user'];
	        $phpmailer->FromName   = $this->site['sitename'];
            $phpmailer->CharSet = "utf-8";
            $mails=explode(',',$sendto);
            foreach ($mails as $key=>$val) {
                $phpmailer->AddAddress($val);
            }
            $phpmailer->Subject  = $title;
            $phpmailer->WordWrap = 80;
            $phpmailer->MsgHTML($send);
            $phpmailer->IsHTML(true);
            $phpmailer->Send();
        } else {
            import("@.ORG.mail.mail");
            $mail=new Email();
            $mail->setTo($send);
            $mail->setFrom($this->site['servicemail']);
            $mail->setSubject($title);
            $mail->setHTML($send);
            $mail->send();
        }
    }

    public function tologin() {
        parent::init();
        if (!$this->my) {
            echo '<script type="text/javascript">window.location.href="'.SITE_URL.'/login"</script>';
            exit;
        }
    }
}
?>