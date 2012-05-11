<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>旅游ERP</title><link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.css" rel="stylesheet" type="text/css" /><script src="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery-1.4.2.js" language="javascript"></script><script src="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.min.js" language="javascript"></script><script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script><script>var names = [
	 <?php foreach($kehu_all as $kehu){ ?>			  { name: "<?php echo ($kehu[realname]); ?>(<?php echo ($kehu['user_name']); ?>)", to: "<?php echo ($kehu['user_name']); ?>" },
	 <?php } ?> ];
$(function() {
		 $('#user_name').autocomplete(names, {
			 max: 20,    //列表里的条目数
			 minChars: 0,    //自动完成激活之前填入的最小字符
			 width: 400,     //提示的宽度，溢出隐藏
			 scrollHeight: 300,   //提示的高度，溢出显示滚动条
			 matchContains: true,    //包含匹配，就是data参数里的数据，是否只要包含文本框里的数据就显示
			 autoFill: false,    //自动填充
			 formatItem: function(row, i, max) {
				 return i + '/' + max + ':"' + row.name + '"[' + row.to + ']';
			 },
			 formatMatch: function(row, i, max) {
				 return row.name + row.to;
			 },
			 formatResult: function(row) {
				 return row.to;
			 }
		 }).result(function(event, row, formatted) {
		 });
	 });
</script></head><body><?php A("Chanpin")->showheader(); ?><div id="main"><?php A("Chanpin")->left_fabu(); ?><div id="content" style="margin-left:170px;"><div class="moduleTitle" style="margin-bottom:10px;"><h2 style="margin-top:10px;">旅游产品：产品发布</h2><div style="float:left; margin-left:50px; margin-top:6px;"><span style="display: none;" id="show_link_insideview"><a href="javascript:void(0);" onclick="showmysearchdiv(1)"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/insideview_collapsed.png"></a></span><span style="" id="hide_link_insideview"><a href="javascript:void(0);" onclick="showmysearchdiv(2)"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/insideview_expanded.png"></a></span></div><span style="margin-top:10px;"><img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a><a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a></span></div><div id="mysearchdiv"><ul id="searchTabs" class="tablist"><li style="margin-right:1px;"><a id="searchtab_1" class="current" href="javascript:selectTabCSS('Calls|basic_search');" onclick="showsearch(1)">基本查找</a></li><li><a id="searchtab_2" href="javascript:selectTabCSS('Calls|advanced_search');" onclick="showsearch(2)">高级查找</a></li></ul><div class="search_form" id="searchdiv_1" style="margin-bottom:0px;"><div class="edit view search "><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td scope="row" nowrap="nowrap"> 名称 </td><td nowrap="nowrap"><input type="text" name="title" id="title"></td><td scope="row" nowrap="nowrap"> 编号 </td><td nowrap="nowrap"><input type="text" name="bianhao" id="bianhao"></td><td scope="row" nowrap="nowrap"> 团期 </td><td nowrap="nowrap"><input type="text" onfocus="WdatePicker()" id="chufariqi" name="chufariqi" value="<?php echo ($chufariqi); ?>" ></tbody></table></div><input tabindex="2" title="查找" class="button" type="button" value=" 查找 " onclick="dosearch();">&nbsp;
                      <input tabindex="2" title="清除" class="button" type="button" value=" 清除 " onclick="clearsearch();"></div><div class="search_form" id="searchdiv_2" style="display:none;margin-bottom:0px;"><div class="edit view search "><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td scope="row" nowrap="nowrap"> 名称 </td><td nowrap="nowrap"><input type="text" name="title" id="title"></td><td scope="row" nowrap="nowrap"> 团期 </td><td nowrap="nowrap"><input type="text" onfocus="WdatePicker()" id="chufariqi" name="chufariqi" value="<?php echo ($chufariqi); ?>"><span>--</span><input type="text" onfocus="WdatePicker()" id="jiezhiriqi" name="jiezhiriqi" value="<?php echo ($jiezhiriqi); ?>"></td><td scope="row" nowrap="nowrap"> 员工 </td><td nowrap="nowrap"><input type="text" id="user_name" value="<?php echo ($user_name); ?>"/></td><td scope="row" nowrap="nowrap"> 状态 </td><td nowrap="nowrap"><select name="zhuangtai" id="zhuangtai"><?php if($zhuangtai){ ?><option value="<?php echo ($zhuangtai); ?>"><?php echo ($zhuangtai); ?></option><option disabled="disabled">-----------------</option><?php } ?><option value="">全部</option><option value="准备">准备</option><option value="等待审核">等待审核</option><option value="审核不通过">审核不通过</option><option value="报名">报名</option><option value="截止">截止</option></select></td></tr><tr><td scope="row" nowrap="nowrap"> 始发地 </td><td nowrap="nowrap"><input type="text" id="chufadi" value="<?php echo ($chufadi); ?>"/></td><td scope="row" nowrap="nowrap"> 目的地 </td><td nowrap="nowrap"><input type="text" id="mudidi" value="<?php echo ($mudidi); ?>"/></td></tr></tbody></table></div><input tabindex="2" title="查找" class="button" type="button" value=" 查找 " onclick="dosearch();">&nbsp;
                      <input tabindex="2" title="清除" class="button" type="button" value=" 清除 " onclick="clearsearch();"></div><div><table width="100%" cellpadding="0" cellspacing="0" class="formHeader h3Row" style="margin-top:0px;"><tbody><tr><td nowrap=""><h3><span>查询：</span></h3></td></tr></tbody></table></div></div><div id="selectitem" style=" display:none; position:absolute;"><table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass"><tbody><tr><td valign="top" class="olOptionsFgClass"><div class="olFontClass"><a href="javascript:void(0)" onclick="myCheckBoxSelect()" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,'yes');" class="menuItem" style="width: 150px">选择全部</a><a href="javascript:void(0)" onclick="myCheckBoxSelect('o','false')" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,'yes');" class="menuItem" style="width: 150px">取消选择</a></div></td></tr></tbody></table></td></tr></tbody></table></div><div id="dateitem" style=" display:none; position:absolute;"><table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass"><tbody><tr><td valign="top" class="olOptionsFgClass"><div class="olFontClass" id="thedate"></div></td></tr></tbody></table></td></tr></tbody></table></div><div id="messageitem" style=" display:none; position:absolute;"><table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass"><tbody><tr><td valign="top" class="olOptionsFgClass"><div class="olFontClass" id="themessage"></div></td></tr></tbody></table></td></tr></tbody></table></div><table cellpadding="0" cellspacing="0" width="100%" class="list view"><tbody><tr class="pagination"><td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable"><tbody><tr><td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                            <input class="button" type="button" value=" 复制 "><input class="button" type="button" value=" 发布 "><input class="button" type="button" value=" 删除 "><input class="button" type="button" value=" 锁定 "><input class="button" type="button" value=" 解锁 "><input class="button" type="button" value=" 截止 "></td><td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?></td></tr></tbody></table></td></tr><tr height="20"><th scope="col" nowrap="nowrap"><input type="checkbox" class="checkbox" value="" id="checkboxall" onclick="myCheckBoxSelect(this)"></th><th scope="col" nowrap="nowrap"><div> 产品名称 </div></th><th scope="col" nowrap="nowrap"><div> 编号 </div></th><th scope="col" nowrap="nowrap"><div> 出团日期 </div></th><th scope="col" nowrap="nowrap"><div> 发布人 </div></th><th scope="col" nowrap="nowrap"><div> 创建时间 </div></th><th scope="col" nowrap="nowrap"><div> 单位 </div></th><th scope="col" nowrap="nowrap"><div> 状态 </div></th><th scope="col" nowrap="nowrap"><div> 锁定 </div></th><th scope="col" nowrap="nowrap"><div> 网站发布 </div></th><th scope="col" nowrap="nowrap"><div> 轨迹 </div></th></tr><?php $i = -1; foreach($chanpin_list as $v){ $i++; ?><tr height="30" class="evenListRowS1"><td scope="row" align="left" valign="top"><input value="<?php echo ($v['xianluID']); ?>" id="chanpinitem<?php echo ($i); ?>" type="checkbox" name="itemlist[]" class="checkbox"></td><td scope="row" align="left" valign="top" style="min-width:300px;"><a href="<?php echo SITE_ADMIN;?>Chanpin/editlvyouxianlu/xianluID/<?php echo ($v['xianluID']); ?>"><?php echo ($v['title']); ?></a></td><td scope="row" align="left" valign="top"><?php echo ($v['ext']['bianhao']); ?></td><td scope="row" align="center" valign="top"><img name="aa" onclick="showdate('<?php echo Fi_ConvertChars($v['ext'][chutuanriqi]) ?>');showbox(this,'dateitem')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" /></td><td scope="row" align="left" valign="top"><?php echo ($v['user_name']); ?></td><td scope="row" align="left" valign="top"><?php echo date('Y/m/d H:i',$v['time']); ?></td><td scope="row" align="left" valign="top" style="min-width:50px;"><?php echo ($v['departmentName']); ?></td><td scope="row" align="left" valign="top" style="min-width:50px;"><?php echo ($v['status']); ?></td><td scope="row" align="left" valign="top" style="min-width:50px;"><?php echo ($v['islock']); ?></td><td scope="row" align="left" valign="top" style="min-width:50px;"><?php echo ($v['ispub']); ?></td><td scope="row" align="center" valign="top"><img onclick="showmessage(this,'<?php echo ($v['chanpinID']); ?>','线路','操作记录');showbox(this,'messageitem','r')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" /></td></tr><?php } ?><tr class="pagination"><td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable"><tbody><tr><td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="#">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a><input name="Delete" class="button" type="button" value="删除" /><input class="button" type="button" value="导出"></td><td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?></td></tr></tbody></table></td></tr></tbody></table></div></div><includeCA file="Chanpin:footer" /></body></html><script language="javascript">function myCheckBoxSelect(o,st)
{
    var id = 'chanpinitem';
    var i = 0;
    for(;;)
    {
        id = 'chanpinitem' + i;
        var c = document.getElementById(id);
		if(st)
			var s = false;
		else
			if(o)
			var s = o.checked;
			else
			var s = true;
        if(c)
            c.checked = s;
        else
            break;
        i ++;
    }
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

function showsearch(s)
{
	if(s == 1){
		var divRili = document.getElementById('searchdiv_1'); 
		divRili.style.display = '';			
		divRili = document.getElementById('searchdiv_2'); 
		divRili.style.display = 'none';	
		$('#searchtab_1').addClass('current');
		$('#searchtab_2').removeClass('current');
	}
	if(s == 2){
		var divRili = document.getElementById('searchdiv_2'); 
		divRili.style.display = '';			
		divRili = document.getElementById('searchdiv_1'); 
		divRili.style.display = 'none';	
		$('#searchtab_2').addClass('current');
		$('#searchtab_1').removeClass('current');
	}
}


function showbox(obj,divname,pos)
{
	objleft = getPosLeft(obj) + 0;
	objtop = getPosTop(obj) + 20;
	if(pos == 'r')
		$("#"+divname).css({top:objtop , right:20 });
	else
		$("#"+divname).css({top:objtop , left:objleft });
	var divRili = document.getElementById(divname); 
	if(divRili.style.display=='')
		divRili.style.display = 'none';
	else 
		divRili.style.display = '';			
}
function showdate(datelist)
{
	datelist=datelist.replace(/'/g,"");
	datelist=datelist.split(";");
	 var str = '';
	 for(var i =0; i<datelist.length;i++){
		 str += '<a href="#" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,\'yes\');" class="menuItem" style="width: 150px">'+datelist[i]+'</a>';
	 }
	$("#thedate").empty();
	$("#thedate").append(str);
}
function showmessage(obj,chanpinID)
{
	$.ajax({
		type:	"POST",
		url:	"<?php echo SITE_INDEX;?>Chanpin/message",
		data:	"chanpinID="+chanpinID,
		success:	function(msg){
				  if(msg != 'false' && msg){
					  var msg = eval('(' + msg + ')');
					  var str = '';
					  for(var i =0; i<msg.length;i++){
						  str += '<a href="#" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,\'yes\');" class="menuItem" style="width: 300px">'+msg[i].title+'<br>'+getLocalTime(msg[i].time)+'</a>';
					  }
				  }
				  else
						  str += '<a href="#" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,\'yes\');" class="menuItem" style="width: 300px">暂无数据</a>';
				  $("#themessage").empty();
				  $("#themessage").append(str);
			}
		});
}
function getPosLeft(obj)
{
    var l = obj.offsetLeft;
    while(obj = obj.offsetParent)
    {
        l += obj.offsetLeft;
    }
    return l;
}
function getPosTop(obj)
{
    var l = obj.offsetTop;
    while(obj = obj.offsetParent)
    {
        l += obj.offsetTop;
    }
    return l;
}

function getLocalTime(nS) {  
	//return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' '); 
	return new Date(parseInt(nS) * 1000).toLocaleString().substr(0,17);
    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
}
</script>