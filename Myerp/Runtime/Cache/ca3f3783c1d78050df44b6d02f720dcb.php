<?php if (!defined('THINK_PATH')) exit();?><div id="leftColumn" style="margin-top:7px; width:148px;"><ul id="searchTabs" class="tablist tablist_2"><li style="margin-right:1px;"><a id="shownavtab_1" class="current" href="javascript:selectTabCSS('Calls|basic_search');" onmouseover="shownavtab(1)">&nbsp;准备&nbsp;</a></li><li style="margin-right:1px;"><a id="shownavtab_2" href="javascript:selectTabCSS('Calls|advanced_search');" onmouseover="shownavtab(2)">&nbsp;报名&nbsp;</a></li><li><a id="shownavtab_3" href="javascript:selectTabCSS('Calls|advanced_search');" onmouseover="shownavtab(3)">&nbsp;截止&nbsp;</a></li></ul><div id="navtab_1" class="leftList"><h3 style=" text-align:center; border:none">准备中的产品</h3><h3><span>国内/拼团</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>近郊游</span></a></li><li><a href="#">&nbsp;<span>长线游</span></a></li></ul><h3><span>国内/散客</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>全部</span></a></li><li><a href="#">&nbsp;<span>|---我爱中华</span></a></li><li><a href="#">&nbsp;<span>|---自由人</span></a></li><li><a href="#">&nbsp;<span>|---印象之旅</span></a></li><li><a href="#">&nbsp;<span>|---爱之旅</span></a></li><li><a href="#">&nbsp;<span>|---夏之旅</span></a></li><li><a href="#">&nbsp;<span>|---成都海悦</span></a></li><li><a href="#">&nbsp;<span>|---通话假期</span></a></li><li><a href="#">&nbsp;<span>|---西部国旅</span></a></li></ul><h3><span>国内</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li><li><a href="#">&nbsp;<span>机票</span></a></li><li><a href="#">&nbsp;<span>酒店</span></a></li></ul><h3><span>境外</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>海岛游</span></a></li><li><a href="#">&nbsp;<span>出境游</span></a></li><li><a href="#">&nbsp;<span>欧美澳非</span></a></li><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li></ul></div><div id="navtab_2" class="leftList" style="display:none"><h3 style=" text-align:center; border:none">报名中的产品</h3><h3><span>国内/拼团</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>近郊游</span></a></li><li><a href="#">&nbsp;<span>长线游</span></a></li></ul><h3><span>国内/散客</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>全部</span></a></li><li><a href="#">&nbsp;<span>|---我爱中华</span></a></li><li><a href="#">&nbsp;<span>|---自由人</span></a></li><li><a href="#">&nbsp;<span>|---印象之旅</span></a></li><li><a href="#">&nbsp;<span>|---爱之旅</span></a></li><li><a href="#">&nbsp;<span>|---夏之旅</span></a></li><li><a href="#">&nbsp;<span>|---成都海悦</span></a></li><li><a href="#">&nbsp;<span>|---通话假期</span></a></li><li><a href="#">&nbsp;<span>|---西部国旅</span></a></li></ul><h3><span>国内</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li><li><a href="#">&nbsp;<span>机票</span></a></li><li><a href="#">&nbsp;<span>酒店</span></a></li></ul><h3><span>境外</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>海岛游</span></a></li><li><a href="#">&nbsp;<span>出境游</span></a></li><li><a href="#">&nbsp;<span>欧美澳非</span></a></li><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li></ul></div><div id="navtab_3" class="leftList" style="display:none"><h3 style=" text-align:center; border:none">已截止的产品</h3><h3><span>国内/拼团</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>近郊游</span></a></li><li><a href="#">&nbsp;<span>长线游</span></a></li></ul><h3><span>国内/散客</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>全部</span></a></li><li><a href="#">&nbsp;<span>|---我爱中华</span></a></li><li><a href="#">&nbsp;<span>|---自由人</span></a></li><li><a href="#">&nbsp;<span>|---印象之旅</span></a></li><li><a href="#">&nbsp;<span>|---爱之旅</span></a></li><li><a href="#">&nbsp;<span>|---夏之旅</span></a></li><li><a href="#">&nbsp;<span>|---成都海悦</span></a></li><li><a href="#">&nbsp;<span>|---通话假期</span></a></li><li><a href="#">&nbsp;<span>|---西部国旅</span></a></li></ul><h3><span>国内</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li><li><a href="#">&nbsp;<span>机票</span></a></li><li><a href="#">&nbsp;<span>酒店</span></a></li></ul><h3><span>境外</span></h3><ul id="ul_shortcuts"><li><a href="#">&nbsp;<span>海岛游</span></a></li><li><a href="#">&nbsp;<span>出境游</span></a></li><li><a href="#">&nbsp;<span>欧美澳非</span></a></li><li><a href="#">&nbsp;<span>自由人</span></a></li><li><a href="#">&nbsp;<span>包团</span></a></li></ul></div></div><script>function shownavtab(s)
{
	if(s == 1){
		var divRili = document.getElementById('navtab_1'); 
		divRili.style.display = '';			
		divRili = document.getElementById('navtab_2'); 
		divRili.style.display = 'none';	
		divRili = document.getElementById('navtab_3'); 
		divRili.style.display = 'none';	
		$('#shownavtab_1').addClass('current');
		$('#shownavtab_2').removeClass('current');
		$('#shownavtab_3').removeClass('current');
	}
	if(s == 2){
		var divRili = document.getElementById('navtab_2'); 
		divRili.style.display = '';			
		divRili = document.getElementById('navtab_1'); 
		divRili.style.display = 'none';	
		divRili = document.getElementById('navtab_3'); 
		divRili.style.display = 'none';	
		$('#shownavtab_2').addClass('current');
		$('#shownavtab_1').removeClass('current');
		$('#shownavtab_3').removeClass('current');
	}
	if(s == 3){
		var divRili = document.getElementById('navtab_3'); 
		divRili.style.display = '';			
		divRili = document.getElementById('navtab_1'); 
		divRili.style.display = 'none';	
		divRili = document.getElementById('navtab_2'); 
		divRili.style.display = 'none';	
		$('#shownavtab_3').addClass('current');
		$('#shownavtab_1').removeClass('current');
		$('#shownavtab_2').removeClass('current');
	}
}


</script>