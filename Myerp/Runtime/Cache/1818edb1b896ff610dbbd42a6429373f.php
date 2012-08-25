<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/Dijie/baozhang.js"></script>
<script type="text/javascript">
var SITE_INDEX = '<?php echo SITE_INDEX;?>';
var parentID = '<?php echo ($baozhangID); ?>';
function save_baozhang(){
	if(CheckForm('form1','resultdiv_2'))
	ThinkAjax.sendForm('form1','<?php echo SITE_INDEX;?>Dijie/dopost_baozhang',doComplete,'resultdiv');
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
		url:	SITE_INDEX+"Dijie/dopost_baozhangitem/dotype/setprint",
		data:	"chanpinID="+id+"&is_print="+value,
		success:	function(msg){
			  ThinkAjax.myAjaxResponse(msg,'resultdiv');
		  }
	});
}

function doprint(type){
	var url = SITE_INDEX+'Dijie/djtuanbaozhang/doprint/'+type+'/chanpinID/<?php echo ($chanpinID); ?>/baozhangID/<?php echo ($baozhangID); ?>';
    window.open(url,null,"height=800,width=1200,status=yes,toolbar=no,menubar=no,location=no");
}

function exports()
{
	window.location.href = SITE_INDEX+'Dijie/djtuanbaozhang/export/1/chanpinID/<?php echo ($chanpinID); ?>/baozhangID/<?php echo ($baozhangID); ?>';
}

function doshenhe_baozhangitem(dotype,datatype,dataID,title){
	ThinkAjax.myloading('resultdiv');
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Dijie/doshenhe",
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
<div id="main"> 
<?php if($chanpinID){ ?>
  <?php A("Dijie")->left_chanpin(); ?>
  <div id="content" style="margin-left:170px;">
<?php }else{ ?>
  <div id="content" style="margin-left:5px; padding-left:0px; border-left:none">
<?php } ?>
    <?php A("Dijie")->header_chanpin(); ?>
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
        <?php if($baozhang['type'] == '订房'){ ?>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 标题:（必填） </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="title" type="text" value="<?php echo trim($baozhang['title']) ?>" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 人数:（必填） </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="renshu" type="text" value="<?php echo trim($baozhang['renshu']) ?>" check="^\S+$" warning="人数不能为空,且不能含有空格"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 酒店名称:（必填） </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="hotel" type="text" value="<?php echo trim($baozhang['datatext']['hotel']) ?>" check="^\S+$" warning="酒店名称不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 联系电话: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="telnum" type="text" value="<?php echo trim($baozhang['datatext']['telnum']) ?>" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 收件单位: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="shoujiandanwei" type="text"  value="<?php echo trim($baozhang['datatext']['shoujiandanwei']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 收件人: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="shoujianren" type="text" value="<?php echo trim($baozhang['datatext']['shoujianren']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 电话: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="shoujiantelnum" type="text" value="<?php echo trim($baozhang['datatext']['shoujiantelnum']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 传真: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="shoujianchuanzhen" type="text" value="<?php echo trim($baozhang['datatext']['shoujianchuanzhen']) ?>"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 发件单位: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="fajiandanwei" type="text" value="<?php echo trim($baozhang['datatext']['fajiandanwei']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 发件人: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="fajianren" type="text" value="<?php echo trim($baozhang['datatext']['fajianren']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 电话: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="fajiantelnum" type="text" value="<?php echo trim($baozhang['datatext']['fajiantelnum']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 传真: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="fajianchuanzhen" type="text" value="<?php echo trim($baozhang['datatext']['fajianchuanzhen']) ?>"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 订房时间: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="dingfangtime" type="text" onfocus="WdatePicker()" value="<?php echo trim($baozhang['datatext']['dingfangtime']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 结算时间: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="jiesuantime" type="text" onfocus="WdatePicker()" value="<?php echo trim($baozhang['datatext']['jiesuantime']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 入住时间: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="ruzhutime" type="text" onfocus="WdatePicker()" value="<?php echo trim($baozhang['datatext']['ruzhutime']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 退房时间: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="tuifangtime" type="text" onfocus="WdatePicker()" value="<?php echo trim($baozhang['datatext']['tuifangtime']) ?>"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 订房标准: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="dingfangbiaozhun" type="text" value="<?php echo trim($baozhang['datatext']['dingfangbiaozhun']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 房间数及价格: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="fangjianjiage" type="text" value="<?php echo trim($baozhang['datatext']['fangjianjiage']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 陪同房: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="peitongfang" type="text" value="<?php echo trim($baozhang['datatext']['peitongfang']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 应付金额: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="yingfujine" type="text" value="<?php echo trim($baozhang['datatext']['yingfujine']) ?>"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 旅行社经办人: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="jingbanren" type="text" value="<?php echo trim($baozhang['datatext']['jingbanren']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 时间: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="jingbanrentime" type="text" onfocus="WdatePicker()" value="<?php echo trim($baozhang['datatext']['jingbanrentime']) ?>"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 酒店经办人: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="hoteljingbanren" type="text" value="<?php echo trim($baozhang['datatext']['hoteljingbanren']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 时间: </td>
          <td valign="top" scope="row" style="min-width:160px;"><input name="hoteljingbanrentime" type="text" onfocus="WdatePicker()" value="<?php echo trim($baozhang['datatext']['hoteljingbanrentime']) ?>"></td>
        </tr>
        <?php } ?>
        
        <?php if($baozhang['type'] == '交通'){ ?>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 标题: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="title" type="text" style="width:200px;" value="<?php echo trim($baozhang['title']) ?>" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 人数: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="renshu" type="text" value="<?php echo trim($baozhang['renshu']) ?>" check="^\S+$" warning="人数不能为空,且不能含有空格"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 列车航班号: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="hangbanhao" type="text" value="<?php echo trim($baozhang['datatext']['hangbanhao']) ?>" check="^\S+$" warning="航班号不能为空,且不能含有空格"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 始发地: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="shifadi" type="text" style="width:200px;" value="<?php echo trim($baozhang['datatext']['shifadi']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 目的地: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="mudidi" type="text" value="<?php echo trim($baozhang['datatext']['mudidi']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 结算时间: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="jiesuantime" type="text" value="<?php echo trim($baozhang['datatext']['jiesuantime']) ?>"></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 起飞时间: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="leavetime" type="text" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" style="width:200px;" value="<?php echo trim($baozhang['datatext']['leavetime']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 抵达时间: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="arrivetime" type="text" onfocus="WdatePicker({startDate:'',dateFmt:'yyyy-MM-dd HH:mm:00',alwaysUseStartDate:true})" value="<?php echo trim($baozhang['datatext']['arrivetime']) ?>"></td>
        </tr>
        <?php } ?>
        
        <?php if($baozhang['type'] == '餐饮' || $baozhang['type'] == '门票' || $baozhang['type'] == '导游'){ ?>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 标题: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="title" type="text" style="width:200px;" value="<?php echo trim($baozhang['title']) ?>" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 人数: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="renshu" type="text" value="<?php echo trim($baozhang['renshu']) ?>" check="^\S+$" warning="人数不能为空,且不能含有空格"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 时间: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="shijian" type="text" value="<?php echo trim($baozhang['datatext']['shijian']) ?>" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 联系电话: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="telnum" type="text" value="<?php echo trim($baozhang['datatext']['telnum']) ?>"></td>
          <td valign="top" scope="row" style="min-width:100px; width:100px;"> 结算时间: </td>
          <td valign="top" scope="row" style="min-width:300px;"><input name="jiesuantime" type="text" value="<?php echo trim($baozhang['datatext']['jiesuantime']) ?>"></td>
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
          <td valign="top" scope="row" colspan="7" style="min-width:200px;"><textarea name="remark" rows="4" style="width:600px;" ><?php echo $baozhang['datatext']['remark'] ?>
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