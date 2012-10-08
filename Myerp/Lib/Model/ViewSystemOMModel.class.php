<?php

class ViewSystemOMModel extends RelationModel {
	protected $trueTableName = 'myerpview_system_om';	
	protected $pk = 'systemID';	
	
	protected $_link = array(
//		'OMparentC'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Category','true_class_name'=>'myerpview_system_category','foreign_key'=>'systemID','parent_key'=>'parentID'),
//		'OMparentD'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Department','true_class_name'=>'myerpview_system_department','foreign_key'=>'systemID','parent_key'=>'parentID'),
//		'OMparentU'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'User','true_class_name'=>'myerpview_system_User','foreign_key'=>'systemID','parent_key'=>'parentID'),
//		'OMparentR'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Roles','true_class_name'=>'myerpview_system_Roles','foreign_key'=>'systemID','parent_key'=>'parentID'),
	);
	

}
?>