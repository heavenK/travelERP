<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>行程打印</title>
<style>
.gl_jsb_box {
	width:700px;
	margin:10px auto;
	overflow:hidden;
}
* {
	font-size:14px;
	line-height:24px;
}
td {
	padding:3px 0;
}
.gl_jsb_td {
	border-bottom:#000000 1px solid;
	border-right:#000000 1px solid;
}
.gl_jsb_td td {
	border-top:#000000 1px solid;
	border-left:#000000 1px solid;
}
.gl_jsb_bottom {
	border-bottom:#000000 1px solid;
}
.gl_td_line {
	font-size:12px;
	line-height:20px;
}
.gl_td_padding {
	padding:0 5px;
	line-height:20px;
	font-size:12px;
}
.gl_td_center {
	text-align:center
}
</style>
<SCRIPT language=javascript>
function printpr()   //预览函数
{
document.all("qingkongyema").click();//打印之前去掉页眉，页脚
document.all("dayinDiv").style.display="none"; //打印之前先隐藏不想打印输出的元素（此例中隐藏“打印”和“打印预览”两个按钮）
var OLECMDID = 7;
var PROMPT = 1; 
var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser); 
WebBrowser1.ExecWB(OLECMDID, PROMPT);
WebBrowser1.outerHTML = "";
document.all("dayinDiv").style.display="";//打印之后将该元素显示出来（显示出“打印”和“打印预览”两个按钮，方便别人下次打印）
} 
function printTure()   //打印函数
{
    document.all('qingkongyema').click();//同上
    document.all("dayinDiv").style.display="none";//同上
    window.print();
    document.all("dayinDiv").style.display="";
}
function doPage()
{
    layLoading.style.display = "none";//同上
}
</SCRIPT>
<script language="VBScript">
dim hkey_root,hkey_path,hkey_key
hkey_root="HKEY_CURRENT_USER"
hkey_path="\Software\Microsoft\Internet Explorer\PageSetup"
'//设置网页打印的页眉页脚为空
function pagesetup_null()
on error resume next
Set RegWsh = CreateObject("WScript.Shell")
hkey_key="\header" 
RegWsh.RegWrite hkey_root+hkey_path+hkey_key,""
hkey_key="\footer"
RegWsh.RegWrite hkey_root+hkey_path+hkey_key,""
end function
'//设置网页打印的页眉页脚为默认值
function pagesetup_default()
on error resume next
Set RegWsh = CreateObject("WScript.Shell")
hkey_key="\header" 
RegWsh.RegWrite hkey_root+hkey_path+hkey_key,"&w&b页码，&p/&P"
hkey_key="\footer"
RegWsh.RegWrite hkey_root+hkey_path+hkey_key,"&u&b&d"
end function
</script>
</head>

<body>
<div class="gl_jsb_box">
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECE9D8" id="dayinDiv" name="dayinDiv">
    <tr>
      <td height="20"><input type="button" class="tab" value="打印" onclick="printTure();">
        <input  type="button" class="tab" value="打印预览" onclick="printpr();">
        <input type="hidden" name="qingkongyema" id="qingkongyema" class="tab" value="清空页码" onclick="pagesetup_null()">
        <input type="hidden" class="tab" value="恢复页码" onclick="pagesetup_default()"></td>
    </tr>
  </table>
</div>
<div id="h" class="gl_jsb_box">
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="gl_jsb_bottom">
    <thead style="display:table-header-group;">
      <tr>
        <td width="210" align="left"><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/dlgllogo.jpg" width="210" height="50" /></td>
        <td width="480" align="center"><span class="gl_td_line">联系人：<?php echo $this->tVar['user']['title'] ?>&nbsp;&nbsp; 联系电话：<?php echo $this->tVar['user']['telnum'] ?> <br />  
          公司地址：<?php echo cookie('_usedbumenaddr') ?> 
          传真：<?php echo cookie('_usedbumenfax') ?>  </span></td>
      </tr>
    </thead>
  </table>
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100%" height="50" align="center" valign="middle" style="padding:30px 0 0 0; "><span style=" border-bottom:#000000 1px solid; font-size:20px; font-weight:bold; "><?php echo ($xianlu['xianlu']['title']); ?></span></td>
    </tr>
  </table>
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="gl_jsb_td">
    <tr>
      <td width="13%" align="center" bgcolor="#FFFFFF">&nbsp;团号：</td>
      <td width="20%" bgcolor="#FFFFFF" class="gl_td_center"><?php echo ($zituan['tuanhao']); ?></td>
      <td width="13%" align="center" bgcolor="#FFFFFF">&nbsp;出团日期：</td>
      <td width="20%" bgcolor="#FFFFFF" class="gl_td_center"><?php echo ($zituan['chutuanriqi']); ?></td>
      <td width="13%" align="center" bgcolor="#FFFFFF">&nbsp;回团日期：</td>
      <td width="20%" bgcolor="#FFFFFF" class="gl_td_center"><?php echo jisuanriqi($zituan['chutuanriqi'],$xianlu['xianlu']['tianshu']); ?></td>
    </tr>
  </table>
  <table width="100%" height="5" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td></td>
    </tr>
  </table>
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="gl_jsb_td">
    <tr>
      <td width="13%" align="center" bgcolor="#FFFFFF">行程特色：</td>
      <td bgcolor="#FFFFFF" class="gl_td_padding"><?php echo ($xianlu['xianlu']['xingchengtese']); ?></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFFF">&nbsp;销售价格：</td>
      <td bgcolor="#FFFFFF" class="gl_td_padding"> 成 人：<?php echo ($shoujia['adultprice']); ?> 元/人            儿童：<?php echo ($shoujia['childprice']); ?> 元/人</td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">&nbsp;旅游行程：</td>
      <td bgcolor="#FFFFFF" class="gl_td_padding"><?php $i = 0;foreach($xianlu[xingcheng] as $v){$i++; ?>
        <div class="ks_main_2nd">
          <div class="ks_main_3rd">
            <div class="ks_main_3rd_sonbav">第<?php echo ($i); ?>天</div>
            <div class="ks_main_3rd_cont"><?php echo ($v['content']); ?></div>
            <div class="ks_main_3rd_bottom"><em>用餐：<?php foreach(unserialize($v['chanyin']) as $xv) echo $xv.','; ?></em> <em>住宿：<?php echo ($v['place']); ?></em> </div>
          </div>
        </div>
        <?php } ?></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">&nbsp;参团须知：</td>
      <td bgcolor="#FFFFFF" class="gl_td_padding"><?php echo ($xianlu['xianlu']['cantuanxuzhi']); ?></td>
    </tr>
  </table>
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="gl_jsb_bottom">
    <thead style="display:table-header-group;">
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="239" align="center"><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/logo_p.gif" width="239" height="34" border="0" /></td>
        <td width="480" align="center"><span class="gl_td_line">联系人：<?php echo $this->tVar['user']['title'] ?>&nbsp;&nbsp; 联系电话：<?php echo $this->tVar['user']['telnum'] ?> <br />  
          公司地址：<?php echo cookie('_usedbumenaddr') ?> 
          传真：<?php echo cookie('_usedbumenfax') ?>  </span></td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="gl_td_line">&nbsp;</td>
      </tr>
    </thead>
  </table>
</div>
</body>
</html>