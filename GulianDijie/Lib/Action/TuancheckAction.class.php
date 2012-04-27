<?php

class TuancheckAction extends CommonAction{
	
	
    public function checklist() {
		
		$navlist = "团队管理 > 报价审核";
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
		$condition['status'] = '报价审核';
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $DJtuan->where($condition)->count();
		$p= new Page($count,10);
		//$rurl = SITE_DIJIE."Tuancheck/checklist/p/";
		$page = $p->show();
        $tuanAll = $DJtuan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		
		$this->assign('page',$page);
		$this->assign('tuanAll',$tuanAll);
		$this->display();
		
    }
	
	
    public function tuaninfo() {
		
		$navlist = "团队管理 > 报价审核 > 基本信息";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		
		$DJtuan = D('dj_tuan');
        $tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		
		$this->assign('location','基本信息');
		$this->assign('tuan',$tuan);
        $this->display();
    }
	
	
    public function itinerary() {
		$navlist = "团队管理 > 报价审核 > 日程安排";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		if(!$forword)
			$forword = SITE_DIJIE."Tuancreate/appraise/djtuanID/".$djtuanID;
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",'');
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
		$navlist = "团队管理 > 报价审核 > 估价";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",'');
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
	
    public function docheck() {
			
		$forward = _getforword();
		$djtuanID = $_GET['djtuanID'];
		$tuan['djtuanID'] = $djtuanID;
		$type = $_GET['type'];
		if($type == '审核通过')
		$tuan['status'] = '询价';
		if($type == '审核不通过')
		$tuan['status'] = '准备';
		
		$DJtuan = D('dj_tuan');
		$DJtuan->save($tuan);
		//记录 savemessage($tableID,$tablename,$type,$content)
		A("Message")->savemessage($djtuanID,'地接团队','审核记录',$type);
		doalert($type,$forward);
	}
	
	
	
	
	
	
	
	
	
	

}
?>