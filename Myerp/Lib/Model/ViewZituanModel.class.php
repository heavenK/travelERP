<?php

class ViewZituanModel extends RelationModel {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerpview_chanpin_zituan';	
	protected $pk = 'chanpinID';	
	
	protected $_link = array(
		//zituan
		'shoujialist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'parentID'),
		'xianlulist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Chanpin','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
		'zituan'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Zituan','foreign_key'=>'chanpinID'),
		'xingcheng'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Xingcheng','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
		'chengben'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Chengben','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
	);
	

}
?>