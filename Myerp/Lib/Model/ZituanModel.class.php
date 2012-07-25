<?php

class ZituanModel extends Model {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_chanpin_zituan';	
	protected $pk = 'chanpinID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('title_copy', 'require', 'title_copy不能为空！', 1,'',1), 
        array('chanpinID', 'require', 'chanpinID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('adultxiuzheng', '0', 1), 
        array('childxiuzheng', '0', 1), 
    ); 


}
?>