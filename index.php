<?php
define('IN_ET', TRUE);
require('./define.inc.php');
error_reporting(7);

define('ET_ROOT', dirname(__FILE__));
define('THINK_MODE','Mycore');
define('THINK_PATH','./ThinkPHP');
define('APP_NAME', 'Myerp');
define('APP_PATH', './Myerp');
define('DEFAULT_TYPE','default');
define('__PUBLIC__',ET_URL."Public");
define('SITE_URL',ET_URL);

require(THINK_PATH.'/ThinkPHP.php');
require(APP_PATH.'/Common/Function.php');
require(APP_PATH.'/Common/MyFunction.php');
require(APP_PATH.'/Common/FusionCharts.php');

App::run();
?>