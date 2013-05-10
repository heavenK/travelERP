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
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		C('TOKEN_ON',false);
		$itemlist = $_REQUEST['checkboxitem'];
		$itemlist = explode(',',$itemlist);
		if(count($itemlist) != 1)
			$this->ajaxReturn($_REQUEST,'错误！请选择唯一一个进行操作！！', 0);
		$ViewXianlu = D("ViewXianlu");
		$Chanpin = D("Chanpin");
		foreach($itemlist as $v){
			$xianlu = $ViewXianlu->where("`chanpinID` = '$v'")->find();
			//链接服务器生成
			if(!$xianlu['serverdataID']){
				$serverdataID = FileGetContents("http://www.myerpcenter.com/index.php?s=/Server/dopostchanpin/chanpinID/".$v);
				if(!intval($serverdataID))
					$this->ajaxReturn($_REQUEST,'提交失败！', 0);
				$serverdataID = str_replace('﻿','',$serverdataID);
				$xianlu['xianlu']['serverdataID'] = $serverdataID;
				$xianlu['chanpinID'] = $v;
//				if(false === $Chanpin->relation("xianlu")->myRcreate($xianlu)){
//					$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
//				}
				//记录
				$url = 'index.php?s=/Chanpin/fabu/chanpinID/'.$v;
				$message = '『'.$xianlu['title'].'』 被提交到网店。';
				$data['status'] = '提交到网店';
				A("Method")->_setMessageHistory($v,'线路',$message,$url,'','',$data);
			}
			else{
				$this->ajaxReturn($_REQUEST,'该产品已提交到网店！', 1);
			}
		}
		$this->ajaxReturn($_REQUEST,'完成！', 1);
	}
	
	
	
	
	
	
	
	
}
?>