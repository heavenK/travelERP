<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/WdatePicker.css" rel="stylesheet" type="text/css">
<div id="main">
          <style>
		#navtab_2 h3 { color:#0B578F}
		#navtab_3 h3 { color:#999}
		</style>

  <div id="leftColumn" style="margin-top:0px; width:150px;">
        <div id="navtab_1" class="leftList">
          <h3><span>产品分类</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="#">&nbsp;<span>子团产品</span></a> </li>
            <li id="subModuleList" style="padding:0px; border-top:none">
                  <ul>
                    <li class="subTabMore" style="font-size:12px;"> <a href="<?php echo SITE_INDEX;?>Chanpin">&nbsp;线路发布及控管&gt;&gt;</a> 
                        <ul class="cssmenu" style="margin-top:8px;">
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/近郊/guojing/国内/xianlutype/散客产">国内近郊 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/长线/guojing/国内/xianlutype/散客产品">国内长线 </a> </li>
                          <li> <a href="#">国内自由人 </a> </li>
                          <li> <a href="#">国内包团 </a> </li>
                          <li> <a href="#">境外海岛 </a> </li>
                          <li> <a href="#">境外欧美澳非 </a> </li>
                          <li> <a href="#">境外游 </a> </li>
                          <li> <a href="#">境外自由人 </a> </li>
                          <li> <a href="#">境外包团 </a> </li>
                        </ul>
                    </li>
                  </ul>
            </li>
            <li> <a href="#">&nbsp;<span>签证及票务</span></a> </li>
            <li> <a href="#">&nbsp;<span>回收站</span></a> </li>
          </ul>
        </div>
  </div>


  <div id="content" style="margin-left:170px;">
    <div id="resultdiv" class="resultdiv"></div>
    <div id="resultdiv_2" class="resultdiv"></div>
    <?php A("Chanpin")->header_kongguan(); ?>
    
    
            <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:0px;">
              <tbody>
                <tr height="20">
                  <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 团员人数 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 已分配房间人数 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 未分配房间人数 </div></th>
                </tr>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($tuanyuan_all); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($tuanyuan_in); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($tuanyuan_out); ?></td>
                </tr>
              </tbody>
            </table>
    
    
            <?php foreach($dingdanlist as $v){ ?>
    
            <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:0px;">
              <tbody>
                <tr height="20">
                  <th scope="col" nowrap="nowrap" style="width:100px; float:left; min-width:100px;"><div style=" background:#4E8CCF; color:#FFF"> 房间标题 </div></th>
                  <th scope="col" nowrap="nowrap" style="width:70%;min-width:300px;"><div> 备注说明 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:250px;width:30%;"><div> 操作 </div></th>
                </tr>
                <tr style="background:#EBEBED" height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['remark']); ?></td>
                  <td scope="row" align="left" valign="top">
                  <input type="button" value="分配人员" name="button" class="button primary" onClick="select_tuanyuan('<?php echo ($chanpinID); ?>','<?php echo ($v[chanpinID]); ?>')">
                  <input type="button" value="编辑房间" name="button" class="button primary" onClick="save();">
                  <input type="button" value="删除房间" name="button" class="button primary" onClick="save();">
                  </td>
                </tr>
              </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:20px;">
              <tbody>
                <tr height="20">
                  <th scope="col" nowrap="nowrap" style="width:100px;"><div style=" background:#090; color:#FFF"> 姓名 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 性别 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 团费 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 证件类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 证件号 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 联系电话 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 需求 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 详细资料 </div></th>
                </tr>
                <?php foreach($v['renyuanlist'] as $vol){ ?>
                <tr style="cursor:pointer" height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['name']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['sex']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['manorchild']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['price']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['zhengjiantype']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['zhengjianhaoma']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['telnum']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['remark']); ?></td>
                  <td scope="row" align="left" valign="top"><a href="javascript:TravelerDetail(<?php echo ($vol['datacdID']); ?>)">查看</a></td>
                </tr>
                <?php } ?>
                
              </tbody>
            </table>
      
                <?php } ?>
      
  </div>
  
</div>
<?php A("Index")->footer(); ?>


<div id="dialog_room" title="房间信息" style="background:#FFF">
<form id="form_room" id="form_room" method="post" >
<input type="hidden" name="chanpinID" />
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="分房标题不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<script language="javascript"> 



jQuery(document).ready(function(){
	// Dialog
	jQuery('#dialog_room').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_room','resultdiv_2'))
				ThinkAjax.sendForm('form_room','<?php echo SITE_INDEX;?>Chanpin/dopostfenfang/',save_room,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog Link
	jQuery('#room_create').click(function(){
		jQuery('#dialog_room').dialog('open');
		return false;
	});
});

function select_tuanyuan(zituanID,fenfangID)
{
    var url = '<?php echo SITE_INDEX;?>Chanpin/select_tuanyuan/zituanID/'+zituanID+'/fenfangID/'+fenfangID;
    var winvalue=	window.open(url,null,"height=600,width=1100,status=yes,toolbar=no,menubar=no,location=no");

}

function TravelerDetail(id)
{
    var url="<?php echo SITE_INDEX;?>Xiaoshou/tuanyuanxinxi/id/"+id;
    window.open(url,'newwin','width=900,height=700,left=240,status=no,resizable=yes,scrollbars=yes');
}

function save_room(data,status)
{
	if(status == 1)
	location.reload();
}

function exports()
{
	window.location.href = '<?php echo SITE_INDEX;?>Chanpin/zituanfenfang/export/1/chanpinID/'+chanpinID;
}
</script>