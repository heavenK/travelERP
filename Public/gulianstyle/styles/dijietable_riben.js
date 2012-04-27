


var hj=0;

function insertappraisal(type,tablename){
	hj++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hj+'" value="'+type+'"  /><input type="hidden" name="titleID" id="titleID'+hj+'" /><input type="text" name="title'+hj+'" id="title'+hj+'" /> <a id="aChoiceCom" href="javascript:openSub(\'title\',\'titleID\',\''+hj+'\',\''+type+'\');">选择</a> <a href="javascript:cancelsub(\'title\',\'titleID\',\''+hj+'\');">取消</a>';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="description"  id="description'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="timestart"  id="timestart'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="timeend"  id="timeend'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="renshu"  id="renshu'+hj+'"   />';    
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="price"  id="price'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hj+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hj+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hj+",'"+tablename+"')\">删除</a>"; 

}


function insertappraisal_1(type,tablename){
	hj++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hj+'" value="'+type+'"  /><input type="hidden" name="titleID" id="titleID'+hj+'" /><input type="hidden" name="title'+hj+'" id="title'+hj+'" />'+'<input type="text" name="description"  id="description'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="timestart"  id="timestart'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="renshu"  id="renshu'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="price"  id="price'+hj+'"   />';    
	
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hj+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hj+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hj+",'"+tablename+"')\">删除</a>"; 

}


function insertappraisal_2(type,tablename){
	hj++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hj+'" value="'+type+'"  /><input type="hidden" name="titleID" id="titleID'+hj+'" /><input type="hidden" name="title'+hj+'" id="title'+hj+'" />'+'<input type="text" name="description"  id="description'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="timestart"  id="timestart'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="price"  id="price'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hj+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hj+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hj+",'"+tablename+"')\">删除</a>"; 

}



function insertappraisal_3(type,tablename){
	hj++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hj+'" value="'+type+'"  /><input type="hidden" name="titleID" id="titleID'+hj+'" /><input type="hidden" name="title'+hj+'" id="title'+hj+'" />'+'<input type="text" name="description"  id="description'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="price"  id="price'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hj+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hj+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hj+",'"+tablename+"')\">删除</a>"; 

}



function insertappraisal_4(type,tablename){
	hj++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hj+'" value="'+type+'"  /><input type="hidden" name="titleID" id="titleID'+hj+'" /><input type="text" name="title'+hj+'" id="title'+hj+'" />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="description"  id="description'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="timestart"  id="timestart'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="timeend"  id="timeend'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="renshu"  id="renshu'+hj+'"   />';    
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="price"  id="price'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hj+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hj+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hj+",'"+tablename+"')\">删除</a>"; 

}



function insertappraisal_5(type,tablename){
	hj++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hj+'" value="'+type+'"  /><input type="hidden" name="titleID" id="titleID'+hj+'" /><input type="hidden" name="title'+hj+'" id="title'+hj+'" />'+'<input type="text" name="description"  id="description'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="timestart"  id="timestart'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="timeend"  id="timeend'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="remark"  id="remark'+hj+'"   />';    
	
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hj+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hj+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hj+",'"+tablename+"')\">删除</a>"; 

}




function deletetablerow(obj,rowi,tablename)   
{ 
    var thetable = document.getElementById(tablename);  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    thetable.deleteRow(rowIndex); 
}   


