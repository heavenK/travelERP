<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    var SITE_INDEX = '<?php echo SITE_INDEX;?>';
    var chanpinID = '<?php echo ($chanpinID); ?>';
	var title =  '<?php echo ($datatitle); ?>';
	function doshenhe(dotype){
		ThinkAjax.myloading('resultdiv');
		var dataID = chanpinID;
		var datatype = '线路';
		jQuery.ajax({
			type:	"POST",
			url:	SITE_INDEX+"Chanpin/doshenhe",
			data:	"dataID="+dataID+"&dotype="+dotype+"&datatype="+datatype+"&title="+title,
			success:function(msg){
				ThinkAjax.myAjaxResponse(msg,'resultdiv');
			}
		});
	}
	function ajaxalert(title){
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+title+'</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
	}
    </script>

<div class="moduleTitle" style="margin-bottom:10px;">
  <h3 style=""><?php echo ($navigation); echo ($datatitle); ?></h3>
  <span style="margin-top:10px;"> <img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a> <a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a> </span> </div>
<?php if($chanpinID){ ?>
<div id="mysearchdiv" style="margin-bottom:10px;">
  <ul id="searchTabs" class="tablist tablist_2">
    <li> <a 
      <?php if($nowDir['title'] == '基本信息'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/fabu/chanpinID/<?php echo ($chanpinID); ?>">基本信息</a> </li>
    <li> <a 
      <?php if($nowDir['title'] == '行程'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/xingcheng/chanpinID/<?php echo ($chanpinID); ?>">&nbsp;&nbsp;行&nbsp;&nbsp;程&nbsp;&nbsp;</a> </li>
    <li> <a 
      <?php if($nowDir['title'] == '成本售价'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/chengbenshoujia/chanpinID/<?php echo ($chanpinID); ?>">成本售价</a> </li>
    <?php if($showzituan === true){ ?>
    <li> <a 
      <?php if($nowDir['title'] == '子团管理'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/zituan/chanpinID/<?php echo ($chanpinID); ?>">子团管理</a> </li>
    <?php } ?>
  </ul>
</div>
<?php }else{ ?>
<div id="mysearchdiv" style="margin-bottom:10px;">
  <ul id="searchTabs" class="tablist tablist_2">
    <li> <a 
      <?php if($nowDir['title'] == '基本信息'){ ?>
      class="current"
      <?php } ?>
      href="javascript:ajaxalert('请先创建基本信息')">基本信息</a> </li>
    <li> <a 
      <?php if($nowDir['title'] == '行程'){ ?>
      class="current"
      <?php } ?>
      href="javascript:ajaxalert('请先创建基本信息')">&nbsp;&nbsp;行&nbsp;&nbsp;程&nbsp;&nbsp;</a> </li>
    <li> <a 
      <?php if($nowDir['title'] == '成本售价'){ ?>
      class="current"
      <?php } ?>
      href="javascript:ajaxalert('请先创建基本信息')">成本售价</a> </li>
  </ul>
</div>
<?php } ?>
<div id="resultdiv" class="resultdiv"></div>
<div id="resultdiv_2" class="resultdiv"></div>
<div class="buttons">
  <input type="button" value="审核记录" name="button" class="button primary" style="float:right" id="showshenhe" onclick="shenheshow_doit(<?php echo ($chanpinID); ?>);">
  
      <?php $taskom = A("Method")->_checkOMTaskShenhe($chanpinID,'线路'); if(false !== $taskom){ if(cookie('show_action') == '批准'){ ?>
      <input type="button" style="float:right" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe('检出');">
      <?php }if(cookie('show_action') == '申请'){ ?>
      <input type="button" style="float:right" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe('申请');">
      <?php }}if(A("Method")->checkshenheback($chanpinID,'线路')){ ?>
      <input type="button" style="float:right" value=" 审核回退 " name="button" onclick="shenhe_back(<?php echo ($chanpinID); ?>,'线路');">
	  <?php } ?>
  
  <?php if('基本信息' == $nowDir['title']){ ?>
  <input type="button" value="保存" name="button" class="button primary" onclick="if(CheckForm('form','resultdiv_2')) save();">
  <?php } ?>
  <?php if('行程' == $nowDir['title']){ ?>
  <input type="button" value="保存" name="button" class="button primary" onClick="save();">
  <?php } ?>
</div>

<script>
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
function shenheshow_doit(chanpinID){
   if(jQuery("#shenhediv").is(":visible")==true){ 
	  jQuery('#shenhediv').hide();
	  return ;
   }
    getshenhemessage("Index.php?s=/Message/getshenhemessage/chanpinID/"+chanpinID);
	obj =document.getElementById('showshenhe');
	objleft = getPosLeft(obj) - 370;
	objtop = getPosTop(obj) + 20;
	jQuery('#shenhediv').css({top:objtop , left:objleft });
	jQuery('#shenhediv').show();
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
function getshenhemessage(posturl){
	jQuery.ajax({
		type:	"POST",
		url:	"<?php echo ET_URL;?>"+posturl,
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

</script>
<div style="position: absolute; display:none" id="shenhediv">
  <table cellspacing="0" cellpadding="1" border="0" class="olBgClass">
    <tbody>
      <tr>
        <td><table cellspacing="0" cellpadding="0" border="0" width="100%" class="olCgClass">
            <tbody>
              <tr>
                <td width="100%" class="olCgClass"><div style="float:left">审核记录</div>
                  <div style="float: right"> <a title="关闭" href="javascript:void(0);" onClick="javascript:return div_close('shenhediv');"> <img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/close.gif" style="margin-left:2px; margin-right: 2px;"> </a> </div></td>
              </tr>
            </tbody>
          </table>
          <table cellspacing="0" cellpadding="0" border="0" width="100%" class="olFgClass">
            <tbody id="shenhe_box">
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div>