<?php

class TaskShenheModel extends Model {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_system_taskShenhe';	
	protected $pk = 'systemID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('systemID', 'require', 'systemID不能为空！', 1,'',1), 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
        array('processID', 'require', 'processID不能为空！', 1,'',1), 
        array('remark', 'require', 'remark不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 


}
?>