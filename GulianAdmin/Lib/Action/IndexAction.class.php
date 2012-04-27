<?php

class IndexAction extends Action{

    public function index() {
		
        $this->assign('navtitle','古莲国旅管理系统');
		if(!$this->loginname){
			$this->display('Login/loginfirst');
		}
		else{
			
			if(!$this->roleuser)
				$this->display('Login/loginfirst');
				else
			{
			$this->toadmin();
			//$this->display('Login/loginguide');
			$this->display('Chanpin/index');
				}
		}
    }
    private function toadmin() {
        if ($this->adminuser) {
			
				$defaulthome = Cookie::get('defaulthome');
				if($defaulthome)
				echo '<script>parent.location.href="'.$defaulthome.'"</script>';
				
				$jumpurl = SITE_ADMIN.'Chanpin';
				if(checkByAdminlevel('门市操作员',$this))
					  $jumpurl = SITE_MENSHI;
				if(checkByAdminlevel('地接操作员,地接经理',$this))
					  $jumpurl = SITE_DIJIE;
				if(checkByAdminlevel('计调操作员,计调经理,财务操作员,财务总监,总经理,网管',$this))
					  $jumpurl = SITE_ADMIN.'Chanpin';
				if(checkByAdminlevel('联合体成员,联合体经理,办事处操作员',$this))
					  $jumpurl = SITE_MENSHI;
				
				echo '<script>parent.location.href="'.$jumpurl.'"</script>';
        }
    }
	
	
	
}
?>