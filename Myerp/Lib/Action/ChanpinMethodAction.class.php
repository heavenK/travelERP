<?php

class ChanpinMethodAction extends Action{

    //显示产品列表
    public function chanpin_list($where,$pagenum = 20) {
		$Chanpin = D('Chanpin');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $Chanpin->where($where)->count();
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $chanpin = $Chanpin->relation('xianlu')->where($where)->order("chanpinID DESC")->limit($p->firstRow.','.$p->listRows)->select();
		$redata['page'] = $page;
		$redata['chanpin'] = $chanpin;
		return $redata;
	}
	
	//生成子团
    public function shengchengzituan($chanpinID) {
		$Chanpin = D("Chanpin");
		$chanpin = $Chanpin->relation("xianlu")->where("`chanpinID` = '$chanpinID'")->find();
		$riqiAll = split(';',$chanpin['xianlu']['chutuanriqi']);
		//根据线路判断生成
		$ViewZituan = D("ViewZituan");
		foreach($riqiAll as $riqi){
			$datazituan = '';
			$zituan = $ViewZituan->where("`parentID` = '$chanpinID' and `chutuanriqi` = '$riqi' ")->find();
			$datazituan['zituan']['baomingjiezhi'] = $chanpin['xianlu']['baomingjiezhi'];
			$datazituan['zituan']['renshu'] = $chanpin['xianlu']['renshu'];
			$datazituan['zituan']['chutuanriqi'] = $riqi;
			$datazituan['zituan']['tuanhao'] =  $chanpin['xianlu']['bianhao'].'/'.$riqi;
			if(!$zituan){
				$datazituan['parentID'] = $chanpinID;
				$datazituan['typeName'] = '子团';
				$datazituan['user_name'] = $chanpin['user_name'];
				$datazituan['user_id'] = $chanpin['user_id'];
				$datazituan['departmentName'] = $chanpin['departmentName'];
				$datazituan['departmentID'] = $chanpin['departmentID'];
				if (false !== $Chanpin->relation("zituan")->myRcreate($datazituan));
			}
			else{
				if($zituan['islock'] != '已锁定'){
					//修改子团内容
					$datazituan['chanpinID'] = $zituan['chanpinID'];
					$datazituan['typeName'] = '子团';
					if (false !== $Chanpin->relation("zituan")->myRcreate($datazituan));
				}
				else
					$locklist .= $zituan['chutuanriqi'].";";
			}
		}
		//删除多余子团
		$viewxianlu = D("ViewXianlu");
		$xianlu = $viewxianlu->relation("zituanlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituanlist = $xianlu['zituanlist'];
		foreach($zituanlist as $zituan){
			if(false === strpos($chanpin['xianlu']['chutuanriqi'],$zituan['chutuanriqi'])){
				if($zituan['islock'] != '已锁定'){
					if (false !== $Chanpin->relation("zituan")->delete($zituan['chanpinID'])){
						continue;	
					}
				}
				else
					$locklist .= $zituan['chutuanriqi'].";";
			}
			if($chutuanlist)
			$chutuanlist .= ";".$zituan['chutuanriqi'];
			else
			$chutuanlist .= $zituan['chutuanriqi'];
		}
	   //由于可能存在子团锁定状态不能删除，要逆更新出团时间到线路
		$xianlu['xianlu']['chutuanriqi'] = $chutuanlist;
		$Chanpin->relation("xianlu")->myRcreate($xianlu);
		return true;
	}

	
	
	
	//生成子团
    public function tst($chanpinID) {
		$Chanpin = D("Chanpin");
					$datazituan['chanpinID'] = '30475';
					$datazituan['typeName'] = '子团';
			$datazituan['zituan']['baomingjiezhi'] = '123';
					
					if (false !== $Chanpin->relation("zituan")->myRcreate($datazituan));
		}
}
?>