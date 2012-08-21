<?php if (!defined('THINK_PATH')) exit();?>
<?php A("Index")->showheader(); ?>
<script language="javascript" type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/Chanpin/xianlu.js"></script>
<style>
.tb1 {
	border-left:1px dashed #CCCCCC;
	border-bottom:1px dashed #CCCCCC
}
.tb1 tr td {
	border-top:1px dashed #CCCCCC;
	border-right:1px dashed #CCCCCC
}
.anu {
	BORDER-RIGHT-WIDTH: 0px;
	TEXT-TRANSFORM: uppercase;
	WIDTH: 89px;
	DISPLAY: block;
	BORDER-TOP-WIDTH: 0px;
	BORDER-BOTTOM-WIDTH: 0px;
	HEIGHT: 23px;
	COLOR: #fff;
	BORDER-LEFT-WIDTH: 0px;
	BACKGROUND: url('<?php echo __PUBLIC__;?>/gulianstyle/images/anu.gif') no-repeat left top;
}
.renyuanxinxi tbody tr td input { width:80px; }
</style>

<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
<script>

function save(){
	scroll(0,0);
	ThinkAjax.sendForm('form1','<?php echo SITE_INDEX;?>Xiaoshou/dopostdingdanxinxi/',doComplete,'resultdiv');
}
function doComplete(data,status){
}
		 
var user = [
	 <?php foreach($userlist as $v){ ?>
		  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
	 <?php } ?>
 ];

jQuery().ready(function() {
	  myautocomplete("#owner",'用户');
});
		
 function myautocomplete(target,parenttype)
{
		if(parenttype == '用户')
		datas = user;
		jQuery(target).unautocomplete().autocomplete(datas, {
		   max: 10,    //列表里的条目数
		   minChars: 0,    //自动完成激活之前填入的最小字符
		   width: 150,     //提示的宽度，溢出隐藏
		   scroll:false,
		   matchContains: true,    //包含匹配，就是data参数里的数据，是否只要包含文本框里的数据就显示
		   autoFill: true,    //自动填充
		   formatItem: function(data, i, num) {//多选显示
			   return data.title;
		   },
		   formatMatch: function(data, i, num) {//匹配格式
			   return data.title;
		   },
		   formatResult: function(data) {//选定显示
			   return data.title;
		   }
		})
}

function checktable()
{
	if(CheckForm('form2','resultdiv_2'))
	{
		if(checktitle())
		{
			var state=document.getElementById("status");
			if(state.value=="占位")
				alert("订单为占位状态，请在48小时内转为确认，否则系统会自动取消该订单！");
			ThinkAjax.sendForm('form2','<?php echo SITE_INDEX;?>Xiaoshou/dopostdingdanxinxi/',doComplete,'resultdiv');
		}
		else
			alert("所属人填写错误");
		
	}
	return false;
}


function checktitle(){
	datas = user;
	var title = jQuery("#owner").val();
	var ishas = 0;
	for (var i=0;i<datas.length;i++) { 
		if(title == datas[i]['title']){
			ishas = 1;
			break;
		}
	} 
	if(!ishas){
		return false;
	}
	else{
		return true;
	}
}
    var SITE_INDEX = '<?php echo SITE_INDEX;?>';
    var chanpinID = '<?php echo ($chanpinID); ?>';
	var title =  '编号<?php echo ($chanpinID); ?>订单';
	function doshenhe(dotype){
		ThinkAjax.myloading('resultdiv');
		var dataID = chanpinID;
		var datatype = '订单';
		jQuery.ajax({
			type:	"POST",
			url:	SITE_INDEX+"Chanpin/doshenhe",
			data:	"dataID="+dataID+"&dotype="+dotype+"&datatype="+datatype+"&title="+title,
			success:function(msg){
				ThinkAjax.myAjaxResponse(msg,'resultdiv');
			}
		});
	}
	
 function quxiao(id)
 {
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Xiaoshou/quxiaodingdan",
		data:	"dingdanID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv_2',quxiao_after);
		}
	});
	
 }
 
function quxiao_after(data,status){
	if(status == 1){
		window.location = SITE_INDEX+'Xiaoshou/dingdanlist';
	}
}
 
 
function TravelerDetail(id)
{
    var url=SITE_INDEX+"Xiaoshou/tuanyuanxinxi/id/"+id;
    window.open(url,'newwin','width=900,height=700,left=240,status=no,resizable=yes,scrollbars=yes');
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
</script>


<div id="main">

  <div id="content" style="margin-left:5px; padding-left:0px; border-left:none">
    <div id="resultdiv" class="resultdiv"></div>
    <div id="resultdiv_2" class="resultdiv"></div>
    
    
    <div class="moduleTitle" style="margin-bottom:10px;">
        <div style="float:left; width:70%">
          <h3 style=""><?php echo ($navigation); echo ($datatitle); ?></h3>
        </div>
        <div style="float:left; width:30%; margin-top:6px;">
              <span style="float:right; margin-left:20px;">
              <img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助" ><a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a> 
              </span>
        </div>
    </div>
      
      <div class="buttons">
            <input type="button" value="审核记录" name="button" class="button primary" style="float:right" onclick="shenheshow_doit(<?php echo ($chanpinID); ?>,this);">
          
      <?php $taskom = A("Method")->_checkOMTaskShenhe($chanpinID,'订单'); if(false !== $taskom){ if(cookie('show_action') == '批准'){ ?>
      <input type="button" style="float:right" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe('检出');">
      <?php }if(cookie('show_action') == '申请'){ ?>
      <input type="button" style="float:right" value=" <?php echo cookie('show_word'); ?> " name="button" onclick="doshenhe('申请');">
      <?php }}if(A("Method")->checkshenheback($chanpinID,'订单')){ ?>
      <input type="button" style="float:right" value=" 审核回退 " name="button" onclick="shenhe_back(<?php echo ($chanpinID); ?>,'订单');">
	  <?php } ?>
          
          <input type="button" value=" 取消订单 " name="button" class="button primary" onClick="quxiao('<?php echo ($chanpinID); ?>');">
      </div>
      
  <form name="form2" method="post" action="<?php echo SITE_INDEX;?>Xiaoshou/dopostdingdanxinxi" id="form2" >
      <input type="hidden" name="dingdanID" value="<?php echo ($chanpinID); ?>" />
    <table width="100%" class="tb1" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td colspan="5" height="32" align="left" ><h4><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/bmbbj.gif"></img> 报名表 </h4></td>
          <td align="right"><a href="javascript:void(0)" onclick="window.history.back();"> <img src="<?php echo __PUBLIC__;?>/gulianstyle/styles/A_ddgl-03.jpg"> </a></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 标题： </td>
          <td colspan="5" style="height: 32px"><?php echo ($dingdan['title']); ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px; min-width:80px; width:10%"> 团号：</td>
          <td align="left" style="height: 32px; min-width:80px; width:20%"><?php echo ($dingdan['zituan']['tuanhao']); ?></td>
          <td align="left" style="height: 32px; min-width:80px; width:10%"> 出团日期：</td>
          <td align="left" style="height: 32px; min-width:80px; width:20%"><?php echo ($dingdan['zituan']['chutuanriqi']); ?></td>
          <td align="left" style="height: 32px; min-width:80px; width:10%"> 剩余名额：</td>
          <td align="left" style="height: 32px; min-width:80px; width:20%"><?php echo ($shengyu); ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px;">所属人及部门：</td>
          <td align="left" style="height: 32px">
            <input type="text" name="owner" id="owner" style="width:50px;" value="<?php echo ($dingdan['owner']); ?>" check="^\S+$" warning="所有人员姓名不能为空,且不能含有空格">
              <select name="departmentID">
              <?php if($dingdan['bumen_copy']){ ?>
                <option value="<?php echo ($dingdan['departmentID']); ?>"><?php echo ($dingdan['bumen_copy']); ?></option>
                <option disabled="disabled">-----------</option>
              <?php } ?>
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
          <td align="left" style="height: 32px"> 提成类型：</td>
          <td align="left" style="height: 32px">
			<select name="tichengID" id="tichengID">
            	<?php if($dingdan['ticheng']['title']){ ?>
                <option value="<?php echo ($dingdan['ticheng']['systemID']); ?>"><?php echo ($dingdan['ticheng']['title']); ?>:<?php echo ($dingdan['ticheng']['description']); ?>%</option>
                <option disabled="disabled">---------------</option>
            	<?php } ?>
          		<?php foreach($ticheng as $tiv){ ?>
                <option value="<?php echo ($tiv['systemID']); ?>"><?php echo ($tiv['title']); ?>:<?php echo ($tiv['description']); ?>%</option>
                <?php } ?>
			</select>
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
          <td align="left" style="height: 32px"> 订单类型：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['type']); ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 联系人：</td>
          <td align="left" style="height: 32px">
            <input type="text" name="lianxiren" style="width:80px;" value="<?php echo ($dingdan['lianxiren']); ?>" check="^\S+$" warning="联系人不能为空,且不能含有空格">
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
          <td align="left" style="height: 32px"> 联系电话：</td>
          <td align="left" style="height: 32px">
            <input type="text" name="telnum" style="width:80px;" value="<?php echo ($dingdan['telnum']); ?>" check="^\S+$" warning="联系电话不能为空,且不能含有空格">
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
          <td align="left" style="height: 32px"> 订单状态：</td>
          <td align="left" style="height: 32px">
            <select name="status" id="status">
            	<?php if($dingdan['status']){ ?>
                <option value="<?php echo ($dingdan['status']); ?>"><?php echo ($dingdan['status']); ?></option>
                <option disabled="disabled">---------------</option>
            	<?php } ?>
                <option value="占位">占位</option>
                <option value="确认">确认</option>
                <option value="候补">候补</option>
			</select>
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 成人数：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['chengrenshu']); ?></td>
          <td align="left" style="height: 32px"> 儿童数：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['ertongshu']); ?></td>
          <td align="left" style="height: 32px"> 领队数：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['lingdui_num']); ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 成人价格：</td>
          <td align="left" style="height: 32px"><?php echo $shoujia['adultprice'] ?></td>
          <td align="left" style="height: 32px"> 儿童价格：</td>
          <td align="left" style="height: 32px"><?php echo $shoujia['childprice'] ?></td>
          <td align="left" style="height: 32px"> 预期成本：</td>
          <td align="left" style="height: 32px"><?php echo $shoujia['chengben'] ?>元</td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 售价：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['jiage']); ?></td>
          <td align="left" style="height: 32px"> 操作人：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['user_name']); ?></td>
          <td align="left" style="height: 32px"> 折扣范围:</td>
          <td align="left" style="height: 32px"><?php echo $shoujia['cut'] ?>元</td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 备注：</td>
          <td align="left" style="height: 32px"  colspan="5"><?php echo ($dingdan['remark']); ?></td>
        </tr>
      </tbody>
    </table>
  </form>
    
    
  <form name="form1" method="post" id="form1" >
      <input type="hidden" name="tuanyuanmark" value="1" />
      <input type="hidden" name="dingdanID" value="<?php echo ($chanpinID); ?>" />
      <input type="hidden" name="shoujiaID" value="<?php echo ($dingdan['shoujiaID']); ?>" />
    <table width="100%" class="tb1 renyuanxinxi" cellpadding="0" cellspacing="0" >
      <tbody>
        <tr>
          <td colspan="10" height="32" align="left" >
          <h4 style="float:left"><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/bmbbj.gif"></img> 人员信息 </h4> 
          </td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 姓名： </td>
          <td align="left" style="height: 32px"> 类型： </td>
          <td align="left" style="height: 32px"> 性别： </td>
          <td align="left" style="height: 32px"> 联系电话： </td>
          <td align="left" style="height: 32px"> 证件类型： </td>
          <td align="left" style="height: 32px"> 证件号码： </td>
          <td align="left" style="height: 32px"> 应付： </td>
          <td align="left" style="height: 32px"> 备注： </td>
          <td align="left" style="height: 32px"> 详细资料： </td>
        </tr>
       <?php $i = 0; foreach($tuanyuan as $vo){$i++; ?>
       <input type="hidden" name="tuanyuanID<?php echo ($i); ?>" value="<?php echo ($vo['id']); ?>" />
       <input type="hidden" name="datatext<?php echo ($i); ?>" value="<?php echo ($vo['datatext']); ?>" />
        <tr>
          <td align="left" style="height: 32px"><input type="text" name="name<?php echo ($i); ?>" value="<?php echo ($vo['name']); ?>" check="^\S+$" warning="所有人员姓名不能为空,且不能含有空格"></td>
          <td align="left" style="height: 32px"><input type="hidden" name="manorchild<?php echo ($i); ?>" value="<?php echo ($vo['manorchild']); ?>" /><?php echo ($vo['manorchild']); ?></td>
          <td align="left" style="height: 32px">
          <select name="sex<?php echo ($i); ?>">
       <?php if($vo['sex']){ ?>
          <option value="<?php echo ($vo['sex']); ?>"><?php echo ($vo['sex']); ?></option>
          <option disabled="disabled">----------------</option>
       <?php } ?>
          <option value="男">男</option>
          <option value="女">女</option>
          </select>
          </td>
          <td align="left" style="height: 32px"><input name="telnum<?php echo ($i); ?>" type="text" value="<?php echo ($vo['telnum']); ?>"></td>
          <td align="left" style="height: 32px">
          <select name="zhengjiantype<?php echo ($i); ?>">
       <?php if($vo['zhengjiantype']){ ?>
          <option value="<?php echo ($vo['zhengjiantype']); ?>"><?php echo ($vo['zhengjiantype']); ?></option>
          <option disabled="disabled">----------------</option>
       <?php } ?>
          <option value="身份证">身份证</option>
          <option value="护照">护照</option>
          <option value="通行证">通行证</option>
          </select>
          </td>
          <td align="left" style="height: 32px"><input name="zhengjianhaoma<?php echo ($i); ?>" type="text" value="<?php echo ($vo['zhengjianhaoma']); ?>"></td>
          <td align="left" style="height: 32px"><input name="price<?php echo ($i); ?>" type="text" value="<?php echo ($vo['price']); ?>"></td>
          <td align="left" style="height: 32px"><input name="remark<?php echo ($i); ?>" type="text" value="<?php echo ($vo['remark']); ?>"></td>
          <td align="left" style="height: 32px"><a href="javascript:TravelerDetail(<?php echo ($vo['id']); ?>)">查看</a></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="10" height="32" align="center" >
          <input style="width:60px;" class="button" type="button" value=" 保存 " onClick="if(CheckForm('form1','resultdiv_2'))save();">
          </td>
        </tr>
        
      </tbody>
    </table>
  </form>
        
        
            
  </div>
</div>

<?php A("Index")->footer(); ?>
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