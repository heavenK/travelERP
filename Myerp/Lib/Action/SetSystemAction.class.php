<?php

class SetSystemAction extends CommonAction{
	
    public function _myinit() {
		//判断计调角色
		$durlist = A("Method")->_checkRolesByUser('网管','行政');
		if(false === $durlist){
			$this->display('Index:error');
			exit;
		}
		$this->assign("navposition",'系统管理');
	}
	
	public function index(){
		$type = $_REQUEST['type'];
		A("Method")->showDirectory($type);
		
		$ViewUser = D("ViewUser");
		$userlist = $ViewUser->where("`status_system` = '1'")->findall();
		$this->assign("userlist",$userlist);
			
		$datas = A('Method')->_getDepartmentList();
		$this->assign("bumenlist",$datas);
		
		$this->display('SetSystem:index');
	}
	
	public function category(){
		A("Method")->showDirectory("分类");
		$ViewCategory = D("ViewCategory");
		$datas = $ViewCategory->findall();
		$this->assign("datalist",$datas);
		$this->display('SetSystem:templatelist');
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
		$this->display('SetSystem:templatelist');
		
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
			$this->display('SetSystem:templatelist');
		}
		else{
			A("Method")->showDirectory("数据开放与管理");
			$this->display('SetSystem:OMindex');
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
		$this->display('SetSystem:templatelist');
		
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
		$this->display('SetSystem:templatelist');
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
		$this->display('SetSystem:templatelist');
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
		//$this->ajaxReturn('', '该功能暂不开放！！！', 0);
		C('TOKEN_ON',false);
		$systemID = $_REQUEST['systemID'];
		$System = D("System");
		$che = $System->where("`systemID` = '$systemID'")->find();
		if($che['status_system'] == -1){
			$data['status_system'] = 1;
			$data['islock'] = '未锁定';
		}
		else{
			$data['status_system'] = -1;
			$data['islock'] = '已锁定';
		}
		$data['systemID'] = $systemID;
		if(false !== $System->save($data)){
			while($d = $System->where("`parentID` = '$systemID'")->find()){
				if(null == $d || false === $d)
				break;
				$dt['systemID'] = $d['systemID'];
				$dt['status_system'] = $data['status_system'];
				$dt['islock'] = $data['islock'];
				$System->save($dt);
			}
			$this->ajaxReturn('', '操作成功！', 1);
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
		$this->display('SetSystem:templatelist');
	}
	
	//统一system内表数据增加
	public function dopostSystemHas(){
		C('TOKEN_ON',false);
		$System = D("System");
		$data = $_REQUEST;
		$data[$_REQUEST['tableName']] = $_REQUEST;
		if($_REQUEST['tableName'] == 'user'){
			$ViewUser = D("ViewUser");
			if($_REQUEST['systemID']){
				if($_REQUEST['islock']){
					if($_REQUEST['islock'] == '未锁定'){
						$data['islock'] = '未锁定';
						$data['status_system'] = 1;
					}
					if($_REQUEST['islock'] == '已锁定'){
						$data['islock'] = '已锁定';
						$data['status_system'] = -1;
					}
				}
			}
			else{
				$user = $ViewUser->where("`systemID` = '$_REQUEST[title]'")->find();
				if($user)
					$this->ajaxReturn($_REQUEST, '错误！用户名已在系统中存在！！', 0);
				$data[$_REQUEST['tableName']]['user_name'] = $_REQUEST['title'];
			}
			if($_REQUEST['password'])
				$data[$_REQUEST['tableName']]['password'] = md5(md5($_REQUEST['password']));
		}
		if($_REQUEST['tableName'] == 'roles'){
			$ViewRoles = D("ViewRoles");
			$roles = $ViewRoles->where("`title` = '$_REQUEST[title]'")->find();
			if($_REQUEST['systemID'] && $_REQUEST['systemID'] != $roles['systemID'])
				$this->ajaxReturn($_REQUEST, '错误！角色名已在系统中存在！！', 0);
			if($_REQUEST['systemID'] == '' && $roles)
				$this->ajaxReturn($_REQUEST, '错误！角色名已在系统中存在！！', 0);
		}
		if($_REQUEST['tableName'] == 'department'){
			$ViewDepartment = D("ViewDepartment");
			$roles = $ViewDepartment->where("`title` = '$_REQUEST[title]'")->find();
			if($_REQUEST['systemID'] && $roles && ($_REQUEST['systemID'] != $roles['systemID']))
				$this->ajaxReturn($_REQUEST, '错误！部门名已在系统中存在！！！！！！！', 0);
			if($_REQUEST['systemID'] == '' && $roles)
				$this->ajaxReturn($_REQUEST, '错误！部门名已在系统中存在！！', 0);
		}
		if($_REQUEST['tableName'] == 'category'){
			$ViewCategory = D("ViewCategory");
			$roles = $ViewCategory->where("`title` = '$_REQUEST[title]'")->find();
			if($_REQUEST['systemID'] && $roles && ($_REQUEST['systemID'] != $roles['systemID']))
				$this->ajaxReturn($_REQUEST, '错误！分类名已在系统中存在！！', 0);
			if($_REQUEST['systemID'] == '' && $roles)
				$this->ajaxReturn($_REQUEST, '错误！分类名已在系统中存在！！', 0);
		}
		if($_REQUEST['tableName'] == 'datadictionary'){
			$data[$_REQUEST['tableName']]['datatext'] = serialize($_REQUEST);//在datacopy表测试无压力，此表诡异
			$ViewDataDictionary = D("ViewDataDictionary");
			$roles = $ViewDataDictionary->where("`title` = '$_REQUEST[title]'")->find();
			if($_REQUEST['systemID'] && $roles && ($_REQUEST['systemID'] != $roles['systemID']))
				$this->ajaxReturn($_REQUEST, '错误！数据名已在系统中存在！！', 0);
			if($_REQUEST['systemID'] == '' && $roles)
				$this->ajaxReturn($_REQUEST, '错误！数据名已在系统中存在！！', 0);
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
			$this->display('SetSystem:templatelist');
		}
		else{
			A("Method")->showDirectory("审核流程");
			$this->display('SetSystem:shenheIndex');
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
			A('Method')->_ShenheToDataShenhe($_REQUEST);
			//修复开放om
			A('Method')->_djcOMCreateRepair($data['datatype'],$data['processID']);
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
		$ViewShenhe = D("ViewShenhe");
		$data = $ViewShenhe->where("`systemID` = '$systemID'")->find();
		if (false !== $System->relation("shenhe")->delete("$systemID"))
		{
			$DataShenhe = D("DataShenhe");
			$DataShenhe->where("`shenheID` = '$systemID'")->delete();
			//修复开放om
			A('Method')->_djcOMCreateRepair($data['datatype'],$data['processID']);
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
		if($_REQUEST['returntype'] == 'array' ){
			$where['systemID'] = $_REQUEST['systemID'];
			$data = $ViewDataDictionary->where($where)->find();
			if($data['type'] == 'FAQ'){
				$data['datatext'] = mb_unserialize($data['datatext']);
			}
			$this->ajaxReturn($data, '读取成功！', 1);
			exit;
		}
		$data = $ViewDataDictionary->where($where)->findall();
		$i = 0;
		foreach($data as $v){
			$data[$i]['datatext'] = mb_unserialize($v['datatext']);
			$i++;
		}
		$this->assign("datalist",$data);
		if($where['type'] == '视频'){
			A("Method")->showDirectory("视频");
			if($_REQUEST['version'] == 'full')
			$this->display('SetSystem:templatelist');
			else{
				$this->assign("datatitle",'视频选择');
				$this->display('SetSystem:shipin');
			}
		}
		elseif($where['type'] == '图片'){
			A("Method")->showDirectory("图片");
			if($_REQUEST['version'] == 'full')
			$this->display('SetSystem:templatelist');
			else{
				if($_REQUEST['title']){
					$tupianlist = split(',',$_REQUEST['title']);
					$this->assign("tupianlist",$tupianlist);
				}
				$this->assign("datatitle",'图片选择');
				$this->display('SetSystem:tupian');
			}
		}
		elseif($where['type'] == '主题'){
			A("Method")->showDirectory("主题");
			$this->display('SetSystem:templatelist');
		}
		elseif($where['type'] == '成本'){
			A("Method")->showDirectory("成本");
			$this->display('SetSystem:templatelist');
		}
		elseif($where['type'] == '提成'){
			A("Method")->showDirectory("提成");
			$this->display('SetSystem:templatelist');
		}
		elseif($where['type'] == 'FAQ'){
			A("Method")->showDirectory("FAQ");
			$this->display('SetSystem:templatelist');
		}
		else
			$this->display('SetSystem:DDindex');
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
				unlink('./Data/Attachments/'.$dd['datadictionary']['pic_url']);
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
		$this->display('SetSystem:templatelist');
	}
	
	public function roles(){
		A("Method")->showDirectory("角色设置");
		$datas = A('Method')->_getRolesList();
		$this->assign("datalist",$datas);
		$this->display('SetSystem:templatelist');
	}
	

	public function dopost_chanpinpingyi(){
		C('TOKEN_ON',false);
		$chanpinID = $_REQUEST['chanpinID'];
		$username = $_REQUEST['username'];
		$bumentitle = $_REQUEST['bumentitle'];
		$ViewDepartment = D("ViewDepartment");
		$bumen = $ViewDepartment->where("`title` = '$bumentitle'")->find();	
		$Chanpin = D("Chanpin");
		$cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
		if($username)
			$cp['user_name'] = $username;
		if($bumen)
			$cp['departmentID'] = $bumen['systemID'];
		if($cp['marktype'] == 'zituan' || $cp['marktype'] == 'DJtuan' || $cp['marktype'] == 'xianlu'){
			//产品转移
			if($cp['marktype'] == 'xianlu'){
				$Chanpin->mycreate($cp);
				$datatype = '线路';
				A('Method')->_OMRcreate($chanpinID,$datatype,$username);
				$tuanall = $Chanpin->where("`parentID` = '$chanpinID'")->findall();
				foreach($tuanall as $tuan){
					$tuan['user_name'] = $cp['user_name'];
					$tuan['departmentID'] = $cp['departmentID'];
					$this->_tuanchanpinpingyi($tuan,$tuan['chanpinID'],$username);
				}
			}
			else
				$this->_tuanchanpinpingyi($cp,$chanpinID,$username);
		}
		if($cp['marktype'] == 'baohang'){
			$baozhang = $Chanpin->relationGet("baozhang");
			if($baozhang['type'] == '团队报账单')
				$this->ajaxReturn('', '团队报账单不允许转移！', 0);
		}
		
		$this->ajaxReturn('', '成功！', 1);
		
		
	}


	public function _tuanchanpinpingyi($cp,$chanpinID,$username){
			$Chanpin = D("Chanpin");
			$Chanpin->mycreate($cp);
			//删除OM并重新生成
			if($cp['marktype'] == 'zituan'){
				$datatype = '子团';
				//订单OM添加
				$dingdanall = $Chanpin->where("`parentID` = '$chanpinID' and `marktype` = 'dingdan'")->findall();
				foreach($dingdanall as $dingdan){
					//开放给自己部门
					$dataOMlist = A("Method")->_getmyOMlist($username);
					A("Method")->_createDataOM($dingdan['chanpinID'],'订单','管理',$dataOMlist);
				}
			}
			if($cp['marktype'] == 'DJtuan')
			$datatype = '地接';
			A('Method')->_OMRcreate($chanpinID,$datatype,$username);
			//报账单转移
			$bzdall = $Chanpin->where("`parentID` = '$chanpinID' and `marktype` = 'baozhang'")->findall();
			$dataOMlist = A('Method')->_getDataOM($chanpinID,$datatype);
			foreach($bzdall as $bzd){
				$bzd['user_name'] = $cp['user_name'];
				$bzd['departmentID'] = $cp['departmentID'];
				$Chanpin->mycreate($bzd);
				A('Method')->_OMRcreate($bzd['chanpinID'],'报账单',$username,$dataOMlist);
				
				//报账项目转移
				$bzditemall = $Chanpin->where("`parentID` = '$bzd[chanpinID]' and `marktype` = 'baozhangitem'")->findall();
				foreach($bzditemall as $bzditem){
					$bzditem['user_name'] = $cp['user_name'];
					$bzditem['departmentID'] = $cp['departmentID'];
					$Chanpin->mycreate($bzditem);
					A('Method')->_OMRcreate($bzditem['chanpinID'],'报账项',$username,$dataOMlist);
				}
				
			}
		
	}
	
	//重置联合体线路om
	public function resetOM(){
		C('TOKEN_ON',false);
		echo "重置联合体线路om<br>";
		if(!$_REQUEST['page']){
			dump('无page参数');
			exit;
		}
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num = ($_REQUEST['page']-1)*1;
		$num_2 = ($_REQUEST['page_2']-1)*100;
		$Chanpin = D("Chanpin");
		$ViewDepartment = D("ViewDepartment");
		$filterlist = $ViewDepartment->Distinct(true)->field('systemID')->where("`type` like '%联合体%' or `type` like '%办事处%'")->limit("$num,1")->order("systemID desc")->findall();
		dump($filterlist);
		if($filterlist == null){
			exit;
		}
		else{
			$systemID = $filterlist[0]['systemID'];
			$xianluall = $Chanpin->where("`departmentID` = '$systemID' and `marktype` = 'xianlu'")->limit("$num_2,100")->findall();
			dump($xianluall);
			if($xianluall == null){
				$url = SITE_INDEX."SetSystem/resetOM/page/".($_REQUEST['page']+1)."/page_2/1";
			}
			else
				$url = SITE_INDEX."SetSystem/resetOM/page/".$_REQUEST['page']."/page_2/".($_REQUEST['page_2']+1);
			foreach($xianluall as $vol){
				$cp = $Chanpin->where("`chanpinID` = '$vol[chanpinID]'")->find();
				A("Method")->_OMRcreate($vol['chanpinID'],'线路',$cp['user_name']);
			}
		}
		$this->assign("url",$url);
		$this->display('Index:systemtools');
		echo "结束";
	}
	
	
	
	
	
	
	
	
	
	
}
?>