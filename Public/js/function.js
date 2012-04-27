/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename function.js $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

function showFlash(host, flashvar, obj, shareid) {
    var flashAddr = {'youku.com' : 'http://player.youku.com/player.php/sid/FLASHVAR/v.swf',
        'ku6.com' : 'http://player.ku6.com/refer/FLASHVAR/v.swf',
        'tudou.com' : 'http://www.tudou.com/v/FLASHVAR/v.swf',
        'sohu.com' : 'http://v.blog.sohu.com/fo/v4/FLASHVAR',
        'mofile.com' : 'http://tv.mofile.com/cn/xplayer.swf?v=FLASHVAR',
        'sina.com.cn' : 'http://vhead.blog.sina.com.cn/player/outer_player.swf?vid=FLASHVAR',
        'youtube.com' : 'http://www.youtube.com/embed/FLASHVAR',
        'music' : 'FLASHVAR','flash':'FLASHVAR'
    };
    var flash = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="390" height="310"><param name="movie" value="FLASHADDR" /><param name="quality" value="high" /><param name="bgcolor" value="#FFFFFF" /><embed width="390" height="310" menu="false" quality="high" src="FLASHADDR" type="application/x-shockwave-flash" /></object>';
    var videoFlash = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="390" height="395"><param value="transparent" name="wmode"/><param value="FLASHADDR" name="movie" /><embed src="FLASHADDR" wmode="transparent" allowfullscreen="true" type="application/x-shockwave-flash" width="390" height="360"></embed></object>';
    var musicFlash = '<object id="audioplayer_SHAREID" height="24" width="290" data="'+pubdir+'/images/player.swf" type="application/x-shockwave-flash"><param value="'+pubdir+'/images/player.swf" name="movie"/><param value="autostart=yes&righticon=0xF2F2F2&righticonhover=0xFFFFFF&text=0x999999&slider=0x357DCE&track=0xFFFFFF&border=0xFFFFFF&loader=0xcccccc&soundFile=FLASHADDR" name="FlashVars"/><param value="transparent" name="wmode"/><param value="high" name="quality"/><param value="false" name="menu"/><param value="#FFFFFF" name="bgcolor"/></object>';
    var musicMedia = '<object height="64" width="290" data="FLASHADDR" type="audio/x-ms-wma"><param value="FLASHADDR" name="src"/><param value="1" name="autostart"/><param value="true" name="controller"/></object>';
    var flashHtml = videoFlash;
    var videoMp3 = true;
    if('' == flashvar) {return false;}
    if('music' == host) {
        var mp3Reg = new RegExp('.mp3$', 'ig');
        var flashReg = new RegExp('.swf$', 'ig');
        flashHtml = musicMedia;videoMp3 = false;
        if(mp3Reg.test(flashvar)) {
            videoMp3 = true;
            flashHtml = musicFlash;
        } else if(flashReg.test(flashvar)) {
            videoMp3 = true;
            flashHtml = flash;
        }
    }
    flashvar = encodeURI(flashvar);
    if(flashAddr[host]) {
        var flash = flashAddr[host].replace('FLASHVAR', flashvar);
        flashHtml = flashHtml.replace(/FLASHADDR/g, flash);
        flashHtml = flashHtml.replace(/SHAREID/g, shareid);
    }
    if(!obj) {
        $('#flash_div_' + shareid).html(flashHtml);
    }
    if(flashAddr[host]) {
        $("<div id='flash_div_"+shareid+"'></div>").appendTo(obj.parentNode);
        $("#flash_div_"+shareid).html(flashHtml);
        $("#flash_div_"+shareid).append("&nbsp;&nbsp;<a class='shouqi' onclick='$(\"#flash_div_"+shareid+"\").remove();$(\"#img_"+shareid+"\").css(\"display\",\"block\")' href='javascript:void(0)'><img src='"+pubdir+"/images/top.gif' style='width:12px;height:15px;padding:0px'></a>");
        $(obj).css("display","none");
    }
}
function explode(inputstring, separators, includeEmpties) {
    inputstring = new String(inputstring);
    separators = new String(separators);
    if(separators == "undefined") {
        separators = " :;";
    }
    fixedExplode = new Array(1);
    currentElement = "";
    count = 0;
    for(x=0; x < inputstring.length; x++) {
        str = inputstring.charAt(x);
        if(separators.indexOf(str) != -1) {
            if ( ( (includeEmpties <= 0) || (includeEmpties == false)) && (currentElement == "")) {
            }else {
                fixedExplode[count] = currentElement;
                count++;
                currentElement = "";
            }
        }
        else {
            currentElement += str;
        }
    }
    if (( ! (includeEmpties <= 0) && (includeEmpties != false)) || (currentElement != "")) {
        fixedExplode[count] = currentElement;
    }
    return fixedExplode;
}
function isKeyTrigger(e,keyCode){
    var argv = isKeyTrigger.arguments;
    var argc = isKeyTrigger.arguments.length;
    var bCtrl = false;
    if(argc > 2){
        bCtrl = argv[2];
    }
    var bAlt = false;
    if(argc > 3){
        bAlt = argv[3];
    }
    var nav4 = window.Event ? true : false;
    if(typeof e == 'undefined') {
        e = event;
    }
    if( bCtrl && !((typeof e.ctrlKey != 'undefined') ? e.ctrlKey : e.modifiers & Event.CONTROL_MASK > 0)){
        return false;
    }
    if( bAlt && !((typeof e.altKey != 'undefined') ? e.altKey : e.modifiers & Event.ALT_MASK > 0)){
        return false;
    }
    var whichCode = 0;
    if (nav4) whichCode = e.which;
    else if (e.type == "keypress" || e.type == "keydown") whichCode = e.keyCode;
    else whichCode = e.button;
    return (whichCode == keyCode);
}
function GetRandomNum(Min,Max) {
    var Range = Max - Min;
    var Rand = Math.random();
    return(Min + Math.round(Rand * Range));
}
function indextop() {
    if(jQuery.browser.safari) {
        jQuery('body').animate({scrollTop:0}, 'fast');return false;
    } else {
        jQuery('html').animate({scrollTop:0}, 'fast');return false;
    }
}
function isLegal(str){
    if(str >= '0' && str <= '9'){return true;}
    if(str >= 'a' && str <= 'z'){return true;}
    if(str >= 'A' && str <= 'Z'){return true;}
    if(str == '_'){return true;}
    var reg = /^[\u4e00-\u9fa5]+$/i;
    if (reg.test(str)){return true;}
    return false;
}
function regname(str){
    if(str=="" || str==undefined) {return false;}
    for (i=0; i<str.length; i++) {
        if (!isLegal(str.charAt(i))){
            return false;
        }
    }
    return true;
}
function clearhtml(text) {
    var regEx = /<[^>]*>/g;
    return text.replace(regEx, "");
}
function isChinese(str) {
   var lst = /[u00-uFF]/;
   return !lst.test(str);
}
function CheckLen(str) {
   var strlength=0;
   for (i=0;i<str.length;i++) {
     if (isChinese(str.charAt(i))==true) {
        strlength=strlength + 2;
     } else {
        strlength=strlength + 1;
     }
   }
   return strlength;
}
function countCharacters(str, len) {
    if(!str || !len) { return ''; }
    var a = 0;
    var i = 0;
    var temp = '';
    for (i=0;i<str.length;i++) {
        a++;
        if(a > len) { return temp; }
         temp += str.charAt(i);
    }
    return str;
}
function countCharacters2(str, startlen,len) {
    if(!str) { return ''; }
    var _startlen=startlen?startlen:0;
    var _len=len?len:(str.length-startlen);
    var a = 0;
    var i = 0;
    var temp = '';
    for (i=_startlen;i<str.length;i++) {
        a++;
        if(a == _len+1) {
            return temp;
        } else {
            temp += str.charAt(i);
        }
    }
    return temp;
}
function cnCharacters(str, len) {
    if(!str || !len) { return ''; }
    var a = 0;
    var i = 0;
    var temp = '';
    for (i=0;i<CheckLen(str);i++) {
        if (isChinese(str.charAt(i))==true) {
            a+=2;
        } else {
            a++;
        }
        if(a > len) { return temp; }
        temp += str.charAt(i);
    }
    return str;
}
function jsop(url,mes){
    tologin();
    var mymes=confirm(mes);
    if(mymes==true){window.location=url;}
}
function tologin(){
    if (!my_uid) {
        location.href=siteurl+'/login';return;
    }
}
function creditshow(data) {
    $('#credit > .credit').html(data);
    $('#credit').fadeIn('normal');
    setTimeout("$('#credit > .credit').html('');$('#credit').fadeOut('normal');", 2000);
}