<?php

class MethodAction extends Action{
	
    public function _initialize() {
		if($_REQUEST['_URL_'][0] == 'Method'){
			$this->display('Index:error');
			exit;
		}
	}
	
    //DataOM显示列表
    public function getDataOMlist($datatype,$relation,$where,$type='管理',$pagenum = 20) {
		if($datatype == '审核任务'){
			$class_name = 'OMViewTaskShenhe';
			$where['status'] = '待检出';
		}
		if($datatype == '线路'){
			$class_name = 'OMViewChanpin';
			$where['datatype'] = $datatype;
		}
		if($datatype == '售价'){
			$class_name = 'OMViewChanpin';
			$where['datatype'] = $datatype;
		}
		if($datatype == '订单'){
			$class_name = 'OMViewChanpin';
			$where['datatype'] = $datatype;
		}
		if($datatype == '控管'){
			$class_name = 'OMViewChanpin';
			$where['datatype'] = '子团';
		}
		$where['type'] = $type;
		$where = $this->_facade($class_name,$where);//过滤搜索项
		$where = $this->_openAndManage_filter($where);
		$DataOM = D($class_name);
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $DataOM->Distinct(true)->field('dataID')->where($where)->count();
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $chanpin = $DataOM->relation($relation)->Distinct(true)->field('dataID')->where($where)->limit($p->firstRow.','.$p->listRows)->order("time desc")->select();
		$chanpin = $this->_getRelation_select_after($chanpin,$relation);
		$redata['page'] = $page;
		$redata['chanpin'] = $chanpin;
		return $redata;
	}


    //显示产品列表
    public function xianlu_list_noOM($where,$pagenum = 20) {
		$class_name = 'ViewXianlu';
		$where['type'] = $type;
		$where = $this->_facade($class_name,$where);//过滤搜索项
		$ViewXianlu = D($class_name);
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $ViewXianlu->where($where)->count();
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $chanpin = $ViewXianlu->where($where)->order("time desc")->limit($p->firstRow.','.$p->listRows)->select();
		$redata['page'] = $page;
		$redata['chanpin'] = $chanpin;
		return $redata;
	}
	
    //开放与管理
    public function _openAndManage_filter($where,$user_ID = '') {
		$ViewSystemDUR = D("ViewSystemDUR");
		$where = $ViewSystemDUR->parseWhere($where);
		if($user_ID)
			$myuserID = $user_ID;
		else
			$myuserID = $this->user['systemID'];
		$DURlist = $ViewSystemDUR->where("`userID` = $myuserID")->findall();
		if($where)
		$where .= " AND (";
		else
		$where .= " (";
		if($DURlist){
			foreach($DURlist as $v)
			{
				if($whereitem)
					$whereitem .= " OR ";
				$whereitem .= "(`DUR` = '$v[bumenID],$v[rolesID],')";//部门，角色
				$whereitem .= " OR (`DUR` = '$v[bumenID],,')";//部门
				$whereitem .= " OR (`DUR` = ',$v[rolesID],')";//角色
				$whereitem .= " OR (`DUR` = ',,$v[userID]')";//用户
			}
		}
		else
				$whereitem .= "(`DUR` = ',,$v[userID]' )";//用户
		$where .= $whereitem.")";
		return $where;
	}
	
    //开放与管理
    public function _openAndManage_user($user_ID = '') {
		$ViewSystemDUR = D("ViewSystemDUR");
		if($user_ID)
			$myuserID = $user_ID;
		else
			$myuserID = $this->user['user_id'];
		$ViewSystemOM = D("ViewSystemOM");
		$DURlist = $ViewSystemDUR->where("`userID` = $myuserID")->findall();
		$i = 0;
		foreach($DURlist as $v)
		{
			if($v['parenttype'] == '部门'){
				$where['userID'] = $myuserID;
				$where['bumenID'] = $v['parentID'];
				if($v['roleslimitID'])
				$where['rolesID'] = $v['roleslimitID'];
				$isom = $ViewSystemDUR->where($where)->find();
				if($isom)
					return true;
			}
			$i++;
		}
	}
	
	//根据日期生成子团
    public function shengchengzituan($chanpinID) {
		$Chanpin = D("Chanpin");
		$chanpin = $Chanpin->relation("xianlu")->where("`chanpinID` = '$chanpinID'")->find();
		$riqiAll = split(';',$chanpin['xianlu']['chutuanriqi']);
		//根据线路判断生成
		$ViewZituan = D("ViewZituan");
		foreach($riqiAll as $riqi){
			$datazituan = '';
			$zituan = $ViewZituan->where("`parentID` = '$chanpinID' and `chutuanriqi` = '$riqi' ")->find();
			$datazituan['zituan']['title_copy'] = $chanpin['xianlu']['title'];
			$datazituan['zituan']['renshu'] = $chanpin['xianlu']['renshu'];
			$datazituan['zituan']['baomingjiezhi'] = $chanpin['xianlu']['baomingjiezhi'];
			$datazituan['zituan']['chutuanriqi'] = $riqi;
			$datazituan['zituan']['tuanhao'] =  $chanpinID.'/'.$riqi;
			if(!$zituan){
				$datazituan['parentID'] = $chanpinID;
				$datazituan['user_name'] = $chanpin['user_name'];
				$datazituan['user_id'] = $chanpin['user_id'];
				$datazituan['departmentName'] = $chanpin['departmentName'];
				$datazituan['departmentID'] = $chanpin['departmentID'];
				if (false !== $Chanpin->relation("zituan")->myRcreate($datazituan)){
					$zituanID = $Chanpin->getRelationID();
					//生成OM
					A("Method")->_createDataOM($zituanID,'子团','管理');
				}
			}
			else{
				if($zituan['islock'] != '已锁定'){
					//修改子团内容
					$datazituan['chanpinID'] = $zituan['chanpinID'];
					if (false !== $Chanpin->relation("zituan")->myRcreate($datazituan));
				}
				else
					$locklist .= $zituan['chutuanriqi'].";";
			}
		}
		//删除多余子团
		$viewxianlu = D("ViewXianlu");
		$xianlu = $viewxianlu->relation("zituanlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituanlist = $xianlu['zituanlist'];
		foreach($zituanlist as $zituan){
			if(false === strpos($chanpin['xianlu']['chutuanriqi'],$zituan['chutuanriqi'])){
				if($zituan['islock'] != '已锁定'){
					if (false !== $Chanpin->relation("zituan")->delete($zituan['chanpinID'])){
						continue;	
					}
				}
				else
					$locklist .= $zituan['chutuanriqi'].";";
			}
			if($chutuanlist)
			$chutuanlist .= ";".$zituan['chutuanriqi'];
			else
			$chutuanlist .= $zituan['chutuanriqi'];
		}
	   //由于可能存在子团锁定状态不能删除，要逆更新出团时间到线路
		$xianlu['xianlu']['chutuanriqi'] = $chutuanlist;
		if(false !== $Chanpin->relation("xianlu")->myRcreate($xianlu)){
			return true;
		}else
		return false;
	}

	
	//根据子团生成日期
    public function shengchengzituan_2($chanpinID) {
		$Chanpin = D("Chanpin");
		$chanpin = $Chanpin->relation("zituanlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituanlist = $chanpin['zituanlist'];
		foreach($zituanlist as $zituan){
			if($chutuanlist)
			$chutuanlist .= ";".$zituan['chutuanriqi'];
			else
			$chutuanlist .= $zituan['chutuanriqi'];
		}
	   //由于可能存在子团锁定状态不能删除，要逆更新出团时间到线路
		$xianlu['xianlu']['chutuanriqi'] = $chutuanlist;
		$xianlu['chanpinID'] = $chanpinID;
		if(false !== $Chanpin->relation("xianlu")->myRcreate($xianlu))
		return true;
		else
		return false;
	}
	
	
	public function OMlist($dataID,$datatype,$method){
		if($datatype == '分类'){
			$dat = $this->_categoryOMlist($dataID,$datatype,$method);
		}
		
		if($datatype == '线路'){
			$dat = $this->_xianluOMlist($dataID,$datatype,$method);
		}
		
		return $dat;
	}
	
     public function _categoryOMlist($dataID,$datatype,$method) {
		$ViewCategory = D("ViewCategory");
		$ViewDepartment = D("ViewDepartment");
		$ViewUser = D("ViewUser");
		$ViewRoles = D("ViewRoles");
		$systemID = $dataID;
		$dat = $ViewCategory->where("`systemID` = '$systemID'")->find();
		$dat['OMlist'] = $ViewCategory->relationGet("categoryOMlist");
		for($i=0;$i<count($dat['OMlist']);$i++){
			if($dat['OMlist'][$i]['type'] != $method){
				unset($dat['OMlist'][$i]);
				continue;
			}
			if($dat['OMlist'][$i]['roleslimitID'] == -1){
				$dat['OMlist'][$i]['roleslimitID'] = '';
			}
		}
		$dat['OMlist'] = array_values($dat['OMlist']);
		return $this->_OMlist($dat);
	 }

     public function _OMlist($dat) {
		$ViewCategory = D("ViewCategory");
		$ViewDepartment = D("ViewDepartment");
		$ViewUser = D("ViewUser");
		$ViewRoles = D("ViewRoles");
		$i=0;
		foreach($dat['OMlist'] as $v){
			if($v['parenttype'] == '分类')
				$d = $ViewCategory->where("`systemID` = '$v[parentID]'")->find();
			if($v['parenttype'] == '部门')
				$d = $ViewDepartment->where("`systemID` = '$v[parentID]'")->find();
			if($v['parenttype'] == '用户')
				$d = $ViewUser->where("`systemID` = '$v[parentID]'")->find();
			if($v['parenttype'] == '角色')
				$d = $ViewRoles->where("`systemID` = '$v[parentID]'")->find();
			if($v['roleslimitID'] != -1){
				$dd = $ViewRoles->where("`systemID` = '$v[roleslimitID]'")->find();
				$dat['OMlist'][$i]['roleslimit'] = $dd;
			}
			$dat['OMlist'][$i]['parent'] = $d;
			$i++;
		}
		$this->assign("dat",$dat);
		//分类
		$datas1 = $ViewCategory->findall();
		$this->assign("categoryAll",$datas1);
		//部门
		$datas2 = $ViewDepartment->findall();
		$this->assign("departmentAll",$datas2);
		//用户
		$datas3 = $ViewUser->findall();
		$this->assign("userAll",$datas3);
		//角色
		$datas4 = $ViewRoles->findall();
		$this->assign("rolesAll",$datas4);
		
		return $dat;
	 }

		
	//分类解析
     public function _fenlei_filter($dat) {
		$ViewCategory = D("ViewCategory");
		$ViewDepartment = D("ViewDepartment");
		$i=0;
		foreach($dat as $v){
			if($v['opentype'] == '分类')
				$d = $ViewCategory->where("`systemID` = '$v[openID]'")->find();
			if($v['opentype'] == '部门')
				$d = $ViewDepartment->where("`systemID` = '$v[openID]'")->find();
			$dat[$i]['title'] = $d['title'];
			$i++;
		}
		return $dat;
	 }
	
	
     public function _xianluOMlist($dataID,$datatype,$method) {
		$ViewSystemOM = D("ViewSystemOM");
		$dat['OMlist'] = $ViewSystemOM->where("`dataID` = '$dataID' and `datatype` = '$datatype'")->findall();
		for($i=0;$i<count($dat['OMlist']);$i++){
			if($dat['OMlist'][$i]['type'] != $method){
				unset($dat['OMlist'][$i]);
				continue;
			}
			if($dat['OMlist'][$i]['roleslimitID'] == -1){
				$dat['OMlist'][$i]['roleslimitID'] = '';
			}
		}
		$dat['OMlist'] = array_values($dat['OMlist']);
		return $this->_OMlist($dat);
	 
	 }
	 
	 
     public function _facade($classname,$data) {
		$class = D($classname);
		$DbFields = $class->getDbFields();
        // 检查非数据字段
        if(!empty($DbFields)) {
            foreach ($data as $key=>$val){
                if(!in_array($key,$DbFields,true)){
                    unset($data[$key]);
                }elseif(C('DB_FIELDTYPE_CHECK') && is_scalar($val)) {
                    // 字段类型检查
                    $this->_parseType($class,$data,$key);
                }
            }
        }
        return $data;
     }
	
	
    public function _parseType($class,&$data,$key) {
		$DbFields = $class->getDbFields();
        $fieldType = strtolower($DbFields['_type'][$key]);
        if(false === strpos($fieldType,'bigint') && false !== strpos($fieldType,'int')) {
            $data[$key]   =  intval($data[$key]);
        }elseif(false !== strpos($fieldType,'float') || false !== strpos($fieldType,'double')){
            $data[$key]   =  floatval($data[$key]);
        }elseif(false !== strpos($fieldType,'bool')){
            $data[$key]   =  (bool)$data[$key];
        }
		
        if(false !== strpos($fieldType,'varchar')) {
            $data[$key]   =  array('like','%'.$data[$key].'%');
		}
    }
	
	
    //搜索
    public function search_list($classname,$_GET,$pagenum = 20) {
		$where = $this->_facade($classname,$_GET);
		$class = D($classname);
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $class->where($where)->count();
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $data = $class->where($where)->limit($p->firstRow.','.$p->listRows)->select();
		$redata['page'] = $page;
		$redata['data'] = $data;
		return $redata;
	}
	
	
     public function unitlist() {
		$ViewCategory = D("ViewCategory");
		$ViewDepartment = D("ViewDepartment");
		$ViewUser = D("ViewUser");
		$ViewRoles = D("ViewRoles");
		//分类
		$datas1 = $ViewCategory->findall();
		$this->assign("categoryAll",$datas1);
		//部门
		$datas2 = $ViewDepartment->findall();
		$this->assign("departmentAll",$datas2);
		//用户
		$datas3 = $ViewUser->findall();
		$this->assign("userAll",$datas3);
		//角色
		$datas4 = $ViewRoles->findall();
		$this->assign("rolesAll",$datas4);
	 }
	
	//解析 部门 角色 分类 用户
     public function _facesystem(&$dat,$type) {
		$ViewDepartment = D("ViewDepartment");
		$ViewRoles = D("ViewRoles");
		if($type == '用户'){
			$i=0;
			foreach($dat as $v){
				$department = $ViewDepartment->where("`systemID` = '$v[bumenID]'")->find();
				$dat[$i]['department'] = $department;
				$roles = $ViewRoles->where("`systemID` = '$v[rolesID]'")->find();
				$dat[$i]['roles'] = $roles;
				$i++;
			}
		}
	 }
	 
	 
	//获得角色列表
     public function _getRolesList() {
		$ViewRoles = D("ViewRoles");
		//角色
		$datas4 = $ViewRoles->findall();
		return $datas4;
	 }
	 
	 
	//获得部门列表
     public function _getDepartmentList() {
		$ViewDepartment = D("ViewDepartment");
		//角色
		$datas2 = $ViewDepartment->findall();
		return $datas2;
	 }
	
	//获得用户部门角色列表
     public function _getDURlist($userID) {
		if($userID)
			$myuserID = $userID;
		else
			$myuserID = $this->user['systemID'];
		$SystemDUR = D("SystemDUR");
		$datas4 = $SystemDUR->where("`userID` = '$myuserID'")->findall();
		return $datas4;
	 }
	 
	//获得用户部门角色列表
     public function _getDURlist_name($user_name) {
		if(!$user_name)
			$user_name = $this->user['title'];
		$ViewUser = D("ViewUser");
		$user = $ViewUser->where("`title` = '$user_name'")->find();
		if($user){
			$SystemDUR = D("SystemDUR");
			$datas4 = $SystemDUR->where("`userID` = '$user[systemID]'")->findall();
			return $datas4;
		}
		return false;
	 }
	 
	//获得用户列表
     public function _getUserlist($bumenID,$rolesID) {
		$ViewSystemDUR = D("ViewSystemDUR");
		if($bumenID && $rolesID)
		$data = $ViewSystemDUR->Distinct(true)->field('userID')->where("`bumenID` = '$bumenID' and `rolesID` = '$rolesID'")->findall();
		elseif($bumenID)
		$data = $ViewSystemDUR->Distinct(true)->field('userID')->where("`bumenID` = '$bumenID'")->findall();
		elseif($rolesID)
		$data = $ViewSystemDUR->Distinct(true)->field('userID')->where("`rolesID` = '$rolesID'")->findall();
		return $data;
	 }
	 
	 
	//获得分类包含项列表
     public function _getDClist($systemID) {
		$System = D("System");
		$category = $System->relation("systemDClist")->where("`systemID` = '$systemID'")->find();
		return $category['systemDClist'];
	 }
	
	
	//同步DataOM:售价开放管理到对象
     public function _shoujiaToDataOM($data) {
		$DataOM = D("DataOM");
		$DataOM->where("`dataID` = '$data[chanpinID]' and `datatype` = '售价'")->delete();
		$OM['dataID'] = $data['chanpinID'];
		$OM['datatype'] = '售价';
		$OM['type'] = '开放';
		if($data['opentype'] == '分类'){
			$departmentlist = $this->_getDClist($data['openID']);
			foreach($departmentlist as $s){
				$OM['bumenID'] = $s['dataID'];
				$OM['DUR'] = _OMToDataOM_filter($OM);
				$DataOM->mycreate($OM);
			}
			return;
		}
		if($data['opentype'] == '部门'){
			$OM['bumenID'] = $data['openID'];
		}
		$OM['DUR'] = $this->_OMToDataOM_filter($OM);
		$DataOM->mycreate($OM);
	 }
	 
	 
	 
	
	//同步开放管理到对象
     public function _OMToDataOM($data) {
		$DataOM = D("DataOM");
		if($data['systemID']){
			$DataOM->where("`OMID` = '$data[systemID]' and `datatype` = '$data[datatype]'")->delete();
			$OM['OMID'] = $data['systemID'];
		}
		$OM['dataID'] = $data['dataID'];
		$OM['datatype'] = $data['datatype'];
		$OM['type'] = $data['type'];
		$OM['DUR'] = $data['DUR'];
		if($data['roleslimitID'] != '-1')
		$OM['rolesID'] = $data['roleslimitID'];
		if($data['parenttype'] == '分类'){
			$departmentlist = $this->_getDClist($data['parentID']);
			foreach($departmentlist as $s){
				unset($OM['userID']);
				$OM['bumenID'] = $s['dataID'];
				$OM['DUR'] = _OMToDataOM_filter($OM);
				$DataOM->mycreate($OM);
			}
			return;
		}
		if($data['parenttype'] == '部门'){
			unset($OM['userID']);
			$OM['bumenID'] = $data['parentID'];
		}
		if($data['parenttype'] == '用户'){
			unset($OM['bumenID']);
			unset($OM['rolesID']);
			$OM['userID'] = $data['parentID'];
		}
		if($data['parenttype'] == '角色'){
			unset($OM['bumenID']);
			unset($OM['userID']);
			$OM['rolesID'] = $data['parentID'];
		}
		if($data['parenttype'])
			$OM['DUR'] = $this->_OMToDataOM_filter($OM);
		$DataOM->mycreate($OM);
	 }
	
	//同步开放管理到对象
     public function _OMToDataOM_filter($data) {
		 return $data['bumenID'].','.$data['rolesID'].','.$data['userID'];
	 }
	
	//同步开放管理到对象,序列化关系数据
     public function _getRelation_select_after($data,$relation_name) {
		 if(false === $data)
		 return $data;
		 for($i=0;$i<count($data);$i++){
			 $nd = null;
			 foreach($data[$i] as $key => $val){
				 if($key == $relation_name)
				 foreach($data[$i][$relation_name] as $key => $val){
					 $nd[$key] = $val;
					 $j++;
				 }
				 $nd[$key] = $val;
			 }
			 $nnd[$i] = $nd;
		 }
		 return $nnd;
	 }
	 
	 
	//显示目录
     public function showDirectory($title) {
		$ViewDirectory = D("ViewDirectory");
		$nowDir = $ViewDirectory->where("`title` = '$title'")->find();
		$this->assign("nowDir",$nowDir);
		if($nowDir['url'])
		$str = '<a href="'.SITE_INDEX.$nowDir['url'].'">'.$nowDir['title'].'</a>';
		else
		$str = $nowDir['title'];
		while($nowDir['parentID'] != null)
		{
			$preDir = $ViewDirectory->where("`systemID` = '$nowDir[parentID]'")->find();
			$str = '<a href="'.SITE_INDEX.$preDir['url'].'">'.$preDir['title'].'</a>  >  ' . $str;
			$nowDir = $preDir;
		}
		$str = '<a href="javascript:window.history.back();">返回上一步 </a>  |  '. $str;
		
		$this->assign("navigation",$str);
	 }
	
	
	
	//同步开放管理到对象
     public function _ShenheToDataShenhe($data) {
		$DataShenhe = D("DataShenhe");
		$DataShenhe->where("`shenheID` = '$data[shenheID]'")->delete();
		$DS = null;
		$DS['shenheID'] = $data['systemID'];
		$DS['datatype'] = $data['datatype'];
		$DS['processID'] = $data['processID'];
		$DS['remark'] = $data['remark'];
		if($data['parenttype'] == '角色'){
			$DS['UR'] = $data['parentID'].',';
		}
		if($data['parenttype'] == '用户'){
			$DS['UR'] = ','.$data['parentID'];
		}
		$DataShenhe->mycreate($DS);
	 }
	

     public function _systemUnitFilter($datalist) {
		$ViewCategory = D("ViewCategory");
		$ViewDepartment = D("ViewDepartment");
		$ViewUser = D("ViewUser");
		$ViewRoles = D("ViewRoles");
		$i=0;
		foreach($datalist as $v){
			if($v['parenttype'] == '分类')
				$d = $ViewCategory->where("`systemID` = '$v[parentID]'")->find();
			if($v['parenttype'] == '部门')
				$d = $ViewDepartment->where("`systemID` = '$v[parentID]'")->find();
			if($v['parenttype'] == '用户')
				$d = $ViewUser->where("`systemID` = '$v[parentID]'")->find();
			if($v['parenttype'] == '角色')
				$d = $ViewRoles->where("`systemID` = '$v[parentID]'")->find();
			$datalist[$i]['title'] = $d['title'];
			$i++;
		}
		return $datalist;
	 }
	 
	 //数据备份：生成
     public function makefiledatacopy($dataID,$datatype,$taskID) {
	 	if($datatype == '线路'){
			$ViewXianlu = D('ViewXianlu');
			$data['xianlu'] = $ViewXianlu->where("`chanpinID` = '$dataID'")->find();
			$ViewXingcheng = D('ViewXingcheng');
			$data['xingcheng'] = $ViewXingcheng->where("`parentID` = '$dataID'")->findall();
			$ViewChengben = D('ViewChengben');
			$data['chengben'] = $ViewChengben->where("`parentID` = '$dataID'")->findall();
			$ViewShoujia = D('ViewShoujia');
			$data['shoujia'] = $ViewShoujia->where("`parentID` = '$dataID'")->findall();
			
			$data['copy'] = serialize($data);
			$DataCopy = D('DataCopy');
			$data['dataID'] = $dataID;
			$data['datatype'] = $datatype;
			$data['taskID'] = $taskID;
			$DataCopy->myCreate($data);
		}
	 }
	 
	 
	//审核任务
	//生成待检出	
	//检查审核流程
     public function _shenheDO($_REQUEST,$dotype='') {
		//检查OM
		$omdata = $this->_checkDataOM($_REQUEST['dataID'],$_REQUEST['datatype'],'管理');
		if(false === $omdata){
			cookie('errormessage','您没有产品操管理权限！',30);
			return false;
		}
		$data = $_REQUEST;
		$data['taskShenhe'] = $_REQUEST;
		if($dotype == '申请'){
			$processID = 1;
			if($this->_checkShenhe($_REQUEST['datatype'],$processID+1)){
				$data['status'] = '申请';
				cookie('successmessage','提交审核成功！',30);
			}
			else{
				$data['status'] = '批准';
				cookie('successmessage','操作成功！'.$data['status'],30);
			}
		}
		else{
			$need = $this->_checkTaskDJC($_REQUEST['dataID'],$_REQUEST['datatype']);
			$processID = $need['processID'];
			$data['systemID'] = $need['systemID'];
			if($this->_checkShenhe($_REQUEST['datatype'],$processID+1))
			$data['status'] = '检出';
			else
			$data['status'] = '批准';
			cookie('successmessage','操作成功！'.$data['status'],30);
		}
		//检查流程状态
		$process = $this->_checkDataShenhe($_REQUEST['dataID'],$_REQUEST['datatype'],$data['status'],$processID);
		if(false === $process){
			cookie('errormessage','错误！该产品流程不存在或已被执行，请勿重复执行！',30);
			return false;
		}
		$data['taskShenhe']['processID'] = $processID;
		$data['taskShenhe']['remark'] = $process[0]['remark'];
		$data['taskShenhe']['roles_copy'] = $omdata['roles'];
		$data['taskShenhe']['bumen_copy'] = $omdata['bumen'];
		//审核任务
		$System = D("System");
		if (false === $System->relation("taskShenhe")->myRcreate($data)){
			cookie('errormessage','错误，操作失败！'.$System->getError(),30);
			return false;
		}
		$to_dataID = $System->getRelationID();
		//生成数据备份
		if($data['status'] == '批准'){
			$this->makefiledatacopy($_REQUEST['dataID'],$_REQUEST['datatype'],$to_dataID);
		}
		$to_dataomlist = $this->_getDataOM($data['dataID'],$data['datatype'],'管理');
		//生成待检出	
		$process = $this->_checkShenhe($data['datatype'],$processID+1);
		if($process){
			$data['status'] = '待检出';
			if($processID == 1)
				$data['parentID'] = $to_dataID;
			else
				$data['parentID'] = $need['parentID'];
			$data['taskShenhe']['remark'] = $process[0]['remark'];
			$data['taskShenhe']['processID'] = $processID+1;
			unset($data['taskShenhe']['roles_copy']);
			unset($data['taskShenhe']['bumen_copy']);
			$System->relation("taskShenhe")->myRcreate($data);
			$dshID = $System->getRelationID();
			//生成待检出OM
			$DataOM = D("DataOM");
			foreach($to_dataomlist as $vo){
				list($om_bumen,$om_roles,$om_user) = split(',',$vo['DUR']);
				$to_dataom['type'] = '管理';
				$to_dataom['dataID'] = $dshID;
				$to_dataom['datatype'] = '审核任务';
				foreach($process as $p){
					$to_dataom['DUR'] = $om_bumen.','.$p['UR'];
					$DataOM->mycreate($to_dataom);
					//返回需要提示的用户
					$userIDlist = $this->_getuserlistByDUR($to_dataom['DUR']);	
					$userIDlist = array_merge($userIDlist,$userIDlist);
					$userIDlist = array_unique($userIDlist);
					
				}
			}
		}
		else{
			foreach($to_dataomlist as $vo){
				//返回需要提示的用户
				$userIDlist = $this->_getuserlistByDUR($vo['DUR']);	
				$userIDlist = array_merge($userIDlist,$userIDlist);
				$userIDlist = array_unique($userIDlist);
			}
		}
		return $userIDlist;
	 }
	
	
	//获得审核流程
     public function _getdatashenhe($datatype) {
		$DataShenhe = D("DataShenhe");
		$data =  $DataShenhe->where("`datatype` = '$datatype'")->findall();
		return $data;
	 }
	
	//获得产品OM
     public function _getOM($dataID,$datatype,$type) {
		$DataOM = D("SystemOM");
		$data = $DataOM->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `type` = '$type'")->findall();
	 	return $data;
	 }
	 
	 
	//获得DataOM
     public function _getDataOM($dataID,$datatype,$type) {
		$DataOM = D("DataOM");
		$data = $DataOM->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `type` = '$type'")->findall();
	 	return $data;
	 }
	 
	 
	//检查数据审核任务OM
     public function _checkDataShenheOM($dataID,$datatype) {
	 	//流程
		$process = $this->_checkTaskDJC($dataID,$datatype);
		if(false !== $process){
			$omdata = $this->_checkDataOM($process['dataID'],$process['datatype'],'管理');
			if(false !== $omdata)
				return $omdata;
		}
		return false;
	 }
	 
	 
	//检查OM
     public function _checkDataOM($dataID,$datatype,$type,$userID) {
		if($userID)
			$myuserID = $userID;
		else
			$myuserID = $this->user['systemID'];
		$DURlist = $this->_getDURlist($myuserID);
		$DataOM = D("DataOM");
		$datalist = array();
		$where['dataID'] = $dataID;
		$where['datatype'] = $datatype;
		if($type == '管理')
		$where['type'] = '管理';
		else
		$where['type'] = array('in','开放,管理');
		foreach($DURlist as $v){
			$where['DUR'] = $v['departmentID'].',,';
			$OMlist = $DataOM->Distinct(true)->field('dataID')->where($where)->find();
			if(!$OMlist){
				$where['DUR'] = $v['departmentID'].','.$v['rolesID'].',';
				$OMlist = $DataOM->Distinct(true)->field('dataID')->where($where)->find();
			}
			if(!$OMlist){
				$where['DUR'] = ','.$v['rolesID'].',';
				$OMlist = $DataOM->Distinct(true)->field('dataID')->where($where)->find();
			}
			if(!$OMlist){
				$where['DUR'] = ',,'.$v['userID'];
				$OMlist = $DataOM->Distinct(true)->field('dataID')->where($where)->find();
			}
			if($OMlist){
				$ViewRoles = D("ViewRoles");
				$roles = $ViewRoles->where("`systemID` = '$v[rolesID]'")->find();
				$ViewDepartment = D("ViewDepartment");
				$bumen = $ViewDepartment->where("`systemID` = '$v[departmentID]'")->find();
				$omdata['roles'] = $roles['title'];
				$omdata['bumen'] = $bumen['title'];
				$omdata['departmentID'] = $bumen['systemID'];
				
				cookie('_usedbumenID',$bumen['systemID'],30);
				cookie('_usedrolesID',$roles['systemID'],30);
				cookie('_usedbumen',$bumen['title'],30);
				cookie('_usedroles',$roles['title'],30);
				cookie('_usedbumenaddr',$bumen['addr'],30);
				cookie('_usedbumenfax',$bumen['fax'],30);
				
				return $omdata;
			}
		}
		return false;
	 }
	 
	 
	//检查审核流程
     public function _checkShenhe($datatype,$processID,$userID='') {
		$DataShenhe = D("DataShenhe");
		if($userID){
			$myuserID = $userID;
			$DURlist = $this->_getDURlist($myuserID);
			foreach($DURlist as $v){
				$UR = $v['rolesID'].',';
				$shenhe = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '$processID' and `UR` = '$UR'")->find();
				if($shenhe != null)
					return $shenhe;
				$UR = ','.$v['userID'];
				$shenhe = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '$processID' and `UR` = '$UR'")->find();
				if($shenhe != null)
					return $shenhe;
			}
		}
		else{
			$shenheAll = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '$processID'")->findall();
			if($shenheAll != null)
				return $shenheAll;
		}
		return false;
		
	 }
	 
	 
	//检查流程状态待检出
     public function _checkTaskDJC($dataID,$datatype) {
		$ViewTaskShenhe = D("ViewTaskShenhe");
		if($processID == ''){
		  $need = $ViewTaskShenhe->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `status` = '待检出'")->find();
		  return $need;
		}
		return false;
	 }
	 
	 
	 
	//检查流程状态
     public function _checkDataShenhe($dataID,$datatype,$status,$processID) {
		$ViewTaskShenhe = D("ViewTaskShenhe");
		//检查审核流程权限
		$process = $this->_checkShenhe($datatype,$processID);
		if(!$process)
			return false;
		$has = $ViewTaskShenhe->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `processID` = '1'")->findall();
		if($processID == 1){
			$process2 = $this->_checkShenhe($datatype,2);
			if(!$process2)
				return $process;
			else	
			foreach($has as $vol){
				$ov = $ViewTaskShenhe->where("`parentID` = '$vol[systemID]' and `status` = '批准' ")->find();
				if(!$ov)
				return false;
			}
			return $process;
		}
		else{
			foreach($has as $vol){
				$ov = $ViewTaskShenhe->where("`parentID` = '$vol[systemID]' and `status` = '批准' ")->find();
				if(!$ov){
					$pro = $ViewTaskShenhe->where("`parentID` = '$vol[systemID]' and `status` = '$status' and `processID` = '$processID'")->find();
					if($pro)
					return false;
				}
			}
			return $process;
		}
	 }
		 
		 
	//历史记录
     public function _setMessageHistory($dataID,$datatype,$message='',$url='',$userIDlist) {
		$data['infohistory']['message'] = cookie('_usedbumen').cookie('_usedroles').'"'.$this->user['title'].'":'.$message;
		$data['infohistory']['usedDUR'] = cookie('_usedbumenID').','.cookie('_usedrolesID').','.$this->user['systemID'];
		$data['infohistory']['dataID'] = $dataID;
		$data['infohistory']['datatype'] = $datatype;
		$data['infohistory']['url'] = $url;
		$Message = D("Message");
		if (false !== $Message->relation("infohistory")->myRcreate($data)){
			if($Message->getLastmodel() == 'add')
				$data['messageID'] = $Message->getRelationID();
		}
		//生成OM
		$dataOMlist = $this->_getDataOM($dataID,$datatype,'管理');
		$this->_createDataOM($data['messageID'],'消息','管理',$dataOMlist);
		$this->_OMToDataNotice($data['infohistory'],$userIDlist);
	}
	
	
		 
	//生成OM
     public function _createDataOM($dataID,$datatype,$type,$dataOMlist = '') {
		$dom['type'] = $type;
		$dom['datatype'] = $datatype;
		$dom['dataID'] = $dataID;
		$DataOM = D("DataOM");
		foreach($dataOMlist as $d){
			$dom['DUR'] = $d["DUR"];
			$DataOM->mycreate($dom);
		}
		$dom['DUR'] = ',,'.$this->user['systemID'];
		$DataOM->mycreate($dom);
	 }
		 
		 
		 
	
	//根据DUR获得提示用户列表
     public function _getuserlistByDUR($DUR) {
		list($bumen,$roles,$user) = split(',',$DUR);
		if($roles)
			$userIDlist = $this->_getUserlist($bumen,$roles);
		elseif($user)
			$userIDlist[0]['userID'] = $user;
		else
			$userIDlist = $this->_getUserlist($bumen);
		return $userIDlist;
	 }
	
		 
		 
	//同步提示信息
     public function _OMToDataNotice($data,$userIDlist) {
		$DataNotice = D("DataNotice");
		foreach($userIDlist as $v){
			if($v['userID']){
				$data['userID'] = $v['userID'];
				$DataNotice->mycreate($data);
			}
		}
	 }
	
		 
		 
	// 文件上传 
    public function _upload($savePath) { 
        import("@.ORG.UploadFile"); 
        //导入上传类 
        $upload = new UploadFile(); 
        //设置上传文件大小 
        $upload->maxSize = 3292200; 
        //设置上传文件类型 
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg'); 
        //设置附件上传目录 
        $upload->savePath = $savePath; 
        //设置需要生成缩略图，仅对图像文件有效 
        $upload->thumb = true; 
        // 设置引用图片类库包路径 
        $upload->imageClassPath = '@.ORG.Image'; 
        //设置需要生成缩略图的文件后缀 
        $upload->thumbPrefix = 'm_,s_';  //生产2张缩略图 
        //设置缩略图最大宽度 
        $upload->thumbMaxWidth = '400,100'; 
        //设置缩略图最大高度 
        $upload->thumbMaxHeight = '400,100'; 
        //设置上传文件规则 
        $upload->saveRule = uniqid; 
        //删除原图 
        $upload->thumbRemoveOrigin = true; 
		
        if (!$upload->upload()) { 
            //捕获上传异常 
            return false; 
        } else { 
		
            //取得成功上传的文件信息 
            $uploadList = $upload->getUploadFileInfo(); 
            import("@.ORG.Image"); 
            //给m_缩略图添加水印, Image::water('原文件名','水印图片地址') 
            Image::water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], '/Public/myerp/images/logo.png');
            $_POST['image'] = $uploadList[0]['savename']; 
        } 
		return $_POST['image'];
    } 
		 
		 
		 
		 
    /**
     +----------------------------------------------------------
     * Ajax上传页面返回信息
     +----------------------------------------------------------
     */
    public function ajaxUploadResult($data,$info='',$status=1,$type='')
    {
        // Ajax方式附件上传提示信息设置
        // 默认使用mootools opacity效果
        $show   = '<script language="JavaScript" src="'.WEB_PUBLIC_PATH.'/myerp/Thinkjs/mootools.js"></script><script language="JavaScript" type="text/javascript">'."\n";
        $show  .= ' var parDoc = window.parent.document;';
		
        if(isset($data['uploadFormId'])) {
                $show  .= ' parDoc.getElementById("'.$data['uploadFormId'].'").reset();';
        }
		
        // 保证AJAX返回后也能保存日志
        if(C('LOG_RECORD')) Log::save();
        $result  =  array();
        $result['status']  =  $status;
        $result['info'] =  $info;
        $result['data'] = $data;
        if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
        if(strtoupper($type)=='JSON') {
            // 返回JSON数据格式到客户端 包含状态信息
            header("Content-Type:text/html; charset=utf-8");
            $msg = json_encode($result);
        }elseif(strtoupper($type)=='XML'){
            // 返回xml格式数据
            header("Content-Type:text/xml; charset=utf-8");
            $msg = xml_encode($result);
        }elseif(strtoupper($type)=='EVAL'){
            // 返回可执行的js脚本
            header("Content-Type:text/html; charset=utf-8");
            $msg = $data;
        }else{
            // TODO 增加其它格式
        }
		
		if(isset($data['uploadResponse'])) {
			$show  .= 'window.parent.'.$data['uploadResponse'].'(\''.$msg.'\');';
		}
		
        $show .= "\n".'</script>';
        exit($show);
        return ;
	}

		 
	//同步RBAC
     public function _opentoRBAC($user) {
		import ( '@.ORG.Util.RBAC' );
		session(null);
		session(C('USER_AUTH_KEY'),$user['systemID']);
		if($user['title']=='aaa' || $user['title'] == 'kkk' || $user['title'] == 'zhangwen') {
			session(C('ADMIN_AUTH_KEY'),true);
		}
		// 缓存访问权限
		RBAC::saveAccessList();
	 }
	 
		 
/*		 
	//同步RBAC角色组
     public function _opentoRBACbyUser($userID,$rolesID) {
		$ViewRoles = D("ViewRoles");
		$role = $ViewRoles->where("`systemID` = '$rolesID'")->find();
		 
		$group_role    =   M("think_role_user");
		$group_role->where("``")->find();
		
		$group_user    =   M("think_role_user");
        $id     = $_POST['userGroupId'];
		$group_user    =   D("Role_user");
		$group_user->where("`user_id` = $userId")->delete();
		foreach($id as $groupId){
			$datas['role_id'] = $groupId;
			$datas['user_id'] = $userId;
			$result = $group_user->add($datas);
		}
	 }
*/	 
	 
	 //生成团员
     public function createCustomer_new($_REQUEST,$dingdanID) {
		//检查dataOM
		$omdingdan = A('Method')->_checkDataOM($dingdanID,'订单');
		if(false === $omdingdan){
			$this->display('Index:error');
			exit;
		}
		//检查dataOM
		$omxiaoshou = A('Method')->_checkDataOM($_REQUEST['shoujiaID'],'售价');
		if(false === $omxiaoshou){
			$this->display('Index:error');
			exit;
		}
		$Chanpin = D("Chanpin");
		$shoujia = $Chanpin->relation("shoujia")->where("`chanpinID` = '$_REQUEST[shoujiaID]'")->find();
		$ViewDingdan = D("ViewDingdan");
		$dingdan = $ViewDingdan->where("`chanpinID` = '$dingdanID'")->find();
		$DataCD = D("DataCD");
		$ViewCustomer = D("ViewCustomer");
		$cus['dingdanID'] = $dingdanID;
		$DataCD->startTrans();
		//清空订单内客户,并重新生成
		$DataCD->where("`dingdanID` = '$dingdanID'")->delete();
		for($i = 0; $i < $dingdan['chengrenshu'] + $dingdan['ertongshu'] + $dingdan['lingdui_num'];$i++){
			$id = $i+1;
			$cus['name'] = $_REQUEST['name'.$id];
			$cus['manorchild'] = $_REQUEST['manorchild'.$id];
			$cus['sex'] = $_REQUEST['sex'.$id];
			$cus['zhengjiantype'] = $_REQUEST['zhengjiantype'.$id];
			$cus['zhengjianhaoma'] = $_REQUEST['zhengjianhaoma'.$id];
			$cus['telnum'] = $_REQUEST['telnum'.$id];
			if($custmoer = $ViewCustomer->where("`zhengjiantype` = '$cus[zhengjiantype]' and `zhengjianhaoma` = '$cus[zhengjianhaoma]'")->find()){
				$cus = array_merge($custmoer,$cus);
				$cus['datatext'] = serialize($custmoer);
			}
			$cus['price'] = $_REQUEST['price'.$id];
			//价格判断
			if($cus['manorchild'] == '成人')
			if($shoujia['shoujia']['adultprice'] - $shoujia['shoujia']['cut'] > $cus['price']){
				cookie('errormessage','团员'.$cus['name'].'应付超过可折扣范围！',30);
				$DataCD->rollback();
				return false;
			}
			if($cus['manorchild'] == '儿童')
			if($shoujia['shoujia']['childprice'] - $shoujia['shoujia']['cut'] > $cus['price']){
				cookie('errormessage','团员'.$cus['name'].'应付超过可折扣范围！',30);
				$DataCD->rollback();
				return false;
			}
			$jiage += $cus['price'];
			$cus['remark'] = $_REQUEST['remark'.$id];
			if (false === $DataCD->mycreate($cus)){
				cookie('errormessage','错误，请联系管理员！',30);
				$DataCD->rollback();
				return false;
			}
		}
		$DataCD->commit();
		//反补订单信息
		$Chanpin = D("Chanpin");
		$data['chanpinID'] = $dingdanID;
		$data['dingdan']['jiage'] = $jiage;
		$Chanpin->relation("dingdan")->myRcreate($data);
	 	return true;
	 
	 }
	 
	 
	 
		//清空占位过期订单
     public function _cleardingdan() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$zhanwei = $Chanpin->where("`marktype` = 'dingdan' and `status` = '占位'")->findall();
		$t = 60*60*24*2;//2天
		 foreach($zhanwei as $v){
			 if(time() - $v['time'] > $t)
			 $v['status'] = '候补';
			 $Chanpin->mycreate($v);
		 }
	 }
	 
	 
	 
		//计算剩余名额
     public function _getzituandingdan($zituanID,$shoujiaID) {
		$Chanpin = D("Chanpin");
		$dingdanlist = $Chanpin->relation("dingdanlist")->where("`chanpinID` = '$zituanID'")->find();
		foreach($dingdanlist['dingdanlist'] as $dd){
			$data['baomingrenshu'] += $dd['chengrenshu'] + $dd['ertongshu'] + $dd['lingdui_num'];
			$data['baomingjiage'] += $dd['jiage'];
			//计算开放的人数
			if($shoujiaID && $dd['shoujiaID'] != $shoujiaID){
				continue;
			}
			$data['shoujiarenshu'] += $dd['chengrenshu'] + $dd['ertongshu'] + $dd['lingdui_num'];
			$data['shoujiajiage'] += $dd['jiage'];
			$data['chengrenshu'] +=$dd['chengrenshu'];
			$data['lingduirenshu'] +=$dd['lingdui_num'];
			$data['ertongrenshu'] +=$dd['ertongshu'];
			if($dd['status'] == '确认')
			$data['querenrenshu'] += $dd['chengrenshu'] + $dd['ertongshu'] + $dd['lingdui_num'];
			if($dd['status'] == '占位')
			$data['zhanweirenshu'] += $dd['chengrenshu'] + $dd['ertongshu'] + $dd['lingdui_num'];
			if($dd['status'] == '候补')
			$data['houburenshu'] += $dd['chengrenshu'] + $dd['ertongshu'] + $dd['lingdui_num'];
		}
		return $data;
	 }
	 
	 
	 //文件生成
	public function _data_exports($chanpinID,$type) {
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$chanpinID'")->find();
		$ViewDingdan = D("ViewDingdan");
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->where("`parentID` = '$chanpinID'")->findall();
		$i = 0;
		foreach($dingdanlist as $v){
			foreach($v['tuanyuanlist'] as $vol){
				$tuanyuan[$i] = $vol;
				$tuanyuan[$i]['bumen'] = $v['bumen_copy'].'-'.$v['user_name'];
				$i++;
			}
		}
		$mingcheng = $zituan['xianlulist']['title'];
		$tuanhao = $zituan['tuanhao'];
		$tianshu = $zituan['xianlulist']['tianshu'];
		$chutuanriqi = $zituan['chutuanriqi'];
		$this->assign('mingcheng',$mingcheng);
		$this->assign('tuanhao',$tuanhao);
		$this->assign('tianshu',$tianshu);
		$this->assign('chutuanriqi',$chutuanriqi);
		$this->assign('tuanyuan',$tuanyuan);
		$title = '团员名单--'.$mingcheng.'--'.$chutuanriqi;
		if($type == '格式3'){	
			//导出Excel必备头
			header("Content-type:application/vnd.ms-excel");
			header("Content-Disposition:attachment;filename=" . $title . ".xls");
			$this->display("Chanpin:exports_1");
		}
		else
		if($type == '格式2'){	
			//导出Word必备头
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . $title . ".doc");
			header("Pragma:no-cache");        
			header("Expires:0"); 
			$this->display("Chanpin:exports_1");
		}
		else
		if($type == '格式1'){	
			$this->exports_1($chanpinID,$type);
		}
	}
	 
	 
	
	public function exports_1($chanpinID,$type) {
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$chanpinID'")->find();
		$ViewDingdan = D("ViewDingdan");
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->where("`parentID` = '$chanpinID'")->findall();
		$i = 0;
		foreach($dingdanlist as $v){
			foreach($v['tuanyuanlist'] as $vol){
				$tuanyuan[$i] = $vol;
				if($vol['sex'] == '男')
				$man_num++;
				if($vol['sex'] == '女')
				$woman_num++;
				if($vol['manorchild'] != '领队')
				$tuanyuan_num++;
				else
				$leader = $vol;
				$i++;
			}
		}
		$page_num = ceil ($tuanyuan_num / 20);
		
		$t = 0;
		$m = 0;
		foreach($tuanyuan as $v){
			$renyuan[$t] = $v;
			$t++;
			$m++;
			if($t%20 == 0){
				$t = 0;
				$dataren[$m/20] = $renyuan;
			}
		}
		$dataren[$m/20] = $renyuan;
		
		//把所有的数据按页数分割
		$page = 0;
		while($page < $page_num){
			$start_pos = $page*20;
			$tuanyuan_part[$page] = $dataren[$page];
			$page++;
		}
		$this->assign('tuanyuan_part',$tuanyuan_part);
		$this->assign('leader',$leader);
		$this->assign('man_num',$man_num);
		$this->assign('woman_num',$woman_num);
		$this->assign('num' ,$tuanyuan_num + 1);
		$this->assign('page_num',$page_num);
		
		$mingcheng = $zituan['xianlulist']['title'];
		$tuanhao = $zituan['tuanhao'];
		$tianshu = $zituan['xianlulist']['tianshu'];
		$chutuanriqi = $zituan['chutuanriqi'];
		$chufadi = $zituan['xianlulist']['chufadi'];
		$chufashijian = explode('-',$chutuanriqi);
		$jieshushijian = explode('-',jisuanriqi($zituan['chutuanriqi'],$xianlu['xianlu']['tianshu']));
		$this->assign('chufashijian',$chufashijian);
		$this->assign('jieshushijian',$jieshushijian);
		$this->assign('chufadi',$chufadi);
		$this->assign('mingcheng',$mingcheng);
		$this->assign('tuanhao',$tuanhao);
		$this->assign('tianshu',$tianshu);
		$this->assign('chutuanriqi',$chutuanriqi);
		$this->assign('tuanyuan',$tuanyuan);
		$title = '团员名单(旅游局格式)--'.$mingcheng.'--'.$chutuanriqi;
		
		//导出Word必备头
		header("Content-type:application/msword");
		header("Content-Disposition:attachment;filename=" . $title . ".doc");
		header("Pragma:no-cache");        
		header("Expires:0");    
		
		$this->display("Chanpin:exports_2");
	}

	 
	 
	 
	 
}
?>