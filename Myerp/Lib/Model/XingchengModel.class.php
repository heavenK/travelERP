<?php

class XingchengModel extends Model {
	protected $trueTableName = 'myerp_chanpin_xingcheng';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('chanpinID', 'require', '产品ID不能为空！', 1,'',1), 
//        array('user_name', 'require', '用户名必须！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
//        array('time', 'time', 1, 'function'), 
    ); 




}
?>