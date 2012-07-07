<?php

function NF_getusername(){  
	return A("Method")->user['title'];
}

function NF_getmydepartmentid(){  
	$bumenID = A("Method")->_getOMUsedBumenID();
	if(!$bumenID)
	{
		$DURlist = A("Method")->_getDURlist(A("Method")->user['systemID']);
		return $DURlist[0]['departmentID'];
	}
	return $bumenID;
}

?>