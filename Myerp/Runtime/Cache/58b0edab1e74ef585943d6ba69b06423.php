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
                  <?php if($markpos == '线路产品'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Chanpin/shenhe/type/线路产品">线路产品</a> </li>
                <li> <a 
                  <?php if($markpos == '收支项'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Chanpin/shenhe/type/收支项">收支项</a> </li>
                <li> <a 
                  <?php if($markpos == '报账单'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Chanpin/shenhe/type/报账单">报账单</a> </li>
                <li> <a 
                  <?php if($markpos == '订单审核'){ ?>
                  class="current"
                  <?php } ?>
                  href="<?php echo SITE_INDEX;?>Chanpin/shenhe/type/订单审核">订单审核</a> </li>
              </ul>
            </div>
            
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
                
                <?php if($markpos == '线路产品'){ ?>
                <tr height="20">
                  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:200px; width:30%"><div> 产品名称 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 出团日期 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 发布人 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:120px;"><div> 单位 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 分类 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 状态 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 锁定 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 创建时间 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 轨迹 </div></th>
                </tr>
                <?php $i = -1; foreach($chanpin_list as $v){ $i++; ?>
                <tr height="30" class="evenListRowS1">
                    <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
                    <td scope="row" align="left" valign="top"><a target="_blank" href="<?php echo SITE_INDEX;?>Chanpin/fabu/chanpinID/<?php echo ($v['chanpinID']); ?>"><?php echo ($v['title']); ?></a></td>
                    <td scope="row" align="center" valign="top"><img name="aa" onclick="showdate('<?php echo Fi_ConvertChars($v[chutuanriqi]) ?>');showbox(this,'dateitem')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" /></td>
                    <td scope="row" align="left" valign="top"><?php echo ($v['user_name']); ?></td>
                    <td scope="row" align="left" valign="top" style="min-width:50px;"><?php echo ($v['bumen_copy']); ?></td>
                    <td scope="row" align="left" valign="top" style="min-width:50px;"><?php echo ($v['guojing']); ?>/<?php echo ($v['kind']); ?></td>
                    <td scope="row" align="left" valign="top" style="min-width:50px;"><?php echo ($v['status']); ?></td>
                    <td scope="row" align="left" valign="top" style="min-width:50px;"><?php echo ($v['islock']); ?></td>
                    <td scope="row" align="left" valign="top"><?php echo date('Y/m/d',$v['time']); ?></td>
                    <td scope="row" align="center" valign="top"><img id="showshenhe" onclick="shenheshow_doit(<?php echo ($v['chanpinID']); ?>,this);" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" /></td>
                </tr>
                <?php }} ?>
                
                <?php if($markpos == '收支项'){ ?>
                <tr height="20">
                  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 标题 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 类型 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 审核阶段 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 金额 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:40px;"><div> 方式 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 备注说明 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:120px;"><div> 提交时间 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:160px;"><div> 操作 </div></th>
                </tr>
                <?php $i = -1; foreach($chanpin_list as $v){ $i++; ?>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['type']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['shenhe_remark']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['value']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['method']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['remark']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo date('Y/m/d H:i',$v['time']); ?></td>
                  <td scope="row" align="left" valign="top">
      <?php $taskom = A("Method")->_checkOMTaskShenhe($v['chanpinID'],'报账项'); if(false !== $taskom){ if(cookie('show_action') == '批准'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('检出','报账项',<?php echo ($v['chanpinID']); ?>,'<?php echo ($v['title']); ?>');">
      <?php }if(cookie('show_action') == '申请'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('申请','报账项',<?php echo ($v['chanpinID']); ?>,'<?php echo ($v['title']); ?>');">
      <?php }}if(A("Method")->checkshenheback($v['chanpinID'],'报账项')){ ?>
      <input type="button" value=" 审核回退 " name="button" onclick="shenhe_back(<?php echo ($v['chanpinID']); ?>,'报账项');">
	  <?php } ?>
                  </td>
                </tr>
                <?php }} ?>
                
                <?php if($markpos == '报账单'){ ?>
                <tr height="20">
                  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 标题 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 类型 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 审核阶段 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 备注说明 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:120px;"><div> 提交时间 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:160px;"><div> 操作 </div></th>
                </tr>
                <?php $i = -1; foreach($chanpin_list as $v){ $i++; ?>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['type']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['shenhe_remark']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['remark']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo date('Y/m/d H:i',$v['time']); ?></td>
                  <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="showinfo(<?php echo ($v['chanpinID']); ?>,<?php echo ($v['parentID']); ?>);">
                  </td>
                </tr>
                <?php }} ?>
                
                <?php if($markpos == '订单审核'){ ?>
                <tr height="20">
                  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 团名/日期 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 编号 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 审核阶段 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 成人数/儿童/领队 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 提成类型 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:140px;"><div> 所属人/部门 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单类型 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 状态 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:200px;"><div> 备注说明 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:120px;"><div> 提交时间 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:160px;"><div> 操作 </div></th>
                </tr>
                <?php $i = -1; foreach($chanpin_list as $v){ $i++; ?>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($i+1); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['chanpinID']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['shenhe_remark']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['chengrenshu']); ?>/<?php echo ($v['ertongshu']); ?>/<?php echo ($v['lingdui_num']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['ticheng']['title']); ?>:<?php echo ($v['ticheng']['description']); ?>%</td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['owner']); ?>/<?php echo ($v['bumen_copy']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['type']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['remark']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo date('Y/m/d H:i',$v['time']); ?></td>
                  <td scope="row" align="left" valign="top">
              <input type="button" value="查看" name="button" class="button primary" onClick="show_dingdan(<?php echo ($v['chanpinID']); ?>);">
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
                <td valign="top" class="olOptionsFgClass"><div class="olFontClass" id="thedate"> </div></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div>
<div style="position: absolute; display:none" id="shenhediv">
  <table cellspacing="0" cellpadding="1" border="0" class="olBgClass">
    <tbody>
      <tr>
        <td><table cellspacing="0" cellpadding="0" border="0" width="100%" class="olCgClass">
            <tbody>
              <tr>
                <td width="100%" class="olCgClass"><div style="float:left">审核记录</div>
                  <div style="float: right"> <a title="关闭" href="javascript:void(0);" onClick="javascript:return div_close('shenhediv');"> <img border="0" src="<?php echo __PUBLIC__;?>/myerp/images/close.gif" style="margin-left:2px; margin-right: 2px;"> </a> </div></td>
              </tr>
            </tbody>
          </table>
          <table cellspacing="0" cellpadding="0" border="0" width="100%" class="olFgClass">
            <tbody id="shenhe_box">
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div>
<script language="javascript"> 
function shenheshow_doit(chanpinID,obj){
   if(jQuery("#shenhediv").is(":visible")==true){ 
	  jQuery('#shenhediv').hide();
	  return ;
   }
    getshenhemessage("Index.php?s=/Message/getshenhemessage/chanpinID/"+chanpinID);
	objleft = getPosLeft(obj) - 370;
	objtop = getPosTop(obj) + 20;
	jQuery('#shenhediv').css({top:objtop , left:objleft });
	jQuery('#shenhediv').show();
}
function getshenhemessage(posturl){
	jQuery.ajax({
		type:	"POST",
		url:	"<?php echo ET_URL;?>"+posturl,
		data:	"",
		success:	function(msg){
				ThinkAjax.myAjaxResponse(msg,'',getshenhemessage_after);
		}
	});
}

function getshenhemessage_after(data,status)
{
	if(status == 1){
		jQuery("#shenhe_box").html(data);
	}
}
function div_close(id){
	jQuery('#'+id+'').hide();
}

	function doshenhe_baozhangitem(dotype,datatype,dataID,title){
		ThinkAjax.myloading('resultdiv');
		jQuery.ajax({
			type:	"POST",
			url:	"<?php echo SITE_INDEX;?>Chanpin/doshenhe",
			data:	"dataID="+dataID+"&dotype="+dotype+"&datatype="+datatype+"&title="+title,
			success:function(msg){
				scroll(0,0);
				ThinkAjax.myAjaxResponse(msg,'resultdiv');
			}
		});
	}
function shenhe_back(dataID,datatype){
	ThinkAjax.myloading('resultdiv');
	jQuery.ajax({
		type:	"POST",
		url:	"<?php echo SITE_INDEX;?>Chanpin/shenheback",
		data:	"dataID="+dataID+"&datatype="+datatype,
		success:function(msg){
			scroll(0,0);
			ThinkAjax.myAjaxResponse(msg,'resultdiv');
		}
	});
}
	function showinfo(baozhangID,parentID){
		window.open('<?php echo SITE_INDEX;?>Chanpin/zituanbaozhang/chanpinID/'+parentID+'/baozhangID/'+baozhangID);
	}
	function show_dingdan(chanpinID){
		window.open('<?php echo SITE_INDEX;?>Xiaoshou/dingdanxinxi/chanpinID/'+chanpinID);
	}
function dosearch()
{
		title = document.getElementById('title').value;
		window.location = '<?php echo SITE_INDEX;?>Chanpin/index/title/'+title;
}

</script>