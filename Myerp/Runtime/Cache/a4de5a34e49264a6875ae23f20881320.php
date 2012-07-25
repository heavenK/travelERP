<?php if (!defined('THINK_PATH')) exit(); A("Index")->showheader(); ?>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/myerp/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/gulianstyle/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
function save(){
	ThinkAjax.sendForm('form1','<?php echo SITE_INDEX;?>Chanpin/dopostzituanxinxi',doComplete,'resultdiv');
}
function doComplete(data,status){
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
          <th align="left" colspan="8"> <h4>子团信息</h4>
          </th>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px;"> 团号: </td>
          <td valign="top" scope="row" style="min-width:200px;"><input name="title" type="text" value="<?php echo trim($zituan['tuanhao']) ?>" check="^\S+$" warning="团号不能为空,且不能含有空格" ></td>
          <td valign="top" scope="row" style="min-width:100px;"> 报名截止: </td>
          <td valign="top" scope="row" style="min-width:200px;"><span>出团前</span>
            <input style="width:50px; margin:0 4px 0 4px;" name="baomingjiezhi" type="text" value="<?php echo trim($zituan['baomingjiezhi']) ?>" check="^\S+$" warning="报名截止不能为空,且不能含有空格">
            <span>天</span></td>
        </tr>
        <tr>
          <td valign="top" scope="row"> 出团日期: </td>
          <td valign="top" scope="row"><input name="title" type="text" value="<?php echo trim($zituan['chutuanriqi']) ?>" check="^\S+$" warning="出团日期不能为空,且不能含有空格" onfocus="WdatePicker()" ></td>
          <td valign="top" scope="row"> 团队人数: </td>
          <td valign="top" scope="row"><input name="renshu" type="text" value="<?php echo trim($zituan['renshu']) ?>" check="^\S+$" warning="人数不能为空,且不能含有空格" ></td>
        </tr>
        <tr>
          <td valign="top" scope="row"> 报价修正: </td>
          <td valign="top" scope="row"><span>成人价</span>
            <input style="width:50px; margin:0 4px 0 4px;" name="adultxiuzheng" type="text" value="<?php echo trim($zituan['adultxiuzheng']) ?>">
            <span>儿童价</span>
            <input style="width:50px; margin:0 4px 0 4px;" name="childxiuzheng" type="text" value="<?php echo trim($zituan['childxiuzheng']) ?>"></td>
          <td valign="top" scope="row" colspan="2"> (举例：加价200元，添入200即可，降价200则添入-200) </td>
        </tr>
      </tbody>
    </table>
    </form>
    
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <th align="left" colspan="8"> <h4>线路信息</h4>
          </th>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:100px;"> 标题: </td>
          <td valign="top" scope="row" style="min-width:200px;"><?php echo trim($zituan['xianlulist']['xianlu']['title']) ?></td>
          <td valign="top" scope="row" style="min-width:100px;"> 报名截止: </td>
          <td valign="top" scope="row" style="min-width:200px;"><span>出团前</span>
            <?php echo trim($zituan['xianlulist']['xianlu']['baomingjiezhi']) ?>
            <span>天</span></td>
        </tr>
        <tr>
          <td valign="top" scope="row"> 始发地: </td>
          <td valign="top" scope="row"><?php echo trim($zituan['xianlulist']['xianlu']['chufadi']) ?></td>
          <td valign="top" scope="row"> 目的地: </td>
          <td valign="top" scope="row"><?php echo trim($zituan['xianlulist']['xianlu']['mudidi']) ?></td>
        </tr>
        <tr>
          <td valign="top" scope="row"> 计划人数: </td>
          <td valign="top" scope="row"><?php echo trim($zituan['xianlulist']['xianlu']['renshu']) ?>
            <span style=" margin:0 10px 0 4px">人</span>
            <?php if($xianlu[ischild] == 1){ ?>
            儿童占位
            <?php }else{ ?>
            儿童不占位
            <?php } ?></td>
          <td valign="top" scope="row"> 行程天数: </td>
          <td valign="top" scope="row"><?php echo trim($zituan['xianlulist']['xianlu']['tianshu']) ?>
            <span>天</span></td>
        </tr>
      </tbody>
    </table>
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view" style=" border-top-color: #CBDAE6 !important;">
      <tbody>
        <tr>
          <td valign="top" colspan="4" scope="row"><table cellspacing="0" cellpadding="0" border="0" width="100%">
              <tbody>
                <tr>
                  <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                      <legend>出团日期</legend>
                      <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                        <tbody>
                          <tr>
                            <td scope="row"><?php echo trim($zituan['xianlulist']['xianlu']['chutuanriqi']) ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </fieldset></td>
                </tr>
              </tbody>
            </table></td>
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
          <td valign="top" scope="row" style="min-width:100px;"> 主题: </td>
          <td valign="top" scope="row" style="min-width:200px;"><?php echo trim($zituan['xianlulist']['xianlu']['zhuti']) ?></td>
          <td valign="top" scope="row" style="min-width:100px;"> 导游服务: </td>
          <td valign="top" scope="row" style="min-width:200px;"><?php if($xianlu['quanpei']){ ?>
            全陪
            <?php } ?>
            <?php if($xianlu['dipei']){ ?>
            地陪
            <?php } ?></td>
        </tr>
        <tr>
          <td valign="top" scope="row"> 视频: </td>
          <td valign="top" scope="row"><?php echo trim($zituan['xianlulist']['xianlu']['shipin']) ?></td>
          <td valign="top" scope="row"> 图片: </td>
          <td valign="top" scope="row"><?php echo trim($zituan['xianlulist']['xianlu']['tupian']) ?></td>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:50px;"> 特色: </td>
          <td valign="top" scope="row" colspan="3"><?php echo trim($zituan['xianlulist']['xianlu']['xingchengtese']) ?></td>
        </tr>
        <tr>
          <td valign="top" scope="row"> 须知: </td>
          <td valign="top" scope="row" colspan="3"><?php echo trim($zituan['xianlulist']['xianlu']['cantuanxuzhi']) ?></td>
        </tr>
      </tbody>
    </table>
    <?php $t =-1;foreach($zituan['xianlulist']['xingcheng'] as $xc) {$t++; ?>
    <input type="hidden" name="chanpinID[]" value="<?php echo ($xc['chanpinID']); ?>" />
    <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
      <tbody>
        <tr>
          <th align="left" colspan="8"> <h4>行程：第<?php echo ($t+1); ?>天</h4>
          </th>
        </tr>
        <tr>
          <td valign="top" scope="row" style="min-width:40px; width:10%"> 住宿: </td>
          <td valign="top" scope="row" style="min-width:100px;"><?php echo ($xc['place']); ?></td>
          <td valign="top" scope="row" style="min-width:40px; width:10%"> 餐饮: </td>
          <td valign="top" scope="row" style="min-width:100px;"><?php if(strstr($xc['chanyin'],'早餐')){ ?>
            早餐,
            <?php } ?>
            <?php if(strstr($xc['chanyin'],'午餐')){ ?>
            午餐,
            <?php } ?>
            <?php if(strstr($xc['chanyin'],'晚餐')){ ?>
            晚餐,
            <?php } ?></td>
          <td valign="top" scope="row" style="min-width:40px; width:10%"> 交通: </td>
          <td valign="top" scope="row" style="min-width:100px;"><?php if(strstr($xc['tools'],'飞机')){ ?>
            飞机,
            <?php } ?>
            <?php if(strstr($xc['tools'],'火车')){ ?>
            火车,
            <?php } ?>
            <?php if(strstr($xc['tools'],'轮船')){ ?>
            轮船,
            <?php } ?>
            <?php if(strstr($xc['tools'],'汽车')){ ?>
            汽车,
            <?php } ?></td>
        </tr>
        <tr>
          <td valign="top" colspan="6" scope="row"><table cellspacing="0" cellpadding="0" border="0" width="100%">
              <tbody>
                <tr>
                  <td valign="top"><fieldset style="border:#CBDAE6 1px solid">
                      <legend>内容</legend>
                      <table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit">
                        <tbody>
                          <tr>
                            <td scope="row"><?php echo ($xc['content']); ?> </td>
                          </tr>
                        </tbody>
                      </table>
                    </fieldset></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
      </tbody>
    </table>
    <?php } ?>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view" id="chengben">
      <tbody>
        <tr class="pagination">
          <td colspan="6"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><strong>成本项目</strong>&nbsp;</td>
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
        </tr>
          <?php $i = 0;foreach($zituan['xianlulist']['chengben'] as $v){$i++;$zongchengben += $v['price']; ?>
      
      <tr height="30" class="evenListRowS1">
        <td scope="row" align="left" valign="top"><?php echo ($i); ?> </td>
        <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['remark']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['price']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['jifeitype']); ?></td>
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
                  <td nowrap="nowrap"><strong>总成本:</strong>&nbsp;&nbsp;&nbsp; <span id="chengbenjisuan"><?php echo ($zongchengben); ?></span></td>
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
                    <?php echo ($zituan['xianlulist']['xianlu']['shoujia']); ?>
                    &nbsp;&nbsp;&nbsp; <strong>儿童及其他说明:</strong>&nbsp;&nbsp;&nbsp;
                    <?php echo ($zituan['xianlulist']['xianlu']['remark']); ?>
                    &nbsp;&nbsp;&nbsp; 
                </tr>
              </tbody>
            </table></td>
      </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" width="100%" class="list view" id="shoujia">
      <tbody>
        <tr class="pagination">
          <td colspan="11"><table cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
              <tbody>
                <tr>
                  <td nowrap="nowrap" class="paginationActionButtons"><strong>指定销售</strong>&nbsp; 
                  <td nowrap="nowrap" align="right" class="paginationChangeButtons"></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr height="20">
          <th scope="col" nowrap="nowrap"> 序号</th>
          <th scope="col" nowrap="nowrap" style="min-width:80px; width:20%"><div> 对象 </div></th>
          <th scope="col" nowrap="nowrap" style="width:10%"><div> 对象类型 </div></th>
          <th scope="col" nowrap="nowrap" style="width:10%"><div> 类型 </div></th>
          <th scope="col" nowrap="nowrap"><div> 成人价 </div></th>
          <th scope="col" nowrap="nowrap"><div> 儿童价 </div></th>
          <th scope="col" nowrap="nowrap"><div> 成本 </div></th>
          <th scope="col" nowrap="nowrap"><div> 折扣范围 </div></th>
          <th scope="col" nowrap="nowrap"><div> 开放人数 </div></th>
        </tr>
          <?php $i = 0;foreach($zituan['xianlulist']['shoujia'] as $v){$i++; ?>
      
      <tr height="30" class="evenListRowS1">
        <td scope="row" align="left" valign="top"><?php echo ($i); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['title']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['opentype']); ?> </td>
        <td scope="row" align="left" valign="top"><?php echo ($v['type']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['adultprice']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['childprice']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['chengben']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['cut']); ?></td>
        <td scope="row" align="left" valign="top"><?php echo ($v['renshu']); ?></td>
      </tr>
      <?php } ?>
        </tbody>
      
    </table>
  </div>
</div>
<?php A("Index")->footer(); ?>