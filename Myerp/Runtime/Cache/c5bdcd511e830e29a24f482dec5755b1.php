<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>旅游ERP</title>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/yui.css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/deprecated.css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/style.css">

<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/mootools.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/ThinkAjax_GP.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/gaopeng.css">

</head>

<div id="header">
  <div id="companyLogo"> <img src="<?php echo __PUBLIC__;?>/myerp/images/company_logo.png" width="212" height="40" border="0"> </div>
  <div id="globalLinks">
    <ul>
      <li> <a id="employees_link" >员工</a> </li>
      <li> <span>|</span> <a id="training_link">培训</a> </li>
      <li> <span>|</span> <a id="help_link">帮助</a> </li>
      <li> <span>|</span> <a id="about_link">关于</a> </li>
    </ul>
  </div>
  <div class="clear"></div>
  <div class="clear"></div>
  <br>
  <br>
  <div id="moduleList">
    <ul>
      <li class="noBorder">&nbsp;</li>
    </ul>
  </div>
  <div class="clear"></div>
  <div class="line"></div>
</div>
<div id="main">
  <div id="content" class="noLeftColumn">
            <div id="resultdiv" class="resultdiv" style="text-align:center"></div>
            <div id="resultdiv_2" class="resultdiv"></div>
            
    <table style="width:100%">
      <tbody>
        <tr>
          <td><link rel="stylesheet" type="text/css" media="all" href="<?php echo __PUBLIC__;?>/myerp/css/login.css">
            <table cellpadding="0" align="center" width="100%" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td align="center"><div class="loginBoxShadow" style="width: 460px;">
                      <div class="loginBox">
                        <table cellpadding="0" cellspacing="0" border="0" align="center">
                          <tbody>
                            <tr>
                              <td align="left"><b>欢迎来到</b><br>
                                <img src="<?php echo __PUBLIC__;?>/myerp/images/sugar_md_open.png" width="340" height="25" style="margin: 5px 0;"></td>
                            </tr>
                            <tr>
                              <td align="center"><div class="login">
            <form id="form" name="form" method="post">
              <input type="hidden" name="ajax" value="1"> <!--ajax提示-->
                                    <table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
                                      <tbody>
                                        <tr>
                                          <td scope="row" width="1%"></td>
                                          <td scope="row"><span id="post_error" class="error"></span></td>
                                        </tr>
                                        <tr>
                                          <td scope="row" colspan="2" width="100%" style="font-size: 12px; font-weight: normal; padding-bottom: 4px;"> 请输入用户名和密码 
                                        </tr>
                                        <tr>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td scope="row" width="30%">用户名:</td>
                                          <td width="70%"><input type="text" size="35" tabindex="1" id="user_name" name="loginname" ></td>
                                        </tr>
                                        <tr>
                                          <td scope="row">密码:</td>
                                          <td width="30%"><input type="password" size="26" tabindex="2" id="user_password" name="password" value=""></td>
                                        </tr>
                                        <tr>
                                          <td scope="row">记住我:</td>
                                          <td width="30%">
                                            <input tabindex="3" type="checkbox" name="rememberMe" id="rememberMe" value="on" class="checkbox"/>&nbsp;&nbsp;下次自动登录
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td>&nbsp;</td>
                                          <td><input title="登录" class="button primary" type="button" tabindex="4" id="login_button" name="Login" value="登录" onclick="dologin();">
                                            <br>
                                            &nbsp;</td>
                                        </tr>
                                      </tbody>
                                    </table>
            </form>
                                </div></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div></td>
                </tr>
              </tbody>
            </table>
            <br>
            <br></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="clear"></div>
</div>
<div id="bottomLinks"> </div>
<div id="footer"> 旅游ERP<br>
  <div id="copyright">这里是版权信息</div>
</div>
</body>
</html>


<script>

function dologin(){
	ThinkAjax.sendForm('form','<?php echo SITE_INDEX;?>Index/dologin',doComplete,'resultdiv');
}
function doComplete(data,status){
	if(status == 1){
			window.location.href='<?php echo SITE_INDEX;?>Chanpin';
	}
}
</script>