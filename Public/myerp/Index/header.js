var timer;
ThinkAjax.updateTip = '<IMG SRC="'+SITE_PUBLIC+'/myerp/images/loading2.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="loading..." align="absmiddle"> 数据处理中...';

function AutoScroll(obj){
	jQuery(obj).find("span:first").animate({marginTop:"-22px"},500,function(){jQuery(this).css({marginTop:"0px"}).find("a:first").appendTo(this);});
}

jQuery(document).ready(function(){
	timer = setInterval('AutoScroll("#alertNewsView")',5000);
	getNews();
	getNewsAll("index.php?s=/Message/getNewsAll");
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
		getNewsAll("index.php?s=/Message/getNewsAll");
		jQuery('#dialog').dialog('open');
		return false;
	});
	//hover states on the static widgets
	jQuery('#dialog_link, ul#icons li').hover(
		function() { jQuery(this).addClass('ui-state-hover'); },
		function() { jQuery(this).removeClass('ui-state-hover'); }
	);
	
	// Dialog
	jQuery('#dialog_password').dialog({
		autoOpen: false,
		width: 300,
		buttons: {
			"确认": function() {
				if(CheckForm('form_password','resultdiv_2')){
					if(jQuery('#re_password').val() == jQuery('#new_password').val())
						ThinkAjax.sendForm('form_password',SITE_INDEX+'Index/dopostchangeuserinfo/type/密码','','resultdiv');
					else	
						ajaxalert("新入密码与重复密码不一致！！");
				}
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog Link
	jQuery('#password_create').click(function(){
		jQuery('#dialog_password').dialog('open');
		return false;
	});
	// Dialog
	jQuery('#dialog_userinfo').dialog({
		autoOpen: false,
		width: 300,
		buttons: {
			"确认": function() {
				if(CheckForm('form_userinfo','resultdiv_2')){
						ThinkAjax.sendForm('form_userinfo',SITE_INDEX+'Index/dopostchangeuserinfo/type/信息','','resultdiv');
				}
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog Link
	jQuery('#userinfo_create').click(function(){
		jQuery('#dialog_userinfo').dialog('open');
		return false;
	});
	
	
	
});

function getNews(){
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Message/getNews",
		data:	"",
		success:	function(msg){
				ThinkAjax.myAjaxResponse(msg,'',getnews_after);
		}
	});
}
  
function getNewsAll(posturl){
	jQuery.ajax({
		type:	"POST",
		url:	ET_URL+posturl,
		data:	"",
		success:	function(msg){
				ThinkAjax.myAjaxResponse(msg,'',getnewsall_after);
		}
	});
}

function cleardingdan(){
	getNewsAll("index.php?s=/Xiaoshou/cleardingdan");
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
		url:	SITE_INDEX+"Message/delNews"+it,
		data:	"id="+id,
		success:	function(msg){
				ThinkAjax.myAjaxResponse(msg,'',getnews_after);
		}
	});
	getNews();
	getNewsAll("index.php?s=/Message/getNewsAll");
}
			
function logout(){
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Index/logout",
		data:	"",
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',todo_logout);
		}
	});
}
function todo_logout(data,status){
	if(status == 1){
			window.location.href=SITE_INDEX+'Index';
	}
}

function headsearch()
{
	title = jQuery("#query_string").val();
	window.location = SITE_INDEX+'Chanpin/index/title/'+title;
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

function ajaxalert(title){
	document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+title+'</div>';
	jQuery("#resultdiv_2").show("fast"); 
	this.intval = window.setTimeout(function (){
		document.getElementById('resultdiv_2').style.display='none';
		document.getElementById('resultdiv_2').innerHTML='';
		},3000);
}

function shenhe_back(dataID,datatype){
	ThinkAjax.myloading('resultdiv');
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/shenheback",
		data:	"dataID="+dataID+"&datatype="+datatype,
		success:function(msg){
			scroll(0,0);
			ThinkAjax.myAjaxResponse(msg,'resultdiv');
		}
	});
}
function shenheshow_doit(chanpinID,obj){
   if(jQuery("#shenhediv").is(":visible")==true){ 
	  jQuery('#shenhediv').hide();
	  return ;
   }
    getshenhemessage("index.php?s=/Message/getshenhemessage/chanpinID/"+chanpinID);
	objleft = getPosLeft(obj) - 370;
	objtop = getPosTop(obj) + 20;
	jQuery('#shenhediv').css({top:objtop , left:objleft });
	jQuery('#shenhediv').show();
}
function getshenhemessage(posturl){
	jQuery.ajax({
		type:	"POST",
		url:	ET_URL+posturl,
		data:	"",
		success:	function(msg){
				ThinkAjax.myAjaxResponse(msg,'',getshenhemessage_after);
		}
	});
}

function getshenhemessage_after(data,status)
{
	if(status == 1){
		jQuery("#shenhe_box").html(data);
	}
}
function div_close(id){
	jQuery('#'+id+'').hide();
}


function showuserinfo(){
		jQuery.ajax({
			type:	"POST",
			url:	SITE_INDEX+"Index/getmyuserinfo",
			data:	"",
			success:function(msg){
				ThinkAjax.myAjaxResponse(msg,'',arraymessage_after);
			}
		});
}



