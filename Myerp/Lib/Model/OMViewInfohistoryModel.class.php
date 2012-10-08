<?php

class OMViewInfohistoryModel extends RelationModel {
	protected $trueTableName = 'myerpview_om_infohistory';	
	//说明，如果通过Distinct数据只能保留过滤字段，关系使用受到限制
	protected $_link = array(
		//infohistory
		'infohistory'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Infohistory','true_class_name'=>'myerpview_message_infohistory','foreign_key'=>'dataID','parent_key'=>'messageID'),
	);
	

}
?>