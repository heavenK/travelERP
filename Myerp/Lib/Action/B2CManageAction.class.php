<?php

class B2CManageAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'电商管理');
	}
	
	
    public function index() {
		A("Method")->showDirectory("网店线路管理");
		//筛选条件
		$_REQUEST['serverdataID'] = array('neq','');
		if($_REQUEST['second_confirm'])
			A("Method")->showDirectory("二次确认线路管理");
		else
			A("Method")->showDirectory("网店线路管理");
		$chanpin_list = A('Method')->getDataOMlist('线路','xianlu',$_REQUEST);
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('index');
    }
	
	
    public function dingdanlist() {
		if($_REQUEST['second_confirm']){
			A("Method")->showDirectory("二次确认订单管理");
			A("Method")->_dede_dingdanlist();
		}
		else{
			A("Method")->showDirectory("电商订单管理");
			$_REQUEST['user_name'] = '电商';
			A("Xiaoshou")->dingdanlist();
		}
    }
	
	
    public function dingzhixinxi() {
		A("Method")->showDirectory("电商定制信息");
		$_REQUEST['user_name'] = '电商';
		A("Message")->gexingdingzhilist();
    }
	
	
    public function zituanlist() {
		//筛选条件
		$_REQUEST['status_shop'] = array('neq','');
		$_REQUEST['webpage'] = 1;
		A("Method")->_zituanlist('产品搜索');	
    }
	
	
    public function getyudinglist() {
		$chanpinID = $_REQUEST['chanpinID'];
		$WEBServiceOrder = D("WEBServiceOrder");
		$orderall = $WEBServiceOrder->where("`clientdataID` = '$chanpinID'")->findall();
		//返回	
		$str = '
			<table cellpadding="0" cellspacing="0" width="100%" class="list view">
				<tr height="20">
				  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单编号 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 联系人姓名  </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 电话 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 邮箱 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 成人 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 儿童 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单时间 </div></th>
				</tr>
		';
		$i = 0;
		foreach($orderall as $v){$i++;
			$str .= '
			<tr class="evenListRowS1">
			  <td>'.$i.'</td>
			  <td>'.$v['orderID'].'</a></td>
			  <td>'.$v['lxr_name'].'</td>
			  <td>'.$v['lxr_telnum'].'</td>
			  <td>'.$v['lxr_email'].'</td>
			  <td>'.$v['chengrenshu'].'</td>
			  <td>'.$v['ertongshu'].'</td>
			  <td>'.date("Y-m-d H:i:s",$v['time']).'</td>
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
		//$this->ajaxReturn($orderall, '读取成功！', 1);
    }
	
	
	//获得众信数据
    public function zhongXinInterface() {
        import("@.ORG.Snoopy");
		$Snoopy = new Snoopy();
		$url = 'http://erp.utourworld.com/api/team/teamInterfaceUrl.asp';
		$Snoopy->fetchlinks($url);
		$xmlNo = $_REQUEST['xmlNo'];
		if(!$xmlNo)
			$xmlNo = 1;
		$i = 1;	
		foreach($Snoopy->results as $v){
			if($i == $xmlNo){
				$this->_xml2chanpin($v,$xmlNo,count($Snoopy->results));
			}
			$i++;	
		}
		$this->ajaxReturn('', '成功！执行结束', 1);
    }
	
	
	//解析xml
    public function _xml2chanpin($url,$xmlNo,$xmlcount) {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		
//		$xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA );//兼容CDATA格式
//		$xml2array = xmltoarray($xml);
		$xml2array = xmltoarrayMix($url);
			
		if($xml2array['item'] > 1){
			$itemNo = $_REQUEST['itemNo'];
			if(!$itemNo)
				$itemNo = 1;
			$i = 1;	
			foreach($xml2array['item'] as $item){
				if($itemNo == 1){
					$this->_checksamexianlu($xml2array,$xml2array['item'][29],$xmlNo+1,$itemNo,$xmlcount);
				}
				if($i == $itemNo){
					$itemNo += 1;
					$this->_xml2chanpin_inter($xml2array,$item,$xmlNo,$itemNo,$xmlcount);
				}
				$i++;
			}
			//跳转
			$xmlNo += 1;
			$url = SITE_INDEX.'B2CManage/zhongXinInterface/xmlNo/'.$xmlNo;
			$msg = '共'.$xmlcount.'组产品,本组'.count($xml2array['item']).'条线路。<br/>';
			$msg .= '正在接收第'.$xmlNo.'组第1条线路....';
			$this->_wait4server($url,$msg);
		}
		else{
			$item = $xml2array['item'];
			$xmlNo += 1;
			$this->_xml2chanpin_inter($xml2array,$item,$xmlNo,$itemNo,$xmlcount);
		}
    }
	
	
	//解析xml inter
    public function _xml2chanpin_inter($xml2array,$item,$xmlNo,$itemNo=1,$xmlcount) {
		//检查线路
		$this->_checksamexianlu($xml2array,$item,$xmlNo,$itemNo,$xmlcount);
		$Chanpin = D("Chanpin");
		$chanpin = $this->_fill2chanpin($item);
		$chanpin['xianlu'] = $this->_fill2xianlu($item);
		if (false !== $Chanpin->relation('xianlu')->myRcreate($chanpin)){
			$chanpinID = $Chanpin->getRelationID();
			$chanpin['xingcheng'] = $this->_fill2xingcheng($item,$chanpinID);
			//生成OM
			A("Method")->_OMRcreate($chanpinID,'线路');
			//批准成团
			$this->_shenhepizhun($chanpinID);
			//跳转
			$url = SITE_INDEX.'B2CManage/zhongXinInterface/xmlNo/'.$xmlNo.'/itemNo/'.$itemNo;
			$msg = '共'.$xmlcount.'组产品,本组'.count($xml2array['item']).'条线路。<br/>';
			$msg .= '正在接收第'.$xmlNo.'组第'.$itemNo.'条线路....';
			$this->_wait4server($url,$msg);
		}
		else{
			$this->ajaxReturn($Chanpin, '发生错误!', 0);
		}
    }
	
	
	//检查重复信息
    public function _checksamexianlu($xml2array,$item,$xmlNo,$itemNo=1,$xmlcount) {
		$ViewXianlu = D("ViewXianlu");
		$where['supplier'] = "众信"; 
		$where['supplier_lineid'] = $item['@attributes']['lineid'];
		if($ViewXianlu->where($where)->find()){
			//跳转
			$url = SITE_INDEX.'B2CManage/zhongXinInterface/xmlNo/'.$xmlNo.'/itemNo/'.$itemNo;
			$msg = '共'.$xmlcount.'组产品,本组'.count($xml2array['item']).'条线路。<br/>';
			$msg .= '正在接收第'.$xmlNo.'组第'.$itemNo.'条线路....';
			$this->_wait4server($url,$msg);
		}
	}
	
	
	//服务器等待
    public function _wait4server($url,$msg) {
		$this->ajaxReturn($url, $msg, 1);
    }
	
	
	//填充chanpin
    public function _fill2chanpin() {
		$chanpin['user_name'] = '电商采购';
		$d = A("Method")->_getDepartmentByTitle('直营-电子商务营业部');
		$chanpin['departmentID'] = $d['systemID'];
		return $chanpin;
    }
	
	
	//填充xianlu
    public function _fill2xianlu($item) {
		if($item['@attributes']['type'] == '出境游'){
			$guojing = '境外';
			//xianlu_ext
			$xianlu_ext['feiyongyes'] = $item['feeInclude'];
			$xianlu_ext['feiyongno'] = $item['feeExclude'];
			$xianlu_ext['qianzhengxinxi'] = $item['visaInfos'];
			$xianlu_ext['kexuanzifei'] = $item['ownExpense'];
			$xianlu_ext['gouwuxinxi'] = '';
			$xianlu_ext['yudingtiaokuan'] = $item['bookingTerms'];
			$xianlu_ext['chuxingjingshi'] = $item['tips'];
			$xianlu['xianlu_ext'] = serialize($xianlu_ext);
		}
		else
			$guojing = '国内';
		$xianlu['guojing'] = $guojing;
		$xianlu['title'] = $item['@attributes']['title'];
		$xianlu['shoujia'] = $item['@attributes']['price'];
		$xianlu['ertongshoujia'] = $xianlu['shoujia'];
		$xianlu['mudidi'] = $item['@attributes']['arrive'];
		$xianlu['chufadi'] = $item['@attributes']['departure'];
		$xianlu['baomingjiezhi'] = 1;
		$xianlu['quankuanriqi'] = 1;
		$xianlu['renshu'] = $item['advanceday'];
		if(!$xianlu['renshu'])
			$xianlu['renshu'] = 30;
		$xianlu['tianshu'] = $item['@attributes']['itineraryDay'];
		$xianlu['zhuti'] = $item['@attributes']['subject'];
		//日期
		$chutuanriqi = '';
		if(count($item['routeDates']['routeDate'])>1)
			foreach($item['routeDates']['routeDate'] as $routeDate){
				if($chutuanriqi)
					$chutuanriqi .= ';';
				$chutuanriqi .= $routeDate['@attributes']['date'];
			}
		else
			$chutuanriqi = $item['routeDates']['routeDate']['@attributes']['date'];
		$xianlu['chutuanriqi'] = $chutuanriqi;
		$xingchengtese = '';
		//特色
		if(count($item['features']['feature'])>1)
			foreach($item['features']['feature'] as $feature){
				$xingchengtese .= $feature.'<br/>';
			}
		else
			$xingchengtese = $item['features']['feature'];
		$xianlu['xingchengtese'] = $xingchengtese;
		$xianlu['cantuanxuzhi'] = '以本团要求为准';
		$xianlu['kind'] = $item['@attributes']['type'];
		//其他数据
		$xianlu['zhongxindatatext']['@attributes'] = $item['@attributes'];
		$xianlu['zhongxindatatext']['routeDates'] = $item['routeDates'];
		$xianlu['datatext'] = serialize($xianlu);
		$xianlu['second_confirm'] = 1;
		$xianlu['supplier'] = '众信';//线路唯一标识
		$xianlu['supplier_lineid'] = $item['@attributes']['lineid'];//线路唯一标识
		return $xianlu;
    }
	
	
	//填充xianlu_ext
    public function _fill2xingcheng($item,$parentID) {
		$Chanpin = D("Chanpin");
		$dat['parentID'] = $parentID;
		$dat['user_name'] = '电商采购';
		$d = A("Method")->_getDepartmentByTitle('直营-电子商务营业部');
		$dat['departmentID'] = $d['systemID'];
		if(count($item['miscellaneous']['itineraryDay'])>1){
			$i = 0;
			foreach($item['miscellaneous']['itineraryDay'] as $itineraryDay){
				$itineraryDay_backup2 = $item['backup2']['miscellaneous']['itineraryDay'][$i];
				$dat['xingcheng']['place'] = $itineraryDay_backup2['@attributes']['accommodation'];
				$dat['xingcheng']['tools'] = $itineraryDay_backup2['@attributes']['traffic'];
				if($itineraryDay_backup2['@attributes']['breakfast'] == '有')
					$chanyin[0] = '早餐';
				if($itineraryDay_backup2['@attributes']['lunch'] == '有')
					$chanyin[1] = '午餐';
				if($itineraryDay_backup2['@attributes']['supper'] == '有')
					$chanyin[2] = '晚餐';
				$chanyin = array_values($chanyin);
				$dat['xingcheng']['chanyin'] = serialize($chanyin);
				$dat['xingcheng']['content'] = $itineraryDay;
				if (false === $Chanpin->relation('xingcheng')->myRcreate($dat))
				return false;
				$i++;
			}
		}
		else{
				$itineraryDay_backup2 = $item['backup2']['miscellaneous']['itineraryDay'];
				$dat['xingcheng']['place'] = $itineraryDay_backup2['@attributes']['accommodation'];
				$dat['xingcheng']['tools'] = $itineraryDay_backup2['@attributes']['traffic'];
				if($itineraryDay_backup2['@attributes']['breakfast'] == '有')
					$chanyin[0] = '早餐';
				if($itineraryDay_backup2['@attributes']['lunch'] == '有')
					$chanyin[1] = '午餐';
				if($itineraryDay_backup2['@attributes']['supper'] == '有')
					$chanyin[2] = '晚餐';
				$chanyin = array_values($chanyin);
				$dat['xingcheng']['chanyin'] = serialize($chanyin);
				$dat['xingcheng']['content'] = $item['miscellaneous']['itineraryDay'];
				if (false === $Chanpin->relation('xingcheng')->myRcreate($dat))
				return false;
		}
		return true;
    }
	
	
	//erp批准
    public function _shenhepizhun($chanpinID) {
		C('TOKEN_ON',false);
		$Chanpin = D("Chanpin");
		$editdat['chanpinID'] = $chanpinID;
		$editdat['status_shenhe'] = '批准';
		$editdat['status'] = '报名';
		$Chanpin->save($editdat);
		//线路审核通过,生成子团
		A("Method")->shengchengzituan($chanpinID);
		//同步售价表线路状态
		A("Method")->_tongbushoujia($chanpinID);
		//提交网店价格产品更新
		$itemlist[0] = $chanpinID;
		A("MethodClient")->_doonshop_xianlu($itemlist,0);
    }
	
	
	
}
?>