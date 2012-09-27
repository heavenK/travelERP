<?php

class OMViewTaskShenheModel extends RelationModel {
	protected $trueTableName = 'myerpview_om_taskshenhe';	
	protected $pk = 'id';	
	
	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>BELONGS_TO,'true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//baozhangitem
		'baozhangitem'=>array('mapping_type'=>BELONGS_TO,'true_class_name'=>'myerpview_chanpin_baozhangitem','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//baozhang
		'baozhang'=>array('mapping_type'=>BELONGS_TO,'true_class_name'=>'myerpview_chanpin_baozhang','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//dingdan
		'dingdan'=>array('mapping_type'=>BELONGS_TO,'true_class_name'=>'myerpview_chanpin_dingdan','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
	);
	

}
?>