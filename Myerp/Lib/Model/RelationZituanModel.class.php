<?php

class RelationZituanModel extends RelationModel {
	protected $trueTableName = 'myerp_chanpin_zituan';	
	protected $pk = 'chanpinID';	
	protected $_link = array(
	'Zituan'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerp_chanpin_zituan','foreign_key'=>'chanpinID'),
	);


}
?>