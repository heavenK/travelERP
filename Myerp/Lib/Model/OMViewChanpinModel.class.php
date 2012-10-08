<?php

class OMViewChanpinModel extends RelationModel {
	protected $trueTableName = 'myerpview_om_chanpin';	
	protected $pk = 'id';	
	//protected $pk = 'chanpinID';	
	//说明，如果通过Distinct数据只能保留过滤字段，关系使用受到限制
	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Xianlu','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		'zituanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'parentID'),
		//shoujia
		'shoujia'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Shoujia','true_class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//dingdan
		'dingdan'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Dingdan','true_class_name'=>'myerpview_chanpin_dingdan','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//zituan
		'zituan'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Zituan','true_class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//DJtuan
		'DJtuan'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'DJtuan','true_class_name'=>'myerpview_chanpin_djtuan','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
	);
	

}
?>