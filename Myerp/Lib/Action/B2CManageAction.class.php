<?php

class B2CManageAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'电商管理');
	}
	
	
    public function index() {
		//筛选条件
		$_REQUEST['serverdataID'] = array('neq','');
		if($_REQUEST['second_confirm'])
			A("Method")->showDirectory("二次确认线路管理");
		else
			A("Method")->showDirectory("网店线路管理");
		$chanpin_list = A('Method')->getDataOMlist('线路','xianlu',$_REQUEST);
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('index');
    }
	
	
    public function dingdanlist() {
		$_REQUEST['user_name'] = '电商';
		A("Xiaoshou")->dingdanlist();
    }
	
	
    public function dingzhixinxi() {
		$_REQUEST['user_name'] = '电商';
		A("Message")->gexingdingzhilist();
    }
	
	
    public function zituanlist() {
		//筛选条件
		$_REQUEST['status_shop'] = array('neq','');
		$_REQUEST['webpage'] = 1;
		A("Method")->_zituanlist('产品搜索');	
    }
	
	
    public function getyudinglist() {
		$chanpinID = $_REQUEST['chanpinID'];
		$WEBServiceOrder = D("WEBServiceOrder");
		$orderall = $WEBServiceOrder->where("`clientdataID` = '$chanpinID'")->findall();
		$this->ajaxReturn($orderall, '读取成功！', 1);
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>