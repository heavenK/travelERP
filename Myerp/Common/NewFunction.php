<?php

function NF_getusername(){  
	return A("Method")->user['title'];
}

function NF_getmydepartmentid(){  
	$bumenID = A("Method")->_getOMUsedBumen();
	if(!$bumenID)
	{
		$DURlist = A("Method")->_getDURlist(A("Method")->user['systemID']);
		return $DURlist[0]['departmentID'];
	}
	return $bumenID;
}

//function NF_getuserid(){  
// 
//	return "-1";
//	return A("Chanpin")->roleuser['user_id'];
//}
//
//function NF_getmydepartmentname(){  
// 
//	return "高鹏";
//	return A("Chanpin")->roleuser['user_name'];
//}




?>