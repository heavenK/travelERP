<?php

class VIPRecordModel extends RelationModel {
	protected $trueTableName = 'myerp_vip_record';	
	protected $pk = 'vipID';
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
	);
}
?>