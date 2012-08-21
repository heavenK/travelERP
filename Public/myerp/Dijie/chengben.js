
 var i=0;
 
 function insertItem(type){
	 if(type == '大交通')
	 insertItem_dajiatong(type);
	 else
	 insertItem_else(type);
 }
 
 
 function insertItem_dajiatong(type)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"chengbenrow_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"hidden\" name=\"type[]\" value=\""+type+"\" check='^\\S+$' warning=\"类型不能为空,且不能含有空格\">"+type+"</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"title[]\"  check='^\\S+$' warning=\"标题不能为空,且不能含有空格\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"renshu[]\" value=\""+renshu+"\"  check='^\\S+$' warning=\"人数不能为空,且不能含有空格\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"time_start[]\" onfocus=\"WdatePicker({startDate:\'\',dateFmt:\'yyyy-MM-dd HH:mm:00\',alwaysUseStartDate:true})\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"time_end[]\" onfocus=\"WdatePicker({startDate:\'\',dateFmt:\'yyyy-MM-dd HH:mm:00\',alwaysUseStartDate:true})\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"remark[]\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"price[]\" class='priceitem' check='^\\S+$' warning=\"金额不能为空,且不能含有空格\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem('chengbenrow_t"+i+"');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onclick=\"save();\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#chengben").append(htmlcontent);
 }


 function insertItem_else(type)
 {
	i++;	 
	var htmlcontent = "<tr height=\"30\" class=\"evenListRowS1\" id=\"chengbenrow_t"+i+"\">";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"hidden\" name=\"type[]\" value=\""+type+"\" check='^\\S+$' warning=\"类型不能为空,且不能含有空格\">"+type+"</td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"title[]\"  check='^\\S+$' warning=\"标题不能为空,且不能含有空格\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"renshu[]\" value=\""+renshu+"\"  check='^\\S+$' warning=\"人数不能为空,且不能含有空格\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"time_start[]\" onfocus=\"WdatePicker()\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"time_end[]\" onfocus=\"WdatePicker()\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"remark[]\" ></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\"><input type=\"text\" name=\"price[]\" class='priceitem' check='^\\S+$' warning=\"金额不能为空,且不能含有空格\"></td>";
	htmlcontent += "<td scope=\"row\" align=\"left\" valign=\"top\">";
	htmlcontent += "<input class=\"button\" type=\"button\" value=\"删除\" onclick=\"deleteSystemItem('chengbenrow_t"+i+"');\" />";
    htmlcontent += "<input class=\"button\" type=\"button\" value=\"确认\" onclick=\"save();\" /></td>";
	htmlcontent += "</tr>";
	jQuery("#chengben").append(htmlcontent);
 }


 function deleteSystemItem(divname)
 {
		jQuery("#"+divname).remove();
		jisuanchengben();
		save();
 }



 function jisuanchengben()
 {
	var t=0;
	var i =1;
	jQuery(".priceitem").each(function(){ 
		price = this.value;
		t += parseInt(price)
		i++;
	});  
		var str = '总成本：'+t;
		jQuery("#chengbenjisuan").html(str); 
}
 




