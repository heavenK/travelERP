<?php

class BaozhangitemModel extends Model {
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
		//baozhang
		//'baozhangitemlist'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Baozhang','foreign_key'=>'chanpinID','condition'=>'`status` != -1'),
		'baozhangitemlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_baozhangitem','foreign_key'=>'parentID','condition'=>'`status` != -1'),
		
	);
	
}
?>