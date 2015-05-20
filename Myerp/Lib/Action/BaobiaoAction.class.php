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
			foreach($baozhangitemlist as $val){
				if($val['type'] == '结算项目') {
					$chanpin[$val['parentID']]['yingshou'] += $val['value'];
					$chanpin[$val['parentID']]['yingshourenshu'] += $val['renshu'];
				}
				else if($val['type'] == '支出项目') {
					$chanpin[$val['parentID']]['yingfu'] += $val['value'];
					$chanpin[$val['parentID']]['yingfurenshu'] += $val['renshu'];
				}
				else if($val['type'] == '已收项目') {
					$chanpin[$val['parentID']]['yishou'] += $val['value'];
					$chanpin[$val['parentID']]['yishourenshu'] += $val['renshu'];
				}
				else if($val['type'] == '已付项目') {
					$chanpin[$val['parentID']]['yifu'] += $val['value'];
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
	
	
	
	
}
?>