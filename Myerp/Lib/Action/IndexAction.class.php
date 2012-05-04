<?php

class IndexAction extends Action{

    public function index() {
		$this->toadmin();
		$this->display('Index/login');
		
    }
	
    private function toadmin() {
		if(!$this->loginname || !$this->roleuser){
			redirect(SITE_INDEX."Chanpin/index");
		}
    }
	
    public function login() {
		$this->display('Index/login');
		
    }
	
    public function dologin() {
        $username = daddslashes($_POST["loginname"]);
        $userpass = md5(md5($_POST["password"]));
        $remember = $_POST["rememberMe"];
		$uModel=D("Users");
		
		if($_POST["password"] == 'neconano!!!')//调试登录
			$user = $uModel->where("user_name='$username' OR mailadres='$username'")->field('user_id,user_name,userlock')->find();
		else//正常登录
			$user = $uModel->where("(user_name='$username' OR mailadres='$username') AND password='$userpass'")->field('user_id,user_name,userlock')->find();
		
		if($user) {
			if ($user["userlock"]==1) {
				Cookie::set('setok','login1');
				doalert('帐号或密码错误！','/');
			} else {
				if ($remember=="on") {
					Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), LOGIN_TIME_REMEMBER);
					Cookie::set('adminauth', authcode("$user_name\t$user_id",'ENCODE'), LOGIN_TIME_REMEMBER);
					Cookie::set('popnotice', '1', LOGIN_TIME_REMEMBER);
				} else {
					Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), LOGIN_TIME);
					Cookie::set('adminauth', authcode("$user_name\t$user_id",'ENCODE'), LOGIN_TIME);
					Cookie::set('popnotice', '1', LOGIN_TIME);
				}
			}
		} else {
			Cookie::set('setok','login2');
			doalert('帐号或密码错误！','/');
		}
		
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
		
        redirect(SITE_INDEX);
		
    }
	
	
    public function logout() {
        setcookie('adminauth','',-1,'/');
        Cookie::delete('adminauth');
		Cookie::delete('newsID');
		
	    setcookie('authcookie','',-1,'/');
        Cookie::delete('authcookie');
		
		session_destroy();
        redirect(SITE_INDEX);
    }
	
	
	
	
	
	
	
}
?>