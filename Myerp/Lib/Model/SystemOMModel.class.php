<?php

class SystemOMModel extends Model {
	protected $trueTableName = 'myerp_system_om';	
		
   // 自动验证设置 
    protected $_validate = array( 
        array('systemID', 'require', 'systemID不能为空！', 1,'',1), 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
        array('parenttype', 'require', 'parenttype不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 


}
?>