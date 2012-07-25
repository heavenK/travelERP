<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>游客信息</title>

<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/deprecated (2).css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/colors.sugar.css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/fonts.normal.css">
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/css/gaopeng.css">

<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/gulianstyle/styles/cssaaa.css">
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/WdatePicker.css" rel="stylesheet" type="text/css">
<script language="javascript" src="<?php echo __PUBLIC__;?>/myerp/jquery-1.7.2.min.js" ></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Base.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/prototype.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/mootools.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/ThinkAjax_GP.js"></script>
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script>

</head>
<script>
function save(){
	ThinkAjax.sendForm('form','<?php echo SITE_INDEX;?>Xiaoshou/doposttuanyuanxinxi/',doComplete,'resultdiv');
}
function doComplete(data,status){
}
</script>
<style>
.myaa input { border:none; width:100%; height:100%}
</style>
<body>
<div id="content_bb" style="margin-top:10px;">
    <div id="resultdiv" class="resultdiv"></div>
    <div id="resultdiv_2" class="resultdiv"></div>
<form name="form" id="form" method="post" >
  <input type="hidden" name="id" value="<?php echo ($data['id']); ?>" >
  <div class="jbxxy" style="padding: 20px 15px 20px 15px; border: 1px solid #CCC">
    <table width="100%" border="0" style="background-color: Silver" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td width="60%" height="38" align="left"><h4><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/bmbbj.gif"></img> 游客资料 </h4></td>
          <td>&nbsp;</td>
          <td align="right" width="100"><a class="yyxxl" href="javascript:void(0)"  onClick="if(CheckForm('form','resultdiv_2'))save();">提 交</a></td>
          <td align="right" width="100"><a onclick="window.close();" id="btnClose" class="yyxxl" href="javascript:void(0)">关 闭</a></td>
        </tr>
      </tbody>
    </table>
    <table width="100%" border="1" cellpadding="0" cellspacing="0" class="myaa">
      <tbody>
        <tr>
          <td width="20%" height="30" align="right">姓名：</td>
          <td width="30%" align="left"><input name="name" type="text" value="<?php echo ($data['name']); ?>" check="^\S+$" warning="姓名不能为空,且不能含有空格"></td>
          <td align="right" width="20%"> 性别： </td>
          <td align="left" width="30%"><input name="sex" type="text" value="<?php echo ($data['sex']); ?>"></td>
        </tr>
        <tr>
          <td align="right" height="30"> 出生日期： </td>
          <td align="left"><input name="chushengriqi" onfocus="WdatePicker()" type="text" value="<?php echo ($data['chushengriqi']); ?>"></td>
          <td height="30" align="right"> 联系电话： </td>
          <td align="left"><input name="telnum" type="text" value="<?php echo ($data[telnum]); ?>" check="^\S+$" warning="联系电话不能为空,且不能含有空格"></td>
        </tr>
        <tr>
          <td align="right" height="30"> 姓名拼音：</td>
          <td align="left"><input name="pinyin" type="text" value="<?php echo ($data[pinyin]); ?>"></td>
          <td align="right" height="30"> Email：</td>
          <td align="left"><input name="email" type="text" value="<?php echo ($data[email]); ?>"></td>
        </tr>
        <tr>
          <td align="right" height="30"> 通讯地址： </td>
          <td align="left"><input name="tongxundizhi" type="text" value="<?php echo ($data[tongxundizhi]); ?>"></td>
          <td align="right" height="30"> 邮政编码：</td>
          <td align="left"><input name="pinyin" type="text" value="<?php echo ($data[pinyin]); ?>"></td>
        </tr>
        <tr>
          <td align="right" height="30"> 身份证号码： </td>
          <td align="left"><input name="shenfenzhenghaoma" type="text" value="<?php echo ($data[shenfenzhenghaoma]); ?>"></td>
          <td align="right" height="30"> 身份证签发地：</td>
          <td align="left"><input name="zhengjianfadi" type="text" value="<?php echo ($data[zhengjianfadi]); ?>"></td>
        </tr>
        <tr>
          <td align="right" height="30"> 身份证签日期：</td>
          <td align="left"><input name="zhengjianriqi" type="text" class="Wdate" onfocus="WdatePicker()" value="<?php echo ($data[zhengjianriqi]); ?>"></td>
          <td align="right"> 户籍地：</td>
          <td align="left"><input name="hujidi" type="text" value="<?php echo ($data[hujidi]); ?>"></td>
        </tr>
        <tr>
          <td align="right" height="30"> 国籍：</td>
          <td align="left"><input name="guoji" type="text" value="<?php echo ($data[guoji]); ?>"></td>
          <td align="right" height="30"> 民族：</td>
          <td align="left"><input name="minzu" type="text" value="<?php echo ($data[minzu]); ?>"></td>
        </tr>
        <tr>
          <td align="right" height="30"> 英文姓：</td>
          <td align="left"><input name="yingwenxing" type="text" value="<?php echo ($data[yingwenxing]); ?>"></td>
          <td align="right"> 英文名：</td>
          <td align="left"><input name="yingwenming" type="text" value="<?php echo ($data[yingwenming]); ?>"></td>
        </tr>
        <tr>
          <td align="right" height="30"> QQ：</td>
          <td align="left"><input name="qq" type="text" value="<?php echo ($data[qq]); ?>"></td>
          <td align="right"> MSN：</td>
          <td align="left"><input name="msn" type="text" value="<?php echo ($data[msn]); ?>"></td>
        </tr>
        <tr>
          <td align="right" height="30" rowspan="4"> 护照： </td>
          <td align="left" height="30"> 护照号码：
            <input name="huzhaohaoma" type="text" style="width:65%;" value="<?php echo ($data[huzhaohaoma]); ?>"></td>
          <td align="right" rowspan="4"> 通行证：</td>
          <td align="left" height="30"> 通行证号：
            <input name="tongxingzhenghao" type="text" style="width:65%;" value="<?php echo ($data[tongxingzhenghao]); ?>"></td>
        </tr>
        <tr>
          <td align="left" height="30"> 签 发 地：
            <input name="hzqianfadi" type="text" style="width:65%;" value="<?php echo ($data[hzqianfadi]); ?>"></td>
          <td align="left"> 签 发 地：
            <input name="txzqianfadi" type="text" style="width:65%;" value="<?php echo ($data[txzqianfadi]); ?>"></td>
        </tr>
        <tr>
          <td align="left" height="30"> 签发日期：
            <input name="hzqianfariqi" type="text" class="Wdate" onfocus="WdatePicker()" style="width:65%;" value="<?php echo ($data[hzqianfariqi]); ?>"></td>
          <td align="left"> 签发日期：
            <input name="txzqianfariqi" type="text" class="Wdate" onfocus="WdatePicker()" style="width:65%;" value="<?php echo ($data[txzqianfariqi]); ?>"></td>
        </tr>
        <tr>
          <td align="left" height="30"> 有效日期：
            <input name="hzyouxiaoriqi" type="text" class="Wdate" onfocus="WdatePicker()" style="width:65%;" value="<?php echo ($data[hzyouxiaoriqi]); ?>"></td>
          <td align="left"> 有效日期：
            <input name="txzyouxiaoriqi" type="text" class="Wdate" onfocus="WdatePicker()" style="width:65%;" value="<?php echo ($data[txzyouxiaoriqi]); ?>"></td>
        </tr>
        <tr>
          <td align="right" height="30"> 备注： </td>
          <td align="left" colspan="3"><textarea name="beizhu" rows="5" cols="20" style="width:98%;"><?php echo ($data[beizhu]); ?></textarea></td>
        </tr>
      </tbody>
    </table>
  </div>
  </div>
  <div> </div>
</form>
</div>
</body>
</html>