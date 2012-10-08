<?php

class BaozhangitemModel extends RelationModel {
	protected $trueTableName = 'myerp_chanpin_baozhangitem';	
	protected $pk = 'chanpinID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('title', 'require', 'title不能为空！', 1,'',1), 
        array('chanpinID', 'require', 'chanpinID不能为空！', 1,'',1), 
        array('value', 'require', 'value不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
        array('method', 'require', 'method不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 

	protected $_link = array(
		//baozhangitem
		'baozhanglist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Baozhang','true_class_name'=>'myerpview_chanpin_baozhang','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
	);
	
}
?>