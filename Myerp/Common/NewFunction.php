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

function about_unique($arr=array()){  
   /*TP数据库层读取出得二维数组内容唯一化
     基本情况：将该种二维数组看成一维数组，则
     该一维数组的value值有相同的则干掉只留一个，并将该一维
     数组用重排后的索引数组返回，而返回的一维数组中的每个元素都是
     原始key值形成的关联数组
   */
   $keys =array();
   $temp = array();
   foreach($arr[0] as $k=>$arrays) {
    /*数组记录下关联数组的key值*/
    $keys[] = $k;
   }
   //return $keys;
   /*降维*/
   foreach($arr as $k=>$v) {
    $v = join(",",$v);  //降维
    $temp[] = $v;
   }
   $temp = array_unique($temp); //去掉重复的内容
   foreach ($temp as $k => $v){
    /*再将拆开的数组按索引数组重新组装*/
    $temp[$k] = explode(",",$v);  
   } 
   //return $temp;
   /*再将拆开的数组按关联数组key值重新组装*/
   foreach($temp as $k=>$v) {
    foreach($v as $kkk=>$ck) {
     $data[$k][$keys[$kkk]] = $temp[$k][$kkk];
    }
   }
   return $data;
  }


//俩数组相连，并去掉重复元素,根据环境支持二维数组
function NF_combin_unique($a,$b){
	$a = array_values($a);
	$b = array_values($b);
	$i = count($a);
	for($j = 0; $j<count($b);$j++){
		$a[$i] = $b[$j];
		$i++;
	}
	if(count($a, COUNT_RECURSIVE) == count($a))
	return array_unique($a);
	else
	return about_unique($a);
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

//反序列化失效解决办法之一//此方法会移除格式
function mb_unserialize($serial_str) {
    $serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );//格式移除原因
    $serial_str= str_replace("\r", "", $serial_str);      
    $serial_str = unserialize($serial_str);
	foreach($serial_str as $key => $val)
	$serial_str[$key] = stripslashes($val);
	return $serial_str;
}	

function simple_unserialize($serial_str) {
    //$serial_str= preg_replace('!s:(\d+):"(.*?)";!se', '"s:".strlen("$2").":\"$2\";"', $serial_str );//格式不移除,不安全
    //$serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );//格式移除原因
//    $serial_str= str_replace("\r", "", $serial_str);      
    return unserialize($serial_str);
}	













?>