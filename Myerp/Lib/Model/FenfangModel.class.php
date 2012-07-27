<?php

class FenfangModel extends Model {
	protected $trueTableName = 'myerp_chanpin_fenfang';	
	protected $pk = 'chanpinID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('chanpinID', 'require', 'chanpinID不能为空！', 1,'',1), 
        array('title', 'require', 'title不能为空！', 1,'',1), 
    ); 


}
?>