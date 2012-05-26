
 var i=0;
 function insertchengben()
 {
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"chengbenrow_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select id=\"typeName_t"+i+"\" >";
	for ( var b=0;b<chengbentypelist.length; b++)
	htmlcontent += "<option value=\""+chengbentypelist[b]+"\">"+chengbentypelist[b]+"</option>";
	htmlcontent += "</select></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" id=\"title_t"+i+"\" ></td>";
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
	i++;	 
 }

 function addchengben(id,mark)
 {
	var it = '';
	if(!mark){
		it ="&chengbenID="+id;
		mark = '';
	}
	var typeName = jQuery("#typeName"+mark+id).val();
	var title = jQuery("#title"+mark+id).val();
	var price = jQuery("#price"+mark+id).val();
	var jifeitype = jQuery("#jifeitype"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/dopostchengben",
		data:	"typeName="+typeName+"&title="+title+"&price="+price+"&jifeitype="+jifeitype+"&chanpinID="+chanpinID+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',chengben_save,id);
		}
	});
	
 }


 function chengben_save(data,status,info,type,id)
 {
	if(status == 1){
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"chengbenrow"+data['chengbenID']+"\">";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select name=\"typeName\" id=\"typeName"+data['chengbenID']+"\">";
		htmlcontent += "<option value=\""+data['typeName']+"\">"+data['typeName']+"</option>";
		htmlcontent += "<option disabled>-------</option>";
		for ( var b=0;b<chengbentypelist.length; b++)
		htmlcontent += "<option value=\""+chengbentypelist[b]+"\">"+chengbentypelist[b]+"</option>";
		htmlcontent += "</select></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"title\" id=\"title"+data['chengbenID']+"\" value=\""+data['title']+"\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"price\" id=\"price"+data['chengbenID']+"\" value=\""+data['price']+"\"></td>";
		
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select name=\"jifeitype\" id=\"jifeitype"+data['chengbenID']+"\">";
		htmlcontent += "<option value=\""+data['jifeitype']+"\">"+data['jifeitype']+"</option>";
		htmlcontent += "<option disabled>-------</option>";
		htmlcontent += "<option value=\"全部\">全部</option>";
		htmlcontent += "<option value=\"成人\">成人</option>";
		htmlcontent += "<option value=\"儿童\">儿童</option>";
		htmlcontent += "</select></td>";
		
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onClick=\"deletechengben("+data['chengbenID']+")\" />"
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onclick=\"addchengben("+data['chengbenID']+")\" /></td>";
		htmlcontent += "</tr>";
		jQuery("#chengbenrow_t"+id).replaceWith(htmlcontent);
	}
 }
 
 
 
 
 function deletechengben(id,type)
 {
	if(type == 'temp')
		jQuery("#chengbenrow_t"+id).remove();
	else	
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/deletechengben",
		data:	"chengbenID="+id,
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
 
 
 
 function insertshoujia()
 {
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"shoujiarow_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select>";
	htmlcontent += "<option>代理商级别</option>";
	htmlcontent += "</select></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><select>";
	htmlcontent += "<option>代理商</option>";
	htmlcontent += "</select></td>";
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
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteshoujia("+i+",'temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onclick=\"addshoujia("+i+",'_t');\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#shoujia").append(htmlcontent);
	i++;	 
 }

 function addshoujia(id,mark)
 {
	var it = '';
	if(!mark){
		it ="&chanpinID="+id;
		mark = '';
	}
	var type = jQuery("#type"+mark+id).val();
	var adultprice = jQuery("#adultprice"+mark+id).val();
	var childprice = jQuery("#childprice"+mark+id).val();
	var chengben = jQuery("#chengben"+mark+id).val();
	var cut = jQuery("#cut"+mark+id).val();
	var renshu = jQuery("#renshu"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/dopostshoujia",
		data:	"type="+type+"&adultprice="+adultprice+"&childprice="+childprice+"&chengben="+chengben+"&cut="+cut+"&renshu="+renshu+"&parentID="+parentID+it,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',shoujia_save,id);
		}
	});
	
 }
 
 function shoujia_save(data,status,info,type,id)
 {
	 
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
 

