<?php

class CustomerModel extends Model {
	protected $trueTableName = 'myerp_system_customer';	
	protected $pk = 'systemID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('systemID', 'require', 'systemID不能为空！', 1,'',1), 
        array('name', 'require', 'name不能为空！', 1,'',1), 
        //array('telnum', 'require', 'telnum不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 


}
?>