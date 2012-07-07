<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript">
var SITE_INDEX = '<?php echo SITE_INDEX;?>';
</script>

<div id="main">
  <div id="content" style="margin-left:0;">
    <div id="resultdiv" class="resultdiv"></div>
    <div id="resultdiv_2" class="resultdiv"></div>
    
    <?php if('线路数据' == $nowDir['title']){ ?>
            
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


    <?php }elseif('用户' == $nowDir['title']){ ?>
            
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
              <a href="javascript:void(0)">高级查找</a>
          </li>
        </ul>
        
        <div class="search_form" id="searchdiv_1" style="margin-bottom:0px;">
              <div class="edit view search ">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td scope="row" nowrap="nowrap"> 姓名 </td>
                          <td nowrap="nowrap"><input type="text" name="title" id="title" value="<?php echo ($title); ?>"></td>
                      </tbody>
                    </table>
                </div>
              <input title="查找" class="button" type="button" value=" 查找 " onclick="dosearch();">&nbsp;
              <input title="清除" class="button" type="button" value=" 清除 " onclick="clearsearch();">
        </div>
        
        <?php if($_GET){ ?>
        <div style="margin-top:10px;">
            <table width="100%" cellpadding="0" cellspacing="0" class="formHeader h3Row" style="margin-top:0px;">
              <tbody>
                <tr>
                  <td nowrap=""><h3><span>查询：<label style="color:red"><?php foreach($_GET as $v) echo $v."&nbsp;" ?></label></span></h3></td>
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


    <?php }else{ ?>
        <table cellspacing="0" cellpadding="0" width="100%" class="h3Row" style="margin-top:0px;">
          <tbody>
            <tr><td width="20%" valign="bottom"><h3><?php echo ($navigation); echo ($datatitle); ?></h3></td></tr>
            <tr><td width="20%" valign="bottom"><h3><?php echo ($nowDir['remark']); ?></h3></td></tr>
          </tbody>
        </table>
    <?php } ?>
    
    <table cellpadding="0" cellspacing="0" width="100%" class="list view" id="itemlist_box">
      <tbody>
      
      <?php if('分类' == $nowDir['title']){ ?>
		<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/category.js"></script>
		<script type="text/javascript">
        var categorytype = '部门';
        </script>
        <tr class="pagination">
          <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><strong><?php echo ($nowDir['title']); ?></strong>&nbsp;
                    <input class="button" type="button" value=" 新增 " onclick="insertItem('itemlist');"></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr height="20">
          <th scope="col" nowrap="nowrap"> 序号</th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 分类类型 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 状态 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 操作 </div></th>
        </tr>
      <?php $i = 0; foreach($datalist as $v){ $i++; ?>
      <tr height="30" class="evenListRowS1" id="itemlist<?php echo ($v['systemID']); ?>">
        <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
        <td scope="row" align="left" valign="top"><input type="text" id="title<?php echo ($v['systemID']); ?>" style="width:200px" value="<?php echo ($v['title']); ?>"></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['type']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td>
        <td scope="row" align="left" valign="top">
        <input class="button" type="button" value="删除" onClick="deleteSystemItem(<?php echo ($v['systemID']); ?>,'itemlist')" />
        <input class="button" type="button" value="修改" onClick="save(<?php echo ($v['systemID']); ?>)"/>
        <input class="button" type="button" value="项目管理" onClick="addSystemDC(<?php echo ($v['systemID']); ?>)" />
        </td>
      </tr>
      <?php }} ?>
      
      <?php if('项目管理' == $nowDir['title']){ ?>
			<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
            <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
            <script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/systemDC.js"></script>
            <script type="text/javascript">
            var parentID = '<?php echo ($systemID); ?>';
            var department = [
                 <?php foreach($departmentAll as $v){ ?>
                          { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
                 <?php } ?>
             ];
            
            jQuery().ready(function() {
                    <?php foreach($dat['OMlist'] as $v){ ?>
                        myautocomplete("#<?php echo ($v[systemID]); ?>",'<?php echo ($v[parenttype]); ?>');
                     <?php } ?>
            });
            </script>
            <tr class="pagination">
              <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                  <tbody>
                    <tr>
                      <td nowrap="nowrap" class="paginationActionButtons"><strong><?php echo ($nowDir['title']); ?></strong>&nbsp;
                        <input class="button" type="button" value=" 新增 " onclick="insertdepartment();"></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr height="20">
              <th scope="col" nowrap="nowrap"> 序号 </th>
              <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 部门 </div></th>
              <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 操作 </div></th>
            </tr>
            <?php $i=0;foreach($systemDClist as $v){$i++; ?>
            <tr height="30" class="evenListRowS1" id="departmentrow<?php echo ($v['systemID']); ?>">
              <td scope="row" align="left" valign="top">
              <?php echo ($i); ?>
              </td>
              <td scope="row" align="left" valign="top">
              <input type="text" class="departmenttitle"  id="<?php echo ($v['systemID']); ?>" style="width:200px;" value="<?php echo ($v['department']['title']); ?>">
              <input type="hidden" id="dataID<?php echo ($v['systemID']); ?>" value="<?php echo ($v['dataID']); ?>">
              </td>
              <td scope="row" align="left" valign="top">
              <input class="button" type="button" value="删除" onClick="deleteDepartemntDC(<?php echo ($v['systemID']); ?>)" />
              <input class="button" type="button" value="修改" onClick="if(checktitle(<?php echo ($v['systemID']); ?>))addSystemDC(<?php echo ($v['systemID']); ?>);" />
              </td>
            </tr>
      <?php }} ?>
      
      
      <?php if('目录设置' == $nowDir['title']){ ?>
            <script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/directory.js"></script>
			<script type="text/javascript">
            var parentID = '<?php echo ($parentID); ?>';
            </script>
            <tr class="pagination">
              <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                  <tbody>
                    <tr>
                      <td nowrap="nowrap" class="paginationActionButtons"><strong><?php echo ($nowDir['title']); ?></strong>&nbsp;
                        <input class="button" type="button" value=" 新增 " onclick="insertItem('itemlist');"></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr height="20">
              <th scope="col" nowrap="nowrap"> 序号</th>
              <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 标题 </div></th>
              <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 地址 </div></th>
              <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 状态 </div></th>
              <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
            </tr>
            
            <?php $i = 0; foreach($datalist as $v){ $i++; ?>
            <tr height="30" class="evenListRowS1" id="itemlist<?php echo ($v['systemID']); ?>">
                <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
                <td scope="row" align="left" valign="top"><input type="text" id="title<?php echo ($v['systemID']); ?>" style="width:200px" value="<?php echo ($v['title']); ?>"></td>
                <td scope="row" align="left" valign="top"><?php echo SITE_INDEX;?><input type="text" id="url<?php echo ($v['systemID']); ?>" style="width:200px" value="<?php echo ($v['url']); ?>"></td>
                <td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td>
                <td scope="row" align="left" valign="top">
                <input class="button" type="button" value="删除" onClick="deleteSystemItem(<?php echo ($v['systemID']); ?>,'itemlist')" />
                <input class="button" type="button" value="修改" onClick="save(<?php echo ($v['systemID']); ?>)"/>
                <input class="button" type="button" value="子目录" onClick="subdirectory(<?php echo ($v['systemID']); ?>)" />
                </td>
            </tr>
      <?php }} ?>
      
      
      <?php if('数据开放与管理' == $nowDir['title']){ ?>
		<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
        <script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/SetSystem/OMpage.js'></script>
		<script type="text/javascript">
        var dataID = '<?php echo ($dataID); ?>';
        var datatype = '<?php echo ($datatype); ?>';
        var method = '<?php echo ($method); ?>';
        var category = [
                  { title: "无", systemID: "" },
             <?php foreach($categoryAll as $v){ ?>
                  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
             <?php } ?>
         ];
        
        var department = [
                  { title: "无", systemID: "" },
             <?php foreach($departmentAll as $v){ ?>
                  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
             <?php } ?>
         ];
        
        var user = [
                  { title: "无", systemID: "" },
             <?php foreach($userAll as $v){ ?>
                  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
             <?php } ?>
         ];
        
        var roles = [
                  { title: "无", systemID: "" },
             <?php foreach($rolesAll as $v){ ?>
                  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
             <?php } ?>
         ];
		 
		jQuery().ready(function() {
			
				<?php foreach($dat['OMlist'] as $v){ ?>
					myautocomplete("#<?php echo ($v[systemID]); ?>",'<?php echo ($v[parenttype]); ?>');
					myautocomplete("#roles<?php echo ($v[systemID]); ?>",'角色');
				 <?php } ?>
			
		});
        </script>
            <tr class="pagination">
              <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                  <tbody>
                    <tr>
                      <td nowrap="nowrap" class="paginationActionButtons">
                        <strong><?php echo ($nowDir['title']); ?></strong>&nbsp;
                        <input class="button" type="button" value="新增分类对象" onclick="insertItem('分类');" />
                        <input class="button" type="button" value="+部门" onclick="insertItem('部门');" />
                        <input class="button" type="button" value="+用户" onclick="insertItem('用户');" />
                        <input class="button" type="button" value="+角色" onclick="insertItem('角色');" />
                      </td>
                      <td nowrap="nowrap" align="right" class="paginationChangeButtons">
                        <?php echo ($page); ?>
                      </td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr height="20">
              <th scope="col" nowrap="nowrap"> 序号</th>
              <th scope="col" nowrap="nowrap"><div> 对象 </div></th>
              <th scope="col" nowrap="nowrap"><div> 对象类型 </div></th>
              <th scope="col" nowrap="nowrap"><div> 限制角色 </div></th>
              <th scope="col" nowrap="nowrap"><div> 状态 </div></th>
              <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
            </tr>
            
            <?php $i=0;foreach($dat['OMlist'] as $v){$i++; ?>
            <tr height="30" class="evenListRowS1" id="itemrow<?php echo ($v['systemID']); ?>">
              <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
              <td scope="row" align="left" valign="top">
              <input type="text" id="<?php echo ($v['systemID']); ?>" style="width:200px;" value="<?php echo ($v['parent']['title']); ?>">
              <input type="hidden" id="parentID<?php echo ($v['systemID']); ?>" value="<?php echo ($v['dataID']); ?>">
              </td>
              <td scope="row" align="left" valign="top">
              <?php echo ($v['parenttype']); ?>
              </td>
              <td scope="row" align="left" valign="top">
              <input type="text" id="roles<?php echo ($v['systemID']); ?>" value="<?php echo ($v['roleslimit']['title']); ?>">
              <input type="hidden" id="roleslimitID<?php echo ($v['systemID']); ?>" value="<?php echo ($v['roleslimitID']); ?>">
              </td>
              <td scope="row" align="left" valign="top">
              <?php echo ($v['parent']['status']); ?>
              </td>
              <td scope="row" align="left" valign="top">
              <input class="button" type="button" value="删除" onClick="deleteSystemOM(<?php echo ($v['systemID']); ?>)" />
              <input class="button" type="button" value="修改" onClick="if(checktitle(<?php echo ($v['systemID']); ?>,'<?php echo ($v[parenttype]); ?>'))additemOM(<?php echo ($v['systemID']); ?>,'<?php echo ($v[parenttype]); ?>');" />
              </td>
            </tr>
      <?php }} ?>
      
      
      <?php if('线路数据' == $nowDir['title']){ ?>
            <script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/OMlist.js"></script>
            <script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/Chanpin/xianlu.js"></script>
            <tr class="pagination" style="height:28px;">
              <td colspan="6">
              <table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                  <tbody>
                    <tr>
                      <td nowrap="nowrap" class="paginationActionButtons"><strong><?php echo ($datatype); ?>列表</strong>&nbsp;</td>
                      <td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($listdatas[page]); ?></td>
                    </tr>
                  </tbody>
                </table>
                </td>
            </tr>
            <tr height="20">
              <th scope="col" nowrap="nowrap"> 序号</th>
              <th scope="col" nowrap="nowrap" style="min-width:300px;"><div> 标题 </div></th>
              <th scope="col" nowrap="nowrap"><div> 编号 </div></th>
              <th scope="col" nowrap="nowrap"><div> 出团日期 </div></th>
              <th scope="col" nowrap="nowrap" style="min-width:50px;"><div> 状态 </div></th>
              <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
            </tr>
            <?php $i=0;foreach($listdatas['chanpin'] as $v){$i++; ?>
            <tr height="30" class="evenListRowS1">
              <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
              <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
              <td scope="row" align="left" valign="top">
              <?php echo ($v['bianhao']); ?>
              </td>
              <td scope="row" align="center" valign="top">
              <img name="aa" onclick="showdate('<?php echo Fi_ConvertChars($v[chutuanriqi]) ?>');showbox(this,'dateitem')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" />
              </td>
              <td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td>
              <td scope="row" align="left" valign="top">
              <input class="button" type="button" value="开放" onClick="openlist(<?php echo ($v['chanpinID']); ?>,'<?php echo ($datatype); ?>','<?php echo ($v['title']); ?>')" />
              <input class="button" type="button" value="管理" onClick="managelist(<?php echo ($v['chanpinID']); ?>,'<?php echo ($datatype); ?>','<?php echo ($v['title']); ?>')" />
              </td>
            </tr>
      <?php }} ?>
      
      
      <?php if('分类数据' == $nowDir['title']){ ?>
            <script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/OMlist.js"></script>
            <tr height="20">
              <th scope="col" nowrap="nowrap"> 序号</th>
              <th scope="col" nowrap="nowrap"><div> 标题 </div></th>
              <th scope="col" nowrap="nowrap"><div> 状态 </div></th>
              <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
            </tr>
            <?php $i=0;foreach($listdatas as $v){$i++; ?>
            <tr height="30" class="evenListRowS1">
              <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
              <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
              <td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td>
              <td scope="row" align="left" valign="top">
              <input class="button" type="button" value="开放" onClick="openlist(<?php echo ($v['systemID']); ?>,'<?php echo ($datatype); ?>')" />
              <input class="button" type="button" value="管理" onClick="managelist(<?php echo ($v['systemID']); ?>,'<?php echo ($datatype); ?>')" />
              </td>
            </tr>
        <?php }} ?>
      
      
      <?php if('用户' == $nowDir['title']){ ?>
            <script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/systemUser.js"></script>
            <tr class="pagination" style="height:28px;">
              <td colspan="6">
              <table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                  <tbody>
                    <tr>
                      <td nowrap="nowrap" class="paginationActionButtons">
                        <strong><?php echo ($nowDir['title']); ?>列表</strong>&nbsp;
                          <input class="button" type="button" value="开/关锁"  onclick="info()"/>
                          <input class="button" type="button" value="重置密码"  />
                      </td>
                      <td nowrap="nowrap" align="right" class="paginationChangeButtons">
                        <?php echo ($users[page]); ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
                </td>
            </tr>
            <tr height="20">
              <th scope="col" nowrap="nowrap" style="width:20px;"> 选择 </th>
              <th scope="col" nowrap="nowrap" style="width:20px;"> 序号 </th>
              <th scope="col" nowrap="nowrap"><div> 姓名 </div></th>
              <th scope="col" nowrap="nowrap"><div> 性别 </div></th>
              <th scope="col" nowrap="nowrap"><div> 锁 </div></th>
              <th scope="col" nowrap="nowrap" style=" width:20%" ><div> 操作 </div></th>
            </tr>
            <?php $i=0;foreach($users[data] as $v){$i++; ?>
            <tr height="30" class="evenListRowS1">
              <td scope="row" align="left" valign="top"><input type="radio" name="select" id="select" value="<?php echo ($v['systemID']); ?>" /></td>
              <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
              <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
              <td scope="row" align="left" valign="top"><?php echo ($v['user_gender']); ?></td>
              <td scope="row" align="left" valign="top"><?php echo ($v['islock']); ?></td>
              <td scope="row" align="left" valign="top">
              <input class="button" type="button" value="部门角色" onclick="openDUR(<?php echo ($v[systemID]); ?>,'<?php echo ($v['title']); ?>')"/>
              <input class="button" type="button" value="修改"/>
              </td>
            </tr>
        <?php }} ?>
      
      
      <?php if('部门角色' == $nowDir['title']){ ?>
			<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
            <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
            <script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/userDUR.js"></script>
			<script type="text/javascript">
            var userID = '<?php echo ($systemID); ?>';
			var department = [
				 <?php foreach($departmentAll as $v){ ?>
					  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
				 <?php } ?>
			 ];
			
			var roles = [
				 <?php foreach($rolesAll as $v){ ?>
					  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
				 <?php } ?>
			 ];
			
			jQuery().ready(function() {
				
					<?php foreach($DURlist as $v){ ?>
						myautocomplete("#department<?php echo ($v[systemID]); ?>",'部门');
						myautocomplete("#roles<?php echo ($v[systemID]); ?>",'角色');
					 <?php } ?>
				
			});
            </script>
            <tr class="pagination" style="height:28px;">
              <td colspan="6">
              <table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                  <tbody>
                    <tr>
                      <td nowrap="nowrap" class="paginationActionButtons">
                        <strong><?php echo ($nowDir['title']); ?>列表</strong>&nbsp;
                          <input class="button" type="button" value="添加" onclick="insertItem()"/>
                      </td>
                      <td nowrap="nowrap" align="right" class="paginationChangeButtons">
                      </td>
                    </tr>
                  </tbody>
                </table>
                </td>
            </tr>
            <tr height="20">
              <th scope="col" nowrap="nowrap" > 序号 </th>
              <th scope="col" nowrap="nowrap" ><div> 部门 </div></th>
              <th scope="col" nowrap="nowrap" ><div> 角色 </div></th>
              <th scope="col" nowrap="nowrap"><div> 锁 </div></th>
              <th scope="col" nowrap="nowrap" style="width:20%"><div> 操作 </div></th>
            </tr>
            <?php $i=0;foreach($DURlist as $v){$i++; ?>
            <tr height="30" class="evenListRowS1" id="durlist<?php echo ($v[systemID]); ?>">
              <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
              <td scope="row" align="left" valign="top">
              <input type="text" id="department<?php echo ($v[systemID]); ?>" style="width:200px;" value="<?php echo ($v[department][title]); ?>"/>
              <input type="hidden" id="departmentID<?php echo ($v[systemID]); ?>" value="<?php echo ($v[department][systemID]); ?>"/>
              </td>
              <td scope="row" align="left" valign="top">
              <input type="text" id="roles<?php echo ($v[systemID]); ?>" style="width:200px;" value="<?php echo ($v[roles][title]); ?>"/>
              <input type="hidden" id="rolesID<?php echo ($v[systemID]); ?>" value="<?php echo ($v[roles][systemID]); ?>"/>
              </td>
              <td scope="row" align="left" valign="top"><?php echo ($v['islock']); ?></td>
              <td scope="row" align="left" valign="top">
              <input class="button" type="button" value="删除" onclick="delUserDUR(<?php echo ($v[systemID]); ?>)"/>
              <input class="button" type="button" value="修改" onclick="if(checktitle(<?php echo ($v[systemID]); ?>,'部门','department') && checktitle(<?php echo ($v[systemID]); ?>,'角色','roles'))save(<?php echo ($v[systemID]); ?>);"/>
              </td>
            </tr>
        <?php }} ?>
      
      
      <?php if('审核流程' == $nowDir['title']){ ?>
		<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
        <script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/SetSystem/shenhe.js'></script>
		<script type="text/javascript">
        var datatype = '<?php echo ($datatype); ?>';
		
        var roles = [
             <?php foreach($rolesAll as $v){ ?>
                  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
             <?php } ?>
         ];
		 
        var user = [
             <?php foreach($userAll as $v){ ?>
                  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
             <?php } ?>
         ];
        
		jQuery().ready(function() {
			
				<?php foreach($datalist as $v){ ?>
					myautocomplete("#<?php echo ($v[systemID]); ?>",'<?php echo ($v[parenttype]); ?>');
					myautocomplete("#roles<?php echo ($v[systemID]); ?>",'角色');
				 <?php } ?>
			
		});
        </script>
            <tr class="pagination">
              <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                  <tbody>
                    <tr>
                      <td nowrap="nowrap" class="paginationActionButtons">
                        <strong><?php echo ($nowDir['title']); ?></strong>&nbsp;
                        <input class="button" type="button" value="新增流程角色" onclick="insertItem('角色');" />
                        <input class="button" type="button" value="+用户" onclick="insertItem('用户');" />
                      </td>
                      <td nowrap="nowrap" align="right" class="paginationChangeButtons">
                        <?php echo ($page); ?>
                      </td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr height="20">
              <th scope="col" nowrap="nowrap"> 序号</th>
              <th scope="col" nowrap="nowrap"><div> 对象 </div></th>
              <th scope="col" nowrap="nowrap"><div> 对象类型 </div></th>
              <th scope="col" nowrap="nowrap"><div> 流程序号 </div></th>
              <th scope="col" nowrap="nowrap"><div> 描述 </div></th>
              <th scope="col" nowrap="nowrap"><div> 状态 </div></th>
              <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
            </tr>
            
            <?php $i=0;foreach($datalist as $v){$i++; ?>
            <tr height="30" class="evenListRowS1" id="itemrow<?php echo ($v['systemID']); ?>">
              <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
              <td scope="row" align="left" valign="top">
              <input type="text" id="<?php echo ($v['systemID']); ?>" style="width:200px;" value="<?php echo ($v['title']); ?>">
              <input type="hidden" id="parentID<?php echo ($v['systemID']); ?>" value="<?php echo ($v['parentID']); ?>">
              </td>
              <td scope="row" align="left" valign="top">
              <?php echo ($v['parenttype']); ?>
              </td>
              <td scope="row" align="left" valign="top">
              <select id="processID<?php echo ($v['systemID']); ?>" style="width:100px;" >
              <option value="<?php echo ($v['processID']); ?>"><?php echo ($v['processID']); ?></option>
              <option disabled="disabled">---------------</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              </select>
              </td>
              <td scope="row" align="left" valign="top">
              <form id="form_t<?php echo ($v['systemID']); ?>" ><input type="text" id="remark<?php echo ($v['systemID']); ?>" value="<?php echo ($v['remark']); ?>" check='^\S+$' warning="描述不能为空,且不能含有空格" style="width:200px;" ></form>
              </td>
              <td scope="row" align="left" valign="top">
              <?php echo ($v['status']); ?>
              </td>
              <td scope="row" align="left" valign="top">
              <input class="button" type="button" value="删除" onClick="deleteItem(<?php echo ($v['systemID']); ?>)" />
              <input class="button" type="button" value="修改" onClick="if(CheckForm('form_t<?php echo ($v['systemID']); ?>','resultdiv_2') && checktitle(<?php echo ($v['systemID']); ?>,'<?php echo ($v[parenttype]); ?>'))additem(<?php echo ($v['systemID']); ?>,'<?php echo ($v[parenttype]); ?>');" />
              </td>
            </tr>
      <?php }} ?>
      
      
      
      <?php if('视频' == $nowDir['title']){ ?>
		<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/shipin.js"></script>
		<script>
		jQuery(document).ready(function(){
			jQuery('#dialogpic').dialog({
				autoOpen: false,
				width: 500,
			});
		});
		 function uploadComplete(data)
		 {
			ThinkAjax.myAjaxResponse(data,'resultdiv',om_save);
		 }
		 function showpic(data)
		 {
			document.getElementById('picimg').src='<?php echo SITE_DATA;?>Attachments/m_'+data;
			jQuery('#dialogpic').dialog('open');
		}
		 function closeshowpic()
		 {
			jQuery('#dialogpic').dialog('close');
		}
        </script>     
        <tr class="pagination">
          <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><strong><?php echo ($nowDir['title']); ?></strong>&nbsp;
                    <input class="button" type="button" value=" 新增 " onclick="insertItem('itemlist');"></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr height="20">
          <th scope="col" nowrap="nowrap"> 序号</th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 描述 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 视频地址 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 封面图片 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 操作 </div></th>
        </tr>
        
      <iframe name="iframeUpload" src="" frameborder="0" SCROLLING="no" style="display:none"></iframe> 
        
      <?php $i = 0; foreach($datalist as $v){ $i++; ?>
      <tr height="30" class="evenListRowS1" id="itemlist<?php echo ($v['systemID']); ?>">
        <form method="post" action="<?php echo SITE_INDEX;?>SetSystem/dopostDataDictionary/" enctype="multipart/form-data" target="iframeUpload"> 
        <INPUT TYPE="hidden" name="uploadResponse" value="uploadComplete">
        <INPUT TYPE="hidden" name="type" value="视频">
        <INPUT TYPE="hidden" name="systemID" value="<?php echo ($v['systemID']); ?>">
        <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
        <td scope="row" align="left" valign="top"><input type="text" name="title" style="width:200px" value="<?php echo ($v['title']); ?>"></td>
        <td scope="row" align="left" valign="top"><input type="text" name="description" style="width:200px" value="<?php echo ($v['description']); ?>"></td>
        <td scope="row" align="left" valign="top"><input type="text" name="video_url" style="width:200px" value="<?php echo ($v['video_url']); ?>"></td>
        <td scope="row" align="left" valign="top"><input type="file" name="image" style="width:200px"><a href="javascript:void(0)" onmouseover="showpic('<?php echo ($v[pic_url]); ?>');" onmouseout="closeshowpic();">查看</a></td>
        <td scope="row" align="left" valign="top">
        <input class="button" type="button" value="删除" onClick="deleteSystemItem(<?php echo ($v['systemID']); ?>,'itemlist')" />
        <input class="button" type="submit" value="修改" />
        </td>
        </form>
      </tr>
      <?php }} ?>
      
      
      
      
      <?php if('图片' == $nowDir['title']){ ?>
		<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/tupian.js"></script>
		<script>
		jQuery(document).ready(function(){
			jQuery('#dialogpic').dialog({
				autoOpen: false,
				width: 500,
			});
		});
		 function uploadComplete(data)
		 {
			ThinkAjax.myAjaxResponse(data,'resultdiv',om_save);
		 }
		 function showpic(data)
		 {
			document.getElementById('picimg').src='<?php echo SITE_DATA;?>Attachments/m_'+data;
			jQuery('#dialogpic').dialog('open');
		}
		 function closeshowpic()
		 {
			jQuery('#dialogpic').dialog('close');
		}
        </script>     
        <tr class="pagination">
          <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><strong><?php echo ($nowDir['title']); ?></strong>&nbsp;
                    <input class="button" type="button" value=" 新增 " onclick="insertItem('itemlist');"></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        
        <tr height="20">
          <th scope="col" nowrap="nowrap"> 序号</th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 描述 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 图片 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 操作 </div></th>
        </tr>
        
      <iframe name="iframeUpload" src="" frameborder="0" SCROLLING="no" style="display:none"></iframe> 
        
      <?php $i = 0; foreach($datalist as $v){ $i++; ?>
      <tr height="30" class="evenListRowS1" id="itemlist<?php echo ($v['systemID']); ?>">
        <form method="post" action="<?php echo SITE_INDEX;?>SetSystem/dopostDataDictionary/" enctype="multipart/form-data" target="iframeUpload"> 
        <INPUT TYPE="hidden" name="uploadResponse" value="uploadComplete">
        <INPUT TYPE="hidden" name="type" value="图片">
        <INPUT TYPE="hidden" name="systemID" value="<?php echo ($v['systemID']); ?>">
        <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
        <td scope="row" align="left" valign="top"><input type="text" name="title" style="width:200px" value="<?php echo ($v['title']); ?>"></td>
        <td scope="row" align="left" valign="top"><input type="text" name="description" style="width:200px" value="<?php echo ($v['description']); ?>"></td>
        <td scope="row" align="left" valign="top"><input type="file" name="image" style="width:200px"><a href="javascript:void(0)" onmouseover="showpic('<?php echo ($v[pic_url]); ?>');" onmouseout="closeshowpic();">查看</a></td>
        <td scope="row" align="left" valign="top">
        <input class="button" type="button" value="删除" onClick="deleteSystemItem(<?php echo ($v['systemID']); ?>,'itemlist')" />
        <input class="button" type="submit" value="修改" />
        </td>
        </form>
      </tr>
      <?php }} ?>
      
      
      
      
      <?php if('主题' == $nowDir['title']){ ?>
		<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/SetSystem/zhuti.js"></script>
        <tr class="pagination">
          <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><strong><?php echo ($nowDir['title']); ?></strong>&nbsp;
                    <input class="button" type="button" value=" 新增 " onclick="insertItem('itemlist');"></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        
        <tr height="20">
          <th scope="col" nowrap="nowrap"> 序号</th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 标题 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 描述 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 操作 </div></th>
        </tr>
        
        
      <?php $i = 0; foreach($datalist as $v){ $i++; ?>
      <tr height="30" class="evenListRowS1" id="itemlist<?php echo ($v['systemID']); ?>">
        <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
        <td scope="row" align="left" valign="top"><form id="form<?php echo ($v['systemID']); ?>" ><input type="text" name="title" id="title<?php echo ($v['systemID']); ?>" style="width:200px" value="<?php echo ($v['title']); ?>"></form></td>
        <td scope="row" align="left" valign="top"><input type="text" name="description" id="description<?php echo ($v['systemID']); ?>" style="width:200px" value="<?php echo ($v['description']); ?>"></td>
        <td scope="row" align="left" valign="top">
        <input class="button" type="button" value="删除" onClick="deleteSystemItem(<?php echo ($v['systemID']); ?>,'itemlist')" />
        <input class="button" type="button" value="修改" onClick="if(CheckForm('form<?php echo ($v[systemID]); ?>','resultdiv_2'))save(<?php echo ($v['systemID']); ?>,'itemlist<?php echo ($v[systemID]); ?>');"/>
        </td>
      </tr>
      <?php }} ?>
      
      
      
      
      
      
        </tbody>
    </table>
    
    
  </div>
</div>
<?php A("Index")->footer(); ?>
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
<div id="dialogpic" title="提示消息" style="background:#FFF">
<img id="picimg" />
</div>