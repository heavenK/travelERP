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
        array('time', 'set_time', 1,'callback','time',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
    ); 

	protected $_link = array(

	);

	protected function set_time($time) {
		if($time != '')	
			return $time;
		else
			return time();
	}


}
?>