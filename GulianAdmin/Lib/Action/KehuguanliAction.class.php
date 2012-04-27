<?php

class KehuguanliAction extends CommonAction{

    public function menshiguanli() {
		
		$Gllvxingshe = D('Gllvxingshe');
		$type = $_POST['type'];
		
		$wheres = '';
		if (!empty($type)){
			$keyword = $_POST['tbKeyword'];
			if ($keyword){
				$wheres['_string'] = "companyname like '%".$keyword."%' OR lianxiren like '%".$keyword."%' OR officetel like '%".$keyword."%'";
			}
		}
		if($_GET['type'] == '门市')
		$wheres['type'] = '门市';
		if($_GET['type'] == '同业')
		$wheres['type'] = '同业';
		if($_GET['type'] == '办事处')
		$wheres['type'] = '办事处';
		$this->assign('kehutype',$_GET['type']);
		$companyAll = $Gllvxingshe->where($wheres)->order("time desc")->findall();
		$i = 0;
		foreach($companyAll as $v)
		{
			$belong = $Gllvxingshe->where("`lvxingsheID` = '$v[belongID]'")->find();
			$companyAll[$i]['belong'] =$belong['companyname'];
			$i++;
		}
		
		
		$this->assign('companyAll',$companyAll);
		$this->assign('guanli_type','menshiguanli');
		
        $this->display();
    }


    public function addmenshi() {
		$Gllvxingshe = D('Gllvxingshe');
		$AC_all = $Gllvxingshe->where("`admintype` = '系统'")->order("time desc")->findall();
		$this->assign('AC_all',$AC_all);
		if($_GET['type'] == '门市')
			$this->assign('kehutype','门市');
		elseif($_GET['type'] == '同业')
			$this->assign('kehutype','同业');
		elseif($_GET['type'] == '办事处')
			$this->assign('kehutype','办事处');
		else
			doalert("错误",'/');
		$lvxingsheID = $_GET['lvxingsheID'];
		if($lvxingsheID)
		{
			$Gllvxingshe = D('Gllvxingshe');
			$postdata = $Gllvxingshe->where("`lvxingsheID` = '$lvxingsheID'")->find();
			$belong = $Gllvxingshe->where("`lvxingsheID` = '$postdata[belongID]'")->find();
			$postdata['belong'] =$belong['companyname'];
			$kehutype = $postdata['type'];
			$this->assign('kehutype',$kehutype);
			$this->assign('postdata',$postdata);
		}
		
        $this->display();
    }



    public function dopostaddmenshi() {
		$Gllvxingshe = D('Gllvxingshe');
		$postdata = $_POST;
		$rurl = SITE_ADMIN."Kehuguanli/menshiguanli/type/".$postdata['kehutype'];
		
		if($postdata['lvxingsheID']){
			$postdata['editusername'] = $this->roleuser['user_name'];
			$Gllvxingshe->save($postdata);
		}
		else
		{
			$theone = $Gllvxingshe->where("`companyname` = '$postdata[companyname]'")->find();
			if(!$postdata['companyname'] || $theone)
			{
				doalert('公司名称已经存在',$rurl);
			}
			
			$postdata['addusername'] = $this->roleuser['user_name'];
			$postdata['editusername'] = $this->roleuser['user_name'];
			$postdata['admintype'] = "隶属";
			$postdata['time'] = time();
			$postdata['user_id'] = $regid;
			$Gllvxingshe->add($postdata);
		
		}
		
		
		doalert('完成',$rurl);
    }


    public function editkehu() {
		
		$kehuID = $_GET['kehuID'];
		
		$Glkehu = D('Glkehu');
		$postdata = $Glkehu->where("`kehuID` = '$kehuID'")->find();
		
		$Gllvxingshe = D('Gllvxingshe');
		$lvxingsheAll = $Gllvxingshe->order("time desc")->findall();
		$this->assign('lvxingsheAll',$lvxingsheAll);
		
		$this->assign('kehutype',$postdata['kehutype']);
		$this->assign('postdata',$postdata);
        $this->display();
    }


    public function doposteditkehu() {
		
		$postdata = $_POST;
		$Glkehu = D('Glkehu');
		$kehu = $Glkehu->where("`kehuID` = '$postdata[kehuID]'")->find();
		
		$postdata['user_name'] = $kehu['user_name'];
		$postdata['editusername'] = $this->roleuser['user_name'];
		$rurl = SITE_ADMIN."Kehuguanli/editkehu/kehuID/".$postdata['kehuID'];
    }

    public function userguanli() {
		
		$Glkehu = D('Glkehu');
		
		$type = $_POST['type'];
		$wheres = '';
		if (!empty($type)){
			$keyword = $_POST['tbKeyword'];
			if ($keyword){
				$wheres['_string'] = "user_name like '%".$keyword."%' OR realname like '%".$keyword."%' OR department like '%".$keyword."%'";
			}
		}
		
		$kehuAll = $Glkehu->where($wheres)->order("time desc")->findall();
		
		$Gllvxingshe = D('Gllvxingshe');
		$lvxingshe = $Gllvxingshe->where("`lvxingsheID` = '1'")->find();
		
		$this->assign('lvxingshe',$lvxingshe);
		$this->assign('kehuAll',$kehuAll);
        $this->display();
    }



    public function kehulist() {
		$navlist = '客户管理 > 客户列表';
		$this->assign('navlist',$navlist);
		
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			continue;
			
			if($key == 'dingdanbianhao'){
				if(!$_GET['usertype']){
					justalert('请选订单类型后搜索订单编号');
				}
				if($_GET['usertype'] == '订团')
					$condition['bianhao'] = array('like','%'.$value.'%');
				if($_GET['usertype'] == '订房' || $_GET['usertype'] == '订票')
					$condition['sid'] = array('like','%'.$value.'%');
					
				$this->assign($key,$value);
				continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		$tuanyuan_dingdan = D('tuanyuan_dingdan');
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $tuanyuan_dingdan->where($condition)->count();
		$p= new Page($count,20);
		//$rurl = SITE_ADMIN."Kehuguanli/kehulist/p/";
		
//		foreach ( $_POST as $key => $val ) {   
//		   $p->parameter .= "/$key/" . $val; 
//		} 
//		
		$page = $p->show();
        $kehuAll = $tuanyuan_dingdan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		//处理
		$i = 0;
		foreach($kehuAll as $kehu){
			if($kehu['chushengriqi']){
			$age = time()- strtotime($kehu['chushengriqi']);
			$age = $age/(60 * 60 * 24 * 265) + 1;
			$kehuAll[$i]['age'] = (int)$age;
			}
			$i++;
		}
		
		$this->assign('page',$page);
		$this->assign('kehuAll',$kehuAll);
        $this->display();
    }


	public function deletecompany()
	{
		
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		if($item['itemlist'] == null){
			doalert('没有选择','');
		}
		else
		{
			foreach($item['itemlist'] as $ID){
				$gllvxingshe = D('gllvxingshe');
				$gllvxingshe->where("`lvxingsheID` = '$ID'")->delete();
			}
		}
		doalert('删除成功'.$_GET['type'],'');
	}




	public function departmentlist()
	{
		$navlist = '系统设置 > 公司架构 > '.$_GET['type'];
		$this->assign('navlist',$navlist);
		$this->assign('type',$_GET['type']);
		
		$condition['type'] = $_GET['type'];
		
		$glbasedata = D("glbasedata");
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		$count = $glbasedata->where($condition)->count();
		$p = new Page ( $count, 30 ); 
		$datalist=$glbasedata->limit($p->firstRow.','.$p->listRows)->where($condition)->order('pubdate desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Kehuguanli/departmentlist/type/'.$condition['type'].'/p/');
        $this->assign ( "page", $page );
        $this->assign ( "datalist", $datalist );
		
		
        $this->display();
	}


	public function adddepartment()
	{
		$navlist = '系统设置 > 公司架构 > '.$_GET['type'];
		$this->assign('navlist',$navlist);
		$this->assign('type',$_GET['type']);
		$id = $_GET['id'];
		if($id){
			$glbasedata = D("glbasedata");
			$olddata = $glbasedata->where("`id` = '$id'")->find();
			$this->assign ( "data", $olddata );
			$this->assign ( "type", $olddata['type'] );
		}
		
        $this->display();
	}


	public function dopostadddepartment()
	{
		foreach($_POST as $key => $value){
			$data[$key] = $value;
		}
		$glbasedata = D("glbasedata");
		if($data['id']){
			$data['edituser'] = $this->roleuser['user_name'];
			$olddata = $glbasedata->where("`id` = '$data[id]'")->find();
			if($olddata){
				$glbasedata->save($data);
			}
		}
		else{
			$data['pubdate'] = time();
			$data['adduser'] = $this->roleuser['user_name'];
			$data['edituser'] = $this->roleuser['user_name'];
			
			$glbasedata->add($data);
		}
	
		doalert('添加成功',SITE_ADMIN.'Kehuguanli/departmentlist/type/'.$data['type']);
	}


	public function deletedepartment()
	{
		$id = $_GET['id'];
		if($id){
			$glbasedata = D("glbasedata");
			$data = $glbasedata->where("`id` = '$id'")->find();
			$glbasedata->where("`id` = '$id'")->delete();
		}
		doalert('删除成功','');
	}






















}
?>