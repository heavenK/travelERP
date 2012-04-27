


var hj=0;

function insertappraisal_1(type,tablename){
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


function insertappraisal_2(type,tablename){
	hj++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hj+'" value="'+type+'"  /><input type="hidden" name="titleID" id="titleID'+hj+'" /><input type="hidden" name="title'+hj+'" id="title'+hj+'" />'+'<input type="text" name="description"  id="description'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="ext_1"  id="ext_1'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="ext_2"  id="ext_2'+hj+'"   />';     
	
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
	C.innerHTML='<input type="text" name="ext_1"  id="ext_1'+hj+'"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="ext_2"  id="ext_2'+hj+'"   />';     
	
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
	C.innerHTML+="<a id='operator"+hj+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hj+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hj+",'"+tablename+"')\">删除</a>"; 

}




function deletetablerow(obj,rowi,tablename)   
{ 
    var thetable = document.getElementById(tablename);  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    thetable.deleteRow(rowIndex); 
}   


