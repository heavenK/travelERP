
 var i=0;
 function insertItem(divname,type)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"itemlist_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"title_t"+i+"\" check='^\\S+$' warning=\"标题不能为空,且不能含有空格\" >";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"value_t"+i+"\" style=\"width:80px;\" check='^\\S+$' warning=\"金额不能为空,且不能含有空格\" >";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<select id=\"method_t"+i+"\">";
	htmlcontent += "<option value=\"现金\">现金</option>";
	htmlcontent += "<option value=\"网拨\">网拨</option>";
	htmlcontent += "<option value=\"银行卡\">银行卡</option>";
	htmlcontent += "<option value=\"汇款\">汇款</option>";
	htmlcontent += "<option value=\"转账\">转账</option>";
	htmlcontent += "<option value=\"支票\">支票</option>";
	htmlcontent += "<option value=\"签单\">签单</option>";
	htmlcontent += "<option value=\"对冲\">对冲</option>";
	htmlcontent += "</select>";
	htmlcontent += "</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"remark_t"+i+"\" >";
	htmlcontent += "</td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+i+",'itemlist_t','temp');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "</tr>";
	jQuery("#"+divname).append(htmlcontent);
 }

 function save(id,divname,mark,type)
 {
	var it = '';
	if(!mark){
		it ="&chanpinID="+id;
		mark = '';
	}
	if(!divname){
		divname = '';
	}
	var title = jQuery("#title"+mark+id).val();
	var value = parseInt(jQuery("#value"+mark+id).val());
	var method = jQuery("#method"+mark+id).val();
	var remark = jQuery("#remark"+mark+id).val();
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/dopost_baozhangitem",
		data:	"type="+type+"&title="+title+"&method="+method+"&remark="+remark+"&value="+value+"&parentID="+parentID+it,
		success:function(msg){
			scroll(0,0);
			ThinkAjax.myAjaxResponse(msg,'resultdiv',om_save,id,divname);
		}
	});
	
 }
 
 function om_save(data,status,info,type,id,divname)
 {
	if(status == 1){
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+data['chanpinID']+"\">";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"title"+data['chanpinID']+"\" value=\""+data['title']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"value"+data['chanpinID']+"\" style=\"width:80px;\" value=\""+data['value']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<select id=\"method"+data['chanpinID']+"\">";
		htmlcontent += "<option value=\""+data['method']+"\">"+data['method']+"</option>";
		htmlcontent += "<option disabled=\"disabled\">--------</option>";
		htmlcontent += "<option value=\"现金\">现金</option>";
		htmlcontent += "<option value=\"网拨\">网拨</option>";
		htmlcontent += "<option value=\"银行卡\">银行卡</option>";
		htmlcontent += "<option value=\"汇款\">汇款</option>";
		htmlcontent += "<option value=\"转账\">转账</option>";
		htmlcontent += "<option value=\"支票\">支票</option>";
		htmlcontent += "<option value=\"签单\">签单</option>";
		htmlcontent += "<option value=\"对冲\">对冲</option>";
		htmlcontent += "</select>";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"remark"+data['chanpinID']+"\" value=\""+data['remark']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+data['chanpinID']+",'"+divname+"',);\" />";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"修改\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+data['chanpinID']+");\" />";
		if(data['type'] != '利润')
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"申请审核\" onclick=\"doshenhe_baozhangitem('申请','报账项',"+data['chanpinID']+",'"+data['title']+"');\"/>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"checkbox\" onclick=\"javascript:dosetprint(this,"+data['chanpinID']+")\"/></td>";
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
		url:	SITE_INDEX+"Chanpin/deleteBaozhangitem",
		data:	"chanpinID="+id,
		success:function(msg){
			ThinkAjax.myAjaxResponse(msg,'resultdiv',del_after,divname+id);
		}
	});
	
 }

 function del_after(data,status,info,type,id)
 {
	if(status == 1){
		jQuery("#"+id).remove();
	}
 }


