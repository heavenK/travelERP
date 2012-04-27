// JScript 文件
// 设置起点的修改
function SelectStartPlace(obj,poiID) {
	$("gjcx_StartPoiName").value = obj.innerHTML;
	$("gjcx_StartPoiID").value=poiID;
	var items = document.getElementById("ulStartPlace").childNodes; //起点的UL
	for (var i=0; i<items.length; i++) {
		items[i].className = "";
	}
	obj.className = "current";
}
// 设置终点的修改
function SelectEndPlace(obj,poiID) {
	$("gjcx_EndPoiName").value = obj.innerHTML;
	$("gjcx_EndPoiID").value=poiID;
	var items = document.getElementById("ulEndPlace").childNodes;   //终点的UL
	for (var i=0; i<items.length; i++) {
		items[i].className = "";
	}
	obj.className = "current";
	//调用地图
    
}
//起点确定按钮
function ModifyStartPlace(start,state){
	//ClearHighLight();
    //getMap();
	//起点选择列表
    var strI=2;
    if (state)
    {
       strI=state;
    }
	RemoveMark(1);
	RemoveMark(4);
	RemoveMark(5);
    ClearLines(); 
	ClearLayer();
	var ds = new XMLDatastore();
	ds.init();
    var url = "/Agent/Hotel/js/ajax.aspx?type=getPoiListOfName&name="+encodeURIComponent(start)+"&time="+new Date().getTime();
	var response = httpRequest("get",null,url);
	if (!ds.loadXML(response)) {
		alert("加载文件出错！");
		ds.destroy();
		return false;
	}
	var str = "<ul id=\"ulStartPlace\">";
    if (ds.rowCount()==0)
	{
        str+="<li>没有找到要查找的出发点信息</li>";
		$("gjcx_StartPoiID").value="";
	}
	else
	{
	    for(var i=0;i<ds.rowCount();i++)
	    {
	        //默认的起点列表第一项选中
	        if (i==0) {          
               $("gjcx_StartPoiName").value=ds.getItemByName(0,"PoiName");
               $("gjcx_StartPoiID").value=ds.getItemByName(i,"PoiID");
               AddPoint(ds.getItemByName(i,"X"),ds.getItemByName(i,"Y"),ds.getItemByName(i,"PoiName"),strI,"startPoint"+(i+1),true);
                 
            }
            str += "<li id='startPoint"+(i+1)+"' onclick=\"AddPoint("+ds.getItemByName(i,"X")+","+ds.getItemByName(i,"Y")+",'"+ds.getItemByName(i,"PoiName")+"',"+strI+",'startPoint"+(i+1)+"',true);AddStartNotice("+ds.getItemByName(i,"X")+","+ds.getItemByName(i,"Y")+",'"+ds.getItemByName(i,"PoiName")+"','"+ds.getItemByName(i,"PoiType")+"','"+ds.getItemByName(i,"Address")+"');SelectStartPlace(this,'"+ds.getItemByName(i,"PoiID")+"');\" style=\"cursor:pointer\">"+ds.getItemXmlByName(i,"PoiName")+"</li>";        	
	    }
	}
	str += "</ul>";
	$("StartPlaceList").innerHTML = str;
    $("gjcx_spanStartPlace").innerHTML = start;
    //设置起点列表 默认第一项的样式
     var itemBegin=document.getElementById("ulStartPlace").childNodes[0];
	itemBegin.className="current";
    CancelTranFormBegin();
	ds.destroy();
    
	if ($("SearchResult")) {
		$("SearchResult").style.display = '';
	}
	
	if ($("RoadResult")) {
		$("RoadResult").style.display = 'none';
	}
	
	if ($("dzskStationList")) {
		$("dzskStationList").style.display = 'none';
		$("dzskSelectPoi").style.display = '';
	}
}
//终点确定按钮
function ModifyEndPlace(end,state){
    //ClearHighLight();
    //getMap();
    var strI=3;
    if (state)
    {
       strI=state;
    }
    RemoveMark(1);
	RemoveMark(4);
	RemoveMark(5);
    ClearLines(); 
	ClearLayer();
	//起点选择列表
	var ds = new XMLDatastore();
    var url = "/Agent/Hotel/js/ajax/ajax.aspx?type=getPoiListOfName&name="+encodeURIComponent(end)+"&time="+new Date().getTime();
	var response = httpRequest("get",null,url);
	ds.init();
	if (!ds.loadXML(response)) {
		alert("加载文件出错！");
		ds.destroy();
		return false;
	}
	var str = "<ul id=\"ulEndPlace\">";
	if (ds.rowCount()==0)
	{
        str+="<li>没有找到要查找的目的地信息</li>";
		$("gjcx_EndPoiID").value="";
	}
	else
	{
	    for(var i=0;i<ds.rowCount();i++)
	    {
	        //默认的终点列表第一项选中
	        if (i==0) {          
               $("gjcx_EndPoiName").value=ds.getItemByName(0,"PoiName");
               $("gjcx_EndPoiID").value=ds.getItemByName(i,"PoiID");
               AddPoint(ds.getItemByName(i,"X"),ds.getItemByName(i,"Y"),ds.getItemByName(i,"PoiName"),strI,"endPoint"+(i+1),true);
                 
            }
            str += "<li id='endPoint"+(i+1)+"' onclick=\"AddPoint("+ds.getItemByName(i,"X")+","+ds.getItemByName(i,"Y")+",'"+ds.getItemByName(i,"PoiName")+" ',"+strI+",'endPoint"+(i+1)+"',true);AddStartNotice("+ds.getItemByName(i,"X")+","+ds.getItemByName(i,"Y")+",'"+ds.getItemByName(i,"PoiName")+"','"+ds.getItemByName(i,"PoiType")+"','"+ds.getItemByName(i,"Address")+"',1);SelectEndPlace(this,'"+ds.getItemByName(i,"PoiID")+"')\" style=\"cursor:pointer\">"+ds.getItemXmlByName(i,"PoiName")+"</li>";   	        
	       
	    }
	}
	str += "</ul>";
	$("EndPlaceList").innerHTML = str;
	$("gjcx_spanEndPlace").innerHTML = end;
	CancelTranFormEnd();
	 //设置终点列表 默认第一项的样式
    var itemEnd=document.getElementById("ulEndPlace").childNodes[0];
	itemEnd.className="current";
	
	if ($("SearchResult")) {
		$("SearchResult").style.display = '';
	}
	
	if ($("RoadResult")) {
		$("RoadResult").style.display = 'none';
	}
	ds.destroy();
}

// =====================================  根据用户输入的内容查询出的相似名称列表
function SearchNotice(showText,showListDiv,name) {
	//PoiFilter.hideMenu(new Date().getTime());lil
	var current = PoiFilter.current;
    if (name == null || name == "" || name.length == 0) {
		PoiFilter.hideMenu();
        return false;
    }
	var url = "/Agent/Hotel/js/ajax.aspx?type=getPoiListByName&name="+encodeURIComponent(name);
	var Http = httpRequest("get",null,url,true);
	Http.onreadystatechange = function()
	{
		if(Http.readyState == 4 ) 
		{
		    var response = Http.responseText;
		    //alert(response);
			if(response!="")
			{
			    var agencys= response.split(",");
			    if(agencys.length>0)
			    {
			        var str = "<ul class=\"notice_ul\">";
			        for(var i=0;i<agencys.length;i++)
			        {
				        str += "<li class=\"noselect\" onmouseover=\"this.className='selected'\" onmouseout=\"this.className='noselect'\" onclick=\"document.getElementById('"+showText+"').value='"+agencys[i]+"';"+showListDiv.substring(3)+".hideMenu();\">"+agencys[i]+"</li>";
			        }
			         str += "</ul>";			
			         document.getElementById(showListDiv).innerHTML = str;
			         PoiFilter.showMenu(showText,30,0);
			         if (current == PoiFilter.current)
			            return true;
			            //PoiFilter.hideMenu();
			            
			    }
			}
		}                   
	}
	Http.send(null);
	/*var response = httpRequest("get",null,url);
	var ds = new XMLDatastore();
	ds.init();
	if (!ds.loadXML(response)) {
		alert("加载文件出错！");
		ds.destroy();
		//PoiFilter.hideMenu();
		return false;
	}
	
	if(ds.rowCount() == 0){
		ds.destroy();
		//PoiFilter.hideMenu();
		PoiFilter.hideMenu(new Date().getTime());
		return false;
	}
	else {
		var str = "<ul class=\"notice_ul\">";
		for(var i=0;i<ds.rowCount();i++)
		{
			str += "<li class=\"noselect\" onmouseover=\"this.className='selected'\" onmouseout=\"this.className='noselect'\" onclick=\"document.getElementById('"+showText+"').value='"+ds.getItemByName(i,"PoiName")+"';"+showListDiv.substring(3)+".hideMenu();\">"+ds.getItemByName(i,"PoiName")+"</li>";
		}
		str += "</ul>";
		document.getElementById(showListDiv).innerHTML = str;
		ds.destroy();
		if (current == PoiFilter.current)
			PoiFilter.showMenu(showText,22,0);
		return true;
	}*/
}

function SearchStation(showText,showListDiv,name) {
	PoiFilter.hideMenu(new Date().getTime());
	var current = PoiFilter.current;
    if (name == null || name == "" || name.length == 0) {
        return false;
    }

	var url = "/Agent/Hotel/js/ajax/ajax.aspx?type=GetPlatInfoByName&name="+encodeURIComponent(name);
	var Http = httpRequest("get",null,url,true);
	Http.onreadystatechange = function()
	{
		if(Http.readyState == 4 ) 
		{               
			var response = Http.responseText;
			var ds = new XMLDatastore();
			ds.init();
			if (!ds.loadXML(response)) {
				alert("加载文件出错！");
				ds.destroy();
				return false;
			}
			
			if(ds.rowCount() == 0){
				ds.destroy();
				return false;
			}
			else {
				var str = "<ul class=\"notice_ul\">";
				for(var i=0;i<ds.rowCount();i++)
				{
					if (i == 20) break;
					str += "<li class=\"noselect\" onmouseover=\"this.className='selected'\" onmouseout=\"this.className='noselect'\" onclick=\"document.getElementById('"+showText+"').value='"+ds.getItemByName(i,"PlatName")+"';"+showListDiv.substring(3)+".hideMenu();\">"+ds.getItemByName(i,"PlatName")+"</li>";
				}
				str += "</ul>";
				document.getElementById(showListDiv).innerHTML = str;
				ds.destroy();
				if (current == PoiFilter.current)
					PoiFilter.showMenu(showText,22,0);
				return true;
			}
			return false;
		}                   
	} 
	Http.send(null);
}

function SearchRoad(showText,showListDiv,name) {
	PoiFilter.hideMenu(new Date().getTime());
	var current = PoiFilter.current;
    if (name == null || name == "" || name.length == 0) {
        return false;
    }

	var url = "/Agent/Hotel/js/ajax/ajax.aspx?type=GetRoadNamesByName&name="+encodeURIComponent(name);
	var Http = httpRequest("get",null,url,true);
	Http.onreadystatechange = function()
	{            
		if(Http.readyState == 4 ) 
		{               
			var response = Http.responseText;
			var ds = new XMLDatastore();
			ds.init();
			if (!ds.loadXML(response)) {
				alert("加载文件出错！");
				ds.destroy();
				return false;
			}
			
			if(ds.rowCount() == 0){
				ds.destroy();
				return false;
			}
			else {
				var str = "<ul class=\"notice_ul\">";
				for(var i=0;i<ds.rowCount();i++)
				{
					if (i == 20) break;
					str += "<li class=\"noselect\" onmouseover=\"this.className='selected'\" onmouseout=\"this.className='noselect'\" onclick=\"document.getElementById('"+showText+"').value='"+ds.getItemByName(i,"RoadName")+"';"+showListDiv.substring(3)+".hideMenu();\">"+ds.getItemByName(i,"RoadName")+"</li>";
				}
				str += "</ul>";
				document.getElementById(showListDiv).innerHTML = str;
				ds.destroy();
				if (current == PoiFilter.current)
					PoiFilter.showMenu(showText,22,0);
				return true;
			}
			return false;
		}                   
	} 
	Http.send(null);
}
// 到站实况 设置起点的修改
function dzskSelectStation(obj,poiID,poiName,X,Y,objID) {
	/*getMap();
	RemoveMark(1);
	RemoveMark(4);
	RemoveMark(5);
	ClearLines(); 
	ClearLayer(); */
		
	$("gjcx_StationID").value=poiID;
	$("gjcx_StartPoiName").value = obj.innerHTML;
	var items = document.getElementById("ulStationList").childNodes; //起点的UL
	for (var i=0; i<items.length; i++) {
		items[i].className = "";
	}
	obj.className = "current";
	//调用地图
	AddPoint(X,Y,poiName,4,objID);
}
// 用户选择修改某点的时候
function TranFormBegin(){
	$("gjcx_Update").style.display='';
	$("gjcx_divStartPlace").style.display="none";
    
}
function TranFormEnd(){
	$("gjcx_Change").style.display='';
	$("gjcx_divEndPlace").style.display="none";
    
}
function CancelTranFormBegin(){
	$("gjcx_Update").style.display='none';
	$("gjcx_divStartPlace").style.display="";
    
}
function CancelTranFormEnd(){
	$("gjcx_Change").style.display='none';
	$("gjcx_divEndPlace").style.display="";
    
}
//关闭某个线路下所列出的站点
function closeStation(stationdiv){
    //清除图层
    ClearLayer();
    if ($(stationdiv).style.display==""){
    
        $(stationdiv).style.display="none";
    }
    else
    {
        $(stationdiv).style.display="";
    }
}

// 选择到点线路
function SelectReachLine(current,len) {
	for (var i=0; i<len; i++) {
		if ($("ReachLineTitle"+i)) {
			$("ReachLineTitle"+i).className = "tableLine4";
		}
		if ($("ReachLineDetail"+i)) {
			$("ReachLineDetail"+i).style.display = "none";
		}
	}
	if ($("ReachLineTitle"+current)) {
		$("ReachLineTitle"+current).className = "tableLine4_on";
	}
	if ($("ReachLineDetail"+current)) {
		$("ReachLineDetail"+current).style.display = "";
	}
}


//选择优选路线
function SelectTransSolution(current,len) {
	for (var i=0; i<len; i++) {
		if ($("roadTable"+i)) {
			$("roadTable"+i).className = "tableLine7";
		}
		if ($("showInfo"+i)) {
			$("showInfo"+i).style.display = "none";
		}
	}
	if ($("roadTable"+current)) {
		$("roadTable"+current).className = "tableLine7_on";
	}
	if ($("showInfo"+current)) {
		$("showInfo"+current).style.display = "";
	}
}

// 菜单跳转
function jumpToMenuBus(bigMenu,subMenu,nameArray,valueArray) {
	showMenuBus('menuList',bigMenu,'../');
	clickSubMenuBus('mainForm','leftWrapper',subMenu,'../');
	if (nameArray != null && nameArray.length > 0) {
		for (var i=0; i<nameArray.length; i++) {
			$(nameArray[i]).value = valueArray[i];
		}
	}
}

function SetMenuBodyHTML(showDiv,code) {
	var ds = new XMLDatastore();
	ds.init();
	if (!ds.loadFile("../xml/MenuHtmlBus.xml")) {
		alert("加载文件出错！");
		ds.destroy();
		return;
	}
	var strbody = "";
	for(var i=0;i<ds.rowCount();i++)
	{
		if (ds.getItemByName(i,"Code") == code) {
			strbody += ds.getItemXmlByName(i,"MenuBodyHTML");
			break;
		}
	}
	document.getElementById(showDiv).innerHTML = strbody;  //显示左侧的部分
	ds.destroy();
}

// 判断是否输入回车
function filterEnter(obj,funName,e) {
	if (obj.value == "" || Trim(obj.value).length == 0 || obj.value.indexOf("例如") != -1) {
		return;
	}
	var keycode = 0;
	if(window.event) {
		keycode = event.keyCode;
	}
	else {
		keycode = e.which;
	}
	if (keycode == 13) {
		if (funName == "gjcx_xlcxSearch") {
			gjcx_xlcxSearch();
		}
		else if (funName == "dtmy_zbssSearch") {
			dtmy_zbssSearch();
		}
		else if (funName == "submit") {
			document.forms[0].submit();
		}
		else if (funName == "userLogin") {
			userLogin();
		}
	}
}

// 提示框使用光标选择POI
function gjcx_cclxEnter(obj,div,funName,e)
{
	var keycode = 0;
	if(window.event) {
		keycode = event.keyCode;
	}
	else {
		keycode = e.which;
	}
	if (keycode == 38) {
		if ($(div).childNodes[0]) {
			var noticeUL = $(div).childNodes[0]
			var liCount = noticeUL.childNodes.length;
			var current = 0;
			for (var i=0; i<liCount; i++) {
				if (noticeUL.childNodes[i].className == "selected") {
					if (i==0) {
						current = liCount-1;
					}
					else {
						current = i-1;
					}
					noticeUL.childNodes[i].className = "noselect";
					break;
				}
			}
			noticeUL.childNodes[current].className = "selected";
			obj.value = noticeUL.childNodes[current].innerHTML;
		}
	}
	else if (keycode == 40) {
		if ($(div).childNodes[0]) {
			var noticeUL = $(div).childNodes[0]
			var liCount = noticeUL.childNodes.length;
			var current = 0;
			for (var i=0; i<liCount; i++) {
				if (noticeUL.childNodes[i].className == "selected") {
					if (i==(liCount-1)) {
						current = 0;
					}
					else {
						current = i+1;
					}
					noticeUL.childNodes[i].className = "noselect";
					break;
				}
			}
			noticeUL.childNodes[current].className = "selected";
			obj.value = noticeUL.childNodes[current].innerHTML;
		}
	}
}

// 判断是否输入不是回车,光标上下箭头
function isSearchNotice(e)
{
	var keycode = 0;
	if(window.event) {
		keycode = event.keyCode;
	}
	else {
		keycode = e.which;
	}
	if (keycode == 13 || keycode == 38 || keycode == 40) {
		return false;
	}
	return true;
}

// 添加停车场浮动层
function AddParkNotice(X,Y,PoiName,StartTime,EndTime,RemPosition,Telephone,Price,Address) {
	var str1 = '停车场名称：'+PoiName+'营业时间：'+StartTime+'-'+EndTime;
		if (C_setting.indexOf(",parkService_2,") != -1) {//动态车位信息
			str1+='，剩余车位：'+RemPosition;
		}
		str1+='，联系电话：'+Telephone+'，收费价格：'+Price+'元/小时，地　址：'+Address;
    var str = '<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
			+'<td height="20" valign="top"><strong>'+PoiName+'</strong></td>'
		  +'</tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="openTable">'
		 +' <tr>'
			+'<th>营业时间：</th>';
			if (C_setting.indexOf(",parkService_2,") != -1) {//动态车位信息
				str+=' <td>'+StartTime+'-'+EndTime+'&nbsp;</td>'
				+'<th>剩余车位：</th>'
				+'<td>'+RemPosition+'&nbsp;</td>';
			}
			else {
				str+=' <td colspan="3">'+StartTime+'-'+EndTime+'&nbsp;</td>';
			}
		 str+='</tr>'
		 +' <tr>'
		   +' <th>联系电话：</th>'
		   +' <td>'+Telephone+'&nbsp;</td>'
		   +' <th>收费价格：</th>'
		   +' <td>'+Price+'元/小时</td>'
		 +' </tr>'
		 +' <tr>'
		   +' <th>地　　址：</th>'
		   +' <td colspan="3">'+Address+'&nbsp;</td>'
		 +' </tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
		   +' <td align="right" height="30">';
		if (C_setting.indexOf(",roamService,") != -1) { //地图漫游服务
			str += '<a href="#" onclick="actionTozbSearch(\''+PoiName+'\')" class="blue">周边搜索</a>　';
		}
		if (C_setting.indexOf(",driveService,") != -1) { //自驾服务
			str += '<a href="#" onclick="park_Goto(\'zjcx\',\'zjcx-zjxl\',\''+PoiName+'\')" class="blue">从这里出发</a>　<a href="#" onclick="park_Reach(\'zjcx\',\'zjcx-zjxl\',\''+PoiName+'\')" class="blue">到这里去</a>　';
		}
		str += '<a href="#"><img src="images/icc_jc.gif" border="0" alt="纠错" align="absmiddle" onclick="GetWrong(\'地图纠错\',\'停车场：'+PoiName+'\',\''+str1+'\',\'\');" /></a></td>'
		  +'</tr>'
		+'</table>';
	AddNotice(X,Y,str,620,460);
}

// 添加兴趣点浮动层
function AddPOINotice(X,Y,PoiName,Telephone,Postalcode,Address,PoiType,PoiID)
{
	var ParkNum = "";
	if (PoiType.indexOf("停车场") != -1 && C_setting.indexOf(",parkService_2,") != -1) {//动态车位信息
		var url = "/Agent/Hotel/js/ajax/ajax.aspx?type=GetParksByPoiID&poiid="+PoiID+"&radius=100&ordertype=1&pagesize=1&pagenum=1&time="+new Date().getTime();   
		var response = httpRequest("get",null,url);
		var ds = new XMLDatastore();
		ds.init();
		if (!ds.loadXML(response)) {
		   ds.destroy();
		}
		else {
			if (ds.rowCount() > 0) {
				ParkNum = ds.getItemByName(0,"RemPosition");
			}
		}
		ds.destroy();
	}
	if (ParkNum != "") {
		PoiName = PoiName+'（可用车位：'+ParkNum+'）';
	}
	var str1 = '兴趣点名称：'+PoiName+'，联系电话：'+Telephone+'，邮 编：'+Postalcode+'，地 址：'+Address;
    var str = '<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
			+'<td height="20" valign="top"><strong>'+PoiName+'</strong></td>'
		  +'</tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="openTable">'
		 +' <tr>'
		   +' <th>联系电话：</th>'
		   +' <td>'+Telephone+'&nbsp;</td>'
		   +' <th>邮    编：</th>'
		   +' <td>'+Postalcode+'&nbsp;</td>'
		 +' </tr>'
		 +' <tr>'
		   +' <th>地　　址：</th>'
		   +' <td colspan="3">'+Address+'&nbsp;</td>'
		 +' </tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
		   +' <td align="right" height="30">';
		 if (C_setting.indexOf(",roamService,") != -1) { //地图漫游服务
		 	str += '<a href="#" onclick="actionTozbSearch(\''+PoiName+'\')" class="blue">周边搜索</a>　';
		 }
		 if (C_setting.indexOf(",driveService,") != -1) { //自驾服务
		 	str += '<a href="#" onclick="park_Goto(\'zjcx\',\'zjcx-zjxl\',\''+PoiName+'\')" class="blue">从这里出发</a>　<a href="#" onclick="park_Reach(\'zjcx\',\'zjcx-zjxl\',\''+PoiName+'\')" class="blue">到这里去</a>　';
		 }
		 str += '<a href="#"><img src="images/icc_jc.gif" border="0" alt="纠错" align="absmiddle" onclick="GetWrong(\'地图纠错\',\'兴趣点名称：'+PoiName+'\',\''+str1+'\',\'\');" /></a></td>'
		  +'</tr>'
		+'</table>';
	AddNotice(X,Y,str,620,415);
}

// 添加起点终点浮动层
function AddStartNotice(X,Y,PoiName,PoiType,Address,sty) {
	var type = "起点";
	if (sty == 1) {
		type = "终点";
	}
	var str1 = type+'：'+PoiName+'，类型：'+PoiType+'，地址：'+Address;
    var str = '<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
			+'<td height="20" valign="top"><strong>'+type+'：'+PoiName+'</strong></td>'
		  +'</tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="openTable">'
		 +' <tr>'
		   +' <th>类型：</th>'
		   +' <td>'+PoiType+'&nbsp;</td>'
		 +' </tr>'
		 +' <tr>'
		   +' <th>地址：</th>'
		   +' <td>'+Address+'&nbsp;</td>'
		 +' </tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
		   +' <td align="right" height="30">';
		if (C_setting.indexOf(",roamService,") != -1) { //地图漫游服务
			str += '<a href="#" onclick="actionTozbSearch(\''+PoiName+'\')" class="blue">周边搜索</a>　';
		}
		str += '<a href="#"><img src="images/icc_jc.gif" border="0" alt="纠错" align="absmiddle" onclick="GetWrong(\'地图纠错\',\''+type+'名称：'+PoiName+'\',\''+str1+'\',\'\');" /></a></td>'
		  +'</tr>'
		+'</table>';
	AddNotice(X,Y,str);
}

// 添加站点浮动层
function AddPlatNotice(X,Y,PlatName,LineName,Num) {
	var str1 = "站点名称："+PlatName+"，所属线路："+LineName+"，"+"站点序列：第"+Num+"站";
    var str = '<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
			+'<td height="20" valign="top"><strong>站点名称：'+PlatName+'</strong></td>'
		  +'</tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="openTable">'
		 +' <tr>'
		   +' <th>所属线路：</th>'
		   +' <td>'+LineName+'&nbsp;</td>'
		 +' </tr>'
		 +' <tr>'
		   +' <th>站点序列：</th>'
		   +' <td>第'+Num+'站</td>'
		 +' </tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
		   +' <td align="right" height="30">';
		if (C_setting.indexOf(",busService,") != -1 && C_setting.indexOf(",busService_2,") != -1) { //公交服务 实时车辆信息
			str += '<a href="#" onclick="Goto_dzskBus(\''+PlatName+'\')" class="blue">查看到站实况</a>　';
		}
		str += '<a href="#"><img src="images/icc_jc.gif" border="0" alt="纠错" align="absmiddle" onclick="GetWrong(\'地图纠错\',\'公交站点：'+PlatName+'\',\''+str1+'\',\'\');" /></a></td>'
		  +'</tr>'
		+'</table>';
	AddNotice(X,Y,str);
}

// 添加站点浮动层
function AddPlatNotice1(X,Y,PlatName,LineName,Num) {
	var str1 = "线路名称："+LineName+"，站点："+PlatName;
    var str = '<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
			+'<td height="20" valign="top"><strong>线路名称：'+LineName+'</strong></td>'
		  +'</tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="openTable">'
		 +' <tr>'
		   +' <th>站点：</th>'
		   +' <td>'+PlatName+'&nbsp;</td>'
		 +' </tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
		   +' <td align="right" height="30">';
		str += '<a href="#"><img src="images/icc_jc.gif" border="0" alt="纠错" align="absmiddle" onclick="GetWrong(\'地图纠错\',\'公交站点：'+PlatName+'\',\''+str1+'\',\'\');" /></a></td>'
		  +'</tr>'
		+'</table>';
	AddNotice(X,Y,str);
}

// 添加交通事件浮动层
function AddEventNotice(X,Y,EventType,RoadName,StartTime,ExpectTime,EventDepict) {
	var etype = "";
	if (EventType == 1) {
		etype = "交通事故";
	}
	else if (EventType == 2) {
		etype = "限行管理";
	}
	else if (EventType == 3) {
		etype = "施工占路";
	}
    var str = '<table width="100%" border="0" cellspacing="0" cellpadding="0">'
		  +'<tr>'
			+'<td height="20" valign="top"><strong>事件类型：'+etype+'</strong></td>'
		  +'</tr>'
		+'</table>'
		+'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="openTable1">'
		 +' <tr>'
		   +' <th>发生地点：</th>'
		   +' <td>'+RoadName+'&nbsp;</td>'
		 +' </tr>'
		 +' <tr>'
		   +' <th>发生时间：</th>'
		   +' <td>'+StartTime+'</td>'
		 +' </tr>'
		 +' <tr>'
		   +' <th>预计结束时间：</th>'
		   +' <td>'+ExpectTime+'</td>'
		 +' </tr>'
		 +' <tr>'
		   +' <th>事件描述：</th>'
		   +' <td>'+EventDepict+'</td>'
		 +' </tr>'
		+'</table>';
	AddNotice(X,Y,str);
}

// 收藏POI信息
function FavoritePoi(poiid,poiname,favtype,setting) {
	var url = "../ajax/common.aspx?type=FavoritePoi&poiid="+encodeURIComponent(poiid)+"&poiname="+encodeURIComponent(poiname)+"&favtype="+favtype+"&setting="+encodeURIComponent(setting)+"&time="+new Date().getTime();
	var response = httpRequest("get",null,url);
	if (response == "nologin") {
		alert("您还没有登录，请先登录！");
	}
	else if (response == "favorited") {
		alert("您已经收藏过这条信息了！");
	}
	else if (response == "success") {
		alert("收藏成功！");
	}
	else {
		alert("收藏失败！");
	}
}

// 收藏线路信息
function FavoriteLine(startpoiid,startpoiname,endpoiid,endpoiname,linetype,setting) {
	var url = "../ajax/common.aspx?type=FavoriteLine&startpoiid="+startpoiid+"&startpoiname="+encodeURIComponent(startpoiname)+"&endpoiid="+endpoiid+"&endpoiname="+encodeURIComponent(endpoiname)+"&linetype="+linetype+"&setting="+encodeURIComponent(setting)+"&time="+new Date().getTime();
	var response = httpRequest("get",null,url);
	if (response == "nologin") {
		alert("您还没有登录，请先登录！");
	}
	else if (response == "favorited") {
		alert("您已经收藏过这条信息了！");
	}
	else if (response == "success") {
		alert("收藏成功！");
	}
	else {
		alert("收藏失败！");
	}
}

// 纠错
function GetWrong(nodename,demo,result,param)
{
	demo = "";
	showPopWin('../user/get_wrong.aspx?nodename='+encodeURIComponent(nodename)+'&demo='+encodeURIComponent(demo)+'&result='+encodeURIComponent(result)+'&param='+encodeURIComponent(param),524,350,null);
}

function actionTozbSearch(poiname) {
	jumpToMenuBus('dtmy','dtmy-zbss',['gjcx_startPlace'],[poiname]);
	if ($("zbss_typeName")) {
		$("zbss_typeName").focus();
	}
}