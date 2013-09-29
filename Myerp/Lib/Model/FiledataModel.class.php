<?php

class FiledataModel extends RelationModel {
	protected $trueTableName = 'myerp_filedata';	
	protected $pk = 'filedataID';	
	
   // 自动验证设置
    protected $_validate = array( 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('status', 'set_status', 1,'callback','status,parentID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('time', 'set_time', 1,'callback','time',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('user_name', 'set_user_name', 1,'callback','user_name',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('departmentID', 'set_department', 1,'callback','departmentID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('bumen_copy', 'set_bumen_copy', 3,'callback','departmentID',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('marktype', 'set_marktype', 1,'callback'),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('islock', 'set_islock', 1,'callback','islock',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('status_system', 'set_status_system', 1,'callback','status_system',1),//1正常,-1删除
        array('companyID', 'set_companyID', 1,'callback','companyID',1),//1正常,-1删除
    ); 
	
	protected function set_status($status,$parentID) {
		if($status != '')	
			return $status;
		else
			return '准备';
	}
	
	protected function set_islock($islock) {
		if($islock != '')	
			return $islock;
		else
			return '未锁定';
	}
	
	protected function set_status_system($status_system) {//1正常,-1删除
		if($status_system != '')	
			return $status_system;
		else
			return 1;
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
	
	protected function set_department($departmentID) {
		if($departmentID != '')
			return $departmentID;
		else{
			$role = A("Method")->_checkRolesByUser('财务','行政',1);
			return $role[0]['bumenID'];
		}
	}
	
	protected function set_bumen_copy($departmentID) {
		if($departmentID){
			return NF_getbumen_title($departmentID);
		}
			$role = A("Method")->_checkRolesByUser('财务','行政',1);
		$ViewDepartment = D("ViewDepartment");
		$company = $ViewDepartment->where("`systemID` = '$role[0][ComID]'")->find();
		return $company['title'];
	}
	
	protected function set_user_name($user_name) {
		if($user_name != '')	
			return $user_name;
		else
			return NF_getusername();
	}
	
	protected function set_status_shenhe($status_shenhe) {
		if($status_shenhe)	
			return $status_shenhe;
		else
			return '未审核';
	}
	
	protected function set_companyID($companyID) {
		if($companyID != '')	
			return $companyID;
		else{
			return $ComID = A("Method")->_getComIDbyUser();
		}
	}
	
	protected $_link = array(
		//hetong
		'hetong'=>array('mapping_type'=>HAS_ONE,'class_name'=>'Hetong','foreign_key'=>'filedataID'),
	);
	

}
?>