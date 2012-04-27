<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename index.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

header('Content-Type: text/html; charset=utf-8');
define('IN_ET', TRUE);
require('./define.inc.php');
error_reporting(7);

define('ET_ROOT', dirname(__FILE__));
define('THINK_MODE','Easytalk');
define('THINK_PATH','./ThinkPHP');
define('APP_NAME', 'Home');
define('APP_PATH', './Home');
define('DEFAULT_TYPE','default');
define('__PUBLIC__',ET_URL."/Public");

require(THINK_PATH.'/ThinkPHP.php');
require(APP_PATH.'/Common/Function.php');

//载入ucenter
if (ET_UC==TRUE) {
    require(ET_ROOT.'/client/client.php');
}
//监测安装
//if (!file_exists(ET_ROOT.'/Public/install.lock'))  {
//    header('location: ./install');
//    exit;
//}
App::run();
?>