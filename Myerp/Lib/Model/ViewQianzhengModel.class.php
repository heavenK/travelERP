<?php

class ViewQianzhengModel extends RelationModel {
	protected $trueTableName = 'myerpview_chanpin_qianzheng';	
	protected $pk = 'chanpinID';	
	
	protected $_link = array(
		//xianlu
		//'zituanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'parentID'),
	);
	

}
?>