


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


function deletetablerow(obj,rowi,tablename)   
{ 
    var thetable = document.getElementById(tablename);  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    thetable.deleteRow(rowIndex); 
}   




var hi=0;
function insertpayment(type,tablename){
	hi++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="title" id="title'+hi+'" style=" width:90%;" />';     
	
	C=R.insertCell(-1);
	C.innerHTML=' <textarea name="content" id="content'+hi+'"  style=" width:90%; height:50px;"   ></textarea>';   
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="applytime" onfocus="WdatePicker()" id="applytime'+hi+'"   style=" width:90%;" />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="manager"  id="manager'+hi+'" style=" width:90%;"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="department"  id="department'+hi+'"  style=" width:90%;"  />';    
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="checker"  id="checker'+hi+'" style=" width:90%;"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="handler"  id="handler'+hi+'" style=" width:90%;"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='准备';     
	
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hi+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hi+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hi+",'"+tablename+"')\">删除</a>"; 

}




var hr=0;
function insertreceipt(type,tablename){
	hr++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="title" id="title'+hr+'" style=" width:90%;" />';     
	
	C=R.insertCell(-1);
	C.innerHTML=' <textarea name="content" id="content'+hr+'"  style=" width:90%; height:50px;"   ></textarea>';   
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="receipttime" onfocus="WdatePicker()" id="receipttime'+hr+'"   style=" width:90%;" />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="fromcompany"  id="fromcompany'+hr+'" style=" width:90%;"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="tocompany"  id="tocompany'+hr+'"  style=" width:90%;"  />';    
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="price"  id="price'+hr+'" style=" width:90%;"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="cashier"  id="cashier'+hr+'" style=" width:90%;"   />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="payperson"  id="payperson'+hr+'" style=" width:90%;"   />';     
	
	
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hr+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hr+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hr+",'"+tablename+"')\">删除</a>"; 

}







var hb=0;
function insertbaozhang(type,tablename){
	hb++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hb+'" value="'+type+'"  /><input type="text" name="title'+hb+'" id="title'+hb+'"  />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="price"  id="price'+hb+'"  />';     
	
	C=R.insertCell(-1);
	C.innerHTML='<select name="pricetype" id="pricetype'+hb+'"  ><option value="网拨">网拨</option><option value="银行卡">银行卡</option><option value="汇款">汇款</option><option value="转账">转账</option><option value="支票">支票</option><option value="签单">签单</option><option value="现金">现金</option></select>';
	
	
	
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="remark"  id="remark'+hb+'"  style=" width:90%;"  />';     
	
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hb+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hb+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hb+",'"+tablename+"')\">删除</a>"; 

}

function insertbaozhang_01(type,tablename){
	hb++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hb+'" value="'+type+'"  /><input type="text" name="title'+hb+'" id="title'+hb+'"  />';     
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="renshu"  id="renshu'+hb+'"  />';  
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="remark"  id="remark'+hb+'" />';   
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="price"  id="price'+hb+'"  />';     
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hb+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hb+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hb+",'"+tablename+"')\">删除</a>"; 

}

function insertbaozhang_02(type,tablename){
	hb++;
	var thetable = document.getElementById(tablename);     
	R=thetable.insertRow(-1); 
	C=R.insertCell(-1);
	C.innerHTML='<input type="hidden" name="type" id="type'+hb+'" value="'+type+'"  /><input type="text" name="title'+hb+'" id="title'+hb+'"  />';     
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="renshu"  id="renshu'+hb+'"  />';  
	C=R.insertCell(-1);
	C.innerHTML='<input type="text" name="price"  id="price'+hb+'"  />';     
	C=R.insertCell(-1);
	C.innerHTML+="<a id='operator"+hb+"' style='cursor:pointer;color: blue;' class='del' onclick=\"additem("+hb+",'"+tablename+"');\">确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick=\"deletetablerow(this,"+hb+",'"+tablename+"')\">删除</a>"; 

}
















