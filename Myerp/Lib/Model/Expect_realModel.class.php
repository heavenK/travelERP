<?php

class Expect_realModel extends RelationModel {
	protected $trueTableName = 'myerp_expect_real';	

   // 自动验证设置 
    protected $_validate = array( 
//        array('title_copy', 'require', 'title_copy不能为空！', 1,'',1), 
//        array('guojing_copy', 'require', 'guojing_copy不能为空！', 1,'',1), 
//        array('kind_copy', 'require', 'kind_copy不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 
	
	protected $_link = array(
		'expectlist'=>array('mapping_type'=>MANY_TO_MANY,'class_name'=>'myerp_chanpin_baozhangitem','foreign_key'=>'chanpinID','parent_key'=>'expectID'),
		'reallist'=>array('mapping_type'=>MANY_TO_MANY,'class_name'=>'myerp_chanpin_baozhangitem','foreign_key'=>'chanpinID','parent_key'=>'realID'),
	);
}
?>