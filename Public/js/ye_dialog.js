var ye_dialog = {
    Counter: 0,
    init: function(isladding/*锁定窗口时不显示loading图片，如参数为ture*/){
        if($.browser.msie && $.browser.version=='6.0'){$("select").css("visibility", "hidden");}
		if(isladding){
        var a = '<div id="ye_dialog_overlay"></div><div id="ye_dialog_window"><a id="ye_dialog_close" href="#" title="\u5173\u95ed"></a><div id="ye_dialog_title">\u8bf7\u7a0d\u5019...</div><div id="ye_dialog_body"></div></div>';
        }else{//默认锁定窗口时显示loading图片
        var a = '<div id="ye_dialog_overlay"></div><div id="ye_dialog_loading"></div><div id="ye_dialog_window"><a id="ye_dialog_close" href="#" title="\u5173\u95ed"></a><div id="ye_dialog_title">\u8bf7\u7a0d\u5019...</div><div id="ye_dialog_body"></div></div>';
		}
	   $("body").append(a);
        var b = this.closeFun ? this.closeFun : function(){
        };
        $("#ye_dialog_close").click(function(){
            b();
            ye_dialog.close();
            return false
        });
        $("#ye_dialog_overlay").show();
        $("#ye_dialog_loading").show();
        this.position();
        return this
    },
    openHtml: function(b, e, a, d, c, f){
		/*
		 (
		    b:html,
			e:title,
			a:width,
			d:height,
			c:callback,
			f:closeFun
		  )
		*/
        if (f && $.isFunction(f.closeFun)) {
            this.closeFun = f.closeFun
        }
        this.init();
        if (b != undefined) {
        	if (typeof b=='object'){
        		$("#ye_dialog_body").append(b.children());
        		this.close_fun2 = function () {
						b.append( $("#ye_dialog_body").children() ); // move elements back when you're finished
				};
        	}else {
            	$("#ye_dialog_body").html(b)
            }
        }
        this.title(e == undefined ? "\u540C\u5B66" : e);
        this.resize(a ? a : 300, d ? d : 150);
        $("#ye_dialog_loading").remove();
        $("#ye_dialog_window").show();
        if ($.isFunction(c)) {
            c()
        }
        return this
    },
    openUrl: function(c, a, e, g, scrolling){
		/*
		(
		   c:url,
		   a:width,
		   e:height,
		   g:title,
		   f:scroll
		 )
		*/
        this.init();
        var b = a != undefined ? a : 300;
        var f = e != undefined ? e : 150;
		var s = scrolling != undefined ? scrolling : 'no';
        var d = (new Date).getTime();
        if (c.indexOf("?") == -1) {
            c = c + "?_t=" + d
        }
        else {
            c = c + "&_t=" + d
        }
        this.title(g == undefined ? "\u540C\u5B66" : g);
        $("#ye_dialog_body").html('<iframe id="ye_dialog_iframe" scrolling="'+s+'" frameborder="0"></iframe>');
        $("#ye_dialog_iframe").attr("src", c);
        this.resize(b, f);
        $("#ye_dialog_loading").remove();
        $("#ye_dialog_window").show()
    },
    close: function(){
    	if (typeof this.close_fun2=='function'){
    		this.close_fun2();
    	}
        $("#ye_dialog_window").remove();
        $("#ye_dialog_overlay").remove();
        if($.browser.msie && $.browser.version=='6.0'){$("select").css("visibility", "visible");}
        return this
    },
    resize: function(a, c){//(a:width---int, b:height----int)
        var d = a ? a : 300;
        var b = c ? c : 150;
        $("#ye_dialog_window").css({
            width: d + "px",
            height: b + "px"
        });
        $("#ye_dialog_body").css("height", "99%").css("height", c - 28 + "px");
        this.position();
        return this
    },
    position: function(){
        var b = $("#ye_dialog_window").width();
        var a = $("#ye_dialog_window").height();
        $("#ye_dialog_window").css({
            marginLeft: "-" + parseInt(b / 2) + "px"
        });
        if (!($.browser.msie && $.browser.version < 7)) {
            $("#ye_dialog_window").css({
                marginTop: "-" + parseInt(a / 2) + "px"
            })
        }
        return this
    },
    title: function(a){
        if (a != undefined) {
            $("#ye_dialog_title").text(a);
            return this
        }
        else {
            return $("#ye_dialog_title").text()
        }
    }
};
// ico 1正确，2错误，3提示，4警告，5疑问
var ye_msg = {
    Counter: 0,
    open: function(e, d, c, b){//(e:html,d:timer,c:type(int),b:callback)
        $('.ye_msg_window').remove();
        var jstz = e.indexOf('<script');
        if (jstz!=-1) {
            e='正在载入中...'+e;
        }
        if($.browser.msie && $.browser.version=='6.0'){$("select").css("visibility", "hidden");}
        this.Counter++;
        var a = '<div id="ye_msg_' + this.Counter + '" class="ye_msg_window"><div class="ye_msg_wrap">' + e + "</div></div>";
        $("body").append(a);
        $("#ye_msg_" + this.Counter + " > .ye_msg_wrap").addClass("ye_msg_ico_" + c);
        this.position(this.Counter);
        if (typeof b == "function") {
            b()
        }
        if (d != undefined && d != 0) {
            $("#ye_msg_" + this.Counter + " > .ye_msg_wrap").append('<div class="ye_msg_autoclose">('+d+langjs['ye_msg_close']+")</div>");
            setTimeout('$("#ye_msg_' + this.Counter + '").remove();if($.browser.msie && $.browser.version=="6.0"){$("select").css("visibility", "visible");}', d * 1000)
        }
    },
    position: function(c){//(c:this.Counter)
        var b = $("#ye_msg_" + c).width();
        var a = $("#ye_msg_" + c).height();
        $("#ye_msg_" + c).css({
            marginLeft: "-" + parseInt(b / 2) + "px"
        })
    }
};