<?php

function sizecount($filesize) {
	if($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
	} elseif($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
	} elseif($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	} else {
		$filesize = $filesize . ' Bytes';
	}
	return $filesize;
}

function jbtype($id) {
    if ($id==1) {
        return '涉及黄色和暴力';
    } else if ($id==2) {
        return '政治反动';
    } else if ($id==3) {
        return '内容侵权';
    } else if ($id==4) {
        return '其他不良信息';
    }
}
function sidedef($name) {
    if ($name=='hottopic') {
        return '热门话题';
    } else if ($name=='hotuser') {
        return '人气用户推荐';
    } else if ($name=='bangnormal') {
        return '人气之星榜';
    } else if ($name=='bangvip') {
        return '认证名人榜';
    } else if ($name=='userfollower') {
        return 'TA的听众';
    } else if ($name=='userfollowing') {
        return 'TA收听的';
    } else {
        return '自定义';
    }
}

function tiaozhuan($rurl)
{
	echo '<script type="text/javascript">window.location.href="'.$rurl.'"</script>';
}

function doalert($word="",$url="",$target="self")
{
		if($_REQUEST["forward"]!=''){
			$url	=	$_REQUEST["forward"];
		}elseif($url==""){
			$url	=	$_SERVER['HTTP_REFERER'];
		}
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>$word</title><script type=\"text/javascript\" >alert('$word');$target.location='$url';</script>
</head><body></body></html>";
		exit;
}


function justalert($word="")
{
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>$word</title><script type=\"text/javascript\" >alert('$word');</script>
</head><body></body></html>";
}

function gethistoryback()
{
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><script type=\"text/javascript\" >history.go(-1);</script></head><body></body></html>";
		exit;
}


function jisuanriqi($date,$num,$mark = '增加')
{
	  if($mark == '增加')
		$num -= 1;
	  $date = strtotime($date);
	  $tianshu = 60 * 60 *24 * $num; 
	  if($mark == '增加')
	  $shijian = date('Y-m-d',($date + $tianshu));
	  if($mark == '减少')
	  $shijian = date('Y-m-d',($date - $tianshu));
	  
	  return $shijian;
}

function islock($tablename,$idname,$id) {

			$condition['islock'] = '已锁定';
			$condition[$idname] = $id;
			$warning = $tablename->where($condition)->find();
			if($warning)
			{
				return $warning;
			}

	}


function getDirFiles($dir)   
{   
	if ($handle = opendir($dir)){   
		while (false !== ($file = readdir($handle))) {   
			$files[]=$file;   
		 }   
	}   
	   closedir($handle);   
	if($files) return $files;   
	else return false;   
}   


function checkUserAdmin($action)   
{ 
	$parameterlist = split('/',$_SERVER["PATH_INFO"]);
	for($i = 0; $i< count($parameterlist);$i++){
		if($parameterlist[$i] == 'guojing')
			$extparameter =  ':jingwai';
		if($parameterlist[$i] == 'send' and $parameterlist[$i + 1] == 'type' )
			$extparameter =  ':'.$parameterlist[$i + 2];
	}
	if($parameterlist[2])
	$actionpath =  $parameterlist[1].':'.$parameterlist[2].$extparameter;
	else
	$actionpath =  $parameterlist[1].$extparameter;
	
	$adminpool = $action->adminuser['adminpool'];
	$alist=split(',',$adminpool);
	foreach($alist as $a){
		if(strtolower($a) == strtolower($actionpath))
		return true;
	}
	return false;
//	$c=explode($actionpath,$adminpool);
//	if(count($c)>1)
//		return true;
//	else
//		return false;

}   



function xianluIsAdmin($id,$action,$forward = '')   
{   
	if(!$forward)
	//$forward = SITE_ADMIN."Chanpin/sankechanpin";
	$forward = '';
	
	$Glxianlu = D("Glxianlu");
	$xianlu = $Glxianlu->where("`xianluID` = '$id'")->find();
	
	if(!$xianlu)
		doalert('错误，线路不存在',$forward);
	else
	{
		if(checkByAdminlevel('网管,总经理',$action)){
			return true;
		}
		if($xianlu['user_name'] == $action->roleuser['user_name'])
		return true;
		else
		doalert('您无权修改别人的产品信息',$forward);
	}

}   


function xianluIsDepartment($id,$action,$forward = '')   
{   
	if(!$forward)
	//$forward = SITE_ADMIN."Chanpin/sankechanpin";
	$forward = '';
	
	$Glxianlu = D("Glxianlu");
	$xianlu = $Glxianlu->where("`xianluID` = '$id'")->find();
	
	if(!$xianlu)
		doalert('错误，线路不存在',$forward);
	else
	{
		if(checkByAdminlevel('网管,总经理',$action)){
			return true;
		}
		if($xianlu['user_name'] == $action->roleuser['user_name'])
		return true;

		if(departInMine($xianlu['departmentID'],$action)){
			return true;
		}
		
		doalert('您无权修改别人的产品信息',$forward);
	}

}   


function airticketIsAdmin($id,$action,$forward = '')   
{   
	if(!$forward)
	$forward = SITE_ADMIN."Airticket/index";
	
	$air_ticket = D("Ticket");	
	$ticket = $air_ticket->where("`id` = '$id'")->find();
	if(!$ticket)
	{
		justalert('错误，飞机不线路不存在');
		gethistoryback();
	}
	else
	{
		if(checkByAdminlevel('网管,总经理',$action)){
			return true;
		}
		if($ticket['user_name'] == $action->adminuser['user_name'])
		return true;
		else
		{
		justalert('您无权修改别人的产品信息');
		gethistoryback();
		}
	}

}   



function hotelIsAdmin($id,$action,$forward = '')   
{   
	if(!$forward)
	$forward = SITE_ADMIN."Airticket/index";
	
	$Hotel_line = D('Hotel_line');
	$line = $Hotel_line->where("`id` = '$id'")->find();
	if(!$line)
		doalert('错误，酒店不存在',$forward);
	else
	{
		if(checkByAdminlevel('网管,总经理',$action)){
			return true;
		}
		if($line['user_name'] == $action->adminuser['user_name'])
		return true;
		else
		doalert('您无权修改别人的产品信息',$forward);
	}

}   





function checkByadminlevel($operate,$mythis,$modle='',$id='')   
{ 
	$myadminlevel = $mythis->adminuser['adminlevel'];
	$gets = explode(',',$operate);
	foreach($gets as $get){
	$c=explode($get,$myadminlevel);
		if(count($c)>1)
		{
			return true;
		}
	}
	return false;
}   

function checkByadminlevel_v($operate,$mythis,$modle='',$id='')   
{ 
	$myadminlevel = $mythis['adminuser']['adminlevel'];
	$gets = explode(',',$operate);
	foreach($gets as $get){
	$c=explode($get,$myadminlevel);
		if(count($c)>1)
		{
			return true;
		}
	}
	return false;
}   

function writetofile_front($my)   
{ 

$ip = $_SERVER["REMOTE_ADDR"];
$time = date("Y-m-d H:i:s", time());
$content = 'time='.$time.',ip='.$_SERVER['REMOTE_ADDR'].',user_name='.$my['roleuser']['user_name'].',realname='.$my['roleuser']['realname'].',url='.$_SERVER["REQUEST_URI"]."'\r\n";
$filename = date("Y_m", time()).".txt";
$myfile = './data/log/'.$filename;

$file_pointer = fopen($myfile,"a");
fwrite($file_pointer,$content);
fclose($file_pointer);

}   


function writetofile($my)   
{ 

$ip = $_SERVER["REMOTE_ADDR"];
$time = date("Y-m-d H:i:s", time());
$content = 'time='.$time.',ip='.$_SERVER['REMOTE_ADDR'].',user_name='.$my->roleuser['user_name'].',realname='.$my->roleuser['realname'].',url='.$_SERVER["REQUEST_URI"]."'\r\n";
$filename = date("Y_m", time()).".txt";
$myfile = './data/log/'.$filename;

$file_pointer = fopen($myfile,"a");
fwrite($file_pointer,$content);
fclose($file_pointer);

}   

function writetofilerecord($my,$content)   
{ 
$filename = date("Y_m", time()).".txt";
$myfile = './data/record/'.$filename;

$file_pointer = fopen($myfile,"a");
fwrite($file_pointer,$content);
fclose($file_pointer);

}   




function jisuanriqi2($date1,$date2)
{
	  $number = $date1-$date2;
	  $tianshu = $number/(60 * 60 *24);
	  
	  return (int)$tianshu;
}

function _isadmindingdan($dingdanID,$mythis)
{
	$Gldingdan = D("gldingdan");
	$dingdan = $Gldingdan->where("`dingdanID` = '$dingdanID'")->find();
	if($dingdan['user_name'] == $mythis->roleuser['user_name'])
		return true;
	else 
		return false;
}

function deleteDir($dir) 
{ 
if (rmdir($dir)==false && is_dir($dir)) { 
if ($dp = opendir($dir)) { 
while (($file=readdir($dp)) != false) { 
if (is_dir($file) && $file!='.' && $file!='..') { 
deleteDir($file); 
} else { 
unlink($file); 
} 
} 
closedir($dp); 
} else { 
exit('Not permission'); 
} 
} 
} 


function deltree($pathdir) 
{ 
echo $pathdir;//调试时用的 
if(is_empty_dir($pathdir))//如果是空的 
{ 
rmdir($pathdir);//直接删除 
} 
else 
{//否则读这个目录，除了.和..外 
$d=dir($pathdir); 
while($a=$d->read()) 
{ 
if(is_file($pathdir.'/'.$a) && ($a!='.') && ($a!='..')){unlink($pathdir.'/'.$a);} 
//如果是文件就直接删除 
if(is_dir($pathdir.'/'.$a) && ($a!='.') && ($a!='..')) 
{//如果是目录 
if(!is_empty_dir($pathdir.'/'.$a))//是否为空 
{//如果不是，调用自身，不过是原来的路径+他下级的目录名 
deltree($pathdir.'/'.$a); 
} 
if(is_empty_dir($pathdir.'/'.$a)) 
{//如果是空就直接删除 
rmdir($pathdir.'/'.$a); 
} 
} 
} 
$d->close(); 
echo "必须先删除目录下的所有文件";//我调试时用的 
} 
} 
function is_empty_dir($pathdir) 
{ 
//判断目录是否为空 
$d=opendir($pathdir); 
$i=0; 
while($a=readdir($d)) 
{ 
$i++; 
} 
closedir($d); 
if($i>2){return false;} 
else return true; 
} 

function _dofileuplod($path = 'files'){
	import ("ORG.Net.UploadFile");

	$upload = new UploadFile();
	$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','doc','txt','xls','rar','zip','xlsx');
	$upload->saveRule = 'time';
	$upload->autoSub = 'true';
	$upload->subType = 'date';
	$upload->dateFormat = 'Y/m';
	$upload->savePath =  './data/'.$path.'/';
	$upload->upload();

	$info =  $upload->getUploadFileInfo();  
	if($info)
	$savepath = $path.'/'.$info[0]['savename'];
//	if (!$info) $url = $url;
//	else $url = $info[0]['savename'];
  	
	return $savepath;
}

function _dofileuplod_uniqid($path = 'files'){
	import ("ORG.Net.UploadFile");

	$upload = new UploadFile();
	$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','doc','txt','xls','rar','zip','xlsx');
	$upload->saveRule = 'uniqid';
	$upload->autoSub = 'true';
	$upload->subType = 'date';
	$upload->dateFormat = 'Y/m';
	$upload->savePath =  './data/'.$path.'/';
	$upload->upload();

	$info =  $upload->getUploadFileInfo();  
	if($info)
	$savepath = $path.'/'.$info[0]['savename'];
	return $savepath;
}


	function compressionDir($dir,$outputname)
	{
        import("@.ORG.archive");
		$test = new zip_file($outputname);
		$test->set_options(
		array(
		‘basedir’ => dirname('/'),
		‘inmemory’ => 0, //不在内存压缩.而是直接存放到磁盘.如果要压缩下载,则可以选择为1
		‘recurse’ => 1, //是否压缩子目录，resurse，递归的意思？
		’storepaths’ => 1, //是否存储目录结构，我选是。
		‘overwrite’ => 1, //是否覆盖
		‘prepend’ => "", //未知
		‘followlinks’ => 0, //未知
		‘method’ => 1, //未知
		’sfx’ => "", //不知道什么意思
		)
		);
		$test->add_files($dir);//目录或文件
		$test->create_archive();
		$test->download_file();//不写这一行，数据只存在内存里
	}



    //UBB代码及其他替换
    function ubb($text,$mythis) {
        $shorturl=$mythis->site['shorturlopen']==1?$mythis->site['shorturl'].'/':SITE_HOME.'?u=';

        $p= array(
            '/\[AT (.*?)\](.*?)\[\/AT\]/i',
            '/\[F l=(.*?)\](.*?)\[\/F\]/i',
            '/\[V h=(.*?) p=(.*?)\](.*?)\[\/V\]/i',
            '/\[M\](.*?)\[\/M\]/i',
            '/\[U (.*?)\](.*?)\[\/U\]/i',
            '/\[T\](.*?)\[\/T\]/i',
        );
        $rand=randStr(6);
        $r=array(
            "<a href='".SITE_HOME."$1'>$2</a>",
            "<div class='imageshow'><a class='miniImg artZoom' href='javascript:void(0)'><img src='$2'></a>
            <div class='artZoomBox'>
            <div class='tool'><a title='收起' href='javascript:void(0)' class='hideImg'>收起</a><a title='向右转' href='javascript:void(0)' class='imgRight'>向右转</a><a title='向左转' href='javascript:void(0)' class='imgLeft'>向左转</a><a title='查看原图' href='$1' class='viewImg' target='_blank'>查看原图</a></div>
            <div class='clearline'></div>
            <a class='maxImgLink' href='javascript:void(0)'><img src='$1' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"' class='maxImg'></a>
            </div>
            </div>",
            "<div class='media'><img id='img_".$rand."' style='background:url($2) no-repeat;' src='".__PUBLIC__."/images/feedvideoplay.gif' alt='点击播放' onclick=\"showFlash('$1','$3',this,'".$rand."');\"/></div>",
            "<div class='music'><img id='img_".$rand."' src='".__PUBLIC__."/images/music.gif' alt='点击播放' onclick=\"javascript:showFlash('music','$1',this,'".$rand."');\"/></div>",
            "<a href='".$shorturl."$1' target='_blank' title='$2'>".$shorturl."$1</a>",
            "<a href='".SITE_HOME."k/$1'>#$1#</a>",
        );
        $text=preg_replace($p,$r,$text);
        $text=emotionrp($text);
        return $text;
    }

function __Debug__($mythis,$val)
{
	
	if($mythis->roleuser['user_name'] == 'aaa')
		dump($val);
}

function Fi_ConvertChars($text)
{
	    $text = str_ireplace("'","\'",$text);
	    $text = str_ireplace("\"","\"",$text);
		return $text;
}

function F_isdberror($dbmodel)
{
		if($dbmodel->getDbError() != ''){
			$word = '数据写入错误！提示：'.$dbmodel->getDbError()." in table ".$dbmodel->getTableName();
			justalert(Fi_ConvertChars($word));
			gethistoryback();
		}
		if($dbmodel->getError() != ''){
			$word = $dbmodel->getError()." in table ".$dbmodel->getTableName();
			justalert(Fi_ConvertChars($word));
			gethistoryback();
		}
}

function F_isdataempty($data,$dbmodel = '')
{
	if($dbmodel)
	{
		if($data[$dbmodel->getPk()])
		{
			$pk = $dbmodel->getPk();
			//$dbmodel->$pk = $data[$pk];
			$havedata = $dbmodel->where("`$pk` = '$data[$pk]'")->find();
		}
	  $DbFields = $dbmodel->getDbFields();
	  foreach($DbFields as $key => $value){
		  if($value == 'timestamp')
		  	continue;
		  
		  if(is_string($value) && $value != $dbmodel->getPk())
		  	$data2[$value] = null;
			
		  if($havedata)
		  	$data2[$value] = $havedata[$value];
			
		  if($data[$value] != '')
		  	$data2[$value] = $data[$value];
	  }
	}
	else
	{
	  foreach($data as $key => $value)
	  {
		  if($value == '')
		  	$data[$key] = null;
	  }
	}
	  return $data2;
}
/**
 +----------------------------------------------------------
 * 字符串截取，支持中文和其他编码
 +----------------------------------------------------------
 * @static
 * @access public
 +----------------------------------------------------------
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
{
    if(function_exists("mb_substr"))
        return mb_substr($str, $start, $length, $charset)."…";
    elseif(function_exists('iconv_substr')) {
        return iconv_substr($str,$start,$length,$charset)."…";
    }
    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}


function listmydepartment($mythis,$where,$dpname = 'departmentID',$uname = 'user_name')   
{  
	
	$user_name = $mythis->roleuser['user_name'];
	$lvxingsheID = $mythis->company['lvxingsheID'];
	
	if(checkByAdminlevel('联合体成员',$mythis)){
		$where['lvxingsheID'] = array('exp',"= $lvxingsheID or `user_name` = '$user_name'");
		$where['companytype'] = '同业';
		return $where;
	}
	if(checkByAdminlevel('办事处管理员',$mythis)){
		$where['lvxingsheID'] = array('exp',"= $lvxingsheID or `user_name` = '$user_name'");
		$where['companytype'] = '办事处';
		return $where;
	}
	if(!$where['companytype'])
	$where['companytype'] = array(array('neq','办事处'),array('neq','同业'));
	
	if(checkByAdminlevel('网管',$mythis))
	{
		return $where;
	}
	
	$where['belongID'] = $mythis->company['belongID'];
	//管理员
	if(checkByAdminlevel('网管,总经理,财务操作员,财务总监',$mythis))
	{
		return $where;
	}
	//经理级
	if(checkByAdminlevel('计调操作员,计调经理,办事处管理员',$mythis))
	{
		$department_list = unserialize($mythis->adminuser['department_list']);
		foreach($department_list as $v){
			if($tlist)
			$tlist .= ','.$v;
			else
			$tlist = $v;
		}
		$v = $mythis->my_department['id'];
		if($v)
		{
			if($tlist)
			$tlist .= ','.$v;
			else
			$tlist = $v;
		}
		if($tlist)
		$where[$dpname] = array('exp',"in ($tlist) or `$uname` = '".$mythis->roleuser['user_name']."'");
		else
		$where[$uname] = $mythis->roleuser['user_name'];
		
		return $where;
	}
	//员工级
	if(checkByAdminlevel('门市操作员,地接操作员',$mythis))
	{
		$where[$uname] = $mythis->roleuser['user_name'];
		return $where;
	}
	
}   

function listmydepartment_qz($mythis,$where,$dpname = 'departmentID',$uname = 'username')   
{  
	//管理员
	if(checkByAdminlevel('网管,总经理,财务操作员,财务总监',$mythis))
	{
		return $where;
	}
	elseif(checkByAdminlevel('计调操作员,计调经理,地接经理',$mythis)){
		$department_list = unserialize($mythis->adminuser['department_list']);
		foreach($department_list as $v){
			if($tlist)
			$tlist .= ','.$v;
			else
			$tlist = $v;
		}
		$v = $mythis->my_department['id'];
		if($v)
		{
			if($tlist)
			$tlist .= ','.$v;
			else
			$tlist = $v;
		}
		if($tlist)
		$where[$dpname] = array('exp',"in ($tlist) or `$uname` = '".$mythis->roleuser['user_name']."'");
		else
		$where[$uname] = $mythis->roleuser['user_name'];
		
		return $where;	
	}
	else{
		$where[$uname] = $mythis->roleuser['user_name'];
	}

	return $where;
	
}   

function departInMine($departmentID ,$mythis)   
{  
	//管理员
	if(checkByAdminlevel('网管,总经理',$mythis))
	{
		return true;
	}
	//经理级
	elseif(checkByAdminlevel('计调操作员,计调经理',$mythis))
	{
		$department_list = unserialize($mythis->adminuser['department_list']);
		
		foreach($department_list as $v){
			if ($v == $departmentID) return true;
		}
		$v = $mythis->my_department['id'];
		if($v == $departmentID) return true;
		
	}
	else{
		return false;
	}
	
	return false;
}   


function listmydepartment_dingdan($mythis,$where,$dpname = 'departmentID',$uname = 'user_name')   
{  
	if(checkByAdminlevel('网管',$mythis))
	{
		return $where;
	}
	$user_name = $mythis->roleuser['user_name'];
	$lvxingsheID = $mythis->company['lvxingsheID'];
	
	if(checkByAdminlevel('联合体成员',$mythis)){
		$where['lvxingsheID'] = array('exp',"= $lvxingsheID or `user_name` = '$user_name'");
		$where['companytype'] = '同业';
		return $where;
	}
//	$where['companytype'] = array('neq','同业');
	$where['belongID'] = $mythis->company['belongID'];
	//管理员
	//管理员
	if(checkByAdminlevel('财务操作员',$mythis))
	{
		return $where;
	}
	//经理级
	if(checkByAdminlevel('计调操作员,计调经理',$mythis))
	{
		$department_list = unserialize($mythis->adminuser['department_list']);
		
		foreach($department_list as $v){
			if($tlist)
			$tlist .= ','.$v;
			else
			$tlist = $v;
		}
		$v = $mythis->my_department['id'];
		if($v)
		{
			if($tlist)
			$tlist .= ','.$v;
			else
			$tlist = $v;
		}
		
		if($tlist)
		$where[$dpname] = array('exp',"in ($tlist) or `xianlu_username` = '".$mythis->roleuser['user_name']."'");
		else
		$where[$uname] = $mythis->roleuser['user_name'];
		return $where;
	}
	//员工级
	if(checkByAdminlevel('门市操作员,地接操作员',$mythis))
	{
		$where[$uname] = $mythis->roleuser['user_name'];
		return $where;
	}
	
}   




function listmydepartment_msg($mythis,$where,$dpname = 'departmentID',$uname = 'user_name')   
{  
	//管理员
	if(checkByAdminlevel('网管,总经理',$mythis))
	{
	}
	//财务
	elseif(checkByAdminlevel('财务操作员',$mythis))
	{
		$where['tablename'] = array('exp'," = '报账单' or `tablename` = '地接报账单'");
	}
	//经理级
	elseif(checkByAdminlevel('计调经理',$mythis))
	{
		foreach($department_list as $v){
			if($tlist)
			$tlist .= ','.$v;
			else
			$tlist = $v;
		}
		$v = $mythis->my_department['id'];
		if($v)
		{
			if($tlist)
			$tlist .= ','.$v;
			else
			$tlist = $v;
		}
		$where[$dpname] = array('in',$tlist);
	}
	//员工级
	elseif(checkByAdminlevel('计调操作员,门市操作员,地接操作员,联合体成员',$mythis))
	{
		$where[$uname] = $mythis->roleuser['user_name'];
	}
	
	
	return $where;
}   



function domydepartment($mythis,$user_name)   
{ 
	$my_departmentID = $mythis->my_department['id'];
	$my_belongID = $mythis->company['belongID'];
	
	$gllvxingshe = D("gllvxingshe");
	$glkehu = D("glkehu");
	$user = $glkehu->where("`user_name` = '$user_name'")->find();
	$com = $gllvxingshe->where("`lvxingsheID` = '$user[lvxingsheID]'")->find();
	$belongID = $com['belongID'];
	$departmentID = $user['department'];
		
	//经理级
	if(checkByAdminlevel('网管,总经理,财务操作员',$mythis))
	{
		if($belongID == $my_belongID)
			return;
		else
			doalert("权限错误",'');	
	}
	elseif(checkByAdminlevel('计调经理',$mythis))
	{
		if($belongID == $my_belongID)
		{
			$department_list = unserialize($mythis->adminuser['department_list']);
			
			$v = $mythis->my_department['id'];
			if($v)
			array_push($department_list, $v);
			
			if(in_array($departmentID,$department_list))	
			return;
			else
			doalert("权限错误!!!",'');	
		}
		else
			doalert("权限错误!!",'');	
	}
	
	else 
	doalert("权限错误",'');	
}   




function domydepartment_sp2($mythis,$xianlu)   
{ 
	$my_belongID = $mythis->company['belongID'];
	if($my_belongID != $xianlu['belongID'])
		doalert("权限错误",'');
		
	//经理级
	if(checkByAdminlevel('网管,总经理',$mythis))
	{
		return;
	}
	elseif(checkByAdminlevel('联合体管理员',$mythis))
	{
		return;
	}
	else
	doalert("权限错误",'');	
}   




function F_checkuserinfo($mythis)   
{
	if($mythis->my_department == '')
	{
		justalert("当前帐号异常，未填写归宿部门");
		gethistoryback();
	}
	if($mythis->company == '')
	{
		justalert("当前帐号异常，未填写隶属公司");
		gethistoryback();
	}
}


function F_getzituanrenshu($zituanID) 
{
	  $zituan_xianlu = D("zituan_xianlu_lvxingshe");
	  $zituan = $zituan_xianlu->where("`zituanID` = '$zituanID'")->find();
	  $Gltuanyuan = D("tuanyuan_dingdan");
	  $Gldingdan = D("dingdan_zituan");
	  $dingdanAll = $Gldingdan->where("`zituanID` = '$zituan[zituanID]'")->findall();
	  $querennum = 0;
	  $zhanweinum = 0;
	  foreach($dingdanAll as $dingdan)
	  {
			  $querennum += $Gltuanyuan->where("`zhuangtai` = '确认' and `dingdanID` = '$dingdan[dingdanID]'")->count();
			  $zhanweinum += $Gltuanyuan->where("`zhuangtai` = '占位' and `dingdanID` = '$dingdan[dingdanID]'")->count();
	  }
	  $shengyu = $zituan['renshu'] - $querennum - $zhanweinum;
	  return $shengyu;
}


function F_dingdan_bzd_item($dd) {
		
		$gl_baozhang = D('gl_baozhang');
		$bzd = $gl_baozhang->where("`zituanID` = '$dd[zituanID]'")->find();
		if(!$bzd){
			$t['zituanID'] = $dd['zituanID'];
			$t['time'] = time();
			
			$glzituan = D("glzituan");
			$zituan = $glzituan->where("`zituanID` = $dd[zituanID]")->find();
			$t['caozuoren'] = $zituan['user_name'];
			$baozhangID = $gl_baozhang->add($t);
		}
		else
		{
			$baozhangID = $bzd['baozhangID'];
			$glzituan = D("glzituan");
			$zituan = $glzituan->where("`zituanID` = $bzd[zituanID]")->find();
			}
		if(!$baozhangID)	
			doalert("错误",'');
			
		//部门
		$glkehu = D("glkehu");
		$user = $glkehu->where("`user_name` = '$dd[user_name]'")->find();
		$glbasedata = D("glbasedata");	
		$bumen = $glbasedata->where("`id` = '$user[department]'")->find();	
			
		$DJbaozhangitem = D('gl_baozhangitem');
		$olditem = $DJbaozhangitem->where("`dingdanID` = '$dd[dingdanID]'")->find();
			
		//大客户生成报账单项目
		//生成报账单应收款项
		if($dd['bigmanID'])
		{
			$glbasedata = D("glbasedata");
			$bigman = $glbasedata->where("`id` = '$dd[bigmanID]'")->find();
			if(!$bigman)
				doalert("大客户信息异常，请联系管理员",'');
			$item['title'] = '大客户：'.$bigman['title'];
			$item['bigmanID'] = $dd['bigmanID'];
			$item['edituser'] = $dd['user_name'];
		}
		else
		{
			$item['title'] = $bumen['title']."团费";
			$item['edituser'] = $zituan['user_name'];
		}
		$item['baozhangID'] = $baozhangID;
		$item['dingdanID'] = $dd['dingdanID'];
		//$item['departmentID'] = $zituan['departmentID'];
		$item['price'] = $dd['jiage'];
		$item['type'] = '结算项目';
		$item['remark'] = '成人'. $dd['chengrenshu'].'人，'.'儿童'. $dd['ertongshu'].'人';
		$item['time'] = time();
		$item['pricetype'] = '现金';
		if($dd['guojing'] == '国内')
			$item['check_status'] = '准备';
		else
			$item['check_status'] = '准备';
			
			
		if($olditem)	
		{
			$item['baozhangitemID'] = $olditem['baozhangitemID'];
			$DJbaozhangitem->save($item);
		}
		else
		$DJbaozhangitem->add($item);
	}
	
	


function F_dingdan_bzd_item_delete($dingdanID) {
		$gl_baozhangitem = D('gl_baozhangitem');
		$gl_baozhangitem->where("`dingdanID` = '$dingdanID'")->delete();
	}
	
	
function F_xianlu_status_check($xianluID,$mythis) {
				$Glxianlu = D("Glxianlu");
				$xianludata = $Glxianlu->where("`xianluID` = '$xianluID'")->find();
				if(!$xianludata)
				{
					doalert('找不到线路产品','');
				}
				if(checkByAdminlevel('办事处管理员',$mythis)){
					return;
				}
				if($xianludata['zhuangtai'] == '截止')
				{
					doalert('该线路已经截止，禁止修改','');
				}
	}
	
	


function F_xianlu_status_set($xianluID) {
				$glzituan = D("glzituan");
				$glxianlu = D("glxianlu");
				$zituanAll = $glzituan->where("`xianluID` = '$xianluID'")->findall();
				$mk = 1;
				foreach($zituanAll as $v)
				{
					if($v['zhuangtai'] != '截止')	
						$mk = 0;
				}
				if($mk)
				{
					$thexianlu['xianluID'] = $xianluID;
					$thexianlu['zhuangtai'] = '截止';
					$glxianlu->save($thexianlu);	
				}
	
	}
	
function F_xianlu_status_set_2($xianluID) {
				$glzituan = D("glzituan");
				$glxianlu = D("glxianlu");
				$zituanAll = $glzituan->where("`xianluID` = '$xianluID'")->findall();
				$mk = 0;
				foreach($zituanAll as $v)
				{
					if($v['zhuangtai'] != '截止')	
						$mk = 1;
				}
				if($mk)
				{
					$thexianlu['xianluID'] = $xianluID;
					$thexianlu['zhuangtai'] = '报名';
					$glxianlu->save($thexianlu);	
				}
	
	}
	
	
//由子团号或者是订单号统计人数和钱数
function get_informations($type, $zituan_info, $id = 0, $dj = 0, $user_name = '', $flag = '') {
	
	//由团号获取该团的订单数，人数，钱数
	if($type == "zituan"){
		
		$zituanID = $id;
		$conditions['zituanID'] = $zituanID;
		$conditions['check_status'] = '审核通过';
		
		
		
		$gldingdan = D("Gldingdan");
		$dingdan_num = $gldingdan->where($conditions)->count();	
		$dingdanAll = $gldingdan->where($conditions)->findall();
		
		
		foreach($dingdanAll as $dingdan){
			
			//人数统计
			$Gltuanyuan = D("tuanyuan_dingdan");
			$rennum = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 0")->count();
			$rennum_leader = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 1")->count();
			$dingdan_rensum += $rennum;
			$dingdan_rennum_leader += $rennum_leader;
			//结束
			
			//钱数统计
			$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findAll();
			foreach($tuanyuanAll as $tuanyuan){
				$sum += $tuanyuan['jiaoqian'];
			}
			$dingdan_money += $sum;
			//结束		
			
			//前台业绩统计
			if($user_name){
				
				if($dingdan['user_name'] == $user_name){
					$zituan_info['qiantai']['dingdanshu'] += 1;
					$zituan_info['qiantai']['dingdanrenshu'] += $rennum;
					$zituan_info['qiantai']['dingdanrenshu_leader'] += $rennum_leader;
				}
				
			}else{
				$zituan_info['qiantai'][$dingdan['user_name']]['dingdanshu'] += 1;
				$zituan_info['qiantai'][$dingdan['user_name']]['dingdanrenshu'] += $rennum;
				$zituan_info['qiantai'][$dingdan['user_name']]['dingdanrenshu_leader'] += $rennum_leader;
			}	

		}
		
		$zituan_info['dingdanshu'] = $dingdan_num;
		$zituan_info['dingdanrenshu'] = $dingdan_rensum;
		$zituan_info['dingdanrenshu_leader'] = $dingdan_rennum_leader;
		$zituan_info['dingdan_money'] = $dingdan_money;
		
		
		$GLbaozhang = D("Gl_baozhang");
		$GLbaozhangitem = D("Gl_baozhangitem");
		
		$DJbaozhang = D("Dj_baozhang");
		$DJbaozhangitem = D("Dj_baozhangitem");
		
		if($dj){
			$baozhang = $DJbaozhang->where('`djtuanID`='.$zituanID)->find();
			//地接人数
			$djtuan = D("Dj_tuan");
			$tuan = $djtuan->where("`djtuanID` = $zituanID")->find();
			
			$zituan_info['dingdanrenshu'] = (int)$tuan['renshu'];
			
		}else{
			$glzituan = D("Glzituan");
			$zituan = $glzituan->where("`zituanID` = $zituanID")->find();
			$baozhang = $GLbaozhang->where('`zituanID`='.$zituanID)->find();
		}
		
		
		if($dj){
			$money_all = $DJbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
		}else{
			$money_all = $GLbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
		}
		
		
		foreach($money_all as $money){
			if ($money['type'] == '项目') $xiangmu_num_nopage = $money['price'];
			if ($money['type'] == '支出项目') $zhichu_num_nopage = $money['price'];
			if ($money['type'] == '结算项目') $shouru_num_nopage = $money['price'];
		}
		
		$shouru_sum = $xiangmu_num_nopage + $shouru_num_nopage;
		$zhichu_sum = $zhichu_num_nopage;
		
		$zituan_info['shouru'] = $shouru_sum;
		$zituan_info['zhichu'] = $zhichu_sum;
		$zituan_info['maoli'] = ($shouru_sum - $zhichu_sum)/$shouru_sum;
		
		$zituan_info['ticheng'] = $zituan_info['dingdanrenshu'] * 2;	
		
		//门市提成率 真他妈麻烦 By heavenK
		if($zituan){
			if($zituan['guojing'] == '国内'){
				if($zituan['kind'] == '近郊游')	$zituan_info['tichenglv'] = 2;
				elseif($zituan['kind'] == '长线游')	$zituan_info['tichenglv'] = 5;
			}else{
				if(strstr($zituan['departmentName'],'台湾'))		$zituan_info['tichenglv'] = 10;
				elseif(strstr($zituan['departmentName'],'欧美岛'))		$zituan_info['tichenglv'] = 20;
				else $zituan_info['tichenglv'] = 5;
			}
		}
		if($zituan_info['maoli'] < 0.05) $zituan_info['tichenglv'] = $zituan_info['tichenglv']/2;
		//结束
		
		return $zituan_info;
	}
	
	//由人名获取此人的子团信息，订单数。
	if($type == "user"){
		
		$zituanID = $id;
		$conditions['zituanID'] = $zituanID;
		$conditions['check_status'] = '审核通过';
		
		
		
		$gldingdan = D("Gldingdan");
		$dingdan_num = $gldingdan->where($conditions)->count();	
		$dingdanAll = $gldingdan->where($conditions)->findall();
		
		
		foreach($dingdanAll as $dingdan){
			
			//人数统计
			$Gltuanyuan = D("tuanyuan_dingdan");
			$rennum = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 0")->count();
			$rennum_leader = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 1")->count();
			$dingdan_rensum += $rennum;
			$dingdan_rennum_leader += $rennum_leader;
			//结束
			
			//钱数统计
/*			$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findAll();
			foreach($tuanyuanAll as $tuanyuan){
				$sum += $tuanyuan['jiaoqian'];
			}
			$dingdan_money += $sum;*/
			//结束			

			//前台业绩统计
/*			$zituan_info['qiantai'][$dingdan['user_name']]['dingdanshu'] += 1;
			$zituan_info['qiantai'][$dingdan['user_name']]['dingdanrenshu'] += $rennum;
			$zituan_info['qiantai'][$dingdan['user_name']]['dingdanrenshu_leader'] += $rennum_leader;*/

		}
		
		$zituan_info['dingdanshu'] = $dingdan_num;
		$zituan_info['dingdanrenshu'] = $dingdan_rensum;
		$zituan_info['dingdanrenshu_leader'] = $dingdan_rennum_leader;
		$zituan_info['dingdan_money'] = $dingdan_money;
		
		
		$GLbaozhang = D("Gl_baozhang");
		$GLbaozhangitem = D("Gl_baozhangitem");
		
		$DJbaozhang = D("Dj_baozhang");
		$DJbaozhangitem = D("Dj_baozhangitem");
		
		if($dj){
			$baozhang = $DJbaozhang->where('`djtuanID`='.$zituanID)->find();
			//地接人数
			$djtuan = D("Dj_tuan");
			$tuan = $djtuan->where("`djtuanID` = $zituanID")->find();
			
			$caozuo_renshu = $tuan['renshu'];
			
		}else{
			$glzituan = D("Glzituan");
			$zituan = $glzituan->where("`zituanID` = $zituanID")->find();
			$baozhang = $GLbaozhang->where('`zituanID`='.$zituanID)->find();
			
			$caozuo_renshu = $baozhang['renshu'];
		}
		
		//当时为什么不把报账人数设成int型，日   by heavenK
		$reg = "/[^\d]/";
		$res = preg_replace($reg ," " ,$caozuo_renshu);
		$arr = explode(' ' ,$res);
		$sum = 0;
		foreach($arr as $value){
			$sum += $value;
		}
		$zituan_info['dingdanrenshu'] = $sum;
		
		
		if($dj){
			$money_all = $DJbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
		}else{
			$money_all = $GLbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
		}
		
		
		foreach($money_all as $money){
			if ($money['type'] == '项目') $xiangmu_num_nopage = $money['price'];
			if ($money['type'] == '支出项目') $zhichu_num_nopage = $money['price'];
			if ($money['type'] == '结算项目') $shouru_num_nopage = $money['price'];
		}
		
		$shouru_sum = $xiangmu_num_nopage + $shouru_num_nopage;
		$zhichu_sum = $zhichu_num_nopage;
		
		$zituan_info['shouru'] = $shouru_sum;
		$zituan_info['zhichu'] = $zhichu_sum;
		$zituan_info['maoli'] = ($shouru_sum - $zhichu_sum)/$shouru_sum;
		
		$zituan_info['ticheng'] = $zituan_info['dingdanrenshu'] * 2;	

		return $zituan_info;
	}
	
	
	//由订单获取此属子团信息，订单数。
	if($type == "dingdan"){
		
		$dingdan = $id;
		$dingdanID = $dingdan['dingdanID'];
		$conditions['dingdanID'] = $dingdanID;
		
		$dingdan_num = 1;
			
		//人数统计
		$Gltuanyuan = D("tuanyuan_dingdan");
		$rennum = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 0")->count();
		$rennum_leader = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]' AND `leader` = 1")->count();
		$dingdan_rensum += $rennum;
		$dingdan_rennum_leader += $rennum_leader;
		//结束
		
		//钱数统计
		$tuanyuanAll = $Gltuanyuan->where("`dingdanID` = '$dingdan[dingdanID]'")->findAll();
		foreach($tuanyuanAll as $tuanyuan){
			$sum += $tuanyuan['jiaoqian'];
		}
		$dingdan_money += $sum;
		//结束			
		

		
		$zituan_info['qiantai']['dingdanshu'] += $dingdan_num;
		$zituan_info['qiantai']['dingdanrenshu'] += $dingdan_rensum;
		$zituan_info['qiantai']['dingdanrenshu_leader'] += $dingdan_rennum_leader;
		$zituan_info['qiantai']['dingdan_money'] += $dingdan_money;
		
		if(!$flag){

			$GLbaozhang = D("Gl_baozhang");
			$GLbaozhangitem = D("Gl_baozhangitem");
			
			$DJbaozhang = D("Dj_baozhang");
			$DJbaozhangitem = D("Dj_baozhangitem");
			
			if(!$dj){
				$glzituan = D("Glzituan");
				$zituan = $glzituan->where("`zituanID` = ".$dingdan['zituanID'])->find();
				$baozhang = $GLbaozhang->where('`zituanID`='.$dingdan['zituanID'])->find();
			}
			
			
			if($dj){
				$money_all = $DJbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
			}else{
				$money_all = $GLbaozhangitem->where('`baozhangID`='.$baozhang['baozhangID']." and `check_status` = '审核通过'")->group('type')->field('sum(price) as price, type')->findAll();
			}
			
			
			foreach($money_all as $money){
				if ($money['type'] == '项目') $xiangmu_num_nopage = $money['price'];
				if ($money['type'] == '支出项目') $zhichu_num_nopage = $money['price'];
				if ($money['type'] == '结算项目') $shouru_num_nopage = $money['price'];
			}
			
			$shouru_sum = $xiangmu_num_nopage + $shouru_num_nopage;
			$zhichu_sum = $zhichu_num_nopage;
			
			$zituan_info['shouru'] = $shouru_sum;
			$zituan_info['zhichu'] = $zhichu_sum;
			$zituan_info['maoli'] = ($shouru_sum - $zhichu_sum)/$shouru_sum;
		}
	
		//门市提成率 真他妈麻烦 By heavenK
		
		if(!$dj){
			$glzituan = D("Glzituan");
			$zituan = $glzituan->where("`zituanID` = ".$dingdan['zituanID'])->find();
		}
		
		if(!$flag){
			
			//由于团不是此用户发布，但订单是，于是进行此判断，付值。
			$zituan_info['zituanID'] = $zituan['zituanID'];
			$zituan_info['tuanhao'] = $zituan['tuanhao'];
			$zituan_info['mingcheng'] = "【".$zituan['user_name']."】".$zituan['mingcheng'];
			$zituan_info['xianlutype'] = $zituan['xianlutype'];
			$zituan_info['caiwu_time'] = $dingdan['caiwu_time'];
			$zituan_info['chutuanriqi'] = $zituan['chutuanriqi'];
			$zituan_info['user_name'] = $dingdan['owner'];
		}
		
		if($zituan){
			if($zituan['guojing'] == '国内'){
				if($zituan['kind'] == '近郊游')	$zituan_info['tichenglv'] = 2;
				elseif($zituan['kind'] == '长线游')	$zituan_info['tichenglv'] = 5;
			}else{
				if(strstr($zituan['departmentName'],'台湾'))		$zituan_info['tichenglv'] = 10;
				elseif(strstr($zituan['departmentName'],'欧美岛'))		$zituan_info['tichenglv'] = 20;
				else $zituan_info['tichenglv'] = 5;
			}
		}
		if($zituan_info['maoli'] < 0.05) $zituan_info['tichenglv'] = $zituan_info['tichenglv']/2;
		//结束
			
			
		return $zituan_info;
	}

}







?>