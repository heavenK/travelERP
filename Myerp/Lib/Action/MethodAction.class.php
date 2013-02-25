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
		if($where['status_system'] != -1)
			$where['status_system'] =  array('eq',1);//默认
		if($datatype == '审核任务'){
			$where['is_notice'] =  array('eq',1);//默认
			
			$class_name = 'OMViewTaskShenhe';
			$where['title_copy'] = array('like','%'.$where['title'].'%');
			$where['user_name'] = array('like','%'.$where['user_name'].'%');
			$where['status'] = '待检出';
			if($relation == 'xianlu')
			$where['datatype'] = '线路';
			if($relation == 'DJtuan')
			$where['datatype'] = '地接';
			if($relation == 'baozhangitem'){
				$relation = 'taskshenhe';
				$where['datatype'] = '报账项';
				if($where['baozhangtitle_copy'])
				$where['baozhangtitle_copy'] = array('like','%'.$where['baozhangtitle_copy'].'%');
				if($where['tuantitle_copy'])
				$where['tuantitle_copy'] = array('like','%'.$where['tuantitle_copy'].'%');
				if($where['tuanhao_copy'])
				$where['tuanhao_copy'] = array('like','%'.$where['tuanhao_copy'].'%');
				if($where['tuanqi_copy'])
				$where['tuanqi_copy'] = array('like','%'.$where['tuanqi_copy'].'%');
				$order = 'tuanqi_copy desc';
			}
			if($relation == 'baozhang'){
				$relation = 'taskshenhe';
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
				$order = 'tuanqi_copy desc';
			}
			if($relation == 'dingdan')
			$where['datatype'] = '订单';
		}
		if($datatype == '线路'){
			$class_name = 'OMViewXianlu';
			$where['datatype'] = $datatype;
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
			$where['user_name'] = array('like','%'.$where['user_name'].'%');
			$where['title'] = array('like','%'.$where['title'].'%');
			$where['mudidi'] = array('like','%'.$where['mudidi'].'%');
			$where['chufadi'] = array('like','%'.$where['chufadi'].'%');
		}
		if($datatype == '售价'){
			$class_name = 'OMViewShoujia';
			$where['datatype'] = $datatype;
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
		}
		if($datatype == '订单'){
			$class_name = 'OMViewDingdan';
			$where['datatype'] = $datatype;
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
		if($datatype == '子团'){
			$class_name = 'OMViewZituan';
			$where['datatype'] = $datatype;
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
			$where['user_name'] = array('like','%'.$where['user_name'].'%');
			$where['title_copy'] = array('like','%'.$where['title'].'%');
			$where['tuanhao'] = array('like','%'.$where['tuanhao'].'%');
			$where['kind_copy'] = array('like','%'.$where['kind_copy'].'%');
			$order = 'chutuanriqi desc';
		}
		if($datatype == '地接'){
			$class_name = 'OMViewDJtuan';
			$where['datatype'] = $datatype;
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
			$where['user_name'] = array('like','%'.$where['user_name'].'%');
			$where['title'] = array('like','%'.$where['title'].'%');
			$where['tuanhao'] = array('like','%'.$where['tuanhao'].'%');
			if($where['fromcompany'])
			$where['fromcompany'] = array('like','%'.$where['fromcompany'].'%');
			if($where['status_baozhang'] && $where['status_baozhang'] != '批准')
			$where['status_baozhang'] = array('neq','批准');
			$order = 'jietuantime desc';
		}
		if($datatype == '报账单'){
			$class_name = 'OMViewBaozhang';
			$where['datatype'] = $datatype;
			$where['user_name'] = array('like','%'.$where['user_name'].'%');
			$where['title'] = array('like','%'.$where['title'].'%');
			$where['shenhe_remark'] = array('like','%'.$where['shenhe_remark'].'%');
			if($where['type'] == '单项服务'){
				$where['type'] = array('neq','团队报账单');
			}
		}
		if($datatype == '消息'){
			$class_name = 'OMViewInfohistory';
			$where['datatype'] = $datatype;
			$where['message'] = array('like','%'.$where['title'].'%');
			unset($where['title']);
		}
		if($datatype == '公告'){
			$class_name = 'OMViewInfo';
			$where['datatype'] = $datatype;
			$where['type'] = $datatype;
			$where['title'] = array('like','%'.$where['title'].'%');
		}
		if($datatype == '排团表'){
			$class_name = 'OMViewInfo';
			$where['datatype'] = $datatype;
			$where['type'] = $datatype;
			$where['title'] = array('like','%'.$where['title'].'%');
			$order = 'sortvalue desc,time desc';
		}
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
		$i = 0;
		if($_REQUEST['title'] || $_REQUEST['tuanhao']){
			  foreach($redata['chanpin'] as $v){
				  if($_REQUEST['title']){
					  $str = '<strong style="color:red">'.$_REQUEST['title'].'</strong>';
					  if($datatype == '子团')
						  $v['title_copy'] = str_ireplace($_REQUEST['title'],$str,$v['title_copy']);
					  else
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
		return $redata;
	}


    //显示产品列表
    public function data_list_noOM($class_name,$where,$pagenum = 20) {
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
			$where = $this->_arraytostr_filter($where);
			$where .= $where_tem;
			$order = 'case when tuanqi_1 is null then tuanqi_2 else tuanqi_1  end desc';
		}
		else{
			$where['status_system'] = 1;
			$where = $this->_facade($class_name,$where);//过滤搜索项
		}
		//$where['status'] = array('neq',-1);;
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
		$i = 0;
		if($_REQUEST['title'] || $_REQUEST['tuanhao']){
			  foreach($redata['chanpin'] as $v){
				  if($_REQUEST['title']){
					  $str = '<strong style="color:red">'.$_REQUEST['title'].'</strong>';
					  $v['title_1'] = str_ireplace($_REQUEST['title'],$str,$v['title_1']);
					  $v['title_2'] = str_ireplace($_REQUEST['title'],$str,$v['title_2']);
				  }
				  if($_REQUEST['tuanhao']){
					  $str = '<strong style="color:red">'.$_REQUEST['tuanhao'].'</strong>';
					  $v['tuanhao_1'] = str_ireplace($_REQUEST['tuanhao'],$str,$v['tuanhao_1']);
					  $v['tuanhao_2'] = str_ireplace($_REQUEST['tuanhao'],$str,$v['tuanhao_2']);
				  }
				  $redata['chanpin'][$i] = $v;
				  $i++;
			  }
		}
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
				$whereitem .= "(`DUR` = '$v[bumenID],$v[rolesID],')";//部门，角色
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
			if(strtotime($riqi) < strtotime('2011-11-11'))
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
				$datazituan['parentID'] = $chanpinID;
				$datazituan['user_name'] = $chanpin['user_name'];
				$datazituan['status'] = '报名';
				if (false !== $Chanpin->relation("zituan")->myRcreate($datazituan)){
					$zituanID = $Chanpin->getRelationID();
					//生成OM
					$dataOMlist = $this->_getDataOM($chanpinID,'线路');
					$this->_createDataOM($zituanID,'子团','管理',$dataOMlist);
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
					$dataOMlist = $this->_getDataOM($zituanID,'子团');
					$this->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
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
	
	
     public function unitlist() {
		$ViewCategory = D("ViewCategory");
		$ViewDepartment = D("ViewDepartment");
		$ViewUser = D("ViewUser");
		$ViewRoles = D("ViewRoles");
		//分类
		$datas1 = $ViewCategory->where("`status_system` != '-1' and `islock` = '未锁定' ")->findall();
		$this->assign("categoryAll",$datas1);
		//部门
		$datas2 = $ViewDepartment->where("`status_system` != '-1' and `islock` = '未锁定' ")->findall();
		$this->assign("departmentAll",$datas2);
		//用户
		$datas3 = $ViewUser->where("`status_system` != '-1' and `islock` = '未锁定' ")->findall();
		$this->assign("userAll",$datas3);
		//角色
		$datas4 = $ViewRoles->where("`status_system` != '-1' and `islock` = '未锁定' ")->findall();
		$this->assign("rolesAll",$datas4);
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
     public function _getDepartmentList() {
		$ViewDepartment = D("ViewDepartment");
		//角色
		$datas2 = $ViewDepartment->findall();
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
		$user = $ViewUser->where("`title` = '$user_name' AND (`status_system` = '1')")->find();
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
				$bumen = $ViewDepartment->where("`systemID` = '$v[bumenID]' and `status_system` = '1'")->find();
				$typelist = explode(',',$bumen['type']);
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
		$where['dataID'] = $data['chanpinID'];
		$where['datatype'] = '售价';
		$DataOM->where($where)->delete();
		//$DataOM->where("`dataID` = '$data[chanpinID]' and `datatype` = '售价' ")->delete();
		$OM['dataID'] = $data['chanpinID'];
		$OM['datatype'] = '售价';
		$OM['type'] = '开放';
		if($data['opentype'] == '分类'){
			$departmentlist = $this->_getDClist($data['openID']);
			foreach($departmentlist as $s){
				$OM['bumenID'] = $s['dataID'];
				$OM['DUR'] = $this->_OMToDataOM_filter($OM);
				if(false === $DataOM->mycreate($OM)){
					dump($DataOM);
					exit;	
				}
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
		$data['copy'] = serialize($data);
		$DataCopy = D('DataCopy');
		$data['dataID'] = $dataID;
		$data['datatype'] = $datatype;
		$data['taskID'] = $taskID;
		$DataCopy->myCreate($data);
	 }
	 
	 
	//审核任务
	//生成待检出	
	//检查审核流程
     public function _shenheDO($_REQUEST,$need) {
		$Chanpin = D("Chanpin");
		$cp = $Chanpin->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
		//订单
		if($cp['marktype'] == 'dingdan' && $cp['status'] != '确认'){
			cookie('errormessage','错误，订单不是确认状态！',30);
			return false;
		}
		if($cp['marktype'] == 'dingdan'){
			$dingdan = $Chanpin->relationGet("dingdan");
			if($dingdan['status_baozhang'] != '批准'){
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
		
		$dotype = $_REQUEST['dotype'];
		$data = $_REQUEST;
		$data['taskShenhe'] = $_REQUEST;
		$data['status'] = $_REQUEST['status_shenhe'];
		$data['user_name'] = $this->user['title'];
		if($dotype == '申请'){
			if(false === $this->_checkShenhe($_REQUEST['datatype'],1,$this->user['systemID'],$_REQUEST['dataID'])){//检查流程的申请权限！检查某人是否有审核权限！（某人的审核权限建立在产品权限之上）
				cookie('errormessage','您没有申请审核的权限！',30);
				return false;
			}
			$processID = 1;
			cookie('successmessage','操作成功！',30);
		}
		else{
			$processID = $need['processID'];
			$data['systemID'] = $need['systemID'];
			cookie('successmessage','操作成功！',30);
		}
		//检查流程状态
		$process = $this->_checkDataShenhe($_REQUEST['dataID'],$_REQUEST['datatype'],$data['status'],$processID,$need);
		if(false === $process){
			cookie('errormessage','错误！该产品流程不存在或已被执行，请勿重复执行！',30);
			return false;
		}
		$data['taskShenhe']['processID'] = $processID;
		$data['taskShenhe']['remark'] = $process[0]['remark'];
		$data['taskShenhe']['roles_copy'] = cookie('_task_roles');
		$data['taskShenhe']['bumen_copy'] = cookie('_task_bumen');
		if($_REQUEST['datatype'] == '订单'){
			$ViewDingdan = D("ViewDingdan");
			$tmdt = $ViewDingdan->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
			$data['taskShenhe']['datakind'] = $tmdt['type'];
		}
		if($_REQUEST['datatype'] == '线路'){
			$ViewXianlu = D("ViewXianlu");
			$tmdt = $ViewXianlu->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
			$data['taskShenhe']['datakind'] = $tmdt['kind'];
		}
		if($_REQUEST['datatype'] == '报账项'){
			$ViewBaozhangitem = D("ViewBaozhangitem");
			$tmdt = $ViewBaozhangitem->relation("baozhanglist")->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
			$data['taskShenhe']['datakind'] = $tmdt['baozhanglist']['type'];//报账项与报账单类型相同
		}
		if($_REQUEST['datatype'] == '报账单'){
			$ViewBaozhang = D("ViewBaozhang");
			$tmdt = $ViewBaozhang->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
			$data['taskShenhe']['datakind'] = $tmdt['type'];
		}
		if($_REQUEST['datatype'] == '地接'){
			$ViewDJtuan = D("ViewDJtuan");
			$tmdt = $ViewDJtuan->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
			$data['taskShenhe']['datakind'] = $tmdt['kind'];
		}
		$data['taskShenhe']['title_copy'] = $tmdt['title'];
		//搜索字段填充
		if($data['datatype'] == '报账单' || $data['datatype'] == '报账项'){
			//$data = $this->_gettaskshenheinfo($data['dataID'],$data['datatype'],$data);
		}
		//审核任务
		$System = D("System");
		if (false === $System->relation("taskShenhe")->myRcreate($data)){
			cookie('errormessage','错误，操作失败！'.$System->getError(),30);
			return false;
		}
		else{
			//锁定产品
			$Chanpin = D("Chanpin");
			$dat_t['chanpinID'] = $_REQUEST['dataID'];
			$dat_t['islock'] = '已锁定';
			$dat_t['shenhe_remark'] = $data['taskShenhe']['remark'];
			$dat_t['status_shenhe'] = $data['status'];
			if (false === $Chanpin->save($dat_t)){
				cookie('errormessage','错误，操作失败！'.$Chanpin->getError(),30);
				return false;
			}
		}
		$to_dataID = $System->getRelationID();
		if($processID == 1 && $data['status'] == '批准'){
			$md['systemID'] = $to_dataID;
			$md['parentID'] = $to_dataID;
			$System->save($md);
		}
		//生成待检出
		$process = $this->_checkShenhe($data['datatype'],$processID+1);
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
			$userIDlist = $this->_djcCreate($data,$process);
		}
		else{
			foreach($to_dataomlist as $vo){
				//返回需要提示的用户
				$userIDlist_temp = $this->_getuserlistByDUR($vo['DUR']);	
				$userIDlist = NF_combin_unique($userIDlist,$userIDlist_temp);
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
     public function _getDataOM($dataID,$datatype,$type = '',$omclass='') {
		 if($omclass)
		$DataOM = D($omclass);
		 else
		$DataOM = D("DataOM");
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
				if(($data['status_shenhe'] != '批准' || ($datatype == '线路' || $datatype == '地接')) && $data['status'] != '截止'){
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
     public function _checkDataOM($dataID,$datatype,$type,$userID='',$DURlist='') {
		if($userID)
			$myuserID = $userID;
		elseif($DURlist == ''){
			$myuserID = $this->user['systemID'];
			$DURlist = $this->_getDURlist($myuserID);
		}
		
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
		$where['DUR'] = array('like',$bumenID.',%');
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
		if($userID){
			if(!$dataID)
			return false;
			$myuserID = $userID;
			$DURlist = $this->_getDURlist($myuserID);
			$ViewRoles = D("ViewRoles");
			$ViewUser = D("ViewUser");
			foreach($DURlist as $v){
				//开放给个人，不检查部门
				$UR = ','.$v['userID'];
				$shenhe = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '$processID' and `UR` = '$UR'")->find();
				if($shenhe != null){
					$roletitle = $ViewUser->where("`systemID` = '$v[userID]' AND (`status_system` = '1')")->find();
					$shenhe['roletitle'] = $roletitle['title'];
					return $shenhe;
				}
				//开放给角色，检查部门
				$UR = $v['rolesID'].',';
				$shenhe = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '$processID' and `UR` = '$UR'")->find();
				if($shenhe != null){
					//检测部门是否有产品管理权
					$omdata = $this->_checkDataOMbumen($dataID,$datatype,'管理',$v['bumenID'],$v['rolesID']);
					if(false === $omdata)
						continue;
					$roletitle = $ViewRoles->where("`systemID` = '$v[rolesID]'")->find();
					$shenhe['roletitle'] = $roletitle['title'];
					return $shenhe;
				}
			}
		}
		else{
			$shenheAll = $DataShenhe->where("`datatype` = '$datatype' and `processID` = '$processID'")->findall();
			if($shenheAll != null)
				return $shenheAll;
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
			if($processID == ''){
			  $need = $ViewTaskShenhe->where("`dataID` = '$dataID' and `datatype` = '$datatype' and `status` = '待检出' AND (`status_system` = '1')")->find();
				if($need)
				  return $need;
			}
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
     public function _setMessageHistory($dataID,$datatype,$message='',$url='',$dataOMlist='',$userIDlist='') {
		$data['infohistory']['message'] = cookie('_usedbumen').cookie('_usedroles').'"'.$this->user['title'].'":'.$message;
		$data['infohistory']['usedDUR'] = cookie('_usedbumenID').','.cookie('_usedrolesID').','.$this->user['systemID'];
		$data['infohistory']['dataID'] = $dataID;
		$data['infohistory']['datatype'] = $datatype;
		$data['infohistory']['url'] = $url;
		$Message = D("Message");
		if (false !== $Message->relation("infohistory")->myRcreate($data))
			$data['messageID'] = $Message->getRelationID();
		//生成OM
		if($dataOMlist == '')
			$dataOMlist = $this->_getDataOM($dataID,$datatype,'管理');
		$this->_createDataOM($data['messageID'],'消息','管理',$dataOMlist,'DataOMMessage');
		if($userIDlist == ''){
			$userIDlist = array();
			foreach($dataOMlist as $vo){
				//返回需要提示的用户
				$userIDlist_temp = $this->_getuserlistByDUR($vo['DUR']);	
				$userIDlist = NF_combin_unique($userIDlist,$userIDlist_temp);
			}
		}
		$this->_OMToDataNotice($data['infohistory'],$userIDlist);
	}
	
	
		 
	//生成OM
     public function _createDataOM($dataID,$datatype,$type,$dataOMlist = '',$dataomclass='') {
		$dom['type'] = $type;
		$dom['datatype'] = $datatype;
		$dom['dataID'] = $dataID;
		if($dataomclass)
		$DataOM = D($dataomclass);
		else
		$DataOM = D("DataOM");
		if($dataOMlist == ''){
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
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg,txt,doc,rar,xls,xlsx'); 
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
		$omxiaoshou = $this->_checkDataOM($_REQUEST['shoujiaID'],'售价');
		if(false === $omxiaoshou){
			$this->display('Index:error');
			exit;
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
	
	
	//获得DUR,应用OM
     public function _setDataOMlist($role,$type,$username='',$guojing='') {
		  $durlist_2 = $this->_checkRolesByUser($role,$type,1,'',$username);//获得角色DUR
		  //判断用户部门联合体属性，如果真，开放产品到非联合体属性的组团部门
		  $istrue = $this->_checkbumenshuxing('联合体,办事处','',$username);
		  if($istrue){
			  $ViewDepartment = D("ViewDepartment");
			  $filterlist = $ViewDepartment->Distinct(true)->field('systemID')->where("`type` like '%联合体%' or `type` like '%办事处%'")->findall();
			  $t = 0;
			  foreach($filterlist as $v){
				  $filterlist_2[$t] = $v['systemID'];
				  $t++;
			  }
			  //判断数据类型
			  if($guojing)
		      $where = "`type` like '%组团%' AND `type` like '%".$guojing."%'";
			  else
		      $where['type'] = array('like','%组团%');
			  $bumenlist = $ViewDepartment->Distinct(true)->field('systemID')->where($where)->findall();
			  $ViewRoles = D("ViewRoles");
			  $r_jidiao = $ViewRoles->where("`title` ='计调'")->find();
			  $t = 0;
			  foreach($bumenlist as $v){//开放到角色，计调
				  if(!in_array($v['systemID'],$filterlist_2)){
					  $needlist[$t]['bumenID'] = $v['systemID'];
					  $needlist[$t]['rolesID'] = $r_jidiao['systemID'];
					  $t++;
				  }
			  }
			  foreach($durlist_2 as $v){
				   $needlist[$t]['bumenID'] = $v['bumenID'];
				   $needlist[$t]['rolesID'] = $v['rolesID'];
				   $t++;
			  }
			  $durlist_1 = about_unique($needlist);
		  }
		  if($durlist_1)
		  $durlist = $durlist_1;
		  else
		  $durlist = $durlist_2;
		  //附加开放给部门角色
		  $i = 0;
		  foreach($durlist as $v){
			  $dataOMlist[$i]['DUR'] = $v['bumenID'].','.$v['rolesID'].',';
			  $i++;
		  }
		  //附加开放到行政属性部门
		  $ViewDepartment = D("ViewDepartment");
		  $filterlist = $ViewDepartment->Distinct(true)->field('systemID')->where("`type` like '%行政%'")->findall();
		  foreach($filterlist as $v){
			  $dataOMlist[$i]['DUR'] = $v['systemID'].',,';
			  $i++;
		  }
		  return $dataOMlist;
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
     public function _checkbumenshuxing($bumentype,$userID = '',$user_name = '') {
		 if($user_name)
		$durlist = $this->_getDURlist_name($user_name);
		else
		$durlist = $this->_getDURlist($userID);
		$ViewDepartment = D("ViewDepartment");
		$bumentypelist = explode(',',$bumentype);
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
		if($type == '子团'){
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
			//检查OM
			$xianlu = $this->_checkDataOM($_REQUEST['chanpinID'],'报账单','管理');
			if(false === $xianlu)
			$this->ajaxReturn($_REQUEST,'错误，无管理权限！！！', 0);
			//判断角色
			if($this->_checkRolesByUser('财务,财务总监,总经理','行政')){
//				if($baozhang['status_shenhe'] == '批准' )
//					$this->ajaxReturn($_REQUEST,'错误，该报账单已经批准，请审核回退后修改！', 0);
			}
			else
			if($baozhang['islock'] == '已锁定' ){
				$this->ajaxReturn($_REQUEST, '错误！该报账单已经被锁定，请审核回退后修改！', 0);
			}
		}
		else{
			//检查OM
			if($_REQUEST['parentID']){
				$xianlu = $this->_checkDataOM($_REQUEST['parentID'],$_REQUEST['parenttype'],'管理');
				if(false === $xianlu)
				$this->ajaxReturn($_REQUEST,'错误，无管理权限！', 0);
				$cpdata = $Chanpin->where("`chanpinID` = '$data[parentID]'")->find();
				$data['departmentID'] = $cpdata['departmentID'];
			}
		}
			
		if (false !== $Chanpin->relation("baozhang")->myRcreate($data)){
			$chanpinID = $Chanpin->getRelationID();
			//生成OM
			if($Chanpin->getLastmodel() == 'add'){
				$dataOMlist = $this->_setDataOMlist($omrole,$omtype);
				$this->_createDataOM($chanpinID,'报账单','管理',$dataOMlist);
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
		$userIDlist = $this->_shenheDO($_REQUEST,$need);
		if (false !== $userIDlist){
			$Chanpin = D("Chanpin");
			$editdat['chanpinID'] = $_REQUEST['dataID'];
			if($status == '批准'){
				//生成备份
				$this->makefiledatacopy($_REQUEST['dataID'],$_REQUEST['datatype'],$need['parentID']);
				$editdat['shenhe_time'] = time();
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
				}
				$Chanpin->save($editdat);
				$url = 'index.php?s=/Chanpin/fabu/chanpinID/'.$_REQUEST['dataID'];
			}
			if($_REQUEST['datatype'] == '订单'){
				if($status == '批准'){
					//填入客户表
					$this->_customerbuild($_REQUEST['dataID']);
				}
				$Chanpin->relation("dingdan")->myRcreate($editdat);
				$url = 'index.php?s=/Xiaoshou/dingdanxinxi/chanpinID/'.$_REQUEST['dataID'];
			}
			if($_REQUEST['datatype'] == '报账项'){
				$Chanpin->relation("baozhangitem")->myRcreate($editdat);
				$ViewBaozhangitem = D("ViewBaozhangitem");
				$item = $ViewBaozhangitem->where("`chanpinID` = '$_REQUEST[dataID]'")->find();
				$url = 'index.php?s=/Chanpin/zituanbaozhang/baozhangID/'.$item['parentID'];
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
				$url = 'index.php?s=/Chanpin/zituanbaozhang/baozhangID/'.$_REQUEST['dataID'];
			}
			if($_REQUEST['datatype'] == '地接'){
				if($status == '批准'){
					$editdat['status'] = '在线';
				  	$Chanpin->save($editdat);
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
						$dataOMlist = $this->_getDataOM($_REQUEST['dataID'],'地接');
						$this->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
					}
				}
				$url = 'index.php?s=/Dijie/fabu/chanpinID/'.$_REQUEST['dataID'];
			}
			
			//记录
			$Chanpin = D("Chanpin");
			$message = $_REQUEST['datatype'].'审核'.$status.'『'.$_REQUEST['title'].'』 。';
			$this->_setMessageHistory($_REQUEST['dataID'],$_REQUEST['datatype'],$message,$url);
			
			if($_REQUEST['datatype'] == '报账项' || $_REQUEST['datatype'] == '报账单'){
				//任务搜索字段填充
				$djc = $this->_getTaskDJC($_REQUEST['dataID'],$_REQUEST['datatype']);//检查待审核任务存在
				$data = $this->_gettaskshenheinfo($_REQUEST['dataID'],$_REQUEST['datatype'],$djc);
				$System = D("System");
				$System->relation("taskShenhe")->myRcreate($data);
			}
			
			$this->ajaxReturn($_REQUEST, cookie('successmessage'), 1);
		}
		else
			$this->ajaxReturn($_REQUEST, cookie('errormessage'), 0);
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
		if($_REQUEST['dotype'] == 'setprint'){
			$data['chanpinID'] = $_REQUEST['chanpinID'];
			$data['baozhangitem']['is_print'] = $_REQUEST['is_print'];
		}
		else{
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
				if($baozhang['status_shenhe'] == '批准' )
					$this->ajaxReturn($_REQUEST,'报账单已经批准，请审核回退报账单后修改！', 0);
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
			//生成OM
			if($Chanpin->getLastmodel() == 'add'){
				//$dataOMlist = $this->_setDataOMlist($omrole,$omtype);
				$dataOMlist = $this->_getDataOM($_REQUEST['parentID'],'报账单');
				$this->_createDataOM($_REQUEST['chanpinID'],'报账项','管理',$dataOMlist);
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
		}
		else
			$this->ajaxReturn($_REQUEST, $Chanpin->getError(), 0);
		
	}


	//审核回退，批准回退查看流程表，申请回退查看产品的管理权限
	public function _shenheback() {
		C('TOKEN_ON',false);
		$dataID = $_REQUEST['dataID'];
		$datatype = $_REQUEST['datatype'];
		if(false === $this->_checkshenhe_admin($dataID,$datatype))
			$this->ajaxReturn($_REQUEST, cookie('errormessage'), 0);
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
		
		$this->ajaxReturn('', '操作成功！', 1);
	}



	public function _xiangmu($type) {
		$this->assign("markpos",'应收及应付');
		if($_REQUEST['baozhangID']){
			$baozhangID = $_REQUEST['baozhangID'];
			$ViewBaozhang = D("ViewBaozhang");
			$baozhang = $ViewBaozhang->where("`chanpinID` = '$baozhangID'")->find();
			$chanpinID = $baozhang['parentID'];
			if($baozhang['type'] != '团队报账单'){
				redirect(SITE_INDEX.'Chanpin/zituanbaozhang/baozhangID/'.$baozhangID);
			}
			redirect(SITE_INDEX.'Chanpin/zituanxiangmu/chanpinID/'.$chanpinID);
		}
		$chanpinID = $_REQUEST['chanpinID'];
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
	public function _tongbushoujia($xianluID) {
		$ViewShoujia = D("ViewShoujia");
		$Shoujia = D("Shoujia");
		$sjall = $ViewShoujia->where("`parentID` = '$xianluID'")->findall();
		$ViewXianlu = D("ViewXianlu");
		$xianlu = $ViewXianlu->where("`chanpinID` = '$xianluID'")->find();
		foreach($sjall as $v){
			$v['xianlu_status'] = $xianlu['status'];
			$v['xianlu_chutuanriqi'] = $xianlu['chutuanriqi'];
			$v['xianlu_kind'] = $xianlu['kind'];
			$v['xianlu_title'] = $xianlu['title'];
			$Shoujia->save($v);
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
		}elseif($_REQUEST['type'] == '订单') {
			$relation = 'dingdan';
			$this->assign("markpos",'订单');
			//ticheng
			$i = 0;
			$ViewDataDictionary = D("ViewDataDictionary");
			foreach($datalist['chanpin'] as $v){
				$datalist['chanpin'][$i]['ticheng'] = $ViewDataDictionary->where("`systemID` = '$v[tichengID]'")->find();
				$i++;
			}
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
		}
		
		$datalist = $this->getDataOMlist('审核任务',$relation,$_REQUEST);
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
			$xianlu = A('Method')->_checkDataOM($v,$type);
			if(false === $xianlu){
				$mark = 1;
				continue;
			}
			if($type == '线路'){
				//线路内容
				$ViewXianlu = D("ViewXianlu");
				$xianlu = $ViewXianlu->where("`chanpinID` = $v")->find();
				unset($xianlu['ispub']);
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
		if($type == '线路'){
			$dataOMlist = $this->_setDataOMlist('计调','组团');
			$this->_createDataOM($chanpinID,'线路','管理',$dataOMlist);
		}
		if($type == '地接'){
			$dataOMlist = $this->_setDataOMlist('地接','地接');
			$this->_createDataOM($chanpinID,'地接','管理',$dataOMlist);
		}
		if($mark == 1)
			$this->ajaxReturn($_REQUEST,'完成！,一部分线路您没有操作权限！无法进行修改！！', 1);
		$this->ajaxReturn($_REQUEST,'完成！', 1);
	
	}
	
	//获得用户权限标记
	public function _getuser_roleright(){
		$role = $this->_checkRolesByUser('计调','组团');
		if(false !== $role)
			$is_jidiao = 1;
		$role = $this->_checkRolesByUser('票务','业务');
		if(false !== $role)
			$is_jidiao = 1;
		$role = $this->_checkRolesByUser('地接','地接');
		if(false !== $role)
			$is_dijie = 1;
		$role = $this->_checkRolesByUser('财务','行政');
		if(false !== $role)
			$is_caiwu = 1;
		$role = $this->_checkRolesByUser('财务总监','行政');
		if(false !== $role)
			$is_caiwu = 1;
		$role = $this->_checkRolesByUser('总经理','行政');
		if(false !== $role)
			$is_caiwu = 1;
		$role = $this->_checkRolesByUser('网管','行政');
		if(false !== $role)
			$is_wangguan = 1;
		
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
		$datalist = A('Method')->getDataOMlist('子团','zituan',$_REQUEST);
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
			
			$i++;
		}
		
		if($dotype == '补订订单'){
			$datalist = A('Method')->data_list_noOM('ViewZituan',$_REQUEST);
		}
		
		$this->assign("page",$datalist['page']);
		$this->assign("chanpin_list",$datalist['chanpin']);
		if($dotype == '产品搜索'){
			$this->showDirectory("子团产品");
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
    public function _zituanbaoming($roletype) {
		if($roletype == '计调'){
			$chanpinID = $_REQUEST['chanpin'];
			//检查dataOM
			$xiaoshou = A('Method')->_checkDataOM($chanpinID,'子团','管理');
			if(false === $xiaoshou){
				$this->display('Index:error');
				exit;
			}
		}
		$Chanpin = D("Chanpin");
		$ViewZituan = D("ViewZituan");
		$zituan = $ViewZituan->where("`chanpinID` = '$_REQUEST[chanpinID]'")->find();
		$this->assign("zituan",$zituan);
		if($roletype == '前台'){
			//报名截止
			if( (time()-strtotime(jisuanriqi($zituan['chutuanriqi'],$zituan['baomingjiezhi'],'减少')) <= 0)  || $zituan['status_baozhang'] == '批准'){
				justalert("错误！只有超过团期后并且没有报账的子团才能进行补订订单操作！！");
				gethistoryback();
				exit;
			}
		}
		$DataCopy = D("DataCopy");
		$xianlu = $DataCopy->where("`dataID` = '$zituan[parentID]' and `datatype` = '线路'")->order("time desc")->find();
		$xianlu = simple_unserialize($xianlu['copy']);
		$xianlu['xianlu_ext'] = simple_unserialize($xianlu['xianlu']['xianlu_ext']);
		$this->assign("xianlu",$xianlu);
		//计算子团人数
		$tuanrenshu = $this->_getzituandingdan($_REQUEST['chanpinID']);
		$baomingrenshu = $tuanrenshu['baomingrenshu'];
		$shengyurenshu = $zituan['renshu'] - $baomingrenshu;
		$this->assign("shengyurenshu",$shengyurenshu);
		//提成数据
		$ViewDataDictionary = D("ViewDataDictionary");
		$ticheng = $ViewDataDictionary->where("`type` = '提成' AND `status_system` = '1'")->findall();
		$this->assign("ticheng",$ticheng);
		//获得个人部门及分类列表
		$bumenfeilei = $this->_getbumenfenleilist();
		$this->assign("bumenfeilei",$bumenfeilei);
		//清空占位过期订单
		A('Method')->_cleardingdan();
		$ViewUser = D("ViewUser");
		$userlist = $ViewUser->where("`status_system` = '1'")->findall();
		$this->assign("userlist",$userlist);
		$this->display('baoming');
	}
	
	
	
	//自动申请
    public function _autoshenqing() {
		$process = $this->_getTaskDJC($_REQUEST['dataID'],$_REQUEST['datatype']);
		if(!$process)
		$this->_doshenhe();
	}
	
	
	
	//任务搜索字段填充信息
    public function _gettaskshenheinfo($dataID,$datatype,$data) {
		$ViewBaozhang = D("ViewBaozhang");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$ViewZituan = D("ViewZituan");
		$ViewDJtuan = D("ViewDJtuan");
		$System = D("System");
		$Chanpin = D("Chanpin");
			if($datatype == '报账项'){
				$cp = $ViewBaozhangitem->where("`chanpinID` = '$dataID'")->find();
				$data['taskShenhe']['datatext_copy'] = serialize($cp);
				$cp = $Chanpin->relation("baozhanglist")->where("`chanpinID` = '$dataID'")->find();
				$data['taskShenhe']['baozhangtitle_copy'] = $cp['baozhanglist']['title'];
				$zituanID = $cp['baozhanglist']['parentID'];
			}
			if($datatype == '报账单'){
				$cp = $ViewBaozhang->where("`chanpinID` = '$dataID'")->find();
				$data['taskShenhe']['datatext_copy'] = serialize($cp);
				$cp = $Chanpin->where("`chanpinID` = '$dataID'")->find();
				$zituanID = $cp['parentID'];
			}
			//获得团
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
			$xianlu = A('Method')->_checkDataOM($v,$type);
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
				$piz = $ViewShenhe->where("`datatype` = '$datatype' AND (`status_system` = '1')")->order("processID desc")->find();
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
			$xianlu = A('Method')->_checkDataOM($v,$type);
			if(false === $xianlu){
				$mark = 1;
				continue;
			}
			if($type == '线路'){
				$data['chanpinID'] = $v;
				if($chanp['status'] == '报名')
					$data['status'] = '截止';
				if($chanp['status'] == '截止')
					$data['status'] = '报名';
				if(false === $Chanpin->mycreate($data)){
					$Chanpin->rollback();
					$this->ajaxReturn($_REQUEST,'错误！！！??', 0);
				}
				else{//同步更新售价
					$shoujialist = $Chanpin->relationGet("shoujialist");
					foreach($shoujialist as $s){
						$shoujia_data['chanpinID'] = $s['chanpinID'];
						$shoujia_data['shoujia']['xianlu_status'] = $data['status'];
						$Chanpin->relation("shoujia")->myRcreate($shoujia_data);
						
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
		$System->relation("taskShenhe")->myRcreate($data);
		$data['systemID'] = $System->getRelationID();
		//生成待检出OM
		return $this->_djcOMCreate($data,$process);
	}
	
	
	
	//生成待检出om
	function _djcOMCreate($data,$process){
		C('TOKEN_ON',false);
		//生成待检出OM
		$DataOM = D("DataOM");
		$to_dataomlist = $this->_getDataOM($data['dataID'],$data['datatype'],'管理');
		foreach($to_dataomlist as $vo){
			list($om_bumen,$om_roles,$om_user) = split(',',$vo['DUR']);
			$to_dataom['type'] = '管理';
			$to_dataom['dataID'] = $data['systemID'];
			$to_dataom['datatype'] = '审核任务';
			foreach($process as $p){
				//开关过滤
				$to_dataom['is_notice'] = $p['is_notice'];
				$to_dataom['DUR'] = $om_bumen.','.$p['UR'];
				//过滤统一部门DUR
				$tmp_d = $DataOM->where("`DUR`= '$to_dataom[DUR]' and `dataID` = '$to_dataom[dataID]' and `datatype` = '$to_dataom[datatype]'")->find();
				if(!$tmp_d){
					if(false === $DataOM->mycreate($to_dataom))
						dump($DataOM);
					//返回需要提示的用户
					$userIDlist_temp = $this->_getuserlistByDUR($to_dataom['DUR']);	
					$userIDlist = NF_combin_unique($userIDlist,$userIDlist_temp);
				}
			}
		}
		return $userIDlist;
	}
	
	
	//修复开放om
	function _djcOMCreateRepair($datatype,$processID){
		C('TOKEN_ON',false);
		//修复开放om
		$DataOM = D("DataOM");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$tsall = $ViewTaskShenhe->where("`datatype` = '$datatype' AND `processID` = '$processID' AND `status` = '待检出' AND `status_system` = 1")->findall();
		foreach($tsall as $v){
			$DataOM->where("`dataID` = '$v[systemID]'")->delete();
			$process = $this->_checkShenhe($datatype,$processID);
			$this->_djcOMCreate($v,$process);
		}
	}
	
	//删除OM并重新生成
	function _OMRcreate($dataID,$datatype,$user_name,$dataOMlist){
		C('TOKEN_ON',false);
		//修复开放om
		$DataOM = D("DataOM");
		$Chanpin = D("Chanpin");
		$ViewXianlu = D("ViewXianlu");
		$DataOM->where("`dataID` = '$dataID' and `datatype` = '$datatype'")->delete();
		if($datatype == '线路' || $datatype == '子团'){
			if(!$dataOMlist){
				if($datatype == '线路'){
					$xl = $ViewXianlu->where("`chanpinID` = '$dataID'")->find();
					$guojing = $xl['guojing'];
				}
				$dataOMlist = A("Method")->_setDataOMlist('计调','组团',$user_name,$guojing);
			}
			A("Method")->_createDataOM($dataID,$datatype,'管理',$dataOMlist);
			if($datatype == '线路'){
				$Chanpin = D("Chanpin");
				$zituanall = $Chanpin->where("`parentID` = '$dataID' and `marktype` = 'zituan'")->findall();
				foreach($zituanall as $v){
					A("Method")->_OMRcreate($v['chanpinID'],'子团',$user_name,$dataOMlist);
					$bzdall = $Chanpin->where("`parentID` = '$v[chanpinID]' and `marktype` = 'baozhang'")->findall();
					foreach($bzdall as $vol){
						A("Method")->_OMRcreate($vol['chanpinID'],'报账单',$user_name,$dataOMlist);
					}
				}
			}
		}
		if($datatype == '地接'){
				if(!$dataOMlist)
				$dataOMlist = A("Method")->_setDataOMlist('地接','地接',$user_name);
			A("Method")->_createDataOM($dataID,$datatype,'管理',$dataOMlist);
		}
		if($datatype == '报账单' || $datatype == '报账项'){
				if($dataOMlist)
					A("Method")->_createDataOM($dataID,$datatype,'管理',$dataOMlist);
		}
	}
	
	
	//获得部门用户列表
     public function _getBumenUserlist($bumenID,$bumentitle='') {
		$ViewDepartment = D("ViewDepartment");
		$ViewSystemDUR = D("ViewSystemDUR");
		$ViewUser = D("ViewUser");
		if($bumenID)
		$all = $ViewSystemDUR->where("`bumenID` = '$bumenID'")->findall();
		if($bumentitle){
			$d = $ViewDepartment->where("`title` = '$bumentitle'")->find();
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
	
	
	
	//报账单同步报账项费用
     public function _resetOM() {
		C('TOKEN_ON',false);
		$itemlist = $_REQUEST['checkboxitem'];
		$itemlist = explode(',',$itemlist);
//		if(count($itemlist) > 1)
//			$this->ajaxReturn($_REQUEST,'错误！请选择唯一一个进行操作！！', 0);
		$Chanpin = D("Chanpin");
		foreach($itemlist as $v){
			$cp = $Chanpin->where("`chanpinID` = '$v'")->find();
			$this->_OMRcreate($v,'线路',$cp['user_name']);
		}
		return true;
		
	 }
	
	
	
	
	
}
?>