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
        array('status', '准备', 1), 
        array('time', 'time', 1, 'function'), 
        array('user_name', 'NF_getusername', 1, 'function'), 
        array('user_id', 'NF_getuserid', 1, 'function'), 
        array('departmentName', 'NF_getmydepartmentname', 1, 'function'), 
        array('departmentID', 'NF_getmydepartmentid', 1, 'function'), 
    ); 
	
	protected $_link = array(
		//xianlu
		'zituanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_ztian','foreign_key'=>'parentID'),
		'shoujialist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'parentID'),
		'xianlu'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Xianlu','foreign_key'=>'chanpinID'),
		'xingcheng'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Xingcheng','foreign_key'=>'chanpinID'),
		'chengben'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Chengben','foreign_key'=>'chanpinID'),
		//zituan
		'xianlulist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Chanpin','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
		'zituan'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Zituan','foreign_key'=>'chanpinID'),
		//shoujia
		'shoujia'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Shoujia','foreign_key'=>'chanpinID'),
	);
	

}
?>