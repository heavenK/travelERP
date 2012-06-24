<?php

class SetSystemAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'系统管理');
	}
	
	public function index(){
		A("Method")->showDirectory("系统管理");
		$this->display('index');
	}
	
	public function setting(){
		A("Method")->showDirectory("系统设置");
		$this->display("index");
	}
	
	public function category(){
		A("Method")->showDirectory("分类");
		$ViewCategory = D("ViewCategory");
		$datas = $ViewCategory->findall();
		$this->assign("datalist",$datas);
		$this->display('templateList');
	}
	
	public function dopostCategory(){
		$System = D("System");
		$data = $_REQUEST;
		$data['category'] = $_REQUEST;
		if (false !== $System->relation("category")->myRcreate($data))
			$this->ajaxReturn('', '成功！', 1);
		else
			$this->ajaxReturn($_REQUEST, $System->getError(), 0);
		
	}
	
	public function addSystemDC(){
		A("Method")->showDirectory("项目管理");
		$ViewCategory = D("ViewCategory");
		$System = D("System");
		$systemID = $_REQUEST['systemID'];
		$datas = A('Method')->_getDepartmentList();
		$this->assign("departmentAll",$datas);
		$datas2 = $System->relation("systemDClist")->where("`systemID` = '$systemID'")->find();
		$datas2['category'] = $System->relationGet("category");
		$Department = D("Department");
		$i = 0;
		foreach($datas2['systemDClist'] as $v){
			$datas2['systemDClist'][$i]['department'] = $Department->where("`systemID` = '$v[dataID]'")->find();
			$i++;
		}
		$this->assign("systemDClist",$datas2['systemDClist']);
		$this->assign("category",$datas2);
		$this->assign("datatitle",' : "'.$datas2['category']['title'].'"');
		$this->display('templateList');
		
	}
	
	public function dopostDepartmentDC(){
		C('TOKEN_ON',false);
		$System = D("System");
		$data = $_REQUEST;
		$data['systemDC'] = $_REQUEST;
		if (false !== $System->relation("systemDC")->myRcreate($data)){
			if($System->getLastmodel() == 'add')
				$_REQUEST['systemID'] = $System->getRelationID();
			else
			{
				$DataShenhe = D("DataShenhe");
				$DataShenhe->where("`shenheID` = '$_REQUEST[systemID]'")->delete();
			}
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else{
			$this->ajaxReturn($_REQUEST, $System->getError(), 0);
			
		}
	}
	
	public function deleteDepartemntDC()
	{
		$systemID = $_REQUEST['systemID'];
		$System = D("System");
		if (false !== $System->relation("systemDC")->delete("$systemID"))
			$this->ajaxReturn('', '删除成功！', 1);
		else
			$this->ajaxReturn('', $System->getError(), 0);
	}
	
	public function systemOM(){
		$System = D("System");
		if($_REQUEST['datatype'] == '分类'){
			$ViewCategory = D("ViewCategory");
			$datas = $ViewCategory->findall();
		}
		if($_REQUEST['datatype'] == '线路'){
			A("Method")->showDirectory("线路数据");
			$wherelist = A('Method')->_facade("ViewXianlu",$_GET);
			$datas = A('Method')->xianlu_list_noOM($wherelist);
		}
		//显示
		if($_REQUEST['datatype']){
			$this->assign("listdatas",$datas);
			$this->display('templateList');
		}
		else{
			A("Method")->showDirectory("数据开放与管理");
			$this->display('OMindex');
		}
		
	}
	
	public function addSystemOM(){
		$datatype = $_REQUEST['datatype'];
		$dataID = $_REQUEST['dataID'];
		$method = $_REQUEST['method'];
		$data = A("Method")->OMlist($dataID,$datatype,$method);
		A('Method')->unitlist();
		A("Method")->showDirectory("数据开放与管理");
		$this->assign("datatitle",' > '.$_REQUEST['method'].' : "'.$_REQUEST['datatitle'].'"');
		$this->display('templateList');
		
	}
	
	public function dopostSystemOM(){
		C('TOKEN_ON',false);
		$System = D("System");
		$data = $_REQUEST;
		$data['systemOM'] = $_REQUEST;
		if (false !== $System->relation("systemOM")->myRcreate($data)){
			if($System->getLastmodel() == 'add')
				$_REQUEST['systemID'] = $System->getRelationID();
				
			A('Method')->_OMToDataOM($_REQUEST);
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else{
			$this->ajaxReturn($_REQUEST, $System->getError(), 0);
		}
	}
	
	
	public function deleteSystemOM()
	{
		$systemID = $_REQUEST['systemID'];
		$System = D("System");
		if (false !== $System->relation("systemOM")->delete("$systemID")){
			$DataOM = D("DataOM");
			$DataOM->where("`OMID` = '$systemID'")->delete();
			$this->ajaxReturn('', '删除成功！', 1);
		}else
			$this->ajaxReturn('', $System->getError(), 0);
	}
	
	
	public function systemUser(){
		A("Method")->showDirectory("用户");
		$this->assign("showtitle",$showtitle);
		$users = A('Method')->search_list("ViewUser",$_REQUEST);
		$this->assign("users",$users);
		A("Method")->unitlist();
		$this->display('templateList');
	}
	
	public function userDUR(){
		A("Method")->showDirectory("部门角色");
		$systemID = $_REQUEST['systemID'];
		$System = D("System");
		$data = $System->relation("DURlist")->where("`systemID` = '$systemID'")->find();
		$DURlist = $data['DURlist'];
		A('Method')->_facesystem($DURlist,'用户');
		A('Method')->unitlist();
		$this->assign("DURlist",$DURlist);
		$this->assign("datatitle",' : "'.$_REQUEST['datatitle'].'"');
		$this->display('templateList');
	}
	
	
	public function dopostUserDUR(){
		C('TOKEN_ON',false);
		$System = D("System");
		$data = $_REQUEST;
		$data['systemDUR'] = $_REQUEST;
		if (false !== $System->relation("systemDUR")->myRcreate($data)){
			if($System->getLastmodel() == 'add')
				$_REQUEST['systemID'] = $System->getRelationID();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else{
			$this->ajaxReturn($_REQUEST, $System->getError(), 0);
		}
		
	}
	
	
	public function deleteSystemItem()
	{
		$systemID = $_REQUEST['systemID'];
		$System = D("System");
		if (false !== $System->relation($_REQUEST['tableName'])->delete("$systemID"))
		{
			while($d = $System->where("`parentID` = '$systemID'")->find())
			{
				if(null == $d || false === $d)
				break;
				$System->relation($_REQUEST['tableName'])->where("`parentID` = '$systemID'")->delete();
				$systemID = $d['parentID'];
			}
			$this->ajaxReturn('', '删除成功！', 1);
		}
		else
			$this->ajaxReturn('', $System->getError(), 0);
	}
	
	
	public function directory(){
		A("Method")->showDirectory("目录设置");
		$parentID = $_REQUEST['parentID'];
		if(!$parentID)
			$where['parentID'] =  array('exp','is NULL');
		else	
			$where['parentID'] = $parentID;
		$ViewDirectory = D("ViewDirectory");
		$datalist = $ViewDirectory->relation("directory")->where($where)->findall();
		$this->assign("datalist",$datalist);
		//目录
		$dd = $ViewDirectory->relation("directory")->where("`systemID` = '$parentID'")->find();
		if($dd)
		$this->assign("datatitle",' : "'.$dd['title'].'"');
		$this->display('templateList');
	}
	
	//统一system内表数据增加
	public function dopostSystemHas(){
		C('TOKEN_ON',false);
		$System = D("System");
		$data = $_REQUEST;
		$data[$_REQUEST['tableName']] = $_REQUEST;
		if (false !== $System->relation($_REQUEST['tableName'])->myRcreate($data)){
			if($System->getLastmodel() == 'add')
				$_REQUEST['systemID'] = $System->getRelationID();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else{
			$this->ajaxReturn($_REQUEST, $System->getError(), 0);
		}
	}
	
	
	public function shenhe(){
		$ViewShenhe = D("ViewShenhe");
		A('Method')->unitlist();
		$datatype = $_REQUEST['datatype'];
		if($_REQUEST['datatype'] == '线路'){
			A("Method")->showDirectory("审核流程");
			$datalist = $ViewShenhe->where("`datatype` = '$datatype'")->findall();
			$datalist = A("Method")->_systemUnitFilter($datalist);
			$this->assign("datalist",$datalist);
		}
		//显示
		if($_REQUEST['datatype']){
			$this->assign("datatitle",' : "'.$datatype.'"');
			$this->display('templateList');
		}
		else{
			A("Method")->showDirectory("审核流程");
			$this->display('shenheIndex');
		}
		
	}
	
	
	public function dopostShenhe(){
		C('TOKEN_ON',false);
		$System = D("System");
		$data = $_REQUEST;
		$data['shenhe'] = $_REQUEST;
		if (false !== $System->relation("shenhe")->myRcreate($data)){
			if($System->getLastmodel() == 'add'){
				$_REQUEST['systemID'] = $System->getRelationID();
			}
			else
			{
				$DataShenhe = D("DataShenhe");
				$DataShenhe->where("`shenheID` = '$_REQUEST[systemID]'")->delete();
			}
			A('Method')->_ShenheToDataShenhe($_REQUEST);
			
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else{
			$this->ajaxReturn($_REQUEST, $System->getError(), 0);
		}
	}
	
	
	public function deleteShenheItem()
	{
		$systemID = $_REQUEST['systemID'];
		$System = D("System");
		if (false !== $System->relation("shenhe")->delete("$systemID"))
		{
			$DataShenhe = D("DataShenhe");
			$DataShenhe->where("`shenheID` = '$systemID'")->delete();
			$this->ajaxReturn('', '删除成功！', 1);
		}
		else
			$this->ajaxReturn('', $System->getError(), 0);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>