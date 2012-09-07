<?php
//载入公共配置
$config	=	require 'config.inc.php';
$config['VAR_PAGE'] =  'p';//分页配置
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
	'USER_AUTH_MODEL'    =>'User',  
	'USER_AUTH_ON'   =>true,  //是否需要认证  
	'USER_AUTH_TYPE'     =>'2',   //认证类型:1为登录模式，2为实时模式  
	'USER_AUTH_KEY'  =>'systemID',    //认证识别号（SEESION的用户ID名）  
	'ADMIN_AUTH_KEY'     =>'superAdmin',  //管理员SEESION  
	'REQUIRE_AUTH_MODULE'   =>'',     //需要认证模块（模块名之间用短号分开）  
	'NOT_AUTH_MODULE'    =>'',    //无需认证模块（模块名之间用短号分开）  
	'REQUIRE_AUTH_ACTION'   =>'',     //需要认证方法（方法名之间用短号分开）  
	'NOT_AUTH_ACTION'    =>'',    //无需认证方法（方法名之间用短号分开）  
	'USER_AUTH_GATEWAY'  =>'',    //认证网关  
        'RBAC_ROLE_TABLE'           =>'think_role',
        'RBAC_USER_TABLE'           =>'think_role_user',
        'RBAC_ACCESS_TABLE'         =>'think_access',
        'RBAC_NODE_TABLE'           =>'think_node',
	
	//显示页面Trace信息
	//'SHOW_PAGE_TRACE' =>true,
	'SHOW_ERROR_MSG' =>true,
	
	'TAGLIB_PRE_LOAD' => 'Tp' ,//加载标签库
	'APP_AUTOLOAD_PATH'=>'@.TagLib',//加载标签库
	'DB_FIELDTYPE_CHECK'=>true,  // 开启字段类型验证
	
	'TOKEN_ON'=>true,  // 是否开启令牌验证
	'TOKEN_NAME'=>'__hash__',    // 令牌验证的表单隐藏字段名称
	'TOKEN_TYPE'=>'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'=>true,  //令牌验证出错后是否重置令牌 默认为true	
	
	//'DB_LIKE_FIELDS' => 'message|remark',//模糊搜索设置
	
	'SESSION_OPTIONS'=>array(
		//session配置，不同浏览器共享
		//'id'=> 'think',
	),	

//    'URL_ROUTE_RULES' => array(
//        'cate/:id\d'                 => 'Blog/category',
//        '/^Blog\/(\d+)$/is'       => 'Blog/show?id=:1',
//        '/^Blog\/(\d+)\/(\d+)/is'=> 'Blog/archive?year=:1&month=:2',
//    ),
);

//合并输出配置
return array_merge($config,$array);
?>