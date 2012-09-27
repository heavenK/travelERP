<?php

class ChengbenModel extends Model {
	protected $trueTableName = 'myerp_chanpin_chengben';	
	protected $pk = 'chanpinID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('chanpinID', 'require', 'chanpinID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
//        array('adultxiuzheng', '0', 1), 
//        array('childxiuzheng', '0', 1), 
    ); 


}
?>