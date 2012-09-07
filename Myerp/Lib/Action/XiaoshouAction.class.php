<?php

class XiaoshouAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'销售');
	}
	
	
    public function index() {
		$this->assign("markpos",$_REQUEST['xianlu_kind']);
		A("Method")->showDirectory("线路产品");
		$chanpin_list = A('Method')->getDataOMlist('售价','shoujia',$_REQUEST,'开放');
		$ViewZituan = D("ViewZituan");
		$DataCopy = D("DataCopy");
		$System = D("System");
		$i = 0;
		foreach($chanpin_list['chanpin'] as $v){
			$xianlu = $DataCopy->where("`dataID` = '$v[parentID]' and `datatype` = '线路'")->order("time desc")->find();
			$xianlu = unserialize($xianlu['copy']);
			//获得部门名
			$bumenID = $xianlu['xianlu']['departmentID'];
			$bumen = $System->relation("department")->where("`systemID` = '$bumenID'")->find();
			$xianlu['xianlu']['bumentitle'] = $bumen['department']['title'];
			$chanpin_list['chanpin'][$i]['xianlu'] = $xianlu;
			$zituan = $ViewZituan->where("`parentID` = '$v[parentID]' AND `status_system` = '1'")->findall();
			//剩余名额
			$jj = 0;
			foreach($zituan as $zt){
				$tuanrenshu = A("Method")->_getzituandingdan($zt['chanpinID'],$v['chanpinID']);
				$shoujia_renshu = $tuanrenshu['shoujiarenshu'];
				$baomingrenshu = $tuanrenshu['baomingrenshu'];
				$baoming_renshu[$zt['chanpinID']] += $tuanrenshu['baomingrenshu'];
				$zituan[$jj]['shoujia_renshu'] = $tuanrenshu['shoujiarenshu'];
				if(($zt['renshu'] - $baomingrenshu) < ($v['renshu'] - $shoujia_renshu))
				$zituan[$jj]['shengyurenshu'] = $zt['renshu'] - $baomingrenshu;
				else
				$zituan[$jj]['shengyurenshu'] = $v['renshu'] - $shoujia_renshu;
				$jj++;
			}
			$chanpin_list['chanpin'][$i]['zituan'] = $zituan;
			$i++;
		}
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->assign("baoming_renshu",$baoming_renshu);
		
		$this->display('index');
    }
	
	
	
    public function zituan() {
		//检查dataOM
		$xiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价','开放');
		dump($xiaoshou);
//		if(false === $xiaoshou){
//			$this->display('Index:error');
//			exit;
//		}
		$Chanpin = D("Chanpin");
		$shoujia = $Chanpin->relation("shoujia")->where("`chanpinID` = '$_REQUEST[shoujiaID]'")->find();
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		$this->assign("zituan",$zituan);
		//价格计算
		$shoujia['shoujia']['adultprice'] += $zituan['adultxiuzheng'];
		$shoujia['shoujia']['childprice'] += $zituan['childxiuzheng'];
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
		//计算子团人数
		$tuanrenshu = A("Method")->_getzituandingdan($_REQUEST['chanpinID'],$_REQUEST['shoujiaID']);
		$shoujia_renshu = $tuanrenshu['shoujiarenshu'];
		$baomingrenshu = $tuanrenshu['baomingrenshu'];
		if(($zituan['renshu'] - $baomingrenshu) < ($shoujia['shoujia']['renshu'] - $shoujia_renshu))
		$shengyurenshu = $zituan['renshu'] - $baomingrenshu;
		else
		$shengyurenshu = $shoujia['shoujia']['renshu'] - $shoujia_renshu;
		$this->assign("shengyurenshu",$shengyurenshu);
		$this->assign("shoujia_renshu",$shoujia_renshu);
		$this->assign("renshu",$renshu);
		//创建人信息
		$ViewDepartment = D("ViewDepartment");
		$durlist = A('Method')->_getDURlist_name($zituan['user_name']);
		$i = 0;
		foreach($durlist as $vvvv){
			$durlist[$i] = $ViewDepartment->where("`systemID` = '$vvvv[departmentID]'")->find();
			$i++;
		}
		$this->assign("userdurlist",$durlist);
		//提成数据
		$ViewDataDictionary = D("ViewDataDictionary");
		$ticheng = $ViewDataDictionary->where("`type` = '提成' AND `status_system` = '1'")->findall();
		$this->assign("ticheng",$ticheng);
		//报名截止
		if(time()-strtotime(jisuanriqi($zituan['chutuanriqi'],$zituan['baomingjiezhi'],'减少')) <= 0 )
		$this->assign("baoming_root",1);
		//显示
		if($_REQUEST['doprint'] == '打印')
		$this->display('printzituan');
		else
		if($_REQUEST['dobaoming'] == '报名'){
			//获得个人部门及分类列表
			$bumenfeilei = A("Method")->_getbumenfenleilist();
			$this->assign("bumenfeilei",$bumenfeilei);
			//清空占位过期订单
			A('Method')->_cleardingdan();
			$ViewUser = D("ViewUser");
			$userlist = $ViewUser->where("`status_system` = '1'")->findall();
			$this->assign("userlist",$userlist);
			$this->display('baoming');
		}
		else
		$this->display('zituan');
	}
	
	
	
    public function baoming() {
		C('TOKEN_ON',false);
		if (md5($_REQUEST['verifyTest']) != session('verify'))
			$this->ajaxReturn($_REQUEST,'验证码错误,请刷新验证码并重新填写！', 0);
		else{
			//ajax测试
			if($_REQUEST['ajaxtest'] != 1)
				session('verify',null);
		}
		//检查dataOM
		$xiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价','开放');
		if(false === $xiaoshou)
			$this->ajaxReturn($_REQUEST,'权限错误！', 0);
		$Chanpin = D("Chanpin");
		$shoujia = $Chanpin->relation("shoujia")->where("`chanpinID` = '$_REQUEST[shoujiaID]'")->find();
		//检查子团ID
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$_REQUEST[zituanID]'")->find();
		if(false === $zituan || $zituan == '')
			$this->ajaxReturn($_REQUEST,'错误,请联系管理员！', 0);
		$this->assign("zituan",$zituan);
		//价格计算
		$shoujia['shoujia']['adultprice'] += $zituan['adultxiuzheng'];
		$shoujia['shoujia']['childprice'] += $zituan['childxiuzheng'];
		//检查数据
		//owner
		$ViewUser = D("ViewUser");
		if(!$ViewUser->where("`title` = '$_REQUEST[owner]'")->find()) 
			$this->ajaxReturn($_REQUEST,'错误,收客人错误！', 0);
		//联系人
		if(!$_REQUEST['lianxiren'] || !$_REQUEST['telnum'])
			$this->ajaxReturn($_REQUEST,'错误,联系人和电话必须！', 0);
		//人数及人数检查
		$tuanrenshu = A("Method")->_getzituandingdan($_REQUEST['zituanID'],$_REQUEST['shoujiaID']);
		$shoujia_renshu = $tuanrenshu['shoujiarenshu'];
		$baomingrenshu = $tuanrenshu['baomingrenshu'];
		if(($zituan['renshu'] - $baomingrenshu) < ($shoujia['shoujia']['renshu'] - $shoujia_renshu))
		$shengyurenshu = $zituan['renshu'] - $baomingrenshu;
		else
		$shengyurenshu = $shoujia['shoujia']['renshu'] - $shoujia_renshu;
		if($_REQUEST['chengrenshu'] + $_REQUEST['ertongshu'] + $_REQUEST['lingdui_num'] <= 0 )
			$this->ajaxReturn($_REQUEST,'错误,订单人数必须大于0！', 0);
		else{
			if($shengyurenshu - ($_REQUEST['chengrenshu'] + $_REQUEST['ertongshu'] + $_REQUEST['lingdui_num']) < 0)
			$this->ajaxReturn($_REQUEST,'错误,订单人数超出剩余，请联系计调！', 0);
		}
		//价格范围
		if($shoujia['shoujia']['adultprice'] - $shoujia['shoujia']['cut'] > $_REQUEST['adultprice'])
			$this->ajaxReturn($_REQUEST,'错误,成人售价超过可折扣范围！', 0);
		if($shoujia['shoujia']['childprice'] - $shoujia['shoujia']['cut'] > $_REQUEST['childprice'])
			$this->ajaxReturn($_REQUEST,'错误,儿童售价超过可折扣范围！', 0);
		//报名截止
		if(time()-strtotime(jisuanriqi($zituan['chutuanriqi'],$zituan['baomingjiezhi'],'减少')) > 0 )
		$this->ajaxReturn($_REQUEST,'错误,该团报名已经截止！', 0);
		//ajax测试
		if($_REQUEST['ajaxtest'] == 1)
			$this->ajaxReturn($_REQUEST,'成功！', 1);
			
		if($_REQUEST['status'] == '确认'){
			unset($_REQUEST['__hash__']);
			$renshu = $_REQUEST['chengrenshu']+$_REQUEST['ertongshu'];
			$_REQUEST['parentID'] = $_REQUEST['zituanID'];
			$this->assign("renshu",$renshu);
			$this->assign("_REQUEST",$_REQUEST);
			//tuanyuan
			for($i=0;$i<$_REQUEST['chengrenshu'];$i++){
				$tuanyuan[$i]['manorchild'] = '成人';
				$tuanyuan[$i]['price'] = $_REQUEST['adultprice'];
			}
			for($i;$i<$_REQUEST['chengrenshu']+$_REQUEST['ertongshu'];$i++){
				$tuanyuan[$i]['manorchild'] = '儿童';
				$tuanyuan[$i]['price'] = $_REQUEST['childprice'];
			}
			for($i;$i<$_REQUEST['chengrenshu']+$_REQUEST['ertongshu']+$_REQUEST['lingdui_num'];$i++){
				$tuanyuan[$i]['manorchild'] = '领队';
				$tuanyuan[$i]['price'] = 0;
			}
			//所属部门显示
			$ViewDepartment = D("ViewDepartment");
			$bumen = $ViewDepartment->where("`systemID` = '$_REQUEST[departmentID]' and `status_system` = '1'")->find();
			$this->assign("bumen",$bumen);
			$this->assign("tuanyuan",$tuanyuan);
			$this->display('baomingnext');
		}
		if($_REQUEST['status'] == '占位'){
			//生成订单
			$Chanpin = D("Chanpin");
			$data = $_REQUEST;
			$data['parentID'] = $data['zituanID'];
			$data['dingdan'] = $data;
			$data['dingdan']['jiage'] = $_REQUEST['chengrenshu']*$_REQUEST['adultprice']+$_REQUEST['ertongshu']*$_REQUEST['childprice'];
			$data['dingdan']['bumen_copy'] = cookie('_usedbumen');
			if (false !== $Chanpin->relation("dingdan")->myRcreate($data)){
				$chanpinID = $Chanpin->getRelationID();
				//生成OM
				$dataOMlist = A("Method")->_getDataOM($zituan['parentID'],'线路','管理');
				A("Method")->_createDataOM($chanpinID,'订单','管理',$dataOMlist);
				redirect(SITE_INDEX."Xiaoshou/dingdanxinxi/chanpinID/".$chanpinID);
			}
			else{
				justalert('错误，请联系管理员！');
				gethistoryback();
			}
			
		}
		
	
	}
	
	
	
    public function dopostbaoming() {
		C('TOKEN_ON',false);
		if (md5($_REQUEST['verifyTest']) != session('verify')) {  
				justalert('验证码错误,请刷新验证码并重新填写！');
				gethistoryback();
		  } 
		else
		session('verify',null);
		//检查dataOM
		$xiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价');
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
			//生成OM
			$dataOMlist = A("Method")->_getDataOM($zituan['parentID'],'线路','管理');
			A("Method")->_createDataOM($dingdanID,'订单','管理',$dataOMlist);
			//生成团员
			A("Method")->createCustomer_new($_REQUEST,$dingdanID);
			justalert('确认成功！');
			redirect(SITE_INDEX."Xiaoshou/dingdanxinxi/chanpinID/".$dingdanID);
		}
		justalert('错误，请联系管理员！');
		gethistoryback();
	}
	
	
	
	
    public function dingdanlist() {
		A("Method")->showDirectory("订单控管");
		$chanpin_list = A('Method')->getDataOMlist('订单','dingdan',$_REQUEST);
		$ViewDataDictionary = D("ViewDataDictionary");
		$i = 0;
		foreach($chanpin_list['chanpin'] as $v){
			//提成
			$chanpin_list['chanpin'][$i]['ticheng'] = $ViewDataDictionary->where("`systemID` = '$v[tichengID]'")->find();
			$i++;
		}
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('dingdanlist');
	}
	
	
	
	
    public function dingdanxinxi() {
		A("Method")->showDirectory("订单信息");
		//检查dataOM
		$dingdan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'订单','管理');
		if(false === $dingdan){
			$this->display('Index:error');
			exit;
		}
		$ViewDingdan = D("ViewDingdan");
		$dingdan = $ViewDingdan->relation("zituanlist")->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		//检查dataOM
		$xiaoshou = A('Method')->_checkDataOM($dingdan['shoujiaID'],'售价');
		if(false === $xiaoshou){
			$this->display('Index:error');
			exit;
		}
		$ViewShoujia = D("ViewShoujia");
		$shoujia = $ViewShoujia->where("`chanpinID` = '$dingdan[shoujiaID]'")->find();
		$this->assign("shoujia",$shoujia);
		//ticheng
		$ViewDataDictionary = D("ViewDataDictionary");
		$dingdan['ticheng'] = $ViewDataDictionary->where("`systemID` = '$dingdan[tichengID]'")->find();
		$this->assign("dingdan",$dingdan);
		//tuanyuan
		$tuanyuan = $ViewDingdan->relationGet("tuanyuanlist");
		if(!$tuanyuan){
			for($i=0;$i<$dingdan['chengrenshu'];$i++){
				$tuanyuan[$i]['manorchild'] = '成人';
				$tuanyuan[$i]['price'] = $shoujia['adultprice'];
			}
			for($i;$i<$dingdan['chengrenshu']+$dingdan['ertongshu'];$i++){
				$tuanyuan[$i]['manorchild'] = '儿童';
				$tuanyuan[$i]['price'] = $shoujia['childprice'];
			}
			for($i;$i<$dingdan['chengrenshu']+$dingdan['ertongshu']+$dingdan['lingdui_num'];$i++){
				$tuanyuan[$i]['manorchild'] = '领队';
				$tuanyuan[$i]['price'] = 0;
			}
		}
		$this->assign("tuanyuan",$tuanyuan);
		
		//提成数据
		$ticheng = $ViewDataDictionary->where("`type` = '提成' AND `status_system` = '1'")->findall();
		$this->assign("ticheng",$ticheng);
		//用户列表
		$ViewUser = D("ViewUser");
		$userlist = $ViewUser->where("`status_system` = '1'")->findall();
		$this->assign("userlist",$userlist);
		//获得个人部门及分类列表
		$bumenfeilei = A("Method")->_getbumenfenleilist();
		$this->assign("bumenfeilei",$bumenfeilei);
		if($_REQUEST['showtype'] == 1){
			A("Method")->showDirectory("子团产品");
			$this->assign("markpos",'订单信息');
			$this->assign("datatitle",' : "'.$dingdan['zituan']['title_copy'].'/团期'.$dingdan['zituan']['chutuanriqi'].'"');
			$this->display('Chanpin:dingdanxinxi');
		}
		else
		$this->display('dingdanxinxi');
	}
	
	
	
	
    public function dopostdingdanxinxi() {
		C('TOKEN_ON',false);
		//检查dataOM
		$dingdan = A('Method')->_checkDataOM($_REQUEST['dingdanID'],'订单','管理');
		if(false === $dingdan){
			$this->ajaxReturn($_REQUEST, '错误，无管理权限', 0);
		}
		$dingdanID = $_REQUEST['dingdanID'];
		$Chanpin = D("Chanpin");
		$dat = $Chanpin->relation("dingdan")->where("`chanpinID` = '$dingdanID'")->find();
		if($dat['islock'] == '已锁定'){
			$this->ajaxReturn($_REQUEST, '错误，订单已被锁定！', 0);
		}
		if($_REQUEST['tuanyuanmark'] == 1){
			//生成团员
			if( false === A("Method")->createCustomer_new($_REQUEST,$_REQUEST['dingdanID']))
			$this->ajaxReturn($_REQUEST, cookie('errormessage'), 0);
		}
		$dat['departmentID'] = $_REQUEST['departmentID'];
		$dat['dingdan']['lianxiren'] = $_REQUEST['lianxiren'];
		$dat['dingdan']['telnum'] = $_REQUEST['telnum'];
		$dat['dingdan']['tichengID'] = $_REQUEST['tichengID'];
		$dat['dingdan']['owner'] = $_REQUEST['owner'];
		$dat['status'] = $_REQUEST['status'];
		if( false !== $Chanpin->relation("dingdan")->myRcreate($dat))
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		else
			$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
	}
	
	
	
    public function quxiaodingdan() {
		C('TOKEN_ON',false);
		//检查dataOM
		$dingdan = A('Method')->_checkDataOM($_REQUEST['dingdanID'],'订单','管理');
		if(false === $dingdan){
			$this->display('Index:error');
			exit;
		}
		$dingdanID = $_REQUEST['dingdanID'];
		$Chanpin = D("Chanpin");
		$dat = $Chanpin->relation("dingdan")->where("`chanpinID` = '$dingdanID'")->find();
		if($dat['islock'] == '已锁定')
			$this->ajaxReturn($_REQUEST, '失败，该订单已经锁定，请审核回退后重试', 0);
		$dat['status_system'] = -1;
		if( false !== $Chanpin->relation("dingdan")->myRcreate($dat))
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		else
			$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
	}
	
	
	
	
    public function tuanyuanxinxi() {
		A("Method")->showDirectory("团员信息");
		$DataCD = D("DataCD");
		$dat = $DataCD->where("`id` = '$_REQUEST[id]'")->find();
		$this->assign("datacd",$dat);
		if($dat['datatext'])
			$dat = unserialize($dat['datatext']);
		else{//查询顾客表
			$ViewCustomer = D("ViewCustomer");
			if($dat['zhengjiantype'] == '身份证')
				$where['sfz_haoma'] = $dat['zhengjianhaoma'];
			if($dat['zhengjiantype'] == '护照')
				$where['hz_haoma'] = $dat['zhengjianhaoma'];
			if($dat['zhengjiantype'] == '通行证')
				$where['txz_haoma'] = $dat['zhengjianhaoma'];
			if($where)
			$cust = $ViewCustomer->where($where)->find();
			if($cust){
				$remark = $dat['remark'];
				$telnum = $dat['telnum'];
				$dat = $cust;
				$dat['id'] = $_REQUEST['id'];
				$dat['remark'] = $remark;
				$dat['telnum'] = $telnum;
			}
		}
		$this->assign("data",$dat);
		$this->display('tuanyuanxinxi');
	}
	
	
	
    public function doposttuanyuanxinxi() {
		C('TOKEN_ON',false);
		$DataCD = D("DataCD");
		$data = $_REQUEST;
		$dt = $DataCD->where("`id` = '$_REQUEST[id]'")->find();
		if($dt['zhengjiantype'] == '身份证')
			$data['zhengjianhaoma'] = $data['sfz_haoma'];
		if($dt['zhengjiantype'] == '护照')
			$data['zhengjianhaoma'] = $data['hz_haoma'];
		if($dt['zhengjiantype'] == '通行证')
			$data['zhengjianhaoma'] = $data['txz_haoma'];
		$data['datatext'] = serialize($_REQUEST);
		unset($data['remark']);
		if( false !== $DataCD->save($data))
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		else
			$this->ajaxReturn($_REQUEST, $DataCD->getError(), 0);
	}
	
	
    public function cleardingdan() {
		A("Method")->_cleardingdan();
	}
	
}
?>