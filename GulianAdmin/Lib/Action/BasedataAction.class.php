<?php

class BasedataAction extends CommonAction {

/*    public function _initialize() {
        if (!$this->adminuser) {
            $this->redirect('/Login/index');
        }
//		if(!checkUserAdmin($this)){
			//dump($_SERVER);
//			$position = '';//操作路径
//			$this->display('Error/index');
//			exit;
//		}
		
		if(!checkByAdminlevel('计调操作员,网管,总经理',$this)){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}
		
		
		
    }*/

    public function index() {
		
		if (empty($_GET['opera'])){
			$this->display();
		}
		$opera = $_GET['opera'] ? $_GET['opera'] : 'line_theme';
		
		$data = D($opera);
		
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
		$page = $p->show (SITE_ADMIN.'Basedata/index/opera/'.$opera.'/p/');

		$type = $opera;
		$this->assign ( "type", $type );
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display('Basedata/list'); 
    }
	
	public function add(){
	
		$opera = $_GET['opera'] ? $_GET['opera'] : 'line_theme';
	
		$title = $_POST['title'];
		$description = $_POST['description'];
		
		if ($title){
			
			$data = D($opera);
			$data->title = $title;
			$data->description = $description;
			$data->pubdate = strtotime("now");
			$data->add();
			justalert("添加完成");
			gethistoryback();
			//$this->redirect('Basedata/index/opera/'.$opera);
		}

		$this->assign ( "type", $opera );
		$this->display();
	}
	
	
	public function ajax_add(){
	
		$opera = $_POST['opera'];
		$title = $_POST['title'];
		
		if($opera != 'line_theme' && $opera != 'goods_type') echo "false";
		
		if ($title && $opera){
			
			$data = D($opera);
			$data->title = $title;
			$data->pubdate = strtotime("now");
			$data->add();
			
			if($data) echo "true";
			else echo "false";
		}
	}
	
	
	public function delete(){
		$opera = $_GET['opera'] ? $_GET['opera'] : 'line_theme';
	
		$id = $_REQUEST['id'];
		
		if(!empty($id)) { 
		
			$data    =    D($opera);

			$condition['id']	= $id;
			
			$result    =    $data->where($condition)->delete(); 
			
			$this->redirect('Basedata/index/opera/'.$opera);
		}
	}
	
	public function edit(){
	
		$opera = $_GET['opera'] ? $_GET['opera'] : 'line_theme';
	
		$id = $_REQUEST['id'];
		$title = $_POST['title'];
		$type = $_POST['type'];
		$description = $_POST['description'];
		
		if(!empty($id)) { 
		
			$datas = D($opera);
			
			$data = $datas->find($id);
		
			if ($type == 'save'){
			
				$datas->title = $title;
				$datas->description = $description;
				$res = $datas->save();
				
				$this->redirect('Basedata/index/opera/'.$opera);
			}
			$this->assign ( "type", $opera);
			$this->assign('data',$data);
			$this->display();
		}
		else	{
			$this->assign('url',SITE_ADMIN.'Basedata/index/opera/'.$opera);
            $this->assign('title','ID不存在！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
		
	}
	
	public function flying() {
	
		$data = D('Flying');
			

		
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
		$page = $p->show (SITE_ADMIN.'Basedata/flying/p/');

        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display(); 
    }
	
	public function add_flying(){
	
		$title = $_POST['title'];
		$description = $_POST['description'];
		$video_url = $_POST['video_url'];
		
		if ($title){
			
			import ("ORG.Net.UploadFile");
			
			$upload = new UploadFile();
			
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
			
			$upload->saveRule = 'time';
			
			$upload->autoSub = 'true';
			
			$upload->subType = 'date';
			
			$upload->dateFormat = 'Y/m';
			
			$upload->savePath =  './data/attachments/';
			
			$upload->upload();

			$info =  $upload->getUploadFileInfo();   
			
			$data = D('Flying');
			$data->title = $title;
			$data->description = $description;
			$data->pic_url = $info[0]['savename'];
			$data->pubdate = strtotime("now");
			$data->add();
			
			$this->redirect('Basedata/flying');
		}

		$this->display();
	}
	
	
	public function delete_flying(){
	
		$id = $_REQUEST['id'];
		
		if(!empty($id)) { 
		
			$data    =    D("Flying");

			$condition['id']	= $id;
			
			$result    =    $data->where($condition)->delete(); 
			
			$this->redirect('Basedata/flying');
		}
	}
	
	public function edit_flying(){
	
		$id = $_REQUEST['id'];
		$title = $_POST['title'];
		$type = $_POST['type'];
		$url = $_POST['url'];
		$description = $_POST['description'];
		
		if(!empty($id)) { 
		
			$data = M("Flying");
			
			$fly = $data->find($id);
		
			if ($type == 'save'){
			
				import ("ORG.Net.UploadFile");
			
				$upload = new UploadFile();
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
				$upload->saveRule = 'time';
				$upload->autoSub = 'true';
				$upload->subType = 'date';
				$upload->dateFormat = 'Y/m';
				$upload->savePath =  './data/attachments/';
				$upload->upload();

				$info =  $upload->getUploadFileInfo();  
			
				if (!$info) $url = $url;
				else 
				{
					unlink('data/attachments/'.$pic['url']);
					$url = $info[0]['savename'];
				}
			
				$fly->title = $title;
				$fly->description = $description;
				$fly->pic_url = $url;
				$res = $fly->save();
				
				$this->redirect('Basedata/flying');
			}
			
			$this->assign('fly',$fly);
			$this->display();
		}
		else	{
			$this->assign('url',SITE_ADMIN.'Basedata/flying');
            $this->assign('title','ID不存在！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
		
	}
	
	
	
	
	public function videos() {
	
		$videos = D('Videos');
			

		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		
		$count = $videos->count();
		$p = new Page ( $count, 10 ); 
		$list=$videos->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Basedata/videos/p/');

        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display(); 
    }
	
	public function add_video(){
	
		$title = $_POST['title'];
		$description = $_POST['description'];
		$video_url = $_POST['video_url'];
		
		if ($title){
			
			import ("ORG.Net.UploadFile");
			
			$upload = new UploadFile();
			
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
			
			$upload->saveRule = 'time';
			
			$upload->autoSub = 'true';
			
			$upload->subType = 'date';
			
			$upload->dateFormat = 'Y/m';
			
			$upload->savePath =  './data/attachments/';
			
			$upload->upload();

			$info =  $upload->getUploadFileInfo();   
			
			$video = D('Videos');
			$video->title = $title;
			$video->description = $description;
			$video->video_url = $video_url;
			$video->pic_url = $info[0]['savename'];
			$video->pubdate = strtotime("now");
			$video->add();
			justalert("添加完成");
			gethistoryback();
			//$this->redirect('Basedata/videos');
		}

		$this->display();
	}
	
	
	public function delete_video(){
	
		$id = $_REQUEST['id'];
		
		if(!empty($id)) { 
		
			$video    =    D("Videos");

			$condition['id']	= $id;
			
			$result    =    $video->where($condition)->delete(); 
			
			doalert("删除完成","");
			//$this->redirect('Basedata/videos');
		}
	}
	
	public function edit_video(){
	
		$id = $_REQUEST['id'];
		$title = $_POST['title'];
		$type = $_POST['type'];
		$url = $_POST['url'];
		$video_url = $_POST['video_url'];
		$description = $_POST['description'];
		
		if(!empty($id)) { 
		
			$video = M("Videos");
			
			$movie = $video->find($id);
		
			if ($type == 'save'){
			
				import ("ORG.Net.UploadFile");
			
				$upload = new UploadFile();
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
				$upload->saveRule = 'time';
				$upload->autoSub = 'true';
				$upload->subType = 'date';
				$upload->dateFormat = 'Y/m';
				$upload->savePath =  './data/attachments/';
				$upload->upload();

				$info =  $upload->getUploadFileInfo();  
			
				if (!$info) $url = $url;
				else 
				{
					unlink('data/attachments/'.$pic['url']);
					$url = $info[0]['savename'];
				}
			
				$video->title = $title;
				$video->description = $description;
				$video->video_url = $video_url;
				$video->pic_url = $url;
				$res = $video->save();
				
				//$this->redirect('Basedata/videos');
				doalert("修改完成","");
			}
			
			$this->assign('movie',$movie);
			$this->display();
		}
		else	{
			$this->assign('url',SITE_ADMIN.'Basedata/videos');
            $this->assign('title','ID不存在！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
		
	}
	
	public function hotel() {
	
		$hotel = D('Hotel');
			

		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		
		$count = $hotel->count();
		$p = new Page ( $count, 10 ); 
		$list=$hotel->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Basedata/hotel/p/');

        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display(); 
    }
	
	public function add_hotel(){
	
		$title = $_POST['title'];
		$guojing = $_POST['guojing'];
		$daqu_id = $_POST['daqu_id'];
		$shengfen_id = $_POST['shengfen_id'];
		$chengshi_id = $_POST['chengshi_id'];
		$chengshi_name = $_POST['chengshi_name'];
		$en_title = $_POST['en_title'];
		$star = $_POST['star'];
		
		$telephone = $_POST['telephone'];
		$address = $_POST['address'];
		$fly_distance = $_POST['fly_distance'];
		$train_distance = $_POST['train_distance'];
		$center_distance = $_POST['center_distance'];
		$hotel_info = $_POST['hotel_info'];
		$hotel_around = $_POST['hotel_around'];
		
		
		if ($title && $en_title){
			
			import ("ORG.Net.UploadFile");
			
			$upload = new UploadFile();
			
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
			
			$upload->saveRule = 'time';
			
			$upload->autoSub = 'true';
			
			$upload->subType = 'date';
			
			$upload->dateFormat = 'Y/m';
			
			$upload->savePath =  './data/attachments/';
			
			$upload->upload();

			$info =  $upload->getUploadFileInfo();   
			
			
			
			$hotel = D('Hotel');
			
			$hotel->title = $title;
			$hotel->en_title = $en_title;
			$hotel->city = $chengshi_id;
			$hotel->city_name = $chengshi_name;
			
			$hotel->star = $star;
			$hotel->telephone = $telephone;
			$hotel->address = $address;
			$hotel->fly_distance = $fly_distance;
			$hotel->train_distance = $train_distance;
			$hotel->center_distance = $center_distance;
			$hotel->hotel_info = $hotel_info;
			$hotel->hotel_around = $hotel_around;
			
			$hotel->pic_url = $info[0]['savename'];
			$hotel->pubdate = strtotime("now");
			$hotel->add();
			//dump($hotel);
			$this->redirect('Basedata/hotel');
		}
		$this->display();

	}
	
	
	public function delete_hotel(){
	
		$id = $_REQUEST['id'];
		
		if(!empty($id)) { 
		
			$hotel    =    D("Hotel");

			$condition['id']	= $id;
			
			$result    =    $hotel->where($condition)->delete(); 
			
			$this->redirect('Basedata/hotel');
		}
	}
	
	public function edit_hotel(){
	
		$id = $_REQUEST['id'];
		$type = $_POST['type'];

		$title = $_POST['title'];
		$guojing = $_POST['guojing'];
		$daqu_id = $_POST['daqu_id'];
		$shengfen_id = $_POST['shengfen_id'];
		$chengshi_id = $_POST['chengshi_id'];
		$en_title = $_POST['en_title'];
		$star = $_POST['star'];
		
		$telephone = $_POST['telephone'];
		$address = $_POST['address'];
		$fly_distance = $_POST['fly_distance'];
		$train_distance = $_POST['train_distance'];
		$center_distance = $_POST['center_distance'];
		$hotel_info = $_POST['hotel_info'];
		$hotel_around = $_POST['hotel_around'];
		
		$url = $_POST['url'];
		
		if(!empty($id)) { 
		
			$hotel = M("Hotel");
			
			$data = $hotel->find($id);
		
			if ($type == 'save'){
			
				import ("ORG.Net.UploadFile");
			
				$upload = new UploadFile();
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
				$upload->saveRule = 'time';
				$upload->autoSub = 'true';
				$upload->subType = 'date';
				$upload->dateFormat = 'Y/m';
				$upload->savePath =  './data/attachments/';
				$upload->upload();

				$info =  $upload->getUploadFileInfo();  
			
				if (!$info) $url = $url;
				else 
				{
					unlink('data/attachments/'.$pic['url']);
					$url = $info[0]['savename'];
				}
			
				$hotel->title = $title;
				$hotel->en_title = $en_title;
				$hotel->city = $chengshi_id;
				
				$hotel->star = $star;
				$hotel->telephone = $telephone;
				$hotel->address = $address;
				$hotel->fly_distance = $fly_distance;
				$hotel->train_distance = $train_distance;
				$hotel->center_distance = $center_distance;
				$hotel->hotel_info = $hotel_info;
				$hotel->hotel_around = $hotel_around;
			
				$hotel->pic_url = $url;
				$res = $hotel->save();
				
				$this->redirect('Basedata/hotel');
			}
			
			$this->assign('data',$data);
			$this->display();
		}
		else	{
			$this->assign('url',SITE_ADMIN.'Basedata/hotel');
            $this->assign('title','ID不存在！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
		
	}
	
	
	public function house() {
	
		$house = D('House');
			

		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		
		$count = $house->count();
		$p = new Page ( $count, 10 ); 
		$list=$house->relation(true)->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Basedata/house/p/');

        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display(); 
    }
	
	public function add_house(){
		
		$pid = $_REQUEST['pid'];
		
		$room = D('Room')->findAll();
		$direction = D('Direction')->findAll();
		$internet = D('Internet')->findAll();
		$breakfast = D('Breakfast')->findAll();
		$support = D('Support')->findAll();
		
		foreach($room as $r){
			$rooms .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		foreach($direction as $r){
			$directions .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		foreach($internet as $r){
			$internets .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		foreach($breakfast as $r){
			$breakfasts .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		foreach($support as $r){
			$supports .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		
		$this->assign ( "pid", $pid );
		$this->assign ( "room", $rooms );
        $this->assign ( "direction", $directions );
		$this->assign ( "internet", $internets );
		$this->assign ( "breakfast", $breakfasts );
		$this->assign ( "support", $supports );
		
		$title = $_POST['title'];
		$room = $_POST['room'];
		$direction = $_POST['direction'];
		$smoke = $_POST['smoke'];
		$internet = $_POST['internet'];
		$breakfast = $_POST['breakfast'];
		$video_url = $_POST['video_url'];
		
		$bf_price = $_POST['bf_price'];
		$support = $_POST['support'];
		$house_info = $_POST['house_info'];
		
		
		if ($title){
			
			import ("ORG.Net.UploadFile");
			
			$upload = new UploadFile();
			
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
			
			
			$upload->saveRule = 'uniqid';
			
			$upload->thumb = 'true';
			$upload->thumbMaxWidth = "50" ; 

			$upload->thumbMaxHeight = "50" ; 
			
			$upload->autoSub = 'true';
			
			$upload->subType = 'date';
			
			$upload->dateFormat = 'Y/m';
			
			$upload->savePath =  './data/attachments/';
			
			$upload->upload();

			$info =  $upload->getUploadFileInfo();   
			
			$house = D('House');
			
			$house->title = $title;
			$house->room = $room;
			$house->direction = $direction;
			
			$house->smoke = $smoke;
			$house->internet = $internet;
			$house->breakfast = $breakfast;
			$house->video_url = $video_url;
			$house->bf_price = $bf_price;
			$house->support = $support;
			$house->house_info = $house_info;
			
			$house->big_pic = $info[0]['savename'];
			$house->pubdate = strtotime("now");
			$house->pid = $pid;
			$house->add();

			$this->redirect('Basedata/house');
		}
		
		
		$this->display();

	}
	
	
	public function delete_house(){
	
		$id = $_REQUEST['id'];
		
		if(!empty($id)) { 
		
			$house    =    D("House");

			$condition['id']	= $id;
			
			$result    =    $house->where($condition)->delete(); 
			
			$this->redirect('Basedata/house');
		}
	}
	
	public function edit_house(){
	
		$id = $_REQUEST['id'];
		$type = $_POST['type'];

		$room = D('Room')->findAll();
		$direction = D('Direction')->findAll();
		$internet = D('Internet')->findAll();
		$breakfast = D('Breakfast')->findAll();
		$support = D('Support')->findAll();
		
		foreach($room as $r){
			$rooms .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		foreach($direction as $r){
			$directions .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		foreach($internet as $r){
			$internets .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		foreach($breakfast as $r){
			$breakfasts .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		foreach($support as $r){
			$supports .= '<option value="' . $r['title'] .'">' .$r['title'] .'</option>';
		}
		
		
		$this->assign ( "room", $rooms );
        $this->assign ( "direction", $directions );
		$this->assign ( "internet", $internets );
		$this->assign ( "breakfast", $breakfasts );
		$this->assign ( "support", $supports );
		
		$title = $_POST['title'];
		$room = $_POST['room'];
		$direction = $_POST['direction'];
		$smoke = $_POST['smoke'];
		$internet = $_POST['internet'];
		$breakfast = $_POST['breakfast'];
		$video_url = $_POST['video_url'];
		
		$bf_price = $_POST['bf_price'];
		$support = $_POST['support'];
		$house_info = $_POST['house_info'];
		
		$url = $_POST['url'];
		
		foreach($support as $key=>$s){
			if ($key == '0') $goods = $s;
			else $goods .= ','.$s;
		}
		
		if(!empty($id)) { 
		
			$house = M("House");
			
			$data = $house->find($id);
		
			if ($type == 'save'){
			
				import ("ORG.Net.UploadFile");
			
				$upload = new UploadFile();
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
				$upload->saveRule = 'time';
				$upload->autoSub = 'true';
				$upload->subType = 'date';
				$upload->dateFormat = 'Y/m';
				$upload->savePath =  './data/attachments/';
				$upload->upload();

				$info =  $upload->getUploadFileInfo();  
			
				if (!$info) $url = $url;
				else 
				{
					unlink('data/attachments/'.$pic['url']);
					$url = $info[0]['savename'];
				}
			
				$house->title = $title;
				$house->room = $room;
				$house->direction = $direction;
				
				$house->smoke = $smoke;
				$house->internet = $internet;
				$house->breakfast = $breakfast;
				$house->video_url = $video_url;
				$house->bf_price = $bf_price;
				$house->support = $goods;
				$house->house_info = $house_info;
			
				$house->big_pic = $url;
				$res = $house->save();
				
				
				$this->redirect('Basedata/house');
			}
			
			$this->assign('data',$data);
			$this->display();
		}
		else	{
			$this->assign('url',SITE_ADMIN.'Basedata/house');
            $this->assign('title','ID不存在！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
		
	}
	
	
	public function hotel_info(){
	    $type=$_POST['type'];
        $pid=$_POST['pid'];
		
		if ($type == 'hotel')
		{
			$liandong = D('Hotel');
			$user=$liandong->where("city='$pid'")->findAll();
			
			$i = 1;
			
			foreach ($user as $row){
				if ($i == 1)	echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['title']	. "</option>";
				else echo "<option value='" . $row['id'] . "'>" . $row['title']	. "</option>";
				$i++;
			}
		}
		if ($type == 'house')
		{
			$liandong = D('House');
			$user=$liandong->where("pid='$pid'")->findAll();
			
			$i = 1;
			$use = D('Hotel_line');
			$str = '';
			
			foreach ($user as $row){
				if ($use->where("house_id='".$row['id']."'")->find()) {
					$str .= "<option value='" . $row['id'] . "' style='color:red' disabled='disabled'>" . $row['title']	. "(已用)</option>";
				}else{
					if ($i == 1)	$str .= "<option value='" . $row['id'] . "' selected='selected' >" . $row['title']	. "</option>";
					else $str .= "<option value='" . $row['id'] . "'>" . $row['title']	. "</option>";
					$i++;
				}
				
			}
			
			echo $str;
			
		}
		 $this->display();
	}
	
	
	
	function bigman(){
		
		$navlist = '系统设置 > 大客户设置 > '.$_GET['type'];
		$this->assign('navlist',$navlist);
		$this->assign('type',$_GET['type']);
		
		$condition['type'] = $_GET['type'];
		
		$glbasedata = D("glbasedata");
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		$count = $glbasedata->where($condition)->count();
		$p = new Page ( $count, 30 ); 
		$datalist=$glbasedata->limit($p->firstRow.','.$p->listRows)->where($condition)->order('pubdate desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Kehuguanli/departmentlist/type/'.$condition['type'].'/p/');
        $this->assign ( "page", $page );
        $this->assign ( "datalist", $datalist );
		 $this->display();
	}
	
	
	function addbigman(){
		
		$this->assign('type',$_GET['type']);
		$navlist = '系统设置 > 大客户设置 > '.$_GET['type'];
		$this->assign('navlist',$navlist);
		$id = $_GET['id'];
		if($id){
			$glbasedata = D("glbasedata");
			$olddata = $glbasedata->where("`id` = '$id'")->find();
			$this->assign ( "data", $olddata );
			$this->assign ( "type", $olddata['type'] );
		}
		 $this->display();
	}
	
	
	public function dopostbigman()
	{
		foreach($_POST as $key => $value){
			$data[$key] = $value;
		}
		$glbasedata = D("glbasedata");
		if($data['id']){
			$data['edituser'] = $this->roleuser['user_name'];
			$olddata = $glbasedata->where("`id` = '$data[id]'")->find();
			if($olddata){
				$glbasedata->save($data);
			}
		}
		else{
			$data['pubdate'] = time();
			$data['adduser'] = $this->roleuser['user_name'];
			$data['edituser'] = $this->roleuser['user_name'];
			$glbasedata->add($data);
		}
	
		doalert('添加成功',SITE_ADMIN.'Basedata/bigman/type/大客户');
	}
	
	public function deletebigman()
	{
		$id = $_GET['id'];
		if($id){
			$glbasedata = D("glbasedata");
			$data = $glbasedata->where("`id` = '$id'")->find();
			$glbasedata->where("`id` = '$id'")->delete();
		}
		doalert('删除成功','');
	}

	
	
	
	
	
	
	
	
	
	
	
}
?>