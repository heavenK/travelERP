<?php

class KongguanAction extends CommonAction{

    public function index() {
        $this->display();
    }


    public function sankekongguan() {
		
		$Glzituan = D("Glzituan");
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'iframe'|| $key == 'pagenum')
			{
				$this->assign($key,$value);
				continue;
			}
			if($key == 'time1' || $key == 'time2')
			{
				$this->assign($key,$value);
				continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		if(!$condition['zhuangtai'])
			$condition['zhuangtai'] = array('in','报名,截止');
			
		$condition = listmydepartment($this,$condition);
		
		$start =date( "Y-m-d",strtotime($_GET['time1'])); 
		$end =date( "Y-m-d",strtotime($_GET['time2'])); 
		if($_GET['time1'] && $_GET['time2'])	
			$condition['chutuanriqi'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$condition['chutuanriqi'] = array('egt',$start);
		elseif($_GET['time2'])
			$condition['chutuanriqi'] = array('elt',$end);
		
		
		//同业，办事处相应修改   by gaoyang
		if(checkByAdminlevel('办事处管理员',$this)){
			$condition['lvxingsheID']	=	$this->roleuser["lvxingsheID"]; //取得
		}
		//dump($condition);
		//修改结束 by gaoyang
		
		//搜索人员需要
		$glkehu = D('Glkehu');
		$kehu_all = $glkehu->findall();
		$this->assign('kehu_all',$kehu_all);
		
		//搜索结束
		
		$navlist = '产品控管 > '.$_GET['guojing'].' > '.$_GET['xianlutype'].' >'.$_GET['kind'];
        $this->assign('navlist',$navlist);
		$zituan_xianlu = D("zituan_xianlu_lvxingshe");
        import("@.ORG.Page");
        C('PAGE_NUMBERS',15);
		$count = $zituan_xianlu->where($condition)->count();
			
		$pagenum = $_GET['pagenum'];
		if(!$pagenum)
			$pagenum = 20;
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $zituanAll = $zituan_xianlu->where($condition)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->select();
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
			//$shengyu = F_getzituanrenshu($zituan['zituanID']);
			$zituanAll[$i]['shengyu'] = $shengyu;
			
			
			//发布人
			$Glkehu = D("Glkehu");
			$kehu = $Glkehu->where("`user_name` = '$zituan[user_name]'")->find();
			$zituanAll[$i]['realname'] = $kehu['realname'];
			//报账单
			$gl_baozhang = D("gl_baozhang");
			$bzd = $gl_baozhang->where("`zituanID` = '$zituan[zituanID]'")->find();
			if($bzd['status'] == '')	
			$zituanAll[$i]['bzd_status'] = '未报账';
			if($bzd['status'] == '计调申请')	
			$zituanAll[$i]['bzd_status'] = '已申请';
			if($bzd['status'] == '经理通过')	
			$zituanAll[$i]['bzd_status'] = '财务审核';
			if($bzd['status'] == '财务通过')	
			$zituanAll[$i]['bzd_status'] = '已报账';
			if($bzd['status'] == '经理不通过' || $bzd['status'] == '财务不通过')	
			$zituanAll[$i]['bzd_status'] = '未通过';
			
			
			$i++;
		}
		
        $this->assign('zituanAll',$zituanAll);
		if($_GET['iframe'])
		$this->display('myzituan');
		else
		$this->display();
    }


    public function jiage() {
		
		$zituanID = $_GET['zituanID'];
		
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		
		if($zituan['xianlutype'] == '自由人')
		{
			$rurl = SITE_ADMIN."Ziyouren/xianlujiage/zituanID/".$zituanID;
			tiaozhuan($rurl);
		}
		else
		{
			$rurl = SITE_ADMIN."Chanpin/xianlujiage/zituanID/".$zituanID;
			tiaozhuan($rurl);
		}
/*		
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		$Glxianlujiage = D("Glxianlujiage");
		$xianlujiage = $Glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
		$Glchengbenxiang = D("Glchengbenxiang");
		$chengbenxiangAll = $Glchengbenxiang->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
		$Glshoujia = D("Glshoujia");
		$shoujiaAll = $Glshoujia->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
		$i = 0;
		$j=0;
		foreach($shoujiaAll as $shoujia)
		{
			if($shoujia['xuanzetype'] == $xianlujiage['xuanzetype'])
			{
				$DailishoujiaAll[$i] = $shoujia;
				$i++;
			}
			else if($shoujia['leixing'] == '合作伙伴')
			{
				$hezuoshoujiaAll[$j] = $shoujia;
				$j++;
			}
		}
		
		
        $this->assign('hezuoshoujiaAll',$hezuoshoujiaAll);
        $this->assign('DailishoujiaAll',$DailishoujiaAll);
        $this->assign('chengbenxiangAll',$chengbenxiangAll);
        $this->assign('xianlujiage',$xianlujiage);
        $this->assign('xianlu',$xianlu);
        $this->assign('zituan',$zituan);
		
		
		$this->assign('location','价格');
		$this->assign('navlist','产品控管 > '.$zituan['guojing'].' > 价格');
        $this->display();
*/    
	
	
	
	}



    public function deleteshoujiaxiang() {
		
		$zituanID = $_GET['zituanID'];
		$shoujiaID = $_GET['shoujiaID'];
		
		$Glxianlu = D("Glxianlu");
		$Glxianlujiage = D("Glxianlujiage");
		$Glchengbenxiang = D("Glchengbenxiang");
		$Glshoujia = D("Glshoujia");
		$oldshoujia = $Glshoujia->where("`shoujiaID` = '$shoujiaID'")->find();
		
		if(!$oldshoujia )
		{
			echo "system error deletechengbenxiang";
			exit;
		}
		$Glshoujia->where("`shoujiaID` = '$shoujiaID'")->delete();
		
		//$rurl = SITE_ADMIN."Konguan/zituanjiage/zituanID/".$zituanID;
		doalert('成功删除',$rurl);
		
		
    }
	
	





    public function tuanyuanmingdan() {
		$zituanID = $_GET['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		$Gltuanyuan = D("tuanyuan_dingdan");
		$Gldingdan = D("dingdan_zituan");
		$dingdanAll = $Gldingdan->where("`zituanID` = '$zituanID'")->findall();
		
		$gllvxingshe = D("gllvxingshe");
		$i = 0;
		foreach($dingdanAll as $dingdan)
		{
			$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findall();
			$dingdanAll[$i]['tuanyuanAll'] = $tuanyuanAll;
			
			$company = $gllvxingshe->where("`lvxingsheID` = '$dingdan[laiyuan]'")->find();
			$dingdanAll[$i]['companyname'] = $company['companyname'];
			
			$i++;
		}
		
        $this->assign('dingdanAll',$dingdanAll);
        $this->assign('dingdan',$dingdan);
        $this->assign('xianlu',$xianlu);
        $this->assign('zituan',$zituan);
		
		$this->assign('location','团员名单');
		$this->assign('navlist','产品控管 > '.$zituan['guojing'].' > 团员名单');
        $this->display();
    }




    public function dopostpiliangtiaojia() {
		
		$postdata = $_POST;
		$ids = split('[,]',$postdata['iditems']);
		$Glzituan = D('Glzituan');
		foreach($ids as $zituanID)
		{
			
			$condition['islock'] = '已锁定';
			$condition['zituanID'] = $zituanID;
			$warningzituan = $Glzituan->where($condition)->find();
			if($warningzituan)
			{
				//$rurl = SITE_ADMIN."Kongguan/sankekongguan";
				doalert('部分子团调价失败,'.$warningzituan['tuanhao'].'已被锁定',$rurl);
			}
			$zituan['zituanID'] = $zituanID;
			if($postdata['adulttype'] == '增加')
			$zituan['adultxiuzheng'] = $postdata['adultxiuzheng'] ;
			if($postdata['adulttype'] == '减少')
			$zituan['adultxiuzheng'] = 0 - $postdata['adultxiuzheng'] ;
			
			if($postdata['childtype'] == '增加')
			$zituan['childxiuzheng'] = $postdata['childxiuzheng'] ;
			if($postdata['childtype'] == '减少')
			$zituan['childxiuzheng'] = 0 - $postdata['childxiuzheng'] ;
			$Glzituan->save($zituan);
			
			//记录
			A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','成人价'.$postdata['adulttype'].$postdata['adultxiuzheng'].'儿童价'.$postdata['childtype'].$postdata['childxiuzheng']);
		}
		
		if($_POST['forward'])
		$rurl = $_POST['forward'];
//		else
//		$rurl = SITE_ADMIN."Kongguan/sankekongguan";
		doalert('修改成功',$rurl);
		
	}



    public function dopostpiliangjiezhi() {
		
		$postdata = $_POST;
		
		$Glzituan = D('Glzituan');
		foreach($postdata['itemlist'] as $zituanID)
		{
			$zituan['zituanID'] = $zituanID;
			$zituan['zhuangtai'] = '截止';
			$Glzituan->save($zituan);
			
			$Gldingdan = D("gldingdan");
			$dingdanAll = $Gldingdan->where("`zituanID` = '$zituanID'")->findall();
			foreach($dingdanAll as $dingdan){
				$dingdan['zhuangtai'] = '截止';	
				$Gldingdan->save($dingdan);
			}
			$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
			F_xianlu_status_set($zituan['xianluID']);
			//记录
			A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','子团截止操作,子团内订单状态改变为截止');
		}
		
		if($_POST['forward'])
		$rurl = $_POST['forward'];
//		else
//		$rurl = SITE_ADMIN."Kongguan/sankekongguan";
		doalert("截止成功",$rurl);
		
	}

	//截止恢复
    public function dopostpilianghuifu() {
		
		$postdata = $_POST;
		
		$Glzituan = D('Glzituan');
		foreach($postdata['itemlist'] as $zituanID)
		{
			$zituan['zituanID'] = $zituanID;
			$zituan['zhuangtai'] = '报名';
			$Glzituan->save($zituan);
			
			$Gldingdan = D("gldingdan");
			$dingdanAll = $Gldingdan->where("`zituanID` = '$zituanID'")->findall();
			foreach($dingdanAll as $dingdan){
				$dingdan['zhuangtai'] = '确认';	
				$Gldingdan->save($dingdan);
			}
			
			$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
			F_xianlu_status_set_2($zituan['xianluID']);
			//记录
			A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','子团截止操作,子团内订单状态改变为报名');
		}
		
		if($_POST['forward'])
		$rurl = $_POST['forward'];
//		else
//		$rurl = SITE_ADMIN."Kongguan/sankekongguan";
		doalert("报名成功",$rurl);
		
	}


/*
    public function dopostpiliangzhidinggongyingshang() {
		
		$postdata = $_POST;
		$ids = split('[,]',$postdata['iditems_2']);
		$Glzituan = D('Glzituan');
		foreach($ids as $zituanID)
		{
			$zituan['zituanID'] = $zituanID;
//			$zituan['ProviderName'] = $postdata['ProviderName'];
//			$zituan['ProviderID'] = $postdata['ProviderID'];
			
			$Glzituan->save($zituan);
			//记录
			A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','批量指定供应商为'.$zituan['ProviderName']);
			
		}
		
		if($_POST['forward'])
		$rurl = $_POST['forward'];
		doalert("修改成功",$rurl);
		
	}

*/
    public function zituanjiezhi() {
		
		$zituanID = $_GET['zituanID'];
		
//		dump($zituanID);
//		exit;
		$Glzituan = D('Glzituan');
		$zituan = $Glzituan->where("`zituanID` = $zituanID")->find();
		if(!$zituan)
		doalert("错误！！",'');
		
		$zituan['zituanID'] = $zituanID;
		$zituan['zhuangtai'] = '截止';
		$Glzituan->save($zituan);
		
		$Gldingdan = D("gldingdan");
		$dingdanAll = $Gldingdan->where("`zituanID` = '$zituanID'")->findall();
		foreach($dingdanAll as $dingdan){
			$dingdan['zhuangtai'] = '截止';	
			$Gldingdan->save($dingdan);
		}
		F_xianlu_status_set($zituan['xianluID']) ;
		//记录
		A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','子团截止操作,子团内订单状态改变为截止');
		$rurl = SITE_ADMIN."Dingdan/zituandingdan/zituanID/".$zituanID;
		doalert("截止成功",$rurl);
	}



    public function doposttiaojia() {
		
		$postdata = $_POST;
		$Glzituan = D('Glzituan');
		$zituan['zituanID'] = $postdata['zituanID'];
		
		
		if($postdata['adulttype'] == '增加')
		$zituan['adultxiuzheng'] = $postdata['adultxiuzheng'] ;
		if($postdata['adulttype'] == '减少')
		$zituan['adultxiuzheng'] = 0 - $postdata['adultxiuzheng'] ;
		
		if($postdata['childtype'] == '增加')
		$zituan['childxiuzheng'] = $postdata['childxiuzheng'] ;
		if($postdata['childtype'] == '减少')
		$zituan['childxiuzheng'] = 0 - $postdata['childxiuzheng'] ;
		$Glzituan->save($zituan);
		//记录
		A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','成人价'.$postdata['adulttype'].$postdata['adultxiuzheng'].'儿童价'.$postdata['childtype'].$postdata['childxiuzheng']);
		
		$rurl = SITE_ADMIN."Kongguan/jiage/zituanID/".$zituan['zituanID'];
		tiaozhuan($rurl);
		
	}


    public function editxingcheng() {
		
		$xianluID = $_GET['xianluID'];
		$zituanID = $_GET['zituanID'];
		$zituan['zituanID'] = $_GET['zituanID'];
		
		//dump($xianluID);
		
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$xianluID'")->field('xianluID,xingcheng')->find();
        $this->assign('zituan',$zituan);
        $this->assign('zituanID',$zituanID);
        $this->assign('xianluID',$xianluID);
        $this->assign('xianlu',$xianlu);
        $this->display();
		
    }




    public function dopostzituanxinxi() {
		
		$postdata = $_POST;
		$zituanID = $_POST['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		//判断锁
		$temttable = islock(D("Glzituan"),'zituanID',$zituanID);
		$rurl = $postdata['forward'];
		if($temttable)
		{
			doalert('修改失败，子团已上锁',$rurl);
		}
		
		if(!$postdata['tuanhao'])
			doalert('修改失败，团号不能空',$rurl);
		if(!$postdata['chutuanriqi'])
			doalert('修改失败，出团日期不能空',$rurl);
		if(!$postdata['renshu'])
			doalert('修改失败，人数不能空',$rurl);
		
		$isok = $Glzituan->save($postdata);
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		$xianlu['chutuanriqi'] = str_replace($zituan['chutuanriqi'],$postdata['chutuanriqi'],$xianlu['chutuanriqi']);
		$Glxianlu->save($xianlu);
		doalert('修改成功',$rurl);
    }



    public function dopostpiliangjiesuo() {
		
		$postdata = $_POST;
		
		$Glzituan = D('Glzituan');
		foreach($postdata['itemlist'] as $zituanID)
		{
			$zituan['zituanID'] = $zituanID;
			$zituan['islock'] = '未锁定';
			$Glzituan->save($zituan);
			//记录
			A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','批量解锁操作');
			
		}
		
		if($_POST['forward'])
		$rurl = $_POST['forward'];
		doalert('修改成功',$rurl);
		
	}


    public function dopostpiliangsuoding() {
		
		$postdata = $_POST;
		
		$Glzituan = D('Glzituan');
		foreach($postdata['itemlist'] as $zituanID)
		{
			$zituan['zituanID'] = $zituanID;
			$zituan['islock'] = '已锁定';
			$Glzituan->save($zituan);
			//记录
			A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','批量锁定操作');
			
		}
		
		if($_POST['forward'])
		$rurl = $_POST['forward'];
		doalert('修改成功',$rurl);
		
	}






    public function jiedaijihua() {
		
		$zituanID = $_GET['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		$zituan['huituanriqi'] = jisuanriqi($zituan['chutuanriqi'],$zituan['tianshu']);
		
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		
		//获取行程信息
		$Glxingcheng = D("Glxingcheng");
		$xingcheng = $Glxingcheng->where("`xianluID` = '$zituan[xianluID]'")->order("id asc")->limit('0,'.$zituan['tianshu'])->findAll();
		$this->assign('xingchengAll',$xingcheng);
		
		$Gldingdan = D("dingdan_zituan");
		$dingdanAll = $Gldingdan->where("`zituanID` = '$zituan[zituanID]'")->findall();
		$Gltuanyuan = D("tuanyuan_dingdan");
		$i = 0;
		foreach($dingdanAll as $dingdan)
		{
			$chengrenshu = $Gltuanyuan->where("`manorchild` = '成人' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			$ertongshu = $Gltuanyuan->where("`manorchild` = '儿童' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			
			$dingdanAll[$i]['chengrenjiesuan'] = $chengrenshu * $dingdan['chengrenjia'];
			$dingdanAll[$i]['ertongjiesuan'] = $ertongshu * $dingdan['ertongjia'];
			
			$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findall();
			$dingdanAll[$i]['tuanyuan'] = $tuanyuanAll;
			$i++;
		}
		
		$Gljiedaijihua = D("Gljiedaijihua");
		$jiedaijihua = $Gljiedaijihua->where("`zituanID` = $zituan[zituanID] and `jiedaitype` = '接待计划'")->find();
		
        $this->assign('jiedaijihua',$jiedaijihua);
        $this->assign('dingdanAll',$dingdanAll);
        $this->assign('xianlu',$xianlu);
        $this->assign('zituan',$zituan);
        $this->assign('zituanID',$zituanID);
		
		$this->assign('location','接待计划');
		$this->assign('navlist','产品控管 > '.$zituan['guojing'].' > 接待计划');
		
		$isprint = $_GET['isprint'];
		if($isprint)
        $this->display('printjiedaijihua');
		else
        $this->display();
		
	}




    public function dopostjiedaijihua() {
	
		$postdata = $_POST;
		$postdata['jiedaitype'] = '接待计划';
		$postdata['ispublished'] = '已发布';
		$Gljiedaijihua = D("Gljiedaijihua");
		
		if($postdata['jiedaiID'])
		$jihua = $Gljiedaijihua->where("`jiedaiID` = '$postdata[jiedaiID]'")->find();
		elseif($postdata['zituanID'])
		$jihua = $Gljiedaijihua->where("`zituanID` = '$postdata[zituanID]' and `jiedaitype` = '接待计划'")->find();
		
		if($jihua)
		$Gljiedaijihua->save($postdata);
		else
		$Gljiedaijihua->add($postdata);
		
		$rurl = SITE_ADMIN."Kongguan/jiedaijihua/zituanID/".$postdata['zituanID'];
		doalert('发布成功',$rurl);
	}





    public function quxiaofabu() {
	
		$postdata = $_POST;
		
		$data['jiedaiID'] = $postdata['jiedaiID'];
		$data['ispublished'] = '未发布';
		
		$Gljiedaijihua = D("Gljiedaijihua");
		$jihua = $Gljiedaijihua->where("`jiedaiID` = '$postdata[jiedaiID]'")->find();
		if($jihua)
		$Gljiedaijihua->save($data);
		
		$rurl = SITE_ADMIN."Kongguan/jiedaijihua/zituanID/".$postdata['zituanID'];
		doalert('取消发布',$rurl);
	}




    public function chutuantongzhi() {
	
		$zituanID = $_GET['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		$zituan['huituanriqi'] = jisuanriqi($zituan['chutuanriqi'],$zituan['tianshu']);
		
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		
		
				//获取行程信息
		$Glxingcheng = D("Glxingcheng");
		$xingcheng = $Glxingcheng->where("`xianluID` = '$zituan[xianluID]'")->order("id asc")->limit('0,'.$zituan['tianshu'])->findAll();
		$this->assign('xingchengAll',$xingcheng);
		
		
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
			
			$Gltuanyuan = D("tuanyuan_dingdan");
			$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findall();
			$dingdanAll[$i]['tuanyuan'] = $tuanyuanAll;
			$i++;
		}
	
		$Gltuanyuan = D("tuanyuan_dingdan");
		$chengrennum = $Gltuanyuan->where("`zituanID` = '$zituan[zituanID]' and `manorchild` = '成人'")->count();
		$ertongnum = $Gltuanyuan->where("`zituanID` = '$zituan[zituanID]' and `manorchild` = '儿童'")->count();
		
		$Gljiedaijihua = D("Gljiedaijihua");
		$jiedaijihua = $Gljiedaijihua->where("`zituanID` = '$zituan[zituanID]' and jiedaitype = '出团通知'")->find();
		
        $this->assign('chengrennum',$chengrennum);
        $this->assign('ertongnum',$ertongnum);
        $this->assign('jiedaijihua',$jiedaijihua);
        $this->assign('dingdanAll',$dingdanAll);
        $this->assign('xianlu',$xianlu);
        $this->assign('zituan',$zituan);
        $this->assign('zituanID',$zituanID);
		
		$this->assign('location','出团通知');
		$this->assign('navlist','产品控管 > '.$zituan['guojing'].' > 出团通知');
		
		$isprint = $_GET['isprint'];
		if($isprint)
        $this->display('printchutuantongzhi');
		else
        $this->display();
		
	}





    public function dopostchutuantongzhi() {
	
		$postdata = $_POST;
		$postdata['jiedaitype'] = '出团通知';
		if(!$_GET['type_s'])
		$postdata['ispublished'] = '已发布';
		$Gljiedaijihua = D("Gljiedaijihua");
		
		if($postdata['jiedaiID'])
		$jihua = $Gljiedaijihua->where("`jiedaiID` = '$postdata[jiedaiID]'")->find();
		elseif($postdata['zituanID'])
		$jihua = $Gljiedaijihua->where("`zituanID` = '$postdata[zituanID]' and `jiedaitype` = '出团通知'")->find();
		
		if($jihua)
		$Gljiedaijihua->save($postdata);
		else
		$Gljiedaijihua->add($postdata);
		
		$rurl = SITE_ADMIN."Kongguan/chutuantongzhi/zituanID/".$postdata['zituanID'];
		doalert('操作成功',$rurl);
	}



/*
    public function ziyouren() {
		
		$Glzituan = D("Glzituan");
		//搜索
		
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			continue;
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		if(!$condition['zhuangtai'])
			$condition['zhuangtai'] = array('in','报名,截止');
					
		//搜索结束
		if($_GET['guojing'] == "境外"){
			$navlist = '产品控管 > 境外 > 自由人 ';
			$condition['guojing'] = '境外';
		}
		else{
			$navlist = '产品控管 > 国内 > 自由人 ';
			$condition['guojing'] = '国内';
		}
		
        $this->assign('navtitle','自由人控管');
        $this->assign('guojing',$_GET['guojing']);
        $this->assign('navlist',$navlist);
		$condition['xianlutype'] = '自由人';
		
//		if(checkByAdminlevel('联合体成员',$this)){
//		$condition['gongyingshang'] = '联合体';
//		
//		}
		
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $Glzituan->where($condition)->count();
		$p= new Page($count,10);
		$rurl = SITE_ADMIN."Kongguan/sankekonguan/p/";
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
			$xianlujiage = $Glxianlujiage->where("`xianluID` = '$zituan[xianluID]'")->field('jiageID')->find();
			
			$shoujia = $Glshoujia->where("`jiageID` = '$xianlujiage[jiageID]'")->field('chengrenshoujia')->find();
			
			$zituanAll[$i]['shoujia'] =  $shoujia['chengrenshoujia'];
			
			//价格修正
			//$zituanAll[$i]['adult_shoujia'] =  $xianlujiage['chengrenzongjia'];
			//$zituanAll[$i]['child_shoujia'] =  $xianlujiage['ertongzongjia'];
			
			$zituanAll[$i]['xiuzheng'] = $zituanAll[$i]['adultxiuzheng'];
			
			$dingdanAll = $Gldingdan->where("`zituanID` = '$zituan[zituanID]'")->findall();
			$querennum = 0;
			$zhanweinum = 0;
			foreach($dingdanAll as $dingdan)
			{
//				if($dingdan['zhuangtai'] == '确认')
//				$querennum += $dingdan['ertongshu'] + $dingdan['chengrenshu'];
//				if($dingdan['zhuangtai'] == '占位')
//				$zhanweinum += $dingdan['ertongshu'] + $dingdan['chengrenshu'];
				
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


*/

	
    public function dopostXianlujiage() {
		
		$postdata = $_POST;
		$zituanID = $_POST['zituanID'];
		$this->assign('zituanID',$zituanID);
		//检测ID
//		$Glxianlu = D("Glxianlu");
//		$xianludata = $Glxianlu->where("`xianluID` = '$xianluID'")->field('xianluID')->find();
//		if(!$xianludata)
//		{
//			echo "system error 1";
//			$rurl = SITE_ADMIN."Ziyouren/sankechanpin";
//			doalert('找不到线路产品',$rurl);
//		}
		$Glxianlujiage = D("Glxianlujiage");
		$oldjiage = $Glxianlujiage->where("`zituanID` = '$zituanID'")->find();
		if($oldjiage)
		{
			$oldjiage['xuanzetype'] = $postdata['ddlAgentType'];
			$ifnewid = $Glxianlujiage->save($oldjiage);
			$xianlujiageID = $oldjiage['jiageID'];
		}
		else
		{
			echo "system error A";
			$this->assign('postdata',$postdata);
			$this->display('zituanjiage');
			exit;
		}
		
//		dump($postdata);
//		exit;
		//机票流程
		$Glticketorder = D("Glticketorder");
		foreach($postdata['aircaozuoID'] as $id)
		{
			  $ticket['ticketID'] = $postdata['ticketID0'.$id];
			  $ticket['tickettype'] = $postdata['tickettype0'.$id];
			  $ticket['jiageID'] = $xianlujiageID;
			  $ticket['time'] = time();
			  
			  $Glticketorder->add($ticket);
		}
		
		//酒店流程
		$Glticketorder = D("Glticketorder");
		foreach($postdata['hotelcaozuoID'] as $id)
		{
			  $ticket['ticketID'] = $postdata['ticketID1'.$id];
			  $ticket['tickettype'] = $postdata['tickettype1'.$id];
			  $ticket['jiageID'] = $xianlujiageID;
			  $ticket['time'] = time();
			  
			  $Glticketorder->add($ticket);
		}
		
		
		//以下是代理商流程
		$Glshoujia = D("Glshoujia");
		//必填
		if($postdata['ddlAgentType'] == 'Batch')
		{
			
			foreach($postdata['BatchcaozuoID'] as $i)
			{
					$dailishang['shoujiaID'] = $postdata['shoujiaID1'.$i];
					$dailishang['leixing'] = '代理商';//合作类型
					$dailishang['dailileixing'] = $postdata['slAgentType1'.$i];//代理商类型
					$dailishang['jibie'] = $postdata['slClass1'.$i];//级别
					$dailishang['chengrenyongjin'] = $postdata['tbAdultCommission1'.$i];//成人佣金
					$dailishang['chengrenlirun'] = $postdata['tbAdultProfit1'.$i];
					$dailishang['time'] = time();
					$dailishang['xuanzetype'] = 'Batch';
					$dailishang['jiageID'] = $xianlujiageID;
					$olddailishang = $Glshoujia->where("`shoujiaID` = '$dailishang[shoujiaID]'")->find();
					
					if($olddailishang)
					{
						$ifnewid = $Glshoujia->save($dailishang);
						$lastshoujiaID = $dailishang['shoujiaID'];
					}
					else
					{
						$lastshoujiaID = $Glshoujia->add($dailishang);
						$postdata['shoujiaID1'.$i] = $lastshoujiaID;
					}
					if($lastshoujiaID < 0)
					{
						echo "system error C  ".$i;
						$this->assign('postdata',$postdata);
						$this->display('Xianlujiage');
						exit;
					}
					
				}
		}
		if($postdata['ddlAgentType'] == 'MultipleChoice')
		{
			foreach($postdata['MultipleChoicecaozuoID'] as $i)
			{
					if($postdata['AgentName2'.$i])
					{
							
							$dailishang['shoujiaID'] = $postdata['shoujiaID2'.$i];
							$dailishang['leixing'] = '代理商';//合作类型
							$dailishang['hezuohuoban'] = $postdata['AgentName2'.$i];//代理商名
							$dailishang['hezuohuobanID'] = $postdata['AgentID2'.$i];//代理商ID
							$dailishang['chengrenyongjin'] = $postdata['tbAdultCommission2'.$i];//成人佣金
							$dailishang['chengrenlirun'] = $postdata['tbAdultProfit2'.$i];
							$dailishang['time'] = time();
							$dailishang['xuanzetype'] = 'MultipleChoice';
							$dailishang['jiageID'] = $xianlujiageID;
							
							$olddailishang = $Glshoujia->where("`shoujiaID` = '$dailishang[shoujiaID]'")->find();
							if($olddailishang)
							{
								$ifnewid = $Glshoujia->save($dailishang);
								$lastshoujiaID = $dailishang['shoujiaID'];
							}
							else
							{
								$lastshoujiaID = $Glshoujia->add($dailishang);
								$postdata['shoujiaID2'.$i] = $lastshoujiaID;
							}
							if(!$lastshoujiaID )
							{
								echo "system error C  a_".$i;
								$this->assign('postdata',$postdata);
								$this->display('Xianlujiage');
								exit;
							}
						}
						
					else
					{
						justalert("请选择代理商后提交");
						$this->assign('postdata',$postdata);
						$this->display('zituanjiage');
						exit;
					}
			}
		}
		$rurl = SITE_ADMIN."Kongguan/zituanjiage/zituanID/".$postdata['zituanID'];
		tiaozhuan($rurl);
			
			
	}
		
	
    public function baozhangdan() {
		$zituanID = $_GET['zituanID'];
		
		if($zituanID)
		{
				$GLzituan = D('zituan_xianlu');
				$tuan = $GLzituan->where("`zituanID` = '$zituanID'")->find();
				$tuan['huituanriqi'] = jisuanriqi($tuan['chutuanriqi'],$tuan['tianshu']);
				
				$guojing = $tuan['guojing'];
				if(!$tuan)
					doalert("团队不存在",'');
				$this->assign('tuan',$tuan);
				
				$GLbaozhang = D('Gl_baozhang');
				$baozhang = $GLbaozhang->where("`zituanID` = '$tuan[zituanID]'")->find();
				
				
				if(!$baozhang)
				{
					$postdata['zituanID'] = $tuan['zituanID'];
					$postdata['time'] = time();
					$postdata['adduser'] = $this->roleuser['user_name'];
					$postdata['edituser'] = $this->roleuser['user_name'];
					$newid = $GLbaozhang->add($postdata);
					if(!$newid){
						justalert("错误");
						gethistoryback();
					}
					$baozhang = $GLbaozhang->where("`zituanID` = '$tuan[zituanID]'")->find();
				}
				
				if(!$baozhang){
					justalert("错误");
					gethistoryback();
				}
				
				$cond['zituanID'] = $zituanID;
				$cond['check_status'] = '审核通过';
				$gldingdan = D("Gldingdan");
				$dingdanAll = $gldingdan->where($cond)->findall();
				foreach($dingdanAll as $dingdan){
					//人数统计
					$Gltuanyuan = D("tuanyuan_dingdan");
					$rennum = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->count();
					$dingdan_rensum += $rennum;
				}
				$this->assign('dingdan_rensum',$dingdan_rensum);
				
				//报账人数   by heavenK
				$reg = "/[^\d]/";
				$res = preg_replace($reg ," " ,$baozhang['renshu']);
				$arr = explode(' ' ,$res);
				$sum_b = 0;
				foreach($arr as $value){
					$sum_b += $value;
				}
				$baozhang_renshu = $sum_b;
				$this->assign('baozhang_renshu',$baozhang_renshu);
				
				
				
				$GLbaozhangitem = D('gl_baozhangitem');
				if($_GET['showpage'] == '计调'){
					$itemAll = $GLbaozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and (`check_status` = '经理确认' or `check_status` = '审核通过')")->findall();
					$itemAll_b = $GLbaozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and (`check_status` = '经理确认' or `check_status` = '审核通过') and (`is_print` is null or `is_print` = '')")->findall();
				}
				else{
					$itemAll = $GLbaozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and `check_status` = '审核通过'")->findall();
					$itemAll_b = $GLbaozhangitem->where("`baozhangID` = '$baozhang[baozhangID]' and `check_status` = '审核通过' and (`is_print` is null or `is_print` = '')")->findall();
				}
				$i=0;$m=0;
				foreach($itemAll_b as $tema){
					if($tema['type'] == '结算项目') { 
					$itemNed_b['yingshou'][$i] = $tema;
					$itemNed_b['yingshoutotalprice'] += $tema['price'];
					$i++;
					}
					if($tema['type'] == '支出项目') { 
					$itemNed_b['yingfu'][$m] = $tema;
					$itemNed_b['yingfutotalprice'] += $tema['price'];
					$m++;
					}
				}
			$this->assign('itemNed_b',$itemNed_b);
			
			
//				$dingdan_zituan = D("dingdan_zituan");
//				$dingdanAll = $dingdan_zituan->where("`zituanID` = '$zituanID'")->findall();
//				foreach($dingdanAll as $dingdan)
//				{
//					$renshu += $dingdan['chengrenshu'] + $dingdan['ertongshu'];
//				}
//				$this->assign('renshu',$renshu);
				
		}
		elseif($_GET['datatype'] == 'backup')
		{
			$id = $_GET["id"];
			$bzdbackup_zituan_djtuan = D("bzdbackup_zituan_djtuan");
			$bzd = $bzdbackup_zituan_djtuan->where("`id` = '$id'")->find();
			$baozhang = unserialize($bzd['content']);
			$tuan = $bzd;
			$itemAll = $baozhang['itemAll'];
			$zituanID = $baozhang['zituanID'];
			
			$guojing = $tuan['guojing'];
			$this->assign('tuan',$tuan);
		}
		
		$this->assign('baozhang',$baozhang);
		$this->assign('zituan',$tuan);
		$this->assign('location','报账单');
		$this->assign('printable','打印');
		
		$glbasedata = D("glbasedata");
		$Gldingdan = D("dingdan_zituan");
		
		$i= 0 ;
		foreach($itemAll as $tema){
			if($tema['type'] == '结算项目') { 
			$totalprice += $tema['price'];
			}
			//大客户
			if($tema['bigmanID']) { 
				$bigman = $glbasedata->where("`id` = '$tema[bigmanID]'")->find();
				$itemAll[$i]['bigman'] = $bigman;
				$itemAll[$i]['title'] = $bigman['title'];
				$dingdanAll = $Gldingdan->where("`bigmanID` = '$tema[bigmanID]' and `zituanID` = '$zituanID'")->findall();
				foreach($dingdanAll as $dingdan){
					$renshu += $dingdan['chengrenshu'] + $dingdan['ertongshu'];
				}
				$itemAll[$i]['renshu'] = $renshu;
			}
			//$itemAll[$i]['remark'] = round($itemAll[$i]['price']/$itemAll[$i]['renshu'],2);
			//利润部
			if($tema['departmentID']) { 
				$department = $glbasedata->where("`id` = '$tema[departmentID]'")->find();
				$itemAll[$i]['department'] = $department;
				$itemAll[$i]['title'] = $department['title'];
			}
			
			$i++;
		}
		$this->assign('totalprice',$totalprice);
	  	$this->assign('itemAll',$itemAll);
		
		$i=0;$m=0;$n=0;$t=0;
		foreach($itemAll as $tema){
			if($tema['type'] == '结算项目') { 
			$itemNed['yingshou'][$i] = $tema;
			$itemNed['yingshoutotalprice'] += $tema['price'];
			$i++;
			}
			if($tema['type'] == '支出项目') { 
			$itemNed['yingfu'][$m] = $tema;
			$itemNed['yingfutotalprice'] += $tema['price'];
			$m++;
			}
			if($tema['type'] == '项目') { 
			$itemNed['qita'][$n] = $tema;
			$itemNed['qitatotalprice'] += $tema['price'];
			$n++;
			}
			if($tema['type'] == '利润') { 
			$itemNed['lirun'][$t] = $tema;
			$itemNed['liruntotalprice'] += $tema['price'];
			$t++;
			}
		}
		
		$this->assign('zongshouru',$itemNed['yingshoutotalprice']);
		$this->assign('zongzhichu',$itemNed['yingfutotalprice'] + $itemNed['qitatotalprice']);
		$this->assign('lirun',$itemNed['yingshoutotalprice']-$itemNed['yingfutotalprice'] - $itemNed['qitatotalprice']);
		if($i > $m)
			$this->assign('rownum',$i);
		else
			$this->assign('rownum',$m);
		$this->assign('itemNed',$itemNed);
		
		
//		$countdata = $this->baozhangcountdata($baozhang['baozhangID']);
//		$this->assign('countdata',$countdata);
//		
//		$jiesuanheji = $this->baozhangheji($baozhang['baozhangID'],'结算项目');
//		$this->assign('jiesuanheji',$jiesuanheji);
//		
//		$zhichuheji = $this->baozhangheji($baozhang['baozhangID'],'支出项目');
//		$this->assign('zhichuheji',$zhichuheji);
		
		if($guojing == '境外'){
			$navlist = "产品控管 > 境外 > 报账单";
		}else{
			$navlist = "产品控管 > 国内 > 报账单";
		}
		$this->assign('navlist',$navlist);
		
		
		if($guojing == '境外'){
			if($_GET['doprint'])
			{
				if($_GET['showpage'] == '计调')
				$this->display('printjingwaibaozhangdan_2');
				else
				$this->display('printjingwaibaozhangdan');
			}
			else	
			{
				if($_GET['showtype'] == '审核'){
					$this->display('Shenhe/jingwaibaozhangdan');
				}
				else
				$this->display('jingwaibaozhangdan');
			}
		}
		else{
			if($_GET['doprint'])
			{
				if($_GET['showpage'] == '计调')
				$this->display('printbaozhangdan_2');
				else
				$this->display('printbaozhangdan');
			}
			else
			{
				if($_GET['showtype'] == '审核'){
					$this->display('Shenhe/baozhangdan');
				}
				else
				$this->display();
			}	
		}
	}



	public function baozhangcountdata($id = null) {
		if($id)	
		$baozhangID = $id;
		else
		$baozhangID = $_POST['baozhangID'];
		$DJbaozhangitem = D('gl_baozhangitem');
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
		//else
		//echo '收入合计:'.$shouru.'元，支出合计:'.$zhichu.'元，其他项目:'.$qita.'元，毛利小计:'.$maoli.'元';
	}


	public function baozhangheji($baozhangID = null, $type = null) {
		if($_POST){
			$baozhangID = $_POST['baozhangID'];
			$type = $_POST['type'];
		}
		$DJbaozhangitem = D('gl_baozhangitem');
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

	public function dopostbaozhangdan() {
		
		foreach($_POST as $key => $value){
			if($key == 'forword')
			$forword = $value;
			else
			$postdata[$key] = $value;
		}
		$DJbaozhang = D('Gl_baozhang');

		if($postdata['baozhangID'] == null || !$postdata['baozhangID'])
		{
			$postdata['time'] = time();
			$postdata['adduser'] = $this->roleuser['user_name'];
			$postdata['edituser'] = $this->roleuser['user_name'];
			$newid = $DJbaozhang->add($postdata);
			if(!$forword)
				$forword = SITE_ADMIN."Kongguan/baozhangdan/zituanID/".$_POST['zituanID'];
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
				
			$DJbaozhang->save($postdata);
			doalert("修改成功",$forword);
		}
		
    }


	
    public function addbaozhangitem() {
			
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		$DJbaozhangitem = D('gl_baozhangitem');
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
		$gl_baozhang = D("gl_baozhang");
		$baozhang = $gl_baozhang->where("`baozhangID` = '$item[baozhangID]'")->find();
		if(!checkByAdminlevel("计调经理,财务操作员,财务总监,网管,总经理",$this)){
			if($baozhang['status']=='经理通过' || $baozhang['status']=='财务通过' || $baozhang['status']=='总经理通过')
			{
				echo "false";
				exit;
			}
		}

		$newid = $DJbaozhangitem->add($item);
		echo $newid;
	}
	

    public function editbaozhangitem() {
			
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		$DJbaozhangitem = D('gl_baozhangitem');
		if($item['baozhangitemID'] == 'undefined'){
			echo "false";
			exit;
		}
		$DJbaozhangitem->save($item);
		echo 'true';
	}
	

	
    public function deletebaozhangitem() {
			
		$postdata = $_POST;
		$DJbaozhangitem = D('gl_baozhangitem');
		
		$item = $DJbaozhangitem->where('baozhangitemID='.$postdata['baozhangitemID'])->find();
		
		if($item['check_status'] == '审核通过')
		{
			if($item['type'] == '利润')
			{
				if($item['bigmanID'] || $item['departmentID'])
				echo 'false';
				else{
				$DJbaozhangitem->where('baozhangitemID='.$postdata['baozhangitemID'])->delete();
				echo 'true';}
			}
			else
			echo 'false';
		}
		else
		{
			if($item['bigmanID'] || $item['departmentID'])
			echo 'false';
			else{
			$DJbaozhangitem->where('baozhangitemID='.$postdata['baozhangitemID'])->delete();
			echo 'true';}
		}
	}
	
	
    public function doprint() {
		
		$zituanID = $_GET['zituanID'];
		
		if($_GET['showpage'] == '计调')
			$this->redirect('/Kongguan/baozhangdan/showpage/计调/doprint/1/zituanID/'.$zituanID);
			
		if($_GET['type'] == '报账单')
			$this->redirect('/Kongguan/baozhangdan/doprint/1/zituanID/'.$zituanID);
			
		else
			$this->display('Error/error404');

    }
	
	public function exports() {
		$zituanID = $_GET['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->findall();
		$Gltuanyuan = D("tuanyuan_dingdan");
		$tuanyuan = $Gltuanyuan->where("`zituanID` = '$zituanID'")->findall();
		
		$glbasedata = D("glbasedata");
		$i = 0;
		foreach($tuanyuan as $v)
		{
			
			//订单部门
			$bumen = $glbasedata->where("`id` = '$v[departmentID]'")->find();
			$tuanyuan[$i]['bumen'] = $bumen['title'].'-'.$v['user_name'];
			$i++;
		}
		
		foreach($zituan as $kszituan)
		{
			$mingcheng = $kszituan['mingcheng'];
			$tuanhao = $kszituan['tuanhao'];
			$tianshu = $kszituan['tianshu'];
			$chutuanriqi = $kszituan['chutuanriqi'];
			
		}

		$this->assign('mingcheng',$mingcheng);
		$this->assign('tuanhao',$tuanhao);
		$this->assign('tianshu',$tianshu);
		$this->assign('chutuanriqi',$chutuanriqi);
		$this->assign('tuanyuan',$tuanyuan);
		
		$title = date('YmdHis');
		
		if(!$_GET['type']){	
			//导出Excel必备头
			header("Content-type:application/vnd.ms-excel");
			header("Content-Disposition:attachment;filename=" . $title . ".xls");
		}
		else{
			//导出Word必备头
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . $title . ".doc");
			header("Pragma:no-cache");        
			header("Expires:0");    
		}
		$this->display();
	}
	
	
	public function exports_word() {
		$zituanID = $_GET['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->findall();
		$Gltuanyuan = D("tuanyuan_dingdan");
		
		$leader = $Gltuanyuan->where("`zituanID` = '$zituanID' and `leader` = '1'")->find();
		
		$tuanyuan = $Gltuanyuan->where("`zituanID` = '$zituanID' AND `tuanyuanID` != '$leader[tuanyuanID]'")->order('leader DESC')->findall();
		
		
		$tuanyuan_num = $Gltuanyuan->where("`zituanID` = '$zituanID' AND `tuanyuanID` != '$leader[tuanyuanID]'")->count();
		$man_num = $Gltuanyuan->where("`zituanID` = '$zituanID' AND `sex` = '男'")->count();
		$woman_num = $Gltuanyuan->where("`zituanID` = '$zituanID' AND `sex` = '女'")->count();
		$page_num = ceil ($tuanyuan_num / 20);
		
		
		//把所有的数据按页数分割
		$page = 0;
		while($page < $page_num){
			$start_pos = $page*20;
			$tuanyuan_part[$page] = $Gltuanyuan->where("`zituanID` = '$zituanID' AND `tuanyuanID` != '$leader[tuanyuanID]'")->order('leader DESC')->limit($start_pos.',20')->select();
			$page++;
		}
		$this->assign('tuanyuan_part',$tuanyuan_part);

		$this->assign('leader',$leader);
		$this->assign('man_num',$man_num);
		$this->assign('woman_num',$woman_num);
		$this->assign('num' ,$tuanyuan_num + 1);
		$this->assign('page_num',$page_num);
		$this->assign('chufashijian',$chufashijian);
		
		
		
		foreach($zituan as $kszituan)
		{
			$mingcheng = $kszituan['mingcheng'];
			$tuanhao = $kszituan['tuanhao'];
			$tianshu = $kszituan['tianshu'];
			$chutuanriqi = $kszituan['chutuanriqi'];
			$chufashijian = explode('-',$chutuanriqi);
			$chufadi = $kszituan['chufadi'];
		}

		$start_date = strtotime("2011-11-11");
		$end_date = strtotime("2011-11-12");
		$one_day = $end_date - $start_date;
		$jieshushijian_stemp = strtotime($chutuanriqi) + ($one_day * ($tianshu - 1));
		$jieshushijian = explode('-',date('Y-m-d', $jieshushijian_stemp));
		
		$this->assign('chufashijian',$chufashijian);
		$this->assign('jieshushijian',$jieshushijian);
		
		$this->assign('chufadi',$chufadi);
		$this->assign('mingcheng',$mingcheng);
		$this->assign('tuanhao',$tuanhao);
		$this->assign('tianshu',$tianshu);
		$this->assign('chutuanriqi',$chutuanriqi);
		$this->assign('tuanyuan',$tuanyuan);
		
		$title = date('YmdHis');
		
		//导出Word必备头
		header("Content-type:application/msword");
		header("Content-Disposition:attachment;filename=" . $title . ".doc");
		header("Pragma:no-cache");        
		header("Expires:0");    
		
		$this->display();
	}


    public function dodeletezituan() {
		
		$postdata = $_POST;
		
		$Glzituan = D('Glzituan');
		$gldingdan = D('gldingdan');
		foreach($postdata['itemlist'] as $zituanID)
		{
			$tuan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
			xianluIsDepartment($tuan['xianluID'],$this);
			
			$zituan['zituanID'] = $zituanID;
			$zituan['zhuangtai'] = '回收站';
			$Glzituan->save($zituan);
			
			$dingdanall = $gldingdan->where("`zituanID` = '$zituanID'")->findall();
			foreach($dingdanall as $v){
				$v['check_status'] = '回收站';
				$gldingdan->save($v);
			}
			//记录
			A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','放入回收站');
			
		}
		
		if($_POST['forward'])
		$rurl = $_POST['forward'];
		doalert('子团及订单被放入回收站',$rurl);
		
	}


    public function huishouzhan() {
		
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'iframe'|| $key == 'pagenum')
			continue;
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		$condition['zhuangtai'] = '回收站';
			
		//$condition = listmydepartment($this,$condition);
		//dump($condition);
		//同业，办事处相应修改   by gaoyang
		if(checkByAdminlevel('办事处管理员',$this)){
			$condition['lvxingsheID']	=	$this->roleuser["lvxingsheID"]; //取得
		}
		//搜索结束
		
		$navlist = '产品控管 > '.$_GET['guojing'].' > '.$_GET['xianlutype'].' >'.$_GET['kind'];
        $this->assign('navlist',$navlist);
		
		$glzituan = D("zituan_xianlu_lvxingshe");
		$glxianlu = D("glxianlu");
		

        import("@.ORG.Page");
        C('PAGE_NUMBERS',15);
		$count = $glzituan->where($condition)->count();
			
		$pagenum = $_GET['pagenum'];
		if(!$pagenum)
			$pagenum = 20;
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $zituanAll = $glzituan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		$shownum = count($zituanAll);
		$this->assign('zituanAll',$zituanAll);
        $this->assign('shownum',$shownum);
        $this->assign('page',$page);
		
//		$i = 0;
//		foreach($zituanAll as $v)
//		{
//			$xianlu = $glxianlu->where("`xianluID` = '$v[xianluID]' and `zhuangtai` = '报名'")->find();
//			if($xianlu)
//			{
//				$listall[$i] = $v;
//				$i++;
//			}
//		}
//		$this->assign('zituanAll',$listall);
		
		
		$this->display();
	}



    public function rebackzituan() {
		
		$postdata = $_POST;
		
		$Glzituan = D('Glzituan');
		$gldingdan = D('gldingdan');
		foreach($postdata['itemlist'] as $zituanID)
		{
			$zituan['zituanID'] = $zituanID;
			$zituan['zhuangtai'] = '报名';
			$Glzituan->save($zituan);
			
			$dingdanall = $gldingdan->where("`zituanID` = '$zituanID'")->findall();
			foreach($dingdanall as $v){
				if($v['check_status'] == '回收站')
				$v['check_status'] = '审核通过';
				$gldingdan->save($v);
			}
			//记录
			A("Message")->savemessage($zituan['zituanID'],'子团','操作记录','回收站还原状态报名');
			
		}
		
		if($_POST['forward'])
		$rurl = $_POST['forward'];
		doalert('子团及订单被还原',$rurl);
		
	}


	public function baozhangshenhe() {
		
		$Glzituan = D("Glzituan");
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'iframe'|| $key == 'pagenum')
			{
				$this->assign($key,$value);
				continue;
			}
			if($key == 'time1' || $key == 'time2')
			{
				$this->assign($key,$value);
				continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		if(!$condition['zhuangtai'])
			$condition['zhuangtai'] = array('in','报名,截止');
			
		$condition = listmydepartment($this,$condition);
		
		$start =date( "Y-m-d",strtotime($_GET['time1'])); 
		$end =date( "Y-m-d",strtotime($_GET['time2'])); 
		if($_GET['time1'] && $_GET['time2'])	
			$condition['chutuanriqi'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$condition['chutuanriqi'] = array('egt',$start);
		elseif($_GET['time2'])
			$condition['chutuanriqi'] = array('elt',$end);
		
		
		
		
		//搜索结束
		
		$condition['status'] = array('IN','计调申请,经理不通过,财务不通过');
		
		$navlist = '产品控管 > '.$_GET['guojing'].' > '.$_GET['xianlutype'].' >'.$_GET['kind'];
        $this->assign('navlist',$navlist);
		$zituan_xianlu = D("baozhang_zituan");
        import("@.ORG.Page");
        C('PAGE_NUMBERS',15);
		$count = $zituan_xianlu->where($condition)->count();
			
		$pagenum = $_GET['pagenum'];
		if(!$pagenum)
			$pagenum = 20;
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $zituanAll = $zituan_xianlu->where($condition)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->select();
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
			//$shengyu = F_getzituanrenshu($zituan['zituanID']);
			$zituanAll[$i]['shengyu'] = $shengyu;
			
			
			//发布人
			$Glkehu = D("Glkehu");
			$kehu = $Glkehu->where("`user_name` = '$zituan[user_name]'")->find();
			$zituanAll[$i]['realname'] = $kehu['realname'];
			//报账单
			$gl_baozhang = D("gl_baozhang");
			$bzd = $gl_baozhang->where("`zituanID` = '$zituan[zituanID]'")->find();
			if($bzd['status'] == '')	
			$zituanAll[$i]['bzd_status'] = '未报账';
			if($bzd['status'] == '计调申请')	
			$zituanAll[$i]['bzd_status'] = '已申请';
			if($bzd['status'] == '经理通过')	
			$zituanAll[$i]['bzd_status'] = '财务审核';
			if($bzd['status'] == '财务通过')	
			$zituanAll[$i]['bzd_status'] = '已报账';
			if($bzd['status'] == '经理不通过' || $bzd['status'] == '财务不通过')	
			$zituanAll[$i]['bzd_status'] = '未通过';
			
			
			$i++;
		}
		
        $this->assign('zituanAll',$zituanAll);
		if($_GET['iframe'])
		$this->display('myzituan');
		else
		$this->display('sankekongguan');
    }

	public function fenfang() {
		$zituanID = $_GET['zituanID'];
		
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();

		$glfenfang = D('Gl_fenfang');
		$fang_all = $glfenfang->where("`zituanID` = '$zituanID'")->findall();
		
		$Gltuanyuan = D('Tuanyuan_fenfang');
		
		foreach($fang_all as $key => $fang){
			$tuanyuanAll = $Gltuanyuan->where("`fenfangID` = '$fang[fenfangID]'")->findall();
			$fang_all[$key]['tuanyuanAll'] = $tuanyuanAll;
		}
		
		$this->assign('fang_all',$fang_all);
        $this->assign('zituan',$zituan);


		$this->assign('location','分房安排');
		$this->assign('navlist','产品控管 > '.$zituan['guojing'].' > 分房安排');
		
		if($_GET['doexport'])	{
			//导出Word必备头
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . time() . ".doc");
			header("Pragma:no-cache");        
			header("Expires:0");  
			$this->display('exportfenfang');
		}
		else	$this->display();
    }



    public function select_tuanyuan() {
		$zituanID = $_GET['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		$Gltuanyuan = D("tuanyuan_dingdan");
		$Gldingdan = D("dingdan_zituan");
		$dingdanAll = $Gldingdan->where("`zituanID` = '$zituanID'")->findall();
		
		$fenfangID = $_GET['fenfangID'];
		$glfenfang = D('Gl_fenfang');
		$glfenfanglist = D('Gl_fenfanglist');
		
		//剔除已分配的团员 by heavenK
		$fenfangs = $glfenfang->where("`zituanID` = $zituanID")->field('fenfangID')->findall();
		foreach($fenfangs as $key => $fenfang){
				if($key == 0) $fenfangIDs = $fenfang['fenfangID'];
				else $fenfangIDs .= ",".$fenfang['fenfangID'];
		}
		if ($fenfangID) {
			$conditions['fenfangID'] = array('IN',$fenfangIDs);
			
			$ids = $glfenfanglist->where($conditions)->field('tuanyuanID')->findall();

			foreach($ids as $key => $id){
					if($key == 0) $tuanyuanID = $id['tuanyuanID'];
					else $tuanyuanID .= ",".$id['tuanyuanID'];
			}
		}
		
		$gllvxingshe = D("gllvxingshe");
		$i = 0;
		foreach($dingdanAll as $dingdan)
		{
			$wheres['dingdanID'] = $dingdan['dingdanID'];
			if ($tuanyuanID)	$wheres['tuanyuanID'] = array('NOT IN',$tuanyuanID);
			
			$tuanyuanAll = $Gltuanyuan->where($wheres)->findall();
			$dingdanAll[$i]['tuanyuanAll'] = $tuanyuanAll;
			
			$company = $gllvxingshe->where("`lvxingsheID` = '$dingdan[laiyuan]'")->find();
			$dingdanAll[$i]['companyname'] = $company['companyname'];
			
			$i++;
		}
		
        $this->assign('dingdanAll',$dingdanAll);
        $this->assign('dingdan',$dingdan);
        $this->assign('xianlu',$xianlu);
        $this->assign('zituan',$zituan);
		
		$this->assign('fenfangID',$fenfangID);
		
		$this->assign('location','人员分房安排');
		$this->assign('navlist','产品控管 > '.$zituan['guojing'].' > 人员分房安排');
        $this->display();
    }

	public function doselect_tuanyuan() {
		$id_array = $_POST['tuanyuanID'];
		$fenfangID = $_POST['fenfangID'];
		
		$glfenlist = D('Gl_fenfanglist');
		
		if($id_array && $fenfangID){
			foreach($id_array as $tuanyuanID){
					$data['tuanyuanID'] = $tuanyuanID;
					$data['fenfangID'] = $fenfangID;
					$data['time']  = time();
					$glfenlist->add($data);
			}
		   echo "<script language='javascript'>";
		   echo "alert('分配成功！');opener.location.reload();window.close();";
		   echo "</script>";
		}else{
			doalert('请选择团员！');	
		}
	}
	
	public function deltuanyuan(){
		$tuanyuanID = $_POST['tuanyuanID'];
		$fenfangID = $_POST['fenfangID'];
		
		$glfenlist = D('Gl_fenfanglist');
		
		if($fenfangID && $tuanyuanID){
				$glfenlist->where("`tuanyuanID` = $tuanyuanID AND `fenfangID` = $fenfangID")->delete();
				echo "success";
		}else{
			echo "false";
		}
		
	}
	
	public function delnew(){
		$fenfangID = $_POST['fenfangID'];
		
		$glfenfang = D('Gl_fenfang');
		$glfenlist = D('Gl_fenfanglist');
		
		if($fenfangID){
			$glfenfang->where("`fenfangID` = $fenfangID")->delete();
			$glfenlist->where("`fenfangID` = $fenfangID")->delete();
			echo "success";
		}else{
			echo "false";
		}
		
	}


    public function addfenfang() {
		$glzituan = D("glzituan");
		$zituanID =  $_GET['zituanID'];
		$zituan = $glzituan->where("`zituanID` = '$zituanID'")->find();
		if($zituan)
		$this->assign('zituan',$zituan);
		$fenfangID =  $_GET['fenfangID'];
		$gl_fenfang = D("gl_fenfang");
		$fenfang = $gl_fenfang->where("`fenfangID` = '$fenfangID'")->find();
		$this->assign('fenfang',$fenfang);
		$this->assign('navtile','分房安排');
        $this->display();
	}
	
	
	
    public function dopostfenfang() {
		$data = $_POST;
		if(!$data['title'] || $data['title'] == '')
			doalert("标题不能为空",'');
		if(!$data['zituanID'] || $data['zituanID'] == '')
			doalert("错误",'');
		$gl_fenfang = D("gl_fenfang");
		if($_POST['fenfangID'])
		{
			$gl_fenfang->save($data);
		}
		else
		{	
			$data['time'] = time();
			$data['adduser'] = $this->roleuser['user_name'];
			$gl_fenfang->add($data);
		}
		$rurl = SITE_ADMIN."Kongguan/fenfang/zituanID/".$data['zituanID'];
		doalert("成功",$rurl);
		
	}

	
	
	
	
	
	
	
	

}
?>