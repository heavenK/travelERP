<?php

class ViewDJtuanModel extends RelationModel {
	protected $trueTableName = 'myerpview_chanpin_djtuan';	
	protected $pk = 'chanpinID';	
	
	protected $_link = array(
		//DJtuan
		'DJxingchenglist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'DJxingcheng','true_class_name'=>'myerpview_chanpin_djxingcheng','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
	);



}
?>