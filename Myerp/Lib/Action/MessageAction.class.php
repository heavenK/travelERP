<?php

class MessageAction extends Action{

	public function getNews(){
		$DataNotice = D("DataNotice");
		$myuserID = $this->user['systemID'];
		$notice = $DataNotice->where("`userID` = '$myuserID'")->order("id desc")->limit('0,10')->findall();
		if($notice != null){
			foreach($notice as $v){
				$str .= '<a href="javascript:void(0)" style="padding:0 2px 4px 8px; width:100%" onclick="del_alert('.$v['id'].');window.open(\''.$v['url'].'\')">
						<img border="0" width="16" height="16" align="absmiddle" src="'.__PUBLIC__.'/myerp/images/icon_SugarFeed.gif">&nbsp;<span>'.$v['message'].'</span>
						</a>';
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
			  <input class="button" type="button" value=" 删除 " onclick="del_alert('.$v['id'].');getNewsAll(\'Index.php?s=/Message/getNewsAll\')" >
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














	
}
?>