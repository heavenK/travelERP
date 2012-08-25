<?php if (!defined('THINK_PATH')) exit();?>        <style>
		#navtab_2 h3 { color:#0B578F}
		#navtab_3 h3 { color:#999}
		</style>

  <div id="leftColumn" style="margin-top:7px; width:150px;">
        <ul id="searchTabs" class="tablist tablist_2">
          <li><a id="shownavtab_1" <?php if($status == '准备' || !$status){ ?>class="current"<?php } ?> href="javascript:void(0)" onclick="shownavtab(1)">&nbsp;准备&nbsp;</a></li>
          <li><a id="shownavtab_2" <?php if($status == '在线'){ ?>class="current"<?php } ?> href="javascript:void(0)" onclick="shownavtab(2)">&nbsp;在线&nbsp;</a></li>
          <li><a id="shownavtab_3" <?php if($status == '截止'){ ?>class="current"<?php } ?> href="javascript:void(0)" onclick="shownavtab(3)">&nbsp;截止&nbsp;</a></li>
        </ul>
            
        <div id="navtab_1" class="leftList" <?php if($status != '准备' && $status){ ?>style="display:none;"<?php } ?>>
          <h3 style=" text-align:center; border:none">准备中的产品</h3>
          <h3><span>国内</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Dijie/index/status/准备/guojing/国内">&nbsp;<span>国内来团</span></a> </li>
          </ul>
          <h3><span>境外</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Dijie/index/status/准备/guojing/境外/kind/日本">&nbsp;<span>日本来团</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Dijie/index/status/准备/guojing/境外/kind/台湾">&nbsp;<span>台湾来团</span></a> </li>
          </ul>
        </div>
        
        <div id="navtab_2" class="leftList" <?php if($status != '在线'){ ?>style="display:none;"<?php } ?>>
          <h3 style=" text-align:center; border:none;">在线中的产品</h3>
          <h3><span>国内</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Dijie/index/status/在线/guojing/国内">&nbsp;<span>国内来团</span></a> </li>
          </ul>
          <h3><span>境外</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Dijie/index/status/在线/guojing/境外/kind/日本">&nbsp;<span>日本来团</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Dijie/index/status/在线/guojing/境外/kind/台湾">&nbsp;<span>台湾来团</span></a> </li>
          </ul>
        </div>
        
        <div id="navtab_3" class="leftList" <?php if($status != '截止'){ ?>style="display:none;"<?php } ?>>
          <h3 style=" text-align:center; border:none">已截止的产品</h3>
          <h3><span>国内</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Dijie/index/status/截止/guojing/国内">&nbsp;<span>国内来团</span></a> </li>
          </ul>
          <h3><span>境外</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Dijie/index/status/截止/guojing/境外/kind/日本">&nbsp;<span>日本来团</span></a> </li>
            <li> <a href="<?php echo SITE_INDEX;?>Dijie/index/status/截止/guojing/境外/kind/台湾">&nbsp;<span>台湾来团</span></a> </li>
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