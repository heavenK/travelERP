<?php

class CaiwuAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'财务管理');
	}
	
	
	public function shenhe() {
		if(!$_REQUEST['datakind']){
			$this->assign("datakind",'全部');
		}
		$datalist = A("Method")->_shenhe();
		$i = 0;
		$ViewBaozhang = D("ViewBaozhang");
		foreach($datalist['chanpin'] as $v){
			
			//项目信息
			$datalist['chanpin'][$i]['datatext_copy'] = $dat = simple_unserialize($v['datatext_copy']);
			$bzd = $ViewBaozhang->where("`chanpinID` = '$dat[chanpinID]'")->find();
			//$datalist['chanpin'][$i]['datatext_copy'] = $bzd;
			if($_REQUEST['type'] == '收支项'){
				//所属报账单信息
				$bzdID = $datalist['chanpin'][$i]['datatext_copy']['parentID'];
				$baozhang = $ViewBaozhang->where("`chanpinID` = '$bzdID'")->find();
				$datalist['chanpin'][$i]['baozhang'] = $baozhang;
			}
			if($_REQUEST['type'] == '报账单'){
				//统计
			}
			$i++;
		}
		if($_REQUEST['type'] == '收支项')
		A("Method")->showDirectory("收支项审核");
		if($_REQUEST['type'] == '报账单')
		A("Method")->showDirectory("报账单审核");
		if($_REQUEST['type'] == '订单')
		A("Method")->showDirectory("订单审核");
		$this->assign("chanpin_list",$datalist['chanpin']);
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
		$where['status_shenhe'] = '批准';
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
		$DataCD = D("DataCD");
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
					//新老客户
					$cdall = $DataCD->where("`dingdanID` = '$vol[chanpinID]'")->findall();
					foreach($cdall as $cd){
						if($cd['laokehu'] == 1)
							$unitdata[$i]['laokehu'] += 1;
						else	
							$unitdata[$i]['xinkehu'] += 1;
					}
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
		if($_REQUEST['listtype'] == '员工'){
			$where['user_name'] = array('like','%'.$_REQUEST['title'].'%');
		}
		$where['status_system'] = 1;
		if($_REQUEST['start_time'] && $_REQUEST['end_time']){
			$where['shenhe_time'] = array('between',strtotime($_REQUEST['start_time']).','.strtotime($_REQUEST['end_time']));	
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
		if($_REQUEST['departmentID'])
			$where['departmentID'] = $_REQUEST["departmentID"];
		$ViewDataDictionary = D("ViewDataDictionary");
		//总体统计。订单列表
		if(!$_REQUEST['shenhe_remark'])
			$where['shenhe_remark'] = array(array('like','财务总监%'),array('like','总经理%'), 'or');;
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
		
		if($_REQUEST['listtype'] == '员工'){
			$this->assign("markpos",$_REQUEST['listtype']);
			//用户列表
			$ViewUser = D("ViewUser");
			$unitdata = $ViewUser->where($where_unit)->findall();
			//根据部门过滤用户
			if($_REQUEST['departmentID']){
				$ii = 0;
				foreach($unitdata as $u){
					$durlist = A("Method")->_getDURlist_name($u['title']);
					$markt = 0;
					foreach($durlist as $dr){
						if($dr['bumenID'] == $_REQUEST['departmentID']){
							$markt = 1;
							break;
						}
					}
					if($markt == 0)
						unset($unitdata[$ii]);
					$ii++;
				}
				$unitdata = array_diff($unitdata, array(null));
				$unitdata = array_values($unitdata);
			}
		}
		else{
			//部门列表
			if($_REQUEST["systemID"])
			$where_unit['systemID'] = $_REQUEST["systemID"];
			$ViewDepartment = D("ViewDepartment");
			$unitdata = $ViewDepartment->where($where_unit)->findall();
		}
		//分类处理
		$i = 0;
		foreach($unitdata as $v){
			if($_REQUEST['listtype'] == '员工'){
				$right = $v['title'];
			}
			else{
				$right = $v['systemID'];
			}
			$m = 0;
			foreach($baozhangall as $vol){
				if($_REQUEST['listtype'] == '员工'){
					$left = $vol['user_name'];
				}
				else{
					$left = $vol['departmentID'];
				}
				if($left == $right){
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
					  <td><a target="_blank" href="'.SITE_INDEX.'Chanpin/zituanbaozhang/doprint/打印/baozhangID/'.$v['chanpinID'].'">'.$v['title'].'</a></td>'.$tabvalue.'
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
		else{
			$this->display('tongji_yingshou');
		}
	}
	
	
	public function zituanlist() {
		$dotype = $_REQUEST['dotype'];
		A("Method")->_zituanlist($dotype);	
	}
	
	
	public function shenheback() {
		A("Method")->_shenheback();
	}
	
	public function djtuanlist() {
		A("Dijie")->index("财务管理");
	}
	
	
	
	public function tuansearch() {
		A("Method")->showDirectory("组团地接产品");
		$ViewZituan = D("ViewZituan");
		$ViewDJtuan = D("ViewDJtuan");
		$ViewBaozhang = D("ViewBaozhang");
		$chanpin_list = A('Method')->data_list_noOM('ViewSearch',$_REQUEST);
		$i = 0;
		foreach($chanpin_list['chanpin'] as $v){
			if($v['marktype'] == 'zituan'){
				$tuan = $ViewZituan->where("`chanpinID` = '$v[chanpinID]'")->find();
			}
			if($v['marktype'] == 'DJtuan'){
				$tuan = $ViewDJtuan->where("`chanpinID` = '$v[chanpinID]'")->find();
			}
			$chanpin_list['chanpin'][$i]['tuan'] = $tuan;
			//报账单
			$bzd = $ViewBaozhang->where("`parentID` = '$v[chanpinID]'")->find();
			$chanpin_list['chanpin'][$i]['baozhang'] = $bzd;
			$i++;
		}
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('tuansearch');
	}
	
	
	public function danxiangfuwu() {
		A("Method")->_danxiangfuwu('财务');
	}
	
	public function tuanbaozhang() {
		$Chanpin = D("Chanpin");
		$bzd = $Chanpin->where("`chanpinID` = '$_REQUEST[baozhangID]'")->find();
		$pcp = $Chanpin->where("`chanpinID` = '$bzd[parentID]'")->find();
		if($pcp['marktype'] == 'zituan'){
			$actionmethod = 'Chanpin';
			$type = '子团';
		}
		elseif($pcp['marktype'] == 'DJtuan'){
			$actionmethod = 'Dijie';
			$type = '地接';
		}
		else{
			$is_o = 1;
			$actionmethod = 'Chanpin';
		}
		$this->assign("actionmethod",$actionmethod);
		A("Method")->showDirectory("签证及票务");
		if($is_o == 1)
			$actionmethod = 'Caiwu';
		$this->assign("action_type",$actionmethod);
		if(!$_REQUEST['chanpinID'])
			A("Method")->_baozhang();
		else
			A("Method")->_baozhang($type);
	}
	
}
?>