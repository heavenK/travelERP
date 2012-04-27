<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename IndexAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class IndexAction extends Action {

    public function _initialize() {
        parent::init();
    }

    public function index() {
        //URL跳转
        $u=$_GET['u'];
        if ($u) {
            $url = D('Url')->where("`key`='$u'")->find();
            if ($url) {
                D('Url')->setInc("times","`key`='$u'");
                header("location: ".str_replace('&amp;','&',$url['url']));
                exit;
            }
        }
        $this->tohome();
        //hottalk
        $data = D('ContentView')->where("retid=0 AND replyid=0")->order("posttime DESC")->limit('20')->select();
        if ($data) {
            foreach($data as $val) {
                $welData.='<li><div class="indexgbli"><table border="0" width="100%"><tr><td width="60px" valign="top"><a href="'.SITE_URL.'/'.rawurlencode($val['user_name']).'"><img src="'.sethead($val['user_head']).'"></a></td><td valign="top"><a href="'.SITE_URL.'/'.rawurlencode($val['user_name']).'" class="'.setvip($val['user_auth']).'" '.viptitle($val['user_auth']).'>'.$val['nickname'].'</a>&nbsp;&nbsp;'.D('Content')->ubb($val['content_body']).'<div class="sp">'.timeop($val['posttime']).'&nbsp;&nbsp;'.L('tfrom').$val['type'].'</div></td></tr></table></div></li>';
            }
        }
        //hotuser
        $data= D('Users')->field('user_id,user_name,nickname,user_head')->where("followme_num>0")->order('followme_num DESC')->limit(12)->select();
        if ($data) {
            foreach($data as $val) {
                $userlisthot.='<li><a href="'.SITE_URL.'/'.rawurlencode($val['user_name']).'"><img alt="'.$val['nickname'].'" src="'.sethead($val['user_head']).'"/><span>'.$val['nickname'].'</span></a></li>';
            }
        }
        //nowuser
        $data= D('Users')->field('user_id,user_name,nickname,user_head')->where("followme_num>0")->order('lastconttime DESC')->limit(12)->select();
        if ($data) {
            foreach($data as $val) {
                $userlistnow.='<li><a href="'.SITE_URL.'/'.rawurlencode($val['user_name']).'"><img alt="'.$val['nickname'].'" src="'.sethead($val['user_head']).'"/><span>'.$val['nickname'].'</span></a></li>';
            }
        }
        //top10
        $data= D('Users')->field('user_name,nickname,followme_num')->where("followme_num>0")->order('followme_num DESC')->limit(10)->select();
        if ($data) {
            foreach($data as $key=>$val) {
                $top10.='<li><em class="num'.($key+1).' fleft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em><a class="fleft" href="'.SITE_URL.'/'.rawurlencode($val['user_name']).'">'.$val['nickname'].'</a><span>'.$val['followme_num'].'</span></li>';
            }
        }
        //hottopic
        $data=D('Topic')->where('tuijian=1')->order('topictimes DESC')->limit(20)->select();
        if ($data) {
            foreach ($data as $val) {
                $topiclist.='<li><a href="'.SITE_URL.'/k/'.$val['topicname'].'">'.$val['topicname'].'</a></li>';
            }
        }
        $this->assign('topiclist',$topiclist);
        $this->assign('userlisthot',$userlisthot);
        $this->assign('userlistnow',$userlistnow);
        $this->assign('top10',$top10);
        $this->assign('welData',$welData);
        $this->assign('allowseo',0);
        $this->display();
    }

    public function changemail() {
        A('Api')->tologin();
        $user=D('Users');
        $new_email= daddslashes(trim($_POST["email"]));
        if(!strpos($new_email,"@")) {
            Cookie::set('setok','mail2');
        } else {
            if ($new_email && $new_email!=$this->my['mailadres']) {
                $row = $user->field('mailadres')->where("mailadres='$new_email'")->find();
                if ($row) {
                    Cookie::set('setok','mail3');
                } else {
                    $data['mailadres']=$new_email;
                    $data['auth_email']=0;
                    $user->where("user_id='".$this->my['user_id']."'")->data($data)->save();
                    //sendmail
                    $this->my['mailadres']=$new_email;
                    $this->sendmail($this->my);
                    Cookie::set('setok','mail8');
                }
            } elseif ($new_email==$this->my[mailadres]){
                Cookie::set('setok','mail4');
            } else {
                Cookie::set('setok','mail5');
            }
        }
        header('location:'.SITE_URL.'/Index/regmailauth');
    }

    public function sendmail($user,$nored=0) {
        $user=$user?$user:$this->my;
        $sendurl=randStr(20);
        $sendurl=base64_encode($user['user_id'].":".$sendurl);
        $url=SITE_URL."/Index/mailactivity/auth/{$sendurl}";
        $send="<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <p>".L('mailauth_title').$user['nickname']."(<small>@".$user['user_name']."</small>)：</p>
        <p style='text-indent:2em'>".L('mailauth_this').$this->site['sitename'].L('mailauth_tip1')."<a href='$url' target='_blank'>".L('mailauth_click')."</a>".L('mailauth_copyurl')."</p>
        <p>".L('authurl').":<a href='$url' target='_blank'>$url</a></p>
        <p style='text-align:right'>".$this->site['sitename']." ".date('Y-m-d H:i')."</p>";
        $title=$this->site['sitename'].L('mailauth');

        A('Api')->sendMail($title,$send,$user['mailadres']);

        $umodel=D('Users');
        $data['auth_email']=$sendurl;
        $umodel->where("user_id='".$user['user_id']."'")->data($data)->save();

        if ($nored==0) {
            Cookie::set('setok','mail1');
            header('location:'.SITE_URL.'/Index/regmailauth');
        }
    }

    public function mailactivity() {
        A('Api')->tologin();
        $_authmsg=daddslashes($_GET['auth']);
        $authmsg=base64_decode($_authmsg);
        $tem=explode(":",$authmsg);
        $send_id=$tem[0];
        $user=D('Users');

        $row = $user->field('auth_email')->where("user_id='$send_id'")->find();
        $auth_email=$row['auth_email'];
        if ($_authmsg==$auth_email) {
            $data['auth_email']=1;
            $data['regmailauth']=1;
            $user->where("user_id='$send_id'")->data($data)->save();
            Cookie::set('setok','mail6');
        } else {
            Cookie::set('setok','mail7');
        }
        header('location:'.SITE_URL.'/Guide');
    }

    public function regmailauth() {
        A('Api')->tologin();
        if (($this->site['regmailauth']==1 && $this->my['regmailauth']==1) || $this->site['regmailauth']==0) {
            header('location:'.SITE_URL);
        }
        $this->display();
    }

    public function vip() {
        $this->assign('subname',L('index_auth_title'));
        $this->assign('allowseo',0);
        $this->display();
    }

    public function about() {
        $this->assign('subname',L('index_about_title'));
        $this->assign('allowseo',0);
        $this->display();
    }

    public function faq() {
        $this->assign('subname',L('index_faq_title'));
        $this->assign('allowseo',0);
        $this->display();
    }

    public function login() {
        $this->tohome();
        $this->assign('subname',L('login_wb'));
        $this->display();
    }

    public function register() {
        $this->tohome();
        //整合ucenter，激活功能 start
        if (ET_UC==TRUE) {
            $uModel=D('Users');
            $auth=$_REQUEST['auth'];
            $activation=$_POST['activation'];
            $password=$_POST['password'];
            if ($activation && ($activeuser = uc_get_user($activation))) {
                list($uid, $username) = $activeuser;
                list($uid, $username, $password, $email) = uc_user_login($username, $password);
                if($username && $uid>0) {
                    $sitedenie=explode('|',$this->site['regname']);
                    $deniedname=array_merge(C('DIFNAME'),$sitedenie);
                    if (in_array($username,$deniedname)) {
                        Cookie::set('setok','activation4');
                        header('location:'.SITE_URL.'/login');
                    }
                    $insert['user_name']=$username;
                    $insert['nickname']=$username;
                    $insert['user_head']=$uid;
                    $insert['password']=md5(md5($password));
                    $insert['mailadres']=$email;
                    $insert['signupdate']=time();
                    $regid = $uModel->add($insert);

                    if($regid) {
                        $this->logindt($regid);
                        Cookie::set('authcookie', authcode("$username\t$regid",'ENCODE'), 31536000);
                        Cookie::set('setok','activation2');
                        header('location:'.ET_URL);
                    } else {
                        Cookie::set('setok','activation3');
                        header('location:'.SITE_URL.'/login');
                    }
                } else {
                    Cookie::set('setok','activation1');
                    header('location:'.SITE_URL.'/register?auth='.$auth);
                    exit;
                }
            }
            list($activeuser) = explode("\t", authcode($auth,'DECODE'));
            if ($auth && $activeuser) {
                $this->assign('activeuser',$activeuser);
                $this->assign('auth',$auth);
                $this->assign('subname',L('reg_wb'));
                $this->display('activation');
                exit;
            }
        }
        // end
        if ($this->site['closereg']==1) {
            $this->assign('type','closereg');
            $this->display('Error/index');
        } else {
            $uModel=D('Users');
            $user=$uModel->getUser("user_name='$_GET[user_name]'");

            $this->assign('user',$user);
            $this->assign('subname',L('reg_wb'));
            $this->display();
        }
    }

    public function reset() {
        $this->tohome();
        $this->assign('subname',L('find_pwd'));
        $this->display();
    }

    public function dologin() {
        $this->tohome();
        $username = daddslashes($_POST["loginname"]);
        $userpass = md5(md5($_POST["password"]));
        $remember = $_POST["rememberMe"];
        $uModel=D("Users");

        if ($uModel->create()){
            //整合UCENTER
            if (ET_UC==TRUE) {
                list($uid, $username, $password, $email) = uc_user_login($username,$_POST["password"]);
                if($username && $uid>0) {
                    $user = $uModel->where("user_name='$username'")->field('user_id,user_name')->find();
                    if(!$user) {
                        $sitedenie=explode('|',$this->site['regname']);
                        $deniedname=array_merge(C('DIFNAME'),$sitedenie);
                        if (in_array($username,$deniedname)) {
                            Cookie::set('setok','activation4');
                            header('location:'.SITE_URL.'/login');
                        }
                        $auth = rawurlencode(authcode("$username\t".time(), 'ENCODE'));
                        echo '<script>alert("'.L('need_activity').'");window.location.href="'.SITE_URL.'/register?auth='.$auth.'"</script>';
                        exit;
                    } else {
                        $plugin= new pluginManager();
                        $plugin->do_action('login');
                        $this->logindt($user['user_id']);
                        if ($remember=="on") {
                            Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
                        } else {
                            Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'));
                        }
                        $ucsynlogin = uc_user_synlogin($uid);
                        if ($this->site['loginindex']=='home') {
                            echo uc_html('<script type="text/javascript" reload="1">setInterval(function(){window.location.href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'";}, 3000);</script><p>'.L('uc_login_success').'</p><p><a href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'">'.L('uc_login_tip').'</a>'.$ucsynlogin.'</p>');
                            exit;
                        } else {
                            echo uc_html('<script type="text/javascript" reload="1">setInterval(function(){window.location.href="'.SITE_URL.'/Pub";}, 3000);</script><p>'.L('uc_login_success').'</p><p><a href="'.SITE_URL.'/Pub">'.L('uc_login_tip').'</a>'.$ucsynlogin.'</p>');
                            exit;
                        }
                    }
                } else {
                    Cookie::set('setok','login2');
                    header('location:'.SITE_URL.'/login');
                }
            //end
            } else {
                $user = $uModel->where("(user_name='$username' OR mailadres='$username') AND password='$userpass'")->field('user_id,user_name,userlock')->find();
                if($user) {
                    if ($user["userlock"]==1) {
                        Cookie::set('setok','login1');
                        header('location:'.SITE_URL.'/login');
                    } else {
                        $this->logindt($user['user_id']);
                        if ($remember=="on") {
                            Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
                        } else {
                            Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'));
                        }
                        //默认跳转地址
                        if ($this->site['loginindex']=='home') {
                            header('location:'.SITE_URL.'/'.rawurlencode($user['user_name']));
                        } else {
                            header('location:'.SITE_URL.'/Pub');
                        }
                    }
                } else {
                    Cookie::set('setok','login2');
                    header('location:'.SITE_URL.'/login');
                }
            }
        } else {
            Cookie::set('setok',L('safeerror'));
            header('location:'.SITE_URL.'/login');
        }
    }

    public function doreset() {
        $this->tohome();
        $uModel=D('Users');

        $mailadres = daddslashes(trim($_POST["mailadres"]));
        $user=$uModel->getUser("mailadres='$mailadres'");
        if ($mailadres && $user['user_id']) {
            $seedstr =split(" ",microtime(),5);
            $seed =$seedstr[0]*10000;
            srand($seed);
            $pass =rand(10000,100000);
            $md5_pass=md5(md5($pass));

            $title="“".$this->site['sitename']."”".L('find_pwd');
            $url=SITE_URL."/checkreset/".base64_encode("user_name=$user[user_name]&mailadres=$user[mailadres]&user_id=$user[user_id]&dateline=".time());
            $send='<p>'.L('reset_title').'</p>
            <p style="text-indent:2em">'.L('reset_body1').'</p>
            <p style="text-indent:2em">'.L('reset_click_url').'<a href="'.$url.'" target="_blank">'.$url.'</a></p>
            <p style="float:right">'.L('reset_now_time').date("Y-m-d H:i:s").'<br/>'.$this->site['sitename'].'</p>';

            A('Api')->sendMail($title,$send,$mailadres);

            $plugin= new pluginManager();
            $plugin->do_action('reset');

            Cookie::set('setok','reset2');
            header('location:'.SITE_URL.'/reset');
        } else {
            Cookie::set('setok','reset1');
            header('location:'.SITE_URL.'/reset');
        }
    }

    public function checkreset() {
        $this->tohome();
        $uModel=D('Users');
        $urldata=$_REQUEST['urldata'];
        parse_str(base64_decode($urldata));

        if (time()-$dateline>3600*5) {
            Cookie::set('setok','reset3');//该地址已经过期，请重新“找回密码”
            header('location:'.SITE_URL.'/reset');
            exit;
        } else {
            $user=$uModel->getUser("user_id='$user_id' AND user_name='$user_name' AND mailadres='$mailadres'");
            if (!$user['user_id']) {
                Cookie::set('setok','reset4');//地址验证失败，请重新“找回密码”
                header('location:'.SITE_URL.'/reset');
                exit;
            }
        }

        $this->assign('subname',L('find_pwd'));
        $this->assign('user',$user);
        $this->assign('urldata',$urldata);
        $this->assign('type','find');
        $this->display('reset');
    }

    public function setpass() {
        $this->tohome();
        $uModel=D('Users');
        $urldata=$_REQUEST['urldata'];
        parse_str(base64_decode($urldata));
        $pass1 = md5(md5(trim($_POST["pass1"])));
        $pass2 = md5(md5(trim($_POST["pass2"])));

        if (time()-$dateline>3600*5) {
            Cookie::set('setok','reset3');//该地址已经过期，请重新“找回密码”
            header('location:'.SITE_URL.'/reset');
        } else {
            $user=$uModel->getUser("user_id='$user_id' AND user_name='$user_name' AND mailadres='$mailadres'");
            if ($user['user_id']) {
                if ($pass1 && $pass1==$pass2) {
                    $uModel->where("user_id='$user[user_id]'")->setField('password',$pass1);
                    if (ET_UC==TRUE) {
                        uc_user_edit($user['user_name'],'',$_POST["pass1"],'',1);
                    }
                    Cookie::set('setok','reset5');
                    header('location:'.SITE_URL.'/login');
                } else {
                    Cookie::set('setok','account1');
                    header('location:'.SITE_URL.'/checkreset/'.$urldata);
                }
            } else {
                Cookie::set('setok','reset4');
                header('location:'.SITE_URL.'/reset');
            }
        }
    }

    public function regcheck() {
        $this->tohome();
        $result=$this->doregcheck();
        if ($result['ret']=='check_ok') {
            $this->logindt($result['user']['user_id']);
            Cookie::set('authcookie', authcode($result['user']['user_name']."\t".$result['user']['user_id'],'ENCODE'), 31536000);
            echo 'check_ok';
        } else {
            echo $result;
        }
    }

    public function regcheckstep() {
        $this->tohome();

        $invitecode=trim($_POST['invitecode']);
        $username=daddslashes(trim(strtolower($_POST['uname'])));
        $mailadres=daddslashes(trim($_POST['mail']));
        $pass1=daddslashes(trim($_POST['pass1']));
        $pass2=daddslashes(trim($_POST['pass2']));

        $uModel=D('Users');
        $user=$uModel->getUser("user_name='$username' OR nickname='$username' OR mailadres='$mailadres'");
        if ($_POST['action']=='checkname') {
            $sitedenie=explode('|',$this->site['regname']);
            $deniedname=array_merge(C('DIFNAME'),$sitedenie);
            if (!preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]+$/u",$username)) {
                echo L('reg_name_check1');
                exit;
            }
            if (StrLenW2($username)>12 || StrLenW2($username)<3 || !$username) {
                echo L('reg_name_check2');
                exit;
            }
            if (in_array($username,$deniedname)) {
                echo L('reg_name_check3');
                exit;
            }
            if ($user && ($user['user_name']==$username || $user['nickname']==$username)) {
                echo L('reg_name_check4');
                exit;
            }
            if (ET_UC==TRUE) {
                $res=uc_user_checkname($username);
                if ($res==-1) {
                    echo L('reg_uc_check1');
                    exit;
                } else if ($res==-2) {
                    echo L('reg_uc_check2');
                    exit;
                } else if ($res==-3) {
                    echo L('reg_uc_check3');
                    exit;
                }
            }
            echo 'check_ok';
            exit;
        }
        if ($_POST['action']=='checkmail') {
            if ($user && $user['mailadres']==$mailadres) {
                echo L('reg_mail_check1');
                exit;
            }
            if(!$mailadres) {
                echo L('reg_mail_check2');
                exit;
            }
            if(!strpos($mailadres,"@")) {
                echo L('reg_mail_check3');
                exit;
            }
            if (ET_UC==TRUE) {
                $res=uc_user_checkemail($mailadres);
                if ($res==-4) {
                    echo L('reg_uc_check4');
                    exit;
                } else if ($res==-5) {
                    echo L('reg_uc_check5');
                    exit;
                } else if ($res==-6) {
                    echo L('reg_uc_check6');
                    exit;
                }
            }
            echo 'check_ok';
            exit;
        }
        if ($_POST['action']=='checkpass1') {
            if (StrLenW($pass1)<6 || StrLenW($pass1)>20) {
                echo L('reg_pass_check1');
            } else {
                echo 'check_ok';
            }
            exit;
        }
        if ($_POST['action']=='checkpass2') {
            if ($pass1 && $pass2 && $pass1==$pass2) {
                echo 'check_ok';
            } else {
                echo L('reg_pass_check2');
            }
            exit;
        }
        if ($_POST['action']=='checkcode') {
            $invitecode=trim($_POST['invitecode']);
            if ($this->site['closereg']==3) {
                $invitemsg=$this->invitecodeauth($invitecode);
                if ($invitemsg!='ok') {
                    echo $invitemsg;
                    exit;
                }
            }
            echo 'check_ok';
            exit;
        }
    }

    public function doregcheck() {
        $uModel=D('Users');

        $sitedenie=explode('|',$this->site['regname']);
        $deniedname=array_merge(C('DIFNAME'),$sitedenie);

        $invitecode=trim($_POST['invitecode']);
        $inviteuid=trim($_POST['inviteuid']);
        $username=daddslashes(trim(strtolower($_POST['uname'])));
        $mailadres=daddslashes(trim($_POST['mail']));
        $pass1=daddslashes(trim($_POST['pass1']));
        $pass2=daddslashes(trim($_POST['pass2']));

        if ($this->site['closereg']==3) {
            $invitemsg=$this->invitecodeauth($invitecode);
            if ($invitemsg!='ok') {
                return $invitemsg;
            }
        }
        if (!preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]+$/u",$username)) {
            return L('reg_name_check1');
        }
        if (StrLenW2($username)>12 || StrLenW2($username)<3 || !$username) {
            return L('reg_name_check2');
        }
        if (in_array($username,$deniedname)) {
            return L('reg_name_check3');
        }
        $user=$uModel->getUser("user_name='$username' OR nickname='$username' OR mailadres='$mailadres'");
        if ($user && ($user['user_name']==$username || $user['nickname']==$username)) {
            return L('reg_name_check4');
        }

        if ($user && $user['mailadres']==$mailadres) {
            return L('reg_mail_check1');
        }
        if(!$mailadres) {
            return L('reg_mail_check2');
        }
        if(!strpos($mailadres,"@")) {
            return L('reg_mail_check3');
        }
        if (StrLenW($pass1)<6 || StrLenW($pass1)>20) {
            return L('reg_pass_check1');
        }
        if ($pass1!=$pass2) {
            return L('reg_pass_check2');
        }
        if ($username && $mailadres && $pass1==$pass2) {
            //ucenter注册
            if (ET_UC==TRUE) {
                if(uc_get_user($username)) {
                    return L('reg_uc_activity');
                }
                $uid = uc_user_register($username, $pass2, $mailadres);
                if($uid <= 0) {
                    if($uid == -1) {
                        return L('reg_uc_check1');
                    } elseif($uid == -2) {
                        return L('reg_uc_check2');
                    } elseif($uid == -3) {
                        return L('reg_uc_check3');
                    } elseif($uid == -4) {
                        return L('reg_uc_check4');
                    } elseif($uid == -5) {
                        return L('reg_uc_check5');
                    } elseif($uid == -6) {
                        return L('reg_uc_check6');
                    } else {
                        return L('reg_uc_check7');
                    }
                }
            }
            if ($uid>0) {
                $insert['user_head']=$uid;
            }
            //end
            $insert['user_name']=$username;
            $insert['nickname']=$username;
            $insert['password']=md5(md5($pass2));
            $insert['mailadres']=$mailadres;
            $insert['signupdate']=time();
            $insert['regip']=real_ip();
            $regid = $uModel->add($insert);
            if($regid) {

                $plugin= new pluginManager();
                $plugin->do_action('register');

                if ($uModel->getUser("user_id='$inviteuid'")) {
                    $uModel->where("user_id='$inviteuid'")->setField(array('followme_num','follow_num','newfollownum'),array(array('exp','followme_num+1'),array('exp','follow_num+1'),array('exp','newfollownum+1')));

                    $uModel->where("user_id='$regid'")->setField(array('followme_num','follow_num'),array(array('exp','followme_num+1'),array('exp','follow_num+1')));

                    $fModel=D('friend');
                    $data1['fid_jieshou']=$regid;
                    $data1['fid_fasong']=$inviteuid;
                    $data2['fid_jieshou']=$inviteuid;
                    $data2['fid_fasong']=$regid;
                    $fModel->add($data1);
                    $fModel->add($data2);
                }
                //注册邮件验证
                if ($this->site['regmailauth']==1) {
                    $user=array('user_id'=>$regid,'user_name'=>$username,'nickname'=>$username,'mailadres'=>$mailadres);
                    $this->sendmail($user,1);
                }
                //发送欢迎私信
                if ($this->site['openwelpri']==1) {
                    D('Messages')->sendmsg($this->site['welcomemsg'],$username,0);
                }
                //网站统计
                $this->addtongji('register');
                if ($this->site['closereg']==3) {
                    D('invitecode')->where("invitecode='$invitecode'")->setField(array('isused','user_name'),array('1',$username));
                }
                return array("ret"=>"check_ok",'user'=>array('user_id'=>$regid,'user_name'=>$username));
            } else {
                return L('reg_error');
            }
        } else {
            return L('reg_error');
        }
    }

    public function logout() {
        setcookie('authcookie','',-1,'/');
        Cookie::delete('authcookie');

        $plugin= new pluginManager();
        $plugin->do_action('logout');

        if (ET_UC==TRUE) {
            $ucsynlogout = uc_user_synlogout();
            echo uc_html('<script type="text/javascript" reload="1">setInterval(function(){window.location.href="'.ET_URL.'";}, 3000);</script><p>'.L('uc_logout_success').'</p><p><a href="'.SITE_URL.'">'.L('uc_login_tip').'</a>'.$ucsynlogout.'</p>');
        } else {
            header("location:".ET_URL);
        }
    }

    private function tohome() {
        //默认跳转地址
        if ($this->site['loginindex']=='home') {
            $rurl=$this->my['user_name'];
        } else {
            $rurl='Pub';
        }
        if ($this->my) {
            if (!arraynull($_REQUEST)) {
                header('location: '.SITE_URL.'/'.rawurlencode($rurl));
            } else {
                echo '<script type="text/javascript">window.location.href="'.SITE_URL.'/'.rawurlencode($rurl).'"</script>';
            }
        }
    }

    public function invitecodeauth($code) {
        $ivcode=D('invitecode');
        $data = $ivcode->where("invitecode='$code'")->find();
        if ($data['id'] && ($data['timeline']>=time() || $data['timeline']==0) && $data['isused']==0) {
            $msg="ok";
        } else if($data['id'] && ($data['timeline']>=time() || $data['timeline']==0) && $data['isused']==1) {
            $msg=L('invtecode_error1');
        } else {
            $msg=L('invtecode_error2');
        }
        return $msg;
    }

    private function logindt($uid) {
        $insert['user_id']=$uid;
        $insert['login_ip']=real_ip();
        $insert['login_time']=time();
        D('Logindt')->add($insert);
    }
}
?>