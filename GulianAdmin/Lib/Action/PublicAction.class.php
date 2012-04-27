<?php

class PublicAction extends Action{

    public function index() {
        $this->display();
    }


    public function newsnoticelist() {
		$navlist = "新闻公告";
		$this->assign('navlist',$navlist);
		
		//按部门接收公告
//		$glkuhu = D('Glkehu');
//		$condition_user['user_name'] = $this->roleuser[user_name];
//		$condition_user['usertype'] = '系统用户';
//		$systemuser = $glkuhu->where($condition_user)->find();
//		$glbasedata = D('Glbasedata');
//		$mydepartment = $glbasedata->where("`id` = '$systemuser[department]'")->find();
//		$condition['jieshoutype'] = array('like','%'.$mydepartment['title'].'%');
		
		//$condition['jieshoutype'] = array('like','%'.$this->my_department['title'].'%');
		
		//按部门和人接收

		$condition['jieshoutype'] = array('exp','LIKE "%'.$this->my_department['title'].'%" OR `jieshouname` = "'.$this->roleuser['user_name'].'"');

		
		
		$glmessage = D('glnews');
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			{			
			$this->assign($key,$value);
			break;
			}
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		$condition['type'] = '新闻公告';
		
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',30);
		$count = $glmessage->where($condition)->count();
		$p= new Page($count,20);
		$page = $p->show();
		//dump($condition);
        $messageAll = $glmessage->where($condition)->order("messageID desc")->limit($p->firstRow.','.$p->listRows)->select();
		
		$this->assign('page',$page);
		$this->assign('messageAll',$messageAll);
		//提示窗口
        //$popnotice = Cookie::set('popnotice','1',45000);
        $popnotice = Cookie::get('popnotice');
		
		//
		$where['type'] = '审核记录';
		$where['status'] = '提示';
		
		$adminlevel = $this->adminuser['adminlevel'];
		$roles = explode(',',$adminlevel);
		if(count($roles) > 1)
		{
//			foreach($roles as $v){
//				if($rl)
//				$rl .= " like '%".$v."%'";
//				else
//				$rl .= " or `jieshoutype` like '%".$v."%'";
//			}
//			$where['jieshoutype'] = array('exp',$rl);
		}
		else
			$where['jieshoutype'] = '';
		
		//查询已读表
		$mes_read = D("glmes_read");
		$read_where['uid'] = $this->roleuser['user_id'];
		$reads = $mes_read->where($read_where)->field('messageID')->findall();
		foreach($reads as $key => $mes){
			if($key == '0') $mes_id = $mes['messageID'];
			else $mes_id .= ','.$mes['messageID'];
		}
		if($mes_id)	$where['messageID'] = array('NOT IN',$mes_id);
		
		$_3today =  date('Y-m-d',time() - 1 * 24* 60 * 60);
		
		$date_time = $_3today;
		if($date_time)
		{
			//$where['time'] = array(array('egt',strtotime($date_time)),array('elt',strtotime($date_time.' 23:59:59')));
			$where['time'] = array('egt',strtotime($date_time));
		}
		
		$wheres = $where;
		
		$message_zituan_xianlu = D("message_zituan_xianlu");
		if(!checkByAdminlevel('财务操作员,网管,总经理',$this))
		{
			$where = listmydepartment_msg($this,$where);
			
			$messageAll_zituan = $message_zituan_xianlu->where($where)->order("time DESC")->findall();
			
			$wheres = listmydepartment_msg($this,$wheres,'departmentID_xl','user_name_xl');

			$messageAll_xianlu = $message_zituan_xianlu->where($wheres)->order("time DESC")->findall();
			$t = count($messageAll_zituan);
			foreach($messageAll_xianlu as $v)
			{
				$messageAll_zituan[$t] = $v;
				$t++;
			}
			$messageAll_gp = $messageAll_zituan;
		}
		else
			$messageAll_gp = $message_zituan_xianlu->where($where)->order("time DESC")->findall();
			
		
		$rolelist = array('门市操作员','地接操作员','计调操作员','计调经理','财务操作员','网管','总经理','联合体成员');
		//$rolelist = array('计调经理');
		$this->assign('rolelist',$rolelist);
		$i = 0;
		foreach($messageAll_gp as $v)
		{
			foreach($rolelist as $ro)
			{
				if(count(explode($ro,$v['jieshoutype'])) > 1)
				$noticelist[$ro][$v['tablename']][$i] = $v;
			}
			$i++;
		}
		$this->assign('noticelist',$noticelist);
		
		//dump($noticelist['计调经理']);
//		if($popnotice)
//		{
//			foreach($noticeAll as $tem){
//				if(!empty($tem)){
//					$popnotice = 2 ;
//					break;
//				}
//			}
//			if($popnotice != 2)
//			$popnotice = null;
//			else
//			$popnotice = 1;
//		}
		$this->assign('popnotice',$popnotice);
        Cookie::delete ('popnotice');
		
		$this->display();
		
		
		
		
    }

	public function noticeignore()
	{
/*		$glmessage = D('glmessage');
		$message['messageID'] = $_GET['messageID'];
		$message['status'] = '已忽略';
		$glmessage->save($message);	*/
		
		
		//添加进已读表
		$glmessage = D('glmes_read');
		$message['messageID'] = $_GET['messageID'];
		$message['uid'] = $this->roleuser['user_id'];
		$glmessage->add($message);	
		
		
		//echo json_encode(array ('messageID'=>$_GET['messageID']));

	}




	public function newsnotice()
	{
		$navlist = "新闻公告";
		$this->assign('navlist',$navlist);
		
		$glkehu = D("glkehu");
		$userAll = $glkehu->findall();
		$this->assign('userAll',$userAll);
		
		$messageID = $_GET['messageID'];
		$glmessage = D("glnews");
		$message = $glmessage->where("`messageID` = '$messageID'")->find();
		$this->assign('newsnotice',$message);
		
		$this->display();
		
	}


	public function ajax_news()
	{
		$date_time = $_POST['date_time'];
		$names = $_POST['names'];
		$type = $_POST['type'];
		if ($type == 'line'){
			$where['tablename'] = '线路';
			$types = '线路';
		}
		elseif ($type == 'dingdan'){
			$where['tablename'] = '订单';
			$types = '订单';
		}
		elseif ($type == 'baozhang'){
			$where['tablename'] = '报账单';
			$types = '报账单';
		}
		else{
			echo "false";
			exit;
		}
		if($names)
			$where['content'] = array('like',"%".$names."%");
		if($date_time)
			$where['time'] = array(array('egt',strtotime($date_time)),array('elt',strtotime($date_time.' 23:59:59')));
		
		$where['type'] = '审核记录';
		$where['status'] = '提示';
		
		$adminlevel = $this->adminuser['adminlevel'];
		$roles = explode(',',$adminlevel);
		if(count($roles) > 0)
		{
/*			foreach($roles as $v){
				if($rl)
				$rl .= " or `jieshoutype` like '%".$v."%'";
				else
				$rl = "like '%".$v."%'";
			}
			$where['jieshoutype'] = array('exp',$rl);*/
		}
		else
			$where['jieshoutype'] = '';
			
		
		//查询已读表
/*		$mes_read = D("glmes_read");
		$read_where['uid'] = $this->roleuser['user_id'];
		$reads = $mes_read->where($read_where)->field('messageID')->findall();
		foreach($reads as $key => $mes){
			if($key == '0') $mes_id = $mes['messageID'];
			else $mes_id .= ','.$mes['messageID'];
		}
		if($mes_id)	$where['messageID'] = array('NOT IN',$mes_id);*/
		
		$wheres = $where;
		
		$message_zituan_xianlu = D("message_zituan_xianlu");
		if(!checkByAdminlevel('财务操作员,网管,总经理',$this))
		{
			$where = listmydepartment($this,$where);
			$messageAll_zituan = $message_zituan_xianlu->where($where)->order("time DESC")->findall();
			
			$wheres = listmydepartment($this,$wheres,'departmentID_xl','user_name_xl');
			$messageAll_xianlu = $message_zituan_xianlu->where($wheres)->order("time DESC")->findall();
			$t = count($messageAll_zituan);
			foreach($messageAll_xianlu as $v)
			{
				$messageAll_zituan[$t] = $v;
				$t++;
			}
			$messageAll_gp = $messageAll_zituan;
		}
		else
			$messageAll_gp = $message_zituan_xianlu->where($where)->order("time DESC")->findall();
				
		
		$rolelist = array('门市操作员','地接操作员','计调操作员','计调经理','财务操作员','网管','总经理','联合体成员');
		$this->assign('rolelist',$rolelist);
		$i = 0;
		foreach($messageAll_gp as $v)
		{
			foreach($rolelist as $ro)
			{
				if(count(explode($ro,$v['jieshoutype'])) > 1)
				$noticelist[$ro][$v['tablename']][$i] = $v;
			}
			$i++;
		}
		
		$this->assign('types',$types);
		$this->assign('noticelist',$noticelist);

		$this->display();
		
	}


	public function makepub($xianluID)
	{
		
		$glxianlu = D("glxianlu");
		$xianlu = $glxianlu->where("`xianluID` = '$xianluID'")->find();
		if(!$xianlu)
			return false;
		$glkehu = D("glkehu");
		$kehuuser = $glkehu->where("`user_name` = '$xianlu[user_name]'")->find();
		if(!$kehuuser){
			return false;
		}
		$gllvxingshe = D("gllvxingshe");
		$company = $gllvxingshe->where("`lvxingsheID` = '$kehuuser[lvxingsheID]'")->find();
		if(!$company){
			return false;
		}
		
		$glxianlujiage = D("glxianlujiage");
		$xianlujiage = $glxianlujiage->where("`xianluID` = '$xianluID'")->find();
		if(!$xianlujiage)
			return false;
		
		$glshoujia = D("glshoujia");
		$jiage = $glshoujia->where("`jiageID` = '$xianlujiage[jiageID]'")->find();
		if(!$jiage)
			return false;
			
			
		$Dedeaddonarticle = D("Dedeaddonarticle");
		$ishas = $Dedeaddonarticle->where("`xianluID` = '$xianluID'")->find();
		
		$Dedearchives = D("Dedearchives");
		
		$insert['title'] = $xianlu['mingcheng'];
		$insert['shorttitle'] =  $xianlu['mingcheng'];//简略标题
		$insert['writer'] =  $kehuuser['realname'];
		$insert['source'] =  $company['companyname'];
		$insert['keywords'] = $xianlu['guanjianzi'];
		$insert['description'] = $xianlu['xingchengtese'];
		
		if($xianlu['guojing'] == '境外')
		$insert['typeid'] =  2;//请选择栏目
		else
		$insert['typeid'] =  3;//请选择栏目
		
		$insert['typeid2'] =  0;//默认0
		$insert['sortrank'] =  time();//大概是time
		$insert['flag'] =  'p';//标记
		$insert['ismake'] =  1;//生成HTML 1/仅动态浏览 -1
		$insert['channel'] =  20;//频道id
		$insert['atcrank'] =  0;
		$insert['click'] = rand(50,150);
		$insert['money'] = 0;
		$insert['color'] =  '';
		$insert['litpic'] =  '';
		$insert['pubdate'] =  time();
		$insert['senddate'] =  time();
		$insert['mid'] =  2;//默认1
		$insert['lastpost'] = time();
		$insert['scores'] = 0;//默认0
		$insert['goodpost'] = 0;//默认0
		$insert['badpost'] = 0;//默认0
		$insert['voteid'] = 0;//默认0
		$insert['notpost'] = 0;//默认0
		$insert['filename'] = '';
		$insert['dutyadmin'] = 2;
		$insert['tackid'] = 0;
		$insert['mtype'] = 0;
		$insert['weight'] = 100;//默认100
		
		if($ishas){
			$insert['id'] = $ishas['aid'];
			$Dedearchives->save($insert);
		}else{
			$last = $Dedearchives->order('id desc')->find();
			$insert['id'] = $last['id']+1;
			$archiveID = $insert['id'];
			$Dedearchives->add($insert);
		}
		
		//附加表
		$insertext['body'] =  $xianlu['xingcheng'];
		$insertext['luxianming'] =  $insert['title'];//路线名
		$insertext['jiage'] =  $jiage['chengrenshoujia'];//优惠价格
		$insertext['jingguo'] =  '略';//经过线路
		//$insertext['ctrq'] =  $xianlu['chutuanriqi'];//出团日期
		$insertext['ctrq'] =  '电话咨询';//出团日期
		
		//图片
		$scenicspot = D('scenicspot');
		$tupianAll = split('[,]',$xianlu['tupian']);
		$i=0;
		
		$piclist .= "{dede:pagestyle value='11'/}";
		
		foreach($tupianAll as $tupian){
			$xianlu['tupianAll'][$i] = $scenicspot->where("`title` = '$tupian'")->find();
			$piclist .= "{dede:img text='".$tupian."' }".SITE_DATA."/attachments/".$xianlu['tupianAll'][$i]['url']."{/dede:img}";
			$i++;
		}
		$insertext['jdtpic'] =  $piclist;//景点图
		$insertext['newpics'] =  $piclist;//景点图
		$insertext['jp'] =  $xianlu['cantuanxuzhi'];;//价格内容,说明须知
		
		$insertext['xianluID'] =  $xianluID;//线路ID
		$insertext['aid'] =  $archiveID;//文章ID
		$insertext['typeid'] =  $insert['typeid'];//模板12?
		$insertext['redirecturl'] =  '';//默认空
		$insertext['templet'] =  '';//默认空
		$insertext['userip'] =  '127.0.0.1';//默认
		if($ishas){
			$insertext['aid'] = $ishas['aid'];
			$Dedeaddonarticle->save($insertext);
		}
		else
			$Dedeaddonarticle->add($insertext);
		
		$Dedearctiny = D("Dedearctiny");
		
		$inserttiny['id'] =  $archiveID;//文章ID
		$inserttiny['typeid'] =  $insert['typeid'];//模板12?
		$inserttiny['typeid2'] =  $insert['typeid2'];
		$inserttiny['arcrank'] =  0;//默认0
		$inserttiny['channel'] =  $insert['channel'];
		$inserttiny['senddate'] =  $insert['senddate'];
		$inserttiny['sortrank'] =  $insert['sortrank'];
		$inserttiny['mid'] =  $insert['mid'];
		
		if($ishas){
			$inserttiny['id'] = $ishas['aid'];
			$Dedearctiny->save($inserttiny);
		}
		else
			$Dedearctiny->add($inserttiny);
			
		return true;	
		
	}
	


	public function cancelpub($xianluID)
	{
		$Dedeaddonarticle = D("Dedeaddonarticle");
		$ishas = $Dedeaddonarticle->where("`xianluID` = '$xianluID'")->find();
		$id = $ishas['aid'];
		$Dedeaddonarticle->where("`aid` = '$id'")->delete();
		$Dedearchives = D("Dedearchives");
		$Dedearchives->where("`id` = '$id'")->delete();
		$Dedearctiny = D("Dedearctiny");
		$Dedearctiny->where("`id` = '$id'")->delete();
		return true;
	}



	public function domakepub()
	{
		$glxianlu = D("glxianlu");
		//调用函数内记录功能
//		if(!checkByAdminlevel('',$this)){
//			$position = $_SERVER["PATH_INFO"];
//			$this->display('Error/notopen');
//			exit;
//		}
		
		$postdata = $_POST;
		$xianlulist = $postdata['itemlist'];
		if(!$xianlulist)
		{
			if($postdata['forward'])
			$rurl = $postdata['forward'];
//			else
//			$rurl = SITE_ADMIN."Chanpin/sankechanpin";
			doalert('没有选择',$rurl);
		}
		
		
		foreach($xianlulist as $xianluID)
		{
			
			$xianlu = $glxianlu->where("`xianluID` = '$xianluID'")->find();
			if($xianlu['zhuangtai'] != '报名'){
				doalert('线路必须在报名状态','');
			}
			
			if($_GET['type'] == '发布'){
			$getback = A("Public")->makepub($xianluID);	
			$xianlu['ispub'] = '已发布';
			$glxianlu->save($xianlu);
			$notice = '网站信息发布，并更新成功';
			}
			
			if($_GET['type'] == '删除'){
			$getback = A("Public")->cancelpub($xianluID);
			$xianlu['ispub'] = '未发布';
			$glxianlu->save($xianlu);
			$notice = '网站信息删除，并更新成功';
			}
			if($getback == false){
				//doalert('产生错误',SITE_ADMIN."Chanpin/sankechanpin");
				$notice = '更新网站';
				
			}
		}
		
//		$host = 'http://test.we54.com/dedecms5.7/dede/';
		$host = 'http://www.dlgulian.com/uploads/dede/';
		$templet = 'default/index.htm';
		$position = '../index.html';
		
		//$runphp = $host.'updatehomepage_addbygaopeng.php?templet='.$templet.'&position='.$position.'&notice='.$notice;
		$runphp = $host.'makehtml_list_action_update_gaopeng.php?typeid=3&maxpagesize=50&upnext=1'.'&notice='.$notice;
		
		tiaozhuan($runphp);
		
	}	
	
	
	
	public function orderticket(){
		
		$xianluID = $_GET['xianluID'];
		$glxianlu = D('glxianlu');
		$xianlu = $glxianlu->where("`xianluID` = '$xianluID'")->find();
        $this->assign('xianlu',$xianlu);
		
		//售价
		$Glxianlujiage = D("Glxianlujiage");
		$xianlujiage = $Glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
		$xianluAll[$k]['chengbenman'] = $xianlujiage['chengrenzongjia'];
		$xianluAll[$k]['chengbenchild'] = $xianlujiage['ertongzongjia'];
		
		//价格
		$Glshoujia = D("Glshoujia");
		$shoujia = $Glshoujia->where("`dailileixing` = '全部' and `jiageID` = '$xianlujiage[jiageID]'")->find();
        $this->assign('shoujia',$shoujia);
		
		$gllvxingshe = D('gllvxingshe');
		$company = $gllvxingshe->where("`lvxingsheID` = '$xianlu[lvxingsheID]'")->find();
        $this->assign('company',$company);
		//if($company)
		
//		if(!$xianlu){
//			justalert('发生错误，线路不存在请稍候再试');
//			gethistoryback();
//		}
		
		$glzituan = D('glzituan');
		$zituanAll = $glzituan->where("`xianluID` = '$xianluID'")->findAll();
		$k = 0;
		foreach($zituanAll as $zituan){
				//子团售价修正
				$chengrenshoujia = $shoujia['chengrenshoujia'] + $zituan['adultxiuzheng'];
				$ertongshoujia = $shoujia['ertongshoujia'] + $zituan['childxiuzheng'];
				$zituanAll[$k]['chengrenshoujia'] = $chengrenshoujia;
				$zituanAll[$k]['ertongshoujia'] = $ertongshoujia;
				//剩余名额
				$Gltuanyuan = D("tuanyuan_dingdan");
				$tuanyuanrenshu = $Gltuanyuan->execute('select * from gltuanyuan where zituanID = '.$zituan['zituanID']);
				$shengyu = $zituan['renshu'] - $tuanyuanrenshu;
				//$zituanAll[$xianlu['xianluID'].$y.$m.$d]['shengyu'] = $shengyu;
				$zituanAll[$k]['shengyu'] = $shengyu;
				$k ++;
		}
        $this->assign('zituanAll',$zituanAll);
		
		
		//dump($shoujia['chengrenshoujia']);
//		
//		if(!checkByAdminlevel('',$this)){
//			$position = $_SERVER["PATH_INFO"];
//			$this->display('Error/notopen');
//			exit;
//		}
		
		$roleuser = $this->roleuser;
        $this->assign('roleuser',$roleuser);
		
        $this->display('tempbuycar');
		
		
	}
	
	
	
	function doselectmath()
	{
		$zituan_xianlu = D('zituan_xianlu');
		$zituan = $zituan_xianlu->where("`zituanID` = '$_POST[zituanID]'")->find();
		//售价
		$Glxianlujiage = D("Glxianlujiage");
		$xianlujiage = $Glxianlujiage->where("`xianluID` = '$zituan[xianluID]'")->find();
		//价格
		$Glshoujia = D("Glshoujia");
		$shoujia = $Glshoujia->where("`dailileixing` = '全部' and `jiageID` = '$xianlujiage[jiageID]'")->find();
		//子团售价修正
		$chengrenshoujia = $shoujia['chengrenshoujia'] + $zituan['adultxiuzheng'];
		$ertongshoujia = $shoujia['ertongshoujia'] + $zituan['childxiuzheng'];
		//剩余名额
		$Gltuanyuan = D("tuanyuan_dingdan");
		$tuanyuanrenshu = $Gltuanyuan->execute('select * from gltuanyuan where zituanID = '.$zituan['zituanID']);
		$shengyu = $zituan['renshu'] - $tuanyuanrenshu;
		echo '{ "chengrenjia": "'.$chengrenshoujia.'","ertongjia": "'.$ertongshoujia.'","shengyu": "'.$shengyu.'"}';
		
	}
	
	
	
    public function baoming() {
		$zituanID = $_GET['zituanID'];
		$crnum = $_GET['crnum'];
		$etnum = $_GET['etnum'];
        $this->assign('crnum',$crnum);
        $this->assign('etnum',$etnum);
		
		$zituan_xianlu = D("zituan_xianlu");
		$zituan = $zituan_xianlu->where("`zituanID` = '$zituanID'")->find();
        $this->assign('zituan',$zituan);
		
		$gllvxingshe = D("gllvxingshe");
		$company = $gllvxingshe->where("`lvxingsheID` = '$zituan[lvxingsheID]'")->find();
        $this->assign('thecompany',$company);
		
		$Glxianlujiage = D("Glxianlujiage");
		$xianlujiage = $Glxianlujiage->where("`xianluID` = '$zituan[xianluID]'")->find();
		//价格
		$Glshoujia = D("Glshoujia");
		$shoujia = $Glshoujia->where("`dailileixing` = '全部' and `jiageID` = '$xianlujiage[jiageID]'")->find();
		//剩余名额
		$Gltuanyuan = D("tuanyuan_dingdan");
		$tuanyuanrenshu = $Gltuanyuan->execute('select * from gltuanyuan where zituanID = '.$zituanID);
		$shengyu = $zituan['renshu'] - $tuanyuanrenshu;
        $this->assign('shengyu',$shengyu);
		//售价
		$chengren_price = $shoujia['chengrenshoujia'] + $zituan['adultxiuzheng'];
		$ertong_price = $shoujia['ertongshoujia'] + $zituan['childxiuzheng'];
		$cut = $shoujia['cut'];
        $this->assign('chengren_price',$chengren_price);
        $this->assign('ertong_price',$ertong_price);
		
		//结算价
		$jiesuan = $crnum * $chengren_price + $etnum * $ertong_price;
        $this->assign('jiesuan',$jiesuan);
		
        $this->display();
    }
	
    public function verify() {  
            import("ORG.Util.Image");  
            Image::buildImageVerify();  
    } 	

	
	
	public function leaderpaituan()
	{
		$navlist = "领队排团表";
		$this->assign('navlist',$navlist);
		
		$glbasedata = D("glbasedata");
		
		$condition['type'] = '排团表';
		
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		$count = $glbasedata->where($condition)->count();
		$p = new Page ( $count, 10 ); 
		$datalist=$glbasedata->limit($p->firstRow.','.$p->listRows)->where($condition)->order('value desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Systemguanli/leaderpaituan/p/');
        $this->assign ( "page", $page );
        $this->assign ( "datalist", $datalist );
		
		
        $this->display();
		
	}
	
	
	
	public function widget()
	{
		foreach($_GET as $key => $value)
		{
			$data[$key] = $value; 
			$this->assign ( $key, $value );
		}
		
        $Users = D('Users');
		$theuser = $Users->where("`user_name` = '$data[name]'")->find();
        $this->assign ( "theuser", $theuser );
		
        $content = D('content');
		$contentAll = $content->where("`user_id` = '$theuser[user_id]'")->order('posttime desc')->findall();
        $this->assign ( "contentAll", $contentAll );
		
		$ctent=D('Content');
        $this->assign ( "ctent", $ctent );
        $this->display();
		
	}
	
	
	public function widget_userline()
	{
		$gltempmessage = D('gltempmessage');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',30);
		$count = $gltempmessage->where($condition)->count();
		$p= new Page($count,50);
		//$rurl = SITE_ADMIN."Systemguanli/locuslist/p/";
		$page = $p->show();
        $messageAll = $gltempmessage->where($condition)->order("messageID DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		$this->assign('page',$page);
		$this->assign('messageAll',$messageAll);
		
        $this->display();
		
	}
	
	
	public function setLeader()
	{

 			$postdata = $_POST;
			$itemlist = $postdata['itemlist'];
			if(!$itemlist)
			{
				if($postdata['forward'])
				$forward = $postdata['forward'];
				else
				$forward = '';
				doalert('没有选择',$forward);
			}
			$Gltuanyuan = D("gltuanyuan");
			$leader['leader'] = '1';
			foreach($itemlist as $tuanyuanID){
				$Gltuanyuan->where("`tuanyuanID` = '$tuanyuanID'")->save($leader);
			}
			doalert('设置成功',$forward);
		
	}
	
	public function cancerleader()
	{

 			$postdata = $_POST;
			$itemlist = $postdata['itemlist'];
			if(!$itemlist)
			{
				if($postdata['forward'])
				$forward = $postdata['forward'];
				else
				$forward = '';
				doalert('没有选择',$forward);
			}
			$Gltuanyuan = D("gltuanyuan");
			$leader['leader'] = '0';
			foreach($itemlist as $tuanyuanID){
				$Gltuanyuan->where("`tuanyuanID` = '$tuanyuanID'")->save($leader);
			}
			doalert('设置成功',$forward);
		
	}	
	
	//分表
	public function cut_table() {
		exit;
		$glmessage = D("Glmessage");
		$messages = $glmessage->where("jieshoutype <> 'NULL' AND jieshoutype <>''")->findall();
//		dump($messages);
//		exit;

		$glmes_jieshou = D("Glmes_jieshou");
		
		foreach($messages as $mess){
			$jieshous = explode(',',$mess['jieshoutype']);
			foreach($jieshous as $jieshou){
				$data['messageID'] = $mess['messageID'];
				$data['jieshoutype'] = $jieshou;
				$res = $glmes_jieshou->add($data);
				dump($res);
			}
		}
		
		
        $this->display();
    }
	
	
	//审核时间更新
	public function update_time() {
		exit;
		$gl_baozhang = D("Dj_baozhang");
		$baozhangs = $gl_baozhang->where("`financeperson` <> ''")->findall();
		
		$glmessage = D("Glmessage");
		
		foreach($baozhangs as $baozhang){
			$mess = $glmessage->where("`tableID` = '$baozhang[baozhangID]' AND `tablename` = '地接报账单' AND `type` = '审核记录' AND `content` LIKE '%财务通过报账单审核'")->order("messageID DESC")->find();
			$baozhang['caiwu_time'] = $mess['time'];
			$gl_baozhang->save($baozhang);
		}
		
		
        $this->display();
    }

}
?>