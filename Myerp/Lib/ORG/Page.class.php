<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <>
// +----------------------------------------------------------------------
// $Id$
class Page extends Think {
    // 起始行数
    public $firstRow ;
    // 列表每页显示行数
    public $listRows ;
    // 页数跳转时要带的参数
    public $parameter ;
    // 分页总页面数
    protected $totalPages ;
    // 总行数
    protected $totalRows ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
    // 分页栏每页显示的页数
    protected $rollPage   ;
// 分页显示定制
protected $script;
protected $up;
protected $down;
    protected $config = array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>' %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first% %prePage% %script% %up% %linkPage% %down% %nextPage% %end%');
    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $totalRows 总的记录数
     * @param array $listRows 每页显示记录数
     * @param array $parameter 分页跳转的参数
     +----------------------------------------------------------
     */
    public function __construct($totalRows,$listRows,$parameter='') {
        $this->totalRows = $totalRows;
        $this->parameter = $parameter;
        //$this->rollPage = C('PAGE_ROLLPAGE');
   $this->rollPage = 1000;
        $this->listRows = !empty($listRows)?$listRows:C('PAGE_LISTROWS');
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages = ceil($this->totalPages/$this->rollPage);
        $this->nowPage = !empty($_GET[C('VAR_PAGE')])?$_GET[C('VAR_PAGE')]:1;
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);
    }
    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }
    /**
     +----------------------------------------------------------
     * 分页显示输出
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p = C('VAR_PAGE');
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        $url = $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            unset($params[$p]);
            $url   = $parse['path'].'?'.http_build_query($params);
        }
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
    $theFirst = "<a href='".$url."&".$p."=1' >".$this->config['first']."</a>";
            $upPage="<a href='".$url."&".$p."=$upRow'>".$this->config['prev']."</a>";
        }else{
    $theFirst =$this->config['first'];
            $upPage=$this->config['prev'];   
        }

        if ($downRow <= $this->totalPages){   
            $downPage="<a href='".$url."&".$p."=$downRow'>".$this->config['next']."</a>";
        }else{
    $theFirst = "<a href='".$url."&".$p."=1' >".$this->config['first']."</a>";           
     $downPage=$this->config['next'];
        }
  
  
  
        // << < > >>
        if($nowCoolPage == 1){
         
        }else{
   
            $preRow = $this->nowPage-$this->rollPage;
           /// $prePage = "<a href='".$url."&".$p."=$preRow' >上".$this->rollPage."页</a>";
            $theFirst = "<a href='".$url."&".$p."=1' >".$this->config['first']."</a>";
        }
  
  
        if($this->nowPage == $this->totalPages){ //最后一夜
    // echo '-------'.$nowCoolPage.'----'.$this->totalPages.'---';
           // $nextPage = $this->config['next'];     
            $theEnd=$this->config['last'];
        }else{
    //echo '-------'.$nowCoolPage.'----'.$this->totalPages.'---';
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
           // $nextPage = "<a href='".$url."&".$p."=$nextRow' >下".$this->rollPage."页</a>";
            $theEnd = "<a href='".$url."&".$p."=$theEndRow' >".$this->config['last']."</a>";
        }
  
  
  
        // 1 2 3 4 5
   $script='<script type="text/javascript">
<!--
function MM_jumpMenu(selObj){ //v3.0
var url=selObj.options[selObj.selectedIndex].value;
window.location = url;
}
//-->
</script>';
   $up='<select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu(this)">';
        $linkPage = "";
   $down='</select>';
   $selected="";
  
   
        for($i=1;$i<=$this->rollPage;$i++){
    $page=($nowCoolPage-1)*$this->rollPage+$i;

   
           
            if($page!=$this->nowPage){
    
                if($page<=$this->totalPages){
                 //   $linkPage .= "&nbsp;<a href='".$url."&".$p."=$page'>&nbsp;".$page."&nbsp;</a>";
      $ul = $url."&".$p."=".$page;
    if( $this->nowPage == $page)//判断当点跳转菜单显示的页
    {
     $selected = 'selected="selected"';
     $linkPage .="<option value=\"$ul\" $selected >第 $page 页</option>";
    
    }else{
     $linkPage .="<option value=\"$ul\">第 $page 页</option>";
    }
   
     
                }else{
                    break;
                }
            }else{
    
                if($this->totalPages != 1){
         
      if( $this->nowPage == $page) //判断当点跳转菜单显示的页面
      {
       $selected = 'selected="selected"';
       $linkPage .="<option value=\"$ul\" $selected >第 $page 页</option>";
      }else{
       $linkPage .="<option value=\"$ul\">第 $page 页</option>";
      }
    
                }else
     {
      $linkPage .="<option>总页数</option><option value=\"$ul\" $selected >第 1 页</option>";
      }
            }
        }
        $pageStr = str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%script%','%up%','%linkPage%','%down%','%nextPage%','%end%'),
            array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$theFirst,$upPage,$downPage,$theEnd,$script,$up,$linkPage,$down,$nextPage,$prePage),$this->config['theme']);
        return $pageStr;
    }
}



	







?>