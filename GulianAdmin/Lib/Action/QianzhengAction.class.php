<?php

class QianzhengAction extends CommonAction{

    public function index() {
            $this->redirect('qianzhenginfo');
    }

    public function qianzhenginfo() {
		
		$zituanID = $_GET['zituanID'];
		
		$kind = isset($_GET['kind']) ? $_GET['kind'] : '签证';
		$this->assign('kind',$kind);
		
		
		$zituan_xianlu = D("zituan_xianlu");
		$zituan = $zituan_xianlu->where("`zituanID` = $zituanID")->find();
		$this->assign('zituan',$zituan);
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'type')
			continue;
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		//区分单和跟团
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		if($type == 'tuan') $condition['zituanID'] = array('neq','0');
		elseif($type == 'dan') $condition['zituanID'] = '0';

		$condition = listmydepartment_qz($this,$condition);
		//查询分页
		$glqianzheng = D("qianzheng_department");
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $glqianzheng->where($condition)->count();
		//$count = $glqianzheng->where($condition)->count();
		$p= new Page($count,20);
		//$rurl = SITE_ADMIN."Qianzheng/qianzhenginfo/zituanID/".$zituanID."/p/";
		$page = $p->show();
		$this->assign('page',$page);
		
		//edit by gaopeng 2012 2 16
		if(checkByAdminlevel('计调经理,网管,财务操作员',$this)) '';
		//elseif(checkByAdminlevel('财务操作员',$this)) $condition['manager'] = array('neq','');
		elseif(checkByAdminlevel('财务总监',$this)) $condition['check_user'] = array('neq','');
		elseif(checkByAdminlevel('总经理',$this)) $condition['caiwu_manager'] = array('neq','');
		
        $qianzhengAll = $glqianzheng->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		$i = 0;
		$newwhere = '';
		
		if(checkByAdminlevel('计调经理,网管',$this)) $newwhere = '';
		//elseif(checkByAdminlevel('财务操作员',$this)) $newwhere = " and `manager` <> ''";
		elseif(checkByAdminlevel('财务操作员,财务总监',$this)) $newwhere = " and `manager` <> ''";
		//elseif(checkByAdminlevel('财务总监',$this)) $newwhere = " and `caiwu` <> ''";
		elseif(checkByAdminlevel('总经理',$this)) $newwhere = " and `caiwu_manager` <> ''";
		//end
		
		foreach($qianzhengAll as $qianzheng){
			$total_1 = 0;
			$total_2 = 0;
			$glqianzhengitem = D("glqianzhengitem");
			$itemAll = $glqianzhengitem->where("`qianzhengID` = '$qianzheng[qianzhengID]' and `type` = '应收费用'".$newwhere)->findAll();
			$num1 = $glqianzhengitem->where("`qianzhengID` = '$qianzheng[qianzhengID]' and `type` = '应收费用'".$newwhere)->count();
			$this->assign('itemAll',$itemAll);
			foreach($itemAll as $item){
					$total_1 += $item['value'];
			}
			$qianzhengAll[$i]['yingshou'] = $total_1;
			
			$itemAll = $glqianzhengitem->where("`qianzhengID` = '$qianzheng[qianzhengID]' and `type` = '费用明细'".$newwhere)->findAll();
			//$num1 = $glqianzhengitem->where("`qianzhengID` = '$qianzheng[qianzhengID]' and `type` = '费用明细'")->count();
			//$this->assign('itemAll',$itemAll);
			foreach($itemAll as $item){
					$total_2 += $item['value'];
			}
			$qianzhengAll[$i]['yingshou'] = $total_1;
			$qianzhengAll[$i]['yingfu'] = $total_2;
			
			$i++;
		}
		$this->assign('qianzhengAll',$qianzhengAll);
		
		$this->assign('location',$kind.'结算报告');
		$this->assign('navtile',$kind.'费用结算报告');
				
        $this->display();
    }

    public function addnew() {
		
		$zituanID = $_GET['zituanID'];
		
		$kind = isset($_GET['kind']) ? $_GET['kind'] : '签证';
		
		
		$zituan_xianlu = D("zituan_xianlu");
		$zituan = $zituan_xianlu->where("`zituanID` = $zituanID")->find();
		$this->assign('zituan',$zituan);
		
		$qianzhengID = $_GET['qianzhengID'];
		$glqianzheng = D("glqianzheng");
		$qianzheng = $glqianzheng->where("`qianzhengID` = '$qianzhengID'")->find();
		if($qianzhengID) $kind = $qianzheng['kind'];
		$this->assign('qianzheng',$qianzheng);
		
		$newwhere = '';
		
		if($_GET['printtype'] == '计调')
		{
			$newwhere = " and `manager` <> ''";
		}
		else	
		{
			if(checkByAdminlevel('计调经理,网管',$this)) $newwhere = '';
			elseif(checkByAdminlevel('财务操作员,财务总监',$this)) $newwhere = " and `manager` <> ''";
			//elseif(checkByAdminlevel('财务总监',$this)) $newwhere = " and `caiwu` <> ''";
			elseif(checkByAdminlevel('总经理',$this)) $newwhere = " and `caiwu_manager` <> ''";
		}
		
		if($_GET['doprint']){
			$newwhere .= " and status <> '准备'";
		}
		
		$glqianzhengitem = D("glqianzhengitem");
		$itemAll = $glqianzhengitem->where("`qianzhengID` = '$qianzhengID' and `type` = '应收费用'".$newwhere)->findAll();
		$num1 = $glqianzhengitem->where("`qianzhengID` = '$qianzhengID' and `type` = '应收费用'".$newwhere)->count();
		$this->assign('itemAll',$itemAll);
		foreach($itemAll as $item){
				$total_1 += $item['value'];
		}
		$this->assign('total_1',$total_1);
		
		$itemAll2 = $glqianzhengitem->where("`qianzhengID` = '$qianzhengID' and `type` = '费用明细'".$newwhere)->findAll();
		$num2 = $glqianzhengitem->where("`qianzhengID` = '$qianzhengID' and `type` = '费用明细'".$newwhere)->count();
		$this->assign('itemAll2',$itemAll2);
		foreach($itemAll2 as $item){
				$total_2 += $item['value'];
		}
		$this->assign('total_2',$total_2);
		
		$itemAll3 = $glqianzhengitem->where("`qianzhengID` = '$qianzhengID' and `type` = '部门利润'".$newwhere)->findAll();
		$num3 = $glqianzhengitem->where("`qianzhengID` = '$qianzhengID' and `type` = '部门利润'".$newwhere)->count();
		$this->assign('itemAll3',$itemAll3);
		foreach($itemAll3 as $item){
				$total_3 += $item['value'];
		}
		$this->assign('total_3',$total_3);
		
		$num = $num1 + $num2 + $num3;
		$this->assign('num',$num);
		$this->assign('num1',$num1);
		$this->assign('num2',$num2);
		$this->assign('num3',$num3);
		$lirun = $total_1 - $total_2;
		$this->assign('lirun',$lirun);
		
		
		$this->assign('navtile','添加'.$kind.'费用结算报告');
		
		$user = D('glkehu');
		$userAll = $user->order('user_id desc')->findall();
		$this->assign('userAll',$userAll);
		
		$this->assign('kind',$kind);
		
		if($_GET['doprint']){
			$user_name = $qianzheng['username'];
			$glkehu = D('user_company');
			$kehuuser = $glkehu->where("`user_name` = '$user_name'")->find();
			$this->assign('kehuuser',$kehuuser);
			
			
			//gp
			if($_GET['printtype'] == '计调')
			{
				if($qianzheng['kind'] == '订房')$this->display("print_hotel_2");
				elseif($qianzheng['kind'] == '机票')	$this->display("print_air_2");
				elseif($qianzheng['kind'] == '订车')	$this->display("print_hotel_2");
				elseif($qianzheng['kind'] == '订餐')	$this->display("print_hotel_2");
				elseif($qianzheng['kind'] == '订票')	$this->display("print_hotel_2");
				elseif($qianzheng['kind'] == '办证')	$this->display("print_hotel_2");
				elseif($qianzheng['kind'] == '订导游') $this->display("print_hotel_2");
				else $this->display('printinfo_2');
			}
			else
			{
				if($qianzheng['kind'] == '订房')$this->display("print_hotel");
				elseif($qianzheng['kind'] == '机票')	$this->display("print_air");
				elseif($qianzheng['kind'] == '订车')	$this->display("print_hotel");
				elseif($qianzheng['kind'] == '订餐')	$this->display("print_hotel");
				elseif($qianzheng['kind'] == '订票')	$this->display("print_hotel");
				elseif($qianzheng['kind'] == '办证')	$this->display("print_hotel");
				elseif($qianzheng['kind'] == '订导游') $this->display("print_hotel");
				else $this->display('printinfo');
			}
			
		}
		else{
			
			//gp
			if($kind == '订房')
				$this->display("addjiudian");
			elseif($kind == '机票')	$this->display("addnew_air");
			elseif($kind == '订车')	$this->display("addnew_car");
			elseif($kind == '订餐')	$this->display("addnew_food");
			elseif($kind == '订票')	$this->display("addnew_piao");
			elseif($kind == '办证')	$this->display("addnew_banz");
			elseif($kind == '订导游')	$this->display("addnew_daoyou");
        	else	$this->display();
		}
    }


    public function dopostqianzheng() {
		
		$postdata = $_POST;
		
		if($postdata['share_tuan'] == 'on')
		$postdata['share_tuan'] = 1;
		else
		$postdata['share_tuan'] = 0;
		
		if($postdata['tijiao'] == '1')	$postdata['status'] = '等待审核';
		unset($postdata['tijiao']);

		$glqianzheng = D("glqianzheng");
		if($postdata['qianzhengID']){
			$qianzheng = $glqianzheng->where("`qianzhengID` = '$postdata[qianzhengID]'")->find();
			if(!$qianzheng)
				doalert('错误','');
			$postdata['zituanID'] = $qianzheng['zituanID'];	
		
			if(!checkByAdminlevel('财务操作员,财务总监,网管,总经理',$this))
			{
/*				if($qianzheng['manager'])
					doalert('此信息已确认，不能修改或删除','');*/
				if($qianzheng['status'] == '总经理通过' || $qianzheng['status'] == '财务总监通过' || $qianzheng['status'] == '财务通过' || $qianzheng['status'] == '经理通过')
					doalert('此信息已确认，不能修改或删除','');
			}
			
			$glqianzheng->save($postdata);
			$reurl = '';
			//修改团人数
			if($postdata['share_tuan'] == 1)
			{
				$glzituan = D("glzituan");
				$zituan = $glzituan->where("`zituanID` = '$postdata[zituanID]'")->find();
				if(!$zituan)
					doalert('子团不存在错误',$reurl);
				if($qianzheng['share_tuan'] == 1)
				{
					if($postdata['share_tuan'] == 0)
					{
						$zituan['renshu'] += intval($postdata['renshu']);
					}				
				}
				else
				{
					if($postdata['share_tuan'] == 1)
					{
						$zituan['renshu'] -= intval($postdata['renshu']);
					}
					
				}
				$glzituan->save($zituan);
			}
			
		}
		else
		{
			
			$postdata['time'] = time();
			$postdata['username'] = $this->roleuser['user_name'];
			$glqianzheng->add($postdata);
			
			//修改团人数
			if($postdata['share_tuan'] == 1)
			{
				$glzituan = D("glzituan");
				$zituan = $glzituan->where("`zituanID` = '$postdata[zituanID]'")->find();
				if(!$zituan)
					doalert('子团不存在错误',$reurl);
				$zituan['renshu'] -= intval($postdata['renshu']);
				$glzituan->save($zituan);
			}
			
			$reurl =SITE_ADMIN.'Qianzheng/qianzhenginfo/zituanID/'.$postdata['zituanID'].'/kind/'.$postdata['kind'];
		}
		
		doalert('操作成功',$reurl);
		
	}

    public function ajaxadditem() {
		
		foreach($_POST as $key => $value)
		{
			$postdata[$key] = $value;
		}
		if(!$postdata['qianzhengID']){
		echo "false";
		exit;
		}
		$glqianzhengitem = D("glqianzhengitem");
		if($postdata['qzitemID'])
		{
			$item = $glqianzhengitem->where("`qzitemID` = '$postdata[qzitemID]'")->find();
			$glqianzheng = D("glqianzheng");
			$qianzheng = $glqianzheng->where("`qianzhengID` = '$item[qianzhengID]'")->find();
			if(!checkByAdminlevel('财务操作员,财务总监,网管',$this))
			{
/*				if($qianzheng['manager']){
					echo "false";
					exit;
				}*/
				if($qianzheng['status'] == '总经理通过' || $qianzheng['status'] == '财务总监通过' || $qianzheng['status'] == '财务通过' || $qianzheng['status'] == '经理通过' || $item['status'] == '总经理通过' || $item['status'] == '财务总监通过' || $item['status'] == '财务通过' || $item['status'] == '经理通过'){
					echo "false";
					exit;
				}
			}
			dump($postdata);
			$glqianzhengitem->save($postdata);
		}
		else
		{
			if(!checkByAdminlevel('财务操作员,财务总监,网管',$this))
			{
/*				if($qianzheng['manager']){
					echo "false";
					exit;
				}*/
				if($qianzheng['status'] == '总经理通过' || $qianzheng['status'] == '财务总监通过' || $qianzheng['status'] == '财务通过' || $qianzheng['status'] == '经理通过'){
					echo "false";
					exit;
				}
			}
			else
			{
				$postdata['status'] = '经理通过';		
				$postdata['manager'] = $this->roleuser['user_name'];		
			}
			
			$postdata['time'] = time();

			$newid = $glqianzhengitem->add($postdata);
			
		}
		echo $newid;
		
	}
	
	
    public function ajaxdeleteitem() {
		$qzitemID = $_POST['qzitemID'];
		$glqianzhengitem = D("glqianzhengitem");
		$item = $glqianzhengitem->where("`qzitemID` = '$qzitemID'")->find();
		$glqianzheng = D("glqianzheng");
		$qianzheng = $glqianzheng->where("`qianzhengID` = '$item[qianzhengID]'")->find();
			if(!checkByAdminlevel('财务操作员,财务总监,网管',$this))
			{
/*				if($qianzheng['manager']){
					echo "false";
					exit;
				}*/
				if($qianzheng['status'] == '总经理通过' || $qianzheng['status'] == '财务总监通过' || $qianzheng['status'] == '财务通过' || $qianzheng['status'] == '经理通过'|| $item['status'] == '总经理通过' || $item['status'] == '财务总监通过' || $item['status'] == '财务通过' || $item['status'] == '经理通过'){
					echo "false";
					exit;
				}
			}
		$glqianzhengitem = D("glqianzhengitem");
		$glqianzhengitem->where("`qzitemID` = '$qzitemID'")->delete();
		echo 'ture';
	}
	
	
    public function ajaxcount() {
		$qianzhengID = $_POST['qianzhengID'];
		$glqianzhengitem = D("glqianzhengitem");
		$itemAll = $glqianzhengitem->where("`qianzhengID` = '$qianzhengID' and `type` = '应收费用'")->findAll();
		foreach($itemAll as $item){
				$total_1 += $item['value'];
		}
		
		$itemAll2 = $glqianzhengitem->where("`qianzhengID` = '$qianzhengID' and `type` = '费用明细'")->findAll();
		foreach($itemAll2 as $item){
				$total_2 += $item['value'];
		}
		
		$lirun = $total_1 - $total_2;
		
		echo '{ "total_1": "'.$total_1.'","total_2": "'.$total_2.'","lirun": "'.$lirun.'"}';
		
	}
	
	
	
    public function dowhat() {
		
		$qianzhengID = $_GET['qianzhengID'] ;
		$glqianzheng = D("glqianzheng");
		$qianzheng = $glqianzheng->where("`qianzhengID` = '$qianzhengID'")->find();
		if($_GET['dotype'] == 'lock'){
			if($qianzheng)
			{
					$qianzheng['islock'] = '已锁定';
					$glqianzheng->where("`qianzhengID` = '$qianzhengID'")->save($qianzheng);
					doalert('锁定成功!','');
			}
		}
		
		if($_GET['dotype'] == 'unlock'){
			if($qianzheng)
			{
					$qianzheng['islock'] = '未锁定';
					$glqianzheng->where("`qianzhengID` = '$qianzhengID'")->save($qianzheng);
					doalert('解锁成功!','');
			}
		}
		
		if(!$qianzheng)
			doalert('发生错误!','');
		if($qianzheng['status'] == '财务通过' || $qianzheng['status'] == '财务总监通过' || $qianzheng['status'] == '总经理通过')
			doalert('已被审核通过，不能修改或删除','');
		if($qianzheng['ckeck_user'] || $qianzheng['caiwu_manager'] || $qianzheng['bigmanager'])
			doalert('已被审核通过，不能修改或删除','');
			
		if($_GET['dotype'] == 'delete'){
			if($qianzheng)
			{
					$glqianzheng->where("`qianzhengID` = '$qianzhengID'")->delete();
					doalert('成功删除!','');
			}
		}
		
		
	}
	
	
	
	
	
	function baozhangitemlist()
	{
		
		$zituanID = $_GET['zituanID'];
		
		$glzituan = D("glzituan");
		$zituan = $glzituan->where("`zituanID` = '$zituanID'")->find();
		
		if($zituan)
		{
		$this->assign('zituan',$zituan);
		$this->assign('zituanID',$_GET['zituanID']);
		}
		else
		doalert("错误",'/');
		
		$gl_baozhang = D("gl_baozhang");
		$baozhang = $gl_baozhang->where("`zituanID` = '$zituanID'")->find();

		$gl_baozhangitem = D("gl_baozhangitem");
		
		if($_GET['showtype'] == '收入')
		{
			$this->assign('location','收入');
			$this->assign('navtile','其他应收款列表');
			$itemAll = $gl_baozhangitem->order("time desc")->where("`type` = '结算项目' and `baozhangID` = '$baozhang[baozhangID]'")->findall();
		}
		if($_GET['showtype'] == '支出'){
			$this->assign('location','支出');
			$this->assign('navtile','请款单	');
			$itemAll = $gl_baozhangitem->order("time desc")->where("`type` = '支出项目' and `baozhangID` = '$baozhang[baozhangID]'")->findall();
		}
		$this->assign('showtype',$_GET['showtype']);
		$i = 0;
		foreach($itemAll as $item)
		{
			if(checkByAdminlevel('财务操作员',$this))
			{
				if(!checkByAdminlevel('网管',$this))
				{
					if($item['manager'] || $item['check_user'])
					{
						$listitem[$i] = $item;
						$i++;
					}
				}
				else{
						$listitem[$i] = $item;
						$i++;
				}
			}
			else{
					$listitem[$i] = $item;
					$i++;
			}
			
			
		}
	$this->assign('itemAll',$listitem);
	
		
        $this->display();
	}
	
	
	
	function addbaozhangitem()
	{
		
		$glzituan = D("glzituan");
		$gl_baozhang = D("gl_baozhang");
		if($_GET['baozhangitemID'])
		{
			$baozhangitemID =$_GET['baozhangitemID'];
			$gl_baozhangitem = D("gl_baozhangitem");
			$item = $gl_baozhangitem->where("`baozhangitemID` = '$baozhangitemID'")->find();
			$this->assign('item',$item);
			$baozhangID = $item['baozhangID'];
			$baozhang = $gl_baozhang->where("`baozhangID` = '$baozhangID'")->find();
			$zituanID = $baozhang['zituanID'];
			if($item['type'] =='结算项目')
			$showtype = '收入';
			if($item['type'] =='支出项目')
			$showtype = '支出';
		}
		else
		{
			$this->assign('showtype',$_GET['showtype']);
			$zituanID = $_GET['zituanID'];
			$baozhang = $gl_baozhang->where("`zituanID` = '$zituanID'")->find();
		}
		
			
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
			
		$zituan = $glzituan->where("`zituanID` = '$zituanID'")->find();
		if($zituan)
		$this->assign('zituan',$zituan);
		else
		doalert("错误",'/');
		
		$baozhang = $gl_baozhang->where("`zituanID` = '$zituan[zituanID]'")->find();
		if(!$baozhang)
		{
			$gl_baozhang = D('gl_baozhang');
			$t['zituanID'] = $zituan['zituanID'];
			$t['time'] = time();
			$t['caozuoren'] = $zituan['user_name'];
			$baozhangID = $gl_baozhang->add($t);
			$baozhang['baozhangID'] = $baozhangID;
		}
		
		$this->assign('baozhang',$baozhang);
		$this->assign('zituan',$zituan);
		
		
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
				
		$gl_baozhang = D("gl_baozhang");
		$baozhang = $gl_baozhang->where("`baozhangID` = '$postdata[baozhangID]'")->find();
		
		if(!checkByAdminlevel('网管,财务操作员,财务总监,总经理',$this))
		{
			if($baozhang['status'] == '财务通过')	
				doalert("报账单已被审核通过，不能删除和修改",'');
				
			if($_GET['dotype'] == '等待审核')
			$postdata['check_status'] = '等待审核';
			else
			$postdata['check_status'] = '准备';
			
			$postdata['manager'] = '';
			$postdata['zong_manager'] = '';
			$postdata['check_user'] = '';
		}
		
		$gl_baozhangitem = D("gl_baozhangitem");
		if($postdata['baozhangitemID'])
		{
			$item = $gl_baozhangitem->where("`baozhangitemID` = '$postdata[baozhangitemID]'")->find();
			if(!checkByAdminlevel('网管,财务操作员,财务总监,总经理',$this))
			{
				if($item['check_status'] == '审核通过')
					doalert("操作失败，该项目已经被通过",'');
//				if($item['departmentID'])
//					doalert("此项目为订单，不允许修改及删除",SITE_ADMIN.'Qianzheng/baozhangitemlist/showtype/'.$showtype.'/zituanID/'.$postdata['zituanID']);
			}
			
			if(!checkByAdminlevel('网管,财务操作员,财务总监,总经理,计调经理',$this))
			{
				if($item['check_status'] == '经理确认')
					doalert("操作失败，该项目已经被经理确认",'');
			}
			
			if($item['type'] == '结算项目')
				$showtype = '收入';
			if($item['type'] == '支出项目')
				$showtype = '支出';
			$gl_baozhangitem->save($postdata);
			
		}
		else
		{
			
			if(checkByAdminlevel('财务操作员',$this))
			{
				$postdata['check_status'] = '经理确认';
				$postdata['manager'] = $this->roleuser['user_name'];
			}
			$gl_baozhangitem->add($postdata);
		
		}
		doalert("操作成功",SITE_ADMIN.'Qianzheng/baozhangitemlist/showtype/'.$showtype.'/zituanID/'.$postdata['zituanID']);
	
	}
	
	
	
	function deleteitem()
	{
		$gl_baozhangitem = D("gl_baozhangitem");
		$baozhangitemID = $_GET['baozhangitemID'];
		$item = $gl_baozhangitem->where("`baozhangitemID` = '$baozhangitemID'")->find();
			
		if(!$item)
			doalert("错误",'/');
			
		if($item['type'] == '结算项目')
			$showtype = '收入';
		if($item['type'] == '支出项目')
			$showtype = '支出';
		
		$gl_baozhang = D("gl_baozhang");
		$baozhang = $gl_baozhang->where("`baozhangID` = '$item[baozhangID]'")->find();
		
		//edit by gaopeng 2012 2 24
		if($qianzheng['status'] == '财务通过' || $qianzheng['status'] == '财务总监通过' || $qianzheng['status'] == '总经理通过')
			doalert('已被审核通过，不能修改或删除','');
		if($qianzheng['ckeck_user'] || $qianzheng['caiwu_manager'] || $qianzheng['bigmanager'])
			doalert('已被审核通过，不能修改或删除','');
		if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
		{
			if($baozhang['status'] == '财务通过')	
				doalert("报账单已被审核通过，不能删除和修改",'');
			if($item['check_status'] == '审核通过')
				doalert("操作失败，该项目已经被通过",'/');
//			if($item['check_status'] != '准备' )
//				doalert("操作失败，没有权限",'/');
		}
			
//		if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
//		{
//			if($item['departmentID'])
//					doalert("此项目为订单，不允许修改及删除",SITE_ADMIN.'Qianzheng/baozhangitemlist/showtype/'.$showtype.'/zituanID/'.$baozhang['zituanID']);
//		}
//		
//		if(!checkByAdminlevel('网管,计调经理,财务操作员,总经理',$this))
//		{
//			if($baozhang['caozuoren'] != $this->roleuser['user_name'])
//			{
//				doalert("操作失败，没有权限",'/');
//			}
//		}
			
		//end	
			
		$gl_baozhangitem->where("`baozhangitemID` = '$baozhangitemID'")->delete();
			
		doalert("操作成功",'');
		
	}
	
	function itemshenhe()
	{
		$gl_baozhangitem = D("gl_baozhangitem");
		$baozhangitemID = $_GET['baozhangitemID'];
		$item = $gl_baozhangitem->where("`baozhangitemID` = '$baozhangitemID'")->find();
		if(!$item)
		doalert("错误",'');
		
		$gl_baozhang = D("gl_baozhang");
		$baozhang = $gl_baozhang->where("`baozhangID` = '$item[baozhangID]'")->find();	
		
//		if($baozhang['status'] == '财务通过')	
//			doalert("报账单...已被审核通过，不能删除和修改",'');
		
//		if($item['check_status'] == '审核通过')
//			doalert("操作失败，该项目已经被通过");
		
		if($_GET['roletype'] == '经理')
		{
			//edit by gaopeng 2012 3 6
			if($item['check_user'])
				doalert("无法操作。财务已经审核过",'');
			//end
			
			if(!checkByAdminlevel('网管,计调经理,财务操作员,总经理',$this))
				doalert("你没有操作权限",'');
/*			$item['manager'] = $this->roleuser['user_name'];	
			$item['check_status'] = '经理确认';*/
			
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
			
			$userlist = '计调操作员,网管';
		}
		if($_GET['roletype'] == '财务')
		{
			//edit by gaopeng 2012 3 6
			if($item['zong_manager'])
				doalert("无法操作。总经理已经审核过",'');
			//end
			
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
			$userlist = '计调经理,计调操作员,网管';
		}
		if($_GET['roletype'] == '总经理')
		{
			if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
				doalert("你没有操作权限",'');
			
			
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
				
			$userlist = '财务操作员,计调经理,计调操作员,网管';
		}
		
		
		if($_GET['dotype'] == '等待审核')
		{
			$item['check_status'] = '等待审核';		
		}
		elseif($_GET['dotype'] == '审核通过')
		{
		
			if(!checkByAdminlevel('网管,财务操作员,计调经理,总经理',$this))
				doalert("你没有操作权限",'');
				
			$megurl = SITE_ADMIN."Qianzheng/addbaozhangitem/baozhangitemID/".$baozhangitemID;
			A("Message")->savemessage($item['baozhangID'],'报账单','审核记录',$_GET['roletype'].'已对应收项审核通过',$userlist,$megurl);
			A("Message")->savemessage($baozhangitemID,'报账项','操作记录',$_GET['roletype'].'已对报账项审核通过');
		}
		elseif($_GET['dotype'] == '审核不通过')	
		{
			A("Message")->savemessage($baozhangitemID,'报账项','操作记录',$_GET['roletype'].'已对报账项审核不通过');
		}
		
		$gl_baozhangitem->save($item);
		
		
		if($item['type'] == '结算项目')
			$showtype = '收入';
		if($item['type'] == '支出项目')
			$showtype = '支出';
		
		doalert("操作成功",SITE_ADMIN.'Qianzheng/baozhangitemlist/showtype/'.$showtype.'/zituanID/'.$baozhang['zituanID']);
		
	}
	
	
	
	function qianzhengshenhe()
	{
		
		
		$glqianzheng = D("glqianzheng");
		$qianzhengID = $_GET['qianzhengID'];
		$qianzheng = $glqianzheng->where("`qianzhengID` = '$qianzhengID'")->find();
		
		if(!$qianzheng)
		doalert("错误",'');
		if(!checkByAdminlevel('网管,财务操作员,财务总监,总经理',$this))
		if(strstr($qianzheng['status'],'通过'))	
			doalert("签证报账单已经被审核通过，不能删除和修改",'');

		if($_GET['dotype'] == '审核通过')
		{
			if($_GET['roletype'] == '总经理')
			{
				if($qianzheng['status'] != '财务总监通过' && $qianzheng['status'] != '总经理不通过')
					doalert("失败,财务总监通过后总经理才可以确认",'');
				if(!checkByAdminlevel('网管,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzheng['status'] = '总经理通过';		
				$qianzheng['bigmanager'] = $this->roleuser['user_name'];		
			}
			
			
			if($_GET['roletype'] == '财务总监')
			{
				if($qianzheng['status'] != '财务通过' && $qianzheng['status'] != '财务总监不通过')
					doalert("失败,财务通过后财务总监才可以确认",'');
				if(!checkByAdminlevel('网管,财务总监,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzheng['status'] = '财务总监通过';		
				$qianzheng['caiwu_manager'] = $this->roleuser['user_name'];		
			}
			
			if($_GET['roletype'] == '财务')
			{
				if($qianzheng['status'] != '经理通过' && $qianzheng['status'] != '财务不通过')
					doalert("失败,经理通过后财务才可以确认",'');
				if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzheng['status'] = '财务通过';		
				$qianzheng['check_user'] = $this->roleuser['user_name'];		
				$qianzheng['check_time'] = time();
			}
			
			if($_GET['roletype'] == '经理')
			{
				if(!checkByAdminlevel('网管,计调经理,地接经理,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzheng['status'] = '经理通过';		
				$qianzheng['manager'] = $this->roleuser['user_name'];	
			}
			
			$megurl = SITE_ADMIN."Qianzheng/addbaozhangitem/baozhangitemID/".$baozhangitemID;
			A("Message")->savemessage($item['baozhangID'],'报账单','审核记录',$_GET['roletype'].'对签证报账单审核通过','计调经理,计调操作员',$megurl);
		}
		if($_GET['dotype'] == '审核不通过')
		{
			
			
			if($_GET['roletype'] == '总经理')
			{
				if(!checkByAdminlevel('网管,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzheng['status'] = '总经理不通过';
				$qianzheng['bigmanager'] = '';		
				
			}
			
			
			if($_GET['roletype'] == '财务总监')
			{
				if($qianzheng['status'] == '总经理通过')
					doalert("失败,总经理已经通过！",'');
				if(!checkByAdminlevel('网管,财务总监,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzheng['status'] = '财务总监不通过';		
				$qianzheng['caiwu_manager'] = '';	
			}
			
			
			if($_GET['roletype'] == '财务')
			{
				if($qianzheng['status'] == '总经理通过' ||$qianzheng['status'] == '财务总监通过')
					doalert("失败,总经理或者是财务总监已经通过！",'');
				if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzheng['status'] = '财务不通过';	
				$qianzheng['check_user'] = '';			
				$qianzheng['check_time'] = time();
			}
			if($_GET['roletype'] == '经理')
			{
				if($qianzheng['status'] == '总经理通过' ||$qianzheng['status'] == '财务总监通过' ||$qianzheng['status'] == '财务通过')
					doalert("失败,总经理或者是财务部门已经通过！",'');	
				if(!checkByAdminlevel('网管,计调经理,地接经理,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzheng['status'] = '经理不通过';		
				$qianzheng['manager'] = '';		
			}
			$megurl = SITE_ADMIN."Qianzheng/addbaozhangitem/baozhangitemID/".$baozhangitemID;
			A("Message")->savemessage($item['baozhangID'],'报账单','审核记录',$_GET['roletype'].'对签证报账单审核不通过','计调操作员',$megurl);
		}
		
		$glqianzheng->save($qianzheng);
		doalert("操作成功",SITE_ADMIN.'Qianzheng/qianzhenginfo/kind/'.$qianzheng['kind']);
	}
	
	
	function qianzhengitemshenhe()
	{
		
		
		$glqianzhengitem = D("Glqianzhengitem");
		$qzitemID = $_GET['qzitemID'];
		$qianzhengitem = $glqianzhengitem->where("`qzitemID` = '$qzitemID'")->find();
		
		if(!$qianzhengitem)
		doalert("错误",'');
		if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
		if(strstr($qianzhengitem['status'],'通过'))	
			doalert("签证报账单已经被审核通过，不能删除和修改",'');
		
		if($_GET['dotype'] == '审核通过')
		{
			if($_GET['roletype'] == '总经理')
			{
				if($qianzhengitem['status'] != '财务总监通过' && $qianzhengitem['status'] != '总经理不通过')
					doalert("失败,财务总监通过后总经理才可以确认",'');
				if(!checkByAdminlevel('网管,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzhengitem['status'] = '总经理通过';		
				$qianzhengitem['bigmanager'] = $this->roleuser['user_name'];		
			}
			
			
			if($_GET['roletype'] == '财务总监')
			{
				if($qianzhengitem['status'] != '财务通过' && $qianzhengitem['status'] != '财务总监不通过')
					doalert("失败,财务通过后财务总监才可以确认",'');
				if(!checkByAdminlevel('网管,财务总监,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzhengitem['status'] = '财务总监通过';		
				$qianzhengitem['caiwu_manager'] = $this->roleuser['user_name'];		
			}
			
			
			
			if($_GET['roletype'] == '财务')
			{
				if($qianzhengitem['status'] != '经理通过' && $qianzhengitem['status'] != '财务不通过')
					doalert("失败,经理通过后财务才可以确认",'');
				if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzhengitem['status'] = '财务通过';		
				$qianzhengitem['caiwu'] = $this->roleuser['user_name'];		
			}
			
			if($_GET['roletype'] == '经理')
			{
				if(!checkByAdminlevel('网管,计调经理,地接经理,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzhengitem['status'] = '经理通过';		
				$qianzhengitem['manager'] = $this->roleuser['user_name'];	
			}
			
		}
		if($_GET['dotype'] == '审核不通过')
		{
			
			
			if($_GET['roletype'] == '总经理')
			{
				if(!checkByAdminlevel('网管,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzhengitem['status'] = '总经理不通过';
				$qianzhengitem['bigmanager'] = '';	
			}
			
			
			if($_GET['roletype'] == '财务总监')
			{
				if($qianzhengitem['status'] == '总经理通过')
					doalert("失败,总经理已经通过！",'');
				if(!checkByAdminlevel('网管,财务总监,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzhengitem['status'] = '财务总监不通过';		
				$qianzhengitem['caiwu_manager'] = '';
			}
			
			
			if($_GET['roletype'] == '财务')
			{
				if($qianzhengitem['status'] == '总经理通过' ||$qianzhengitem['status'] == '财务总监通过')
					doalert("失败,总经理或者是财务总监已经通过！",'');
				if(!checkByAdminlevel('网管,财务操作员,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzhengitem['status'] = '财务不通过';	
				$qianzhengitem['caiwu'] = '';	
			}
			if($_GET['roletype'] == '经理')
			{
				if($qianzhengitem['status'] == '总经理通过' ||$qianzhengitem['status'] == '财务总监通过' ||$qianzhengitem['status'] == '财务通过')
					doalert("失败,总经理或者是财务部门已经通过！",'');	
				if(!checkByAdminlevel('网管,计调经理,地接经理,总经理',$this))
					doalert("你没有操作权限",'');
				$qianzhengitem['status'] = '经理不通过';		
				$qianzhengitem['manager'] = '';		
			}
/*			$megurl = SITE_ADMIN."Qianzheng/addbaozhangitem/baozhangitemID/".$baozhangitemID;
			A("Message")->savemessage($item['baozhangID'],'报账单','审核记录',$_GET['roletype'].'对签证报账单审核不通过','计调操作员',$megurl);*/
		}
		
		$glqianzhengitem->save($qianzhengitem);
		doalert("操作成功",SITE_ADMIN.'Qianzheng/addnew/qianzhengID/'.$qianzhengitem['qianzhengID']);
	}
	
	
}
?>