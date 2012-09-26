function openDUR (userID,dataitle)
{
	window.location.href=SITE_INDEX+"SetSystem/userDUR/systemID/"+userID+"/datatitle/"+dataitle; 
}

function dosearch(str){
	window.location = SITE_INDEX+'SetSystem/systemUser'+str;
}
function setlock(){
	var elm=document.getElementsByName('select');
	checked=false;
	for(ii=0;ii<elm.length;ii++)
		if(elm[ii].checked){
			jQuery.ajax({
				type:	"POST",
				url:	SITE_INDEX+"SetSystem/dopostSystemHas/tableName/user/systemID/"+elm[ii].value,
				data:	'islock=已锁定',
				success:	function(msg){
						ThinkAjax.myAjaxResponse(msg,'resultdiv',setafter);
				}
			});
			checked=true;
			break;
			}
	if (!checked){alert('请选择')}
}
function resetpwd(str){
	var elm=document.getElementsByName('select');
	checked=false;
	for(ii=0;ii<elm.length;ii++)
		if(elm[ii].checked){
			jQuery.ajax({
				type:	"POST",
				url:	SITE_INDEX+"SetSystem/dopostSystemHas/tableName/user/systemID/"+elm[ii].value,
				data:	'password=123456',
				success:	function(msg){
						ThinkAjax.myAjaxResponse(msg,'resultdiv',setafter);
				}
			});
			checked=true;
			break;
			}
	if (!checked){alert('请选择')}
}
function setafter(data,status){
	if(status == 1)
	location.reload();
}
