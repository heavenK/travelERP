<?php

class ClientAction extends Action{
	
	//网站销售
    public function onshop() {
		A("MethodClient")->_onshop();
	}
	
	//下/上架
    public function onoffshop() {
		A("MethodClient")->_onoffshop();
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
	
	
	//获得线路
    public function _getzituan() {
		$chanpinID = $_REQUEST['chanpinID'];
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
		$zituan['xianlulist'] = $ViewZituan->relationGet("xianlulist");
		if($zituan['xianlulist'] == NULL){
			$returndata['msg'] = '子团所属线路获取失败';
			$returndata['error'] = 'true';
			echo serialize($returndata);
			exit;
		}
		$data = serialize($zituan);
		echo $data;
		
    }
	
	
	//获得签证
    public function _getqianzheng() {
		$chanpinID = $_REQUEST['chanpinID'];
		$ViewQianzheng = D("ViewQianzheng");
		$qianzheng = $ViewQianzheng->where("`chanpinID` = '$chanpinID'")->find();
		$qianzheng['shoujialist'] = $ViewQianzheng->relationGet("shoujialist");
		$data = serialize($qianzheng);
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
	
	//接收推送订单
    public function dopostOrder() {
		$orderID = $_REQUEST['orderID'];
		$Dingdan = D("Dingdan");
		$order = $Dingdan->where("`orderID` = '$orderID'")->find();
		if($order){
			$returndata['msg'] = "订单已经存在ERP！";
			$returndata['error'] = 'true';
			echo serialize($returndata);
			exit;
		}
		$order = FileGetContents(SERVER_INDEX."Server/getorder/orderID/".$orderID);
		if($order['error']){
			$returndata['msg'] = '服务器订单获取失败！';
			$returndata['error'] = 'true';
			echo serialize($returndata);
			exit;
		}
		$weborder = unserialize($order);
		//保存订单
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		//数据填充
		unset($order['chanpinID']);
		$dingdan = $order;
		$dingdan['dingdan'] = $order;
		$dingdan['parentID'] = $order['erp_parentID'];
		$dingdan['departmentID'] = '40174';
		$dingdan['user_name'] = '电商';
		$dingdan['companyID'] = '40150';
		//数据填充
		//$dingdan['dingdan']['title'] = $order['title'];
		$dingdan['dingdan']['lianxiren'] = $order['lxr_name'];
		$dingdan['dingdan']['jiage'] = $order['price'];
		$dingdan['dingdan']['telnum'] = $order['lxr_telnum'];
		//$dingdan['dingdan']['lxr_email'] = $order['lxr_email'];
		//数据填充
		$dingdan['dingdan']['tichengID'] = '43428';
		$dingdan['dingdan']['lingdui_num'] = 0;
		$dingdan['dingdan']['owner'] = '电商';
		//$dingdan['dingdan']['fuzebumenID'] = '40174';
		//$dingdan['dingdan']['fuzeren'] = '电商';
		//$dingdan['dingdan']['type'] = $order['type'];
		$dingdan['dingdan']['shoujiaID'] = -2;
		$dingdan['dingdan']['lxr_address'] = $weborder['lxr_address'];
		$dingdan['dingdan']['remark'] = $weborder['remark'];
		$order['datatext'] = unserialize($order['datatext']);
		if($order['type'] == '标准'){
			$i = 1;
			foreach($order['datatext']['joinerlist'] as $v){
				$dingdan['name'.$i] = $v['name'];
				$dingdan['manorchild'.$i] = $v['manorchild'];
				$dingdan['sex'.$i] = $v['sex'];
				$dingdan['telnum'.$i] = $v['telnum'];
				$dingdan['zhengjiantype'.$i] = $v['zhengjiantype'];
				$dingdan['zhengjianhaoma'.$i] = $v['zhengjianhaoma'];
				$dingdan['price'.$i] = $v['price'];
				$dingdan['remark'.$i] = '';
				$dingdan['pay_method'.$i] = '网银';
				$i++;
			}
		}
		if(A("Method")->_dingdansave_process($dingdan,'电商')){
			echo serialize($dingdan);
		}
		else{
			$returndata['msg'] = '订单服务器推送失败！';
			$returndata['error'] = 'true';
			echo serialize($returndata);
			exit;
		}
	}
	
	
	//获得记录
    public function bankOfChinaFileUpload() {
		
       $allUidArr=array();
		$uids_path='README.txt';
		if(!file_exists($uids_path)){
			dump('break');
			break;
		}
		$uidArr=file($uids_path,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$allUidArr=$allUidArr + array_fill_keys($uidArr,$i);
				
		dump($allUidArr['1234']);
		dump($allUidArr);
		
		$this->display('Index:bankofchinafileupload');
		
    }
	
	
	
	
	
	
	
	
	
	
	
}
?>