<?php

class TuancontrolAction extends CommonAction{

	
    public function tuanlist() {
		$navlist = "团队管理 > 团队控管 > ".$_GET['jingwai']." > ".$_GET['kind'];
		$this->assign('navlist',$navlist);
		
		$DJtuan = D('dj_tuan');
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'type')
			continue;
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		if(!$condition['status'])
		$condition['status'] = '在线';

		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $DJtuan->where($condition)->count();
		$p= new Page($count,10);
		//$rurl = SITE_DIJIE."Tuancontrol/tuanlist/p/";
		$page = $p->show();
        $tuanAll = $DJtuan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		$this->assign('page',$page);
		$DJbaozhang = D('dj_baozhang');
		$i = 0;
		foreach($tuanAll as $tuan)
		{
			$baozhang = $DJbaozhang->where("`djtuanID` = '$tuan[djtuanID]'")->find();
			if($baozhang)
				$tuanAll[$i]['baozhang'] = $baozhang;
			$i++;	
		}
		$this->assign('tuanAll',$tuanAll);
		
		if($type == '带团通知单')
		$this->display('travelnoticelist');
		elseif($type == '付款申请单')
		$this->display('applypaymentlist');
		elseif($type == '收据清单')
		$this->display('receiptlist');
//		elseif($type == '订房确认单')
//		$this->display('orderhotellist');
		elseif($type == '报账单')
		$this->display('baozhangdanlist');
		else
		$this->display();
		
    }
	
	
    public function tuaninfo() {
		
		$navlist = "团队管理 > 团队控管 > 基本信息";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		
		$DJtuan = D('dj_tuan');
        $tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		
		$this->assign('location','基本信息');
		$this->assign('tuan',$tuan);
        $this->display();
    }
	


    public function itinerary() {
		$navlist = "团队管理 > 团队控管 > 日程安排";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		if(!$forword)
			$forword = SITE_DIJIE."Tuancontrol/appraise/djtuanID/".$djtuanID;
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Tuancontrol/tuanlist");
		$this->assign('tuan',$tuan);
		
		$Gllvxingshe = D('Gllvxingshe');
		$postdata['admintype'] = "客户";
		$postdata['type'] = "同业";
		$companyAll = $Gllvxingshe->where($postdata)->findall();
		$this->assign('companyAll',$companyAll);
		
		$DJitinerary = D('dj_itinerary');
		$itinerary = $DJitinerary->where("`djtuanID` = '$djtuanID'")->find();
		$company = $Gllvxingshe->where("`lvxingsheID` = '$itinerary[oncompany]'")->find();
		$itinerary['oncompanyname'] = $company['companyname'];
		
		//交通工具
		$dj_res = D('dj_resource');
		$traffic_tools = $dj_res->where("`type` = '工具'")->findAll();
		$this->assign('traffic_tools',$traffic_tools);
		//拆分抵达方式
		$arrivetool_arr = explode(",",$itinerary['arrivetool']);
		$arrivebianhao_arr = explode(",",$itinerary['arrivebianhao']);
		$arrivedatestart_arr = explode(",",$itinerary['arrivedatestart']);
		$arrivedateend_arr = explode(",",$itinerary['arrivedateend']);
		
		//拆分离开方式
		$leavetool_arr = explode(",",$itinerary['leavetool']);
		$leavebianhao_arr = explode(",",$itinerary['leavebianhao']);
		$leavedate_arr = explode(",",$itinerary['leavedate']);
		
		$this->assign('arrivetool_arr',$arrivetool_arr);
		$this->assign('arrivebianhao_arr',$arrivebianhao_arr);
		$this->assign('arrivedatestart_arr',$arrivedatestart_arr);
		$this->assign('arrivedateend_arr',$arrivedateend_arr);
		$this->assign('leavetool_arr',$leavetool_arr);
		$this->assign('leavebianhao_arr',$leavebianhao_arr);
		$this->assign('leavedate_arr',$leavedate_arr);		
		
		
		
		
		$this->assign('itinerary',$itinerary);
		
		$DJrcitem = D('dj_rcitem');
		$rcitemAll = $DJrcitem->where("`itineraryID` = '$itinerary[itineraryID]'")->findall();
		$this->assign('rcitemAll',$rcitemAll);
		
		$this->assign('location','日程安排');
        $this->display();
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
		
		$this->assign('printable','打印');
		
		$this->assign('location','估价');
		if($tuan['jingwai'] == '境外'){
			if($_GET['doprint'] == 1)
			$this->display('print_gujia_riben');
			else
			$this->display('appraisal_riben');
		}
		if($tuan['jingwai'] == '国内')
		{
			if($_GET['doprint'] == 1)
			$this->display('print_gujia');
			else
			$this->display();
		}
		
	}
	

	
    public function travelnotice() {
		$navlist = "团队管理 > 团队控管 >带团通知单";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		if(!$forword)
			$forword = SITE_DIJIE."Tuancreate/appraise/djtuanID/".$djtuanID;
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Tuancontrol/tuanlist");
		$this->assign('tuan',$tuan);
		
		$DJitinerary = D('dj_itinerary');
		$itinerary = $DJitinerary->where("`djtuanID` = '$djtuanID'")->find();
		
		
		//拆分抵达方式
		$arrivetool_arr = explode(",",$itinerary['arrivetool']);
		$arrivedatestart_arr = explode(",",$itinerary['arrivedatestart']);
		$arrivedateend_arr = explode(",",$itinerary['arrivedateend']);
		
		//拆分离开方式
		$leavetool_arr = explode(",",$itinerary['leavetool']);
		$leavedate_arr = explode(",",$itinerary['leavedate']);
		
		$this->assign('arrivetool_arr',$arrivetool_arr);
		$this->assign('arrivedatestart_arr',$arrivedatestart_arr);
		$this->assign('arrivedateend_arr',$arrivedateend_arr);
		$this->assign('leavetool_arr',$leavetool_arr);
		$this->assign('leavedate_arr',$leavedate_arr);
		$this->assign('itinerary',$itinerary);
		
		$DJrcitem = D('dj_rcitem');
		$rcitemAll = $DJrcitem->where("`itineraryID` = '$itinerary[itineraryID]'")->findall();
		$this->assign('rcitemAll',$rcitemAll);
		
		$this->assign('location','带团通知单');
		$this->assign('printable','打印');
		
		if($_GET['doprint'])
			$this->display('printtravelnotice');
		else
		{
			if($_GET['showtype'] == '审核')
			{
				$tppage =  'AdminShenhe/travelnotice';
				$this->display($tppage);
			}
			else
			{
				$this->display();
			}
			
		}	
	}



    public function doprint() {
		
		$djtuanID = $_GET['djtuanID'];
		if($_GET['type'] == '带团通知单')
			$this->redirect('/Tuancontrol/travelnotice/doprint/1/djtuanID/'.$djtuanID);
		if($_GET['type'] == '付款申请单')
			$this->redirect('/Tuancontrol/printapplypayment/doprint/1/djtuanID/'.$djtuanID);
		if($_GET['type'] == '收据清单')
			$this->redirect('/Tuancontrol/printshouju/doprint/1/djtuanID/'.$djtuanID);
		if($_GET['type'] == '订房确认单')
			$this->redirect('/Tuancontrol/orderhotel/doprint/1/djtuanID/'.$djtuanID);
		if($_GET['type'] == '报账单'){
			if($_GET['showpage'] == '计调')
			$this->redirect('/Tuancontrol/baozhangdan/showpage/计调/doprint/1/djtuanID/'.$djtuanID);
			else
			$this->redirect('/Tuancontrol/baozhangdan/doprint/1/djtuanID/'.$djtuanID);
			
			//$this->redirect('/Tuancontrol/baozhangdanjw/doprint/1/djtuanID/'.$djtuanID);
		}
		if($_GET['type'] == '估价'){
			if($_GET['jingwai'] == '境外')
			$this->redirect('/Tuancreate/appraisal/doprint/1/djtuanID/'.$djtuanID);
		}
		if($_GET['type'] == '成本计算'){
			if($_GET['jingwai'] == '境外')
			$this->redirect('/Tuancreate/riben_cost/doprint/1/djtuanID/'.$djtuanID);
		}
		else
			$this->display('Error/error404');

    }
	

//	
//    public function applypayment() {
//		$navlist = "团队管理 > 团队控管 > 付款申请单";
//		$this->assign('navlist',$navlist);
//		$djtuanID = $_GET['djtuanID'];
//		$DJtuan = D('dj_tuan');
//		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
//		if(!$tuan)
//			doalert("团队不存在",SITE_DIJIE."Tuancontrol/tuanlist");
//		$this->assign('tuan',$tuan);
//		
//		$DJapplypayment = D('dj_applypayment');
//		$paymentAll = $DJapplypayment->where("`djtuanID` = '$djtuanID'")->findall();
//		$this->assign('paymentAll',$paymentAll);
//		
//		$this->assign('location','付款申请单');
//		
//		if($_GET['showtype'] == '审核')
//		{
//			$tppage =  'AdminShenhe/applypayment';
//			$this->display($tppage);
//		}
//		else
//		{
//			$this->display();
//		}
//	}
//	

//    public function addpaymentitem() {
//		
//		$postdata = $_POST;
//		foreach($_POST as $key => $value ){
//			$item[$key] = $value;
//		}
//		$DJapplypayment = D('dj_applypayment');
//		if($item['djtuanID'] == null){
//			echo "false";
//			exit;
//		}
//		$item['time'] = time();
//		$newid = $DJapplypayment->add($item);
//		echo $newid;
//			
//	}
	

	
//    public function editpaymentitem() {
//			
//		$postdata = $_POST;
//		foreach($_POST as $key => $value ){
//			$item[$key] = $value;
//		}
//		$DJapplypayment = D('dj_applypayment');
//		if($item['applypaymentID'] == null){
//			echo "false";
//			exit;
//		}
//		$DJapplypayment->save($item);
//		echo 'true';
//	}
	
	
	
//    public function deletepaymentitem() {
//			
//		$postdata = $_POST;
//		$DJapplypayment = D('dj_applypayment');
//		$DJapplypayment->where('applypaymentID='.$postdata['applypaymentID'])->delete();
//		echo 'true';
//	}
	

//    public function docheck() {
//			
//		$postdata = $_POST;
//		$item['applypaymentID'] = $postdata['applypaymentID'];
//		if($postdata['type'] == '申请'){
//			$item['status'] = '申请';
//		}
//		$DJapplypayment = D('dj_applypayment');
//		if($item['applypaymentID'] == null){
//			echo "false";
//			exit;
//		}
//		$DJapplypayment->save($item);
//		echo $item['status'];
//	}
	
//
//    public function receipt() {
//		$navlist = "团队管理 > 团队控管 > 收据清单";
//		$this->assign('navlist',$navlist);
//		$djtuanID = $_GET['djtuanID'];
//		$DJtuan = D('dj_tuan');
//		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
//		if(!$tuan)
//			doalert("团队不存在",SITE_DIJIE."Tuancontrol/tuanlist");
//		$this->assign('tuan',$tuan);
//		
//		$DJreceipt = D('dj_receipt');
//		$receiptAll = $DJreceipt->where("`djtuanID` = '$djtuanID'")->findall();
//		$this->assign('receiptAll',$receiptAll);
//		
//		$this->assign('location','收据清单');
//		
//		if($_GET['showtype'] == '审核')
//		{
//			$tppage =  'AdminShenhe/receipt';
//			$this->display($tppage);
//		}
//		else
//		{
//			$this->display();
//		}
//	}
//	

//    public function addreceipt() {
//		
//		$postdata = $_POST;
//		foreach($_POST as $key => $value ){
//			$item[$key] = $value;
//		}
//		$DJreceipt = D('dj_receipt');
//		if($item['djtuanID'] == null){
//			echo "false";
//			exit;
//		}
//		$item['time'] = time();
//		$newid = $DJreceipt->add($item);
//		echo $newid;
//			
//	}
	

	
//    public function editreceipt() {
//			
//		$postdata = $_POST;
//		foreach($_POST as $key => $value ){
//			$item[$key] = $value;
//		}
//		$DJreceipt = D('dj_receipt');
//		if($item['receiptID'] == null){
//			echo "false";
//			exit;
//		}
//		$DJreceipt->save($item);
//		echo 'true';
//	}
//

	
//    public function deletereceipt() {
//			
//		$postdata = $_POST;
//		$DJreceipt = D('dj_receipt');
//		$DJreceipt->where('receiptID='.$postdata['receiptID'])->delete();
//		echo 'true';
//	}
//	

//    public function receiptattachment() {
//
//		$navlist = "团队管理 > 团队控管 > 收据清单 > 上传副本";
//		$this->assign('navlist',$navlist);
//		$receiptID = $_GET['receiptID'];
//		$DJreceipt = D('dj_receipt');
//		$receipt = $DJreceipt->where("`receiptID` = '$receiptID'")->find();
//		$this->assign('receipt',$receipt);
//		
//        $this->display();
//
//
//	}
	
//
//    public function dopostreceiptattachment() {
//			
//		$postdata = $_POST;
//		$DJreceipt = D('dj_receipt');
//		$reurl = SITE_DIJIE.'Tuancontrol/receiptattachment/receiptID/'.$postdata['receiptID'];
//		
//		$receipt = $DJreceipt->where("`receiptID` = '$postdata[receiptID]")->find();
//		
//		if(!$receipt)
//			doalert('错误',$reurl);
//		foreach($_FILES as $key => $value){
//			$uplod = _dofileuplod();
//			if($_FILES[$key]['name'] && $uplod != null){
//			$postdata['attachment'] = $uplod;
//			unlink("data/".$receipt['attachment']);
//			}
//			elseif($_FILES[$key]['name'] && $uplod == null)
//			doalert('副本上传失败',$reurl);
//		}
//		
//		$DJreceipt->save($postdata);
//		doalert("上传成功",$reurl);
//
//	}
//	
	
//	
//    public function applyattachment() {
//
//		$navlist = "团队管理 > 团队控管 > 付款申请单 > 上传副本";
//		$this->assign('navlist',$navlist);
//		$applypaymentID = $_GET['applypaymentID'];
//		$DJapplypayment = D('dj_applypayment');
//		$applypayment = $DJapplypayment->where("`applypaymentID` = '$applypaymentID'")->find();
//		$this->assign('applypayment',$applypayment);
//		
//        $this->display();
//
//
//	}
//	

//    public function dopostapplyattachment() {
//			
//		$postdata = $_POST;
//		$DJapplypayment = D('dj_applypayment');
//		$reurl = SITE_DIJIE.'Tuancontrol/applyattachment/applypaymentID/'.$postdata['applypaymentID'];
//		
//		$applypayment = $DJapplypayment->where("`applypaymentID` = '$postdata[applypaymentID]'")->find();
//		if(!$applypayment)
//			doalert('错误',$reurl);
//		foreach($_FILES as $key => $value){
//			$uplod = _dofileuplod();
//			if($_FILES[$key]['name'] && $uplod != null){
//			$postdata['attachment'] = $uplod;
//			unlink("data/".$applypayment['attachment']);
//			}
//			elseif($_FILES[$key]['name'] && $uplod == null)
//			doalert('副本上传失败',$reurl);
//		}
//		
//		$DJapplypayment->save($postdata);
//		doalert("上传成功",$reurl);
//
//	}
	
	public function orderhotel_list() {

		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Tuancontrol/tuanlist");
		$this->assign('tuan',$tuan);
		$this->assign('list_add','1');

		
		$navlist = "团队管理 > 团队控管 > 订房确认单列表";
		$this->assign('navlist',$navlist);
		
		$DJorderhotel = D('dj_orderhotel');

        $orderhotelAll = $DJorderhotel->where("`djtuanID` = '$tuan[djtuanID]'")->order("time DESC")->select();

		$dj_tuan = D("dj_tuan");
		$i = 0;
		foreach($orderhotelAll as $v){
			$tuan = $dj_tuan->where("`djtuanID` = '$v[djtuanID]'")->find();
			$orderhotelAll[$i]['tuan'] = $tuan;
			$i ++;
		}
		$this->assign('orderhotelAll',$orderhotelAll);
		
        $this->display();

	}

	
    public function orderhotel() {
		
		$navlist = "团队管理 > 团队控管 > 订房确认单";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Tuancontrol/tuanlist");
		$this->assign('tuan',$tuan);
		
		$orderhotelID = $_GET['orderhotelID'];
		
		$DJorderhotel = D('dj_orderhotel');
		$orderhotel = $DJorderhotel->where("`orderhotelID` = '$orderhotelID'")->find();
		$this->assign('orderhotel',$orderhotel);
		$this->assign('location','订房确认单');
		$this->assign('printable','打印');
		
		if($_GET['doprint']){
			$glkehu = D('glkehu');
			$kehuuser = $glkehu->where("`user_name` = '$tuan[adduser]'")->find();
			
			$this->assign('kehuuser',$kehuuser);
			$gllvxingshe = D('gllvxingshe');
			$company = $gllvxingshe->where("`lvxingsheID` = '$kehuuser[lvxingsheID]'")->find();
			$this->assign('company',$company);
			
			$this->display('printorderhotel');
		}
		else
		{
				if($_GET['showtype'] == '审核')
				{
					$tppage =  'AdminShenhe/orderhotel';
					$this->display($tppage);
				}
				else
				{
					$this->display();
				}
			}
			
	}

	
	
	
    public function dopostorderhotel() {
		
		foreach($_POST as $key => $value){
			if($key == 'forword')
			$forword = $value;
			else
			$orderhotel[$key] = $value;
		}
		$DJorderhotel = D('dj_orderhotel');
		
		foreach($_FILES as $key => $value){
			$uplod = _dofileuplod();
			if($_FILES[$key]['name'] && $uplod != null)
			$orderhotel[$key] = $uplod;
			elseif($_FILES[$key]['name'] && $uplod == null)
			justalert('副本上传失败');
		}
		if($orderhotel['orderhotelID'] == null)
		{
			$orderhotel['time'] = time();
			$orderhotel['status'] = '准备';
			$orderhotel['islock'] = '未锁定';
			$orderhotel['adduser'] = $this->roleuser['user_name'];
			$newid = $DJorderhotel->add($orderhotel);
			if(!$forword)
				$forword = SITE_DIJIE."Tuancontrol/orderhotel_list/djtuanID/".$newid;
			if($newid)
				doalert("保存成功",$forword);
			else
				doalert("新建失败",$forword);
		}
		else
		{
			$record = $DJorderhotel->where("`orderhotelID` = '$orderhotel[orderhotelID]'")->find();
			if($orderhotel['attachment'])
				unlink("data/".$record['attachment']);
			$DJorderhotel->save($orderhotel);
			doalert("修改成功",$forword);
		}
		
    }
	



	
    public function baozhangdan() {
		
		
		$navlist = "团队管理 > 团队控管 > 报账单";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		
		if($djtuanID)
		{
			$DJtuan = D('dj_tuan');
			$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
			if(!$tuan)
				doalert("团队不存在",SITE_DIJIE."Tuancontrol/tuanlist");
			$this->assign('tuan',$tuan);
			$DJbaozhang = D('dj_baozhang');
			$baozhang = $DJbaozhang->where("`djtuanID` = '$tuan[djtuanID]'")->find();
		}
		elseif($_GET['datatype'] == 'backup')
		{
			$id = $_GET["id"];
			$bzdbackup_zituan_djtuan = D("bzdbackup_zituan_djtuan");
			$bzd = $bzdbackup_zituan_djtuan->where("`id` = '$id'")->find();
			$tuan = $bzd;
			$tuan['renshu'] = $tuan['dj_renshu'];
			$this->assign('tuan',$tuan);
			$baozhang = unserialize($bzd['content']);
			$djtuanID = $baozhang['djtuanID'];
		}
		
		$this->assign('baozhang',$baozhang);
		$this->assign('location','报账单');
		$this->assign('printable','打印');
		
		$DJbaozhangitem = D('dj_baozhangitem');
		if($_GET['showpage'] == '计调')
		$itemAll = $DJbaozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and (`check_status` = '经理确认' or `check_status` = '审核通过')")->findall();
		else
		$itemAll = $DJbaozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and `check_status` = '审核通过'")->findall();
		
		$i = 0; $m =0; $n =0;
		foreach($itemAll as $item){
			if($item['type'] == '结算项目'){
				$itemjiesuan[$i] = $item;
				
				$jisuanheji_p += $item['price'];
				if($item['pricetype'] == '现金'){
					$jiesuanxianjin_p += $item['price'];
				}
				if($item['pricetype'] == '支票'){
					$jiesuanzhipiao_p += $item['price'];
				}
				if($item['pricetype'] == '汇款'){
					$jiesuanhuikuan_p += $item['price'];
				}
				if($item['pricetype'] == '网拨'){
					$jiesuanwangbo_p += $item['price'];
				}
				if($item['pricetype'] == '银行卡'){
					$jiesuanyinhangka_p += $item['price'];
				}
				if($item['pricetype'] == '转账'){
					$jiesuanzhuanzhang_p += $item['price'];
				}
				
				$i++;
			}
			if($item['type'] == '支出项目'){
				$itemzhichu[$m] = $item;
				
				$zhichuheji_p += $item['price'];
				if($item['pricetype'] == '现金'){
					$zhichuxianjin_p += $item['price'];
				}
				if($item['pricetype'] == '支票'){
					$zhichuzhipiao_p += $item['price'];
				}
				if($item['pricetype'] == '转账'){
					$zhichuzhuanzhang_p += $item['price'];
				}
				if($item['pricetype'] == '签单'){
					$zhichuqiandan_p += $item['price'];
				}
				
				$m++;
			}
//			if($item['type'] == '项目'){
//				$itemqita[$n] = $item;
//				$qitaheji += $item['price'];
//				$n++;
//			}
		}
		$this->assign('jisuanheji_p',$jisuanheji_p);
		$this->assign('jiesuanxianjin_p',$jiesuanxianjin_p);
		$this->assign('jiesuanzhipiao_p',$jiesuanzhipiao_p);
		$this->assign('jiesuanhuikuan_p',$jiesuanhuikuan_p);
		$this->assign('jiesuanwangbo_p',$jiesuanwangbo_p);
		$this->assign('jiesuanyinhangka_p',$jiesuanyinhangka_p);
		$this->assign('jiesuanzhuanzhang_p',$jiesuanzhuanzhang_p);
		
		$this->assign('zhichuheji_p',$zhichuheji_p);
		$this->assign('zhichuxianjin_p',$zhichuxianjin_p);
		$this->assign('zhichuzhipiao_p',$zhichuzhipiao_p);
		$this->assign('zhichuzhuanzhang_p',$zhichuzhuanzhang_p);
		$this->assign('zhichuqiandan_p',$zhichuqiandan_p);
		
		$this->assign('qitaheji',$qitaheji);
		
		$this->assign('itemjiesuan',$itemjiesuan);
		$this->assign('itemzhichu',$itemzhichu);
		$this->assign('itemqita',$itemqita);
		$this->assign('itemAll',$itemAll);
		
		
		$countdata = $this->baozhangcountdata($baozhang['baozhangID']);
		$this->assign('countdata',$countdata);
		
		$jiesuanheji = $this->baozhangheji($baozhang['baozhangID'],'结算项目');
		$this->assign('jiesuanheji',$jiesuanheji);
		
		$zhichuheji = $this->baozhangheji($baozhang['baozhangID'],'支出项目');
		$this->assign('zhichuheji',$zhichuheji);
		
		if($_GET['doprint'])
		{
			$glkehu = D('glkehu');
			$kehuuser = $glkehu->where("`user_name` = '$tuan[adduser]'")->find();
			
			$this->assign('kehuuser',$kehuuser);
			$gllvxingshe = D('gllvxingshe');
			$company = $gllvxingshe->where("`lvxingsheID` = '$kehuuser[lvxingsheID]'")->find();
			$this->assign('company',$company);
			if($_GET['showpage'] == '计调')
			{
				$this->display('printbaozhangdan_2');
				}
			else
			{
				if($tuan['jingwai'] == '境外')
				$this->display('printbaozhangdan');
				
				if($tuan['jingwai'] == '国内')
				$this->display('printbaozhangdan');
			}	
			
		}
		else
		{
			if($_GET['showtype'] == '审核')
			{
				$tppage =  'AdminShenhe/baozhangdan';
				$this->display($tppage);
			}
			else
			{
				$this->display();
			}
		}
	}

	

	

	
	
    public function dopostbaozhangdan() {
		
		foreach($_POST as $key => $value){
			if($key == 'forword')
			$forword = $value;
			else
			$postdata[$key] = $value;
		}
		$DJbaozhang = D('dj_baozhang');
//		
//		foreach($_FILES as $key => $value){
//			$uplod = _dofileuplod();
//			if($_FILES[$key]['name'] && $uplod != null)
//			$postdata[$key] = $uplod;
//			elseif($_FILES[$key]['name'] && $uplod == null)
//			justalert('副本上传失败');
//		}

		if($postdata['baozhangID'] == null || !$postdata['baozhangID'])
		{
			$postdata['time'] = time();
			$postdata['adduser'] = $this->roleuser['user_name'];
			$postdata['edituser'] = $this->roleuser['user_name'];
			$newid = $DJbaozhang->add($postdata);
			if(!$forword)
				$forword = SITE_DIJIE."Tuancontrol/baozhangdan/djtuanID/".$newid;
			if($newid)
				doalert("保存成功",$forword);
			else
				doalert("新建失败",$forword);
		}
		else
		{
			$record = $DJbaozhang->where("`baozhangID` = '$postdata[baozhangID]'")->find();
			if($postdata['attachment'])
				unlink("data/".$record['attachment']);
				
			if(!checkByAdminlevel('总经理,网管,财务操作员',$this))
			if($record['manager'] || $record['departmentperson'] || $record['financeperson'])
			{
					$postdata['status'] = '计调申请';
					$postdata['manager'] = '';
					$postdata['departmentperson'] = '';
					$postdata['financeperson'] = '';
			}
				
			$DJbaozhang->save($postdata);
			if(!checkByAdminlevel('总经理,网管,财务操作员',$this)){
				if($record['manager'] || $record['departmentperson'] || $record['financeperson'])
					doalert("修改成功,但报账审核失效，请重新报账",$forword);
				doalert("修改成功",$forword);
			}
			else
			doalert("修改成功",$forword);
			
		}
		
    }
	
	
	
//	
//    public function addbaozhangitem() {
//			
//		$postdata = $_POST;
//		foreach($_POST as $key => $value ){
//			$item[$key] = $value;
//		}
//		$DJbaozhangitem = D('dj_baozhangitem');
//		if($item['baozhangID'] == 'undefined'){
//			echo "false";
//			exit;
//		}
//		$item['time'] = time();
//		$item['edituser'] = $this->roleuser['user_name'];
//		$newid = $DJbaozhangitem->add($item);
//		echo $newid;
//	}
//	

    public function editbaozhangitem() {
			
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		$DJbaozhangitem = D('dj_baozhangitem');
		if($item['baozhangitemID'] == 'undefined'){
			echo "false";
			exit;
		}
		$DJbaozhangitem->save($item);
		echo 'true';
	}
	

	
    public function deletebaozhangitem() {
			
		$postdata = $_POST;
		$DJbaozhangitem = D('dj_baozhangitem');
		$DJbaozhangitem->where('baozhangitemID='.$postdata['baozhangitemID'])->delete();
		echo 'true';
	}
	
	
    public function baozhangcountdata($id = null) {
		if($id)	
		$baozhangID = $id;
		else
		$baozhangID = $_POST['baozhangID'];
		$DJbaozhangitem = D('dj_baozhangitem');
		$itemAll = $DJbaozhangitem->where('baozhangID='.$baozhangID)->findall();
			$shouru = 0;
			$zhichu = 0;
			$qita = 0;
		foreach($itemAll as $item){
			if($item['type'] == '结算项目')
			$shouru += $item['price'];
			if($item['type'] == '支出项目')
			$zhichu += $item['price'];
			if($item['type'] == '项目')
			$qita += $item['price'];
		}
		
		$maoli = $shouru - $zhichu + $qita;
		
		if($id)	
		return '收入合计:'.$shouru.'元，支出合计:'.$zhichu.'元，其他项目:'.$qita.'元，毛利小计:'.$maoli.'元';
		elseif($baozhangID)
		echo '收入合计:'.$shouru.'元，支出合计:'.$zhichu.'元，其他项目:'.$qita.'元，毛利小计:'.$maoli.'元';
	}
	
	
	
    public function baozhangheji($baozhangID = null, $type = null) {
		if($_POST){
			$baozhangID = $_POST['baozhangID'];
			$type = $_POST['type'];
		}
		$DJbaozhangitem = D('dj_baozhangitem');
		$itemAll = $DJbaozhangitem->where('baozhangID='.$baozhangID)->findall();
		$shouru = 0;
		$xianjin = 0;
		$zhipiao = 0;
		$huikuan = 0;
		$wangbo = 0;
		$yinhangka = 0;
		$zhuanzhang = 0;
		foreach($itemAll as $item){
			if($item['type'] == $type){
			$shouru += $item['price'];
				if($item['pricetype'] == '现金')
				$xianjin += $item['price'];
				if($item['pricetype'] == '支票')
				$zhipiao += $item['price'];
				if($item['pricetype'] == '汇款')
				$huikuan += $item['price'];
				if($item['pricetype'] == '网拨')
				$wangbo += $item['price'];
				if($item['pricetype'] == '银行卡')
				$yinhangka += $item['price'];
				if($item['pricetype'] == '转账')
				$zhuanzhang += $item['price'];
			}
		}
		
		if($_POST)
		echo '结算合计:'.$shouru.'元，现金:'.$xianjin.'元，支票:'.$zhipiao.'元，汇款:'.$huikuan.'元，网拨:'.$wangbo.'元，银行卡:'.$yinhangka.'元，转账:'.$zhuanzhang.'元';
		else
		return '结算合计:'.$shouru.'元，现金:'.$xianjin.'元，支票:'.$zhipiao.'元，汇款:'.$huikuan.'元，网拨:'.$wangbo.'元，银行卡:'.$yinhangka.'元，转账:'.$zhuanzhang.'元';
	}
	
	
	
	
    public function travelnoticelist() {
		
		$navlist = "团队管理 > 团队控管";
		$this->assign('navlist',$navlist);
		
		$DJtuan = D('dj_tuan');
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'type')
			break;
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		$condition['status'] = '在线';
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $DJtuan->where($condition)->count();
		$p= new Page($count,10);
		//$rurl = SITE_DIJIE."Tuancontrol/tuanlist/p/";
		$page = $p->show();
        $tuanAll = $DJtuan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		
		$this->assign('page',$page);
		$this->assign('tuanAll',$tuanAll);
		$this->display();
		
    }
	
	
    public function orderhotellist() {
		
		$navlist = "团队管理 > 团队控管 > 订房确认单列表";
		$this->assign('navlist',$navlist);
		
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'pagenum'|| $key == 'iframe')
			continue;
			if($key == 'time1' || $key == 'time2')
			{
				$urlitem .= $key.'/'.$value;
				$this->assign($key,$value);
				continue;
			}
			$urlitem .= $key.'/'.$value;
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		$start =date( "Y-m",strtotime($_GET['time1'])); 
		$end =date( "Y-m",strtotime($_GET['time2'])); 
		if($_GET['time1'] && $_GET['time2'])	
			$condition['orderdate'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$condition['orderdate'] = array('egt',$start);
		elseif($_GET['time2'])
			$condition['orderdate'] = array('elt',$start);
		

		//查询分页
		$DJorderhotel = D('dj_orderhotel');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $DJorderhotel->where($condition)->count();
		$pagenum = $_GET['pagenum'];
		if(!$pagenum)
			$pagenum = 15;
		$p= new Page($count,$pagenum);
		$forward = SITE_DIJIE."Tuancreate/tuanlist/".$urlitem."/p/";
		$page = $p->show($forward);
		$this->assign('page',$page);
        $orderhotelAll = $DJorderhotel->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();

		$dj_tuan = D("dj_tuan");
		$i = 0;
		foreach($orderhotelAll as $v){
			$tuan = $dj_tuan->where("`djtuanID` = '$v[djtuanID]'")->find();
			$orderhotelAll[$i]['tuan'] = $tuan;
			$i ++;
		}
		$this->assign('orderhotelAll',$orderhotelAll);
		
        $this->display();
	
	}
	
	
    public function doduizhang() {
		
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
		
		$status = $_GET['status'];
		if($status == '已对账')
			$changedata['status'] = '已对账';
		if($status == '未对账')
			$changedata['status'] = '未对账';
		
		$DJorderhotel = D('dj_orderhotel');
		
		foreach($itemlist as $item){
			$changedata['orderhotelID'] = $item;
			$DJorderhotel->save($changedata);
		}
		
		doalert($changedata['status'].'成功','');

	}
	
	

    public function dolockorderhotel() {
		
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
		
		$islock = $_GET['islock'];
		if($islock == '已锁定')
			$changedata['islock'] = '已锁定';
		if($islock == '未锁定')
			$changedata['islock'] = '未锁定';
		
		$DJorderhotel = D('dj_orderhotel');
		
		foreach($itemlist as $item){
			$changedata['orderhotelID'] = $item;
			$DJorderhotel->save($changedata);
		}
		
		doalert($changedata['islock'].'成功','');

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
		$this->assign('printable','打印');
		if($_GET['doprint'] == 1)
		$this->display('print_chengbenjisuan_riben');
		else
        $this->display();
		
	}



	
	
	function baozhangitemlist()
	{
		
		$djtuanID = $_GET['djtuanID'];
		
		$dj_tuan = D("dj_tuan");
		$djtuan = $dj_tuan->where("`djtuanID` = '$djtuanID'")->find();
		
		if($djtuan)
		{
			$this->assign('tuan',$djtuan);
			$this->assign('djtuan',$djtuan);
			$this->assign('djtuanID',$_GET['djtuanID']);
		}
		else
		doalert("错误",'/');
		
		$dj_baozhang = D("dj_baozhang");
		$baozhang = $dj_baozhang->where("`djtuanID` = '$djtuanID'")->find();
	//dump($baozhang);exit;
		if(!$baozhang) doalert("请先保存报账单，然后才能添加收入，支出项！",'');
	
		$dj_baozhangitem = D("dj_baozhangitem");
		
		if($_GET['showtype'] == '收入')
		{
			$this->assign('location','收入');
			$this->assign('navtile','收入项列表');
			$itemAll = $dj_baozhangitem->order("time desc")->where("`type` = '结算项目' and `baozhangID` = '$baozhang[baozhangID]'")->findall();
		}
		if($_GET['showtype'] == '支出'){
			$this->assign('location','支出');
			$this->assign('navtile','请款单	');
			$itemAll = $dj_baozhangitem->order("time desc")->where("`type` = '支出项目' and `baozhangID` = '$baozhang[baozhangID]'")->findall();
		}
		$this->assign('showtype',$_GET['showtype']);
		$this->assign('itemAll',$itemAll);
		
		$this->assign('showtype_2',$_GET['showtype_2']);
        $this->display();
	}
	
	
    public function ajax_addbaozhangitem() {
			
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		if($item['baozhangID'] == 'undefined'){
			echo "false";
			exit;
		}
		$item['time'] = time();
		$item['edituser'] = $this->roleuser['user_name'];
		
		if($item['type'] == '利润')
		{
			$item['check_status'] = '审核通过';
		}
		$dj_baozhang = D("dj_baozhang");
		$baozhang = $dj_baozhang->where("`baozhangID` = '$item[baozhangID]'")->find();
		
//		if($baozhang['status']=='经理通过' || $baozhang['status']=='财务通过' || $baozhang['status']=='总经理通过')
//		{
//			echo "false";
//			exit;
//		}
		$dj_baozhangitem = D('dj_baozhangitem');
		$newid = $dj_baozhangitem->add($item);
		
		echo $newid;
	}
	
	function addbaozhangitem()
	{
		
		$dj_tuan = D("dj_tuan");
		$dj_baozhang = D("dj_baozhang");
		if($_GET['baozhangitemID'])
		{
			$baozhangitemID =$_GET['baozhangitemID'];
			$dj_baozhangitem = D("dj_baozhangitem");
			$item = $dj_baozhangitem->where("`baozhangitemID` = '$baozhangitemID'")->find();
			$this->assign('item',$item);
			$baozhangID = $item['baozhangID'];
			$baozhang = $dj_baozhang->where("`baozhangID` = '$baozhangID'")->find();
			$djtuanID = $baozhang['djtuanID'];
			if($item['type'] =='结算项目')
			$showtype = '收入';
			if($item['type'] =='支出项目')
			$showtype = '支出';
		}
		else
		{
			$this->assign('showtype',$_GET['showtype']);
			$djtuanID = $_GET['djtuanID'];
			$baozhang = $dj_baozhang->where("`djtuanID` = '$djtuanID'")->find();
		}
		$this->assign('baozhang',$baozhang);
			
		if(!$showtype)	
			$showtype = $_GET['showtype'];
		$this->assign('showtype',$showtype);
		$this->assign('location',$showtype);
		if($showtype == '收入')
		{
			$this->assign('navtile','其他应收款列表');
			$this->assign('type','结算项目');
		}
		if($showtype == '支出')
		{
			$this->assign('navtile','请款单');
			$this->assign('type','支出项目');
		}
			
		$djtuan = $dj_tuan->where("`djtuanID` = '$djtuanID'")->find();
		if($djtuan){
		$this->assign('tuan',$djtuan);
		$this->assign('djtuan',$djtuan);
		}
		else
		doalert("错误",'/');
		
		$baozhang = $dj_baozhang->where("`djtuanID` = '$djtuan[djtuanID]'")->find();
		if(!$baozhang)
		{
			$dj_baozhang = D('dj_baozhang');
			$t['djtuanID'] = $djtuan['djtuanID'];
			$t['time'] = time();
			$baozhangID = $dj_baozhang->add($t);
		}
		
		
		$this->assign('djtuan',$djtuan);
		
		$this->assign('showtype_2',$_GET['showtype_2']);
        $this->display();
	}
	
	
	function dopostbaozhangitem()
	{
		
		foreach($_POST as $key => $value)
		{
			$postdata[$key] = $value;
		}
		if(!$postdata['title'])
				doalert("操作失败，请填写标题",'');
		if($_POST['type'] == '结算项目'){
			$showtype = '收入';
			$postdata['type'] = '结算项目';
		}
		if($_POST['type'] == '支出项目'){
			$showtype = '支出';
			$postdata['type'] = '支出项目';
		}
		
		$postdata['time'] = time();
		$postdata['edituser'] = $this->roleuser['user_name'];		
				
		$dj_baozhang = D("dj_baozhang");
		$baozhang = $dj_baozhang->where("`baozhangID` = '$postdata[baozhangID]'")->find();
		if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
		{
			//if($baozhang['status'] == '财务通过')	
			if($baozhang['financeperson'])	
				doalert("报账单已被审核通过，不能删除和修改",'');
			$postdata['check_status'] = '准备';
			$postdata['manager'] = '';
			$postdata['zong_manager'] = '';
			$postdata['check_user'] = '';
		}
		
		$dj_baozhangitem = D("dj_baozhangitem");
		if($postdata['baozhangitemID'])
		{
			$item = $dj_baozhangitem->where("`baozhangitemID` = '$postdata[baozhangitemID]'")->find();
			if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
			{
				if($item['check_status'] == '审核通过')
					doalert("操作失败，该项目已经被通过",'');
			}
				
			if($item['type'] == '结算项目')
				$showtype = '收入';
			if($item['type'] == '支出项目')
				$showtype = '支出';
			
			if($item['departmentID'])
				doalert("此项目为订单，不允许修改及删除",SITE_ADMIN.'Tuancontrol/baozhangitemlist/showtype/'.$showtype.'/djtuanID/'.$postdata['djtuanID']);
			$dj_baozhangitem->save($postdata);
			
		}
		else
		$dj_baozhangitem->add($postdata);
		
		doalert("操作成功",SITE_DIJIE.'Tuancontrol/baozhangitemlist/showtype/'.$showtype.'/djtuanID/'.$postdata['djtuanID']);
	
	}
	
	
	
	function deleteitem()
	{
		$dj_baozhangitem = D("dj_baozhangitem");
		$baozhangitemID = $_GET['baozhangitemID'];
		$item = $dj_baozhangitem->where("`baozhangitemID` = '$baozhangitemID'")->find();
			
		if(!$item)
			doalert("错误",'/');
			
		if($item['type'] == '结算项目')
			$showtype = '收入';
		if($item['type'] == '支出项目')
			$showtype = '支出';
		
		$dj_baozhang = D("dj_baozhang");
		$baozhang = $dj_baozhang->where("`baozhangID` = '$item[baozhangID]'")->find();	
		
		if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
		{
			if($baozhang['status'] == '财务通过')	
				doalert("报账单已被审核通过，不能删除和修改",'');
		}
			
//		if($item['departmentID'])
//				doalert("此项目为订单，不允许修改及删除",SITE_ADMIN.'Tuancontrol/baozhangitemlist/showtype/'.$showtype.'/djtuanID/'.$baozhang['djtuanID']);
			
		if($item['check_status'] == '审核通过')
			doalert("操作失败，该项目已经被通过",'/');
		if($item['edituser'] != $this->roleuser['user_name'])
			doalert("操作失败，没有权限",'/');
			
		$dj_baozhangitem->where("`baozhangitemID` = '$baozhangitemID'")->delete();
			
		doalert("操作成功",'');
		
	}
	
	function itemshenhe()
	{
		$dj_baozhangitem = D("dj_baozhangitem");
		$baozhangitemID = $_GET['baozhangitemID'];
		$item = $dj_baozhangitem->where("`baozhangitemID` = '$baozhangitemID'")->find();
		if(!$item)
		doalert("错误",'');
		
		$dj_baozhang = D("dj_baozhang");
		$baozhang = $dj_baozhang->where("`baozhangID` = '$item[baozhangID]'")->find();	
//		if($baozhang['status'] == '财务通过')	
//			doalert("报账单已被审核通过，不能删除和修改",'');
		
//		if($item['check_status'] == '审核通过')
//			doalert("操作失败，该项目已经被通过");
		
		if($_GET['roletype'] == '经理')
		{
			if(!checkByAdminlevel('网管,地接经理,财务操作员,总经理',$this))
				doalert("你没有操作权限",'');
			
			if($item['check_user'])
				doalert("无法操作。财务已经审核过",'');
			
			//-----add no pass by heavenK-------
			if($_GET['dotype'] == '审核通过')	
			{
				$item['manager'] = $this->roleuser['user_name'];	
				$item['check_status'] = '经理确认';
			}
			if($_GET['dotype'] == '审核不通过')	
			{
			$item['manager'] = '';	
			$item['check_status'] = '审核不通过';
			}
			//-----end------
			
			$userlist = '财务操作员,网管';
		}
		if($_GET['roletype'] == '财务')
		{
			if($item['zong_manager'])
				doalert("无法操作。总经理已经审核过",'');
		
			if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
				doalert("你没有操作权限",'');
			if($_GET['dotype'] == '审核通过')	
			{
				$item['check_user'] = $this->roleuser['user_name'];	
				$item['check_status'] = '审核通过';
				$item['check_time'] = time();
			}
			if($_GET['dotype'] == '审核不通过')	
			{
			$item['check_user'] = '';	
			$item['check_status'] = '审核不通过';
			$item['check_time'] = time();
			}
			$userlist = '地接经理,地接操作员,网管';
		}
		if($_GET['roletype'] == '总经理')
		{
			//edit by gaopeng 2012 3 6
			if($item['zong_manager'])
				doalert("无法操作。总经理已经审核过",'');
			//end
			
			
			//-----add no pass by heavenK-------
			if($_GET['dotype'] == '审核通过')	
			{
				$item['zong_manager'] = $this->roleuser['user_name'];	
			}
			if($_GET['dotype'] == '审核不通过')	
			{
			$item['zong_manager'] = '';	
			$item['check_status'] = '审核不通过';
			}
			//--------end-----------
			
			
			$userlist = '财务操作员,地接经理,地接操作员,网管';
		}
		
		
		if($_GET['dotype'] == '等待审核')
		{
			$item['check_status'] = '等待审核';		
		}
		elseif($_GET['dotype'] == '审核通过')
		{
			if(!checkByAdminlevel('网管,地接经理,财务操作员,总经理',$this))
				doalert("你没有操作权限",'');
			$megurl = SITE_DIJIE."Tuancontrol/addbaozhangitem/baozhangitemID/".$baozhangitemID;
			A("Message")->savemessage($item['baozhangID'],'报账单','审核记录',$_GET['roletype'].'已对应收项审核通过',$userlist,$megurl);
		}
		
		$dj_baozhangitem->save($item);
		
		
		if($item['type'] == '结算项目')
			$showtype = '收入';
		if($item['type'] == '支出项目')
			$showtype = '支出';
		
		doalert("操作成功",SITE_DIJIE.'Tuancontrol/baozhangitemlist/roletype//showtype_2/审核/showtype/'.$showtype.'/djtuanID/'.$baozhang['djtuanID']);
		
	}
	
	













}
?>