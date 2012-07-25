<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>

<div id="main">

  <div id="content" style="margin-left:5px; padding-left:0px; border-left:none">
  
    <?php A("Chanpin")->header_chanpin(); ?>
   
    
<form name="form" method="post" id="form" action="<?php echo SITE_INDEX;?>Chanpin/dopostxingcheng/">
  <input type="hidden" name="ajax" value="1"> <!--ajax提示-->
  <input type="hidden" name="tianshu" value="<?php echo ($chanpin['xianlu']['tianshu']); ?>"> 
  <input type="hidden" name="parentID" value="<?php echo ($chanpin['chanpinID']); ?>"> 
    
    <?php $count = 0 ;$t =-1;while ($count < $chanpin['xianlu']['tianshu']) {$t++; ?>
	<input type="hidden" name="chanpinID[]" value="<?php echo ($xingcheng[$count]['chanpinID']); ?>" />
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
//	if(status == 1){
//			window.location.href='<?php echo SITE_INDEX;?>Chanpin/xingcheng/chanpinID/'+data['chanpinID'];
//	}
}
</script>