<?php

class FormeAction extends Action{

    public function chanpinxianlu() {
		echo "开始";
		echo "<br>";
		
		$gl_xianlu=D("glxianlu");
		//$xianluAll = $gl_xianlu->order('time DESC')->limit(50)->findall();
		$xianluAll = $gl_xianlu->where("`xianluID` = '278'")->findall();
		$myerp_chanpin=D("myerp_chanpin");
		$myerp_chanpin_xianlu=D("myerp_chanpin_xianlu");
		//线路
		foreach($xianluAll as $v)
		{
			//chanpin
			$dat = $v;
			$dat['typeName'] = '线路';
			$dat['status'] = $v['zhuangtai'];
			$chanpinID = $myerp_chanpin->add($dat);
			//chanpin_xianlu
			$dat = $v;
			$dat['chanpinID'] = $chanpinID;
			$dat['keyword'] = $v['guanjianzi'];
			$dat['title'] = $v['mingcheng'];
			$myerp_chanpin_xianlu->add($dat);
			//message
			$this->chanpinxiaoxi($v,$chanpinID);
			//xingcheng
			$this->xingcheng($v,$chanpinID);
			//chanpin  zituan
			$this->zituan($v,$chanpinID);
			//chengben shoujia
			$this->chengbenshoujia($v,$chanpinID);
			//exit;
		}
		
		echo "结束";
		
    }
	
	
    private function chanpinxiaoxi($v,$chanpinID) {
		$glmessage=M("glmessage");
		$myerp_message=M("myerp_message");
		$message = $glmessage->where("`tableID` = '$v[xianluID]' and `tablename` = '线路'")->findall();
		foreach($message as $b)
		{
			//message
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
	
	
    private function chengbenshoujia($xianlu,$chanpinID) {
		
		$Glxianlujiage = D("Glxianlujiage");
		$Glchengbenxiang = D("Glchengbenxiang");
		$Glshoujia = D("Glshoujia");
		$Glchengben = D("Glchengben");
		
		$oldjiage = $Glxianlujiage->where("`xianluID` = '$xianlu[xianluID]'")->find();
		$dd = $this->myjiagedata($oldjiage);
//		//zituan
		$Zituan = D("Zituan");
		$Xianlu = D("Xianlu");
		$xl = $Xianlu->where("`ChanpinID` = '$chanpinID'")->find();
		$xl['remark'] = $dd['xianlu']['remark'];
		$Xianlu->save($xl);
		
		//chengben
		$Chengben = D("Chengben");
		foreach($dd['chengben'] as $v)
		{
			$data = $v;
			$data['chanpinID'] = $chanpinID;
			$Chengben->add($data);
		}
		//shoujia
		$myerp_chanpin=M("myerp_chanpin");
		$myerp_chanpin_shoujia=M("myerp_chanpin_shoujia");
		foreach($dd['shoujia'] as $v)
		{
			//chanpin
			$data = $v;
			$data['parentID'] = $chanpinID;
			$data['typeName'] = '售价';
			$data['user_name'] = $xianlu['user_name'];
			$data['user_id'] = $xianlu['user_id'];
			$data['departmentName'] = $xianlu['departmentName'];
			$data['departmentID'] = $xianlu['departmentID'];
			$data['time'] = $xianlu['time'];
			$chanpinID_shoujia = $myerp_chanpin->add($data);
			//chanpin shoujia
			$data2 = $v;
			$data2['chanpinID'] = $chanpinID_shoujia;
			$data2['type'] = '标准';
			$data2['renshu'] = $xianlu['renshu'];
			$myerp_chanpin_shoujia->add($data2);
			//jijiu
			if($dd['jijiu'])
			{
				$data3 = $dd['jijiu'];
				$data3['chanpinID'] = $chanpinID_shoujia;
				$data3['type'] = '机票酒店';
				$chanpinID_shoujia = $myerp_chanpin_shoujia->add($data3);
			}
		}
		
		

    }
	
	private function myjiagedata($oldjiage)
	{
			$Glxianlujiage = D("Glxianlujiage");
			$Glchengbenxiang = D("Glchengbenxiang");
			$Glshoujia = D("Glshoujia");
			$Glchengben = D("Glchengben");
			
			$xianlu['remark'] = $oldjiage['ertongshuoming'];
			//chengben
			$oldchengben = $Glchengbenxiang->where("`jiageID` = '$oldjiage[jiageID]'")->findall();
			  $i = 0;
			  foreach($oldchengben as $v)
			  {
				$chengben[$i]['typeName'] = $v['leixing'];
				$chengben[$i]['title'] = $v['miaoshu'];
				$chengben[$i]['price'] = $v['jiage'] * $v['cishu'] * $v['shuliang'];
				$chengben[$i]['jifeitype'] = $v['jifeileixing'];
				$chengben[$i]['time'] = $v['time'];
				$i++;
			  }
			  //shoujia
			  $oldshoujia = $Glshoujia->where("`jiageID` = '$oldjiage[jiageID]'")->findall();
			  $i = 0;
			  foreach($oldshoujia as $v)
			  {
				  $shoujia[$i]['adultprice'] = $v['chengrenshoujia'];
				  $shoujia[$i]['childprice'] = $v['ertongshoujia'];
				  $shoujia[$i]['cut'] = $v['cut'];
				  $i++;
			  }
			  //jipiaojiudian
			  $jijiu['adultprice'] = $oldjiage['adultcostair'] + $oldjiage['adultcosthotle'];
			  $jijiu['childprice'] = $oldjiage['childcostair'] + $oldjiage['childcosthotle'];
			  $jijiu['cut'] = $oldjiage['aircut'] + $oldjiage['hotlecut'];
			  $jijiu['renshu'] = $oldjiage['airhotlenumber'];
			  
			  $re['jijiu'] = $jijiu;
			  $re['chengben'] = $chengben;
			  $re['shoujia'] = $shoujia;
			  $re['xianlu'] = $xianlu;
			  
			  return $re;
	}
	
}
?>