<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/WdatePicker.css" rel="stylesheet" type="text/css">
<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
<script>
function save(){
	if(checktitle())
		document.getElementById('form').submit();
	else
	  ajaxalert("负责人填写错误！请确认是系统内用户！");
}

function uploadComplete(data){
  ThinkAjax.myAjaxResponse(data,'resultdiv',om_save);
}
function om_save(data,stats){
	window.location = '<?php echo SITE_INDEX;?>Dijie/fabu/chanpinID/'+data['chanpinID'];
}

var user = [
	 <?php foreach($userlist as $v){ ?>
		  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
	 <?php } ?>
 ];

jQuery().ready(function() {
	  myautocomplete("#onperson",'用户');
});
		
 function myautocomplete(target,parenttype)
{
		if(parenttype == '用户')
		datas = user;
		jQuery(target).unautocomplete().autocomplete(datas, {
		   max: 50,    //列表里的条目数
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
		
function checktitle(){
	datas = user;
	var title = jQuery("#onperson").val();
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

function ajaxalert(title){
	document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+title+'</div>';
	jQuery("#resultdiv_2").show("fast"); 
	this.intval = window.setTimeout(function (){
		document.getElementById('resultdiv_2').style.display='none';
		document.getElementById('resultdiv_2').innerHTML='';
		},3000);
}

</script>

<div id="main">
  <?php A("Dijie")->left_chanpin(); ?>
  <div id="content" style="margin-left:170px;">
    <?php A("Dijie")->header_chanpin(); ?>
    
    <iframe name="iframeUpload" src="" frameborder="0" SCROLLING="no" style="display:none"></iframe> 
    <form name="form" id="form" method="post" action="<?php echo SITE_INDEX;?>Dijie/dopostfabu/" enctype="multipart/form-data" target="iframeUpload"> 
      <INPUT TYPE="hidden" name="uploadResponse" value="uploadComplete">
      <?php if($djtuan[chanpinID]){ ?>
      <input name="chanpinID" id="chanpinID" type="hidden" value="<?php echo ($djtuan['chanpinID']); ?>" >
      <?php }else{ ?>
      <input name="guojing" type="hidden" id="guojing" value="<?php echo ($guojing); ?>" >
      <input name="kind" type="hidden" id="kind" value="<?php echo ($kind); ?>" >
      <?php } ?>
      <input type="hidden" name="ajax" value="1">
      <!--ajax提示-->
      <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
        <tbody>
          <tr>
            <th align="left" colspan="8"> <h4>基本信息（必填）</h4>
            </th>
          </tr>
          <tr>
            <td valign="top" scope="row" style="min-width:100px;"> 标题: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="title" type="text" id="title" value="<?php echo ($djtuan['title']); ?>" style="width:90%;" check="^\S+$" warning="标题不能为空,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 负责人: </td>
            <td valign="top"><input name="onperson" type="text" id="onperson" value="<?php echo ($djtuan['onperson']); ?>" check="^\S+$" warning="负责人不能为空,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 人数: </td>
            <td valign="top"><input name="renshu" type="text" id="renshu" value="<?php echo ($djtuan['renshu']); ?>" check="^\S+$" warning="人数不能为空,且不能含有空格" ></td>
          </tr>
          <tr>
            <td valign="top" scope="row" style="min-width:100px;"> 编号: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="tuanhao" type="text" id="tuanhao" value="<?php echo ($djtuan['tuanhao']); ?>" check="^\S+$" warning="编号不能为空,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 发团单位: </td>
            <td valign="top"><input name="fromcompany" type="text" id="fromcompany" value="<?php echo ($djtuan['fromcompany']); ?>" check="^\S+$" warning="发团单位不能为空,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 天数: </td>
            <td valign="top"><input name="tianshu" type="text" id="tianshu" value="<?php echo ($djtuan['tianshu']); ?>" check="^\S+$" warning="天数不能为空,且不能含有空格" ></td>
          </tr>
          <tr>
            <td valign="top" scope="row" style="min-width:100px;"> 联系人: </td>
            <td valign="top" scope="row" style="min-width:200px;"><input name="lianxiren" type="text" id="lianxiren" value="<?php echo ($djtuan['lianxiren']); ?>" check="^\S+$" warning="联系人不能为空,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 电话: </td>
            <td valign="top"><input name="lianxirentelnum" type="text" id="lianxirentelnum" value="<?php echo ($djtuan['lianxirentelnum']); ?>" check="^\S+$" warning="电话不能为空,且不能含有空格" ></td>
            <td valign="top" scope="row" style="min-width:100px;"> 接团时间: </td>
            <td valign="top"><input name="jietuantime" type="text" id="jietuantime" onfocus="WdatePicker()" value="<?php echo ($djtuan['jietuantime']); ?>" check="^\S+$" warning="接团时间不能为空,且不能含有空格" ></td>
          </tr>
        </tbody>
      </table>
      <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view" style=" border-top-color: #CBDAE6 !important;">
        <tbody>
          <tr>
            <th align="left" colspan="8"> <h4>选填信息</h4>
            </th>
          </tr>
          <tr>
            <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                <legend>交通方式</legend>
                <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                  <tbody>
                    <tr>
                      <td><textarea style="width:99%; resize:none" rows="3" name="jiaotongfangshi" id="jiaotongfangshi"><?php echo ($djtuan[datatext]['jiaotongfangshi']); ?></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </fieldset></td>
          </tr>
          <tr>
            <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                <legend>酒店标准</legend>
                <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                  <tbody>
                    <tr>
                      <td><textarea style="width:99%; resize:none" rows="3" name="jiudianbiaozhun" id="jiudianbiaozhun"><?php echo ($djtuan[datatext]['jiudianbiaozhun']); ?></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </fieldset></td>
          </tr>
          <tr>
            <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                <legend>用车标准</legend>
                <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                  <tbody>
                    <tr>
                      <td><textarea style="width:99%; resize:none" rows="3" name="yongchebiaozhun" id="yongchebiaozhun"><?php echo ($djtuan[datatext]['yongchebiaozhun']); ?></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </fieldset></td>
          </tr>
          <tr>
            <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                <legend>用餐标准</legend>
                <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                  <tbody>
                    <tr>
                      <td><textarea style="width:99%; resize:none" rows="3" name="yongchanbiaozhun" id="yongchanbiaozhun"><?php echo ($djtuan[datatext]['yongchanbiaozhun']); ?></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </fieldset></td>
          </tr>
          <tr>
            <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                <legend>导游服务</legend>
                <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                  <tbody>
                    <tr>
                      <td><textarea style="width:99%; resize:none" rows="3" name="daoyoufuwu" id="daoyoufuwu"><?php echo ($djtuan[datatext]['daoyoufuwu']); ?></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </fieldset></td>
          </tr>
          <tr>
            <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                <legend>景点门票</legend>
                <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                  <tbody>
                    <tr>
                      <td><textarea style="width:99%; resize:none" rows="3" name="jingdianmenpiao" id="jingdianmenpiao"><?php echo ($djtuan[datatext]['jingdianmenpiao']); ?></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </fieldset></td>
          </tr>
          <tr>
            <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                <legend>购物计划</legend>
                <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                  <tbody>
                    <tr>
                      <td><textarea style="width:99%; resize:none" rows="3" name="gouwujihua" id="gouwujihua"><?php echo ($djtuan[datatext]['gouwujihua']); ?></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </fieldset></td>
          </tr>
          <tr>
            <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                <legend>备注</legend>
                <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                  <tbody>
                    <tr>
                      <td><textarea style="width:99%; resize:none" rows="3" name="remark" id="remark"><?php echo ($djtuan[datatext]['remark']); ?></textarea></td>
                    </tr>
                  </tbody>
                </table>
              </fieldset></td>
          </tr>
          <tr>
            <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                <legend>上传行程副本</legend>
                <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                  <tbody>
                    <tr>
                      <td style="line-height:28px;"><input type="file" name="attachment" id="attachment" />
                      <?php if($djtuan['attachment']){ ?>
                      <a href="<?php echo SITE_DATA;?>Attachments/<?php echo ($djtuan['attachment']); ?>">点击查看</a>已上传文件
                      <?php } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </fieldset></td>
          </tr>
        </tbody>
      </table>
      <div class="buttons">
          <input type="button" value="保存" name="button" class="button primary" onclick="if(CheckForm('form','resultdiv_2')) save();">
      </div>
    </form>
  </div>
</div>
<?php A("Index")->footer(); ?>