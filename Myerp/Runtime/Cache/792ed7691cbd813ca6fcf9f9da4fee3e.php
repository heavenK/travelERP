<?php if (!defined('THINK_PATH')) exit();?>        <style>
		#navtab_2 h3 { color:#0B578F}
		#navtab_3 h3 { color:#999}
		</style>

  <div id="leftColumn" style="margin-top:7px; width:150px;">
        <ul id="searchTabs" class="tablist tablist_2">
          <li><a id="shownavtab_1" <?php if($status == '准备' || !$status){ ?>class="current"<?php } ?> href="javascript:void(0)" onclick="shownavtab(1)">&nbsp;准备&nbsp;</a></li>
          <li><a id="shownavtab_2" <?php if($status == '报名'){ ?>class="current"<?php } ?> href="javascript:void(0)" onclick="shownavtab(2)">&nbsp;报名&nbsp;</a></li>
          <li><a id="shownavtab_3" <?php if($status == '截止'){ ?>class="current"<?php } ?> href="javascript:void(0)" onclick="shownavtab(3)">&nbsp;截止&nbsp;</a></li>
        </ul>
        <div id="navtab_1" class="leftList" <?php if($status != '准备' && $status){ ?>style="display:none;"<?php } ?>>
          <h3 style=" text-align:center; border:none">准备中的产品</h3>
          <h3><span>国内/拼团</span><a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/status/准备">&nbsp;<span>全部</span></a></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/近郊游/status/准备">&nbsp;<span>近郊游</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/长线游/status/准备">&nbsp;<span>长线游</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/自由人/status/准备">&nbsp;<span>自由人</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/包团/status/准备">&nbsp;<span>包团</span></a> </li>
          </ul>
          <h3><span>境外</span><a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/status/准备">&nbsp;<span>全部</span></a></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/韩国/status/准备">&nbsp;<span>韩国</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/日本/status/准备">&nbsp;<span>日本</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/台湾/status/准备">&nbsp;<span>台湾</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/港澳/status/准备">&nbsp;<span>港澳</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/东南亚/status/准备">&nbsp;<span>东南亚</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/欧美岛/status/准备">&nbsp;<span>欧美岛</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/自由人/status/准备">&nbsp;<span>自由人</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/包团/status/准备">&nbsp;<span>包团</span></a> </li>
          </ul>
          <h3><span>散客（联合体提供）</span></h3>
          <ul id="ul_shortcuts">
            <?php foreach($bumenlist as $v){ ?>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/status/准备/departmentID/<?php echo ($v['systemID']); ?>">&nbsp;<span>|---<?php echo ($v['title']); ?></span></a> </li>
            <?php } ?>
          </ul>
        </div>
        <div id="navtab_2" class="leftList" <?php if($status != '报名'){ ?>style="display:none;"<?php } ?>>
          <h3 style=" text-align:center; border:none;">报名中的产品</h3>
          <h3><span>国内/拼团</span><a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/status/报名">&nbsp;<span>全部</span></a></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/近郊游/status/报名">&nbsp;<span>近郊游</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/长线游/status/报名">&nbsp;<span>长线游</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/自由人/status/报名">&nbsp;<span>自由人</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/包团/status/报名">&nbsp;<span>包团</span></a> </li>
          </ul>
          <h3><span>境外</span><a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/status/报名">&nbsp;<span>全部</span></a></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/韩国/status/报名">&nbsp;<span>韩国</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/日本/status/报名">&nbsp;<span>日本</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/台湾/status/报名">&nbsp;<span>台湾</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/港澳/status/报名">&nbsp;<span>港澳</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/东南亚/status/报名">&nbsp;<span>东南亚</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/欧美岛/status/报名">&nbsp;<span>欧美岛</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/自由人/status/报名">&nbsp;<span>自由人</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/包团/status/报名">&nbsp;<span>包团</span></a> </li>
          </ul>
          <h3><span>散客（联合体提供）</span></h3>
          <ul id="ul_shortcuts">
            <?php foreach($bumenlist as $v){ ?>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/status/报名/departmentID/<?php echo ($v['systemID']); ?>">&nbsp;<span>|---<?php echo ($v['title']); ?></span></a> </li>
            <?php } ?>
          </ul>
        </div>
        
        <div id="navtab_3" class="leftList" <?php if($status != '截止'){ ?>style="display:none;"<?php } ?>>
          <h3 style=" text-align:center; border:none">已截止的产品</h3>
          <h3><span>国内/拼团</span><a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/status/截止">&nbsp;<span>全部</span></a></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/近郊游/status/截止">&nbsp;<span>近郊游</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/长线游/status/截止">&nbsp;<span>长线游</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/自由人/status/截止">&nbsp;<span>自由人</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/国内/kind/包团/status/截止">&nbsp;<span>包团</span></a> </li>
          </ul>
          <h3><span>境外</span><a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/status/截止">&nbsp;<span>全部</span></a></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/韩国/status/截止">&nbsp;<span>韩国</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/日本/status/截止">&nbsp;<span>日本</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/台湾/status/截止">&nbsp;<span>台湾</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/港澳/status/截止">&nbsp;<span>港澳</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/东南亚/status/截止">&nbsp;<span>东南亚</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/欧美岛/status/截止">&nbsp;<span>欧美岛</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/自由人/status/截止">&nbsp;<span>自由人</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/guojing/境外/kind/包团/status/截止">&nbsp;<span>包团</span></a> </li>
          </ul>
          <h3><span>散客（联合体提供）</span></h3>
          <ul id="ul_shortcuts">
            <?php foreach($bumenlist as $v){ ?>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/index/status/截止/departmentID/<?php echo ($v['systemID']); ?>">&nbsp;<span>|---<?php echo ($v['title']); ?></span></a> </li>
            <?php } ?>
          </ul>
        </div>
    
  </div>

<script>
function shownavtab(s)
{
	if(s == 1){
		var divRili = document.getElementById('navtab_1'); 
		divRili.style.display = '';			
		divRili = document.getElementById('navtab_2'); 
		divRili.style.display = 'none';	
		divRili = document.getElementById('navtab_3'); 
		divRili.style.display = 'none';	
		jQuery('#shownavtab_1').addClass('current');
		jQuery('#shownavtab_2').removeClass('current');
		jQuery('#shownavtab_3').removeClass('current');
	}
	if(s == 2){
		var divRili = document.getElementById('navtab_2'); 
		divRili.style.display = '';			
		divRili = document.getElementById('navtab_1'); 
		divRili.style.display = 'none';	
		divRili = document.getElementById('navtab_3'); 
		divRili.style.display = 'none';	
		jQuery('#shownavtab_2').addClass('current');
		jQuery('#shownavtab_1').removeClass('current');
		jQuery('#shownavtab_3').removeClass('current');
	}
	if(s == 3){
		var divRili = document.getElementById('navtab_3'); 
		divRili.style.display = '';			
		divRili = document.getElementById('navtab_1'); 
		divRili.style.display = 'none';	
		divRili = document.getElementById('navtab_2'); 
		divRili.style.display = 'none';	
		jQuery('#shownavtab_3').addClass('current');
		jQuery('#shownavtab_1').removeClass('current');
		jQuery('#shownavtab_2').removeClass('current');
	}
}


</script>