<?php

class ClientAction extends Action{
	
	//上架
    public function onshop() {
		A("MethodClient")->_onshop();
	}
	
	//获得线路
    public function _getxianlu() {
		$chanpinID = $_REQUEST['chanpinID'];
		$ViewXianlu = D("ViewXianlu");
		$xianlu = $ViewXianlu->where("`chanpinID` = '$chanpinID'")->find();
		$xianlu['zituanlist'] = $ViewXianlu->relationGet("zituanlist");
		if($xianlu['zituanlist'] == NULL){
			$returndata['msg'] = '子团获取失败';
			$returndata['error'] = 'true';
			echo serialize($returndata);
			exit;
		}
		$xianlu['xingchenglist'] = $ViewXianlu->relationGet("xingchenglist");
		$xianlu['shoujialist'] = $ViewXianlu->relationGet("shoujialist");
		$xianlu['chengbenlist'] = $ViewXianlu->relationGet("chengbenlist");
		$data = serialize($xianlu);
		echo $data;
		
    }
	
	
	//检查记录
    public function _checkActHistory($dataID,$datatype,$status) {
		$ViewInfohistory = D("ViewInfohistory");
		$record = $ViewInfohistory->where("`dataID` = '$dataID' AND `datatype` = '$datatype' AND `status` = '$status'")->find();
		if($record)
		return $record;
		return false;
    }
	
	
	//获得记录
    public function _getActHistory() {
		if($_REQUEST['dataID'])
			$dataID = $_REQUEST['dataID'];
		if($_REQUEST['datatype'])
			$datatype = $_REQUEST['datatype'];
		if($_REQUEST['status'])
			$status = $_REQUEST['status'];
		$ViewInfohistory = D("ViewInfohistory");
		$record = $ViewInfohistory->where("`dataID` = '$dataID' AND `datatype` = '$datatype' AND `status` = '$status'")->find();
		if(!$record){
			$returndata['msg'] = '未获得相关记录！';
			$returndata['error'] = 'true';
			echo serialize($returndata);
			exit;
		}
		$data = serialize($record);
		echo $data;
    }
	
	
	
}
?>