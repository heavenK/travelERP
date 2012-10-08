<?php

class ViewXianluModel extends RelationModel {
	protected $trueTableName = 'myerpview_chanpin_xianlu';	
	protected $pk = 'chanpinID';	
	
	protected $_link = array(
		//xianlu
		'zituanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'parentID'),
		'shoujialist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'parentID'),
		'xingcheng'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Xingcheng','foreign_key'=>'chanpinID'),
		'chengben'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Chengben','foreign_key'=>'chanpinID'),
		//zituan
		'xianlulist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Xianlu','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
		'zituan'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Zituan','foreign_key'=>'chanpinID'),
		//shoujia
		'shoujia'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Shoujia','foreign_key'=>'chanpinID'),
	);
	

}
?>