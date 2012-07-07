<?php

class SystemDataDictionaryModel extends Model {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_system_dataDictionary';	
		
   // 自动验证设置 
    protected $_validate = array( 
        array('systemID', 'require', 'systemID不能为空！', 1,'',1), 
        array('title', 'require', 'title不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 


}
?>