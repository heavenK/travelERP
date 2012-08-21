<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/WdatePicker.css" rel="stylesheet" type="text/css">
<div id="main">         <style>
		#navtab_2 h3 { color:#0B578F}
		#navtab_3 h3 { color:#999}
		</style>

  <div id="leftColumn" style="margin-top:0px; width:150px;">
        <div id="navtab_1" class="leftList">
          <h3><span>产品分类</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/kongguan">&nbsp;<span>子团产品</span></a> </li>
            <li id="subModuleList" style="padding:0px; border-top:none">
                  <ul>
                    <li class="subTabMore" style="font-size:12px;"> <a href="<?php echo SITE_INDEX;?>Chanpin">&nbsp;线路发布及控管&gt;&gt;</a> 
                        <ul class="cssmenu" style="margin-top:8px;">
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
                  </ul>
            </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu">&nbsp;<span>签证及票务</span></a> </li>
            <li> <a href="#">&nbsp;<span>回收站</span></a> </li>
          </ul>
        </div>
  </div>


  <div id="content" style="margin-left:170px;">
    <div id="resultdiv" class="resultdiv"></div>
    <div id="resultdiv_2" class="resultdiv"></div>
    <?php A("Chanpin")->header_kongguan(); ?>
    
    
    <div id="mysearchdiv" style="margin-bottom:10px;">
      <ul id="searchTabs" class="tablist " style="border-top:#4E8CCF">
        <li style="color:#FFF; background:#4E8CCF">应收费用</li>
      </ul>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:20px;">
      <tbody>
        <tr height="20">
          <th scope="col" nowrap="nowrap" style="min-width:200px;width:200px;"><div style=" background:#090; color:#FFF"> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 审核阶段 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 金额 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 方式 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:240px; width:10%"><div> 操作 </div></th>
        </tr>
        <?php foreach($baozhanglist as $vol){ if($vol['type'] != '结算项目') continue; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['value']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['method']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>);">
              <input type="button" value="删除" name="button" class="button primary" onClick="deleteSystemItem(<?php echo ($vol['chanpinID']); ?>);" >
      <?php $taskom = A("Method")->_checkOMTaskShenhe($vol['chanpinID'],'报账项'); if(false !== $taskom){ if(cookie('show_action') == '批准'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('检出','报账项',<?php echo ($vol['chanpinID']); ?>,'<?php echo ($vol['title']); ?>');">
      <?php }if(cookie('show_action') == '申请'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('申请','报账项',<?php echo ($vol['chanpinID']); ?>,'<?php echo ($vol['title']); ?>');">
      <?php }}if(A("Method")->checkshenheback($vol['chanpinID'],'报账项')){ ?>
      <input type="button" value=" 审核回退 " name="button" onclick="shenhe_back(<?php echo ($vol['chanpinID']); ?>,'报账项');">
	  <?php } ?>
            </td>
          </tr>
        <?php } ?>
        </tbody>
    </table>
    
    
      
      
    <div id="mysearchdiv" style="margin-bottom:10px;">
      <ul id="searchTabs" class="tablist " style="border-top:#4E8CCF">
        <li style="color:#FFF; background:#4E8CCF">应付费用</li>
      </ul>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:20px;">
      <tbody>
        <tr height="20">
          <th scope="col" nowrap="nowrap" style="min-width:200px;width:200px;"><div style=" background:#090; color:#FFF"> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 审核阶段 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 金额 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 方式 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:240px; width:10%"><div> 操作 </div></th>
        </tr>
        <?php foreach($baozhanglist as $vol){ if($vol['type'] != '支出项目') continue; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['value']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['method']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>);">
              <input type="button" value="删除" name="button" class="button primary" onClick="deleteSystemItem(<?php echo ($vol['chanpinID']); ?>);" >
              
      <?php $taskom = A("Method")->_checkOMTaskShenhe($vol['chanpinID'],'报账项'); if(false !== $taskom){ if(cookie('show_action') == '批准'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('检出','报账项',<?php echo ($vol['chanpinID']); ?>,'<?php echo ($vol['title']); ?>');">
      <?php }if(cookie('show_action') == '申请'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('申请','报账项',<?php echo ($vol['chanpinID']); ?>,'<?php echo ($vol['title']); ?>');">
      <?php }}if(A("Method")->checkshenheback($v['chanpinID'],'报账项')){ ?>
      <input type="button" value=" 审核回退 " name="button" onclick="shenhe_back(<?php echo ($v['chanpinID']); ?>,'报账项');">
	  <?php } ?>
            </td>
          </tr>
        <?php } ?>
        </tbody>
    </table>
      
  </div>
</div>
<?php A("Index")->footer(); ?>


<div id="dialog_item" title="报账项目" style="background:#FFF">
<form id="form_item" id="form_item" method="post" >
<input type="hidden" name="chanpinID" id="chanpinID" />
<input type="hidden" name="type" id="type" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" id="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 类型: </td>
          <td valign="top" scope="row"><span id="type_shuoming"></span></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 金额: </td>
          <td valign="top" scope="row"><input name="value" type="text" id="value" check="^\S+$" warning="金额不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 方式: </td>
          <td scope="row" align="left" valign="top"><select name="method" id="method">
              <option value="现金">现金</option>
              <option value="网拨">网拨</option>
              <option value="银行卡">银行卡</option>
              <option value="汇款">汇款</option>
              <option value="转账">转账</option>
              <option value="支票">支票</option>
              <option value="签单">签单</option>
              <option value="对冲">对冲</option>
            </select></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" id="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<script language="javascript"> 

var baozhangID = '<?php echo ($baozhang[chanpinID]); ?>';

jQuery(document).ready(function(){
	// Dialog
	jQuery('#dialog_item').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"申请审核": function() {
				title = jQuery("#title").val();
				doshenhe_baozhangitem('申请','报账项',jQuery("#chanpinID").val(),title);
			},
			"批准": function() {
				doshenhe_baozhangitem('检出','报账项',jQuery("#chanpinID").val(),title);
			},
			"确认": function() {
				if(CheckForm('form_item','resultdiv_2'))
				ThinkAjax.sendForm('form_item','<?php echo SITE_INDEX;?>Chanpin/dopost_baozhangitem/parentID/'+baozhangID,save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	
	// Dialog Link
	jQuery('#yingshuo_create').click(function(){
		jQuery('#title').val('');
		jQuery('#value').val('');
		jQuery('#method').val('现金');
		jQuery('#remark').val('');
		jQuery('#chanpinID').val('');
		jQuery('#type_shuoming').html('应收费用');
		jQuery('#type').val('结算项目');
		jQuery('#dialog_item').dialog('open');
		return false;
	});
	
	// Dialog Link
	jQuery('#yingfu_create').click(function(){
		jQuery('#title').val('');
		jQuery('#value').val('');
		jQuery('#method').val('现金');
		jQuery('#remark').val('');
		jQuery('#chanpinID').val('');
		jQuery('#type_shuoming').html('应付费用');
		jQuery('#type').val('支出项目');
		jQuery('#dialog_item').dialog('open');
		return false;
	});
	
});

	
function save_after(data,status){
	if(status == 1)
	location.reload();
}
	
function showinfo(itemID){
	ThinkAjax.myloading('resultdiv');
	jQuery.ajax({
		type:	"POST",
		url:	"<?php echo SITE_INDEX;?>Chanpin/getBaozhangitem/chanpinID/"+itemID,
		data:	"",
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',after_showinfo);
		}
	});
}


 function after_showinfo(data,status)
 {
	if(status == 1){
		if(data['type'] == '结算项目')
		jQuery('#type_shuoming').html('应收费用');
		if(data['type'] == '支出项目')
		jQuery('#type_shuoming').html('应付费用');
		jQuery('#title').val(data['title']);
		jQuery('#value').val(data['value']);
		jQuery('#method').val(data['method']);
		jQuery('#remark').val(data['remark']);
		jQuery('#chanpinID').val(data['chanpinID']);
		jQuery('#dialog_item').dialog('open');
	}
 }

	function doshenhe_baozhangitem(dotype,datatype,dataID,title){
		ThinkAjax.myloading('resultdiv');
		jQuery.ajax({
			type:	"POST",
			url:	SITE_INDEX+"Chanpin/doshenhe",
			data:	"dataID="+dataID+"&dotype="+dotype+"&datatype="+datatype+"&title="+title,
			success:function(msg){
				scroll(0,0);
				ThinkAjax.myAjaxResponse(msg,'resultdiv');
			}
		});
	}


 function deleteSystemItem(id)
 {
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/deleteBaozhangitem",
		data:	"chanpinID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',save_after);
		}
	});
	
 }

</script>