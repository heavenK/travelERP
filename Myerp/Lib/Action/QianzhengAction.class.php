<?php

class QianzhengAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'签证产品');
	}
	
    public function index() {
		A("Method")->showDirectory("签证产品发布及控管");
		$chanpin_list = A('Method')->getDataOMlist('签证','qianzheng',$_REQUEST);
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('index');
    }
	
    public function fabu() {
		A("Method")->showDirectory("签证信息");
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			//检查dataOM
			$qianzheng = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'签证');
			if(false === $qianzheng){
				$this->display('Index:error');
				exit;
			}
			$ViewQianzheng = D('ViewQianzheng');
			$qianzheng = $ViewQianzheng->where("`chanpinID` = '$chanpinID'")->find();
			$this->assign("qianzheng",$qianzheng);
		}
		$this->assign("datatitle",' : "'.$qianzheng['title'].'"');
		//获得个人部门及分类列表
		$bumenfeilei = A("Method")->_getbumenfenleilist('组团');
		$this->assign("bumenfeilei",$bumenfeilei);
		//部门列表
		$bumenall = A("Method")->_getDepartmentList();
		$this->assign("bumenall",$bumenall);
		$this->display();
    }
	
	
	public function dopostfabu() {
		$Chanpin = D("Chanpin");
		$_REQUEST['qianzheng'] = $_REQUEST;
		$_REQUEST['qianzheng']['shoujia'] = 100000;//默认
		$_REQUEST['qianzheng']['ertongshoujia'] = 100000;//默认
		if(!$_REQUEST['departmentID'])
			A("Method")->ajaxUploadResult($_REQUEST,'您没有权限发布签证产品！',0);
		if (false !== $Chanpin->relation("qianzheng")->myRcreate($_REQUEST)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			//生成OM
			if($Chanpin->getLastmodel() == 'add'){
				$dataOMlist = A("Method")->_setDataOMlist('计调','组团');
				A("Method")->_createDataOM($_REQUEST['chanpinID'],'签证','管理',$dataOMlist);
			}
			//自动申请审核
			$_REQUEST['dataID'] = $_REQUEST['chanpinID'];
			$_REQUEST['dotype'] = '申请';
			$_REQUEST['datatype'] = '签证';
			$_REQUEST['title'] = $_REQUEST['qianzheng']['title'];
			A("Method")->_autoshenqing();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	public function header_chanpin() {
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			$Chanpin = D("Chanpin");
			$tem_cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
			$this->assign("tem_cp",$tem_cp);
			$zituan = $Chanpin->where("`parentID` = '$chanpinID' and `marktype` = 'qianzheng'")->find();
		}
		$this->display('header_chanpin');
	}
	
	
	public function doshenhe() {
		//判断角色
		$durlist = A("Method")->_checkRolesByUser('计调','组团');
		if (false === $durlist)
			$this->ajaxReturn('', '没有计调权限！', 0);
		A("Method")->_doshenhe();
	}
	
	
	public function dingdanlist() {
		A("Method")->showDirectory("签证订单");
		$chanpinID = $_REQUEST['chanpinID'];
		//检查dataOM
		$tuan = A('Method')->_checkDataOM($chanpinID,'签证','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		$ViewDingdan = D("ViewDingdan");
		$dingdanlist = $ViewDingdan->order("time desc")->where("`parentID` = '$chanpinID' AND `status_system` = '1'")->findall();
		$ViewDataDictionary = D("ViewDataDictionary");
		$DataCD = D("DataCD");
		$i = 0;
		foreach($dingdanlist as $v){
			//提成数据
			$dingdanlist[$i]['ticheng'] = $ViewDataDictionary->where("`systemID` = '$v[tichengID]'")->find();
			//统计
			$tongji['renshu'] += $v['chengrenshu'] + $v['ertongshu'];
			$tongji['chengrenshu'] += $v['chengrenshu'] ;
			$tongji['ertongshu'] += $v['ertongshu'] ;
			$tongji['jiage'] += $v['jiage'] ;
			$i++;
		}
		$this->assign("tongji",$tongji);
		//剩余人数
		$this->assign("dingdanlist",$dingdanlist);
		$this->display('dingdanlist');
	}
	
	
	public function zhidingxiaoshou() {
		A("Method")->showDirectory("签证销售");
		$chanpinID = $_REQUEST["chanpinID"];
		//检查dataOM
		$qianzheng = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'签证');
		if(false === $qianzheng){
			$this->display('Index:error');
			exit;
		}
		$ViewQianzheng = D('ViewQianzheng');
		$qianzheng = $ViewQianzheng->where("`chanpinID` = '$chanpinID'")->find();
		
		$Chanpin = D("Chanpin");
		$chanpinID = $_REQUEST["chanpinID"];
		$cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
		$qianzheng = $Chanpin->relationGet('qianzheng');
		$this->assign("qianzheng",$qianzheng);
		$shoujia = $Chanpin->relationGet("shoujialist");
		$shoujia = A("Method")->_fenlei_filter($shoujia);
		$this->assign("shoujia",$shoujia);
		
		A('Method')->unitlist();
		$this->assign("qianzheng",$qianzheng);
		$this->display();
	}
	
	
	public function dopostfabu_shoujia() {
		A("Chanpin")->dopostfabu_shoujia();
	}

	
	public function dopostshoujia()
	{
		A("Chanpin")->dopostshoujia();
	}
	
	
	//添加订单
    public function qianzhengbaoming() {
		A("Method")->_chanpinbaoming('计调','签证');	
	}
	
	public function baozhangdanlist() {
		A("Method")->showDirectory("签证报账列表");
		$chanpinID = $_REQUEST['chanpinID'];
		//检查dataOM
		$qianzheng = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'签证','管理');
		if(false === $xianlu)
			$this->ajaxReturn($qianzheng,'错误，无管理权限！', 0);
		$ViewQianzheng = D("ViewQianzheng");
		$qianzheng = $ViewQianzheng->where("`chanpinID` = '$chanpinID'")->find();
		$this->assign("qianzheng",$qianzheng);
		$this->assign("datatitle",' : "'.$qianzheng['title'].'"');
		$ViewBaozhang = D("ViewBaozhang");
		$baozhanglist = $ViewBaozhang->order("time desc")->where("`parentID` = '$chanpinID' AND `status_system` = '1'")->findall();
		$i = 0;
		foreach($baozhanglist as $v){
			$baozhanglist[$i]['datatext'] = simple_unserialize($v['datatext']);
			$i++;
		}
		$this->assign("baozhanglist",$baozhanglist);
		$this->display();
	}
	
	
	public function dopost_baozhang() {
		A("Method")->dosavebaozhang('签证');
	}
	
	public function deleteBaozhang() {
		A("Method")->_deleteBaozhang();
	}
	
	
	public function zituanbaozhang() {
		$this->qianzhengbaozhang();
	}
	
	
	public function qianzhengbaozhang() {
		A("Method")->showDirectory("签证报账单");
		$this->assign("actionmethod",'Qianzheng');
		A('Method')->unitlist();
		if(!$_REQUEST['chanpinID'])
			A("Method")->_baozhang();
		else
			A("Method")->_baozhang('签证');
	}
	
	public function dopost_baozhangitem() {
		A("Method")->_dosavebaozhangitem('签证');
	}
	
	public function deleteBaozhangitem() {
		A("Method")->_deleteBaozhangitem();
	}
	
	public function shenheback() {
		A("Method")->_shenheback();
	}
	
	
	
}
?>