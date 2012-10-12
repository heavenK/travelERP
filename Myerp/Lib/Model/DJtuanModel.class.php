<?php

class DJtuanModel extends Model {
	protected $trueTableName = 'myerp_chanpin_djtuan';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('title', 'require', 'title不能为空！', 1,'',1), 
        array('tuanhao', 'require', 'tuanhao不能为空！', 1,'',1), 
        array('fromcompany', 'require', 'fromcompany不能为空！', 1,'',1), 
        array('lianxiren', 'require', 'lianxiren不能为空！', 1,'',1), 
        array('lianxirentelnum', 'require', 'lianxirentelnum不能为空！', 1,'',1), 
        array('onperson', 'require', 'onperson不能为空！', 1,'',1), 
        array('renshu', 'require', 'renshu不能为空！', 1,'',1), 
        array('tianshu', 'require', 'tianshu不能为空！', 1,'',1), 
        array('jietuantime', 'require', 'jietuantime不能为空！', 1,'',1), 
        array('guojing', 'require', 'guojing不能为空！', 1,'',1), 
        array('kind', 'require', 'kind不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('baojia', 'set_baojia', 1,'callback','baojia',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('status_baozhang', 'set_status_baozhang', 1,'callback','status_baozhang',1),//array('field','填充内容','填充条件','附加规则',[额外参数],[表单数据标记])
        array('baozhang_remark', '未报账', 1),
    ); 

	protected function set_baojia($baojia) {
		if($baojia)	
			return $baojia;
		else
			return 0;
	}

	protected function set_status_baozhang($status_baozhang) {
		if($status_baozhang)	
			return $status_baozhang;
		else
			return '未审核';
	}


}
?>