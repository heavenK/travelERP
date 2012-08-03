<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo __PUBLIC__;?>/gulianstyle/css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo __PUBLIC__;?>/gulianstyle/css/fit.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo __PUBLIC__;?>/gulianstyle/admintemp/ks.css" rel="stylesheet" />
<title>接待计划</title>
</head>

<body>
<div id="hlt_fit_view">
  <div id="control_domestic_order_over"> <a href="javascript:window.print();" class="control_domestic_order_over_c" title="打印"></a> </div>
  <div id="hlt_fit_published"><!--发布新线路页面-->
    <div id="hlt_fit_published_cont">
      <div id="plan_jh">
        <div class="plan_jh_b">接待计划书</div>
        <div id="plan_jh_a">
          <div class="plan_jh_c"><b>致：</b>
            <label style="float:left"><?php echo ($zituan['jiedaijihua']['toperson']); ?></label>
            <b>电话：</b>
            <label style="float:left"><?php echo ($zituan['jiedaijihua']['totelnum']); ?></label>
            <b>传真：</b>
            <label style="float:left"><?php echo ($zituan['jiedaijihua']['tofax']); ?></label>
          </div>
          <div class="plan_jh_d">以下为团号：接待计划，请仔细核查后予以确认并安排接待！</div>
          <div class="plan_jh_e"><b>发件人：</b><span style="margin-right:40px;">大连古莲国旅</span>
            <label style="float:left"><?php echo ($zituan['jiedaijihua']['fromperson']); ?></label>
            <b>电话：</b>
            <label style="float:left"><?php echo ($zituan['jiedaijihua']['fromtelnum']); ?></label>
            <b>传真：</b>
            <label style="float:left"><?php echo ($zituan['jiedaijihua']['fromfax']); ?></label>
          </div>
          <div class="plan_jh_f"><b>线路名称：</b>
            <label style="float:left"><?php echo ($zituan['title_copy']); ?></label>
          </div>
          <div class="plan_jh_g"><b>团号：</b>
            <label style="float:left"><?php echo ($zituan['tuanhao']); ?></label>
          </div>
          <div class="plan_jh_h"><b>出团日期：</b>
            <label style="float:left"><?php echo ($zituan['chutuanriqi']); ?></label>
          </div>
          <div class="plan_jh_i"><b>回团日期：</b>
            <label style="float:left">
              <?php echo jisuanriqi($zituan['chutuanriqi'],$zituan['xianlulist']['xianlu']['tianshu']); ?>
            </label>
          </div>
          <div class="plan_jh_l">
          <b>去程交通：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['tojiaotong']); ?>
          </div>
          <div class="plan_jh_m">
          <b>返程交通：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['backjiaotong']); ?>
          </div>
          <div class="plan_jh_n">
          <b>领队：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['lingdui']); ?>
          </div>
          <div class="plan_jh_o">
          <b>电话：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['lingduitelnum']); ?>
          </div>
          <div class="plan_jh_p">
          <b>地陪姓名：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['dipei']); ?>
          </div>
          <div class="plan_jh_q">
          <b>电话：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['lingduitelnum']); ?>
          </div>
          <div class="plan_jh_r">
          <b>紧急联系人：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['jinjilianxiren']); ?>
          </div>
          <div class="plan_jh_s">
          <b>电话：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['jinjitelnum']); ?>
          </div>
          <div class="plan_jh_r">
          <b>接团标志：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['jietuanmark']); ?>
          </div>
          <div class="plan_jh_s">
          <p>&nbsp;</p>
          <label style="float:left">
          </div>
          <div class="plan_jh_l">
          <b>集合标志：</b>
          <label style="float:left">
          <?php echo ($zituan['jiedaijihua']['jihemark']); ?>
          </div>
          <div class="plan_jh_m"></div>
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
      <div id="plan_bz">
        <div class="plan_ap_a">费用明细</div>
        <div class="plan_ap_b">
          <div class="ks_main" style="width:700px; float:left; overflow:hidden"><!--主体内容--> 
            <del>成本明细</del>
            <div class="ks_main_1st">
              <?php foreach($zituan['xianlulist']['chengben'] as $v ){ ?>
              <div class="ks_main_2nd">
                <div class="ks_main_3rd">
                  <div class="ks_main_3rd_sonbav"><?php echo ($v['title']); ?></div>
                  <div class="ks_main_3rd_cont"><?php echo ($v['price']); ?></div>
                </div>
              </div>
              <?php } ?>
            </div>
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