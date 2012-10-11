<?php

    // global config
    define('ET_URL','http://'.$_SERVER['HTTP_HOST'].'/');
    define('SITE_INDEX',ET_URL.'index.php?s=/');
    define('SITE_DATA',ET_URL.'Data/');
	
    define('LOGIN_TIME_REMEMBER', 3600 * 24 * 30);
    define('LOGIN_TIME', 3600 * 6);
    define('LOGIN_TIME_FAILE', 60 * 10);
?>