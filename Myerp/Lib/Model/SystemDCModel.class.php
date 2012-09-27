<?php

class SystemDCModel extends Model {
	protected $trueTableName = 'myerp_system_dc';	
		
   // 自动验证设置 
    protected $_validate = array( 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('systemID', 'require', 'systemID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 


}
?>