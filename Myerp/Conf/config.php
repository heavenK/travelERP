<?php
//载入公共配置
$config	=	require 'config.inc.php';

//设定项目配置
$array = array(
    'URL_MODEL'=>3,
    'URL_ROUTER_ON'=>true,

    'TMPL_TEMPLATE_SUFFIX'=>'.html',
    'TMPL_CACHE_TIME'=>0,
    'TMPL_L_DELIM'=>'<{',
    'TMPL_R_DELIM'=>'}>',
    'DATA_CACHE_SUBDIR'=>true,
    'DATA_PATH_LEVEL'=>2,

    'LANG_SWITCH_ON'=>true,
    'LANG_AUTO_DETECT'=>false,
    'DEFAULT_LANG'=>'zh-cn',
    'DB_FIELDTYPE_CHECK'=>true,
	//'DB_PREFIX'=>'', 
	//可以被访问的类
    //'DIFNAME'=>array('admin','home','api','client','index','pub','v','m','p','setting','dologin','login','logout','register','regcheck','reset','doreset','checkreset','setpass','space','message','find','topic','hot','index','widget','comments','wap','map','plugins','url','guide','sendapi','blacklist'),


	//RBAC配置增加设置  
	'USER_AUTH_MODEL'    =>'Users',  
	'USER_AUTH_ON'   =>true,  //是否需要认证  
	'USER_AUTH_TYPE'     =>'2',   //认证类型:1为登录模式，2为实时模式  
	'USER_AUTH_KEY'  =>'user_id',    //认证识别号（SEESION的用户ID名）  
	'ADMIN_AUTH_KEY'     =>'admin',  //管理员SEESION  
	'REQUIRE_AUTH_MODULE'   =>'',     //需要认证模块（模块名之间用短号分开）  
	'NOT_AUTH_MODULE'    =>'',    //无需认证模块（模块名之间用短号分开）  
	'REQUIRE_AUTH_ACTION'   =>'',     //需要认证方法（方法名之间用短号分开）  
	'NOT_AUTH_ACTION'    =>'',    //无需认证方法（方法名之间用短号分开）  
	'USER_AUTH_GATEWAY'  =>'',    //认证网关  
	'RBAC_ROLE_TABLE'	=>	'role',
	'RBAC_USER_TABLE'	=>	'role_user',
	'RBAC_ACCESS_TABLE' =>	'access',
	'RBAC_NODE_TABLE'	=>  'node',
	//显示页面Trace信息
	//'SHOW_PAGE_TRACE' =>true,
);

//合并输出配置
return array_merge($config,$array);
?>