<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
function save(){
	if(CheckForm('form1','resultdiv_2'))
	ThinkAjax.sendForm('form1','<?php echo SITE_INDEX;?>Chanpin/dopostzituanplan/typemark/出团通知',doComplete,'resultdiv');
}
function doComplete(data,status){
}

function dofabu(chanpinID){
	ThinkAjax.myloading('resultdiv');
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/sendzituanplan/typemark/出团通知",
		data:	"chanpinID="+chanpinID,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv');
		}
	});
}
function exports(chanpinID){
	window.location.href = '<?php echo SITE_INDEX;?>Chanpin/zituanxinxi/typemark/出团通知/export/1/chanpinID/'+chanpinID;
}
</script>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/WdatePicker.css" rel="stylesheet" type="text/css">
<div id="main">         <style>
		#navtab_2 h3 { color:#0B578F}
		#navtab_3 h3 { color:#999}
		</style>

  <div id="leftColumn" style="margin-top:0px; width:150px;">
        <div id="navtab_1" class="leftList">
          <h3><span>产品分类</span></h3>
          <ul id="ul_shortcuts">
            <li> <a href="#">&nbsp;<span>子团产品</span></a> </li>
            <li id="subModuleList" style="padding:0px; border-top:none">
                  <ul>
                    <li class="subTabMore" style="font-size:12px;"> <a href="<?php echo SITE_INDEX;?>Chanpin">&nbsp;线路发布及控管&gt;&gt;</a> 
                        <ul class="cssmenu" style="margin-top:8px;">
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/近郊/guojing/国内/xianlutype/散客产">国内近郊 </a> </li>
                          <li> <a href="<?php echo SITE_INDEX;?>Chanpin/fabu/kind/长线/guojing/国内/xianlutype/散客产品">国内长线 </a> </li>
                          <li> <a href="#">国内自由人 </a> </li>
                          <li> <a href="#">国内包团 </a> </li>
                          <li> <a href="#">境外海岛 </a> </li>
                          <li> <a href="#">境外欧美澳非 </a> </li>
                          <li> <a href="#">境外游 </a> </li>
                          <li> <a href="#">境外自由人 </a> </li>
                          <li> <a href="#">境外包团 </a> </li>
                        </ul>
                    </li>
                  </ul>
            </li>
            <li> <a href="#">&nbsp;<span>签证及票务</span></a> </li>
            <li> <a href="#">&nbsp;<span>回收站</span></a> </li>
          </ul>
        </div>
  </div>


  <div id="content" style="margin-left:170px;">
    <div id="resultdiv" class="resultdiv"></div>
    <div id="resultdiv_2" class="resultdiv"></div>
    <?php A("Chanpin")->header_kongguan(); ?>
    <form name="form1" method="post" id="form1" >
      <input type="hidden" name="chanpinID" value="<?php echo ($zituan[chanpinID]); ?>">
      <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
        <tbody>
          <tr>
            <th align="left" colspan="8"> <h4>出团通知（该出团通知将发布给产品的开放用户）</h4>
            </th>
          </tr>
          <tr>
            <td valign="top" scope="row" style="min-width:100px;"> 集合时间: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="jihetime" type="text" value="<?php echo ($zituan['chutuantongzhi']['jihetime']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 集合地点: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="jiheplace" type="text" value="<?php echo ($zituan['chutuantongzhi']['jiheplace']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 集合标志: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="jihemark" type="text" value="<?php echo ($zituan['chutuantongzhi']['jihemark']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
          </tr>
          <tr>
            <td valign="top" scope="row" style="min-width:100px;"> 去程交通: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="tojiaotong" type="text" value="<?php echo ($zituan['chutuantongzhi']['tojiaotong']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 返程交通: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="backjiaotong" type="text" value="<?php echo ($zituan['chutuantongzhi']['backjiaotong']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 接团标志: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="jietuanmark" type="text" value="<?php echo ($zituan['chutuantongzhi']['jietuanmark']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
          </tr>
        </tbody>
      </table>
      <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
        <tbody>
          <tr>
            <td valign="top" scope="row" style="min-width:100px;"> 领队: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="lingdui" type="text" value="<?php echo ($zituan['chutuantongzhi']['lingdui']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 领队电话: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="lingduitelnum" type="text" value="<?php echo ($zituan['chutuantongzhi']['lingduitelnum']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
          </tr>
          <tr>
            <td valign="top" scope="row" style="min-width:100px;"> 地陪: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="dipei" type="text" value="<?php echo ($zituan['chutuantongzhi']['dipei']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 地陪电话: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="dipeitelnum" type="text" value="<?php echo ($zituan['chutuantongzhi']['dipeitelnum']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
          </tr>
          <tr>
            <td valign="top" scope="row" style="min-width:100px;"> 紧急联系人: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="jinjilianxiren" type="text" value="<?php echo ($zituan['chutuantongzhi']['jinjilianxiren']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 紧急联系人电话: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="jinjitelnum" type="text" value="<?php echo ($zituan['chutuantongzhi']['jinjitelnum']); ?>" check="^\S+$" warning="所有信息必填,没有请写无,且不能含有空格" ></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<?php A("Index")->footer(); ?>