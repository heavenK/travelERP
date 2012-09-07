<?php

class ViewUserModel extends RelationModel {
	protected $trueTableName = 'myerpview_system_user';	
	protected $pk = 'systemID';	
	
	protected $_link = array(
		//子团
		'zituanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Chanpin','true_class_name'=>'myerpview_chanpin_zituan','foreign_key'=>'title','parent_key'=>'user_name','condition'=>"`status_system` = '1'"),
		//订单
		//'dingdanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Chanpin','true_class_name'=>'myerpview_chanpin_dingdan','foreign_key'=>'title','parent_key'=>'user_name','condition'=>"`status_system` = '1' and `status_shenhe` = '批准'"),
		'dingdanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'Chanpin','true_class_name'=>'myerpview_chanpin_dingdan','foreign_key'=>'title','parent_key'=>'user_name','condition'=>"`status_system` = '1'"),
	);
	

}
?>