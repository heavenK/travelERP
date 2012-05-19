<?php

class InfoAction extends Action{

	public function addinfo(){
		C('TOKEN_ON',false);
		$d['title'] = $_REQUEST['zhutititle'];
		$d['typeName'] = $_REQUEST['zhutitype'];
		$Info = D("Info");
		if (false !== $Info->mycreate($d))
			$this->ajaxReturn($d['title'], '保存成功！', 1);
		else
			$this->ajaxReturn($d['title'], $Info->getError(), 0);
	}
	
}
?>