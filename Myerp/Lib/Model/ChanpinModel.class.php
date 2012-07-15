<?php

class ChanpinModel extends RelationModel {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_chanpin';	
	protected $pk = 'chanpinID';	
	
   // 自动验证设置 
    protected $_validate = array( 
//        array('title', 'require', '标题必须！', 1), 
//        array('user_name', 'require', '用户名必须！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
//        array('status', '准备', 1),
        array('status', 'set_status', 1,'callback','status',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('time', 'time', 1, 'function'), 
        array('user_name', 'NF_getusername', 1, 'function'), 
        array('departmentID', 'NF_getmydepartmentid', 1, 'function'), 
        array('marktype', 'set_marktype', 1,'callback'),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
    ); 
	
	protected function set_status($args) {
		if($args != '')	
			return $args;
		else
			return '准备';
	}
	
	protected function set_marktype() {
		$options = $this->getRelationOptions();
		return $options;
	}
	
	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Xianlu','foreign_key'=>'chanpinID'),
		'zituanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'parentID'),
		'shoujialist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'parentID'),
		'xingchenglist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_xingcheng','foreign_key'=>'parentID'),
		'chengben'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Chengben','foreign_key'=>'chanpinID'),
		//zituan
		'xianlulist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Chanpin','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
		'zituan'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Zituan','foreign_key'=>'chanpinID'),
		//shoujia
		'shoujia'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Shoujia','foreign_key'=>'chanpinID'),
		//chengbenlist
		'chengbenlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_chengben','foreign_key'=>'parentID'),
		//xingcheng
		'xingcheng'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Xingcheng','foreign_key'=>'chanpinID'),
		//dingdan
		'dingdan'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Dingdan','foreign_key'=>'chanpinID'),
	);
	

}
?>