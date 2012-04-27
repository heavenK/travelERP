<?php
class DingdanAction extends CommonAction{
	

    public function querenfukuancw() {
		
		$dingdanID = $_GET['dingdanID'];
		
		$Gldingdan = D("gldingdan");
		$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();

		$dingdan['daokuancw'] = '已付款';
		$dingdan['islock'] = '已锁定';
		
		$Gldingdan->save($dingdan);
		//记录提示经理
		$megurl = SITE_MENSHI."Dingdan/dingdanxinxi/showtype/审核/dingdanID/".$dingdanID;
		A("Message")->savemessage($dingdanID,'订单','审核记录','财务已确认订单支付','计调经理,计调操作员',$megurl);
		//记录提示财务
		$megurl = SITE_MENSHI."Dingdan/dingdanxinxi/showtype/审核/dingdanID/".$dingdanID;
		A("Message")->savemessage($dingdanID,'订单','审核记录','财务已确认订单支付','门市操作员',$megurl);
		
		doalert('订单已'.$dingdan['daokuancw'],'');
    }

    public function quxiaofukuancw() {
		
		$dingdanID = $_GET['dingdanID'];
		
		$Gldingdan = D("gldingdan");
		$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();

		$dingdan['daokuancw'] = '未付款';
		$dingdan['islock'] = '未锁定';
		
		$Gldingdan->save($dingdan);
		//记录提示经理
		$megurl = SITE_MENSHI."Dingdan/dingdanxinxi/showtype/审核/dingdanID/".$dingdanID;
		A("Message")->savemessage($dingdanID,'订单','审核记录','财务取消订单支付','计调经理,计调操作员',$megurl);
		//记录提示财务
		$megurl = SITE_MENSHI."Dingdan/dingdanxinxi/dingdanID/".$dingdanID;
		A("Message")->savemessage($dingdanID,'订单','审核记录','财务取消订单支付','门市操作员',$megurl);
		
		doalert('订单已'.$dingdan['daokuancw'],'');
    }


    public function dingdansuo() {
		
		$type = $_GET['type'];
		$dingdanID = $_GET['dingdanID'];
		$Gldingdan = D("gldingdan");
		$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
		if($type == '锁定')
			$dingdan['islock'] = '已锁定';
		if($type == '解锁')
			$dingdan['islock'] = '未锁定';
		$Gldingdan->save($dingdan);
		doalert('订单已'.$type,'');
    }



    public function zituandingdan() {
		
		$zituanID = $_GET['zituanID'];
		
		$Glzituan = D("zituan_xianlu");
		$zituan = $Glzituan->where("`zituanID` = '$zituanID'")->find();
		
		$Gldingdan = D("dingdan_zituan");
		$dingdanAll = $Gldingdan->where("`zituanID` = '$zituanID'")->findall();
		$i = 0;
		$zongrenshu = 0;
		$zongqueren = 0;
		$zonghuobu = 0;
		$zongzhanwei = 0;
		$zongtuituan = 0;
		foreach($dingdanAll as $dingdan)
		{
			$Gltuanyuan = D("tuanyuan_dingdan");
			$chengrenshu = $Gltuanyuan->where("`manorchild` = '成人' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			$ertongshu = $Gltuanyuan->where("`manorchild` = '儿童' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			$renshu = $chengrenshu + $ertongshu;
			
			//关联来源
			$Gllvxingshe = D("Gllvxingshe");
			$lvxingshe = $Gllvxingshe->where("`lvxingsheID` = '$dingdan[laiyuan]'")->find();
			$dingdanAll[$i]['laiyuan'] = $lvxingshe['companyname'];
			
			$dingdanAll[$i]['renshu'] = $renshu;
			$dingdanAll[$i]['querennum'] = 0;
			$dingdanAll[$i]['houbunum'] = 0;
			$dingdanAll[$i]['zhanweinum'] = 0;
			$dingdanAll[$i]['tuituannum'] = 0;
			//if($dingdan['zhuangtai'] == '确认')
			$dingdanAll[$i]['querennum'] = $Gltuanyuan->where("`zhuangtai` = '确认' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			if($dingdan['zhuangtai'] == '候补')
			$dingdanAll[$i]['houbunum'] = $renshu;
			//if($dingdan['zhuangtai'] == '占位')
			$dingdanAll[$i]['zhanweinum'] = $Gltuanyuan->where("`zhuangtai` = '占位' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			if($dingdan['zhuangtai'] == '退团')
			$dingdanAll[$i]['tuituannum'] = $renshu;
			
			$zongrenshu += $renshu;
			$zongqueren += $dingdanAll[$i]['querennum'];
			$zonghuobu += $dingdanAll[$i]['houbunum'];
			$zongzhanwei += $dingdanAll[$i]['zhanweinum'];
			$zongtuituan += $dingdanAll[$i]['tuituannum'];
			
			$tuanfei += $dingdan['jiage'];
			$i++;
		}
		$shengyu = $zituan['renshu'] - $zongrenshu;
		
        $this->assign('zongrenshu',$zongrenshu);
        $this->assign('zongqueren',$zongqueren);
        $this->assign('zonghuobu',$zonghuobu);
        $this->assign('zongzhanwei',$zongzhanwei);
        $this->assign('zongtuituan',$zongtuituan);
        $this->assign('shengyu',$shengyu);
        $this->assign('zituanID',$zituanID);
        $this->assign('zituan',$zituan);
        $this->assign('dingdanAll',$dingdanAll);
        $this->assign('tuanfei',$tuanfei);
		
		$this->assign('location','订单资料');
		$this->assign('navlist','产品控管 > '.$zituan['guojing'].' > 订单资料');
		if($_GET['xianlutype'] == '自由人')
        $this->display('z_zituandingdan');
		else
        $this->display('Kongguan/zituandingdan');
		

    }





}
?>