<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>系统发生错误</title>
<script language="javascript" src="<?php echo __PUBLIC__;?>/myerp/jquery-1.7.2.min.js" ></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/mootools.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/ThinkAjax_GP.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="Generator" content="EditPlus">
<style>
body{
	font-family: 'Microsoft Yahei', Verdana, arial, sans-serif;
	font-size:14px;
}
a{text-decoration:none;color:#174B73;}
a:hover{ text-decoration:none;color:#FF6600;}
h2{
	border-bottom:1px solid #DDD;
	padding:8px 0;
    font-size:25px;
}
.title{
	margin:4px 0;
	color:#F60;
	font-weight:bold;
}
.message,#trace{
	padding:1em;
	border:solid 1px #000;
	margin:10px 0;
	background:#FFD;
	line-height:150%;
}
.message{
	background:#FFD;
	color:#2E2E2E;
		border:1px solid #E0E0E0;
}
#trace{
	background:#E7F7FF;
	border:1px solid #E0E0E0;
	color:#535353;
}
.notice{
    padding:10px;
	margin:5px;
	color:#666;
	background:#FCFCFC;
	border:1px solid #E0E0E0;
}
.red{
	color:red;
	font-weight:bold;
}
</style>
</head>
<body>
<div class="notice">
<h2>系统发生错误 </h2>
<div>您可以选择 [ <a href="javascript:history.go(0)">重试</a> ] [ <a href="javascript:history.back()">返回</a> ] [ <a href="javascript:logout()">注销</a> ] 或者 [ <a href="<?php echo SITE_INDEX;?>">回到首页</a> ]</div>
<p class="title">[ 错误信息 ]</p>
<p class="message">请联系管理员</p>
</div>
<div style="color:#FF3300;margin:5pt;font-family:Verdana" align="center"> ThinkPHP <sup style="color:gray;font-size:9pt">3.0</sup><span style="color:silver"> { Fast &amp; Simple OOP PHP Framework } -- [ WE CAN DO IT JUST THINK ]</span>
</div>

</body></html>

<script>
function logout(){
	jQuery.ajax({
		type:	"POST",
		url:	"<?php echo SITE_INDEX;?>Index/logout",
		data:	"",
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',todo_logout);
		}
	});
}
function todo_logout(data,status){
	if(status == 1){
			window.location.href='<?php echo SITE_INDEX;?>Index';
	}
}
</script>