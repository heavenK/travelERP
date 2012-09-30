<?php

class TaskShenheModel extends Model {
	protected $trueTableName = 'myerp_system_taskshenhe';	
	protected $pk = 'systemID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('systemID', 'require', 'systemID不能为空！', 1,'',1), 
        array('dataID', 'require', 'dataID不能为空！', 1,'',1), 
        array('datatype', 'require', 'datatype不能为空！', 1,'',1), 
        array('processID', 'require', 'processID不能为空！', 1,'',1), 
        array('remark', 'require', 'remark不能为空！', 1,'',1), 
//        array('roles_copy', 'require', 'roles_copy不能为空！', 1,'',1), 
//        array('bumen_copy', 'require', 'bumen_copy不能为空！', 1,'',1), 
        array('datakind', 'require', 'datakind不能为空！', 1,'',1), 
        array('title_copy', 'require', 'title_copy不能为空！', 1,'',1), 
    ); 
	
    // 自动填充设置 
    protected $_auto = array( 
        //array('datakind', 'set_datakind', 1,'callback','datakind',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
    ); 
	
//	protected function set_datakind($datakind) {
//		if($datakind)	
//			return $datakind;
//		else
//			return '';
//	}
//	


}
?>