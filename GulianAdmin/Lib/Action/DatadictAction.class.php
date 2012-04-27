<?php

class DatadictAction extends CommonAction {

/*    public function _initialize() {
        if (!$this->adminuser) {
            $this->redirect('/Login/index');
        }
    }*/

    public function index() {
		
		$opera = $_GET['opera'] ? $_GET['opera'] : 'direction';
		
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
		$page = $p->show (SITE_ADMIN.'Datadict/index/opera/'.$opera);

		$type = $opera;
		$this->assign ( "type", $type );
        $this->assign ( "page", $page );
        $this->assign ( "list", $list );
        $this->display('Datadict/list'); 
    }
	
	public function add(){
	
		$opera = $_GET['opera'] ? $_GET['opera'] : 'direction';
	
		$title = $_POST['title'];
		$description = $_POST['description'];
		
		if ($title){
			
			$data = D($opera);
			$data->title = $title;
			$data->description = $description;
			$data->pubdate = strtotime("now");
			$data->add();
			
			$this->redirect('Datadict/index/opera/'.$opera);
		}

		$this->assign ( "type", $opera );
		$this->display();
	}
	
	public function delete(){
		$opera = $_GET['opera'] ? $_GET['opera'] : 'direction';
	
		$id = $_REQUEST['id'];
		
		if(!empty($id)) { 
		
			$data    =    D($opera);

			$condition['id']	= $id;
			
			$result    =    $data->where($condition)->delete(); 
			
			$this->redirect('Datadict/index/opera/'.$opera);
		}
	}
	
	public function edit(){
	
		$opera = $_GET['opera'] ? $_GET['opera'] : 'direction';
	
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
				
				$this->redirect('Datadict/index/opera/'.$opera);
			}
			$this->assign ( "type", $opera);
			$this->assign('data',$data);
			$this->display();
		}
		else	{
			$this->assign('url',SITE_ADMIN.'Datadict/index/opera/'.$opera);
            $this->assign('title','ID不存在！');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
		}
		
	}
}
?>