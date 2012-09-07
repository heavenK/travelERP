<?php

function NF_getusername(){  
	return A("Method")->user['title'];
}

function NF_getmydepartmentid(){  
	$bumenID = cookie('_usedbumenID');
	if(!$bumenID)
	{
		$DURlist = A("Method")->_getDURlist(A("Method")->user['systemID']);
		return $DURlist[0]['departmentID'];
	}
	return $bumenID;
}

function NF_getbumen(){  
	$_usedbumen = cookie('_usedbumen');
	if(!$_usedbumen)
	{
		$DURlist = A("Method")->_getDURlist(A("Method")->user['systemID']);
		$bumenID = $DURlist[0]['departmentID'];
		//获得部门名
		$ViewDepartment = D("ViewDepartment");
		$bumen = $ViewDepartment->where("`systemID` = '$bumenID'")->find();
		return $bumen['title'];
	}
	return $_usedbumen;
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