<?php

class ChanpinAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'旅游产品');
	}
	
    public function index() {
		A("Method")->showDirectory("线路发布及控管");
		$chanpin_list = A('Method')->getDataOMlist('线路','xianlu',$_REQUEST);
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('index');
    }
	
	public function fabu() {
		A("Method")->showDirectory("基本信息");
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			//检查dataOM
			$xianlu = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'线路');
			if(false === $xianlu){
				$this->display('Index:error');
				exit;
			}
			$ViewXianlu = D('ViewXianlu');
			$xianlu = $ViewXianlu->where("`chanpinID` = '$chanpinID'")->find();
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
		else{
			//判断计调角色
			$durlist = A("Method")->_checkRolesByUser('计调,经理');
			if(false === $durlist){
				$this->display('Index:error');
				exit;
			}
			$xianlu['chufadi'] = '辽宁,大连';
		}
		//主题
		$ViewDataDictionary = D("ViewDataDictionary");
		$xianlu['theme_all'] = $ViewDataDictionary->order("time desc")->where("`type` = '主题' AND `status` != '-1'")->findall();
		
		$this->assign("xianlu",$xianlu);
		$this->assign("datatitle",' : "'.$xianlu['title'].'"');
		$this->display('fabu');
	}
	
	public function dopostfabu() {
		$Chanpin = D("Chanpin");
		$_REQUEST['xianlu'] = $_REQUEST;
		//修改已有
		if($_REQUEST['chanpinID']){
			//检查dataOM
			$xianlu = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'线路','管理');
			if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
			$xianlu = $Chanpin->relation("xianlu")->find($_REQUEST['chanpinID']);
			$_REQUEST['xianlu']['kind'] = $xianlu['xianlu']['kind'];
			$_REQUEST['xianlu']['xianlutype'] = $xianlu['xianlu']['xianlutype'];
		}
		else{
			//判断计调角色
			$durlist = A("Method")->_checkRolesByUser('计调,经理');
			if (false === $durlist)
				$this->ajaxReturn('', '没有计调或经理权限发布', 0);
		}
		//检查
		if(!$_REQUEST['chufashengfen'] || !$_REQUEST['chufachengshi'])
			$this->ajaxReturn($_REQUEST,'错误,出发地不能为空！', 0);
		if(!$_REQUEST['daqu'] || !$_REQUEST['shengfen'] || !$_REQUEST['chengshi'])
			$this->ajaxReturn($_REQUEST,'错误,目的地不能为空！', 0);
		//数据处理
		if($_REQUEST['guojing'] == "国内")
		$_REQUEST['xianlu']['mudidi'] = $_REQUEST['daqu'].','.$_REQUEST['shengfen'].','.$_REQUEST['chengshi'];
		$_REQUEST['xianlu']['chufadi'] = $_REQUEST['chufashengfen'].','.$_REQUEST['chufachengshi'];
		$_REQUEST['xianlu']['daoyoufuwu'] = $_REQUEST['daoyoufuwu'][0].','.$_REQUEST['daoyoufuwu'][1];
		$_REQUEST['xianlu']['ischild'] = $_REQUEST['ischild'] ? 1 : 0;
		//end
		if (false !== $Chanpin->relation("xianlu")->myRcreate($_REQUEST)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			//生成OM
			if($Chanpin->getLastmodel() == 'add'){
				$i = 0;
				foreach($durlist as $v){
					$dataOMlist[$i]['DUR'] = $v['departmentID'].','.$v['rolesID'].','.$v['userID'];
					$i++;
				}
				//附加开放给部门角色
				foreach($durlist as $v){
					$dataOMlist[$i]['DUR'] = $v['departmentID'].','.$v['rolesID'].',';
					$i++;
				}
				A("Method")->_createDataOM($_REQUEST['chanpinID'],'线路','管理',$dataOMlist);
			}
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	public function dopostfabu_shoujia() {
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'线路','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data['chanpinID'] = $_REQUEST['chanpinID'];
		$data['xianlu']['shoujia'] = $_REQUEST['shoujia'];
		$data['xianlu']['remark'] = $_REQUEST['remark'];
		if (false !== $Chanpin->relation("xianlu")->myRcreate($data))
				$this->ajaxReturn($_REQUEST, '保存成功！', 1);
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
		return false;
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
		$xingcheng = $Chanpin->relationGet("xingchenglist");
		$this->assign("chanpin",$chanpin);
		$this->assign("xingcheng",$xingcheng);
		$this->assign("datatitle",' : "'.$chanpin['xianlu']['title'].'"');
		$this->display('xingcheng');
	}
	
	
	public function dopostxingcheng()
	{
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($_REQUEST['parentID'],'线路','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$dat['__hash__'] = $_REQUEST['__hash__'];
		for($t = 0; $t < $_REQUEST['tianshu']; $t++){
			if($_REQUEST['chanpinID'][$t])
			$dat['chanpinID'] = $_REQUEST['chanpinID'][$t];
			$dat['parentID'] = $_REQUEST['parentID'];
			$dat['xingcheng']['place'] = $_REQUEST['place'][$t];
			$dat['xingcheng']['tools'] = serialize($_REQUEST['tools'.$t]);
			$dat['xingcheng']['chanyin'] = serialize($_REQUEST['chanyin'.$t]);
			$dat['xingcheng']['content'] = $_REQUEST['content'][$t];
			if (false === $Chanpin->relation('xingcheng')->myRcreate($dat))
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
		}
		$this->ajaxReturn($_REQUEST, '保存成功！', 1);
	}
	
	
	public function chengbenshoujia()
	{
		A("Method")->showDirectory("成本售价");
		$Chanpin = D("Chanpin");
		$chanpinID = $_REQUEST["chanpinID"];
		$cp = $Chanpin->relation('chengbenlist')->where("`chanpinID` = '$chanpinID'")->find();
		$chanpin = $Chanpin->relationGet('xianlu');
		$this->assign("chanpin",$chanpin);
		$shoujia = $Chanpin->relationGet("shoujialist");
		$chengbenlist = $cp['chengbenlist'];
		$this->assign("chengben",$chengbenlist);
		$shoujia = A("Method")->_fenlei_filter($shoujia);
		$this->assign("shoujia",$shoujia);
		$xianlu = $Chanpin->relationGet("xianlu");
		$this->assign("datatitle",' : "'.$xianlu['title'].'"');
		//成本数据字典
		$ViewDataDictionary = D("ViewDataDictionary");
		$chengbenlist = $ViewDataDictionary->order("time desc")->where("`type` = '成本' AND `status` != '-1'")->findall();
		$this->assign("chengbenlist_1",$chengbenlist);
		foreach($chengbenlist as $v){
			if($d)
			$d .= ','.'"'.$v['title'].'"';
			else
			$d = '"'.$v['title'].'"';
		}
		$this->assign("chengbenlist",$d);
		A('Method')->unitlist();
		$this->display('chengbenshoujia');
	}
	
	
	
	public function dopostchengben()
	{
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($_REQUEST['parentID'],'线路','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		C('TOKEN_ON',false);
		$d = $_REQUEST;
		$d['chengben'] = $_REQUEST;
		$Chanpin = D("Chanpin");
		if (false !== $Chanpin->relation('chengben')->myRcreate($d)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	public function deletechengben()
	{
		$chanpinID = $_REQUEST['chanpinID'];
		$Chengben = D("Chengben");
		$ViewChengben = D("ViewChengben");
		$cb = $ViewChengben->where("`chanpinID` = '$chanpinID'")->find();
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($cb['parentID'],'线路','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		if (false !== $Chengben->where("`chanpinID` = '$chanpinID'")->delete())
			$this->ajaxReturn('', '删除成功！', 1);
		else
			$this->ajaxReturn('', $Chengben->getError(), 0);
	}
	
	
	public function dopostshoujia()
	{
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($_REQUEST['parentID'],'线路','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data = $_REQUEST;
		$data['shoujia'] = $_REQUEST;
		//折扣范围
		if($_REQUEST['adultprice'] -$_REQUEST['cut'] <0)
			$this->ajaxReturn($_REQUEST, '成人销售价格与折扣范围相差不能为负！', 0);
		if($_REQUEST['childprice'] -$_REQUEST['cut'] <0)
			$this->ajaxReturn($_REQUEST, '儿童销售价格与折扣范围相差不能为负！', 0);
		if (false !== $Chanpin->relation("shoujia")->myRcreate($data)){
			if($Chanpin->getLastmodel() == 'add')
				$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			//生成开放OM	
			A('Method')->_shoujiaToDataOM($_REQUEST);
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	public function deleteshoujia()
	{
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'线路','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
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
		$Message=D("Message");
		$message = $Message->order("time desc")->where("`chanpinID` = '$chanpinID' AND `status` != '-1'")->findall();
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
		$this->display('Chanpin:left_fabu');
	}
	
	
	public function header_chanpin() {
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			//检查OM
			$dataom = A("Method")->_checkDataOM($chanpinID,'线路','管理');
			if(false !== $dataom){
				if(A('Method')->_checkShenhe('线路',2))
				$this->assign("root_shenqing",true);
				else
				$this->assign("root_shenqing2",true);
			}
			$taskom = A("Method")->_checkDataShenheOM($chanpinID,'线路');
			if(false !== $taskom)
				$this->assign("root_shenhe",true);
			//判断子团
			$Chanpin = D("Chanpin");
			$zituan = $Chanpin->where("`parentID` = '$chanpinID' and `marktype` = 'zituan'")->find();
			if($zituan)
				$this->assign("showzituan",true);
		}
		$this->display('header_chanpin');
	}
	
	
	
	public function header_kongguan() {
		$chanpinID = $_REQUEST["chanpinID"];
		$this->display('header_kongguan');
	}
	
	
	
	public function doshenhe() {
		C('TOKEN_ON',false);
		//报账项
		if($_REQUEST['datatype'] == '报账项'){
			$ViewBaozhangitem = D("ViewBaozhangitem");
			$bzi = $ViewBaozhangitem->where("`chanpinID` = '$_REQUEST[dataID]' and `status` = '批准'")->find();
			if($bzi)
			$this->ajaxReturn('', '错误！该项目已经审核通过！', 0);
		}
		
		if($_REQUEST['dotype'] == '申请'){
			$processID = 1;
			if(A("Method")->_checkShenhe($_REQUEST['datatype'],$processID+1))
			$data['status'] = '申请';
			else
			$data['status'] = '批准';
		}
		else{
			$need = A("Method")->_checkTaskDJC($_REQUEST['dataID'],$_REQUEST['datatype']);
			$processID = $need['processID'];
			if(A("Method")->_checkShenhe($_REQUEST['datatype'],$processID+1))
			$data['status'] = '检出';
			else
			$data['status'] = '批准';
		}
		//检查OM权限
		//检查流程权限及状态
		//生成审核任务
		//生成待检出	
		$userIDlist = A("Method")->_shenheDO($_REQUEST,$_REQUEST['dotype']);
		if (false !== $userIDlist){
			//记录
			$url = '';
			$Chanpin = D("Chanpin");
			$message = $_REQUEST['datatype'].'审核'.$data['status'].$_REQUEST['title'];
			A("Method")->_setMessageHistory($_REQUEST['dataID'],$_REQUEST['datatype'],$message,$url);
			
			//检查审核流程权限
			$checkds = A("Method")->_checkShenhe($_REQUEST['datatype'],$processID,$this->user['systemID']);
			if($_REQUEST['datatype'] == '线路'){
				if($data['status'] == '批准'){
				  	$Chanpin = D("Chanpin");
					$editdat['chanpinID'] = $_REQUEST['dataID'];
					$editdat['islock'] = '已锁定';
					$editdat['status'] = '报名';
				  	$Chanpin->mycreate($editdat);
					//线路审核通过,生成子团
					A("Method")->shengchengzituan($_REQUEST['dataID']);
				}
			}
			if($_REQUEST['datatype'] == '报账项'){
				$Chanpin = D("Chanpin");
				$editdat['chanpinID'] = $_REQUEST['dataID'];
				$editdat['baozhangitem']['shenhe_remark'] = $checkds['remark'];
				if($data['status'] == '批准'){
					$editdat['islock'] = '已锁定';
					$editdat['status'] = '批准';
				}
				$Chanpin->relation("baozhangitem")->myRcreate($editdat);
			}
			
			if($_REQUEST['datatype'] == '报账单'){
				$Chanpin = D("Chanpin");
				$editdat['chanpinID'] = $_REQUEST['dataID'];
				$editdat['baozhang']['shenhe_remark'] = $checkds['remark'];
				if($data['status'] == '批准'){
					$editdat['islock'] = '已锁定';
					$editdat['status'] = '批准';
				}
				$Chanpin->relation("baozhang")->myRcreate($editdat);
			}
			
			$this->ajaxReturn($_REQUEST, cookie('successmessage'), 1);
		}
		else
			$this->ajaxReturn($_REQUEST, cookie('errormessage'), 0);
	}
	
	
	
	public function shenhe() {
		A("Method")->showDirectory("产品审核");
		$datalist = A('Method')->getDataOMlist('审核任务','xianlu',$_REQUEST);
		$this->assign("page",$datalist['page']);
		$this->assign("chanpin_list",$datalist['chanpin']);
		$this->display('shenhe');
	}
	
	
	
	public function kongguan() {
		A("Method")->showDirectory("子团产品");
		$datalist = A('Method')->getDataOMlist('控管','zituan',$_REQUEST);
		$this->assign("page",$datalist['page']);
		$this->assign("chanpin_list",$datalist['chanpin']);
		$this->display('kongguan');
	}
	
	
	
	public function zituanxinxi() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		A("Method")->showDirectory("子团产品");
		$this->assign("markpos",'基本信息');
		$chanpinID = $_REQUEST['chanpinID'];
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
		$DataCopy = D("DataCopy");
		$data = $DataCopy->where("`dataID` = '$zituan[parentID]' and `datatype` = '线路'")->order("time desc")->find();
		$zituan['xianlulist'] = unserialize($data['copy']);
		$zituan['xianlulist']['shoujia'] = A("Method")->_fenlei_filter($zituan['xianlulist']['shoujia']);
		$this->assign("zituan",$zituan);
		$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		$title = $_REQUEST['typemark'].'--'.$zituan['title_copy'].'--'.$zituan['chutanriqi'];
		if($_REQUEST['export'] == 1){
			//导出Word必备头
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . $title . ".doc");
			header("Pragma:no-cache");        
			header("Expires:0"); 
		}
		if($_REQUEST['typemark'] == '接待计划' || $_REQUEST['typemark'] == '出团通知'){
			$ViewDingdan = D("ViewDingdan");
			$dingdanlist = $ViewDingdan->order("time desc")->where("`parentID` = '$zituan[chanpinID]' and `status` = '确认' AND `status` != '-1'")->findall();
			$DataCD = D("DataCD");
			$i = 0;
			foreach($dingdanlist as $v){
				$cdall = $DataCD->order("id desc")->where("`dingdanID` = '$v[chanpinID]'")->findall();
				foreach($cdall as $vol){
					$tuanyuan[$i] = $vol;
					$i++;
				}
			}
			$this->assign("tuanyuan",$tuanyuan);
		}
		if($_REQUEST['typemark'] == '接待计划'){
			$zituan['jiedaijihua'] = unserialize($zituan['jiedaijihua']);
			$this->assign("zituan",$zituan);
			$this->display('print_jiedaijihua');
		}
		else if($_REQUEST['typemark'] == '出团通知'){
			$zituan['chutuantongzhi'] = unserialize($zituan['chutuantongzhi']);
			$tuanrenshu = A("Method")->_getzituandingdan($_REQUEST['chanpinID']);
			$this->assign("tuanrenshu",$tuanrenshu);
			$this->assign("zituan",$zituan);
			$this->display('print_chutuantongzhi');
		}
		else $this->display('zituanxinxi');
	}
	
	
	
	public function dopostzituanxinxi() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		$data = $_REQUEST;
		$data['zituan'] = $data;
		$Chanpin = D("Chanpin");
		if( false !== $Chanpin->relation("zituan")->myRcreate($data))
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		else
			$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
		

	}
	
	
	public function zituandingdan() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		A("Method")->showDirectory("子团产品");
		$this->assign("markpos",'子团订单');
		$chanpinID = $_REQUEST['chanpinID'];
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
		$this->assign("zituan",$zituan);
		$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		$ViewDingdan = D("ViewDingdan");
		$dingdanlist = $ViewDingdan->order("time desc")->where("`parentID` = '$_REQUEST[chanpinID]' AND `status` != '-1'")->findall();
		//剩余人数
		$tuanrenshu = A("Method")->_getzituandingdan($_REQUEST['chanpinID']);
		$this->assign("tuanrenshu",$tuanrenshu);
		$this->assign("dingdanlist",$dingdanlist);
		$this->display('zituandingdan');
	}
	
	
	
	
	public function zituantuanyuan() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		A("Method")->showDirectory("子团产品");
		$this->assign("markpos",'团员名单');
		$chanpinID = $_REQUEST['chanpinID'];
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
		$this->assign("zituan",$zituan);
		$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		$ViewDingdan = D("ViewDingdan");
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->order("time desc")->where("`parentID` = '$_REQUEST[chanpinID]' AND `status` != '-1'")->findall();
		$this->assign("dingdanlist",$dingdanlist);
		//dump($dingdanlist);
		//统计
		$Chanpin = D("Chanpin");
		$baomingrenshu = 0;
		$dingdanlist = $Chanpin->relation("dingdanlist")->where("`chanpinID` = '$chanpinID'")->find();
		foreach($dingdanlist['dingdanlist'] as $dd){
			$baomingrenshu += $dd['chengrenshu'] + $dd['ertongshu'] + $dd['lingdui_num'];
		}
		$this->assign("dingdan_num",count($dingdanlist['dingdanlist']));
		$this->assign("tuanyuan_num",$baomingrenshu);
		
		$this->display('zituantuanyuan');
	}
	
	
	
	public function _tuanyuan_exports() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		A("Method")->_data_exports($_REQUEST['chanpinID'],$_REQUEST['type']);
		
	}
	
	
	
	public function zituanfenfang() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		A("Method")->showDirectory("子团产品");
		$this->assign("markpos",'分房安排');
		$chanpinID = $_REQUEST['chanpinID'];
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
		$this->assign("zituan",$zituan);
		$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		$ViewFenfang = D("ViewFenfang");
		$dingdanlist = $ViewFenfang->relation("renyuanlist")->order("time desc")->where("`parentID` = '$chanpinID' AND `status` != '-1'")->findall();
		$DataCD = D("DataCD");
		$i =0;
		$j =0;
		foreach($dingdanlist as $v){
			foreach($v['renyuanlist'] as $vol){
				$dat = $DataCD->where("`id` = '$vol[datacdID]'")->find();
				$dingdanlist[$i]['renyuanlist'][$j]['renyuan'] = $dat;
				$j++;
			}
			$i++;
		}
		$this->assign("dingdanlist",$dingdanlist);
		
		//统计
		$ViewDingdan = D("ViewDingdan");
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->order("time desc")->where("`parentID` = '$chanpinID' AND `status` != '-1'")->findall();
		$DataCR = D("DataCR");
		$i = 0;
		foreach($dingdanlist as $v){
			foreach($v['tuanyuanlist'] as $vol){
				if($DataCR->where("`datacdID` = '$vol[id]'")->find())
				$tuanyuan_in[$i] = $vol;
				else
				if(!$DataCR->where("`datacdID` = '$vol[id]'")->find())
				$tuanyuan_out[$i] = $vol;
				$tuanyuan_all[$i] = $vol;
				$i++;
			}
		}
		$this->assign("tuanyuan_in",count($tuanyuan_in));
		$this->assign("tuanyuan_out",count($tuanyuan_out));
		$this->assign("tuanyuan_all",count($tuanyuan_all));
		
		if($_REQUEST['export'] == 1){
			//导出Word必备头
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . '分房安排--'.$zituan['title_copy'] . ".doc");
			header("Pragma:no-cache");        
			header("Expires:0");  
			$this->display('exports_fenfang');
		}
		else
		$this->display('zituanfenfang');
	
	
	
	}
	
	
	
	public function dopostfenfang() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['parentID'],'子团','管理');
		if(false === $tuan){
			$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
		}
		$data = $_REQUEST;
		$data['fenfang'] = $data;
		$Chanpin = D("Chanpin");
		if( false !== $Chanpin->relation("fenfang")->myRcreate($data)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}else
			$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
	
	}
	
	
	


    public function select_tuanyuan() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['zituanID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		$chanpinID = $_REQUEST['zituanID'];
		$fenfangID = $_REQUEST['fenfangID'];
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
		$this->assign("zituan",$zituan);
		$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		$ViewDingdan = D("ViewDingdan");
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->order("time desc")->where("`parentID` = '$chanpinID' AND `status` != '-1'")->findall();
		$DataCR = D("DataCR");
		$i = 0;
		foreach($dingdanlist as $v){
			foreach($v['tuanyuanlist'] as $vol){
				if($DataCR->where("`datacdID` = '$vol[id]' and `fenfangID` = '$fenfangID'")->find())
				$tuanyuan_in[$i] = $vol;
				else
				if(!$DataCR->where("`datacdID` = '$vol[id]'")->find())
				$tuanyuan_out[$i] = $vol;
				$i++;
			}
		}
		$tuanyuan_in = array_values($tuanyuan_in);
		$tuanyuan_out = array_values($tuanyuan_out);
		$this->assign("tuanyuan_in",$tuanyuan_in);
		$this->assign("tuanyuan_out",$tuanyuan_out);
		
		
		$this->assign("tuanyuanlist",$tuanyuanlist);
		
		
		$this->assign("dingdanlist",$dingdanlist);
		$this->display('select_tuanyuan');
		
    }

	
	
	public function dopostselect_tuanyuan() {
		C('TOKEN_ON',false);
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['zituanID'],'子团','管理');
		if(false === $tuan){
			$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
		}
		
		$DataCR = D("DataCR");
		$DataCR->startTrans();
		$DataCR->where("`fenfangID` = '$_REQUEST[fenfangID]'")->delete();
		foreach($_REQUEST['datacdID'] as $v){
			$dat['fenfangID'] = $_REQUEST['fenfangID'];
			$dat['datacdID'] = $v;
			if( false === $DataCR->mycreate($dat)){
				$DataCR->rollback();
				$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
			}
		}
		$DataCR->commit();
		$this->ajaxReturn($_REQUEST, '保存成功！', 1);
	}
	
	
	
	
	public function zituanplan() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		A("Method")->showDirectory("子团产品");
		$this->assign("markpos",$_REQUEST['marktype']);
		$chanpinID = $_REQUEST['chanpinID'];
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituan['chutuantongzhi'] = unserialize($zituan['chutuantongzhi']);
		$zituan['jiedaijihua'] = unserialize($zituan['jiedaijihua']);
		$this->assign("zituan",$zituan);
		$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		if($_REQUEST['marktype'] == '出团通知')
		$this->display('chutuantongzhi');
		if($_REQUEST['marktype'] == '接待计划')
		$this->display('jiedaijihua');
	}
	
	
	public function dopostzituanplan() {
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data['chanpinID'] = $_REQUEST['chanpinID'];
		if($_REQUEST['typemark'] == '接待计划')
		$data['zituan']['jiedaijihua'] = serialize($_REQUEST);
		if($_REQUEST['typemark'] == '出团通知')
		$data['zituan']['chutuantongzhi'] = serialize($_REQUEST);
		if (false !== $Chanpin->relation("zituan")->myRcreate($data)){
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	
	
	public function sendzituanplan() {
		C('TOKEN_ON',false);
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		//生成消息及提示
		$dataOMlist = A('Method')->_getDataOM($zituan['parentID'],'线路');
		$ViewShoujia = D("ViewShoujia");
		$shoujialist = $ViewShoujia->order("time desc")->where("`parentID` = '$zituan[parentID]' AND `status` != '-1'")->findall();
		foreach($shoujialist as $v){
			$omtemp = A('Method')->_getDataOM($v['chanpinID'],'售价');
			$dataOMlist = NF_combin_unique($dataOMlist,$omtemp);
		}
		$url = SITE_INDEX.'Chanpin/zituanxinxi/typemark/'.$_REQUEST['typemark'].'/chanpinID/'.$_REQUEST['chanpinID'];
		$message = '《'.$zituan['title_copy'].'/'.$zituan['chutuanriqi'].'》'.'的'.$_REQUEST['typemark'];
		A("Method")->_setMessageHistory($_REQUEST['chanpinID'],'子团',$message,$url,$dataOMlist);
		$this->ajaxReturn($_REQUEST, '发送成功！', 1);
	}
	
	
	
	
	public function zituandanxiangfuwu() {
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		A("Method")->showDirectory("子团产品");
		$this->assign("markpos",'单项服务及补账');
		$chanpinID = $_REQUEST['chanpinID'];
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
		$this->assign("zituan",$zituan);
		$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		//
		$ViewBaozhang = D("ViewBaozhang");
		$baozhanglist = $ViewBaozhang->order("time desc")->where("`parentID` = '$chanpinID' AND `status` != '-1'")->findall();
		$i = 0;
		foreach($baozhanglist as $v){
			$baozhanglist[$i]['datatext'] = unserialize($v['datatext']);
			$i++;
		}
		$this->assign("baozhanglist",$baozhanglist);
		$this->display('zituandanxiangfuwu');
	}
	
	
	
	
	public function dopost_zituanbaozhang() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data = $_REQUEST;
		$data['baozhang'] = $data;
		$data['baozhang']['datatext'] = serialize($data);
		$baozhang = $Chanpin->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		if($baozhang['islock'] == '已锁定' )
			$this->ajaxReturn($_REQUEST,'错误，报账单已经锁定，无法修改报账项！', 0);
		if (false !== $Chanpin->relation("baozhang")->myRcreate($data)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			//生成OM
			if($Chanpin->getLastmodel() == 'add'){
				$i = 0;
				foreach($durlist as $v){
					$dataOMlist[$i]['DUR'] = $v['departmentID'].','.$v['rolesID'].','.$v['userID'];
					$i++;
				}
				//附加开放给部门角色
				foreach($durlist as $v){
					$dataOMlist[$i]['DUR'] = $v['departmentID'].','.$v['rolesID'].',';
					$i++;
				}
				A("Method")->_createDataOM($_REQUEST['chanpinID'],'报账单','管理',$dataOMlist);
			}
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	
	public function zituanbaozhang() {
		A("Method")->showDirectory("子团产品");
		$this->assign("markpos",'单项服务');
		$baozhangID = $_REQUEST['baozhangID'];
		$ViewBaozhang = D("ViewBaozhang");
		$baozhang = $ViewBaozhang->relation("baozhangitemlist")->where("`chanpinID` = '$baozhangID'")->find();
		$baozhang['datatext'] = unserialize($baozhang['datatext']);
		$this->assign("baozhang",$baozhang);
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$baozhang[parentID]'")->find();
		$this->assign("zituan",$zituan);
		$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($zituan['chanpinID'],'子团','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		
		//shenhe
		//检查OM
		if(false !== $tuan){
			if(A('Method')->_checkShenhe('报账项',2))
			$this->assign("root_shenqing",true);
			else
			$this->assign("root_shenqing2",true);
			if(A('Method')->_checkShenhe('报账单',2))
			$this->assign("shenqing_baozhangdan",true);
			else
			$this->assign("shenqing_baozhangdan2",true);
		}
		$this->assign("baozhang_data",$baozhang);
		if($_REQUEST['doprint'] == '计调打印' || $_REQUEST['doprint'] == '打印' || $_REQUEST['export'] == 1){
			if($baozhang['status'] == '批准'){
				$DataCopy = D("DataCopy");
				$data = $DataCopy->where("`dataID` = '$baozhangID' and `datatype` = '报账单'")->order("id desc")->find();
				$newdata = unserialize($data['copy']);
				$baozhang = $newdata['baozhang'];
				$baozhang['datatext'] = unserialize($baozhang['datatext']);
				$baozhang['baozhangitemlist'] = $newdata['baozhangitem'];
				$this->assign("baozhang",$baozhang);
				$ViewTaskShenhe = D("ViewTaskShenhe");
				$task = $ViewTaskShenhe->where("`systemID` = '$data[taskID]' or `parentID` = '$data[taskID]' and `status` != '待检出'")->order("time asc")->findall();
			}
			else{
				$ViewTaskShenhe = D("ViewTaskShenhe");
				$task = $ViewTaskShenhe->where("`dataID` = '$baozhangID' and `datatype` = '报账单' and `status` != '待检出'")->order("time asc ")->findall();
			}
			$this->assign("task",$task);
			if($_REQUEST['doprint']){
				$this->display('print_danxiangfuwu');
			}
			else
				if($_REQUEST['export']){
				//导出Word必备头
				header("Content-type:application/msword");
				header("Content-Disposition:attachment;filename=" . $baozhang['type'].'结算报告'.'--'.$baozhang['title'] . ".doc");
				header("Pragma:no-cache");        
				header("Expires:0");  
				$this->display('print_danxiangfuwu');
			}
		}
		else
		$this->display('zituanbaozhang');
	}
	
	
	
	public function dopost_baozhangitem() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		if($_REQUEST['dotype'] == 'setprint'){
			$item = $Chanpin->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
			$baozhang = $Chanpin->where("`chanpinID` = '$item[parentID]'")->find();
			$data['chanpinID'] = $_REQUEST['chanpinID'];
			$data['baozhangitem']['is_print'] = $_REQUEST['is_print'];
		}
		else{
			$baozhang = $Chanpin->where("`chanpinID` = '$_REQUEST[parentID]'")->find();
			$data = $_REQUEST;
			$data['baozhangitem'] = $_REQUEST;
			if($_REQUEST['chanpinID'])
				unset($data['baozhangitem']['type']);
			if($baozhang['islock'] == '已锁定' )
				$this->ajaxReturn($_REQUEST,'错误，报账单已经锁定，无法修改报账项！', 0);
		}
		if(!$data['chanpinID']){
			//判断计调角色
			$durlist = A("Method")->_checkRolesByUser('计调,经理');
			if (false === $durlist)
				$this->ajaxReturn('', '没有计调或经理权限发布', 0);
		}
		else{
			//检查OM
			$xianlu = A('Method')->_checkDataOM($baozhang['parentID'],'子团','管理');
			if(false === $xianlu)
				$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		}
		
		if (false !== $Chanpin->relation('baozhangitem')->myRcreate($data)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			//生成OM
			if($Chanpin->getLastmodel() == 'add'){
				$i = 0;
				foreach($durlist as $v){
					$dataOMlist[$i]['DUR'] = $v['departmentID'].','.$v['rolesID'].','.$v['userID'];
					$i++;
				}
				//附加开放给部门角色
				foreach($durlist as $v){
					$dataOMlist[$i]['DUR'] = $v['departmentID'].','.$v['rolesID'].',';
					$i++;
				}
				A("Method")->_createDataOM($_REQUEST['chanpinID'],'报账项','管理',$dataOMlist);
			}
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
		
		
		
	public function deleteBaozhangitem() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data['chanpinID'] = $_REQUEST['chanpinID'];
		$item = $Chanpin->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		$baozhang = $Chanpin->where("`chanpinID` = '$item[parentID]'")->find();
		if($baozhang['islock'] == '已锁定' )
			$this->ajaxReturn($_REQUEST,'错误，报账单已经锁定，无法修改报账项！', 0);
		$xianlu = A('Method')->_checkDataOM($baozhang['parentID'],'子团','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		$data['status'] = -1;
		if (false !== $Chanpin->mycreate($data)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
		
	}
	
	
	
	public function deleteBaozhang() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data['chanpinID'] = $_REQUEST['chanpinID'];
		$baozhang = $Chanpin->where("`chanpinID` = '$data[chanpinID]'")->find();
		if($baozhang['islock'] == '已锁定' )
			$this->ajaxReturn($_REQUEST,'错误，报账单已经锁定，无法修改报账项！', 0);
		$xianlu = A('Method')->_checkDataOM($baozhang['parentID'],'子团','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		$data['status'] = -1;
		if (false !== $Chanpin->mycreate($data)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
		
	}
	
	
	
	
	
	
	
	
	
	
	
}
?>