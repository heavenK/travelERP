<?php

class ViewBaozhangitemModel extends RelationModel {
	protected $trueTableName = 'myerpview_chanpin_baozhangitem';	
	protected $pk = 'chanpinID';	
	
	protected $_link = array(
		//baozhangitem
		'baozhanglist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Baozhang','true_class_name'=>'myerpview_chanpin_baozhang','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
	);
	

}
?>