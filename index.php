<?php
define('IN_ET', TRUE);
require('./define.inc.php');

define('ET_ROOT', dirname(__FILE__));
define('MODE_NAME','mycore');
define('THINK_PATH','./ThinkPHP/');
define('APP_NAME', 'Myerp');
define('APP_PATH', './Myerp/');
define('DEFAULT_TYPE','default');
define('__PUBLIC__',ET_URL."Public");
define('SITE_URL',ET_URL);
define('APP_DEBUG', true);

require(APP_PATH.'Common/Function.php');
require(APP_PATH.'Common/MyFunction.php');
require(APP_PATH.'Common/FusionCharts.php');
require(APP_PATH.'Common/NewFunction.php');

require(THINK_PATH.'ThinkPHP.php');

?>