<?php if (!defined('THINK_PATH')) exit();?><table class="zsj" width="100%" border="1" cellspacing="0" cellpadding="0">
    <tbody><tr>
        <td height="27" align="center" bgcolor="#ff8d00">
            <strong>名称</strong>
        </td>
        <td height="27" align="center" bgcolor="#ff8d00">
            <strong>团号</strong>
        </td>
        <td height="27" align="center" bgcolor="#ff8d00">
            <strong>行程天数</strong>
        </td>
        <td height="27" align="center" bgcolor="#ff8d00">
            <strong>出团日期</strong>
        </td>
    </tr>
    <tr>
        <td class="xxxx" height="27" align="center">
            <?php echo ($mingcheng); ?>
        </td>
        <td class="xxxx" height="27" align="center">
            <?php echo ($tuanhao); ?>
        </td>
        <td class="xxxx" height="27" align="center">
            <?php echo ($tianshu); ?>天
        </td>
        <td class="xxxx" height="27" align="center">
            <?php echo ($chutuanriqi); ?>
        </td>
    </tr>
</tbody></table>
<br>
<br>
<table class="zsj" width="100%" border="1" cellspacing="0" cellpadding="0">
  <tbody><tr>
      <td height="27" align="center" bgcolor="#ff8d00">
          <strong>姓名</strong></td>
      <td height="27" align="center" bgcolor="#ff8d00">
          <strong>性别</strong></td>
      <td height="27" align="center" bgcolor="#ff8d00">
          <strong>身份</strong></td>
      <td height="27" align="center" bgcolor="#ff8d00">
          <strong>证件类型</strong></td>
      <td height="27" align="center" bgcolor="#ff8d00">
          <strong>证件号</strong></td>
      <td height="27" align="center" bgcolor="#ff8d00">
          <strong>联系电话</strong></td>
      <td align="center" bgcolor="#ff8d00">
          <strong>游客需求</strong></td>
      <td align="center" bgcolor="#ff8d00">
          <strong>订单来源</strong></td>
  </tr>
          <?php foreach($tuanyuan as $dingdan){ ?>
          <tr>
              <td class="xxxx" height="27" align="center">
                  <?php echo ($dingdan['name']); ?>
              </td>
              <td class="xxxx" height="27" align="center">
                  <?php echo ($dingdan['sex']); ?>
              </td>
              <td class="xxxx" height="27" align="center">
                  <?php echo ($dingdan['manorchild']); ?>
              </td>
              <td class="xxxx" height="27" align="center">
                  <?php echo ($dingdan['zhengjiantype']); ?>
              </td>
              <td class="xxxx" height="27" align="center">
                  &nbsp;<?php echo ($dingdan['zhengjianhaoma']); ?>
                  
              </td>
              <td align="center" height="27" class="xxxx">
                  <?php echo ($dingdan['telnum']); ?>
              </td>
              <td align="center" height="27" class="xxxx">
                  <?php echo ($dingdan['remark']); ?>
              </td>
              <td align="center" height="27" class="xxxx">
                  <?php echo ($dingdan['bumen']); ?>
              </td>
          </tr>
          <?php } ?>
</tbody></table>