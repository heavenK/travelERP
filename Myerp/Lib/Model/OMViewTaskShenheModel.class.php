<?php

class OMViewTaskShenheModel extends RelationModel {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerpview_om_taskshenhe';	
	protected $pk = 'id';	
	
	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>BELONGS_TO,'true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
	);
	

}
?>