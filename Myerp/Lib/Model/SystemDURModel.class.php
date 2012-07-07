<?php

class SystemDURModel extends Model {
	protected $trueTableName = 'myerp_system_DUR';	
		
   // 自动验证设置 
    protected $_validate = array( 
        array('systemID', 'require', 'systemID不能为空！', 1,'',1), 
        array('departmentID', 'require', 'departmentID不能为空！', 1,'',1), 
        array('rolesID', 'require', 'rolesID不能为空！', 1,'',1), 
        array('userID', 'require', 'userID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 


}
?>