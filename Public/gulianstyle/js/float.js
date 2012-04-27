/**
 * $.float
 * @extends jquery.1.4
 * @fileOverview 创建一个悬浮层，支持上、下、左、右、右中、左中浮动
 * @author 明河共影
 * @email mohaiguyan12@126.com
 * @version 0.1
 * @date 2010-04-18
 * Copyright (c) 2010-2010 明河共影
 * @example
 *    $("#to-right").float({position:"rm"}); //右中位置浮动
 */
jQuery.fn.float= function(settings){
	if(typeof settings == "object"){
		settings = jQuery.extend({
			//延迟
			delay : 1000,
			//位置偏移
			offset : {
				left : 0,
				right : 0,
				top : 0,
				bottom : 0
			},
			style : null, //样式
			width:100,  //宽度
			height:200, //高度
			position:"rm" //位置
		}, settings || {});	
		var winW = $(window).width();
		var winH = $(window).height();
		
		 //根据参数获取位置数值
		function getPosition($applyTo,position){
			var _pos = null;
			switch(position){
				case "rm" : 
					$applyTo.data("offset","right");
					$applyTo.data("offsetPostion",settings.offset.right);
					_pos = {right:settings.offset.right,top:winH/2-$applyTo.innerHeight()/2};
				break;
				case "lm" :
					$applyTo.data("offset","left");
					$applyTo.data("offsetPostion",settings.offset.left);
					_pos = {left:settings.offset.left,top:winH/2-$applyTo.innerHeight()/2};
				break;
				case "rb" :
					_pos = {right:settings.offset.right,top:winH - $applyTo.innerHeight()};
				break;
				case "lb" :
					_pos = {left:settings.offset.left,top:winH - $applyTo.innerHeight()};
				break;
				case "l" : 
					_pos = {left:settings.offset.left,top:settings.offset.top};
				break;
				case "r" : 
					_pos = {right:settings.offset.right,top:settings.offset.top};
				break;				
				case "t" :
					$applyTo.data("offset","top");
					$applyTo.data("offsetPostion",settings.offset.top);					
					_pos = {left:settings.offset.left,top:settings.offset.top};
				break;
				case "b" :
					$applyTo.data("offset","bottom");
					$applyTo.data("offsetPostion",settings.offset.bottom);					
					_pos = {left:settings.offset.left,top:winH - $applyTo.innerHeight()};				
				break;
			}
			return _pos;
		}
		//设置容器位置
		function setPosition($applyTo,position,isUseAnimate){
			var scrollTop = $(window).scrollTop();
			var scrollLeft = $(window).scrollLeft();
			var _pos = getPosition($applyTo,position);
			_pos.top += scrollTop;
			isUseAnimate && $applyTo.stop().animate(_pos,settings.delay) || $applyTo.css(_pos);
		} 
		return this.each(function(){
			var $this =  $(this);
			$this.css("position","absolute");
			settings.style && $this.css(settings.style);
			setPosition($this,settings.position);
			$(this).data("isAllowScroll",true);
			$(window).scroll(function(){
				$this.data("isAllowScroll") && setPosition($this,settings.position,true);
			});
		})	
	}else{
		var speed = arguments.length > 1 && arguments[1] || "fast"; 
		this.each(function(){		   
			if(settings == "clearOffset"){
					var _c = {};
					if($(this).data("offset")){
						 _c[$(this).data("offset")] = 0; 
						 $(this).data("isAllowScroll",false);
						 $(this).stop().animate(_c,speed);
					}
			}else if(settings == "addOffset"){
					var _c = {};
					if($(this).data("offset") && $(this).data("offsetPostion")){
						 _c[$(this).data("offset")] = $(this).data("offsetPostion"); 
						 $(this).stop().animate(_c,speed);
						 $(this).data("isAllowScroll",true);
					}
									   
			}else if(settings == "setScrollDisable"){
				$(this).data("isAllowScroll",false);
			}else if(settings == "setScrollUsable"){
				$(this).data("isAllowScroll",true);	
			}
		})
	}
}		  
