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
	
	
	//报账项字段填充，报账标题，子团日期，子团团号，子团标题
    public function baozhangxiangtianchong() {
		C('TOKEN_ON',false);
		echo "报账项字段填充，报账标题，子团日期，子团团号，子团标题";
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$ViewBaozhang = D("ViewBaozhang");
		$ViewZituan = D("ViewZituan");
		$ViewDJtuan = D("ViewDJtuan");
		$Chanpin = D("Chanpin");
		$all = $ViewBaozhangitem->findall();
		foreach($all as $v){
			$data = $v;
			$data['baozhangitem'] = $v;
			//获得报账单
			$baozhang = $ViewBaozhang->where("`chanpinID` = $v[parentID]")->find();
			$data['baozhangitem']['baozhangtitle_copy'] = $baozhang['title'];
			//获得团
			$cp = $Chanpin->where("`chanpinID` = '$baozhang[parentID]'")->find();
			if($cp['marktype'] == 'zituan'){
				$zituan = $ViewZituan->where("`chanpinID` = '$cp[chanpinID]'")->find();
				$data['baozhangitem']['tuantitle_copy'] = $zituan['title_copy'];
				$data['baozhangitem']['tuanqi_copy'] = $zituan['chutuanriqi'];
				$data['baozhangitem']['tuanhao_copy'] = $zituan['tuanhao'];
					
			}
			if($cp['marktype'] == 'DJtuan'){
				$zituan = $ViewZituan->where("`chanpinID` = '$cp[chanpinID]'")->find();
				$data['baozhangitem']['tuantitle_copy'] = $zituan['title'];
				$data['baozhangitem']['tuanqi_copy'] = $zituan['jietuantime'];
				$data['baozhangitem']['tuanhao_copy'] = $zituan['tuanhao'];
			}
			$Chanpin->relation("baozhangitem")->myRcreate($data);
		}
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