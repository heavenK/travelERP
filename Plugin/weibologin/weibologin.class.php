<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename weibologin_action.class.php $

    @Author hjoeson $

    @Date 2011-04-16 08:45:20 $
*************************************************************/

if (!defined('IN_ET')) exit();

include_once("oauth.php");

include_once("sinaweibo/config.inc.php");
include_once("sinaweibo/opent.class.php");

include_once("qqweibo/config.inc.php");
include_once("qqweibo/opent.class.php");

class weibologin_action {
    var $pm;

    function __construct(&$pluginManager,$action) {
        $this->pm=$pluginManager;
        if (method_exists($this->pm,add_view)) {
            if ($action=='view') {
                $this->pm->add_view('index_login_btn','weibologin_sinalogin1',$this,'login','');
                $this->pm->add_view('login_btn','weibologin_sinalogin2',$this,'login','');
                $this->pm->add_view('register_top','weibologin_sinareg',$this,'register');
                $this->pm->add_view('reg_login_btn','weibologin_side3',$this,'login','reg');
                $this->pm->add_view('index_post_top2','weibosendswitch1',$this,'sendswitch');
                $this->pm->add_view('topic_top','weibosendswitch2',$this,'sendswitch');
                $this->sidelogo();
            } else {
                $this->pm->add_action('register','weibologin_dosinabind',$this,'dobind');
                $this->pm->add_action('sendtalk','weibologin_sendtalk',$this,'sendtalk');
            }
        }
    }

    function login($data) {
        session_start();

        //sina
        $sinawb = new WeiboOAuth(WB_AKEY,WB_SKEY);
        $keys = $sinawb->getRequestToken();
        $aurl = $sinawb->getAuthorizeURL($keys['oauth_token'],false,SITE_URL.'/p/weibologin?out=sina_login_callback.php');
        $_SESSION['keys'] = $keys;
        $_SESSION['aurl'] = $aurl;
        //qq
        $qqwb = new MBOpenTOAuth(MB_AKEY,MB_SKEY);
        $qqkeys = $qqwb->getRequestToken(SITE_URL.'/p/weibologin?out=qq_login_callback.php');
        $qqaurl = $qqwb->getAuthorizeURL($qqkeys['oauth_token'],false,'');
        $_SESSION['qqkeys'] = $qqkeys;
        $_SESSION['qqaurl'] = $qqaurl;


        if ($data=='reg') {
            $result='<div style="border-top:1px dashed #9f9f9f;margin-top:30px;padding-top:30px;text-align:center">
                <p>还可使用以下方式登陆：</p><br/>
                <a href="'.$_SESSION['aurl'].'"><img src="'.ET_URL.'/Plugin/weibologin/images/sinalogin.png"></a>&nbsp;&nbsp;&nbsp;
                <a href="'.$_SESSION['qqaurl'].'"><img src="'.ET_URL.'/Plugin/weibologin/images/qqlogin.gif"></a>
            </div>';
        } else {
            $result='<div style="margin-top:10px">
                <a href="'.$_SESSION['aurl'].'"><img src="'.ET_URL.'/Plugin/weibologin/images/sinalogin.png"></a>&nbsp;&nbsp;&nbsp;
                <a href="'.$_SESSION['qqaurl'].'"><img src="'.ET_URL.'/Plugin/weibologin/images/qqlogin.gif"></a>
            </div>';
        }
        return $result;
    }

    function sendswitch() {
        $user_name=$_GET['user_name']?$_GET['user_name']:Action::$login_user['user_name'];
        $user=D('Users')->where("user_name='$user_name'")->find();
        $bind=D('weibobind')->where("uid='$user[user_id]'")->find();

        if ($bind['sendtosina']==1) {
            $result.='<a title="点击不同步发送到新浪微博" href="'.SITE_URL.'/p/weibologin?t=sina"><img src="'.ET_URL.'/Plugin/weibologin/images/sinawebo_on.gif"></a>&nbsp;';
        } else {
            $result.='<a title="您还没有开启广播同步到新浪" href="'.SITE_URL.'/p/weibologin?t=sina"><img src="'.ET_URL.'/Plugin/weibologin/images/sinawebo_off.gif"></a>&nbsp;';
        }
        if ($bind['sendtoqq']==1) {
            $result.='<a title="点击不同步发送到腾讯微博" href="'.SITE_URL.'/p/weibologin?t=qq"><img src="'.ET_URL.'/Plugin/weibologin/images/qqwb_on.gif"></a>';
        } else {
            $result.='<a title="您还没有开启广播同步到腾讯" href="'.SITE_URL.'/p/weibologin?t=qq"><img src="'.ET_URL.'/Plugin/weibologin/images/qqwb_off.gif"></a>';
        }
        return $result;
    }

    function sidelogo()  {
        $user_name=$_GET['user_name']?$_GET['user_name']:Action::$login_user['user_name'];
        $user=D('Users')->where("user_name='$user_name'")->find();
        $bind=D('weibobind')->where("uid='$user[user_id]'")->find();

        if ($bind) {
            if ($bind['sina_uid'] && $bind['sina_token'] && $bind['sina_tsecret']) {
                $sinaico='<img src="'.ET_URL.'/Plugin/weibologin/images/sinawebo_on.gif" title="已经绑定新浪微博帐号">';
            } else {
                $sinaico='<img src="'.ET_URL.'/Plugin/weibologin/images/sinawebo_off.gif" title="没有绑定新浪微博帐号">';
            }
            if ($bind['qq_uid'] && $bind['qq_token'] && $bind['qq_tsecret']) {
                $qqico='<img src="'.ET_URL.'/Plugin/weibologin/images/qqwb_on.gif" title="已经绑定腾讯微博帐号">';
            } else {
                $qqico='<img src="'.ET_URL.'/Plugin/weibologin/images/qqwb_off.gif" title="没有绑定腾讯微博帐号">';
            }
        } else {
            $sinaico='<img src="'.ET_URL.'/Plugin/weibologin/images/sinawebo_off.gif" title="没有绑定新浪微博帐号">';
            $qqico='<img src="'.ET_URL.'/Plugin/weibologin/images/qqwb_off.gif" title="没有绑定腾讯微博帐号">';
        }

        $sina='<a href="'.SITE_URL.'/p/weibologin?t=sina">'.$sinaico.'</a>';
        $qq='<a href="'.SITE_URL.'/p/weibologin?t=qq">'.$qqico.'</a>';

        $this->pm->add_ico('home_side_mid2',$sina,1);
        $this->pm->add_ico('home_side_mid2',$qq,2);
        $this->pm->add_ico('profile_side_mid',$sina,1);
        $this->pm->add_ico('profile_side_mid',$qq,2);
    }

    function register() {
        $sinaloginauth = Cookie::get('sinaloginauth');
        $qqloginauth = Cookie::get('qqloginauth');
        if ($sinaloginauth) {
            return '<div class="invite" style="width:500px">当您注册成功后将自动绑定帐号ID为：<b>'.$sinaloginauth.'</b> 的新浪微博帐号！<br/>提示：如果您已经有了微博帐号，请登录后直接绑定即可！</div>';
        } else if ($qqloginauth) {
            return '<div class="invite" style="width:500px">当您注册成功后将自动绑定帐号ID为：<b>'.$qqloginauth.'</b> 的腾讯微博帐号！<br/>提示：如果您已经有了微博帐号，请登录后直接绑定即可！</div>';
        }
    }

    function dobind() {
        $sinaloginauth = Cookie::get('sinaloginauth');
        $qqloginauth = Cookie::get('qqloginauth');
        $uid=mysql_insert_id();

        $weibo=D('Weibobind');
        $bind=$weibo->where("uid='$uid'")->find();

        if ($uid && $_SESSION['last_key'] && $_SESSION['last_key']['user_id']==$sinaloginauth) {
            if ($bind) {
                $weibo->where("uid='$uid'")->setField(array('sina_uid','sina_token','sina_tsecret'),array($_SESSION['last_key']['user_id'],$_SESSION['last_key']['oauth_token'],$_SESSION['last_key']['oauth_token_secret']));
            } else {
                $insert['uid']=$uid;
                $insert['sina_uid']=$_SESSION['last_key']['user_id'];
                $insert['sina_token']=$_SESSION['last_key']['oauth_token'];
                $insert['sina_tsecret']=$_SESSION['last_key']['oauth_token_secret'];
                $weibo->add($insert);
            }
        } else if ($uid && $_SESSION['qqlast_key'] && $_SESSION['qqlast_key']['name']==$qqloginauth) {
            if ($bind) {
                $weibo->where("uid='$uid'")->setField(array('qq_uid','qq_token','qq_tsecret'),array($_SESSION['qqlast_key']['name'],$_SESSION['qqlast_key']['oauth_token'],$_SESSION['qqlast_key']['oauth_token_secret']));
            } else {
                $insert['uid']=$uid;
                $insert['qq_uid']=$_SESSION['qqlast_key']['name'];
                $insert['qq_token']=$_SESSION['qqlast_key']['oauth_token'];
                $insert['qq_tsecret']=$_SESSION['qqlast_key']['oauth_token_secret'];
                $weibo->add($insert);
            }
        }
        Cookie::delete('sinaloginauth');
        Cookie::delete('qqloginauth');
        return true;
    }

    function sendtalk() {
        $weibo=D('Weibobind');
        $ctent=D('Content');
        $user=Action::$login_user;
        $contentid=mysql_insert_id();

        if ($contentid) {
            $content=$ctent->where("content_id='$contentid'")->find();
            $text=$content['content_body'];
            $media=$content['media_body'];
            $text=str_replace('&amp;','&',$text);
            $text=ubbreplace($text);
            $media=ubbreplace($content['media_body']);
            $st=getsubstr($media,0,7,false);
            if ($st=='http://' || $st=='/photo/') {
                if ($st=='/photo/') {
                    $media=__PUBLIC__.'/attachments'.$media;
                    $media=str_replace('s_','',$media);
                }
                $text=$text.$media;
            }
            $text=clean_html($text);
        }

        if ($text) {
            $bind=$weibo->where("uid='$user[user_id]'")->find();
            if ($bind['sina_uid'] && $bind['sina_token'] && $bind['sina_tsecret'] && $bind['sendtosina']==1) {
                $sinawb = new WeiboClient(WB_AKEY,WB_SKEY,$bind['sina_token'],$bind['sina_tsecret']);
                $me = $sinawb->verify_credentials();
                if ($me['id']==$bind['sina_uid']) {
                    $rssina=$sinawb->update($text);
                }
            }

            if ($bind['qq_uid'] && $bind['qq_token'] && $bind['qq_tsecret'] && $bind['sendtoqq']==1) {
                include_once("qqweibo/api_client.php");
                $qqwb = new MBApiClient(MB_AKEY,MB_SKEY,$bind['qq_token'],$bind['qq_tsecret']);
                $me=$qqwb->getUserInfo();
                if ($me['data']['name']==$bind['qq_uid']) {
                    $p =array(
                        'c' => $text,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'j' => '',
                        'w' => ''
                    );
                    $rsqq=$qqwb->postOne($p);
                }
            }
        }
    }

    function page() {
        $type=$_GET['t']?$_GET['t']:'sina';
        $action=$_REQUEST['act'];
        $user=Action::$login_user;

        $weibo=D('weibobind');
        $bind=$weibo->where("uid='$user[user_id]'")->find();

        if ($action=='sinasave') {
            $sinatb=intval($_POST['sinatb']);

            $weibo->where("uid='$user[user_id]'")->setField('sendtosina',$sinatb);

            Cookie::set('setok','新浪帐号设置成功');
            header('location: '.SITE_URL.'/p/weibologin?t=sina');
            exit;
        }

        if ($action=='qqsave') {
            $qqtb=intval($_POST['qqtb']);

            $weibo->where("uid='$user[user_id]'")->setField('sendtoqq',$qqtb);

            Cookie::set('setok','腾讯帐号设置成功');
            header('location: '.SITE_URL.'/p/weibologin?t=qq');
            exit;
        }

        if ($action=='unbindsina') {
            $weibo->where("uid='$user[user_id]'")->setField(array('sina_uid','sina_token','sina_tsecret','sendtosina'),'0');

            Cookie::set('setok','新浪帐号解绑成功');
            header('location: '.SITE_URL.'/p/weibologin?t=sina');
            exit;
        }

        if ($action=='unbindqq') {
            $weibo->where("uid='$user[user_id]'")->setField(array('qq_uid','qq_token','qq_tsecret','sendtoqq'),'0');

            Cookie::set('setok','腾讯帐号解绑成功');
            header('location: '.SITE_URL.'/p/weibologin?t=qq');
            exit;
        }

        if ($action=='bindsina') {
            if (!$bind['sina_uid']) {
                $sinawb = new WeiboOAuth(WB_AKEY,WB_SKEY,$_SESSION['keys']['oauth_token'],$_SESSION['keys']['oauth_token_secret']);
                $last_key = $sinawb->getAccessToken($_REQUEST['oauth_verifier']);

                if ($last_key['oauth_token']) {
                    $canbind=$weibo->where("sina_uid='$last_key[user_id]'")->find();
                    if ($canbind) {
                        Cookie::set('setok','很抱歉，该新浪帐号已经被其他帐号绑定');
                        header('location: '.SITE_URL.'/p/weibologin?t=sina');
                        exit;
                    }
                    if ($bind) {
                        $weibo->where("uid='$user[user_id]'")->setField(array('sina_uid','sina_token','sina_tsecret'),array($last_key['user_id'],$last_key['oauth_token'],$last_key['oauth_token_secret']));
                    } else {
                        $insert['uid']=$user['user_id'];
                        $insert['sina_uid']=$last_key['user_id'];
                        $insert['sina_token']=$last_key['oauth_token'];
                        $insert['sina_tsecret']=$last_key['oauth_token_secret'];
                        $weibo->add($insert);
                    }
                    Cookie::set('setok','新浪帐号绑定成功');
                } else {
                    Cookie::set('setok','新浪帐号绑定失败');
                }
            }
            header('location: '.SITE_URL.'/p/weibologin?t=sina');
            exit;
        }

        if ($action=='bindqq') {
            if (!$bind['qq_uid']) {
                $qqwb = new MBOpenTOAuth(MB_AKEY,MB_SKEY,$_SESSION['qqkeys']['oauth_token'],$_SESSION['qqkeys']['oauth_token_secret']);
                $last_key = $qqwb->getAccessToken($_REQUEST['oauth_verifier']);

                if ($last_key['oauth_token']) {
                    $canbind=$weibo->where("qq_uid='$last_key[name]'")->find();
                    if ($canbind) {
                        Cookie::set('setok','很抱歉，该腾讯帐号已经被其他帐号绑定');
                        header('location: '.SITE_URL.'/p/weibologin?t=qq');
                        exit;
                    }
                    if ($bind) {
                        $weibo->where("uid='$user[user_id]'")->setField(array('qq_uid','qq_token','qq_tsecret'),array($last_key['name'],$last_key['oauth_token'],$last_key['oauth_token_secret']));
                    } else {
                        $insert['uid']=$user['user_id'];
                        $insert['qq_uid']=$last_key['name'];
                        $insert['qq_token']=$last_key['oauth_token'];
                        $insert['qq_tsecret']=$last_key['oauth_token_secret'];
                        $weibo->add($insert);
                    }
                    Cookie::set('setok','腾讯帐号绑定成功');
                } else {
                    Cookie::set('setok','腾讯帐号绑定失败');
                }
            }
            header('location: '.SITE_URL.'/p/weibologin?t=qq');
            exit;
        }

        $result.='<div class="friends" style="height:400px">';
        if ($type=='sina') {
            $result.='<div class="indexh"><div class="tabon"><a href="'.SITE_URL.'/p/weibologin?t=sina">新浪帐号</a></div><div class="taboff"><a href="'.SITE_URL.'/p/weibologin?t=qq">腾讯帐号</a></div></div>';
        } else {
            $result.='<div class="indexh"><div class="taboff"><a href="'.SITE_URL.'/p/weibologin?t=sina">新浪帐号</a></div><div class="tabon"><a href="'.SITE_URL.'/p/weibologin?t=qq">腾讯帐号</a></div></div>';
        }
        $result.='<div style="ine-height:200%;padding:0 10px;">';
        if ($type=='sina') {
            if ($bind['sina_uid']) {
                $result.='<div style="float:right"><img src="'.ET_URL.'/Plugin/weibologin/images/sinalogo.jpg"></div><div class="clearline"></div>
                <form action="'.SITE_URL.'/p/weibologin" method="post">
                <table style="margin:10px 0 0 10px;font-size:12px;text-indent:10px" width="100%">
                <tr height="60px">
                <td width="150px" bgcolor="#f3f3f3">绑定新浪微博帐号：</td>
                <td bgcolor="#ffffde">'.$bind['sina_uid'].'</td>';
                $result.='</tr><tr height="60px"><td bgcolor="#f3f3f3">是否同步发表微博：</td>';
                if ($bind['sendtosina']) {
                    $result.='<td bgcolor="#ffffde"><input type="radio" name="sinatb" value="1" checked> 是&nbsp;&nbsp;&nbsp; <input type="radio" name="sinatb" value="0"> 否</td>';
                } else {
                    $result.='<td bgcolor="#ffffde"><input type="radio" name="sinatb" value="1"> 是&nbsp;&nbsp;&nbsp; <input type="radio" name="sinatb" value="0" checked> 否</td>';
                }
                $result.='</tr>
                <tr height="120px">
                    <td> </td>
                    <td><input type="hidden" name="act" value="sinasave">
                    <input type="submit" class="button1" value="提交保存">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" class="button3" value="解绑帐号" onclick="if(confirm(\'是否确定要解绑新浪微博帐号？\')){window.location.href=\''.SITE_URL.'/p/weibologin?act=unbindsina\'}">
                    </td>
                </tr>
                </table>
                </from>';
            } else {
                session_start();
                unset($_SESSION['keys']);

                $sinawb = new WeiboOAuth(WB_AKEY,WB_SKEY);
                $keys = $sinawb->getRequestToken();
                $aurl = $sinawb->getAuthorizeURL($keys['oauth_token'],false,SITE_URL.'/p/weibologin?act=bindsina');

                $_SESSION['keys'] = $keys;

                $result.='<div style="text-align:center;width:100%;margin-top:80px;font-size:14px">
                <img src="'.ET_URL.'/Plugin/weibologin/images/sinalogo.jpg"><br/><br/><a href="'.$aurl.'">您还未绑定新浪帐号，点击绑定！</a>
                </div>';
            }
        } else if ($type=='qq') {
            if ($bind['qq_uid']) {
                $result.='<div style="float:right"><img src="'.ET_URL.'/Plugin/weibologin/images/qqlogo.jpg"></div><div class="clearline"></div>
                <form action="'.SITE_URL.'/p/weibologin" method="post">
                <table style="margin:10px 0 0 10px;font-size:12px;text-indent:10px" width="100%">
                <tr height="60px">
                <td width="150px" bgcolor="#f3f3f3">绑定腾讯微博帐号：</td>
                <td bgcolor="#ffffde">'.$bind['qq_uid'].'</td>';
                $result.='</tr><tr height="60px"><td bgcolor="#f3f3f3">是否同步发表微博：</td>';
                if ($bind['sendtoqq']) {
                    $result.='<td bgcolor="#ffffde"><input type="radio" name="qqtb" value="1" checked> 是&nbsp;&nbsp;&nbsp; <input type="radio" name="qqtb" value="0"> 否</td>';
                } else {
                    $result.='<td bgcolor="#ffffde"><input type="radio" name="qqtb" value="1"> 是&nbsp;&nbsp;&nbsp; <input type="radio" name="qqtb" value="0" checked> 否</td>';
                }
                $result.='</tr>
                <tr height="120px">
                    <td> </td>
                    <td><input type="hidden" name="act" value="qqsave">
                    <input type="submit" class="button1" value="提交保存">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" class="button3" value="解绑帐号" onclick="if(confirm(\'是否确定要解绑腾讯微博帐号？\')){window.location.href=\''.SITE_URL.'/p/weibologin?act=unbindqq\'}">
                    </td>
                </tr>
                </table>
                </from>';
            } else {
                session_start();
                unset($_SESSION['qqkeys']);

                $qqwb = new MBOpenTOAuth(MB_AKEY,MB_SKEY);
                $keys = $qqwb->getRequestToken(SITE_URL.'/p/weibologin?act=bindqq');
                $aurl = $qqwb->getAuthorizeURL($keys['oauth_token'],false,'');

                $_SESSION['qqkeys'] = $keys;

                $result.='<div style="text-align:center;width:100%;margin-top:80px;font-size:14px">
                <img src="'.ET_URL.'/Plugin/weibologin/images/qqlogo.jpg"><br/><br/><a href="'.$aurl.'">您还未绑定腾讯帐号，点击绑定！</a>
                </div>';
            }
        }
        $result.='</div></div>';
        return $result;
    }

    public function install() {
        $model=new model();
        $model->query("CREATE TABLE IF NOT EXISTS `".C('DB_PREFIX')."weibobind` (
            `uid` INT( 10 ) NOT NULL ,
            `sina_uid` BIGINT( 20 ) NOT NULL ,
            `sina_token` VARCHAR( 32 ) NOT NULL ,
            `sina_tsecret` VARCHAR( 32 ) NOT NULL ,
            `sendtosina` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '是否发送到新浪微博',
            `qq_uid` VARCHAR( 20 ) NOT NULL ,
            `qq_token` VARCHAR( 32 ) NOT NULL ,
            `qq_tsecret` VARCHAR( 32 ) NOT NULL ,
            `sendtoqq` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '是否发送到腾讯微博',
            PRIMARY KEY ( `uid` )
            ) ENGINE = MYISAM");
        return true;
    }

    public function uninstall() {
        $model=new model();
        $model->query("DROP TABLE IF EXISTS `".C('DB_PREFIX')."weibobind`");
        return true;
    }
}
?>