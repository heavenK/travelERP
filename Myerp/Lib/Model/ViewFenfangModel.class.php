<?php

class ViewFenfangModel extends RelationModel {
	protected $trueTableName = 'myerpview_chanpin_fenfang';	
	protected $pk = 'chanpinID';	
	
	protected $_link = array(
		//fenfang
		'renyuanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerp_datacr','foreign_key'=>'fenfangID'),
	);
}
?>