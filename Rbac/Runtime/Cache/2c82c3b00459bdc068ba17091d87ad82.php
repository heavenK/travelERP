<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel='stylesheet' type='text/css' href='__PUBLIC__/rbac/Css/style.css'>
<style>
html {
	overflow-x : hidden;
}
</style>
<base target="main" />
</head>

<body >
<div class="menu" id="menu">
  <table cellspacing="0" cellpadding="0" class="list shadow">
    <tbody>
      <tr>
        <td height="5" class="topTd" colspan="7"></td>
      </tr>
      <tr class="row">
        <th class="tCenter space"><img width="16" border="0" align="absmiddle" height="16" alt="" src="__PUBLIC__/rbac/Images/home.gif">应用中心</th>
      </tr>
      <tr class="row ">
        <td><div style="margin:0px 5px"><img width="9" border="0" align="absmiddle" height="9" alt="" src="/Rbac/Tpl/Public/images/comment.gif"><a id="3" href="__APP__/Node/index/">节点管理</a></div></td>
      </tr>
      <tr class="row ">
        <td><div style="margin:0px 5px"><img width="9" border="0" align="absmiddle" height="9" alt="" src="/Rbac/Tpl/Public/images/comment.gif"><a id="4" href="__APP__/Role/index/">角色管理</a></div></td>
      </tr>
      <tr class="row ">
        <td><div style="margin:0px 5px"><img width="9" border="0" align="absmiddle" height="9" alt="" src="/Rbac/Tpl/Public/images/comment.gif"><a id="5" href="__APP__/User/index/">后台用户</a></div></td>
      </tr>
      <tr>
        <td height="5" class="bottomTd" colspan="7"></td>
      </tr>
    </tbody>
  </table>
</div>
<script language="JavaScript">
            <!--
            function refreshMainFrame(url){
                parent.main.document.location = url;
            }
            if (document.anchors[0]){
                refreshMainFrame(document.anchors[0].href);
            }
            //-->
        </script>
</body>
</html>