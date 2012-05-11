<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>视频选择</title><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/style (2).css"><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/yui (2).css"><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/deprecated (2).css"><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/colors.sugar.css"><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/fonts.normal.css"><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/gaopeng.css"><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/sugar_grp1_yui.js"></script><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/sugar_grp1.js"></script><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/style.js"></script><script src="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery-1.4.2.js" language="javascript"></script><script>function confirmAct()
{
	if(confirm('你确定要删除吗？'))
	{
		return true;
	}
	return false;
}
function showmysearchdiv(s)
{
		var divRili = document.getElementById('mysearchdiv');
		var divRili_1 = document.getElementById('show_link_insideview');
		var divRili_2 = document.getElementById('hide_link_insideview');
	if(s == 1){
		divRili.style.display = ''
		divRili_1.style.display = 'none'
		divRili_2.style.display = ''
	}
	if(s == 2){
		divRili.style.display = 'none'
		divRili_1.style.display = ''
		divRili_2.style.display = 'none'
	}
}
</script></head><body><input type="hidden" id="own" value="<?php echo ($own); ?>" /><div style="overflow-x:hidden"><div class="moduleTitle" style="margin-bottom:10px;"><h2 style="margin-top:10px;">数据字典：视频</h2><div style="float:left; margin-left:50px; margin-top:6px;"><span style="display: none;" id="show_link_insideview"><a href="javascript:void(0);" onclick="showmysearchdiv(1)"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/insideview_collapsed.png"></a></span><span style="" id="hide_link_insideview"><a href="javascript:void(0);" onclick="showmysearchdiv(2)"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/insideview_expanded.png"></a></span></div><span style="margin-top:10px;"><img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a><a href="javascript:void(0);" onclick="alert('暂无');" class="utilsLink"> 帮助 </a></span></div><div id="mysearchdiv"><ul id="searchTabs" class="tablist"><li style="margin-right:1px;"><a id="searchtab_1" class="current" href="javascript:selectTabCSS('Calls|basic_search');" onclick="showsearch(1)">基本查找</a></li></ul><div class="search_form" id="searchdiv_1" style="margin-bottom:0px;"><div class="edit view search "><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td scope="row" nowrap="nowrap"> 名称 </td><td nowrap="nowrap"><input type="text" name="title" id="title"></td><td scope="row" nowrap="nowrap"> 编号 </td><td nowrap="nowrap"><input type="text" name="bianhao" id="bianhao"></td><td scope="row" nowrap="nowrap"> 团期 </td><td nowrap="nowrap"><input type="text" onfocus="WdatePicker()" id="chufariqi" name="chufariqi" value="<?php echo ($chufariqi); ?>" ></tbody></table></div><input title="查找" class="button" type="button" value=" 查找 " onclick="dosearch();"><input title="清除" class="button" type="button" value=" 清除 " onclick="clearsearch();"></div></div><table cellpadding="0" cellspacing="0" width="100%" class="list view"><tbody><tr class="pagination"><td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable"><tbody><tr><td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                            <input class="button" type="button" id="send" onclick="sendValue();" value="确认推送"/><input class="button" type="button" id="send" onclick="<?php echo SITE_ADMIN;?>Basedata/add_video" value="添加"/></td><td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?></td></tr></tbody></table></td></tr><tr height="20"><th scope="col" nowrap="nowrap"></th><th scope="col" nowrap="nowrap"><div> 标题 </div></th><th scope="col" nowrap="nowrap"><div> 简介 </div></th><th scope="col" nowrap="nowrap"><div> 创建时间 </div></th><th scope="col" nowrap="nowrap"><div> 操作 </div></th></tr><?php $i=0;foreach($movies as $movie){ $i++; ?><tr height="30" class="evenListRowS1"><td scope="row" align="left" valign="top"><input type="radio" id="<?php echo ($movie[id]); ?>" name="checkboxs" value="<?php echo ($movie[title]); ?>"></td><td scope="row" align="left" valign="top"><?php echo ($movie[title]); ?></td><td scope="row" align="left" valign="top"><span  style=" width:300px; height:16px; overflow:hidden; float:left"><?php echo ($movie[description]); ?></span></td><td scope="row" align="left" valign="top"><?php echo (date("Y/m/d",$movie[pubdate])); ?></td><td scope="row" align="left" valign="top"><input class="button" type="button" id="send" onclick="<?php echo SITE_ADMIN;?>Basedata/edit_video/id/<?php echo ($movie[id]); ?>" value="修改"/><input class="button" type="button" id="send" onclick="return confirmAct();" onclick="<?php echo SITE_ADMIN;?>Basedata/delete_video/id/<?php echo ($movie[id]); ?>" value="删除"/></td></tr><?php } ?><tr class="pagination"><td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable"><tbody><tr><td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                            <input class="button" type="button" id="send" onclick="sendValue();" value="确认推送"/><input class="button" type="button" id="send" onclick="<?php echo SITE_ADMIN;?>Basedata/add_video" value="添加"/></td><td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?></td></tr></tbody></table></td></tr></tbody></table></div></body></html><script language="javascript">$("document").ready(function(){
	var arr = $("#own").attr("value").split(',');
	for(var i in arr){
		v = arr[i]
		$("input[name='checkboxs'][value=" + v + "]").attr("checked",true);
	}
})

function sendValue(){
	$("input[name='checkboxs']:checked").each(function(i){
		if (i == '0') {
			str = $(this).attr('value');
			ids = $(this).attr('id');
		}
		else {
			str += ',' + $(this).attr('value');
			ids += ',' + $(this).attr('id');
		}
	})
	
	window.parent.document.getElementById("shipin").value=str;
	window.parent.document.getElementById("Videos_id").value=ids;
}
</script>