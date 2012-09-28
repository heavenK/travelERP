
 var i=0;
 function insertItem(divname)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+"_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<form id='form_t"+i+"' ><input type=\"text\" id=\"title_t"+i+"\" style=\"width:200px;\" check='^\\S+$' warning=\"标题不能为空,且不能含有空格\" ></form>";
	htmlcontent += "</td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"description_t"+i+"\" style=\"width:200px\" ></td>";
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
	var description = parseInt(jQuery("#description"+mark+id).val());
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/dopostSystemHas/tableName/datadictionary",
		data:	"type=提成&title="+title+"&description="+description+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',om_save,id,divname);
		}
	});
	
 }
 
 function om_save(data,status,info,type,id,divname)
 {
	if(status == 1){
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+data['systemID']+"\">";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<form id='form"+data['systemID']+"' ><input type=\"text\" id=\"title"+data['systemID']+"\" style=\"width:200px;\" value=\""+data['title']+"\"></form>";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"description"+data['systemID']+"\" style=\"width:200px\"  value=\""+data['description']+"\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+data['systemID']+",'"+divname+"',);\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onClick=\"if(CheckForm('form"+data['systemID']+"','resultdiv_2'))save("+data['systemID']+");\" />";
		htmlcontent += "</tr>";
		jQuery("#"+divname+id).replaceWith(htmlcontent);
	}
 }

 function deleteSystemItem(id,divname,type)
 {
	if(type == 'temp')
		jQuery("#"+divname+id).remove();
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


