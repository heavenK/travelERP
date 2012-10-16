<?php

class ViewBaozhangModel extends RelationModel {
	protected $trueTableName = 'myerpview_chanpin_baozhang';	
	protected $pk = 'chanpinID';	
	
	protected $_link = array(
		//baozhang
		'baozhangitemlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_baozhangitem','foreign_key'=>'parentID','condition'=>"`status_system` = '1'"),
		'zituanlist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Zituan','true_class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
	);
	

}
?>