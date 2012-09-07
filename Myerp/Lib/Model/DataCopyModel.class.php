<?php

class DataCopyModel extends Model {
	protected $trueTableName = 'myerp_datacopy';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
        array('copy', 'require', 'copy不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('time', 'time', 1, 'function'), 
    ); 

	protected $_link = array(

	);


}
?>