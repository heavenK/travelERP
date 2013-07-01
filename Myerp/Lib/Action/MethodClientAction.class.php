<?php

class MethodClientAction extends CommonAction{
	
    public function _initialize() {
		if($_REQUEST['_URL_'][0] == 'MethodClient'){
			$this->display('Index:error');
			exit;
		}
	}
	
	
	function _onshop(){
		//判断角色,返回用户DUR
		$durlist = A("Method")->_checkRolesByUser('网管','行政');
		if(false === $durlist)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		C('TOKEN_ON',false);
		$itemlist = $_REQUEST['checkboxitem'];
		$itemlist = explode(',',$itemlist);
		if(count($itemlist) != 1)
			$this->ajaxReturn($_REQUEST,'错误！请选择唯一一个进行操作！！', 0);
		if($_REQUEST['chanpintype'] == '线路'){
			$this->_doonshop_xianlu($itemlist);	
		}
		if($_REQUEST['chanpintype'] == '签证'){
			$this->_doonshop_qianzheng($itemlist);	
		}
		
	}
	
	
	
	function _doonshop_xianlu($itemlist){
		$ViewXianlu = D("ViewXianlu");
		$Chanpin = D("Chanpin");
		foreach($itemlist as $v){
			$xianlu = $ViewXianlu->where("`chanpinID` = '$v'")->find();
			if($xianlu['status_shenhe'] != '批准')
				$this->ajaxReturn($_REQUEST,'产品未被审核批准,禁止提交！', 0);
			//链接服务器生成
			if(!$xianlu['serverdataID']){
				//记录
				$url = 'index.php?s=/Chanpin/fabu/chanpinID/'.$v;
				$message = '『'.$xianlu['title'].'』 被提交到网店。';
				$data['status'] = '提交到网店';
				A("Method")->_setMessageHistory($v,'线路',$message,$url,'','',$data);
				//生成
				$getres = FileGetContents(SERVER_INDEX."Server/dopostchanpin/chanpinID/".$v);
				if($getres['error'])
					$this->ajaxReturn($_REQUEST,$getres['msg'], 0);
				else
					$serverdataID = $getres;
				if(!intval($serverdataID))
					$this->ajaxReturn($_REQUEST,'提交失败！', 0);
//				$serverdataID = str_replace('﻿','',$serverdataID);
				$xianlu['xianlu']['serverdataID'] = $serverdataID;
				$xianlu['chanpinID'] = $v;
				if(false === $Chanpin->relation("xianlu")->myRcreate($xianlu)){
					$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
				}
			}
			else{
				$this->ajaxReturn($_REQUEST,'该产品已提交到网店！', 1);
			}
		}
		$this->ajaxReturn($_REQUEST,'完成！', 1);
	}
	
	
	
	function _doonshop_qianzheng($itemlist){
		$ViewQianzheng = D("ViewQianzheng");
		$Chanpin = D("Chanpin");
		foreach($itemlist as $v){
			$qianzheng = $ViewQianzheng->where("`chanpinID` = '$v'")->find();
			if($qianzheng['status_shenhe'] != '批准')
				$this->ajaxReturn($_REQUEST,'产品未被审核批准,禁止提交！', 0);
			//链接服务器生成
			if(!$qianzheng['serverdataID']){
				//记录
				$url = 'index.php?s=/Qianzheng/fabu/chanpinID/'.$v;
				$message = '『'.$xianlu['title'].'』 被提交到网店。';
				$data['status'] = '提交到网店';
				A("Method")->_setMessageHistory($v,'签证',$message,$url,'','',$data);
				//生成
				$getres = FileGetContents(SERVER_INDEX."Server/dopostchanpin_qianzheng/chanpinID/".$v);
				if($getres['error'])
					$this->ajaxReturn($_REQUEST,$getres['msg'], 0);
				else
					$serverdataID = $getres;
				if(!intval($serverdataID))
					$this->ajaxReturn($_REQUEST,'提交失败！', 0);
				$qianzheng['qianzheng']['serverdataID'] = $serverdataID;
				$qianzheng['chanpinID'] = $v;
				if(false === $Chanpin->relation("qianzheng")->myRcreate($qianzheng)){
					$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
				}
			}
			else{
				$this->ajaxReturn($_REQUEST,'该产品已提交到网店！', 1);
			}
		}
		$this->ajaxReturn($_REQUEST,'完成！', 1);
	}
	
	
	
	
	
	
	
}
?>