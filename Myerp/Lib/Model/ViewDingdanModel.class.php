<?php

class ViewDingdanModel extends RelationModel {
	protected $trueTableName = 'myerpview_chanpin_dingdan';	
	protected $pk = 'chanpinID';	
	
	protected $_link = array(
		//dingdan
		'zituanlist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Zituan','true_class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
		'tuanyuanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'DataCD','foreign_key'=>'dingdanID','parent_key'=>'chanpinID'),
	);
	

}
?>