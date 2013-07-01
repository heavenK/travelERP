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
			$dingdan['dingdan']['zituanID'] = $dingdan['parentID'];
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
		if(false !== $Chanpin->relation('dingdan')->myRcreate($dingdan)){
			$dingdan['chanpinID'] = $Chanpin->getRelationID();
			$chanpinID = $dingdan['chanpinID'];
			//生成OM
			if($dingdan['type'] == '签证')
				$dataOMlist = A("Method")->_getDataOM($dingdan['parentID'],'签证','管理');
			else
				$dataOMlist = A("Method")->_getDataOM($dingdan['parentID'],'子团','管理');
			A("Method")->_createDataOM($chanpinID,'订单','管理',$dataOMlist);
			//开放给自己部门
			$dataOMlist = A("Method")->_getmyOMlist('电商');
			A("Method")->_createDataOM($chanpinID,'订单','管理',$dataOMlist);
			//生成团员
			if($dingdan['type'] != '签证')
				A("Method")->createCustomer_new($dingdan,$chanpinID);
			echo serialize($dingdan);
		}
		else{
			$returndata['msg'] = '订单服务器推送失败！';
			$returndata['error'] = 'true';
			echo serialize($returndata);
			exit;
		}
	}
	
	
	
	
}
?>