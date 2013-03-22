
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
	htmlcontent += "<option value=\"月结\">月结</option>";
	htmlcontent += "</select>";
	htmlcontent += "</td>";
	if(type != '利润'){
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"renshu_t"+i+"\" style=\"width:80px;\" check='^\\S+$' warning=\"人数不能为空,且不能含有空格\" value=\"0\" >";
		htmlcontent += "</td>";
	}
	else{
		htmlcontent += "<input type=\"hidden\" id=\"expand_t"+i+"\">";
	}
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"remark_t"+i+"\" >";
	htmlcontent += "</td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+i+",'itemlist_t','temp');\" />";
	if(type != '利润'){
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" id=\"btsave_"+i+"\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
	}
	else{
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" id=\"btsave_"+i+"\" onClick=\"if(checktitle("+i+",'_t'))if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
	}
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "</tr>";
	jQuery("#"+divname).append(htmlcontent);
	if(type == '利润'){
		myautocomplete("#title_t"+i,'部门');
	}
 }

 function save(id,divname,mark,type)
 {
	scroll(0,0);
	ThinkAjax.myloading('resultdiv');
	act = jQuery("#btsave_"+id).attr("onclick"); 
	jQuery("#btsave_"+id).attr("onclick","alert('正在执行请稍候...')"); 
	var it = '';
	if(!mark){
		it ="&chanpinID="+id;
		mark = '';
	}
	if(!divname){
		divname = '';
	}
	var title = jQuery("#title"+mark+id).val();
	var value = jQuery("#value"+mark+id).val();
	var method = jQuery("#method"+mark+id).val();
	var renshu = jQuery("#renshu"+mark+id).val();
	var remark = jQuery("#remark"+mark+id).val();
	var expand = jQuery("#expand"+mark+id).val();
	if(expand)
		it +="&expand="+expand
	title = FixJqText(title);
	remark = FixJqText(remark);
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+"Chanpin/dopost_baozhangitem",
		data:	"type="+type+"&title="+title+"&method="+method+"&remark="+remark+"&value="+value+"&renshu="+renshu+"&parentID="+parentID+it,
		success:function(msg){
			scroll(0,0);
			jQuery("#btsave_"+id).attr("onclick","alert("+act+")"); 
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
		htmlcontent += "<input type=\"text\" id=\"title"+data['chanpinID']+"\" value=\""+data['title']+"\" check='^\\S+$' warning=\"标题不能为空,且不能含有空格\" >";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"value"+data['chanpinID']+"\" style=\"width:80px;\" value=\""+data['value']+"\" check='^\\S+$' warning=\"金额不能为空,且不能含有空格\" >";
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
		htmlcontent += "<option value=\"月结\">月结</option>";
		htmlcontent += "</select>";
		htmlcontent += "</td>";
		if(data['type'] != '利润'){
			htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
			htmlcontent += "<input type=\"text\" id=\"renshu"+i+"\" style=\"width:80px;\" check='^\\S+$' warning=\"人数不能为空,且不能含有空格\" value=\""+data['renshu']+"\">";
			htmlcontent += "</td>";
		}
		else{
			htmlcontent += "<input type=\"hidden\" id=\"expand"+i+"\">";
		}
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"remark"+data['chanpinID']+"\" value=\""+data['remark']+"\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+data['chanpinID']+",'"+divname+"',);\" />";
		if(data['type'] != '利润'){
			htmlcontent += "<input class=\"button\" type=\"button\" id=\"btsave_"+data['chanpinID']+"\" value=\"修改\" onClick=\"if(checktitle("+data['chanpinID']+"))if(CheckForm('form_yingshou','resultdiv_2'))save("+data['chanpinID']+");\" />";
		}
		else{
			htmlcontent += "<input class=\"button\" type=\"button\" id=\"btsave_"+data['chanpinID']+"\" value=\"修改\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+data['chanpinID']+");\" />";
		}
//		if(data['type'] != '利润')
//		htmlcontent += "<input class=\"button\" type=\"button\" id=\"btshenhe_"+data['chanpinID']+"\" value=\"申请审核\" onclick=\"doshenhe_baozhangitem('申请','报账项',"+data['chanpinID']+",'"+data['title']+"');\"/>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"checkbox\" onclick=\"javascript:dosetprint(this,"+data['chanpinID']+")\"/></td>";
		htmlcontent += "</tr>";
		jQuery("#"+divname+id).replaceWith(htmlcontent);
		if(data['type'] == '利润'){
			myautocomplete("#title"+data['chanpinID'],'部门');
		}
	}
 }

 function deleteSystemItem(id,divname,type)
 {
	scroll(0,0);
	ThinkAjax.myloading('resultdiv');
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
	var title = document.getElementById("title"+mark+id).value;
	var ishas = 0;
	for (var i=0;i<datas.length;i++) { 
		if(title == datas[i]['title']){
			systemID = datas[i]['systemID'];
			ishas = 1;
			break;
		}
	} 
	if(!ishas){
		jQuery("#title"+id).val('');
		jQuery("#expand"+id).val('');
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+title+',不存在,请重新选择！！</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
			return false;
	}
	else{
		jQuery("#expand"+mark+id).val(systemID);
		return true;
	}
}






