/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename admin.js $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

$(document).ready(function(){
    $('#menu > li').click(function(){
        $('#menu > li').attr('class','');
        $(this).attr('class','selected');
    });
    $('#addside').change(function(){
        if ($('#addside').val()=='hottopic') {
            $('#addtitle').val('热门话题');
            setreadonly();
        } else if ($('#addside').val()=='hotuser') {
            $('#addtitle').val('人气用户推荐');
            setreadonly();
        } else if ($('#addside').val()=='bangnormal') {
            $('#addtitle').val('人气之星榜');
            setreadonly();
        } else if ($('#addside').val()=='bangvip') {
            $('#addtitle').val('认证名人榜');
            setreadonly();
        } else if ($('#addside').val()=='userfollower') {
            $('#addtitle').val('TA的听众');
            setreadonly();
        } else if ($('#addside').val()=='userfollowing') {
            $('#addtitle').val('TA收听的');
            setreadonly();
        } else {
            $('#addtitle').val('');
            $('#addval').val('');
            $('#addtitle').removeAttr("readonly");
            $('#addval').removeAttr("readonly");
            $('#addval').attr('class','txt_input');
            $('#addtitle').attr('class','txt_input');
        }
    });
    $('#tab1').click(function(){
        for (var i=1; i<=6; i++) {
            $('#menu'+i).hide();
            $('#tab'+i).parent().attr('class','');
        }
        $('#menu1').show();
        $(this).parent().attr('class','current');
    });
    $('#tab2').click(function(){
        for (var i=1; i<=6; i++) {
            $('#menu'+i).hide();
            $('#tab'+i).parent().attr('class','');
        }
        $('#menu2').show();
        $(this).parent().attr('class','current');
    });
    $('#tab3').click(function(){
        for (var i=1; i<=6; i++) {
            $('#menu'+i).hide();
            $('#tab'+i).parent().attr('class','');
        }
        $('#menu3').show();
        $(this).parent().attr('class','current');
    });
    $('#tab4').click(function(){
        for (var i=1; i<=6; i++) {
            $('#menu'+i).hide();
            $('#tab'+i).parent().attr('class','');
        }
        $('#menu4').show();
        $(this).parent().attr('class','current');
    });
    $('#tab5').click(function(){
        for (var i=1; i<=6; i++) {
            $('#menu'+i).hide();
            $('#tab'+i).parent().attr('class','');
        }
        $('#menu5').show();
        $(this).parent().attr('class','current');
    });
    $('#tab6').click(function(){
        for (var i=1; i<=6; i++) {
            $('#menu'+i).hide();
            $('#tab'+i).parent().attr('class','');
        }
        $('#menu6').show();
        $(this).parent().attr('class','current');
    });
});
function setreadonly() {
    $('#addval').val('系统默认内容');
    $('#addtitle').attr('readonly','readonly');
    $('#addval').attr('readonly','readonly');
    $('#addval').attr('class','readonly');
    $('#addtitle').attr('class','readonly');
}

function CheckAll(name,ckall) {
    var cbox=$("input[name='"+name+"[]']");
    var sc=$("#"+ckall).attr("checked");
    for(var i=0; i<cbox.length;i++){
        if(sc){
            cbox.get(i).checked = true;
        } else {
            cbox.get(i).checked = false;
        }
    }
}
function jsop(url,mes) {
    var mymes;
    mymes=confirm(mes);
    if(mymes==true){
        window.location=url;
    }
}
function topicinfo(tid) {
    if (!tid) {
        alert('很抱歉。数据传输失败！');
        return;
    }
    var info=$('#info_'+tid).val();
    var postDt="tid="+tid+"&info="+info;
    $.ajax({type:"POST",url:"admin.php?s=/Topic/info",data:postDt,
    success: function(msg){
        if (msg=="success") {
            alert('话题描述设置成功！');
        } else {
            alert(msg);
        }
    }});
}