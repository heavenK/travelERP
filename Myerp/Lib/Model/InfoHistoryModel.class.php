<?php

class InfoHistoryModel extends Model {
	protected $trueTableName = 'myerp_message_infohistory';	
	protected $pk = 'messageID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('messageID', 'require', 'messageID不能为空！', 1,'',1), 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
        array('usedDUR', 'require', 'usedDUR不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array(
    ); 


}
?>