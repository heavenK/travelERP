<?php
define('IN_ET', TRUE);
require('./define.inc.php');
require('./define2.inc.php');

define('ET_ROOT', dirname(__FILE__));
define('MODE_NAME','mycore');
//define('THINK_PATH','./ThinkPHP/');
define('THINK_PATH',dirname(__FILE__).'/../ThinkPHP/');
define('APP_NAME', 'Myerp');
define('APP_PATH', './Myerp/');
define('DEFAULT_TYPE','default');
define('__PUBLIC__',ET_URL."Public");
define('APP_DEBUG', false);//调试模式（无缓存）

require(APP_PATH.'Common/Function.php');
require(APP_PATH.'Common/MyFunction.php');
require(APP_PATH.'Common/FusionCharts.php');
require(APP_PATH.'Common/NewFunction.php');
require(APP_PATH.'Common/B2CFunction.php');

require(THINK_PATH.'ThinkPHP.php');

?>