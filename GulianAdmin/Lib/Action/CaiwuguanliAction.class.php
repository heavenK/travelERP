<?php

class CaiwuguanliAction extends CommonAction{
	
    public function leftcontent_caiwuguanli() {

		$glbasedata = D("glbasedata");
		$t_a = $glbasedata->where("`type` = '部门'")->order("sort_value desc")->findall();
		$adp = array('总经理','DM杂志','秘书','技术支持');
		$i = 0;
		foreach($t_a as $v){
			if(in_array($v['title'],$adp))	
			continue;
			$departmentAll[$i] = $v;
			$i++;
		}
		
		$caiwu_zituan_info = D('caiwu_zituan_info');
		$caiwu_djtuan_info = D('caiwu_djtuan_info');
		$i = 0;
		foreach($departmentAll as $department){
			
			$departmentAll[$i]['count'] = count($caiwu_zituan_info->where("`departmentID` = '$department[id]'")->Distinct(true)->field('zituanID')->select());
			$departmentAll[$i]['count'] += $caiwu_djtuan_info->where("`departmentID` = '$department[id]'")->count();
			
			$countAll +=$departmentAll[$i]['count'];
			$i++;
		}
		
		
		
		//联合体单独统计，靠。
		$lianheti_count_guonei = count($caiwu_zituan_info->where("`departmentID` = '14' AND jingwai = '国内'")->Distinct(true)->field('zituanID')->select());
		$lianheti_count_guonei += $caiwu_djtuan_info->where("`departmentID` = '14' AND jingwai = '国内'")->count();
		
		$lianheti_count_jingwai = count($caiwu_zituan_info->where("`departmentID` = '14' AND jingwai = '境外'")->Distinct(true)->field('zituanID')->select());
		$lianheti_count_jingwai += $caiwu_djtuan_info->where("`departmentID` = '14' AND jingwai = '境外'")->count();
		$this->assign("lianheti_count_jingwai",$lianheti_count_jingwai);
		$this->assign("lianheti_count_guonei",$lianheti_count_guonei);
		
        $this->assign("countAll",$countAll);
        $this->assign("departmentAll",$departmentAll);
        $this->display();
    }





    public function caiwutongji() {
		foreach($_GET as $key => $value)
		{
			$this->assign($key,$value);
		}
//		$conditions['jiedaitype'] = '接待计划';
//		$conditions['ispublished'] = '已发布';
//		if (!empty($_GET)){
//			$start_date = $_GET['chufariqi'];
//			$end_date = $_GET['jiezhiriqi'];
//			
//			if ($start_date && $end_date){
//				$conditions['chutuanriqi'] = array(array('egt',$start_date),array('elt',$end_date),'and');
//			}
//			elseif ($end_date){
//				$conditions['chutuanriqi'] = array('elt',$end_date); 	
//			}
//			elseif ($start_date){
//				$conditions['chutuanriqi'] = array('egt',$start_date); 	
//			}
//		}
		$glbasedata = D('glbasedata');
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign('departmentAll',$departmentAll);
		
		
		$glkehu = D('Glkehu');
		$kehu_all = $glkehu->findall();
		$this->assign('kehu_all',$kehu_all);
		
		$wheres = "WHERE 1=1";
		
		
		if ($_REQUEST['start_date']){
			$conditions['caiwu_time'] = array('between',strtotime($_REQUEST['start_date'].'-01').','.strtotime($_REQUEST['start_date'].'-31'));	
			$wheres .= " AND caiwu_time BETWEEN ".strtotime($_REQUEST['start_date'].'-01')." AND ".strtotime($_REQUEST['start_date'].'-31');
		}
		
		if ($_REQUEST['start_day']){
			$conditions['caiwu_time'] = array('between',strtotime($_REQUEST['start_day']).','.strtotime($_REQUEST['start_day'].' 23:59:59'));	
			$wheres .= " AND caiwu_time BETWEEN ".strtotime($_REQUEST['start_day'])." AND ".strtotime($_REQUEST['start_day'].' 23:59:59');
		}
		
		if ($_REQUEST['start_date1'] && $_REQUEST['end_date1']){
			$conditions['caiwu_time'] = array('between',strtotime($_REQUEST['start_date1']).','.strtotime($_REQUEST['end_date1']));
			$wheres .= " AND caiwu_time BETWEEN ".strtotime($_REQUEST['start_date1'])." AND ".strtotime($_REQUEST['end_date1']);	
		}else if($_REQUEST['start_date1']){
			$conditions['caiwu_time'] = array('egt',strtotime($_REQUEST['start_date1']));
			$wheres .= " AND caiwu_time >= '".strtotime($_REQUEST['start_date1'])."'";
		}else if($_REQUEST['end_date1']){
			$conditions['caiwu_time'] = array('elt',strtotime($_REQUEST['end_date1']));
			$wheres .= " AND caiwu_time <= '".strtotime($_REQUEST['end_date1'])."'";
		}
		
		if (!$conditions['caiwu_time']){
			$year = date('Y');
			$year = $year.'-01-01';
			$conditions['caiwu_time'] = array('egt',strtotime($year));
			$wheres .= " AND caiwu_time >= '".strtotime($year)."'";
		}
		
		
		$_REQUEST['department'] ? $conditions['departmentName'] = $_REQUEST['department']:'';
		$_REQUEST['departmentID'] ? $conditions['departmentID'] = $_REQUEST['departmentID']:'';
		$_REQUEST['user_name'] ? $conditions['user_name'] = $_REQUEST['user_name']:'';
		$_REQUEST['companyname'] ? $conditions['companyname'] = $_REQUEST['companyname']:'';
		$_REQUEST['guojing'] ? $conditions['guojing'] = $_REQUEST['guojing']:'';
		$_REQUEST['keyword'] ? $conditions['mingcheng'] = array('LIKE','%'.$_REQUEST['keyword'].'%'):'';
		
		
		$_REQUEST['departmentID'] ? $wheres .= " AND `departmentID` = ".$_REQUEST['departmentID']:'';
		$_REQUEST['user_name'] ? $wheres .= " AND `user_name` = '".$_REQUEST['user_name']."'":'';
		$_REQUEST['companyname'] ? $wheres .= " AND `companyname` = '".$_REQUEST['companyname']."'":'';
		$_REQUEST['guojing'] ? $wheres .= " AND `guojing` = '".$_REQUEST['guojing']."'":'';
		$_REQUEST['keyword'] ? $wheres .= " AND `keyword` LIKE '%".$_REQUEST['departmentID']."%'":'';
		
		
		//$Gljiedaijihua = D("Jiedai_zituan");
		$Gljiedaijihua = D("Zituan_baozhang");
		
		import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		
		//联合子团和地接视图
		$sql = "SELECT * from (SELECT z.zituanID,z.caiwuren,z.caiwu_time,z.xianlutype,z.tuanhao,z.mingcheng,z.chutuanriqi,z.departmentID,z.departmentName,z.user_name,z.renshu FROM zituan_baozhang z union all SELECT d.djtuanID,d.financeperson,d.caiwu_time,d.xianlutype,d.tuannumber,d.tuantitle,d.startdate,d.departmentID,d.departmentName,d.adduser,d.renshu FROM djtuan_baozhang d) AS tmp ".$wheres;
		$rs = M()->query($sql);
		//dump($rs);
		
		//$count = $Gljiedaijihua->where($conditions)->count();
		$count = count($rs);
		
		$p= new Page($count,20);
		//$rurl = SITE_ADMIN."Caiwuguanli/jiedaijihua/p/";
		$page = $p->show();
		$page = $p->show_select();

        //$jiedaijihua_all = $Gljiedaijihua->where($conditions)->order("caiwu_time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		//$jiedaijihua_nopage = $Gljiedaijihua->where($conditions)->order("chutuanriqi DESC")->select();
		$jiedaijihua_all = M()->query($sql." ORDER BY caiwu_time DESC LIMIT ".$p->firstRow.",".$p->listRows);
		$jiedaijihua_nopage = $rs;
		
		
		$GLbaozhang = D("Gl_baozhang");
		$GLbaozhangitem = D("Gl_baozhangitem");
		
		$DJbaozhang = D("Dj_baozhang");
		$DJbaozhangitem = D("Dj_baozhangitem");
		
		$Gltuanyuan = D("tuanyuan_dingdan");
		
		foreach($jiedaijihua_all as $key=>$jiedai){
			
			if($jiedai['xianlutype'] == '地接'){
				$baozhang = $DJbaozhang->where('`djtuanID`='.$jiedai['zituanID'])->find();
			}else{
				$baozhang = $GLbaozhang->where('`zituanID`='.$jiedai['zituanID'])->find();
			}
			
			//报账人数
			if($jiedai['xianlutype'] == '地接'){
				$jiedaijihua_all[$key]['baozhangrenshu'] = $jiedai['renshu'];
			}else{
				$jiedaijihua_all[$key]['baozhangrenshu'] = $baozhang['renshu'];
			}
			
			
			//$renshu_sum += $baozhang['renshu'];
			
			//统计订单数
			$Gldingdan = D("dingdan_zituan");
			$jiedaijihua_all[$key]['dingdanshu'] = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->count();
			//$dingdan_sum += $jiedaijihua_all[$key]['dingdanshu'];
			
			//add by gaopeng 2012 2 27
/*			$dingdan_all = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->findall();
			$dindanrenshu_num_t = 0;
			foreach($dingdan_all as $v){
				$dindanrenshu = $v['chengrenshu'] + $v['ertongshu'];
				$dindanrenshu_num_t += $dindanrenshu;
				//$dindanrenshu_num_a += $dindanrenshu;
			}
			$jiedaijihua_all[$key]['dingdanrenshu'] = $dindanrenshu_num_t;*/
			//end
			
			//参团人数和领队人数统计 by heavenK
			$rennum = 0;
			$rennum_leader = 0;
			$dingdanall = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->findall();
			foreach($dingdanall as $dingdan){
				$rennum += $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 0")->count();
				$rennum_leader += $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 1")->count();
			}
			$jiedaijihua_all[$key]['dingdanrenshu'] = $rennum;
			$jiedaijihua_all[$key]['dingdanrenshu_leader'] = $rennum_leader;
			
		/*//画订单图 by heavenK
		$dingdanAll = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->findall();
			foreach($dingdanAll as $dingdan)
			{
				//统计图用
				$node_date = date('Y-m',$dingdan['time']);
				$node[$node_date]++;
				//人数统计图
				$Gltuanyuan = D("tuanyuan_dingdan");
				$rennum = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->count();
				$node_people[$node_date] += $rennum;
				//钱数统计图
				$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findAll();
				$sum = 0;
				foreach($tuanyuanAll as $tuanyuan){
					$sum += $tuanyuan['jiaoqian'];
				}
				$node_money[$node_date] += $sum;
			}*/
			//结束
			
/*			//人数flash
			$strXML_people = "<graph caption='人数' xAxisName='月份' yAxisName='份额' decimalPrecision='0' formatNumberScale='0'>";
			ksort($node_people);
			foreach($node_people as $dates => $values){
				$strXML_people .= "<set name='".$dates."' value='".$values."' color='AFD8F8' />";
			}
			$strXML_people .=  "</graph>";
			$this->assign('strXML_people',$strXML_people);
			
			//钱数flash
			$strXML_money = "<graph caption='金额' xAxisName='月份' yAxisName='份额' decimalPrecision='0' formatNumberScale='0'>";
			ksort($node_money);
			foreach($node_money as $dates => $values){
				$strXML_money .= "<set name='".$dates."' value='".$values."' color='AFD8F8' />";
			}
			$strXML_money .=  "</graph>";
			$this->assign('strXML_money',$strXML_money);
		
			$strXML = "<graph caption='订单数' xAxisName='月份' yAxisName='份额' decimalPrecision='0' formatNumberScale='0'>";
			ksort($node);
			foreach($node as $dates => $values){
				$strXML .= "<set name='".$dates."' value='".$values."' color='AFD8F8' />";
			}
			$strXML .=  "</graph>";
			$this->assign('strXML',$strXML);*/
			
			if($jiedai['xianlutype'] == '地接'){
				$money_all = $DJbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
			}else{
				$money_all = $GLbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
			}
			
			foreach($money_all as $money){
				//if ($money['type'] == '项目') $jiedaijihua_all[$key]['xiangmu'] = $money['price'];
				if ($money['type'] == '支出项目') $jiedaijihua_all[$key]['zhichu'] = $money['price'];
				if ($money['type'] == '结算项目') $jiedaijihua_all[$key]['shouru'] = $money['price'];
			}
			
			
			//$shouru_sum += $jiedaijihua_all[$key]['shouru'];
			//$zhichu_sum += $jiedaijihua_all[$key]['zhichu'];
		}
		
		foreach($jiedaijihua_nopage as $key=>$jiedai){
			//分月统计
			$node_date = date('Y-m',$jiedai['caiwu_time']);
			
			if($jiedai['xianlutype'] == '地接'){
				$baozhang = $DJbaozhang->where('`djtuanID`='.$jiedai['zituanID'])->find();
			}else{
				$baozhang = $GLbaozhang->where('`zituanID`='.$jiedai['zituanID'])->find();
			}
			
			//参团人数和领队人数统计 by heavenK
			$Gldingdan = D("dingdan_zituan");
			$rennum = 0;
			$rennum_leader = 0;
			$dingdanall = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->findall();
			foreach($dingdanall as $dingdan){
				$rennum += $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 0")->count();
				$rennum_leader += $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 1")->count();
			}
			$node_people[$node_date] +=  $rennum;
			$node_people_leader[$node_date] +=  $rennum_leader;
			$renshu_sum += $rennum;
			$renshu_sum_leader += $rennum_leader;
			
			//报账人数
			/*$renshu_sum += $baozhang['renshu'];
			
			$node_people[$node_date] += $baozhang['renshu'];*/
			
			//统计订单数
			$Gldingdan = D("dingdan_zituan");
			$dingdan_num_nopage = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->count();
			$dingdan_sum += $dingdan_num_nopage;

/*			$dingdan_all = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->findall();
			foreach($dingdan_all as $v){
				$dindanrenshu = $v['chengrenshu'] + $v['ertongshu'];
				$dindanrenshu_num_a += $dindanrenshu;
			}*/


			$node_dingdan[$node_date] += $dingdan_num_nopage;

			if($jiedai['xianlutype'] == '地接'){
				$money_all = $DJbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
			}else{
				$money_all = $GLbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
			}
			
			
			foreach($money_all as $money){
				if ($money['type'] == '项目') $xiangmu_num_nopage = $money['price'];
				if ($money['type'] == '支出项目') $zhichu_num_nopage = $money['price'];
				if ($money['type'] == '结算项目') $shouru_num_nopage = $money['price'];
			}
			
			$shouru_sum += $xiangmu_num_nopage + $shouru_num_nopage;
			$zhichu_sum += $zhichu_num_nopage;
			
			
			$node_yingshou[$node_date] += $xiangmu_num_nopage + $shouru_num_nopage;
			$node_yingfu[$node_date] += $zhichu_num_nopage;
			
		}
		ksort($node_people);
		$this->assign('node_people',$node_people);
		$this->assign('node_people_leader',$node_people_leader);
		$this->assign('node_dingdan',$node_dingdan);
		$this->assign('node_yingshou',$node_yingshou);
		$this->assign('node_yingfu',$node_yingfu);
		
		
		//所在位置
		$navlist = "账务管理 > 统计管理 > 财务统计";
		$this->assign('navlist',$navlist);
		$this->assign('dingdan_sum',$dingdan_sum);
		$this->assign('dindanrenshu_num_a',$dindanrenshu_num_a);
		$this->assign('renshu_sum',$renshu_sum);
		$this->assign('renshu_sum_leader',$renshu_sum_leader);
		$this->assign('shouru_sum',$shouru_sum);
		$this->assign('zhichu_sum',$zhichu_sum);
        $this->assign('page',$page);
		$this->assign('jiedaijihua_all',$jiedaijihua_all);
		
		//搜索出团日期
/*		if ($_REQUEST['start_date']){
			$conditions['chutuanriqi'] = array('between',"'".$_REQUEST['start_date'].'-01'."'".','."'".$_REQUEST['start_date'].'-31'."'");	
		}
		
		if ($_REQUEST['start_day']){
			$conditions['chutuanriqi'] = array('between',"'".$_REQUEST['start_day']."'".','."'".$_REQUEST['start_day'].' 23:59:59'."'");	
		}
		
		if ($_REQUEST['start_date1'] && $_REQUEST['end_date1']){
			$conditions['chutuanriqi'] = array('between',"'".$_REQUEST['start_date1']."'".','."'".$_REQUEST['end_date1']."'");	
		}else if($_REQUEST['start_date1']){
			$conditions['chutuanriqi'] = array('egt',"'".$_REQUEST['start_date1']."'");
		}else if($_REQUEST['end_date1']){
			$conditions['chutuanriqi'] = array('elt',"'".$_REQUEST['end_date1']."'");
		}
		unset($conditions[caiwu_time]);*/
		$wheres_nopass = "WHERE 1=1";
		$_REQUEST['departmentID'] ? $wheres_nopass .= " AND `departmentID` = ".$_REQUEST['departmentID']:'';
		$_REQUEST['user_name'] ? $wheres_nopass .= " AND `user_name` = '".$_REQUEST['user_name']."'":'';
		$_REQUEST['companyname'] ? $wheres_nopass .= " AND `companyname` = '".$_REQUEST['companyname']."'":'';
		$_REQUEST['guojing'] ? $wheres_nopass .= " AND `guojing` = '".$_REQUEST['guojing']."'":'';
		$_REQUEST['keyword'] ? $wheres_nopass .= " AND `keyword` LIKE '%".$_REQUEST['departmentID']."%'":'';
		
		
		//add by gaopeng 2012 2 27
/*		$zituan_baozhang_nopass = D("zituan_baozhang_nopass");
		$tuanall_nopass = $zituan_baozhang_nopass->where($conditions)->findall();*/
		
		//联合子团和地接团 by heavenK
		$sql = "SELECT * from (SELECT z.zituanID,z.caiwuren,z.caiwu_time,z.xianlutype,z.tuanhao,z.mingcheng,z.chutuanriqi,z.departmentID,z.departmentName,z.user_name,z.renshu FROM zituan_baozhang_nopass z union all SELECT d.djtuanID,d.financeperson,d.caiwu_time,d.xianlutype,d.tuannumber,d.tuantitle,d.startdate,d.departmentID,d.departmentName,d.adduser,d.renshu FROM djtuan_baozhang_nopass d) AS tmp ".$wheres_nopass;
		$rs = M()->query($sql);
		$tuanall_nopass = $rs;
		
		foreach($tuanall_nopass as $key => $value){
			
			if($value['xianlutype'] == '地接'){
				$baozhang = $DJbaozhang->where('`djtuanID`='.$value['zituanID'])->find();
			}else{
				$baozhang = $GLbaozhang->where('`zituanID`='.$value['zituanID'])->find();
			}
			
			if($value['xianlutype'] == '地接'){
				$tuanall_nopass[$key]['baozhangrenshu'] = $value['renshu'];
			}else{
				$tuanall_nopass[$key]['baozhangrenshu'] = $baozhang['renshu'];
			}
			
			
			//订单数人数
			$Gldingdan = D("dingdan_zituan");
			$tuanall_nopass[$key]['dingdanshu'] = $Gldingdan->where("`zituanID`= $value[zituanID]")->count();
			$dingdanshu += $tuanall_nopass[$key]['dingdanshu'];
			
			
			
			
/*			$dingdanall = $Gldingdan->where('`zituanID`='.$value['zituanID'])->findall();
			$dindanrenshu_num_t = 0;
			foreach($dingdanall as $v){
				$dindanrenshu = $v['chengrenshu'] + $v['ertongshu'];
				$dindanrenshu_num_t += $dindanrenshu;
				$dindanrenshu_num += $dindanrenshu;
				
			}
			$tuanall_nopass[$key]['dingdanrenshu'] = $dindanrenshu_num_t;*/
			
			//参团人数和领队人数统计 by heavenK
			$rennum = 0;
			$rennum_leader = 0;
			$dingdanall = $Gldingdan->where('`zituanID`='.$value['zituanID'])->findall();
			foreach($dingdanall as $dingdan){
				$rennum += $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 0")->count();
				$rennum_leader += $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 1")->count();
			}
			$tuanall_nopass[$key]['dingdanrenshu'] = $rennum;
			$tuanall_nopass[$key]['dingdanrenshu_leader'] = $rennum_leader;
			
			$dindanrenshu_num += $rennum;
			$dindanrenshu_num_leader += $rennum_leader;
			
			//报账项
			if($value['xianlutype'] == '地接'){
				$money_all = $DJbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID'])->group('type')->field('sum(price) as price, type')->findAll();
			}else{
				$money_all = $GLbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID'])->group('type')->field('sum(price) as price, type')->findAll();
			}
			
			foreach($money_all as $money){
				if ($money['type'] == '支出项目') $tuanall_nopass[$key]['zhichu'] = $money['price'];
				if ($money['type'] == '结算项目') $tuanall_nopass[$key]['shouru'] = $money['price'];
			}
			$shouru_sum_nopass += $tuanall_nopass[$key]['shouru'];
			$zhichu_sum_nopass += $tuanall_nopass[$key]['zhichu'];
		}
		$this->assign('dindanrenshu_num',$dindanrenshu_num);
		$this->assign('dingdanshu',$dingdanshu);
		$this->assign('dindanrenshu_num_leader',$dindanrenshu_num_leader);
		$this->assign('shouru_sum_nopass',$shouru_sum_nopass);
		$this->assign('zhichu_sum_nopass',$zhichu_sum_nopass);
		$this->assign('tuanall_nopass',$tuanall_nopass);
		//end
		
        $this->display();
	}


	public function yejitongji() {
		foreach($_GET as $key => $value)
		{
			$this->assign($key,$value);
		}
		$glbasedata = D('glbasedata');
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign('departmentAll',$departmentAll);
		
		
		$glkehu = D('Glkehu');
		$kehu_all = $glkehu->findall();
		$this->assign('kehu_all',$kehu_all);
		
		$wheres = "WHERE 1=1";
		
		
		if ($_REQUEST['start_date']){
			$conditions['caiwu_time'] = array('between',strtotime($_REQUEST['start_date'].'-01').','.strtotime($_REQUEST['start_date'].'-31'));	
			$wheres .= " AND caiwu_time BETWEEN ".strtotime($_REQUEST['start_date'].'-01')." AND ".strtotime($_REQUEST['start_date'].'-31');
		}
		
		if ($_REQUEST['start_day']){
			$conditions['caiwu_time'] = array('between',strtotime($_REQUEST['start_day']).','.strtotime($_REQUEST['start_day'].' 23:59:59'));	
			$wheres .= " AND caiwu_time BETWEEN ".strtotime($_REQUEST['start_day'])." AND ".strtotime($_REQUEST['start_day'].' 23:59:59');
		}
		
		if ($_REQUEST['start_date1'] && $_REQUEST['end_date1']){
			$conditions['caiwu_time'] = array('between',strtotime($_REQUEST['start_date1']).','.strtotime($_REQUEST['end_date1']));
			$wheres .= " AND caiwu_time BETWEEN ".strtotime($_REQUEST['start_date1'])." AND ".strtotime($_REQUEST['end_date1']);	
		}else if($_REQUEST['start_date1']){
			$conditions['caiwu_time'] = array('egt',strtotime($_REQUEST['start_date1']));
			$wheres .= " AND caiwu_time >= '".strtotime($_REQUEST['start_date1'])."'";
		}else if($_REQUEST['end_date1']){
			$conditions['caiwu_time'] = array('elt',strtotime($_REQUEST['end_date1']));
			$wheres .= " AND caiwu_time <= '".strtotime($_REQUEST['end_date1'])."'";
		}
		
		if (!$conditions['caiwu_time']){
			$year = date('Y');
			$year = $year.'-01-01';
			$conditions['caiwu_time'] = array('egt',strtotime($year));
			$wheres .= " AND caiwu_time >= '".strtotime($year)."'";
		}
		
		
		$_REQUEST['department'] ? $conditions['departmentName'] = $_REQUEST['department']:'';
		$_REQUEST['departmentID'] ? $conditions['departmentID'] = $_REQUEST['departmentID']:'';
		$_REQUEST['user_name'] ? $conditions['user_name'] = $_REQUEST['user_name']:'';
		$_REQUEST['companyname'] ? $conditions['companyname'] = $_REQUEST['companyname']:'';
		$_REQUEST['guojing'] ? $conditions['guojing'] = $_REQUEST['guojing']:'';
		$_REQUEST['keyword'] ? $conditions['mingcheng'] = array('LIKE','%'.$_REQUEST['keyword'].'%'):'';
		
		
		$_REQUEST['departmentID'] ? $wheres .= " AND `departmentID` = ".$_REQUEST['departmentID']:'';
		$_REQUEST['user_name'] ? $wheres .= " AND `user_name` = '".$_REQUEST['user_name']."'":'';
		
		if($_REQUEST['user_name']){
			
			$db = D("dingdan_baozhang");
			$sql1	=	"SELECT DISTINCT `zituanID`  
			FROM `dingdan_baozhang`   
			WHERE   
			`user_name` =  '".$_REQUEST['user_name']."' AND `check_status` = '审核通过'";
			$rs = $db->query($sql1);

			foreach($rs as $v){ $cond	.=	$v["zituanID"].",";}
			$cond	=	rtrim($cond,",");
			
			if($cond) $wheres .= " OR `zituanID` IN (".$cond.")";
		}
		
		$_REQUEST['companyname'] ? $wheres .= " AND `companyname` = '".$_REQUEST['companyname']."'":'';
		$_REQUEST['guojing'] ? $wheres .= " AND `guojing` = '".$_REQUEST['guojing']."'":'';
		$_REQUEST['keyword'] ? $wheres .= " AND `keyword` LIKE '%".$_REQUEST['departmentID']."%'":'';
		
		
		

		$Gljiedaijihua = D("Zituan_baozhang");
		
		import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		
		//联合子团和地接视图
		$sql = "SELECT * from (SELECT z.zituanID,z.caiwuren,z.caiwu_time,z.xianlutype,z.tuanhao,z.mingcheng,z.chutuanriqi,z.departmentID,z.departmentName,z.user_name,z.renshu FROM zituan_baozhang z union all SELECT d.djtuanID,d.financeperson,d.caiwu_time,d.xianlutype,d.tuannumber,d.tuantitle,d.startdate,d.departmentID,d.departmentName,d.adduser,d.renshu FROM djtuan_baozhang d) AS tmp ".$wheres;
		$rs = M()->query($sql);

		$count = count($rs);
		
		$p= new Page($count,20);
		$page = $p->show();
		$page = $p->show_select();


		$jiedaijihua_all = M()->query($sql." ORDER BY caiwu_time DESC LIMIT ".$p->firstRow.",".$p->listRows);
		$jiedaijihua_nopage = $rs;
		
		
		$GLbaozhang = D("Gl_baozhang");
		$GLbaozhangitem = D("Gl_baozhangitem");
		
		$DJbaozhang = D("Dj_baozhang");
		$DJbaozhangitem = D("Dj_baozhangitem");
		
		$Gltuanyuan = D("tuanyuan_dingdan");
		
		foreach($jiedaijihua_all as $key=>$jiedai){
			
			if($jiedai['xianlutype'] == '地接'){
				$jiedaijihua_all[$key] = get_informations('zituan', $jiedaijihua_all[$key], $jiedai['zituanID'], '1');
			}else{
				$jiedaijihua_all[$key] = get_informations('zituan', $jiedaijihua_all[$key], $jiedai['zituanID']);
			}
		}
		
		foreach($jiedaijihua_nopage as $key=>$jiedai){
			//分月统计
			$node_date = date('Y-m',$jiedai['caiwu_time']);
			
			if($jiedai['xianlutype'] == '地接'){
				$baozhang = $DJbaozhang->where('`djtuanID`='.$jiedai['zituanID'])->find();
			}else{
				$baozhang = $GLbaozhang->where('`zituanID`='.$jiedai['zituanID'])->find();
			}
			
			//参团人数和领队人数统计 by heavenK
			$Gldingdan = D("dingdan_zituan");
			$rennum = 0;
			$rennum_leader = 0;
			$dingdanall = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->findall();
			foreach($dingdanall as $dingdan){
				$rennum += $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 0")->count();
				$rennum_leader += $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 1")->count();
			}
			$node_people[$node_date] +=  $rennum;
			$node_people_leader[$node_date] +=  $rennum_leader;
			$renshu_sum += $rennum;
			$renshu_sum_leader += $rennum_leader;
			
			
			//统计订单数
			$Gldingdan = D("dingdan_zituan");
			$dingdan_num_nopage = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->count();
			$dingdan_sum += $dingdan_num_nopage;


			$node_dingdan[$node_date] += $dingdan_num_nopage;

			if($jiedai['xianlutype'] == '地接'){
				$money_all = $DJbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
			}else{
				$money_all = $GLbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
			}
			
			
			foreach($money_all as $money){
				if ($money['type'] == '项目') $xiangmu_num_nopage = $money['price'];
				if ($money['type'] == '支出项目') $zhichu_num_nopage = $money['price'];
				if ($money['type'] == '结算项目') $shouru_num_nopage = $money['price'];
			}
			
			$shouru_sum += $xiangmu_num_nopage + $shouru_num_nopage;
			$zhichu_sum += $zhichu_num_nopage;
			
			
			$node_yingshou[$node_date] += $xiangmu_num_nopage + $shouru_num_nopage;
			$node_yingfu[$node_date] += $zhichu_num_nopage;
			
		}
		ksort($node_people);
		$this->assign('node_people',$node_people);
		$this->assign('node_people_leader',$node_people_leader);
		$this->assign('node_dingdan',$node_dingdan);
		$this->assign('node_yingshou',$node_yingshou);
		$this->assign('node_yingfu',$node_yingfu);
		
		
		//所在位置
		$navlist = "账务管理 > 统计管理 > 财务统计";
		$this->assign('navlist',$navlist);
		$this->assign('dingdan_sum',$dingdan_sum);
		$this->assign('dindanrenshu_num_a',$dindanrenshu_num_a);
		$this->assign('renshu_sum',$renshu_sum);
		$this->assign('renshu_sum_leader',$renshu_sum_leader);
		$this->assign('shouru_sum',$shouru_sum);
		$this->assign('zhichu_sum',$zhichu_sum);
        $this->assign('page',$page);
		$this->assign('jiedaijihua_all',$jiedaijihua_all);
		
        $this->display();
	}






    public function yewutongji() {
		
		foreach($_GET as $key => $value)
		{
			$this->assign($key,$value);
		}
		
		//默认散客
		$types = $_REQUEST['types'];
		$tuan = $_REQUEST['tuan'];
		
		if (!$types) 
			$types = 'Line';
		$this->assign('types',$types);
		
		if ($types == 'Line'){
			$navlist = "账务管理 > 业务统计 > 散客产品";
			$condition['xianlutype'] = '散客产品';
			$condition_all['xianlutype'] = '散客产品';
		}
		if ($types == 'Free'){
			$navlist = "账务管理 > 业务统计 > 自由人";
			$condition['xianlutype'] = '自由人';
			$condition_all['xianlutype'] = '自由人';
		}
		if ($types == 'baotuan'){
			$navlist = "账务管理 > 业务统计 >包团";
			$condition['xianlutype'] = '包团';
			$condition_all['xianlutype'] = '包团';
		}
		if ($types == 'Ticket'){
			$navlist = "账务管理 > 业务统计 > 机票";
		}
		if ($types == 'Hotel'){
			$navlist = "账务管理 > 业务统计 > 酒店";
		}
		$this->assign('navlist',$navlist);
		
		$glbasedata = D('glbasedata');
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign('departmentAll',$departmentAll);
		
		$gllvxingshe = D('gllvxingshe');
		$company = $this->company;
		$companyAll = $gllvxingshe->where("`belongID` = '$company[belongID]'")->findall();
		$this->assign('companyAll',$companyAll);
		
		$glkehu = D('Glkehu');
		$kehu_all = $glkehu->findall();
		$this->assign('kehu_all',$kehu_all);
		
		
/*
		if ($types == 'Line' || $types == 'Free'){
			
			$Gldingdan = D("dingdan_zituan");
			$caiwu_zituan_info = D('caiwu_zituan_info');
			
			//搜索功能
//			$type = $_REQUEST['type'];
//			$condition = '';
//			if (!empty($type)){
//				$start_date = $_REQUEST['start_date'];
//				$end_date = $_REQUEST['end_date'];
//				if ($start_date && $end_date){
//					$condition['time'] = array(array('egt',strtotime($start_date)),array('elt',strtotime($end_date)),'and');
//				}
//				elseif ($start_date){
//					$condition['time'] = array('egt',strtotime($start_date)); 	
//				}
//				elseif ($end_date){
//					$condition['time'] = array('elt',strtotime($end_date)); 	
//				}
//				$agent = $_REQUEST['agent'];
//				if ($agent){
//					$condition['laiyuan'] = $agent; 	
//				}
//				$lianxiren = $_REQUEST['lianxiren'];
//				if ($lianxiren){
//					$condition['user_name'] = $lianxiren; 	
//				}
//			}
			//搜索结束
			
			if ($types == 'Line')	
				$condition['xianlutype'] = '散客产品';
			if ($types == 'Free')	
				$condition['xianlutype'] = '自由人';
			
			$i = 0;
			$dingdanAll = $Gldingdan->where($condition)->order("time desc")->findall();
			$Gltuanyuan = D("tuanyuan_dingdan");
			foreach($dingdanAll as $dingdan)
			{
					//统计图用
					$node_date = date('Y-m',$dingdan['time']);
					$node[$node_date]++;
					$yongjin += $dingdan['yongjin'];
					$chengrenshu = $Gltuanyuan->where("`manorchild` = '成人' and `dingdanID` = '$dingdan[dingdanID]'")->count();
					$ertongshu = $Gltuanyuan->where("`manorchild` = '儿童' and `dingdanID` = '$dingdan[dingdanID]'")->count();
					$renshu = $chengrenshu + $ertongshu;
					$qianshu += $chengrenshu * $dingdan['chengrenjia']+ $ertongshu * $dingdan['ertongjia'];

					$i++;
			}
			$dingdannum = $i + 1;
			
			$this->assign('chengrenshu',$chengrenshu);
			$this->assign('ertongshu',$ertongshu);
			$this->assign('yongjin',$yongjin);
			$this->assign('num',$i);
			$this->assign('qianshu',$qianshu);
			$this->assign('dingdanAll',$dingdanAll);
			
			
			//$dingdans = $Gldingdan->where($condition)->order("time desc")->findall();
		
		}
		
*/		
		
		if ($types == 'Ticket'){
			
			//搜索功能
			$type = $_REQUEST['type'];
			
			$condition = '';
			if (!empty($type)){
				
				$start_date = $_REQUEST['start_date'];
				$end_date = $_REQUEST['end_date'];
				if ($start_date && $end_date){
					$condition['pubdate'] = array(array('egt',strtotime($start_date)),array('elt',strtotime($end_date)),'and');
				}
				elseif ($start_date){
					$condition['pubdate'] = array('egt',strtotime($start_date)); 	
				}
				elseif ($end_date){
					$condition['pubdate'] = array('elt',strtotime($end_date)); 	
				}
				
				
				$user_name = $_REQUEST['user_name'];
				if ($user_name){
					$condition['user_name'] = $user_name; 	
				}

			}
			//搜索结束
			
			$dingdan = D("Ticket_signup");
			
			
			import("@.ORG.Page");
			C('PAGE_NUMBERS',10);

			$count = $dingdan->relation(true)->where($condition)->count();
			$shownumber = 20;
			$p= new Page($count,$shownumber);
			$page = $p->show_select();
			$this->assign('page',$page);
			
			$dingdanPage = $dingdan->relation(true)->where($condition)->order('pubdate desc')->limit($p->firstRow.','.$p->listRows)->findall();
			$dingdanAll = $dingdan->relation(true)->where($condition)->order('pubdate desc')->findall();
			
			
			//人员名单
			$glkehu = D('Glkehu');
			$kehu_all = $glkehu->findall();
			$this->assign('kehu_all',$kehu_all);
			
			
			$i = 0;
			foreach($dingdanAll as $dingdan)
			{
					//统计图用
					$node_date = date('Y-m',$dingdan['pubdate']);
					$node[$node_date]++;
				
					$renshu += $dingdan['re_num'];
					$qianshu += $dingdan['re_num'] * $dingdan['ticket_date']['price'];
					$i++;
			}
			$dingdannum = $i + 1;
			
			$this->assign('renshu',$renshu);
			$this->assign('num',$i);
			$this->assign('qianshu',$qianshu);
			$this->assign('dingdanAll',$dingdanAll);
		}
		
		if ($types == 'Hotel'){
			
			//搜索功能
			$type = $_REQUEST['type'];
			
			$condition = '';
			if (!empty($type)){
				
				
				$start_date = $_REQUEST['start_date'];
				$end_date = $_REQUEST['end_date'];
				if ($start_date && $end_date){
					$condition['pubdate'] = array(array('egt',strtotime($start_date)),array('elt',strtotime($end_date)),'and');
				}
				elseif ($start_date){
					$condition['pubdate'] = array('egt',strtotime($start_date)); 	
				}
				elseif ($end_date){
					$condition['pubdate'] = array('elt',strtotime($end_date)); 	
				}
				
				
				$user_name = $_REQUEST['user_name'];
				if ($user_name){
					$condition['user_name'] = $user_name; 	
				}

				
			}
			//搜索结束
			

			
			
			
			$dingdan = D("Signup");
			
			import("@.ORG.Page");
			C('PAGE_NUMBERS',10);

			$count = $dingdan->relation(true)->where($condition)->count();
			$shownumber = 20;
			$p= new Page($count,$shownumber);
			$page = $p->show_select();
			$this->assign('page',$page);
			
			$dingdanPage = $dingdan->relation(true)->where($condition)->order('pubdate desc')->limit($p->firstRow.','.$p->listRows)->findall();
			$dingdanAll = $dingdan->relation(true)->where($condition)->order('pubdate desc')->findall();
			
			//人员名单
			$glkehu = D('Glkehu');
			$kehu_all = $glkehu->findall();
			$this->assign('kehu_all',$kehu_all);
			
			
			$i = 0;
			foreach($dingdanAll as $dingdan)
			{
					//统计图用
					$node_date = date('Y-m',$dingdan['pubdate']);
					$node[$node_date]++;
				
					$renshu += $dingdan['re_num'];
					$tianshu += $dingdan['stay_day'];
					$qianshu += $dingdan['re_num'] * $dingdan['hotel_date']['price'] * $dingdan['stay_day'];
					$i++;
			}
			$dingdannum = $i + 1;
			$this->assign('renshu',$renshu);
			$this->assign('tianshu',$tianshu);
			$this->assign('num',$i);
			$this->assign('qianshu',$qianshu);
			$this->assign('dingdanAll',$dingdanPage);
		}
		
		//$condition = $_POST;
		if ($types == 'Line' || $types == 'Free' || $types == 'baotuan'){

/*			if ($_REQUEST['start_date'] && $_REQUEST['end_date']){
				$condition['time'] = array('between',strtotime($_REQUEST['start_date']).','.strtotime($_REQUEST['end_date']));	
			}else if($_REQUEST['start_date']){
				$condition['time'] = array('egt',strtotime($_REQUEST['start_date']));
			}else if($_REQUEST['end_date']){
				$condition['time'] = array('elt',strtotime($_REQUEST['end_date']));
			}*/
			
			if ($_REQUEST['start_date']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_date'].'-01').','.strtotime($_REQUEST['start_date'].'-31'));	
			}
			
			if ($_REQUEST['start_day']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_day']).','.strtotime($_REQUEST['start_day'].' 23:59:59'));	
			}
			
			if ($_REQUEST['start_date1'] && $_REQUEST['end_date1']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_date1']).','.strtotime($_REQUEST['end_date1']));	
			}else if($_REQUEST['start_date1']){
				$condition['caiwu_time'] = array('egt',strtotime($_REQUEST['start_date1']));
			}else if($_REQUEST['end_date1']){
				$condition['caiwu_time'] = array('elt',strtotime($_REQUEST['end_date1']));
			}
			
			if (!$condition['caiwu_time']){
				$year = date('Y');
            	$year = $year.'-01-01';
				$condition['caiwu_time'] = array('egt',strtotime($year));
			}
			
			$_REQUEST['department'] ? $condition['department'] = $_REQUEST['department']:'';
			$_REQUEST['user_name'] ? $condition['user_name'] = $_REQUEST['user_name']:'';
			$_REQUEST['companyname'] ? $condition['companyname'] = $_REQUEST['companyname']:'';
			
			//dump($condition);
			//$caiwu_dingdan_tongji = D('dingdan_lvxingshe_department');
			$caiwu_dingdan_tongji = D('dingdan_baozhang');
			$condition['dingdanID'] = array('neq','null');
			$condition['check_status'] = '审核通过';
			
			$condition_all['dingdanID'] = array('neq','null');
			$condition_all['check_status'] = '审核通过';
			
			import("@.ORG.Page");
			C('PAGE_NUMBERS',10);

			$count = $caiwu_dingdan_tongji->where($condition)->count();
			$shownumber = 20;
			$p= new Page($count,$shownumber);
			$page = $p->show_select();
			$this->assign('page',$page);	
			
			$i = 0;
			$dingdanPage = $caiwu_dingdan_tongji->where($condition)->limit($p->firstRow.','.$p->listRows)->findall();
			$dingdanAll = $caiwu_dingdan_tongji->where($condition)->findall();
			//$dingdanAll_nosearch = $caiwu_dingdan_tongji->where($condition_all)->findall();
			$Gltuanyuan = D("tuanyuan_dingdan");
			
			
			//统计图数据
			foreach($dingdanAll as $dingdan)
			{
				//统计图用
				$node_date = date('Y-m',$dingdan['caiwu_time']);
				$node[$node_date]++;
				
				//人数统计图
				$Gltuanyuan = D("tuanyuan_dingdan");
				$rennum = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 0")->count();
				$rennum_leader = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' and `leader` = 1")->count();
				$node_people[$node_date] += $rennum;
				$node_people_leader[$node_date] += $rennum_leader;
				//结束
				
				//钱数统计图
				$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findAll();
				$sum = 0;
				foreach($tuanyuanAll as $tuanyuan){
					$sum += $tuanyuan['jiaoqian'];
				}
				$node_money[$node_date] += $sum;
				//结束
				

				$renshu += $rennum;
				$renshu_leader += $rennum_leader;
				
/*				$v_c = $dingdan['chengrenshu'];
				$v_e = $dingdan['ertongshu'];
				
				$chengrenshu += $v_c;
				$ertongshu += $v_e;
				$renshu += $v_c + $v_e;*/
				
				/*
				$qianshu += $v_c * $dingdan['chengrenjia'] + $v_e * $dingdan['ertongjia'];*/
				
				$qianshu += $sum;
				
				$i++;
			}
			
			$j = 0;
			
			//根据分页统计订单人数和金额
			foreach($dingdanPage as $dingdan)
			{
				//统计图用
				$node_date_page = date('Y-m',$dingdan['caiwu_time']);
				$node_page[$node_date_page]++;
				
				//人数统计图
				$rennum_page = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 0")->count();
				$rennum_page_leader = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 1")->count();
				//结束
				
				//钱数统计图
				$tuanyuanAll_page = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findAll();
				$sum = 0;
				foreach($tuanyuanAll_page as $tuanyuan){
					$sum += $tuanyuan['jiaoqian'];
				}
				//结束

				$renshu_page += $rennum_page;
				$renshu_page_leader += $rennum_page_leader;
				
				$dingdanPage[$j]['xiaoshoue'] = $sum;
				$dingdanPage[$j]['renshu'] = $rennum_page;
				$dingdanPage[$j]['renshu_leader'] = $rennum_page_leader;
				$qianshu_all += $sum;
				
				$j++;
			}
			
/*			$k = 0;
			
			//不根据搜索条件统计订单人数和金额
			foreach($dingdanAll_nosearch as $dingdan)
			{
				//统计
				$node_date_nosearch = date('Y-m',$dingdan['caiwu_time']);
				$nodedingdanAll_nosearch[$node_date_nosearch]++;
				
				//人数统计
				$rennum_nosearch = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->count();
				//结束
				
				//钱数统计
				$tuanyuanAll_nosearch = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findAll();
				$sum_nosearch = 0;
				foreach($tuanyuanAll_nosearch as $tuanyuan){
					$sum_nosearch += $tuanyuan['jiaoqian'];
				}
				//结束

				$renshu_nosearch += $rennum_nosearch;
				
				$qianshu_nosearch += $sum_nosearch;
				
				$k++;
			}
			
			$this->assign('renshu_nosearch',$renshu_nosearch);
			$this->assign('qianshu_nosearch',$qianshu_nosearch);
			$this->assign('num_nosearch',$k);*/


			$dingdannum = $i + 1;
			$this->assign('chengrenshu',$chengrenshu);
			$this->assign('ertongshu',$ertongshu);
			$this->assign('renshu',$renshu);
			$this->assign('renshu_leader',$renshu_leader);
			$this->assign('yongjin',$yongjin);
			$this->assign('num',$i);
			$this->assign('qianshu',$qianshu);
			$this->assign('dingdanAll',$dingdanPage);
	
		}

		if($tuan == 'all'){
			//人数flash
/*			$strXML_people = "<graph caption='人数' xAxisName='月份' yAxisName='份额' decimalPrecision='0' formatNumberScale='0'>";
			ksort($node_people);
			foreach($node_people as $dates => $values){
				$strXML_people .= "<set name='".$dates."' value='".$values."' color='AFD8F8' />";
			}
			$strXML_people .=  "</graph>";
			$this->assign('strXML_people',$strXML_people);
			
			//钱数flash
			$strXML_money = "<graph caption='金额' xAxisName='月份' yAxisName='份额' decimalPrecision='0' formatNumberScale='0'>";
			ksort($node_money);
			foreach($node_money as $dates => $values){
				$strXML_money .= "<set name='".$dates."' value='".$values."' color='AFD8F8' />";
			}
			$strXML_money .=  "</graph>";
			$this->assign('strXML_money',$strXML_money);*/
			
			
			
			
		}
	
		//订单数
		/*$strXML = "<graph caption='订单数' xAxisName='月份' yAxisName='份额' decimalPrecision='0' formatNumberScale='0'>";
		ksort($node);
		foreach($node as $dates => $values){
			$strXML .= "<set name='".$dates."' value='".$values."' color='AFD8F8' />";
		}
		$strXML .=  "</graph>";
		$this->assign('strXML',$strXML);*/
		
		
		//人数flash
		$strXML_people = "<graph caption='参团人数' xAxisName='月份' yAxisName='份额' decimalPrecision='0' formatNumberScale='0'>";
		ksort($node_people);
		foreach($node_people as $dates => $values){
			$strXML_people .= "<set name='".$dates."' value='".$values."' hoverText='".$node_money[$dates]."' color='AFD8F8' />";
		}
		$strXML_people .=  "</graph>";
		$this->assign('strXML_people',$strXML_people);
		
		$this->assign('node',$node);
		$this->assign('node_people',$node_people);
		$this->assign('node_people_leader',$node_people_leader);
		$this->assign('node_money',$node_money);
		
		
		$this->assign('chanshu',$_GET);
		$this->assign('tuan',$tuan);
		if ($types == 'Ticket') 
			$this->display('yewutongji_air');
		elseif ($types == 'Hotel') 
			$this->display('yewutongji_hotel');
		else
			$this->display();
	}

	
	
	public function yuangongtongji() {
		foreach($_GET as $key => $value)
		{
			$this->assign($key,$value);
		}
		//默认散客
		$types = $_REQUEST['types'];
		$tuan = $_REQUEST['tuan'];
		
		if (!$types) 
			$types = 'Line';
		$this->assign('types',$types);
		
		if ($types == 'Line'){
			$navlist = "账务管理 > 业务统计 > 散客产品";
			$condition['xianlutype'] = '散客产品';
			$condition_all['xianlutype'] = '散客产品';
		}
		if ($types == 'Free'){
			$navlist = "账务管理 > 业务统计 > 自由人";
			$condition['xianlutype'] = '自由人';
			$condition_all['xianlutype'] = '自由人';
		}
		if ($types == 'baotuan'){
			$navlist = "账务管理 > 业务统计 >包团";
			$condition['xianlutype'] = '包团';
			$condition_all['xianlutype'] = '包团';
		}

		$this->assign('navlist',$navlist);
		
		$glbasedata = D('glbasedata');
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign('departmentAll',$departmentAll);
		
		$gllvxingshe = D('gllvxingshe');
		$company = $this->company;
		$companyAll = $gllvxingshe->where("`belongID` = '$company[belongID]'")->findall();
		$this->assign('companyAll',$companyAll);
		
		$glkehu = D('Glkehu');
		$kehu_all = $glkehu->findall();
		$this->assign('kehu_all',$kehu_all);

		if ($types == 'Line' || $types == 'Free' || $types == 'baotuan'){
			
			if ($_REQUEST['start_date']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_date'].'-01').','.strtotime($_REQUEST['start_date'].'-31'));	
			}
			
			if ($_REQUEST['start_day']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_day']).','.strtotime($_REQUEST['start_day'].' 23:59:59'));	
			}
			
			if ($_REQUEST['start_date1'] && $_REQUEST['end_date1']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_date1']).','.strtotime($_REQUEST['end_date1']));	
			}else if($_REQUEST['start_date1']){
				$condition['caiwu_time'] = array('egt',strtotime($_REQUEST['start_date1']));
			}else if($_REQUEST['end_date1']){
				$condition['caiwu_time'] = array('elt',strtotime($_REQUEST['end_date1']));
			}
			
			if (!$condition['caiwu_time']){
				$year = date('Y');
            	$year = $year.'-01-01';
				$condition['caiwu_time'] = array('egt',strtotime($year));
			}
			
			$_REQUEST['department'] ? $condition['department'] = $_REQUEST['department']:'';
			$_REQUEST['user_name'] ? $condition['user_name'] = $_REQUEST['user_name']:'';
			$_REQUEST['companyname'] ? $condition['companyname'] = $_REQUEST['companyname']:'';
			
			//dump($condition);
			//$caiwu_dingdan_tongji = D('dingdan_lvxingshe_department');
			$caiwu_dingdan_tongji = D('dingdan_baozhang');
			$condition['dingdanID'] = array('neq','null');
			$condition['check_status'] = '审核通过';
			
			$condition_all['dingdanID'] = array('neq','null');
			$condition_all['check_status'] = '审核通过';
			
/*			import("@.ORG.Page");
			C('PAGE_NUMBERS',10);

			$count = $caiwu_dingdan_tongji->where($condition)->count();

			$shownumber = 20;
			$p= new Page($count,$shownumber);
			$page = $p->show_select();
			$this->assign('page',$page);	*/
			
			$i = 0;
			//$dingdanPage = $caiwu_dingdan_tongji->where($condition)->limit($p->firstRow.','.$p->listRows)->findall();
			$dingdanAll = $caiwu_dingdan_tongji->where($condition)->findall();
			//$dingdanAll_nosearch = $caiwu_dingdan_tongji->where($condition_all)->findall();
			$Gltuanyuan = D("tuanyuan_dingdan");
			
			
			//统计图数据
			foreach($dingdanAll as $dingdan)
			{
				//统计图用
				$node_date = date('Y-m',$dingdan['caiwu_time']);
				$node[$node_date]++;
				
				//人数统计图
				$Gltuanyuan = D("tuanyuan_dingdan");
				$rennum = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 0")->count();
				$rennum_leader = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 1")->count();
				$node_people[$node_date] += $rennum;
				$node_people_leader[$node_date] += $rennum_leader;
				//结束
				
				//钱数统计图
				$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findAll();
				$sum = 0;
				foreach($tuanyuanAll as $tuanyuan){
					$sum += $tuanyuan['jiaoqian'];
				}
				$node_money[$node_date] += $sum;
				//结束
				

				$renshu += $rennum;
				$renshu_leader += $rennum_leader;
				
				$dingdanAll[$i]['xiaoshoue'] = $sum;
				$dingdanAll[$i]['renshu'] = $rennum;
				$dingdanAll[$i]['renshu_leader'] = $rennum_leader;
				
				$qianshu += $sum;
				
				//按人员统计
				$renyuantj[$dingdan['user_name']]['dingdan_sum']++;
				$renyuantj[$dingdan['user_name']]['renshu_sum'] += $rennum;
				$renyuantj[$dingdan['user_name']]['renshu_sum_leader'] += $rennum_leader;
				$renyuantj[$dingdan['user_name']]['jine_sum'] += $sum;
				$renyuantj[$dingdan['user_name']]['department'] = $dingdan['department'];
				
				$i++;
			}
			


			$dingdannum = $i + 1;
			$this->assign('chengrenshu',$chengrenshu);
			$this->assign('ertongshu',$ertongshu);
			$this->assign('renshu',$renshu);
			$this->assign('renshu_leader',$renshu_leader);
			$this->assign('yongjin',$yongjin);
			$this->assign('num',$i);
			$this->assign('qianshu',$qianshu);
			//$this->assign('dingdanAll',$dingdanAll);
			$this->assign('renyuantj',$renyuantj);
	
		}
		
		
		//人数flash
		ksort($node_people);
		
		$this->assign('node',$node);
		$this->assign('node_people',$node_people);
		$this->assign('node_people_leader',$node_people_leader);
		$this->assign('node_money',$node_money);
		
		
		$this->assign('chanshu',$_GET);
		$this->assign('tuan',$tuan);
		$this->display();
	}

	public function yuangongticheng() {
		foreach($_GET as $key => $value)
		{
			$this->assign($key,$value);
		}
		
		if (!$types) 
			$types = 'Line';
		$this->assign('types',$types);
		
		if ($types == 'Line'){
			$navlist = "账务管理 > 业务统计 > 散客产品";
			$condition['xianlutype'] = '散客产品';
			$condition_all['xianlutype'] = '散客产品';
		}
		if ($types == 'Free'){
			$navlist = "账务管理 > 业务统计 > 自由人";
			$condition['xianlutype'] = '自由人';
			$condition_all['xianlutype'] = '自由人';
		}
		if ($types == 'baotuan'){
			$navlist = "账务管理 > 业务统计 >包团";
			$condition['xianlutype'] = '包团';
			$condition_all['xianlutype'] = '包团';
		}

		$this->assign('navlist',$navlist);
		
		$glbasedata = D('glbasedata');
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign('departmentAll',$departmentAll);
		
		$gllvxingshe = D('gllvxingshe');
		$company = $this->company;
		$companyAll = $gllvxingshe->where("`belongID` = '$company[belongID]'")->findall();
		$this->assign('companyAll',$companyAll);
		
		$glkehu = D('Glkehu');
		$kehu_all = $glkehu->findall();
		$this->assign('kehu_all',$kehu_all);

		if ($types == 'Line' || $types == 'Free' || $types == 'baotuan'){
			
			$wheres = "WHERE 1=1";

			if ($_REQUEST['start_date']){
				$conditions['caiwu_time'] = array('between',strtotime($_REQUEST['start_date'].'-01').','.strtotime($_REQUEST['start_date'].'-31'));	
				$wheres .= " AND caiwu_time BETWEEN ".strtotime($_REQUEST['start_date'].'-01')." AND ".strtotime($_REQUEST['start_date'].'-31');
			}
			
			if ($_REQUEST['start_day']){
				$conditions['caiwu_time'] = array('between',strtotime($_REQUEST['start_day']).','.strtotime($_REQUEST['start_day'].' 23:59:59'));	
				$wheres .= " AND caiwu_time BETWEEN ".strtotime($_REQUEST['start_day'])." AND ".strtotime($_REQUEST['start_day'].' 23:59:59');
			}
			
			if ($_REQUEST['start_date1'] && $_REQUEST['end_date1']){
				$conditions['caiwu_time'] = array('between',strtotime($_REQUEST['start_date1']).','.strtotime($_REQUEST['end_date1']));
				$wheres .= " AND caiwu_time BETWEEN ".strtotime($_REQUEST['start_date1'])." AND ".strtotime($_REQUEST['end_date1']);	
			}else if($_REQUEST['start_date1']){
				$conditions['caiwu_time'] = array('egt',strtotime($_REQUEST['start_date1']));
				$wheres .= " AND caiwu_time >= '".strtotime($_REQUEST['start_date1'])."'";
			}else if($_REQUEST['end_date1']){
				$conditions['caiwu_time'] = array('elt',strtotime($_REQUEST['end_date1']));
				$wheres .= " AND caiwu_time <= '".strtotime($_REQUEST['end_date1'])."'";
			}
			
			if (!$conditions['caiwu_time']){
				$year = date('Y');
				$year = $year.'-01-01';
				$conditions['caiwu_time'] = array('egt',strtotime($year));
				$wheres .= " AND caiwu_time >= '".strtotime($year)."'";
			}
			
			
			$_REQUEST['department'] ? $conditions['departmentName'] = $_REQUEST['department']:'';
			
			$_REQUEST['departmentID'] ? $conditions['departmentID'] = $_REQUEST['departmentID']:'';
			$_REQUEST['departmentID'] ? $where['department'] = $_REQUEST['departmentID']:'';
			
			$_REQUEST['user_name'] ? $conditions['user_name'] = $_REQUEST['user_name']:'';
			$_REQUEST['user_name'] ? $where['user_name'] = $_REQUEST['user_name']:'';
			
			$_REQUEST['companyname'] ? $conditions['companyname'] = $_REQUEST['companyname']:'';
			$_REQUEST['guojing'] ? $conditions['guojing'] = $_REQUEST['guojing']:'';
			$_REQUEST['keyword'] ? $conditions['mingcheng'] = array('LIKE','%'.$_REQUEST['keyword'].'%'):'';
			
			
			$_REQUEST['departmentID'] ? $wheres .= " AND `departmentID` = ".$_REQUEST['departmentID']:'';
			$_REQUEST['user_name'] ? $wheres .= " AND `user_name` = '".$_REQUEST['user_name']."'":'';
			$_REQUEST['companyname'] ? $wheres .= " AND `companyname` = '".$_REQUEST['companyname']."'":'';
			$_REQUEST['guojing'] ? $wheres .= " AND `guojing` = '".$_REQUEST['guojing']."'":'';
			$_REQUEST['keyword'] ? $wheres .= " AND `keyword` LIKE '%".$_REQUEST['departmentID']."%'":'';
			
/*			if($_REQUEST['user_name']){
				
				$db = D("dingdan_baozhang");
				$sql1	=	"SELECT DISTINCT `zituanID`  
				FROM `dingdan_baozhang`   
				WHERE   
				`user_name` =  '".$_REQUEST['user_name']."' AND `check_status` = '审核通过'";
				$rs = $db->query($sql1);
	
				foreach($rs as $v){ $cond	.=	$v["zituanID"].",";}
				$cond	=	rtrim($cond,",");
				
				if($cond) $wheres .= " OR `zituanID` IN (".$cond.")";
			}*/
			
			
			//联合子团和地接视图
			$sql = "SELECT * from (SELECT z.zituanID,z.caiwuren,z.caiwu_time,z.xianlutype,z.tuanhao,z.mingcheng,z.chutuanriqi,z.departmentID,z.departmentName,z.user_name,z.renshu FROM zituan_baozhang z union all SELECT d.djtuanID,d.financeperson,d.caiwu_time,d.xianlutype,d.tuannumber,d.tuantitle,d.startdate,d.departmentID,d.departmentName,d.adduser,d.renshu FROM djtuan_baozhang d) AS tmp ".$wheres;
			$rs = M()->query($sql);
			
			
			$kehus = $glkehu->where($where)->findall();
			
			//计调统计
			foreach($rs as $key=>$value)
			{
				
				if($value['xianlutype'] == '地接'){
					$res[$value['user_name']][$value['zituanID']] = get_informations('user', $value, $value['zituanID'], '1',$value['user_name']);
				}else{
					$res[$value['user_name']][$value['zituanID']] = get_informations('user', $value, $value['zituanID'], 0,$value['user_name']);
				}
			}

			//门市统计
			$caiwu_dingdan_tongji = D('dingdan_baozhang');
			$condition['dingdanID'] = array('neq','null');
			$condition['check_status'] = '审核通过';
			$_REQUEST['user_name'] ? $condition['owner'] = $_REQUEST['user_name']:'';
			
			$dingdanAll = $caiwu_dingdan_tongji->where($condition)->findall();
			
			foreach($dingdanAll as $dingdan)
			{
				$res[$dingdan['owner']][$dingdan['zituanID']] = get_informations('dingdan', $res[$dingdan['owner']][$dingdan['zituanID']], $dingdan, 0, '',$res[$dingdan['owner']][$dingdan['zituanID']]['zituanID']);
			}

			
			//dump($res);
			$this->assign('tichengAll',$res);
	
		}
		
		
		$this->assign('chanshu',$_GET);
		$this->assign('tuan',$tuan);
		$this->display();
	}


	//导出散客Excel文件
	public function exports() {
		
		$types = $_REQUEST['types'];
		
		if (!$types) $types = 'Line';
		
		if ($types == 'Line' || $types == 'Free'){
				
			
			//$Gldingdan = D("dingdan_lvxingshe_department");
			$Gldingdan = D('dingdan_baozhang');
			
			if ($types == 'Line')	$condition['xianlutype'] = '散客产品';
			if ($types == 'Free')	$condition['xianlutype'] = '自由人';
			
/*			if ($_REQUEST['start_date'] && $_REQUEST['end_date']){
				$condition['time'] = array('between',strtotime($_REQUEST['start_date']).','.strtotime($_REQUEST['end_date']));	
			}else if($_REQUEST['start_date']){
				$condition['time'] = array('egt',strtotime($_REQUEST['start_date']));
			}else if($_REQUEST['end_date']){
				$condition['time'] = array('elt',strtotime($_REQUEST['start_date']));
			}*/
			
			if ($_REQUEST['start_date']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_date'].'-01').','.strtotime($_REQUEST['start_date'].'-31'));	
			}
			
			if ($_REQUEST['start_day']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_day']).','.strtotime($_REQUEST['start_day'].' 23:59:59'));	
			}
			
			if ($_REQUEST['start_date1'] && $_REQUEST['end_date1']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_date1']).','.strtotime($_REQUEST['end_date1']));	
			}else if($_REQUEST['start_date1']){
				$condition['caiwu_time'] = array('egt',strtotime($_REQUEST['start_date1']));
			}else if($_REQUEST['end_date1']){
				$condition['caiwu_time'] = array('elt',strtotime($_REQUEST['end_date1']));
			}
			
			if (!$condition['caiwu_time']){
				$year = date('Y');
            	$year = $year.'-01-01';
				$condition['caiwu_time'] = array('egt',strtotime($year));
			}
			
			
			$_REQUEST['department'] ? $condition['department'] = $_REQUEST['department']:'';
			$_REQUEST['user_name'] ? $condition['user_name'] = $_REQUEST['user_name']:'';
			$_REQUEST['companyname'] ? $condition['companyname'] = $_REQUEST['companyname']:'';
			
			//$caiwu_dingdan_tongji = D('dingdan_lvxingshe_department');
			$caiwu_dingdan_tongji = D('dingdan_baozhang');
			
			$condition['dingdanID'] = array('neq','null');
			$condition['check_status'] = '审核通过';
			
			$i = 0;
			$dingdanAll = $Gldingdan->where($condition)->order("time desc")->findall();
/*			foreach($dingdanAll as $dingdan)
			{
				$yongjin += $dingdan['yongjin'];
				$Gltuanyuan = D("tuanyuan_dingdan");
				
				$v_c = $dingdan['chengrenshu'];
				$v_e = $dingdan['ertongshu'];
				
				$chengrenshu += $v_c;
				$ertongshu += $v_e;
				$renshu += $v_c + $v_e;
				
				$qianshu += $v_c * $dingdan['chengrenjia'] + $v_e * $dingdan['ertongjia'];
				
				$i++;
			}*/
			
			foreach($dingdanAll as $dingdan)
			{
				//统计图用
				$node_date = date('Y-m',$dingdan['caiwu_time']);
				$node[$node_date]++;
				
				//人数统计图
				$Gltuanyuan = D("tuanyuan_dingdan");
				$rennum = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->count();
				$node_people[$node_date] += $rennum;
				//结束
				
				//钱数统计图
				$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findAll();
				$sum = 0;
				foreach($tuanyuanAll as $tuanyuan){
					$sum += $tuanyuan['jiaoqian'];
				}
				$node_money[$node_date] += $sum;
				//结束
				
				
				$dingdanAll[$i]['xiaoshoue'] = $sum;
				$dingdanAll[$i]['renshu'] = $rennum;

				$renshu += $rennum;
				
				$qianshu += $sum;
				
				$i++;
			}
			//分月统计
			ksort($node_people);
			$this->assign('node',$node);
			$this->assign('node_people',$node_people);
			$this->assign('node_money',$node_money);
			
			$dingdannum = $i + 1;
			
			$this->assign('renshu',$renshu);
			$this->assign('num',$i);
			$this->assign('qianshu',$qianshu);
			$this->assign('dingdanAll',$dingdanAll);
		}
		
		if ($types == 'Ticket'){
			
			$dingdan = D("Ticket_signup");
			$dingdanAll = $dingdan->relation(true)->where($condition)->order('pubdate desc')->findall();
			
			$i = 0;
			foreach($dingdanAll as $dingdan)
			{
					$renshu += $dingdan['re_num'];
					$qianshu += $dingdan['re_num'] * $dingdan['ticket_date']['price'];
					$i++;
			}
			$dingdannum = $i + 1;
			
			$this->assign('renshu',$renshu);
			$this->assign('num',$i);
			$this->assign('qianshu',$qianshu);
			$this->assign('dingdanAll',$dingdanAll);
		}
		
		if ($types == 'Hotel'){

			$dingdan = D("Signup");
			$dingdanAll = $dingdan->relation(true)->where($condition)->order('pubdate desc')->findall();
			
			$i = 0;
			foreach($dingdanAll as $dingdan)
			{
					$renshu += $dingdan['re_num'];
					$tianshu += $dingdan['stay_day'];
					$qianshu += $dingdan['re_num'] * $dingdan['hotel_date']['price'] * $dingdan['stay_day'];
					$i++;
			}
			$dingdannum = $i + 1;
			$this->assign('renshu',$renshu);
			$this->assign('tianshu',$tianshu);
			$this->assign('num',$i);
			$this->assign('qianshu',$qianshu);
			$this->assign('dingdanAll',$dingdanAll);
		}
		if ($types == 'caiwutongji'){
			//$conditions['jiedaitype'] = '接待计划';
			//$conditions['ispublished'] = '已发布';
			if ($_REQUEST['start_date']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_date'].'-01').','.strtotime($_REQUEST['start_date'].'-31'));	
			}
			
			if ($_REQUEST['start_day']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_day']).','.strtotime($_REQUEST['start_day'].' 23:59:59'));	
			}
			
			if ($_REQUEST['start_date1'] && $_REQUEST['end_date1']){
				$condition['caiwu_time'] = array('between',strtotime($_REQUEST['start_date1']).','.strtotime($_REQUEST['end_date1']));	
			}else if($_REQUEST['start_date1']){
				$condition['caiwu_time'] = array('egt',strtotime($_REQUEST['start_date1']));
			}else if($_REQUEST['end_date1']){
				$condition['caiwu_time'] = array('elt',strtotime($_REQUEST['end_date1']));
			}
			
			if (!$condition['caiwu_time']){
				$year = date('Y');
            	$year = $year.'-01-01';
				$condition['caiwu_time'] = array('egt',strtotime($year));
			}
			
			
			$_REQUEST['department'] ? $condition['department'] = $_REQUEST['department']:'';
			$_REQUEST['user_name'] ? $condition['user_name'] = $_REQUEST['user_name']:'';
			$_REQUEST['companyname'] ? $condition['companyname'] = $_REQUEST['companyname']:'';

			$Gljiedaijihua = D("Zituan_baozhang");
			
			$jiedaijihua_all = $Gljiedaijihua->where($condition)->order("chutuanriqi DESC")->select();
			
			
			$dingdan_sum = 0;
			$shouru_sum = 0;
			$zhichu_sum = 0;
			$renshu_sum = 0;
			
			//统计收入，支出
			$GLbaozhang = D("Gl_baozhang");
			$GLbaozhangitem = D("Gl_baozhangitem");
			
			foreach($jiedaijihua_all as $key=>$jiedai){
				//分月统计
				$node_date = date('Y-m',$jiedai['caiwu_time']);
				
				$baozhang = $GLbaozhang->where('`zituanID`='.$jiedai['zituanID'])->find();
				
				
				//报账人数
				$jiedaijihua_all[$key]['baozhangrenshu'] = $baozhang['renshu'];
				
				$renshu_sum += $baozhang['renshu'];
				
				$node_people[$node_date] += $baozhang['renshu'];
				
				//统计订单数
				$Gldingdan = D("dingdan_zituan");
				$jiedaijihua_all[$key]['dingdanshu'] = $Gldingdan->where('`zituanID`='.$jiedai['zituanID'])->count();
				
				$dingdan_sum += $jiedaijihua_all[$key]['dingdanshu'];
				
				$node_dingdan[$node_date] += $jiedaijihua_all[$key]['dingdanshu'];
				
				$money_all = $GLbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
				
				foreach($money_all as $money){
					if ($money['type'] == '项目') $jiedaijihua_all[$key]['xiangmu'] = $money['price'];
					if ($money['type'] == '支出项目') $jiedaijihua_all[$key]['zhichu'] = $money['price'];
					if ($money['type'] == '结算项目') $jiedaijihua_all[$key]['shouru'] = $money['price'];
				}
				
				$shouru_sum += $jiedaijihua_all[$key]['xiangmu'] + $jiedaijihua_all[$key]['shouru'];
				$zhichu_sum += $jiedaijihua_all[$key]['zhichu'];
				
				$node_yingshou[$node_date] += $jiedaijihua_all[$key]['xiangmu'] + $jiedaijihua_all[$key]['shouru'];
				$node_yingfu[$node_date] += $jiedaijihua_all[$key]['zhichu'];
				
			}
			ksort($node_people);
			$this->assign('node_people',$node_people);
			$this->assign('node_dingdan',$node_dingdan);
			$this->assign('node_yingshou',$node_yingshou);
			$this->assign('node_yingfu',$node_yingfu);
			
			$this->assign('dingdan_sum',$dingdan_sum);
			$this->assign('renshu_sum',$renshu_sum);
			$this->assign('shouru_sum',$shouru_sum);
			$this->assign('zhichu_sum',$zhichu_sum);

			$this->assign('jiedaijihua_all',$jiedaijihua_all);
		}
		
		$title = date('YmdHis');
		
		//导出Excel必备头
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=" . $title . ".xls");
		
		if ($types == 'Line' || $types == 'Free') $this->display();
		if ($types == 'Ticket') $this->display('exports_air');
		if ($types == 'Hotel') $this->display('exports_hotel');
		if ($types == 'caiwutongji') $this->display('exports_caiwutongji');
	}
	


    public function caiwulist() {

		$navlist = "财务管理 > 财务管理 > 组团财务列表";
		$this->assign('navlist',$navlist);
		
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$time1	=	"1992-01-01";
        $this->assign("departmentAll",$departmentAll);
		
		
    	$belongID = $this->company['belongID'];
        $gllvxingshe = D('gllvxingshe');
        $companyAll = $gllvxingshe->where("`belongID` = '$belongID'")->findall();
		$glkehu = D('glkehu');
        $i = 0;
        foreach($companyAll as $company){
            $systemuserAll = $glkehu->where("`lvxingsheID` = '$company[lvxingsheID]'")->findall();
        	foreach($systemuserAll as $user){
            $topsystemuserAll[$i] = $user;
            $i++;
            }
        }
        $this->assign("topsystemuserAll",$topsystemuserAll);
		
		$caiwu_zituan_info = D('caiwu_zituan_info');
		$caiwu_djtuan_info = D('caiwu_djtuan_info');
		
		$i = 0;
		foreach($departmentAll as $department){
			
			$departmentONE = $caiwu_zituan_info->where("`title` = '$department[title]'")->findall();
			//订单
			$nopay = 0;
			$payed = 0;
			foreach($departmentONE as $data){
				$tem = $data['chengrenjia'] * $data['chengrenshu'] + $data['ertongjia'] * $data['ertongshu'];
				if($data['daokuan'] == '未付款')
				{
					$countonpay += $tem;
					$nopay += $tem;
				}
				if($data['daokuan'] == '已付款')
				{
					$countpayed += $tem;
					$payed += $tem;
				}
				$countall += $tem;
			}
			
			$departmentAll[$i]['nopay'] = $nopay;
			$departmentAll[$i]['payed'] = $payed;
			
			
			//报账单
			$zituanbaozhang = $this->getbaozhangdan_zituan($department['title']);
			$departmentAll[$i]['baozhangshouru'] += $zituanbaozhang['yingshou']['totalprice'];
			$departmentAll[$i]['baozhangzhichu'] += $zituanbaozhang['yingfu']['totalprice'];
			$departmentAll[$i]['baozhangyingkui'] += $zituanbaozhang['yingshou']['totalprice'] - $zituanbaozhang['yingfu']['totalprice'];
			
			$djtuanbaozhang = $this->getbaozhangdan_djtuan($department['title']);
			$departmentAll[$i]['baozhangshouru'] += $djtuanbaozhang['yingshou']['totalprice'];
			$departmentAll[$i]['baozhangzhichu'] += $djtuanbaozhang['yingfu']['totalprice'];
			$departmentAll[$i]['baozhangyingkui'] += $djtuanbaozhang['yingshou']['totalprice'] - $djtuanbaozhang['yingfu']['totalprice'];
			
			$baozhangshouru += $departmentAll[$i]['baozhangshouru'];
			$baozhangzhichu += $departmentAll[$i]['baozhangzhichu'];
			$baozhangyingkui += $departmentAll[$i]['baozhangyingkui'];
			
			$i++;
		}
		
		
		$this->assign('countall',$countall);
		$this->assign('countonpay',$countonpay);
		$this->assign('countpayed',$countpayed);
		$this->assign('baozhangshouru',$baozhangshouru);
		$this->assign('baozhangzhichu',$baozhangzhichu);
		$this->assign('baozhangyingkui',$baozhangyingkui);
		$this->assign('departmentAll',$departmentAll);
		
		
		$this->display();
		
    }


	public function getbaozhangdan_zituan($title,$zituanID)
	{
		if($title){
			$caiwu_zituan_info = D('caiwu_zituan_info');
			$zituanAll = $caiwu_zituan_info->Distinct(true)->field('zituanID')->where("`title` = '$title'")->select();
		}
		if($zituanID){
			$caiwu_zituan_info = D('caiwu_zituan_info');
			$zituanAll = $caiwu_zituan_info->Distinct(true)->field('zituanID')->where("`zituanID` = '$zituanID'")->select();
		}
		$GLbaozhang = D('Gl_baozhang');
		$GLbaozhangitem = D('gl_baozhangitem');
		foreach($zituanAll as $tuan){
			$baozhang = $GLbaozhang->where("`zituanID` = '$tuan[zituanID]'")->find();
			$itemNed['baozhang'] = $baozhang;
			$itemAll = $GLbaozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and `check_status` = '审核通过'")->findall();
//			foreach($itemAll as $tema){
//				if($tema['type'] == '结算项目') { 
//				$totalprice += $tema['price'];
//				}
//			}
			foreach($itemAll as $tema){
				if($tema['type'] == '结算项目') { 
				$itemNed['yingshou']['totalprice'] += $tema['price'];
				}
				if($tema['type'] == '支出项目') { 
				$itemNed['yingfu']['totalprice'] += $tema['price'];
				}
			}
		}
		
		return $itemNed;
			
	}


	public function getbaozhangdan_djtuan($title,$djtuanID)
	{
		$caiwu_djtuan_info = D('caiwu_djtuan_info');
		
		if($title){
		$djtuanAll = $caiwu_djtuan_info->Distinct(true)->field('djtuanID')->where("`title` = '$title'")->select();
		}
		if($djtuanID){
		$djtuanAll = $caiwu_djtuan_info->where("`djtuanID` = '$djtuanID'")->select();
		}
		
		$DJbaozhang = D('dj_baozhang');
		$DJbaozhangitem = D('dj_baozhangitem');
		foreach($djtuanAll as $tuan){
			if($tuan['baozhangID'])
			$baozhang = $DJbaozhang->where("`djtuanID` = '$tuan[djtuanID]'")->find();
			$itemAll = $DJbaozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and `check_status` = '审核通过'")->findall();
			foreach($itemAll as $item){
				if($item['type'] == '结算项目'){
					$jisuanheji_p += $item['price'];
				}
				if($item['type'] == '支出项目'){
					$zhichuheji_p += $item['price'];
				}
			}
		}
		$itemNed['yingshou']['totalprice'] = $jisuanheji_p;
		$itemNed['yingfu']['totalprice'] = $zhichuheji_p;
		return $itemNed;
		
	}

	
    public function editdepartment() {
		
		
		$glbasedata = D('glbasedata');
		$glbasedata->save($_POST);
		
		echo true;
	}
	
	
    public function index() {
		$navlist = "财务导航页";
		$this->assign('navlist',$navlist);
		
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
        $this->assign("departmentAll",$departmentAll);
		
		
    	$belongID = $this->company['belongID'];
        $gllvxingshe = D('gllvxingshe');
        $companyAll = $gllvxingshe->where("`belongID` = '$belongID'")->findall();
		$glkehu = D('glkehu');
        $i = 0;
        foreach($companyAll as $company){
            $systemuserAll = $glkehu->where("`lvxingsheID` = '$company[lvxingsheID]'")->findall();
        	foreach($systemuserAll as $user){
            $topsystemuserAll[$i] = $user;
            $i++;
            }
        }
        $this->assign("topsystemuserAll",$topsystemuserAll);
		
        $this->display();
    }
	

    public function departmentdetail() {
		
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
        $this->assign("departmentAll",$departmentAll);
		
		
    	$belongID = $this->company['belongID'];
        $gllvxingshe = D('gllvxingshe');
        $companyAll = $gllvxingshe->where("`belongID` = '$belongID'")->findall();
		$glkehu = D('glkehu');
        $i = 0;
        foreach($companyAll as $company){
            $systemuserAll = $glkehu->where("`lvxingsheID` = '$company[lvxingsheID]'")->findall();
        	foreach($systemuserAll as $user){
            $topsystemuserAll[$i] = $user;
            $i++;
            }
        }
        $this->assign("topsystemuserAll",$topsystemuserAll);
		
		//子团
		$glbasedata = D('glbasedata');
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
				continue;
			if($key == 'time1' || $key == 'time2')
			{
				$this->assign($key,$value);
				continue;
			}
			if($key == 'departmentID')
			{
				$conditions[$key] = $value;
				$department = $glbasedata->where("`id` = $value")->find();
				$this->assign('departmentID',$value);
				$this->assign('department',$department['title']);
				continue;
			}
			
			if($key == 'xianlutype')
			{
				if($value == '地接')
				{
					$djmark = 1;
				}
				else
				{
					$conditions[$key] = $value;
				}
				$this->assign($key,$value);
				continue;
			}
			if($key == 'page_listrowss'){ continue;}
			
			$conditions[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		$start =date( "Y-m",strtotime($_GET['time1'])); 
		$end =date( "Y-m",strtotime($_GET['time2'])); 
		if($_GET['time1'] && $_GET['time2'])	
			$conditions['chutuanriqi'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$conditions['chutuanriqi'] = array('egt',$start);
		elseif($_GET['time2'])
			$conditions['chutuanriqi'] = array('elt',$start);
		
		//dump($conditions);
		
		$glkehu = D('glkehu');
		$caiwu_zituan_info = D('caiwu_zituan_info');
		$caiwu_djtuan_info = D('caiwu_djtuan_info');
		import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		if($djmark)
			$countzituan = 0;
		else
			$countzituan = count($caiwu_zituan_info->where($conditions)->Distinct(true)->field('zituanID')->select());
		$countdjtuan = $caiwu_djtuan_info->where($conditions)->count();
		$count = $countzituan + $countdjtuan;
		$shownumber = 20;
		$p= new Page($count,$shownumber);
		$rurl = SITE_ADMIN."Caiwuguanli/departmentdetail/".$urlitem."/p/";
		$page = $p->show_select($rurl);
		$this->assign('page',$page);
		
		//dump($conditions);
		
		if($countzituan > $p->firstRow){
			$zituanAll = $caiwu_zituan_info->where($conditions)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->Distinct(true)->field('zituanID')->select();
			$i=0;
			foreach($zituanAll as $zituan)
			{
				//获取子团内容和订单内容
				if($department['title'])
				$dingdanAll = $caiwu_zituan_info->where("`title` = '$department[title]' and `zituanID` = '$zituan[zituanID]'")->select();
				else
				$dingdanAll = $caiwu_zituan_info->where("`zituanID` = '$zituan[zituanID]'")->select();
				
				$zituanAll[$i] = $dingdanAll[0];
				//$zituanAll[$i]['tuantype'] = '组团';
				$user_name = $dingdanAll[0]['zituanadduser'];
				$kehu = $glkehu->where("`user_name` = '$user_name'")->find();
				$zituanAll[$i]['zituanrealname'] = $kehu['realname'];
				
				$nopay = 0;
				$payed = 0;
				foreach($dingdanAll as $data){
					
					if($data['check_status'] != '审核通过')
						continue;
					
					//人数修正 by heavenK
					$Gltuanyuan = D("tuanyuan_dingdan");
					$rennum = $Gltuanyuan->where("`dingdanID` = '$data[dingdanID]'")->count();
					$zituanAll[$i]['renshu'] += $rennum;
					//结束	
					
					//订单价格修正 by heavenK 靠，都他妈三层循环了！
					$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$data[dingdanID]'")->findAll();
					$sum = 0;
					foreach($tuanyuanAll as $tuanyuan){
						$sum += $tuanyuan['jiaoqian'];
					}
					$tem = $sum;
					//结束
					
					//$tem = $data['chengrenjia'] * $data['chengrenshu'] + $data['ertongjia'] * $data['ertongshu'];
					if($data['daokuan'] == '未付款')
					{
						$countonpay += $tem;
						$nopay += $tem;
					}
					if($data['daokuan'] == '已付款')
					{
						$countpayed += $tem;
						$payed += $tem;
					}
					$countall += $tem;
					//人数
					//$zituanAll[$i]['renshu'] += $data['chengrenshu'] + $data['ertongshu'];
				}
				$zituanAll[$i]['nopay'] = $nopay;
				$zituanAll[$i]['payed'] = $payed;
				//报账单
				$zituanbaozhang = $this->getbaozhangdan_zituan('',$zituan['zituanID']);
				$zituanAll[$i]['baozhangshouru'] = $zituanbaozhang['yingshou']['totalprice'] + $zituanbaozhang['qita']['totalprice'];
				$zituanAll[$i]['baozhangzhichu'] = $zituanbaozhang['yingfu']['totalprice'];
				$zituanAll[$i]['baozhangyingkui'] = $zituanbaozhang['yingshou']['totalprice'] + $zituanbaozhang['qita']['totalprice'] - $zituanbaozhang['yingfu']['totalprice'];
				$baozhangshouru += $zituanAll[$i]['baozhangshouru'];
				$baozhangzhichu += $zituanAll[$i]['baozhangzhichu'];
				$baozhangyingkui += $zituanAll[$i]['baozhangyingkui'];
				
				$i++;
			}
			$this->assign('countall',$countall);
			$this->assign('countonpay',$countonpay);
			$this->assign('countpayed',$countpayed);
		}
		
		//dump($countzituan);
		
		if($countzituan < ($p->firstRow + $p->listRows))
		{
			
			
			$num = $countzituan % $shownumber;
			$t1 = $shownumber - $num;
			
			if(($p->firstRow - $countzituan) <= 0 ){
				$p->firstRow = 0;
				$p->listRows = $t1;
			}
			else{
				$t22 = ($p->firstRow - $countzituan) / $shownumber;
				if($num == 0)
				$p->firstRow = $t1 + $shownumber * ((int)$t22 - 1);
				else
				$p->firstRow = $t1 + $shownumber * (int)$t22;
			}
			
			//地接团
			$djtuanAll = $caiwu_djtuan_info->where($conditions)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->select();
			
			foreach($djtuanAll as $tuan)
			{
				$tuan['xianlutype'] = '地接';
				$zituanAll[$i] = $tuan;
				//报账单
				$djtuanbaozhang = $this->getbaozhangdan_djtuan('',$tuan['djtuanID']);
				$zituanAll[$i]['baozhangshouru'] = $djtuanbaozhang['yingshou']['totalprice'] + $djtuanbaozhang['qita']['totalprice'];
				$zituanAll[$i]['baozhangzhichu'] = $djtuanbaozhang['yingfu']['totalprice'];
				$zituanAll[$i]['baozhangyingkui'] = $djtuanbaozhang['yingshou']['totalprice'] + $djtuanbaozhang['qita']['totalprice'] - $djtuanbaozhang['yingfu']['totalprice'];
				$baozhangshouru += $zituanAll[$i]['baozhangshouru'];
				$baozhangzhichu += $zituanAll[$i]['baozhangzhichu'];
				$baozhangyingkui += $zituanAll[$i]['baozhangyingkui'];
				
				$i++;
			}
		}
		$this->assign('zituanAll',$zituanAll);
		$this->assign('baozhangshouru',$baozhangshouru);
		$this->assign('baozhangzhichu',$baozhangzhichu);
		$this->assign('baozhangyingkui',$baozhangyingkui);
		
		$this->display();
	}
	


    public function baozhangdanlist() 
	{
		
		foreach($_GET as $key => $value)
		{
			if($key == 'time1' || $key == 'time2' || $key == 'p')
			{
				$this->assign($key,$value);
				continue;
			}
			if($key == 'departmentID')
			{
				$conditions[$key] = $value;
				$glbasedata = D("glbasedata");
				$department = $glbasedata->where("`id` = $value")->find();
				$this->assign('departmentID',$value);
				$this->assign('department',$department['title']);
				continue;
			}
			
			if($key == 'xianlutype')
			{
				if($value == '地接')
					$djmark = 1;
				else
					$conditions[$key] = $value;
				$this->assign($key,$value);
				continue;
			}
			if($key == 'page_listrowss'){ continue;}
			
			$conditions[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		
		$glkehu = D('glkehu');
		$caiwu_zituan_info = D('caiwu_zituan_info');
		$caiwu_djtuan_info = D('caiwu_djtuan_info');
		import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		if($djmark)
			$countzituan = 0;
		else
			$countzituan = count($caiwu_zituan_info->where($conditions)->Distinct(true)->field('zituanID')->select());
		$countdjtuan = $caiwu_djtuan_info->where($conditions)->count();
		$count = $countzituan + $countdjtuan;
		$shownumber = 20;
		$p= new Page($count,$shownumber);
		$page = $p->show_select();
		$this->assign('page',$page);
		
		if($countzituan > $p->firstRow){
			$zituanAll = $caiwu_zituan_info->where($conditions)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->Distinct(true)->field('zituanID')->select();
			$i=0;
			foreach($zituanAll as $zituan)
			{
				if($department['title'])
				$dingdanAll = $caiwu_zituan_info->where("`title` = '$department[title]' and `zituanID` = '$zituan[zituanID]'")->select();
				else
				$dingdanAll = $caiwu_zituan_info->where("`zituanID` = '$zituan[zituanID]'")->select();
				$zituanAll[$i] = $dingdanAll[0];
				//$zituanAll[$i]['tuantype'] = '组团';
				$user_name = $dingdanAll[0]['zituanadduser'];
				$kehu = $glkehu->where("`user_name` = '$user_name'")->find();
				$zituanAll[$i]['zituanrealname'] = $kehu['realname'];
				
				$nopay = 0;
				$payed = 0;
				foreach($dingdanAll as $data){
					$tem = $data['chengrenjia'] * $data['chengrenshu'] + $data['ertongjia'] * $data['ertongshu'];
					if($data['daokuan'] == '未付款')
					{
						$countonpay += $tem;
						$nopay += $tem;
					}
					if($data['daokuan'] == '已付款')
					{
						$countpayed += $tem;
						$payed += $tem;
					}
					$countall += $tem;
					//人数
					$zituanAll[$i]['renshu'] += $data['chengrenshu'] + $data['ertongshu'];
				}
				$zituanAll[$i]['nopay'] = $nopay;
				$zituanAll[$i]['payed'] = $payed;
				//报账单
				$zituanbaozhang = $this->getbaozhangdan_zituan('',$zituan['zituanID']);
				$zituanAll[$i]['baozhangshouru'] = $zituanbaozhang['yingshou']['totalprice'] + $zituanbaozhang['qita']['totalprice'];
				$zituanAll[$i]['baozhangzhichu'] = $zituanbaozhang['yingfu']['totalprice'];
				$zituanAll[$i]['baozhangyingkui'] = $zituanbaozhang['yingshou']['totalprice'] + $zituanbaozhang['qita']['totalprice'] - $zituanbaozhang['yingfu']['totalprice'];
				$baozhangshouru += $zituanAll[$i]['baozhangshouru'];
				$baozhangzhichu += $zituanAll[$i]['baozhangzhichu'];
				$baozhangyingkui += $zituanAll[$i]['baozhangyingkui'];
				dump($zituanbaozhang);
				$i++;
			}
			$this->assign('countall',$countall);
			$this->assign('countonpay',$countonpay);
			$this->assign('countpayed',$countpayed);
		}
		if($countzituan < ($p->firstRow + $p->listRows))
		{
			
			
			$num = $countzituan % $shownumber;
			$t1 = $shownumber - $num;
			
			if(($p->firstRow - $countzituan) <= 0 ){
				$p->firstRow = 0;
				$p->listRows = $t1;
			}
			else{
				$t22 = ($p->firstRow - $countzituan) / $shownumber;
				if($num == 0)
				$p->firstRow = $t1 + $shownumber * ((int)$t22 - 1);
				else
				$p->firstRow = $t1 + $shownumber * (int)$t22;
			}
			
			//地接团
			$djtuanAll = $caiwu_djtuan_info->where($conditions)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->select();
			
			foreach($djtuanAll as $tuan)
			{
				$tuan['xianlutype'] = '地接';
				$zituanAll[$i] = $tuan;
				//报账单
				$djtuanbaozhang = $this->getbaozhangdan_djtuan('',$tuan['djtuanID']);
				$zituanAll[$i]['baozhangshouru'] = $djtuanbaozhang['yingshou']['totalprice'] + $djtuanbaozhang['qita']['totalprice'];
				$zituanAll[$i]['baozhangzhichu'] = $djtuanbaozhang['yingfu']['totalprice'];
				$zituanAll[$i]['baozhangyingkui'] = $djtuanbaozhang['yingshou']['totalprice'] + $djtuanbaozhang['qita']['totalprice'] - $djtuanbaozhang['yingfu']['totalprice'];
				$baozhangshouru += $zituanAll[$i]['baozhangshouru'];
				$baozhangzhichu += $zituanAll[$i]['baozhangzhichu'];
				$baozhangyingkui += $zituanAll[$i]['baozhangyingkui'];
				
				$i++;
			}
		}
		$this->assign('zituanAll',$zituanAll);
		$this->assign('baozhangshouru',$baozhangshouru);
		$this->assign('baozhangzhichu',$baozhangzhichu);
		$this->assign('baozhangyingkui',$baozhangyingkui);
		
		$this->display('departmentdetail');
		
	}




	//财务收支管理
    public function shouzhilist() {
	
		//先找到收支的ITEM项		
		$db = D("gl_baozhang");
		$db2 = D("dj_baozhang");
		
		//原来的
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
        $this->assign("departmentAll",$departmentAll);
		
		
    	$belongID = $this->company['belongID'];
        $gllvxingshe = D('gllvxingshe');
        $companyAll = $gllvxingshe->where("`belongID` = '$belongID'")->findall();
		$glkehu = D('glkehu');
        $i = 0;
        foreach($companyAll as $company){
            $systemuserAll = $glkehu->where("`lvxingsheID` = '$company[lvxingsheID]'")->findall();
        	foreach($systemuserAll as $user){
            $topsystemuserAll[$i] = $user;
            $i++;
            }
        }
        $this->assign("topsystemuserAll",$topsystemuserAll);
		
		//子团
		$glbasedata = D('glbasedata');
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key=='shouzhizhuangtai')
				continue;
			if($key == 'time1' || $key == 'time2')
			{
				$this->assign($key,$value);
				continue;
			}
			if($key == 'departmentID')
			{
				$conditions[$key] = $value;
				$department = $glbasedata->where("`id` = $value")->find();
				$this->assign('departmentID',$value);
				$this->assign('department',$department['title']);
				continue;
			}
			
			if($key == 'xianlutype')
			{
				if($value == '地接')
				{
					$djmark = 1;
				}
				else
				{
					$conditions[$key] = $value;
				}
				$this->assign($key,$value);
				continue;
			}
			if($key == 'page_listrowss'){ continue;}
			
			$conditions[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		$start =date( "Y-m",strtotime($_GET['time1'])); 
		$end =date( "Y-m",strtotime($_GET['time2'])); 
		if($_GET['time1'] && $_GET['time2'])	
			$conditions['chutuanriqi'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$conditions['chutuanriqi'] = array('egt',$start);
		elseif($_GET['time2'])
			$conditions['chutuanriqi'] = array('elt',$start);
		
		//dump($conditions);
		
		$glkehu = D('glkehu');
		$caiwu_zituan_info = D('caiwu_zituan_info');
		$caiwu_djtuan_info = D('caiwu_djtuan_info');
		import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		if($djmark){
			$countzituan = 0;
		}else{
			//修改介入 gaoyang
			//$conditions
			if(isset($_GET["shouzhizhuangtai"])){
				$shouzhizhuangtai=$_GET["shouzhizhuangtai"];
				if($shouzhizhuangtai=="经理确认"){
					$shouzhizhuangtai	=	$shouzhizhuangtai."' or `check_status`='审核通过'";
				}
			}else{
				$shouzhizhuangtai="等待审核'";
			}//确定要查的收支状态
//			$sql1	=	"SELECT DISTINCT `zituanID` FROM `gl_baozhang`,`gl_baozhangitem`  WHERE  (`gl_baozhangitem`.`check_status`='".$shouzhizhuangtai." ) AND `gl_baozhang`.`status` = '计调申请' AND `gl_baozhang`.`baozhangID`=`gl_baozhangitem`.`baozhangID`";	//找到'等待审核'状态的组团子团ID
			$sql1	=	"SELECT DISTINCT `zituanID` FROM `gl_baozhang`,`gl_baozhangitem`  WHERE  (`gl_baozhangitem`.`check_status`='".$shouzhizhuangtai." ) AND `gl_baozhang`.`baozhangID`=`gl_baozhangitem`.`baozhangID`";	//找到'等待审核'状态的组团子团ID
			$rs = $db->query($sql1);
			//dump($sql1);
			foreach($rs as $v){ $cond	.=	$v["zituanID"].",";}
			$cond	=	rtrim($cond,",");
			$conditions['zituanID'] = array('IN',$cond);
			//$conditions['status'] = "计调申请";
			//dump($conditions);
			//修改结束 gaoyang
			$countzituan = count($caiwu_zituan_info->where($conditions)->Distinct(true)->field('zituanID')->select());
		}
		//地接情况
		//修改介入 gaoyang
		//$conditions
		if(isset($_GET["shouzhizhuangtai"])){
				$shouzhizhuangtai=$_GET["shouzhizhuangtai"];
				if($shouzhizhuangtai=="经理确认"){
					$shouzhizhuangtai	=	$shouzhizhuangtai."' or `check_status`='审核通过'";
				}
			}else{
				$shouzhizhuangtai="等待审核'";
			}//确定要查的收支状态
//		$sql2	=	"SELECT DISTINCT `djtuanID` 
//		FROM `dj_baozhang`,`dj_baozhangitem`  
//		WHERE  (`dj_baozhangitem`.`check_status`='".$shouzhizhuangtai." ) 
//		AND  `dj_baozhang`.`status` = '计调申请' 
//		AND  `dj_baozhang`.`baozhangID`=`dj_baozhangitem`.`baozhangID` ";//找到'等待审核'状态的地接子团ID
		$sql2	=	"SELECT DISTINCT `djtuanID` 
		FROM `dj_baozhang`,`dj_baozhangitem`  
		WHERE  (`dj_baozhangitem`.`check_status`='".$shouzhizhuangtai." ) 
		AND  `dj_baozhang`.`baozhangID`=`dj_baozhangitem`.`baozhangID` ";//找到'等待审核'状态的地接子团ID
		$rs2 = $db2->query($sql2);
		//echo $sql2;
		//dump($rs2);echo "caonima";
		foreach($rs2 as $v2){ $cond2	.=	$v2["djtuanID"].",";}
		$cond2	=	rtrim($cond2,",");
		$conditions2	=$conditions;
		unset($conditions2['zituanID']);	//去掉组团的条件
		$conditions2['djtuanID'] = array('IN',$cond2);
		//dump($conditions2);
		//修改结束 gaoyang
		$countdjtuan = $caiwu_djtuan_info->where($conditions2)->count();
		//dump($caiwu_djtuan_info);
		$count = $countzituan + $countdjtuan;
		$shownumber = 20;
		$p= new Page($count,$shownumber);
		$rurl = SITE_ADMIN."Caiwuguanli/departmentdetail/".$urlitem."/p/";
		$page = $p->show_select($rurl);
		$this->assign('page',$page);
		
		
		
		//判断组团还是地接 by gaoyang
		if($countzituan > $p->firstRow){			
			$zituanAll = $caiwu_zituan_info->where($conditions)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->Distinct(true)->field('zituanID')->select();
			$i=0;
			foreach($zituanAll as $zituan)
			{
				//获取子团内容和订单内容
				if($department['title'])
				$dingdanAll = $caiwu_zituan_info->where("`title` = '$department[title]' and `zituanID` = '$zituan[zituanID]'")->select();
				else
				$dingdanAll = $caiwu_zituan_info->where("`zituanID` = '$zituan[zituanID]'")->select();
				
				$zituanAll[$i] = $dingdanAll[0];
				//$zituanAll[$i]['tuantype'] = '组团';
				$user_name = $dingdanAll[0]['zituanadduser'];
				$kehu = $glkehu->where("`user_name` = '$user_name'")->find();
				$zituanAll[$i]['zituanrealname'] = $kehu['realname'];
				
				$nopay = 0;
				$payed = 0;
				foreach($dingdanAll as $data){
					
					if($data['check_status'] != '审核通过')
						continue;
						
					//人数修正 by heavenK
					$Gltuanyuan = D("tuanyuan_dingdan");
					$rennum = $Gltuanyuan->where("`dingdanID` = '$data[dingdanID]'")->count();
					$zituanAll[$i]['renshu'] += $rennum;
					//结束
					
						
					//订单价格修正 by heavenK 靠，都他妈三层循环了！
					$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$data[dingdanID]'")->findAll();
					$sum = 0;
					foreach($tuanyuanAll as $tuanyuan){
						$sum += $tuanyuan['jiaoqian'];
					}
					$tem = $sum;
					//结束
					
					//$tem = $data['chengrenjia'] * $data['chengrenshu'] + $data['ertongjia'] * $data['ertongshu'];
					if($data['daokuan'] == '未付款')
					{
						$countonpay += $tem;
						$nopay += $tem;
					}
					if($data['daokuan'] == '已付款')
					{
						$countpayed += $tem;
						$payed += $tem;
					}
					$countall += $tem;
					//人数
					//$zituanAll[$i]['renshu'] += $data['chengrenshu'] + $data['ertongshu'];
					
				}
				$zituanAll[$i]['nopay'] = $nopay;
				$zituanAll[$i]['payed'] = $payed;
				//报账单
				$zituanbaozhang = $this->getbaozhangdan_zituan('',$zituan['zituanID']);
				$zituanAll[$i]['baozhangshouru'] = $zituanbaozhang['yingshou']['totalprice'] + $zituanbaozhang['qita']['totalprice'];
				$zituanAll[$i]['baozhangzhichu'] = $zituanbaozhang['yingfu']['totalprice'];
				$zituanAll[$i]['baozhangyingkui'] = $zituanbaozhang['yingshou']['totalprice'] + $zituanbaozhang['qita']['totalprice'] - $zituanbaozhang['yingfu']['totalprice'];
				$baozhangshouru += $zituanAll[$i]['baozhangshouru'];
				$baozhangzhichu += $zituanAll[$i]['baozhangzhichu'];
				$baozhangyingkui += $zituanAll[$i]['baozhangyingkui'];
				
				$i++;
			}
			$this->assign('countall',$countall);
			$this->assign('countonpay',$countonpay);
			$this->assign('countpayed',$countpayed);
		}
		
		//dump($countzituan);
		
		//判断地接
		if($countzituan < ($p->firstRow + $p->listRows))
		{
			$num = $countzituan % $shownumber;
			$t1 = $shownumber - $num;
			
			if(($p->firstRow - $countzituan) <= 0 ){
				$p->firstRow = 0;
				$p->listRows = $t1;
			}
			else{
				$t22 = ($p->firstRow - $countzituan) / $shownumber;
				if($num == 0)
				$p->firstRow = $t1 + $shownumber * ((int)$t22 - 1);
				else
				$p->firstRow = $t1 + $shownumber * (int)$t22;
			}
			
			//地接团
			$djtuanAll = $caiwu_djtuan_info->where($conditions2)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->select();
			
			foreach($djtuanAll as $tuan)
			{
				$tuan['xianlutype'] = '地接';
				$zituanAll[$i] = $tuan;
				//报账单
				$djtuanbaozhang = $this->getbaozhangdan_djtuan('',$tuan['djtuanID']);
				$zituanAll[$i]['baozhangshouru'] = $djtuanbaozhang['yingshou']['totalprice'] + $djtuanbaozhang['qita']['totalprice'];
				$zituanAll[$i]['baozhangzhichu'] = $djtuanbaozhang['yingfu']['totalprice'];
				$zituanAll[$i]['baozhangyingkui'] = $djtuanbaozhang['yingshou']['totalprice'] + $djtuanbaozhang['qita']['totalprice'] - $djtuanbaozhang['yingfu']['totalprice'];
				$baozhangshouru += $zituanAll[$i]['baozhangshouru'];
				$baozhangzhichu += $zituanAll[$i]['baozhangzhichu'];
				$baozhangyingkui += $zituanAll[$i]['baozhangyingkui'];
				
				$i++;
			}
		}
		$this->assign('zituanAll',$zituanAll);
		$this->assign('baozhangshouru',$baozhangshouru);
		$this->assign('baozhangzhichu',$baozhangzhichu);
		$this->assign('baozhangyingkui',$baozhangyingkui);
		
		$this->display();
		
		
    }








	//报账单管理---财务
    public function baozhangdan_guanli() {
	
		//先找到收支的ITEM项		
		$db = D("gl_baozhang");
		
		//原来的
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
        $this->assign("departmentAll",$departmentAll);
		
		
    	$belongID = $this->company['belongID'];
        $gllvxingshe = D('gllvxingshe');
        $companyAll = $gllvxingshe->where("`belongID` = '$belongID'")->findall();
		$glkehu = D('glkehu');
        $i = 0;
        foreach($companyAll as $company){
            $systemuserAll = $glkehu->where("`lvxingsheID` = '$company[lvxingsheID]'")->findall();
        	foreach($systemuserAll as $user){
            $topsystemuserAll[$i] = $user;
            $i++;
            }
        }
        $this->assign("topsystemuserAll",$topsystemuserAll);
		
		//子团
		$glbasedata = D('glbasedata');
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key=='shouzhizhuangtai' || $key=='baozhangzhuangtai')
				continue;
			if($key == 'time1' || $key == 'time2')
			{
				$this->assign($key,$value);
				continue;
			}
			if($key == 'departmentID')
			{
				$conditions[$key] = $value;
				$department = $glbasedata->where("`id` = $value")->find();
				$this->assign('departmentID',$value);
				$this->assign('department',$department['title']);
				continue;
			}
			
			if($key == 'xianlutype')
			{
				if($value == '地接')
				{
					$djmark = 1;
				}
				else
				{
					$conditions[$key] = $value;
				}
				$this->assign($key,$value);
				continue;
			}
			if($key == 'page_listrowss'){ continue;}
			
			$conditions[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		$start =date( "Y-m",strtotime($_GET['time1'])); 
		$end =date( "Y-m",strtotime($_GET['time2'])); 
		if($_GET['time1'] && $_GET['time2'])	
			$conditions['chutuanriqi'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$conditions['chutuanriqi'] = array('egt',$start);
		elseif($_GET['time2'])
			$conditions['chutuanriqi'] = array('elt',$start);
		
		//dump($conditions);
		
		$glkehu = D('glkehu');
		$caiwu_zituan_info = D('caiwu_zituan_info');
		$caiwu_djtuan_info = D('caiwu_djtuan_info');
		import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		if($djmark){
			$countzituan = 0;
		}else{
			//修改更新 heavenK
			//$conditions
			if(isset($_GET["baozhangzhuangtai"])){
				if($_GET["baozhangzhuangtai"] == '财务已处理' || $_GET["baozhangzhuangtai"] == '总经理已处理'){
					if(checkByAdminlevel('财务操作员',$this)) $_GET["baozhangzhuangtai"] = '财务已处理';
					elseif(checkByAdminlevel('财务总监',$this)) $_GET["baozhangzhuangtai"] = '财务总监已处理';
					elseif(checkByAdminlevel('总经理',$this)) $_GET["baozhangzhuangtai"] = '总经理已处理';
				}
				else{
					if(checkByAdminlevel('财务操作员',$this)) $_GET["baozhangzhuangtai"] = '财务待处理';
					elseif(checkByAdminlevel('财务总监',$this)) $_GET["baozhangzhuangtai"] = '财务总监待处理';
					elseif(checkByAdminlevel('总经理',$this)) $_GET["baozhangzhuangtai"] = '总经理待处理';
				}
			}else{
					if(checkByAdminlevel('财务操作员',$this)) $_GET["baozhangzhuangtai"] = '财务待处理';
					elseif(checkByAdminlevel('财务总监',$this)) $_GET["baozhangzhuangtai"] = '财务总监待处理';
					elseif(checkByAdminlevel('总经理',$this)) $_GET["baozhangzhuangtai"] = '总经理待处理';
			}
			//结束修改
			
			//修改介入 gaoyang
			//$conditions
			if(isset($_GET["baozhangzhuangtai"])){
				$baozhangzhuangtai =	 $_GET["baozhangzhuangtai"];	
				if($baozhangzhuangtai=="财务待处理"){
					$baozhangzhuangtai	=	"'经理通过' OR `status`='总经理不通过'";					
				}	
				if($baozhangzhuangtai=="财务已处理"){
					$baozhangzhuangtai	=	"'财务通过' OR `status`='财务不通过'";					
				}
				if($baozhangzhuangtai=="财务总监待处理"){
					$baozhangzhuangtai	=	"'财务通过'";					
				}	
				if($baozhangzhuangtai=="财务总监已处理"){
					$baozhangzhuangtai	=	"'财务总监通过' OR `status`='财务总监不通过'";					
				}
				if($baozhangzhuangtai=="总经理待处理"){
					$baozhangzhuangtai	=	"'财务总监通过'";					
				}
				if($baozhangzhuangtai=="总经理已处理"){
					$baozhangzhuangtai	=	"'总经理通过'";					
				}		
			}else{
					$baozhangzhuangtai="'经理通过' OR `status`='总经理不通过'";
					
			}//确定要查的收支状态

			if(checkByAdminlevel('网管',$this)) $baozhangzhuangtai="'经理通过' OR `status` <> '经理通过'";

			//dump($baozhangzhuangtai);
			$sql1	=	"SELECT DISTINCT `zituanID`  
			FROM `gl_baozhang`   
			WHERE   
			`gl_baozhang`.`status` =  ".$baozhangzhuangtai;	//找到‘经理通过’的报账单的子团ID
			$rs = $db->query($sql1);
			//dump($rs);
			foreach($rs as $v){ $cond	.=	$v["zituanID"].",";}
			$cond	=	rtrim($cond,",");
			$conditions['zituanID'] = array('IN',$cond);
			//$conditions['status'] = "计调申请";
			//dump($conditions);
			//修改结束 gaoyang
			$countzituan = count($caiwu_zituan_info->where($conditions)->Distinct(true)->field('zituanID')->select());
		}
		//地接情况
		//修改介入 gaoyang
		//$conditions
		if(isset($_GET["baozhangzhuangtai"])){
				$baozhangzhuangtai =	 $_GET["baozhangzhuangtai"];	
				if($baozhangzhuangtai=="财务待处理"){
					$baozhangzhuangtai	=	"'经理通过' OR `status`='总经理不通过'";					
				}	
				if($baozhangzhuangtai=="财务已处理"){
					$baozhangzhuangtai	=	"'财务通过' OR `status`='财务不通过'";					
				}

				if($baozhangzhuangtai=="财务总监待处理"){
					$baozhangzhuangtai	=	"'财务通过'";					
				}	
				if($baozhangzhuangtai=="财务总监已处理"){
					$baozhangzhuangtai	=	"'财务总监通过' OR `status`='财务总监不通过'";					
				}
				if($baozhangzhuangtai=="总经理待处理"){
					$baozhangzhuangtai	=	"'财务总监通过'";					
				}
				if($baozhangzhuangtai=="总经理已处理"){
					$baozhangzhuangtai	=	"'总经理通过'";					
				}	
			
		}else{
				$baozhangzhuangtai="'经理通过' OR `status`='总经理不通过'";
		}//确定要查的收支状态
		$sql2	=	"SELECT DISTINCT `djtuanID` 
		FROM `dj_baozhang`  
		WHERE  `dj_baozhang`.`status` = ".$baozhangzhuangtai;//找到'等待审核'状态的地接子团ID
		$rs2 = $db->query($sql2);
		//echo $sql2;
		//dump($rs2);echo "caonima";
		foreach($rs2 as $v2){ $cond2	.=	$v2["djtuanID"].",";}
		$cond2	=	rtrim($cond2,",");
		$conditions2	=$conditions;
		unset($conditions2['zituanID']);	//去掉组团的条件
		$conditions2['djtuanID'] = array('IN',$cond2);
		//dump($conditions2);
		//修改结束 gaoyang
		$countdjtuan = $caiwu_djtuan_info->where($conditions2)->count();
		//dump($caiwu_djtuan_info);
		$count = $countzituan + $countdjtuan;
		$shownumber = 20;
		$p= new Page($count,$shownumber);
		$rurl = SITE_ADMIN."Caiwuguanli/departmentdetail/".$urlitem."/p/";
		$page = $p->show_select($rurl);
		$this->assign('page',$page);
		
		
		
		//判断组团还是地接 by gaoyang
		if($countzituan > $p->firstRow){			
			$zituanAll = $caiwu_zituan_info->where($conditions)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->Distinct(true)->field('zituanID')->select();
			$i=0;
			foreach($zituanAll as $zituan)
			{
				//获取子团内容和订单内容
				if($department['title'])
				$dingdanAll = $caiwu_zituan_info->where("`title` = '$department[title]' and `zituanID` = '$zituan[zituanID]'")->select();
				else
				$dingdanAll = $caiwu_zituan_info->where("`zituanID` = '$zituan[zituanID]'")->select();
				
				$zituanAll[$i] = $dingdanAll[0];
				//$zituanAll[$i]['tuantype'] = '组团';
				$user_name = $dingdanAll[0]['zituanadduser'];
				$kehu = $glkehu->where("`user_name` = '$user_name'")->find();
				$zituanAll[$i]['zituanrealname'] = $kehu['realname'];
				
				$nopay = 0;
				$payed = 0;
				foreach($dingdanAll as $data){
					
					if($data['check_status'] != '审核通过')
						continue;
					//人数修正 by heavenK
					$Gltuanyuan = D("tuanyuan_dingdan");
//					$rennum = $Gltuanyuan->where("`dingdanID` = '$data[dingdanID]'")->count();
					$bzd = $db->where("`zituanID` = '$data[zituanID]'")->find();
					$rennum = $bzd['renshu'];
					//$zituanAll[$i]['renshu'] += $rennum;
					$zituanAll[$i]['renshu'] = $rennum;
					//结束	
					
					//订单价格修正 by heavenK 靠，都他妈三层循环了！
					$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$data[dingdanID]'")->findAll();
					$sum = 0;
					foreach($tuanyuanAll as $tuanyuan){
						$sum += $tuanyuan['jiaoqian'];
					}
					$tem = $sum;
					//结束
					
					//$tem = $data['chengrenjia'] * $data['chengrenshu'] + $data['ertongjia'] * $data['ertongshu'];
					if($data['daokuan'] == '未付款')
					{
						$countonpay += $tem;
						$nopay += $tem;
					}
					if($data['daokuan'] == '已付款')
					{
						$countpayed += $tem;
						$payed += $tem;
					}
					$countall += $tem;
					//人数
					//$zituanAll[$i]['renshu'] += $data['chengrenshu'] + $data['ertongshu'];
				}
				$zituanAll[$i]['nopay'] = $nopay;
				$zituanAll[$i]['payed'] = $payed;
				//报账单
				$zituanbaozhang = $this->getbaozhangdan_zituan('',$zituan['zituanID']);
				$zituanAll[$i]['baozhangshouru'] = $zituanbaozhang['yingshou']['totalprice'] + $zituanbaozhang['qita']['totalprice'];
				$zituanAll[$i]['baozhangzhichu'] = $zituanbaozhang['yingfu']['totalprice'];
				$zituanAll[$i]['baozhangyingkui'] = $zituanbaozhang['yingshou']['totalprice'] + $zituanbaozhang['qita']['totalprice'] - $zituanbaozhang['yingfu']['totalprice'];
				$baozhangshouru += $zituanAll[$i]['baozhangshouru'];
				$baozhangzhichu += $zituanAll[$i]['baozhangzhichu'];
				$baozhangyingkui += $zituanAll[$i]['baozhangyingkui'];
				
				$i++;
			}
			$this->assign('countall',$countall);
			$this->assign('countonpay',$countonpay);
			$this->assign('countpayed',$countpayed);
		}
		
		//dump($countzituan);
		
		//判断地接
		if($countzituan < ($p->firstRow + $p->listRows))
		{
			$num = $countzituan % $shownumber;
			$t1 = $shownumber - $num;
			
			if(($p->firstRow - $countzituan) <= 0 ){
				$p->firstRow = 0;
				$p->listRows = $t1;
			}
			else{
				$t22 = ($p->firstRow - $countzituan) / $shownumber;
				if($num == 0)
				$p->firstRow = $t1 + $shownumber * ((int)$t22 - 1);
				else
				$p->firstRow = $t1 + $shownumber * (int)$t22;
			}
			
			//地接团
			$djtuanAll = $caiwu_djtuan_info->where($conditions2)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->select();
			
			foreach($djtuanAll as $tuan)
			{
				$tuan['xianlutype'] = '地接';
				$zituanAll[$i] = $tuan;
				//报账单
				$djtuanbaozhang = $this->getbaozhangdan_djtuan('',$tuan['djtuanID']);
				$zituanAll[$i]['baozhangshouru'] = $djtuanbaozhang['yingshou']['totalprice'] + $djtuanbaozhang['qita']['totalprice'];
				$zituanAll[$i]['baozhangzhichu'] = $djtuanbaozhang['yingfu']['totalprice'];
				$zituanAll[$i]['baozhangyingkui'] = $djtuanbaozhang['yingshou']['totalprice'] + $djtuanbaozhang['qita']['totalprice'] - $djtuanbaozhang['yingfu']['totalprice'];
				$baozhangshouru += $zituanAll[$i]['baozhangshouru'];
				$baozhangzhichu += $zituanAll[$i]['baozhangzhichu'];
				$baozhangyingkui += $zituanAll[$i]['baozhangyingkui'];
				
				$i++;
			}
		}
		$this->assign('zituanAll',$zituanAll);
		$this->assign('baozhangshouru',$baozhangshouru);
		$this->assign('baozhangzhichu',$baozhangzhichu);
		$this->assign('baozhangyingkui',$baozhangyingkui);
		
		$this->display();
		
		
    }































}
?>