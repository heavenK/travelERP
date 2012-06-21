<?php
	if (!defined('IN_ET')) exit();

    // global config
    define('ET_URL','http://'.$_SERVER['HTTP_HOST'].'/');
    define('SITE_INDEX',ET_URL.'Index.php?s=/');
    define('SITE_DATA',ET_URL.'data/');
	
    define('LOGIN_TIME_REMEMBER', 3600 * 24 * 30);
    define('LOGIN_TIME', 3600 * 6);
    define('LOGIN_TIME_FAILE', 60 * 10);
	
	
	
	
?>