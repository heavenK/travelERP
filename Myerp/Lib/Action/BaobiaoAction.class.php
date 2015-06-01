<?php

class BaobiaoAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'报表管理');
	}
	
	public function left_fabu($htmltp='',$pagetype='') {
	}

	
	public function index(){
		A("Method")->showDirectory("报表管理");
		
		isset($_GET['type']) ? $type = $_GET['type'] : $type = '往来';
		
		$ViewBaozhangitem = D('ViewBaozhangitem');
		

		
		if($type == '往来'){
			
			isset($_REQUEST['title']) ? $data_str = ' AND `title`="'.$_REQUEST['title'].'"' : ''; 
			isset($_REQUEST['start_time']) ? $start_time = $_REQUEST['start_time'] : $start_time = $_REQUEST['start_time'] = date('Y-m-01'); 
			isset($_REQUEST['end_time']) ? $end_time = $_REQUEST['end_time'] : $end_time = $_REQUEST['end_time'] = date('Y-m-01',strtotime($start_time."+1 month")); 
			$where['paytime'] = array('lt',strtotime($end_time));
			$where['status_system'] = 1;
			
			$ViewDataDictionary = D("ViewDataDictionary");
			
			import("@.ORG.Page");
			$count = $ViewDataDictionary->field("systemID,title")->where("`type`='商户条目' AND `status_system` = 1".$data_str)->count();
			$p= new Page($count,100);
			$page = $p->show();
			$wanglai = $ViewDataDictionary->field("systemID,title")->where("`type`='商户条目' AND `status_system` = 1".$data_str)->limit($p->firstRow.','.$p->listRows)->select();

			foreach($wanglai as $val){
				$ids[] = $val['systemID'];
			}
			$where['expandID'] = array('IN',$ids);
			
			
			$baozhangitem = $ViewBaozhangitem->where($where)->select();

			foreach($baozhangitem as $baozhang){
				$chanpin[$baozhang['expandID']]['title'] = $baozhang['title'];
				if($baozhang['type'] == '结算项目') {
					if($baozhang['paytime'] < strtotime($start_time)) $chanpin[$baozhang['expandID']]['qichuyingshou'] += $baozhang['value'];
					else $chanpin[$baozhang['expandID']]['yingshou'] += $baozhang['value'];
				}
				else if($baozhang['type'] == '支出项目') {
					if($baozhang['paytime'] < strtotime($start_time)) $chanpin[$baozhang['expandID']]['qichuyingfu'] += $baozhang['value'];
					else $chanpin[$baozhang['expandID']]['yingfu'] += $baozhang['value'];
				}
				else if($baozhang['type'] == '已收项目') {
					if($baozhang['paytime'] < strtotime($start_time)) $chanpin[$baozhang['expandID']]['qichuyingshou'] -= $baozhang['value'];
					else $chanpin[$baozhang['expandID']]['yishou'] += $baozhang['value'];
				}
				else if($baozhang['type'] == '已付项目') {
					if($baozhang['paytime'] < strtotime($start_time)) $chanpin[$baozhang['expandID']]['qichuyingfu'] -= $baozhang['value'];
					else $chanpin[$baozhang['expandID']]['yifu'] += $baozhang['value'];
				}
				else continue;
			}
		}else if($type == '应收' || $type == '应付'){
			
			isset($_REQUEST['title']) ? $where['title_copy'] = array('LIKE',"%".$_REQUEST['title']."%") : ''; 
			isset($_REQUEST['start_time']) ? $start_time = $_REQUEST['start_time'] : $start_time = $_REQUEST['start_time'] = date('Y-m-01'); 
			isset($_REQUEST['end_time']) ? $end_time = $_REQUEST['end_time'] : $end_time = $_REQUEST['end_time'] = date('Y-m-01',strtotime($start_time."+1 month")); 
			$where['chutuanriqi'] = array('between',array($start_time,$end_time));
			$where['status_system'] = 1;
			
			$order = 'chutuanriqi desc';
			
			$ViewZituan = D("ViewZituan");
			
			
			import("@.ORG.Page");
			$count = $ViewZituan->where($where)->count();
			$p= new Page($count,30);
			$page = $p->show();
			$zituanlist = $ViewZituan->where($where)->order($order)->limit($p->firstRow.','.$p->listRows)->select();
			
			foreach($zituanlist as $val){
				$zituan_ids[] = $val['chanpinID'];
				$arr[$val['chanpinID']] = $val; 
			}
			
			$where_bz['parentID'] = array('IN',$zituan_ids);
			$ViewBaozhang = D("ViewBaozhang");
			$baozhanglist = $ViewBaozhang->where($where_bz)->order("title desc")->select();
			
			foreach($baozhanglist as $val){
				$baozhang_ids[] = $val['chanpinID']; 
				$chanpin[$val['chanpinID']] = $arr[$val['parentID']];
			}
			$where_bzi['parentID'] = array('IN',$baozhang_ids);
			$baozhangitemlist = $ViewBaozhangitem->where($where_bzi)->select();
            
            
            $er = D("ViewExpectlist");
			$yijinglist = $er->where($where_bzi)->select();
            
			foreach($baozhangitemlist as $val){
				if($val['type'] == '结算项目') {
					$chanpin[$val['parentID']]['yingshou'] += $val['value'];
					$chanpin[$val['parentID']]['yingshourenshu'] += $val['renshu'];
				}
				else if($val['type'] == '支出项目') {
					$chanpin[$val['parentID']]['yingfu'] += $val['value'];
					$chanpin[$val['parentID']]['yingfurenshu'] += $val['renshu'];
				}
				
			}
            foreach($yijinglist as $val){
				if($val['type'] == '结算项目') {
					$chanpin[$val['parentID']]['yishou'] += $val['money'];
					$chanpin[$val['parentID']]['yishourenshu'] += $val['renshu'];
				}
				else if($val['type'] == '支出项目') {
					$chanpin[$val['parentID']]['yifu'] += $val['money'];
					$chanpin[$val['parentID']]['yifurenshu'] += $val['renshu'];
				}
				
			}
			
			
		}else if($type == '收款' || $type == '付款'){
			isset($_REQUEST['title']) ? $data_str = ' AND `title`="'.$_REQUEST['title'].'"' : ''; 
			isset($_REQUEST['start_time']) ? $start_time = $_REQUEST['start_time'] : $start_time = $_REQUEST['start_time'] = date('Y-m-01'); 
			isset($_REQUEST['end_time']) ? $end_time = $_REQUEST['end_time'] : $end_time = $_REQUEST['end_time'] = date('Y-m-01',strtotime($start_time."+1 month")); 
			$where['paytime'] = array('between',array(strtotime($start_time),strtotime($end_time)));
			$where['status_system'] = 1;
			
			$order = 'paytime desc';
/*			$ViewDataDictionary = D("ViewDataDictionary");
			
			import("@.ORG.Page");
			$count = $ViewDataDictionary->field("systemID,title")->where("`type`='商户条目' AND `status_system` = 1".$data_str)->count();
			$p= new Page($count,100);
			$page = $p->show();
			$wanglai = $ViewDataDictionary->field("systemID,title")->where("`type`='商户条目' AND `status_system` = 1".$data_str)->limit($p->firstRow.','.$p->listRows)->select();

			foreach($wanglai as $val){
				$ids[] = $val['systemID'];
			}
			$where['expandID'] = array('IN',$ids);*/
			
			$where['type'] =  $type == '收款' ? '已收项目' : '已付项目';
			
			import("@.ORG.Page");
			$count = $ViewBaozhangitem->where($where)->count();
			$p= new Page($count,100);
			$page = $p->show();
			$baozhangitem = $ViewBaozhangitem->where($where)->order($order)->limit($p->firstRow.','.$p->listRows)->select();
			
			$chanpin = $baozhangitem;
		}
		
		$this->assign('page',$page);
		$this->assign('chanpin_list',$chanpin);
		$this->display();
		
	}
	
	public function add(){
		
		$type = $_GET['type'];
		$chanpinID = $_GET['chanpinID'];
		if(!$type && !$chanpinID){
			$this->error('来源有问题！',U('index'));
		}
		
		$list = A('Method')->_shanghutiaomulist();
		$this->assign("shanghutiaomu",$list);
		
		$ViewCategory = D("ViewCategory");
		$username = $this->user['title'];
		$ComID = A('Method')->_getComIDbyUser($username);
		$categorylist = $ViewCategory->where("`companyID` = '$ComID' AND `status_system` = 1 AND type = '往来'")->findall();
		$this->assign("categorylist",$categorylist);

		if($type){
			if($type == '付款'){
				$this->assign("actiontype",'已付');
			}
			if($type == '收款'){
				$this->assign("actiontype",'已收');
			}
		}else{
			$ViewBaozhangitem = D('ViewBaozhangitem');
			$baozhangitem = $ViewBaozhangitem->where("chanpinID=".$chanpinID)->find();
			
			if($baozhangitem['type'] == '已付项目'){
				$this->assign("actiontype",'已付');
				$this->assign("type",'付款');
			}
			if($baozhangitem['type'] == '已收项目'){
				$this->assign("actiontype",'已收');
				$this->assign("type",'收款');
			}
			$this->assign("chanpin",$baozhangitem);
		}

		
		if($chanpinID){
			$where_e_r['realID'] = $chanpinID;
			$ViewExpectlist = D("ViewExpectlist");
			$expectlist = $ViewExpectlist->where($where_e_r)->select();
			$this->assign("chanpins",$expectlist);
			
			foreach($expectlist as $val){
				$bzdID[] = $val['expectID'];
                $bzID[] = $val['parentID'];
			}
			
            $Baozhang = D('Baozhang');
            $expect_baozhang = $Baozhang->where(array('chanpinID'=>array('IN',$bzID)))->select();
            foreach($expect_baozhang as $val){
                $bz[$val['chanpinID']] = $val['title'];
            }
            $this->assign('bz',$bz);
            
			$where_e_r['expectID'] = array('IN',$bzdID);
			$er = D("Expect_real");
			$money_flow = $er->field("expectID,SUM(money) as money")->where($where_e_r)->group('expectID')->select();
			foreach($money_flow as $val){
				$money[$val['expectID']] = $val['money'];
			}
			$this->assign('money',$money);
		}
		
		
		
		$this->display();
	}
	
	
	public function selectbox(){
	
		isset($_REQUEST['title']) ? $where['title'] = array('LIKE',"%".$_REQUEST['title']."%") : ''; 

		$where['status_system'] = 1;
		
		$order = 'time desc';
		
		$ViewBaozhang = D('ViewBaozhang');
		
		$ViewBaozhangitem = D('ViewBaozhangitem');
		
		$baozhanglist = $ViewBaozhang->where($where)->order($order)->select();
		foreach ($baozhanglist as $val){
			$bzid[] = $val['chanpinID'];
			$bzd[$val['chanpinID']] = $val['title'];
		}

		$where_bzd['status_system'] = 1;
		$where_bzd['parentID'] = array('IN',$bzid);
		
		$type = $_REQUEST['type'];
		if($type=='收款') {
			$where_bzd['type'] = '结算项目';
			$table_expect = '应收';
			$table_real = '已收';
		}
		if($type=='付款') {
			$where_bzd['type'] = '支出项目';
			$table_expect = '应付';
			$table_real = '已付';
		}
		
		import("@.ORG.Page");
		$count = $ViewBaozhangitem->where($where_bzd)->count();
		$p= new Page($count,30);
		$page = $p->show();
		
		$chanpin = $ViewBaozhangitem->where($where_bzd)->order('time desc')->limit($p->firstRow.','.$p->listRows)->select();

		foreach($chanpin as $val){
			$bzdID[] = $val['chanpinID'];
		}
		
		
		$where_e_r['expectID'] = array('IN',$bzdID);
		$er = D("Expect_real");
		$money_flow = $er->field("expectID,SUM(money) as money")->where($where_e_r)->group('expectID')->select();
		foreach($money_flow as $val){
			$money[$val['expectID']] = $val['money'];
		}

		$this->assign('bzd',$bzd);
		$this->assign('page',$page);
		$this->assign('chanpin',$chanpin);
		$this->assign('money',$money);

		$this->assign('table_expect',$table_expect);
		$this->assign('table_real',$table_real);

		$this->display();
	}
	
	
	public function dopost_selectbox(){
		
		if($_REQUEST['expectIDs'])	$expectIDs = explode(',',$_REQUEST['expectIDs']);
		if($_REQUEST['moneys'])		$moneys = explode(',',$_REQUEST['moneys']);
		
		if($_REQUEST['realID'])		$realID = $_REQUEST['realID'];
		else $this->ajaxReturn($_REQUEST, '产品错误！', 0);
		$data['realID'] = $realID;


		$ViewBaozhangitem = D('ViewBaozhangitem');
		$Expect_real = D("Expect_real");
		
		
		$expect_chanpin = $ViewBaozhangitem->where("chanpinID=".$realID)->find();
		if(!$expect_chanpin)	$this->ajaxReturn($_REQUEST, '产品不存在！', 0);
		
		foreach($moneys as $key=>$val){
			$tot_money += $val;
		}
		if($tot_money > $expect_chanpin['value']) $this->ajaxReturn($_REQUEST, '分配价格超过实际价格了！', 0);
		
		
		foreach($expectIDs as $key=>$val){
			
			$expect_chanpin[$key] = $ViewBaozhangitem->where("chanpinID=".$val)->find();
			if(!$expect_chanpin[$key])	$this->ajaxReturn($_REQUEST, '第'.($key+1).'个团队项不存在！', 0);
			
			if($moneys[$key] > $expect_chanpin[$key]['value'])	$this->ajaxReturn($_REQUEST, '第'.($key+1).'个分配价格超过预计价格了！', 0);

			
			$where_e_r['expectID'] = $val;
			$money_flow = $Expect_real->field("expectID,SUM(money) as money")->where($where_e_r)->group('expectID')->find();
			
			if($moneys[$key] > ($expect_chanpin[$key]['value'] - $money_flow['money']))	$this->ajaxReturn($_REQUEST, '第'.($key+1).'个分配价格超过预计价格了！！', 0);
			
			
			
			$data['expectID'] = $val;

			if($Expect_real->where($data)->find())	{
				$data['money'] = $moneys[$key];
				$Expect_real->save($data); 
			}else{
				$data['money'] = $moneys[$key];
				$data['time'] = time();
				$Expect_real->add($data);
			}
		}
		
		
		
		$this->ajaxReturn($_REQUEST, '保存成功！', 1);
	}
	
    public function delete_selectbox(){
        $Expect_real = D("Expect_real");
        
        $where_e_r['expectID'] = $_REQUEST['expectID'];
        $where_e_r['realID'] =  $_REQUEST['realID'];
        
        $Expect_real->where($where_e_r)->delete();
        
        $this->ajaxReturn($_REQUEST, '保存成功！', 1);
    }
    
    
    
}
?>