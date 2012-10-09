<?php

function NF_getusername(){  
	return A("Method")->user['title'];
}

function NF_getmydepartmentid($chanpinID = ''){  
	$bumenID = cookie('_usedbumenID');
	if(!$bumenID)//随机选择部门
	{
		//$DURlist = A("Method")->_getDURlist(A("Method")->user['systemID'],1,);
		$DURlist = A("Method")->_getbumenfenleilist('组团,地接,业务');
		$bumenID = $DURlist[0]['bumenID'];
		//获得部门名
		$ViewDepartment = D("ViewDepartment");
		$bumen = $ViewDepartment->where("`systemID` = '$bumenID'")->find();
		cookie('_usedbumen',$bumen['title'],30);
		return $bumenID;
	}
	elseif($chanpinID){
		$Chanpin = D("Chanpin");
		$chanp = $Chanpin->where("`chanpinID` = '$chanpinID'")->find();
		cookie('_usedbumen',$chanp['bumen_copy'],30);
		return $chanp['departmentID'];
	}
	return $bumenID;
}

function NF_getbumen(){ 
	$_usedbumen = cookie('_usedbumen');
	if(!$_usedbumen)
		return '系统发生错误！！！编号erp232';
	return $_usedbumen;
}

function NF_getbumen_title($departmentID){  
	if($departmentID){
		$ViewDepartment = D("ViewDepartment");
		$bumen = $ViewDepartment->where("`systemID` = '$departmentID'")->find();
		return $bumen['title'];
	}
	else{
		NF_getbumen();
	}
}


//俩数组相连，并去掉重复元素
function NF_combin_unique($a,$b){
	$a = array_values($a);
	$b = array_values($b);
	$i = count($a);
	for($j = 0; $j<count($b);$j++){
		$a[$i] = $b[$j];
		$i++;
	}
	return array_unique($a);
}


function NF_getmonth(){  
	//得到系统的年月
	$tmp_date=date("Ym");
	//切割出年份
	$tmp_year=substr($tmp_date,0,4);
	//切割出月份
	$tmp_mon =substr($tmp_date,4,2);
	$tmp_nextmonth=mktime(0,0,0,$tmp_mon+1,1,$tmp_year);
	$tmp_forwardmonth=mktime(0,0,0,$tmp_mon-1,1,$tmp_year);
	//得到当前月的下一个月 
	$fm_next_month=date("Y-m",$tmp_nextmonth);
	//得到当前月的上一个月 
	$fm_forward_month=date("Y-m",$tmp_forwardmonth);
	$m['forward'] = $fm_forward_month;  
	$m['next'] = $fm_next_month; 
	return $m;
}


//获得两个日期之间的日期列表
function NF_getdatelistbetweentwodate($d0,$d1,$returntype = 'array'){  
	$_time = range(strtotime($d0), strtotime($d1), 24*60*60);
	$_time = array_map(create_function('$v', 'return date("Y-m-d", $v);'), $_time);
	if($returntype == 'array')
	return $_time;
	if($returntype == 'string')
	return implode(',',$_time);
}

















?>