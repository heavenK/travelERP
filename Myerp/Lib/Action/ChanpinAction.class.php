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
		$this->display('Chanpin/index');
    }
	
	public function fabu() {
		$chanpinID = $_REQUEST["chanpinID"];
		$myerpview_chanpin_xianlu = D('myerpview_chanpin_xianlu');
		$xianlu = $myerpview_chanpin_xianlu->where("`chanpinID` = '$chanpinID'")->find();
		$this->assign("xianlu",$xianlu);
		$this->display('Chanpin/fabu');
	}
	
	public function dopostfabu() {
		$Chanpin = D("Chanpin");
        if ($Chanpin->create()) { 
            if (false !== $Chanpin->add()) { 
                $this->success('数据添加成功！'); 
            } else { 
                $this->error($Chanpin->getError()); 
            } 
        } else { 
			$this->error($Chanpin->getError()); 
        } 
	
	}
	
	public function xingcheng()
	{
		$chanpinID = $_REQUEST["chanpinID"];
		$myerpview_chanpin_xianlu = D('myerpview_chanpin_xianlu');
		$xianlu = $myerpview_chanpin_xianlu->where("`chanpinID` = '$chanpinID'")->find();
		
		$Xingcheng = D("xingcheng");
		$xingchengAll = $Xingcheng->where("`chanpinID` = '$chanpinID'")->findall();
		$this->assign("xianlu",$xianlu);
		$this->assign("xingchengAll",$xingchengAll);
		$this->display('Chanpin/xingcheng');
	}
	
	
	
	
	public function message() {
		$chanpinID = $_POST['chanpinID'];
		$myerp_message=D("myerp_message");
		$message = $myerp_message->where("`chanpinID` = '$chanpinID'")->findall();
		echo json_encode($message);
	}
	
	public function left_fabu() {
		$this->display('Chanpin/left_fabu');
	}
	
	public function showheader() {
		$this->display('Chanpin/header');
	}
	
	public function footer() {
		$this->display('Chanpin/footer');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>