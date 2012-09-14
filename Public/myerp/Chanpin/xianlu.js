function myCheckBoxSelect(o,st)
{
    var id = 'chanpinitem';
    var i = 0;
    for(;;)
    {
        id = 'chanpinitem' + i;
        var c = document.getElementById(id);
		if(st)
			var s = false;
		else
			if(o)
			var s = o.checked;
			else
			var s = true;
        if(c)
            c.checked = s;
        else
            break;
        i ++;
    }
}

function showbox(obj,divname,pos)
{
	objleft = getPosLeft(obj) + 0;
	objtop = getPosTop(obj) + 20;
	if(pos == 'r')
		jQuery("#"+divname).css({top:objtop , right:20 });
	else
		jQuery("#"+divname).css({top:objtop , left:objleft });
	var divRili = document.getElementById(divname); 
	if(divRili.style.display=='')
		divRili.style.display = 'none';
	else 
		divRili.style.display = '';			
}
function showdate(datelist)
{
	datelist=datelist.replace(/'/g,"");
	datelist=datelist.split(";");
	 var str = '';
	 for(var i =0; i<datelist.length;i++){
		 str += '<a href="#" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,\'yes\');" class="menuItem" style="width: 150px">'+datelist[i]+'</a>';
	 }
	jQuery("#thedate").empty();
	jQuery("#thedate").append(str);
}
function showmessage(obj,chanpinID)
{
	jQuery.ajax({
		type:	"POST",
		url:	"<{:SITE_INDEX}>Chanpin/message",
		data:	"chanpinID="+chanpinID,
		success:	function(msg){
				  var str = '';
				  if(msg != 'null' && msg){
					  var msg = eval('(' + msg + ')');
					  for(var i =0; i<msg.length;i++){
						  str += '<a href="#" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,\'yes\');" class="menuItem" style="width: 300px">'+msg[i].title+'<br>'+getLocalTime(msg[i].time)+'</a>';
					  }
				  }
				  else
				  str += '<a href="#" onMouseOut="unhiliteItem(this);" onMouseOver="hiliteItem(this,\'yes\');" class="menuItem" style="width: 300px">暂无数据</a>';
				  jQuery("#themessage").empty();
				  jQuery("#themessage").append(str);
			}
		});
}

function getLocalTime(nS) {  
	return new Date(parseInt(nS) * 1000).toLocaleString().substr(0,17);
    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
}

