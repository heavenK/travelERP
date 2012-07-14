<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>视频图片选择</title>

<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/style (2).css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/yui (2).css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/deprecated (2).css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/colors.sugar.css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/fonts.normal.css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/gaopeng.css">

<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/sugar_grp1_yui.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/sugar_grp1.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/js/style.js"></script>
<script language="javascript" src="<?php echo __PUBLIC__;?>/myerp/jquery-1.7.2.min.js" ></script>
<script language="javascript" src="<?php echo __PUBLIC__;?>/myerp/chanpin/aboutsearch.js" ></script>

<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/ThinkAjax_GP.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script>

<link type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-ui-1.8.20.custom/css/ui-lightness/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/jquery-ui-1.8.20.custom/js/jquery-ui-1.8.20.custom.min.js"></script>

<script>
SITE_INDEX = '<?php echo SITE_INDEX;?>';
jQuery(document).ready(function(){
	jQuery('#dialogpic').dialog({
		autoOpen: false,
		width: 500,
	});
});
 function showpic(data)
 {
	document.getElementById('picimg').src='<?php echo SITE_DATA;?>Attachments/m_'+data;
	jQuery('#dialogpic').dialog('open');
}
 function closeshowpic()
 {
	jQuery('#dialogpic').dialog('close');
}
</script>
</head>
<body>
<input type="hidden" id="own" value="<?php echo ($own); ?>" />
<div style="overflow-x:hidden;">
            <div class="moduleTitle" style="margin-bottom:10px;">
              <h2 style="margin-top:10px;"><?php echo ($datatitle); ?></h2>
              <div style="float:left; margin-left:50px; margin-top:6px;">
                  <span id="show_link_insideview"  <?php if(!cookie('closesearch')) echo 'style="display:none"'; ?>> 
                  <a href="javascript:void(0);" onclick="showmysearchdiv(1)"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/insideview_collapsed.png"></a> 
                  </span> 
                  <span id="hide_link_insideview"  <?php if(cookie('closesearch')) echo 'style="display:none"'; ?>> 
                  <a href="javascript:void(0);" onclick="showmysearchdiv(2)"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/insideview_expanded.png"></a> 
                  </span> 
              </div>
              <span style="margin-top:10px;">
              <img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a> <a href="javascript:void(0);" onclick="alert('暂无');" class="utilsLink"> 帮助 </a>
              </span>
            </div>
            
            <div id="mysearchdiv"  <?php if(cookie('closesearch')) echo 'style="display:none"'; ?> >
                <ul id="searchTabs" class="tablist">
                  <li style="margin-right:1px;">
                      <a id="searchtab_1" class="current" href="javascript:selectTabCSS('Calls|basic_search');" onclick="showsearch(1)">基本查找</a>
                  </li>
                </ul>
                <div class="search_form" id="searchdiv_1" style="margin-bottom:0px;">
                      <div class="edit view search ">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                              <tbody>
                                <tr>
                                  <td scope="row" nowrap="nowrap"> 名称 </td>
                                  <td nowrap="nowrap"><input type="text" name="title" id="title"></td>
                                  <td scope="row" nowrap="nowrap"> 编号 </td>
                                  <td nowrap="nowrap"><input type="text" name="bianhao" id="bianhao"></td>
                                  <td scope="row" nowrap="nowrap"> 团期 </td>
                                  <td nowrap="nowrap">
                                  <input type="text" onfocus="WdatePicker()" id="chufariqi" name="chufariqi" value="<?php echo ($chufariqi); ?>" >
                              </tbody>
                            </table>
                        </div>
                      <input title="查找" class="button" type="button" value=" 查找 " onclick="dosearch();">
                      <input title="清除" class="button" type="button" value=" 清除 " onclick="clearsearch();">
                </div>
            </div>
            
            <table cellpadding="0" cellspacing="0" width="100%" class="list view">
              <tbody>
              
                <tr class="pagination">
                  <td colspan="11">
                  <table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                      <tbody>
                        <tr>
                          <td nowrap="nowrap" class="paginationActionButtons">
                          	<a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                            <input class="button" type="button" id="send" onclick="sendValue();" value="确认推送"/>
                            <input class="button" type="button" id="send" onclick="<?php echo SITE_ADMIN;?>Basedata/add_video" value="添加"/>
                          </td>
                          <td nowrap="nowrap" align="right" class="paginationChangeButtons">
                          	<?php echo ($page); ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    </td>
                </tr>
                
              <tr height="20">
                <th scope="col" nowrap="nowrap"> 序号</th>
                <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 标题 </div></th>
                <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 描述 </div></th>
                <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 视频地址 </div></th>
                <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 封面图片 </div></th>
              </tr>
              <?php $i=0;foreach($datalist as $v){ $i++; ?>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><input <?php if($v['title'] == $title){ ?> checked="checked"<?php } ?> id="<?php echo ($v[systemID]); ?>" type="radio" id="<?php echo ($v[systemID]); ?>" name="checkboxs" value="<?php echo ($v[title]); ?>"></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['description']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['video_url']); ?></td>
                  <td scope="row" align="left" valign="top"><a href="javascript:void(0)" onmouseover="showpic('<?php echo ($v[pic_url]); ?>');" onmouseout="closeshowpic();">查看</a></td>
                </tr>
              <?php } ?>
              
              
                <tr class="pagination">
                  <td colspan="11">
                  <table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                      <tbody>
                        <tr>
                          <td nowrap="nowrap" class="paginationActionButtons">
                          	<a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                            <input class="button" type="button" id="send" onclick="sendValue();" value="确认推送"/>
                            <input class="button" type="button" id="send" onclick="<?php echo SITE_ADMIN;?>Basedata/add_video" value="添加"/>
                          </td>
                          <td nowrap="nowrap" align="right" class="paginationChangeButtons">
                          	<?php echo ($page); ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    </td>
                </tr>
              
              </tbody>
            </table>
</div>
</body>
</html>
<script language="javascript">
jQuery("document").ready(function(){
	var arr = jQuery("#own").attr("value").split(',');
	for(var i in arr){
		v = arr[i]
		jQuery("input[name='checkboxs'][value=" + v + "]").attr("checked",true);
	}
})

function sendValue(){
	jQuery("input[name='checkboxs']:checked").each(function(i){
		if (i == '0') {
			str = jQuery(this).attr('value');
			ids = jQuery(this).attr('id');
		}
		else {
			str += ',' + jQuery(this).attr('value');
			ids += ',' + jQuery(this).attr('id');
		}
	})
	
	window.parent.document.getElementById("shipin").value=str;
	window.parent.document.getElementById("Videos_id").value=ids;
}
</script>

<div id="dialogpic" title="提示消息" style="background:#FFF">
<img id="picimg" />
</div>