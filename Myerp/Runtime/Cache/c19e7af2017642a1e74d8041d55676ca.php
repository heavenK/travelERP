<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    var SITE_INDEX = '<?php echo SITE_INDEX;?>';
    var chanpinID = '<?php echo ($chanpinID); ?>';
	var title =  '<?php echo ($datatitle); ?>';
	function doshenhe(dotype){
		ThinkAjax.myloading('resultdiv');
		var dataID = chanpinID;
		var datatype = '地接';
		jQuery.ajax({
			type:	"POST",
			url:	SITE_INDEX+"Chanpin/doshenhe",
			data:	"dataID="+dataID+"&dotype="+dotype+"&datatype="+datatype+"&title="+title,
			success:function(msg){
				ThinkAjax.myAjaxResponse(msg,'resultdiv',shenhe_after);
			}
		});
	}
	
	function shenhe_after(data,status){
		if(status == 1 && data['status'] == '批准')
		location.reload();
	}
	
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
  <h3 style=""><?php echo ($navigation); echo ($datatitle); ?></h3>
  <span style="margin-top:10px;"> <img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a> <a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a> </span> </div>
<?php if($chanpinID){ ?>
<div id="mysearchdiv" style="margin-bottom:10px;">
  <ul id="searchTabs" class="tablist tablist_2">
    <li> <a 
      <?php if($nowDir['title'] == '接团基本信息'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Dijie/fabu/chanpinID/<?php echo ($chanpinID); ?>">基本信息</a> </li>
    <li> <a 
      <?php if($nowDir['title'] == '日程安排'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Dijie/xingcheng/chanpinID/<?php echo ($chanpinID); ?>">日程安排</a> </li>
    <li> <a 
      <?php if($nowDir['title'] == '成本及报价'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Dijie/chengbenshoujia/chanpinID/<?php echo ($chanpinID); ?>">成本及报价</a> </li>
    <?php if($show_chengtuan === true || $baozhangID){ ?>
    <li> <a 
      <?php if($markpos == '单项服务及补账' || $markpos == '单项服务'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Dijie/djtuandanxiangfuwu/chanpinID/<?php echo ($chanpinID); ?>">订房及其他服务</a> </li>
    <li> <a 
      <?php if($markpos == '应收及应付'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Dijie/djtuanxiangmu/chanpinID/<?php echo ($chanpinID); ?>">应收及应付</a> </li>
    <li> <a 
      <?php if($markpos == '团队报账单'){ ?>
      class="current"
      <?php } ?>
      href="<?php echo SITE_INDEX;?>Dijie/djtuanbaozhang/type/团队报账单/chanpinID/<?php echo ($chanpinID); ?>">团队报账单</a> </li>
      
    <?php } ?>
  </ul>
</div>
<?php }elseif(!$baozhangID){ ?>
<div id="mysearchdiv" style="margin-bottom:10px;">
  <ul id="searchTabs" class="tablist tablist_2">
    <li> <a 
      <?php if($nowDir['title'] == '接团基本信息'){ ?>
      class="current"
      <?php } ?>
      href="javascript:ajaxalert('请先创建基本信息')">基本信息</a> </li>
    <li> <a 
      <?php if($nowDir['title'] == '日程安排'){ ?>
      class="current"
      <?php } ?>
      href="javascript:ajaxalert('请先创建基本信息')">日程安排</a> </li>
    <li> <a 
      <?php if($nowDir['title'] == '成本及报价'){ ?>
      class="current"
      <?php } ?>
      href="javascript:ajaxalert('请先创建基本信息')">成本及报价</a> </li>
  </ul>
</div>
<?php } ?>
<div id="resultdiv" class="resultdiv"></div>
<div id="resultdiv_2" class="resultdiv"></div>
<div class="buttons">
  <input type="button" value="审核记录" name="button" class="button primary" style="float:right">
  <?php if('单项服务' != $markpos && '团队报账单' != $markpos){ ?>
      <?php $taskom = A("Method")->_checkOMTaskShenhe($chanpinID,'地接'); if(false !== $taskom){ if(cookie('show_action') == '批准'){ ?>
      <input type="button" style="float:right" value=" <?php echo cookie('show_word'); ?>成团 " name="button" onclick="doshenhe('检出');">
      <?php }if(cookie('show_action') == '申请'){ ?>
      <input type="button" style="float:right" value=" <?php echo cookie('show_word'); ?>成团 " name="button" onclick="doshenhe('申请');">
      <?php }}if(A("Method")->checkshenheback($chanpinID,'地接')){ ?>
      <input type="button" style="float:right" value=" 成团回退 " name="button" onclick="shenhe_back(<?php echo ($chanpinID); ?>,'地接');">
	  <?php } ?>
  <?php } ?>
  
  <?php if('接团基本信息' == $nowDir['title']){ ?>
  <input type="button" value="保存" name="button" class="button primary" onclick="if(CheckForm('form','resultdiv_2')) save();">
  <?php } ?>
  <?php if('日程安排' == $nowDir['title']){ ?>
  <input type="button" value="保存" name="button" class="button primary" onClick="save();">
  <?php } ?>
  <?php if('成本及报价' == $nowDir['title']){ ?>
  <input type="button" value="保存" name="button" class="button primary" onClick="save();">
  <?php } ?>
  
  
  <?php if('单项服务及补账' == $markpos){ ?>
  <input type="button" value="添加订房结算报告" name="button" class="button primary" id="dingfang_create">
  <input type="button" value="+交通" name="button" class="button primary" id="jiaotong_create">
  <input type="button" value="+订餐" name="button" class="button primary" id="dingcan_create">
  <input type="button" value="+门票" name="button" class="button primary" id="menpiao_create">
  <input type="button" value="+导游" name="button" class="button primary" id="daoyou_create">
  <input type="button" value="+补账" name="button" class="button primary" id="buzhang_create">
  <?php } ?>
  <?php if('单项服务' == $markpos || '团队报账单' == $markpos){ ?>
  <input type="button" value=" 保存 " name="button" class="button primary" onclick="save_baozhang();">
  <input type="button" value="导出Word（普通）" name="button" class="button primary" onclick="exports()">
  <input type="button" value=" 计调打印 " name="button" class="button primary" onclick="doprint('计调打印');">
  <input type="button" value=" 打印 " name="button" class="button primary" onclick="doprint('打印');">
      <?php if('单项服务' == $markpos) $taskom = A("Method")->_checkOMTaskShenhe($baozhangID,'报账单'); if(false !== $taskom){ if(cookie('show_action') == '批准'){ ?>
      <input type="button" style="float:right" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('检出','报账单',<?php echo ($baozhangID); ?>,'<?php echo ($baozhang[title]); ?>');">
      <?php }if(cookie('show_action') == '申请'){ ?>
      <input type="button" style="float:right" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('申请','报账单',<?php echo ($baozhangID); ?>,'<?php echo ($baozhang[title]); ?>');">
      <?php }}if(A("Method")->checkshenheback($baozhangID,'报账单')){ ?>
      <input type="button" style="float:right" value=" 审核回退 " name="button" onclick="shenhe_back(<?php echo ($baozhangID); ?>,'报账单');">
	  <?php } ?>
  <?php } ?>
  <?php if('应收及应付' == $markpos){ ?>
  <input type="button" value=" 添加应收项目 " name="button" class="button primary" id="yingshuo_create">
  <input type="button" value=" +应付项目 " name="button" class="button primary" id="yingfu_create">
  <?php } ?>
  
  
</div>