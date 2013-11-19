<?php

class MethodAction extends CommonAction{
	
    public function _initialize() {
		if($_REQUEST['_URL_'][0] == 'Method'){
			$this->display('Index:error');
			exit;
		}
	}
	
	
    //DataOM显示列表
    public function getDataOMlist($datatype,$relation,$where,$type='管理',$pagenum = 20,$ajaxdiv='',$distinctfield='') {
		
		//优化查询
		if(!$where){
			$class_name = 'DataOM';
			$order = 'dataID desc';
		}
		
		if($datatype == '审核任务'){
			$class_name = 'OMViewTaskShenhe';
			$where = $this->_orderShenheTask($where,$datatype,$relation);
			if($relation == 'baozhangitem'){
				$relation = 'taskshenhe';
				$order = 'tuanqi_copy desc';
			}
			if($relation == 'baozhang'){
				$relation = 'taskshenhe';
				$order = 'tuanqi_copy desc';
			}
		}
		if($datatype == '售价'){
			$class_name = 'OMViewShoujia';
			if($where['chanpintype'] == ''){
				$where['chanpintype'] = '线路';
			}
			$where['xianlu_status'] = '报名';
			//处理搜索
			if($where['title']){
				$where['xianlu_title'] = array('like','%'.$where['title'].'%');
			}
			if($where['chutuanriqi']){
				$where['xianlu_chutuanriqi'] = array('like','%'.$where['chutuanriqi'].'%');
			}
			if($where['start_time'] && $where['end_time']){
				$datelist = NF_getdatelistbetweentwodate($where['start_time'],$where['end_time'],"array");
				$i = 0;
				foreach($datelist as $v){
					$where['xianlu_chutuanriqi'][$i][0] = 'like';
					$where['xianlu_chutuanriqi'][$i][1] = '%'.$v.'%';
					$i++;
				}
				$where['xianlu_chutuanriqi'][$i] = 'or';
			}
			$where['datatype'] = $datatype;
		}
		if($datatype == '线路'){
			//优化查询
			if($where){
				$class_name = 'OMViewXianlu';
				$where = $this->_orderXianlu($where,$datatype);
			}
			$where['datatype'] = $datatype;
		}
		if($datatype == '订单'){
			//优化查询
			if($where){
				$class_name = 'OMViewDingdan';
				$where = $this->_orderDingdan($where,$datatype);
			}
			$where['datatype'] = $datatype;
		}
		if($datatype == '子团'){
			//优化查询
			if($where){
				$class_name = 'OMViewZituan';
				$order = 'chutuanriqi desc';
				$where = $this->_orderZituan($where,$datatype);
			}
			$where['datatype'] = $datatype;
		}
		if($datatype == '地接'){
			//优化查询
			if($where){
				$class_name = 'OMViewDJtuan';
				$where = $this->_orderDijie($where,$datatype);
				$order = 'jietuantime desc';
			}
			$where['datatype'] = $datatype;
		}
		if($datatype == '报账单'){
			//优化查询
			if($where){
				$class_name = 'OMViewBaozhang';
				if($where['user_name'])
					$where['user_name'] = array('like','%'.$where['user_name'].'%');
				if($where['title'])
					$where['title'] = array('like','%'.$where['title'].'%');
				if($where['shenhe_remark'])
					$where['shenhe_remark'] = array('like','%'.$where['shenhe_remark'].'%');
				if($where['type'] == '单项服务')
					$where['type'] = array('neq','团队报账单');
			}
			$where['datatype'] = $datatype;
		}
		if($datatype == '消息'){
			$class_name = 'OMViewInfohistory';
			$where['message'] = array('like','%'.$where['title'].'%');
			unset($where['title']);
			$where['datatype'] = $datatype;
		}
		if($datatype == '公告'){
			$class_name = 'OMViewInfo';
			$where['type'] = $datatype;
			$where['title'] = array('like','%'.$where['title'].'%');
			$where['datatype'] = $datatype;
		}
		if($datatype == '排团表'){
			$class_name = 'OMViewInfo';
			$where['type'] = $datatype;
			$where['title'] = array('like','%'.$where['title'].'%');
			$order = 'sortvalue desc,time desc';
			$where['datatype'] = $datatype;
		}
		if($datatype == '签证'){
			//优化查询
			if($where){
				$class_name = 'OMViewQianzheng';
				$where['title'] = array('like','%'.$where['title'].'%');
			}
			$where['datatype'] = $datatype;
		}
		//查询状态下有效
		if($where['status_system'] != -1)
			$where['status_system'] =  array('eq',1);//默认
			
		if($type == '开放')
			$type = array(array('eq','管理'),array('eq','开放'), 'or');
		else
			$type = '管理';
		if($datatype == '报账单' ||$datatype == '售价' || $datatype == '公告' || $datatype == '排团表' || $datatype == '订单')
			$where['omtype'] = $type;
		else
			$where['type'] = $type;
		$where = $this->_facade($class_name,$where);//过滤搜索项
		$where = $this->_openAndManage_filter($where);
//		if($status_system != -1)
//		$where .= "AND (`status_system` = '1')";
		$DataOM = D($class_name);
		if(!$distinctfield)
		$distinctfield = 'dataID';
		if($ajaxdiv)
        import("@.ORG.OldPage");
		else
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$tempcount = $DataOM->Distinct(true)->field($distinctfield)->where($where)->findall();
		$count = count($tempcount);
		$p= new Page($count,$pagenum);
		if($ajaxdiv)
		$page = $p->show_ajax($ajaxdiv);
		else
		$page = $p->show();
		if(!$order)
			$order = 'time desc';
        $chanpin = $DataOM->relation($relation)->Distinct(true)->field($distinctfield)->where($where)->limit($p->firstRow.','.$p->listRows)->order($order)->select();
		$chanpin = $this->_getRelation_select_after($chanpin,$relation);
		$redata['page'] = $page;
		$redata['chanpin'] = $chanpin;
		//关键字高亮
		return $this->_keyStar($redata,$_REQUEST);
	}
	
	
	//关键字高亮
    public function _keyStar($redata,$_REQUEST) {
		$i = 0;
		if($_REQUEST['title'] || $_REQUEST['tuanhao']){
			  foreach($redata['chanpin'] as $v){
				  if($_REQUEST['title']){
					  $str = '<strong style="color:red">'.$_REQUEST['title'].'</strong>';
					  $v['title_copy'] = str_ireplace($_REQUEST['title'],$str,$v['title_copy']);
					  $v['title'] = str_ireplace($_REQUEST['title'],$str,$v['title']);
				  }
				  if($_REQUEST['tuanhao']){
					  $str = '<strong style="color:red">'.$_REQUEST['tuanhao'].'</strong>';
					  $v['tuanhao'] = str_ireplace($_REQUEST['tuanhao'],$str,$v['tuanhao']);
				  }
				  $redata['chanpin'][$i] = $v;
				  $i++;
			  }
		}
		if($_REQUEST['baozhangtitle_copy'] || $_REQUEST['tuanhao_copy']){
			  foreach($redata['chanpin'] as $v){
				  if($_REQUEST['baozhangtitle_copy']){
					  $str = '<strong style="color:red">'.$_REQUEST['baozhangtitle_copy'].'</strong>';
					  $v['baozhangtitle_copy'] = str_ireplace($_REQUEST['baozhangtitle_copy'],$str,$v['baozhangtitle_copy']);
					  $v['tuantitle_copy'] = str_ireplace($_REQUEST['baozhangtitle_copy'],$str,$v['tuantitle_copy']);
				  }
				  if($_REQUEST['tuanhao_copy']){
					  $str = '<strong style="color:red">'.$_REQUEST['tuanhao_copy'].'</strong>';
					  $v['tuanhao_copy'] = str_ireplace($_REQUEST['tuanhao_copy'],$str,$v['tuanhao_copy']);
				  }
				  $redata['chanpin'][$i] = $v;
				  $i++;
			  }
		}
		return $redata;
	}
	
	//定制线路搜索条件
    public function _orderXianlu($where,$datatype) {
		//处理搜索
		if($where['start_time'] && $where['end_time']){
			$datelist = NF_getdatelistbetweentwodate($where['start_time'],$where['end_time'],"array");
			$i = 0;
			foreach($datelist as $v){
				$where['chutuanriqi'][$i][0] = 'like';
				$where['chutuanriqi'][$i][1] = '%'.$v.'%';
				$i++;
			}
			$where['chutuanriqi'][$i] = 'or';
		}
		if($where['chutuanriqi'])
			$where['chutuanriqi'] = array('like','%'.$where['chutuanriqi'].'%');
		if($where['user_name'])
			$where['user_name'] = array('like','%'.$where['user_name'].'%');
		if($where['title'])
			$where['title'] = array('like','%'.$where['title'].'%');
		if($where['mudidi'])
			$where['mudidi'] = array('like','%'.$where['mudidi'].'%');
		if($where['chufadi'])
			$where['chufadi'] = array('like','%'.$where['chufadi'].'%');
		return $where;
	}
	
	
	//定制订单搜索条件
    public function _orderDingdan($where,$datatype) {
		//处理搜索
		if($where['tuanqi_copy']){
			if($where['title'])
				$where['title'] = array(array('like',$where['title']),array('like',$where['tuanqi_copy']));
			else
				$where['title'] = $where['tuanqi_copy'];
		}
		$where['title'] = array('like','%'.$where['title'].'%');
		if($where['start_time'] && $where['end_time']){
			$where['time'] = array('between',"'".strtotime($where['start_time']).",".strtotime($where['end_time'])."'");
		}
		if($where['lianxiren'])
			$where['lianxiren'] = array('like','%'.$where['lianxiren'].'%');
		if($where['owner'])
			$where['owner'] = array('like','%'.$where['owner'].'%');
		if($where['remark'])
			$where['remark'] = array('like','%'.$where['remark'].'%');
		return $where;
	}
	
	//定制子团搜索条件
    public function _orderZituan($where,$datatype) {
		//处理搜索
		if($where['bzd_status'] == '未报账')
			$where['status_baozhang'] = array('neq','批准');
		if($where['bzd_status'] == '已报账')
			$where['status_baozhang'] = array('eq','批准');
		if($where['start_time'] && $where['end_time']){
			$where['chutuanriqi'] = array('between',"".$where['start_time'].",".$where['end_time']."");
		}
		elseif($where['start_time']){
			$where['chutuanriqi'] = $where['start_time'];
		}
		elseif($where['end_time']){
			$where['chutuanriqi'] = $where['end_time'];
		}
		if($where['user_name'])
			$where['user_name'] = array('like','%'.$where['user_name'].'%');
		if($where['title'])
			$where['title_copy'] = array('like','%'.$where['title'].'%');
		if($where['tuanhao'])
			$where['tuanhao'] = array('like','%'.$where['tuanhao'].'%');
		if($where['kind_copy'])
			$where['kind_copy'] = array('like','%'.$where['kind_copy'].'%');
		return $where;
	}
	
	//定制地接团搜索条件
    public function _orderDijie($where,$datatype) {
			//处理搜索
		if($where['start_time'] && $where['end_time']){
			$where['jietuantime'] = array('between',"".$where['start_time'].",".$where['end_time']."");
		}
		elseif($where['start_time']){
			$where['jietuantime'] = $where['start_time'];
		}
		elseif($where['end_time']){
			$where['jietuantime'] = $where['end_time'];
		}
		if($where['user_name'])
			$where['user_name'] = array('like','%'.$where['user_name'].'%');
		if($where['title'])
			$where['title'] = array('like','%'.$where['title'].'%');
		if($where['tuanhao'])
			$where['tuanhao'] = array('like','%'.$where['tuanhao'].'%');
		if($where['fromcompany'])
			$where['fromcompany'] = array('like','%'.$where['fromcompany'].'%');
		if($where['status_baozhang'] && $where['status_baozhang'] != '批准')
			$where['status_baozhang'] = array('neq','批准');
		return $where;
	}
	
	//定制审核任务搜索条件
    public function _orderShenheTask($where,$datatype,$relation) {
		$where['is_notice'] =  array('eq',1);//默认
		$where['title_copy'] = array('like','%'.$where['title'].'%');
		$where['user_name'] = array('like','%'.$where['user_name'].'%');
		$where['status'] = '待检出';
		if($relation == 'xianlu')
			$where['datatype'] = '线路';
		if($relation == 'DJtuan')
			$where['datatype'] = '地接';
		if($relation == 'qianzheng')
			$where['datatype'] = '签证';
		if($relation == 'baozhangitem'){
			$where['datatype'] = '报账项';
			if($where['baozhangtitle_copy'])
			$where['baozhangtitle_copy'] = array('like','%'.$where['baozhangtitle_copy'].'%');
			if($where['tuantitle_copy'])
			$where['tuantitle_copy'] = array('like','%'.$where['tuantitle_copy'].'%');
			if($where['tuanhao_copy'])
			$where['tuanhao_copy'] = array('like','%'.$where['tuanhao_copy'].'%');
			if($where['tuanqi_copy'])
			$where['tuanqi_copy'] = array('like','%'.$where['tuanqi_copy'].'%');
		}
		if($relation == 'baozhang'){
			$where['datatype'] = '报账单';
			if($where['baozhangtitle_copy']){
				$where['title_copy'] = array('like','%'.$where['baozhangtitle_copy'].'%');
				unset($where['baozhangtitle_copy']);
			}
			if($where['tuantitle_copy'])
				$where['tuantitle_copy'] = array('like','%'.$where['tuantitle_copy'].'%');
			if($where['tuanhao_copy'])
				$where['tuanhao_copy'] = array('like','%'.$where['tuanhao_copy'].'%');
			if($where['tuanqi_copy'])
				$where['tuanqi_copy'] = array('like','%'.$where['tuanqi_copy'].'%');
		}
		if($relation == 'dingdan')
			$where['datatype'] = '订单';
		return $where;
	}

	
	
	

    //显示产品列表
    public function data_list_noOM($class_name,$where,$pagenum = 20) {
		if($class_name == 'ViewHetong'){//合同
			$where['bianhao'] = array('like','%'.$where['bianhao'].'%');
			$where['name'] = array('like','%'.$where['name'].'%');
		}
		if($class_name == 'ViewXianlu'){
			$where = $this->_orderXianlu($where,$datatype);
		}
		if($class_name == 'ViewDingdan'){
			//处理搜索
			if($where['start_time'] && $where['end_time']){
				$where['time'] = array('between',"'".strtotime($where['start_time']).",".strtotime($where['end_time'])."'");
			}
			$where['title'] = array('like','%'.$where['title'].'%');
			$where['lianxiren'] = array('like','%'.$where['lianxiren'].'%');
			$where['owner'] = array('like','%'.$where['owner'].'%');
			if($where['remark'])
			$where['remark'] = array('like','%'.$where['remark'].'%');
		}
		//处理搜索
		if($class_name == 'ViewCustomer'){
			if($where['title'])
				$where['name'] = array('like','%'.$where['title'].'%');
			if($where['telnum'])
				$where['telnum'] = array('like','%'.$where['telnum'].'%');
			if($where['sfz_haoma'])
				$where['sfz_haoma'] = array('like','%'.$where['sfz_haoma'].'%');
			if($where['hz_haoma'])
				$where['hz_haoma'] = array('like','%'.$where['hz_haoma'].'%');
			if($where['txz_haoma'])
				$where['txz_haoma'] = array('like','%'.$where['txz_haoma'].'%');
		}
		if($class_name == 'ViewZituan'){
			//处理搜索
			if($where['start_time'] && $where['end_time'])
				$where['chutuanriqi'] = array('between',"".$where['start_time'].",".$where['end_time']."");
			elseif($where['start_time'])
				$where['chutuanriqi'] = $where['start_time'];
			elseif($where['end_time'])
				$where['chutuanriqi'] = $where['end_time'];
			$where['user_name'] = array('like','%'.$where['user_name'].'%');
			$where['title_copy'] = array('like','%'.$where['title'].'%');
			$where['tuanhao'] = array('like','%'.$where['tuanhao'].'%');
			$where['kind_copy'] = array('like','%'.$where['kind_copy'].'%');
			$order = 'chutuanriqi desc';
		}
		if($class_name == 'ViewSearch'){
//			if($where){
				if($where['user_name'])
					$where['user_name'] = array('like','%'.$where['user_name'].'%');
				if($where['title'])
					$where_tem .= "AND (`title_1` like '%".$where['title']."%' OR `title_2` like '%".$where['title']."%')";
				if($where['tuanhao'])
					$where_tem .= "AND (`tuanhao_1` like '%".$where['tuanhao']."%' OR `tuanhao_2` like '%".$where['tuanhao']."%')";
				if($where['chutuanriqi'])
					$where_tem .= "AND (`tuanqi_1` = '".$where['chutuanriqi']."' OR `tuanqi_2` = '".$where['chutuanriqi']."')";
				if($where['start_time'] && $where['end_time'])
					$where_tem .= "AND (  `tuanqi_1` BETWEEN '".$where['start_time']."' AND '".$where['end_time']."' OR `tuanqi_2` BETWEEN '".$where['start_time']."' AND '".$where['end_time']."' )";
				elseif($where['start_time'])
					$where_tem .= "AND (`tuanqi_1` = '".$where['chutuanriqi']."' OR `tuanqi_2` = '".$where['chutuanriqi']."')";
				elseif($where['end_time'])
					$where_tem .= "AND (`tuanqi_1` = '".$where['chutuanriqi']."' OR `tuanqi_2` = '".$where['chutuanriqi']."')";
				$order = 'case when tuanqi_1 is null then tuanqi_2 else tuanqi_1  end desc';
//			}
//			else{
//				$class_name = 'Chanpin';
//				$where['marktype'] =  array('exp'," = 'zituan' or `marktype` = 'DJtuan'");
//				$order = 'chanpinID desc';
//			}
			$where['status_system'] =  array('eq',1);//默认
			$where = $this->_facade($class_name,$where);//过滤搜索项
			$where = $this->_arraytostr_filter($where);
			$where .= $where_tem;
		}
		else{
			if($where['status_system'] != -1)
				$where['status_system'] = 1;
			$where = $this->_facade($class_name,$where);//过滤搜索项
			$where = $this->_arraytostr_filter($where);
		}
		//获得财务所属公司，过滤出公司拥有部门列表
		if($this->_checkRolesByUser('网管,总经理,出纳,会计,财务,财务总监','行政')){
			$ComID = $this->_getComIDbyUser($username);
			$wherebumen =" AND (`companyID` = '$ComID')";
		}else{
			$bumenlist = $this->_getCompanyDepartmentList();
			foreach($bumenlist as $v){
				if($wherebumen)
				$wherebumen .= " OR `departmentID` = '$v[systemID]'";
				else
				$wherebumen =" AND (`departmentID` = '$v[systemID]'";
			}
			$wherebumen .= ")";
		}
		$where .= $wherebumen;
		$ViewClass = D($class_name);
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $ViewClass->where($where)->count();
		$p= new Page($count,$pagenum);
		$page = $p->show();
		if(!$order)
			$order = 'time desc';
        $chanpin = $ViewClass->where($where)->order($order)->limit($p->firstRow.','.$p->listRows)->select();
		$redata['page'] = $page;
		$redata['chanpin'] = $chanpin;
		//关键字高亮
		return $this->_keyStar($redata,$_REQUEST);
	}
	
	
    //系统显示控制
    public function getDataOMlistSystem($datatype,$relation,$where,$type='管理',$pagenum = 20,$ajaxdiv='',$distinctfield='') {
		if($datatype == '用户'){
			$class_name = 'OMViewSystemUser';
			$where['datatype'] = $datatype;
		}
		if($datatype == '分类'){
			//$class_name = 'OMViewSystemCategory';
			$class_name = 'ViewCategory';
			$ComID = $this->_getComIDbyUser();
			$where['companyID'] = $ComID;
			$where['datatype'] = $datatype;
		}
		if($datatype == '产品搜索'){
			$class_name = 'OMViewSearch';
			$where['status_system'] =  array('eq',1);//默认
			if($where['user_name'])
				$where['user_name'] = array('like','%'.$where['user_name'].'%');
			if($where['title'])
				$where_tem .= "AND (`title_1` like '%".$where['title']."%' OR `title_2` like '%".$where['title']."%')";
			if($where['tuanhao'])
				$where_tem .= "AND (`tuanhao_1` like '%".$where['tuanhao']."%' OR `tuanhao_2` like '%".$where['tuanhao']."%')";
			if($where['chutuanriqi'])
				$where_tem .= "AND (`tuanqi_1` = '".$where['chutuanriqi']."' OR `tuanqi_2` = '".$where['chutuanriqi']."')";
			if($where['start_time'] && $where['end_time'])
				$where_tem .= "AND (  `tuanqi_1` BETWEEN '".$where['start_time']."' AND '".$where['end_time']."' OR `tuanqi_2` BETWEEN '".$where['start_time']."' AND '".$where['end_time']."' )";
			elseif($where['start_time'])
				$where_tem .= "AND (`tuanqi_1` = '".$where['chutuanriqi']."' OR `tuanqi_2` = '".$where['chutuanriqi']."')";
			elseif($where['end_time'])
				$where_tem .= "AND (`tuanqi_1` = '".$where['chutuanriqi']."' OR `tuanqi_2` = '".$where['chutuanriqi']."')";
			$where = $this->_facade($class_name,$where);//过滤搜索项
			$where = $this->_openAndManage_filter($where);
			$where = $this->_arraytostr_filter($where);
			$where .= $where_tem;
			$order = 'case when tuanqi_1 is null then tuanqi_2 else tuanqi_1  end desc';
		}
		else{
			$where = $this->_facade($class_name,$where);//过滤搜索项
			$where = $this->_openAndManage_filter($where);
		}
		$DataOM = D($class_name);
		if(!$distinctfield)
		$distinctfield = 'dataID';
		if($ajaxdiv)
        import("@.ORG.OldPage");
		else
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$tempcount = $DataOM->Distinct(true)->field($distinctfield)->where($where)->findall();
		$count = count($tempcount);
		$p= new Page($count,$pagenum);
		if($ajaxdiv)
		$page = $p->show_ajax($ajaxdiv);
		else
		$page = $p->show();
		if(!$order)
			$order = 'time desc';
        $chanpin = $DataOM->relation($relation)->Distinct(true)->field($distinctfield)->where($where)->limit($p->firstRow.','.$p->listRows)->order($order)->select();
		$chanpin = $this->_getRelation_select_after($chanpin,$relation);
		$redata['page'] = $page;
		$redata['chanpin'] = $chanpin;
		return $redata;
	}
	
	
    //开放与管理
    public function _openAndManage_filter($where,$user_ID = '') {
		$ViewSystemDUR = D("ViewSystemDUR");
		$where = $ViewSystemDUR->parseWhere($where);
		if($userID)
			$myuserID = $userID;
		else
			$myuserID = $this->user['systemID'];
		$DURlist = $this->_getDURlist($myuserID);
		if($where)
		$where .= " AND (";
		else
		$where .= " (";
		if($DURlist){
			foreach($DURlist as $v)
			{
				if($whereitem)
					$whereitem .= " OR ";
				$whereitem .= " (`DUR` = '$v[bumenID],$v[rolesID],')";//部门，角色
				$whereitem .= " OR (`DUR` = '$v[bumenID],$v[rolesID],$v[userID]')";//部门，角色，用户
				$whereitem .= " OR (`DUR` = '$v[bumenID],,$v[userID]')";//部门，用户
				$whereitem .= " OR (`DUR` = '$v[bumenID],,')";//部门
				$whereitem .= " OR (`DUR` = ',$v[rolesID],')";//角色
				$whereitem .= " OR (`DUR` = ',$v[rolesID],$v[userID]')";//角色，用户
				$whereitem .= " OR (`DUR` = ',,$v[userID]')";//用户
			}
		}
		else
				$whereitem .= "(`DUR` = ',,$v[userID]' )";//用户
				
		//附加公司计调
		//根据公司，做联合体开放产品的行政角色调整
		$durlist = A("Method")->_checkRolesByUser('计调','组团');
		if($durlist){
			$ComID = $this->_getComIDbyUser();
			$ViewRoles = D("ViewRoles");
			$r_jidiao = $ViewRoles->where("`title` ='计调'")->find();
			$whereitem .= " OR (`DUR` = '$ComID,$r_jidiao[systemID],' )";//公司计调
		}
		$where .= $whereitem.")";
		return $where;
	}
	
	
	
    //字符串化条件数组
    public function _arraytostr_filter($where) {
		$Chanpin = D("Chanpin");
		$where = $Chanpin->parseWhere($where);
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
		$DURlist = $ViewSystemDUR->where("`userID` = '$myuserID' AND (`status_system` = '1')")->findall();
		$i = 0;
		foreach($DURlist as $v)
		{
			$where['status'] = array('neq',-1);;
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
		$ViewBaozhang = D('ViewBaozhang');
		$chanpin = $Chanpin->relation("xianlu")->where("`chanpinID` = '$chanpinID' AND (`status_system` = '1')")->find();
		$riqiAll = split(';',$chanpin['xianlu']['chutuanriqi']);
		//根据线路判断生成
		$ViewZituan = D("ViewZituan");
		foreach($riqiAll as $riqi){
			if(strtotime($riqi) < strtotime('2010-11-11'))
			continue;
			$datazituan = '';
			$zituan = $ViewZituan->where("`parentID` = '$chanpinID' and `chutuanriqi` = '$riqi' AND (`status_system` = '1')")->find();
			$datazituan['zituan']['title_copy'] = $chanpin['xianlu']['title'];
			$datazituan['departmentID'] = $chanpin['departmentID'];
			if(!$zituan){//生成
				$datazituan['zituan']['guojing_copy'] = $chanpin['xianlu']['guojing'];
				$datazituan['zituan']['kind_copy'] = $chanpin['xianlu']['kind'];
				$datazituan['zituan']['renshu'] = $chanpin['xianlu']['renshu'];
				$datazituan['zituan']['baomingjiezhi'] = $chanpin['xianlu']['baomingjiezhi'];
				$datazituan['zituan']['chutuanriqi'] = $riqi;
				$datazituan['zituan']['tuanhao'] =  $chanpinID.'/'.$riqi;
				$datazituan['zituan']['second_confirm'] =  $chanpin['xianlu']['second_confirm'];
				$datazituan['parentID'] = $chanpinID;
				$datazituan['user_name'] = $chanpin['user_name'];
				$datazituan['status'] = '报名';
				$datazituan['zituan']['second_confirm'] = $chanpin['xianlu']['second_confirm'];
				$datazituan['zituan']['status_shop'] = $chanpin['xianlu']['status_shop'];
				if (false !== $Chanpin->relation("zituan")->myRcreate($datazituan)){
					$zituanID = $Chanpin->getRelationID();
					//生成OM
					$this->_OMRcreate($zituanID,'子团');
					//线路审核通过,生成默认报账单
					$td['user_name'] = $chanpin['user_name'];
					$td['departmentID'] = $chanpin['departmentID'];
					$td['parentID'] = $zituanID;
					$td['baozhang']['type'] = '团队报账单';
					$td['baozhang']['title'] = $datazituan['zituan']['title_copy'].'/'.$datazituan['zituan']['chutuanriqi'].'团队报账单';
					$td['baozhang']['renshu'] = $chanpin['xianlu']['renshu'];
					$Chanpin->relation("baozhang")->myRcreate($td);
					$baozhangID = $Chanpin->getRelationID();
					//生成OM
					$this->_OMRcreate($baozhangID,'报账单');
				}
			}
			else{//修改
				$zituanID = $zituan['chanpinID'];
				//判断子团报账单
				$bzdall = $ViewBaozhang->where("`parentID` = '$zituanID' AND (`status_system` = '1')")->findall();
				foreach($bzdall as $b){
					if($b['status_shenhe'] == '批准'){
						$marknotedit = 1;
						continue;
					}
				}
				if($marknotedit != 1){
					//修改子团内容
					$datazituan['chanpinID'] = $zituan['chanpinID'];
					if (false !== $Chanpin->relation("zituan")->myRcreate($datazituan)){
						//修改报账单
							$bzdall = $ViewBaozhang->where("`parentID` = '$zituanID' AND (`status_system` = '1')")->findall();
							foreach($bzdall as $b){
								$bzd_data['chanpinID'] = $b['chanpinID'];
								$bzd_data['departmentID'] = $datazituan['departmentID'];
								if(false === $Chanpin->mycreate($bzd_data))
								dump($Chanpin);
							}
					}
				}
//				else{
//					justalter("部分子团已经报账，部门修改对子团及报账单无效！！");
//				}
			}
		}
		//删除多余子团
		$viewxianlu = D("ViewXianlu");
		$ViewDingdan = D("ViewDingdan");
		$xianlu = $viewxianlu->relation("zituanlist")->where("`chanpinID` = '$chanpinID' AND (`status_system` = '1')")->find();
		$zituanlist = $xianlu['zituanlist'];
		foreach($zituanlist as $zituan){
			if(false === strpos($xianlu['chutuanriqi'],$zituan['chutuanriqi'])){//不存在删除
				$markb = 0;
				//报账情况
				$bzdall = $ViewBaozhang->relation("baozhangitemlist")->where("`parentID` = '$zituan[chanpinID]' AND (`status_system` = '1')")->findall();
				foreach($bzdall as $b){
					if($b['baozhangitemlist'] || $b['status_shenhe'] == '批准'){
						$locklist .= $zituan['chutuanriqi'].";";
						$markb = 1;
						break;
					}
				}
				if($markb == 1){
					if($chutuanlist)
					$chutuanlist .= ";".$zituan['chutuanriqi'];
					else
					$chutuanlist .= $zituan['chutuanriqi'];
					continue;	
				}
				//订单情况
				$dingdan = $ViewDingdan->where("`parentID` = '$zituan[chanpinID]' AND `status_system` = '1' AND `status` != '候补'")->find();
				if($dingdan){
					$locklist .= $zituan['chutuanriqi'].";";
					if($chutuanlist)
					$chutuanlist .= ";".$zituan['chutuanriqi'];
					else
					$chutuanlist .= $zituan['chutuanriqi'];
					continue;	
				}
				$zituan['status_system'] = -1;
				if (false !== $Chanpin->relation("zituan")->myRcreate($zituan)){
					//清空相关om
					$DataOM =D("DataOM");
					$DataOM->where("`dataID` = '$zituan[chanpinID]' and `datatype` = '子团'")->delete();
					continue;	
				}
			}
			if($chutuanlist)
			$chutuanlist .= ";".$zituan['chutuanriqi'];
			else
			$chutuanlist .= $zituan['chutuanriqi'];
		}
//		if($locklist)
//			justalter("部分子团已经报账，团期".$locklist."无法删除！！");
	   //由于可能存在子团锁定状态不能删除，要逆更新出团时间到线路
		$xianlu_data['chanpinID'] = $chanpinID;
		$xianlu_data['xianlu']['chutuanriqi'] = $chutuanlist;
		if(false !== $Chanpin->relation("xianlu")->myRcreate($xianlu_data)){
			return true;
		}else
		return false;
	}

	
	//根据子团生成日期
    public function shengchengzituan_2($chanpinID) {
		$Chanpin = D("Chanpin");
		$chanpin = $Chanpin->relation("zituanlist")->where("`chanpinID` = '$chanpinID' AND (`status_system` = '1')")->find();
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
		$dat = $ViewCategory->where("`systemID` = '$systemID' AND (`status_system` = '1')")->find();
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
				$d = $ViewCategory->where("`systemID` = '$v[parentID]' AND (`status_system` = '1')")->find();
			if($v['parenttype'] == '部门')
				$d = $ViewDepartment->where("`systemID` = '$v[parentID]' AND (`status_system` = '1')")->find();
			if($v['parenttype'] == '用户')
				$d = $ViewUser->where("`systemID` = '$v[parentID]' AND (`status_system` = '1')")->find();
			if($v['parenttype'] == '角色')
				$d = $ViewRoles->where("`systemID` = '$v[parentID]' AND (`status_system` = '1')")->find();
			if($v['roleslimitID'] != -1){
				$dd = $ViewRoles->where("`systemID` = '$v[roleslimitID]' AND (`status_system` = '1')")->find();
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
     public function _fenlei_filter_one($dat) {
		$ViewCategory = D("ViewCategory");
		$ViewDepartment = D("ViewDepartment");
		if($dat['opentype'] == '分类')
			$d = $ViewCategory->where("`systemID` = '$dat[openID]' AND (`status_system` = '1')")->find();
		if($dat['opentype'] == '部门')
			$d = $ViewDepartment->where("`systemID` = '$dat[openID]' AND (`status_system` = '1')")->find();
		$dat['title'] = $d['title'];
		return $dat;
	 }
		
	//分类解析
     public function _fenlei_filter($dat) {
		$ViewCategory = D("ViewCategory");
		$ViewDepartment = D("ViewDepartment");
		$i=0;
		foreach($dat as $v){
			if($v['opentype'] == '分类')
				$d = $ViewCategory->where("`systemID` = '$v[openID]' AND (`status_system` = '1')")->find();
			if($v['opentype'] == '部门')
				$d = $ViewDepartment->where("`systemID` = '$v[openID]' AND (`status_system` = '1')")->find();
			$dat[$i]['title'] = $d['title'];
			$i++;
		}
		return $dat;
	 }
	
	
     public function _xianluOMlist($dataID,$datatype,$method) {
		$ViewSystemOM = D("ViewSystemOM");
		$dat['OMlist'] = $ViewSystemOM->where("`dataID` = '$dataID' and `datatype` = '$datatype' AND (`status_system` = '1')")->findall();
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
	 
	 //过滤字段
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
		$DbFields = $class->flush();
        $fieldType = strtolower($DbFields['_type'][$key]);
        if(false === strpos($fieldType,'bigint') && false !== strpos($fieldType,'int')) {
            $data[$key]   =  intval($data[$key]);
        }elseif(false !== strpos($fieldType,'float') || false !== strpos($fieldType,'double')){
            $data[$key]   =  floatval($data[$key]);
        }elseif(false !== strpos($fieldType,'bool')){
            $data[$key]   =  (bool)$data[$key];
        }
    }
	
	
     public function unitlist($where_dept,$where_user,$where_cate) {
		$ViewCategory = D("ViewCategory");
		$ViewDepartment = D("ViewDepartment");
		$ViewUser = D("ViewUser");
		$ViewRoles = D("ViewRoles");
		$where = "`status_system` != '-1' and `islock` = '未锁定' ";
		//分类
		if($this->user['title'] == 'aaa'){
			if($where_cate)
			$where .= " AND ".$this->_arraytostr_filter($where_cate);
			$datas1 = $ViewCategory->where($where)->findall();
			$this->assign("categoryAll",$datas1);
		}
		else{
			$category = $this->_getCompanyCategoryList();
			$this->assign("categoryAll",$category);
//			$category = $this->getDataOMlistSystem("分类",'category','');
//			$this->assign("categoryAll",$category['chanpin']);
		}
		//部门
		if($this->user['title'] == 'aaa'){
			if($where_dept)
			$where .= " AND ".$this->_arraytostr_filter($where_dept);
			$datas2 = $ViewDepartment->where($where)->findall();
		}
		else
			$datas2 = $this->_getCompanyDepartmentList();
		$this->assign("departmentAll",$datas2);
		//用户
		if($this->user['title'] == 'aaa'){
			if($where_user)
			$where .= " AND ".$this->_arraytostr_filter($where_user);
			$datas3 = $ViewUser->where($where)->findall();
		}
		else{
//			$datas3 = $this->getDataOMlistSystem("用户",'user','');
			$datas3 = $this->_getCompanyUserList();
		}
			
		$this->assign("userAll",$datas3);
		//角色
		$datas4 = $ViewRoles->where("`status_system` != '-1' and `islock` = '未锁定' ")->findall();
		$this->assign("rolesAll",$datas4);
	 }
	 
	 
     public function _shanghutiaomulist() {
		$ViewDataDictionary = D("ViewDataDictionary");
		$list = $ViewDataDictionary->where("`status_system` = 1 AND `type` = '商户条目'")->findall();
		return $list;
	 }
	 
	 //获得公司及下属部门列表
     public function _getCompanyDepartmentList($username) {
		$ViewDepartment = D("ViewDepartment");
		if(!$username)
		$username = $this->user['title'];
		$ComID = $this->_getComIDbyUser($username);
		$bumenlist = $ViewDepartment->where("`systemID` = '$ComID' OR `parentID` = '$ComID' AND `status_system` = 1")->findall();
		return $bumenlist;
	 }
	
	
	 //获得公司及下属用户列表
     public function _getCompanyUserList($username) {
		$ViewUser = D("ViewUser");
		if(!$username)
		$username = $this->user['title'];
		$ComID = $this->_getComIDbyUser($username);
		$userall = $ViewUser->where("`companyID` = '$ComID' AND `status_system` = 1")->findall();
		return $userall;
	 }
	
	
	 //获得公司及下属用户列表
     public function _getCompanyCategoryList($username) {
		$ViewCategory = D("ViewCategory");
		if(!$username)
		$username = $this->user['title'];
		$ComID = $this->_getComIDbyUser($username);
		$list = $ViewCategory->where("`companyID` = '$ComID' AND `status_system` = 1")->findall();
		return $list;
	 }
	
	
	//解析 部门 角色 分类 用户
     public function _facesystem(&$dat,$type) {
		$ViewDepartment = D("ViewDepartment");
		$ViewRoles = D("ViewRoles");
		if($type == '用户'){
			$i=0;
			foreach($dat as $v){
				$department = $ViewDepartment->where("`systemID` = '$v[bumenID]' AND (`status_system` = '1')")->find();
				$dat[$i]['department'] = $department;
				$roles = $ViewRoles->where("`systemID` = '$v[rolesID]' AND (`status_system` = '1')")->find();
				$dat[$i]['roles'] = $roles;
				$i++;
			}
		}
	 }
	 
	 
	//获得角色设置列表
     public function _getRolesList() {
		$ViewRoles = D("ViewRoles");
		//角色
		$datas4 = $ViewRoles->findall();
		return $datas4;
	 }
	 
	 
	//获得部门列表
     public function _getDepartmentList($where) {
		$ViewDepartment = D("ViewDepartment");
		$datas2 = $ViewDepartment->where($where)->findall();
		return $datas2;
	 }
	
	
	//获得用户部门角色列表
     public function _getDURlist($userID,$bumen='',$bumentype='') {
		if($userID)
			$myuserID = $userID;
		else
			$myuserID = $this->user['systemID'];
		return $this->_getDURlist_do($myuserID,$bumen,$bumentype);	
	 }
	 
	 
	 
	//获得用户部门角色列表
     public function _getDURlist_name($user_name,$bumen='',$bumentype='') {
		if(!$user_name)
			$user_name = $this->user['title'];
		$ViewUser = D("ViewUser");
		$user = $ViewUser->where("`title` = '$user_name'")->find();
		return $this->_getDURlist_do($user['systemID'],$bumen,$bumentype);	
	 }
	 
	 
	 
     public function _getDURlist_do($myuserID,$bumen,$bumentype) {
		$ViewSystemDUR = D("ViewSystemDUR");
		if($bumen)//获得部门关联
		$data = $ViewSystemDUR->relation("bumen")->where("`userID` = '$myuserID' AND (`status_system` = '1')")->findall();
		else
		$data = $ViewSystemDUR->where("`userID` = '$myuserID' AND (`status_system` = '1')")->findall();
		if($bumentype){//过滤部门类型
			$ViewDepartment = D("ViewDepartment");
			$bumentypelist = explode(',',$bumentype);
			$m = 0;
			foreach($data as $v){
				$ok_d = 0;
				//比对部门类型
				$bumen_t = $ViewDepartment->where("`systemID` = '$v[bumenID]' and `status_system` = '1'")->find();
				$typelist = explode(',',$bumen_t['type']);
				foreach($typelist as $vaa){
					if(in_array($vaa,$bumentypelist)){
						$ok_d = 1;
						break;	
					}
				}
				if($ok_d == 1){
					$data_2[$m] = $v;
					$m++;
				}
			}
			return $data_2;
		}
		return $data;
	 }
	 
	 
	//获得用户列表
     public function _getUserlist($bumenID,$rolesID) {
		$ViewSystemDUR = D("ViewSystemDUR");
		if($bumenID && $rolesID)
		$data = $ViewSystemDUR->Distinct(true)->field('userID')->where("`bumenID` = '$bumenID' and `rolesID` = '$rolesID' AND (`status_system` = '1')")->findall();
		elseif($bumenID)
		$data = $ViewSystemDUR->Distinct(true)->field('userID')->where("`bumenID` = '$bumenID' AND (`status_system` = '1')")->findall();
		elseif($rolesID)
		$data = $ViewSystemDUR->Distinct(true)->field('userID')->where("`rolesID` = '$rolesID' AND (`status_system` = '1')")->findall();
		return $data;
	 }
	 
	 
	//获得分类包含项列表
     public function _getDClist($systemID) {
		$System = D("System");
		$category = $System->relation("systemDClist")->where("`systemID` = '$systemID' AND (`status_system` = '1')")->find();
		return $category['systemDClist'];
	 }
	
	
	//同步DataOM:售价开放管理到对象
     public function _shoujiaToDataOM($data) {
		$DataOM = D("DataOM");
//		$where['dataID'] = $data['chanpinID'];
//		$where['datatype'] = '售价';
//		$DataOM->where($where)->delete();
		$OM['dataID'] = $data['chanpinID'];
		$OM['datatype'] = '售价';
		$OM['type'] = '开放';
		if($data['opentype'] == '分类'){
			$departmentlist = $this->_getDClist($data['openID']);
			foreach($departmentlist as $s){
				$temp['bumenID'] = $s['dataID'];
				$OM['DUR'] = $this->_OMToDataOM_filter($temp);
				//查询重复
				$has = $DataOM->where($OM)->find();
				if($has)
					continue;
				if(false === $DataOM->mycreate($OM)){
					dump($DataOM);
					exit;	
				}
			}
			return;
		}
		if($data['opentype'] == '部门'){
			$temp['bumenID'] = $data['openID'];
			$OM['DUR'] = $this->_OMToDataOM_filter($temp);
			$DataOM->mycreate($OM);
		}
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
				$OM['DUR'] = $this->_OMToDataOM_filter($OM);
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
		$nowDir = $ViewDirectory->where("`title` = '$title' AND (`status_system` = '1')")->find();
		$this->assign("nowDir",$nowDir);
		if($nowDir['url'])
		$str = '<a href="'.SITE_INDEX.$nowDir['url'].'">'.$nowDir['title'].'</a>';
		else
		$str = $nowDir['title'];
		while($nowDir['parentID'] != null)
		{
			$preDir = $ViewDirectory->where("`systemID` = '$nowDir[parentID]' AND (`status_system` = '1')")->find();
			$str = '<a href="'.SITE_INDEX.$preDir['url'].'">'.$preDir['title'].'</a>  >  ' . $str;
			$nowDir = $preDir;
		}
		$str = '<a href="javascript:window.history.back();">返回上一步 </a>  |  '. $str;
		
		$this->assign("navigation",$str);
	 }
	
	
	
	//同步开放管理到对象
     public function _ShenheToDataShenhe($data) {
		$DataShenhe = D("DataShenhe");
		$DataShenhe->where("`shenheID` = '$data[systemID]'")->delete();
		$DS = null;
		$DS['shenheID'] = $data['systemID'];
		$DS['datatype'] = $data['datatype'];
		$DS['processID'] = $data['processID'];
		$DS['remark'] = $data['remark'];
		$DS['is_notice'] = $data['is_notice'];
		$DS['companyID'] = $data['companyID'];
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
				$d = $ViewCategory->where("`systemID` = '$v[parentID]' AND (`status_system` = '1')")->find();
			if($v['parenttype'] == '部门')
				$d = $ViewDepartment->where("`systemID` = '$v[parentID]' AND (`status_system` = '1')")->find();
			if($v['parenttype'] == '用户')
				$d = $ViewUser->where("`systemID` = '$v[parentID]' AND (`status_system` = '1')")->find();
			if($v['parenttype'] == '角色')
				$d = $ViewRoles->where("`systemID` = '$v[parentID]' AND (`status_system` = '1')")->find();
			$datalist[$i]['title'] = $d['title'];
			$i++;
		}
		return $datalist;
	 }
	 
	 //数据备份：生成
     public function makefiledatacopy($dataID,$datatype,$taskID) {
	 	if($datatype == '线路'){
			$ViewXianlu = D('ViewXianlu');
			$data['xianlu'] = $ViewXianlu->where("`chanpinID` = '$dataID' AND (`status_system` = '1')")->find();
			$ViewXingcheng = D('ViewXingcheng');
			$data['xingcheng'] = $ViewXingcheng->where("`parentID` = '$dataID' AND (`status_system` = '1')")->findall();
			$ViewChengben = D('ViewChengben');
			$data['chengben'] = $ViewChengben->where("`parentID` = '$dataID' AND (`status_system` = '1')")->findall();
			$ViewShoujia = D('ViewShoujia');
			$data['shoujia'] = $ViewShoujia->where("`parentID` = '$dataID' AND (`status_system` = '1')")->findall();
		}
	 	if($datatype == '报账项'){
			$ViewBaozhangitem = D('ViewBaozhangitem');
			$data['baozhangitem'] = $ViewBaozhangitem->where("`chanpinID` = '$dataID' AND (`status_system` = '1')")->find();
		}
	 	if($datatype == '报账单'){
			$ViewBaozhang = D('ViewBaozhang');
			$data['baozhang'] = $ViewBaozhang->where("`chanpinID` = '$dataID' AND (`status_system` = '1')")->find();
			$ViewBaozhangitem = D('ViewBaozhangitem');
			$data['baozhangitem'] = $ViewBaozhangitem->where("`parentID` = '$dataID' AND (`status_system` = '1')")->findall();
		}
	 	if($datatype == '签证'){
			$ViewQianzheng = D('ViewQianzheng');
			$data['qianzheng'] = $ViewQianzheng->where("`chanpinID` = '$dataID' AND (`status_system` = '1')")->find();
		}
		$data['copy'] = serialize($data);
		$DataCopy = D('DataCopy');
		$data['dataID'] = $dataID;
		$data['datatype'] = $datatype;
		$data['taskID'] = $taskID;
		$DataCopy->myCreate($data);
	 }
	 
	 
	 //审核检查商品
     public function _shenheDO_chanpin_check() {
		$Chanpin = D("Chanpin");
		$cp = $Chanpin->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
		//订单
		if($cp['marktype'] == 'dingdan' && $cp['status'] != '确认'){
			cookie('errormessage','错误，订单不是确认状态！',30);
			return false;
		}
		if($cp['marktype'] == 'dingdan'){
			$dingdan = $Chanpin->relationGet("dingdan");
			if($dingdan['status_baozhang'] != '批准' && $dingdan['type'] != '签证'){
				cookie('errormessage','错误，报账单审核通过后进行订单审核！',30);
				return false;
			}
		}
		//报账项
		if($cp['marktype'] == 'baozhangitem'){
			$ViewBaozhang = D("ViewBaozhang");
			$bzd = $ViewBaozhang->where("`chanpinID` = '$cp[parentID]'")->find();
			if($bzd['status_shenhe'] == '批准' ){
				cookie('errormessage','请审核回退报账单后进行审核！！！',30);
				return false;
			}
		}
		//线路和地接
		if(($cp['marktype'] == 'DJtuan' || $cp['marktype'] == 'xianlu') && $cp['status'] == '截止'){
			cookie('errormessage','错误，线路和地接状态已经截止！',30);
			return false;
		}
		//线路
		if($cp['marktype'] == 'xianlu'){
			$xianlu = $Chanpin->relationGet("xianlu");
			if($xianlu['chutuanriqi'] == '0' || $xianlu['chutuanriqi'] == ''){
				cookie('errormessage','错误，出团日期未添加！',30);
				return false;
			}
			if($xianlu['shoujia'] == '0' || $xianlu['shoujia'] == ''){
				cookie('errormessage','错误，销售价格（电商成人）未填写！',30);
				return false;
			}
			if($xianlu['ertongshoujia'] == '0' || $xianlu['ertongshoujia'] == ''){
				cookie('errormessage','错误，销售价格（电商儿童）未填写！',30);
				return false;
			}
		}
		//签证
		if($cp['marktype'] == 'qianzheng'){
			$qianzheng = $Chanpin->relationGet("qianzheng");
			if(!$qianzheng['shoujia']){
				cookie('errormessage','错误，售价未添加！',30);
				return false;
			}
		}
	 
	 }
	 
	 
	 
	 
	//审核任务
	//生成待检出	
	//检查审核流程
     public function _shenheDO($need) {
		 //检查商品
		if(false === $this->_shenheDO_chanpin_check())
			return false;
		$Chanpin = D("Chanpin");
		$dotype = $_REQUEST['dotype'];
		if($dotype == '申请'){
			unset($_REQUEST['parentID']);//多余字段影响数据
			$process = $this->_checkShenhe($_REQUEST['datatype'],1,$this->user['systemID'],$_REQUEST['dataID']);
			if(false === $process){//检查流程的申请权限！检查某人是否有审核权限！（某人的审核权限建立在产品权限之上）
				cookie('errormessage','您没有申请审核的权限！',30);
				return false;
			}
			if(A("Method")->_shenheback() && $process['status'] != '批准')//审核回退
				$processID = 1;
			else{
				cookie('errormessage','错误！产品已被批准，请回退后重新申请。',30);
				return false;
			}
		}
		else{
			$process = $this->_getTaskDJC($_REQUEST['dataID'],$_REQUEST['datatype']);//检查待审核任务存在
			if(false === $process){
				cookie('errormessage','错误！该产品流程不存在或已被执行！',30);
				return false;
			}
			$processID = $need['processID'];
			$data['systemID'] = $need['systemID'];//审核覆盖
		}
		$data['taskShenhe'] = $_REQUEST;
		$data['status'] = $_REQUEST['status_shenhe'];
		$data['user_name'] = $this->user['title'];
		//检查流程状态
//		$process = $this->_checkDataShenhe($_REQUEST['dataID'],$_REQUEST['datatype'],$data['status'],$processID,$need);
//		if(false === $process){
//			cookie('errormessage','错误！该产品流程不存在或已被执行！',30);
//			return false;
//		}
		$data['taskShenhe']['processID'] = $processID;
		$data['taskShenhe']['remark'] = $process['remark'];
		$data['taskShenhe']['roles_copy'] = cookie('_task_roles');
		$data['taskShenhe']['bumen_copy'] = cookie('_task_bumen');
		//任务搜索字段填充
		$data = $this->_gettaskshenheinfo($_REQUEST['dataID'],$_REQUEST['datatype'],$data);
		//审核任务，申请及检出
		$System = D("System");
		$System->startTrans();
		if(false === $System->relation("taskShenhe")->myRcreate($data)){
			cookie('errormessage','错误，操作失败！'.$System->getError(),30);
			return false;
		}
		//如果流程只有批准
		$to_dataID = $System->getRelationID();
		if($processID == 1 && $data['status'] == '批准'){
			$md['systemID'] = $to_dataID;
			$md['parentID'] = $to_dataID;
			if(false === $System->save($md))
				$System->rollback();
		}
		//如果多流程
		$process = $this->_checkShenhe($_REQUEST['datatype'],$processID+1);
		if($process){
			$data['status'] = '待检出';
			if($processID == 1)
				$data['parentID'] = $to_dataID;
			else
				$data['parentID'] = $need['parentID'];
			//申请人	
			$data['user_name'] = $need['user_name'];
			$data['departmentID'] = $need['departmentID'];
			$data['taskShenhe']['remark'] = $process[0]['remark'];
			$data['taskShenhe']['processID'] = $processID+1;
			unset($data['systemID']);
			unset($data['taskShenhe']['roles_copy']);
			unset($data['taskShenhe']['bumen_copy']);
			//生成待检出
			$userIDlist = $this->_djcCreate($data,$process);
			if(false === $userIDlist)
				$System->rollback();
		}
		else{
			foreach($to_dataomlist as $vo){
				//返回需要提示的用户
				$userIDlist_temp = $this->_getuserlistByDUR($vo['DUR']);	
				$userIDlist = NF_combin_unique($userIDlist,$userIDlist_temp);
			}
		}
		$System->commit();
		//记录
		if($_REQUEST['datatype'] == '线路')
			$url = 'index.php?s=/Chanpin/fabu/chanpinID/'.$_REQUEST['dataID'];
		if($_REQUEST['datatype'] == '地接')
			$url = 'index.php?s=/Dijie/fabu/chanpinID/'.$_REQUEST['dataID'];
		if($_REQUEST['datatype'] == '签证')
			$url = 'index.php?s=/Qianzheng/fabu/chanpinID/'.$_REQUEST['dataID'];
		if($_REQUEST['datatype'] == '订单')
			$url = 'index.php?s=/Xiaoshou/dingdanxinxi/chanpinID/'.$_REQUEST['dataID'];
		if($_REQUEST['datatype'] == '报账单')
			$url = 'index.php?s=/Chanpin/zituanbaozhang/baozhangID/'.$_REQUEST['dataID'];
		if($_REQUEST['datatype'] == '报账项'){
			$ViewBaozhangitem = D("ViewBaozhangitem");
			$item = $ViewBaozhangitem->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
			$url = 'index.php?s=/Chanpin/zituanbaozhang/baozhangID/'.$item['parentID'];
		}
		$message = $_REQUEST['datatype'].'审核'.$status.'『'.$_REQUEST['title'].'』 。';
		$this->_setMessageHistory($_REQUEST['dataID'],$_REQUEST['datatype'],$message,$url);
		cookie('successmessage','操作成功！',30);
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
     public function _getDataOM($dataID,$datatype='',$type = '',$omclass='') {
		 if($omclass)
		$DataOM = D($omclass);
		 else
		$DataOM = D("DataOM");
		if(!$datatype && !$omclass){
			$Chanpin = D('Chanpin');
			$cp = $Chanpin->where("`chanpinID` = '$dataID'")->find();
			if($cp['marktype'] == 'xianlu')
				$datatype = '线路';
			if($cp['marktype'] == 'qianzheng')
				$datatype = '签证';
			if($cp['marktype'] == 'DJtuan')
				$datatype = '地接';
			if($cp['marktype'] == 'baozhang')
				$datatype = '报账单';
			if($cp['marktype'] == 'baozhangitem')
				$datatype = '报账项';
		}
		if($type == '')
		$data = $DataOM->where("`dataID` = '$dataID' and `datatype` = '$datatype'")->findall();
		else
		$data = $DataOM->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `type` = '$type'")->findall();
		//过滤相同DUR字段数组
		$i = 0;
		foreach($data as $v){
			if($newdat){
				foreach($newdat as $vol){
					if($vol['DUR'] == $v['DUR']){
						$ishas = 1;
						break;
					}
				}
				if($ishas != 1){
					$ishas = 0;
					$newdat[$i] = $v;
				}
				$i++;
			}
			else{
			$newdat[$i] = $v;
			$i++;
			}
		}
	 	return $newdat;
	 }
	 
	 
	 
	//根据产品相关DUR获得提示用户列表
     public function _getUserlistByDataOM($dataID,$datatype,$type = '') {
		$omlist = $this->_getDataOM($dataID,$datatype,$type);
		$userIDlist = array();
		foreach($omlist as $vo){
			//返回需要提示的用户
			$userIDlist_temp = $this->_getuserlistByDUR($vo['DUR']);	
			$userIDlist = NF_combin_unique($userIDlist,$userIDlist_temp);
		}
		return $userIDlist;
	 }
	 
	 
	 
	//检查数据审核任务OM
     public function _checkOMTaskShenhe($dataID,$datatype) {
		 
	 	//流程
		$process = $this->_getTaskDJC($dataID,$datatype);
		if($process){
			$need = $this->_getTaskDJC($dataID,$datatype,1);//检查待审核任务存在
			if(false === $need){
				cookie('errormessage','错误！您没有产品审核权限！',30);
				return false;
			}
			$omdata = $this->_checkDataOM($process['dataID'],$process['datatype'],'管理');
			if(false !== $omdata){
				if($datatype == '线路')
				cookie('show_word','批准成团',30);
				else
				cookie('show_word','批准',30);
				cookie('show_action','批准',30);
				return $omdata;
			}
			else{
				cookie('errormessage','错误！您没有产品审核权限！',30);
				return false;
			}
		}
		else{
			if(false === $this->_checkShenhe($datatype,1,$this->user['systemID'],$dataID)){//检查流程的申请权限！检查某人是否有审核权限！（某人的审核权限建立在产品权限之上）
				cookie('errormessage','您没有申请审核的权限！',30);
				return false;
			}
			else{
				
				$Chanpin = D("Chanpin");
				$data = $Chanpin->where("`chanpinID` = '$dataID'")->find();
				if(($data['status_shenhe'] != '批准' || ($datatype == '签证' || $datatype == '线路' || $datatype == '地接')) && $data['status'] != '截止'){
					if($this->_checkShenhe($datatype,2))
					cookie('show_word','申请审核',30);
					else
					cookie('show_word','批准',30);
					cookie('show_action','申请',30);
					return $omdata;
				}
				return false;
			}
		}
	 }
	 
	 
	 
	//检查DataOM
     public function _checkDataOM($dataID,$datatype,$type,$userID='',$DURlist='',$omclass='') {
		 if($this->user['title'] == 'aaa')
		 	return true;
		 
		if($userID)
			$myuserID = $userID;
		if($DURlist == ''){
			$myuserID = $this->user['systemID'];
		}
		$DURlist = $this->_getDURlist($myuserID);
		if($omclass)
			$DataOM = D($omclass);
		else
			$DataOM = D("DataOM");
		$datalist = array();
		$where['dataID'] = $dataID;
		$where['datatype'] = $datatype;
		if($type == '管理')
			$where['type'] = '管理';
		else
			$where['type'] = array('in','开放,管理');
		foreach($DURlist as $v){
			$where['DUR'] = $v['bumenID'].',,';
			$OMlist = $DataOM->Distinct(true)->field('dataID')->where($where)->find();
			if(!$OMlist){
				$where['DUR'] = $v['bumenID'].','.$v['rolesID'].','.$v['userID'];
				$OMlist = $DataOM->Distinct(true)->field('dataID')->where($where)->find();
			}
			if(!$OMlist){
				$where['DUR'] = $v['bumenID'].','.$v['rolesID'].',';
				$OMlist = $DataOM->Distinct(true)->field('dataID')->where($where)->find();
			}
			if(!$OMlist){
				$where['DUR'] = $v['bumenID'].',,'.$v['userID'];
				$OMlist = $DataOM->Distinct(true)->field('dataID')->where($where)->find();
			}
			if(!$OMlist){
				$where['DUR'] = ','.$v['rolesID'].','.$v['userID'];
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
				$bumen = $ViewDepartment->where("`systemID` = '$v[bumenID]'")->find();
				$omdata['roles'] = $roles['title'];
				$omdata['bumen'] = $bumen['title'];
				$omdata['bumenID'] = $bumen['systemID'];
				
				cookie('_usedbumenID',$bumen['systemID'],30);
				cookie('_usedrolesID',$roles['systemID'],30);
				cookie('_usedbumen',$bumen['title'],30);
				cookie('_usedroles',$roles['title'],30);
				cookie('_usedbumenaddr',$bumen['addr'],30);
				cookie('_usedbumenfax',$bumen['fax'],30);
				return $omdata;
			}
		}
		
		//附加公司计调
		$durlist = A("Method")->_checkRolesByUser('计调','组团');
		if($durlist){
			$ComID = $this->_getComIDbyUser();
			$ViewRoles = D("ViewRoles");
			$r_jidiao = $ViewRoles->where("`title` ='计调'")->find();
			$where['DUR'] = $ComID.','.$r_jidiao['systemID'].',';
			$OMlist = $DataOM->Distinct(true)->field('dataID')->where($where)->find();
			
			if($OMlist){
				$ViewDepartment = D("ViewDepartment");
				$bumen = $ViewDepartment->where("`systemID` = '$ComID'")->find();
				$omdata['roles'] = '计调';
				$omdata['bumen'] = $bumen['title'];
				$omdata['bumenID'] = $bumen['systemID'];
				
				cookie('_usedbumenID',$bumen['systemID'],30);
				cookie('_usedrolesID',$r_jidiao['systemID'],30);
				cookie('_usedbumen',$bumen['title'],30);
				cookie('_usedroles',$r_jidiao['title'],30);
				cookie('_usedbumenaddr',$bumen['addr'],30);
				cookie('_usedbumenfax',$bumen['fax'],30);
				return $omdata;
			}
			
		}
		
		return false;
	 }
	 
	 
	//检查DataOM部门一项是否相同
     public function _checkDataOMbumen($dataID,$datatype,$type,$bumenID,$rolesID) {
		$DataOM = D("DataOM");
		$datalist = array();
		if($type == '管理')
		$where['type'] = '管理';
		else
		$where['type'] = array('in','开放,管理');
		$where['DUR'] = array('like',$bumenID.',%');//只检查部门
		$where['dataID'] = $dataID;
		$where['datatype'] = $datatype;
		$OMlist = $DataOM->where($where)->find();
		if($OMlist){
			$ViewRoles = D("ViewRoles");
			$roles = $ViewRoles->where("`systemID` = '$rolesID'")->find();
			$ViewDepartment = D("ViewDepartment");
			$bumen = $ViewDepartment->where("`systemID` = '$bumenID'")->find();
			cookie('_task_bumen',$bumen['title'],30);
			cookie('_task_roles',$roles['title'],30);
			return true;
		}
		return false;
	 }
	 
	 
	 
	//检查审核流程,检查某人是否有审核权限！（某人的审核权限建立在产品权限之上）
     public function _checkShenhe($datatype,$processID,$userID='',$dataID='') {
		$DataShenhe = D("DataShenhe");
		if($userID){//判断用户权限
			$ComID = $this->_getComIDbyUser('',$userID);
			if(!$dataID || !$ComID)
			return false;
			$myuserID = $userID;
			$DURlist = $this->_getDURlist($myuserID);
			$ViewRoles = D("ViewRoles");
			$ViewUser = D("ViewUser");
			foreach($DURlist as $v){
				//开放给个人，不检查部门
				$UR = ','.$v['userID'];
				//公司范围控制
				$shenhe = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '$processID' and `UR` = '$UR' AND `companyID` = '$ComID'")->find();
				if($shenhe != null){
					$roletitle = $ViewUser->where("`systemID` = '$v[userID]' AND (`status_system` = '1')")->find();
					$shenhe['roletitle'] = $roletitle['title'];
					return $shenhe;
				}
				//开放给角色，检查部门
				$UR = $v['rolesID'].',';
				//公司范围控制
				//先检查角色
				$shenhe = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '$processID' and `UR` = '$UR' AND `companyID` = '$ComID'")->find();
				if($shenhe != null){
					//检测部门是否有产品管理权
					//再检查部门
					$omdata = $this->_checkDataOMbumen($dataID,$datatype,'管理',$v['bumenID'],$v['rolesID']);
					if(false === $omdata)
						continue;
					$roletitle = $ViewRoles->where("`systemID` = '$v[rolesID]'")->find();
					$shenhe['roletitle'] = $roletitle['title'];
					return $shenhe;
				}
			}
			
			//联合体产品，比对公司计调权限。
			if($processID == 1){
				return $this->_checkLHT_OM($dataID,$datatype,$userID);
			}
			
		}
		else{//获得审核流程
			//公司范围控制
			$username = $this->user['title'];
			$ComID = $this->_getComIDbyUser($username);
			$shenheAll = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '$processID' AND `companyID` = '$ComID'")->findall();
			if($shenheAll != null)
				return $shenheAll;
		}
		return false;
		
	 }
	 
	 
	 
	 
	//根据流程，检查该产品是否对公司计调开放
     public function _checkLHT_OM($dataID,$datatype,$userID='') {
		  $DataShenhe = D("DataShenhe");
		  $ViewRoles = D("ViewRoles");
		  $ComID = $this->_getComIDbyUser('',$userID);
		  $durlist = A("Method")->_checkRolesByUser('计调','组团',1,$userID);
		  foreach($durlist as $v){
			  //开放给角色，检查部门
			  $UR = $v['rolesID'].',';
			  $shenhe = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '1' and `UR` = '$UR' AND `companyID` = '$ComID'")->find();
			  if($shenhe != null){
				  $user_dur_item = $ComID.','.$v['rolesID'].',';
				  //附加公司计调
				  //根据公司，做联合体开放产品的行政角色调整
				  $dataOMlist = $this->_getDataOM($dataID,$datatype,'管理');
				  foreach($dataOMlist as $dol){
					  if($dol['DUR'] == $user_dur_item){
						  $roletitle = $ViewRoles->where("`systemID` = '$v[rolesID]'")->find();
						  $shenhe['roletitle'] = $roletitle['title'];
						  return $shenhe;
					  }
				  }
			  }
		  }
		  return false;
	 }
	 
	 


	
	//获得任务管理角色和部门cookie
     public function _task_cookie_by_dur($dur) {
		  list($om_bumen,$om_roles,$om_user) = split(',',$dur);
		  $ViewRoles = D("ViewRoles");
		  $roles = $ViewRoles->where("`systemID` = '$om_roles'")->find();
		  $ViewDepartment = D("ViewDepartment");
		  $bumen = $ViewDepartment->where("`systemID` = '$om_bumen'")->find();
		  cookie('_task_roles',$roles['title'],30);
		  cookie('_task_bumen',$bumen['title'],30);
	 }
	 
	 
	//检查流程状态待检出，检出用户是否有任务权限！
     public function _getTaskDJC($dataID,$datatype,$checkright=0) {
		 if($checkright){
			$OMViewTaskShenhe = D("OMViewTaskShenhe");
			$where['dataID'] = $dataID;
			$where['datatype'] = $datatype;
			$where['status'] = '待检出';
			$where['status_system'] = 1;
			$where = $this->_openAndManage_filter($where);
			$need = $OMViewTaskShenhe->where($where)->find();
			if($need){
				$this->_task_cookie_by_dur($need['DUR']);
				return $need;
			}
		 }
		 else
		 {
			$ViewTaskShenhe = D("ViewTaskShenhe");
			$need = $ViewTaskShenhe->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `status` = '待检出' AND (`status_system` = '1')")->find();
			if($need)
			  return $need;
		 }
		return false;
	 }
	 
	 
	//检查流程状态批准
     public function _getTaskPZ($dataID,$datatype) {
		$ViewTaskShenhe = D("ViewTaskShenhe");
		if($processID == ''){
		  $need = $ViewTaskShenhe->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `status` = '批准' AND (`status_system` = '1')")->find();
		  return $need;
		}
		return false;
	 }
	 
	 
	 
	//检查流程状态
     public function _checkDataShenhe($dataID,$datatype,$status,$processID,$need) {
		$ViewTaskShenhe = D("ViewTaskShenhe");
		//检查审核流程权限
		$process = $this->_checkShenhe($datatype,$processID);
		if(!$process)
			return false;
		$Chanpin = D("Chanpin");
		$tc = $Chanpin->where("`chanpiniD` = '$dataID'")->find();
		if($tc['status_shenhe'] == '批准'){
			$need = $this->_getTaskDJC($_REQUEST['dataID'],$_REQUEST['datatype']);//检查待审核任务存在
			if($need)
			return $process;
			if($datatype == '线路')
			return $process;
			if($datatype == '签证')
			return $process;
			return false;
		}
		elseif($processID == 1 && ($tc['status_shenhe'] == '未审核' || $tc['status_shenhe'] == '')){
			return $process;
		}
		elseif($processID != 1 && ($tc['status_shenhe'] == '申请' || $tc['status_shenhe'] == '检出')){
			return $process;
		}
		return false;
	 }
		 
		 
	//历史记录,保存到dataom_system
     public function _setMessageHistory($dataID,$datatype,$message='',$url='',$dataOMlist='',$userIDlist='',$data='') {
		 if($datatype == '订单'){
			$data['infohistory']['message'] = $message;
			if($data['usermame'])
				$data['infohistory']['usedDUR'] = $data['usermame'];
			else
				$data['infohistory']['usedDUR'] = $this->user['title'];
		 }else{
			$data['infohistory']['message'] = cookie('_usedbumen').cookie('_usedroles').'"'.$this->user['title'].'":'.$message;
			$data['infohistory']['usedDUR'] = cookie('_usedbumenID').','.cookie('_usedrolesID').','.$this->user['systemID'];
		 }
		$data['parentID'] = $dataID;
		$data['infohistory']['dataID'] = $dataID;
		$data['infohistory']['datatype'] = $datatype;
		$data['infohistory']['url'] = $url;
		
		$Message = D("Message");
		if (false !== $Message->relation("infohistory")->myRcreate($data)){
			$data['messageID'] = $Message->getRelationID();
			//生成OM
			$dataOMlis = $this->_OMRcreate($data['messageID'],'消息');
			if($userIDlist == ''){
				$userIDlist = array();
				foreach($dataOMlist as $vo){
					//返回需要提示的用户
					$userIDlist_temp = $this->_getuserlistByDUR($vo['DUR']);	
					$userIDlist = NF_combin_unique($userIDlist,$userIDlist_temp);
				}
			}
			if($data['usermame'] == '电商'){
				//开放给电商
				$dataOMlist = $this->_getmyOMlist('电商');
				$dataOMlis = $this->_OMRcreate($data['messageID'],'消息');
				foreach($dataOMlist as $vo){
					//返回需要提示的用户
					$userIDlist_temp = $this->_getuserlistByDUR($vo['DUR']);	
					$userIDlist = NF_combin_unique($userIDlist,$userIDlist_temp);
				}
			}
			$this->_OMToDataNotice($data['infohistory'],$userIDlist);//同步提示信息
		}
	}
	
	
	
		 
	//生成OM
     public function _createDataOM($dataID,$datatype,$type,$dataOMlist = '',$dataomclass='',$status='') {
		$dom['type'] = $type;
		$dom['datatype'] = $datatype;
		$dom['dataID'] = $dataID;
		$dom['status'] = $status;
		if($dataomclass)
		$DataOM = D($dataomclass);
		else
		$DataOM = D("DataOM");
		if($dataOMlist == ''){
			$where['DUR'] = $dom['DUR'];
			$where['datatype'] = $dom['datatype'];
			$where['dataID'] = $dom['dataID'];
			$theom = $DataOM->where($where)->find();
			if($theom)
			continue;
			$dom['DUR'] = ',,'.$this->user['systemID'];
			$DataOM->mycreate($dom);
		}
		foreach($dataOMlist as $d){
			$dom['DUR'] = $d["DUR"];
			$where['DUR'] = $dom['DUR'];
			$where['datatype'] = $dom['datatype'];
			$where['dataID'] = $dom['dataID'];
			$theom = $DataOM->where($where)->find();
			if($theom)
			continue;
			$DataOM->mycreate($dom);
		}
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
				$data['datatype'] = $data['datatype'];
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
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg,txt,doc,rar,xls,xlsx,csv'); 
        //设置附件上传目录 
        $upload->savePath = $savePath; 
        //设置需要生成缩略图，仅对图像文件有效 
        $upload->thumb = true; 
        // 设置引用图片类库包路径 
        $upload->imageClassPath = '@.ORG.Image'; 
        //设置需要生成缩略图的文件后缀 
        $upload->thumbPrefix = 'm_';
        //设置缩略图最大宽度 
        $upload->thumbMaxWidth = '400,100'; 
        //设置缩略图最大高度 
        $upload->thumbMaxHeight = '400,100'; 
        //设置上传文件规则 
        $upload->saveRule = uniqid; 
        //设置上传文件规则 
//		$upload->saveRule = 'time';
//		$upload->autoSub = 'true';
//		$upload->subType = 'date';
//		$upload->dateFormat = 'Y/m';
        //删除原图 
        //$upload->thumbRemoveOrigin = true; 
        if (!$upload->upload()) { 
            //捕获上传异常 
            return false; 
        } else { 
		
            //取得成功上传的文件信息 
            $uploadList = $upload->getUploadFileInfo(); 
            import("@.ORG.Image"); 
            //给m_缩略图添加水印, Image::water('原文件名','水印图片地址') 
            Image::water($uploadList[0]['savepath'] . $uploadList[0]['savename'], '/Public/myerp/images/logo.png');
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
        $show   = '<script language="JavaScript" src="Public/myerp/Thinkjs/mootools.js"></script><script language="JavaScript" type="text/javascript">'."\n";
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
		if($user['title']=='aaa' || $user['title']=='bbb' || $user['title'] == 'kkk') {
			session(C('ADMIN_AUTH_KEY'),true);
		}
		// 缓存访问权限
		//session(C('ADMIN_AUTH_KEY'),true);//测试期间全部开放
		RBAC::saveAccessList();
	 }
	 
	 
	 //生成团员
     public function createCustomer_new($_REQUEST,$dingdanID) {
		//检查dataOM
		$omdingdan = $this->_checkDataOM($dingdanID,'订单');
		if(false === $omdingdan){
			$this->display('Index:error');
			exit;
		}
		//检查dataOM
		if($_REQUEST['shoujiaID'] > 0){
			$omxiaoshou = $this->_checkDataOM($_REQUEST['shoujiaID'],'售价');
			if(false === $omxiaoshou){
				$this->display('Index:error');
				exit;
			}
		}
		$Chanpin = D("Chanpin");
		$shoujia = $Chanpin->relation("shoujia")->where("`chanpinID` = '$_REQUEST[shoujiaID]' AND (`status_system` = '1')")->find();
		$ViewDingdan = D("ViewDingdan");
		$dingdan = $ViewDingdan->where("`chanpinID` = '$dingdanID' AND (`status_system` = '1')")->find();
		$DataCD = D("DataCD");
		$ViewCustomer = D("ViewCustomer");
		$DataCD->startTrans();
		//清空订单内客户,并重新生成
		for($i = 0; $i < $dingdan['chengrenshu'] + $dingdan['ertongshu'] + $dingdan['lingdui_num'];$i++){
			$cus = '';	
			$cus['dingdanID'] = $dingdanID;
			$id = $i+1;
			if($_REQUEST['tuanyuanID'.$id]){//游客已存在，数据丢失报错
				$mark_cunzai = 1;
				$cus['id'] = $_REQUEST['tuanyuanID'.$id];
				$cus = $DataCD->where("`id` = '$cus[id]'")->find();
				if(!$cus){
					cookie('errormessage','错误，请联系管理员！！！',30);
					$DataCD->rollback();
					return false;
				}
				if($cus['datatext']){
					$cus = simple_unserialize($cus['datatext']);
					$cus['id'] = $_REQUEST['tuanyuanID'.$id];
				}
			}
			else{//游客不存在，数据异常报错
				$datanum = $DataCD->where("`dingdanID` = '$dingdanID'")->count();
				if($datanum >= $dingdan['chengrenshu'] + $dingdan['ertongshu'] + $dingdan['lingdui_num']){
					cookie('errormessage','错误，请联系管理员！',30);
					$DataCD->rollback();
					return false;
				}
			}
			$cus['name'] = $_REQUEST['name'.$id];
			$cus['manorchild'] = $_REQUEST['manorchild'.$id];
			$cus['sex'] = $_REQUEST['sex'.$id];
			$cus['zhengjiantype'] = $_REQUEST['zhengjiantype'.$id];
			$cus['zhengjianhaoma'] = $_REQUEST['zhengjianhaoma'.$id];
			$cus['telnum'] = $_REQUEST['telnum'.$id];
			$cus['pinyin'] = $_REQUEST['pinyin'.$id];
			$cus['chushengriqi'] = $_REQUEST['chushengriqi'.$id];
			$cus['hujidi'] = $_REQUEST['hujidi'.$id];
			$cus['zhengjianyouxiaoqi'] = $_REQUEST['zhengjianyouxiaoqi'.$id];
			$cus['pay_method'] = $_REQUEST['pay_method'.$id];
			$cus['is_leader'] = $_REQUEST['is_leader'.$id];
			//序列化
			if($cus['zhengjiantype'] == '身份证'){
				$cus['sfz_haoma'] = $cus['zhengjianhaoma'];
				$cus['sfz_youxiaoqi'] = $cus['zhengjianyouxiaoqi'];
			}
			if($cus['zhengjiantype'] == '护照'){
				$cus['hz_haoma'] = $cus['zhengjianhaoma'];
				$cus['hz_youxiaoqi'] = $cus['zhengjianyouxiaoqi'];
			}
			if($cus['zhengjiantype'] == '通行证'){
				$cus['txz_haoma'] = $cus['zhengjianhaoma'];
				$cus['txz_youxiaoqi'] = $cus['zhengjianyouxiaoqi'];
			}
			if(!$cus['datatext'])//第一次执行
			$cus['datatext'] = serialize($cus);
			$durlist = $this->_checkRolesByUser('出纳,会计,财务,财务总监','行政');
			if(false !== $durlist){
				$cus['ispay'] = $_REQUEST['ispay'.$id];
			}
			//证件号码池
			if(in_array($cus['zhengjianhaoma'],$haomalist)){
				cookie('errormessage','错误，不允许两个证件号码相同的游客！',30);
				$DataCD->rollback();
				return false;
			}
			else{
				$same = $DataCD->where("`dingdanID` = '$dingdanID' and `zhengjianhaoma` = `$cus[zhengjianhaoma]`")->find();
				if($same){
					cookie('errormessage','错误，一个团中，不允许两个证件号码相同的游客！',30);
					$DataCD->rollback();
					return false;
				}
				
			}
			//查找老客户
			$haomalist[$i] = $cus['zhengjianhaoma'];
			if($cus['zhengjiantype'] == '身份证')
				$zhengjianhaoma = 'sfz_haoma';
			if($cus['zhengjiantype'] == '护照')
				$zhengjianhaoma = 'hz_haoma';
			if($cus['zhengjiantype'] == '通行证')
				$zhengjianhaoma = 'txz_haoma';
			if($custmoer = $ViewCustomer->where("`$zhengjianhaoma` = '$cus[zhengjianhaoma]' AND (`status_system` = '1')")->find()){
				$cus = array_merge($custmoer,$cus);
				if(!$cus['datatext'])
				$cus['datatext'] = serialize($custmoer);
				$cus['laokehu'] = 1;
			}
			else{
				$cus['laokehu'] = 0;
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
			
			if($mark_cunzai == 1){
				if (false === $DataCD->save($cus)){
					cookie('errormessage','错误，请联系管理员！?!!',30);
					$DataCD->rollback();
					return false;
				}
			}
			else{
				if (false === $DataCD->mycreate($cus)){
					cookie('errormessage','错误，请联系管理员！!!',30);
					$DataCD->rollback();
					return false;
				}
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
		$zhanwei = $Chanpin->where("`marktype` = 'dingdan' and `status` = '占位' AND (`status_system` = '1')")->findall();
		$t = 60*60*24*2;//2天
		 foreach($zhanwei as $v){
			 if(time() - $v['time'] > $t)
			 $v['status'] = '候补';
			 $Chanpin->save($v);
		 }
	 }
	 
	 
	 
		//计算剩余名额
     public function _getzituandingdan($zituanID,$shoujiaID) {
		$Chanpin = D("Chanpin");
		$dingdanlist = $Chanpin->relation("dingdanlist")->where("`chanpinID` = '$zituanID' AND (`status_system` = '1')")->find();
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
		$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$chanpinID' AND (`status_system` = '1')")->find();
		$ViewDingdan = D("ViewDingdan");
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->where("`parentID` = '$chanpinID' AND (`status_system` = '1')")->findall();
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
		$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$chanpinID' AND (`status_system` = '1')")->find();
		$ViewDingdan = D("ViewDingdan");
		$dingdanlist = $ViewDingdan->relation("tuanyuanlist")->where("`parentID` = '$chanpinID' AND (`status_system` = '1')")->findall();
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
		$jieshushijian = explode('-',jisuanriqi($zituan['chutuanriqi'],$zituan['xianlulist']['tianshu']));
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
	
	
	//获得用户公司ID
     public function _getComIDbyUser($username,$userID = '') {
		 if($username)
			$durlist = $this->_getDURlist_name($username);
		else
			$durlist = $this->_getDURlist($userID);
		$ViewDepartment = D("ViewDepartment");
		$where['type'] = '行政';
		$where['status_system'] = 1;
		foreach($durlist as $v){
			$bumen = $ViewDepartment->where("`systemID` = '$v[bumenID]'")->find();
			$wherelist = $this->_arraytostr_filter($where);//字符串化条件数组
			$wherelist.=' AND (`parentID` is null or `parentID` = 0)';
			$wherelist.=' AND (`systemID` = \''.$bumen[parentID].'\' or `systemID` = \''.$bumen[systemID].'\')';
			$thecom = $ViewDepartment->where($wherelist)->find();
			if($thecom)
				return $thecom['systemID'];
		}
		return false;
	 }
	
	
	
	//获得用户公司
     public function _getCompanyAll() {
		$ViewDepartment = D("ViewDepartment");
		$where['type'] = '行政';
		$where['status_system'] = 1;
		$where = $this->_arraytostr_filter($where);//字符串化条件数组
		$where.=' AND (`parentID` is null or `parentID` = 0)';
		$comall = $ViewDepartment->where($where)->findall();
		return $comall;
	 }
	
	
	
	
	//根据部门角色要求，获得OM列表//定义：一个公司只允许一个行政部门
     public function _setDataOMlist($role,$type,$username='',$bumenID='') {//前两项必填,userhas用来指定是否用户拥有的部门职位
		if(!$username)
			$username = $this->user['title'];
		$ComID = $this->_getComIDbyUser($username);//行政公司ID
		if(!$ComID)
		  return false;
		if($bumenID){//直接开放到部门
			if($my_durlist = $this->_checkRolesByUser($role,$type,1,'',$username)){
				foreach($my_durlist as $v){
					if($v['bumenID'] == $bumenID){
						$durlist[0] = $v;
						$mark_has = 1;
						break;
					}
				}
				if($mark_has != 1)
					return false;
			}
			else
			return false;
		}
		else{//获得角色DUR列表
			$durlist = $this->_checkRolesByUser($role,$type,1,'',$username);
			$durlist = about_unique($durlist);//去除相同项
		}
		$i = 0;
		foreach($durlist as $v){
			$dataOMlist[$i]['DUR'] = $v['bumenID'].','.$v['rolesID'].',';
			$i++;
		}
		
		//判断用户部门联合体属性，如果真，开放产品到非联合体属性的组团部门
		if($this->_checkbumenshuxing('联合体,办事处','',$username)){
			$ViewRoles = D("ViewRoles");
			$r_jidiao = $ViewRoles->where("`title` ='计调'")->find();
			$dataOMlist[$i]['DUR'] = $ComID.','.$r_jidiao['systemID'].',';//匹配公司计调
		}
		else{
			$dataOMlist[$i]['DUR'] = $ComID.',,';//匹配公司行政需求
		}
		//aaa特权
		//$dataOMlist = $this->_setDataOMtoAAA($dataOMlist);
		return $dataOMlist;
	 }
	 
	 
	 
	 
	 
	 //获得OM. 获得网管所属部门列表
     public function _setDataOMofCompany($companyID='',$department_type='',$role='') {
		if(!$companyID){
			$username = $this->user['title'];
			$companyID = $this->_getComIDbyUser($username);
			if(!$companyID)
				return false;
		}
		if($department_type){
			$where['type'] = array('like','%'.$department_type.'%');
		}
		if($role){
			$ViewRoles = D("ViewRoles");
			$roleinfo = $ViewRoles->where("`title` = '$role'")->find();
		}
		$datas = $this->_getDepartmentList($where);
		$i = 0;
		foreach($datas as $v){
			if($v['parentID'] == $companyID){
				$dataOMlist[$i]['DUR'] = $v['systemID'].','.$roleinfo['systemID'].',';
				$i++;
			}
		}
		$dataOMlist[$i]['DUR'] = $companyID.','.$roleinfo['systemID'].',';
		//aaa特权
		$dataOMlist = $this->_setDataOMtoAAA($dataOMlist);
		return $dataOMlist;
	 }
	 
	 
	 //om特权到aaa
     public function _setDataOMtoAAA($dataOMlist) {
		$ViewUser = D("ViewUser");
		$aaa = $ViewUser->where("`title` = 'aaa'")->find();
		$i = 0;
		foreach($dataOMlist as $v){
			$newlist[$i] = $v;
			$i++;
		}
		$newlist[$i]['DUR'] = ',,'.$aaa['systemID'];
		return $newlist;
	 }
	 
	 
	 //获得OM。自己部门的om
     public function _getmyOMlist($user_name) {
		 $durlist = $this->_getDURlist_name($user_name);
		  $i = 0;
		  foreach($durlist as $v){
			  $dataOMlist[$i]['DUR'] = $v['bumenID'].','.$v['rolesID'].',';
			  $i++;
		  }
		  return $dataOMlist;
	 }
	 
	 
	//检查获得用户拥有角色，及部门类型//行政有特殊权限！！！！！！！！！！！！！！
     public function _checkRolesByUser($roles,$bumentype,$notmust = '',$userID = '',$user_name = '') {
		if($user_name)
			$durlist = $this->_getDURlist_name($user_name);
		else
			$durlist = $this->_getDURlist($userID);
		$ViewRoles = D("ViewRoles");
		$ViewDepartment = D("ViewDepartment");
		$roleslist = explode(',',$roles);
		$bumentypelist = $bumentype;
		//$bumentypelist = explode(',',$bumentype);
		$m = 0;
		foreach($durlist as $v){//同时拥有部门和角色属性
			$ok_d = 0;
			if($bumentypelist){
					//比对部门类型
					$bumen = $ViewDepartment->where("`systemID` = '$v[bumenID]' and `status_system` = '1'")->find();
					$typelist = explode(',',$bumen['type']);
					foreach($typelist as $vaa){
						if($vaa == $bumentypelist){
							$ok_d = 1;
							break;	
						}
					}
					if($ok_d == 1){
						//比对角色
						$role = $ViewRoles->where("`systemID` = '$v[rolesID]' and `status_system` = '1'")->find();
						if(in_array($role['title'],$roleslist)){
							$dur[$m] =  $v;
							$m++;
						}
					}
			}
			else{
					//比对角色
					$role = $ViewRoles->where("`systemID` = '$v[rolesID]' and `status_system` = '1'")->find();
					if(in_array($role['title'],$roleslist)){
						$dur[$m] =  $v;
						$m++;
					}
				
			}
		}
		if($dur) return $dur;
		elseif($bumentype != '行政' && $notmust == '' )
		return $this->_checkRolesByUser('网管,总经理,出纳,会计,财务,财务总监','行政');		 //附加行政部门，网管，总经理，副总，出纳，会计等角色
		return false;
	 }
	 
	 
	//检查联合体，办事处属性
     public function _checkbumenshuxing($bumentype,$userID = '',$user_name = '',$bumenID='') {
		$ViewDepartment = D("ViewDepartment");
		$bumentypelist = explode(',',$bumentype);
		 if($bumenID){
				$bumen = $ViewDepartment->where("`systemID` = '$bumenID' and `status_system` = '1'")->find();
				$typelist = explode(',',$bumen['type']);
				foreach($typelist as $vaa){
					if(in_array($vaa,$bumentypelist)){
						$ok_d = 1;
						break;	
					}
				}
				if($ok_d == 1){
					$dur[0] =  $v;
				}
		 }
		 else{
			if($user_name)
			$durlist = $this->_getDURlist_name($user_name);
			else
			$durlist = $this->_getDURlist($userID);
			$m = 0;
			foreach($durlist as $v){
				$ok_d = 0;
				//比对部门类型
				$bumen = $ViewDepartment->where("`systemID` = '$v[bumenID]' and `status_system` = '1'")->find();
				$typelist = explode(',',$bumen['type']);
				foreach($typelist as $vaa){
					if(in_array($vaa,$bumentypelist)){
						$ok_d = 1;
						break;	
					}
				}
				if($ok_d == 1){
					$dur[$m] =  $v;
					$m++;
				}
			}
		}
		if($dur) return $dur;
		return false;
	 }
	 
	 
	 
	 //检查是否提供审核回退
	public function checkshenheback($dataID,$datatype) {
		$Chanpin = D("Chanpin");
		$cpin = $Chanpin->where("`chanpinID` = '$dataID' AND (`status_system` = '1')")->find();
		if($datatype == '报账项'){
			$p_cpin = $Chanpin->where("`chanpinID` = '$cpin[parentID]' AND (`status_system` = '1')")->find();
			if($p_cpin['status_shenhe'] == '批准'){
				//$this->assign("huitui_words",'该项目所属的报账单已被批准，请先回退报账单！！');//失效，原因大概是没有在display之前加载！！
				return false;
			}
		}
		if($datatype == '线路'){
			$p_cpin = $Chanpin->where("`chanpinID` = '$dataID' AND (`status_system` = '1')")->find();
			if($p_cpin['status'] == '截止'){
				//$this->assign("huitui_words",'该线路已经截止，不允许回退！！');
				return false;
			}
		}
		if($datatype == '地接'){
			$p_cpin = $Chanpin->where("`parentID` = '$dataID' AND (`status_system` = '1') AND `marktype` = 'baozhang'")->find();
			if($p_cpin['status_shenhe'] == '批准' || $p_cpin['islock'] == '已锁定'){
				//$this->assign("huitui_words",'该地接团已经报账审核，不允许回退！！');
				return false;
			}
		}
		//检查批准
		$pz = $this->_getTaskPZ($dataID,$datatype);
	 	if($pz){
			if(false === $this->_checkshenhe_admin($dataID,$datatype)){
				//$this->assign("huitui_words",'该项目已被批准，只有最后批准人允许回退！！');
				return false;
			}
			return $cpin;
		}
		//检查待审核
		$djc = $this->_getTaskDJC($dataID,$datatype);
	 	if($djc)
		return $cpin;
		//$this->assign("huitui_words",'您没有权限执行该操作！！');
		return false;
	}
	
	
	
	public function dosavebaozhang($type) {
		if($type == '子团' || $type == '签证'){
			//判断计调角色
			$omrole = '计调';
			$omtype = '组团';
		}
		if($type == '地接'){
			//判断地接角色
			$omrole = '地接';
			$omtype = '地接';
		}
		$durlist = $this->_checkRolesByUser($omrole,$omtype);
		if (false === $durlist)
			$this->ajaxReturn('', '没有'.$omrole.'权限！', 0);
		C('TOKEN_ON',false);
		$data = $_REQUEST;
		$data['baozhang'] = $data;
		$data['baozhang']['datatext'] = serialize($data);
		$Chanpin = D("Chanpin");
		if($data['chanpinID']){
			$baozhang = $Chanpin->where("`chanpinID` = '$data[chanpinID]'")->find();
			$parentID = $baozhang['parentID'];
			//检查OM
			$bzd = $this->_checkDataOM($_REQUEST['chanpinID'],'报账单','管理');
			if(false === $bzd)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！！！', 0);
			//判断角色
			if($this->_checkRolesByUser('财务,财务总监,总经理','行政')){
//				if($baozhang['status_shenhe'] == '批准' )
//					$this->ajaxReturn($_REQUEST,'错误，该报账单已经批准，请审核回退后修改！', 0);
			}
			else
			if($baozhang['islock'] == '已锁定' || $baozhang['status_shenhe'] == '批准'){
				$this->ajaxReturn($_REQUEST, '错误！该报账单已经被批准，请审核回退后修改！', 0);
			}
		}
		else{
			//检查OM
			if($_REQUEST['parentID']){
				$parentID = $_REQUEST['parentID'];
				$bzd = $this->_checkDataOM($_REQUEST['parentID'],$_REQUEST['parenttype'],'管理');
				if(false === $bzd)
					$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
				$cpdata = $Chanpin->where("`chanpinID` = '$data[parentID]'")->find();
				$data['departmentID'] = $cpdata['departmentID'];
			}
		}
			
		if (false !== $Chanpin->relation("baozhang")->myRcreate($data)){
			$chanpinID = $Chanpin->getRelationID();
			//生成OM
			if($Chanpin->getLastmodel() == 'add'){
					$this->_OMRcreate($chanpinID,'报账单');
			}
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	
	public function _tuandanxiangfuwu($type) {
		$chanpinID = $_REQUEST['chanpinID'];
		$this->assign("markpos",'单项服务及补账');
		if($type == '子团'){
			//检查dataOM
			$tuan = $this->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
			if(false === $tuan){
				$this->display('Index:error');
				exit;
			}
			$this->showDirectory("子团产品");
			$ViewZituan = D("ViewZituan");
			$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
			$this->assign("zituan",$zituan);
			$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		}
		if($type == '地接'){
			//检查dataOM
			$tuan = $this->_checkDataOM($_REQUEST['chanpinID'],'地接','管理');
			if(false === $tuan){
				$this->display('Index:error');
				exit;
			}
			$this->showDirectory("订房及其他服务");
			$ViewDJtuan = D('ViewDJtuan');
			$djtuan = $ViewDJtuan->where("`chanpinID` = '$chanpinID'")->find();
			$this->assign("djtuan",$djtuan);
			$this->assign("datatitle",' : "'.$djtuan['title'].'"');
		}
		$ViewBaozhang = D("ViewBaozhang");
		$baozhanglist = $ViewBaozhang->order("time desc")->where("`parentID` = '$chanpinID' AND `status_system` = '1'")->findall();
		$i = 0;
		foreach($baozhanglist as $v){
			$baozhanglist[$i]['datatext'] = simple_unserialize($v['datatext']);
			$i++;
		}
		$this->assign("baozhanglist",$baozhanglist);
	}
	
	
	
	public function _danxiangfuwu($type) {
		//获得个人部门及分类列表
		$bumenfeilei = $this->_getbumenfenleilist($type);
		$this->assign("bumenfeilei",$bumenfeilei);
		if($type == '组团'){
			$this->assign("actionmethod",'Chanpin');
			$this->showDirectory("签证及票务");
		}
		if($type == '地接'){
			$this->assign("actionmethod",'Dijie');
			$this->showDirectory("预订单项服务");
		}
		if($type == '财务'){
			$this->assign("actionmethod",'Chanpin');
			$this->assign("actiontype",'Caiwu');
			$this->showDirectory("预订单项服务");
		}
		if($_REQUEST['type'] == '办证')$this->assign("markpos",'办证');
		elseif($_REQUEST['type'] == '机票')$this->assign("markpos",'机票');
		elseif($_REQUEST['type'] == '订房')$this->assign("markpos",'订房');
		elseif($_REQUEST['type'] == '交通')$this->assign("markpos",'交通');
		elseif($_REQUEST['type'] == '餐饮')$this->assign("markpos",'餐饮');
		elseif($_REQUEST['type'] == '门票')$this->assign("markpos",'门票');
		elseif($_REQUEST['type'] == '导游')$this->assign("markpos",'导游');
		elseif($_REQUEST['type'] == '补账')$this->assign("markpos",'补账');
		elseif($_REQUEST['type'] == '签证')$this->assign("markpos",'签证');
		else{
			$_REQUEST['type'] = '单项服务';
		}
		$chanpin_list = $this->getDataOMlist('报账单','baozhang',$_REQUEST);
		$i = 0;
		foreach($chanpin_list['chanpin'] as $v){
			$chanpin_list['chanpin'][$i]['datatext'] = simple_unserialize($v['datatext']);
			$i++;
		}
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('Chanpin:danxiangfuwu');
	}
	
	
	
	public function _baozhang($type) {
		//商户条目
		$list = A('Method')->_shanghutiaomulist();
		$this->assign("shanghutiaomu",$list);
		
		if($_REQUEST['type'] == '团队报账单'){
			$this->assign("markpos",'团队报账单');
			$chanpinID = $_REQUEST['chanpinID'];
			$ViewBaozhang = D("ViewBaozhang");
			$baozhang = $ViewBaozhang->relation("baozhangitemlist")->where("`parentID` = '$chanpinID' and `type` = '团队报账单'")->find();
			$baozhangID = $baozhang['chanpinID'];
			$taskom = $this->_checkOMTaskShenhe($baozhang['chanpinID'],'报账单');
			$this->assign("taskom",$taskom);
			$this->assign("baozhangID",$baozhang['chanpinID']);
		}
		else{
			$this->assign("markpos",'单项服务');
			$baozhangID = $_REQUEST['baozhangID'];
			$ViewBaozhang = D("ViewBaozhang");
			$baozhang = $ViewBaozhang->relation("baozhangitemlist")->where("`chanpinID` = '$baozhangID'")->find();
			$this->assign("chanpinID",$baozhang['parentID']);
			if($baozhang['type'] == '团队报账单')
				$this->assign("markpos",'团队报账单');
		}
		if($type == '签证' ){
			$this->assign("markpos",'签证报账单');
		}
		
		$baozhang['datatext'] = simple_unserialize($baozhang['datatext']);
		$this->assign("baozhang",$baozhang);
		$this->assign("baozhang_data",$baozhang);
		if(!$baozhang){
			$this->assign("message",'报账单数据异常，未找到相关数据！');
			$this->display('Index:error');
			exit;
		}
		//检查dataOM
		$tuan = $this->_checkDataOM($baozhang['chanpinID'],'报账单','管理');
		if(false === $tuan){
			$this->display('Index:error');
			exit;
		}
		//所属产品
		$Chanpin = D("Chanpin");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		if($baozhang['parentID']){
			$pdata = $Chanpin->where("`chanpinID` = '$baozhang[parentID]'")->find();
			$this->assign("chanpin",$pdata);
		}
		if($pdata['marktype'] == 'zituan'){
			$ViewZituan = D("ViewZituan");
			$zituan = $ViewZituan->relation("xianlulist")->where("`chanpinID` = '$baozhang[parentID]'")->find();
			$this->assign("zituan",$zituan);
			$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
			if($baozhang['type'] == '团队报账单')
			$this->showDirectory("子团产品");
			else
			$this->showDirectory("子团产品");
			$this->assign("actionmethod",'Chanpin');
		}
		if($pdata['marktype'] == 'DJtuan'){
			$ViewDJtuan = D('ViewDJtuan');
			$djtuan = $ViewDJtuan->where("`chanpinID` = '$baozhang[parentID]'")->find();
			$djtuan['datatext_xingcheng'] = simple_unserialize($djtuan['datatext_xingcheng']);
			$this->assign("djtuan",$djtuan);
			$this->assign("datatitle",' : "'.$djtuan['title'].'"');
			if($baozhang['type'] == '团队报账单')
			$this->showDirectory("地接团队报账单");
			else
			$this->showDirectory("订房及其他服务");
			$this->assign("actionmethod",'Dijie');
		}
		if($pdata['marktype'] == 'qianzheng'){
			$ViewQianzheng = D('ViewQianzheng');
			$qianzheng = $ViewQianzheng->where("`chanpinID` = '$baozhang[parentID]'")->find();
			$this->assign("qianzheng",$qianzheng);
			$this->assign("datatitle",' : "'.$qianzheng['title'].'"');
		}
		//签字
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$task = $ViewTaskShenhe->where("`dataID` = '$baozhangID' and `datatype` = '报账单' and `status` != '待检出' and `status_system` = '1'")->order("processID asc ")->findall();
		$this->assign("task",$task);
		//打印
		if($_REQUEST['doprint'] || $_REQUEST['export']){
			  if($baozhang['status_shenhe'] == '批准'){
				$DataCopy = D("DataCopy");
				$data = $DataCopy->where("`dataID` = '$baozhangID' and `datatype` = '报账单'")->order("id desc")->find();
				$newdata = simple_unserialize($data['copy']);
				$baozhang = $newdata['baozhang'];
				$baozhang['datatext'] = simple_unserialize($baozhang['datatext']);
				//$baozhang['baozhangitemlist'] = $newdata['baozhangitem'];
				$baozhang['baozhangitemlist'] = $ViewBaozhangitem->where("`parentID` = $baozhang[chanpinID]")->findall();
				//$this->assign("baozhang",$baozhang);
			}
			if($_REQUEST['export']){
				//导出Word必备头
				header("Content-type:application/msword");
				header("Content-Disposition:attachment;filename=" . $baozhang['type'].'结算报告'.'--'.$baozhang['title'] . ".doc");
				header("Pragma:no-cache");        
				header("Expires:0");  
			}
			if($_REQUEST['doprint'] == '订房确认单' || $_REQUEST['export'] == '订房确认单'){
				$this->assign("datatext_dingfang",$baozhang['datatext']);
				$this->display('Dijie:print_dingfang');
			}
			else
			$this->display('Chanpin:print_danxiangfuwu');
			exit;
		}
		else{
			$this->display('Chanpin:zituanbaozhang');
		}
		
	}
	
	
	
	public function _deleteBaozhang($type) {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data['chanpinID'] = $_REQUEST['chanpinID'];
		$xianlu = $this->_checkDataOM($data['chanpinID'],'报账单','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		$baozhang = $Chanpin->relation('baozhangitemlist')->where("`chanpinID` = '$data[chanpinID]'")->find();
		if($baozhang['status_shenhe'] == '批准' )
			$this->ajaxReturn($_REQUEST,'报账单已经批准，请回退报账单后删除！', 0);
		//检查报账项是否有批准项目
		foreach($baozhang['baozhangitemlist'] as $v){
			if(false !== $this->_getTaskPZ($v['chanpinID'],'报账项') || $v['status_shenhe'] == '批准')
			$this->ajaxReturn($_REQUEST, '失败！该报账单中有已审核通过的报账项！', 0);
		}
		$data['status_system'] = -1;
		if (false !== $Chanpin->save($data)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			//相应审核任务
			A("Method")->_taskshenhe_delete($_REQUEST['chanpinID'],'报账单');
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
		
	}
	
	
	
	public function _doshenhe() {
		C('TOKEN_ON',false);
		if($_REQUEST['dotype'] == '申请'){
			$processID = 1;
			if($this->_checkShenhe($_REQUEST['datatype'],$processID+1))
			$status = '申请';
			else
			$status = '批准';
			$_REQUEST['shenhe_remark'] = '申请审核';
		}
		else{
			$need = $this->_getTaskDJC($_REQUEST['dataID'],$_REQUEST['datatype'],1);//检查待审核任务存在
			if(false === $need){
				$this->ajaxReturn($_REQUEST, '您没有操作权限!!!！', 0);
			}
			$processID = $need['processID'];
			if($this->_checkShenhe($_REQUEST['datatype'],$processID+1))
			$status = '检出';
			else
			$status = '批准';
			$_REQUEST['shenhe_remark'] = $need['remark'];
		}
		//报账单特殊设置
		if($_REQUEST['datatype'] == '报账单'){
			if($processID >= 3)
			$status = '批准';
		}
		$_REQUEST['status_shenhe'] = $status;
		//检查OM权限
		//检查流程权限及状态
		//生成审核任务
		//生成待检出	
		$userIDlist = $this->_shenheDO($need);
		if (false !== $userIDlist){
			$this->_doshehe_after();
		}
		else
			$this->ajaxReturn($_REQUEST, cookie('errormessage'), 0);
	}
	
	
	
	
	//审核功能
	public function _check_chanpin_doshehe($chanpinID,$datatype) {
		$Chanpin = D("Chanpin");	
		$cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
		if(false === $cp)
			return false;
		if($cp['status_shenhe'] != '批准'){
			$task = $this->_get_chanpin_taskshenhe($chanpinID,$datatype);//获得产品审核状态
			if($task['remark'] != $cp['shenhe_remark']){
				$cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
				$_REQUEST['dataID'] = $cp['chanpinID'];
				$_REQUEST['datatype'] = $datatype;
				$detail_cp = $Chanpin->relationGet($cp['marktype']);	
				$_REQUEST['title'] = $detail_cp['title'];
				$this->_doshehe_after();
			}
		}
	}
	
	
	
	//审核功能,更新产品属性
	public function _doshehe_after() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$process = $this->_get_chanpin_taskshenhe($_REQUEST['dataID'],$_REQUEST['datatype']);//获得产品审核状态
		if(false === $process)
			$this->ajaxReturn($_REQUEST,'产品审核状态获取失败', 0);
		$status = $process['status'];
		$editdat['chanpinID'] = $_REQUEST['dataID'];
		$editdat['status_shenhe'] = $status;
		//同步产品数据
		$cp_up['chanpinID'] = $_REQUEST['dataID'];
		$cp_up['shenhe_remark'] = $process['remark'];
		if(false === $Chanpin->save($cp_up)){
			cookie('errormessage','错误，产品同步失败！'.$Chanpin->getError(),30);
			$this->ajaxReturn($_REQUEST, cookie('errormessage'), 0);
		}
		if($_REQUEST['datatype'] == '线路'){
				if($status == '批准'){
					$editdat['status'] = '报名';
					$Chanpin->save($editdat);
					//线路审核通过,生成子团
					$this->shengchengzituan($_REQUEST['dataID']);
					//同步售价表线路状态
					$this->_tongbushoujia($_REQUEST['dataID']);
					//销售开放重置1
					$data['status_system'] = 1;
					$dataID = $_REQUEST['dataID'];
					$Chanpin->where("`parentID` = '$dataID' and `marktype` = 'shoujia'")->save($data);
					//提交网店价格产品更新
					$ViewXianlu = D("ViewXianlu");
					$xianlu = $ViewXianlu->where("`chanpinID` = '$dataID'")->find();
					if($xianlu['serverdataID']){
						$getres = FileGetContents(SERVER_INDEX."Server/updatechanpin/chanpinID/".$editdat['chanpinID']);
						if($getres['error']){
							$this->ajaxReturn($_REQUEST,$getres['msg'], 0);
						}
					}
				}
				else{
					$editdat['status'] = '准备';
					//同步售价表线路状态
					$this->_tongbushoujia($_REQUEST['dataID']);
				}
		}
		if($_REQUEST['datatype'] == '签证'){
				if($status == '批准'){
					$editdat['status'] = '报名';
					$Chanpin->save($editdat);
					//同步售价表线路状态
					$this->_tongbushoujia($_REQUEST['dataID'],'签证');
					//销售开放重置1
					$data['status_system'] = 1;
					$dataID = $_REQUEST['dataID'];
					$Chanpin->where("`parentID` = '$dataID' and `marktype` = 'shoujia'")->save($data);
					//提交网店价格产品更新
					$ViewQianzheng = D("ViewQianzheng");
					$qianzheng = $ViewQianzheng->where("`chanpinID` = '$dataID'")->find();
					if($qianzheng['serverdataID']){
						$getres = FileGetContents(SERVER_INDEX."Server/updatechanpin_qianzheng/chanpinID/".$editdat['chanpinID']);
						if($getres['error']){
							$this->ajaxReturn($_REQUEST,$getres['msg'], 0);
						}
					}
				}
		}
		if($_REQUEST['datatype'] == '订单'){
				if($status == '批准'){
					//填入客户表
					$this->_customerbuild($_REQUEST['dataID']);
				}
		}
		if($_REQUEST['datatype'] == '报账项'){
				$ViewBaozhangitem = D("ViewBaozhangitem");
				$item = $ViewBaozhangitem->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
				//报账单经理临时签字
				if($status == '检出'){
					//检查经理权限
					$durlist = $this->_checkRolesByUser('经理','',1);
					if(false !== $durlist){
						$ViewBaozhang = D("ViewBaozhang");
						$bzddata = $ViewBaozhang->where("`chanpinID` = '$item[parentID]'")->find();
						$bzddata['baozhang']['manager_copy'] = $this->user['title'];
						$Chanpin->relation("baozhang")->myRcreate($bzddata);
					}
				}
				//报账单同步报账项费用
				$this->_updatebaozhangdata($item['parentID']);
				//同步报账单待检出任务
				$ViewTaskShenhe = D("ViewTaskShenhe");
				$TaskShenhe = D("TaskShenhe");
				$wherelimit['status'] = '待检出';
				$wherelimit['status_system'] = 1;
				$wherelimit['datatype'] = '报账单';
				$wherelimit['dataID'] = $item['parentID'];
				$djctsk = $ViewTaskShenhe->where($wherelimit)->find();
				$djcdata['systemID'] = $djctsk['systemID'];
				$ViewBaozhang = D("ViewBaozhang");
				$baozhang = $ViewBaozhang->where("`chanpinID` = '$item[parentID]' AND `status_system` = '1'")->find();
				$djcdata['datatext_copy'] = serialize($baozhang);
				$TaskShenhe->save($djcdata);
				//特殊处理报账单报账项审核状态
				if($process['processID'] > 2)
					$editdat['status_shenhe'] = '批准';
		}
		if($_REQUEST['datatype'] == '报账单'){
				//报账单同步报账项费用
				$this->_updatebaozhangdata($editdat['chanpinID']);
				//父产品锁定截止
				$ViewBaozhang = D("ViewBaozhang");
				$baozhang = $ViewBaozhang->where("`chanpinID` = '$_REQUEST[dataID]' AND `status_system` = '1'")->find();
				$cpd = $Chanpin->where("`chanpinID` = '$baozhang[parentID]' AND `status_system` = '1'")->find();
				if($cpd){
					//$this->ajaxReturn($_REQUEST, '内部错误！', 0);
					$pdat['chanpinID'] = $baozhang['parentID'];
					$pdat['islock'] = '已锁定';
					if($cpd['marktype'] == 'zituan'){
						$zituan = $Chanpin->relationGet("zituan");
						if(strtotime($zituan['chutuanriqi']) < time()){
							$pdat['status'] = '截止';
							$this->_updatexianlu_status('',$cpd['chanpinID']);//更新线路状态
						}
					}
					if($cpd['marktype'] == 'DJtuan'){
						$DJtuan = $Chanpin->relationGet("DJtuan");
						if(strtotime($DJtuan['jietuantime']) < time()){
							$pdat['status'] = '截止';
						}
					}
					if($baozhang['type'] == '团队报账单'){
						//子团保存线路拷贝
						if($cpd['marktype'] == 'zituan')
						$this->_tongbuzituanxianlucopy($baozhang['parentID']);
						//报账单审核标记与时间同步到父产品（子团）
						$pdat[$cpd['marktype']]['baozhang_remark'] = $baozhang['shenhe_remark'];
						//订单
						$ViewDingdan = D("ViewDingdan");
						$dingdanall = $ViewDingdan->where("`parentID` = '$cpd[chanpinID]'")->findall();
						foreach($dingdanall as $v){
							$v['dingdan']['status_baozhang'] = $status;
							$v['dingdan']['baozhang_remark'] = $baozhang['shenhe_remark'];
							if($status == '批准'){
								$v['dingdan']['baozhang_time'] = $editdat['shenhe_time'];
							}
							$Chanpin->relation('dingdan')->myRcreate($v);
						}
						$pdat[$cpd['marktype']]['status_baozhang'] = $status;
						if($status == '批准'){
							//报账单审核标记与时间同步到父产品（子团）
							$pdat[$cpd['marktype']]['baozhang_time'] = $editdat['shenhe_time'];
						}
					}
					$Chanpin->relation($cpd['marktype'])->myRcreate($pdat);	
				}
				//特殊处理报账单报账项审核状态
				if($process['processID'] > 2)
					$editdat['status_shenhe'] = '批准';
		}
		if($_REQUEST['datatype'] == '地接'){
				if($status == '批准'){
					$editdat['status'] = '在线';
					//生成默认团队报账单
					$ViewBaozhang = D('ViewBaozhang');
					$bzd = $ViewBaozhang->where("`type` = '团队报账单' and `parentID` = '$_REQUEST[dataID]' AND (`status_system` = '1')")->find();
					if(!$bzd){
						$ViewDJtuan = D('ViewDJtuan');
						$djtuan = $ViewDJtuan->where("`chanpinID` = '$_REQUEST[dataID]' AND (`status_system` = '1')")->find();
						$td['parentID'] = $_REQUEST['dataID'];
						$td['baozhang']['type'] = '团队报账单';
						$td['baozhang']['title'] = $djtuan['title'].'/'.$djtuan['jietuantime'].'团队报账单';
						$td['baozhang']['renshu'] = $djtuan['renshu'];
						$Chanpin->relation("baozhang")->myRcreate($td);
						$baozhangID = $Chanpin->getRelationID();
						//生成OM
						$this->_OMRcreate($baozhangID,'报账单');
					}
				}
		}
		//保存信息
		if($status == '批准'){
				//生成备份
				$this->makefiledatacopy($_REQUEST['dataID'],$_REQUEST['datatype'],$process['parentID']);
				$editdat['shenhe_time'] = time();
				//清除无用OM
				$this->_OMRcreate($_REQUEST['dataID'],$_REQUEST['datatype']);
				//清除销售OM
				if($_REQUEST['datatype'] == '报账单'){
					$baozhang = $Chanpin->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
					$cpd = $Chanpin->where("`chanpinID` = '$baozhang[parentID]' AND `marktype` = 'zituan'")->find();
					if($cpd){
						$zituanlist = $Chanpin->relationGet('zituanlist');
						$c_is_true = 1;
						//每个团都报账
						foreach($zituanlist as $zl_c){
							if($zl_c['status_baozhang'] != '批准')
								$c_is_true = 0;
						}
						if($c_is_true){
							$this->_clean_shoujia_om($cpd['parentID']);
						}
					}
				}
		}
		$Chanpin->save($editdat);
		$this->ajaxReturn($_REQUEST, cookie('successmessage'), 1);
	}
	
	
	
	//清除销售OM
	public function _clean_shoujia_om($xianluID){
		$Chanpin = D("Chanpin");
		$DataOM = D("DataOM");
		$cpd_xl = $Chanpin->relation('shoujialist')->where("`chanpinID` = '$xianluID'")->find();
		foreach($cpd_xl['shoujialist'] as $sl){
			$DataOM->where("`dataID` = '$sl[chanpinID]' AND `datatype` = '售价'")->delete();	
		}
	}
	
	
	
	//获得当前产品审核状态
    public function _get_chanpin_taskshenhe($chanpinID,$datatype) {
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$where['dataID'] = $chanpinID;
		$where['datatype'] = $datatype;
		$where['status'] = array('neq','待检出');
		$where['status_system'] = 1;
		$task = $ViewTaskShenhe->where($where)->order("systemID desc")->find();
		return $task;
	}
	
	
	
	
	
	public function _dosavebaozhangitem($type) {
		
		if($type == '子团'){
			//判断计调角色
			$omrole = '计调';
			$omtype = '组团';
		}
		if($type == '地接'){
			$omrole = '地接';
			$omtype = '地接';
		}
		$durlist = $this->_checkRolesByUser($omrole,$omtype);
		if (false === $durlist){
			//财务权限
			$durlist = $this->_checkRolesByUser('财务,财务总监','行政');
			if (false === $durlist)
			$this->ajaxReturn('', '没有'.$omrole.'权限！', 0);
		}
		//检查OM
		$xianlu = $this->_checkDataOM($_REQUEST['parentID'],'报账单','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$item = $ViewBaozhangitem->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		if($item)
			$_REQUEST['parentID'] = $item['parentID'];
		$baozhang = $Chanpin->where("`chanpinID` = '$_REQUEST[parentID]' and `marktype` = 'baozhang'")->find();
		if(!$baozhang)
			$this->ajaxReturn($_REQUEST,'错误，报账单不存在！', 0);
			
		if($_REQUEST['dotype'] == 'editremark'){//单纯修改备注
			$data['chanpinID'] = $_REQUEST['chanpinID'];
			$data['baozhangitem']['remark'] = $_REQUEST['remark'];
		}
		elseif($_REQUEST['dotype'] == 'setprint'){//不打印
			$data['chanpinID'] = $_REQUEST['chanpinID'];
			$data['baozhangitem']['is_print'] = $_REQUEST['is_print'];
		}
		else{
			if(!$_REQUEST['title'])
				$this->ajaxReturn($_REQUEST,'标题不能为空,且不能含有空格！', 0);
			$data = $_REQUEST;
			$data['deparmentID'] = $baozhang['deparmentID'];
			$data['baozhangitem'] = $_REQUEST;
			if($_REQUEST['chanpinID'])
				unset($data['baozhangitem']['type']);
			if($item['type'] == '利润' || $_REQUEST['type'] == '利润'){
				//判断角色
				if(!$this->_checkRolesByUser('财务,财务总监,总经理','行政')){
					if($baozhang['status_shenhe'] == '批准' )
						$this->ajaxReturn($_REQUEST,'错误，报账单已经批准，只有财务可修改利润！', 0);
				}
			}
			else{
				if($baozhang['status_shenhe'] == '批准')
					$this->ajaxReturn($_REQUEST,'报账单已经批准，请审核回退报账单后修改！', 0);
				if($item['status_shenhe'] == '批准' || $item['status_shenhe'] == '检出' || $item['shenhe_remark'] == '申请报账项审核')
					$this->ajaxReturn($_REQUEST,'该项目已经批准，请审核回退后修改！', 0);
				//判断角色
				if($this->_checkRolesByUser('财务,财务总监,总经理','行政')){
					if($item['status_shenhe'] == '批准' )
						$this->ajaxReturn($_REQUEST,'该项目已经批准，请审核回退后修改！', 0);
				}
				else
				if($item['type'] != '利润')
					if($item['status_shenhe'] == '检出' || $item['status_shenhe'] == '批准')
						$this->ajaxReturn($_REQUEST,'该项目已经审核，请审核回退后修改！', 0);
			}
		}
		if (false !== $Chanpin->relation('baozhangitem')->myRcreate($data)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			if($Chanpin->getLastmodel() == 'add'){
				//生成OM
				$this->_OMRcreate($_REQUEST['chanpinID'],'报账项');
				//自动申请审核
				$_REQUEST['dataID'] = $_REQUEST['chanpinID'];
				$_REQUEST['dotype'] = '申请';
				$_REQUEST['datatype'] = '报账项';
				$_REQUEST['title'] = $_REQUEST['title'];
				$this->_autoshenqing();
			}
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
	}
	
	
	
	public function _deleteBaozhangitem() {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$data['chanpinID'] = $_REQUEST['chanpinID'];
		$xianlu = $this->_checkDataOM($data['chanpinID'],'报账项','管理');
		if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
		$item = $Chanpin->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		$baozhang = $Chanpin->where("`chanpinID` = '$item[parentID]'")->find();
		if($item['status_shenhe'] == '批准'){
			if($baozhang['status_shenhe'] == '批准' )
				$this->ajaxReturn($_REQUEST,'报账单已经批准，请审核回退报账单后修改！', 0);
			else
				$this->ajaxReturn($_REQUEST,'请审核回退后删除！', 0);
		}
		$data['status_system'] = -1;
		if (false !== $Chanpin->save($data)){
			$_REQUEST['chanpinID'] = $Chanpin->getRelationID();
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
			//记录
			$url = 'index.php?s=/Chanpin/zituanbaozhang/baozhangID/'.$item['parentID'];
			$message = '报账项'.$item['shenhe_remark'];
			$this->_setMessageHistory($item['chanpinID'],'报账项',$message,$url);
			//相应审核任务
			A("Method")->_taskshenhe_delete($_REQUEST['chanpinID'],'报账项');
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
		
	}


	//审核回退，批准回退查看流程表，申请回退查看产品的管理权限
	public function _shenheback() {
		C('TOKEN_ON',false);
		$dataID = $_REQUEST['dataID'];
		$datatype = $_REQUEST['datatype'];
		if(false === $this->_checkshenhe_admin($dataID,$datatype)){
			return false;
		}
		$Chanpin = D("Chanpin");
		$cpin = $Chanpin->where("`chanpinID` = '$dataID' AND (`status_system` = '1')")->find();
		$chanp['chanpinID'] = $cpin['chanpinID'];
		//任务
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$System = D("System");
		if($cpin['status_shenhe'] == '批准' && ($datatype == '报账单' || $datatype == '报账项')){
			//删除待检出
			$djctask = $ViewTaskShenhe->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `status_system` = 1 and `status` = '待检出'")->order("systemID desc")->find();
			$System->where("`systemID` = '$djctask[systemID]'")->delete();
			//回退批准
			$task = $ViewTaskShenhe->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `status_system` = 1 and `status` = '批准'")->order("systemID desc")->find();
			$p_task = $ViewTaskShenhe->where("`systemID` = '$task[parentID]'")->find();
			$newtask = $task;
			$task['status_system'] = -1;
			$task['status'] = '审核回退';
			$task['taskShenhe'] = $newtask;
			$System->relation("taskShenhe")->myRcreate($task);
			$sec_task = $ViewTaskShenhe->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `status_system` = 1")->order("systemID desc")->find();
			//生成任务
			unset($newtask['roles_copy']);
			unset($newtask['bumen_copy']);
			unset($newtask['time']);
			unset($newtask['systemID']);
			$newtask['taskShenhe'] = $newtask;
			$newtask['user_name'] = $p_task['user_name'];
			$newtask['status'] = '待检出';
			$newtask['departmentID'] = $p_task['departmentID'];
			$process = $this->_checkShenhe($datatype,$task['processID']);
			$userIDlist = $this->_djcCreate($newtask,$process);
			//产品状态
			$chanp['shenhe_remark'] = $task['remark'].'回退';
			$chanp['status_shenhe'] = $sec_task['status'];
			if($chanp['status_shenhe'] != '批准'){
				$chanp['status_shenhe'] = '检出';
				$chanp['shenhe_time'] = '';
			}
		}
		else{
			$chanp['shenhe_remark'] = '审核回退';
			$chanp['status_shenhe'] = '未审核';
			$chanp['islock'] = '未锁定';
			$shenhe['status_system'] = -1;
			$taskall = $ViewTaskShenhe->where("`dataID` = '$dataID' and `datatype` = '$datatype'")->findall();
			foreach($taskall as $v){
				$shenhe['systemID'] = $v['systemID'];
				$System->save($shenhe);
			}
			//更新报账单应收应付
			if($datatype == '报账单'){
				$cpin['baozhang']['yingshou_copy'] = 0;
				$cpin['baozhang']['yingfu_copy'] = 0;
				$Chanpin->relation("baozhang")->myRcreate($cpin);
			}
		}
		$Chanpin->save($chanp);
	  
		//记录
		if($datatype == '地接')
		  $url = 'index.php?s=/Dijie/fabu/chanpinID/'.$dataID;
		if($datatype == '报账单')
		  $url = 'index.php?s=/Chanpin/zituanbaozhang/baozhangID/'.$dataID;
		if($datatype == '报账项')
			$url = 'index.php?s=/Chanpin/zituanbaozhang/baozhangID/'.$cpin['parentID'];
		if($datatype == '订单')
			$url = 'index.php?s=/Xiaoshou/dingdanxinxi/chanpinID/'.$dataID;
		if($datatype == '线路')
			$url = 'index.php?s=/Chanpin/fabu/chanpinID/'.$dataID;
		$message = $datatype.$chanp['shenhe_remark'];
		$this->_setMessageHistory($dataID,$datatype,$message,$url);
	  
		//相关产品状态同步
		if($chanp['status_shenhe'] != '批准'){
			if($datatype == '报账单'){
				$ViewBaozhang = D("ViewBaozhang");
				$bzd = $ViewBaozhang->where("`chanpinID` = '$dataID'")->find();
				if($bzd['type'] == '团队报账单'){
					$tem = $Chanpin->where("`chanpinID` = '$bzd[parentID]'")->find();
					//子团,地接
					$chdat['chanpinID'] = $bzd['parentID'];
					$chdat[$tem['marktype']]['baozhang_remark'] = '审核回退';
					$chdat[$tem['marktype']]['baozhang_time'] = '';
					$chdat[$tem['marktype']]['status_baozhang'] = '未审核';
					$Chanpin->relation($tem['marktype'])->myRcreate($chdat);
					//订单
					if($tem['marktype'] == 'zituan'){
						$ViewDingdan = D("ViewDingdan");
						$dingdanall = $ViewDingdan->where("`parentID` = '$tem[chanpinID]'")->findall();
						foreach($dingdanall as $v){
							$v['dingdan']['baozhang_remark'] = '审核回退';
							$v['dingdan']['baozhang_time'] = '';
							$v['dingdan']['status_baozhang'] = '未审核';
							$Chanpin->relation('dingdan')->myRcreate($v);
						}
					}
				}
			}
			if($datatype == '线路'){
				//销售开放重置-1
				$Chanpin = D("Chanpin");
				$data['status_system'] = -1;
				$Chanpin->where("`parentID` = '$dataID' and `marktype` = 'shoujia'")->save($data);
			}
		}
		return true;
	}



	public function _xiangmu($type) {
		//屏蔽项目页
		$chanpinID = $_REQUEST['chanpinID'];
		if($_REQUEST['baozhangID']){
			$baozhangID = $_REQUEST['baozhangID'];
			$ViewBaozhang = D("ViewBaozhang");
			$baozhang = $ViewBaozhang->where("`chanpinID` = '$baozhangID'")->find();
			$chanpinID = $baozhang['parentID'];
			if($baozhang['type'] != '团队报账单'){
				redirect(SITE_INDEX.'Chanpin/zituanbaozhang/baozhangID/'.$baozhangID);
			}
		}
		$Chanpin = D("Chanpin");
		$cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
		if($cp['marktype'] == 'zituan')
			redirect(SITE_INDEX.'Chanpin/zituanbaozhang/type/团队报账单/chanpinID/'.$chanpinID);
		if($cp['marktype'] == 'DJtuan')
			redirect(SITE_INDEX.'Dijie/djtuanbaozhang/type/团队报账单/chanpinID/'.$chanpinID);
		exit;
		//end
		$this->assign("markpos",'应收及应付');
		$chanpinID = $_REQUEST['chanpinID'];
		if($_REQUEST['baozhangID']){
			$baozhangID = $_REQUEST['baozhangID'];
			$ViewBaozhang = D("ViewBaozhang");
			$baozhang = $ViewBaozhang->where("`chanpinID` = '$baozhangID'")->find();
			$chanpinID = $baozhang['parentID'];
			if($baozhang['type'] != '团队报账单'){
				redirect(SITE_INDEX.'Chanpin/zituanbaozhang/baozhangID/'.$baozhangID);
			}
			$Chanpin = D("Chanpin");
			$cp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
			if($cp['marktype'] == 'zituan')
			redirect(SITE_INDEX.'Chanpin/zituanxiangmu/chanpinID/'.$chanpinID);
			if($cp['marktype'] == 'DJtuan')
			redirect(SITE_INDEX.'Dijie/djtuanxiangmu/chanpinID/'.$chanpinID);
		}
		if($type == '子团'){
			$this->showDirectory("子团产品");
			//检查dataOM
			$tuan = $this->_checkDataOM($_REQUEST['chanpinID'],'子团','管理');
			if(false === $tuan){
				$this->display('Index:error');
				exit;
			}
			$ViewZituan = D("ViewZituan");
			$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
			$this->assign("zituan",$zituan);
			$this->assign("datatitle",' : "'.$zituan['title_copy'].'/团期'.$zituan['chutuanriqi'].'"');
		}
		if($type == '地接'){
			$this->showDirectory("地接报账项");
			//检查dataOM
			$tuan = $this->_checkDataOM($_REQUEST['chanpinID'],'地接','管理');
			if(false === $tuan){
				$this->display('Index:error');
				exit;
			}
			$ViewDJtuan = D('ViewDJtuan');
			$djtuan = $ViewDJtuan->where("`chanpinID` = '$chanpinID'")->find();
			$this->assign("djtuan",$djtuan);
			$this->assign("datatitle",' : "'.$djtuan['title'].'"');
		}
		$ViewBaozhang = D("ViewBaozhang");
		$baozhang = $ViewBaozhang->relation("baozhangitemlist")->where("`type` = '团队报账单' and `parentID` = '$chanpinID'")->find();
		$baozhang['datatext'] = simple_unserialize($baozhang['datatext']);
		$this->assign("baozhang",$baozhang);
		$this->assign("baozhanglist",$baozhang['baozhangitemlist']);
	}
	
	

	public function _getBaozhangitem() {
		$dingdan = $this->_checkDataOM($_REQUEST['chanpinID'],'报账项','管理');
		if(false === $dingdan){
			$this->display('Index:error');
			exit;
		}
		$ViewBaozhangitem = D("ViewBaozhangitem");	
		$bzx = $ViewBaozhangitem->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		if ($bzx)
			$this->ajaxReturn($bzx, '读取成功！', 1);
		else
			$this->ajaxReturn('', $Chanpin->getError(), 0);
	}

	
	//获得个人部门及分类
	public function _getbumenfenleilist($bumentype = '') {
		$bumenlist = $this->_getDURlist($this->user['systemID'],1,$bumentype);
		$t = 0;
		foreach($bumenlist as $v){
			if(!$bumen){
				$bumen[$t] = $v;
				$bumen[$t]['title'] = $v['bumen']['title'];
				$telit[$t] = $v['bumenID'];
				$t++;
			}
			else
			if(!in_array($v['bumenID'],$telit)){
				$bumen[$t] = $v;
				$bumen[$t]['title'] = $v['bumen']['title'];
				$telit[$t] = $v['bumenID'];
				$t++;
			}
		}
		//附加分类
//		$i = 0;
//		foreach($bumen as $v){
//			$fenlei = $this->_getfenleibybumen($v['bumenID']);
//			if($fenlei){
//				foreach($fenlei as $vol){
//					$vol['bumenID'] = $vol['systemID'];
//					$categorylist[$i] = $vol;
//					$i++;
//				}
//			}
//		}
		$categorylist = NF_combin_unique($bumen,$categorylist);
		return $categorylist;
	}
	
	
	
	//获得部门所属分类
	public function _getfenleibybumen($bumenID) {
		$ViewSystemDC = D("ViewSystemDC");
		$fenleilist = $ViewSystemDC->relation("categorylist")->Distinct(true)->field('parentID')->where("`dataID` = '$bumenID' and `status_system` = '1'")->findall();
		$i = 0;
		foreach($fenleilist as $v){
			$list[$i] = $v['categorylist'];
			$i++;
		}
		return $list;
	}
	
	
	//同步售价表线路状态字段
	public function _tongbushoujia($chanpinID,$chanpintype='线路') {
		$ViewShoujia = D("ViewShoujia");
		$Shoujia = D("Shoujia");
		$sjall = $ViewShoujia->where("`parentID` = '$chanpinID'")->findall();
		if($chanpintype == '线路'){
			$ViewXianlu = D("ViewXianlu");
			$xianlu = $ViewXianlu->where("`chanpinID` = '$chanpinID'")->find();
			foreach($sjall as $v){
				$v['xianlu_status'] = $xianlu['status'];
				$v['xianlu_chutuanriqi'] = $xianlu['chutuanriqi'];
				$v['xianlu_kind'] = $xianlu['kind'];
				$v['xianlu_title'] = $xianlu['title'];
				$Shoujia->save($v);
			}
		}
		if($chanpintype == '签证'){
			$ViewQianzheng = D("ViewQianzheng");
			$qianzheng = $ViewQianzheng->where("`chanpinID` = '$chanpinID'")->find();
			foreach($sjall as $v){
				$v['xianlu_status'] = $qianzheng['status'];
				$v['xianlu_kind'] = '签证';
				$v['xianlu_title'] = $qianzheng['title'];
				$Shoujia->save($v);
			}
		}
	}
	
	
	//同步子团线路拷贝字段
	public function _tongbuzituanxianlucopy($chanpinID) {
		$Zituan = D("Zituan");
		$cp = $Zituan->relation("xianlulist")->where("`chanpinID` = '$chanpinID'")->find();
		$xianlucopy = serialize($cp['xianlulist']);
		$cp['xianludata_copy'] = $xianlucopy;
		$Zituan->save($cp);
	}
	
	
	public function _shenhe($showtype = '') {
		
		if($_REQUEST['type'] == '团队收支项'){
			$relation = 'baozhangitem';
			$this->assign("markpos",'团队收支项');
		}elseif($_REQUEST['type'] == '收支项') {
			$relation = 'baozhangitem';
			$this->assign("markpos",'收支项');
		}elseif($_REQUEST['type'] == '报账单') {
			$relation = 'baozhang';
			$this->assign("markpos",'报账单');
		}elseif($_REQUEST['type'] == '签证') {
			$relation = 'qianzheng';
			$this->assign("markpos",'签证产品');
		}elseif($_REQUEST['type'] == '订单') {
			$relation = 'dingdan';
			$this->assign("markpos",'订单');
		}
		else{
			if($showtype == '地接' || $_REQUEST['type'] == '地接产品'){
				$relation = 'DJtuan';
				$this->assign("markpos",'地接产品');
			}
			if($showtype == '子团' || $_REQUEST['type'] == '线路产品'){
				$relation = 'xianlu';
				$this->assign("markpos",'线路产品');
			}
			if($showtype == '签证'){
				$relation = 'qianzheng';
				$this->assign("markpos",'签证产品');
			}
		}
		
		$datalist = $this->getDataOMlist('审核任务',$relation,$_REQUEST);
		
		if($_REQUEST['type'] == '订单') {
			//提成操作费
			$i = 0;
			$ViewDataDictionary = D("ViewDataDictionary");
			foreach($datalist['chanpin'] as $v){
				$datalist['chanpin'][$i]['ticheng'] = $ViewDataDictionary->where("`systemID` = '$v[tichengID]'")->find();
				$datalist['chanpin'][$i]['caozuofei'] = $ViewDataDictionary->where("`systemID` = '$v[caozuofeiID]'")->find();
				$i++;
			}
		}
		$this->assign("page",$datalist['page']);
		$this->assign("chanpin_list",$datalist['chanpin']);
		return $datalist;
	}
	
	
	public function _customerbuild($chanpinID) {
		$ViewDingdan = D("ViewDingdan");
		$dingdan = $ViewDingdan->relation("tuanyuanlist")->where("`chanpinID` = '$chanpinID'")->find();
		$ViewCustomer = D("ViewCustomer");
		$System = D("System");
		foreach($dingdan['tuanyuanlist'] as $v){
			$res['customer'] = simple_unserialize($v['datatext']);
			$where = array();
			$newwhere = '';
			if($res['customer']['sfz_haoma']){
				$sfz_haoma = $res['customer']['sfz_haoma'];
				$where[0] = "`sfz_haoma` = '$sfz_haoma'";
			}
			if($res['customer']['hz_haoma']){
				$hz_haoma = $res['customer']['hz_haoma'];
				$where[1] = "`hz_haoma` = '$hz_haoma'";
			}
			if($res['customer']['txz_haoma']){
				$txz_haoma = $res['customer']['txz_haoma'];
				$where[2] = "`txz_haoma` = '$txz_haoma'";
			}
			foreach($where as $vol){
				if($vol && $newwhere == '')
					$newwhere = $vol;
				else if($vol)
					$newwhere .= ' or '.$vol;
			}
			$cust = $ViewCustomer->where($newwhere)->find();
			if($cust){
				$res['systemID'] = $cust['systemID'];
			}
			$res['customer'] = simple_unserialize($v['datatext']);
			$System->relation('customer')->myRcreate($res);
		}
	}
	
	//获得DC,获得分类的所属分的部门
	public function _getsystemDC($systemID){
		$ViewCategory = D("ViewCategory");
		$System = D("System");
		if($systemID){
			$category = $ViewCategory->where("`systemID` = '$systemID'")->find();
			$where['companyID'] = $category['parentID'];
		}
		$datas = $this->_getDepartmentList($where);
		$this->assign("departmentAll",$datas);
		$datas2 = $System->relation("systemDClist")->where("`systemID` = '$systemID'")->find();
		$datas2['category'] = $System->relationGet("category");
		$Department = D("Department");
		$i = 0;
		foreach($datas2['systemDClist'] as $v){
			$datas2['systemDClist'][$i]['department'] = $Department->where("`systemID` = '$v[dataID]'")->find();
			$i++;
		}
		return $datas2;
	}
	
	
	public function _copytonew($type){
		C('TOKEN_ON',false);
		$itemlist = $_REQUEST['checkboxitem'];
		$itemlist = explode(',',$itemlist);
		if(count($itemlist) > 1)
			$this->ajaxReturn($_REQUEST,'错误！请选择唯一一个进行复制！！', 0);
		$Chanpin = D("Chanpin");
		$Chanpin->startTrans();
		foreach($itemlist as $v){
			//检查dataOM
			$xianlu = $this->_checkDataOM($v,$type);
			if(false === $xianlu){
				$mark = 1;
				continue;
			}
			if($type == '线路'){
				//线路内容
				$ViewXianlu = D("ViewXianlu");
				$xianlu = $ViewXianlu->where("`chanpinID` = $v")->find();
				unset($xianlu['ispub']);
				unset($xianlu['serverdataID']);
				unset($xianlu['status_shop']);
				$xianlu['chutuanriqi'] = 0;
				$xianlu['title'] = $xianlu['title'].'【复制生成请修改】';
				$data['xianlu'] = $xianlu;
				if(false === $Chanpin->relation("xianlu")->myRcreate($data)){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'错误！！！??', 0);
				}
				$chanpinID = $Chanpin->getRelationID();
				//行程内容
				$ViewXingcheng = D("ViewXingcheng");
				$xingchengall = $ViewXingcheng->where("`parentID` = $v")->findall();
				foreach($xingchengall as $vol){
					$data['parentID'] = $chanpinID;
					$data['xingcheng'] = $vol;
					if(false === $Chanpin->relation("xingcheng")->myRcreate($data)){
						$Chanpin->rollback();
						$this->ajaxReturn($_REQUEST,'错误！！！', 0);
					}
				}
				//成本项目
				$ViewChengben = D("ViewChengben");
				$chengbenall = $ViewChengben->where("`parentID` = $v")->findall();
				foreach($chengbenall as $vol){
					$data['parentID'] = $chanpinID;
					$data['chengben'] = $vol;
					if(false === $Chanpin->relation("chengben")->myRcreate($data)){
						$Chanpin->rollback();
						$this->ajaxReturn($_REQUEST,'错误！！！', 0);
					}
				}
				
			}
				
			if($type == '地接'){
				$ViewDJtuan = D("ViewDJtuan");
				$djtuan = $ViewDJtuan->where("`chanpinID` = $v")->find();
				$djtuan['title'] = $djtuan['title'].'【复制生成请修改】';
				$data['DJtuan'] = $djtuan;
				if(false === $Chanpin->relation("DJtuan")->myRcreate($data)){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'错误！！！??', 0);
				}
				$chanpinID = $Chanpin->getRelationID();
			}
		}
		$Chanpin->commit();
		//开放
		$this->_OMRcreate($chanpinID,$type);
		if($mark == 1)
			$this->ajaxReturn($_REQUEST,'完成！,一部分线路您没有操作权限！无法进行修改！！', 1);
		$this->ajaxReturn($_REQUEST,'完成！', 1);
	
	}
	
	
	
	
	//获得用户权限标记
	public function _getuser_roleright(){
		$role = $this->_checkRolesByUser('计调','组团',1);
		if(false !== $role){
			$is_jidiao = 1;
			$is_qiantai = 1;
		}
		$role = $this->_checkRolesByUser('票务','业务',1);
		if(false !== $role){
			$is_jidiao = 1;
			$is_qiantai = 1;
		}
		$role = $this->_checkRolesByUser('地接','地接',1);
		if(false !== $role){
			$is_dijie = 1;
			$is_qiantai = 1;
		}
		$role = $this->_checkRolesByUser('财务','行政',1);
		if(false !== $role){
			$is_caiwu = 1;
			$is_qiantai = 1;
		}
		$role = $this->_checkRolesByUser('财务总监','行政',1);
		if(false !== $role){
			$is_caiwu = 1;
			$is_qiantai = 1;
		}
		$role = $this->_checkRolesByUser('总经理','行政',1);
		if(false !== $role){
			$is_caiwu = 1;
			$is_qiantai = 1;
		}
		$role = $this->_checkRolesByUser('网管','行政',1);
		if(false !== $role){
			$is_wangguan = 1;
			$is_qiantai = 1;
		}
		$role = $this->_checkRolesByUser('网店计调','组团',1);
		if(false !== $role){
			$is_webjidiao = 1;
			$is_qiantai = 1;
		}
		if($is_qiantai != 1){
			$role = $this->_checkRolesByUser('前台','销售（加盟）',1);
			if(false !== $role)
				$is_qiantai = 1;
			$role = $this->_checkRolesByUser('前台','销售（直营）',1);
			if(false !== $role)
				$is_qiantai = 1;
			$role = $this->_checkRolesByUser('前台','行政',1);
			if(false !== $role)
				$is_qiantai = 1;
			$role = $this->_checkRolesByUser('秘书','行政',1);
			if(false !== $role)
				$is_qiantai = 1;
		}
		$role = $this->_checkRolesByUser('业务','银行',1);
		if(false !== $role)
			$is_yinghang_yewu = 1;
		elseif($this->user['title'] == 'aaa'){
			$is_yinghang_yewu = 1;
		}
		
		if($this->user['title'] == '吴爽' || $this->user['title'] == 'aaa'){
			$is_vip = 1;
		}
		
		
		$this->assign("is_vip",$is_vip);
		$this->assign("is_yinghang_yewu",$is_yinghang_yewu);
		$this->assign("is_qiantai",$is_qiantai);
		$this->assign("is_webjidiao",$is_webjidiao);
		$this->assign("is_caiwu",$is_caiwu);
		$this->assign("is_dijie",$is_dijie);
		$this->assign("is_jidiao",$is_jidiao);
		$this->assign("is_wangguan",$is_wangguan);
		
	}
	
	
	
	public function _zituanlist($dotype) {
		if($_REQUEST['kind_copy'] == '近郊游')$this->assign("markpos",'近郊游');
		elseif($_REQUEST['kind_copy'] == '长线游')$this->assign("markpos",'长线游');
		elseif($_REQUEST['kind_copy'] == '韩国')$this->assign("markpos",'韩国');
		elseif($_REQUEST['kind_copy'] == '日本')$this->assign("markpos",'日本');
		elseif($_REQUEST['kind_copy'] == '台湾')$this->assign("markpos",'台湾');
		elseif($_REQUEST['kind_copy'] == '港澳')$this->assign("markpos",'港澳');
		elseif($_REQUEST['kind_copy'] == '东南亚')$this->assign("markpos",'东南亚');
		elseif($_REQUEST['kind_copy'] == '欧美岛')$this->assign("markpos",'欧美岛');
		elseif($_REQUEST['kind_copy'] == '自由人')$this->assign("markpos",'自由人');
		elseif($_REQUEST['kind_copy'] == '包团')$this->assign("markpos",'包团');
		else
		$this->assign("markpos",'全部');
		if($dotype == '团费确认'){
			$this->showDirectory("团费确认");
			$_REQUEST['status'] = array(array('eq','报名'),array('eq','截止'), 'or');
			$_REQUEST['status_baozhang'] = '未审核';
		}
		$datalist = $this->getDataOMlist('子团','zituan',$_REQUEST);
		$ViewDingdan = D("ViewDingdan");
		$ViewBaozhang = D("ViewBaozhang");
		$DataCD = D("DataCD");
		$i = 0;
		foreach($datalist['chanpin'] as $v){
			//搜索订单
			$dingdanall = $ViewDingdan->where("`parentID` = '$v[chanpinID]' AND `status` = '确认'")->findall();
			foreach($dingdanall as $vol){
				$customerall = $DataCD->where("`dingdanID` = '$vol[chanpinID]'")->findall();
				foreach($customerall as $c){
					if($c['ispay'] == '已付款'){
						$datalist['chanpin'][$i]['payed'] += $c['price'];
					}
					if($c['ispay'] == '未付款'){
						$datalist['chanpin'][$i]['unpay'] += $c['price'];
					}
					$datalist['chanpin'][$i]['tuanfei'] += $c['price'];
				}
			}
			$dingdanall = $ViewDingdan->where("`parentID` = '$v[chanpinID]' and `status_system` = 1")->findall();
			foreach($dingdanall as $vol){
				if($vol['status'] == '确认'){
					$datalist['chanpin'][$i]['queren_num'] += $vol['chengrenshu'] + $vol['ertongshu'];
					//团费确认
					$customerall = $DataCD->where("`dingdanID` = '$vol[chanpinID]'")->findall();
					foreach($customerall as $c){
						if($c['ispay'] == '已付款'){
							$datalist['chanpin'][$i]['payed'] += $c['price'];
						}
						if($c['ispay'] == '未付款'){
							$datalist['chanpin'][$i]['unpay'] += $c['price'];
						}
						$datalist['chanpin'][$i]['tuanfei'] += $c['price'];
					}
				}
				if($vol['status'] == '占位'){
					$datalist['chanpin'][$i]['zhanwei_num'] += $vol['chengrenshu'] + $vol['ertongshu'];
				}
			}
			$datalist['chanpin'][$i]['shengyu_num'] = $v['renshu'] - $datalist['chanpin'][$i]['queren_num'] - $datalist['chanpin'][$i]['zhanwei_num'];
			
			//报账单
			$bzd = $ViewBaozhang->where("`parentID` = '$v[chanpinID]'")->find();
			$datalist['chanpin'][$i]['baozhang'] = $bzd;
			//二次确认订单
			if($_REQUEST['second_confirm'] == 1){
				$WEBServiceOrder = D("WEBServiceOrder");
				$orderall = $WEBServiceOrder->where("`clientdataID` = '$v[chanpinID]'")->findall();
				$yudinglist = '';
				foreach($orderall as $ord){
					$yudinglist['renshu'] += $ord['chengrenshu']+$ord['ertongshu'];
					$yudinglist['chengrenshu'] += $ord['chengrenshu'];
					$yudinglist['ertongshu'] += $ord['ertongshu'];
				}
				$datalist['chanpin'][$i]['orderall'] = $orderall;
				$datalist['chanpin'][$i]['yudinglist'] = $yudinglist;
			}
			
			$i++;
		}
		if($dotype == '补订订单'){
			$datalist = $this->data_list_noOM('ViewZituan',$_REQUEST);
		}
		
		$this->assign("page",$datalist['page']);
		$this->assign("chanpin_list",$datalist['chanpin']);
		if($dotype == '产品搜索'){
			$this->showDirectory("子团产品");
			if($_REQUEST['webpage'] == 1){
				$this->display('B2CManage:kongguan');
			}
			else
				$this->display('Chanpin:kongguan');
		}
		if($dotype == '补订订单'){
			$this->showDirectory("补订订单");
			$this->display('zituanlist');
		}
		if($dotype == '团费确认'){
			$this->showDirectory("补订订单");
			$this->display('zituanlist');
		}
		return $datalist['chanpin'];
	}
	
	
	//添加订单
    public function _chanpinbaoming($roletype,$chanpintype = '线路') {
		$chanpinID = $_REQUEST['chanpinID'];
		$Chanpin = D("Chanpin");
		if($chanpintype == '线路'){
			if($roletype == '计调'){
				//检查dataOM
				$xiaoshou = $this->_checkDataOM($chanpinID,'子团','管理');
				if(false === $xiaoshou){
					$this->display('Index:error');
					exit;
				}
			}
			$ViewZituan = D("ViewZituan");
			$zituan = $ViewZituan->where("`chanpinID` = '$chanpinID'")->find();
			$this->assign("zituan",$zituan);
			if($roletype == '前台'){
				//报名截止
				if( (time()-strtotime(jisuanriqi($zituan['chutuanriqi'],$zituan['baomingjiezhi'],'减少')) <= 0)  || $zituan['status_baozhang'] == '批准'){
					justalert("错误！只有超过团期后并且没有报账的子团才能进行补订订单操作！！");
					echo "<script>window.close();</script>";
					exit;
				}
			}
		}
		if($chanpintype == '签证'){
			$ViewQianzheng = D("ViewQianzheng");
			$qianzheng = $ViewQianzheng->where("`chanpinID` = '$chanpinID'")->find();
			if($qianzheng['status_shenhe'] != '批准'){
				justalert("错误！签证未被通过审核！！");
				echo "<script>window.close();</script>";
				exit;
			}
			if($roletype == '计调'){
				$chanpinID = $_REQUEST['chanpinID'];
				//检查dataOM
				$xiaoshou = $this->_checkDataOM($chanpinID,'签证','管理');
				if(false === $xiaoshou){
					$this->display('Index:error');
					exit;
				}
			}
			if($roletype == '前台'){
			}
		}
		$DataCopy = D("DataCopy");
		if($chanpintype == '签证'){
			$chanpin = $DataCopy->where("`dataID` = '$chanpinID' and `datatype` = '$chanpintype'")->order("time desc")->find();
			$chanpin = simple_unserialize($chanpin['copy']);
		}
		if($chanpintype == '线路'){
			$chanpin = $DataCopy->where("`dataID` = '$zituan[parentID]' and `datatype` = '$chanpintype'")->order("time desc")->find();
			$chanpin = simple_unserialize($chanpin['copy']);
			$chanpin['xianlu_ext'] = simple_unserialize($chanpin['xianlu']['xianlu_ext']);
			$this->assign("xianlu",$chanpin);
			//计算子团人数
			$tuanrenshu = $this->_getzituandingdan($chanpinID);
			$baomingrenshu = $tuanrenshu['baomingrenshu'];
			$shengyurenshu = $zituan['renshu'] - $baomingrenshu;
			$this->assign("shengyurenshu",$shengyurenshu);
			//清空占位过期订单
			$this->_cleardingdan();
		}
		$this->assign("chanpin",$chanpin);
		//提成数据
		$ViewDataDictionary = D("ViewDataDictionary");
		$ticheng = $ViewDataDictionary->where("`type` = '提成' AND `status_system` = '1'")->findall();
		$this->assign("ticheng",$ticheng);
		//获得个人部门及分类列表
		$bumenfeilei = $this->_getbumenfenleilist();
		$this->assign("bumenfeilei",$bumenfeilei);
		$userlist = $this->_getCompanyUserList();
		$this->assign("userlist",$userlist);
		$this->display('baoming');
	}
	
	
	//自动申请
    public function _autoshenqing() {
		$process = $this->_getTaskDJC($_REQUEST['dataID'],$_REQUEST['datatype']);
		$step2 = $this->_checkShenhe($_REQUEST['datatype'],2);
		if(!$process && $step2)
		$this->_doshenhe();
	}
	
	
	
	//任务搜索字段填充信息
    public function _gettaskshenheinfo($dataID,$datatype,$data) {
		$ViewBaozhang = D("ViewBaozhang");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$ViewDingdan = D("ViewDingdan");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$ViewZituan = D("ViewZituan");
		$ViewDJtuan = D("ViewDJtuan");
		$ViewXianlu = D("ViewXianlu");
		$ViewQianzheng = D("ViewQianzheng");
		$System = D("System");
		$Chanpin = D("Chanpin");
		if($datatype == '报账项'){
			$cp = $ViewBaozhangitem->relation("baozhanglist")->where("`chanpinID` = '$dataID'")->find();
			$data['taskShenhe']['datatext_copy'] = serialize($cp);
			$data['taskShenhe']['baozhangtitle_copy'] = $cp['baozhanglist']['title'];
			$zituanID = $cp['baozhanglist']['parentID'];
			$data['taskShenhe']['datakind'] = $cp['baozhanglist']['type'];//报账项与报账单类型相同
		}
		if($datatype == '报账单'){
			$cp = $ViewBaozhang->where("`chanpinID` = '$dataID'")->find();
			$data['taskShenhe']['datatext_copy'] = serialize($cp);
			$zituanID = $cp['parentID'];
			$data['taskShenhe']['datakind'] = $cp['type'];
		}
		if($datatype == '订单'){
			$cp = $ViewDingdan->where("`chanpinID` = '$dataID'")->find();
			$data['taskShenhe']['datatext_copy'] = serialize($cp);
			$zituanID = $cp['parentID'];
			$data['taskShenhe']['datakind'] = $cp['type'];
		}
		if($datatype == '线路'){
			$cp = $ViewXianlu->where("`chanpinID` = '$dataID'")->find();
			$data['taskShenhe']['datakind'] = $cp['kind'];
		}
		if($datatype == '地接'){
			$cp = $ViewDJtuan->where("`chanpinID` = '$dataID'")->find();
			$data['taskShenhe']['datakind'] = $cp['kind'];
		}
		if($datatype == '签证'){
			$cp = $ViewQianzheng->where("`chanpinID` = '$dataID'")->find();
			$data['taskShenhe']['datakind'] = '签证';
		}
		$data['taskShenhe']['title_copy'] = $cp['title'];
		//获得团
		if($zituanID){
			$cp = $Chanpin->where("`chanpinID` = '$zituanID'")->find();
			if($cp['marktype'] == 'zituan'){
				$zituan = $ViewZituan->where("`chanpinID` = '$cp[chanpinID]'")->find();
				$data['taskShenhe']['tuantitle_copy'] = $zituan['title_copy'];
				$data['taskShenhe']['tuanqi_copy'] = $zituan['chutuanriqi'];
				$data['taskShenhe']['tuanhao_copy'] = $zituan['tuanhao'];
					
			}
			if($cp['marktype'] == 'DJtuan'){
				$djtuan = $ViewDJtuan->where("`chanpinID` = '$cp[chanpinID]'")->find();
				$data['taskShenhe']['tuantitle_copy'] = $djtuan['title'];
				$data['taskShenhe']['tuanqi_copy'] = $djtuan['jietuantime'];
				$data['taskShenhe']['tuanhao_copy'] = $djtuan['tuanhao'];
			}
		}
		return $data;
	}
	
	
	
	
	//获得用户信息
    public function _getuserinfo($username) {
		$ViewUser = D("ViewUser");
		$user = $ViewUser->where("`title` = '$username'")->find();
		return $user;
	}
	
	
	
	public function _deletechanpin($type) {
		C('TOKEN_ON',false);
		$itemlist = $_REQUEST['checkboxitem'];
		$itemlist = explode(',',$itemlist);
		if(count($itemlist) > 1)
			$this->ajaxReturn($_REQUEST,'错误！请选择唯一一个进行删除！！', 0);
		$Chanpin = D("Chanpin");
		$ViewDJtuan = D("ViewDJtuan");
		$ViewZituan = D("ViewZituan");
		$ViewBaozhang = D("ViewBaozhang");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$Chanpin->startTrans();
		foreach($itemlist as $v){
			//检查dataOM
			$xianlu = $this->_checkDataOM($v,$type);
			if(false === $xianlu){
				$mark = 1;
				continue;
			}
			if($type == '地接' || $type == '子团'){
				if($type == '地接')
					$chanp = $ViewDJtuan->where("`chanpinID` = '$v'")->find();
				if($type == '子团')
					$chanp = $ViewZituan->where("`chanpinID` = '$v'")->find();
				if($chanp['status_baozhang'] == '批准'){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'该团已经报账，不能删除！！！', 0);
				}
				else{
					$bzd = $ViewBaozhang->relation("baozhangitemlist")->where("`parentID` = '$v'")->find();
					foreach($bzd['baozhangitemlist'] as $vol){
						if($vol['status_shenhe'] == '批准'){
							$Chanpin->rollback();
							$this->ajaxReturn($_REQUEST,'该团已经开始报账，报账项目已审核，不能删除！！！', 0);
						}
					}
				}
				$data['chanpinID'] = $v;
				$data['status_system'] = -1;
				if(false === $Chanpin->save($data)){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'错误！！！', 0);
				}
			}
			
			if($type == '线路'){
				$ViewXianlu = D("ViewXianlu");
				$xianlu = $ViewXianlu->relation("zituanlist")->where("`chanpinID` = '$v'")->find();
				foreach($xianlu['zituanlist'] as $zituan){
					if($zituan['status_system'] == 1)
							$this->ajaxReturn($_REQUEST,'请先删除该线路内所有子团后继续！！！', 0);
				}
				$data['chanpinID'] = $v;
				$data['status_system'] = -1;
				if(false === $Chanpin->save($data)){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'错误！！！', 0);
				}
			}
			
			$Chanpin->commit();
			//删除OM
			$DataOM = D("DataOM");
			$where_om['dataID'] = $v;
			$where_om['datatype'] = $type;
			$where_om['status'] = array('neq','指定');
			$DataOM->where($where_om)->delete();
			//相应审核任务
			A("Method")->_taskshenhe_delete($data['chanpinID'],$type);
		}
		$this->ajaxReturn($_REQUEST,'操作成功！', 1);
	
	}

	
	
	
	
	function _checkshenhe_admin($dataID,$datatype){
		//检查OM
		$tempom = $this->_checkDataOM($dataID,$datatype,'管理');
		if(false === $tempom){
			//$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
			cookie('errormessage','错误，无管理权限！',30);
			return false;
		}
		$Chanpin = D("Chanpin");
		$cpin = $Chanpin->where("`chanpinID` = '$dataID' AND (`status_system` = '1')")->find();
		if(!$cpin){
			//$this->ajaxReturn('', '错误！', 0);
			cookie('errormessage','错误！',30);
			return false;
		}
		if($datatype == '报账项'){//检查父状态
			$p_cpin = $Chanpin->where("`chanpinID` = '$cpin[parentID]' AND (`status_system` = '1')")->find();
			if($p_cpin['status_shenhe'] == '批准'){
				//$this->ajaxReturn($_REQUEST,'错误，该报账项的报账单已被审核通过，无法审核回退！', 0);
				cookie('errormessage','错误，该报账项的报账单已被审核通过,无法审核回退！',30);
				return false;
			}
		}
		if($datatype == '地接'){//检查报账单状态
			$p_cpin = $Chanpin->where("`parentID` = '$cpin[chanpinID]' AND (`status_system` = '1') AND `marktype` = 'baozhang'")->find();
			if($p_cpin['status_shenhe'] == '批准' || $p_cpin['islock'] == '已锁定'){
				//$this->ajaxReturn($_REQUEST,'错误，该地接产品的报账单已被审核通过，无法审核回退！', 0);
				cookie('errormessage','错误，该地接产品的报账单已被审核通过,无法审核回退！',30);
				return false;
			}
		}
		
		if($cpin['status_shenhe'] == '批准'){
			$ViewShenhe = D("ViewShenhe");
			$djc = $this->_getTaskDJC($dataID,$datatype);
			if($djc)
				$piz['processID'] = $djc['processID']-1;
			else
				$piz = $this->_getTaskPZ($dataID,$datatype);
			$checkds = $this->_checkShenhe($datatype,$piz['processID'],$this->user['systemID'],$dataID);//检查流程的申请权限！检查某人是否有审核权限！（某人的审核权限建立在产品权限之上）
			if(false === $checkds){
				//$this->ajaxReturn('', '错误！您没有操作权限！', 0);
				cookie('errormessage','错误，您没有操作权限！',30);
				return false;
			}
		}
		return true;
		
	}
	
	
	
	
	function _jiezhiorbaoming($type){
		C('TOKEN_ON',false);
		$itemlist = $_REQUEST['checkboxitem'];
		$itemlist = explode(',',$itemlist);
		if(count($itemlist) > 1)
			$this->ajaxReturn($_REQUEST,'错误！请选择唯一一个进行截止或报名！！', 0);
		$Chanpin = D("Chanpin");
		$ViewShoujia = D("ViewShoujia");
		$Chanpin->startTrans();
		foreach($itemlist as $v){
			$chanp = $Chanpin->where("`chanpinID` = '$v'")->find();
			
			//检查dataOM
			$xianlu = $this->_checkDataOM($v,$type);
			if(false === $xianlu){
				$mark = 1;
				continue;
			}
			if($type == '线路'){
				$data['chanpinID'] = $v;
				if($chanp['status'] == '报名')
					$data['status'] = '截止';
				if($chanp['status'] == '截止'){
					$xianlu = $Chanpin->relation("zituanlist")->where("`chanpinID` = '$v'")->find();
					$mark = 0;
					foreach($xianlu['zituanlist'] as $v){
						if($v['status'] != '截止'){
							$mark = 1;
						}
					}
					if($mark == 1)
						$data['status'] = '报名';
					else
						$this->ajaxReturn($_REQUEST,'线路所有子团截止，无法再报名！', 0);
				}
				if(false === $Chanpin->mycreate($data)){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'错误！', 0);
				}
				else{//同步更新售价
					$shoujialist = $Chanpin->relationGet("shoujialist");
					foreach($shoujialist as $s){
						$shoujia_data['chanpinID'] = $s['chanpinID'];
						$shoujia_data['shoujia']['xianlu_status'] = $data['status'];
						$Chanpin->relation("shoujia")->myRcreate($shoujia_data);
					}
					//处理销售OM
					if($chanp['status'] == '报名'){
						$this->_updatexianlu_status($xianluID);
					}
					if($chanp['status'] == '截止'){
						//清除销售OM
						$this->_clean_shoujia_om($xianluID);
					}
				}
			}
			if($type == '地接'){
				$data['chanpinID'] = $v;
				if($chanp['status'] == '在线')
					$data['status'] = '截止';
				if($chanp['status'] == '截止')
					$data['status'] = '在线';
				if(false === $Chanpin->mycreate($data)){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'错误！！！??', 0);
				}
			}
			if($type == '子团'){
				$data['chanpinID'] = $v;
				if($chanp['status'] == '报名')
					$data['status'] = '截止';
				if($chanp['status'] == '截止')
					$data['status'] = '报名';
				if(false === $Chanpin->mycreate($data)){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'错误！！！??', 0);
				}
				else{
					$this->_updatexianlu_status('',$chanp['chanpinID']);
				}
			}
			
		}
		$Chanpin->commit();
		//开放
		if($mark == 1)
			$this->ajaxReturn($_REQUEST,'完成！,一部分线路您没有操作权限！无法进行修改！！', 1);
		$this->ajaxReturn($_REQUEST,'完成！', 1);
	
	
	}
	
	
	
	function check_baozhangitemstatus($chanpinID){
		$ViewBaozhang = D("ViewBaozhang");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$itemall = $ViewBaozhangitem->where("`parentID` = '$chanpinID' and `type` != '利润' and `status_system` = '1'")->findall();
		foreach($itemall as $v){
			if($v['status_shenhe'] != '批准'){
				return true;
			}
		}
		return false;
	}
	
	
	
	
	//生成待检出
	function _djcCreate($data,$process){//任务数据,下一流程
		C('TOKEN_ON',false);
		$System = D("System");
		if(false === $System->relation("taskShenhe")->myRcreate($data)){
			cookie('errormessage','生成待审核失败！',30);
			return false;
		}
		//生成待检出OM
		$data['systemID'] = $System->getRelationID();
		$data['dataID'] = $data['taskShenhe']['dataID'];
		$data['datatype'] = $data['taskShenhe']['datatype'];
		return $this->_djcOMCreate($data,$process);
	}
	
	
	
	
	//生成待检出om
	function _djcOMCreate($data,$process){
		C('TOKEN_ON',false);
		//生成待检出OM
		$DataOM = D("DataOM");
		$to_dataomlist = $this->_getDataOM($data['dataID'],$data['datatype'],'管理');
		//联合体产品处理，根据申请者部门生成审核OM
		if($this->_checkLHT_OM($data['dataID'],$data['datatype'])){
			$i = 0;
			foreach($to_dataomlist as $tod){
				$i++;
			}
			$durlist = A("Method")->_checkRolesByUser('计调','组团',1);
			foreach($durlist as $vdul){
				$to_dataomlist[$i]['DUR'] = $vdul['bumenID'].','.$vdul['roleID'].',';
				$i++;
			}
		}
		foreach($to_dataomlist as $vo){
			list($om_bumen,$om_roles,$om_user) = split(',',$vo['DUR']);
			$to_dataom['type'] = '管理';
			$to_dataom['dataID'] = $data['systemID'];
			$to_dataom['datatype'] = '审核任务';
			foreach($process as $p){
				list($pro_roles,$pro_user) = split(',',$p['UR']);
				//角色存在，部门必须存在
				if(!$om_bumen && $pro_roles)
				continue;
				//开关过滤
				$to_dataom['is_notice'] = $p['is_notice'];
				$to_dataom['DUR'] = $om_bumen.','.$p['UR'];
				//过滤统一部门DUR
				$tmp_d = $DataOM->where("`DUR`= '$to_dataom[DUR]' and `dataID` = '$to_dataom[dataID]' and `datatype` = '$to_dataom[datatype]'")->find();
				if(!$tmp_d){
					if(false === $DataOM->mycreate($to_dataom))
						return false;
					//返回需要提示的用户
					$userIDlist_temp = $this->_getuserlistByDUR($to_dataom['DUR']);	
					$userIDlist = NF_combin_unique($userIDlist,$userIDlist_temp);
				}
			}
		}
		
		
		return $userIDlist;
	}
	
	
	//修复开放om(修复某类型所有)
	function _djcOMCreateRepair($datatype,$processID){
		C('TOKEN_ON',false);
		//修复开放om
		$DataOM = D("DataOM");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$tsall = $ViewTaskShenhe->where("`datatype` = '$datatype' AND `processID` = '$processID' AND `status` = '待检出' AND `status_system` = 1")->findall();
		foreach($tsall as $v){
			$where_om['dataID'] = $v['systemID'];
			$where_om['datatype'] = $v['datatype'];
			$where_om['status'] = array('neq','指定');
			$DataOM->where($where_om)->delete();
			$process = $this->_checkShenhe($datatype,$processID);
			$this->_djcOMCreate($v,$process);
		}
	}
	
	
	//删除OM并重新生成
	function _OMRcreate($dataID,$datatype,$user_name,$dataOMlist,$departmentID){
		C('TOKEN_ON',false);
		//修复开放om
		if($datatype == '消息'){
				$DataOMMessage = D("DataOMMessage");
				$DataOMMessage->where("`dataID` = '$dataID' and `datatype` = '$datatype'")->delete();
				if(!$dataOMlist){
					$Message = D("Message");
					$msg = $Message->where("`messageID` = '$dataID'")->find();
					$dataOMlist = $this->_getDataOM($msg['parentID'],'','管理');
				}
				$this->_createDataOM($dataID,$datatype,'管理',$dataOMlist,'DataOMMessage');
		}
		else{
				$DataOM = D("DataOM");
				$Chanpin = D("Chanpin");
				$where_om['dataID'] = $dataID;
				$where_om['datatype'] = $datatype;
				$where_om['status'] = array('neq','指定');
				$DataOM->where($where_om)->delete();
				//获得产品
				$d_cp = $Chanpin->where("`chanpinID` = '$dataID'")->find();
				if(!$departmentID){
					$departmentID = $d_cp['departmentID'];//默认部门
				}
				if(!$user_name){
					$user_name = $d_cp['user_name'];//产品拥有者
				}
				if($datatype == '线路'){
					//修复产品部门
					if($d_cp['bumen_copy'] == '总经理' || $d_cp['bumen_copy'] == '大连古莲国际旅行社'){
						$d_list = $this->_getDURlist_name($user_name,'','组团');	
						//随即第一个
						$d_cp['departmentID'] = $d_list[0]['bumenID'];	
						if(false !== $Chanpin->mycreate($d_cp))
							$departmentID = $d_cp['departmentID'];
					}
					if(!$dataOMlist){
						$dataOMlist = $this->_setDataOMlist('计调','组团',$user_name,$departmentID);
					}
					$this->_createDataOM($dataID,$datatype,'管理',$dataOMlist);
					//子团重置
					$zituanall = $Chanpin->where("`parentID` = '$dataID' and `marktype` = 'zituan'")->findall();
					foreach($zituanall as $v){
						$this->_OMRcreate($v['chanpinID'],'子团',$user_name,$dataOMlist);
					}
				}
				if($datatype == '地接' || $datatype == '子团' || $datatype == '签证'){
					if(!$dataOMlist){
						if($datatype == '地接'){
							$role = '地接';
							$bumentype = '地接';
						}
						if($datatype == '子团' || $datatype == '签证'){
							$role = '计调';
							$bumentype = '组团';
						}
						$dataOMlist = $this->_setDataOMlist($role,$bumentype,$user_name,$departmentID);
					}
					$this->_createDataOM($dataID,$datatype,'管理',$dataOMlist);
					//报账单重置
					$bzdall = $Chanpin->where("`parentID` = '$dataID' and `marktype` = 'baozhang'")->findall();
					foreach($bzdall as $vol){
						$this->_OMRcreate($vol['chanpinID'],'报账单',$user_name,$dataOMlist);
					}
					//重置订单
					if($datatype == '子团' || $datatype == '签证'){
						$dingdanall = $Chanpin->where("`parentID` = '$dataID' and `marktype` = 'dingdan'")->findall();
						foreach($dingdanall as $vd){
							$this->_OMRcreate($vd['chanpinID'],'订单',$user_name,$dataOMlist);
						}
					}
				}
				if($datatype == '订单'){
					if(!$dataOMlist){
						$cp = $Chanpin->where("`chanpinID` = '$d_cp[parentID]'")->find();
						$dataOMlist = $this->_setDataOMlist('计调','组团',$user_name,$cp['departmentID']);//user_name需要指定，必须为团拥有者
					}
					//处理订单//订单比较特殊
					$i=0;
					foreach($dataOMlist as $vd){
						$i++;
					}
					$dataOMlist[$i]['DUR'] = $departmentID.',,';//开放至部门
					$this->_createDataOM($dataID,$datatype,'管理',$dataOMlist);
				}
				if($datatype == '报账单'){
					if(!$dataOMlist){
						$cp = $Chanpin->where("`chanpinID` = '$d_cp[parentID]'")->find();
						if($cp){
							if($cp['marktype'] == 'zituan'){
								$role = '计调';
								$bumentype = '组团';
							}
							if($cp['marktype'] == 'DJtuan'){
								$role = '地接';
								$bumentype = '地接';
							}
							$dataOMlist = $this->_setDataOMlist($role,$bumentype,$user_name,$departmentID);
						}
						else{
							$dataOMlist = $this->_setDataOMlist('计调','组团',$user_name,$departmentID);
							if(!$dataOMlist)				
								$dataOMlist = $this->_setDataOMlist('地接','地接',$user_name,$departmentID);
						}
					}
					$this->_createDataOM($dataID,$datatype,'管理',$dataOMlist);
					//报账项重置
					$bzditemall = $Chanpin->where("`parentID` = '$dataID' and `marktype` = 'baozhangitem'")->findall();
					foreach($bzditemall as $volitem){
						$this->_OMRcreate($volitem['chanpinID'],'报账项',$user_name,$dataOMlist);
					}
				}
				if($datatype == '报账项'){
					if(!$dataOMlist){
						$cp_bzd = $Chanpin->where("`chanpinID` = '$d_cp[parentID]'")->find();//获得报账单
						$dataOMlist = $this->_getDataOM($d_cp['parentID'],'报账单','管理');
					}
					$this->_createDataOM($dataID,$datatype,'管理',$dataOMlist);
				}
				
				//清除无用OM
				$process = $this->_get_chanpin_taskshenhe($dataID,$datatype);//获得产品审核状态
				$need = $this->_getTaskDJC($dataID,$datatype);//检查待审核任务存在
				if($process['status'] == '批准' && $need == false){
					$ViewTaskShenhe = D("ViewTaskShenhe");
					$taskall = $ViewTaskShenhe->where("`dataID` = '$dataID' AND `datatype` = '$datatype'")->findall();
					$DataOM = D("DataOM");
					foreach($taskall as $v){
						$DataOM->where("`dataID` = '$v[systemID]' AND `datatype` = '审核任务'")->delete();	
					}
				}
		}
		
		return $dataOMlist;
	}
	
	
	
	
	//获得部门用户列表
     public function _getBumenUserlist($bumenID,$bumentitle='') {
		$ViewDepartment = D("ViewDepartment");
		$ViewSystemDUR = D("ViewSystemDUR");
		$ViewUser = D("ViewUser");
		if($bumenID)
		$all = $ViewSystemDUR->where("`bumenID` = '$bumenID'")->findall();
		if($bumentitle){
			//公司范围控制
			$username = $this->user['title'];
			$ComID = $this->_getComIDbyUser($username);
			$d = $ViewDepartment->where("`title` = '$bumentitle' AND `parentID` = '$ComID'")->find();
			$all = $ViewSystemDUR->where("`bumenID` = '$d[systemID]'")->findall();
		}
		$i = 0;
		foreach($all as $v){
			$userIDlist[$i] = $v['userID'];
			$i++;
		}
		$userIDlist = array_unique($userIDlist);
		$i = 0;
		foreach($userIDlist as $v){
			$user = $ViewUser->where("`systemID` = '$v'")->find();
			$userlist[$i] = $user;
			$i++;
		}
		if($userlist)
		return $userlist;
		else
		return false;
	 }

	
	//报账单同步报账项费用
     public function _updatebaozhangdata($baozhangID,$itemID='') {
		  $Chanpin = D("Chanpin");
		  $ViewBaozhangitem = D("ViewBaozhangitem");
		  if($baozhangID){
			  $editdat['chanpinID'] = $baozhangID;
			  $baozhangitemlist = $ViewBaozhangitem->where("`parentID` = '$baozhangID' and `status_system` = 1 and `status_shenhe` = '批准'")->findall();
		  }
		  if($itemID){
			  $item = $ViewBaozhangitem->where("`chanpinID` = '$itemID' and `status_system` = 1 and `status_shenhe` = '批准'")->find();
			  $editdat['chanpinID'] = $item['parentID'];
			  $baozhangitemlist = $ViewBaozhangitem->where("`parentID` = '$item[parentID]' and `status_system` = 1 and `status_shenhe` = '批准'")->findall();
		  }
		  foreach($baozhangitemlist as $va){
			  if($va['type'] == '结算项目')
				  $jisuan +=$va['value'];
			  if($va['type'] == '支出项目')
				  $zhichu +=$va['value'];
		  }
		  $editdat['chanpinID'] = $baozhangID;
		  $editdat['baozhang']['yingshou_copy'] = $jisuan;
		  $editdat['baozhang']['yingfu_copy'] = $zhichu;
		  $Chanpin->relation("baozhang")->myRcreate($editdat);
	 }
	
	
	
	//重置产品OM
     public function _resetOM($chanpinID='') {
		$Chanpin = D("Chanpin");
		C('TOKEN_ON',false);
		if($chanpinID)
			$_REQUEST['chanpinID'] = $chanpinID;
		if($_REQUEST['chanpinID']){
			$cp = $Chanpin->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
			if($cp){
				if($cp['marktype'] == 'xianlu')
					$omtype = '线路';
				if($cp['marktype'] == 'zituan')
					$omtype = '子团';
				if($cp['marktype'] == 'qianzheng')
					$omtype = '签证';
				if($cp['marktype'] == 'DJtuan')
					$omtype = '地接';
				if($cp['marktype'] == 'baozhang')
					$omtype = '报账单';
				if($cp['marktype'] == 'baozhangitem')
					$omtype = '报账项';
				$this->_OMRcreate($_REQUEST['chanpinID'],$omtype,$cp['user_name']);
			}
			else
				return false;
		}
		else{
			$itemlist = $_REQUEST['checkboxitem'];
			$itemlist = explode(',',$itemlist);
//			if(count($itemlist) > 1)
//				$this->ajaxReturn($_REQUEST,'错误！请选择唯一一个进行操作！！', 0);
			foreach($itemlist as $v){
				$cp = $Chanpin->where("`chanpinID` = '$v'")->find();
				if($cp)
				$this->_OMRcreate($v,'线路',$cp['user_name']);
			}
		}
		return true;
		
	 }
	 
	 
	//重置待审核OM
     public function _resetOMTask($chanpinID='') {
		$Chanpin = D("Chanpin");
		C('TOKEN_ON',false);
		if($chanpinID)
			$_REQUEST['chanpinID'] = $chanpinID;
		//分类
		$cp = $Chanpin->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		if($cp['marktype'] == 'zituan' || $cp['marktype'] == 'DJtuan'){
			$baozhangall = $Chanpin->where("`chanpinID` = '$cp[parentID]' AND `marktype` = 'baozhang'")->findall();
			dump($baozhangall);
			foreach($baozhangall as $v){
				$this->_resetOMTask($v['chanpinID']);
				$baozhangitemall = $Chanpin->where("`chanpinID` = '$v[parentID]'")->findall();
				foreach($baozhangitemall as $vol){
			dump($baozhangitemall);
					$this->_resetOMTask($vol['chanpinID']);
				}
			}
			return true;
		}
		$DataOM = D("DataOM");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$where['status'] = '待检出';
		$where['dataID'] = $_REQUEST['chanpinID'];
		$task = $ViewTaskShenhe->where($where)->find();
		$process = $this->_checkShenhe($task['datatype'],$task['processID']);
		$this->_djcOMCreate($task,$process);
		return true;
	 }
	 
	
	
	
	//侧导航部门提取
	public function _nav_leftdatas() {
		$ViewDepartment = D("ViewDepartment");
		$ComID = $this->_getComIDbyUser();
		$bumenlist = $ViewDepartment->where("`parentID` = '$ComID' AND `type` like '%联合体%'")->findall();
		$this->assign("bumenlist",$bumenlist);
		$zutuanlist = $ViewDepartment->where("`parentID` = '$ComID' AND `type` like '%组团%' AND `type` not like '%联合体%' AND `type` not like '%办事处%'")->findall();
		$this->assign("zutuanlist",$zutuanlist);
		$dijielist = $ViewDepartment->where("`parentID` = '$ComID' AND `type` like '%地接%'")->findall();
		$this->assign("dijielist",$dijielist);
	}
	
	
	
	
	//订单存储流程
	public function _dingdansave_process($data,$username) {
		$Chanpin = D("Chanpin");
		$Chanpin->startTrans();
		if (false !== $Chanpin->relation("dingdan")->myRcreate($data)){
			$chanpinID = $Chanpin->getRelationID();
			$data['chanpinID'] = $chanpinID;
			//生成OM
			$this->_OMRcreate($chanpinID,'订单');
			if($data['type'] != '签证')
				$data['type'] = '子团';
			//生成团员
			if($data['type'] == '子团'){
				if($this->createCustomer_new($data,$chanpinID)){
					//更新信息
					if($data['type'] == '子团'){
						$zituan = $Chanpin->relation("xianlulist")->where("`chanpinID` = '$data[parentID]'")->find();
						if($zituan['xianlulist']['serverdataID']){
							$getres = FileGetContents(SERVER_INDEX."Server/updatechanpin/chanpinID/".$zituan['parentID']);
							if($getres['error']){
								$Chanpin->rollback();
								return false;
							}
						}
					}
					$Chanpin->commit();
				}
				else{
					$Chanpin->rollback();
					return false;
				}
			}
			if($data['user_mame'] == '电商' || $data['dingdan']['owner'] == '电商'){
				//生成提醒消息
				$message = '《'.$data['dingdan']['lianxiren'].'》'.'预订了：'.'『'.$data['dingdan']['title'].'』 。';
				$url = SITE_INDEX.'Xiaoshou/dingdanxinxi/chanpinID/'.$chanpinID;
				$data['username'] = $username;
				$this->_setMessageHistory($chanpinID,'订单',$message,$url,'','',$data);
			}
			return $data;
		}
		else{
			return false;
		}
	}
	
	
	
	//查询
	public function _NH_zhifuchaxun($orderNo='',$orderID='') {
		$record = FileGetContents_b(WEB_INDEX."NHOrder/_interface_query_order/orderNo/".$orderNo."/orderID/".$orderID);
		return $record;
	}
	
	
	
	
	//统计
	public function _tongji($chanpintype) {
		if($chanpintype == '子团'){
			$ModelName = 'ViewZituan';
			$where['status_baozhang'] = '批准';
			$baozhang_type = '团队报账单';
		}
		if($chanpintype == '签证'){
			$ModelName = 'ViewQianzheng';
			$baozhang_type = '签证';
		}
		$this->showDirectory("统计");
		//搜索
		if($_REQUEST['listtype'] == '员工'){
			$where['user_name'] = array('like','%'.$_REQUEST['title'].'%');
		}
		else{
//			$where['title'] = array('like','%'.$_REQUEST['title'].'%');
			$bumen_where['title'] = array('like','%'.$_REQUEST['title'].'%');
		}
		$where['status_system'] = 1;
		
		if($_REQUEST['start_time'] && $_REQUEST['end_time']){
			if($chanpintype == '子团')
				$where['chutuanriqi'] = array('between',$_REQUEST['start_time'].','.$_REQUEST['end_time']);
			if($chanpintype == '签证')
				$baozhang_where['shenhe_time'] = array('between',strtotime($_REQUEST['start_time']).','.strtotime($_REQUEST['end_time']));	
		}
		else{
			$month = NF_getmonth();
			$fm_forward_month = $month['forward'];
			if($chanpintype == '子团')
				$where['chutuanriqi'] = array('between',$fm_forward_month.'-01'.','.date("Y-m").'-01');	
			if($chanpintype == '签证')
				$baozhang_where['shenhe_time'] = array('between',$fm_forward_month.'-01'.','.date("Y-m").'-01');	
			$_REQUEST['start_time'] = $fm_forward_month.'-01';
			$_REQUEST['end_time'] = date("Y-m").'-01';
			$this->assign("start_time",$fm_forward_month.'-01');
			$this->assign("end_time",date("Y-m").'-01');
		}
		
		if($_REQUEST['departmentID'])
			$where['departmentID'] = $_REQUEST["departmentID"];
		$ViewDataDictionary = D("ViewDataDictionary");
		//获得用户权限，部门列表
		$ViewDepartment = D("ViewDepartment");
		$role = $this->_checkRolesByUser('网管,总经理,出纳,会计,财务,财务总监','行政');
		$ComID = $this->_getComIDbyUser();
		if($role){
			$bumen_where['parentID'] = $ComID;
			$bumen_where['type'] = array('like','%组团%');
			$unitdata = $ViewDepartment->where($bumen_where)->findall();
		}
		else{
			$role = $this->_checkRolesByUser('经理','组团');
			if(!$role){
				$this->assign("message",'您的访问受限！！');
				$this->display('Index:error');
				exit;
			}
			$i = 0;
			foreach($role as $v){
				$bumen_where['parentID'] = $v['bumenID'];
				$unitdata[$i] = $ViewDepartment->where($bumen_where)->find();
				$i++;
			}
			$unitdata = about_unique($unitdata);
		}
		//部门列表
		if($_REQUEST["departmentID"]){
			foreach($unitdata as $b){
				if($b['systemID'] == $_REQUEST["departmentID"]){
					$newdata[0] = $b;
					break;
				}
			}
			$unitdata = $newdata;
		}
		
		//end
		//总体统计。
		$ViewZituan = D($ModelName);
		$ViewDingdan = D("ViewDingdan");
		$ViewBaozhang = D("ViewBaozhang");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$i = 0;
		foreach($unitdata as $v){
			$where['departmentID'] = $v['systemID'];
			$tuanall = $ViewZituan->where($where)->findall();
			foreach($tuanall as $vol){
				$zituanall[$i] = $vol;
				$i++;
			}
		}
		$i = 0;
		foreach($zituanall as $v){
			$tongji['tuanshu'] += 1;
			$tongji['jihua_renshu'] += $v['renshu'];
			$queren_renshu = 0;
			$zhanwei_renshu = 0;
			$houbu_renshu = 0;
			$dingdan_renshu = 0;
			$yingfu = 0;
			$yingshou = 0;
			//订单人数
			$dingdanall = $ViewDingdan->where("`parentID` = '$v[chanpinID]' and `status_system` = 1")->findall();
			foreach($dingdanall as $vol){
				if($vol['status'] == '确认'){
					$tongji['queren_renshu'] += $vol['chengrenshu'] + $vol['ertongshu'];
					$queren_renshu += $vol['chengrenshu'] + $vol['ertongshu'];
				}
				if($vol['status'] == '占位'){
					$tongji['zhanwei_renshu'] += $vol['chengrenshu'] + $vol['ertongshu'];
					$zhanwei_renshu += $vol['chengrenshu'] + $vol['ertongshu'];
				}
				if($vol['status'] == '候补'){
					$tongji['houbu_renshu'] += $vol['chengrenshu'] + $vol['ertongshu'];
					$houbu_renshu += $vol['chengrenshu'] + $vol['ertongshu'];
				}
				$tongji['dingdan_renshu'] += $vol['chengrenshu'] + $vol['ertongshu'];
				$dingdan_renshu += $vol['chengrenshu'] + $vol['ertongshu'];
			}
			//报账单
			$baozhang_where['parentID'] = $v['chanpinID'];
			$baozhangall = $ViewBaozhang->where($baozhang_where)->findall();
			foreach($baozhangall as $vol){
				if($vol['type'] == $baozhang_type){
				  $tongji['baozhang_renshu'] += $vol['renshu'];
				  $baozhang_renshu = $vol['renshu'];
				}
				$itemall = $ViewBaozhangitem->where("`parentID` = '$vol[chanpinID]' and `status_system` = 1")->findall();
				foreach($itemall as $w){
					if($w['type'] == '支出项目'){
						$tongji['yingfu'] += $w['value'];
						$yingfu += $w['value'];
					}
					if($w['type'] == '结算项目'){
						$tongji['yingshou'] += $w['value'];
						$yingshou += $w['value'];
					}
				}
			}
			$zituanall[$i]['queren_renshu'] = $queren_renshu;
			$zituanall[$i]['zhanwei_renshu'] = $zhanwei_renshu;
			$zituanall[$i]['houbu_renshu'] = $houbu_renshu;
			$zituanall[$i]['dingdan_renshu'] = $dingdan_renshu;
			$zituanall[$i]['baozhang_renshu'] = $baozhang_renshu;
			$zituanall[$i]['yingshou'] = $yingshou;
			$zituanall[$i]['yingfu'] = $yingfu;
			$i++;
		}
		$this->assign("tongji",$tongji);
		//分类处理
		//人员统计
		if($_REQUEST['listtype'] == '员工'){
			$this->assign("markpos",$_REQUEST['listtype']);
			//用户列表
			$ViewUser = D("ViewUser");
			$i = 0;
			foreach($unitdata as $v){
				$listarray = $this->_getBumenUserlist($v['systemID']);
				foreach($listarray as $lol){
					$userlist[$i] = $lol;
					$i++;
				}
			}
			$unitdata = about_unique($userlist);
			$unitdata = array_values($unitdata);
			//搜索用户
			if($_REQUEST['title']){
				foreach($unitdata as $tt){
					if($tt['user_name'] == $_REQUEST['title']){
						$unitdata_tem[0] = $tt;
						break;
					}
				}
				$unitdata = $unitdata_tem;
			}
		}
		
		//end人员统计
		$i = 0;
		foreach($unitdata as $v){
			if($_REQUEST['listtype'] == '员工'){
				$right = $v['title'];
			}
			else{
				$right = $v['systemID'];
			}
			$m = 0;
			foreach($zituanall as $vol){
				if($_REQUEST['listtype'] == '员工'){
					$left = $vol['user_name'];
				}
				else{
					$left = $vol['departmentID'];
				}
				if($left == $right){
					$unitdata[$i]['zituan'][$m] = $vol;
					$unitdata[$i]['jihua_renshu'] += (int)$vol['renshu'];
					$unitdata[$i]['queren_renshu'] += (int)$vol['queren_renshu'];
					$unitdata[$i]['zhanwei_renshu'] += (int)$vol['zhanwei_renshu'];
					$unitdata[$i]['houbu_renshu'] += (int)$vol['houbu_renshu'];
					$unitdata[$i]['dingdan_renshu'] += (int)$vol['dingdan_renshu'];
					$unitdata[$i]['baozhang_renshu'] += (int)$vol['baozhang_renshu'];
					$unitdata[$i]['yingshou'] += (int)$vol['yingshou'];
					$unitdata[$i]['yingfu'] += (int)$vol['yingfu'];
					$m++;
				}
			}
			if($_REQUEST['returntype'] == 'ajax')
				$data = $unitdata[$i]['zituan'];
			$i++;
		}
		$this->assign("unitdata",$unitdata);
		//打印
		if($_REQUEST['doprint'] == 1){
			$this->display('print_yingshou');
			return ;	
		}
		if($_REQUEST['export'] == 1){
			//导出Word
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . $_REQUEST['start_time'].'至'.$_REQUEST['end_time'] . "绩效统计.doc");
			header("Pragma:no-cache");        
			header("Expires:0"); 
			$this->display('print_yingshou');
			return ;	
		}
		
		//返回	
		if($_REQUEST['returntype'] == 'ajax'){
			if($chanpintype == '子团'){
				$str = '
					<table cellpadding="0" cellspacing="0" width="100%" class="list view">
						<tr height="20">
						  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 标题 </div></th>'.$tabtile.'
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 团号 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 出团日期  </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 操作人 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 计划人数 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单人数/确认/占位/候补 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 报账情况 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 报账人数 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 计划应收 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 计划应付 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 盈亏 </div></th>
						</tr>
				';
				$i = 0;
				foreach($data as $v){$i++;
					$str .= '
					<tr class="evenListRowS1">
					  <td>'.$i.'</td>
					  <td><a target="_blank" href="'.SITE_INDEX.'Chanpin/zituanxinxi/chanpinID/'.$v['chanpinID'].'">'.$v['title_copy'].'</a></td>'.$tabvalue.'
					  <td>'.$v['tuanhao'].'</td>
					  <td>'.$v['chutuanriqi'].'</td>
					  <td>'.$v['user_name'].'</td>
					  <td>'.$v['renshu'].'</td>
					  <td>'.$v['dingdan_renshu'].'/'.$v['queren_renshu'].'/'.$v['zhanwei_renshu'].'/'.$v['houbu_renshu'].'</td>
					  <td>'.$v['baozhang_remark'].'</td>
					  <td>'.$v['baozhang_renshu'].'</td>
					  <td>'.number_format($v['yingshou']).'</td>
					  <td>'.number_format($v['yingfu']).'</td>
					  <td>'.number_format($v['yingshou']-$v['yingfu']).'</td>
					</tr>
					';
				}
			}
				
			if($chanpintype == '签证'){
				$str = '
					<table cellpadding="0" cellspacing="0" width="100%" class="list view">
						<tr height="20">
						  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 标题 </div></th>'.$tabtile.'
						  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 操作人 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单人数/确认/占位/候补 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 报账人数 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 计划应收 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 计划应付 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 盈亏 </div></th>
						</tr>
				';
				$i = 0;
				foreach($data as $v){$i++;
					$str .= '
					<tr class="evenListRowS1">
					  <td>'.$i.'</td>
					  <td><a target="_blank" href="'.SITE_INDEX.'Qianzheng/fabu/chanpinID/'.$v['chanpinID'].'">'.$v['title'].'</a></td>'.$tabvalue.'
					  <td>'.$v['user_name'].'</td>
					  <td>'.$v['dingdan_renshu'].'/'.$v['queren_renshu'].'/'.$v['zhanwei_renshu'].'/'.$v['houbu_renshu'].'</td>
					  <td>'.$v['baozhang_renshu'].'</td>
					  <td>'.number_format($v['yingshou']).'</td>
					  <td>'.number_format($v['yingfu']).'</td>
					  <td>'.number_format($v['yingshou']-$v['yingfu']).'</td>
					</tr>
					';
				}
			}
				
				
				$str .= '
					<tr class="evenListRowS1">
					  <td align="right" colspan="3">
					  '.$page.'
					  </td>
					</tr>
					</table>
				';
				$this->ajaxReturn($str, '', 1);
		}
		else{
			if($chanpintype == '子团')
				$this->display('Chanpin:tongji');
			if($chanpintype == '签证')
				$this->display('Qianzheng:tongji');
		}
	}
	
	
	
	//新增分类，指定销售处理
	public function _dc_reset_to_shoujia_om($data){
		$categoryID = $data['parentID'];
		$ViewShoujia = D("ViewShoujia");
//		$shoujiaall = $ViewShoujia->Distinct(true)->field('parentID')->where("`openID` = '$categoryID'")->findall();
		$shoujiaall = $ViewShoujia->where("`openID` = '$categoryID'")->findall();
		$ViewXianlu = D("ViewXianlu");
		foreach($shoujiaall as $v){
			$xianlu = $ViewXianlu->where("`chanpinID` = '$v[parentID]' AND `status` = '报名'")->find();
			if(!$xianlu)
				continue;
			$OM['chanpinID'] = $v['chanpinID'];
			$OM['opentype'] = '分类';
			$OM['openID'] = $categoryID;
			$this->_shoujiaToDataOM($OM);
		}
	}
	
	
	//线路状态更新
	public function _updatexianlu_status($xianluID='',$zituanID=''){
		$Chanpin = D("Chanpin");
		if(!$xianluID){
			$zituan = $Chanpin->where("`chanpinID` = '$zituanID'")->find();
			$xianluID = $zituan['parentID'];
		}
		$xianlu = $Chanpin->relation("zituanlist")->where("`chanpinID` = '$xianluID'")->find();
		$mark = 0;
		foreach($xianlu['zituanlist'] as $v){
			if($v['status'] != '截止'){
				$mark = 1;
			}
		}
		if($mark == 0){
			$xianlu['status'] = '截止';
			$xianlu = $Chanpin->save($xianlu);
			//清除销售OM
			$this->_clean_shoujia_om($xianluID);
		}
		return $xianlu['status'];
	}
	
	
	
	//线路状态更新
	public function _taskshenhe_delete($dataID,$datatype){
		$System = D("System");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$taskall = $ViewTaskShenhe->where("`dataID` = '$dataID' AND `datatype` = '$datatype'")->findall();
		foreach($taskall as $v){
			$d['systemID'] = $v['systemID'];
			$d['status_system'] = -1;
			$System->save($d);
		}
	}
	
	
	
	//商户条目增加
	public function _new_shanghutiaomu(){
		//权限判断
		$durlist = A("Method")->_checkRolesByUser('计调,经理','组团');
		if(false === $durlist){
			$durlist = A("Method")->_checkRolesByUser('地接,经理','地接');
			if(false === $durlist)
				$this->ajaxReturn('', '失败！需求经理级别以上权限！', 0);
		}
		C('TOKEN_ON',false);
		$System = D("System");
		$ViewDataDictionary = D("ViewDataDictionary");
		$_REQUEST['title'] = $_REQUEST['title'];
		$_REQUEST['companyID'] = $this->_getComIDbyUser();
		$_REQUEST['type'] = '商户条目';
		$data = $_REQUEST;
		$data['datadictionary'] = $_REQUEST;
		$data['datadictionary']['datatext'] = serialize($_REQUEST);
		$roles = $ViewDataDictionary->where("`title` = '$_REQUEST[title]'")->find();
		if($roles && ($_REQUEST['companyID'] == $roles['companyID'])){
			$this->ajaxReturn('', '新增失败：条目重复！', 0);
		}
		if($_REQUEST['title'] == ''){
			$this->ajaxReturn('', '新增失败：内容为空！', 0);
		}
		if (false === $System->relation('datadictionary')->myRcreate($data)){
			$this->ajaxReturn('', '失败！', 0);
		}
		else{
			$this->ajaxReturn('', '成功！', 1);
		}
	}
	
	
	
	//商户条目增加
	public function _check_bankfile($type){
		Vendor ( 'Excel.PHPExcel' );
		$inputFileType = 'CSV';
		$inputFileName = $_FILES['attachment']['name'];
		$inputFile = $_FILES["attachment"]["tmp_name"];
        if ($inputFileName == '')
			A("Method")->ajaxUploadResult($_REQUEST,'文件未选择！',0);
        if (pathinfo($inputFileName,PATHINFO_EXTENSION) != 'csv')
			A("Method")->ajaxUploadResult($_REQUEST,'文件类型错误！',0);
		if(false === NF_is_file_encode_utf8($inputFile))
			A("Method")->ajaxUploadResult($_REQUEST,'文件非utf8编码！',0);
		//上传附件
		$savepath = './Data/BankFiles/'; 
		if($type == '消费'){
			$savepath .= 'Consume/'; 
			//必填项
		}
		if($type == '会员'){
			$savepath .= 'Member/'; 
			
		}
		$ViewDepartment = D("ViewDepartment");
		$ComID = A("Method")->_getComIDbyUser();
		$company = $ViewDepartment->where("`systemID` = '$ComID'")->find();
		if($company['title'] == '中国银行')
			$savepath .= 'BankOfChina/';
		elseif($company['title'] == '中国农业银行')
			$savepath .= 'ABChina/';
		else
			A("Method")->ajaxUploadResult($_REQUEST,'银行配置错误！',0);
		//文件
		copy($_FILES["attachment"]["tmp_name"],$savepath.$inputFileName);
		if($filepath = A("Method")->_upload($savepath)){
			try {
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($savepath.$inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			} catch (Exception $e) {
				A("Method")->ajaxUploadResult($_REQUEST,'文件打开失败',0);
			}	
			//操作记录
			$VIP = D("VIP");
			$record['record']['filename_upload'] = $inputFileName;
			$record['record']['filename_record'] = $filepath;
			$record['record']['bank_type'] = $company['title'];
			$record['record']['file_type'] = $type;
			if(false === $VIP->relation("record")->myRcreate($record)){
				A("Method")->ajaxUploadResult($_REQUEST,'备份失败！',0);
			}
			return $sheetData;
		}
		unlink($savepath.$inputFileName);
		A("Method")->ajaxUploadResult($_REQUEST,'上传失败！',0);
	}
	
	
	
	
	//商户条目增加
	public function _dede_dingdanlist(){
		$where['clientdataID'] = array('neq','');
		$where['second_confirm'] = 1;
		$order = 'time desc';
		$WEBServiceOrder = D("WEBServiceOrder");
		$distinctfield = 'clientdataID';
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$tempcount = $WEBServiceOrder->Distinct(true)->field($distinctfield)->where($where)->findall();
		$count = count($tempcount);
		$p= new Page($count,20);
		$page = $p->show();
        $chanpinlist = $WEBServiceOrder->Distinct(true)->field($distinctfield)->where($where)->limit($p->firstRow.','.$p->listRows)->order($order)->select();
		$ViewZituan = D("ViewZituan");
		$i = 0;
		foreach($chanpinlist as $v){
			$chanpin_list[$i] = $ViewZituan->where("`chanpinID` = '$v[clientdataID]'")->find();
			$chanpin_list[$i]['orderlist'] = $WEBServiceOrder->where("`clientdataID` = '$v[clientdataID]' AND `second_confirm` = 1")->findall();
			$renshu = 0;
			foreach($chanpin_list[$i]['orderlist'] as $vol){
				$renshu += $vol['chengrenshu'] + $vol['ertongshu'];
			}
			$chanpin_list[$i]['yudinglist']['renshu'] = $renshu;
			$i++;
		}
		$this->assign("page",$page);
		$this->assign("chanpin_list",$chanpin_list);
		$this->display('B2CManage:kongguan');
	}
	
	
	//判断超级管理员
	public function _is_Super_Admin(){
		if($this->user['title'] == 'aaa')
			return true;
		return false;	
		
	}
	
	
	//判断超级管理员
	public function _zhidingxiaoshou_xiuzheng($shoujiaID,$chanpinID){
		$ViewShoujia = D("ViewShoujia");
		$shoujia = $ViewShoujia->where("`chanpinID` = '$shoujiaID'")->find();
		$ViewTiaojia = D("ViewTiaojia");
		$tiaojia = $ViewTiaojia->where("`parentID` = '$chanpinID' AND `shoujiaID` = '$shoujiaID'")->find();
		$shoujia['adultprice'] += $tiaojia['adultprice'];
		$shoujia['childprice'] += $tiaojia['childprice'];
		$shoujia['cut'] += $tiaojia['cut'];
		$shoujia['chengben'] += $tiaojia['chengben'];
		$shoujia['renshu'] += $tiaojia['renshu'];
		return $shoujia;
	}
	
	
	//编辑行程
    public function _echo_xingcheng($chanpinID) {
		$Chanpin = D("Chanpin");
		$chanpin = $Chanpin->relation('xianlu')->where("`chanpinID` = '$chanpinID'")->find();
		$xingcheng = $Chanpin->relationGet("xingchenglist");
		if(!$xingcheng)
			return '';
		$str = '<ul>';
		$count = 0 ;$t =-1;
		while ($count < $chanpin['xianlu']['tianshu']) {$t++; 
			$str .= '<li><div class="cty_article_cont_title"><i>第'.($t+1).'天</i><h1>'.$xingcheng[$count]['title'].'</h1></div><div class="cty_article_cont_infos">';
			if(strstr($xingcheng[$count]['chanyin'],'早餐')){
			$str .= '<b>早餐：</b>包含';
			}else{
			$str .= '<b>早餐：</b>不含';
			}
			if(strstr($xingcheng[$count]['chanyin'],'午餐')){
			$str .= '<b>午餐：</b>包含';
			}else{
			$str .= '<b>午餐：</b>不含';
			}
			if(strstr($xingcheng[$count]['chanyin'],'晚餐')){
			$str .= '<b>晚餐：</b>包含';
			}else{
			$str .= '<b>晚餐：</b>不含';
			}
			$str .= '<b>住宿：</b>'.$xingcheng[$count]['place'].'</div>';
			$str .= '<div class="cty_article_cont_cont">'.$xingcheng[$count]['content'].'</div></li>';
			$count++;
		}
		$str .= '</ul>';
		return $str;
    }
	
	
	
}
?>