<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/WdatePicker.css" rel="stylesheet" type="text/css">

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

<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
<script>

function save(){
	scroll(0,0);
	ThinkAjax.sendForm('form1','<?php echo SITE_INDEX;?>Xiaoshou/dopostdingdanxinxi/',doComplete,'resultdiv');
}
function doComplete(data,status){
}
		 
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

function checktable()
{
	if(CheckForm('form2','resultdiv_2'))
	{
		if(checktitle())
		{
			var state=document.getElementById("status");
			if(state.value=="占位")
				alert("订单为占位状态，请在48小时内转为确认，否则系统会自动取消该订单！");
			ThinkAjax.sendForm('form2','<?php echo SITE_INDEX;?>Xiaoshou/dopostdingdanxinxi/',doComplete,'resultdiv');
		}
		else
			alert("所属人填写错误");
		
	}
	return false;
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
    var SITE_INDEX = '<?php echo SITE_INDEX;?>';
    var chanpinID = '<?php echo ($chanpinID); ?>';
	var title =  '编号<?php echo ($chanpinID); ?>订单';
	function doshenhe(dotype){
		ThinkAjax.myloading('resultdiv');
		var dataID = chanpinID;
		var datatype = '订单';
		jQuery.ajax({
			type:	"POST",
			url:	SITE_INDEX+"Chanpin/doshenhe",
			data:	"dataID="+dataID+"&dotype="+dotype+"&datatype="+datatype+"&title="+title,
			success:function(msg){
				ThinkAjax.myAjaxResponse(msg,'resultdiv');
			}
		});
	}
	
 function quxiao(id)
 {
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Xiaoshou/quxiaodingdan",
		data:	"dingdanID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv_2');
		}
	});
	
 }
 
function TravelerDetail(id)
{
    var url=SITE_INDEX+"Xiaoshou/tuanyuanxinxi/id/"+id;
    window.open(url,'newwin','width=900,height=700,left=240,status=no,resizable=yes,scrollbars=yes');
}


</script>


<div id="main">
          <style>
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
    <div class="moduleTitle" style="margin-bottom:10px;">
        <div style="float:left; width:70%">
          <h3 style=""><?php echo ($navigation); echo ($datatitle); ?></h3>
        </div>
        <div style="float:left; width:30%; margin-top:6px;">
              <span style="float:right; margin-left:20px;">
              <img src="<?php echo __PUBLIC__;?>/myerp/images/help.gif" alt="帮助" ><a href="javascript:void(0)" onclick="alert('暂无');" class="utilsLink"> 帮助 </a> 
              </span>
        </div>
    </div>
      
      <div class="buttons">
            <input type="button" value="审核失败记录" name="button" class="button primary" style="float:right">
          <?php if($root_shenqing){ ?>
            <input type="submit" value="申请审核" name="button" class="button primary" style="float:right" onclick="doshenhe('申请');">
          <?php } ?>
          <?php if($root_shenqing2){ ?>
            <input type="submit" value=" 批准 " name="button" class="button primary" style="float:right" onclick="doshenhe('申请');">
          <?php } ?>
          <?php if($root_shenhe){ ?>
            <input type="submit" value=" 批准 " name="button" class="button primary" style="float:right" onclick="doshenhe('检出');">
          <?php } ?>
          <input type="button" value=" 取消订单 " name="button" class="button primary" onClick="quxiao('<?php echo ($chanpinID); ?>');">
          <input type="button" value=" 订单解锁 " name="button" class="button primary" onClick="save();">
      </div>
      
  <form name="form2" method="post" action="<?php echo SITE_INDEX;?>Xiaoshou/dopostdingdanxinxi" id="form2" >
      <input type="hidden" name="dingdanID" value="<?php echo ($chanpinID); ?>" />
    <table width="100%" class="tb1" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td colspan="5" height="32" align="left" ><h4><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/bmbbj.gif"></img> 报名表 </h4></td>
          <td align="right"><a href="javascript:void(0)" onclick="window.history.back();"> <img src="<?php echo __PUBLIC__;?>/gulianstyle/styles/A_ddgl-03.jpg"> </a></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 团名： </td>
          <td colspan="5" style="height: 32px"><?php echo ($dingdan['title']); ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px; min-width:80px; width:10%"> 团号：</td>
          <td align="left" style="height: 32px; min-width:80px; width:20%"><?php echo ($dingdan['zituan']['tuanhao']); ?></td>
          <td align="left" style="height: 32px; min-width:80px; width:10%"> 出团日期：</td>
          <td align="left" style="height: 32px; min-width:80px; width:20%"><?php echo ($dingdan['zituan']['chutuanriqi']); ?></td>
          <td align="left" style="height: 32px; min-width:80px; width:10%"> 剩余名额：</td>
          <td align="left" style="height: 32px; min-width:80px; width:20%"><?php echo ($shengyu); ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px;">所属人：</td>
          <td align="left" style="height: 32px">
            <input type="text" name="owner" id="owner" style="width:80px;" value="<?php echo ($dingdan['owner']); ?>" check="^\S+$" warning="所有人员姓名不能为空,且不能含有空格">
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
          <td align="left" style="height: 32px"> 提成类型：</td>
          <td align="left" style="height: 32px">
			<select name="tichengID" id="tichengID">
            	<?php if($dingdan['ticheng']['title']){ ?>
                <option value="<?php echo ($dingdan['ticheng']['systemID']); ?>"><?php echo ($dingdan['ticheng']['title']); ?>:<?php echo ($dingdan['ticheng']['description']); ?>%</option>
                <option disabled="disabled">---------------</option>
            	<?php } ?>
          		<?php foreach($ticheng as $tiv){ ?>
                <option value="<?php echo ($tiv['systemID']); ?>"><?php echo ($tiv['title']); ?>:<?php echo ($tiv['description']); ?>%</option>
                <?php } ?>
			</select>
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
          <td align="left" style="height: 32px"> 订单类型：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['type']); ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 联系人：</td>
          <td align="left" style="height: 32px">
            <input type="text" name="lianxiren" style="width:80px;" value="<?php echo ($dingdan['lianxiren']); ?>" check="^\S+$" warning="联系人不能为空,且不能含有空格">
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
          <td align="left" style="height: 32px"> 联系电话：</td>
          <td align="left" style="height: 32px">
            <input type="text" name="telnum" style="width:80px;" value="<?php echo ($dingdan['telnum']); ?>" check="^\S+$" warning="联系电话不能为空,且不能含有空格">
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
          <td align="left" style="height: 32px"> 订单状态：</td>
          <td align="left" style="height: 32px">
            <select name="status" id="status">
            	<?php if($dingdan['status']){ ?>
                <option value="<?php echo ($dingdan['status']); ?>"><?php echo ($dingdan['status']); ?></option>
                <option disabled="disabled">---------------</option>
            	<?php } ?>
                <option value="占位">占位</option>
                <option value="确认">确认</option>
                <option value="候补">候补</option>
			</select>
            <input style="width:60px;" class="button" type="button" value=" 修改 " onClick="checktable()">
          </td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 成人数：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['chengrenshu']); ?></td>
          <td align="left" style="height: 32px"> 儿童数：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['ertongshu']); ?></td>
          <td align="left" style="height: 32px"> 领队数：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['lingdui_num']); ?></td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 成人价格：</td>
          <td align="left" style="height: 32px"><?php echo $shoujia['adultprice'] ?></td>
          <td align="left" style="height: 32px"> 儿童价格：</td>
          <td align="left" style="height: 32px"><?php echo $shoujia['childprice'] ?></td>
          <td align="left" style="height: 32px"> 预期成本：</td>
          <td align="left" style="height: 32px"><?php echo $shoujia['chengben'] ?>元</td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 售价：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['jiage']); ?></td>
          <td align="left" style="height: 32px"> 操作人：</td>
          <td align="left" style="height: 32px"><?php echo ($dingdan['user_name']); ?></td>
          <td align="left" style="height: 32px"> 折扣范围:</td>
          <td align="left" style="height: 32px"><?php echo $shoujia['cut'] ?>元</td>
        </tr>
        <tr>
          <td align="left" style="height: 32px"> 备注：</td>
          <td align="left" style="height: 32px"  colspan="5"><?php echo ($dingdan['remark']); ?></td>
        </tr>
      </tbody>
    </table>
  </form>
    
    
  <form name="form1" method="post" id="form1" >
      <input type="hidden" name="tuanyuanmark" value="1" />
      <input type="hidden" name="dingdanID" value="<?php echo ($chanpinID); ?>" />
      <input type="hidden" name="shoujiaID" value="<?php echo ($dingdan['shoujiaID']); ?>" />
    <table width="100%" class="tb1 renyuanxinxi" cellpadding="0" cellspacing="0" >
      <tbody>
        <tr>
          <td colspan="10" height="32" align="left" >
          <h4 style="float:left"><img src="<?php echo __PUBLIC__;?>/gulianstyle/images/bmbbj.gif"></img> 人员信息 </h4> 
          </td>
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
          <td align="left" style="height: 32px"> 详细资料： </td>
        </tr>
       <?php $i = 0; foreach($tuanyuan as $vo){$i++; ?>
       <input type="hidden" name="datatext<?php echo ($i); ?>" value="<?php echo ($vo['datatext']); ?>" />
        <tr>
          <td align="left" style="height: 32px"><input type="text" name="name<?php echo ($i); ?>" value="<?php echo ($vo['name']); ?>" check="^\S+$" warning="所有人员姓名不能为空,且不能含有空格"></td>
          <td align="left" style="height: 32px"><input type="hidden" name="manorchild<?php echo ($i); ?>" value="<?php echo ($vo['manorchild']); ?>" /><?php echo ($vo['manorchild']); ?></td>
          <td align="left" style="height: 32px">
          <select name="sex<?php echo ($i); ?>">
       <?php if($vo['sex']){ ?>
          <option value="<?php echo ($vo['sex']); ?>"><?php echo ($vo['sex']); ?></option>
          <option disabled="disabled">----------------</option>
       <?php } ?>
          <option value="男">男</option>
          <option value="女">女</option>
          </select>
          </td>
          <td align="left" style="height: 32px"><input name="telnum<?php echo ($i); ?>" type="text" value="<?php echo ($vo['telnum']); ?>"></td>
          <td align="left" style="height: 32px">
          <select name="zhengjiantype<?php echo ($i); ?>">
       <?php if($vo['zhengjiantype']){ ?>
          <option value="<?php echo ($vo['zhengjiantype']); ?>"><?php echo ($vo['zhengjiantype']); ?></option>
          <option disabled="disabled">----------------</option>
       <?php } ?>
          <option value="身份证">身份证</option>
          <option value="护照">护照</option>
          <option value="通行证">通行证</option>
          </select>
          </td>
          <td align="left" style="height: 32px"><input name="zhengjianhaoma<?php echo ($i); ?>" type="text" value="<?php echo ($vo['zhengjianhaoma']); ?>"></td>
          <td align="left" style="height: 32px"><input name="price<?php echo ($i); ?>" type="text" value="<?php echo ($vo['price']); ?>"></td>
          <td align="left" style="height: 32px"><input name="remark<?php echo ($i); ?>" type="text" value="<?php echo ($vo['remark']); ?>"></td>
          <td align="left" style="height: 32px"><a href="javascript:TravelerDetail(<?php echo ($vo['id']); ?>)">查看</a></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="10" height="32" align="center" >
          <input style="width:60px;" class="button" type="button" value=" 保存 " onClick="if(CheckForm('form1','resultdiv_2'))save();">
          </td>
        </tr>
        
      </tbody>
    </table>
  </form>
      
      
  </div>
  
</div>
<?php A("Index")->footer(); ?>

<script language="javascript"> 

function showinfo(chanpinID){
	window.location = '<?php echo SITE_INDEX;?>Xiaoshou/dingdanxinxi/showtype/1/chanpinID/'+chanpinID;
}

function dosearch()
{
		title = document.getElementById('title').value;
		window.location = '<?php echo SITE_INDEX;?>Chanpin/index/title/'+title;
}

</script>