<?php

class HotelAction extends CommonAction {

/*    public function _initialize() {
        if (!$this->adminuser) {
            $this->redirect('/Login/index');
        }

    }*/

    public function index() {
		
/*		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}*/
		
		//搜索开始
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			continue;
			
			if($key == 'start_date' || $key == 'end_date'){
			$this->assign($key,$value);
			continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		if ($start_date && $end_date){
			$condition['start_date'] = array('between',array(strtotime($start_date),strtotime($end_date)));
		}
		elseif ($end_date){
			$condition['start_date'] = array('egt',strtotime($start_date));
		}
		elseif ($start_date){
			$condition['start_date'] = array('elt',strtotime($end_date));
		}
		
		//搜索结束

		$data = D('Hotel_line_view');
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		$count = $data->where($condition)->group('hotel_id')->count();
		$p = new Page ( $count, 10 ); 
		$list=$data->limit($p->firstRow.','.$p->listRows)->where($condition)->group('hotel_id')->order('hotel_id desc')->findAll(); 
		foreach($list as $key=>$hotels){
			$condition['hotel_id'] = $hotels['hotel_id'];
			$data_line[$key] = $data->where($condition)->order('id desc')->findAll(); 
			}
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页');
		
//		foreach($_GET as $key => $value){
//		   $p->parameter .= "/$key/" . $val; 
//		} 
//		 
//		$page = $p->show (SITE_ADMIN.'Hotel/index/p/');
		$page = $p->show();
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 酒店';
		$this->assign ( "typeurl", $typeurl );
		
		$this->assign ( "data_line", $data_line );
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display('hotel'); 
    }
	
	public function add(){
	
		//dump($_POST);
/*		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}*/
		
		$type = $_POST['type'];
		
		if ($type == 'add'){
			$hotel_id = $_POST['ddlHotel'];
			$house_id = $_POST['ddlChamber'];
			
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$before_day = $_POST['before_day'];
			$stay_day = $_POST['stay_day'];
			$room_num = $_POST['room_num'];
			$breakfast = $_POST['breakfast'];
			$sell_price = $_POST['sell_price'];
			$price = $_POST['price'];
			$inner_price = $_POST['inner_price'];
			$cut = $_POST['cut'];
			$agent_price = $_POST['agent_price'];
			$free = $_POST['free'];
			$other = $_POST['other'];
			
			$week1 = $_POST['cblWeeks$0'];
			$week2 = $_POST['cblWeeks$1'];
			$week3 = $_POST['cblWeeks$2'];
			$week4 = $_POST['cblWeeks$3'];
			$week5 = $_POST['cblWeeks$4'];
			$week6 = $_POST['cblWeeks$5'];
			$week7 = $_POST['cblWeeks$6'];
			
			
			$hotel = D('Hotel_line');
			
			$hotel->id = $house_id;
			$hotel->hotel_id = $hotel_id;
			$hotel->house_id = $house_id;
	
			$hotel->start_date = strtotime($start_date);
			$hotel->end_date = strtotime($end_date);
			$hotel->before_day = $before_day;
			$hotel->stay_day = $stay_day;
			$hotel->room_num = $room_num;
			$hotel->breakfast = $breakfast;
			$hotel->sell_price = $sell_price;
			$hotel->price = $price;
			$hotel->inner_price = $inner_price;
			$hotel->cut = $cut;
			$hotel->agent_price = $agent_price;
			$hotel->free = $free;
			$hotel->other = $other;
			
			$hotel->week1 = $week1;
			$hotel->week2 = $week2;
			$hotel->week3 = $week3;
			$hotel->week4 = $week4;
			$hotel->week5 = $week5;
			$hotel->week6 = $week6;
			$hotel->week7 = $week7;
			
			//add by gaopeng
			$hotel->user_name = $this->roleuser['user_name'];
			//end
			
			if ($hotel->add()){
				$data = D('Hlcontent');
				
				$start = strtotime('2011-01-02');
				$end = strtotime('2011-01-03');
				$one_day =$end - $start;
				
				$now = strtotime($start_date);
				
				$str = 'w';
				if ($week1) $str .= '1';
				if ($week2) $str .= '2';
				if ($week3) $str .= '3';
				if ($week4) $str .= '4';
				if ($week5) $str .= '5';
				if ($week6) $str .= '6';
				if ($week7) $str .= '0';
				
				
				while ($now <= strtotime($end_date)){
					
					if (strpos($str, date('w',$now)) != false){
						$data->hl_id = $house_id;
						$data->h_id = $hotel_id;
						$data->sum_num = $room_num;
						$data->price = $price;
						$data->agent_price = $agent_price;
						$data->date = $now;
						
						$data->add();
					}
					
					$now += $one_day;
				}
			
			}else{
				$this->assign('url',SITE_ADMIN.'Hotel/');
				$this->assign('title','添加失败，你的房型已经不可用！');
				$this->assign('position','系统跳转');
				$this->display('Common/return');
			}

			$this->redirect('Hotel/edit/id/'.$house_id);
			
		}
		//所在位置
		$typeurl = '产品发布 > 国内 > 酒店';
		$this->assign ( "typeurl", $typeurl );


		$this->display();
	}
	
	public function delete(){
		
		$type = $_POST['type'];
		if ($type == 'hotel_index'){
			$hotel_line = D('Hotel_line');
			$idlist = $_POST['idlist'];
			$condition['house_id'] = array('IN',$idlist);
			$res = $hotel_line->where($condition)->delete(); 
			if ($res){
				$hlcontent = D('Hlcontent');
				$condition['hl_id'] = array('IN',$idlist);
				$hlcontent->where($condition)->delete(); 
				echo "true";
			}
		}
		
	}
	
	public function edit(){
	
		$id = $_REQUEST['id'];
		$type = $_POST['type'];
		
		if(!empty($id)) { 
		
/*			if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
				$position = $_SERVER["PATH_INFO"];
				$this->display('Error/index');
				exit;
			}*/
		
			$datas = D('Hotel_line');
			
			$data = $datas->relation(true)->find($id);
		
			if (!$data){
				$this->assign('url',SITE_ADMIN.'Hotel/');
				$this->assign('title','ID不存在！');
				$this->assign('position','系统跳转');
				$this->display('Common/return');
			}
		
			if ($type == 'save'){
				
				$hotel_id = $_POST['ddlHotel'];
				$house_id = $_POST['ddlChamber'];
				
				$start_date = $_POST['start_date'];
				$end_date = $_POST['end_date'];
				$before_day = $_POST['before_day'];
				$stay_day = $_POST['stay_day'];
				$room_num = $_POST['room_num'];
				$breakfast = $_POST['breakfast'];
				$sell_price = $_POST['sell_price'];
				$price = $_POST['price'];
				$inner_price = $_POST['inner_price'];
				$cut = $_POST['cut'];
				$agent_price = $_POST['agent_price'];
				$free = $_POST['free'];
				$other = $_POST['other'];
				
				$week1 = $_POST['cblWeeks$0'];
				$week2 = $_POST['cblWeeks$1'];
				$week3 = $_POST['cblWeeks$2'];
				$week4 = $_POST['cblWeeks$3'];
				$week5 = $_POST['cblWeeks$4'];
				$week6 = $_POST['cblWeeks$5'];
				$week7 = $_POST['cblWeeks$6'];
			
			
				$datas->hotel_id = $hotel_id;
				$datas->house_id = $house_id;
		
				$datas->start_date = strtotime($start_date);
				$datas->end_date = strtotime($end_date);
				$datas->before_day = $before_day;
				$datas->stay_day = $stay_day;
				$datas->room_num = $room_num;
				$datas->breakfast = $breakfast;
				$datas->sell_price = $sell_price;
				$datas->price = $price;
				$datas->inner_price = $inner_price;
				$datas->cut = $cut;
				$datas->agent_price = $agent_price;
				$datas->free = $free;
				$datas->other = $other;
				
				$datas->week1 = $week1;
				$datas->week2 = $week2;
				$datas->week3 = $week3;
				$datas->week4 = $week4;
				$datas->week5 = $week5;
				$datas->week6 = $week6;
				$datas->week7 = $week7;

				$datas->status = '准备';

				$res = $datas->save();
				

				if ($res){
					
					
					$data = D('Hlcontent');
					
					$dd = M('Hlcontent');
					
					$start = strtotime('2011-01-02');
					$end = strtotime('2011-01-03');
					$one_day =$end - $start;
					
					$now = strtotime($start_date);
					
					$str = 'w';
					if ($week1) $str .= '1';
					if ($week2) $str .= '2';
					if ($week3) $str .= '3';
					if ($week4) $str .= '4';
					if ($week5) $str .= '5';
					if ($week6) $str .= '6';
					if ($week7) $str .= '0';
					

					
					while ($now <= strtotime($end_date)){
						$condition['hl_id'] = $house_id;
						$condition['date'] = $now;
						
						
						
						if (!$data->where($condition)->find()){
							if (strpos($str, date('w',$now)) != false){
								
								
								$dd->hl_id = $house_id;
								$dd->h_id = $hotel_id;
								$dd->sum_num = $room_num;
								$dd->price = $price;
								$dd->agent_price = $agent_price;
								$dd->date = $now;

								$dd->add();

								
							}
						}
						
						$now += $one_day;
					}
				
				}
				
				
				$this->redirect('Hotel/index');
			}
			
			//所在位置
			$typeurl = '产品发布 > 国内 > 酒店';
			$this->assign ( "typeurl", $typeurl );
			
			$this->assign('data',$data);
			$this->display();
		}
		else	{
			$this->assign('url',SITE_ADMIN.'Hotel/');
            $this->assign('title','ID不存在！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
		
	}
	
	public function calendar(){
		
		$house_id = $_GET['house_id'];
		
		$data = D('Hlcontent');
		
		$condition['hl_id']	= $house_id;
		
		
		
		$calendar = $data->where($condition)->order('date asc')->findAll(); 
		
		
		$house = D('House');
		$room = $house->find($house_id);


		//所在位置
		$typeurl = '产品发布 > 国内 > 酒店';
		$this->assign ( "typeurl", $typeurl );

		$this->assign('room',$room);
		$this->assign('house_id',$house_id);
		$this->assign('calendar',$calendar);
		$this->display();
		
	}
	
	public function send(){
	
		$id = $_REQUEST['id'];
		$type = $_GET['type'];
		
		if(!empty($id)) { 
		
			if ($type == 'wait_check'){
				//gaopeng
				hotelIsAdmin($id,$this,SITE_ADMIN."Hotel/index");
				//end
				$hotel_line = D('Hotel_line');
				$hotel_line->find($id);
				$hotel_line->status = '等待审核';
				
				$res = $hotel_line->save();

				$this->redirect('Hotel/index');
			}
			
			elseif($type == 'success'){
				$hotel_line = D('Hotel_line');
				$hotel_line->find($id);
				$hotel_line->status = '报名';
				
				$res = $hotel_line->save();

				$this->redirect('Hotel/check');
			}
			
			elseif($type == 'fail'){
				$hotel_line = D('Hotel_line');
				$hotel_line->find($id);
				$hotel_line->status = '审核不通过';
				
				$res = $hotel_line->save();

				$this->redirect('Hotel/check');
			}else{
			}
		}
		else	{
			$this->assign('url',SITE_ADMIN.'Hotel/');
            $this->assign('title','ID不存在！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
		
	}
	
	public function check(){
/*	
		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}*/
	
	
		//搜索开始
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			continue;
			
			if($key == 'start_date' || $key == 'end_date'){
			$this->assign($key,$value);
			continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		if ($start_date && $end_date){
			$condition['start_date'] = array('between',array(strtotime($start_date),strtotime($end_date)));
		}
		elseif ($end_date){
			$condition['start_date'] = array('egt',strtotime($start_date));
		}
		elseif ($start_date){
			$condition['start_date'] = array('elt',strtotime($end_date));
		}
		
		//搜索结束
	
	
		$id = $_GET['id'];
		if(!empty($id)) { 
		
			$datas = D('Hotel_line');
			$data = $datas->relation(true)->find($id);
			
			//所在位置
			$typeurl = '产品发布 > 国内 > 酒店';
			$this->assign ( "typeurl", $typeurl );
			$this->assign('data',$data);
			$messageAll = A('Message')->getxuqiuyingdan($id,'酒店');
			$this->assign('messageAll',$messageAll);
			$this->display('show');
		
		}
		else{
			
			$data = D('Hotel_line_view');
			import("@.ORG.Page");
			C('PAGE_NUMBERS',10);
			$condition['status'] = '等待审核';
			$count = $data->where($condition)->group('hotel_id')->count();
			$p = new Page ( $count, 10 ); 
			$list=$data->limit($p->firstRow.','.$p->listRows)->where($condition)->group('hotel_id')->order('hotel_id desc')->findAll(); 
			foreach($list as $key=>$hotels){
				$condition['hotel_id'] = $hotels['hotel_id'];
				$data_line[$key] = $data->where($condition)->order('id desc')->findAll(); 
			}
			$p->setConfig('header','篇记录');
			$p->setConfig('prev',"上一页");
			$p->setConfig('next','下一页');
			$p->setConfig('first','首页');
			$p->setConfig('last','末页'); 
			
//			foreach ( $_GET as $key => $val ) {   
//			   $p->parameter .= "/$key/" . $val; 
//			} 
//			
//			$page = $p->show (SITE_ADMIN.'Hotel/check/p/');
			$page = $p->show();
			//所在位置
			$typeurl = '产品发布 > 国内 > 酒店';
			$this->assign ( "typeurl", $typeurl );
	
			$this->assign ( "data_line", $data_line );
			$this->assign ( "page", $page );
			$this->assign ( "list", $list );
			$this->display(); 
		}
		
	}
	
	public function mange(){
/*	
		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}*/
		
		//搜索开始
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			continue;
			
			if($key == 'start_date' || $key == 'end_date'){
			$this->assign($key,$value);
			continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		if ($start_date && $end_date){
			$condition['start_date'] = array('between',array(strtotime($start_date),strtotime($end_date)));
		}
		elseif ($end_date){
			$condition['start_date'] = array('egt',strtotime($start_date));
		}
		elseif ($start_date){
			$condition['start_date'] = array('elt',strtotime($end_date));
		}
		//搜索结束

	
		$id = $_GET['id'];
		
		if(!empty($id)) { 
			
			if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
				$position = $_SERVER["PATH_INFO"];
				$this->display('Error/index');
				exit;
			}
			
			$house_id = $id;
			$data = D('Hlcontent');
			$condition['hl_id']	= $house_id;
			$calendar = $data->where($condition)->order('date asc')->findAll(); 
			$house = D('House');
			$room = $house->find($house_id);
	
			//所在位置
			$typeurl = '产品发布 > 国内 > 酒店';
			$this->assign ( "typeurl", $typeurl );
	
			$this->assign('room',$room);
			$this->assign('house_id',$house_id);
			$this->assign('calendar',$calendar);
			$this->display('m_calendar');
		
		}
		else{
			
			$data = D('Hotel_line_view');
			import("@.ORG.Page");
			C('PAGE_NUMBERS',10);
			$condition['status'] = array('IN','报名,截止');
			$count = $data->where($condition)->group('hotel_id')->count();
			$p = new Page ( $count, 10 ); 
			$list=$data->limit($p->firstRow.','.$p->listRows)->where($condition)->group('hotel_id')->order('hotel_id desc')->findAll(); 
			foreach($list as $key=>$hotels){
				$condition['hotel_id'] = $hotels['hotel_id'];
				$data_line[$key] = $data->where($condition)->order('id desc')->findAll(); 
				}
			$p->setConfig('header','篇记录');
			$p->setConfig('prev',"上一页");
			$p->setConfig('next','下一页');
			$p->setConfig('first','首页');
			$p->setConfig('last','末页'); 
			
//			foreach ( $_REQUEST as $key => $val ) {   
//			   $p->parameter .= "/$key/" . $val; 
//			} 
//			
//			$page = $p->show (SITE_ADMIN.'Hotel/mange/p/');
			$page = $p->show();
			
			//所在位置
			$typeurl = '产品发布 > 国内 > 酒店';
			$this->assign ( "typeurl", $typeurl );
			
			$this->assign ( "data_line", $data_line );
			$this->assign ( "page", $page );
			$this->assign ( "list", $list );
			$this->display(); 
		}
		
	}
	
	public function modify(){
		$id = $_REQUEST['id'];
		
		$type = $_POST['type'];
		
		$val = $_POST['val'];
		
		if(!empty($id)) { 
		
			if ($type == 'sum'){
				$hotel_line = D('Hlcontent');
				$hotel_line->find($id);
				$hotel_line->sum_num = $val;
				
				$res = $hotel_line->save();
				
				echo "success!";
			}
			elseif($type == 'ap'){
				$hotel_line = D('Hlcontent');
				$hotel_line->find($id);
				$hotel_line->agent_price = $val;
				
				$res = $hotel_line->save();
				
				echo "success!";
			}
			elseif($type == 'price'){
				$hotel_line = D('Hlcontent');
				$hotel_line->find($id);
				$hotel_line->price = $val;
				
				$res = $hotel_line->save();
				
				echo "success!";
			}
			else{
			}
		}
		else	{
			echo "error!";
		}
	}
	
	
	public function house() {
	
		$house = D('Hlcontent');
		
		$house_id = $_REQUEST['house_id'];
		$type = $_POST['type'];
		
		if (!empty($type)){
			if ($type == 'down'){
				$house_arr = $_POST['house'];
				$condition['id'] = array('IN',implode(',',$house_arr));
				$house->where($condition)->delete(); 
				$this->redirect('Hotel/house/house_id/' .$house_id);
			}
		}
		elseif(!empty($house_id)) {
			
			import("@.ORG.Page");
			C('PAGE_NUMBERS',10);
			$condition['hl_id'] = $house_id;
			$count = $house->where($condition)->count();
			$p = new Page ( $count, 10 ); 
			$list=$house->relation(true)->where($condition)->limit($p->firstRow.','.$p->listRows)->order('date asc')->findAll(); 
			$p->setConfig('header','篇记录');
			$p->setConfig('prev',"上一页");
			$p->setConfig('next','下一页');
			$p->setConfig('first','首页');
			$p->setConfig('last','末页'); 
			$page = $p->show (SITE_ADMIN.'Hotel/house/house_id/' . $house_id . '/p/');
	
			//所在位置
			$typeurl = '产品发布 > 国内 > 酒店';
			$this->assign ( "typeurl", $typeurl );
	
			$this->assign ( "house_id", $house_id );
			$this->assign ( "page", $page );
			$this->assign ( "list", $list );
			$this->display(); 
		}
		else{
			$this->assign('url',SITE_ADMIN.'Hotel/mange');
            $this->assign('title','错误来源！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
    }
	
	
	public function dingdan() {

		//搜索开始
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			continue;
			
			if($key == 'start_date'){
				$condition[$key] = array('like','%'.strtotime($value).'%');
				$this->assign($key,$value);
				continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		//搜索结束
		
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 酒店';
		$this->assign ( "typeurl", $typeurl );

		$dingdan = D("Signup");
		$dingdans = $dingdan->where($condition)->order('pubdate desc')->findall();
		
        $this->assign('dingdans',$dingdans);
        $this->display();
    }
	
	public function dingdan_info() {
		
		$bid = $_GET['bid'];
		$member = D('Member');
		$c1['sid'] = $bid;
		$members = $member->where($c1)->findAll();

		$dingdan = D('Signup');
		$c2['bid'] = $bid;
		$dingdans = $dingdan->where($c2)->find();
		
		//gaopeng
		$Gltuanyuan = D("tuanyuan_dingdan");
		$tuanyuanAll = $Gltuanyuan->where("`usertype` = '订房' and `sid` = '$bid'")->findall();
		$this->assign('tuanyuanAll',$tuanyuanAll);
		//end
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 酒店';
		$this->assign ( "typeurl", $typeurl );

		
		$this->assign('username',$this->roleuser['user_name']);
		$this->assign('bid',$bid);
		$this->assign('members',$members);
		$this->assign('dingdans',$dingdans);
        $this->display();
    }
	
	public function chang_info() {

		$bid = $_GET['bid'];
		$type = $_GET['type'];
		
		if (!empty($bid)){
			if (!empty($type)){
				$sign = D('Signup');
				$condition['bid'] = $bid;
				$sign->where($condition)->find();
				
				if ($type == 'lock')	$sign->islock = '锁定';
				if ($type == 'unlock')	$sign->islock = '未锁定';
				if ($type == 'pay')	$sign->money = '已付款';
				if ($type == 'notpay')	$sign->money = '未付款';
				if ($type == 'paycw')	$sign->moneycw = '已付款';
				if ($type == 'notpaycw')	$sign->moneycw = '未付款';
				
				$sign->save();
				
				
				if ($type == 'lock')	A("Message")->savemessage($bid,'订单','操作记录','锁定订单');
				if ($type == 'unlock')	A("Message")->savemessage($bid,'订单','操作记录','解锁订单');
				if ($type == 'pay')	A("Message")->savemessage($bid,'订单','操作记录','订单付款');
				if ($type == 'notpay')	A("Message")->savemessage($bid,'订单','操作记录','取消付款');
				if ($type == 'paycw')	A("Message")->savemessage($bid,'订单','操作记录','财务订单付款');
				if ($type == 'notpaycw')	A("Message")->savemessage($bid,'订单','操作记录','财务取消付款');
				
				$this->redirect('Hotel/dingdan_info/bid/'.$bid);
			}
		}
        $this->redirect('Hotel/dingdan');
    }
	
	public function answer() {

		$type = $_POST['type'];
		
		if ($type == 'show'){
			$answers = D("Answers");
			
			$condition['pid'] = $_POST['pid'];
			
			$answer = $answers->where($condition)->order('pubdate asc')->findall();
			
			$this->assign('answer',$answer);
			$this->display();
		}elseif($type == 'insert'){
			$username = $_POST['username'];
			$content = $_POST['content'];
			$pid = $_POST['pid'];
			
			$answers = D("Answers");
			
			$answers->username = $username;
			$answers->content = $content;
			$answers->pubdate = strtotime("now");
			$answers->pid = $pid;
			
			$answers->add();

			$answer[0]['username'] = $username;
			$answer[0]['content'] = $content;
			$answer[0]['pubdate'] = strtotime("now");
			
			
			//所在位置
			$typeurl = '产品发布 > 国内 > 酒店';
			$this->assign ( "typeurl", $typeurl );
			
			$this->assign('answer',$answer);
			$this->display();
		}
    }
	
	
	
    public function canceltuanyuan() {
 			$postdata = $_POST;
			$itemlist = $postdata['itemlist'];
			if(!$itemlist)
			{
				if($postdata['forward'])
				$forward = $postdata['forward'];
				else
				$forward = '';
				doalert('没有选择',$forward);
			}
			$Gltuanyuan = D("gltuanyuan");
			foreach($itemlist as $tuanyuanID){
				$Gltuanyuan->where("`tuanyuanID` = '$tuanyuanID'")->delete();
			}
			doalert('取消成功',$forward);
			
			
	}
	
	
	
    public function dochangestatus() {
 			$postdata = $_POST;
			$itemlist = $postdata['itemlist'];
			if(!$itemlist)
			{
				if($postdata['forward'])
				$forward = $postdata['forward'];
				else
				$forward = '';
				doalert('没有选择',$forward);
			}
			if(!$_GET)
				doalert('错误',$forward);
			$Gltuanyuan = D("gltuanyuan");
			foreach($itemlist as $tuanyuanID){
				$tuanyuan['tuanyuanID'] = $tuanyuanID;
				$tuanyuan['zhuangtai'] = $_GET['type'];
				$Gltuanyuan->save($tuanyuan);
			}
			doalert('修改成功',$forward);
			
			
	}
	
	
	
    public function dodaokuancheck() {
 			$postdata = $_POST;
			$itemlist = $postdata['itemlist'];
			if(!$itemlist)
			{
				if($postdata['forward'])
				$forward = $postdata['forward'];
				else
				$forward = '';
				doalert('没有选择',$forward);
			}
			if(!$_GET)
				doalert('错误',$forward);
			$Gltuanyuan = D("gltuanyuan");
			foreach($itemlist as $tuanyuanID){
				$tuanyuan['tuanyuanID'] = $tuanyuanID;
				$tuanyuan['daokuan'] = $_GET['type'];
				$Gltuanyuan->save($tuanyuan);
			}
			doalert('修改成功',$forward);
			
			
	}
	
	
	
	
	
	
	
	
	
	
	
}
?>