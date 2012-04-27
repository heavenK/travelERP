///////////////////////////////////////////////////////////////////////////////////////////
  ///代理商销售价
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

  var j=0;
  function insert_row1(){
  j++;
  //代理商选择类别
  var AgentPrice = document.getElementById('AgentPrice');     
  R=AgentPrice.insertRow(-1); 
 
  C=R.insertCell(-1);
  C.innerHTML="<select id='slAgentType"+j+"' name='slAgentType'  onchange='GetAgentType(this)'><option value='all'>全部</option><option value='Store'>门市</option><option value='Industry'>同业</option></select>";     
  C=R.insertCell(-1);
  C.innerHTML="<select id='slClass"+j+"' name='slClass'><option value='all'>全部</option></select>";
  
 
  C=R.insertCell(-1);
  C.innerHTML="<input id='tbAdultCommission"+j+"' name='tbAdultCommission' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";

  C=R.insertCell(-1);
  C.innerHTML="<input id='tbAdultProfit"+j+"' name='tbAdultProfit' type='text' style='width:100px' />";
 
  C=R.insertCell(-1);
  C.innerHTML+="<a style='cursor:pointer;color:blue' onclick='delete_rows(this,"+j+")'>删除</a>"; 
  
  }
  
  function delete_rows(obj,rowi)   
  { 
    var AgentPrice = document.getElementById('AgentPrice');  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    AgentPrice.deleteRow(rowIndex); 
  }   
 
 
  var m=0;
  function insert_row2(){
  m++;
  //代理商选择类别
  var AgentPrice2 = document.getElementById('AgentPrice2');     
  R=AgentPrice2.insertRow(-1); 
  
  C=R.insertCell(-1);
  C.innerHTML="<input id='AgentName2"+m+"' name='AgentName2' type='text'  readonly='readonly' /><input id='AgentID2"+m+"' name='AgentID2' type='hidden' />";
  C=R.insertCell(-1);
  C.innerHTML="<a id='AChoice2"+m+"' style='cursor:pointer;color:blue' onclick='GetAgentList(this.id.replace(\"AChoice2"+m+"\",\"AgentName2"+m+"\"),this.id.replace(\"AChoice2"+m+"\",\"AgentID2"+m+"\"),\"agent\");'>选择</a>";
  
 
  C=R.insertCell(-1);
  C.innerHTML="<input id='tbAdultCommission2"+m+"' name='tbAdultCommission2' type='text' style='width:100px' onkeydown='Getthisvalue2(this)' onkeyup='Checkthisvalue2(this)' />";
  
  C=R.insertCell(-1);
  C.innerHTML="<input id='tbAdultProfit2"+m+"' name='tbAdultProfit2' type='text' style='width:100px' />";
 
  C=R.insertCell(-1);
  C.innerHTML+="<a style='cursor:pointer;color:blue' onclick='delete_row2(this,"+m+")'>删除</a>"; 
  
  }
  
  
  function delete_row2(obj,rowi)   
  { 
    var AgentPrice2 = document.getElementById('AgentPrice2');  
    var rowIndex   =   obj.parentNode.parentNode.rowIndex;  
    AgentPrice2.deleteRow(rowIndex); 
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
            //GetPersonType2();
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

function checkRate(input) //判断是否是数字
{ 
     var re = /^[0-9]+[.]?[0-9]*$/;   //判断字符串是否为数字     //判断正整数 /^[1-9]+[0-9]*]*$/   
     if (!re.test(input)) 
     {     
        return false; 
     }
     return true;
}
///代理商销售价结束
/////////////////////////////////////////////////////////////////////////////////////////////////