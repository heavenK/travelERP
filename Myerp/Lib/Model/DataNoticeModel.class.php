<?php

class DataNoticeModel extends RelationModel {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_dataNotice';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('message', 'require', 'message不能为空！', 1,'',1), 
        array('userID', 'require', 'userID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
//        array('status', '准备', 1), 
//        array('time', 'time', 1, 'function'), 
    ); 

	protected $_link = array(

	);


}
?>