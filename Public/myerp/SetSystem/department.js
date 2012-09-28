
 var i=0;
 function insertItem(divname)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+"_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<form id='form_t"+i+"' ><input type=\"text\" id=\"title_t"+i+"\" check='^\\S+$' warning=\"标题不能为空,且不能含有空格\" ></form>";
	htmlcontent += "</td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
    htmlcontent += "<input type=\"checkbox\" name=\"type[]\" value=\"组团\" class=\"type_t"+i+"\"/>组团";
    htmlcontent += "<input type=\"checkbox\" name=\"type[]\" value=\"地接\" class=\"type_t"+i+"\"/>地接";
    htmlcontent += "<input type=\"checkbox\" name=\"type[]\" value=\"销售（直营）\" class=\"type_t"+i+"\"/>销售（直营）";
    htmlcontent += "<input type=\"checkbox\" name=\"type[]\" value=\"销售（加盟）\" class=\"type_t"+i+"\"/>销售（加盟）";
    htmlcontent += "<input type=\"checkbox\" name=\"type[]\" value=\"办事处\" class=\"type_t"+i+"\"/>办事处";
    htmlcontent += "<input type=\"checkbox\" name=\"type[]\" value=\"联合体\" class=\"type_t"+i+"\"/>联合体";
    htmlcontent += "<input type=\"checkbox\" name=\"type[]\" value=\"行政\" class=\"type_t"+i+"\"/>行政";
	htmlcontent += "</td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"lianxiren_t"+i+"\" style=\"width:80px\" ></td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"officetel_t"+i+"\" style=\"width:80px\" ></td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"postal_t"+i+"\" style=\"width:80px\" ></td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"addr_t"+i+"\" ></td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"fax_t"+i+"\" style=\"width:80px\" ></td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"email_t"+i+"\" style=\"width:100px\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+i+",'"+divname+"_t','temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onClick=\"if(CheckForm('form_t"+i+"','resultdiv_2'))save("+i+",'"+divname+"_t','_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#"+divname+"_box").append(htmlcontent);
	
 }

 function save(id,divname,mark)
 {
	 scroll(0,0);
	var it = '';
	if(!mark){
		it ="&systemID="+id;
		mark = '';
	}
	if(!divname){
		divname = '';
	}
	var title = jQuery("#title"+mark+id).val();
	var lianxiren = jQuery("#lianxiren"+mark+id).val();
	var officetel = jQuery("#officetel"+mark+id).val();
	var postal = jQuery("#postal"+mark+id).val();
	var addr = jQuery("#addr"+mark+id).val();
	var fax = jQuery("#fax"+mark+id).val();
	var type = new Array();
	var i = 0;
	jQuery(".type"+mark+id).each(function(index, element) {
		if(jQuery(this).attr("checked")){
			type[i] = jQuery(this).attr('value');
			i++;
		}
    });
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/dopostSystemHas/tableName/department",
		data:	"title="+title+"&lianxiren="+lianxiren+"&officetel="+officetel+"&postal="+postal+"&addr="+addr+"&fax="+fax+"&type="+type+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',om_save,id,divname);
		}
	});
	
 }
 
 function om_save(data,status,info,type,id,divname)
 {
	if(status == 1){
		location.reload();
//		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+data['systemID']+"\">";
//		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
//		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
//		htmlcontent += "<form id='form"+data['systemID']+"' ><input type=\"text\" id=\"title"+data['systemID']+"\" style=\"width:200px;\" value=\""+data['title']+"\"></form>";
//		htmlcontent += "</td>";
//		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"lianxiren"+data['systemID']+"\" style=\"width:200px\"  value=\""+data['lianxiren']+"\"></td>";
//		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"officetel"+data['systemID']+"\" style=\"width:80px\"  value=\""+data['officetel']+"\"></td>";
//		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"postal"+data['systemID']+"\" style=\"width:80px\"  value=\""+data['postal']+"\"></td>";
//		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"addr"+data['systemID']+"\" style=\"width:200px\"  value=\""+data['addr']+"\"></td>";
//		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"fax"+data['systemID']+"\" style=\"width:80px\"  value=\""+data['fax']+"\"></td>";
//		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"email"+data['systemID']+"\" style=\"width:100px\"  value=\""+data['email']+"\"></td>";
//		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
//		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+data['systemID']+",'"+divname+"',);\" />";
//		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onClick=\"if(CheckForm('form"+data['systemID']+"','resultdiv_2'))save("+data['systemID']+");\" />";
//		htmlcontent += "</tr>";
//		jQuery("#"+divname+id).replaceWith(htmlcontent);
	}
 }

 function deleteSystemItem(id,divname,type)
 {
	 scroll(0,0);
	if(type == 'temp')
		jQuery("#"+divname+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/deleteSystemItem/tableName/department",
		data:	"systemID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',del_after,divname+id);
		}
	});
	
 }

 function del_after(data,status,info,type,id)
 {
	if(status == 1){
//		jQuery("#"+id).remove();
	}
 }


