
 var i=0;
 function insertItem(divname)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+"_t"+i+"\">";
    htmlcontent += '<form method="post" action="'+SITE_INDEX+'SetSystem/dopostDataDictionary/" enctype="multipart/form-data" target="iframeUpload"> ';
    htmlcontent += '<INPUT TYPE="hidden" name="uploadResponse" value="uploadComplete">'
    htmlcontent += '<INPUT TYPE="hidden" name="type" value="视频">';
    htmlcontent += '<INPUT TYPE="hidden" name="tempID" value="'+i+'">';
    htmlcontent += '<td scope="row" align="left" valign="top"></td>';
    htmlcontent += '<td scope="row" align="left" valign="top"><input type="text" name="title" id="title" style="width:200px" ></td>';
    htmlcontent += '<td scope="row" align="left" valign="top"><input type="text" name="description" id="description" style="width:200px" ></td>';
    htmlcontent += '<td scope="row" align="left" valign="top"><input type="text" name="video_url" id="video_url" style="width:200px" ></td>';
    htmlcontent += '<td scope="row" align="left" valign="top"><input type="file" name="image" style="width:200px" ></td>';
    htmlcontent += '<td scope="row" align="left" valign="top">';
    htmlcontent += '<input class="button" type="button" value="删除" onClick="deleteSystemItem('+i+',\''+divname+'_t\',\'temp\')" />';
    htmlcontent += '<input class="button" type="submit" value="添加"/>';
    htmlcontent += '</td></form></tr>';
	
	jQuery("#"+divname+"_box").append(htmlcontent);
	
 }
 
 function om_save(data,status)
 {
	id = data['tempID'];
	if(id)
	divname = 'itemlist_t';
	else{
	divname = 'itemlist';
	id=data['systemID'];
	}
	if(status == 1){
		var htmlcontent = '<tr height="30" class="evenListRowS1" id="itemlist'+data['systemID']+'">';
		htmlcontent += '<form method="post" action="'+SITE_INDEX+'SetSystem/dopostDataDictionary/" enctype="multipart/form-data" target="iframeUpload"> ';
		htmlcontent += '<INPUT TYPE="hidden" name="uploadResponse" value="uploadComplete">'
		htmlcontent += '<INPUT TYPE="hidden" name="type" value="视频">';
		htmlcontent += '<INPUT TYPE="hidden" name="systemID" value="'+data['systemID']+'">';
		htmlcontent += '<td scope="row" align="left" valign="top"></td>';
		htmlcontent += '<td scope="row" align="left" valign="top"><input type="text" name="title" style="width:200px" value="'+data['title']+'" ></td>';
		htmlcontent += '<td scope="row" align="left" valign="top"><input type="text" name="description" style="width:200px" value="'+data['description']+'" ></td>';
		htmlcontent += '<td scope="row" align="left" valign="top"><input type="text" name="video_url" style="width:200px" value="'+data['video_url']+'" ></td>';
		htmlcontent += '<td scope="row" align="left" valign="top"><input type="file" name="image" style="width:200px" ><a  href="javascript:void(0)" onmouseover="showpic(\''+data['pic_url']+'\');" onmouseout="closeshowpic();">查看</a></td>';
		htmlcontent += '<td scope="row" align="left" valign="top">';
		htmlcontent += '<input class="button" type="button" value="删除" onClick="deleteSystemItem('+data['systemID']+',\'itemlist\')" />';
		htmlcontent += '<input class="button" type="submit" value="修改"/>';
		htmlcontent += '</td></form></tr>';
		jQuery("#"+divname+id).replaceWith(htmlcontent);
	}
 }

 function deleteSystemItem(id,divname,type)
 {
	if(type == 'temp'){
		jQuery("#"+divname+id).remove();
	}
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/deleteSystemItem/tableName/datadictionary",
		data:	"systemID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',del_after,divname+id);
		}
	});
	
 }

 function del_after(data,status,info,type,id)
 {
	if(status == 1){
		//jQuery("#"+id).remove();
	}
 }

function addSystemDC (systemID)
{
	window.location.href=SITE_INDEX+"SetSystem/addSystemDC/systemID/"+systemID; 
}

