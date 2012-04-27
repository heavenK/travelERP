<?php

class ShenheAction extends CommonAction{

    public function sankechanpin() {
		
		$Glxianlu = D("xianlu_lvxingshe");
		$Glxianlujiage = D("Glxianlujiage");
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			continue;
			if($key == 'chufariqi' || $key == 'jiezhiriqi'){
				$this->assign($key,$value);
				continue;
			}
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
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
		
		if($_GET['xianlutype'] == '包团')
			$condition['xianlutype'] = '包团';
		elseif($_GET['xianlutype'] == '自由人')
			$condition['xianlutype'] = '自由人';
		else
			$condition['xianlutype'] = '散客产品';
			
		$condition['zhuangtai'] = '等待审核';
		$condition = listmydepartment($this,$condition);
		
		
		//搜索结束
		
		//搜索人员需要
		$glkehu = D('Glkehu');
		$kehu_all = $glkehu->findall();
		$this->assign('kehu_all',$kehu_all);
		
		//同业，办事处相应修改   by gaoyang
		if(checkByAdminlevel('办事处管理员',$this)){
			$condition['lvxingsheID']	=	$this->roleuser["lvxingsheID"]; //取得
		}
		//dump($condition);
		//修改结束 by gaoyang
		
		
		if($_GET['companytype'] == '同业'){
			unset($condition['companytype']);
			$condition['companytype'] = '同业'; 	
		}
		if(checkByadminlevel('联合体管理员',$this)){
			unset($condition['user_name']);
			unset($condition['departmentID']);
		}
		

		$kind = $_GET['kind'];
		$guojing = $_GET['guojing'];

		$navlist = '产品审核 > '.$_GET['guojing'].' > '.$condition['xianlutype'].' >'.$_GET['kind'];
        $this->assign('navlist',$navlist);
		
        import("@.ORG.Page");
        C('PAGE_NUMBERS',20);
		$count = $Glxianlu->where($condition)->count();
		
		$p= new Page($count,20);
		//$rurl = SITE_ADMIN."Shenhe/sankechanpin/guojing/".$_GET['guojing']."/p/";
		$page = $p->show();
        $xianludatas = $Glxianlu->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
        $this->assign('page',$page);
		
		//数据解析
		$i = 0;
		foreach($xianludatas as $xianlu){
			$chutuanriqi = split('[;]',$xianlu['chutuanriqi']);
			foreach($chutuanriqi as $riqi){
				if($newdatelist)
				$newdatelist .= ','."'".$riqi."'";
				else
				$newdatelist .= "'".$riqi."'";
			}
			$xianludatas[$i]['chutuanriqi'] = $newdatelist;
			$newdatelist = '';
			$jiage = $Glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
			$xianludatas[$i]['chengrenzongjia'] = $jiage['chengrenzongjia'];
			//发布人
			$Glkehu = D("Glkehu");
			$kehu = $Glkehu->where("`user_name` = '$xianlu[user_name]'")->find();
			$xianludatas[$i]['realname'] = $kehu['realname'];//大概要连表
			$i++;
		}
		
		
		

		//获得部门人员列表
		$department_list = unserialize($this->adminuser['department_list']);
		$glkehu = D("glkehu");
		foreach($department_list as $v){
		$userlist[] = $glkehu->where("`department` = '$v'")->findall();
		}
		foreach($userlist as $v){
			foreach($v as $t)
			{
				$users[] = $t['user_name'];
			}
		}
        $this->assign('users',$users);
		
		
		
        $this->assign('xianludatas',$xianludatas);
        $this->display();
    }


    public function shenhecaozuo() {
		$xianluID = $_GET['xianluID'];
		$caozuo = $_GET['caozuo'];
		$Glxianlu = D("Glxianlu");
		$Glzituan = D("Glzituan");
		//判断状态
		$condition['zhuangtai'] = array('IN','等待审核');
		$condition['xianluID'] = $xianluID;
		$xianlu = $Glxianlu->where($condition)->find();
		
		$xianlu_lvxingshe = D("xianlu_lvxingshe");
		$x_l = $xianlu_lvxingshe->where($condition)->find();
		
		if(!$xianlu)
			doalert('操作失败，状态错误','');
		if($x_l['companytype'] == '同业')	
			domydepartment_sp2($this,$x_l);
		else
			domydepartment($this,$xianlu['user_name']);
		
		$zituanAll = $Glzituan->where("`xianluID` = '$xianluID'")->findall();
		if($caozuo == '成功')
		{
			//判断自由人
			//为每个子团生成价格
			if($xianlu['xianlutype'] == '自由人')
			$this->shengchengjiage($xianlu['xianluID']);
			
			$xianlu['zhuangtai'] = '报名';
			$xianlu['islock'] = '已锁定';
			$Glxianlu->save($xianlu);
			foreach($zituanAll as $zituan)
			{
				$zituan['zhuangtai'] = '报名';
				$zituan['islock'] = '已锁定';
				$Glzituan->save($zituan);
			}
			$neirong = "线路通过审核,锁定线路及所有子团，并改变状态为报名";
		}
		if($caozuo == '失败')
		{
			$xianlu['zhuangtai'] = '审核不通过';
			$Glxianlu->save($xianlu);
			foreach($zituanAll as $zituan)
			{
				if($zituan['zhuangtai'] == '等待审核')
				$zituan['zhuangtai'] = '审核不通过';
				$Glzituan->save($zituan);
			}
			$neirong = "线路审核不通过,改变线路及子团状态为审核不通过";
			A("Message")->savemessage($xianluID,'线路','需求应答',$neirong,'计调操作员',$megurl);
		}
		//提示
		$megurl = SITE_ADMIN."Chanpin/editlvyouxianlu/xianluID/".$xianluID;
		A("Message")->savemessage($xianluID,'线路','审核记录',$neirong,'计调操作员',$megurl);
		
		$xianlutype = $_GET['xianlutype'];
		doalert('该线路已'.$neirong,$rurl);
    }

	//删除所有子团价格并重新生成新价格
    private function shengchengjiage($xianluID) {
		
		$Glxianlujiage = D("Glxianlujiage");
		$xianlujiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();
		//清空线路下子团价格并重新生成
		$Glzituan = D("Glzituan");
		$zituanAll = $Glzituan->where("`xianluID` = '$xianluID'")->findall();
		foreach($zituanAll as $zituan)
		{
			$oldzituanjiage = $Glxianlujiage->where("`zituanID` = '$zituan[zituanID]'")->find();
			$Glxianlujiage->where("`zituanID` = '$zituan[zituanID]'")->delete();
			$newzituanjiage['zituanID'] = $zituan['zituanID'];
			$newzituanjiage['time'] = time();
			$newzituanjiage['xuanzetype'] = $xianlujiage['xuanzetype'];
			$newjiageID =$Glxianlujiage->add($newzituanjiage);
			
			//生成票副本
			$Glticketorder = D("Glticketorder");
			$Glticketorder->where("`jiageID` = '$oldzituanjiage[jiageID]'")->delete();
			$ticketAll = $Glticketorder->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
			foreach($ticketAll as $ticket)
			{
				$copyticket = $ticket;
				$copyticket['jiageID'] = $newjiageID;
				$copyticket['ticketorderID'] = "";
				$Glticketorder->add($copyticket);
			}
			//生成一日游副本
			$Glyiriyou = D("Glyiriyou");
			$Glyiriyou->where("`jiageID` = '$oldzituanjiage[jiageID]'")->delete();
			$yiriyouAll = $Glyiriyou->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
			foreach($yiriyouAll as $yiriyou)
			{
				$copyyiriyou = $yiriyou;
				$copyyiriyou['jiageID'] = $newjiageID;
				$copyyiriyou['yiriyouID'] = "";
				$Glyiriyou->add($copyyiriyou);
			}
			//生成代理副本
			$Glshoujia = D("Glshoujia");
			$Glshoujia->where("`jiageID` = '$oldzituanjiage[jiageID]'")->delete();
			$shoujiaAll = $Glshoujia->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
			foreach($shoujiaAll as $shoujia)
			{
				$copyshoujia = $shoujia;
				$copyshoujia['jiageID'] = $newjiageID;
				$copyshoujia['shoujiaID'] = '';
				//$copyyiriyou['xianluID'] = "";
				$Glshoujia->add($copyshoujia);
			}
		}
	}


    public function baozhangdanlist() {
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
        $this->assign("departmentAll",$departmentAll);
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'iframe'|| $key == 'pagenum'|| $key == 'xianlutype'|| $key == 'roletype')
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
		
		
		$start =date( "Y-m-d",strtotime($_GET['time1'])); 
		$end =date( "Y-m-d",strtotime($_GET['time2'])); 
		if($_GET['time1'] && $_GET['time2'])	
			$condition['chutuanriqi'] = array('between',"'".$start."','".$end."'");
		elseif($_GET['time1'])
			$condition['chutuanriqi'] = array('egt',$start);
		elseif($_GET['time2'])
			$condition['chutuanriqi'] = array('elt',$end);
		
		if($_GET['roletype'] == '计调经理')
			$condition['status'] = '计调申请';
		if($_GET['roletype'] == '财务操作员')
			$condition['status'] = '经理通过';
		if($_GET['roletype'] == '总经理')
			$condition['status'] = '财务通过';
		$condition = listmydepartment($this,$condition);
			
		unset($condition['belongID']);
		unset($condition['companytype']);
		
		//dump($condition);
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		
		if($_GET['xianlutype'] == '地接')
		{
			$condition['baozhangID'] = array('exp','is not null');
			
			$caiwu_djtuan_info = D("caiwu_djtuan_info");
			$count = $caiwu_djtuan_info->where($condition)->count();
			$pagenum = $_GET['pagenum'];
			if(!$pagenum)
				$pagenum = 20;
			$p= new Page($count,$pagenum);
			$page = $p->show();
			$this->assign('page',$page);
			$xianludatas = $caiwu_djtuan_info->where($condition)->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->select();
			$i = 0;
			foreach($xianludatas as $v){
				$xianludatas[$i]['xianlutype'] = '地接';
				$xianludatas[$i]['guojing'] = $v['jingwai'];
				$xianludatas[$i]['zhuangtai'] = $v['zituanstatus'];
				$i++;
			}
		}
		else
		{
			if($_GET['xianlutype'] != '组团')
			$condition['xianlutype'] = $_GET['xianlutype'];
			$baozhang_zituan = D("baozhang_zituan");
			$count = $baozhang_zituan->where($condition)->count();
			$pagenum = $_GET['pagenum'];
			if(!$pagenum)
				$pagenum = 20;
			$p= new Page($count,$pagenum);
			$page = $p->show();
			$this->assign('page',$page);
			$baozhangAll = $baozhang_zituan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
			$xianludatas = $baozhangAll;
		}
		
		$this->assign('pagenum',$pagenum);
        $this->assign('xianludatas',$xianludatas);
		if($_GET['pagenum'])
		$this->display('mybaozhang');
		else
		$this->display('Caiwuguanli/baozhanglist');
	}
	
	
	
//edit by gaopeng 2012 3 6	
	
    public function bzdshenhe() {
		
		if($_GET['zituanID'])
		{
			$zituanID = $_GET['zituanID'];
			$bzd = D("gl_baozhang");
			$baozhangdan = $bzd->where("`zituanID` = '$zituanID'")->find();
			$glzituan = D("glzituan");
			$zituan = $glzituan->where("`zituanID` = '$zituanID'")->find();
			$user_name = $zituan['user_name'];
		}
		elseif($_GET['djtuanID'])
		{
			$djtuanID = $_GET['djtuanID'];
			$bzd = D("dj_baozhang");
			$baozhangdan = $bzd->where("`djtuanID` = '$djtuanID'")->find();
			$dj_tuan = D("dj_tuan");
			$djtuan = $dj_tuan->where("`djtuanID` = '$djtuanID'")->find();
			$user_name = $djtuan['adduser'];
		}
		//domydepartment($this,$user_name);
		
		if($baozhangdan)
		{
			$baozhangID = $baozhangdan['baozhangID'];
			$baozhangdan['status'] = $_GET['dotype'];
			
			$zt_shenhe_jl = SITE_ADMIN."Chanpin/editlvyouxianlu/showtype/审核/roletype/计调经理/xianluID/".$xianluID."/zituanID/".$zituanID;
			$zt_shenhe_zjl = SITE_ADMIN."Chanpin/editlvyouxianlu/showtype/审核/roletype/总经理/xianluID/".$xianluID."/zituanID/".$zituanID;
			$zt_shenhe_cw = SITE_ADMIN."Chanpin/editlvyouxianlu/showtype/审核/roletype/财务操作员/xianluID/".$xianluID."/zituanID/".$zituanID;
			$zt_shenhe_cwzj = SITE_ADMIN."Chanpin/editlvyouxianlu/showtype/审核/roletype/财务总监/xianluID/".$xianluID."/zituanID/".$zituanID;
			$zt_kongguan = SITE_ADMIN."Kongguan/baozhangdan/xianluID/".$xianluID."/zituanID/".$zituanID;
			
			$dj_shenhe_jl = SITE_DIJIE."Tuancontrol/baozhangdan/showtype/审核/roletype/地接经理/djtuanID/".$djtuanID;
			$dj_shenhe_zjl = SITE_DIJIE."Tuancontrol/baozhangdan/showtype/审核/roletype/总经理/djtuanID/".$djtuanID;
			$dj_shenhe_cw = SITE_DIJIE."Tuancontrol/baozhangdan/showtype/审核/roletype/财务操作员/djtuanID/".$djtuanID;
			$dj_shenhe_cwzj = SITE_DIJIE."Tuancontrol/baozhangdan/showtype/审核/roletype/财务总监/djtuanID/".$djtuanID;
			$dj_kongguan = SITE_DIJIE."Tuancontrol/baozhangdan/djtuanID/".$djtuanID;
			
			//计调
			if($_GET['dotype'] == '计调申请' || $_GET['dotype'] == '地接申请'){
				
//					if($baozhangdan['status']=='经理通过' || $baozhangdan['status']=='财务通过' || $baozhangdan['status']=='总经理通过')
//					{
//							doalert("报账单正在审核中！",'');
//					}
					$baozhangdan['status'] = $_GET['dotype'];
					if($djtuanID)
					{
							if(!checkByAdminlevel('地接操作员,网管',$this))
								doalert("失败！权限错误！",'');
							if($baozhangdan['manager'] || $baozhangdan['financeperson'] || $baozhangdan['caiwuzongjian'] || $baozhangdan['departmentperson'])
								doalert("失败！报账单正在审核中！",'');
							$baozhangdan['operateperson'] = $this->roleuser['realname'];
							$bzd->save($baozhangdan);
							A("Message")->savemessage($baozhangID,'地接报账单','审核记录','申请报账单审核','地接经理',$dj_shenhe_jl);
					}
					if($zituanID)
					{
							if(!checkByAdminlevel('计调操作员,网管',$this))
								doalert("失败！权限错误！",'');
							if($baozhangdan['caiwuren'] || $baozhangdan['caiwuzongjian'] || $baozhangdan['bumenren'] || $baozhangdan['manager'])
								doalert("失败！报账单正在审核中！",'');
							$baozhangdan['caozuoren'] = $this->roleuser['realname'];
							$bzd->save($baozhangdan);
							A("Message")->savemessage($baozhangID,'报账单','审核记录','申请报账单审核','计调经理',$zt_shenhe_jl);
					}
			}
			
			//经理
			if($_GET['dotype'] == '经理通过' || $_GET['dotype'] == '经理不通过'){
					if($zituanID)
					{
							if(!checkByAdminlevel('计调经理,网管',$this))
								doalert("失败！权限错误！",'');
							if(!$baozhangdan['caozuoren'])
								doalert("失败！计调未提交报账单申请！",'');
							if($baozhangdan['manager'] || $baozhangdan['caiwuren'] || $baozhangdan['caiwuzongjian'])
								doalert("失败！报账单正在上级审核中！",'');
					}
					if($djtuanID)
					{
							if(!checkByAdminlevel('计调经理,地接经理,网管',$this))
								doalert("失败！权限错误！",'');
							if(!$baozhangdan['operateperson'])
								doalert("失败！计调未提交报账单申请！",'');
							if($baozhangdan['manager'] || $baozhangdan['financeperson'] || $baozhangdan['caiwuzongjian'])
								doalert("失败！报账单正在上级审核中！",'');
					}
					if($_GET['dotype'] == '经理通过')
					{
							$baozhangdan['islock'] = '已锁定';
							if($djtuanID)
							{
								$baozhangdan['departmentperson'] = $this->roleuser['realname'];
								$bzd->save($baozhangdan);
								A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','财务操作员',$dj_shenhe_cw);
							}
							if($zituanID)
							{
								$baozhangdan['bumenren'] = $this->roleuser['realname'];
								$bzd->save($baozhangdan);
								A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','财务操作员',$zt_shenhe_cw);
							}
					}
					if($_GET['dotype'] == '经理不通过')
					{
							if($djtuanID)
							{
								$baozhangdan['departmentperson'] = '';
								$bzd->save($baozhangdan);
								A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','地接操作员',$dj_kongguan);
							}
							if($zituanID)
							{
								$baozhangdan['bumenren'] = '';
								$bzd->save($baozhangdan);
								A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','计调操作员',$zt_kongguan);
							}
					}
			}
			
			
			//财务
			if($_GET['dotype'] == '财务通过' || $_GET['dotype'] == '财务不通过'){
					if(!checkByAdminlevel('财务操作员,网管',$this))
						doalert("权限错误！",'');
					if($zituanID)
					{
							if(!$baozhangdan['caozuoren'] || !$baozhangdan['bumenren'])
									doalert("失败！经理未审核通过！",'');
							if($baozhangdan['manager'] || $baozhangdan['caiwuzongjian'])
									doalert("失败！报账单正在上级审核中！",'');
					}
					if($djtuanID)
					{
							if(!$baozhangdan['operateperson'] || !$baozhangdan['departmentperson'])
									doalert("失败！经理未审核通过！",'');
							if($baozhangdan['manager'] || $baozhangdan['caiwuzongjian'])
									doalert("失败！报账单正在上级审核中！",'');
					}
						
					if($_GET['dotype'] == '财务通过')
					{
						$baozhangdan['islock'] = '已锁定';
						if($djtuanID)
						{
							$baozhangdan['financeperson'] = $this->roleuser['realname'];
							$baozhangdan['caiwu_time'] = strtotime("now");
							$bzd->save($baozhangdan);
							//子团截止
							$djtuan['status'] = '截止';
							$dj_tuan->save($djtuan);
							A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','总经理',$dj_shenhe_zjl);
						}
						if($zituanID)
						{
							$baozhangdan['caiwuren'] = $this->roleuser['realname'];
							$baozhangdan['caiwu_time'] = strtotime("now");
							$bzd->save($baozhangdan);
							
							//子团截止
							$zituan['zhuangtai'] = '截止';
							$glzituan->save($zituan);
							F_xianlu_status_set($zituan['xianluID']);
							
							A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','总经理',$zt_shenhe_zjl);
						}
						
					}
					if($_GET['dotype'] == '财务不通过')
					{
						if($djtuanID)
						{
							$baozhangdan['financeperson'] = '';
							$bzd->save($baozhangdan);
							A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','地接操作员',$dj_kongguan);
							A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','地接经理',$dj_shenhe_jl);
						}
						if($zituanID)
						{
							$baozhangdan['caiwuren'] = '';
							$bzd->save($baozhangdan);
							A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','计调操作员',$zt_kongguan);
							A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','计调经理',$zt_shenhe_jl);
						}
					}
			}
			
			
			
			//财务总监
			if($_GET['dotype'] == '财务总监通过' || $_GET['dotype'] == '财务总监不通过'){
					if(!checkByAdminlevel('财务总监,网管',$this))
						doalert("权限错误！",'');
					if($zituanID)
					{
							if(!$baozhangdan['caozuoren'] || !$baozhangdan['bumenren'] || !$baozhangdan['caiwuren'])
									doalert("失败！财务未审核通过！",'');
							if($baozhangdan['manager'])
									doalert("失败！报账单正在上级审核中！",'');
					}
					if($djtuanID)
					{
							if(!$baozhangdan['operateperson'] || !$baozhangdan['departmentperson'] || !$baozhangdan['financeperson'])
									doalert("失败！财务未审核通过！",'');
							if($baozhangdan['manager'])
									doalert("失败！报账单正在上级审核中！",'');
					}
					if($_GET['dotype'] == '财务总监通过')
					{
						$baozhangdan['islock'] = '已锁定';
						if($djtuanID)
						{
							$baozhangdan['caiwuzongjian'] = $this->roleuser['realname'];
							A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','财务总监',$dj_shenhe_cwzj);
							A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','总经理',$dj_shenhe_zjl);
						}
						if($zituanID)
						{
							$baozhangdan['caiwuzongjian'] = $this->roleuser['realname'];
							A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','财务总监',$zt_shenhe_cwzj);
							A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','总经理',$zt_shenhe_zjl);
						}
					}
					if($_GET['dotype'] == '财务总监不通过')
					{
						if($djtuanID)
						{
							$baozhangdan['caiwuzongjian'] = '';
							A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','地接操作员',$dj_kongguan);
							A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','地接经理',$dj_shenhe_jl);
							A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','财务操作员',$dj_shenhe_cw);
						}
						if($zituanID)
						{
							$baozhangdan['caiwuzongjian'] = '';
							A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','计调操作员',$zt_kongguan);
							A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','计调经理',$zt_shenhe_jl);
							A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','财务操作员',$zt_shenhe_cw);
						}
						
					}
					$bzd->save($baozhangdan);
			}
			
			
			//总经理
			if($_GET['dotype'] == '总经理通过' || $_GET['dotype'] == '总经理不通过'){
					if(!checkByAdminlevel('总经理,网管',$this))
						doalert("权限错误！",'');
					if($_GET['dotype'] == '总经理通过')
					{
						$baozhangdan['islock'] = '已锁定';
						//到备份
						$gl_bzdbackup = D('gl_bzdbackup');
						if($djtuanID)
						{
								if(!$baozhangdan['operateperson'] || !$baozhangdan['departmentperson'] || !$baozhangdan['financeperson'] || !$baozhangdan['caiwuzongjian'])
										doalert("失败！财务未审核通过！",'');
								$baozhangdan['manager'] = $this->roleuser['realname'];
								$bzd->save($baozhangdan);
								
								$backup['tuanID'] = $djtuanID;
								$backup['tuantype'] = '地接';
								$DJbaozhangitem = D('dj_baozhangitem');
								$itemAll = $DJbaozhangitem->where("`baozhangID` = '$baozhangID'")->findall();
						}
						if($zituanID)
						{
								if(!$baozhangdan['caozuoren'] || !$baozhangdan['bumenren'] || !$baozhangdan['caiwuren'] || !$baozhangdan['caiwuzongjian'])
										doalert("失败！财务未审核通过！",'');
								$baozhangdan['manager'] = $this->roleuser['realname'];
								$bzd->save($baozhangdan);
								
								$backup['tuanID'] = $zituanID;
								$backup['tuantype'] = '组团';
								$gl_baozhangitem = D('gl_baozhangitem');
								$itemAll = $gl_baozhangitem->where("`baozhangID` = $baozhangID")->findall();
						}
						$baozhangdan['itemAll'] = $itemAll;
						$backup['content'] = serialize($baozhangdan) ;
						$backup['time'] = time();
						
						$gl_bzdbackup->add($backup);
					}
					
					if($_GET['dotype'] == '总经理不通过')
					{
							if($djtuanID)
							{
								$baozhangdan['manager'] = '';
								$bzd->save($baozhangdan);
							}
							if($zituanID)
							{
								$baozhangdan['manager'] = '';
								$bzd->save($baozhangdan);
							}
					}
					//提示
					if($djtuanID){
						A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','地接操作员',$dj_kongguan);
						A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','地接经理',$dj_shenhe_jl);
						A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','财务操作员',$dj_shenhe_cw);
						A("Message")->savemessage($baozhangID,'地接报账单','审核记录',$_GET['dotype'].'报账单审核','财务总监',$dj_shenhe_cwzj);
					}
					else{
						A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','计调操作员',$zt_kongguan);
						A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','计调经理',$zt_shenhe_jl);
						A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','财务操作员',$zt_shenhe_cw);
						A("Message")->savemessage($baozhangID,'报账单','审核记录',$_GET['dotype'].'报账单审核','财务总监',$zt_shenhe_cwzj);
					}
			}
			
			$bzd->save($baozhangdan);
			doalert($_GET['dotype'].'操作成功','');
		}
		else
			doalert('错误！不存在报账单','');
    }


//end


    public function baozhangdanjw_dj() {
		$navlist = "团队管理 > 团队控管 > 报账单";
		$this->assign('navlist',$navlist);
		$djtuanID = $_GET['djtuanID'];
		$DJtuan = D('dj_tuan');
		$tuan = $DJtuan->where("`djtuanID` = '$djtuanID'")->find();
		if(!$tuan)
			doalert("团队不存在",SITE_ADMIN."Caiwuguanli/tuanlist");
		$this->assign('tuan',$tuan);
		
		$DJbaozhang = D('dj_baozhang');
		$baozhang = $DJbaozhang->where("`djtuanID` = '$tuan[djtuanID]'")->find();
		$this->assign('baozhang',$baozhang);
		$this->assign('location','报账单');
		$this->assign('printable','打印');
		
		if($_GET['doprint'])
		{
			$glkehu = D('glkehu');
			$kehuuser = $glkehu->where("`user_name` = '$tuan[adduser]'")->find();
			
			$this->assign('kehuuser',$kehuuser);
			$gllvxingshe = D('gllvxingshe');
			$company = $gllvxingshe->where("`lvxingsheID` = '$kehuuser[lvxingsheID]'")->find();
			$this->assign('company',$company);
			$this->display('printbaozhangdanriben');
			
		}
		else
		{
			$this->display('baozhangdanriben');
		}
	}

    public function dingdancaozuo() {
		
		$postdata = $_POST;
		$zituanID = $postdata['zituanID'];
		if($postdata['caozuotype'] == '订单锁定')
		$islock = '已锁定';
		if($postdata['caozuotype'] == '订单解锁')
		$islock = '未锁定';
		if($postdata['caozuotype'] == '支付')
		$daokuan = '已付款';
		if($postdata['caozuotype'] == '未支付')
		$daokuan = '未付款';
		
		$Glmessage = D("Glmessage");
		$MessageAction = A("Message");
		$Gldingdan = D("gldingdan");
		
		foreach($postdata['itemlist'] as $item)
		{
			$dingdanID = $item;
			$arr['dingdanID'] = $dingdanID;
			if($daokuan)
			$arr['daokuancw'] = $daokuan;
			if($islock)
			$arr['islock'] = $islock;
			
			$Gldingdan->save($arr);
			//保留记录
			$MessageAction->savemessage($arr['dingdanID'],'订单','操作记录',$postdata['caozuotype']);
		}

		doalert($postdata['caozuotype'].'操作成功','');
	
    }



    public function docheck() {
			
		$postdata = $_POST;
		$item['applypaymentID'] = $postdata['applypaymentID'];
		$item['status'] = $postdata['type'];
		
		$DJapplypayment = D('dj_applypayment');
		if($item['applypaymentID'] == null){
			echo "false";
			exit;
		}
		$DJapplypayment->save($item);
		echo $item['status'];
	}
	


	function showbackuplist()
	{
		$zituanID = $_GET["zituanID"];
		$djtuanID = $_GET["djtuanID"];
		$gl_bzdbackup = D("gl_bzdbackup");
		if($zituanID)
		{
			$where['tuanID'] = array('eq',$zituanID);
			$where['tuantype'] = array('eq','组团');
		}
		if($djtuanID)
		{
			$where['tuanID'] = array('eq',$djtuanID);
			$where['tuantype'] = array('eq','地接');
		}
		
		$dataAll = $gl_bzdbackup->where($where)->order("time desc")->findall();
		
		$this->assign('dataAll',$dataAll);
		$this->display('Message/showbackup');
	}


	function showbzdbackup()
	{
		$id = $_GET["id"];
		$bzdbackup_zituan_djtuan = D("bzdbackup_zituan_djtuan");
		$bzd = $bzdbackup_zituan_djtuan->where("`id` = '$id'")->find();
			
		if($bzd['tuantype']=='组团')
		{
				tiaozhuan(SITE_ADMIN.'Kongguan/baozhangdan/datatype/backup/doprint/1/id/'.$id);	
		}
		elseif($bzd['tuantype']=='地接')
		{
				tiaozhuan(SITE_DIJIE.'Tuancontrol/baozhangdan/datatype/backup/doprint/1/id/'.$id);	
		}
		else
			doalert("错误",'');
		
	}


    public function dingdanshenhe() {
		
		$dingdanID = $_GET["dingdanID"];
		$Gldingdan = D("gldingdan");
		$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		
		$dingdan_xianlu_lvxingshe = D("dingdan_xianlu_lvxingshe");
		$dingdan_xl = $dingdan_xianlu_lvxingshe->where("`dingdanID` = '$dingdanID'")->find();
		
		if($dingdan)
		{
			if(!checkByAdminlevel('计调经理,网管,总经理',$this))
			{
				if(checkByAdminlevel('联合体成员',$this))
				{
					if($dingdan_xl['lvxingsheID'] != $this->company['lvxingsheID'])
					doalert("你无权审核别人子团内的订单",'');
				}
				
				elseif(checkByAdminlevel('计调操作员',$this))
				{
					$glzituan = D("glzituan");
					$zituan = $glzituan->where("`zituanID` = '$dingdan[zituanID]'")->find();
					$myuser = $this->roleuser['user_name'];
//					if($zituan['user_name'] != '$myuser')
//						doalert("你无权审核别人子团内的订单",'');
					
				}
				else
					doalert("你无权审核别人子团内的订单",'');
			}
					
			if($_GET['check_status'] == '审核通过')		
			$dingdan['check_status'] = '审核通过';
			if($_GET['check_status'] == '审核不通过')		
			$dingdan['check_status'] = '审核不通过';
			$Gldingdan->save($dingdan);
			//msg
			$menshi_url = SITE_MENSHI."Dingdan/dingdanxinxi/dingdanID/".$dingdanID;
			A("Message")->savemessage($dingdanID,'订单','审核记录',$_GET['dotype'].'订单'.$_GET['check_status'],'门市操作员',$menshi_url);
			
			doalert("审核成功",'');
		}
			else
			doalert("错误",'');
		
	}












}
?>