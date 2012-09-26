<?php

class MessageModel extends RelationModel {
	protected $trueTableName = 'myerp_message';	
	protected $pk = 'messageID';	
	
   // 自动验证设置 
    protected $_validate = array( 
//        array('user_name', 'require', '用户名必须！', 1), 
    ); 
	
    // 自动填充设置 
    protected $_auto = array( 
        array('status', 'set_status', 1,'callback','status,parentID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('time', 'set_time', 1,'callback','time',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('user_name', 'set_user_name', 1,'callback','user_name',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('departmentID', 'set_department', 1,'callback','departmentID,messageID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('bumen_copy', 'set_bumen_copy', 3,'callback','departmentID,messageID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('marktype', 'set_marktype', 1,'callback'),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('islock', '未锁定', 1),
        array('status_system', 'set_status_system', 1,'callback','status_system',1),//1正常,-1删除
    ); 
	
	protected function set_status_system($status_system) {//1正常,-1删除
		if($status_system != '')	
			return $status_system;
		else
			return 1;
	}
	protected function set_status($status,$parentID) {
		if($status != '')	
			return $status;
		else
			return '';
	}
	protected function set_time($time) {
		if($time != '')	
			return $time;
		else
			return time();
	}
	protected function set_marktype() {
		$options = $this->getRelationOptions();
		return $options;
	}
	protected function set_user_name($user_name) {
		if($user_name != '')	
			return $user_name;
		else
			return NF_getusername();
	}
	
	protected function set_department($departmentID,$chanpinID) {
		if($departmentID != '')
			return $departmentID;
		else
			return NF_getmydepartmentid($chanpinID);
	}
	
	protected function set_bumen_copy($departmentID,$messageID) {
		if($messageID){
			$dt = $this->where("`messageID` = '$messageID'")->find();
			return $dt['bumen_copy'];
		}
		return NF_getbumen_title($departmentID);
	}
	
	protected $_link = array(
		//infohistory
		'infohistory'=>array('mapping_type'=>HAS_ONE,'class_name'=>'InfoHistory','foreign_key'=>'messageID'),
		//info
		'info'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Info','foreign_key'=>'messageID'),
	);
	

}
?>