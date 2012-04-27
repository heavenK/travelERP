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
		//var imgMenu = document.getElementById("img"+menu);

		var coords = this.findPosition(document.getElementById(formenu));
		if($(formenu).offsetWidth != null && $(formenu).offsetWidth != "") {
			divMenu.style.width = ($(formenu).offsetWidth-2)+"px";
		}
		divMenu.style.left = (coords[0]+left)+'px';
		divMenu.style.top = (coords[1]+top-divMenu.style.height-6)+'px';
		divMenu.style.display='';
		menuOn = true;
		mouseIn = "false";
		//if (imgMenu) 
		//	imgMenu.src = img_up;
		//hideSelectBoxes();
	}
	
	function hideMenu(currentSeq){
		if (currentSeq == undefined) currentSeq = 0;
		this.current = currentSeq;
		var divMenu = document.getElementById("div"+menu);
		//var imgMenu = document.getElementById("img"+menu);
		
		//divMenu.style.left = '-999em';
		divMenu.style.display='none';
		menuOn = false;
		mouseIn = false;
		//if (imgMenu) 
		//	imgMenu.src = img_down;
		//displaySelectBoxes();
	}
	
	Event.observe(document,'click',function(){
		if(!mouseIn){
			if (document.getElementById('div'+menu)) {
				if (document.getElementById('div'+menu).style.display =='') 
					//displaySelectBoxes();
				document.getElementById('div'+menu).style.display='none';
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