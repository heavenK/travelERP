<?php

class OMViewSystemCategoryModel extends RelationModel {
	protected $trueTableName = 'myerpview_omsys_category';	
	protected $pk = 'id';	
	//说明，如果通过Distinct数据只能保留过滤字段，关系使用受到限制
	protected $_link = array(
		//category
		'category'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Category','true_class_name'=>'myerpview_system_category','foreign_key'=>'dataID','parent_key'=>'systemID'),
	);
	

}
?>