<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename admin.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

define('IN_ET', TRUE);
require('./define.inc.php');
error_reporting(7);

define('ET_ROOT', dirname(__FILE__));
define('THINK_MODE','EasytalkAdmin');
define('THINK_PATH','./ThinkPHP');
define('APP_NAME', 'Admin');
define('APP_PATH', './Admin');
define('DEFAULT_TYPE','default');
define('__PUBLIC__',ET_URL."/Public");
define('SITE_URL',ET_URL);

require(THINK_PATH.'/ThinkPHP.php');
require('./Home/Common/Function.php');
require(APP_PATH.'/Common/Function.php');

//载入ucenter
if (ET_UC==TRUE) {
    require(ET_ROOT.'/client/client.php');
}

App::run();
?>