<?php

class ShoujiaModel extends Model {
	protected $trueTableName = 'myerp_chanpin_shoujia';	
	protected $pk = 'chanpinID';
		
   // 自动验证设置 
    protected $_validate = array( 
        array('type', 'require', 'type不能为空！', 1,'',1), 
        array('adultprice', 'require', 'adultprice不能为空！', 1,'',1), 
        array('childprice', 'require', 'childprice不能为空！', 1,'',1), 
        array('cut', 'require', 'cut不能为空！', 1,'',1), 
        array('chengben', 'require', 'chengben不能为空！', 1,'',1), 
        array('renshu', 'require', 'renshu不能为空！', 1,'',1), 
        array('openID', 'require', 'openID不能为空！', 1,'',1), 
        array('opentype', 'require', 'opentype不能为空！', 1,'',1), 
//        array('xianlu_status', 'require', 'xianlu_status不能为空！', 1,'',1), 
//        array('xianlu_chutuanriqi', 'require', 'xianlu_chutuanriqi不能为空！', 1,'',1), 
//        array('xianlu_kind', 'require', 'xianlu_kind不能为空！', 1,'',1), 
//        array('xianlu_title', 'require', 'xianlu_title不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
    ); 
}
?>