<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($xianlu['xianlu']['title']); ?></title>
<link type="text/css" href="<?php echo __PUBLIC__;?>/gulianstyle/admintemp/ks.css" rel="stylesheet" />
<script src="<?php echo __PUBLIC__;?>/gulianstyle/js/jquery.js" type="text/javascript"></script>

		<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
		<script type="text/javascript">
		 
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
		
		
        </script>


<script type="text/javascript">

    function setMeg()
    {
		return true;
		
         var synum="";
         var adult=document.getElementById("chengrenshu");
         var child=document.getElementById("ertongshu");
         var state=document.getElementById("status");
         var person=document.getElementById("lianxiren");
         var phone=document.getElementById("telnum");
		 var adult_price=document.getElementById("adultprice");
		 var child_price=document.getElementById("childprice");
        if(person.value=="")
        {
            alert("请填写联系人");
            person.focus();
            return false;
        }
		
         if(phone.value=="")
        {
            alert("请填写联系人电话");
            phone.focus();
            return false;
        }
        
        if((adult.value=="")&&(child.value==""))
        {
            alert("请输入人数");
             adult.focus();
            return false;
        }
        if((adult.value==0)&&(child.value==0))
        {
            alert("请输入大于0的数字");
            adult.focus();
            return false;
        }
		if((adult_price.value<0)&& (adult_price.value<0))
        {
            alert("请保证成人价格不小于0");
            adult.focus();
            return false;
        }
		if((child_price.value<0)&&(child_price.value<0))
        {
            alert("请保证儿童价格不小于0");
            adult.focus();
            return false;
        }
        if((adult.value>=50)||(child.value>=50))
        {
            alert("请输入小于50的数字");
            adult.focus();
            return false;
        }
        if(state.value=="1"&&(parseInt(adult.value)>parseInt(synum)||parseInt(child.value)>parseInt(synum)||(parseInt(adult.value)+parseInt(child.value))>parseInt(synum)))
        {
            alert("余位不足，请重新填写人数");
            adult.focus();
            return false;
        }
        
        if(state.value=="2"&&(parseInt(adult.value)>parseInt(synum)||parseInt(child.value)>parseInt(synum)||(parseInt(adult.value)+parseInt(child.value))>parseInt(synum)))
        {
            return confirm("余位不足，订单将转为候补状态，确认继续?");
        }
       
        if(if(checktitle())
        {
            alert("所属人填写错误");
            return false;
        }
       
        return　true;
    }

	function Getthisvalue(obj,maxcut,price,tab)
	{
		if (Number(obj.value) > maxcut) {
			obj.value = 0;
			alert('您输入的值超过' +maxcut + '了！');
		}
		document.getElementById(tab).value  = price - Number(obj.value);
	}

    function CheckState()
    {
        var state=document.getElementById("status");
        if(state.value=="1")
        {
            alert("您选择了占位状态，请在48小时内转为确认，否则系统会自动取消该订单！");
        }
        return true;
    }
	
	
	function dochange(id)
	{
		var type = document.getElementById("type").value;
		window.location.href = "<?php echo SITE_MENSHI;?>Index/baoming/zituanID/"+id+"/type/"+type;
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

    <form name="form1" method="post" action="<?php echo SITE_INDEX;?>Xiaoshou/baoming" id="form1">
      <input type="hidden" name="zituanID" value="<?php echo ($chanpinID); ?>" />
      <input type="hidden" name="shoujiaID" value="<?php echo ($shoujiaID); ?>" />
      <table width="100%" class="tb1" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td colspan="3" height="27" align="left" ><h4><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/bmbbj.gif"></img> 报名表 </h4></td>
            <td align="right"><a href="javascript:void(0)" onclick="window.history.back();"> <img src="<?php echo __PUBLIC__;?>/gulianstyle/styles/A_ddgl-03.jpg"> </a></td>
          </tr>
          <tr>
            <td align="left" style="height: 32px"> 线路名称： </td>
            <td colspan="3" style="height: 32px"><span id="lbLinename"><?php echo ($xianlu['xianlu']['title']); ?></span></td>
          </tr>
          <tr>
            <td align="left" style="height: 32px"> 团号：</td>
            <td align="left" style="height: 32px"><?php echo ($zituan['tuanhao']); ?></td>
            <td align="left" style="height: 32px"> 出团日期：</td>
            <td align="left" style="height: 32px"><?php echo ($zituan['chutuanriqi']); ?></td>
          </tr>
          <tr>
            <td align="left" style="height: 27px;"> 剩余名额：</td>
            <td style="height: 27px; width: 288px;"><span id="lbSyno"><?php echo ($shengyu); ?></span></td>
            <td align="left" style="height: 27px; width: 156px;">所属人：</td>
            <td align="left" style="height: 32px">
            	<input type="text" name="owner" id="owner" value="<?php echo $this->tVar['user']['title'] ?>">（绩效奖金）
            </td>
          </tr>
        <tr>
          <td align="left" style="height: 32px"> 可选大客户：</td>
          <td align="left" style="height: 32px"><select name="bigmanID" id="bigmanID">
              <option value="">散客</option>
              <option value="<?php echo ($bigman[id]); ?>"><?php echo ($bigman[title]); ?></option>
            </select>（提成依据）</td>
          <td align="left" style="height: 32px"> 订单类型：</td>
          <td align="left" style="height: 32px"><select name="type" id="type" onchange="javascript:dochange('<?php echo ($zituan['zituanID']); ?>')" >
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
          <td align="left" style="height: 32px"><input name="lianxiren" type="text" id="lianxiren"></td>
          <td align="left" style="height: 32px"> 联系电话：</td>
          <td align="left" style="height: 32px"><input name="telnum" type="text" id="telnum" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')"></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 包含领队数：</td>
          <td align="left" style="height: 32px"><input name="lingdui_num" type="text" id="lingdui_num" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')"></td>
          <td align="left" style="height: 32px"> 订单状态：</td>
          <td align="left" style="height: 32px">
          	<select name="status" id="status" onchange="return CheckState();">
              <option value="占位">占位</option>
              <option value="确认">确认</option>
            </select></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 成人人数：</td>
          <td align="left" style="height: 32px"><input name="chengrenshu" type="text" maxlength="3" id="chengrenshu" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')"></td>
          <td align="left" style="height: 32px"> 儿童人数：</td>
          <td align="left" style="height: 32px"><input name="ertongshu" type="text" maxlength="3" id="ertongshu" onkeyup="this.value=this.value.replace(/[^0-9]/g, '')"></td>
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
          <td align="left" style="height: 32px"> 目前以有<?php echo ($renshu); ?>人报名。</td>
          <td align="left" style="height: 32px" colspan="3"><?php foreach($chengben_all as $key => $chengben){ if($key == 0) echo "当人数小于".$chengben['renshu']."时，成本为".$chengben['chengben']."元。<br />
              "; else { echo "当人数小于".$chengben['renshu']."，大于".$chengben_all[$key-1]['renshu']."时，成本为".$chengben['chengben']."元。<br />
              "; } } ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 备注：</td>
          <td align="left" style="height: 32px"  colspan="3"><input name="remark" type="text"  style="width:300px;" id="remark" value="<?php echo ($remark); ?>" ></td>
        </tr>
        
        <tr>
          <td align="left" style="height: 32px" colspan="4"></td>
        </tr>
        
          </tbody>
        
      </table>
      <hr>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td align="center" colspan="5" style="height: 32px"><input type="submit" value="保 存" id="Button1" onclick="return setMeg();"  class="anu"></td>
          </tr>
        </tbody>
      </table>
    </form>
	</div>
    </body>
</html>