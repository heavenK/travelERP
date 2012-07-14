<?php

class OMViewChanpinModel extends RelationModel {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerpview_om_chanpin';	
	protected $pk = 'id';	
	
	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Xianlu','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//shoujia
		'shoujia'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Shoujia','true_class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
	);
	

}
?>