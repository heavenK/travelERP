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
<!-- 菜单区域  -->

<!-- 主页面开始 -->
<div id="main" class="main" >

<!-- 主体内容  -->
<div class="content" >
<div class="title">后台用户列表</div>
<!--  功能操作区域  -->
<div class="operate" >
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="add" value="新增" onclick="add()" class="add imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="edit" value="编辑" onclick="edit()" class="edit imgButton"></div>
<div class="impBtn hMargin fLeft shadow" ><input type="button" id="" name="delete" value="删除" onclick="del()" class="delete imgButton"></div>
<!-- 查询区域 -->
<div class="fRig">
<form method='post' action="__URL__">
<div class="fLeft"><span id="key"><input type="text" name="account" title="帐号查询" class="medium" ></span></div>
<div class="impBtn hMargin fLeft shadow" ><input type="submit" id="" name="search" value="查询" onclick="" class="search imgButton"></div>
</div>
<!-- 高级查询区域 -->
<div  id="searchM" class=" none search cBoth" >
</div>
</form>
</div>
<!-- 功能操作区域结束 -->

<!-- 列表显示区域  -->
<div class="list" >

<table id="checkList" class="list" cellpadding=0 cellspacing=0 >
	<tr>
		<td height="5" colspan="7" class="topTd" ></td>
    </tr>
    <tr class="row" >
        <th width="10%"><a href="javascript:sortBy('user_id','1','index')" title="按照编号升序排列 ">编号</a></th>
        <th><a href="javascript:sortBy('user_name','1','index')" title="按照组名升序排列 ">用户名</a></th>
        <th >操作</th>
    </tr>
    <?php foreach($list as $vo){ ?>
    
    <tr class="row" onmouseover="over(event)" onmouseout="out(event)" onclick="change(event)" >
        <td><?php echo ($vo[id]); ?></td>
        <td><?php echo ($vo[account]); ?></td>
        <td> <a href="__URL__/role/id/<?php echo ($vo[id]); ?>">所属组列表</a>&nbsp;</td>
    </tr>
    <?php } ?>
    <tr>
        <td height="5" colspan="7" class="bottomTd"></td>
    </tr>
</table>

</div>
<!--  分页显示区域 -->
<div class="page"><?php echo ($page); ?></div>
<!-- 列表显示区域结束 -->
</div>
<!-- 主体内容结束 -->
</div>
<!-- 主页面结束 -->