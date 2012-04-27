<?php

class CompanyAction extends CommonAction{

    public function index() {
        $this->redirect('/Company/companylist');
    }
	

    public function companylist() {
        
		$navlist = "客户管理 > 客户管理 > 旅行社列表";
		$this->assign('navlist',$navlist);
		
		$Gllvxingshe = D('Gllvxingshe');
		$type = $_POST['type'];
		$wheres = '';
		if (!empty($type)){
			$keyword = $_POST['tbKeyword'];
			if ($keyword){
				$wheres['_string'] = "companyname like '%".$keyword."%' OR lianxiren like '%".$keyword."%' OR officetel like '%".$keyword."%'";
			}
		}
		$wheres['admintype'] = '客户';
		$kehuAll = $Gllvxingshe->where($wheres)->order("time desc")->findall();
		$this->assign('kehuAll',$kehuAll);
        $this->display();
		
    }
	

    public function addcompany() {
		
		if($_GET['lvxingsheID']){
			$lvxingsheID = $_GET['lvxingsheID'];
			$Gllvxingshe = D('Gllvxingshe');
			$lvxingshe = $Gllvxingshe->where("`lvxingsheID` = '$lvxingsheID'")->find();
			$this->assign('lvxingshe',$lvxingshe);
		}
		
        $this->display();
    }


    public function dopsotaddcompany() {
		
		$Gllvxingshe = D('Gllvxingshe');
		foreach($_POST as $key => $value){
			if($key == 'forword')
			$forword = $value;
			else
			$postdata[$key] = $value;
		}
		if($postdata['lvxingsheID'] == null){
			$theone = $Gllvxingshe->where("`companyname` = '$postdata[companyname]'")->find();
			if(!$postdata['companyname'] || $theone)
				doalert('公司名称已经存在',$forword);
			$postdata['addusername'] = $this->admin['user_name'];
			$postdata['editusername'] = $this->admin['user_name'];
			$postdata['admintype'] = "客户";
			$postdata['type'] = "客户";
			$postdata['time'] = time();
			$newid = $Gllvxingshe->add($postdata);
			if($newid)
			doalert('添加成功',$forword);
			else
			doalert('失败',$forword);
		}
		else
		{
			$postdata['editusername'] = $this->admin['user_name'];
			$Gllvxingshe->save($postdata);
			doalert('修改成功',$forword);
		}
		
		
    }


	
    public function deletecompany() {
		
		$Gllvxingshe = D('Gllvxingshe');
		$lvxingsheID = $_GET['lvxingsheID'];
		$company = $Gllvxingshe->where("`lvxingsheID` = '$lvxingsheID' and `type` = '同业'")->find();
		
		if(!$company)
			doalert('错误','');
			
		$Gllvxingshe->delete();
		doalert('成功','');
    }







}
?>