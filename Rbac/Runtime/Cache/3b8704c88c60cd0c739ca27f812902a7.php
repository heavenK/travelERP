<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>『ThinkPHP管理平台』By ThinkPHP <?php echo (THINK_VERSION); ?></title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/rbac/Css/style.css" />
<script type="text/javascript" src="__PUBLIC__/rbac/Js/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/rbac/Js/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/rbac/Js/mootools.js"></script>
<script type="text/javascript" src="__PUBLIC__/rbac/Js/Ajax/ThinkAjax.js"></script>
<script type="text/javascript" src="__PUBLIC__/rbac/Js/Form/CheckForm.js"></script>
<script type="text/javascript" src="__PUBLIC__/rbac/Js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/rbac/Js/Util/ImageLoader.js"></script>
<script language="JavaScript">
<!--
//指定当前组模块URL地址 
var URL = '__URL__';
var APP	 =	 '__APP__';
var PUBLIC = '__PUBLIC__';
ThinkAjax.image = [	 '__PUBLIC__/rbac/Images/loading2.gif', '__PUBLIC__/rbac/Images/ok.gif','__PUBLIC__/rbac/Images/update.gif' ]
ImageLoader.add("__PUBLIC__/rbac/Images/bgline.gif","__PUBLIC__/rbac/Images/bgcolor.gif","__PUBLIC__/rbac/Images/titlebg.gif");
ImageLoader.startLoad();
//-->
</script>
</head>

<body onload="loadBar(0)">
<div id="loader" >页面加载中...</div>
<div class="main" >
<div class="content">
<TABLE id="checkList" class="list" cellpadding=0 cellspacing=0 >
<tr><td height="5" colspan="5" class="topTd" ></td></tr>
<TR class="row" ><th colspan="3" class="space">系统信息</th></tr>
<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><TR class="row" onmouseover="over()" onmouseout="out()" onclick="change()" ><TD width="15%"><?php echo ($key); ?></TD><TD><?php echo ($v); ?></TD></TR><?php endforeach; endif; else: echo "" ;endif; ?>
<tr><td height="5" colspan="5" class="bottomTd"></td></tr>
</TABLE>
</div>
</div>
<!-- 主页面结束 -->