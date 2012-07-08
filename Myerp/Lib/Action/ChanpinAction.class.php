<?php

class ChanpinAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'旅游产品');
	}
	
    public function index() {
		A("Method")->showDirectory("旅游产品");
		$chanpin_list = A('Method')->xianlu_list($_GET);
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('index');
    }
	
	public function fabu() {
		A("Method")->showDirectory("基本信息");
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			//检查OM
			$dataom = A("Method")->_checkDataOM($chanpinID,'线路','管理');
			if(false !== $dataom){
				$root_shenqing = true;
				$this->assign("root_shenqing",true);
			}
			$taskom = A("Method")->_checkDataShenheOM($chanpinID,'线路');
			if(false !== $taskom){
				$root_shenhe = true;
				$this->assign("root_shenhe",true);
			}
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
		$ViewDataDictionary = D("ViewDataDictionary");
		$xianlu['theme_all'] = $ViewDataDictionary->where("`type` = '主题'")->findall();
		
		$this->assign("xianlu",$xianlu);
		$this->assign("datatitle",' : "'.$xianlu['title'].'"');
		$this->display('fabu');
	}
	
	public function dopostfabu() {
		$Chanpin = D("Chanpin");
		$_REQUEST['xianlu'] = $_REQUEST;
		//修改已有
		if($_REQUEST['chanpinID']){
			$xianlu = $Chanpin->relation("xianlu")->find($_REQUEST['chanpinID']);
			$_REQUEST['xianlu']['kind'] = $xianlu['xianlu']['kind'];
			$_REQUEST['xianlu']['xianlutype'] = $xianlu['xianlu']['xianlutype'];
		}
		//数据处理
		if($_REQUEST['guojing'] == "国内")
		$_REQUEST['xianlu']['mudidi'] = $_REQUEST['daqu'].','.$_REQUEST['shengfen'].','.$_REQUEST['chengshi'];
		$_REQUEST['xianlu']['chufadi'] = $_REQUEST['chufashengfen'].','.$_REQUEST['chufachengshi'];
		$_REQUEST['xianlu']['daoyoufuwu'] = $_REQUEST['daoyoufuwu'][0].','.$_REQUEST['daoyoufuwu'][1];
		$_REQUEST['xianlu']['ischild'] = $_REQUEST['ischild'] ? 1 : 0;
		//end
		$Chanpin->startTrans();
		if (false !== $Chanpin->relation("xianlu")->myRcreate($_REQUEST)){
			if($Chanpin->getLastmodel() == 'add')
				$_REQUEST['chanpinID'] = $Chanpin->getLastInsID();
			if(A("Method")->shengchengzituan($_REQUEST['chanpinID'])){
				$Chanpin->commit();
				$this->ajaxReturn($_REQUEST, '保存成功！', 1);
			}
		}
		$Chanpin->rollback();
		$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	public function zituan()
	{
		A("Method")->showDirectory("子团管理");
		$chanpinID = $_REQUEST["chanpinID"];
		$Chanpin = D('Chanpin');
		$xianlu = $Chanpin->relation("zituanlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituanAll = $xianlu['zituanlist'];
		$this->assign("zituanAll",$zituanAll);
		$xianlu = $Chanpin->relationGet("xianlu");
		$this->assign("datatitle",' : "'.$xianlu['title'].'"');
		$this->display('zituan');
	}
	
	public function deletezituan()
	{
		$chanpinID = $_REQUEST['chanpinID'];
		$parentID = $_REQUEST['parentID'];
		$Chanpin = D("Chanpin");
		$Chanpin->startTrans();
		if (false !== $Chanpin->relation("zituan")->delete($chanpinID)){
			if(A("Method")->shengchengzituan_2($parentID)){
				$Chanpin->commit();
				$this->ajaxReturn('', '删除成功！', 1);
			}
		}
		$Chanpin->rollback();
		$this->ajaxReturn('', $Chengben->getError(), 0);
	}
	
	public function xingcheng()
	{
		A("Method")->showDirectory("行程");
		$chanpinID = $_REQUEST["chanpinID"];
		$Chanpin = D("Chanpin");
		$chanpin = $Chanpin->relation('xianlu')->where("`chanpinID` = '$chanpinID'")->find();
		$xingcheng = $Chanpin->relationGet("xingcheng");
		$this->assign("chanpin",$chanpin);
		$this->assign("xingcheng",$xingcheng);
		$this->assign("datatitle",' : "'.$chanpin['xianlu']['title'].'"');
		$this->display('xingcheng');
	}
	
	public function dopostxingcheng()
	{
		$Chanpin = D("Chanpin");
		$chanpin = $_REQUEST;
		for($t = 0; $t < $_REQUEST['tianshu']; $t++){
			$dat['chanpinID'] = $_REQUEST['chanpinID'];
			$dat['xingchengID'] = $_REQUEST['xingchengID'][$t];
			$dat['place'] = $_REQUEST['place'][$t];
			$dat['tools'] = serialize($_REQUEST['tools'.$t]);
			$dat['chanyin'] = serialize($_REQUEST['chanyin'.$t]);
			$dat['content'] = $_REQUEST['content'][$t];
			$chanpin['xingcheng'][$t] = $dat;
		}
		if (false !== $Chanpin->relation('xingcheng')->myRcreate($chanpin))
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	public function chengbenshoujia()
	{
		A("Method")->showDirectory("成本售价");
		$Chanpin = D("Chanpin");
		$chanpinID = $_REQUEST["chanpinID"];
		$cp = $Chanpin->relation('chengben')->where("`chanpinID` = '$chanpinID'")->find();
		$shoujia = $Chanpin->relationGet("shoujialist");
		$chengben = $cp['chengben'];
		$this->assign("chengben",$chengben);
		$this->assign("shoujia",$shoujia);
		$xianlu = $Chanpin->relationGet("xianlu");
		$this->assign("datatitle",' : "'.$xianlu['title'].'"');
		$this->display('chengbenshoujia');
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
	
	
	public function left_fabu() {
		$this->display('left_fabu');
	}
	
	
	
	public function doshenhe() {
		C('TOKEN_ON',false);
		//检查OM权限
		//检查流程权限及状态
		//生成审核任务
		//生成待检出	
		$userIDlist = A("Method")->_shenheDO($_REQUEST,$_REQUEST['dotype']);
		if (false !== $userIDlist){
			//记录
			$url = '';
			$message = '提交'.$_REQUEST['datatype'].'审核申请《'.$_REQUEST['title']."》";
			A("Method")->_setMessageHistory($_REQUEST['dataID'],$_REQUEST['datatype'],$message,$url,$userIDlist);	
			$this->ajaxReturn($_REQUEST, cookie('successmessage'), 1);
		}
		else
			$this->ajaxReturn($_REQUEST, cookie('errormessage'), 0);
	}
	
	
	
	public function shenhe() {
		A("Method")->showDirectory("产品审核");
		$datalist = A('Method')->getDataOMlist('审核任务',$_GET);
		$this->assign("page",$datalist['page']);
		$this->assign("chanpin_list",$datalist['chanpin']);
		$this->display('shenhe');
	}
	
	
	
	
	
	
	
	
	
	
	
}
?>