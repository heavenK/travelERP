<?php if (!defined('THINK_PATH')) exit();?>
<?php A("Index")->showheader(); ?>

<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.min.js" language="javascript"></script>
<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/Chanpin/xianlu.js"></script>
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


            
            <table cellpadding="0" cellspacing="0" width="100%" class="list view">
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
                  <th scope="col" nowrap="nowrap"><div> 团名 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 编号 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 联系人 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 联系电话 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 成人数 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 儿童数 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 领队数 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 售价 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 提成类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 所属人 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 订单类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 状态 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 时间 </div></th>
                </tr>
                
                <?php $i = -1; foreach($chanpin_list as $v){ $i++; ?>
                <tr style="cursor:pointer" height="30" class="evenListRowS1" onclick="showinfo(<?php echo ($v['chanpinID']); ?>)">
                  <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
                  <td scope="row" align="left" valign="top" style="min-width:300px; width:30%;"><?php echo ($v['title']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['chanpinID']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['lianxiren']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['telnum']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['chengrenshu']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['ertongshu']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['lingdui_num']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['jiage']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['ticheng']['title']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['owner']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['type']); ?></td>
                  <td scope="row" align="left" valign="top" style="color:#990"><?php echo ($v['status']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo date('m/d H:i',$v['time']) ?></td>
                </tr>
                <?php } ?>
                
                
              </tbody>
            </table>
            
  </div>
  
  
  
</div>

<?php A("Index")->footer(); ?>

<script language="javascript"> 

function showinfo(chanpinID){
	window.open('<?php echo SITE_INDEX;?>Xiaoshou/dingdanxinxi/chanpinID/'+chanpinID);
}

function dosearch()
{
		title = document.getElementById('title').value;
		window.location = '<?php echo SITE_INDEX;?>Chanpin/index/title/'+title;
}

</script>