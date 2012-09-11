<?php

class FormeAction extends Action{
	
	//线路
    public function chanpinxianlu() {
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$gl_xianlu=M("glxianlu");
		$glxianlu_ext=M("glxianlu_ext");
		$xianluAll = $gl_xianlu->order('time DESC')->limit(1)->findall();
		$Chanpin=D("Chanpin");
		$gl_baozhang=M("gl_baozhang");
		foreach($xianluAll as $v)
		{
			$dat = $v;
			$dat['xianlu'] = $v;
			$dat['status'] = $v['zhuangtai'];
			$dat['xianlu']['title'] = $v['mingcheng'];
			//部门
			$this->_getnewbumenID($v['departmentName']);
			$dat['bumen_copy'] = $v['title'];
			//审核时间
			if($v['zhuangtai'] == '报名' || $v['zhuangtai'] == '截止'){
				$dat['islock'] = '已锁定';
				$dat['shenhe_time'] = $v['time'];
				$dat['shenhe_remark'] = '已审核';
			}
			else
				$dat['status'] = '准备';
			//境外团
			$ext = $glxianlu_ext->where("`xianluID` = '$v[xianluID]'")->find();
			$dat['xianlu']['xianlu_ext'] = serialize($ext);		
			if (false !== $Chanpin->relation("xianlu")->myRcreate($dat)){
				$xianluID = $Chanpin->getRelationID();
				$dat['chanpinID'] = $xianluID;
				$dataOMlist = A("Method")->_setDataOMlist('计调','组团');
				A("Method")->_createDataOM($xianluID,'线路','管理',$dataOMlist);
				//zituan
				$this->_zituan_build($v,$dat,$dataOMlist);
				
				
			}
			
			
			
			//message
//			$this->chanpinxiaoxi($v,$chanpinID);
//			//xingcheng
//			$this->xingcheng($v,$chanpinID);
//			//chengben shoujia
//			$this->chengbenshoujia($v,$chanpinID);
			//exit;
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
	
	//获得用户名获得旧部门ID
	function _getoldbumenbyusername($user_name){
		$roleuser = M('Glkehu')->where("`user_id`='$user_id'")->find();
		$mydepartment = M('glbasedata')->where("`id`='$roleuser[department]'")->find();
		return $mydepartment;
	}
	
	//获得新用户ID根据用户名
	function _getuserIDbytitle($user_name){
		$ViewUser = D("ViewUser");
		$user = $ViewUser->where("`user_name` = '$user_name'")->find();
		return $user['systemID'];
	}
	
	
	
	
    public function fillSystemAll() {
	
 		$this->filldepartment();
		$this->fillrole();
		$this->filluser();
	
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
		$jihua = $gljiedaijihua->whre("`xianluID` = '$xianlu[xianluID]' and `jiedaitype` = '接待计划'")->find();
		$tongzhi = $gljiedaijihua->whre("`xianluID` = '$xianlu[xianluID]' and `jiedaitype` = '出团通知'")->find();
		$gl_baozhang=M("gl_baozhang");
		foreach($zituanAll as $v){
			$dat = $v;
			$dat['zituan'] = $v;
			$dat['parentID'] = $newxianlu['chanpinID'];
			//计算出团日期，重置子团状态
			if($v['zhuangtai'] == '报名' || $v['zhuangtai'] == '准备' ||$v['zhuangtai'] == '截止'){
				if(strtotime($v['chutuanriqi']) < time()){
					$dat['islock'] = '已锁定';
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
			$dat['zituan']['title_copy'] = $newxianlu['title'];
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
					$dat['zituan']['baozhangtime'] =  $baozhang['caiwu_time'];
				}
			}
			if(false !== $Chanpin->relation("zituan")->myRcreate($dat)){
				$zituanID = $Chanpin->getRelationID();
				$dat['chanpinID'] = $zituanID;
				A("Method")->_createDataOM($zituanID,'子团','管理',$dataOMlist);
				
				//生成报账单----------------------
				$this->_baozhangdan_build($dat,$dataOMlist);
				//生成随团单项服务报账单----------------------
				$this->_danxiangfuwu_build($v,$dataOMlist);
				//生成订单----------------------
				$this->_dingdan_build($v,$dataOMlist);
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
	public function _baozhangdan_build($zituan,$dataOMlist)
	{
		$Chanpin = D("Chanpin");
		$gl_baozhang=M("gl_baozhang");
		$gl_baozhangitem=M("gl_baozhangitem");
		$baozhang = $gl_baozhang->where("`zituanID` = '$zituan[zituanID]'")->find();
		$bzd = $baozhang;
		$bzd["baozhang"] = $baozhang;
		$bzd["baozhang"]['title'] = $zituan['title'].'/'.$zituan['chutuanriqi'].'团队报账单';
		$bzd['parentID'] = $zituan['chanpinID'];
		$dat['user_name'] =  $zituan['user_name'];
		$dat['departmentID'] =  $zituan['departmentID'];
		$dat['bumen_copy'] = $zituan['bumen_copy'];
		if($baozhang){
			$temprenshu = preg_replace("/[" . chr(0xa0). "-" .chr(0xfe) . "]+/", "", $baozhang["baozhang"]['renshu']);//过滤汉字
			$bzd["baozhang"]['renshu'] = preg_replace('/[\.a-zA-Z]/s','',$temprenshu); //过滤字母
			$renshulist = explode('+',$bzd["baozhang"]['renshu']);
			foreach($renshulist as $rs){
				$renshu += (int)$rs;
			}
			$bzd["baozhang"]['renshu'] = $renshu;
			$bzd["baozhang"]['type'] = '团队报账单';
			//审核状态
			if($baozhang['status'] == '财务总监通过' || $baozhang['status'] == '财务通过' || $baozhang['status'] == '总经理通过'){
				$bzd['status_shenhe'] = '批准';
				$bzd['shenhe_remark'] = $baozhang['status'];
				$bzd['shenhe_time'] =  $baozhang['caiwu_time'];
			}
			//计算报账项
			$baozhangitemall = $gl_baozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and 'check_status' = '审核通过'")->findall();
			foreach($baozhangitemall as $v){
				if($v['type'] == '结算项目')
				$bzd["baozhang"]['yingshou_copy'] += $v['price'];
				if($v['type'] == '支出项目')
				$bzd["baozhang"]['yingfu_copy'] += $v['price'];
			}
		}
		if(false !== $Chanpin->relation("baozhang")->myRcreate($bzd)){
			$baozhangID = $Chanpin->getRelationID();
			$bzd['chanpinID'] = $baozhangID;
			A("Method")->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
		
			//生成审核任务？
			if($baozhang){
				$this->_taskshenhe_build($baozhang,$bzd,'团队报账单');
			}
			
			//生成报账项-----------------------
			foreach($baozhangitemall as $v){
				$bzditem = $v;
				$bzditem['baozhangitem'] = $v;
				$bzditem['parentID'] = $baozhangID;
				$bzditem['user_name'] = $baozhang['user_name'];
				$bzditem['departmentID'] = $baozhang['departmentID'];
				$bzditem['bumen_copy'] = $baozhang['bumen_copy'];
				$bzditem['baozhangitem']['value'] = $v['price'];
				$bzditem['baozhangitem']['method'] = $v['pricetype'];
				//审核状态
				if($item['check_status'] == '审核通过'){
					$bzditem['status_shenhe'] = '批准';
					$bzditem['shenhe_remark'] = $v['check_status'];
					$bzditem['shenhe_time'] =  $v['check_time'];
				}
				if(false !== $Chanpin->relation("baozhangitem")->myRcreate($bzditem)){
					$baozhangitemID = $Chanpin->getRelationID();
					A("Method")->_createDataOM($baozhangitemID,'报账项','管理',$dataOMlist);
				} 
			}
		}
	
	
	
	}
	
	
	
	//生成随团单项服务----------------------
	public function _danxiangfuwu_build($zituan,$dataOMlist)
	{
		$zituanID = $zituan['zituanID'];
		$Chanpin = D("Chanpin");
		$glqianzheng=M("glqianzheng");
		$glqianzhengitem=M("glqianzhengitem");
				$dxfwall = $glqianzheng->where("`zituanID` = '$zituanID'")->findall();
				foreach($dxfwall as $dxfw){
					$bzd = $dxfw;
					$bzd['baozhang'] = $dxfw;
					$bzd['baozhang']['title'] = $dxfw['title'].'/'.$dxfw['title_ext'];
					if($dxfw['type'] == '机票' ||$dxfw['type'] == '订车'){
						$dxfw['type'] = '交通';
						$bzd['baozhang']['type'] = '交通';
						$bzd['baozhang']['datatext']['hangbanhao'] = $dxfw['title_ext'];
						$bzd['baozhang']['datatext']['shifadi'] = $dxfw['start_addr'];
						$bzd['baozhang']['datatext']['mudidi'] = $dxfw['end_addr'];
						$bzd['baozhang']['datatext']['leavetime'] = $dxfw['leavetime'];
						$bzd['baozhang']['datatext']['arrvietime'] = $dxfw['arrivetime'];
					}
					if($dxfw['type'] == '订导游'){
						$dxfw['type'] = '导游';
						$bzd['baozhang']['type'] = '导游';
					}
					if($dxfw['type'] == '订房'){
						$bzd['baozhang']['datatext']['hotel'] = $dxfw['title_ext'];
						$bzd['baozhang']['datatext']['hoteltelnum'] = $dxfw['quanchengpeitong'];
						$bzd['baozhang']['datatext']['ordertime'] = $dxfw['arrivetime'];
						$bzd['baozhang']['datatext']['jiesuantime'] = $dxfw['leavetime'];
					}
					if($dxfw['type'] == '餐饮' || $dxfw['type'] == '门票' || $dxfw['type'] == '订导游'){
						$bzd['baozhang']['datatext']['telnum'] = $dxfw['quanchengpeitong'];
						$bzd['baozhang']['datatext']['ordertime'] = $dxfw['arrivetime'];
						$bzd['baozhang']['datatext']['jiesuantime'] = $dxfw['leavetime'];
					}
					//备注
					if($dxfw['tianshu'])
					$remark .= '天数:'.$dxfw['tianshu'];
					if($dxfw['quanchengpeitong'])
					$remark .= '接收单位:'.$dxfw['quanchengpeitong'];
					if($dxfw['buhuanhui'])
					$remark .= '不换汇人员:'.$dxfw['buhuanhui'];
					if($dxfw['yinsihuzhao'])
					$remark .= '因私护照:'.$dxfw['yinsihuzhao'];
					if($dxfw['bufancheng'])
					$remark .= '不返程:'.$dxfw['bufancheng'];
					if($dxfw['waidihukou'])
					$remark .= '外地户口:'.$dxfw['waidihukou'];
					if($dxfw['other'])
					$remark .= '其他:'.$dxfw['other'];
					$bzd['baozhang']['datatext']['remark'] = $remark;
					$bzd['baozhang']['datatext'] = serialize($bzd['baozhang']['datatext']);
					//审核状态
					if($dxfw['status'] == '财务总监通过' || $dxfw['status'] == '财务通过' || $dxfw['status'] == '总经理通过'){
						$bzd['status_shenhe'] = '批准';
						$bzd['shenhe_remark'] = $dxfw['status'];
						$bzd['shenhe_time'] =  $dxfw['check_time'];
					}
					//计算报账项
					$baozhangitemall = $glqianzhengitem->where("`qianzhengID` = '$dxfw[qianzhengID]' and 'status' == '财务通过'")->findall();
					foreach($baozhangitemall as $item){
						if($item['type'] == '应收费用')
						$bzd["baozhang"]['yingshou_copy'] += $item['value'];
						if($item['type'] == '费用明细')
						$bzd["baozhang"]['yingfu_copy'] += $item['value'];
					}
					$bzd['user_name'] =  $dxfw['username'];
					if(false !== $Chanpin->relation("baozhang")->myRcreate($bzd)){
						$baozhangID = $Chanpin->getRelationID();
						A("Method")->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
						//生成随团服务报账项-----------------------
						foreach($baozhangitemall as $item){
							$bzditem = $item;
							$bzditem['baozhangitem'] = $item;
							$bzditem['parentID'] = $baozhangID;
							$bzditem['baozhangitem']['value'] = $item['price'];
							$bzditem['baozhangitem']['method'] = '现金';
							if($item['type'] == '应收费用')
								$bzditem['baozhangitem']['type'] = '结算项目';
							if($item['type'] == '费用明细')
								$bzditem['baozhangitem']['type'] = '支出项目';
							if($item['type'] == '部门利润')
								$bzditem['baozhangitem']['type'] = '利润';
							//审核状态
							if($item['status'] == '审核通过'){
								$bzditem['islock'] = '批准';
								$bzditem['status_shenhe'] = '已锁定';
								$bzditem['shenhe_remark'] = $item['status'];
								$bzditem['shenhe_time'] =  $item['time'];
							}
							if(false !== $Chanpin->relation("baozhangitem")->myRcreate($bzditem)){
								$baozhangitemID = $Chanpin->getRelationID();
								A("Method")->_createDataOM($baozhangitemID,'报账项','管理',$dataOMlist);
							} 
						}
					}
				}
	}
	
	
	
	
	
	
	//生成订单----------------------
	public function _dingdan_build($zituan,$dataOMlist)
	{
		$Chanpin = D("Chanpin");
		$gldingdan = M("gldingdan");
		$dingdanall = $gldingdan->where("`zituanID` = '$zituan[zituanID]'")->findall();
		foreach($dingdanall as $v){
			$data = $v;
			$data['parentID'] = $zituan['zituanID'];
			$data['dingdan'] = $v;
			$data['dingdan']['title'] = $v['mingcheng'].'/'.$v['chutuanriqi'];
			$data['dingdan']['remark'] = $v['xuqiu'];
			$data['dingdan']['fuzebumenID'] = $zituan['departmentID'];
			$data['status'] = $v['zhuangtai'];
			//订单状态
			if($v['zhuangtai'] == '截止')
				$data['status'] = '确认';
			if($v['check_status'] == '审核通过'){
				$data['status'] = '确认';
			}
			if(false !== $Chanpin->relation("dingdan")->myRcreate($data)){
				$dingdanID = $Chanpin->getRelationID();
				A("Method")->_createDataOM($dingdanID,'订单','管理',$dataOMlist);
			}
		}
	}
	
	
	
	
	//生成审核任务----------------------
	public function _taskshenhe_build($baozhang,$newbaozhang,$type)
	{
		$System = D("System");
		if($type == '团队报账单'){
			if($baozhang['caozuoren']){
				$task['time'] = $baozhang['time'];
				$task['status'] = '申请';
				$task['user_name'] = $baozhang['caozuoren'];
				$task['taskshenhe']['processID'] = 1;
				$task['taskshenhe']['dataID'] = $newbaozhang['chanpinID'];
				$task['taskshenhe']['datatype'] = '线路';
				$task['taskshenhe']['remark'] = '计调申请';
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
			dump($Message);exit;	
				
			}
		}
		echo "结束";
		return true;
		
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>