<?php

class BaozhangModel extends RelationModel {
	protected $trueTableName = 'myerp_chanpin_baozhang';	
	protected $pk = 'chanpinID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('title', 'require', 'title不能为空！', 1,'',1), 
        array('chanpinID', 'require', 'chanpinID不能为空！', 1,'',1), 
        array('renshu', 'require', 'renshu不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 


}
?>