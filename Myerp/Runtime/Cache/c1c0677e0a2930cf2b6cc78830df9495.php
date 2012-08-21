<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($zituan['xianlulist']['title']); ?></title>
<link type="text/css" href="<?php echo __PUBLIC__;?>/gulianstyle/admintemp/ks.css" rel="stylesheet" />
<script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script>
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
<script>

function save(){
	document.getElementById('form1').submit();
}

</script>


<div class="ks_box" style="margin-top:40px;"> 
  <!--整体-->
            <div id="resultdiv" class="resultdiv"></div>
            <div id="resultdiv_2" class="resultdiv"></div>
    <table width="100%" class="tb1" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td colspan="5" height="32" align="left" ><h4><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/bmbbj.gif"></img> 报名表 </h4></td>
          <td align="right"><a href="javascript:void(0)" onclick="window.history.back();"> <img src="<?php echo __PUBLIC__;?>/gulianstyle/styles/A_ddgl-03.jpg"> </a></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 线路名称： </td>
          <td colspan="5" style="height: 32px"><span id="lbLinename"><?php echo ($zituan['xianlulist']['title']); ?></span></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 团号：</td>
          <td align="left" style="height: 32px"><?php echo ($zituan['tuanhao']); ?></td>
          <td align="left" style="height: 32px"> 出团日期：</td>
          <td align="left" style="height: 32px"><?php echo ($zituan['chutuanriqi']); ?></td>
          <td align="left" style="height: 32px;"> 剩余名额：</td>
          <td align="left" style="height: 32px; "><span id="lbSyno"><?php echo ($shengyu); ?></span></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px;">所属人及所属部门：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['owner'] ?>/<?php echo $bumen['title'] ?></td>
          <td align="left" style="height: 32px"> 可选大客户：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['bigmanID'] ?></td>
          <td align="left" style="height: 32px"> 订单类型：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['type'] ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 联系人：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['lianxiren'] ?></td>
          <td align="left" style="height: 32px"> 联系电话：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['telnum'] ?></td>
          <td align="left" style="height: 32px"> 订单状态：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['status'] ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 成人人数：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['chengrenshu'] ?></td>
          <td align="left" style="height: 32px"> 儿童人数：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['ertongshu'] ?></td>
          <td align="left" style="height: 32px"> 领队人数：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['lingdui_num'] ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 成人价格：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['adultprice'] ?></td>
          <td align="left" style="height: 32px"> 儿童价格：</td>
          <td align="left" style="height: 32px"><?php echo $_REQUEST['childprice'] ?></td>
          <td align="left" style="height: 32px"></td>
          <td align="left" style="height: 32px"></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 备注：</td>
          <td align="left" style="height: 32px"  colspan="5"><?php echo $_REQUEST['remark'] ?></td>
        </tr>
      </tbody>
    </table>
    
  <form name="form1" method="post" action="<?php echo SITE_INDEX;?>Xiaoshou/dopostbaoming" id="form1" >
    <?php foreach($_REQUEST as $key => $val){ ?>
    <input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($val); ?>" />
    <?php } ?>
    <table width="100%" class="tb1 renyuanxinxi" cellpadding="0" cellspacing="0" >
      <tbody>
        <tr>
          <td colspan="8" height="32" align="left" ><h4><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/bmbbj.gif"></img> 人员信息 </h4></td>
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
        </tr>
       <?php $i = 0; foreach($tuanyuan as $vo){$i++; ?>
        <tr>
          <td align="left" style="height: 32px"><input name="name<?php echo ($i); ?>" type="text" check="^\S+$" warning="所有人员姓名不能为空,且不能含有空格"></td>
          <td align="left" style="height: 32px">
          <input type="hidden" name="manorchild<?php echo ($i); ?>" value="<?php echo ($vo['manorchild']); ?>" /><?php echo ($vo['manorchild']); ?>
          </td>
          <td align="left" style="height: 32px">
          <select name="sex<?php echo ($i); ?>">
          <option value="男">男</option>
          <option value="女">女</option>
          </select>
          </td>
          <td align="left" style="height: 32px"><input name="telnum<?php echo ($i); ?>" type="text"></td>
          <td align="left" style="height: 32px">
          <select name="zhengjiantype<?php echo ($i); ?>">
          <option value="身份证">身份证</option>
          <option value="护照">护照</option>
          <option value="通行证">通行证</option>
          </select>
          </td>
          <td align="left" style="height: 32px"><input name="zhengjianhaoma<?php echo ($i); ?>" type="text"></td>
          <td align="left" style="height: 32px"><input name="price<?php echo ($i); ?>" type="text" value="<?php echo ($vo['price']); ?>" ></td>
          <td align="left" style="height: 32px"><input name="remark<?php echo ($i); ?>" type="text"></td>
        </tr>
        <?php } ?>
        
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
          <td align="center" colspan="5" style="height: 32px"><input type="button" value="保 存" id="Button1" class="anu" onClick="if(CheckForm('form1','resultdiv_2'))save()" /></td>
        </tr>
      </tbody>
    </table>
  </form>
  
  
  
  
  
  
  
</div>
</body></html>