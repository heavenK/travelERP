<?php

class ViewSystemDCModel extends RelationModel {
	protected $trueTableName = 'myerpview_system_DC';	
	protected $pk = 'systemID';	
	
	protected $_link = array(
		'categorylist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'System','true_class_name'=>'ViewCategory','foreign_key'=>'parentID','parent_key'=>'systemID'),
	);
	

}
?>