<?php

class CaiwuAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'财务管理');
	}
	
	
	public function shenhe() {
		A("Method")->_shenhe();
		if($_REQUEST['type'] == '收支项')
		A("Method")->showDirectory("收支项审核");
		if($_REQUEST['type'] == '报账单')
		A("Method")->showDirectory("报账单审核");
		if($_REQUEST['type'] == '订单')
		A("Method")->showDirectory("订单审核");
		$this->display('shenhe');
	}
	
	
	public function doshenhe() {
		A("Method")->_doshenhe();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>