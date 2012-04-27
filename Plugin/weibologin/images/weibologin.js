function cookieset(type) {
    var url=pubdir.replace('/Public','');
    if (type=='sina') {
        if($('#sinaicon').attr('title')=='点击不同步发送到新浪微博'){
            $.get(siteurl+"/p/weibologin/action/cookieset/tbtype/sina/open/0",
            function(msg){
                if (msg=='success') {
                    $('#sinaicon').attr('title','点击同步发送到新浪微博');
                    $('#sinaicon').css('background-image','url('+url+'/Plugin/weibologin/images/sinawebo_off.gif)');
                }
            });
        } else {
            $.get(siteurl+"/p/weibologin/action/cookieset/tbtype/sina/open/1",
            function(msg){
                if (msg=='success') {
                    $('#sinaicon').attr('title','点击不同步发送到新浪微博');
                    $('#sinaicon').css('background-image','url('+url+'/Plugin/weibologin/images/sinawebo_on.gif)');
                }
            });
        }
    } else {
        if($('#qqicon').attr('title')=='点击不同步发送到腾讯微博'){
            $.get(siteurl+"/p/weibologin/action/cookieset/tbtype/qq/open/0",
            function(msg){
                if (msg=='success') {
                    $('#qqicon').attr('title','点击同步发送到腾讯微博');
                    $('#qqicon').css('background-image','url('+url+'/Plugin/weibologin/images/qqwb_off.gif)');
                }
            });
        } else {
            $.get(siteurl+"/p/weibologin/action/cookieset/tbtype/qq/open/1",
            function(msg){
                if (msg=='success') {
                    $('#qqicon').attr('title','点击不同步发送到腾讯微博');
                    $('#qqicon').css('background-image','url('+url+'/Plugin/weibologin/images/qqwb_on.gif)');
                }
            });
        }
    }
}