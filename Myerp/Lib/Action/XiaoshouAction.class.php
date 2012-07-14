<?php

class XiaoshouAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'销售');
	}
	
	
    public function index() {
		A("Method")->showDirectory("线路产品");
		$chanpin_list = A('Method')->getDataOMlist('售价','shoujia',$_REQUEST,'开放');
		$Chanpin = D("Chanpin");
		$ViewZituan = D("ViewZituan");
		$DataCopy = D("DataCopy");
		$i = 0;
		foreach($chanpin_list['chanpin'] as $v){
			$xianlu = $DataCopy->where("`dataID` = '$v[parentID]' and `datatype` = '线路'")->order("time desc")->find();
			$xianlu = unserialize($xianlu['copy']);
			$chanpin_list['chanpin'][$i]['xianlu'] = $xianlu;
			$zituan = $ViewZituan->where("`parentID` = '$v[parentID]'")->findall();
			$chanpin_list['chanpin'][$i]['zituan'] = $zituan;
			$i++;
		}
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('index');
    }
	
	
	
    public function zituan() {
		//检查dataOM
		$xiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价','开放');
		if(false === $xiaoshou){
			$this->display('Index:error');
			exit;
		}
		$Chanpin = D("Chanpin");
		$shoujia = $Chanpin->relation("shoujia")->where("`chanpinID` = '$_REQUEST[shoujiaID]'")->find();
		$this->assign("shoujia",$shoujia['shoujia']);
		$DataCopy = D("DataCopy");
		$xianlu = $DataCopy->where("`dataID` = '$_REQUEST[xianluID]' and `datatype` = '线路'")->order("time desc")->find();
		$xianlu = unserialize($xianlu['copy']);
		//解析视频
		$ViewDataDictionary = D("ViewDataDictionary");
		$nameshipin = $xianlu['xianlu']['shipin'];
		$shipin = $ViewDataDictionary->where("`title` = '$nameshipin' and `type` = '视频'")->find();
		$tupianlist = split(',',$xianlu['xianlu']['tupian']);
		$i = 0;
		foreach($tupianlist as $v){
			$tupian[$i] = $ViewDataDictionary->where("`title` = '$v' and `type` = '图片'")->find();
			$i++;
		}
		$this->assign("shipin",$shipin);
		$this->assign("tupian",$tupian);
		$this->assign("xianlu",$xianlu);
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		$this->assign("zituan",$zituan);
		//创建人信息
		$ViewDepartment = D("ViewDepartment");
		$durlist = A('Method')->_getDURlist_name($zituan['user_name']);
		$i = 0;
		foreach($durlist as $vvvv){
			$durlist[$i] = $ViewDepartment->where("`systemID` = '$vvvv[departmentID]'")->find();
			$i++;
		}
		$this->assign("userdurlist",$durlist);
		if($_REQUEST['doprint'] == '打印')
		$this->display('printzituan');
		else
		if($_REQUEST['dobaoming'] == '报名'){
			$ViewUser = D("ViewUser");
			$userlist = $ViewUser->findall();
			$this->assign("userlist",$userlist);
			$this->display('baoming');
		}
		else
		$this->display('zituan');
	}
	
	
	
    public function baoming() {
	
		//检查dataOM
		$xiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价','开放');
		if(false === $xiaoshou){
			$this->display('Index:error');
			exit;
		}
		//检查子团ID
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$_REQUEST[zituanID]'")->find();
		if(false === $zituan || $zituan == ''){
			$this->display('Index:error');
			exit;
		}
		$this->assign("zituan",$zituan);
		//检查数据
		//owner
		$ViewUser = D("ViewUser");
		if(!$ViewUser->where("`title` = '$_REQUEST[owner]'")->find()){ 
				justalert('所属人错误！');
				gethistoryback();
		} 	
		//联系人
		if(!$_REQUEST['lianxiren'] || !$_REQUEST['telnum']){ 
				justalert('联系人和电话必须！');
				gethistoryback();
		} 	
		//人数及人数检查
		if(!$_REQUEST['chengrenshu']){ 
				justalert('成人人数必须！');
				gethistoryback();
		} 	
		//价格及价格检查
		if(!$_REQUEST['adultprice']){ 
				justalert('成人价格必须！');
				gethistoryback();
		} 	
		unset($_REQUEST['__hash__']);
		
		$renshu = $_REQUEST['chengrenshu']+$_REQUEST['ertongshu'];
		$this->assign("renshu",$renshu);
		$this->assign("_REQUEST",$_REQUEST);
		$this->display('baomingnext');
	
	}
	
	
	
    public function dopostbaoming() {
//		if (md5($_REQUEST['verifyTest']) != session('verify')) {  
//				justalert('验证码错误,请刷新验证码并重新填写！');
//				gethistoryback();
//		  } 
//		else
//		session('verify',null);

		C('TOKEN_ON',false);
		
		//检查dataOM
		$xiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价','开放');
		if(false === $xiaoshou){
			$this->display('Index:error');
			exit;
		}
		//检查子团ID
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$_REQUEST[zituanID]'")->find();
		if(false === $zituan || $zituan == ''){
			$this->display('Index:error');
			exit;
		}
		//生成订单
		$Chanpin = D("Chanpin");
		$System = D("System");
		$ViewCustomer = D("ViewCustomer");
		$data = $_REQUEST;
		$data['dingdan'] = $data;
		for($i = 0;$i<$_REQUEST['chengrenshu']+$_REQUEST['ertongshu'];$i++){
			$jiage += $_REQUEST['price'.$i];
		}
		$data['dingdan']['jiage'] = $jiage;
		$data['dingdan']['bumen_copy'] = cookie('_usedbumen');
		if (false !== $Chanpin->relation("dingdan")->myRcreate($data)){
			$dingdanID = $Chanpin->getRelationID();
			$cust['dingdanID'] = $dingdanID;
			//生成团员
			for($i = 0;$i<$_REQUEST['chengrenshu']+$_REQUEST['ertongshu'];$i++){
				$cust['name'] = $_REQUEST['name'.$i];
				$cust['sex'] = $_REQUEST['sex'.$i];
				$cust['telnum'] = $_REQUEST['telnum'.$i];
				$cust['zhengjiantype'] = $_REQUEST['zhengjiantype'.$i];
				$cust['zhengjianhaoma'] = $_REQUEST['zhengjianhaoma'.$i];
				$cust['price'] = $_REQUEST['price'.$i];
				$cust['remark'] = $_REQUEST['remark'.$i];
				if($_REQUEST['telnum'.$i]){ 
					//查询客户表
					$c = $ViewCustomer->where("`telnum` = '$tel'")->find();
					if($c)
						$cust['customerID'] = $c['systemID'];	
				}
				//生成客户订单中间表
				A("Method")->createCustomerDingdan($cust);
			
			
			}
			
			
			
		}
		dump($Chanpin);
	}
	
	
	
	
	
	
	
	
	
	
	
}
?>