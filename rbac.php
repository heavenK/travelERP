<?php
define('IN_ET', TRUE);
require('./define.inc.php');

define('ET_ROOT', dirname(__FILE__));
define('MODE_NAME','mycore');
define('THINK_PATH','./ThinkPHP/');
define('APP_NAME', 'Rbac');
define('APP_PATH', './Rbac/');
//define('DEFAULT_TYPE','default');
//define('SITE_URL',ET_URL);
define('APP_DEBUG', true);

define('_PHP_FILE_',$_SERVER['SCRIPT_NAME']);//thinkphp 对php-cgi 解析bug

require('./Myerp/Common/Function.php');
require(THINK_PATH.'ThinkPHP.php');

?>