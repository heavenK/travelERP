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
			if($xianlu['guojing'] == '境外' || $xianlu['kind'] == '包团')
				$xianlu['xianlu_ext'] = simple_unserialize($xianlu['xianlu_ext']);
		}
		else{
			//判断计调角色
			$durlist = A("Method")->_checkRolesByUser('计调','组团');
			if(false === $durlist){
				$this->display('Index:error');
				exit;
			}
			$xianlu['chufadi'] = '辽宁,大连';
		}
		//主题
		$ViewDataDictionary = D("ViewDataDictionary");
		$xianlu['theme_all'] = $ViewDataDictionary->order("time desc")->where("`type` = '主题' AND `status_system` = '1'")->findall();
		$this->assign("xianlu",$xianlu);
		$this->assign("datatitle",' : "'.$xianlu['title'].'"');
		//获得个人部门及分类列表
		$bumenfeilei = A("Method")->_getbumenfenleilist('组团');
		$this->assign("bumenfeilei",$bumenfeilei);
		//部门列表
		$bumenall = A("Method")->_getDepartmentList();
		$this->assign("bumenall",$bumenall);
		$this->display('fabu');
	}
	
	
	public function dopostfabu() {
		$Chanpin = D("Chanpin");
		$_REQUEST['xianlu'] = $_REQUEST;
		if(!$_REQUEST['departmentID'])
			A("Method")->ajaxUploadResult($_REQUEST,'您没有权限发布线路类产品！',0);
		//修改已有
		if($_REQUEST['chanpinID']){
			//检查dataOM
			$xianlu = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'线路','管理');
			if(false === $xianlu)
				$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
			$xianlu = $Chanpin->relation("xianlu")->find($_REQUEST['chanpinID']);
			$_REQUEST['xianlu']['kind'] = $xianlu['xianlu']['kind'];
			$_REQUEST['xianlu']['guojing'] = $xianlu['xianlu']['guojing'];
			$zituanlist = $Chanpin->relationGet("zituanlist");
			$ViewBaozhang = D('ViewBaozhang');
			foreach($zituanlist as $z){
				//判断子团报账单
				$bzdall = $ViewBaozhang->where("`parentID` = '$z[chanpinID]' AND (`status_system` = '1')")->findall();
				foreach($bzdall as $b){
					if($b['status_shenhe'] == '批准'){
						$this->ajaxReturn($_REQUEST, '部门子团已经报账，禁止修改线路信息！！！', 0);
					}
				}
			}
		}
		else{
			//判断计调角色,返回用户DUR
			$durlist = A("Method")->_checkRolesByUser('计调','组团');
			if (false === $durlist)
				$this->ajaxReturn('', '没有计调权限！', 0);
			$_REQUEST['xianlu']['kind'] = $_REQUEST['kind'];
			$_REQUEST['xianlu']['guojing'] = $_REQUEST['guojing'];
		}
		//检查
		if(!$_REQUEST['chufashengfen'] || !$_REQUEST['chufachengshi'])
			$this->ajaxReturn($_REQUEST,'错误,出发地不能为空！', 0);
		if($_REQUEST['xianlu']['guojing'] == "国内")
		if(!$_REQUEST['daqu'] || !$_REQUEST['shengfen'] || !$_REQUEST['chengshi'])
			$this->ajaxReturn($_REQUEST,'错误,目的地不能为空！', 0);
		if($_REQUEST['xianlu']['guojing'] == "境外")
		if(!$_REQUEST['mudidi'])
			$this->ajaxReturn($_REQUEST,'错误,目的地不能为空！', 0);
			
		//数据处理
		if($_REQUEST['xianlu']['guojing'] == "国内")
		$_REQUEST['xianlu']['mudidi'] = $_REQUEST['daqu'].','.$_REQUEST['shengfen'].','.$_REQUEST['chengshi'];
		$_REQUEST['xianlu']['chufadi'] = $_REQUEST['chufashengfen'].','.$_REQUEST['chufachengshi'];
		$_REQUEST['xianlu']['daoyoufuwu'] = $_REQUEST['daoyoufuwu'][0].','.$_REQUEST['daoyoufuwu'][1];
		$_REQUEST['xianlu']['ischild'] = $_REQUEST['ischild'] ? 1 : 0;
		if($_REQUEST['xianlu']['guojing'] == "境外" && $_REQUEST['xianlu']['kind'] != "包团"){
			$xianlu_ext['feiyongyes'] = $_REQUEST['feiyongyes'];
			$xianlu_ext['feiyongno'] = $_REQUEST['feiyongno'];
			$xianlu_ext['qianzhengxinxi'] = $_REQUEST['qianzhengxinxi'];
			$xianlu_ext['kexuanzifei'] = $_REQUEST['kexuanzifei'];
			$xianlu_ext['gouwuxinxi'] = $_REQUEST['gouwuxinxi'];
			$xianlu_ext['yudingtiaokuan'] = $_REQUEST['yudingtiaokuan'];
			$xianlu_ext['chuxingjingshi'] = $_REQUEST['chuxingjingshi'];
			$_REQUEST['xianlu']['xianlu_ext'] = serialize($xianlu_ext);
		}
		if($_REQUEST['xianlu']['kind'] == "包团"){
			$xianlu_ext['baotuandanwei'] = $_REQUEST['baotuandanwei'];
			$xianlu_ext['quanpei'] = $_REQUEST['quanpei'];
			$xianlu_ext['adultprice'] = $_REQUEST['adultprice'];
			$xianlu_ext['childprice'] = $_REQUEST['childprice'];
			$xianlu_ext['zongjia'] = $_REQUEST['zongjia'];
			$xianlu_ext['remark'] = $_REQUEST['remark'];
			$_REQUEST['xianlu']['xianlu_ext'] = serialize($xianlu_ext);
		}
		//dump($_REQUEST);
		//end
		if (false !== $Chanpin->relation("xianlu")->myRcreate($_REQUEST)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			//生成OM
			if($Chanpin->getLastmodel() == 'add'){
				$dataOMlist = A("Method")->_setDataOMlist('计调','组团','',$_REQUEST['xianlu']['guojing']);
				A("Method")->_createDataOM($_REQUEST['chanpinID'],'线路','管理',$dataOMlist);
			}
			//自动申请审核
			$_REQUEST['dataID'] = $_REQUEST['chanpinID'];
			$_REQUEST['dotype'] = '申请';
			$_REQUEST['datatype'] = '线路';
			$_REQUEST['title'] = $_REQUEST['xianlu']['title'];
			A("Method")->_autoshenqing();
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
		C('TOKEN_ON',false);
//		$this->ajaxReturn('', '功能未开启', 0);
		$chanpinID = $_REQUEST['chanpinID'];
		$parentID = $_REQUEST['parentID'];
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($parentID,'线路');
		if(false === $xianlu){
			$this->display('Index:error');
			exit;
		}
		$Chanpin = D("Chanpin");
		$Chanpin->startTrans();
		$ViewZituan = D("ViewZituan");
		$ViewBaozhang = D("ViewBaozhang");
		$chanp = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
		if($chanp['status_baozhang'] == '批准'){
			$Chanpin->rollback();
			$this->ajaxReturn($_REQUEST,'该团已经报账，不能删除！！！', 0);
		}
		else{
			$bzd = $ViewBaozhang->relation("baozhangitemlist")->where("`parentID` = '$chanpinID'")->find();
			foreach($bzd['baozhangitemlist'] as $vol){
				if($vol['status_shenhe'] == '批准'){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'该团已经开始报账，报账项目已审核，不能删除！！！', 0);
				}
			}
		}
		//保存
		$dat['chanpinID'] = $chanpinID;
		$dat['status_system'] = -1;
		if (false !== $Chanpin->save($dat)){
//			if(A("Method")->shengchengzituan_2($parentID)){
				$Chanpin->commit();
				$this->ajaxReturn('', '删除成功！', 1);
//			}
		}
		else{
			$Chanpin->rollback();
			$this->ajaxReturn('', $Chanpin->getError(), 0);
		}
	}
	
	
	public function xingcheng()
	{
		A("Method")->showDirectory("行程");
		$chanpinID = $_REQUEST["chanpinID"];
		$Chanpin = D("Chanpin");
		$chanpin = $Chanpin->relation('xianlu')->where("`chanpinID` = '$chanpinID'")->find();
		$xingcheng = $Chanpin->relationGet("xingchenglist");
		//行程一
		$ViewXianlu = D("ViewXianlu");
		$xianlu = $ViewXianlu->where("`chanpinID` = '$chanpinID'")->find();
		$datatext = simple_unserialize($xianlu['datatext']);
		$xingcheng_1 = $datatext['xingcheng'];
		$this->assign("xingcheng_1",$xingcheng_1);
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
		//更新行程一到线路
		$ViewXianlu = D("ViewXianlu");
		$xianlu = $ViewXianlu->where("`chanpinID` = '$_REQUEST[parentID]'")->find();
		$daat['chanpinID'] = $xianlu['chanpinID'];
		$daat['xianlu']['datatext'] = simple_unserialize($xianlu['datatext']);
		$daat['xianlu']['datatext']['xingcheng'] = $_REQUEST['xingcheng'];
		$daat['xianlu']['datatext'] = serialize($daat['xianlu']['datatext']);
		if (false === $Chanpin->relation('xianlu')->myRcreate($daat))
		$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
		
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
		$chengbenlist = $ViewDataDictionary->order("time desc")->where("`type` = '成本' AND `status_system` = '1'")->findall();
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
		C('TOKEN_ON',false);
		$chanpinID = $_REQUEST['chanpinID'];
		$Chanpin = D("Chanpin");
//		$ViewChengben = D("ViewChengben");
//		$cb = $ViewChengben->where("`chanpinID` = '$chanpinID'")->find();
		$cb = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
		$cb['status_system'] = -1;
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($cb['parentID'],'线路','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		if (false !== $Chanpin->save($cb)){
			$this->ajaxReturn('', '删除成功！', 1);
			
		}
		else
			$this->ajaxReturn('', $Chanpin->getError(), 0);
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
		$ViewXianlu = D("ViewXianlu");	
		$xianlu = $ViewXianlu->where("`chanpinID` = '$_REQUEST[parentID]'")->find();
		if($xianlu['status'] == '截止')
			$this->ajaxReturn($_REQUEST, '该线路已经截止，不能开放销售！', 0);
		if (false !== $Chanpin->relation("shoujia")->myRcreate($data)){
			//同步售价表线路状态
			A("Method")->_tongbushoujia($_REQUEST['parentID']);
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
	
	
	
	public function left_fabu($htmltp='',$pagetype='') {
		$ViewDepartment = D("ViewDepartment");
		$where['type'] = array('like','%联合体%');
		$bumenlist = $ViewDepartment->where($where)->findall();
		$this->assign("bumenlist",$bumenlist);
		$zutuanlist = $ViewDepartment->where("`type` like '%组团%' and `type` not like '%联合体%' and `type` not like '%办事处%'")->findall();
		$this->assign("zutuanlist",$zutuanlist);
		$this->assign("pagetype",$pagetype);
		$this->display('Chanpin:'.$htmltp);
	}
	
	public function header_chanpin() {
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			//判断子团
			$Chanpin = D("Chanpin");
			$tem_cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
			$this->assign("tem_cp",$tem_cp);
			$zituan = $Chanpin->where("`parentID` = '$chanpinID' and `marktype` = 'zituan'")->find();
			if($zituan)
				$this->assign("showzituan",true);
		}
		$this->display('header_chanpin');
	}
	
	
	
	public function header_kongguan() {
		$chanpinID = $_REQUEST["chanpinID"];
		$Chanpin = D("Chanpin");
		if($_REQUEST['type'] == '团队报账单'){
			$tem_cp = $Chanpin->relation("tdbzdlist")->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
			$tem_cp = $tem_cp['tdbzdlist'];
		}
		elseif($_REQUEST['baozhangID']){
			$tem_cp = $Chanpin->where("`chanpinID` = '$_REQUEST[baozhangID]'")->find();
		}
		else	
		$tem_cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
		$this->assign("tem_cp",$tem_cp);
		$this->display('Chanpin:header_kongguan');
	}
	
	
	
	public function doshenhe() {
		//判断角色
		$durlist = A("Method")->_checkRolesByUser('计调','组团');
		if (false === $durlist)
			$this->ajaxReturn('', '没有计调权限！', 0);
		A("Method")->_doshenhe();
	}
	
	
	
	public function shenhe() {
		A("Method")->showDirectory("产品审核");
		$datalist = A("Method")->_shenhe('子团');
		$i = 0;
		foreach($datalist['chanpin'] as $v){
			$datalist['chanpin'][$i]['datatext_copy'] = simple_unserialize($v['datatext_copy']);
			$i++;
		}
		$this->assign("chanpin_list",$datalist['chanpin']);
		$this->assign("chanpin_mark",'Chanpin');
		$this->display('shenhe');
	}
	
	
	
	public function kongguan() {
		A("Method")->_zituanlist('产品搜索');	
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
		$zituan['xianlulist'] = simple_unserialize($data['copy']);
		$zituan['xianlulist']['xianlu']['xianlu_ext'] = simple_unserialize($zituan['xianlulist']['xianlu']['xianlu_ext']);
		$zituan['xianlulist']['shoujia'] = A("Method")->_fenlei_filter($zituan['xianlulist']['shoujia']);
		$this->assign("zituan",$zituan);
		$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		$title = $_REQUEST['typemark'].'--'.$zituan['title_copy'].'--'.$zituan['chutanriqi'];
		//行程一
		$datatext = simple_unserialize($zituan['xianlulist']['xianlu']['datatext']);
		$xingcheng_1 = $datatext['xingcheng'];
		$this->assign("xingcheng_1",$xingcheng_1);
		if($_REQUEST['export'] == 1){
			//导出Word必备头
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . $title . ".doc");
			header("Pragma:no-cache");        
			header("Expires:0"); 
		}
		if($_REQUEST['typemark'] == '接待计划' || $_REQUEST['typemark'] == '出团通知'){
			$ViewDingdan = D("ViewDingdan");
			$dingdanlist = $ViewDingdan->order("time desc")->where("`parentID` = '$zituan[chanpinID]' and `status` = '确认' AND `status_system` = '1'")->findall();
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
			$zituan['jiedaijihua'] = simple_unserialize($zituan['jiedaijihua']);
			$this->assign("zituan",$zituan);
			$this->display('print_jiedaijihua');
		}
		else if($_REQUEST['typemark'] == '出团通知'){
			$zituan['chutuantongzhi'] = simple_unserialize($zituan['chutuantongzhi']);
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
		$zituan = $Chanpin->where("`chanpinID` = '$data[chanpinID]'")->find();
		if($zituan['status_baozhang'] == '批准'){
			$this->ajaxReturn($_REQUEST, '失败，该团队已经报账不能再修改信息！！', 0);
		}
		if( false !== $Chanpin->relation("zituan")->myRcreate($data)){
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
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
		$dingdanlist = $ViewDingdan->order("time desc")->where("`parentID` = '$_REQUEST[chanpinID]' AND `status_system` = '1'")->findall();
		$ViewDataDictionary = D("ViewDataDictionary");
		$DataCD = D("DataCD");
		$i = 0;
		foreach($dingdanlist as $v){
		//提成数据
			$dingdanlist[$i]['ticheng'] = $ViewDataDictionary->where("`systemID` = '$v[tichengID]'")->find();
		//新老客户数
			$dingdanlist[$i]['xinkehu_num'] = $DataCD->where("`dingdanID` = '$v[chanpinID]' and `laokehu` = '0'")->count();
			$dingdanlist[$i]['laokehu_num'] = $DataCD->where("`dingdanID` = '$v[chanpinID]' and `laokehu` = '1'")->count();
			$i++;
		}
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
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->order("time desc")->where("`parentID` = '$_REQUEST[chanpinID]' AND `status_system` = '1' and `status` = '确认'")->findall();
		$i = 0;
		$j = 0;
		foreach($dingdanlist as $v){
			foreach($v['tuanyuanlist'] as $vol){
				$cus = simple_unserialize($vol['datatext']);
				$dingdanlist[$i]['tuanyuanlist'][$j] = array_merge($dingdanlist[$i]['tuanyuanlist'][$j],$cus);
				$j++;
			}
			$i++;
		}
		$this->assign("dingdanlist",$dingdanlist);
		//统计
		$baomingrenshu = 0;
		foreach($dingdanlist as $dd){
			$baomingrenshu += $dd['chengrenshu'] + $dd['ertongshu'] + $dd['lingdui_num'];
		}
		$this->assign("dingdan_num",count($dingdanlist));
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
		$dingdanlist = $ViewFenfang->relation("renyuanlist")->order("time desc")->where("`parentID` = '$chanpinID' AND `status_system` = '1'")->findall();
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
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->order("time desc")->where("`parentID` = '$chanpinID' AND `status_system` = '1'")->findall();
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
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->order("time desc")->where("`parentID` = '$chanpinID' AND `status_system` = '1'")->findall();
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
			if(false === $DataCR->mycreate($dat)){
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
		$zituan['chutuantongzhi'] = simple_unserialize($zituan['chutuantongzhi']);
		$zituan['jiedaijihua'] = simple_unserialize($zituan['jiedaijihua']);
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
		$shoujialist = $ViewShoujia->order("time desc")->where("`parentID` = '$zituan[parentID]' AND `status_system` = '1'")->findall();
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
		A("Method")->_tuandanxiangfuwu('子团');
		$this->display('zituandanxiangfuwu');
	}
	
	public function dopost_baozhang() {
		A("Method")->dosavebaozhang('子团');
	}
	
	public function zituanbaozhang() {
		A("Method")->showDirectory("签证及票务");
		$this->assign("actionmethod",'Chanpin');
		if(!$_REQUEST['chanpinID'])
			A("Method")->_baozhang();
		else
			A("Method")->_baozhang('子团');
	}
	
	public function deleteBaozhang() {
		A("Method")->_deleteBaozhang();
	}
	
	public function dopost_baozhangitem() {
		A("Method")->_dosavebaozhangitem('子团');
	}
		
	public function deleteBaozhangitem() {
		A("Method")->_deleteBaozhangitem();
	}
	
	public function zituanxiangmu() {
		A("Method")->_xiangmu('子团');
		$this->display('zituanxiangmu');
	}
	
	public function getBaozhangitem() {
		A("Method")->_getBaozhangitem();
	}
	
	public function shenheback() {
		A("Method")->_shenheback();
	}
	
	
	public function danxiangfuwu() {
		//判断计调角色
		$durlist = A("Method")->_checkRolesByUser('计调','组团');
		if(false === $durlist){
			$durlist = A("Method")->_checkRolesByUser('票务','业务');
			if(false === $durlist){
				$this->display('Index:error');
				exit;
			}
		}
		A("Method")->_danxiangfuwu('组团');
	}
	
	public function doposttiaojia() {
		C('TOKEN_ON',false);
		$itemlist = $_REQUEST['checkboxitem'];
		$itemlist = explode(',',$itemlist);
		$Chanpin = D("Chanpin");
		foreach($itemlist as $v){
			//检查dataOM
			$xianlu = A('Method')->_checkDataOM($v,'子团');
			if(false === $xianlu){
				$mark = 1;
				continue;
			}
			$dat['chanpinID'] = $v;
			$dat['zituan']['adultxiuzheng'] = $_REQUEST['adultxiuzheng'];
			$dat['zituan']['childxiuzheng'] = $_REQUEST['childxiuzheng'];
			$Chanpin->relation("zituan")->myRcreate($dat);
		}
		if($mark == 1)
			$this->ajaxReturn($_REQUEST,'完成！,一部分团队您没有操作权限！无法进行修改！！', 1);
		$this->ajaxReturn($_REQUEST,'完成！', 1);
	}
	
	
	
	public function customer(){
		A("Method")->showDirectory("游客管理");
		$chanpin_list = A('Method')->data_list_noOM('ViewCustomer',$_REQUEST);
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('customer');
	}
	
	
	
    public function customer_info() {
		A("Method")->showDirectory("团员信息");
		$ViewCustomer = D("ViewCustomer");
		$dat = $ViewCustomer->where("`systemID` = '$_REQUEST[systemID]'")->find();
		$this->assign("data",$dat);
		$this->display('customer_info');
	}
	
	
    public function dopostcustomer_info() {
		C('TOKEN_ON',false);
		$systemID = $_REQUEST['systemID'];
		$data = $_REQUEST;
		$data['customer'] = $_REQUEST;
		$ViewCustomer = D("ViewCustomer");
		$cust = $ViewCustomer->where("`systemID` = '$systemID'")->find();
		$System = D("System");
		if($_REQUEST['sfz_haoma']){
			$tempcust = $ViewCustomer->where("`sfz_haoma` = '$_REQUEST[sfz_haoma]'")->find();
			if($tempcust && $systemID!=$tempcust['systemID'])
				$this->ajaxReturn('', '错误！身份证与已有其他用户冲突！！', 0);
		}
		if($_REQUEST['hz_haoma']){
			$tempcust = $ViewCustomer->where("`hz_haoma` = '$_REQUEST[hz_haoma]'")->find();
			if($tempcust && $systemID!=$tempcust['systemID'])
				$this->ajaxReturn('', '错误！护照与已有其他用户冲突！！', 0);
		}
		if($_REQUEST['txz_haoma']){
			$tempcust = $ViewCustomer->where("`sfz_haoma` = '$_REQUEST[txz_haoma]'")->find();
			if($tempcust && $systemID!=$tempcust['systemID'])
				$this->ajaxReturn('', '错误！通行证与已有其他用户冲突！！', 0);
		}
		if (false !== $System->relation('customer')->myRcreate($data)){
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	
	
	
	//添加订单
    public function zituanbaoming() {
		A("Method")->_zituanbaoming('计调');	
	}
	
	
	
    public function copytonew() {
		A('Method')->_copytonew('线路');
	}
	
	
	
    public function jiezhiorbaoming() {
		if($_REQUEST['datatype'])
		A('Method')->_jiezhiorbaoming($_REQUEST['datatype']);
		else
		A('Method')->_jiezhiorbaoming('线路');
	}
	
	
	public function tongji() {
		A("Method")->showDirectory("统计");
		//搜索
		if($_REQUEST['title'])
			$where_unit['title'] = array('like','%'.$_REQUEST['title'].'%');
		if($_REQUEST['listtype'] == '员工'){
			$where['user_name'] = array('like','%'.$_REQUEST['title'].'%');
		}
		$where['status_system'] = 1;
		if($_REQUEST['start_time'] && $_REQUEST['end_time']){
			$where['shenhe_time'] = array('between',strtotime($_REQUEST['start_time']).','.strtotime($_REQUEST['end_time']));	
		}
		else{
			$month = NF_getmonth();
			$fm_forward_month = $month['forward'];
			$where['chutuanriqi'] = array('between',$fm_forward_month.'-01'.','.date("Y-m").'-01');	
			$_REQUEST['start_time'] = $fm_forward_month.'-01';
			$_REQUEST['end_time'] = date("Y-m").'-01';
			$this->assign("start_time",$fm_forward_month.'-01');
			$this->assign("end_time",date("Y-m").'-01');
		}
		if($_REQUEST['departmentID'])
			$where['departmentID'] = $_REQUEST["departmentID"];
		$ViewDataDictionary = D("ViewDataDictionary");
		
		//获得用户权限，部门列表
		$ViewDepartment = D("ViewDepartment");
		$role = A("Method")->_checkRolesByUser('网管,总经理,出纳,会计,财务,财务总监','行政');
		if($role){
			$unitdata = $ViewDepartment->where("`type` like '%组团%'")->findall();
		}
		else{
			$role = A("Method")->_checkRolesByUser('经理','组团');
			if(!$role)
				exit;
			$i = 0;
			foreach($role as $v){
				$unitdata[$i] = $ViewDepartment->where("`systemID` = '$v[bumenID]'")->find();
				$i++;
			}
			$unitdata = about_unique($unitdata);
		}
		//部门列表
		if($_REQUEST["departmentID"]){
			foreach($unitdata as $b){
				if($b['systemID'] == $_REQUEST["departmentID"])
				$newdata[0] = $b;
			}
			$unitdata = $newdata;
		}
		//end
		//总体统计。
		$ViewZituan = D("ViewZituan");
		$ViewDingdan = D("ViewDingdan");
		$ViewBaozhang = D("ViewBaozhang");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$i = 0;
		foreach($unitdata as $v){
			$where['departmentID'] = $v['systemID'];
			$tuanall = $ViewZituan->where($where)->findall();
			foreach($tuanall as $vol){
				$zituanall[$i] = $vol;
				$i++;
			}
		}
		$i = 0;
		foreach($zituanall as $v){
			$tongji['tuanshu'] += 1;
			$tongji['jihua_renshu'] += $v['renshu'];
			$queren_renshu = 0;
			$zhanwei_renshu = 0;
			$houbu_renshu = 0;
			$dingdan_renshu = 0;
			$yingfu = 0;
			$yingshou = 0;
			//订单人数
			$dingdanall = $ViewDingdan->where("`parentID` = '$v[chanpinID]' and `status_system` = 1")->findall();
			foreach($dingdanall as $vol){
				if($vol['status'] == '确认'){
					$tongji['queren_renshu'] += $vol['chengrenshu'] + $vol['ertongshu'];
					$queren_renshu += $vol['chengrenshu'] + $vol['ertongshu'];
				}
				if($vol['status'] == '占位'){
					$tongji['zhanwei_renshu'] += $vol['chengrenshu'] + $vol['ertongshu'];
					$zhanwei_renshu += $vol['chengrenshu'] + $vol['ertongshu'];
				}
				if($vol['status'] == '候补'){
					$tongji['houbu_renshu'] += $vol['chengrenshu'] + $vol['ertongshu'];
					$houbu_renshu += $vol['chengrenshu'] + $vol['ertongshu'];
				}
				$tongji['dingdan_renshu'] += $vol['chengrenshu'] + $vol['ertongshu'];
				$dingdan_renshu += $vol['chengrenshu'] + $vol['ertongshu'];
			}
			//报账单
			$baozhangall = $ViewBaozhang->where("`parentID` = '$v[chanpinID]'")->findall();
			foreach($baozhangall as $vol){
				if($vol['type'] == '团队报账单'){
				  $tongji['baozhang_renshu'] += $vol['renshu'];
				  $baozhang_renshu = $vol['renshu'];
				}
				$itemall = $ViewBaozhangitem->where("`parentID` = '$vol[chanpinID]' and `status_system` = 1")->findall();
				foreach($itemall as $w){
					if($w['type'] == '支出项目'){
						$tongji['yingfu'] += $w['value'];
						$yingfu += $w['value'];
					}
					if($w['type'] == '结算项目'){
						$tongji['yingshou'] += $w['value'];
						$yingshou += $w['value'];
					}
				}
			}
			$zituanall[$i]['queren_renshu'] = $queren_renshu;
			$zituanall[$i]['zhanwei_renshu'] = $zhanwei_renshu;
			$zituanall[$i]['houbu_renshu'] = $houbu_renshu;
			$zituanall[$i]['dingdan_renshu'] = $dingdan_renshu;
			$zituanall[$i]['baozhang_renshu'] = $baozhang_renshu;
			$zituanall[$i]['yingshou'] = $yingshou;
			$zituanall[$i]['yingfu'] = $yingfu;
			$i++;
		}
		$this->assign("tongji",$tongji);
		//分类处理
		//人员统计
		if($_REQUEST['listtype'] == '员工'){
			$this->assign("markpos",$_REQUEST['listtype']);
			//用户列表
			$ViewUser = D("ViewUser");
			$i = 0;
			foreach($unitdata as $v){
				$listarray = A("Method")->_getBumenUserlist($v['systemID']);
				foreach($listarray as $lol){
					$userlist[$i] = $lol;
					$i++;
				}
			}
			$unitdata = about_unique($userlist);
			$unitdata = array_values($unitdata);
			//搜索用户
			if($_REQUEST['title']){
				foreach($unitdata as $tt){
					if($tt['title'] == $_REQUEST['title']){
						$unitdata = null;
						$unitdata[0] = $tt;
						break;
					}
				}
			}
		}
		//end人员统计
		$i = 0;
		foreach($unitdata as $v){
			if($_REQUEST['listtype'] == '员工'){
				$right = $v['title'];
			}
			else{
				$right = $v['systemID'];
			}
			$m = 0;
			foreach($zituanall as $vol){
				if($_REQUEST['listtype'] == '员工'){
					$left = $vol['user_name'];
				}
				else{
					$left = $vol['departmentID'];
				}
				if($left == $right){
					$unitdata[$i]['zituan'][$m] = $vol;
					$unitdata[$i]['jihua_renshu'] += (int)$vol['renshu'];
					$unitdata[$i]['queren_renshu'] += (int)$vol['queren_renshu'];
					$unitdata[$i]['zhanwei_renshu'] += (int)$vol['zhanwei_renshu'];
					$unitdata[$i]['houbu_renshu'] += (int)$vol['houbu_renshu'];
					$unitdata[$i]['dingdan_renshu'] += (int)$vol['dingdan_renshu'];
					$unitdata[$i]['baozhang_renshu'] += (int)$vol['baozhang_renshu'];
					$unitdata[$i]['yingshou'] += (int)$vol['yingshou'];
					$unitdata[$i]['yingfu'] += (int)$vol['yingfu'];
					$m++;
				}
			}
			if($_REQUEST['returntype'] == 'ajax')
				$data = $unitdata[$i]['zituan'];
			$i++;
		}
		$this->assign("unitdata",$unitdata);
		//打印
		if($_REQUEST['doprint'] == 1){
			$this->display('print_yingshou');
			return ;	
		}
		if($_REQUEST['export'] == 1){
			//导出Word
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . $_REQUEST['start_time'].'至'.$_REQUEST['end_time'] . "绩效统计.doc");
			header("Pragma:no-cache");        
			header("Expires:0"); 
			$this->display('print_yingshou');
			return ;	
		}
		
		//返回	
		if($_REQUEST['returntype'] == 'ajax'){
				$str = '
					<table cellpadding="0" cellspacing="0" width="100%" class="list view">
						<tr height="20">
						  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 标题 </div></th>'.$tabtile.'
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 团号 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 出团日期  </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 操作人 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 计划人数 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单人数/确认/占位/候补 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 报账情况 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 报账人数 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 计划应收 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 计划应付 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 盈亏 </div></th>
						</tr>
				';
				$i = 0;
				foreach($data as $v){$i++;
					$str .= '
					<tr class="evenListRowS1">
					  <td>'.$i.'</td>
					  <td><a target="_blank" href="'.SITE_INDEX.'Chanpin/zituanxinxi/chanpinID/'.$v['chanpinID'].'">'.$v['title_copy'].'</a></td>'.$tabvalue.'
					  <td>'.$v['tuanhao'].'</td>
					  <td>'.$v['chutuanriqi'].'</td>
					  <td>'.$v['user_name'].'</td>
					  <td>'.$v['renshu'].'</td>
					  <td>'.$v['dingdan_renshu'].'/'.$v['queren_renshu'].'/'.$v['zhanwei_renshu'].'/'.$v['houbu_renshu'].'</td>
					  <td>'.$v['baozhang_remark'].'</td>
					  <td>'.$v['baozhang_renshu'].'</td>
					  <td>'.number_format($v['yingshou']).'</td>
					  <td>'.number_format($v['yingfu']).'</td>
					  <td>'.number_format($v['yingshou']-$v['yingfu']).'</td>
					</tr>
					';
				}
				$str .= '
					<tr class="evenListRowS1">
					  <td align="right" colspan="3">
					  '.$page.'
					  </td>
					</tr>
					</table>
				';
				$this->ajaxReturn($str, '', 1);
		}
		else{
			$this->display('tongji');
		}
	}
	
    public function deletechanpin() {
		$typevalue = $_REQUEST['typevalue'];
		if(!$typevalue)
			$typevalue = '子团';
		A('Method')->_deletechanpin($typevalue);
	}
	
	
	
    public function resetOM() {
		if(false !== A('Method')->_resetOM())
		$this->ajaxReturn('', '成功！', 1);
	}
	
	
	
	
    public function chaxunma() {
		$chanpinID = $_REQUEST['chanpinID'];
		$Chanpin = D("Chanpin");
		$chanp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
		if(!$chanp)
		echo "查询码对应的产品不存在！！！";
		if($chanp['marktype'] == 'xianlu'){
			redirect(SITE_INDEX."Chanpin/fabu/chanpinID/".$chanpinID);
		}
		if($chanp['marktype'] == 'zituan'){
			redirect(SITE_INDEX."Chanpin/zituanxinxi/chanpinID/".$chanpinID);
		}
		if($chanp['marktype'] == 'Djtuan'){
			redirect(SITE_INDEX."Dijie/fabu/chanpinID/".$chanpinID);
		}
		if($chanp['marktype'] == 'baozhang'){
			$chanp_p = $Chanpin->where("`chanpinID` = '$chanp[parentID]'")->find();
			if($chanp_p['marktype'] == 'zituan')
			redirect(SITE_INDEX."Chanpin/zituanbaozhang/doprint/打印/baozhangID/".$chanpinID);
			if($chanp_p['marktype'] == 'DJtuan')
			redirect(SITE_INDEX."Dijie/zituanbaozhang/doprint/打印/baozhangID/".$chanpinID);
		}
    }
	
	
	
	
	
	
	
	
}
?>