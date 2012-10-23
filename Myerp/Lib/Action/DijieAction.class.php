<?php

class DijieAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'产品地接');
	}
	
	
	public function header_chanpin() {
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			//判断批准
			$Chanpin = D("Chanpin");
			$zituan = $Chanpin->where("`chanpinID` = '$chanpinID' and `status` != '准备'")->find();
			if($zituan)
				$this->assign("show_chengtuan",true);
		}
		$this->display('Dijie:header_chanpin');
	}
	
	
    public function index($directory) {
		A("Method")->showDirectory("团队创建及控管");
		if($directory)
		$this->assign("navposition",$directory);
		$chanpin_list = A('Method')->getDataOMlist('地接','DJtuan',$_REQUEST);
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('Dijie:index');
    }
	
	
	public function left_chanpin() {
		$this->display('Dijie:left_chanpin');
	}
	
	
	public function fabu() {
		A("Method")->showDirectory("接团基本信息");
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			//检查dataOM
			$xianlu = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'地接');
			if(false === $xianlu){
				$this->display('Index:error');
				exit;
			}
			$ViewDJtuan = D('ViewDJtuan');
			$djtuan = $ViewDJtuan->where("`chanpinID` = '$chanpinID'")->find();
			$djtuan['datatext'] = simple_unserialize($djtuan['datatext']);
			$this->assign("djtuan",$djtuan);
			$this->assign("datatitle",' : "'.$djtuan['title'].'"');
		}
		else{
			//判断计调角色
			$durlist = A("Method")->_checkRolesByUser('地接','地接');
			if(false === $durlist){
				$this->display('Index:error');
				exit;
			}
		}
		//用户列表
		$ViewUser = D("ViewUser");
		$userlist = $ViewUser->where("`status_system` = '1'")->findall();
		$this->assign("userlist",$userlist);
		//获得个人部门及分类列表
		$bumenfeilei = A("Method")->_getbumenfenleilist('地接');
		$this->assign("bumenfeilei",$bumenfeilei);
		$this->display('fabu');
	}
	
	
	
	public function dopostfabu()
	{
		$chanpinID = $_REQUEST["chanpinID"];
		if($chanpinID){
			//检查dataOM
			$xianlu = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'地接');
			if(false === $xianlu){
				$this->display('Index:error');
				exit;
			}
		}
		if(!$_REQUEST['departmentID'])
			A("Method")->ajaxUploadResult($_REQUEST,'您没有权限发布地接类产品！',0);
		$Chanpin = D("Chanpin");
		$data = $_REQUEST;
		$data["DJtuan"] = $_REQUEST;
		$data["DJtuan"]['datatext'] = serialize($_REQUEST);
		//如果有文件上传 上传附件
		$savepath = './Data/Files/'; 
        if ($_FILES['attachment']['name'] != '') { 
            $data["DJtuan"]['attachment'] = A("Method")->_upload($savepath); 
        }
		if($data['chanpinID'] && $data["DJtuan"]['attachment']){
			$dd = $Chanpin->relation('DJtuan')->where("`chanpinID` = '$data[chanpinID]'")->find();
			if($dd){
				unlink($savepath.$dd['DJtuan']['attachment']);
			}
		}
		else{
			//判断计调角色
			$durlist = A("Method")->_checkRolesByUser('地接','地接');
			if (false === $durlist)
				$this->ajaxReturn('', '没有地接权限！', 0);
		}
		if(!$data['chanpinID'] && false === $data["DJtuan"]['attachment'])
			$data["DJtuan"]['attachment'] = '';
		if (false !== $Chanpin->relation('DJtuan')->myRcreate($data)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			//生成OM
			if($Chanpin->getLastmodel() == 'add'){
				$dataOMlist = A("Method")->_setDataOMlist('地接','地接');
				A("Method")->_createDataOM($_REQUEST['chanpinID'],'地接','管理',$dataOMlist);
			}
			A("Method")->ajaxUploadResult($_REQUEST,'保存成功',1);
		}
		else{
			A("Method")->ajaxUploadResult($_REQUEST,$Chanpin->getError(),0);
		}
		
	}
	
	
	
	
	public function dingfangquerendan() {
		A("Method")->showDirectory("订房确认单");
		$chanpinID = $_REQUEST["chanpinID"];
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($chanpinID,'地接');
		if(false === $xianlu){
			$this->display('Index:error');
			exit;
		}
		$ViewDJtuan = D('ViewDJtuan');
		$djtuan = $ViewDJtuan->where("`chanpinID` = '$chanpinID'")->find();
		$djtuan['datatext_dingfang'] = simple_unserialize($djtuan['datatext_dingfang']);
		if($djtuan['datatext_dingfang']['title'] == '')
			$djtuan['datatext_dingfang']['title'] = '大连古莲国旅';
		if($djtuan['datatext_dingfang']['fajianrendanwei'] == '')
			$djtuan['datatext_dingfang']['fajianrendanwei'] = '大连古莲国旅';
		$this->assign("datatext_dingfang",$djtuan['datatext_dingfang']);
		$this->assign("djtuan",$djtuan);
		$this->assign("remark",$djtuan['datatext_xingcheng']['remark']);
		$this->assign("datatitle",' : "'.$djtuan['title'].'"');
		if($_REQUEST['doprint'] == '打印'){
			$this->display('print_dingfang');
		}
		elseif($_REQUEST['export'] == 1){
			//导出Word
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . '日程安排——'.$djtuan['title']. ".doc");
			header("Pragma:no-cache");        
			header("Expires:0"); 
			$this->display('print_dingfang');
		}
		else
			$this->display('dingfangquerendan');
	}
	
	
	
	public function xingcheng() {
		A("Method")->showDirectory("日程安排");
		$chanpinID = $_REQUEST["chanpinID"];
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($chanpinID,'地接');
		if(false === $xianlu){
			$this->display('Index:error');
			exit;
		}
		$ViewDJtuan = D('ViewDJtuan');
		$djtuan = $ViewDJtuan->where("`chanpinID` = '$chanpinID'")->find();
		$djtuan['datatext_xingcheng'] = simple_unserialize($djtuan['datatext_xingcheng']);
		$djtuan['datatext'] = simple_unserialize($djtuan['datatext']);
		$this->assign("datatext_xingcheng",$djtuan['datatext_xingcheng']);
		$this->assign("jiaotong_array",$djtuan['datatext_xingcheng']['jiaotong_array']);
		$this->assign("djtuan",$djtuan);
		$this->assign("xingcheng_array",$djtuan['datatext_xingcheng']['xingcheng_array']);
		$this->assign("remark",$djtuan['datatext_xingcheng']['remark']);
		$this->assign("datatitle",' : "'.$djtuan['title'].'"');
		if($_REQUEST['doprint'] == '打印'){
			$this->display('print_travelnotice');
		}
		elseif($_REQUEST['export'] == 1){
			//导出Word
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . '日程安排——'.$djtuan['title']. ".doc");
			header("Pragma:no-cache");        
			header("Expires:0"); 
			$this->display('print_xingcheng');
		}
		else
			$this->display('xingcheng');
	}
	
	
	
	public function dopostdingfang() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data["chanpinID"] = $_REQUEST["chanpinID"];
		$datatext =  $_REQUEST;
		$data["DJtuan"]['datatext_dingfang'] = serialize($datatext);
		if (false !== $Chanpin->relation('DJtuan')->myRcreate($data)){
			$this->ajaxReturn($_REQUEST,'保存成功！', 1);
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	
	}
	
	
	
	public function dopostxingcheng() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data["chanpinID"] = $_REQUEST["chanpinID"];
		$data['DJtuan']["daoyou"] = $_REQUEST["daoyou"];
		$data["DJtuan"]["daoyoutelnum"] = $_REQUEST["daoyoutelnum"];
		$data["DJtuan"]["tuanbiao"] = $_REQUEST["tuanbiao"];
		$datatext['hotel'] =  $_REQUEST["hotel"];
		$datatext['roomnumber'] =  $_REQUEST["roomnumber"];
		$datatext['quanpei'] =  $_REQUEST["quanpei"];
		$datatext['quanpeitelnum'] =  $_REQUEST["quanpeitelnum"];
		$datatext['carnumber'] =  $_REQUEST["carnumber"];
		$datatext['carpilot'] =  $_REQUEST["carpilot"];
		$datatext['cartelnum'] =  $_REQUEST["cartelnum"];
		$i = 0;
		foreach($_REQUEST['content'] as $v){
			$xingcheng_array[$i] = $_REQUEST['zaocan_price'][$i].'#_#'.$_REQUEST['zaocan_addres'][$i].'#_#'.$_REQUEST['zaocan_telnum'][$i].'@_@';
			$xingcheng_array[$i] .= $_REQUEST['wucan_price'][$i].'#_#'.$_REQUEST['wucan_addres'][$i].'#_#'.$_REQUEST['wucan_telnum'][$i].'@_@';
			$xingcheng_array[$i] .= $_REQUEST['wancan_price'][$i].'#_#'.$_REQUEST['wancan_addres'][$i].'#_#'.$_REQUEST['wancan_telnum'][$i].'@_@';
			$xingcheng_array[$i] .= $_REQUEST['content'][$i];
			//$xingcheng_array[$i] = $_REQUEST['zaocan'][$i].'@_@'.$_REQUEST['wucan'][$i].'@_@'.$_REQUEST['wancan'][$i].'@_@'.$_REQUEST['content'][$i];
			$i++;	
		}
		$datatext['xingcheng_array'] = $xingcheng_array;
		$i = 0;
		foreach($_REQUEST['jiaotongtype'] as $v){
			$jiaotong_array[$i] = $_REQUEST['jiaotongtype'][$i].'@_@'.$_REQUEST['fangshi'][$i].'@_@'.$_REQUEST['bianhao'][$i].'@_@'.$_REQUEST['dachengshijian'][$i].'@_@'.$_REQUEST['didashijian'][$i];
			$i++;	
		}
		$datatext['jiaotong_array'] = $jiaotong_array;
		$datatext['remark'] = $_REQUEST["remark"];
		$data["DJtuan"]['datatext_xingcheng'] = serialize($datatext);
		if (false !== $Chanpin->relation('DJtuan')->myRcreate($data)){
			$this->ajaxReturn($_REQUEST,'保存成功！', 1);
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	
	}
	
	
	
	public function chengbenshoujia() {
		A("Method")->showDirectory("成本及报价");
		$chanpinID = $_REQUEST["chanpinID"];
		//检查dataOM
		$xianlu = A('Method')->_checkDataOM($chanpinID,'地接');
		if(false === $xianlu){
			$this->display('Index:error');
			exit;
		}
		$ViewDJtuan = D('ViewDJtuan');
		$djtuan = $ViewDJtuan->where("`chanpinID` = '$chanpinID'")->find();
		$djtuan['datatext_chengben'] = simple_unserialize($djtuan['datatext_chengben']);
		$this->assign("djtuan",$djtuan);
		$this->assign("chengben",$djtuan['datatext_chengben']['chengben']);
		$this->assign("remark",$djtuan['datatext_chengben']['remark']);
		$this->assign("datatitle",' : "'.$djtuan['title'].'"');
		$this->display('chengbenshoujia');
	}
	
	
	
	
	public function dopostchengbenshoujia() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data["chanpinID"] = $_REQUEST["chanpinID"];
		$data['DJtuan']["baojia"] = $_REQUEST["baojia"];
		$i = 0;
		foreach($_REQUEST['type'] as $v){
			$chengben[$i] = $_REQUEST['type'][$i].'@_@'.$_REQUEST['title'][$i].'@_@'.$_REQUEST['renshu'][$i].'@_@'.$_REQUEST['time_start'][$i].'@_@'.$_REQUEST['time_end'][$i].'@_@'.$_REQUEST['remark'][$i].'@_@'.intval($_REQUEST['price'][$i]);
			$i++;	
		}
		$datatext['chengben'] = $chengben;
		$datatext['remark'] = $_REQUEST["remark"];
		$data["DJtuan"]['datatext_chengben'] = serialize($datatext);
		if (false !== $Chanpin->relation('DJtuan')->myRcreate($data)){
			$this->ajaxReturn($_REQUEST,'保存成功！', 1);
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	
	}
	
	
	
	public function doshenhe() {
		A("Method")->_doshenhe();
	}
	
	public function djtuandanxiangfuwu() {
		A("Method")->_tuandanxiangfuwu('地接');
		$this->display('djtuandanxiangfuwu');
	}
	
	public function dopost_baozhang() {
		A("Method")->dosavebaozhang('地接');
	}
	
	public function djtuanbaozhang() {
		A("Method")->showDirectory("预订单项服务");
		$this->assign("actionmethod",'Dijie');
		if(!$_REQUEST['chanpinID'])
			A("Method")->_baozhang();
		else
			A("Method")->_baozhang('地接');
	}
	
	public function deleteBaozhang() {
		A("Method")->_deleteBaozhang();
	}
	
	public function dopost_baozhangitem() {
		A("Method")->_dosavebaozhangitem('地接');
	}
	
	public function deleteBaozhangitem() {
		A("Method")->_deleteBaozhangitem();
	}
	
	public function shenheback() {
		A("Method")->_shenheback();
	}
	
	public function djtuanxiangmu() {
		A("Method")->_xiangmu('地接');
		$this->display('djtuanxiangmu');
	}
	
	public function getBaozhangitem() {
		A("Method")->_getBaozhangitem();
	}
	
	public function danxiangfuwu() {
		A("Method")->_danxiangfuwu('地接');
	}
	
	
	public function shenhe() {
		A("Method")->showDirectory("团队审核");
		A("Method")->_shenhe('地接');
		$this->assign("chanpin_mark",'Dijie');
		$this->display('Chanpin:shenhe');
	}
	
	public function zituanbaozhang() {
		$this->djtuanbaozhang();
	}
	
	public function zituanxiangmu() {
		$this->djtuanxiangmu();
	}
	
    public function copytonew() {
		A('Method')->_copytonew('地接');
	}
	
    public function deletechanpin() {
		A('Method')->_deletechanpin('地接');
	}
	
}
?>