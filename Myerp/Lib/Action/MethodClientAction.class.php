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
		$durlist = A("Method")->_checkRolesByUser('网店计调','组团');
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
	
	
	
	function _onoffshop(){
		//判断角色,返回用户DUR
		$durlist = A("Method")->_checkRolesByUser('网店计调','组团');
		if(false === $durlist)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		C('TOKEN_ON',false);
		$itemlist = $_REQUEST['checkboxitem'];
		$itemlist = explode(',',$itemlist);
		if(count($itemlist) != 1)
			$this->ajaxReturn($_REQUEST,'错误！请选择唯一一个进行操作！！', 0);
		if($_REQUEST['chanpintype'] == '线路'){
			$this->_doonoffshop_xianlu($itemlist);	
		}
		if($_REQUEST['chanpintype'] == '子团'){
			$this->_doonoffshop_zituan($itemlist);	
		}
		if($_REQUEST['chanpintype'] == '签证'){
			$this->_doonoffshop_qianzheng($itemlist);	
		}
		
	}
	
	
	function _doonoffshop_xianlu($itemlist){
		$ViewXianlu = D("ViewXianlu");
		$Chanpin = D("Chanpin");
		foreach($itemlist as $v){
			$xianlu = $ViewXianlu->relation("zituanlist")->where("`chanpinID` = '$v'")->find();
			if($xianlu['status_shenhe'] != '批准')
				$this->ajaxReturn($_REQUEST,'线路未被审核批准,禁止提交！', 0);
			if($xianlu['serverdataID']<0 || $xianlu['serverdataID'] == NULL)
				$this->ajaxReturn($_REQUEST,'线路未被提交到网店！', 0);
			//修改线路状态
			if($xianlu['status_shop'] == '上架' || $xianlu['status_shop'] == NULL)
				$xianlu['xianlu']['status_shop'] = '下架';	
			else
				$xianlu['xianlu']['status_shop'] = '上架';
			foreach($xianlu['zituanlist'] as $v_zt){
				$zituan['chanpiniD'] = $v_zt['chanpinID'];	
				//修改子团状态
				$zituan['zituan']['status_shop'] = $xianlu['xianlu']['status_shop'];
				if(false === $Chanpin->relation("zituan")->myRcreate($zituan)){
					dump($v_zt);
					dump($zituan);
					dump($Chanpin);
					$this->ajaxReturn($_REQUEST, '子团更新失败！', 0);	
				}
			}
			if(false !== $Chanpin->relation('xianlu')->myRcreate($xianlu)){
				//修改服务器子团状态
				$getres = FileGetContents(SERVER_INDEX."Server/updatechanpin_status/chanpintype/线路/chanpinID/".$v);
				if($getres['error']){
					$this->ajaxReturn($_REQUEST, '服务器更新失败！', 0);
				}
			}
		}
		$this->ajaxReturn($_REQUEST,'产品'.$xianlu['xianlu']['status_shop'], 1);
	}
	
	
	
	function _doonoffshop_zituan($itemlist){
		$ViewZituan = D("ViewZituan");
		$Chanpin = D("Chanpin");
		foreach($itemlist as $v){
			$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$v'")->find();
			if($zituan['xianlulist']['status_shenhe'] != '批准')
				$this->ajaxReturn($_REQUEST,'子团所属线路未被审核批准,禁止提交！', 0);
			if($zituan['xianlulist']['serverdataID']<0 || $zituan['xianlulist']['serverdataID'] == NULL)
				$this->ajaxReturn($_REQUEST,'子团所属线路未被提交到网店！', 0);
			//修改子团状态
			if($zituan['status_shop'] == '上架' || $zituan['status_shop'] == NULL)
				$zituan['zituan']['status_shop'] = '下架';	
			else
				$zituan['zituan']['status_shop'] = '上架';
			if(false !== $Chanpin->relation('zituan')->myRcreate($zituan)){
				//修改服务器子团状态
				$getres = FileGetContents(SERVER_INDEX."Server/updatechanpin_status/chanpintype/子团/chanpinID/".$v);
				if($getres['error']){
					$this->ajaxReturn($_REQUEST, '服务器更新失败！', 0);
				}
			}
		}
		$this->ajaxReturn($_REQUEST,'产品'.$zituan['zituan']['status_shop'], 1);
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
				//更新产品状态
				$xianlu['xianlu']['status_shop'] = '上架';
				$Chanpin->relation('xianlu')->myRcreate($xianlu);
				$zituanlist = $ViewXianlu->relationGet("zituanlist");
				foreach($zituanlist as $vol){
					$vol['zituan']['status_shop'] = '上架';
					$Chanpin->relation('zituan')->myRcreate($vol);
				}
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
				$xianlu['xianlu']['serverdataID'] = $serverdataID;
				$xianlu['chanpinID'] = $v;
				if(false === $Chanpin->relation("xianlu")->myRcreate($xianlu)){
					$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
				}
			}
			else{
				//更新信息
				$getres = FileGetContents(SERVER_INDEX."Server/updatechanpin/chanpinID/".$v);
				if($getres['error']){
					$this->ajaxReturn($_REQUEST,$getres['msg'], 0);
				}
				$this->ajaxReturn($_REQUEST,'网店产品更新成功！', 1);
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
				$getres = FileGetContents(SERVER_INDEX."Server/updatechanpin_qianzheng/chanpinID/".$v);
				if($getres['error']){
					$this->ajaxReturn($_REQUEST,$getres['msg'], 0);
				}
				$this->ajaxReturn($_REQUEST,'网店产品更新成功！', 1);
			}
		}
		$this->ajaxReturn($_REQUEST,'完成！', 1);
	}
	
	
	
	
	
	
	
}
?>