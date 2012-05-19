<?php

class ChanpinMethodAction extends Action{

    //显示产品列表
    public function chanpin_list($where,$pagenum = 20) {
		$myerpview_chanpin_xianlu = D('myerpview_chanpin_xianlu');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $myerpview_chanpin_xianlu->where($where)->count();
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $chanpin = $myerpview_chanpin_xianlu->where($where)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		$redata['page'] = $page;
		$redata['chanpin'] = $chanpin;
		return $redata;
		
	}
	//生成子团
    private function shengchengzituan($chanpinID) {
		$myerpview_chanpin_xianlu = D('myerpview_chanpin_xianlu');
		$xianlu = $myerpview_chanpin_xianlu->where("`chanpinID` = '$chanpinID'")->find();
		$Chanpin = D('Chanpin');
		$d = $Chanpin->relation("zituanview")->where("`chanpinID` = '$chanpinID'")->find();
		$zituanAll = $d['zituanview'];
		$riqiAll = split(';',$xianlu['chutuanriqi']);
		//先根据子团判断修改和删除
		foreach($zituanAll as $zituan){
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

	
	
	
	
}
?>