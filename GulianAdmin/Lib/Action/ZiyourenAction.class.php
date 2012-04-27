<?php

class ZiyourenAction extends CommonAction{
	
	
    public function gethotellinelist() {
		
		$type = $_POST['type'];
		$wheres = '';
		if (!empty($type)){
			$hotel = $_POST['hotel'];
			if ($hotel){
				$wheres['hotel_title'] = array('like','%'.$hotel.'%'); 	
			}
			
			$room = $_POST['room'];
			if ($room){
				$wheres['house_title'] = array('like','%'.$room.'%'); 	
			}
			
			$city = $_POST['city'];
			if ($city){
				$wheres['city_name'] = array('like','%'.$city.'%'); 	
			}
			
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			
			if ($start_date && $end_date){
				$wheres['start_date'] = array('between',array(strtotime($start_date),strtotime($end_date)));
			}
			elseif ($start_date){
				$wheres['start_date'] = array('egt',strtotime($start_date)); 	
			}
			elseif ($end_date){
				$wheres['start_date'] = array('elt',strtotime($end_date)); 	
			}
			
			$status = $_POST['status'];
			if ($status != '全部'){
				$wheres['status'] = $status; 	
			}
		}
		
		$data = D('Hotel_line_view');
		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		
		$count = $data->where($wheres)->group('hotel_id')->count();
		$p = new Page ( $count, 10 ); 
		$list=$data->limit($p->firstRow.','.$p->listRows)->where($wheres)->group('hotel_id')->order('hotel_id desc')->findAll(); 
		foreach($list as $key=>$hotels){
			$wheres['hotel_id'] = $hotels['hotel_id'];
			$data_line[$key] = $data->where($wheres)->order('id desc')->findAll(); 
			}
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Hotel/index/p/');

		
		$this->assign ( "data_line", $data_line );
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display('Hotel'); 
    }


    public function xianlujiage() {
		
		if($_GET['zituanID'])
		{
			$zituanID = $_GET['zituanID'];
			$glzituan = D("glzituan");
			$zituan = $glzituan->where("`zituanID` = '$zituanID'")->find();
			$xianluID = $zituan['xianluID'];
			$showpage = 'Kongguan/xianlujiage_zyr';
			$this->assign('zituan',$zituan);
			$this->assign('location','价格');
			$this->assign('navlist','产品控管 > '.$zituan['guojing'].' > 价格');
			
		}
		if($_GET['xianluID'])
		{
			$xianluID = $_GET['xianluID'];
			$showpage = 'xianlujiage';
		}
		
		xianluIsAdmin($xianluID,$this);
		$Glxianlujiage = D("Glxianlujiage");
		$xianlujiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();
		if(!$xianlujiage)
		{
			//价格
			$jiage['xianluID'] = $xianluID;
			$jiage['time'] = time();
			$jiage['xuanzetype'] = 'Batch';
			$jiageID = $Glxianlujiage->add($jiage);
			$xianlujiage = $Glxianlujiage->where("`jiageID` = '$jiageID'")->find();
//			$rurl = '/';
//			doalert('线路错误',$rurl);
		}
		
		$Glyiriyou = D("Glyiriyou");
		$yiriyouAll = $Glyiriyou->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
		$rowspaly = $Glyiriyou->where("`jiageID` = '$xianlujiage[jiageID]'")->count();
		//酒店流程
  		$rh = 0;
  		$ra = 0;
		$Glticketorder = D("Glticketorder");
		$hotel_line_view = D("hotel_line_view");
		$ticket = D("ticket");
		$ticketorderAll = $Glticketorder->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
		foreach($ticketorderAll as $ticketorder)
		{
			if($ticketorder['tickettype'] == '酒店')
			{
//				$postdata['ticketID1'.$rh] = $ticketorder['ticketID'];
//				$postdata['tickettype1'.$rh] = $ticketorder['tickettype'];
				$postdata['ticketorderID1'.$rh] = $ticketorder['ticketorderID'];
				$hotel = $hotel_line_view->where("`id` = '$ticketorder[ticketID]'")->find();
				$postdata['room1'.$rh] = $hotel['room'];
				$postdata['hotelname1'.$rh] = $hotel['hotel_title'];
				$postdata['stayday1'.$rh] = $hotel['stay_day'];
				$rh ++;
			}
			
			if($ticketorder['tickettype'] == '机票')
			{
				$postdata['ticketorderID0'.$ra] = $ticketorder['ticketorderID'];
				$air = $ticket->where("`id` = '$ticketorder[ticketID]'")->find();
				$postdata['ticket_id0'.$ra] = $air['ticket_id'];
				$postdata['fly_company0'.$ra] = $air['fly_company'];
				$postdata['travel_type0'.$ra] = $air['travel_type'];
				$ra ++;
				
				//dump($air);
				
			}
			
		}
		
		//$postdata['rowshotel']  = $rh-1<0 ? 0 : $rh-1;
		$postdata['rowshotel']  = $rh;
		$postdata['rowspaly']  = $ra;
		//代理流程
		$Glshoujia = D("Glshoujia");
		$oldshoujia = $Glshoujia->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
		$i = 0;
		$m = 0;
		$n = 0;
		foreach($oldshoujia as $shoujia)
		{
			if($shoujia['leixing'] == '代理商' && $shoujia['xuanzetype'] == 'Batch' )
			{
					$postdata['shoujiaID1'.$i] = $shoujia['shoujiaID'];
					$postdata['slAgentType1'.$i] = $shoujia['dailileixing'];
					$postdata['slClass1'.$i] = $shoujia['jibie'];
					$postdata['tbAdultPrice1'.$i] = $shoujia['chengrenshoujia'];
					$postdata['tbChildPrice1'.$i] = $shoujia['ertongshoujia'];
					$postdata['tbAdultCommission1'.$i] = $shoujia['chengrenyongjin'];
					$postdata['tbChildCommission1'.$i] = $shoujia['ertongyongjin'];
					$postdata['tbAdultProfit1'.$i] = $shoujia['chengrenlirun'];
					$postdata['tbChildProfit1'.$i] = $shoujia['ertonglirun'];
					$postdata['tbCut1'.$i] = $shoujia['cut'];
					$i++;
			}
			
			if($shoujia['leixing'] == '代理商' && $shoujia['xuanzetype'] == 'MultipleChoice' )
			{
					$postdata['shoujiaID2'.$m] = $shoujia['shoujiaID'];
					$postdata['AgentName2'.$m] = $shoujia['hezuohuoban'];
					$postdata['AgentID2'.$m] = $shoujia['hezuohuobanID'];
					$postdata['tbAdultPrice2'.$m] = $shoujia['chengrenshoujia'];
					$postdata['tbChildPrice2'.$m] = $shoujia['ertongshoujia'];
					$postdata['tbAdultCommission2'.$m] = $shoujia['chengrenyongjin'];
					$postdata['tbChildCommission2'.$m] = $shoujia['ertongyongjin'];
					$postdata['tbAdultProfit2'.$m] = $shoujia['chengrenlirun'];
					$postdata['tbChildProfit2'.$m] = $shoujia['ertonglirun'];
					$postdata['tbCut2'.$i] = $shoujia['cut'];
					$m++;
			}
		}
		
		$postdata['rowsnum1'] = $i-1<0 ? 0 : $i-1;
		$postdata['rowsnum2'] = $m-1<0 ? 0 : $m-1;
		
        $this->assign ( "postdata", $postdata );
        $this->assign ( "yiriyouAll", $yiriyouAll );
        $this->assign ( "xianluID", $xianluID );
        $this->assign ( "jiageID", $xianlujiage['jiageID'] );
        $this->display($showpage); 
    }


    public function addyiriyou() {
		$xianluID = $_GET['xianluID'];
		xianluIsAdmin($xianluID,$this);
		$jiageID = $_GET['jiageID'];
        $this->assign ( "jiageID", $jiageID );
        $this->assign ( "xianluID", $xianluID );
        $this->display(); 
    }


    public function dopostaddyiriyou() {
		
		$postdata = $_POST;
		$Glyiriyou = D("Glyiriyou");
		
		$yiriyou = $Glyiriyou->where("`yiriyouID` = '$postdata[yiriyouID]'")->find();
		if($yiriyou)
		{
			$postdata['jiageID'] = $yiriyou['jiageID'];
			
			$Glyiriyou->save($postdata);
			echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
			<html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>$word</title><script type=\"text/javascript\" >opener.location.reload();window.close();</script>
			</head><body></body></html>";		
		}
		else
		{
			$postdata['time'] = time();
			$Glyiriyou->add($postdata);
			echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>$word</title><script type=\"text/javascript\" >alert('添加成功');window.close();</script></head><body></body></html>";
			
		}
		
    }



    public function dopostXianlujiage() {
		
		$postdata = $_POST;
		$xianluID = $_POST['xianluID'];
		$this->assign('xianluID',$xianluID);
		//检测ID
		$Glxianlu = D("Glxianlu");
		$xianludata = $Glxianlu->where("`xianluID` = '$xianluID'")->field('xianluID')->find();
		if(!$xianludata)
		{
			echo "system error 1";
			$rurl = SITE_ADMIN."Ziyouren/sankechanpin";
			doalert('找不到线路产品',$rurl);
		}
		$Glxianlujiage = D("Glxianlujiage");
		$oldjiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();
		if($oldjiage)
		{
			xianluIsAdmin($xianluID,$this);
			$oldjiage['xuanzetype'] = $postdata['ddlAgentType'];
			$ifnewid = $Glxianlujiage->save($oldjiage);
			$xianlujiageID = $oldjiage['jiageID'];
		}
		else
		{
			echo "system error A";
			$this->assign('postdata',$postdata);
			$this->display('Xianlujiage');
			exit;
		}
		
		//机票流程
		$Glticketorder = D("Glticketorder");
		foreach($postdata['aircaozuoID'] as $id)
		{
			  $ticket['ticketID'] = $postdata['ticketID0'.$id];
			  $ticket['tickettype'] = $postdata['tickettype0'.$id];
			  $ticket['jiageID'] = $xianlujiageID;
			  $ticket['xianluID'] = $xianluID;
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
			  $ticket['xianluID'] = $xianluID;
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
					
					$dailishang['chengrenshoujia'] = $postdata['tbAdultPrice1'.$i];//成人销售价
					$dailishang['chengrenyongjin'] = $postdata['tbAdultCommission1'.$i];//成人佣金
					$dailishang['chengrenlirun'] = $postdata['tbAdultProfit1'.$i];
//					$dailishang['ertongshoujia'] = $postdata['tbChildPrice1'.$i];
//					$dailishang['ertongyongjin'] = $postdata['tbChildCommission1'.$i];
//					$dailishang['ertonglirun'] = $postdata['tbChildProfit1'.$i];
					$dailishang['ertongshoujia'] = $dailishang['chengrenshoujia'];
					$dailishang['ertongyongjin'] = $dailishang['chengrenyongjin'];
					$dailishang['ertonglirun'] = $dailishang['chengrenlirun'];
					
					
					$dailishang['cut'] = $postdata['tbCut1'.$i];
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
							
							$dailishang['chengrenshoujia'] = $postdata['tbAdultPrice2'.$i];//成人销售价
							$dailishang['chengrenyongjin'] = $postdata['tbAdultCommission2'.$i];//成人佣金
							$dailishang['chengrenlirun'] = $postdata['tbAdultProfit2'.$i];
//							$dailishang['ertongshoujia'] = $postdata['tbChildPrice2'.$i];
//							$dailishang['ertongyongjin'] = $postdata['tbChildCommission2'.$i];
//							$dailishang['ertonglirun'] = $postdata['tbChildProfit2'.$i];
							$dailishang['ertongshoujia'] = $dailishang['chengrenshoujia'];
							$dailishang['ertongyongjin'] = $dailishang['chengrenyongjin'];
							$dailishang['ertonglirun'] = $dailishang['chengrenlirun'];
							
							$dailishang['cut'] = $postdata['tbCut2'.$i];
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
						$this->display('Xianlujiage');
						exit;
					}
			}
		}
		$rurl = SITE_ADMIN."Ziyouren/xianlujiage/xianluID/".$postdata['xianluID'];
		tiaozhuan($rurl);
			
			
	}
		
    public function deleteshoujiaxiang() {
		
		$xianluID = $_GET['xianluID'];
		xianluIsAdmin($xianluID,$this);
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
		
		$rurl = SITE_ADMIN."Ziyouren/xianlujiage/xianluID/".$xianluID;
		doalert('成功删除',$rurl);
		
		
    }
		

    public function deleteticketorder() {
		
		$xianluID = $_GET['xianluID'];
		xianluIsAdmin($xianluID,$this);
		$ticketorderID = $_GET['ticketorderID'];
		$Glticketorder = D("Glticketorder");
		$Glticketorder->where("`ticketorderID` = '$ticketorderID'")->delete();
		
		$rurl = SITE_ADMIN."Ziyouren/xianlujiage/xianluID/".$xianluID;
		doalert('删除成功',$rurl);
    }



    public function getairlinelist() {
		
		$data = D('Ticket');
		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		
		$count = $data->count();
		$p = new Page ( $count, 10 ); 
		$list=$data->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll(); 

		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Airticket/index/p/');

		$i = 0;
		foreach($list as $xianlu)
		{
			$chutuanriqi = split('[;]',$xianlu['start_date']);
			foreach($chutuanriqi as $riqi)
			{
				if($newdatelist)
				$newdatelist .= ','."'".$riqi."'";
				else
				$newdatelist .= "'".$riqi."'";
			}
			$list[$i]['start_date'] = $newdatelist;
			$newdatelist = '';
			
			$i++;
		}

		
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );

        $this->display('ticketList');
    }

	
    public function deleteziyouren() {
		
			$postdata = $_POST;
			$xianlulist = $postdata['itemlist'];
			
			if(!$xianlulist)
			{
				$rurl = '';
				doalert('没有选择',$rurl);
			}
			
			$Glxianlu = D("Glxianlu");
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			foreach($xianlulist as $xianluID)
			{
				xianluIsAdmin($xianluID,$this);
				$xianludata = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
				//判断状态,锁
				$isstatus = array("准备", "等待审核", "审核不通过");
				if(!in_array($xianludata['zhuangtai'],$isstatus) )
					doalert('该线路在报名或截止状态，不允许删除',$rurl);
				if( $xianludata['islock'] == '已锁定' )
					doalert('该线路已锁定，不允许删除',$rurl);
				
				if($xianludata)
				{
					//异常
					//删除订单和报账单
//					$Glzituan = D("Glzituan");
//					$ztall = $Glzituan->where("`xianluID` = '$xianluID'")->findall();
//					$gldingdan = D("gldingdan");
//					$gl_baozhang = D("gl_baozhang");
//					foreach($ztal as $v)
//					{
//						$gldingdan->where("`zituanID` == '$v[zituanID]'")->delete_My();
//						$gl_baozhang->where("`zituanID` == '$v[zituanID]'")->delete_My();
//					}
					
					//查找价格ID
					$jiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->field('jiageID')->find();
					$jiageID = $jiage['jiageID'];
					//代理商售价删除
					$Glshoujia->where("`jiageID` = '$jiageID'")->delete();
					//价格删除
					$Glxianlujiage->where("`xianluID` = '$xianluID'")->delete();
					//清空子团
					$Glzituan = D("Glzituan");
					//$Glzituan->where("`xianluID` = '$xianluID'")->delete_My();
					$Glzituan->where("`xianluID` = '$xianluID' and `zhuangtai` in ('准备','等待审核','审核不通过')")->delete_My();
					//删除日程
					$Glxingcheng = D("Glxingcheng");
					$Glxingcheng->where("`xianluID` = '$xianluID'")->delete_My();
					//删除附属表
					$glxianlu_ext = D("glxianlu_ext");
					$glxianlu_ext->where("`xianluID` = '$xianluID'")->delete_My();
					//删除附属成本价格显示
					$glchengben = D("glchengben");
					$glchengben->where("`jiageID` = '$jiageID'")->delete_My();
					//删除机票信息,删除酒店信息
					$Glticketorder = D("Glticketorder");
					$Glticketorder->where("`jiageID` = $jiageID")->delete();
					//删除一日游信息
					$Glyiriyou = D("Glyiriyou");
					$Glyiriyou->where("`jiageID` = $jiageID")->delete();
					
					
					
					//线路删除
					$Glxianlu->where("`xianluID` = '$xianluID'")->delete();
					
				}
				
			}
			//dump($postdata);
			$rurl = '';
			doalert('成功删除',$rurl);
    }
	



    public function edityiriyou() {
		
		$yiriyouID = $_GET['yiriyouID'];
		
		$Glyiriyou = D("Glyiriyou");
		$yiriyou = $Glyiriyou->where("`yiriyouID` = '$yiriyouID'")->find();
		
        $this->assign ( "yiriyou", $yiriyou );
        $this->display('addyiriyou'); 
    }



    public function deleteyiriyou() {
		
		$yiriyouID = $_GET['yiriyouID'];
		$Glyiriyou = D("Glyiriyou");
		$yiriyou = $Glyiriyou->where("`yiriyouID` = '$yiriyouID'")->find();
		$jiageID = $yiriyou['jiageID'];
		$Glyiriyou->where("`yiriyouID` = '$yiriyouID'")->delete();
		$Glxianlujiage = D('Glxianlujiage');
		$jiage = $Glxianlujiage->where("`jiageID` = '$jiageID'")->find();
		
		$rurl = SITE_ADMIN."Ziyouren/xianlujiage/xianluID/".$jiage['xianluID'];
		doalert('成功删除',$rurl);
    }








}
?>