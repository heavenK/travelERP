<?php

class MessageModel extends RelationModel {
	protected $trueTableName = 'myerp_message';	
	protected $pk = 'messageID';	
	
   // 自动验证设置 
    protected $_validate = array( 
//        array('user_name', 'require', '用户名必须！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('time', 'time', 1, 'function'), 
        array('user_name', 'NF_getusername', 1, 'function'), 
        array('departmentID', 'NF_getmydepartmentid', 1, 'function'), 
    ); 
	
	protected $_link = array(
		//infohistory
		'infohistory'=>array('mapping_type'=>HAS_ONE,'class_name'=>'InfoHistory','foreign_key'=>'messageID'),
	);
	

}
?>