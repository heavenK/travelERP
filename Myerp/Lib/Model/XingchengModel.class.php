<?php

class XingchengModel extends Model {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_chanpin_xingcheng';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('chanpinID', 'require', '产品ID不能为空！', 1), 
//        array('user_name', 'require', '用户名必须！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
//        array('status', '准备', 1), 
//        array('time', 'time', 1, 'function'), 
    ); 




}
?>