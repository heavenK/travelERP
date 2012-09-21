<?php

class DingdanModel extends Model {
	protected $trueTableName = 'myerp_chanpin_dingdan';	
   // 自动验证设置 
    protected $_validate = array( 
        array('chanpinID', 'require', 'chanpinID不能为空！', 1,'',1), 
        array('lianxiren', 'require', 'lianxiren不能为空！', 1,'',1), 
        array('owner', 'require', 'owner不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
        array('tichengID', 'require', 'tichengID不能为空！', 1,'',1), 
        array('telnum', 'require', 'telnum不能为空！', 1,'',1), 
        array('zituanID', 'require', 'zituanID不能为空！', 1,'',1), 
    );
	
    // 自动填充设置 
    protected $_auto = array( 
        array('laokehu', 0, 1),
        array('baozhang_remark', 'set_bzdremark', 1,'callback','chanpinID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('baozhang_time', 'set_bzdtime', 1,'callback','chanpinID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('status_baozhang', 'set_bzdstatus', 1,'callback','chanpinID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('fuzeren', 'set_fuzeren', 1,'callback','chanpinID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('fuzebumenID', 'set_fuzebumenID', 1,'callback','chanpinID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
    ); 
	//传值不能传parentID原因，parentID为主表属性，故提取不到
	protected function set_bzdremark($chanpinID) {
		$Chanpin = D("Chanpin");
		$dingdan = $Chanpin->relation("chanpinparentlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituan = $Chanpin->relation("tdbzdlist")->where("`chanpinID` = '$dingdan[parentID]'")->find();
		return $zituan['tdbzdlist']['shenhe_remark'];
	}
	protected function set_bzdtime($chanpinID) {
		$Chanpin = D("Chanpin");
		$dingdan = $Chanpin->relation("chanpinparentlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituan = $Chanpin->relation("tdbzdlist")->where("`chanpinID` = '$dingdan[parentID]'")->find();
		return $zituan['tdbzdlist']['shenhe_time'];
	}
	protected function set_bzdstatus($chanpinID) {
		$Chanpin = D("Chanpin");
		$dingdan = $Chanpin->relation("chanpinparentlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituan = $Chanpin->relation("tdbzdlist")->where("`chanpinID` = '$dingdan[parentID]'")->find();
		return $zituan['tdbzdlist']['status_shenhe'];
	}
	protected function set_fuzeren($chanpinID) {
		$Chanpin = D("Chanpin");
		$dingdan = $Chanpin->relation("chanpinparentlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituan = $Chanpin->where("`chanpinID` = '$dingdan[parentID]'")->find();
		return $zituan['user_name'];
	}
	protected function set_fuzebumenID($chanpinID) {
		$Chanpin = D("Chanpin");
		$dingdan = $Chanpin->relation("chanpinparentlist")->where("`chanpinID` = '$chanpinID'")->find();
		$zituan = $Chanpin->where("`chanpinID` = '$dingdan[parentID]'")->find();
		return $zituan['departmentID'];
	}
	




}
?>