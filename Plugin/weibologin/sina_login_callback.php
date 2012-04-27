<?php
if (!defined('IN_ET')) exit();

session_start();

include_once("oauth.php");
include_once("sinaweibo/config.inc.php");
include_once("sinaweibo/opent.class.php");

$sinawb = new WeiboOAuth(WB_AKEY,WB_SKEY,$_SESSION['keys']['oauth_token'],$_SESSION['keys']['oauth_token_secret']);
$last_key = $sinawb->getAccessToken($_REQUEST['oauth_verifier']);
$_SESSION['last_key']=$last_key;

unset($_SESSION['keys']);
unset($_SESSION['aurl']);

if ($last_key['oauth_token']) {
    $bind=D('Weibobind')->where("sina_uid='$last_key[user_id]'")->find();
    if (!$bind) {
        Cookie::set('sinaloginauth',$last_key['user_id']);
        header("location: ".SITE_URL."/register");
    } else {
        $user=D('Users')->where("user_id='$bind[uid]'")->find();
        Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
        Cookie::set('setok','通过新浪微博帐号登陆成功！');
        header("location: ".SITE_URL.'/'.$user['user_name']);
    }
} else {
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>提示信息</title><style>body{font-size:12px;margin:0 auto}.box{text-align:center;width:250px;height:42px;background:url("'.ET_URL.'/Plugin/weibologin/images/tip.gif") no-repeat;color:#000000;margin:200px auto;line-height:38px;color:#ffffff}a {color:#fff}</style></head><body><div class="box">很抱歉，新浪认证失败！<a href="'.SITE_URL.'">返回主页</a></div></body></html>';
}
?>