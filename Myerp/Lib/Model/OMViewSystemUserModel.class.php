<?php

class OMViewSystemUserModel extends RelationModel {
	protected $trueTableName = 'myerpview_omsys_user';	
	protected $pk = 'id';	
	//说明，如果通过Distinct数据只能保留过滤字段，关系使用受到限制
	protected $_link = array(
		//user
		'user'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'User','true_class_name'=>'myerpview_system_user','foreign_key'=>'dataID','parent_key'=>'systemID'),
	);
	

}
?>