  function GetCaoZuoType(obj)
  {
      if(confirm("确定要修改代理商选择类别？"))
      {
          if(obj.value=="Batch")
          {
            document.getElementById('xuanzetype').value="Batch";
			
			$(".batchdiv").show();
			$(".multiplediv").hide();
          }
          if(obj.value=="MultipleChoice")
          {
            document.getElementById('xuanzetype').value="MultipleChoice";
			$(".multiplediv").show();
			$(".batchdiv").hide();
          }
      }
  }
  
 
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
 
  function insert_row_chengben()
  {
	  var jnum=Number(document.getElementById('rowsnum4').value);
	  var j = jnum + 1;
      var htmlcontent = "<ul onmouseover=\"this.style.backgroundColor='#bce5df'\" onmouseout=\"this.style.backgroundColor=''\" id='list_chengben_div1"+j+"'><input type='hidden' name='chengbenyongyouID[]' value='"+j+"' />";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lid\"><input id=\"renshu1"+j+"\" type=\"text\" name=\"renshu1"+j+"\" /></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lic\"  style=\"width:450px;\"><input style=\"width:415px;\" id=\"miaoshu1"+j+"\" type=\"text\" name=\"miaoshu1"+j+"\" /></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lid\"><input id=\"chengben1"+j+"\" type=\"text\" name=\"chengben1"+j+"\" /></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lii\"><a href=\"javascript:delete_row_chengben('"+j+"')\" >删除</a></li></ul>";
	  $(".cbDIV").append(htmlcontent);	  
 	  document.getElementById('rowsnum4').value ++;
		  
		  
  }

  function insert_row1()
  {
	  var jnum=Number(document.getElementById('rowsnum1').value);
	  var j = jnum + 1;
      var htmlcontent = "<ul onmouseover=\"this.style.backgroundColor='#bce5df'\" onmouseout=\"this.style.backgroundColor=''\" id='listdiv1"+j+"'> <input type='hidden' name='BatchcaozuoID[]' value='"+j+"'/> ";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lia\"><select id=\"slAgentType1"+j+"\" name=\"slAgentType1"+j+"\" onchange=\"GetAgentType(this)\"><option value=\"全部\">全部</option><option value=\"直营门市\">直营门市</option><option value=\"加盟门市\">加盟门市</option><option value=\"联合体\">联合体</option><option value=\"办事处\">办事处</option></select></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lic\"><input id=\"tbAdultPrice1"+j+"\" type=\"text\" name=\"tbAdultPrice1"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\" ></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lid\"><input id=\"tbChildPrice1"+j+"\" type=\"text\" name=\"tbChildPrice1"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\" ></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lie\"><input id=\"tbAdultCommission1"+j+"\" type=\"text\" name=\"tbAdultCommission1"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lif\"><input id=\"tbChildCommission1"+j+"\" type=\"text\" name=\"tbChildCommission1"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lih\"><input id=\"tbCut1"+j+"\" type=\"text\" name=\"tbCut1"+j+"\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lig\"><input id=\"tbAdultProfit1"+j+"\" type=\"text\" name=\"tbAdultProfit1"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\" readonly=\"readonly\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lih\"><input id=\"tbChildProfit1"+j+"\" type=\"text\" name=\"tbChildProfit1"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\" readonly=\"readonly\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lii\"><a href=\"javascript:delete_rows('"+j+"')\" >删除</a></li></ul>";
	  
		$(".batchdiv").append(htmlcontent);	  
 		document.getElementById('rowsnum1').value ++;
		  
		  
  }
  
  function delete_rows(rowi)   
  { 
  
	  $("#listdiv1"+rowi).remove();	  
  }   
  
  function delete_row_chengben(rowi){
	   $("#list_chengben_div1"+rowi).remove();	  
  }
 
 
  function insert_row2()
  {
	  var jnum=Number(document.getElementById('rowsnum2').value);
	  var j = jnum + 1;
      var htmlcontent = "<ul onmouseover=\"this.style.backgroundColor='#bce5df'\" onmouseout=\"this.style.backgroundColor=''\" id='listdiv2"+j+"'> <input type='hidden' name='MultipleChoicecaozuoID[]' value='"+j+"'/> <li class=\"hlt_fit_price_agents_lia\"><input style=\"width:50px;\" id=\"AgentName2"+j+"\" name=\"AgentName2"+j+"\" type=\"text\" readonly=\"readonly\"><input id=\"AgentID2"+j+"\" name=\"AgentID2"+j+"\" type=\"hidden\"><a id=\"aChoiceCom\" href=\"javascript:openSub('AgentName2','AgentID2','"+j+"');\">选择</a></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lic\"><input id=\"tbAdultPrice2"+j+"\" type=\"text\" name=\"tbAdultPrice2"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\" ></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lid\"><input id=\"tbChildPrice2"+j+"\" type=\"text\" name=\"tbChildPrice2"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\" ></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lie\"><input id=\"tbAdultCommission2"+j+"\" type=\"text\" name=\"tbAdultCommission2"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lif\"><input id=\"tbChildCommission2"+j+"\" type=\"text\" name=\"tbChildCommission2"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lih\"><input id=\"tbCut2"+j+"\" type=\"text\" name=\"tbCut2"+j+"\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lig\"><input id=\"tbAdultProfit2"+j+"\" type=\"text\" name=\"tbAdultProfit2"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\" readonly=\"readonly\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lih\"><input id=\"tbChildProfit2"+j+"\" type=\"text\" name=\"tbChildProfit2"+j+"\" onkeydown=\"Getthisvalue2(this)\" onkeyup=\"Checkthisvalue2(this)\" readonly=\"readonly\"></li>";
	  htmlcontent += "<li class=\"hlt_fit_price_agents_lii\"><a href=\"javascript:delete_row2('"+j+"')\" >删除</a></li></ul>";
	  
		$(".multiplediv").append(htmlcontent);	  
 		document.getElementById('rowsnum2').value ++;
	 	  
  }
  
  
  function delete_row2(rowi)   
  { 
	  $("#listdiv2"+rowi).remove();	  
  }
  
  function GetPersonType2()
  {
			var Adult=document.getElementById("tbAdultAllPrice").value;
			var Child=document.getElementById("tbChildAllPrice").value;
			
			var xuanzetype = document.getElementById('xuanzetype').value;
			var rowsnum2=Number(document.getElementById('rowsnum2').value);  
			
			if(xuanzetype == "MultipleChoice"){
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
			}
			var rowsnum1=Number(document.getElementById('rowsnum1').value);  
			if(xuanzetype == "Batch"){
				for(var i=0;i<=rowsnum1;i++)
				{
					var tbAdultPrice1=document.getElementById("tbAdultPrice1"+i);
					var tbChildPrice1=document.getElementById("tbChildPrice1"+i);
					var tbAdultCommission1=document.getElementById("tbAdultCommission1"+i);
					var tbChildCommission1=document.getElementById("tbChildCommission1"+i);
					var tbAdultProfit1=document.getElementById("tbAdultProfit1"+i);
					var tbChildProfit1=document.getElementById("tbChildProfit1"+i);
					
					tbAdultProfit1.value=tbAdultPrice1.value-Adult-tbAdultCommission1.value;
					tbChildProfit1.value=tbChildPrice1.value-Child-tbChildCommission1.value;
	
	
				}
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

  function insert_row()
  {
		var inum=Number(document.getElementById('rowsnum0').value);  
	  	i = inum + 1;
		var htmlcontent =  "<ul onmouseover=\"this.style.backgroundColor='#bce5df'\" onmouseout=\"this.style.backgroundColor=''\" id=\"listdiv0"+i+"\"> <input type='hidden' name='chengbencaozuoID[]' value='"+i+"'/>	<li class=\"hlt_fit_price_cost_lia\"><select id=\"tbType0"+i+"\" name=\"tbType0"+i+"\"><option value=\"导游\">导游</option><option value=\"门票\">门票</option><option value=\"其他\">其它</option><option value=\"地接综费\">地接综费</option><option value=\"餐\">餐</option><option value=\"房\">房</option><option value=\"车（小交通）\">车（小交通）</option><option value=\"火车票\">火车票</option><option value=\"船票\">船票</option><option value=\"机票\">机票</option><option value=\"保险\">保险</option></select></li><li class=\"hlt_fit_price_cost_lib\"><input id=\"tbSummary0"+i+"\" type=\"text\" name=\"tbSummary0"+i+"\" ></li><li class=\"hlt_fit_price_cost_lic\"><input id=\"tbPrice0"+i+"\" type=\"text\" name=\"tbPrice0"+i+"\" onkeydown=\"Getthisvalue(this)\" onkeyup=\"Checkthisvalue(this)\"></li><li class=\"hlt_fit_price_cost_lid\"><input id=\"tbNum0"+i+"\" type=\"text\" name=\"tbNum0"+i+"\" value='1'  onkeydown=\"Getthisvalue(this)\" onkeyup=\"Checkthisvalue(this)\"></li><li class=\"hlt_fit_price_cost_lie\"><input id=\"tbOrder0"+i+"\" type=\"text\" name=\"tbOrder0"+i+"\" value='1' onkeydown=\"Getthisvalue(this)\" onkeyup=\"Checkthisvalue(this)\"></li><li class=\"hlt_fit_price_cost_lif\"><select id=\"tbPriceType0"+i+"\" name=\"tbPriceType0"+i+"\" onchange=\"GetPersonType()\"><option value=\"全部\">全部</option><option value=\"成人\">成人</option><option value=\"儿童\">儿童</option></select></li><li class=\"hlt_fit_price_cost_lig\"><a href=\"javascript:delete_row('"+i+"')\" >删除</a></li></ul>";
					
		$(".chengbendiv").append(htmlcontent);	  
 		document.getElementById('rowsnum0').value ++;
  }
  
  function delete_row(rowi)   
  { 
		$("#listdiv0"+rowi).remove();
 		document.getElementById('rowsnum0').value --;
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
//						if(AgentID.value=="" || AgentID.value==0 )
//						{
//							alert("请选择代理商！");
//										return false;
//						}
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
		//GetPersonType3();
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
  function insert_rowCom()
  {
	  
	  var jnum=Number(document.getElementById('rowsnum3').value);
	  var j = jnum + 1;
      var htmlcontent = "<ul onmouseover=\"this.style.backgroundColor='#bce5df'\" onmouseout=\"this.style.backgroundColor=''\" id='listdiv3"+j+"'> <input type='hidden' name='huobancaozuoID[]' value='"+j+"'/> <li class=\"hlt_fit_price_agents_lia\"><input style=\"width:80px;\" id=\"CompanyName3"+j+"\" name=\"CompanyName3"+j+"\" type=\"text\" readonly=\"readonly\"><input id=\"CompanyID3"+j+"\" name=\"CompanyID3"+j+"\" type=\"hidden\"></li><li class=\"hlt_fit_price_agents_lib\"><a id=\"aChoiceCom\" href=\"javascript:openSub('CompanyName3','CompanyID3','"+j+"');\">选择</a></li><li class=\"hlt_fit_price_agents_lic\"><input id=\"tbAdultPrice3"+j+"\" type=\"text\" name=\"tbAdultPrice3"+j+"\" onkeydown=\"Getthisvalue3(this)\" onkeyup=\"Checkthisvalue3(this)\" ></li><li class=\"hlt_fit_price_agents_lid\"><input id=\"tbChildPrice3"+j+"\" type=\"text\" name=\"tbChildPrice3"+j+"\" onkeydown=\"Getthisvalue3(this)\" onkeyup=\"Checkthisvalue3(this)\" ></li><li class=\"hlt_fit_price_agents_lie\"><input id=\"tbAdultCommission3"+j+"\" type=\"text\" name=\"tbAdultCommission3"+j+"\" onkeydown=\"Getthisvalue3(this)\" onkeyup=\"Checkthisvalue3(this)\"></li><li class=\"hlt_fit_price_agents_lif\"><input id=\"tbChildCommission3"+j+"\" type=\"text\" name=\"tbChildCommission3"+j+"\" onkeydown=\"Getthisvalue3(this)\" onkeyup=\"Checkthisvalue3(this)\"></li><li class=\"hlt_fit_price_agents_lig\"><input id=\"tbAdultProfit3"+j+"\" type=\"text\" name=\"tbAdultProfit3"+j+"\" onkeydown=\"Getthisvalue3(this)\" onkeyup=\"Checkthisvalue3(this)\" readonly=\"readonly\"></li><li class=\"hlt_fit_price_agents_lih\"><input id=\"tbChildProfit3"+j+"\" type=\"text\" name=\"tbChildProfit3"+j+"\" onkeydown=\"Getthisvalue3(this)\" onkeyup=\"Checkthisvalue3(this)\" readonly=\"readonly\"></li><li class=\"hlt_fit_price_agents_lii\"><a href=\"javascript:delete_rowCom('"+j+"')\" >删除</a></li></ul>";
	  
		$(".hezuodiv").append(htmlcontent);	  
 		document.getElementById('rowsnum3').value ++;
		
		
	  
  }
  
  function delete_rowCom(rowi)
  { 

		$('#listdiv3'+rowi).remove();
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
