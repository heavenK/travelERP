<?php

class MessageAction extends Action{

    public function showmessage() {
		
		foreach($_GET as $key => $value)
		{
			$condition[$key] = array('like','%'.$value.'%');
		}
		
		$Glmessage = D("Glmessage");
		$messageAll = $Glmessage->where($condition)->order('time desc')->findall();
		
        $this->assign('messageAll',$messageAll);
        $this->display();
    }
	
	
	
    public function savemessage($tableID,$tablename,$type,$content,$jieshoutype,$url) {
		
		$companyname = $this->company['companyname'];
		$department = $this->my_department['title'];
		$role = $this->my_role['title'];
		$realname = $this->roleuser['realname'];
		//$content = $companyname.$department.$role.$realname.'：'.$content;
		$content = $department.$role.$realname.'：'.$content;

		$Glmessage = D("Glmessage");
		$msssage['type'] = $type;
		$msssage['content'] = $content;
		$msssage['username'] = $this->roleuser['user_name'];
		$msssage['laiyuan'] = $this->roleuser['lvxingsheID'];
		$msssage['tableID'] = $tableID;
		$msssage['tablename'] = $tablename;
		$msssage['time'] = time();
		$msssage['jieshoutype'] = $jieshoutype;
		$msssage['url'] = $url;
		
		$msssage['departmentName'] = $department;
		$msssage['departmentID'] = $this->my_department['id'];
		
		$messageID = $Glmessage->add($msssage);
		
		//已经进行接受类型拆分 by heavenK
		if($jieshoutype){
			$glmes_jieshou = D("Glmes_jieshou");
			$jieshous = explode(',',$jieshoutype);
			foreach($jieshous as $jieshou){
				$data['messageID'] = $messageID;
				$data['jieshoutype'] = $jieshou;
				$glmes_jieshou->add($data);
			}
		}
		
		$content = 'type='.$msssage['type'].',content='.$msssage['content'].',username='.$msssage['username'].',laiyuan='.$msssage['laiyuan'].',tableID='.$msssage['tableID'].',tablename='.$msssage['tablename'].',time='.$msssage['time']."\r\n";
		writetofilerecord($this,$content);
	}




    public function getxuqiuyingdan($tableID,$tablename,$jieshoutype = "") {
		
		$Glmessage = D("Glmessage");
		if($jieshoutype == "")
		$messageAll = $Glmessage->where("`tableID` = '".$tableID."' and `tablename` = '".$tablename."' and `type` = '需求应答'")->findall();
		else
		$messageAll = $Glmessage->where("`tableID` = '".$tableID."' and `tablename` = '".$tablename."' and `type` = '需求应答' and `jieshoutype` = '".$jieshoutype."'")->findall();
		
		
		$gllvxingshe = D("gllvxingshe");
		$i = 0;
		foreach($messageAll as $v){
			$t =  $gllvxingshe->where("`lvxingsheID` = '$v[laiyuan]'")->find();
			$messageAll[$i]['laiyuan'] = $t['companyname'];
			$i++;
		}
		
		return $messageAll;
	}



    public function dopostxuqiuxinxi() {

		$postdata = $_POST;
		
		$Glmessage = D("Glmessage");
		$msssage['type'] = '需求应答';
		$msssage['content'] = $postdata['content'];
		$msssage['username'] = $this->roleuser['realname'];
		$msssage['laiyuan'] = $this->roleuser['lvxingsheID'];
		$msssage['tableID'] = $postdata['tableID'];
		$msssage['tablename'] = $postdata['tablename'];
		$msssage['jieshoutype'] = $postdata['jieshoutype'];
		$msssage['time'] = time();
		$msssage['departmentName'] = $this->my_department['title'];
		$msssage['departmentID'] = $this->my_department['id'];
		
		$content = 'type='.$msssage['type'].',content='.$msssage['content'].',username='.$msssage['username'].',laiyuan='.$msssage['laiyuan'].',tableID='.$msssage['tableID'].',tablename='.$msssage['tablename'].',time='.$msssage['time'].',jieshoutype='.$msssage['jieshoutype']."\r\n";
		writetofilerecord($this,$content);
		
		$Glmessage->add($msssage);
		
		$rurl = $postdata['forward'];
		tiaozhuan($rurl);

	}





    public function savetempmessage($tableID,$tablename,$type,$content) {

		$Glmessage = D("Gltempmessage");
		$msssage['type'] = $type;
		$msssage['content'] = $content;
		$msssage['username'] = $this->roleuser['user_name'];
		$msssage['laiyuan'] = $this->roleuser['lvingsheID'];
		$msssage['tableID'] = $tableID;
		$msssage['tablename'] = $tablename;
		$msssage['time'] = time();
		$Glmessage->add($msssage);

		writetofile($this);

	}


	//即时消息
	public function news() {
		isset($_POST['type']) ? $type = $_POST['type']:'';
		
		$newsID = Cookie::get('newsID');
		//
		$where['type'] = '审核记录';
		$where['status'] = '提示';
		
		$adminlevel = $this->adminuser['adminlevel'];
		
		//新的接受角色处理 by heavenK
		$glmes_jieshou = D("Glmes_jieshou");
		$where_jieshou['jieshoutype'] = array('IN',$adminlevel);
		$mes_jieshous = $glmes_jieshou->where($where_jieshou)->findall();
		
		foreach($mes_jieshous as $key => $mes){
			if($key == '0') $mes_id1 = $mes['messageID'];
			else $mes_id1 .= ','.$mes['messageID'];
		}
		if($mes_id1)	$where['messageID'] = array('IN',$mes_id1);
		else {
			exit;
		}
		//dump($mes_jieshous);
		
/*		$roles = explode(',',$adminlevel);
		if(count($roles) > 0)
		{
			foreach($roles as $v){
				if($rl)
				$rl .= " or `jieshoutype` like '%".$v."%'";
				else
				$rl = "like '%".$v."%'";
			}
			$where['jieshoutype'] = array('exp',$rl);
		}
		else
			$where['jieshoutype'] = '';*/
			
		
		
		//查询已读表
		$mes_read = D("glmes_read");
		$read_where['uid'] = $this->roleuser['user_id'];
		$reads = $mes_read->where($read_where)->field('messageID')->findall();
		foreach($reads as $key => $mes){
			if($key == '0') $mes_id = $mes['messageID'];
			else $mes_id .= ','.$mes['messageID'];
		}
		if($mes_id)	{
			if($where['messageID'])	$where['messageID'] = array('exp','IN ('.$mes_id1.') AND `messageID` NOT IN ('.$mes_id.')');
			else $where['messageID'] = array('NOT IN',$mes_id);
		}
		$wheres = $where;
		//dump($where);
		//$message_zituan_xianlu = D("message_zituan_xianlu");
		$message = D("Glmessage");
		$message_dingdan = D("message_dingdan");
		$message_xianlu = D("message_xianlu");
		if(!checkByAdminlevel('财务操作员,财务总监,网管,总经理',$this))
		{
			
			$where = listmydepartment($this,$where);
			unset($where['companytype']);
			unset($where['belongID']);
			//dump($where);
			$messageAll_zituan = $message_dingdan->where($where)->limit('0,5')->order("time DESC")->findall();
			$wheres = listmydepartment($this,$wheres,'departmentID_xl','user_name_xl');
			unset($wheres['companytype']);
			unset($wheres['belongID']);
			//dump($wheres);
			$messageAll_xianlu = $message_xianlu->where($wheres)->limit('0,5')->order("time DESC")->findall();
			$t = count($messageAll_zituan);
			foreach($messageAll_xianlu as $v)
			{
				$messageAll_zituan[$t] = $v;
				$t++;
			}
			$noticeAll = $messageAll_zituan;
			//排序	
			for($j=0;$j<10-1;$j++)
				for ($i=1;$i<10-$j;$i++) 
				if ($noticeAll[$i]['time']>$noticeAll[$i-1]['time']) 
				{
					$temp=$noticeAll[$i-1]; 
					$noticeAll[$i-1]=$noticeAll[$i]; 
					$noticeAll[$i]=$temp;
				}
				
			
				
		}
		else
			$noticeAll = $message->where($where)->order("time DESC")->limit('0,10')->findall();
		if('show' == $type){
		}	
		if('getNews' == $type){
			if($noticeAll['0']['messageID'] <= $newsID) {
				echo "false";
				exit;	
			}
		}
		if('showNews' == $type){

			Cookie::set('newsID', $noticeAll['0']['messageID'],LOGIN_TIME);
			echo "success";
			exit;
			
		}
		
		$this->assign('noticeAll',$noticeAll);
        $this->display();
	
	}









}
?>