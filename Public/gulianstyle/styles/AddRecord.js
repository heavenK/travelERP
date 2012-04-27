// JScript 文件
var href=window.location.href;
if(href.toLowerCase().indexOf("/agent/lineinfo.aspx")!=-1)
{
    AddRecord("LineProduct",GetParastrByUrlAndParaName(href,"lineid"));
}

if(href.toLowerCase().indexOf("/agent/free/lineinfo.aspx")!=-1)
{
    AddRecord("FreeProduct",GetParastrByUrlAndParaName(href,"lineid"));
}

function AddRecord(type,ID)
{
    var url="/Agent/AddRecord.aspx?type="+type+"&ProductID="+ID+"&date="+new Date().getTime();
    var response=httpRequest("get",null,url);
    //alert(response);
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
		if(tempstr.substring(0,pos) == strname) {
			tmp = tempstr.substring(pos+1);
			if(tmp.indexOf("#") != -1)
				return tmp.substring(0,tmp.length-1);
			else
				return tmp;
		}
	}
	return null;
}