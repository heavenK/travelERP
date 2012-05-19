<?php

class ChanpinModel extends RelationModel {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_chanpin';	
	protected $pk = 'chanpinID';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('title', 'require', '标题必须！', 1), 
//        array('user_name', 'require', '用户名必须！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('status', '准备', 1), 
        array('time', 'time', 1, 'function'), 
    ); 
	
	protected $_link = array(
		'zituanview'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_ztian','foreign_key'=>'parentID'),
		'xianluview'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'chanpin','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
		'xianlu'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'chanpin','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
		'zituan'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'chanpin','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
	);
	

}
?>