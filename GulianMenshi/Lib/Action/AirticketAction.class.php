<?php

class AirticketAction extends CommonAction{

/*    public function _initialize() {
        if (!$this->adminuser) {
			redirect('/');
        }
		
		if(!checkByAdminlevel('门市操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}
		
    }*/

    public function index() {
        $this->display();
    }
	
	
    public function search() {
		
		
		$post_data = $_GET;
		
		$wheres = '';
		if (!empty($post_data)){
			$from_city = $post_data['from_city'];
			if ($from_city){
				
				$city = D('Liandong');
				
				$conditions['position'] = $from_city;
				$conditions['id'] = array('gt',100000);
				
				$f_city = $city->where($conditions)->find();
				
				$wheres['from_city'] = $f_city['id']; 	
			}
			
			$to_city = $post_data['to_city'];
			if ($to_city){
				
				$city = D('Liandong');
				
				$conditions['position'] = $to_city;
				$conditions['id'] = array('gt',100000);
				
				$t_city = $city->where($conditions)->find();
				
				$wheres['to_city'] = $t_city['id']; 	
			}
			
			$travel_type = $post_data['travel_type'];
			if ($travel_type){
				$wheres['travel_type'] = $travel_type; 	
			}
			
			$start_date = $post_data['start_date'];
			
			if ($start_date){
				$wheres['start_date'] = array('like','%'.$start_date.'%'); 	
			}
			
			//返程时间暂时无法使用。
			/*
			$end_date = $post_data['end_date'];
			if ($end_date){
				$end_date = strtotime($end_date);
				$start = strtotime('2011-05-13');
				$end = strtotime('2011-05-14');
				$one_day = $start-$end;
				$wheres['start_date'] = array('like','%'.$end_date.'%'); 	
			}
			*/
		}
		
		
		
		$wheres['status'] = '报名';
		
		$data = D('Ticket');
		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		$count = $data->where($wheres)->count();
		$p = new Page ( $count, 10 ); 
		$list=$data->limit($p->firstRow.','.$p->listRows)->relation(true)->where($wheres)->order('id desc')->findAll(); 
		
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_MENSHI.'Airticket/search/p/');

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
		
		$this->assign('marktab','机票');
		
        $this->display();
    }
	
	
	
	
    public function searchdetail() {
		
		$wheres['status'] = '报名';
		$wheres['id'] = $_GET['id'];
		
		$data = D('Ticket');
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		$count = $data->where($wheres)->count();
		$p = new Page ( $count, 10 ); 
		$list=$data->limit($p->firstRow.','.$p->listRows)->relation(true)->where($wheres)->order('id desc')->findAll(); 

        $this->assign ( "list", $list );
		
        $this->display();
    }
	
	
	
	
	
	
	public function ajax() {
		 
		 		
		$pid = $_GET['pid'];
		
		$data = D('Ticket_date');
		
		$condition['pid']	= $pid;
		
		
		
		$calendar = $data->where($condition)->order('start_date asc')->findAll(); 
		
		
		
			//根据不同代理商进行价格处理
			$agents = D("Ticket_agent");
			$price_type = D('Ticket_price')->where("pid=".$pid)->find();
			
			if ($price_type['agent_type'] == 'Batch'){
				
				$price_all = $agents->where("pid=".$pid." AND `type` = 'Batch'")->findAll();
				
				$flag = '0';
				
				foreach($price_all as $price_one){
					if($price_one['agent_type'] == $this->roleuser['kehutype'] && $price_one['level'] == $this->roleuser['jibie']){
						$price = $price_one;
						
						//完全匹配成功
						$flag = '100';
						
						break;
					}
					elseif($price_one['agent_type'] == $this->roleuser['kehutype']){
						$price = $price_one;
						
						//匹配到类型，级别匹配失败
						$flag = '75';
						
						continue;
					}
					elseif($price_one['agent_type'] == '全部' && $flag < 50){
						$price = $price_one;
						
						//匹配到全部类型
						$flag = '50';
						
						continue;
					}
					else{	
					}
				}
				//处理结束
			}else{
				
				$price = $agents->where("pid=".$pid." AND `type` = 'MultipleChoice' AND `agent_type` = '".$this->company['companyname']."'")->find();
				//处理结束	
			}
		
		$this->assign('price',$price);
		$this->assign('pid',$pid);
		$this->assign('calendar',$calendar);
		 
		$this->display();
	}
	
	public function signup() {
		 
		$type = $_POST['type'];

		if (!empty($type)){
			$data = D('Ticket_signup');
			
			$pid = $_POST['id'];
			$department = $_POST['department'];
			$linkphone = $_POST['linkphone'];
			$linkman = $_POST['linkman'];
			$fax = $_POST['fax'];
			$re_num = $_POST['re_num'];
			
			
			$from = $_POST['from'];
			$gooo = $_POST['gooo'];
			$start_date = $_POST['start_date'];
			$ticket_id = $_POST['ticket_id'];
			
			
			
			$other = $_POST['other'];
			$status = $_POST['status'];
			
			$data->bid = 'TDD'.date('Ymd').strtotime("now");
			$data->department = $department;
			$data->linkphone = $linkphone;
			$data->linkman = $linkman;
			$data->fax = $fax;
			$data->re_num = $re_num;
			$data->other = $other;
			$data->status = $status;
			
			
			$data->from = $from;
			$data->gooo = $gooo;
			$data->start_date = $start_date;
			$data->ticket_id = $ticket_id;
			$data->pubdate = strtotime("now");
			$data->pid = $pid;
			$data->user_name = $this->roleuser['user_name'];


			//根据不同代理商进行价格处理
			$idd = D("Ticket_date")->find($pid);
			
			$agents = D("Ticket_agent");
			$price_type = D('Ticket_price')->where("pid=".$idd['pid'])->find();
			
			if ($price_type['agent_type'] == 'Batch'){
				
				$price_all = $agents->where("pid=".$idd['pid']." AND `type` = 'Batch'")->findAll();
				
				$flag = '0';
				
				foreach($price_all as $price_one){
					if($price_one['agent_type'] == $this->roleuser['kehutype'] && $price_one['level'] == $this->roleuser['jibie']){
						$price = $price_one;
						
						//完全匹配成功
						$flag = '100';
						
						break;
					}
					elseif($price_one['agent_type'] == $this->roleuser['kehutype']){
						$price = $price_one;
						
						//匹配到类型，级别匹配失败
						$flag = '75';
						
						continue;
					}
					elseif($price_one['agent_type'] == '全部' && $flag < 50){
						$price = $price_one;
						
						//匹配到全部类型
						$flag = '50';
						
						continue;
					}
					else{	
					}
				}
				//处理结束
			}else{
				
				$price = $agents->where("pid=".$idd['pid']." AND `type` = 'MultipleChoice' AND `agent_type` = '".$this->company['companyname']."'")->find();
				//处理结束	
			}

			$data->price = ($price['price'] + $idd['price'])* $re_num;

			if($data->add()){
				
				$id = $_POST['id'];
				$hl = D('Ticket_date');
				
				$hl->find($id);
				
				if ($status == '占位')	$hl->zhanwei_num += $re_num;
				if ($status == '确认')	$hl->queren_num += $re_num;
				$hl->save();
				
				$this->redirect('Airticket/member/num/'.$re_num.'/sid/'.$data->bid.'/pid/'.$pid);
			}
		}else{
			
			$id = $_GET['id'];
		
			$data = D('Ticket_date');
			
			$calender = $data->find($id);
				
			$ticket = D('Ticket');
			
			$t = $ticket->find($calender['pid']);	
			
			
			$citys = D('Liandong');
			
			$from = $citys->find($t['from_city']);
			$gooo = $citys->find($t['to_city']);


			//gaopeng
			$Gllvxingshe = D('Gllvxingshe');
			$lvxingsheID = $this->roleuser['lvxingsheID'];
			$lvxingshe = $Gllvxingshe->where("`lvxingsheID` = '$lvxingsheID'")->find();
			$this->assign('lvxingshe',$lvxingshe);
			//end


			$this->assign('id',$id);	
			$this->assign('from',$from);
			$this->assign('gooo',$gooo);
			$this->assign('user',$this->roleuser);	
			$this->assign('calender',$calender);

		}




		$this->display();
	}
	
	//gaopeng
	public function dopostmingdan() {
		$num = $_GET['num'];
		$sid = $_GET['sid'];
		$type = $_POST['type'];
		
		if (!empty($type)){
			$vals = $_POST;
			$Gltuanyuan = D('Gltuanyuan');
			for ($i=1; $i<=$vals['num'] ; $i++){
				$name = 'name'.$i;
				$sex = 'sex'.$i;
				$zj = 'zj'.$i;
				$zj_num = 'zj_num'.$i;
				$phone = 'phone'.$i;
				$zhuangtai = 'zhuangtai'.$i;
				$jiaoqian = 'jiaoqian'.$i;
				$demand = 'demand'.$i;
				
				$Gltuanyuan->name = $vals[$name];
				$Gltuanyuan->sex = $vals[$sex];
				$Gltuanyuan->zhengjiantype = $vals[$zj];
				$Gltuanyuan->zhengjianhaoma = $vals[$zj_num];
				$Gltuanyuan->telnum = $vals[$phone];
				$Gltuanyuan->zhuangtai = $vals[$zhuangtai];
				$Gltuanyuan->jiaoqian = $vals[$jiaoqian];
				$Gltuanyuan->xuqiu = $vals[$demand];
				$Gltuanyuan->sid = $vals['sid'];
				$Gltuanyuan->usertype = '订票';
				
				$Gltuanyuan->add();
			}
			$this->redirect('Dingdan/');
		}
	}
	//end
	
	public function member() {
		$num = $_GET['num'];
		$sid = $_GET['sid'];
		
		$type = $_POST['type'];
		
		
		if (!empty($type)){
			
			$vals = $_POST;
			
			$member = D('Member');
			
			for ($i=1; $i<=$vals['num'] ; $i++){
				$name = 'name'.$i;
				$sex = 'sex'.$i;
				$zj = 'zj'.$i;
				$zj_num = 'zj_num'.$i;
				$phone = 'phone'.$i;
				$demand = 'demand'.$i;
				
				$member->name = $vals[$name];
				$member->sex = $vals[$sex];
				$member->zj = $vals[$zj];
				$member->zj_num = $vals[$zj_num];
				$member->phone = $vals[$phone];
				$member->demand = $vals[$demand];
				$member->sid = $vals['sid'];
				
				$member->add();
			}
			$this->redirect('Airticket/search/');
		}
		
			$pid = $_GET['pid'];
			//根据不同代理商进行价格处理
			$idd = D("Ticket_date")->find($pid);
			
			$agents = D("Ticket_agent");
			$price_type = D('Ticket_price')->where("pid=".$idd['pid'])->find();
			
			if ($price_type['agent_type'] == 'Batch'){
				
				$price_all = $agents->where("pid=".$idd['pid']." AND `type` = 'Batch'")->findAll();
				
				$flag = '0';
				
				foreach($price_all as $price_one){
					if($price_one['agent_type'] == $this->roleuser['kehutype'] && $price_one['level'] == $this->roleuser['jibie']){
						$price = $price_one;
						
						//完全匹配成功
						$flag = '100';
						
						break;
					}
					elseif($price_one['agent_type'] == $this->roleuser['kehutype']){
						$price = $price_one;
						
						//匹配到类型，级别匹配失败
						$flag = '75';
						
						continue;
					}
					elseif($price_one['agent_type'] == '全部' && $flag < 50){
						$price = $price_one;
						
						//匹配到全部类型
						$flag = '50';
						
						continue;
					}
					else{	
					}
				}
				//处理结束
			}else{
				
				$price = $agents->where("pid=".$idd['pid']." AND `type` = 'MultipleChoice' AND `agent_type` = '".$this->company['companyname']."'")->find();
				//处理结束	
			}
		
		$this->assign('price',$price['price'] + $idd['price']);
		$this->assign('num',$num);
		$this->assign('sid',$sid);
		$this->display();
	}
	
	public function dingdan() {
		
		//搜索结束
		if($_GET['guojing'] == "境外"){
			$navlist = '订单管理 > 境外 > 机票订单';
		}
		else{
			$navlist = '订单管理 > 国内 > 机票订单';
		}
        $this->assign('navlist',$navlist);
		
		$type = $_POST['type'];
		$wheres = '';
		if (!empty($type)){
			$keyword = $_POST['tbKeyword'];
			if ($keyword){
				$wheres['bid'] = array('like','%'.$keyword.'%');
			}
			
			$status = $_POST['dlState'];
			if ($status){
				$wheres['status'] = $status; 	
			}
		}

		$dingdan = D("Ticket_signup");
		
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $dingdan->where($wheres)->count();
		$p= new Page($count,10);
		//$rurl = SITE_MENSHI."Airticket/dingdan/p/";
		$page = $p->show();
        $dingdans = $dingdan->where($wheres)->order("pubdate DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $this->assign('page',$page);
		
        $this->assign('dingdans',$dingdans);
        $this->display();
    }
	
	public function member_edit() {

		
		$member = D("Member");
		
		$id = $_POST['id'];
		$name = $_POST['name'];
		$sex = $_POST['sex'];
		$zj = $_POST['zj'];
		$zj_num = $_POST['zj_num'];
		$phone = $_POST['phone'];
		$demand = $_POST['demand'];
		
		if (!empty($id)){
			$member->find($id);
			
			$member->name = $name;
			$member->sex = $sex;
			$member->zj = $zj;
			$member->zj_num = $zj_num;
			$member->phone = $phone;
			$member->demand = $demand;
			
			$member->save();
			
		}
		

    }

	//gaopeng
	public function tuanyuan_edit() {
		$Gltuanyuan = D("gltuanyuan");
		
		$id = $_POST['id'];
		$name = $_POST['name'];
		$sex = $_POST['sex'];
		$zj = $_POST['zj'];
		$zj_num = $_POST['zj_num'];
		$phone = $_POST['phone'];
		$demand = $_POST['demand'];
		
		if (!empty($id)){
			$Gltuanyuan->find($id);
			
			//$Gltuanyuan->tuanyuanID = $id;
			$Gltuanyuan->name = $name;
			$Gltuanyuan->sex = $sex;
			$Gltuanyuan->zhengjiantype = $zj;
			$Gltuanyuan->zhengjianhaoma = $zj_num;
			$Gltuanyuan->telnum = $phone;
			$Gltuanyuan->xuqiu = $demand;
			
			$Gltuanyuan->save();
			
		}
		

    }
	
	//end
	public function sign_edit() {

		
		$sign = D("Ticket_signup");
		
		$id = $_POST['id'];
		$val = $_POST['val'];
		$type = $_POST['type'];

		
		if (!empty($id)){
			
			if ($type == 'status'){
				$sign->find($id);
				
				$sign->status = $val;
				
				if($sign->save()){
					$ticket_date = D('Ticket_date');
					$wheres['ticket_id'] = $sign->ticket_id;
					$ticket_date->where($wheres)->find();
					
					if ($val == '占位')	{
						$ticket_date->queren_num -= $sign->re_num;
						$ticket_date->zhanwei_num += $sign->re_num;
					}elseif($val == '确认'){
						$ticket_date->zhanwei_num -= $sign->re_num;
						$ticket_date->queren_num += $sign->re_num;
					}
					
					$ticket_date->save();
				}
			}
		}
		

    }

	public function dingdan_info() {
		
		$bid = $_GET['bid'];
		
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
		

		$this->assign('username',$this->admin['user_name']);
		$this->assign('bid',$bid);
		$this->assign('members',$members);
		$this->assign('dingdans',$dingdans);
        $this->display();
    }

	public function del() {
		
		$bid = $_GET['bid'];
		
		$signup = D('Ticket_signup');
		
		$conditions['bid'] = $bid;
		
		$infos = $signup->where($conditions)->find();
		
		if($signup->delete()){
			$ticket_date = D('Ticket_date');
			
			$wheres['ticket_id'] = $signup->ticket_id;
			$ticket_date->where($wheres)->find();
			
			if ($infos['status'] == '占位')	{
				$ticket_date->zhanwei_num += $infos['re_num'];
			}elseif($infos['status'] == '确认'){
				$ticket_date->queren_num += $infos['re_num'];
			}
			
			$ticket_date->save();
		}
		
		$this->redirect('Airticket/dingdan');
    }
}
?>