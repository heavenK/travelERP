<?php
//载入公共配置
$config	=	require 'config.inc.php';

//设定项目配置
$array = array(
    'URL_MODEL'=>3,
    'TMPL_TEMPLATE_SUFFIX'=>'.htm',
    'TMPL_CACHE_TIME'=>-1,//设置为-1
    'TMPL_L_DELIM'=>'<{',
    'TMPL_R_DELIM'=>'}>',
    'DATA_CACHE_SUBDIR'=>true,
    'DATA_PATH_LEVEL'=>2,
);

//合并输出配置
return array_merge($config,$array);
?>