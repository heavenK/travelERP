<?php

class FormeAction extends Action{

    public function chanpinxianlu() {
		echo "开始";
		echo "<br>";
		
		$gl_xianlu=D("glxianlu");
		$xianluAll = $gl_xianlu->order('time DESC')->limit(100)->findall();
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
			//xingcheng
			$this->xingcheng($v,$chanpinID);
			//chanpin  zituan
			$this->zituan($v,$chanpinID);
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
	
	
    private function xingcheng($v,$chanpinID) {
		
		$glxingcheng=M("glxingcheng");
		$xingchengAll = $glxingcheng->where("`xianluID` = '$v[xianluID]'")->findall();
		$myerp_chanpin_xingcheng=M("myerp_chanpin_xingcheng");
		//线路
		foreach($xingchengAll as $v)
		{
			$dat = $v;
			$dat['chanpinID'] = $chanpinID;
			$dat['chanyin'] = $v['time'];
			$myerp_chanpin_xingcheng->add($dat);
		}
		
    }
	
    private function zituan($v,$chanpinID) {
		$myerp_chanpin_zituan=M("myerp_chanpin_zituan");
		$myerp_chanpin=M("myerp_chanpin");
		$glzituan=M("glzituan");
		$zituanAll = $glzituan->where("`xianluID` = '$v[xianluID]'")->findall();
		
		foreach($zituanAll as $v)
		{
			//chanpin
			$dat = $v;
			$dat['title'] = $v['mingcheng'];
			$dat['typeName'] = '子团';
			$dat['parentID'] = $chanpinID;
			$dat['status'] = $v['zhuangtai'];
			$zituanchanpinID = $myerp_chanpin->add($dat);
			//zituan
			$dat = $v;
			$dat['chanpinID'] = $zituanchanpinID;
			$myerp_chanpin_zituan->add($dat);
		}
		
    }
	
	
    public function fullinfo() {
		echo "开始";
		echo "<br>";
		//主题
		$theme = D('Line_theme');
		$theme_all = $theme->findAll();
		$Info=D("Info");
		foreach($theme_all as $v)
		{
			$d = $v;
			$d['typeName'] = '产品主题';
			$d['time'] = $v['pubdate'];
			$d['islock'] = '未锁定';
			$d['user_name'] = '系统';
			$d['user_id'] = '-1';
			$d['departmentName'] = '系统';
			$d['departmentID'] = '-1';
			$d['status'] = '系统';
			$Info->add($d);
		}
		echo "结束";
	}
	
	
	
	
	
}
?>