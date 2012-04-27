<?php

class ChanpinpingyiAction extends CommonAction{

/*    public function _initialize() {
        if (!$this->adminuser) {
            $this->redirect('/Login/index');
        }
//		if(!checkUserAdmin($this)){
//			$position = '';
//			$this->display('Error/index');
//			exit;
//		}
		
		if(!checkByAdminlevel('网管',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}
		
		
    }*/





    public function index() {
		
		$navlist = "系统设置 > 产品平移 > ".$_GET['type'];
		$this->assign('navlist',$navlist);
		$this->assign('type',$_GET['type']);
		
		$Glkehu = D("Glkehu");
		
		//搜索用户名和真实姓名
		$datas = $_GET;
		$wheres1 = '';
		$wheres2 = '';
		if ($datas){
			$left_keyword = $datas['left_keyword'];
			$right_keyword = $datas['right_keyword'];
			
			if($left_keyword) $wheres1['_string'] = "user_name like '%".$left_keyword."%' OR realname like '%".$left_keyword."%'";
			if($right_keyword) $wheres2['_string'] = "user_name like '%".$right_keyword."%' OR realname like '%".$right_keyword."%'";
			
		}
		$wheres1['usertype'] = '系统用户';
		$wheres2['usertype'] = '系统用户';
		
		$userAll_left = $Glkehu->where($wheres1)->findall();
		$userAll_right = $Glkehu->where($wheres2)->findall();
		
        $this->assign('userAll_left',$userAll_left);
		$this->assign('userAll_right',$userAll_right);
		$this->assign('left_keyword',$left_keyword);
		$this->assign('right_keyword',$right_keyword);
        $this->display();
		
    }

	

    public function chanpinlist() {

		$leftusername = $_GET['leftusername'];
		$rightusername = $_GET['rightusername'];
		$chanpintype = $_GET['chanpintype'];

		$Glkehu = D("Glkehu");
		$leftuser = $Glkehu->where("`user_name` = '$leftusername'")->find();
		$rightuser = $Glkehu->where("`user_name` = '$rightusername'")->find();
		
		$Glzituan = D("Glzituan");
		$condition['user_name'] = $leftuser['user_name'];
		
		if(!$chanpintype)
			$chanpintype = '散客产品';
		if($chanpintype == '散客产品' || $chanpintype == '自由人')
		{
			//新搜索
			$condition['zhuangtai'] = array('NOT IN','准备,等待审核,审核不通过');
			if (!empty($_GET)){
				$from_city = $_GET['chufadi'];
				if ($from_city){
					$condition['chufadi'] = array('like','%'.$from_city.'%'); 	
				}
				
				$to_city = $_GET['mudidi'];
				if ($to_city){
					
					$condition['mudidi'] = array('like','%'.$to_city.'%'); 	
				}
				
				$keyword = $_GET['guanjianzi'];
				if ($keyword){
					$condition['mingcheng'] = array('like','%'.$keyword.'%'); 	
				}
				
				$tianshu = $_GET['tianshu'];
				if ($tianshu){
					$condition['tianshu'] = $tianshu; 	
				}
				
				$start_date = $_GET['chufariqi'];
				
				if ($start_date){
					$condition['chutuanriqi'] = array('like','%'.$start_date.'%'); 	
				}
				
				$status = $_GET['zhuangtai'];
				if ($status && $status != '全部' && $status !='准备' && $status !='等待审核' && $status !='审核不通过'){
					$condition['zhuangtai'] = $status; 	
				}
			}
			
			$condition['xianlutype'] = $chanpintype;
			$zituanAll = $Glzituan->where($condition)->findall();
			
		}
		if($chanpintype == '酒店')
		{
			
			$condition['status'] = array('NOT IN','等待审核,准备,审核不通过');
			if (!empty($_GET)){
				
				$city = $_GET['city'];
				if ($city){
					$condition['city_name'] = $city; 	
				}
				
				$keyword = $_GET['keyword'];
				if ($keyword){
					$condition['_string'] = "house_title like '%".$keyword."%' OR hotel_title like '%".$keyword."%'";
				}
				
				$status = $_GET['status'];
				if ($status){
					$condition['status'] = $status; 	
				}
				
				$start_date = $_GET['start_date'];
				
				if ($start_date){
					$condition['start_date'] = strtotime($start_date); 	
				}
			}
			
			$Hotel_line_view = D("Hotel_line_view");
			
			$hotellineviewAll = $Hotel_line_view->where($condition)->findall();
		}
		if($chanpintype == '机票')
		{
			$condition['status'] = array('NOT IN','等待审核,准备,审核不通过');
			if (!empty($_GET)){
				$from_city = $_GET['from_city'];
				if ($from_city){
					
					$city = D('Liandong');
					
					$conditions['position'] = $from_city;
					$conditions['id'] = array('gt',100000);
					
					$f_city = $city->where($conditions)->find();
					
					$condition['from_city'] = $f_city['id']; 	
				}
				
				$to_city = $_GET['to_city'];
				if ($to_city){
					
					$city = D('Liandong');
					
					$conditions['position'] = $to_city;
					$conditions['id'] = array('gt',100000);
					
					$t_city = $city->where($conditions)->find();
					
					$condition['to_city'] = $t_city['id']; 	
				}
				
				$keyword = $_GET['keyword'];
				if ($keyword){
					$condition['title'] = array('like','%'.$keyword.'%'); 	
				}
				
				$fly_company = $_GET['fly_company'];
				if ($fly_company){
					$condition['fly_company'] = $fly_company; 	
				}
				
				$status = $_GET['status'];
				if ($status){
					$condition['status'] = $status; 	
				}
				
				$start_date = $_GET['start_date'];
				
				if ($start_date){
					$condition['start_date'] = strtotime($start_date); 	
				}
			}

			$ticket_data_view = D("ticket_date_view");
			
			$ticketdataviewAll = $ticket_data_view->where($condition)->findall();
		}
		
        $this->assign('chanpintype',$chanpintype);
        $this->assign('zituanAll',$zituanAll);
        $this->assign('hotellineviewAll',$hotellineviewAll);
        $this->assign('ticketdataviewAll',$ticketdataviewAll);
        $this->assign('leftuser',$leftuser);
        $this->assign('rightuser',$rightuser);
		
		if($chanpintype == '酒店')
        $this->display('hotelchanpinlist');
		else if($chanpintype == '机票')
        $this->display('airchanpinlist');
		else if($chanpintype == '自由人')
        $this->display('zyrchanpinlist');
		else
        $this->display();
    }

	


    public function dopostzhuanyi() {

		$postdata = $_POST;
		if($postdata['postchanpintype'] == '散客产品' || $chanpintype == '自由人')
		{
			$Glzituan = D('Glzituan');
			foreach($postdata['itemlist'] as $id)
			{
				$zituan['zituanID'] = $id;
				$zituan['user_name'] = $postdata['rightusername'];
				$Glzituan->save($zituan);
			}
		}
		
		if($postdata['postchanpintype'] == '机票')
		{
			$ticket_date = D('Ticket_date');
			foreach($postdata['itemlist'] as $id)
			{
				$data['id'] = $id;
				$data['user_name'] = $postdata['rightusername'];
				$ticket_date->save($data);
			}
		}
		
		if($postdata['postchanpintype'] == '酒店')
		{
			$hotel_line = D('Hotel_line');
			foreach($postdata['itemlist'] as $id)
			{
				$data['id'] = $id;
				$data['user_name'] = $postdata['rightusername'];
				$hotel_line->save($data);
			}
		}
		
		$rurl = SITE_ADMIN."Chanpinpingyi/chanpinlist/leftusername/".$postdata['leftusername']."/rightusername/".$postdata['rightusername']."/chanpintype/".$postdata['postchanpintype'];
		doalert('转移成功',$rurl);

    }

	
	
	

    public function dijietuanlist() {
		
		$navlist = "系统设置 > 产品平移 > 地接团队平移";
		$this->assign('navlist',$navlist);
		
		$leftusername = $_GET['leftusername'];
		$rightusername = $_GET['rightusername'];
		$chanpintype = $_GET['chanpintype'];

		$Glkehu = D("Glkehu");
		$leftuser = $Glkehu->where("`user_name` = '$leftusername'")->find();
		$rightuser = $Glkehu->where("`user_name` = '$rightusername'")->find();
		$this->assign('leftuser',$leftuser);
		$this->assign('rightuser',$rightuser);
		
		$dj_tuan = D("dj_tuan");
		$tuanAll = $dj_tuan->where("`adduser` = '$leftusername'")->findall();
		$this->assign('tuanAll',$tuanAll);
		
        $this->display();
	}

























}
?>