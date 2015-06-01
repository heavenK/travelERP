
 var i=0;
 function insertItem(divname)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+"_t"+i+"\"><form id='form_t"+i+"' >";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"title_t"+i+"\" style=\"width:200px;\" check='^\\S+$' warning=\"标题不能为空,且不能含有空格\" >";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"parentID_t"+i+"\" style=\"width:200px;\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select id=\"type_t"+i+"\" style=\"width:100px\"><option value=\"部门\">部门</option><option value=\"往来\">往来</option></select>";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+i+",'"+divname+"_t','temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onClick=\"if(CheckForm('form_t"+i+"','resultdiv_2'))save("+i+",'"+divname+"_t','_t');\" /></td>";
	htmlcontent += "</form></tr>";
	jQuery("#"+divname+"_box").append(htmlcontent);
	myautocomplete("#parentID_t"+i,'部门');
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
	var parentID = jQuery("#parentID"+mark+id).val();
	var categorytype = jQuery("#type"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/dopostSystemHas/tableName/category",
		data:	"title="+title+"&type="+categorytype+"&parentID="+parentID+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',om_save,id,divname);
		}
	});
	
 }
 
 function om_save(data,status,info,type,id,divname)
 {
	if(status == 1){
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+data['systemID']+"\"><form id='form"+data['systemID']+"' >";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"title"+data['systemID']+"\" style=\"width:200px;\" value=\""+data['title']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"parentID"+data['systemID']+"\" style=\"width:200px;\" value=\""+data['parentID']+"\"></form></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">"+data['type'];
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+data['systemID']+",'"+divname+"',);\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onClick=\"if(CheckForm('form"+data['systemID']+"','resultdiv_2'))save("+data['systemID']+");\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"项目管理\" onClick=\"addSystemDC("+data['systemID']+")\" />";
		htmlcontent += "</form></tr>";
		jQuery("#"+divname+id).replaceWith(htmlcontent);
		myautocomplete("#parentID"+data['systemID'],'部门');
	}
 }

 function deleteSystemItem(id,divname,type)
 {
	if(type == 'temp')
		jQuery("#"+divname+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/deleteSystemItem/tableName/departmentDC",
		data:	"systemID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',del_after,divname+id);
		}
	});
	
 }

 function lockSystemItem(id,divname,type,islock)
 {
	if(type == 'temp')
		jQuery("#"+divname+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/lcokSystemItem/tableName/departmentDC/islock/"+islock,
		data:	"systemID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv');
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



 function myautocomplete(target,parenttype)
{
		if(parenttype == '部门')
		datas = department;
	
		jQuery(target).unautocomplete().autocomplete(datas, {
		   max: 50,    //列表里的条目数
		   minChars: 0,    //自动完成激活之前填入的最小字符
		   width: 150,     //提示的宽度，溢出隐藏
		   scroll:false,
		   matchContains: true,    //包含匹配，就是data参数里的数据，是否只要包含文本框里的数据就显示
		   autoFill: true,    //自动填充
		   formatItem: function(data, i, num) {//多选显示
			   return data.systemID+'|'+data.title;
		   },
		   formatMatch: function(data, i, num) {//匹配格式
			   return data.title;
		   },
		   formatResult: function(data) {//选定显示
			   return data.systemID;
		   }
		})
}








