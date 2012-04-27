// JScript 文件
////////////////////////////////////////////////////////////////////////////////////////////////
///机票
function GetPersonType2()
{
    var Price=document.getElementById("tbCostPrice").value;//成本

    var Agentprice=document.getElementsByName("tbSettlementPrice");//代理商价
    var Profit=document.getElementsByName("tbProfit");
    var Commission=document.getElementsByName("tbCommission");
    if(Agentprice.length>0)
    {
        for(var i=0;i<Agentprice.length;i++)
        {
            Agentprice[i].value=Number(Commission[i].value)+Number(Price)+Number(Profit[i].value);
        }
    }

    var Agentprice2=document.getElementsByName("tbSettlementPrice2");
    var Profit2=document.getElementsByName("tbProfit2");
    var Commission2=document.getElementsByName("tbCommission2");
    if(Agentprice2.length>0)
    {
        for(var i=0;i<Agentprice2.length;i++)
        {
            Agentprice2[i].value=Number(Commission2[i].value)+Number(Price)+Number(Profit2[i].value);
        }
    }
    
    var InnerPrice=document.getElementById("tbInnerPrice");
    var InnerProfit=document.getElementById("tbInnerProfit");
    if(InnerPrice&&InnerProfit)
    {
        InnerPrice.value=Number(InnerProfit.value)+Number(Price);
    }
}
  
var thisvalue2="";
var isok2="1";
function Getthisvalue2(obj)
{
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



function GetCaoZuoType(obj)
{
    if(confirm("确定要修改代理商选择类别？"))
    {
        if(obj.value=="Batch")
        {
            document.getElementById('AgentPrice').style.display="";
            document.getElementById('AgentPrice2').style.display="none";
        }
        if(obj.value=="MultipleChoice")
        {
            document.getElementById('AgentPrice').style.display="none";
            document.getElementById('AgentPrice2').style.display="";
        }
    }
    else
    {
        if(obj.value=="Batch")
        {
            obj.value="MultipleChoice";
        }
        else if(obj.value=="MultipleChoice")
        {
            obj.value="Batch";
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


function insert_row1(){
	var values1 = Number(document.getElementById('rowsnum2').value);
	var j = values1 + 1;
//代理商选择类别
var AgentPrice = document.getElementById('AgentPrice');     
R=AgentPrice.insertRow(-1); 

C=R.insertCell(-1);
C.innerHTML="<select id='slAgentType"+j+"' name='slAgentType'  onchange='GetAgentType(this)'><option value='全部'>全部</option><option value='门市'>门市</option><option value='同业'>同业</option></select>";     
C=R.insertCell(-1);
C.innerHTML="<select id='slClass"+j+"' name='slClass'><option value='全部'>全部</option></select>";

C=R.insertCell(-1);
C.innerHTML="<input id='tbSettlementPrice"+j+"' name='tbSettlementPrice' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' readonly='readonly' />";
C=R.insertCell(-1);
C.innerHTML="<input id='tbCommission"+j+"' name='tbCommission' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
C=R.insertCell(-1);
C.innerHTML="<input id='tbProfit"+j+"' name='tbProfit' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";

C=R.insertCell(-1);
C.innerHTML+="<a id='prices"+j+"' style='color: blue;' class='del' onclick='add_price("+j+");'>确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick='delete_rows(this,"+j+")'>删除</a>"; 
document.getElementById('rowsnum2').value++;
}

function delete_rows(obj,rowi)   
{ 
    var AgentPrice = document.getElementById('AgentPrice');  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    AgentPrice.deleteRow(rowIndex); 
}   



function insert_row2(){
var values2 = Number(document.getElementById('rowsnum2').value);
var m = values2 + 1;
//代理商选择类别
var AgentPrice2 = document.getElementById('AgentPrice2');     
R=AgentPrice2.insertRow(-1); 

C=R.insertCell(-1);
C.innerHTML="<input id='AgentName2"+m+"' name='AgentName2' type='text'  readonly='readonly' /><input id='AgentID2"+m+"' name='AgentID2' type='hidden' />";
C=R.insertCell(-1);
C.innerHTML="<a id='AChoice2"+m+"' style='cursor:pointer;color:blue' onclick='openSub(\"AgentName2\",\"AgentID2\",\"" + m + "\");'>选择</a>";

C=R.insertCell(-1);
C.innerHTML="<input id='tbSettlementPrice2"+m+"' name='tbSettlementPrice2' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' readonly='readonly' />";
C=R.insertCell(-1);
C.innerHTML="<input id='tbCommission2"+m+"' name='tbCommission2' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
C=R.insertCell(-1);
C.innerHTML="<input id='tbProfit2"+m+"' name='tbProfit2' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";

C=R.insertCell(-1);
C.innerHTML+="<a id='agents"+m+"' style='cursor: pointer; color: blue;' onclick='add_price2(" + m + ")'>确认</a>&nbsp;&nbsp;<a style='cursor:pointer;color:blue' onclick='delete_row2(this,"+m+")'>删除</a>"; 
 
document.getElementById('rowsnum2').value ++;
}


function delete_row2(obj,rowi)
{ 
    var AgentPrice2 = document.getElementById('AgentPrice2');  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    AgentPrice2.deleteRow(rowIndex); 
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

function checkdata()
{
var CostPrice=document.getElementById("tbCostPrice");
var AllPrice=document.getElementById("tbAllPrice");
var TicketPrice=document.getElementById("tbTicketPrice");
var Discount=document.getElementById("tbDiscount");
var OutSidePrice=document.getElementById("tbOutSidePrice"); 
 var InnerPrice=document.getElementById("tbInnerPrice");
var InnerProfit=document.getElementById("tbInnerProfit"); 
 if(CostPrice.value=="")
 {
    alert("请填写成本价！");
    
    return false;
 }
 if(AllPrice.value=="")
 {
    alert("请填写机票全价！");
    
    return false;
 }
 if(TicketPrice.value=="")
 {
    alert("请填写票面价！");
    
    return false;
 }
 if(Discount.value=="")
 {
    alert("请填写折扣！");
   
    return false;
 }
 if(OutSidePrice.value=="")
 {
    alert("请填写外卖价！");
    
    return false;
 }
  if(InnerPrice.value=="")
 {
    alert("请填写内部结算价！");
    
    return false;
 }
  if(InnerProfit.value=="")
 {
    alert("请填写内部利润！");
    
    return false;
 }
    
var ddlAgentType=document.getElementById("ddlAgentType");

if(ddlAgentType.value=="Batch")
{

    var SettlementPrice=document.getElementsByName("tbSettlementPrice");
    
    //变色
    if(SettlementPrice.length>0)
    {
        for(var i=0;i<SettlementPrice.length;i++)
        {
            if(SettlementPrice[i].value=="")
            {
                SettlementPrice[i].className="textboxcolor";
            }
            else
            {
                SettlementPrice[i].className="";
            }
        }
    }
    
    if(SettlementPrice.length>0)
    {
        for(var i=0;i<SettlementPrice.length;i++)
        {
            if(SettlementPrice[i].value=="")
            {
                alert("请填写代理商结算价！");
                return false;
            }
        }
    }
}
else if(ddlAgentType.value=="MultipleChoice")
{
    var SettlementPrice=document.getElementsByName("tbSettlementPrice2");
    
    var AgentID=document.getElementsByName("AgentID2");
    if(SettlementPrice.length>0)
    {
        for(var i=0;i<SettlementPrice.length;i++)
        {
            if(AgentID[i].value=="")
            {
                alert("请选择代理商！");
                return false;
            }
            if(SettlementPrice[i].value=="")
            {
                alert("请填写代理商结算价！");
                return false;
            }
        }
    }
}

return true;
}
///机票结束
/////////////////////////////////////////////////////////////////////////////////////////////////

