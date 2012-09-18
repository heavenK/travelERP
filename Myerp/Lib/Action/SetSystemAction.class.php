<?php

class SetSystemAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'系统管理');
	}
	
	public function index(){
		$type = $_REQUEST['type'];
		A("Method")->showDirectory($type);
		$this->display('index');
	}
	
	public function category(){
		A("Method")->showDirectory("分类");
		$ViewCategory = D("ViewCategory");
		$datas = $ViewCategory->findall();
		$this->assign("datalist",$datas);
		$this->display('templatelist');
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
		$systemID = $_REQUEST['systemID'];
		$datalist = A("Method")->_getsystemDC($systemID);
		$this->assign("systemDClist",$datalist['systemDClist']);
		$this->assign("category",$datalist);
		$this->assign("datatitle",' : "'.$datalist['category']['title'].'"');
		$this->display('templatelist');
		
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
			$datas = A('Method')->data_list_noOM('ViewXianlu',$_GET);
		}
		if($_REQUEST['datatype'] == '报账单'){
			A("Method")->showDirectory("报账单数据");
			$datas = A('Method')->data_list_noOM("ViewBaozhang",$_GET);
		}
		//显示
		if($_REQUEST['datatype']){
			$this->assign("listdatas",$datas);
			$this->display('templatelist');
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
		$this->display('templatelist');
		
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
		if($_REQUEST['title']){
			$_REQUEST['title'] = array('like','%'.$_REQUEST['title'].'%');
		}
		A("Method")->showDirectory("用户");
		$this->assign("showtitle",$showtitle);
		$users = A('Method')->data_list_noOM("ViewUser",$_REQUEST);
		$this->assign("users",$users);
		A("Method")->unitlist();
		$this->display('templatelist');
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
		$this->display('templatelist');
	}
	
	
	public function dopostUserDUR(){
		C('TOKEN_ON',false);
		$System = D("System");
		$data = $_REQUEST;
		$data['systemDUR'] = $_REQUEST;
		if (false !== $System->relation("systemDUR")->myRcreate($data)){
			if($System->getLastmodel() == 'add')
				$_REQUEST['systemID'] = $System->getRelationID();
			//选填RBAC权限
			//A("Method")->_opentoRBACbyUser($_REQUEST['systemID'],$_REQUEST['rolesID']);
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else{
			$this->ajaxReturn($_REQUEST, $System->getError(), 0);
		}
		
	}
	
	
	public function deleteSystemItem()
	{
		$this->ajaxReturn('', '该功能暂不开放！！！', 0);
		$systemID = $_REQUEST['systemID'];
		$System = D("System");
		
		if($_REQUEST['tableName'] == 'datadictionary'){
			$System = D("System");
			$dd = $System->relation('datadictionary')->where("`systemID` = '$systemID'")->find();
		}
		
		if (false !== $System->relation($_REQUEST['tableName'])->delete("$systemID"))
		{
			if($dd){
				unlink('./Data/Attachments/m_'.$dd['datadictionary']['pic_url']);
				unlink('./Data/Attachments/s_'.$dd['datadictionary']['pic_url']);
			}
			while($d = $System->where("`parentID` = '$systemID'")->find())
			{
				if(null == $d || false === $d)
				break;
				$System->relation($_REQUEST['tableName'])->where("`parentID` = '$systemID'")->delete();
			}
			$this->ajaxReturn('', '删除成功！', 1);
		}
		else
			$this->ajaxReturn('', $System->getError(), 0);
	}
	
	
	public function lcokSystemItem()
	{
		C('TOKEN_ON',false);
		$System = D("System");
		$systemID = $_REQUEST['systemID'];
		$data['systemID'] = $_REQUEST['systemID'];
		$data['islock'] = $_REQUEST['islock'];
		if (false !== $System->save($data)){
			while($d = $System->where("`parentID` = '$systemID' and `islock` != '$_REQUEST[islock]'")->find()){
				if(null == $d || false === $d)
				break;
				$d['islock'] = $_REQUEST['islock'];
				$System->save($d);
			}
			$this->ajaxReturn('', $_REQUEST['islock'].'！', 1);
		}
		else{
			$this->ajaxReturn('', $System->getError(), 0);
		}
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
		$this->display('templatelist');
	}
	
	//统一system内表数据增加
	public function dopostSystemHas(){
		C('TOKEN_ON',false);
		$System = D("System");
		$data = $_REQUEST;
		$data[$_REQUEST['tableName']] = $_REQUEST;
		if($_REQUEST['tableName'] == 'user'){
			$ViewUser = D("ViewUser");
			$user = $ViewUser->where("`systemID` = '$_REQUEST[systemID]'")->find();
			$data[$_REQUEST['tableName']]['user_name'] = $user['user_name'];
			if($user['islock'] == '已锁定'){
				$data['islock'] = '未锁定';
				$data['status_system'] = 1;
			}
			if($_REQUEST['password'])
				$data[$_REQUEST['tableName']]['password'] = md5($_REQUEST['password']);
		}
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
		A("Method")->showDirectory("审核流程");
		$datalist = $ViewShenhe->where("`datatype` = '$datatype'")->findall();
		$datalist = A("Method")->_systemUnitFilter($datalist);
		$this->assign("datalist",$datalist);
		//显示
		if($_REQUEST['datatype']){
			$this->assign("datatitle",' : "'.$datatype.'"');
			$this->display('templatelist');
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
	
	
	
	public function dataDictionary()
	{
		A("Method")->showDirectory("数据字典");
		$ViewDataDictionary = D("ViewDataDictionary");
		$where['type'] = $_REQUEST['type'];
		$data = $ViewDataDictionary->where($where)->findall();
		$this->assign("datalist",$data);
		if($where['type'] == '视频'){
			A("Method")->showDirectory("视频");
			if($_REQUEST['version'] == 'full')
			$this->display('templatelist');
			else{
				$this->assign("datatitle",'视频选择');
				$this->display('shipin');
			}
		}
		elseif($where['type'] == '图片'){
			A("Method")->showDirectory("图片");
			if($_REQUEST['version'] == 'full')
			$this->display('templatelist');
			else{
				$tupianlist = split(',',$_REQUEST['title']);
				$this->assign("tupianlist",$tupianlist);
				$this->assign("datatitle",'图片选择');
				$this->display('tupian');
			}
		}
		elseif($where['type'] == '主题'){
			A("Method")->showDirectory("主题");
			$this->display('templatelist');
		}
		elseif($where['type'] == '成本'){
			A("Method")->showDirectory("成本");
			$this->display('templatelist');
		}
		elseif($where['type'] == '提成'){
			A("Method")->showDirectory("提成");
			$this->display('templatelist');
		}
		else
			$this->display('DDindex');
	}
	
	
	
	public function dopostDataDictionary()
	{
		C('TOKEN_ON',false);
		$System = D("System");
		$data = $_REQUEST;
		$data["datadictionary"] = $_REQUEST;
        if ($_FILES['image']['name'] != '') { 
            //如果有文件上传 上传附件
			$savepath = './Data/Attachments/'; 
            $data["datadictionary"]['pic_url'] = A("Method")->_upload($savepath); 
        }
		if($data['systemID'] && $data["datadictionary"]['pic_url']){
			$dd = $System->relation('datadictionary')->where("`systemID` = '$data[systemID]'")->find();
			if($dd)
			{
				unlink('./Data/Attachments/m_'.$dd['datadictionary']['pic_url']);
				unlink('./Data/Attachments/s_'.$dd['datadictionary']['pic_url']);
			}
		}
		elseif(!$data['systemID'] && false === $data["datadictionary"]['pic_url'])
			$data["datadictionary"]['pic_url'] = '';
		if (false !== $System->relation('datadictionary')->myRcreate($data)){
			if($System->getLastmodel() == 'add')
				$_REQUEST['systemID'] = $System->getRelationID();
			$dd = $System->relation('datadictionary')->where("`systemID` = '$_REQUEST[systemID]'")->find();	
			$_REQUEST['pic_url'] = $dd['datadictionary']['pic_url'];
			A("Method")->ajaxUploadResult($_REQUEST,'保存成功',1);
		}
		else{
			A("Method")->ajaxUploadResult($_REQUEST,$System->getError(),0);
		}
		
	}
	
	
	public function liandong(){
		A("Method")->showDirectory("地区联动");
		$t=$_GET['t']?$_GET['t']:0;
		$name = D("myerp_liandong");
		$condition['id'] = $t; 
		$pname = $name->where($condition)->find();
		
		if (!$pname) {
			$pname['position'] = '顶级分类';
			$pname['level'] = '一级选择';
			$condition['id']    = array('elt',99); 
		}
		else if ($t >= '1' && $t <= '99') {
			$pname['position'] = '<a href=SITE_INDEX."SetSystem/liandong/t/' . floor($t/100) . '" style="color:red">'.$pname['position'].'</a>';
			$pname['level'] = '二级选择';
			$condition['id']    = array('between','100,999'); 
		}else{
			$pname['position'] = '<a href=SITE_INDEX."SetSystem/liandong/t/' . floor($t/100) . '" style="color:red">'.$pname['position'].'</a>';
			$pname['level'] = '三级选择';
			$condition['id']    = array('egt',1000); 
		}
		$liandong = D("myerp_liandong");
		$condition['pid']	= $t;
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		$count = $liandong->where($condition)->count();
		$p = new Page ( $count, 10 ); 
		$list=$liandong->where($condition)->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_INDEX.'SetSystem/liandong/t/' . $t . '/p/');
		$this->assign ( "t", $t );
		$this->assign ( "pname", $pname );
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display(); 
	}
	
	//联动增加
	public function liandongInsert(){
		$pid = $_POST['pid'];
		$ename = $_POST['ename'];
		$names = split(',',$ename);
		$lian = D("myerp_liandong");
		$condition['pid']	= $pid;
		$max_lian = $lian->where($condition)->order('id desc')->find();
		if ($max_lian){
			$max_id = $max_lian['id'] + 1;
			echo "1";
		}else{
			if ($pid == '0') {
				$max_id = 1;
			}
			else if ($pid >= '1' && $pid <= '99') {
				$max_id = $pid * 100 + 1;
			}else{
				$max_id = $pid * 1000 + 1;
			}
		}
		foreach($names as $name){
			$liandong = D("myerp_liandong");
			$liandong->id = $max_id;
			$liandong->position = $name;
			$liandong->pid = $pid;
			$liandong->add();
			$max_id++;
		}
		$this->redirect('SetSystem/liandong/t/'.$pid);
	}
	//联动编辑
	public function liandongEdit(){
		$pid = $_POST['pid']?$_POST['pid']:0;
		$id = $_POST['id'];
		$name = $_POST['name'];
		if(!empty($id)) { 
			$liandong    =    D("myerp_liandong");
			$liandong->find($id);
			$liandong->position = $name;
			$res = $liandong->save();
		}
	}
	//联动删除
	public function liandongDelete(){
		$t=$_GET['t']?$_GET['t']:0;
		$id = $_REQUEST['id'];
		if(!empty($id)) { 
			$liandong    =    D("myerp_liandong");
			$condition['id']	= array('like',$id.'%');
			$result    =    $liandong->where($condition)->delete(); 
			$this->redirect('SetSystem/liandong/t/'.$t);
		}
	}
	
	
	public function department(){
		A("Method")->showDirectory("部门设置");
		$datas = A('Method')->_getDepartmentList();
		$this->assign("datalist",$datas);
		$this->display('templatelist');
	}
	
	public function roles(){
		A("Method")->showDirectory("角色设置");
		$datas = A('Method')->_getRolesList();
		$this->assign("datalist",$datas);
		$this->display('templatelist');
	}
	





}
?>