<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
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


    
    <div id="mysearchdiv" style="margin:10px 0 0 0;">
      <ul id="searchTabs" class="tablist tablist_2">
        <li> <a 
          <?php if($markpos == '签证'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/签证">签证</a> </li>
        <li> <a 
          <?php if($markpos == '办证'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/办证">办证</a> </li>
        <li> <a 
          <?php if($markpos == '交通'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/交通">交通</a> </li>
        <li> <a 
          <?php if($markpos == '订房'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/订房">订房</a> </li>
        <li> <a 
          <?php if($markpos == '餐饮'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/餐饮">订餐</a> </li>
        <li> <a 
          <?php if($markpos == '门票'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/门票">门票</a> </li>
        <li> <a 
          <?php if($markpos == '导游'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/导游">导游</a> </li>
        <li> <a 
          <?php if($markpos == '补账'){ ?>
          class="current"
          <?php } ?>
          href="<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/补账">补账</a> </li>
      </ul>
    </div>
    
    <table cellpadding="0" cellspacing="0" width="100%" class="list view">
      <tbody>
        <tr class="pagination">
          <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><a id="select_link" href="javascript:void(0)" onclick="showbox(this,'selectitem')">选择&nbsp;<img src="<?php echo __PUBLIC__;?>/myerp/images/MoreDetail.png" ></a>&nbsp;
                    <input class="button" type="button" value=" 添加签证结算报告 " id="qianzheng_create">
                    <input class="button" type="button" value=" +办证 " id="banzheng_create">
                    <input class="button" type="button" value=" +交通 " id="jiaotong_create">
                    <input class="button" type="button" value=" +订房 " id="dingfang_create">
                    <input class="button" type="button" value=" +订餐 " id="dingcan_create">
                    <input class="button" type="button" value=" +门票 " id="menpiao_create">
                    <input class="button" type="button" value=" +导游 " id="daoyou_create">
                    <input class="button" type="button" value=" +补账 " id="buzhang_create">
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
      
        <?php if($type == '交通'){ ?>
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
<script>
function dosearch(){
	title = document.getElementById('title').value;
	window.location = '<?php echo SITE_INDEX;?>Dijie/index/title/'+title;
}

function showinfo(baozhangID){
	window.open('<?php echo SITE_INDEX;?>Dijie/djtuanbaozhang/baozhangID/'+baozhangID);
}

</script>
<div id="dialog_qianzheng" title="添加签证结算报告" style="background:#FFF">
<form id="form_qianzheng" id="form_qianzheng" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="签证" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 所属部门: </td>
          <td valign="top" scope="row">
              <select name="departmentID">
              <?php if($xianlu['bumen_copy']){ ?>
                <option value="<?php echo ($xianlu['departmentID']); ?>"><?php echo ($xianlu['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
          
          </td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row" colspan="3"><input name="renshu" type="text" check="^\S+$" warning="人数不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<div id="dialog_banzheng" title="添加办证结算报告" style="background:#FFF">
<form id="form_banzheng" id="form_banzheng" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="办证" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 所属部门: </td>
          <td valign="top" scope="row">
              <select name="departmentID">
              <?php if($xianlu['bumen_copy']){ ?>
                <option value="<?php echo ($xianlu['departmentID']); ?>"><?php echo ($xianlu['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
          
          </td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row"><input name="renshu" type="text" check="^\S+$" warning="人数不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<div id="dialog_jipiao" title="添加机票结算报告" style="background:#FFF">
<form id="form_jipiao" id="form_jipiao" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="机票" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 所属部门: </td>
          <td valign="top" scope="row">
              <select name="departmentID">
              <?php if($xianlu['bumen_copy']){ ?>
                <option value="<?php echo ($xianlu['departmentID']); ?>"><?php echo ($xianlu['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
          
          </td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row"><input name="renshu" type="text" style="width:100%" check="^\S+$" warning="人数号不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 航班号: </td>
          <td valign="top" scope="row"><input name="hangbanhao" type="text" style="width:100%" check="^\S+$" warning="航班号不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 始发地: </td>
          <td valign="top" scope="row"><input name="shifadi" type="text" style="width:100%" ></td>
          <td valign="top" scope="row" style="width:80px;"> 目的地: </td>
          <td valign="top" scope="row"><input name="mudidi" type="text" style="width:100%" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 起飞时间: </td>
          <td valign="top" scope="row"><input name="leavetime" type="text" style="width:100%" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" ></td>
          <td valign="top" scope="row" style="width:80px;"> 抵达时间: </td>
          <td valign="top" scope="row"><input name="arrivetime" type="text" style="width:100%" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<div id="dialog_dingfang" title="添加订房结算报告" style="background:#FFF">
<form id="form_dingfang" id="form_dingfang" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="订房" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 所属部门: </td>
          <td valign="top" scope="row">
              <select name="departmentID">
              <?php if($xianlu['bumen_copy']){ ?>
                <option value="<?php echo ($xianlu['departmentID']); ?>"><?php echo ($xianlu['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
          
          </td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row"><input name="renshu" type="text" check="^\S+$" warning="人数不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row"></td>
          <td valign="top" scope="row"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 酒店名称: </td>
          <td valign="top" scope="row"><input name="hotel" type="text" style="width:100%" check="^\S+$" warning="酒店名称不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 联系电话: </td>
          <td valign="top" scope="row"><input name="hoteltelnum" type="text" style="width:100%" check="^\S+$" warning="联系电话不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 订房时间: </td>
          <td valign="top" scope="row"><input name="ordertime" type="text" style="width:100%" onfocus="WdatePicker()" check="^\S+$" warning="订房时间不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 结算时间: </td>
          <td valign="top" scope="row"><input name="jiesuantime" type="text" style="width:100%" onfocus="WdatePicker()" check="^\S+$" warning="结算时间不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<div id="dialog_buzhang" title="添加补账" style="background:#FFF">
<form id="form_buzhang" id="form_buzhang" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="补账" />
<input type="hidden" name="renshu" value="0" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 所属部门: </td>
          <td valign="top" scope="row">
              <select name="departmentID">
              <?php if($xianlu['bumen_copy']){ ?>
                <option value="<?php echo ($xianlu['departmentID']); ?>"><?php echo ($xianlu['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
          
          </td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>


<div id="dialog_jiaotong" title="添加交通" style="background:#FFF">
<form id="form_jiaotong" id="form_jiaotong" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="交通" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 所属部门: </td>
          <td valign="top" scope="row">
              <select name="departmentID">
              <?php if($xianlu['bumen_copy']){ ?>
                <option value="<?php echo ($xianlu['departmentID']); ?>"><?php echo ($xianlu['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
          
          </td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row"><input name="renshu" type="text"check="^\S+$" warning="人数号不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 列车航班编号: </td>
          <td valign="top" scope="row"><input name="hangbanhao" type="text"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 结算时间: </td>
          <td valign="top" scope="row"><input name="jiesuantime" type="text" ></td>
          <td valign="top" scope="row" style="width:80px;"> 联系电话: </td>
          <td valign="top" scope="row"><input name="telnum" type="text"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 始发地: </td>
          <td valign="top" scope="row"><input name="shifadi" type="text"></td>
          <td valign="top" scope="row" style="width:80px;"> 目的地: </td>
          <td valign="top" scope="row"><input name="mudidi" type="text"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 开始时间: </td>
          <td valign="top" scope="row"><input name="leavetime" type="text" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" ></td>
          <td valign="top" scope="row" style="width:80px;"> 结束时间: </td>
          <td valign="top" scope="row"><input name="arrivetime" type="text" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<div id="dialog_menpiao" title="添加订门票" style="background:#FFF">
<form id="form_menpiao" id="form_menpiao" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="门票" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 所属部门: </td>
          <td valign="top" scope="row">
              <select name="departmentID">
              <?php if($xianlu['bumen_copy']){ ?>
                <option value="<?php echo ($xianlu['departmentID']); ?>"><?php echo ($xianlu['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
          
          </td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row" colspan="3"><input name="renshu" type="text" check="^\S+$" warning="人数号不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 结算时间: </td>
          <td valign="top" scope="row"><input name="jiesuantime" type="text" ></td>
          <td valign="top" scope="row" style="width:80px;"> 联系电话: </td>
          <td valign="top" scope="row"><input name="telnum" type="text"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>


<div id="dialog_daoyou" title="添加订导游" style="background:#FFF">
<form id="form_daoyou" id="form_daoyou" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="导游" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 所属部门: </td>
          <td valign="top" scope="row">
              <select name="departmentID">
              <?php if($xianlu['bumen_copy']){ ?>
                <option value="<?php echo ($xianlu['departmentID']); ?>"><?php echo ($xianlu['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
          
          </td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row" colspan="3"><input name="renshu" type="text" check="^\S+$" warning="人数号不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 结算时间: </td>
          <td valign="top" scope="row"><input name="jiesuantime" type="text" ></td>
          <td valign="top" scope="row" style="width:80px;"> 联系电话: </td>
          <td valign="top" scope="row"><input name="telnum" type="text"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<div id="dialog_dingcan" title="添加订餐" style="background:#FFF">
<form id="form_dingcan" id="form_dingcan" method="post" >
<input type="hidden" name="parentID" value="<?php echo ($chanpinID); ?>" />
<input type="hidden" name="type" value="餐饮" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 标题: </td>
          <td valign="top" scope="row"><input name="title" type="text" style="width:100%" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 所属部门: </td>
          <td valign="top" scope="row">
              <select name="departmentID">
              <?php if($xianlu['bumen_copy']){ ?>
                <option value="<?php echo ($xianlu['departmentID']); ?>"><?php echo ($xianlu['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
          
          </td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 人数: </td>
          <td valign="top" scope="row"><input name="renshu" type="text" check="^\S+$" warning="人数号不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="width:80px;"> 时间: </td>
          <td valign="top" scope="row"><input name="shijian" type="text"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 结算时间: </td>
          <td valign="top" scope="row"><input name="jiesuantime" type="text" ></td>
          <td valign="top" scope="row" style="width:80px;"> 联系电话: </td>
          <td valign="top" scope="row"><input name="telnum" type="text"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="width:80px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3"><textarea name="remark" rows="4" style="width:100%"></textarea></td>
        </tr>
      </tbody>
    </table>
</form>
</div>

<script language="javascript"> 
jQuery(document).ready(function(){
	// Dialog
	jQuery('#dialog_qianzheng').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_qianzheng','resultdiv_2'))
				ThinkAjax.sendForm('form_qianzheng','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_banzheng').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_banzheng','resultdiv_2'))
				ThinkAjax.sendForm('form_banzheng','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_jipiao').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_jipiao','resultdiv_2'))
				ThinkAjax.sendForm('form_jipiao','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_dingfang').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_dingfang','resultdiv_2'))
				ThinkAjax.sendForm('form_dingfang','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_buzhang').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_buzhang','resultdiv_2'))
				ThinkAjax.sendForm('form_buzhang','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_jiaotong').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_jiaotong','resultdiv_2'))
				ThinkAjax.sendForm('form_jiaotong','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_menpiao').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_menpiao','resultdiv_2'))
				ThinkAjax.sendForm('form_menpiao','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_daoyou').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_daoyou','resultdiv_2'))
				ThinkAjax.sendForm('form_daoyou','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog
	jQuery('#dialog_dingcan').dialog({
		autoOpen: false,
		width: 600,
		buttons: {
			"确认": function() {
				if(CheckForm('form_dingcan','resultdiv_2'))
				ThinkAjax.sendForm('form_dingcan','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',save_after,'resultdiv');
			},
			"取消": function() {
				jQuery(this).dialog("close");
			}
		}
	});
	// Dialog Link
	jQuery('#qianzheng_create').click(function(){
		jQuery('#dialog_qianzheng').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#banzheng_create').click(function(){
		jQuery('#dialog_banzheng').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#jipiao_create').click(function(){
		jQuery('#dialog_jipiao').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#dingfang_create').click(function(){
		jQuery('#dialog_dingfang').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#buzhang_create').click(function(){
		jQuery('#dialog_buzhang').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#jiaotong_create').click(function(){
		jQuery('#dialog_jiaotong').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#menpiao_create').click(function(){
		jQuery('#dialog_menpiao').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#daoyou_create').click(function(){
		jQuery('#dialog_daoyou').dialog('open');
		return false;
	});
	// Dialog Link
	jQuery('#dingcan_create').click(function(){
		jQuery('#dialog_dingcan').dialog('open');
		return false;
	});
	
});

	
function save_after(data,status){
	if(status == 1){
		window.location = '<?php echo SITE_INDEX;?>Dijie/danxiangfuwu/type/'+data['type'];
	}
}


function deletebaozhang(baozhangID){
	jQuery.ajax({
		type:	"POST",
		url:	'<?php echo SITE_INDEX;?>Dijie/deleteBaozhang/chanpinID/'+baozhangID,
		data:	'',
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',del_after);
		}
	});
}
function del_after(data,status){
	if(status == 1){
		location.reload();
	}
}
</script>