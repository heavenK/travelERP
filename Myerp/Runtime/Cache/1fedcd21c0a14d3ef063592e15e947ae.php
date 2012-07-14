<?php if (!defined('THINK_PATH')) exit();?>
	<script type="text/javascript">
    var SITE_INDEX = '<?php echo SITE_INDEX;?>';
    var chanpinID = '<?php echo ($chanpinID); ?>';
	var title =  '<?php echo ($chanpin[xianlu][title]); ?>';
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
    </script>
    <div class="moduleTitle" style="margin-bottom:10px;">
      <h3 style=""><?php echo ($navigation); echo ($datatitle); ?></h3>
      <span style="margin-top:10px;"> 
      <img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a> <a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a> 
      </span> 
    </div>
    
    <div id="mysearchdiv" style="margin-bottom:10px;">
      <ul id="searchTabs" class="tablist tablist_2">
        <li> <a <?php if($nowDir['title'] == '基本信息'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/fabu/chanpinID/<?php echo ($chanpinID); ?>">基本信息</a> </li>
        <li> <a <?php if($nowDir['title'] == '子团管理'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/zituan/chanpinID/<?php echo ($chanpinID); ?>">子团管理</a> </li>
        <li> <a <?php if($nowDir['title'] == '行程'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/xingcheng/chanpinID/<?php echo ($chanpinID); ?>">&nbsp;&nbsp;行&nbsp;&nbsp;程&nbsp;&nbsp;</a> </li>
        <li> <a <?php if($nowDir['title'] == '成本售价'){ ?> class="current" <?php } ?> href="<?php echo SITE_INDEX;?>Chanpin/chengbenshoujia/chanpinID/<?php echo ($chanpinID); ?>">成本售价</a> </li>
      </ul>
    </div>
    
    <div id="resultdiv" class="resultdiv"></div>
    <div id="resultdiv_2" class="resultdiv"></div>
    
      <div class="buttons">
        <input type="button" value="审核失败记录" name="button" class="button primary" style="float:right">
      <?php if($root_shenqing){ ?>
        <input type="submit" value="申请审核" name="button" class="button primary" style="float:right" onclick="doshenhe('申请');">
        <?php } ?>
      <?php if($root_shenhe){ ?>
        <input type="submit" value=" 批准 " name="button" class="button primary" style="float:right" onclick="doshenhe('检出');">
        <?php } ?>
      <?php if('基本信息' == $nowDir['title']){ ?>
        <input type="button" value="保存" name="button" class="button primary" onclick="if(CheckForm('form','resultdiv_2')) save();">
        <?php } ?>
      <?php if('行程' == $nowDir['title']){ ?>
      <input type="button" value="保存" name="button" class="button primary" onClick="save();">
        <?php } ?>
      </div>