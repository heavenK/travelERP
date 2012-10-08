<?php

class OMViewShoujiaModel extends RelationModel {
	protected $trueTableName = 'myerpview_om_shoujia';	
	protected $pk = 'id';	
	//说明，如果通过Distinct数据只能保留过滤字段，关系使用受到限制
	protected $_link = array(
		//shoujia
		'shoujia'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Shoujia','true_class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
	);
	

}
?>