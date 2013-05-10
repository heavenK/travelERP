<?php

class DataOMSystemModel extends RelationModel {
	protected $trueTableName = 'myerp_dataom_system';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
        array('DUR', 'require', 'DUR不能为空！', 1,'',1), 
//        array('OMID', 'require', 'OMID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('time', 'time', 1, 'function'), 
    ); 

	protected $_link = array(
		//user
		'user'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'User','true_class_name'=>'myerpview_system_user','foreign_key'=>'dataID','parent_key'=>'systemID'),
		//category
		'category'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Category','true_class_name'=>'myerpview_system_category','foreign_key'=>'dataID','parent_key'=>'systemID'),
	);


}
?>