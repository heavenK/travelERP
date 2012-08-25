<?php

class SystemModel extends RelationModel {
	protected $trueTableName = 'myerp_system';	
	protected $pk = 'systemID';	
	
   // 自动验证设置,心情全部自动填充
    protected $_validate = array( 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('status', 'set_status', 1,'callback','status,parentID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('time', 'time', 1, 'function'), 
        array('user_name', 'NF_getusername', 1, 'function'), 
        array('departmentID', 'NF_getmydepartmentid', 1, 'function'), 
        array('bumen_copy', 'NF_getbumen', 1, 'function'), 
        array('marktype', 'set_marktype', 1,'callback'),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('islock', '未锁定', 1),
        array('status_system', 1, 1),//1正常,-1删除
    ); 
	
	protected function set_status($status,$parentID) {
		if($status)	
			return $status;
		else
			return '准备';
	}
	
	protected function set_marktype() {
		$options = $this->getRelationOptions();
		return $options;
	}
	
	protected $_link = array(
		//user
		'user'=>array('mapping_type'=>HAS_ONE,'class_name'=>'User','foreign_key'=>'systemID'),
		'DURlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_system_dur','foreign_key'=>'userID','condition'=>"`status_system` = '1'"),
		//department
		'department'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Department','foreign_key'=>'systemID'),
		//roles
		'roles'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Roles','foreign_key'=>'systemID'),
		//category
		'category'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Category','foreign_key'=>'systemID'),
		'categoryOMlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_system_om','foreign_key'=>'dataID','condition'=>"`status_system` = '1'"),
		'systemDClist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_system_dc','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
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
		//customer
		'customer'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Customer','foreign_key'=>'systemID'),
	);
	

}
?>