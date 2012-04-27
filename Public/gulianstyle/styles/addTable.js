///////////////////////////////////////////////////////////////////////////////////////////
  ///代理商销售价
  function GetCaoZuoType(obj)
  {
      if(confirm("确定要修改代理商选择类别？"))
      {
          if(obj.value=="Batch")
          {
            document.getElementById('xuanzetype').value="Batch";
            document.getElementById('AgentPrice').style.display="";
            document.getElementById('AgentPrice2').style.display="none";
          }
          if(obj.value=="MultipleChoice")
          {
            document.getElementById('xuanzetype').value="MultipleChoice";
            document.getElementById('AgentPrice').style.display="none";
            document.getElementById('AgentPrice2').style.display="";
          }
      }
      else
      {
        if(obj.value=="Batch")
        {
            document.getElementById('xuanzetype').value="MultipleChoice";
            obj.value="MultipleChoice";
        }
        else if(obj.value=="MultipleChoice")
        {
            document.getElementById('xuanzetype').value="Batch";
            obj.value="Batch";
        }
      }
  }
  
//  function getClass(obj)
//  {
//      var biaoshi=obj.id.replace("slClass","")
//      var slAgentType=document.getElementById("slAgentType"+biaoshi);
//      if(slAgentType.value!="Store")
//      {
//          obj.value="all";
//      }
//  }
 
 function insert_rows()
 {
      var obj=document.getElementById("ddlAgentType");
      if(obj.value=="Batch")
      {
        insert_row1()
      }
      if(obj.value=="MultipleChoice")
      {
        insert_row2()
      }
 }

  var j=Number(document.getElementById('rowsnum1').value);
  function insert_row1()
  {
		  j++;
		  //代理商选择类别
		  var AgentPrice = document.getElementById('AgentPrice');     
		  R=AgentPrice.insertRow(-1); 
		 
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='shoujiaID1"+j+"' type='hidden' name='shoujiaID1"+j+"' />"+"<select id='slAgentType1"+j+"' name='slAgentType1"+j+"'  onchange='GetAgentType(this)'><option value='全部'>全部</option><option value='门市'>门市</option><option value='同业'>同业</option></select>";     
		  C=R.insertCell(-1);
		  C.innerHTML="<select id='slClass1"+j+"' name='slClass1"+j+"'><option value='全部'>全部</option></select>";
		  
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbAdultPrice1"+j+"' name='tbAdultPrice1"+j+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbChildPrice1"+j+"' name='tbChildPrice1"+j+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbAdultCommission1"+j+"' name='tbAdultCommission1"+j+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbChildCommission1"+j+"' name='tbChildCommission1"+j+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbAdultProfit1"+j+"' name='tbAdultProfit1"+j+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' readonly='readonly' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbChildProfit1"+j+"' name='tbChildProfit1"+j+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' readonly='readonly' />";
		  C=R.insertCell(-1);
		  C.innerHTML+="<a style='cursor:pointer;color:blue' onclick='delete_rows(this,"+j+")'>删除</a>"; 
		  document.getElementById('rowsnum1').value  ++;
  }
  
  function delete_rows(obj,rowi)   
  { 
    var AgentPrice = document.getElementById('AgentPrice');  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    AgentPrice.deleteRow(rowIndex); 
  }   
 
 
  var m=Number(document.getElementById('rowsnum2').value);  
  function insert_row2()
  {
		  m++;
		  //代理商选择类别
		  var AgentPrice2 = document.getElementById('AgentPrice2');     
		  R=AgentPrice2.insertRow(-1); 
		  
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='shoujiaID2"+m+"' type='hidden' name='shoujiaID2"+m+"' />"+"<input id='AgentName2"+m+"' name='AgentName2"+m+"' type='text'  readonly='readonly' /><input id='AgentID2"+m+"' name='AgentID2"+m+"' type='hidden' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<a id='AChoice2"+m+"' style='cursor:pointer;color:blue' onclick='openSubAgent(" + m + ");'>选择</a>";
		  
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbAdultPrice2"+m+"' name='tbAdultPrice2"+m+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbChildPrice2"+m+"' name='tbChildPrice2"+m+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbAdultCommission2"+m+"' name='tbAdultCommission2"+m+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbChildCommission2"+m+"' name='tbChildCommission2"+m+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbAdultProfit2"+m+"' name='tbAdultProfit2"+m+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' readonly='readonly' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbChildProfit2"+m+"' name='tbChildProfit2"+m+"' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' readonly='readonly' />";
		  C=R.insertCell(-1);
		  C.innerHTML+="<a style='cursor:pointer;color:blue' onclick='delete_row2(this,"+m+")'>删除</a>"; 
		  
		  document.getElementById('rowsnum2').value  ++;
  }
  
  
  function delete_row2(obj,rowi)   
  { 
    var AgentPrice2 = document.getElementById('AgentPrice2');  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    AgentPrice2.deleteRow(rowIndex); 
  }
  
  function GetPersonType2()
  {
			var Adult=document.getElementById("tbAdultAllPrice").value;
			var Child=document.getElementById("tbChildAllPrice").value;
			
			var rowsnum2=Number(document.getElementById('rowsnum2').value);  
			
			for(var i=0;i<=rowsnum2;i++)
			{
					var tbAdultPrice2=document.getElementById("tbAdultPrice2"+i);
					var tbChildPrice2=document.getElementById("tbChildPrice2"+i);
					var tbAdultCommission2=document.getElementById("tbAdultCommission2"+i);
					var tbChildCommission2=document.getElementById("tbChildCommission2"+i);
					var tbAdultProfit2=document.getElementById("tbAdultProfit2"+i);
					var tbChildProfit2=document.getElementById("tbChildProfit2"+i);
					
					tbAdultProfit2.value=tbAdultPrice2.value-Adult-tbAdultCommission2.value;
					tbChildProfit2.value=tbChildPrice2.value-Child-tbChildCommission2.value;
			}
	
			var rowsnum1=Number(document.getElementById('rowsnum1').value);  
			
			for(var i=0;i<=rowsnum1;i++)
			{
					var tbAdultPrice1=document.getElementById("tbAdultPrice1"+i);
					var tbChildPrice1=document.getElementById("tbChildPrice1"+i);
					var tbAdultCommission1=document.getElementById("tbAdultCommission1"+i);
					var tbChildCommission1=document.getElementById("tbChildCommission1"+i);
					var tbAdultProfit1=document.getElementById("tbAdultProfit1"+i);
					var tbChildProfit1=document.getElementById("tbChildProfit1"+i);
					
//					tbAdultPrice2.value=Number(Adult)+Number(tbAdultProfit2.value)+Number(tbAdultCommission2.value);
//					tbChildPrice2.value=Number(Child)+Number(tbChildProfit2.value)+Number(tbChildCommission2.value);
					tbAdultProfit1.value=tbAdultPrice1.value-Adult-tbAdultCommission1.value;
					tbChildProfit1.value=tbChildPrice1.value-Child-tbChildCommission1.value;


			}
	
	
	
  }
  
  var thisvalue2="";
  var isok2="1";
  function Getthisvalue2(obj)
  {
    //alert(thisvalue+','+isok);
    if(isok2=="1")
    {
        thisvalue2=obj.value;
        isok2="0";
    }    
  }
  function Checkthisvalue2(obj)
  {
  //alert(thisvalue+','+isok);
    if(isok2=="0")
    {
        if(checkRate(obj.value))
        {
            GetPersonType2();
            isok2="1";            
        }
        else
        {
            if(obj.value!="")
            {
                obj.value=thisvalue2;
                alert("请输入数字！");
            }
        }
        thisvalue2="";
    }
    else
    {
        return "";
    }
}

///代理商销售价结束
/////////////////////////////////////////////////////////////////////////////////////////////////


  ///////////////////////////////////////////////////////////////////////////////////////////
  ///成本项
  //var i=0;
  var i=Number(document.getElementById('rowsnum0').value);  
  function insert_row()
  {
		  i++;
		  var lineprice = document.getElementById('lineprice');     
		  R=lineprice.insertRow(-1);  
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='chengbenID0"+i+"' type='hidden' name='chengbenID0"+i+"' />"+"<select id='tbType0"+i+"' name='tbType0"+i+"'><option value=''>请选择</option></select>";
		  GetTypeSelect(document.getElementById('tbType0'+i));
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbSummary0"+i+"' type='text' name='tbSummary0"+i+"' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbPrice0"+i+"' type='text' name='tbPrice0"+i+"' onkeydown='Getthisvalue(this)' onkeyup='Checkthisvalue(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbNum0"+i+"' type='text' name='tbNum0"+i+"'  value='1' onkeydown='Getthisvalue(this)' onkeyup='Checkthisvalue(this)'/>";
		  C=R.insertCell(-1);
		  C.innerHTML="<input id='tbOrder0"+i+"' type='text' name='tbOrder0"+i+"' value='1' onkeydown='Getthisvalue(this)' onkeyup='Checkthisvalue(this)' />";
		  C=R.insertCell(-1);
		  C.innerHTML="<select id='tbPriceType0"+i+"' name='tbPriceType0"+i+"' onchange='GetPersonType()'><option value='全部'>全部</option><option value='成人'>成人</option><option value=''>儿童'>儿童</option></select>";
		  C=R.insertCell(-1);
		  C.innerHTML+="<a style='cursor:pointer;color:blue' onclick='delete_row(this,"+i+")'>删除</a>"; 
 		  document.getElementById('rowsnum0').value ++;
  }
  
  function   delete_row(obj,rowi)   
  { 
    var lineprice = document.getElementById('lineprice');  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    lineprice.deleteRow(rowIndex); 
    
    GetPersonType();
  }   
  
  function checkdata()
  {
			var rowsnum0=Number(document.getElementById('rowsnum0').value);  
			for(var i=0;i<=rowsnum0;i++)
			{
					var typename=document.getElementById("tbType0"+i);
					var price=document.getElementById("tbPrice0"+i);
					var order=document.getElementById("tbOrder0"+i);
							 if(typename.value=="")
							 {
								alert("请选择类型！");
								typename.focus()
								return false;
							 }
							 if(price.value=="")
							 {
								alert("请填写价格！");
								price.focus()
								return false;
							 }
							 if(order.value=="")
							 {
								alert("请填写次数！");
								order.focus()
								return false;
							 }
			}
			
			var ddlAgentType=document.getElementById("ddlAgentType");
			
			if(ddlAgentType.value=="Batch")
			{  
				var rowsnum1=Number(document.getElementById('rowsnum1').value);  
				for(var i=0;i<=rowsnum1;i++)
				{
						var AdultPrice=document.getElementById("tbAdultPrice1"+i);
						var ChildPrice=document.getElementById("tbChildPrice1"+i);
						var AdultCommission=document.getElementById("tbAdultCommission1"+i);
						var ChildCommission=document.getElementById("tbChildCommission1"+i);
			
						if(AdultPrice.value=="")
						{
							alert("请填写成人价格！");
										AdultPrice.focus()
										return false;
						}
						if(ChildPrice.value=="")
						{
							alert("请填写儿童价格！");
										ChildPrice.focus()
										return false;
						}
						if(AdultCommission.value=="")
						{
							alert("请填写成人佣金！");
										AdultCommission.focus()
										return false;
						}
						if(ChildCommission.value=="")
						{
							alert("请填写儿童佣金！");
										ChildCommission.focus()
										return false;
						}
				}
			}
			else if(ddlAgentType.value=="MultipleChoice")
			{
				
				
				var rowsnum2=Number(document.getElementById('rowsnum2').value);  
				for(var i=0;i<=rowsnum2;i++)
				{
						var AgentName=document.getElementById("AgentName2"+i);
						var AgentID=document.getElementById("AgentID2"+i);
						var AdultPrice=document.getElementById("tbAdultPrice2"+i);
						var ChildPrice=document.getElementById("tbChildPrice2"+i);
						var AdultCommission=document.getElementById("tbAdultCommission2"+i);
						var ChildCommission=document.getElementById("tbChildCommission2"+i);
						var AgentID=document.getElementById("AgentID2"+i);
						if(AgentName.value=="")
						{
							alert("请选择代理商！");
										return false;
						}
						if(AgentID.value=="" || AgentID.value==0 )
						{
							alert("请选择代理商！");
										return false;
						}
						if(AdultPrice.value=="")
						{
							alert("请填写成人价格！");
										AdultPrice.focus()
										return false;
						}
						if(ChildPrice.value=="")
						{
							alert("请填写儿童价格！");
										ChildPrice.focus()
										return false;
						}
						if(AdultCommission.value=="")
						{
							alert("请填写成人佣金！");
										AdultCommission.focus()
										return false;
						}
						if(ChildCommission.value=="")
						{
							alert("请填写儿童佣金！");
										ChildCommission.focus()
										return false;
						}
				}
			}
			
			//return false;
			return true;
  }
  function checkRate(input) //判断是否是数字
    { 
         var re = /^[0-9]+[.]?[0-9]*$/;   //判断字符串是否为数字     //判断正整数 /^[1-9]+[0-9]*]*$/   
         if (!re.test(input)) 
         {     
            return false; 
         }
         return true;
    }


  function GetPersonType()
  {
	  
	  
		
	    var rowsnum0=Number(document.getElementById('rowsnum0').value);  
		
		var Adult=0;
		var Child=0;
		
		for(var i=0;i<=rowsnum0;i++)
		{
			
			var price=document.getElementById("tbPrice0"+i);
			var num=document.getElementById("tbNum0"+i);
			var order=document.getElementById("tbOrder0"+i);
			var PriceType=document.getElementById("tbPriceType0"+i);
			
			 if(PriceType.value=="全部")
			 {
				Adult+=(price.value*num.value*order.value);
				Child+=(price.value*num.value*order.value);
			 }
			 if(PriceType.value=="成人")
			 {
				Adult+=(price.value*num.value*order.value);
			 }
			 if(PriceType.value=="儿童")
			 {
				Child+=(price.value*num.value*order.value);
			 } 
	   }
	   
		document.getElementById("tbAdultAllPrice").value=Adult;
		document.getElementById("tbChildAllPrice").value=Child;
		
		
		GetPersonType2();
		GetPersonType3();
  }
  
  var thisvalue="";
  var isok="1";
  function Getthisvalue(obj)
  {
    //alert(thisvalue+','+isok);
    if(isok=="1")
    {
        thisvalue=obj.value;
        isok="0";
    }    
  }
  function Checkthisvalue(obj)
  {
  //alert(thisvalue+','+isok);
    if(isok=="0")
    {
        if(checkRate(obj.value))
        {
            GetPersonType();
            isok="1";
        }
        else
        {
            if(obj.value!="")
            {
                obj.value=thisvalue;
                alert("请输入数字！");
            }
        }
        thisvalue="";
    }
    else
    {
        return "";
    }
}
///成本项结束
/////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////
///合作伙伴
//var n=0;
var n=Number(document.getElementById('rowsnum3').value);  
  function insert_rowCom()
  {
	  n++;
	  //代理商选择类别
	  var Companytable = document.getElementById('Companytable');     
	  R=Companytable.insertRow(-1); 
	  
	  C=R.insertCell(-1);
	  C.innerHTML="<input id='shoujiaID3"+n+"' type='hidden' name='shoujiaID3"+n+"' />"+"<input id='CompanyName3"+n+"' name='CompanyName3"+n+"' type='text'  readonly='readonly' /><input id='CompanyID3"+n+"' name='CompanyID3"+n+"' type='hidden' />";
	  C=R.insertCell(-1);
	  C.innerHTML="<a id='aChoiceCom"+n+"' style='cursor:pointer;color:blue' onclick='openSub(" + n + ");'>选择</a>";
	  
	  C=R.insertCell(-1);
	  C.innerHTML="<input id='tbAdultPrice3"+n+"' name='tbAdultPrice3"+n+"' type='text' style='width:100px' onkeydown='Getthisvalue3(this)' onkeyup='Checkthisvalue3(this)' />";
	  C=R.insertCell(-1);
	  C.innerHTML="<input id='tbChildPrice3"+n+"' name='tbChildPrice3"+n+"' type='text' style='width:100px' onkeydown='Getthisvalue3(this)' onkeyup='Checkthisvalue3(this)' />";
	  C=R.insertCell(-1);
	  C.innerHTML="<input id='tbAdultCommission3"+n+"' name='tbAdultCommission3"+n+"' type='text' style='width:100px' onkeydown='Getthisvalue3(this)' onkeyup='Checkthisvalue3(this)' />";
	  C=R.insertCell(-1);
	  C.innerHTML="<input id='tbChildCommission3"+n+"' name='tbChildCommission3"+n+"' type='text' style='width:100px' onkeydown='Getthisvalue3(this)' onkeyup='Checkthisvalue3(this)' />";
	  C=R.insertCell(-1);
	  C.innerHTML="<input id='tbAdultProfit3"+n+"' name='tbAdultProfit3"+n+"' type='text' style='width:100px' />";
	  C=R.insertCell(-1);
	  C.innerHTML="<input id='tbChildProfit3"+n+"' name='tbChildProfit3"+n+"' type='text' style='width:100px' />";
	  C=R.insertCell(-1);
	  C.innerHTML+="<a style='cursor:pointer;color:blue' onclick='delete_rowCom(this,"+n+")'>删除</a>";  
	  document.getElementById('rowsnum3').value ++;
  }
  
  function delete_rowCom(obj,rowi)
  { 
    var Companytable = document.getElementById('Companytable');  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    Companytable.deleteRow(rowIndex); 
  }
  
  
  function GetPersonType3()
  {
			var rowsnum3=Number(document.getElementById('rowsnum3').value);  
			  
			var Adult=document.getElementById("tbAdultAllPrice").value;
			var Child=document.getElementById("tbChildAllPrice").value;
			
				for(var i=0;i<=rowsnum3;i++)
				{
					
					var tbAdultPrice3=document.getElementById("tbAdultPrice3"+i);
					var tbChildPrice3=document.getElementById("tbChildPrice3"+i);
					var tbAdultCommission3=document.getElementById("tbAdultCommission3"+i);
					var tbChildCommission3=document.getElementById("tbChildCommission3"+i);
					var tbAdultProfit3=document.getElementById("tbAdultProfit3"+i);
					var tbChildProfit3=document.getElementById("tbChildProfit3"+i);
					
					tbAdultProfit3.value=tbAdultPrice3.value-Adult-tbAdultCommission3.value;
					tbChildProfit3.value=tbChildPrice3.value-Child-tbChildCommission3.value;
					
				}
  }
  
  var thisvalue3="";
  var isok3="1";
  function Getthisvalue3(obj)
  {
    //alert(thisvalue+','+isok);
    if(isok3=="1")
    {
        thisvalue3=obj.value;
        isok3="0";
    }    
  }
  function Checkthisvalue3(obj)
  {
  //alert(thisvalue+','+isok);
    if(isok3=="0")
    {
        if(checkRate(obj.value))
        {
            GetPersonType3();
            isok3="1";            
        }
        else
        {
            if(obj.value!="")
            {
                obj.value=thisvalue3;
                alert("请输入数字！");
            }
        }
        thisvalue3="";
    }
    else
    {
        return "";
    }
}
///合作伙伴结束
/////////////////////////////////////////////////////////////////////////////////////////////////
