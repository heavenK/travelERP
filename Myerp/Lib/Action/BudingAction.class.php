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
		exit;
		C('TOKEN_ON',false);
		echo "报账项字段填充，报账标题，子团日期，子团团号，子团标题<br>";
		$ViewBaozhang = D("ViewBaozhang");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$ViewZituan = D("ViewZituan");
		$ViewDJtuan = D("ViewDJtuan");
		$System = D("System");
		$Chanpin = D("Chanpin");
		if(!$_REQUEST['page']){
				dump('无page参数');
		exit;
		}
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num = ($_REQUEST['page']-1)*800;
		$all = $ViewTaskShenhe->where("`datatype` = '报账单' or `datatype` = '报账项'")->limit("$num,800")->findall();
		//$all = $ViewTaskShenhe->where("`datatype` = '报账单' or `datatype` = '报账项'")->limit("50")->order("systemID desc")->findall();
		
		if(count($all)==0){
			exit;
		}
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
	
	
	//线路销售价格补订
    public function xianluxiaoshoujiage() {
		exit;
		C('TOKEN_ON',false);
		echo "线路销售价格补订";
		$ViewXianlu = D("ViewXianlu");
		$ViewShoujia = D("ViewShoujia");
		$Chanpin = D("Chanpin");
		$glxianlu = M("glxianlu");
		$glxianlujiage = M("glxianlujiage");
		$glshoujia = M("glshoujia");
		$zhenxiaoshouall = $ViewShoujia->findall();
		foreach($zhenxiaoshouall as $v){
			$xianlu = $ViewXianlu->where("`chanpinID` = $v[parentID]")->find();
			$where['mingcheng'] = $xianlu['title'];
			//$where['chutuanriqi'] = $xianlu['chutuanriqi'];
			$where['time'] = $xianlu['time'];
			$xianlu_old = $glxianlu->where($where)->find();
			if($xianlu_old){
				//价格表
				$jiage = $glxianlujiage->where("`xianluID` = '$xianlu_old[xianluID]'")->find();
				if($jiage){
					//售价表
					$shoujiaall = $glshoujia->where("`jiageID` = '$jiage[jiageID]'")->findall();
					if(count($shoujiaall) > 0){
						foreach($shoujiaall as $vol){
							$price_chengren = $vol['chengrenshoujia'];
							if($price_chengren < $vol['chengrenshoujia'])
								$price_chengren = $vol['chengrenshoujia'];
							$price_ertong = $vol['ertongshoujia'];
							if($price_ertong < $vol['ertongshoujia'])
								$price_ertong = $vol['ertongshoujia'];
							$cut = $vol['cut'];
							if($cut > $vol['cut'])
								$cut = $vol['cut'];
						}
						$data = $v;
						$data['shoujia'] = $data;
						$data['shoujia']['adultprice'] = $price_chengren;
						$data['shoujia']['childprice'] = $price_ertong;
						$data['shoujia']['cut'] = $cut;
						$data['shoujia']['chengben'] = $price_chengren;
						$Chanpin->relation("shoujia")->myRcreate($data);
						$xianlu['xianlu']['shoujia'] = $price_chengren;
						$Chanpin->relation("xianlu")->myRcreate($xianlu);
					}
				}
			}
		}

		echo "结束";
    }
	
	
	
	//报账单状态根据流程重置
    public function baozhangzhuangtai() {
		C('TOKEN_ON',false);
		echo "报账单状态根据流程重置";
		$Chanpin = D("Chanpin");
		$ViewBaozhang = D("ViewBaozhang");
		$ViewTaskShenhe = D("ViewTaskShenhe");
//		$baozhangall = $ViewBaozhang->order("chanpinID desc")->limit("1000")->findall();
		$baozhangall = $ViewBaozhang->findall();
		foreach($baozhangall as $v){
			
			$need = $ViewTaskShenhe->where("`dataID` = '$v[chanpinID]' and `status` = '批准' AND (`status_system` = '1')")->order("processID desc")->find();
			if(!$need)	{
				$need = $ViewTaskShenhe->where("`dataID` = '$v[chanpinID]' and `status` = '检出' AND (`status_system` = '1')")->order("processID desc")->find();
				if(!$need){
					$need = $ViewTaskShenhe->where("`dataID` = '$v[chanpinID]' and `status` = '申请' AND (`status_system` = '1')")->order("processID desc")->find();
				}
			}
			if($need){
				$data = $v; 
				$data['shenhe_remark'] = $need['remark'];
				$data['status_shenhe'] = $need['status'];
				$Chanpin->mycreate($data);
			}
		}
		
		echo "结束";
    }
	
	
	
	
	
	//重置地接行程信息
    public function dijiexingcheng() {
		exit;
		C('TOKEN_ON',false);
		echo "重置地接行程信息";
		$ViewDJtuan = D("ViewDJtuan");
		$Chanpin = D("Chanpin");
		$dj_itinerary = M("dj_itinerary");
		$dj_rcitem = M("dj_rcitem");
		$dj_tuan = M("dj_tuan");
		$tuanall = $dj_tuan->order("time desc")->findall();
		foreach($tuanall as $v){
			$where['title'] = $v['tuantitle'];
			$where['time'] = $v['time'];
			$newdjtuan = $ViewDJtuan->where($where)->find();
			$iti = $dj_itinerary->where("`djtuanID` = $v[djtuanID]")->find();
			$rcall = $dj_rcitem->where("`itineraryID` = $iti[itineraryID]")->findall();
			if(!$newdjtuan)
			continue;
			//行程项目
			$datatext_xingcheng = simple_unserialize($newdjtuan['datatext_xingcheng']);
			//$xingcheng_array = $datatext_xingcheng['xingcheng_array'];
			$i = 0;
			foreach($rcall as $vol){
				$xingcheng_array[$i] = $vol['breakfastprice'].'#_#'.$vol['breakfastplace'].'#_#'.$vol['breakfasttelnum'].'@_@';
				$xingcheng_array[$i] .= $vol['lunchprice'].'#_#'.$vol['lunchplace'].'#_#'.$vol['lunchtelnum'].'@_@';
				$xingcheng_array[$i] .= $vol['dinnerprice'].'#_#'.$vol['dinnerpalce'].'#_#'.$vol['dinnertelnum'].'@_@';
				$xingcheng_array[$i] .= $vol['content'];
				$i++;
			}
			//行程
			$datatext_xingcheng['carnumber'] = $iti['carnumber'];
			$datatext_xingcheng['carpilot'] = $iti['carpilot'];
			$datatext_xingcheng['cartelnum'] = $iti['cartelnum'];
			$datatext_xingcheng['xingcheng_array'] =  $xingcheng_array;
			$newdjtuan['datatext_xingcheng'] =  serialize($datatext_xingcheng);
			$newdjtuan['DJtuan'] =  $newdjtuan;
			$re = $Chanpin->relation("DJtuan")->myRcreate($newdjtuan);
			if($re === false){
				dump($re);
				exit;
			}
				
		}
		echo "结束";
	}
	
	
	
	
	//重置电话号码
    public function yonghutelnum() {
		exit;
		C('TOKEN_ON',false);
		echo "重置电话号码";
		$User = D("User");
		$System = D("System");
		$glkehu = M("glkehu");
		$userall = $User->findall();
		foreach($userall as $v){
			$user = $glkehu->where("`user_name` = '$v[user_name]'")->find();
			if(!$user)
			continue;
			$v['telnum'] = $user['mobiletel'];
			$v['user'] = $v;
			$System->relation("user")->myRcreate($v);
		}
		echo "结束";
	}
	
	
	
	
	
	
	
	//地接团om补充,及报账单om
    public function dijietuanom() {
		exit;
		C('TOKEN_ON',false);
		echo "地接团om补充";
		$ViewDJtuan = D("ViewDJtuan");
		$ViewBaozhang = D("ViewBaozhang");
		$OMViewDJtuanModel = D("OMViewDJtuanModel");
		$djtuanall = $ViewDJtuan->findall();
		foreach($djtuanall as $v){
			$bumenlist = A("Method")->_checkbumenshuxing('地接','',$v['user_name']);
			if($bumenlist){
				$i = 0;
				$dataOMlist = '';
				foreach($bumenlist as $vol){
					$dataOMlist[$i]['DUR'] = $vol['bumenID'].',,';
					$i++;
				}
				foreach($dataOMlist as $w){
					$where['DUR'] = $w['DUR'];
					$where['dataID'] = $v['chanpinID'];
					$where['time'] = $v['time'];
					$om = $OMViewDJtuanModel->where($where)->find();
					if($om)
					continue;
					$do_dataOMlist[0] = $w;
					A("Method")->_createDataOM($where['dataID'],'地接','管理',$do_dataOMlist);
				}
			}
			//报账单
			$dataOMlist = A('Method')->_getDataOM($v['chanpinID'],'地接');
			$bzd = $ViewBaozhang->where("`parentID` = '$v[chanpinID]'")->find();
			if($bzd){
				A("Method")->_createDataOM($bzd['chanpinID'],'报账单','管理',$dataOMlist);
			}
		}
		echo "结束";
	}
	
	
	
	
	
	//报账项未审核解锁
    public function baozhangxiangmujiesuo() {
		exit;
		C('TOKEN_ON',false);
		echo "报账项未审核解锁";
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$Chanpin = D("Chanpin");
		$itemall = $ViewBaozhangitem->findall();
		dump(count($itemall));
		$aaa = 0;
		foreach($itemall as $v){
			echo $aaa++.'<br>';
			if($v['status_shenhe'] == '未审核'){
				$data['chanpinID'] = $v['chanpinID'];
				$data['islock'] = '未锁定';
				if(false === $Chanpin->save($data)){
			dump($Chanpin);
				}
			}
		}
		echo "结束";
	}
	
	
	
	//报账单经理签名报账项关联
    public function baozhangmanagercopy() {
		exit;
		C('TOKEN_ON',false);
		echo "报账单经理签名报账项关联";
		$ViewBaozhang = D("ViewBaozhang");
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$Chanpin = D("Chanpin");
		$bzdall = $ViewBaozhang->findall();
		foreach($bzdall as $v){
			if($v['manager_copy'] == ''){
				$itemall = $ViewBaozhangitem->where("`parentID` = $v[chanpinID]")->findall();
				foreach($itemall as $vol){
					$task = $ViewTaskShenhe->where("`dataID` = '$vol[chanpinID]' and `status` = '检出' and `status_system` = 1")->find();
					if($task){
						$data['chanpinID'] = $v['chanpinID'];
						$data['baozhang']['manager_copy'] = $task['user_name'];
						$Chanpin->relation("baozhang")->myRcreate($data);
						break;
					}
				}
			}
		}
		echo "结束";
	}
	
	
	
	//地接，截止团报账单填补
    public function djtuanbaozhangtianbu() {
		exit;
		C('TOKEN_ON',false);
		echo "地接，截止团报账单填补";
		$ViewDJtuan = D("ViewDJtuan");
		$Chanpin = D("Chanpin");
		$tuanall = $ViewDJtuan->findall();
		foreach($tuanall as $v){
			$bzd = $Chanpin->where("`parentID` = '$v[chanpinID]' and `marktype` = 'baozhang'")->find();
			if($bzd)
			continue;
			$data['parentID'] = $v['chanpinID'];
			$data['user_name'] = $v['user_name'];
			$data['departmentID'] = $v['departmentID'];
			$data['baozhang']['type'] = '团队报账单';
			$data['baozhang']['title'] = $v['title'].'/'.$v['jietuantime'].'团队报账单';
			$data['baozhang']['renshu'] = $v['renshu'];
			$Chanpin->relation("baozhang")->myRcreate($data);
			$baozhangID = $Chanpin->getRelationID();
			//生成OM
			$dataOMlist = A("Method")->_getDataOM($v['chanpinID'],'地接');
			A("Method")->_createDataOM($baozhangID,'报账单','管理',$dataOMlist);
		}
		echo "结束";
	}
	
	
	//单项服务报账单om补充
    public function djtuandanxiangfuomkaifang() {
		exit;
		C('TOKEN_ON',false);
		echo "单项服务报账单om补充";
		$ViewBaozhang = D("ViewBaozhang");
		$bzdall = $ViewBaozhang->where("`type` != '团队报账单'")->findall();
		foreach($bzdall as $v){
			$bumenlist = A("Method")->_checkbumenshuxing('地接','',$v['user_name']);
			if($bumenlist){
				$i = 0;
				$dataOMlist = '';
				foreach($bumenlist as $vol){
					$dataOMlist[$i]['DUR'] = $vol['bumenID'].',,';
					$i++;
				}
				foreach($dataOMlist as $w){
					$do_dataOMlist[0] = $w;
					A("Method")->_createDataOM($v['chanpinID'],'报账单','管理',$do_dataOMlist);
				}
			}
		}
		echo "结束";
	}
	
	
	
	
	
	
	
	
}
?>