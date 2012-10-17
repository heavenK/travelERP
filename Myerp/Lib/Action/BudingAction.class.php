<?php

class BudingAction extends Action{
	//报账单解锁
    public function baozhangdanjiesuo() {
		exit;
		echo "执行报账解锁";
		$Chanpin = D("Chanpin");
		$baozhangall = $Chanpin->where("`marktype` = 'baozhang'")->findall();
		foreach($baozhangall as $v){
			if($v['status_shenhe'] == '未审核'){
				$data['chanpinID'] = $v['chanpinID'];
				$data['islock'] = '未锁定';
				$Chanpin->save($data);
			}
		}
		echo "结束";
    }
	
	//订单om开放到用户本人
    public function dingdankaifang() {
		exit;
		echo "执行订单om开放到用户本人";
		$ViewUser = D("ViewUser");
		$DataOM = D("DataOM");
		$Chanpin = D("Chanpin");
		$all = $Chanpin->where("`marktype` = 'dingdan'")->findall();
		foreach($all as $v){
			$data['dataID'] = $v['chanpinID'];
			$data['datatype'] = '订单';
			$data['type'] = '管理';
			//
			$user = $ViewUser->where("`title` = '$v[user_name]'")->find();
			$data['DUR'] = ',,'.$user['systemID'];
			$ish = $DataOM->where($data)->find();
			if(!$ish)
			$DataOM->add($data);
		}
		echo "结束";
    }
	
	
	//线路开放销售补订
    public function xianluxiaoshoukaifang() {
		exit;
		C('TOKEN_ON',false);
		echo "执行线路开放销售om";
		$ViewXianlu = D("ViewXianlu");
		$ViewShoujia = D("ViewShoujia");
		$all = $ViewXianlu->where("`status` = '报名'")->findall();
		foreach($all as $v){
			$shoujia = $ViewShoujia->where("`parentID` = '$v[chanpinID]'")->find();
			$shoujia['shoujia'] = $shoujia;
			A('Method')->_shoujiaToDataOM($shoujia);
		}
		echo "结束";
    }
	
	
	//审核任务表字段填充，报账标题，子团日期，子团团号，子团标题
    public function shenherenwutianchong() {
		C('TOKEN_ON',false);
		echo "报账项字段填充，报账标题，子团日期，子团团号，子团标题<br>";
		$ViewBaozhang = D("ViewBaozhang");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$ViewZituan = D("ViewZituan");
		$ViewDJtuan = D("ViewDJtuan");
		$System = D("System");
		$Chanpin = D("Chanpin");
//		$all = $ViewTaskShenhe->where("`datatype` = '报账单' or `datatype` = '报账项'")->findall();
//		
//		echo count($all);
//		exit;
		if(!$_REQUEST['page']){
				dump('无page参数');
		exit;
		}
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num = ($_REQUEST['page']-1)*800;
		$all = $ViewTaskShenhe->where("`datatype` = '报账单' or `datatype` = '报账项'")->limit("$num,800")->findall();
		if(count($all)==0)
		exit;
		dump("共".count($ViewTaskShenhe->where("`datatype` = '报账单' or `datatype` = '报账项'")->findall()).'个'.'<br>');
		$jishu_xianlu = 0;
		foreach($all as $v){
			dump("正在执行".$num+(++$jishu_xianlu).'个'.$v['systemID'].'<br>');
			$data = $v;
			$data['taskShenhe'] = $v;
			if($v['datatype'] == '报账项'){
				$cp = $ViewBaozhangitem->where("`chanpinID` = '$v[dataID]'")->find();
				$data['taskShenhe']['datatext_copy'] = serialize($cp);
				$cp = $Chanpin->relation("baozhanglist")->where("`chanpinID` = '$v[dataID]'")->find();
				$data['taskShenhe']['baozhangtitle_copy'] = $cp['baozhanglist']['title'];
				$zituanID = $cp['baozhanglist']['parentID'];
			}
			if($v['datatype'] == '报账单'){
				$cp = $ViewBaozhang->where("`chanpinID` = '$v[dataID]'")->find();
				$data['taskShenhe']['datatext_copy'] = serialize($cp);
				$cp = $Chanpin->where("`chanpinID` = '$v[dataID]'")->find();
				$zituanID = $cp['parentID'];
			}
			//获得团
			$cp = $Chanpin->where("`chanpinID` = '$zituanID'")->find();
			if($cp['marktype'] == 'zituan'){
				$zituan = $ViewZituan->where("`chanpinID` = '$cp[chanpinID]'")->find();
				$data['taskShenhe']['tuantitle_copy'] = $zituan['title_copy'];
				$data['taskShenhe']['tuanqi_copy'] = $zituan['chutuanriqi'];
				$data['taskShenhe']['tuanhao_copy'] = $zituan['tuanhao'];
					
			}
			if($cp['marktype'] == 'DJtuan'){
				$zituan = $ViewZituan->where("`chanpinID` = '$cp[chanpinID]'")->find();
				$data['taskShenhe']['tuantitle_copy'] = $zituan['title'];
				$data['taskShenhe']['tuanqi_copy'] = $zituan['jietuantime'];
				$data['taskShenhe']['tuanhao_copy'] = $zituan['tuanhao'];
			}
			if(false === $System->relation("taskShenhe")->myRcreate($data))
			{
				dump($data);	
				dump($System);	
				exit;
			}
		}
		$url = SITE_INDEX."Buding/shenherenwutianchong/page/".($_REQUEST['page']+1);
		$this->assign("url",$url);
		$this->display('Index:forme');
		echo "结束";
    }
	
	
	//线路联合体开放给自己
    public function lianhetixianlukaifang() {
		exit;
		C('TOKEN_ON',false);
		echo "线路联合体开放给自己om";
		$ViewXianlu = D("ViewXianlu");
		$DataOM = D("DataOM");
		$Chanpin = D("Chanpin");
		$all = $ViewXianlu->findall();
		foreach($all as $v){
			$data['dataID'] = $v['chanpinID'];
			$data['datatype'] = '线路';
			$data['type'] = '管理';
			$data['DUR'] = $v['departmentID'].',,';
			$ish = $DataOM->where($data)->find();
			if(!$ish)
			$DataOM->add($data);
		}
		echo "结束";
    }
	
	
	
}
?>