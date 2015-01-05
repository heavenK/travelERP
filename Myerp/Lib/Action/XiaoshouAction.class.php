<?php

class XiaoshouAction extends Action{
	
    public function _initialize() {
        if (!$this->user)
            redirect(SITE_INDEX.'Index/index');
		$this->_myinit();	
    }
	
    public function _myinit() {
		$this->assign("navposition",'销售');
	}
	
	
    public function index() {
		if(!$_REQUEST['chanpintype']){
			$_REQUEST['chanpintype'] = '线路';
		}
		$this->assign("markpos",$_REQUEST['xianlu_kind']);
		A("Method")->showDirectory("线路产品");
		$chanpin_list = A('Method')->getDataOMlist('售价','shoujia',$_REQUEST,'开放');
		$ViewZituan = D("ViewZituan");
		$DataCopy = D("DataCopy");
		$System = D("System");
		$i = 0;
		foreach($chanpin_list['chanpin'] as $v){
			$zituan = $ViewZituan->where("`parentID` = '$v[parentID]' AND `status_system` = '1'")->findall();
			$xianlu = $DataCopy->where("`dataID` = '$v[parentID]' and `datatype` = '线路'")->order("time desc")->find();
			$xianlu = simple_unserialize($xianlu['copy']);
			if(false === $xianlu)
				$xianlu['xianlu'] = $zituan[0];
			$chanpin_list['chanpin'][$i]['xianlu'] = $xianlu;
			//剩余名额
			$jj = 0;
			foreach($zituan as $zt){
				//修正
				$shoujia = A("Method")->_zhidingxiaoshou_xiuzheng($v['chanpinID'],$zt['chanpinID']);
				$tuanrenshu = A("Method")->_getzituandingdan($zt['chanpinID'],$v['chanpinID']);
				$shoujia_renshu = $tuanrenshu['shoujiarenshu'];
				$baomingrenshu = $tuanrenshu['baomingrenshu'];
				$baoming_renshu[$zt['chanpinID']] = $tuanrenshu['baomingrenshu'];
				$zituan[$jj]['shoujia_renshu'] = $tuanrenshu['shoujiarenshu'];
				if(($zt['renshu'] - $baomingrenshu) < ($shoujia['renshu'] - $shoujia_renshu))
				$zituan[$jj]['shengyurenshu'] = $zt['renshu'] - $baomingrenshu;
				else
				$zituan[$jj]['shengyurenshu'] = $shoujia['renshu'] - $shoujia_renshu;
				$jj++;
			}
			$chanpin_list['chanpin'][$i]['zituan'] = $zituan;
			$i++;
		}
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->assign("baoming_renshu",$baoming_renshu);
		if($_REQUEST['chanpintype'] == '线路'){
			$this->display('index');
		}
		if($_REQUEST['chanpintype'] == '签证'){
			$this->display('index_qianzheng');
		}
    }
	
	
	
    public function zituan() {
		//检查dataOM
		if($_REQUEST['shoujiaID'] > 0){
			$xiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价','开放');
			if(false === $xiaoshou){
				$this->display('Index:error');
				exit;
			}
		}
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		if(!$zituan){
			$this->display('Index:error');
			exit;
		}
		$this->assign("zituan",$zituan);
		//
		$Chanpin = D("Chanpin");
		$DataCopy = D("DataCopy");
		$xianlu = $DataCopy->where("`dataID` = '$_REQUEST[xianluID]' and `datatype` = '线路'")->order("time desc")->find();
		$xianlu = simple_unserialize($xianlu['copy']);
		$xianlu['xianlu_ext'] = simple_unserialize($xianlu['xianlu']['xianlu_ext']);
		if(!$xianlu['xingcheng']){
			$xianlu_2 = $Chanpin->where("`chanpinID` = '$_REQUEST[xianluID]'")->find();
			$xianlu['xingcheng'] = $Chanpin->relationGet("xingchenglist");
		}
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
		//价格计算
		$shoujia = A("Method")->_zhidingxiaoshou_xiuzheng($_REQUEST['shoujiaID'],$_REQUEST['chanpinID']);
		$this->assign("shoujia",$shoujia);
		//计算子团人数
		$tuanrenshu = A("Method")->_getzituandingdan($_REQUEST['chanpinID'],$_REQUEST['shoujiaID']);
		$shoujia_renshu = $tuanrenshu['shoujiarenshu'];
		$baomingrenshu = $tuanrenshu['baomingrenshu'];
		if(($zituan['renshu'] - $baomingrenshu) < ($shoujia['renshu'] - $shoujia_renshu))
			$shengyurenshu = $zituan['renshu'] - $baomingrenshu;
		else
			$shengyurenshu = $shoujia['renshu'] - $shoujia_renshu;
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
		if($zituan['status_baozhang'] != '批准'){
			if($_REQUEST['shoujiaID'] > 0 && $zituan['status'] != '截止'){
				//报名截止
				if(time()-strtotime(jisuanriqi($zituan['chutuanriqi'],$zituan['baomingjiezhi'],'减少')) <= 0 )
				$this->assign("baoming_root",1);
			}
//			;
//			else
//			if($_REQUEST['shoujiaID'] > 0)
//			$this->assign("baoming_root",1);
		}
		//行程一
		$datatext = simple_unserialize($xianlu['xianlu']['datatext']);
		$xingcheng_1 = $datatext['xingcheng'];
		$this->assign("xingcheng_1",$xingcheng_1);
		//显示
		if($_REQUEST['doprint'] == '打印'){
			$company_d = M("Myerp_system_department");
			$company_info = $company_d->where("systemID=".$this->user['companyID'])->find();
			//dump($this->user);
			
			$shop_info_list = D('ViewDepartment')->where("parentID=".$this->user['companyID']." AND type LIKE '%销售%' AND islock='未锁定'")->select();
		
			$this->assign("shop_info_list",$shop_info_list);
			$this->assign("company_info",$company_info);
		}
		if($_REQUEST['doprint'] == '打印')
		$this->display('printzituan');
		else
		if($_REQUEST['dobaoming'] == '报名'){
			//获得个人部门及分类列表
			$bumenfeilei = A("Method")->_getbumenfenleilist();
			$this->assign("bumenfeilei",$bumenfeilei);
			//清空占位过期订单
			A('Method')->_cleardingdan();
			$userlist = A("Method")->_getCompanyUserList();
			$this->assign("userlist",$userlist);
			$this->display('baoming');
		}
		else
		$this->display('zituan');
	}
	
	
    public function qianzheng() {
		//检查dataOM
		if($_REQUEST['shoujiaID'] > 0){
			$xiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价','开放');
			if(false === $xiaoshou){
				$this->display('Index:error');
				exit;
			}
		}
		$Chanpin = D("Chanpin");
		$ViewShoujia = D("ViewShoujia");
		$shoujia = $ViewShoujia->where("`chanpinID` = '$_REQUEST[shoujiaID]'")->find();
		//价格计算
		$this->assign("shoujia",$shoujia);
		$DataCopy = D("DataCopy");
		$qianzheng = $DataCopy->where("`dataID` = '$_REQUEST[chanpinID]' and `datatype` = '签证'")->order("time desc")->find();
		if(!$qianzheng){
			$this->display('Index:error');
			exit;
		}
		$qianzheng = simple_unserialize($qianzheng['copy']);
		$qianzheng = $qianzheng['qianzheng'];
		$this->assign("qianzheng",$qianzheng);
		//创建人信息
		$ViewDepartment = D("ViewDepartment");
		$durlist = A('Method')->_getDURlist_name($qianzheng['user_name']);
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
		if($zituan['status_baozhang'] != '批准'){
			if($_REQUEST['shoujiaID'] > 0 && $zituan['status'] != '截止'){
				//报名截止
				$this->assign("baoming_root",1);
			}
		}
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
			$userlist = A("Method")->_getCompanyUserList();
			$this->assign("userlist",$userlist);
			$this->display('baoming_qianzheng');
		}
		else
		$this->display('qianzheng');
	}
	
	
    public function _ckeck_baoming() {
		//检查数据
		//owner
		$ViewUser = D("ViewUser");
		if(!$ViewUser->where("`title` = '$_REQUEST[owner]'")->find()) 
			$this->ajaxReturn($_REQUEST,'错误,收客人错误！', 0);
		//联系人
		if(!$_REQUEST['lianxiren'] || !$_REQUEST['telnum'])
			$this->ajaxReturn($_REQUEST,'错误,联系人和电话必须！', 0);
		//产品检查
		$Chanpin = D("Chanpin");
		$cp = $Chanpin->where("`chanpinID` = '$_REQUEST[parentID]'")->find();
		if($cp['marktype'] == 'zituan'){
			$chanpintype = '子团';
			$ViewZituan = D("ViewZituan");
			$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$_REQUEST[parentID]'")->find();
			if(false === $zituan || $zituan == '')
				$this->ajaxReturn($_REQUEST,'错误,请联系管理员！', 0);
			$this->assign("zituan",$zituan);
		}
		if($cp['marktype'] == 'qianzheng'){
			$ViewQianzheng = D("ViewQianzheng");
			$qianzheng = $ViewQianzheng->where("`chanpinID` = '$_REQUEST[parentID]'")->find();
			
			if(false === $qianzheng || $qianzheng == '')
				$this->ajaxReturn($_REQUEST,'错误,请联系管理员！', 0);
			$this->assign("chanpin",$qianzheng);
		}
		//计调报名，脱离销售
		if($_REQUEST['backdoor'] == 1){
			if($chanpintype == '子团'){
				//检查dataOM
				$xiaoshou = A('Method')->_checkDataOM($_REQUEST['parentID'],'子团','管理');
				if(false === $xiaoshou)
					$this->ajaxReturn($_REQUEST,'权限错误,无子团管理权限！', 0);
				//人数及人数检查
				$tuanrenshu = A("Method")->_getzituandingdan($_REQUEST['parentID']);
				$baomingrenshu = $tuanrenshu['baomingrenshu'];
				$shengyurenshu = $zituan['renshu'] - $baomingrenshu;
			}
			if($chanpintype == '签证'){
				//检查dataOM
				$xiaoshou = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'签证','管理');
				if(false === $xiaoshou)
					$this->ajaxReturn($_REQUEST,'权限错误,无签证管理权限！', 0);
			}
		}
		else{
			if($_REQUEST['shoujiaID'] > 0){
				$xiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价','开放');
				if(false === $xiaoshou)
					$this->ajaxReturn($_REQUEST,'权限错误！', 0);
				$shoujia = A("Method")->_zhidingxiaoshou_xiuzheng($_REQUEST['shoujiaID'],$_REQUEST['parentID']);
			}
			//子团控制
			if($chanpintype == '子团'){
				if($shoujia['cut'] < 0)//折扣不能为负
					$shoujia['cut'] = 0;
				//正常报名检查
				if($_REQUEST['shoujiaID'] > 0){	
					if($zituan['status_baozhang'] == '批准')
						$this->ajaxReturn($_REQUEST,'错误,该团报名已经报账，无法报名！', 0);
					if($_REQUEST['shoujiaID'] > 0)	
						if(time()-strtotime(jisuanriqi($zituan['chutuanriqi'],$zituan['baomingjiezhi'],'减少')) > 0 ){
								$this->ajaxReturn($_REQUEST,'报名截止已过，请补订订单！', 0);
						}
					//报名截止
					if($zituan['status'] == '截止')
						$this->ajaxReturn($_REQUEST,'该团期已经截止报名！', 0);
				}
				else{
					if($zituan['status'] == '截止' || $zituan['status_baozhang'] == '批准' || time()-strtotime(jisuanriqi($zituan['chutuanriqi'],$zituan['baomingjiezhi'],'减少')) > 0 )
						;
					else
						$this->ajaxReturn($_REQUEST,'请正常提交订单！', 0);
				}
				$tuanrenshu = A("Method")->_getzituandingdan($_REQUEST['parentID'],$_REQUEST['shoujiaID']);
				$shoujia_renshu = $tuanrenshu['shoujiarenshu'];
				$baomingrenshu = $tuanrenshu['baomingrenshu'];
				if($_REQUEST['shoujiaID'] > 0){
					if(($zituan['renshu'] - $baomingrenshu) < ($shoujia['renshu'] - $shoujia_renshu)){
						$shengyurenshu = $zituan['renshu'] - $baomingrenshu;
					}
					else
					$shengyurenshu = $shoujia['renshu'] - $shoujia_renshu;
				}
				else
					$shengyurenshu = $zituan['renshu'] - $baomingrenshu;
					
				if($shengyurenshu - ($_REQUEST['chengrenshu'] + $_REQUEST['ertongshu'] + $_REQUEST['lingdui_num']) < 0)
				$this->ajaxReturn($_REQUEST,'错误,订单人数超出剩余，请联系计调！', 0);
			}
			
			$this->ajaxReturn($_REQUEST,$shengyurenshu, 0);
			
			
			//价格范围
			if($shoujia['adultprice'] - $shoujia['cut'] > $_REQUEST['adultprice'])
				$this->ajaxReturn($_REQUEST,'错误,成人售价超过可折扣范围！', 0);
			if($shoujia['childprice'] - $shoujia['cut'] > $_REQUEST['childprice'])
				$this->ajaxReturn($_REQUEST,'错误,儿童售价超过可折扣范围！', 0);
		}
		$this->ajaxReturn($_REQUEST,$chanpintype, 0);
		//检查人数
		if($_REQUEST['chengrenshu'] + $_REQUEST['ertongshu'] + $_REQUEST['lingdui_num'] <= 0 )
			$this->ajaxReturn($_REQUEST,'错误,订单人数必须大于0！', 0);
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
		if(!$_REQUEST['chanpintype'])
			$chanpintype = '子团';
		else
			$chanpintype = $_REQUEST['chanpintype'];
		$this->_ckeck_baoming($chanpintype);
		
		//ajax测试
		if($_REQUEST['ajaxtest'] == 1)
			$this->ajaxReturn($_REQUEST,'成功！', 1);
		if($chanpintype == '子团'){	
			  unset($_REQUEST['__hash__']);
			  $renshu = $_REQUEST['chengrenshu']+$_REQUEST['ertongshu'];
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
			  //团
			  $ViewZituan = D("ViewZituan");
			  $zituan = $ViewZituan->where("`chanpinID` = '$_REQUEST[parentID]' and `status_system` = '1'")->find();
			  $this->assign("zituan",$zituan);
			  //计算子团人数
			  $tuanrenshu = A("Method")->_getzituandingdan($_REQUEST['parentID']);
			  $baomingrenshu = $tuanrenshu['baomingrenshu'];
			  $shengyurenshu = $zituan['renshu'] - $baomingrenshu;
			  $this->assign("shengyurenshu",$shengyurenshu);
			
			  $this->display('baomingnext');
		}
		else{
			if($chanpintype == '子团' && $_REQUEST['status'] == '占位'){	
				  $Chanpin = D("Chanpin");
				  $data = $_REQUEST;
				  $data['parentID'] = $data['parentID'];
				  $data['dingdan'] = $data;
				  $data['dingdan']['jiage'] = $_REQUEST['chengrenshu']*$_REQUEST['adultprice']+$_REQUEST['ertongshu']*$_REQUEST['childprice'];
				  $data['dingdan']['bumen_copy'] = cookie('_usedbumen');
			}
			if($chanpintype == '签证'){
				  //tuanyuan
				  for($i=0;$i<$_REQUEST['chengrenshu'];$i++){
					  $tuanyuan[$i]['manorchild'] = '成人';
					  $tuanyuan[$i]['price'] = $_REQUEST['adultprice'];
				  }
				  for($i;$i<$_REQUEST['chengrenshu']+$_REQUEST['ertongshu'];$i++){
					  $tuanyuan[$i]['manorchild'] = '儿童';
					  $tuanyuan[$i]['price'] = $_REQUEST['childprice'];
				  }
					
				
				  //部门
				  $ViewDepartment = D("ViewDepartment");
				  $bumen = $ViewDepartment->where("`systemID` = '$_REQUEST[departmentID]' and `status_system` = '1'")->find();
				  $this->assign("bumen",$bumen);
				  $this->assign("tuanyuan",$tuanyuan);
				  
				  //签证
				  $ViewQianzheng = D("ViewQianzheng");
				  $qianzheng = $ViewQianzheng->where("`chanpinID` = '$_REQUEST[parentID]' and `status_system` = '1'")->find();
				  $this->assign("qianzheng",$qianzheng);
				  
				  
				  
				  
				  $Chanpin = D("Chanpin");
				  $data = $_REQUEST;
				  $data['parentID'] = $data['parentID'];
				  $data['dingdan'] = $data;
				  $data['dingdan']['jiage'] = $_REQUEST['chengrenshu']*$_REQUEST['adultprice']+$_REQUEST['ertongshu']*$_REQUEST['childprice'];
				  $data['dingdan']['bumen_copy'] = cookie('_usedbumen');
				  
				  
				  $this->display('baomingnext_qianzheng');
				  exit;
			}
			if($dingdan = A("Method")->_dingdansave_process($data,$this->user['title'])){
				redirect(SITE_INDEX."Xiaoshou/dingdanxinxi/chanpinID/".$dingdan['chanpinID']);
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
		$chanpinID = $_REQUEST['parentID'];
		$this->_ckeck_baoming();
		
		if($_REQUEST['type'] == '签证'){
			$ViewQianzheng = D("ViewQianzheng");
			$qianzheng = $ViewQianzheng->where("`chanpinID` = '$chanpinID'")->find();
			
			
			if(false === $qianzheng || $qianzheng == ''){
				$this->display('Index:error');
				exit;
			}
		}else{
			//检查子团ID
			$ViewZituan = D("ViewZituan");
			$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
			if(false === $zituan || $zituan == ''){
				$this->display('Index:error');
				exit;
			}
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
		$dingdan = A("Method")->_dingdansave_process($data,$this->user['title']);
		if($dingdan)
			redirect(SITE_INDEX."Xiaoshou/dingdanxinxi/chanpinID/".$dingdan['chanpinID']);
//		justalert(cookie('errormessage'));
//		gethistoryback();
	}
	
	
	
	
    public function dingdanlist() {
		if($_REQUEST['status_shenhe']){
			$this->assign("markpos",$_REQUEST['status_shenhe']);
		}
		if($_REQUEST['status']){
			$this->assign("markpos",$_REQUEST['status']);
		}
		
		A("Method")->showDirectory("订单控管");
		$chanpin_list = A('Method')->getDataOMlist('订单','dingdan',$_REQUEST);
		$ViewDataDictionary = D("ViewDataDictionary");
		$DataCD = D("DataCD");
		$i = 0;
		foreach($chanpin_list['chanpin'] as $v){
			//提成
			$chanpin_list['chanpin'][$i]['ticheng'] = $ViewDataDictionary->where("`systemID` = '$v[tichengID]'")->find();
		//新老客户数
			$chanpin_list['chanpin'][$i]['xinkehu_num'] = $DataCD->where("`dingdanID` = '$v[chanpinID]' and `laokehu` = '0'")->count();
			$chanpin_list['chanpin'][$i]['laokehu_num'] = $DataCD->where("`dingdanID` = '$v[chanpinID]' and `laokehu` = '1'")->count();
			$i++;
		}
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		if($_REQUEST['user_name'] == '电商'){
			$this->assign("navposition",'电商管理');
			A("Method")->showDirectory("电商订单管理");
			$this->display('Xiaoshou:dingdanlist_web');
		}
		else{
			A("Method")->showDirectory("订单控管");
			$this->display('Xiaoshou:dingdanlist');
		}
	}
	
	
	
	
    public function dingdanxinxi() {
		A("Method")->showDirectory("订单信息");
		//检查dataOM
		$dingdan = A('Method')->_checkDataOM($_REQUEST['chanpinID'],'订单','管理');
		if(false === $dingdan){
			$this->assign("message",'权限错误');
			$this->display('Index:error');
			exit;
		}
		$ViewDingdan = D("ViewDingdan");
		$dingdan = $ViewDingdan->relation("zituanlist")->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		if($dingdan['shoujiaID']> 0 ){
//			$ViewShoujia = D("ViewShoujia");
			//$shoujia = $ViewShoujia->where("`chanpinID` = '$dingdan[shoujiaID]'")->find();
			//修正
			$shoujia = A("Method")->_zhidingxiaoshou_xiuzheng($dingdan['shoujiaID'],$dingdan['parentID']);
			$this->assign("shoujia",$shoujia);
		}
		//提成操作费
		$ViewDataDictionary = D("ViewDataDictionary");
		$dingdan['ticheng'] = $ViewDataDictionary->where("`systemID` = '$dingdan[tichengID]'")->find();
		$dingdan['caozuofei'] = $ViewDataDictionary->where("`systemID` = '$dingdan[caozuofeiID]'")->find();
		$this->assign("dingdan",$dingdan);
		//if($dingdan['type'] != '签证' ){
			//tuanyuan
			$tuanyuan = $ViewDingdan->relationGet("tuanyuanlist");
			$this->assign("tuanyuan_has",1);
			if(!$tuanyuan){
				$this->assign("tuanyuan_has",0);
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
			$i = 0;
			foreach($tuanyuan as $v){
				$tuanyuan[$i]['datatext'] = simple_unserialize($v['datatext']);
				$i++;
			}
			
			//备忘
			$DataRemark = D("DataRemark");
			$remarkall = $DataRemark->where("`dataID` = '$_REQUEST[chanpinID]' AND `datatype` = '订单'")->findall();
			$this->assign("remarkall",$remarkall);
			
			$this->assign("tuanyuan",$tuanyuan);
		//}

		//提成数据操作费
		$ticheng = $ViewDataDictionary->where("`type` = '提成' AND `status_system` = '1'")->findall();
		$this->assign("ticheng",$ticheng);
		$caozuofei = $ViewDataDictionary->where("`type` = '操作费' AND `status_system` = '1'")->findall();
		$this->assign("caozuofei",$caozuofei);
		//用户列表
		$userlist = A("Method")->_getCompanyUserList();
		$this->assign("userlist",$userlist);
		//获得个人部门及分类列表
		$bumenfeilei = A("Method")->_getbumenfenleilist();
		$this->assign("bumenfeilei",$bumenfeilei);
		//签字
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$task = $ViewTaskShenhe->where("`dataID` = '$dingdan[chanpinID]' and `datatype` = '订单' and `status` != '待检出' and `status_system` = '1'")->order("processID asc ")->findall();
		$this->assign("task",$task);
		if($_REQUEST['showtype'] == 1){
			A("Method")->showDirectory("子团产品");
			$this->assign("markpos",'订单信息');
			$this->assign("datatitle",' : "'.$dingdan['zituanlist']['title_copy'].'/团期'.$dingdan['zituanlist']['chutuanriqi'].'"');
			$this->display('Chanpin:dingdanxinxi');
		}
		else{
			if($dingdan['type'] == '签证')
			$this->display('Qianzheng:dingdanxinxi');
			else
			$this->display('dingdanxinxi');
		}
	}
	
	
	
	
    public function dopostdingdanxinxi() {
		C('TOKEN_ON',false);
		//检查dataOM
		$dingdan = A('Method')->_checkDataOM($_REQUEST['dingdanID'],'订单','管理');
		
		if(false === $dingdan){
			$this->ajaxReturn($_REQUEST, '错误，无管理权限', 0);
		}
		
		$ViewDingdan = D("ViewDingdan");
		$dingdan = $ViewDingdan->where("`chanpinID` = '$_REQUEST[dingdanID]'")->find();
		//检查dataOM
		if($dingdan['status_baozhang'] != '批准'){
			//检查dataOM
			$zituanOM = A('Method')->_checkDataOM($dingdan['parentID'],'子团','管理');
			
			if(false === $zituanOM){
				
				if($_REQUEST['shoujiaID'])
				{
					$xiaoshou = A('Method')->_checkDataOM($dingdan['shoujiaID'],'售价');
					if(false === $xiaoshou){
						
						// modify by heavenK 订单修改返回错误，XML无法解析。
						
						$this->ajaxReturn($_REQUEST, "您没有管理权限", 0);
						//$this->assign("message",'权限错误2');
						//$this->display('Index:error');
						exit;
					}
				}
			}
		}
		else{
			$this->ajaxReturn($_REQUEST, '错误，订单已过审核，不许修改！', 0);
		}
		
		
		$dingdanID = $_REQUEST['dingdanID'];
		$Chanpin = D("Chanpin");
		$dat = $Chanpin->relation("dingdan")->where("`chanpinID` = '$dingdanID'")->find();
		if($dat['islock'] == '已锁定'){
			$this->ajaxReturn($_REQUEST, '错误，订单已被锁定！', 0);
		}
		if($_REQUEST['tuanyuanmark'] == 1){
			if($_REQUEST['daokuanqueren'] == 1){
				$dat['islock'] = '已锁定';
				$durlist = A("Method")->_checkRolesByUser('出纳,会计,财务,财务总监','行政');
				if(false === $durlist){
					$this->ajaxReturn($_REQUEST, '错误，无财财务或出纳权限！', 0);
				}
			}
			//生成团员
			if( false === A("Method")->createCustomer_new($_REQUEST,$_REQUEST['dingdanID']))
			$this->ajaxReturn($_REQUEST, cookie('errormessage'), 0);
			else
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		if($_REQUEST['status'] == '确认'){
			$DataCD = D("DataCD");
			$num = $DataCD->where("`dingdanID` = '$dingdanID'")->count();
			$dingdanrenshu = $dat['dingdan']['chengrenshu'] + $dat['dingdan']['ertongshu'] + $dat['dingdan']['lingdui_num'];
			if($num != $dingdanrenshu)
			$this->ajaxReturn($_REQUEST, '错误！请完善游客数据后确认订单！', 0);
		}
		
		$dat['dingdan']['lianxiren'] = $_REQUEST['lianxiren'];
		$dat['dingdan']['telnum'] = $_REQUEST['telnum'];
		$dat['dingdan']['tichengID'] = $_REQUEST['tichengID'];
		$dat['dingdan']['caozuofeiID'] = $_REQUEST['caozuofeiID'];
		$dat['dingdan']['tuandui_ticheng'] = $_REQUEST['tuandui_ticheng'];
		//电商不许修改
		if(!$dat['dingdan']['orderID']){
			$dat['dingdan']['owner'] = $_REQUEST['owner'];
			$dat['departmentID'] = $_REQUEST['departmentID'];
		}
		$dat['dingdan']['fuzeren'] = $_REQUEST['fuzeren'];
		$dat['dingdan']['lxr_address'] = $_REQUEST['lxr_address'];
		$dat['dingdan']['lxr_email'] = $_REQUEST['lxr_email'];
		$dat['status'] = $_REQUEST['status'];
		if( false !== $Chanpin->relation("dingdan")->myRcreate($dat)){
				
			
			if($_REQUEST['type'] == 'all') {
				$_REQUEST = $dingdan;
				A('Method')->_dosavebaozhangitem_auto($data['type']);
			}
//			if($_REQUEST['status'] == '确认'){
//				$_REQUEST['dataID'] = $dingdanID;
//				$_REQUEST['datatype'] = '订单';
//				$_REQUEST['dotype'] = '申请';
//				A("Method")->_autoshenqing();
//			}
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else{
			$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
		}
	}
	
	
	
    public function dingdan_daokuanqueren() {
		C('TOKEN_ON',false);
		//检查dataOM
		$dingdan = A('Method')->_checkDataOM($_REQUEST['dingdanID'],'订单','管理');
		if(false === $dingdan){
			$this->ajaxReturn($_REQUEST, '错误，无管理权限', 0);
		}
		$dingdanID = $_REQUEST['dingdanID'];
		$Chanpin = D("Chanpin");
		$dat = $Chanpin->relation("dingdan")->where("`chanpinID` = '$dingdanID'")->find();
//		if($dat['islock'] == '已锁定'){
//			$this->ajaxReturn($_REQUEST, '错误，订单已被锁定！', 0);
//		}
		$dat['islock'] = '已锁定';
		$dat['dingdan']['ispay'] = '已付款';
		$dat['dingdan']['pay_method'] = $_REQUEST['pay_method'];
		
		$durlist = A("Method")->_checkRolesByUser('出纳,会计,财务,财务总监','行政');
		if(false === $durlist){
			$this->ajaxReturn($_REQUEST, '错误，无财财务或出纳权限！', 0);
		}
		if( false !== $Chanpin->relation("dingdan")->myRcreate($dat))
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		else{
			$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
		}
	}
	
	
	
    public function quxiaodingdan() {
		C('TOKEN_ON',false);
		//检查dataOM
		$om = A('Method')->_checkDataOM($_REQUEST['dingdanID'],'订单','管理');
		if(false === $om){
			$this->ajaxReturn($_REQUEST, '错误，没有管理权限！', 0);
		}
		//判断订单状态
		$ViewDingdan = D("ViewDingdan");
		$dingdan = $ViewDingdan->where("`chanpinID` = '$_REQUEST[dingdanID]'")->find();
		if($dingdan['status_shenhe'] == '批准'){
			  $this->ajaxReturn($_REQUEST, '订单已经被审核，请审核回退后取消！', 0);
		}
		if($dingdan['status'] == '确认'){
			$durlist = A("Method")->_checkRolesByUser('经理,计调','组团',1);
			if(false === $durlist){
			  $this->ajaxReturn($_REQUEST, '订单已经确认，请联系计调取消订单！', 0);
			}
		}
		$dingdanID = $_REQUEST['dingdanID'];
		$Chanpin = D("Chanpin");
		$dat = $Chanpin->relation("dingdan")->where("`chanpinID` = '$dingdanID'")->find();
//		if($dat['islock'] == '已锁定')
//			$this->ajaxReturn($_REQUEST, '失败，该订单已经锁定，请审核回退后重试', 0);
		$dat['status_system'] = -1;
		if( false !== $Chanpin->relation("dingdan")->myRcreate($dat)){
			//相应审核任务
			A('Method')->_taskshenhe_delete($_REQUEST['dingdanID'],'订单');
			//开放删除
			$DataOM = D("DataOM");
			$where_om['dataID'] = $dingdanID;
			$where_om['datatype'] = '订单';
			$where_om['status'] = array('neq','指定');
			$DataOM->where($where_om)->delete();

			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else
			$this->ajaxReturn($_REQUEST, '错误，请联系管理员', 0);
	}
	
	
	
	
    public function tuanyuanxinxi() {
		A("Method")->showDirectory("团员信息");
		$DataCD = D("DataCD");
		$dat = $DataCD->where("`id` = '$_REQUEST[id]'")->find();
		$this->assign("datacd",$dat);
		if($dat['datatext']){
			$dat = simple_unserialize($dat['datatext']);
			if($dat['datatext'])		
			$dat = simple_unserialize($dat['datatext']);
		}
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
		if($dt['zhengjiantype'] == '身份证'){
			$data['zhengjianhaoma'] = $data['sfz_haoma'];
			$data['zhengjianyouxiaoqi'] = $data['sfz_youxiaoqi'];
		}
		if($dt['zhengjiantype'] == '护照'){
			$data['zhengjianhaoma'] = $data['hz_haoma'];
			$data['zhengjianyouxiaoqi'] = $data['hz_youxiaoqi'];
		}
		if($dt['zhengjiantype'] == '通行证'){
			$data['zhengjianhaoma'] = $data['txz_haoma'];
			$data['zhengjianyouxiaoqi'] = $data['txz_youxiaoqi'];
		}
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
	
	
	public function zituanlist() {
		$chanpin_list = A("Method")->_zituanlist('补订订单');
	}
	
	
	//添加订单
    public function zituanbaoming() {
		A("Method")->_chanpinbaoming('前台');	
	}
	
	public function quxiaocantuan(){
		C('TOKEN_ON',false);
		$tuanyuanID = $_REQUEST['tuanyuanID'];
		$DataCD = D("DataCD");
		$Chanpin = D("Chanpin");
		$ViewDingdan = D("ViewDingdan");
		$tuanyuan = $DataCD->where("`id` = '$tuanyuanID'")->find();
		//判断
		$dingdan = $ViewDingdan->where("`chanpinID` = '$tuanyuan[dingdanID]'")->find();
		if(!$dingdan)
			$this->ajaxReturn('', '错误！！！', 0);
		elseif($dingdan['status_shenhe'] == '批准')
			$this->ajaxReturn('', '订单已经被审核，请审核回退后操作！！！', 0);
		if($tuanyuan){
			//删除团员
			if($DataCD->where("`id` = '$tuanyuanID'")->delete()){
				  $tuanyuanall = $DataCD->where("`dingdanID` = '$dingdan[chanpinID]'")->findall();
				  $data['dingdan']['chengrenshu'] = 0;
				  $data['dingdan']['ertongshu'] = 0;
				  $data['dingdan']['lindui_num'] = 0;
				  $data['dingdan']['jiage'] = 0;
				  foreach($tuanyuanall as $v){
					  if($v['manorchild'] == '成人')
					  $data['dingdan']['chengrenshu'] += 1;
					  if($v['manorchild'] == '儿童')
					  $data['dingdan']['ertongshu'] += 1;
					  if($v['is_leader'] == '领队')
					  $data['dingdan']['lindui_num'] += 1;
					  $data['dingdan']['jiage'] += $v['jiage'];
				  }
				  $data['chanpinID'] = $dingdan['chanpinID'];
				  if(false !== $Chanpin->relation("dingdan")->myRcreate($data))
					  $this->ajaxReturn($_REQUEST, '取消成功！', 1);
				  else
					  $this->ajaxReturn($_REQUEST, $DataCD->getError(), 0);
			}
		}
		
		
	}
	
	//备忘
	public function dopost_dataremark(){
		$data = $_REQUEST;
		$DataRemark = D("DataRemark");
//		if($_REQUEST['id'])
//			$data['id'] = $_REQUEST['id'];
		if(!$_REQUEST['content'])	
			$this->ajaxReturn($_REQUEST, '内容不能为空', 0);
		$data['content'] = $_REQUEST['content'];
		$data['copy'] = serialize($data);
		if($DataRemark->mycreate($data))
			$this->ajaxReturn($_REQUEST, '取消成功！', 1);
		else
			$this->ajaxReturn($_REQUEST, $DataRemark->getError(), 0);
	}
	
	
	
	
	//备忘
	public function zhifuchaxun(){
		$orderNo = $_REQUEST['orderNo'];
		if(!$orderNo)
			$orderNo = 0;
		$orderID = $_REQUEST['orderID'];
		$res = A("Method")->_NH_zhifuchaxun($orderNo,$orderID);
		$this->ajaxReturn($res, '查询成功！', 1);
	}
	
	
	
	
	
	

	
}
?>