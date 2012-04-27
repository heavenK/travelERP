// JScript 文件
function MenuShowOrNone(NodeID)
{
    var menu=document.getElementById("node"+NodeID);
    if(menu)
    {
        if(menu.parentNode.parentNode.id!="")
        {
            var parentul=document.getElementById(menu.parentNode.parentNode.id);
            if(parentul)
            {
                var uls=parentul.getElementsByTagName("ul");
                if(uls.length>0)
                {
                    for(var i=0;i<uls.length;i++)
                    {
                        if(menu)
                        {
                            uls[i].style.display="none";
                        }
                    }
                }
            }
        }
    }
    
    if(menu)
    {
        if(menu.style.display=='none')
        {
            menu.style.display='';
        }
        else
        {
            menu.style.display='none';
        }
    }
    
    
    
    
// old   
//    var uls=document.getElementsByTagName("ul");
//    if(uls.length>0)
//    {
//        
//        for(var i=0;i<uls.length;i++)
//        {
//            if(menu)
//            {
//                if(uls[i].className=="nav2"&&uls[i].id!=menu.id)
//                    uls[i].style.display="none";
//            }
//            else
//            {
//                if(uls[i].className=="nav2")
//                    uls[i].style.display="none";
//            }
//        }
//    }
//    if(menu)
//    {
//        if(menu.style.display=="none") 
//        {
//            menu.style.display="";
//        } 
//        else 
//        {
//            menu.style.display="none";
//        }
//    }
}
