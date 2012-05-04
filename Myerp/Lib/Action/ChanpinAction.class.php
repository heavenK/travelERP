<?php

class ChanpinAction extends Action{

	
    public function index() {
		//搜索
		$kind = $_GET['kind'];
		$guojing = $_GET['guojing'];
		$navlist = '线路产品发布 》  '.$_GET['guojing'].' 》  '.$_GET['xianlutype'].' 》 '.$_GET['kind'];
        $this->assign('navlist',$navlist);
		
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'chufariqi' || $key == 'jiezhiriqi'){
				continue;
			}
			if($key == 'zhuangtai' || $value == '全部' )
				$condition['zhuangtai'] = array('in','报名,截止'); 	
			else
				$condition[$key] = array('like','%'.$value.'%');
		}
		$start_date = $_GET['chufariqi'];
		$end_date = $_GET['jiezhiriqi'];
		if ($start_date && $end_date){
			$condition['chutuanriqi'] = array(array('like','%'.$start_date.'%'),array('like','%'.$end_date.'%'),'or');
		}
		elseif ($end_date){
			$condition['chutuanriqi'] = array('like','%'.$end_date.'%'); 	
		}
		elseif ($start_date){
			$condition['chutuanriqi'] = array('like','%'.$start_date.'%'); 	
		}
		if(!$condition['zhuangtai'])
			$condition['zhuangtai'] = array('in','准备,审核不通过,等待审核'); 	
		//查询
		$chanpin_list = D('Chanpin')->chanpin_list();
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		//dump($chanpin_list);
		$this->display('Chanpin/index');
    }
	
	
	public function message() {
		$chanpinID = $_POST['chanpinID'];
		$myerp_message=D("myerp_message");
		$message = $myerp_message->where("`chanpinID` = '$chanpinID'")->findall();
		echo json_encode($message);
	}
	
	public function showheader() {
		$this->display('Chanpin/header');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>