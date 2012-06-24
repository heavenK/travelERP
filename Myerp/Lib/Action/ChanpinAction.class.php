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
		$this->display('Chanpin/index');
    }
	
	public function fabu() {
		A("Method")->showDirectory("基本信息");
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
//		$Info = D("Info");
//		$xianlu['theme_all'] = $Info->where("`typeName` = '产品主题'")->findall();
		
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
		$this->display('Chanpin/xingcheng');
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
		$this->display('Chanpin/left_fabu');
	}
	
	
	
	public function doshenhe() {
		C('TOKEN_ON',false);
		$processID = $_REQUEST['processID'];
		//检查OM
		$omdata = A("Method")->_checkOM($_REQUEST['dataID'],$_REQUEST['datatype'],'管理');
		if(false === $omdata)
			$this->ajaxReturn('', '错误！无开放与管理权限', 0);
		//检查审核流程
		$process = A("Method")->_checkShenhe($_REQUEST['datatype'],$processID);
		if(!$process)
			$this->ajaxReturn('', '错误！无审核权限', 0);
		//审核任务
		$System = D("System");
		$data = $_REQUEST;
		$data['taskShenhe'] = $_REQUEST;
		if($processID == 1)
		$data['status'] = '申请';
		elseif(A("Method")->_checkShenhe($_REQUEST['datatype'],$processID+1))
		$data['status'] = '检出';
		else
		$data['status'] = '批准';
		//检查流程状态
		if(false !== A("Method")->_checkDataShenhe($_REQUEST['dataID'],$_REQUEST['datatype'],$data['status'],$processID))
			$this->ajaxReturn('', '错误！该流程已被执行，请勿重复执行！', 0);
		
		$data['taskShenhe']['processID'] = $processID;
		$data['taskShenhe']['remark'] = $process['remark'];
		$data['taskShenhe']['roles_copy'] = $omdata['roles'];
		$data['taskShenhe']['bumen_copy'] = $omdata['bumen'];
		if (false !== $System->relation("taskShenhe")->myRcreate($data)){
			if($System->getLastmodel() == 'add')
				$_REQUEST['systemID'] = $System->getRelationID();
			//记录
			$url = '';
			A("Method")->_setMessageHistory($_REQUEST['dataID'],$_REQUEST['datatype'],'提交审核申请',$url,'提醒');	
			//生成待检出	
			//检查审核流程
			$process = A("Method")->_checkShenhe($_REQUEST['datatype'],$processID+1);
			if($process){
				$data['status'] = '待检出';
				$data['taskShenhe']['remark'] = $process['remark'];
				$data['taskShenhe']['processID'] = $processID+1;
				unset($data['taskShenhe']['roles_copy']);
				unset($data['taskShenhe']['bumen_copy']);
				$System->relation("taskShenhe")->myRcreate($data);
			}
				
			$this->ajaxReturn($_REQUEST, '提交审核成功！', 1);
		}
		else{
			$this->ajaxReturn($_REQUEST, $System->getError(), 0);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
}
?>