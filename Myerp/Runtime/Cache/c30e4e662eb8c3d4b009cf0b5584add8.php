<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>

<div id="main">

  <div id="content" style="margin-left:5px; padding-left:0px; border-left:none">
  
    
	<script type="text/javascript">
    var SITE_INDEX = '<?php echo SITE_INDEX;?>';
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
    
    
    
   
    
<form name="form" method="post" id="form" action="<?php echo SITE_INDEX;?>Chanpin/dopostxingcheng/">
  <input type="hidden" name="ajax" value="1"> <!--ajax提示-->
  <input type="hidden" name="tianshu" value="<?php echo ($chanpin['xianlu']['tianshu']); ?>"> <!--ajax提示-->
  <input type="hidden" name="chanpinID" value="<?php echo ($chanpin['chanpinID']); ?>"> <!--ajax提示-->
    
    <?php $count = 0 ;$t =-1;while ($count < $chanpin['xianlu']['tianshu']) {$t++; ?>
	<input type="hidden" name="xingchengID[]" value="<?php echo ($xingcheng[$count]['xingchengID']); ?>" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <th align="left" colspan="8"> <h4>行程：第<?php echo ($t+1); ?>天</h4>
          </th>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px;"> 住宿: </td>
          <td valign="top" scope="row">
          <input type="text" name="place[]" value="<?php echo ($xingcheng[$count]['place']); ?>" style="width:200px;"/>
          </td>
          <td valign="top" scope="row" style="min-width:100px;"> 餐饮: </td>
          <td valign="top" scope="row">
              <input type="checkbox" name="chanyin<?php echo ($count); ?>[]" value="早餐"/ <?php if(strstr($xingcheng[$count]['chanyin'],'早餐')){ ?>checked="checked"<?php } ?> /> <label style=" margin:0 4px 0 4px">早餐</label>
              <input type="checkbox" name="chanyin<?php echo ($count); ?>[]" value="午餐"/ <?php if(strstr($xingcheng[$count]['chanyin'],'午餐')){ ?>checked="checked"<?php } ?> /> <label style=" margin:0 4px 0 4px">午餐</label>
              <input type="checkbox" name="chanyin<?php echo ($count); ?>[]" value="晚餐"/ <?php if(strstr($xingcheng[$count]['chanyin'],'晚餐')){ ?>checked="checked"<?php } ?> /> <label style=" margin:0 4px 0 4px">晚餐</label>
          </td>
        </tr>
        
        <tr>
          <td valign="top" scope="row" style="min-width:100px;"> 交通: </td>
          <td valign="top" scope="row">
              <input type="checkbox" name="tools<?php echo ($count); ?>[]" value="飞机"/ <?php if(strstr($xingcheng[$count]['tools'],'飞机')){ ?>checked="checked"<?php } ?> /> <label style=" margin:0 4px 0 4px">飞机</label>
              <input type="checkbox" name="tools<?php echo ($count); ?>[]" value="火车"/ <?php if(strstr($xingcheng[$count]['tools'],'火车')){ ?>checked="checked"<?php } ?> /> <label style=" margin:0 4px 0 4px">火车</label>
              <input type="checkbox" name="tools<?php echo ($count); ?>[]" value="轮船"/ <?php if(strstr($xingcheng[$count]['tools'],'轮船')){ ?>checked="checked"<?php } ?> /> <label style=" margin:0 4px 0 4px">轮船</label>
              <input type="checkbox" name="tools<?php echo ($count); ?>[]" value="汽车"/ <?php if(strstr($xingcheng[$count]['tools'],'汽车')){ ?>checked="checked"<?php } ?> /> <label style=" margin:0 4px 0 4px">汽车</label>
          </td>
        </tr>
        
        <tr>
          <td valign="top" colspan="4" scope="row">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
              <tbody>
                <tr>
                  <td valign="top">
                        <fieldset style="border:#CBDAE6 1px solid">
                          <legend>内容</legend>
                          <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                            <tbody>
                              <tr>
                                <td>
                                <textarea style="width:99%; resize:none" rows="6" id="content<?php echo ($count); ?>" name="content[]"><?php echo ($xingcheng[$count]['content']); ?></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </fieldset>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        
      </tbody>
    </table>
	<?php $count++;} ?>
    
    
    
    
</form>
    
  </div>
</div>

<?php A("Index")->footer(); ?>

<script>
function save(){
	ThinkAjax.sendForm('form','<?php echo SITE_INDEX;?>Chanpin/dopostxingcheng/',doComplete,'resultdiv');
}
function doComplete(data,status){
	if(status == 1){
			window.location.href='<?php echo SITE_INDEX;?>Chanpin/xingcheng/chanpinID/'+data['chanpinID'];
	}
}
</script>