<?php if (!defined('THINK_PATH')) exit();?>            <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:0px;">
              <tbody>
                <tr height="20">
                  <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 团员人数 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 已分配房间人数 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:100px;"><div> 未分配房间人数 </div></th>
                </tr>
                <tr height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($tuanyuan_all); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($tuanyuan_in); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($tuanyuan_out); ?></td>
                </tr>
              </tbody>
            </table>
    
    
            <?php foreach($dingdanlist as $v){ ?>
    
            <table cellpadding="0" cellspacing="0" width="100%" class="list view list_new" style="border-bottom:none; margin-bottom:0px;">
              <tbody>
                <tr height="20">
                  <th scope="col" nowrap="nowrap" style="width:100px; float:left; min-width:100px;"><div style=" background:#4E8CCF; color:#FFF"> 房间标题 </div></th>
                  <th scope="col" nowrap="nowrap" style="width:70%;min-width:300px;"><div> 备注说明 </div></th>
                  <th scope="col" nowrap="nowrap" style="min-width:250px;width:30%;"><div> 操作 </div></th>
                </tr>
                <tr style="background:#EBEBED" height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($v['remark']); ?></td>
                  <td scope="row" align="left" valign="top">
                  <input type="button" value="分配人员" name="button" class="button primary" onClick="select_tuanyuan('<?php echo ($chanpinID); ?>','<?php echo ($v[chanpinID]); ?>')">
                  <input type="button" value="编辑房间" name="button" class="button primary" onClick="save();">
                  <input type="button" value="删除房间" name="button" class="button primary" onClick="save();">
                  </td>
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
                </tr>
                <?php foreach($v['renyuanlist'] as $vol){ ?>
                <tr style="cursor:pointer" height="30" class="evenListRowS1">
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['name']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['sex']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['manorchild']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['price']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['zhengjiantype']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['zhengjianhaoma']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['telnum']); ?></td>
                  <td scope="row" align="left" valign="top"><?php echo ($vol['renyuan']['remark']); ?></td>
                </tr>
                <?php } ?>
                
              </tbody>
            </table>
      
                <?php } ?>