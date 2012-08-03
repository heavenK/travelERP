<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    var SITE_INDEX = '<?php echo SITE_INDEX;?>';
    var chanpinID = '<?php echo ($chanpinID); ?>';
	function ajaxalert(title){
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+title+'</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
	}
    </script>

<div class="moduleTitle" style="margin-bottom:10px;">
  <h3 style=""><?php echo ($navigation); ?> > <?php echo ($markpos); echo ($datatitle); ?></h3>
  <span style="margin-top:10px;"> <img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a> <a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a> </span> </div>
<div id="mysearchdiv" style="margin-bottom:10px;">
  <ul id="searchTabs" class="tablist tablist_2">
    <li> <a 
      <?php if($markpos == '基本信息'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/zituanxinxi/chanpinID/<?php echo ($chanpinID); ?>">基本信息</a> </li>
    <li> <a 
      <?php if($markpos == '子团订单'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/zituandingdan/chanpinID/<?php echo ($chanpinID); ?>">子团订单</a> </li>
    <li> <a 
      <?php if($markpos == '团员名单'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/zituantuanyuan/chanpinID/<?php echo ($chanpinID); ?>">团员名单</a> </li>
    <li> <a 
      <?php if($markpos == '分房安排'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/zituanfenfang/chanpinID/<?php echo ($chanpinID); ?>">分房安排</a> </li>
    <li> <a 
      <?php if($markpos == '接待计划'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/zituanplan/marktype/接待计划/chanpinID/<?php echo ($chanpinID); ?>">接待计划</a> </li>
    <li> <a 
      <?php if($markpos == '出团通知'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/zituanplan/marktype/出团通知/chanpinID/<?php echo ($chanpinID); ?>">出团通知</a> </li>
    <li> <a 
      <?php if($markpos == '单项服务及补账' || $markpos == '单项服务'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Chanpin/zituandanxiangfuwu/chanpinID/<?php echo ($chanpinID); ?>">单项服务及补账</a> </li>
  </ul>
</div>
<div id="resultdiv" class="resultdiv"></div>
<div id="resultdiv_2" class="resultdiv"></div>
<div class="buttons">
  <?php if('基本信息' == $markpos){ ?>
  <input type="button" value="保存" name="button" class="button primary" onClick="save();">
  <?php } ?>
  <?php if('子团订单' == $markpos){ ?>
  <input type="button" value="添加订单" name="button" class="button primary" onClick="baoming();">
  <?php } ?>
  <?php if('团员名单' == $markpos){ ?>
  <input type="button" value="导出Word（旅游局格式）" name="button" class="button primary" onClick="exports('<?php echo ($chanpinID); ?>','格式1');">
  <input type="button" value="导出Word（普通）" name="button" class="button primary" onClick="exports('<?php echo ($chanpinID); ?>','格式2');">
  <input type="button" value="导出Excel（普通）" name="button" class="button primary" onClick="exports('<?php echo ($chanpinID); ?>','格式3');">
  <?php } ?>
  <?php if('分房安排' == $markpos){ ?>
  <input type="button" value="创建房间" name="button" class="button primary" id="room_create">
  <input type="button" value="导出Word（普通）" name="button" class="button primary" onclick="exports('<?php echo ($chanpinID); ?>')">
  <?php } ?>
  <?php if('接待计划' == $markpos || '出团通知' == $markpos){ ?>
  <input type="button" value=" 保存 " name="button" class="button primary" onclick="save()">
  <input type="button" value=" 发布 " name="button" class="button primary" onclick="dofabu('<?php echo ($chanpinID); ?>')">
  <input type="button" value="导出Word（普通）" name="button" class="button primary" onclick="exports('<?php echo ($chanpinID); ?>')">
  <?php } ?>
  <?php if('单项服务及补账' == $markpos){ ?>
  <input type="button" value=" 添加签证结算报告 " name="button" class="button primary" id="qianzheng_create">
  <input type="button" value=" +机票结算报告 " name="button" class="button primary" id="jipiao_create">
  <input type="button" value=" +订房结算报告 " name="button" class="button primary" id="dingfang_create">
  <input type="button" value=" 添加补账 " name="button" class="button primary" id="buzhang_create">
  <?php } ?>
  <?php if('单项服务' == $markpos){ ?>
  <input type="button" value=" 保存 " name="button" class="button primary" id="qianzheng_create" onclick="save_baozhang();">
  <input type="button" value="导出Word（普通）" name="button" class="button primary" onclick="exports()">
  <input type="button" value=" 计调打印 " name="button" class="button primary" onclick="doprint('计调打印');">
  <input type="button" value=" 打印 " name="button" class="button primary" onclick="doprint('打印');">
  
  <?php $taskom = A("Method")->_checkDataShenheOM($baozhangID,'报账单'); if(false !== $taskom){ ?>
  <input type="button" style="float:right" value=" 批准 " name="button" onclick="doshenhe_baozhangitem('检出','报账单',<?php echo ($baozhangID); ?>,'<?php echo ($baozhang[title]); ?>');">
  <?php } ?>
  <?php if($shenqing_baozhangdan){ ?>
  <input type="button" style="float:right" value="申请审核" name="button" onclick="doshenhe_baozhangitem('申请','报账单',<?php echo ($baozhangID); ?>,'<?php echo ($baozhang[title]); ?>');">
  <?php } ?>
  <?php if($shenqing_baozhangdan2){ ?>
  <input type="button" style="float:right" value=" 批准 " name="button" onclick="doshenhe_baozhangitem('申请','报账单',<?php echo ($baozhangID); ?>,'<?php echo ($baozhang[title]); ?>');">
  <?php } ?>
  
  <?php } ?>
</div>