<?php

class CaiwuAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'财务管理');
	}
	
	
	public function shenhe() {
		if(!$_REQUEST['datakind']){
			$this->assign("datakind",'全部');
		}
		A("Method")->_shenhe();
		if($_REQUEST['type'] == '收支项')
		A("Method")->showDirectory("收支项审核");
		if($_REQUEST['type'] == '报账单')
		A("Method")->showDirectory("报账单审核");
		if($_REQUEST['type'] == '订单')
		A("Method")->showDirectory("订单审核");
		$this->display('shenhe');
	}
	
	
	public function doshenhe() {
		A("Method")->_doshenhe();
	}
	
	
	public function left_fabu($htmltp='',$pagetype='') {
		$ViewDepartment = D("ViewDepartment");
		$where['type'] = array('like','%联合体%');
		$bumenlist = $ViewDepartment->where($where)->findall();
		$this->assign("bumenlist",$bumenlist);
		$zutuanlist = $ViewDepartment->where("`type` like '%组团%' and `type` not like '%联合体%' and `type` not like '%办事处%'")->findall();
		$this->assign("zutuanlist",$zutuanlist);
		$dijielist = $ViewDepartment->where("`type` like '%地接%' and `type` not like '%联合体%' and `type` not like '%办事处%'")->findall();
		$this->assign("dijielist",$dijielist);
		$this->assign("pagetype",$pagetype);
		if($htmltp)
			$this->display('Caiwu:'.$htmltp);
		else
		$this->display('Caiwu:left_fabu');
	}
	
	
	
	public function jixiao_tongji() {
		A("Method")->showDirectory("统计");
		//订单搜索
		$where['status_system'] = 1;
		if($_REQUEST['start_time'] && $_REQUEST['end_time']){
			$where['baozhang_time'] = array('between',strtotime($_REQUEST['start_time']).','.strtotime($_REQUEST['end_time']));	
		}
		else{
			$month = NF_getmonth();
			$fm_forward_month = $month['forward'];
			$where['baozhang_time'] = array('between',strtotime($fm_forward_month.'-01').','.strtotime(date("Y-m").'-01'));	
			$_REQUEST['start_time'] = $fm_forward_month.'-01';
			$_REQUEST['end_time'] = date("Y-m").'-01';
			$this->assign("start_time",$fm_forward_month.'-01');
			$this->assign("end_time",date("Y-m").'-01');
		}
		$ViewDataDictionary = D("ViewDataDictionary");
		//订单列表
		$ViewDingdan = D("ViewDingdan");
		$dingdanall = $ViewDingdan->where($where)->findall();
		foreach($dingdanall as $v){
			$tongji['chengrenshu'] += $v['chengrenshu'];
			$tongji['ertongshu'] += $v['ertongshu'];
			$tongji['zongrenshu'] += $v['chengrenshu']+$v['ertongshu'];
			//收客提成
			$ticheng = $ViewDataDictionary->where("`systemID` = '$v[tichengID]'")->find();
			$tongji['ticheng'] += $v['jiage'] * (int)$ticheng['description'] / 100 ;
		}
		//操作费
		$tongji['caozuofei'] = $tongji['zongrenshu'] * 2 ;
		$this->assign("tongji",$tongji);
		
		//用户列表
		if($_REQUEST["title"])
		$where_unit['title'] = $_REQUEST["title"];
		$where_unit['status_system'] = 1;
		if($_REQUEST['type'] == '员工'){
			$ViewUser = D("ViewUser");
			$unitdata = $ViewUser->where($where_unit)->findall();
		}
		if($_REQUEST['type'] == '部门'){
			if($_REQUEST["systemID"])
			$where_unit['systemID'] = $_REQUEST["systemID"];
			$ViewDepartment = D("ViewDepartment");
			$unitdata = $ViewDepartment->where($where_unit)->findall();
		}
		//分类处理
		$i = 0;
		foreach($unitdata as $v){
			$t = 0;
			$m = 0;
			$n = 0;
			$k = 0;
			foreach($dingdanall as $vol){
				$ok_caozuo = 0;
				$ok_shouke = 0;
				if($_REQUEST['type'] == '员工'){
					if($vol['fuzeren'] == $v['title']){
						$ok_caozuo = 1;
					}
					if($vol['owner'] == $v['title']){
						$ok_shouke = 1;
					}
				}
				if($_REQUEST['type'] == '部门'){
					if($vol['fuzebumenID'] == $v['systemID']){
						$ok_caozuo = 1;
					}
					if($vol['departmentID'] == $v['systemID']){
						$ok_shouke = 1;
					}
				}
				//操作数
				if($ok_caozuo){
					$vol['jixiaotype'] = '操作';
					$vol['caozuo_price'] = ($vol['chengrenshu']+$vol['ertongshu']) * 2;
					$unitdata[$i]['dingdan_caozuo'][$m] = $vol;
					$unitdata[$i]['caozuo_shu'] += $vol['chengrenshu']+$vol['ertongshu'];
					$unitdata[$i]['caozuo_chengren'] += $vol['chengrenshu'];
					$unitdata[$i]['caozuo_ertong'] += $vol['ertongshu'];
					$unitdata[$i]['caozuo_price'] += $vol['caozuo_price'];
					$m++;
				}
				//收客数
				if($ok_shouke){
					if($vol['jixiaotype'])
					$vol['jixiaotype'] .= '/收客';
					else
					$vol['jixiaotype'] = '收客';
					$ticheng = $ViewDataDictionary->where("`systemID` = '$vol[tichengID]'")->find();
					$vol['ticheng'] = $ticheng;
					$vol['shouke_price'] = $vol['jiage'] * (int)$ticheng['description'] / 100 ;
					$unitdata[$i]['dingdan_shouke'][$n] = $vol;
					$unitdata[$i]['shouke_shu'] += $vol['chengrenshu']+$vol['ertongshu'];
					$unitdata[$i]['shouke_chengren'] += $vol['chengrenshu'];
					$unitdata[$i]['shouke_ertong'] += $vol['ertongshu'];
					$unitdata[$i]['shouke_price'] += $vol['shouke_price'];
					if($vol['title'] == '直客'){
						$unitdata[$i]['zhike_num'] += $vol['chengrenshu']+$vol['ertongshu'];
					}
					if($vol['title'] == '散客'){
						$unitdata[$i]['sanke_num'] += $vol['chengrenshu']+$vol['ertongshu'];
					}
					$n++;
				}
				if($ok_shouke || $ok_caozuo){
					$unitdata[$i]['dingdan'][$k] = $vol;
					$k++;
				}
				$t++;
			}
			//搜索单人	
			if($_REQUEST['returnkind'] == '收客')
				$data = $unitdata[$i]['dingdan_shouke'];
			elseif($_REQUEST['returnkind'] == '操作')
				$data = $unitdata[$i]['dingdan_caozuo'];
			$i++;
		}
		$this->assign("unitdata",$unitdata);
		//打印
		if($_REQUEST['doprint'] == 1){
			$this->display('print_jixiao');
			return ;	
		}
		if($_REQUEST['export'] == 1){
			//导出Word
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . $_REQUEST['start_time'].'至'.$_REQUEST['end_time'] . "绩效统计.doc");
			header("Pragma:no-cache");        
			header("Expires:0"); 
			$this->display('print_jixiao');
			return ;	
		}
		//返回	
		if($_REQUEST['returntype'] == 'ajax' && $_REQUEST['returnkind'] == '收客'){
				if($_REQUEST['type'] == '部门')
					$tabtile = '<th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 收客人 </div></th>';
				$str = '
					<table cellpadding="0" cellspacing="0" width="100%" class="list view">
						<tr height="20">
						  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 标题 </div></th>'.$tabtile.'
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单类型 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 成人/儿童/领队  </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 售价 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 提成类型</div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 收客提成 </div></th>
						</tr>
				';
				$i = 0;
				foreach($data as $v){$i++;
					if($_REQUEST['type'] == '部门')
						$tabvalue = '<td>'.$v['owner'].'</td>';
					$str .= '
					<tr class="evenListRowS1">
					  <td>'.$i.'</td>
					  <td><a target="_blank" href="'.SITE_INDEX.'Xiaoshou/dingdanxinxi/chanpinID/'.$v['chanpinID'].'">'.$v['title'].'</a></td>'.$tabvalue.'
					  <td>'.$v['type'].'</td>
					  <td>'.$v['chengrenshu'].'/'.$v['ertongshu'].'/'.$v['lingdui_num'].'</td>
					  <td>'.$v['jiage'].'</td>
					  <td>'.$v['ticheng']['title'].'/'.$v['ticheng']['description'].'%</td>
					  <td>'.$v['shouke_price'].'</td>
					</tr>
					';
				}
				$str .= '
					<tr class="evenListRowS1">
					  <td align="right" colspan="3">
					  '.$page.'
					  </td>
					</tr>
					</table>
				';
				$this->ajaxReturn($str, '', 1);
		}
		elseif($_REQUEST['returntype'] == 'ajax' && $_REQUEST['returnkind'] == '操作'){
				$str = '
					<table cellpadding="0" cellspacing="0" width="100%" class="list view">
						<tr height="20">
						  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 标题 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单类型</div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 成人/儿童/领队  </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 售价 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 操作费提成（元/人）</div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 操作费（全部） </div></th>
						</tr>
				';
				$i = 0;
				foreach($data as $v){$i++;
					$str .= '
					<tr class="evenListRowS1">
					  <td>'.$i.'</td>
					  <td><a target="_blank" href="'.SITE_INDEX.'Xiaoshou/dingdanxinxi/chanpinID/'.$v['chanpinID'].'">'.$v['title'].'</a></td>
					  <td>'.$v['type'].'</td>
					  <td>'.$v['chengrenshu'].'/'.$v['ertongshu'].'/'.$v['lingdui_num'].'</td>
					  <td>'.$v['jiage'].'</td>
					  <td> 2 </td>
					  <td>'.($v['chengrenshu'] + $v['ertongshu'] ) * 2 .'</td>
					</tr>
					';
				}
				$str .= '
					<tr class="evenListRowS1">
					  <td align="right" colspan="3">
					  '.$page.'
					  </td>
					</tr>
					</table>
				';
				$this->ajaxReturn($str, '', 2);
		}
		else
		$this->display('tongji_jixiao');
	}
	
	
	
	
	
	
	public function yingshou_tongji() {
		A("Method")->showDirectory("统计");
		//搜索
		if($_REQUEST['title'])
			$where_unit['title'] = array('like','%'.$_REQUEST['title'].'%');
		$where['status_system'] = 1;
		if($_REQUEST['start_time'] && $_REQUEST['end_time']){
			$where['baozhang_time'] = array('between',strtotime($_REQUEST['start_time']).','.strtotime($_REQUEST['end_time']));	
		}
		else{
			$month = NF_getmonth();
			$fm_forward_month = $month['forward'];
			$where['shenhe_time'] = array('between',strtotime($fm_forward_month.'-01').','.strtotime(date("Y-m").'-01'));	
			$_REQUEST['start_time'] = $fm_forward_month.'-01';
			$_REQUEST['end_time'] = date("Y-m").'-01';
			$this->assign("start_time",$fm_forward_month.'-01');
			$this->assign("end_time",date("Y-m").'-01');
		}
		$ViewDataDictionary = D("ViewDataDictionary");
		//订单列表
		$ViewBaozhang = D("ViewBaozhang");
		$baozhangall = $ViewBaozhang->where($where)->findall();
		foreach($baozhangall as $v){
			$tongji['renshu'] += $v['renshu'];
			$tongji['yingshou'] += $v['yingshou_copy'];
			$tongji['yingfu'] += $v['yingfu_copy'];
			$tongji['maoli'] += $v['yingshou_copy'] - $v['yingfu_copy'];
		}
		$tongji['maolilv'] = sprintf( '%.2f%%',$tongji['maoli']/$tongji['yingshou'] * 100);
		$this->assign("tongji",$tongji);
		//部门列表
		if($_REQUEST["systemID"])
		$where_unit['systemID'] = $_REQUEST["systemID"];
		$ViewDepartment = D("ViewDepartment");
		$unitdata = $ViewDepartment->where($where_unit)->findall();
		//分类处理
		$i = 0;
		foreach($unitdata as $v){
			$m = 0;
			foreach($baozhangall as $vol){
				if($vol['departmentID'] == $v['systemID']){
					$vol['maoli'] = $vol['yingshou_copy'] - $vol['yingfu_copy'];
					$vol['maolilv'] = sprintf( '%.2f%%',$vol['maoli']/$vol['yingshou_copy'] * 100);
					$unitdata[$i]['baozhang'][$m] = $vol;
					$unitdata[$i]['fatuanrenshu'] += (int)$vol['renshu'];
					$unitdata[$i]['yingshou'] += $vol['yingshou_copy'];
					$unitdata[$i]['yingfu'] += $vol['yingfu_copy'];
					$unitdata[$i]['maoli'] += $vol['yingshou_copy'] - $vol['yingfu_copy'];
					$m++;
				}
			}
			$unitdata[$i]['maolilv'] = sprintf( '%.2f%%',$unitdata[$i]['maoli']/$unitdata[$i]['yingshou'] * 100);
			if($_REQUEST['returntype'] == 'ajax')
				$data = $unitdata[$i]['baozhang'];
			$i++;
		}
		$this->assign("unitdata",$unitdata);
		//打印
		if($_REQUEST['doprint'] == 1){
			$this->display('print_yingshou');
			return ;	
		}
		if($_REQUEST['export'] == 1){
			//导出Word
			header("Content-type:application/msword");
			header("Content-Disposition:attachment;filename=" . $_REQUEST['start_time'].'至'.$_REQUEST['end_time'] . "绩效统计.doc");
			header("Pragma:no-cache");        
			header("Expires:0"); 
			$this->display('print_yingshou');
			return ;	
		}
		
		//返回	
		if($_REQUEST['returntype'] == 'ajax'){
				$str = '
					<table cellpadding="0" cellspacing="0" width="100%" class="list view">
						<tr height="20">
						  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 标题 </div></th>'.$tabtile.'
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 类型 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 人数  </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 应收款 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 应付款 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 毛利 </div></th>
						  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 毛利率 </div></th>
						</tr>
				';
				$i = 0;
				foreach($data as $v){$i++;
					$str .= '
					<tr class="evenListRowS1">
					  <td>'.$i.'</td>
					  <td><a target="_blank" href="'.SITE_INDEX.'Chanpin/zituanbaozhang/baozhangID/'.$v['chanpinID'].'">'.$v['title'].'</a></td>'.$tabvalue.'
					  <td>'.$v['type'].'</td>
					  <td>'.$v['renshu'].'</td>
					  <td>'.$v['yingshou_copy'].'</td>
					  <td>'.$v['yingfu_copy'].'</td>
					  <td>'.$v['maoli'].'</td>
					  <td>'.$v['maolilv'].'</td>
					</tr>
					';
				}
				$str .= '
					<tr class="evenListRowS1">
					  <td align="right" colspan="3">
					  '.$page.'
					  </td>
					</tr>
					</table>
				';
				$this->ajaxReturn($str, '', 1);
		}
		else
		$this->display('tongji_yingshou');
	}
	
	
	
	
	
	public function zituanlist() {
		if($_REQUEST['kind_copy'] == '近郊游')$this->assign("markpos",'近郊游');
		elseif($_REQUEST['kind_copy'] == '长线游')$this->assign("markpos",'长线游');
		elseif($_REQUEST['kind_copy'] == '韩国')$this->assign("markpos",'韩国');
		elseif($_REQUEST['kind_copy'] == '日本')$this->assign("markpos",'日本');
		elseif($_REQUEST['kind_copy'] == '台湾')$this->assign("markpos",'台湾');
		elseif($_REQUEST['kind_copy'] == '港澳')$this->assign("markpos",'港澳');
		elseif($_REQUEST['kind_copy'] == '东南亚')$this->assign("markpos",'东南亚');
		elseif($_REQUEST['kind_copy'] == '欧美岛')$this->assign("markpos",'欧美岛');
		elseif($_REQUEST['kind_copy'] == '自由人')$this->assign("markpos",'自由人');
		elseif($_REQUEST['kind_copy'] == '包团')$this->assign("markpos",'包团');
		else
		$this->assign("markpos",'全部');
		A("Method")->showDirectory("团费确认");
		$datalist = A('Method')->getDataOMlist('子团','zituan',$_REQUEST);
		$ViewDingdan = D("ViewDingdan");
		$DataCD = D("DataCD");
		$i = 0;
		foreach($datalist['chanpin'] as $v){
			//搜索订单
			$dingdanall = $ViewDingdan->where("`parentID` = '$v[chanpinID]' AND `status` = '确认'")->findall();
			foreach($dingdanall as $vol){
				$customerall = $DataCD->where("`dingdanID` = '$vol[chanpinID]'")->findall();
				foreach($customerall as $c){
					if($c['ispay'] == '已付款'){
						$datalist['chanpin'][$i]['payed'] += $c['price'];
					}
					if($c['ispay'] == '未付款'){
						$datalist['chanpin'][$i]['unpay'] += $c['price'];
					}
					$datalist['chanpin'][$i]['tuanfei'] += $c['price'];
				}
			}
			$i++;
		}
		$this->assign("page",$datalist['page']);
		$this->assign("chanpin_list",$datalist['chanpin']);
		$this->display('zituanlist');
	}
	
	
	public function shenheback() {
		A("Method")->_shenheback();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>