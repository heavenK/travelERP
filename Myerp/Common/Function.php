<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename Function.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : ET_URL);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function StrLenW($str){
    return mb_strlen($str,'UTF8');
}

function StrLenW2($str){
    return (strlen($str)+mb_strlen($str,'UTF8'))/2;
}

function daddslashes($string) {
    $string=str_replace("'",'"',$string);
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if(!MAGIC_QUOTES_GPC) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val);
            }
        } else {
            $string = addslashes($string);
        }
    }
	return $string;
}

function sethead($head) {
    //ucenter头像
    if (ET_UC==TRUE) {
        return UC_API."/avatar.php?uid=".$head."&size=middle";
    }
    if (getsubstr($head,0,4,false)=='http') {
        return $head;
    } else if (getsubstr($head,-4,1,false)!='.') {
        return __PUBLIC__."/images/noavatar.jpg";
    } else {
        return $head?__PUBLIC__."/attachments/head/".$head:__PUBLIC__."/images/noavatar.jpg";
    }
}

function setvip($user_auth) {
    $vipgroup=@include(ET_ROOT.'/Home/Runtime/Data/vipgroup.php');
    if ($vipgroup) {
        foreach($vipgroup as $val){
            $vgroup[$val['id']]=$val;
        }
    }
    if ($vgroup[$user_auth]['name']) {
        return 'vip'.$user_auth;
    } else {
        return '';
    }
}

function viptitle($user_auth) {
    $vipgroup=@include(ET_ROOT.'/Home/Runtime/Data/vipgroup.php');
    if ($vipgroup) {
        foreach($vipgroup as $val){
            $vgroup[$val['id']]=$val;
        }
    }
    if ($vgroup[$user_auth]['name']) {
        return 'title="'.$vgroup[$user_auth]['name'].'"';
    } else {
        return '';
    }
}

function timeop($time,$type="talk") {
    $ntime=time()-$time;
    if ($ntime<60) {
        return(L('just'));
    } elseif ($ntime<3600) {
        return(intval($ntime/60).L('date_minutes'));
    } elseif ($ntime<3600*24) {
        return(intval($ntime/3600).L('date_houre'));
    } else {
        if ($type=="talk") {
            return(gmdate('m'.L('months').'d'.L('day').' H:i',$time+8*3600));
        } else {
            return(gmdate('Y-m-d H:i',$time+8*3600));
        }

    }
}

function randStr($len=6) {
    $chars='ABDEFGHJKLMNPQRSTVWXY123456789';
    mt_srand((double)microtime()*1000000*getmypid());
    $password='';
    while(strlen($password)<$len)
    $password.=substr($chars,(mt_rand()%strlen($chars)),1);
    return $password;
}

function getsubstr($string, $start = 0,$sublen,$append=true) {
    $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
    preg_match_all($pa, $string, $t_string);

    if(count($t_string[0]) - $start > $sublen && $append==true) {
        return join('', array_slice($t_string[0], $start, $sublen))."...";
    } else {
        return join('', array_slice($t_string[0], $start, $sublen));
    }
}

//过滤html
function clean_html($html) {
    $html = nl2br($html);
    $html = str_replace(array("<br />","<br/>","<br>","\r","\n","\r\n","#".L('input_topic_title')."#"), " ", $html);
    $html = eregi_replace('<("|\')?([^ "\']*)("|\')?.*>([^<]*)<([^<]*)>', '\4', $html);
    $html = preg_replace('#</?.*?\>(.*?)</?.*?\>#i','',$html);
    $html = preg_replace('#(.*?)\[(.*?)\](.*?)javascript(.*?);(.*?)\[/(.*?)\](.*?)#','', $html);
    $html = preg_replace('#javascript(.*?)\;#','', $html);
    $html = htmlspecialchars($html);
    return($html);
}

//缓存目录分组
function cachedir($uid) {
    return strtolower(substr(md5($uid),0,1));
}

//链接过滤
function clean_http($html) {
    $html = preg_replace('`((?:https?|ftp?|http):\/\/([a-zA-Z0-9-.?=&_\/:]*)/?)`si','',$html);
    return($html);
}

//过滤链接ubb等
function ubbreplace($content) {
    $cbody=preg_replace('/\[T\](.*?)\[\/T\]/i','#$1#',$content);
    $cbody=preg_replace("/\[(F l=.*|V h=.*|M|AT .*|U.*)\](\S+?)\[\/[A-Z]{1,2}\]/i","$2 ",$cbody);
    return $cbody;
}

function simplecontent($content,$len=50) {
    $sc=clean_html(trim($content));
    $sc=ubbreplace($sc);
    $sc=clean_http($sc);
    if ($len!=0) {
        $sc=getsubstr($sc,0,$len,true);
    }
    $sc=$sc?$sc:L('not_say');
    return $sc;
}

function usertemp($user) {
    if ($user) {
        $css.='body {';
        if ($user['theme_bgcolor']){
            $css.="background:$user[theme_bgcolor]";
        }
        if ($user['theme_bgurl']) {
            if ($user['theme_pictype']=="repeat"){
                $css.=" url('".__PUBLIC__."/attachments/".thumb2theme($user[theme_bgurl])."') repeat left top";
            } else if ($user['theme_pictype']=="center") {
                $css.=" url('".__PUBLIC__."/attachments/".thumb2theme($user[theme_bgurl])."') no-repeat center top;background-attachment: fixed";
            } else if ($user['theme_pictype']=="left") {
                $css.=" url('".__PUBLIC__."/attachments/".thumb2theme($user[theme_bgurl])."') no-repeat left top; background-attachment: fixed";
            }
        }
        if ($user['theme_text']){
            $css.=";color:$user[theme_text]";
        }
        $css.='}';
        if ($user['theme_link']) {
            $css.="a {color:$user[theme_link]}
            a:hover {text-decoration:underline;}
            .light .stamp a { color:$user[theme_link]; border-color:$user[theme_link];}
            #sidebar a:hover {color:$user[theme_link]; border-color:$user[theme_link];}
            a:hover .label { border-bottom:1px solid $user[theme_link];}";
        }
        if ($user['theme_sidebar']){
            $css.="#sidebar {background:$user[theme_sidebar]}";
        }
        if ($user['theme_sidebox']){
            $css.="#sidebar,.userauth{border-color:$user[theme_sidebox]}
            #sidebar .homestabs .menu li a {border-top:1px dashed $user[theme_sidebox]}
            #sidebar .sect {border-top:1px solid $user[theme_sidebox];background:none;}
            #sidebar .first-sect {border:0;background:none;}
            .sidebang {border-bottom:1px dashed $user[theme_sidebox]}
            .authdot {border-bottom:1px dashed $user[theme_sidebox]}";
        }
        return $css;
    }
}

function thumb2theme($url) {
    return str_replace('thumb_','theme_',$url);
}

//表情过滤
function emotionrp($content) {
    $p= array("(疑问)","(惊喜)","(鄙视)","(呕吐)","(拜拜)","(大笑)","(求)","(色)","(撇嘴)","(调皮)","(流泪)","(偷笑)","(鲜花)","(流汗)","(困)","(惊恐)","(闪人)","(惊讶)","(心)","(发怒)","(发愁)","(投降)","(便便)","(害羞)","(大哭)","(得意)","(跪服)","(难过)","(生气)","(闭嘴)","(抓狂)","(人品)","(钱)","(酷)","(挨打)","(痛打)","(阴险)","(困惑)","(尴尬)","(发呆)","(睡)","(嘘)","(鼻血)","(可爱)","(亲吻)","(寒)","(谢谢)","(顶)","(胜利)");

    $r=array();
    for ($i=0;$i<49;$i++) {
        $r[]="<img class='emo' src='".__PUBLIC__."/images/emotion/".($i+1).".gif' alt='$p[$i]'>";
    }
    return str_replace($p, $r, $content);
}

function getcity($city,$type) {
    $tp=explode(' ',$city);
    if (is_array($tp)) {
        if ($type=='province') {
            return $tp[0];
        } else {
            return $tp[1];
        }
    } else {
        return '';
    }
}

function arraynull($array) {
    if (is_array($array)) {
        foreach($array as $key=>$val) {
            if (trim($val)!=='' && !is_array($val)) {
                return 1;
            } else {
                return arraynull($val);
            }
        }
    }
    return 0;
}

//share functions
function get_host($str){
	$list=array(
        "sina.com.cn",
        "youku.com",
        "tudou.com",
        "ku6.com",
        "sohu.com",
        "mofile.com",
        "youtube.com",
	);
	foreach($list as $v){
		if( strpos($str,$v)>0){
			$re= substr($str,strpos($str,$v),100);
			break;
		}
	}
	return $re;
}

function uc_html($text) {
    return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>'.L('jumpin').'</title><meta name="MSSmartTagsPreventParsing" content="True"/><meta http-equiv="MSThemeCompatible" content="Yes"/><style>body{font-size:12px;margin:0 auto}.box{text-aign:center;width:250px;background:#f1f2f2;color:#000000;padding:20px 100px;margin:200px auto;line-height:150%}a {color:#2b4a78;text-decoration:none}a:hover {text-decoration:underline;}</style></head><body><div class="box">'.$text.'</div></body></html>';
}

function makethumb($srcfile,$dstfile,$thumbwidth,$thumbheight,$maxthumbwidth=0,$maxthumbheight=0,$src_x=0,$src_y=0,$src_w=0,$src_h=0) {
    if (!is_file($srcfile)) {
		return '';
	}
	$tow = $thumbwidth;
	$toh = $thumbheight;
	if($tow < 30) {
		$tow = 30;
	}
	if($toh < 30) {
		$toh = 30;
	}
	$make_max = 0;
	$maxtow = $maxthumbwidth;
	$maxtoh = $maxthumbheight;
	if($maxtow >= 300 && $maxtoh >= 300) {
		$make_max = 1;
	}
	$im = '';
	if($data = getimagesize($srcfile)) {
		if($data[2] == 1) {
			$make_max = 0;
            if(function_exists("imagecreatefromgif")) {
				$im = imagecreatefromgif($srcfile);
			}
		} elseif($data[2] == 2) {
			if(function_exists("imagecreatefromjpeg")) {
				$im = imagecreatefromjpeg($srcfile);
			}
		} elseif($data[2] == 3) {
			if(function_exists("imagecreatefrompng")) {
				$im = imagecreatefrompng($srcfile);
			}
		}
	}
	if(!$im) return '';
	$srcw = ($src_w ? $src_w : imagesx($im));
	$srch = ($src_h ? $src_h : imagesy($im));
	$towh = $tow/$toh;
	$srcwh = $srcw/$srch;
	if($towh <= $srcwh){
		$ftow = $tow;
		$ftoh = $ftow*($srch/$srcw);
		$fmaxtow = $maxtow;
		$fmaxtoh = $fmaxtow*($srch/$srcw);
	} else {
		$ftoh = $toh;
		$ftow = $ftoh*($srcw/$srch);
		$fmaxtoh = $maxtoh;
		$fmaxtow = $fmaxtoh*($srcw/$srch);
	}
	if($srcw <= $maxtow && $srch <= $maxtoh) {
		$make_max = 0;	}
	if($srcw >= $tow || $srch >= $toh) {
		if(function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && $ni = imagecreatetruecolor($ftow, $ftoh)) {
			imagecopyresampled($ni, $im, 0, 0, $src_x, $src_y, $ftow, $ftoh, $srcw, $srch);
            if($make_max && $maxni = imagecreatetruecolor($fmaxtow, $fmaxtoh)) {
				imagecopyresampled($maxni, $im, 0, 0, $src_x, $src_y, $fmaxtow, $fmaxtoh, $srcw, $srch);
			}
		} elseif(function_exists("imagecreate") && function_exists("imagecopyresized") && $ni = imagecreate($ftow, $ftoh)) {
			imagecopyresized($ni, $im, 0, 0, $src_x, $src_y, $ftow, $ftoh, $srcw, $srch);
			if($make_max && $maxni = imagecreate($fmaxtow, $fmaxtoh)) {
				imagecopyresized($maxni, $im, 0, 0, $src_x, $src_y, $fmaxtow, $fmaxtoh, $srcw, $srch);
			}
		} else {
			return '';
		}
		if(function_exists('imagejpeg')) {
			imagejpeg($ni, $dstfile);
			if($make_max) {
				imagejpeg($maxni, $srcfile);
			}
		} elseif(function_exists('imagepng')) {
			imagepng($ni, $dstfile);
			if($make_max) {
				imagepng($maxni, $srcfile);
			}
		}
		imagedestroy($ni);
		if($make_max) {
			imagedestroy($maxni);
		}
	}
	imagedestroy($im);
	if(!is_file($dstfile)) {
		return '';
	} else {
		return $dstfile;
	}
}

function getExtensionName($filePath){
    $num=strrpos($filePath,'.');
    $len=strlen($filePath);
    $extension=substr($filePath,$num+1,$len-$num);
    return $extension;
}

function shortserver($sid) {
    if ($sid==0) {
        return 'http://goo.gl';
    } else if ($sid==1) {
        return 'http://bit.ly';
    }
}

function get_content($server,$url){
    if ($server=='goo.gl') {
        return shortenGoogleUrl($url);
    } else if ($server=='bit.ly') {
        $urljs=file_get_contents('http://api.bit.ly/v3/shorten?login=hjoeson&apiKey=R_8ad3e9c52c8a7d6eeb397acd2f4bd90e&longUrl='.urlencode($url).'&format=json');
        $urls=json_decode($urljs,true);
        return $urls['data']['url'];
    }
}


function shortenGoogleUrl($long_url){
    $apiKey = 'API-KEY'; //Get API key from : http://code.google.com/apis/console/
    $postData = array('longUrl' => $long_url, 'key' => $apiKey);
    $jsonData = json_encode($postData);
    $curlObj = curl_init();
    curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($curlObj);
    curl_close($curlObj);
    $json = json_decode($response);
    return $json->id;
}

function ubburl($v1,$v2,$shorturl) {
    if ($v1!=$v2) {
        $st=-1;
        $tp=explode(' ',$v1);
        if (count($tp)==2) {
            $v1=$tp[0];
            $st=$tp[1];
        }
        if ($st==0 || $st==1) {
            $surl=shortserver($st);
        } else {
            $surl=$shorturl;
        }
        return "<a href='".$surl."/{$v1}' target='_blank' title='{$v2}'>".$surl."/{$v1}</a>";
    } else {
        return "<a href='{$v1}' target='_blank' title='{$v1}'>{$v1}</a>";
    }
}

function ubbtopicrl($key,$type) {
    if ($type==1) {
        return "<a href='".SITE_URL."/k/".rawurlencode($key)."'>#$key#</a>";
    } else if ($type==2) {
        return "<a href='".SITE_URL."/k/".rawurlencode($key)."' target='_blank'>#$key#</a>";
    } else if ($type==3) {
        return "<a href='".SITE_URL."/Wap/topic/k/".rawurlencode($key)."'>#$key#</a>";
    }
}

function getSafeCode($value,$code) {//$code=gb2312
    if (is_array($value)) {
        foreach ($value as $key=>$val) {
            $value_1 = $val;
            $value_2 = @iconv("utf-8",$code,$value_1);
            $value_3 = @iconv($code,"utf-8",$value_2);
            $value_4 = @iconv($code,"utf-8",$value_1);
            if ($value_1 == $value_3) {
                $value2[$key]=$value_1;
            } else {
                $value2[$key]=$value_4;
            }
        }
        return $value2;
    } else {
        $value_1 = $value;
        $value_2 = @iconv("utf-8",$code,$value_1);
        $value_3 = @iconv($code,"utf-8",$value_2);
        $value_4 = @iconv($code,"utf-8",$value_1);
        if ($value_1 == $value_3) {
            return $value_1;
        } else {
            return $value_4;
        }
    }
}

function ubbpic($pic1,$pic2,$type) {
    if (getsubstr(trim($pic1),0,4,false)!='http') {
        $pic1=__PUBLIC__.'/attachments'.$pic1;
        $pic2=__PUBLIC__.'/attachments'.$pic2;
    }
    if ($type=='in') {
        return "<div class='imageshow'><a class='miniImg artZoom' href='javascript:void(0)'><img src='".$pic2."' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"'></a>
        <div class='artZoomBox'>
        <div class='tool'><a href='javascript:void(0)' class='hideImg'>".L('hideimg')."</a><a href='javascript:void(0)' class='imgRight'>".L('imgright')."</a><a href='javascript:void(0)' class='imgLeft'>".L('imgleft')."</a><a href='".$pic1."' class='viewImg' target='_blank'>".L('viewimg')."</a></div>
        <div class='clearline'></div>
        <a class='maxImgLink' href='javascript:void(0)'><img src='".$pic1."' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"' class='maxImg'></a>
        </div>
        </div>";
    } else if ($type=='out') {
        return "<p><a title='".L('viewimg')."' href='".$pic1."' target='_blank'><img src='".$pic2."' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"'></a></p>";
    } else if ($type=='wap') {
        return "<p><a href='".$pic1."' target='_blank'><img src='".$pic2."' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"' class='photo'></a></p>";
    }
}

function ubbatrl($p1,$p2,$type) {
    if ($type==1){
        return "<a class='atlink' href='".SITE_URL."/".rawurlencode($p1)."'>$p2</a>";
    } else if ($type==2){
        return "<a href='".SITE_URL."/".rawurlencode($p1)."' target='_blank'>$p2</a>";
    } else {
        return "<a href='".SITE_URL."/Wap/space/user_name/".rawurlencode($p1)."''>$p2</a>";
    }
}

function alphacolor($color,$Alpha=50) {
    function hColor2RGB($hexColor) {
        $color = str_replace('#', '', $hexColor);
        if (strlen($color) > 3) {
            $rgb = array(
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2))
            );
         } else {
            $color = str_replace('#', '', $hexColor);
            $r = substr($color, 0, 1) . substr($color, 0, 1);
            $g = substr($color, 1, 1) . substr($color, 1, 1);
            $b = substr($color, 2, 1) . substr($color, 2, 1);
            $rgb = array(
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b)
            );
        }
        return $rgb;
    }

    $color=hColor2RGB($color);
    $R1=$color['r'];
    $G1=$color['g'];
    $B1=$color['b'];
    $color=hColor2RGB('ffffff');
    $R2=$color['r'];
    $G2=$color['g'];
    $B2=$color['b'];

    $r = dechex(( $R1 * (100 - $Alpha) + $R2 * $Alpha ) / 100);
    $g = dechex(( $G1 * (100 - $Alpha) + $G2 * $Alpha ) / 100);
    $b = dechex(( $B1 * (100 - $Alpha) + $B2 * $Alpha ) / 100);

    return '#'.$r.$g.$b;
}

function gotomail($mail) {
    $temp=explode('@',$mail);
    $t=strtolower($temp[1]);

    if ($t=='163.com') {
        return 'mail.163.com';
    } else if ($t=='vip.163.com') {
        return 'vip.163.com';
    } else if ($t=='126.com') {
        return 'mail.126.com';
    } else if ($t=='qq.com' || $t=='vip.qq.com' || $t=='foxmail.com') {
        return 'mail.qq.com';
    } else if ($t=='gmail.com') {
        return 'mail.google.com';
    } else if ($t=='sohu.com') {
        return 'mail.sohu.com';
    } else if ($t=='tom.com') {
        return 'mail.tom.com';
    } else if ($t=='vip.sina.com') {
        return 'vip.sina.com';
    } else if ($t=='sina.com.cn' || $t=='sina.com') {
        return 'mail.sina.com.cn';
    } else if ($t=='tom.com') {
        return 'mail.tom.com';
    } else if ($t=='yahoo.com.cn' || $t=='yahoo.cn') {
        return 'mail.cn.yahoo.com';
    } else if ($t=='tom.com') {
        return 'mail.tom.com';
    } else if ($t=='yeah.net') {
        return 'www.yeah.net';
    } else if ($t=='21cn.com') {
        return 'mail.21cn.com';
    } else if ($t=='hotmail.com') {
        return 'www.hotmail.com';
    } else if ($t=='sogou.com') {
        return 'mail.sogou.com';
    } else if ($t=='188.com') {
        return 'www.188.com';
    } else if ($t=='139.com') {
        return 'mail.10086.cn';
    } else if ($t=='189.cn') {
        return 'webmail15.189.cn/webmail';
    } else if ($t=='wo.com.cn') {
        return 'mail.wo.com.cn/smsmail';
    } else if ($t=='139.com') {
        return 'mail.10086.cn';
    } else {
        return '';
    }
}
function real_ip(){
    static $realip = NULL;
    if ($realip !== NULL){
        return $realip;
    }
    if (isset($_SERVER)){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr as $ip){
                $ip = trim($ip);
                if ($ip != 'unknown'){
                    $realip = $ip;
                    break;
                }
            }
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])){
                $realip = $_SERVER['REMOTE_ADDR'];
            }else {
                $realip = '0.0.0.0';
            }
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')){
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }  elseif (getenv('HTTP_CLIENT_IP')){
            $realip = getenv('HTTP_CLIENT_IP');
        } else  {
            $realip = getenv('REMOTE_ADDR');
        }
    }
    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
    return $realip;
}
?>