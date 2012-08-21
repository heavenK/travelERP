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
        array('baojia', '0', 1),
        array('status_baozhang', '未报账', 1), 
    ); 

	




}
?>