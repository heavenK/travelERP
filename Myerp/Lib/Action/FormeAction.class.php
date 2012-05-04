<?php

class FormeAction extends Action{

    public function chanpinxianlu() {
		echo "开始";
		echo "<br>";
		
		$gl_xianlu=D("glxianlu");
		$xianluAll = $gl_xianlu->findall();
		$myerp_chanpin=D("myerp_chanpin");
		$myerp_chanpin_xianlu=D("myerp_chanpin_xianlu");
		//线路
		foreach($xianluAll as $v)
		{
			//chanpin
			$dat = $v;
			$dat['typeName'] = '线路';
			$dat['title'] = $v['mingcheng'];
			$dat['status'] = $v['zhuangtai'];
			$chanpinID = $myerp_chanpin->add($dat);
			//chanpin_xianlu
			$dat = $v;
			$dat['chanpinID'] = $chanpinID;
			$dat['keyword'] = $v['guanjianzi'];
			$myerp_chanpin_xianlu->add($dat);
			//message
			$this->chanpinxiaoxi($v,$chanpinID);
		}
		
		echo "结束";
		
    }
	
	
    private function chanpinxiaoxi($v,$chanpinID) {
		$glmessage=D("glmessage");
		$myerp_message=D("myerp_message");
		$message = $glmessage->where("`tableID` = '$v[xianluID]' and `tablename` = '线路'")->findall();
		foreach($message as $b)
		{
			//message
			$dat = $b;
			$dat['typeName'] = '线路';
			$dat['user_name'] = $b['username'];
			$dat['departmentID'] = $b['laiyuan'];
			$dat['chanpinID'] = $chanpinID;
			$dat['title'] = $b['content'];
			$myerp_message->add($dat);
			
		}
    }
	
	
	
	
	
	
	
	
	
	
	
	
}
?>