<?php

class OMViewSearchModel extends RelationModel {
	protected $trueTableName = 'myerpview_om_search';	
	protected $pk = 'id';	
	//说明，如果通过Distinct数据只能保留过滤字段，关系使用受到限制
	protected $_link = array(
	);
	

}
?>