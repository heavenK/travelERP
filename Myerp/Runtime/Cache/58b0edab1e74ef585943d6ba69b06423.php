<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>

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
          <li style="margin-right:1px;">
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
                          	<a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                            <input class="button" type="button" value=" 复制 ">
                            <input class="button" type="button" value=" 发布 ">
                            <input class="button" type="button" value=" 删除 ">
                            <input class="button" type="button" value=" 锁定 ">
                            <input class="button" type="button" value=" 解锁 ">
                            <input class="button" type="button" value=" 截止 ">
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
                  <th scope="col" nowrap="nowrap"><input type="checkbox" class="checkbox" value="" id="checkboxall" onclick="myCheckBoxSelect(this)"></th>
                  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 产品名称 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 编号 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 出团日期 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 发布人 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 创建时间 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 单位 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 状态 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 锁定 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 网站发布 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 轨迹 </div></th>
                </tr>
                
                <?php $i = -1; foreach($chanpin_list as $v){ $i++; ?>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><input value="<?php echo ($v['xianluID']); ?>" id="chanpinitem<?php echo ($i); ?>" type="checkbox" name="itemlist[]" class="checkbox"></td>
                  <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
                  <td scope="row" align="left" valign="top" style="min-width:300px;">
                  <a target="_blank" href="<?php echo SITE_INDEX;?>Chanpin/fabu/chanpinID/<?php echo ($v['chanpinID']); ?>"><?php echo ($v['title']); ?></a>
                  </td>
                  <td scope="row" align="left" valign="top">
                  <?php echo ($v['bianhao']); ?>
                  </td>
                  <td scope="row" align="center" valign="top">
                  <img name="aa" onclick="showdate('<?php echo Fi_ConvertChars($v[chutuanriqi]) ?>');showbox(this,'dateitem')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" />
                  </td>
                  <td scope="row" align="left" valign="top">
                  <?php echo ($v['user_name']); ?>
                  </td>
                  <td scope="row" align="left" valign="top">
                  <?php echo date('Y/m/d H:i',$v['time']); ?>
                  </td>
                  <td scope="row" align="left" valign="top" style="min-width:50px;">
                  <?php echo ($v['departmentName']); ?>
                  </td>
                  <td scope="row" align="left" valign="top" style="min-width:50px;">
                  <?php echo ($v['status']); ?>
                  </td>
                  <td scope="row" align="left" valign="top" style="min-width:50px;">
                  <?php echo ($v['islock']); ?>
                  </td>
                  <td scope="row" align="left" valign="top" style="min-width:50px;">
                  <?php echo ($v['ispub']); ?>
                  </td>
                  <td scope="row" align="center" valign="top">
                  <img onclick="showmessage(this,'<?php echo ($v['chanpinID']); ?>','线路','操作记录');showbox(this,'messageitem','r')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" />
                  </td>
                </tr>
                <?php } ?>
                
              </tbody>
            </table>
            
  </div>
</div>

<?php A("Index")->footer(); ?>

<script language="javascript"> 

function dosearch()
{
		title = document.getElementById('title').value;
		window.location = '<?php echo SITE_INDEX;?>Chanpin/index/title/'+title;
}

</script>

<div id="selectitem" style=" display:none; position:absolute;">
  <table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass">
    <tbody>
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass">
            <tbody>
              <tr>
                <td valign="top" class="olOptionsFgClass">
                <div class="olFontClass">
                <a href="javascript:void(0)" onclick="myCheckBoxSelect()" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,'yes');" class="menuItem" style="width: 150px">选择全部</a>
                <a href="javascript:void(0)" onclick="myCheckBoxSelect('o','false')" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,'yes');" class="menuItem" style="width: 150px">取消选择</a>
                </div>
                </td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div>            

<div id="dateitem" style=" display:none; position:absolute;">
  <table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass">
    <tbody>
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass">
            <tbody>
              <tr>
                <td valign="top" class="olOptionsFgClass">
                <div class="olFontClass" id="thedate">
                </div>
                </td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div>            

<div id="messageitem" style=" display:none; position:absolute;">
  <table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass">
    <tbody>
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass">
            <tbody>
              <tr>
                <td valign="top" class="olOptionsFgClass">
                <div class="olFontClass" id="themessage">
                </div>
                </td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div>