<?php

class DataShenheModel extends RelationModel {
	protected $trueTableName = 'myerp_datashenhe';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('shenheID', 'require', 'shenheID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
        array('processID', 'require', 'processID不能为空！', 1,'',1), 
        array('UR', 'require', 'UR不能为空！', 1,'',1), 
        array('remark', 'require', 'remark不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
//        array('time', 'time', 1, 'function'), 
    ); 

	protected $_link = array(

	);


}
?>