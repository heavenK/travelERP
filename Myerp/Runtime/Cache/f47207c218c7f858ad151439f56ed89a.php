<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($xianlu['xianlu']['title']); ?></title>
<link type="text/css" href="<?php echo __PUBLIC__;?>/gulianstyle/admintemp/ks.css" rel="stylesheet" />

<script language="javascript" src="<?php echo __PUBLIC__;?>/myerp/jquery-1.7.2.min.js" ></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/mootools.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/ThinkAjax_GP.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script>

<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
<script type="text/javascript">
function save(){
	ThinkAjax.sendForm('form1','<?php echo SITE_INDEX;?>Xiaoshou/baoming/ajaxtest/1',doComplete,'resultdiv');
}
function doComplete(data,status){
	if(status == 1){
		document.getElementById('form1').action='<?php echo SITE_INDEX;?>Xiaoshou/baoming';
		document.getElementById('form1').submit();
	}
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
	if(CheckForm('form1','resultdiv_2'))
	{
		if(checktitle()){
			var state=document.getElementById("status");
			if(state.value=="占位")
				alert("订单为占位状态，请在48小时内转为确认，否则系统会自动取消该订单！");
			save();
		}
		else
			ajaxalert("所属人填写错误");
	}
}

function CheckState()
{
	var state=document.getElementById("status");
	if(state.value=="占位")
		alert("订单为占位状态，请在48小时内转为确认，否则系统会自动取消该订单！");
	return true;
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

function ajaxalert(title){
	document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+title+'</div>';
	jQuery("#resultdiv_2").show("fast"); 
	this.intval = window.setTimeout(function (){
		document.getElementById('resultdiv_2').style.display='none';
		document.getElementById('resultdiv_2').innerHTML='';
		},3000);
}
</script>    
    
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
</style>
    <div class="ks_box" style="margin-top:40px;">
    <!--整体-->
            <div id="resultdiv" class="resultdiv"></div>
            <div id="resultdiv_2" class="resultdiv"></div>
    <form name="form1" method="post" id="form1" >
      <input type="hidden" name="title" value="<?php echo ($xianlu['xianlu']['title']); ?>/<?php echo ($zituan['chutuanriqi']); ?>" />
      <input type="hidden" name="zituanID" value="<?php echo ($chanpinID); ?>" />
      <input type="hidden" name="shoujiaID" value="<?php echo ($shoujiaID); ?>" />
      <table width="100%" class="tb1" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="3" height="32" align="left" ><h4><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/bmbbj.gif"></img> 报名表 </h4></td>
            <td align="right"><a href="javascript:void(0)" onclick="window.history.back();"> <img src="<?php echo __PUBLIC__;?>/gulianstyle/styles/A_ddgl-03.jpg"> </a></td>
          </tr>
          <tr>
            <td align="left" style="height: 32px"> 线路名称： </td>
            <td colspan="3" style="height: 32px"><?php echo ($xianlu['xianlu']['title']); ?></td>
          </tr>
          <tr>
            <td align="left" style="height: 32px"> 团号：</td>
            <td align="left" style="height: 32px"><?php echo ($zituan['tuanhao']); ?></td>
            <td align="left" style="height: 32px"> 出团日期：</td>
            <td align="left" style="height: 32px"><?php echo ($zituan['chutuanriqi']); ?></td>
          </tr>
          <tr>
            <td align="left" style="height: 27px;"> 剩余名额：</td>
            <td style="height: 27px; width: 288px;"><?php echo $shengyurenshu ?></td>
            <td align="left" style="height: 27px; width: 156px;">所属人及所属部门：</td>
            <td align="left" style="height: 32px">
            	<input type="text" style="width:50px;" name="owner" id="owner" value="<?php echo $this->tVar['user']['title'] ?>">
              <select name="departmentID">
              <?php foreach($bumenfeilei as $v){ ?>
                <option value="<?php echo ($v['bumenID']); ?>"><?php echo ($v['title']); ?></option>
              <?php } ?>
              </select>
                （绩效奖金）
            </td>
          </tr>
        <tr>
          <td align="left" style="height: 32px"> 提成类型：</td>
          <td align="left" style="height: 32px"><select name="tichengID" id="tichengID">
          		<?php foreach($ticheng as $tiv){ ?>
                <option value="<?php echo ($tiv['systemID']); ?>"><?php echo ($tiv['title']); ?>:<?php echo ($tiv['description']); ?>%</option>
                <?php } ?>
            </select>（提成依据）</td>
          <td align="left" style="height: 32px"> 订单类型：</td>
          <td align="left" style="height: 32px"><select name="type" id="type">
              <?php if($type){ ?>
              <option value="<?php echo $shoujia['chengben'] ?>"><?php echo $shoujia['type'] ?></option>
              <option disabled="disabled">--------------</option>
              <?php } ?>
              <option value="标准">标准</option>
              <option value="机票酒店">机票酒店</option>
            </select></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 联系人：</td>
          <td align="left" style="height: 32px"><input name="lianxiren" type="text" id="lianxiren" check="^\S+$" warning="联系人不能为空,且不能含有空格"></td>
          <td align="left" style="height: 32px"> 联系电话：</td>
          <td align="left" style="height: 32px"><input name="telnum" type="text" id="telnum" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" check="^\S+$" warning="联系电话不能为空,且不能含有空格"></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 包含领队数：</td>
          <td align="left" style="height: 32px"><input name="lingdui_num" type="text" id="lingdui_num" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="0"></td>
          <td align="left" style="height: 32px"> 订单状态：</td>
          <td align="left" style="height: 32px">
          	<select name="status" id="status" onchange="return CheckState();">
              <option value="占位">占位</option>
              <option value="确认">确认</option>
            </select></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 成人人数：</td>
          <td align="left" style="height: 32px"><input name="chengrenshu" type="text" maxlength="3" id="chengrenshu" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="0"></td>
          <td align="left" style="height: 32px"> 儿童人数：</td>
          <td align="left" style="height: 32px"><input name="ertongshu" type="text" maxlength="3" id="ertongshu" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="0"></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 建议售价：</td>
          <td align="left" style="height: 32px">成人<?php echo $shoujia['adultprice']; ?>元,儿童<?php echo $shoujia['childprice'] ?>元</td>
          <td align="left" style="height: 32px"> 预期成本：</td>
          <td align="left" style="height: 32px"><a id="cbta" href="javascript:jQuery('#chengbenxianshi').show();javascript:jQuery('#cbta').hide();">查看</a><span id='chengbenxianshi' style="display:none"><?php echo $shoujia['chengben'] ?>元</span></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 成人价格：</td>
          <td align="left" style="height: 32px"><input name="adultprice" type="text" id="adultprice" value="<?php echo $shoujia['adultprice']; ?>" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
          (折扣范围:<?php echo $shoujia['cut'] ?>元)
          </td>
          <td align="left" style="height: 32px"> 儿童价格：</td>
          <td align="left" style="height: 32px"><input name="childprice" type="text" id="childprice" value="<?php echo $shoujia['childprice']; ?>" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
          (折扣范围:<?php echo $shoujia['cut'] ?>元)
          </td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 儿童及其他说明。</td>
          <td align="left" style="height: 32px" colspan="3"><?php echo ($xianlu['xianlu']['remark']); ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 备注：</td>
          <td align="left" style="height: 32px"  colspan="3"><input name="remark" type="text"  style="width:300px;" id="remark" value="<?php echo ($remark); ?>" ></td>
        </tr>
        
        <tr>
          <td align="left" style="height: 32px" colspan="4"></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 验证码：</td>
          <td align="left" style="height: 32px" colspan="7"><input style=" height:18px;width:80px;float:left; margin-right:5px;" type='text' name='verifyTest'>
            <img style="float:left" style='cursor:pointer' title='刷新验证码' src='<?php echo SITE_INDEX;?>Index/verify' id='verifyImg' onClick='freshVerify()'/>（提示验证码错误可点击图片重新生成验证码）</td>
        </tr>
        
        <script type='text/javascript'>  
		//重载验证码  
		function freshVerify() {  
		  document.getElementById('verifyImg').src='<?php echo SITE_INDEX;?>Index/verify/'+Math.random();  
		}  
		</script>
          </tbody>
        
      </table>
      <hr>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td align="center" colspan="5" style="height: 32px"><input type="button" value="提交" onClick="return checktable();"  class="anu"></td>
          </tr>
        </tbody>
      </table>
    </form>
	</div>
    </body>
</html>