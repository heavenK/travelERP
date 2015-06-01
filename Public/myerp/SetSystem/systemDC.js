
 var i=0;
 function insertdepartment(type)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"departmentrow_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"_t"+i+"\" style=\"width:200px;\" >";
	htmlcontent += "<input type=\"hidden\" id=\"dataID_t"+i+"\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteDepartemntDC("+i+",'temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onClick=\"if(checktitle("+i+",'_t'))addSystemDC("+i+",'_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#itemlist_box").append(htmlcontent);
	if(type != '往来') type == '部门';
	myautocomplete("#_t"+i,type);
	
 }

 function addSystemDC(id,mark)
 {
	scroll(0,0);
	ThinkAjax.myloading('resultdiv');
	act = jQuery("#btsave_"+id).attr("onclick"); 
	jQuery("#btsave_"+id).attr("onclick","alert('正在执行请稍候...')"); 
	 
	var it = '';
	if(!mark){
		it ="&systemID="+id;
		mark = '';
	}
	var title = jQuery("#"+mark+id).val();
	var dataID = jQuery("#dataID"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/dopostDepartmentDC",
		data:	"parentID="+parentID+"&dataID="+dataID+"&typeName=DC"+"&title="+title+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',dp_save,id);
		}
	});
	
 }


 function dp_save(data,status,info,type,id)
 {
	if(status == 1){
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"departmentrow"+data['systemID']+"\">";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\""+data['systemID']+"\" style=\"width:200px;\" value=\""+data['title']+"\">";
		htmlcontent += "<input type=\"hidden\" id=\"dataID"+data['systemID']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteDepartemntDC("+data['systemID']+");\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onClick=\"if(checktitle("+data['systemID']+"))addSystemDC("+data['systemID']+");\" /></td>";
		htmlcontent += "</tr>";
		jQuery("#departmentrow_t"+id).replaceWith(htmlcontent);
		myautocomplete("#"+data['systemID'],'部门');
	}
 }
 
 
 
 
 function deleteDepartemntDC(id,type)
 {
	if(type == 'temp')
		jQuery("#departmentrow_t"+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/deleteDepartemntDC",
		data:	"systemID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',departmentDC_del,id);
		}
	});
	
 }
 
 function departmentDC_del(data,status,info,type,id)
 {
	if(status == 1){
		jQuery("#departmentrow"+id).remove();
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
		
		if(parenttype == '往来')
		datas = wanglai;
	
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



function checktitle(id,mark){
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
		jQuery("#dataID"+mark+id).val('');
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+title+',不存在,请重新选择！！</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
			return false;
	}
	else{
		jQuery("#dataID"+mark+id).val(systemID);
		return true;
	}
}

function save(){
	ThinkAjax.sendForm('form','<{:SITE_INDEX}>SetSystem/dopostCategory/',doComplete,'resultdiv');
}

function doComplete(data,status){
	if(status == 1){
			window.location.href='<{:SITE_INDEX}>SetSystem/category';
	}
}











