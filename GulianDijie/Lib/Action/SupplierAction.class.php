<?php

class SupplierAction extends CommonAction{

    public function index() {
        $this->redirect('/Supplier/supplierlist/type/酒店');
    }
	
	
	
	public function supplierlist() {
	
		$navlist = "供应商 > 供应商 > ".$_GET['type'];
		$this->assign('navlist',$navlist);
	
		$dj_resource = D('dj_resource');
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		if($_GET['type'])
			$condition['type'] = $_GET['type'];
		
		$count = $dj_resource->where($condition)->count();
		$p = new Page ( $count, 10 ); 
		$list=$dj_resource->where($condition)->limit($p->firstRow.','.$p->listRows)->order('time desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_DIJIE.'Supplier/hotellist/p/');

        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
		if($_GET['type'] == '酒店')
			$this->display('hotellist'); 
		if($_GET['type'] == '用车')
			$this->display('trafficlist'); 
		if($_GET['type'] == '飞机')
			$this->display('airlist'); 
		if($_GET['type'] == '轮船')
			$this->display('shiplist'); 
		if($_GET['type'] == '火车')
			$this->display('trainlist'); 
		if($_GET['type'] == '餐饮')
			$this->display('restaurantlist'); 
		if($_GET['type'] == '门票')
			$this->display('ticketlist'); 
		if($_GET['type'] == '导游')
			$this->display('daoyoulist'); 
		if($_GET['type'] == '购物')
			$this->display('shoppinglist'); 
		if($_GET['type'] == '其他')
			$this->display('otherlist'); 
		if($_GET['type'] == '工具')
			$this->display('traffic_tools'); 
    }
	
	
	
	public function addresource() {
	
		$navlist = "供应商 > 供应商 > 添加".$_GET['type'];
		$this->assign('navlist',$navlist);
	
		$resourceID = $_GET['resourceID'];
		if($resourceID != null){
			$dj_resource = D('dj_resource');
			$resource = $dj_resource->where("`resourceID` = '$resourceID'")->find();
			$this->assign('resource',$resource);
		}
	
		if($_GET['type'] == '酒店')
			$this->display('add_hotel'); 
		if($_GET['type'] == '用车')
			$this->display('add_car'); 
		if($_GET['type'] == '飞机')
			$this->display('add_air'); 
		if($_GET['type'] == '轮船')
			$this->display('add_ship'); 
		if($_GET['type'] == '火车')
			$this->display('add_train'); 
		if($_GET['type'] == '餐饮')
			$this->display('add_restaurant'); 
		if($_GET['type'] == '门票')
			$this->display('add_ticket'); 
		if($_GET['type'] == '导游')
			$this->display('add_daoyou'); 
		if($_GET['type'] == '购物')
			$this->display('add_shopping'); 
		if($_GET['type'] == '其他')
			$this->display('add_other'); 
		if($_GET['type'] == '工具')
			$this->display('add_tools'); 
	}
	
	
	public function dopostaddresource() {
	
		$dj_resource = D('dj_resource');
		
		foreach($_POST as $key => $value){
			if($key == 'forword')
			$forword = $value;
			else
			$postdata[$key] = $value;
		}
		if(!$forword)
			$forword = SITE_DIJIE."Supplier/supplierlist/type/酒店";
			
		if($postdata['resourceID']){
			$recode = $dj_resource->where("`resourceID` = '$postdata[resourceID]'")->find();
			if(!$recode)
				doalert('错误',$forword);
		}
		foreach($_FILES as $key => $value){
			$uplod = _dofileuplod('files');
			if($_FILES[$key]['name'] && $uplod != null){
			$postdata['pic_url'] = $uplod;
			if($recode)
				unlink('data/'.$recode['pic_url']);
				
			}
			elseif($_FILES[$key]['name'] && $uplod == null)
			doalert('副本上传失败',$forword);
		}
		$postdata['edituser'] = $this->roleuser['user_name'];
		if($postdata['resourceID']){
			$dj_resource->save($postdata);
			doalert('成功',$forword);
		}
		else{
			$postdata['time'] = time();
			$postdata['adduser'] = $this->roleuser['user_name'];
			$newid = $dj_resource->add($postdata);
			if($newid)
			doalert('成功',$forword);
			else
			doalert('失败',$forword);
		}
	}
	
	public function ajax_add() {
	
		$dj_resource = D('dj_resource');
		
		$postdata['type'] = $_POST['type'];
		$postdata['title'] = $_POST['title'];
		$postdata['time'] = time();
		$postdata['adduser'] = $this->roleuser['user_name'];
		$newid = $dj_resource->add($postdata);
		if($newid)
			echo $newid;
		else
			echo "false";
		
	}
	
	public function getresource(){
		$own = $_REQUEST['own'];
		$ids = $_REQUEST['ids'];
		
		$idname = $_REQUEST['idname'];
		$idid = $_REQUEST['idid'];
		
		$this->assign('idid',$idid); 
		$this->assign('idname',$idname); 
		$this->assign('own',$own);
		$this->assign('ids',$ids);
		
		$type = $_GET['type'];
		$this->assign('type',$type); 
		
		
//		$Glkehu = D('Gllvxingshe');
//		
//		if ($idname == 'AgentName2') $wheres['isagent'] = '是';
//		if ($idname == 'CompanyName3') $wheres['type'] = '同业';
//		
//		$agents = $Glkehu->where($wheres)->findAll();
//		
//		$isduoxuan = $_REQUEST['isduoxuan'];
//		if(!$isduoxuan)
//		$this->assign('isduoxuan',1); 
		
		$djresource = D('dj_resource');
		$resourceAll = $djresource->where("type = '$type'")->order('resourceID DESC')->findall();
		$this->assign('resourceAll',$resourceAll); 
		
		$this->display();
	}
	
	
	
		

	
}
?>