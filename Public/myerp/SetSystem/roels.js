
 var i=0;
 function insertItem(divname)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+"_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<form id='form_t"+i+"' ><input type=\"text\" id=\"title_t"+i+"\" check='^\\S+$' warning=\"标题不能为空,且不能含有空格\" ></form>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"remark_t"+i+"\" style=\"width:400px\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+i+",'"+divname+"_t','temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onClick=\"if(CheckForm('form_t"+i+"','resultdiv_2'))save("+i+",'"+divname+"_t','_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#"+divname+"_box").append(htmlcontent);
	
 }

 function save(id,divname,mark)
 {
	var it = '';
	if(!mark){
		it ="&systemID="+id;
		mark = '';
	}
	if(!divname){
		divname = '';
	}
	var title = jQuery("#title"+mark+id).val();
	var remark = jQuery("#remark"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/dopostSystemHas/tableName/roles",
		data:	"title="+title+"&remark="+remark+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',om_save,id,divname);
		}
	});
	
 }
 
 function om_save(data,status,info,type,id,divname)
 {
	if(status == 1){
		location.reload();
	}
 }

 function deleteSystemItem(id,divname,type)
 {
	if(type == 'temp')
		jQuery("#"+divname+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/deleteSystemItem/tableName/roles",
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


