<?php

class SystemAction extends CommonAction{

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


    public function companyinfo() {
		
		$username = $this->roleuser['user_name'];
		
		$Glkehu = D("Glkehu");
		$kehu = $Glkehu->where("`user_name` = '$username'")->find();
		$lvxingsheID = $kehu['lvxingsheID'];
		$Gllvxingshe = D('Gllvxingshe');
		$postdata = $Gllvxingshe->where("`lvxingsheID` = '$lvxingsheID'")->find();
		
		
		$this->assign('postdata',$postdata);
		$this->display();
		
    }



    public function userlist() {
		$username = $this->roleuser['user_name'];
		
		$Glkehu = D("Glkehu");
		$kehu = $Glkehu->where("`user_name` = '$username'")->find();

		//$Glkehu = D('Glkehu');
		$kehuAll = $Glkehu->where("`lvxingsheID` = '$kehu[lvxingsheID]'")->order("time desc")->findall();
		
		$Gllvxingshe = D('Gllvxingshe');
		$lvxingshe = $Gllvxingshe->where("`lvxingsheID` = '$kehu[lvxingsheID]'")->find();
		
		$this->assign('lvxingshe',$lvxingshe);
		$this->assign('kehuAll',$kehuAll);
        $this->display();
		
    }



    public function kehulist() {
		$navlist = '客户管理 > 客户列表';
		$this->assign('navlist',$navlist);
		
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			continue;
			
			if($key == 'dingdanbianhao'){
				if(!$_GET['usertype']){
					justalert('请选订单类型后搜索订单编号');
				}
				if($_GET['usertype'] == '订团')
					$condition['bianhao'] = array('like','%'.$value.'%');
				if($_GET['usertype'] == '订房' || $_GET['usertype'] == '订票')
					$condition['sid'] = array('like','%'.$value.'%');
					
				$this->assign($key,$value);
				continue;
			}
			
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		
		$tuanyuan_dingdan = D('tuanyuan_dingdan');
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $tuanyuan_dingdan->where($condition)->count();
		$p= new Page($count,20);
		//$rurl = SITE_ADMIN."Kehuguanli/kehulist/p/";
		
//		foreach ( $_POST as $key => $val ) {   
//		   $p->parameter .= "/$key/" . $val; 
//		} 
		
		$page = $p->show();
        $kehuAll = $tuanyuan_dingdan->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		//处理
		$i = 0;
		foreach($kehuAll as $kehu){
			if($kehu['chushengriqi']){
			$age = time()- strtotime($kehu['chushengriqi']);
			$age = $age/(60 * 60 * 24 * 265) + 1;
			$kehuAll[$i]['age'] = (int)$age;
			}
			$i++;
		}
		
		$this->assign('page',$page);
		$this->assign('kehuAll',$kehuAll);
        $this->display();
    }






















}
?>