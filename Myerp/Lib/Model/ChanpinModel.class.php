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
        array('user_name', 'set_user_name', 1,'callback','user_name',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('departmentID', 'set_department', 1,'callback','departmentID,chanpinID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('bumen_copy', 'set_bumen_copy', 3,'callback','departmentID,chanpinID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('marktype', 'set_marktype', 1,'callback'),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('islock', 'set_islock', 1,'callback','islock',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('status_system', 'set_status_system', 1,'callback','status_system',1),//1正常,-1删除
        array('status_shenhe', 'set_status_shenhe', 1,'callback','status_shenhe',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
    ); 
	
	protected function set_status($status,$parentID) {
		if($status != '')	
			return $status;
		else
			return '准备';
	}
	
	protected function set_islock($islock) {
		if($islock != '')	
			return $islock;
		else
			return '未锁定';
	}
	
	protected function set_status_system($status_system) {//1正常,-1删除
		if($status_system != '')	
			return $status_system;
		else
			return 1;
	}
	
	protected function set_time($time) {
		if($time != '')	
			return $time;
		else
			return time();
	}
	
	protected function set_marktype() {
		$options = $this->getRelationOptions();
		return $options;
	}
	
	protected function set_department($departmentID,$chanpinID) {
		if($departmentID != '')
			return $departmentID;
		else
			return NF_getmydepartmentid($chanpinID);
	}
	
	protected function set_bumen_copy($departmentID,$chanpinID) {
		if($departmentID){
			return NF_getbumen_title($departmentID);
		}
		if($chanpinID){
			$dt = $this->where("`chanpinID` = '$chanpinID'")->find();
			return $dt['bumen_copy'];
		}
		return NF_getbumen_title($departmentID);
	}
	
	protected function set_user_name($user_name) {
		if($user_name != '')	
			return $user_name;
		else
			return NF_getusername();
	}
	
	protected function set_status_shenhe($status_shenhe) {
		if($status_shenhe)	
			return $status_shenhe;
		else
			return '未审核';
	}
	
	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Xianlu','foreign_key'=>'chanpinID'),
		'zituanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'shoujialist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'xingchenglist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_xingcheng','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'chengben'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Chengben','foreign_key'=>'chanpinID','condition'=>"`status_system` = '1'"),
		//zituan
		'xianlulist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Xianlu','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
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
		'baozhangitemlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_baozhangitem','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'baozhangzituanlist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Zituan','true_class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'parentID','parent_key'=>'chanpinID'),//class_name写,true_class_name读，更新需求parentID非空
		'baozhangDJtuanlist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'DJtuan','true_class_name'=>'myerpview_chanpin_djtuan','foreign_key'=>'parentID','parent_key'=>'chanpinID'),//class_name写,true_class_name读，更新需求parentID非空
		//baozhangitem
		'baozhangitem'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Baozhangitem','foreign_key'=>'chanpinID'),
		'baozhanglist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Baozhang','true_class_name'=>'myerpview_chanpin_baozhang','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
		//DJtuan
		'DJtuan'=>array('mapping_type'=>HAS_ONE,'class_name'=>'DJtuan','foreign_key'=>'chanpinID'),
	);
	

}
?>