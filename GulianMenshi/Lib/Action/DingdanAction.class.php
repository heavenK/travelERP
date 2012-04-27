<?php

class DingdanAction extends CommonAction{

    public function index_nav() {
		//大客户
		$glbasedata = D('glbasedata');
		$bigmanAll = $glbasedata->where("`type` = '大客户'")->findall();
        $this->assign('bigmanAll',$bigmanAll);
		
        $this->display();
    }
	
    public function sankedingdan() {
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'iframe' || $key == 'pagenum'|| $key == 'showtype')
			{
				$urlitem.= '/'.$key.'/'.$value;
				continue;
			}
			if($key == 'time1' || $key == 'time2')
			{
				$urlitem.= '/'.$key.'/'.$value;
				$this->assign($key,$value);
				continue;
			}
			if ($key == 'zituanID' || $key == 'kind' || $key == 'guojing' || $key == 'xianlutype' )	{
				$condition[$key] = $value;
				continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		$start =strtotime($_GET['time1'].'-0'); 
		$end =strtotime($_GET['time2'].'-0'); 
		if($_GET['time1'] && $_GET['time2'])	
			$condition['time'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$condition['time'] = array('egt',$start);
		elseif($_GET['time2'])
			$condition['time'] = array('elt',$start);
			
		if($_GET['check_status'] == '所有')	
			unset($condition['check_status']);
		if($_GET['check_status'] == '')	
			$condition['check_status'] = '审核通过';
		if($_GET['check_status'] == '等待审核')	
			$condition['check_status'] = array('IN','等待审核,审核不通过');
			
//		if($_GET['showtype'] == '审核')
//			$condition['check_status'] = '等待审核';
			
		//搜索结束
		$navlist = '订单管理 > '.$condition['guojing'].' > '.$condition['xianlutype'].' >' .$condition['kind'] ;
        $this->assign('navlist',$navlist);
		
		$condition = listmydepartment_dingdan($this,$condition);
		//同业，办事处相应修改   by gaoyang
		if(checkByAdminlevel('办事处管理员',$this)){
			$condition['lvxingsheID']	=	$this->roleuser["lvxingsheID"]; //取得
		}
		//修改结束 by gaoyang
			
		
		//dump($condition);
		//$Gldingdan = D("dingdan_zituan_all");
		$Gldingdan = D("dingdan_xianlu_lvxingshe");
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $Gldingdan->where($condition)->count();
		
		$pagenum = $_GET['pagenum'];
		if(!$pagenum)
		$pagenum = 20;
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $dingdanAll = $Gldingdan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $this->assign('page',$page);
		$glkehu = D("glkehu");
		$glbasedata = D("glbasedata");
		$gllvxingshe = D("gllvxingshe");
		$Gltuanyuan = D('gltuanyuan');
		$i= 0;
		foreach($dingdanAll as $dingdan){
			$chengrenshu = $Gltuanyuan->where("`manorchild` = '成人' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			$ertongshu = $Gltuanyuan->where("`manorchild` = '儿童' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			$renshu = $chengrenshu + $ertongshu;
			$dingdanAll[$i]['chengrenshu'] = $chengrenshu;
			$dingdanAll[$i]['ertongshu'] = $ertongshu;
			$dingdanAll[$i]['renshu'] = $renshu;
			
			$company = $gllvxingshe->where("`lvxingsheID` = '$dingdan[laiyuan]'")->find();
			$dingdanAll[$i]['laiyuan'] = $company['companyname'];
			
			//部门用户
			$user = $glkehu->where("`user_name` = '$dingdan[user_name]'")->find();
			$department = $glbasedata->where("`id` = '$user[department]'")->find();
			$dingdanAll[$i]['realname'] = $user['realname'];
			$dingdanAll[$i]['department'] = $department['title'];
			
			$i++;
		}
		
        $this->assign('dingdanAll',$dingdanAll);
		
		if($_GET['iframe'] == 1)
        $this->display('mydingdan');
		elseif($_GET['iframe'] == 's1')
        $this->display('AdminShenhe/dingdanlist');
		else
		{
			if($_GET['showtype'] == '审核')
        	$this->display('AdminShenhe/sankedingdan');
			else
        	$this->display();
			
		}
    }
	
    private function getzituanrenshu($zituanID) 
	{
		  $zituan_xianlu = D("zituan_xianlu_lvxingshe");
		  $zituan = $zituan_xianlu->where("`zituanID` = '$zituanID'")->find();
		  $Gltuanyuan = D("tuanyuan_dingdan");
		  $Gldingdan = D("dingdan_zituan");
		  $dingdanAll = $Gldingdan->where("`zituanID` = '$zituan[zituanID]'")->findall();
		  $querennum = 0;
		  $zhanweinum = 0;

		  foreach($dingdanAll as $dingdan)
		  {
			  	  if($zituan['ischild']){
					  $querennum += $Gltuanyuan->where("`zhuangtai` = '确认' and `dingdanID` = '$dingdan[dingdanID]' and `manorchild` = '成人'")->count();
					  $zhanweinum += $Gltuanyuan->where("`zhuangtai` = '占位' and `dingdanID` = '$dingdan[dingdanID]' and `manorchild` = '成人'")->count();
  
				  }else{
					  $querennum += $Gltuanyuan->where("`zhuangtai` = '确认' and `dingdanID` = '$dingdan[dingdanID]'")->count();
					  $zhanweinum += $Gltuanyuan->where("`zhuangtai` = '占位' and `dingdanID` = '$dingdan[dingdanID]'")->count();
				  }
			  
		  }
		  $shengyu = $zituan['renshu'] - $querennum - $zhanweinum;
		  return $shengyu;
	}
	
	
    public function dingdanxinxi() {
		$dingdanID = $_GET['dingdanID'];
		//$Gldingdan = D("dingdan_zituan_all");
		$Gldingdan = D("dingdan_lvxingshe_department");
		$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		
		$Gltuanyuan = D("gltuanyuan");
		$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdanID'")->findall();
		
		$chengrenshu = $Gltuanyuan->where("`manorchild` = '成人' and `dingdanID` = '$dingdan[dingdanID]'")->count();
		$ertongshu = $Gltuanyuan->where("`manorchild` = '儿童' and `dingdanID` = '$dingdan[dingdanID]'")->count();
        $this->assign('chengrenshu',$chengrenshu);
        $this->assign('ertongshu',$ertongshu);
		$renshu = $chengrenshu + $ertongshu;
		
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$dingdan[zituanID]'")->find();
		//剩余名额
		$shengyu = $this->getzituanrenshu($zituanID); 
	
		
		$MessageAction = A("Message");
		$messageAll = $MessageAction->getxuqiuyingdan($dingdan['dingdanID'],'订单');
		
		$this->assign('messageAll',$messageAll);
		$this->assign('shengyu',$shengyu);
		$this->assign('dingdanID',$dingdanID);
        $this->assign('renshu',$renshu);
        $this->assign('tuanyuanAll',$tuanyuanAll);
        $this->assign('dingdan',$dingdan);
		
        $this->assign('showtype',$_GET['showtype']);
		$this->display();
//		
//		if($_GET['showtype'] == '审核')
//		{
//			$this->display('AdminShenhe/dingdanxinxi');
//		}
//		else
//		{
//			$this->display();
//		}
    }
	
	
	
    public function tuanyuanxinxi() {
		
		$tuanyuanID = $_GET['tuanyuanID'];
		$Gltuanyuan = D('Gltuanyuan');
		$tuanyuan = $Gltuanyuan->where("`tuanyuanID` = '$tuanyuanID'")->find();
		
		//dump($tuanyuan);
		
        $this->assign('tuanyuan',$tuanyuan);
        $this->assign('postdata',$tuanyuan);
        $this->display();
    }
	
	
	
    public function doposttuanyuanxinxi() {
		
		$postdata = $_POST;
		
		$Gltuanyuan = D('Gltuanyuan');
		$newid = $Gltuanyuan->save($postdata);
		if(!$newid)
		{
			$this->assign('postdata',$postdata);
			$this->display('tuanyuanxinxi');
		}
		else
		{
			$rurl = SITE_MENSHI."Dingdan/tuanyuanxinxi/tuanyuanID/".$postdata['tuanyuanID'];
			tiaozhuan($rurl);
		}
    }
	
	public function addtuanyuan() {

			$shengyu = $this->getzituanrenshu($_POST['zituanID']); 
			$forward = $postdata['forward'];
			
			if($shengyu < '1') doalert('人数已满',$forward);
			
			$tuanyuan['dingdanID'] = $_POST['dingdanID'];
			$tuanyuan['zituanID'] = $_POST['zituanID'];
			$tuanyuan['jiaoqian'] = $_POST['jiaoqian_chengren'];
			$tuanyuan['time'] = time();
			$tuanyuan['usertype'] = '订团';
			$tuanyuan['manorchild'] = '成人';
			$tuanyuan['islock'] = '未锁定';
			$tuanyuan['sex'] = '男';
			$tuanyuan['zhengjiantype'] = '身份证';
			$tuanyuan['zhuangtai'] = '占位';
			$Gltuanyuan = D("gltuanyuan");
			$res = $Gltuanyuan->add($tuanyuan);

			//修改团人数
			$gldingdan = D("gldingdan");
			$dingdan = $gldingdan->where("`dingdanID` = '$_POST[dingdanID]'")->find();
			$dingdan['renshu'] += 1;
			$gldingdan->save($dingdan);
			

			if($res) doalert('添加成功',$forward);
			
			
	}
	
    public function canceltuanyuan() {
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
			$Gltuanyuan = D("gltuanyuan");
			$i= 0;
			foreach($itemlist as $tuanyuanID){
				$Gltuanyuan->where("`tuanyuanID` = '$tuanyuanID'")->delete();
				$i++;
			}
			
			//修改团人数
			$gldingdan = D("gldingdan");
			$dingdan = $gldingdan->where("`dingdanID` = '$postdata[dingdanID]'")->find();
			$dingdan['renshu'] -= $i;
			$gldingdan->save($dingdan);
			
			doalert('取消成功',$forward);
			
			
	}
	
	
	
    public function dochangestatus() {
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
			if(!$_GET)
				doalert('错误',$forward);
			$Gltuanyuan = D("gltuanyuan");
			foreach($itemlist as $tuanyuanID){
				
				$tuanyuan = $Gltuanyuan->where("`tuanyuanID` = '$tuanyuanID'")->find();
				
				if(!$tuanyuan['zhengjianhaoma'] && !$tuanyuan['huzhaohaoma'])
				{
					justalert('确认失败,团员身份证或护照信息未填写！');
					gethistoryback();
				}
				
				//$tuanyuan['tuanyuanID'] = $tuanyuanID;
				$tuanyuan['zhuangtai'] = $_GET['type'];
				$Gltuanyuan->save($tuanyuan);
				
				$dingdanID = $tuanyuan['dingdanID'];
			}
			
			//团员全确认，订单确认
			$gldingdan = d("gldingdan");
			$dingdan = $gldingdan->where("`dingdanID` = '$dingdanID'")->find();
			$thezw = $Gltuanyuan->where("`dingdanID` = '$dingdanID' and `zhuangtai` = '占位'")->find();
			if(!$thezw)
			{
			F_dingdan_bzd_item($dingdan);
			$dingdan['zhuangtai'] = '确认';
			$gldingdan->save($dingdan);
			doalert($_GET['type'].'成功,所有团员确认,订单改为确认状态',$forward);
			}
			elseif($dingdan['zhuangtai'] == '确认' && $thezw)
			{
			$dingdan['zhuangtai'] = '占位';
			$gldingdan->save($dingdan);
			doalert($_GET['type'].'成功,不是所有团员都确认,订单改为占位状态',$forward);
			}
			
			doalert($_GET['type'].'成功',$forward);
			
			
	}
	
	
    public function dodaokuancheck() {
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
			if(!$_GET)
				doalert('错误',$forward);
			$Gltuanyuan = D("gltuanyuan");
			foreach($itemlist as $tuanyuanID){
				
				$tuanyuan = $Gltuanyuan->where("`tuanyuanID` = '$tuanyuanID'")->find();
				
				if(!$tuanyuan['zhengjianhaoma'] && !$tuanyuan['huzhaohaoma'])
				{
					justalert('确认失败,团员身份证或护照信息未填写！');
					gethistoryback();
				}
				
				$tuanyuan['daokuan'] = $_GET['type'];
				$Gltuanyuan->save($tuanyuan);
				
				$dingdanID = $tuanyuan['dingdanID'];
			}
			
			
			//团员全到款，订单到款
			$gldingdan = d("gldingdan");
			$dingdan = $gldingdan->where("`dingdanID` = '$dingdanID'")->find();
			$thezw = $Gltuanyuan->where("`dingdanID` = '$dingdanID' and `daokuan` = '未付费'")->find();
			
			if(!$thezw)
			{
				$dingdan['daokuan'] = '已付款';
				$gldingdan->save($dingdan);
				doalert($_GET['type'].'成功,所有团员已付款,订单改为已付款状态',$forward);
			}
			elseif($dingdan['daokuan'] == '已付款' && $thezw)
			{
				$dingdan['daokuan'] = '未付款';
				$gldingdan->save($dingdan);
				doalert($_GET['type'].'成功,不是所有团员都已付款,订单改为未付款状态',$forward);
			}
			
			
			doalert($_GET['type'].'成功',$forward);
			
			
	}
	
	
	
	
	
    public function dingdansuo() {
		
		$type = $_GET['type'];
		$dingdanID = $_GET['dingdanID'];
		$Gldingdan = D('gldingdan');
		$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		if($type == '锁定')
			$dingdan['islock'] = '已锁定';
		if($type == '解锁')
			$dingdan['islock'] = '未锁定';
		$Gldingdan->save($dingdan);
		doalert('订单已'.$type,'');
    }
	
	
    public function querenfukuan() {
		
		$dingdanID = $_GET['dingdanID'];
		$Gldingdan = D("gldingdan");
		$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		$dingdan['daokuan'] = '已付款';
		$dingdan['zhuangtai'] = '确认';
		
		if(!checkByAdminlevel('网管,总经理,财务操作员',$this)){
			doalert('您没有权限','');
		}
		
		$Gldingdan->save($dingdan);
		//记录
		$megurl = SITE_MENSHI."Dingdan/dingdanxinxi/dingdanID/".$dingdanID;
		A("Message")->savemessage($dingdanID,'订单','审核记录','门市确认订单支付','计调经理,计调操作员,财务操作员',$megurl);
		
				
		$megurl_caiwu = SITE_MENSHI."Dingdan/dingdanxinxi/showtype/审核/dingdanID/".$dingdanID;
		A("Message")->savemessage($dingdanID,'订单','审核记录','报名子团订单确认提醒','财务操作员',$megurl_caiwu);
		
		doalert('订单已'.$dingdan['daokuan'],'');
    }

    public function quxiaofukuan() {
		
		$dingdanID = $_GET['dingdanID'];
		$Gldingdan = D("gldingdan");
		$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		$dingdan['daokuan'] = '未付款';
		
		$Gldingdan->save($dingdan);
		//记录
		$megurl = SITE_MENSHI."Dingdan/dingdanxinxi/dingdanID/".$dingdanID;
		A("Message")->savemessage($dingdanID,'订单','审核记录','订单门市取消支付','计调经理,计调操作员,财务操作员',$megurl);
		
		doalert('订单已'.$dingdan['daokuan'],'');
    }

	
    public function noticelist() {
		
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'iframe' || $key == 'pagenum'|| $key == 'showtype')
			{
				$urlitem.= '/'.$key.'/'.$value;
				continue;
			}
			if($key == 'time1' || $key == 'time2')
			{
				$urlitem.= '/'.$key.'/'.$value;
				$this->assign($key,$value);
				continue;
			}
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		//搜索结束
		$start =$_GET['time1'].'-00'; 
		$end =$_GET['time2'].'-00'; 
		if($_GET['time1'] && $_GET['time2'])	
			$condition['chutuanriqi'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$condition['chutuanriqi'] = array('egt',$start);
		elseif($_GET['time2'])
			$condition['chutuanriqi'] = array('elt',$start);
		
		
		$navlist = '订单管理 > 通知计划 > '.$_GET['jiedaitype'];
        $this->assign('navlist',$navlist);
		$Gljiedaijihua = D('jiedai_zituan');
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $Gljiedaijihua->where($condition)->count();
		$pagenum = $_GET['pagenum'];
		if(!$pagenum)
		$pagenum = 15;
		$p= new Page($count,$pagenum);
		//$rurl = SITE_MENSHI."Dingdan/noticelist".$searchargs."/p/";
		$page = $p->show();
        $noticelist = $Gljiedaijihua->where($condition)->order("jiedaiID DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $this->assign('page',$page);
		
		$i = 0;
		foreach($noticelist as $notice){
			$glkehu = D("glkehu");
			$user = $glkehu->where("`user_name` = '$notice[user_name]'")->find();
			$noticelist[$i]['user'] = $user ;

			$i++;
		}
		
        $this->assign('noticelist',$noticelist);
		
		if($_GET['iframe']){
			$this->assign('iframe',$_GET['iframe']);
			$this->display('mynotice');
		}
		else
		$this->display('noticelist');
    }

	
	
    public function notice() {
		
		$type = $_GET['jiedaitype'];
        $this->assign('type',$type);
		$navlist = '订单管理 > 通知计划 > '.$type;
        $this->assign('navlist',$navlist);
		
		$zituanID = $_GET['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		$zituan['huituanriqi'] = jisuanriqi($zituan['chutuanriqi'],$zituan['tianshu']);
		
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		
		$Gldingdan = D("dingdan_zituan");
		$dingdanAll = $Gldingdan->where("`zituanID` = '$zituan[zituanID]'")->findall();
		$i = 0;
		foreach($dingdanAll as $dingdan)
		{
			$Gltuanyuan = D("tuanyuan_dingdan");
			$chengrenshu = $Gltuanyuan->where("`manorchild` = '成人' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			$ertongshu = $Gltuanyuan->where("`manorchild` = '儿童' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			
			$dingdanAll[$i]['chengrenjiesuan'] = $chengrenshu * $dingdan['chengrenjia'];
			$dingdanAll[$i]['ertongjiesuan'] = $ertongshu * $dingdan['ertongjia'];
			
			$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findall();
			$dingdanAll[$i]['tuanyuan'] = $tuanyuanAll;
			$i++;
		}
	
		$Gltuanyuan = D("tuanyuan_dingdan");
		$chengrennum = $Gltuanyuan->where("`zituanID` = '$zituan[zituanID]' and `manorchild` = '成人'")->count();
		$ertongnum = $Gltuanyuan->where("`zituanID` = '$zituan[zituanID]' and `manorchild` = '儿童'")->count();
		
		$Gljiedaijihua = D("Gljiedaijihua");
		$jiedaijihua = $Gljiedaijihua->where("`zituanID` = '$zituan[zituanID]' and jiedaitype = '$type'")->find();
		
        $this->assign('chengrennum',$chengrennum);
        $this->assign('ertongnum',$ertongnum);
        $this->assign('jiedaijihua',$jiedaijihua);
        $this->assign('dingdanAll',$dingdanAll);
        $this->assign('xianlu',$xianlu);
        $this->assign('zituan',$zituan);
        $this->assign('zituanID',$zituanID);
		
		$isprint = $_GET['isprint'];
		if($isprint){
			if($type == '出团通知')
			$this->display('printchutuantongzhi');
			if($type == '接待计划')
			$this->display('printjiedaijihua');
		}
		else
		{
			if($type == '出团通知')
			$this->display('chutuantongzhi');
			if($type == '接待计划')
			$this->display('jiedaijihua');
		}
		
		
	}
	
	
	

    public function tuanhistory() {
		
		$Glzituan = D("Glzituan");
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			break;
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		//搜索结束
		$condition['zhuangtai'] = '截止';
			
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $Glzituan->where($condition)->count();
		$p= new Page($count,20);
		//$rurl = SITE_MENSHI."Dingdan/tuanhistory/p/";
		$page = $p->show();
        $zituanAll = $Glzituan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		$shownum = count($zituanAll);

        $this->assign('shownum',$shownum);
        $this->assign('page',$page);
		
		$Glxianlu = D("Glxianlu");
		$Glshoujia = D("Glshoujia");
		$Glxianlujiage = D("Glxianlujiage");
		$Gldingdan = D("dingdan_zituan");
		$i = 0;
		foreach($zituanAll as $zituan)
		{
			$xianlujiage = $Glxianlujiage->where("`xianluID` = '$zituan[xianluID]'")->field('jiageID,chengrenzongjia,ertongzongjia')->find();
			//价格修正
			$zituanAll[$i]['adult_shoujia'] =  $xianlujiage['chengrenzongjia'];
			$zituanAll[$i]['child_shoujia'] =  $xianlujiage['ertongzongjia'];
			$dingdanAll = $Gldingdan->where("`zituanID` = '$zituan[zituanID]'")->findall();
			$querennum = 0;
			$zhanweinum = 0;
			foreach($dingdanAll as $dingdan)
			{
				$Gltuanyuan = D("tuanyuan_dingdan");
				$querennum += $Gltuanyuan->where("`zhuangtai` = '确认' and `dingdanID` = '$dingdan[dingdanID]'")->count();
				$zhanweinum += $Gltuanyuan->where("`zhuangtai` = '占位' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			}
			$zituanAll[$i]['querennum'] = $querennum;
			$zituanAll[$i]['zhanweinum'] = $zhanweinum;
			
			$shengyu = $zituan['renshu'] - $querennum - $zhanweinum;
			$zituanAll[$i]['shengyu'] = $shengyu;
			
			$i++;
		}
		
        $this->assign('zituanAll',$zituanAll);
        $this->display();
    }



    public function dopostdiymindan() {
	
		$dingdanID = $_POST['dingdanID'];
		$gldingdan = D("gldingdan");
		$dingdan = $gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		if(!$dingdan)
			doalert("错误",'/');
			
		$dingdan['diyinput'] = '文件名单'	;
		$dingdan['jiage'] = $_POST['jiage']	;
		$dingdan['lingdui_num'] = $_POST['lingdui_num']	;
		
		if($_FILES['file_url']['name'])
		{
			if($dingdan['file_url'])
				unlink("data/".$dingdan['file_url']);
			foreach($_FILES as $key => $value){
				$uplod = _dofileuplod();
				if($_FILES[$key]['name'] && $uplod != null)
				$dingdan[$key] = $uplod;
				elseif($_FILES[$key]['name'] && $uplod == null)
				justalert('副本上传失败');
			}
		}
		
		$gldingdan->save($dingdan);
		doalert("操作成功",'');

	}





	
	
	
	
	
}
?>