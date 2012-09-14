
 var i=0;
 function insertItem()
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"durlist_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"bumen_t"+i+"\" style=\"width:200px;\" >";
	htmlcontent += "<input type=\"hidden\" id=\"bumenID_t"+i+"\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"roles_t"+i+"\" style=\"width:200px;\" >";
	htmlcontent += "<input type=\"hidden\" id=\"rolesID_t"+i+"\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"delUserDUR("+i+",'temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onClick=\"if(checktitle("+i+",'部门','bumen','_t') && checktitle("+i+",'角色','roles','_t'))save("+i+",'_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#itemlist_box").append(htmlcontent);
	
	myautocomplete("#bumen_t"+i,'部门');
	myautocomplete("#roles_t"+i,'角色');
	
 }


 function myautocomplete(target,parenttype)
{
		if(parenttype == '部门')
		datas = department;
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


function checktitle(id,parenttype,inputid,mark){
	if(!mark){
		mark = '';
	}
	if(parenttype == '部门')
		datas = department;
	else if(parenttype == '角色')
		datas = roles;
	else{
		jQuery("#"+inputid+mark+id).val('');
		jQuery("#"+inputid+"ID"+mark+id).val('');
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">请删除空白项，重新添加！！</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
		return false;
	}
	var title = jQuery("#"+inputid+mark+id).val();
	var ishas = 0;
	for (var i=0;i<datas.length;i++) { 
		if(title == datas[i]['title']){
			systemID = datas[i]['systemID'];
			ishas = 1;
			break;
		}
	} 
	if(!ishas){
		jQuery("#"+inputid+mark+id).val('');
		jQuery("#"+inputid+"ID"+mark+id).val('');
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+parenttype+title+',不存在,请重新选择！！</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
		return false;
	}
	else{
		jQuery("#"+inputid+"ID"+mark+id).val(systemID);
		return true;
	}
}

 function save(id,mark)
 {
	var it = '';
	if(!mark){
		it ="&systemID="+id;
		mark = '';
	}
	var bumen = jQuery("#bumen"+mark+id).val();
	var bumenID = jQuery("#bumenID"+mark+id).val();
	var roles = jQuery("#roles"+mark+id).val();
	var rolesID = jQuery("#rolesID"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/dopostUserDUR",
		data:	"bumenID="+bumenID+"&rolesID="+rolesID+"&bumen="+bumen+"&roles="+roles+"&userID="+userID+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',om_save,id);
		}
	});
	
 }
 
 function om_save(data,status,info,type,id)
 {
	if(status == 1){
		
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"durlist"+data['systemID']+"\">";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"bumen"+data['systemID']+"\" style=\"width:200px;\" value=\""+data['bumen']+"\">";
		htmlcontent += "<input type=\"hidden\" id=\"bumenID"+data['systemID']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"roles"+data['systemID']+"\" style=\"width:200px;\" value=\""+data['roles']+"\">";
		htmlcontent += "<input type=\"hidden\" id=\"rolesID"+data['systemID']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"delUserDUR("+data['systemID']+");\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onClick=\"if(checktitle("+data['systemID']+",'部门','bumen') && checktitle("+data['systemID']+",'角色','roles'))save("+data['systemID']+");\" /></td>";
		htmlcontent += "</tr>";
		
		jQuery("#durlist_t"+id).replaceWith(htmlcontent);
		
		myautocomplete("#bumen"+data['systemID'],'部门');
		myautocomplete("#roles"+data['systemID'],'角色');
	}
 }

 function delUserDUR(id,type)
 {
	if(type == 'temp')
		jQuery("#durlist_t"+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"SetSystem/deleteSystemItem/tableName/systemDUR",
		data:	"systemID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',userDUR_del,id);
		}
	});
	
 }

 function userDUR_del(data,status,info,type,id)
 {
	if(status == 1){
		jQuery("#durlist"+id).remove();
	}
 }
