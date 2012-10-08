<?php

class DataCDModel extends Model {
	protected $trueTableName = 'myerp_datacd';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('name', 'require', 'name不能为空！', 1,'',1), 
        array('dingdanID', 'require', 'dingdanID不能为空！', 1,'',1), 
        array('price', 'require', 'price不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('time', 'time', 1, 'function'), 
        array('ispay', '未付款', 1),
    ); 

	protected $_link = array(
		//customer
		'customer'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Customer','true_class_name'=>'myerpview_system_customer','foreign_key'=>'customerID','parent_key'=>'systemID'),
	);


}
?>