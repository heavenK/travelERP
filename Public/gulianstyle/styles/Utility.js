
function expandDiv(ctrl) {
	var ctl = eval(ctrl);
	if (ctl.style.display == "none") 
		ctl.style.display = "";
	else
		ctl.style.display = "none";
}

// 数值检测
function IsNumber(number)	{	
	if(number.length == 0)
		return false;
	for(i = 0; i < number.length; i++) {
		if(number.charAt(i) < '0' || number.charAt(i) > '9')
			return false;
	}
	return true;
}


function LTrim(str) {
	if (str == null) {
		return "";
	}	
	var len = 0;
	while(str.charAt(len) == " ")
		len++;
	return str.substring(len);
}


function RTrim(str) {
	if (str == null) {
		return "";
	}
	var len = str.length;
	while(str.charAt(len-1) == " ")
		len--;
	return str.substring(0,len);
}	


function Trim(str) {		
	return LTrim(RTrim(str));
}

// 是否以字符开头
function IsBeginChar(str)	{
	if(str.length == 0)
		return false;		
	if((str.charAt(0) >= 'A' && str.charAt(0) <= 'Z') || (str.charAt(0) >= 'a' && str.charAt(0) <= 'z'))
			return true;		
	return false;
}

// Email验证
function IsEmail(email) {
	var patrn=/^\w[0-9a-zA-Z-_\.]*@(\w[0-9a-zA-Z-]*\.)+\w{2,}$/;
	if (!patrn.exec(email)) 
		return false;
	return true;
} 

// 固定电话验证
function IsTel(tel) {
	if(tel.length < 7 || tel.length > 20)
		return false;
	for(i = 0;i<tel.length;i++)
	{
		if((tel.charAt(i)>='0' && tel.charAt(i)<='9') || tel.charAt(i) == '-') {
			if(tel.charAt(i) == '-' && (i <=2 || i >= (tel.length -3)))
				return false;
		}
		else			
			return false;
	}
	return true;

} 

// 手机验证
function IsMobile(mobile) {
	if (mobile.length = 11 && IsNumber(mobile)) {
		return true;
	}
	return false;
} 

// 邮政编码验证
function IsPostCode(postCode)	{	
	if(postCode.length != 6 || !IsNumber(postCode))
		return false;		
	return true;
}


function GetParastr(strname) {// 获取地址参数
	var hrefstr
	hrefstr = window.location.href;		
	return GetParastrByUrlAndParaName(hrefstr,strname);
}


function GetParastrByUrlAndParaName(hrefstr,strname) {// 获取地址参数
	var pos,parastr,para,tempstr;		
	pos = hrefstr.indexOf("?")
	parastr = hrefstr.substring(pos+1);
	para = parastr.split("&");
	tempstr="";
	for(i=0;i<para.length;i++) {
		tempstr = para[i];
		pos = tempstr.indexOf("=");
		if(tempstr.substring(0,pos) == strname)
			return tempstr.substring(pos+1);
	}
	return null;
}	

// Find element x,y location
function findPosition( oLink ) {
	var posX = null;
	var posY = null;
	if( oLink.offsetParent ) {
	for( posX = 0, posY = 0; oLink.offsetParent; oLink = oLink.offsetParent ) {
		posX += oLink.offsetLeft;
		posY += oLink.offsetTop;
	}
	return [ posX, posY ];
	} else {
	posX = oLink.x;
	posY = oLink.y;
	return [ posX, posY ];
	}
}

function locationAddParam(url, paramName, paramValue) {
	paramValue = encodeURIComponent(paramValue)
	if (url == "" || url.length == 0) {
		url = window.location.href;
	}
	if (url.substring(url.length-1,url.length) == "#") {
		url = url.substring(0,url.length-1);
	}
	var pos = url.indexOf("&"+paramName+"=");
	if (pos == -1) {
		pos = url.indexOf("?"+paramName+"=");
	}
	if (pos != -1) {
		if (url.indexOf("&",pos+1) == -1) {
			url = url.substring(0,url.indexOf("=",pos+1)+1)+paramValue;
		}
		else {
			var tempStr = url.substring(url.indexOf("&",pos+1),url.length);
			url = url.substring(0,url.indexOf("=",pos+1)+1)+paramValue+tempStr;
		}
	}
	else {
		if (url.indexOf("?") != -1) {
			url = url+"&"+paramName+"="+paramValue;
		}
		else {
			url = url+"?"+paramName+"="+paramValue;
		}
	}
	return url;
}

function locationDelParam(url, paramName) {
	if (url == "" || url.length == 0) {
		url = window.location.href;
	}
	var pos = url.indexOf("&"+paramName+"=");
	if (pos == -1) {
		pos = url.indexOf("?"+paramName+"=");
	}
	if (pos != -1) {
		if (url.indexOf("&",pos+1) == -1) {
			url = url.substring(0,pos);
		}
		else {
			var tempStr = url.substring(url.indexOf("&",pos+1)+1,url.length);
			url = url.substring(0,pos+1)+tempStr;
		}
	}
	return url;
}

function ReadCookie(name)
{
	var mycookie = document.cookie; 
	var start1 = mycookie.indexOf(name + "=");
	if (start1== -1)
		return "";
	else
	{
		start=mycookie.indexOf("=",start1)+1; 
		var end = mycookie.indexOf(";",start);
		if (end==-1)
		{
			end=mycookie.length;
		}
		var value=unescape(mycookie.substring(start,end));
		return value;
	}
}

function isNull(obj){
	if (typeof(obj) == "undefined")
	  return true;
	  
	if (obj == undefined)
	  return true;
	  
	if (obj == null)
	  return true;
	 
	return false;
}

function replaceAll(sourceStr,str1,str2) {
	raRegExp = new RegExp(str1,"g");
	return sourceStr.replace(raRegExp,str2); 
}
