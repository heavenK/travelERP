<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>打印</title>
<style media="print" type="text/css"> 
.noprint{visibility:hidden} 
</style>
<style>
* {
	font-size:14px;
	line-height:20px;
}
.big_box{ width:900px; margin:0 auto; overflow:hidden;}
.table_item { border-right:1px solid #000; border-top:1px solid #000}
.table_item tr td{ border-left:1px solid #000; border-bottom:1px solid #000}
</style>
</head>
<body>

<div class="big_box">

  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="noprint" style="background:#CCCCCC">
    <tbody>
      <tr>
        <td height="20"><input class="tab" value="打印" onclick="window.print();" type="button">
      </tr>
    </tbody>
  </table>


  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td width="250" height="50" align="left" ><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/logo_p.gif" border="0" height="37" width="223"></td>
        <td align="center"><span style="border-bottom:#000000 1px solid; font-size:26px; font-weight:bold; font-family:'黑体';"><?php echo ($baozhang['type']); ?>结算报告<?php if($doprint == '计调打印'){ ?>(计调打印)<?php } ?></span>&nbsp;</td>
        <td valign="bottom" width="250" align="right"><span style=" font-size:12px; height:20px; overflow:hidden;">填送日期:
          <?php echo date('Y年m月d日',$baozhang[time]); ?>
          &nbsp;&nbsp;&nbsp;&nbsp;单位：元</span></td>
      </tr>
    </tbody>
  </table>
  
  <table width="100%" align="center" cellpadding="0" cellspacing="0" class="table_item">
    <tbody>
    
    <?php if($baozhang['type'] == '签证'){ ?>
      <tr height="28px" >
        <td width="25%">&nbsp;标题：<?php echo ($baozhang['title']); ?></td>
        <td width="25%">&nbsp;人数：<?php echo ($baozhang['renshu']); ?></td>
        <td width="25%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
      </tr>
    <?php } ?>
      
    <?php if($baozhang['type'] == '机票'){ ?>
      <tr height="28px" >
        <td width="25%">&nbsp;标题：<?php echo ($baozhang['title']); ?></td>
        <td width="25%">&nbsp;人数：<?php echo ($baozhang['renshu']); ?></td>
        <td width="25%">&nbsp;航班号:<?php echo ($baozhang['datatext']['hangbanhao']); ?></td>
        <td width="25%">&nbsp;</td>
      </tr>
      <tr height="28px" >
        <td width="25%">&nbsp;始发地：<?php echo ($baozhang['datatext']['shifadi']); ?></td>
        <td width="25%">&nbsp;目的地：<?php echo ($baozhang['datatext']['mudidi']); ?></td>
        <td width="25%">&nbsp;起飞时间：<?php echo ($baozhang['datatext']['leavetime']); ?></td>
        <td width="25%">&nbsp;抵达时间：<?php echo ($baozhang['datatext']['arrivetime']); ?></td>
      </tr>
    <?php } ?>
      
    <?php if($baozhang['type'] == '订房'){ ?>
      <tr height="28px" >
        <td width="25%">&nbsp;标题：<?php echo ($baozhang['title']); ?></td>
        <td width="25%">&nbsp;人数：<?php echo ($baozhang['renshu']); ?></td>
        <td width="25%">&nbsp;酒店名称:<?php echo ($baozhang['datatext']['hotel']); ?></td>
        <td width="25%">&nbsp;联系电话:<?php echo ($baozhang['datatext']['hoteltelnum']); ?></td>
      </tr>
      <tr height="28px" >
        <td width="25%">&nbsp;订房时间：<?php echo ($baozhang['datatext']['shifadi']); ?></td>
        <td width="25%">&nbsp;结算时间：<?php echo ($baozhang['datatext']['mudidi']); ?></td>
        <td width="25%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
      </tr>
    <?php } ?>
      
    <?php if($baozhang['type'] == '补账'){ ?>
      <tr height="28px" >
        <td width="25%">&nbsp;标题：<?php echo ($baozhang['title']); ?></td>
        <td width="25%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
      </tr>
    <?php } ?>
      
      <tr height="28px" >
        <td colspan="4">&nbsp;备注说明：<?php echo ($baozhang['datatext']['remark']); ?></td>
      </tr>
    </tbody>
  </table>
  
  <?php $tem = -1;$i = 0;foreach($baozhang['baozhangitemlist'] as $v){$tem++;if($v['type'] != '结算项目' || $baozhang_data['baozhangitemlist'][$tem]['is_print'] == '不打印') continue; else if($doprint != '计调打印' && $v['status'] != '批准') continue;$i++;} $tem = -1;$j = 0;foreach($baozhang['baozhangitemlist'] as $v){$tem++;if($v['type'] != '支出项目' || $baozhang_data['baozhangitemlist'][$tem]['is_print'] == '不打印') continue; else if($doprint != '计调打印' && $v['status'] != '批准') continue;$j++;} $i_num = 8 - $i; $j_num = 8-$j; ?>
  
  
  <table width="100%" align="center" cellpadding="0" cellspacing="0" style="margin-top:4px;">
    <tbody>
      <tr>
        <td align="left" valign="top">
          <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_item">
            <tr height="28px">
              <td align="center" colspan="5"><b style="font-size:18px;">应  收  款  项</b></td>
            </tr>
            <tr height="28px">
              <td width="30"  align="center">序号 </td>
              <td width="120" align="center">项目</td>
              <td width="70" align="center">金额</td>
              <td width="50" align="center">方式</td>
              <td width="220" align="center">备注</td>
            </tr>
            <?php $tem = -1;$i = 0;foreach($baozhang['baozhangitemlist'] as $v){$tem++;if($v['type'] != '结算项目' || $baozhang_data['baozhangitemlist'][$tem]['is_print'] == '不打印') continue; else if($doprint != '计调打印' && $v['status'] != '批准') continue;$i++; $value_i += $v['value']; ?>
            <tr height="28px">
              <td width="30"  align="center"> <?php echo ($i); ?> </td>
              <td width="120" align="center"> <?php echo ($v['title']); ?> </td>
              <td width="70" align="center"> <?php echo ($v['value']); ?> </td>
              <td width="50" align="center"> <?php echo ($v['method']); ?> </td>
              <td width="220" align="center"> <?php echo ($v['remark']); ?> </td>
            </tr>
        <?php } ?>
        <?php for($t=0;$t<$i_num;$t++){ ?>
            <tr height="28px">
              <td width="30"  align="center"></td>
              <td width="120" align="center"></td>
              <td width="70" align="center"></td>
              <td width="50" align="center"></td>
              <td width="220" align="center"></td>
            </tr>
        <?php } ?>
            <tr height="28px">
              <td width="30"  align="center"> 合计 </td>
              <td width="120" align="center"></td>
              <td width="70" align="center"> <?php echo ($value_i); ?> </td>
              <td width="50" align="center"></td>
              <td width="220"  align="center"></td>
            </tr>
          </table>
        </td>
        <td align="left" valign="top" width="4px" style=" border-bottom:1px #000 solid; border-top:1px #000 solid"></td>
        <td align="left" valign="top">
          <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_item">
            <tr height="28px">
              <td align="center" colspan="5"><b style="font-size:18px;">应  收  款  项</b></td>
            </tr>
            <tr height="28px">
              <td width="30"  align="center">序号 </td>
              <td width="120" align="center">项目</td>
              <td width="70" align="center">金额</td>
              <td width="50" align="center">方式</td>
              <td width="220"  align="center">备注</td>
            </tr>
            <?php $tem = -1;$i = 0;foreach($baozhang['baozhangitemlist'] as $v){$tem++;if($v['type'] != '支出项目' || $baozhang_data['baozhangitemlist'][$tem]['is_print'] == '不打印' ) continue;else if($doprint != '计调打印' && $v['status'] != '批准') continue;$i++; $value_j += $v['value']; ?>
            <tr height="28px">
              <td width="30"  align="center"> <?php echo ($i); ?> </td>
              <td width="120" align="center"> <?php echo ($v['title']); ?> </td>
              <td width="70" align="center"> <?php echo ($v['value']); ?> </td>
              <td width="50" align="center"> <?php echo ($v['method']); ?> </td>
              <td width="220" align="center"> <?php echo ($v['remark']); ?> </td>
            </tr>
        <?php } ?>
        <?php for($t=0;$t<$j_num;$t++){ ?>
            <tr height="28px">
              <td width="30"  align="center"></td>
              <td width="120" align="center"></td>
              <td width="70" align="center"></td>
              <td width="50" align="center"></td>
              <td width="220" align="center"></td>
            </tr>
        <?php } ?>
            <tr height="28px">
              <td width="30"  align="center"> 合计 </td>
              <td width="120" align="center"></td>
              <td width="70" align="center"> <?php echo ($value_j); ?> </td>
              <td width="50" align="center"></td>
              <td width="220"  align="center"></td>
            </tr>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  
  <table width="100%" align="center" cellpadding="0" cellspacing="0" class="table_item" style="margin-top:4px;">
    <tr >
            <?php foreach($baozhang['baozhangitemlist'] as $v){if($v['type'] != '利润') continue;$value_m += $v['value'];} ?>
      <td align="left" height="28px" style="min-width:150px">
      	<table  border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="80" align="center" style="border:none; border-right:#000 solid 1px">本团利润</td>
            <td  width="70" align="center" style="border:none; border-right:#000 solid 1px"><?php echo ($value_m); ?></td>
          </tr>
        </table>
      </td>
            <?php $i = 0;foreach($baozhang['baozhangitemlist'] as $v){if($v['type'] != '利润') continue;$i++; ?>
      <td align="left" height="28px" style="min-width:150px; border-left:none">
        <table  border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="80" align="center" style="border:none; border-right:#000 solid 1px"><?php echo ($v['title']); ?></td>
            <td  width="70" align="center" style="border:none; border-right:#000 solid 1px"><?php echo ($v['value']); ?></td>
          </tr>
        </table>
      </td>
        <?php } ?>
      <td align="left" height="28px" width="100%" style=" border-left:none">
      </td>
      
    </tr>
  </table>
  
  <?php if($doprint != '计调打印'){ ?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top:1px solid #000; margin-top:4px;">
    <tbody>
      <tr>
        <td width="20%" align="left"><strong>总经理：</strong><?php echo ($task[4][user_name]); ?></td>
        <td width="20%" align="left"><strong>财务总监：</strong><?php echo ($task[3][user_name]); ?></td>
        <td width="20%" align="left"><strong>财务审核：</strong><?php echo ($task[2][user_name]); ?></td>
        <td width="20%" align="left"><strong>部门经理：</strong><?php echo ($task[1][user_name]); ?></td>
        <td width="20%" align="left"><strong>操作人：</strong><?php echo ($task[0][user_name]); ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
</div>
</body>
</html>