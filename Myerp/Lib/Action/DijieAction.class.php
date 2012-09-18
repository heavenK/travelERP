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
		$this->display('header_chanpin');
	}
	
	
    public function index() {
		A("Method")->showDirectory("团队创建及控管");
		$chanpin_list = A('Method')->getDataOMlist('地接','DJtuan',$_REQUEST);
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('index');
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
			$djtuan['datatext'] = unserialize($djtuan['datatext']);
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
        if ($_FILES['attachment']['name'] != '') { 
            //如果有文件上传 上传附件
			$savepath = './Data/Attachments/'; 
            $data["DJtuan"]['attachment'] = A("Method")->_upload($savepath); 
        }
		if($data['chanpinID'] && $data["DJtuan"]['attachment']){
			$dd = $Chanpin->relation('DJtuan')->where("`chanpinID` = '$data[chanpinID]'")->find();
			if($dd)
			{
				unlink('./Data/Attachments/'.$dd['DJtuan']['attachment']);
				unlink('./Data/Attachments/m_'.$dd['DJtuan']['attachment']);
				unlink('./Data/Attachments/s_'.$dd['DJtuan']['attachment']);
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
		$djtuan['datatext_xingcheng'] = unserialize($djtuan['datatext_xingcheng']);
		$this->assign("djtuan",$djtuan);
		$this->assign("xingcheng_array",$djtuan['datatext_xingcheng']['xingcheng_array']);
		$this->assign("remark",$djtuan['datatext_xingcheng']['remark']);
		$this->assign("datatitle",' : "'.$djtuan['title'].'"');
		$this->display('xingcheng');
	}
	
	
	
	public function dopostxingcheng() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data["chanpinID"] = $_REQUEST["chanpinID"];
		$data['DJtuan']["daoyou"] = $_REQUEST["daoyou"];
		$data["DJtuan"]["daoyoutelnum"] = $_REQUEST["daoyoutelnum"];
		$data["DJtuan"]["tuanbiao"] = $_REQUEST["tuanbiao"];
		$i = 0;
		foreach($_REQUEST['zaocan'] as $v){
			$xingcheng_array[$i] = $_REQUEST['zaocan'][$i].'@_@'.$_REQUEST['wucan'][$i].'@_@'.$_REQUEST['wancan'][$i].'@_@'.$_REQUEST['content'][$i];
			$i++;	
		}
		$datatext['xingcheng_array'] = $xingcheng_array;
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
		$djtuan['datatext_chengben'] = unserialize($djtuan['datatext_chengben']);
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
		if(!$_REQUEST['chanpinID']){
			A("Method")->_baozhang();
			A("Method")->showDirectory("预订单项服务");
		}
		else
			A("Method")->_baozhang('地接');
		$this->display('djtuanbaozhang');
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
		$this->display('danxiangfuwu');
	}
	
	
	
	
	
	
	
}
?>