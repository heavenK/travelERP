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
</script>

</head>

<body>

<div id="header">



<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/WdatePicker.css" rel="stylesheet" type="text/css">
<div id="main">
  <div id="content" style="margin-left:5px; padding-left:0px; border-left:none">
    <div id="resultdiv" class="resultdiv"></div>
    <div id="resultdiv_2" class="resultdiv"></div>
    
<form id="form_room" id="form_room" method="post" >
            <table cellpadding="0" cellspacing="0" width="100%" class="list view">
              <tbody>
                <tr class="pagination">
                  <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                      <tbody>
                        <tr>
                          <td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="javascript:void(0)">操作&nbsp;</a>&nbsp;
                            <input class="button" type="button" value=" 分配 " onclick="doselect()">
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
                <tr height="20">
                  <th scope="col" nowrap="nowrap" colspan="10"><div style=" background:#4E8CCF; color:#FFF"> 已分配该房间人员 </div></th>
                </tr>
                <tr height="20">
                  <th scope="col" nowrap="nowrap"><div> 选择 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 姓名 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 性别 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 团费 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 证件类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 证件号 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 联系电话 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 需求 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 详细资料 </div></th>
                </tr>
              <?php foreach($tuanyuan_in as $v){ ?>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><input type="checkbox" name="datacdID[]" checked="checked" value="<?php echo ($v['id']); ?>"/></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['name']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['sex']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['manorchild']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['price']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['zhengjiantype']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['zhengjianhaoma']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['telnum']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['remark']); ?></td>
                  <td scope="row" align="left" valign="top"><a href="javascript:TravelerDetail(<?php echo ($v['id']); ?>)">查看</a></td>
                </tr>
                <?php } ?>
                <tr height="20">
                  <th scope="col" nowrap="nowrap" colspan="10"><div style=" background:#090; color:#FFF"> 可分配人员 </div></th>
                </tr>
                <tr height="20">
                  <th scope="col" nowrap="nowrap"><div> 选择 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 姓名 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 性别 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 团费 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 证件类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 证件号 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 联系电话 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 需求 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 详细资料 </div></th>
                </tr>
              <?php foreach($tuanyuan_out as $v){ ?>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><input type="checkbox" name="datacdID[]" value="<?php echo ($v['id']); ?>" /></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['name']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['sex']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['manorchild']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['price']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['zhengjiantype']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['zhengjianhaoma']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['telnum']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['remark']); ?></td>
                  <td scope="row" align="left" valign="top"><a href="javascript:TravelerDetail(<?php echo ($v['id']); ?>)">查看</a></td>
                </tr>
                <?php } ?>
                
              </tbody>
            </table>
</form>
            
  </div>
  
</div>

<script language="javascript"> 

function doselect()
{
  ThinkAjax.sendForm('form_room','<?php echo SITE_INDEX;?>Chanpin/dopostselect_tuanyuan/zituanID/<?php echo ($zituanID); ?>/fenfangID/<?php echo ($fenfangID); ?>',save_room,'resultdiv');
}
function save_room(data,status)
{
	if(status == 1){
		opener.location.reload();
		window.close();
	}
}
function TravelerDetail(id)
{
    var url="<?php echo SITE_INDEX;?>Xiaoshou/tuanyuanxinxi/id/"+id;
    window.open(url,'newwin','width=900,height=700,left=240,status=no,resizable=yes,scrollbars=yes');
}
</script>