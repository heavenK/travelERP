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

?>