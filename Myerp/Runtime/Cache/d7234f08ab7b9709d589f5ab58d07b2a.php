<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo __PUBLIC__;?>/gulianstyle/css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo __PUBLIC__;?>/gulianstyle/css/fit.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo __PUBLIC__;?>/gulianstyle/admintemp/ks.css" rel="stylesheet" />
<title>出团通知</title>
</head>

<body>
<div id="hlt_fit_view">
  <div id="control_domestic_order_over"> <a href="javascript:window.print();" class="control_domestic_order_over_c" title="打印"></a> </div>
  <div id="hlt_fit_published"><!--发布新线路页面-->
    <div id="hlt_fit_published_cont">
      <div id="plan_jh">
        <div class="plan_jh_b">出团通知书</div>
        <div id="plan_jh_a">
          <div class="plan_jh_c"> 成人
            <?php echo $tuanrenshu['chengrenshu'] + $tuanrenshu['lingduirenshu'] ?>
            人	儿童 <?php echo ($tuanrenshu['ertongrenshu']); ?> 人 </div>
          <div class="plan_jh_c"> 欢迎您们参加我社的旅游团，请您按照下表所示，准时到达指定地点集合。逾时不到，视为自动放弃此团所有行程。届时务必带上本人身份证[16岁以下请带户口本正本]及相关旅游证件，如因证件原因导致行程有误，后果自负。返程交通以当地导游（或取票联系人）告知为准。祝大家旅途愉快！ </div>
          <div class="plan_jh_e"> </div>
          <div class="plan_jh_f"><b>线路名称：</b><?php echo ($zituan['title_copy']); ?></div>
          <div class="plan_jh_g"><b>团号：</b><?php echo ($zituan['tuanhao']); ?></div>
          <div class="plan_jh_h"><b>出团日期：</b><?php echo ($zituan['chutuanriqi']); ?></div>
          <div class="plan_jh_i"><b>回团日期：</b>
            <?php echo jisuanriqi($zituan['chutuanriqi'],$zituan['xianlulist']['xianlu']['tianshu']); ?>
          </div>
          <div class="plan_jh_j"><b>集合时间：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['jihetime']); ?></label>
          </div>
          <div class="plan_jh_k"><b>集合地点：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['jiheplace']); ?></label>
          </div>
          <div class="plan_jh_r"><b>集合标志：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['jietuanmark']); ?></label>
          </div>
          <div class="plan_jh_s"><b>接团标志：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['jinjilianxiren']); ?></label>
          </div>
          <div class="plan_jh_r"><b>去程交通：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['tojiaotong']); ?></label>
          </div>
          <div class="plan_jh_s"><b>返程交通：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['tojiaotong']); ?></label>
          </div>
          <div class="plan_jh_r"><b>领队：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['lingdui']); ?></label>
          </div>
          <div class="plan_jh_s"><b>领队电话：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['lingduitelnum']); ?></label>
          </div>
          <div class="plan_jh_r"><b>地陪：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['dipei']); ?></label>
          </div>
          <div class="plan_jh_s"><b>地陪电话：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['dipeitelnum']); ?></label>
          </div>
          <div class="plan_jh_r"><b>紧急联系人：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['jinjilianxiren']); ?></label>
          </div>
          <div class="plan_jh_s"><b>紧急电话：</b>
            <label style="float:left"><?php echo ($zituan['chutuantongzhi']['jinjitelnum']); ?></label>
          </div>
        </div>
      </div>
      <div id="plan_ap">
        <div class="plan_ap_a">行程安排</div>
        <div class="plan_ap_b">
          <div class="ks_main" style="width:700px; float:left; overflow:hidden"><!--主体内容--> 
            <a name="xyxc"></a> <del>旅游行程</del>
            <div class="ks_main_1st">
              <?php $i = 0;foreach($zituan['xianlulist'][xingcheng] as $v){$i++; ?>
              <div class="ks_main_2nd">
                <div class="ks_main_3rd">
                  <div class="ks_main_3rd_sonbav">第<?php echo ($i); ?>天</div>
                  <div class="ks_main_3rd_cont"><?php echo ($v['content']); ?></div>
                  <div class="ks_main_3rd_bottom"><em>用餐：
                    <?php foreach(unserialize($v['chanyin']) as $xv) echo $xv.','; ?>
                    </em> <em>住宿：<?php echo ($v['place']); ?></em> </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div id="plan_bz">
        <div class="plan_ap_a">备注说明</div>
        <div class="plan_ap_b">
          <div class="ks_main" style="width:700px; float:left; overflow:hidden"><!--主体内容--> 
            <del>参团须知</del>
            <div class="ks_main_1st"> <?php echo ($zituan['xianlulist']['xianlu']['cantuanxuzhi']); ?> </div>
          </div>
        </div>
      </div>
      <div id="plan_ty">
        <div class="plan_ap_a">团员名单</div>
        <div id="plan_ty_box">
          <ol>
            <ul class="plan_ty_box_ul_a">
              <li class="plan_ty_a">姓名 </li>
              <li class="plan_ty_b">性别 </li>
              <li class="plan_ty_c">电话 </li>
              <li class="plan_ty_d">成人|儿童 </li>
              <li class="plan_ty_e">备注 </li>
            </ul>
            <?php foreach($tuanyuan as $v){ ?>
            <ul onmouseover="this.style.backgroundColor='#bce5df'" onmouseout="this.style.backgroundColor=''">
              <li class="plan_ty_a"><?php echo ($v['name']); ?></li>
              <li class="plan_ty_b"><?php echo ($v['sex']); ?></li>
              <li class="plan_ty_c"><?php echo ($v['telnum']); ?></li>
              <li class="plan_ty_d"><?php echo ($v['manorchild']); ?></li>
              <li class="plan_ty_e"><?php echo ($v['remark']); ?></li>
            </ul>
            <?php } ?>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>