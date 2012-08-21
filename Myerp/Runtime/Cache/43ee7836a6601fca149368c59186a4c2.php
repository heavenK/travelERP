<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<div id="main">
  <div id="content" style="margin-left:5px; padding-left:0px; border-left:none">
    <?php A("Chanpin")->header_chanpin(); ?>
    <form name="form" method="post" id="form">
      <input type="hidden" name="ajax" value="1">
      <!--ajax提示-->
      
      <table cellpadding="1" cellspacing="0" width="100%" class="list view">
        <tbody>
          <tr class="pagination" style=" height:26px;">
            <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                <tbody>
                  <tr>
                    <td nowrap="nowrap" class="paginationActionButtons"><strong>子团列表</strong>&nbsp; </td>
                    <td nowrap="nowrap" align="right" class="paginationChangeButtons"><?php echo ($page); ?> </td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
          <tr height="20">
            <th scope="col" nowrap="nowrap"> 序号</th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 出团日期 </div></th>
            <th scope="col" nowrap="nowrap"><div> 团编号 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 报名截止 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 状态 </div></th>
            <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 操作人 </div></th>
            <th scope="col" nowrap="nowrap"><div> 操作 </div></th>
            <th scope="col" nowrap="nowrap"><div> 轨迹 </div></th>
          </tr>
            <?php $i = 0; foreach($zituanAll as $v){ $i++; ?>
        
        <tr height="30" class="evenListRowS1" id="zituandiv<?php echo ($v['chanpinID']); ?>">
          <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
          <td scope="row" align="left" valign="top"><?php echo ($v['chutuanriqi']); ?></td>
          <td scope="row" align="left" valign="top"><?php echo ($v['tuanhao']); ?></td>
          <td scope="row" align="left" valign="top"><?php echo ($v['baomingjiezhi']); ?></td>
          <td scope="row" align="left" valign="top"><?php echo ($v['status']); ?></td>
          <td scope="row" align="left" valign="top"><?php echo ($v['user_name']); ?></td>
          <td scope="row" align="left" valign="top"><input class="button" type="button" value="删除" onClick="deletezituan(<?php echo ($v['chanpinID']); ?>,<?php echo ($v['parentID']); ?>)" />
            <input class="button" type="button" value="修改" /></td>
          <td scope="row" align="center" valign="top"><img onclick="showmessage(this,'<?php echo ($v['chanpinID']); ?>','线路','操作记录');showbox(this,'messageitem','r')" src="<?php echo __PUBLIC__;?>/myerp/images/info_inline.gif" width="16" height="16" border="0" /></td>
        </tr>
        <?php } ?>
          </tbody>
        
      </table>
    </form>
  </div>
</div>
<?php A("Index")->footer(); ?>
<script>
var SITE_INDEX = '<?php echo SITE_INDEX;?>';

function deletezituan(chanpinID,parentID)
{
  jQuery.ajax({
	  type:	"POST",
	  url:	SITE_INDEX+"Chanpin/deletezituan",
	  data:	"chanpinID="+chanpinID+"&parentID="+parentID,
	  success:function(msg){
		  ThinkAjax.myAjaxResponse(msg,'resultdiv',todo_del,chanpinID);
	  }
  });
}
function todo_del(data,status,info,type,id)
{


}
function showbox(obj,divname,pos)
{
	objleft = getPosLeft(obj) + 0;
	objtop = getPosTop(obj) + 20;
	if(pos == 'r')
		jQuery("#"+divname).css({top:objtop , right:20 });
	else
		jQuery("#"+divname).css({top:objtop , left:objleft });
	var divRili = document.getElementById(divname); 
	if(divRili.style.display=='')
		divRili.style.display = 'none';
	else 
		divRili.style.display = '';			
}

function messagetodo(data,status,info,type,id)
{
	
	var megstr = '';
	if(status == 1){
		var msg = eval('(' + data + ')');
		for(var i =0; i<msg.length;i++){
			megstr += '<a href="#" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,\'yes\');" class="menuItem" style="width: 300px">'+msg[i].title+'<br>'+getLocalTime(msg[i].time)+'</a>';
		}
	}
	else
		megstr += '<a href="#" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,\'yes\');" class="menuItem" style="width: 300px">暂无数据</a>';
	jQuery("#themessage").empty();
	jQuery("#themessage").append(megstr);
}


function getPosLeft(obj)
{
    var l = obj.offsetLeft;
    while(obj = obj.offsetParent)
    {
        l += obj.offsetLeft;
    }
    return l;
}
function getPosTop(obj)
{
    var l = obj.offsetTop;
    while(obj = obj.offsetParent)
    {
        l += obj.offsetTop;
    }
    return l;
}

</script>
<div id="messageitem" style=" display:none; position:absolute;">
  <table width="150" cellspacing="0" cellpadding="1" border="0" class="olBgClass">
    <tbody>
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="2" border="0" class="olOptionsFgClass">
            <tbody>
              <tr>
                <td valign="top" class="olOptionsFgClass"><div class="olFontClass" id="themessage"> </div></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div>