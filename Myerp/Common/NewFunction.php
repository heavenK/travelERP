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








?>