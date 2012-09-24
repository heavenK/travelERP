<?php

class CommonAction extends Action {
	
    public function _initialize() {
        if (!$this->user)
            redirect(SITE_INDEX.'Index/index');
		$this->_myinit();	
        import('@.ORG.Util.Cookie');
        // 用户权限检查
        if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
            import('@.ORG.Util.RBAC');
            if (!RBAC::AccessDecision()) {
				if ($this->user) {
					A("Method")->_opentoRBAC($this->user);
				}
				if(!RBAC::AccessDecision()){
					$this->assign("message",'您的访问受限！！');
					$this->display ('Index:error');
					exit;
				}
            }
        }
    }
	
	
    public function _myinit() {	}
   
}
?>