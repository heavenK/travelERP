
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
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"roles_t"+i+"\" >";
	htmlcontent += "<input type=\"hidden\" id=\"roleslimitID_t"+i+"\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemOM("+i+",'temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onClick=\"if(checktitle("+i+",'"+parenttype+"','_t'))additemOM("+i+",'"+parenttype+"','_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#itemlist_box").append(htmlcontent);
	
	myautocomplete("#_t"+i,parenttype);
	myautocomplete("#roles_t"+i,'角色');
	
 }
 
 function additemOM(id,parenttype,mark)
 {
	var it = '';
	if(!mark){
		it ="&systemID="+id;
		mark = '';
	}
	var title = jQuery("#"+mark+id).val();
	var parentID = jQuery("#parentID"+mark+id).val();
	var rolestitle = jQuery("#roles"+mark+id).val();
	var roleslimitID = jQuery("#roleslimitID"+mark+id).val();
	var limit = '';
	if(roleslimitID){
		limit = "&rolestitle="+rolestitle+"&roleslimitID="+roleslimitID;
	}
	else
		limit = "&rolestitle="+"&roleslimitID=-1";
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/dopostSystemOM",
		data:	"parentID="+parentID+"&dataID="+dataID+"&title="+title+"&type="+method+"&parenttype="+parenttype+"&datatype="+datatype+limit+it,
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
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"roles"+data['systemID']+"\" value=\""+data['rolestitle']+"\">";
		htmlcontent += "<input type=\"hidden\" id=\"roleslimitID"+data['systemID']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemOM("+data['systemID']+");\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onClick=\"if(checktitle("+data['systemID']+",'"+data['parenttype']+"'))additemOM("+data['systemID']+",'"+data['parenttype']+"');\" /></td>";
		htmlcontent += "</tr>";
		jQuery("#itemrow_t"+id).replaceWith(htmlcontent);
		
		myautocomplete("#"+data['systemID'],data['parenttype']);
		myautocomplete("#roles"+data['systemID'],'角色');
	}
 }
 
 function deleteSystemOM(id,type)
 {
	if(type == 'temp')
		jQuery("#itemrow_t"+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/deleteSystemOM",
		data:	"systemID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',itemOM_del,id);
		}
	});
	
 }
 
 function itemOM_del(data,status,info,type,id)
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
	
	if(false === checkroles(id,mark)){
		return false;
	}
	
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
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">开放对象,'+title+',不存在,请重新选择！！</div>';
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


function checkroles(id,mark){
	if(!mark)
		mark = '';
	var title = document.getElementById("roles"+mark+id).value;
	if(title == '' || title == '无'){
		jQuery("#roleslimitID"+mark+id).val('');
		jQuery("#roles"+mark+id).val('');
		return true;
	}
	else
	{
		var ishas = 0;
		datas = roles;
		for (var i=0;i<datas.length;i++) { 
			if(title == datas[i]['title']){
				systemID = datas[i]['systemID'];
				ishas = 1;
				break;
			}
		} 
		if(!ishas){
			jQuery("#roleslimitID"+mark+id).val('');
			jQuery("#roles"+mark+id).val('');
			document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">限制角色,'+title+',不存在,请重新选择！！</div>';
			jQuery("#resultdiv_2").show("fast"); 
			this.intval = window.setTimeout(function (){
				document.getElementById('resultdiv_2').style.display='none';
				document.getElementById('resultdiv_2').innerHTML='';
				},3000);
			return false;
		}
		else{
			jQuery("#roleslimitID"+mark+id).val(systemID);
			return true;
		}
	}
}




