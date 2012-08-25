
 var i=0;
 function insertItem(parenttype)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"itemrow_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"_t"+i+"\" style=\"width:200px;\" >";
	htmlcontent += "<input type=\"hidden\" id=\"parentID_t"+i+"\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">"+parenttype;
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select id=\"processID_t"+i+"\" style=\"width:100px;\" >";
	htmlcontent += "<option value=\"1\">1</option>";
	htmlcontent += "<option value=\"2\">2</option>";
	htmlcontent += "<option value=\"3\">3</option>";
	htmlcontent += "<option value=\"4\">4</option>";
	htmlcontent += "<option value=\"5\">5</option>";
	htmlcontent += "</select></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<form id='form_t"+i+"' ><input type=\"text\" id=\"remark_t"+i+"\" style=\"width:200px;\" check='^\\S+$' warning=\"描述不能为空,且不能含有空格\" ></form>";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteItem("+i+",'temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onClick=\"if(CheckForm('form_t"+i+"','resultdiv_2') && checktitle("+i+",'"+parenttype+"','_t'))additem("+i+",'"+parenttype+"','_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#itemlist_box").append(htmlcontent);
	
	myautocomplete("#_t"+i,parenttype);
	
 }
 
 function additem(id,parenttype,mark)
 {
	var it = '';
	if(!mark){
		it ="&systemID="+id;
		mark = '';
	}
	var title = jQuery("#"+mark+id).val();
	var parentID = jQuery("#parentID"+mark+id).val();
	var processID = jQuery("#processID"+mark+id).val();
	var remark = jQuery("#remark"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/dopostShenhe",
		data:	"parentID="+parentID+"&title="+title+"&parenttype="+parenttype+"&datatype="+datatype+"&processID="+processID+"&remark="+remark+it,
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
		htmlcontent += "<input type=\"text\" id=\""+data['systemID']+"\" style=\"width:200px;\" value=\""+data['title']+"\">";
		htmlcontent += "<input type=\"hidden\" id=\"parentID"+data['systemID']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">"+data['parenttype'];
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select id=\"processID"+data['systemID']+"\" style=\"width:100px;\" >";
		htmlcontent += "<option value=\""+data['processID']+"\">"+data['processID']+"</option>";
		htmlcontent += "<option disabled=\"disabled\">-------------</option>";
		htmlcontent += "<option value=\"1\">1</option>";
		htmlcontent += "<option value=\"2\">2</option>";
		htmlcontent += "<option value=\"3\">3</option>";
		htmlcontent += "<option value=\"4\">4</option>";
		htmlcontent += "<option value=\"5\">5</option>";
		htmlcontent += "</select></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<form id='form_t"+i+"' ><input type=\"text\" id=\"remark"+data['systemID']+"\" style=\"width:200px;\" value=\""+data['remark']+"\" check='^\\S+$' warning=\"描述不能为空,且不能含有空格\" ></form>";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteItem("+data['systemID']+");\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onClick=\"if(CheckForm('form_t"+i+"','resultdiv_2') && checktitle("+data['systemID']+",'"+data['parenttype']+"'))additem("+data['systemID']+",'"+data['parenttype']+"');\" /></td>";
		htmlcontent += "</tr>";
		jQuery("#itemrow_t"+id).replaceWith(htmlcontent);
		
		myautocomplete("#"+data['systemID'],data['parenttype']);
	}
 }
 
 function deleteItem(id,type)
 {
	if(type == 'temp')
		jQuery("#itemrow_t"+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/deleteShenheItem",
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
			   return data.title;
		   }
		})
}



function checktitle(id,parenttype,mark){
	
	if(parenttype == '分类')
		datas = category;
	else if(parenttype == '部门')
		datas = department;
	else if(parenttype == '用户')
		datas = user;
	else if(parenttype == '角色')
		datas = roles;
	else{
		jQuery("#"+id).val('');
		jQuery("#parentID"+mark+id).val('');
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">请删除空白项，重新添加！！</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
		return false;
	}
	if(!mark)
		mark = '';
	var title = document.getElementById(mark+id).value;
	var ishas = 0;
	for (var i=0;i<datas.length;i++) { 
		if(title == datas[i]['title']){
			systemID = datas[i]['systemID'];
			ishas = 1;
			break;
		}
	} 
	if(!ishas){
		jQuery("#"+id).val('');
		jQuery("#parentID"+mark+id).val('');
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">对象,'+title+',不存在,请重新选择！！</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
		return false;
	}
	else{
		jQuery("#parentID"+mark+id).val(systemID);
		return true;
	}
}


