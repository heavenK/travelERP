<?php

class DataOMModel extends RelationModel {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_dataOM';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
        array('OMID', 'require', 'OMID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
//        array('status', '准备', 1), 
//        array('time', 'time', 1, 'function'), 
    ); 

	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>BELONGS_TO,'true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'dataID','parent_key'=>'chanpinID'),

	);


}
?>