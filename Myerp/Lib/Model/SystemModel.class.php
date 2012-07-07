<?php

class SystemModel extends RelationModel {
	protected $trueTableName = 'myerp_system';	
	protected $pk = 'systemID';	
	
   // 自动验证设置 
    protected $_validate = array( 
//        array('user_name', 'require', '用户名必须！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('time', 'time', 1, 'function'), 
        array('user_name', 'NF_getusername', 1, 'function'), 
        array('departmentID', 'NF_getmydepartmentid', 1, 'function'), 
        array('status', 'set_status', 1,'callback','status',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
    ); 
	
	protected function set_status($args) {
		if($args != '')	
			return $args;
		else
			return 1;
	}
	
	protected $_link = array(
		//user
		'user'=>array('mapping_type'=>HAS_ONE,'class_name'=>'User','foreign_key'=>'systemID'),
		'DURlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_system_dur','foreign_key'=>'userID'),
		//department
		'department'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Department','foreign_key'=>'systemID'),
		//roles
		'roles'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Roles','foreign_key'=>'systemID'),
		//category
		'category'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Category','foreign_key'=>'systemID'),
		'categoryOMlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_system_om','foreign_key'=>'dataID','condition'=>"`datatype` = '分类'"),
		'systemDClist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_system_dc','foreign_key'=>'parentID'),
		//systemDC
		'systemDC'=>array('mapping_type'=>HAS_ONE,'class_name'=>'SystemDC','foreign_key'=>'systemID'),
		//systemOM
		'systemOM'=>array('mapping_type'=>HAS_ONE,'class_name'=>'SystemOM','foreign_key'=>'systemID'),
		//systemDUR
		'systemDUR'=>array('mapping_type'=>HAS_ONE,'class_name'=>'SystemDUR','foreign_key'=>'systemID'),
		//dirctory
		'directory'=>array('mapping_type'=>HAS_ONE,'class_name'=>'SystemDirectory','foreign_key'=>'systemID'),
		//shenhe
		'shenhe'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Shenhe','foreign_key'=>'systemID'),
		//taskShenhe
		'taskShenhe'=>array('mapping_type'=>HAS_ONE,'class_name'=>'TaskShenhe','foreign_key'=>'systemID'),
		//datadictionary
		'datadictionary'=>array('mapping_type'=>HAS_ONE,'class_name'=>'SystemDataDictionary','foreign_key'=>'systemID'),
	);
	

}
?>