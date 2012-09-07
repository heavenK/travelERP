function openDUR (userID,dataitle)
{
	window.location.href=SITE_INDEX+"SetSystem/userDUR/systemID/"+userID+"/datatitle/"+dataitle; 
}

function info ()
{
	var elm=document.getElementsByName('select');
	checked=false;
	for(ii=0;ii<elm.length;ii++)
		if(elm[ii].checked){checked=true;break;}
	if (!checked){alert('请选择')}
	else
	{
		alert('aa')
	}
}

