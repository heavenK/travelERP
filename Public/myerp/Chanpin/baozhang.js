
 var i=0;
 function insertItem(divname,type,other)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"itemlist_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"title_t"+i+"\" style=\"width:200px;\" check='^\\S+$' warning=\"标题不能为空,且不能含有空格\" >";
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
	htmlcontent += "<option value=\"VIP贵宾卡\">VIP贵宾卡</option>";
	htmlcontent += "<option value=\"抵值券\">抵值券</option>";
	htmlcontent += "</select>";
	htmlcontent += "</td>";
	if(type == '结算项目' || type == '已收项目' || type == '已付项目' || type == '预收项目' || type == '预付项目' || type == '支出项目'){
		var today = new Date();
		var t = today.getFullYear() + "-" + (today.getMonth() + 1) + '-' + today.getDate();
		
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"renshu_t"+i+"\" style=\"width:80px;\" check='^\\S+$' warning=\"人数不能为空,且不能含有空格\" value=\"0\" >";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"paytime_t"+i+"\" style=\"width:80px;\" value=\""+ t +"\"  onfocus=\"WdatePicker()\">";
		htmlcontent += "</td>";
		
		if(type == '支出项目'){
			htmlcontent += "<input type=\"hidden\" id=\"expandID_t"+i+"\">";
			htmlcontent += "<input type=\"hidden\" id=\"expandtype_t"+i+"\" value='商户条目'>";
		}
		
	}
	else{
		htmlcontent += "<input type=\"hidden\" id=\"expandID_t"+i+"\">";
		if(other == '部门')
			htmlcontent += "<input type=\"hidden\" id=\"expandtype_t"+i+"\" value='部门'>";
		if(other == '用户')
			htmlcontent += "<input type=\"hidden\" id=\"expandtype_t"+i+"\" value='用户'>";
	}
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input type=\"text\" id=\"remark_t"+i+"\"  style=\"width:200px;\">";
	htmlcontent += "</td>";
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+i+",'itemlist_t','temp');\" />";
	if(type == '结算项目'){
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" id=\"btsave_"+i+"\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
	}
	else if(type == '已收项目'){
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" id=\"btsave_"+i+"\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
	}
	else if(type == '已付项目'){
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" id=\"btsave_"+i+"\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
	}
	else if(type == '预收项目'){
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" id=\"btsave_"+i+"\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
	}
	else if(type == '预付项目'){
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" id=\"btsave_"+i+"\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
	}
	else if(type == '支出项目'){
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" id=\"btsave_"+i+"\" onClick=\"if(checktitle("+i+",'_t'))if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
	}
	else{
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" id=\"btsave_"+i+"\" onClick=\"if(checktitle("+i+",'_t'))if(CheckForm('form_yingshou','resultdiv_2'))save("+i+",'itemlist_t','_t','"+type+"');\" /></td>";
	}
    htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "</tr>";
	jQuery("#"+divname).append(htmlcontent);
	if(type == '利润'){
		if(other == '部门')
		myautocomplete("#title_t"+i,'部门');
		if(other == '用户')
		myautocomplete("#title_t"+i,'用户');
	}
	if(type == '支出项目'){
		myautocomplete("#title_t"+i,'商户条目');
	}
	
	
	
	
 }

 function save(id,divname,mark,type)
 {
	art.dialog({
		id: 'id-demo',
		title: '操作信息',
	});		
//	scroll(0,0);
//	ThinkAjax.myloading('resultdiv');
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
	var paytime = jQuery("#paytime"+mark+id).val();
	var remark = jQuery("#remark"+mark+id).val();
	var expandID = jQuery("#expandID"+mark+id).val();
	var expandtype = jQuery("#expandtype"+mark+id).val();
	if(expandID)
		it += "&expandID="+expandID+"&expandtype="+expandtype
	title = FixJqText(title);
	remark = FixJqText(remark);
	jQuery.ajax({
		type:	"POST",
		url:	SITE_INDEX+actionmethod+"/dopost_baozhangitem",
		data:	"type="+type+"&title="+title+"&method="+method+"&remark="+remark+"&value="+value+"&renshu="+renshu+"&paytime="+paytime+"&parentID="+parentID+it,
		success:function(msg){
			jQuery("#btsave_"+id).attr("onclick",act); 
			if(mark){
//				ThinkAjax.myAjaxResponse(msg,'resultdiv',om_save,id,divname,expandtype);
				ThinkAjax.myAjaxResponse(msg,'',om_save,id,divname,expandtype);
			}
			else{
				ThinkAjax.myAjaxResponse(msg,'',save_g_after);
			}
		}
	});
	
 }
 
 
 function save_g_after(data,status,info){
	if(status == 1){
		art.dialog.get('id-demo').content('完成').time(2000);
	}
	else{
		art.dialog.get('id-demo').content(info).time(4000);
	}
 }
 
 
 
 function om_save(data,status,info,type,id,divname,other)
 {
	if(status == 1){
		var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\""+divname+data['chanpinID']+"\">";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"title"+data['chanpinID']+"\" style=\"width:200px;\" value=\""+data['title']+"\" check='^\\S+$' warning=\"标题不能为空,且不能含有空格\" >";
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
		htmlcontent += "<option value=\"抵值券\">抵值券</option>";
		htmlcontent += "</select>";
		htmlcontent += "</td>";
		if(data['type'] == '结算项目'){
			htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
			htmlcontent += "<input type=\"text\" id=\"renshu"+data['chanpinID']+"\" style=\"width:80px;\" check='^\\S+$' warning=\"人数不能为空,且不能含有空格\" value=\""+data['renshu']+"\">";
			htmlcontent += "</td>";
		}
		else if(data['type'] == '已收项目'){
			htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
			htmlcontent += "<input type=\"text\" id=\"renshu"+data['chanpinID']+"\" style=\"width:80px;\" check='^\\S+$' warning=\"人数不能为空,且不能含有空格\" value=\""+data['renshu']+"\">";
			htmlcontent += "</td>";
		}
		else if(data['type'] == '已付项目'){
			htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
			htmlcontent += "<input type=\"text\" id=\"renshu"+data['chanpinID']+"\" style=\"width:80px;\" check='^\\S+$' warning=\"人数不能为空,且不能含有空格\" value=\""+data['renshu']+"\">";
			htmlcontent += "</td>";
		}
		else if(data['type'] == '预收项目'){
			htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
			htmlcontent += "<input type=\"text\" id=\"renshu"+data['chanpinID']+"\" style=\"width:80px;\" check='^\\S+$' warning=\"人数不能为空,且不能含有空格\" value=\""+data['renshu']+"\">";
			htmlcontent += "</td>";
		}
		else if(data['type'] == '预付项目'){
			htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
			htmlcontent += "<input type=\"text\" id=\"renshu"+data['chanpinID']+"\" style=\"width:80px;\" check='^\\S+$' warning=\"人数不能为空,且不能含有空格\" value=\""+data['renshu']+"\">";
			htmlcontent += "</td>";
		}
		else if(data['type'] == '支出项目'){
			htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
			htmlcontent += "<input type=\"text\" id=\"renshu"+data['chanpinID']+"\" style=\"width:80px;\" check='^\\S+$' warning=\"人数不能为空,且不能含有空格\" value=\""+data['renshu']+"\">";
			htmlcontent += "</td>";
			htmlcontent += "<input type=\"hidden\" id=\"expandID"+data['chanpinID']+"\" value=\""+data['expandID']+"\">";
			htmlcontent += "<input type=\"hidden\" id=\"expandtype"+data['chanpinID']+"\" value=\""+other+"\">";
		}
		else{
			htmlcontent += "<input type=\"hidden\" id=\"expandID"+data['chanpinID']+"\" value=\""+data['expandID']+"\">";
			htmlcontent += "<input type=\"hidden\" id=\"expandtype"+data['chanpinID']+"\" value=\""+other+"\">";
		}
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input type=\"text\" id=\"remark"+data['chanpinID']+"\" value=\""+data['remark']+"\" style=\"width:200px;\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "</td>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
		htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem("+data['chanpinID']+",'"+divname+"',);\" />";
		if(data['type'] != '利润'){
			htmlcontent += "<input class=\"button\" type=\"button\" id=\"btsave_"+data['chanpinID']+"\" value=\"修改\" onClick=\"if(CheckForm('form_yingshou','resultdiv_2'))save("+data['chanpinID']+",'itemlist');\" />";
		}
		else{
			htmlcontent += "<input class=\"button\" type=\"button\" id=\"btsave_"+data['chanpinID']+"\" value=\"修改\" onClick=\"if(checktitle("+data['chanpinID']+"))if(CheckForm('form_yingshou','resultdiv_2'))save("+data['chanpinID']+",'itemlist');\" />";
		}
//		if(data['type'] != '利润')
//		htmlcontent += "<input class=\"button\" type=\"button\" id=\"btshenhe_"+data['chanpinID']+"\" value=\"申请审核\" onclick=\"doshenhe_baozhangitem('申请','报账项',"+data['chanpinID']+",'"+data['title']+"');\"/>";
		htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"checkbox\" onclick=\"javascript:dosetprint(this,"+data['chanpinID']+")\"/></td>";
		htmlcontent += "</tr>";
		jQuery("#"+divname+id).replaceWith(htmlcontent);
		if(data['type'] == '利润'){
			if(other == '部门')
				myautocomplete("#title"+data['chanpinID'],'部门');
			if(other == '用户')
				myautocomplete("#title"+data['chanpinID'],'用户');
		}
		
		if(data['type'] == '支出项目'){
			myautocomplete("#title"+data['chanpinID'],'商户条目');
		}
		art.dialog.get('id-demo').content('完成').time(2000);
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
		url:	SITE_INDEX+actionmethod+"/deleteBaozhangitem",
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
		if(parenttype == '用户')
		datas = userlist;
		if(parenttype == '商户条目')
		datas = shanghutiaomu;
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


function checktitle(id,mark,expandtype){
	if(!mark)
		mark = '';
	var title = document.getElementById("title"+mark+id).value;
	if(!expandtype)
		var expandtype = document.getElementById("expandtype"+mark+id).value;
	if(expandtype == '用户')
		datas = userlist;
	if(expandtype == '部门')
		datas = department;
	if(expandtype == '商户条目')
		datas = shanghutiaomu;
	var ishas = 0;
	for (var i=0;i<datas.length;i++) { 
		if(title == datas[i]['title']){
			systemID = datas[i]['systemID'];
			ishas = 1;
			break;
		}
	} 
	if(!ishas){
		scroll(0,0);
		jQuery("#title"+id).val('');
		jQuery("#expandID"+id).val('');
		document.getElementById('resultdiv_2').innerHTML	=	'<div style="color:red">'+title+',不存在,请重新选择！！</div>';
		jQuery("#resultdiv_2").show("fast"); 
		this.intval = window.setTimeout(function (){
			document.getElementById('resultdiv_2').style.display='none';
			document.getElementById('resultdiv_2').innerHTML='';
			},3000);
			return false;
	}
	else{
		jQuery("#expandID"+mark+id).val(systemID);
		return true;
	}
}






