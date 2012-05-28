<?php

class ChanpinAction extends Action{

	
    public function index() {
		//搜索
//		foreach($_GET as $key => $value)
//		{
//			if($key == 'p' || $key == 'chufariqi' || $key == 'jiezhiriqi')
//				continue;
//			if($key == 'status' || $value == '全部' )
//				$wherelist['status'] = array('in','报名,截止'); 	
//			else
//				$wherelist[$key] = array('like','%'.$value.'%');
//		}
//		$start_date = $_GET['chufariqi'];
//		$end_date = $_GET['jiezhiriqi'];
//		if ($start_date && $end_date)
//			$wherelist['chutuanriqi'] = array(array('like','%'.$start_date.'%'),array('like','%'.$end_date.'%'),'or');
//		elseif ($end_date)
//			$wherelist['chutuanriqi'] = array('like','%'.$end_date.'%'); 	
//		elseif ($start_date)
//			$wherelist['chutuanriqi'] = array('like','%'.$start_date.'%'); 	
//		if(!$wherelist['status'])
//			$wherelist['status'] = array('in','准备,审核不通过,等待审核'); 	
		$wherelist['typeName'] = '线路'; 	
		//查询
		$chanpin_list = A('ChanpinMethod')->chanpin_list($wherelist);
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
		$_REQUEST['typeName'] = '线路';
		//end
			C('TOKEN_ON',false);
A('ChanpinMethod')->shengchengzituan($_REQUEST['chanpinID']);
exit;
		
		//事务，mycreate 调用顺序 create save add,如果save失败并且主键存在则调用add
		//$Chanpin->startTrans();
        if (false !== $Chanpin->mycreate($_REQUEST)){
			if($Chanpin->getLastmodel() == 'add')
				$_REQUEST['chanpinID'] = $Chanpin->getLastInsID();
			C('TOKEN_ON',false);
            if (false !== $Xianlu->mycreate($_REQUEST) && A('ChanpinMethod')->shengchengzituan($_REQUEST['chanpinID'])){
//            if (false !== $Xianlu->mycreate($_REQUEST)){
				//$Chanpin->commit();
				$this->success('保存成功！');
			}
			else{
				//$Chanpin->rollback();
				$this->error($Xianlu->getError()); 
			}
		}
        else{
			//$Chanpin->rollback();
			$this->error($Chanpin->getError()); 
		}
	}
	
	public function zituan()
	{
		$this->assign("nav",'旅游产品：子团信息');
		$this->assign("pos",'子团管理');
		$chanpinID = $_REQUEST["chanpinID"];
		$Chanpin = D('Chanpin');
		$xianlu = $Chanpin->relation("zituanlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituanAll = $xianlu['zituanlist'];
		$this->assign("zituanAll",$zituanAll);
		$this->display('Chanpin/zituan');
	}
	
	
	public function xingcheng()
	{
		$this->assign("nav",'旅游产品：行程管理');
		$this->assign("pos",'行程');
		$chanpinID = $_REQUEST["chanpinID"];
		$Chanpin = D("Chanpin");
		$chanpin = $Chanpin->relation('xianlu')->where("`chanpinID` = '$chanpinID'")->find();
		$xingcheng = $Chanpin->relationGet("xingcheng");
		$this->assign("chanpin",$chanpin);
		$this->assign("xingcheng",$xingcheng);
		$this->display('Chanpin/xingcheng');
	}
	
	public function dopostxingcheng()
	{
		$Chanpin = D("Chanpin");
		$chanpinID = $_REQUEST["chanpinID"];
		$cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
		for($t = 0; $t < $_REQUEST['tianshu']; $t++){
			$dat['chanpinID'] = $_REQUEST['chanpinID'];
			$dat['xingchengID'] = $_REQUEST['xingchengID'][$t];
			$dat['place'] = $_REQUEST['place'][$t];
			$dat['tools'] = serialize($_REQUEST['tools'.$t]);
			$dat['chanyin'] = serialize($_REQUEST['chanyin'.$t]);
			$dat['content'] = $_REQUEST['content'][$t];
			$cp['xingcheng'][$t] = $dat;
		}
		if (false !== $Chanpin->relation('xingcheng')->save($cp))
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		else
			$this->ajaxReturn($_REQUEST, $Chengben->getError(), 0);
	}
	
	public function chengbenshoujia()
	{
		$this->assign("nav",'旅游产品：成本售价');
		$this->assign("pos",'成本售价');
		$Chanpin = D("Chanpin");
		$chanpinID = $_REQUEST["chanpinID"];
		$cp = $Chanpin->relation('chengben')->where("`chanpinID` = '$chanpinID'")->find();
		$shoujia = $Chanpin->relationGet("shoujialist");
		$chengben = $cp['chengben'];
		$this->assign("chengben",$chengben);
		$this->assign("shoujia",$shoujia);
		$this->display('Chanpin/chengbenshoujia');
	}
	
	public function dopostchengben()
	{
		C('TOKEN_ON',false);
		$d = $_REQUEST;
		$Chengben = D("Chengben");
		if (false !== $Chengben->mycreate($d)){
			if($Chengben->getLastmodel() == 'add')
				$_REQUEST['chengbenID'] = $Chengben->getLastInsID();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}else
			$this->ajaxReturn($_REQUEST, $Chengben->getError(), 0);
		
		
	}
	
	public function deletechengben()
	{
		$chengbenID = $_REQUEST['chengbenID'];
		$Chengben = D("Chengben");
		if (false !== $Chengben->where("`chengbenID` = '$chengbenID'")->delete())
			$this->ajaxReturn('', '删除成功！', 1);
		else
			$this->ajaxReturn('', $Chengben->getError(), 0);
	}
	
	
	public function dopostshoujia()
	{
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$_REQUEST['typeName'] = '售价';//必须
		$data = $_REQUEST;
		$data['shoujia'] = $_REQUEST;
		if (false !== $Chanpin->relation("shoujia")->myRcreate($data)){
			if($Chanpin->getLastmodel() == 'add')
				$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	public function deleteshoujia()
	{
		$chanpinID = $_REQUEST['chanpinID'];
		$Chanpin = D("Chanpin");
		if (false !== $Chanpin->relation("shoujia")->delete("$chanpinID"))
			$this->ajaxReturn('', '删除成功！', 1);
		else
			$this->ajaxReturn('', $Chanpin->getError(), 0);
	}
	
	
	
	public function message() {
		C('TOKEN_ON',false);
		$chanpinID = $_POST['chanpinID'];
		$myerp_message=D("myerp_message");
		$message = $myerp_message->where("`chanpinID` = '$chanpinID'")->findall();
		if ($message)
			$this->ajaxReturn(json_encode($message), '成功！', 1);
		else
			$this->ajaxReturn('', $myerp_message->getError(), 0);
		
		
//		echo json_encode($message);
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