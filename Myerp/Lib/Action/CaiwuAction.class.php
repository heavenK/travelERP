<?php

class CaiwuAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'财务管理');
	}
	
	
	public function shenhe() {
		if($_REQUEST['datakind'] == '办证')$this->assign("markpos",'办证');
		elseif($_REQUEST['datakind'] == '签证')$this->assign("markpos",'签证');
		elseif($_REQUEST['datakind'] == '团队'){
			$this->assign("markpos",'团队');
			$_REQUEST['datakind'] = array('in','结算项目,支出项目');
		}
		elseif($_REQUEST['datakind'] == '订房')$this->assign("markpos",'订房');
		elseif($_REQUEST['datakind'] == '交通')$this->assign("markpos",'交通');
		elseif($_REQUEST['datakind'] == '餐饮')$this->assign("markpos",'餐饮');
		elseif($_REQUEST['datakind'] == '门票')$this->assign("markpos",'门票');
		elseif($_REQUEST['datakind'] == '导游')$this->assign("markpos",'导游');
		elseif($_REQUEST['datakind'] == '补账')$this->assign("markpos",'补账');
		else{
			//$_REQUEST['datakind'] = '全部';
			$this->assign("datakind",'全部');
			$this->assign("markpos",'全部');
		}
		
		A("Method")->_shenhe();
		
		if($_REQUEST['type'] == '收支项')
		A("Method")->showDirectory("收支项审核");
		if($_REQUEST['type'] == '报账单')
		A("Method")->showDirectory("报账单审核");
		if($_REQUEST['type'] == '订单')
		A("Method")->showDirectory("订单审核");
		
		
		$this->assign("markpos",$_REQUEST['datakind']);
		
		
		$this->display('shenhe');
	}
	
	
	public function doshenhe() {
		A("Method")->_doshenhe();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>