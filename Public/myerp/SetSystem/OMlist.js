function openlist (dataID,datatype,datatitle)
{
	window.location.href=SITE_INDEX+"SetSystem/addSystemOM/method/开放/dataID/"+dataID+"/datatype/"+datatype+"/datatitle/"+datatitle; 
}

function managelist (dataID,datatype,datatitle)
{
	window.location.href=SITE_INDEX+"SetSystem/addSystemOM/method/管理/dataID/"+dataID+"/datatype/"+datatype+"/datatitle/"+datatitle; 
}

function dosearch()
{
	title = document.getElementById('title').value;
	window.location = SITE_INDEX+'SetSystem/systemOM/datatype/线路/title/'+title;
}
