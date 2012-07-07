<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<div id="main" class="main" >
<div class="content">
<div class="title">编辑<?php if(($vo["level"]) == "1"): ?>应用<?php endif; if(($vo["level"]) == "2"): ?>模块<?php endif; if(($vo["level"]) == "3"): ?>操作<?php endif; ?> [ <a href="__URL__">返回列表</a> ]</div>
<form method='post'  id="form1" >
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" ><?php if(($vo["level"]) == "1"): ?>应用<?php endif; if(($vo["level"]) == "2"): ?>模块<?php endif; if(($vo["level"]) == "3"): ?>操作<?php endif; ?>名：</td>
	<td class="tLeft" ><input type="text" class="medium bLeftRequire" check='Require' warning="<?php if(($vo["level"]) == "1"): ?>应用<?php endif; if(($vo["level"]) == "2"): ?>模块<?php endif; if(($vo["level"]) == "3"): ?>操作<?php endif; ?>名称不能为空,且不能含有空格"  name="name" value="<?php echo ($vo["name"]); ?>"></td>
</tr>
<tr>
	<td class="tRight" >显示名：</td>
	<td class="tLeft" ><input type="text" class="medium bLeftRequire" check='Require' warning="显示名称必须" name="title" value="<?php echo ($vo["title"]); ?>"></td>
</tr>
<tr>
	<td class="tRight" >分 组：</td>
	<td class="tLeft" >
	<SELECT class="medium bLeft" name="group_id">
	<option value="">未分组</option>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><option value="<?php echo ($group["id"]); ?>" <?php if(($group["id"]) == $vo['group_id']): ?>selected<?php endif; ?>><?php echo ($group["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</SELECT>
	</td>
</tr>
<tr>
	<td class="tRight">状态：</td>
	<td class="tLeft"><SELECT class="small bLeft"  name="status">
	<option <?php if(($vo["status"]) == "1"): ?>selected<?php endif; ?> value="1">启用</option>
	<option <?php if(($vo["status"]) == "0"): ?>selected<?php endif; ?> value="0">禁用</option>
	</SELECT></td>
</tr>
<tr>
	<td class="tRight tTop">描 述：</td>
	<td class="tLeft"><TEXTAREA class="large bLeft" name="remark"  rows="5" cols="57"><?php echo ($vo["remark"]); ?></textarea></td>
</tr>
<tr>
	<td></td>
	<td class="center"><div style="width:85%;margin:5px"><input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>" >
	<input type="hidden" name="ajax" value="1">
	<input type="hidden" name="pid" value="<?php echo ($vo["pid"]); ?>">
	<div class="impBtn fLeft"><input type="button" value="保存" onclick="sendForm('form1','__URL__/update/','tips')" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" onclick="history.back(-1)" class="reset imgButton" value="取消" ></div>
	</div></td>
</tr>
</table>
</form>
</div>
</div>