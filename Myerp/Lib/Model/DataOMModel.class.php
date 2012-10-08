<?php

class DataOMModel extends RelationModel {
	protected $trueTableName = 'myerp_dataom';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
        array('type', 'require', 'type不能为空！', 1,'',1), 
        array('DUR', 'require', 'DUR不能为空！', 1,'',1), 
//        array('OMID', 'require', 'OMID不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('time', 'time', 1, 'function'), 
    ); 

	protected $_link = array(
		//xianlu
		'xianlu'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Xianlu','true_class_name'=>'myerpview_chanpin_xianlu','foreign_key'=>'dataID','parent_key'=>'chanpinID'),
		//infohistory
		'infohistory'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Infohistory','true_class_name'=>'merpview_message_infohistory','foreign_key'=>'dataID','parent_key'=>'messageID'),
		//dingdan
		'dingdan'=>array('mapping_type'=>BELONGS_TO,'class_name'=>'Dingdan','true_class_name'=>'myerpview_chanpin_dingdan','foreign_key'=>'dataID','parent_key'=>'chanpinID'),

	);


}
?>