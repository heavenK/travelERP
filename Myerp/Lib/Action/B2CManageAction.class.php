<?php

class B2CManageAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'电商管理');
	}
	
	
    public function index() {
		A("Method")->showDirectory("网店线路管理");
		//筛选条件
		$_REQUEST['serverdataID'] = array('neq','');
		if($_REQUEST['second_confirm'])
			A("Method")->showDirectory("二次确认线路管理");
		else
			A("Method")->showDirectory("网店线路管理");
		$chanpin_list = A('Method')->getDataOMlist('线路','xianlu',$_REQUEST);
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('index');
    }
	
	
    public function dingdanlist() {
		A("Method")->showDirectory("电商订单管理");
		$_REQUEST['user_name'] = '电商';
		A("Xiaoshou")->dingdanlist();
    }
	
	
    public function dingzhixinxi() {
		A("Method")->showDirectory("电商定制信息");
		$_REQUEST['user_name'] = '电商';
		A("Message")->gexingdingzhilist();
    }
	
	
    public function zituanlist() {
		//筛选条件
		$_REQUEST['status_shop'] = array('neq','');
		$_REQUEST['webpage'] = 1;
		A("Method")->_zituanlist('产品搜索');	
    }
	
	
    public function getyudinglist() {
		$chanpinID = $_REQUEST['chanpinID'];
		$WEBServiceOrder = D("WEBServiceOrder");
		$orderall = $WEBServiceOrder->where("`clientdataID` = '$chanpinID'")->findall();
		//返回	
		$str = '
			<table cellpadding="0" cellspacing="0" width="100%" class="list view">
				<tr height="20">
				  <th scope="col" nowrap="nowrap"><div> 序号 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单编号 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 联系人姓名  </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:60px;"><div> 电话 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 邮箱 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 成人 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 儿童 </div></th>
				  <th scope="col" nowrap="nowrap" style="min-width:80px;"><div> 订单时间 </div></th>
				</tr>
		';
		$i = 0;
		foreach($orderall as $v){$i++;
			$str .= '
			<tr class="evenListRowS1">
			  <td>'.$i.'</td>
			  <td>'.$v['orderID'].'</a></td>
			  <td>'.$v['lxr_name'].'</td>
			  <td>'.$v['lxr_telnum'].'</td>
			  <td>'.$v['lxr_email'].'</td>
			  <td>'.$v['chengrenshu'].'</td>
			  <td>'.$v['ertongshu'].'</td>
			  <td>'.date("Y-m-d H:i:s",$v['time']).'</td>
			</tr>
			';
		}
		$str .= '
			<tr class="evenListRowS1">
			  <td align="right" colspan="3">
			  '.$page.'
			  </td>
			</tr>
			</table>
		';
		$this->ajaxReturn($str, '', 1);
		//$this->ajaxReturn($orderall, '读取成功！', 1);
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>