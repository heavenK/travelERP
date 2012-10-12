<?php

class OMViewTaskShenheModel extends RelationModel {
	protected $trueTableName = 'myerpview_om_taskshenhe';	
	protected $pk = 'id';	
	
	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Xianlu','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//baozhangitem
		'baozhangitem'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Baozhangitem','true_class_name'=>'myerpview_chanpin_baozhangitem','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//baozhang
		'baozhang'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Baozhang','true_class_name'=>'myerpview_chanpin_baozhang','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//dingdan
		'dingdan'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Dingdan','true_class_name'=>'myerpview_chanpin_dingdan','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//DJtuan
		'DJtuan'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'DJtuan','true_class_name'=>'myerpview_chanpin_djtuan','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
	);
	

}
?>