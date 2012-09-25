<?php

class FormeAction extends Action{
	
	
    public function index() {
		$this->display('Index:forme');
	}
	
	//基础数据
    public function fillSystemAll() {
 		$this->filldepartment();
		$this->fillrole();
		$this->filluser();
	}
	
	
	//线路
    public function chanpinxianlu() {
		echo "开始";
		echo "<br>";
		
		C('TOKEN_ON',false);
		$gl_xianlu=M("glxianlu");
		$xianluAll = $gl_xianlu->order('time DESC')->findall();
		$Chanpin=D("Chanpin");
		$glxianlujiage = M("glxianlujiage");
		foreach($xianluAll as $v)
		{
			$dat = $v;
			$dat['xianlu'] = $v;
			$dat['time'] = time();//临时+++++++++++++++++++++++++
			$dat['status'] = $v['zhuangtai'];
			$dat['xianlu']['title'] = $v['mingcheng'];
			//部门
			$dat['departmentID'] = $this->_getnewbumenID($v['departmentName']);
			$dat['bumen_copy'] = $v['departmentName'];
			//审核时间
			if($v['zhuangtai'] == '报名' || $v['zhuangtai'] == '截止'){
				$dat['islock'] = '已锁定';
				$dat['shenhe_time'] = $v['time'];
				$dat['shenhe_remark'] = '已审核';
			}
			else
				$dat['status'] = '准备';
			//售价及儿童说明
			$jiage = $glxianlujiage->where("`xianluID` = '$v[xianluID]'")->find();
			$dat['xianlu']['shoujia'] = $jiage['chengrenzongjia'];
			$dat['xianlu']['remark'] = $jiage['ertongshuoming'];
			//天数
			if(!$dat['xianlu']['tianshu'])
				$dat['xianlu']['tianshu'] = 0;
			//人数
			if(!$dat['xianlu']['renshu'])
				$dat['xianlu']['renshu'] = 0;
			if (false !== $Chanpin->relation("xianlu")->myRcreate($dat)){
				$xianluID = $Chanpin->getRelationID();
				$dat['chanpinID'] = $xianluID;
				$dataOMlist = A("Method")->_setDataOMlist('计调','组团');
				A("Method")->_createDataOM($xianluID,'线路','管理',$dataOMlist);
				if($v['zhuangtai'] == '报名' || $v['zhuangtai'] == '截止'){
					//生成备份
					A("Method")->makefiledatacopy($xianluID,'线路',-1);
					//开放售价
					if($v['zhuangtai'] == '报名')
					$this->_xianlu_shoujia($v,$dat,$dataOMlist);
					//zituan
					$this->_zituan_build($v,$dat,$dataOMlist);
				}
				//附表
				if($v['guojing'] == '境外')
				$this->_xianluext_build($v,$dat);
				if($v['xianlutype'] == '包团' && $v['guojing'] != '境外')
				$this->_xianluext_build($v,$dat,'包团');
				//行程
				$this->_xianlu_xingcheng($v,$dat);
				//成本
				$this->_xianlu_chengben($v,$dat);
				
			}
			else{
				dump(12312333333);
				dump($Chanpin);
				exit;
			}
			
			
			//message
//			$this->chanpinxiaoxi($v,$chanpinID);
			//exit;
		}
		
		echo "结束";
		
    }
	
	
	//地接
    public function chanpindijie() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$dj_tuan=M("dj_tuan");
		$datalist = $dj_tuan->order('time DESC')->findall();
		$Chanpin=D("Chanpin");
		$dj_itinerary=M("dj_itinerary");
		$dj_rcitem=M("dj_rcitem");
		$dj_appraisal=M("dj_appraisal");
		$dj_orderhotel=M("dj_orderhotel");
		foreach($datalist as $v){
			$dat = $v;
			$dat['DJtuan'] = $v;
			$dat['time'] = time();//临时+++++++++++++++++++++++++
			//计算截止状态
			if(strtotime($v['startdate']) < time())
			$dat['status'] = '截止';
			$dat['user_name'] = $v['adduser'];
			$bumen = $this->_getnewbumenbyusername($dat['user_name']);
			$dat['departmentID'] = $bumen['systemID'];
			$dat['bumen_copy'] = $bumen['title'];
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
				$dataOMlist = A("Method")->_setDataOMlist('地接','地接');
				A("Method")->_createDataOM($chanpinID,'地接','管理',$dataOMlist);
				//生成报账单----------------------
				$this->_baozhangdan_dijie_build($v,$dat,$dataOMlist);
				//生成随团单项服务报账单----------------------
				$this->_danxiangfuwu_build($dat,$dataOMlist,'地接');
			}
			else
			{
				dump(2342536346);
				dump($Chanpin);
				exit;
			}
		}
		
		echo "结束";
		
    }
	
	
	//获得部门ID：根据同名部门获得新ID
	function _getnewbumenID($title){
		$ViewDepartment=D("ViewDepartment");
		$bumen = $ViewDepartment->where("`title` = '$title'")->find();
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
		$roleuser = M('Glkehu')->where("`user_name`='$user_name'")->find();
		$mydepartment = M('glbasedata')->where("`id`='$roleuser[department]'")->find();
		$ViewDepartment=D("ViewDepartment");
		$bumen = $ViewDepartment->where("`title` = '$mydepartment[title]'")->find();
		return $bumen;
	}
	
	
	
	
	//用户相关
    public function filluser() {
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
			$this->fillDUR($v,$systemID);
		}
		echo "结束";
	}
	
	//部门相关
    public function filldepartment() {
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
				$System->relation("department")->myRcreate($v);
				$parentID = $System->getRelationID();
				$bball = $glbasedata->where("`type` = '部门'")->findall();
				foreach($bball as $c)
				{
					$c['parentID'] = $parentID;
					$c['department'] = $c;
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
				$System->relation("department")->myRcreate($v);
			}
			
		}
		echo "结束";
		return true;
	}
	
	
	//角色相关
    public function fillrole() {
		
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
    public function fillDUR($user,$newuser_ID) {
		//unserialize
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$System = D("System");
		$list = unserialize($user['department_list']);
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
	
	//角色相关
    public function filldc($department,$systemID) {
		
		C('TOKEN_ON',false);
		$SystemDC=D("SystemDC");
		
		if($department['type'] == '办事处' )
		{
			$data['systemID'] = $systemID;
			$data['category'] = '办事处';
			$SystemDC->add($v);
		}
		elseif($department['title'] == '联合体' )
		{
			$data['systemID'] = $systemID;
			$data['category'] = '联合体';
			$SystemDC->add($v);
		}
		elseif(false !== strpos($department['title'],'直营'))
		{
			$data['systemID'] = $systemID;
			$data['category'] = '直营门市';
			$SystemDC->add($v);
		}
		elseif(false !== strpos($department['title'],'加盟'))
		{
			$data['systemID'] = $systemID;
			$data['category'] = '加盟门市';
			$SystemDC->add($v);
		}
		else
		{
			$data['systemID'] = $systemID;
			$data['category'] = '加盟门市';
			$SystemDC->add($v);
		}
		
		
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
	
	
    private function xingcheng($v,$chanpinID) {
		
		$glxingcheng=M("glxingcheng");
		$xingchengAll = $glxingcheng->where("`xianluID` = '$v[xianluID]'")->findall();
		$Chanpin=D("Chanpin");
		//线路
		foreach($xingchengAll as $v)
		{
			$dat = $v;
			$dat['parentID'] = $chanpinID;
			$dat['xingcheng'] = $v;
			$dat['xingcheng']['chanyin'] = $v['time'];
			$Chanpin->relation("xingcheng")->myRcreate($dat);
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
			$dat['time'] = time();//临时+++++++++++++++++++++++++
			//部门
			$dat['departmentID'] = $newxianlu['departmentID'];
			$dat['bumen_copy'] = $newxianlu['bumen_copy'];
			$dat['parentID'] = $newxianlu['chanpinID'];
			//计算出团日期，重置子团状态
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
			else
				$dat['status'] = '准备';
			$dat['zituan']['title_copy'] = $newxianlu['xianlu']['title'];
			$dat['zituan']['jiedaijihua'] = serialize($jihua);
			$dat['zituan']['chutuantongzhi'] = serialize($tongzhi);
			$dat['zituan']['xianludata_copy'] = serialize($newxianlu);
			$dat['zituan']['guojing_copy'] = $newxianlu['guojing'];
			$dat['zituan']['kind_copy'] = $newxianlu['kind'];
			//报账单审核状态
			$baozhang = $gl_baozhang->where("`zituanID` = '$v[zituanID]'")->find();
			if($baozhang){
				$dat['islock'] = '已锁定';
				if($baozhang['status'] == '财务总监通过' || $baozhang['status'] == '财务通过' || $baozhang['status'] == '总经理通过'){
					$dat['zituan']['status_baozhang'] = '批准';
					$dat['zituan']['baozhang_remark'] = $baozhang['status'];
					$dat['zituan']['baozhang_time'] =  $baozhang['caiwu_time'];
				}
			}
			if(false !== $Chanpin->relation("zituan")->myRcreate($dat)){
				$zituanID = $Chanpin->getRelationID();
				$dat['chanpinID'] = $zituanID;
				A("Method")->_createDataOM($zituanID,'子团','管理',$dataOMlist);
				//生成报账单----------------------
				$this->_baozhangdan_build($dat,$dataOMlist);
				//生成随团单项服务报账单----------------------
				$this->_danxiangfuwu_build($dat,$dataOMlist,'子团');
				//生成订单----------------------
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
	
	
    public function fullinfo() {
		echo "开始";
		echo "<br>";
		//主题
		$theme = D('Line_theme');
		$theme_all = $theme->findAll();
		$Info=D("Info");
		foreach($theme_all as $v)
		{
			$d = $v;
			$d['time'] = $v['pubdate'];
			$d['islock'] = '未锁定';
			$d['user_name'] = '系统';
			$d['user_id'] = '-1';
			$d['departmentName'] = '系统';
			$d['departmentID'] = '-1';
			$d['status'] = '系统';
			$Info->add($d);
		}
		echo "结束";
	}
	
	
    private function chengbenshoujia($xianlu,$chanpinID) {
		
		$Glxianlujiage = D("Glxianlujiage");
		$Glchengbenxiang = D("Glchengbenxiang");
		$Glshoujia = D("Glshoujia");
		$Glchengben = D("Glchengben");
		
		$oldjiage = $Glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
		$dd = $this->myjiagedata($oldjiage);
//		//zituan
		$Zituan = D("Zituan");
		$Xianlu = D("Xianlu");
		$xl = $Xianlu->where("`chanpinID` = '$chanpinID'")->find();
		$xl['remark'] = $dd['xianlu']['remark'];
		$Xianlu->save($xl);
		
		//chengben
		$Chengben = D("Chengben");
		foreach($dd['chengben'] as $v)
		{
			$data = $v;
			$data['chanpinID'] = $chanpinID;
			$Chengben->add($data);
		}
		//shoujia
		$myerp_chanpin=M("myerp_chanpin");
		$myerp_chanpin_shoujia=M("myerp_chanpin_shoujia");
		foreach($dd['shoujia'] as $v)
		{
			//chanpin
			$data = $v;
			$data['parentID'] = $chanpinID;
			$data['user_name'] = $xianlu['user_name'];
			$data['user_id'] = $xianlu['user_id'];
			$data['departmentName'] = $xianlu['departmentName'];
			$data['departmentID'] = $xianlu['departmentID'];
			$data['time'] = $xianlu['time'];
			$chanpinID_shoujia = $myerp_chanpin->add($data);
			//chanpin shoujia
			$data2 = $v;
			$data2['chanpinID'] = $chanpinID_shoujia;
			$data2['type'] = '标准';
			$data2['renshu'] = $xianlu['renshu'];
			$myerp_chanpin_shoujia->add($data2);
			//jijiu
			if($dd['jijiu'])
			{
				$data3 = $dd['jijiu'];
				$data3['chanpinID'] = $chanpinID_shoujia;
				$data3['type'] = '机票酒店';
				$chanpinID_shoujia = $myerp_chanpin_shoujia->add($data3);
			}
		}
		
		

    }
	
	private function myjiagedata($oldjiage)
	{
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			$Glchengben = D("Glchengben");
			
			$xianlu['remark'] = $oldjiage['ertongshuoming'];
			//chengben
			$oldchengben = $Glchengbenxiang->where("`jiageID` = '$oldjiage[jiageID]'")->findall();
			  $i = 0;
			  foreach($oldchengben as $v)
			  {
				$chengben[$i]['title'] = $v['miaoshu'];
				$chengben[$i]['price'] = $v['jiage'] * $v['cishu'] * $v['shuliang'];
				$chengben[$i]['jifeitype'] = $v['jifeileixing'];
				$chengben[$i]['time'] = $v['time'];
				$i++;
			  }
			  //shoujia
			  $oldshoujia = $Glshoujia->where("`jiageID` = '$oldjiage[jiageID]'")->findall();
			  $i = 0;
			  foreach($oldshoujia as $v)
			  {
				  $shoujia[$i]['adultprice'] = $v['chengrenshoujia'];
				  $shoujia[$i]['childprice'] = $v['ertongshoujia'];
				  $shoujia[$i]['cut'] = $v['cut'];
				  $i++;
			  }
			  //jipiaojiudian
			  $jijiu['adultprice'] = $oldjiage['adultcostair'] + $oldjiage['adultcosthotle'];
			  $jijiu['childprice'] = $oldjiage['childcostair'] + $oldjiage['childcosthotle'];
			  $jijiu['cut'] = $oldjiage['aircut'] + $oldjiage['hotlecut'];
			  $jijiu['renshu'] = $oldjiage['airhotlenumber'];
			  
			  $re['jijiu'] = $jijiu;
			  $re['chengben'] = $chengben;
			  $re['shoujia'] = $shoujia;
			  $re['xianlu'] = $xianlu;
			  
			  return $re;
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
			$bzd['time'] = time();//临时+++++++++++++++++++++++++
			$bzd['user_name'] =  $zituan['user_name'];
			$bzd['departmentID'] =  $zituan['departmentID'];
			$bzd['bumen_copy'] = $zituan['bumen_copy'];
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
			$remark .= '，原团队ID：'.$v['djtuanID'].'，原报账单ID:'.$baozhang['baozhangID'];
			$bzd["baozhang"]['datatext']['remark'] = $remark;
			//报账人数
			$bzd["baozhang"]['renshu'] = $zituan['renshu'];
			//领队人数
			$lingdui_num = 0;
			$bzd["baozhang"]['datatext']['lingdui_num'] = $lingdui_num;
			//审核状态
			if($baozhang['financeperson']){
				$bzd['status_shenhe'] = '批准';
				$bzd['shenhe_remark'] = $baozhang['status'];
				$bzd['shenhe_time'] =  $baozhang['caiwu_time'];
			}
			//计算报账项
			$baozhangitemall = $dj_baozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and `check_status` = '审核通过'")->findall();
			foreach($baozhangitemall as $v){
				if($v['type'] == '结算项目')
				$bzd["baozhang"]['yingshou_copy'] += $v['price'];
				if($v['type'] == '支出项目')
				$bzd["baozhang"]['yingfu_copy'] += $v['price'];
			}
			$bzd["baozhang"]['datatext'] = serialize($bzd["baozhang"]['datatext']);
			if(false !== $Chanpin->relation("baozhang")->myRcreate($bzd)){
				$baozhangID = $Chanpin->getRelationID();
				$bzd['chanpinID'] = $baozhangID;
				A("Method")->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
				//生成审核任务？
				if($baozhang){
					$this->_taskshenhe_dijie_build($baozhang,$bzd,'团队报账单',$dataOMlist);
				}
				//生成报账项-----------------------
				foreach($baozhangitemall as $v){
					$bzditem = '';
					$bzditem['parentID'] = $baozhangID;
					$bzditem['time'] = $v['time'];
					$bzditem['user_name'] = $bzd['user_name'];
					$bzditem['departmentID'] = $bzd['departmentID'];
					$bzditem['bumen_copy'] = $bzd['bumen_copy'];
					$bzditem['baozhangitem']['value'] = $v['price'];
					$bzditem['baozhangitem']['method'] = $v['pricetype'];
					$bzditem['baozhangitem']['title'] = $v['title'];
					$bzditem['baozhangitem']['type'] = $v['type'];
					$bzditem['baozhangitem']['datatext']['remark'] = '原报账ID:'.$baozhang['baozhangID'].'原报账项ID：'.$v['baozhangitemID'];
					$bzditem['baozhangitem']['datatext'] = serialize($bzditem['baozhangitem']['datatext']);
					//审核状态
					if($v['check_status'] == '审核通过' && $v['type'] != '利润'){
						$bzditem['islock'] = '已锁定';
						$bzditem['status_shenhe'] = '批准';
						$bzditem['shenhe_remark'] = $v['check_status'];
						$bzditem['shenhe_time'] =  $v['check_time'];
					}
					if(false !== $Chanpin->relation("baozhangitem")->myRcreate($bzditem)){
						$baozhangitemID = $Chanpin->getRelationID();
						$bzditem['chanpinID'] = $baozhangitemID;
						A("Method")->_createDataOM($baozhangitemID,'报账项','管理',$dataOMlist);
						//生成审核任务？
						if($v['type'] != '利润')
						$this->_taskshenhe_dijie_build($v,$bzditem,'报账项',$dataOMlist,$zituan,$bzd['user_name']);
					} 
					else{
						dump("543535");
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
				
			
			
			
		}
		
		
		
		
	
	}
	
	
	//生成报账单----------------------
	public function _baozhangdan_build($zituan,$dataOMlist)
	{
		$Chanpin = D("Chanpin");
		$gl_baozhang=M("gl_baozhang");
		$gl_baozhangitem=M("gl_baozhangitem");
		$baozhang = $gl_baozhang->where("`zituanID` = '$zituan[zituanID]'")->find();
		$bzd["baozhang"]['title'] = $zituan['zituan']['title_copy'].'/'.$zituan['chutuanriqi'].'团队报账单';
		$bzd['parentID'] = $zituan['chanpinID'];
		$bzd['time'] = time();//临时+++++++++++++++++++++++++
		$bzd['user_name'] =  $zituan['user_name'];
		$bzd['departmentID'] =  $zituan['departmentID'];
		$bzd['bumen_copy'] = $zituan['bumen_copy'];
		$bzd["baozhang"]['type'] = '团队报账单';
		if($baozhang){
			$bzd["time"] = $baozhang['time'];
			$bzd["islock"] = '已锁定';
			//备注
			$remark = '原报账人数：'.$baozhang['renshu'];
			if($baozhang['passport_user'])
			$remark .= '，因私护照人：'.$baozhang['passport_user'];
			if($baozhang['no_change_user'])
			$remark .= '，不换汇人：'.$baozhang['no_change_user'];
			if($baozhang['no_back_user'])
			$remark .= '，不返程人：'.$baozhang['no_back_user'];
			if($baozhang['out_user'])
			$remark .= '，外地户口人：'.$baozhang['out_user'];
			$remark .= '，原团队ID：'.$zituan['zituanID'].'，原报账单ID:'.$baozhang['baozhangID'];
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
			$renshulist = explode('+',$baozhangrenshu);
			foreach($renshulist as $rs){
				$renshu += (int)$rs;
			}
			$bzd["baozhang"]['renshu'] = $renshu;
			//领队人数
			$lingdui_num = substr_count($baozhangrenshu,"+1");
			$bzd["baozhang"]['datatext']['lingdui_num'] = $lingdui_num;
			//审核状态
			if($baozhang['caiwuren']){
				$bzd['status_shenhe'] = '批准';
				$bzd['shenhe_remark'] = $baozhang['status'];
				$bzd['shenhe_time'] =  $baozhang['caiwu_time'];
			}
			//计算报账项
			$baozhangitemall = $gl_baozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and `check_status` = '审核通过'")->findall();
			foreach($baozhangitemall as $v){
				if($v['type'] == '结算项目')
				$bzd["baozhang"]['yingshou_copy'] += $v['price'];
				if($v['type'] == '支出项目')
				$bzd["baozhang"]['yingfu_copy'] += $v['price'];
			}
			$bzd["baozhang"]['datatext'] = serialize($bzd["baozhang"]['datatext']);
		}
		else{
			$bzd["baozhang"]['renshu'] = $zituan['renshu'];
		}
		
		
		if(false !== $Chanpin->relation("baozhang")->myRcreate($bzd)){
			$baozhangID = $Chanpin->getRelationID();
			$bzd['chanpinID'] = $baozhangID;
			A("Method")->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
			//生成审核任务？
			if($baozhang){
				$this->_taskshenhe_build($baozhang,$bzd,'团队报账单',$dataOMlist);
			}
			//生成报账项-----------------------
			foreach($baozhangitemall as $v){
				$bzditem = '';
				$bzditem['parentID'] = $baozhangID;
				$bzditem['time'] = $v['time'];
				$bzditem['user_name'] = $bzd['user_name'];
				$bzditem['departmentID'] = $bzd['departmentID'];
				$bzditem['bumen_copy'] = $bzd['bumen_copy'];
				$bzditem['baozhangitem']['value'] = $v['price'];
				$bzditem['baozhangitem']['method'] = $v['pricetype'];
				$bzditem['baozhangitem']['title'] = $v['title'];
				$bzditem['baozhangitem']['type'] = $v['type'];
				$bzditem['baozhangitem']['datatext']['remark'] = '原报账ID:'.$baozhang['baozhangID'].'原报账项ID：'.$v['baozhangitemID'];
				$bzditem['baozhangitem']['datatext'] = serialize($bzditem['baozhangitem']['datatext']);
				//审核状态
				if($v['check_status'] == '审核通过' && $v['type'] != '利润'){
					$bzditem['islock'] = '已锁定';
					$bzditem['status_shenhe'] = '批准';
					$bzditem['shenhe_remark'] = $v['check_status'];
					$bzditem['shenhe_time'] =  $v['check_time'];
				}
				if(false !== $Chanpin->relation("baozhangitem")->myRcreate($bzditem)){
					$baozhangitemID = $Chanpin->getRelationID();
					$bzditem['chanpinID'] = $baozhangitemID;
					A("Method")->_createDataOM($baozhangitemID,'报账项','管理',$dataOMlist);
					//生成审核任务？
					if($v['type'] != '利润')
					$this->_taskshenhe_build($v,$bzditem,'报账项',$dataOMlist,$zituan,$bzd['user_name']);
				} 
				else{
					dump("11111111111111");
					dump($Chanpin);
				exit;
				}
				
			}
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
		foreach($dxfwall as $dxfw){
			$bzd = '';
			$bzd['baozhang']['title'] = $dxfw['title'];
			if($dxfw['title_ext'])
			$bzd['baozhang']['title'] .= '/'.$dxfw['title_ext'];
			$bzd['parentID'] = $zituan['chanpinID'];
			$bzd['departmentID'] =  $zituan['departmentID'];
			$bzd['bumen_copy'] = $zituan['bumen_copy'];
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
			if($dxfw['tianshu'])
			$remark .= '天数:'.$dxfw['tianshu'];
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
			if($dxfw['other'])
			$remark .= '，其他:'.$dxfw['other'];
			$remark .= '，原报账附表ID:'.$dxfw['qianzhengID'].'，原团队ID：'.$zituanID;
			$bzd['baozhang']['datatext']['remark'] = $remark;
			$bzd['baozhang']['datatext'] = serialize($bzd['baozhang']['datatext']);
			if($dxfw['renshu'])
			$bzd["baozhang"]['renshu'] = $dxfw['renshu'];
			else
			$bzd["baozhang"]['renshu'] = 0;
			//审核状态
			if($dxfw['status'] == '财务总监通过' || $dxfw['status'] == '财务通过' || $dxfw['status'] == '总经理通过'){
				$bzd['status_shenhe'] = '批准';
				$bzd['shenhe_remark'] = $dxfw['status'];
				$bzd['shenhe_time'] =  $dxfw['check_time'];
				$bzd['islock'] =  '已锁定';
			}
			//计算报账项
			$baozhangitemall = $glqianzhengitem->where("`qianzhengID` = '$dxfw[qianzhengID]' and `status` = '财务通过'")->findall();
			foreach($baozhangitemall as $item){
				if($item['type'] == '应收费用')
				$bzd["baozhang"]['yingshou_copy'] += $item['value'];
				if($item['type'] == '费用明细')
				$bzd["baozhang"]['yingfu_copy'] += $item['value'];
			}
			$bzd['user_name'] =  $dxfw['username'];
			if(false !== $Chanpin->relation("baozhang")->myRcreate($bzd)){
				$baozhangID = $Chanpin->getRelationID();
				$bzd["chanpinID"] = $baozhangID;
				A("Method")->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
				//生成审核任务？
				$this->_taskshenhe_build($dxfw,$bzd,'单项服务',$dataOMlist);
				//生成随团服务报账项-----------------------
				foreach($baozhangitemall as $v){
					$bzditem = '';
					$bzditem['parentID'] = $baozhangID;
					$bzditem['time'] = $v['time'];
					$bzditem['user_name'] = $bzd['user_name'];
					$bzditem['departmentID'] = $bzd['departmentID'];
					$bzditem['bumen_copy'] = $bzd['bumen_copy'];
					$bzditem['baozhangitem']['value'] = $v['value'];
					$bzditem['baozhangitem']['method'] = '现金';
					$bzditem['baozhangitem']['title'] = $v['title'];
					$bzditem['baozhangitem']['datatext'] = '，原报账附表ID:'.$dxfw['qianzhengID'].'，原报账项附表ID：'.$v['qzitemID'];
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
					//审核状态
					if($v['status'] == '财务通过' && $v['type'] != '利润'){
						$bzditem['islock'] = '已锁定';
						$bzditem['status_shenhe'] = '批准';
						$bzditem['shenhe_remark'] = '审核通过';
						$bzditem['shenhe_time'] =  $v['time'];
					}
					if(false !== $Chanpin->relation("baozhangitem")->myRcreate($bzditem)){
						$baozhangitemID = $Chanpin->getRelationID();
						$bzditem['chanpinID'] = $baozhangitemID;
						A("Method")->_createDataOM($baozhangitemID,'报账项','管理',$dataOMlist);
						//生成审核任务？
						$this->_taskshenhe_build($v,$bzditem,'单项服务报账项',$dataOMlist);
					} 
					else{
				dump(78963543);
					dump($Chanpin);
					exit;
					}
				}
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
			$data['dingdan']['remark'] .= "，原订单ID：".$v['dingdanID'];
			$data['dingdan']['fuzebumenID'] = $zituan['departmentID'];
			$data['dingdan']['type'] = '标准';
			$data['dingdan']['shoujiaID'] = -1;
			$data['dingdan']['zituanID'] = $zituan['chanpinID'];
			if($data['dingdan']['telnum'] == '')
				$data['dingdan']['telnum'] = -1;
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
			$data['bumen_copy'] = $bumen['title'];
			//订单状态
			$data['status'] = '确认';
			if($v['check_status'] == '回收站'){
				$data['status'] = '候补';
				$data['status_system'] = -1;
			}
			if($v['check_status'] == '审核不通过'){
				$data['status'] = '候补';
			}
			if(false !== $Chanpin->relation("dingdan")->myRcreate($data)){
				$dingdanID = $Chanpin->getRelationID();
				$data['chanpinID'] = $dingdanID;
				A("Method")->_createDataOM($dingdanID,'订单','管理',$dataOMlist);
				//生成订单临时游客
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
	public function _taskshenhe_dijie_build($baozhang,$newbaozhang,$type,$dataOMlist,$relationdata =''){
		$System = D("System");
		if($type == '团队报账单'){
			$datatype = '报账单';
			if($baozhang['operateperson']){
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $baozhang['operateperson'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['bumen_copy'] = $bumen['title'];
				$task['taskShenhe']['datakind'] = '团队报账单';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
				}
				else{
				dump(8967635);
				dump($System);
				}
			}
			if($baozhang['operateperson'] && $baozhang['departmentperson']){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['departmentperson'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
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
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
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
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
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
			$datatype = '报账项';
			if($baozhang['edituser']){
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $relationdata['user_name'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['bumen_copy'] = $bumen['title'];
				$task['taskShenhe']['datakind'] = '报账项';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
				}
			}
			if($baozhang['check_status'] == '经理确认'){
				$task['status'] = '检出';
				$task['user_name'] = '于丹丹';
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
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
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
				  $taskID = '';
				}
			}
		}
			
			
			
			
		//生成备份
		if($task['status'] == '批准')
		A("Method")->makefiledatacopy($newbaozhang['chanpinID'],$datatype,$task['parentID']);
			
			
		if($taskID){
			//生成待检出
			$task['status'] = '待检出';
			$task['taskShenhe']['remark'] = $process[0]['remark'];
			$task['taskShenhe']['processID'] += 1;
			unset($task['taskShenhe']['roles_copy']);
			unset($task['taskShenhe']['bumen_copy']);
			$task['taskShenhe']['remark'] = '待检出';
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
	public function _taskshenhe_build($baozhang,$newbaozhang,$type,$dataOMlist,$relationdata ='')
	{
		$System = D("System");
		if($type == '团队报账单'){
			$datatype = '报账单';
			if($baozhang['caozuoren']){
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $baozhang['caozuoren'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['bumen_copy'] = $bumen['title'];
				$task['taskShenhe']['datakind'] = '团队报账单';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
				}
				else{
				dump(97342342);
				dump($System);
				}
			}
			if($baozhang['caozuoren'] && $baozhang['bumenren']){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['bumenren'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($baozhang['caozuoren'] && $baozhang['bumenren'] && $baozhang['caiwuren']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['caiwuren'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($baozhang['caozuoren'] && $baozhang['bumenren'] && $baozhang['caiwuren'] && $baozhang['caiwurenzongjian']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['caiwurenzongjian'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 4;
				$task['taskShenhe']['remark'] = '财务总监批准';
				$task['taskShenhe']['roles_copy'] = '财务总监';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($baozhang['caozuoren'] && $baozhang['bumenren'] && $baozhang['caiwuren'] && $baozhang['caiwurenzongjian'] && $baozhang['manager']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['manager'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
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
			$datatype = '报账项';
			if($baozhang['edituser']){
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $relationdata['user_name'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['bumen_copy'] = $bumen['title'];
				$task['taskShenhe']['datakind'] = '报账项';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
				}
			}
			if($baozhang['edituser'] && $baozhang['manager']){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['manager'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
			}
			if($baozhang['edituser'] && $baozhang['manager'] && $baozhang['check_user']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['check_user'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
				  $taskID = '';
				}
			}
		}
			
			
		if($type == '单项服务'){
			$datatype = '报账单';
			if($baozhang['username']){
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $baozhang['username'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['bumen_copy'] = $bumen['title'];
				$task['taskShenhe']['datakind'] = $newbaozhang['baozhang']['type'];
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
				}
				else{
				dump(12313114151515);
				dump($System);
				}
			}
			if($baozhang['username'] && $baozhang['manager']){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['manager'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($baozhang['username'] && $baozhang['manager'] && $baozhang['check_user']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['check_user'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 3;
				$task['taskShenhe']['remark'] = '财务批准';
				$task['taskShenhe']['roles_copy'] = '财务';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($baozhang['username'] && $baozhang['manager'] && $baozhang['check_user'] && $baozhang['caiwu_manager']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['caiwu_manager'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
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
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
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
			$datatype = '报账项';
			if($newbaozhang['user_name']){
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $newbaozhang['user_name'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 1;
				$task['taskShenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskShenhe']['datatype'] = $datatype;
				$task['taskShenhe']['remark'] = '计调申请';
				$task['taskShenhe']['roles_copy'] = '计调';
				$task['taskShenhe']['bumen_copy'] = $bumen['title'];
				$task['taskShenhe']['datakind'] = $newbaozhang['datakind'];
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
					$task['parentID'] = $taskID;
				}
				else{
				dump(6456242322);
				dump($System);
				}
			}
			if($newbaozhang['user_name'] && $baozhang['manager']){
				$task['status'] = '检出';
				$task['user_name'] = $baozhang['manager'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
				$task['departmentID'] = $newbumenID;
				$task['taskShenhe']['processID'] = 2;
				$task['taskShenhe']['remark'] = '经理检出';
				$task['taskShenhe']['roles_copy'] = '经理';
				if(false !== $System->relation("taskShenhe")->myRcreate($task)){
					$taskID = $System->getRelationID();
				}
				
			}
			if($newbaozhang['user_name'] && $baozhang['manager'] && $baozhang['caiwu']){
				$task['status'] = '批准';
				$task['user_name'] = $baozhang['caiwu'];
				$bumen = $this->_getoldbumenbyusername($task['user_name']);
				$newbumenID = $this->_getnewbumenID($bumen['title']);
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
		if($task['status'] == '批准')
		A("Method")->makefiledatacopy($newbaozhang['chanpinID'],$datatype,$task['parentID']);
			
			
		if($taskID){
			//生成待检出
			$task['status'] = '待检出';
			$task['taskShenhe']['remark'] = $process[0]['remark'];
			$task['taskShenhe']['processID'] += 1;
			unset($task['taskShenhe']['roles_copy']);
			unset($task['taskShenhe']['bumen_copy']);
			$task['taskShenhe']['remark'] = '待检出';
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
		if($dingdan['diyinput'] == '手入名单'){
			$tuanyuanall = $gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findall();
			foreach($tuanyuanall as $v){
				$data = $v;
				$data['dingdanID'] = $newdingdan['dingdanID'];
				$v['dingdanID'] = $newdingdan['dingdanID'];
				$data['price'] = $v['jiaoqian'];
				$v['price'] = $v['jiaopian'];
				$data['datatext'] = serialize($v);
				$data['zituanID'] = $newdingdan['prarentID'];
				$data['remark'] = '原团员ID：'.$v['tuanyuanID'];
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
			$data = $v;
			$data['info'] = $v;
			$data['user_name'] = $v['username'];
			$data['status'] = '';
			$bumen = $this->_getoldbumenbyusername($v['username']);
			$data['departmentID'] = $bumen['id'];
			$data['bumen_copy'] = $bumen['title'];
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
			$data['user_name'] = 'aaa';
			$data['time'] = $v['pubdate'];
			$data['status'] = '';
			$bumen = $this->_getoldbumenbyusername($data['username']);
			$data['departmentID'] = $bumen['id'];
			$data['bumen_copy'] = $bumen['title'];
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
	
	
	
    public function doCustomer() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$gltuanyuan = M("gltuanyuan");
		$tuanyuanall = $gltuanyuan->findall();
		$System = D("System");
		$gldingdan = M("gldingdan");
		foreach($tuanyuanall as $v){
			if($v['name']){
				if($v['zhengjianhaoma']){
					$data = $v;
					$data['customer'] = $v;
					$data['customer']['remark'] = $v['xuqiu'].'，'.$v['beizhu'];
					$data['customer']['hz_haoma'] = $v['huzhaohaoma'];
					$data['customer']['hz_qianfariqi'] = $v['hzqianfadi'];
					$data['customer']['hz_youxiaoriqi'] = $v['hzyouxiaoriqi'];
					if($v['zhengjiantype'] == '身份证')
					$data['customer']['sfz_haoma'] = $v['zhengjianhaoma'];
					if($v['zhengjiantype'] == '护照')
					$data['customer']['hz_haoma'] = $v['zhengjianhaoma'];
					if($v['zhengjiantype'] == '通行证')
					$data['customer']['txz_haoma'] = $v['zhengjianhaoma'];
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
		
		echo "结束";
		return true;
	}
	
	
	
    public function _xianlu_shoujia($xianlu,$newxianlu,$dataOMlist){
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$ViewCategory = D("ViewCategory");
		$category = $ViewCategory->where("`title` = '系统内所有单位'")->find();
		//搜索价格
		$glxianlujiage = M("glxianlujiage");
		$jiage = $glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
		$_REQUEST['parentID'] = $newxianlu['chanpinID'];
		$_REQUEST['type'] = '标准';
		if($jiage['chengrenzongjia'] == '' || $jiage['ertongzongjia'] == '')
		return;
		$_REQUEST['time'] = $xianlu['time'];
		$_REQUEST['adultprice'] = $jiage['chengrenzongjia'];
		$_REQUEST['title'] = $category['title'];
		$_REQUEST['openID'] = $category['systemID'];
		$_REQUEST['opentype'] = '分类';
		$_REQUEST['childprice'] = $jiage['ertongzongjia'];
		$_REQUEST['chengben'] = 0;
		$_REQUEST['cut'] = 0;
		$_REQUEST['renshu'] = $xianlu['renshu'];
		$data = $_REQUEST;
		$data['shoujia'] = $_REQUEST;
		if (false !== $Chanpin->relation("shoujia")->myRcreate($data)){
			//同步售价表线路状态
			A("Method")->_tongbushoujia($data['parentID']);
			if($Chanpin->getLastmodel() == 'add')
				$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			//生成开放OM	
			A('Method')->_shoujiaToDataOM($_REQUEST);
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
		$data['bumen_copy'] = $newxianlu['bumen_copy'];
		foreach($xingchengall as $v){
			$time = explode($v['time']);
			$data['xingcheng']['chanyin'] = serialize($time);
			$tools = explode($v['tools']);
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
		$data['bumen_copy'] = $newxianlu['bumen_copy'];
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
	
	
	
}
?>