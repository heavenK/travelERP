<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<link href="<?php echo __PUBLIC__;?>/gulianstyle/styles/WdatePicker.css" rel="stylesheet" type="text/css">
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
    <?php A("Chanpin")->header_kongguan(); ?>
    
            <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:0px;">
              <tbody>
                <tr height="20">
                  <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 订单个数 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 团员人数 </div></th>
                </tr>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($dingdan_num); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($tuanyuan_num); ?></td>
                </tr>
              </tbody>
            </table>
    
            <?php foreach($dingdanlist as $v){ ?>
    
            <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:0px;">
              <tbody>
                
                <tr height="20">
                  <th scope="col" nowrap="nowrap" style="width:100px;"><div style=" background:#4E8CCF; color:#FFF"> 订单编号 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:150px;"><div> 订单来源 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 订单状态 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 成人人数 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 儿童人数 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 领队人数 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 订单售价 </div></th>
                </tr>
                
                <tr style="cursor:pointer; background:#EBEBED" height="30" class="evenListRowS1" onclick="showinfo(<?php echo ($v['chanpinID']); ?>)">
                  <td scope="row" align="left" valign="top"><?php echo ($v['chanpinID']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['bumen_copy']); ?>-<?php echo ($v['user_name']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['chengrenshu']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['ertongshu']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['lingdui_num']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['jiage']); ?></td>
                </tr>
                
                
              </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:20px;">
              <tbody>
                <tr height="20">
                  <th scope="col" nowrap="nowrap" style="width:100px;"><div style=" background:#090; color:#FFF"> 姓名 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 性别 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 团费 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 证件类型 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 证件号 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 联系电话 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 需求 </div></th>
                  <th scope="col" nowrap="nowrap"><div> 详细资料 </div></th>
                </tr>
                <?php foreach($v['tuanyuanlist'] as $vol){ ?>
                <tr style="cursor:pointer" height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($vol['name']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['sex']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['manorchild']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['price']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['zhengjiantype']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['zhengjianhaoma']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['telnum']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['remark']); ?></td>
                  <td scope="row" align="left" valign="top"><a href="javascript:TravelerDetail(<?php echo ($vol['id']); ?>)">查看</a></td>
                </tr>
                <?php } ?>
                
              </tbody>
            </table>
      
                <?php } ?>
      
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

function exports(chanpinID,type)
{
	window.location.href = '<?php echo SITE_INDEX;?>Chanpin/_tuanyuan_exports/chanpinID/'+chanpinID+'/type/'+type;
}
function TravelerDetail(id)
{
    var url=SITE_INDEX+"Xiaoshou/tuanyuanxinxi/id/"+id;
    window.open(url,'newwin','width=900,height=700,left=240,status=no,resizable=yes,scrollbars=yes');
}
</script>