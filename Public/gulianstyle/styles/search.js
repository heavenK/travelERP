// JScript 文件
// 提示框使用光标选择POI
function gjcx_cclxEnter(obj,div,e)
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
/**
* Makes all drop down form select boxes on the screen visible so they do not reappear after the dialog is closed.
* IE has a problem with wanted select form tags to always be the topmost z-index or layer
*/
function displaySelectBoxes(win) {
	if (win == undefined) {
		win = window;
	}
	for(var i = 0; i < win.document.forms.length; i++) {
		for(var e = 0; e < win.document.forms[i].length; e++){
			if(win.document.forms[i].elements[e].tagName == "SELECT") {
			win.document.forms[i].elements[e].style.visibility="visible";
			}
		}
	}
}
function hideSelectBoxes() {
	for(var i = 0; i < document.forms.length; i++) {
		for(var e = 0; e < document.forms[i].length; e++){
			if(document.forms[i].elements[e].tagName == "SELECT") {
				document.forms[i].elements[e].style.visibility="hidden";
			}
		}
	}
}
function SortFilter() {
	//类变量
	var menuOn = false;
	var mouseIn = false;
	var menu = "";
	var img_up = "";
	var img_down = "";
	var current = 0;
	
	//类方法
	this.setMenu = setMenu;
	this.showMenu = showMenu;
	this.hideMenu = hideMenu;
	this.mouseTrue = mouseTrue;
	this.mouseFalse = mouseFalse;
	this.findPosition = findPosition;
	
	function setMenu(name,img_up,img_down) {
		if (!img_up) img_up = "";
		if (!img_down) img_down = "";
		menu = name;
		img_up = img_up;
		img_down = img_down;
	}
	
	function showMenu(formenu,top,left){
		if (!top) top = 0;
		if (!left) left = 0;
		var divMenu = document.getElementById("div"+menu);
		var coords = this.findPosition(document.getElementById(formenu));
		if($(formenu).offsetWidth != null && $(formenu).offsetWidth != "") {
			divMenu.style.width = ($(formenu).offsetWidth-2)+"px";
		}
		divMenu.style.left = (coords[0]+left)+'px';
		divMenu.style.top = (coords[1]+top)+'px';
		menuOn = true;
		mouseIn = "false";
		hideSelectBoxes();
	}
	
	function hideMenu(currentSeq){
		if (currentSeq == undefined) currentSeq = 0;
		this.current = currentSeq;
		var divMenu = document.getElementById("div"+menu);
		
		divMenu.style.left = '-999em';
		menuOn = false;
		mouseIn = false;
		displaySelectBoxes();
	}
	
	Event.observe(document,'click',function(){
		if(!mouseIn){
			if (document.getElementById('div'+menu)) {
				if (document.getElementById('div'+menu).style.left != '-999em') 
					displaySelectBoxes();
				document.getElementById('div'+menu).style.left='-999em';
				var arImgs = document.getElementById('img'+menu);
				if (arImgs) 
					arImgs.src = img_up;
				menuOn = false;
				//displaySelectBoxes();
			}
		}
		if (mouseIn == "false") {
			mouseIn = false;
		}
	});
	function mouseTrue(){mouseIn=true;}
	function mouseFalse(){mouseIn=false;}
	
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
}

var PoiFilter = new SortFilter();
PoiFilter.setMenu('PoiFilter');
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
//
function SearchNotice(showText,showListDiv,name,type) {
	
	var current = PoiFilter.current;
    if (name == null || name == "" || name.length == 0) {
		PoiFilter.hideMenu();
        return false;
    }
	var url = "/CityShow/ajax111.aspx?type=" + type + "&pf="+encodeURIComponent(name)+"&time="+new Date().getTime();
	var response = httpRequest("get",null,url);
	
	var ps = response.split('|');
	if(ps.length == 0)
	{
	    PoiFilter.hideMenu(new Date().getTime());
	    return false;
	}
	else {
		var str = "<ul class=\"notice_ul\">";
		for(var i=0;i<ps.length;i++)
		{
		    if(ps[i] != '')
			    str += "<li class=\"noselect\" onmouseover=\"this.className='selected'\" onmouseout=\"this.className='noselect'\" onclick=\"document.getElementById('"+showText+"').value='"+ps[i]+"';"+showListDiv.substring(3)+".hideMenu();\">"+ps[i]+"</li>";
		}
		str += "</ul>";
		if(str == "<ul class=\"notice_ul\"></ul>")
		{
		    PoiFilter.hideMenu(new Date().getTime());
	        return false;
		}
		document.getElementById(showListDiv).innerHTML = str;
		if (current == PoiFilter.current)
			PoiFilter.showMenu(showText,22,0);
		return true;
	}
}
