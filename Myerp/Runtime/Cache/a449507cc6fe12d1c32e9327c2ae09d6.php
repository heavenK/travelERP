<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/Chanpin/chengbenshoujia.js"></script>
<script type='text/javascript' src='<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/myerp/jquery-autocomplete/jquery.autocomplete.css" />
<script type="text/javascript">
var chengbentypelist = new Array(<?php echo ($chengbenlist); ?>);
var chanpinID = '<?php echo ($chanpinID); ?>';
var parentID = '<?php echo ($chanpinID); ?>';
var SITE_INDEX = '<?php echo SITE_INDEX;?>';
var category = [
	 <?php foreach($categoryAll as $v){ ?>
		  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
	 <?php } ?>
 ];

var department = [
	 <?php foreach($departmentAll as $v){ ?>
		  { title: "<?php echo ($v[title]); ?>", systemID: "<?php echo ($v['systemID']); ?>" },
	 <?php } ?>
 ];

jQuery().ready(function() {
		<?php foreach($shoujia as $v){ ?>
			myautocomplete("#<?php echo ($v[chanpinID]); ?>",'<?php echo ($v[opentype]); ?>');	
		 <?php } ?>
		var t =jisuanchengben();
		var str = '成人总成本：'+t['chengren']+',儿童总成本：'+t['ertong'];
		jQuery("#chengbenjisuan").html(str); 
		});
</script>
<div id="main">
  <div id="content" style="margin-left:5px; padding-left:0px; border-left:none">
    <?php A("Chanpin")->header_chanpin(); ?>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view" id="chengben">
      <tbody>
        <tr class="pagination">
          <td colspan="6"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><strong>成本项目</strong>&nbsp;
                    <input class="button" type="button" value="新增" onclick="insertchengben();" /></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr height="20">
          <th scope="col" nowrap="nowrap"> 序号 </th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 类型 </div></th>
          <th scope="col" nowrap="nowrap"><div> 描述 </div></th>
          <th scope="col" nowrap="nowrap"><div> 成本 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:40px;"><div> 对象 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 操作 </div></th>
        </tr>
          <?php $i = 0;foreach($chengben as $v){$i++; ?>
      
      <input type="hidden" class="jisuanchengben" value="<?php echo ($v['chanpinID']); ?>" >
      <tr height="30" class="evenListRowS1" id="chengbenrow<?php echo ($v['chanpinID']); ?>">
        <td scope="row" align="left" valign="top"><?php echo ($i); ?> </td>
        <td scope="row" align="left" valign="top"><select name="title" id="title<?php echo ($v['chanpinID']); ?>" >
            <?php if($v['title']){ ?>
            <option value="<?php echo ($v['title']); ?>"><?php echo ($v['title']); ?></option>
            <option disabled>-------</option>
            <?php } ?>
            <?php foreach($chengbenlist_1 as $tb){ ?>
            <option value="<?php echo ($tb['title']); ?>"><?php echo ($tb['title']); ?></option>
            <?php } ?>
          </select></td>
        <td scope="row" align="left" valign="top"><input type="text" name="remark" id="remark<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['remark']); ?>" ></td>
        <td scope="row" align="left" valign="top"><input type="text" name="price" id="price<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['price']); ?>" ></td>
        <td scope="row" align="left" valign="top"><select name="jifeitype" id="jifeitype<?php echo ($v['chanpinID']); ?>" >
            <?php if($v['jifeitype']){ ?>
            <option><?php echo ($v['jifeitype']); ?></option>
            <option disabled>-------</option>
            <?php } ?>
            <option value="全部">全部</option>
            <option value="成人">成人</option>
            <option value="儿童">儿童</option>
          </select></td>
        <td scope="row" align="left" valign="top"><input class="button" type="button" value="删除" onClick="deletechengben(<?php echo ($v['chanpinID']); ?>)" />
          <input class="button" type="button" value="修改" onClick="addchengben(<?php echo ($v['chanpinID']); ?>)" /></td>
      </tr>
      <?php } ?>
        </tbody>
      
    </table>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view" style="margin:10px 0 10px 0;">
      <tbody>
        <tr class="pagination">
          <td colspan="6"><table cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td nowrap="nowrap"><strong>总成本:</strong>&nbsp;&nbsp;&nbsp; <span id="chengbenjisuan"></span></td>
                </tr>
              </tbody>
            </table></td>
      </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view" style="margin:10px 0 10px 0;">
      <tbody>
        <tr class="pagination">
          <td colspan="6"><table cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td nowrap="nowrap"><strong>对外统一显示价格:</strong>&nbsp;&nbsp;&nbsp;
                    <input type="text" id="xianlushoujia" value="<?php echo ($chanpin['shoujia']); ?>" >
                    &nbsp;&nbsp;&nbsp; <strong>儿童及其他说明:</strong>&nbsp;&nbsp;&nbsp;
                    <input style="width:400px;" type="text" id="xianluremark" value="<?php echo ($chanpin['remark']); ?>"  >
                    &nbsp;&nbsp;&nbsp;
                    <input style="margin-top:-2px;" class="button" type="button" value="保存" onclick="saveshoujia()"/></td>
                </tr>
              </tbody>
            </table></td>
      </tbody>
    </table>
    <script>
		 function saveshoujia()
		 {
			var shoujia = jQuery("#xianlushoujia").val();
			var remark = jQuery("#xianluremark").val();
			jQuery.ajax({
				type:	"POST",
				url:	SITE_INDEX+"Chanpin/dopostfabu_shoujia/chanpinID/"+chanpinID,
				data:	"shoujia="+shoujia+"&remark="+remark,
				success:function(msg){
					ThinkAjax.myAjaxResponse(msg,'resultdiv');
				}
			});
			
		 }
		  </script>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view" id="shoujia">
      <tbody>
        <tr class="pagination">
          <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><strong>指定销售</strong>&nbsp;
                    <input class="button" type="button" value="新增分类" onclick="insertshoujia('分类');" />
                    <input class="button" type="button" value="+部门" onclick="insertshoujia('部门');" /></td>
                  <td nowrap="nowrap" align="right" class="paginationChangeButtons"></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr height="20">
          <th scope="col" nowrap="nowrap"> 序号</th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 对象 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 对象类型 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 类型 </div></th>
          <th scope="col" nowrap="nowrap"><div> 成人价 </div></th>
          <th scope="col" nowrap="nowrap"><div> 儿童价 </div></th>
          <th scope="col" nowrap="nowrap"><div> 成本 </div></th>
          <th scope="col" nowrap="nowrap"><div> 折扣范围 </div></th>
          <th scope="col" nowrap="nowrap"><div> 开放人数 </div></th>
          <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 操作 </div></th>
        </tr>
          <?php $i = 0;foreach($shoujia as $v){$i++; ?>
      
      <tr height="30" class="evenListRowS1" id="shoujiarow<?php echo ($v['chanpinID']); ?>">
        <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
        <td scope="row" align="left" valign="top"><input style="width:80px;" type="text" name="title" id="<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['title']); ?>" >
          <input type="hidden" id="openID<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['openID']); ?>"></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['opentype']); ?> </td>
        <td scope="row" align="left" valign="top"><select name="type" id="type<?php echo ($v['chanpinID']); ?>" >
            <?php if($v['type']){ ?>
            <option value="<?php echo ($v['type']); ?>"><?php echo ($v['type']); ?></option>
            <option disabled>-------</option>
            <?php } ?>
            <option value="标准">标准</option>
            <option value="机票酒店">机票酒店</option>
          </select></td>
        <td scope="row" align="left" valign="top"><input style="width:80px;" type="text" name="adultprice" id="adultprice<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['adultprice']); ?>" ></td>
        <td scope="row" align="left" valign="top"><input style="width:80px;" type="text" name="childprice" id="childprice<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['childprice']); ?>" ></td>
        <td scope="row" align="left" valign="top"><input style="width:80px;" type="text" name="chengben" id="chengben<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['chengben']); ?>" ></td>
        <td scope="row" align="left" valign="top"><input style="width:80px;" type="text" name="cut" id="cut<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['cut']); ?>" ></td>
        <td scope="row" align="left" valign="top"><input style="width:80px;" type="text" name="renshu" id="renshu<?php echo ($v['chanpinID']); ?>" value="<?php echo ($v['renshu']); ?>" ></td>
        <td scope="row" align="left" valign="top"><input class="button" type="button" value="删除" onClick="deleteshoujia(<?php echo ($v['chanpinID']); ?>)" />
          <input class="button" type="button" value="修改" onClick="if(checktitle(<?php echo ($v['chanpinID']); ?>,'<?php echo ($v['opentype']); ?>'))addshoujia(<?php echo ($v['chanpinID']); ?>,'<?php echo ($v['opentype']); ?>')" /></td>
      </tr>
      <?php } ?>
        </tbody>
      
    </table>
  </div>
</div>
<?php A("Index")->footer(); ?>