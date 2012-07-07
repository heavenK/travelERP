<?php

class FormeAction extends Action{
	//产品相关
    public function chanpinxianlu() {
		echo "开始";
		echo "<br>";
		
		$gl_xianlu=D("glxianlu");
		$xianluAll = $gl_xianlu->order('time DESC')->limit(20)->findall();
//		$xianluAll = $gl_xianlu->where("`xianluID` = '278'")->findall();
		$myerp_chanpin=D("myerp_chanpin");
		$myerp_chanpin_xianlu=D("myerp_chanpin_xianlu");
		//线路
		foreach($xianluAll as $v)
		{
			//chanpin
			$dat = $v;
			$dat['status'] = $v['zhuangtai'];
			$chanpinID = $myerp_chanpin->add($dat);
			//chanpin_xianlu
			$dat = $v;
			$dat['chanpinID'] = $chanpinID;
			$dat['keyword'] = $v['guanjianzi'];
			$dat['title'] = $v['mingcheng'];
			$myerp_chanpin_xianlu->add($dat);
			//message
			$this->chanpinxiaoxi($v,$chanpinID);
			//xingcheng
			$this->xingcheng($v,$chanpinID);
			//chanpin  zituan
			$this->zituan($v,$chanpinID);
			//chengben shoujia
			$this->chengbenshoujia($v,$chanpinID);
			//exit;
		}
		
		echo "结束";
		
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
		$myerp_message=M("myerp_message");
		$message = $glmessage->where("`tableID` = '$v[xianluID]' and `tablename` = '线路'")->findall();
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
		$myerp_chanpin_xingcheng=M("myerp_chanpin_xingcheng");
		//线路
		foreach($xingchengAll as $v)
		{
			$dat = $v;
			$dat['chanpinID'] = $chanpinID;
			$dat['chanyin'] = $v['time'];
			$myerp_chanpin_xingcheng->add($dat);
		}
		
    }
	
    private function zituan($v,$chanpinID) {
		$myerp_chanpin_zituan=M("myerp_chanpin_zituan");
		$myerp_chanpin=M("myerp_chanpin");
		$glzituan=M("glzituan");
		$zituanAll = $glzituan->where("`xianluID` = '$v[xianluID]'")->findall();
		
		foreach($zituanAll as $v)
		{
			//chanpin
			$dat = $v;
			$dat['parentID'] = $chanpinID;
			$dat['status'] = $v['zhuangtai'];
			$zituanchanpinID = $myerp_chanpin->add($dat);
			//zituan
			$dat = $v;
			$dat['chanpinID'] = $zituanchanpinID;
			$myerp_chanpin_zituan->add($dat);
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
		$xl = $Xianlu->where("`ChanpinID` = '$chanpinID'")->find();
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
	
	
	
	
	
	
}
?>