<?php

class TuanchangeAction extends CommonAction{


    public function userlist() {
		$navlist = "团队管理 > 团队平移 > 团队平移";
		$this->assign('navlist',$navlist);
		
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
		
		$userAll_left = $Glkehu->where($wheres1)->findall();
		$userAll_right = $Glkehu->where($wheres2)->findall();
		
        $this->assign('userAll_left',$userAll_left);
		$this->assign('userAll_right',$userAll_right);
		$this->assign('left_keyword',$left_keyword);
		$this->assign('right_keyword',$right_keyword);
        $this->display();
		
    }

	

	

    public function tuanlist() {
		$navlist = "团队管理 > 团队平移 > 团队列表";
		$this->assign('navlist',$navlist);
		$DJtuan = D('dj_tuan');
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'rightusername')
			break;
			if($key == 'leftusername'){
			$condition['adduser'] =  $value;
			break;
			}
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
        $tuanAll = $DJtuan->where($condition)->order("time DESC")->findall();
		$this->assign('tuanAll',$tuanAll);
		
		$Glkehu = D("Glkehu");
		$leftuser = $Glkehu->where("`user_name` = '$_GET[leftusername]'")->find();
		$rightuser = $Glkehu->where("`user_name` = '$_GET[rightusername]'")->find();
		$this->assign('leftuser',$leftuser);
		$this->assign('rightuser',$rightuser);
		
		$this->display();
		
	}



    public function dopostzhuanyi() {

		$postdata = $_POST;
		
		$DJtuan = D('dj_tuan');
		foreach($postdata['itemlist'] as $id)
		{
			$tuan['djtuanID'] = $id;
			$tuan['adduser'] = $postdata['rightusername'];
			$DJtuan->save($tuan);
		}
		
		$rurl = SITE_DIJIE."Tuanchange/tuanlist/leftusername/".$postdata['leftusername']."/rightusername/".$postdata['rightusername'];
		doalert('转移成功',$rurl);

    }















}
?>