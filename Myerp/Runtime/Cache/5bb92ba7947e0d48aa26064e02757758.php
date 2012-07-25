<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($xianlu['xianlu']['title']); ?></title>
<link type="text/css" href="<?php echo __PUBLIC__;?>/gulianstyle/admintemp/ks.css" rel="stylesheet" />
<script src="<?php echo __PUBLIC__;?>/gulianstyle/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo __PUBLIC__;?>/gulianstyle/js/jquery.KinSlideshow-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo __PUBLIC__;?>/gulianstyle/js/tanchukuang.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$("#KinSlideshow").KinSlideshow();
})

</script>
</head>

<body>
  
<div class="ks_box"><!--整体-->

  <dl class="ks_mainbav" style="margin-top:40px;">
    <!--主导航-->
    <dt></dt>
    <dd>线路创建于：
      <?php echo date('Y-m-d',$zituan['time']); ?>
    </dd>
  </dl>
  
  <?php if($xianlu['xianlu']['shipin']){ ?>
  <div class="float_layer" id="miaov_float_layer" style="width:320px;">
    <h2> <strong>线路景色</strong> <a id="btn_min" href="javascript:;" class="min"></a> <a id="btn_close" href="javascript:;" class="close"></a> </h2>
    <div class="content" style=" height:270px;">
      <div class="wrap">
        <embed src="<?php echo ($shipin['video_url']); ?>" allowFullScreen="true" quality="high" width="300" height="250" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
      </div>
    </div>
  </div>
  <?php } ?>
  
  <dl class="ks_title">
    <!--标题-->
    <dt><?php echo ($xianlu['xianlu']['title']); ?></dt>
    <dd><a href="javascript:doPrint()"></a></dd>
  </dl>
  
  <dl class="ks_cont">
    <!--内容-->
    <dt> 
    <?php if($xianlu['companytype'] == '同业'){ ?>
    <img src="<?php echo __PUBLIC__;?>/gulianstyle/images/tongyemark_1.jpg" width="328" height="95" style=" margin:0 0 4px 0; display:inline;" /> 
    <?php }else{ ?>
    <img src="<?php echo __PUBLIC__;?>/gulianstyle/images/gulianmark_1.jpg" width="328" height="95" style=" margin:0 0 4px 0; display:inline;" /> 
    <?php } ?>
    <i>
  <u id="KinSlideshow" style="visibility:hidden;">
  <?php if($xianlu['xianlu']['tupian']){ ?>
    <?php foreach($tupian as $v){ ?>
    <a href="javascript:void(0)"><img src="<?php echo SITE_DATA;?>Attachments/m_<?php echo ($v[pic_url]); ?>" width="316" height="201" /></a>
    <?php } ?>
  <?php }else{ ?>
    <?php if($xianlu['companytype'] == '同业'){ ?>
    <img src="<?php echo __PUBLIC__;?>/gulianstyle/images/tongyemark.jpg" width="316" height="201" />
    <?php }else{ ?>
    <img src="<?php echo __PUBLIC__;?>/gulianstyle/images/gulianmark.jpg" width="316" height="201" /> 
    <?php } ?>
  <?php } ?>
  </u>
    </i> </dt>
    <dd> <em>
      <ol>
        <li>成人价：<h1>¥<?php echo ($shoujia['adultprice']); ?></h1>起</li>
        <li>儿童价：<h1>¥<?php echo ($shoujia['childprice']); ?></h1> 起</li>
      </ol>
      <ul>
        <li>
          <p>团号：<b><?php echo ($zituan['tuanhao']); ?></b></p>
          <p>剩余名额：<b><?php echo $shengyurenshu ?></b></p>
        </li>
        <li>
          <p>天数：<b><?php echo ($xianlu['xianlu']['tianshu']); ?>天</b></p>
          <p>计划人数：<b><?php echo ($zituan['renshu']); ?>人</b></p>
        </li>
        <li>
          <p>出团日期：<b><?php echo ($zituan['chutuanriqi']); ?></b></p>
          <p>回团日期：<b><?php echo jisuanriqi($zituan['chutuanriqi'],$xianlu['xianlu']['tianshu']); ?></b></p>
        </li>
        <li>
          <p>出发城市：<b><?php echo ($xianlu['xianlu']['chufadi']); ?></b></p>
          <p>目的城市：<b><?php echo ($xianlu['xianlu']['mudidi']); ?></b></p>
        </li>
        <li>
          <p>截止日期：<b><?php echo jisuanriqi($zituan['chutuanriqi'],$zituan['baomingjiezhi'],'减少'); ?></b></p>
          <p>儿童及其他说明：<b><?php echo ($xianlu['xianlu']['remark']); ?></b></p>
        </li>
        <li><span>导游服务：<b><?php echo ($xianlu['xianlu']['daoyoufuwu']); ?></b></span></li>
        <li><span>创建者：<b>[<?php echo ($zituan['user_name']); ?>]办公电话:<?php foreach($userdurlist as $v) echo $v['officetel'].',' ?> </b></span></li>
      </ul>
      <u>
      <?php if($baoming_root == 1){ ?>
      <a href="<?php echo SITE_INDEX;?>Xiaoshou/zituan/dobaoming/报名/chanpinID/<?php echo ($chanpinID); ?>/xianluID/<?php echo ($xianluID); ?>/shoujiaID/<?php echo ($shoujiaID); ?>"></a>
      <?php }else{ ?>
      <a href="javascript:alert('报名截止');"></a>
      <?php } ?>
      </u> </em> </dd>
  </dl>
  <div class="ks_inof">
    <h2><?php echo ($xianlu['xianlu']['xingchengtese']); ?></h2>
  </div>
  <div class="ks_sonbav" style="margin-top:10px;"><!--子导航--> 
    <a href="#xyxc">旅游行程</a><a href="#ctxz">参团须知</a>
  <?php if($xianlu['xianlu']['guojing'] == '境外'){ ?>
    <a href="#fybh">费用包含</a><a href="#fybbh">费用不包含</a><a href="#qzxx">签证信息</a><a href="#kxzf">可选自费</a><a href="#gwxx">购物信息</a><a href="#ydtk">预定条款</a><a href="#cxjs">出行警示</a> 
  <?php } ?>
  </div>
  <?php if($xianlu['xianlu']['xianlutype'] != '自由人'){ ?>
  <div class="ks_main"><!--主体内容--> 
  <a name="xyxc"></a>
    <del>旅游行程</del>
    <div class="ks_main_1st">
      <?php $i = 0;foreach($xianlu[xingcheng] as $v){$i++; ?>
      <div class="ks_main_2nd">
        <div class="ks_main_3rd">
          <div class="ks_main_3rd_sonbav">第<?php echo ($i); ?>天</div>
          <div class="ks_main_3rd_cont"><?php echo ($v['content']); ?></div>
          <div class="ks_main_3rd_bottom"><em>用餐：<?php foreach(unserialize($v['chanyin']) as $xv) echo $xv.','; ?></em> <em>住宿：<?php echo ($v['place']); ?></em> </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
  <a name="ctxz"></a>
  <div class="ks_main" ><!--主体内容--> 
    <del>参团须知</del>
    <div class="ks_main_1st"> <?php echo ($xianlu['xianlu']['cantuanxuzhi']); ?> </div>
  </div>
  
  <?php if($xianlu['guojing'] == '境外'){ ?>
  <a name="fybh"></a>
  <div class="ks_main"><!--主体内容--> 
    <del>费用包含</del>
    <div class="ks_main_1st"> <?php echo ($xianlu['ext']['feiyongyes']); ?> </div>
  </div>
  <a name="fybbh"></a>
  <div class="ks_main"><!--主体内容--> 
    <del>费用不包含</del>
    <div class="ks_main_1st"> <?php echo ($xianlu['ext']['feiyongno']); ?> </div>
  </div>
  <a name="qzxx"></a>
  <div class="ks_main"><!--主体内容--> 
    <del>签证信息</del>
    <div class="ks_main_1st"> <?php echo ($xianlu['ext']['qianzhengxinxi']); ?> </div>
  </div>
  <a name="kxzf"></a>
  <div class="ks_main"><!--主体内容--> 
    <del>可选自费</del>
    <div class="ks_main_1st"> <?php echo ($xianlu['ext']['kexuanzifei']); ?> </div>
  </div>
  <a name="gwxx"></a>
  <div class="ks_main"><!--主体内容--> 
    <del>购物信息</del>
    <div class="ks_main_1st"> <?php echo ($xianlu['ext']['gouwuxinxi']); ?> </div>
  </div>
  <a name="ydtk"></a>
  <div class="ks_main"><!--主体内容--> 
    <del>预定条款</del>
    <div class="ks_main_1st"> <?php echo ($xianlu['ext']['yudingtiaokuan']); ?> </div>
  </div>
  <a name="cxjs"></a>
  <div class="ks_main"><!--主体内容--> 
    <del>出行警示</del>
    <div class="ks_main_1st"> <?php echo ($xianlu['ext']['chuxingjingshi']); ?> </div>
  </div>
  <?php } ?>
  
  <div class="ks_footer"><!--底部--> 
    <em></em>
    <ul>
      <li>联合路旗舰店：0411-82111105 \ 82111106 \ 82111107 \ 82111108</li>
      <li>人民路旗舰店：0411-82657676 \ 82657070 \ 82652323 \ 82655050</li>
      <li>国内接待电话：0411-84305290 \ 84305295</li>
      <li>日本入境部：0411-84317755</li>
      <li>劳动公园：0411-82556009 \ 83696009</li>
      <li>金州区：0411-87685600 \ 87693699</li>
      <li>普 兰 店：0411-83112367 \ 83114954</li>
      <li>瓦房店：0411-66503722 \ 66503733</li>
    </ul>
    <i>Copyright © 2005-2011 dlgulian.com　All rights reserved 大连古莲国际旅行社 版权所有<br />
    网站经营许可证号辽ICP备案06006255号</i> </div>
</div>


</body>
</html>

<script>
function doPrint()
{
    var url="<?php echo SITE_INDEX;?>Xiaoshou/zituan/doprint/打印/chanpinID/"+<?php echo ($chanpinID); ?>+"/xianluID/"+<?php echo ($xianluID); ?>+"/shoujiaID/"+<?php echo ($shoujiaID); ?>;
    window.open(url,'Printer','width=900,height=700,left=240,status=no,resizable=yes,scrollbars=yes');
}

</script>