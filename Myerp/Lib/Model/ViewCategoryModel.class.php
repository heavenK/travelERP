<?php

class ViewCategoryModel extends RelationModel {
	protected $trueTableName = 'myerpview_system_category';	
	protected $pk = 'systemID';	
	
	protected $_link = array(
		//category
		'categoryOMlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_system_om','foreign_key'=>'dataID'),
		'systemDClist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'ViewSystemDC','foreign_key'=>'parentID'),
	);
	

}
?>