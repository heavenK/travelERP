<?php

class ChanpinAction extends CommonAction{


    public function navigation() {
		
		//订单审核显示,国内部门不显示
		$department = $this->my_department[title];
		$c = count(explode('国内',$department));
        $this->assign('ds',$c);
		$this->display();
	}
	
    public function leftcontent() {
		
		//查找办事处
		$gllvxingshe = D("Gllvxingshe");
		$lvxingsheall = $gllvxingshe->where("`type` = '办事处'")->findall();
		$this->assign('lvxingsheall',$lvxingsheall);
		
		
		//出境按部门分类
		if(checkByAdminlevel('计调经理,网管,财务操作员,财务总监,总经理',$this)){
			$glbasedata = D("Glbasedata");
			$departmentAll = $glbasedata->where("`type` = '部门' AND `title` LIKE '%出境%'")->order("sort_value desc")->findall();
			foreach($departmentAll as $key => $department){
				$title = str_replace('出境部-','',$department['title']);
				$departmentAll[$key]['title'] = str_replace('部-出境','',$title);
			}
			$this->assign('departmentAll',$departmentAll);
		}
		
		$this->display();
	}

	//散客列表
    public function sankechanpin() {
		//$Glxianlu = D("Glxianlu");
		$Glxianlu = D("xianlu_lvxingshe");
		$Glxianlujiage = D("Glxianlujiage");
		//dump($this);
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'iframe'|| $key == 'pagenum')
			{
				$this->assign($key,$value);
				continue;
			}
			if($key == 'chufariqi' || $key == 'jiezhiriqi'){
				$this->assign($key,$value);
				continue;
			}
			
			if($key == 'zhuangtai' || $value == '全部' )
				$condition['zhuangtai'] = array('in','报名,截止'); 	
			else
				$condition[$key] = array('like','%'.$value.'%');
			
			$this->assign($key,$value);
		}
		
		$start_date = $_GET['chufariqi'];
		$end_date = $_GET['jiezhiriqi'];
		//需要优化！！！by gaoyang
		if ($start_date && $end_date){
			$condition['chutuanriqi'] = array(array('like','%'.$start_date.'%'),array('like','%'.$end_date.'%'),'or');
		}
		elseif ($end_date){
			$condition['chutuanriqi'] = array('like','%'.$end_date.'%'); 	
		}
		elseif ($start_date){
			$condition['chutuanriqi'] = array('like','%'.$start_date.'%'); 	
		}

		$condition = listmydepartment($this,$condition);
		
		//edit by gaopeng 2012 3 7
		if(!$condition['zhuangtai'])
			$condition['zhuangtai'] = array('in','准备,审核不通过,等待审核'); 	
		//end
		
		//同业，办事处相应修改   by gaoyang
/*		if(checkByAdminlevel('办事处管理员',$this)){
			$condition['lvxingsheID']	=	$this->roleuser["lvxingsheID"]; //取得
		}*/
		
		//dump($condition);
		//修改结束 by gaoyang
		
		//搜索结束
		//搜索人员需要
		$glkehu = D('Glkehu');
		$kehu_all = $glkehu->findall();
		$this->assign('kehu_all',$kehu_all);
		
		
		$kind = $_GET['kind'];
		$guojing = $_GET['guojing'];
		$navlist = '线路产品发布 》  '.$_GET['guojing'].' 》  '.$_GET['xianlutype'].' 》 '.$_GET['kind'];
        $this->assign('navlist',$navlist);
		
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $Glxianlu->where($condition)->count();
		
		$pagenum = $_GET['pagenum'];
		if(!$pagenum)
			$pagenum = 20;
		$p= new Page($count,$pagenum);
//		$rurl = SITE_ADMIN."Chanpin/sankechanpin/guojing/".$condition['guojing']."/p/";
		$page = $p->show();
        $xianludatas = $Glxianlu->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		//dump($xianludatas);
		//数据解析
		$i = 0;
		foreach($xianludatas as $xianlu){
			
			$jiage = $Glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
			$xianludatas[$i]['chengrenzongjia'] = $jiage['chengrenzongjia'];
			//发布人
			$Glkehu = D("Glkehu");
			$kehu = $Glkehu->where("`user_name` = '$xianlu[user_name]'")->find();
			$xianludatas[$i]['realname'] = $kehu['realname'];
			//dedecms关联
			$i++;
		}
		
        $this->assign('page',$page);
        $this->assign('xianludatas',$xianludatas);
		if($_GET['iframe'] == 1 ||$_GET['iframe'] == 2)
		$this->display('myxianlu');
		elseif($_GET['iframe'] == 4)
		$this->display('Shenhe/myxianlu');
		else
		{
			if($_GET['xianlutype'] == '自由人')
			$this->display('Ziyouren/index');
			else
			$this->display();
		}
    }

	//发布线路
    public function fabuxinxianlu() {
		//线路主题
		$theme = D('Line_theme');
		$theme_all = $theme->findAll();
		$this->assign('theme_all',$theme_all);
		//产品类型
		$goods = D('Goods_type');
		$goods_all = $goods->findAll();
		$this->assign('goods_all',$goods_all);
		//默认
		$xianludata['chufadi'] = '辽宁,大连';
        $this->assign('postdata',$xianludata);
		$this->assign('xianlutype','散客产品');
		
		if($_GET['showtype'] == '快速')
		{
			$this->assign('navlist','线路产品发布 》  快速发布 》  境外欧美澳非');
			//默认
			$xianludata['chufadi'] = '辽宁,大连';
			$xianludata['renshu'] = 30;
			$this->assign('postdata',$xianludata);
			$this->assign('kind','欧美澳非');
			$this->assign('xianlutype','散客产品');
			
			$this->display('quickfabu');
		}
		else
		{
			$this->assign('navlist','线路产品发布 》  '.$_GET['guojing'].' 》  发布线路 》 '.$_GET['kind']);
			if($_GET['xianlutype'] == '自由人')
			{
				$this->assign('xianlutype','自由人');
				if ($_GET['guojing']=='境外')
					$this->display('chujingfabu');
				else
					$this->display();
			}
			else 
			if($_GET['xianlutype'] == '包团')
			{
				$this->assign('xianlutype','包团');
				if($_GET['guojing'] == "境外"){
					$this->display('chujingfabu');
				}
				else{
					$glbasedata = D("glbasedata");
					$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
					$this->assign("departmentAll",$departmentAll);
					$this->display('baotuanfabu');
				}
			}
			else
			{
				if($_GET['guojing'] == "境外"){
					if($_GET['kind'] == '欧美澳非')
						$this->display('fabuomei');
					else
						$this->display('chujingfabu');
				}
				else{
					$this->display();
				}
			}
		}
    }

	//保存修改
    public function dopostFabulvyouxianlu() {
		$postdata = $_POST;
		$Glxianlu = D("Glxianlu");
		$Glxianlu_ext = D("Glxianlu_ext");
		//数据处理
		if($postdata['guojing'] == "国内"){
			$mudidi = $postdata['daqu'];
			$mudidi .= ','.$postdata['shengfen'];
			$mudidi .= ','.$postdata['chengshi'];
			$postdata['mudidi'] = $mudidi;
		}
		$chufadi = $postdata['chufashengfen'];
		$chufadi .= ','.$postdata['chufachengshi'];
		$postdata['chufadi'] = $chufadi;
		$mark = '';
		if($postdata['daoyoufuwu'][0]){
			$mark = ',';
			$daoyoufuwu = $postdata['daoyoufuwu'][0];
		}
		if($postdata['daoyoufuwu'][1]){
			$daoyoufuwu .= $mark.$postdata['daoyoufuwu'][1];
		}
		$postdata['daoyoufuwu'] = $daoyoufuwu;
		if(!$postdata['ischild']) $postdata['ischild'] = '0';
		//附加表副本
		foreach($_FILES as $key => $value){
			$uplod = _dofileuplod();
			if($_FILES[$key]['name'] && $uplod != null)
			$postdata[$key] = $uplod;
			elseif($_FILES[$key]['name'] && $uplod == null)
			justalert('副本上传失败');
		}
		//修改线路
		if($postdata['xianluID'])
		{

			//xianluIsAdmin($postdata['xianluID'],$this);
			//同部门计调操作员可以互改。
			xianluIsDepartment($postdata['xianluID'],$this);
			//检查状态
			F_xianlu_status_check($postdata['xianluID'],$this);	
			//判断线路状态
			$xianluID = $postdata['xianluID'];
//			$condition['zhuangtai'] = array('NOT IN','等待审核,准备,审核不通过');
			$condition['islock'] = '未锁定';
			$condition['xianluID'] = $xianluID;
			$xianlu = $Glxianlu->where($condition)->find();
//			$xianlu = $Glxianlu->where("`xianluID` = '$xianluID' and `islock` = '未锁定'")->find();
			if(!$xianlu)
			{
				//$rurl = SITE_ADMIN."Chanpin/sankechanpin";
				doalert('操作失败，该线路已被锁定','');
			}
			//不允许修改项
			$postdata['kind'] = $xianlu['kind'];
			$postdata['bianhao'] = $xianlu['bianhao'];
			$postdata['guojing'] = $xianlu['guojing'];
			$postdata['xianlutype'] = $xianlu['xianlutype'];
			$postdata['user_name'] = $xianlu['user_name'];
			$postdata['departmentName'] = $xianlu['departmentName'];
			$postdata['departmentID'] = $xianlu['departmentID'];

			$Glxianlu->save_My($postdata);
			
			if($xianlu['xianlutype'] == "包团"){
				//附加表，包团
				$Glbaotuan_ext = D("Glbaotuan_ext");
				$res = $Glbaotuan_ext->where("`xianluID` = '$postdata[xianluID]'")->find();
				if($res)
					$Glbaotuan_ext->where("`xianluID` = '$postdata[xianluID]'")->save_My($postdata);
				else
					$Glbaotuan_ext->add_My($postdata);
			}
			
			if($xianlu['guojing'] == '境外'){
				//附加表，境外
				$record = $Glxianlu_ext->where("`xianluID` = '$postdata[xianluID]'")->find();
				if($postdata['attachment'])
					unlink("data/".$record['attachment']);
				$Glxianlu_ext->where("`xianluID` = '$postdata[xianluID]'")->save_My($postdata);
				
				if($xianlu['kind'] == '欧美澳非'){
					$Glxianlujiage = D("Glxianlujiage");
					$Glchengbenxiang = D("Glchengbenxiang");
					$Glshoujia = D("Glshoujia");

					//成本项
					$chengbenxiang['chengbenID'] = $postdata['chengbenID'];
					$chengbenxiang['leixing'] = '地接综费';
					$chengbenxiang['jiage'] = $postdata['chengben_x'];
					$chengbenxiang['shuliang'] = 1;
					$chengbenxiang['cishu'] = 1;
					$chengbenxiang['jifeileixing'] = '全部';
					$chengbenxiang['time'] = time();
					$Glchengbenxiang->save($chengbenxiang);
					//售价
					$shoujia['shoujiaID'] = $postdata['shoujiaID'];
					$shoujia['leixing'] = '代理商';
					$shoujia['dailileixing'] = '门市';
					$shoujia['jibie'] = '全部';
					$shoujia['chengrenshoujia'] = $postdata['shoujia_x'];
					$shoujia['ertongshoujia'] = $postdata['shoujia_x'];
					$shoujia['time'] = time();
					$shoujia['xuanzetype'] = 'Batch';
					$shoujia['cut'] = $postdata['cut_x'];
					$Glshoujia->save($shoujia);
				}
				
			}
			
			//根据线路修改子团
			//由于可能存在子团锁定状态不能删除，要逆更新出团时间到线路
			$this->editzituanAll($postdata);
			
			A("Message")->savemessage($xianluID,'线路','操作记录','修改线路基本信息！');
//			$rurl = SITE_ADMIN."Chanpin/editlvyouxianlu/xianluID/".$xianluID;
//			tiaozhuan($rurl);
			doalert('修改成功','');
		}
		else
		{
			$gongtyingshan = '古莲国旅';
			$postdata['user_name'] = $this->roleuser['user_name'];
			$postdata['user_id'] = $this->roleuser['user_id'];
			$postdata['gongyingshang'] = $gongtyingshan;
			//$postdata['lvxingshe'] = $this->company['companyname'];
			$postdata['lvxingsheID'] = $this->company['lvxingsheID'];
			$postdata['ispub'] = '未发布';
			$postdata['islock'] = '未锁定';
			$postdata['time'] = time();
			$postdata['bianhao'] = "DLGL".date('ymd',time());
			$postdata['departmentName'] = $this->my_department['title'];
			$postdata['departmentID'] = $this->my_department['id'];
			$postdata['zhuangtai'] = '准备';
			//同业，办事处相应修改   by gaoyang
			if(checkByAdminlevel('办事处管理员',$this)){
				$postdata['zhuangtai'] = '报名';	//办事处的人发的发布直接进入报名状态
				
			}
//			if(!$postdata['xianlutype'])
//				$postdata['xianlutype'] = "散客产品";
			//修改结束 by gaoyang
			
			if($postdata['showtype'] == '快速')
			{
				$postdata['zhuangtai'] = '准备';
			}
			
			$newid = $Glxianlu->add_My($postdata);
			
			if($postdata['xianlutype'] == "包团"){
				//附加表，包团
				$Glbaotuan_ext = D("Glbaotuan_ext");
				$postdata['xianluID'] = $newid;
				$Glbaotuan_ext->add_My($postdata);
			}
			
			if($postdata['guojing'] == '境外'){
				//附加表，境外
				$postdata['xianluID'] = $newid;
				$Glxianlu_ext->add_My($postdata);
			}
			//生成子团
			$this->shengchengzituan($postdata,$newid);
		}
		if($newid)
		{
			$xianluID = $newid;	
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			if($postdata['showtype'] == '快速')
			{
				//价格
				$jiage['xianluID'] = $xianluID;
				$jiage['time'] = time();
				$jiage['xuanzetype'] = 'Batch';
				$jiageID = $Glxianlujiage->add($jiage);
				//成本项
				$chengbenxiang['jiageID'] = $jiageID;
				$chengbenxiang['leixing'] = '地接综费';
				$chengbenxiang['jiage'] = $postdata['chengben_x'];
				$chengbenxiang['shuliang'] = 1;
				$chengbenxiang['cishu'] = 1;
				$chengbenxiang['jifeileixing'] = '全部';
				$chengbenxiang['time'] = time();
				$Glchengbenxiang->add($chengbenxiang);
				//售价
				$shoujia['jiageID'] = $jiageID;
				$shoujia['leixing'] = '代理商';
				$shoujia['dailileixing'] = '门市';
				$shoujia['jibie'] = '全部';
				$shoujia['chengrenshoujia'] = $postdata['shoujia_x'];
				$shoujia['ertongshoujia'] = $postdata['shoujia_x'];
				$shoujia['time'] = time();
				$shoujia['xuanzetype'] = 'Batch';
				$shoujia['cut'] = $postdata['cut_x'];
				$Glshoujia->add($shoujia);
			}
			
			
			if(!$postdata['forward'])
			$postdata['forward'] = SITE_ADMIN."Chanpin/zituanguanli/xianluID/".$newid;
			doalert('线路发布成功',$postdata['forward']);
		}
        $this->assign('postdata',$postdata);
        $this->display('fabuxinxianlu');
    }
	
	
	//行程编辑
    public function xingchengbianji() {
		
		if($_GET['zituanID']){
			$zituanID = $_GET['zituanID'];
			$Glzituan = D("zituan_xianlu");
			$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
			$this->assign('zituanID',$zituan['zituanID']);
			$this->assign('zituan',$zituan);
			$this->assign('location','行程');
			$this->assign('navlist','产品控管 》  '.$zituan['guojing'].' 》  行程');
			$Glxianlu = D("Glxianlu");
			$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		}
		if($_GET['xianluID']){
			$xianluID = $_GET['xianluID'];
			$Glxianlu = D("Glxianlu");
			$xianlu = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
			$this->assign('typeurl','线路产品发布 》  '.$xianlu['guojing'].' 》  '.$xianlu['xianlutype'].' 》  行程');
		}
		$this->assign('xianluID',$xianlu['xianluID']);
        $this->assign('xianlu',$xianlu);
		//显示行程
		$Glxingcheng = D("Glxingcheng");
		$xingcheng = $Glxingcheng->where("`xianluID` = '$xianlu[xianluID]'")->order("id asc")->findAll();

		$this->assign('xingcheng',$xingcheng);
		if($_GET['zituanID']){
				$this->display('Kongguan/newricheng');

		}
        
		if($_GET['xianluID']){
			if($_GET['course'])
			$this->display('Shenhe/newricheng');
			else {
				if($xianlu['xianlutype'] == "包团"){
					$Glbaotuan_ext = D("Glbaotuan_ext");
					$glbaotuan = $Glbaotuan_ext->where("`xianluID` = '$_GET[xianluID]'")->find();
					
					$this->assign('xingcheng_word',$glbaotuan['xingcheng_word']);
					$this->display('baotuanxingcheng');	
				}else{
					$this->display('newricheng');
				}
			}
		}
		
    }
	
	//行程编辑保存修改
    public function dopostXingchengbianji() {
		$postdata = $_POST;
		
		//xianluIsAdmin($postdata['xianluID'],$this);
		//同部门计调操作员可以互改。
		xianluIsDepartment($postdata['xianluID'],$this);
		//检查状态
		F_xianlu_status_check($postdata['xianluID'],$this);	
		
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$_POST[xianluID]'")->find();
		if($xianlu['xianlutype'] == '包团'){
			$Glbaotuan_ext = D("Glbaotuan_ext");
			
			$uplod = _dofileuplod_uniqid();
			if($uplod != null)
			$postdata['xingcheng_word'] = $uplod;
			else
			doalert('您没有选择上传文件！',$rurl);
			
			$Glbaotuan_ext->where("`xianluID` = '$_POST[xianluID]'")->save_My($postdata);
			
			if($_POST['forward'])
			$rurl = $_POST['forward'];
	
			A("Message")->savemessage($xianluID,'线路','操作记录','修改线路行程！');
			doalert('保存完成',$rurl);
		}
		
		
		$Glxingcheng = D("Glxingcheng");
		
		$ids = $_POST['id'];
		$dates = $_POST['date'];
		$tools = $_POST['tools'];
		$places = $_POST['place'];
		$contents = $_POST['content'];
		$others = $_POST['other'];
		$t = 0;
		foreach( $_POST['date'] as $key => $data){
			
			$savedata['xianluID'] = $_POST[xianluID];
			$savedata['date'] = $dates[$key];

			$savedata['time'] = implode(',',$_POST['time'.$key]);
			$savedata['tools'] = implode(',',$_POST['tools'.$key]);
			$savedata['place'] = $places[$key];
			$savedata['content'] = $contents[$key];
			$savedata['other'] = $others[$key];
			
			if($ids){
				$savedata['id'] = $ids[$key];
				$res[$key] = $Glxingcheng->save($savedata);
			}
			$res[$key] = $Glxingcheng->add($savedata);
		}
		
		if($postdata['forward'])
		$rurl = $postdata['forward'];
//		else
//		$rurl = SITE_ADMIN."Chanpin/xianlujiage/xianluID/".$postdata['xianluID'];
//		tiaozhuan($rurl);

		A("Message")->savemessage($xianluID,'线路','操作记录','修改线路行程！');
		doalert('保存完成',$rurl);
    }
	
	//人员编辑
    public function renyuanbianji() {
		
		if($_GET['xianluID']){
			$xianluID = $_GET['xianluID'];
			$Glxianlu = D("Glxianlu");
			$xianlu = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
			$this->assign('typeurl','线路产品发布 》  '.$xianlu['guojing'].' 》  '.$xianlu['xianlutype'].' 》  人员');
		
			$this->assign('xianluID',$xianlu['xianluID']);
			$this->assign('xianlu',$xianlu);
	
	
			$Glbaotuan_ext = D("Glbaotuan_ext");
			$glbaotuan = $Glbaotuan_ext->where("`xianluID` = '$_GET[xianluID]'")->find();
			
			$this->assign('renyuan_word',$glbaotuan['renyuan_word']);
			$this->display('baotuanrenyuan');	
		}
		
    }
	
	//人员编辑保存修改
    public function dopostRenyuanbianji() {
		$postdata = $_POST;
		
		//xianluIsAdmin($postdata['xianluID'],$this);
		//同部门计调操作员可以互改。
		//xianluIsDepartment($postdata['xianluID'],$this);
		
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$_POST[xianluID]'")->find();
		if($xianlu['xianlutype'] == '包团'){
			$Glbaotuan_ext = D("Glbaotuan_ext");
			
			$uplod = _dofileuplod_uniqid();
			if($uplod != null)
			$postdata['renyuan_word'] = $uplod;
			else
			doalert('您没有选择上传文件！',$rurl);
			
			$Glbaotuan_ext->where("`xianluID` = '$_POST[xianluID]'")->save_My($postdata);
			
			if($_POST['forward'])
			$rurl = $_POST['forward'];
	
			A("Message")->savemessage($xianluID,'线路','操作记录','修改线路人员！');
			doalert('保存完成',$rurl);
		}
    }
	
	//线路价格
    public function xianlujiage() {
		
		if($_GET['zituanID'])
		{
			$zituanID = $_GET['zituanID'];
			$Glzituan = D("Glzituan");
			$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
			$Glxianlu = D("Glxianlu");
			$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
			$xianluID = $xianlu['xianluID'];
			$this->assign('location','价格');
			$this->assign('navlist','产品控管 》  '.$zituan['guojing'].' 》  价格');
			$this->assign('zituan',$zituan);
			
		}
		if($_GET['xianluID'])
		{
			$xianluID = $_GET['xianluID'];
			$Glxianlu = D("Glxianlu");
			$xianlu = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
		}
		
		if($xianlu['xianlutype'] == '自由人'){
			tiaozhuan(SITE_ADMIN.'Ziyouren/xianlujiage/xianluID/'.$xianluID);
		}
		
		$Glxianlujiage = D("Glxianlujiage");
		$Glchengbenxiang = D("Glchengbenxiang");
		$Glshoujia = D("Glshoujia");
		$Glchengben = D("Glchengben");
		
		$oldjiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();
		if($oldjiage)
		{
			$this->myjiagedata($oldjiage);
		}
		
        $this->assign('xianlu',$xianlu);
        $this->assign('xianluID',$xianluID);
		
		if($_GET['zituanID'])
		{
			if($xianlu['guojing'] == '境外')
				$this->display('Kongguan/xianlujiage_jingwai');
			else
				$this->display('Kongguan/xianlujiage');
		}
		if($_GET['xianluID'])
		{
				$this->assign ( "typeurl", '产品发布 》  '.$xianlu['guojing'].' 》  '.$xianlu['xianlutype'].' 》  价格');
				
			if(checkByAdminlevel('联合体成员',$this))
			{
				if($xianlu['guojing'] == '境外'){
					$this->display('jingwaijiage_tongye');
				}else{
					$this->display('xianlujiage_tongye');
				}
			}
			else
			{
				if($xianlu['guojing'] == '境外'){
					$this->display('jingwaijiage');
				}else{
					$this->display();
				}
			}
		}
    }
	
	
	
	private function myjiagedata($oldjiage)
	{
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			$Glchengben = D("Glchengben");
			  $postdata['xianluID'] = $oldjiage['xianluID'];
			  $postdata['tbChildNote'] = $oldjiage['ertongshouming'];
			  $postdata['tbAdultAllPrice'] = $oldjiage['chengrenzongjia'];
			  $postdata['tbChildAllPrice'] = $oldjiage['ertongzongjia'];
			  $postdata['tbChildNote'] = $oldjiage['ertongshuoming'];
			  $postdata['ddlAgentType'] = $oldjiage['xuanzetype'];
			  //数据解析
			  $oldchengben = $Glchengbenxiang->where("`jiageID` = '$oldjiage[jiageID]'")->findall();
			  $i = 0;
			  foreach($oldchengben as $chenben)
			  {
				  $postdata['chengbenID0'.$i] = $chenben['chengbenID'];
				  $postdata['tbType0'.$i] = $chenben['leixing'];
				  $postdata['tbSummary0'.$i] = $chenben['miaoshu'];
				  $postdata['tbPrice0'.$i] = $chenben['jiage'];
				  $postdata['tbNum0'.$i] = $chenben['shuliang'];
				  $postdata['tbOrder0'.$i] = $chenben['cishu'];
				  $postdata['tbPriceType0'.$i] = $chenben['jifeileixing'];
				  $i++;
			  }
			  $postdata['rowsnum0'] = $i-1<0 ? 0 : $i-1;
			  
			  //数据解析
			  $oldchengben_new = $Glchengben->where("`jiageID` = '$oldjiage[jiageID]'")->findall();
			  $k = 0;
			  foreach($oldchengben_new as $chenben)
			  {
				  $postdata['cbID1'.$k] = $chenben['id'];
				  $postdata['renshu1'.$k] = $chenben['renshu'];
				  $postdata['miaoshu1'.$k] = $chenben['miaoshu'];
				  $postdata['chengben1'.$k] = $chenben['chengben'];
				  $k++;
			  }
			  $postdata['rowsnum4'] = $k-1<0 ? 0 : $k-1;
			  
			  $oldshoujia = $Glshoujia->where("`jiageID` = '$oldjiage[jiageID]'")->findall();
			  $i = 0;
			  $m = 0;
			  $n = 0;
			  foreach($oldshoujia as $shoujia)
			  {
				  if($shoujia['leixing'] == '代理商' && $shoujia['xuanzetype'] == 'Batch' )
				  {
						  $postdata['shoujiaID1'.$i] = $shoujia['shoujiaID'];
						  $postdata['slAgentType1'.$i] = $shoujia['dailileixing'];
						  $postdata['slClass1'.$i] = $shoujia['jibie'];
						  $postdata['tbAdultPrice1'.$i] = $shoujia['chengrenshoujia'];
						  $postdata['tbChildPrice1'.$i] = $shoujia['ertongshoujia'];
						  $postdata['tbAdultCommission1'.$i] = $shoujia['chengrenyongjin'];
						  $postdata['tbChildCommission1'.$i] = $shoujia['ertongyongjin'];
						  $postdata['tbAdultProfit1'.$i] = $shoujia['chengrenlirun'];
						  $postdata['tbChildProfit1'.$i] = $shoujia['ertonglirun'];
						  $postdata['tbCut1'.$i] = $shoujia['cut'];
						  $i++;
				  }
				  if($shoujia['leixing'] == '代理商' && $shoujia['xuanzetype'] == 'MultipleChoice' )
				  {
						  $postdata['shoujiaID2'.$m] = $shoujia['shoujiaID'];
						  $postdata['AgentName2'.$m] = $shoujia['hezuohuoban'];
						  $postdata['AgentID2'.$m] = $shoujia['hezuohuobanID'];
						  $postdata['tbAdultPrice2'.$m] = $shoujia['chengrenshoujia'];
						  $postdata['tbChildPrice2'.$m] = $shoujia['ertongshoujia'];
						  $postdata['tbAdultCommission2'.$m] = $shoujia['chengrenyongjin'];
						  $postdata['tbChildCommission2'.$m] = $shoujia['ertongyongjin'];
						  $postdata['tbAdultProfit2'.$m] = $shoujia['chengrenlirun'];
						  $postdata['tbChildProfit2'.$m] = $shoujia['ertonglirun'];
						  $postdata['tbCut2'.$m] = $shoujia['cut'];
						  $m++;
				  }
				  if($shoujia['leixing'] == '合作伙伴' )
				  {
						  $postdata['shoujiaID3'.$n] = $shoujia['shoujiaID'];
						  $postdata['CompanyName3'.$n] = $shoujia['hezuohuoban'];
						  $postdata['CompanyID3'.$n] = $shoujia['hezuohuobanID'];
						  $postdata['tbAdultPrice3'.$n] = $shoujia['chengrenshoujia'];
						  $postdata['tbChildPrice3'.$n] = $shoujia['ertongshoujia'];
						  $postdata['tbAdultCommission3'.$n] = $shoujia['chengrenyongjin'];
						  $postdata['tbChildCommission3'.$n] = $shoujia['ertongyongjin'];
						  $postdata['tbAdultProfit3'.$n] = $shoujia['chengrenlirun'];
						  $postdata['tbChildProfit3'.$n] = $shoujia['ertonglirun'];
						  $n++;
				  }
			  }
			  $postdata['rowsnum1'] = $i-1<0 ? 0 : $i-1;
			  $postdata['rowsnum2'] = $m-1<0 ? 0 : $m-1;
			  $postdata['rowsnum3'] = $n-1<0 ? 0 : $n-1;
			  $this->assign('postdata',$postdata);
			  $this->assign('oldjiage',$oldjiage);
			  
	}
	
	
	
	
	
	
	
	
	
	
	
	
	//保存修改价格
    public function dopostXianlujiage() {
		$postdata = $_POST;
		$xianluID = $_POST['xianluID'];
		$this->assign('xianluID',$xianluID);
		//检查状态
		F_xianlu_status_check($xianluID,$this);	
		
		$Glxianlujiage = D("Glxianlujiage");
		$Glchengbenxiang = D("Glchengbenxiang");
		$Glshoujia = D("Glshoujia");
		$Glchengben = D("Glchengben");
		//生成线路价格纪录
		$oldjiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();
		$oldjiage['ertongshuoming'] = $postdata['tbChildNote'];
		$oldjiage['chengrenzongjia'] = $postdata['tbAdultAllPrice'];
		$oldjiage['ertongzongjia'] = $postdata['tbChildAllPrice'];
		$oldjiage['xuanzetype'] = $postdata['ddlAgentType'];
		$oldjiage['airhotlenumber'] = $postdata['airhotlenumber'];
		$oldjiage['adultcostair'] = $postdata['adultcostair'];
		$oldjiage['childcostair'] = $postdata['childcostair'];
		$oldjiage['adultcosthotle'] = $postdata['adultcosthotle'];
		$oldjiage['childcosthotle'] = $postdata['childcosthotle'];
		$oldjiage['aircut'] = $postdata['aircut'];
		$oldjiage['hotlecut'] = $postdata['hotlecut'];
		if($oldjiage['jiageID'])
		{
			
			//xianluIsAdmin($xianluID,$this);
			//同部门计调操作员可以互改。
			xianluIsDepartment($xianluID,$this);
			
			//修改
			$ifnewid = $Glxianlujiage->save_My($oldjiage);
			A("Message")->savemessage($xianluID,'线路','操作记录','修改线路价格！');
			$xianlujiageID = $oldjiage['jiageID'];
			$iftiaozhuan = 0;
		}
		else
		{
			$oldjiage['xianluID'] = $xianluID;
			$oldjiage['time'] = time();
			$xianlujiageID = $Glxianlujiage->add_My($oldjiage);
			$iftiaozhuan = 1;
		}
		
		if($xianlujiageID == null )
		{
			justalert('找不到线路价格');
			$this->assign('postdata',$postdata);
			$this->display('Xianlujiage');
			exit;
		}
		//必填
		foreach($postdata['chengbencaozuoID'] as $i)
		{
			$chengben['chengbenID'] = $postdata['chengbenID0'.$i];
			$chengben['leixing'] = $postdata['tbType0'.$i];
			$chengben['miaoshu'] = $postdata['tbSummary0'.$i];
			$chengben['jiage'] = $postdata['tbPrice0'.$i];
			$chengben['shuliang'] = $postdata['tbNum0'.$i];
			$chengben['cishu'] = $postdata['tbOrder0'.$i];
			$chengben['jifeileixing'] = $postdata['tbPriceType0'.$i];
			$chengben['time'] = time();
			$chengben['jiageID'] = $xianlujiageID;
			if($chengben['chengbenID'])
			{
				//修改
				$oldchengben = $Glchengbenxiang->where("`chengbenID` = '$chengben[chengbenID]'")->find();
				if(!$oldchengben)
				{
					justalert('找不到线路成本');
					$this->assign('postdata',$postdata);
					$this->display('Xianlujiage');
					exit;
				}
				$ifnewid = $Glchengbenxiang->save_My($chengben);
				$lastchenbenID = $chengben['chengbenID'];
			}
			else
			{
				$lastchenbenID = $Glchengbenxiang->add_My($chengben);
				$postdata['chengbenID0'.$i] = $lastchenbenID;
			}
			//exit;
			if($lastchenbenID < 0)
			{
				justalert('找不到线路成本！！');
				$this->assign('postdata',$postdata);
				$this->display('Xianlujiage');
				exit;
			}
		}
		
		foreach($postdata['chengbenyongyouID'] as $i)
		{
			$chengben_new['id'] = $postdata['cbID1'.$i];
			$chengben_new['renshu'] = $postdata['renshu1'.$i];
			$chengben_new['chengben'] = $postdata['chengben1'.$i];
			$chengben_new['miaoshu'] = $postdata['miaoshu1'.$i];
			$chengben_new['jiageID'] = $xianlujiageID;

			if($chengben_new['id'])
			{
				//修改
				$oldchengben_new = $Glchengben->where("`id` = '$chengben_new[id]'")->find();
				if(!$oldchengben_new)
				{
					justalert('找不到线路成本');
					$this->assign('postdata',$postdata);
					$this->display('Xianlujiage');
					exit;
				}
				$ifnewid = $Glchengben->save_My($chengben_new);
				$lastcbID = $chengben_new['id'];
			}
			else
			{
				$lastcbID = $Glchengben->add_My($chengben_new);
				$postdata['cbID1'.$i] = $lastchenbenID;
			}
			//exit;
			if($lastcbID < 0)
			{
				justalert('找不到线路成本！！');
				$this->assign('postdata',$postdata);
				$this->display('Xianlujiage');
				exit;
			}
		}
		
		//必填
		if($postdata['ddlAgentType'] == 'Batch')
		{
				foreach($postdata['BatchcaozuoID'] as $i)
				{
					$dailishang['shoujiaID'] = $postdata['shoujiaID1'.$i];
					$dailishang['leixing'] = '代理商';//合作类型
					$dailishang['dailileixing'] = $postdata['slAgentType1'.$i];//代理商类型
					//$dailishang['jibie'] = $postdata['slClass1'.$i];//级别
					$dailishang['jibie'] = '全部';//级别
					$dailishang['chengrenshoujia'] = $postdata['tbAdultPrice1'.$i];//成人销售价
					$dailishang['ertongshoujia'] = $postdata['tbChildPrice1'.$i];//儿童销售价
					$dailishang['chengrenyongjin'] = $postdata['tbAdultCommission1'.$i];//成人佣金
					$dailishang['ertongyongjin'] = $postdata['tbChildCommission1'.$i];//儿童佣金
					$dailishang['chengrenlirun'] = $postdata['tbAdultProfit1'.$i];
					$dailishang['ertonglirun'] = $postdata['tbChildProfit1'.$i];
					$dailishang['cut'] = $postdata['tbCut1'.$i];
					$dailishang['time'] = time();
					$dailishang['xuanzetype'] = 'Batch';
					$dailishang['jiageID'] = $xianlujiageID;
					//$olddailishang = $Glshoujia->where("`shoujiaID` = '$dailishang[shoujiaID]'")->find();
					
					
					if($dailishang['shoujiaID'] != null)
					{
						$ifnewid = $Glshoujia->save_My($dailishang);
						$lastshoujiaID = $dailishang['shoujiaID'];
					}
					else
					{
						$lastshoujiaID = $Glshoujia->add_My($dailishang);
						$postdata['shoujiaID1'.$i] = $lastshoujiaID;
					}
					if($lastshoujiaID < 0)
					{
						justalert('找不到代理！！');
						$this->assign('postdata',$postdata);
						$this->display('Xianlujiage');
						exit;
					}
				}
		}
		if($postdata['ddlAgentType'] == 'MultipleChoice')
		{
				foreach($postdata['MultipleChoicecaozuoID'] as $i)
				{
					if($postdata['AgentName2'.$i])
					{
							$dailishang['shoujiaID'] = $postdata['shoujiaID2'.$i];
							$dailishang['leixing'] = '代理商';//合作类型
							$dailishang['hezuohuoban'] = $postdata['AgentName2'.$i];//代理商名
							$dailishang['hezuohuobanID'] = $postdata['AgentID2'.$i];//代理商ID
							$dailishang['chengrenshoujia'] = $postdata['tbAdultPrice2'.$i];//成人销售价
							$dailishang['ertongshoujia'] = $postdata['tbChildPrice2'.$i];//儿童销售价
							$dailishang['chengrenyongjin'] = $postdata['tbAdultCommission2'.$i];//成人佣金
							$dailishang['ertongyongjin'] = $postdata['tbChildCommission2'.$i];//儿童佣金
							$dailishang['chengrenlirun'] = $postdata['tbAdultProfit2'.$i];
							$dailishang['ertonglirun'] = $postdata['tbChildProfit2'.$i];
							$dailishang['cut'] = $postdata['tbCut2'.$i];
							$dailishang['time'] = time();
							$dailishang['xuanzetype'] = 'MultipleChoice';
							$dailishang['jiageID'] = $xianlujiageID;
							$olddailishang = $Glshoujia->where("`shoujiaID` = '$dailishang[shoujiaID]'")->find();
							if($olddailishang)
							{
								$ifnewid = $Glshoujia->save_My($dailishang);
								$lastshoujiaID = $dailishang['shoujiaID'];
							}
							else
							{
								$lastshoujiaID = $Glshoujia->add_My($dailishang);
								$postdata['shoujiaID2'.$i] = $lastshoujiaID;
							}
							if(!$lastshoujiaID )
							{
								justalert('找不到代理！！');
								$this->assign('postdata',$postdata);
								$this->display('Xianlujiage');
								exit;
							}
						}
						
					else
					{
						justalert("请选择代理商后提交");
						$this->assign('postdata',$postdata);
						$this->display('Xianlujiage');
						exit;
					}
			}
		}
/*		
		//选填
		foreach($postdata['huobancaozuoID'] as $i){
			if($postdata['CompanyName3'.$i]){
					$hezuohuoban['shoujiaID'] = $postdata['shoujiaID3'.$i];
					$hezuohuoban['leixing'] = '合作伙伴';//合作类型
					$hezuohuoban['hezuohuoban'] = $postdata['CompanyName3'.$i];//合作伙伴
					$hezuohuoban['hezuohuobanID'] = $postdata['CompanyID3'.$i];//合作伙伴ID
					$hezuohuoban['chengrenshoujia'] = $postdata['tbAdultPrice3'.$i];//成人销售价
					$hezuohuoban['ertongshoujia'] = $postdata['tbChildPrice3'.$i];//儿童销售价
					$hezuohuoban['chengrenyongjin'] = $postdata['tbAdultCommission3'.$i];//成人佣金
					$hezuohuoban['ertongyongjin'] = $postdata['tbChildCommission3'.$i];//儿童佣金
					$hezuohuoban['chengrenlirun'] = $postdata['tbAdultProfit3'.$i];
					$hezuohuoban['ertonglirun'] = $postdata['tbChildProfit3'.$i];
					$hezuohuoban['time'] = time();
					$hezuohuoban['jiageID'] = $xianlujiageID;
					$oldhezuohuoban = $Glshoujia->where("`shoujiaID` = '$hezuohuoban[shoujiaID]'")->find();
					if($oldhezuohuoban){
						$ifnewid = $Glshoujia->save_My($hezuohuoban);
						$lastshoujiaID = $hezuohuoban['shoujiaID'];
					}
					else{
						$lastshoujiaID = $Glshoujia->add_My($hezuohuoban);
						$postdata['shoujiaID3'.$i] = $lastshoujiaID;
					}
					if(!$lastshoujiaID ){
						justalert("找不到代理");
						$this->assign('postdata',$postdata);
						$this->display('Xianlujiage');
						exit;
					}
			}
			else{
				if($postdata['tbAdultPrice30'] || $postdata['tbChildPrice30']  || $postdata['tbAdultCommission30']  || $postdata['tbChildCommission30'] )
					justalert("合作伙伴代理商没有选择，合作伙伴售价将不被保存");
			}
		}
*/		
		if($iftiaozhuan){
			//发布
			$rurl = SITE_ADMIN."Chanpin/xianlujiage/xianluID/".$xianluID;
			doalert('发布成功',$rurl);
		}
		else{
			//修改
			$rurl = SITE_ADMIN."Chanpin/xianlujiage/xianluID/".$xianluID;
			tiaozhuan($rurl);
		}
    }
	
	//修改线路
    public function editlvyouxianlu() {
		
		if($_GET['zituanID'])
		{
			$zituanID = $_GET['zituanID'];
			$Glzituan = D("zituan_xianlu");
			$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
			$Glxianlu = D("Glxianlu");
			$xianludata = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
			$this->assign('location','基本信息');
			$this->assign('navlist','产品控管 》  '.$zituan['guojing'].' 》  基本信息');
			
			$xianluID = $xianludata['xianluID'];
			$this->assign('xianluID',$xianluID);
			$this->assign('zituan',$zituan);
		}
		elseif($_GET['xianluID'])
		{
			$xianluID = $_GET['xianluID'];
			$this->assign('xianluID',$xianluID);
			$Glxianlu = D("Glxianlu");
			$xianludata = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
			$typeurl = '产品发布 》 '.$xianludata['guojing'].' 》  '.$xianludata['xianlutype'];
			$this->assign ( "navlist", $typeurl );
		}
		
		//部门列表
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign("departmentAll",$departmentAll);
		
		//线路主题
		$theme = D('Line_theme');
		$theme_all = $theme->findAll();
		$this->assign('theme_all',$theme_all);
		//产品类型
		$goods = D('Goods_type');
		$goods_all = $goods->findAll();
		$this->assign('goods_all',$goods_all);
		//数据解析
		list($shengfen,$chengshi) = split('[,]',$xianludata['mudidi']);
		list($chufashengfen,$chufachengshi) = split('[,]',$xianludata['chufadi']);
		$xianludata['shengfen'] = $shengfen;
		$xianludata['chengshi'] = $chengshi;
		$xianludata['chufashengfen'] = $chufashengfen;
		$xianludata['chufachengshi'] = $chufachengshi;
		list($fuwu1,$fuwu2) = split('[,]',$xianludata['daoyoufuwu']);
		if(!$fuwu2){
			if($fuwu1 == '全陪')
			$xianludata['quanpei'] = $fuwu1;
			if($fuwu1 == '地陪')
			$xianludata['dipei'] = $fuwu1;
		}
		else{
			$xianludata['quanpei'] = $fuwu1;
			$xianludata['dipei'] = $fuwu2;
		}
		//附属表
		if($xianludata['guojing'] == "境外"){
			$Glxianlu_ext = D("Glxianlu_ext");
			$xianluext = $Glxianlu_ext->where("`xianluID` = '$xianludata[xianluID]'")->find();
			foreach($xianluext as $key => $value)
			{
				$xianludata[$key] = $value;
			}
		}
		
		//附属表
		if($xianludata['xianlutype'] == "包团"){
			$Glbaotuan_ext = D("Glbaotuan_ext");
			$baotuanext = $Glbaotuan_ext->where("`xianluID` = '$xianludata[xianluID]'")->find();
			foreach($baotuanext as $key => $value)
			{
				$xianludata[$key] = $value;
			}
		}
		
		if($_GET['showtype'] == '审核')
		{
			//价格信息
			$Glxianlujiage = D("Glxianlujiage");
			$xianlujiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();
			$this->assign('xianlujiage',$xianlujiage);
			
			$Glchengbenxiang = D("Glchengbenxiang");
			$chengbenAll = $Glchengbenxiang->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
			
			$Glshoujia = D("Glshoujia");
			$shoujiaAll = $Glshoujia->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
			$i = 0;$j = 0;
			foreach($shoujiaAll as $shoujia)
			{
				if($shoujia['xuanzetype'] == $xianlujiage['xuanzetype'])
				{
					$typeshoujiaAll[$i] = $shoujia;
					$i++;
				}
				if($shoujia['leixing'] == '合作伙伴')
				{
					$HZshoujiaAll[$j] = $shoujia;
					$j++;
				}
			}
			$this->assign('HZshoujiaAll',$HZshoujiaAll);
			$this->assign('typeshoujiaAll',$typeshoujiaAll);
			$this->assign('chengbenAll',$chengbenAll);
			$this->assign('xianlujiage',$xianlujiage);
			$this->assign('shoujiaAll',$shoujiaAll);
			$this->assign('xianlu',$xianludata);
			$this->assign('xianluID',$xianluID);
			if($xianludata['guojing'] == "境外"){
				if($_GET['zituanID'])
				$this->display('Shenhe/chujingzituan');
				elseif($_GET['xianluID'])
				{
						if($xianludata['xianlutype'] == '自由人')
						{
							$this->getziyourenxinxi($xianlujiage,$xianlujiage);
							$this->display('Shenhe/chujingziyouren');
						}
						else
						{
							if($xianludata['kind'] == '欧美澳非'){
								$Glxianlujiage = D("Glxianlujiage");
								$Glchengbenxiang = D("Glchengbenxiang");
								$Glshoujia = D("Glshoujia");
								
								$oldjiage = $Glxianlujiage->where("`xianluID` = '$_GET[xianluID]'")->find();
			
								$glchengben = $Glchengbenxiang->where("`jiageID` = '$oldjiage[jiageID]'")->find();
								$this->assign('chengbenID',$glchengben['chengbenID']);
								$this->assign('chengben_x',$glchengben['jiage']);
								
								$glshoujia = $Glshoujia->where("`jiageID` = '$oldjiage[jiageID]'")->find();
								$this->assign('shoujiaID',$glshoujia['shoujiaID']);
								$this->assign('shoujia_x',$glshoujia['chengrenshoujia']);
								$this->assign('cut_x',$glshoujia['cut']);
								$this->display('Shenhe/fabuomei');
							}else{
								$this->myjiagedata($xianlujiage);
								$this->display('Shenhe/chujingsanke');
							}
						}
				}
			}
			else{
				if($_GET['zituanID']){
					if($xianludata['xianlutype'] == "包团")
						$this->display('Shenhe/baotuanxinxi_cw');
					else
						$this->display('Shenhe/zituanxinxi');
				}
				elseif($_GET['xianluID'])
				{
						if($xianludata['xianlutype'] == '自由人')
						{
							$this->getziyourenxinxi($xianlujiage,$xianlujiage);
							$this->display('Shenhe/ziyourenxinxi');
						}
						if($xianludata['xianlutype'] == "包团")
							$this->display('Shenhe/baotuanxinxi');
						else
						$this->display('Shenhe/chanpinxinxi');
				}
			}
		}
		elseif($_GET['zituanID'])
		{
			$this->assign('postdata',$xianludata);
			$this->assign('zituan',$zituan);
			if($zituan['guojing'] == '境外'){
//				if($zituan['xianlutype'] == '自由人')
//				$this->display('Kongguan/z_zituanxinxi');
//				else
				if($xianludata['kind'] == '欧美澳非'){
					$Glxianlujiage = D("Glxianlujiage");
					$Glchengbenxiang = D("Glchengbenxiang");
					$Glshoujia = D("Glshoujia");
					
					$oldjiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();

					$glchengben = $Glchengbenxiang->where("`jiageID` = '$oldjiage[jiageID]'")->find();
					$this->assign('chengbenID',$glchengben['chengbenID']);
					$this->assign('chengben_x',$glchengben['jiage']);
					
					$glshoujia = $Glshoujia->where("`jiageID` = '$oldjiage[jiageID]'")->find();
					$this->assign('shoujiaID',$glshoujia['shoujiaID']);
					$this->assign('shoujia_x',$glshoujia['chengrenshoujia']);
					$this->assign('cut_x',$glshoujia['cut']);
					
					$this->display('Kongguan/fabuomei');
				}
				else
					$this->display('Kongguan/zituanxinxi_jw');
			}
			else{
				
//				if($zituan['xianlutype'] == '自由人')
//				$this->display('Kongguan/z_zituanxinxi');
//				else
				if($xianludata['xianlutype'] == "包团")
					$this->display('Kongguan/baotuanxinxi');
				else
					$this->display('Kongguan/zituanxinxi');
			}
			
		}
		elseif($_GET['xianluID'])
		{
			$this->assign('postdata',$xianludata);
			if($xianludata['guojing'] == "国内"){
				if($xianludata['xianlutype'] == "包团")
					$this->display('baotuanfabu');
				else
					$this->display('fabuxinxianlu');
			}
			else{
				if($xianludata['kind'] == '欧美澳非'){
					$Glxianlujiage = D("Glxianlujiage");
					$Glchengbenxiang = D("Glchengbenxiang");
					$Glshoujia = D("Glshoujia");
					
					$oldjiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();

					$glchengben = $Glchengbenxiang->where("`jiageID` = '$oldjiage[jiageID]'")->find();
					$this->assign('chengbenID',$glchengben['chengbenID']);
					$this->assign('chengben_x',$glchengben['jiage']);
					
					$glshoujia = $Glshoujia->where("`jiageID` = '$oldjiage[jiageID]'")->find();
					$this->assign('shoujiaID',$glshoujia['shoujiaID']);
					$this->assign('shoujia_x',$glshoujia['chengrenshoujia']);
					$this->assign('cut_x',$glshoujia['cut']);
					
					$this->display('fabuomei');
				}
				else
					$this->display('chujingfabu');
			}
		}
		
    }
	
	
	//自由人信息
	private function getziyourenxinxi($xianlujiage,$xianlujiage)
	{
	  
		  //流程
		  $Glticketorder = D("Glticketorder");
		  $hotel_line_view = D("hotel_line_view");
		  $ticket = D("ticket");
		  $ticketorderAll = $Glticketorder->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
		  $i = 0;
		  foreach($ticketorderAll as $ticketorder)
		  {
			  if($ticketorder['tickettype'] == '酒店')
			  {
				  $hotel = $hotel_line_view->where("`id` = '$ticketorder[ticketID]'")->find();
				  $ticketshowAll[$i]['tickettype'] = '酒店';
				  $ticketshowAll[$i]['arg1'] = $hotel['room'];
				  $ticketshowAll[$i]['arg2'] = $hotel['hotel_title'];
				  $ticketshowAll[$i]['arg3'] = $hotel['stay_day'];
				  $i++;
			  }
			  
			  if($ticketorder['tickettype'] == '机票')
			  {
				  $air = $ticket->where("`id` = '$ticketorder[ticketID]'")->find();
				  $ticketshowAll[$i]['tickettype'] = '机票';
				  $ticketshowAll[$i]['arg1'] = $air['ticket_id'];
				  $ticketshowAll[$i]['arg2'] = $air['fly_company'];
				  $ticketshowAll[$i]['arg3'] = $air['travel_type'];
				  $i++;
			  }
		  }
		  $this->assign('ticketshowAll',$ticketshowAll);
		  
		  //一日游
		  $Glyiriyou = D("Glyiriyou");
		  $yiriyouAll = $Glyiriyou->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
		  $this->assign('yiriyouAll',$yiriyouAll);
		
	}
	
	
	
	
	//删除成本项目
    public function deletechengbenxiang() {
		$xianluID = $_GET['xianluID'];
		xianluIsAdmin($xianluID,$this);
		$chengbenID = $_GET['chengbenID'];
		$Glxianlu = D("Glxianlu");
		
		$Glxianlujiage = D("Glxianlujiage");
		$xianlujiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();
		
		$Glchengbenxiang = D("Glchengbenxiang");
		$oldchengben = $Glchengbenxiang->where("`chengbenID` = '$chengbenID'")->find();
		if(!$oldchengben )
		{
			$rurl = SITE_ADMIN."Chanpin/xianlujiage/xianluID/".$xianluID;
			doalert('失败，成本错误',$rurl);
		}
		$Glchengbenxiang->where("`chengbenID` = '$chengbenID'")->delete_My();
		$chengbenAll = $Glchengbenxiang->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
		
		foreach($chengbenAll as $chengben ){
				if($chengben['jifeileixing'] == '全部' || $chengben['jifeileixing'] == '成人' )
					$chengrenjia += $chengben['jiage'];
				if($chengben['jifeileixing'] == '全部' || $chengben['jifeileixing'] == '儿童' )
					$ertongjia += $chengben['jiage'];
		}
		$xianlujiage['chengrenzongjia'] = $chengrenjia;
		$xianlujiage['ertongzongjia'] = $ertongjia;
		$Glxianlujiage->save_My($xianlujiage);
		$rurl = SITE_ADMIN."Chanpin/xianlujiage/xianluID/".$xianluID;
		doalert('成功删除',$rurl);
		
    }
	
	//删除成本
    public function deletechengben() {
		$xianluID = $_GET['xianluID'];
		xianluIsAdmin($xianluID,$this);
		
		$chengbenID = $_GET['chengbenID'];
		$Glchengben = D("Glchengben");

		$res = $Glchengben->where("`id` = '$chengbenID'")->delete_My();
		if(!$res )
		{
			$rurl = SITE_ADMIN."Chanpin/xianlujiage/xianluID/".$xianluID;
			doalert('失败，该成本不存在',$rurl);
		}
		
		$rurl = SITE_ADMIN."Chanpin/xianlujiage/xianluID/".$xianluID;
		doalert('成功删除',$rurl);
    }
	
	
	//删除售价项目
    public function deleteshoujiaxiang() {
		$xianluID = $_GET['xianluID'];
		//检查状态
		F_xianlu_status_check($xianluID,$this);	
		
		xianluIsAdmin($xianluID,$this);
		$shoujiaID = $_GET['shoujiaID'];
		$Glxianlu = D("Glxianlu");
		$Glxianlujiage = D("Glxianlujiage");
		$Glchengbenxiang = D("Glchengbenxiang");
		$Glshoujia = D("Glshoujia");
		$oldshoujia = $Glshoujia->where("`shoujiaID` = '$shoujiaID'")->find();
		if(!$oldshoujia )
		{
			$rurl = SITE_ADMIN."Chanpin/xianlujiage/xianluID/".$xianluID;
			doalert('失败，售价项目不存在',$rurl);
		}
		$Glshoujia->where("`shoujiaID` = '$shoujiaID'")->delete_My();
		$rurl = SITE_ADMIN."Chanpin/xianlujiage/xianluID/".$xianluID;
		doalert('成功删除',$rurl);
		
		
    }
	
	//删除线路
    public function deletechanpin() {
 			$postdata = $_POST;
			
			$xianlulist = $postdata['itemlist'];
			if(!$xianlulist)
			{
				if($postdata['forward'])
				$rurl = $postdata['forward'];
				else
				$rurl = '';
				doalert('没有选择',$rurl);
			}
 			$Glxianlu = D("Glxianlu");
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			foreach($xianlulist as $xianluID)
			{
				xianluIsAdmin($xianluID,$this);
				$xianludata = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
				
				//判断状态,锁
				if(!checkByAdminlevel('网管,计调经理,财务操作员,总经理,办事处管理员,联合体管理员',$this))
				{
					$isstatus = array("准备", "等待审核", "审核不通过");
					if(!in_array($xianludata['zhuangtai'],$isstatus) )
						doalert('该线路在报名或截止状态，不允许删除',$rurl);
					if( $xianludata['islock'] == '已锁定' )
						doalert('该线路已锁定，不允许删除',$rurl);
				}
			
				//线路准备
				$xianludata['zhuangtai'] = '准备';
				$Glxianlu->save($xianludata);
				//子团准备
				$gldingdan = D("gldingdan");
				$Glzituan = D("Glzituan");
				$zituanall = $Glzituan->where("`xianluID` = '$xianluID'")->findall();
				foreach($zituanall as $zv){
					$zv['zhuangtai'] = '准备';
					$Glzituan->save($zv);
					
					//定单准备
					$dingdanAll = $gldingdan->where("`zituanID` = '$zv[zituanID]'")->findall();
					foreach($dingdanAll as $dv)
					{
						$dv['check_status'] = '审核不通过';
						$gldingdan->save($dv);
					}
				}
			if($postdata['forward'])
			$rurl = $postdata['forward'];
			doalert('操作功,线路子团订单改成准备',$rurl);
			exit;
			
			//////////////////////////////////////////////////////////////////以下无效
				if($xianludata)
				{
					//异常
					//删除订单和报账单
//					$Glzituan = D("Glzituan");
//					$ztall = $Glzituan->where("`xianluID` = '$xianluID'")->findall();
//					$gldingdan = D("gldingdan");
//					$gl_baozhang = D("gl_baozhang");
//					foreach($ztal as $v)
//					{
//						$gldingdan->where("`zituanID` == '$v[zituanID]'")->delete_My();
//						$gl_baozhang->where("`zituanID` == '$v[zituanID]'")->delete_My();
//					}
					
					//查找价格ID
					$jiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->field('jiageID')->find();
					$jiageID = $jiage['jiageID'];
					//成本删除
					$Glchengbenxiang->where("`jiageID` = '$jiageID'")->delete_My();
					//代理商售价删除
					$Glshoujia->where("`jiageID` = '$jiageID'")->delete_My();
					//价格删除
					$Glxianlujiage->where("`xianluID` = '$xianluID'")->delete_My();
					//清空子团
					$Glzituan = D("Glzituan");
					//$Glzituan->where("`xianluID` = '$xianluID'")->delete_My();
					$Glzituan->where("`xianluID` = '$xianluID' and `zhuangtai` in ('准备','等待审核','审核不通过')")->delete_My();
					//删除日程
					$Glxingcheng = D("Glxingcheng");
					$Glxingcheng->where("`xianluID` = '$xianluID'")->delete_My();
					//删除附属表
					$glxianlu_ext = D("glxianlu_ext");
					$glxianlu_ext->where("`xianluID` = '$xianluID'")->delete_My();
					//删除附属表
					$glbaotuan_ext = D("Glbaotuan_ext");
					$glbaotuan_ext->where("`xianluID` = '$xianluID'")->delete_My();
					//删除附属成本价格显示
					$glchengben = D("glchengben");
					$glchengben->where("`jiageID` = '$jiageID'")->delete_My();
					
					//线路删除
					$Glxianlu->where("`xianluID` = '$xianluID'")->delete_My();
 				}
 			}
			if($postdata['forward'])
			$rurl = $postdata['forward'];
			doalert('成功删除',$rurl);
    }
	
	
	//子团管理
    public function zituanguanli() {
		$xianluID = $_GET['xianluID'];
		
		//xianluIsAdmin($xianluID,$this);
		//同部门计调操作员可以互改。
		xianluIsDepartment($xianluID,$this);
		
		$Glxianlu = D("Glxianlu");
		$Glzituan = D("Glzituan");
		$xianlu = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
		$zituanAll = $Glzituan->where("`xianluID` = '$xianluID'")->findall();
        $this->assign('xianluID',$xianluID);
        $this->assign('xianlu',$xianlu);
        $this->assign('zituanAll',$zituanAll);
		
		$typeurl = '产品发布 》  '.$xianlu['guojing'].' 》  '.$xianlu['xianlutype'].' 》  子团管理';
		$this->assign ( "navlist", $typeurl );
		
		if($_GET['showtype'] == '审核')
		{
        $this->display('Shenhe/zituanjilu');
		}
		else
		{
        $this->display();
		}
		
    }


    private function shengchengzituan($postdata,$xianluID) {
			$Glzituan = D("Glzituan");
			$datelist = split('[;]',$postdata['chutuanriqi']);
			foreach($datelist as $date)
			{
				$zituan['xianluID'] = $xianluID;
				list($y,$m,$d) = split("[-]",$date);
				$last = $Glzituan->order("zituanID desc")->find();
				$lastid = $last['zituanID']+1;
				$zituan['tuanhao'] = $postdata['bianhao'].$lastid;
				$zituan['zituanID'] = $lastid;
				$zituan['zhuangtai'] = '准备';
				//同业，办事处相应修改   by gaoyang
				if(checkByAdminlevel('办事处管理员',$this)){
					$zituan['zhuangtai'] = '报名';
				}
				//dump($condition);
				//修改结束 by gaoyang
				//$zituan['xianlutype'] = '散客产品';
				$zituan['xianlutype'] = $postdata['xianlutype'];
				
				$zituan['user_name'] = $postdata['user_name'];
				$zituan['mingcheng'] = $postdata['mingcheng'];
				$zituan['chutuanriqi'] = $date;
				$zituan['keyword'] = $postdata['guanjianzi'];
				$zituan['tianshu'] = $postdata['tianshu'];
				$zituan['chufadi'] = $postdata['chufadi'];
				$zituan['mudidi'] = $postdata['mudidi'];
				$zituan['guojing'] = $postdata['guojing'];
				$zituan['timerand'] .= $zituan['chutuanriqi'];	
				$zituan['islock'] = '未锁定';	
				$chutuanriqi = strtotime($zituan['chutuanriqi']);
				for($i = 0;$i<$postdata['tianshu'];$i++)
				{
					$zituan['timerand'] .= ";".jisuanriqi($chutuanriqi,1);		
				}
				$zituan['baomingjiezhi'] = $postdata['baomingjiezhi']; 
				$zituan['quankuanriqi'] = $postdata['quankuanriqi']; 
				$zituan['renshu'] = $postdata['renshu'];
				$zituan['kind'] = $postdata['kind'];
				$zituan['time'] = time();
				$zituan['departmentName'] = $postdata['departmentName'];
				$zituan['departmentID'] = $postdata['departmentID'];
				if($postdata['showtype'] == '快速')
				{
					$zituan['zhuangtai'] = '报名';
					$zituan['islock'] = '锁定';
				}
				
				$Glzituan->add_My($zituan);
				
			}
    }

	//删除子团
    public function deletezituan() {
			$postdata = $_POST;
			$xianluID = $postdata['xianluID'];
			xianluIsAdmin($xianluID,$this);
			$zituanlist = $postdata['itemlist'];
			if(!$zituanlist)
			{
				$rurl = SITE_ADMIN."Chanpin/zituanguanli/xianluID/$xianluID";
				doalert('没有选择',$rurl);
			}
			$Glxianlu = D("Glxianlu");
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			$Glzituan = D("Glzituan");
			foreach($zituanlist as $zituanID)
			{
				$condition['islock'] = '未锁定';
				$condition['zituanID'] = $zituanID;
				$zituan = $Glzituan->where($condition)->field('zituanID,chutuanriqi')->find();
				if($zituan)
				{
					if($date)
					$date .= ";".$zituan['chutuanriqi'];
					else
					$date .= $zituan['chutuanriqi'];
				}
				else
				{
					$warningzituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
					$rurl = SITE_ADMIN."Chanpin/zituanguanli/xianluID/$xianluID";
					doalert('团号：'.$warningzituan['tuanhao']."，已被锁定不能删除",$rurl);
				}
			}
			//更改线路产品出团日期
			$xianlu = $Glxianlu->where("`xianluID` = '$xianluID'")->field('xianluID,chutuanriqi')->find();
			$xianlu['chutuanriqi'] = str_replace($date.";","",$xianlu['chutuanriqi']);
			$xianlu['chutuanriqi'] = str_replace(";".$date,"",$xianlu['chutuanriqi']);
			$xianlu['chutuanriqi'] = str_replace($date,"",$xianlu['chutuanriqi']);
			if($xianlu['chutuanriqi'] == '')
			{
				$rurl = SITE_ADMIN."Chanpin/zituanguanli/xianluID/$xianluID";
				doalert('线路产品出团日期不能为空',$rurl);
			}
			//删除子团
			foreach($zituanlist as $zituanID)
			{
				//检查状态
				F_xianlu_status_check($xianluID,$this);	
				$Glzituan->where("`zituanID` = '$zituanID'")->delete_My();
			}
			//修改日期
			$xianlu = $Glxianlu->save_My($xianlu);
			$rurl = SITE_ADMIN."Chanpin/zituanguanli/xianluID/$xianluID";
			doalert('成功删除',$rurl);
    }
	
	
	//提交审核
    public function tijiaoshenhe() {
		//同业，办事处相应修改   by gaoyang
		if(checkByAdminlevel('办事处管理员',$this)){
			doalert('办事处线路无需审核',$rurl);
		}
		//dump($condition);
		//修改结束 by gaoyan
		$xianluID = $_GET['xianluID'];
		
		//xianluIsAdmin($xianluID,$this);
		//同部门计调操作员可以互改。
		xianluIsDepartment($xianluID,$this);
		
		
		$Glxianlu = D("Glxianlu");
		$Glzituan = D("Glzituan");
		//判断状态
		$condition['xianluID'] = $xianluID;
		$xianlu = $Glxianlu->where($condition)->find();
		//判断完整性
		$Glxianlujiage = D("Glxianlujiage");
		$jiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();

		if($xianlu['xianlutype'] != '包团' && !$jiage)
		{
			doalert('申请失败,请检查是否填写价格内容','');
		}
		if(!$xianlu)
		{
			$warningxianlu = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
			if($warningxianlu['islock'] == '已锁定' )
			doalert('申请失败,'.'线路已被锁定，不能提交申请','');
			
			doalert('意外错误',$rurl);
		}
		$zituanAll = $Glzituan->where("`xianluID` = '$xianluID'")->findall();
		$xianlu['zhuangtai'] = '等待审核';
		$Glxianlu->save_My($xianlu);
		foreach($zituanAll as $zituan)
		{
			if($zituan['准备']){
				$zituan['islock'] = '未锁定';
				$zituan['zhuangtai'] = '等待审核';
			}
			$Glzituan->save_My($zituan);
		}
		
		//记录
		$megurl = SITE_ADMIN."Chanpin/editlvyouxianlu/showtype/审核/roletype/计调经理/xianluID/".$xianluID;
		A("Message")->savemessage($xianluID,'线路','审核记录','提交线路审核申请','计调经理',$megurl);
		doalert('提交审核，再次修改该线路则自动变为准备状态！','');
    }



    private function editzituanAll($xianlu) {
		$xianluID = $xianlu['xianluID'];
		
		//xianluIsAdmin($xianluID,$this);
		//同部门计调操作员可以互改。
		xianluIsDepartment($xianluID,$this);
		
		$Glzituan = D('Glzituan');
		$zituanAll = $Glzituan->where("`xianluID` = '$xianluID'")->findall();
		$riqiAll = split(';',$xianlu['chutuanriqi']);
		//先根据子团判断修改和删除
		foreach($zituanAll as $zituan)
		{
			$c=explode($zituan['chutuanriqi'],$xianlu['chutuanriqi']);
			//修改已存在
			if(count($c)> 1)
			{ 
			
					//修改子团内容
					$zituan['baomingjiezhi'] = $xianlu['baomingjiezhi'];
					$zituan['quankuanriqi'] = $xianlu['quankuanriqi'];
					$zituan['mingcheng'] = $xianlu['mingcheng'];
					$zituan['keyword'] = $xianlu['keyword'];
					$zituan['tianshu'] = $xianlu['tianshu'];
					$zituan['mudidi'] = $xianlu['mudidi'];
					$zituan['chufadi'] = $xianlu['chufadi'];
					$zituan['renshu'] = $xianlu['renshu'];
					
					$Glzituan->save($zituan);
//					$temxianlu = $xianlu;
//					$temxianlu['chutuanriqi'] = $zituan['chutuanriqi'];
//					$this->shengchengzituan($temxianlu,$xianluID);
			} 
			else
			{
				//不存在删除
				//判断锁定
				if($zituan['zhuangtai'] == '准备')
				{
					//删除
					$gl_baozhang = D("gl_baozhang");
					$bzd = $gl_baozhang->where("`zituanID` = '$zituan[zituanID]'")->find();
					$gldingdan = D("gldingdan");
					$dd = $gldingdan->where("`zituanID` = '$zituan[zituanID]'")->find();
					
					if($bzd || $dd)
						$locklist .= $zituan['chutuanriqi'].";";
					else
						$Glzituan->where("`zituanID` = '$zituan[zituanID]'")->delete_My();
						
				}
				else
				{
					$locklist .= $zituan['chutuanriqi'].";";
				}
			}
		}
		if($locklist)
				justalert($locklist."日期的子团已被锁定，无法修改或删除！");
		//根据线路判断生成
		foreach($riqiAll as $riqi)
		{
			$zituan = $Glzituan->where("`xianluID` = '$xianluID' and chutuanriqi = '$riqi' ")->find();
			if(!$zituan)
			{
					$temxianlu = $xianlu;
					$temxianlu['chutuanriqi'] = $riqi;
					$this->shengchengzituan($temxianlu,$xianluID);
			}
		}
	  //由于可能存在子团锁定状态不能删除，要逆更新出团时间到线路
		$zituanAll = $Glzituan->where("`xianluID` = '$xianluID'")->findall();
		foreach($zituanAll as $zituan)
		{
			if($chutuanriqi)
			$chutuanriqi .= ";".$zituan['chutuanriqi'];
			else
			$chutuanriqi .= $zituan['chutuanriqi'];
		}
		$xianlu['chutuanriqi'] = $chutuanriqi;
		$Glxianlu = D("Glxianlu");
		$Glxianlu->save_My($xianlu);
	}





	//线路解锁
    public function xianlujiesuo() {
		
			//经理级
			if(!checkByAdminlevel('计调经理,网管',$this))
			{
				doalert('只有经理可以锁定和解锁！','');
			}
 			$postdata = $_POST;
			$xianlulist = $postdata['itemlist'];
 			if(!$xianlulist)
			{
				if($postdata['forward'])
				$rurl = $postdata['forward'];
//				else
//				$rurl = SITE_ADMIN."Chanpin/sankechanpin";
				doalert('没有选择',$rurl);
			}
 			$Glxianlu = D("Glxianlu");
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			
			foreach($xianlulist as $xianluID)
			{
				
				//xianluIsAdmin($xianluID,$this);
				//同部门计调操作员可以互改。
				xianluIsDepartment($xianluID,$this);
				
				$xianludata = $Glxianlu->where("`xianluID` = '$xianluID'")->field('xianluID')->find();
				if($xianludata)
				{
					//线路解锁
					$xianludata['islock'] = '未锁定';
					$Glxianlu->save_My($xianludata);
					//记录
					A("Message")->savemessage($xianluID,'线路','操作记录','线路解锁');
				}
				
 			}
			if($postdata['forward'])
			$rurl = $postdata['forward'];
//			else
//			$rurl = '';
			doalert('线路已解除锁定','');
 	}


	//线路锁定
    public function xianlusuoding() {
		
			//经理级
			if(!checkByAdminlevel('计调经理,网管',$this))
			{
				doalert('只有经理可以锁定和解锁！','');
			}
			$postdata = $_POST;
			$xianlulist = $postdata['itemlist'];
			if(!$xianlulist)
			{
				if($postdata['forward'])
				$rurl = $postdata['forward'];
//				else
//				$rurl = SITE_ADMIN."Chanpin/sankechanpin";
				doalert('没有选择',$rurl);
			}
			$Glxianlu = D("Glxianlu");
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			foreach($xianlulist as $xianluID)
			{
				
				//xianluIsAdmin($xianluID,$this);
				//同部门计调操作员可以互改。
				xianluIsDepartment($xianluID,$this);
				
				$xianludata = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
				if($xianludata)
				{
					//线路解锁
					$xianludata['islock'] = '已锁定';
					$Glxianlu->save_My($xianludata);
					//记录
					A("Message")->savemessage($xianluID,'线路','操作记录','锁定线路');
				}
			}
			if($postdata['forward'])
			$rurl = $postdata['forward'];
//			else
//			$rurl = SITE_ADMIN."Chanpin/sankechanpin";
			doalert('线路锁定成功',$rurl);
	}






	//线路锁定
    public function dochangestatus() {
			$postdata = $_POST;
			$xianlulist = $postdata['itemlist'];
			if(!$xianlulist)
			{
				if($postdata['forward'])
				$rurl = $postdata['forward'];
//				else
//				$rurl = SITE_ADMIN."Chanpin/sankechanpin";
				doalert('没有选择',$rurl);
			}
			$Glxianlu = D("Glxianlu");
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			
			foreach($xianlulist as $xianluID)
			{
				
				//xianluIsAdmin($xianluID,$this);
				//同部门计调操作员可以互改。
				xianluIsDepartment($xianluID,$this);
				
				$xianludata = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
					
				$type = $_GET['type'];
				if($type == '截止')
						$xianludata['zhuangtai'] = '截止';
				if($type == '报名')
						$xianludata['zhuangtai'] = '报名';
				
				if($xianludata)
				{
					$Glxianlu->save_My($xianludata);
					//记录
					A("Message")->savemessage($xianluID,'线路','操作记录',$type);
				}
			}
			if($postdata['forward'])
			$rurl = $postdata['forward'];
			else
			$rurl = SITE_ADMIN."Chanpin/sankechanpin";
			doalert('线路'.$type.'操作成功',$rurl);
	}



	//复制生成
    public function copytonew() {
		
			$postdata = $_POST;
			$xianlulist = $postdata['itemlist'];
			if(!$xianlulist)
			{
				if($postdata['forward'])
				$rurl = $postdata['forward'];
//				else
//				$rurl = SITE_ADMIN."Chanpin/sankechanpin";
				doalert('没有选择',$rurl);
			}
			
			$Glxianlu = D("Glxianlu");
			$Glxianlu_ext = D("Glxianlu_ext");
			$Glxianlujiage = D("Glxianlujiage");
			$Glxingcheng = D("Glxingcheng");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			$Glyiriyou = D("Glyiriyou");
			$Glticketorder = D("Glticketorder");
		
			foreach($xianlulist as $xianluID){
				$xianlu = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
				if(!$xianlu)
					doalert('发生错误','');
				
				//线路复制
				$copyxianlu = $xianlu;
				$copyxianlu['xianluID'] = '';
				$copyxianlu['mingcheng'] = $copyxianlu['mingcheng'].'[复制线路]';
				$copyxianlu['bianhao'] = "DLGL".date('ymd',time());
				$copyxianlu['zhuangtai'] = '准备';
				$copyxianlu['chutuanriqi'] = '';
				
				$copyxianlu['islock'] = '未锁定';
				$copyxianlu['user_name'] = $this->roleuser['user_name'];
				$copyxianlu['ispub'] = '未发布';
				$copyxianlu['time'] = time();
				
				//同业，办事处相应修改
				if(checkByAdminlevel('办事处管理员',$this)){
					$copyxianlu['zhuangtai'] = '报名';	//办事处的人发的发布直接进入报名状态
					
				}
				
				$newid = $Glxianlu->add_My($copyxianlu);
				if($copyxianlu['guojing'] == '境外'){
				//附加表，境外
					$xianluext = $Glxianlu_ext->where("`xianluID` = '$xianluID'")->find();
					$xianluext['xianluID'] = $newid;
					$xianluext['xianlu_extID'] = '';
					$xianluext['islock'] = '未锁定';
					$Glxianlu_ext->add_My($xianluext);
				}
				
				//价格
				$xianlujiage = $Glxianlujiage->where("`xianluID` = '$xianluID'")->find();
				$copyxianlujiage = $xianlujiage;
				$copyxianlujiage['jiageID'] = '';
				$copyxianlujiage['xianluID'] = $newid;
				$copyxianlujiage['islock'] = '未锁定';
				$newjiageID = $Glxianlujiage->add_My($copyxianlujiage);
				//成本项
				$chengbenAll = $Glchengbenxiang->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
				foreach($chengbenAll as $copychengben){
					$copychengben['chengbenID'] = '';
					$copychengben['jiageID'] = $newjiageID;
					$Glchengbenxiang->add_My($copychengben);
				}
				//行程
				$xingchengAll = $Glxingcheng->where("`xianluID` = '$xianluID'")->order("id ASC")->findall();
				foreach($xingchengAll as $copyxingcheng){
					$copyxingcheng['id'] = '';
					$copyxingcheng['xianluID'] = $newid;
					$Glxingcheng->add_My($copyxingcheng);
				}
				//售价
				$shoujiaAll = $Glshoujia->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
				foreach($shoujiaAll as $copyshoujia){
					$copyshoujia['shoujiaID'] = '';
					$copyshoujia['jiageID'] = $newjiageID;
					$Glshoujia->add_My($copyshoujia);
				}
				if($copyxianlu['xianlutype'] == '自由人'){
				//订票	
					$ticketAll = $Glticketorder->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
					foreach($ticketAll as $copyticket){
						$copyticket['ticketorderID'] = '';
						$copyticket['jiageID'] = $newjiageID;
						$Glticketorder->add_My($copyticket);
					}
				//一日游
					$yiriyouAll = $Glyiriyou->where("`jiageID` = '$xianlujiage[jiageID]'")->findall();
					foreach($yiriyouAll as $copyyiriyou){
						$copyyiriyou['yiriyouID'] = '';
						$copyyiriyou['jiageID'] = $newjiageID;
						$Glyiriyou->add_My($copyyiriyou);
					}
				}
				
				//生成子团
				//$this->shengchengzituan($copyxianlu,$newid);

			}
			
			doalert('线路复制成功','');

	}















}
?>