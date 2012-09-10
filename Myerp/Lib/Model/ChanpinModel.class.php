<?php

class ChanpinModel extends RelationModel {
	protected $trueTableName = 'myerp_chanpin';	
	protected $pk = 'chanpinID';	
	
   // 自动验证设置
    protected $_validate = array( 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('status', 'set_status', 1,'callback','status,parentID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('time', 'set_time', 1,'callback','time',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
//        array('time', 'time', 1, 'function'), 
//        array('user_name', 'NF_getusername', 1, 'function'), 
        array('user_name', 'set_user_name', 1,'callback','user_name',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('departmentID', 'set_department', 1,'callback','departmentID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('bumen_copy', 'NF_getbumen', 3, 'function'), 
        array('marktype', 'set_marktype', 1,'callback'),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('islock', '未锁定', 1),
        array('status_system', 1, 1),//1正常,-1删除
        array('status_shenhe', '未审核', 1),
    ); 
	
	protected function set_status($status,$parentID) {
		if($status)	
			return $status;
		else
			return '准备';
	}
	
	protected function set_time($time) {
		if($time)	
			return $time;
		else
			return time();
	}
	
	protected function set_marktype() {
		$options = $this->getRelationOptions();
		return $options;
	}
	
	protected function set_department($departmentID) {
		if($departmentID){
			$ViewDepartment = D("ViewDepartment");
			$bumen = $ViewDepartment->where("`systemID` = '$departmentID' and `status_system` = '1'")->find();
			cookie('_usedbumenID',$bumen['systemID'],30);
			return $departmentID;
		}
		else
		return NF_getmydepartmentid();
	}
	
	protected function set_user_name($user_name) {
		if($user_name)	
			return $user_name;
		else
			return NF_getusername();
	}
	
	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Xianlu','foreign_key'=>'chanpinID'),
		'zituanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'shoujialist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'xingchenglist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_xingcheng','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'chengben'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Chengben','foreign_key'=>'chanpinID','condition'=>"`status_system` = '1'"),
		//zituan
		'xianlulist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Chanpin','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
		'zituan'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Zituan','foreign_key'=>'chanpinID'),
		'dingdanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_dingdan','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'fenfanglist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_fenfang','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'tdbzdlist'=>array('mapping_type'=>HAS_ONE,'class_name'=>'ViewBaozhang','foreign_key'=>'parentID','condition'=>"`status_system` = '1' and `type` = '团队报账单'"),
		//shoujia
		'shoujia'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Shoujia','foreign_key'=>'chanpinID'),
		//chengbenlist
		'chengbenlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_chengben','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		//xingcheng
		'xingcheng'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Xingcheng','foreign_key'=>'chanpinID'),
		//dingdan
		'dingdan'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Dingdan','foreign_key'=>'chanpinID'),
		'chanpinparentlist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Chanpin','true_class_name'=>'myerp_chanpin','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
		//fenfang
		'fenfang'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Fenfang','foreign_key'=>'chanpinID'),
		//baozhang
		'baozhang'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Baozhang','foreign_key'=>'chanpinID'),
		//baozhangitem
		'baozhangitem'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Baozhangitem','foreign_key'=>'chanpinID'),
		'baozhanglist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Chanpin','true_class_name'=>'myerpview_chanpin_baozhang','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
		//DJtuan
		'DJtuan'=>array('mapping_type'=>HAS_ONE,'class_name'=>'DJtuan','foreign_key'=>'chanpinID'),
	);
	

}
?>