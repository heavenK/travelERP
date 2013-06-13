<?php

class OMViewQianzhengModel extends RelationModel {
	protected $trueTableName = 'myerpview_om_qianzheng';	
	protected $pk = 'id';	
	//说明，如果通过Distinct数据只能保留过滤字段，关系使用受到限制
	protected $_link = array(
		//qianzheng
		'qianzheng'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Qianzheng','true_class_name'=>'myerpview_chanpin_qianzheng','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
	);
	
	
	

}
?>