<?php if (!defined('THINK_PATH')) exit();?><?php A("Chanpin")->showheader(); ?><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckeditor/ckeditor.js"></script><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckfinder/ckfinder.js"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Base.js"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/prototype.js"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/mootools.js"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Ajax/ThinkAjax.js"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script><div id="main"><?php A("Chanpin")->left_fabu(); ?><div id="content" style="margin-left:170px;"><div class="moduleTitle" style="margin-bottom:10px;"><h2 style="margin-top:10px;"><?php echo ($nav); ?></h2><span style="margin-top:10px;"><img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a><a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a></span></div><div id="mysearchdiv" style="margin-bottom:10px;"><ul id="searchTabs" class="tablist tablist_2"><li style="margin-right:1px;"><a <?php if($pos == '基本信息'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/fabu/chanpinID/<?php echo ($chanpinID); ?>">基本信息</a></li><li style="margin-right:1px;"><a <?php if($pos == '子团管理'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/zituan/chanpinID/<?php echo ($chanpinID); ?>">子团管理</a></li><li style="margin-right:1px;"><a <?php if($pos == '行程'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/xingcheng/chanpinID/<?php echo ($chanpinID); ?>">&nbsp;&nbsp;行&nbsp;&nbsp;程&nbsp;&nbsp;</a></li><li style="margin-right:1px;"><a <?php if($pos == '成本售价'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/chengbenshoujia/chanpinID/<?php echo ($chanpinID); ?>">成本售价</a></li></ul></div><div id="resultdiv" class="resultdiv"></div><div id="resultdiv_2" class="resultdiv"></div><form name="form" method="post" id="form" action="<?php echo SITE_INDEX;?>Chanpin/dopostfabu/"><?php if($xianlu[chanpinID]){ ?><input name="chanpinID" id="chanpinID" type="hidden" value="<?php echo ($xianlu['chanpinID']); ?>" ><?php }else{ ?><input name="guojing" type="hidden" id="guojing" value="<?php echo ($guojing); ?>" ><input name="kind" type="hidden" id="kind" value="<?php echo ($kind); ?>" ><input name="xianlutype" id="xianlutype" type="hidden" value="<?php echo ($xianlutype); ?>"><?php } ?><input type="hidden" name="ajax" value="1"><!--ajax提示--><div class="buttons"><input type="button" value="审核失败记录" name="button" class="button primary" style="float:right"><input type="submit" value="提交审核" name="button" class="button primary" style="float:right"><input type="button" value="保存" name="button" class="button primary" onclick="if(CheckForm('form','resultdiv_2')) save();"></div><table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view"><tbody><tr><th align="left" colspan="8"><h4>基本信息（必填）</h4></th></tr><tr><td valign="top" scope="row" style="min-width:100px;"> 标题: </td><td valign="top"><input name="title" type="text" id="title" value="<?php echo trim($xianlu['title']) ?>" style="width:200px;" check="^\S+$" warning="账号不能为空,且不能含有空格" ></td><td valign="top" scope="row"> 报名截止: </td><td valign="top" scope="row"><span>出团前</span><input style="width:50px; margin:0 4px 0 4px;" name="baomingjiezhi" type="text" value="<?php if ($xianlu['baomingjiezhi']) echo $xianlu['baomingjiezhi']; else echo 1 ?>" id="baomingjiezhi" ><span>天</span></td></tr><tr><td valign="top" scope="row" style="min-width:100px;"> 始发地: </td><td valign="top"><select name="chufashengfen_id" id="chufashengfen_id" onchange="change_pos_go()" class="button"><option value="0">请选择</option></select><select name="chufachengshi_id" id="chufachengshi_id" onchange="chufachengshi_gaopeng()" class="button"><option value="0">请选择</option></select><input type="hidden" name="chufashengfen" id="chufashengfen"/><input type="hidden" name="chufachengshi" id="chufachengshi"/></td><td valign="top" scope="row" style="min-width:100px;"> 目的地: </td><td valign="top"><select name="guojing" id="guojing" class="button"><option value="国内">国内</option></select><select name="daqu_id" id="pos1" onchange="change_pos('1')" class="button"><option value="0">请选择</option><option value="1">华北地区</option><option value="2">东北地区</option><option value="3">华东地区</option><option value="4">中南地区</option><option value="5">西南地区</option><option value="6">西北地区</option><option value="7">港澳地区</option></select><select name="shengfen_id" id="pos2" onchange="change_pos('2')" class="button"><option value="0">请选择</option></select><select name="chengshi_id" id="pos3" onchange="change_pos('3')" class="button"><option value="0">请选择</option></select><input type="hidden" name="daqu" id="pos_name1"/><input type="hidden" name="shengfen" id="pos_name2"/><input type="hidden" name="chengshi" id="pos_name3"/></td></tr><tr><td valign="top" scope="row"> 计划人数: </td><td valign="top"><input type="text" id="renshu" name="renshu" style="width:50px; margin:0 4px 0 4px;" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" value="<?php echo ($xianlu['renshu']); ?>" ><span style=" margin:0 10px 0 4px">人</span><input id="ischild" type="checkbox" name="ischild" value="1" <?php if($xianlu[ischild] == 1){ ?> checked="checked"<?php } ?> ><label style=" margin:0 4px 0 4px">儿童不占位</label></td><td valign="top" scope="row"> 行程天数: </td><td valign="top"><input type="text" id="tianshu" name="tianshu" style="width:50px; margin:0 4px 0 4px;" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" value="<?php echo ($xianlu['tianshu']); ?>"><span>天</span></td></tr></tbody></table><table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view" style=" border-top-color: #CBDAE6 !important;"><tbody><tr><td valign="top"><fieldset style="border:#CBDAE6 1px solid"><legend>出团日期</legend><table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit"><tbody><tr><td><textarea style="width:100%; resize:none" rows="3" readonly name="chutuanriqi" id="chutuanriqi" onclick="setdate(this.id);"><?php echo ($xianlu['chutuanriqi']); ?></textarea></td><td><span class="id-ff multiple" style="margin:0 0 0 10px;"><button style="margin: 0 0 2px 4px;" id="bt_showdate" class="button firstChild" type="button" onclick="setdate('chutuanriqi');"><img src="<?php echo __PUBLIC__;?>/myerp/images/id-ff-select.png"></button><button style="margin: 0 0 2px 4px;" onclick="clearinput('chutuanriqi');" class="button lastChild" type="button"><img src="<?php echo __PUBLIC__;?>/myerp/images/id-ff-clear.png"></button></span></td></tr></tbody></table></fieldset></td></tr></tbody></table><table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view" style=" border-top-color: #CBDAE6 !important;"><tbody><tr><th align="left" colspan="8"><h4>选填信息</h4></th></tr><tr><td valign="top" scope="row" style="min-width:100px;"> 主题: </td><td valign="top"><select name="zhuti" id="zhuti"><?php if($xianlu['zhuti']){ ?><option value="<?php echo ($xianlu['zhuti']); ?>"><?php echo ($xianlu['zhuti']); ?></option><?php }else{ ?><option value="">请选择...</option><?php } ?><?php foreach($xianlu['theme_all'] as $theme){ ?><option value="<?php echo ($theme['title']); ?>"><?php echo ($theme['title']); ?></option><?php } ?></select><input id="addTheme" type="button" name="adds_theme" value="添加" onclick="add_theme()" class="button" style="margin: 0 0 2px 4px;"/><input type="text" id="zhutititle" name="zhutititle" style="width:100px; display:none;"/><input type="text" id="zhutitype" name="zhutitype" value="产品主题" style="width:100px; display:none;"/><input type="button" id="submitTheme" onclick="submit_theme()" value="确定" style="display:none;margin: 0 0 2px 4px;" /></td><td valign="top" scope="row" style="min-width:100px;"> 导游服务: </td><td valign="top"><?php if($xianlu['quanpei']){ ?><input id="daoyoufuwu[]" type="checkbox" name="daoyoufuwu[]" value="全陪" checked="checked"><?php }else{ ?><input id="daoyoufuwu[]" type="checkbox" name="daoyoufuwu[]" value="全陪"><?php } ?><label style=" margin:0 4px 0 4px">全陪</label><?php if($xianlu['dipei']){ ?><input id="daoyoufuwu[]" type="checkbox" name="daoyoufuwu[]" value="地陪" checked="checked"><?php }else{ ?><input id="daoyoufuwu[]" type="checkbox" name="daoyoufuwu[]" value="地陪"><?php } ?><label style=" margin:0 4px 0 4px">地陪</label></td></tr><tr><td valign="top" scope="row"> 视频: </td><td valign="top"><input readonly name="shipin" type="text" id="shipin" value="<?php echo ($xianlu['shipin']); ?>" onclick="showdiv_2('shipin')" style="width:200px;"><input type="hidden" id="Videos_id" /><input type="button" value="选择" class="button" style="margin: 0 0 2px 4px;" onclick="showdiv_2('shipin')" id="selectshipin"/></td><td valign="top" scope="row"> 图片: </td><td valign="top"><input readonly name="tupian" type="text" id="tupian" value="<?php echo ($xianlu['tupian']); ?>" onclick="showdiv_2('tupian')" style="width:200px;"><input type="hidden" id="Images_id" /><input type="button" value="选择" class="button" style="margin: 0 0 2px 4px;" onclick="showdiv_2('tupian')" id="selecttupian"/><input type="button" value="清空" class="button" style="margin: 0 0 2px 4px;" onclick="clearinput('tupian')" id="selecttupian"/></td></tr></tbody></table><style>	.cke_toolgroup { border: 1px solid #94C1E8;}
	.cke_icon{ border: 1px solid #94C1E8;}
	</style><table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view" style=" border-top-color: #CBDAE6 !important;"><tbody><tr><th align="left" colspan="8" style="min-width:100px;"><h4>选填信息</h4></th></tr><tr><td valign="top" scope="row" style="min-width:50px;"> 特色: </td><td valign="top" colspan="3"><textarea name="xingchengtese" id="xingchengtese"><?php echo ($xianlu['xingchengtese']); ?></textarea><script type="text/javascript">          var editor = CKEDITOR.replace( 'xingchengtese' );
          CKFinder.setupCKEditor( editor, '<?php echo __PUBLIC__;?>/gulianstyle/ckfinder/' ) ;
          </script></td></tr><tr><td valign="top" scope="row"> 须知: </td><td valign="top" colspan="3"><textarea name="cantuanxuzhi" id="cantuanxuzhi"><?php echo ($xianlu['cantuanxuzhi']); ?></textarea><script type="text/javascript">          var editor = CKEDITOR.replace( 'cantuanxuzhi' );
          CKFinder.setupCKEditor( editor, '<?php echo __PUBLIC__;?>/gulianstyle/ckfinder/' ) ;
          </script></td></tr></tbody></table><div class="buttons"><input type="submit" value="保存" name="button" class="button primary"><input type="button" value="取消" name="button" class="button"></div></form></div></div><?php A("Chanpin")->footer(); ?><script>jQuery(document).ready(function(){
	  pid = jQuery('#pos2').val();
	  change_jingshe(pid);
	  
	  mudidi = "<?php echo ($xianlu[mudidi]); ?>";
	  mudidi_arr = mudidi.split(',');
	  
	  if (!mudidi_arr[0]) {
		  mudidi_arr[0] = '请选择';
	  }else{
		  jQuery("#pos2").attr('disabled','true');
		  jQuery("#pos3").attr('disabled','true');
	  }
	  jQuery("#pos1").find("option:selected").text(mudidi_arr[0]); 
	  jQuery("#pos2").find("option:selected").text(mudidi_arr[1]); 
	  jQuery("#pos3").find("option:selected").text(mudidi_arr[2]); 
	  jQuery("#pos_name1").val(mudidi_arr[0]);
	  jQuery("#pos_name2").val(mudidi_arr[1]);
	  jQuery("#pos_name3").val(mudidi_arr[2]);
	  jQuery.ajax({
			type:	"POST",
			url:	"<?php echo SITE_INDEX;?>Liandong/liandong",
			async: false,
			data:	"pid=0&type=pos_go",
			success:	function(msg){
						  jQuery("#chufashengfen_id").empty();
						  jQuery(msg).appendTo("#chufashengfen_id");
					  }
		});
	  jQuery("#chufashengfen_id").prepend("<option selected='selected' value='0'>请选择</option>");
	   
	  chufadi = "<?php echo ($xianlu[chufadi]); ?>";
	  chufadi_arr = chufadi.split(',');
	  
	  if (!chufadi_arr[0]) {
		  chufadi_arr[0] = '请选择';
	  }else{
		  jQuery("#chufachengshi_id").attr('disabled','true');
	  }
	  jQuery("#chufashengfen_id").find("option:selected").text(chufadi_arr[0]); 
	  jQuery("#chufachengshi_id").find("option:selected").text(chufadi_arr[1]); 
	  jQuery("#chufashengfen").val(chufadi_arr[0]);
	  jQuery("#chufachengshi").val(chufadi_arr[1]);
	  
});

function change_pos(sid){
	var maxIndex = jQuery("#pos1 option:last").attr("index");
	if (sid=='1' && maxIndex >= '7'){
		jQuery("#pos1 option:first").remove();
		jQuery("#pos2").attr('disabled',false);
		jQuery("#pos3").attr('disabled',false);
	}
	while (sid <= '3')
	{
		jQuery('#pos_name' + sid).val(jQuery('#pos' + sid).find("option:selected").text());
		pid = jQuery('#pos' + sid).val();
		sid++;
		nexts = 'pos' + sid;				
		change(pid ,nexts);
	}
	pid = jQuery('#pos2').val();
	change_jingshe(pid);
}
	
function change_pos_go(){
	var maxIndex = jQuery("#chufashengfen_id option:last").attr("index");
	if ( maxIndex >= '33'){
		
		jQuery("#chufashengfen_id option:first").remove();
		jQuery("#chufachengshi_id").attr('disabled',false);
	}
	jQuery('#chufashengfen').val(jQuery('#chufashengfen_id').find("option:selected").text());
	pid = jQuery('#chufashengfen_id').val();
	nexts = 'chufachengshi_id';				
	change(pid ,nexts);
	jQuery('#chufachengshi').val(jQuery('#chufachengshi_id').find("option:selected").text());
}	
	
function chufachengshi_gaopeng(){
	value = jQuery('#chufachengshi_id').find("option:selected").text();
	jQuery('#chufachengshi').val(jQuery('#chufachengshi_id').find("option:selected").text());
}	
	
function change(pid ,nexts){
	jQuery.ajax({
		type:	"POST",
		url:	"<?php echo SITE_INDEX;?>Liandong/liandong",
		async: false,
		data:	"pid=" + pid + "&type=pos",
		success:	function(msg){
					  jQuery("#" + nexts).empty();
					  jQuery(msg).appendTo("#" +nexts);
				  }
	});
}

function change_jingshe(){
	jQuery.ajax({
		  type:	"POST",
		  url:	"<?php echo SITE_INDEX;?>Liandong/liandong",
		  async: false,
		  data:	"pid=" + pid + "&type=jingshe",
		  success:	function(msg){
						jQuery("#jingshe").html(msg);
					}
	  });
}

function setdate(objID){
   if(jQuery("#datediv").is(":visible")==true){ 
	  jQuery('#datediv').hide();
	  return ;
   }
	var url = '<?php echo __PUBLIC__;?>/myerp/date.html';
	url = url + '?oid='+objID+'&selectdates=' + document.getElementById(objID).value;
	jQuery('#dateiframe').attr("src",url);
	
	obj =document.getElementById('bt_showdate');
	objleft = getPosLeft(obj) - 410;
	objtop = getPosTop(obj) - 230;
	jQuery('#datediv').css({top:objtop , left:objleft });
	jQuery('#datediv').show();
}

function div_close(id){
	jQuery('#'+id+'').hide();
}

function clearinput(objID){
	jQuery('#'+objID+'').val('');
	var url = '<?php echo __PUBLIC__;?>/myerp/date.html';
	url = url + '?oid='+objID+'&selectdates=' + document.getElementById(objID).value;
	jQuery('#dateiframe').attr("src",url);
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

function add_theme(){
	jQuery("#zhutititle").val('');
	jQuery("#zhuti").hide();
	jQuery("#addTheme").hide();
	jQuery("#zhutititle").show();
	jQuery("#submitTheme").show();
}

function submit_theme(){
	var themeName = jQuery("#zhutititle").val();
	if(themeName == '') {
		alert('请填写线路主题！');
		jQuery("#zhutititle").hide();
		jQuery("#submitTheme").hide();
		jQuery("#zhuti").show();
		jQuery("#addTheme").show();
		return false;	
	}
	ThinkAjax.sendForm('form','<?php echo SITE_INDEX;?>Info/addinfo/',doComplete_11,'resultdiv');
}

function doComplete_11(data,status){
	if (status==1){
		jQuery("#zhutititle").hide();
		jQuery("#submitTheme").hide();
		jQuery("#zhuti").show();
		jQuery("#addTheme").show();
		var option_new = "<option value='" + data + "'>" + data + "</option>";
		jQuery("#zhuti").append(option_new);
		jQuery("#zhuti").val(data);
	}
}

function showdiv_2(id){
   if(jQuery("#divselect").is(":visible")==true){ 
	  jQuery("#divselect").hide();
	  return ;
   }
   if(id == 'shipin'){
		var url = '<?php echo SITE_INDEX;?>/Liandong/getVideos/own/';
		url = url + document.getElementById("shipin").value;
		obj =document.getElementById('selectshipin');
		jQuery("#iftitle").html('选择视频');
		objleft = getPosLeft(obj) - 430;
   }
   if(id == 'tupian'){
		var url = '<?php echo SITE_INDEX;?>/Liandong/getImages/own/';
		url = url + document.getElementById("tupian").value;
		obj =document.getElementById('selecttupian');
		jQuery("#iftitle").html('选择图片');
		objleft = getPosLeft(obj) - 630;
   }
	objtop = getPosTop(obj) - 450;
	jQuery('#iframeselect').attr("src",url);
	jQuery("#divselect").css({top:objtop , left:objleft });
	jQuery("#divselect").show();
	
	
}

function save(){
	document.getElementById('xingchengtese').value = CKEDITOR.instances.xingchengtese.getData();
	document.getElementById('cantuanxuzhi').value = CKEDITOR.instances.cantuanxuzhi.getData();
	ThinkAjax.sendForm('form','<?php echo SITE_INDEX;?>Chanpin/dopostfabu/',doComplete,'resultdiv');
}

function doComplete(data,status){
	if(status == 1){
		var chanpinID = document.getElementById('chanpinID').value;
		if (chanpinID)
			window.location.href='<?php echo SITE_INDEX;?>Chanpin/fabu/chanpinID/'+chanpinID;
		else
			window.location.href='<?php echo SITE_INDEX;?>Chanpin/xingcheng/chanpinID/'+chanpinID;
	}
}
</script><div style="position: absolute; display:none;" id="divselect"><table cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table cellspacing="0" cellpadding="0" border="0" width="100%" class="olCgClass"><tbody><tr><td width="100%" class="olCgClass"><div style="float:left" id="iftitle"></div><div style="float: right"><a title="关闭" href="javascript:void(0);" onClick="javascript:return div_close('divselect');"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/close.gif" style="margin-left:2px; margin-right: 2px;"></a></div></td></tr></tbody></table><table cellspacing="0" cellpadding="0" border="0" width="100%" class="olFgClass"><tbody><tr><td valign="top" class="olFgClass"><iframe id="iframeselect" frameborder="0" width="700px" height="400px" scrolling="auto" ></iframe></td></tr></tbody></table></td></tr></tbody></table></div><div style="position: absolute; display:none" id="datediv"><table cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table cellspacing="0" cellpadding="0" border="0" width="100%" class="olCgClass"><tbody><tr><td width="100%" class="olCgClass"><div style="float:left">选择出团日期</div><div style="float: right"><a title="关闭" href="javascript:void(0);" onClick="javascript:return div_close('datediv');"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/close.gif" style="margin-left:2px; margin-right: 2px;"></a></div></td></tr></tbody></table><table cellspacing="0" cellpadding="0" border="0" width="100%" class="olFgClass"><tbody><tr><td valign="top" class="olFgClass"><iframe id="dateiframe" frameborder="0" scrolling="no" width="390px" height="180px" style="margin-top:4px;"></iframe></td></tr></tbody></table></td></tr></tbody></table></div>