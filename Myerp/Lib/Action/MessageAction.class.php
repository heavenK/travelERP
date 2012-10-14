<?php

class MessageAction extends Action{
	
    public function _initialize() {
        if (!$this->user)
            redirect(SITE_INDEX.'Index/index');
		$this->_myinit();	
    }
	
    public function _myinit() {
		$this->assign("navposition",'信息');
	}

    public function index() {
		$datatype = $_REQUEST['datatype'];
		A("Method")->showDirectory($datatype);
		$chanpin_list = A('Method')->getDataOMlist($datatype,'info',$_REQUEST,'管理');
		if($_REQUEST['returntype'] == 'ajax' ){
				$str = '
					<table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view">
						<tr height="20">
						  <td valign="top" scope="row" style="min-width:50px;"> 标题:</td>
						  <td valign="top" scope="row" style="min-width:800px;"><h1><strong>'.$chanpin_list['chanpin'][0]['title'].'</strong></h1>
						  </td>
						</tr>
						</tbody>
					</table>
					<table cellspacing="1" cellpadding="0" border="0" width="100%" class="edit view" style=" border-top-color: #CBDAE6 !important;">
						<tbody>
						  <tr>
							<td valign="top" scope="row" style="min-width:50px;"> 内容: </td>
							<td valign="top" colspan="3" style="min-width:800px;">'.$chanpin_list['chanpin'][0]['message'].'
						  </td>
						  </tr>
						</tbody>
					  </table>
				';
				$this->ajaxReturn($str, '', 1);
		}
		else
		if($_REQUEST['returntype'] == 'array' ){
			$data = $chanpin_list['chanpin'][0];
			//获得omlist
			$dataOMlist = A("Method")->_getDataOM($data['messageID'],'公告','管理','DataOMMessage');
			$i = 0;
			foreach($dataOMlist as $v){
				list($bumenID,$rolesID,$userID) = split(',',$v['DUR']);
				if($bumenID){
					$bumenlist[$i] = $bumenID;
					$i++;
				}
			}
			$data['bumenlist'] = $bumenlist;
			$this->ajaxReturn($data, '读取成功！', 1);
		}
		else
		{
			$this->assign("page",$chanpin_list['page']);
			$this->assign("chanpin_list",$chanpin_list['chanpin']);
			//部门分类
			$ViewCategory = D("ViewCategory");
			$categorylist = $ViewCategory->where("`islock` = '未锁定'")->findall();
			$i = 0;
			foreach($categorylist as $v){
				$datalist = A("Method")->_getsystemDC($v['systemID']);
				$categorylist[$i]['systemDClist'] = $datalist['systemDClist'];
				$i++;
			}
			$this->assign("categorylist",$categorylist);
			//查看权限
			$role = A("Method")->_checkRolesByUser('网管,秘书,财务,财务总监,总经理','行政');
			if(false !== $role)
				$is_fabu = 1;
			$this->assign("is_fabu",$is_fabu);
			if($_REQUEST['datatype'] == '公告')
			$this->display('gonggao');
			if($_REQUEST['datatype'] == '排团表')
			$this->display('paituanbiao');
			if($_REQUEST['datatype'] == '系统提示')
			$this->display('systeminfo');
		}
    }
	
	
    public function infodelete() {
		$durlist = A("Method")->_checkRolesByUser('网管,秘书,财务,财务总监,总经理','行政');
		if (false === $durlist)
			$this->ajaxReturn('', '没有权限！', 0);
		$data['messageID'] = $_REQUEST['messageID'];
		$data['status_system'] = -1;
		$Message = D("Message");
		if (false !== $Message->save($data))
			$this->ajaxReturn('', '删除成功！', 1);
		else
			$this->ajaxReturn('', $Message->getError(), 0);
	}
	
	
    public function dopostMessageInof() {
		C('TOKEN_ON',false);
		$data = $_REQUEST;
		$data['info'] = $_REQUEST;
		$durlist = A("Method")->_checkRolesByUser('网管,秘书,财务,财务总监,总经理','行政');
		if (false === $durlist)
			$this->ajaxReturn('', '没有权限！', 0);
		$data['info']['usedDUR'] = $durlist[0]['bumenID'].','.$durlist[0]['rolesID'].','.$durlist[0]['userID'];
		$Message = D("Message");
		//文档上传
		$datatype = $_REQUEST['type'];
		//如果有文件上传 上传附件
		$savepath = './Data/Files/'; 
		if($datatype == '排团表'){
			if ($_FILES['attachment']['name'] != '') { 
				$data["info"]['url_file'] = A("Method")->_upload($savepath); 
			}
			if($data['messageID'] && $data["info"]['url_file']){
				$dd = $Message->relation('info')->where("`messageID` = '$data[messageID]'")->find();
				if($dd){
					unlink($savepath.$dd['info']['attachment']);
				}
			}
			if(!$data['messageID'] && false === $data["DJtuan"]['attachment'])
				$data["info"]['attachment'] = '';
		}
		if (false !== $Message->relation("info")->myRcreate($data)){
			$_REQUEST['messageID'] = $Message->getRelationID();
			//清空OM
			$DataOMMessage = D("DataOMMessage");
			$DataOMMessage->where("`dataID` = '$_REQUEST[messageID]' and `datatype` = '$datatype'")->delete();
			//生成OM
			$bumenlist = $_REQUEST['bumenlist'];
			$i = 0;
			foreach($bumenlist as $v){
				$dataOMlist[$i]['DUR'] = $v.',,';
				$i++;
			}
			A("Method")->_createDataOM($_REQUEST['messageID'],$datatype,'管理',$dataOMlist,'DataOMMessage');
			
			if($datatype == '排团表')
				A("Method")->ajaxUploadResult($_REQUEST,'保存成功',1);
			$this->ajaxReturn($_REQUEST, '保存成功！', 1);
		}
		if($datatype == '排团表')
		  A("Method")->ajaxUploadResult($_REQUEST,$Chanpin->getError(),0);
		$this->ajaxReturn($_REQUEST, $Message->getError(), 0);
	}


	public function left_kongguan() {
		$this->display('Message:left_kongguan');
	}
	


    public function infohistory() {
		A("Method")->showDirectory('系统提示');
		$chanpin_list = A('Method')->getDataOMlist('消息','infohistory',$_REQUEST,'管理');
		$this->assign("page",$chanpin_list['page']);
		$this->assign("chanpin_list",$chanpin_list['chanpin']);
		$this->display('infohistory');
	}
	
	


	public function getNews(){
		$DataNotice = D("DataNotice");
		$myuserID = $this->user['systemID'];
		$notice = $DataNotice->where("`userID` = '$myuserID'")->order("id desc")->limit('0,10')->findall();
		if($notice != null){
			foreach($notice as $v){
				$str .= '<span style="width:100%;float:left;"><a href="javascript:void(0)" style="padding:0 2px 4px 8px; " onclick="del_alert('.$v['id'].');window.open(\''.$v['url'].'\')">
						<img border="0" width="16" height="16" align="absmiddle" src="'.__PUBLIC__.'/myerp/images/icon_SugarFeed.gif">&nbsp;<span>'.$v['message'].'</span>
						</a></span>';
			}
			$this->ajaxReturn($str, '', 1);
		}
		else
			$this->ajaxReturn('', '', 0);
	}


	public function delNews(){
		$DataNotice = D("DataNotice");
		if($_REQUEST['dowhat'] == 'all'){
			$myuserID = $this->user['systemID'];
			$notice = $DataNotice->where("`userID` = '$myuserID'")->delete();
		}
		else{
			$id = $_REQUEST['id'];
			$notice = $DataNotice->where("`id` = '$id'")->delete();
		}
		$this->ajaxReturn($str, '', 1);
	}


	public function getNewsAll($pagenum = 10){
		$myuserID = $this->user['systemID'];
		$where['userID'] = $myuserID;
		$DataNotice = D("DataNotice");
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $DataNotice->where($where)->count();
		$p= new Page($count,$pagenum);
		$page = $p->show_ajax("getNewsAll");
        $data = $DataNotice->where($where)->limit($p->firstRow.','.$p->listRows)->order("id desc")->select();
		$str = '
            <table cellpadding="0" cellspacing="0" width="100%" class="list view">
                <tr>
                  <th><div> 序号 </div></th>
                  <th><div> 标题 </div></th>
                  <th><div> 操作 </div></th>
                </tr>
		';
		$i = 0;
		foreach($data as $v){$i++;
			$str .= '
			<tr class="evenListRowS1">
			  <td>'.$i.'</td>
			  <td>
			  <a style="text-decoration:none" href="javascript:void(0)" onclick="del_alert('.$v['id'].');window.open(\''.$v['url'].'\')">
			  '.$v['message'].'
			  </td>
			  <td>
			  <input class="button" type="button" value=" 删除 " onclick="del_alert('.$v['id'].');getNewsAll(\'index.php?s=/Message/getNewsAll\')" >
			  </td>
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
	}


	public function liandong(){
	    $type=$_POST['type'];
        $pid=$_POST['parentID'];
		$liandong = D("myerp_liandong");
		if ($type == '城市'){
			$user=$liandong->where("pid='$pid'")->findAll();
		}
		if ($type == '省份'){
			$condition['pid'] = array('between','1,99'); 
			$user=$liandong->where($condition)->findAll();
		}
		if ($type == '地区'){
			$condition['pid'] = 0; 
			$user=$liandong->where($condition)->findAll();
		}
		$i = 1;
		foreach ($user as $row){
			if ($i == 1)
				echo "<option value='".$row['id']."' selected='selected'>".$row['position']. "</option>";
			else
				echo "<option value='".$row['id']."'>".$row['position']."</option>";
			$i++;
		}
	}




	public function getshenhemessage($pagenum = 10){
		$where['chanpinID'] = $_REQUEST['chanpinID'];
		$chanpin_list = A('Method')->getDataOMlist('消息','infohistory',$where,'开放',10,'getshenhemessage','message');
		$data = $chanpin_list['chanpin'];
		$str = '
            <table cellpadding="0" cellspacing="0" width="100%" class="list view">
                <tr>
                  <th height="24px" width="30px"><div> 序号 </div></th>
                  <th width="400px"><div> 内容 </div></th>
                </tr>
		';
		$i = 0;
		foreach($data as $v){$i++;
			$str .= '
			<tr class="evenListRowS1">
			  <td>'.$i.'</td>
			  <td>
			  <a style="text-decoration:none" href="javascript:void(0)">
			  '.$v['message'].'
			  </td>
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
	}








	
}
?>