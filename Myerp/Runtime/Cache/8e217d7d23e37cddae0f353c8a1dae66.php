<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>旅游ERP</title><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/style (2).css"><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/yui (2).css"><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/deprecated (2).css"><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/colors.sugar.css" id="current_color_style"><link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/fonts.normal.css" id="current_font_style"><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/sugar_grp1_yui.js"></script><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/sugar_grp1.js"></script><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/style.js"></script><script src="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery-1.4.2.js" language="javascript"></script><script src="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.min.js" language="javascript"></script><link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.css" rel="stylesheet" type="text/css" /><script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script><script>var names = [
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
</script></head><body><div id="header"><div id="companyLogo"><img src="<?php echo __PUBLIC__;?>/myerp/images/company_logo.png" width="212" height="40" alt="Company Logo" border="0"></div><div id="globalLinks"><ul><li><a href="#">我的帐户</a></li><li><span>|</span><a href="#">员工</a></li><li><span>|</span><a href="#">系统管理</a></li><li><span>|</span><a href="#">培训</a></li><li><span>|</span><a href="#">关于</a></li></ul></div><div id="welcome"> 欢迎, <strong>admin</strong> [ <a href="#" class="utilsLink">注销</a> ] </div><div class="clear"></div><div id="search"><form name=""><img id="unified_search_advanced_img" src="<?php echo __PUBLIC__;?>/myerp/images/searchMore.gif" alt="查找">&nbsp;
      <input type="text" name="query_string" id="query_string" size="20" value="">      &nbsp;
      <input type="submit" class="button" value="查找"></form><br><div id="unified_search_advanced_div"></div></div><div id="sitemapLink"><span id="sitemapLinkSpan"> 站点地图 <img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png"></span></div><span id="sm_holder"></span><div class="clear"></div><div id="moduleList"><ul><li class="noBorder">&nbsp;</li><li><span class="currentTabLeft">&nbsp;</span><span class="currentTab"><a href="#" id="grouptab_0">&nbsp;旅游产品&nbsp;</a></span><span class="currentTabRight">&nbsp;</span></li><li><span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"><a href="#" id="grouptab_1">&nbsp;财务管理&nbsp;</a></span><span class="notCurrentTabRight">&nbsp;</span></li><li><span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"><a href="#" id="grouptab_2">&nbsp;系统管理&nbsp;</a></span><span class="notCurrentTabRight">&nbsp;</span></li><li><span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"><a href="#" id="grouptab_3">&nbsp;销售&nbsp;</a></span><span class="notCurrentTabRight">&nbsp;</span></li><li><span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"><a href="#" id="grouptab_4">&nbsp;信息&nbsp;</a></span><span class="notCurrentTabRight">&nbsp;</span></li></ul></div><div class="clear"></div><div id="subModuleList"><span id="moduleLink_0"  class="selected"><ul><li><a href="#">发布产品</a></li><li><a href="#">产品审核</a></li><li><a href="#">产品控管</a></li><li><a href="#">订单控管</a></li><li><a href="#">客户管理</a></li><li><a href="#">数据字典</a></li><li><a href="#">统计</a></li></ul></span><span id="moduleLink_1"><ul><li><a href="#">报表项审核</a></li><li><a href="#">报表审核管理</a></li><li><a href="#">签证</a></li><li><a href="#">单项服务</a></li><li><a href="#">统计</a></li></ul></span><span id="moduleLink_2"><ul><li><a href="#">用户</a></li><li><a href="#">系统工具</a></li><li><a href="#">系统设置</a></li><li><a href="#">站内信息</a></li><li><a href="#">产品平移</a></li></ul></span><span id="moduleLink_3"><ul><li><a href="#">线路产品</a></li><li><a href="#">机票</a></li><li><a href="#">酒店</a></li><li><a href="#">门票</a></li></ul></span><span id="moduleLink_4"><ul><li><a href="#">公告</a></li><li><a href="#">排团表</a></li><li><a href="#">系统提示</a></li></ul></span></div><div class="clear"></div><div class="line"></div><div id="lastView" class="headerList"><b style="white-space:nowrap;">最近查看:&nbsp;&nbsp;</b><span> 无 </span></div></div><div id="main"><div id="leftColumn" style="margin-top:7px; width:147px;"><ul id="searchTabs" class="tablist"><li style="margin-right:1px;"><a id="shownavtab_1" class="current" href="javascript:selectTabCSS('Calls|basic_search');" onmouseover="shownavtab(1)">&nbsp;准备&nbsp;</a></li><li style="margin-right:1px;"><a id="shownavtab_2" href="javascript:selectTabCSS('Calls|advanced_search');" onmouseover="shownavtab(2)">&nbsp;报名&nbsp;</a></li><li><a id="shownavtab_3" href="javascript:selectTabCSS('Calls|advanced_search');" onmouseover="shownavtab(3)">&nbsp;截止&nbsp;</a></li></ul><div id="navtab_1" class="leftList"><h3><span>准备中的产品</span></h3><h3><span>国内/拼团</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>近郊游</span></a></li><li><a href="#">&nbsp;<span>长线游</span></a></li></ul><h3><span>国内/散客</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>近郊游</span></a></li><li><a href="#">&nbsp;<span>长线游</span></a></li><li><a href="#">&nbsp;<span>|---我爱中华</span></a></li><li><a href="#">&nbsp;<span>|---自由人</span></a></li><li><a href="#">&nbsp;<span>|---印象之旅</span></a></li><li><a href="#">&nbsp;<span>|---爱之旅</span></a></li><li><a href="#">&nbsp;<span>|---夏之旅</span></a></li><li><a href="#">&nbsp;<span>|---成都海悦</span></a></li><li><a href="#">&nbsp;<span>|---通话假期</span></a></li><li><a href="#">&nbsp;<span>|---西部国旅</span></a></li></ul><h3><span>国内</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li><li><a href="#">&nbsp;<span>机票</span></a></li><li><a href="#">&nbsp;<span>酒店</span></a></li></ul><h3><span>境外</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>海岛游</span></a></li><li><a href="#">&nbsp;<span>出境游</span></a></li><li><a href="#">&nbsp;<span>欧美澳非</span></a></li><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li></ul></div><div id="navtab_2" class="leftList" style="display:none"><h3><span>报名中的产品</span></h3><h3><span>国内/拼团</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>近郊游</span></a></li><li><a href="#">&nbsp;<span>长线游</span></a></li></ul><h3><span>国内/散客</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>近郊游</span></a></li><li><a href="#">&nbsp;<span>长线游</span></a></li><li><a href="#">&nbsp;<span>|---我爱中华</span></a></li><li><a href="#">&nbsp;<span>|---自由人</span></a></li><li><a href="#">&nbsp;<span>|---印象之旅</span></a></li><li><a href="#">&nbsp;<span>|---爱之旅</span></a></li><li><a href="#">&nbsp;<span>|---夏之旅</span></a></li><li><a href="#">&nbsp;<span>|---成都海悦</span></a></li><li><a href="#">&nbsp;<span>|---通话假期</span></a></li><li><a href="#">&nbsp;<span>|---西部国旅</span></a></li></ul><h3><span>国内</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li><li><a href="#">&nbsp;<span>机票</span></a></li><li><a href="#">&nbsp;<span>酒店</span></a></li></ul><h3><span>境外</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>海岛游</span></a></li><li><a href="#">&nbsp;<span>出境游</span></a></li><li><a href="#">&nbsp;<span>欧美澳非</span></a></li><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li></ul></div><div id="navtab_3" class="leftList" style="display:none"><h3><span>已截止的产品</span></h3><h3><span>国内/拼团</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>近郊游</span></a></li><li><a href="#">&nbsp;<span>长线游</span></a></li></ul><h3><span>国内/散客</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>近郊游</span></a></li><li><a href="#">&nbsp;<span>长线游</span></a></li><li><a href="#">&nbsp;<span>|---我爱中华</span></a></li><li><a href="#">&nbsp;<span>|---自由人</span></a></li><li><a href="#">&nbsp;<span>|---印象之旅</span></a></li><li><a href="#">&nbsp;<span>|---爱之旅</span></a></li><li><a href="#">&nbsp;<span>|---夏之旅</span></a></li><li><a href="#">&nbsp;<span>|---成都海悦</span></a></li><li><a href="#">&nbsp;<span>|---通话假期</span></a></li><li><a href="#">&nbsp;<span>|---西部国旅</span></a></li></ul><h3><span>国内</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li><li><a href="#">&nbsp;<span>机票</span></a></li><li><a href="#">&nbsp;<span>酒店</span></a></li></ul><h3><span>境外</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>海岛游</span></a></li><li><a href="#">&nbsp;<span>出境游</span></a></li><li><a href="#">&nbsp;<span>欧美澳非</span></a></li><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li></ul></div></div><div id="content" style="margin-left:170px;"><table><tbody><tr><td><div ><div class="moduleTitle" style="margin-bottom:0px;"><h2>旅游产品：产品发布</h2><span><img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a><a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink" target="_blank"> 帮助 </a></span></div><ul id="searchTabs" class="tablist"><li style="margin-right:1px;"><a id="searchtab_1" class="current" href="javascript:selectTabCSS('Calls|basic_search');" onclick="showsearch(1)">基本查找</a></li><li><a id="searchtab_2" href="javascript:selectTabCSS('Calls|advanced_search');" onclick="showsearch(2)">高级查找</a></li></ul><div class="search_form" id="searchdiv_1" style="margin-bottom:0px;"><div class="edit view search "><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td scope="row" nowrap="nowrap"> 名称 </td><td nowrap="nowrap"><input type="text" name="title" id="title"></td><td scope="row" nowrap="nowrap"> 编号 </td><td nowrap="nowrap"><input type="text" name="bianhao" id="bianhao"></td><td scope="row" nowrap="nowrap"> 团期 </td><td nowrap="nowrap"><input type="text" onfocus="WdatePicker()" id="chufariqi" name="chufariqi" value="<?php echo ($chufariqi); ?>" ></tbody></table></div><input tabindex="2" title="查找" class="button" type="button" value=" 查找 " onclick="dosearch();">&nbsp;
                      <input tabindex="2" title="清除" class="button" type="button" value=" 清除 " onclick="clearsearch();"></div><div class="search_form" id="searchdiv_2" style="display:none;margin-bottom:0px;"><div class="edit view search "><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td scope="row" nowrap="nowrap"> 名称 </td><td nowrap="nowrap"><input type="text" name="title" id="title"></td><td scope="row" nowrap="nowrap"> 团期 </td><td nowrap="nowrap"><input type="text" onfocus="WdatePicker()" id="chufariqi" name="chufariqi" value="<?php echo ($chufariqi); ?>"><span>--</span><input type="text" onfocus="WdatePicker()" id="jiezhiriqi" name="jiezhiriqi" value="<?php echo ($jiezhiriqi); ?>"></td><td scope="row" nowrap="nowrap"> 员工 </td><td nowrap="nowrap"><input type="text" id="user_name" value="<?php echo ($user_name); ?>"/></td><td scope="row" nowrap="nowrap"> 状态 </td><td nowrap="nowrap"><select name="zhuangtai" id="zhuangtai"><?php if($zhuangtai){ ?><option value="<?php echo ($zhuangtai); ?>"><?php echo ($zhuangtai); ?></option><option disabled="disabled">-----------------</option><?php } ?><option value="">全部</option><option value="准备">准备</option><option value="等待审核">等待审核</option><option value="审核不通过">审核不通过</option><option value="报名">报名</option><option value="截止">截止</option></select></td></tr><tr><td scope="row" nowrap="nowrap"> 始发地 </td><td nowrap="nowrap"><input type="text" id="chufadi" value="<?php echo ($chufadi); ?>"/></td><td scope="row" nowrap="nowrap"> 目的地 </td><td nowrap="nowrap"><input type="text" id="mudidi" value="<?php echo ($mudidi); ?>"/></td></tr></tbody></table></div><input tabindex="2" title="查找" class="button" type="button" value=" 查找 " onclick="dosearch();">&nbsp;
                      <input tabindex="2" title="清除" class="button" type="button" value=" 清除 " onclick="clearsearch();"></div><div><table width="100%" cellpadding="0" cellspacing="0" class="formHeader h3Row" style="margin-top:0px;"><tbody><tr><td nowrap=""><h3><span>查询：</span></h3></td></tr></tbody></table></div></div><div id="selectitem" style=" display:none; position:absolute;"><table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass"><tbody><tr><td valign="top" class="olOptionsFgClass"><div class="olFontClass"><a href="javascript:void(0)" onclick="myCheckBoxSelect()" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,'yes');" class="menuItem" style="width: 150px">选择全部</a><a href="javascript:void(0)" onclick="myCheckBoxSelect('o','false')" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,'yes');" class="menuItem" style="width: 150px">取消选择</a></div></td></tr></tbody></table></td></tr></tbody></table></div><div id="dateitem" style=" display:none; position:absolute;"><table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass"><tbody><tr><td valign="top" class="olOptionsFgClass"><div class="olFontClass" id="thedate"></div></td></tr></tbody></table></td></tr></tbody></table></div><div id="messageitem" style=" display:none; position:absolute;"><table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass"><tbody><tr><td valign="top" class="olOptionsFgClass"><div class="olFontClass" id="themessage"></div></td></tr></tbody></table></td></tr></tbody></table></div><table cellpadding="0" cellspacing="0" width="100%" class="list view"><tbody><tr class="pagination"><td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable"><tbody><tr><td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                            <input class="button" type="button" value=" 复制 "><input class="button" type="button" value=" 发布 "><input class="button" type="button" value=" 删除 "><input class="button" type="button" value=" 锁定 "><input class="button" type="button" value=" 解锁 "><input class="button" type="button" value=" 截止 "></td><td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?></td></tr></tbody></table></td></tr><tr height="20"><th scope="col" nowrap="nowrap"><input type="checkbox" class="checkbox" value="" id="checkboxall" onclick="myCheckBoxSelect(this)"></th><th scope="col" nowrap="nowrap"><div> 产品名称 </div></th><th scope="col" nowrap="nowrap"><div> 编号 </div></th><th scope="col" nowrap="nowrap"><div> 出团日期 </div></th><th scope="col" nowrap="nowrap"><div> 发布人 </div></th><th scope="col" nowrap="nowrap"><div> 创建时间 </div></th><th scope="col" nowrap="nowrap"><div> 单位 </div></th><th scope="col" nowrap="nowrap"><div> 状态 </div></th><th scope="col" nowrap="nowrap"><div> 锁定 </div></th><th scope="col" nowrap="nowrap"><div> 网站发布 </div></th><th scope="col" nowrap="nowrap"><div> 轨迹 </div></th></tr><?php $i = -1; foreach($chanpin_list as $v){ $i++; ?><tr height="20" class="evenListRowS1"><td width="1%" class="nowrap"><input value="<?php echo ($v['xianluID']); ?>" id="chanpinitem<?php echo ($i); ?>" type="checkbox" name="itemlist[]" class="checkbox"></td><td scope="row" align="left" valign="top"><a href="<?php echo SITE_ADMIN;?>Chanpin/editlvyouxianlu/xianluID/<?php echo ($v['xianluID']); ?>"><?php echo ($v['title']); ?></a></td><td scope="row" align="left" valign="top"><?php echo ($v['ext']['bianhao']); ?></td><td scope="row" align="center" valign="top"><img name="aa" onclick="showdate('<?php echo Fi_ConvertChars($v['ext'][chutuanriqi]) ?>');showbox(this,'dateitem')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" /></td><td scope="row" align="left" valign="top"><?php echo ($v['user_name']); ?></td><td scope="row" align="left" valign="top"><?php echo date('Y/m/d H:i',$v['time']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['departmentName']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['islock']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['ispub']); ?></td><td scope="row" align="center" valign="top"><img onclick="showmessage(this,'<?php echo ($v['chanpinID']); ?>','线路','操作记录');showbox(this,'messageitem','r')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" /></td></tr><?php } ?><tr class="pagination"><td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable"><tbody><tr><td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="#">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a><input name="Delete" class="button" type="button" value="删除" /><input class="button" type="button" value="导出"></td><td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></div></div><div id="footer"> 服务器响应时间: 0.29 秒。<br><div id="copyright"> © 2004-2010 <img style="margin-top: 2px" width="106" height="23" src="<?php echo __PUBLIC__;?>/myerp/images/poweredby_sugarcrm.png" alt="Powered By SugarCRM"></div></div></body></html><script language="javascript">function myCheckBoxSelect(o,st)
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

function shownavtab(s)
{
	if(s == 1){
		var divRili = document.getElementById('navtab_1'); 
		divRili.style.display = '';			
		divRili = document.getElementById('navtab_2'); 
		divRili.style.display = 'none';	
		divRili = document.getElementById('navtab_3'); 
		divRili.style.display = 'none';	
		$('#shownavtab_1').addClass('current');
		$('#shownavtab_2').removeClass('current');
		$('#shownavtab_3').removeClass('current');
	}
	if(s == 2){
		var divRili = document.getElementById('navtab_2'); 
		divRili.style.display = '';			
		divRili = document.getElementById('navtab_1'); 
		divRili.style.display = 'none';	
		divRili = document.getElementById('navtab_3'); 
		divRili.style.display = 'none';	
		$('#shownavtab_2').addClass('current');
		$('#shownavtab_1').removeClass('current');
		$('#shownavtab_3').removeClass('current');
	}
	if(s == 3){
		var divRili = document.getElementById('navtab_3'); 
		divRili.style.display = '';			
		divRili = document.getElementById('navtab_1'); 
		divRili.style.display = 'none';	
		divRili = document.getElementById('navtab_2'); 
		divRili.style.display = 'none';	
		$('#shownavtab_3').addClass('current');
		$('#shownavtab_1').removeClass('current');
		$('#shownavtab_2').removeClass('current');
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