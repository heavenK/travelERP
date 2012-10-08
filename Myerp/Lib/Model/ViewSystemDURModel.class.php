<?php

class ViewSystemDURModel extends RelationModel {
	protected $trueTableName = 'myerpview_system_dur';	
	protected $pk = 'systemID';	
	
	protected $_link = array(
		'bumen'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Department','true_class_name'=>'ViewDepartment','foreign_key'=>'bumenID','parent_key'=>'systemID'),
	);
	

}
?>