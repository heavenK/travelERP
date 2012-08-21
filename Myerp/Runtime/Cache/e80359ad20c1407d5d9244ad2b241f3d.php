<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/Chanpin/baozhang.js"></script>
<script type="text/javascript">
var SITE_INDEX = '<?php echo SITE_INDEX;?>';
var parentID = '<?php echo ($baozhangID); ?>';
function save_baozhang(){
	if(CheckForm('form1','resultdiv_2'))
	ThinkAjax.sendForm('form1','<?php echo SITE_INDEX;?>Chanpin/dopost_zituanbaozhang',doComplete,'resultdiv');
}
function doComplete(data,status){
}

function dosetprint(ele,id)
{
	checked = ele.checked;
	if(checked)
	value = '不打印';
	else
	value = '';
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/dopost_baozhangitem/dotype/setprint",
		data:	"chanpinID="+id+"&is_print="+value,
		success:	function(msg){
			  ThinkAjax.myAjaxResponse(msg,'resultdiv');
		  }
	});
}

function doprint(type){
	var url = SITE_INDEX+'Chanpin/zituanbaozhang/doprint/'+type+'/chanpinID/<?php echo ($chanpinID); ?>/baozhangID/<?php echo ($baozhangID); ?>';
    window.open(url,null,"height=800,width=1200,status=yes,toolbar=no,menubar=no,location=no");
}

function exports()
{
	window.location.href = SITE_INDEX+'Chanpin/zituanbaozhang/export/1/chanpinID/<?php echo ($chanpinID); ?>/baozhangID/<?php echo ($baozhangID); ?>';
}

	function doshenhe_baozhangitem(dotype,datatype,dataID,title){
		ThinkAjax.myloading('resultdiv');
		jQuery.ajax({
			type:	"POST",
			url:	SITE_INDEX+"Chanpin/doshenhe",
			data:	"dataID="+dataID+"&dotype="+dotype+"&datatype="+datatype+"&title="+title,
			success:function(msg){
				scroll(0,0);
				ThinkAjax.myAjaxResponse(msg,'resultdiv');
			}
		});
	}
	function ajaxalert(title){
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+title+'</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
	}
	
</script>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/WdatePicker.css" rel="stylesheet" type="text/css">
<div id="main">         <style>
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
    <?php A("Chanpin")->header_kongguan(); ?>
    <form name="form1" method="post" id="form1" >
      <input type="hidden" name="chanpinID" value="<?php echo ($baozhangID); ?>">
      <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
        <tbody>
          <tr>
            <th align="left" colspan="8"> <h4 style="color:#090"><?php echo ($baozhang['type']); ?>结算报告(注意：报账项只有在审核通过后才可以被打印或导出) <span style="float:right; color:#4e8ccf; margin-right:100px;">审核阶段：<?php echo ($baozhang['shenhe_remark']); ?></span></h4>
            </th>
          </tr>
            <?php if($baozhang['type'] == '团队报账单'){ ?>
        <input type="hidden" name="title" value="<?php echo trim($baozhang['title']) ?>"/>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 人数: </td>
          <td valign="top" scope="row" style="min-width:100px;"><input name="renshu" type="text" value="<?php echo trim($baozhang['renshu']) ?>" check="^\S+$" warning="人数不能为空,且不能含有空格"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 接团单位: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="jietuandanwei" type="text" value="<?php echo trim($baozhang['datatext']['jietuandanwei']) ?>" check="^\S+$" warning="接团单位不能为空,且不能含有空格"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 全陪: </td>
          <td valign="top" scope="row" style="min-width:100px;"><input name="quanpei" type="text" value="<?php echo trim($baozhang['datatext']['quanpei']) ?>" check="^\S+$" warning="全陪不能为空,且不能含有空格"></td>
        </tr>
        <?php } ?>
            <?php if($baozhang['type'] == '签证'){ ?>
        
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 标题: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="title" type="text" style="width:200px;" value="<?php echo trim($baozhang['title']) ?>" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 人数: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="renshu" type="text" value="<?php echo trim($baozhang['renshu']) ?>" check="^\S+$" warning="人数不能为空,且不能含有空格"></td>
        </tr>
        <?php } ?>
        <?php if($baozhang['type'] == '机票'){ ?>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 标题: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="title" type="text" style="width:200px;" value="<?php echo trim($baozhang['title']) ?>" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 人数: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="renshu" type="text" value="<?php echo trim($baozhang['renshu']) ?>" check="^\S+$" warning="人数不能为空,且不能含有空格"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 航班号: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="hangbanhao" type="text" value="<?php echo trim($baozhang['datatext']['hangbanhao']) ?>" check="^\S+$" warning="航班号不能为空,且不能含有空格"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 始发地: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="shifadi" type="text" style="width:200px;" value="<?php echo trim($baozhang['datatext']['shifadi']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 目的地: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="mudidi" type="text" value="<?php echo trim($baozhang['datatext']['mudidi']) ?>"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 起飞时间: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="leavetime" type="text" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" style="width:200px;" value="<?php echo trim($baozhang['datatext']['leavetime']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 抵达时间: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="arrivetime" type="text" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" value="<?php echo trim($baozhang['datatext']['arrivetime']) ?>"></td>
        </tr>
        <?php } ?>
        <?php if($baozhang['type'] == '订房'){ ?>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 标题: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="title" type="text" style="width:200px;" value="<?php echo trim($baozhang['title']) ?>" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 人数: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="renshu" type="text" value="<?php echo trim($baozhang['renshu']) ?>" check="^\S+$" warning="人数不能为空,且不能含有空格"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 酒店名称: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="hotel" type="text" style="width:200px;" value="<?php echo trim($baozhang['datatext']['hotel']) ?>" check="^\S+$" warning="酒店名称不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 联系电话: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="hoteltelnum" type="text" value="<?php echo trim($baozhang['datatext']['hoteltelnum']) ?>" check="^\S+$" warning="联系电话不能为空,且不能含有空格"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 订房时间: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="ordertime" type="text" onfocus="WdatePicker()" style="width:200px;" value="<?php echo trim($baozhang['datatext']['ordertime']) ?>" check="^\S+$" warning="订房时间不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 结算时间: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="jiesuantime" type="text" onfocus="WdatePicker()" value="<?php echo trim($baozhang['datatext']['jiesuantime']) ?>" check="^\S+$" warning="结算时间不能为空,且不能含有空格"></td>
        </tr>
        <?php } ?>
        <?php if($baozhang['type'] == '补账'){ ?>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 标题: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="title" type="text" style="width:200px;" value="<?php echo trim($baozhang['title']) ?>" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
        </tr>
        <?php } ?>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 备注说明: </td>
          <td valign="top" scope="row" colspan="3" style="min-width:200px;"><textarea name="remark" rows="4" style="width:600px;" ><?php echo $baozhang['datatext']['remark'] ?>
</textarea></td>
        </tr>
          </tbody>
        
      </table>
    </form>
    <form id="form_yingshou" name="form_yingshou" >
      <table cellpadding="0" cellspacing="0" width="100%" class="list view" id="yingshou_list">
        <tbody>
          <tr class="pagination">
            <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                <tbody>
                  <tr>
                    <td nowrap="nowrap" class="paginationActionButtons" style=" background:#4E8CCF; color:#FFF"><strong>应收费用</strong>&nbsp;
                      <input class="button" type="button" value=" 新增 " onclick="insertItem('yingshou_list','结算项目');"></td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
          <tr height="20">
            <th scope="col" nowrap="nowrap"> 序号</th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 标题 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 金额 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 方式 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 备注说明 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 审核阶段 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:240px;"><div> 操作 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:40px;"><div> 不打印 </div></th>
          </tr>
            <?php $i = 0;foreach($baozhang['baozhangitemlist'] as $v){if($v['type'] != '结算项目') continue;$i++; ?>
        
        <tr height="30" class="evenListRowS1" id="itemlist<?php echo ($v['chanpinID']); ?>">
          <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
          <td scope="row" align="left" valign="top"><input type="text" name="title" id="title<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['title']); ?>"></td>
          <td scope="row" align="left" valign="top"><input type="text" name="value" style="width:80px;" id="value<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['value']); ?>"></td>
          <td scope="row" align="left" valign="top"><select id="method<?php echo ($v['chanpinID']); ?>">
              <option value="<?php echo ($v['method']); ?>"><?php echo ($v['method']); ?></option>
              <option disabled="disabled">--------</option>
              <option value="现金">现金</option>
              <option value="网拨">网拨</option>
              <option value="银行卡">银行卡</option>
              <option value="汇款">汇款</option>
              <option value="转账">转账</option>
              <option value="支票">支票</option>
              <option value="签单">签单</option>
              <option value="对冲">对冲</option>
            </select></td>
          <td scope="row" align="left" valign="top"><input type="text" name="remark" id="remark<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['remark']); ?>"></td>
          <td scope="row" align="left" valign="top"><?php echo ($v['shenhe_remark']); ?></td>
          <td scope="row" align="left" valign="top"><input class="button" type="button" value="删除" onClick="deleteSystemItem(<?php echo ($v['chanpinID']); ?>,'itemlist')" />
            <input class="button" type="button" value="修改" onClick="if(CheckForm('form_yingshou','resultdiv_2'))save(<?php echo ($v['chanpinID']); ?>,'itemlist<?php echo ($v[chanpinID]); ?>');"/>
  
      <?php $taskom = A("Method")->_checkOMTaskShenhe($v['chanpinID'],'报账项'); if(false !== $taskom){ if(cookie('show_action') == '批准'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('检出','报账项',<?php echo ($v['chanpinID']); ?>,'<?php echo ($v['title']); ?>');">
      <?php }if(cookie('show_action') == '申请'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('申请','报账项',<?php echo ($v['chanpinID']); ?>,'<?php echo ($v['title']); ?>');">
      <?php }}if(A("Method")->checkshenheback($v['chanpinID'],'报账项')){ ?>
      <input type="button" value=" 审核回退 " name="button" onclick="shenhe_back(<?php echo ($v['chanpinID']); ?>,'报账项');">
	  <?php } ?>
      
          <td scope="row" align="left" valign="top"><input type="checkbox" 
            <?php if($v['is_print'] =='不打印'){ ?>
            checked="checked"
            <?php } ?>
            onclick="javascript:dosetprint(this,<?php echo ($v['chanpinID']); ?>);"/></td>
        </tr>
        <?php } ?>
          </tbody>
        
      </table>
    </form>
    <form id="form_yingshou" name="form_yingshou" >
      <table cellpadding="0" cellspacing="0" width="100%" class="list view" id="yingfu_list">
        <tbody>
          <tr class="pagination">
            <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                <tbody>
                  <tr>
                    <td nowrap="nowrap" class="paginationActionButtons" style=" background:#090; color:#FFF"><strong>应付费用</strong>&nbsp;
                      <input class="button" type="button" value=" 新增 " onclick="insertItem('yingfu_list','支出项目');"></td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
          <tr height="20">
            <th scope="col" nowrap="nowrap"> 序号</th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 标题 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 金额 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 方式 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 备注说明 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 审核阶段 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:240px;"><div> 操作 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:40px;"><div> 不打印 </div></th>
          </tr>
            <?php $i = 0;foreach($baozhang['baozhangitemlist'] as $v){ if($v['type'] != '支出项目') continue;$i++; ?>
        
        <tr height="30" class="evenListRowS1" id="itemlist<?php echo ($v['chanpinID']); ?>">
          <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
          <td scope="row" align="left" valign="top"><input type="text" name="title" id="title<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['title']); ?>"></td>
          <td scope="row" align="left" valign="top"><input type="text" name="value" style="width:80px;" id="value<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['value']); ?>"></td>
          <td scope="row" align="left" valign="top"><select id="method<?php echo ($v['chanpinID']); ?>">
              <option value="<?php echo ($v['method']); ?>"><?php echo ($v['method']); ?></option>
              <option disabled="disabled">--------</option>
              <option value="现金">现金</option>
              <option value="网拨">网拨</option>
              <option value="银行卡">银行卡</option>
              <option value="汇款">汇款</option>
              <option value="转账">转账</option>
              <option value="支票">支票</option>
              <option value="签单">签单</option>
              <option value="对冲">对冲</option>
            </select></td>
          <td scope="row" align="left" valign="top"><input type="text" name="remark" id="remark<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['remark']); ?>"></td>
          <td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td>
          <td scope="row" align="left" valign="top"><input class="button" type="button" value="删除" onClick="deleteSystemItem(<?php echo ($v['chanpinID']); ?>,'itemlist')" />
            <input class="button" type="button" value="修改" onClick="if(CheckForm('form_yingshou','resultdiv_2'))save(<?php echo ($v['chanpinID']); ?>,'itemlist<?php echo ($v[chanpinID]); ?>');"/>
      <?php $taskom = A("Method")->_checkOMTaskShenhe($v['chanpinID'],'报账项'); if(false !== $taskom){ if(cookie('show_action') == '批准'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('检出','报账项',<?php echo ($v['chanpinID']); ?>,'<?php echo ($v['title']); ?>');">
      <?php }if(cookie('show_action') == '申请'){ ?>
      <input type="button" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe_baozhangitem('申请','报账项',<?php echo ($v['chanpinID']); ?>,'<?php echo ($v['title']); ?>');">
      <?php }}if(A("Method")->checkshenheback($v['chanpinID'],'报账项')){ ?>
      <input type="button" value=" 审核回退 " name="button" onclick="shenhe_back(<?php echo ($v['chanpinID']); ?>,'报账项');">
	  <?php } ?>
      
          <td scope="row" align="left" valign="top"><input type="checkbox" 
            <?php if($v['is_print'] =='不打印'){ ?>
            checked="checked"
            <?php } ?>
            onclick="javascript:dosetprint(this,<?php echo ($v['chanpinID']); ?>);"/></td>
        </tr>
        <?php } ?>
          </tbody>
        
      </table>
    </form>
    <form id="form_yingshou" name="form_yingshou" >
      <table cellpadding="0" cellspacing="0" width="100%" class="list view" id="lirun_list">
        <tbody>
          <tr class="pagination">
            <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                <tbody>
                  <tr>
                    <td nowrap="nowrap" class="paginationActionButtons" style=" background:#C90; color:#FFF"><strong>利润部门</strong>&nbsp;
                      <input class="button" type="button" value=" 新增 " onclick="insertItem('lirun_list','利润');"></td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
          <tr height="20">
            <th scope="col" nowrap="nowrap"> 序号</th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 标题 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 金额 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 方式 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 备注说明 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 审核阶段 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:240px;"><div> 操作 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:40px;"><div> 不打印 </div></th>
          </tr>
            <?php $i = 0;foreach($baozhang['baozhangitemlist'] as $v){if($v['type'] != '利润') continue;$i++; ?>
        
        <tr height="30" class="evenListRowS1" id="itemlist<?php echo ($v['chanpinID']); ?>">
          <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
          <td scope="row" align="left" valign="top"><input type="text" name="title" id="title<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['title']); ?>"></td>
          <td scope="row" align="left" valign="top"><input type="text" name="value" style="width:80px;" id="value<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['value']); ?>"></td>
          <td scope="row" align="left" valign="top"><select id="method<?php echo ($v['chanpinID']); ?>">
              <option value="<?php echo ($v['method']); ?>"><?php echo ($v['method']); ?></option>
              <option disabled="disabled">--------</option>
              <option value="现金">现金</option>
              <option value="网拨">网拨</option>
              <option value="银行卡">银行卡</option>
              <option value="汇款">汇款</option>
              <option value="转账">转账</option>
              <option value="支票">支票</option>
              <option value="签单">签单</option>
              <option value="对冲">对冲</option>
            </select></td>
          <td scope="row" align="left" valign="top"><input type="text" name="remark" id="remark<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['remark']); ?>"></td>
          <td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td>
          <td scope="row" align="left" valign="top"><input class="button" type="button" value="删除" onClick="deleteSystemItem(<?php echo ($v['chanpinID']); ?>,'itemlist')" />
            <input class="button" type="button" value="修改" onClick="if(CheckForm('form_yingshou','resultdiv_2'))save(<?php echo ($v['chanpinID']); ?>,'itemlist<?php echo ($v[chanpinID]); ?>');"/>
          <td scope="row" align="left" valign="top"><input type="checkbox" 
            <?php if($v['is_print'] =='不打印'){ ?>
            checked="checked"
            <?php } ?>
            onclick="javascript:dosetprint(this,<?php echo ($v['chanpinID']); ?>);"/></td>
        </tr>
        <?php } ?>
          </tbody>
        
      </table>
    </form>
  </div>
</div>
<?php A("Index")->footer(); ?>