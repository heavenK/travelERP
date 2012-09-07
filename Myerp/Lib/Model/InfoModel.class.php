<?php

class InfoModel extends Model {
	protected $trueTableName = 'myerp_message_info';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('title', 'require', 'title不能为空！', 1,'',1), 
        array('usedDUR', 'require', 'usedDUR不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 




}
?>