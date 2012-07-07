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
<script type="text/javascript" src="rbac.Js.Util.JTree"></script>
<!-- 主体内容  -->
<div class="content" >
<div class="title"> 应用授权 [ <a href="__URL__">返回</a> ]</div>
<!--  功能组区域  -->
<script language="JavaScript">
<!--
function saveAccess(){
ThinkAjax.sendForm('form1','__URL__/setApp/');
}
//-->
</script>
<div id="result" class="result none"></div>
<script type="text/javascript" src="/Public/rbac/Js/Form/MultiSelect.js"></script>
<form method=post id="form1">
<table class="select" style="width:265px" align="center">
<tr><td height="5" colspan="3" class="topTd" ></td></tr>
<tr><th class="tCenter">应用授权 | <a href="__URL__/module/groupId/<?php echo ($_GET['groupId']); ?>">模块授权</a> | <a href="__URL__/action/groupId/<?php echo ($_GET['groupId']); ?>">操作授权</a>
</th></tr>
<tr><Td class="tRight">当前组：<select id="" name="groupId" onchange="location.href = '?groupId='+this.options[this.selectedIndex].value;" ondblclick="" class="medium" ><option value="" >选择组</option><?php  foreach($groupList as $key=>$val) { if(!empty($selectGroupId) && ($selectGroupId == $key || in_array($key,$selectGroupId))) { ?><option selected="selected" value="<?php echo $key ?>"><?php echo $val ?></option><?php }else { ?><option value="<?php echo $key ?>"><?php echo $val ?></option><?php } } ?></select>
</Td></tr>
<tr><td >
<select id="groupAppId" name="groupAppId[]" ondblclick="" onchange="" multiple="multiple" class="multiSelect" size="15" ><?php  foreach($appList as $key=>$val) { if(!empty($groupAppList) && ($groupAppList == $key || in_array($key,$groupAppList))) { ?><option selected="selected" value="<?php echo $key ?>"><?php echo $val ?></option><?php }else { ?><option value="<?php echo $key ?>"><?php echo $val ?></option><?php } } ?></select>
</td>
</tr>
<tr>
<td  class="row tCenter" >
<input type="button" onclick="allSelect()" value="全 选" class="submit  ">&nbsp;
<input type="button" onclick="InverSelect()" value="反 选" class="submit  ">&nbsp;
<input type="button" onclick="allUnSelect()" value="全 否" class="submit ">&nbsp;
<input type="button" onclick="saveAccess()" value="保 存" class="submit  ">&nbsp;
<input type="hidden" name="groupId" VALUE="<?php echo ($_GET['id']); ?>" >
<input type="hidden" name="module" value="Node">
<input type="hidden" name="ajax" VALUE="1">
</td>
</tr>
<tr>
<td height="5" class="bottomTd" >
</td>
</tr>
</table>
</form>

</div>
<!-- 主体内容结束 -->
</div>
<!-- 主页面结束 -->