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
		$all = $ViewTaskShenhe->where("`datatype` = '报账单' or `datatype` = '报账项'")->limit("$num,800")->order("systemID desc")->findall();
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
				$djtuan = $ViewDJtuan->where("`chanpinID` = '$cp[chanpinID]'")->find();
				$data['taskShenhe']['tuantitle_copy'] = $djtuan['title'];
				$data['taskShenhe']['tuanqi_copy'] = $djtuan['jietuantime'];
				$data['taskShenhe']['tuanhao_copy'] = $djtuan['tuanhao'];
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
	
	
	
	
	//产品报账状态描述重置
    public function chanpinbaozhangremark() {
		exit;
		C('TOKEN_ON',false);
		echo "产品报账状态描述重置";
		$Chanpin = D("Chanpin");
		$ViewBaozhang = D("ViewBaozhang");
		$bzdall = $ViewBaozhang->where("`type` = '团队报账单'")->findall();
		foreach($bzdall as $v){
			if($v['status_shenhe'] == '批准'){
				$data['chanpinID'] = $v['parentID'];
				$d = $Chanpin->where("`chanpinID` = '$data[chanpinID] '")->find();
				$data[$d['marktype']]['baozhang_remark'] = $v['shenhe_remark'];
				if(false === $Chanpin->relation($d['marktype'])->myRcreate($data)){
				dump($data);
				dump($Chanpin);
				}
			}
		}
		echo "结束";
	}
	
	
	
	//客户导出测试
    public function customertest() {
		exit;
		$DataCD = D("DataCD");	
		$cusall = $DataCD->Distinct(true)->field("telnum")->findall();
		$i = 0;
		foreach($cusall as $v){
			if(strlen($v['telnum']) == 11){
				$tellist[$i] = $v['telnum'];
				$i++;
			}
		}
		$this->assign("cusall",$tellist);
		//导出Word必备头
		header("Content-type:application/msword");
		header("Content-Disposition:attachment;filename=" . '客户电话名单'.".txt");
		header("Pragma:no-cache");        
		header("Expires:0");  
		$this->display('Index:customerlist');
	}
	
	
	
	//客户统计
    public function customercounter() {
		exit;
		$DataCD = D("DataCD");	
		$cusall = $DataCD->Distinct(true)->field("telnum")->findall();
		$i = 0;
		foreach($cusall as $v){
			if(strlen($v['telnum']) == 11){
				$tellist[$i]['telnum'] = $v['telnum'];
				$i++;
			}
		}
		$cusall = $tellist;
		$num['num_8000'] = 0;
		$num['num_15000_a'] = 0;
		$num['num_15000_b'] = 0;
		$num['num_30000'] = 0;
		$i = 0;
		foreach($cusall as $v){
			$telnum_one = $DataCD->where("`telnum` = '$v[telnum]'")->findall();
			$price = 0;
			$level = 0;
			foreach($telnum_one as $vol){
				$price += $vol['price'];
			}
			if($price > 8000){
				if($price > 15000){
					if($price > 30000){
						$num['num_30000'] += 1;
						$level = '30000';
					}
					else{
						$num['num_15000_b'] += 1;
						$level = '15000_b';
					}
				}
				else{
					$num['num_15000_a'] += 1;
					$level = '15000_a';
				}
			}
			else{
				$num['num_8000'] += 1;
				$level = '8000';
			}
			
			$cusall[$i]['vol'] = $vol;
			$cusall[$i]['level'] = $level;
			$cusall[$i]['price'] = $price;
			$i++;
			
		}
		
		$this->assign("cusall",$cusall);
		$this->assign("num",$num);
		
		//导出Word必备头
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=" . '客户统计名单' . ".xls");
		$this->display('Index:customerlist_1');
		
		
	}
	
	
	
	
	//订单统计
    public function dingdancounter() {
		exit;
		$ViewDingdan = D("ViewDingdan");
		$all = $ViewDingdan->where("`status_system` = 1")->findall();
		foreach($all as $v){
			if($v['jiage'] > 0){
				$num_renshu += $v['chengrenshu'] + $v['ertongshu'];
				$num_price += $v['jiage'];
			}
		}
		
		echo "总人数:".number_format($num_renshu).',总金额:'.number_format($num_price);
		
	}
	
	
	
	//订单统计
    public function baozhangshenhetime() {
		exit;
		C('TOKEN_ON',false);
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$ViewBaozhang = D("ViewBaozhang");
		$Chanpin = D("Chanpin");
		$baozhangall = $ViewBaozhang->where("`shenhe_remark` like '%财务%' and (`shenhe_time` = 0 or `shenhe_time` = ''  or `shenhe_time` is null) ")->findall();
		dump(count($baozhangall));
		$i = 0;
		foreach($baozhangall as $v){
			$ts = $ViewTaskShenhe->where("`dataID` = '$v[chanpinID]' and `remark` like '%财务%' and `status_system` = 1")->order("time desc")->findall();
			foreach($ts as $vol){
				if($vol['remark'] == '财务总监审核通过'){
					$v['shenhe_time'] = $vol['time'];
					break;
				}
				else
					$v['shenhe_time'] = $vol['time'];
			}
			$dat['chanpinID'] = $v['chanpinID'];
			$dat['shenhe_time'] = $v['shenhe_time'];
			$Chanpin->save($dat);
		}
		echo "结束";
	}
	
	
	//重置管理员用户OM
	public function resetUserOM40150(){
		exit;
		C('TOKEN_ON',false);
		$dataOMlist[0]['DUR'] = '40150,43980,';
		$ViewUser = D("ViewUser");
		$uall = $ViewUser->findall();
		foreach($uall as $v){
			A("Method")->_createDataOM($v['systemID'],'用户','管理',$dataOMlist,'DataOMSystem');
		}
		echo "结束";
	}
	
	
	//重置分类OM
	public function resetCategoryOM40150(){
		exit;
		C('TOKEN_ON',false);
		$dataOMlist = A("Method")->_setDataOMtoAAA();
		$ViewCategory = D("ViewCategory");
		$uall = $ViewCategory->findall();
		foreach($uall as $v){
			A("Method")->_createDataOM($v['systemID'],'分类','管理',$dataOMlist,'DataOMSystem');
		}
		echo "结束";
	}
	
	//重置分类OM
	public function fillAllCompanyID40150(){
		exit;
		C('TOKEN_ON',false);
		$System = D("System");
		$uall = $System->where("`marktype`='department' or `marktype`='user'")->findall();
		foreach($uall as $v){
			$v['companyID'] = '40150';
			$System->save($v);
		}
		echo "结束";
	}
	
	public function fillAllCompanyID40150chanpin(){
		exit;
//		C('TOKEN_ON',false);
//		$Chanpin = D("Chanpin");
//		$uall = $Chanpin->order('time asc')->limit("0,400")->findall();
//		foreach($uall as $v){
//			$v['companyID'] = '40150';
//			$Chanpin->save($v);
//		}
//		echo "结束";
		echo "开始";
		echo "<br>";
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		if(!$_REQUEST['page']){
				dump('无page参数');
		exit;
		}
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num = ($_REQUEST['page']-1)*9000;
		$uall = $Chanpin->order('time asc')->limit("$num,9000")->findall();
		if(count($uall)==0)
		exit;
		foreach($uall as $v){
			$v['companyID'] = '40150';
			$Chanpin->save($v);
		}
		$url = SITE_INDEX."Buding/fillAllCompanyID40150chanpin/page/".($_REQUEST['page']+1);
		$this->assign("url",$url);
		$this->display('Index:forme');
		echo "结束";
		
	}
	
	
	public function fillAllCompanyID40150message(){
		exit;
		C('TOKEN_ON',false);
		$Message = D("Message");
		$uall = $Message->findall();
		foreach($uall as $v){
			$v['companyID'] = '40150';
			$Message->save($v);
		}
		echo "结束";
	}
	
	public function xxxxxxxxx(){
		exit;
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		
		$uall = $Chanpin->where("`status_system` = 1")->findall();
		dump(count($uall));
		
//		foreach($uall as $v){
//			$v['companyID'] = '40150';
//			$Chanpin->save($v);
//		}
		echo "结束";
	}
	
	
	
	//重置报账利润类型expandtype为部门
	public function resetlirunexpandtype(){
		exit;
		C('TOKEN_ON',false);
		$ViewBaozhangitem = D("ViewBaozhangitem");
		$itemall = $ViewBaozhangitem->where("`type` = '利润' AND `expandID` is not null")->findall();
		$Chanpin = D("Chanpin");
		foreach($itemall as $v){
			$dat['chanpinID'] = $v['chanpinID'];
			$dat['baozhangitem']['expandtype'] = '部门';
			if(false === $Chanpin->relation("baozhangitem")->myRcreate($dat)){
				echo "发生错误";
				exit;
			}
		}
		echo "结束";
	}
	
	
	
	//重置销售类型chanpintype
	public function resetshoujiachanpintype(){
		exit;
		C('TOKEN_ON',false);
		$Shoujia = D("Shoujia");
		$shoujiaall = $Shoujia->findall();
		$Chanpin = D("Chanpin");
		foreach($shoujiaall as $v){
			$dat['chanpinID'] = $v['chanpinID'];
			$dat['shoujia']['chanpintype'] = '线路';
			if(false === $Chanpin->relation("shoujia")->myRcreate($dat)){
				echo "发生错误";
				exit;
			}
		}
		echo "结束";
	}
	
	
	//线路截止
    public function xianlujiezhi() {
		exit;
		C('TOKEN_ON',false);
		echo "开始";
		$ViewXianlu = D("ViewXianlu");
		$all = $ViewXianlu->where("`status` != '截止'")->findall();
		foreach($all as $v){
			A('Method')->_updatexianlu_status($v['chanpinID']);
		}
		echo "结束";
    }
	
	
	
	
	//审核任务根据产品重置
    public function taskshenhelistreset() {
		exit;
		if(!$_REQUEST['page']){
			dump('无page参数');
			exit;
		}
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		$System = D("System");
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num = ($_REQUEST['page']-1)*800;
		$all = $Chanpin->where("`marktype` = 'xianlu' or `marktype` = 'zituan' or `marktype` = 'DJtuan' or `marktype` = 'baozhang' or `marktype` = 'baozhangitem'")->limit("$num,800")->findall();
		if(count($all)==0){
			exit;
		}
		foreach($all as $v){
			if($v['status_system'] == -1){
			dump("正在执行".$_REQUEST['page'].'页'.$v['chanpinID'].'<br>');
				
				if($v['marktype'] == 'xianlu')
					$datatype = '线路';
				if($v['marktype'] == 'zituan')
					$datatype = '子团';
				if($v['marktype'] == 'DJtuan')
					$datatype = '地接';
				if($v['marktype'] == 'baozhang')
					$datatype = '报账单';
				if($v['marktype'] == 'baozhangitem')
					$datatype = '报账项';
				//相应审核任务
				A("Method")->_taskshenhe_delete($v['chanpinID'],$datatype);
			}
			
		}
		$url = SITE_INDEX."Buding/taskshenhelistreset/page/".($_REQUEST['page']+1);
		$this->assign("url",$url);
		$this->display('Index:forme');
		echo "结束";
    }
	
	//商户条目输入
    public function shanghutiaomu() {
		exit;
		Vendor ( 'Excel.PHPExcel' );
		$inputFileName = 'list.xls';
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$System = D("System");
		$ViewDataDictionary = D("ViewDataDictionary");
		if(!$_REQUEST['page']){
			dump('无page参数');
			exit;
		}
		C('TOKEN_ON',false);
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num_cur = ($_REQUEST['page']-1)*100+1;
		$num_limit = $num_cur + 100;
		for($num_cur;$num_cur<=$num_limit;$num_cur++){
			$val = $sheetData[$num_cur];
			if(!$val['A']){
				dump('循环'.$num_cur);
				echo "结束";
				exit;
			}
			if($num_cur == $num_limit){
				$url = SITE_INDEX."Buding/shanghutiaomu/page/".($_REQUEST['page']+1);
				$this->assign("url",$url);
				$this->display('Index:forme');
				exit;
			}
			$_REQUEST['title'] = $val['A'];
			$_REQUEST['companyID'] = 40150;
			$_REQUEST['type'] = '商户条目';
			$data = $_REQUEST;
			$data['datadictionary'] = $_REQUEST;
			$data['datadictionary']['datatext'] = serialize($_REQUEST);
			$roles = $ViewDataDictionary->where("`title` = '$_REQUEST[title]'")->find();
			if($roles && ($_REQUEST['companyID'] == $roles['companyID'])){
				dump('跳过'.$num_cur);
				continue;
			}
			if (false === $System->relation('datadictionary')->myRcreate($data)){
				dump('保存失败');
				dump($System);
			}
			else{
				dump('成功执行'.$num_cur);
			}
		}
		echo "结束";
	}
	
	
	
	
	
	//清除无效审核任务OM
    public function clearn_shenhetask_om() {
		$DataOM = D("DataOM");
		$ViewTaskShenhe = D("ViewTaskShenhe");
		if(!$_REQUEST['page']){
			dump('无page参数');
			exit;
		}
		C('TOKEN_ON',false);
		echo "执行page=".$_REQUEST['page'].'<br>';
		$num = ($_REQUEST['page']-1)*200;
		$taksall = $ViewTaskShenhe->where("`status` != '申请' AND `status` != '待检出'")->limit("$num,200")->findall();
		dump($taskall);
		if(count($taksall)==0){
			echo "结束";
			exit;
		}
		foreach($taksall as $v){
			$DataOM->where("`datatype` = '审核任务' AND `dataID` = '$v[systemID]'")->delete();
		}
		$url = SITE_INDEX."Buding/clearn_shenhetask_om/page/".($_REQUEST['page']+1);
		$this->assign("url",$url);
		$this->display('Index:forme');
		echo "结束";
	}
	
	
	
	
}
?>