<?php

class OMViewInfoModel extends RelationModel {
	protected $trueTableName = 'myerpview_om_info';	
	protected $pk = 'id';	
	//说明，如果通过Distinct数据只能保留过滤字段，关系使用受到限制
	protected $_link = array(
		'info'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Info','true_class_name'=>'myerpview_message_info','foreign_key'=>'dataID','parent_key'=>'messageID'),
	);
	

}
?>