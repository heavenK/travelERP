
 var i=0;
 function insertchengben()
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"chengbenrow_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select id=\"title_t"+i+"\" >";
	for ( var b=0;b<chengbentypelist.length; b++)
	htmlcontent += "<option value=\""+chengbentypelist[b]+"\">"+chengbentypelist[b]+"</option>";
	htmlcontent += "</select></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"remark_t"+i+"\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"price_t"+i+"\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select id=\"jifeitype_t"+i+"\">";
	htmlcontent += "<option value=\"全部\">全部</option>";
	htmlcontent += "<option value=\"成人\">成人</option>";
	htmlcontent += "<option value=\"儿童\">儿童</option>";
	htmlcontent += "</select></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deletechengben("+i+",'temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onclick=\"addchengben("+i+",'_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#chengben").append(htmlcontent);
 }

 function addchengben(id,mark)
 {
	var it = '';
	if(!mark){
		it ="&chanpinID="+id;
		mark = '';
	}
	var title = jQuery("#title"+mark+id).val();
	var remark = jQuery("#remark"+mark+id).val();
	var price = jQuery("#price"+mark+id).val();
	var jifeitype = jQuery("#jifeitype"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/dopostchengben",
		data:	"title="+title+"&remark="+remark+"&price="+price+"&jifeitype="+jifeitype+"&parentID="+chanpinID+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',chengben_save,id);
		}
	});
	
 }


 function chengben_save(data,status,info,type,id)
 {
	if(status == 1){
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"chengbenrow"+data['chanpinID']+"\">";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select id=\"title"+data['chanpinID']+"\">";
		htmlcontent += "<option value=\""+data['title']+"\">"+data['title']+"</option>";
		htmlcontent += "<option disabled>-------</option>";
		for ( var b=0;b<chengbentypelist.length; b++)
		htmlcontent += "<option value=\""+chengbentypelist[b]+"\">"+chengbentypelist[b]+"</option>";
		htmlcontent += "</select></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"remark"+data['chanpinID']+"\" value=\""+data['remark']+"\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"price\" class=\"jisuanchengben\" id=\"price"+data['chanpinID']+"\" value=\""+data['price']+"\"></td>";
		
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select name=\"jifeitype\" id=\"jifeitype"+data['chanpinID']+"\">";
		htmlcontent += "<option value=\""+data['jifeitype']+"\">"+data['jifeitype']+"</option>";
		htmlcontent += "<option disabled>-------</option>";
		htmlcontent += "<option value=\"全部\">全部</option>";
		htmlcontent += "<option value=\"成人\">成人</option>";
		htmlcontent += "<option value=\"儿童\">儿童</option>";
		htmlcontent += "</select></td>";
		
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onClick=\"deletechengben("+data['chanpinID']+")\" />"
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onclick=\"addchengben("+data['chanpinID']+")\" /></td>";
		htmlcontent += "</tr>";
		jQuery("#chengbenrow_t"+id).replaceWith(htmlcontent);
		var t =jisuanchengben();
		var str = '成人总成本：'+t['chengren']+',儿童总成本：'+t['ertong'];
		jQuery("#chengbenjisuan").html(str); 
		
	}
 }
 
 function jisuanchengben()
 {
	 var t = Array();
	 var jifeitype;
	 var chengren = 0;
	 var ertong = 0;
	jQuery(".jisuanchengben").each(function(){ 
		jifeitype = jQuery("#jifeitype"+this.value).val();
		price = jQuery("#price"+this.value).val();
		if(jifeitype == '成人')
			chengren += parseInt(price);
		else if(jifeitype == '儿童')
			ertong += parseInt(price);
		else if(jifeitype == '全部'){
			chengren += parseInt(price);
			ertong += parseInt(price);
		}
	});  
	t['chengren'] = chengren;
	t['ertong'] = ertong;
	return t;
}
 
 
 function deletechengben(id,type)
 {
	if(type == 'temp')
		jQuery("#chengbenrow_t"+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/deletechengben",
		data:	"chanpinID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',chengben_del,id);
		}
	});
	
 }
 
 function chengben_del(data,status,info,type,id)
 {
	if(status == 1){
		jQuery("#chengbenrow"+id).remove();
	}
 }
 
 
 
 function insertshoujia(opentype)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"shoujiarow_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"_t"+i+"\" style=\"width:80px;\" >";
	htmlcontent += "<input type=\"hidden\" id=\"openID_t"+i+"\">";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">"+opentype;
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select id=\"type_t"+i+"\">";
	htmlcontent += "<option value=\"标准\">标准</option>";
	htmlcontent += "<option value=\"酒店机票\">酒店机票</option>";
	htmlcontent += "</select></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"adultprice_t"+i+"\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"childprice_t"+i+"\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"chengben_t"+i+"\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"cut_t"+i+"\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"renshu_t"+i+"\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteshoujia("+i+",temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onclick=\"if(checktitle("+i+",'"+opentype+"','_t'))addshoujia("+i+",'"+opentype+"','_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#shoujia").append(htmlcontent);
	myautocomplete("#_t"+i,opentype);
 }

 function addshoujia(id,opentype,mark)
 {
	ThinkAjax.myloading('resultdiv');
	var it = '';
	if(!mark){
		it ="&chanpinID="+id;
		mark = '';
	}
	var title = jQuery("#"+mark+id).val();
	var openID = jQuery("#openID"+mark+id).val();
	var type = jQuery("#type"+mark+id).val();
	var adultprice = jQuery("#adultprice"+mark+id).val();
	var childprice = jQuery("#childprice"+mark+id).val();
	var chengben = jQuery("#chengben"+mark+id).val();
	var cut = jQuery("#cut"+mark+id).val();
	var renshu = jQuery("#renshu"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/dopostshoujia",
		data:	"type="+type+"&adultprice="+adultprice+"&title="+title+"&openID="+openID+"&opentype="+opentype+"&childprice="+childprice+"&chengben="+chengben+"&cut="+cut+"&renshu="+renshu+"&parentID="+parentID+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',shoujia_save,id);
		}
	});
	
 }
 
 function shoujia_save(data,status,info,type,id)
 {
	if(status == 1){
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"shoujiarow"+data['chanpinID']+"\">";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\""+data['chanpinID']+"\" style=\"width:80px;\" value=\""+data['title']+"\">";
		htmlcontent += "<input type=\"hidden\" id=\"openID"+data['chanpinID']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">"+data['opentype'];
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select id=\"type"+data['chanpinID']+"\">";
		htmlcontent += "<option value=\""+data['type']+"\">"+data['type']+"</option>";
		htmlcontent += "<option disabled>-------</option>";
		htmlcontent += "<option value=\"标准\">标准</option>";
		htmlcontent += "<option value=\"酒店机票\">酒店机票</option>";
		htmlcontent += "</select></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"adultprice"+data['chanpinID']+"\" value=\""+data['adultprice']+"\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"childprice"+data['chanpinID']+"\" value=\""+data['childprice']+"\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"chengben"+data['chanpinID']+"\" value=\""+data['chengben']+"\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"cut"+data['chanpinID']+"\" value=\""+data['cut']+"\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input style=\"width:80px;\" type=\"text\" id=\"renshu"+data['chanpinID']+"\" value=\""+data['renshu']+"\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteshoujia("+data['chanpinID']+");\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onclick=\"if(checktitle("+data['chanpinID']+",'"+data['opentype']+"'))addshoujia("+data['chanpinID']+",'"+data['opentype']+"');\" /></td>";
		htmlcontent += "</tr>";
		jQuery("#shoujiarow_t"+id).replaceWith(htmlcontent);
		myautocomplete("#"+data['chanpinID'],data['opentype']);
	}
 }

 function deleteshoujia(id,type)
 {
	if(type == 'temp')
		jQuery("#shoujiarow_t"+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/deleteshoujia",
		data:	"chanpinID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',shoujia_del,id);
		}
	});
	
 }
 
 function shoujia_del(data,status,info,type,id)
 {
	if(status == 1){
		jQuery("#shoujiarow"+id).remove();
	}
 }
 
 function myautocomplete(target,opentype)
{
		if(opentype == '分类')
		datas = category;
		if(opentype == '部门')
		datas = department;
		if(opentype == '用户')
		datas = user;
		if(opentype == '角色')
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



function checktitle(id,opentype,mark){
	
	if(opentype == '分类')
		datas = category;
	else if(opentype == '部门')
		datas = department;
	else if(opentype == '用户')
		datas = user;
	else if(opentype == '角色')
		datas = roles;
	else{
		jQuery("#"+id).val('');
		jQuery("#openID"+mark+id).val('');
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
		jQuery("#openID"+mark+id).val('');
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">开放对象,'+title+',不存在,请重新选择！！</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
		return false;
	}
	else{
		jQuery("#openID"+mark+id).val(systemID);
		return true;
	}
}













