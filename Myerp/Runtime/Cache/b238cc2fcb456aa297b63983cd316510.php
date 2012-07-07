<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>

<div id="main">
  <div id="content" style="margin-left:0;">
  
      <?php if( $nowDir['title'] == '用户' || $nowDir['title'] == '系统管理'){ ?>
    <table cellspacing="0" cellpadding="0" width="100%" class="h3Row" style="margin-top:0px;">
      <tbody>
      <?php if( $nowDir['title'] == '用户'){ ?>
      	<tr><td width="20%" valign="bottom"><h3><?php echo ($navigation); ?></h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;"><?php echo ($nowDir['remark']); ?></td></tr>
      <?php }else{ ?>
      	<tr><td width="20%" valign="bottom"><h3>用户</h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;">在系统中创建，编辑，激活和取消激活用户. 创建和管理团队和角色, 包括模块-字段-访问水平.</td></tr>
      <?php } ?>
      </tbody>
    </table>
    <table class="other view">
      <tbody>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/Users.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/systemUser">用户管理</a></td>
          <td width="30%">管理用户账号,密码等信息</td>
        </tr>
      </tbody>
    </table>
      <?php } ?>
      
      
      <?php if( $nowDir['title'] == '系统工具' || $nowDir['title'] == '系统管理'){ ?>
    <table cellspacing="0" cellpadding="0" width="100%" class="h3Row" style="margin-top:0px;">
      <tbody>
      <?php if( $nowDir['title'] == '系统工具'){ ?>
      	<tr><td width="20%" valign="bottom"><h3><?php echo ($navigation); ?></h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;"><?php echo ($nowDir['remark']); ?></td></tr>
      <?php }else{ ?>
      	<tr><td width="20%" valign="bottom"><h3>系统工具</h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;">获取文档和执行管理员操作.</td></tr>
      <?php } ?>
      </tbody>
    </table>
    <table class="other view">
      <tbody>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/Administration.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/">系统工具</a></td>
          <td width="30%">管理用户账号和密码</td>
        </tr>
      </tbody>
    </table>
      <?php } ?>
      
      
      <?php if( $nowDir['title'] == '系统设置' || $nowDir['title'] == '系统管理'){ ?>
    <table cellspacing="0" cellpadding="0" width="100%" class="h3Row" style="margin-top:0px;">
      <tbody>
      <?php if( $nowDir['title'] == '系统设置'){ ?>
      	<tr><td width="20%" valign="bottom"><h3><?php echo ($navigation); ?></h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;"><?php echo ($nowDir['remark']); ?></td></tr>
      <?php }else{ ?>
      	<tr><td width="20%" valign="bottom"><h3>系统设置</h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;">配置系统-按照您组织机构的特殊性. 用户能添加和废弃一些本地设置在他们的操作页面.</td></tr>
      <?php } ?>
      </tbody>
    </table>
    <table class="other view">
      <tbody>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/icon_AdminThemes.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/category">分类</a></td>
          <td width="30%">将分类进行统一操作</td>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/icon_ProductCategories_32.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/systemOM">数据开放与管理</a></td>
          <td width="30%">管理产品等数据的开放对象和管理对象</td>
        </tr>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/Accounts.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/directory">目录设置</a></td>
          <td width="30%">目录导航</td>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/icon_Layouts.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/shenhe">审核流程</a></td>
          <td width="30%">设置报表和产品的审核流程</td>
        </tr>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/sugar_icon.ico">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/dataDictionary">数据字典</a></td>
          <td width="30%">数据字典</td>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/WorkFlow.gif">&nbsp;<a target="_blank" href="<?php echo ET_URL;?>rbac.php">RBAC设置</a></td>
          <td width="30%">数据字典</td>
        </tr>
      </tbody>
    </table>
      <?php } ?>
      
      
      <?php if( $nowDir['title'] == '站内信息' || $nowDir['title'] == '系统管理'){ ?>
    <table cellspacing="0" cellpadding="0" width="100%" class="h3Row" style="margin-top:0px;">
      <tbody>
      <?php if( $nowDir['title'] == '站内信息'){ ?>
      	<tr><td width="20%" valign="bottom"><h3><?php echo ($navigation); ?></h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;"><?php echo ($nowDir['remark']); ?></td></tr>
      <?php }else{ ?>
      	<tr><td width="20%" valign="bottom"><h3>站内信息</h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;">公告广播排团表等信息.</td></tr>
      <?php } ?>
      </tbody>
    </table>
    <table class="other view">
      <tbody>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/icon_SugarFeed.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/">站内信息</a></td>
          <td width="30%">把一些部门归为一类，对某类部门进行统一操作</td>
        </tr>
      </tbody>
    </table>
      <?php } ?>
      
      
      <?php if( $nowDir['title'] == '产品平移' || $nowDir['title'] == '系统管理'){ ?>
    <table cellspacing="0" cellpadding="0" width="100%" class="h3Row" style="margin-top:0px;">
      <tbody>
      <?php if( $nowDir['title'] == '产品平移'){ ?>
      	<tr><td width="20%" valign="bottom"><h3><?php echo ($navigation); ?></h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;"><?php echo ($nowDir['remark']); ?></td></tr>
      <?php }else{ ?>
      	<tr><td width="20%" valign="bottom"><h3>产品平移</h3></td></tr>
        <tr><td style="padding-top: 3px; padding-bottom: 5px;">公告广播排团表等信息.</td></tr>
      <?php } ?>
      </tbody>
    </table>
    <table class="other view">
      <tbody>
        <tr>
          <td width="20%" scope="row"><img border="0" width="16" height="16" align="absmiddle" src="<?php echo __PUBLIC__;?>/myerp/images/Backups.gif">&nbsp;<a href="<?php echo SITE_INDEX;?>SetSystem/">产品平移</a></td>
          <td width="30%">把一些部门归为一类，对某类部门进行统一操作</td>
        </tr>
      </tbody>
    </table>
      <?php } ?>
  </div>
</div>
<?php A("Index")->footer(); ?>