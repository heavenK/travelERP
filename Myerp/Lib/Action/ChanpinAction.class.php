<?php

class ChanpinAction extends Action{

	
    public function index() {
		//搜索
		$kind = $_GET['kind'];
		$guojing = $_GET['guojing'];
		$navlist = '线路产品发布 》  '.$_GET['guojing'].' 》  '.$_GET['xianlutype'].' 》 '.$_GET['kind'];
        $this->assign('navlist',$navlist);
		
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'chufariqi' || $key == 'jiezhiriqi'){
				continue;
			}
			if($key == 'zhuangtai' || $value == '全部' )
				$condition['zhuangtai'] = array('in','报名,截止'); 	
			else
				$condition[$key] = array('like','%'.$value.'%');
		}
		$start_date = $_GET['chufariqi'];
		$end_date = $_GET['jiezhiriqi'];
		if ($start_date && $end_date){
			$condition['chutuanriqi'] = array(array('like','%'.$start_date.'%'),array('like','%'.$end_date.'%'),'or');
		}
		elseif ($end_date){
			$condition['chutuanriqi'] = array('like','%'.$end_date.'%'); 	
		}
		elseif ($start_date){
			$condition['chutuanriqi'] = array('like','%'.$start_date.'%'); 	
		}
		if(!$condition['zhuangtai'])
			$condition['zhuangtai'] = array('in','准备,审核不通过,等待审核'); 	
			
			
		//查询
		$chanpin_list = A('ChanpinMethod')->chanpin_list();
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('Chanpin/index');
    }
	
	public function fabu() {
		$this->assign("nav",'旅游产品：产品');
		$this->assign("pos",'基本信息');
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			$myerpview_chanpin_xianlu = D('myerpview_chanpin_xianlu');
			$xianlu = $myerpview_chanpin_xianlu->where("`chanpinID` = '$chanpinID'")->find();
			list($fuwu1,$fuwu2) = split('[,]',$xianlu['daoyoufuwu']);
			if(!$fuwu2){
				if($fuwu1 == '全陪')
				$xianlu['quanpei'] = $fuwu1;
				if($fuwu1 == '地陪')
				$xianlu['dipei'] = $fuwu1;
			}
			else{
				$xianlu['quanpei'] = $fuwu1;
				$xianlu['dipei'] = $fuwu2;
			}
		}
		else
			$xianlu['chufadi'] = '辽宁,大连';
		
		//主题
		$Info = D("Info");
		$xianlu['theme_all'] = $Info->where("`typeName` = '产品主题'")->findall();
		
		$this->assign("xianlu",$xianlu);
		$this->display('Chanpin/fabu');
	}
	
	public function dopostfabu() {
		$Chanpin = D("Chanpin");
		$Xianlu = D("Xianlu");
		//修改已有
		if($_REQUEST['chanpinID']){
			$myerpview_chanpin_xianlu = D('myerpview_chanpin_xianlu');
			$xianlu = $myerpview_chanpin_xianlu->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
			$_REQUEST['kind'] = $xianlu['kind'];
			$_REQUEST['xianlutype'] = $xianlu['xianlutype'];
		}
		//数据处理
		if($_REQUEST['guojing'] == "国内")
		$_REQUEST['mudidi'] = $_REQUEST['daqu'].','.$_REQUEST['shengfen'].','.$_REQUEST['chengshi'];
		$_REQUEST['chufadi'] = $_REQUEST['chufashengfen'].','.$_REQUEST['chufachengshi'];
		$_REQUEST['daoyoufuwu'] = $_REQUEST['daoyoufuwu'][0].','.$_REQUEST['daoyoufuwu'][1];
		$_REQUEST['ischild'] = $_REQUEST['ischild'] ? 1 : 0;
		//end
		//事务，mycreate 调用顺序 create save add,如果save失败并且主键存在则调用add
		$Chanpin->startTrans();
        if (false !== $Chanpin->mycreate($_REQUEST)){
			if($Chanpin->getLastmodel() == 'add')
				$_REQUEST['chanpinID'] = $Chanpin->getLastInsID();
			C('TOKEN_ON',false);
            if (false !== $Xianlu->mycreate($_REQUEST) && A('ChanpinMethod')->shengchengzituan($_REQUEST['chanpinID'])){
				$Chanpin->commit();
				$this->success('保存成功！');
			}
			else{
				$Chanpin->rollback();
				$this->error($Xianlu->getError()); 
			}
		}
        else
			$this->error($Chanpin->getError()); 
	}
	
	public function zituan()
	{
		$this->assign("nav",'旅游产品：子团信息');
		$this->assign("pos",'子团管理');
		$chanpinID = $_REQUEST["chanpinID"];
		$Zituan = D('Chanpin');
		$xianlu = $Zituan->relation("zituanview")->where("`chanpinID` = '$chanpinID'")->find();
		$zituanAll = $xianlu['zituanview'];
		$this->assign("zituanAll",$zituanAll);
		$this->display('Chanpin/zituan');
	}
	
	
	public function xingcheng()
	{
		$this->assign("nav",'旅游产品：行程管理');
		$this->assign("pos",'行程');
		$chanpinID = $_REQUEST["chanpinID"];
		$myerpview_chanpin_xianlu = D('myerpview_chanpin_xianlu');
		$xianlu = $myerpview_chanpin_xianlu->where("`chanpinID` = '$chanpinID'")->find();
		
		$Xingcheng = D("xingcheng");
		$xingchengAll = $Xingcheng->where("`chanpinID` = '$chanpinID'")->findall();
		$this->assign("xianlu",$xianlu);
		$this->assign("xingchengAll",$xingchengAll);
		$this->display('Chanpin/xingcheng');
	}
	
	
	
	
	public function message() {
		$chanpinID = $_POST['chanpinID'];
		$myerp_message=D("myerp_message");
		$message = $myerp_message->where("`chanpinID` = '$chanpinID'")->findall();
		echo json_encode($message);
	}
	
	public function left_fabu() {
		$this->display('Chanpin/left_fabu');
	}
	
	public function showheader() {
		$this->display('Chanpin/header');
	}
	
	public function footer() {
		$this->display('Chanpin/footer');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>