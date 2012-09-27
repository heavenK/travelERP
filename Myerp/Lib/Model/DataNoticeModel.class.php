<?php

class DataNoticeModel extends RelationModel {
	protected $trueTableName = 'myerp_datanotice';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('message', 'require', 'message不能为空！', 1,'',1), 
        array('userID', 'require', 'userID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
//        array('time', 'time', 1, 'function'), 
    ); 

	protected $_link = array(

	);


}
?>