<?php

class JijiuModel extends Model {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_chanpin_Jijiu';	
	protected $pk = 'chanpinID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('chanpinID', 'require', 'chanpinID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('jipiaoprice', '0', 1), 
        array('jipiaoprice2', '0', 1), 
        array('jipiaocut', '0', 1), 
        array('jiudianprice', '0', 1), 
        array('jiudianprice2', '0', 1), 
        array('jiudiancut', '0', 1), 
    ); 


}
?>