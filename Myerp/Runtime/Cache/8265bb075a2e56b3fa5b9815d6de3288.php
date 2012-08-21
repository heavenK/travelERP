<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo __PUBLIC__;?>/gulianstyle/styles/jquery.autocomplete.min.js" language="javascript"></script>
<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/Chanpin/xianlu.js"></script>

<div id="main">
          <style>
		#navtab_2 h3 { color:#0B578F}
		#navtab_3 h3 { color:#999}
		</style>

  <div id="leftColumn" style="margin-top:0px; width:150px;">
        <div id="navtab_1" class="leftList">
          <h3><span>产品分类</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/kongguan">&nbsp;<span>子团产品</span></a> </li>
            <li id="subModuleList" style="padding:0px; border-top:none">
                  <ul>
                    <li class="subTabMore" style="font-size:12px;"> <a href="<?php echo SITE_INDEX;?>Chanpin">&nbsp;线路发布及控管&gt;&gt;</a> 
                        <ul class="cssmenu" style="margin-top:8px;">
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/近郊游/guojing/国内">近郊游 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/长线游/guojing/国内">长线游 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/自由人/guojing/国内">国内自由人 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/包团/guojing/国内">国内包团 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/韩国/guojing/境外">韩国 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/日本/guojing/境外">日本 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/台湾/guojing/境外">台湾 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/港澳/guojing/境外">港澳 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/东南亚/guojing/境外">东南亚 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/欧美岛/guojing/境外">欧美岛 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/自由人/guojing/境外">境外自由人 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/包团/guojing/境外">境外包团 </a> </li>
                        </ul>
                    </li>
                  </ul>
            </li>
            <li> <a href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu">&nbsp;<span>签证及票务</span></a> </li>
            <li> <a href="#">&nbsp;<span>回收站</span></a> </li>
          </ul>
        </div>
  </div>


  <div id="content" style="margin-left:170px;">
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
          href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu/type/签证">签证</a> </li>
        <li> <a 
          <?php if($markpos == '办证'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu/type/办证">办证</a> </li>
        <li> <a 
          <?php if($markpos == '机票'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu/type/机票">机票</a> </li>
        <li> <a 
          <?php if($markpos == '订房'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu/type/订房">订房</a> </li>
        <li> <a 
          <?php if($markpos == '交通'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu/type/交通">订车</a> </li>
        <li> <a 
          <?php if($markpos == '餐饮'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu/type/餐饮">订餐</a> </li>
        <li> <a 
          <?php if($markpos == '门票'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu/type/门票">门票</a> </li>
        <li> <a 
          <?php if($markpos == '导游'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu/type/导游">导游</a> </li>
        <li> <a 
          <?php if($markpos == '补账'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu/type/补账">补账</a> </li>
      </ul>
    </div>
    
    <table cellpadding="0" cellspacing="0" width="100%" class="list view">
      <tbody>
        <tr class="pagination">
          <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                    <input class="button" type="button" value=" 复制 ">
                    <input class="button" type="button" value=" 发布 ">
                    <input class="button" type="button" value=" 删除 ">
                    <input class="button" type="button" value=" 锁定 ">
                    <input class="button" type="button" value=" 解锁 ">
                    <input class="button" type="button" value=" 截止 "></td>
                  <td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?> </td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        
        <?php if($type == '签证'|| $type == '办证'|| $type == '餐饮'|| $type == '门票'|| $type == '导游'){ ?>
        <tr height="20">
          <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
          <th scope="col" nowrap="nowrap"><div> 标题 </div></th>
          <th scope="col" nowrap="nowrap"><div> 审核阶段 </div></th>
          <th scope="col" nowrap="nowrap"><div> 人数 </div></th>
          <th scope="col" nowrap="nowrap"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
        </tr>
          <?php $i = -1; foreach($chanpin_list as $vol){ $i++; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['renshu']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>,'签证');">
              <input type="button" value="删除" name="button" class="button primary" onClick="deletebaozhang(<?php echo ($vol['chanpinID']); ?>);" >
            </td>
          </tr>
      <?php }} ?>
      
        <?php if($type == '机票'){ ?>
        <tr height="20">
          <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
          <th scope="col" nowrap="nowrap"><div> 标题 </div></th>
          <th scope="col" nowrap="nowrap"><div> 审核阶段 </div></th>
          <th scope="col" nowrap="nowrap"><div> 人数 </div></th>
          <th scope="col" nowrap="nowrap"><div> 航班号 </div></th>
          <th scope="col" nowrap="nowrap"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
        </tr>
          <?php $i = -1; foreach($chanpin_list as $vol){ $i++; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['renshu']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['hangbanhao']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>,'签证');">
              <input type="button" value="删除" name="button" class="button primary" onClick="deletebaozhang(<?php echo ($vol['chanpinID']); ?>);" >
            </td>
          </tr>
      <?php }} ?>
      
        <?php if($type == '订房'){ ?>
        <tr height="20">
          <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
          <th scope="col" nowrap="nowrap"><div> 标题 </div></th>
          <th scope="col" nowrap="nowrap"><div> 审核阶段 </div></th>
          <th scope="col" nowrap="nowrap"><div> 人数 </div></th>
          <th scope="col" nowrap="nowrap"><div> 酒店名称 </div></th>
          <th scope="col" nowrap="nowrap"><div> 联系电话 </div></th>
          <th scope="col" nowrap="nowrap"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
        </tr>
          <?php $i = -1; foreach($chanpin_list as $vol){ $i++; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['renshu']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['hotel']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['hoteltelnum']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>,'签证');">
              <input type="button" value="删除" name="button" class="button primary" onClick="deletebaozhang(<?php echo ($vol['chanpinID']); ?>);" >
            </td>
          </tr>
      <?php }} ?>
      
        <?php if($type == '交通'){ ?>
        <tr height="20">
          <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
          <th scope="col" nowrap="nowrap"><div> 标题 </div></th>
          <th scope="col" nowrap="nowrap"><div> 审核阶段 </div></th>
          <th scope="col" nowrap="nowrap"><div> 人数 </div></th>
          <th scope="col" nowrap="nowrap"><div> 列车航班号 </div></th>
          <th scope="col" nowrap="nowrap"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
        </tr>
          <?php $i = -1; foreach($chanpin_list as $vol){ $i++; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['renshu']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['hangbanhao']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>,'签证');">
              <input type="button" value="删除" name="button" class="button primary" onClick="deletebaozhang(<?php echo ($vol['chanpinID']); ?>);" >
            </td>
          </tr>
      <?php }} ?>
      
        <?php if($type == '补账'){ ?>
        <tr height="20">
          <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
          <th scope="col" nowrap="nowrap"><div> 标题 </div></th>
          <th scope="col" nowrap="nowrap"><div> 审核阶段 </div></th>
          <th scope="col" nowrap="nowrap"><div> 备注说明 </div></th>
          <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
        </tr>
          <?php $i = -1; foreach($chanpin_list as $vol){ $i++; ?>
          <tr height="30" class="evenListRowS1">
            <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['title']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['shenhe_remark']); ?></td>
            <td scope="row" align="left" valign="top"><?php echo ($vol['datatext']['remark']); ?></td>
            <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($vol['chanpinID']); ?>,'签证');">
              <input type="button" value="删除" name="button" class="button primary" onClick="deletebaozhang(<?php echo ($vol['chanpinID']); ?>);" >
            </td>
          </tr>
      <?php }} ?>
      
      
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

	function showinfo(baozhangID){
		window.location = '<?php echo SITE_INDEX;?>Chanpin/danxiangfuwu_info/baozhangID/'+baozhangID;
	}
	
	function deletebaozhang(baozhangID){
		window.location = '<?php echo SITE_INDEX;?>Chanpin/deleteBaozhang/chanpinID/'+baozhangID;
	}

</script>