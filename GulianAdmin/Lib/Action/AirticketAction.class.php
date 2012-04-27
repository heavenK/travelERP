<?php
class AirticketAction extends CommonAction{

/*    public function _initialize() {
        if (!$this->adminuser) {
            $this->redirect('/Login/index');
        }
	
    }*/
	
	
	//机票列表
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
			
			if ($key == 'from_city' || $key == 'to_city'){
				
				$city = D('Liandong');
				$conditions['position'] = $value;
				$conditions['id'] = array('gt',100000);
				$f_city = $city->where($conditions)->find();
				$condition[$key] = $f_city['id'];
				$this->assign($key,$value);
				continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		//搜索结束
		
		$data = D('Ticket');
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		$count = $data->where($condition)->count();
		$p = new Page ( $count, 10 ); 
		$list=$data->limit($p->firstRow.','.$p->listRows)->relation(true)->where($condition)->order('id desc')->findAll(); 

		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		
//		foreach($_GET as $key => $value){
//		   $p->parameter .= "/$key/" . $val; 
//		} 
//		$page = $p->show (SITE_ADMIN.'Airticket/index/p/');
		$page = $p->show();
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


		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign ( "typeurl", $typeurl );
		
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );

        $this->display('ticketList');
    }

	
	
	
	public function ticketPublish(){
		
/*		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}*/
		
		if($_POST){
			
			$datas = $_POST;
			
			$air_ticket = D("ticket");	
			
			$datas['go_takeoff_time'] = strtotime($datas['go_takeoff_time']);
			$datas['go_land_time'] = strtotime($datas['go_land_time']);
			
			if ($datas['back_takeoff_time']) $datas['back_takeoff_time'] = strtotime($datas['back_takeoff_time']);
			
			if ($datas['back_land_time'])	$datas['back_land_time'] = strtotime($datas['back_land_time']);
			
			
			$air_ticket->title = $datas['title'];
			$air_ticket->free = $datas['free'];
			$air_ticket->ticket_id = $datas['ticket_id'];
			$air_ticket->ticket_type = $datas['ticket_type'];
			$air_ticket->travel_type = $datas['travel_type'];
			$air_ticket->days = $datas['days'];
			$air_ticket->ticket_num = $datas['ticket_num'];
			$air_ticket->start_date = $datas['start_date'];
			$air_ticket->before_day = $datas['before_day'];
			$air_ticket->fly_company = $datas['fly_company'];
			$air_ticket->go_takeoff_time = $datas['go_takeoff_time'];
			$air_ticket->go_land_time = $datas['go_land_time'];
			$air_ticket->back_takeoff_time = $datas['back_takeoff_time'];
			$air_ticket->back_land_time = $datas['back_land_time'];
			$air_ticket->fly_id = $datas['fly_id'];
			$air_ticket->fly_area = $datas['fly_area'];
			$air_ticket->takeoff_airport = $datas['takeoff_airport'];
			$air_ticket->land_airport = $datas['land_airport'];
			$air_ticket->from_city = $datas['from_city'];
			$air_ticket->to_city = $datas['to_city'];
			$air_ticket->other = $datas['other'];
			
			//add by gaopeng
			$air_ticket->user_name = $this->roleuser['user_name'];
			//end
			
			$res = $air_ticket->add();	//发布机票
			
			
			if ($res){
				
				A("Message")->savemessage($res,'机票产品','操作记录','添加机票基本信息');
				
				//生成机票子团
				$dates = D("ticket_date");
				
				//计算一天的时间当量
				$start = strtotime('2011-01-02');
				$end = strtotime('2011-01-03');
				$one_day =$end - $start;
				
				$date_arr = explode(';',$datas['start_date']);
				
				foreach($date_arr as $val){
					$ticket_date['ticket_id'] = $datas['ticket_id']."-".date('md',strtotime($val));
					$ticket_date['sum_num'] = $datas['ticket_num'];
					$ticket_date['start_date'] = strtotime($val);
					$ticket_date['end_date'] = strtotime($val) - ($datas['before_day']*$one_day);
					$ticket_date['pid'] = $res;
					
					$dates->add($ticket_date);
				}
				
				$price = D('Ticket_price');
				
				$price->pid = $res;
				$price->add();
				
			}

			$this->redirect('Airticket/ticketDate/pid/'.$res);
		}
		
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign ( "typeurl", $typeurl );
		
		//添加机票界面（保存，或者待审核）
		$this->assign('airlines',$this->_getAirlineCor());		//航空公司数据
	
		$this->display();		
	}
	
	
	public function ticketEdit(){
		
/*		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}*/
		
		if($_POST){
			
			$datas = $_POST;
			
			$air_ticket = D("Ticket");	
			
			$datas['go_takeoff_time'] = strtotime($datas['go_takeoff_time']);
			$datas['go_land_time'] = strtotime($datas['go_land_time']);
			
			if ($datas['back_takeoff_time']) $datas['back_takeoff_time'] = strtotime($datas['back_takeoff_time']);
			if ($datas['back_land_time'])	$datas['back_land_time'] = strtotime($datas['back_land_time']);
		//gaopeng
		airticketIsAdmin($datas['id'],$this);
		//end
			$air_ticket->find($datas['id']);
			
			$air_ticket->title = $datas['title'];
			$air_ticket->free = $datas['free'];
			$air_ticket->ticket_id = $datas['ticket_id'];
			$air_ticket->ticket_type = $datas['ticket_type'];
			$air_ticket->travel_type = $datas['travel_type'];
			$air_ticket->days = $datas['days'];
			$air_ticket->ticket_num = $datas['ticket_num'];
			$air_ticket->start_date = $datas['start_date'];
			$air_ticket->before_day = $datas['before_day'];
			$air_ticket->fly_company = $datas['fly_company'];
			$air_ticket->go_takeoff_time = $datas['go_takeoff_time'];
			$air_ticket->go_land_time = $datas['go_land_time'];
			$air_ticket->back_takeoff_time = $datas['back_takeoff_time'];
			$air_ticket->back_land_time = $datas['back_land_time'];
			$air_ticket->fly_id = $datas['fly_id'];
			$air_ticket->fly_area = $datas['fly_area'];
			$air_ticket->takeoff_airport = $datas['takeoff_airport'];
			$air_ticket->land_airport = $datas['land_airport'];
			$air_ticket->from_city = $datas['from_city'];
			$air_ticket->to_city = $datas['to_city'];
			$air_ticket->other = $datas['other'];
			
			$air_ticket->status = '准备';
			
			
			$res = $air_ticket->save();	//修改机票
			
			if ($res){
				
				A("Message")->savemessage($datas['id'],'机票产品','操作记录','修改机票基本信息');
				//生成机票子团
				$dd = D("ticket_date");
				$dates = M("ticket_date");
				
				//计算一天的时间当量
				$start = strtotime('2011-01-02');
				$end = strtotime('2011-01-03');
				$one_day =$end - $start;
				
				$date_arr = explode(';',$datas['start_date']);
				
				foreach($date_arr as $val){
					
					
					
					$ticket_date['ticket_id'] = $datas['ticket_id']."-".date('md',strtotime($val));
					$ticket_date['sum_num'] = $datas['ticket_num'];
					$ticket_date['start_date'] = strtotime($val);
					$ticket_date['end_date'] = strtotime($val) - ($datas['before_day']*$one_day);
					$ticket_date['pid'] = $datas['id'];

					if(!$dd->find($ticket_date['ticket_id'])){
						$dates->add($ticket_date);
					}
				}
				
			}

			$this->redirect('Airticket/ticketDate/pid/'.$datas['id']);
		}
		
		$id = $_GET['id'];
		$dd = D("ticket");	
		
		$ticket = $dd->find($id);
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign ( "typeurl", $typeurl );
		
		
		//添加机票界面（保存，或者待审核）
		$this->assign('airlines',$this->_getAirlineCor());		//航空公司数据
		$this->assign('ticket',$ticket);
		$this->display();		
	}
	
	
	public function ticketDate(){

		$pid = $_GET['pid'];
		if ($pid){
			$ticket_date = D('Ticket_date');
			
			$conditions['pid'] = $pid;
			
			$datas = $ticket_date->relation(true)->where($conditions)->order('start_date asc')->findAll();
			
			//所在位置
			$typeurl = '产品发布 > 国内 > 机票';
			$this->assign ( "typeurl", $typeurl );
			
			$this->assign('pid',$pid);
			$this->assign('datas',$datas);	
			$this->display();
		}
				
	}
	
	public function ticketPrice(){

		$pid = $_REQUEST['pid'];
		$type = $_POST['type'];
		//gaopeng
		//airticketIsAdmin($pid,$this);
		//end
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign ( "typeurl", $typeurl );
		
		if ($pid){
			
			if (!empty($type)){
				
				$price = D("Ticket_price");
				
				$ticket_price['id'] = $_POST['id'];
				$ticket_price['cost_price'] = $_POST['tbCostPrice'];
				$ticket_price['all_price'] = $_POST['tbAllPrice'];
				$ticket_price['out_price'] = $_POST['tbTicketPrice'];
				$ticket_price['cut_price'] = $_POST['tbDiscount'];
				$ticket_price['inner_price'] = $_POST['tbInnerPrice'];
				$ticket_price['inner_lirun'] = $_POST['tbInnerProfit'];
				$ticket_price['agent_type'] = $_POST['ddlAgentType'];
				
				$conditions['pid'] = $pid;
				
				
				
				if ($price->where($conditions)->find())	{
					$res = $price->save($ticket_price);
				}else{
					$res = $price->add($ticket_price);
				}
				
				$agent = D("Ticket_agent");
				$wheres['pid'] = $pid;
				$wheres['type'] = $ticket_price['agent_type'];
				$ticket_agent_price = $agent->where($wheres)->order('id asc')->find();
				
				
/*				$ticket_date = D("Ticket_date");
				$maps['pid'] = $pid;
				$maps['price'] = '0';
				$ticket_date->where($maps)->price = $ticket_agent_price['price']?$ticket_agent_price['price']:$ticket_price['cost_price'];
				$rr = $ticket_date->save();*/

				A("Message")->savemessage($pid,'机票产品','操作记录','修改机票价格');


				$rurl = SITE_ADMIN."Airticket/ticketPrice/pid/$pid";
				doalert('保存成功！',$rurl);
			}
			else{
				$price = D("Ticket_price");
				
				$conditions['pid'] = $pid;
				
				$ticket_price = $price->where($conditions)->find();
				
				$agent = D("Ticket_agent");
				
				$conditions['type'] = 'Batch';
				
				$ticket_agent = $agent->where($conditions)->order('id asc')->findAll();
				$rowsnum1 = $agent->where($conditions)->count();
				
				$conditions['type'] = 'MultipleChoice';
				
				$ticket_agent2 = $agent->where($conditions)->order('id asc')->findAll();
				$rowsnum2 = $agent->where($conditions)->count();
				
				
				
				if ($ticket_price){
					$this->assign('rowsnum1',$rowsnum1);
					$this->assign('rowsnum2',$rowsnum2);
					
					$this->assign('ticket_price',$ticket_price);
					$this->assign('ticket_agent',$ticket_agent);
					$this->assign('ticket_agent2',$ticket_agent2);
					$this->assign('pid',$pid);
					$this->display();
				}else{
					$rurl = SITE_ADMIN."Airticket/";
					doalert('对应价格不存在！',$rurl);
				}
			}
		}
				
	}
	
	public function ticketPriceShow(){

		$pid = $_REQUEST['pid'];
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign ( "typeurl", $typeurl );
		
		if ($pid){

			  $price = D("Ticket_price");
			  
			  $conditions['pid'] = $pid;
			  
			  $ticket_price = $price->where($conditions)->find();
			  
			  $agent = D("Ticket_agent");
			  
			  $conditions['type'] = 'Batch';
			  
			  $ticket_agent = $agent->where($conditions)->order('id asc')->findAll();
			  
			  $conditions['type'] = 'MultipleChoice';
			  
			  $ticket_agent2 = $agent->where($conditions)->order('id asc')->findAll();
			  
			  if ($ticket_price){
				  $this->assign('ticket_price',$ticket_price);
				  $this->assign('ticket_agent',$ticket_agent);
				  $this->assign('ticket_agent2',$ticket_agent2);
				  $this->assign('pid',$pid);
				  $this->display();
			  }else{
				  $rurl = SITE_ADMIN."Airticket/";
				  doalert('对应价格不存在！',$rurl);
			  }
		}
				
	}
	
	public function ticketPriceControlShow(){

		$pid = $_REQUEST['pid'];
		$id = $_REQUEST['id'];
		
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);
		
		if ($pid){

			  $price = D("Ticket_price");
			  
			  $conditions['pid'] = $pid;
			  
			  $ticket_price = $price->where($conditions)->find();
			  
			  $agent = D("Ticket_agent");
			  
			  $conditions['type'] = 'Batch';
			  
			  $ticket_agent = $agent->where($conditions)->order('id asc')->findAll();
			  
			  $conditions['type'] = 'MultipleChoice';
			  
			  $ticket_agent2 = $agent->where($conditions)->order('id asc')->findAll();
			  
			  if ($ticket_price){
				  $this->assign('ticket_price',$ticket_price);
				  $this->assign('ticket_agent',$ticket_agent);
				  $this->assign('ticket_agent2',$ticket_agent2);
				  $this->assign('pid',$pid);
				  $this->assign('id',$id);
				  $this->display();
			  }else{
				  $rurl = SITE_ADMIN."Airticket/";
				  doalert('对应价格不存在！',$rurl);
			  }
		}
				
	}
	
	public function agent_price(){

		$pid = $_REQUEST['pid'];
		$post_type = $_POST['post_type'];
		//gaopeng
		//airticketIsAdmin($pid,$this);
		//end

		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);

		if ($post_type == 'add'){
			
			if ($pid){
				$price = D("Ticket_agent");
				
				$ticket_price['type'] = $_POST['type'];
				$ticket_price['agent_type'] = $_POST['agent_type'];
				$ticket_price['level'] = $_POST['level']?$_POST['level']:'';
				$ticket_price['price'] = $_POST['price'];
				$ticket_price['yongjin'] = $_POST['yongjin'];
				$ticket_price['lirun'] = $_POST['lirun'];
				$ticket_price['pid'] = $pid;
	
				$res = $price->add($ticket_price);
				
				if ($res) echo $res;
			}
			
		}
		elseif ($post_type == 'save'){
			
			$price = D("Ticket_agent");
			
			$ticket_price['type'] = $_POST['type'];
			$ticket_price['agent_type'] = $_POST['agent_type'];
			$ticket_price['level'] = $_POST['level']?$_POST['level']:'';
			$ticket_price['price'] = $_POST['price'];
			$ticket_price['yongjin'] = $_POST['yongjin'];
			$ticket_price['lirun'] = $_POST['lirun'];
			$ticket_price['id'] = $_POST['id'];

			$res = $price->save($ticket_price);

			if ($res) echo $res;
		}
		elseif ($post_type == 'del'){
			
			$price = D("Ticket_agent");
			
			$id = $_POST['id'];

			$res = $price->where('id='.$id)->delete();

			if ($res) echo $res;
		}
		else{

		}
				
	}
	
	public function ticketDateShow(){

		$pid = $_GET['pid'];
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);
		
		if ($pid){
			$ticket_date = D('Ticket_date');
			
			$conditions['pid'] = $pid;
			
			$datas = $ticket_date->relation(true)->where($conditions)->order('start_date asc')->findAll();
			
			$this->assign('pid',$pid);
			$this->assign('datas',$datas);	
			$this->display();
		}
				
	}
	
	
	public function send(){
	
		$id = $_REQUEST['id'];
		$type = $_GET['type'];
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);
		
		if(!empty($id)) { 
		
			if ($type == 'wait_check'){
				
				//gaopeng
				airticketIsAdmin($id,$this);
				//end
				$ticket = D('Ticket');
				$ticket->find($id);
				$ticket->status = '等待审核';
				
				$res = $ticket->save();
				
				$ticket_date = D('Ticket_date');
				
				$conditions['pid'] = $id;
				$td = $ticket_date->where($conditions)->findAll();
				foreach($td as $val){
					$val['status'] = '等待审核';
				
				 	$ticket_date->save($val);
				}
				
				A("Message")->savemessage($id,'机票产品','操作记录','提交审核');
				
				$this->redirect('Airticket/index');
			}
			
			elseif($type == 'success'){
				$ticket = D('Ticket');
				$ticket->find($id);
				$ticket->status = '报名';
				
				$res = $ticket->save();
				
				$ticket_date = D('Ticket_date');
				
				$conditions['pid'] = $id;
				$td = $ticket_date->where($conditions)->findAll();
				foreach($td as $val){
					$val['status'] = '报名';
				
				 	$ticket_date->save($val);
				}
	
				A("Message")->savemessage($id,'机票产品','操作记录','审核通过');
	
				$this->redirect('Airticket/ticketCheck');
			}
			
			elseif($type == 'fail'){
				$ticket = D('Ticket');
				$ticket->find($id);
				$ticket->status = '审核不通过';
				
				$res = $ticket->save();
				
				$ticket_date = D('Ticket_date');
				
				$conditions['pid'] = $id;
				$td = $ticket_date->where($conditions)->findAll();
				foreach($td as $val){
					$val['status'] = '审核不通过';
				
				 	$ticket_date->save($val);
				}
				
				A("Message")->savemessage($id,'机票产品','操作记录','审核失败');
				
				$this->redirect('Airticket/ticketCheck');
			}else{
			}
		}
		else	{
			$this->assign('url',SITE_ADMIN.'Airticket/');
            $this->assign('title','ID不存在！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
		
	}
	
	
	public function ticketCheck(){
		
/*		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}*/
		
		$id = $_GET['id'];

		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);
		
		if (!$id){
			
			$type = $_POST['type'];
		
			$wheres = '';
			if (!empty($type)){
				$from_city = $_POST['from_city'];
				if ($from_city){
					
					$city = D('Liandong');
					
					$conditions['position'] = $from_city;
					$conditions['id'] = array('gt',100000);
					
					$f_city = $city->where($conditions)->find();
					
					$wheres['from_city'] = $f_city['id']; 	
				}
				
				$to_city = $_POST['to_city'];
				if ($to_city){
					
					$city = D('Liandong');
					
					$conditions['position'] = $to_city;
					$conditions['id'] = array('gt',100000);
					
					$t_city = $city->where($conditions)->find();
					
					$wheres['to_city'] = $t_city['id']; 	
				}
				
				$keyword = $_POST['keyword'];
				if ($keyword){
					$wheres['title'] = array('like','%'.$keyword.'%'); 	
				}
				
				$fly_company = $_POST['fly_company'];
				if ($fly_company){
					$wheres['fly_company'] = $fly_company; 	
				}
				
				$start_date = $_POST['start_date'];
				
				if ($start_date){
					$wheres['start_date'] = array('like','%'.$start_date.'%'); 	
				}
			}
			
			
			$data = D('Ticket');
		
			import("@.ORG.Page");
			C('PAGE_NUMBERS',10);
			
			$wheres['status'] = '等待审核';
			
			$count = $data->where($wheres)->count();
			$p = new Page ( $count, 10 ); 
			$list=$data->limit($p->firstRow.','.$p->listRows)->relation(true)->where($wheres)->order('id desc')->findAll(); 
	
			$p->setConfig('header','篇记录');
			$p->setConfig('prev',"上一页");
			$p->setConfig('next','下一页');
			$p->setConfig('first','首页');
			$p->setConfig('last','末页'); 
			
//			foreach ( $_REQUEST as $key => $val ) {   
//			   $p->parameter .= "/$key/" . $val; 
//			} 
//			
//			$page = $p->show (SITE_ADMIN.'Airticket/ticketCheck/p/');
			$page = $p->show();
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
	
			$this->display();						
		}
		else{
			
			if ($id){
				$dd = D("ticket");	
		
				$ticket = $dd->find($id);
				
				$this->assign('airlines',$this->_getAirlineCor());		//航空公司数据
				$this->assign('ticket',$ticket);
				
				$messageAll = A('Message')->getxuqiuyingdan($id,'机票');
				$this->assign('messageAll',$messageAll);
				
				$this->display('Airticket/ticketShow');		
			}
		}
	}
	
	public function ticketControl(){

/*		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}*/
		
		//所在位置
		$typeurl = '产品控管 > 机票控管 ';
		$this->assign("typeurl",$typeurl);
		//搜索开始
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			continue;
			
			if($key == 'start_date'){
				$condition[$key] = strtotime($value);
				$this->assign($key,$value);
				continue;
			}
			
			if ($key == 'from_city' || $key == 'to_city'){
				
				$city = D('Liandong');
				$conditions['position'] = $value;
				$conditions['id'] = array('gt',100000);
				$f_city = $city->where($conditions)->find();
				$condition[$key] = $f_city['id'];
				$this->assign($key,$value);
				continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		//搜索结束
		$condition['status'] = '报名';

		
		$data = D('Ticket_date_view');
		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		$count = $data->where($condition)->count();
		$p = new Page ( $count, 15 ); 
		$list=$data->limit($p->firstRow.','.$p->listRows)->where($condition)->order('id desc')->findAll(); 
		
		$p->setConfig('header','篇记录');
		$p->setConfig('prev',"上一页");
		$p->setConfig('next','下一页');
		$p->setConfig('first','首页');
		$p->setConfig('last','末页'); 
		
//		foreach ( $_GET as $key => $val ) {   
//		   $p->parameter .= "/$key/" . $val; 
//		} 
//		
//		$page = $p->show (SITE_ADMIN.'Airticket/ticketControl/p/');
		$page = $p->show();
		  
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display();
			
	}
	
	public function ticketControlShow(){
		
/*		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}*/
		$id = $_GET['id'];
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);
		
		if ($id){
			$dd = D("Ticket_date");	
	
			$ticket = $dd->relation(true)->find($id);
			
			$this->assign('airlines',$this->_getAirlineCor());		//航空公司数据
			$this->assign('ticket',$ticket);
			$this->display();		
		}	
	}
	
	
	
	public function delete(){
		
		$type = $_POST['type'];
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);
		
		if ($type == 'ticketDate'){
			
			$pid = $_POST['pid'];
			//gaopeng
			//airticketIsAdmin($pid,$this);
			//end
			$ticket_date = D('Ticket_date');
			
			$ticket_date_arr = $_POST['selected'];
			
			$condition['id'] = array('IN',implode(',',$ticket_date_arr));
			
			$start_dates = $ticket_date->where($condition)->find();
			
			$flag = $ticket_date->where($condition)->delete();
						
			if ($flag){
				
				$ticket_data_own = D('Ticket_date');	
				
				$ticket_datas_own = $ticket_data_own->where('pid='.$pid)->findAll();

				$start_dates = '';
				$count = 1;
				
				$max_num = sizeof($ticket_datas_own);
				foreach($ticket_datas_own as $arrs){
					if ($count == $max_num)	$start_dates .= date('Y-m-d',$arrs['start_date']);
					else $start_dates .= date('Y-m-d',$arrs['start_date']).';';
					
					$count++;
				}
				
				$ticket = D('Ticket');
				
				$ticket->find($pid);
				
				
				$ticket->start_date = $start_dates;
				$ticket->save();
			} 
			
			$this->redirect('Airticket/ticketDate/pid/' .$pid);
				
		}	
		
		if ($type == 'ticketDate_ajax'){
			
			
			$ticket_date = D('Ticket_date');
			
			$idlist = $_POST['idlist'];
			
			$condition['id'] = array('IN',$idlist);

			
			echo $ticket_date->where($condition)->delete(); 
				
		}
		
		if ($type == 'overtime_ajax'){
			
			
			$ticket_date = D('Ticket_date');
			
			$idlist = $_POST['idlist'];
			
			$condition['id'] = array('IN',$idlist);

			
			$ticket_date->where($condition)->status = '截止'; 
			
			
			
			echo $ticket_date->save();
				
		}
		
		if ($type == 'price_ajax'){
			
			
			$ticket_date = D('Ticket_date');
			
			$idlist = $_POST['idlist'];
			$add = $_POST['add'];
			$val = $_POST['val'];
			
			
			$condition['id'] = array('IN',$idlist);
			
			$t = $ticket_date->where($condition)->findAll();
			
			foreach($t as $arr){
				if ($add == 'add') {
					$arr['price'] += $val;
					A("Message")->savemessage($arr['id'],'机票子团','操作记录','批量修改价格增加'.$val."元");
				}
				if ($add == 'cut') {
					$arr['price'] -= $val;
					A("Message")->savemessage($arr['id'],'机票子团','操作记录','批量修改价格减少'.$val."元");
				}
				
				
				
				$res = $ticket_date->save($arr);
			}
			
			echo $res;
				
		}
		
		if ($type == 'num_ajax'){
			
			
			$ticket_date = D('Ticket_date');
			
			$idlist = $_POST['idlist'];
			$val = $_POST['val'];
			
			
			$condition['id'] = array('IN',$idlist);

			
			$ticket_date->where($condition)->sum_num = $val; 
			
			echo $ticket_date->save();
			
			$id_arr = explode(',',$idlist);
			foreach($id_arr as $table_id){
				A("Message")->savemessage($table_id,'机票子团','操作记录','批量修改票数为'.$val."张");
			}
				
		}
		
		if ($type == 'ticket'){
			
			$ticket = D('Ticket');
			
			$ticket_arr = $_POST['selected'];
			
			$condition['id'] = array('IN',implode(',',$ticket_arr));
			
			$ticket->where($condition)->delete(); 
			
			
			
			
			$ticket_date = D('Ticket_date');
			
			$wheres['pid'] = array('IN',implode(',',$ticket_arr));
			
			$ticket_date->where($wheres)->delete(); 
			
			$this->redirect('Airticket/');
				
		}	
	}
	
	public function dingdan() {

		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);
		
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



		$dingdan = D("Ticket_signup");
		$dingdans = $dingdan->relation(true)->where($condition)->order('pubdate desc')->findall();
		
		foreach($dingdans as $val){
			$ticket = D("Ticket");
			$ticket_info[$val['id']] = $ticket->find($val['ticket_date']['pid']);
		}

        $this->assign('dingdans',$dingdans);
		$this->assign('ticket_info',$ticket_info);
        $this->display();
    }
	
	
	
	public function dingdan_info() {
		
		$bid = $_GET['bid'];
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);
		
		$member = D('Member');
		$c1['sid'] = $bid;
		$members = $member->where($c1)->findAll();

		$dingdan = D('Ticket_signup');
		$c2['bid'] = $bid;
		$dingdans = $dingdan->where($c2)->find();

		//gaopeng
		$Gltuanyuan = D("tuanyuan_dingdan");
		$tuanyuanAll = $Gltuanyuan->where("`usertype` = '订票' and `sid` = '$bid'")->findall();
		$this->assign('tuanyuanAll',$tuanyuanAll);
		//end
		
		$this->assign('username',$this->roleuser['user_name']);
		$this->assign('bid',$bid);
		$this->assign('members',$members);
		$this->assign('dingdans',$dingdans);
        $this->display();
    }
	
	public function chang_info() {

		$bid = $_GET['bid'];
		$type = $_GET['type'];
		
		//所在位置
		$typeurl = '产品发布 > 国内 > 机票';
		$this->assign("typeurl",$typeurl);
		
		if (!empty($bid)){
			if (!empty($type)){
				$sign = D('Ticket_signup');
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
				if ($type == 'pay')	A("Message")->savemessage($bid,'订单','操作记录','门市订单付款');
				if ($type == 'notpay')	A("Message")->savemessage($bid,'订单','操作记录','门市取消付款');
				if ($type == 'paycw')	A("Message")->savemessage($bid,'订单','操作记录','财务订单付款');
				if ($type == 'notpaycw')	A("Message")->savemessage($bid,'订单','操作记录','财务取消付款');
				
				$this->redirect('Airticket/dingdan_info/bid/'.$bid);
			}
		}
        $this->redirect('Airticket/dingdan');
    }
	
	
	
	//取得航空公司的数据，用于option提取
	private function _getAirlineCor(){
		$rs = D("flying");
		return $rs->findall();
	}
	
	
}
?>