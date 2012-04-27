<?php

class TuancreateAction extends CommonAction{

    public function index() {
        $this->redirect('/Tuancreate/tuanlist/jingwai/国内/type/创建');
    }
	
    public function tuanlist() {
		
		$navlist = "团队管理 > 团队创建 > ".$_GET['jingwai']." > ".$_GET['kind'];
		$this->assign('navlist',$navlist);
		
		$DJtuan = D('dj_tuan');
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'pagenum'|| $key == 'iframe')
			continue;
			if($key == 'type'){
				$condition['status'] = array('like','%'.$value.'%');
				$this->assign($key,$value);
				continue;
			}
			if($key == 'time1' || $key == 'time2')
			{
				$urlitem .= $key.'/'.$value;
				$this->assign($key,$value);
				continue;
			}
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		if($_GET['type'] == '创建')
			$condition['status'] = array('NOT IN','在线');
		elseif($_GET['type'] == '在线')
			$condition['status'] = '在线';
			
		$start =date( "Y-m",strtotime($_GET['time1'])); 
		$end =date( "Y-m",strtotime($_GET['time2'])); 
		if($_GET['time1'] && $_GET['time2'])	
			$condition['startdate'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$condition['startdate'] = array('egt',$start);
		elseif($_GET['time2'])
			$condition['startdate'] = array('elt',$start);
		
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $DJtuan->where($condition)->count();
		$pagenum = $_GET['pagenum'];
		if(!$pagenum)
			$pagenum = 15;
		$p= new Page($count,$pagenum);
		$forward = SITE_DIJIE."Tuancreate/tuanlist/p/";
		$page = $p->show($forward);
        $tuanAll = $DJtuan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		$this->assign('page',$page);
		$this->assign('tuanAll',$tuanAll);
		$this->assign('jingwai',$_GET['jingwai']);
		
		if($_GET['iframe'] == 1){
		$this->display('mytuan');
		exit;
		}
		
		$this->display();
    }
	
	
	
    public function newtuan() {
		
		foreach($_GET as $key => $value)
		{
			if($key == 'showtype' || $key == 'roletype' )
			{
				$this->assign($key,$value);
				continue;
			}
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		if($_GET['showtype'] == '审核')
		{
			$navlist = "审核";
			$this->assign('navlist',$navlist);
		}
		else
		{
			$navlist = "团队管理 > 团队创建 > 创建团队 > ".$_GET['jingwai']." > ".$_GET['kind'];;
			$this->assign('navlist',$navlist);
			
		}
		
		if($_GET['djtuanID']){
			$DJtuan = D('dj_tuan');
			$tuan = $DJtuan->where($condition)->find();
			if(!$tuan)
			doalert("错误!",'');
			$this->assign('tuan',$tuan);
		}
		
		$this->assign('location','基本信息');
		
		if($_GET['showtype'] == '审核')
		{
        $this->display('AdminShenhe/tuaninfo');
		}
		else	
        $this->display();
		
		
		
		
		
    }
	
	
    public function dopostNewtuan() {
		
		foreach($_POST as $key => $value){
			if($key == 'forword')
			$forword = $value;
			else
			$tuan[$key] = $value;
		}
		
		foreach($_FILES as $key => $value){
			$uplod = _dofileuplod();
			if($_FILES[$key]['name'] && $uplod != null)
			$tuan[$key] = $uplod;
			elseif($_FILES[$key]['name'] && $uplod == null)
			justalert('副本上传失败');
		}
		
		$DJtuan = D('dj_tuan');
		if($tuan['djtuanID'] == null)
		{
			$tuan['time'] = time();
			$tuan['status'] = '准备';
			$tuan['tocompany'] = $this->company['companyname'];
			$tuan['adduser'] = $this->roleuser['user_name'];
			$tuan['edituser'] = $this->roleuser['user_name'];
			$tuan['departmentName'] = $this->my_department['title'];
			$tuan['departmentID'] = $this->my_department['id'];
			
			$this->assign('postdata',$tuan);
			$newid = $DJtuan->add_My($tuan);
			if(!$forword)
				$forword = SITE_DIJIE."Tuancreate/itinerary/djtuanID/".$newid;
			if($newid)
				doalert("保存成功",$forword);
			else
				doalert("新建失败",$forword);
		}
		else
		{
			$record = $DJtuan->where("`djtuanID` = '$tuan[djtuanID]'")->find();
			if($tuan['attachment'])
				unlink("data/".$record['attachment']);
			$tuan['edituser'] = $this->roleuser['user_name'];
			$this->assign('postdata',$tuan);
			$DJtuan->save_My($tuan);
			doalert("修改成功",$forword);
		}
		
    }
	
	
	
    public function itinerary() {
		
		if($_GET['showtype'] == '审核')
		{
			$tppage =  'AdminShenhe/itinerary';
			$navlist = "审核 > 日程";
		}
		else
		{
			$tppage =  'itinerary';
			$navlist = "团队管理 > 团队创建 > 日程安排";
		}
		$this->assign('navlist',$navlist);
		
		$djtuanID = $_GET['djtuanID'];
		if(!$forword)
			$forword = '';
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",'');
		$this->assign('tuan',$tuan);
		
		$DJitinerary = D('dj_itinerary');
		$itinerary = $DJitinerary->where("`djtuanID` = '$djtuanID'")->find();
		
		//交通工具
		$dj_res = D('dj_resource');
		$traffic_tools = $dj_res->where("`type` = '工具'")->findAll();
		$this->assign('traffic_tools',$traffic_tools);
		
		//拆分抵达方式
		$arrivetool_arr = explode(",",$itinerary['arrivetool']);
		$arrivedatestart_arr = explode(",",$itinerary['arrivedatestart']);
		$arrivedateend_arr = explode(",",$itinerary['arrivedateend']);
		$arrivebianhao_arr = explode(",",$itinerary['arrivebianhao']);
		
		//拆分离开方式
		$leavetool_arr = explode(",",$itinerary['leavetool']);
		$leavedate_arr = explode(",",$itinerary['leavedate']);
		$leavebianhao_arr = explode(",",$itinerary['leavebianhao']);
		
		$this->assign('arrivetool_arr',$arrivetool_arr);
		$this->assign('arrivedatestart_arr',$arrivedatestart_arr);
		$this->assign('arrivedateend_arr',$arrivedateend_arr);
		$this->assign('leavetool_arr',$leavetool_arr);
		$this->assign('leavedate_arr',$leavedate_arr);
		$this->assign('leavebianhao_arr',$leavebianhao_arr);
		$this->assign('arrivebianhao_arr',$arrivebianhao_arr);


	
		$this->assign('itinerary',$itinerary);
		
		$DJrcitem = D('dj_rcitem');
		$rcitemAll = $DJrcitem->where("`itineraryID` = '$itinerary[itineraryID]'")->findall();
		$this->assign('rcitemAll',$rcitemAll);
		
		$this->assign('location','日程安排');
		
        $this->display($tppage);
	}
	
	
	
    public function dopostItinerary() {
		
		foreach($_POST as $key => $value){
			if($key == 'forword')
			$forword = $value;
			elseif($key == 'date')
			$rcitem[$key] = $value;
			elseif($key == 'content')
			$rcitem[$key] = $value;
			elseif($key == 'breakfastprice')
			$rcitem[$key] = $value;
			elseif($key == 'breakfastplace')
			$rcitem[$key] = $value;
			elseif($key == 'breakfasttelnum')
			$rcitem[$key] = $value;
			elseif($key == 'lunchprice')
			$rcitem[$key] = $value;
			elseif($key == 'lunchplace')
			$rcitem[$key] = $value;
			elseif($key == 'lunchtelnum')
			$rcitem[$key] = $value;
			elseif($key == 'dinnerprice')
			$rcitem[$key] = $value;
			elseif($key == 'dinnerpalce')
			$rcitem[$key] = $value;
			elseif($key == 'dinnertelnum')
			$rcitem[$key] = $value;
			elseif($key == 'othertitle')
			$rcitem[$key] = $value;
			elseif($key == 'otherpalce')
			$rcitem[$key] = $value;
			elseif($key == 'othertelnum')
			$rcitem[$key] = $value;
			elseif($key == 'rcitemID'){
				if($value)
				$rcitem[$key] = $value;
			}
			else
			$itinerary[$key] = $value;
		}
		foreach($rcitem as $key => $value){
			for($i =0; $i< $itinerary['daynumber']; $i++){
				$rcitemsave[$i][$key] = $value[$i];
			}
		}
		if(!$forword)
			$forword = '';
			
		
		//处理接收到的到达方式数组，将其转为字符串。
		$itinerary['arrivetool'] = implode(',',$itinerary['arrivetool']);
		$itinerary['arrivebianhao'] = implode(',',$itinerary['arrivebianhao']);
		$itinerary['arrivedatestart'] = implode(',',$itinerary['arrivedatestart']);
		$itinerary['arrivedateend'] = implode(',',$itinerary['arrivedateend']);
		
		//处理接收到的离开方式数组，将其转为字符串。
		$itinerary['leavetool'] = implode(',',$itinerary['leavetool']);
		$itinerary['leavebianhao'] = implode(',',$itinerary['leavebianhao']);
		$itinerary['leavedate'] = implode(',',$itinerary['leavedate']);
		
		
		$DJitinerary = D('dj_itinerary');
		$DJrcitem = D('dj_rcitem');
		if($itinerary['itineraryID'] == null)
		{
			
			$itinerary['time'] = time();
			$itinerary['status'] = '准备';
			$itinerary['edituser'] = $this->roleuser['user_name'];
			$this->assign('postdata',$itinerary);
			$newid = $DJitinerary->add_My($itinerary);
			
			//日程项
			foreach($rcitemsave as $item){
				$item['itineraryID'] = $newid;
				$item['time'] = time();
				$DJrcitem->add_My($item);
			}
			if($newid)
				doalert("保存成功",$forword);
			else
				doalert("新建失败",$forword);
		}
		else
		{
			$itinerary['edituser'] = $this->roleuser['user_name'];
			$this->assign('postdata',$itinerary);
			$DJitinerary->save_My($itinerary);
			
			//日程项
		    $DJrcitem->where("`itineraryID` = '$itinerary[itineraryID]'")->delete();
			foreach($rcitemsave as $item){
				$item['itineraryID'] = $itinerary['itineraryID'];
				$item['time'] = time();
				$DJrcitem->add_My($item);
			}
			doalert("修改成功",$forword);
		}
		
    }
	
	
	
    public function appraisal() {
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",'');
		$this->assign('tuan',$tuan);
		
		if($tuan['jingwai'] == '国内')
			$navlist = "团队管理 > 团队创建 > 估价";
		else
			$navlist = "团队管理 > 团队创建 > 見　積　書";
		$this->assign('navlist',$navlist);
		
		$DJappraisal = D('dj_appraisal');
		$appraisalAll = $DJappraisal->where("`djtuanID` = '$djtuanID'")->findall();
		$this->assign('appraisalAll',$appraisalAll);
		
		if($tuan['jingwai'] == '国内')	
		{
			foreach($appraisalAll as $item){
				$price += $item['price'];
			}
			$this->assign('totalprice',$price);
			
			$this->assign('appraisalAll',$appraisalAll);
			
			$djresource = D('dj_resource');
			$hotelAll = $djresource->where("type = '酒店'")->findall();
			$this->assign('hotelAll',$hotelAll);
			
			$otherAll = $djresource->where("type = '其他'")->findall();
			$this->assign('otherAll',$otherAll);
			
			$daoyouAll = $djresource->where("type = '导游'")->findall();
			$this->assign('daoyouAll',$daoyouAll);
			
			$carAll = $djresource->where("type = '用车'")->findall();
			$this->assign('carAll',$carAll);
			
			$ticketAll = $djresource->where("type = '门票'")->findall();
			$this->assign('ticketAll',$ticketAll);
			
			$eatAll = $djresource->where("type = '餐饮'")->findall();
			$this->assign('eatAll',$eatAll);
			
			$shopAll = $djresource->where("type = '购物'")->findall();
			$this->assign('shopAll',$shopAll);
		}
		if($tuan['jingwai'] == '境外')	
		{
			foreach($appraisalAll as $item){
				if($item['type'] == '日次'){
					$price_1_rmb += $item['renshu'];
					$price_1_rmb += $item['price'];
				}
				if($item['type'] == '机票'){
					$price_2_rmb += $item['price'];
				}
				if($item['type'] == '火车'){
					$price_3_rmb += $item['price'];
				}
				if($item['type'] == '门票'){
					$price_4_rmb += $item['price'];
				}
				if($item['type'] == '公路'){
					$price_5_rmb += $item['price'];
				}
				if($item['type'] == '料理'){
					$price_6_rmb += $item['price'];
				}
				if($item['type'] == '酒店'){
					$price_7_rmb += $item['renshu'];
					$price_7_rmb += $item['price'];
				}
				if($item['type'] == '特别费'){
					$price_8_rmb += $item['price'];
				}
			}
			$this->assign('price_8_rmb',$price_8_rmb);
			$this->assign('price_7_rmb',$price_7_rmb);
			$this->assign('price_6_rmb',$price_6_rmb);
			$this->assign('price_5_rmb',$price_5_rmb);
			$this->assign('price_4_rmb',$price_4_rmb);
			$this->assign('price_3_rmb',$price_3_rmb);
			$this->assign('price_2_rmb',$price_2_rmb);
			$this->assign('price_1_rmb',$price_1_rmb);
			
			$dj_resource = D('dj_resource');
			$huilv = $dj_resource->where("`title` = '人民币兑美元' and `type` = '汇率'")->find();
			$this->assign('huilv',$huilv);
			//dump($huilv);
			$this->assign('price_8_usa',$price_8_rmb * $huilv['price_ext2']);
			$this->assign('price_7_usa',$price_7_rmb * $huilv['price_ext2']);
			$this->assign('price_6_usa',$price_6_rmb * $huilv['price_ext2']);
			$this->assign('price_5_usa',$price_5_rmb * $huilv['price_ext2']);
			$this->assign('price_4_usa',$price_4_rmb * $huilv['price_ext2']);
			$this->assign('price_3_usa',$price_3_rmb * $huilv['price_ext2']);
			$this->assign('price_2_usa',$price_2_rmb * $huilv['price_ext2']);
			$this->assign('price_1_usa',$price_1_rmb * $huilv['price_ext2']);
		}
		
		$this->assign('location','估价');
		
		
		if($tuan['jingwai'] == '境外'){
			if($_GET['doprint'] == 1)
			$this->display('print_gujia_riben');
			else
			{
				if($_GET['showtype'] == '审核')
				{
					$tppage =  'AdminShenhe/appraisal_riben';
					$this->display($tppage);
				}
				else
				{
					$this->display('appraisal_riben');
				}
			
			}
		}
		if($tuan['jingwai'] == '国内')
		{
			if($_GET['doprint'] == 1)
			$this->display('print_gujia');
			else
			{
				if($_GET['showtype'] == '审核')
				{
					$tppage =  'AdminShenhe/appraisal';
					$this->display($tppage);
				}
				else
				{
					$this->display();
				}
			}
		}
		
	}
	
	
    public function addappraisalitem() {
			
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		$DJappraisal = D('dj_appraisal');
		if($item['djtuanID'] == null){
			echo "false";
			exit;
		}
		$item['time'] = time();
		$newid = $DJappraisal->add_My($item);
		echo $newid;
	}
	
	
    public function editappraisalitem() {
			
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		$DJappraisal = D('dj_appraisal');
		if($item['appraisalID'] == null){
			echo "false";
			exit;
		}
		$DJappraisal->save_My($item);
		echo 'true';
	}
	
	
    public function deleteappraisalitem() {
			
		$postdata = $_POST;
		$DJappraisal = D('dj_appraisal');
		$DJappraisal->where('appraisalID='.$postdata['appraisalID'])->delete();
		echo 'true';
	}
	
	
    public function appraisalprice() {
			
		$djtuanID = $_POST['djtuanID'];
		$DJappraisal = D('dj_appraisal');
		$appraisalAll = $DJappraisal->where('djtuanID='.$djtuanID)->findall();
		foreach($appraisalAll as $item){
			$price += $item['price'];
		}
		echo $price;
	}
	
	
    public function price_count() {
			
		$djtuanID = $_POST['djtuanID'];
		$type = $_POST['type'];
		foreach($_POST as $key => $value)
		{
			$condition[$key] = array('eq',$value);
		}
		
		$DJappraisal = D('dj_appraisal');
		$appraisalAll = $DJappraisal->where($condition)->findall();
		foreach($appraisalAll as $item){
			if($type == '日次' || $type == '酒店'){
				$price += $item['renshu'];
			}
			$price += $item['price'];
		}
		//echo $price;
			$dj_resource = D('dj_resource');
			$huilv = $dj_resource->where("`title` = '人民币兑美元' and `type` = '汇率'")->find();
		$usa = $price * $huilv['price_ext2'];
		
		echo '{ "rmb": "'.$price.'","usa": "'.$usa.'"}';
		
	}
	
	
    public function docheck() {
			
		$forward = _getforword();
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan['djtuanID'] = $djtuanID;
		$tuan['status'] = '报价审核';
		$DJtuan->save_My($tuan);
		//记录 savemessage($tableID,$tablename,$type,$content)
		A("Message")->savemessage($djtuanID,'地接团队','操作记录','报价审核，进入报价阶段');
		doalert('报价审核',$forward);
	}
	
	

    public function chengtuan() {
		$postdata = $_POST;
		$itemlist = $postdata['itemlist'];
		if($postdata['forward'])
			$forward = $postdata['forward'];
		if(!$itemlist){
			doalert('没有选择',$forward);
		}
		
		$DJtuan = D('dj_tuan');
		foreach($itemlist as $item)
		{
			$tuan = $DJtuan->where("`djtuanID` = '$item'")->find();
			if($tuan){
				
					$tuan['islock'] = '已锁定';
					$tuan['status'] = '在线';
					$DJtuan->save_My($tuan);
					//记录
					A("Message")->savemessage($item['djtuanID'],'地接团队','操作记录','在线成团，锁定团队');
//				if($tuan['status'] == '询价'){
//					$tuan['islock'] = '已锁定';
//					$tuan['status'] = '在线';
//					$DJtuan->save_My($tuan);
//					A("Message")->savemessage($item['djtuanID'],'地接团队','操作记录','在线成团，锁定团队');
//				}
//				else 
//				doalert('只能在询价结束后成团',$forward);
			}
		}
		doalert('操作成功',$forward);
	}
	
	
	
	
    public function deletetuan() {
 			$postdata = $_POST;
			$itemlist = $postdata['itemlist'];
			if(!$itemlist)
			{
				if($postdata['forward'])
				$forward = $postdata['forward'];
				else
				$forward = '';
				doalert('没有选择',$forward);
			}
			
			$DJtuan = D('dj_tuan');
			$dj_applypayment = D('dj_applypayment');
			$dj_appraisal = D('dj_appraisal');
			$dj_baozhang = D('dj_baozhang');
			$dj_baozhangitem = D('dj_baozhangitem');
			$dj_itinerary = D('dj_itinerary');
			$dj_orderhotel = D('dj_orderhotel');
			$dj_receipt = D('dj_receipt');
			$dj_rcitem = D('dj_rcitem');
			
			foreach($itemlist as $djtuanID)
			{
				$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
				if($tuan){
					$DJtuan->where("`djtuanID` = '$djtuanID'")->delete();
					$dj_applypayment->where("`djtuanID` = '$djtuanID'")->delete();
					$dj_appraisal->where("`djtuanID` = '$djtuanID'")->delete();
					
					$baozhang = $dj_baozhang->where("`djtuanID` = '$djtuanID'")->find();
					$dj_baozhangitem->where("`baozhangID` = '$baozhang[baozhangID]'")->delete();
					$dj_baozhang->where("`djtuanID` = '$djtuanID'")->delete();
					
					$itinerary = $dj_itinerary->where("`djtuanID` = '$djtuanID'")->find();
					$dj_rcitem->where("`itineraryID` = '$itinerary[itineraryID]'")->delete();
					$dj_itinerary->where("`djtuanID` = '$djtuanID'")->delete();
					
					$dj_receipt->where("`djtuanID` = '$djtuanID'")->delete();
					$dj_orderhotel->where("`djtuanID` = '$djtuanID'")->delete();
 				}
 			}
			if($postdata['forward'])
			$forward = $postdata['forward'];
			else
			$forward = '';
			doalert('成功删除',$forward);
	}
	
	
	
	
	
	
    public function tuanlock() {
 			$postdata = $_POST;
			if($_GET['type'] == '已锁定')
			$lock = '已锁定';
			elseif($_GET['type'] == '未锁定')
			$lock = '未锁定';
			else
			$error = true;
			
			$itemlist = $postdata['itemlist'];
			if(!$itemlist || $error)
			{
				if($postdata['forward'])
				$forward = $postdata['forward'];
				else
				$forward = '';
				doalert('没有选择',$forward);
			}
			
			$DJtuan = D('dj_tuan');
			$dj_applypayment = D('dj_applypayment');
			$dj_appraisal = D('dj_appraisal');
			$dj_baozhang = D('dj_baozhang');
			$dj_baozhangitem = D('dj_baozhangitem');
			$dj_itinerary = D('dj_itinerary');
			$dj_orderhotel = D('dj_orderhotel');
			$dj_receipt = D('dj_receipt');
			$dj_rcitem = D('dj_rcitem');
			
			foreach($itemlist as $djtuanID)
			{
				$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
				if($tuan){
					$edittuan['djtuanID'] = $djtuanID;
					$edittuan['islock'] = $lock;
					$DJtuan->save_My($edittuan);
 				}
 			}
			if($postdata['forward'])
			$forward = $postdata['forward'];
			else
			$forward = '';
			doalert($lock,$forward);
	}
	
	
	

    public function quxiaochengtuan() {
		
		$postdata = $_POST;
		$itemlist = $postdata['itemlist'];
		if($postdata['forward'])
			$forward = $postdata['forward'];
		else
			$forward = '';
		if(!$itemlist){
			doalert('没有选择',$forward);
		}
		
		$DJtuan = D('dj_tuan');
		foreach($itemlist as $item)
		{
			$tuan = $DJtuan->where("`djtuanID` = '$item'")->find();
			if($tuan['islock'] == '未锁定'){
					$tuan['status'] = '准备';
					$DJtuan->save_My($tuan);
					//记录
					A("Message")->savemessage($item['djtuanID'],'地接团队','操作记录','取消锁定');
			}
			else 
			doalert('操作失败，团已经锁定',$forward);
		}
		doalert('操作成功',$forward);
	}
	
	
    public function copynew() {
		
		$postdata = $_POST;
		$itemlist = $postdata['itemlist'];
		if($postdata['forward'])
			$forward = $postdata['forward'];
		else
			$forward = '';
		if(!$itemlist){
			doalert('没有选择',$forward);
		}
		
		$DJtuan = D('dj_tuan');
		foreach($itemlist as $item)
		{
			$tuan = $DJtuan->where("`djtuanID` = '$item'")->find();
			if($tuan){
				$tuannew = $tuan;
				$tuannew['djtuanID'] = '';
				$tuannew['tuannumber'] = '';
				$tuannew['startdate'] = '';
				$tuannew['attachment'] = '';
				$tuannew['adduser'] = $this->roleuser['user_name'];
				$tuannew['edituser'] = $this->roleuser['user_name'];
				$tuannew['time'] = time();
				$tuannew['islock'] = '未锁定';
				$tuannew['status'] = '准备';
				$DJtuan->add_My($tuannew);
			}
			
		}
		doalert('操作成功',$forward);
	
	}
	
	
    public function riben_cost() {
		$navlist = "团队管理 > 团队创建 > 原価計算表";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		if(!$forword)
			$forword = '';
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",'');
		$this->assign('tuan',$tuan);
		
		$dj_costitem = D('dj_costitem');
		$costitemAll = $dj_costitem->where("`djtuanID` = '$djtuanID'")->findall();
		$this->assign('costitemAll',$costitemAll);
		
		foreach($costitemAll as $item){
			$price += $item['price'];
		}
		$this->assign('price_usd',$price);
		
		$this->assign('location','成本计算');
		
		if($_GET['doprint'] == 1)
		$this->display('print_chengbenjisuan_riben');
		else
        $this->display();
		
	}
	
	
	
    public function addcostitem() {
			
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		$dj_cost = D('dj_cost');
		if($item['djtuanID'] == null){
			echo "false";
			exit;
		}
		$item['time'] = time();
		$newid = $dj_cost->add_My($item);
		echo $newid;
	}
	
	
    public function addcostlitem() {
			
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		$dj_costitem = D('dj_costitem');
		if($item['djtuanID'] == null){
			echo "false";
			exit;
		}
		$item['time'] = time();
		$newid = $dj_costitem->add_My($item);
		echo $newid;
	}
	
	
    public function editcostlitem() {
			
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		$dj_costitem = D('dj_costitem');
		if($item['costitemID'] == null){
			echo "false";
			exit;
		}
		$dj_costitem->save_My($item);
		echo 'true';
	}
	
    public function deletecostlitem() {
			
		$postdata = $_POST;
		$dj_costitem = D('dj_costitem');
		$dj_costitem->where('costitemID='.$postdata['costitemID'])->delete();
		echo 'true';
	}
	
	
	
    public function cost_price_count() {
			
		$djtuanID = $_POST['djtuanID'];
		foreach($_POST as $key => $value)
		{
			$condition[$key] = array('eq',$value);
		}
		
		$dj_costitem = D('dj_costitem');
		$costitemAll = $dj_costitem->where($condition)->findall();
		foreach($costitemAll as $item){
			$price += $item['price'];
		}
		
		//echo $price;
//		$dj_resource = D('dj_resource');
//		$huilv = $dj_resource->where("`title` = '人民币兑美元' and `type` = '汇率'")->find();
//		$usa = $price * $huilv['price_ext2'];
		
		echo '{ "price": "'.$price.'"}';
		
	}
	
	
	
	
	
	
	
	

}
?>