<?php

class CommonAction extends Action {

    public function _initialize() {
		
		//权限
		foreach($_GET as $key => $value)
		{
			$this->assign($key,$value);
		}
		
        if (!$this->roleuser) {
            redirect(SITE_ADMIN.'Login/index');
        }
		import('@.ORG.RBAC');  

		if(!RBAC::AccessDecision()){
			if ($this->roleuser) {
				$_SESSION[C('USER_AUTH_KEY')]	= $this->roleuser['user_id'];
				RBAC::saveAccessList();
			}
			if(!RBAC::AccessDecision())
			{
				$this->display ('Error/index');
				exit;
			}
			
		}
		
		//轨迹
		$content = $_SERVER['REMOTE_ADDR'].' 登录 '.$_SERVER["REQUEST_URI"];
		A("Message")->savetempmessage('',$this->roleuser['realname'],'轨迹',$content);
		writetofile($this);
	
		
		
/*		
		$acts=explode("/",$_SERVER['PATH_INFO']);
		if(!checkByAdminlevel('网管,总经理',$this))
		{
			if($_SERVER['PHP_SELF'] == '/gulianDijie.php')
			{
				if(!checkByAdminlevel('地接操作员',$this))
				{
					$this->display ('Error/index');
					exit;
				}
			}
			if($_SERVER['PHP_SELF'] == '/gulianMenshi.php')
			{
				if(in_array('Dingdan',$acts))
				{
					if(checkByAdminlevel('联合体成员',$this))
					{
						$this->display ('Error/index');
						exit;
					}
				}
			}
			if($_SERVER['PHP_SELF'] == '/index.php')
			{
				if(!checkByAdminlevel('计调操作员,计调经理,财务操作员',$this))
				{
					$this->display ('Error/index');
					exit;
				}
			}
		}
		
*/		
		
    }
	
	
	

   
}
?>