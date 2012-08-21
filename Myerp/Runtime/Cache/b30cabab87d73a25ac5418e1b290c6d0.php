<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($nowDir['title']); echo ($datatitle); ?></title>
<script language="javascript" src="<?php echo __PUBLIC__;?>/myerp/jquery-1.7.2.min.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/style (2).css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/yui (2).css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/deprecated (2).css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/colors.sugar.css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/fonts.normal.css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/gaopeng.css">
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/sugar_grp1_yui.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/sugar_grp1.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/style.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/mootools.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/ThinkAjax_GP.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script>
<link type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-ui-1.8.20.custom/css/ui-lightness/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/jquery-ui-1.8.20.custom/js/jquery-ui-1.8.20.custom.min.js"></script>
<script>
var timer;
ThinkAjax.updateTip = '<IMG SRC="<?php echo __PUBLIC__;?>/myerp/images/loading2.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="loading..." align="absmiddle"> 数据处理中...';

function AutoScroll(obj){
	jQuery(obj).find("span:first").animate({marginTop:"-22px"},500,function(){jQuery(this).css({marginTop:"0px"}).find("a:first").appendTo(this);});
}

jQuery(document).ready(function(){
	timer = setInterval('AutoScroll("#alertNewsView")',5000);
	getNews();
	getNewsAll("Index.php?s=/Message/getNewsAll");
	window.setInterval(getNews,50000);
	jQuery("#alertitem").mouseover(function(){
		clearTimeout(timer);
	});
	jQuery("#alertitem").mouseout(function () {
		timer = setInterval('AutoScroll("#alertNewsView")',5000);
	});
	
	//清空占位过期订单
	window.setInterval(cleardingdan,50000);
	
	// Dialog
	jQuery('#dialog').dialog({
		autoOpen: false,
		width: 1000,
		buttons: {
			"关闭": function() {
				jQuery(this).dialog("close");
			},
			"清空": function() {
				del_alert('','全部');
				//jQuery(this).dialog("close");
			}
		}
	});
	// Dialog Link
	jQuery('#dialog_link').click(function(){
		getNewsAll("Index.php?s=/Message/getNewsAll");
		jQuery('#dialog').dialog('open');
		return false;
	});
	//hover states on the static widgets
	jQuery('#dialog_link, ul#icons li').hover(
		function() { jQuery(this).addClass('ui-state-hover'); },
		function() { jQuery(this).removeClass('ui-state-hover'); }
	);
	
});

function getNews(){
	jQuery.ajax({
		type:	"POST",
		url:	"<?php echo SITE_INDEX;?>Message/getNews",
		data:	"",
		success:	function(msg){
				ThinkAjax.myAjaxResponse(msg,'',getnews_after);
		}
	});
}
  
function getNewsAll(posturl){
	jQuery.ajax({
		type:	"POST",
		url:	"<?php echo ET_URL;?>"+posturl,
		data:	"",
		success:	function(msg){
				ThinkAjax.myAjaxResponse(msg,'',getnewsall_after);
		}
	});
}

function cleardingdan(){
	getNewsAll("Index.php?s=/Xiaoshou/cleardingdan");
}
  
function getnews_after(data,status)
{
	if(status == 1){
		jQuery("#alertNewsView").show();
		jQuery("#alertitem").html(data);
	}
	else
		jQuery("#alertNewsView").hide();
}

function getnewsall_after(data,status)
{
	if(status == 1){
		jQuery("#dialog").html(data);
	}
}

function del_alert(id,dowhat)
{
	it = '';
	if(dowhat == '全部')
		it = "/dowhat/all";
	jQuery.ajax({
		type:	"POST",
		url:	"<?php echo SITE_INDEX;?>Message/delNews"+it,
		data:	"id="+id,
		success:	function(msg){
				ThinkAjax.myAjaxResponse(msg,'',getnews_after);
		}
	});
	getNews();
	getNewsAll("Index.php?s=/Message/getNewsAll");
}
			
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
</head>

<body>
<div id="header">
  <div id="companyLogo" style="padding:4px 15px 10px;"> <img src="<?php echo __PUBLIC__;?>/myerp/images/company_logo.png" width="212" height="40" alt="Company Logo" border="0"> </div>
  <div id="globalLinks" style="padding:18px 0 0 10px;">
    <ul>
      <li> <a href="#">我的帐户</a> </li>
      <li> <span>|</span> <a href="#">员工</a> </li>
      <li> <span>|</span> <a href="#">系统管理</a> </li>
      <li> <span>|</span> <a href="#">培训</a> </li>
      <li> <span>|</span> <a href="#">关于</a> </li>
    </ul>
  </div>
  <div id="welcome" style="border:none; padding:18px 0 0 10px;"> 欢迎, <strong>
    <?php echo $this->tVar['user']['title']; ?>
    </strong> [ <a href="javascript:logout()" class="utilsLink">注销</a> ] </div>
  <div id="search" style="padding:18px 0 0 10px; border:none ">
    <form name="">
      <img id="unified_search_advanced_img" src="<?php echo __PUBLIC__;?>/myerp/images/searchMore.gif" alt="查找">&nbsp;
      <input type="text" name="query_string" id="query_string" size="20" value="">
      &nbsp;
      <input style="margin-top:-2px;" type="submit" class="button" value="查找">
    </form>
  </div>
  <div id="sitemapLink" style="padding:18px 0 0 10px; border:none "> 站点地图 <img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png"> </div>
  <div class="clear"></div>
  <div id="moduleList">
    <ul>
      <li class="noBorder">&nbsp;</li>
      <?php if($navposition == '销售'){ ?>
      <li> <span class="currentTabLeft">&nbsp;</span><span class="currentTab"> <a href="<?php echo SITE_INDEX;?>Xiaoshou" id="grouptab_3">&nbsp;销售&nbsp;</a> </span><span class="currentTabRight">&nbsp;</span> </li>
      <?php }else{ ?>
      <li> <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"> <a href="<?php echo SITE_INDEX;?>Xiaoshou" id="grouptab_3">&nbsp;销售&nbsp;</a> </span><span class="notCurrentTabRight">&nbsp;</span> </li>
      <?php } ?>
      <li class="noBorder">&nbsp;</li>
      <?php if($navposition == '旅游产品'){ ?>
      <li> <span class="currentTabLeft">&nbsp;</span><span class="currentTab"> <a href="<?php echo SITE_INDEX;?>Chanpin" id="grouptab_0">&nbsp;旅游产品&nbsp;</a> </span><span class="currentTabRight">&nbsp;</span> </li>
      <?php }else{ ?>
      <li> <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"> <a href="<?php echo SITE_INDEX;?>Chanpin" id="grouptab_0">&nbsp;旅游产品&nbsp;</a> </span><span class="notCurrentTabRight">&nbsp;</span> </li>
      <?php } ?>
      <li class="noBorder">&nbsp;</li>
      <?php if($navposition == '产品地接'){ ?>
      <li> <span class="currentTabLeft">&nbsp;</span><span class="currentTab"> <a href="<?php echo SITE_INDEX;?>Dijie" id="grouptab_5">&nbsp;产品地接&nbsp;</a> </span><span class="currentTabRight">&nbsp;</span> </li>
      <?php }else{ ?>
      <li> <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"> <a href="<?php echo SITE_INDEX;?>Dijie" id="grouptab_5">&nbsp;产品地接&nbsp;</a> </span><span class="notCurrentTabRight">&nbsp;</span> </li>
      <?php } ?>
      <li class="noBorder">&nbsp;</li>
      <?php if($navposition == '财务管理'){ ?>
      <li> <span class="currentTabLeft">&nbsp;</span><span class="currentTab"> <a href="#" id="grouptab_1">&nbsp;财务管理&nbsp;</a> </span><span class="currentTabRight">&nbsp;</span> </li>
      <?php }else{ ?>
      <li> <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"> <a href="#" id="grouptab_1">&nbsp;财务管理&nbsp;</a> </span><span class="notCurrentTabRight">&nbsp;</span> </li>
      <?php } ?>
      <li class="noBorder">&nbsp;</li>
      <?php if($navposition == '系统管理'){ ?>
      <li> <span class="currentTabLeft">&nbsp;</span><span class="currentTab"> <a href="<?php echo SITE_INDEX;?>SetSystem" id="grouptab_2">&nbsp;系统管理&nbsp;</a> </span><span class="currentTabRight">&nbsp;</span> </li>
      <?php }else{ ?>
      <li> <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"> <a href="#" id="grouptab_2">&nbsp;系统管理&nbsp;</a> </span><span class="notCurrentTabRight">&nbsp;</span> </li>
      <?php } ?>
      <li class="noBorder">&nbsp;</li>
      <?php if($navposition == '信息'){ ?>
      <li> <span class="currentTabLeft">&nbsp;</span><span class="currentTab"> <a href="#" id="grouptab_4">&nbsp;信息&nbsp;</a> </span><span class="currentTabRight">&nbsp;</span> </li>
      <?php }else{ ?>
      <li> <span class="notCurrentTabLeft">&nbsp;</span><span class="notCurrentTab"> <a href="#" id="grouptab_4">&nbsp;信息&nbsp;</a> </span><span class="notCurrentTabRight">&nbsp;</span> </li>
      <?php } ?>
    </ul>
  </div>
  <div class="clear"></div>
  <div id="subModuleList"> <span id="moduleLink_0" 
    <?php if($navposition == '旅游产品'){ ?>
    class="selected"
    <?php } ?>
    >
    <ul>
      <li class="subTabMore" style="font-size:12px;"> <a href="<?php echo SITE_INDEX;?>Chanpin">线路发布及控管&gt;&gt;</a>
        <ul class="cssmenu">
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/近郊游/guojing/国内">近郊游 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/长线游/guojing/国内">长线游 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/自由人/guojing/国内">国内自由人 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/包团/guojing/国内">国内包团 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/韩国/guojing/境外">韩国 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/日本/guojing/境外">日本 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/台湾/guojing/境外">台湾 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/港澳/guojing/境外">港澳 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/东南亚/guojing/境外">东南亚 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/欧美岛/guojing/境外">欧美岛 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/自由人/guojing/境外">境外自由人 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/包团/guojing/境外">境外包团 </a> </li>
        </ul>
      </li>
      <li> <a href="<?php echo SITE_INDEX;?>Chanpin/shenhe">产品审核</a> </li>
      <li> <a href="<?php echo SITE_INDEX;?>Chanpin/kongguan">产品控管</a> </li>
      <li> <a href="<?php echo SITE_INDEX;?>Xiaoshou/dingdanlist">订单控管</a> </li>
      <li> <a href="#">客户管理</a> </li>
      <li> <a href="#">数据字典</a> </li>
      <li> <a href="#">统计</a> </li>
    </ul>
    </span> <span id="moduleLink_1" 
    <?php if($navposition == '财务管理'){ ?>
    class="selected"
    <?php } ?>
    >
    <ul>
      <li> <a href="#">报表项审核</a> </li>
      <li> <a href="#">报表审核管理</a> </li>
      <li> <a href="#">签证</a> </li>
      <li> <a href="#">单项服务</a> </li>
      <li> <a href="#">统计</a> </li>
    </ul>
    </span> <span id="moduleLink_2" 
    <?php if($navposition == '系统管理'){ ?>
    class="selected"
    <?php } ?>
    >
    <ul>
      <li> <a href="#">用户</a> </li>
      <li> <a href="#">系统工具</a> </li>
      <li> <a href="<?php echo SITE_INDEX;?>SetSystem/setting">系统设置</a> </li>
      <li> <a href="#">站内信息</a> </li>
      <li> <a href="#">产品平移</a> </li>
    </ul>
    </span> <span id="moduleLink_3" 
    <?php if($navposition == '销售'){ ?>
    class="selected"
    <?php } ?>
    >
    <ul>
      <li> <a href="<?php echo SITE_INDEX;?>Xiaoshou">线路产品</a> </li>
      <li> <a href="<?php echo SITE_INDEX;?>Xiaoshou/dingdanlist">订单控管</a> </li>
    </ul>
    </span> 
    
    <span id="moduleLink_4" 
    <?php if($navposition == '信息'){ ?>
    class="selected"
    <?php } ?>
    >
    <ul>
      <li> <a href="#">公告</a> </li>
      <li> <a href="#">排团表</a> </li>
      <li> <a href="#">系统提示</a> </li>
    </ul>
    </span> 
    
    <span id="moduleLink_5" 
    <?php if($navposition == '产品地接'){ ?>
    class="selected"
    <?php } ?>
    >
    <ul>
      <li class="subTabMore" style="font-size:12px;"> <a href="<?php echo SITE_INDEX;?>Dijie">团队创建与控管&gt;&gt;</a>
        <ul class="cssmenu">
          <li> <a href="<?php echo SITE_INDEX;?>Dijie/fabu/guojing/国内/kind/国内">国内团队 </a> </li>
          <li> <a href="<?php echo SITE_INDEX;?>Dijie/fabu/guojing/境外/kind/日本">境外团队（日本） </a> </li>
        </ul>
      </li>
      <li> <a href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu">单项服务</a> </li>
    </ul>
    </span> 
    
    </div>
  <div class="clear"></div>
  <div class="line"></div>
  <div class="headerList" id="alertNewsView" style="height:18px; overflow:hidden"> <b style="white-space:nowrap;float:left;">即时消息:&nbsp;&nbsp;</b> <b style="white-space:nowrap;float:right;"> <a href="#" id="dialog_link" class="ui-state-default ui-corner-all" style="padding:0px;">
    <div class="ui-icon ui-icon-newwin" style="float:left"></div>
    显示全部</a> </b> <span style="float:left; width:70%" id="alertitem"> </span> </div>
</div>
<div id="dialog" title="提示消息" style="background:#FFF"> </div>