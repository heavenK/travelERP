<?php

class SystemAction extends CommonAction{

    public function index() {
        $this->redirect('/Supplier/supplierlist/type/酒店');
    }
	


    public function companyinfo() {
		$navlist = "系统设置 > 系统设置 > 企业信息";
		$this->assign('navlist',$navlist);
		
		
		$username = $this->roleuser['user_name'];
		$Glkehu = D("Glkehu");
		$kehu = $Glkehu->where("`user_name` = '$username'")->find();
		$lvxingsheID = $kehu['lvxingsheID'];
		$Gllvxingshe = D('Gllvxingshe');
		$postdata = $Gllvxingshe->where("`lvxingsheID` = '$lvxingsheID'")->find();
		
		$this->assign('lvxingshe',$postdata);
		$this->display();
		
    }



    public function userlist() {
		
		$navlist = "系统设置 > 系统设置 > 用户列表";
		$this->assign('navlist',$navlist);
		
		$username = $this->roleuser['user_name'];
		$Glkehu = D("Glkehu");
		$kehu = $Glkehu->where("`user_name` = '$username'")->find();
		$kehuAll = $Glkehu->where("`lvxingsheID` = '$kehu[lvxingsheID]'")->order("time desc")->findall();
		$Gllvxingshe = D('Gllvxingshe');
		$lvxingshe = $Gllvxingshe->where("`lvxingsheID` = '$kehu[lvxingsheID]'")->find();
		
		$this->assign('lvxingshe',$lvxingshe);
		$this->assign('kehuAll',$kehuAll);
        $this->display();
		
    }



    public function dopsoteditcompany() {
		
		$Gllvxingshe = D('Gllvxingshe');
		foreach($_POST as $key => $value){
			if($key == 'forword')
			$forword = $value;
			else
			$postdata[$key] = $value;
		}
		$postdata['editusername'] = $this->admin['user_name'];
		$Gllvxingshe->save($postdata);
		doalert('修改成功',$forword);
		
		
    }


    public function editkehu() {
		$navlist = "系统设置 > 系统设置 > 修改用户";
		$this->assign('navlist',$navlist);
		
		$kehuID = $_GET['kehuID'];
		$Glkehu = D('Glkehu');
		$postdata = $Glkehu->where("`kehuID` = '$kehuID'")->find();
		
		$this->assign('postdata',$postdata);
        $this->display();
    }


    public function doposteditkehu() {
		
		$postdata = $_POST;
		$Glkehu = D('Glkehu');
		$kehu = $Glkehu->where("`kehuID` = '$postdata[kehuID]'")->find();
		
		$postdata['user_name'] = $kehu['user_name'];
		$postdata['editusername'] = $this->admin['user_name'];
		
		$Glkehu->save($postdata);
		$rurl = SITE_DIJIE."System/userlist";
		doalert('修改成功',$rurl);
    }


    public function powermanage() {
		$navlist = "系统设置 > 系统设置 > 权限设置";
		$this->assign('navlist',$navlist);
		
		$Glkehu = D('Glkehu');
		$kehu = $Glkehu->where("`user_name` = '$_GET[user_name]'")->find();
		$this->assign('kehu',$kehu);
		
		$Gladminuser = D('Gladminuser');
		$adminuser = $Gladminuser->where("`user_name` = '$kehu[user_name]'")->find();
		$this->assign('adminuser',$adminuser);
		$this->assign('adminpool',$adminuser['adminpool']);
		$appAll = $this->_getadminlist();
		$this->assign('appAll',$appAll);
        $this->display();
		
    }





	public function dopostSystemguanli()
	{
		$postdata = $_POST;	
		$Gladminuser = D('Gladminuser');
		$adminuser = $Gladminuser->where("`user_name` = '$postdata[user_name]'")->find();
		
		if(!$this->adminuser)
		{
			$rurl = SITE_DIJIE."System/userlist";
			doalert('powermanage错误',$rurl);
		}
		foreach($postdata['itemlist'] as $item){
			if($adminpool)
			$adminpool .= ','.$item;
			else
			$adminpool .= $item;
		}
		$adminuser['adminpool'] = $adminpool;
		$adminuser['edituser'] = $this->adminuser['user_name'];
		$Gladminuser = D('Gladminuser');
		$Gladminuser->save($adminuser);
		$rurl = SITE_DIJIE."System/powermanage/user_name/".$postdata[user_name];
		doalert('修改成功',$rurl);
	}
























	private function _getadminlist()
	{
		//产品管理-发布产品
		$methodlist = $actionlist = null;
		$methodlist = $this->_getmethodlist('ChanpinAction');
		$actionlist[0]['actiontitle'] = '国内-散客产品';
		$actionlist[0]['methodlist'] = $methodlist;
		
		$methodlist = 'Airticket,Airticket:index,Airticket:delete,Airticket:ticketPublish,Airticket:ticketDate,Airticket:ticketEdit,Airticket:ticketPrice,Airticket:agent_price,Airticket:ticketPrice,Airticket:send:wait_check';
		$actionlist[1]['actiontitle'] = '国内-机票';
		$actionlist[1]['methodlist'] = $methodlist;
		
		$methodlist = 'Hotel,Hotel:index,Hotel:edit,Hotel:add,Hotel:calendar,Hotel:modify,Hotel:send:wait_check';
		$actionlist[2]['actiontitle'] = '国内-酒店';
		$actionlist[2]['methodlist'] = $methodlist;
		
		$methodlist = $this->_getmethodlist('ZiyourenAction');
		$actionlist[3]['actiontitle'] = '国内-自由人';
		$actionlist[3]['methodlist'] = $methodlist;
		
		$exclist = 'Chanpin:sankechanpin,Chanpin:fabuxinxianlu';
		$methodlist = $this->_getmethodlistexcept('ChanpinAction',$exclist);
		$methodlist .= ',Chanpin:sankechanpin:jingwai,Chanpin:fabuxinxianlu:jingwai';
		$actionlist[4]['actiontitle'] = '境外-散客产品';
		$actionlist[4]['methodlist'] = $methodlist;
		
		$classlist[0]['classtitle'] = '发布产品';
		$classlist[0]['actionlist'] = $actionlist;
		
		//产品管理-产品审核
		$methodlist = $actionlist = null;
		$methodlist = 'Shenhe:sankechanpin,Shenhe:chanpinxinxi,Shenhe:shenhecaozuo,Shenhe:zituanjilu';
		$actionlist[0]['actiontitle'] = '国内-散客产品';
		$actionlist[0]['methodlist'] = $methodlist;
		
		$methodlist = 'Airticket:ticketCheck,Airticket:ticketDateShow,Airticket:ticketPriceShow,Airticket:send:success,Airticket:send:fail';
		$actionlist[1]['actiontitle'] = '国内-机票';
		$actionlist[1]['methodlist'] = $methodlist;
		
		$methodlist = 'Hotel:check,Hotel:calendar,Hotel:send:success,Hotel:send:fail';
		$actionlist[2]['actiontitle'] = '国内-酒店';
		$actionlist[2]['methodlist'] = $methodlist;
		
		$methodlist = 'Shenhe:ziyouren,Shenhe:ziyourenxinxi,Shenhe:shenhecaozuo,Shenhe:zituanjilu';
		$actionlist[3]['actiontitle'] = '国内-自由人';
		$actionlist[3]['methodlist'] = $methodlist;
		
		$methodlist = 'Shenhe:sankechanpin:jingwai';
		$methodlist .= ',Shenhe:chanpinxinxi,Shenhe:shenhecaozuo,Shenhe:zituanjilu';
		$actionlist[4]['actiontitle'] = '境外-散客产品';
		$actionlist[4]['methodlist'] = $methodlist;
		
		$classlist[1]['classtitle'] = '产品审核';
		$classlist[1]['actionlist'] = $actionlist;
		
		//产品管理-产品控管
		$methodlist = $actionlist = null;
		$exclist = 'Kongguan:ziyouren';
		$methodlist = $this->_getmethodlistexcept('KongguanAction',$exclist);
		$actionlist[0]['actiontitle'] = '国内-散客产品';
		$actionlist[0]['methodlist'] = $methodlist;
		
		$methodlist = 'Airticket:ticketControl,Airticket:delete,Airticket:ticketControlShow,Airticket:ticketPriceControlShow';
		$actionlist[1]['actiontitle'] = '国内-机票';
		$actionlist[1]['methodlist'] = $methodlist;
		
		$methodlist = 'Hotel:mange,Hotel:dingdan_info,Hotel:answer,Hotel:chang_info,Hotel:house';
		$actionlist[2]['actiontitle'] = '国内-酒店';
		$actionlist[2]['methodlist'] = $methodlist;
		
		$exclist = 'Kongguan:sankekongguan';
		$methodlist = $this->_getmethodlistexcept('KongguanAction',$exclist);
		$actionlist[3]['actiontitle'] = '国内-自由人';
		$actionlist[3]['methodlist'] = $methodlist;
		
		$exclist = 'Kongguan:sankekongguan,Kongguan:ziyouren';
		$methodlist = $this->_getmethodlistexcept('KongguanAction',$exclist);
		$methodlist .= ',Kongguan:sankekongguan:jingwai';
		$actionlist[4]['actiontitle'] = '境外-散客产品';
		$actionlist[4]['methodlist'] = $methodlist;
		
		$classlist[2]['classtitle'] = '产品控管';
		$classlist[2]['actionlist'] = $actionlist;
		
		//产品管理-订单控管
		$methodlist = $actionlist = null;
		$exclist = 'Dingdan:ziyourendingdan';
		$methodlist = $this->_getmethodlistexcept('DingdanAction',$exclist);
		$actionlist[0]['actiontitle'] = '国内-散客产品';
		$actionlist[0]['methodlist'] = $methodlist;
		
		$methodlist = 'Airticket:dingdan,Airticket:dingdan_info,Airticket:chang_info';
		$actionlist[1]['actiontitle'] = '国内-机票';
		$actionlist[1]['methodlist'] = $methodlist;
		
		$methodlist = 'Hotel:dingdan,Hotel:nouse,Hotel:dingdan_info,Hotel:chang_info';
		$actionlist[2]['actiontitle'] = '国内-酒店';
		$actionlist[2]['methodlist'] = $methodlist;
		
		$exclist = 'Dingdan:sankedingdan';
		$methodlist = $this->_getmethodlistexcept('DingdanAction',$exclist);
		$actionlist[3]['actiontitle'] = '国内-自由人';
		$actionlist[3]['methodlist'] = $methodlist;
		
		$exclist = 'Dingdan:sankedingdan,Dingdan:ziyourendingdan';
		$methodlist = $this->_getmethodlistexcept('DingdanAction',$exclist);
		$methodlist .= ',Dingdan:sankedingdan:jingwai';
		$actionlist[4]['actiontitle'] = '境外-散客产品';
		$actionlist[4]['methodlist'] = $methodlist;
		
		$classlist[3]['classtitle'] = '订单控管';
		$classlist[3]['actionlist'] = $actionlist;
		
		//产品管理-产品平移
		$methodlist = $actionlist = null;
		$methodlist = $this->_getmethodlist('ChanpinpingyiAction');
		$actionlist[0]['actiontitle'] = '产品平移-产品平移';
		$actionlist[0]['methodlist'] = $methodlist;
		
		$classlist[4]['classtitle'] = '产品平移';
		$classlist[4]['actionlist'] = $actionlist;
		
		$appAll[0]['menutitle'] = '产品管理';
		$appAll[0]['classlist'] = $classlist;
		
		
		//权限管理
		//权限管理-系统管理
		$methodlist = $actionlist = $classlist =null;
		$methodlist = $this->_getmethodlist('SystemguanliAction');
		$actionlist[0]['actiontitle'] = '权限管理所有权限';
		$actionlist[0]['methodlist'] = $methodlist;
		
		$classlist[0]['classtitle'] = '权限管理';
		$classlist[0]['actionlist'] = $actionlist;
		
		$appAll[1]['menutitle'] = '权限管理';
		$appAll[1]['classlist'] = $classlist;
		
		
		
		//客户管理
		//客户管理-代理管理
		$methodlist = $actionlist = $classlist =null;
		$exclist = 'Kehuguanli:kehulist';
		$methodlist = $this->_getmethodlistexcept('KehuguanliAction',$exclist);
		$actionlist[0]['actiontitle'] = '代理管理所有权限';
		$actionlist[0]['methodlist'] = $methodlist;
		
		$classlist[0]['classtitle'] = '代理管理';
		$classlist[0]['actionlist'] = $actionlist;
		
		//客户管理-客户管理
		$methodlist = $actionlist = null;
		$methodlist = 'Kehuguanli:kehulist';
		$actionlist[0]['actiontitle'] = '客户管理所有权限';
		$actionlist[0]['methodlist'] = $methodlist;
		
		$classlist[1]['classtitle'] = '客户管理';
		$classlist[1]['actionlist'] = $actionlist;
		
		$appAll[2]['menutitle'] = '客户管理';
		$appAll[2]['classlist'] = $classlist;
		
		
		//系统设置
		//系统设置-系统设置
		$methodlist = $actionlist = $classlist =null;
		$methodlist = $this->_getmethodlist('BasedataAction');
		$actionlist[0]['actiontitle'] = '系统设置所有权限';
		$actionlist[0]['methodlist'] = $methodlist;
		
		$classlist[0]['classtitle'] = '系统设置';
		$classlist[0]['actionlist'] = $actionlist;
		
		$appAll[3]['menutitle'] = '系统设置';
		$appAll[3]['classlist'] = $classlist;
		
		
		
		
		
		return $appAll;
	}
	


	//获得所有
	private function _getmethodlist($classname)
	{
		//获得类名
		//$b = get_class ();
		//获得动作名列表
		
		$c = str_replace ('Action','',$classname);
		$acitonAll = get_class_methods($classname);
		
		foreach($acitonAll as $action){
			if($methodlist)
				$methodlist .= ','.$c.':'.$action;
			else
				$methodlist .= $c.':'.$action;
		}
		
		return $methodlist;
		
	}
	


	//获得所有，不包括参数2
	private function _getmethodlistexcept($classname,$exceptlist)
	{
		$c = str_replace ('Action','',$classname);
		$acitonAll = get_class_methods($classname);
		
		foreach($acitonAll as $action){
			if($methodlist)
				$methodlist .= ','.$c.':'.$action;
			else
				$methodlist .= $c.':'.$action;
		}
		
		$methodlist = str_replace (','.$exceptlist,'',$methodlist);
		
//		dump($exceptlist);
//		exit;
		return $methodlist;
		
	}
	

    public function rmbtoother() {
		
		$navlist = "系统设置 > 系统设置 > 汇率兑换";
		$this->assign('navlist',$navlist);
		
		$dj_resource = D('dj_resource');
		$huilvAll = $dj_resource->where("`type` = '汇率'")->findall();
		$this->assign('huilvAll',$huilvAll);
		
        $this->display();
    }
	
    public function dopostrmbtoother() {
		
		foreach($_POST as $key => $value)
		{
			$data[$key] = $value;
		}
		
		$dj_resource = D('dj_resource');
		if(!$data['resourceID'])
		{
				$data['time'] = time();
				$data['type'] = '汇率';
				$data['adduser'] = $this->roleuser['user_name'];
				$data['edituser'] = $this->roleuser['user_name'];
				$id = $dj_resource->add($data);
				
			echo $id;
		}
		else
		{
				$data['edituser'] = $this->roleuser['user_name'];
				$dj_resource->save($data);
		
			echo 'true';
		}
    }
	


	
	
	
    public function deletestrmbtoother() {
		
		$resourceID = $_POST['resourceID'];
		
		$dj_resource = D('dj_resource');
		
		$huilv = $dj_resource->where("`resourceID` = '$resourceID'")->find();
		if($huilv){
			$dj_resource->where("`resourceID` = '$resourceID'")->delete();
			echo "true";
		}
		else
		{
			echo "false";
		}	
	
	}
	
	


}
?>