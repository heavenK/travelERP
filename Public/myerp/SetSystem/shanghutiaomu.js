
 var i=0;
 function insertItem()
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"itemrow_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<form id='form_t"+i+"' ><input type=\"text\" id=\"title_t"+i+"\" style=\"width:200px;\" check='^\\S+$' warning=\"标题不能为空,且不能含有空格\" >";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"companyID_t"+i+"\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"remark_t"+i+"\" style=\"width:200px;\" >";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteItem("+i+",'temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onClick=\"if(CheckForm('form_t"+i+"','resultdiv_2'))additem("+i+",'_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#itemlist_box").append(htmlcontent);
	
	myautocomplete("#companyID_t"+i,'部门');
 }
 
 function additem(id,mark)
 {
	scroll(0,0);
	ThinkAjax.myloading('resultdiv');
	var it = '';
	if(!mark){
		it ="&systemID="+id;
		mark = '';
	}
	var title = jQuery("#title"+mark+id).val();
	var remark = jQuery("#remark"+mark+id).val();
	var companyID = jQuery("#companyID"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/dopostSystemHas/tableName/datadictionary",
		data:	"type=商户条目&title="+title+"&remark="+remark+"&companyID="+companyID+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',om_save,id);
		}
	});
 }
 
 function om_save(data,status,info,type,id)
 {
	if(status == 1){
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"itemrow"+data['systemID']+"\">";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<form id='form_t"+i+"' ><input type=\"text\" id=\"title"+data['systemID']+"\" style=\"width:200px;\" value=\""+data['title']+"\"></form>";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"companyID"+data['systemID']+"\" value=\""+data['companyID']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"remark"+data['systemID']+"\" style=\"width:200px;\" value=\""+data['remark']+"\" >";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteItem("+data['systemID']+");\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onClick=\"if(CheckForm('form_t"+i+"','resultdiv_2') )additem("+data['systemID']+");\" /></td>";
		htmlcontent += "</tr>";
		jQuery("#itemrow_t"+id).replaceWith(htmlcontent);
		myautocomplete("#companyID"+data['systemID'],'部门');
	}
 }
 
 function deleteItem(id,type)
 {
	scroll(0,0);
	ThinkAjax.myloading('resultdiv');
	if(type == 'temp')
		jQuery("#itemrow_t"+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/deleteSystemItem/tableName/datadictionary",
		data:	"systemID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',item_del,id);
		}
	});
 }
 
 function item_del(data,status,info,type,id)
 {
	if(status == 1){
		jQuery("#itemrow"+id).remove();
	}
 }
 

 function myautocomplete(target,parenttype)
{
		if(parenttype == '分类')
		datas = category;
		if(parenttype == '部门')
		datas = department;
		if(parenttype == '用户')
		datas = user;
		if(parenttype == '角色')
		datas = roles;
	
		jQuery(target).unautocomplete().autocomplete(datas, {
		   max: 50,    //列表里的条目数
		   minChars: 0,    //自动完成激活之前填入的最小字符
		   width: 150,     //提示的宽度，溢出隐藏
		   scroll:false,
		   matchContains: true,    //包含匹配，就是data参数里的数据，是否只要包含文本框里的数据就显示
		   autoFill: true,    //自动填充
		   formatItem: function(data, i, num) {//多选显示
			   return data.title;
		   },
		   formatMatch: function(data, i, num) {//匹配格式
			   return data.title;
		   },
		   formatResult: function(data) {//选定显示
			   if(parenttype == '部门')
			   return data.systemID;
			   else
			   return data.title;
		   }
		})
}



