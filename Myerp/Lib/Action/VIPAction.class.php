<?php

class VIPAction extends CommonAction{
	
    public function _myinit() {
        if (!$this->user)
            redirect(SITE_INDEX.'Index/index');
		$this->assign("navposition",'会员管理');
		if($this->user['title'] != 'aaa'){
			$role = A("Method")->_checkRolesByUser('业务','银行',1);
			if(!$role){
				$this->display('Index:error');
				exit;
			}
		}
	}
	
	
    public function index() {
		A("Method")->showDirectory("会员列表");
                
                $where['telnum'] = array('gt',0);
                if($_GET['title']) $where['name'] = array('LIKE','%'.$_GET['title'].'%');
                
                $Datacd = D("Datacd");
                import("@.ORG.Page");
                C('PAGE_NUMBERS',50);
		$count = $Datacd->where($where)->count();
		$pagenum = 50;
		$p= new Page($count,$pagenum);
		$page = $p->show();
                $list = $Datacd->where($where)->limit($p->firstRow.','.$p->listRows)->select();
		$data['list'] = $list;
		$data['page'] = $page;
		$this->assign("data",$data);
                dump($where);
                dump($data);
                dump($Datacd);
                
		$this->display('index');
    }
	
    public function uploadHistory() {
		$this->assign("navposition",'信息');
		A("Method")->showDirectory("上传记录查询");
		$ViewVIPRecord = D("ViewVIPRecord");
		$where['user_name'] = $this->user['title'];
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $ViewVIPRecord->where($where)->count();
		$pagenum = 20;
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $list = $ViewVIPRecord->where($where)->limit($p->firstRow.','.$p->listRows)->select();
		$data['list'] = $list;
		$data['page'] = $page;
		$this->assign("data",$data);
		$this->display('uploadHistory');
    }
	
	
	//获得记录
    public function bankFileUpload() {
		$this->assign("navposition",'信息');
		A("Method")->showDirectory("消费记录上传");
		$this->assign('dopostpath','dopost_bankFileUpload');
		$this->display('bankfileupload');
    }
	
	
	//获得记录
    public function dopost_bankFileUpload() {
		C('TOKEN_ON',false);
		//检查并上传备份
		$sheetData = A("Method")->_check_bankfile('消费');
		if($sheetData){
			//解析
			$ViewDepartment = D("ViewDepartment");
			$ComID = A("Method")->_getComIDbyUser();
			$company = $ViewDepartment->where("`systemID` = '$ComID'")->find();
			$consume['consume']['bank_type'] = $company['title'];
			$ViewVIPConsume = D("ViewVIPConsume");
			$VIP = D("VIP");
			$VIP->startTrans();
			foreach($sheetData as $v){
				$consume['consume']['cardNo'] = $v['A'];
				$consume['consume']['name'] = $v['B'];
				$consume['consume']['IDtype'] = $v['C'];
				$consume['consume']['IDNo'] = $v['D'];
				$consume['consume']['transactionNo'] = $v['E'];
				$consume['consume']['consumeAmount'] = $v['F'];
				$consume['consume']['consumeTime'] = $v['G'];
				$consume['consume']['posID'] = $v['H'];
				//对比
				$where['cardNo'] = $consume['consume']['cardNo'];
				$where['consumeAmount'] = $consume['consume']['consumeAmount'];
				$where['consumeTime'] = $consume['consume']['consumeTime'];
				$where['posID'] = $consume['consume']['posID'];
				$tc = $ViewVIPConsume->where($where)->find();
				if($tc)
					continue;
				if(false === $VIP->relation("consume")->myRcreate($consume)){
					$VIP->rollback();
					A("Method")->ajaxUploadResult($_REQUEST,'解析失败！',0);
				}
			}
			$VIP->commit();
			A("Method")->ajaxUploadResult($_REQUEST,'上传成功',1);
		}
		else
			A("Method")->ajaxUploadResult($_REQUEST,'上传失败！',0);
    }
	
	
	
	public function left($htmltp='',$pagetype='') {
		$this->assign("pagetype",$pagetype);
		$this->display('VIP:'.$htmltp);
	}
	
	
	
	//获得记录
    public function memberFileUpload() {
		$this->assign("navposition",'信息');
		A("Method")->showDirectory("会员清单上传");
		$this->assign('dopostpath','dopost_memberFileUpload');
		$this->display('bankfileupload');
    }
	
	
	//获得记录
    public function dopost_memberFileUpload() {
		C('TOKEN_ON',false);
		//检查并上传备份
		$sheetData = A("Method")->_check_bankfile('会员');
		if($sheetData){
			//解析
			$ViewDepartment = D("ViewDepartment");
			$ComID = A("Method")->_getComIDbyUser();
			$company = $ViewDepartment->where("`systemID` = '$ComID'")->find();
			$member['member']['bank_type'] = $company['title'];
			$ViewVIPMember = D("ViewVIPMember");
			$ViewVIPCard = D("ViewVIPCard");
			$VIP = D("VIP");
			$VIP->startTrans();
			foreach($sheetData as $v){
				$member['member']['cardNo'] = $v['A'];
				$member['member']['name'] = $v['B'];
				$member['member']['sex'] = $v['C'];
				$member['member']['IDtype'] = $v['D'];
				$member['member']['IDNo'] = $v['E'];
				$member['member']['tel'] = $v['F'];
				$member['member']['birthday'] = $v['G'];
				$member['member']['datatext'] = serialize($member['member']);
				//对比,姓名电话，卡号姓名，卡号电话，两项匹配确定老用户。
				$cardNo = $member['member']['cardNo'];
				$name = $member['member']['name'];
				$tel = $member['member']['tel'];
				$where_m = "(`cardNo` = '$cardNo' AND `name` = '$name') OR (`cardNo` = '$cardNo' AND `tel` = '$tel') OR (`name` = '$name' AND `tel` = '$tel')";
				$tc = $ViewVIPMember->where($where_m)->find();
				if($tc){
					$where_m = "`cardNo` = '$cardNo' AND `name` = '$name' AND `tel` != '$tel'";
					$n_tc = $ViewVIPMember->where($where_m)->find();
					$tc['cardNo'] = $member['member']['cardNo'];
					$tc['tel'] = $member['member']['tel'];
					$ViewVIPMember->save($tc);//更新
					if($n_tc)//更新电话后下一循环
						continue;
					$vipID = $tc['vipID'];
				}else{
					if(false === $VIP->relation("member")->myRcreate($member)){
						$VIP->rollback();
						A("Method")->ajaxUploadResult($_REQUEST,'解析失败！',0);
					}
					$vipID = $VIP->getRelationID();
				}
				//更新卡表
				$where_card['parentID'] = $vipID;
				$where_card['bank_type'] = $member['member']['bank_type'];
				$where_card['cardNo'] = $member['member']['cardNo'];
				$tc_c = $ViewVIPCard->where($where_card)->find();
				if(!$tc_c){
					$card['parentID'] = $where_card['parentID'];
					$card['card']['bank_type'] = $where_card['bank_type'];
					$card['card']['cardNo'] = $where_card['cardNo'];
					$card['status'] = '当前卡';
					//重置卡状态
					unset($where_card['cardNo']);
					$cardlist = $ViewVIPCard->where($where_card)->findall();
					foreach($cardlist as $vol){
						$recard['vipID'] = $vol['vipID'];
						$recard['status'] = '失效卡';
						if(false === $VIP->save($recard)){
							$VIP->rollback();
							A("Method")->ajaxUploadResult($_REQUEST,'卡状态重置失败！',0);
						}
					}
					if(false === $VIP->relation("card")->myRcreate($card)){
						$VIP->rollback();
						A("Method")->ajaxUploadResult($_REQUEST,'卡号保存失败！',0);
					}
				}
			}
			$VIP->commit();
			A("Method")->ajaxUploadResult($_REQUEST,'上传成功',1);
		}
		else
			A("Method")->ajaxUploadResult($_REQUEST,'上传失败！',0);
		
	}
		

		
		
		
	
}
?>
