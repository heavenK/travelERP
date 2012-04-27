<?php

define('IN_ET', TRUE);
require('./define.inc.php');
error_reporting(7);

define('ET_ROOT', dirname(__FILE__));
define('THINK_MODE','EasytalkAdmin');
define('THINK_PATH','./ThinkPHP');
define('APP_NAME', 'GulianDijie');
define('APP_PATH', './GulianDijie');
define('DEFAULT_TYPE','default');
define('__PUBLIC__',ET_URL."/Public");
define('SITE_URL',ET_URL);

require(THINK_PATH.'/ThinkPHP.php');
require('./GulianAdmin/Common/Function.php');
require('./Home/Common/Function.php');
require('./GulianAdmin/Lib/Action/MessageAction.class.php');
require('./GulianAdmin/Lib/Action/CommonAction.class.php');
App::run();
?>