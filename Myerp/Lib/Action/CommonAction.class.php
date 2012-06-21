<?php

class CommonAction extends Action {

    public function _initialize() {
        if (!$this->user)
            redirect(SITE_INDEX.'Index/index');
			
		$this->_myinit();	
		//dump($_SERVER);
//		import('@.ORG.RBAC');  
//		if(!RBAC::AccessDecision()){
//			if ($this->roleuser) {
//				$_SESSION[C('USER_AUTH_KEY')]	= $this->roleuser['user_id'];
//				RBAC::saveAccessList();
//			}
//			if(!RBAC::AccessDecision()){
//				$this->display ('Error/index');
//				exit;
//			}
//		}
		//轨迹
//		$content = $_SERVER['REMOTE_ADDR'].' 登录 '.$_SERVER["REQUEST_URI"];
//		A("Message")->savetempmessage('',$this->roleuser['realname'],'轨迹',$content);
//		writetofile($this);
    }
	
	
    public function _myinit() {	}
   
}
?>