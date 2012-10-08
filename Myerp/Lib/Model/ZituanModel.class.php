<?php

class ZituanModel extends RelationModel {
	protected $trueTableName = 'myerp_chanpin_zituan';	
	protected $pk = 'chanpinID';
   // 自动验证设置 
    protected $_validate = array( 
        array('title_copy', 'require', 'title_copy不能为空！', 1,'',1), 
        array('guojing_copy', 'require', 'guojing_copy不能为空！', 1,'',1), 
        array('kind_copy', 'require', 'kind_copy不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('adultxiuzheng', 'set_adultxiuzheng', 1,'callback','adultxiuzheng',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('childxiuzheng', 'set_childxiuzheng', 1,'callback','childxiuzheng',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('status_baozhang', 'set_status_baozhang', 1,'callback','status_baozhang',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('baozhang_remark', '未报账', 1),
    ); 
	
	protected function set_adultxiuzheng($adultxiuzheng) {
		if($adultxiuzheng)	
			return $adultxiuzheng;
		else
			return 0;
	}
	protected function set_childxiuzheng($childxiuzheng) {
		if($childxiuzheng)	
			return $childxiuzheng;
		else
			return 0;
	}
	protected function set_status_baozhang($status_baozhang) {
		if($status_baozhang)	
			return $status_baozhang;
		else
			return '未审核';
	}
	
	
	protected $_link = array(
		//zituan
		'shoujialist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_shoujia','foreign_key'=>'parentID'),
		'xianlulist'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Xianlu','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'parentID','parent_key'=>'chanpinID'),
		'xingcheng'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Xingcheng','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
		'chengben'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Chengben','foreign_key'=>'chanpinID','parent_key'=>'parentID'),
		'dingdanlist'=>array('mapping_type'=>HAS_MANY,'class_name'=>'myerpview_chanpin_dingdan','foreign_key'=>'parentID'),
	);
}
?>