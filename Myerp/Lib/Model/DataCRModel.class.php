<?php

class DataCRModel extends Model {
	protected $trueTableName = 'myerp_datacr';	
	protected $pk = 'id';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('fenfangID', 'require', 'fenfangID不能为空！', 1,'',1), 
        array('datacdID', 'require', 'datacdID不能为空！', 1,'',1), 
    ); 


}
?>