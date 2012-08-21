<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckfinder/ckfinder.js"></script>
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
        <li style="color:#FFF; background:#4E8CCF">签证结算报告</li>
      </ul>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:20px;">
      <tbody>
        <tr height="20">
          <th scope="col" nowrap="nowrap" style="min-width:200px;width:200px;"><div style=" background:#090; color:#FFF"> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 审核阶段 </div></th>
		  <th scope="col" nowrap="nowrap" style="min-width:50px;width:50px;"><div> 人数 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px; width:10%"><div> 操作 </div></th>
        </tr>
        <?php foreach($baozhanglist as $vol){ if($vol['type'] != '签证') continue; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['renshu']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>);">
              <input type="button" value="删除" name="button" class="button primary" onClick="deletebaozhang(<?php echo ($vol['chanpinID']); ?>);" >
            </td>
          </tr>
        <?php } ?>
        </tbody>
    </table>
    
    
      
      
    <div id="mysearchdiv" style="margin-bottom:10px;">
      <ul id="searchTabs" class="tablist " style="border-top:#4E8CCF">
        <li style="color:#FFF; background:#4E8CCF">机票结算报告</li>
      </ul>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:20px;">
      <tbody>
        <tr height="20">
          <th scope="col" nowrap="nowrap" style="min-width:200px;width:200px;"><div style=" background:#090; color:#FFF"> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 审核阶段 </div></th>
		  <th scope="col" nowrap="nowrap" style="min-width:50px;width:50px;"><div> 人数 </div></th>
		  <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 航班号 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px; width:10%"><div> 操作 </div></th>
        </tr>
        <?php foreach($baozhanglist as $vol){ if($vol['type'] != '机票') continue; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['renshu']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['hangbanhao']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>);">
              <input type="button" value="删除" name="button" class="button primary" onClick="deletebaozhang(<?php echo ($vol['chanpinID']); ?>);" >
            </td>
          </tr>
        <?php } ?>
        </tbody>
    </table>
      
    <div id="mysearchdiv" style="margin-bottom:10px;">
      <ul id="searchTabs" class="tablist " style="border-top:#4E8CCF">
        <li style="color:#FFF; background:#4E8CCF">订房结算报告</li>
      </ul>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:20px;">
      <tbody>
        <tr height="20">
          <th scope="col" nowrap="nowrap" style="min-width:200px;width:200px;"><div style=" background:#090; color:#FFF"> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 审核阶段 </div></th>
		  <th scope="col" nowrap="nowrap" style="min-width:50px;width:50px;"><div> 人数 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:150px;width:150px;"><div> 酒店名称 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 联系电话 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px; width:10%"><div> 操作 </div></th>
        </tr>
        <?php foreach($baozhanglist as $vol){ if($vol['type'] != '订房') continue; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['renshu']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['hotel']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['hoteltelnum']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>);">
              <input type="button" value="删除" name="button" class="button primary" onClick="deletebaozhang(<?php echo ($vol['chanpinID']); ?>);" >
            </td>
          </tr>
        <?php } ?>
        </tbody>
    </table>
    
    
    <div id="mysearchdiv" style="margin-bottom:10px;">
      <ul id="searchTabs" class="tablist " style="border-top:#4E8CCF">
        <li style="color:#FFF; background:#4E8CCF">补账</li>
      </ul>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:20px;">
      <tbody>
        <tr height="20">
          <th scope="col" nowrap="nowrap" style="min-width:200px;width:200px;"><div style=" background:#090; color:#FFF"> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;width:100px;"><div> 审核阶段 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px; width:10%"><div> 操作 </div></th>
        </tr>
        <?php foreach($baozhanglist as $vol){ if($vol['type'] != '补账') continue; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>);">
              <input type="button" value="删除" name="button" class="button primary" onClick="deletebaozhang(<?php echo ($vol['chanpinID']); ?>);" >
            </td>
          </tr>
        <?php } ?>
        </tbody>
    </table>
      
  </div>
</div>
<?php A("Index")->footer(); ?>


<div id="dialog_qianzheng" title="添加签证结算报告" style="background:#FFF">
<form id="form_qianzheng" id="form_qianzheng" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="签证" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row"><input name="renshu" type="text" check="^\S+$" warning="人数不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<div id="dialog_jipiao" title="添加机票结算报告" style="background:#FFF">
<form id="form_jipiao" id="form_jipiao" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="机票" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row" colspan="3"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row"><input name="renshu" type="text" style="width:100%" check="^\S+$" warning="人数号不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 航班号: </td>
          <td valign="top" scope="row"><input name="hangbanhao" type="text" style="width:100%" check="^\S+$" warning="航班号不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 始发地: </td>
          <td valign="top" scope="row"><input name="shifadi" type="text" style="width:100%" ></td>
          <td valign="top" scope="row" style="width:80px;"> 目的地: </td>
          <td valign="top" scope="row"><input name="mudidi" type="text" style="width:100%" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 起飞时间: </td>
          <td valign="top" scope="row"><input name="leavetime" type="text" style="width:100%" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" ></td>
          <td valign="top" scope="row" style="width:80px;"> 抵达时间: </td>
          <td valign="top" scope="row"><input name="arrivetime" type="text" style="width:100%" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<div id="dialog_dingfang" title="添加订房结算报告" style="background:#FFF">
<form id="form_dingfang" id="form_dingfang" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="订房" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row" colspan="3"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row"><input name="renshu" type="text" style="width:100%" check="^\S+$" warning="人数不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row"></td>
          <td valign="top" scope="row"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 酒店名称: </td>
          <td valign="top" scope="row"><input name="hotel" type="text" style="width:100%" check="^\S+$" warning="酒店名称不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 联系电话: </td>
          <td valign="top" scope="row"><input name="hoteltelnum" type="text" style="width:100%" check="^\S+$" warning="联系电话不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 订房时间: </td>
          <td valign="top" scope="row"><input name="ordertime" type="text" style="width:100%" onfocus="WdatePicker()" check="^\S+$" warning="订房时间不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 结算时间: </td>
          <td valign="top" scope="row"><input name="jiesuantime" type="text" style="width:100%" onfocus="WdatePicker()" check="^\S+$" warning="结算时间不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<div id="dialog_buzhang" title="添加补账" style="background:#FFF">
<form id="form_buzhang" id="form_buzhang" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="补账" />
<input type="hidden" name="renshu" value="0" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
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
	jQuery('#dialog_qianzheng').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_qianzheng','resultdiv_2'))
				ThinkAjax.sendForm('form_qianzheng','<?php echo SITE_INDEX;?>Chanpin/dopost_zituanbaozhang/',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_jipiao').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_jipiao','resultdiv_2'))
				ThinkAjax.sendForm('form_jipiao','<?php echo SITE_INDEX;?>Chanpin/dopost_zituanbaozhang/',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_dingfang').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_dingfang','resultdiv_2'))
				ThinkAjax.sendForm('form_dingfang','<?php echo SITE_INDEX;?>Chanpin/dopost_zituanbaozhang/',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_buzhang').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_buzhang','resultdiv_2'))
				ThinkAjax.sendForm('form_buzhang','<?php echo SITE_INDEX;?>Chanpin/dopost_zituanbaozhang/',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	
	
	// Dialog Link
	jQuery('#qianzheng_create').click(function(){
		jQuery('#dialog_qianzheng').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#jipiao_create').click(function(){
		jQuery('#dialog_jipiao').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#dingfang_create').click(function(){
		jQuery('#dialog_dingfang').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#buzhang_create').click(function(){
		jQuery('#dialog_buzhang').dialog('open');
		return false;
	});
	
	
});

	
	function save_after(data,status){
		if(status == 1)
		location.reload();
	}
	
	
	function showinfo(baozhangID){
		window.location = '<?php echo SITE_INDEX;?>Chanpin/zituanbaozhang/chanpinID/<?php echo ($chanpinID); ?>/baozhangID/'+baozhangID;
	}
	
	function deletebaozhang(baozhangID){
		window.location = '<?php echo SITE_INDEX;?>Chanpin/deleteBaozhang/chanpinID/'+baozhangID;
		
		
		
	}
	
</script>