<?php if (!defined('THINK_PATH')) exit();?>
<?php A("Index")->showheader(); ?>

<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.min.js" language="javascript"></script>
<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/Chanpin/xianlu.js"></script>
<style>
.mytem td { border:none}
.list_new tr td {
	padding: 0px 8px 0px 5px !important;
	vertical-align: middle;
}
</style>
<div id="main">

  <div id="content" style="margin-left:5px; padding-left:0px; border-left:none">
  
            <div id="resultdiv" class="resultdiv"></div>
            <div id="resultdiv_2" class="resultdiv"></div>
            
                
    <div class="moduleTitle" style="margin-bottom:10px;">
      <h2 style="margin-top:10px;"><?php echo ($navigation); echo ($datatitle); ?></h2>
      <div style="float:left; margin-left:50px; margin-top:6px;">
          <span id="show_link_insideview"  <?php if(!cookie('closesearch')) echo 'style="display:none"'; ?>> 
          <a href="javascript:void(0);" onclick="showmysearchdiv(1)"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/insideview_collapsed.png"></a> 
          </span> 
          <span id="hide_link_insideview"  <?php if(cookie('closesearch')) echo 'style="display:none"'; ?>> 
          <a href="javascript:void(0);" onclick="showmysearchdiv(2)"><img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/insideview_expanded.png"></a> 
          </span> 
      </div>
      <span style="margin-top:10px;">
      <img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助"></a> <a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a>
      </span>
    </div>
    
    <div id="mysearchdiv"  <?php if(cookie('closesearch')) echo 'style="display:none"'; ?> >
        <ul id="searchTabs" class="tablist">
          <li>
              <a id="searchtab_1" class="current" href="javascript:selectTabCSS('Calls|basic_search');" onclick="showsearch(1)">基本查找</a>
          </li>
          <li>
              <a id="searchtab_2" href="javascript:selectTabCSS('Calls|advanced_search');" onclick="showsearch(2)">高级查找</a>
          </li>
        </ul>
        
        <div class="search_form" id="searchdiv_1" style="margin-bottom:0px;">
              <div class="edit view search ">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td scope="row" nowrap="nowrap"> 名称 </td>
                          <td nowrap="nowrap"><input type="text" name="title" id="title" value="<?php echo ($title); ?>"></td>
                          <td scope="row" nowrap="nowrap"> 编号 </td>
                          <td nowrap="nowrap"><input type="text" name="bianhao" id="bianhao" value="<?php echo ($bianhao); ?>"></td>
                          <td scope="row" nowrap="nowrap"> 团期 </td>
                          <td nowrap="nowrap">
                          <input type="text" onfocus="WdatePicker()" id="chufariqi" name="chufariqi" value="<?php echo ($chufariqi); ?>" >
                      </tbody>
                    </table>
                </div>
              <input title="查找" class="button" type="button" value=" 查找 " onclick="dosearch();">&nbsp;
              <input title="清除" class="button" type="button" value=" 清除 " onclick="clearsearch();">
        </div>
        
        <div class="search_form" id="searchdiv_2" style="display:none;margin-bottom:0px;">
              <div class="edit view search ">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td scope="row" nowrap="nowrap"> 名称 </td>
                          <td nowrap="nowrap"><input type="text" name="title"></td>
                          <td scope="row" nowrap="nowrap"> 团期 </td>
                          <td nowrap="nowrap">
                          <input type="text" onfocus="WdatePicker()" id="chufariqi" name="chufariqi" value="<?php echo ($chufariqi); ?>">
                          <span>--</span>
                          <input type="text" onfocus="WdatePicker()" id="jiezhiriqi" name="jiezhiriqi" value="<?php echo ($jiezhiriqi); ?>"></td>
                          <td scope="row" nowrap="nowrap"> 员工 </td>
                          <td nowrap="nowrap"><input type="text" id="user_name" value="<?php echo ($user_name); ?>"/></td>
                          <td scope="row" nowrap="nowrap"> 状态 </td>
                          <td nowrap="nowrap">
                        <select name="zhuangtai" id="zhuangtai"> 
                            <?php if($zhuangtai){ ?>
                            <option value="<?php echo ($zhuangtai); ?>"><?php echo ($zhuangtai); ?></option>
                            <option disabled="disabled">-----------------</option>
                            <?php } ?>
                            <option value="">全部</option> 
                            <option value="准备">准备</option> 
                            <option value="等待审核">等待审核</option> 
                            <option value="审核不通过">审核不通过</option> 
                            <option value="报名">报名</option> 
                            <option value="截止">截止</option> 
                        </select>
                          </td>
                        </tr>
                        <tr>
                          <td scope="row" nowrap="nowrap"> 始发地 </td>
                          <td nowrap="nowrap"><input type="text" id="chufadi" value="<?php echo ($chufadi); ?>"/></td>
                          <td scope="row" nowrap="nowrap"> 目的地 </td>
                          <td nowrap="nowrap"><input type="text" id="mudidi" value="<?php echo ($mudidi); ?>"/></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
              <input title="查找" class="button" type="button" value=" 查找 " onclick="dosearch();">&nbsp;
              <input title="清除" class="button" type="button" value=" 清除 " onclick="clearsearch();">
        </div>
        <?php unset($_REQUEST['_URL_']);if($_REQUEST){ ?>
        <div style="margin-top:10px;">
            <table width="100%" cellpadding="0" cellspacing="0" class="formHeader h3Row" style="margin-top:0px;">
              <tbody>
                <tr>
                  <td nowrap=""><h3><span>查询：<label style="color:red"><?php foreach($_REQUEST as $v) echo $v."&nbsp;" ?></label></span></h3></td>
                </tr>
              </tbody>
            </table>
        </div>
        <?php } ?>
    </div>


<script>

function showmysearchdiv(s)
{
		var divRili = document.getElementById('mysearchdiv');
		var divRili_1 = document.getElementById('show_link_insideview');
		var divRili_2 = document.getElementById('hide_link_insideview');
	if(s == 1){
		divRili.style.display = ''
		divRili_1.style.display = 'none'
		divRili_2.style.display = ''
		setsearch(1);
	}
	if(s == 2){
		divRili.style.display = 'none'
		divRili_1.style.display = ''
		divRili_2.style.display = 'none'
		setsearch(2);
	}
}

function setsearch(status)
{
	jQuery.ajax({
		  type:	"POST",
		  url:	"<?php echo SITE_INDEX;?>Chanpin/setsearch",
		  async: false,
		  data:	"status=" + status ,
		  success:	function(msg){
				ThinkAjax.myAjaxResponse(msg,'resultdiv');
			}
	  });
}

function showsearch(s)
{
	if(s == 1){
		var divRili = document.getElementById('searchdiv_1'); 
		divRili.style.display = '';			
		divRili = document.getElementById('searchdiv_2'); 
		divRili.style.display = 'none';	
		jQuery('#searchtab_1').addClass('current');
		jQuery('#searchtab_2').removeClass('current');
	}
	if(s == 2){
		var divRili = document.getElementById('searchdiv_2'); 
		divRili.style.display = '';			
		divRili = document.getElementById('searchdiv_1'); 
		divRili.style.display = 'none';	
		jQuery('#searchtab_2').addClass('current');
		jQuery('#searchtab_1').removeClass('current');
	}
}
</script>


            
            <div id="mysearchdiv" style="margin:10px 0 0 0;">
              <ul id="searchTabs" class="tablist tablist_2">
                <li> <a 
                  <?php if($markpos == '签证'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/签证">近郊游</a> </li>
                <li> <a 
                  <?php if($markpos == '办证'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/办证">长线游</a> </li>
                <li> <a 
                  <?php if($markpos == '交通'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/交通">自由人</a> </li>
                <li> <a 
                  <?php if($markpos == '订房'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/订房">包团</a> </li>
                <li> <a 
                  <?php if($markpos == '餐饮'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/餐饮">韩国</a> </li>
                <li> <a 
                  <?php if($markpos == '门票'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/门票">日本</a> </li>
                <li> <a 
                  <?php if($markpos == '导游'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/导游">台湾</a> </li>
                <li> <a 
                  <?php if($markpos == '补账'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/补账">港澳</a> </li>
                <li> <a 
                  <?php if($markpos == '补账'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/补账">东南亚</a> </li>
                <li> <a 
                  <?php if($markpos == '补账'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/补账">欧美岛</a> </li>
              </ul>
            </div>
            
            
            
            <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:0px;">
              <tbody>
              
                <tr class="pagination">
                  <td colspan="11">
                  <table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                      <tbody>
                        <tr>
                          <td nowrap="nowrap" class="paginationActionButtons">
                          </td>
                          <td nowrap="nowrap" align="right" class="paginationChangeButtons">
                          	<?php echo ($page); ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    </td>
                </tr>
                <tr height="20">
                  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 产品名称 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 售价 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 创建时间 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 单位 </div></th>
                </tr>
                
                <?php $i = 0;foreach($chanpin_list as $v){$i++; ?>
                <tr height="30" class="evenListRowS1">
                  <td valign="top" align="left" scope="row"><?php echo ($i); ?></td>
                  <td valign="top" align="left" style="min-width:300px;" scope="row"><?php echo ($v['xianlu']['xianlu']['title']); ?></td>
                  <td valign="top" align="left" scope="row"><?php echo ($v['adultprice']); ?>元</td>
                  <td valign="top" align="left" scope="row"><?php echo date('Y/m/d H:i',$v['xianlu']['xianlu']['time']); ?></td>
                  <td valign="top" align="left" style="min-width:50px;" scope="row"><?php echo ($v['xianlu']['xianlu']['bumentitle']); ?></td>
                </tr>  
                <tr height="30" class="evenListRowS1">
                    <td valign="top" align="left" scope="row" colspan="10">
                    <table cellpadding="0" cellspacing="0" width="100%" class="list_new view mytem" style="border:none">
                      <tbody>
                        <tr>
                          <td valign="top" align="left" style="vertical-align:top;" width="10" >
                          <input class="button" type="button" value=" 展开 " onclick="opendatelist(<?php echo ($i); ?>)" id="buttomopen<?php echo ($i); ?>" style="float:left">
                          <input class="button" type="button" value=" 收起 " onclick="closedatelist(<?php echo ($i); ?>)" id="buttomclose<?php echo ($i); ?>" style="display:none; float:left; ">
                          </td>
                          <td valign="top" align="left" colspan="10" class="sall_td" style=" height:37px; overflow:hidden; width:100%; float:left " id="sall_td<?php echo ($i); ?>">
                            <?php foreach($v['zituan'] as $vol){ ?>
                                <a target="_blank" href="<?php echo SITE_INDEX;?>Xiaoshou/zituan/chanpinID/<?php echo ($vol['chanpinID']); ?>/xianluID/<?php echo ($vol['parentID']); ?>/shoujiaID/<?php echo ($v['dataID']); ?>" ><?php echo ($vol['chutuanriqi']); ?><br /> 报名:<?php echo ($baoming_renshu[$vol['chanpinID']]); ?>人 剩余:<?php echo ($vol['shengyurenshu']); ?></a>
                            <?php } ?>
                          </td>
                        </tr>  
                      </tbody>
                    </table>
                    </td>
                </tr>  
                <?php } ?>
                
              </tbody>
            </table>
            
            
                
  </div>
</div>

<?php A("Index")->footer(); ?>

<script language="javascript"> 
function opendatelist(mark){
		jQuery("#sall_td"+mark).css( "height","100%"); 
		jQuery("#buttomclose"+mark).show();
		jQuery("#buttomopen"+mark).hide();
}
function closedatelist(mark){
		jQuery("#sall_td"+mark).css( "height","37px"); 
		jQuery("#buttomopen"+mark).show();
		jQuery("#buttomclose"+mark).hide();
}
function dosearch()
{
		title = document.getElementById('title').value;
		window.location = '<?php echo SITE_INDEX;?>Chanpin/index/title/'+title;
}

</script>