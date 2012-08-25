<?php

class DingdanModel extends Model {
	protected $trueTableName = 'myerp_chanpin_dingdan';	
   // 自动验证设置 
    protected $_validate = array( 
        array('chanpinID', 'require', 'chanpinID不能为空！', 1,'',1), 
        array('lianxiren', 'require', 'lianxiren不能为空！', 1,'',1), 
//        array('jiage', 'require', 'jiage不能为空！', 1,'',1), 
        array('owner', 'require', 'owner不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 

	




}
?>