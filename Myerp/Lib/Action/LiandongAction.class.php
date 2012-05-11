<?php

class LiandongAction extends Action {

    public function index() {
        $this->display();
    }
	
	public function show() {
	
		$t=$_GET['t']?$_GET['t']:0;
		
		$name = M('Liandong');
		$condition['id'] = $t; 
		$pname = $name->where($condition)->find();
		
		if (!$pname) {
			$pname['position'] = '顶级分类';
			$pname['level'] = '一级选择';
			$condition['id']    = array('elt',99); 
		}
		else if ($t >= '1' && $t <= '99') {
			$pname['position'] = '<a href=SITE_ADMIN."Liandong/show/t/' . floor($t/100) . '" style="color:red">'.$pname['position'].'</a>';
			$pname['level'] = '二级选择';
			$condition['id']    = array('between','100,999'); 
		}else{
			$pname['position'] = '<a href=SITE_ADMIN."Liandong/show/t/' . floor($t/100) . '" style="color:red">'.$pname['position'].'</a>';
			$pname['level'] = '三级选择';
			$condition['id']    = array('egt',1000); 
		}
		
		
		$liandong = M('Liandong');
		
		$condition['pid']	= $t;
		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		
		$count = $liandong->where($condition)->count();
		$p = new Page ( $count, 10 ); 
		$list=$liandong->where($condition)->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		
		
		$page = $p->show (SITE_ADMIN.'Liandong/show/t/' . $t . '/p/');
		
		$this->assign ( "t", $t );
		$this->assign ( "pname", $pname );
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display(); 
    }
	
	public function keyword() {
	
		$pid = $_GET['pid']?$_GET['pid']:0;
	
		$name = M('Liandong');
		$conditions['id'] = $pid; 
		$pname = $name->where($conditions)->find();
		$pname['position'] = '<a href=SITE_ADMIN."Liandong/show/t/' . floor($pid/100) . '" style="color:red">'.$pname['position'].'</a>';
		
	
		$jing = D('Jingshe');
			
		$condition['pid'] = $pid; 
		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		
		$count = $jing->where($condition)->count();
		$p = new Page ( $count, 10 ); 
		$list=$jing->where($condition)->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Liandong/keyword/pid/' . $pid . '/p/');
		
		$this->assign ( "pid", $pid );
		$this->assign ( "pname", $pname );
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display(); 
    }
	
	
	public function scenic() {
	
		$scenic = D('Scenicspot');
			

		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		
		
		$count = $scenic->count();
		$p = new Page ( $count, 10 ); 
		$list=$scenic->relation(true)->limit($p->firstRow.','.$p->listRows)->order('id desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Liandong/scenic/p/');

		$this->assign ( "pid", $pid );
		$this->assign ( "pname", $pname );
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display(); 
    }
	
	public function add_scenic(){
	
		$title = $_POST['title'];
		$pid = $_POST['chufachengshi_id'];
		
		if ($title && $pid){
			
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
			
			$scenic = new ScenicspotModel();
			$scenic->title = $title;
			$scenic->pid = $pid;
			$scenic->url = $info[0]['savename'];
			$scenic->pubdate = strtotime("now");
			$scenic->add();
			justalert("修改完成,点击返回后刷新页面");
			gethistoryback();
			//$this->redirect('Liandong/scenic');
		}
		$this->display();
	}
	
	
	public function insert(){
	
		$pid = $_POST['pid'];
		$ename = $_POST['ename'];
		
		$names = split(',',$ename);
		
		$lian = M('Liandong');
		$condition['pid']	= $pid;
		$max_lian = $lian->where($condition)->order('id desc')->find();
		
		if ($max_lian){
			$max_id = $max_lian['id'] + 1;
			echo "1";
		}else{
			if ($pid == '0') {
				$max_id = 1;
			}
			else if ($pid >= '1' && $pid <= '99') {
				$max_id = $pid * 100 + 1;
			}else{
				$max_id = $pid * 1000 + 1;
			}
		}
		
		foreach($names as $name){
			$liandong = new LiandongModel();
			$liandong->id = $max_id;
			$liandong->position = $name;
			$liandong->pid = $pid;
			$liandong->add();
			$max_id++;
		}
		
		
		
		$this->redirect('Liandong/show/t/'.$pid);
	}
	
	public function insert_keyword(){
	
		$pid = $_POST['pid'];
		$ename = $_POST['ename'];
		
		$names = split(',',$ename);
		
		$lian = M('Jingshe');
		
		foreach($names as $name){
			$jingshe = new JingsheModel();
			$jingshe->title = $name;
			$jingshe->pid = $pid;
			$jingshe->add();
		}
		
		
		
		$this->redirect('Liandong/keyword/pid/'.$pid);
	}
	
	public function delete(){
	
		$t=$_GET['t']?$_GET['t']:0;
		$id = $_REQUEST['id'];
		
		if(!empty($id)) { 
		
			$liandong    =    M("Liandong");

			$condition['id']	= array('like',$id.'%');
			
			$result    =    $liandong->where($condition)->delete(); 
			
			$this->redirect('Liandong/show/t/'.$t);
		}
	}
	
	public function delete_keyword(){
	
		$pid = $_GET['pid']?$_GET['pid']:0;
		$id = $_REQUEST['id'];
		
		if(!empty($id)) { 
		
			$jingshe    =    M("Jingshe");

			$condition['id']	= $id;
			
			$result    =    $jingshe->where($condition)->delete(); 
			
			$this->redirect('Liandong/keyword/pid/'.$pid);
		}
	}
	
	public function delete_scenic(){
	
		$id = $_REQUEST['id'];
		
		if(!empty($id)) { 
		
			$scenic    =    M("Scenicspot");

			$condition['id']	= $id;
			
			$result    =    $scenic->where($condition)->delete(); 
			justalert("修改完成,点击返回后刷新页面");
			gethistoryback();
			//$this->redirect('Liandong/scenic');
		}
	}
	
	public function edit(){
	
		$pid = $_POST['pid']?$_POST['pid']:0;
		$id = $_POST['id'];
		$name = $_POST['name'];
		
		
		if(!empty($id)) { 
		
			$liandong    =    M("Liandong");
			
			$liandong->find($id);
			$liandong->position = $name;
			$res = $liandong->save();
		}
	}
	
	public function edit_keyword(){
	
		$pid = $_POST['pid']?$_POST['pid']:0;
		$id = $_POST['id'];
		$name = $_POST['name'];
		
		
		if(!empty($id)) { 
		
			$jingshe    =    M("Jingshe");
			
			$jingshe->find($id);
			$jingshe->title = $name;
			$res = $jingshe->save();
		}
	}
	
	public function edit_scenic(){
	
		$pid = $_POST['chufachengshi_id'];
		$id = $_REQUEST['id'];
		$title = $_POST['title'];
		$type = $_POST['type'];
		$url = $_POST['url'];
		
		if(!empty($id)) { 
		
			$scenic = M("Scenicspot");
			
			$pic = $scenic->find($id);
		
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
				$scenic->title = $title;
				$scenic->pid = $pid;
				$scenic->url = $url;
				$res = $scenic->save();
				justalert("修改完成,点击返回后刷新页面");
				gethistoryback();
				//$this->redirect('Liandong/scenic');
			}
			
			$this->assign('pic',$pic);
			$this->display();
		}
		else	$this->redirect('Liandong/scenic');
		
	}
	
	public function liandong(){
	    $type=$_POST['type'];
        $pid=$_POST['pid'];
		
		if ($type == 'pos')
		{
			$liandong = D('Liandong');
			$user=$liandong->where("pid='$pid'")->findAll();
			
			$i = 1;
			
			foreach ($user as $row){
				if ($i == 1)	echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['position']	. "</option>";
				else echo "<option value='" . $row['id'] . "'>" . $row['position']	. "</option>";
				$i++;
			}
		}
		
		if ($type == 'pos_go')
		{
			$liandong = D('Liandong');
			
			$condition['pid'] = array('between','1,99'); 
			
			$user=$liandong->where($condition)->findAll();
			
			$i = 1;
			
			foreach ($user as $row){
				if ($i == 1)	echo "<option value='" . $row['id'] . "' selected='selected'>" . $row['position']	. "</option>";
				else echo "<option value='" . $row['id'] . "'>" . $row['position']	. "</option>";
				$i++;
			}
		}
		
		if ($type == 'jingshe')
		{
			$jingshe = D('Jingshe');
			$jing=$jingshe->where("pid='$pid'")->findAll();
			
			foreach ($jing as $row){
				echo "<a onclick='addWords(this, \"". $row['title'] ."\");' href='javascript:void(0)'>" . $row['title'] . "</a>&nbsp;";
			}
		}
		
		if ($type == 'all')
		{
			$jingshe = M("Jingshe");
			$jing=$jingshe->where("pid='$pid'")->findAll();
			
			foreach ($jing as $row){
				echo $row['title'] . " ";
			}
		}
		 $this->display();
	}
	
	public function select(){
		$this->display();
	}
	
	public function getImages(){
		$own = $_REQUEST['own'];
		$images = D('Scenicspot');
		
		$pics = $images->order("pubdate desc")->findAll();
		
		$this->assign('pics',$pics); 
		$this->assign('own',$own);
		$this->display();
	}
	
	public function getVideos(){
		$own = $_REQUEST['own'];
		$videos = D('Videos');
		
		$movies = $videos->order("pubdate desc")->findAll();
		
		$this->assign('movies',$movies); 
		$this->assign('own',$own);
		$this->display();
	}
	
	public function getAgencys(){
		$own = $_REQUEST['own'];
		$ids = $_REQUEST['ids'];
		
		$idname = $_REQUEST['idname'];
		$idid = $_REQUEST['idid'];
		
		$Glkehu = D('Gllvxingshe');
//		if ($idname == 'AgentName2') $wheres['isagent'] = '是';
//		if ($idname == 'CompanyName3') $wheres['type'] = '同业';
		
		$agents = $Glkehu->where($wheres)->findAll();
		$isduoxuan = $_REQUEST['isduoxuan'];
		if(!$isduoxuan)
		$this->assign('isduoxuan',1); 
		
		$this->assign('idid',$idid); 
		$this->assign('idname',$idname); 
		$this->assign('agents',$agents); 
		$this->assign('own',$own);
		$this->assign('ids',$ids);
		$this->display();
	}
	
	
	
	
}
?>