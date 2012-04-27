/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename common.js $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

var autoupdateid;
var etobj=jQuery.parseJSON(etuser);
var setok=etobj.setok;
var siteurl=etobj.siteurl;
var pubdir=etobj.pubdir;
var my_uid=etobj.my_uid;
var user_name=etobj.user_name;
var nickname=etobj.nickname;
var space=etobj.space;
var lasttalk;
var hometipid=0;
var wblayertimeid;
var matchURL = new RegExp("((?:http|https|ftp|mms|rtsp)://(&(?=amp;)|[A-Za-z0-9\./=\?%_~@&#:;\+\-])+)","ig");
var titlec;
$(document).ready(function(){
    titlec=$("title").html();
    $("#main").height(parseInt($("#columns").height())-36);
    /*input num*/
    $("#contentbox").keyup(function(event){
        var len=typenums('#contentbox');
        if (len<0) {
            $(".sendsp").html(langjs['word_exceed']+'<font color="red"><span id="nums">'+(-len)+'</span></font>'+langjs['word']);
        } else {
            $(".sendsp").html(langjs['can_input']+'<span id="nums">'+len+'</span>'+langjs['word']);
        }
        atuserlist('contentbox',event);
    });
    $("#contentbox").click(function(event){atuserlist('contentbox',event);});
    /*hometabs*/
    $(".homestabs > .menu: li").mouseover(function(){$(this).find('b').addClass("arrHover");});
    $(".homestabs > .menu: li").mouseout(function(){$(this).find('b').removeClass("arrHover");});
    $(window).scroll(function(){if ($(window).scrollTop()>0) {$(".gotop").fadeIn("fast");} else {$(".gotop").fadeOut("fast");}});
    $("ol li").mouseover(function(){if (this.parentNode.id!='nolignt' && this.id!='nonemsg') {$(this).addClass("light");$(this).removeClass("unlight");$(this).removeClass("new");}});
    $("ol li").mouseout(function(){if (this.parentNode.id!='nolignt' && this.id!='nonemsg') {$(this).addClass("unlight");$(this).removeClass("light");$(this).removeClass("new");}});
    $("a").focus(function(){this.blur()});
    $("input:button").focus(function(){this.blur()});
    $('#topcity').change(function(){
        var topcity=$(this).val();
        window.location.href=siteurl+'/Hot?c='+encodeURIComponent(topcity);
    });
    $("#mytopic li").mouseover(function(){
        $(this).find('.num').show();
    });
    $("#mytopic li").mouseout(function(){
        $(this).find('.num').hide();
    });
    $("#plugins").mouseover(function(){
        $(this).attr('class','on');
        $('.subNav').show();
    });
    $("#plugins").mouseout(function(){
        $(this).attr('class','');
        $('.subNav').hide();
    });
    var subNavwid=parseInt($('.subNav').css('width'))+20;
    $('.subNav > p').each(function(){
        $(this).css('width',subNavwid+'px');
    });
    $('.topic').mouseover(function(){$('#sharetopic').show();});
    $('.topic').mouseout(function(){$('#sharetopic').hide()});
    $('.video').mouseover(function(){$('#sharevideo').show()});
    $('.video').mouseout(function(){$('#sharevideo').hide()});
    $('#uploadbtn').change(function(){uploadpic($(this).val());});
    /*pic rot*/
    picctrl();
    /*tip*/
    if (setok && setok!=-1) {ye_msg.open(setok,3,4);}
    $('#switchlang').change(function(){
        $.cookie('etlang',$('#switchlang').val());
        window.location.reload();
    });
    $(document).keydown(function(event){
        event = event || window.event;
        if (event.keyCode==27) {
            ye_dialog.close();
        }
    });
    /*auto update*/
    if (window.location.href==siteurl+'/'+encodeURIComponent(etobj.user_name) && etobj.space=='home') {
        hometipid=$('#stream > ol > li').first().attr('id');
    }
    if (my_uid!=0 && autorefresh==1) {
        setInterval(autoloadtip,10000);
        hometipclick();
    }
    $('textarea').live('blur',function(e){
        $(document).click(function(ev){
            if ($.browser.msie) {
                cname=ev.srcElement.className;
            } else {
                cname=ev.target.className;
            }
            if (cname!='cur') {
                $('.atusers').remove();
                $('.atmask').remove();
            }
        });
    });
    /*photo*/
    $('#loadform').mouseover(function(){
        $('#loadform > a').css('text-decoration','underline');
    });
    $('#loadform').mouseout(function(){
        $('#loadform > a').css('text-decoration','none');
    });
    $('.photo').mouseover(function(){
        if ($('#loadform').css('display')=='block' && $('.outphotobox').css('display')=='none') {
            $('.photobox').show();
        }
    });
    $('.photo').mouseout(function(){
        $('.photobox').hide();
    });
    $('#upptpr').live('mouseover',function(){
        $('#priviewpoic').show();
    });
    $('#upptpr').live('mouseout',function(){
        $('#priviewpoic').hide();
    });
    /*wblayer*/
    wblayeract();
    sidelay();
});
function wblayer(nickname,div,pos){/*pos=ntop nbottom nright*/
    var ext=$('.wblayerbox[nickname='+nickname+']');
    if (ext.html()!=null) {
        ext.attr('style',div+';display:none');
        ext.find('.mm').find('div').first().removeClass();
        ext.find('.mm').find('div').first().addClass(pos);
        ext.fadeIn("fast");
    } else {
        var html='<div class="wblayerbox" nickname="'+nickname+'" style="'+div+';display:none">';
        html+='<table class="wbLayer" cellspacing="0" cellpadding="0">';
        html+='    <tr><td class="topl"></td><td class="topm"></td><td class="topr"></td></tr>';
        html+='    <tr><td class="ml"></td><td class="mm">';
        html+='        <div class="'+pos+'"></div>';
        html+='        <div class="laycont"><div style="height:160px"><br/><br/><center><img src="'+pubdir+'/images/loading.gif"><br/><br/>'+langjs['loadings']+'</center></div></div>';
        html+='    </td><td class="mr"></td></tr>';
        html+='    <tr><td class="bottoml"></td><td class="bottomm"></td><td class="bottomr"></td></tr>';
        html+='</table>';
        html+='</div>';

        $('#container').append(html);
        ext=$('.wblayerbox[nickname='+nickname+']');
        ext.fadeIn("fast");

        $.post(siteurl+"/Api/userpreview",{nickname:nickname},
        function(msg){
            ext.find('.laycont').html(msg);
        });
    }

}
function getCursortPosition(ctrl) {
    var CaretPos = 0;
    if (document.selection) {
    ctrl.focus ();
        var Sel = document.selection.createRange ();
        Sel.moveStart ('character', -ctrl.value.length);
        CaretPos = Sel.text.length;
    }
    else if (ctrl.selectionStart || ctrl.selectionStart == '0')
        CaretPos = ctrl.selectionStart;
    return (CaretPos);
}
function setCaretPosition(ctrl,pos1,pos2){
    var textArea = document.getElementById(ctrl);
    if (document.selection) {
         var rng = textArea.createTextRange();
         rng.collapse(true);
         rng.moveEnd("character",pos2);
         rng.moveStart("character",pos1);
         rng.select();
    } else if (textArea.selectionStart || (textArea.selectionStart == '0')) {
        textArea.selectionStart = pos1;
        textArea.selectionEnd = pos2;
    }
    textArea.focus();
}
/*黑名单开始*/
function add2black(uid,uname){
    tologin();
    var html='<div style="margin-left:20px;font-size:14px">'+langjs['blackinfo']+'<div><br/><center><input type="button" onclick="doadd2black(\''+uid+'\',\''+uname+'\')" value="'+langjs['addok']+'" class="button2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="ye_dialog.close()" value="'+langjs['closewindow']+'" class="button3"></center>';
    ye_dialog.openHtml(html,langjs['black'],'350','180');
}
function doadd2black(uid,uname){
    tologin();
    $.post(siteurl+"/Blacklist/addblack", {uid:uid,uname:uname},
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        ye_dialog.close();
        if (stdata.ret=='success') {
            ye_msg.open(stdata.tip,1,1);
            setTimeout(function(){
                window.location.href=siteurl+"/"+uname;
            },1000);
        } else {
            ye_msg.open(stdata.tip,1,2);
        }
    });
}
function delblack(uid,uname){
    tologin();
    var html='<center>'+langjs['blackinfo2']+'<br/><br/><input type="button" onclick="dodelblack(\''+uid+'\',\''+uname+'\')" value="'+langjs['delok']+'" class="button2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="ye_dialog.close()" value="'+langjs['closewindow']+'" class="button3"></center>';
    ye_dialog.openHtml(html,langjs['black'],'350','140');
}
function dodelblack(uid,uname){
    tologin();
    $.post(siteurl+"/Blacklist/delblack", {uid:uid},
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        ye_dialog.close();
        if (stdata.ret=='success') {
            ye_msg.open(stdata.tip,1,1);
            setTimeout(function(){
                window.location.href=siteurl+"/"+uname;
            },1000);
        } else {
            ye_msg.open(stdata.tip,1,2);
        }
    });
}
/*黑名单结束*/
function atuserlist(aid,event) {
    var pos1=getCursortPosition(document.getElementById(aid));
    var pos2=$('#'+aid).val().slice(0,pos1).lastIndexOf('@');
    var space1=$('#'+aid).val().slice(pos2,pos1).lastIndexOf(' ');
    var space2=$('#'+aid).val().slice(pos2,pos1).lastIndexOf('\n');
    $('#'+aid).keydown(function(e){
        e=e||window.event;
        if(((e.keyCode=="40" || e.keyCode=="38" || e.keyCode=="13") && $('.atusers').html()!=null) || e.keyCode=="27") {
            return false;
        }
    });
    if(event.keyCode!=38 && event.keyCode!=40 && event.keyCode!=13 && event.keyCode!=27){
        if (pos2!=-1 && space1==-1 && space2==-1) {
            var keyword=$('#'+aid).val().slice(pos2,pos1);
            keyword=keyword.replace('@','');
            keyword=keyword?keyword:'';

            $.post(siteurl+"/Api/atuserlist",{keyword:keyword},
            function(msg){
                $('.atusers').remove();
                $('.atmask').remove();
                var s1='<span>'+$('#'+aid).val().slice(0,pos2).replace(/\n/g,'<br>')+'</span>';
                var s2='<span>@</span>';
                var s3='<span>'+$('#'+aid).val().slice(pos2+1,$('#'+aid).val().length).replace(/\n/g,'<br>')+'</span>';
                if (aid=='contentbox') {
                    fs='font-size:14px;line-height:18px;'
                } else {
                    fs='font-size:12px;line-height:15px;';
                }
                $('#container').after('<div class="atmask" style="'+fs+'width:'+$('#'+aid).css('width')+';height:'+$('#'+aid).css('height')+';top:'+($('#'+aid).offset().top+5)+'px;left:'+($('#'+aid).offset().left+7)+'px">'+s1+s2+s3+'</div>');
                $('#container').after('<div class="atusers"><div class="attip">想用@提到谁？ESC取消</div><ul>'+msg+'</ul></div>');
                var attop=parseInt($('.atmask').find('span:eq(1)').offset().top)+20-$('#'+aid).scrollTop();
                if ($.browser.msie) {
                    attop=parseInt($('.atmask').find('span:eq(1)').offset().top)+20-$('#'+aid).scrollTop();
                }
                $('.atusers').css({"left":$('.atmask').find('span:eq(1)').offset().left,"top":attop+'px'});
                $('.atusers > ul > li').mouseover(function(){$('.atusers > ul > li').removeClass();$(this).addClass("cur");});
                $('.atusers > ul > li').mouseout(function(){$('.atusers > ul > li').removeClass();});
                $(".atusers > ul > li").first().addClass("cur");
                $('.atusers > ul > li').click(function(){
                    var n1=$('#'+aid).val().slice(0,pos2);
                    var n2=$('#'+aid).val().slice(pos1,$('#'+aid).val().length);
                    var prev=n1+"@"+$(this).html()+' ';
                    var newc=prev+n2;
                    $('#'+aid).val(newc);
                    $('#'+aid).focus();
                    setCaretPosition(aid,prev.length,prev.length);
                    $('.atusers').remove();
                    $('.atmask').remove();
                });
            });
        } else {
            $('.atusers').remove();
            $('.atmask').remove();
        }
    } else {
        if (event.keyCode==40) {
            if ($('.atusers').html()!=null){
                var aul=$('.atusers > ul');
                var n=aul.find('.cur').index();
                if (n==-1 || n>=$('.atusers > ul > li').length-1) {
                    n=0;
                } else {
                    n=n+1;
                }
                $('.atusers > ul > li').removeClass();
                $(".atusers > ul > li").eq(n).addClass("cur");
                $('.atusers > ul').scrollTop((n-6)*$(".atusers > ul > li").eq(n).height());
            }
        } else if (event.keyCode==38) {
            if ($('.atusers').html()!=null){
                var aul=$('.atusers > ul');
                var n=aul.find('.cur').index();
                if (n==-1) {
                    n=0;
                } else if (n==0) {
                    n=$('.atusers > ul > li').length-1;
                } else {
                    n=n-1;
                }
                $('.atusers > ul > li').removeClass();
                $(".atusers > ul > li").eq(n).addClass("cur");
                $('.atusers > ul').scrollTop((n-6)*$(".atusers > ul > li").eq(n).height());
            }
        } else if (event.keyCode==13) {
            if ($('.atusers').html()!=null){
                var aul=$('.atusers > ul');
                var n=aul.find('.cur').index();
                if (n!=-1) {
                    var n1=$('#'+aid).val().slice(0,pos2);
                    var n2=$('#'+aid).val().slice(pos1,$('#'+aid).val().length);
                    var newc=n1+"@"+$(".atusers > ul > li").eq(n).html()+' '+n2;
                    $('#'+aid).val(newc);
                    $('#'+aid).focus();
                }
                $('.atusers').remove();
                $('.atmask').remove();
            }
        } else if (event.keyCode==27) {
            if ($('.atusers').html()!=null){
                $('.atusers').remove();
                $('.atmask').remove();
            }
        }
    }
}

function autoloadtip() {
    $.get(siteurl+'/Api/autoloadtip/hometipid/'+hometipid+'/rank/'+GetRandomNum(1,999999),
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        if (stdata.ret=="success") {
            if (parseInt(stdata.priread)>0) {
                $('#t_msg').show();
                $('#t_msg_num').html(stdata.priread);
                $('#msgtip').html('('+stdata.priread+')');
                $('.tipmsg').show();
            } else {
                $('#t_msg').hide();
                $('#msgtip').html('');
            }
            if (parseInt(stdata.comments)>0) {
                $('#t_comment').show();
                $('#t_comment_num').html(stdata.comments);
                $('#commentstip').html('('+stdata.comments+')');
                $('.tipmsg').show();
            } else {
                $('#t_comment').hide();
                $('#commentstip').html('');
            }
            if (parseInt(stdata.newfollownum)>0) {
                $('#t_follow').show();
                $('#t_follow_num').html(stdata.newfollownum);
                $('.tipmsg').show();
            } else {
                $('#t_follow').hide();
            }
            if (parseInt(stdata.atnum)>0) {
                $('#t_at').show();
                $('#t_at_num').html(stdata.atnum);
                $('#atnum').html('('+stdata.atnum+')');
                $('.tipmsg').show();
            } else {
                $('#t_at').hide();
                $('#atnum').html('');
            }
            if (parseInt(stdata.tipcount)>0) {
                document.title='('+stdata.tipcount+')'+titlec;
                hometipid=$('#stream > ol > li').first().attr('id');
                $('.homeautotip').html(langjs['have']+stdata.tipcount+langjs['newweibo']);
                $('.homeautotip').show();
            } else {
                $('.homeautotip').html('');
                document.title=titlec;
                $('.homeautotip').hide();
            }
            if ($('#t_msg').css('display')=='none' && $('#t_comment').css('display')=='none' && $('#t_follow').css('display')=='none' && $('#t_at').css('display')=='none') {
                $('.tipmsg').hide();
            }
        }
    });
}
function hometipclick() {
    $('.homeautotip').click(function(){
        $('.homeautotip').html('<img src="'+pubdir+'/images/spinner.gif"> '+langjs['loadings']);
        $.get(siteurl+'/Api/loadnewmsg/hometipid/'+hometipid+'/rank/'+GetRandomNum(1,999999),
        function(msg){
            var stdata=jQuery.parseJSON(msg);
            if (stdata.ret=='success') {
                $('.homeautotip').html('');
                $('.homeautotip').hide();
                $(document).find('title').html(titlec);
                $('#stream > ol > li').each(function(){
                    if (parseInt($(this).attr('id'))>parseInt(hometipid)) {
                        $(this).remove();
                    }
                });
                $('#stream > ol > li').first().before(stdata.data.replace('class="unlight"','class="unlight new"'));

                var loadnum=stdata.data.match(/\<\/li>/gi).length;
                $("ol li").slice(0, loadnum).mouseover(function(){
                   $(this).addClass("light");
                   $(this).removeClass("unlight");
                   $(this).removeClass("new");
                });
                $("ol li").slice(0, loadnum).mouseout(function(){
                   $(this).addClass("unlight");
                   $(this).removeClass("light");
                   $(this).removeClass("new");
                });
                $("ol li").slice(0, loadnum).find("a").focus(function(){this.blur()});

                picctrl();
                wblayeract();

                hometipid=$('#stream > ol > li').first().attr('id');
            } else {
                ye_msg.open(langjs['data_error'],3,2);
            }
        });
    });
}
function CheckAll(name,ckall,text) {
    var cbox=$("input[name='"+name+"[]']");
    var sc=$("#"+ckall).attr("checked");
    if (text) {
        if (sc) {
            $("#"+ckall).removeAttr("checked");
        } else {
            $("#"+ckall).attr("checked","checked");
        }
        sc=$("#"+ckall).attr("checked");
    }
    for(var i=0; i<cbox.length;i++){
        if(sc){
            cbox.get(i).checked = true;
        } else {
            cbox.get(i).checked = false;
        }
    }
}
function typenums(id){
    var cval=$(id).val();
    var webnum=cval.match(matchURL);
    if (webnum) {
        webnum=webnum.length;
    } else {
        webnum=0;
    }
    cval= cval.replace(matchURL, shorturl);
    var len=$.trim(cval).length+(webnum*8);
    len=140-len;
    return len;
}
function picctrl(){
    $(".imageshow > .miniImg").live('click',function(){
        $(this).hide();
        $(this).parent().find('.artZoomBox').show();
    });
    $(".imageshow").find('.maxImgLink').live('click',function(){
        $(this).parent().parent().find('.miniImg').show();
        $(this).parent().hide();
    });
    $(".imageshow").find('.hideImg').live('click',function(){
        $(this).parent().parent().parent().find('.miniImg').show();
        $(this).parent().parent().hide();
    });
    $(".imageshow").find('.imgRight').live('click',function(){
        $(this).parent().parent().find('.maxImg').rotateRight(90);
    });
    $(".imageshow").find('.imgLeft').live('click',function(){
        $(this).parent().parent().find('.maxImg').rotateLeft(90);
    });
}
/*emotion*/
function closetip(id) {
    $("#"+id).hide();
    if ($('#t_msg').css('display')=='none' && $('#t_comment').css('display')=='none' && $('#t_follow').css('display')=='none' && $('#t_at').css('display')=='none') {
        $('.tipmsg').hide();
    }
}
function showemotion(em,pid) {
    $('.emotions').remove();
    $("#"+em).html('<div class="emotions"><div class="emoreview" style="display:none"></div><ul class="emotion"><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(疑问)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(惊喜)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(鄙视)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(呕吐)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(拜拜)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(大笑)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(求)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(色)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(撇嘴)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(调皮)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(流泪)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(偷笑)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(鲜花)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(流汗)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(困)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(惊恐)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(闪人)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(惊讶)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(心)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(发怒)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(发愁)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(投降)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(便便)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(害羞)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(大哭)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(得意)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(跪服)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(难过)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(生气)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(闭嘴)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(抓狂)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(人品)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(钱)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(酷)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(挨打)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(痛打)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(阴险)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(困惑)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(尴尬)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(发呆)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(睡)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(嘘)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(鼻血)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(可爱)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(亲吻)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(寒)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(谢谢)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(顶)\')"></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(胜利)\')"></a></li><li> </li><li> </li><li><a href="javascript:void(0);" onclick="closeemotion(\''+em+'\')"></a></li></ul></div>');
    $("#"+em).show();
    $('.emotion > li').mousemove(function(){
        var n=$(this).prevAll("li").length;
        var pattern=/\'\(([^\s]+)\)\'/gi;
        var mts = pattern.exec($(this).html());
        if ((n>=0 && n<=6) || (n>=13 && n<=19) || (n>=26 && n<=32) || (n>=39 && n<=45)) {
            $('.emoreview').css('margin-left','260px');
        } else {
            $('.emoreview').css('margin-left','1px');
        }
        $('.emoreview').html('<img src="'+pubdir+'/images/emotion/'+(n+1)+'.gif"><br/>'+mts[1]);
        $('.emoreview').show();
    });
}
function emotion(em,id,emo) {
    $("#"+id).insertAtCaret(emo);
    closeemotion(em);
}
function closeemotion(id) {
     $("#"+id).html('');
     $("#"+id).hide();
     $('.emoreview').hide();
}
/*del msg*/
function delcomment(fromwhere) {
    var cbox=$('input[name="delcid[]"]:checked');
    var cids=new Array();
    if(cbox.length>0){
        if (confirm(langjs['delete_true_select'])) {
            for(var i=0; i<cbox.length;i++){
                cids[i]=cbox.get(i).value;
            }
        }
    }
    if (cids.length>0) {
        $.post(siteurl+"/Comments/delmsg", {cmid:cids},
        function(msg){
            var stdata=jQuery.parseJSON(msg);
            if (stdata.ret=='success') {
                ye_msg.open(stdata.tip,1,1);
                setTimeout(function(){
                    window.location.href=siteurl+"/Comments/"+fromwhere;
                },1000);
            } else {
                ye_msg.open(stdata.tip,1,2);
            }
        });
    }
}
function delmsg(url,mes,obj,reurl) {
    tologin();
    $('.emotions').hide();
    var mymes;
    mymes=confirm(mes);
    if(mymes==true){
        $.get(url,
        function(msg){
            var stdata=jQuery.parseJSON(msg);
            if (stdata.ret=="success") {
                if (!reurl) {
                    $(obj).animate({opacity: 'toggle'}, "slow");
                    ye_msg.open(stdata.tip,1,1);
                } else {
                    location.href=reurl;
                    return;
                }
            } else {
                ye_msg.open(stdata.tip,3,2);
            }
        });
    }
}
function followop(url,mes,mes2,uname,unickname,uid,status) {
    tologin();
    var mymes;
    if (mes2=='gz') {
        mymes=true;
    } else {
        mymes=confirm(mes);
    }
    if(mymes==true){
        $.get(siteurl+'/Space/'+url+'/rand/'+GetRandomNum(1,999999),
        function(msg){
            var stdata=jQuery.parseJSON(msg);
            if (stdata.ret=="success") {
                if (mes2=='gz') {
                    ye_msg.open(stdata.tip,1,1);
                    if (parseInt(status)>=2) {
                        var html="<span class='followbtn'><img src='"+pubdir+"/images/fico.gif'> "+langjs['follow_2']+"&nbsp;|&nbsp;<a href='javascript:void(0)' onclick=\"followop('delfollow/user_name/"+uname+"','"+langjs['jiechu_1']+" "+unickname+" "+langjs['jiechu_2']+"','jc','"+uname+"','"+unickname+"','"+uid+"','"+status+"')\">"+langjs['cancel']+"</a></span>";
                        $('#followsp_'+uid).html(html);
                        $('#followsp2_'+uid).html(html);
                    } else {
                        var html="<span class='followbtn'><img src='"+pubdir+"/images/fico2.gif'> "+langjs['follow_1']+"&nbsp;|&nbsp;<a href='javascript:void(0)' onclick=\"followop('delfollow/user_name/"+uname+"','"+langjs['jiechu_1']+" "+unickname+" "+langjs['jiechu_2']+"','jc','"+uname+"','"+unickname+"','"+uid+"','"+status+"')\">"+langjs['cancel']+"</a></span>";
                        $('#followsp_'+uid).html(html);
                        $('#followsp2_'+uid).html(html);
                    }
                } else {
                    ye_msg.open(stdata.tip,1,1);
                    var html="<a class='bh' onclick=\"followop('addfollow/user_name/"+uname+"','','gz','"+uname+"','"+unickname+"','"+uid+"','"+status+"')\">"+langjs['follow_3']+"</a>";
                    $('#followsp_'+uid).html(html);
                    $('#followsp2_'+uid).html(html);
                }
            } else {
                ye_msg.open(stdata.tip,3,2);
            }
        });
    }
}
function followone(user_name,e) {
    tologin();
    $.get(siteurl+'/Space/addfollow/user_name/'+encodeURIComponent(user_name)+'/rank/'+GetRandomNum(1,999999),
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        if (stdata.ret=='success') {
            $(e).attr("class","yst");
            $(e).attr("onclick","");
            $(e).html(langjs['follow_1']);
            ye_msg.open(stdata.tip,3,1);
        } else {
            ye_msg.open(stdata.tip,3,2);
        }
    });
}
function fltopic(topic,mes,op,obj) {
    tologin();
    var mymes;
    if (op=='fl') {
        mymes=true;
    } else {
        mymes=confirm(mes);
    }
    if(mymes==true){
        $.get(siteurl+'/Topic/follow/keyword/'+encodeURIComponent(topic)+'/op/'+op+'/rank/'+GetRandomNum(1,999999),
        function(msg){
            var stdata=jQuery.parseJSON(msg);
            if (stdata.ret=="success") {
                if (op=='fl') {
                    ye_msg.open(stdata.tip,1,1);
                    $('#followtopic').html("<a class='bl' onclick=\"fltopic('"+topic+"','"+langjs['confirm_topic']+"','jc')\">"+langjs['unfollow_topic']+"</a>");
                } else {
                    ye_msg.open(stdata.tip,1,1);
                    $('#followtopic').html("<a class='bh' onclick=\"fltopic('"+topic+"','','fl')\">"+langjs['follow_topic']+"</a>");
                    if (obj) {
                        $(obj).animate({opacity: 'toggle'}, "slow");
                    }
                }
            } else {
                ye_msg.open(stdata.tip,3,2);
            }
        });
    }
}
function dofavor(id){
    tologin();
    $('.emotions').hide();
    $.get(siteurl+'/Space/dofavor/cid/'+id+"/rank/"+GetRandomNum(1,999999),
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        if (stdata.ret=='success') {
            ye_msg.open(stdata.tip,1,1);
        } else {
            ye_msg.open(stdata.tip,1,2);
        }
    });
}
function loadcity(sfid,ctid,firstload) {
    var select = document.getElementById(sfid);
    var pid = select.item(select.selectedIndex).getAttribute('pid');
    $.get(siteurl+'/Api/getcity/pid/'+pid+"/rank/"+GetRandomNum(1,999999),
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        if (stdata.ret=='success') {
            $('#'+ctid).html(stdata.data);
            if (firstload==1) {
                mycity();
            }
        }
    });
}
/*send msg start*/
function spnums(){
    var len=typenums('#pmcontentbox');
    if (len<0) {
        $("#sendmsgbox").html(langjs['word_exceed']+'<font color="red"><em>'+(-len)+'</em></font>'+langjs['word']);
    } else {
        $("#sendmsgbox").html(langjs['can_input']+'<em>'+len+'</em>'+langjs['word']);
    }
}
function atbox(funame,fid) {
    tologin();
    var html;
    html ='<div id="pmessage" style="background:none"><table border="0" width="100%">';
    html+='<tr><td><textarea id="atcontentbox_'+fid+'" class="input_text" style="width:395px;height:70px;">@'+funame+' </textarea><div id="atemotion_'+fid+'"></div></td></tr>';
    html+='<tr height="40px"><td><div class="fleft"><a href="javascript:void(0);" onclick="showemotion(\'atemotion_'+fid+'\',\'atcontentbox_'+fid+'\')"><img src="'+pubdir+'/images/facelist.gif"></a></div><div class="fright"><span class="tip2 sendsp">'+langjs['can_input']+'<em>140</em>'+langjs['word']+'</span><input class="button4" onclick="sendTalk(1,\'atcontentbox_'+fid+'\')" value="'+langjs['send']+'" type="button"></div></td></tr></table></div>';
    ye_dialog.openHtml(html,'@'+funame,'450','180');
    $('#atcontentbox_'+fid).focus();
    $('.sendsp').html(langjs['can_input']+'<em>'+(140-$.trim('@'+funame).length)+'</em>'+langjs['word']);
    $('#atcontentbox_'+fid).keyup(function(){
        var len=typenums('#atcontentbox_'+fid);
        if (len<0) {
            $(".sendsp").html(langjs['word_exceed']+'<font color="red"><em>'+(-len)+'</em></font>'+langjs['word']);
        } else {
            $(".sendsp").html(langjs['can_input']+'<em>'+len+'</em>'+langjs['word']);
        }
    });
    setCaretPosition('atcontentbox_'+fid,CheckLen($('#atcontentbox_'+fid).val()),CheckLen($('#atcontentbox_'+fid).val()));
}
function sendprimsgbox(funame) {
    tologin();
    var html;
    html ='<div id="pmessage"><table border="0" width="100%">';
    html+='<tr height="30px"><td width="50px">'+langjs['get_messageer']+'</td><td><input type="text" class="input_text" id="senduser" style="width:195px"><span class="tip1">'+langjs['input_account']+'</span></td></tr>';
    html+='<tr><td valign="top">'+langjs['message_send_body']+'</td><td><textarea onkeyup="spnums()" id="pmcontentbox" class="input_text" style="width:350px;height:70px;"></textarea></td></tr>';
    html+='<tr><td colspan="2"><p><span class="tip2" id="sendmsgbox">'+langjs['can_input']+'<em>140</em>'+langjs['word']+'</span><input type="button" class="button4" onclick="sendprimsg()" value="'+langjs['send']+'"></p></td></tr></table></div>';
    ye_dialog.openHtml(html,langjs['send_message'],'450','220');
    if (funame) {
        $("#senduser").val(funame);
        $("#senduser").attr('readonly','readonly');
    } else {
        $("#senduser").autocomplete(siteurl+"/Message/getMsgUser/rank/"+GetRandomNum(1,999999),{delay:400,minChars:1,matchSubset:0,matchContains:1,autoFill:0,scroll:0,width:170,height:170});
    }
}
function sendprimsg() {
    tologin();
    var funame=$("#senduser").val();
    var contents=$("#pmcontentbox").val();
    if (!funame || !contents) {
        ye_msg.open(langjs['form_uncompleted'],1,2);
        return;
    }
    if (typenums("#pmcontentbox")<0) {
        $('#sendmsgbox').hide();
        $('#sendmsgbox').fadeIn("normal");
        return;
    }
    $.post(siteurl+"/Message/sendmsg",{funame:funame,content:contents},
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        if (stdata.ret=="success") {
            ye_msg.open(stdata.tip,1,1);
            ye_dialog.close();
        } else {
            ye_msg.open(stdata.tip,1,2);
        }
    });
}
/*send msg end*/
/*send talk*/
function ctrlEnter_st(e){
    var ie =navigator.appName=="Microsoft Internet Explorer"?true:false;
    if(ie){
        if(event.ctrlKey && window.event.keyCode==13){sendTalk();}
    } else {
        if(isKeyTrigger(e,13,true)){sendTalk();}
    }
}
function sendTalk(noadd,textid) {
    tologin();
    var tid;
    if (textid) {
        tid=textid;
    } else {
        tid='contentbox';
    }
    $('.emotions').hide();
    $('#'+tid).val($('#'+tid).val().replace('#'+langjs['input_topic_title']+'#',''));
    var topic=$('#topic').val();
    var cont=$('#'+tid).val();
    var morecontent=$("#morecontent").html();/*upload pic*/
    morecontent=morecontent==null?'':morecontent;
    if (!cont) {
        ye_msg.open(langjs['talk_isnull'],1,2);
        return false;
    }
    if (topic) {
        cont=topic+cont;
    }
    if (typenums('#'+tid)<0) {
        $('.sendsp').hide();
        $('.sendsp').fadeIn("normal");
        return;
    }
    if(cont==lasttalk && lasttalk!='') {
        ye_msg.open(langjs['same_talk'],1,2);
        return false;
    } else {
        lasttalk=cont;
    }
    $('#'+tid).val('');
    $.post(siteurl+"/Space/sendmsg", {content:cont,morecontent:morecontent},
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        if (stdata.ret=="success") {
            if (noadd!=1) {
                var firstli,firstli2;
                if (stalk=='1') {
                    firstli=$(".wa li").first();
                    firstli.before(stdata.data);
                    firstli2=$(".wa li").first();
                    firstli2.css("display","none");
                    firstli2.animate({height: 'toggle', opacity: 'toggle'}, { duration: "slow" });
                    if ($('.homeautotip').html()=='') {
                        hometipid=$('#stream > ol > li').first().attr('id');
                    }
                    wblayeract();
                    $("#nonemsg").remove();
                }
                $("ol li").slice(0, 1).mouseover(function(){
                   $(this).addClass("light");
                   $(this).removeClass("unlight");
                   $(this).removeClass("new");
                });
                $("ol li").slice(0, 1).mouseout(function(){
                   $(this).addClass("unlight");
                   $(this).removeClass("light");
                   $(this).removeClass("new");
                });
                $("ol li").slice(0, 1).find("a").focus(function(){this.blur()});
                if (topic) {
                    $("#keynum").html(parseInt($("#keynum").html())+1);
                }
            } else {
                ye_dialog.close();
            }
            $("#mymsgnum").html(parseInt($("#mymsgnum").html())+1);
            delUpload();/*clear pic*/
            picctrl();
            ye_msg.open(stdata.tip,1,1);
        } else {
            ye_msg.open(stdata.tip,1,2);
        }
        $('.sendsp').html(langjs['can_input']+"<span id='nums'>140</span>"+langjs['word']);
    });
}
/*topic*/
function topicajax(type) {
    var act;
    if (type==1) {
        act='mytopic';
        $('#topic1').attr('class','selected');
        $('#topic2').removeAttr('class');
    } else {
        act='tjtopic';
        $('#topic2').attr('class','selected');
        $('#topic1').removeAttr('class');
    }
    $('.tagB').html('<br/><center><img src="'+pubdir+'/images/loading.gif"> '+langjs['topic_loading']+'</center><br/>');
    $.get(siteurl+"/Topic/"+act+"/rank/"+GetRandomNum(1,999999),
    function(msg){
        $('.tagB').html(msg);
    });
}
/*reply start*/
function ctrlEnter_rb(e,id,closebox){
    var ie =navigator.appName=="Microsoft Internet Explorer"?true:false;
    if(ie){
        if(event.ctrlKey && window.event.keyCode==13){replysend(id,closebox);}
    } else {
        if(isKeyTrigger(e,13,true)){replysend(id,closebox);}
    }
}
function replyajax(contid) {
    if ($('#reply_'+contid).html()) {
        $('#reply_'+contid).html('');
    } else {
        $('#reply_'+contid).html('<span style="margin:10px 0 0 30px"><img src="'+pubdir+'/images/spinner.gif"></span>');
        $.get(siteurl+"/Space/reply/cid/"+contid+"/rank/"+GetRandomNum(1,999999),
        function(msg){
            $('#reply_'+contid).html(msg);
            $('#replybox_'+contid).focus();
            $('#replybox_'+contid).click(function(event){atuserlist('replybox_'+contid,event);});
            replaylay();
        });
    }
}
function replyajaxbox(contid,conbox) {
    conbox=conbox==undefined?contid:conbox;
    if ($('#reply_'+conbox).html()) {
        $('#reply_'+conbox).html('');
    } else {
        $('.replyspan').html('');
        var html='<div class="status_reply_list"><div class="arrow1"></div><div class="top"></div><div class="cont"><table border="0" width="100%"><tr><td><div class="fleft" style="margin-top:8px"><a href="javascript:void(0);" onclick="showemotion(\'emotion_'+contid+'\',\'replybox_'+contid+'\')"><img src="'+pubdir+'/images/facelist.gif"></a></div><textarea id="replybox_'+contid+'" onkeyup="replynums(\'replybox_'+contid+'\',\'rnum_'+contid+'\',event);" onkeydown="javascript:return ctrlEnter_rb(event,\''+contid+'\',1);" class="input_text replytextarea"></textarea><div class="clearline"></div></td></tr><tr><td><div id="emotion_'+contid+'"></div><div class="fleft"><input type="checkbox" class="replaycheckbox" id="replycheckbox_'+contid+'"><label for="replycheckbox_'+contid+'" class="replycheckbox">'+langjs['ret_to_mytalk']+'</label></div><div class="fright"><span class="inputnum" id="rnum_'+contid+'">'+langjs['can_input']+'<em>140</em>'+langjs['word']+'</span><input type="button" id="replybutton_'+contid+'" class="button1" value="'+langjs['reply']+'" onclick="replysend(\''+contid+'\',1)"/></div><div class="clearline"></div></td></tr></table></div><div class="bottom"></div></div>';
        $('#reply_'+conbox).html(html);
        $('#replybox_'+contid).focus();
        $('#replybox_'+contid).click(function(event){atuserlist('replybox_'+contid,event);});
    }
}
function replysend(id,closebox) {
    tologin();
    $('.emotions').hide();
    $('#replybox_'+id).val($('#replybox_'+id).val().replace('#'+langjs['input_topic_title']+'#',''));
    var isret=$("#replycheckbox_"+id).attr('checked');
    var cont=$('#replybox_'+id).val();
    if ($('#replybox_'+id).val()=="") {
        ye_msg.open(langjs['reply_isnull'],1,2);
        return false;
    } else if (typenums('#replybox_'+id)<0)  {
        $('#rnum_'+id).hide();
        $('#rnum_'+id).fadeIn("normal");
        return;
    } else {
        if(cont==lasttalk && lasttalk!='') {
            ye_msg.open(langjs['same_talk'],1,2);
            return false;
        } else {
            lasttalk=cont;
        }
        $('#replybutton_'+id).attr("disabled","disabled");
        $.post(siteurl+"/Space/doreply",{sid:id,closebox:closebox,scont:cont,rck:isret},
        function(msg){
            var stdata=jQuery.parseJSON(msg);
            if (stdata.ret=="success") {
                if (parseInt(closebox)==1) {
                    ye_msg.open(stdata.tip,1,1);
                } else {
                    var firstli,firstli2;
                    firstli=$("#reply_"+id+" .reply_list_ul li").first();
                    if (firstli.length>0) {
                        firstli.before(stdata.data);
                        firstli2=$("#reply_"+id+" .reply_list_ul li").first();
                        firstli2.css("display","none");
                        firstli2.animate({height: 'toggle', opacity: 'toggle'}, { duration: "slow" });
                    } else {
                        $("#reply_"+id+" .reply_list_ul").append(stdata.data);
                        firstli2=$("#reply_"+id+" .reply_list_ul li").first();
                        firstli2.css("display","none");
                        firstli2.animate({height: 'toggle', opacity: 'toggle'}, { duration: "slow" });
                    }
                    replaylay();
                }
            } else {
                ye_msg.open(stdata.tip,1,2);
            }
            $('#rnum_'+id).html(langjs['can_input']+"<em>140</em>"+langjs['word']);
            $('#replybox_'+id).val("");
            $('#replybutton_'+id).removeAttr("disabled");
        });
    }
}
function replyajaxin(inputid,nickname) {
    var atto='@'+nickname+' ';
    $('#replybox_'+inputid).focus();
    $('#replybox_'+inputid).val(atto);
}
function replynums(val,nums,event){
    var len=typenums("#"+val);
    if (len<0) {
        $("#"+nums).html(langjs['word_exceed']+'<font color="red"><em>'+(-len)+'</em></font>'+langjs['word']);
    } else {
        $("#"+nums).html(langjs['can_input']+'<em>'+len+'</em>'+langjs['word']);
    }
    $("#"+val).height('18px');
    var setheight = $("#"+val).get(0).scrollHeight;
    if ($.browser.msie && ($.browser.version=='6.0' || $.browser.version=='7.0')) {
        setheight=setheight-7;
    }
    if ($.browser.safari) {
        setheight=setheight-10;
    }
    if($("#"+val).attr("height") != setheight) {
        $("#"+val).height(setheight+"px").attr("height",setheight);
    } else {
        $("#"+val).height($("#"+val).attr("height")+"px");
    }
    atuserlist(val,event);
}
/*reply start*/
/*ret start*/
function retnums(val,nums,event){
    var len=typenums("#"+val);
    if (len<0) {
        $("#"+nums).html(langjs['word_exceed']+'<font color="red"><em>'+(-len)+'</em></font>'+langjs['word']);
    } else {
        $("#"+nums).html(langjs['can_input']+'<em>'+len+'</em>'+langjs['word']);
    }
    atuserlist(val,event);
}
function retwit(contid){
    tologin();
    $('.emotions').hide();
    var retcont=$("#ret"+contid).html();
    var emo= new Array("(疑问)","(惊喜)","(鄙视)","(呕吐)","(拜拜)","(大笑)","(求)","(色)","(撇嘴)","(调皮)","(流泪)","(偷笑)","(鲜花)","(流汗)","(困)","(惊恐)","(闪人)","(惊讶)","(心)","(发怒)","(发愁)","(投降)","(便便)","(害羞)","(大哭)","(得意)","(跪服)","(难过)","(生气)","(闭嘴)","(抓狂)","(人品)","(钱)","(酷)","(挨打)","(痛打)","(阴险)","(困惑)","(尴尬)","(发呆)","(睡)","(嘘)","(鼻血)","(可爱)","(亲吻)","(寒)","(谢谢)","(顶)","(胜利)");
    if (retcont) {
        retcont= retcont.replace(/<a class="atlink" href="(.*?)">(.*?)<\/a>/gi,'$2');
        retcont= retcont.replace(/<img class="emo" src="(.*?)" alt="(.*?)">/gi,'$2');
        retcont= retcont.replace(/<a href="(.*?)" target="_blank" title="(.*?)">(.*?)<\/a>/gi,'$2');
    }

    var retconttp=explode(retcont,'||',false);
    var newretcont='';
    var at=$("#ret"+contid).prev().prev().html();
    var html='<table border="0" width="350px" style="margin-left:17px"><tr><td valign="top" height="60px"><div id="retbody" style="padding-bottom:10px;word-wrap: break-word;width:365px"></div></td></tr><tr><td valign="top" style="border-top:1px dashed #cccccc"><div style="color:#999;margin-top:10px"><span class="fleft">'+langjs['ret_say_something']+'<a href="javascript:void(0);" onclick="showemotion(\'emotionret_'+contid+'\',\'retbox_'+contid+'\')"><img src="'+pubdir+'/images/facelist.gif"></a></span><span class="retbox" id="num_'+contid+'">'+langjs['can_input']+'<em>140</em>'+langjs['word']+'</span></div><div id="emotionret_'+contid+'"></div><textarea id="retbox_'+contid+'" class="input_text" onkeyup="retnums(\'retbox_'+contid+'\',\'num_'+contid+'\',event);" style="width:350px;height:100px;margin:5px auto;color:#999"></textarea></td></tr><tr><td align="center" height="50px"><input type="button" id="replybutton_'+contid+'" class="button2" value="'+langjs['send_ret']+'" onclick="retwitact(\''+contid+'\')"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button3" value="'+langjs['cancel_ret']+'" onclick="ye_dialog.close()"/></td></tr></table>';
    ye_dialog.openHtml(html,langjs['ret_to'],'400','330');

    $('#retbox_'+contid).click(function(event){atuserlist('retbox_'+contid,event);});

    var rethtml=$("#cont"+contid).html();
    rethtml=rethtml.replace(/<img class="emo"(.*?)alt="(.*?)"(.*?)>/gi,'$2');
    rethtml=rethtml.replace(langjs['photo_c1']+langjs['photo_c2']+langjs['photo_c3']+langjs['photo_c4'],"");
    rethtml=clearhtml(rethtml);
    $('#retbody').html(langjs['ret']+rethtml);

    if (at!=undefined) {
        if (retconttp[0]!=null && retcont!=undefined && retcont!=null && retcont!='') {
            if (countCharacters($.trim(retconttp[0]),1)=='@') {
                retconttp[0]=' || '+$.trim(retconttp[0]);
            }
            retcont=" || "+"@"+at+" "+$.trim(retconttp[0]);
            if (retconttp.length>1) {
                for (var i=1; i<retconttp.length; i++) {
                    newretcont+=" || " +$.trim(retconttp[i]);
                }
            }
        } else {
            retcont=" || "+"@"+at;
        }
        newretcont=retcont+newretcont;
    }
    if (retcont) {
        $('#retbox_'+contid).val(newretcont);
        retnums('retbox_'+contid,'num_'+contid,'');
    }
    var contheight=$('#retbody').height();
    contheight=contheight<=60?60:contheight;
    $('#ye_dialog_window').css('height',(contheight+280)+'px');
    setCaretPosition('retbox_'+contid,0,0);
}
function retwitact(contid) {
    tologin();
    var retwitval=$("#retbox_"+contid).val();
    if (typenums("#retbox_"+contid)<0) {
        $('#num_'+contid).hide();
        $('#num_'+contid).fadeIn("normal");
        return;
    }
    if(retwitval==lasttalk && lasttalk!='') {
        ye_msg.open(langjs['same_talk'],1,2);
        return false;
    } else {
        lasttalk=retwitval;
    }
    ye_dialog.close();
    $.post(siteurl+"/Space/retwit",{cid:contid,retcont:retwitval},
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        if (stdata.ret=="success") {
            var firstli,firstli2;
            if (stalk==1) {
                firstli=$(".wa li").first();
                firstli.before(stdata.data);
                firstli2=$(".wa li").first();
                firstli2.css("display","none");
                firstli2.animate({height: 'toggle', opacity: 'toggle'}, { duration: "slow" });
                if ($('.homeautotip').html()=='') {
                    hometipid=$('#stream > ol > li').first().attr('id');
                }
                wblayeract();
            }
            $("ol li").slice(0, 1).mouseover(function(){
               $(this).addClass("light");
               $(this).removeClass("unlight");
               $(this).removeClass("new");
            });
            $("ol li").slice(0, 1).mouseout(function(){
               $(this).addClass("unlight");
               $(this).removeClass("light");
               $(this).removeClass("new");
            });
            $("ol li").slice(0, 1).find("a").focus(function(){this.blur()});
            $("#nonemsg").remove();
            ye_msg.open(stdata.tip,1,1);
        } else {
            ye_msg.open(stdata.tip,1,2);
        }
    });
}
/*ret end*/
function reportbox() {
    tologin();
    $('.emotions').hide();
    var html='<div id="report"><p>'+langjs['report_title']+'</p><p><select id="reporttp"><option value="0" selected="selected">'+langjs['report_0']+'</option><option value="1">'+langjs['report_1']+'</option><option value="2">'+langjs['report_2']+'</option><option value="3">'+langjs['report_3']+'</option><option value="4">'+langjs['report_4']+'</option></select></p><p>'+langjs['report_body_title']+'</p><p><textarea id="describe" class="input_text">'+langjs['report_url']+document.URL+'\n\r'+langjs['report_body']+'</textarea></p><p><center><input type="button" class="button2" value="'+langjs['report_submit']+'" onclick="reportact()"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="button3" type="button" value="'+langjs['closewindow']+'" onclick="ye_dialog.close()"/></center></p></div>';
    ye_dialog.openHtml(html,langjs['report'],'400','340');
}
function reportact() {
    tologin();
    var l=$('#reporttp').val();
    var d=$('#describe').val();
    if(l==0 || !d){
        ye_msg.open(langjs['report_isnull'],1,2);
        return false;
    }
    $.post(siteurl+"/Space/report",{reporttp:l,describe:d},
    function(msg){
        var stdata=jQuery.parseJSON(msg);
        if (stdata.ret=="success") {
           ye_msg.open(stdata.tip,1,1);
           ye_dialog.close();
        } else {
            ye_msg.open(stdata.tip,3,2);
        }
    });
}
/*upload pic*/
function uploadouturl(){
    var url=$('#outphotourl').val();
    $('.photobox').hide();
    $('.outphotobox').hide();
    var pic=url.toLowerCase();
    if(pic.indexOf( ".gif")>-1 || pic.indexOf( ".jpg")>-1 || pic.indexOf( ".bmp")>-1 || pic.indexOf( ".png")>-1) {
        $("#loadform").hide();
        $("#priviewbtn").hide();
        $("#priviewbtn").html('');
        $("#uploading").show();
        $.post(siteurl+"/Space/uploadpic",{picurl:url},
        function(msg){
            if (msg) {
                loadpic(msg);
            }
        });
    } else {
        ye_msg.open(langjs['upload_error'],1,2);
        $("#uploadbtn").val('');
    }
}
function cencelUpload() {
    $("#imageUpload").attr("src","about:blank");
    $("#priviewbtn").hide();
    $("#priviewbtn").html('');
    $("#uploading").hide();
    $('.photobox').hide();
    $("#uploadbtn").val('');
    $("#loadform").show();
    $("#imageUpload").contents().find("body").html('');
    $("#morecontent").html('');
}
function uploadpic(file) {
    $('.photobox').hide();
    var pic=file.toLowerCase();
    if(pic.indexOf( ".gif")>-1 || pic.indexOf( ".jpg")>-1 || pic.indexOf( ".bmp")>-1 || pic.indexOf( ".png")>-1) {
        $("#imageUpload").attr("src","about:blank");
        $("#loadform").hide();
        $("#priviewbtn").hide();
        $("#priviewbtn").html('');
        $("#uploading").show();
        $("#upform").submit();
        $('#imageUpload').unbind("load");
        $("#imageUpload").load(function(){loadpic($("#imageUpload").contents().find("body").html());});
    } else {
        ye_msg.open(langjs['upload_error'],1,2);
        $("#uploadbtn").val('');
    }
}
function loadpic(htmls) {
    var obj = jQuery.parseJSON(htmls);
    if (htmls) {
        if (obj.ret=='success') {
            $("#uploading").hide();
            $("#priviewbtn").show();
            $("#priviewbtn").html('<span id="photoico">&nbsp;</span><a href="javascript:void(0);" id="upptpr">'+obj.name+"</a> <a onclick='delUpload()' class='greyclose'>x</a>");
            $("#priviewpoic").html("<img src='"+obj.img+"'>");
            $("#imageUpload").contents().find("body").html('');
            $("#morecontent").html(obj.content);
            $('#outphotourl').val('');
            if (!$('#contentbox').val()) {
                $('#contentbox').val('#'+langjs['share_photo']+'#');
            }
        } else {
            $("#uploading").hide();
            $("#priviewbtn").hide();
            $("#priviewbtn").html('');
            $("#priviewpoic").html('');
            $("#imageUpload").contents().find("body").html('');
            $("#morecontent").html('');
            ye_msg.open(obj.ret,3,2);
        }
    }
}
function delUpload() {
    $("#uploading").hide();
    $("#priviewbtn").hide();
    $("#priviewbtn").html('');
    $("#priviewpoic").html('');
    $("#uploadbtn").val('');
    $("#loadform").show();
    $("#imageUpload").contents().find("body").html('');
    $("#morecontent").html('');
    $('.photobox').hide();
}
function ETCopy(id){
    var testCode=document.getElementById(id).value;
    if(copy2Clipboard(testCode)!=false){
        document.getElementById(id).select() ;
        ye_msg.open(langjs['coty_success'],3,1);
    }
}
function dosearch(){
    var v=$('#searchr-input').val();
    var t=$('#commonsearch').val();
    if(v!=langjs['input_keyword'] && v!=''){
        if (t=='user') {
            window.location.href=siteurl+'/Find/search?sname='+encodeURIComponent(v);
        } else {
            window.location.href=siteurl+'/Pub/index?t=s&q='+encodeURIComponent(v);
        }
    }else{
        $('#searchr-input').val(langjs['input_keyword']);
    }
}


function GetQueryString(paras){
    var url = location.href;
    var paraString = url.substring(url.indexOf("?")+1,url.length).split("&");
    var paraObj = {}
    for (i=0; j=paraString[i]; i++){
        paraObj[j.substring(0,j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=")+1,j.length);
    }
    var returnValue = paraObj[paras.toLowerCase()];
    if(typeof(returnValue)=="undefined"){
        return "";
    }else{
        return returnValue;
    }
}
function homesearch(conttype){
    var v=$('#sinput').val();
    var dt=GetQueryString('dt');
    var group=GetQueryString('group');
    group=group==''?0:group;
    if(v!='' && v!='输入关键词搜索广播'){
        if (dt!='') {
            window.location.href=siteurl+'/'+encodeURIComponent(user_name)+'/'+space+'/'+conttype+'?hq='+v+'&dt='+dt+'&group='+group;
        } else {
            window.location.href=siteurl+'/'+encodeURIComponent(user_name)+'/'+space+'/'+conttype+'?hq='+v+'&group='+group;
        }
    }
}
function homedate(conttype,date){
    var hq=GetQueryString('hq');
    var group=GetQueryString('group');
    group=group==''?0:group;
    if(date!=''){
        if (hq!='') {
            window.location.href=siteurl+'/'+encodeURIComponent(user_name)+'/'+space+'/'+conttype+'?dt='+date+'&hq='+hq+'&group='+group;
        } else {
            window.location.href=siteurl+'/'+encodeURIComponent(user_name)+'/'+space+'/'+conttype+'?dt='+date+'&group='+group;
        }
    }
}
function Sharetopic(topic) {
    topic=topic==undefined?langjs['input_topic_title']:topic;
    var tlenght=topic.length+1;
    var cont=$('#contentbox').val();
    var pos=cont.indexOf('#'+topic+'#');
    if (pos < 0) {
        $('#contentbox').val(cont+'#'+topic+'#');
        cont=$('#contentbox').val();
        pos=cont.indexOf('#'+topic+'#');
    }
    if (topic!=langjs['input_topic_title']) {
        $('#contentbox').val($('#contentbox').val().replace('#'+langjs['input_topic_title']+'#',''));
        $('#contentbox').focus();
    } else {
        setCaretPosition('contentbox',parseInt(pos)+1,parseInt(pos)+tlenght);
    }
}
function wblayout(){
    var _tptimeid;
    $('.wblayerbox').mouseover(function(event){
        clearTimeout(_tptimeid);
    }).mouseout(function(event){
        _tptimeid=setTimeout(function(){
            $('.wblayerbox').hide();
        },1);
    });
    _tptimeid=setTimeout(function(){
        $('.wblayerbox').hide();
    },500);
    clearTimeout(wblayertimeid);
}
function wblayeract(){
    $('.author').mouseover(function(e){
        $('.wblayerbox').hide();
        clearTimeout(wblayertimeid);
        var top=$(this).offset().top;
        var left=$(this).offset().left;
        var name=$(this).html();
        e = e || window.event;
        var mtop;
        if (parseInt(e.clientY)>170) {
            mtop='nbottom';
            top=top-170;
        } else {
            mtop='ntop';
            top=top+20;
        }
        wblayertimeid=setTimeout(function(){
            wblayer(name,'left:'+left+'px;top:'+top+'px',mtop);
        },1000);
    }).mouseout(function(){
        wblayout();
    });
    $('.atlink').mouseover(function(e){
        $('.wblayerbox').hide();
        clearTimeout(wblayertimeid);
        var top=$(this).offset().top;
        var left=$(this).offset().left;
        var name=$(this).html().replace('@','');
        e = e || window.event;
        var mtop;
        if (parseInt(e.clientY)>170) {
            mtop='nbottom';
            top=top-170;
        } else {
            mtop='ntop';
            top=top+20;
        }
        wblayertimeid=setTimeout(function(){
            wblayer(name,'left:'+left+'px;top:'+top+'px',mtop);
        },1000);
    }).mouseout(function(){
        wblayout();
    });
    $('.avatar').mouseover(function(e){
        $('.wblayerbox').hide();
        clearTimeout(wblayertimeid);
        var top=$(this).offset().top;
        var left=$(this).offset().left;
        var name=$(this).find('img').attr('alt');
        e = e || window.event;
        var mtop;
        if (parseInt(e.clientY)>170) {
            mtop='nbottom';
            top=top-175;
        } else {
            mtop='ntop';
            top=top+50;
        }
        wblayertimeid=setTimeout(function(){
            wblayer(name,'left:'+left+'px;top:'+top+'px',mtop);
        },1000);
    }).mouseout(function(){
        wblayout();
    });
}
function sidelay(){
    $('.followpreview').mouseover(function(e){
        $('.wblayerbox').hide();
        clearTimeout(wblayertimeid);
        var top=$(this).offset().top;
        var left=$(this).offset().left;
        var name=$(this).attr('alt');
        left=left-312;
        wblayertimeid=setTimeout(function(){
            wblayer(name,'left:'+left+'px;top:'+top+'px','nright');
        },1000);
    }).mouseout(function(){
        wblayout();
    });
}
function followlay(){
    $('li > .fleft > a').mouseover(function(e){
        $('.wblayerbox').hide();
        clearTimeout(wblayertimeid);
        var top=$(this).offset().top;
        var left=$(this).offset().left;
        var name=$(this).html();
        e = e || window.event;
        var mtop;
        if (parseInt(e.clientY)>170) {
            mtop='nbottom';
            top=top-170;
        } else {
            mtop='ntop';
            top=top+20;
        }
        wblayertimeid=setTimeout(function(){
            wblayer(name,'left:'+left+'px;top:'+top+'px',mtop);
        },1000);
    }).mouseout(function(){
        wblayout();
    });
}
function hotbanglay(){
    $('li').find('em').next().mouseover(function(e){
        $('.wblayerbox').hide();
        clearTimeout(wblayertimeid);
        var top=$(this).offset().top;
        var left=$(this).offset().left;
        var name=$(this).html();
        e = e || window.event;
        var mtop;
        if (parseInt(e.clientY)>170) {
            mtop='nbottom';
            top=top-170;
        } else {
            mtop='ntop';
            top=top+20;
        }
        wblayertimeid=setTimeout(function(){
            wblayer(name,'left:'+left+'px;top:'+top+'px',mtop);
        },1000);
    }).mouseout(function(){
        wblayout();
    });
}
function replaylay(){
    $('.username').mouseover(function(e){
        $('.wblayerbox').hide();
        clearTimeout(wblayertimeid);
        var top=$(this).offset().top;
        var left=$(this).offset().left;
        var name=$(this).html();
        e = e || window.event;
        var mtop;
        if (parseInt(e.clientY)>170) {
            mtop='nbottom';
            top=top-170;
        } else {
            mtop='ntop';
            top=top+20;
        }
        wblayertimeid=setTimeout(function(){
            wblayer(name,'left:'+left+'px;top:'+top+'px',mtop);
        },1000);
    }).mouseout(function(){
        wblayout();
    });
    $('.lire .images').mouseover(function(e){
        $('.wblayerbox').hide();
        clearTimeout(wblayertimeid);
        var top=$(this).offset().top;
        var left=$(this).offset().left;
        var name=$(this).find('a > img').attr('alt');
        e = e || window.event;
        var mtop;
        if (parseInt(e.clientY)>170) {
            mtop='nbottom';
            top=top-175;
        } else {
            mtop='ntop';
            top=top+35;
        }
        left=left-13;
        wblayertimeid=setTimeout(function(){
            wblayer(name,'left:'+left+'px;top:'+top+'px',mtop);
        },1000);
    }).mouseout(function(){
        wblayout();
    });
}