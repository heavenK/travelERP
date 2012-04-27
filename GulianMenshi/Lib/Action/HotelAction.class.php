<?php

class HotelAction extends CommonAction{

/*    public function _initialize() {
        if (!$this->adminuser) {
			redirect('/');
        }
    }*/

    public function index() {
        $this->display();
    }
	
	
    public function search() {
		
		$post_data = $_GET;
		
		$wheres = '';
		if (!empty($post_data)){
			
			$hotel = $post_data['keyword'];
			if ($hotel){
				$wheres['hotel_title'] = array('like','%'.$hotel.'%'); 	
			}
			
			$city = $post_data['from_city'];
			if ($city){
				$wheres['city_name'] = array('like','%'.$city.'%'); 	
			}
			
			$start_date = $post_data['start_date'];
			$end_date = $post_data['end_date'];
			
			if ($start_date){
				$wheres['start_date'] = strtotime($start_date); 	
			}
			if ($end_date){
				$wheres['end_date'] = strtotime($end_date); 	
			}
		}
		
		$wheres['status'] = '报名';
		
		
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
		$page = $p->show (SITE_MENSHI.'Hotel/search/p/');


		$this->assign ( "data_line", $data_line );
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
		
		$this->assign('marktab','酒店');
		
        $this->display();
    }
	
	public function ajax() {
		 
		 		
		$house_id = $_GET['house_id'];
		
		$data = D('Hlcontent');
		
		$condition['hl_id']	= $house_id;
		
		$calendar = $data->where($condition)->order('date asc')->findAll(); 
		
		$this->assign('house_id',$house_id);
		$this->assign('calendar',$calendar);
		 
		$this->display();
	}
	
	
	
	public function signup() {
		 
		$type = $_POST['type'];

		if (!empty($type)){
			$data = D('Signup');
			$id = $_POST['id'];
			$department = $_POST['department'];
			$linkphone = $_POST['linkphone'];
			$linkman = $_POST['linkman'];
			$fax = $_POST['fax'];
			$re_num = $_POST['re_num'];
			$other = $_POST['other'];
			$status = $_POST['status'];
			$room = $_POST['room'];
			$hotel = $_POST['hotel'];
			$start_date = $_POST['start_date'];
			$stay_day = $_POST['stay_day'];
			$agent_price = $_POST['agent_price'];
			
			$data->bid = 'DD'.date('Ymd').strtotime("now");
			$data->department = $department;
			$data->linkphone = $linkphone;
			$data->linkman = $linkman;
			$data->fax = $fax;
			$data->re_num = $re_num;
			$data->other = $other;
			$data->status = $status;
			$data->room = $room;
			$data->hotel = $hotel;
			$data->start_date = $start_date;
			$data->stay_day = $stay_day;
			$data->pubdate = strtotime("now");
			$data->pid = $id;
			$data->user_name = $this->roleuser['user_name'];
			$data->price = $agent_price * $re_num;

			if($data->add()){
				
				$id = $_POST['id'];
				$hl = D('Hlcontent');
				
				$hl->find($id);
				
				$hl->reserve_num += $re_num;
				$hl->save();
				
				$this->redirect('Hotel/member/num/'.$re_num.'/sid/'.$data->bid.'/id/'.$id);
			}
		}else{
			$id = $_GET['id'];
		
			$data = D('Hlcontent');
			
			$calender = $data->find($id);
			
			$house = D('House');
			
			$houses = $house->find($calender['hl_id']);
			
			$hotel = D('Hotel');
			
			$hotels = $hotel->find($calender['h_id']);
			
			
			$hotel_line = D('Hotel_line');
			
			$hotel_lines = $hotel_line->find($calender->hl_id);
				
			//gaopeng
			$Gllvxingshe = D('Gllvxingshe');
			$lvxingsheID = $this->roleuser['lvxingsheID'];
			$lvxingshe = $Gllvxingshe->where("`lvxingsheID` = '$lvxingsheID'")->find();
			$this->assign('lvxingshe',$lvxingshe);
			//end
				
				
			$this->assign('agent_price',$calender['agent_price']);
			$this->assign('id',$id);	
			$this->assign('user',$this->roleuser);	
			$this->assign('calender',$calender);
			$this->assign('houses',$houses);
			$this->assign('hotels',$hotels);
			$this->assign('hotel_lines',$hotel_lines);
		}




		$this->display();
	}
	
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
			$this->redirect('Hotel/search/');
		}
		
		$id = $_GET['id'];
		$hl = D('Hlcontent');
		$hlconten = $hl->find($id);
		
		$this->assign('price',$hlconten['agent_price']);
		$this->assign('num',$num);
		$this->assign('sid',$sid);
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
				$Gltuanyuan->usertype = '订房';
				$Gltuanyuan->add();
			}
			$this->redirect('Dingdan/');
		}
	}
	//end
	
	
	
	public function dingdan() {

		$navlist = '订单管理 > 酒店订单';
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
		$dingdan = D("Signup");
		
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

	public function sign_edit() {

		
		$sign = D("Signup");
		
		$id = $_POST['id'];
		$val = $_POST['val'];
		$type = $_POST['type'];

		
		if (!empty($id)){
			
			if ($type == 'status'){
				$sign->find($id);
				
				$sign->status = $val;
				
				$sign->save();
			}
		}
		

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

		$this->assign('username',$this->admin['user_name']);
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
				
				$sign->save();
				
				if ($type == 'lock')	A("Message")->savemessage($bid,'订单','操作记录','锁定订单');
				if ($type == 'unlock')	A("Message")->savemessage($bid,'订单','操作记录','解锁订单');
				if ($type == 'pay')	A("Message")->savemessage($bid,'订单','操作记录','订单付款');
				if ($type == 'notpay')	A("Message")->savemessage($bid,'订单','操作记录','取消付款');
				
				$this->redirect('Hotel/dingdan_info/bid/'.$bid);
			}
		}
        $this->redirect('Hotel/dingdan');
    }


	public function del() {
		
		$bid = $_GET['bid'];
		
		$signup = D('Signup');
		
		$conditions['bid'] = $bid;
		
		$ss = $signup->where($conditions)->find();
		
		if($signup->delete()){
			
			$hl = D('Hlcontent');
			$wheres['id'] = $ss['pid'];
			$hl->where($wheres)->find();
			
			$hl->reserve_num -= $ss['re_num'];
			$hl->save();
			
				
		}
		
		$this->redirect('Hotel/dingdan');
    }
	
	public function answer() {

		$type = $_POST['type'];
		
		if ($type == 'show'){
			$answers = D("Answers");
			
			$wheres['pid'] = $_POST['pid'];
			
			$answer = $answers->where($wheres)->order('pubdate asc')->findall();
			
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