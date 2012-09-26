<?php

class UserModel extends Model {
	protected $trueTableName = 'myerp_system_user';	
	protected $pk = 'systemID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('systemID', 'require', 'systemID不能为空！', 1,'',1), 
        array('user_name', 'require', 'user_name不能为空！', 1,'',1), 
        array('password', 'require', 'password不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
	
    ); 


}
?>