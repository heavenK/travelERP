<?php
if (!defined('IN_ET')) exit();

// ucenter config
define('UC_CONNECT', '');
define('UC_DBHOST', '');
define('UC_DBUSER', '');
define('UC_DBPW', '');
define('UC_DBNAME', '');
define('UC_DBCHARSET', '');
define('UC_DBTABLEPRE', '');
define('UC_DBCONNECT', 0);
define('UC_CHARSET', '');
define('UC_KEY', '');
define('UC_API', '');
define('UC_APPID', '');
define('UC_IP', '');
define('UC_PPP', 20);

define('ADMIN_UID', 2);

    // vesion
    define('ET_VESION', 'X1.8');
	define('ET_RELEASE', '20110829');

    // global config
    define('ET_UC', FALSE);                      //是否开启ucenter ，开启填写 TRUE ，关闭 填写 FALSE
    define('ET_URL','http://m.dlgulian.com/');
	
    define('SITE_ADMIN',ET_URL.'index.php?s=/');
    define('SITE_DIJIE',ET_URL.'gulianDijie.php?s=/');
    define('SITE_MENSHI',ET_URL.'gulianMenshi.php?s=/');
    define('SITE_HOME',ET_URL.'home.php?s=/');
    define('SITE_INDEX',ET_URL.'gulianIndex.php?s=/');
	
    define('SITE_DATA',ET_URL.'data/');
    //define('LOGIN_TIME', 3600 * 24 * 365);
    define('LOGIN_TIME', 3600 * 24 * 3);
    ?>