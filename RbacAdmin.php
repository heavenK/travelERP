<?php
define('IN_ET', TRUE);
require('./define.inc.php');
error_reporting(7);

define('ET_ROOT', dirname(__FILE__));
define('THINK_MODE','EasytalkAdmin');
define('THINK_PATH','./ThinkPHP');
define('APP_NAME', 'RbacAdmin');
define('APP_PATH', './RbacAdmin');
define('DEFAULT_TYPE','default');
define('__PUBLIC__',ET_URL."/Public");
define('SITE_URL',ET_URL);

require(THINK_PATH.'/ThinkPHP.php');
require('./Home/Common/Function.php');

App::run();
?>