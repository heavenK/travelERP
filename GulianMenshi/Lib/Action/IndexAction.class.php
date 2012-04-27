<?php

class IndexAction extends CommonAction{

    public function index() {
		$this->redirect('Index/search');
    }
	
	
    public function admintalk() {
		
        $this->assign('roleuser',$this->roleuser);
        $this->display();
    }
	
	private function _getxianlupirce($xianlu)
	{
			//价格
			$Glxianlujiage = D("Glxianlujiage");
			$xianlujiage = $Glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
			
			$companytype = $this->company['type'];
			$companyjibie = $this->company['jibie'];
			$companyID = $this->company['lvxingsheID'];
			$admintype = $this->company['admintype'];
			$depart_type = $this->my_department['description'];
			
			//区分直营,加盟门市,联合体,办事处
			if($depart_type){
				$companytype = $depart_type;
			}
			
			if($admintype == '系统'){
				$companytype = '直营门市';
				$companyjibie = '全部';
			}

			
			$Glshoujia = D("Glshoujia");
			$thecompany1 = $Glshoujia->where("`hezuohuobanID` = '$companyID'  and `jiageID` = '$xianlujiage[jiageID]'")->find();
			$thecompany2 = $Glshoujia->where("`dailileixing` = '$companytype' and `jiageID` = '$xianlujiage[jiageID]' ")->find();
			
			if($companytype == '直营门市' || $companytype == '加盟门市'){
				$thecompany2_1 = $Glshoujia->where("`dailileixing` = '门市' and `jiageID` = '$xianlujiage[jiageID]'")->find();
			}
			elseif($companytype == '联合体'){
				$thecompany2_1 = $Glshoujia->where("`dailileixing` = '同业' and `jiageID` = '$xianlujiage[jiageID]'")->find();
			}
			
			$thecompany3 = $Glshoujia->where("`dailileixing` = '全部' and `jiageID` = '$xianlujiage[jiageID]'")->find();
			if($thecompany1){
				$the = $thecompany1;
			}
			elseif($thecompany2){
				$the = $thecompany2;
			}
			elseif($thecompany2_1){
				$the = $thecompany2_1;
			}
			elseif($thecompany3){
				$the = $thecompany3;
			}
			if(!$the){
				$the = $Glshoujia->where("`jiageID` = '$xianlujiage[jiageID]'")->find();
			}
			/*if($xianlu['companytype'] == '同业'){
				$the = $Glshoujia->where("`jiageID` = '$xianlujiage[jiageID]'")->find();
			}*/
			
			return $the;
			
	}
	
	
    public function search() {

		$postdata = $_GET;

		//$Glxianlu = D("Glxianlu");
		//$Glxianlu = D("xianlu_lvxingshe");
		//为了排序
		$Glxianlu = D("Zituan_xianlu_lvxingshe");
		
		if(checkByAdminlevel('联合体成员',$this))
		{
			$condition['lvxingsheID'] = $this->company['lvxingsheID'];
			$condition['openTongye'] = 1;
			if(!$_GET['companytype'])
			$_GET['companytype'] = '同业';
		}
		elseif(checkByAdminlevel('办事处管理员',$this))
		{
			$condition['lvxingsheID'] = $this->company['lvxingsheID'];
			$condition['companytype'] = '办事处';
			if(!$_GET['companytype'])
			$_GET['companytype'] = '办事处';
		}
		elseif($this->company['lvxingsheID'] != 1)
		$condition['openMenshi'] = 1;
		
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p' || $key == 'iframe' || $key == 'pagenum')
			{
				$this->assign($key,$value);
				continue;
			}
			if($key == 'xianlutype')
			{
				$condition[$key] = array('exp'," = '$value' and `xianlutype` != '包团'");
				continue;
			}
			if($key == 'keyword')
			{
				$condition['mingcheng'] = array('like','%'.$value.'%');
				continue;
			}
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		//$condition['zhuangtai'] = '报名';
		$condition['zhuangtai'] = array("exp","= '报名' and `xianlutype` != '包团' ");
		
		if(!$_GET['companytype'])
			$condition['companytype'] = array(array("neq","办事处"),array("neq","同业"),'AND');
		if($_GET['companytype'] == '全部')
			unset($condition['companytype']);
		
		//dump($condition);
		
		
		
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $Glxianlu->where($condition)->count();
		$p= new Page($count,15);
		$page = $p->show();
        //$xianluAll = $Glxianlu->where($condition)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		$xianluAll = $Glxianlu->where($condition)->group("xianluID")->order("chutuanriqi DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
        $this->assign('page',$page);
		
		$Glzituan = D("Glzituan");
		//数据解析
		$k = 0;
		$Glshoujia = D("Glshoujia");
		foreach($xianluAll as $xianlu)
		{
			
			$xianluAll[$k]['price'] = $this->_getxianlupirce($xianlu);
			
			//子团处理
			$zituanAll = $Glzituan->where("`xianluID` = '$xianlu[xianluID]'")->findall();
			$j = 0;
			foreach($zituanAll as $zituan)
			{
				$xianluAll[$k]['zituanAll'][$j] = $zituan;
				
				//子团售价修正
				$zituanshoujia = $xianluAll[$k]['price']['chengrenshoujia'] + $zituan['adultxiuzheng'];
				$xianluAll[$k]['zituanAll'][$j]['shoujia'] = $zituanshoujia;
				//剩余名额
				$zituanID = $zituan['zituanID'];
				$shengyu = $this->getzituanrenshu($zituanID); 
				$xianluAll[$k]['zituanAll'][$j]['shengyu'] = $shengyu;
				
				//直营门市显示成本
				if($this->my_department['description'] == '直营门市'){
					$xianluAll[$k]['zituanAll'][$j]['shoujia_chengben'] = $xianluAll[$k]['price']['chengrenshoujia'] - $xianluAll[$k]['price']['chengrenlirun'];
				}
				
				
				$j++;
			}
			
			$k++;
		}
		
		//时间列表显示
		$xianludatas = $xianluAll;
		//数据解析
		$i = 0;
		foreach($xianludatas as $xianlu){
			$chutuanriqi = split('[;]',$xianlu['chutuanriqi']);
			foreach($chutuanriqi as $riqi){
				if($newdatelist)
				$newdatelist .= ','."'".$riqi."'";
				else
				$newdatelist .= "'".$riqi."'";
			}
			$xianludatas[$i]['chutuanriqi'] = $newdatelist;
			$newdatelist = '';
			$Glxianlujiage = D("Glxianlujiage");
			$jiage = $Glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
			$xianludatas[$i]['chengrenzongjia'] = $jiage['chengrenzongjia'];
			//发布人
			$Glkehu = D("Glkehu");
			$kehu = $Glkehu->where("`user_name` = '$xianlu[user_name]'")->find();
			$xianludatas[$i]['realname'] = $kehu['realname'];
			$i++;
		}
		$xianluAll = $xianludatas;
		
        $this->assign('xianluAll',$xianluAll);
		if($postdata['xianlutype']!='自由人')
		$this->assign('marktab',$_GET['guojing']);
		else
		$this->assign('marktab',$_GET['xianlutype']);
		if($_GET['xianlutype'] == null)
		$this->assign('marktab','境外');
		if($_GET['companytype'] == '同业')
		$this->assign('marktab','联合体');
		if($_GET['companytype'] == '办事处')
		$this->assign('marktab','办事处');
		
		$this->display('index');
    }
	
    private function getzituanrenshu($zituanID) 
	{
		  $zituan_xianlu = D("zituan_xianlu_lvxingshe");
		  $zituan = $zituan_xianlu->where("`zituanID` = '$zituanID'")->find();
		  $Gltuanyuan = D("tuanyuan_dingdan");
		  $Gldingdan = D("dingdan_zituan");
		  $dingdanAll = $Gldingdan->where("`zituanID` = '$zituan[zituanID]'")->findall();
		  $querennum = 0;
		  $zhanweinum = 0;
		  
		  foreach($dingdanAll as $dingdan)
		  {
			  	  if($zituan['ischild']){
					  $querennum += $Gltuanyuan->where("`zhuangtai` = '确认' and `dingdanID` = '$dingdan[dingdanID]' and `manorchild` = '成人'")->count();
					  $zhanweinum += $Gltuanyuan->where("`zhuangtai` = '占位' and `dingdanID` = '$dingdan[dingdanID]' and `manorchild` = '成人'")->count();
  
				  }else{
					  $querennum += $Gltuanyuan->where("`zhuangtai` = '确认' and `dingdanID` = '$dingdan[dingdanID]'")->count();
					  $zhanweinum += $Gltuanyuan->where("`zhuangtai` = '占位' and `dingdanID` = '$dingdan[dingdanID]'")->count();
				  }
		  }
		  $shengyu = $zituan['renshu'] - $querennum - $zhanweinum;
		  return $shengyu;
	}

	
    public function zituanxinxi() {
		
		$zituanID = $_GET['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		//报名截止
		$huituanriqi = jisuanriqi($zituan['chutuanriqi'],$zituan['tianshu']);
		$baomingjiezhi = jisuanriqi($zituan['chutuanriqi'],$zituan['baomingjiezhi'],'减少');
		//$Glxianlu = D("Glxianlu");
		$Glxianlu = D("xianlu_lvxingshe");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		$glxianlu_ext = D("glxianlu_ext");
		$xianlu['ext'] = $glxianlu_ext->where("`xianluID` = '$zituan[xianluID]'")->find();

		$shoujia = $this->_getxianlupirce($xianlu);
		
		//剩余名额
		$shengyu = $this->getzituanrenshu($zituanID); 
		
		//售价
		$zituan['chengrenshoujia'] = $shoujia['chengrenshoujia'] + $zituan['adultxiuzheng'];
		$zituan['ertongshoujia'] = $shoujia['ertongshoujia'] + $zituan['childxiuzheng'];
		//图片
		if($xianlu['tupian'])
		{
			$scenicspot = D('scenicspot');
			$tupianAll = split(',',$xianlu['tupian']);
			$i=0;
			foreach($tupianAll as $tupian)
			{
				$xianlu['tupianAll'][$i] = $scenicspot->where("`title` = '$tupian'")->find();
				$i++;
			}
		}
		//视频
		if($xianlu['shipin'])
		{
			$videos = D('videos');
			$shipinAll = split('[,]',$xianlu['shipin']);
			$i=0;
			foreach($shipinAll as $shipin)
			{
				$xianlu['shipinAll'][$i] = $videos->where("`title` = '$shipin'")->find();
				$i++;
			}
		}
		//创建者信息
		
		$Glkehu = D('Glkehu');
		
		//打印时显示登录人信息 by heavenK
		if($_GET['doprint'] == '打印'){
			$kehu = $Glkehu->where("`user_name` = '".$this->roleuser['user_name']."'")->find();
		}else{
			$kehu = $Glkehu->where("`user_name` = '".$xianlu['user_name']."'")->find();
		}
		$glbasedata = D("glbasedata");
		$dp = $glbasedata->where("`id` = '$kehu[department]'")->find();
		$kehu['department'] = $dp['title'];
        $this->assign('kehu',$kehu);
        $this->assign('huituanriqi',$huituanriqi);
        $this->assign('baomingjiezhi',$baomingjiezhi);
        $this->assign('shengyu',$shengyu);
        $this->assign('shoujia',$shoujia);
        $this->assign('xianlujiage',$xianlujiage);
        $this->assign('xianlu',$xianlu);
        $this->assign('zituan',$zituan);
		
		$lvxingsheID = $this->roleuser['lvxingsheID'];
		$gllvxingshe = D('gllvxingshe');
		$company =$gllvxingshe->where("`lvxingsheID` = '$lvxingsheID'")->find();
        $this->assign('company',$company);
		
		//显示行程
		$Glxingcheng = D("Glxingcheng");
		$xingcheng = $Glxingcheng->where("`xianluID` = '$xianlu[xianluID]'")->order("id asc")->findAll();
		$this->assign('xingchengAll',$xingcheng);
		
        $this->assign('xianlutype',$zituan['xianlutype']);
		
		if($_GET['doprint'] == '打印'){
			if($xianlu['guojing'] == '境外')
			$this->display('jingwaizituanprint');
			else
			$this->display('zituanprint');
		}
		else
		{
			if($zituan['xianlutype'] == '自由人')
			$this->display();
			else
			$this->display();
		}
    }
	
	
	
    public function baoming() {
		//dump($this->my_department);exit;
		F_checkuserinfo($this);
		
		$navtitle = '组团报名';
		$this->assign('navtitle',$navtitle);
		
		$zituanID = $_GET['zituanID'];
		
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		
		//$Glxianlu = D("Glxianlu");
		$Glxianlu = D("xianlu_lvxingshe");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		
		$Glxianlujiage = D("Glxianlujiage");
		$xianlujiage = $Glxianlujiage->where("`xianluID` = '$zituan[xianluID]'")->find();
		
		//为了选择所有人
		$glkehu = D('Glkehu');
		$kehu_all = $glkehu->findall();
		$this->assign('kehu_all',$kehu_all);
		
		//为了取成本
		$Glchengben = D("Glchengben");
		$Gldingdan = D("Gldingdan");
		$dindan_all = $Gldingdan->where("`zituanID` = '$zituanID'")->findAll();
		
		//获取子团人数。
		$renshu = 0;
		foreach($dindan_all as $dingdans){
			$renshu += $dingdans['chengrenshu'] + $dingdans['ertongshu'];
		}
		$chengben_all = $Glchengben->where("`jiageID` = '$xianlujiage[jiageID]'")->order("renshu ASC")->findAll();
		
/*		if(!$chengben_all) $chengben_now = '暂无成本价格';	
		else{
			$i = 0;
			foreach($chengben_all as $chengbens){
				
				if ($renshu >= $chengbens['renshu']) {
					$chengben_now = $chengbens['chengben'];
					break;
				}
				$i++;
			}
			
			if(!$chengben_now) $chengben_now = $chengben_all[$i-1]['chengben'];
		}*/
		
		$this->assign('renshu',$renshu);
		$this->assign('chengben_all',$chengben_all);
		
		if($_GET['type'] == null)
		$_GET['type'] = '包团';
		
		$Glshoujia = D("Glshoujia");
		//价格
		if($_GET['type'] != '包团')
		{
			$this->assign('airhotle',1);
			$this->assign('type',$_GET['type']);
			if($_GET['type'] == '机票酒店')
			{
					$jiage['adultcost'] = $xianlujiage['adultcostair'] + $xianlujiage['adultcosthotle'];
					$jiage['childcost'] = $xianlujiage['childcostair'] + $xianlujiage['chhildcosthotle'];
					$jiage['cut'] = $xianlujiage['aircut'] + $xianlujiage['hotlecut'];
					
				}
			if($_GET['type'] == '机票')
			{
					$jiage['adultcost'] = $xianlujiage['adultcostair'];
					$jiage['childcost'] = $xianlujiage['childcostair'];
					$jiage['cut'] = $xianlujiage['aircut'];
				}
			if($_GET['type'] == '酒店')
			{
					$jiage['adultcost'] = $xianlujiage['adultcosthotle'];
					$jiage['childcost'] = $xianlujiage['childcosthotle'];
					$jiage['cut'] = $xianlujiage['hotlecut'];
				}
			$this->assign('jiage',$jiage);
			$Gldingdan = D('gldingdan');
			$where['type'] = array('in','机票酒店,机票,酒店');
			$where['zituanID'] = $zituanID;
			$dingdanAll = $Gldingdan->where($where)->findall();
			$renshu = 0;
			foreach($dingdanAll as $dingdan){
				$renshu += $dingdan['chengrenshu'] + $dingdan['ertongshu'];
			}
			$shengyu = $xianlujiage['airhotlenumber'] - $renshu ;
			$this->assign('shengyu',$shengyu);
		}
		else
		{
			
			$shoujia = $this->_getxianlupirce($xianlu);
			//剩余名额
			$shengyu = $this->getzituanrenshu($zituanID); 
			$this->assign('shengyu',$shengyu);
		}
		
		//售价
		$chengren_price = $shoujia['chengrenshoujia'] + $zituan['adultxiuzheng'];
		$ertong_price = $shoujia['ertongshoujia'] + $zituan['childxiuzheng'];
		
		//直营门市显示成本
		if($this->my_department['description'] == '直营门市'){
			$chengren_chengben = $shoujia['chengrenshoujia'] - $shoujia['chengrenlirun'];
			$ertong_chengben = $shoujia['ertongshoujia'] - $shoujia['ertonglirun'];
			$this->assign('chengren_chengben',$chengren_chengben);
        	$this->assign('ertong_chengben',$ertong_chengben);
		}
		
		if($zituan['user_name'] == $this->roleuser['user_name'])
		{
			$cut = $chengren_price / 2;
		}
		else
			$cut = $shoujia['cut'];
		
		//其他信息
        $this->assign('roleuser',$this->roleuser);
		$lvxingsheID = $this->roleuser['lvxingsheID'];
		$gllvxingshe = D('gllvxingshe');
		$company = $gllvxingshe->where("`lvxingsheID` = '$lvxingsheID'")->find();
        $this->assign('company',$company);
		
		//大客户
		$glbasedata = D('glbasedata');
		$bigmanAll = $glbasedata->where("`type` = '大客户'")->findall();
        $this->assign('bigmanAll',$bigmanAll);
		
		$this->assign('chengren_price',$chengren_price);
        $this->assign('ertong_price',$ertong_price);
		$this->assign('cut',$cut);
		
        $this->assign('shoujia',$shoujia);
        $this->assign('xianlujiage',$xianlujiage);
        $this->assign('xianlu',$xianlu);
        $this->assign('zituan',$zituan);
        $this->display();
    }
	
	
	
    public function dopostbaoming() {
		F_checkuserinfo($this);
		
		if (md5($_POST['verifyTest']) != Session::get('verify')) {  
				justalert('验证码错误,请刷新验证码并重新填写！');
				gethistoryback();
		  } 
		  else
		  Session::set('verify',null);
		  
		$postdata = $_POST;
		  
		if (!$postdata['zhuangtai']) {  
				justalert('报名状态未填写！');
				gethistoryback();
		  } 
		if (!$postdata['chengrenshu'] && !$postdata['ertongshu']) 
		{  
				justalert('人数未填写！');
				gethistoryback();
		  } 

		if($postdata['ischild'] == 'on')
		{
			$postdata['xuqiu'] .= '#'.$postdata['ertongshu'].'名儿童不占位！';
			$postdata['ertongshu'] = 0;
		}
		
		$zituanID = $postdata['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		
		//剩余名额
		$shengyu = $this->getzituanrenshu($zituanID); 
		$xuqiurenshu = $postdata['chengrenshu']+$postdata['ertongshu'];
		if($xuqiurenshu > $shengyu){
			justalert('失败！超出团队计划人数','');
			gethistoryback();
		}
			
//		if($zituan['zhuangtai']!='报名' || $zituan['islock']!='已锁定'){
//			justalert('失败！子团未在报名状态，或已经上锁');
//			gethistoryback();
//		}
		if($zituan['zhuangtai']!='报名'){
			justalert('失败！子团未在报名状态');
			gethistoryback();
		}
		
		//$Glxianlu = D("Glxianlu");
		$Glxianlu = D("xianlu_lvxingshe");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		$Glxianlujiage = D("Glxianlujiage");
		$xianlujiage = $Glxianlujiage->where("`xianluID` = '$zituan[xianluID]'")->find();
		
		if($postdata['type'] != '包团' && $postdata['type']){
				$Gldingdan = D('gldingdan');
				$where['type'] = array('in','机票酒店,机票,酒店');
				$where['zituanID'] = $zituanID;
				$dingdanAll = $Gldingdan->where($where)->findall();
				$renshu = 0;
				foreach($dingdanAll as $dingdan){
					$renshu += $dingdan['chengrenshu'] + $dingdan['ertongshu'];
				}
				$shengyu = $xianlujiage['airhotlenumber'] - $renshu ;
				if($xuqiurenshu > $xianlujiage['airhotlenumber']){
					justalert('失败！人数不符合要求');
					gethistoryback();
				}
				
		}
		
		$Glshoujia = D("Glshoujia");
		$chengrenshoujia = $postdata['chengren_price'];
		$ertongshoujia = $postdata['ertong_price'];
		
		if($chengrenshoujia < 0 || $ertongshoujia < 0)
		{
			justalert('失败！价格异常');
			gethistoryback();
		}

		$Gldingdan = D("gldingdan");
		$num = $Gldingdan->execute('select * from gldingdan');
		if($num<10)
			$num = '000'.$num;
		else if($num<100)
			$num = '00'.$num;
		else if($num<1000)
			$num = '0'.$num;
		else
			$num = $num;
		$postdata['bianhao'] = "DD".date('Ymd',time()).$num;
		$postdata['zituanID'] = $zituanID;
		//$postdata['tuanhao'] = $postdata['tuanhao'];
		$postdata['yongjin'] = $postdata['chengrenshu']*$shoujia['chengrenyongjin'] + $postdata['ertongshu']*$shoujia['ertongyongjin'];
		//$postdata['chengrenshu'] = $postdata['chengrenshu'];
		$postdata['chengrenjia'] = $chengrenshoujia;
		$postdata['lianxiren'] = $postdata['lianxiren'];
		$postdata['chutuanriqi'] = $zituan['chutuanriqi'];
		$postdata['mingcheng'] = $zituan['mingcheng'];
		$postdata['daokuan'] = '未付款';//管理员确认款项
		$postdata['jiage'] = $postdata['chengrenshu']*$chengrenshoujia + $postdata['ertongshu']*$ertongshoujia;
		//$postdata['ertongshu'] = $postdata['ertongshu'];
		$postdata['ertongjia'] = $ertongshoujia;
		$postdata['telnum'] = $postdata['telnum'];
		$postdata['zhuangtai'] = $postdata['zhuangtai'];
		$postdata['xuqiu'] = $postdata['xuqiu'];
		$postdata['time'] = time();
		$postdata['islock'] = "未锁定";
		if($xianlu['xianlutype'])
		$postdata['xianlutype'] = $xianlu['xianlutype'];
		$postdata['guojing'] = $xianlu['guojing'];
		
		$postdata['user_name'] = $this->roleuser['user_name'];
		$postdata['laiyuan'] = $this->roleuser['lvxingsheID'];
		$postdata['type'] =  $postdata['type'];
		$postdata['bigmanID'] =  $postdata['bigmanID'];
		$departmentID = $this->roleuser['department'];
		$postdata['departmentID'] =  $departmentID;
		
		
		//状态
//		if($xianlu['companytype'] == '同业')
//			$postdata['check_status'] =  '等待审核';
//		else
//		{
//			if($zituan['guojing'] == '国内')
//			$postdata['check_status'] =  '审核通过';
//			else
//			$postdata['check_status'] =  '审核通过';
//		}
		
		$postdata['check_status'] =  '准备';
		
		$dingdanID = $Gldingdan->add($postdata);
		
		//提醒
//		$megurl = SITE_MENSHI."/Dingdan/dingdanxinxi/showtype/审核/dingdanID/".$dingdanID;
//		A("Message")->savemessage($dingdanID,'订单','审核记录','报名子团订单审核提醒','计调操作员,计调经理',$megurl);
		
		
		//占位生成团员数据
		$Gltuanyuan = D('Gltuanyuan');
		$insertdat['dingdanID'] = $dingdanID;
		$insertdat['zituanID'] = $zituanID;
		$insertdat['time'] = time();
		$insertdat['usertype'] = '订团';
		$insertdat['zhuangtai'] = $postdata['zhuangtai'];
		$insertdat['islock'] = '未锁定';
		
		for($i=0;$i<$postdata['chengrenshu'];$i++){
			$insertdat['manorchild'] = '成人';
			$insertdat['jiaoqian'] = $chengrenshoujia;//应交钱数
			$Gltuanyuan->add($insertdat);
		}
		
		for($i=0;$i<$postdata['ertongshu'];$i++){
			$insertdat['manorchild'] = '儿童';
			$insertdat['jiaoqian'] = $ertongshoujia;//应交钱数
			$Gltuanyuan->add($insertdat);
		}
		
		//生成报账单项
		$dd = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		//$this->dingdan_bzd_item($dd);
		
		$rurl = SITE_MENSHI."Index/mingdan/dingdanID/".$dingdanID;
		tiaozhuan($rurl);
		
    }
	
    private function dingdan_bzd_item($dd) {
		
		$gl_baozhang = D('gl_baozhang');
		$bzd = $gl_baozhang->where("`zituanID` = '$dd[zituanID]'")->find();
		if(!$bzd){
			$t['zituanID'] = $dd['zituanID'];
			$t['time'] = time();
			
			$glzituan = D("glzituan");
			$zituan = $glzituan->where("`zituanID` = $dd[zituanID]")->find();
			$t['caozuoren'] = $zituan['user_name'];
			$baozhangID = $gl_baozhang->add($t);
		}
		else
			$baozhangID = $bzd['baozhangID'];
		if(!$baozhangID)	
			doalert("错误",'');
		$DJbaozhangitem = D('gl_baozhangitem');
		//大客户生成报账单项目
		//生成报账单应收款项
		if($dd['bigmanID'])
		{
			$glbasedata = D("glbasedata");
			$bigman = $glbasedata->where("`id` = '$dd[bigmanID]'")->find();
			if(!$bigman)
				doalert("大客户信息异常，请联系管理员",'');
			$item['title'] = $this->my_department['title'].'大客户：'.$bigman['title'];
			$item['bigmanID'] = $dd['bigmanID'];
		}
		else
			$item['title'] = $this->my_department['title']."团费";
			
		$item['departmentID'] = $this->my_department['id'];
		$item['baozhangID'] = $baozhangID;
		$item['edituser'] = $dd['user_name'];
		$item['price'] = $dd['jiage'];
		$item['type'] = '结算项目';
		$item['remark'] = '成人'. $dd['chengrenshu'].'人，'.'儿童'. $dd['ertongshu'].'人';
		$item['time'] = time();
		$item['pricetype'] = '现金';
		if($dd['guojing'] == '国内')
			$item['check_status'] = '等待审核';
		else
			$item['check_status'] = '准备';
		$DJbaozhangitem->add($item);
	}
	
	
	
	
    public function mingdan() {
		//非修改页面
		
		$dingdanID = $_GET['dingdanID'];
		$Gldingdan = D("dingdan_zituan_all");
		$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		
		if(!$dingdan)
			doalert("错误",SITE_MENSHI);
			
		$Gltuanyuan = D("gltuanyuan");	
		$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findall();
        $this->assign('tuanyuanAll',$tuanyuanAll);
		
        $this->assign('dingdanID',$dingdanID);
        $this->assign('dingdan',$dingdan);
        //$this->assign('renshu',$renshu);
        $this->display();
    }

	
	
    public function dopostmingdan() {
		
		$Gltuanyuan = D("gltuanyuan");
		$dingdanID = $_POST['dingdanID'];
		
		if($_POST['ajax']){
			$Gltuanyuan->save($_POST);
			exit;
		}
		
		foreach($_POST as $key => $value){
			$i = 0;
			foreach($_POST[$key] as $value2){
				if($key == 'name')
					if(!$value2)
					{
						justalert('失败！所有团员姓名不能为空!!');
						gethistoryback();
					}
				$tuanyuanAll[$i][$key] = $value2;	
				$i++;
			}
		}
		$dingdanpirce = 0;
		foreach($tuanyuanAll as $tuanyuan){
			$Gltuanyuan->save($tuanyuan);
			$dingdanpirce+=$tuanyuan['jiaoqian'];
		}
		$Gldingdan = D("gldingdan");
		$dd = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		$dd['jiage'] = $dingdanpirce;
		$dd['diyinput'] = '手入名单';
		
		if($dd['check_status'] == '准备')
		{
			$dd['check_status'] =  '审核通过';
			//记录1
			$megurl = SITE_MENSHI."/Dingdan/dingdanxinxi/showtype/审核/dingdanID/".$dingdanID;
			A("Message")->savemessage($dingdanID,'订单','审核记录','报名子团订单提醒','计调操作员,计调经理',$megurl);
		}
		
		$Gldingdan->save($dd);
		
		if($_POST['forward'])
		$forward = $_POST['forward'];
		else
		$forward = SITE_MENSHI;
		doalert("成功",$forward);

    }

	
    public function quxiaodingdan() {
		$dingdanID = $_GET['dingdanID'];
		$Gldingdan = D("gldingdan");
		$dingdan_xianlu_lvxingshe = D("dingdan_xianlu_lvxingshe");
	    $dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		if($dingdan['zhuangtai'] == '截止' || $dingdan['islock'] == '已锁定' || $dingdan['check_status'] == '审核通过' )
			doalert("该订单截止或已被审核通过或锁定，不允许删除",'');
			
		if(!checkByAdminlevel('网管',$this)){
			
//			if(checkByAdminlevel('联合体成员',$this)){
//				$dxl = $dingdan_xianlu_lvxingshe->where("`dingdanID` = '$dingdanID'")->find();
//				if($dxl['lvxingsheID'] != $this->company['lvxingsheID'])
//				doalert("您无权对别人的订单进行操作",'');
//			}
//			elseif(!_isadmindingdan($dingdanID,$this))
//				doalert("您无权对别人的订单进行操作",'');
				
			if(checkByAdminlevel('计调经理',$this))
			{
				$departmentID = $dingdan['departmentID'];
				$department_list = unserialize($this->adminuser['department_list']);
				$v = $this->my_department['id'];
				if($v)
				array_push($department_list, $v);
				if(!in_array($departmentID,$department_list))	
				doalert("权限错误!!!",'');	
			}
			if(checkByAdminlevel('计调操作员',$this))
			{
				$glzituan = D("glzituan");
				$zituan = $glzituan->where("`zituanID` = '$dingdan[zituanID]'")->find();
				if($zituan['user_name'] != $this->roleuser['user_name'])
				doalert("权限错误!!!",'');	
			}
			
			
		}
		
		
		$Gltuanyuan = D("gltuanyuan");
		//删除团员
		$Gltuanyuan->where("`dingdanID` = '$dingdanID'")->delete();
		//删除订单
	   $Gldingdan->where("`dingdanID` = '$dingdanID'")->delete();
	   //删除报账项目
	   F_dingdan_bzd_item_delete($dingdanID);

	   //取消提示
	   $megurl = SITE_ADMIN."Dingdan/zituandingdan/zituanID/".$dingdan['zituanID'];
	   A("Message")->savemessage($dingdanID,'订单','审核记录','订单被取消提示','计调操作员,计调经理,网管',$megurl);
	   A("Message")->savemessage($dingdan['zituanID'],'子团','操作记录','订单'.$dingdan['bianhao'].'被取消');
	   
	   doalert("删除成功",SITE_MENSHI.'Dingdan/mydingdan');
	  // doalert("删除成功",'');
	   //tiaozhuan($rurl);
    }



	
    public function showvideo() {
		
		$videoname = $_GET['videoname'];
		$videos = D('videos');
		$video = $videos->where("`title` = '$videoname'")->find();
		$video['video_url'] = stripslashes($video['video_url']);
		//dump($video);
		
        $this->assign('video',$video);
        $this->display();
    }
	
	
	
/*	
    public function zituanprint() {
		
		$zituanID = $_GET['zituanID'];
		$Glzituan = D("Glzituan");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
		
		$Glxianlujiage = D("Glxianlujiage");
		$jiage = $Glxianlujiage->where("`xianluID` = '$zituan[xianluID]'")->find();
		
		$glshoujia = D("glshoujia");
		$jiage = $glshoujia->where("`jiageID` = '$jiage[jiageID]'")->find();
	  	$this->assign('jiage',$jiage);
		
		//处理
		$zituan['huituanriqi'] = jisuanriqi($zituan['chutuanriqi'],$zituan['tianshu']);
		$zituan['chengrenshoujia'] = $jiage['chengrenzongjia'] + $zituan['adultxiuzheng'];
		$zituan['ertongshoujia'] = $jiage['ertongzongjia'] + $zituan['childxiuzheng'];
		
	  	$this->assign('my',$this->roleuser);
	  	$this->assign('company',$this->company);
		
	  	$this->assign('zituan',$zituan);
	  	$this->assign('xianlu',$xianlu);
	  	$this->assign('jiage',$jiage);
		
		$glxianlu_ext = D("glxianlu_ext");
		$xianluext = $glxianlu_ext->where("`xianluID` = '$zituan[xianluID]'")->find();
	  	$this->assign('xianluext',$xianluext);
		
		if($xianlu['guojing'] == '境外')
        $this->display('jingwaizituanprint');
		else
        $this->display();
		
		
    }
	
*/	
	
    public function xianluxinxi() {
		$xianluID = $_GET['xianluID'];
		$Glxianlu = D("Glxianlu");
		$xianlu = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
		
	  	$this->assign('xianlutype',$xianlu['xianlutype']);
		
		//创建者信息
		$Glkehu = D('Glkehu');
		$kehu = $Glkehu->where("`user_name` = '".$xianlu['user_name']."'")->find();
	  	$this->assign('kehu',$kehu);
		
		//图片
		$scenicspot = D('scenicspot');
		$tupianAll = split('[,]',$xianlu['tupian']);
		$i=0;
		foreach($tupianAll as $tupian)
		{
			$xianlu['tupianAll'][$i] = $scenicspot->where("`title` = '$tupian'")->find();
			$i++;
		}
		//视频
		$videos = D('videos');
		$shipinAll = split('[,]',$xianlu['shipin']);
		$i=0;
		foreach($shipinAll as $shipin)
		{
			$xianlu['shipinAll'][$i] = $videos->where("`title` = '$shipin'")->find();
			$i++;
		}
	  	$this->assign('xianlu',$xianlu);
		
        $this->display();
	}
	
	
    public function verify() {  
        $type = isset($_GET['type']) ? $_GET['type'] : 'gif'; 
        import("@.ORG.Image"); 
		Image::buildImageVerify(4, 1, $type); 
    } 	
	
}
?>