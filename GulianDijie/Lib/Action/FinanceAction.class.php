<?php

class FinanceAction extends CommonAction{

    public function index() {
        $this->redirect('/Finance/tuanlist/type/在线团队');
    }
	
    public function tuanlist() {
		
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
		//$rurl = SITE_DIJIE."Finance/tuanlist/p/";
		$page = $p->show();
        $tuanAll = $DJtuan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		
		$this->assign('page',$page);
		$this->assign('tuanAll',$tuanAll);
		
		$type = $_GET['type'];
		$navlist = "财务管理 > 财务管理 > ".$type;
		
		$this->assign('navlist',$navlist);
		
		if($type == '带团通知单')
		$this->display('travelnoticelist');
		elseif($type == '付款申请单')
		$this->display('applypaymentlist');
		elseif($type == '收据清单')
		$this->display('receiptlist');
		elseif($type == '订房确认单')
		$this->display('orderhotellist');
		elseif($type == '报账单')
		$this->display('baozhangdanlist');
		else
		$this->display();
		
    }
	


    public function tuaninfo() {
		
		$navlist = "财务管理 > 财务管理 > 基本信息";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		
		$DJtuan = D('dj_tuan');
        $tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		
		$this->assign('location','基本信息');
		$this->assign('tuan',$tuan);
        $this->display();
    }
	



    public function itinerary() {
		
		$navlist = "财务管理 > 财务管理 > 日程安排";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		if(!$forword)
			$forword = SITE_DIJIE."Finance/appraise/djtuanID/".$djtuanID;
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Finance/tuanlist");
		$this->assign('tuan',$tuan);
		
		$DJitinerary = D('dj_itinerary');
		$itinerary = $DJitinerary->where("`djtuanID` = '$djtuanID'")->find();
		$this->assign('itinerary',$itinerary);
		
		$DJrcitem = D('dj_rcitem');
		$rcitemAll = $DJrcitem->where("`itineraryID` = '$itinerary[itineraryID]'")->findall();
		$this->assign('rcitemAll',$rcitemAll);
		
		$this->assign('location','日程安排');
        $this->display();
	}
	


    public function appraisal() {
		$navlist = "财务管理 > 财务管理 > 估价";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Finance/tuanlist");
		$this->assign('tuan',$tuan);
			
		$DJappraisal = D('dj_appraisal');
		$appraisalAll = $DJappraisal->where("`djtuanID` = '$djtuanID'")->findall();
		foreach($appraisalAll as $item){
			$price += $item['price'];
		}
		$this->assign('totalprice',$price);
		
		$this->assign('location','估价');
		$this->assign('appraisalAll',$appraisalAll);
        $this->display();
	}
	
	
    public function travelnotice() {
		$navlist = "财务管理 > 财务管理 >带团通知单";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		if(!$forword)
			$forword = SITE_DIJIE."Tuancreate/appraise/djtuanID/".$djtuanID;
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Finance/tuanlist");
		$this->assign('tuan',$tuan);
		
		$DJitinerary = D('dj_itinerary');
		$itinerary = $DJitinerary->where("`djtuanID` = '$djtuanID'")->find();
		$this->assign('itinerary',$itinerary);
		
		$DJrcitem = D('dj_rcitem');
		$rcitemAll = $DJrcitem->where("`itineraryID` = '$itinerary[itineraryID]'")->findall();
		$this->assign('rcitemAll',$rcitemAll);
		
		$this->assign('location','带团通知单');
		$this->assign('printable','打印');
		
		if($_GET['doprint'])
			$this->display('printtravelnotice');
		else	
        $this->display();
	}



	
    public function applypayment() {
		
		$navlist = "财务管理 > 财务管理 > 付款申请单";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Finance/tuanlist");
		$this->assign('tuan',$tuan);
		
		$DJapplypayment = D('dj_applypayment');
		$paymentAll = $DJapplypayment->where("`djtuanID` = '$djtuanID'")->findall();
		$this->assign('paymentAll',$paymentAll);
		
		$this->assign('location','付款申请单');
        $this->display();
	}
	

    public function docheck() {
			
		$postdata = $_POST;
		$item['applypaymentID'] = $postdata['applypaymentID'];
		if($postdata['type'] == '审核通过'){
			$item['status'] = '审核通过';
		}
		if($postdata['type'] == '审核不通过'){
			$item['status'] = '审核不通过';
		}
		$DJapplypayment = D('dj_applypayment');
		if($item['applypaymentID'] == null){
			echo "false";
			exit;
		}
		$DJapplypayment->save($item);
		echo $item['status'];
	}
	

    public function receipt() {
		$navlist = "财务管理 > 财务管理 > 收据清单";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Finance/tuanlist");
		$this->assign('tuan',$tuan);
		
		$DJreceipt = D('dj_receipt');
		$receiptAll = $DJreceipt->where("`djtuanID` = '$djtuanID'")->findall();
		$this->assign('receiptAll',$receiptAll);
		
		$this->assign('location','收据清单');
        $this->display();
	}
	

	
    public function orderhotel() {
		$navlist = "财务管理 > 财务管理 > 订房确认单";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Finance/tuanlist");
		$this->assign('tuan',$tuan);
		
		$DJorderhotel = D('dj_orderhotel');
		$orderhotel = $DJorderhotel->where("`djtuanID` = '$tuan[djtuanID]'")->find();
		$this->assign('orderhotel',$orderhotel);
		$this->assign('location','订房确认单');
		$this->assign('printable','打印');
		
		if($_GET['doprint'])
			$this->display('printorderhotel');
		else	
        $this->display();
	}

	

	
    public function baozhangdan() {
		$navlist = "团队管理 > 团队控管 > 报账单";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_DIJIE."Finance/tuanlist");
		$this->assign('tuan',$tuan);
		
		$DJbaozhang = D('dj_baozhang');
		$baozhang = $DJbaozhang->where("`djtuanID` = '$tuan[djtuanID]'")->find();
		$this->assign('baozhang',$baozhang);
		$this->assign('location','报账单');
		$this->assign('printable','打印');
		
		$DJbaozhangitem = D('dj_baozhangitem');
		$itemAll = $DJbaozhangitem->where("`baozhangID` = '$baozhang[baozhangID]'")->findall();
		$this->assign('itemAll',$itemAll);
		
		$countdata = $this->baozhangcountdata($baozhang['baozhangID']);
		$this->assign('countdata',$countdata);
		
		$jiesuanheji = $this->baozhangheji($baozhang['baozhangID'],'结算项目');
		$this->assign('jiesuanheji',$jiesuanheji);
		
		$zhichuheji = $this->baozhangheji($baozhang['baozhangID'],'支出项目');
		$this->assign('zhichuheji',$zhichuheji);
		
		if($_GET['doprint'])
			$this->display('printbaozhangdan');
		else	
        $this->display();
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
		
		
		if($_POST)
		echo '收入合计:'.$shouru.'元，支出合计:'.$zhichu.'元，其他项目:'.$qita.'元，毛利小计:'.$maoli.'元';
		else
		return '收入合计:'.$shouru.'元，支出合计:'.$zhichu.'元，其他项目:'.$qita.'元，毛利小计:'.$maoli.'元';
		
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
	
	

    public function doprint() {
		
		$djtuanID = $_GET['djtuanID'];
		if($_GET['type'] == '带团通知单')
			$this->redirect('/Finance/travelnotice/doprint/1/djtuanID/'.$djtuanID);
		if($_GET['type'] == '付款申请单')
			$this->redirect('/Finance/printapplypayment/doprint/1/djtuanID/'.$djtuanID);
		if($_GET['type'] == '收据清单')
			$this->redirect('/Finance/printshouju/doprint/1/djtuanID/'.$djtuanID);
		if($_GET['type'] == '订房确认单')
			$this->redirect('/Finance/orderhotel/doprint/1/djtuanID/'.$djtuanID);
		if($_GET['type'] == '报账单')
			$this->redirect('/Finance/baozhangdan/doprint/1/djtuanID/'.$djtuanID);
			
		else
			$this->display('Error/error404');

    }
	


}
?>