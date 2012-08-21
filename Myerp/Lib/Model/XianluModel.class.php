<?php

class XianluModel extends Model {
	protected $trueTableName = 'myerp_chanpin_xianlu';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('kind', 'require', 'kind不能为空！', 1,'',1), 
        array('guojing', 'require', 'guojing不能为空！', 1,'',1), 
        array('baomingjiezhi', 'require', 'baomingjiezhi不能为空！', 1,'',1), 
        array('chufadi', 'require', 'chufadi不能为空！', 1,'',1), 
        array('renshu', 'require', 'renshu不能为空！', 1,'',1), 
        array('tianshu', 'require', 'tianshu不能为空！', 1,'',1), 
        array('chutuanriqi', 'require', 'chutuanriqi不能为空！', 1,'',1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('ischild', '0', 1), 
    ); 

	




}
?>