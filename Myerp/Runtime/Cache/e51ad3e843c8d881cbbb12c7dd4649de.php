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
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/Holidays.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/systemOM/datatype/线路">线路</a></td>
          <td width="30%">线路的开放与管理</td>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/icon_Activities.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/systemOM/datatype/分类">分类数据</a></td>
          <td width="30%">管理产品等数据的开放对象和管理对象</td>
        </tr>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/icon_email_mark.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/systemOM/datatype/报账单">报账单</a></td>
          <td width="30%">报账单的开放与管理</td>
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