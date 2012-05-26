<?php

class ShoujiaModel extends Model {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_chanpin_shoujia';	
	protected $pk = 'chanpinID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('type', 'require', 'type不能为空！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 

    // 插入数据前的回调方法
    protected function _before_insert(&$data,$options) {
		$data = $this->create($data);
		return $data;
	}
}
?>