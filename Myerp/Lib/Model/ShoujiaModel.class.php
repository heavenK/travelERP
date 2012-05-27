<?php

class ShoujiaModel extends Model {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_chanpin_shoujia';	
	protected $pk = 'chanpinID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('type', 'require', 'type不能为空！', 1), 
        //array('renshu', 'require', 'type不能为空！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 
}
?>