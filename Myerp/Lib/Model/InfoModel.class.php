<?php

class InfoModel extends Model {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_info';	
	
   // 自动验证设置 
    protected $_validate = array( 
//        array('typeName', 'require', 'typeName不能为空！', 1), 
//        array('user_name', 'require', '用户名必须！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('islock', '未锁定', 1), 
        array('user_name', '系统', 1), 
        array('user_id', '-1', 1), 
        array('departmentName', '系统', 1), 
        array('departmentID', '-1', 1), 
        array('status', '系统', 1), 
        array('time', 'time', 1, 'function'), 
    ); 




}
?>