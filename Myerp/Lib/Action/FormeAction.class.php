<?php

class FormeAction extends Action{
    public function _initialize() {
		exit;
		if($this->user['title'] != 'aaa'){
			$this->display('Index:error');
			exit;
		}
	}
	
    public function index() {
		$this->display('Index:forme');
	}
	
	//游客生成
    public function doCustomer() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$gltuanyuan = M("gltuanyuan");
		if(!$_REQUEST['page']){
				dump('无page参数');
		exit;
		}
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num = ($_REQUEST['page']-1)*400;
		$tuanyuanall = $gltuanyuan->order('time asc')->limit("$num,400")->findall();
		if(count($tuanyuanall)==0)
		exit;
		dump("共".count($gltuanyuan->findall()).'个'.'<br>');
		//$tuanyuanall = $gltuanyuan->findall();
		$System = D("System");
		$gldingdan = M("gldingdan");
		$jishu_xianlu = 0;
		foreach($tuanyuanall as $v){
			dump("正在执行".$num+(++$jishu_xianlu).'个'.$v['tuanyuanID'].'<br>');
			if($v['name']){
				if($v['zhengjianhaoma']){
					$data = $v;
					$data['customer'] = $v;
					$data['customer']['remark'] = $v['xuqiu'].'，'.$v['beizhu'];
					//护照
					$c=explode("E",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['hz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['hz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					$c=explode("G",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['hz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['hz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					$c=explode("P",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['hz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['hz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					$c=explode("S",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['hz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['hz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					$c=explode("D",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['hz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['hz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					//外国
					$c=explode("Q",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['hz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['hz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					$c=explode("N",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['hz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['hz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					$c=explode("M",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['hz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['hz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					//通行证
					$c=explode("W",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['txz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['txz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					$c=explode("T",$v['zhengjianhaoma']); 
					if(count($c)> 1){
						$data['customer']['txz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['txz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					//身份证
					$c=strlen($v['zhengjianhaoma']); 
					if($c == 18) {
						$data['customer']['sfz_haoma'] = $v['zhengjianhaoma'];
						$data['customer']['sfz_youxiaoqi'] = $v['zhengjianyouxiaoqi'];
					}
					if($data['customer']['hz_haoma'])
					$where['hz_haoma'] = $data['customer']['hz_haoma'];
					if($data['customer']['txz_haoma'])
					$where['txz_haoma'] = $data['customer']['txz_haoma'];
					if($data['customer']['sfz_haoma'])
					$where['sfz_haoma'] = $data['customer']['sfz_haoma'];
					$ViewCustomer = D("ViewCustomer");
					$cus = $ViewCustomer->where($where)->find();
					if($cus)
						continue;
					if(false === $System->relation("customer")->myRcreate($data)){
						dump(7825222);
						dump($System);
						exit;
					}
				}
			}
			else
			continue;
		}
		$url = SITE_INDEX."Forme/doCustomer/page/".($_REQUEST['page']+1);
		$this->assign("url",$url);
		$this->display('Index:forme');
		echo "结束";
	}
	
	
	//基础数据
    public function fillSystemAll() {
 		$this->_filldepartment();
 		$this->_filldatadictionary();
		$this->_fillrole();
		$this->_filluser();
	}
	
	
	//生成单项服务报账单----------------------
	public function danxiangfuwu_build(){
		//生成随团单项服务报账单----------------------
		$this->_danxiangfuwu_build($dat,'','独立');
	}
	
	
	//线路
    public function chanpinxianlu() {
		echo "开始";
		echo "<br>";
		set_time_limit(0);
		C('TOKEN_ON',false);
		$gl_xianlu=M("glxianlu");
		if(!$_REQUEST['page']){
				dump('无page参数');
		exit;
		}
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num = ($_REQUEST['page']-1)*50;
		$xianluAll = $gl_xianlu->order('time asc')->limit("$num,50")->findall();
		if(count($xianluAll)==0)
		exit;
		//$xianluAll = $gl_xianlu->order('time asc')->where("`xianluID` = '336'")->findall();
		$Chanpin=D("Chanpin");
		$glxianlujiage = M("glxianlujiage");
		$glzituan=M("glzituan");
		$gl_baozhang=M("gl_baozhang");
		
		dump("共".count($gl_xianlu->findall()).'个线路'.'<br>');
		$jishu_xianlu = 0;
		foreach($xianluAll as $v)
		{
			dump("正在执行".$num+(++$jishu_xianlu).'个线路ID'.$v['xianluID'].'<br>');
			$dat = $v;
			$dat['xianlu'] = $v;
			$dat['status'] = $v['zhuangtai'];
			$dat['xianlu']['title'] = $v['mingcheng'];
			//$dat['departmentID'] = $this->_getnewbumenID($v['departmentName']);
			$bumen = $this->_getnewbumenbyusername($v['user_name']);
			$dat['departmentID'] = $bumen['systemID'];
			if(!$dat['departmentID']){
				dump(74544444444444);
				dump($v);
				dump($dat);
				exit;
			}
			//审核时间
			if($v['zhuangtai'] == '报名' || $v['zhuangtai'] == '截止'){
				$dat['islock'] = '已锁定';
				$dat['shenhe_time'] = $v['time'];
				$dat['shenhe_remark'] = '已审核';
				$dat['status_shenhe'] = '批准';
				$v['zhuangtai'] = '截止';
				$dat['status'] = '截止';
			}
			else{
				$dat['islock'] = '未锁定';
				$dat['status'] = '准备';
			}
			//子团报名状态
			$zituanAll = $glzituan->where("`xianluID` = '$v[xianluID]' and `zhuangtai` != '回收站'")->findall();
			foreach($zituanAll as $zit){
				if(strtotime($zit['chutuanriqi']) > time()){
					$v['zhuangtai'] = '报名';
					$dat['status'] = '报名';
					break;
				}
			}
			//售价及儿童说明
			$jiage = $glxianlujiage->where("`xianluID` = '$v[xianluID]'")->find();
			$dat['xianlu']['shoujia'] = $jiage['chengrenzongjia'];
			$dat['xianlu']['remark'] = $jiage['ertongshuoming'];
			//异常数据处理
			if(!$dat['xianlu']['tianshu'])
				$dat['xianlu']['tianshu'] = 0;
			if(!$dat['xianlu']['renshu'])
				$dat['xianlu']['renshu'] = 0;
			if(!$dat['xianlu']['chutuanriqi'])
				$dat['xianlu']['chutuanriqi'] = 0;
			$dat['xianlu']['ispub'] = '未发布';
			if(!$dat['xianlu']['ischild'])
				$dat['xianlu']['ischild'] = 0;
			if (false !== $Chanpin->relation("xianlu")->myRcreate($dat)){
				$xianluID = $Chanpin->getRelationID();
				$dat['chanpinID'] = $xianluID;
				//附表
				if($v['guojing'] == '境外')
				$this->_xianluext_build($v,$dat);
				if($v['xianlutype'] == '包团' && $v['guojing'] != '境外')
				$this->_xianluext_build($v,$dat,'包团');
				//行程
				$this->_xianlu_xingcheng($v,$dat);
				//成本
				$this->_xianlu_chengben($v,$dat);
				$dataOMlist = A("Method")->_setDataOMlist('计调','组团',$v['user_name']);
				A("Method")->_createDataOM($xianluID,'线路','管理',$dataOMlist);
				if($v['zhuangtai'] == '报名' || $v['zhuangtai'] == '截止'){
					//生成备份,要放在生成行程，成本，附表之后。
					A("Method")->makefiledatacopy($xianluID,'线路',-1);
					//开放售价
					if($v['zhuangtai'] == '报名')
					$this->_xianlu_shoujia($v,$dat);
					//zituan
					if($dat['status'] != '准备')
					$this->_zituan_build($v,$dat,$dataOMlist);
				}
				
			}
			else{
				dump(12312333333);
				dump($v);
				dump($dat);
				dump($Chanpin);
				exit;
			}
			
			
			//message
//			$this->chanpinxiaoxi($v,$chanpinID);
			//exit;
		}
		$url = SITE_INDEX."Forme/chanpinxianlu/page/".($_REQUEST['page']+1);
		$this->assign("url",$url);
		$this->display('Index:forme');
		echo "结束";
		
    }
	
	
	//地接
    public function chanpindijie() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$dj_tuan=M("dj_tuan");
		if(!$_REQUEST['page']){
				dump('无page参数');
		exit;
		}
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num = ($_REQUEST['page']-1)*50;
		$datalist = $dj_tuan->where("`adduser` != 'aaa'")->order('time asc')->limit("$num,50")->findall();
		if(count($datalist) == 0)
		exit;
		dump("共".count($dj_tuan->where("`adduser` != 'aaa'")->findall()).'个团'.'<br>');
		$jishu_xianlu = 0;
		//$datalist = $dj_tuan->order('time DESC')->findall();
		$Chanpin=D("Chanpin");
		$dj_itinerary=M("dj_itinerary");
		$dj_rcitem=M("dj_rcitem");
		$dj_appraisal=M("dj_appraisal");
		$dj_orderhotel=M("dj_orderhotel");
		foreach($datalist as $v){
			dump("正在执行".$num+(++$jishu_xianlu).'个团ID'.$v['djtuanID'].'<br>');
			$dat = $v;
			$dat['DJtuan'] = $v;
			//计算截止状态
			if(strtotime($v['startdate']) < time())
			$dat['status'] = '截止';
			$dat['user_name'] = $v['adduser'];
			$bumen = $this->_getnewbumenbyusername($dat['user_name']);
			$dat['departmentID'] = $bumen['systemID'];
			//审核
			if($dat['status'] == '截止' || $dat['status'] == '在线'){
				$dat['islock'] = '已锁定';
				$dat['shenhe_time'] = $v['time'];
				$dat['shenhe_remark'] = '已审核';
			}
			else
				$dat['status'] = '准备';
			$dat['DJtuan']['title'] = $v['title'] =$v['tuantitle'];
			$dat['DJtuan']['tuanhao'] = $v['tuanhao'] = $v['tuannumber'];
			$dat['DJtuan']['lianxiren'] = $v['lianxiren'] = $v['contact'];
			$dat['DJtuan']['lianxirentelnum'] = $v['lianxirentelnum'] = $v['contactphone'];
			$dat['DJtuan']['jietuantime'] = $v['jietuantime'] = $v['startdate'];
			$dat['DJtuan']['tianshu'] = $v['tianshu'] = $v['days'];
			$dat['DJtuan']['baojia'] = $v['baojia'] = intval($v['quote']);
			$dat['DJtuan']['guojing'] = $v['guojing'] = $v['jingwai'];
			$v['jiaotongfangshi'] = $v['trafficarrive'];
			$v['jiudianbiaozhun'] = $v['hotelstd'];
			$v['yongchanbiaozhun'] = $v['eatingstd'];
			$v['yongchebiaozhun'] = $v['trafficstd'];
			$v['daoyoufuwu'] = $v['daoyoustd'];
			$v['jingdianmenpiao'] = $v['ticketstd'];
			$v['gouwujihua'] = $v['shoppingstd'];
			$v['remark'] = $v['remark'];
			$v['jiezhanfangshi'] = $v['jiezhanstd'];
			if(!$dat['DJtuan']['tuanhao'])
				$dat['DJtuan']['tuanhao'] = $v['tuanhao'] = 0;
			if(!$dat['DJtuan']['fromcompany'])
				$dat['DJtuan']['fromcompany'] = $v['fromcompany'] = 0;
			if(!$dat['DJtuan']['lianxiren'])
				$dat['DJtuan']['lianxiren'] = $v['lianxiren'] = 0;
			if(!$dat['DJtuan']['lianxirentelnum'])
				$dat['DJtuan']['lianxirentelnum'] = $v['lianxirentelnum'] = 0;
			if(!$dat['DJtuan']['onperson'])
				$dat['DJtuan']['onperson'] = $v['onperson'] = 0;
			if(!$dat['DJtuan']['renshu'])
				$dat['DJtuan']['renshu'] = $v['renshu'] = 0;
			if(!$dat['DJtuan']['tianshu'])
				$dat['DJtuan']['tianshu'] = $v['tianshu'] = 0;
			if(!$dat['DJtuan']['jietuantime'])
				$dat['DJtuan']['jietuantime'] = $v['jietuantime'] = 0;
			$dat['DJtuan']['datatext'] = serialize($v);
			//行程内容
			$xingcheng = $dj_itinerary->where("`djtuanID` = '$v[djtuanID]'")->find();
			$dat['DJtuan']['daoyou'] = $xingcheng['daoyou'] = $xingcheng['guide'];
			$dat['DJtuan']['tuanbiao'] = $xingcheng['tuanbiao'] = $xingcheng['tuanmark'];
			$richengall = $dj_rcitem->where("`itineraryID` = '$xingcheng[itineraryID]'")->findall();
			$i = 0;
			foreach($richengall as $vol){
				$xingcheng_array[$i] = '标准：'.$vol['breakfastprice'].'元，地点：'.$vol['breakfastplace'].'，电话：'.$vol['breakfasttelnum'];
				$xingcheng_array[$i] .= '@_@'.'标准：'.$vol['lunchprice'].'元，地点：'.$vol['lunchplace'].'，电话：'.$vol['lunchtelnum'];
				$xingcheng_array[$i] .= '@_@'.'标准：'.$vol['dinnerprice'].'元，地点：'.$vol['dinnerpalce'].'，电话：'.$vol['dinnertelnum'];
				$xingcheng_array[$i] .= '@_@'.$vol['content'];
				$i++;	
			}
			$datatext['xingcheng_array'] = $xingcheng_array;
			$datatext['hotel'] = $xingcheng['hotel'] = $xingcheng['hotel'];
			$datatext['quanpei'] = $xingcheng['quanpei'] = $xingcheng['guidetype'];
			$datatext['quanpeitelnum'] = $xingcheng['quanpeitelnum'] = $xingcheng['guidetelnum'];
			$datatext['roomnumber'] = $xingcheng['roomnumber'] = $xingcheng['roomnumber'];
			//行程内容
			$itinerary['arrivetool'] = explode(',',$xingcheng['arrivetool']);
			$itinerary['arrivebianhao'] = explode(',',$xingcheng['arrivebianhao']);
			$itinerary['arrivedatestart'] = explode(',',$xingcheng['arrivedatestart']);
			$itinerary['arrivedateend'] = explode(',',$xingcheng['arrivedateend']);
			$itinerary['leavetool'] = explode(',',$xingcheng['leavetool']);
			$itinerary['leavebianhao'] = explode(',',$xingcheng['leavebianhao']);
			$itinerary['leavedate'] = explode(',',$xingcheng['leavedate']);
			for($i = 0;$i<count($itinerary['arrivetool']);$i++){
				$jiaotong_array[$i] = '去程@_@'.$itinerary['arrivetool'][$i].'@_@'.$itinerary['arrivebianhao'][$i].'@_@'.$itinerary['arrivedatestart'][$i].'@_@'.$itinerary['arrivedateend'][$i];
				$i++;	
			}
			for($i;$i<count($itinerary['leavetool']);$i++){
				$jiaotong_array[$i] = '回程@_@'.$itinerary['leavetool'][$i].$itinerary['leavebianhao'][$i].'@_@'.$itinerary['leavedate'][$i].'@_@';
				$i++;	
			}
			$datatext['jiaotong_array'] = $jiaotong_array;
			$dat["DJtuan"]['datatext_xingcheng'] = serialize($datatext);
			//订房确认单
			$hotel = $dj_orderhotel->where("`djtuanID` = '$v[djtuanID]'")->find();
			$dingfang = $hotel;
			$dingfang['hotel'] = $hotel['hotelname'];
			$dingfang['shoujiandanwei'] = $hotel['sendcompany'];
			$dingfang['fajiandanwei'] = $hotel['recivecompany'];
			$dingfang['shoujianren'] = $hotel['sendperson'];
			$dingfang['fajianren'] = $hotel['reciveperson'];
			$dingfang['shoujiantelnum'] = $hotel['sendtelnum'];
			$dingfang['fajiantelnum'] = $hotel['recivetelnum'];
			$dingfang['shoujianfax'] = $hotel['senfax'];
			$dingfang['fajianfax'] = $hotel['recivefax'];
			$dingfang['dingfangshijian'] = $hotel['orderdate'];
			$dingfang['ruzhushijian'] = $hotel['livedate'];
			$dingfang['jiesuanshijian'] = $hotel['jiesuandate'];
			$dingfang['tuifangshijian'] = $hotel['checkoutdate'];
			$dingfang['dingfangbiaozhun'] = $hotel['roomstd'];
			$dingfang['fangjianjiage'] = $hotel['roomprice'];
			$dingfang['peitongfang'] = $hotel['peitongroom'];
			$dingfang['zaocanbiaozhun'] = $hotel['breakfaststd'];
			$dingfang['zaocanrenshu'] = $hotel['breakrenshu'];
			$dingfang['yingfu'] = $hotel['meetamount'];
			$dat["DJtuan"]['datatext_dingfang'] = serialize($dingfang);
			//成本内容
			$chengbenall = $dj_appraisal->where("`djtuanID` = '$v[djtuanID]'")->findall();
			$i = 0;
			foreach($chengbenall as $ch){
				$chengben[$i] = $ch['type'].'@_@'.$ch['title'].'@_@'.$ch['renshu'].'@_@'.$ch['timestart'].'@_@'.$ch['timeend'].'@_@'.$ch['description'].'@_@'.intval($ch['price']);
				$i++;	
			}
			$datatext['chengben'] = $chengben;
			$dat["DJtuan"]['datatext_chengben'] = serialize($datatext);
			if (false !== $Chanpin->relation("DJtuan")->myRcreate($dat)){
				$chanpinID = $Chanpin->getRelationID();
				$dat['chanpinID'] = $chanpinID;
				$dataOMlist = A("Method")->_setDataOMlist('地接','地接',$dat['user_name']);
				A("Method")->_createDataOM($chanpinID,'地接','管理',$dataOMlist);
				//生成报账单----------------------
				$this->_baozhangdan_dijie_build($v,$dat,$dataOMlist);
				//生成随团单项服务报账单----------------------
				$this->_danxiangfuwu_build($dat,$dataOMlist,'地接');
			}
			else
			{
				dump(2342536346);
				dump($dat);
				dump($Chanpin);
				exit;
			}
		}
		$url = SITE_INDEX."Forme/chanpindijie/page/".($_REQUEST['page']+1);
		$this->assign("url",$url);
		$this->display('Index:forme');
		echo "结束";
		
    }
	
	
	//获得部门ID：根据同名部门获得新ID
	function _getnewbumenID($title){
		$ViewDepartment=D("ViewDepartment");
		$bumen = $ViewDepartment->where("`title` = '$title'")->find();
		if(!$bumen)
		$bumen = $ViewDepartment->where("`title` like '%$title%'")->find();
		return $bumen['systemID'];
	}
	
	//获得部门ID：根据同名部门获得旧ID
	function _getoldbumenID($title){
		$glbasedata=M("glbasedata");
		$bumen = $glbasedata->where("`title` = '$title'")->find();
		return $bumen['id'];
	}
	
	//获得旧部门ID
	function _getoldbumenbyusername($user_name){
		$roleuser = M('Glkehu')->where("`user_name`='$user_name'")->find();
		$mydepartment = M('glbasedata')->where("`id`='$roleuser[department]'")->find();
		return $mydepartment;
	}
	
	//获得新用户ID根据用户名
	function _getuserIDbytitle($user_name){
		$ViewUser = D("ViewUser");
		$user = $ViewUser->where("`user_name` = '$user_name'")->find();
		return $user['systemID'];
	}
	
	
	//获得新部门，根据用户名
	function _getnewbumenbyusername($user_name){
		$ViewSystemDUR=D("ViewSystemDUR");
		$ViewUser = D("ViewUser");
		$ViewDepartment=D("ViewDepartment");
		$user = $ViewUser->where("`title` = '$user_name'")->find();
		$durlist = $ViewSystemDUR->where("`userID` = '$user[systemID]'")->findall();
		if(count($durlist) == 1){
			$bumenID = $durlist[0]['bumenID'];
			$bumen = $ViewDepartment->where("`systemID` = '$bumenID'")->find();
			return $bumen;
		}
		$roleuser = M('Glkehu')->where("`user_name`='$user_name'")->find();
		$mydepartment = M('glbasedata')->where("`id`='$roleuser[department]'")->find();
		$bumen = $ViewDepartment->where("`title` = '$mydepartment[title]'")->find();
		return $bumen;
	}
	
	
	
	
	//用户相关
    public function _filluser() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$gladminuser=M("gladminuser");
		$userall = $gladminuser->findall();
		$System = D("System");
		$users=M("Users");
		foreach($userall as $v)
		{
			$b = $users->where("`user_id` = '$v[user_id]'")->find();
			$b['user'] = $b;
			$System->relation("user")->myRcreate($b);
			$systemID = $System->getRelationID();
			$this->_fillDUR($v,$systemID);
		}
		echo "结束";
	}
	
	//部门相关
    public function _filldepartment() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$gllvxingshe=M("gllvxingshe");
		$all = $gllvxingshe->findall();
		$System = D("System");
		$glbasedata=M("glbasedata");
		foreach($all as $v)
		{
			if($v['admintype'] == '系统'){
				$v['title'] = $v['companyname'];
				$v['department'] = $v;
				$v['department']['type'] = '行政';
				$System->relation("department")->myRcreate($v);
				$parentID = $System->getRelationID();
				$bball = $glbasedata->where("`type` = '部门'")->findall();
				foreach($bball as $c)
				{
					$c['parentID'] = $parentID;
					$c['department'] = $c;
					if($v['title'] == '直营-普兰店营业部' || $v['title'] == '直营-金州营业部' || $v['title'] == '直营-瓦房店营业部'||$v['title'] == '直营-人民路旗舰店'||$v['title'] == '直营-联合路营业部'||$v['title'] == '直营-电子商务营业部'){
					$c['department']['type'] = '销售（直营）';
					}
					if($v['title'] == '加盟-二七营业部' || $v['title'] == '加盟-开发区营业部' || $v['title'] == '加盟-劳动公园营业部'){
					$c['department']['type'] = '销售（加盟）';
					}
					if($v['title'] == '出境部-韩国' || $v['title'] == '国内部-组团' || $v['title'] == '出境部-欧美岛'||$v['title'] == '出境部-台湾'||$v['title'] == '出境部-港澳东南亚'||$v['title'] == '日本部-出境'){
					$c['department']['type'] = '组团';
					}
					if($v['title'] == '国内部-地接' || $v['title'] == '日本部-入境' || $v['title'] == '出境部-欧美岛'||$v['title'] == '出境部-台湾'){
					$c['department']['type'] = '地接';
					}
					$System->relation("department")->myRcreate($c);
				}
			}
			
		}
		foreach($all as $v)
		{
			if($v['admintype'] != '系统' && $v['type'] == '办事处'){
				$v['title'] = $v['companyname'];
				$v['parentID'] = $parentID;
				$v['department'] = $v;
				$v['department']['type'] = '组团,联合体';
				if($v['title'])
				$System->relation("department")->myRcreate($v);
			}
			
		}
		echo "结束";
		return true;
	}
	
	
	//角色相关
    public function _fillrole() {
		
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$glbasedata=M("glbasedata");
		$all = $glbasedata->where("`type` = '职位'")->findall();
		$System = D("System");
		foreach($all as $v)
		{
			$v['roles'] = $v;
			$System->relation("roles")->myRcreate($v);
		}
		echo "结束";
		
	}
	
	//角色相关
    public function _fillDUR($user,$newuser_ID) {
		//simple_unserialize
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$System = D("System");
		$list = simple_unserialize($user['department_list']);
		$glbasedata = M("glbasedata");
		$Department = D("Department");
		$glkehu = M("glkehu");
		$gllvxingshe = M("gllvxingshe");
		$glkehu = M("glkehu");
		$Roles = D("Roles");
		
		foreach($list as $v)
		{
			$data = '';
			$bumen = $glbasedata->where("`id` = '$v'")->find();
			$dd = $Department->where("`title`='$bumen[title]'")->find();
			$r = $Roles->where("`title` = '前台'")->find();
			$data['systemDUR']['departmentID'] = $dd['systemID'];//部门
			$data['systemDUR']['userID'] = $newuser_ID;//用户
			$data['systemDUR']['rolesID'] = $r['systemID'];
			//默认项,门市权限
			$System->relation("systemDUR")->myRcreate($data);
			
			$gets = explode(',',$user['adminlevel']);
			foreach($gets as $cc)
			{
				if($cc == '地接操作员' || $cc == '计调操作员'){
					$r = $Roles->where("`title` = '计调'")->find();
					$data['systemDUR']['rolesID'] = $r['systemID'];
					$System->relation("systemDUR")->myRcreate($data);
				}
				if($cc == '地接经理' || $cc == '计调经理'){
					$r = $Roles->where("`title` = '经理'")->find();
					$data['systemDUR']['rolesID'] = $r['systemID'];
					$System->relation("systemDUR")->myRcreate($data);
				}
				if($cc == '财务操作员' || $cc == '财务总监'){
					$r = $Roles->where("`title` = '会计'")->find();
					$data['systemDUR']['rolesID'] = $r['systemID'];
					$System->relation("systemDUR")->myRcreate($data);
					$r = $Roles->where("`title` = '出纳'")->find();
					$data['systemDUR']['rolesID'] = $r['systemID'];
					$System->relation("systemDUR")->myRcreate($data);
				}
				if($cc == '网管'){
					$r = $Roles->where("`title` = '技术支持'")->find();
					$data['systemDUR']['rolesID'] = $r['systemID'];
					$System->relation("systemDUR")->myRcreate($data);
				}
				if($cc == '总经理'){
					$r = $Roles->where("`title` = '总经理'")->find();
					$data['systemDUR']['rolesID'] = $r['systemID'];
					$System->relation("systemDUR")->myRcreate($data);
				}
				if($cc == '联合体成员' || $cc == '联合体管理员'){
					$r = $Roles->where("`title` = '联合体'")->find();
					$data['systemDUR']['rolesID'] = $r['systemID'];
					$System->relation("systemDUR")->myRcreate($data);
				}
				if($cc == '办事处管理员'){
					$r = $Roles->where("`title` = '同业'")->find();
					$data['systemDUR']['rolesID'] = $r['systemID'];
					$System->relation("systemDUR")->myRcreate($data);
				}
			}
		}
		
		echo "结束";
		
	}
	
	
    private function chanpinxiaoxi($v,$chanpinID) {
		$glmessage=M("glmessage");
		$message = $glmessage->where("`tableID` = '$v[xianluID]' and `tablename` = '线路'")->findall();
		$Message=D("Message");
		foreach($message as $b)
		{
			//message
			$dat['user_name'] = $b['username'];
			$dat['departmentID'] = $b['laiyuan'];
			$dat['chanpinID'] = $chanpinID;
			$dat['title'] = $b['content'];
			$myerp_message->add($dat);
		}
    }
	
	
    private function _zituan_build($xianlu,$newxianlu,$dataOMlist) {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$glzituan=M("glzituan");
		$zituanAll = $glzituan->where("`xianluID` = '$xianlu[xianluID]'")->findall();
		$gljiedaijihua=M("gljiedaijihua");
		$jihua = $gljiedaijihua->where("`xianluID` = '$xianlu[xianluID]' and `jiedaitype` = '接待计划'")->find();
		$tongzhi = $gljiedaijihua->where("`xianluID` = '$xianlu[xianluID]' and `jiedaitype` = '出团通知'")->find();
		$gl_baozhang=M("gl_baozhang");
		foreach($zituanAll as $v){
			$dat = $v;
			$dat['zituan'] = $v;
			//部门
			$dat['departmentID'] = $newxianlu['departmentID'];
			$dat['parentID'] = $newxianlu['chanpinID'];
			//计算出团日期，重置子团状态
			$dat['status'] = '报名';
			if($v['zhuangtai'] == '报名' ||$v['zhuangtai'] == '截止'){
				$dat['islock'] = '已锁定';
				if(strtotime($v['chutuanriqi']) < time()){
					$dat['status'] = '截止';
				}
				else
					$dat['status'] = $v['zhuangtai'];
			}
			elseif($v['zhuangtai'] == '回收站'){
				$dat['status'] = '准备';
				$dat['status_system'] = -1;
			}
			$dat['zituan']['title_copy'] = $newxianlu['xianlu']['title'];
			$dat['zituan']['jiedaijihua'] = serialize($jihua);
			$dat['zituan']['chutuantongzhi'] = serialize($tongzhi);
			$dat['zituan']['xianludata_copy'] = serialize($newxianlu);
			$dat['zituan']['guojing_copy'] = $newxianlu['guojing'];
			$dat['zituan']['kind_copy'] = $newxianlu['kind'];
			//报账单审核状态
			$baozhang = $gl_baozhang->where("`zituanID` = '$v[zituanID]'")->find();
			if(false !== $Chanpin->relation("zituan")->myRcreate($dat)){
				$zituanID = $Chanpin->getRelationID();
				$dat['chanpinID'] = $zituanID;
				A("Method")->_createDataOM($zituanID,'子团','管理',$dataOMlist);
				//生成报账单----------------------
				$this->_baozhangdan_build($dat);
				//生成随团单项服务报账单----------------------
				$this->_danxiangfuwu_build($dat,'','子团');
				//生成订单----------------------与子团om相同
				$this->_dingdan_build($dat,$dataOMlist);
			}
			else
			{
				dump(123321123);	
				dump($Chanpin);	
				exit;
			}
		}
		
    }
	
	
	//地区联动
	public function liandong()
	{
		C('TOKEN_ON',false);
		echo "开始";
		echo "<br>";
			$System = D("System");
			//中国0
			$v['parentID'] = 0;
			$v['datadictionary']['type'] = '地区联动';
			$v['datadictionary']['title'] = '中国';
			$SystemID = $System->relation("datadictionary")->myRcreate($v);
			
			$liandong  = D("liandong");
			$all = $liandong->findall();
			
			foreach($all as $v){
				//地区
				if($v['pid'] == 0 )
				{
					$v['parentID'] = $SystemID;
					$v['datadictionary']['type'] = '地区联动';
					$v['datadictionary']['title'] = $v['position'];
					$System->relation("datadictionary")->myRcreate($v);
					$new_id = $System->getRelationID();
					$c_all = $liandong->where("`pid` = '$v[id]'")->findall();
					//省
					foreach($c_all as $c){
						$v['parentID'] = $new_id;
						$v['datadictionary']['type'] = '地区联动';
						$v['datadictionary']['title'] = $c['position'];
						$System->relation("datadictionary")->myRcreate($v);
						$new_id_2 = $System->getRelationID();
						$c_all_2 = $liandong->where("`pid` = '$c[id]'")->findall();
						//市
						foreach($c_all_2 as $b){
							$v['parentID'] = $new_id_2;
							$v['datadictionary']['type'] = '地区联动';
							$v['datadictionary']['title'] = $b['position'];
							$System->relation("datadictionary")->myRcreate($v);
						}
					}
				}
			}
		echo "开始222";
		echo "<br>";
	}
	
	
	
	
	//生成报账单----------------------
	public function _baozhangdan_dijie_build($v,$zituan,$dataOMlist){
		$Chanpin = D("Chanpin");
		$dj_baozhang = D("dj_baozhang");
		$dj_baozhangitem=M("dj_baozhangitem");
		$baozhang = $dj_baozhang->where("`djtuanID` = '$v[djtuanID]'")->find();
		if($baozhang){
			$bzd["baozhang"]['title'] = $zituan['DJtuan']['title'].'团队报账单';
			$bzd['parentID'] = $zituan['chanpinID'];
			$bzd['user_name'] =  $zituan['user_name'];
			$bzd['departmentID'] =  $zituan['departmentID'];
			$bzd["baozhang"]['type'] = '团队报账单';
			$bzd["time"] = $baozhang['time'];
			$bzd["islock"] = '已锁定';
			//备注
			if($v['guidetype'])
			$remark .= '领队：'.$v['guidetype'];
			if($baozhang['daoyou'])
			$remark .= '，导游：'.$baozhang['daoyou'];
			if($baozhang['leader'])
			$remark .= '，领队：'.$baozhang['leader'];
			$bzd["baozhang"]['datatext']['remark'] = $remark;
			//报账人数
			$bzd["baozhang"]['renshu'] = $zituan['renshu'];
			if(!$bzd["baozhang"]['renshu'])
				$bzd["baozhang"]['renshu'] = 0;
			//领队人数
			$lingdui_num = 0;
			$bzd["baozhang"]['datatext']['lingdui_num'] = $lingdui_num;
			//计算报账项
			$baozhangitemall = $dj_baozhangitem->where("`baozhangID` = '$baozhang[baozhangID]'")->findall();
			foreach($baozhangitemall as $v){
				if($v['check_status'] == '审核通过'){
					if($v['type'] == '结算项目')
					$bzd["baozhang"]['yingshou_copy'] += $v['price'];
					if($v['type'] == '支出项目')
					$bzd["baozhang"]['yingfu_copy'] += $v['price'];
				}
			}
			$bzd["baozhang"]['datatext'] = serialize($bzd["baozhang"]['datatext']);
			if(false !== $Chanpin->relation("baozhang")->myRcreate($bzd)){
				$baozhangID = $Chanpin->getRelationID();
				$bzd['chanpinID'] = $baozhangID;
				A("Method")->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
				//生成报账项-----------------------
				foreach($baozhangitemall as $v){
					$bzditem = '';
					$bzditem['parentID'] = $baozhangID;
					$bzditem['time'] = $v['time'];
					$bzditem['user_name'] = $bzd['user_name'];
					$bzditem['departmentID'] = $bzd['departmentID'];
					$bzditem['baozhangitem']['value'] = $v['price'];
					$bzditem['baozhangitem']['method'] = $v['pricetype'];
					$bzditem['baozhangitem']['title'] = $v['title'];
					if($bzditem['baozhangitem']['title'] == '')
					continue;
					$bzditem['baozhangitem']['type'] = $v['type'];
					if($bzditem['baozhangitem']['type'] == '')
					continue;
					$bzditem['baozhangitem']['datatext'] = serialize($bzditem['baozhangitem']['datatext']);
					if(false !== $Chanpin->relation("baozhangitem")->myRcreate($bzditem)){
						$baozhangitemID = $Chanpin->getRelationID();
						$bzditem['chanpinID'] = $baozhangitemID;
						A("Method")->_createDataOM($baozhangitemID,'报账项','管理',$dataOMlist);
						//生成审核任务？
						if($v['type'] != '利润')
						$this->_taskshenhe_dijie_build($v,$bzditem,'报账项',$dataOMlist,$zituan,$baozhang);
					} 
					else{
						dump("543535");
						dump($bzditem);
						dump($Chanpin);
					exit;
					}
					
				}
			}
			else{
				dump("111111er345");
				dump($Chanpin);
				exit;
			}
			//生成审核任务？
			if($baozhang){
				$this->_taskshenhe_dijie_build($baozhang,$bzd,'团队报账单',$dataOMlist,$zituan);
			}
		}
		
		
		
		
	
	}
	
	
	//生成报账单----------------------
	public function _baozhangdan_build($zituan)
	{
		$Chanpin = D("Chanpin");
		$gl_baozhang=M("gl_baozhang");
		$gl_baozhangitem=M("gl_baozhangitem");
		$baozhang = $gl_baozhang->where("`zituanID` = '$zituan[zituanID]'")->find();
		$bzd["baozhang"]['title'] = $zituan['zituan']['title_copy'].'/'.$zituan['chutuanriqi'].'团队报账单';
		$bzd['parentID'] = $zituan['chanpinID'];
		$bzd['user_name'] =  $zituan['user_name'];
		$bzd['departmentID'] =  $zituan['departmentID'];
		$bzd["baozhang"]['type'] = '团队报账单';
		if($baozhang){
			$bzd["time"] = $baozhang['time'];
			$bzd["islock"] = '已锁定';
			//备注
			$remark = '';
			$remark = '原报账人数：'.$baozhang['renshu'];
			if($baozhang['passport_user'])
			$remark .= '，因私护照人：'.$baozhang['passport_user'];
			if($baozhang['no_change_user'])
			$remark .= '，不换汇人：'.$baozhang['no_change_user'];
			if($baozhang['no_back_user'])
			$remark .= '，不返程人：'.$baozhang['no_back_user'];
			if($baozhang['out_user'])
			$remark .= '，外地户口人：'.$baozhang['out_user'];
			$bzd["baozhang"]['datatext']['remark'] = $remark;
			//其他数据
			$bzd["baozhang"]['datatext']['jietuandanwei'] = $baozhang['jingwaijiedai'];
			$bzd["baozhang"]['datatext']['qianyueren'] = $baozhang['qianyueren'];
			$bzd["baozhang"]['datatext']['dilianfangshi'] = $baozhang['diliangongju'];
			$bzd["baozhang"]['datatext']['dilianshijian'] = $baozhang['dilianshijian'];
			$bzd["baozhang"]['datatext']['lilianfangshi'] = $baozhang['liliangongju'];
			$bzd["baozhang"]['datatext']['lilianshijian'] = $baozhang['lilianshijian'];
			$bzd["baozhang"]['datatext']['lingdui_name'] = $baozhang['quanpei'];
			//报账人数
			$temprenshu = preg_replace("/[" . chr(0xa0). "-" .chr(0xfe) . "]+/", "", $baozhang['renshu']);//过滤汉字
			$baozhangrenshu = preg_replace('/[\.a-zA-Z]/s','',$temprenshu); //过滤字母
			//领队人数
			$lingdui_num = substr_count($baozhangrenshu,"+1");
			$bzd["baozhang"]['datatext']['lingdui_num'] = $lingdui_num;
			$baozhangrenshu = str_replace("+1","",$baozhangrenshu); //去除
			
			$renshulist = explode('+',$baozhangrenshu);
			foreach($renshulist as $rs){
				$renshu += (int)$rs;
			}
			$bzd["baozhang"]['renshu'] = $renshu;
			//计算报账项
			$baozhangitemall = $gl_baozhangitem->where("`baozhangID` = '$baozhang[baozhangID]'")->findall();
			foreach($baozhangitemall as $v){
				if($v['check_status'] == '审核通过'){
					if($v['type'] == '结算项目')
					$bzd["baozhang"]['yingshou_copy'] += $v['price'];
					if($v['type'] == '支出项目')
					$bzd["baozhang"]['yingfu_copy'] += $v['price'];
				}
			}
			$bzd["baozhang"]['datatext'] = serialize($bzd["baozhang"]['datatext']);
		}
		else{
			$bzd["baozhang"]['renshu'] = $zituan['renshu'];
		}
		if(!$bzd["baozhang"]['renshu'])
			$bzd["baozhang"]['renshu'] = 0;
		$bzd['islock'] =  '已锁定';
		if(false !== $Chanpin->relation("baozhang")->myRcreate($bzd)){
			$baozhangID = $Chanpin->getRelationID();
			$bzd['chanpinID'] = $baozhangID;
			//重置omlist
			$dataOMlist = A("Method")->_setDataOMlist('计调','组团',$bzd['user_name']);
			A("Method")->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
			//生成报账项-----------------------
			foreach($baozhangitemall as $v){
				$bzditem = '';
				$bzditem['parentID'] = $baozhangID;
				$bzditem['time'] = $v['time'];
				$bzditem['user_name'] = $bzd['user_name'];
				$bzditem['departmentID'] = $bzd['departmentID'];
				$bzditem['baozhangitem']['value'] = $v['price'];
				$bzditem['baozhangitem']['method'] = $v['pricetype'];
				$bzditem['baozhangitem']['title'] = $v['title'];
				$bzditem['baozhangitem']['type'] = $v['type'];
				$bzditem['baozhangitem']['remark'] = $v['remark'];
				$bzditem['baozhangitem']['is_print'] = $v['is_print'];
				if($bzditem['baozhangitem']['title'] == '')
				continue;
				if($bzditem['baozhangitem']['method'] == '')
					$bzditem['baozhangitem']['method'] = '现金';
				$bzditem['islock'] =  '已锁定';
				if(false !== $Chanpin->relation("baozhangitem")->myRcreate($bzditem)){
					$baozhangitemID = $Chanpin->getRelationID();
					$bzditem['chanpinID'] = $baozhangitemID;
					A("Method")->_createDataOM($baozhangitemID,'报账项','管理',$dataOMlist);
					//生成审核任务？
					if($v['type'] != '利润')
					$this->_taskshenhe_build($v,$bzditem,'报账项',$dataOMlist,$zituan,$baozhang);
				} 
				else{
					dump("11111111111111");
					dump($Chanpin);
				exit;
				}
			}
			//生成审核任务？报账单生成拷贝，要在报账项之后
			$this->_taskshenhe_build($baozhang,$bzd,'团队报账单',$dataOMlist,$zituan);
			
			
		}
		else{
			dump("2222222222");
			dump($bzd);
			dump($Chanpin);
			exit;
		}
			
	
	
	}
	
	
	
	//生成随团单项服务----------------------
	public function _danxiangfuwu_build($zituan,$dataOMlist,$idtype)
	{
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$glqianzheng=M("glqianzheng");
		$glqianzhengitem=M("glqianzhengitem");
		if($idtype == '子团'){
			$zituanID = $zituan['zituanID'];
			$dxfwall = $glqianzheng->where("`zituanID` = '$zituanID'")->findall();
		}
		if($idtype == '地接'){
			$zituanID = $zituan['djtuanID'];
			$dxfwall = $glqianzheng->where("`djtuanID` = '$zituanID'")->findall();
		}
		if($idtype == '独立'){
			$dxfwall = $glqianzheng->where("`zituanID` = '0' or `djtuanID` = '0' or `djtuanID` = ''")->findall();
		}
		foreach($dxfwall as $dxfw){
			if($idtype == '独立'){
				$dataOMlist = A("Method")->_setDataOMlist('计调','组团',$dxfw['username']);	
			}
			$bzd = '';
			$bzd['user_name'] =  $dxfw['username'];
			$bzd['time'] = $dxfw['time'];
			$bzd['baozhang']['title'] = $dxfw['title'];
			if($bzd['baozhang']['title'] == '')
				continue;
			if($dxfw['title_ext'])
			$bzd['baozhang']['title'] .= '/'.$dxfw['title_ext'];
			$bzd['parentID'] = $zituan['chanpinID'];
			$bumen = $this->_getnewbumenbyusername($bzd['user_name']);
			$bzd['departmentID'] =  $bumen['systemID'];
			if($dxfw['kind'] == '机票' ||$dxfw['kind'] == '订车'){
				$dxfw['kind'] = '交通';
				$bzd['baozhang']['datatext']['hangbanhao'] = $dxfw['title_ext'];
				$bzd['baozhang']['datatext']['shifadi'] = $dxfw['start_addr'];
				$bzd['baozhang']['datatext']['mudidi'] = $dxfw['end_addr'];
				$bzd['baozhang']['datatext']['leavetime'] = $dxfw['leavetime'];
				$bzd['baozhang']['datatext']['arrvietime'] = $dxfw['arrivetime'];
			}
			if($dxfw['kind'] == '订导游'){
				$dxfw['kind'] = '导游';
			}
			if($dxfw['kind'] == '订房'){
				$bzd['baozhang']['datatext']['hotel'] = $dxfw['title_ext'];
				$bzd['baozhang']['datatext']['hoteltelnum'] = $dxfw['quanchengpeitong'];
				$bzd['baozhang']['datatext']['ordertime'] = $dxfw['arrivetime'];
				$bzd['baozhang']['datatext']['jiesuantime'] = $dxfw['leavetime'];
			}
			if($dxfw['kind'] == '餐饮' || $dxfw['kind'] == '门票' || $dxfw['kind'] == '订导游'){
				$bzd['baozhang']['datatext']['telnum'] = $dxfw['quanchengpeitong'];
				$bzd['baozhang']['datatext']['ordertime'] = $dxfw['arrivetime'];
				$bzd['baozhang']['datatext']['jiesuantime'] = $dxfw['leavetime'];
			}
			$bzd['baozhang']['type'] = $dxfw['kind'];
			$bzd['baozhang']['datatext']['tianshu'] = $dxfw['tianshu'];
			//备注
			$remark = '';
			if($dxfw['other'])
			$remark .= $dxfw['other'];
			if($dxfw['tianshu'])
			$remark .= '，天数:'.$dxfw['tianshu'];
			if($dxfw['jingwaijiedaishe'])
			$remark .= '，接待单位:'.$dxfw['jingwaijiedaishe'];
			if($dxfw['arrivetool'])
			$remark .= '，抵达方式:'.$dxfw['arrivetool'];
			if($dxfw['arrivetool'])
			$remark .= '，离开方式:'.$dxfw['leavetool'];
			if($dxfw['quanchengpeitong'])
			$remark .= '，接收单位:'.$dxfw['quanchengpeitong'];
			if($dxfw['buhuanhui'])
			$remark .= '，不换汇人员:'.$dxfw['buhuanhui'];
			if($dxfw['yinsihuzhao'])
			$remark .= '，因私护照:'.$dxfw['yinsihuzhao'];
			if($dxfw['bufancheng'])
			$remark .= '，不返程:'.$dxfw['bufancheng'];
			if($dxfw['waidihukou'])
			$remark .= '，外地户口:'.$dxfw['waidihukou'];
			$bzd['baozhang']['datatext']['remark'] = $remark;
			$bzd['baozhang']['datatext'] = serialize($bzd['baozhang']['datatext']);
			if($dxfw['renshu'])
			$bzd["baozhang"]['renshu'] = $dxfw['renshu'];
			else
			$bzd["baozhang"]['renshu'] = 0;
			//计算报账项
			$baozhangitemall = $glqianzhengitem->where("`qianzhengID` = '$dxfw[qianzhengID]'")->findall();
			foreach($baozhangitemall as $item){
				if($item['status'] == '财务通过'){
					if($item['type'] == '应收费用')
					$bzd["baozhang"]['yingshou_copy'] += $item['value'];
					if($item['type'] == '费用明细')
					$bzd["baozhang"]['yingfu_copy'] += $item['value'];
				}
			}
			$bzd['islock'] =  '已锁定';
			if(false !== $Chanpin->relation("baozhang")->myRcreate($bzd)){
				$baozhangID = $Chanpin->getRelationID();
				$bzd["chanpinID"] = $baozhangID;
				//重置omlist
				if($idtype == '子团')
					$dataOMlist = A("Method")->_setDataOMlist('计调','组团',$bzd['user_name']);
				if($idtype == '地接')
					$dataOMlist = A("Method")->_setDataOMlist('地接','地接',$bzd['user_name']);
				A("Method")->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
				//生成随团服务报账项-----------------------
				foreach($baozhangitemall as $v){
					$bzditem = '';
					$bzditem['parentID'] = $baozhangID;
					$bzditem['time'] = $v['time'];
					$bzditem['user_name'] = $bzd['user_name'];
					$bzditem['departmentID'] = $bzd['departmentID'];
					$bzditem['baozhangitem']['value'] = $v['value'];
					$bzditem['baozhangitem']['method'] = '现金';
					$bzditem['baozhangitem']['title'] = $v['title'];
					$bzditem['baozhangitem']['datatext'] = serialize($bzditem['baozhangitem']['datatext']);
					$bzditem['datakind'] = $dxfw['kind'];
					if($v['type'] == '应收费用'){
						$v['type'] = '结算项目';
						$bzditem['baozhangitem']['type'] = '结算项目';
					}
					if($v['type'] == '费用明细'){
						$v['type'] = '支出项目';
						$bzditem['baozhangitem']['type'] = '支出项目';
					}
					if($v['type'] == '部门利润'){
						$v['type'] = '利润';
						$bzditem['baozhangitem']['type'] = '利润';
					}
					if($bzditem['baozhangitem']['title'] == '')
					continue;
					$bzditem['islock'] =  '已锁定';
					if(false !== $Chanpin->relation("baozhangitem")->myRcreate($bzditem)){
						$baozhangitemID = $Chanpin->getRelationID();
						$bzditem['chanpinID'] = $baozhangitemID;
						A("Method")->_createDataOM($baozhangitemID,'报账项','管理',$dataOMlist);
						//生成审核任务？
						if($v['type'] != '利润')
						$this->_taskshenhe_build($v,$bzditem,'单项服务报账项',$dataOMlist,$dxfw);
					} 
					else{
						dump(78963543);
						dump($Chanpin);
						exit;
					}
				}
				//生成审核任务？
				$this->_taskshenhe_build($dxfw,$bzd,'单项服务',$dataOMlist,$zituan);
			}
			else{
				dump(63521111);
				dump($Chanpin);
			}
		}
	}
	
	
	
	
	
	
	//生成订单----------------------
	public function _dingdan_build($zituan,$dataOMlist)
	{
		$Chanpin = D("Chanpin");
		$ViewDataDictionary = D("ViewDataDictionary");
		$gldingdan = M("gldingdan");
		$gltuanyuan = M("gltuanyuan");
		$dingdanall = $gldingdan->where("`zituanID` = '$zituan[zituanID]'")->findall();
		foreach($dingdanall as $v){
			$data = $v;
			$data['dingdan'] = $v;
			$data['user_name'] = $v['user_name'];
			$data['parentID'] = $zituan['chanpinID'];
			$data['dingdan']['title'] = $v['mingcheng'].'/'.$v['chutuanriqi'];
			$data['dingdan']['remark'] = $v['xuqiu'];
			$data['dingdan']['fuzebumenID'] = $zituan['departmentID'];
			$data['dingdan']['type'] = '标准';
			$data['dingdan']['shoujiaID'] = 0;
			$data['dingdan']['zituanID'] = $zituan['chanpinID'];
			if($data['dingdan']['telnum'] == '')
				$data['dingdan']['telnum'] = 0;
			//计算领队数
			$data['dingdan']['lingdui_num'] = 0;
			$tuanyuanall = $gltuanyuan->where("`dingdanID` = '$v[dingdanID]'")->findall();
			foreach($tuanyuanall as $u){
				if($u['leader'] == 1)
				$data['dingdan']['lingdui_num'] ++;
			}
			//提成
			$ticheng = $ViewDataDictionary->where("`status_system` = 1")->find();
			$data['dingdan']['tichengID'] = $ticheng['systemID'];
			//部门
			$bumen = $this->_getnewbumenbyusername($data['user_name']);
			$data['departmentID'] = $bumen['systemID'];
			//订单状态
			$data['status'] = '确认';
			if($v['check_status'] == '回收站' || $v['check_status'] == '审核不通过'){
				$data['status'] = '候补';
			}
			if(strtotime($v['chutuanriqi']) < time()){
				if($v['check_status'] == '等待审核' || $v['check_status'] == '准备'){
				$data['status'] = '候补';
				}
			}
			if($data['dingdan']['lianxiren'] == '')
			$data['dingdan']['lianxiren'] = 0;
			if($data['dingdan']['lianxirentelnum'] == '')
			$data['dingdan']['lianxirentelnum'] = 0;
			if(false !== $Chanpin->relation("dingdan")->myRcreate($data)){
				$dingdanID = $Chanpin->getRelationID();
				$data['chanpinID'] = $dingdanID;
				A("Method")->_createDataOM($dingdanID,'订单','管理',$dataOMlist);
				//生成订单临时游客
				if($data['status'] == '确认')
				$this->_dingdan_customer_build($v,$data,$dataOMlist);
			}
			else
			{
				dump(4323424);
				dump($Chanpin);
				exit;	
			}
		}
	}
	
	
	//生成审核任务----------------------
	public function _taskshenhe_dijie_build($baozhang,$newbaozhang,$type,$dataOMlist,$relationdata ='',$relationdata_2 =''){
		$Chanpin = D("Chanpin");
		$xd['chanpinID'] = $newbaozhang['chanpinID'];
		$System = D("System");
		if($type == '团队报账单'){
			if(($baozhang['status'] != '财务总监通过' && $baozhang['status'] != '财务通过') && ($baozhang['time'] + 3600 * 24 * 30)  < time()){
				//更新报账
				$xd['shenhe_remark'] = '未审核';
				$Chanpin->save($xd);
				return;
			}
			$datatype = '报账单';
			if($baozhang['operateperson'] || $baozhang['status'] == '计调申请'){
				if(!$baozhang['departmentperson'] && !$baozhang['financeperson'] && $baozhang['status'] != '计调申请')
					return;
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $baozhang['operateperson'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata['user_name'];
					$baozhang['operateperson'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['datakind'] = '团队报账单';
				$task['taskShenhe']['title_copy'] = $newbaozhang["baozhang"]['title'];
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
					$task['shenqingname'] = $task['user_name'];
					$task['shenqingbumenID'] = $newbumenID;
					$task['shenqingbumentitle'] = $bumen['title'];
				}
				else{
				dump(8967635);
				dump($System);
				}
			}
			if(($baozhang['operateperson'] && $baozhang['departmentperson']) || $baozhang['status'] == '经理通过'){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['departmentperson'];
				if(!$task['user_name']){
					if($relationdata['guojing'] == '境外')
					$task['user_name'] = '王琦';
					if($relationdata['guojing'] == '国内')
					$task['user_name'] = '于丹丹';
					$baozhang['departmentperson'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($baozhang['operateperson'] && $baozhang['departmentperson'] && $baozhang['financeperson']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['financeperson'];
				if(!$task['user_name']){
					$task['user_name'] = '崔军';
					$baozhang['financeperson'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($baozhang['operateperson'] && $baozhang['departmentperson'] && $baozhang['financeperson'] && $baozhang['caiwuzongjian']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['caiwuzongjian'];
				if(!$task['user_name']){
					$task['user_name'] = '龚敏娜';
					$baozhang['caiwuzongjian'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 4;
				$task['taskShenhe']['remark'] = '财务总监批准';
				$task['taskShenhe']['roles_copy'] = '财务总监';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
		}
			
			
		if($type == '报账项'){
			if(($baozhang['check_status'] != '审核通过') && ($baozhang['time'] + 3600 * 24 * 30)  < time()){
				//更新报账
				$xd['shenhe_remark'] = '未审核';
				$Chanpin->save($xd);
				return;
			}
			$datatype = '报账项';
			if($baozhang['edituser'] || $baozhang['check_status'] == '审核通过'){
				if(!$baozhang['check_status'] == '经理确认' && !$baozhang['check_user'] && $baozhang['check_status'] != '审核通过')
					return;
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $relationdata['user_name'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata_2['operateperson'];
					$baozhang['edituser'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['datakind'] = '报账项';
				$task['taskShenhe']['title_copy'] = $newbaozhang["baozhangitem"]['title'];
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
					$task['shenqingname'] = $task['user_name'];
					$task['shenqingbumenID'] = $newbumenID;
					$task['shenqingbumentitle'] = $bumen['title'];
				}
			}
			if($baozhang['check_status'] == '经理确认'|| $baozhang['check_status'] == '审核通过'){
				$task['status'] = '检出';
				if(!$task['user_name']){
					if($relationdata['guojing'] == '境外')
					$task['user_name'] = '王琦';
					if($relationdata['guojing'] == '国内')
					$task['user_name'] = '于丹丹';
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
			}
			if($baozhang['check_status'] == '审核通过'){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['check_user'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata_2['financeperson'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
				  $taskID = '';
				}
			}
		}
			
		//生成备份
		if($task['status'] == '批准'){
			A("Method")->makefiledatacopy($newbaozhang['chanpinID'],$datatype,$task['parentID']);
			if($type == '团队报账单'){
				//联动更新
				$xd['baozhangDJtuanlist']['baozhang_remark'] = $task['taskShenhe']['remark'];
				$xd['baozhangDJtuanlist']['baozhang_time'] = $baozhang['caiwu_time'];
				$xd['baozhangDJtuanlist']['status_baozhang'] = $task['status'];
				$xd['shenhe_time'] = $baozhang['caiwu_time'];
				$xd['parentID'] = $newbaozhang['parentID'];
			}
			if($type == '报账项')
			$xd['shenhe_time'] = $baozhang['time'];
		}
		$xd['islock'] = '已锁定';
		$xd['status_shenhe'] = $task['status'];
		$xd['shenhe_remark'] = $task['taskShenhe']['remark'];
		if($type == '团队报账单')
		$Chanpin->relation('baozhangDJtuanlist')->myRcreate($xd);
		else
		$Chanpin->save($xd);
			
		if($taskID){
			//生成待检出
			$task['user_name'] = $task['shenqingname'];
			$task['departmentID'] = $task['shenqingbumenID'];
			$task['status'] = '待检出';
			$task['taskShenhe']['processID'] += 1;
			unset($task['taskShenhe']['roles_copy']);
			//检查流程
			$process = A("Method")->_checkShenhe($datatype,$task['taskShenhe']['processID']);
			if(false === $process)
			return;
			if(false !== $System->relation("taskShenhe")->myRcreate($task))
			{
				$dshID = $System->getRelationID();
				//生成待检出OM
				$DataOM = D("DataOM");
				foreach($dataOMlist as $vo){
					list($om_bumen,$om_roles,$om_user) = split(',',$vo['DUR']);
					$to_dataom['type'] = '管理';
					$to_dataom['dataID'] = $dshID;
					$to_dataom['datatype'] = '审核任务';
					foreach($process as $p){
						$to_dataom['DUR'] = $om_bumen.','.$p['UR'];
						//过滤统一部门DUR
						$tmp_d = $DataOM->where("`DUR`= '$to_dataom[DUR]' and `dataID` = '$to_dataom[dataID]' and `datatype` = '$to_dataom[datatype]'")->find();
						if(!$tmp_d){
							if(false === $DataOM->mycreate($to_dataom)){
							dump(896563453);
							dump($DataOM);
							}
						}
					}
				}
			}
			else
			dump($System);
		}
					
			
			
			
			
	
	}
	
	
	
	
	
	
	//生成审核任务----------------------
	public function _taskshenhe_build($baozhang,$newbaozhang,$type,$dataOMlist,$relationdata ='',$relationdata_2 ='')
	{
		$Chanpin = D("Chanpin");
		$xd['chanpinID'] = $newbaozhang['chanpinID'];
		$System = D("System");
		if($type == '团队报账单'){
			if(($baozhang['status'] != '财务总监通过' && $baozhang['status'] != '财务通过') && ($baozhang['time'] + 3600 * 24 * 30)  < time()){
				//更新报账
				$xd['shenhe_remark'] = '未审核';
				$Chanpin->save($xd);
				return;
			}
			$datatype = '报账单';
			if($baozhang['caozuoren'] || $baozhang['status'] == '计调申请'){
				if(!$baozhang['bumenren'] && !$baozhang['caiwuren'] && $baozhang['status'] != '计调申请')
					return;
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $baozhang['caozuoren'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata['user_name'];
					$baozhang['caozuoren'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['datakind'] = '团队报账单';
				$task['taskShenhe']['title_copy'] = $newbaozhang["baozhang"]['title'];
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
					$task['shenqingname'] = $task['user_name'];
					$task['shenqingbumenID'] = $newbumenID;
					$task['shenqingbumentitle'] = $bumen['title'];
				}
				else{
				dump(97342342);
				dump($System);
				}
			}
			if(($baozhang['caozuoren'] && $baozhang['bumenren']) || $baozhang['status'] == '经理通过'){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['bumenren'];
				if(!$task['user_name']){
					if($relationdata['guojing'] == '境外')
					$task['user_name'] = '单莲莲';
					if($relationdata['guojing'] == '国内')
					$task['user_name'] = '王晓辉';
					$baozhang['bumenren'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if(($baozhang['caozuoren'] && $baozhang['bumenren'] && $baozhang['caiwuren']) || $baozhang['status'] == '财务通过'){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['caiwuren'];
				if(!$task['user_name']){
					$task['user_name'] = '崔军';
					$baozhang['caiwuren'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if(($baozhang['caozuoren'] && $baozhang['bumenren'] && $baozhang['caiwuren'] && $baozhang['caiwuzongjian']) || $baozhang['status'] == '财务总监通过'){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['caiwuzongjian'];
				if(!$task['user_name']){
					$task['user_name'] = '龚敏娜';
					$baozhang['caiwuzongjian'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 4;
				$task['taskShenhe']['remark'] = '财务总监批准';
				$task['taskShenhe']['roles_copy'] = '财务总监';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($baozhang['caozuoren'] && $baozhang['bumenren'] && $baozhang['caiwuren'] && $baozhang['caiwuzongjian'] && $baozhang['manager']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['manager'];
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 5;
				$task['taskShenhe']['remark'] = '总经理批准';
				$task['taskShenhe']['roles_copy'] = '总经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
				  $taskID = '';
				}
			}
				
		}
			
			
		if($type == '报账项'){
			if(($baozhang['check_status'] != '审核通过') && ($baozhang['time'] + 3600 * 24 * 30)  < time()){
				//更新报账
				$xd['shenhe_remark'] = '未审核';
				$Chanpin->save($xd);
				return;
			}
			$datatype = '报账项';
			if($baozhang['edituser'] || $baozhang['check_status'] == '审核通过'){
				if(!$baozhang['manager'] && !$baozhang['check_user'] && $baozhang['check_status'] != '审核通过')
					return;
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $relationdata['user_name'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata_2['caozuoren'];
					$baozhang['edituser'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['datakind'] = '报账项';
				$task['taskShenhe']['title_copy'] = $newbaozhang["baozhangitem"]['title'];
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
					$task['shenqingname'] = $task['user_name'];
					$task['shenqingbumenID'] = $newbumenID;
					$task['shenqingbumentitle'] = $bumen['title'];
				}
			}
			if(($baozhang['edituser'] && $baozhang['manager']) || $baozhang['check_status'] == '审核通过'){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['manager'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata_2['bumenren'];
					$baozhang['manager'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
			}
			if(($baozhang['edituser'] && $baozhang['manager'] && $baozhang['check_user']) || $baozhang['check_status'] == '审核通过'){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['check_user'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata_2['caiwuren'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
				  $taskID = '';
				}
			}
		}
			
			
		if($type == '单项服务'){
			if(($baozhang['status'] != '财务总监通过' && $baozhang['status'] != '财务通过') && ($baozhang['time'] + 3600 * 24 * 30)  < time()){
				//更新报账
				$xd['shenhe_remark'] = '未审核';
				$Chanpin->save($xd);
				return;
			}
			$datatype = '报账单';
			if($baozhang['username'] || $baozhang['status'] == '财务通过' || $baozhang['status'] == '财务总监通过'){
				if(!$baozhang['manager'] && !$baozhang['check_user'] && $baozhang['status'] != '财务通过' && $baozhang['status'] != '财务总监通过')
					return;
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $baozhang['username'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata['user_name'];
					$baozhang['username'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['datakind'] = $newbaozhang['baozhang']['type'];
				$task['taskShenhe']['title_copy'] = $newbaozhang["baozhang"]['title'];
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
					$task['shenqingname'] = $task['user_name'];
					$task['shenqingbumenID'] = $newbumenID;
					$task['shenqingbumentitle'] = $bumen['title'];
				}
				else{
				dump(12313114151515);
				dump($System);
				}
			}
			if(($baozhang['username'] && $baozhang['manager']) || $baozhang['status'] == '经理通过'){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['manager'];
				if(!$task['user_name']){
					if($relationdata['guojing'] == '境外')
					$task['user_name'] = '单莲莲';
					if($relationdata['guojing'] == '国内')
					$task['user_name'] = '王晓辉';
					$baozhang['manager'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if(($baozhang['username'] && $baozhang['manager'] && $baozhang['check_user']) || $baozhang['status'] == '财务通过'){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['check_user'];
				if(!$task['user_name']){
					$task['user_name'] = '崔军';
					$baozhang['check_user'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if(($baozhang['username'] && $baozhang['manager'] && $baozhang['check_user'] && $baozhang['caiwu_manager']) || $baozhang['status'] == '财务总监通过'){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['caiwu_manager'];
				if(!$task['user_name']){
					$task['user_name'] = '龚敏娜';
					$baozhang['caiwu_manager'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 4;
				$task['taskShenhe']['remark'] = '财务总监批准';
				$task['taskShenhe']['roles_copy'] = '财务总监';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($baozhang['username'] && $baozhang['manager'] && $baozhang['check_user'] && $baozhang['caiwu_manager'] && $baozhang['bigmanager']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['bigmanager'];
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 5;
				$task['taskShenhe']['remark'] = '总经理批准';
				$task['taskShenhe']['roles_copy'] = '总经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
				  $taskID = '';
				}
			}
		}
			
			
		if($type == '单项服务报账项'){
			if(($baozhang['status'] != '财务通过') && ($baozhang['time'] + 3600 * 24 * 30)  < time()){
				//更新报账
				$xd['shenhe_remark'] = '未审核';
				$Chanpin->save($xd);
				return;
			}
			$datatype = '报账项';
			if($newbaozhang['user_name'] || $baozhang['status'] == '财务通过'){
				if(!$baozhang['manager'] && !$baozhang['caiwu'] && $baozhang['status'] != '财务通过')
					return;
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $newbaozhang['user_name'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata['username'];
					$newbaozhang['user_name'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['datakind'] = $newbaozhang['datakind'];
				$task['taskShenhe']['title_copy'] = $newbaozhang["baozhangitem"]['title'];
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
					$task['shenqingname'] = $task['user_name'];
					$task['shenqingbumenID'] = $newbumenID;
					$task['shenqingbumentitle'] = $bumen['title'];
				}
				else{
				dump(6456242322);
				dump($System);
				}
			}
			if(($newbaozhang['user_name'] && $baozhang['manager']) || $baozhang['status'] == '财务通过'){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['manager'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata['manager'];
					$baozhang['manager'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if(($newbaozhang['user_name'] && $baozhang['manager'] && $baozhang['caiwu']) || $baozhang['status'] == '财务通过'){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['caiwu'];
				if(!$task['user_name']){
					$task['user_name'] = $relationdata['check_user'];
					$baozhang['caiwu'] = $task['user_name'];
				}
				$bumen = $this->_getnewbumenbyusername($task['user_name']);
				$newbumenID = $bumen['systemID'];
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
				  $taskID = '';
				}//
				
			}
		}
		//生成备份
		if($task['status'] == '批准'){
			A("Method")->makefiledatacopy($newbaozhang['chanpinID'],$datatype,$task['parentID']);
			if($type == '团队报账单'){
				//联动更新
				$xd['baozhangzituanlist']['baozhang_remark'] = $task['taskShenhe']['remark'];
				$xd['baozhangzituanlist']['baozhang_time'] = $baozhang['caiwu_time'];
				$xd['baozhangzituanlist']['status_baozhang'] = $task['status'];
				$xd['shenhe_time'] = $baozhang['caiwu_time'];
				$xd['parentID'] = $newbaozhang['parentID'];
			}
			if($type == '报账项' || $type == '单项服务报账项')
			$xd['shenhe_time'] = $baozhang['time'];
			if($type == '单项服务')
			$xd['shenhe_time'] = $baozhang['check_time'];
		}
		$xd['islock'] = '已锁定';
		$xd['status_shenhe'] = $task['status'];
		$xd['shenhe_remark'] = $task['taskShenhe']['remark'];
		if($type == '团队报账单')
		$Chanpin->relation("baozhangzituanlist")->myRcreate($xd);
		else
		$Chanpin->save($xd);
		
		if($taskID){
			//生成待检出
			$task['user_name'] = $task['shenqingname'];
			$task['departmentID'] = $task['shenqingbumenID'];
			$task['status'] = '待检出';
			$task['taskShenhe']['processID'] += 1;
			unset($task['taskShenhe']['roles_copy']);
			//检查流程
			$process = A("Method")->_checkShenhe($datatype,$task['taskShenhe']['processID']);
			if(false === $process)
			return;
			if(false !== $System->relation("taskShenhe")->myRcreate($task))
			{
				$dshID = $System->getRelationID();
				//生成待检出OM
				$DataOM = D("DataOM");
				foreach($dataOMlist as $vo){
					list($om_bumen,$om_roles,$om_user) = split(',',$vo['DUR']);
					$to_dataom['type'] = '管理';
					$to_dataom['dataID'] = $dshID;
					$to_dataom['datatype'] = '审核任务';
					foreach($process as $p){
						$to_dataom['DUR'] = $om_bumen.','.$p['UR'];
						//过滤统一部门DUR
						$tmp_d = $DataOM->where("`DUR`= '$to_dataom[DUR]' and `dataID` = '$to_dataom[dataID]' and `datatype` = '$to_dataom[datatype]'")->find();
						if(!$tmp_d){
							if(false === $DataOM->mycreate($to_dataom)){
							dump(67546234525);
							dump($DataOM);
							}
						}
					}
				}
			}
			else{
				dump(3425626262);
			dump($System);
			}
		}
					
		
	}
	
	
	
	
	//生成订单临时游客----------------------
	public function _dingdan_customer_build($dingdan,$newdingdan,$dataOMlist)
	{
		$DataCD = D("DataCD");
		$gltuanyuan = M("gltuanyuan");
		if($dingdan['diyinput'] != '文件名单'){
			$tuanyuanall = $gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findall();
			foreach($tuanyuanall as $v){
				$data = $v;
				if($data['name'] == '')
				$data['name'] = 0;
				$data['dingdanID'] = $newdingdan['chanpinID'];
				$v['dingdanID'] = $newdingdan['chanpinID'];
				$data['price'] = $v['jiaoqian'];
				$v['price'] = $v['jiaopian'];
				$data['datatext'] = serialize($v);
				$data['zituanID'] = $newdingdan['prarentID'];
				if(false !== $DataCD->mycreate($data)){
				}
				else
				{
					dump(453634673673);
					dump($DataCD);
					exit;
					}
			}
		}
	
	}
	
	
	
	
	
	
    public function doMessage() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		//公告
		$glnews=M("glnews");
		$gonggaoall = $glnews->where("`type` = '新闻公告'")->findall();
		$Message=D("Message");
		foreach($gonggaoall as $v){
			if($v['title'] =='')
			continue;
			unset($v['messageID']);
			$data = $v;
			$data['info'] = $v;
			$data['user_name'] = $v['username'];
			$data['status'] = '';
			$bumen = $this->_getnewbumenbyusername($data['user_name']);
			$data['departmentID'] = $bumen['systemID'];
			$data['info']['title'] = $v['title'];
			$data['info']['usedDUR'] = ",,".$this->_getuserIDbytitle($v['username']);
			$data['info']['type'] = '公告';
			$data['info']['message'] = $v['content'];
			if(false !== $Message->relation("info")->myRcreate($data)){
				$messageID = $Message->getRelationID();
				$bumenlist = D("ViewDepartment")->findall();
				$i = 0;
				foreach($bumenlist as $v){
					if(in_array("联合体",$v['type']) || in_array("办事处",$v['type']))
					;
					else{
						$dataOMlist[$i]['DUR'] = $v['systemID'].',,';
						$i++;
					}
				}
				A("Method")->_createDataOM($messageID,'公告','管理',$dataOMlist,'DataOMMessage');
			}
			else{
				dump(42425325626);
			dump($Message);exit;	
				
			}
		}
		echo "结束";
		return true;
		
	
	}
	
	
    public function doMessage_paituanbiao() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		//公告
		$glbasedata=M("glbasedata");
		$paituanbiaoall = $glbasedata->where("`type` = '排团表'")->findall();
		$Message=D("Message");
		foreach($paituanbiaoall as $v){
			if($v['title'] =='')
			continue;
			$data = $v;
			$data['info'] = $v;
			$data['user_name'] = '潘思迪';
			$data['time'] = $v['pubdate'];
			$data['status'] = '';
			$bumen = $this->_getnewbumenbyusername($data['user_name']);
			$data['departmentID'] = $bumen['systemID'];
			$data['info']['title'] = $v['title'];
			$data['info']['usedDUR'] = ",,".$this->_getuserIDbytitle($v['username']);
			$data['info']['type'] = '排团表';
			$data['info']['message'] = '';
			$data['info']['sortvalue'] = $v['value'];
			$data['info']['url_file'] = $v['pic_url'];
			if(false !== $Message->relation("info")->myRcreate($data)){
				$messageID = $Message->getRelationID();
				$bumenlist = D("ViewDepartment")->findall();
				$i = 0;
				foreach($bumenlist as $v){
					if(in_array("联合体",$v['type']) || in_array("办事处",$v['type']))
					;
					else{
						$dataOMlist[$i]['DUR'] = $v['systemID'].',,';
						$i++;
					}
				}
				A("Method")->_createDataOM($messageID,'排团表','管理',$dataOMlist,'DataOMMessage');
			}
			else{
				dump(25626672727);
			dump($Message);exit;	
				
			}
		}
		echo "结束";
		return true;
		
	
	}
	
	
	
	
    public function _xianlu_shoujia($xianlu,$newxianlu){
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$ViewCategory = D("ViewCategory");
		$category = $ViewCategory->where("`title` = '系统内所有单位'")->find();
		//搜索价格
		$glxianlujiage = M("glxianlujiage");
		$jiage = $glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
		if($jiage['chengrenzongjia'] == '' || $jiage['ertongzongjia'] == '')
		return;
		$_REQUEST['parentID'] = $newxianlu['chanpinID'];
		$_REQUEST['type'] = '标准';
		$_REQUEST['time'] = $newxianlu['time'];
		$_REQUEST['adultprice'] = $jiage['chengrenzongjia'];
		$_REQUEST['title'] = $category['title'];
		$_REQUEST['openID'] = $category['systemID'];
		$_REQUEST['opentype'] = '分类';
		$_REQUEST['childprice'] = $jiage['ertongzongjia'];
		$_REQUEST['chengben'] = $jiage['ertongzongjia'];
		//$_REQUEST['chengben'] = 0;
		$_REQUEST['cut'] = 200;
		$_REQUEST['renshu'] = $xianlu['renshu'];
		$data = $_REQUEST;
		$data['shoujia'] = $_REQUEST;
		$data['user_name'] = $newxianlu['user_name'];
		$data['departmentID'] = $newxianlu['departmentID'];
		if (false !== $Chanpin->relation("shoujia")->myRcreate($data)){
			$data['chanpinID'] = $Chanpin->getRelationID();
			//同步售价表线路状态
			A("Method")->_tongbushoujia($data['parentID']);
			//生成开放OM	
			A('Method')->_shoujiaToDataOM($data);
		}
		else{
				dump(2626266666);
			dump($Chanpin);	
			exit;
		}
	
	}
	
	
	
    public function _xianluext_build($xianlu,$newxianlu,$type=''){
		$Chanpin = D("Chanpin");
		if($type == '包团'){
			$glbaotuan_ext = M("glbaotuan_ext");
			$ext = $glbaotuan_ext->where("`xianluID` = '$xianlu[xianluID]'")->find();
			$xianluext['baotuandanwei'] = $ext['baotuan_uni'];
			$xianluext['remark'] = $ext['price_big'];
			$xianluext['quanpei'] = $ext['quanpeiren'];
			$xianluext['adultprice'] = $ext['chengren_price'];
			$xianluext['childprice'] = $ext['ertong_price'];
			$xianluext['zongjia'] = $ext['sum_price'];
			$data['xianlu']['xianlu_ext'] = serialize($xianluext);
			$data['xianlu']['chufadi'] = '辽宁,大连';
		}
		else{
			//境外团
			$glxianlu_ext=M("glxianlu_ext");
			$ext = $glxianlu_ext->where("`xianluID` = '$xianlu[xianluID]'")->find();
			$dat['xianlu']['xianlu_ext'] = serialize($ext);		
		}
		$data['chanpinID'] = $newxianlu['chanpinID'];
		if(false === $Chanpin->relation("xianlu")->myRcreate($data)){
		dump(02423432);
		dump($Chanpin);
		}
	}
	
	
	
	
    public function _xianlu_xingcheng($xianlu,$newxianlu){
		$Chanpin = D("Chanpin");
		$glxingcheng = M("glxingcheng");
		$xingchengall = $glxingcheng->where("`xianluID` = '$xianlu[xianluID]'")->findall();
		$data['parentID'] = $newxianlu['chanpinID'];
		$data['user_name'] = $newxianlu['user_name'];
		$data['departmentID'] = $newxianlu['departmentID'];
		foreach($xingchengall as $v){
			$time = explode(',',$v['time']);
			$data['xingcheng']['chanyin'] = serialize($time);
			$tools = explode(',',$v['tools']);
			$data['xingcheng']['tools'] = serialize($tools);
			$data['xingcheng']['place'] = $v['place'];
			$data['xingcheng']['content'] = $v['content'];
			if(false == $Chanpin->relation("xingcheng")->myRcreate($data))
			{
				dump(4444444);
				dump($Chanpin);
				exit;	
				
			}
		}
	}
	
	
	
    public function _xianlu_chengben($xianlu,$newxianlu){
		$Chanpin = D("Chanpin");
		$glxianlujiage = M("glxianlujiage");
		$glchengbenxiang = M("glchengbenxiang");
		$jiage = $glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
		$chengbenall = $glchengbenxiang->where("`jiageID` = '$jiage[jiageID]'")->findall();
		$data['parentID'] = $newxianlu['chanpinID'];
		$data['user_name'] = $newxianlu['user_name'];
		$data['departmentID'] = $newxianlu['departmentID'];
		foreach($chengbenall as $v){
			$data['chengben']['title'] = $v['leixing'];
			$data['chengben']['remark'] = $v['miaoshu'];
			$data['chengben']['price'] = $v['jiage'];
			$data['chengben']['jifeitype'] = $v['jifeileixing'];
			if(false == $Chanpin->relation("chengben")->myRcreate($data))
			{
				dump(23536437547858);
				dump($Chanpin);
				exit;	
			}
		}
	}
	
	
	
	//清除多余数据
    public function clearuselessdata($xianlu,$newxianlu){
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$System = D("System");	
		$all = $System->findall();
		foreach($all as $v){
//			if($v['status_system'] == -1 || $v['marktype'] == ''){
//				$System->where("`systemID` = '$v[systemID]'")->delete();
//			}
			if($v['marktype'] == 'category'){
				$d = M("myerpview_system_category")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'customer'){
				$d = M("myerpview_system_customer")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'datadictionary'){
				$d = M("myerpview_system_datadictionary")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'systemDC'){
				$d = M("myerpview_system_dc")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'department'){
				$d = M("myerpview_system_department")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'directory'){
				$d = M("myerpview_system_directory")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'systemDUR'){
				$d = M("myerpview_system_dur")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'systemOM'){
				$d = M("myerpview_system_om")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'roles'){
				$d = M("myerpview_system_roles")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'shenhe'){
				$d = M("myerpview_system_shenhe")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'taskShenhe'){
				$d = M("myerpview_system_taskshenhe")->where("`systemID` = '$v[systemID]'")->find();
			}
			if($v['marktype'] == 'user'){
				$d = M("myerpview_system_user")->where("`systemID` = '$v[systemID]'")->find();
			}
			if(!$d)
			$System->where("`systemID` = '$v[systemID]'")->delete();
		}
		echo "结束";
	}
	
	//重置系统表
    public function resetsystemstatus(){
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$System = D("System");	
		$all = $System->findall();
		foreach($all as $v){
			$dd['status'] = '';
			$dd['bumen_copy'] = '系统';
			$dd['departmentID'] = '-1';
			$dd['user_name'] = '系统';
			$dd['islock'] = '未锁定';
			$dd['systemID'] = $v['systemID'];
			if(false === $System->save($dd)){
			dump($System);
			exit;
			}
		}
		echo "结束";
	}
	
	
	//目录重置
    public function reset_directory(){
		$System = D("System");	
		$ViewDirectory = D("ViewDirectory");	
		$all = $ViewDirectory->findall();
		foreach($all as $v){
			$dd['marktype'] = 'directory';
			$dd['systemID'] = $v['systemID'];
			if(false === $System->save($dd))
			dump($System);
			
		}
		
	}
	
	
	//目录重置
    public function reset_dur(){
		$System = D("System");	
		$ViewDirectory = D("ViewSystemDUR");	
		$all = $ViewDirectory->findall();
		foreach($all as $v){
			$dd['marktype'] = 'systemDUR';
			$dd['systemID'] = $v['systemID'];
			if(false === $System->save($dd))
			dump($System);
			
		}
		
	}
	
	
	//补填用户
    public function fillusertouser() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$gladminuser=M("gladminuser");
		$userall = $gladminuser->findall();
		$System = D("System");
		$ViewUser = D("ViewUser");
		$users=M("Users");
		foreach($userall as $v)
		{
			$u = $ViewUser->where("`title` = '$v[user_name]'")->find();
			if($u || $v['user_name'] == 'zhangwen' || !$v['user_name'])
			continue;
			$b = $users->where("`user_id` = '$v[user_id]'")->find();
			$b['user'] = $b;
			if(false === $System->relation("user")->myRcreate($b)){
			dump($System);	
				exit;
			}
			$systemID = $System->getRelationID();
			$this->_fillDUR($v,$systemID);
		}
		echo "结束";
	
	
	}
	
	
	//补填部门
    public function fillbumentobumen() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$System = D("System");
		$glbasedata=M("glbasedata");
		$bball = $glbasedata->where("`type` = '部门'")->findall();
		$ViewDepartment = D("ViewDepartment");
		foreach($bball as $v)
		{
			$u = $ViewDepartment->where("`title` = '$v[title]'")->find();
			if($u || !$v['title'])
			continue;
			$c['parentID'] = $parentID;
			$c['department'] = $v;
			$System->relation("department")->myRcreate($c);
		}
		echo "结束";
		return true;
	}
	
	
	
	//清空临时数据
    public function cleartabledata() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$myerp_system_taskshenhe=M("myerp_system_taskshenhe");
		$myerp_system_om=M("myerp_system_om");
		$myerp_system_customer=M("myerp_system_customer");
		$myerp_system_customer=M("myerp_system_customer");
		
		$task = $myerp_system_taskshenhe->findall();
		$om = $myerp_system_om->findall();
		$customer = $myerp_system_customer->findall();
		foreach($task as $v){
			$myerp_system_taskshenhe->where("`systemID` = '$v[systemID]'")->delete();
		}
		foreach($om as $v){
			$myerp_system_om->where("`systemID` = '$v[systemID]'")->delete();
		}
		foreach($customer as $v){
			$myerp_system_customer->where("`systemID` = '$v[systemID]'")->delete();
		}
		
		echo "结束";
		return true;
	}
	
	
	//重置用户名zhangwen
    public function bumenzhangwenreset() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data['user_name'] = '张文';
		$Chanpin->where("`user_name` = 'zhangwen'")->save($data);
		$data = '';
		$data['bumen_copy'] = '直营-电子商务营业部';
		$Chanpin->where("`bumen_copy` = '技术支持'")->save($data);
		echo "结束";
		return true;
	}
	
	//重置子团准备状态到报名
    public function zituanstatusreset() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data['status'] = '报名';
		$data['islock'] = '已锁定';
		$Chanpin->where("`marktype` = 'zituan' and `status` = '准备'")->save($data);
		$data = '';
		$data['islock'] = '已锁定';
		$Chanpin->where("`marktype` = 'zituan'")->save($data);
		echo "结束";
		return true;
	}
	
	
	
	
	
}
?>




