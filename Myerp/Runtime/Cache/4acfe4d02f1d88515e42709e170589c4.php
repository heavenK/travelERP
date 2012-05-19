<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>旅游ERP</title><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckeditor/ckeditor.js"></script><script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckfinder/ckfinder.js"></script><script src="<?php echo __PUBLIC__;?>/myerp/jquery-1.4.2.js" language="javascript"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Base.js"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/prototype.js"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/mootools.js"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Ajax/ThinkAjax.js"></script><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script><script>function save(){
	ThinkAjax.sendForm('form','<?php echo SITE_INDEX;?>Chanpin/dopostfabu/',doComplete,'resultdiv');
}

function doComplete(data,status){
	if (status==1){
		window.location.href='<?php echo SITE_INDEX;?>Chanpin/xingcheng/';
	}
 
}



</script></head><style>#content {
	paggin-buttom:0px;
}
</style><body><?php A("Chanpin")->showheader(); ?><div id="main"><?php A("Chanpin")->left_fabu(); ?><div id="content" style="margin-left:170px;"><div class="moduleTitle" style="margin-bottom:10px;"><h2 style="margin-top:10px;"><?php echo ($nav); ?></h2><span style="margin-top:10px;"><img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a><a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a></span></div><div id="mysearchdiv" style="margin-bottom:10px;"><ul id="searchTabs" class="tablist tablist_2"><li style="margin-right:1px;"><a <?php if($pos == '基本信息'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/fabu/chanpinID/<?php echo ($chanpinID); ?>">基本信息</a></li><li style="margin-right:1px;"><a <?php if($pos == '子团管理'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/zituan/chanpinID/<?php echo ($chanpinID); ?>">子团管理</a></li><li style="margin-right:1px;"><a <?php if($pos == '行程'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/xingcheng/chanpinID/<?php echo ($chanpinID); ?>">&nbsp;&nbsp;行&nbsp;&nbsp;程&nbsp;&nbsp;</a></li><li style="margin-right:1px;"><a <?php if($pos == '成本售价'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/chengbenshoujia/chanpinID/<?php echo ($chanpinID); ?>">成本售价</a></li></ul></div><div id="resultdiv" class="resultdiv"></div><div id="resultdiv_2" class="resultdiv"></div><form name="form" method="post" id="form"><input type="hidden" name="ajax" value="1"><!--ajax提示--><table cellpadding="0" cellspacing="0" width="100%" class="list view"><tbody><tr class="pagination"><td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable"><tbody><tr><td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                            <input class="button" type="button" value=" 删除 "></td><td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?></td></tr></tbody></table></td></tr><tr height="20"><th scope="col" nowrap="nowrap"><input type="checkbox" class="checkbox" value="" id="checkboxall" onclick="myCheckBoxSelect(this)"></th><th scope="col" nowrap="nowrap" style="min-width:300px;"><div> 标题 </div></th><th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 出团日期 </div></th><th scope="col" nowrap="nowrap"><div> 团编号 </div></th><th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 报名截止 </div></th><th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 名额 </div></th><th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 状态 </div></th><th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 操作人 </div></th><th scope="col" nowrap="nowrap"><div> 轨迹 </div></th></tr><?php $i = -1; foreach($zituanAll as $v){ $i++; ?><tr height="30" class="evenListRowS1"><td scope="row" align="left" valign="top"><input value="<?php echo ($v['xianluID']); ?>" id="chanpinitem<?php echo ($i); ?>" type="checkbox" name="itemlist[]" class="checkbox"></td><td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['chutuanriqi']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['tuanhao']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['baomingjiezhi']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['renshu']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td><td scope="row" align="left" valign="top"><?php echo ($v['user_name']); ?></td><td scope="row" align="center" valign="top"><img onclick="showmessage(this,'<?php echo ($v['chanpinID']); ?>','线路','操作记录');showbox(this,'messageitem','r')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" /></td></tr><?php } ?><tr class="pagination"><td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable"><tbody><tr><td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="#">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a><input name="Delete" class="button" type="button" value="删除" /><input class="button" type="button" value="导出"></td><td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?></td></tr></tbody></table></td></tr></tbody></table></form></div></div></body></html><script language="javascript">function myCheckBoxSelect(o,st)
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

function showmessage(obj,chanpinID)
{
	$.ajax({
		type:	"POST",
		url:	"<?php echo SITE_INDEX;?>Chanpin/message",
		data:	"chanpinID="+chanpinID,
		success:	function(msg){
				  var str = '';
				  if(msg != 'null' && msg){
					  var msg = eval('(' + msg + ')');
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

</script><div id="selectitem" style=" display:none; position:absolute;"><table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass"><tbody><tr><td valign="top" class="olOptionsFgClass"><div class="olFontClass"><a href="javascript:void(0)" onclick="myCheckBoxSelect()" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,'yes');" class="menuItem" style="width: 150px">选择全部</a><a href="javascript:void(0)" onclick="myCheckBoxSelect('o','false')" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,'yes');" class="menuItem" style="width: 150px">取消选择</a></div></td></tr></tbody></table></td></tr></tbody></table></div><div id="messageitem" style=" display:none; position:absolute;"><table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass"><tbody><tr><td valign="top" class="olOptionsFgClass"><div class="olFontClass" id="themessage"></div></td></tr></tbody></table></td></tr></tbody></table></div>