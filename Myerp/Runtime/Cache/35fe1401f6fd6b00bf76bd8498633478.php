<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>

<div id="main">
  <div id="content" style="margin-left:0;">

    <table cellspacing="0" cellpadding="0" width="100%" class="h3Row" style="margin-top:0px;">
      <tbody>
        <tr>
          <td width="20%" valign="bottom"><h3><?php echo ($navigation); echo ($datatitle); ?></h3></td>
        </tr>
        <tr>
          <td width="20%" valign="bottom"><h3><?php echo ($nowDir['remark']); ?></h3></td>
        </tr>
      </tbody>
    </table>
    
    <table class="other view">
      <tbody>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/icon_CampaignLog_32.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/dataDictionary/type/视频/version/full">视频</a></td>
          <td width="30%">视频</td>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/Documents_favico.png">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/dataDictionary/type/图片/version/full">图片</a></td>
          <td width="30%">图片</td>
        </tr>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/Trackers_favico.png">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/dataDictionary/type/主题">主题</a></td>
          <td width="30%">产品主题</td>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/list.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/liandong">地区联动</a></td>
          <td width="30%">地区联动</td>
        </tr>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/icon_email_folder_drafts.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/dataDictionary/type/成本">成本</a></td>
          <td width="30%">产品成本</td>
        </tr>
      </tbody>
    </table>
    
    
  </div>
</div>
<?php A("Index")->footer(); ?>

<script>

function addnew ()
{
	window.location.href="<?php echo SITE_INDEX;?>SetSystem/addCategory/type/部门/typeName/分类"; 
}

function addSystemDC (systemID)
{
	window.location.href="<?php echo SITE_INDEX;?>SetSystem/addSystemDC/systemID/"+systemID; 
}

</script>