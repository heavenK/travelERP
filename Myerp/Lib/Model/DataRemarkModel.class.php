<?php

class DataRemarkModel extends Model {
	protected $trueTableName = 'myerp_dataremark';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('time', 'time', 1, 'function'), 
        array('user_name', 'set_user_name', 1,'callback','user_name',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('departmentID', 'set_department', 1,'callback','departmentID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('bumen_copy', 'set_bumen_copy', 3,'callback','departmentID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
    ); 

	protected $_link = array(

	);

	protected function set_department($departmentID) {
		if($departmentID != '')
			return $departmentID;
		else
			return NF_getmydepartmentid();
	}
	
	protected function set_bumen_copy($departmentID) {
		if($departmentID){
			return NF_getbumen_title($departmentID);
		}
		return NF_getbumen_title($departmentID);
	}
	
	protected function set_user_name($user_name) {
		if($user_name != '')	
			return $user_name;
		else
			return NF_getusername();
	}
	
	
}
?>