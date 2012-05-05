/*
 Copyright (c) 2010, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.com/yui/license.html
 version: 3.3.0
 build: 3167
 */
if(typeof YUI!="undefined"){YUI._YUI=YUI;}var YUI=function(){var c=0,f=this,b=arguments,a=b.length,e=function(h,g){return(h&&h.hasOwnProperty&&(h instanceof g));},d=(typeof YUI_config!=="undefined")&&YUI_config;if(!(e(f,YUI))){f=new YUI();}else{f._init();if(YUI.GlobalConfig){f.applyConfig(YUI.GlobalConfig);}if(d){f.applyConfig(d);}if(!a){f._setup();}}if(a){for(;c<a;c++){f.applyConfig(b[c]);}f._setup();}f.instanceOf=e;return f;};(function(){var p,b,q="3.3.0",h=".",n="http://yui.yahooapis.com/",t="yui3-js-enabled",l=function(){},g=Array.prototype.slice,r={"io.xdrReady":1,"io.xdrResponse":1,"SWF.eventHandler":1},f=(typeof window!="undefined"),e=(f)?window:null,v=(f)?e.document:null,d=v&&v.documentElement,a=d&&d.className,c={},i=new Date().getTime(),m=function(z,y,x,w){if(z&&z.addEventListener){z.addEventListener(y,x,w);}else{if(z&&z.attachEvent){z.attachEvent("on"+y,x);}}},u=function(A,z,y,w){if(A&&A.removeEventListener){try{A.removeEventListener(z,y,w);}catch(x){}}else{if(A&&A.detachEvent){A.detachEvent("on"+z,y);}}},s=function(){YUI.Env.windowLoaded=true;YUI.Env.DOMReady=true;if(f){u(window,"load",s);}},j=function(y,x){var w=y.Env._loader;if(w){w.ignoreRegistered=false;w.onEnd=null;w.data=null;w.required=[];w.loadType=null;}else{w=new y.Loader(y.config);y.Env._loader=w;}return w;},o=function(y,x){for(var w in x){if(x.hasOwnProperty(w)){y[w]=x[w];}}},k={success:true};if(d&&a.indexOf(t)==-1){if(a){a+=" ";}a+=t;d.className=a;}if(q.indexOf("@")>-1){q="3.2.0";}p={applyConfig:function(D){D=D||l;var y,A,z=this.config,B=z.modules,x=z.groups,C=z.rls,w=this.Env._loader;for(A in D){if(D.hasOwnProperty(A)){y=D[A];if(B&&A=="modules"){o(B,y);}else{if(x&&A=="groups"){o(x,y);}else{if(C&&A=="rls"){o(C,y);}else{if(A=="win"){z[A]=y.contentWindow||y;z.doc=z[A].document;}else{if(A=="_yuid"){}else{z[A]=y;}}}}}}}if(w){w._config(D);}},_config:function(w){this.applyConfig(w);},_init:function(){var y,z=this,w=YUI.Env,x=z.Env,A;z.version=q;if(!x){z.Env={mods:{},versions:{},base:n,cdn:n+q+"/build/",_idx:0,_used:{},_attached:{},_yidx:0,_uidx:0,_guidp:"y",_loaded:{},serviced:{},getBase:w&&w.getBase||function(G,F){var B,C,E,H,D;C=(v&&v.getElementsByTagName("script"))||[];for(E=0;E<C.length;E=E+1){H=C[E].src;if(H){D=H.match(G);B=D&&D[1];if(B){y=D[2];if(y){D=y.indexOf("js");if(D>-1){y=y.substr(0,D);}}D=H.match(F);if(D&&D[3]){B=D[1]+D[3];}break;}}}return B||x.cdn;}};x=z.Env;x._loaded[q]={};if(w&&z!==YUI){x._yidx=++w._yidx;x._guidp=("yui_"+q+"_"+x._yidx+"_"+i).replace(/\./g,"_");}else{if(YUI._YUI){w=YUI._YUI.Env;x._yidx+=w._yidx;x._uidx+=w._uidx;for(A in w){if(!(A in x)){x[A]=w[A];}}delete YUI._YUI;}}z.id=z.stamp(z);c[z.id]=z;}z.constructor=YUI;z.config=z.config||{win:e,doc:v,debug:true,useBrowserConsole:true,throwFail:true,bootstrap:true,cacheUse:true,fetchCSS:true};z.config.base=YUI.config.base||z.Env.getBase(/^(.*)yui\/yui([\.\-].*)js(\?.*)?$/,/^(.*\?)(.*\&)(.*)yui\/yui[\.\-].*js(\?.*)?$/);if(!y||(!("-min.-debug.").indexOf(y))){y="-min.";}z.config.loaderPath=YUI.config.loaderPath||"loader/loader"+(y||"-min.")+"js";},_setup:function(B){var x,A=this,w=[],z=YUI.Env.mods,y=A.config.core||["get","rls","intl-base","loader","yui-log","yui-later","yui-throttle"];for(x=0;x<y.length;x++){if(z[y[x]]){w.push(y[x]);}}A._attach(["yui-base"]);A._attach(w);},applyTo:function(C,B,y){if(!(B in r)){this.log(B+": applyTo not allowed","warn","yui");return null;}var x=c[C],A,w,z;if(x){A=B.split(".");w=x;for(z=0;z<A.length;z=z+1){w=w[A[z]];if(!w){this.log("applyTo not found: "+B,"warn","yui");}}return w.apply(x,y);}return null;},add:function(x,C,B,w){w=w||{};var A=YUI.Env,D={name:x,fn:C,version:B,details:w},E,z,y=A.versions;A.mods[x]=D;y[B]=y[B]||{};y[B][x]=D;for(z in c){if(c.hasOwnProperty(z)){E=c[z].Env._loader;if(E){if(!E.moduleInfo[x]){E.addModule(w,x);}}}}return this;},_attach:function(w,C){var F,A,J,x,I,y,z,L=YUI.Env.mods,B=this,E,D=B.Env._attached,G=w.length,K;for(F=0;F<G;F++){if(!D[w[F]]){A=w[F];J=L[A];if(!J){K=B.Env._loader;if(!K||!K.moduleInfo[A]){B.message("NOT loaded: "+A,"warn","yui");}}else{D[A]=true;x=J.details;I=x.requires;y=x.use;z=x.after;if(I){for(E=0;E<I.length;E++){if(!D[I[E]]){if(!B._attach(I)){return false;}break;}}}if(z){for(E=0;E<z.length;E++){if(!D[z[E]]){if(!B._attach(z)){return false;}break;}}}if(y){for(E=0;E<y.length;E++){if(!D[y[E]]){if(!B._attach(y)){return false;}break;}}}if(J.fn){try{J.fn(B,A);}catch(H){B.error("Attach error: "+A,H,A);return false;}}}}}return true;},use:function(){var w=g.call(arguments,0),z=w[w.length-1],y=this,x;if(y.Lang.isFunction(z)){w.pop();}else{z=null;}if(y._loading){y._useQueue=y._useQueue||new y.Queue();y._useQueue.add([w,z]);}else{x=w.join();if(y.config.cacheUse&&y.Env.serviced[x]){y._notify(z,k,w);}else{y._use(w,function(B,A){if(B.config.cacheUse){B.Env.serviced[x]=true;}B._notify(z,A,w);});}}return y;},_notify:function(z,w,x){if(!w.success&&this.config.loadErrorFn){this.config.loadErrorFn.call(this,this,z,w,x);}else{if(z){try{z(this,w);}catch(y){this.error("use callback error",y,x);}}}},_use:function(y,A){if(!this.Array){this._attach(["yui-base"]);}var L,F,M,x=this,N=YUI.Env,z=N.mods,w=x.Env,C=w._used,J=N._loaderQueue,Q=y[0],E=x.Array,O=x.config,D=O.bootstrap,K=[],H=[],P=true,B=O.fetchCSS,I=function(S,R){if(!S.length){return;}E.each(S,function(V){if(!R){H.push(V);}if(C[V]){return;}var T=z[V],W,U;if(T){C[V]=true;W=T.details.requires;U=T.details.use;}else{if(!N._loaded[q][V]){K.push(V);}else{C[V]=true;}}if(W&&W.length){I(W);}if(U&&U.length){I(U,1);}});},G=function(V){var T=V||{success:true,msg:"not dynamic"},S,R,U=true,W=T.data;x._loading=false;if(W){R=K;K=[];H=[];I(W);S=K.length;if(S){if(K.sort().join()==R.sort().join()){S=false;}}}if(S&&W){x._loading=false;x._use(y,function(){if(x._attach(W)){x._notify(A,T,W);}});}else{if(W){U=x._attach(W);}if(U){x._notify(A,T,y);}}if(x._useQueue&&x._useQueue.size()&&!x._loading){x._use.apply(x,x._useQueue.next());}};if(Q==="*"){P=x._attach(x.Object.keys(z));if(P){G();}return x;}if(D&&x.Loader&&y.length){F=j(x);F.require(y);F.ignoreRegistered=true;F.calculate(null,(B)?null:"js");y=F.sorted;}I(y);L=K.length;if(L){K=x.Object.keys(E.hash(K));L=K.length;}if(D&&L&&x.Loader){x._loading=true;F=j(x);F.onEnd=G;F.context=x;F.data=y;F.ignoreRegistered=false;F.require(y);F.insert(null,(B)?null:"js");}else{if(L&&x.config.use_rls){x.Get.script(x._rls(y),{onEnd:function(R){G(R);},data:y});}else{if(D&&L&&x.Get&&!w.bootstrapped){x._loading=true;M=function(){x._loading=false;J.running=false;w.bootstrapped=true;if(x._attach(["loader"])){x._use(y,A);}};if(N._bootstrapping){J.add(M);}else{N._bootstrapping=true;x.Get.script(O.base+O.loaderPath,{onEnd:M});}}else{P=x._attach(y);if(P){G();}}}}return x;},namespace:function(){var x=arguments,B=this,z=0,y,A,w;for(;z<x.length;z++){w=x[z];if(w.indexOf(h)){A=w.split(h);for(y=(A[0]=="YAHOO")?1:0;y<A.length;y++){B[A[y]]=B[A[y]]||{};B=B[A[y]];}}else{B[w]=B[w]||{};}}return B;},log:l,message:l,error:function(A,y,x){var z=this,w;if(z.config.errorFn){w=z.config.errorFn.apply(z,arguments);}if(z.config.throwFail&&!w){throw(y||new Error(A));}else{z.message(A,"error");}return z;},guid:function(w){var x=this.Env._guidp+(++this.Env._uidx);return(w)?(w+x):x;},stamp:function(y,z){var w;if(!y){return y;}if(y.uniqueID&&y.nodeType&&y.nodeType!==9){w=y.uniqueID;}else{w=(typeof y==="string")?y:y._yuid;}if(!w){w=this.guid();if(!z){try{y._yuid=w;}catch(x){w=null;}}}return w;},destroy:function(){var w=this;if(w.Event){w.Event._unload();}delete c[w.id];delete w.Env;delete w.config;}};YUI.prototype=p;for(b in p){if(p.hasOwnProperty(b)){YUI[b]=p[b];}}YUI._init();if(f){m(window,"load",s);}else{s();}YUI.Env.add=m;YUI.Env.remove=u;if(typeof exports=="object"){exports.YUI=YUI;}}());YUI.add("yui-base",function(c){c.Lang=c.Lang||{};var k=c.Lang,B="array",p="boolean",f="date",g="error",i="function",t="number",A="null",n="object",y="regexp",r="string",s=String.prototype,m=Object.prototype.toString,D="undefined",b={"undefined":D,"number":t,"boolean":p,"string":r,"[object Function]":i,"[object RegExp]":y,"[object Array]":B,"[object Date]":f,"[object Error]":g},x=/^\s+|\s+$/g,z="",e=/\{\s*([^\|\}]+?)\s*(?:\|([^\}]*))?\s*\}/g;k.isArray=function(E){return k.type(E)===B;};k.isBoolean=function(E){return typeof E===p;};k.isFunction=function(E){return k.type(E)===i;};k.isDate=function(E){return k.type(E)===f&&E.toString()!=="Invalid Date"&&!isNaN(E);};k.isNull=function(E){return E===null;};k.isNumber=function(E){return typeof E===t&&isFinite(E);};k.isObject=function(G,F){var E=typeof G;return(G&&(E===n||(!F&&(E===i||k.isFunction(G)))))||false;};k.isString=function(E){return typeof E===r;};k.isUndefined=function(E){return typeof E===D;};k.trim=s.trim?function(E){return(E&&E.trim)?E.trim():E;}:function(E){try{return E.replace(x,z);}catch(F){return E;}};k.trimLeft=s.trimLeft?function(E){return E.trimLeft();}:function(E){return E.replace(/^\s+/,"");};k.trimRight=s.trimRight?function(E){return E.trimRight();}:function(E){return E.replace(/\s+$/,"");};k.isValue=function(F){var E=k.type(F);switch(E){case t:return isFinite(F);case A:case D:return false;default:return!!(E);}};k.type=function(E){return b[typeof E]||b[m.call(E)]||(E?n:A);};k.sub=function(E,F){return((E.replace)?E.replace(e,function(G,H){return(!k.isUndefined(F[H]))?F[H]:G;}):E);};k.now=Date.now||function(){return new Date().getTime();};var u=Array.prototype,w="length",l=function(K,I,G){var H=(G)?2:l.test(K),F,E,L=I||0;if(H){try{return u.slice.call(K,L);}catch(J){E=[];F=K.length;for(;L<F;L++){E.push(K[L]);}return E;}}else{return[K];}};c.Array=l;l.test=function(G){var E=0;if(c.Lang.isObject(G)){if(c.Lang.isArray(G)){E=1;}else{try{if((w in G)&&!G.tagName&&!G.alert&&!G.apply){E=2;}}catch(F){}}}return E;};l.each=(u.forEach)?function(E,F,G){u.forEach.call(E||[],F,G||c);return c;}:function(F,H,I){var E=(F&&F.length)||0,G;for(G=0;G<E;G=G+1){H.call(I||c,F[G],G,F);}return c;};l.hash=function(G,F){var J={},E=G.length,I=F&&F.length,H;for(H=0;H<E;H=H+1){J[G[H]]=(I&&I>H)?F[H]:true;}return J;};l.indexOf=(u.indexOf)?function(E,F){return u.indexOf.call(E,F);}:function(E,G){for(var F=0;F<E.length;F=F+1){if(E[F]===G){return F;}}return-1;};l.numericSort=function(F,E){return(F-E);};l.some=(u.some)?function(E,F,G){return u.some.call(E,F,G);}:function(F,H,I){var E=F.length,G;for(G=0;G<E;G=G+1){if(H.call(I,F[G],G,F)){return true;}}return false;};function C(){this._init();this.add.apply(this,arguments);}C.prototype={_init:function(){this._q=[];},next:function(){return this._q.shift();},last:function(){return this._q.pop();},add:function(){this._q.push.apply(this._q,arguments);return this;},size:function(){return this._q.length;}};c.Queue=C;YUI.Env._loaderQueue=YUI.Env._loaderQueue||new C();var o="__",a=function(G,F){var E=F.toString;if(c.Lang.isFunction(E)&&E!=Object.prototype.toString){G.toString=E;}};c.merge=function(){var F=arguments,H={},G,E=F.length;for(G=0;G<E;G=G+1){c.mix(H,F[G],true);}return H;};c.mix=function(E,N,G,M,J,L){if(!N||!E){return E||c;}if(J){switch(J){case 1:return c.mix(E.prototype,N.prototype,G,M,0,L);case 2:c.mix(E.prototype,N.prototype,G,M,0,L);break;case 3:return c.mix(E,N.prototype,G,M,0,L);case 4:return c.mix(E.prototype,N,G,M,0,L);default:}}var I,H,F,K;if(M&&M.length){for(I=0,H=M.length;I<H;++I){F=M[I];K=c.Lang.type(E[F]);if(N.hasOwnProperty(F)){if(L&&K=="object"){c.mix(E[F],N[F]);}else{if(G||!(F in E)){E[F]=N[F];}}}}}else{for(I in N){if(N.hasOwnProperty(I)){if(L&&c.Lang.isObject(E[I],true)){c.mix(E[I],N[I],G,M,0,true);}else{if(G||!(I in E)){E[I]=N[I];}}}}if(c.UA.ie){a(E,N);}}return E;};c.cached=function(G,E,F){E=E||{};return function(I){var H=(arguments.length>1)?Array.prototype.join.call(arguments,o):I;if(!(H in E)||(F&&E[H]==F)){E[H]=G.apply(G,arguments);}return E[H];};};var q=function(){},h=function(E){q.prototype=E;return new q();},j=function(F,E){return F&&F.hasOwnProperty&&F.hasOwnProperty(E);},v,d=function(I,H){var G=(H===2),E=(G)?0:[],F;for(F in I){if(j(I,F)){if(G){E++;}else{E.push((H)?I[F]:F);}}}return E;};c.Object=h;h.keys=function(E){return d(E);};h.values=function(E){return d(E,1);};h.size=Object.size||function(E){return d(E,2);};h.hasKey=j;h.hasValue=function(F,E){return(c.Array.indexOf(h.values(F),E)>-1);};h.owns=j;h.each=function(I,H,J,G){var F=J||c,E;for(E in I){if(G||j(I,E)){H.call(F,I[E],E,I);}}return c;};h.some=function(I,H,J,G){var F=J||c,E;for(E in I){if(G||j(I,E)){if(H.call(F,I[E],E,I)){return true;}}}return false;};h.getValue=function(I,H){if(!c.Lang.isObject(I)){return v;}var F,G=c.Array(H),E=G.length;for(F=0;I!==v&&F<E;F++){I=I[G[F]];}return I;};h.setValue=function(K,I,J){var E,H=c.Array(I),G=H.length-1,F=K;if(G>=0){for(E=0;F!==v&&E<G;E++){F=F[H[E]];}if(F!==v){F[H[E]]=J;}else{return v;}}return K;};h.isEmpty=function(F){for(var E in F){if(j(F,E)){return false;}}return true;};YUI.Env.parseUA=function(K){var J=function(N){var O=0;return parseFloat(N.replace(/\./g,function(){return(O++==1)?"":".";}));},M=c.config.win,E=M&&M.navigator,H={ie:0,opera:0,gecko:0,webkit:0,chrome:0,mobile:null,air:0,ipad:0,iphone:0,ipod:0,ios:null,android:0,webos:0,caja:E&&E.cajaVersion,secure:false,os:null},F=K||E&&E.userAgent,L=M&&M.location,G=L&&L.href,I;H.secure=G&&(G.toLowerCase().indexOf("https")===0);if(F){if((/windows|win32/i).test(F)){H.os="windows";}else{if((/macintosh/i).test(F)){H.os="macintosh";}else{if((/rhino/i).test(F)){H.os="rhino";}}}if((/KHTML/).test(F)){H.webkit=1;}I=F.match(/AppleWebKit\/([^\s]*)/);if(I&&I[1]){H.webkit=J(I[1]);if(/ Mobile\//.test(F)){H.mobile="Apple";I=F.match(/OS ([^\s]*)/);if(I&&I[1]){I=J(I[1].replace("_","."));}H.ios=I;H.ipad=H.ipod=H.iphone=0;I=F.match(/iPad|iPod|iPhone/);if(I&&I[0]){H[I[0].toLowerCase()]=H.ios;}}else{I=F.match(/NokiaN[^\/]*|Android \d\.\d|webOS\/\d\.\d/);if(I){H.mobile=I[0];}if(/webOS/.test(F)){H.mobile="WebOS";I=F.match(/webOS\/([^\s]*);/);if(I&&I[1]){H.webos=J(I[1]);}}if(/ Android/.test(F)){H.mobile="Android";I=F.match(/Android ([^\s]*);/);if(I&&I[1]){H.android=J(I[1]);}}}I=F.match(/Chrome\/([^\s]*)/);if(I&&I[1]){H.chrome=J(I[1]);}else{I=F.match(/AdobeAIR\/([^\s]*)/);if(I){H.air=I[0];}}}if(!H.webkit){I=F.match(/Opera[\s\/]([^\s]*)/);if(I&&I[1]){H.opera=J(I[1]);I=F.match(/Opera Mini[^;]*/);if(I){H.mobile=I[0];}}else{I=F.match(/MSIE\s([^;]*)/);if(I&&I[1]){H.ie=J(I[1]);}else{I=F.match(/Gecko\/([^\s]*)/);if(I){H.gecko=1;I=F.match(/rv:([^\s\)]*)/);if(I&&I[1]){H.gecko=J(I[1]);}}}}}}YUI.Env.UA=H;return H;};c.UA=YUI.Env.UA||YUI.Env.parseUA();},"3.3.0");YUI.add("get",function(f){var b=f.UA,a=f.Lang,d="text/javascript",e="text/css",c="stylesheet";f.Get=function(){var m,n,j,l={},k=0,u,w=function(A,x,B){var y=B||f.config.win,C=y.document,D=C.createElement(A),z;for(z in x){if(x[z]&&x.hasOwnProperty(z)){D.setAttribute(z,x[z]);}}return D;},t=function(y,z,x){var A={id:f.guid(),type:e,rel:c,href:y};if(x){f.mix(A,x);}return w("link",A,z);},s=function(y,z,x){var A={id:f.guid(),type:d};if(x){f.mix(A,x);}A.src=y;return w("script",A,z);},p=function(y,z,x){return{tId:y.tId,win:y.win,data:y.data,nodes:y.nodes,msg:z,statusText:x,purge:function(){n(this.tId);}};},o=function(B,A,x){var y=l[B],z;if(y&&y.onEnd){z=y.context||y;y.onEnd.call(z,p(y,A,x));}},v=function(A,z){var x=l[A],y;if(x.timer){clearTimeout(x.timer);}if(x.onFailure){y=x.context||x;x.onFailure.call(y,p(x,z));}o(A,z,"failure");},i=function(A){var x=l[A],z,y;if(x.timer){clearTimeout(x.timer);}x.finished=true;if(x.aborted){z="transaction "+A+" was aborted";v(A,z);return;}if(x.onSuccess){y=x.context||x;x.onSuccess.call(y,p(x));}o(A,z,"OK");},q=function(z){var x=l[z],y;if(x.onTimeout){y=x.context||x;x.onTimeout.call(y,p(x));}o(z,"timeout","timeout");},h=function(z,C){var y=l[z],B,G,F,D,A,x,H,E;if(y.timer){clearTimeout(y.timer);}if(y.aborted){B="transaction "+z+" was aborted";v(z,B);return;}if(C){y.url.shift();if(y.varName){y.varName.shift();}}else{y.url=(a.isString(y.url))?[y.url]:y.url;if(y.varName){y.varName=(a.isString(y.varName))?[y.varName]:y.varName;}}G=y.win;F=G.document;D=F.getElementsByTagName("head")[0];if(y.url.length===0){i(z);return;}x=y.url[0];if(!x){y.url.shift();return h(z);}if(y.timeout){y.timer=setTimeout(function(){q(z);},y.timeout);}if(y.type==="script"){A=s(x,G,y.attributes);}else{A=t(x,G,y.attributes);}j(y.type,A,z,x,G,y.url.length);y.nodes.push(A);E=y.insertBefore||F.getElementsByTagName("base")[0];if(E){H=m(E,z);if(H){H.parentNode.insertBefore(A,H);}}else{D.appendChild(A);}if((b.webkit||b.gecko)&&y.type==="css"){h(z,x);}},g=function(){if(u){return;}u=true;var x,y;for(x in l){if(l.hasOwnProperty(x)){y=l[x];if(y.autopurge&&y.finished){n(y.tId);delete l[x];}}}u=false;},r=function(y,x,z){z=z||{};var C="q"+(k++),A,B=z.purgethreshold||f.Get.PURGE_THRESH;if(k%B===0){g();}l[C]=f.merge(z,{tId:C,type:y,url:x,finished:false,nodes:[]});A=l[C];A.win=A.win||f.config.win;A.context=A.context||A;A.autopurge=("autopurge"in A)?A.autopurge:(y==="script")?true:false;A.attributes=A.attributes||{};A.attributes.charset=z.charset||A.attributes.charset||"utf-8";h(C);return{tId:C};};j=function(z,E,D,y,C,B,x){var A=x||h;if(b.ie){E.onreadystatechange=function(){var F=this.readyState;if("loaded"===F||"complete"===F){E.onreadystatechange=null;A(D,y);}};}else{if(b.webkit){if(z==="script"){E.addEventListener("load",function(){A(D,y);});}}else{E.onload=function(){A(D,y);};E.onerror=function(F){v(D,F+": "+y);};}}};m=function(x,A){var y=l[A],z=(a.isString(x))?y.win.document.getElementById(x):x;if(!z){v(A,"target node not found: "+x);}return z;};n=function(C){var y,A,G,D,H,B,z,F,E,x=l[C];if(x){y=x.nodes;A=y.length;G=x.win.document;D=G.getElementsByTagName("head")[0];E=x.insertBefore||G.getElementsByTagName("base")[0];if(E){H=m(E,C);if(H){D=H.parentNode;}}for(B=0;B<A;B=B+1){z=y[B];if(z.clearAttributes){z.clearAttributes();}else{for(F in z){if(z.hasOwnProperty(F)){delete z[F];}}}D.removeChild(z);}}x.nodes=[];};return{PURGE_THRESH:20,_finalize:function(x){setTimeout(function(){i(x);},0);},abort:function(y){var z=(a.isString(y))?y:y.tId,x=l[z];if(x){x.aborted=true;}},script:function(x,y){return r("script",x,y);},css:function(x,y){return r("css",x,y);}};}();},"3.3.0",{requires:["yui-base"]});YUI.add("features",function(b){var c={};b.mix(b.namespace("Features"),{tests:c,add:function(d,e,f){c[d]=c[d]||{};c[d][e]=f;},all:function(e,f){var g=c[e],d="";if(g){b.Object.each(g,function(i,h){d+=h+":"+(b.Features.test(e,h,f)?1:0)+";";});}return d;},test:function(e,g,f){f=f||[];var d,i,k,j=c[e],h=j&&j[g];if(!h){}else{d=h.result;if(b.Lang.isUndefined(d)){i=h.ua;if(i){d=(b.UA[i]);}k=h.test;if(k&&((!i)||d)){d=k.apply(b,f);}h.result=d;}}return d;}});var a=b.Features.add;a("load","0",{"test":function(d){return!(d.UA.ios||d.UA.android);},"trigger":"autocomplete-list"});a("load","1",{"test":function(j){var h=j.Features.test,i=j.Features.add,f=j.config.win,g=j.config.doc,d="documentElement",e=false;i("style","computedStyle",{test:function(){return f&&"getComputedStyle"in f;}});i("style","opacity",{test:function(){return g&&"opacity"in g[d].style;}});e=(!h("style","opacity")&&!h("style","computedStyle"));return e;},"trigger":"dom-style"});a("load","2",{"trigger":"widget-base","ua":"ie"});a("load","3",{"test":function(e){var d=e.config.doc&&e.config.doc.implementation;return(d&&(!d.hasFeature("Events","2.0")));},"trigger":"node-base"});a("load","4",{"test":function(d){return(d.config.win&&("ontouchstart"in d.config.win&&!d.UA.chrome));},"trigger":"dd-drag"});a("load","5",{"test":function(e){var d=e.config.doc.documentMode;return e.UA.ie&&(!("onhashchange"in e.config.win)||!d||d<8);},"trigger":"history-hash"});},"3.3.0",{requires:["yui-base"]});YUI.add("rls",function(a){a._rls=function(g){var d=a.config,f=d.rls||{m:1,v:a.version,gv:d.gallery,env:1,lang:d.lang,"2in3v":d["2in3"],"2v":d.yui2,filt:d.filter,filts:d.filters,tests:1},b=d.rls_base||"load?",e=d.rls_tmpl||function(){var h="",i;for(i in f){if(i in f&&f[i]){h+=i+"={"+i+"}&";}}return h;}(),c;f.m=g;f.env=a.Object.keys(YUI.Env.mods);f.tests=a.Features.all("load",[a]);c=a.Lang.sub(b+e,f);d.rls=f;d.rls_tmpl=e;return c;};},"3.3.0",{requires:["get","features"]});YUI.add("intl-base",function(b){var a=/[, ]/;b.mix(b.namespace("Intl"),{lookupBestLang:function(g,h){var f,j,c,e;function d(l){var k;for(k=0;k<h.length;k+=1){if(l.toLowerCase()===h[k].toLowerCase()){return h[k];}}}if(b.Lang.isString(g)){g=g.split(a);}for(f=0;f<g.length;f+=1){j=g[f];if(!j||j==="*"){continue;}while(j.length>0){c=d(j);if(c){return c;}else{e=j.lastIndexOf("-");if(e>=0){j=j.substring(0,e);if(e>=2&&j.charAt(e-2)==="-"){j=j.substring(0,e-2);}}else{break;}}}}return"";}});},"3.3.0",{requires:["yui-base"]});YUI.add("yui-log",function(d){var c=d,e="yui:log",a="undefined",b={debug:1,info:1,warn:1,error:1};c.log=function(j,s,g,q){var l,p,n,k,o,i=c,r=i.config,h=(i.fire)?i:YUI.Env.globalEvents;if(r.debug){if(g){p=r.logExclude;n=r.logInclude;if(n&&!(g in n)){l=1;}else{if(p&&(g in p)){l=1;}}}if(!l){if(r.useBrowserConsole){k=(g)?g+": "+j:j;if(i.Lang.isFunction(r.logFn)){r.logFn.call(i,j,s,g);}else{if(typeof console!=a&&console.log){o=(s&&console[s]&&(s in b))?s:"log";console[o](k);}else{if(typeof opera!=a){opera.postError(k);}}}}if(h&&!q){if(h==i&&(!h.getEvent(e))){h.publish(e,{broadcast:2});}h.fire(e,{msg:j,cat:s,src:g});}}}return i;};c.message=function(){return c.log.apply(c,arguments);};},"3.3.0",{requires:["yui-base"]});YUI.add("yui-later",function(a){a.later=function(c,i,d,h,g){c=c||0;var b=d,e,j;if(i&&a.Lang.isString(d)){b=i[d];}e=!a.Lang.isUndefined(h)?function(){b.apply(i,a.Array(h));}:function(){b.call(i);};j=(g)?setInterval(e,c):setTimeout(e,c);return{id:j,interval:g,cancel:function(){if(this.interval){clearInterval(j);}else{clearTimeout(j);}}};};a.Lang.later=a.later;},"3.3.0",{requires:["yui-base"]});YUI.add("yui-throttle",function(a){a.throttle=function(c,b){b=(b)?b:(a.config.throttleTime||150);if(b===-1){return(function(){c.apply(null,arguments);});}var d=a.Lang.now();return(function(){var e=a.Lang.now();if(e-d>b){d=e;c.apply(null,arguments);}});};},"3.3.0",{requires:["yui-base"]});YUI.add("yui",function(a){},"3.3.0",{use:["yui-base","get","features","rls","intl-base","yui-log","yui-later","yui-throttle"]});
// End of File include/javascript/yui3/build/yui/yui-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
if(typeof YAHOO=="undefined"||!YAHOO){var YAHOO={};}YAHOO.namespace=function(){var b=arguments,g=null,e,c,f;for(e=0;e<b.length;e=e+1){f=(""+b[e]).split(".");g=YAHOO;for(c=(f[0]=="YAHOO")?1:0;c<f.length;c=c+1){g[f[c]]=g[f[c]]||{};g=g[f[c]];}}return g;};YAHOO.log=function(d,a,c){var b=YAHOO.widget.Logger;if(b&&b.log){return b.log(d,a,c);}else{return false;}};YAHOO.register=function(a,f,e){var k=YAHOO.env.modules,c,j,h,g,d;if(!k[a]){k[a]={versions:[],builds:[]};}c=k[a];j=e.version;h=e.build;g=YAHOO.env.listeners;c.name=a;c.version=j;c.build=h;c.versions.push(j);c.builds.push(h);c.mainClass=f;for(d=0;d<g.length;d=d+1){g[d](c);}if(f){f.VERSION=j;f.BUILD=h;}else{YAHOO.log("mainClass is undefined for module "+a,"warn");}};YAHOO.env=YAHOO.env||{modules:[],listeners:[]};YAHOO.env.getVersion=function(a){return YAHOO.env.modules[a]||null;};YAHOO.env.parseUA=function(d){var e=function(i){var j=0;return parseFloat(i.replace(/\./g,function(){return(j++==1)?"":".";}));},h=navigator,g={ie:0,opera:0,gecko:0,webkit:0,chrome:0,mobile:null,air:0,ipad:0,iphone:0,ipod:0,ios:null,android:0,webos:0,caja:h&&h.cajaVersion,secure:false,os:null},c=d||(navigator&&navigator.userAgent),f=window&&window.location,b=f&&f.href,a;g.secure=b&&(b.toLowerCase().indexOf("https")===0);if(c){if((/windows|win32/i).test(c)){g.os="windows";}else{if((/macintosh/i).test(c)){g.os="macintosh";}else{if((/rhino/i).test(c)){g.os="rhino";}}}if((/KHTML/).test(c)){g.webkit=1;}a=c.match(/AppleWebKit\/([^\s]*)/);if(a&&a[1]){g.webkit=e(a[1]);if(/ Mobile\//.test(c)){g.mobile="Apple";a=c.match(/OS ([^\s]*)/);if(a&&a[1]){a=e(a[1].replace("_","."));}g.ios=a;g.ipad=g.ipod=g.iphone=0;a=c.match(/iPad|iPod|iPhone/);if(a&&a[0]){g[a[0].toLowerCase()]=g.ios;}}else{a=c.match(/NokiaN[^\/]*|Android \d\.\d|webOS\/\d\.\d/);if(a){g.mobile=a[0];}if(/webOS/.test(c)){g.mobile="WebOS";a=c.match(/webOS\/([^\s]*);/);if(a&&a[1]){g.webos=e(a[1]);}}if(/ Android/.test(c)){g.mobile="Android";a=c.match(/Android ([^\s]*);/);if(a&&a[1]){g.android=e(a[1]);}}}a=c.match(/Chrome\/([^\s]*)/);if(a&&a[1]){g.chrome=e(a[1]);}else{a=c.match(/AdobeAIR\/([^\s]*)/);if(a){g.air=a[0];}}}if(!g.webkit){a=c.match(/Opera[\s\/]([^\s]*)/);if(a&&a[1]){g.opera=e(a[1]);a=c.match(/Version\/([^\s]*)/);if(a&&a[1]){g.opera=e(a[1]);}a=c.match(/Opera Mini[^;]*/);if(a){g.mobile=a[0];}}else{a=c.match(/MSIE\s([^;]*)/);if(a&&a[1]){g.ie=e(a[1]);}else{a=c.match(/Gecko\/([^\s]*)/);if(a){g.gecko=1;a=c.match(/rv:([^\s\)]*)/);if(a&&a[1]){g.gecko=e(a[1]);}}}}}}return g;};YAHOO.env.ua=YAHOO.env.parseUA();(function(){YAHOO.namespace("util","widget","example");if("undefined"!==typeof YAHOO_config){var b=YAHOO_config.listener,a=YAHOO.env.listeners,d=true,c;if(b){for(c=0;c<a.length;c++){if(a[c]==b){d=false;break;}}if(d){a.push(b);}}}})();YAHOO.lang=YAHOO.lang||{};(function(){var f=YAHOO.lang,a=Object.prototype,c="[object Array]",h="[object Function]",i="[object Object]",b=[],g={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","/":"&#x2F;","`":"&#x60;"},d=["toString","valueOf"],e={isArray:function(j){return a.toString.apply(j)===c;},isBoolean:function(j){return typeof j==="boolean";},isFunction:function(j){return(typeof j==="function")||a.toString.apply(j)===h;},isNull:function(j){return j===null;},isNumber:function(j){return typeof j==="number"&&isFinite(j);},isObject:function(j){return(j&&(typeof j==="object"||f.isFunction(j)))||false;},isString:function(j){return typeof j==="string";},isUndefined:function(j){return typeof j==="undefined";},_IEEnumFix:(YAHOO.env.ua.ie)?function(l,k){var j,n,m;for(j=0;j<d.length;j=j+1){n=d[j];m=k[n];if(f.isFunction(m)&&m!=a[n]){l[n]=m;}}}:function(){},escapeHTML:function(j){return j.replace(/[&<>"'\/`]/g,function(k){return g[k];});},extend:function(m,n,l){if(!n||!m){throw new Error("extend failed, please check that "+"all dependencies are included.");}var k=function(){},j;k.prototype=n.prototype;m.prototype=new k();m.prototype.constructor=m;m.superclass=n.prototype;if(n.prototype.constructor==a.constructor){n.prototype.constructor=n;}if(l){for(j in l){if(f.hasOwnProperty(l,j)){m.prototype[j]=l[j];}}f._IEEnumFix(m.prototype,l);}},augmentObject:function(n,m){if(!m||!n){throw new Error("Absorb failed, verify dependencies.");}var j=arguments,l,o,k=j[2];if(k&&k!==true){for(l=2;l<j.length;l=l+1){n[j[l]]=m[j[l]];}}else{for(o in m){if(k||!(o in n)){n[o]=m[o];}}f._IEEnumFix(n,m);}return n;},augmentProto:function(m,l){if(!l||!m){throw new Error("Augment failed, verify dependencies.");}var j=[m.prototype,l.prototype],k;for(k=2;k<arguments.length;k=k+1){j.push(arguments[k]);}f.augmentObject.apply(this,j);return m;},dump:function(j,p){var l,n,r=[],t="{...}",k="f(){...}",q=", ",m=" => ";if(!f.isObject(j)){return j+"";}else{if(j instanceof Date||("nodeType" in j&&"tagName" in j)){return j;}else{if(f.isFunction(j)){return k;}}}p=(f.isNumber(p))?p:3;if(f.isArray(j)){r.push("[");for(l=0,n=j.length;l<n;l=l+1){if(f.isObject(j[l])){r.push((p>0)?f.dump(j[l],p-1):t);}else{r.push(j[l]);}r.push(q);}if(r.length>1){r.pop();}r.push("]");}else{r.push("{");for(l in j){if(f.hasOwnProperty(j,l)){r.push(l+m);if(f.isObject(j[l])){r.push((p>0)?f.dump(j[l],p-1):t);}else{r.push(j[l]);}r.push(q);}}if(r.length>1){r.pop();}r.push("}");}return r.join("");},substitute:function(x,y,E,l){var D,C,B,G,t,u,F=[],p,z=x.length,A="dump",r=" ",q="{",m="}",n,w;for(;;){D=x.lastIndexOf(q,z);if(D<0){break;}C=x.indexOf(m,D);if(D+1>C){break;}p=x.substring(D+1,C);G=p;u=null;B=G.indexOf(r);if(B>-1){u=G.substring(B+1);G=G.substring(0,B);}t=y[G];if(E){t=E(G,t,u);}if(f.isObject(t)){if(f.isArray(t)){t=f.dump(t,parseInt(u,10));}else{u=u||"";n=u.indexOf(A);if(n>-1){u=u.substring(4);}w=t.toString();if(w===i||n>-1){t=f.dump(t,parseInt(u,10));}else{t=w;}}}else{if(!f.isString(t)&&!f.isNumber(t)){t="~-"+F.length+"-~";F[F.length]=p;}}x=x.substring(0,D)+t+x.substring(C+1);if(l===false){z=D-1;}}for(D=F.length-1;D>=0;D=D-1){x=x.replace(new RegExp("~-"+D+"-~"),"{"+F[D]+"}","g");}return x;},trim:function(j){try{return j.replace(/^\s+|\s+$/g,"");}catch(k){return j;
}},merge:function(){var n={},k=arguments,j=k.length,m;for(m=0;m<j;m=m+1){f.augmentObject(n,k[m],true);}return n;},later:function(t,k,u,n,p){t=t||0;k=k||{};var l=u,s=n,q,j;if(f.isString(u)){l=k[u];}if(!l){throw new TypeError("method undefined");}if(!f.isUndefined(n)&&!f.isArray(s)){s=[n];}q=function(){l.apply(k,s||b);};j=(p)?setInterval(q,t):setTimeout(q,t);return{interval:p,cancel:function(){if(this.interval){clearInterval(j);}else{clearTimeout(j);}}};},isValue:function(j){return(f.isObject(j)||f.isString(j)||f.isNumber(j)||f.isBoolean(j));}};f.hasOwnProperty=(a.hasOwnProperty)?function(j,k){return j&&j.hasOwnProperty&&j.hasOwnProperty(k);}:function(j,k){return !f.isUndefined(j[k])&&j.constructor.prototype[k]!==j[k];};e.augmentObject(f,e,true);YAHOO.util.Lang=f;f.augment=f.augmentProto;YAHOO.augment=f.augmentProto;YAHOO.extend=f.extend;})();YAHOO.register("yahoo",YAHOO,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/yahoo/yahoo-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
(function(){YAHOO.env._id_counter=YAHOO.env._id_counter||0;var e=YAHOO.util,k=YAHOO.lang,L=YAHOO.env.ua,a=YAHOO.lang.trim,B={},F={},m=/^t(?:able|d|h)$/i,w=/color$/i,j=window.document,v=j.documentElement,C="ownerDocument",M="defaultView",U="documentElement",S="compatMode",z="offsetLeft",o="offsetTop",T="offsetParent",x="parentNode",K="nodeType",c="tagName",n="scrollLeft",H="scrollTop",p="getBoundingClientRect",V="getComputedStyle",y="currentStyle",l="CSS1Compat",A="BackCompat",E="class",f="className",i="",b=" ",R="(?:^|\\s)",J="(?= |$)",t="g",O="position",D="fixed",u="relative",I="left",N="top",Q="medium",P="borderLeftWidth",q="borderTopWidth",d=L.opera,h=L.webkit,g=L.gecko,s=L.ie;e.Dom={CUSTOM_ATTRIBUTES:(!v.hasAttribute)?{"for":"htmlFor","class":f}:{"htmlFor":"for","className":E},DOT_ATTRIBUTES:{checked:true},get:function(aa){var ac,X,ab,Z,W,G,Y=null;if(aa){if(typeof aa=="string"||typeof aa=="number"){ac=aa+"";aa=j.getElementById(aa);G=(aa)?aa.attributes:null;if(aa&&G&&G.id&&G.id.value===ac){return aa;}else{if(aa&&j.all){aa=null;X=j.all[ac];if(X&&X.length){for(Z=0,W=X.length;Z<W;++Z){if(X[Z].id===ac){return X[Z];}}}}}}else{if(e.Element&&aa instanceof e.Element){aa=aa.get("element");}else{if(!aa.nodeType&&"length" in aa){ab=[];for(Z=0,W=aa.length;Z<W;++Z){ab[ab.length]=e.Dom.get(aa[Z]);}aa=ab;}}}Y=aa;}return Y;},getComputedStyle:function(G,W){if(window[V]){return G[C][M][V](G,null)[W];}else{if(G[y]){return e.Dom.IE_ComputedStyle.get(G,W);}}},getStyle:function(G,W){return e.Dom.batch(G,e.Dom._getStyle,W);},_getStyle:function(){if(window[V]){return function(G,Y){Y=(Y==="float")?Y="cssFloat":e.Dom._toCamel(Y);var X=G.style[Y],W;if(!X){W=G[C][M][V](G,null);if(W){X=W[Y];}}return X;};}else{if(v[y]){return function(G,Y){var X;switch(Y){case"opacity":X=100;try{X=G.filters["DXImageTransform.Microsoft.Alpha"].opacity;}catch(Z){try{X=G.filters("alpha").opacity;}catch(W){}}return X/100;case"float":Y="styleFloat";default:Y=e.Dom._toCamel(Y);X=G[y]?G[y][Y]:null;return(G.style[Y]||X);}};}}}(),setStyle:function(G,W,X){e.Dom.batch(G,e.Dom._setStyle,{prop:W,val:X});},_setStyle:function(){if(!window.getComputedStyle&&j.documentElement.currentStyle){return function(W,G){var X=e.Dom._toCamel(G.prop),Y=G.val;if(W){switch(X){case"opacity":if(Y===""||Y===null||Y===1){W.style.removeAttribute("filter");}else{if(k.isString(W.style.filter)){W.style.filter="alpha(opacity="+Y*100+")";if(!W[y]||!W[y].hasLayout){W.style.zoom=1;}}}break;case"float":X="styleFloat";default:W.style[X]=Y;}}else{}};}else{return function(W,G){var X=e.Dom._toCamel(G.prop),Y=G.val;if(W){if(X=="float"){X="cssFloat";}W.style[X]=Y;}else{}};}}(),getXY:function(G){return e.Dom.batch(G,e.Dom._getXY);},_canPosition:function(G){return(e.Dom._getStyle(G,"display")!=="none"&&e.Dom._inDoc(G));},_getXY:function(W){var X,G,Z,ab,Y,aa,ac=Math.round,ad=false;if(e.Dom._canPosition(W)){Z=W[p]();ab=W[C];X=e.Dom.getDocumentScrollLeft(ab);G=e.Dom.getDocumentScrollTop(ab);ad=[Z[I],Z[N]];if(Y||aa){ad[0]-=aa;ad[1]-=Y;}if((G||X)){ad[0]+=X;ad[1]+=G;}ad[0]=ac(ad[0]);ad[1]=ac(ad[1]);}else{}return ad;},getX:function(G){var W=function(X){return e.Dom.getXY(X)[0];};return e.Dom.batch(G,W,e.Dom,true);},getY:function(G){var W=function(X){return e.Dom.getXY(X)[1];};return e.Dom.batch(G,W,e.Dom,true);},setXY:function(G,X,W){e.Dom.batch(G,e.Dom._setXY,{pos:X,noRetry:W});},_setXY:function(G,Z){var aa=e.Dom._getStyle(G,O),Y=e.Dom.setStyle,ad=Z.pos,W=Z.noRetry,ab=[parseInt(e.Dom.getComputedStyle(G,I),10),parseInt(e.Dom.getComputedStyle(G,N),10)],ac,X;ac=e.Dom._getXY(G);if(!ad||ac===false){return false;}if(aa=="static"){aa=u;Y(G,O,aa);}if(isNaN(ab[0])){ab[0]=(aa==u)?0:G[z];}if(isNaN(ab[1])){ab[1]=(aa==u)?0:G[o];}if(ad[0]!==null){Y(G,I,ad[0]-ac[0]+ab[0]+"px");}if(ad[1]!==null){Y(G,N,ad[1]-ac[1]+ab[1]+"px");}if(!W){X=e.Dom._getXY(G);if((ad[0]!==null&&X[0]!=ad[0])||(ad[1]!==null&&X[1]!=ad[1])){e.Dom._setXY(G,{pos:ad,noRetry:true});}}},setX:function(W,G){e.Dom.setXY(W,[G,null]);},setY:function(G,W){e.Dom.setXY(G,[null,W]);},getRegion:function(G){var W=function(X){var Y=false;if(e.Dom._canPosition(X)){Y=e.Region.getRegion(X);}else{}return Y;};return e.Dom.batch(G,W,e.Dom,true);},getClientWidth:function(){return e.Dom.getViewportWidth();},getClientHeight:function(){return e.Dom.getViewportHeight();},getElementsByClassName:function(ab,af,ac,ae,X,ad){af=af||"*";ac=(ac)?e.Dom.get(ac):null||j;if(!ac){return[];}var W=[],G=ac.getElementsByTagName(af),Z=e.Dom.hasClass;for(var Y=0,aa=G.length;Y<aa;++Y){if(Z(G[Y],ab)){W[W.length]=G[Y];}}if(ae){e.Dom.batch(W,ae,X,ad);}return W;},hasClass:function(W,G){return e.Dom.batch(W,e.Dom._hasClass,G);},_hasClass:function(X,W){var G=false,Y;if(X&&W){Y=e.Dom._getAttribute(X,f)||i;if(Y){Y=Y.replace(/\s+/g,b);}if(W.exec){G=W.test(Y);}else{G=W&&(b+Y+b).indexOf(b+W+b)>-1;}}else{}return G;},addClass:function(W,G){return e.Dom.batch(W,e.Dom._addClass,G);},_addClass:function(X,W){var G=false,Y;if(X&&W){Y=e.Dom._getAttribute(X,f)||i;if(!e.Dom._hasClass(X,W)){e.Dom.setAttribute(X,f,a(Y+b+W));G=true;}}else{}return G;},removeClass:function(W,G){return e.Dom.batch(W,e.Dom._removeClass,G);},_removeClass:function(Y,X){var W=false,aa,Z,G;if(Y&&X){aa=e.Dom._getAttribute(Y,f)||i;e.Dom.setAttribute(Y,f,aa.replace(e.Dom._getClassRegex(X),i));Z=e.Dom._getAttribute(Y,f);if(aa!==Z){e.Dom.setAttribute(Y,f,a(Z));W=true;if(e.Dom._getAttribute(Y,f)===""){G=(Y.hasAttribute&&Y.hasAttribute(E))?E:f;Y.removeAttribute(G);}}}else{}return W;},replaceClass:function(X,W,G){return e.Dom.batch(X,e.Dom._replaceClass,{from:W,to:G});},_replaceClass:function(Y,X){var W,ab,aa,G=false,Z;if(Y&&X){ab=X.from;aa=X.to;if(!aa){G=false;}else{if(!ab){G=e.Dom._addClass(Y,X.to);}else{if(ab!==aa){Z=e.Dom._getAttribute(Y,f)||i;W=(b+Z.replace(e.Dom._getClassRegex(ab),b+aa).replace(/\s+/g,b)).split(e.Dom._getClassRegex(aa));W.splice(1,0,b+aa);e.Dom.setAttribute(Y,f,a(W.join(i)));G=true;}}}}else{}return G;},generateId:function(G,X){X=X||"yui-gen";var W=function(Y){if(Y&&Y.id){return Y.id;}var Z=X+YAHOO.env._id_counter++;
if(Y){if(Y[C]&&Y[C].getElementById(Z)){return e.Dom.generateId(Y,Z+X);}Y.id=Z;}return Z;};return e.Dom.batch(G,W,e.Dom,true)||W.apply(e.Dom,arguments);},isAncestor:function(W,X){W=e.Dom.get(W);X=e.Dom.get(X);var G=false;if((W&&X)&&(W[K]&&X[K])){if(W.contains&&W!==X){G=W.contains(X);}else{if(W.compareDocumentPosition){G=!!(W.compareDocumentPosition(X)&16);}}}else{}return G;},inDocument:function(G,W){return e.Dom._inDoc(e.Dom.get(G),W);},_inDoc:function(W,X){var G=false;if(W&&W[c]){X=X||W[C];G=e.Dom.isAncestor(X[U],W);}else{}return G;},getElementsBy:function(W,af,ab,ad,X,ac,ae){af=af||"*";ab=(ab)?e.Dom.get(ab):null||j;var aa=(ae)?null:[],G;if(ab){G=ab.getElementsByTagName(af);for(var Y=0,Z=G.length;Y<Z;++Y){if(W(G[Y])){if(ae){aa=G[Y];break;}else{aa[aa.length]=G[Y];}}}if(ad){e.Dom.batch(aa,ad,X,ac);}}return aa;},getElementBy:function(X,G,W){return e.Dom.getElementsBy(X,G,W,null,null,null,true);},batch:function(X,ab,aa,Z){var Y=[],W=(Z)?aa:null;X=(X&&(X[c]||X.item))?X:e.Dom.get(X);if(X&&ab){if(X[c]||X.length===undefined){return ab.call(W,X,aa);}for(var G=0;G<X.length;++G){Y[Y.length]=ab.call(W||X[G],X[G],aa);}}else{return false;}return Y;},getDocumentHeight:function(){var W=(j[S]!=l||h)?j.body.scrollHeight:v.scrollHeight,G=Math.max(W,e.Dom.getViewportHeight());return G;},getDocumentWidth:function(){var W=(j[S]!=l||h)?j.body.scrollWidth:v.scrollWidth,G=Math.max(W,e.Dom.getViewportWidth());return G;},getViewportHeight:function(){var G=self.innerHeight,W=j[S];if((W||s)&&!d){G=(W==l)?v.clientHeight:j.body.clientHeight;}return G;},getViewportWidth:function(){var G=self.innerWidth,W=j[S];if(W||s){G=(W==l)?v.clientWidth:j.body.clientWidth;}return G;},getAncestorBy:function(G,W){while((G=G[x])){if(e.Dom._testElement(G,W)){return G;}}return null;},getAncestorByClassName:function(W,G){W=e.Dom.get(W);if(!W){return null;}var X=function(Y){return e.Dom.hasClass(Y,G);};return e.Dom.getAncestorBy(W,X);},getAncestorByTagName:function(W,G){W=e.Dom.get(W);if(!W){return null;}var X=function(Y){return Y[c]&&Y[c].toUpperCase()==G.toUpperCase();};return e.Dom.getAncestorBy(W,X);},getPreviousSiblingBy:function(G,W){while(G){G=G.previousSibling;if(e.Dom._testElement(G,W)){return G;}}return null;},getPreviousSibling:function(G){G=e.Dom.get(G);if(!G){return null;}return e.Dom.getPreviousSiblingBy(G);},getNextSiblingBy:function(G,W){while(G){G=G.nextSibling;if(e.Dom._testElement(G,W)){return G;}}return null;},getNextSibling:function(G){G=e.Dom.get(G);if(!G){return null;}return e.Dom.getNextSiblingBy(G);},getFirstChildBy:function(G,X){var W=(e.Dom._testElement(G.firstChild,X))?G.firstChild:null;return W||e.Dom.getNextSiblingBy(G.firstChild,X);},getFirstChild:function(G,W){G=e.Dom.get(G);if(!G){return null;}return e.Dom.getFirstChildBy(G);},getLastChildBy:function(G,X){if(!G){return null;}var W=(e.Dom._testElement(G.lastChild,X))?G.lastChild:null;return W||e.Dom.getPreviousSiblingBy(G.lastChild,X);},getLastChild:function(G){G=e.Dom.get(G);return e.Dom.getLastChildBy(G);},getChildrenBy:function(W,Y){var X=e.Dom.getFirstChildBy(W,Y),G=X?[X]:[];e.Dom.getNextSiblingBy(X,function(Z){if(!Y||Y(Z)){G[G.length]=Z;}return false;});return G;},getChildren:function(G){G=e.Dom.get(G);if(!G){}return e.Dom.getChildrenBy(G);},getDocumentScrollLeft:function(G){G=G||j;return Math.max(G[U].scrollLeft,G.body.scrollLeft);},getDocumentScrollTop:function(G){G=G||j;return Math.max(G[U].scrollTop,G.body.scrollTop);},insertBefore:function(W,G){W=e.Dom.get(W);G=e.Dom.get(G);if(!W||!G||!G[x]){return null;}return G[x].insertBefore(W,G);},insertAfter:function(W,G){W=e.Dom.get(W);G=e.Dom.get(G);if(!W||!G||!G[x]){return null;}if(G.nextSibling){return G[x].insertBefore(W,G.nextSibling);}else{return G[x].appendChild(W);}},getClientRegion:function(){var X=e.Dom.getDocumentScrollTop(),W=e.Dom.getDocumentScrollLeft(),Y=e.Dom.getViewportWidth()+W,G=e.Dom.getViewportHeight()+X;return new e.Region(X,Y,G,W);},setAttribute:function(W,G,X){e.Dom.batch(W,e.Dom._setAttribute,{attr:G,val:X});},_setAttribute:function(X,W){var G=e.Dom._toCamel(W.attr),Y=W.val;if(X&&X.setAttribute){if(e.Dom.DOT_ATTRIBUTES[G]&&X.tagName&&X.tagName!="BUTTON"){X[G]=Y;}else{G=e.Dom.CUSTOM_ATTRIBUTES[G]||G;X.setAttribute(G,Y);}}else{}},getAttribute:function(W,G){return e.Dom.batch(W,e.Dom._getAttribute,G);},_getAttribute:function(W,G){var X;G=e.Dom.CUSTOM_ATTRIBUTES[G]||G;if(e.Dom.DOT_ATTRIBUTES[G]){X=W[G];}else{if(W&&"getAttribute" in W){if(/^(?:href|src)$/.test(G)){X=W.getAttribute(G,2);}else{X=W.getAttribute(G);}}else{}}return X;},_toCamel:function(W){var X=B;function G(Y,Z){return Z.toUpperCase();}return X[W]||(X[W]=W.indexOf("-")===-1?W:W.replace(/-([a-z])/gi,G));},_getClassRegex:function(W){var G;if(W!==undefined){if(W.exec){G=W;}else{G=F[W];if(!G){W=W.replace(e.Dom._patterns.CLASS_RE_TOKENS,"\\$1");W=W.replace(/\s+/g,b);G=F[W]=new RegExp(R+W+J,t);}}}return G;},_patterns:{ROOT_TAG:/^body|html$/i,CLASS_RE_TOKENS:/([\.\(\)\^\$\*\+\?\|\[\]\{\}\\])/g},_testElement:function(G,W){return G&&G[K]==1&&(!W||W(G));},_calcBorders:function(X,Y){var W=parseInt(e.Dom[V](X,q),10)||0,G=parseInt(e.Dom[V](X,P),10)||0;if(g){if(m.test(X[c])){W=0;G=0;}}Y[0]+=G;Y[1]+=W;return Y;}};var r=e.Dom[V];if(L.opera){e.Dom[V]=function(W,G){var X=r(W,G);if(w.test(G)){X=e.Dom.Color.toRGB(X);}return X;};}if(L.webkit){e.Dom[V]=function(W,G){var X=r(W,G);if(X==="rgba(0, 0, 0, 0)"){X="transparent";}return X;};}if(L.ie&&L.ie>=8){e.Dom.DOT_ATTRIBUTES.type=true;}})();YAHOO.util.Region=function(d,e,a,c){this.top=d;this.y=d;this[1]=d;this.right=e;this.bottom=a;this.left=c;this.x=c;this[0]=c;this.width=this.right-this.left;this.height=this.bottom-this.top;};YAHOO.util.Region.prototype.contains=function(a){return(a.left>=this.left&&a.right<=this.right&&a.top>=this.top&&a.bottom<=this.bottom);};YAHOO.util.Region.prototype.getArea=function(){return((this.bottom-this.top)*(this.right-this.left));};YAHOO.util.Region.prototype.intersect=function(f){var d=Math.max(this.top,f.top),e=Math.min(this.right,f.right),a=Math.min(this.bottom,f.bottom),c=Math.max(this.left,f.left);
if(a>=d&&e>=c){return new YAHOO.util.Region(d,e,a,c);}else{return null;}};YAHOO.util.Region.prototype.union=function(f){var d=Math.min(this.top,f.top),e=Math.max(this.right,f.right),a=Math.max(this.bottom,f.bottom),c=Math.min(this.left,f.left);return new YAHOO.util.Region(d,e,a,c);};YAHOO.util.Region.prototype.toString=function(){return("Region {"+"top: "+this.top+", right: "+this.right+", bottom: "+this.bottom+", left: "+this.left+", height: "+this.height+", width: "+this.width+"}");};YAHOO.util.Region.getRegion=function(e){var g=YAHOO.util.Dom.getXY(e),d=g[1],f=g[0]+e.offsetWidth,a=g[1]+e.offsetHeight,c=g[0];return new YAHOO.util.Region(d,f,a,c);};YAHOO.util.Point=function(a,b){if(YAHOO.lang.isArray(a)){b=a[1];a=a[0];}YAHOO.util.Point.superclass.constructor.call(this,b,a,b,a);};YAHOO.extend(YAHOO.util.Point,YAHOO.util.Region);(function(){var b=YAHOO.util,a="clientTop",f="clientLeft",j="parentNode",k="right",w="hasLayout",i="px",u="opacity",l="auto",d="borderLeftWidth",g="borderTopWidth",p="borderRightWidth",v="borderBottomWidth",s="visible",q="transparent",n="height",e="width",h="style",t="currentStyle",r=/^width|height$/,o=/^(\d[.\d]*)+(em|ex|px|gd|rem|vw|vh|vm|ch|mm|cm|in|pt|pc|deg|rad|ms|s|hz|khz|%){1}?/i,m={get:function(x,z){var y="",A=x[t][z];if(z===u){y=b.Dom.getStyle(x,u);}else{if(!A||(A.indexOf&&A.indexOf(i)>-1)){y=A;}else{if(b.Dom.IE_COMPUTED[z]){y=b.Dom.IE_COMPUTED[z](x,z);}else{if(o.test(A)){y=b.Dom.IE.ComputedStyle.getPixel(x,z);}else{y=A;}}}}return y;},getOffset:function(z,E){var B=z[t][E],x=E.charAt(0).toUpperCase()+E.substr(1),C="offset"+x,y="pixel"+x,A="",D;if(B==l){D=z[C];if(D===undefined){A=0;}A=D;if(r.test(E)){z[h][E]=D;if(z[C]>D){A=D-(z[C]-D);}z[h][E]=l;}}else{if(!z[h][y]&&!z[h][E]){z[h][E]=B;}A=z[h][y];}return A+i;},getBorderWidth:function(x,z){var y=null;if(!x[t][w]){x[h].zoom=1;}switch(z){case g:y=x[a];break;case v:y=x.offsetHeight-x.clientHeight-x[a];break;case d:y=x[f];break;case p:y=x.offsetWidth-x.clientWidth-x[f];break;}return y+i;},getPixel:function(y,x){var A=null,B=y[t][k],z=y[t][x];y[h][k]=z;A=y[h].pixelRight;y[h][k]=B;return A+i;},getMargin:function(y,x){var z;if(y[t][x]==l){z=0+i;}else{z=b.Dom.IE.ComputedStyle.getPixel(y,x);}return z;},getVisibility:function(y,x){var z;while((z=y[t])&&z[x]=="inherit"){y=y[j];}return(z)?z[x]:s;},getColor:function(y,x){return b.Dom.Color.toRGB(y[t][x])||q;},getBorderColor:function(y,x){var z=y[t],A=z[x]||z.color;return b.Dom.Color.toRGB(b.Dom.Color.toHex(A));}},c={};c.top=c.right=c.bottom=c.left=c[e]=c[n]=m.getOffset;c.color=m.getColor;c[g]=c[p]=c[v]=c[d]=m.getBorderWidth;c.marginTop=c.marginRight=c.marginBottom=c.marginLeft=m.getMargin;c.visibility=m.getVisibility;c.borderColor=c.borderTopColor=c.borderRightColor=c.borderBottomColor=c.borderLeftColor=m.getBorderColor;b.Dom.IE_COMPUTED=c;b.Dom.IE_ComputedStyle=m;})();(function(){var c="toString",a=parseInt,b=RegExp,d=YAHOO.util;d.Dom.Color={KEYWORDS:{black:"000",silver:"c0c0c0",gray:"808080",white:"fff",maroon:"800000",red:"f00",purple:"800080",fuchsia:"f0f",green:"008000",lime:"0f0",olive:"808000",yellow:"ff0",navy:"000080",blue:"00f",teal:"008080",aqua:"0ff"},re_RGB:/^rgb\(([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)\)$/i,re_hex:/^#?([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})$/i,re_hex3:/([0-9A-F])/gi,toRGB:function(e){if(!d.Dom.Color.re_RGB.test(e)){e=d.Dom.Color.toHex(e);}if(d.Dom.Color.re_hex.exec(e)){e="rgb("+[a(b.$1,16),a(b.$2,16),a(b.$3,16)].join(", ")+")";}return e;},toHex:function(f){f=d.Dom.Color.KEYWORDS[f]||f;if(d.Dom.Color.re_RGB.exec(f)){f=[Number(b.$1).toString(16),Number(b.$2).toString(16),Number(b.$3).toString(16)];for(var e=0;e<f.length;e++){if(f[e].length<2){f[e]="0"+f[e];}}f=f.join("");}if(f.length<6){f=f.replace(d.Dom.Color.re_hex3,"$1$1");}if(f!=="transparent"&&f.indexOf("#")<0){f="#"+f;}return f.toUpperCase();}};}());YAHOO.register("dom",YAHOO.util.Dom,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/dom/dom-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
YAHOO.util.CustomEvent=function(d,c,b,a,e){this.type=d;this.scope=c||window;this.silent=b;this.fireOnce=e;this.fired=false;this.firedWith=null;this.signature=a||YAHOO.util.CustomEvent.LIST;this.subscribers=[];if(!this.silent){}var f="_YUICEOnSubscribe";if(d!==f){this.subscribeEvent=new YAHOO.util.CustomEvent(f,this,true);}this.lastError=null;};YAHOO.util.CustomEvent.LIST=0;YAHOO.util.CustomEvent.FLAT=1;YAHOO.util.CustomEvent.prototype={subscribe:function(b,c,d){if(!b){throw new Error("Invalid callback for subscriber to '"+this.type+"'");}if(this.subscribeEvent){this.subscribeEvent.fire(b,c,d);}var a=new YAHOO.util.Subscriber(b,c,d);if(this.fireOnce&&this.fired){this.notify(a,this.firedWith);}else{this.subscribers.push(a);}},unsubscribe:function(d,f){if(!d){return this.unsubscribeAll();}var e=false;for(var b=0,a=this.subscribers.length;b<a;++b){var c=this.subscribers[b];if(c&&c.contains(d,f)){this._delete(b);e=true;}}return e;},fire:function(){this.lastError=null;var h=[],a=this.subscribers.length;var d=[].slice.call(arguments,0),c=true,f,b=false;if(this.fireOnce){if(this.fired){return true;}else{this.firedWith=d;}}this.fired=true;if(!a&&this.silent){return true;}if(!this.silent){}var e=this.subscribers.slice();for(f=0;f<a;++f){var g=e[f];if(!g||!g.fn){b=true;}else{c=this.notify(g,d);if(false===c){if(!this.silent){}break;}}}return(c!==false);},notify:function(g,c){var b,i=null,f=g.getScope(this.scope),a=YAHOO.util.Event.throwErrors;if(!this.silent){}if(this.signature==YAHOO.util.CustomEvent.FLAT){if(c.length>0){i=c[0];}try{b=g.fn.call(f,i,g.obj);}catch(h){this.lastError=h;if(a){throw h;}}}else{try{b=g.fn.call(f,this.type,c,g.obj);}catch(d){this.lastError=d;if(a){throw d;}}}return b;},unsubscribeAll:function(){var a=this.subscribers.length,b;for(b=a-1;b>-1;b--){this._delete(b);}this.subscribers=[];return a;},_delete:function(a){var b=this.subscribers[a];if(b){delete b.fn;delete b.obj;}this.subscribers.splice(a,1);},toString:function(){return"CustomEvent: "+"'"+this.type+"', "+"context: "+this.scope;}};YAHOO.util.Subscriber=function(a,b,c){this.fn=a;this.obj=YAHOO.lang.isUndefined(b)?null:b;this.overrideContext=c;};YAHOO.util.Subscriber.prototype.getScope=function(a){if(this.overrideContext){if(this.overrideContext===true){return this.obj;}else{return this.overrideContext;}}return a;};YAHOO.util.Subscriber.prototype.contains=function(a,b){if(b){return(this.fn==a&&this.obj==b);}else{return(this.fn==a);}};YAHOO.util.Subscriber.prototype.toString=function(){return"Subscriber { obj: "+this.obj+", overrideContext: "+(this.overrideContext||"no")+" }";};if(!YAHOO.util.Event){YAHOO.util.Event=function(){var g=false,h=[],j=[],a=0,e=[],b=0,c={63232:38,63233:40,63234:37,63235:39,63276:33,63277:34,25:9},d=YAHOO.env.ua.ie,f="focusin",i="focusout";return{POLL_RETRYS:500,POLL_INTERVAL:40,EL:0,TYPE:1,FN:2,WFN:3,UNLOAD_OBJ:3,ADJ_SCOPE:4,OBJ:5,OVERRIDE:6,CAPTURE:7,lastError:null,isSafari:YAHOO.env.ua.webkit,webkit:YAHOO.env.ua.webkit,isIE:d,_interval:null,_dri:null,_specialTypes:{focusin:(d?"focusin":"focus"),focusout:(d?"focusout":"blur")},DOMReady:false,throwErrors:false,startInterval:function(){if(!this._interval){this._interval=YAHOO.lang.later(this.POLL_INTERVAL,this,this._tryPreloadAttach,null,true);}},onAvailable:function(q,m,o,p,n){var k=(YAHOO.lang.isString(q))?[q]:q;for(var l=0;l<k.length;l=l+1){e.push({id:k[l],fn:m,obj:o,overrideContext:p,checkReady:n});}a=this.POLL_RETRYS;this.startInterval();},onContentReady:function(n,k,l,m){this.onAvailable(n,k,l,m,true);},onDOMReady:function(){this.DOMReadyEvent.subscribe.apply(this.DOMReadyEvent,arguments);},_addListener:function(m,k,v,p,t,y){if(!v||!v.call){return false;}if(this._isValidCollection(m)){var w=true;for(var q=0,s=m.length;q<s;++q){w=this.on(m[q],k,v,p,t)&&w;}return w;}else{if(YAHOO.lang.isString(m)){var o=this.getEl(m);if(o){m=o;}else{this.onAvailable(m,function(){YAHOO.util.Event._addListener(m,k,v,p,t,y);});return true;}}}if(!m){return false;}if("unload"==k&&p!==this){j[j.length]=[m,k,v,p,t];return true;}var l=m;if(t){if(t===true){l=p;}else{l=t;}}var n=function(z){return v.call(l,YAHOO.util.Event.getEvent(z,m),p);};var x=[m,k,v,n,l,p,t,y];var r=h.length;h[r]=x;try{this._simpleAdd(m,k,n,y);}catch(u){this.lastError=u;this.removeListener(m,k,v);return false;}return true;},_getType:function(k){return this._specialTypes[k]||k;},addListener:function(m,p,l,n,o){var k=((p==f||p==i)&&!YAHOO.env.ua.ie)?true:false;return this._addListener(m,this._getType(p),l,n,o,k);},addFocusListener:function(l,k,m,n){return this.on(l,f,k,m,n);},removeFocusListener:function(l,k){return this.removeListener(l,f,k);},addBlurListener:function(l,k,m,n){return this.on(l,i,k,m,n);},removeBlurListener:function(l,k){return this.removeListener(l,i,k);},removeListener:function(l,k,r){var m,p,u;k=this._getType(k);if(typeof l=="string"){l=this.getEl(l);}else{if(this._isValidCollection(l)){var s=true;for(m=l.length-1;m>-1;m--){s=(this.removeListener(l[m],k,r)&&s);}return s;}}if(!r||!r.call){return this.purgeElement(l,false,k);}if("unload"==k){for(m=j.length-1;m>-1;m--){u=j[m];if(u&&u[0]==l&&u[1]==k&&u[2]==r){j.splice(m,1);return true;}}return false;}var n=null;var o=arguments[3];if("undefined"===typeof o){o=this._getCacheIndex(h,l,k,r);}if(o>=0){n=h[o];}if(!l||!n){return false;}var t=n[this.CAPTURE]===true?true:false;try{this._simpleRemove(l,k,n[this.WFN],t);}catch(q){this.lastError=q;return false;}delete h[o][this.WFN];delete h[o][this.FN];h.splice(o,1);return true;},getTarget:function(m,l){var k=m.target||m.srcElement;return this.resolveTextNode(k);},resolveTextNode:function(l){try{if(l&&3==l.nodeType){return l.parentNode;}}catch(k){return null;}return l;},getPageX:function(l){var k=l.pageX;if(!k&&0!==k){k=l.clientX||0;if(this.isIE){k+=this._getScrollLeft();}}return k;},getPageY:function(k){var l=k.pageY;if(!l&&0!==l){l=k.clientY||0;if(this.isIE){l+=this._getScrollTop();}}return l;},getXY:function(k){return[this.getPageX(k),this.getPageY(k)];},getRelatedTarget:function(l){var k=l.relatedTarget;
if(!k){if(l.type=="mouseout"){k=l.toElement;}else{if(l.type=="mouseover"){k=l.fromElement;}}}return this.resolveTextNode(k);},getTime:function(m){if(!m.time){var l=new Date().getTime();try{m.time=l;}catch(k){this.lastError=k;return l;}}return m.time;},stopEvent:function(k){this.stopPropagation(k);this.preventDefault(k);},stopPropagation:function(k){if(k.stopPropagation){k.stopPropagation();}else{k.cancelBubble=true;}},preventDefault:function(k){if(k.preventDefault){k.preventDefault();}else{k.returnValue=false;}},getEvent:function(m,k){var l=m||window.event;if(!l){var n=this.getEvent.caller;while(n){l=n.arguments[0];if(l&&Event==l.constructor){break;}n=n.caller;}}return l;},getCharCode:function(l){var k=l.keyCode||l.charCode||0;if(YAHOO.env.ua.webkit&&(k in c)){k=c[k];}return k;},_getCacheIndex:function(n,q,r,p){for(var o=0,m=n.length;o<m;o=o+1){var k=n[o];if(k&&k[this.FN]==p&&k[this.EL]==q&&k[this.TYPE]==r){return o;}}return -1;},generateId:function(k){var l=k.id;if(!l){l="yuievtautoid-"+b;++b;k.id=l;}return l;},_isValidCollection:function(l){try{return(l&&typeof l!=="string"&&l.length&&!l.tagName&&!l.alert&&typeof l[0]!=="undefined");}catch(k){return false;}},elCache:{},getEl:function(k){return(typeof k==="string")?document.getElementById(k):k;},clearCache:function(){},DOMReadyEvent:new YAHOO.util.CustomEvent("DOMReady",YAHOO,0,0,1),_load:function(l){if(!g){g=true;var k=YAHOO.util.Event;k._ready();k._tryPreloadAttach();}},_ready:function(l){var k=YAHOO.util.Event;if(!k.DOMReady){k.DOMReady=true;k.DOMReadyEvent.fire();k._simpleRemove(document,"DOMContentLoaded",k._ready);}},_tryPreloadAttach:function(){if(e.length===0){a=0;if(this._interval){this._interval.cancel();this._interval=null;}return;}if(this.locked){return;}if(this.isIE){if(!this.DOMReady){this.startInterval();return;}}this.locked=true;var q=!g;if(!q){q=(a>0&&e.length>0);}var p=[];var r=function(t,u){var s=t;if(u.overrideContext){if(u.overrideContext===true){s=u.obj;}else{s=u.overrideContext;}}u.fn.call(s,u.obj);};var l,k,o,n,m=[];for(l=0,k=e.length;l<k;l=l+1){o=e[l];if(o){n=this.getEl(o.id);if(n){if(o.checkReady){if(g||n.nextSibling||!q){m.push(o);e[l]=null;}}else{r(n,o);e[l]=null;}}else{p.push(o);}}}for(l=0,k=m.length;l<k;l=l+1){o=m[l];r(this.getEl(o.id),o);}a--;if(q){for(l=e.length-1;l>-1;l--){o=e[l];if(!o||!o.id){e.splice(l,1);}}this.startInterval();}else{if(this._interval){this._interval.cancel();this._interval=null;}}this.locked=false;},purgeElement:function(p,q,s){var n=(YAHOO.lang.isString(p))?this.getEl(p):p;var r=this.getListeners(n,s),o,k;if(r){for(o=r.length-1;o>-1;o--){var m=r[o];this.removeListener(n,m.type,m.fn);}}if(q&&n&&n.childNodes){for(o=0,k=n.childNodes.length;o<k;++o){this.purgeElement(n.childNodes[o],q,s);}}},getListeners:function(n,k){var q=[],m;if(!k){m=[h,j];}else{if(k==="unload"){m=[j];}else{k=this._getType(k);m=[h];}}var s=(YAHOO.lang.isString(n))?this.getEl(n):n;for(var p=0;p<m.length;p=p+1){var u=m[p];if(u){for(var r=0,t=u.length;r<t;++r){var o=u[r];if(o&&o[this.EL]===s&&(!k||k===o[this.TYPE])){q.push({type:o[this.TYPE],fn:o[this.FN],obj:o[this.OBJ],adjust:o[this.OVERRIDE],scope:o[this.ADJ_SCOPE],index:r});}}}}return(q.length)?q:null;},_unload:function(s){var m=YAHOO.util.Event,p,o,n,r,q,t=j.slice(),k;for(p=0,r=j.length;p<r;++p){n=t[p];if(n){try{k=window;if(n[m.ADJ_SCOPE]){if(n[m.ADJ_SCOPE]===true){k=n[m.UNLOAD_OBJ];}else{k=n[m.ADJ_SCOPE];}}n[m.FN].call(k,m.getEvent(s,n[m.EL]),n[m.UNLOAD_OBJ]);}catch(w){}t[p]=null;}}n=null;k=null;j=null;if(h){for(o=h.length-1;o>-1;o--){n=h[o];if(n){try{m.removeListener(n[m.EL],n[m.TYPE],n[m.FN],o);}catch(v){}}}n=null;}try{m._simpleRemove(window,"unload",m._unload);m._simpleRemove(window,"load",m._load);}catch(u){}},_getScrollLeft:function(){return this._getScroll()[1];},_getScrollTop:function(){return this._getScroll()[0];},_getScroll:function(){var k=document.documentElement,l=document.body;if(k&&(k.scrollTop||k.scrollLeft)){return[k.scrollTop,k.scrollLeft];}else{if(l){return[l.scrollTop,l.scrollLeft];}else{return[0,0];}}},regCE:function(){},_simpleAdd:function(){if(window.addEventListener){return function(m,n,l,k){m.addEventListener(n,l,(k));};}else{if(window.attachEvent){return function(m,n,l,k){m.attachEvent("on"+n,l);};}else{return function(){};}}}(),_simpleRemove:function(){if(window.removeEventListener){return function(m,n,l,k){m.removeEventListener(n,l,(k));};}else{if(window.detachEvent){return function(l,m,k){l.detachEvent("on"+m,k);};}else{return function(){};}}}()};}();(function(){var a=YAHOO.util.Event;a.on=a.addListener;a.onFocus=a.addFocusListener;a.onBlur=a.addBlurListener;
/*! DOMReady: based on work by: Dean Edwards/John Resig/Matthias Miller/Diego Perini */
if(a.isIE){if(self!==self.top){document.onreadystatechange=function(){if(document.readyState=="complete"){document.onreadystatechange=null;a._ready();}};}else{YAHOO.util.Event.onDOMReady(YAHOO.util.Event._tryPreloadAttach,YAHOO.util.Event,true);var b=document.createElement("p");a._dri=setInterval(function(){try{b.doScroll("left");clearInterval(a._dri);a._dri=null;a._ready();b=null;}catch(c){}},a.POLL_INTERVAL);}}else{if(a.webkit&&a.webkit<525){a._dri=setInterval(function(){var c=document.readyState;if("loaded"==c||"complete"==c){clearInterval(a._dri);a._dri=null;a._ready();}},a.POLL_INTERVAL);}else{a._simpleAdd(document,"DOMContentLoaded",a._ready);}}a._simpleAdd(window,"load",a._load);a._simpleAdd(window,"unload",a._unload);a._tryPreloadAttach();})();}YAHOO.util.EventProvider=function(){};YAHOO.util.EventProvider.prototype={__yui_events:null,__yui_subscribers:null,subscribe:function(a,c,f,e){this.__yui_events=this.__yui_events||{};var d=this.__yui_events[a];if(d){d.subscribe(c,f,e);}else{this.__yui_subscribers=this.__yui_subscribers||{};var b=this.__yui_subscribers;if(!b[a]){b[a]=[];}b[a].push({fn:c,obj:f,overrideContext:e});}},unsubscribe:function(c,e,g){this.__yui_events=this.__yui_events||{};var a=this.__yui_events;if(c){var f=a[c];if(f){return f.unsubscribe(e,g);}}else{var b=true;for(var d in a){if(YAHOO.lang.hasOwnProperty(a,d)){b=b&&a[d].unsubscribe(e,g);
}}return b;}return false;},unsubscribeAll:function(a){return this.unsubscribe(a);},createEvent:function(b,g){this.__yui_events=this.__yui_events||{};var e=g||{},d=this.__yui_events,f;if(d[b]){}else{f=new YAHOO.util.CustomEvent(b,e.scope||this,e.silent,YAHOO.util.CustomEvent.FLAT,e.fireOnce);d[b]=f;if(e.onSubscribeCallback){f.subscribeEvent.subscribe(e.onSubscribeCallback);}this.__yui_subscribers=this.__yui_subscribers||{};var a=this.__yui_subscribers[b];if(a){for(var c=0;c<a.length;++c){f.subscribe(a[c].fn,a[c].obj,a[c].overrideContext);}}}return d[b];},fireEvent:function(b){this.__yui_events=this.__yui_events||{};var d=this.__yui_events[b];if(!d){return null;}var a=[];for(var c=1;c<arguments.length;++c){a.push(arguments[c]);}return d.fire.apply(d,a);},hasEvent:function(a){if(this.__yui_events){if(this.__yui_events[a]){return true;}}return false;}};(function(){var a=YAHOO.util.Event,c=YAHOO.lang;YAHOO.util.KeyListener=function(d,i,e,f){if(!d){}else{if(!i){}else{if(!e){}}}if(!f){f=YAHOO.util.KeyListener.KEYDOWN;}var g=new YAHOO.util.CustomEvent("keyPressed");this.enabledEvent=new YAHOO.util.CustomEvent("enabled");this.disabledEvent=new YAHOO.util.CustomEvent("disabled");if(c.isString(d)){d=document.getElementById(d);}if(c.isFunction(e)){g.subscribe(e);}else{g.subscribe(e.fn,e.scope,e.correctScope);}function h(o,n){if(!i.shift){i.shift=false;}if(!i.alt){i.alt=false;}if(!i.ctrl){i.ctrl=false;}if(o.shiftKey==i.shift&&o.altKey==i.alt&&o.ctrlKey==i.ctrl){var j,m=i.keys,l;if(YAHOO.lang.isArray(m)){for(var k=0;k<m.length;k++){j=m[k];l=a.getCharCode(o);if(j==l){g.fire(l,o);break;}}}else{l=a.getCharCode(o);if(m==l){g.fire(l,o);}}}}this.enable=function(){if(!this.enabled){a.on(d,f,h);this.enabledEvent.fire(i);}this.enabled=true;};this.disable=function(){if(this.enabled){a.removeListener(d,f,h);this.disabledEvent.fire(i);}this.enabled=false;};this.toString=function(){return"KeyListener ["+i.keys+"] "+d.tagName+(d.id?"["+d.id+"]":"");};};var b=YAHOO.util.KeyListener;b.KEYDOWN="keydown";b.KEYUP="keyup";b.KEY={ALT:18,BACK_SPACE:8,CAPS_LOCK:20,CONTROL:17,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,LEFT:37,META:224,NUM_LOCK:144,PAGE_DOWN:34,PAGE_UP:33,PAUSE:19,PRINTSCREEN:44,RIGHT:39,SCROLL_LOCK:145,SHIFT:16,SPACE:32,TAB:9,UP:38};})();YAHOO.register("event",YAHOO.util.Event,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/event/event-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
YAHOO.widget.LogMsg=function(a){this.msg=this.time=this.category=this.source=this.sourceDetail=null;if(a&&(a.constructor==Object)){for(var b in a){if(a.hasOwnProperty(b)){this[b]=a[b];}}}};YAHOO.widget.LogWriter=function(a){if(!a){YAHOO.log("Could not instantiate LogWriter due to invalid source.","error","LogWriter");return;}this._source=a;};YAHOO.widget.LogWriter.prototype.toString=function(){return"LogWriter "+this._sSource;};YAHOO.widget.LogWriter.prototype.log=function(a,b){YAHOO.widget.Logger.log(a,b,this._source);};YAHOO.widget.LogWriter.prototype.getSource=function(){return this._source;};YAHOO.widget.LogWriter.prototype.setSource=function(a){if(!a){YAHOO.log("Could not set source due to invalid source.","error",this.toString());return;}else{this._source=a;}};YAHOO.widget.LogWriter.prototype._source=null;if(!YAHOO.widget.Logger){YAHOO.widget.Logger={loggerEnabled:true,_browserConsoleEnabled:false,categories:["info","warn","error","time","window"],sources:["global"],_stack:[],maxStackEntries:2500,_startTime:new Date().getTime(),_lastTime:null,_windowErrorsHandled:false,_origOnWindowError:null};YAHOO.widget.Logger.log=function(b,f,g){if(this.loggerEnabled){if(!f){f="info";}else{f=f.toLocaleLowerCase();if(this._isNewCategory(f)){this._createNewCategory(f);}}var c="global";var a=null;if(g){var d=g.indexOf(" ");if(d>0){c=g.substring(0,d);a=g.substring(d,g.length);}else{c=g;}if(this._isNewSource(c)){this._createNewSource(c);}}var h=new Date();var j=new YAHOO.widget.LogMsg({msg:b,time:h,category:f,source:c,sourceDetail:a});var i=this._stack;var e=this.maxStackEntries;if(e&&!isNaN(e)&&(i.length>=e)){i.shift();}i.push(j);this.newLogEvent.fire(j);if(this._browserConsoleEnabled){this._printToBrowserConsole(j);}return true;}else{return false;}};YAHOO.widget.Logger.reset=function(){this._stack=[];this._startTime=new Date().getTime();this.loggerEnabled=true;this.log("Logger reset");this.logResetEvent.fire();};YAHOO.widget.Logger.getStack=function(){return this._stack;};YAHOO.widget.Logger.getStartTime=function(){return this._startTime;};YAHOO.widget.Logger.disableBrowserConsole=function(){YAHOO.log("Logger output to the function console.log() has been disabled.");this._browserConsoleEnabled=false;};YAHOO.widget.Logger.enableBrowserConsole=function(){this._browserConsoleEnabled=true;YAHOO.log("Logger output to the function console.log() has been enabled.");};YAHOO.widget.Logger.handleWindowErrors=function(){if(!YAHOO.widget.Logger._windowErrorsHandled){if(window.error){YAHOO.widget.Logger._origOnWindowError=window.onerror;}window.onerror=YAHOO.widget.Logger._onWindowError;YAHOO.widget.Logger._windowErrorsHandled=true;YAHOO.log("Logger handling of window.onerror has been enabled.");}else{YAHOO.log("Logger handling of window.onerror had already been enabled.");}};YAHOO.widget.Logger.unhandleWindowErrors=function(){if(YAHOO.widget.Logger._windowErrorsHandled){if(YAHOO.widget.Logger._origOnWindowError){window.onerror=YAHOO.widget.Logger._origOnWindowError;YAHOO.widget.Logger._origOnWindowError=null;}else{window.onerror=null;}YAHOO.widget.Logger._windowErrorsHandled=false;YAHOO.log("Logger handling of window.onerror has been disabled.");}else{YAHOO.log("Logger handling of window.onerror had already been disabled.");}};YAHOO.widget.Logger.categoryCreateEvent=new YAHOO.util.CustomEvent("categoryCreate",this,true);YAHOO.widget.Logger.sourceCreateEvent=new YAHOO.util.CustomEvent("sourceCreate",this,true);YAHOO.widget.Logger.newLogEvent=new YAHOO.util.CustomEvent("newLog",this,true);YAHOO.widget.Logger.logResetEvent=new YAHOO.util.CustomEvent("logReset",this,true);YAHOO.widget.Logger._createNewCategory=function(a){this.categories.push(a);this.categoryCreateEvent.fire(a);};YAHOO.widget.Logger._isNewCategory=function(b){for(var a=0;a<this.categories.length;a++){if(b==this.categories[a]){return false;}}return true;};YAHOO.widget.Logger._createNewSource=function(a){this.sources.push(a);this.sourceCreateEvent.fire(a);};YAHOO.widget.Logger._isNewSource=function(a){if(a){for(var b=0;b<this.sources.length;b++){if(a==this.sources[b]){return false;}}return true;}};YAHOO.widget.Logger._printToBrowserConsole=function(c){if((window.console&&console.log)||(window.opera&&opera.postError)){var e=c.category;var d=c.category.substring(0,4).toUpperCase();var g=c.time;var f;if(g.toLocaleTimeString){f=g.toLocaleTimeString();}else{f=g.toString();}var h=g.getTime();var b=(YAHOO.widget.Logger._lastTime)?(h-YAHOO.widget.Logger._lastTime):0;YAHOO.widget.Logger._lastTime=h;var a=f+" ("+b+"ms): "+c.source+": ";if(window.console){console.log(a,c.msg);}else{opera.postError(a+c.msg);}}};YAHOO.widget.Logger._onWindowError=function(a,c,b){try{YAHOO.widget.Logger.log(a+" ("+c+", line "+b+")","window");if(YAHOO.widget.Logger._origOnWindowError){YAHOO.widget.Logger._origOnWindowError();}}catch(d){return false;}};YAHOO.widget.Logger.log("Logger initialized");}(function(){var c=YAHOO.widget.Logger,e=YAHOO.util,f=e.Dom,a=e.Event,h=document;function b(i,d){i=h.createElement(i);if(d){for(var j in d){if(d.hasOwnProperty(j)){i[j]=d[j];}}}return i;}function g(i,d){this._sName=g._index;g._index++;this._init.apply(this,arguments);if(this.autoRender!==false){this.render();}}YAHOO.lang.augmentObject(g,{_index:0,ENTRY_TEMPLATE:(function(){return b("pre",{className:"yui-log-entry"});})(),VERBOSE_TEMPLATE:"<p><span class='{category}'>{label}</span> {totalTime}ms (+{elapsedTime}) {localTime}:</p><p>{sourceAndDetail}</p><p>{message}</p>",BASIC_TEMPLATE:"<p><span class='{category}'>{label}</span> {totalTime}ms (+{elapsedTime}) {localTime}: {sourceAndDetail}: {message}</p>"});g.prototype={logReaderEnabled:true,width:null,height:null,top:null,left:null,right:null,bottom:null,fontSize:null,footerEnabled:true,verboseOutput:true,entryFormat:null,newestOnTop:true,outputBuffer:100,thresholdMax:500,thresholdMin:100,isCollapsed:false,isPaused:false,draggable:true,toString:function(){return"LogReader instance"+this._sName;},pause:function(){this.isPaused=true;this._timeout=null;
this.logReaderEnabled=false;if(this._btnPause){this._btnPause.value="Resume";}},resume:function(){this.isPaused=false;this.logReaderEnabled=true;this._printBuffer();if(this._btnPause){this._btnPause.value="Pause";}},render:function(){if(this.rendered){return;}this._initContainerEl();this._initHeaderEl();this._initConsoleEl();this._initFooterEl();this._initCategories();this._initSources();this._initDragDrop();c.newLogEvent.subscribe(this._onNewLog,this);c.logResetEvent.subscribe(this._onReset,this);c.categoryCreateEvent.subscribe(this._onCategoryCreate,this);c.sourceCreateEvent.subscribe(this._onSourceCreate,this);this.rendered=true;this._filterLogs();},destroy:function(){a.purgeElement(this._elContainer,true);this._elContainer.innerHTML="";this._elContainer.parentNode.removeChild(this._elContainer);this.rendered=false;},hide:function(){this._elContainer.style.display="none";},show:function(){this._elContainer.style.display="block";},collapse:function(){this._elConsole.style.display="none";if(this._elFt){this._elFt.style.display="none";}this._btnCollapse.value="Expand";this.isCollapsed=true;},expand:function(){this._elConsole.style.display="block";if(this._elFt){this._elFt.style.display="block";}this._btnCollapse.value="Collapse";this.isCollapsed=false;},getCheckbox:function(d){return this._filterCheckboxes[d];},getCategories:function(){return this._categoryFilters;},showCategory:function(j){var l=this._categoryFilters;if(l.indexOf){if(l.indexOf(j)>-1){return;}}else{for(var d=0;d<l.length;d++){if(l[d]===j){return;}}}this._categoryFilters.push(j);this._filterLogs();var k=this.getCheckbox(j);if(k){k.checked=true;}},hideCategory:function(j){var l=this._categoryFilters;for(var d=0;d<l.length;d++){if(j==l[d]){l.splice(d,1);break;}}this._filterLogs();var k=this.getCheckbox(j);if(k){k.checked=false;}},getSources:function(){return this._sourceFilters;},showSource:function(d){var l=this._sourceFilters;if(l.indexOf){if(l.indexOf(d)>-1){return;}}else{for(var j=0;j<l.length;j++){if(d==l[j]){return;}}}l.push(d);this._filterLogs();var k=this.getCheckbox(d);if(k){k.checked=true;}},hideSource:function(d){var l=this._sourceFilters;for(var j=0;j<l.length;j++){if(d==l[j]){l.splice(j,1);break;}}this._filterLogs();var k=this.getCheckbox(d);if(k){k.checked=false;}},clearConsole:function(){this._timeout=null;this._buffer=[];this._consoleMsgCount=0;var d=this._elConsole;d.innerHTML="";},setTitle:function(d){this._title.innerHTML=this.html2Text(d);},getLastTime:function(){return this._lastTime;},formatMsg:function(i){var d=this.entryFormat||(this.verboseOutput?g.VERBOSE_TEMPLATE:g.BASIC_TEMPLATE),j={category:i.category,label:i.category.substring(0,4).toUpperCase(),sourceAndDetail:i.sourceDetail?i.source+" "+i.sourceDetail:i.source,message:this.html2Text(i.msg||i.message||"")};if(i.time&&i.time.getTime){j.localTime=i.time.toLocaleTimeString?i.time.toLocaleTimeString():i.time.toString();j.elapsedTime=i.time.getTime()-this.getLastTime();j.totalTime=i.time.getTime()-c.getStartTime();}var k=g.ENTRY_TEMPLATE.cloneNode(true);if(this.verboseOutput){k.className+=" yui-log-verbose";}k.innerHTML=d.replace(/\{(\w+)\}/g,function(l,m){return(m in j)?j[m]:"";});return k;},html2Text:function(d){if(d){d+="";return d.replace(/&/g,"&#38;").replace(/</g,"&#60;").replace(/>/g,"&#62;");}return"";},_sName:null,_buffer:null,_consoleMsgCount:0,_lastTime:null,_timeout:null,_filterCheckboxes:null,_categoryFilters:null,_sourceFilters:null,_elContainer:null,_elHd:null,_elCollapse:null,_btnCollapse:null,_title:null,_elConsole:null,_elFt:null,_elBtns:null,_elCategoryFilters:null,_elSourceFilters:null,_btnPause:null,_btnClear:null,_init:function(d,i){this._buffer=[];this._filterCheckboxes={};this._lastTime=c.getStartTime();if(i&&(i.constructor==Object)){for(var j in i){if(i.hasOwnProperty(j)){this[j]=i[j];}}}this._elContainer=f.get(d);YAHOO.log("LogReader initialized",null,this.toString());},_initContainerEl:function(){if(!this._elContainer||!/div$/i.test(this._elContainer.tagName)){this._elContainer=h.body.insertBefore(b("div"),h.body.firstChild);f.addClass(this._elContainer,"yui-log-container");}f.addClass(this._elContainer,"yui-log");var k=this._elContainer.style,d=["width","right","top","fontSize"],l,j;for(j=d.length-1;j>=0;--j){l=d[j];if(this[l]){k[l]=this[l];}}if(this.left){k.left=this.left;k.right="auto";}if(this.bottom){k.bottom=this.bottom;k.top="auto";}if(YAHOO.env.ua.opera){h.body.style+="";}},_initHeaderEl:function(){if(this._elHd){a.purgeElement(this._elHd,true);this._elHd.innerHTML="";}this._elHd=b("div",{className:"yui-log-hd"});f.generateId(this._elHd,"yui-log-hd"+this._sName);this._elCollapse=b("div",{className:"yui-log-btns"});this._btnCollapse=b("input",{type:"button",className:"yui-log-button",value:"Collapse"});a.on(this._btnCollapse,"click",this._onClickCollapseBtn,this);this._title=b("h4",{innerHTML:"Logger Console"});this._elCollapse.appendChild(this._btnCollapse);this._elHd.appendChild(this._elCollapse);this._elHd.appendChild(this._title);this._elContainer.appendChild(this._elHd);},_initConsoleEl:function(){if(this._elConsole){a.purgeElement(this._elConsole,true);this._elConsole.innerHTML="";}this._elConsole=b("div",{className:"yui-log-bd"});if(this.height){this._elConsole.style.height=this.height;}this._elContainer.appendChild(this._elConsole);},_initFooterEl:function(){if(this.footerEnabled){if(this._elFt){a.purgeElement(this._elFt,true);this._elFt.innerHTML="";}this._elFt=b("div",{className:"yui-log-ft"});this._elBtns=b("div",{className:"yui-log-btns"});this._btnPause=b("input",{type:"button",className:"yui-log-button",value:"Pause"});a.on(this._btnPause,"click",this._onClickPauseBtn,this);this._btnClear=b("input",{type:"button",className:"yui-log-button",value:"Clear"});a.on(this._btnClear,"click",this._onClickClearBtn,this);this._elCategoryFilters=b("div",{className:"yui-log-categoryfilters"});this._elSourceFilters=b("div",{className:"yui-log-sourcefilters"});this._elBtns.appendChild(this._btnPause);this._elBtns.appendChild(this._btnClear);
this._elFt.appendChild(this._elBtns);this._elFt.appendChild(this._elCategoryFilters);this._elFt.appendChild(this._elSourceFilters);this._elContainer.appendChild(this._elFt);}},_initDragDrop:function(){if(e.DD&&this.draggable&&this._elHd){var d=new e.DD(this._elContainer);d.setHandleElId(this._elHd.id);this._elHd.style.cursor="move";}},_initCategories:function(){this._categoryFilters=[];var k=c.categories;for(var d=0;d<k.length;d++){var i=k[d];this._categoryFilters.push(i);if(this._elCategoryFilters){this._createCategoryCheckbox(i);}}},_initSources:function(){this._sourceFilters=[];var k=c.sources;for(var i=0;i<k.length;i++){var d=k[i];this._sourceFilters.push(d);if(this._elSourceFilters){this._createSourceCheckbox(d);}}},_createCategoryCheckbox:function(l){if(this._elFt){var k=b("span",{className:"yui-log-filtergrp"}),j=f.generateId(null,"yui-log-filter-"+l+this._sName),d=b("input",{id:j,className:"yui-log-filter-"+l,type:"checkbox",category:l}),i=b("label",{htmlFor:j,className:l,innerHTML:l});a.on(d,"click",this._onCheckCategory,this);this._filterCheckboxes[l]=d;k.appendChild(d);k.appendChild(i);this._elCategoryFilters.appendChild(k);d.checked=true;}},_createSourceCheckbox:function(d){if(this._elFt){var l=b("span",{className:"yui-log-filtergrp"}),k=f.generateId(null,"yui-log-filter-"+d+this._sName),i=b("input",{id:k,className:"yui-log-filter-"+d,type:"checkbox",source:d}),j=b("label",{htmlFor:k,className:d,innerHTML:d});a.on(i,"click",this._onCheckSource,this);this._filterCheckboxes[d]=i;l.appendChild(i);l.appendChild(j);this._elSourceFilters.appendChild(l);i.checked=true;}},_filterLogs:function(){if(this._elConsole!==null){this.clearConsole();this._printToConsole(c.getStack());}},_printBuffer:function(){this._timeout=null;if(this._elConsole!==null){var j=this.thresholdMax;j=(j&&!isNaN(j))?j:500;if(this._consoleMsgCount<j){var d=[];for(var k=0;k<this._buffer.length;k++){d[k]=this._buffer[k];}this._buffer=[];this._printToConsole(d);}else{this._filterLogs();}if(!this.newestOnTop){this._elConsole.scrollTop=this._elConsole.scrollHeight;}}},_printToConsole:function(r){var k=r.length,v=h.createDocumentFragment(),y=[],z=this.thresholdMin,l=this._sourceFilters.length,w=this._categoryFilters.length,t,q,p,o,u;if(isNaN(z)||(z>this.thresholdMax)){z=0;}t=(k>z)?(k-z):0;for(q=t;q<k;q++){var n=false,s=false,x=r[q],d=x.source,m=x.category;for(p=0;p<l;p++){if(d==this._sourceFilters[p]){s=true;break;}}if(s){for(p=0;p<w;p++){if(m==this._categoryFilters[p]){n=true;break;}}}if(n){if(this._consoleMsgCount===0){this._lastTime=x.time.getTime();}o=this.formatMsg(x);if(typeof o==="string"){y[y.length]=o;}else{v.insertBefore(o,this.newestOnTop?v.firstChild||null:null);}this._consoleMsgCount++;this._lastTime=x.time.getTime();}}if(y.length){y.splice(0,0,this._elConsole.innerHTML);this._elConsole.innerHTML=this.newestOnTop?y.reverse().join(""):y.join("");}else{if(v.firstChild){this._elConsole.insertBefore(v,this.newestOnTop?this._elConsole.firstChild||null:null);}}},_onCategoryCreate:function(k,j,d){var i=j[0];d._categoryFilters.push(i);if(d._elFt){d._createCategoryCheckbox(i);}},_onSourceCreate:function(k,j,d){var i=j[0];d._sourceFilters.push(i);if(d._elFt){d._createSourceCheckbox(i);}},_onCheckCategory:function(d,i){var j=this.category;if(!this.checked){i.hideCategory(j);}else{i.showCategory(j);}},_onCheckSource:function(d,i){var j=this.source;if(!this.checked){i.hideSource(j);}else{i.showSource(j);}},_onClickCollapseBtn:function(d,i){if(!i.isCollapsed){i.collapse();}else{i.expand();}},_onClickPauseBtn:function(d,i){if(!i.isPaused){i.pause();}else{i.resume();}},_onClickClearBtn:function(d,i){i.clearConsole();},_onNewLog:function(k,j,d){var i=j[0];d._buffer.push(i);if(d.logReaderEnabled===true&&d._timeout===null){d._timeout=setTimeout(function(){d._printBuffer();},d.outputBuffer);}},_onReset:function(j,i,d){d._filterLogs();}};YAHOO.widget.LogReader=g;})();YAHOO.register("logger",YAHOO.widget.Logger,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/logger/logger-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
(function(){var b=YAHOO.util;var a=function(d,c,e,f){if(!d){}this.init(d,c,e,f);};a.NAME="Anim";a.prototype={toString:function(){var c=this.getEl()||{};var d=c.id||c.tagName;return(this.constructor.NAME+": "+d);},patterns:{noNegatives:/width|height|opacity|padding/i,offsetAttribute:/^((width|height)|(top|left))$/,defaultUnit:/width|height|top$|bottom$|left$|right$/i,offsetUnit:/\d+(em|%|en|ex|pt|in|cm|mm|pc)$/i},doMethod:function(c,e,d){return this.method(this.currentFrame,e,d-e,this.totalFrames);},setAttribute:function(c,f,e){var d=this.getEl();if(this.patterns.noNegatives.test(c)){f=(f>0)?f:0;}if(c in d&&!("style" in d&&c in d.style)){d[c]=f;}else{b.Dom.setStyle(d,c,f+e);}},getAttribute:function(c){var e=this.getEl();var g=b.Dom.getStyle(e,c);if(g!=="auto"&&!this.patterns.offsetUnit.test(g)){return parseFloat(g);}var d=this.patterns.offsetAttribute.exec(c)||[];var h=!!(d[3]);var f=!!(d[2]);if("style" in e){if(f||(b.Dom.getStyle(e,"position")=="absolute"&&h)){g=e["offset"+d[0].charAt(0).toUpperCase()+d[0].substr(1)];}else{g=0;}}else{if(c in e){g=e[c];}}return g;},getDefaultUnit:function(c){if(this.patterns.defaultUnit.test(c)){return"px";}return"";},setRuntimeAttribute:function(d){var j;var e;var f=this.attributes;this.runtimeAttributes[d]={};var h=function(i){return(typeof i!=="undefined");};if(!h(f[d]["to"])&&!h(f[d]["by"])){return false;}j=(h(f[d]["from"]))?f[d]["from"]:this.getAttribute(d);if(h(f[d]["to"])){e=f[d]["to"];}else{if(h(f[d]["by"])){if(j.constructor==Array){e=[];for(var g=0,c=j.length;g<c;++g){e[g]=j[g]+f[d]["by"][g]*1;}}else{e=j+f[d]["by"]*1;}}}this.runtimeAttributes[d].start=j;this.runtimeAttributes[d].end=e;this.runtimeAttributes[d].unit=(h(f[d].unit))?f[d]["unit"]:this.getDefaultUnit(d);return true;},init:function(f,c,h,i){var d=false;var e=null;var g=0;f=b.Dom.get(f);this.attributes=c||{};this.duration=!YAHOO.lang.isUndefined(h)?h:1;this.method=i||b.Easing.easeNone;this.useSeconds=true;this.currentFrame=0;this.totalFrames=b.AnimMgr.fps;this.setEl=function(j){f=b.Dom.get(j);};this.getEl=function(){return f;};this.isAnimated=function(){return d;};this.getStartTime=function(){return e;};this.runtimeAttributes={};this.animate=function(){if(this.isAnimated()){return false;}this.currentFrame=0;this.totalFrames=(this.useSeconds)?Math.ceil(b.AnimMgr.fps*this.duration):this.duration;if(this.duration===0&&this.useSeconds){this.totalFrames=1;}b.AnimMgr.registerElement(this);return true;};this.stop=function(j){if(!this.isAnimated()){return false;}if(j){this.currentFrame=this.totalFrames;this._onTween.fire();}b.AnimMgr.stop(this);};this._handleStart=function(){this.onStart.fire();this.runtimeAttributes={};for(var j in this.attributes){if(this.attributes.hasOwnProperty(j)){this.setRuntimeAttribute(j);}}d=true;g=0;e=new Date();};this._handleTween=function(){var l={duration:new Date()-this.getStartTime(),currentFrame:this.currentFrame};l.toString=function(){return("duration: "+l.duration+", currentFrame: "+l.currentFrame);};this.onTween.fire(l);var k=this.runtimeAttributes;for(var j in k){if(k.hasOwnProperty(j)){this.setAttribute(j,this.doMethod(j,k[j].start,k[j].end),k[j].unit);}}this.afterTween.fire(l);g+=1;};this._handleComplete=function(){var j=(new Date()-e)/1000;var k={duration:j,frames:g,fps:g/j};k.toString=function(){return("duration: "+k.duration+", frames: "+k.frames+", fps: "+k.fps);};d=false;g=0;this.onComplete.fire(k);};this._onStart=new b.CustomEvent("_start",this,true);this.onStart=new b.CustomEvent("start",this);this.onTween=new b.CustomEvent("tween",this);this.afterTween=new b.CustomEvent("afterTween",this);this._onTween=new b.CustomEvent("_tween",this,true);this.onComplete=new b.CustomEvent("complete",this);this._onComplete=new b.CustomEvent("_complete",this,true);this._onStart.subscribe(this._handleStart);this._onTween.subscribe(this._handleTween);this._onComplete.subscribe(this._handleComplete);}};b.Anim=a;})();YAHOO.util.AnimMgr=new function(){var e=null;var c=[];var g=0;this.fps=1000;this.delay=20;this.registerElement=function(j){c[c.length]=j;g+=1;j._onStart.fire();this.start();};var f=[];var d=false;var h=function(){var j=f.shift();b.apply(YAHOO.util.AnimMgr,j);if(f.length){arguments.callee();}};var b=function(k,j){j=j||a(k);if(!k.isAnimated()||j===-1){return false;}k._onComplete.fire();c.splice(j,1);g-=1;if(g<=0){this.stop();}return true;};this.unRegister=function(){f.push(arguments);if(!d){d=true;h();d=false;}};this.start=function(){if(e===null){e=setInterval(this.run,this.delay);}};this.stop=function(l){if(!l){clearInterval(e);for(var k=0,j=c.length;k<j;++k){this.unRegister(c[0],0);}c=[];e=null;g=0;}else{this.unRegister(l);}};this.run=function(){for(var l=0,j=c.length;l<j;++l){var k=c[l];if(!k||!k.isAnimated()){continue;}if(k.currentFrame<k.totalFrames||k.totalFrames===null){k.currentFrame+=1;if(k.useSeconds){i(k);}k._onTween.fire();}else{YAHOO.util.AnimMgr.stop(k,l);}}};var a=function(l){for(var k=0,j=c.length;k<j;++k){if(c[k]===l){return k;}}return -1;};var i=function(k){var n=k.totalFrames;var m=k.currentFrame;var l=(k.currentFrame*k.duration*1000/k.totalFrames);var j=(new Date()-k.getStartTime());var o=0;if(j<k.duration*1000){o=Math.round((j/l-1)*k.currentFrame);}else{o=n-(m+1);}if(o>0&&isFinite(o)){if(k.currentFrame+o>=n){o=n-(m+1);}k.currentFrame+=o;}};this._queue=c;this._getIndex=a;};YAHOO.util.Bezier=new function(){this.getPosition=function(e,d){var f=e.length;var c=[];for(var b=0;b<f;++b){c[b]=[e[b][0],e[b][1]];}for(var a=1;a<f;++a){for(b=0;b<f-a;++b){c[b][0]=(1-d)*c[b][0]+d*c[parseInt(b+1,10)][0];c[b][1]=(1-d)*c[b][1]+d*c[parseInt(b+1,10)][1];}}return[c[0][0],c[0][1]];};};(function(){var a=function(f,e,g,h){a.superclass.constructor.call(this,f,e,g,h);};a.NAME="ColorAnim";a.DEFAULT_BGCOLOR="#fff";var c=YAHOO.util;YAHOO.extend(a,c.Anim);var d=a.superclass;var b=a.prototype;b.patterns.color=/color$/i;b.patterns.rgb=/^rgb\(([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)\)$/i;b.patterns.hex=/^#?([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})$/i;b.patterns.hex3=/^#?([0-9A-F]{1})([0-9A-F]{1})([0-9A-F]{1})$/i;
b.patterns.transparent=/^transparent|rgba\(0, 0, 0, 0\)$/;b.parseColor=function(e){if(e.length==3){return e;}var f=this.patterns.hex.exec(e);if(f&&f.length==4){return[parseInt(f[1],16),parseInt(f[2],16),parseInt(f[3],16)];}f=this.patterns.rgb.exec(e);if(f&&f.length==4){return[parseInt(f[1],10),parseInt(f[2],10),parseInt(f[3],10)];}f=this.patterns.hex3.exec(e);if(f&&f.length==4){return[parseInt(f[1]+f[1],16),parseInt(f[2]+f[2],16),parseInt(f[3]+f[3],16)];}return null;};b.getAttribute=function(e){var g=this.getEl();if(this.patterns.color.test(e)){var i=YAHOO.util.Dom.getStyle(g,e);var h=this;if(this.patterns.transparent.test(i)){var f=YAHOO.util.Dom.getAncestorBy(g,function(j){return !h.patterns.transparent.test(i);});if(f){i=c.Dom.getStyle(f,e);}else{i=a.DEFAULT_BGCOLOR;}}}else{i=d.getAttribute.call(this,e);}return i;};b.doMethod=function(f,k,g){var j;if(this.patterns.color.test(f)){j=[];for(var h=0,e=k.length;h<e;++h){j[h]=d.doMethod.call(this,f,k[h],g[h]);}j="rgb("+Math.floor(j[0])+","+Math.floor(j[1])+","+Math.floor(j[2])+")";}else{j=d.doMethod.call(this,f,k,g);}return j;};b.setRuntimeAttribute=function(f){d.setRuntimeAttribute.call(this,f);if(this.patterns.color.test(f)){var h=this.attributes;var k=this.parseColor(this.runtimeAttributes[f].start);var g=this.parseColor(this.runtimeAttributes[f].end);if(typeof h[f]["to"]==="undefined"&&typeof h[f]["by"]!=="undefined"){g=this.parseColor(h[f].by);for(var j=0,e=k.length;j<e;++j){g[j]=k[j]+g[j];}}this.runtimeAttributes[f].start=k;this.runtimeAttributes[f].end=g;}};c.ColorAnim=a;})();
/*!
TERMS OF USE - EASING EQUATIONS
Open source under the BSD License.
Copyright 2001 Robert Penner All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name of the author nor the names of contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
YAHOO.util.Easing={easeNone:function(e,a,g,f){return g*e/f+a;},easeIn:function(e,a,g,f){return g*(e/=f)*e+a;},easeOut:function(e,a,g,f){return -g*(e/=f)*(e-2)+a;},easeBoth:function(e,a,g,f){if((e/=f/2)<1){return g/2*e*e+a;}return -g/2*((--e)*(e-2)-1)+a;},easeInStrong:function(e,a,g,f){return g*(e/=f)*e*e*e+a;},easeOutStrong:function(e,a,g,f){return -g*((e=e/f-1)*e*e*e-1)+a;},easeBothStrong:function(e,a,g,f){if((e/=f/2)<1){return g/2*e*e*e*e+a;}return -g/2*((e-=2)*e*e*e-2)+a;},elasticIn:function(g,e,k,j,f,i){if(g==0){return e;}if((g/=j)==1){return e+k;}if(!i){i=j*0.3;}if(!f||f<Math.abs(k)){f=k;var h=i/4;}else{var h=i/(2*Math.PI)*Math.asin(k/f);}return -(f*Math.pow(2,10*(g-=1))*Math.sin((g*j-h)*(2*Math.PI)/i))+e;},elasticOut:function(g,e,k,j,f,i){if(g==0){return e;}if((g/=j)==1){return e+k;}if(!i){i=j*0.3;}if(!f||f<Math.abs(k)){f=k;var h=i/4;}else{var h=i/(2*Math.PI)*Math.asin(k/f);}return f*Math.pow(2,-10*g)*Math.sin((g*j-h)*(2*Math.PI)/i)+k+e;},elasticBoth:function(g,e,k,j,f,i){if(g==0){return e;}if((g/=j/2)==2){return e+k;}if(!i){i=j*(0.3*1.5);}if(!f||f<Math.abs(k)){f=k;var h=i/4;}else{var h=i/(2*Math.PI)*Math.asin(k/f);}if(g<1){return -0.5*(f*Math.pow(2,10*(g-=1))*Math.sin((g*j-h)*(2*Math.PI)/i))+e;}return f*Math.pow(2,-10*(g-=1))*Math.sin((g*j-h)*(2*Math.PI)/i)*0.5+k+e;},backIn:function(e,a,h,g,f){if(typeof f=="undefined"){f=1.70158;}return h*(e/=g)*e*((f+1)*e-f)+a;},backOut:function(e,a,h,g,f){if(typeof f=="undefined"){f=1.70158;}return h*((e=e/g-1)*e*((f+1)*e+f)+1)+a;},backBoth:function(e,a,h,g,f){if(typeof f=="undefined"){f=1.70158;}if((e/=g/2)<1){return h/2*(e*e*(((f*=(1.525))+1)*e-f))+a;}return h/2*((e-=2)*e*(((f*=(1.525))+1)*e+f)+2)+a;},bounceIn:function(e,a,g,f){return g-YAHOO.util.Easing.bounceOut(f-e,0,g,f)+a;},bounceOut:function(e,a,g,f){if((e/=f)<(1/2.75)){return g*(7.5625*e*e)+a;}else{if(e<(2/2.75)){return g*(7.5625*(e-=(1.5/2.75))*e+0.75)+a;}else{if(e<(2.5/2.75)){return g*(7.5625*(e-=(2.25/2.75))*e+0.9375)+a;}}}return g*(7.5625*(e-=(2.625/2.75))*e+0.984375)+a;},bounceBoth:function(e,a,g,f){if(e<f/2){return YAHOO.util.Easing.bounceIn(e*2,0,g,f)*0.5+a;}return YAHOO.util.Easing.bounceOut(e*2-f,0,g,f)*0.5+g*0.5+a;}};(function(){var a=function(h,g,i,j){if(h){a.superclass.constructor.call(this,h,g,i,j);}};a.NAME="Motion";var e=YAHOO.util;YAHOO.extend(a,e.ColorAnim);var f=a.superclass;var c=a.prototype;c.patterns.points=/^points$/i;c.setAttribute=function(g,i,h){if(this.patterns.points.test(g)){h=h||"px";f.setAttribute.call(this,"left",i[0],h);f.setAttribute.call(this,"top",i[1],h);}else{f.setAttribute.call(this,g,i,h);}};c.getAttribute=function(g){if(this.patterns.points.test(g)){var h=[f.getAttribute.call(this,"left"),f.getAttribute.call(this,"top")];}else{h=f.getAttribute.call(this,g);}return h;};c.doMethod=function(g,k,h){var j=null;if(this.patterns.points.test(g)){var i=this.method(this.currentFrame,0,100,this.totalFrames)/100;j=e.Bezier.getPosition(this.runtimeAttributes[g],i);
}else{j=f.doMethod.call(this,g,k,h);}return j;};c.setRuntimeAttribute=function(q){if(this.patterns.points.test(q)){var h=this.getEl();var k=this.attributes;var g;var m=k["points"]["control"]||[];var j;var n,p;if(m.length>0&&!(m[0] instanceof Array)){m=[m];}else{var l=[];for(n=0,p=m.length;n<p;++n){l[n]=m[n];}m=l;}if(e.Dom.getStyle(h,"position")=="static"){e.Dom.setStyle(h,"position","relative");}if(d(k["points"]["from"])){e.Dom.setXY(h,k["points"]["from"]);}else{e.Dom.setXY(h,e.Dom.getXY(h));}g=this.getAttribute("points");if(d(k["points"]["to"])){j=b.call(this,k["points"]["to"],g);var o=e.Dom.getXY(this.getEl());for(n=0,p=m.length;n<p;++n){m[n]=b.call(this,m[n],g);}}else{if(d(k["points"]["by"])){j=[g[0]+k["points"]["by"][0],g[1]+k["points"]["by"][1]];for(n=0,p=m.length;n<p;++n){m[n]=[g[0]+m[n][0],g[1]+m[n][1]];}}}this.runtimeAttributes[q]=[g];if(m.length>0){this.runtimeAttributes[q]=this.runtimeAttributes[q].concat(m);}this.runtimeAttributes[q][this.runtimeAttributes[q].length]=j;}else{f.setRuntimeAttribute.call(this,q);}};var b=function(g,i){var h=e.Dom.getXY(this.getEl());g=[g[0]-h[0]+i[0],g[1]-h[1]+i[1]];return g;};var d=function(g){return(typeof g!=="undefined");};e.Motion=a;})();(function(){var d=function(f,e,g,h){if(f){d.superclass.constructor.call(this,f,e,g,h);}};d.NAME="Scroll";var b=YAHOO.util;YAHOO.extend(d,b.ColorAnim);var c=d.superclass;var a=d.prototype;a.doMethod=function(e,h,f){var g=null;if(e=="scroll"){g=[this.method(this.currentFrame,h[0],f[0]-h[0],this.totalFrames),this.method(this.currentFrame,h[1],f[1]-h[1],this.totalFrames)];}else{g=c.doMethod.call(this,e,h,f);}return g;};a.getAttribute=function(e){var g=null;var f=this.getEl();if(e=="scroll"){g=[f.scrollLeft,f.scrollTop];}else{g=c.getAttribute.call(this,e);}return g;};a.setAttribute=function(e,h,g){var f=this.getEl();if(e=="scroll"){f.scrollLeft=h[0];f.scrollTop=h[1];}else{c.setAttribute.call(this,e,h,g);}};b.Scroll=d;})();YAHOO.register("animation",YAHOO.util.Anim,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/animation/animation-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
YAHOO.util.Connect={_msxml_progid:["Microsoft.XMLHTTP","MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP"],_http_headers:{},_has_http_headers:false,_use_default_post_header:true,_default_post_header:"application/x-www-form-urlencoded; charset=UTF-8",_default_form_header:"application/x-www-form-urlencoded",_use_default_xhr_header:true,_default_xhr_header:"XMLHttpRequest",_has_default_headers:true,_isFormSubmit:false,_default_headers:{},_poll:{},_timeOut:{},_polling_interval:50,_transaction_id:0,startEvent:new YAHOO.util.CustomEvent("start"),completeEvent:new YAHOO.util.CustomEvent("complete"),successEvent:new YAHOO.util.CustomEvent("success"),failureEvent:new YAHOO.util.CustomEvent("failure"),abortEvent:new YAHOO.util.CustomEvent("abort"),_customEvents:{onStart:["startEvent","start"],onComplete:["completeEvent","complete"],onSuccess:["successEvent","success"],onFailure:["failureEvent","failure"],onUpload:["uploadEvent","upload"],onAbort:["abortEvent","abort"]},setProgId:function(a){this._msxml_progid.unshift(a);},setDefaultPostHeader:function(a){if(typeof a=="string"){this._default_post_header=a;this._use_default_post_header=true;}else{if(typeof a=="boolean"){this._use_default_post_header=a;}}},setDefaultXhrHeader:function(a){if(typeof a=="string"){this._default_xhr_header=a;}else{this._use_default_xhr_header=a;}},setPollingInterval:function(a){if(typeof a=="number"&&isFinite(a)){this._polling_interval=a;}},createXhrObject:function(g){var d,a,b;try{a=new XMLHttpRequest();d={conn:a,tId:g,xhr:true};}catch(c){for(b=0;b<this._msxml_progid.length;++b){try{a=new ActiveXObject(this._msxml_progid[b]);d={conn:a,tId:g,xhr:true};break;}catch(f){}}}finally{return d;}},getConnectionObject:function(a){var c,d=this._transaction_id;try{if(!a){c=this.createXhrObject(d);}else{c={tId:d};if(a==="xdr"){c.conn=this._transport;c.xdr=true;}else{if(a==="upload"){c.upload=true;}}}if(c){this._transaction_id++;}}catch(b){}return c;},asyncRequest:function(h,d,g,a){var b=g&&g.argument?g.argument:null,e=this,f,c;if(this._isFileUpload){c="upload";}else{if(g&&g.xdr){c="xdr";}}f=this.getConnectionObject(c);if(!f){return null;}else{if(g&&g.customevents){this.initCustomEvents(f,g);}if(this._isFormSubmit){if(this._isFileUpload){window.setTimeout(function(){e.uploadFile(f,g,d,a);},10);return f;}if(h.toUpperCase()=="GET"){if(this._sFormData.length!==0){d+=((d.indexOf("?")==-1)?"?":"&")+this._sFormData;}}else{if(h.toUpperCase()=="POST"){a=a?this._sFormData+"&"+a:this._sFormData;}}}if(h.toUpperCase()=="GET"&&(g&&g.cache===false)){d+=((d.indexOf("?")==-1)?"?":"&")+"rnd="+new Date().valueOf().toString();}if(this._use_default_xhr_header){if(!this._default_headers["X-Requested-With"]){this.initHeader("X-Requested-With",this._default_xhr_header,true);}}if((h.toUpperCase()==="POST"&&this._use_default_post_header)&&this._isFormSubmit===false){this.initHeader("Content-Type",this._default_post_header);}if(f.xdr){this.xdr(f,h,d,g,a);return f;}f.conn.open(h,d,true);if(this._has_default_headers||this._has_http_headers){this.setHeader(f);}this.handleReadyState(f,g);f.conn.send(a||"");if(this._isFormSubmit===true){this.resetFormState();}this.startEvent.fire(f,b);if(f.startEvent){f.startEvent.fire(f,b);}return f;}},initCustomEvents:function(a,c){var b;for(b in c.customevents){if(this._customEvents[b][0]){a[this._customEvents[b][0]]=new YAHOO.util.CustomEvent(this._customEvents[b][1],(c.scope)?c.scope:null);a[this._customEvents[b][0]].subscribe(c.customevents[b]);}}},handleReadyState:function(c,d){var b=this,a=(d&&d.argument)?d.argument:null;if(d&&d.timeout){this._timeOut[c.tId]=window.setTimeout(function(){b.abort(c,d,true);},d.timeout);}this._poll[c.tId]=window.setInterval(function(){if(c.conn&&c.conn.readyState===4){window.clearInterval(b._poll[c.tId]);delete b._poll[c.tId];if(d&&d.timeout){window.clearTimeout(b._timeOut[c.tId]);delete b._timeOut[c.tId];}b.completeEvent.fire(c,a);if(c.completeEvent){c.completeEvent.fire(c,a);}b.handleTransactionResponse(c,d);}},this._polling_interval);},handleTransactionResponse:function(b,j,d){var f,a,h=(j&&j.argument)?j.argument:null,c=(b.r&&b.r.statusText==="xdr:success")?true:false,i=(b.r&&b.r.statusText==="xdr:failure")?true:false,k=d;try{if((b.conn.status!==undefined&&b.conn.status!==0)||c){f=b.conn.status;}else{if(i&&!k){f=0;}else{f=13030;}}}catch(g){f=13030;}if((f>=200&&f<300)||f===1223||c){a=b.xdr?b.r:this.createResponseObject(b,h);if(j&&j.success){if(!j.scope){j.success(a);}else{j.success.apply(j.scope,[a]);}}this.successEvent.fire(a);if(b.successEvent){b.successEvent.fire(a);}}else{switch(f){case 12002:case 12029:case 12030:case 12031:case 12152:case 13030:a=this.createExceptionObject(b.tId,h,(d?d:false));if(j&&j.failure){if(!j.scope){j.failure(a);}else{j.failure.apply(j.scope,[a]);}}break;default:a=(b.xdr)?b.response:this.createResponseObject(b,h);if(j&&j.failure){if(!j.scope){j.failure(a);}else{j.failure.apply(j.scope,[a]);}}}this.failureEvent.fire(a);if(b.failureEvent){b.failureEvent.fire(a);}}this.releaseObject(b);a=null;},createResponseObject:function(a,h){var d={},k={},f,c,g,b;try{c=a.conn.getAllResponseHeaders();g=c.split("\n");for(f=0;f<g.length;f++){b=g[f].indexOf(":");if(b!=-1){k[g[f].substring(0,b)]=YAHOO.lang.trim(g[f].substring(b+2));}}}catch(j){}d.tId=a.tId;d.status=(a.conn.status==1223)?204:a.conn.status;d.statusText=(a.conn.status==1223)?"No Content":a.conn.statusText;d.getResponseHeader=k;d.getAllResponseHeaders=c;d.responseText=a.conn.responseText;d.responseXML=a.conn.responseXML;if(h){d.argument=h;}return d;},createExceptionObject:function(h,d,a){var f=0,g="communication failure",c=-1,b="transaction aborted",e={};e.tId=h;if(a){e.status=c;e.statusText=b;}else{e.status=f;e.statusText=g;}if(d){e.argument=d;}return e;},initHeader:function(a,d,c){var b=(c)?this._default_headers:this._http_headers;b[a]=d;if(c){this._has_default_headers=true;}else{this._has_http_headers=true;}},setHeader:function(a){var b;if(this._has_default_headers){for(b in this._default_headers){if(YAHOO.lang.hasOwnProperty(this._default_headers,b)){a.conn.setRequestHeader(b,this._default_headers[b]);
}}}if(this._has_http_headers){for(b in this._http_headers){if(YAHOO.lang.hasOwnProperty(this._http_headers,b)){a.conn.setRequestHeader(b,this._http_headers[b]);}}this._http_headers={};this._has_http_headers=false;}},resetDefaultHeaders:function(){this._default_headers={};this._has_default_headers=false;},abort:function(e,g,a){var d,b=(g&&g.argument)?g.argument:null;e=e||{};if(e.conn){if(e.xhr){if(this.isCallInProgress(e)){e.conn.abort();window.clearInterval(this._poll[e.tId]);delete this._poll[e.tId];if(a){window.clearTimeout(this._timeOut[e.tId]);delete this._timeOut[e.tId];}d=true;}}else{if(e.xdr){e.conn.abort(e.tId);d=true;}}}else{if(e.upload){var c="yuiIO"+e.tId;var f=document.getElementById(c);if(f){YAHOO.util.Event.removeListener(f,"load");document.body.removeChild(f);if(a){window.clearTimeout(this._timeOut[e.tId]);delete this._timeOut[e.tId];}d=true;}}else{d=false;}}if(d===true){this.abortEvent.fire(e,b);if(e.abortEvent){e.abortEvent.fire(e,b);}this.handleTransactionResponse(e,g,true);}return d;},isCallInProgress:function(a){a=a||{};if(a.xhr&&a.conn){return a.conn.readyState!==4&&a.conn.readyState!==0;}else{if(a.xdr&&a.conn){return a.conn.isCallInProgress(a.tId);}else{if(a.upload===true){return document.getElementById("yuiIO"+a.tId)?true:false;}else{return false;}}}},releaseObject:function(a){if(a&&a.conn){a.conn=null;a=null;}}};(function(){var g=YAHOO.util.Connect,h={};function d(i){var j='<object id="YUIConnectionSwf" type="application/x-shockwave-flash" data="'+i+'" width="0" height="0">'+'<param name="movie" value="'+i+'">'+'<param name="allowScriptAccess" value="always">'+"</object>",k=document.createElement("div");document.body.appendChild(k);k.innerHTML=j;}function b(l,i,j,n,k){h[parseInt(l.tId)]={"o":l,"c":n};if(k){n.method=i;n.data=k;}l.conn.send(j,n,l.tId);}function e(i){d(i);g._transport=document.getElementById("YUIConnectionSwf");}function c(){g.xdrReadyEvent.fire();}function a(j,i){if(j){g.startEvent.fire(j,i.argument);if(j.startEvent){j.startEvent.fire(j,i.argument);}}}function f(j){var k=h[j.tId].o,i=h[j.tId].c;if(j.statusText==="xdr:start"){a(k,i);return;}j.responseText=decodeURI(j.responseText);k.r=j;if(i.argument){k.r.argument=i.argument;}this.handleTransactionResponse(k,i,j.statusText==="xdr:abort"?true:false);delete h[j.tId];}g.xdr=b;g.swf=d;g.transport=e;g.xdrReadyEvent=new YAHOO.util.CustomEvent("xdrReady");g.xdrReady=c;g.handleXdrResponse=f;})();(function(){var e=YAHOO.util.Connect,g=YAHOO.util.Event,a=document.documentMode?document.documentMode:false;e._isFileUpload=false;e._formNode=null;e._sFormData=null;e._submitElementValue=null;e.uploadEvent=new YAHOO.util.CustomEvent("upload");e._hasSubmitListener=function(){if(g){g.addListener(document,"click",function(k){var j=g.getTarget(k),i=j.nodeName.toLowerCase();if((i==="input"||i==="button")&&(j.type&&j.type.toLowerCase()=="submit")){e._submitElementValue=encodeURIComponent(j.name)+"="+encodeURIComponent(j.value);}});return true;}return false;}();function h(w,r,m){var v,l,u,s,z,t=false,p=[],y=0,o,q,n,x,k;this.resetFormState();if(typeof w=="string"){v=(document.getElementById(w)||document.forms[w]);}else{if(typeof w=="object"){v=w;}else{return;}}if(r){this.createFrame(m?m:null);this._isFormSubmit=true;this._isFileUpload=true;this._formNode=v;return;}for(o=0,q=v.elements.length;o<q;++o){l=v.elements[o];z=l.disabled;u=l.name;if(!z&&u){u=encodeURIComponent(u)+"=";s=encodeURIComponent(l.value);switch(l.type){case"select-one":if(l.selectedIndex>-1){k=l.options[l.selectedIndex];p[y++]=u+encodeURIComponent((k.attributes.value&&k.attributes.value.specified)?k.value:k.text);}break;case"select-multiple":if(l.selectedIndex>-1){for(n=l.selectedIndex,x=l.options.length;n<x;++n){k=l.options[n];if(k.selected){p[y++]=u+encodeURIComponent((k.attributes.value&&k.attributes.value.specified)?k.value:k.text);}}}break;case"radio":case"checkbox":if(l.checked){p[y++]=u+s;}break;case"file":case undefined:case"reset":case"button":break;case"submit":if(t===false){if(this._hasSubmitListener&&this._submitElementValue){p[y++]=this._submitElementValue;}t=true;}break;default:p[y++]=u+s;}}}this._isFormSubmit=true;this._sFormData=p.join("&");this.initHeader("Content-Type",this._default_form_header);return this._sFormData;}function d(){this._isFormSubmit=false;this._isFileUpload=false;this._formNode=null;this._sFormData="";}function c(i){var j="yuiIO"+this._transaction_id,l=(a===9)?true:false,k;if(YAHOO.env.ua.ie&&!l){k=document.createElement('<iframe id="'+j+'" name="'+j+'" />');if(typeof i=="boolean"){k.src="javascript:false";}}else{k=document.createElement("iframe");k.id=j;k.name=j;}k.style.position="absolute";k.style.top="-1000px";k.style.left="-1000px";document.body.appendChild(k);}function f(j){var m=[],k=j.split("&"),l,n;for(l=0;l<k.length;l++){n=k[l].indexOf("=");if(n!=-1){m[l]=document.createElement("input");m[l].type="hidden";m[l].name=decodeURIComponent(k[l].substring(0,n));m[l].value=decodeURIComponent(k[l].substring(n+1));this._formNode.appendChild(m[l]);}}return m;}function b(m,y,n,l){var t="yuiIO"+m.tId,u="multipart/form-data",w=document.getElementById(t),p=(a>=8)?true:false,z=this,v=(y&&y.argument)?y.argument:null,x,s,k,r,j,q;j={action:this._formNode.getAttribute("action"),method:this._formNode.getAttribute("method"),target:this._formNode.getAttribute("target")};this._formNode.setAttribute("action",n);this._formNode.setAttribute("method","POST");this._formNode.setAttribute("target",t);if(YAHOO.env.ua.ie&&!p){this._formNode.setAttribute("encoding",u);}else{this._formNode.setAttribute("enctype",u);}if(l){x=this.appendPostData(l);}this._formNode.submit();this.startEvent.fire(m,v);if(m.startEvent){m.startEvent.fire(m,v);}if(y&&y.timeout){this._timeOut[m.tId]=window.setTimeout(function(){z.abort(m,y,true);},y.timeout);}if(x&&x.length>0){for(s=0;s<x.length;s++){this._formNode.removeChild(x[s]);}}for(k in j){if(YAHOO.lang.hasOwnProperty(j,k)){if(j[k]){this._formNode.setAttribute(k,j[k]);}else{this._formNode.removeAttribute(k);}}}this.resetFormState();
q=function(){var i,A,B;if(y&&y.timeout){window.clearTimeout(z._timeOut[m.tId]);delete z._timeOut[m.tId];}z.completeEvent.fire(m,v);if(m.completeEvent){m.completeEvent.fire(m,v);}r={tId:m.tId,argument:v};try{i=w.contentWindow.document.getElementsByTagName("body")[0];A=w.contentWindow.document.getElementsByTagName("pre")[0];if(i){if(A){B=A.textContent?A.textContent:A.innerText;}else{B=i.textContent?i.textContent:i.innerText;}}r.responseText=B;r.responseXML=w.contentWindow.document.XMLDocument?w.contentWindow.document.XMLDocument:w.contentWindow.document;}catch(o){}if(y&&y.upload){if(!y.scope){y.upload(r);}else{y.upload.apply(y.scope,[r]);}}z.uploadEvent.fire(r);if(m.uploadEvent){m.uploadEvent.fire(r);}g.removeListener(w,"load",q);setTimeout(function(){document.body.removeChild(w);z.releaseObject(m);},100);};g.addListener(w,"load",q);}e.setForm=h;e.resetFormState=d;e.createFrame=c;e.appendPostData=f;e.uploadFile=b;})();YAHOO.register("connection",YAHOO.util.Connect,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/connection/connection-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
if(!YAHOO.util.DragDropMgr){YAHOO.util.DragDropMgr=function(){var A=YAHOO.util.Event,B=YAHOO.util.Dom;return{useShim:false,_shimActive:false,_shimState:false,_debugShim:false,_createShim:function(){var C=document.createElement("div");C.id="yui-ddm-shim";if(document.body.firstChild){document.body.insertBefore(C,document.body.firstChild);}else{document.body.appendChild(C);}C.style.display="none";C.style.backgroundColor="red";C.style.position="absolute";C.style.zIndex="99999";B.setStyle(C,"opacity","0");this._shim=C;A.on(C,"mouseup",this.handleMouseUp,this,true);A.on(C,"mousemove",this.handleMouseMove,this,true);A.on(window,"scroll",this._sizeShim,this,true);},_sizeShim:function(){if(this._shimActive){var C=this._shim;C.style.height=B.getDocumentHeight()+"px";C.style.width=B.getDocumentWidth()+"px";C.style.top="0";C.style.left="0";}},_activateShim:function(){if(this.useShim){if(!this._shim){this._createShim();}this._shimActive=true;var C=this._shim,D="0";if(this._debugShim){D=".5";}B.setStyle(C,"opacity",D);this._sizeShim();C.style.display="block";}},_deactivateShim:function(){this._shim.style.display="none";this._shimActive=false;},_shim:null,ids:{},handleIds:{},dragCurrent:null,dragOvers:{},deltaX:0,deltaY:0,preventDefault:true,stopPropagation:true,initialized:false,locked:false,interactionInfo:null,init:function(){this.initialized=true;},POINT:0,INTERSECT:1,STRICT_INTERSECT:2,mode:0,_execOnAll:function(E,D){for(var F in this.ids){for(var C in this.ids[F]){var G=this.ids[F][C];if(!this.isTypeOfDD(G)){continue;}G[E].apply(G,D);}}},_onLoad:function(){this.init();A.on(document,"mouseup",this.handleMouseUp,this,true);A.on(document,"mousemove",this.handleMouseMove,this,true);A.on(window,"unload",this._onUnload,this,true);A.on(window,"resize",this._onResize,this,true);},_onResize:function(C){this._execOnAll("resetConstraints",[]);},lock:function(){this.locked=true;},unlock:function(){this.locked=false;},isLocked:function(){return this.locked;},locationCache:{},useCache:true,clickPixelThresh:3,clickTimeThresh:1000,dragThreshMet:false,clickTimeout:null,startX:0,startY:0,fromTimeout:false,regDragDrop:function(D,C){if(!this.initialized){this.init();}if(!this.ids[C]){this.ids[C]={};}this.ids[C][D.id]=D;},removeDDFromGroup:function(E,C){if(!this.ids[C]){this.ids[C]={};}var D=this.ids[C];if(D&&D[E.id]){delete D[E.id];}},_remove:function(E){for(var D in E.groups){if(D){var C=this.ids[D];if(C&&C[E.id]){delete C[E.id];}}}delete this.handleIds[E.id];},regHandle:function(D,C){if(!this.handleIds[D]){this.handleIds[D]={};}this.handleIds[D][C]=C;},isDragDrop:function(C){return(this.getDDById(C))?true:false;},getRelated:function(H,D){var G=[];for(var F in H.groups){for(var E in this.ids[F]){var C=this.ids[F][E];if(!this.isTypeOfDD(C)){continue;}if(!D||C.isTarget){G[G.length]=C;}}}return G;},isLegalTarget:function(G,F){var D=this.getRelated(G,true);for(var E=0,C=D.length;E<C;++E){if(D[E].id==F.id){return true;}}return false;},isTypeOfDD:function(C){return(C&&C.__ygDragDrop);},isHandle:function(D,C){return(this.handleIds[D]&&this.handleIds[D][C]);},getDDById:function(D){for(var C in this.ids){if(this.ids[C][D]){return this.ids[C][D];}}return null;},handleMouseDown:function(E,D){this.currentTarget=YAHOO.util.Event.getTarget(E);this.dragCurrent=D;var C=D.getEl();this.startX=YAHOO.util.Event.getPageX(E);this.startY=YAHOO.util.Event.getPageY(E);this.deltaX=this.startX-C.offsetLeft;this.deltaY=this.startY-C.offsetTop;this.dragThreshMet=false;this.clickTimeout=setTimeout(function(){var F=YAHOO.util.DDM;F.startDrag(F.startX,F.startY);F.fromTimeout=true;},this.clickTimeThresh);},startDrag:function(C,E){if(this.dragCurrent&&this.dragCurrent.useShim){this._shimState=this.useShim;this.useShim=true;}this._activateShim();clearTimeout(this.clickTimeout);var D=this.dragCurrent;if(D&&D.events.b4StartDrag){D.b4StartDrag(C,E);D.fireEvent("b4StartDragEvent",{x:C,y:E});}if(D&&D.events.startDrag){D.startDrag(C,E);D.fireEvent("startDragEvent",{x:C,y:E});}this.dragThreshMet=true;},handleMouseUp:function(C){if(this.dragCurrent){clearTimeout(this.clickTimeout);if(this.dragThreshMet){if(this.fromTimeout){this.fromTimeout=false;this.handleMouseMove(C);}this.fromTimeout=false;this.fireEvents(C,true);}else{}this.stopDrag(C);this.stopEvent(C);}},stopEvent:function(C){if(this.stopPropagation){YAHOO.util.Event.stopPropagation(C);}if(this.preventDefault){YAHOO.util.Event.preventDefault(C);}},stopDrag:function(E,D){var C=this.dragCurrent;if(C&&!D){if(this.dragThreshMet){if(C.events.b4EndDrag){C.b4EndDrag(E);C.fireEvent("b4EndDragEvent",{e:E});}if(C.events.endDrag){C.endDrag(E);C.fireEvent("endDragEvent",{e:E});}}if(C.events.mouseUp){C.onMouseUp(E);C.fireEvent("mouseUpEvent",{e:E});}}if(this._shimActive){this._deactivateShim();if(this.dragCurrent&&this.dragCurrent.useShim){this.useShim=this._shimState;this._shimState=false;}}this.dragCurrent=null;this.dragOvers={};},handleMouseMove:function(F){var C=this.dragCurrent;if(C){if(YAHOO.env.ua.ie&&(YAHOO.env.ua.ie<9)&&!F.button){this.stopEvent(F);return this.handleMouseUp(F);}else{if(F.clientX<0||F.clientY<0){}}if(!this.dragThreshMet){var E=Math.abs(this.startX-YAHOO.util.Event.getPageX(F));var D=Math.abs(this.startY-YAHOO.util.Event.getPageY(F));if(E>this.clickPixelThresh||D>this.clickPixelThresh){this.startDrag(this.startX,this.startY);}}if(this.dragThreshMet){if(C&&C.events.b4Drag){C.b4Drag(F);C.fireEvent("b4DragEvent",{e:F});}if(C&&C.events.drag){C.onDrag(F);C.fireEvent("dragEvent",{e:F});}if(C){this.fireEvents(F,false);}}this.stopEvent(F);}},fireEvents:function(W,M){var c=this.dragCurrent;if(!c||c.isLocked()||c.dragOnly){return;}var O=YAHOO.util.Event.getPageX(W),N=YAHOO.util.Event.getPageY(W),Q=new YAHOO.util.Point(O,N),K=c.getTargetCoord(Q.x,Q.y),F=c.getDragEl(),E=["out","over","drop","enter"],V=new YAHOO.util.Region(K.y,K.x+F.offsetWidth,K.y+F.offsetHeight,K.x),I=[],D={},L={},R=[],d={outEvts:[],overEvts:[],dropEvts:[],enterEvts:[]};for(var T in this.dragOvers){var f=this.dragOvers[T];if(!this.isTypeOfDD(f)){continue;
}if(!this.isOverTarget(Q,f,this.mode,V)){d.outEvts.push(f);}I[T]=true;delete this.dragOvers[T];}for(var S in c.groups){if("string"!=typeof S){continue;}for(T in this.ids[S]){var G=this.ids[S][T];if(!this.isTypeOfDD(G)){continue;}if(G.isTarget&&!G.isLocked()&&G!=c){if(this.isOverTarget(Q,G,this.mode,V)){D[S]=true;if(M){d.dropEvts.push(G);}else{if(!I[G.id]){d.enterEvts.push(G);}else{d.overEvts.push(G);}this.dragOvers[G.id]=G;}}}}}this.interactionInfo={out:d.outEvts,enter:d.enterEvts,over:d.overEvts,drop:d.dropEvts,point:Q,draggedRegion:V,sourceRegion:this.locationCache[c.id],validDrop:M};for(var C in D){R.push(C);}if(M&&!d.dropEvts.length){this.interactionInfo.validDrop=false;if(c.events.invalidDrop){c.onInvalidDrop(W);c.fireEvent("invalidDropEvent",{e:W});}}for(T=0;T<E.length;T++){var Z=null;if(d[E[T]+"Evts"]){Z=d[E[T]+"Evts"];}if(Z&&Z.length){var H=E[T].charAt(0).toUpperCase()+E[T].substr(1),Y="onDrag"+H,J="b4Drag"+H,P="drag"+H+"Event",X="drag"+H;if(this.mode){if(c.events[J]){c[J](W,Z,R);L[Y]=c.fireEvent(J+"Event",{event:W,info:Z,group:R});}if(c.events[X]&&(L[Y]!==false)){c[Y](W,Z,R);c.fireEvent(P,{event:W,info:Z,group:R});}}else{for(var a=0,U=Z.length;a<U;++a){if(c.events[J]){c[J](W,Z[a].id,R[0]);L[Y]=c.fireEvent(J+"Event",{event:W,info:Z[a].id,group:R[0]});}if(c.events[X]&&(L[Y]!==false)){c[Y](W,Z[a].id,R[0]);c.fireEvent(P,{event:W,info:Z[a].id,group:R[0]});}}}}}},getBestMatch:function(E){var G=null;var D=E.length;if(D==1){G=E[0];}else{for(var F=0;F<D;++F){var C=E[F];if(this.mode==this.INTERSECT&&C.cursorIsOver){G=C;break;}else{if(!G||!G.overlap||(C.overlap&&G.overlap.getArea()<C.overlap.getArea())){G=C;}}}}return G;},refreshCache:function(D){var F=D||this.ids;for(var C in F){if("string"!=typeof C){continue;}for(var E in this.ids[C]){var G=this.ids[C][E];if(this.isTypeOfDD(G)){var H=this.getLocation(G);if(H){this.locationCache[G.id]=H;}else{delete this.locationCache[G.id];}}}}},verifyEl:function(D){try{if(D){var C=D.offsetParent;if(C){return true;}}}catch(E){}return false;},getLocation:function(H){if(!this.isTypeOfDD(H)){return null;}var F=H.getEl(),K,E,D,M,L,N,C,J,G;try{K=YAHOO.util.Dom.getXY(F);}catch(I){}if(!K){return null;}E=K[0];D=E+F.offsetWidth;M=K[1];L=M+F.offsetHeight;N=M-H.padding[0];C=D+H.padding[1];J=L+H.padding[2];G=E-H.padding[3];return new YAHOO.util.Region(N,C,J,G);},isOverTarget:function(K,C,E,F){var G=this.locationCache[C.id];if(!G||!this.useCache){G=this.getLocation(C);this.locationCache[C.id]=G;}if(!G){return false;}C.cursorIsOver=G.contains(K);var J=this.dragCurrent;if(!J||(!E&&!J.constrainX&&!J.constrainY)){return C.cursorIsOver;}C.overlap=null;if(!F){var H=J.getTargetCoord(K.x,K.y);var D=J.getDragEl();F=new YAHOO.util.Region(H.y,H.x+D.offsetWidth,H.y+D.offsetHeight,H.x);}var I=F.intersect(G);if(I){C.overlap=I;return(E)?true:C.cursorIsOver;}else{return false;}},_onUnload:function(D,C){this.unregAll();},unregAll:function(){if(this.dragCurrent){this.stopDrag();this.dragCurrent=null;}this._execOnAll("unreg",[]);this.ids={};},elementCache:{},getElWrapper:function(D){var C=this.elementCache[D];if(!C||!C.el){C=this.elementCache[D]=new this.ElementWrapper(YAHOO.util.Dom.get(D));}return C;},getElement:function(C){return YAHOO.util.Dom.get(C);},getCss:function(D){var C=YAHOO.util.Dom.get(D);return(C)?C.style:null;},ElementWrapper:function(C){this.el=C||null;this.id=this.el&&C.id;this.css=this.el&&C.style;},getPosX:function(C){return YAHOO.util.Dom.getX(C);},getPosY:function(C){return YAHOO.util.Dom.getY(C);},swapNode:function(E,C){if(E.swapNode){E.swapNode(C);}else{var F=C.parentNode;var D=C.nextSibling;if(D==E){F.insertBefore(E,C);}else{if(C==E.nextSibling){F.insertBefore(C,E);}else{E.parentNode.replaceChild(C,E);F.insertBefore(E,D);}}}},getScroll:function(){var E,C,F=document.documentElement,D=document.body;if(F&&(F.scrollTop||F.scrollLeft)){E=F.scrollTop;C=F.scrollLeft;}else{if(D){E=D.scrollTop;C=D.scrollLeft;}else{}}return{top:E,left:C};},getStyle:function(D,C){return YAHOO.util.Dom.getStyle(D,C);},getScrollTop:function(){return this.getScroll().top;},getScrollLeft:function(){return this.getScroll().left;},moveToEl:function(C,E){var D=YAHOO.util.Dom.getXY(E);YAHOO.util.Dom.setXY(C,D);},getClientHeight:function(){return YAHOO.util.Dom.getViewportHeight();},getClientWidth:function(){return YAHOO.util.Dom.getViewportWidth();},numericSort:function(D,C){return(D-C);},_timeoutCount:0,_addListeners:function(){var C=YAHOO.util.DDM;if(YAHOO.util.Event&&document){C._onLoad();}else{if(C._timeoutCount>2000){}else{setTimeout(C._addListeners,10);if(document&&document.body){C._timeoutCount+=1;}}}},handleWasClicked:function(C,E){if(this.isHandle(E,C.id)){return true;}else{var D=C.parentNode;while(D){if(this.isHandle(E,D.id)){return true;}else{D=D.parentNode;}}}return false;}};}();YAHOO.util.DDM=YAHOO.util.DragDropMgr;YAHOO.util.DDM._addListeners();}(function(){var A=YAHOO.util.Event;var B=YAHOO.util.Dom;YAHOO.util.DragDrop=function(E,C,D){if(E){this.init(E,C,D);}};YAHOO.util.DragDrop.prototype={events:null,on:function(){this.subscribe.apply(this,arguments);},id:null,config:null,dragElId:null,handleElId:null,invalidHandleTypes:null,invalidHandleIds:null,invalidHandleClasses:null,startPageX:0,startPageY:0,groups:null,locked:false,lock:function(){this.locked=true;},unlock:function(){this.locked=false;},isTarget:true,padding:null,dragOnly:false,useShim:false,_domRef:null,__ygDragDrop:true,constrainX:false,constrainY:false,minX:0,maxX:0,minY:0,maxY:0,deltaX:0,deltaY:0,maintainOffset:false,xTicks:null,yTicks:null,primaryButtonOnly:true,available:false,hasOuterHandles:false,cursorIsOver:false,overlap:null,b4StartDrag:function(C,D){},startDrag:function(C,D){},b4Drag:function(C){},onDrag:function(C){},onDragEnter:function(C,D){},b4DragOver:function(C){},onDragOver:function(C,D){},b4DragOut:function(C){},onDragOut:function(C,D){},b4DragDrop:function(C){},onDragDrop:function(C,D){},onInvalidDrop:function(C){},b4EndDrag:function(C){},endDrag:function(C){},b4MouseDown:function(C){},onMouseDown:function(C){},onMouseUp:function(C){},onAvailable:function(){},getEl:function(){if(!this._domRef){this._domRef=B.get(this.id);
}return this._domRef;},getDragEl:function(){return B.get(this.dragElId);},init:function(F,C,D){this.initTarget(F,C,D);A.on(this._domRef||this.id,"mousedown",this.handleMouseDown,this,true);for(var E in this.events){this.createEvent(E+"Event");}},initTarget:function(E,C,D){this.config=D||{};this.events={};this.DDM=YAHOO.util.DDM;this.groups={};if(typeof E!=="string"){this._domRef=E;E=B.generateId(E);}this.id=E;this.addToGroup((C)?C:"default");this.handleElId=E;A.onAvailable(E,this.handleOnAvailable,this,true);this.setDragElId(E);this.invalidHandleTypes={A:"A"};this.invalidHandleIds={};this.invalidHandleClasses=[];this.applyConfig();},applyConfig:function(){this.events={mouseDown:true,b4MouseDown:true,mouseUp:true,b4StartDrag:true,startDrag:true,b4EndDrag:true,endDrag:true,drag:true,b4Drag:true,invalidDrop:true,b4DragOut:true,dragOut:true,dragEnter:true,b4DragOver:true,dragOver:true,b4DragDrop:true,dragDrop:true};if(this.config.events){for(var C in this.config.events){if(this.config.events[C]===false){this.events[C]=false;}}}this.padding=this.config.padding||[0,0,0,0];this.isTarget=(this.config.isTarget!==false);this.maintainOffset=(this.config.maintainOffset);this.primaryButtonOnly=(this.config.primaryButtonOnly!==false);this.dragOnly=((this.config.dragOnly===true)?true:false);this.useShim=((this.config.useShim===true)?true:false);},handleOnAvailable:function(){this.available=true;this.resetConstraints();this.onAvailable();},setPadding:function(E,C,F,D){if(!C&&0!==C){this.padding=[E,E,E,E];}else{if(!F&&0!==F){this.padding=[E,C,E,C];}else{this.padding=[E,C,F,D];}}},setInitPosition:function(F,E){var G=this.getEl();if(!this.DDM.verifyEl(G)){if(G&&G.style&&(G.style.display=="none")){}else{}return;}var D=F||0;var C=E||0;var H=B.getXY(G);this.initPageX=H[0]-D;this.initPageY=H[1]-C;this.lastPageX=H[0];this.lastPageY=H[1];this.setStartPosition(H);},setStartPosition:function(D){var C=D||B.getXY(this.getEl());this.deltaSetXY=null;this.startPageX=C[0];this.startPageY=C[1];},addToGroup:function(C){this.groups[C]=true;this.DDM.regDragDrop(this,C);},removeFromGroup:function(C){if(this.groups[C]){delete this.groups[C];}this.DDM.removeDDFromGroup(this,C);},setDragElId:function(C){this.dragElId=C;},setHandleElId:function(C){if(typeof C!=="string"){C=B.generateId(C);}this.handleElId=C;this.DDM.regHandle(this.id,C);},setOuterHandleElId:function(C){if(typeof C!=="string"){C=B.generateId(C);}A.on(C,"mousedown",this.handleMouseDown,this,true);this.setHandleElId(C);this.hasOuterHandles=true;},unreg:function(){A.removeListener(this.id,"mousedown",this.handleMouseDown);this._domRef=null;this.DDM._remove(this);},isLocked:function(){return(this.DDM.isLocked()||this.locked);},handleMouseDown:function(J,I){var D=J.which||J.button;if(this.primaryButtonOnly&&D>1){return;}if(this.isLocked()){return;}var C=this.b4MouseDown(J),F=true;if(this.events.b4MouseDown){F=this.fireEvent("b4MouseDownEvent",J);}var E=this.onMouseDown(J),H=true;if(this.events.mouseDown){if(E===false){H=false;}else{H=this.fireEvent("mouseDownEvent",J);}}if((C===false)||(E===false)||(F===false)||(H===false)){return;}this.DDM.refreshCache(this.groups);var G=new YAHOO.util.Point(A.getPageX(J),A.getPageY(J));if(!this.hasOuterHandles&&!this.DDM.isOverTarget(G,this)){}else{if(this.clickValidator(J)){this.setStartPosition();this.DDM.handleMouseDown(J,this);this.DDM.stopEvent(J);}else{}}},clickValidator:function(D){var C=YAHOO.util.Event.getTarget(D);return(this.isValidHandleChild(C)&&(this.id==this.handleElId||this.DDM.handleWasClicked(C,this.id)));},getTargetCoord:function(E,D){var C=E-this.deltaX;var F=D-this.deltaY;if(this.constrainX){if(C<this.minX){C=this.minX;}if(C>this.maxX){C=this.maxX;}}if(this.constrainY){if(F<this.minY){F=this.minY;}if(F>this.maxY){F=this.maxY;}}C=this.getTick(C,this.xTicks);F=this.getTick(F,this.yTicks);return{x:C,y:F};},addInvalidHandleType:function(C){var D=C.toUpperCase();this.invalidHandleTypes[D]=D;},addInvalidHandleId:function(C){if(typeof C!=="string"){C=B.generateId(C);}this.invalidHandleIds[C]=C;},addInvalidHandleClass:function(C){this.invalidHandleClasses.push(C);},removeInvalidHandleType:function(C){var D=C.toUpperCase();delete this.invalidHandleTypes[D];},removeInvalidHandleId:function(C){if(typeof C!=="string"){C=B.generateId(C);}delete this.invalidHandleIds[C];},removeInvalidHandleClass:function(D){for(var E=0,C=this.invalidHandleClasses.length;E<C;++E){if(this.invalidHandleClasses[E]==D){delete this.invalidHandleClasses[E];}}},isValidHandleChild:function(F){var E=true;var H;try{H=F.nodeName.toUpperCase();}catch(G){H=F.nodeName;}E=E&&!this.invalidHandleTypes[H];E=E&&!this.invalidHandleIds[F.id];for(var D=0,C=this.invalidHandleClasses.length;E&&D<C;++D){E=!B.hasClass(F,this.invalidHandleClasses[D]);}return E;},setXTicks:function(F,C){this.xTicks=[];this.xTickSize=C;var E={};for(var D=this.initPageX;D>=this.minX;D=D-C){if(!E[D]){this.xTicks[this.xTicks.length]=D;E[D]=true;}}for(D=this.initPageX;D<=this.maxX;D=D+C){if(!E[D]){this.xTicks[this.xTicks.length]=D;E[D]=true;}}this.xTicks.sort(this.DDM.numericSort);},setYTicks:function(F,C){this.yTicks=[];this.yTickSize=C;var E={};for(var D=this.initPageY;D>=this.minY;D=D-C){if(!E[D]){this.yTicks[this.yTicks.length]=D;E[D]=true;}}for(D=this.initPageY;D<=this.maxY;D=D+C){if(!E[D]){this.yTicks[this.yTicks.length]=D;E[D]=true;}}this.yTicks.sort(this.DDM.numericSort);},setXConstraint:function(E,D,C){this.leftConstraint=parseInt(E,10);this.rightConstraint=parseInt(D,10);this.minX=this.initPageX-this.leftConstraint;this.maxX=this.initPageX+this.rightConstraint;if(C){this.setXTicks(this.initPageX,C);}this.constrainX=true;},clearConstraints:function(){this.constrainX=false;this.constrainY=false;this.clearTicks();},clearTicks:function(){this.xTicks=null;this.yTicks=null;this.xTickSize=0;this.yTickSize=0;},setYConstraint:function(C,E,D){this.topConstraint=parseInt(C,10);this.bottomConstraint=parseInt(E,10);this.minY=this.initPageY-this.topConstraint;this.maxY=this.initPageY+this.bottomConstraint;
if(D){this.setYTicks(this.initPageY,D);}this.constrainY=true;},resetConstraints:function(){if(this.initPageX||this.initPageX===0){var D=(this.maintainOffset)?this.lastPageX-this.initPageX:0;var C=(this.maintainOffset)?this.lastPageY-this.initPageY:0;this.setInitPosition(D,C);}else{this.setInitPosition();}if(this.constrainX){this.setXConstraint(this.leftConstraint,this.rightConstraint,this.xTickSize);}if(this.constrainY){this.setYConstraint(this.topConstraint,this.bottomConstraint,this.yTickSize);}},getTick:function(I,F){if(!F){return I;}else{if(F[0]>=I){return F[0];}else{for(var D=0,C=F.length;D<C;++D){var E=D+1;if(F[E]&&F[E]>=I){var H=I-F[D];var G=F[E]-I;return(G>H)?F[D]:F[E];}}return F[F.length-1];}}},toString:function(){return("DragDrop "+this.id);}};YAHOO.augment(YAHOO.util.DragDrop,YAHOO.util.EventProvider);})();YAHOO.util.DD=function(C,A,B){if(C){this.init(C,A,B);}};YAHOO.extend(YAHOO.util.DD,YAHOO.util.DragDrop,{scroll:true,autoOffset:function(C,B){var A=C-this.startPageX;var D=B-this.startPageY;this.setDelta(A,D);},setDelta:function(B,A){this.deltaX=B;this.deltaY=A;},setDragElPos:function(C,B){var A=this.getDragEl();this.alignElWithMouse(A,C,B);},alignElWithMouse:function(C,G,F){var E=this.getTargetCoord(G,F);if(!this.deltaSetXY){var H=[E.x,E.y];YAHOO.util.Dom.setXY(C,H);var D=parseInt(YAHOO.util.Dom.getStyle(C,"left"),10);var B=parseInt(YAHOO.util.Dom.getStyle(C,"top"),10);this.deltaSetXY=[D-E.x,B-E.y];}else{YAHOO.util.Dom.setStyle(C,"left",(E.x+this.deltaSetXY[0])+"px");YAHOO.util.Dom.setStyle(C,"top",(E.y+this.deltaSetXY[1])+"px");}this.cachePosition(E.x,E.y);var A=this;setTimeout(function(){A.autoScroll.call(A,E.x,E.y,C.offsetHeight,C.offsetWidth);},0);},cachePosition:function(B,A){if(B){this.lastPageX=B;this.lastPageY=A;}else{var C=YAHOO.util.Dom.getXY(this.getEl());this.lastPageX=C[0];this.lastPageY=C[1];}},autoScroll:function(J,I,E,K){if(this.scroll){var L=this.DDM.getClientHeight();var B=this.DDM.getClientWidth();var N=this.DDM.getScrollTop();var D=this.DDM.getScrollLeft();var H=E+I;var M=K+J;var G=(L+N-I-this.deltaY);var F=(B+D-J-this.deltaX);var C=40;var A=(document.all)?80:30;if(H>L&&G<C){window.scrollTo(D,N+A);}if(I<N&&N>0&&I-N<C){window.scrollTo(D,N-A);}if(M>B&&F<C){window.scrollTo(D+A,N);}if(J<D&&D>0&&J-D<C){window.scrollTo(D-A,N);}}},applyConfig:function(){YAHOO.util.DD.superclass.applyConfig.call(this);this.scroll=(this.config.scroll!==false);},b4MouseDown:function(A){this.setStartPosition();this.autoOffset(YAHOO.util.Event.getPageX(A),YAHOO.util.Event.getPageY(A));},b4Drag:function(A){this.setDragElPos(YAHOO.util.Event.getPageX(A),YAHOO.util.Event.getPageY(A));},toString:function(){return("DD "+this.id);}});YAHOO.util.DDProxy=function(C,A,B){if(C){this.init(C,A,B);this.initFrame();}};YAHOO.util.DDProxy.dragElId="ygddfdiv";YAHOO.extend(YAHOO.util.DDProxy,YAHOO.util.DD,{resizeFrame:true,centerFrame:false,createFrame:function(){var B=this,A=document.body;if(!A||!A.firstChild){setTimeout(function(){B.createFrame();},50);return;}var F=this.getDragEl(),E=YAHOO.util.Dom;if(!F){F=document.createElement("div");F.id=this.dragElId;var D=F.style;D.position="absolute";D.visibility="hidden";D.cursor="move";D.border="2px solid #aaa";D.zIndex=999;D.height="25px";D.width="25px";var C=document.createElement("div");E.setStyle(C,"height","100%");E.setStyle(C,"width","100%");E.setStyle(C,"background-color","#ccc");E.setStyle(C,"opacity","0");F.appendChild(C);A.insertBefore(F,A.firstChild);}},initFrame:function(){this.createFrame();},applyConfig:function(){YAHOO.util.DDProxy.superclass.applyConfig.call(this);this.resizeFrame=(this.config.resizeFrame!==false);this.centerFrame=(this.config.centerFrame);this.setDragElId(this.config.dragElId||YAHOO.util.DDProxy.dragElId);},showFrame:function(E,D){var C=this.getEl();var A=this.getDragEl();var B=A.style;this._resizeProxy();if(this.centerFrame){this.setDelta(Math.round(parseInt(B.width,10)/2),Math.round(parseInt(B.height,10)/2));}this.setDragElPos(E,D);YAHOO.util.Dom.setStyle(A,"visibility","visible");},_resizeProxy:function(){if(this.resizeFrame){var H=YAHOO.util.Dom;var B=this.getEl();var C=this.getDragEl();var G=parseInt(H.getStyle(C,"borderTopWidth"),10);var I=parseInt(H.getStyle(C,"borderRightWidth"),10);var F=parseInt(H.getStyle(C,"borderBottomWidth"),10);var D=parseInt(H.getStyle(C,"borderLeftWidth"),10);if(isNaN(G)){G=0;}if(isNaN(I)){I=0;}if(isNaN(F)){F=0;}if(isNaN(D)){D=0;}var E=Math.max(0,B.offsetWidth-I-D);var A=Math.max(0,B.offsetHeight-G-F);H.setStyle(C,"width",E+"px");H.setStyle(C,"height",A+"px");}},b4MouseDown:function(B){this.setStartPosition();var A=YAHOO.util.Event.getPageX(B);var C=YAHOO.util.Event.getPageY(B);this.autoOffset(A,C);},b4StartDrag:function(A,B){this.showFrame(A,B);},b4EndDrag:function(A){YAHOO.util.Dom.setStyle(this.getDragEl(),"visibility","hidden");},endDrag:function(D){var C=YAHOO.util.Dom;var B=this.getEl();var A=this.getDragEl();C.setStyle(A,"visibility","");C.setStyle(B,"visibility","hidden");YAHOO.util.DDM.moveToEl(B,A);C.setStyle(A,"visibility","hidden");C.setStyle(B,"visibility","");},toString:function(){return("DDProxy "+this.id);}});YAHOO.util.DDTarget=function(C,A,B){if(C){this.initTarget(C,A,B);}};YAHOO.extend(YAHOO.util.DDTarget,YAHOO.util.DragDrop,{toString:function(){return("DDTarget "+this.id);}});YAHOO.register("dragdrop",YAHOO.util.DragDropMgr,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/dragdrop/dragdrop-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
(function(){YAHOO.util.Config=function(d){if(d){this.init(d);}};var b=YAHOO.lang,c=YAHOO.util.CustomEvent,a=YAHOO.util.Config;a.CONFIG_CHANGED_EVENT="configChanged";a.BOOLEAN_TYPE="boolean";a.prototype={owner:null,queueInProgress:false,config:null,initialConfig:null,eventQueue:null,configChangedEvent:null,init:function(d){this.owner=d;this.configChangedEvent=this.createEvent(a.CONFIG_CHANGED_EVENT);this.configChangedEvent.signature=c.LIST;this.queueInProgress=false;this.config={};this.initialConfig={};this.eventQueue=[];},checkBoolean:function(d){return(typeof d==a.BOOLEAN_TYPE);},checkNumber:function(d){return(!isNaN(d));},fireEvent:function(d,f){var e=this.config[d];if(e&&e.event){e.event.fire(f);}},addProperty:function(e,d){e=e.toLowerCase();this.config[e]=d;d.event=this.createEvent(e,{scope:this.owner});d.event.signature=c.LIST;d.key=e;if(d.handler){d.event.subscribe(d.handler,this.owner);}this.setProperty(e,d.value,true);if(!d.suppressEvent){this.queueProperty(e,d.value);}},getConfig:function(){var d={},f=this.config,g,e;for(g in f){if(b.hasOwnProperty(f,g)){e=f[g];if(e&&e.event){d[g]=e.value;}}}return d;},getProperty:function(d){var e=this.config[d.toLowerCase()];if(e&&e.event){return e.value;}else{return undefined;}},resetProperty:function(d){d=d.toLowerCase();var e=this.config[d];if(e&&e.event){if(d in this.initialConfig){this.setProperty(d,this.initialConfig[d]);return true;}}else{return false;}},setProperty:function(e,g,d){var f;e=e.toLowerCase();if(this.queueInProgress&&!d){this.queueProperty(e,g);return true;}else{f=this.config[e];if(f&&f.event){if(f.validator&&!f.validator(g)){return false;}else{f.value=g;if(!d){this.fireEvent(e,g);this.configChangedEvent.fire([e,g]);}return true;}}else{return false;}}},queueProperty:function(v,r){v=v.toLowerCase();var u=this.config[v],l=false,k,g,h,j,p,t,f,n,o,d,m,w,e;if(u&&u.event){if(!b.isUndefined(r)&&u.validator&&!u.validator(r)){return false;}else{if(!b.isUndefined(r)){u.value=r;}else{r=u.value;}l=false;k=this.eventQueue.length;for(m=0;m<k;m++){g=this.eventQueue[m];if(g){h=g[0];j=g[1];if(h==v){this.eventQueue[m]=null;this.eventQueue.push([v,(!b.isUndefined(r)?r:j)]);l=true;break;}}}if(!l&&!b.isUndefined(r)){this.eventQueue.push([v,r]);}}if(u.supercedes){p=u.supercedes.length;for(w=0;w<p;w++){t=u.supercedes[w];f=this.eventQueue.length;for(e=0;e<f;e++){n=this.eventQueue[e];if(n){o=n[0];d=n[1];if(o==t.toLowerCase()){this.eventQueue.push([o,d]);this.eventQueue[e]=null;break;}}}}}return true;}else{return false;}},refireEvent:function(d){d=d.toLowerCase();var e=this.config[d];if(e&&e.event&&!b.isUndefined(e.value)){if(this.queueInProgress){this.queueProperty(d);}else{this.fireEvent(d,e.value);}}},applyConfig:function(d,g){var f,e;if(g){e={};for(f in d){if(b.hasOwnProperty(d,f)){e[f.toLowerCase()]=d[f];}}this.initialConfig=e;}for(f in d){if(b.hasOwnProperty(d,f)){this.queueProperty(f,d[f]);}}},refresh:function(){var d;for(d in this.config){if(b.hasOwnProperty(this.config,d)){this.refireEvent(d);}}},fireQueue:function(){var e,h,d,g,f;this.queueInProgress=true;for(e=0;e<this.eventQueue.length;e++){h=this.eventQueue[e];if(h){d=h[0];g=h[1];f=this.config[d];f.value=g;this.eventQueue[e]=null;this.fireEvent(d,g);}}this.queueInProgress=false;this.eventQueue=[];},subscribeToConfigEvent:function(d,e,g,h){var f=this.config[d.toLowerCase()];if(f&&f.event){if(!a.alreadySubscribed(f.event,e,g)){f.event.subscribe(e,g,h);}return true;}else{return false;}},unsubscribeFromConfigEvent:function(d,e,g){var f=this.config[d.toLowerCase()];if(f&&f.event){return f.event.unsubscribe(e,g);}else{return false;}},toString:function(){var d="Config";if(this.owner){d+=" ["+this.owner.toString()+"]";}return d;},outputEventQueue:function(){var d="",g,e,f=this.eventQueue.length;for(e=0;e<f;e++){g=this.eventQueue[e];if(g){d+=g[0]+"="+g[1]+", ";}}return d;},destroy:function(){var e=this.config,d,f;for(d in e){if(b.hasOwnProperty(e,d)){f=e[d];f.event.unsubscribeAll();f.event=null;}}this.configChangedEvent.unsubscribeAll();this.configChangedEvent=null;this.owner=null;this.config=null;this.initialConfig=null;this.eventQueue=null;}};a.alreadySubscribed=function(e,h,j){var f=e.subscribers.length,d,g;if(f>0){g=f-1;do{d=e.subscribers[g];if(d&&d.obj==j&&d.fn==h){return true;}}while(g--);}return false;};YAHOO.lang.augmentProto(a,YAHOO.util.EventProvider);}());(function(){YAHOO.widget.Module=function(r,q){if(r){this.init(r,q);}else{}};var f=YAHOO.util.Dom,d=YAHOO.util.Config,n=YAHOO.util.Event,m=YAHOO.util.CustomEvent,g=YAHOO.widget.Module,i=YAHOO.env.ua,h,p,o,e,a={"BEFORE_INIT":"beforeInit","INIT":"init","APPEND":"append","BEFORE_RENDER":"beforeRender","RENDER":"render","CHANGE_HEADER":"changeHeader","CHANGE_BODY":"changeBody","CHANGE_FOOTER":"changeFooter","CHANGE_CONTENT":"changeContent","DESTROY":"destroy","BEFORE_SHOW":"beforeShow","SHOW":"show","BEFORE_HIDE":"beforeHide","HIDE":"hide"},j={"VISIBLE":{key:"visible",value:true,validator:YAHOO.lang.isBoolean},"EFFECT":{key:"effect",suppressEvent:true,supercedes:["visible"]},"MONITOR_RESIZE":{key:"monitorresize",value:true},"APPEND_TO_DOCUMENT_BODY":{key:"appendtodocumentbody",value:false}};g.IMG_ROOT=null;g.IMG_ROOT_SSL=null;g.CSS_MODULE="yui-module";g.CSS_HEADER="hd";g.CSS_BODY="bd";g.CSS_FOOTER="ft";g.RESIZE_MONITOR_SECURE_URL="javascript:false;";g.RESIZE_MONITOR_BUFFER=1;g.textResizeEvent=new m("textResize");g.forceDocumentRedraw=function(){var q=document.documentElement;if(q){q.className+=" ";q.className=YAHOO.lang.trim(q.className);}};function l(){if(!h){h=document.createElement("div");h.innerHTML=('<div class="'+g.CSS_HEADER+'"></div>'+'<div class="'+g.CSS_BODY+'"></div><div class="'+g.CSS_FOOTER+'"></div>');p=h.firstChild;o=p.nextSibling;e=o.nextSibling;}return h;}function k(){if(!p){l();}return(p.cloneNode(false));}function b(){if(!o){l();}return(o.cloneNode(false));}function c(){if(!e){l();}return(e.cloneNode(false));}g.prototype={constructor:g,element:null,header:null,body:null,footer:null,id:null,imageRoot:g.IMG_ROOT,initEvents:function(){var q=m.LIST;
this.beforeInitEvent=this.createEvent(a.BEFORE_INIT);this.beforeInitEvent.signature=q;this.initEvent=this.createEvent(a.INIT);this.initEvent.signature=q;this.appendEvent=this.createEvent(a.APPEND);this.appendEvent.signature=q;this.beforeRenderEvent=this.createEvent(a.BEFORE_RENDER);this.beforeRenderEvent.signature=q;this.renderEvent=this.createEvent(a.RENDER);this.renderEvent.signature=q;this.changeHeaderEvent=this.createEvent(a.CHANGE_HEADER);this.changeHeaderEvent.signature=q;this.changeBodyEvent=this.createEvent(a.CHANGE_BODY);this.changeBodyEvent.signature=q;this.changeFooterEvent=this.createEvent(a.CHANGE_FOOTER);this.changeFooterEvent.signature=q;this.changeContentEvent=this.createEvent(a.CHANGE_CONTENT);this.changeContentEvent.signature=q;this.destroyEvent=this.createEvent(a.DESTROY);this.destroyEvent.signature=q;this.beforeShowEvent=this.createEvent(a.BEFORE_SHOW);this.beforeShowEvent.signature=q;this.showEvent=this.createEvent(a.SHOW);this.showEvent.signature=q;this.beforeHideEvent=this.createEvent(a.BEFORE_HIDE);this.beforeHideEvent.signature=q;this.hideEvent=this.createEvent(a.HIDE);this.hideEvent.signature=q;},platform:function(){var q=navigator.userAgent.toLowerCase();if(q.indexOf("windows")!=-1||q.indexOf("win32")!=-1){return"windows";}else{if(q.indexOf("macintosh")!=-1){return"mac";}else{return false;}}}(),browser:function(){var q=navigator.userAgent.toLowerCase();if(q.indexOf("opera")!=-1){return"opera";}else{if(q.indexOf("msie 7")!=-1){return"ie7";}else{if(q.indexOf("msie")!=-1){return"ie";}else{if(q.indexOf("safari")!=-1){return"safari";}else{if(q.indexOf("gecko")!=-1){return"gecko";}else{return false;}}}}}}(),isSecure:function(){if(window.location.href.toLowerCase().indexOf("https")===0){return true;}else{return false;}}(),initDefaultConfig:function(){this.cfg.addProperty(j.VISIBLE.key,{handler:this.configVisible,value:j.VISIBLE.value,validator:j.VISIBLE.validator});this.cfg.addProperty(j.EFFECT.key,{handler:this.configEffect,suppressEvent:j.EFFECT.suppressEvent,supercedes:j.EFFECT.supercedes});this.cfg.addProperty(j.MONITOR_RESIZE.key,{handler:this.configMonitorResize,value:j.MONITOR_RESIZE.value});this.cfg.addProperty(j.APPEND_TO_DOCUMENT_BODY.key,{value:j.APPEND_TO_DOCUMENT_BODY.value});},init:function(v,u){var s,w;this.initEvents();this.beforeInitEvent.fire(g);this.cfg=new d(this);if(this.isSecure){this.imageRoot=g.IMG_ROOT_SSL;}if(typeof v=="string"){s=v;v=document.getElementById(v);if(!v){v=(l()).cloneNode(false);v.id=s;}}this.id=f.generateId(v);this.element=v;w=this.element.firstChild;if(w){var r=false,q=false,t=false;do{if(1==w.nodeType){if(!r&&f.hasClass(w,g.CSS_HEADER)){this.header=w;r=true;}else{if(!q&&f.hasClass(w,g.CSS_BODY)){this.body=w;q=true;}else{if(!t&&f.hasClass(w,g.CSS_FOOTER)){this.footer=w;t=true;}}}}}while((w=w.nextSibling));}this.initDefaultConfig();f.addClass(this.element,g.CSS_MODULE);if(u){this.cfg.applyConfig(u,true);}if(!d.alreadySubscribed(this.renderEvent,this.cfg.fireQueue,this.cfg)){this.renderEvent.subscribe(this.cfg.fireQueue,this.cfg,true);}this.initEvent.fire(g);},initResizeMonitor:function(){var r=(i.gecko&&this.platform=="windows");if(r){var q=this;setTimeout(function(){q._initResizeMonitor();},0);}else{this._initResizeMonitor();}},_initResizeMonitor:function(){var q,s,u;function w(){g.textResizeEvent.fire();}if(!i.opera){s=f.get("_yuiResizeMonitor");var v=this._supportsCWResize();if(!s){s=document.createElement("iframe");if(this.isSecure&&g.RESIZE_MONITOR_SECURE_URL&&i.ie){s.src=g.RESIZE_MONITOR_SECURE_URL;}if(!v){u=["<html><head><script ",'type="text/javascript">',"window.onresize=function(){window.parent.","YAHOO.widget.Module.textResizeEvent.","fire();};<","/script></head>","<body></body></html>"].join("");s.src="data:text/html;charset=utf-8,"+encodeURIComponent(u);}s.id="_yuiResizeMonitor";s.title="Text Resize Monitor";s.tabIndex=-1;s.setAttribute("role","presentation");s.style.position="absolute";s.style.visibility="hidden";var r=document.body,t=r.firstChild;if(t){r.insertBefore(s,t);}else{r.appendChild(s);}s.style.backgroundColor="transparent";s.style.borderWidth="0";s.style.width="2em";s.style.height="2em";s.style.left="0";s.style.top=(-1*(s.offsetHeight+g.RESIZE_MONITOR_BUFFER))+"px";s.style.visibility="visible";if(i.webkit){q=s.contentWindow.document;q.open();q.close();}}if(s&&s.contentWindow){g.textResizeEvent.subscribe(this.onDomResize,this,true);if(!g.textResizeInitialized){if(v){if(!n.on(s.contentWindow,"resize",w)){n.on(s,"resize",w);}}g.textResizeInitialized=true;}this.resizeMonitor=s;}}},_supportsCWResize:function(){var q=true;if(i.gecko&&i.gecko<=1.8){q=false;}return q;},onDomResize:function(s,r){var q=-1*(this.resizeMonitor.offsetHeight+g.RESIZE_MONITOR_BUFFER);this.resizeMonitor.style.top=q+"px";this.resizeMonitor.style.left="0";},setHeader:function(r){var q=this.header||(this.header=k());if(r.nodeName){q.innerHTML="";q.appendChild(r);}else{q.innerHTML=r;}if(this._rendered){this._renderHeader();}this.changeHeaderEvent.fire(r);this.changeContentEvent.fire();},appendToHeader:function(r){var q=this.header||(this.header=k());q.appendChild(r);this.changeHeaderEvent.fire(r);this.changeContentEvent.fire();},setBody:function(r){var q=this.body||(this.body=b());if(r.nodeName){q.innerHTML="";q.appendChild(r);}else{q.innerHTML=r;}if(this._rendered){this._renderBody();}this.changeBodyEvent.fire(r);this.changeContentEvent.fire();},appendToBody:function(r){var q=this.body||(this.body=b());q.appendChild(r);this.changeBodyEvent.fire(r);this.changeContentEvent.fire();},setFooter:function(r){var q=this.footer||(this.footer=c());if(r.nodeName){q.innerHTML="";q.appendChild(r);}else{q.innerHTML=r;}if(this._rendered){this._renderFooter();}this.changeFooterEvent.fire(r);this.changeContentEvent.fire();},appendToFooter:function(r){var q=this.footer||(this.footer=c());q.appendChild(r);this.changeFooterEvent.fire(r);this.changeContentEvent.fire();},render:function(s,q){var t=this;function r(u){if(typeof u=="string"){u=document.getElementById(u);
}if(u){t._addToParent(u,t.element);t.appendEvent.fire();}}this.beforeRenderEvent.fire();if(!q){q=this.element;}if(s){r(s);}else{if(!f.inDocument(this.element)){return false;}}this._renderHeader(q);this._renderBody(q);this._renderFooter(q);this._rendered=true;this.renderEvent.fire();return true;},_renderHeader:function(q){q=q||this.element;if(this.header&&!f.inDocument(this.header)){var r=q.firstChild;if(r){q.insertBefore(this.header,r);}else{q.appendChild(this.header);}}},_renderBody:function(q){q=q||this.element;if(this.body&&!f.inDocument(this.body)){if(this.footer&&f.isAncestor(q,this.footer)){q.insertBefore(this.body,this.footer);}else{q.appendChild(this.body);}}},_renderFooter:function(q){q=q||this.element;if(this.footer&&!f.inDocument(this.footer)){q.appendChild(this.footer);}},destroy:function(q){var r,s=!(q);if(this.element){n.purgeElement(this.element,s);r=this.element.parentNode;}if(r){r.removeChild(this.element);}this.element=null;this.header=null;this.body=null;this.footer=null;g.textResizeEvent.unsubscribe(this.onDomResize,this);this.cfg.destroy();this.cfg=null;this.destroyEvent.fire();},show:function(){this.cfg.setProperty("visible",true);},hide:function(){this.cfg.setProperty("visible",false);},configVisible:function(r,q,s){var t=q[0];if(t){if(this.beforeShowEvent.fire()){f.setStyle(this.element,"display","block");this.showEvent.fire();}}else{if(this.beforeHideEvent.fire()){f.setStyle(this.element,"display","none");this.hideEvent.fire();}}},configEffect:function(r,q,s){this._cachedEffects=(this.cacheEffects)?this._createEffects(q[0]):null;},cacheEffects:true,_createEffects:function(t){var q=null,u,r,s;if(t){if(t instanceof Array){q=[];u=t.length;for(r=0;r<u;r++){s=t[r];if(s.effect){q[q.length]=s.effect(this,s.duration);}}}else{if(t.effect){q=[t.effect(this,t.duration)];}}}return q;},configMonitorResize:function(s,r,t){var q=r[0];if(q){this.initResizeMonitor();}else{g.textResizeEvent.unsubscribe(this.onDomResize,this,true);this.resizeMonitor=null;}},_addToParent:function(q,r){if(!this.cfg.getProperty("appendtodocumentbody")&&q===document.body&&q.firstChild){q.insertBefore(r,q.firstChild);}else{q.appendChild(r);}},toString:function(){return"Module "+this.id;}};YAHOO.lang.augmentProto(g,YAHOO.util.EventProvider);}());(function(){YAHOO.widget.Overlay=function(p,o){YAHOO.widget.Overlay.superclass.constructor.call(this,p,o);};var i=YAHOO.lang,m=YAHOO.util.CustomEvent,g=YAHOO.widget.Module,n=YAHOO.util.Event,f=YAHOO.util.Dom,d=YAHOO.util.Config,k=YAHOO.env.ua,b=YAHOO.widget.Overlay,h="subscribe",e="unsubscribe",c="contained",j,a={"BEFORE_MOVE":"beforeMove","MOVE":"move"},l={"X":{key:"x",validator:i.isNumber,suppressEvent:true,supercedes:["iframe"]},"Y":{key:"y",validator:i.isNumber,suppressEvent:true,supercedes:["iframe"]},"XY":{key:"xy",suppressEvent:true,supercedes:["iframe"]},"CONTEXT":{key:"context",suppressEvent:true,supercedes:["iframe"]},"FIXED_CENTER":{key:"fixedcenter",value:false,supercedes:["iframe","visible"]},"WIDTH":{key:"width",suppressEvent:true,supercedes:["context","fixedcenter","iframe"]},"HEIGHT":{key:"height",suppressEvent:true,supercedes:["context","fixedcenter","iframe"]},"AUTO_FILL_HEIGHT":{key:"autofillheight",supercedes:["height"],value:"body"},"ZINDEX":{key:"zindex",value:null},"CONSTRAIN_TO_VIEWPORT":{key:"constraintoviewport",value:false,validator:i.isBoolean,supercedes:["iframe","x","y","xy"]},"IFRAME":{key:"iframe",value:(k.ie==6?true:false),validator:i.isBoolean,supercedes:["zindex"]},"PREVENT_CONTEXT_OVERLAP":{key:"preventcontextoverlap",value:false,validator:i.isBoolean,supercedes:["constraintoviewport"]}};b.IFRAME_SRC="javascript:false;";b.IFRAME_OFFSET=3;b.VIEWPORT_OFFSET=10;b.TOP_LEFT="tl";b.TOP_RIGHT="tr";b.BOTTOM_LEFT="bl";b.BOTTOM_RIGHT="br";b.PREVENT_OVERLAP_X={"tltr":true,"blbr":true,"brbl":true,"trtl":true};b.PREVENT_OVERLAP_Y={"trbr":true,"tlbl":true,"bltl":true,"brtr":true};b.CSS_OVERLAY="yui-overlay";b.CSS_HIDDEN="yui-overlay-hidden";b.CSS_IFRAME="yui-overlay-iframe";b.STD_MOD_RE=/^\s*?(body|footer|header)\s*?$/i;b.windowScrollEvent=new m("windowScroll");b.windowResizeEvent=new m("windowResize");b.windowScrollHandler=function(p){var o=n.getTarget(p);if(!o||o===window||o===window.document){if(k.ie){if(!window.scrollEnd){window.scrollEnd=-1;}clearTimeout(window.scrollEnd);window.scrollEnd=setTimeout(function(){b.windowScrollEvent.fire();},1);}else{b.windowScrollEvent.fire();}}};b.windowResizeHandler=function(o){if(k.ie){if(!window.resizeEnd){window.resizeEnd=-1;}clearTimeout(window.resizeEnd);window.resizeEnd=setTimeout(function(){b.windowResizeEvent.fire();},100);}else{b.windowResizeEvent.fire();}};b._initialized=null;if(b._initialized===null){n.on(window,"scroll",b.windowScrollHandler);n.on(window,"resize",b.windowResizeHandler);b._initialized=true;}b._TRIGGER_MAP={"windowScroll":b.windowScrollEvent,"windowResize":b.windowResizeEvent,"textResize":g.textResizeEvent};YAHOO.extend(b,g,{CONTEXT_TRIGGERS:[],init:function(p,o){b.superclass.init.call(this,p);this.beforeInitEvent.fire(b);f.addClass(this.element,b.CSS_OVERLAY);if(o){this.cfg.applyConfig(o,true);}if(this.platform=="mac"&&k.gecko){if(!d.alreadySubscribed(this.showEvent,this.showMacGeckoScrollbars,this)){this.showEvent.subscribe(this.showMacGeckoScrollbars,this,true);}if(!d.alreadySubscribed(this.hideEvent,this.hideMacGeckoScrollbars,this)){this.hideEvent.subscribe(this.hideMacGeckoScrollbars,this,true);}}this.initEvent.fire(b);},initEvents:function(){b.superclass.initEvents.call(this);var o=m.LIST;this.beforeMoveEvent=this.createEvent(a.BEFORE_MOVE);this.beforeMoveEvent.signature=o;this.moveEvent=this.createEvent(a.MOVE);this.moveEvent.signature=o;},initDefaultConfig:function(){b.superclass.initDefaultConfig.call(this);var o=this.cfg;o.addProperty(l.X.key,{handler:this.configX,validator:l.X.validator,suppressEvent:l.X.suppressEvent,supercedes:l.X.supercedes});o.addProperty(l.Y.key,{handler:this.configY,validator:l.Y.validator,suppressEvent:l.Y.suppressEvent,supercedes:l.Y.supercedes});
o.addProperty(l.XY.key,{handler:this.configXY,suppressEvent:l.XY.suppressEvent,supercedes:l.XY.supercedes});o.addProperty(l.CONTEXT.key,{handler:this.configContext,suppressEvent:l.CONTEXT.suppressEvent,supercedes:l.CONTEXT.supercedes});o.addProperty(l.FIXED_CENTER.key,{handler:this.configFixedCenter,value:l.FIXED_CENTER.value,validator:l.FIXED_CENTER.validator,supercedes:l.FIXED_CENTER.supercedes});o.addProperty(l.WIDTH.key,{handler:this.configWidth,suppressEvent:l.WIDTH.suppressEvent,supercedes:l.WIDTH.supercedes});o.addProperty(l.HEIGHT.key,{handler:this.configHeight,suppressEvent:l.HEIGHT.suppressEvent,supercedes:l.HEIGHT.supercedes});o.addProperty(l.AUTO_FILL_HEIGHT.key,{handler:this.configAutoFillHeight,value:l.AUTO_FILL_HEIGHT.value,validator:this._validateAutoFill,supercedes:l.AUTO_FILL_HEIGHT.supercedes});o.addProperty(l.ZINDEX.key,{handler:this.configzIndex,value:l.ZINDEX.value});o.addProperty(l.CONSTRAIN_TO_VIEWPORT.key,{handler:this.configConstrainToViewport,value:l.CONSTRAIN_TO_VIEWPORT.value,validator:l.CONSTRAIN_TO_VIEWPORT.validator,supercedes:l.CONSTRAIN_TO_VIEWPORT.supercedes});o.addProperty(l.IFRAME.key,{handler:this.configIframe,value:l.IFRAME.value,validator:l.IFRAME.validator,supercedes:l.IFRAME.supercedes});o.addProperty(l.PREVENT_CONTEXT_OVERLAP.key,{value:l.PREVENT_CONTEXT_OVERLAP.value,validator:l.PREVENT_CONTEXT_OVERLAP.validator,supercedes:l.PREVENT_CONTEXT_OVERLAP.supercedes});},moveTo:function(o,p){this.cfg.setProperty("xy",[o,p]);},hideMacGeckoScrollbars:function(){f.replaceClass(this.element,"show-scrollbars","hide-scrollbars");},showMacGeckoScrollbars:function(){f.replaceClass(this.element,"hide-scrollbars","show-scrollbars");},_setDomVisibility:function(o){f.setStyle(this.element,"visibility",(o)?"visible":"hidden");var p=b.CSS_HIDDEN;if(o){f.removeClass(this.element,p);}else{f.addClass(this.element,p);}},configVisible:function(x,w,t){var p=w[0],B=f.getStyle(this.element,"visibility"),o=this._cachedEffects||this._createEffects(this.cfg.getProperty("effect")),A=(this.platform=="mac"&&k.gecko),y=d.alreadySubscribed,q,v,s,r,u,z;if(B=="inherit"){v=this.element.parentNode;while(v.nodeType!=9&&v.nodeType!=11){B=f.getStyle(v,"visibility");if(B!="inherit"){break;}v=v.parentNode;}if(B=="inherit"){B="visible";}}if(p){if(A){this.showMacGeckoScrollbars();}if(o){if(p){if(B!="visible"||B===""||this._fadingOut){if(this.beforeShowEvent.fire()){z=o.length;for(s=0;s<z;s++){q=o[s];if(s===0&&!y(q.animateInCompleteEvent,this.showEvent.fire,this.showEvent)){q.animateInCompleteEvent.subscribe(this.showEvent.fire,this.showEvent,true);}q.animateIn();}}}}}else{if(B!="visible"||B===""){if(this.beforeShowEvent.fire()){this._setDomVisibility(true);this.cfg.refireEvent("iframe");this.showEvent.fire();}}else{this._setDomVisibility(true);}}}else{if(A){this.hideMacGeckoScrollbars();}if(o){if(B=="visible"||this._fadingIn){if(this.beforeHideEvent.fire()){z=o.length;for(r=0;r<z;r++){u=o[r];if(r===0&&!y(u.animateOutCompleteEvent,this.hideEvent.fire,this.hideEvent)){u.animateOutCompleteEvent.subscribe(this.hideEvent.fire,this.hideEvent,true);}u.animateOut();}}}else{if(B===""){this._setDomVisibility(false);}}}else{if(B=="visible"||B===""){if(this.beforeHideEvent.fire()){this._setDomVisibility(false);this.hideEvent.fire();}}else{this._setDomVisibility(false);}}}},doCenterOnDOMEvent:function(){var o=this.cfg,p=o.getProperty("fixedcenter");if(o.getProperty("visible")){if(p&&(p!==c||this.fitsInViewport())){this.center();}}},fitsInViewport:function(){var s=b.VIEWPORT_OFFSET,q=this.element,t=q.offsetWidth,r=q.offsetHeight,o=f.getViewportWidth(),p=f.getViewportHeight();return((t+s<o)&&(r+s<p));},configFixedCenter:function(s,q,t){var u=q[0],p=d.alreadySubscribed,r=b.windowResizeEvent,o=b.windowScrollEvent;if(u){this.center();if(!p(this.beforeShowEvent,this.center)){this.beforeShowEvent.subscribe(this.center);}if(!p(r,this.doCenterOnDOMEvent,this)){r.subscribe(this.doCenterOnDOMEvent,this,true);}if(!p(o,this.doCenterOnDOMEvent,this)){o.subscribe(this.doCenterOnDOMEvent,this,true);}}else{this.beforeShowEvent.unsubscribe(this.center);r.unsubscribe(this.doCenterOnDOMEvent,this);o.unsubscribe(this.doCenterOnDOMEvent,this);}},configHeight:function(r,p,s){var o=p[0],q=this.element;f.setStyle(q,"height",o);this.cfg.refireEvent("iframe");},configAutoFillHeight:function(t,s,p){var v=s[0],q=this.cfg,u="autofillheight",w="height",r=q.getProperty(u),o=this._autoFillOnHeightChange;q.unsubscribeFromConfigEvent(w,o);g.textResizeEvent.unsubscribe(o);this.changeContentEvent.unsubscribe(o);if(r&&v!==r&&this[r]){f.setStyle(this[r],w,"");}if(v){v=i.trim(v.toLowerCase());q.subscribeToConfigEvent(w,o,this[v],this);g.textResizeEvent.subscribe(o,this[v],this);this.changeContentEvent.subscribe(o,this[v],this);q.setProperty(u,v,true);}},configWidth:function(r,o,s){var q=o[0],p=this.element;f.setStyle(p,"width",q);this.cfg.refireEvent("iframe");},configzIndex:function(q,o,r){var s=o[0],p=this.element;if(!s){s=f.getStyle(p,"zIndex");if(!s||isNaN(s)){s=0;}}if(this.iframe||this.cfg.getProperty("iframe")===true){if(s<=0){s=1;}}f.setStyle(p,"zIndex",s);this.cfg.setProperty("zIndex",s,true);if(this.iframe){this.stackIframe();}},configXY:function(q,p,r){var t=p[0],o=t[0],s=t[1];this.cfg.setProperty("x",o);this.cfg.setProperty("y",s);this.beforeMoveEvent.fire([o,s]);o=this.cfg.getProperty("x");s=this.cfg.getProperty("y");this.cfg.refireEvent("iframe");this.moveEvent.fire([o,s]);},configX:function(q,p,r){var o=p[0],s=this.cfg.getProperty("y");this.cfg.setProperty("x",o,true);this.cfg.setProperty("y",s,true);this.beforeMoveEvent.fire([o,s]);o=this.cfg.getProperty("x");s=this.cfg.getProperty("y");f.setX(this.element,o,true);this.cfg.setProperty("xy",[o,s],true);this.cfg.refireEvent("iframe");this.moveEvent.fire([o,s]);},configY:function(q,p,r){var o=this.cfg.getProperty("x"),s=p[0];this.cfg.setProperty("x",o,true);this.cfg.setProperty("y",s,true);this.beforeMoveEvent.fire([o,s]);o=this.cfg.getProperty("x");s=this.cfg.getProperty("y");f.setY(this.element,s,true);
this.cfg.setProperty("xy",[o,s],true);this.cfg.refireEvent("iframe");this.moveEvent.fire([o,s]);},showIframe:function(){var p=this.iframe,o;if(p){o=this.element.parentNode;if(o!=p.parentNode){this._addToParent(o,p);}p.style.display="block";}},hideIframe:function(){if(this.iframe){this.iframe.style.display="none";}},syncIframe:function(){var o=this.iframe,q=this.element,s=b.IFRAME_OFFSET,p=(s*2),r;if(o){o.style.width=(q.offsetWidth+p+"px");o.style.height=(q.offsetHeight+p+"px");r=this.cfg.getProperty("xy");if(!i.isArray(r)||(isNaN(r[0])||isNaN(r[1]))){this.syncPosition();r=this.cfg.getProperty("xy");}f.setXY(o,[(r[0]-s),(r[1]-s)]);}},stackIframe:function(){if(this.iframe){var o=f.getStyle(this.element,"zIndex");if(!YAHOO.lang.isUndefined(o)&&!isNaN(o)){f.setStyle(this.iframe,"zIndex",(o-1));}}},configIframe:function(r,q,s){var o=q[0];function t(){var v=this.iframe,w=this.element,x;if(!v){if(!j){j=document.createElement("iframe");if(this.isSecure){j.src=b.IFRAME_SRC;}if(k.ie){j.style.filter="alpha(opacity=0)";j.frameBorder=0;}else{j.style.opacity="0";}j.style.position="absolute";j.style.border="none";j.style.margin="0";j.style.padding="0";j.style.display="none";j.tabIndex=-1;j.className=b.CSS_IFRAME;}v=j.cloneNode(false);v.id=this.id+"_f";x=w.parentNode;var u=x||document.body;this._addToParent(u,v);this.iframe=v;}this.showIframe();this.syncIframe();this.stackIframe();if(!this._hasIframeEventListeners){this.showEvent.subscribe(this.showIframe);this.hideEvent.subscribe(this.hideIframe);this.changeContentEvent.subscribe(this.syncIframe);this._hasIframeEventListeners=true;}}function p(){t.call(this);this.beforeShowEvent.unsubscribe(p);this._iframeDeferred=false;}if(o){if(this.cfg.getProperty("visible")){t.call(this);}else{if(!this._iframeDeferred){this.beforeShowEvent.subscribe(p);this._iframeDeferred=true;}}}else{this.hideIframe();if(this._hasIframeEventListeners){this.showEvent.unsubscribe(this.showIframe);this.hideEvent.unsubscribe(this.hideIframe);this.changeContentEvent.unsubscribe(this.syncIframe);this._hasIframeEventListeners=false;}}},_primeXYFromDOM:function(){if(YAHOO.lang.isUndefined(this.cfg.getProperty("xy"))){this.syncPosition();this.cfg.refireEvent("xy");this.beforeShowEvent.unsubscribe(this._primeXYFromDOM);}},configConstrainToViewport:function(p,o,q){var r=o[0];if(r){if(!d.alreadySubscribed(this.beforeMoveEvent,this.enforceConstraints,this)){this.beforeMoveEvent.subscribe(this.enforceConstraints,this,true);}if(!d.alreadySubscribed(this.beforeShowEvent,this._primeXYFromDOM)){this.beforeShowEvent.subscribe(this._primeXYFromDOM);}}else{this.beforeShowEvent.unsubscribe(this._primeXYFromDOM);this.beforeMoveEvent.unsubscribe(this.enforceConstraints,this);}},configContext:function(u,t,q){var x=t[0],r,o,v,s,p,w=this.CONTEXT_TRIGGERS;if(x){r=x[0];o=x[1];v=x[2];s=x[3];p=x[4];if(w&&w.length>0){s=(s||[]).concat(w);}if(r){if(typeof r=="string"){this.cfg.setProperty("context",[document.getElementById(r),o,v,s,p],true);}if(o&&v){this.align(o,v,p);}if(this._contextTriggers){this._processTriggers(this._contextTriggers,e,this._alignOnTrigger);}if(s){this._processTriggers(s,h,this._alignOnTrigger);this._contextTriggers=s;}}}},_alignOnTrigger:function(p,o){this.align();},_findTriggerCE:function(o){var p=null;if(o instanceof m){p=o;}else{if(b._TRIGGER_MAP[o]){p=b._TRIGGER_MAP[o];}}return p;},_processTriggers:function(s,v,r){var q,u;for(var p=0,o=s.length;p<o;++p){q=s[p];u=this._findTriggerCE(q);if(u){u[v](r,this,true);}else{this[v](q,r);}}},align:function(p,w,s){var v=this.cfg.getProperty("context"),t=this,o,q,u;function r(z,A){var y=null,x=null;switch(p){case b.TOP_LEFT:y=A;x=z;break;case b.TOP_RIGHT:y=A-q.offsetWidth;x=z;break;case b.BOTTOM_LEFT:y=A;x=z-q.offsetHeight;break;case b.BOTTOM_RIGHT:y=A-q.offsetWidth;x=z-q.offsetHeight;break;}if(y!==null&&x!==null){if(s){y+=s[0];x+=s[1];}t.moveTo(y,x);}}if(v){o=v[0];q=this.element;t=this;if(!p){p=v[1];}if(!w){w=v[2];}if(!s&&v[4]){s=v[4];}if(q&&o){u=f.getRegion(o);switch(w){case b.TOP_LEFT:r(u.top,u.left);break;case b.TOP_RIGHT:r(u.top,u.right);break;case b.BOTTOM_LEFT:r(u.bottom,u.left);break;case b.BOTTOM_RIGHT:r(u.bottom,u.right);break;}}}},enforceConstraints:function(p,o,q){var s=o[0];var r=this.getConstrainedXY(s[0],s[1]);this.cfg.setProperty("x",r[0],true);this.cfg.setProperty("y",r[1],true);this.cfg.setProperty("xy",r,true);},_getConstrainedPos:function(y,p){var t=this.element,r=b.VIEWPORT_OFFSET,A=(y=="x"),z=(A)?t.offsetWidth:t.offsetHeight,s=(A)?f.getViewportWidth():f.getViewportHeight(),D=(A)?f.getDocumentScrollLeft():f.getDocumentScrollTop(),C=(A)?b.PREVENT_OVERLAP_X:b.PREVENT_OVERLAP_Y,o=this.cfg.getProperty("context"),u=(z+r<s),w=this.cfg.getProperty("preventcontextoverlap")&&o&&C[(o[1]+o[2])],v=D+r,B=D+s-z-r,q=p;if(p<v||p>B){if(w){q=this._preventOverlap(y,o[0],z,s,D);}else{if(u){if(p<v){q=v;}else{if(p>B){q=B;}}}else{q=v;}}}return q;},_preventOverlap:function(y,w,z,u,C){var A=(y=="x"),t=b.VIEWPORT_OFFSET,s=this,q=((A)?f.getX(w):f.getY(w))-C,o=(A)?w.offsetWidth:w.offsetHeight,p=q-t,r=(u-(q+o))-t,D=false,v=function(){var x;if((s.cfg.getProperty(y)-C)>q){x=(q-z);}else{x=(q+o);}s.cfg.setProperty(y,(x+C),true);return x;},B=function(){var E=((s.cfg.getProperty(y)-C)>q)?r:p,x;if(z>E){if(D){v();}else{v();D=true;x=B();}}return x;};B();return this.cfg.getProperty(y);},getConstrainedX:function(o){return this._getConstrainedPos("x",o);},getConstrainedY:function(o){return this._getConstrainedPos("y",o);},getConstrainedXY:function(o,p){return[this.getConstrainedX(o),this.getConstrainedY(p)];},center:function(){var r=b.VIEWPORT_OFFSET,s=this.element.offsetWidth,q=this.element.offsetHeight,p=f.getViewportWidth(),t=f.getViewportHeight(),o,u;if(s<p){o=(p/2)-(s/2)+f.getDocumentScrollLeft();}else{o=r+f.getDocumentScrollLeft();}if(q<t){u=(t/2)-(q/2)+f.getDocumentScrollTop();}else{u=r+f.getDocumentScrollTop();}this.cfg.setProperty("xy",[parseInt(o,10),parseInt(u,10)]);this.cfg.refireEvent("iframe");if(k.webkit){this.forceContainerRedraw();}},syncPosition:function(){var o=f.getXY(this.element);
this.cfg.setProperty("x",o[0],true);this.cfg.setProperty("y",o[1],true);this.cfg.setProperty("xy",o,true);},onDomResize:function(q,p){var o=this;b.superclass.onDomResize.call(this,q,p);setTimeout(function(){o.syncPosition();o.cfg.refireEvent("iframe");o.cfg.refireEvent("context");},0);},_getComputedHeight:(function(){if(document.defaultView&&document.defaultView.getComputedStyle){return function(p){var o=null;if(p.ownerDocument&&p.ownerDocument.defaultView){var q=p.ownerDocument.defaultView.getComputedStyle(p,"");if(q){o=parseInt(q.height,10);}}return(i.isNumber(o))?o:null;};}else{return function(p){var o=null;if(p.style.pixelHeight){o=p.style.pixelHeight;}return(i.isNumber(o))?o:null;};}})(),_validateAutoFillHeight:function(o){return(!o)||(i.isString(o)&&b.STD_MOD_RE.test(o));},_autoFillOnHeightChange:function(r,p,q){var o=this.cfg.getProperty("height");if((o&&o!=="auto")||(o===0)){this.fillHeight(q);}},_getPreciseHeight:function(p){var o=p.offsetHeight;if(p.getBoundingClientRect){var q=p.getBoundingClientRect();o=q.bottom-q.top;}return o;},fillHeight:function(r){if(r){var p=this.innerElement||this.element,o=[this.header,this.body,this.footer],v,w=0,x=0,t=0,q=false;for(var u=0,s=o.length;u<s;u++){v=o[u];if(v){if(r!==v){x+=this._getPreciseHeight(v);}else{q=true;}}}if(q){if(k.ie||k.opera){f.setStyle(r,"height",0+"px");}w=this._getComputedHeight(p);if(w===null){f.addClass(p,"yui-override-padding");w=p.clientHeight;f.removeClass(p,"yui-override-padding");}t=Math.max(w-x,0);f.setStyle(r,"height",t+"px");if(r.offsetHeight!=t){t=Math.max(t-(r.offsetHeight-t),0);}f.setStyle(r,"height",t+"px");}}},bringToTop:function(){var s=[],r=this.element;function v(z,y){var B=f.getStyle(z,"zIndex"),A=f.getStyle(y,"zIndex"),x=(!B||isNaN(B))?0:parseInt(B,10),w=(!A||isNaN(A))?0:parseInt(A,10);if(x>w){return -1;}else{if(x<w){return 1;}else{return 0;}}}function q(y){var x=f.hasClass(y,b.CSS_OVERLAY),w=YAHOO.widget.Panel;if(x&&!f.isAncestor(r,y)){if(w&&f.hasClass(y,w.CSS_PANEL)){s[s.length]=y.parentNode;}else{s[s.length]=y;}}}f.getElementsBy(q,"div",document.body);s.sort(v);var o=s[0],u;if(o){u=f.getStyle(o,"zIndex");if(!isNaN(u)){var t=false;if(o!=r){t=true;}else{if(s.length>1){var p=f.getStyle(s[1],"zIndex");if(!isNaN(p)&&(u==p)){t=true;}}}if(t){this.cfg.setProperty("zindex",(parseInt(u,10)+2));}}}},destroy:function(o){if(this.iframe){this.iframe.parentNode.removeChild(this.iframe);}this.iframe=null;b.windowResizeEvent.unsubscribe(this.doCenterOnDOMEvent,this);b.windowScrollEvent.unsubscribe(this.doCenterOnDOMEvent,this);g.textResizeEvent.unsubscribe(this._autoFillOnHeightChange);if(this._contextTriggers){this._processTriggers(this._contextTriggers,e,this._alignOnTrigger);}b.superclass.destroy.call(this,o);},forceContainerRedraw:function(){var o=this;f.addClass(o.element,"yui-force-redraw");setTimeout(function(){f.removeClass(o.element,"yui-force-redraw");},0);},toString:function(){return"Overlay "+this.id;}});}());(function(){YAHOO.widget.OverlayManager=function(g){this.init(g);};var d=YAHOO.widget.Overlay,c=YAHOO.util.Event,e=YAHOO.util.Dom,b=YAHOO.util.Config,f=YAHOO.util.CustomEvent,a=YAHOO.widget.OverlayManager;a.CSS_FOCUSED="focused";a.prototype={constructor:a,overlays:null,initDefaultConfig:function(){this.cfg.addProperty("overlays",{suppressEvent:true});this.cfg.addProperty("focusevent",{value:"mousedown"});},init:function(i){this.cfg=new b(this);this.initDefaultConfig();if(i){this.cfg.applyConfig(i,true);}this.cfg.fireQueue();var h=null;this.getActive=function(){return h;};this.focus=function(j){var k=this.find(j);if(k){k.focus();}};this.remove=function(k){var m=this.find(k),j;if(m){if(h==m){h=null;}var l=(m.element===null&&m.cfg===null)?true:false;if(!l){j=e.getStyle(m.element,"zIndex");m.cfg.setProperty("zIndex",-1000,true);}this.overlays.sort(this.compareZIndexDesc);this.overlays=this.overlays.slice(0,(this.overlays.length-1));m.hideEvent.unsubscribe(m.blur);m.destroyEvent.unsubscribe(this._onOverlayDestroy,m);m.focusEvent.unsubscribe(this._onOverlayFocusHandler,m);m.blurEvent.unsubscribe(this._onOverlayBlurHandler,m);if(!l){c.removeListener(m.element,this.cfg.getProperty("focusevent"),this._onOverlayElementFocus);m.cfg.setProperty("zIndex",j,true);m.cfg.setProperty("manager",null);}if(m.focusEvent._managed){m.focusEvent=null;}if(m.blurEvent._managed){m.blurEvent=null;}if(m.focus._managed){m.focus=null;}if(m.blur._managed){m.blur=null;}}};this.blurAll=function(){var k=this.overlays.length,j;if(k>0){j=k-1;do{this.overlays[j].blur();}while(j--);}};this._manageBlur=function(j){var k=false;if(h==j){e.removeClass(h.element,a.CSS_FOCUSED);h=null;k=true;}return k;};this._manageFocus=function(j){var k=false;if(h!=j){if(h){h.blur();}h=j;this.bringToTop(h);e.addClass(h.element,a.CSS_FOCUSED);k=true;}return k;};var g=this.cfg.getProperty("overlays");if(!this.overlays){this.overlays=[];}if(g){this.register(g);this.overlays.sort(this.compareZIndexDesc);}},_onOverlayElementFocus:function(i){var g=c.getTarget(i),h=this.close;if(h&&(g==h||e.isAncestor(h,g))){this.blur();}else{this.focus();}},_onOverlayDestroy:function(h,g,i){this.remove(i);},_onOverlayFocusHandler:function(h,g,i){this._manageFocus(i);},_onOverlayBlurHandler:function(h,g,i){this._manageBlur(i);},_bindFocus:function(g){var h=this;if(!g.focusEvent){g.focusEvent=g.createEvent("focus");g.focusEvent.signature=f.LIST;g.focusEvent._managed=true;}else{g.focusEvent.subscribe(h._onOverlayFocusHandler,g,h);}if(!g.focus){c.on(g.element,h.cfg.getProperty("focusevent"),h._onOverlayElementFocus,null,g);g.focus=function(){if(h._manageFocus(this)){if(this.cfg.getProperty("visible")&&this.focusFirst){this.focusFirst();}this.focusEvent.fire();}};g.focus._managed=true;}},_bindBlur:function(g){var h=this;if(!g.blurEvent){g.blurEvent=g.createEvent("blur");g.blurEvent.signature=f.LIST;g.focusEvent._managed=true;}else{g.blurEvent.subscribe(h._onOverlayBlurHandler,g,h);}if(!g.blur){g.blur=function(){if(h._manageBlur(this)){this.blurEvent.fire();}};g.blur._managed=true;}g.hideEvent.subscribe(g.blur);
},_bindDestroy:function(g){var h=this;g.destroyEvent.subscribe(h._onOverlayDestroy,g,h);},_syncZIndex:function(g){var h=e.getStyle(g.element,"zIndex");if(!isNaN(h)){g.cfg.setProperty("zIndex",parseInt(h,10));}else{g.cfg.setProperty("zIndex",0);}},register:function(g){var k=false,h,j;if(g instanceof d){g.cfg.addProperty("manager",{value:this});this._bindFocus(g);this._bindBlur(g);this._bindDestroy(g);this._syncZIndex(g);this.overlays.push(g);this.bringToTop(g);k=true;}else{if(g instanceof Array){for(h=0,j=g.length;h<j;h++){k=this.register(g[h])||k;}}}return k;},bringToTop:function(m){var i=this.find(m),l,g,j;if(i){j=this.overlays;j.sort(this.compareZIndexDesc);g=j[0];if(g){l=e.getStyle(g.element,"zIndex");if(!isNaN(l)){var k=false;if(g!==i){k=true;}else{if(j.length>1){var h=e.getStyle(j[1].element,"zIndex");if(!isNaN(h)&&(l==h)){k=true;}}}if(k){i.cfg.setProperty("zindex",(parseInt(l,10)+2));}}j.sort(this.compareZIndexDesc);}}},find:function(g){var l=g instanceof d,j=this.overlays,p=j.length,k=null,m,h;if(l||typeof g=="string"){for(h=p-1;h>=0;h--){m=j[h];if((l&&(m===g))||(m.id==g)){k=m;break;}}}return k;},compareZIndexDesc:function(j,i){var h=(j.cfg)?j.cfg.getProperty("zIndex"):null,g=(i.cfg)?i.cfg.getProperty("zIndex"):null;if(h===null&&g===null){return 0;}else{if(h===null){return 1;}else{if(g===null){return -1;}else{if(h>g){return -1;}else{if(h<g){return 1;}else{return 0;}}}}}},showAll:function(){var h=this.overlays,j=h.length,g;for(g=j-1;g>=0;g--){h[g].show();}},hideAll:function(){var h=this.overlays,j=h.length,g;for(g=j-1;g>=0;g--){h[g].hide();}},toString:function(){return"OverlayManager";}};}());(function(){YAHOO.widget.Tooltip=function(p,o){YAHOO.widget.Tooltip.superclass.constructor.call(this,p,o);};var e=YAHOO.lang,n=YAHOO.util.Event,m=YAHOO.util.CustomEvent,c=YAHOO.util.Dom,j=YAHOO.widget.Tooltip,h=YAHOO.env.ua,g=(h.ie&&(h.ie<=6||document.compatMode=="BackCompat")),f,i={"PREVENT_OVERLAP":{key:"preventoverlap",value:true,validator:e.isBoolean,supercedes:["x","y","xy"]},"SHOW_DELAY":{key:"showdelay",value:200,validator:e.isNumber},"AUTO_DISMISS_DELAY":{key:"autodismissdelay",value:5000,validator:e.isNumber},"HIDE_DELAY":{key:"hidedelay",value:250,validator:e.isNumber},"TEXT":{key:"text",suppressEvent:true},"CONTAINER":{key:"container"},"DISABLED":{key:"disabled",value:false,suppressEvent:true},"XY_OFFSET":{key:"xyoffset",value:[0,25],suppressEvent:true}},a={"CONTEXT_MOUSE_OVER":"contextMouseOver","CONTEXT_MOUSE_OUT":"contextMouseOut","CONTEXT_TRIGGER":"contextTrigger"};j.CSS_TOOLTIP="yui-tt";function k(q,o){var p=this.cfg,r=p.getProperty("width");if(r==o){p.setProperty("width",q);}}function d(p,o){if("_originalWidth" in this){k.call(this,this._originalWidth,this._forcedWidth);}var q=document.body,u=this.cfg,t=u.getProperty("width"),r,s;if((!t||t=="auto")&&(u.getProperty("container")!=q||u.getProperty("x")>=c.getViewportWidth()||u.getProperty("y")>=c.getViewportHeight())){s=this.element.cloneNode(true);s.style.visibility="hidden";s.style.top="0px";s.style.left="0px";q.appendChild(s);r=(s.offsetWidth+"px");q.removeChild(s);s=null;u.setProperty("width",r);u.refireEvent("xy");this._originalWidth=t||"";this._forcedWidth=r;}}function b(p,o,q){this.render(q);}function l(){n.onDOMReady(b,this.cfg.getProperty("container"),this);}YAHOO.extend(j,YAHOO.widget.Overlay,{init:function(p,o){j.superclass.init.call(this,p);this.beforeInitEvent.fire(j);c.addClass(this.element,j.CSS_TOOLTIP);if(o){this.cfg.applyConfig(o,true);}this.cfg.queueProperty("visible",false);this.cfg.queueProperty("constraintoviewport",true);this.setBody("");this.subscribe("changeContent",d);this.subscribe("init",l);this.subscribe("render",this.onRender);this.initEvent.fire(j);},initEvents:function(){j.superclass.initEvents.call(this);var o=m.LIST;this.contextMouseOverEvent=this.createEvent(a.CONTEXT_MOUSE_OVER);this.contextMouseOverEvent.signature=o;this.contextMouseOutEvent=this.createEvent(a.CONTEXT_MOUSE_OUT);this.contextMouseOutEvent.signature=o;this.contextTriggerEvent=this.createEvent(a.CONTEXT_TRIGGER);this.contextTriggerEvent.signature=o;},initDefaultConfig:function(){j.superclass.initDefaultConfig.call(this);this.cfg.addProperty(i.PREVENT_OVERLAP.key,{value:i.PREVENT_OVERLAP.value,validator:i.PREVENT_OVERLAP.validator,supercedes:i.PREVENT_OVERLAP.supercedes});this.cfg.addProperty(i.SHOW_DELAY.key,{handler:this.configShowDelay,value:200,validator:i.SHOW_DELAY.validator});this.cfg.addProperty(i.AUTO_DISMISS_DELAY.key,{handler:this.configAutoDismissDelay,value:i.AUTO_DISMISS_DELAY.value,validator:i.AUTO_DISMISS_DELAY.validator});this.cfg.addProperty(i.HIDE_DELAY.key,{handler:this.configHideDelay,value:i.HIDE_DELAY.value,validator:i.HIDE_DELAY.validator});this.cfg.addProperty(i.TEXT.key,{handler:this.configText,suppressEvent:i.TEXT.suppressEvent});this.cfg.addProperty(i.CONTAINER.key,{handler:this.configContainer,value:document.body});this.cfg.addProperty(i.DISABLED.key,{handler:this.configContainer,value:i.DISABLED.value,supressEvent:i.DISABLED.suppressEvent});this.cfg.addProperty(i.XY_OFFSET.key,{value:i.XY_OFFSET.value.concat(),supressEvent:i.XY_OFFSET.suppressEvent});},configText:function(p,o,q){var r=o[0];if(r){this.setBody(r);}},configContainer:function(q,p,r){var o=p[0];if(typeof o=="string"){this.cfg.setProperty("container",document.getElementById(o),true);}},_removeEventListeners:function(){var r=this._context,o,q,p;if(r){o=r.length;if(o>0){p=o-1;do{q=r[p];n.removeListener(q,"mouseover",this.onContextMouseOver);n.removeListener(q,"mousemove",this.onContextMouseMove);n.removeListener(q,"mouseout",this.onContextMouseOut);}while(p--);}}},configContext:function(t,p,u){var s=p[0],v,o,r,q;if(s){if(!(s instanceof Array)){if(typeof s=="string"){this.cfg.setProperty("context",[document.getElementById(s)],true);}else{this.cfg.setProperty("context",[s],true);}s=this.cfg.getProperty("context");}this._removeEventListeners();this._context=s;v=this._context;if(v){o=v.length;if(o>0){q=o-1;do{r=v[q];n.on(r,"mouseover",this.onContextMouseOver,this);
n.on(r,"mousemove",this.onContextMouseMove,this);n.on(r,"mouseout",this.onContextMouseOut,this);}while(q--);}}}},onContextMouseMove:function(p,o){o.pageX=n.getPageX(p);o.pageY=n.getPageY(p);},onContextMouseOver:function(q,p){var o=this;if(o.title){p._tempTitle=o.title;o.title="";}if(p.fireEvent("contextMouseOver",o,q)!==false&&!p.cfg.getProperty("disabled")){if(p.hideProcId){clearTimeout(p.hideProcId);p.hideProcId=null;}n.on(o,"mousemove",p.onContextMouseMove,p);p.showProcId=p.doShow(q,o);}},onContextMouseOut:function(q,p){var o=this;if(p._tempTitle){o.title=p._tempTitle;p._tempTitle=null;}if(p.showProcId){clearTimeout(p.showProcId);p.showProcId=null;}if(p.hideProcId){clearTimeout(p.hideProcId);p.hideProcId=null;}p.fireEvent("contextMouseOut",o,q);p.hideProcId=setTimeout(function(){p.hide();},p.cfg.getProperty("hidedelay"));},doShow:function(r,o){var t=this.cfg.getProperty("xyoffset"),p=t[0],s=t[1],q=this;if(h.opera&&o.tagName&&o.tagName.toUpperCase()=="A"){s+=12;}return setTimeout(function(){var u=q.cfg.getProperty("text");if(q._tempTitle&&(u===""||YAHOO.lang.isUndefined(u)||YAHOO.lang.isNull(u))){q.setBody(q._tempTitle);}else{q.cfg.refireEvent("text");}q.moveTo(q.pageX+p,q.pageY+s);if(q.cfg.getProperty("preventoverlap")){q.preventOverlap(q.pageX,q.pageY);}n.removeListener(o,"mousemove",q.onContextMouseMove);q.contextTriggerEvent.fire(o);q.show();q.hideProcId=q.doHide();},this.cfg.getProperty("showdelay"));},doHide:function(){var o=this;return setTimeout(function(){o.hide();},this.cfg.getProperty("autodismissdelay"));},preventOverlap:function(s,r){var o=this.element.offsetHeight,q=new YAHOO.util.Point(s,r),p=c.getRegion(this.element);p.top-=5;p.left-=5;p.right+=5;p.bottom+=5;if(p.contains(q)){this.cfg.setProperty("y",(r-o-5));}},onRender:function(s,r){function t(){var w=this.element,v=this.underlay;if(v){v.style.width=(w.offsetWidth+6)+"px";v.style.height=(w.offsetHeight+1)+"px";}}function p(){c.addClass(this.underlay,"yui-tt-shadow-visible");if(h.ie){this.forceUnderlayRedraw();}}function o(){c.removeClass(this.underlay,"yui-tt-shadow-visible");}function u(){var x=this.underlay,w,v,z,y;if(!x){w=this.element;v=YAHOO.widget.Module;z=h.ie;y=this;if(!f){f=document.createElement("div");f.className="yui-tt-shadow";}x=f.cloneNode(false);w.appendChild(x);this.underlay=x;this._shadow=this.underlay;p.call(this);this.subscribe("beforeShow",p);this.subscribe("hide",o);if(g){window.setTimeout(function(){t.call(y);},0);this.cfg.subscribeToConfigEvent("width",t);this.cfg.subscribeToConfigEvent("height",t);this.subscribe("changeContent",t);v.textResizeEvent.subscribe(t,this,true);this.subscribe("destroy",function(){v.textResizeEvent.unsubscribe(t,this);});}}}function q(){u.call(this);this.unsubscribe("beforeShow",q);}if(this.cfg.getProperty("visible")){u.call(this);}else{this.subscribe("beforeShow",q);}},forceUnderlayRedraw:function(){var o=this;c.addClass(o.underlay,"yui-force-redraw");setTimeout(function(){c.removeClass(o.underlay,"yui-force-redraw");},0);},destroy:function(){this._removeEventListeners();j.superclass.destroy.call(this);},toString:function(){return"Tooltip "+this.id;}});}());(function(){YAHOO.widget.Panel=function(v,u){YAHOO.widget.Panel.superclass.constructor.call(this,v,u);};var s=null;var e=YAHOO.lang,f=YAHOO.util,a=f.Dom,t=f.Event,m=f.CustomEvent,k=YAHOO.util.KeyListener,i=f.Config,h=YAHOO.widget.Overlay,o=YAHOO.widget.Panel,l=YAHOO.env.ua,p=(l.ie&&(l.ie<=6||document.compatMode=="BackCompat")),g,q,c,d={"BEFORE_SHOW_MASK":"beforeShowMask","BEFORE_HIDE_MASK":"beforeHideMask","SHOW_MASK":"showMask","HIDE_MASK":"hideMask","DRAG":"drag"},n={"CLOSE":{key:"close",value:true,validator:e.isBoolean,supercedes:["visible"]},"DRAGGABLE":{key:"draggable",value:(f.DD?true:false),validator:e.isBoolean,supercedes:["visible"]},"DRAG_ONLY":{key:"dragonly",value:false,validator:e.isBoolean,supercedes:["draggable"]},"UNDERLAY":{key:"underlay",value:"shadow",supercedes:["visible"]},"MODAL":{key:"modal",value:false,validator:e.isBoolean,supercedes:["visible","zindex"]},"KEY_LISTENERS":{key:"keylisteners",suppressEvent:true,supercedes:["visible"]},"STRINGS":{key:"strings",supercedes:["close"],validator:e.isObject,value:{close:"Close"}}};o.CSS_PANEL="yui-panel";o.CSS_PANEL_CONTAINER="yui-panel-container";o.FOCUSABLE=["a","button","select","textarea","input","iframe"];function j(v,u){if(!this.header&&this.cfg.getProperty("draggable")){this.setHeader("&#160;");}}function r(v,u,w){var z=w[0],x=w[1],y=this.cfg,A=y.getProperty("width");if(A==x){y.setProperty("width",z);}this.unsubscribe("hide",r,w);}function b(v,u){var y,x,w;if(p){y=this.cfg;x=y.getProperty("width");if(!x||x=="auto"){w=(this.element.offsetWidth+"px");y.setProperty("width",w);this.subscribe("hide",r,[(x||""),w]);}}}YAHOO.extend(o,h,{init:function(v,u){o.superclass.init.call(this,v);this.beforeInitEvent.fire(o);a.addClass(this.element,o.CSS_PANEL);this.buildWrapper();if(u){this.cfg.applyConfig(u,true);}this.subscribe("showMask",this._addFocusHandlers);this.subscribe("hideMask",this._removeFocusHandlers);this.subscribe("beforeRender",j);this.subscribe("render",function(){this.setFirstLastFocusable();this.subscribe("changeContent",this.setFirstLastFocusable);});this.subscribe("show",this._focusOnShow);this.initEvent.fire(o);},_onElementFocus:function(z){if(s===this){var y=t.getTarget(z),x=document.documentElement,v=(y!==x&&y!==window);if(v&&y!==this.element&&y!==this.mask&&!a.isAncestor(this.element,y)){try{this._focusFirstModal();}catch(w){try{if(v&&y!==document.body){y.blur();}}catch(u){}}}}},_focusFirstModal:function(){var u=this.firstElement;if(u){u.focus();}else{if(this._modalFocus){this._modalFocus.focus();}else{this.innerElement.focus();}}},_addFocusHandlers:function(v,u){if(!this.firstElement){if(l.webkit||l.opera){if(!this._modalFocus){this._createHiddenFocusElement();}}else{this.innerElement.tabIndex=0;}}this._setTabLoop(this.firstElement,this.lastElement);t.onFocus(document.documentElement,this._onElementFocus,this,true);s=this;},_createHiddenFocusElement:function(){var u=document.createElement("button");
u.style.height="1px";u.style.width="1px";u.style.position="absolute";u.style.left="-10000em";u.style.opacity=0;u.tabIndex=-1;this.innerElement.appendChild(u);this._modalFocus=u;},_removeFocusHandlers:function(v,u){t.removeFocusListener(document.documentElement,this._onElementFocus,this);if(s==this){s=null;}},_focusOnShow:function(v,u,w){if(u&&u[1]){t.stopEvent(u[1]);}if(!this.focusFirst(v,u,w)){if(this.cfg.getProperty("modal")){this._focusFirstModal();}}},focusFirst:function(w,u,z){var v=this.firstElement,y=false;if(u&&u[1]){t.stopEvent(u[1]);}if(v){try{v.focus();y=true;}catch(x){}}return y;},focusLast:function(w,u,z){var v=this.lastElement,y=false;if(u&&u[1]){t.stopEvent(u[1]);}if(v){try{v.focus();y=true;}catch(x){}}return y;},_setTabLoop:function(u,v){this.setTabLoop(u,v);},setTabLoop:function(x,z){var v=this.preventBackTab,w=this.preventTabOut,u=this.showEvent,y=this.hideEvent;if(v){v.disable();u.unsubscribe(v.enable,v);y.unsubscribe(v.disable,v);v=this.preventBackTab=null;}if(w){w.disable();u.unsubscribe(w.enable,w);y.unsubscribe(w.disable,w);w=this.preventTabOut=null;}if(x){this.preventBackTab=new k(x,{shift:true,keys:9},{fn:this.focusLast,scope:this,correctScope:true});v=this.preventBackTab;u.subscribe(v.enable,v,true);y.subscribe(v.disable,v,true);}if(z){this.preventTabOut=new k(z,{shift:false,keys:9},{fn:this.focusFirst,scope:this,correctScope:true});w=this.preventTabOut;u.subscribe(w.enable,w,true);y.subscribe(w.disable,w,true);}},getFocusableElements:function(v){v=v||this.innerElement;var x={},u=this;for(var w=0;w<o.FOCUSABLE.length;w++){x[o.FOCUSABLE[w]]=true;}return a.getElementsBy(function(y){return u._testIfFocusable(y,x);},null,v);},_testIfFocusable:function(u,v){if(u.focus&&u.type!=="hidden"&&!u.disabled&&v[u.tagName.toLowerCase()]){return true;}return false;},setFirstLastFocusable:function(){this.firstElement=null;this.lastElement=null;var u=this.getFocusableElements();this.focusableElements=u;if(u.length>0){this.firstElement=u[0];this.lastElement=u[u.length-1];}if(this.cfg.getProperty("modal")){this._setTabLoop(this.firstElement,this.lastElement);}},initEvents:function(){o.superclass.initEvents.call(this);var u=m.LIST;this.showMaskEvent=this.createEvent(d.SHOW_MASK);this.showMaskEvent.signature=u;this.beforeShowMaskEvent=this.createEvent(d.BEFORE_SHOW_MASK);this.beforeShowMaskEvent.signature=u;this.hideMaskEvent=this.createEvent(d.HIDE_MASK);this.hideMaskEvent.signature=u;this.beforeHideMaskEvent=this.createEvent(d.BEFORE_HIDE_MASK);this.beforeHideMaskEvent.signature=u;this.dragEvent=this.createEvent(d.DRAG);this.dragEvent.signature=u;},initDefaultConfig:function(){o.superclass.initDefaultConfig.call(this);this.cfg.addProperty(n.CLOSE.key,{handler:this.configClose,value:n.CLOSE.value,validator:n.CLOSE.validator,supercedes:n.CLOSE.supercedes});this.cfg.addProperty(n.DRAGGABLE.key,{handler:this.configDraggable,value:(f.DD)?true:false,validator:n.DRAGGABLE.validator,supercedes:n.DRAGGABLE.supercedes});this.cfg.addProperty(n.DRAG_ONLY.key,{value:n.DRAG_ONLY.value,validator:n.DRAG_ONLY.validator,supercedes:n.DRAG_ONLY.supercedes});this.cfg.addProperty(n.UNDERLAY.key,{handler:this.configUnderlay,value:n.UNDERLAY.value,supercedes:n.UNDERLAY.supercedes});this.cfg.addProperty(n.MODAL.key,{handler:this.configModal,value:n.MODAL.value,validator:n.MODAL.validator,supercedes:n.MODAL.supercedes});this.cfg.addProperty(n.KEY_LISTENERS.key,{handler:this.configKeyListeners,suppressEvent:n.KEY_LISTENERS.suppressEvent,supercedes:n.KEY_LISTENERS.supercedes});this.cfg.addProperty(n.STRINGS.key,{value:n.STRINGS.value,handler:this.configStrings,validator:n.STRINGS.validator,supercedes:n.STRINGS.supercedes});},configClose:function(y,v,z){var A=v[0],x=this.close,u=this.cfg.getProperty("strings"),w;if(A){if(!x){if(!c){c=document.createElement("a");c.className="container-close";c.href="#";}x=c.cloneNode(true);w=this.innerElement.firstChild;if(w){this.innerElement.insertBefore(x,w);}else{this.innerElement.appendChild(x);}x.innerHTML=(u&&u.close)?u.close:"&#160;";t.on(x,"click",this._doClose,this,true);this.close=x;}else{x.style.display="block";}}else{if(x){x.style.display="none";}}},_doClose:function(u){t.preventDefault(u);this.hide();},configDraggable:function(v,u,w){var x=u[0];if(x){if(!f.DD){this.cfg.setProperty("draggable",false);return;}if(this.header){a.setStyle(this.header,"cursor","move");this.registerDragDrop();}this.subscribe("beforeShow",b);}else{if(this.dd){this.dd.unreg();}if(this.header){a.setStyle(this.header,"cursor","auto");}this.unsubscribe("beforeShow",b);}},configUnderlay:function(D,C,z){var B=(this.platform=="mac"&&l.gecko),E=C[0].toLowerCase(),v=this.underlay,w=this.element;function x(){var F=false;if(!v){if(!q){q=document.createElement("div");q.className="underlay";}v=q.cloneNode(false);this.element.appendChild(v);this.underlay=v;if(p){this.sizeUnderlay();this.cfg.subscribeToConfigEvent("width",this.sizeUnderlay);this.cfg.subscribeToConfigEvent("height",this.sizeUnderlay);this.changeContentEvent.subscribe(this.sizeUnderlay);YAHOO.widget.Module.textResizeEvent.subscribe(this.sizeUnderlay,this,true);}if(l.webkit&&l.webkit<420){this.changeContentEvent.subscribe(this.forceUnderlayRedraw);}F=true;}}function A(){var F=x.call(this);if(!F&&p){this.sizeUnderlay();}this._underlayDeferred=false;this.beforeShowEvent.unsubscribe(A);}function y(){if(this._underlayDeferred){this.beforeShowEvent.unsubscribe(A);this._underlayDeferred=false;}if(v){this.cfg.unsubscribeFromConfigEvent("width",this.sizeUnderlay);this.cfg.unsubscribeFromConfigEvent("height",this.sizeUnderlay);this.changeContentEvent.unsubscribe(this.sizeUnderlay);this.changeContentEvent.unsubscribe(this.forceUnderlayRedraw);YAHOO.widget.Module.textResizeEvent.unsubscribe(this.sizeUnderlay,this,true);this.element.removeChild(v);this.underlay=null;}}switch(E){case"shadow":a.removeClass(w,"matte");a.addClass(w,"shadow");break;case"matte":if(!B){y.call(this);}a.removeClass(w,"shadow");a.addClass(w,"matte");break;default:if(!B){y.call(this);
}a.removeClass(w,"shadow");a.removeClass(w,"matte");break;}if((E=="shadow")||(B&&!v)){if(this.cfg.getProperty("visible")){var u=x.call(this);if(!u&&p){this.sizeUnderlay();}}else{if(!this._underlayDeferred){this.beforeShowEvent.subscribe(A);this._underlayDeferred=true;}}}},configModal:function(v,u,x){var w=u[0];if(w){if(!this._hasModalityEventListeners){this.subscribe("beforeShow",this.buildMask);this.subscribe("beforeShow",this.bringToTop);this.subscribe("beforeShow",this.showMask);this.subscribe("hide",this.hideMask);h.windowResizeEvent.subscribe(this.sizeMask,this,true);this._hasModalityEventListeners=true;}}else{if(this._hasModalityEventListeners){if(this.cfg.getProperty("visible")){this.hideMask();this.removeMask();}this.unsubscribe("beforeShow",this.buildMask);this.unsubscribe("beforeShow",this.bringToTop);this.unsubscribe("beforeShow",this.showMask);this.unsubscribe("hide",this.hideMask);h.windowResizeEvent.unsubscribe(this.sizeMask,this);this._hasModalityEventListeners=false;}}},removeMask:function(){var v=this.mask,u;if(v){this.hideMask();u=v.parentNode;if(u){u.removeChild(v);}this.mask=null;}},configKeyListeners:function(x,u,A){var w=u[0],z,y,v;if(w){if(w instanceof Array){y=w.length;for(v=0;v<y;v++){z=w[v];if(!i.alreadySubscribed(this.showEvent,z.enable,z)){this.showEvent.subscribe(z.enable,z,true);}if(!i.alreadySubscribed(this.hideEvent,z.disable,z)){this.hideEvent.subscribe(z.disable,z,true);this.destroyEvent.subscribe(z.disable,z,true);}}}else{if(!i.alreadySubscribed(this.showEvent,w.enable,w)){this.showEvent.subscribe(w.enable,w,true);}if(!i.alreadySubscribed(this.hideEvent,w.disable,w)){this.hideEvent.subscribe(w.disable,w,true);this.destroyEvent.subscribe(w.disable,w,true);}}}},configStrings:function(v,u,w){var x=e.merge(n.STRINGS.value,u[0]);this.cfg.setProperty(n.STRINGS.key,x,true);},configHeight:function(x,v,y){var u=v[0],w=this.innerElement;a.setStyle(w,"height",u);this.cfg.refireEvent("iframe");},_autoFillOnHeightChange:function(x,v,w){o.superclass._autoFillOnHeightChange.apply(this,arguments);if(p){var u=this;setTimeout(function(){u.sizeUnderlay();},0);}},configWidth:function(x,u,y){var w=u[0],v=this.innerElement;a.setStyle(v,"width",w);this.cfg.refireEvent("iframe");},configzIndex:function(v,u,x){o.superclass.configzIndex.call(this,v,u,x);if(this.mask||this.cfg.getProperty("modal")===true){var w=a.getStyle(this.element,"zIndex");if(!w||isNaN(w)){w=0;}if(w===0){this.cfg.setProperty("zIndex",1);}else{this.stackMask();}}},buildWrapper:function(){var w=this.element.parentNode,u=this.element,v=document.createElement("div");v.className=o.CSS_PANEL_CONTAINER;v.id=u.id+"_c";if(w){w.insertBefore(v,u);}v.appendChild(u);this.element=v;this.innerElement=u;a.setStyle(this.innerElement,"visibility","inherit");},sizeUnderlay:function(){var v=this.underlay,u;if(v){u=this.element;v.style.width=u.offsetWidth+"px";v.style.height=u.offsetHeight+"px";}},registerDragDrop:function(){var v=this;if(this.header){if(!f.DD){return;}var u=(this.cfg.getProperty("dragonly")===true);this.dd=new f.DD(this.element.id,this.id,{dragOnly:u});if(!this.header.id){this.header.id=this.id+"_h";}this.dd.startDrag=function(){var x,z,w,C,B,A;if(YAHOO.env.ua.ie==6){a.addClass(v.element,"drag");}if(v.cfg.getProperty("constraintoviewport")){var y=h.VIEWPORT_OFFSET;x=v.element.offsetHeight;z=v.element.offsetWidth;w=a.getViewportWidth();C=a.getViewportHeight();B=a.getDocumentScrollLeft();A=a.getDocumentScrollTop();if(x+y<C){this.minY=A+y;this.maxY=A+C-x-y;}else{this.minY=A+y;this.maxY=A+y;}if(z+y<w){this.minX=B+y;this.maxX=B+w-z-y;}else{this.minX=B+y;this.maxX=B+y;}this.constrainX=true;this.constrainY=true;}else{this.constrainX=false;this.constrainY=false;}v.dragEvent.fire("startDrag",arguments);};this.dd.onDrag=function(){v.syncPosition();v.cfg.refireEvent("iframe");if(this.platform=="mac"&&YAHOO.env.ua.gecko){this.showMacGeckoScrollbars();}v.dragEvent.fire("onDrag",arguments);};this.dd.endDrag=function(){if(YAHOO.env.ua.ie==6){a.removeClass(v.element,"drag");}v.dragEvent.fire("endDrag",arguments);v.moveEvent.fire(v.cfg.getProperty("xy"));};this.dd.setHandleElId(this.header.id);this.dd.addInvalidHandleType("INPUT");this.dd.addInvalidHandleType("SELECT");this.dd.addInvalidHandleType("TEXTAREA");}},buildMask:function(){var u=this.mask;if(!u){if(!g){g=document.createElement("div");g.className="mask";g.innerHTML="&#160;";}u=g.cloneNode(true);u.id=this.id+"_mask";document.body.insertBefore(u,document.body.firstChild);this.mask=u;if(YAHOO.env.ua.gecko&&this.platform=="mac"){a.addClass(this.mask,"block-scrollbars");}this.stackMask();}},hideMask:function(){if(this.cfg.getProperty("modal")&&this.mask&&this.beforeHideMaskEvent.fire()){this.mask.style.display="none";a.removeClass(document.body,"masked");this.hideMaskEvent.fire();}},showMask:function(){if(this.cfg.getProperty("modal")&&this.mask&&this.beforeShowMaskEvent.fire()){a.addClass(document.body,"masked");this.sizeMask();this.mask.style.display="block";this.showMaskEvent.fire();}},sizeMask:function(){if(this.mask){var v=this.mask,w=a.getViewportWidth(),u=a.getViewportHeight();if(v.offsetHeight>u){v.style.height=u+"px";}if(v.offsetWidth>w){v.style.width=w+"px";}v.style.height=a.getDocumentHeight()+"px";v.style.width=a.getDocumentWidth()+"px";}},stackMask:function(){if(this.mask){var u=a.getStyle(this.element,"zIndex");if(!YAHOO.lang.isUndefined(u)&&!isNaN(u)){a.setStyle(this.mask,"zIndex",u-1);}}},render:function(u){return o.superclass.render.call(this,u,this.innerElement);},_renderHeader:function(u){u=u||this.innerElement;o.superclass._renderHeader.call(this,u);},_renderBody:function(u){u=u||this.innerElement;o.superclass._renderBody.call(this,u);},_renderFooter:function(u){u=u||this.innerElement;o.superclass._renderFooter.call(this,u);},destroy:function(u){h.windowResizeEvent.unsubscribe(this.sizeMask,this);this.removeMask();if(this.close){t.purgeElement(this.close);}o.superclass.destroy.call(this,u);},forceUnderlayRedraw:function(){var v=this.underlay;a.addClass(v,"yui-force-redraw");
setTimeout(function(){a.removeClass(v,"yui-force-redraw");},0);},toString:function(){return"Panel "+this.id;}});}());(function(){YAHOO.widget.Dialog=function(j,i){YAHOO.widget.Dialog.superclass.constructor.call(this,j,i);};var b=YAHOO.util.Event,g=YAHOO.util.CustomEvent,e=YAHOO.util.Dom,a=YAHOO.widget.Dialog,f=YAHOO.lang,h={"BEFORE_SUBMIT":"beforeSubmit","SUBMIT":"submit","MANUAL_SUBMIT":"manualSubmit","ASYNC_SUBMIT":"asyncSubmit","FORM_SUBMIT":"formSubmit","CANCEL":"cancel"},c={"POST_METHOD":{key:"postmethod",value:"async"},"POST_DATA":{key:"postdata",value:null},"BUTTONS":{key:"buttons",value:"none",supercedes:["visible"]},"HIDEAFTERSUBMIT":{key:"hideaftersubmit",value:true}};a.CSS_DIALOG="yui-dialog";function d(){var m=this._aButtons,k,l,j;if(f.isArray(m)){k=m.length;if(k>0){j=k-1;do{l=m[j];if(YAHOO.widget.Button&&l instanceof YAHOO.widget.Button){l.destroy();}else{if(l.tagName.toUpperCase()=="BUTTON"){b.purgeElement(l);b.purgeElement(l,false);}}}while(j--);}}}YAHOO.extend(a,YAHOO.widget.Panel,{form:null,initDefaultConfig:function(){a.superclass.initDefaultConfig.call(this);this.callback={success:null,failure:null,argument:null};this.cfg.addProperty(c.POST_METHOD.key,{handler:this.configPostMethod,value:c.POST_METHOD.value,validator:function(i){if(i!="form"&&i!="async"&&i!="none"&&i!="manual"){return false;}else{return true;}}});this.cfg.addProperty(c.POST_DATA.key,{value:c.POST_DATA.value});this.cfg.addProperty(c.HIDEAFTERSUBMIT.key,{value:c.HIDEAFTERSUBMIT.value});this.cfg.addProperty(c.BUTTONS.key,{handler:this.configButtons,value:c.BUTTONS.value,supercedes:c.BUTTONS.supercedes});},initEvents:function(){a.superclass.initEvents.call(this);var i=g.LIST;this.beforeSubmitEvent=this.createEvent(h.BEFORE_SUBMIT);this.beforeSubmitEvent.signature=i;this.submitEvent=this.createEvent(h.SUBMIT);this.submitEvent.signature=i;this.manualSubmitEvent=this.createEvent(h.MANUAL_SUBMIT);this.manualSubmitEvent.signature=i;this.asyncSubmitEvent=this.createEvent(h.ASYNC_SUBMIT);this.asyncSubmitEvent.signature=i;this.formSubmitEvent=this.createEvent(h.FORM_SUBMIT);this.formSubmitEvent.signature=i;this.cancelEvent=this.createEvent(h.CANCEL);this.cancelEvent.signature=i;},init:function(j,i){a.superclass.init.call(this,j);this.beforeInitEvent.fire(a);e.addClass(this.element,a.CSS_DIALOG);this.cfg.setProperty("visible",false);if(i){this.cfg.applyConfig(i,true);}this.beforeHideEvent.subscribe(this.blurButtons,this,true);this.subscribe("changeBody",this.registerForm);this.initEvent.fire(a);},doSubmit:function(){var q=YAHOO.util.Connect,r=this.form,l=false,o=false,s,n,m,j;switch(this.cfg.getProperty("postmethod")){case"async":s=r.elements;n=s.length;if(n>0){m=n-1;do{if(s[m].type=="file"){l=true;break;}}while(m--);}if(l&&YAHOO.env.ua.ie&&this.isSecure){o=true;}j=this._getFormAttributes(r);q.setForm(r,l,o);var k=this.cfg.getProperty("postdata");var p=q.asyncRequest(j.method,j.action,this.callback,k);this.asyncSubmitEvent.fire(p);break;case"form":r.submit();this.formSubmitEvent.fire();break;case"none":case"manual":this.manualSubmitEvent.fire();break;}},_getFormAttributes:function(k){var i={method:null,action:null};if(k){if(k.getAttributeNode){var j=k.getAttributeNode("action");var l=k.getAttributeNode("method");if(j){i.action=j.value;}if(l){i.method=l.value;}}else{i.action=k.getAttribute("action");i.method=k.getAttribute("method");}}i.method=(f.isString(i.method)?i.method:"POST").toUpperCase();i.action=f.isString(i.action)?i.action:"";return i;},registerForm:function(){var i=this.element.getElementsByTagName("form")[0];if(this.form){if(this.form==i&&e.isAncestor(this.element,this.form)){return;}else{b.purgeElement(this.form);this.form=null;}}if(!i){i=document.createElement("form");i.name="frm_"+this.id;this.body.appendChild(i);}if(i){this.form=i;b.on(i,"submit",this._submitHandler,this,true);}},_submitHandler:function(i){b.stopEvent(i);this.submit();this.form.blur();},setTabLoop:function(i,j){i=i||this.firstButton;j=j||this.lastButton;a.superclass.setTabLoop.call(this,i,j);},_setTabLoop:function(i,j){i=i||this.firstButton;j=this.lastButton||j;this.setTabLoop(i,j);},setFirstLastFocusable:function(){a.superclass.setFirstLastFocusable.call(this);var k,j,m,n=this.focusableElements;this.firstFormElement=null;this.lastFormElement=null;if(this.form&&n&&n.length>0){j=n.length;for(k=0;k<j;++k){m=n[k];if(this.form===m.form){this.firstFormElement=m;break;}}for(k=j-1;k>=0;--k){m=n[k];if(this.form===m.form){this.lastFormElement=m;break;}}}},configClose:function(j,i,k){a.superclass.configClose.apply(this,arguments);},_doClose:function(i){b.preventDefault(i);this.cancel();},configButtons:function(t,s,n){var o=YAHOO.widget.Button,v=s[0],l=this.innerElement,u,q,k,r,p,j,m;d.call(this);this._aButtons=null;if(f.isArray(v)){p=document.createElement("span");p.className="button-group";r=v.length;this._aButtons=[];this.defaultHtmlButton=null;for(m=0;m<r;m++){u=v[m];if(o){k=new o({label:u.text,type:u.type});k.appendTo(p);q=k.get("element");if(u.isDefault){k.addClass("default");this.defaultHtmlButton=q;}if(f.isFunction(u.handler)){k.set("onclick",{fn:u.handler,obj:this,scope:this});}else{if(f.isObject(u.handler)&&f.isFunction(u.handler.fn)){k.set("onclick",{fn:u.handler.fn,obj:((!f.isUndefined(u.handler.obj))?u.handler.obj:this),scope:(u.handler.scope||this)});}}this._aButtons[this._aButtons.length]=k;}else{q=document.createElement("button");q.setAttribute("type","button");if(u.isDefault){q.className="default";this.defaultHtmlButton=q;}q.innerHTML=u.text;if(f.isFunction(u.handler)){b.on(q,"click",u.handler,this,true);}else{if(f.isObject(u.handler)&&f.isFunction(u.handler.fn)){b.on(q,"click",u.handler.fn,((!f.isUndefined(u.handler.obj))?u.handler.obj:this),(u.handler.scope||this));}}p.appendChild(q);this._aButtons[this._aButtons.length]=q;}u.htmlButton=q;if(m===0){this.firstButton=q;}if(m==(r-1)){this.lastButton=q;}}this.setFooter(p);j=this.footer;if(e.inDocument(this.element)&&!e.isAncestor(l,j)){l.appendChild(j);}this.buttonSpan=p;}else{p=this.buttonSpan;
j=this.footer;if(p&&j){j.removeChild(p);this.buttonSpan=null;this.firstButton=null;this.lastButton=null;this.defaultHtmlButton=null;}}this.changeContentEvent.fire();},getButtons:function(){return this._aButtons||null;},focusFirst:function(k,i,n){var j=this.firstFormElement,m=false;if(i&&i[1]){b.stopEvent(i[1]);if(i[0]===9&&this.firstElement){j=this.firstElement;}}if(j){try{j.focus();m=true;}catch(l){}}else{if(this.defaultHtmlButton){m=this.focusDefaultButton();}else{m=this.focusFirstButton();}}return m;},focusLast:function(k,i,n){var o=this.cfg.getProperty("buttons"),j=this.lastFormElement,m=false;if(i&&i[1]){b.stopEvent(i[1]);if(i[0]===9&&this.lastElement){j=this.lastElement;}}if(o&&f.isArray(o)){m=this.focusLastButton();}else{if(j){try{j.focus();m=true;}catch(l){}}}return m;},_getButton:function(j){var i=YAHOO.widget.Button;if(i&&j&&j.nodeName&&j.id){j=i.getButton(j.id)||j;}return j;},focusDefaultButton:function(){var i=this._getButton(this.defaultHtmlButton),k=false;if(i){try{i.focus();k=true;}catch(j){}}return k;},blurButtons:function(){var o=this.cfg.getProperty("buttons"),l,n,k,j;if(o&&f.isArray(o)){l=o.length;if(l>0){j=(l-1);do{n=o[j];if(n){k=this._getButton(n.htmlButton);if(k){try{k.blur();}catch(m){}}}}while(j--);}}},focusFirstButton:function(){var m=this.cfg.getProperty("buttons"),k,i,l=false;if(m&&f.isArray(m)){k=m[0];if(k){i=this._getButton(k.htmlButton);if(i){try{i.focus();l=true;}catch(j){}}}}return l;},focusLastButton:function(){var n=this.cfg.getProperty("buttons"),j,l,i,m=false;if(n&&f.isArray(n)){j=n.length;if(j>0){l=n[(j-1)];if(l){i=this._getButton(l.htmlButton);if(i){try{i.focus();m=true;}catch(k){}}}}}return m;},configPostMethod:function(j,i,k){this.registerForm();},validate:function(){return true;},submit:function(){if(this.validate()){if(this.beforeSubmitEvent.fire()){this.doSubmit();this.submitEvent.fire();if(this.cfg.getProperty("hideaftersubmit")){this.hide();}return true;}else{return false;}}else{return false;}},cancel:function(){this.cancelEvent.fire();this.hide();},getData:function(){var A=this.form,k,t,w,m,u,r,q,j,x,l,y,B,p,C,o,z,v;function s(n){var i=n.tagName.toUpperCase();return((i=="INPUT"||i=="TEXTAREA"||i=="SELECT")&&n.name==m);}if(A){k=A.elements;t=k.length;w={};for(z=0;z<t;z++){m=k[z].name;u=e.getElementsBy(s,"*",A);r=u.length;if(r>0){if(r==1){u=u[0];q=u.type;j=u.tagName.toUpperCase();switch(j){case"INPUT":if(q=="checkbox"){w[m]=u.checked;}else{if(q!="radio"){w[m]=u.value;}}break;case"TEXTAREA":w[m]=u.value;break;case"SELECT":x=u.options;l=x.length;y=[];for(v=0;v<l;v++){B=x[v];if(B.selected){o=B.attributes.value;y[y.length]=(o&&o.specified)?B.value:B.text;}}w[m]=y;break;}}else{q=u[0].type;switch(q){case"radio":for(v=0;v<r;v++){p=u[v];if(p.checked){w[m]=p.value;break;}}break;case"checkbox":y=[];for(v=0;v<r;v++){C=u[v];if(C.checked){y[y.length]=C.value;}}w[m]=y;break;}}}}}return w;},destroy:function(i){d.call(this);this._aButtons=null;var j=this.element.getElementsByTagName("form"),k;if(j.length>0){k=j[0];if(k){b.purgeElement(k);if(k.parentNode){k.parentNode.removeChild(k);}this.form=null;}}a.superclass.destroy.call(this,i);},toString:function(){return"Dialog "+this.id;}});}());(function(){YAHOO.widget.SimpleDialog=function(e,d){YAHOO.widget.SimpleDialog.superclass.constructor.call(this,e,d);};var c=YAHOO.util.Dom,b=YAHOO.widget.SimpleDialog,a={"ICON":{key:"icon",value:"none",suppressEvent:true},"TEXT":{key:"text",value:"",suppressEvent:true,supercedes:["icon"]}};b.ICON_BLOCK="blckicon";b.ICON_ALARM="alrticon";b.ICON_HELP="hlpicon";b.ICON_INFO="infoicon";b.ICON_WARN="warnicon";b.ICON_TIP="tipicon";b.ICON_CSS_CLASSNAME="yui-icon";b.CSS_SIMPLEDIALOG="yui-simple-dialog";YAHOO.extend(b,YAHOO.widget.Dialog,{initDefaultConfig:function(){b.superclass.initDefaultConfig.call(this);this.cfg.addProperty(a.ICON.key,{handler:this.configIcon,value:a.ICON.value,suppressEvent:a.ICON.suppressEvent});this.cfg.addProperty(a.TEXT.key,{handler:this.configText,value:a.TEXT.value,suppressEvent:a.TEXT.suppressEvent,supercedes:a.TEXT.supercedes});},init:function(e,d){b.superclass.init.call(this,e);this.beforeInitEvent.fire(b);c.addClass(this.element,b.CSS_SIMPLEDIALOG);this.cfg.queueProperty("postmethod","manual");if(d){this.cfg.applyConfig(d,true);}this.beforeRenderEvent.subscribe(function(){if(!this.body){this.setBody("");}},this,true);this.initEvent.fire(b);},registerForm:function(){b.superclass.registerForm.call(this);var e=this.form.ownerDocument,d=e.createElement("input");d.type="hidden";d.name=this.id;d.value="";this.form.appendChild(d);},configIcon:function(k,j,h){var d=j[0],e=this.body,f=b.ICON_CSS_CLASSNAME,l,i,g;if(d&&d!="none"){l=c.getElementsByClassName(f,"*",e);if(l.length===1){i=l[0];g=i.parentNode;if(g){g.removeChild(i);i=null;}}if(d.indexOf(".")==-1){i=document.createElement("span");i.className=(f+" "+d);i.innerHTML="&#160;";}else{i=document.createElement("img");i.src=(this.imageRoot+d);i.className=f;}if(i){e.insertBefore(i,e.firstChild);}}},configText:function(e,d,f){var g=d[0];if(g){this.setBody(g);this.cfg.refireEvent("icon");}},toString:function(){return"SimpleDialog "+this.id;}});}());(function(){YAHOO.widget.ContainerEffect=function(e,h,g,d,f){if(!f){f=YAHOO.util.Anim;}this.overlay=e;this.attrIn=h;this.attrOut=g;this.targetElement=d||e.element;this.animClass=f;};var b=YAHOO.util.Dom,c=YAHOO.util.CustomEvent,a=YAHOO.widget.ContainerEffect;a.FADE=function(d,f){var g=YAHOO.util.Easing,i={attributes:{opacity:{from:0,to:1}},duration:f,method:g.easeIn},e={attributes:{opacity:{to:0}},duration:f,method:g.easeOut},h=new a(d,i,e,d.element);h.handleUnderlayStart=function(){var k=this.overlay.underlay;if(k&&YAHOO.env.ua.ie){var j=(k.filters&&k.filters.length>0);if(j){b.addClass(d.element,"yui-effect-fade");}}};h.handleUnderlayComplete=function(){var j=this.overlay.underlay;if(j&&YAHOO.env.ua.ie){b.removeClass(d.element,"yui-effect-fade");}};h.handleStartAnimateIn=function(k,j,l){l.overlay._fadingIn=true;b.addClass(l.overlay.element,"hide-select");if(!l.overlay.underlay){l.overlay.cfg.refireEvent("underlay");
}l.handleUnderlayStart();l.overlay._setDomVisibility(true);b.setStyle(l.overlay.element,"opacity",0);};h.handleCompleteAnimateIn=function(k,j,l){l.overlay._fadingIn=false;b.removeClass(l.overlay.element,"hide-select");if(l.overlay.element.style.filter){l.overlay.element.style.filter=null;}l.handleUnderlayComplete();l.overlay.cfg.refireEvent("iframe");l.animateInCompleteEvent.fire();};h.handleStartAnimateOut=function(k,j,l){l.overlay._fadingOut=true;b.addClass(l.overlay.element,"hide-select");l.handleUnderlayStart();};h.handleCompleteAnimateOut=function(k,j,l){l.overlay._fadingOut=false;b.removeClass(l.overlay.element,"hide-select");if(l.overlay.element.style.filter){l.overlay.element.style.filter=null;}l.overlay._setDomVisibility(false);b.setStyle(l.overlay.element,"opacity",1);l.handleUnderlayComplete();l.overlay.cfg.refireEvent("iframe");l.animateOutCompleteEvent.fire();};h.init();return h;};a.SLIDE=function(f,d){var i=YAHOO.util.Easing,l=f.cfg.getProperty("x")||b.getX(f.element),k=f.cfg.getProperty("y")||b.getY(f.element),m=b.getClientWidth(),h=f.element.offsetWidth,j={attributes:{points:{to:[l,k]}},duration:d,method:i.easeIn},e={attributes:{points:{to:[(m+25),k]}},duration:d,method:i.easeOut},g=new a(f,j,e,f.element,YAHOO.util.Motion);g.handleStartAnimateIn=function(o,n,p){p.overlay.element.style.left=((-25)-h)+"px";p.overlay.element.style.top=k+"px";};g.handleTweenAnimateIn=function(q,p,r){var s=b.getXY(r.overlay.element),o=s[0],n=s[1];if(b.getStyle(r.overlay.element,"visibility")=="hidden"&&o<l){r.overlay._setDomVisibility(true);}r.overlay.cfg.setProperty("xy",[o,n],true);r.overlay.cfg.refireEvent("iframe");};g.handleCompleteAnimateIn=function(o,n,p){p.overlay.cfg.setProperty("xy",[l,k],true);p.startX=l;p.startY=k;p.overlay.cfg.refireEvent("iframe");p.animateInCompleteEvent.fire();};g.handleStartAnimateOut=function(o,n,r){var p=b.getViewportWidth(),s=b.getXY(r.overlay.element),q=s[1];r.animOut.attributes.points.to=[(p+25),q];};g.handleTweenAnimateOut=function(p,o,q){var s=b.getXY(q.overlay.element),n=s[0],r=s[1];q.overlay.cfg.setProperty("xy",[n,r],true);q.overlay.cfg.refireEvent("iframe");};g.handleCompleteAnimateOut=function(o,n,p){p.overlay._setDomVisibility(false);p.overlay.cfg.setProperty("xy",[l,k]);p.animateOutCompleteEvent.fire();};g.init();return g;};a.prototype={init:function(){this.beforeAnimateInEvent=this.createEvent("beforeAnimateIn");this.beforeAnimateInEvent.signature=c.LIST;this.beforeAnimateOutEvent=this.createEvent("beforeAnimateOut");this.beforeAnimateOutEvent.signature=c.LIST;this.animateInCompleteEvent=this.createEvent("animateInComplete");this.animateInCompleteEvent.signature=c.LIST;this.animateOutCompleteEvent=this.createEvent("animateOutComplete");this.animateOutCompleteEvent.signature=c.LIST;this.animIn=new this.animClass(this.targetElement,this.attrIn.attributes,this.attrIn.duration,this.attrIn.method);this.animIn.onStart.subscribe(this.handleStartAnimateIn,this);this.animIn.onTween.subscribe(this.handleTweenAnimateIn,this);this.animIn.onComplete.subscribe(this.handleCompleteAnimateIn,this);this.animOut=new this.animClass(this.targetElement,this.attrOut.attributes,this.attrOut.duration,this.attrOut.method);this.animOut.onStart.subscribe(this.handleStartAnimateOut,this);this.animOut.onTween.subscribe(this.handleTweenAnimateOut,this);this.animOut.onComplete.subscribe(this.handleCompleteAnimateOut,this);},animateIn:function(){this._stopAnims(this.lastFrameOnStop);this.beforeAnimateInEvent.fire();this.animIn.animate();},animateOut:function(){this._stopAnims(this.lastFrameOnStop);this.beforeAnimateOutEvent.fire();this.animOut.animate();},lastFrameOnStop:true,_stopAnims:function(d){if(this.animOut&&this.animOut.isAnimated()){this.animOut.stop(d);}if(this.animIn&&this.animIn.isAnimated()){this.animIn.stop(d);}},handleStartAnimateIn:function(e,d,f){},handleTweenAnimateIn:function(e,d,f){},handleCompleteAnimateIn:function(e,d,f){},handleStartAnimateOut:function(e,d,f){},handleTweenAnimateOut:function(e,d,f){},handleCompleteAnimateOut:function(e,d,f){},toString:function(){var d="ContainerEffect";if(this.overlay){d+=" ["+this.overlay.toString()+"]";}return d;}};YAHOO.lang.augmentProto(a,YAHOO.util.EventProvider);})();YAHOO.register("container",YAHOO.widget.Module,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/container/container-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
var Y=YAHOO,Y_DOM=YAHOO.util.Dom,EMPTY_ARRAY=[],Y_UA=Y.env.ua,Y_Lang=Y.lang,Y_DOC=document,Y_DOCUMENT_ELEMENT=Y_DOC.documentElement,Y_DOM_inDoc=Y_DOM.inDocument,Y_mix=Y_Lang.augmentObject,Y_guid=Y_DOM.generateId,Y_getDoc=function(a){var b=Y_DOC;if(a){b=(a.nodeType===9)?a:a.ownerDocument||a.document||Y_DOC;}return b;},Y_Array=function(g,d){var c,b,h=d||0;try{return Array.prototype.slice.call(g,h);}catch(f){b=[];c=g.length;for(;h<c;h++){b.push(g[h]);}return b;}},Y_DOM_allById=function(f,a){a=a||Y_DOC;var b=[],c=[],d,e;if(a.querySelectorAll){c=a.querySelectorAll('[id="'+f+'"]');}else{if(a.all){b=a.all(f);if(b){if(b.nodeName){if(b.id===f){c.push(b);b=EMPTY_ARRAY;}else{b=[b];}}if(b.length){for(d=0;e=b[d++];){if(e.id===f||(e.attributes&&e.attributes.id&&e.attributes.id.value===f)){c.push(e);}}}}}else{c=[Y_getDoc(a).getElementById(f)];}}return c;};var COMPARE_DOCUMENT_POSITION="compareDocumentPosition",OWNER_DOCUMENT="ownerDocument",Selector={_foundCache:[],useNative:true,_compare:("sourceIndex" in Y_DOCUMENT_ELEMENT)?function(f,e){var d=f.sourceIndex,c=e.sourceIndex;if(d===c){return 0;}else{if(d>c){return 1;}}return -1;}:(Y_DOCUMENT_ELEMENT[COMPARE_DOCUMENT_POSITION]?function(b,a){if(b[COMPARE_DOCUMENT_POSITION](a)&4){return -1;}else{return 1;}}:function(e,d){var c,a,b;if(e&&d){c=e[OWNER_DOCUMENT].createRange();c.setStart(e,0);a=d[OWNER_DOCUMENT].createRange();a.setStart(d,0);b=c.compareBoundaryPoints(1,a);}return b;}),_sort:function(a){if(a){a=Y_Array(a,0,true);if(a.sort){a.sort(Selector._compare);}}return a;},_deDupe:function(a){var b=[],c,d;for(c=0;(d=a[c++]);){if(!d._found){b[b.length]=d;d._found=true;}}for(c=0;(d=b[c++]);){d._found=null;d.removeAttribute("_found");}return b;},query:function(b,j,k,a){if(j&&typeof j=="string"){j=Y_DOM.get(j);if(!j){return(k)?null:[];}}else{j=j||Y_DOC;}var f=[],c=(Selector.useNative&&Y_DOC.querySelector&&!a),e=[[b,j]],g,l,d,h=(c)?Selector._nativeQuery:Selector._bruteQuery;if(b&&h){if(!a&&(!c||j.tagName)){e=Selector._splitQueries(b,j);}for(d=0;(g=e[d++]);){l=h(g[0],g[1],k);if(!k){l=Y_Array(l,0,true);}if(l){f=f.concat(l);}}if(e.length>1){f=Selector._sort(Selector._deDupe(f));}}return(k)?(f[0]||null):f;},_splitQueries:function(c,f){var b=c.split(","),d=[],g="",e,a;if(f){if(f.tagName){f.id=f.id||Y_guid();g='[id="'+f.id+'"] ';}for(e=0,a=b.length;e<a;++e){c=g+b[e];d.push([c,f]);}}return d;},_nativeQuery:function(a,b,c){if(Y_UA.webkit&&a.indexOf(":checked")>-1&&(Selector.pseudos&&Selector.pseudos.checked)){return Selector.query(a,b,c,true);}try{return b["querySelector"+(c?"":"All")](a);}catch(d){return Selector.query(a,b,c,true);}},filter:function(b,a){var c=[],d,e;if(b&&a){for(d=0;(e=b[d++]);){if(Selector.test(e,a)){c[c.length]=e;}}}else{}return c;},test:function(c,d,k){var g=false,b=d.split(","),a=false,l,o,h,n,f,e,m;if(c&&c.tagName){if(!k&&!Y_DOM_inDoc(c)){l=c.parentNode;if(l){k=l;}else{n=c[OWNER_DOCUMENT].createDocumentFragment();n.appendChild(c);k=n;a=true;}}k=k||c[OWNER_DOCUMENT];if(!c.id){c.id=Y_guid();}for(f=0;(m=b[f++]);){m+='[id="'+c.id+'"]';h=Selector.query(m,k);for(e=0;o=h[e++];){if(o===c){g=true;break;}}if(g){break;}}if(a){n.removeChild(c);}}return g;}};YAHOO.util.Selector=Selector;var PARENT_NODE="parentNode",TAG_NAME="tagName",ATTRIBUTES="attributes",COMBINATOR="combinator",PSEUDOS="pseudos",SelectorCSS2={_reRegExpTokens:/([\^\$\?\[\]\*\+\-\.\(\)\|\\])/,SORT_RESULTS:true,_children:function(e,a){var b=e.children,d,c=[],f,g;if(e.children&&a&&e.children.tags){c=e.children.tags(a);}else{if((!b&&e[TAG_NAME])||(b&&a)){f=b||e.childNodes;b=[];for(d=0;(g=f[d++]);){if(g.tagName){if(!a||a===g.tagName){b.push(g);}}}}}return b||[];},_re:{attr:/(\[[^\]]*\])/g,esc:/\\[:\[\]\(\)#\.\'\>+~"]/gi,pseudos:/(\([^\)]*\))/g},shorthand:{"\\#(-?[_a-z]+[-\\w\\uE000]*)":"[id=$1]","\\.(-?[_a-z]+[-\\w\\uE000]*)":"[className~=$1]"},operators:{"":function(b,a){return !!b.getAttribute(a);},"~=":"(?:^|\\s+){val}(?:\\s+|$)","|=":"^{val}(?:-|$)"},pseudos:{"first-child":function(a){return Selector._children(a[PARENT_NODE])[0]===a;}},_bruteQuery:function(f,j,l){var g=[],a=[],i=Selector._tokenize(f),e=i[i.length-1],k=Y_getDoc(j),c,b,h,d;if(e){b=e.id;h=e.className;d=e.tagName||"*";if(j.getElementsByTagName){if(b&&(j.all||(j.nodeType===9||Y_DOM_inDoc(j)))){a=Y_DOM_allById(b,j);}else{if(h){a=j.getElementsByClassName(h);}else{a=j.getElementsByTagName(d);}}}else{c=j.firstChild;while(c){if(c.tagName){a.push(c);}c=c.nextSilbing||c.firstChild;}}if(a.length){g=Selector._filterNodes(a,i,l);}}return g;},_filterNodes:function(l,f,h){var r=0,q,s=f.length,k=s-1,e=[],o=l[0],v=o,t=Selector.getters,d,p,c,g,a,m,b,u;for(r=0;(v=o=l[r++]);){k=s-1;g=null;testLoop:while(v&&v.tagName){c=f[k];b=c.tests;q=b.length;if(q&&!a){while((u=b[--q])){d=u[1];if(t[u[0]]){m=t[u[0]](v,u[0]);}else{m=v[u[0]];if(m===undefined&&v.getAttribute){m=v.getAttribute(u[0]);}}if((d==="="&&m!==u[2])||(typeof d!=="string"&&d.test&&!d.test(m))||(!d.test&&typeof d==="function"&&!d(v,u[0],u[2]))){if((v=v[g])){while(v&&(!v.tagName||(c.tagName&&c.tagName!==v.tagName))){v=v[g];}}continue testLoop;}}}k--;if(!a&&(p=c.combinator)){g=p.axis;v=v[g];while(v&&!v.tagName){v=v[g];}if(p.direct){g=null;}}else{e.push(o);if(h){return e;}break;}}}o=v=null;return e;},combinators:{" ":{axis:"parentNode"},">":{axis:"parentNode",direct:true},"+":{axis:"previousSibling",direct:true}},_parsers:[{name:ATTRIBUTES,re:/^\uE003(-?[a-z]+[\w\-]*)+([~\|\^\$\*!=]=?)?['"]?([^\uE004'"]*)['"]?\uE004/i,fn:function(d,e){var c=d[2]||"",a=Selector.operators,b=(d[3])?d[3].replace(/\\/g,""):"",f;if((d[1]==="id"&&c==="=")||(d[1]==="className"&&Y_DOCUMENT_ELEMENT.getElementsByClassName&&(c==="~="||c==="="))){e.prefilter=d[1];d[3]=b;e[d[1]]=(d[1]==="id")?d[3]:b;}if(c in a){f=a[c];if(typeof f==="string"){d[3]=b.replace(Selector._reRegExpTokens,"\\$1");f=new RegExp(f.replace("{val}",d[3]));}d[2]=f;}if(!e.last||e.prefilter!==d[1]){return d.slice(1);}}},{name:TAG_NAME,re:/^((?:-?[_a-z]+[\w-]*)|\*)/i,fn:function(b,c){var a=b[1].toUpperCase();c.tagName=a;if(a!=="*"&&(!c.last||c.prefilter)){return[TAG_NAME,"=",a];
}if(!c.prefilter){c.prefilter="tagName";}}},{name:COMBINATOR,re:/^\s*([>+~]|\s)\s*/,fn:function(a,b){}},{name:PSEUDOS,re:/^:([\-\w]+)(?:\uE005['"]?([^\uE005]*)['"]?\uE006)*/i,fn:function(a,b){var c=Selector[PSEUDOS][a[1]];if(c){if(a[2]){a[2]=a[2].replace(/\\/g,"");}return[a[2],c];}else{return false;}}}],_getToken:function(a){return{tagName:null,id:null,className:null,attributes:{},combinator:null,tests:[]};},_tokenize:function(c){c=c||"";c=Selector._replaceShorthand(Y_Lang.trim(c));var b=Selector._getToken(),h=c,g=[],j=false,e,f,d,a;outer:do{j=false;for(d=0;(a=Selector._parsers[d++]);){if((e=a.re.exec(c))){if(a.name!==COMBINATOR){b.selector=c;}c=c.replace(e[0],"");if(!c.length){b.last=true;}if(Selector._attrFilters[e[1]]){e[1]=Selector._attrFilters[e[1]];}f=a.fn(e,b);if(f===false){j=false;break outer;}else{if(f){b.tests.push(f);}}if(!c.length||a.name===COMBINATOR){g.push(b);b=Selector._getToken(b);if(a.name===COMBINATOR){b.combinator=Selector.combinators[e[1]];}}j=true;}}}while(j&&c.length);if(!j||c.length){g=[];}return g;},_replaceShorthand:function(b){var d=Selector.shorthand,c=b.match(Selector._re.esc),e,h,g,f,a;if(c){b=b.replace(Selector._re.esc,"\uE000");}e=b.match(Selector._re.attr);h=b.match(Selector._re.pseudos);if(e){b=b.replace(Selector._re.attr,"\uE001");}if(h){b=b.replace(Selector._re.pseudos,"\uE002");}for(g in d){if(d.hasOwnProperty(g)){b=b.replace(new RegExp(g,"gi"),d[g]);}}if(e){for(f=0,a=e.length;f<a;++f){b=b.replace(/\uE001/,e[f]);}}if(h){for(f=0,a=h.length;f<a;++f){b=b.replace(/\uE002/,h[f]);}}b=b.replace(/\[/g,"\uE003");b=b.replace(/\]/g,"\uE004");b=b.replace(/\(/g,"\uE005");b=b.replace(/\)/g,"\uE006");if(c){for(f=0,a=c.length;f<a;++f){b=b.replace("\uE000",c[f]);}}return b;},_attrFilters:{"class":"className","for":"htmlFor"},getters:{href:function(b,a){return Y_DOM.getAttribute(b,a);}}};Y_mix(Selector,SelectorCSS2,true);Selector.getters.src=Selector.getters.rel=Selector.getters.href;if(Selector.useNative&&Y_DOC.querySelector){Selector.shorthand["\\.([^\\s\\\\(\\[:]*)"]="[class~=$1]";}Selector._reNth=/^(?:([\-]?\d*)(n){1}|(odd|even)$)*([\-+]?\d*)$/;Selector._getNth=function(d,o,q,h){Selector._reNth.test(o);var m=parseInt(RegExp.$1,10),c=RegExp.$2,j=RegExp.$3,k=parseInt(RegExp.$4,10)||0,p=[],l=Selector._children(d.parentNode,q),f;if(j){m=2;f="+";c="n";k=(j==="odd")?1:0;}else{if(isNaN(m)){m=(c)?1:0;}}if(m===0){if(h){k=l.length-k+1;}if(l[k-1]===d){return true;}else{return false;}}else{if(m<0){h=!!h;m=Math.abs(m);}}if(!h){for(var e=k-1,g=l.length;e<g;e+=m){if(e>=0&&l[e]===d){return true;}}}else{for(var e=l.length-k,g=l.length;e>=0;e-=m){if(e<g&&l[e]===d){return true;}}}return false;};Y_mix(Selector.pseudos,{"root":function(a){return a===a.ownerDocument.documentElement;},"nth-child":function(a,b){return Selector._getNth(a,b);},"nth-last-child":function(a,b){return Selector._getNth(a,b,null,true);},"nth-of-type":function(a,b){return Selector._getNth(a,b,a.tagName);},"nth-last-of-type":function(a,b){return Selector._getNth(a,b,a.tagName,true);},"last-child":function(b){var a=Selector._children(b.parentNode);return a[a.length-1]===b;},"first-of-type":function(a){return Selector._children(a.parentNode,a.tagName)[0]===a;},"last-of-type":function(b){var a=Selector._children(b.parentNode,b.tagName);return a[a.length-1]===b;},"only-child":function(b){var a=Selector._children(b.parentNode);return a.length===1&&a[0]===b;},"only-of-type":function(b){var a=Selector._children(b.parentNode,b.tagName);return a.length===1&&a[0]===b;},"empty":function(a){return a.childNodes.length===0;},"not":function(a,b){return !Selector.test(a,b);},"contains":function(a,b){var c=a.innerText||a.textContent||"";return c.indexOf(b)>-1;},"checked":function(a){return(a.checked===true||a.selected===true);},enabled:function(a){return(a.disabled!==undefined&&!a.disabled);},disabled:function(a){return(a.disabled);}});Y_mix(Selector.operators,{"^=":"^{val}","!=":function(b,a,c){return b[a]!==c;},"$=":"{val}$","*=":"{val}"});Selector.combinators["~"]={axis:"previousSibling"};YAHOO.register("selector",YAHOO.util.Selector,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/selector/selector-min.js
                                

/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * @class a YAHOO.util.DDProxy implementation. During the drag over event, the
 * dragged element is inserted before the dragged-over element.
 *
 * @extends YAHOO.util.DDProxy
 * @constructor
 * @param {String} id the id of the linked element
 * @param {String} sGroup the group of related DragDrop objects
 */
function ygDDList(id, sGroup) {

	if (id) {
		this.init(id, sGroup);
		this.initFrame();
		//this.logger = new ygLogger("ygDDList");
	}

	var s = this.getDragEl().style;
	s.borderColor = "transparent";
	s.backgroundColor = "#f6f5e5";
	s.opacity = 0.76;
	s.filter = "alpha(opacity=76)";
}

ygDDList.prototype = new YAHOO.util.DDProxy();

ygDDList.prototype.borderDiv = null;
ygDDList.prototype.originalDisplayProperties = Array();

ygDDList.prototype.startDrag = function(x, y) {
	//this.logger.debug(this.id + " startDrag");

	var dragEl = this.getDragEl();
	var clickEl = this.getEl();

	dragEl.innerHTML = clickEl.innerHTML;
	dragElObjects = dragEl.getElementsByTagName('object');

	
	dragEl.className = clickEl.className;
	dragEl.style.color = clickEl.style.color;
	dragEl.style.border = "1px solid #aaa";

	// save the style of the object 
	clickElRegion = YAHOO.util.Dom.getRegion(clickEl);
	
	this.borderDiv = document.createElement('div'); // create a div to display border
	this.borderDiv.style.height = (clickElRegion.bottom - clickElRegion.top) + 'px';
	this.borderDiv.style.border = '2px dashed #cccccc';
	
	for(i in clickEl.childNodes) { // hide contents of the target elements contents
		if(typeof clickEl.childNodes[i].style != 'undefined') {
			this.originalDisplayProperties[i] = clickEl.childNodes[i].style.display;
			clickEl.childNodes[i].style.display = 'none';
		}

	}
	clickEl.appendChild(this.borderDiv);
};

ygDDList.prototype.endDrag = function(e) {
	// disable moving the linked element
	var clickEl = this.getEl();

	clickEl.removeChild(this.borderDiv); // remove border div
	
	for(i in clickEl.childNodes) { // show target elements contents
		if(typeof clickEl.childNodes[i].style != 'undefined') {
			clickEl.childNodes[i].style.display = this.originalDisplayProperties[i];
		}
	}
	
	if(this.clickHeight) 
	    clickEl.style.height = this.clickHeight;
	else 
		clickEl.style.height = '';
	
	if(this.clickBorder) 
	    clickEl.style.border = this.clickBorder;
	else 
		clickEl.style.border = '';
		
	dragEl = this.getDragEl();
	dragEl.innerHTML = '';

	this.afterEndDrag(e);
};

ygDDList.prototype.afterEndDrag = function(e) {

}

ygDDList.prototype.onDrag = function(e, id) {
    
};

ygDDList.prototype.onDragOver = function(e, id) {
	// this.logger.debug(this.id.toString() + " onDragOver " + id);
	var el;
        
    if ("string" == typeof id) {
        el = YAHOO.util.DDM.getElement(id);
    } else { 
        el = YAHOO.util.DDM.getBestMatch(id).getEl();
    }
    
	dragEl = this.getDragEl();
	elRegion = YAHOO.util.Dom.getRegion(el);
	    
//    this.logger.debug('id: ' + el.id);
//    this.logger.debug('size: ' + (elRegion.bottom - elRegion.top));
//    this.logger.debug('getPosY: ' + YAHOO.util.DDM.getPosY(el));
	var mid = YAHOO.util.DDM.getPosY(el) + (Math.floor((elRegion.bottom - elRegion.top) / 2));
//    this.logger.debug('mid: ' + mid);
    	
//    this.logger.debug(YAHOO.util.DDM.getPosY(dragEl) + " <  " + mid);
//    this.logger.debug("Y: " + YAHOO.util.Event.getPageY(e));
	
	if (YAHOO.util.DDM.getPosY(dragEl) < mid ) { // insert on top triggering item
		var el2 = this.getEl();
		var p = el.parentNode;
		p.insertBefore(el2, el);
	}
	if (YAHOO.util.DDM.getPosY(dragEl) >= mid ) { // insert below triggered item
		var el2 = this.getEl();
		var p = el.parentNode;
		p.insertBefore(el2, el.nextSibling);
	}
};

ygDDList.prototype.onDragEnter = function(e, id) {
	// this.logger.debug(this.id.toString() + " onDragEnter " + id);
	// this.getDragEl().style.border = "1px solid #449629";
};

ygDDList.prototype.onDragOut = function(e, id) {
    // I need to know when we are over nothing
	// this.getDragEl().style.border = "1px solid #964428";
}

/////////////////////////////////////////////////////////////////////////////

function ygDDListBoundary(id, sGroup) {
	if (id) {
		this.init(id, sGroup);
		//this.logger = new ygLogger("ygDDListBoundary");
		this.isBoundary = true;
	}
}

ygDDListBoundary.prototype = new YAHOO.util.DDTarget();
// End of File include/javascript/yui/ygDDList.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
(function(){var lang=YAHOO.lang,util=YAHOO.util,Ev=util.Event;util.DataSourceBase=function(oLiveData,oConfigs){if(oLiveData===null||oLiveData===undefined){return;}this.liveData=oLiveData;this._oQueue={interval:null,conn:null,requests:[]};this.responseSchema={};if(oConfigs&&(oConfigs.constructor==Object)){for(var sConfig in oConfigs){if(sConfig){this[sConfig]=oConfigs[sConfig];}}}var maxCacheEntries=this.maxCacheEntries;if(!lang.isNumber(maxCacheEntries)||(maxCacheEntries<0)){maxCacheEntries=0;}this._aIntervals=[];this.createEvent("cacheRequestEvent");this.createEvent("cacheResponseEvent");this.createEvent("requestEvent");this.createEvent("responseEvent");this.createEvent("responseParseEvent");this.createEvent("responseCacheEvent");this.createEvent("dataErrorEvent");this.createEvent("cacheFlushEvent");var DS=util.DataSourceBase;this._sName="DataSource instance"+DS._nIndex;DS._nIndex++;};var DS=util.DataSourceBase;lang.augmentObject(DS,{TYPE_UNKNOWN:-1,TYPE_JSARRAY:0,TYPE_JSFUNCTION:1,TYPE_XHR:2,TYPE_JSON:3,TYPE_XML:4,TYPE_TEXT:5,TYPE_HTMLTABLE:6,TYPE_SCRIPTNODE:7,TYPE_LOCAL:8,ERROR_DATAINVALID:"Invalid data",ERROR_DATANULL:"Null data",_nIndex:0,_nTransactionId:0,_cloneObject:function(o){if(!lang.isValue(o)){return o;}var copy={};if(Object.prototype.toString.apply(o)==="[object RegExp]"){copy=o;}else{if(lang.isFunction(o)){copy=o;}else{if(lang.isArray(o)){var array=[];for(var i=0,len=o.length;i<len;i++){array[i]=DS._cloneObject(o[i]);}copy=array;}else{if(lang.isObject(o)){for(var x in o){if(lang.hasOwnProperty(o,x)){if(lang.isValue(o[x])&&lang.isObject(o[x])||lang.isArray(o[x])){copy[x]=DS._cloneObject(o[x]);}else{copy[x]=o[x];}}}}else{copy=o;}}}}return copy;},_getLocationValue:function(field,context){var locator=field.locator||field.key||field,xmldoc=context.ownerDocument||context,result,res,value=null;try{if(!lang.isUndefined(xmldoc.evaluate)){result=xmldoc.evaluate(locator,context,xmldoc.createNSResolver(!context.ownerDocument?context.documentElement:context.ownerDocument.documentElement),0,null);while(res=result.iterateNext()){value=res.textContent;}}else{xmldoc.setProperty("SelectionLanguage","XPath");result=context.selectNodes(locator)[0];value=result.value||result.text||null;}return value;}catch(e){}},issueCallback:function(callback,params,error,scope){if(lang.isFunction(callback)){callback.apply(scope,params);}else{if(lang.isObject(callback)){scope=callback.scope||scope||window;var callbackFunc=callback.success;if(error){callbackFunc=callback.failure;}if(callbackFunc){callbackFunc.apply(scope,params.concat([callback.argument]));}}}},parseString:function(oData){if(!lang.isValue(oData)){return null;}var string=oData+"";if(lang.isString(string)){return string;}else{return null;}},parseNumber:function(oData){if(!lang.isValue(oData)||(oData==="")){return null;}var number=oData*1;if(lang.isNumber(number)){return number;}else{return null;}},convertNumber:function(oData){return DS.parseNumber(oData);},parseDate:function(oData){var date=null;if(lang.isValue(oData)&&!(oData instanceof Date)){date=new Date(oData);}else{return oData;}if(date instanceof Date){return date;}else{return null;}},convertDate:function(oData){return DS.parseDate(oData);}});DS.Parser={string:DS.parseString,number:DS.parseNumber,date:DS.parseDate};DS.prototype={_sName:null,_aCache:null,_oQueue:null,_aIntervals:null,maxCacheEntries:0,liveData:null,dataType:DS.TYPE_UNKNOWN,responseType:DS.TYPE_UNKNOWN,responseSchema:null,useXPath:false,cloneBeforeCaching:false,toString:function(){return this._sName;},getCachedResponse:function(oRequest,oCallback,oCaller){var aCache=this._aCache;if(this.maxCacheEntries>0){if(!aCache){this._aCache=[];}else{var nCacheLength=aCache.length;if(nCacheLength>0){var oResponse=null;this.fireEvent("cacheRequestEvent",{request:oRequest,callback:oCallback,caller:oCaller});for(var i=nCacheLength-1;i>=0;i--){var oCacheElem=aCache[i];if(this.isCacheHit(oRequest,oCacheElem.request)){oResponse=oCacheElem.response;this.fireEvent("cacheResponseEvent",{request:oRequest,response:oResponse,callback:oCallback,caller:oCaller});if(i<nCacheLength-1){aCache.splice(i,1);this.addToCache(oRequest,oResponse);}oResponse.cached=true;break;}}return oResponse;}}}else{if(aCache){this._aCache=null;}}return null;},isCacheHit:function(oRequest,oCachedRequest){return(oRequest===oCachedRequest);},addToCache:function(oRequest,oResponse){var aCache=this._aCache;if(!aCache){return;}while(aCache.length>=this.maxCacheEntries){aCache.shift();}oResponse=(this.cloneBeforeCaching)?DS._cloneObject(oResponse):oResponse;var oCacheElem={request:oRequest,response:oResponse};aCache[aCache.length]=oCacheElem;this.fireEvent("responseCacheEvent",{request:oRequest,response:oResponse});},flushCache:function(){if(this._aCache){this._aCache=[];this.fireEvent("cacheFlushEvent");}},setInterval:function(nMsec,oRequest,oCallback,oCaller){if(lang.isNumber(nMsec)&&(nMsec>=0)){var oSelf=this;var nId=setInterval(function(){oSelf.makeConnection(oRequest,oCallback,oCaller);},nMsec);this._aIntervals.push(nId);return nId;}else{}},clearInterval:function(nId){var tracker=this._aIntervals||[];for(var i=tracker.length-1;i>-1;i--){if(tracker[i]===nId){tracker.splice(i,1);clearInterval(nId);}}},clearAllIntervals:function(){var tracker=this._aIntervals||[];for(var i=tracker.length-1;i>-1;i--){clearInterval(tracker[i]);}tracker=[];},sendRequest:function(oRequest,oCallback,oCaller){var oCachedResponse=this.getCachedResponse(oRequest,oCallback,oCaller);if(oCachedResponse){DS.issueCallback(oCallback,[oRequest,oCachedResponse],false,oCaller);return null;}return this.makeConnection(oRequest,oCallback,oCaller);},makeConnection:function(oRequest,oCallback,oCaller){var tId=DS._nTransactionId++;this.fireEvent("requestEvent",{tId:tId,request:oRequest,callback:oCallback,caller:oCaller});var oRawResponse=this.liveData;this.handleResponse(oRequest,oRawResponse,oCallback,oCaller,tId);return tId;},handleResponse:function(oRequest,oRawResponse,oCallback,oCaller,tId){this.fireEvent("responseEvent",{tId:tId,request:oRequest,response:oRawResponse,callback:oCallback,caller:oCaller});
var xhr=(this.dataType==DS.TYPE_XHR)?true:false;var oParsedResponse=null;var oFullResponse=oRawResponse;if(this.responseType===DS.TYPE_UNKNOWN){var ctype=(oRawResponse&&oRawResponse.getResponseHeader)?oRawResponse.getResponseHeader["Content-Type"]:null;if(ctype){if(ctype.indexOf("text/xml")>-1){this.responseType=DS.TYPE_XML;}else{if(ctype.indexOf("application/json")>-1){this.responseType=DS.TYPE_JSON;}else{if(ctype.indexOf("text/plain")>-1){this.responseType=DS.TYPE_TEXT;}}}}else{if(YAHOO.lang.isArray(oRawResponse)){this.responseType=DS.TYPE_JSARRAY;}else{if(oRawResponse&&oRawResponse.nodeType&&(oRawResponse.nodeType===9||oRawResponse.nodeType===1||oRawResponse.nodeType===11)){this.responseType=DS.TYPE_XML;}else{if(oRawResponse&&oRawResponse.nodeName&&(oRawResponse.nodeName.toLowerCase()=="table")){this.responseType=DS.TYPE_HTMLTABLE;}else{if(YAHOO.lang.isObject(oRawResponse)){this.responseType=DS.TYPE_JSON;}else{if(YAHOO.lang.isString(oRawResponse)){this.responseType=DS.TYPE_TEXT;}}}}}}}switch(this.responseType){case DS.TYPE_JSARRAY:if(xhr&&oRawResponse&&oRawResponse.responseText){oFullResponse=oRawResponse.responseText;}try{if(lang.isString(oFullResponse)){var parseArgs=[oFullResponse].concat(this.parseJSONArgs);if(lang.JSON){oFullResponse=lang.JSON.parse.apply(lang.JSON,parseArgs);}else{if(window.JSON&&JSON.parse){oFullResponse=JSON.parse.apply(JSON,parseArgs);}else{if(oFullResponse.parseJSON){oFullResponse=oFullResponse.parseJSON.apply(oFullResponse,parseArgs.slice(1));}else{while(oFullResponse.length>0&&(oFullResponse.charAt(0)!="{")&&(oFullResponse.charAt(0)!="[")){oFullResponse=oFullResponse.substring(1,oFullResponse.length);}if(oFullResponse.length>0){var arrayEnd=Math.max(oFullResponse.lastIndexOf("]"),oFullResponse.lastIndexOf("}"));oFullResponse=oFullResponse.substring(0,arrayEnd+1);oFullResponse=eval("("+oFullResponse+")");}}}}}}catch(e1){}oFullResponse=this.doBeforeParseData(oRequest,oFullResponse,oCallback);oParsedResponse=this.parseArrayData(oRequest,oFullResponse);break;case DS.TYPE_JSON:if(xhr&&oRawResponse&&oRawResponse.responseText){oFullResponse=oRawResponse.responseText;}try{if(lang.isString(oFullResponse)){var parseArgs=[oFullResponse].concat(this.parseJSONArgs);if(lang.JSON){oFullResponse=lang.JSON.parse.apply(lang.JSON,parseArgs);}else{if(window.JSON&&JSON.parse){oFullResponse=JSON.parse.apply(JSON,parseArgs);}else{if(oFullResponse.parseJSON){oFullResponse=oFullResponse.parseJSON.apply(oFullResponse,parseArgs.slice(1));}else{while(oFullResponse.length>0&&(oFullResponse.charAt(0)!="{")&&(oFullResponse.charAt(0)!="[")){oFullResponse=oFullResponse.substring(1,oFullResponse.length);}if(oFullResponse.length>0){var objEnd=Math.max(oFullResponse.lastIndexOf("]"),oFullResponse.lastIndexOf("}"));oFullResponse=oFullResponse.substring(0,objEnd+1);oFullResponse=eval("("+oFullResponse+")");}}}}}}catch(e){}oFullResponse=this.doBeforeParseData(oRequest,oFullResponse,oCallback);oParsedResponse=this.parseJSONData(oRequest,oFullResponse);break;case DS.TYPE_HTMLTABLE:if(xhr&&oRawResponse.responseText){var el=document.createElement("div");el.innerHTML=oRawResponse.responseText;oFullResponse=el.getElementsByTagName("table")[0];}oFullResponse=this.doBeforeParseData(oRequest,oFullResponse,oCallback);oParsedResponse=this.parseHTMLTableData(oRequest,oFullResponse);break;case DS.TYPE_XML:if(xhr&&oRawResponse.responseXML){oFullResponse=oRawResponse.responseXML;}oFullResponse=this.doBeforeParseData(oRequest,oFullResponse,oCallback);oParsedResponse=this.parseXMLData(oRequest,oFullResponse);break;case DS.TYPE_TEXT:if(xhr&&lang.isString(oRawResponse.responseText)){oFullResponse=oRawResponse.responseText;}oFullResponse=this.doBeforeParseData(oRequest,oFullResponse,oCallback);oParsedResponse=this.parseTextData(oRequest,oFullResponse);break;default:oFullResponse=this.doBeforeParseData(oRequest,oFullResponse,oCallback);oParsedResponse=this.parseData(oRequest,oFullResponse);break;}oParsedResponse=oParsedResponse||{};if(!oParsedResponse.results){oParsedResponse.results=[];}if(!oParsedResponse.meta){oParsedResponse.meta={};}if(!oParsedResponse.error){oParsedResponse=this.doBeforeCallback(oRequest,oFullResponse,oParsedResponse,oCallback);this.fireEvent("responseParseEvent",{request:oRequest,response:oParsedResponse,callback:oCallback,caller:oCaller});this.addToCache(oRequest,oParsedResponse);}else{oParsedResponse.error=true;this.fireEvent("dataErrorEvent",{request:oRequest,response:oRawResponse,callback:oCallback,caller:oCaller,message:DS.ERROR_DATANULL});}oParsedResponse.tId=tId;DS.issueCallback(oCallback,[oRequest,oParsedResponse],oParsedResponse.error,oCaller);},doBeforeParseData:function(oRequest,oFullResponse,oCallback){return oFullResponse;},doBeforeCallback:function(oRequest,oFullResponse,oParsedResponse,oCallback){return oParsedResponse;},parseData:function(oRequest,oFullResponse){if(lang.isValue(oFullResponse)){var oParsedResponse={results:oFullResponse,meta:{}};return oParsedResponse;}return null;},parseArrayData:function(oRequest,oFullResponse){if(lang.isArray(oFullResponse)){var results=[],i,j,rec,field,data;if(lang.isArray(this.responseSchema.fields)){var fields=this.responseSchema.fields;for(i=fields.length-1;i>=0;--i){if(typeof fields[i]!=="object"){fields[i]={key:fields[i]};}}var parsers={},p;for(i=fields.length-1;i>=0;--i){p=(typeof fields[i].parser==="function"?fields[i].parser:DS.Parser[fields[i].parser+""])||fields[i].converter;if(p){parsers[fields[i].key]=p;}}var arrType=lang.isArray(oFullResponse[0]);for(i=oFullResponse.length-1;i>-1;i--){var oResult={};rec=oFullResponse[i];if(typeof rec==="object"){for(j=fields.length-1;j>-1;j--){field=fields[j];data=arrType?rec[j]:rec[field.key];if(parsers[field.key]){data=parsers[field.key].call(this,data);}if(data===undefined){data=null;}oResult[field.key]=data;}}else{if(lang.isString(rec)){for(j=fields.length-1;j>-1;j--){field=fields[j];data=rec;if(parsers[field.key]){data=parsers[field.key].call(this,data);}if(data===undefined){data=null;}oResult[field.key]=data;
}}}results[i]=oResult;}}else{results=oFullResponse;}var oParsedResponse={results:results};return oParsedResponse;}return null;},parseTextData:function(oRequest,oFullResponse){if(lang.isString(oFullResponse)){if(lang.isString(this.responseSchema.recordDelim)&&lang.isString(this.responseSchema.fieldDelim)){var oParsedResponse={results:[]};var recDelim=this.responseSchema.recordDelim;var fieldDelim=this.responseSchema.fieldDelim;if(oFullResponse.length>0){var newLength=oFullResponse.length-recDelim.length;if(oFullResponse.substr(newLength)==recDelim){oFullResponse=oFullResponse.substr(0,newLength);}if(oFullResponse.length>0){var recordsarray=oFullResponse.split(recDelim);for(var i=0,len=recordsarray.length,recIdx=0;i<len;++i){var bError=false,sRecord=recordsarray[i];if(lang.isString(sRecord)&&(sRecord.length>0)){var fielddataarray=recordsarray[i].split(fieldDelim);var oResult={};if(lang.isArray(this.responseSchema.fields)){var fields=this.responseSchema.fields;for(var j=fields.length-1;j>-1;j--){try{var data=fielddataarray[j];if(lang.isString(data)){if(data.charAt(0)=='"'){data=data.substr(1);}if(data.charAt(data.length-1)=='"'){data=data.substr(0,data.length-1);}var field=fields[j];var key=(lang.isValue(field.key))?field.key:field;if(!field.parser&&field.converter){field.parser=field.converter;}var parser=(typeof field.parser==="function")?field.parser:DS.Parser[field.parser+""];if(parser){data=parser.call(this,data);}if(data===undefined){data=null;}oResult[key]=data;}else{bError=true;}}catch(e){bError=true;}}}else{oResult=fielddataarray;}if(!bError){oParsedResponse.results[recIdx++]=oResult;}}}}}return oParsedResponse;}}return null;},parseXMLResult:function(result){var oResult={},schema=this.responseSchema;try{for(var m=schema.fields.length-1;m>=0;m--){var field=schema.fields[m];var key=(lang.isValue(field.key))?field.key:field;var data=null;if(this.useXPath){data=YAHOO.util.DataSource._getLocationValue(field,result);}else{var xmlAttr=result.attributes.getNamedItem(key);if(xmlAttr){data=xmlAttr.value;}else{var xmlNode=result.getElementsByTagName(key);if(xmlNode&&xmlNode.item(0)){var item=xmlNode.item(0);data=(item)?((item.text)?item.text:(item.textContent)?item.textContent:null):null;if(!data){var datapieces=[];for(var j=0,len=item.childNodes.length;j<len;j++){if(item.childNodes[j].nodeValue){datapieces[datapieces.length]=item.childNodes[j].nodeValue;}}if(datapieces.length>0){data=datapieces.join("");}}}}}if(data===null){data="";}if(!field.parser&&field.converter){field.parser=field.converter;}var parser=(typeof field.parser==="function")?field.parser:DS.Parser[field.parser+""];if(parser){data=parser.call(this,data);}if(data===undefined){data=null;}oResult[key]=data;}}catch(e){}return oResult;},parseXMLData:function(oRequest,oFullResponse){var bError=false,schema=this.responseSchema,oParsedResponse={meta:{}},xmlList=null,metaNode=schema.metaNode,metaLocators=schema.metaFields||{},i,k,loc,v;try{if(this.useXPath){for(k in metaLocators){oParsedResponse.meta[k]=YAHOO.util.DataSource._getLocationValue(metaLocators[k],oFullResponse);}}else{metaNode=metaNode?oFullResponse.getElementsByTagName(metaNode)[0]:oFullResponse;if(metaNode){for(k in metaLocators){if(lang.hasOwnProperty(metaLocators,k)){loc=metaLocators[k];v=metaNode.getElementsByTagName(loc)[0];if(v){v=v.firstChild.nodeValue;}else{v=metaNode.attributes.getNamedItem(loc);if(v){v=v.value;}}if(lang.isValue(v)){oParsedResponse.meta[k]=v;}}}}}xmlList=(schema.resultNode)?oFullResponse.getElementsByTagName(schema.resultNode):null;}catch(e){}if(!xmlList||!lang.isArray(schema.fields)){bError=true;}else{oParsedResponse.results=[];for(i=xmlList.length-1;i>=0;--i){var oResult=this.parseXMLResult(xmlList.item(i));oParsedResponse.results[i]=oResult;}}if(bError){oParsedResponse.error=true;}else{}return oParsedResponse;},parseJSONData:function(oRequest,oFullResponse){var oParsedResponse={results:[],meta:{}};if(lang.isObject(oFullResponse)&&this.responseSchema.resultsList){var schema=this.responseSchema,fields=schema.fields,resultsList=oFullResponse,results=[],metaFields=schema.metaFields||{},fieldParsers=[],fieldPaths=[],simpleFields=[],bError=false,i,len,j,v,key,parser,path;var buildPath=function(needle){var path=null,keys=[],i=0;if(needle){needle=needle.replace(/\[(['"])(.*?)\1\]/g,function(x,$1,$2){keys[i]=$2;return".@"+(i++);}).replace(/\[(\d+)\]/g,function(x,$1){keys[i]=parseInt($1,10)|0;return".@"+(i++);}).replace(/^\./,"");if(!/[^\w\.\$@]/.test(needle)){path=needle.split(".");for(i=path.length-1;i>=0;--i){if(path[i].charAt(0)==="@"){path[i]=keys[parseInt(path[i].substr(1),10)];}}}else{}}return path;};var walkPath=function(path,origin){var v=origin,i=0,len=path.length;for(;i<len&&v;++i){v=v[path[i]];}return v;};path=buildPath(schema.resultsList);if(path){resultsList=walkPath(path,oFullResponse);if(resultsList===undefined){bError=true;}}else{bError=true;}if(!resultsList){resultsList=[];}if(!lang.isArray(resultsList)){resultsList=[resultsList];}if(!bError){if(schema.fields){var field;for(i=0,len=fields.length;i<len;i++){field=fields[i];key=field.key||field;parser=((typeof field.parser==="function")?field.parser:DS.Parser[field.parser+""])||field.converter;path=buildPath(key);if(parser){fieldParsers[fieldParsers.length]={key:key,parser:parser};}if(path){if(path.length>1){fieldPaths[fieldPaths.length]={key:key,path:path};}else{simpleFields[simpleFields.length]={key:key,path:path[0]};}}else{}}for(i=resultsList.length-1;i>=0;--i){var r=resultsList[i],rec={};if(r){for(j=simpleFields.length-1;j>=0;--j){rec[simpleFields[j].key]=(r[simpleFields[j].path]!==undefined)?r[simpleFields[j].path]:r[j];}for(j=fieldPaths.length-1;j>=0;--j){rec[fieldPaths[j].key]=walkPath(fieldPaths[j].path,r);}for(j=fieldParsers.length-1;j>=0;--j){var p=fieldParsers[j].key;rec[p]=fieldParsers[j].parser.call(this,rec[p]);if(rec[p]===undefined){rec[p]=null;}}}results[i]=rec;}}else{results=resultsList;}for(key in metaFields){if(lang.hasOwnProperty(metaFields,key)){path=buildPath(metaFields[key]);
if(path){v=walkPath(path,oFullResponse);oParsedResponse.meta[key]=v;}}}}else{oParsedResponse.error=true;}oParsedResponse.results=results;}else{oParsedResponse.error=true;}return oParsedResponse;},parseHTMLTableData:function(oRequest,oFullResponse){var bError=false;var elTable=oFullResponse;var fields=this.responseSchema.fields;var oParsedResponse={results:[]};if(lang.isArray(fields)){for(var i=0;i<elTable.tBodies.length;i++){var elTbody=elTable.tBodies[i];for(var j=elTbody.rows.length-1;j>-1;j--){var elRow=elTbody.rows[j];var oResult={};for(var k=fields.length-1;k>-1;k--){var field=fields[k];var key=(lang.isValue(field.key))?field.key:field;var data=elRow.cells[k].innerHTML;if(!field.parser&&field.converter){field.parser=field.converter;}var parser=(typeof field.parser==="function")?field.parser:DS.Parser[field.parser+""];if(parser){data=parser.call(this,data);}if(data===undefined){data=null;}oResult[key]=data;}oParsedResponse.results[j]=oResult;}}}else{bError=true;}if(bError){oParsedResponse.error=true;}else{}return oParsedResponse;}};lang.augmentProto(DS,util.EventProvider);util.LocalDataSource=function(oLiveData,oConfigs){this.dataType=DS.TYPE_LOCAL;if(oLiveData){if(YAHOO.lang.isArray(oLiveData)){this.responseType=DS.TYPE_JSARRAY;}else{if(oLiveData.nodeType&&oLiveData.nodeType==9){this.responseType=DS.TYPE_XML;}else{if(oLiveData.nodeName&&(oLiveData.nodeName.toLowerCase()=="table")){this.responseType=DS.TYPE_HTMLTABLE;oLiveData=oLiveData.cloneNode(true);}else{if(YAHOO.lang.isString(oLiveData)){this.responseType=DS.TYPE_TEXT;}else{if(YAHOO.lang.isObject(oLiveData)){this.responseType=DS.TYPE_JSON;}}}}}}else{oLiveData=[];this.responseType=DS.TYPE_JSARRAY;}util.LocalDataSource.superclass.constructor.call(this,oLiveData,oConfigs);};lang.extend(util.LocalDataSource,DS);lang.augmentObject(util.LocalDataSource,DS);util.FunctionDataSource=function(oLiveData,oConfigs){this.dataType=DS.TYPE_JSFUNCTION;oLiveData=oLiveData||function(){};util.FunctionDataSource.superclass.constructor.call(this,oLiveData,oConfigs);};lang.extend(util.FunctionDataSource,DS,{scope:null,makeConnection:function(oRequest,oCallback,oCaller){var tId=DS._nTransactionId++;this.fireEvent("requestEvent",{tId:tId,request:oRequest,callback:oCallback,caller:oCaller});var oRawResponse=(this.scope)?this.liveData.call(this.scope,oRequest,this,oCallback):this.liveData(oRequest,oCallback);if(this.responseType===DS.TYPE_UNKNOWN){if(YAHOO.lang.isArray(oRawResponse)){this.responseType=DS.TYPE_JSARRAY;}else{if(oRawResponse&&oRawResponse.nodeType&&oRawResponse.nodeType==9){this.responseType=DS.TYPE_XML;}else{if(oRawResponse&&oRawResponse.nodeName&&(oRawResponse.nodeName.toLowerCase()=="table")){this.responseType=DS.TYPE_HTMLTABLE;}else{if(YAHOO.lang.isObject(oRawResponse)){this.responseType=DS.TYPE_JSON;}else{if(YAHOO.lang.isString(oRawResponse)){this.responseType=DS.TYPE_TEXT;}}}}}}this.handleResponse(oRequest,oRawResponse,oCallback,oCaller,tId);return tId;}});lang.augmentObject(util.FunctionDataSource,DS);util.ScriptNodeDataSource=function(oLiveData,oConfigs){this.dataType=DS.TYPE_SCRIPTNODE;oLiveData=oLiveData||"";util.ScriptNodeDataSource.superclass.constructor.call(this,oLiveData,oConfigs);};lang.extend(util.ScriptNodeDataSource,DS,{getUtility:util.Get,asyncMode:"allowAll",scriptCallbackParam:"callback",generateRequestCallback:function(id){return"&"+this.scriptCallbackParam+"=YAHOO.util.ScriptNodeDataSource.callbacks["+id+"]";},doBeforeGetScriptNode:function(sUri){return sUri;},makeConnection:function(oRequest,oCallback,oCaller){var tId=DS._nTransactionId++;this.fireEvent("requestEvent",{tId:tId,request:oRequest,callback:oCallback,caller:oCaller});if(util.ScriptNodeDataSource._nPending===0){util.ScriptNodeDataSource.callbacks=[];util.ScriptNodeDataSource._nId=0;}var id=util.ScriptNodeDataSource._nId;util.ScriptNodeDataSource._nId++;var oSelf=this;util.ScriptNodeDataSource.callbacks[id]=function(oRawResponse){if((oSelf.asyncMode!=="ignoreStaleResponses")||(id===util.ScriptNodeDataSource.callbacks.length-1)){if(oSelf.responseType===DS.TYPE_UNKNOWN){if(YAHOO.lang.isArray(oRawResponse)){oSelf.responseType=DS.TYPE_JSARRAY;}else{if(oRawResponse.nodeType&&oRawResponse.nodeType==9){oSelf.responseType=DS.TYPE_XML;}else{if(oRawResponse.nodeName&&(oRawResponse.nodeName.toLowerCase()=="table")){oSelf.responseType=DS.TYPE_HTMLTABLE;}else{if(YAHOO.lang.isObject(oRawResponse)){oSelf.responseType=DS.TYPE_JSON;}else{if(YAHOO.lang.isString(oRawResponse)){oSelf.responseType=DS.TYPE_TEXT;}}}}}}oSelf.handleResponse(oRequest,oRawResponse,oCallback,oCaller,tId);}else{}delete util.ScriptNodeDataSource.callbacks[id];};util.ScriptNodeDataSource._nPending++;var sUri=this.liveData+oRequest+this.generateRequestCallback(id);sUri=this.doBeforeGetScriptNode(sUri);this.getUtility.script(sUri,{autopurge:true,onsuccess:util.ScriptNodeDataSource._bumpPendingDown,onfail:util.ScriptNodeDataSource._bumpPendingDown});return tId;}});lang.augmentObject(util.ScriptNodeDataSource,DS);lang.augmentObject(util.ScriptNodeDataSource,{_nId:0,_nPending:0,callbacks:[]});util.XHRDataSource=function(oLiveData,oConfigs){this.dataType=DS.TYPE_XHR;this.connMgr=this.connMgr||util.Connect;oLiveData=oLiveData||"";util.XHRDataSource.superclass.constructor.call(this,oLiveData,oConfigs);};lang.extend(util.XHRDataSource,DS,{connMgr:null,connXhrMode:"allowAll",connMethodPost:false,connTimeout:0,makeConnection:function(oRequest,oCallback,oCaller){var oRawResponse=null;var tId=DS._nTransactionId++;this.fireEvent("requestEvent",{tId:tId,request:oRequest,callback:oCallback,caller:oCaller});var oSelf=this;var oConnMgr=this.connMgr;var oQueue=this._oQueue;var _xhrSuccess=function(oResponse){if(oResponse&&(this.connXhrMode=="ignoreStaleResponses")&&(oResponse.tId!=oQueue.conn.tId)){return null;}else{if(!oResponse){this.fireEvent("dataErrorEvent",{request:oRequest,response:null,callback:oCallback,caller:oCaller,message:DS.ERROR_DATANULL});DS.issueCallback(oCallback,[oRequest,{error:true}],true,oCaller);return null;
}else{if(this.responseType===DS.TYPE_UNKNOWN){var ctype=(oResponse.getResponseHeader)?oResponse.getResponseHeader["Content-Type"]:null;if(ctype){if(ctype.indexOf("text/xml")>-1){this.responseType=DS.TYPE_XML;}else{if(ctype.indexOf("application/json")>-1){this.responseType=DS.TYPE_JSON;}else{if(ctype.indexOf("text/plain")>-1){this.responseType=DS.TYPE_TEXT;}}}}}this.handleResponse(oRequest,oResponse,oCallback,oCaller,tId);}}};var _xhrFailure=function(oResponse){this.fireEvent("dataErrorEvent",{request:oRequest,response:oResponse,callback:oCallback,caller:oCaller,message:DS.ERROR_DATAINVALID});if(lang.isString(this.liveData)&&lang.isString(oRequest)&&(this.liveData.lastIndexOf("?")!==this.liveData.length-1)&&(oRequest.indexOf("?")!==0)){}oResponse=oResponse||{};oResponse.error=true;DS.issueCallback(oCallback,[oRequest,oResponse],true,oCaller);return null;};var _xhrCallback={success:_xhrSuccess,failure:_xhrFailure,scope:this};if(lang.isNumber(this.connTimeout)){_xhrCallback.timeout=this.connTimeout;}if(this.connXhrMode=="cancelStaleRequests"){if(oQueue.conn){if(oConnMgr.abort){oConnMgr.abort(oQueue.conn);oQueue.conn=null;}else{}}}if(oConnMgr&&oConnMgr.asyncRequest){var sLiveData=this.liveData;var isPost=this.connMethodPost;var sMethod=(isPost)?"POST":"GET";var sUri=(isPost||!lang.isValue(oRequest))?sLiveData:sLiveData+oRequest;var sRequest=(isPost)?oRequest:null;if(this.connXhrMode!="queueRequests"){oQueue.conn=oConnMgr.asyncRequest(sMethod,sUri,_xhrCallback,sRequest);}else{if(oQueue.conn){var allRequests=oQueue.requests;allRequests.push({request:oRequest,callback:_xhrCallback});if(!oQueue.interval){oQueue.interval=setInterval(function(){if(oConnMgr.isCallInProgress(oQueue.conn)){return;}else{if(allRequests.length>0){sUri=(isPost||!lang.isValue(allRequests[0].request))?sLiveData:sLiveData+allRequests[0].request;sRequest=(isPost)?allRequests[0].request:null;oQueue.conn=oConnMgr.asyncRequest(sMethod,sUri,allRequests[0].callback,sRequest);allRequests.shift();}else{clearInterval(oQueue.interval);oQueue.interval=null;}}},50);}}else{oQueue.conn=oConnMgr.asyncRequest(sMethod,sUri,_xhrCallback,sRequest);}}}else{DS.issueCallback(oCallback,[oRequest,{error:true}],true,oCaller);}return tId;}});lang.augmentObject(util.XHRDataSource,DS);util.DataSource=function(oLiveData,oConfigs){oConfigs=oConfigs||{};var dataType=oConfigs.dataType;if(dataType){if(dataType==DS.TYPE_LOCAL){return new util.LocalDataSource(oLiveData,oConfigs);}else{if(dataType==DS.TYPE_XHR){return new util.XHRDataSource(oLiveData,oConfigs);}else{if(dataType==DS.TYPE_SCRIPTNODE){return new util.ScriptNodeDataSource(oLiveData,oConfigs);}else{if(dataType==DS.TYPE_JSFUNCTION){return new util.FunctionDataSource(oLiveData,oConfigs);}}}}}if(YAHOO.lang.isString(oLiveData)){return new util.XHRDataSource(oLiveData,oConfigs);}else{if(YAHOO.lang.isFunction(oLiveData)){return new util.FunctionDataSource(oLiveData,oConfigs);}else{return new util.LocalDataSource(oLiveData,oConfigs);}}};lang.augmentObject(util.DataSource,DS);})();YAHOO.util.Number={format:function(e,k){if(e===""||e===null||!isFinite(e)){return"";}e=+e;k=YAHOO.lang.merge(YAHOO.util.Number.format.defaults,(k||{}));var j=e+"",l=Math.abs(e),b=k.decimalPlaces||0,r=k.thousandsSeparator,f=k.negativeFormat||("-"+k.format),q,p,g,h;if(f.indexOf("#")>-1){f=f.replace(/#/,k.format);}if(b<0){q=l-(l%1)+"";g=q.length+b;if(g>0){q=Number("."+q).toFixed(g).slice(2)+new Array(q.length-g+1).join("0");}else{q="0";}}else{var a=l+"";if(b>0||a.indexOf(".")>0){var d=Math.pow(10,b);q=Math.round(l*d)/d+"";var c=q.indexOf("."),m,o;if(c<0){m=b;o=(Math.pow(10,m)+"").substring(1);if(b>0){q=q+"."+o;}}else{m=b-(q.length-c-1);o=(Math.pow(10,m)+"").substring(1);q=q+o;}}else{q=l.toFixed(b)+"";}}p=q.split(/\D/);if(l>=1000){g=p[0].length%3||3;p[0]=p[0].slice(0,g)+p[0].slice(g).replace(/(\d{3})/g,r+"$1");}return YAHOO.util.Number.format._applyFormat((e<0?f:k.format),p.join(k.decimalSeparator),k);}};YAHOO.util.Number.format.defaults={format:"{prefix}{number}{suffix}",negativeFormat:null,decimalSeparator:".",decimalPlaces:null,thousandsSeparator:""};YAHOO.util.Number.format._applyFormat=function(a,b,c){return a.replace(/\{(\w+)\}/g,function(d,e){return e==="number"?b:e in c?c[e]:"";});};(function(){var a=function(c,e,d){if(typeof d==="undefined"){d=10;}for(;parseInt(c,10)<d&&d>1;d/=10){c=e.toString()+c;}return c.toString();};var b={formats:{a:function(e,c){return c.a[e.getDay()];},A:function(e,c){return c.A[e.getDay()];},b:function(e,c){return c.b[e.getMonth()];},B:function(e,c){return c.B[e.getMonth()];},C:function(c){return a(parseInt(c.getFullYear()/100,10),0);},d:["getDate","0"],e:["getDate"," "],g:function(c){return a(parseInt(b.formats.G(c)%100,10),0);},G:function(f){var g=f.getFullYear();var e=parseInt(b.formats.V(f),10);var c=parseInt(b.formats.W(f),10);if(c>e){g++;}else{if(c===0&&e>=52){g--;}}return g;},H:["getHours","0"],I:function(e){var c=e.getHours()%12;return a(c===0?12:c,0);},j:function(h){var g=new Date(""+h.getFullYear()+"/1/1 GMT");var e=new Date(""+h.getFullYear()+"/"+(h.getMonth()+1)+"/"+h.getDate()+" GMT");var c=e-g;var f=parseInt(c/60000/60/24,10)+1;return a(f,0,100);},k:["getHours"," "],l:function(e){var c=e.getHours()%12;return a(c===0?12:c," ");},m:function(c){return a(c.getMonth()+1,0);},M:["getMinutes","0"],p:function(e,c){return c.p[e.getHours()>=12?1:0];},P:function(e,c){return c.P[e.getHours()>=12?1:0];},s:function(e,c){return parseInt(e.getTime()/1000,10);},S:["getSeconds","0"],u:function(c){var e=c.getDay();return e===0?7:e;},U:function(g){var c=parseInt(b.formats.j(g),10);var f=6-g.getDay();var e=parseInt((c+f)/7,10);return a(e,0);},V:function(g){var f=parseInt(b.formats.W(g),10);var c=(new Date(""+g.getFullYear()+"/1/1")).getDay();var e=f+(c>4||c<=1?0:1);if(e===53&&(new Date(""+g.getFullYear()+"/12/31")).getDay()<4){e=1;}else{if(e===0){e=b.formats.V(new Date(""+(g.getFullYear()-1)+"/12/31"));}}return a(e,0);},w:"getDay",W:function(g){var c=parseInt(b.formats.j(g),10);var f=7-b.formats.u(g);var e=parseInt((c+f)/7,10);
return a(e,0,10);},y:function(c){return a(c.getFullYear()%100,0);},Y:"getFullYear",z:function(f){var e=f.getTimezoneOffset();var c=a(parseInt(Math.abs(e/60),10),0);var g=a(Math.abs(e%60),0);return(e>0?"-":"+")+c+g;},Z:function(c){var e=c.toString().replace(/^.*:\d\d( GMT[+-]\d+)? \(?([A-Za-z ]+)\)?\d*$/,"$2").replace(/[a-z ]/g,"");if(e.length>4){e=b.formats.z(c);}return e;},"%":function(c){return"%";}},aggregates:{c:"locale",D:"%m/%d/%y",F:"%Y-%m-%d",h:"%b",n:"\n",r:"locale",R:"%H:%M",t:"\t",T:"%H:%M:%S",x:"locale",X:"locale"},format:function(g,f,d){f=f||{};if(!(g instanceof Date)){return YAHOO.lang.isValue(g)?g:"";}var h=f.format||"%m/%d/%Y";if(h==="YYYY/MM/DD"){h="%Y/%m/%d";}else{if(h==="DD/MM/YYYY"){h="%d/%m/%Y";}else{if(h==="MM/DD/YYYY"){h="%m/%d/%Y";}}}d=d||"en";if(!(d in YAHOO.util.DateLocale)){if(d.replace(/-[a-zA-Z]+$/,"") in YAHOO.util.DateLocale){d=d.replace(/-[a-zA-Z]+$/,"");}else{d="en";}}var j=YAHOO.util.DateLocale[d];var c=function(l,k){var m=b.aggregates[k];return(m==="locale"?j[k]:m);};var e=function(l,k){var m=b.formats[k];if(typeof m==="string"){return g[m]();}else{if(typeof m==="function"){return m.call(g,g,j);}else{if(typeof m==="object"&&typeof m[0]==="string"){return a(g[m[0]](),m[1]);}else{return k;}}}};while(h.match(/%[cDFhnrRtTxX]/)){h=h.replace(/%([cDFhnrRtTxX])/g,c);}var i=h.replace(/%([aAbBCdegGHIjklmMpPsSuUVwWyYzZ%])/g,e);c=e=undefined;return i;}};YAHOO.namespace("YAHOO.util");YAHOO.util.Date=b;YAHOO.util.DateLocale={a:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],A:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],b:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],B:["January","February","March","April","May","June","July","August","September","October","November","December"],c:"%a %d %b %Y %T %Z",p:["AM","PM"],P:["am","pm"],r:"%I:%M:%S %p",x:"%d/%m/%y",X:"%T"};YAHOO.util.DateLocale["en"]=YAHOO.lang.merge(YAHOO.util.DateLocale,{});YAHOO.util.DateLocale["en-US"]=YAHOO.lang.merge(YAHOO.util.DateLocale["en"],{c:"%a %d %b %Y %I:%M:%S %p %Z",x:"%m/%d/%Y",X:"%I:%M:%S %p"});YAHOO.util.DateLocale["en-GB"]=YAHOO.lang.merge(YAHOO.util.DateLocale["en"],{r:"%l:%M:%S %P %Z"});YAHOO.util.DateLocale["en-AU"]=YAHOO.lang.merge(YAHOO.util.DateLocale["en"]);})();YAHOO.register("datasource",YAHOO.util.DataSource,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/datasource/datasource-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
(function(){var l=YAHOO.lang,isFunction=l.isFunction,isObject=l.isObject,isArray=l.isArray,_toStr=Object.prototype.toString,Native=(YAHOO.env.ua.caja?window:this).JSON,_UNICODE_EXCEPTIONS=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,_ESCAPES=/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,_VALUES=/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,_BRACKETS=/(?:^|:|,)(?:\s*\[)+/g,_UNSAFE=/[^\],:{}\s]/,_SPECIAL_CHARS=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,_CHARS={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},UNDEFINED="undefined",OBJECT="object",NULL="null",STRING="string",NUMBER="number",BOOLEAN="boolean",DATE="date",_allowable={"undefined":UNDEFINED,"string":STRING,"[object String]":STRING,"number":NUMBER,"[object Number]":NUMBER,"boolean":BOOLEAN,"[object Boolean]":BOOLEAN,"[object Date]":DATE,"[object RegExp]":OBJECT},EMPTY="",OPEN_O="{",CLOSE_O="}",OPEN_A="[",CLOSE_A="]",COMMA=",",COMMA_CR=",\n",CR="\n",COLON=":",COLON_SP=": ",QUOTE='"';Native=_toStr.call(Native)==="[object JSON]"&&Native;function _char(c){if(!_CHARS[c]){_CHARS[c]="\\u"+("0000"+(+(c.charCodeAt(0))).toString(16)).slice(-4);}return _CHARS[c];}function _revive(data,reviver){var walk=function(o,key){var k,v,value=o[key];if(value&&typeof value==="object"){for(k in value){if(l.hasOwnProperty(value,k)){v=walk(value,k);if(v===undefined){delete value[k];}else{value[k]=v;}}}}return reviver.call(o,key,value);};return typeof reviver==="function"?walk({"":data},""):data;}function _prepare(s){return s.replace(_UNICODE_EXCEPTIONS,_char);}function _isSafe(str){return l.isString(str)&&!_UNSAFE.test(str.replace(_ESCAPES,"@").replace(_VALUES,"]").replace(_BRACKETS,""));}function _parse(s,reviver){s=_prepare(s);if(_isSafe(s)){return _revive(eval("("+s+")"),reviver);}throw new SyntaxError("JSON.parse");}function _type(o){var t=typeof o;return _allowable[t]||_allowable[_toStr.call(o)]||(t===OBJECT?(o?OBJECT:NULL):UNDEFINED);}function _string(s){return QUOTE+s.replace(_SPECIAL_CHARS,_char)+QUOTE;}function _indent(s,space){return s.replace(/^/gm,space);}function _stringify(o,w,space){if(o===undefined){return undefined;}var replacer=isFunction(w)?w:null,format=_toStr.call(space).match(/String|Number/)||[],_date=YAHOO.lang.JSON.dateToString,stack=[],tmp,i,len;if(replacer||!isArray(w)){w=undefined;}if(w){tmp={};for(i=0,len=w.length;i<len;++i){tmp[w[i]]=true;}w=tmp;}space=format[0]==="Number"?new Array(Math.min(Math.max(0,space),10)+1).join(" "):(space||EMPTY).slice(0,10);function _serialize(h,key){var value=h[key],t=_type(value),a=[],colon=space?COLON_SP:COLON,arr,i,keys,k,v;if(isObject(value)&&isFunction(value.toJSON)){value=value.toJSON(key);}else{if(t===DATE){value=_date(value);}}if(isFunction(replacer)){value=replacer.call(h,key,value);}if(value!==h[key]){t=_type(value);}switch(t){case DATE:case OBJECT:break;case STRING:return _string(value);case NUMBER:return isFinite(value)?value+EMPTY:NULL;case BOOLEAN:return value+EMPTY;case NULL:return NULL;default:return undefined;}for(i=stack.length-1;i>=0;--i){if(stack[i]===value){throw new Error("JSON.stringify. Cyclical reference");}}arr=isArray(value);stack.push(value);if(arr){for(i=value.length-1;i>=0;--i){a[i]=_serialize(value,i)||NULL;}}else{keys=w||value;i=0;for(k in keys){if(l.hasOwnProperty(keys,k)){v=_serialize(value,k);if(v){a[i++]=_string(k)+colon+v;}}}}stack.pop();if(space&&a.length){return arr?OPEN_A+CR+_indent(a.join(COMMA_CR),space)+CR+CLOSE_A:OPEN_O+CR+_indent(a.join(COMMA_CR),space)+CR+CLOSE_O;}else{return arr?OPEN_A+a.join(COMMA)+CLOSE_A:OPEN_O+a.join(COMMA)+CLOSE_O;}}return _serialize({"":o},"");}YAHOO.lang.JSON={useNativeParse:!!Native,useNativeStringify:!!Native,isSafe:function(s){return _isSafe(_prepare(s));},parse:function(s,reviver){if(typeof s!=="string"){s+="";}return Native&&YAHOO.lang.JSON.useNativeParse?Native.parse(s,reviver):_parse(s,reviver);},stringify:function(o,w,space){return Native&&YAHOO.lang.JSON.useNativeStringify?Native.stringify(o,w,space):_stringify(o,w,space);},dateToString:function(d){function _zeroPad(v){return v<10?"0"+v:v;}return d.getUTCFullYear()+"-"+_zeroPad(d.getUTCMonth()+1)+"-"+_zeroPad(d.getUTCDate())+"T"+_zeroPad(d.getUTCHours())+COLON+_zeroPad(d.getUTCMinutes())+COLON+_zeroPad(d.getUTCSeconds())+"Z";},stringToDate:function(str){var m=str.match(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(?:\.(\d{3}))?Z$/);if(m){var d=new Date();d.setUTCFullYear(m[1],m[2]-1,m[3]);d.setUTCHours(m[4],m[5],m[6],(m[7]||0));return d;}return str;}};YAHOO.lang.JSON.isValid=YAHOO.lang.JSON.isSafe;})();YAHOO.register("json",YAHOO.lang.JSON,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/json/json-min.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
YAHOO.widget.DS_JSArray=YAHOO.util.LocalDataSource;YAHOO.widget.DS_JSFunction=YAHOO.util.FunctionDataSource;YAHOO.widget.DS_XHR=function(b,a,d){var c=new YAHOO.util.XHRDataSource(b,d);c._aDeprecatedSchema=a;return c;};YAHOO.widget.DS_ScriptNode=function(b,a,d){var c=new YAHOO.util.ScriptNodeDataSource(b,d);c._aDeprecatedSchema=a;return c;};YAHOO.widget.DS_XHR.TYPE_JSON=YAHOO.util.DataSourceBase.TYPE_JSON;YAHOO.widget.DS_XHR.TYPE_XML=YAHOO.util.DataSourceBase.TYPE_XML;YAHOO.widget.DS_XHR.TYPE_FLAT=YAHOO.util.DataSourceBase.TYPE_TEXT;YAHOO.widget.AutoComplete=function(g,b,j,c){if(g&&b&&j){if(j&&YAHOO.lang.isFunction(j.sendRequest)){this.dataSource=j;}else{return;}this.key=0;var d=j.responseSchema;if(j._aDeprecatedSchema){var k=j._aDeprecatedSchema;if(YAHOO.lang.isArray(k)){if((j.responseType===YAHOO.util.DataSourceBase.TYPE_JSON)||(j.responseType===YAHOO.util.DataSourceBase.TYPE_UNKNOWN)){d.resultsList=k[0];this.key=k[1];d.fields=(k.length<3)?null:k.slice(1);}else{if(j.responseType===YAHOO.util.DataSourceBase.TYPE_XML){d.resultNode=k[0];this.key=k[1];d.fields=k.slice(1);}else{if(j.responseType===YAHOO.util.DataSourceBase.TYPE_TEXT){d.recordDelim=k[0];d.fieldDelim=k[1];}}}j.responseSchema=d;}}if(YAHOO.util.Dom.inDocument(g)){if(YAHOO.lang.isString(g)){this._sName="instance"+YAHOO.widget.AutoComplete._nIndex+" "+g;this._elTextbox=document.getElementById(g);}else{this._sName=(g.id)?"instance"+YAHOO.widget.AutoComplete._nIndex+" "+g.id:"instance"+YAHOO.widget.AutoComplete._nIndex;this._elTextbox=g;}YAHOO.util.Dom.addClass(this._elTextbox,"yui-ac-input");}else{return;}if(YAHOO.util.Dom.inDocument(b)){if(YAHOO.lang.isString(b)){this._elContainer=document.getElementById(b);}else{this._elContainer=b;}if(this._elContainer.style.display=="none"){}var e=this._elContainer.parentNode;var a=e.tagName.toLowerCase();if(a=="div"){YAHOO.util.Dom.addClass(e,"yui-ac");}else{}}else{return;}if(this.dataSource.dataType===YAHOO.util.DataSourceBase.TYPE_LOCAL){this.applyLocalFilter=true;}if(c&&(c.constructor==Object)){for(var i in c){if(i){this[i]=c[i];}}}this._initContainerEl();this._initProps();this._initListEl();this._initContainerHelperEls();var h=this;var f=this._elTextbox;YAHOO.util.Event.addListener(f,"keyup",h._onTextboxKeyUp,h);YAHOO.util.Event.addListener(f,"keydown",h._onTextboxKeyDown,h);YAHOO.util.Event.addListener(f,"focus",h._onTextboxFocus,h);YAHOO.util.Event.addListener(f,"blur",h._onTextboxBlur,h);YAHOO.util.Event.addListener(b,"mouseover",h._onContainerMouseover,h);YAHOO.util.Event.addListener(b,"mouseout",h._onContainerMouseout,h);YAHOO.util.Event.addListener(b,"click",h._onContainerClick,h);YAHOO.util.Event.addListener(b,"scroll",h._onContainerScroll,h);YAHOO.util.Event.addListener(b,"resize",h._onContainerResize,h);YAHOO.util.Event.addListener(f,"keypress",h._onTextboxKeyPress,h);YAHOO.util.Event.addListener(window,"unload",h._onWindowUnload,h);this.textboxFocusEvent=new YAHOO.util.CustomEvent("textboxFocus",this);this.textboxKeyEvent=new YAHOO.util.CustomEvent("textboxKey",this);this.dataRequestEvent=new YAHOO.util.CustomEvent("dataRequest",this);this.dataRequestCancelEvent=new YAHOO.util.CustomEvent("dataRequestCancel",this);this.dataReturnEvent=new YAHOO.util.CustomEvent("dataReturn",this);this.dataErrorEvent=new YAHOO.util.CustomEvent("dataError",this);this.containerPopulateEvent=new YAHOO.util.CustomEvent("containerPopulate",this);this.containerExpandEvent=new YAHOO.util.CustomEvent("containerExpand",this);this.typeAheadEvent=new YAHOO.util.CustomEvent("typeAhead",this);this.itemMouseOverEvent=new YAHOO.util.CustomEvent("itemMouseOver",this);this.itemMouseOutEvent=new YAHOO.util.CustomEvent("itemMouseOut",this);this.itemArrowToEvent=new YAHOO.util.CustomEvent("itemArrowTo",this);this.itemArrowFromEvent=new YAHOO.util.CustomEvent("itemArrowFrom",this);this.itemSelectEvent=new YAHOO.util.CustomEvent("itemSelect",this);this.unmatchedItemSelectEvent=new YAHOO.util.CustomEvent("unmatchedItemSelect",this);this.selectionEnforceEvent=new YAHOO.util.CustomEvent("selectionEnforce",this);this.containerCollapseEvent=new YAHOO.util.CustomEvent("containerCollapse",this);this.textboxBlurEvent=new YAHOO.util.CustomEvent("textboxBlur",this);this.textboxChangeEvent=new YAHOO.util.CustomEvent("textboxChange",this);f.setAttribute("autocomplete","off");YAHOO.widget.AutoComplete._nIndex++;}else{}};YAHOO.widget.AutoComplete.prototype.dataSource=null;YAHOO.widget.AutoComplete.prototype.applyLocalFilter=null;YAHOO.widget.AutoComplete.prototype.queryMatchCase=false;YAHOO.widget.AutoComplete.prototype.queryMatchContains=false;YAHOO.widget.AutoComplete.prototype.queryMatchSubset=false;YAHOO.widget.AutoComplete.prototype.minQueryLength=1;YAHOO.widget.AutoComplete.prototype.maxResultsDisplayed=10;YAHOO.widget.AutoComplete.prototype.queryDelay=0.2;YAHOO.widget.AutoComplete.prototype.typeAheadDelay=0.5;YAHOO.widget.AutoComplete.prototype.queryInterval=500;YAHOO.widget.AutoComplete.prototype.highlightClassName="yui-ac-highlight";YAHOO.widget.AutoComplete.prototype.prehighlightClassName=null;YAHOO.widget.AutoComplete.prototype.delimChar=null;YAHOO.widget.AutoComplete.prototype.autoHighlight=true;YAHOO.widget.AutoComplete.prototype.typeAhead=false;YAHOO.widget.AutoComplete.prototype.animHoriz=false;YAHOO.widget.AutoComplete.prototype.animVert=true;YAHOO.widget.AutoComplete.prototype.animSpeed=0.3;YAHOO.widget.AutoComplete.prototype.forceSelection=false;YAHOO.widget.AutoComplete.prototype.allowBrowserAutocomplete=true;YAHOO.widget.AutoComplete.prototype.alwaysShowContainer=false;YAHOO.widget.AutoComplete.prototype.useIFrame=false;YAHOO.widget.AutoComplete.prototype.useShadow=false;YAHOO.widget.AutoComplete.prototype.suppressInputUpdate=false;YAHOO.widget.AutoComplete.prototype.resultTypeList=true;YAHOO.widget.AutoComplete.prototype.queryQuestionMark=true;YAHOO.widget.AutoComplete.prototype.autoSnapContainer=true;YAHOO.widget.AutoComplete.prototype.toString=function(){return"AutoComplete "+this._sName;};YAHOO.widget.AutoComplete.prototype.getInputEl=function(){return this._elTextbox;
};YAHOO.widget.AutoComplete.prototype.getContainerEl=function(){return this._elContainer;};YAHOO.widget.AutoComplete.prototype.isFocused=function(){return this._bFocused;};YAHOO.widget.AutoComplete.prototype.isContainerOpen=function(){return this._bContainerOpen;};YAHOO.widget.AutoComplete.prototype.getListEl=function(){return this._elList;};YAHOO.widget.AutoComplete.prototype.getListItemMatch=function(a){if(a._sResultMatch){return a._sResultMatch;}else{return null;}};YAHOO.widget.AutoComplete.prototype.getListItemData=function(a){if(a._oResultData){return a._oResultData;}else{return null;}};YAHOO.widget.AutoComplete.prototype.getListItemIndex=function(a){if(YAHOO.lang.isNumber(a._nItemIndex)){return a._nItemIndex;}else{return null;}};YAHOO.widget.AutoComplete.prototype.setHeader=function(b){if(this._elHeader){var a=this._elHeader;if(b){a.innerHTML=b;a.style.display="";}else{a.innerHTML="";a.style.display="none";}}};YAHOO.widget.AutoComplete.prototype.setFooter=function(b){if(this._elFooter){var a=this._elFooter;if(b){a.innerHTML=b;a.style.display="";}else{a.innerHTML="";a.style.display="none";}}};YAHOO.widget.AutoComplete.prototype.setBody=function(a){if(this._elBody){var b=this._elBody;YAHOO.util.Event.purgeElement(b,true);if(a){b.innerHTML=a;b.style.display="";}else{b.innerHTML="";b.style.display="none";}this._elList=null;}};YAHOO.widget.AutoComplete.prototype.generateRequest=function(b){var a=this.dataSource.dataType;if(a===YAHOO.util.DataSourceBase.TYPE_XHR){if(!this.dataSource.connMethodPost){b=(this.queryQuestionMark?"?":"")+(this.dataSource.scriptQueryParam||"query")+"="+b+(this.dataSource.scriptQueryAppend?("&"+this.dataSource.scriptQueryAppend):"");}else{b=(this.dataSource.scriptQueryParam||"query")+"="+b+(this.dataSource.scriptQueryAppend?("&"+this.dataSource.scriptQueryAppend):"");}}else{if(a===YAHOO.util.DataSourceBase.TYPE_SCRIPTNODE){b="&"+(this.dataSource.scriptQueryParam||"query")+"="+b+(this.dataSource.scriptQueryAppend?("&"+this.dataSource.scriptQueryAppend):"");}}return b;};YAHOO.widget.AutoComplete.prototype.sendQuery=function(b){this._bFocused=true;var a=(this.delimChar)?this._elTextbox.value+b:b;this._sendQuery(a);};YAHOO.widget.AutoComplete.prototype.snapContainer=function(){var a=this._elTextbox,b=YAHOO.util.Dom.getXY(a);b[1]+=YAHOO.util.Dom.get(a).offsetHeight+2;YAHOO.util.Dom.setXY(this._elContainer,b);};YAHOO.widget.AutoComplete.prototype.expandContainer=function(){this._toggleContainer(true);};YAHOO.widget.AutoComplete.prototype.collapseContainer=function(){this._toggleContainer(false);};YAHOO.widget.AutoComplete.prototype.clearList=function(){var b=this._elList.childNodes,a=b.length-1;for(;a>-1;a--){b[a].style.display="none";}};YAHOO.widget.AutoComplete.prototype.getSubsetMatches=function(e){var d,c,a;for(var b=e.length;b>=this.minQueryLength;b--){a=this.generateRequest(e.substr(0,b));this.dataRequestEvent.fire(this,d,a);c=this.dataSource.getCachedResponse(a);if(c){return this.filterResults.apply(this.dataSource,[e,c,c,{scope:this}]);}}return null;};YAHOO.widget.AutoComplete.prototype.preparseRawResponse=function(c,b,a){var d=((this.responseStripAfter!=="")&&(b.indexOf))?b.indexOf(this.responseStripAfter):-1;if(d!=-1){b=b.substring(0,d);}return b;};YAHOO.widget.AutoComplete.prototype.filterResults=function(l,n,r,m){if(m&&m.argument&&YAHOO.lang.isValue(m.argument.query)){l=m.argument.query;}if(l&&l!==""){r=YAHOO.widget.AutoComplete._cloneObject(r);var j=m.scope,q=this,c=r.results,o=[],b=j.maxResultsDisplayed,k=(q.queryMatchCase||j.queryMatchCase),a=(q.queryMatchContains||j.queryMatchContains);for(var d=0,h=c.length;d<h;d++){var f=c[d];var e=null;if(YAHOO.lang.isString(f)){e=f;}else{if(YAHOO.lang.isArray(f)){e=f[0];}else{if(this.responseSchema.fields){var p=this.responseSchema.fields[0].key||this.responseSchema.fields[0];e=f[p];}else{if(this.key){e=f[this.key];}}}}if(YAHOO.lang.isString(e)){var g=(k)?e.indexOf(decodeURIComponent(l)):e.toLowerCase().indexOf(decodeURIComponent(l).toLowerCase());if((!a&&(g===0))||(a&&(g>-1))){o.push(f);}}if(h>b&&o.length===b){break;}}r.results=o;}else{}return r;};YAHOO.widget.AutoComplete.prototype.handleResponse=function(c,a,b){if((this instanceof YAHOO.widget.AutoComplete)&&this._sName){this._populateList(c,a,b);}};YAHOO.widget.AutoComplete.prototype.doBeforeLoadData=function(c,a,b){return true;};YAHOO.widget.AutoComplete.prototype.formatResult=function(b,d,a){var c=(a)?a:"";return c;};YAHOO.widget.AutoComplete.prototype.formatEscapedResult=function(c,d,b){var a=(b)?b:"";return YAHOO.lang.escapeHTML(a);};YAHOO.widget.AutoComplete.prototype.doBeforeExpandContainer=function(d,a,c,b){return true;};YAHOO.widget.AutoComplete.prototype.destroy=function(){var b=this.toString();var a=this._elTextbox;var d=this._elContainer;this.textboxFocusEvent.unsubscribeAll();this.textboxKeyEvent.unsubscribeAll();this.dataRequestEvent.unsubscribeAll();this.dataReturnEvent.unsubscribeAll();this.dataErrorEvent.unsubscribeAll();this.containerPopulateEvent.unsubscribeAll();this.containerExpandEvent.unsubscribeAll();this.typeAheadEvent.unsubscribeAll();this.itemMouseOverEvent.unsubscribeAll();this.itemMouseOutEvent.unsubscribeAll();this.itemArrowToEvent.unsubscribeAll();this.itemArrowFromEvent.unsubscribeAll();this.itemSelectEvent.unsubscribeAll();this.unmatchedItemSelectEvent.unsubscribeAll();this.selectionEnforceEvent.unsubscribeAll();this.containerCollapseEvent.unsubscribeAll();this.textboxBlurEvent.unsubscribeAll();this.textboxChangeEvent.unsubscribeAll();YAHOO.util.Event.purgeElement(a,true);YAHOO.util.Event.purgeElement(d,true);d.innerHTML="";for(var c in this){if(YAHOO.lang.hasOwnProperty(this,c)){this[c]=null;}}};YAHOO.widget.AutoComplete.prototype.textboxFocusEvent=null;YAHOO.widget.AutoComplete.prototype.textboxKeyEvent=null;YAHOO.widget.AutoComplete.prototype.dataRequestEvent=null;YAHOO.widget.AutoComplete.prototype.dataRequestCancelEvent=null;YAHOO.widget.AutoComplete.prototype.dataReturnEvent=null;YAHOO.widget.AutoComplete.prototype.dataErrorEvent=null;
YAHOO.widget.AutoComplete.prototype.containerPopulateEvent=null;YAHOO.widget.AutoComplete.prototype.containerExpandEvent=null;YAHOO.widget.AutoComplete.prototype.typeAheadEvent=null;YAHOO.widget.AutoComplete.prototype.itemMouseOverEvent=null;YAHOO.widget.AutoComplete.prototype.itemMouseOutEvent=null;YAHOO.widget.AutoComplete.prototype.itemArrowToEvent=null;YAHOO.widget.AutoComplete.prototype.itemArrowFromEvent=null;YAHOO.widget.AutoComplete.prototype.itemSelectEvent=null;YAHOO.widget.AutoComplete.prototype.unmatchedItemSelectEvent=null;YAHOO.widget.AutoComplete.prototype.selectionEnforceEvent=null;YAHOO.widget.AutoComplete.prototype.containerCollapseEvent=null;YAHOO.widget.AutoComplete.prototype.textboxBlurEvent=null;YAHOO.widget.AutoComplete.prototype.textboxChangeEvent=null;YAHOO.widget.AutoComplete._nIndex=0;YAHOO.widget.AutoComplete.prototype._sName=null;YAHOO.widget.AutoComplete.prototype._elTextbox=null;YAHOO.widget.AutoComplete.prototype._elContainer=null;YAHOO.widget.AutoComplete.prototype._elContent=null;YAHOO.widget.AutoComplete.prototype._elHeader=null;YAHOO.widget.AutoComplete.prototype._elBody=null;YAHOO.widget.AutoComplete.prototype._elFooter=null;YAHOO.widget.AutoComplete.prototype._elShadow=null;YAHOO.widget.AutoComplete.prototype._elIFrame=null;YAHOO.widget.AutoComplete.prototype._bFocused=false;YAHOO.widget.AutoComplete.prototype._oAnim=null;YAHOO.widget.AutoComplete.prototype._bContainerOpen=false;YAHOO.widget.AutoComplete.prototype._bOverContainer=false;YAHOO.widget.AutoComplete.prototype._elList=null;YAHOO.widget.AutoComplete.prototype._nDisplayedItems=0;YAHOO.widget.AutoComplete.prototype._sCurQuery=null;YAHOO.widget.AutoComplete.prototype._sPastSelections="";YAHOO.widget.AutoComplete.prototype._sInitInputValue=null;YAHOO.widget.AutoComplete.prototype._elCurListItem=null;YAHOO.widget.AutoComplete.prototype._elCurPrehighlightItem=null;YAHOO.widget.AutoComplete.prototype._bItemSelected=false;YAHOO.widget.AutoComplete.prototype._nKeyCode=null;YAHOO.widget.AutoComplete.prototype._nDelayID=-1;YAHOO.widget.AutoComplete.prototype._nTypeAheadDelayID=-1;YAHOO.widget.AutoComplete.prototype._iFrameSrc="javascript:false;";YAHOO.widget.AutoComplete.prototype._queryInterval=null;YAHOO.widget.AutoComplete.prototype._sLastTextboxValue=null;YAHOO.widget.AutoComplete.prototype._initProps=function(){var b=this.minQueryLength;if(!YAHOO.lang.isNumber(b)){this.minQueryLength=1;}var e=this.maxResultsDisplayed;if(!YAHOO.lang.isNumber(e)||(e<1)){this.maxResultsDisplayed=10;}var f=this.queryDelay;if(!YAHOO.lang.isNumber(f)||(f<0)){this.queryDelay=0.2;}var c=this.typeAheadDelay;if(!YAHOO.lang.isNumber(c)||(c<0)){this.typeAheadDelay=0.2;}var a=this.delimChar;if(YAHOO.lang.isString(a)&&(a.length>0)){this.delimChar=[a];}else{if(!YAHOO.lang.isArray(a)){this.delimChar=null;}}var d=this.animSpeed;if((this.animHoriz||this.animVert)&&YAHOO.util.Anim){if(!YAHOO.lang.isNumber(d)||(d<0)){this.animSpeed=0.3;}if(!this._oAnim){this._oAnim=new YAHOO.util.Anim(this._elContent,{},this.animSpeed);}else{this._oAnim.duration=this.animSpeed;}}if(this.forceSelection&&a){}};YAHOO.widget.AutoComplete.prototype._initContainerHelperEls=function(){if(this.useShadow&&!this._elShadow){var a=document.createElement("div");a.className="yui-ac-shadow";a.style.width=0;a.style.height=0;this._elShadow=this._elContainer.appendChild(a);}if(this.useIFrame&&!this._elIFrame){var b=document.createElement("iframe");b.src=this._iFrameSrc;b.frameBorder=0;b.scrolling="no";b.style.position="absolute";b.style.width=0;b.style.height=0;b.style.padding=0;b.tabIndex=-1;b.role="presentation";b.title="Presentational iframe shim";this._elIFrame=this._elContainer.appendChild(b);}};YAHOO.widget.AutoComplete.prototype._initContainerEl=function(){YAHOO.util.Dom.addClass(this._elContainer,"yui-ac-container");if(!this._elContent){var c=document.createElement("div");c.className="yui-ac-content";c.style.display="none";this._elContent=this._elContainer.appendChild(c);var b=document.createElement("div");b.className="yui-ac-hd";b.style.display="none";this._elHeader=this._elContent.appendChild(b);var d=document.createElement("div");d.className="yui-ac-bd";this._elBody=this._elContent.appendChild(d);var a=document.createElement("div");a.className="yui-ac-ft";a.style.display="none";this._elFooter=this._elContent.appendChild(a);}else{}};YAHOO.widget.AutoComplete.prototype._initListEl=function(){var c=this.maxResultsDisplayed,a=this._elList||document.createElement("ul"),b;while(a.childNodes.length<c){b=document.createElement("li");b.style.display="none";b._nItemIndex=a.childNodes.length;a.appendChild(b);}if(!this._elList){var d=this._elBody;YAHOO.util.Event.purgeElement(d,true);d.innerHTML="";this._elList=d.appendChild(a);}this._elBody.style.display="";};YAHOO.widget.AutoComplete.prototype._focus=function(){var a=this;setTimeout(function(){try{a._elTextbox.focus();}catch(b){}},0);};YAHOO.widget.AutoComplete.prototype._enableIntervalDetection=function(){var a=this;if(!a._queryInterval&&a.queryInterval){a._queryInterval=setInterval(function(){a._onInterval();},a.queryInterval);}};YAHOO.widget.AutoComplete.prototype.enableIntervalDetection=YAHOO.widget.AutoComplete.prototype._enableIntervalDetection;YAHOO.widget.AutoComplete.prototype._onInterval=function(){var a=this._elTextbox.value;var b=this._sLastTextboxValue;if(a!=b){this._sLastTextboxValue=a;this._sendQuery(a);}};YAHOO.widget.AutoComplete.prototype._clearInterval=function(){if(this._queryInterval){clearInterval(this._queryInterval);this._queryInterval=null;}};YAHOO.widget.AutoComplete.prototype._isIgnoreKey=function(a){if((a==9)||(a==13)||(a==16)||(a==17)||(a>=18&&a<=20)||(a==27)||(a>=33&&a<=35)||(a>=36&&a<=40)||(a>=44&&a<=45)||(a==229)){return true;}return false;};YAHOO.widget.AutoComplete.prototype._sendQuery=function(d){if(this.minQueryLength<0){this._toggleContainer(false);return;}if(this.delimChar){var a=this._extractQuery(d);d=a.query;this._sPastSelections=a.previous;}if((d&&(d.length<this.minQueryLength))||(!d&&this.minQueryLength>0)){if(this._nDelayID!=-1){clearTimeout(this._nDelayID);
}this._toggleContainer(false);return;}d=encodeURIComponent(d);this._nDelayID=-1;if(this.dataSource.queryMatchSubset||this.queryMatchSubset){var c=this.getSubsetMatches(d);if(c){this.handleResponse(d,c,{query:d});return;}}if(this.dataSource.responseStripAfter){this.dataSource.doBeforeParseData=this.preparseRawResponse;}if(this.applyLocalFilter){this.dataSource.doBeforeCallback=this.filterResults;}var b=this.generateRequest(d);if(b!==undefined){this.dataRequestEvent.fire(this,d,b);this.dataSource.sendRequest(b,{success:this.handleResponse,failure:this.handleResponse,scope:this,argument:{query:d}});}else{this.dataRequestCancelEvent.fire(this,d);}};YAHOO.widget.AutoComplete.prototype._populateListItem=function(b,a,c){b.innerHTML=this.formatResult(a,c,b._sResultMatch);};YAHOO.widget.AutoComplete.prototype._populateList=function(n,f,c){if(this._nTypeAheadDelayID!=-1){clearTimeout(this._nTypeAheadDelayID);}n=(c&&c.query)?c.query:n;var h=this.doBeforeLoadData(n,f,c);if(h&&!f.error){this.dataReturnEvent.fire(this,n,f.results);if(this._bFocused){var p=decodeURIComponent(n);this._sCurQuery=p;this._bItemSelected=false;var u=f.results,a=Math.min(u.length,this.maxResultsDisplayed),m=(this.dataSource.responseSchema.fields)?(this.dataSource.responseSchema.fields[0].key||this.dataSource.responseSchema.fields[0]):0;if(a>0){if(!this._elList||(this._elList.childNodes.length<a)){this._initListEl();}this._initContainerHelperEls();var l=this._elList.childNodes;for(var t=a-1;t>=0;t--){var s=l[t],e=u[t];if(this.resultTypeList){var b=[];b[0]=(YAHOO.lang.isString(e))?e:e[m]||e[this.key];var o=this.dataSource.responseSchema.fields;if(YAHOO.lang.isArray(o)&&(o.length>1)){for(var q=1,v=o.length;q<v;q++){b[b.length]=e[o[q].key||o[q]];}}else{if(YAHOO.lang.isArray(e)){b=e;}else{if(YAHOO.lang.isString(e)){b=[e];}else{b[1]=e;}}}e=b;}s._sResultMatch=(YAHOO.lang.isString(e))?e:(YAHOO.lang.isArray(e))?e[0]:(e[m]||"");s._oResultData=e;this._populateListItem(s,e,p);s.style.display="";}if(a<l.length){var g;for(var r=l.length-1;r>=a;r--){g=l[r];g.style.display="none";}}this._nDisplayedItems=a;this.containerPopulateEvent.fire(this,n,u);if(this.autoHighlight){var d=this._elList.firstChild;this._toggleHighlight(d,"to");this.itemArrowToEvent.fire(this,d);this._typeAhead(d,n);}else{this._toggleHighlight(this._elCurListItem,"from");}h=this._doBeforeExpandContainer(this._elTextbox,this._elContainer,n,u);this._toggleContainer(h);}else{this._toggleContainer(false);}return;}}else{this.dataErrorEvent.fire(this,n,f);}};YAHOO.widget.AutoComplete.prototype._doBeforeExpandContainer=function(d,a,c,b){if(this.autoSnapContainer){this.snapContainer();}return this.doBeforeExpandContainer(d,a,c,b);};YAHOO.widget.AutoComplete.prototype._clearSelection=function(){var a=(this.delimChar)?this._extractQuery(this._elTextbox.value):{previous:"",query:this._elTextbox.value};this._elTextbox.value=a.previous;this.selectionEnforceEvent.fire(this,a.query);};YAHOO.widget.AutoComplete.prototype._textMatchesOption=function(){var a=null;for(var b=0;b<this._nDisplayedItems;b++){var c=this._elList.childNodes[b];var d=(""+c._sResultMatch).toLowerCase();if(d==this._sCurQuery.toLowerCase()){a=c;break;}}return(a);};YAHOO.widget.AutoComplete.prototype._typeAhead=function(b,d){if(!this.typeAhead||(this._nKeyCode==8)){return;}var a=this,c=this._elTextbox;if(c.setSelectionRange||c.createTextRange){this._nTypeAheadDelayID=setTimeout(function(){var f=c.value.length;a._updateValue(b);var g=c.value.length;a._selectText(c,f,g);var e=c.value.substr(f,g);a._sCurQuery=b._sResultMatch;a.typeAheadEvent.fire(a,d,e);},(this.typeAheadDelay*1000));}};YAHOO.widget.AutoComplete.prototype._selectText=function(d,a,b){if(d.setSelectionRange){d.setSelectionRange(a,b);}else{if(d.createTextRange){var c=d.createTextRange();c.moveStart("character",a);c.moveEnd("character",b-d.value.length);c.select();}else{d.select();}}};YAHOO.widget.AutoComplete.prototype._extractQuery=function(h){var c=this.delimChar,f=-1,g,e,b=c.length-1,d;for(;b>=0;b--){g=h.lastIndexOf(c[b]);if(g>f){f=g;}}if(c[b]==" "){for(var a=c.length-1;a>=0;a--){if(h[f-1]==c[a]){f--;break;}}}if(f>-1){e=f+1;while(h.charAt(e)==" "){e+=1;}d=h.substring(0,e);h=h.substr(e);}else{d="";}return{previous:d,query:h};};YAHOO.widget.AutoComplete.prototype._toggleContainerHelpers=function(d){var e=this._elContent.offsetWidth+"px";var b=this._elContent.offsetHeight+"px";if(this.useIFrame&&this._elIFrame){var c=this._elIFrame;if(d){c.style.width=e;c.style.height=b;c.style.padding="";}else{c.style.width=0;c.style.height=0;c.style.padding=0;}}if(this.useShadow&&this._elShadow){var a=this._elShadow;if(d){a.style.width=e;a.style.height=b;}else{a.style.width=0;a.style.height=0;}}};YAHOO.widget.AutoComplete.prototype._toggleContainer=function(i){var d=this._elContainer;if(this.alwaysShowContainer&&this._bContainerOpen){return;}if(!i){this._toggleHighlight(this._elCurListItem,"from");this._nDisplayedItems=0;this._sCurQuery=null;if(this._elContent.style.display=="none"){return;}}var a=this._oAnim;if(a&&a.getEl()&&(this.animHoriz||this.animVert)){if(a.isAnimated()){a.stop(true);}var g=this._elContent.cloneNode(true);d.appendChild(g);g.style.top="-9000px";g.style.width="";g.style.height="";g.style.display="";var f=g.offsetWidth;var c=g.offsetHeight;var b=(this.animHoriz)?0:f;var e=(this.animVert)?0:c;a.attributes=(i)?{width:{to:f},height:{to:c}}:{width:{to:b},height:{to:e}};if(i&&!this._bContainerOpen){this._elContent.style.width=b+"px";this._elContent.style.height=e+"px";}else{this._elContent.style.width=f+"px";this._elContent.style.height=c+"px";}d.removeChild(g);g=null;var h=this;var j=function(){a.onComplete.unsubscribeAll();if(i){h._toggleContainerHelpers(true);h._bContainerOpen=i;h.containerExpandEvent.fire(h);}else{h._elContent.style.display="none";h._bContainerOpen=i;h.containerCollapseEvent.fire(h);}};this._toggleContainerHelpers(false);this._elContent.style.display="";a.onComplete.subscribe(j);a.animate();}else{if(i){this._elContent.style.display="";this._toggleContainerHelpers(true);
this._bContainerOpen=i;this.containerExpandEvent.fire(this);}else{this._toggleContainerHelpers(false);this._elContent.style.display="none";this._bContainerOpen=i;this.containerCollapseEvent.fire(this);}}};YAHOO.widget.AutoComplete.prototype._toggleHighlight=function(a,c){if(a){var b=this.highlightClassName;if(this._elCurListItem){YAHOO.util.Dom.removeClass(this._elCurListItem,b);this._elCurListItem=null;}if((c=="to")&&b){YAHOO.util.Dom.addClass(a,b);this._elCurListItem=a;}}};YAHOO.widget.AutoComplete.prototype._togglePrehighlight=function(b,c){var a=this.prehighlightClassName;if(this._elCurPrehighlightItem){YAHOO.util.Dom.removeClass(this._elCurPrehighlightItem,a);}if(b==this._elCurListItem){return;}if((c=="mouseover")&&a){YAHOO.util.Dom.addClass(b,a);this._elCurPrehighlightItem=b;}else{YAHOO.util.Dom.removeClass(b,a);}};YAHOO.widget.AutoComplete.prototype._updateValue=function(c){if(!this.suppressInputUpdate){var f=this._elTextbox;var e=(this.delimChar)?(this.delimChar[0]||this.delimChar):null;var b=c._sResultMatch;var d="";if(e){d=this._sPastSelections;d+=b+e;if(e!=" "){d+=" ";}}else{d=b;}f.value=d;if(f.type=="textarea"){f.scrollTop=f.scrollHeight;}var a=f.value.length;this._selectText(f,a,a);this._elCurListItem=c;}};YAHOO.widget.AutoComplete.prototype._selectItem=function(a){this._bItemSelected=true;this._updateValue(a);this._sPastSelections=this._elTextbox.value;this._clearInterval();this.itemSelectEvent.fire(this,a,a._oResultData);this._toggleContainer(false);};YAHOO.widget.AutoComplete.prototype._jumpSelection=function(){if(this._elCurListItem){this._selectItem(this._elCurListItem);}else{this._toggleContainer(false);}};YAHOO.widget.AutoComplete.prototype._moveSelection=function(g){if(this._bContainerOpen){var h=this._elCurListItem,d=-1;if(h){d=h._nItemIndex;}var e=(g==40)?(d+1):(d-1);if(e<-2||e>=this._nDisplayedItems){return;}if(h){this._toggleHighlight(h,"from");this.itemArrowFromEvent.fire(this,h);}if(e==-1){if(this.delimChar){this._elTextbox.value=this._sPastSelections+this._sCurQuery;}else{this._elTextbox.value=this._sCurQuery;}return;}if(e==-2){this._toggleContainer(false);return;}var f=this._elList.childNodes[e],b=this._elContent,c=YAHOO.util.Dom.getStyle(b,"overflow"),i=YAHOO.util.Dom.getStyle(b,"overflowY"),a=((c=="auto")||(c=="scroll")||(i=="auto")||(i=="scroll"));if(a&&(e>-1)&&(e<this._nDisplayedItems)){if(g==40){if((f.offsetTop+f.offsetHeight)>(b.scrollTop+b.offsetHeight)){b.scrollTop=(f.offsetTop+f.offsetHeight)-b.offsetHeight;}else{if((f.offsetTop+f.offsetHeight)<b.scrollTop){b.scrollTop=f.offsetTop;}}}else{if(f.offsetTop<b.scrollTop){this._elContent.scrollTop=f.offsetTop;}else{if(f.offsetTop>(b.scrollTop+b.offsetHeight)){this._elContent.scrollTop=(f.offsetTop+f.offsetHeight)-b.offsetHeight;}}}}this._toggleHighlight(f,"to");this.itemArrowToEvent.fire(this,f);if(this.typeAhead){this._updateValue(f);this._sCurQuery=f._sResultMatch;}}};YAHOO.widget.AutoComplete.prototype._onContainerMouseover=function(a,c){var d=YAHOO.util.Event.getTarget(a);var b=d.nodeName.toLowerCase();while(d&&(b!="table")){switch(b){case"body":return;case"li":if(c.prehighlightClassName){c._togglePrehighlight(d,"mouseover");}else{c._toggleHighlight(d,"to");}c.itemMouseOverEvent.fire(c,d);break;case"div":if(YAHOO.util.Dom.hasClass(d,"yui-ac-container")){c._bOverContainer=true;return;}break;default:break;}d=d.parentNode;if(d){b=d.nodeName.toLowerCase();}}};YAHOO.widget.AutoComplete.prototype._onContainerMouseout=function(a,c){var d=YAHOO.util.Event.getTarget(a);var b=d.nodeName.toLowerCase();while(d&&(b!="table")){switch(b){case"body":return;case"li":if(c.prehighlightClassName){c._togglePrehighlight(d,"mouseout");}else{c._toggleHighlight(d,"from");}c.itemMouseOutEvent.fire(c,d);break;case"ul":c._toggleHighlight(c._elCurListItem,"to");break;case"div":if(YAHOO.util.Dom.hasClass(d,"yui-ac-container")){c._bOverContainer=false;return;}break;default:break;}d=d.parentNode;if(d){b=d.nodeName.toLowerCase();}}};YAHOO.widget.AutoComplete.prototype._onContainerClick=function(a,c){var d=YAHOO.util.Event.getTarget(a);var b=d.nodeName.toLowerCase();while(d&&(b!="table")){switch(b){case"body":return;case"li":c._toggleHighlight(d,"to");c._selectItem(d);return;default:break;}d=d.parentNode;if(d){b=d.nodeName.toLowerCase();}}};YAHOO.widget.AutoComplete.prototype._onContainerScroll=function(a,b){b._focus();};YAHOO.widget.AutoComplete.prototype._onContainerResize=function(a,b){b._toggleContainerHelpers(b._bContainerOpen);};YAHOO.widget.AutoComplete.prototype._onTextboxKeyDown=function(a,b){var c=a.keyCode;if(b._nTypeAheadDelayID!=-1){clearTimeout(b._nTypeAheadDelayID);}switch(c){case 9:if(!YAHOO.env.ua.opera&&(navigator.userAgent.toLowerCase().indexOf("mac")==-1)||(YAHOO.env.ua.webkit>420)){if(b._elCurListItem){if(b.delimChar&&(b._nKeyCode!=c)){if(b._bContainerOpen){YAHOO.util.Event.stopEvent(a);}}b._selectItem(b._elCurListItem);}else{b._toggleContainer(false);}}break;case 13:if(!YAHOO.env.ua.opera&&(navigator.userAgent.toLowerCase().indexOf("mac")==-1)||(YAHOO.env.ua.webkit>420)){if(b._elCurListItem){if(b._nKeyCode!=c){if(b._bContainerOpen){YAHOO.util.Event.stopEvent(a);}}b._selectItem(b._elCurListItem);}else{b._toggleContainer(false);}}break;case 27:b._toggleContainer(false);return;case 39:b._jumpSelection();break;case 38:if(b._bContainerOpen){YAHOO.util.Event.stopEvent(a);b._moveSelection(c);}break;case 40:if(b._bContainerOpen){YAHOO.util.Event.stopEvent(a);b._moveSelection(c);}break;default:b._bItemSelected=false;b._toggleHighlight(b._elCurListItem,"from");b.textboxKeyEvent.fire(b,c);break;}if(c===18){b._enableIntervalDetection();}b._nKeyCode=c;};YAHOO.widget.AutoComplete.prototype._onTextboxKeyPress=function(a,b){var c=a.keyCode;if(YAHOO.env.ua.opera||(navigator.userAgent.toLowerCase().indexOf("mac")!=-1)&&(YAHOO.env.ua.webkit<420)){switch(c){case 9:if(b._bContainerOpen){if(b.delimChar){YAHOO.util.Event.stopEvent(a);}if(b._elCurListItem){b._selectItem(b._elCurListItem);}else{b._toggleContainer(false);}}break;case 13:if(b._bContainerOpen){YAHOO.util.Event.stopEvent(a);
if(b._elCurListItem){b._selectItem(b._elCurListItem);}else{b._toggleContainer(false);}}break;default:break;}}else{if(c==229){b._enableIntervalDetection();}}};YAHOO.widget.AutoComplete.prototype._onTextboxKeyUp=function(a,c){var b=this.value;c._initProps();var d=a.keyCode;if(c._isIgnoreKey(d)){return;}if(c._nDelayID!=-1){clearTimeout(c._nDelayID);}c._nDelayID=setTimeout(function(){c._sendQuery(b);},(c.queryDelay*1000));};YAHOO.widget.AutoComplete.prototype._onTextboxFocus=function(a,b){if(!b._bFocused){b._elTextbox.setAttribute("autocomplete","off");b._bFocused=true;b._sInitInputValue=b._elTextbox.value;b.textboxFocusEvent.fire(b);}};YAHOO.widget.AutoComplete.prototype._onTextboxBlur=function(a,c){if(!c._bOverContainer||(c._nKeyCode==9)){if(!c._bItemSelected){var b=c._textMatchesOption();if(!c._bContainerOpen||(c._bContainerOpen&&(b===null))){if(c.forceSelection){c._clearSelection();}else{c.unmatchedItemSelectEvent.fire(c,c._sCurQuery);}}else{if(c.forceSelection){c._selectItem(b);}}}c._clearInterval();c._bFocused=false;if(c._sInitInputValue!==c._elTextbox.value){c.textboxChangeEvent.fire(c);}c.textboxBlurEvent.fire(c);c._toggleContainer(false);}else{c._focus();}};YAHOO.widget.AutoComplete.prototype._onWindowUnload=function(a,b){if(b&&b._elTextbox&&b.allowBrowserAutocomplete){b._elTextbox.setAttribute("autocomplete","on");}};YAHOO.widget.AutoComplete.prototype.doBeforeSendQuery=function(a){return this.generateRequest(a);};YAHOO.widget.AutoComplete.prototype.getListItems=function(){var c=[],b=this._elList.childNodes;for(var a=b.length-1;a>=0;a--){c[a]=b[a];}return c;};YAHOO.widget.AutoComplete._cloneObject=function(d){if(!YAHOO.lang.isValue(d)){return d;}var f={};if(YAHOO.lang.isFunction(d)){f=d;}else{if(YAHOO.lang.isArray(d)){var e=[];for(var c=0,b=d.length;c<b;c++){e[c]=YAHOO.widget.AutoComplete._cloneObject(d[c]);}f=e;}else{if(YAHOO.lang.isObject(d)){for(var a in d){if(YAHOO.lang.hasOwnProperty(d,a)){if(YAHOO.lang.isValue(d[a])&&YAHOO.lang.isObject(d[a])||YAHOO.lang.isArray(d[a])){f[a]=YAHOO.widget.AutoComplete._cloneObject(d[a]);}else{f[a]=d[a];}}}}else{f=d;}}}return f;};YAHOO.register("autocomplete",YAHOO.widget.AutoComplete,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/autocomplete/autocomplete-min.js
                                
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
function enableQS(noReload){YAHOO.util.Event.onDOMReady(function(){if(typeof sqs_objects=='undefined'){return;}
var Dom=YAHOO.util.Dom;var qsFields=Dom.getElementsByClassName('sqsEnabled');for(qsField in qsFields){if(typeof qsFields[qsField]=='function'||typeof qsFields[qsField].id=='undefined'){continue;}
form_id=qsFields[qsField].form.getAttribute('id');if(typeof form_id=='object'&&qsFields[qsField].form.getAttribute('real_id')){form_id=qsFields[qsField].form.getAttribute('real_id');}
qs_index_id=form_id+'_'+qsFields[qsField].name;if(typeof sqs_objects[qs_index_id]=='undefined'){qs_index_id=qsFields[qsField].name;if(typeof sqs_objects[qs_index_id]=='undefined'){continue;}}
if(QSProcessedFieldsArray[qs_index_id]){continue;}
var qs_obj=sqs_objects[qs_index_id];var loaded=false;if(!document.forms[qs_obj.form]){continue;}
if(!document.forms[qs_obj.form].elements[qsFields[qsField].id].readOnly&&qs_obj['disable']!=true){combo_id=qs_obj.form+'_'+qsFields[qsField].id;if(Dom.get(combo_id+"_results")){loaded=true}
if(!loaded){QSProcessedFieldsArray[qs_index_id]=true;qsFields[qsField].form_id=form_id;var sqs=sqs_objects[qs_index_id];var resultDiv=document.createElement('div');resultDiv.id=combo_id+"_results";Dom.insertAfter(resultDiv,qsFields[qsField]);var fields=qs_obj.field_list.slice();fields[fields.length]="module";var ds=new YAHOO.util.DataSource("index.php?",{responseType:YAHOO.util.XHRDataSource.TYPE_JSON,responseSchema:{resultsList:'fields',total:'totalCount',fields:fields,metaNode:"fields",metaFields:{total:'totalCount',fields:"fields"}},connMethodPost:true});var forceSelect=!((qsFields[qsField].form&&typeof(qsFields[qsField].form)=='object'&&qsFields[qsField].form.name=='search_form')||qsFields[qsField].className.match('sqsNoAutofill')!=null);var search=new YAHOO.widget.AutoComplete(qsFields[qsField],resultDiv,ds,{typeAhead:forceSelect,forceSelection:forceSelect,fields:fields,sqs:sqs,animSpeed:0.25,qs_obj:qs_obj,inputElement:qsFields[qsField],generateRequest:function(sQuery){var out=SUGAR.util.paramsToUrl({to_pdf:'true',module:'Home',action:'quicksearchQuery',data:encodeURIComponent(YAHOO.lang.JSON.stringify(this.sqs)),query:sQuery});return out;},setFields:function(data,filter){this.updateFields(data,filter);},updateFields:function(data,filter){for(var i in this.fields){for(var key in this.qs_obj.field_list){if(this.fields[i]==this.qs_obj.field_list[key]&&document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]]&&this.qs_obj.populate_list[key].match(filter)){var displayValue=data[i].replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]].value=displayValue;}}}},clearFields:function(){for(var key in this.qs_obj.field_list){if(document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]]){document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]].value="";}}
this.oldValue="";}});if(/^(billing_|shipping_)?account_name$/.exec(qsFields[qsField].name))
{search.clearFields=function(){};search.setFields=function(data,filter)
{var label_str='';var label_data_str='';var current_label_data_str='';var label_data_hash=new Array();for(var i in this.fields){for(var key in this.qs_obj.field_list){if(this.fields[i]==this.qs_obj.field_list[key]&&document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]]&&document.getElementById(this.qs_obj.populate_list[key]+'_label')&&this.qs_obj.populate_list[key].match(filter)){var displayValue=data[i].replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');var data_label=document.getElementById(this.qs_obj.populate_list[key]+'_label').innerHTML.replace(/\n/gi,'');label_and_data=data_label+' '+displayValue;if(document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]]&&!label_data_hash[data_label])
{label_str+=data_label+' \n';label_data_str+=label_and_data+'\n';label_data_hash[data_label]=true;current_label_data_str+=data_label+' '+document.forms[this.qs_obj.form].elements[this.qs_obj.populate_list[key]].value+'\n';}}}}
if(label_str!=current_label_data_str&&current_label_data_str!=label_data_str){module_key=(typeof document.forms[form_id].elements['module']!='undefined')?document.forms[form_id].elements['module'].value:'app_strings';warning_label=SUGAR.language.translate(module_key,'NTC_OVERWRITE_ADDRESS_PHONE_CONFIRM')+'\n\n'+label_data_str;if(!confirm(warning_label))
{this.updateFields(data,/account_id/);}else{if(Dom.get('shipping_checkbox'))
{if(this.inputElement.id=='shipping_account_name')
{filter=Dom.get('shipping_checkbox').checked?/(account_id|office_phone)/:filter;}else if(this.inputElement.id=='billing_account_name'){filter=Dom.get('shipping_checkbox').checked?filter:/(account_id|office_phone|billing)/;}}else if(Dom.get('alt_checkbox')){filter=Dom.get('alt_checkbox').checked?filter:/^(?!alt)/;}
this.updateFields(data,filter);}}else{this.updateFields(data,filter);}};}
if(typeof(SUGAR.config.quicksearch_querydelay)!='undefined'){search.queryDelay=SUGAR.config.quicksearch_querydelay;}
search.itemSelectEvent.subscribe(function(e,args){var data=args[2];var fields=this.fields;this.setFields(data,/\S/);if(typeof(this.qs_obj['post_onblur_function'])!='undefined'){collection_extended=new Array();for(var i in fields){for(var key in this.qs_obj.field_list){if(fields[i]==this.qs_obj.field_list[key]){collection_extended[this.qs_obj.field_list[key]]=data[i];}}}
eval(this.qs_obj['post_onblur_function']+'(collection_extended, this.qs_obj.id)');}});search.textboxFocusEvent.subscribe(function(){this.oldValue=this.getInputEl().value;});search.selectionEnforceEvent.subscribe(function(e,args){if(this.oldValue!=args[1]){this.clearFields();}else{this.getInputEl().value=this.oldValue;}});search.dataReturnEvent.subscribe(function(e,args){if(this.getInputEl().value.length==0&&args[2].length>0){var data=[];for(var key in this.qs_obj.field_list){data[data.length]=args[2][0][this.qs_obj.field_list[key]];}
this.getInputEl().value=data[this.key];this.itemSelectEvent.fire(this,"",data);}});search.typeAheadEvent.subscribe(function(e,args){this.getInputEl().value=this.getInputEl().value.replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');});if(typeof QSFieldsArray[combo_id]=='undefined'&&qsFields[qsField].id){QSFieldsArray[combo_id]=search;}}}}});}
function registerSingleSmartInputListener(input){if((c=input.className)&&(c.indexOf("sqsEnabled")!=-1)){enableQS(true);}}
if(typeof QSFieldsArray=='undefined'){QSFieldsArray=new Array();QSProcessedFieldsArray=new Array();}
// End of File include/javascript/quicksearch.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
(function(){var K=YAHOO.env.ua,C=YAHOO.util.Dom,Z=YAHOO.util.Event,H=YAHOO.lang,T="DIV",P="hd",M="bd",O="ft",X="LI",A="disabled",D="mouseover",F="mouseout",U="mousedown",G="mouseup",V="click",B="keydown",N="keyup",I="keypress",L="clicktohide",S="position",Q="dynamic",Y="showdelay",J="selected",E="visible",W="UL",R="MenuManager";YAHOO.widget.MenuManager=function(){var l=false,d={},o={},h={},c={"click":"clickEvent","mousedown":"mouseDownEvent","mouseup":"mouseUpEvent","mouseover":"mouseOverEvent","mouseout":"mouseOutEvent","keydown":"keyDownEvent","keyup":"keyUpEvent","keypress":"keyPressEvent","focus":"focusEvent","focusin":"focusEvent","blur":"blurEvent","focusout":"blurEvent"},i=null;function b(r){var p,q;if(r&&r.tagName){switch(r.tagName.toUpperCase()){case T:p=r.parentNode;if((C.hasClass(r,P)||C.hasClass(r,M)||C.hasClass(r,O))&&p&&p.tagName&&p.tagName.toUpperCase()==T){q=p;}else{q=r;}break;case X:q=r;break;default:p=r.parentNode;if(p){q=b(p);}break;}}return q;}function e(t){var p=Z.getTarget(t),q=b(p),u=true,w=t.type,x,r,s,z,y;if(q){r=q.tagName.toUpperCase();if(r==X){s=q.id;if(s&&h[s]){z=h[s];y=z.parent;}}else{if(r==T){if(q.id){y=d[q.id];}}}}if(y){x=c[w];if(w=="click"&&(K.gecko&&y.platform!="mac")&&t.button>0){u=false;}if(u&&z&&!z.cfg.getProperty(A)){z[x].fire(t);}if(u){y[x].fire(t,z);}}else{if(w==U){for(var v in o){if(H.hasOwnProperty(o,v)){y=o[v];if(y.cfg.getProperty(L)&&!(y instanceof YAHOO.widget.MenuBar)&&y.cfg.getProperty(S)==Q){y.hide();if(K.ie&&p.focus&&(K.ie<9)){p.setActive();}}else{if(y.cfg.getProperty(Y)>0){y._cancelShowDelay();}if(y.activeItem){y.activeItem.blur();y.activeItem.cfg.setProperty(J,false);y.activeItem=null;}}}}}}}function n(q,p,r){if(d[r.id]){this.removeMenu(r);}}function k(q,p){var r=p[1];if(r){i=r;}}function f(q,p){i=null;}function a(r,q){var p=q[0],s=this.id;if(p){o[s]=this;}else{if(o[s]){delete o[s];}}}function j(q,p){m(this);}function m(q){var p=q.id;if(p&&h[p]){if(i==q){i=null;}delete h[p];q.destroyEvent.unsubscribe(j);}}function g(q,p){var s=p[0],r;if(s instanceof YAHOO.widget.MenuItem){r=s.id;if(!h[r]){h[r]=s;s.destroyEvent.subscribe(j);}}}return{addMenu:function(q){var p;if(q instanceof YAHOO.widget.Menu&&q.id&&!d[q.id]){d[q.id]=q;if(!l){p=document;Z.on(p,D,e,this,true);Z.on(p,F,e,this,true);Z.on(p,U,e,this,true);Z.on(p,G,e,this,true);Z.on(p,V,e,this,true);Z.on(p,B,e,this,true);Z.on(p,N,e,this,true);Z.on(p,I,e,this,true);Z.onFocus(p,e,this,true);Z.onBlur(p,e,this,true);l=true;}q.cfg.subscribeToConfigEvent(E,a);q.destroyEvent.subscribe(n,q,this);q.itemAddedEvent.subscribe(g);q.focusEvent.subscribe(k);q.blurEvent.subscribe(f);}},removeMenu:function(s){var q,p,r;if(s){q=s.id;if((q in d)&&(d[q]==s)){p=s.getItems();if(p&&p.length>0){r=p.length-1;do{m(p[r]);}while(r--);}delete d[q];if((q in o)&&(o[q]==s)){delete o[q];}if(s.cfg){s.cfg.unsubscribeFromConfigEvent(E,a);}s.destroyEvent.unsubscribe(n,s);s.itemAddedEvent.unsubscribe(g);s.focusEvent.unsubscribe(k);s.blurEvent.unsubscribe(f);}}},hideVisible:function(){var p;for(var q in o){if(H.hasOwnProperty(o,q)){p=o[q];if(!(p instanceof YAHOO.widget.MenuBar)&&p.cfg.getProperty(S)==Q){p.hide();}}}},getVisible:function(){return o;},getMenus:function(){return d;},getMenu:function(q){var p;if(q in d){p=d[q];}return p;},getMenuItem:function(q){var p;if(q in h){p=h[q];}return p;},getMenuItemGroup:function(t){var q=C.get(t),p,v,u,r,s;if(q&&q.tagName&&q.tagName.toUpperCase()==W){v=q.firstChild;if(v){p=[];do{r=v.id;if(r){u=this.getMenuItem(r);if(u){p[p.length]=u;}}}while((v=v.nextSibling));if(p.length>0){s=p;}}}return s;},getFocusedMenuItem:function(){return i;},getFocusedMenu:function(){var p;if(i){p=i.parent.getRoot();}return p;},toString:function(){return R;}};}();})();(function(){var AM=YAHOO.lang,Aq="Menu",G="DIV",K="div",Am="id",AH="SELECT",e="xy",R="y",Ax="UL",L="ul",AJ="first-of-type",k="LI",h="OPTGROUP",Az="OPTION",Ah="disabled",AY="none",y="selected",At="groupindex",i="index",O="submenu",Au="visible",AX="hidedelay",Ac="position",AD="dynamic",C="static",An=AD+","+C,Q="url",M="#",V="target",AU="maxheight",T="topscrollbar",x="bottomscrollbar",d="_",P=T+d+Ah,E=x+d+Ah,b="mousemove",Av="showdelay",c="submenuhidedelay",AF="iframe",w="constraintoviewport",A4="preventcontextoverlap",AO="submenualignment",Z="autosubmenudisplay",AC="clicktohide",g="container",j="scrollincrement",Aj="minscrollheight",A2="classname",Ag="shadow",Ar="keepopen",A0="hd",D="hastitle",p="context",u="",Ak="mousedown",Ae="keydown",Ao="height",U="width",AQ="px",Ay="effect",AE="monitorresize",AW="display",AV="block",J="visibility",z="absolute",AS="zindex",l="yui-menu-body-scrolled",AK="&#32;",A1=" ",Ai="mouseover",H="mouseout",AR="itemAdded",n="itemRemoved",AL="hidden",s="yui-menu-shadow",AG=s+"-visible",m=s+A1+AG;YAHOO.widget.Menu=function(A6,A5){if(A5){this.parent=A5.parent;this.lazyLoad=A5.lazyLoad||A5.lazyload;this.itemData=A5.itemData||A5.itemdata;}YAHOO.widget.Menu.superclass.constructor.call(this,A6,A5);};function B(A6){var A5=false;if(AM.isString(A6)){A5=(An.indexOf((A6.toLowerCase()))!=-1);}return A5;}var f=YAHOO.util.Dom,AA=YAHOO.util.Event,Aw=YAHOO.widget.Module,AB=YAHOO.widget.Overlay,r=YAHOO.widget.Menu,A3=YAHOO.widget.MenuManager,F=YAHOO.util.CustomEvent,As=YAHOO.env.ua,Ap,AT=false,Ad,Ab=[["mouseOverEvent",Ai],["mouseOutEvent",H],["mouseDownEvent",Ak],["mouseUpEvent","mouseup"],["clickEvent","click"],["keyPressEvent","keypress"],["keyDownEvent",Ae],["keyUpEvent","keyup"],["focusEvent","focus"],["blurEvent","blur"],["itemAddedEvent",AR],["itemRemovedEvent",n]],AZ={key:Au,value:false,validator:AM.isBoolean},AP={key:w,value:true,validator:AM.isBoolean,supercedes:[AF,"x",R,e]},AI={key:A4,value:true,validator:AM.isBoolean,supercedes:[w]},S={key:Ac,value:AD,validator:B,supercedes:[Au,AF]},A={key:AO,value:["tl","tr"]},t={key:Z,value:true,validator:AM.isBoolean,suppressEvent:true},Y={key:Av,value:250,validator:AM.isNumber,suppressEvent:true},q={key:AX,value:0,validator:AM.isNumber,suppressEvent:true},v={key:c,value:250,validator:AM.isNumber,suppressEvent:true},o={key:AC,value:true,validator:AM.isBoolean,suppressEvent:true},AN={key:g,suppressEvent:true},Af={key:j,value:1,validator:AM.isNumber,supercedes:[AU],suppressEvent:true},N={key:Aj,value:90,validator:AM.isNumber,supercedes:[AU],suppressEvent:true},X={key:AU,value:0,validator:AM.isNumber,supercedes:[AF],suppressEvent:true},W={key:A2,value:null,validator:AM.isString,suppressEvent:true},a={key:Ah,value:false,validator:AM.isBoolean,suppressEvent:true},I={key:Ag,value:true,validator:AM.isBoolean,suppressEvent:true,supercedes:[Au]},Al={key:Ar,value:false,validator:AM.isBoolean};
function Aa(A5){Ad=AA.getTarget(A5);}YAHOO.lang.extend(r,AB,{CSS_CLASS_NAME:"yuimenu",ITEM_TYPE:null,GROUP_TITLE_TAG_NAME:"h6",OFF_SCREEN_POSITION:"-999em",_useHideDelay:false,_bHandledMouseOverEvent:false,_bHandledMouseOutEvent:false,_aGroupTitleElements:null,_aItemGroups:null,_aListElements:null,_nCurrentMouseX:0,_bStopMouseEventHandlers:false,_sClassName:null,lazyLoad:false,itemData:null,activeItem:null,parent:null,srcElement:null,init:function(A7,A6){this._aItemGroups=[];this._aListElements=[];this._aGroupTitleElements=[];if(!this.ITEM_TYPE){this.ITEM_TYPE=YAHOO.widget.MenuItem;}var A5;if(AM.isString(A7)){A5=f.get(A7);}else{if(A7.tagName){A5=A7;}}if(A5&&A5.tagName){switch(A5.tagName.toUpperCase()){case G:this.srcElement=A5;if(!A5.id){A5.setAttribute(Am,f.generateId());}r.superclass.init.call(this,A5);this.beforeInitEvent.fire(r);break;case AH:this.srcElement=A5;r.superclass.init.call(this,f.generateId());this.beforeInitEvent.fire(r);break;}}else{r.superclass.init.call(this,A7);this.beforeInitEvent.fire(r);}if(this.element){f.addClass(this.element,this.CSS_CLASS_NAME);this.initEvent.subscribe(this._onInit);this.beforeRenderEvent.subscribe(this._onBeforeRender);this.renderEvent.subscribe(this._onRender);this.beforeShowEvent.subscribe(this._onBeforeShow);this.hideEvent.subscribe(this._onHide);this.showEvent.subscribe(this._onShow);this.beforeHideEvent.subscribe(this._onBeforeHide);this.mouseOverEvent.subscribe(this._onMouseOver);this.mouseOutEvent.subscribe(this._onMouseOut);this.clickEvent.subscribe(this._onClick);this.keyDownEvent.subscribe(this._onKeyDown);this.keyPressEvent.subscribe(this._onKeyPress);this.blurEvent.subscribe(this._onBlur);if(!AT){AA.onFocus(document,Aa);AT=true;}if((As.gecko&&As.gecko<1.9)||(As.webkit&&As.webkit<523)){this.cfg.subscribeToConfigEvent(R,this._onYChange);}if(A6){this.cfg.applyConfig(A6,true);}A3.addMenu(this);this.initEvent.fire(r);}},_initSubTree:function(){var A6=this.srcElement,A5,A8,BB,BC,BA,A9,A7;if(A6){A5=(A6.tagName&&A6.tagName.toUpperCase());if(A5==G){BC=this.body.firstChild;if(BC){A8=0;BB=this.GROUP_TITLE_TAG_NAME.toUpperCase();do{if(BC&&BC.tagName){switch(BC.tagName.toUpperCase()){case BB:this._aGroupTitleElements[A8]=BC;break;case Ax:this._aListElements[A8]=BC;this._aItemGroups[A8]=[];A8++;break;}}}while((BC=BC.nextSibling));if(this._aListElements[0]){f.addClass(this._aListElements[0],AJ);}}}BC=null;if(A5){switch(A5){case G:BA=this._aListElements;A9=BA.length;if(A9>0){A7=A9-1;do{BC=BA[A7].firstChild;if(BC){do{if(BC&&BC.tagName&&BC.tagName.toUpperCase()==k){this.addItem(new this.ITEM_TYPE(BC,{parent:this}),A7);}}while((BC=BC.nextSibling));}}while(A7--);}break;case AH:BC=A6.firstChild;do{if(BC&&BC.tagName){switch(BC.tagName.toUpperCase()){case h:case Az:this.addItem(new this.ITEM_TYPE(BC,{parent:this}));break;}}}while((BC=BC.nextSibling));break;}}}},_getFirstEnabledItem:function(){var A5=this.getItems(),A9=A5.length,A8,A7;for(var A6=0;A6<A9;A6++){A8=A5[A6];if(A8&&!A8.cfg.getProperty(Ah)&&A8.element.style.display!=AY){A7=A8;break;}}return A7;},_addItemToGroup:function(BA,BB,BF){var BD,BG,A8,BE,A9,A6,A7,BC;function A5(BH,BI){return(BH[BI]||A5(BH,(BI+1)));}if(BB instanceof this.ITEM_TYPE){BD=BB;BD.parent=this;}else{if(AM.isString(BB)){BD=new this.ITEM_TYPE(BB,{parent:this});}else{if(AM.isObject(BB)){BB.parent=this;BD=new this.ITEM_TYPE(BB.text,BB);}}}if(BD){if(BD.cfg.getProperty(y)){this.activeItem=BD;}BG=AM.isNumber(BA)?BA:0;A8=this._getItemGroup(BG);if(!A8){A8=this._createItemGroup(BG);}if(AM.isNumber(BF)){A9=(BF>=A8.length);if(A8[BF]){A8.splice(BF,0,BD);}else{A8[BF]=BD;}BE=A8[BF];if(BE){if(A9&&(!BE.element.parentNode||BE.element.parentNode.nodeType==11)){this._aListElements[BG].appendChild(BE.element);}else{A6=A5(A8,(BF+1));if(A6&&(!BE.element.parentNode||BE.element.parentNode.nodeType==11)){this._aListElements[BG].insertBefore(BE.element,A6.element);}}BE.parent=this;this._subscribeToItemEvents(BE);this._configureSubmenu(BE);this._updateItemProperties(BG);this.itemAddedEvent.fire(BE);this.changeContentEvent.fire();BC=BE;}}else{A7=A8.length;A8[A7]=BD;BE=A8[A7];if(BE){if(!f.isAncestor(this._aListElements[BG],BE.element)){this._aListElements[BG].appendChild(BE.element);}BE.element.setAttribute(At,BG);BE.element.setAttribute(i,A7);BE.parent=this;BE.index=A7;BE.groupIndex=BG;this._subscribeToItemEvents(BE);this._configureSubmenu(BE);if(A7===0){f.addClass(BE.element,AJ);}this.itemAddedEvent.fire(BE);this.changeContentEvent.fire();BC=BE;}}}return BC;},_removeItemFromGroupByIndex:function(A8,A6){var A7=AM.isNumber(A8)?A8:0,A9=this._getItemGroup(A7),BB,BA,A5;if(A9){BB=A9.splice(A6,1);BA=BB[0];if(BA){this._updateItemProperties(A7);if(A9.length===0){A5=this._aListElements[A7];if(A5&&A5.parentNode){A5.parentNode.removeChild(A5);}this._aItemGroups.splice(A7,1);this._aListElements.splice(A7,1);A5=this._aListElements[0];if(A5){f.addClass(A5,AJ);}}this.itemRemovedEvent.fire(BA);this.changeContentEvent.fire();}}return BA;},_removeItemFromGroupByValue:function(A8,A5){var BA=this._getItemGroup(A8),BB,A9,A7,A6;if(BA){BB=BA.length;A9=-1;if(BB>0){A6=BB-1;do{if(BA[A6]==A5){A9=A6;break;}}while(A6--);if(A9>-1){A7=this._removeItemFromGroupByIndex(A8,A9);}}}return A7;},_updateItemProperties:function(A6){var A7=this._getItemGroup(A6),BA=A7.length,A9,A8,A5;if(BA>0){A5=BA-1;do{A9=A7[A5];if(A9){A8=A9.element;A9.index=A5;A9.groupIndex=A6;A8.setAttribute(At,A6);A8.setAttribute(i,A5);f.removeClass(A8,AJ);}}while(A5--);if(A8){f.addClass(A8,AJ);}}},_createItemGroup:function(A7){var A5,A6;if(!this._aItemGroups[A7]){this._aItemGroups[A7]=[];A5=document.createElement(L);this._aListElements[A7]=A5;A6=this._aItemGroups[A7];}return A6;},_getItemGroup:function(A7){var A5=AM.isNumber(A7)?A7:0,A8=this._aItemGroups,A6;if(A5 in A8){A6=A8[A5];}return A6;},_configureSubmenu:function(A5){var A6=A5.cfg.getProperty(O);if(A6){this.cfg.configChangedEvent.subscribe(this._onParentMenuConfigChange,A6,true);this.renderEvent.subscribe(this._onParentMenuRender,A6,true);}},_subscribeToItemEvents:function(A5){A5.destroyEvent.subscribe(this._onMenuItemDestroy,A5,this);
A5.cfg.configChangedEvent.subscribe(this._onMenuItemConfigChange,A5,this);},_onVisibleChange:function(A7,A6){var A5=A6[0];if(A5){f.addClass(this.element,Au);}else{f.removeClass(this.element,Au);}},_cancelHideDelay:function(){var A5=this.getRoot()._hideDelayTimer;if(A5){A5.cancel();}},_execHideDelay:function(){this._cancelHideDelay();var A5=this.getRoot();A5._hideDelayTimer=AM.later(A5.cfg.getProperty(AX),this,function(){if(A5.activeItem){if(A5.hasFocus()){A5.activeItem.focus();}A5.clearActiveItem();}if(A5==this&&!(this instanceof YAHOO.widget.MenuBar)&&this.cfg.getProperty(Ac)==AD){this.hide();}});},_cancelShowDelay:function(){var A5=this.getRoot()._showDelayTimer;if(A5){A5.cancel();}},_execSubmenuHideDelay:function(A7,A6,A5){A7._submenuHideDelayTimer=AM.later(50,this,function(){if(this._nCurrentMouseX>(A6+10)){A7._submenuHideDelayTimer=AM.later(A5,A7,function(){this.hide();});}else{A7.hide();}});},_disableScrollHeader:function(){if(!this._bHeaderDisabled){f.addClass(this.header,P);this._bHeaderDisabled=true;}},_disableScrollFooter:function(){if(!this._bFooterDisabled){f.addClass(this.footer,E);this._bFooterDisabled=true;}},_enableScrollHeader:function(){if(this._bHeaderDisabled){f.removeClass(this.header,P);this._bHeaderDisabled=false;}},_enableScrollFooter:function(){if(this._bFooterDisabled){f.removeClass(this.footer,E);this._bFooterDisabled=false;}},_onMouseOver:function(BH,BA){var BI=BA[0],BE=BA[1],A5=AA.getTarget(BI),A9=this.getRoot(),BG=this._submenuHideDelayTimer,A6,A8,BD,A7,BC,BB;var BF=function(){if(this.parent.cfg.getProperty(y)){this.show();}};if(!this._bStopMouseEventHandlers){if(!this._bHandledMouseOverEvent&&(A5==this.element||f.isAncestor(this.element,A5))){if(this._useHideDelay){this._cancelHideDelay();}this._nCurrentMouseX=0;AA.on(this.element,b,this._onMouseMove,this,true);if(!(BE&&f.isAncestor(BE.element,AA.getRelatedTarget(BI)))){this.clearActiveItem();}if(this.parent&&BG){BG.cancel();this.parent.cfg.setProperty(y,true);A6=this.parent.parent;A6._bHandledMouseOutEvent=true;A6._bHandledMouseOverEvent=false;}this._bHandledMouseOverEvent=true;this._bHandledMouseOutEvent=false;}if(BE&&!BE.handledMouseOverEvent&&!BE.cfg.getProperty(Ah)&&(A5==BE.element||f.isAncestor(BE.element,A5))){A8=this.cfg.getProperty(Av);BD=(A8>0);if(BD){this._cancelShowDelay();}A7=this.activeItem;if(A7){A7.cfg.setProperty(y,false);}BC=BE.cfg;BC.setProperty(y,true);if(this.hasFocus()||A9._hasFocus){BE.focus();A9._hasFocus=false;}if(this.cfg.getProperty(Z)){BB=BC.getProperty(O);if(BB){if(BD){A9._showDelayTimer=AM.later(A9.cfg.getProperty(Av),BB,BF);}else{BB.show();}}}BE.handledMouseOverEvent=true;BE.handledMouseOutEvent=false;}}},_onMouseOut:function(BD,A7){var BE=A7[0],BB=A7[1],A8=AA.getRelatedTarget(BE),BC=false,BA,A9,A5,A6;if(!this._bStopMouseEventHandlers){if(BB&&!BB.cfg.getProperty(Ah)){BA=BB.cfg;A9=BA.getProperty(O);if(A9&&(A8==A9.element||f.isAncestor(A9.element,A8))){BC=true;}if(!BB.handledMouseOutEvent&&((A8!=BB.element&&!f.isAncestor(BB.element,A8))||BC)){if(!BC){BB.cfg.setProperty(y,false);if(A9){A5=this.cfg.getProperty(c);A6=this.cfg.getProperty(Av);if(!(this instanceof YAHOO.widget.MenuBar)&&A5>0&&A5>=A6){this._execSubmenuHideDelay(A9,AA.getPageX(BE),A5);}else{A9.hide();}}}BB.handledMouseOutEvent=true;BB.handledMouseOverEvent=false;}}if(!this._bHandledMouseOutEvent){if(this._didMouseLeave(A8)||BC){if(this._useHideDelay){this._execHideDelay();}AA.removeListener(this.element,b,this._onMouseMove);this._nCurrentMouseX=AA.getPageX(BE);this._bHandledMouseOutEvent=true;this._bHandledMouseOverEvent=false;}}}},_didMouseLeave:function(A5){return(A5===this._shadow||(A5!=this.element&&!f.isAncestor(this.element,A5)));},_onMouseMove:function(A6,A5){if(!this._bStopMouseEventHandlers){this._nCurrentMouseX=AA.getPageX(A6);}},_onClick:function(BG,A7){var BH=A7[0],BB=A7[1],BD=false,A9,BE,A6,A5,BA,BC,BF;var A8=function(){A6=this.getRoot();if(A6 instanceof YAHOO.widget.MenuBar||A6.cfg.getProperty(Ac)==C){A6.clearActiveItem();}else{A6.hide();}};if(BB){if(BB.cfg.getProperty(Ah)){AA.preventDefault(BH);A8.call(this);}else{A9=BB.cfg.getProperty(O);BA=BB.cfg.getProperty(Q);if(BA){BC=BA.indexOf(M);BF=BA.length;if(BC!=-1){BA=BA.substr(BC,BF);BF=BA.length;if(BF>1){A5=BA.substr(1,BF);BE=YAHOO.widget.MenuManager.getMenu(A5);if(BE){BD=(this.getRoot()===BE.getRoot());}}else{if(BF===1){BD=true;}}}}if(BD&&!BB.cfg.getProperty(V)){AA.preventDefault(BH);if(As.webkit){BB.focus();}else{BB.focusEvent.fire();}}if(!A9&&!this.cfg.getProperty(Ar)){A8.call(this);}}}},_stopMouseEventHandlers:function(){this._bStopMouseEventHandlers=true;AM.later(10,this,function(){this._bStopMouseEventHandlers=false;});},_onKeyDown:function(BJ,BD){var BG=BD[0],BF=BD[1],BC,BH,A6,A9,BK,A5,BN,A8,BI,A7,BE,BM,BA,BB;if(this._useHideDelay){this._cancelHideDelay();}if(BF&&!BF.cfg.getProperty(Ah)){BH=BF.cfg;A6=this.parent;switch(BG.keyCode){case 38:case 40:BK=(BG.keyCode==38)?BF.getPreviousEnabledSibling():BF.getNextEnabledSibling();if(BK){this.clearActiveItem();BK.cfg.setProperty(y,true);BK.focus();if(this.cfg.getProperty(AU)>0||f.hasClass(this.body,l)){A5=this.body;BN=A5.scrollTop;A8=A5.offsetHeight;BI=this.getItems();A7=BI.length-1;BE=BK.element.offsetTop;if(BG.keyCode==40){if(BE>=(A8+BN)){A5.scrollTop=BE-A8;}else{if(BE<=BN){A5.scrollTop=0;}}if(BK==BI[A7]){A5.scrollTop=BK.element.offsetTop;}}else{if(BE<=BN){A5.scrollTop=BE-BK.element.offsetHeight;}else{if(BE>=(BN+A8)){A5.scrollTop=BE;}}if(BK==BI[0]){A5.scrollTop=0;}}BN=A5.scrollTop;BM=A5.scrollHeight-A5.offsetHeight;if(BN===0){this._disableScrollHeader();this._enableScrollFooter();}else{if(BN==BM){this._enableScrollHeader();this._disableScrollFooter();}else{this._enableScrollHeader();this._enableScrollFooter();}}}}AA.preventDefault(BG);this._stopMouseEventHandlers();break;case 39:BC=BH.getProperty(O);if(BC){if(!BH.getProperty(y)){BH.setProperty(y,true);}BC.show();BC.setInitialFocus();BC.setInitialSelection();}else{A9=this.getRoot();if(A9 instanceof YAHOO.widget.MenuBar){BK=A9.activeItem.getNextEnabledSibling();
if(BK){A9.clearActiveItem();BK.cfg.setProperty(y,true);BC=BK.cfg.getProperty(O);if(BC){BC.show();BC.setInitialFocus();}else{BK.focus();}}}}AA.preventDefault(BG);this._stopMouseEventHandlers();break;case 37:if(A6){BA=A6.parent;if(BA instanceof YAHOO.widget.MenuBar){BK=BA.activeItem.getPreviousEnabledSibling();if(BK){BA.clearActiveItem();BK.cfg.setProperty(y,true);BC=BK.cfg.getProperty(O);if(BC){BC.show();BC.setInitialFocus();}else{BK.focus();}}}else{this.hide();A6.focus();}}AA.preventDefault(BG);this._stopMouseEventHandlers();break;}}if(BG.keyCode==27){if(this.cfg.getProperty(Ac)==AD){this.hide();if(this.parent){this.parent.focus();}else{BB=this._focusedElement;if(BB&&BB.focus){try{BB.focus();}catch(BL){}}}}else{if(this.activeItem){BC=this.activeItem.cfg.getProperty(O);if(BC&&BC.cfg.getProperty(Au)){BC.hide();this.activeItem.focus();}else{this.activeItem.blur();this.activeItem.cfg.setProperty(y,false);}}}AA.preventDefault(BG);}},_onKeyPress:function(A7,A6){var A5=A6[0];if(A5.keyCode==40||A5.keyCode==38){AA.preventDefault(A5);}},_onBlur:function(A6,A5){if(this._hasFocus){this._hasFocus=false;}},_onYChange:function(A6,A5){var A8=this.parent,BA,A7,A9;if(A8){BA=A8.parent.body.scrollTop;if(BA>0){A9=(this.cfg.getProperty(R)-BA);f.setY(this.element,A9);A7=this.iframe;if(A7){f.setY(A7,A9);}this.cfg.setProperty(R,A9,true);}}},_onScrollTargetMouseOver:function(BB,BE){var BD=this._bodyScrollTimer;if(BD){BD.cancel();}this._cancelHideDelay();var A7=AA.getTarget(BB),A9=this.body,A8=this.cfg.getProperty(j),A5,A6;function BC(){var BF=A9.scrollTop;if(BF<A5){A9.scrollTop=(BF+A8);this._enableScrollHeader();}else{A9.scrollTop=A5;this._bodyScrollTimer.cancel();this._disableScrollFooter();}}function BA(){var BF=A9.scrollTop;if(BF>0){A9.scrollTop=(BF-A8);this._enableScrollFooter();}else{A9.scrollTop=0;this._bodyScrollTimer.cancel();this._disableScrollHeader();}}if(f.hasClass(A7,A0)){A6=BA;}else{A5=A9.scrollHeight-A9.offsetHeight;A6=BC;}this._bodyScrollTimer=AM.later(10,this,A6,null,true);},_onScrollTargetMouseOut:function(A7,A5){var A6=this._bodyScrollTimer;if(A6){A6.cancel();}this._cancelHideDelay();},_onInit:function(A6,A5){this.cfg.subscribeToConfigEvent(Au,this._onVisibleChange);var A7=!this.parent,A8=this.lazyLoad;if(((A7&&!A8)||(A7&&(this.cfg.getProperty(Au)||this.cfg.getProperty(Ac)==C))||(!A7&&!A8))&&this.getItemGroups().length===0){if(this.srcElement){this._initSubTree();}if(this.itemData){this.addItems(this.itemData);}}else{if(A8){this.cfg.fireQueue();}}},_onBeforeRender:function(A8,A7){var A9=this.element,BC=this._aListElements.length,A6=true,BB=0,A5,BA;if(BC>0){do{A5=this._aListElements[BB];if(A5){if(A6){f.addClass(A5,AJ);A6=false;}if(!f.isAncestor(A9,A5)){this.appendToBody(A5);}BA=this._aGroupTitleElements[BB];if(BA){if(!f.isAncestor(A9,BA)){A5.parentNode.insertBefore(BA,A5);}f.addClass(A5,D);}}BB++;}while(BB<BC);}},_onRender:function(A6,A5){if(this.cfg.getProperty(Ac)==AD){if(!this.cfg.getProperty(Au)){this.positionOffScreen();}}},_onBeforeShow:function(A7,A6){var A9,BC,A8,BA=this.cfg.getProperty(g);if(this.lazyLoad&&this.getItemGroups().length===0){if(this.srcElement){this._initSubTree();}if(this.itemData){if(this.parent&&this.parent.parent&&this.parent.parent.srcElement&&this.parent.parent.srcElement.tagName.toUpperCase()==AH){A9=this.itemData.length;for(BC=0;BC<A9;BC++){if(this.itemData[BC].tagName){this.addItem((new this.ITEM_TYPE(this.itemData[BC])));}}}else{this.addItems(this.itemData);}}A8=this.srcElement;if(A8){if(A8.tagName.toUpperCase()==AH){if(f.inDocument(A8)){this.render(A8.parentNode);}else{this.render(BA);}}else{this.render();}}else{if(this.parent){this.render(this.parent.element);}else{this.render(BA);}}}var BB=this.parent,A5;if(!BB&&this.cfg.getProperty(Ac)==AD){this.cfg.refireEvent(e);}if(BB){A5=BB.parent.cfg.getProperty(AO);this.cfg.setProperty(p,[BB.element,A5[0],A5[1]]);this.align();}},getConstrainedY:function(BH){var BS=this,BO=BS.cfg.getProperty(p),BV=BS.cfg.getProperty(AU),BR,BG={"trbr":true,"tlbl":true,"bltl":true,"brtr":true},BA=(BO&&BG[BO[1]+BO[2]]),BC=BS.element,BW=BC.offsetHeight,BQ=AB.VIEWPORT_OFFSET,BL=f.getViewportHeight(),BP=f.getDocumentScrollTop(),BM=(BS.cfg.getProperty(Aj)+BQ<BL),BU,BD,BJ,BK,BF=false,BE,A7,BI=BP+BQ,A9=BP+BL-BW-BQ,A5=BH;var BB=function(){var BX;if((BS.cfg.getProperty(R)-BP)>BJ){BX=(BJ-BW);}else{BX=(BJ+BK);}BS.cfg.setProperty(R,(BX+BP),true);return BX;};var A8=function(){if((BS.cfg.getProperty(R)-BP)>BJ){return(A7-BQ);}else{return(BE-BQ);}};var BN=function(){var BX;if((BS.cfg.getProperty(R)-BP)>BJ){BX=(BJ+BK);}else{BX=(BJ-BC.offsetHeight);}BS.cfg.setProperty(R,(BX+BP),true);};var A6=function(){BS._setScrollHeight(this.cfg.getProperty(AU));BS.hideEvent.unsubscribe(A6);};var BT=function(){var Ba=A8(),BX=(BS.getItems().length>0),BZ,BY;if(BW>Ba){BZ=BX?BS.cfg.getProperty(Aj):BW;if((Ba>BZ)&&BX){BR=Ba;}else{BR=BV;}BS._setScrollHeight(BR);BS.hideEvent.subscribe(A6);BN();if(Ba<BZ){if(BF){BB();}else{BB();BF=true;BY=BT();}}}else{if(BR&&(BR!==BV)){BS._setScrollHeight(BV);BS.hideEvent.subscribe(A6);BN();}}return BY;};if(BH<BI||BH>A9){if(BM){if(BS.cfg.getProperty(A4)&&BA){BD=BO[0];BK=BD.offsetHeight;BJ=(f.getY(BD)-BP);BE=BJ;A7=(BL-(BJ+BK));BT();A5=BS.cfg.getProperty(R);}else{if(!(BS instanceof YAHOO.widget.MenuBar)&&BW>=BL){BU=(BL-(BQ*2));if(BU>BS.cfg.getProperty(Aj)){BS._setScrollHeight(BU);BS.hideEvent.subscribe(A6);BN();A5=BS.cfg.getProperty(R);}}else{if(BH<BI){A5=BI;}else{if(BH>A9){A5=A9;}}}}}else{A5=BQ+BP;}}return A5;},_onHide:function(A6,A5){if(this.cfg.getProperty(Ac)===AD){this.positionOffScreen();}},_onShow:function(BD,BB){var A5=this.parent,A7,A8,BA,A6;function A9(BF){var BE;if(BF.type==Ak||(BF.type==Ae&&BF.keyCode==27)){BE=AA.getTarget(BF);if(BE!=A7.element||!f.isAncestor(A7.element,BE)){A7.cfg.setProperty(Z,false);AA.removeListener(document,Ak,A9);AA.removeListener(document,Ae,A9);}}}function BC(BF,BE,BG){this.cfg.setProperty(U,u);this.hideEvent.unsubscribe(BC,BG);}if(A5){A7=A5.parent;if(!A7.cfg.getProperty(Z)&&(A7 instanceof YAHOO.widget.MenuBar||A7.cfg.getProperty(Ac)==C)){A7.cfg.setProperty(Z,true);
AA.on(document,Ak,A9);AA.on(document,Ae,A9);}if((this.cfg.getProperty("x")<A7.cfg.getProperty("x"))&&(As.gecko&&As.gecko<1.9)&&!this.cfg.getProperty(U)){A8=this.element;BA=A8.offsetWidth;A8.style.width=BA+AQ;A6=(BA-(A8.offsetWidth-BA))+AQ;this.cfg.setProperty(U,A6);this.hideEvent.subscribe(BC,A6);}}if(this===this.getRoot()&&this.cfg.getProperty(Ac)===AD){this._focusedElement=Ad;this.focus();}},_onBeforeHide:function(A7,A6){var A5=this.activeItem,A9=this.getRoot(),BA,A8;if(A5){BA=A5.cfg;BA.setProperty(y,false);A8=BA.getProperty(O);if(A8){A8.hide();}}if(As.ie&&this.cfg.getProperty(Ac)===AD&&this.parent){A9._hasFocus=this.hasFocus();}if(A9==this){A9.blur();}},_onParentMenuConfigChange:function(A6,A5,A9){var A7=A5[0][0],A8=A5[0][1];switch(A7){case AF:case w:case AX:case Av:case c:case AC:case Ay:case A2:case j:case AU:case Aj:case AE:case Ag:case A4:case Ar:A9.cfg.setProperty(A7,A8);break;case AO:if(!(this.parent.parent instanceof YAHOO.widget.MenuBar)){A9.cfg.setProperty(A7,A8);}break;}},_onParentMenuRender:function(A6,A5,BB){var A8=BB.parent.parent,A7=A8.cfg,A9={constraintoviewport:A7.getProperty(w),xy:[0,0],clicktohide:A7.getProperty(AC),effect:A7.getProperty(Ay),showdelay:A7.getProperty(Av),hidedelay:A7.getProperty(AX),submenuhidedelay:A7.getProperty(c),classname:A7.getProperty(A2),scrollincrement:A7.getProperty(j),maxheight:A7.getProperty(AU),minscrollheight:A7.getProperty(Aj),iframe:A7.getProperty(AF),shadow:A7.getProperty(Ag),preventcontextoverlap:A7.getProperty(A4),monitorresize:A7.getProperty(AE),keepopen:A7.getProperty(Ar)},BA;if(!(A8 instanceof YAHOO.widget.MenuBar)){A9[AO]=A7.getProperty(AO);}BB.cfg.applyConfig(A9);if(!this.lazyLoad){BA=this.parent.element;if(this.element.parentNode==BA){this.render();}else{this.render(BA);}}},_onMenuItemDestroy:function(A7,A6,A5){this._removeItemFromGroupByValue(A5.groupIndex,A5);},_onMenuItemConfigChange:function(A7,A6,A5){var A9=A6[0][0],BA=A6[0][1],A8;switch(A9){case y:if(BA===true){this.activeItem=A5;}break;case O:A8=A6[0][1];if(A8){this._configureSubmenu(A5);}break;}},configVisible:function(A7,A6,A8){var A5,A9;if(this.cfg.getProperty(Ac)==AD){r.superclass.configVisible.call(this,A7,A6,A8);}else{A5=A6[0];A9=f.getStyle(this.element,AW);f.setStyle(this.element,J,Au);if(A5){if(A9!=AV){this.beforeShowEvent.fire();f.setStyle(this.element,AW,AV);this.showEvent.fire();}}else{if(A9==AV){this.beforeHideEvent.fire();f.setStyle(this.element,AW,AY);this.hideEvent.fire();}}}},configPosition:function(A7,A6,BA){var A9=this.element,A8=A6[0]==C?C:z,BB=this.cfg,A5;f.setStyle(A9,Ac,A8);if(A8==C){f.setStyle(A9,AW,AV);BB.setProperty(Au,true);}else{f.setStyle(A9,J,AL);}if(A8==z){A5=BB.getProperty(AS);if(!A5||A5===0){BB.setProperty(AS,1);}}},configIframe:function(A6,A5,A7){if(this.cfg.getProperty(Ac)==AD){r.superclass.configIframe.call(this,A6,A5,A7);}},configHideDelay:function(A6,A5,A7){var A8=A5[0];this._useHideDelay=(A8>0);},configContainer:function(A6,A5,A8){var A7=A5[0];if(AM.isString(A7)){this.cfg.setProperty(g,f.get(A7),true);}},_clearSetWidthFlag:function(){this._widthSetForScroll=false;this.cfg.unsubscribeFromConfigEvent(U,this._clearSetWidthFlag);},_subscribeScrollHandlers:function(A6,A5){var A8=this._onScrollTargetMouseOver;var A7=this._onScrollTargetMouseOut;AA.on(A6,Ai,A8,this,true);AA.on(A6,H,A7,this,true);AA.on(A5,Ai,A8,this,true);AA.on(A5,H,A7,this,true);},_unsubscribeScrollHandlers:function(A6,A5){var A8=this._onScrollTargetMouseOver;var A7=this._onScrollTargetMouseOut;AA.removeListener(A6,Ai,A8);AA.removeListener(A6,H,A7);AA.removeListener(A5,Ai,A8);AA.removeListener(A5,H,A7);},_setScrollHeight:function(BF){var BC=BF,BB=false,BG=false,A8,A9,BE,A6,A5,BD,BA,A7;if(this.getItems().length>0){A8=this.element;A9=this.body;BE=this.header;A6=this.footer;A5=this.cfg.getProperty(Aj);if(BC>0&&BC<A5){BC=A5;}f.setStyle(A9,Ao,u);f.removeClass(A9,l);A9.scrollTop=0;BG=((As.gecko&&As.gecko<1.9)||As.ie);if(BC>0&&BG&&!this.cfg.getProperty(U)){BA=A8.offsetWidth;A8.style.width=BA+AQ;A7=(BA-(A8.offsetWidth-BA))+AQ;this.cfg.unsubscribeFromConfigEvent(U,this._clearSetWidthFlag);this.cfg.setProperty(U,A7);this._widthSetForScroll=true;this.cfg.subscribeToConfigEvent(U,this._clearSetWidthFlag);}if(BC>0&&(!BE&&!A6)){this.setHeader(AK);this.setFooter(AK);BE=this.header;A6=this.footer;f.addClass(BE,T);f.addClass(A6,x);A8.insertBefore(BE,A9);A8.appendChild(A6);}BD=BC;if(BE&&A6){BD=(BD-(BE.offsetHeight+A6.offsetHeight));}if((BD>0)&&(A9.offsetHeight>BC)){f.addClass(A9,l);f.setStyle(A9,Ao,(BD+AQ));if(!this._hasScrollEventHandlers){this._subscribeScrollHandlers(BE,A6);this._hasScrollEventHandlers=true;}this._disableScrollHeader();this._enableScrollFooter();BB=true;}else{if(BE&&A6){if(this._widthSetForScroll){this._widthSetForScroll=false;this.cfg.unsubscribeFromConfigEvent(U,this._clearSetWidthFlag);this.cfg.setProperty(U,u);}this._enableScrollHeader();this._enableScrollFooter();if(this._hasScrollEventHandlers){this._unsubscribeScrollHandlers(BE,A6);this._hasScrollEventHandlers=false;}A8.removeChild(BE);A8.removeChild(A6);this.header=null;this.footer=null;BB=true;}}if(BB){this.cfg.refireEvent(AF);this.cfg.refireEvent(Ag);}}},_setMaxHeight:function(A6,A5,A7){this._setScrollHeight(A7);this.renderEvent.unsubscribe(this._setMaxHeight);},configMaxHeight:function(A6,A5,A7){var A8=A5[0];if(this.lazyLoad&&!this.body&&A8>0){this.renderEvent.subscribe(this._setMaxHeight,A8,this);}else{this._setScrollHeight(A8);}},configClassName:function(A7,A6,A8){var A5=A6[0];if(this._sClassName){f.removeClass(this.element,this._sClassName);}f.addClass(this.element,A5);this._sClassName=A5;},_onItemAdded:function(A6,A5){var A7=A5[0];if(A7){A7.cfg.setProperty(Ah,true);}},configDisabled:function(A7,A6,BA){var A9=A6[0],A5=this.getItems(),BB,A8;if(AM.isArray(A5)){BB=A5.length;if(BB>0){A8=BB-1;do{A5[A8].cfg.setProperty(Ah,A9);}while(A8--);}if(A9){this.clearActiveItem(true);f.addClass(this.element,Ah);this.itemAddedEvent.subscribe(this._onItemAdded);}else{f.removeClass(this.element,Ah);this.itemAddedEvent.unsubscribe(this._onItemAdded);
}}},_sizeShadow:function(){var A6=this.element,A5=this._shadow;if(A5&&A6){if(A5.style.width&&A5.style.height){A5.style.width=u;A5.style.height=u;}A5.style.width=(A6.offsetWidth+6)+AQ;A5.style.height=(A6.offsetHeight+1)+AQ;}},_replaceShadow:function(){this.element.appendChild(this._shadow);},_addShadowVisibleClass:function(){f.addClass(this._shadow,AG);},_removeShadowVisibleClass:function(){f.removeClass(this._shadow,AG);},_removeShadow:function(){var A5=(this._shadow&&this._shadow.parentNode);if(A5){A5.removeChild(this._shadow);}this.beforeShowEvent.unsubscribe(this._addShadowVisibleClass);this.beforeHideEvent.unsubscribe(this._removeShadowVisibleClass);this.cfg.unsubscribeFromConfigEvent(U,this._sizeShadow);this.cfg.unsubscribeFromConfigEvent(Ao,this._sizeShadow);this.cfg.unsubscribeFromConfigEvent(AU,this._sizeShadow);this.cfg.unsubscribeFromConfigEvent(AU,this._replaceShadow);this.changeContentEvent.unsubscribe(this._sizeShadow);Aw.textResizeEvent.unsubscribe(this._sizeShadow);},_createShadow:function(){var A6=this._shadow,A5;if(!A6){A5=this.element;if(!Ap){Ap=document.createElement(K);Ap.className=m;}A6=Ap.cloneNode(false);A5.appendChild(A6);this._shadow=A6;this.beforeShowEvent.subscribe(this._addShadowVisibleClass);this.beforeHideEvent.subscribe(this._removeShadowVisibleClass);if(As.ie){AM.later(0,this,function(){this._sizeShadow();this.syncIframe();});this.cfg.subscribeToConfigEvent(U,this._sizeShadow);this.cfg.subscribeToConfigEvent(Ao,this._sizeShadow);this.cfg.subscribeToConfigEvent(AU,this._sizeShadow);this.changeContentEvent.subscribe(this._sizeShadow);Aw.textResizeEvent.subscribe(this._sizeShadow,this,true);this.destroyEvent.subscribe(function(){Aw.textResizeEvent.unsubscribe(this._sizeShadow,this);});}this.cfg.subscribeToConfigEvent(AU,this._replaceShadow);}},_shadowBeforeShow:function(){if(this._shadow){this._replaceShadow();if(As.ie){this._sizeShadow();}}else{this._createShadow();}this.beforeShowEvent.unsubscribe(this._shadowBeforeShow);},configShadow:function(A6,A5,A7){var A8=A5[0];if(A8&&this.cfg.getProperty(Ac)==AD){if(this.cfg.getProperty(Au)){if(this._shadow){this._replaceShadow();if(As.ie){this._sizeShadow();}}else{this._createShadow();}}else{this.beforeShowEvent.subscribe(this._shadowBeforeShow);}}else{if(!A8){this.beforeShowEvent.unsubscribe(this._shadowBeforeShow);this._removeShadow();}}},initEvents:function(){r.superclass.initEvents.call(this);var A6=Ab.length-1,A7,A5;do{A7=Ab[A6];A5=this.createEvent(A7[1]);A5.signature=F.LIST;this[A7[0]]=A5;}while(A6--);},positionOffScreen:function(){var A6=this.iframe,A7=this.element,A5=this.OFF_SCREEN_POSITION;A7.style.top=u;A7.style.left=u;if(A6){A6.style.top=A5;A6.style.left=A5;}},getRoot:function(){var A7=this.parent,A6,A5;if(A7){A6=A7.parent;A5=A6?A6.getRoot():this;}else{A5=this;}return A5;},toString:function(){var A6=Aq,A5=this.id;if(A5){A6+=(A1+A5);}return A6;},setItemGroupTitle:function(BA,A9){var A8,A7,A6,A5;if(AM.isString(BA)&&BA.length>0){A8=AM.isNumber(A9)?A9:0;A7=this._aGroupTitleElements[A8];if(A7){A7.innerHTML=BA;}else{A7=document.createElement(this.GROUP_TITLE_TAG_NAME);A7.innerHTML=BA;this._aGroupTitleElements[A8]=A7;}A6=this._aGroupTitleElements.length-1;do{if(this._aGroupTitleElements[A6]){f.removeClass(this._aGroupTitleElements[A6],AJ);A5=A6;}}while(A6--);if(A5!==null){f.addClass(this._aGroupTitleElements[A5],AJ);}this.changeContentEvent.fire();}},addItem:function(A5,A6){return this._addItemToGroup(A6,A5);},addItems:function(A9,A8){var BB,A5,BA,A6,A7;if(AM.isArray(A9)){BB=A9.length;A5=[];for(A6=0;A6<BB;A6++){BA=A9[A6];if(BA){if(AM.isArray(BA)){A5[A5.length]=this.addItems(BA,A6);}else{A5[A5.length]=this._addItemToGroup(A8,BA);}}}if(A5.length){A7=A5;}}return A7;},insertItem:function(A5,A6,A7){return this._addItemToGroup(A7,A5,A6);},removeItem:function(A5,A7){var A8,A6;if(!AM.isUndefined(A5)){if(A5 instanceof YAHOO.widget.MenuItem){A8=this._removeItemFromGroupByValue(A7,A5);}else{if(AM.isNumber(A5)){A8=this._removeItemFromGroupByIndex(A7,A5);}}if(A8){A8.destroy();A6=A8;}}return A6;},getItems:function(){var A8=this._aItemGroups,A6,A7,A5=[];if(AM.isArray(A8)){A6=A8.length;A7=((A6==1)?A8[0]:(Array.prototype.concat.apply(A5,A8)));}return A7;},getItemGroups:function(){return this._aItemGroups;},getItem:function(A6,A7){var A8,A5;if(AM.isNumber(A6)){A8=this._getItemGroup(A7);if(A8){A5=A8[A6];}}return A5;},getSubmenus:function(){var A6=this.getItems(),BA=A6.length,A5,A7,A9,A8;if(BA>0){A5=[];for(A8=0;A8<BA;A8++){A9=A6[A8];if(A9){A7=A9.cfg.getProperty(O);if(A7){A5[A5.length]=A7;}}}}return A5;},clearContent:function(){var A9=this.getItems(),A6=A9.length,A7=this.element,A8=this.body,BD=this.header,A5=this.footer,BC,BB,BA;if(A6>0){BA=A6-1;do{BC=A9[BA];if(BC){BB=BC.cfg.getProperty(O);if(BB){this.cfg.configChangedEvent.unsubscribe(this._onParentMenuConfigChange,BB);this.renderEvent.unsubscribe(this._onParentMenuRender,BB);}this.removeItem(BC,BC.groupIndex);}}while(BA--);}if(BD){AA.purgeElement(BD);A7.removeChild(BD);}if(A5){AA.purgeElement(A5);A7.removeChild(A5);}if(A8){AA.purgeElement(A8);A8.innerHTML=u;}this.activeItem=null;this._aItemGroups=[];this._aListElements=[];this._aGroupTitleElements=[];this.cfg.setProperty(U,null);},destroy:function(A5){this.clearContent();this._aItemGroups=null;this._aListElements=null;this._aGroupTitleElements=null;r.superclass.destroy.call(this,A5);},setInitialFocus:function(){var A5=this._getFirstEnabledItem();if(A5){A5.focus();}},setInitialSelection:function(){var A5=this._getFirstEnabledItem();if(A5){A5.cfg.setProperty(y,true);}},clearActiveItem:function(A7){if(this.cfg.getProperty(Av)>0){this._cancelShowDelay();}var A5=this.activeItem,A8,A6;if(A5){A8=A5.cfg;if(A7){A5.blur();this.getRoot()._hasFocus=true;}A8.setProperty(y,false);A6=A8.getProperty(O);if(A6){A6.hide();}this.activeItem=null;}},focus:function(){if(!this.hasFocus()){this.setInitialFocus();}},blur:function(){var A5;if(this.hasFocus()){A5=A3.getFocusedMenuItem();if(A5){A5.blur();}}},hasFocus:function(){return(A3.getFocusedMenu()==this.getRoot());
},_doItemSubmenuSubscribe:function(A6,A5,A8){var A9=A5[0],A7=A9.cfg.getProperty(O);if(A7){A7.subscribe.apply(A7,A8);}},_doSubmenuSubscribe:function(A6,A5,A8){var A7=this.cfg.getProperty(O);if(A7){A7.subscribe.apply(A7,A8);}},subscribe:function(){r.superclass.subscribe.apply(this,arguments);r.superclass.subscribe.call(this,AR,this._doItemSubmenuSubscribe,arguments);var A5=this.getItems(),A9,A8,A6,A7;if(A5){A9=A5.length;if(A9>0){A7=A9-1;do{A8=A5[A7];A6=A8.cfg.getProperty(O);if(A6){A6.subscribe.apply(A6,arguments);}else{A8.cfg.subscribeToConfigEvent(O,this._doSubmenuSubscribe,arguments);}}while(A7--);}}},unsubscribe:function(){r.superclass.unsubscribe.apply(this,arguments);r.superclass.unsubscribe.call(this,AR,this._doItemSubmenuSubscribe,arguments);var A5=this.getItems(),A9,A8,A6,A7;if(A5){A9=A5.length;if(A9>0){A7=A9-1;do{A8=A5[A7];A6=A8.cfg.getProperty(O);if(A6){A6.unsubscribe.apply(A6,arguments);}else{A8.cfg.unsubscribeFromConfigEvent(O,this._doSubmenuSubscribe,arguments);}}while(A7--);}}},initDefaultConfig:function(){r.superclass.initDefaultConfig.call(this);var A5=this.cfg;A5.addProperty(AZ.key,{handler:this.configVisible,value:AZ.value,validator:AZ.validator});A5.addProperty(AP.key,{handler:this.configConstrainToViewport,value:AP.value,validator:AP.validator,supercedes:AP.supercedes});A5.addProperty(AI.key,{value:AI.value,validator:AI.validator,supercedes:AI.supercedes});A5.addProperty(S.key,{handler:this.configPosition,value:S.value,validator:S.validator,supercedes:S.supercedes});A5.addProperty(A.key,{value:A.value,suppressEvent:A.suppressEvent});A5.addProperty(t.key,{value:t.value,validator:t.validator,suppressEvent:t.suppressEvent});A5.addProperty(Y.key,{value:Y.value,validator:Y.validator,suppressEvent:Y.suppressEvent});A5.addProperty(q.key,{handler:this.configHideDelay,value:q.value,validator:q.validator,suppressEvent:q.suppressEvent});A5.addProperty(v.key,{value:v.value,validator:v.validator,suppressEvent:v.suppressEvent});A5.addProperty(o.key,{value:o.value,validator:o.validator,suppressEvent:o.suppressEvent});A5.addProperty(AN.key,{handler:this.configContainer,value:document.body,suppressEvent:AN.suppressEvent});A5.addProperty(Af.key,{value:Af.value,validator:Af.validator,supercedes:Af.supercedes,suppressEvent:Af.suppressEvent});A5.addProperty(N.key,{value:N.value,validator:N.validator,supercedes:N.supercedes,suppressEvent:N.suppressEvent});A5.addProperty(X.key,{handler:this.configMaxHeight,value:X.value,validator:X.validator,suppressEvent:X.suppressEvent,supercedes:X.supercedes});A5.addProperty(W.key,{handler:this.configClassName,value:W.value,validator:W.validator,supercedes:W.supercedes});A5.addProperty(a.key,{handler:this.configDisabled,value:a.value,validator:a.validator,suppressEvent:a.suppressEvent});A5.addProperty(I.key,{handler:this.configShadow,value:I.value,validator:I.validator});A5.addProperty(Al.key,{value:Al.value,validator:Al.validator});}});})();(function(){YAHOO.widget.MenuItem=function(AS,AR){if(AS){if(AR){this.parent=AR.parent;this.value=AR.value;this.id=AR.id;}this.init(AS,AR);}};var x=YAHOO.util.Dom,j=YAHOO.widget.Module,AB=YAHOO.widget.Menu,c=YAHOO.widget.MenuItem,AK=YAHOO.util.CustomEvent,k=YAHOO.env.ua,AQ=YAHOO.lang,AL="text",O="#",Q="-",L="helptext",n="url",AH="target",A="emphasis",N="strongemphasis",b="checked",w="submenu",H="disabled",B="selected",P="hassubmenu",U="checked-disabled",AI="hassubmenu-disabled",AD="hassubmenu-selected",T="checked-selected",q="onclick",J="classname",AJ="",i="OPTION",v="OPTGROUP",K="LI",AE="href",r="SELECT",X="DIV",AN='<em class="helptext">',a="<em>",I="</em>",W="<strong>",y="</strong>",Y="preventcontextoverlap",h="obj",AG="scope",t="none",V="visible",E=" ",m="MenuItem",AA="click",D="show",M="hide",S="li",AF='<a href="#"></a>',p=[["mouseOverEvent","mouseover"],["mouseOutEvent","mouseout"],["mouseDownEvent","mousedown"],["mouseUpEvent","mouseup"],["clickEvent",AA],["keyPressEvent","keypress"],["keyDownEvent","keydown"],["keyUpEvent","keyup"],["focusEvent","focus"],["blurEvent","blur"],["destroyEvent","destroy"]],o={key:AL,value:AJ,validator:AQ.isString,suppressEvent:true},s={key:L,supercedes:[AL],suppressEvent:true},G={key:n,value:O,suppressEvent:true},AO={key:AH,suppressEvent:true},AP={key:A,value:false,validator:AQ.isBoolean,suppressEvent:true,supercedes:[AL]},d={key:N,value:false,validator:AQ.isBoolean,suppressEvent:true,supercedes:[AL]},l={key:b,value:false,validator:AQ.isBoolean,suppressEvent:true,supercedes:[H,B]},F={key:w,suppressEvent:true,supercedes:[H,B]},AM={key:H,value:false,validator:AQ.isBoolean,suppressEvent:true,supercedes:[AL,B]},f={key:B,value:false,validator:AQ.isBoolean,suppressEvent:true},u={key:q,suppressEvent:true},AC={key:J,value:null,validator:AQ.isString,suppressEvent:true},z={key:"keylistener",value:null,suppressEvent:true},C=null,e={};var Z=function(AU,AT){var AR=e[AU];if(!AR){e[AU]={};AR=e[AU];}var AS=AR[AT];if(!AS){AS=AU+Q+AT;AR[AT]=AS;}return AS;};var g=function(AR){x.addClass(this.element,Z(this.CSS_CLASS_NAME,AR));x.addClass(this._oAnchor,Z(this.CSS_LABEL_CLASS_NAME,AR));};var R=function(AR){x.removeClass(this.element,Z(this.CSS_CLASS_NAME,AR));x.removeClass(this._oAnchor,Z(this.CSS_LABEL_CLASS_NAME,AR));};c.prototype={CSS_CLASS_NAME:"yuimenuitem",CSS_LABEL_CLASS_NAME:"yuimenuitemlabel",SUBMENU_TYPE:null,_oAnchor:null,_oHelpTextEM:null,_oSubmenu:null,_oOnclickAttributeValue:null,_sClassName:null,constructor:c,index:null,groupIndex:null,parent:null,element:null,srcElement:null,value:null,browser:j.prototype.browser,id:null,init:function(AR,Ab){if(!this.SUBMENU_TYPE){this.SUBMENU_TYPE=AB;}this.cfg=new YAHOO.util.Config(this);this.initDefaultConfig();var AX=this.cfg,AY=O,AT,Aa,AZ,AS,AV,AU,AW;if(AQ.isString(AR)){this._createRootNodeStructure();AX.queueProperty(AL,AR);}else{if(AR&&AR.tagName){switch(AR.tagName.toUpperCase()){case i:this._createRootNodeStructure();AX.queueProperty(AL,AR.text);AX.queueProperty(H,AR.disabled);this.value=AR.value;this.srcElement=AR;break;case v:this._createRootNodeStructure();
AX.queueProperty(AL,AR.label);AX.queueProperty(H,AR.disabled);this.srcElement=AR;this._initSubTree();break;case K:AZ=x.getFirstChild(AR);if(AZ){AY=AZ.getAttribute(AE,2);AS=AZ.getAttribute(AH);AV=AZ.innerHTML;}this.srcElement=AR;this.element=AR;this._oAnchor=AZ;AX.setProperty(AL,AV,true);AX.setProperty(n,AY,true);AX.setProperty(AH,AS,true);this._initSubTree();break;}}}if(this.element){AU=(this.srcElement||this.element).id;if(!AU){AU=this.id||x.generateId();this.element.id=AU;}this.id=AU;x.addClass(this.element,this.CSS_CLASS_NAME);x.addClass(this._oAnchor,this.CSS_LABEL_CLASS_NAME);AW=p.length-1;do{Aa=p[AW];AT=this.createEvent(Aa[1]);AT.signature=AK.LIST;this[Aa[0]]=AT;}while(AW--);if(Ab){AX.applyConfig(Ab);}AX.fireQueue();}},_createRootNodeStructure:function(){var AR,AS;if(!C){C=document.createElement(S);C.innerHTML=AF;}AR=C.cloneNode(true);AR.className=this.CSS_CLASS_NAME;AS=AR.firstChild;AS.className=this.CSS_LABEL_CLASS_NAME;this.element=AR;this._oAnchor=AS;},_initSubTree:function(){var AX=this.srcElement,AT=this.cfg,AV,AU,AS,AR,AW;if(AX.childNodes.length>0){if(this.parent.lazyLoad&&this.parent.srcElement&&this.parent.srcElement.tagName.toUpperCase()==r){AT.setProperty(w,{id:x.generateId(),itemdata:AX.childNodes});}else{AV=AX.firstChild;AU=[];do{if(AV&&AV.tagName){switch(AV.tagName.toUpperCase()){case X:AT.setProperty(w,AV);break;case i:AU[AU.length]=AV;break;}}}while((AV=AV.nextSibling));AS=AU.length;if(AS>0){AR=new this.SUBMENU_TYPE(x.generateId());AT.setProperty(w,AR);for(AW=0;AW<AS;AW++){AR.addItem((new AR.ITEM_TYPE(AU[AW])));}}}}},configText:function(Aa,AT,AV){var AS=AT[0],AU=this.cfg,AY=this._oAnchor,AR=AU.getProperty(L),AZ=AJ,AW=AJ,AX=AJ;if(AS){if(AR){AZ=AN+AR+I;}if(AU.getProperty(A)){AW=a;AX=I;}if(AU.getProperty(N)){AW=W;AX=y;}AY.innerHTML=(AW+AS+AX+AZ);}},configHelpText:function(AT,AS,AR){this.cfg.refireEvent(AL);},configURL:function(AT,AS,AR){var AV=AS[0];if(!AV){AV=O;}var AU=this._oAnchor;if(k.opera){AU.removeAttribute(AE);}AU.setAttribute(AE,AV);},configTarget:function(AU,AT,AS){var AR=AT[0],AV=this._oAnchor;if(AR&&AR.length>0){AV.setAttribute(AH,AR);}else{AV.removeAttribute(AH);}},configEmphasis:function(AT,AS,AR){var AV=AS[0],AU=this.cfg;if(AV&&AU.getProperty(N)){AU.setProperty(N,false);}AU.refireEvent(AL);},configStrongEmphasis:function(AU,AT,AS){var AR=AT[0],AV=this.cfg;if(AR&&AV.getProperty(A)){AV.setProperty(A,false);}AV.refireEvent(AL);},configChecked:function(AT,AS,AR){var AV=AS[0],AU=this.cfg;if(AV){g.call(this,b);}else{R.call(this,b);}AU.refireEvent(AL);if(AU.getProperty(H)){AU.refireEvent(H);}if(AU.getProperty(B)){AU.refireEvent(B);}},configDisabled:function(AT,AS,AR){var AV=AS[0],AW=this.cfg,AU=AW.getProperty(w),AX=AW.getProperty(b);if(AV){if(AW.getProperty(B)){AW.setProperty(B,false);}g.call(this,H);if(AU){g.call(this,AI);}if(AX){g.call(this,U);}}else{R.call(this,H);if(AU){R.call(this,AI);}if(AX){R.call(this,U);}}},configSelected:function(AT,AS,AR){var AX=this.cfg,AW=this._oAnchor,AV=AS[0],AY=AX.getProperty(b),AU=AX.getProperty(w);if(k.opera){AW.blur();}if(AV&&!AX.getProperty(H)){g.call(this,B);if(AU){g.call(this,AD);}if(AY){g.call(this,T);}}else{R.call(this,B);if(AU){R.call(this,AD);}if(AY){R.call(this,T);}}if(this.hasFocus()&&k.opera){AW.focus();}},_onSubmenuBeforeHide:function(AU,AT){var AV=this.parent,AR;function AS(){AV._oAnchor.blur();AR.beforeHideEvent.unsubscribe(AS);}if(AV.hasFocus()){AR=AV.parent;AR.beforeHideEvent.subscribe(AS);}},configSubmenu:function(AY,AT,AW){var AV=AT[0],AU=this.cfg,AS=this.parent&&this.parent.lazyLoad,AX,AZ,AR;if(AV){if(AV instanceof AB){AX=AV;AX.parent=this;AX.lazyLoad=AS;}else{if(AQ.isObject(AV)&&AV.id&&!AV.nodeType){AZ=AV.id;AR=AV;AR.lazyload=AS;AR.parent=this;AX=new this.SUBMENU_TYPE(AZ,AR);AU.setProperty(w,AX,true);}else{AX=new this.SUBMENU_TYPE(AV,{lazyload:AS,parent:this});AU.setProperty(w,AX,true);}}if(AX){AX.cfg.setProperty(Y,true);g.call(this,P);if(AU.getProperty(n)===O){AU.setProperty(n,(O+AX.id));}this._oSubmenu=AX;if(k.opera){AX.beforeHideEvent.subscribe(this._onSubmenuBeforeHide);}}}else{R.call(this,P);if(this._oSubmenu){this._oSubmenu.destroy();}}if(AU.getProperty(H)){AU.refireEvent(H);}if(AU.getProperty(B)){AU.refireEvent(B);}},configOnClick:function(AT,AS,AR){var AU=AS[0];if(this._oOnclickAttributeValue&&(this._oOnclickAttributeValue!=AU)){this.clickEvent.unsubscribe(this._oOnclickAttributeValue.fn,this._oOnclickAttributeValue.obj);this._oOnclickAttributeValue=null;}if(!this._oOnclickAttributeValue&&AQ.isObject(AU)&&AQ.isFunction(AU.fn)){this.clickEvent.subscribe(AU.fn,((h in AU)?AU.obj:this),((AG in AU)?AU.scope:null));this._oOnclickAttributeValue=AU;}},configClassName:function(AU,AT,AS){var AR=AT[0];if(this._sClassName){x.removeClass(this.element,this._sClassName);}x.addClass(this.element,AR);this._sClassName=AR;},_dispatchClickEvent:function(){var AS=this,AR;if(!AS.cfg.getProperty(H)){AR=x.getFirstChild(AS.element);this._dispatchDOMClick(AR);}},_dispatchDOMClick:function(AS){var AR;if(k.ie&&k.ie<9){AS.fireEvent(q);}else{if((k.gecko&&k.gecko>=1.9)||k.opera||k.webkit){AR=document.createEvent("HTMLEvents");AR.initEvent(AA,true,true);}else{AR=document.createEvent("MouseEvents");AR.initMouseEvent(AA,true,true,window,0,0,0,0,0,false,false,false,false,0,null);}AS.dispatchEvent(AR);}},_createKeyListener:function(AU,AT,AW){var AV=this,AS=AV.parent;var AR=new YAHOO.util.KeyListener(AS.element.ownerDocument,AW,{fn:AV._dispatchClickEvent,scope:AV,correctScope:true});if(AS.cfg.getProperty(V)){AR.enable();}AS.subscribe(D,AR.enable,null,AR);AS.subscribe(M,AR.disable,null,AR);AV._keyListener=AR;AS.unsubscribe(D,AV._createKeyListener,AW);},configKeyListener:function(AT,AS){var AV=AS[0],AU=this,AR=AU.parent;if(AU._keyData){AR.unsubscribe(D,AU._createKeyListener,AU._keyData);AU._keyData=null;}if(AU._keyListener){AR.unsubscribe(D,AU._keyListener.enable);AR.unsubscribe(M,AU._keyListener.disable);AU._keyListener.disable();AU._keyListener=null;}if(AV){AU._keyData=AV;AR.subscribe(D,AU._createKeyListener,AV,AU);}},initDefaultConfig:function(){var AR=this.cfg;
AR.addProperty(o.key,{handler:this.configText,value:o.value,validator:o.validator,suppressEvent:o.suppressEvent});AR.addProperty(s.key,{handler:this.configHelpText,supercedes:s.supercedes,suppressEvent:s.suppressEvent});AR.addProperty(G.key,{handler:this.configURL,value:G.value,suppressEvent:G.suppressEvent});AR.addProperty(AO.key,{handler:this.configTarget,suppressEvent:AO.suppressEvent});AR.addProperty(AP.key,{handler:this.configEmphasis,value:AP.value,validator:AP.validator,suppressEvent:AP.suppressEvent,supercedes:AP.supercedes});AR.addProperty(d.key,{handler:this.configStrongEmphasis,value:d.value,validator:d.validator,suppressEvent:d.suppressEvent,supercedes:d.supercedes});AR.addProperty(l.key,{handler:this.configChecked,value:l.value,validator:l.validator,suppressEvent:l.suppressEvent,supercedes:l.supercedes});AR.addProperty(AM.key,{handler:this.configDisabled,value:AM.value,validator:AM.validator,suppressEvent:AM.suppressEvent});AR.addProperty(f.key,{handler:this.configSelected,value:f.value,validator:f.validator,suppressEvent:f.suppressEvent});AR.addProperty(F.key,{handler:this.configSubmenu,supercedes:F.supercedes,suppressEvent:F.suppressEvent});AR.addProperty(u.key,{handler:this.configOnClick,suppressEvent:u.suppressEvent});AR.addProperty(AC.key,{handler:this.configClassName,value:AC.value,validator:AC.validator,suppressEvent:AC.suppressEvent});AR.addProperty(z.key,{handler:this.configKeyListener,value:z.value,suppressEvent:z.suppressEvent});},getNextSibling:function(){var AR=function(AX){return(AX.nodeName.toLowerCase()==="ul");},AV=this.element,AU=x.getNextSibling(AV),AT,AS,AW;if(!AU){AT=AV.parentNode;AS=x.getNextSiblingBy(AT,AR);if(AS){AW=AS;}else{AW=x.getFirstChildBy(AT.parentNode,AR);}AU=x.getFirstChild(AW);}return YAHOO.widget.MenuManager.getMenuItem(AU.id);},getNextEnabledSibling:function(){var AR=this.getNextSibling();return(AR.cfg.getProperty(H)||AR.element.style.display==t)?AR.getNextEnabledSibling():AR;},getPreviousSibling:function(){var AR=function(AX){return(AX.nodeName.toLowerCase()==="ul");},AV=this.element,AU=x.getPreviousSibling(AV),AT,AS,AW;if(!AU){AT=AV.parentNode;AS=x.getPreviousSiblingBy(AT,AR);if(AS){AW=AS;}else{AW=x.getLastChildBy(AT.parentNode,AR);}AU=x.getLastChild(AW);}return YAHOO.widget.MenuManager.getMenuItem(AU.id);},getPreviousEnabledSibling:function(){var AR=this.getPreviousSibling();return(AR.cfg.getProperty(H)||AR.element.style.display==t)?AR.getPreviousEnabledSibling():AR;},focus:function(){var AU=this.parent,AT=this._oAnchor,AR=AU.activeItem;function AS(){try{if(!(k.ie&&!document.hasFocus())){if(AR){AR.blurEvent.fire();}AT.focus();this.focusEvent.fire();}}catch(AV){}}if(!this.cfg.getProperty(H)&&AU&&AU.cfg.getProperty(V)&&this.element.style.display!=t){AQ.later(0,this,AS);}},blur:function(){var AR=this.parent;if(!this.cfg.getProperty(H)&&AR&&AR.cfg.getProperty(V)){AQ.later(0,this,function(){try{this._oAnchor.blur();this.blurEvent.fire();}catch(AS){}},0);}},hasFocus:function(){return(YAHOO.widget.MenuManager.getFocusedMenuItem()==this);},destroy:function(){var AT=this.element,AS,AR,AV,AU;if(AT){AS=this.cfg.getProperty(w);if(AS){AS.destroy();}AR=AT.parentNode;if(AR){AR.removeChild(AT);this.destroyEvent.fire();}AU=p.length-1;do{AV=p[AU];this[AV[0]].unsubscribeAll();}while(AU--);this.cfg.configChangedEvent.unsubscribeAll();}},toString:function(){var AS=m,AR=this.id;if(AR){AS+=(E+AR);}return AS;}};AQ.augmentProto(c,YAHOO.util.EventProvider);})();(function(){var B="xy",C="mousedown",F="ContextMenu",J=" ";YAHOO.widget.ContextMenu=function(L,K){YAHOO.widget.ContextMenu.superclass.constructor.call(this,L,K);};var I=YAHOO.util.Event,E=YAHOO.env.ua,G=YAHOO.widget.ContextMenu,A={"TRIGGER_CONTEXT_MENU":"triggerContextMenu","CONTEXT_MENU":(E.opera?C:"contextmenu"),"CLICK":"click"},H={key:"trigger",suppressEvent:true};function D(L,K,M){this.cfg.setProperty(B,M);this.beforeShowEvent.unsubscribe(D,M);}YAHOO.lang.extend(G,YAHOO.widget.Menu,{_oTrigger:null,_bCancelled:false,contextEventTarget:null,triggerContextMenuEvent:null,init:function(L,K){G.superclass.init.call(this,L);this.beforeInitEvent.fire(G);if(K){this.cfg.applyConfig(K,true);}this.initEvent.fire(G);},initEvents:function(){G.superclass.initEvents.call(this);this.triggerContextMenuEvent=this.createEvent(A.TRIGGER_CONTEXT_MENU);this.triggerContextMenuEvent.signature=YAHOO.util.CustomEvent.LIST;},cancel:function(){this._bCancelled=true;},_removeEventHandlers:function(){var K=this._oTrigger;if(K){I.removeListener(K,A.CONTEXT_MENU,this._onTriggerContextMenu);if(E.opera){I.removeListener(K,A.CLICK,this._onTriggerClick);}}},_onTriggerClick:function(L,K){if(L.ctrlKey){I.stopEvent(L);}},_onTriggerContextMenu:function(M,K){var L;if(!(M.type==C&&!M.ctrlKey)){this.contextEventTarget=I.getTarget(M);this.triggerContextMenuEvent.fire(M);if(!this._bCancelled){I.stopEvent(M);YAHOO.widget.MenuManager.hideVisible();L=I.getXY(M);if(!YAHOO.util.Dom.inDocument(this.element)){this.beforeShowEvent.subscribe(D,L);}else{this.cfg.setProperty(B,L);}this.show();}this._bCancelled=false;}},toString:function(){var L=F,K=this.id;if(K){L+=(J+K);}return L;},initDefaultConfig:function(){G.superclass.initDefaultConfig.call(this);this.cfg.addProperty(H.key,{handler:this.configTrigger,suppressEvent:H.suppressEvent});},destroy:function(K){this._removeEventHandlers();G.superclass.destroy.call(this,K);},configTrigger:function(L,K,N){var M=K[0];if(M){if(this._oTrigger){this._removeEventHandlers();}this._oTrigger=M;I.on(M,A.CONTEXT_MENU,this._onTriggerContextMenu,this,true);if(E.opera){I.on(M,A.CLICK,this._onTriggerClick,this,true);}}else{this._removeEventHandlers();}}});}());YAHOO.widget.ContextMenuItem=YAHOO.widget.MenuItem;(function(){var D=YAHOO.lang,N="static",M="dynamic,"+N,A="disabled",F="selected",B="autosubmenudisplay",G="submenu",C="visible",Q=" ",H="submenutoggleregion",P="MenuBar";YAHOO.widget.MenuBar=function(T,S){YAHOO.widget.MenuBar.superclass.constructor.call(this,T,S);};function O(T){var S=false;if(D.isString(T)){S=(M.indexOf((T.toLowerCase()))!=-1);
}return S;}var R=YAHOO.util.Event,L=YAHOO.widget.MenuBar,K={key:"position",value:N,validator:O,supercedes:[C]},E={key:"submenualignment",value:["tl","bl"]},J={key:B,value:false,validator:D.isBoolean,suppressEvent:true},I={key:H,value:false,validator:D.isBoolean};D.extend(L,YAHOO.widget.Menu,{init:function(T,S){if(!this.ITEM_TYPE){this.ITEM_TYPE=YAHOO.widget.MenuBarItem;}L.superclass.init.call(this,T);this.beforeInitEvent.fire(L);if(S){this.cfg.applyConfig(S,true);}this.initEvent.fire(L);},CSS_CLASS_NAME:"yuimenubar",SUBMENU_TOGGLE_REGION_WIDTH:20,_onKeyDown:function(U,T,Y){var S=T[0],Z=T[1],W,X,V;if(Z&&!Z.cfg.getProperty(A)){X=Z.cfg;switch(S.keyCode){case 37:case 39:if(Z==this.activeItem&&!X.getProperty(F)){X.setProperty(F,true);}else{V=(S.keyCode==37)?Z.getPreviousEnabledSibling():Z.getNextEnabledSibling();if(V){this.clearActiveItem();V.cfg.setProperty(F,true);W=V.cfg.getProperty(G);if(W){W.show();W.setInitialFocus();}else{V.focus();}}}R.preventDefault(S);break;case 40:if(this.activeItem!=Z){this.clearActiveItem();X.setProperty(F,true);Z.focus();}W=X.getProperty(G);if(W){if(W.cfg.getProperty(C)){W.setInitialSelection();W.setInitialFocus();}else{W.show();W.setInitialFocus();}}R.preventDefault(S);break;}}if(S.keyCode==27&&this.activeItem){W=this.activeItem.cfg.getProperty(G);if(W&&W.cfg.getProperty(C)){W.hide();this.activeItem.focus();}else{this.activeItem.cfg.setProperty(F,false);this.activeItem.blur();}R.preventDefault(S);}},_onClick:function(e,Y,b){L.superclass._onClick.call(this,e,Y,b);var d=Y[1],T=true,S,f,U,W,Z,a,c,V;var X=function(){if(a.cfg.getProperty(C)){a.hide();}else{a.show();}};if(d&&!d.cfg.getProperty(A)){f=Y[0];U=R.getTarget(f);W=this.activeItem;Z=this.cfg;if(W&&W!=d){this.clearActiveItem();}d.cfg.setProperty(F,true);a=d.cfg.getProperty(G);if(a){S=d.element;c=YAHOO.util.Dom.getX(S);V=c+(S.offsetWidth-this.SUBMENU_TOGGLE_REGION_WIDTH);if(Z.getProperty(H)){if(R.getPageX(f)>V){X();R.preventDefault(f);T=false;}}else{X();}}}return T;},configSubmenuToggle:function(U,T){var S=T[0];if(S){this.cfg.setProperty(B,false);}},toString:function(){var T=P,S=this.id;if(S){T+=(Q+S);}return T;},initDefaultConfig:function(){L.superclass.initDefaultConfig.call(this);var S=this.cfg;S.addProperty(K.key,{handler:this.configPosition,value:K.value,validator:K.validator,supercedes:K.supercedes});S.addProperty(E.key,{value:E.value,suppressEvent:E.suppressEvent});S.addProperty(J.key,{value:J.value,validator:J.validator,suppressEvent:J.suppressEvent});S.addProperty(I.key,{value:I.value,validator:I.validator,handler:this.configSubmenuToggle});}});}());YAHOO.widget.MenuBarItem=function(B,A){YAHOO.widget.MenuBarItem.superclass.constructor.call(this,B,A);};YAHOO.lang.extend(YAHOO.widget.MenuBarItem,YAHOO.widget.MenuItem,{init:function(B,A){if(!this.SUBMENU_TYPE){this.SUBMENU_TYPE=YAHOO.widget.Menu;}YAHOO.widget.MenuBarItem.superclass.init.call(this,B);var C=this.cfg;if(A){C.applyConfig(A,true);}C.fireQueue();},CSS_CLASS_NAME:"yuimenubaritem",CSS_LABEL_CLASS_NAME:"yuimenubaritemlabel",toString:function(){var A="MenuBarItem";if(this.cfg&&this.cfg.getProperty("text")){A+=(": "+this.cfg.getProperty("text"));}return A;}});YAHOO.register("menu",YAHOO.widget.Menu,{version:"2.9.0",build:"2800"});// End of File include/javascript/yui/build/menu/menu-min.js
                                
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
SUGAR_callsInProgress=0;YAHOO.util.Connect.completeEvent.subscribe(function(event,data){SUGAR_callsInProgress--;if(SUGAR.util.isLoginPage(data[0].conn.responseText))
return false;});YAHOO.util.Connect.startEvent.subscribe(function(event,data)
{SUGAR_callsInProgress++;});
// End of File include/javascript/sugar_connection_event_listener.js
                                
/*
Copyright (c) 2011, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 2.9.0
*/
(function () {

    /**
    * Config is a utility used within an Object to allow the implementer to
    * maintain a list of local configuration properties and listen for changes 
    * to those properties dynamically using CustomEvent. The initial values are 
    * also maintained so that the configuration can be reset at any given point 
    * to its initial state.
    * @namespace YAHOO.util
    * @class Config
    * @constructor
    * @param {Object} owner The owner Object to which this Config Object belongs
    */
    YAHOO.util.Config = function (owner) {

        if (owner) {
            this.init(owner);
        }


    };


    var Lang = YAHOO.lang,
        CustomEvent = YAHOO.util.CustomEvent,
        Config = YAHOO.util.Config;


    /**
     * Constant representing the CustomEvent type for the config changed event.
     * @property YAHOO.util.Config.CONFIG_CHANGED_EVENT
     * @private
     * @static
     * @final
     */
    Config.CONFIG_CHANGED_EVENT = "configChanged";
    
    /**
     * Constant representing the boolean type string
     * @property YAHOO.util.Config.BOOLEAN_TYPE
     * @private
     * @static
     * @final
     */
    Config.BOOLEAN_TYPE = "boolean";
    
    Config.prototype = {
     
        /**
        * Object reference to the owner of this Config Object
        * @property owner
        * @type Object
        */
        owner: null,
        
        /**
        * Boolean flag that specifies whether a queue is currently 
        * being executed
        * @property queueInProgress
        * @type Boolean
        */
        queueInProgress: false,
        
        /**
        * Maintains the local collection of configuration property objects and 
        * their specified values
        * @property config
        * @private
        * @type Object
        */ 
        config: null,
        
        /**
        * Maintains the local collection of configuration property objects as 
        * they were initially applied.
        * This object is used when resetting a property.
        * @property initialConfig
        * @private
        * @type Object
        */ 
        initialConfig: null,
        
        /**
        * Maintains the local, normalized CustomEvent queue
        * @property eventQueue
        * @private
        * @type Object
        */ 
        eventQueue: null,
        
        /**
        * Custom Event, notifying subscribers when Config properties are set 
        * (setProperty is called without the silent flag
        * @event configChangedEvent
        */
        configChangedEvent: null,
    
        /**
        * Initializes the configuration Object and all of its local members.
        * @method init
        * @param {Object} owner The owner Object to which this Config 
        * Object belongs
        */
        init: function (owner) {
    
            this.owner = owner;
    
            this.configChangedEvent = 
                this.createEvent(Config.CONFIG_CHANGED_EVENT);
    
            this.configChangedEvent.signature = CustomEvent.LIST;
            this.queueInProgress = false;
            this.config = {};
            this.initialConfig = {};
            this.eventQueue = [];
        
        },
        
        /**
        * Validates that the value passed in is a Boolean.
        * @method checkBoolean
        * @param {Object} val The value to validate
        * @return {Boolean} true, if the value is valid
        */ 
        checkBoolean: function (val) {
            return (typeof val == Config.BOOLEAN_TYPE);
        },
        
        /**
        * Validates that the value passed in is a number.
        * @method checkNumber
        * @param {Object} val The value to validate
        * @return {Boolean} true, if the value is valid
        */
        checkNumber: function (val) {
            return (!isNaN(val));
        },
        
        /**
        * Fires a configuration property event using the specified value. 
        * @method fireEvent
        * @private
        * @param {String} key The configuration property's name
        * @param {value} Object The value of the correct type for the property
        */ 
        fireEvent: function ( key, value ) {
            var property = this.config[key];
        
            if (property && property.event) {
                property.event.fire(value);
            } 
        },
        
        /**
        * Adds a property to the Config Object's private config hash.
        * @method addProperty
        * @param {String} key The configuration property's name
        * @param {Object} propertyObject The Object containing all of this 
        * property's arguments
        */
        addProperty: function ( key, propertyObject ) {
            key = key.toLowerCase();
        
            this.config[key] = propertyObject;
        
            propertyObject.event = this.createEvent(key, { scope: this.owner });
            propertyObject.event.signature = CustomEvent.LIST;
            
            
            propertyObject.key = key;
        
            if (propertyObject.handler) {
                propertyObject.event.subscribe(propertyObject.handler, 
                    this.owner);
            }
        
            this.setProperty(key, propertyObject.value, true);
            
            if (! propertyObject.suppressEvent) {
                this.queueProperty(key, propertyObject.value);
            }
            
        },
        
        /**
        * Returns a key-value configuration map of the values currently set in  
        * the Config Object.
        * @method getConfig
        * @return {Object} The current config, represented in a key-value map
        */
        getConfig: function () {
        
            var cfg = {},
                currCfg = this.config,
                prop,
                property;
                
            for (prop in currCfg) {
                if (Lang.hasOwnProperty(currCfg, prop)) {
                    property = currCfg[prop];
                    if (property && property.event) {
                        cfg[prop] = property.value;
                    }
                }
            }

            return cfg;
        },
        
        /**
        * Returns the value of specified property.
        * @method getProperty
        * @param {String} key The name of the property
        * @return {Object}  The value of the specified property
        */
        getProperty: function (key) {
            var property = this.config[key.toLowerCase()];
            if (property && property.event) {
                return property.value;
            } else {
                return undefined;
            }
        },
        
        /**
        * Resets the specified property's value to its initial value.
        * @method resetProperty
        * @param {String} key The name of the property
        * @return {Boolean} True is the property was reset, false if not
        */
        resetProperty: function (key) {
            key = key.toLowerCase();

            var property = this.config[key];

            if (property && property.event) {
                if (key in this.initialConfig) {
                    this.setProperty(key, this.initialConfig[key]);
                    return true;
                }
            } else {
                return false;
            }
        },
        
        /**
        * Sets the value of a property. If the silent property is passed as 
        * true, the property's event will not be fired.
        * @method setProperty
        * @param {String} key The name of the property
        * @param {String} value The value to set the property to
        * @param {Boolean} silent Whether the value should be set silently, 
        * without firing the property event.
        * @return {Boolean} True, if the set was successful, false if it failed.
        */
        setProperty: function (key, value, silent) {
        
            var property;
        
            key = key.toLowerCase();
        
            if (this.queueInProgress && ! silent) {
                // Currently running through a queue... 
                this.queueProperty(key,value);
                return true;
    
            } else {
                property = this.config[key];
                if (property && property.event) {
                    if (property.validator && !property.validator(value)) {
                        return false;
                    } else {
                        property.value = value;
                        if (! silent) {
                            this.fireEvent(key, value);
                            this.configChangedEvent.fire([key, value]);
                        }
                        return true;
                    }
                } else {
                    return false;
                }
            }
        },
        
        /**
        * Sets the value of a property and queues its event to execute. If the 
        * event is already scheduled to execute, it is
        * moved from its current position to the end of the queue.
        * @method queueProperty
        * @param {String} key The name of the property
        * @param {String} value The value to set the property to
        * @return {Boolean}  true, if the set was successful, false if 
        * it failed.
        */ 
        queueProperty: function (key, value) {
        
            key = key.toLowerCase();
        
            var property = this.config[key],
                foundDuplicate = false,
                iLen,
                queueItem,
                queueItemKey,
                queueItemValue,
                sLen,
                supercedesCheck,
                qLen,
                queueItemCheck,
                queueItemCheckKey,
                queueItemCheckValue,
                i,
                s,
                q;
                                
            if (property && property.event) {
    
                if (!Lang.isUndefined(value) && property.validator && 
                    !property.validator(value)) { // validator
                    return false;
                } else {
        
                    if (!Lang.isUndefined(value)) {
                        property.value = value;
                    } else {
                        value = property.value;
                    }
        
                    foundDuplicate = false;
                    iLen = this.eventQueue.length;
        
                    for (i = 0; i < iLen; i++) {
                        queueItem = this.eventQueue[i];
        
                        if (queueItem) {
                            queueItemKey = queueItem[0];
                            queueItemValue = queueItem[1];

                            if (queueItemKey == key) {
    
                                /*
                                    found a dupe... push to end of queue, null 
                                    current item, and break
                                */
    
                                this.eventQueue[i] = null;
    
                                this.eventQueue.push(
                                    [key, (!Lang.isUndefined(value) ? 
                                    value : queueItemValue)]);
    
                                foundDuplicate = true;
                                break;
                            }
                        }
                    }
                    
                    // this is a refire, or a new property in the queue
    
                    if (! foundDuplicate && !Lang.isUndefined(value)) { 
                        this.eventQueue.push([key, value]);
                    }
                }
        
                if (property.supercedes) {

                    sLen = property.supercedes.length;

                    for (s = 0; s < sLen; s++) {

                        supercedesCheck = property.supercedes[s];
                        qLen = this.eventQueue.length;

                        for (q = 0; q < qLen; q++) {
                            queueItemCheck = this.eventQueue[q];

                            if (queueItemCheck) {
                                queueItemCheckKey = queueItemCheck[0];
                                queueItemCheckValue = queueItemCheck[1];

                                if (queueItemCheckKey == 
                                    supercedesCheck.toLowerCase() ) {

                                    this.eventQueue.push([queueItemCheckKey, 
                                        queueItemCheckValue]);

                                    this.eventQueue[q] = null;
                                    break;

                                }
                            }
                        }
                    }
                }


                return true;
            } else {
                return false;
            }
        },
        
        /**
        * Fires the event for a property using the property's current value.
        * @method refireEvent
        * @param {String} key The name of the property
        */
        refireEvent: function (key) {
    
            key = key.toLowerCase();
        
            var property = this.config[key];
    
            if (property && property.event && 
    
                !Lang.isUndefined(property.value)) {
    
                if (this.queueInProgress) {
    
                    this.queueProperty(key);
    
                } else {
    
                    this.fireEvent(key, property.value);
    
                }
    
            }
        },
        
        /**
        * Applies a key-value Object literal to the configuration, replacing  
        * any existing values, and queueing the property events.
        * Although the values will be set, fireQueue() must be called for their 
        * associated events to execute.
        * @method applyConfig
        * @param {Object} userConfig The configuration Object literal
        * @param {Boolean} init  When set to true, the initialConfig will 
        * be set to the userConfig passed in, so that calling a reset will 
        * reset the properties to the passed values.
        */
        applyConfig: function (userConfig, init) {
        
            var sKey,
                oConfig;

            if (init) {
                oConfig = {};
                for (sKey in userConfig) {
                    if (Lang.hasOwnProperty(userConfig, sKey)) {
                        oConfig[sKey.toLowerCase()] = userConfig[sKey];
                    }
                }
                this.initialConfig = oConfig;
            }

            for (sKey in userConfig) {
                if (Lang.hasOwnProperty(userConfig, sKey)) {
                    this.queueProperty(sKey, userConfig[sKey]);
                }
            }
        },
        
        /**
        * Refires the events for all configuration properties using their 
        * current values.
        * @method refresh
        */
        refresh: function () {

            var prop;

            for (prop in this.config) {
                if (Lang.hasOwnProperty(this.config, prop)) {
                    this.refireEvent(prop);
                }
            }
        },
        
        /**
        * Fires the normalized list of queued property change events
        * @method fireQueue
        */
        fireQueue: function () {
        
            var i, 
                queueItem,
                key,
                value,
                property;
        
            this.queueInProgress = true;
            for (i = 0;i < this.eventQueue.length; i++) {
                queueItem = this.eventQueue[i];
                if (queueItem) {
        
                    key = queueItem[0];
                    value = queueItem[1];
                    property = this.config[key];

                    property.value = value;

                    // Clear out queue entry, to avoid it being 
                    // re-added to the queue by any queueProperty/supercedes
                    // calls which are invoked during fireEvent
                    this.eventQueue[i] = null;

                    this.fireEvent(key,value);
                }
            }
            
            this.queueInProgress = false;
            this.eventQueue = [];
        },
        
        /**
        * Subscribes an external handler to the change event for any 
        * given property. 
        * @method subscribeToConfigEvent
        * @param {String} key The property name
        * @param {Function} handler The handler function to use subscribe to 
        * the property's event
        * @param {Object} obj The Object to use for scoping the event handler 
        * (see CustomEvent documentation)
        * @param {Boolean} overrideContext Optional. If true, will override
        * "this" within the handler to map to the scope Object passed into the
        * method.
        * @return {Boolean} True, if the subscription was successful, 
        * otherwise false.
        */ 
        subscribeToConfigEvent: function (key, handler, obj, overrideContext) {
    
            var property = this.config[key.toLowerCase()];
    
            if (property && property.event) {
                if (!Config.alreadySubscribed(property.event, handler, obj)) {
                    property.event.subscribe(handler, obj, overrideContext);
                }
                return true;
            } else {
                return false;
            }
    
        },
        
        /**
        * Unsubscribes an external handler from the change event for any 
        * given property. 
        * @method unsubscribeFromConfigEvent
        * @param {String} key The property name
        * @param {Function} handler The handler function to use subscribe to 
        * the property's event
        * @param {Object} obj The Object to use for scoping the event 
        * handler (see CustomEvent documentation)
        * @return {Boolean} True, if the unsubscription was successful, 
        * otherwise false.
        */
        unsubscribeFromConfigEvent: function (key, handler, obj) {
            var property = this.config[key.toLowerCase()];
            if (property && property.event) {
                return property.event.unsubscribe(handler, obj);
            } else {
                return false;
            }
        },
        
        /**
        * Returns a string representation of the Config object
        * @method toString
        * @return {String} The Config object in string format.
        */
        toString: function () {
            var output = "Config";
            if (this.owner) {
                output += " [" + this.owner.toString() + "]";
            }
            return output;
        },
        
        /**
        * Returns a string representation of the Config object's current 
        * CustomEvent queue
        * @method outputEventQueue
        * @return {String} The string list of CustomEvents currently queued 
        * for execution
        */
        outputEventQueue: function () {

            var output = "",
                queueItem,
                q,
                nQueue = this.eventQueue.length;
              
            for (q = 0; q < nQueue; q++) {
                queueItem = this.eventQueue[q];
                if (queueItem) {
                    output += queueItem[0] + "=" + queueItem[1] + ", ";
                }
            }
            return output;
        },

        /**
        * Sets all properties to null, unsubscribes all listeners from each 
        * property's change event and all listeners from the configChangedEvent.
        * @method destroy
        */
        destroy: function () {

            var oConfig = this.config,
                sProperty,
                oProperty;


            for (sProperty in oConfig) {
            
                if (Lang.hasOwnProperty(oConfig, sProperty)) {

                    oProperty = oConfig[sProperty];

                    oProperty.event.unsubscribeAll();
                    oProperty.event = null;

                }
            
            }
            
            this.configChangedEvent.unsubscribeAll();
            
            this.configChangedEvent = null;
            this.owner = null;
            this.config = null;
            this.initialConfig = null;
            this.eventQueue = null;
        
        }

    };
    
    
    
    /**
    * Checks to determine if a particular function/Object pair are already 
    * subscribed to the specified CustomEvent
    * @method YAHOO.util.Config.alreadySubscribed
    * @static
    * @param {YAHOO.util.CustomEvent} evt The CustomEvent for which to check 
    * the subscriptions
    * @param {Function} fn The function to look for in the subscribers list
    * @param {Object} obj The execution scope Object for the subscription
    * @return {Boolean} true, if the function/Object pair is already subscribed 
    * to the CustomEvent passed in
    */
    Config.alreadySubscribed = function (evt, fn, obj) {
    
        var nSubscribers = evt.subscribers.length,
            subsc,
            i;

        if (nSubscribers > 0) {
            i = nSubscribers - 1;
            do {
                subsc = evt.subscribers[i];
                if (subsc && subsc.obj == obj && subsc.fn == fn) {
                    return true;
                }
            }
            while (i--);
        }

        return false;

    };

    YAHOO.lang.augmentProto(Config, YAHOO.util.EventProvider);

}());
/**
* The datemath module provides utility methods for basic JavaScript Date object manipulation and 
* comparison. 
* 
* @module datemath
*/

/**
* YAHOO.widget.DateMath is used for simple date manipulation. The class is a static utility
* used for adding, subtracting, and comparing dates.
* @namespace YAHOO.widget
* @class DateMath
*/
YAHOO.widget.DateMath = {
    /**
    * Constant field representing Day
    * @property DAY
    * @static
    * @final
    * @type String
    */
    DAY : "D",

    /**
    * Constant field representing Week
    * @property WEEK
    * @static
    * @final
    * @type String
    */
    WEEK : "W",

    /**
    * Constant field representing Year
    * @property YEAR
    * @static
    * @final
    * @type String
    */
    YEAR : "Y",

    /**
    * Constant field representing Month
    * @property MONTH
    * @static
    * @final
    * @type String
    */
    MONTH : "M",

    /**
    * Constant field representing one day, in milliseconds
    * @property ONE_DAY_MS
    * @static
    * @final
    * @type Number
    */
    ONE_DAY_MS : 1000*60*60*24,
    
    /**
     * Constant field representing the date in first week of January
     * which identifies the first week of the year.
     * <p>
     * In the U.S, Jan 1st is normally used based on a Sunday start of week.
     * ISO 8601, used widely throughout Europe, uses Jan 4th, based on a Monday start of week.
     * </p>
     * @property WEEK_ONE_JAN_DATE
     * @static
     * @type Number
     */
    WEEK_ONE_JAN_DATE : 1,

    /**
    * Adds the specified amount of time to the this instance.
    * @method add
    * @param {Date} date The JavaScript Date object to perform addition on
    * @param {String} field The field constant to be used for performing addition.
    * @param {Number} amount The number of units (measured in the field constant) to add to the date.
    * @return {Date} The resulting Date object
    */
    add : function(date, field, amount) {
        var d = new Date(date.getTime());
        switch (field) {
            case this.MONTH:
                var newMonth = date.getMonth() + amount;
                var years = 0;

                if (newMonth < 0) {
                    while (newMonth < 0) {
                        newMonth += 12;
                        years -= 1;
                    }
                } else if (newMonth > 11) {
                    while (newMonth > 11) {
                        newMonth -= 12;
                        years += 1;
                    }
                }

                d.setMonth(newMonth);
                d.setFullYear(date.getFullYear() + years);
                break;
            case this.DAY:
                this._addDays(d, amount);
                // d.setDate(date.getDate() + amount);
                break;
            case this.YEAR:
                d.setFullYear(date.getFullYear() + amount);
                break;
            case this.WEEK:
                this._addDays(d, (amount * 7));
                // d.setDate(date.getDate() + (amount * 7));
                break;
        }
        return d;
    },

    /**
     * Private helper method to account for bug in Safari 2 (webkit < 420)
     * when Date.setDate(n) is called with n less than -128 or greater than 127.
     * <p>
     * Fix approach and original findings are available here:
     * http://brianary.blogspot.com/2006/03/safari-date-bug.html
     * </p>
     * @method _addDays
     * @param {Date} d JavaScript date object
     * @param {Number} nDays The number of days to add to the date object (can be negative)
     * @private
     */
    _addDays : function(d, nDays) {
        if (YAHOO.env.ua.webkit && YAHOO.env.ua.webkit < 420) {
            if (nDays < 0) {
                // Ensure we don't go below -128 (getDate() is always 1 to 31, so we won't go above 127)
                for(var min = -128; nDays < min; nDays -= min) {
                    d.setDate(d.getDate() + min);
                }
            } else {
                // Ensure we don't go above 96 + 31 = 127
                for(var max = 96; nDays > max; nDays -= max) {
                    d.setDate(d.getDate() + max);
                }
            }
            // nDays should be remainder between -128 and 96
        }
        d.setDate(d.getDate() + nDays);
    },

    /**
    * Subtracts the specified amount of time from the this instance.
    * @method subtract
    * @param {Date} date The JavaScript Date object to perform subtraction on
    * @param {Number} field The this field constant to be used for performing subtraction.
    * @param {Number} amount The number of units (measured in the field constant) to subtract from the date.
    * @return {Date} The resulting Date object
    */
    subtract : function(date, field, amount) {
        return this.add(date, field, (amount*-1));
    },

    /**
    * Determines whether a given date is before another date on the calendar.
    * @method before
    * @param {Date} date  The Date object to compare with the compare argument
    * @param {Date} compareTo The Date object to use for the comparison
    * @return {Boolean} true if the date occurs before the compared date; false if not.
    */
    before : function(date, compareTo) {
        var ms = compareTo.getTime();
        if (date.getTime() < ms) {
            return true;
        } else {
            return false;
        }
    },

    /**
    * Determines whether a given date is after another date on the calendar.
    * @method after
    * @param {Date} date  The Date object to compare with the compare argument
    * @param {Date} compareTo The Date object to use for the comparison
    * @return {Boolean} true if the date occurs after the compared date; false if not.
    */
    after : function(date, compareTo) {
        var ms = compareTo.getTime();
        if (date.getTime() > ms) {
            return true;
        } else {
            return false;
        }
    },

    /**
    * Determines whether a given date is between two other dates on the calendar.
    * @method between
    * @param {Date} date  The date to check for
    * @param {Date} dateBegin The start of the range
    * @param {Date} dateEnd  The end of the range
    * @return {Boolean} true if the date occurs between the compared dates; false if not.
    */
    between : function(date, dateBegin, dateEnd) {
        if (this.after(date, dateBegin) && this.before(date, dateEnd)) {
            return true;
        } else {
            return false;
        }
    },
    
    /**
    * Retrieves a JavaScript Date object representing January 1 of any given year.
    * @method getJan1
    * @param {Number} calendarYear  The calendar year for which to retrieve January 1
    * @return {Date} January 1 of the calendar year specified.
    */
    getJan1 : function(calendarYear) {
        return this.getDate(calendarYear,0,1);
    },

    /**
    * Calculates the number of days the specified date is from January 1 of the specified calendar year.
    * Passing January 1 to this function would return an offset value of zero.
    * @method getDayOffset
    * @param {Date} date The JavaScript date for which to find the offset
    * @param {Number} calendarYear The calendar year to use for determining the offset
    * @return {Number} The number of days since January 1 of the given year
    */
    getDayOffset : function(date, calendarYear) {
        var beginYear = this.getJan1(calendarYear); // Find the start of the year. This will be in week 1.
        
        // Find the number of days the passed in date is away from the calendar year start
        var dayOffset = Math.ceil((date.getTime()-beginYear.getTime()) / this.ONE_DAY_MS);
        return dayOffset;
    },

    /**
    * Calculates the week number for the given date. Can currently support standard
    * U.S. week numbers, based on Jan 1st defining the 1st week of the year, and 
    * ISO8601 week numbers, based on Jan 4th defining the 1st week of the year.
    * 
    * @method getWeekNumber
    * @param {Date} date The JavaScript date for which to find the week number
    * @param {Number} firstDayOfWeek The index of the first day of the week (0 = Sun, 1 = Mon ... 6 = Sat).
    * Defaults to 0
    * @param {Number} janDate The date in the first week of January which defines week one for the year
    * Defaults to the value of YAHOO.widget.DateMath.WEEK_ONE_JAN_DATE, which is 1 (Jan 1st). 
    * For the U.S, this is normally Jan 1st. ISO8601 uses Jan 4th to define the first week of the year.
    * 
    * @return {Number} The number of the week containing the given date.
    */
    getWeekNumber : function(date, firstDayOfWeek, janDate) {

        // Setup Defaults
        firstDayOfWeek = firstDayOfWeek || 0;
        janDate = janDate || this.WEEK_ONE_JAN_DATE;

        var targetDate = this.clearTime(date),
            startOfWeek,
            endOfWeek;

        if (targetDate.getDay() === firstDayOfWeek) { 
            startOfWeek = targetDate;
        } else {
            startOfWeek = this.getFirstDayOfWeek(targetDate, firstDayOfWeek);
        }

        var startYear = startOfWeek.getFullYear();

        // DST shouldn't be a problem here, math is quicker than setDate();
        endOfWeek = new Date(startOfWeek.getTime() + 6*this.ONE_DAY_MS);

        var weekNum;
        if (startYear !== endOfWeek.getFullYear() && endOfWeek.getDate() >= janDate) {
            // If years don't match, endOfWeek is in Jan. and if the 
            // week has WEEK_ONE_JAN_DATE in it, it's week one by definition.
            weekNum = 1;
        } else {
            // Get the 1st day of the 1st week, and 
            // find how many days away we are from it.
            var weekOne = this.clearTime(this.getDate(startYear, 0, janDate)),
                weekOneDayOne = this.getFirstDayOfWeek(weekOne, firstDayOfWeek);

            // Round days to smoothen out 1 hr DST diff
            var daysDiff  = Math.round((targetDate.getTime() - weekOneDayOne.getTime())/this.ONE_DAY_MS);

            // Calc. Full Weeks
            var rem = daysDiff % 7;
            var weeksDiff = (daysDiff - rem)/7;
            weekNum = weeksDiff + 1;
        }
        return weekNum;
    },

    /**
     * Get the first day of the week, for the give date. 
     * @param {Date} dt The date in the week for which the first day is required.
     * @param {Number} startOfWeek The index for the first day of the week, 0 = Sun, 1 = Mon ... 6 = Sat (defaults to 0)
     * @return {Date} The first day of the week
     */
    getFirstDayOfWeek : function (dt, startOfWeek) {
        startOfWeek = startOfWeek || 0;
        var dayOfWeekIndex = dt.getDay(),
            dayOfWeek = (dayOfWeekIndex - startOfWeek + 7) % 7;

        return this.subtract(dt, this.DAY, dayOfWeek);
    },

    /**
    * Determines if a given week overlaps two different years.
    * @method isYearOverlapWeek
    * @param {Date} weekBeginDate The JavaScript Date representing the first day of the week.
    * @return {Boolean} true if the date overlaps two different years.
    */
    isYearOverlapWeek : function(weekBeginDate) {
        var overlaps = false;
        var nextWeek = this.add(weekBeginDate, this.DAY, 6);
        if (nextWeek.getFullYear() != weekBeginDate.getFullYear()) {
            overlaps = true;
        }
        return overlaps;
    },

    /**
    * Determines if a given week overlaps two different months.
    * @method isMonthOverlapWeek
    * @param {Date} weekBeginDate The JavaScript Date representing the first day of the week.
    * @return {Boolean} true if the date overlaps two different months.
    */
    isMonthOverlapWeek : function(weekBeginDate) {
        var overlaps = false;
        var nextWeek = this.add(weekBeginDate, this.DAY, 6);
        if (nextWeek.getMonth() != weekBeginDate.getMonth()) {
            overlaps = true;
        }
        return overlaps;
    },

    /**
    * Gets the first day of a month containing a given date.
    * @method findMonthStart
    * @param {Date} date The JavaScript Date used to calculate the month start
    * @return {Date}  The JavaScript Date representing the first day of the month
    */
    findMonthStart : function(date) {
        var start = this.getDate(date.getFullYear(), date.getMonth(), 1);
        return start;
    },

    /**
    * Gets the last day of a month containing a given date.
    * @method findMonthEnd
    * @param {Date} date The JavaScript Date used to calculate the month end
    * @return {Date}  The JavaScript Date representing the last day of the month
    */
    findMonthEnd : function(date) {
        var start = this.findMonthStart(date);
        var nextMonth = this.add(start, this.MONTH, 1);
        var end = this.subtract(nextMonth, this.DAY, 1);
        return end;
    },

    /**
    * Clears the time fields from a given date, effectively setting the time to 12 noon.
    * @method clearTime
    * @param {Date} date The JavaScript Date for which the time fields will be cleared
    * @return {Date}  The JavaScript Date cleared of all time fields
    */
    clearTime : function(date) {
        date.setHours(12,0,0,0);
        return date;
    },

    /**
     * Returns a new JavaScript Date object, representing the given year, month and date. Time fields (hr, min, sec, ms) on the new Date object
     * are set to 0. The method allows Date instances to be created with the a year less than 100. "new Date(year, month, date)" implementations 
     * set the year to 19xx if a year (xx) which is less than 100 is provided.
     * <p>
     * <em>NOTE:</em>Validation on argument values is not performed. It is the caller's responsibility to ensure
     * arguments are valid as per the ECMAScript-262 Date object specification for the new Date(year, month[, date]) constructor.
     * </p>
     * @method getDate
     * @param {Number} y Year.
     * @param {Number} m Month index from 0 (Jan) to 11 (Dec).
     * @param {Number} d (optional) Date from 1 to 31. If not provided, defaults to 1.
     * @return {Date} The JavaScript date object with year, month, date set as provided.
     */
    getDate : function(y, m, d) {
        var dt = null;
        if (YAHOO.lang.isUndefined(d)) {
            d = 1;
        }
        if (y >= 100) {
            dt = new Date(y, m, d);
        } else {
            dt = new Date();
            dt.setFullYear(y);
            dt.setMonth(m);
            dt.setDate(d);
            dt.setHours(0,0,0,0);
        }
        return dt;
    }
};
/**
* The Calendar component is a UI control that enables users to choose one or more dates from a graphical calendar presented in a one-month or
* multi-month interface. Calendars are generated entirely via script and can be navigated without any page refreshes.
* @module    calendar
* @title    Calendar
* @namespace  YAHOO.widget
* @requires  yahoo,dom,event
*/
(function(){

    var Dom = YAHOO.util.Dom,
        Event = YAHOO.util.Event,
        Lang = YAHOO.lang,
        DateMath = YAHOO.widget.DateMath;

/**
* Calendar is the base class for the Calendar widget. In its most basic
* implementation, it has the ability to render a calendar widget on the page
* that can be manipulated to select a single date, move back and forth between
* months and years.
* <p>To construct the placeholder for the calendar widget, the code is as
* follows:
*   <xmp>
*       <div id="calContainer"></div>
*   </xmp>
* </p>
* <p>
* <strong>NOTE: As of 2.4.0, the constructor's ID argument is optional.</strong>
* The Calendar can be constructed by simply providing a container ID string, 
* or a reference to a container DIV HTMLElement (the element needs to exist 
* in the document).
* 
* E.g.:
*   <xmp>
*       var c = new YAHOO.widget.Calendar("calContainer", configOptions);
*   </xmp>
* or:
*   <xmp>
*       var containerDiv = YAHOO.util.Dom.get("calContainer");
*       var c = new YAHOO.widget.Calendar(containerDiv, configOptions);
*   </xmp>
* </p>
* <p>
* If not provided, the ID will be generated from the container DIV ID by adding an "_t" suffix.
* For example if an ID is not provided, and the container's ID is "calContainer", the Calendar's ID will be set to "calContainer_t".
* </p>
* 
* @namespace YAHOO.widget
* @class Calendar
* @constructor
* @param {String} id optional The id of the table element that will represent the Calendar widget. As of 2.4.0, this argument is optional.
* @param {String | HTMLElement} container The id of the container div element that will wrap the Calendar table, or a reference to a DIV element which exists in the document.
* @param {Object} config optional The configuration object containing the initial configuration values for the Calendar.
*/
function Calendar(id, containerId, config) {
    this.init.apply(this, arguments);
}

/**
* The path to be used for images loaded for the Calendar
* @property YAHOO.widget.Calendar.IMG_ROOT
* @static
* @deprecated   You can now customize images by overriding the calclose, calnavleft and calnavright default CSS classes for the close icon, left arrow and right arrow respectively
* @type String
*/
Calendar.IMG_ROOT = null;

/**
* Type constant used for renderers to represent an individual date (M/D/Y)
* @property YAHOO.widget.Calendar.DATE
* @static
* @final
* @type String
*/
Calendar.DATE = "D";

/**
* Type constant used for renderers to represent an individual date across any year (M/D)
* @property YAHOO.widget.Calendar.MONTH_DAY
* @static
* @final
* @type String
*/
Calendar.MONTH_DAY = "MD";

/**
* Type constant used for renderers to represent a weekday
* @property YAHOO.widget.Calendar.WEEKDAY
* @static
* @final
* @type String
*/
Calendar.WEEKDAY = "WD";

/**
* Type constant used for renderers to represent a range of individual dates (M/D/Y-M/D/Y)
* @property YAHOO.widget.Calendar.RANGE
* @static
* @final
* @type String
*/
Calendar.RANGE = "R";

/**
* Type constant used for renderers to represent a month across any year
* @property YAHOO.widget.Calendar.MONTH
* @static
* @final
* @type String
*/
Calendar.MONTH = "M";

/**
* Constant that represents the total number of date cells that are displayed in a given month
* @property YAHOO.widget.Calendar.DISPLAY_DAYS
* @static
* @final
* @type Number
*/
Calendar.DISPLAY_DAYS = 42;

/**
* Constant used for halting the execution of the remainder of the render stack
* @property YAHOO.widget.Calendar.STOP_RENDER
* @static
* @final
* @type String
*/
Calendar.STOP_RENDER = "S";

/**
* Constant used to represent short date field string formats (e.g. Tu or Feb)
* @property YAHOO.widget.Calendar.SHORT
* @static
* @final
* @type String
*/
Calendar.SHORT = "short";

/**
* Constant used to represent long date field string formats (e.g. Monday or February)
* @property YAHOO.widget.Calendar.LONG
* @static
* @final
* @type String
*/
Calendar.LONG = "long";

/**
* Constant used to represent medium date field string formats (e.g. Mon)
* @property YAHOO.widget.Calendar.MEDIUM
* @static
* @final
* @type String
*/
Calendar.MEDIUM = "medium";

/**
* Constant used to represent single character date field string formats (e.g. M, T, W)
* @property YAHOO.widget.Calendar.ONE_CHAR
* @static
* @final
* @type String
*/
Calendar.ONE_CHAR = "1char";

/**
* The set of default Config property keys and values for the Calendar.
*
* <p>
* NOTE: This property is made public in order to allow users to change 
* the default values of configuration properties. Users should not 
* modify the key string, unless they are overriding the Calendar implementation
* </p>
*
* <p>
* The property is an object with key/value pairs, the key being the 
* uppercase configuration property name and the value being an object 
* literal with a key string property, and a value property, specifying the 
* default value of the property. To override a default value, you can set
* the value property, for example, <code>YAHOO.widget.Calendar.DEFAULT_CONFIG.MULTI_SELECT.value = true;</code>
* 
* @property YAHOO.widget.Calendar.DEFAULT_CONFIG
* @static
* @type Object
*/

Calendar.DEFAULT_CONFIG = {
    YEAR_OFFSET : {key:"year_offset", value:0, supercedes:["pagedate", "selected", "mindate","maxdate"]},
    TODAY : {key:"today", value:new Date(), supercedes:["pagedate"]}, 
    PAGEDATE : {key:"pagedate", value:null},
    SELECTED : {key:"selected", value:[]},
    TITLE : {key:"title", value:""},
    CLOSE : {key:"close", value:false},
    IFRAME : {key:"iframe", value:(YAHOO.env.ua.ie && YAHOO.env.ua.ie <= 6) ? true : false},
    MINDATE : {key:"mindate", value:null},
    MAXDATE : {key:"maxdate", value:null},
    MULTI_SELECT : {key:"multi_select", value:false},
    OOM_SELECT : {key:"oom_select", value:false},
    START_WEEKDAY : {key:"start_weekday", value:0},
    SHOW_WEEKDAYS : {key:"show_weekdays", value:true},
    SHOW_WEEK_HEADER : {key:"show_week_header", value:false},
    SHOW_WEEK_FOOTER : {key:"show_week_footer", value:false},
    HIDE_BLANK_WEEKS : {key:"hide_blank_weeks", value:false},
    NAV_ARROW_LEFT: {key:"nav_arrow_left", value:null} ,
    NAV_ARROW_RIGHT : {key:"nav_arrow_right", value:null} ,
    MONTHS_SHORT : {key:"months_short", value:["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]},
    MONTHS_LONG: {key:"months_long", value:["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]},
    WEEKDAYS_1CHAR: {key:"weekdays_1char", value:["S", "M", "T", "W", "T", "F", "S"]},
    WEEKDAYS_SHORT: {key:"weekdays_short", value:["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]},
    WEEKDAYS_MEDIUM: {key:"weekdays_medium", value:["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]},
    WEEKDAYS_LONG: {key:"weekdays_long", value:["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]},
    LOCALE_MONTHS:{key:"locale_months", value:"long"},
    LOCALE_WEEKDAYS:{key:"locale_weekdays", value:"short"},
    DATE_DELIMITER:{key:"date_delimiter", value:","},
    DATE_FIELD_DELIMITER:{key:"date_field_delimiter", value:"/"},
    DATE_RANGE_DELIMITER:{key:"date_range_delimiter", value:"-"},
    MY_MONTH_POSITION:{key:"my_month_position", value:1},
    MY_YEAR_POSITION:{key:"my_year_position", value:2},
    MD_MONTH_POSITION:{key:"md_month_position", value:1},
    MD_DAY_POSITION:{key:"md_day_position", value:2},
    MDY_MONTH_POSITION:{key:"mdy_month_position", value:1},
    MDY_DAY_POSITION:{key:"mdy_day_position", value:2},
    MDY_YEAR_POSITION:{key:"mdy_year_position", value:3},
    MY_LABEL_MONTH_POSITION:{key:"my_label_month_position", value:1},
    MY_LABEL_YEAR_POSITION:{key:"my_label_year_position", value:2},
    MY_LABEL_MONTH_SUFFIX:{key:"my_label_month_suffix", value:" "},
    MY_LABEL_YEAR_SUFFIX:{key:"my_label_year_suffix", value:""},
    NAV: {key:"navigator", value: null},
    STRINGS : { 
        key:"strings",
        value: {
            previousMonth : "Previous Month",
            nextMonth : "Next Month",
            close: "Close"
        },
        supercedes : ["close", "title"]
    }
};

/**
* The set of default Config property keys and values for the Calendar
* @property YAHOO.widget.Calendar._DEFAULT_CONFIG
* @deprecated Made public. See the public DEFAULT_CONFIG property for details
* @final
* @static
* @private
* @type Object
*/
Calendar._DEFAULT_CONFIG = Calendar.DEFAULT_CONFIG;

var DEF_CFG = Calendar.DEFAULT_CONFIG;

/**
* The set of Custom Event types supported by the Calendar
* @property YAHOO.widget.Calendar._EVENT_TYPES
* @final
* @static
* @private
* @type Object
*/
Calendar._EVENT_TYPES = {
    BEFORE_SELECT : "beforeSelect", 
    SELECT : "select",
    BEFORE_DESELECT : "beforeDeselect",
    DESELECT : "deselect",
    CHANGE_PAGE : "changePage",
    BEFORE_RENDER : "beforeRender",
    RENDER : "render",
    BEFORE_DESTROY : "beforeDestroy",
    DESTROY : "destroy",
    RESET : "reset",
    CLEAR : "clear",
    BEFORE_HIDE : "beforeHide",
    HIDE : "hide",
    BEFORE_SHOW : "beforeShow",
    SHOW : "show",
    BEFORE_HIDE_NAV : "beforeHideNav",
    HIDE_NAV : "hideNav",
    BEFORE_SHOW_NAV : "beforeShowNav",
    SHOW_NAV : "showNav",
    BEFORE_RENDER_NAV : "beforeRenderNav",
    RENDER_NAV : "renderNav"
};

/**
* The set of default style constants for the Calendar
* @property YAHOO.widget.Calendar.STYLES
* @static
* @type Object An object with name/value pairs for the class name identifier/value.
*/
Calendar.STYLES = {
    CSS_ROW_HEADER: "calrowhead",
    CSS_ROW_FOOTER: "calrowfoot",
    CSS_CELL : "calcell",
    CSS_CELL_SELECTOR : "selector",
    CSS_CELL_SELECTED : "selected",
    CSS_CELL_SELECTABLE : "selectable",
    CSS_CELL_RESTRICTED : "restricted",
    CSS_CELL_TODAY : "today",
    CSS_CELL_OOM : "oom",
    CSS_CELL_OOB : "previous",
    CSS_HEADER : "calheader",
    CSS_HEADER_TEXT : "calhead",
    CSS_BODY : "calbody",
    CSS_WEEKDAY_CELL : "calweekdaycell",
    CSS_WEEKDAY_ROW : "calweekdayrow",
    CSS_FOOTER : "calfoot",
    CSS_CALENDAR : "yui-calendar",
    CSS_SINGLE : "single",
    CSS_CONTAINER : "yui-calcontainer",
    CSS_NAV_LEFT : "calnavleft",
    CSS_NAV_RIGHT : "calnavright",
    CSS_NAV : "calnav",
    CSS_CLOSE : "calclose",
    CSS_CELL_TOP : "calcelltop",
    CSS_CELL_LEFT : "calcellleft",
    CSS_CELL_RIGHT : "calcellright",
    CSS_CELL_BOTTOM : "calcellbottom",
    CSS_CELL_HOVER : "calcellhover",
    CSS_CELL_HIGHLIGHT1 : "highlight1",
    CSS_CELL_HIGHLIGHT2 : "highlight2",
    CSS_CELL_HIGHLIGHT3 : "highlight3",
    CSS_CELL_HIGHLIGHT4 : "highlight4",
    CSS_WITH_TITLE: "withtitle",
    CSS_FIXED_SIZE: "fixedsize",
    CSS_LINK_CLOSE: "link-close"
};

/**
* The set of default style constants for the Calendar
* @property YAHOO.widget.Calendar._STYLES
* @deprecated Made public. See the public STYLES property for details
* @final
* @static
* @private
* @type Object
*/
Calendar._STYLES = Calendar.STYLES;

Calendar.prototype = {

    /**
    * The configuration object used to set up the calendars various locale and style options.
    * @property Config
    * @private
    * @deprecated Configuration properties should be set by calling Calendar.cfg.setProperty.
    * @type Object
    */
    Config : null,

    /**
    * The parent CalendarGroup, only to be set explicitly by the parent group
    * @property parent
    * @type CalendarGroup
    */ 
    parent : null,

    /**
    * The index of this item in the parent group
    * @property index
    * @type Number
    */
    index : -1,

    /**
    * The collection of calendar table cells
    * @property cells
    * @type HTMLTableCellElement[]
    */
    cells : null,

    /**
    * The collection of calendar cell dates that is parallel to the cells collection. The array contains dates field arrays in the format of [YYYY, M, D].
    * @property cellDates
    * @type Array[](Number[])
    */
    cellDates : null,

    /**
    * The id that uniquely identifies this Calendar.
    * @property id
    * @type String
    */
    id : null,

    /**
    * The unique id associated with the Calendar's container
    * @property containerId
    * @type String
    */
    containerId: null,

    /**
    * The DOM element reference that points to this calendar's container element. The calendar will be inserted into this element when the shell is rendered.
    * @property oDomContainer
    * @type HTMLElement
    */
    oDomContainer : null,

    /**
    * A Date object representing today's date.
    * @deprecated Use the "today" configuration property
    * @property today
    * @type Date
    */
    today : null,

    /**
    * The list of render functions, along with required parameters, used to render cells. 
    * @property renderStack
    * @type Array[]
    */
    renderStack : null,

    /**
    * A copy of the initial render functions created before rendering.
    * @property _renderStack
    * @private
    * @type Array
    */
    _renderStack : null,

    /**
    * A reference to the CalendarNavigator instance created for this Calendar.
    * Will be null if the "navigator" configuration property has not been set
    * @property oNavigator
    * @type CalendarNavigator
    */
    oNavigator : null,

    /**
    * The private list of initially selected dates.
    * @property _selectedDates
    * @private
    * @type Array
    */
    _selectedDates : null,

    /**
    * A map of DOM event handlers to attach to cells associated with specific CSS class names
    * @property domEventMap
    * @type Object
    */
    domEventMap : null,

    /**
     * Protected helper used to parse Calendar constructor/init arguments.
     *
     * As of 2.4.0, Calendar supports a simpler constructor 
     * signature. This method reconciles arguments
     * received in the pre 2.4.0 and 2.4.0 formats.
     * 
     * @protected
     * @method _parseArgs
     * @param {Array} Function "arguments" array
     * @return {Object} Object with id, container, config properties containing
     * the reconciled argument values.
     **/
    _parseArgs : function(args) {
        /*
           2.4.0 Constructors signatures

           new Calendar(String)
           new Calendar(HTMLElement)
           new Calendar(String, ConfigObject)
           new Calendar(HTMLElement, ConfigObject)

           Pre 2.4.0 Constructor signatures

           new Calendar(String, String)
           new Calendar(String, HTMLElement)
           new Calendar(String, String, ConfigObject)
           new Calendar(String, HTMLElement, ConfigObject)
         */
        var nArgs = {id:null, container:null, config:null};

        if (args && args.length && args.length > 0) {
            switch (args.length) {
                case 1:
                    nArgs.id = null;
                    nArgs.container = args[0];
                    nArgs.config = null;
                    break;
                case 2:
                    if (Lang.isObject(args[1]) && !args[1].tagName && !(args[1] instanceof String)) {
                        nArgs.id = null;
                        nArgs.container = args[0];
                        nArgs.config = args[1];
                    } else {
                        nArgs.id = args[0];
                        nArgs.container = args[1];
                        nArgs.config = null;
                    }
                    break;
                default: // 3+
                    nArgs.id = args[0];
                    nArgs.container = args[1];
                    nArgs.config = args[2];
                    break;
            }
        } else {
        }
        return nArgs;
    },

    /**
    * Initializes the Calendar widget.
    * @method init
    *
    * @param {String} id optional The id of the table element that will represent the Calendar widget. As of 2.4.0, this argument is optional.
    * @param {String | HTMLElement} container The id of the container div element that will wrap the Calendar table, or a reference to a DIV element which exists in the document.
    * @param {Object} config optional The configuration object containing the initial configuration values for the Calendar.
    */
    init : function(id, container, config) {
        // Normalize 2.4.0, pre 2.4.0 args
        var nArgs = this._parseArgs(arguments);

        id = nArgs.id;
        container = nArgs.container;
        config = nArgs.config;

        this.oDomContainer = Dom.get(container);

        this._oDoc = this.oDomContainer.ownerDocument;

        if (!this.oDomContainer.id) {
            this.oDomContainer.id = Dom.generateId();
        }

        if (!id) {
            id = this.oDomContainer.id + "_t";
        }

        this.id = id;
        this.containerId = this.oDomContainer.id;

        this.initEvents();

        /**
        * The Config object used to hold the configuration variables for the Calendar
        * @property cfg
        * @type YAHOO.util.Config
        */
        this.cfg = new YAHOO.util.Config(this);

        /**
        * The local object which contains the Calendar's options
        * @property Options
        * @type Object
        */
        this.Options = {};

        /**
        * The local object which contains the Calendar's locale settings
        * @property Locale
        * @type Object
        */
        this.Locale = {};

        this.initStyles();

        Dom.addClass(this.oDomContainer, this.Style.CSS_CONTAINER);
        Dom.addClass(this.oDomContainer, this.Style.CSS_SINGLE);

        this.cellDates = [];
        this.cells = [];
        this.renderStack = [];
        this._renderStack = [];

        this.setupConfig();

        if (config) {
            this.cfg.applyConfig(config, true);
        }

        this.cfg.fireQueue();

        this.today = this.cfg.getProperty("today");
    },

    /**
    * Default Config listener for the iframe property. If the iframe config property is set to true, 
    * renders the built-in IFRAME shim if the container is relatively or absolutely positioned.
    * 
    * @method configIframe
    */
    configIframe : function(type, args, obj) {
        var useIframe = args[0];
    
        if (!this.parent) {
            if (Dom.inDocument(this.oDomContainer)) {
                if (useIframe) {
                    var pos = Dom.getStyle(this.oDomContainer, "position");
                    
                    if (pos == "absolute" || pos == "relative") {
                        
                        if (!Dom.inDocument(this.iframe)) {
                            this.iframe = document.createElement("iframe");
                            this.iframe.src = "javascript:false;";
    
                            Dom.setStyle(this.iframe, "opacity", "0");
    
                            if (YAHOO.env.ua.ie && YAHOO.env.ua.ie <= 6) {
                                Dom.addClass(this.iframe, this.Style.CSS_FIXED_SIZE);
                            }
    
                            this.oDomContainer.insertBefore(this.iframe, this.oDomContainer.firstChild);
                        }
                    }
                } else {
                    if (this.iframe) {
                        if (this.iframe.parentNode) {
                            this.iframe.parentNode.removeChild(this.iframe);
                        }
                        this.iframe = null;
                    }
                }
            }
        }
    },

    /**
    * Default handler for the "title" property
    * @method configTitle
    */
    configTitle : function(type, args, obj) {
        var title = args[0];

        // "" disables title bar
        if (title) {
            this.createTitleBar(title);
        } else {
            var close = this.cfg.getProperty(DEF_CFG.CLOSE.key);
            if (!close) {
                this.removeTitleBar();
            } else {
                this.createTitleBar("&#160;");
            }
        }
    },
    
    /**
    * Default handler for the "close" property
    * @method configClose
    */
    configClose : function(type, args, obj) {
        var close = args[0],
            title = this.cfg.getProperty(DEF_CFG.TITLE.key);
    
        if (close) {
            if (!title) {
                this.createTitleBar("&#160;");
            }
            this.createCloseButton();
        } else {
            this.removeCloseButton();
            if (!title) {
                this.removeTitleBar();
            }
        }
    },

    /**
    * Initializes Calendar's built-in CustomEvents
    * @method initEvents
    */
    initEvents : function() {

        var defEvents = Calendar._EVENT_TYPES,
            CE = YAHOO.util.CustomEvent,
            cal = this; // To help with minification

        /**
        * Fired before a date selection is made
        * @event beforeSelectEvent
        */
        cal.beforeSelectEvent = new CE(defEvents.BEFORE_SELECT); 

        /**
        * Fired when a date selection is made
        * @event selectEvent
        * @param {Array} Array of Date field arrays in the format [YYYY, MM, DD].
        */
        cal.selectEvent = new CE(defEvents.SELECT);

        /**
        * Fired before a date or set of dates is deselected
        * @event beforeDeselectEvent
        */
        cal.beforeDeselectEvent = new CE(defEvents.BEFORE_DESELECT);

        /**
        * Fired when a date or set of dates is deselected
        * @event deselectEvent
        * @param {Array} Array of Date field arrays in the format [YYYY, MM, DD].
        */
        cal.deselectEvent = new CE(defEvents.DESELECT);
    
        /**
        * Fired when the Calendar page is changed
        * @event changePageEvent
        * @param {Date} prevDate The date before the page was changed
        * @param {Date} newDate The date after the page was changed
        */
        cal.changePageEvent = new CE(defEvents.CHANGE_PAGE);
    
        /**
        * Fired before the Calendar is rendered
        * @event beforeRenderEvent
        */
        cal.beforeRenderEvent = new CE(defEvents.BEFORE_RENDER);
    
        /**
        * Fired when the Calendar is rendered
        * @event renderEvent
        */
        cal.renderEvent = new CE(defEvents.RENDER);

        /**
        * Fired just before the Calendar is to be destroyed
        * @event beforeDestroyEvent
        */
        cal.beforeDestroyEvent = new CE(defEvents.BEFORE_DESTROY);

        /**
        * Fired after the Calendar is destroyed. This event should be used
        * for notification only. When this event is fired, important Calendar instance
        * properties, dom references and event listeners have already been 
        * removed/dereferenced, and hence the Calendar instance is not in a usable 
        * state.
        *
        * @event destroyEvent
        */
        cal.destroyEvent = new CE(defEvents.DESTROY);

        /**
        * Fired when the Calendar is reset
        * @event resetEvent
        */
        cal.resetEvent = new CE(defEvents.RESET);

        /**
        * Fired when the Calendar is cleared
        * @event clearEvent
        */
        cal.clearEvent = new CE(defEvents.CLEAR);

        /**
        * Fired just before the Calendar is to be shown
        * @event beforeShowEvent
        */
        cal.beforeShowEvent = new CE(defEvents.BEFORE_SHOW);

        /**
        * Fired after the Calendar is shown
        * @event showEvent
        */
        cal.showEvent = new CE(defEvents.SHOW);

        /**
        * Fired just before the Calendar is to be hidden
        * @event beforeHideEvent
        */
        cal.beforeHideEvent = new CE(defEvents.BEFORE_HIDE);

        /**
        * Fired after the Calendar is hidden
        * @event hideEvent
        */
        cal.hideEvent = new CE(defEvents.HIDE);

        /**
        * Fired just before the CalendarNavigator is to be shown
        * @event beforeShowNavEvent
        */
        cal.beforeShowNavEvent = new CE(defEvents.BEFORE_SHOW_NAV);
    
        /**
        * Fired after the CalendarNavigator is shown
        * @event showNavEvent
        */
        cal.showNavEvent = new CE(defEvents.SHOW_NAV);
    
        /**
        * Fired just before the CalendarNavigator is to be hidden
        * @event beforeHideNavEvent
        */
        cal.beforeHideNavEvent = new CE(defEvents.BEFORE_HIDE_NAV);
    
        /**
        * Fired after the CalendarNavigator is hidden
        * @event hideNavEvent
        */
        cal.hideNavEvent = new CE(defEvents.HIDE_NAV);

        /**
        * Fired just before the CalendarNavigator is to be rendered
        * @event beforeRenderNavEvent
        */
        cal.beforeRenderNavEvent = new CE(defEvents.BEFORE_RENDER_NAV);

        /**
        * Fired after the CalendarNavigator is rendered
        * @event renderNavEvent
        */
        cal.renderNavEvent = new CE(defEvents.RENDER_NAV);

        cal.beforeSelectEvent.subscribe(cal.onBeforeSelect, this, true);
        cal.selectEvent.subscribe(cal.onSelect, this, true);
        cal.beforeDeselectEvent.subscribe(cal.onBeforeDeselect, this, true);
        cal.deselectEvent.subscribe(cal.onDeselect, this, true);
        cal.changePageEvent.subscribe(cal.onChangePage, this, true);
        cal.renderEvent.subscribe(cal.onRender, this, true);
        cal.resetEvent.subscribe(cal.onReset, this, true);
        cal.clearEvent.subscribe(cal.onClear, this, true);
    },

    /**
    * The default event handler for clicks on the "Previous Month" navigation UI
    *
    * @method doPreviousMonthNav
    * @param {DOMEvent} e The DOM event
    * @param {Calendar} cal A reference to the calendar
    */
    doPreviousMonthNav : function(e, cal) {
        Event.preventDefault(e);
        // previousMonth invoked in a timeout, to allow
        // event to bubble up, with correct target. Calling
        // previousMonth, will call render which will remove 
        // HTML which generated the event, resulting in an 
        // invalid event target in certain browsers.
        setTimeout(function() {
            cal.previousMonth();
            var navs = Dom.getElementsByClassName(cal.Style.CSS_NAV_LEFT, "a", cal.oDomContainer);
            if (navs && navs[0]) {
                try {
                    navs[0].focus();
                } catch (ex) {
                    // ignore
                }
            }
        }, 0);
    },

    /**
     * The default event handler for clicks on the "Next Month" navigation UI
     *
     * @method doNextMonthNav
     * @param {DOMEvent} e The DOM event
     * @param {Calendar} cal A reference to the calendar
     */
    doNextMonthNav : function(e, cal) {
        Event.preventDefault(e);
        setTimeout(function() {
            cal.nextMonth();
            var navs = Dom.getElementsByClassName(cal.Style.CSS_NAV_RIGHT, "a", cal.oDomContainer);
            if (navs && navs[0]) {
                try {
                    navs[0].focus();
                } catch (ex) {
                    // ignore
                }
            }
        }, 0);
    },

    /**
    * The default event handler for date cell selection. Currently attached to 
    * the Calendar's bounding box, referenced by it's <a href="#property_oDomContainer">oDomContainer</a> property.
    *
    * @method doSelectCell
    * @param {DOMEvent} e The DOM event
    * @param {Calendar} cal A reference to the calendar
    */
    doSelectCell : function(e, cal) {
        var cell, d, date, index;

        var target = Event.getTarget(e),
            tagName = target.tagName.toLowerCase(),
            defSelector = false;

        while (tagName != "td" && !Dom.hasClass(target, cal.Style.CSS_CELL_SELECTABLE)) {

            if (!defSelector && tagName == "a" && Dom.hasClass(target, cal.Style.CSS_CELL_SELECTOR)) {
                defSelector = true;
            }

            target = target.parentNode;
            tagName = target.tagName.toLowerCase();

            if (target == this.oDomContainer || tagName == "html") {
                return;
            }
        }

        if (defSelector) {
            // Stop link href navigation for default renderer
            Event.preventDefault(e);
        }
    
        cell = target;

        if (Dom.hasClass(cell, cal.Style.CSS_CELL_SELECTABLE)) {
            index = cal.getIndexFromId(cell.id);
            if (index > -1) {
                d = cal.cellDates[index];
                if (d) {
                    date = DateMath.getDate(d[0],d[1]-1,d[2]);
                
                    var link;

                    if (cal.Options.MULTI_SELECT) {
                        link = cell.getElementsByTagName("a")[0];
                        if (link) {
                            link.blur();
                        }

                        var cellDate = cal.cellDates[index];
                        var cellDateIndex = cal._indexOfSelectedFieldArray(cellDate);

                        if (cellDateIndex > -1) { 
                            cal.deselectCell(index);
                        } else {
                            cal.selectCell(index);
                        }

                    } else {
                        link = cell.getElementsByTagName("a")[0];
                        if (link) {
                            link.blur();
                        }
                        cal.selectCell(index);
                    }
                }
            }
        }
    },

    /**
    * The event that is executed when the user hovers over a cell
    * @method doCellMouseOver
    * @param {DOMEvent} e The event
    * @param {Calendar} cal A reference to the calendar passed by the Event utility
    */
    doCellMouseOver : function(e, cal) {
        var target;
        if (e) {
            target = Event.getTarget(e);
        } else {
            target = this;
        }

        while (target.tagName && target.tagName.toLowerCase() != "td") {
            target = target.parentNode;
            if (!target.tagName || target.tagName.toLowerCase() == "html") {
                return;
            }
        }

        if (Dom.hasClass(target, cal.Style.CSS_CELL_SELECTABLE)) {
            Dom.addClass(target, cal.Style.CSS_CELL_HOVER);
        }
    },

    /**
    * The event that is executed when the user moves the mouse out of a cell
    * @method doCellMouseOut
    * @param {DOMEvent} e The event
    * @param {Calendar} cal A reference to the calendar passed by the Event utility
    */
    doCellMouseOut : function(e, cal) {
        var target;
        if (e) {
            target = Event.getTarget(e);
        } else {
            target = this;
        }

        while (target.tagName && target.tagName.toLowerCase() != "td") {
            target = target.parentNode;
            if (!target.tagName || target.tagName.toLowerCase() == "html") {
                return;
            }
        }

        if (Dom.hasClass(target, cal.Style.CSS_CELL_SELECTABLE)) {
            Dom.removeClass(target, cal.Style.CSS_CELL_HOVER);
        }
    },

    setupConfig : function() {

        var cfg = this.cfg;

        /**
        * The date to use to represent "Today".
        *
        * @config today
        * @type Date
        * @default The client side date (new Date()) when the Calendar is instantiated.
        */
        cfg.addProperty(DEF_CFG.TODAY.key, { value: new Date(DEF_CFG.TODAY.value.getTime()), supercedes:DEF_CFG.TODAY.supercedes, handler:this.configToday, suppressEvent:true } );

        /**
        * The month/year representing the current visible Calendar date (mm/yyyy)
        * @config pagedate
        * @type String | Date
        * @default Today's date
        */
        cfg.addProperty(DEF_CFG.PAGEDATE.key, { value: DEF_CFG.PAGEDATE.value || new Date(DEF_CFG.TODAY.value.getTime()), handler:this.configPageDate } );

        /**
        * The date or range of dates representing the current Calendar selection
        * @config selected
        * @type String
        * @default []
        */
        cfg.addProperty(DEF_CFG.SELECTED.key, { value:DEF_CFG.SELECTED.value.concat(), handler:this.configSelected } );

        /**
        * The title to display above the Calendar's month header. The title is inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.   
        * @config title
        * @type HTML
        * @default ""
        */
        cfg.addProperty(DEF_CFG.TITLE.key, { value:DEF_CFG.TITLE.value, handler:this.configTitle } );

        /**
        * Whether or not a close button should be displayed for this Calendar
        * @config close
        * @type Boolean
        * @default false
        */
        cfg.addProperty(DEF_CFG.CLOSE.key, { value:DEF_CFG.CLOSE.value, handler:this.configClose } );

        /**
        * Whether or not an iframe shim should be placed under the Calendar to prevent select boxes from bleeding through in Internet Explorer 6 and below.
        * This property is enabled by default for IE6 and below. It is disabled by default for other browsers for performance reasons, but can be 
        * enabled if required.
        * 
        * @config iframe
        * @type Boolean
        * @default true for IE6 and below, false for all other browsers
        */
        cfg.addProperty(DEF_CFG.IFRAME.key, { value:DEF_CFG.IFRAME.value, handler:this.configIframe, validator:cfg.checkBoolean } );

        /**
        * The minimum selectable date in the current Calendar (mm/dd/yyyy)
        * @config mindate
        * @type String | Date
        * @default null
        */
        cfg.addProperty(DEF_CFG.MINDATE.key, { value:DEF_CFG.MINDATE.value, handler:this.configMinDate } );

        /**
        * The maximum selectable date in the current Calendar (mm/dd/yyyy)
        * @config maxdate
        * @type String | Date
        * @default null
        */
        cfg.addProperty(DEF_CFG.MAXDATE.key, { value:DEF_CFG.MAXDATE.value, handler:this.configMaxDate } );

        // Options properties
    
        /**
        * True if the Calendar should allow multiple selections. False by default.
        * @config MULTI_SELECT
        * @type Boolean
        * @default false
        */
        cfg.addProperty(DEF_CFG.MULTI_SELECT.key, { value:DEF_CFG.MULTI_SELECT.value, handler:this.configOptions, validator:cfg.checkBoolean } );

        /**
        * True if the Calendar should allow selection of out-of-month dates. False by default.
        * @config OOM_SELECT
        * @type Boolean
        * @default false
        */
        cfg.addProperty(DEF_CFG.OOM_SELECT.key, { value:DEF_CFG.OOM_SELECT.value, handler:this.configOptions, validator:cfg.checkBoolean } );

        /**
        * The weekday the week begins on. Default is 0 (Sunday = 0, Monday = 1 ... Saturday = 6).
        * @config START_WEEKDAY
        * @type number
        * @default 0
        */
        cfg.addProperty(DEF_CFG.START_WEEKDAY.key, { value:DEF_CFG.START_WEEKDAY.value, handler:this.configOptions, validator:cfg.checkNumber  } );
    
        /**
        * True if the Calendar should show weekday labels. True by default.
        * @config SHOW_WEEKDAYS
        * @type Boolean
        * @default true
        */
        cfg.addProperty(DEF_CFG.SHOW_WEEKDAYS.key, { value:DEF_CFG.SHOW_WEEKDAYS.value, handler:this.configOptions, validator:cfg.checkBoolean  } );
    
        /**
        * True if the Calendar should show week row headers. False by default.
        * @config SHOW_WEEK_HEADER
        * @type Boolean
        * @default false
        */
        cfg.addProperty(DEF_CFG.SHOW_WEEK_HEADER.key, { value:DEF_CFG.SHOW_WEEK_HEADER.value, handler:this.configOptions, validator:cfg.checkBoolean } );
    
        /**
        * True if the Calendar should show week row footers. False by default.
        * @config SHOW_WEEK_FOOTER
        * @type Boolean
        * @default false
        */ 
        cfg.addProperty(DEF_CFG.SHOW_WEEK_FOOTER.key,{ value:DEF_CFG.SHOW_WEEK_FOOTER.value, handler:this.configOptions, validator:cfg.checkBoolean } );
    
        /**
        * True if the Calendar should suppress weeks that are not a part of the current month. False by default.
        * @config HIDE_BLANK_WEEKS
        * @type Boolean
        * @default false
        */ 
        cfg.addProperty(DEF_CFG.HIDE_BLANK_WEEKS.key, { value:DEF_CFG.HIDE_BLANK_WEEKS.value, handler:this.configOptions, validator:cfg.checkBoolean } );
        
        /**
        * The image URL that should be used for the left navigation arrow. The image URL is inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config NAV_ARROW_LEFT
        * @type String
        * @deprecated You can customize the image by overriding the default CSS class for the left arrow - "calnavleft"  
        * @default null
        */ 
        cfg.addProperty(DEF_CFG.NAV_ARROW_LEFT.key, { value:DEF_CFG.NAV_ARROW_LEFT.value, handler:this.configOptions } );
    
        /**
        * The image URL that should be used for the right navigation arrow. The image URL is inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config NAV_ARROW_RIGHT
        * @type String
        * @deprecated You can customize the image by overriding the default CSS class for the right arrow - "calnavright"
        * @default null
        */ 
        cfg.addProperty(DEF_CFG.NAV_ARROW_RIGHT.key, { value:DEF_CFG.NAV_ARROW_RIGHT.value, handler:this.configOptions } );
    
        // Locale properties
    
        /**
        * The short month labels for the current locale. The month labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config MONTHS_SHORT
        * @type HTML[]
        * @default ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        */
        cfg.addProperty(DEF_CFG.MONTHS_SHORT.key, { value:DEF_CFG.MONTHS_SHORT.value, handler:this.configLocale } );

        /**
        * The long month labels for the current locale. The month labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config MONTHS_LONG
        * @type HTML[]
        * @default ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
        */ 
        cfg.addProperty(DEF_CFG.MONTHS_LONG.key,  { value:DEF_CFG.MONTHS_LONG.value, handler:this.configLocale } );

        /**
        * The 1-character weekday labels for the current locale. The weekday labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config WEEKDAYS_1CHAR
        * @type HTML[]
        * @default ["S", "M", "T", "W", "T", "F", "S"]
        */ 
        cfg.addProperty(DEF_CFG.WEEKDAYS_1CHAR.key, { value:DEF_CFG.WEEKDAYS_1CHAR.value, handler:this.configLocale } );
        
        /**
        * The short weekday labels for the current locale. The weekday labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config WEEKDAYS_SHORT
        * @type HTML[]
        * @default ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
        */ 
        cfg.addProperty(DEF_CFG.WEEKDAYS_SHORT.key, { value:DEF_CFG.WEEKDAYS_SHORT.value, handler:this.configLocale } );
        
        /**
        * The medium weekday labels for the current locale. The weekday labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config WEEKDAYS_MEDIUM
        * @type HTML[]
        * @default ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
        */ 
        cfg.addProperty(DEF_CFG.WEEKDAYS_MEDIUM.key, { value:DEF_CFG.WEEKDAYS_MEDIUM.value, handler:this.configLocale } );
        
        /**
        * The long weekday labels for the current locale. The weekday labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config WEEKDAYS_LONG
        * @type HTML[]
        * @default ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
        */ 
        cfg.addProperty(DEF_CFG.WEEKDAYS_LONG.key, { value:DEF_CFG.WEEKDAYS_LONG.value, handler:this.configLocale } );

        /**
        * Refreshes the locale values used to build the Calendar.
        * @method refreshLocale
        * @private
        */
        var refreshLocale = function() {
            cfg.refireEvent(DEF_CFG.LOCALE_MONTHS.key);
            cfg.refireEvent(DEF_CFG.LOCALE_WEEKDAYS.key);
        };
    
        cfg.subscribeToConfigEvent(DEF_CFG.START_WEEKDAY.key, refreshLocale, this, true);
        cfg.subscribeToConfigEvent(DEF_CFG.MONTHS_SHORT.key, refreshLocale, this, true);
        cfg.subscribeToConfigEvent(DEF_CFG.MONTHS_LONG.key, refreshLocale, this, true);
        cfg.subscribeToConfigEvent(DEF_CFG.WEEKDAYS_1CHAR.key, refreshLocale, this, true);
        cfg.subscribeToConfigEvent(DEF_CFG.WEEKDAYS_SHORT.key, refreshLocale, this, true);
        cfg.subscribeToConfigEvent(DEF_CFG.WEEKDAYS_MEDIUM.key, refreshLocale, this, true);
        cfg.subscribeToConfigEvent(DEF_CFG.WEEKDAYS_LONG.key, refreshLocale, this, true);
       
        /**
        * The setting that determines which length of month labels should be used. Possible values are "short" and "long".
        * @config LOCALE_MONTHS
        * @type String
        * @default "long"
        */ 
        cfg.addProperty(DEF_CFG.LOCALE_MONTHS.key, { value:DEF_CFG.LOCALE_MONTHS.value, handler:this.configLocaleValues } );
        
        /**
        * The setting that determines which length of weekday labels should be used. Possible values are "1char", "short", "medium", and "long".
        * @config LOCALE_WEEKDAYS
        * @type String
        * @default "short"
        */ 
        cfg.addProperty(DEF_CFG.LOCALE_WEEKDAYS.key, { value:DEF_CFG.LOCALE_WEEKDAYS.value, handler:this.configLocaleValues } );

        /**
        * The positive or negative year offset from the Gregorian calendar year (assuming a January 1st rollover) to 
        * be used when displaying and parsing dates. NOTE: All JS Date objects returned by methods, or expected as input by
        * methods will always represent the Gregorian year, in order to maintain date/month/week values. 
        *
        * @config YEAR_OFFSET
        * @type Number
        * @default 0
        */
        cfg.addProperty(DEF_CFG.YEAR_OFFSET.key, { value:DEF_CFG.YEAR_OFFSET.value, supercedes:DEF_CFG.YEAR_OFFSET.supercedes, handler:this.configLocale  } );
    
        /**
        * The value used to delimit individual dates in a date string passed to various Calendar functions.
        * @config DATE_DELIMITER
        * @type String
        * @default ","
        */ 
        cfg.addProperty(DEF_CFG.DATE_DELIMITER.key,  { value:DEF_CFG.DATE_DELIMITER.value, handler:this.configLocale } );
    
        /**
        * The value used to delimit date fields in a date string passed to various Calendar functions.
        * @config DATE_FIELD_DELIMITER
        * @type String
        * @default "/"
        */ 
        cfg.addProperty(DEF_CFG.DATE_FIELD_DELIMITER.key, { value:DEF_CFG.DATE_FIELD_DELIMITER.value, handler:this.configLocale } );
    
        /**
        * The value used to delimit date ranges in a date string passed to various Calendar functions.
        * @config DATE_RANGE_DELIMITER
        * @type String
        * @default "-"
        */
        cfg.addProperty(DEF_CFG.DATE_RANGE_DELIMITER.key, { value:DEF_CFG.DATE_RANGE_DELIMITER.value, handler:this.configLocale } );
    
        /**
        * The position of the month in a month/year date string
        * @config MY_MONTH_POSITION
        * @type Number
        * @default 1
        */
        cfg.addProperty(DEF_CFG.MY_MONTH_POSITION.key, { value:DEF_CFG.MY_MONTH_POSITION.value, handler:this.configLocale, validator:cfg.checkNumber } );
    
        /**
        * The position of the year in a month/year date string
        * @config MY_YEAR_POSITION
        * @type Number
        * @default 2
        */
        cfg.addProperty(DEF_CFG.MY_YEAR_POSITION.key, { value:DEF_CFG.MY_YEAR_POSITION.value, handler:this.configLocale, validator:cfg.checkNumber } );
    
        /**
        * The position of the month in a month/day date string
        * @config MD_MONTH_POSITION
        * @type Number
        * @default 1
        */
        cfg.addProperty(DEF_CFG.MD_MONTH_POSITION.key, { value:DEF_CFG.MD_MONTH_POSITION.value, handler:this.configLocale, validator:cfg.checkNumber } );
    
        /**
        * The position of the day in a month/year date string
        * @config MD_DAY_POSITION
        * @type Number
        * @default 2
        */
        cfg.addProperty(DEF_CFG.MD_DAY_POSITION.key,  { value:DEF_CFG.MD_DAY_POSITION.value, handler:this.configLocale, validator:cfg.checkNumber } );
    
        /**
        * The position of the month in a month/day/year date string
        * @config MDY_MONTH_POSITION
        * @type Number
        * @default 1
        */
        cfg.addProperty(DEF_CFG.MDY_MONTH_POSITION.key, { value:DEF_CFG.MDY_MONTH_POSITION.value, handler:this.configLocale, validator:cfg.checkNumber } );
    
        /**
        * The position of the day in a month/day/year date string
        * @config MDY_DAY_POSITION
        * @type Number
        * @default 2
        */
        cfg.addProperty(DEF_CFG.MDY_DAY_POSITION.key, { value:DEF_CFG.MDY_DAY_POSITION.value, handler:this.configLocale, validator:cfg.checkNumber } );
    
        /**
        * The position of the year in a month/day/year date string
        * @config MDY_YEAR_POSITION
        * @type Number
        * @default 3
        */
        cfg.addProperty(DEF_CFG.MDY_YEAR_POSITION.key, { value:DEF_CFG.MDY_YEAR_POSITION.value, handler:this.configLocale, validator:cfg.checkNumber } );
        
        /**
        * The position of the month in the month year label string used as the Calendar header
        * @config MY_LABEL_MONTH_POSITION
        * @type Number
        * @default 1
        */
        cfg.addProperty(DEF_CFG.MY_LABEL_MONTH_POSITION.key, { value:DEF_CFG.MY_LABEL_MONTH_POSITION.value, handler:this.configLocale, validator:cfg.checkNumber } );
    
        /**
        * The position of the year in the month year label string used as the Calendar header
        * @config MY_LABEL_YEAR_POSITION
        * @type Number
        * @default 2
        */
        cfg.addProperty(DEF_CFG.MY_LABEL_YEAR_POSITION.key, { value:DEF_CFG.MY_LABEL_YEAR_POSITION.value, handler:this.configLocale, validator:cfg.checkNumber } );
        
        /**
        * The suffix used after the month when rendering the Calendar header. The suffix is inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config MY_LABEL_MONTH_SUFFIX
        * @type HTML
        * @default " "
        */
        cfg.addProperty(DEF_CFG.MY_LABEL_MONTH_SUFFIX.key, { value:DEF_CFG.MY_LABEL_MONTH_SUFFIX.value, handler:this.configLocale } );
        
        /**
        * The suffix used after the year when rendering the Calendar header. The suffix is inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config MY_LABEL_YEAR_SUFFIX
        * @type HTML
        * @default ""
        */
        cfg.addProperty(DEF_CFG.MY_LABEL_YEAR_SUFFIX.key, { value:DEF_CFG.MY_LABEL_YEAR_SUFFIX.value, handler:this.configLocale } );

        /**
        * Configuration for the Month/Year CalendarNavigator UI which allows the user to jump directly to a 
        * specific Month/Year without having to scroll sequentially through months.
        * <p>
        * Setting this property to null (default value) or false, will disable the CalendarNavigator UI.
        * </p>
        * <p>
        * Setting this property to true will enable the CalendarNavigatior UI with the default CalendarNavigator configuration values.
        * </p>
        * <p>
        * This property can also be set to an object literal containing configuration properties for the CalendarNavigator UI.
        * The configuration object expects the the following case-sensitive properties, with the "strings" property being a nested object.
        * Any properties which are not provided will use the default values (defined in the CalendarNavigator class).
        * </p>
        * <dl>
        * <dt>strings</dt>
        * <dd><em>Object</em> :  An object with the properties shown below, defining the string labels to use in the Navigator's UI. The strings are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source. 
        *     <dl>
        *         <dt>month</dt><dd><em>HTML</em> : The markup to use for the month label. Defaults to "Month".</dd>
        *         <dt>year</dt><dd><em>HTML</em> : The markup to use for the year label. Defaults to "Year".</dd>
        *         <dt>submit</dt><dd><em>HTML</em> : The markup to use for the submit button label. Defaults to "Okay".</dd>
        *         <dt>cancel</dt><dd><em>HTML</em> : The markup to use for the cancel button label. Defaults to "Cancel".</dd>
        *         <dt>invalidYear</dt><dd><em>HTML</em> : The markup to use for invalid year values. Defaults to "Year needs to be a number".</dd>
        *     </dl>
        * </dd>
        * <dt>monthFormat</dt><dd><em>String</em> : The month format to use. Either YAHOO.widget.Calendar.LONG, or YAHOO.widget.Calendar.SHORT. Defaults to YAHOO.widget.Calendar.LONG</dd>
        * <dt>initialFocus</dt><dd><em>String</em> : Either "year" or "month" specifying which input control should get initial focus. Defaults to "year"</dd>
        * </dl>
        * <p>E.g.</p>
        * <pre>
        * var navConfig = {
        *   strings: {
        *    month:"Calendar Month",
        *    year:"Calendar Year",
        *    submit: "Submit",
        *    cancel: "Cancel",
        *    invalidYear: "Please enter a valid year"
        *   },
        *   monthFormat: YAHOO.widget.Calendar.SHORT,
        *   initialFocus: "month"
        * }
        * </pre>
        * @config navigator
        * @type {Object|Boolean}
        * @default null
        */
        cfg.addProperty(DEF_CFG.NAV.key, { value:DEF_CFG.NAV.value, handler:this.configNavigator } );

        /**
         * The map of UI strings which the Calendar UI uses.
         *
         * @config strings
         * @type {Object}
         * @default An object with the properties shown below:
         *     <dl>
         *         <dt>previousMonth</dt><dd><em>HTML</em> : The markup to use for the "Previous Month" navigation label. Defaults to "Previous Month". The string is added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.</dd>
         *         <dt>nextMonth</dt><dd><em>HTML</em> : The markup to use for the "Next Month" navigation UI. Defaults to "Next Month". The string is added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.</dd>
         *         <dt>close</dt><dd><em>HTML</em> : The markup to use for the close button label. Defaults to "Close". The string is added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.</dd>
         *     </dl>
         */
        cfg.addProperty(DEF_CFG.STRINGS.key, { 
            value:DEF_CFG.STRINGS.value,
            handler:this.configStrings,
            validator: function(val) {
                return Lang.isObject(val);
            },
            supercedes:DEF_CFG.STRINGS.supercedes
        });
    },

    /**
    * The default handler for the "strings" property
    * @method configStrings
    */
    configStrings : function(type, args, obj) {
        var val = Lang.merge(DEF_CFG.STRINGS.value, args[0]);
        this.cfg.setProperty(DEF_CFG.STRINGS.key, val, true);
    },

    /**
    * The default handler for the "pagedate" property
    * @method configPageDate
    */
    configPageDate : function(type, args, obj) {
        this.cfg.setProperty(DEF_CFG.PAGEDATE.key, this._parsePageDate(args[0]), true);
    },

    /**
    * The default handler for the "mindate" property
    * @method configMinDate
    */
    configMinDate : function(type, args, obj) {
        var val = args[0];
        if (Lang.isString(val)) {
            val = this._parseDate(val);
            this.cfg.setProperty(DEF_CFG.MINDATE.key, DateMath.getDate(val[0],(val[1]-1),val[2]));
        }
    },

    /**
    * The default handler for the "maxdate" property
    * @method configMaxDate
    */
    configMaxDate : function(type, args, obj) {
        var val = args[0];
        if (Lang.isString(val)) {
            val = this._parseDate(val);
            this.cfg.setProperty(DEF_CFG.MAXDATE.key, DateMath.getDate(val[0],(val[1]-1),val[2]));
        }
    },

    /**
    * The default handler for the "today" property
    * @method configToday
    */
    configToday : function(type, args, obj) {
        // Only do this for initial set. Changing the today property after the initial
        // set, doesn't affect pagedate
        var val = args[0];
        if (Lang.isString(val)) {
            val = this._parseDate(val);
        }
        var today = DateMath.clearTime(val);
        if (!this.cfg.initialConfig[DEF_CFG.PAGEDATE.key]) {
            this.cfg.setProperty(DEF_CFG.PAGEDATE.key, today);
        }
        this.today = today;
        this.cfg.setProperty(DEF_CFG.TODAY.key, today, true);
    },

    /**
    * The default handler for the "selected" property
    * @method configSelected
    */
    configSelected : function(type, args, obj) {
        var selected = args[0],
            cfgSelected = DEF_CFG.SELECTED.key;
        
        if (selected) {
            if (Lang.isString(selected)) {
                this.cfg.setProperty(cfgSelected, this._parseDates(selected), true);
            } 
        }
        if (! this._selectedDates) {
            this._selectedDates = this.cfg.getProperty(cfgSelected);
        }
    },
    
    /**
    * The default handler for all configuration options properties
    * @method configOptions
    */
    configOptions : function(type, args, obj) {
        this.Options[type.toUpperCase()] = args[0];
    },

    /**
    * The default handler for all configuration locale properties
    * @method configLocale
    */
    configLocale : function(type, args, obj) {
        this.Locale[type.toUpperCase()] = args[0];

        this.cfg.refireEvent(DEF_CFG.LOCALE_MONTHS.key);
        this.cfg.refireEvent(DEF_CFG.LOCALE_WEEKDAYS.key);
    },
    
    /**
    * The default handler for all configuration locale field length properties
    * @method configLocaleValues
    */
    configLocaleValues : function(type, args, obj) {

        type = type.toLowerCase();

        var val = args[0],
            cfg = this.cfg,
            Locale = this.Locale;

        switch (type) {
            case DEF_CFG.LOCALE_MONTHS.key:
                switch (val) {
                    case Calendar.SHORT:
                        Locale.LOCALE_MONTHS = cfg.getProperty(DEF_CFG.MONTHS_SHORT.key).concat();
                        break;
                    case Calendar.LONG:
                        Locale.LOCALE_MONTHS = cfg.getProperty(DEF_CFG.MONTHS_LONG.key).concat();
                        break;
                }
                break;
            case DEF_CFG.LOCALE_WEEKDAYS.key:
                switch (val) {
                    case Calendar.ONE_CHAR:
                        Locale.LOCALE_WEEKDAYS = cfg.getProperty(DEF_CFG.WEEKDAYS_1CHAR.key).concat();
                        break;
                    case Calendar.SHORT:
                        Locale.LOCALE_WEEKDAYS = cfg.getProperty(DEF_CFG.WEEKDAYS_SHORT.key).concat();
                        break;
                    case Calendar.MEDIUM:
                        Locale.LOCALE_WEEKDAYS = cfg.getProperty(DEF_CFG.WEEKDAYS_MEDIUM.key).concat();
                        break;
                    case Calendar.LONG:
                        Locale.LOCALE_WEEKDAYS = cfg.getProperty(DEF_CFG.WEEKDAYS_LONG.key).concat();
                        break;
                }
                
                var START_WEEKDAY = cfg.getProperty(DEF_CFG.START_WEEKDAY.key);
    
                if (START_WEEKDAY > 0) {
                    for (var w=0; w < START_WEEKDAY; ++w) {
                        Locale.LOCALE_WEEKDAYS.push(Locale.LOCALE_WEEKDAYS.shift());
                    }
                }
                break;
        }
    },

    /**
     * The default handler for the "navigator" property
     * @method configNavigator
     */
    configNavigator : function(type, args, obj) {
        var val = args[0];
        if (YAHOO.widget.CalendarNavigator && (val === true || Lang.isObject(val))) {
            if (!this.oNavigator) {
                this.oNavigator = new YAHOO.widget.CalendarNavigator(this);
                // Cleanup DOM Refs/Events before innerHTML is removed.
                this.beforeRenderEvent.subscribe(function () {
                    if (!this.pages) {
                        this.oNavigator.erase();
                    }
                }, this, true);
            }
        } else {
            if (this.oNavigator) {
                this.oNavigator.destroy();
                this.oNavigator = null;
            }
        }
    },

    /**
    * Defines the class names used by Calendar when rendering to DOM. NOTE: The class names are added to the DOM as HTML and should be escaped by the implementor if coming from an external source. 
    * @method initStyles
    */
    initStyles : function() {

        var defStyle = Calendar.STYLES;

        this.Style = {
            /**
            * @property Style.CSS_ROW_HEADER
            */
            CSS_ROW_HEADER: defStyle.CSS_ROW_HEADER,
            /**
            * @property Style.CSS_ROW_FOOTER
            */
            CSS_ROW_FOOTER: defStyle.CSS_ROW_FOOTER,
            /**
            * @property Style.CSS_CELL
            */
            CSS_CELL : defStyle.CSS_CELL,
            /**
            * @property Style.CSS_CELL_SELECTOR
            */
            CSS_CELL_SELECTOR : defStyle.CSS_CELL_SELECTOR,
            /**
            * @property Style.CSS_CELL_SELECTED
            */
            CSS_CELL_SELECTED : defStyle.CSS_CELL_SELECTED,
            /**
            * @property Style.CSS_CELL_SELECTABLE
            */
            CSS_CELL_SELECTABLE : defStyle.CSS_CELL_SELECTABLE,
            /**
            * @property Style.CSS_CELL_RESTRICTED
            */
            CSS_CELL_RESTRICTED : defStyle.CSS_CELL_RESTRICTED,
            /**
            * @property Style.CSS_CELL_TODAY
            */
            CSS_CELL_TODAY : defStyle.CSS_CELL_TODAY,
            /**
            * @property Style.CSS_CELL_OOM
            */
            CSS_CELL_OOM : defStyle.CSS_CELL_OOM,
            /**
            * @property Style.CSS_CELL_OOB
            */
            CSS_CELL_OOB : defStyle.CSS_CELL_OOB,
            /**
            * @property Style.CSS_HEADER
            */
            CSS_HEADER : defStyle.CSS_HEADER,
            /**
            * @property Style.CSS_HEADER_TEXT
            */
            CSS_HEADER_TEXT : defStyle.CSS_HEADER_TEXT,
            /**
            * @property Style.CSS_BODY
            */
            CSS_BODY : defStyle.CSS_BODY,
            /**
            * @property Style.CSS_WEEKDAY_CELL
            */
            CSS_WEEKDAY_CELL : defStyle.CSS_WEEKDAY_CELL,
            /**
            * @property Style.CSS_WEEKDAY_ROW
            */
            CSS_WEEKDAY_ROW : defStyle.CSS_WEEKDAY_ROW,
            /**
            * @property Style.CSS_FOOTER
            */
            CSS_FOOTER : defStyle.CSS_FOOTER,
            /**
            * @property Style.CSS_CALENDAR
            */
            CSS_CALENDAR : defStyle.CSS_CALENDAR,
            /**
            * @property Style.CSS_SINGLE
            */
            CSS_SINGLE : defStyle.CSS_SINGLE,
            /**
            * @property Style.CSS_CONTAINER
            */
            CSS_CONTAINER : defStyle.CSS_CONTAINER,
            /**
            * @property Style.CSS_NAV_LEFT
            */
            CSS_NAV_LEFT : defStyle.CSS_NAV_LEFT,
            /**
            * @property Style.CSS_NAV_RIGHT
            */
            CSS_NAV_RIGHT : defStyle.CSS_NAV_RIGHT,
            /**
            * @property Style.CSS_NAV
            */
            CSS_NAV : defStyle.CSS_NAV,
            /**
            * @property Style.CSS_CLOSE
            */
            CSS_CLOSE : defStyle.CSS_CLOSE,
            /**
            * @property Style.CSS_CELL_TOP
            */
            CSS_CELL_TOP : defStyle.CSS_CELL_TOP,
            /**
            * @property Style.CSS_CELL_LEFT
            */
            CSS_CELL_LEFT : defStyle.CSS_CELL_LEFT,
            /**
            * @property Style.CSS_CELL_RIGHT
            */
            CSS_CELL_RIGHT : defStyle.CSS_CELL_RIGHT,
            /**
            * @property Style.CSS_CELL_BOTTOM
            */
            CSS_CELL_BOTTOM : defStyle.CSS_CELL_BOTTOM,
            /**
            * @property Style.CSS_CELL_HOVER
            */
            CSS_CELL_HOVER : defStyle.CSS_CELL_HOVER,
            /**
            * @property Style.CSS_CELL_HIGHLIGHT1
            */
            CSS_CELL_HIGHLIGHT1 : defStyle.CSS_CELL_HIGHLIGHT1,
            /**
            * @property Style.CSS_CELL_HIGHLIGHT2
            */
            CSS_CELL_HIGHLIGHT2 : defStyle.CSS_CELL_HIGHLIGHT2,
            /**
            * @property Style.CSS_CELL_HIGHLIGHT3
            */
            CSS_CELL_HIGHLIGHT3 : defStyle.CSS_CELL_HIGHLIGHT3,
            /**
            * @property Style.CSS_CELL_HIGHLIGHT4
            */
            CSS_CELL_HIGHLIGHT4 : defStyle.CSS_CELL_HIGHLIGHT4,
            /**
             * @property Style.CSS_WITH_TITLE
             */
            CSS_WITH_TITLE : defStyle.CSS_WITH_TITLE,
             /**
             * @property Style.CSS_FIXED_SIZE
             */
            CSS_FIXED_SIZE : defStyle.CSS_FIXED_SIZE,
             /**
             * @property Style.CSS_LINK_CLOSE
             */
            CSS_LINK_CLOSE : defStyle.CSS_LINK_CLOSE
        };
    },

    /**
    * Builds the date label that will be displayed in the calendar header or
    * footer, depending on configuration.
    * @method buildMonthLabel
    * @return {HTML} The formatted calendar month label
    */
    buildMonthLabel : function() {
        return this._buildMonthLabel(this.cfg.getProperty(DEF_CFG.PAGEDATE.key));
    },

    /**
     * Helper method, to format a Month Year string, given a JavaScript Date, based on the 
     * Calendar localization settings
     * 
     * @method _buildMonthLabel
     * @private
     * @param {Date} date
     * @return {HTML} Formated month, year string
     */
    _buildMonthLabel : function(date) {
        var monthLabel  = this.Locale.LOCALE_MONTHS[date.getMonth()] + this.Locale.MY_LABEL_MONTH_SUFFIX,
            yearLabel = (date.getFullYear() + this.Locale.YEAR_OFFSET) + this.Locale.MY_LABEL_YEAR_SUFFIX;

        if (this.Locale.MY_LABEL_MONTH_POSITION == 2 || this.Locale.MY_LABEL_YEAR_POSITION == 1) {
            return yearLabel + monthLabel;
        } else {
            return monthLabel + yearLabel;
        }
    },

    /**
    * Builds the date digit that will be displayed in calendar cells
    * @method buildDayLabel
    * @param {Date} workingDate The current working date
    * @return {Number} The day
    */
    buildDayLabel : function(workingDate) {
        return workingDate.getDate();
    },

    /**
     * Creates the title bar element and adds it to Calendar container DIV. NOTE: The title parameter passed into this method is added to the DOM as HTML and should be escaped by the implementor if coming from an external source.  
     * 
     * @method createTitleBar
     * @param {HTML} strTitle The title to display in the title bar
     * @return The title bar element
     */
    createTitleBar : function(strTitle) {
        var tDiv = Dom.getElementsByClassName(YAHOO.widget.CalendarGroup.CSS_2UPTITLE, "div", this.oDomContainer)[0] || document.createElement("div");
        tDiv.className = YAHOO.widget.CalendarGroup.CSS_2UPTITLE;
        tDiv.innerHTML = strTitle;
        this.oDomContainer.insertBefore(tDiv, this.oDomContainer.firstChild);
    
        Dom.addClass(this.oDomContainer, this.Style.CSS_WITH_TITLE);
    
        return tDiv;
    },
    
    /**
     * Removes the title bar element from the DOM
     * 
     * @method removeTitleBar
     */
    removeTitleBar : function() {
        var tDiv = Dom.getElementsByClassName(YAHOO.widget.CalendarGroup.CSS_2UPTITLE, "div", this.oDomContainer)[0] || null;
        if (tDiv) {
            Event.purgeElement(tDiv);
            this.oDomContainer.removeChild(tDiv);
        }
        Dom.removeClass(this.oDomContainer, this.Style.CSS_WITH_TITLE);
    },

    /**
     * Creates the close button HTML element and adds it to Calendar container DIV
     * 
     * @method createCloseButton
     * @return {HTMLElement} The close HTML element created
     */
    createCloseButton : function() {
        var cssClose = YAHOO.widget.CalendarGroup.CSS_2UPCLOSE,
            cssLinkClose = this.Style.CSS_LINK_CLOSE,
            DEPR_CLOSE_PATH = "us/my/bn/x_d.gif",

            lnk = Dom.getElementsByClassName(cssLinkClose, "a", this.oDomContainer)[0],
            strings = this.cfg.getProperty(DEF_CFG.STRINGS.key),
            closeStr = (strings && strings.close) ? strings.close : "";

        if (!lnk) {
            lnk = document.createElement("a");
            Event.addListener(lnk, "click", function(e, cal) {
                cal.hide(); 
                Event.preventDefault(e);
            }, this);
        }

        lnk.href = "#";
        lnk.className = cssLinkClose;

        if (Calendar.IMG_ROOT !== null) {
            var img = Dom.getElementsByClassName(cssClose, "img", lnk)[0] || document.createElement("img");
            img.src = Calendar.IMG_ROOT + DEPR_CLOSE_PATH;
            img.className = cssClose;
            lnk.appendChild(img);
        } else {
            lnk.innerHTML = '<span class="' + cssClose + ' ' + this.Style.CSS_CLOSE + '">' + closeStr + '</span>';
        }
        this.oDomContainer.appendChild(lnk);

        return lnk;
    },
    
    /**
     * Removes the close button HTML element from the DOM
     * 
     * @method removeCloseButton
     */
    removeCloseButton : function() {
        var btn = Dom.getElementsByClassName(this.Style.CSS_LINK_CLOSE, "a", this.oDomContainer)[0] || null;
        if (btn) {
            Event.purgeElement(btn);
            this.oDomContainer.removeChild(btn);
        }
    },

    /**
    * Renders the calendar header. NOTE: The contents of the array passed into this method are added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.
    * @method renderHeader
    * @param {HTML[]} html The current working HTML array
    * @return {HTML[]} The current working HTML array
    */
    renderHeader : function(html) {


        var colSpan = 7,
            DEPR_NAV_LEFT = "us/tr/callt.gif",
            DEPR_NAV_RIGHT = "us/tr/calrt.gif",
            cfg = this.cfg,
            pageDate = cfg.getProperty(DEF_CFG.PAGEDATE.key),
            strings= cfg.getProperty(DEF_CFG.STRINGS.key),
            prevStr = (strings && strings.previousMonth) ?  strings.previousMonth : "",
            nextStr = (strings && strings.nextMonth) ? strings.nextMonth : "",
            monthLabel;

        if (cfg.getProperty(DEF_CFG.SHOW_WEEK_HEADER.key)) {
            colSpan += 1;
        }
    
        if (cfg.getProperty(DEF_CFG.SHOW_WEEK_FOOTER.key)) {
            colSpan += 1;
        }

        html[html.length] = "<thead>";
        html[html.length] =  "<tr>";
        html[html.length] =   '<th colspan="' + colSpan + '" class="' + this.Style.CSS_HEADER_TEXT + '">';
        html[html.length] =    '<div class="' + this.Style.CSS_HEADER + '">';

        var renderLeft, renderRight = false;

        if (this.parent) {
            if (this.index === 0) {
                renderLeft = true;
            }
            if (this.index == (this.parent.cfg.getProperty("pages") -1)) {
                renderRight = true;
            }
        } else {
            renderLeft = true;
            renderRight = true;
        }

        if (renderLeft) {
            monthLabel  = this._buildMonthLabel(DateMath.subtract(pageDate, DateMath.MONTH, 1));

            var leftArrow = cfg.getProperty(DEF_CFG.NAV_ARROW_LEFT.key);
            // Check for deprecated customization - If someone set IMG_ROOT, but didn't set NAV_ARROW_LEFT, then set NAV_ARROW_LEFT to the old deprecated value
            if (leftArrow === null && Calendar.IMG_ROOT !== null) {
                leftArrow = Calendar.IMG_ROOT + DEPR_NAV_LEFT;
            }
            var leftStyle = (leftArrow === null) ? "" : ' style="background-image:url(' + leftArrow + ')"';
            html[html.length] = '<a class="' + this.Style.CSS_NAV_LEFT + '"' + leftStyle + ' href="#">' + prevStr + ' (' + monthLabel + ')' + '</a>';
        }

        var lbl = this.buildMonthLabel();
        var cal = this.parent || this;
        if (cal.cfg.getProperty("navigator")) {
            lbl = "<a class=\"" + this.Style.CSS_NAV + "\" href=\"#\">" + lbl + "</a>";
        }
        html[html.length] = lbl;

        if (renderRight) {
            monthLabel  = this._buildMonthLabel(DateMath.add(pageDate, DateMath.MONTH, 1));

            var rightArrow = cfg.getProperty(DEF_CFG.NAV_ARROW_RIGHT.key);
            if (rightArrow === null && Calendar.IMG_ROOT !== null) {
                rightArrow = Calendar.IMG_ROOT + DEPR_NAV_RIGHT;
            }
            var rightStyle = (rightArrow === null) ? "" : ' style="background-image:url(' + rightArrow + ')"';
            html[html.length] = '<a class="' + this.Style.CSS_NAV_RIGHT + '"' + rightStyle + ' href="#">' + nextStr + ' (' + monthLabel + ')' + '</a>';
        }

        html[html.length] = '</div>\n</th>\n</tr>';

        if (cfg.getProperty(DEF_CFG.SHOW_WEEKDAYS.key)) {
            html = this.buildWeekdays(html);
        }
        
        html[html.length] = '</thead>';
    
        return html;
    },

    /**
    * Renders the Calendar's weekday headers. NOTE: The contents of the array passed into this method are added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.
    * @method buildWeekdays
    * @param {HTML[]} html The current working HTML array
    * @return {HTML[]} The current working HTML array
    */
    buildWeekdays : function(html) {

        html[html.length] = '<tr class="' + this.Style.CSS_WEEKDAY_ROW + '">';

        if (this.cfg.getProperty(DEF_CFG.SHOW_WEEK_HEADER.key)) {
            html[html.length] = '<th>&#160;</th>';
        }

        for(var i=0;i < this.Locale.LOCALE_WEEKDAYS.length; ++i) {
            html[html.length] = '<th class="' + this.Style.CSS_WEEKDAY_CELL + '">' + this.Locale.LOCALE_WEEKDAYS[i] + '</th>';
        }

        if (this.cfg.getProperty(DEF_CFG.SHOW_WEEK_FOOTER.key)) {
            html[html.length] = '<th>&#160;</th>';
        }

        html[html.length] = '</tr>';

        return html;
    },
    
    /**
    * Renders the calendar body. NOTE: The contents of the array passed into this method are added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.
    * @method renderBody
    * @param {Date} workingDate The current working Date being used for the render process
    * @param {HTML[]} html The current working HTML array
    * @return {HTML[]} The current working HTML array
    */
    renderBody : function(workingDate, html) {

        var startDay = this.cfg.getProperty(DEF_CFG.START_WEEKDAY.key);

        this.preMonthDays = workingDate.getDay();
        if (startDay > 0) {
            this.preMonthDays -= startDay;
        }
        if (this.preMonthDays < 0) {
            this.preMonthDays += 7;
        }

        this.monthDays = DateMath.findMonthEnd(workingDate).getDate();
        this.postMonthDays = Calendar.DISPLAY_DAYS-this.preMonthDays-this.monthDays;


        workingDate = DateMath.subtract(workingDate, DateMath.DAY, this.preMonthDays);
    
        var weekNum,
            weekClass,
            weekPrefix = "w",
            cellPrefix = "_cell",
            workingDayPrefix = "wd",
            dayPrefix = "d",
            cellRenderers,
            renderer,
            t = this.today,
            cfg = this.cfg,
            oom,
            todayYear = t.getFullYear(),
            todayMonth = t.getMonth(),
            todayDate = t.getDate(),
            useDate = cfg.getProperty(DEF_CFG.PAGEDATE.key),
            hideBlankWeeks = cfg.getProperty(DEF_CFG.HIDE_BLANK_WEEKS.key),
            showWeekFooter = cfg.getProperty(DEF_CFG.SHOW_WEEK_FOOTER.key),
            showWeekHeader = cfg.getProperty(DEF_CFG.SHOW_WEEK_HEADER.key),
            oomSelect = cfg.getProperty(DEF_CFG.OOM_SELECT.key),
            mindate = cfg.getProperty(DEF_CFG.MINDATE.key),
            maxdate = cfg.getProperty(DEF_CFG.MAXDATE.key),
            yearOffset = this.Locale.YEAR_OFFSET;

        if (mindate) {
            mindate = DateMath.clearTime(mindate);
        }
        if (maxdate) {
            maxdate = DateMath.clearTime(maxdate);
        }

        html[html.length] = '<tbody class="m' + (useDate.getMonth()+1) + ' ' + this.Style.CSS_BODY + '">';

        var i = 0,
            tempDiv = document.createElement("div"),
            cell = document.createElement("td");

        tempDiv.appendChild(cell);

        var cal = this.parent || this;

        for (var r = 0; r < 6; r++) {
            weekNum = DateMath.getWeekNumber(workingDate, startDay);
            weekClass = weekPrefix + weekNum;

            // Local OOM check for performance, since we already have pagedate
            if (r !== 0 && hideBlankWeeks === true && workingDate.getMonth() != useDate.getMonth()) {
                break;
            } else {
                html[html.length] = '<tr class="' + weekClass + '">';

                if (showWeekHeader) { html = this.renderRowHeader(weekNum, html); }

                for (var d=0; d < 7; d++){ // Render actual days

                    cellRenderers = [];

                    this.clearElement(cell);
                    cell.className = this.Style.CSS_CELL;
                    cell.id = this.id + cellPrefix + i;

                    if (workingDate.getDate()  == todayDate && 
                        workingDate.getMonth()  == todayMonth &&
                        workingDate.getFullYear() == todayYear) {
                        cellRenderers[cellRenderers.length]=cal.renderCellStyleToday;
                    }

                    var workingArray = [workingDate.getFullYear(),workingDate.getMonth()+1,workingDate.getDate()];
                    this.cellDates[this.cellDates.length] = workingArray; // Add this date to cellDates

                    // Local OOM check for performance, since we already have pagedate
                    oom = workingDate.getMonth() != useDate.getMonth(); 
                    if (oom && !oomSelect) {
                        cellRenderers[cellRenderers.length]=cal.renderCellNotThisMonth;
                    } else {
                        Dom.addClass(cell, workingDayPrefix + workingDate.getDay());
                        Dom.addClass(cell, dayPrefix + workingDate.getDate());

                        // Concat, so that we're not splicing from an array 
                        // which we're also iterating
                        var rs = this.renderStack.concat();

                        for (var s=0, l = rs.length; s < l; ++s) {

                            renderer = null;

                            var rArray = rs[s],
                                type = rArray[0],
                                month,
                                day,
                                year;

                            switch (type) {
                                case Calendar.DATE:
                                    month = rArray[1][1];
                                    day = rArray[1][2];
                                    year = rArray[1][0];

                                    if (workingDate.getMonth()+1 == month && workingDate.getDate() == day && workingDate.getFullYear() == year) {
                                        renderer = rArray[2];
                                        this.renderStack.splice(s,1);
                                    }

                                    break;
                                case Calendar.MONTH_DAY:
                                    month = rArray[1][0];
                                    day = rArray[1][1];

                                    if (workingDate.getMonth()+1 == month && workingDate.getDate() == day) {
                                        renderer = rArray[2];
                                        this.renderStack.splice(s,1);
                                    }
                                    break;
                                case Calendar.RANGE:
                                    var date1 = rArray[1][0],
                                        date2 = rArray[1][1],
                                        d1month = date1[1],
                                        d1day = date1[2],
                                        d1year = date1[0],
                                        d1 = DateMath.getDate(d1year, d1month-1, d1day),
                                        d2month = date2[1],
                                        d2day = date2[2],
                                        d2year = date2[0],
                                        d2 = DateMath.getDate(d2year, d2month-1, d2day);

                                    if (workingDate.getTime() >= d1.getTime() && workingDate.getTime() <= d2.getTime()) {
                                        renderer = rArray[2];

                                        if (workingDate.getTime()==d2.getTime()) { 
                                            this.renderStack.splice(s,1);
                                        }
                                    }
                                    break;
                                case Calendar.WEEKDAY:
                                    var weekday = rArray[1][0];
                                    if (workingDate.getDay()+1 == weekday) {
                                        renderer = rArray[2];
                                    }
                                    break;
                                case Calendar.MONTH:
                                    month = rArray[1][0];
                                    if (workingDate.getMonth()+1 == month) {
                                        renderer = rArray[2];
                                    }
                                    break;
                            }

                            if (renderer) {
                                cellRenderers[cellRenderers.length]=renderer;
                            }
                        }

                    }

                    if (this._indexOfSelectedFieldArray(workingArray) > -1) {
                        cellRenderers[cellRenderers.length]=cal.renderCellStyleSelected; 
                    }

                    if (oom) {
                        cellRenderers[cellRenderers.length] = cal.styleCellNotThisMonth; 
                    }

                    if ((mindate && (workingDate.getTime() < mindate.getTime())) || (maxdate && (workingDate.getTime() > maxdate.getTime()))) {
                        cellRenderers[cellRenderers.length] = cal.renderOutOfBoundsDate;
                    } else {
                        cellRenderers[cellRenderers.length] = cal.styleCellDefault;
                        cellRenderers[cellRenderers.length] = cal.renderCellDefault;
                    }

                    for (var x=0; x < cellRenderers.length; ++x) {
                        if (cellRenderers[x].call(cal, workingDate, cell) == Calendar.STOP_RENDER) {
                            break;
                        }
                    }

                    workingDate.setTime(workingDate.getTime() + DateMath.ONE_DAY_MS);
                    // Just in case we crossed DST/Summertime boundaries
                    workingDate = DateMath.clearTime(workingDate);

                    if (i >= 0 && i <= 6) {
                        Dom.addClass(cell, this.Style.CSS_CELL_TOP);
                    }
                    if ((i % 7) === 0) {
                        Dom.addClass(cell, this.Style.CSS_CELL_LEFT);
                    }
                    if (((i+1) % 7) === 0) {
                        Dom.addClass(cell, this.Style.CSS_CELL_RIGHT);
                    }

                    var postDays = this.postMonthDays; 
                    if (hideBlankWeeks && postDays >= 7) {
                        var blankWeeks = Math.floor(postDays/7);
                        for (var p=0;p<blankWeeks;++p) {
                            postDays -= 7;
                        }
                    }
                    
                    if (i >= ((this.preMonthDays+postDays+this.monthDays)-7)) {
                        Dom.addClass(cell, this.Style.CSS_CELL_BOTTOM);
                    }
    
                    html[html.length] = tempDiv.innerHTML;
                    i++;
                }
    
                if (showWeekFooter) { html = this.renderRowFooter(weekNum, html); }
    
                html[html.length] = '</tr>';
            }
        }
    
        html[html.length] = '</tbody>';
    
        return html;
    },
    
    /**
    * Renders the calendar footer. In the default implementation, there is no footer. NOTE: The contents of the array passed into this method are added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.
    * @method renderFooter
    * @param {HTML[]} html The current working HTML array
    * @return {HTML[]} The current working HTML array
    */
    renderFooter : function(html) { return html; },
    
    /**
    * Renders the calendar after it has been configured. The render() method has a specific call chain that will execute
    * when the method is called: renderHeader, renderBody, renderFooter.
    * Refer to the documentation for those methods for information on individual render tasks.
    * @method render
    */
    render : function() {
        this.beforeRenderEvent.fire();

        // Find starting day of the current month
        var workingDate = DateMath.findMonthStart(this.cfg.getProperty(DEF_CFG.PAGEDATE.key));

        this.resetRenderers();
        this.cellDates.length = 0;

        Event.purgeElement(this.oDomContainer, true);

        var html = [], 
            table;

        html[html.length] = '<table cellSpacing="0" class="' + this.Style.CSS_CALENDAR + ' y' + (workingDate.getFullYear() + this.Locale.YEAR_OFFSET) +'" id="' + this.id + '">';
        html = this.renderHeader(html);
        html = this.renderBody(workingDate, html);
        html = this.renderFooter(html);
        html[html.length] = '</table>';

        this.oDomContainer.innerHTML = html.join("\n");

        this.applyListeners();

        // Using oDomContainer.ownerDocument, to allow for cross-frame rendering
        table = ((this._oDoc) && this._oDoc.getElementById(this.id)) || (this.id);

        this.cells = Dom.getElementsByClassName(this.Style.CSS_CELL, "td", table);

        this.cfg.refireEvent(DEF_CFG.TITLE.key);
        this.cfg.refireEvent(DEF_CFG.CLOSE.key);
        this.cfg.refireEvent(DEF_CFG.IFRAME.key);

        this.renderEvent.fire();
    },

    /**
    * Applies the Calendar's DOM listeners to applicable elements.
    * @method applyListeners
    */
    applyListeners : function() {
        var root = this.oDomContainer,
            cal = this.parent || this,
            anchor = "a",
            click = "click";

        var linkLeft = Dom.getElementsByClassName(this.Style.CSS_NAV_LEFT, anchor, root),
            linkRight = Dom.getElementsByClassName(this.Style.CSS_NAV_RIGHT, anchor, root);

        if (linkLeft && linkLeft.length > 0) {
            this.linkLeft = linkLeft[0];
            Event.addListener(this.linkLeft, click, this.doPreviousMonthNav, cal, true);
        }

        if (linkRight && linkRight.length > 0) {
            this.linkRight = linkRight[0];
            Event.addListener(this.linkRight, click, this.doNextMonthNav, cal, true);
        }

        if (cal.cfg.getProperty("navigator") !== null) {
            this.applyNavListeners();
        }

        if (this.domEventMap) {
            var el,elements;
            for (var cls in this.domEventMap) { 
                if (Lang.hasOwnProperty(this.domEventMap, cls)) {
                    var items = this.domEventMap[cls];
    
                    if (! (items instanceof Array)) {
                        items = [items];
                    }
    
                    for (var i=0;i<items.length;i++) {
                        var item = items[i];
                        elements = Dom.getElementsByClassName(cls, item.tag, this.oDomContainer);
    
                        for (var c=0;c<elements.length;c++) {
                            el = elements[c];
                             Event.addListener(el, item.event, item.handler, item.scope, item.correct );
                        }
                    }
                }
            }
        }

        Event.addListener(this.oDomContainer, "click", this.doSelectCell, this);
        Event.addListener(this.oDomContainer, "mouseover", this.doCellMouseOver, this);
        Event.addListener(this.oDomContainer, "mouseout", this.doCellMouseOut, this);
    },

    /**
    * Applies the DOM listeners to activate the Calendar Navigator.
    * @method applyNavListeners
    */
    applyNavListeners : function() {
        var calParent = this.parent || this,
            cal = this,
            navBtns = Dom.getElementsByClassName(this.Style.CSS_NAV, "a", this.oDomContainer);

        if (navBtns.length > 0) {

            Event.addListener(navBtns, "click", function (e, obj) {
                var target = Event.getTarget(e);
                // this == navBtn
                if (this === target || Dom.isAncestor(this, target)) {
                    Event.preventDefault(e);
                }
                var navigator = calParent.oNavigator;
                if (navigator) {
                    var pgdate = cal.cfg.getProperty("pagedate");
                    navigator.setYear(pgdate.getFullYear() + cal.Locale.YEAR_OFFSET);
                    navigator.setMonth(pgdate.getMonth());
                    navigator.show();
                }
            });
        }
    },

    /**
    * Retrieves the Date object for the specified Calendar cell
    * @method getDateByCellId
    * @param {String} id The id of the cell
    * @return {Date} The Date object for the specified Calendar cell
    */
    getDateByCellId : function(id) {
        var date = this.getDateFieldsByCellId(id);
        return (date) ? DateMath.getDate(date[0],date[1]-1,date[2]) : null;
    },
    
    /**
    * Retrieves the Date object for the specified Calendar cell
    * @method getDateFieldsByCellId
    * @param {String} id The id of the cell
    * @return {Array} The array of Date fields for the specified Calendar cell
    */
    getDateFieldsByCellId : function(id) {
        id = this.getIndexFromId(id);
        return (id > -1) ? this.cellDates[id] : null;
    },

    /**
     * Find the Calendar's cell index for a given date.
     * If the date is not found, the method returns -1.
     * <p>
     * The returned index can be used to lookup the cell HTMLElement  
     * using the Calendar's cells array or passed to selectCell to select 
     * cells by index. 
     * </p>
     *
     * See <a href="#cells">cells</a>, <a href="#selectCell">selectCell</a>.
     *
     * @method getCellIndex
     * @param {Date} date JavaScript Date object, for which to find a cell index.
     * @return {Number} The index of the date in Calendars cellDates/cells arrays, or -1 if the date 
     * is not on the curently rendered Calendar page.
     */
    getCellIndex : function(date) {
        var idx = -1;
        if (date) {
            var m = date.getMonth(),
                y = date.getFullYear(),
                d = date.getDate(),
                dates = this.cellDates;

            for (var i = 0; i < dates.length; ++i) {
                var cellDate = dates[i];
                if (cellDate[0] === y && cellDate[1] === m+1 && cellDate[2] === d) {
                    idx = i;
                    break;
                }
            }
        }
        return idx;
    },

    /**
     * Given the id used to mark each Calendar cell, this method
     * extracts the index number from the id.
     * 
     * @param {String} strId The cell id
     * @return {Number} The index of the cell, or -1 if id does not contain an index number
     */
    getIndexFromId : function(strId) {
        var idx = -1,
            li = strId.lastIndexOf("_cell");

        if (li > -1) {
            idx = parseInt(strId.substring(li + 5), 10);
        }

        return idx;
    },
    
    // BEGIN BUILT-IN TABLE CELL RENDERERS
    
    /**
    * Renders a cell that falls before the minimum date or after the maximum date.
    * @method renderOutOfBoundsDate
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    * @return {String} YAHOO.widget.Calendar.STOP_RENDER if rendering should stop with this style, null or nothing if rendering
    *   should not be terminated
    */
    renderOutOfBoundsDate : function(workingDate, cell) {
        Dom.addClass(cell, this.Style.CSS_CELL_OOB);
        cell.innerHTML = workingDate.getDate();
        return Calendar.STOP_RENDER;
    },

    /**
    * Renders the row header HTML for a week.
    *
    * @method renderRowHeader
    * @param {Number} weekNum The week number of the current row
    * @param {HTML[]} cell The current working HTML array
    */
    renderRowHeader : function(weekNum, html) {
        html[html.length] = '<th class="' + this.Style.CSS_ROW_HEADER + '">' + weekNum + '</th>';
        return html;
    },

    /**
    * Renders the row footer HTML for a week.
    *
    * @method renderRowFooter
    * @param {Number} weekNum The week number of the current row
    * @param {HTML[]} cell The current working HTML array
    */
    renderRowFooter : function(weekNum, html) {
        html[html.length] = '<th class="' + this.Style.CSS_ROW_FOOTER + '">' + weekNum + '</th>';
        return html;
    },

    /**
    * Renders a single standard calendar cell in the calendar widget table.
    *
    * All logic for determining how a standard default cell will be rendered is 
    * encapsulated in this method, and must be accounted for when extending the
    * widget class.
    *
    * @method renderCellDefault
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    */
    renderCellDefault : function(workingDate, cell) {
        cell.innerHTML = '<a href="#" class="' + this.Style.CSS_CELL_SELECTOR + '">' + this.buildDayLabel(workingDate) + "</a>";
    },
    
    /**
    * Styles a selectable cell.
    * @method styleCellDefault
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    */
    styleCellDefault : function(workingDate, cell) {
        Dom.addClass(cell, this.Style.CSS_CELL_SELECTABLE);
    },
    
    
    /**
    * Renders a single standard calendar cell using the CSS hightlight1 style
    * @method renderCellStyleHighlight1
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    */
    renderCellStyleHighlight1 : function(workingDate, cell) {
        Dom.addClass(cell, this.Style.CSS_CELL_HIGHLIGHT1);
    },
    
    /**
    * Renders a single standard calendar cell using the CSS hightlight2 style
    * @method renderCellStyleHighlight2
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    */
    renderCellStyleHighlight2 : function(workingDate, cell) {
        Dom.addClass(cell, this.Style.CSS_CELL_HIGHLIGHT2);
    },
    
    /**
    * Renders a single standard calendar cell using the CSS hightlight3 style
    * @method renderCellStyleHighlight3
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    */
    renderCellStyleHighlight3 : function(workingDate, cell) {
        Dom.addClass(cell, this.Style.CSS_CELL_HIGHLIGHT3);
    },
    
    /**
    * Renders a single standard calendar cell using the CSS hightlight4 style
    * @method renderCellStyleHighlight4
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    */
    renderCellStyleHighlight4 : function(workingDate, cell) {
        Dom.addClass(cell, this.Style.CSS_CELL_HIGHLIGHT4);
    },
    
    /**
    * Applies the default style used for rendering today's date to the current calendar cell
    * @method renderCellStyleToday
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    */
    renderCellStyleToday : function(workingDate, cell) {
        Dom.addClass(cell, this.Style.CSS_CELL_TODAY);
    },

    /**
    * Applies the default style used for rendering selected dates to the current calendar cell
    * @method renderCellStyleSelected
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    * @return {String} YAHOO.widget.Calendar.STOP_RENDER if rendering should stop with this style, null or nothing if rendering
    *   should not be terminated
    */
    renderCellStyleSelected : function(workingDate, cell) {
        Dom.addClass(cell, this.Style.CSS_CELL_SELECTED);
    },

    /**
    * Applies the default style used for rendering dates that are not a part of the current
    * month (preceding or trailing the cells for the current month)
    *
    * @method renderCellNotThisMonth
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    * @return {String} YAHOO.widget.Calendar.STOP_RENDER if rendering should stop with this style, null or nothing if rendering
    *   should not be terminated
    */
    renderCellNotThisMonth : function(workingDate, cell) {
        this.styleCellNotThisMonth(workingDate, cell);
        cell.innerHTML=workingDate.getDate();
        return Calendar.STOP_RENDER;
    },

    /** Applies the style used for rendering out-of-month dates to the current calendar cell
    * @method styleCellNotThisMonth
    * @param {Date}                 workingDate     The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell            The current working cell in the calendar
    */
    styleCellNotThisMonth : function(workingDate, cell) {
        YAHOO.util.Dom.addClass(cell, this.Style.CSS_CELL_OOM);
    },

    /**
    * Renders the current calendar cell as a non-selectable "black-out" date using the default
    * restricted style.
    * @method renderBodyCellRestricted
    * @param {Date}     workingDate  The current working Date object being used to generate the calendar
    * @param {HTMLTableCellElement} cell   The current working cell in the calendar
    * @return {String} YAHOO.widget.Calendar.STOP_RENDER if rendering should stop with this style, null or nothing if rendering
    *   should not be terminated
    */
    renderBodyCellRestricted : function(workingDate, cell) {
        Dom.addClass(cell, this.Style.CSS_CELL);
        Dom.addClass(cell, this.Style.CSS_CELL_RESTRICTED);
        cell.innerHTML=workingDate.getDate();
        return Calendar.STOP_RENDER;
    },
    
    // END BUILT-IN TABLE CELL RENDERERS
    
    // BEGIN MONTH NAVIGATION METHODS

    /**
    * Adds the designated number of months to the current calendar month, and sets the current
    * calendar page date to the new month.
    * @method addMonths
    * @param {Number} count The number of months to add to the current calendar
    */
    addMonths : function(count) {
        var cfgPageDate = DEF_CFG.PAGEDATE.key,

        prevDate = this.cfg.getProperty(cfgPageDate),
        newDate = DateMath.add(prevDate, DateMath.MONTH, count);

        this.cfg.setProperty(cfgPageDate, newDate);
        this.resetRenderers();
        this.changePageEvent.fire(prevDate, newDate);
    },

    /**
    * Subtracts the designated number of months from the current calendar month, and sets the current
    * calendar page date to the new month.
    * @method subtractMonths
    * @param {Number} count The number of months to subtract from the current calendar
    */
    subtractMonths : function(count) {
        this.addMonths(-1*count);
    },

    /**
    * Adds the designated number of years to the current calendar, and sets the current
    * calendar page date to the new month.
    * @method addYears
    * @param {Number} count The number of years to add to the current calendar
    */
    addYears : function(count) {
        var cfgPageDate = DEF_CFG.PAGEDATE.key,

        prevDate = this.cfg.getProperty(cfgPageDate),
        newDate = DateMath.add(prevDate, DateMath.YEAR, count);

        this.cfg.setProperty(cfgPageDate, newDate);
        this.resetRenderers();
        this.changePageEvent.fire(prevDate, newDate);
    },

    /**
    * Subtcats the designated number of years from the current calendar, and sets the current
    * calendar page date to the new month.
    * @method subtractYears
    * @param {Number} count The number of years to subtract from the current calendar
    */
    subtractYears : function(count) {
        this.addYears(-1*count);
    },

    /**
    * Navigates to the next month page in the calendar widget.
    * @method nextMonth
    */
    nextMonth : function() {
        this.addMonths(1);
    },
    
    /**
    * Navigates to the previous month page in the calendar widget.
    * @method previousMonth
    */
    previousMonth : function() {
        this.addMonths(-1);
    },
    
    /**
    * Navigates to the next year in the currently selected month in the calendar widget.
    * @method nextYear
    */
    nextYear : function() {
        this.addYears(1);
    },
    
    /**
    * Navigates to the previous year in the currently selected month in the calendar widget.
    * @method previousYear
    */
    previousYear : function() {
        this.addYears(-1);
    },

    // END MONTH NAVIGATION METHODS
    
    // BEGIN SELECTION METHODS
    
    /**
    * Resets the calendar widget to the originally selected month and year, and 
    * sets the calendar to the initial selection(s).
    * @method reset
    */
    reset : function() {
        this.cfg.resetProperty(DEF_CFG.SELECTED.key);
        this.cfg.resetProperty(DEF_CFG.PAGEDATE.key);
        this.resetEvent.fire();
    },
    
    /**
    * Clears the selected dates in the current calendar widget and sets the calendar
    * to the current month and year.
    * @method clear
    */
    clear : function() {
        this.cfg.setProperty(DEF_CFG.SELECTED.key, []);
        this.cfg.setProperty(DEF_CFG.PAGEDATE.key, new Date(this.today.getTime()));
        this.clearEvent.fire();
    },
    
    /**
    * Selects a date or a collection of dates on the current calendar. This method, by default,
    * does not call the render method explicitly. Once selection has completed, render must be 
    * called for the changes to be reflected visually.
    *
    * Any dates which are OOB (out of bounds, not selectable) will not be selected and the array of 
    * selected dates passed to the selectEvent will not contain OOB dates.
    * 
    * If all dates are OOB, the no state change will occur; beforeSelect and select events will not be fired.
    *
    * @method select
    * @param {String/Date/Date[]} date The date string of dates to select in the current calendar. Valid formats are
    *        individual date(s) (12/24/2005,12/26/2005) or date range(s) (12/24/2005-1/1/2006).
    *        Multiple comma-delimited dates can also be passed to this method (12/24/2005,12/11/2005-12/13/2005).
    *        This method can also take a JavaScript Date object or an array of Date objects.
    * @return {Date[]}   Array of JavaScript Date objects representing all individual dates that are currently selected.
    */
    select : function(date) {

        var aToBeSelected = this._toFieldArray(date),
            validDates = [],
            selected = [],
            cfgSelected = DEF_CFG.SELECTED.key;

        
        for (var a=0; a < aToBeSelected.length; ++a) {
            var toSelect = aToBeSelected[a];

            if (!this.isDateOOB(this._toDate(toSelect))) {

                if (validDates.length === 0) {
                    this.beforeSelectEvent.fire();
                    selected = this.cfg.getProperty(cfgSelected);
                }
                validDates.push(toSelect);

                if (this._indexOfSelectedFieldArray(toSelect) == -1) { 
                    selected[selected.length] = toSelect;
                }
            }
        }


        if (validDates.length > 0) {
            if (this.parent) {
                this.parent.cfg.setProperty(cfgSelected, selected);
            } else {
                this.cfg.setProperty(cfgSelected, selected);
            }
            this.selectEvent.fire(validDates);
        }

        return this.getSelectedDates();
    },
    
    /**
    * Selects a date on the current calendar by referencing the index of the cell that should be selected.
    * This method is used to easily select a single cell (usually with a mouse click) without having to do
    * a full render. The selected style is applied to the cell directly.
    *
    * If the cell is not marked with the CSS_CELL_SELECTABLE class (as is the case by default for out of month 
    * or out of bounds cells), it will not be selected and in such a case beforeSelect and select events will not be fired.
    * 
    * @method selectCell
    * @param {Number} cellIndex The index of the cell to select in the current calendar. 
    * @return {Date[]} Array of JavaScript Date objects representing all individual dates that are currently selected.
    */
    selectCell : function(cellIndex) {

        var cell = this.cells[cellIndex],
            cellDate = this.cellDates[cellIndex],
            dCellDate = this._toDate(cellDate),
            selectable = Dom.hasClass(cell, this.Style.CSS_CELL_SELECTABLE);


        if (selectable) {
    
            this.beforeSelectEvent.fire();
    
            var cfgSelected = DEF_CFG.SELECTED.key;
            var selected = this.cfg.getProperty(cfgSelected);
    
            var selectDate = cellDate.concat();
    
            if (this._indexOfSelectedFieldArray(selectDate) == -1) {
                selected[selected.length] = selectDate;
            }
            if (this.parent) {
                this.parent.cfg.setProperty(cfgSelected, selected);
            } else {
                this.cfg.setProperty(cfgSelected, selected);
            }
            this.renderCellStyleSelected(dCellDate,cell);
            this.selectEvent.fire([selectDate]);
    
            this.doCellMouseOut.call(cell, null, this);  
        }
    
        return this.getSelectedDates();
    },
    
    /**
    * Deselects a date or a collection of dates on the current calendar. This method, by default,
    * does not call the render method explicitly. Once deselection has completed, render must be 
    * called for the changes to be reflected visually.
    * 
    * The method will not attempt to deselect any dates which are OOB (out of bounds, and hence not selectable) 
    * and the array of deselected dates passed to the deselectEvent will not contain any OOB dates.
    * 
    * If all dates are OOB, beforeDeselect and deselect events will not be fired.
    * 
    * @method deselect
    * @param {String/Date/Date[]} date The date string of dates to deselect in the current calendar. Valid formats are
    *        individual date(s) (12/24/2005,12/26/2005) or date range(s) (12/24/2005-1/1/2006).
    *        Multiple comma-delimited dates can also be passed to this method (12/24/2005,12/11/2005-12/13/2005).
    *        This method can also take a JavaScript Date object or an array of Date objects. 
    * @return {Date[]}   Array of JavaScript Date objects representing all individual dates that are currently selected.
    */
    deselect : function(date) {

        var aToBeDeselected = this._toFieldArray(date),
            validDates = [],
            selected = [],
            cfgSelected = DEF_CFG.SELECTED.key;


        for (var a=0; a < aToBeDeselected.length; ++a) {
            var toDeselect = aToBeDeselected[a];
    
            if (!this.isDateOOB(this._toDate(toDeselect))) {
    
                if (validDates.length === 0) {
                    this.beforeDeselectEvent.fire();
                    selected = this.cfg.getProperty(cfgSelected);
                }
    
                validDates.push(toDeselect);
    
                var index = this._indexOfSelectedFieldArray(toDeselect);
                if (index != -1) { 
                    selected.splice(index,1);
                }
            }
        }
    
    
        if (validDates.length > 0) {
            if (this.parent) {
                this.parent.cfg.setProperty(cfgSelected, selected);
            } else {
                this.cfg.setProperty(cfgSelected, selected);
            }
            this.deselectEvent.fire(validDates);
        }
    
        return this.getSelectedDates();
    },
    
    /**
    * Deselects a date on the current calendar by referencing the index of the cell that should be deselected.
    * This method is used to easily deselect a single cell (usually with a mouse click) without having to do
    * a full render. The selected style is removed from the cell directly.
    * 
    * If the cell is not marked with the CSS_CELL_SELECTABLE class (as is the case by default for out of month 
    * or out of bounds cells), the method will not attempt to deselect it and in such a case, beforeDeselect and 
    * deselect events will not be fired.
    * 
    * @method deselectCell
    * @param {Number} cellIndex The index of the cell to deselect in the current calendar. 
    * @return {Date[]} Array of JavaScript Date objects representing all individual dates that are currently selected.
    */
    deselectCell : function(cellIndex) {
        var cell = this.cells[cellIndex],
            cellDate = this.cellDates[cellIndex],
            cellDateIndex = this._indexOfSelectedFieldArray(cellDate);

        var selectable = Dom.hasClass(cell, this.Style.CSS_CELL_SELECTABLE);

        if (selectable) {

            this.beforeDeselectEvent.fire();

            var selected = this.cfg.getProperty(DEF_CFG.SELECTED.key),
                dCellDate = this._toDate(cellDate),
                selectDate = cellDate.concat();

            if (cellDateIndex > -1) {
                if ((this.cfg.getProperty(DEF_CFG.PAGEDATE.key).getMonth() == dCellDate.getMonth() &&
                    this.cfg.getProperty(DEF_CFG.PAGEDATE.key).getFullYear() == dCellDate.getFullYear()) || this.cfg.getProperty(DEF_CFG.OOM_SELECT.key)) {
                    Dom.removeClass(cell, this.Style.CSS_CELL_SELECTED);
                }
                selected.splice(cellDateIndex, 1);
            }

            if (this.parent) {
                this.parent.cfg.setProperty(DEF_CFG.SELECTED.key, selected);
            } else {
                this.cfg.setProperty(DEF_CFG.SELECTED.key, selected);
            }

            this.deselectEvent.fire([selectDate]);
        }

        return this.getSelectedDates();
    },

    /**
    * Deselects all dates on the current calendar.
    * @method deselectAll
    * @return {Date[]}  Array of JavaScript Date objects representing all individual dates that are currently selected.
    *      Assuming that this function executes properly, the return value should be an empty array.
    *      However, the empty array is returned for the sake of being able to check the selection status
    *      of the calendar.
    */
    deselectAll : function() {
        this.beforeDeselectEvent.fire();
        
        var cfgSelected = DEF_CFG.SELECTED.key,
            selected = this.cfg.getProperty(cfgSelected),
            count = selected.length,
            sel = selected.concat();

        if (this.parent) {
            this.parent.cfg.setProperty(cfgSelected, []);
        } else {
            this.cfg.setProperty(cfgSelected, []);
        }
        
        if (count > 0) {
            this.deselectEvent.fire(sel);
        }
    
        return this.getSelectedDates();
    },
    
    // END SELECTION METHODS
    
    // BEGIN TYPE CONVERSION METHODS
    
    /**
    * Converts a date (either a JavaScript Date object, or a date string) to the internal data structure
    * used to represent dates: [[yyyy,mm,dd],[yyyy,mm,dd]].
    * @method _toFieldArray
    * @private
    * @param {String/Date/Date[]} date The date string of dates to deselect in the current calendar. Valid formats are
    *        individual date(s) (12/24/2005,12/26/2005) or date range(s) (12/24/2005-1/1/2006).
    *        Multiple comma-delimited dates can also be passed to this method (12/24/2005,12/11/2005-12/13/2005).
    *        This method can also take a JavaScript Date object or an array of Date objects. 
    * @return {Array[](Number[])} Array of date field arrays
    */
    _toFieldArray : function(date) {
        var returnDate = [];
    
        if (date instanceof Date) {
            returnDate = [[date.getFullYear(), date.getMonth()+1, date.getDate()]];
        } else if (Lang.isString(date)) {
            returnDate = this._parseDates(date);
        } else if (Lang.isArray(date)) {
            for (var i=0;i<date.length;++i) {
                var d = date[i];
                returnDate[returnDate.length] = [d.getFullYear(),d.getMonth()+1,d.getDate()];
            }
        }
        
        return returnDate;
    },
    
    /**
    * Converts a date field array [yyyy,mm,dd] to a JavaScript Date object. The date field array
    * is the format in which dates are as provided as arguments to selectEvent and deselectEvent listeners.
    * 
    * @method toDate
    * @param {Number[]} dateFieldArray The date field array to convert to a JavaScript Date.
    * @return {Date} JavaScript Date object representing the date field array.
    */
    toDate : function(dateFieldArray) {
        return this._toDate(dateFieldArray);
    },
    
    /**
    * Converts a date field array [yyyy,mm,dd] to a JavaScript Date object.
    * @method _toDate
    * @private
    * @deprecated Made public, toDate 
    * @param {Number[]}  dateFieldArray The date field array to convert to a JavaScript Date.
    * @return {Date} JavaScript Date object representing the date field array
    */
    _toDate : function(dateFieldArray) {
        if (dateFieldArray instanceof Date) {
            return dateFieldArray;
        } else {
            return DateMath.getDate(dateFieldArray[0],dateFieldArray[1]-1,dateFieldArray[2]);
        }
    },
    
    // END TYPE CONVERSION METHODS 
    
    // BEGIN UTILITY METHODS
    
    /**
    * Determines if 2 field arrays are equal.
    * @method _fieldArraysAreEqual
    * @private
    * @param {Number[]} array1 The first date field array to compare
    * @param {Number[]} array2 The first date field array to compare
    * @return {Boolean} The boolean that represents the equality of the two arrays
    */
    _fieldArraysAreEqual : function(array1, array2) {
        var match = false;
    
        if (array1[0]==array2[0]&&array1[1]==array2[1]&&array1[2]==array2[2]) {
            match=true; 
        }
    
        return match;
    },
    
    /**
    * Gets the index of a date field array [yyyy,mm,dd] in the current list of selected dates.
    * @method _indexOfSelectedFieldArray
    * @private
    * @param {Number[]}  find The date field array to search for
    * @return {Number}   The index of the date field array within the collection of selected dates.
    *        -1 will be returned if the date is not found.
    */
    _indexOfSelectedFieldArray : function(find) {
        var selected = -1,
            seldates = this.cfg.getProperty(DEF_CFG.SELECTED.key);
    
        for (var s=0;s<seldates.length;++s) {
            var sArray = seldates[s];
            if (find[0]==sArray[0]&&find[1]==sArray[1]&&find[2]==sArray[2]) {
                selected = s;
                break;
            }
        }
    
        return selected;
    },
    
    /**
    * Determines whether a given date is OOM (out of month).
    * @method isDateOOM
    * @param {Date} date The JavaScript Date object for which to check the OOM status
    * @return {Boolean} true if the date is OOM
    */
    isDateOOM : function(date) {
        return (date.getMonth() != this.cfg.getProperty(DEF_CFG.PAGEDATE.key).getMonth());
    },
    
    /**
    * Determines whether a given date is OOB (out of bounds - less than the mindate or more than the maxdate).
    *
    * @method isDateOOB
    * @param {Date} date The JavaScript Date object for which to check the OOB status
    * @return {Boolean} true if the date is OOB
    */
    isDateOOB : function(date) {
        var minDate = this.cfg.getProperty(DEF_CFG.MINDATE.key),
            maxDate = this.cfg.getProperty(DEF_CFG.MAXDATE.key),
            dm = DateMath;
        
        if (minDate) {
            minDate = dm.clearTime(minDate);
        } 
        if (maxDate) {
            maxDate = dm.clearTime(maxDate);
        }
    
        var clearedDate = new Date(date.getTime());
        clearedDate = dm.clearTime(clearedDate);
    
        return ((minDate && clearedDate.getTime() < minDate.getTime()) || (maxDate && clearedDate.getTime() > maxDate.getTime()));
    },
    
    /**
     * Parses a pagedate configuration property value. The value can either be specified as a string of form "mm/yyyy" or a Date object 
     * and is parsed into a Date object normalized to the first day of the month. If no value is passed in, the month and year from today's date are used to create the Date object 
     * @method _parsePageDate
     * @private
     * @param {Date|String} date Pagedate value which needs to be parsed
     * @return {Date} The Date object representing the pagedate
     */
    _parsePageDate : function(date) {
        var parsedDate;

        if (date) {
            if (date instanceof Date) {
                parsedDate = DateMath.findMonthStart(date);
            } else {
                var month, year, aMonthYear;
                aMonthYear = date.split(this.cfg.getProperty(DEF_CFG.DATE_FIELD_DELIMITER.key));
                month = parseInt(aMonthYear[this.cfg.getProperty(DEF_CFG.MY_MONTH_POSITION.key)-1], 10)-1;
                year = parseInt(aMonthYear[this.cfg.getProperty(DEF_CFG.MY_YEAR_POSITION.key)-1], 10) - this.Locale.YEAR_OFFSET;

                parsedDate = DateMath.getDate(year, month, 1);
            }
        } else {
            parsedDate = DateMath.getDate(this.today.getFullYear(), this.today.getMonth(), 1);
        }
        return parsedDate;
    },
    
    // END UTILITY METHODS
    
    // BEGIN EVENT HANDLERS
    
    /**
    * Event executed before a date is selected in the calendar widget.
    * @deprecated Event handlers for this event should be susbcribed to beforeSelectEvent.
    */
    onBeforeSelect : function() {
        if (this.cfg.getProperty(DEF_CFG.MULTI_SELECT.key) === false) {
            if (this.parent) {
                this.parent.callChildFunction("clearAllBodyCellStyles", this.Style.CSS_CELL_SELECTED);
                this.parent.deselectAll();
            } else {
                this.clearAllBodyCellStyles(this.Style.CSS_CELL_SELECTED);
                this.deselectAll();
            }
        }
    },
    
    /**
    * Event executed when a date is selected in the calendar widget.
    * @param {Array} selected An array of date field arrays representing which date or dates were selected. Example: [ [2006,8,6],[2006,8,7],[2006,8,8] ]
    * @deprecated Event handlers for this event should be susbcribed to selectEvent.
    */
    onSelect : function(selected) { },
    
    /**
    * Event executed before a date is deselected in the calendar widget.
    * @deprecated Event handlers for this event should be susbcribed to beforeDeselectEvent.
    */
    onBeforeDeselect : function() { },
    
    /**
    * Event executed when a date is deselected in the calendar widget.
    * @param {Array} selected An array of date field arrays representing which date or dates were deselected. Example: [ [2006,8,6],[2006,8,7],[2006,8,8] ]
    * @deprecated Event handlers for this event should be susbcribed to deselectEvent.
    */
    onDeselect : function(deselected) { },
    
    /**
    * Event executed when the user navigates to a different calendar page.
    * @deprecated Event handlers for this event should be susbcribed to changePageEvent.
    */
    onChangePage : function() {
        this.render();
    },

    /**
    * Event executed when the calendar widget is rendered.
    * @deprecated Event handlers for this event should be susbcribed to renderEvent.
    */
    onRender : function() { },

    /**
    * Event executed when the calendar widget is reset to its original state.
    * @deprecated Event handlers for this event should be susbcribed to resetEvemt.
    */
    onReset : function() { this.render(); },

    /**
    * Event executed when the calendar widget is completely cleared to the current month with no selections.
    * @deprecated Event handlers for this event should be susbcribed to clearEvent.
    */
    onClear : function() { this.render(); },
    
    /**
    * Validates the calendar widget. This method has no default implementation
    * and must be extended by subclassing the widget.
    * @return Should return true if the widget validates, and false if
    * it doesn't.
    * @type Boolean
    */
    validate : function() { return true; },
    
    // END EVENT HANDLERS
    
    // BEGIN DATE PARSE METHODS
    
    /**
    * Converts a date string to a date field array
    * @private
    * @param {String} sDate   Date string. Valid formats are mm/dd and mm/dd/yyyy.
    * @return    A date field array representing the string passed to the method
    * @type Array[](Number[])
    */
    _parseDate : function(sDate) {
        var aDate = sDate.split(this.Locale.DATE_FIELD_DELIMITER),
            rArray;

        if (aDate.length == 2) {
            rArray = [aDate[this.Locale.MD_MONTH_POSITION-1],aDate[this.Locale.MD_DAY_POSITION-1]];
            rArray.type = Calendar.MONTH_DAY;
        } else {
            rArray = [aDate[this.Locale.MDY_YEAR_POSITION-1] - this.Locale.YEAR_OFFSET, aDate[this.Locale.MDY_MONTH_POSITION-1],aDate[this.Locale.MDY_DAY_POSITION-1]];
            rArray.type = Calendar.DATE;
        }

        for (var i=0;i<rArray.length;i++) {
            rArray[i] = parseInt(rArray[i], 10);
        }
    
        return rArray;
    },
    
    /**
    * Converts a multi or single-date string to an array of date field arrays
    * @private
    * @param {String} sDates  Date string with one or more comma-delimited dates. Valid formats are mm/dd, mm/dd/yyyy, mm/dd/yyyy-mm/dd/yyyy
    * @return       An array of date field arrays
    * @type Array[](Number[])
    */
    _parseDates : function(sDates) {
        var aReturn = [],
            aDates = sDates.split(this.Locale.DATE_DELIMITER);
        
        for (var d=0;d<aDates.length;++d) {
            var sDate = aDates[d];
    
            if (sDate.indexOf(this.Locale.DATE_RANGE_DELIMITER) != -1) {
                // This is a range
                var aRange = sDate.split(this.Locale.DATE_RANGE_DELIMITER),
                    dateStart = this._parseDate(aRange[0]),
                    dateEnd = this._parseDate(aRange[1]),
                    fullRange = this._parseRange(dateStart, dateEnd);

                aReturn = aReturn.concat(fullRange);
            } else {
                // This is not a range
                var aDate = this._parseDate(sDate);
                aReturn.push(aDate);
            }
        }
        return aReturn;
    },
    
    /**
    * Converts a date range to the full list of included dates
    * @private
    * @param {Number[]} startDate Date field array representing the first date in the range
    * @param {Number[]} endDate  Date field array representing the last date in the range
    * @return       An array of date field arrays
    * @type Array[](Number[])
    */
    _parseRange : function(startDate, endDate) {
        var dCurrent = DateMath.add(DateMath.getDate(startDate[0],startDate[1]-1,startDate[2]),DateMath.DAY,1),
            dEnd     = DateMath.getDate(endDate[0],  endDate[1]-1,  endDate[2]),
            results = [];

        results.push(startDate);
        while (dCurrent.getTime() <= dEnd.getTime()) {
            results.push([dCurrent.getFullYear(),dCurrent.getMonth()+1,dCurrent.getDate()]);
            dCurrent = DateMath.add(dCurrent,DateMath.DAY,1);
        }
        return results;
    },
    
    // END DATE PARSE METHODS
    
    // BEGIN RENDERER METHODS
    
    /**
    * Resets the render stack of the current calendar to its original pre-render value.
    */
    resetRenderers : function() {
        this.renderStack = this._renderStack.concat();
    },

    /**
     * Removes all custom renderers added to the Calendar through the addRenderer, addMonthRenderer and 
     * addWeekdayRenderer methods. Calendar's render method needs to be called after removing renderers 
     * to re-render the Calendar without custom renderers applied.
     */
    removeRenderers : function() {
        this._renderStack = [];
        this.renderStack = [];
    },

    /**
    * Clears the inner HTML, CSS class and style information from the specified cell.
    * @method clearElement
    * @param {HTMLTableCellElement} cell The cell to clear
    */ 
    clearElement : function(cell) {
        cell.innerHTML = "&#160;";
        cell.className="";
    },
    
    /**
    * Adds a renderer to the render stack. The function reference passed to this method will be executed
    * when a date cell matches the conditions specified in the date string for this renderer.
    * 
    * <p>NOTE: The contents of the cell set by the renderer will be added to the DOM as HTML. The custom renderer implementation should 
    * escape markup used to set the cell contents, if coming from an external source.<p>
    * @method addRenderer
    * @param {String} sDates  A date string to associate with the specified renderer. Valid formats
    *         include date (12/24/2005), month/day (12/24), and range (12/1/2004-1/1/2005)
    * @param {Function} fnRender The function executed to render cells that match the render rules for this renderer.
    */
    addRenderer : function(sDates, fnRender) {
        var aDates = this._parseDates(sDates);
        for (var i=0;i<aDates.length;++i) {
            var aDate = aDates[i];
        
            if (aDate.length == 2) { // this is either a range or a month/day combo
                if (aDate[0] instanceof Array) { // this is a range
                    this._addRenderer(Calendar.RANGE,aDate,fnRender);
                } else { // this is a month/day combo
                    this._addRenderer(Calendar.MONTH_DAY,aDate,fnRender);
                }
            } else if (aDate.length == 3) {
                this._addRenderer(Calendar.DATE,aDate,fnRender);
            }
        }
    },
    
    /**
    * The private method used for adding cell renderers to the local render stack.
    * This method is called by other methods that set the renderer type prior to the method call.
    * @method _addRenderer
    * @private
    * @param {String} type  The type string that indicates the type of date renderer being added.
    *         Values are YAHOO.widget.Calendar.DATE, YAHOO.widget.Calendar.MONTH_DAY, YAHOO.widget.Calendar.WEEKDAY,
    *         YAHOO.widget.Calendar.RANGE, YAHOO.widget.Calendar.MONTH
    * @param {Array}  aDates  An array of dates used to construct the renderer. The format varies based
    *         on the renderer type
    * @param {Function} fnRender The function executed to render cells that match the render rules for this renderer.
    */
    _addRenderer : function(type, aDates, fnRender) {
        var add = [type,aDates,fnRender];
        this.renderStack.unshift(add); 
        this._renderStack = this.renderStack.concat();
    },

    /**
    * Adds a month renderer to the render stack. The function reference passed to this method will be executed
    * when a date cell matches the month passed to this method
    * 
    * <p>NOTE: The contents of the cell set by the renderer will be added to the DOM as HTML. The custom renderer implementation should 
    * escape markup used to set the cell contents, if coming from an external source.<p>
    * @method addMonthRenderer
    * @param {Number} month  The month (1-12) to associate with this renderer
    * @param {Function} fnRender The function executed to render cells that match the render rules for this renderer.
    */
    addMonthRenderer : function(month, fnRender) {
        this._addRenderer(Calendar.MONTH,[month],fnRender);
    },

    /**
    * Adds a weekday renderer to the render stack. The function reference passed to this method will be executed
    * when a date cell matches the weekday passed to this method.
    *
    * <p>NOTE: The contents of the cell set by the renderer will be added to the DOM as HTML. The custom renderer implementation should 
    * escape HTML used to set the cell contents, if coming from an external source.<p>
    *
    * @method addWeekdayRenderer
    * @param {Number} weekday  The weekday (Sunday = 1, Monday = 2 ... Saturday = 7) to associate with this renderer
    * @param {Function} fnRender The function executed to render cells that match the render rules for this renderer.
    */
    addWeekdayRenderer : function(weekday, fnRender) {
        this._addRenderer(Calendar.WEEKDAY,[weekday],fnRender);
    },

    // END RENDERER METHODS
    
    // BEGIN CSS METHODS
    
    /**
    * Removes all styles from all body cells in the current calendar table.
    * @method clearAllBodyCellStyles
    * @param {style} style The CSS class name to remove from all calendar body cells
    */
    clearAllBodyCellStyles : function(style) {
        for (var c=0;c<this.cells.length;++c) {
            Dom.removeClass(this.cells[c],style);
        }
    },
    
    // END CSS METHODS
    
    // BEGIN GETTER/SETTER METHODS
    /**
    * Sets the calendar's month explicitly
    * @method setMonth
    * @param {Number} month  The numeric month, from 0 (January) to 11 (December)
    */
    setMonth : function(month) {
        var cfgPageDate = DEF_CFG.PAGEDATE.key,
            current = this.cfg.getProperty(cfgPageDate);
        current.setMonth(parseInt(month, 10));
        this.cfg.setProperty(cfgPageDate, current);
    },

    /**
    * Sets the calendar's year explicitly.
    * @method setYear
    * @param {Number} year  The numeric 4-digit year
    */
    setYear : function(year) {
        var cfgPageDate = DEF_CFG.PAGEDATE.key,
            current = this.cfg.getProperty(cfgPageDate);

        current.setFullYear(parseInt(year, 10) - this.Locale.YEAR_OFFSET);
        this.cfg.setProperty(cfgPageDate, current);
    },

    /**
    * Gets the list of currently selected dates from the calendar.
    * @method getSelectedDates
    * @return {Date[]} An array of currently selected JavaScript Date objects.
    */
    getSelectedDates : function() {
        var returnDates = [],
            selected = this.cfg.getProperty(DEF_CFG.SELECTED.key);

        for (var d=0;d<selected.length;++d) {
            var dateArray = selected[d];

            var date = DateMath.getDate(dateArray[0],dateArray[1]-1,dateArray[2]);
            returnDates.push(date);
        }

        returnDates.sort( function(a,b) { return a-b; } );
        return returnDates;
    },

    /// END GETTER/SETTER METHODS ///
    
    /**
    * Hides the Calendar's outer container from view.
    * @method hide
    */
    hide : function() {
        if (this.beforeHideEvent.fire()) {
            this.oDomContainer.style.display = "none";
            this.hideEvent.fire();
        }
    },

    /**
    * Shows the Calendar's outer container.
    * @method show
    */
    show : function() {
        if (this.beforeShowEvent.fire()) {
            this.oDomContainer.style.display = "block";
            this.showEvent.fire();
        }
    },

    /**
    * Returns a string representing the current browser.
    * @deprecated As of 2.3.0, environment information is available in YAHOO.env.ua
    * @see YAHOO.env.ua
    * @property browser
    * @type String
    */
    browser : (function() {
                var ua = navigator.userAgent.toLowerCase();
                      if (ua.indexOf('opera')!=-1) { // Opera (check first in case of spoof)
                         return 'opera';
                      } else if (ua.indexOf('msie 7')!=-1) { // IE7
                         return 'ie7';
                      } else if (ua.indexOf('msie') !=-1) { // IE
                         return 'ie';
                      } else if (ua.indexOf('safari')!=-1) { // Safari (check before Gecko because it includes "like Gecko")
                         return 'safari';
                      } else if (ua.indexOf('gecko') != -1) { // Gecko
                         return 'gecko';
                      } else {
                         return false;
                      }
                })(),
    /**
    * Returns a string representation of the object.
    * @method toString
    * @return {String} A string representation of the Calendar object.
    */
    toString : function() {
        return "Calendar " + this.id;
    },

    /**
     * Destroys the Calendar instance. The method will remove references
     * to HTML elements, remove any event listeners added by the Calendar,
     * and destroy the Config and CalendarNavigator instances it has created.
     *
     * @method destroy
     */
    destroy : function() {

        if (this.beforeDestroyEvent.fire()) {
            var cal = this;

            // Child objects
            if (cal.navigator) {
                cal.navigator.destroy();
            }

            if (cal.cfg) {
                cal.cfg.destroy();
            }

            // DOM event listeners
            Event.purgeElement(cal.oDomContainer, true);

            // Generated markup/DOM - Not removing the container DIV since we didn't create it.
            Dom.removeClass(cal.oDomContainer, cal.Style.CSS_WITH_TITLE);
            Dom.removeClass(cal.oDomContainer, cal.Style.CSS_CONTAINER);
            Dom.removeClass(cal.oDomContainer, cal.Style.CSS_SINGLE);
            cal.oDomContainer.innerHTML = "";

            // JS-to-DOM references
            cal.oDomContainer = null;
            cal.cells = null;

            this.destroyEvent.fire();
        }
    }
};

YAHOO.widget.Calendar = Calendar;

/**
* @namespace YAHOO.widget
* @class Calendar_Core
* @extends YAHOO.widget.Calendar
* @deprecated The old Calendar_Core class is no longer necessary.
*/
YAHOO.widget.Calendar_Core = YAHOO.widget.Calendar;

YAHOO.widget.Cal_Core = YAHOO.widget.Calendar;

})();
(function() {

    var Dom = YAHOO.util.Dom,
        DateMath = YAHOO.widget.DateMath,
        Event = YAHOO.util.Event,
        Lang = YAHOO.lang,
        Calendar = YAHOO.widget.Calendar;

/**
* YAHOO.widget.CalendarGroup is a special container class for YAHOO.widget.Calendar. This class facilitates
* the ability to have multi-page calendar views that share a single dataset and are
* dependent on each other.
*
* The calendar group instance will refer to each of its elements using a 0-based index.
* For example, to construct the placeholder for a calendar group widget with id "cal1" and
* containerId of "cal1Container", the markup would be as follows:
*   <xmp>
*       <div id="cal1Container_0"></div>
*       <div id="cal1Container_1"></div>
*   </xmp>
* The tables for the calendars ("cal1_0" and "cal1_1") will be inserted into those containers.
*
* <p>
* <strong>NOTE: As of 2.4.0, the constructor's ID argument is optional.</strong>
* The CalendarGroup can be constructed by simply providing a container ID string, 
* or a reference to a container DIV HTMLElement (the element needs to exist 
* in the document).
* 
* E.g.:
*   <xmp>
*       var c = new YAHOO.widget.CalendarGroup("calContainer", configOptions);
*   </xmp>
* or:
*   <xmp>
*       var containerDiv = YAHOO.util.Dom.get("calContainer");
*       var c = new YAHOO.widget.CalendarGroup(containerDiv, configOptions);
*   </xmp>
* </p>
* <p>
* If not provided, the ID will be generated from the container DIV ID by adding an "_t" suffix.
* For example if an ID is not provided, and the container's ID is "calContainer", the CalendarGroup's ID will be set to "calContainer_t".
* </p>
* 
* @namespace YAHOO.widget
* @class CalendarGroup
* @constructor
* @param {String} id optional The id of the table element that will represent the CalendarGroup widget. As of 2.4.0, this argument is optional.
* @param {String | HTMLElement} container The id of the container div element that will wrap the CalendarGroup table, or a reference to a DIV element which exists in the document.
* @param {Object} config optional The configuration object containing the initial configuration values for the CalendarGroup.
*/
function CalendarGroup(id, containerId, config) {
    if (arguments.length > 0) {
        this.init.apply(this, arguments);
    }
}

/**
* The set of default Config property keys and values for the CalendarGroup.
* 
* <p>
* NOTE: This property is made public in order to allow users to change 
* the default values of configuration properties. Users should not 
* modify the key string, unless they are overriding the Calendar implementation
* </p>
*
* @property YAHOO.widget.CalendarGroup.DEFAULT_CONFIG
* @static
* @type Object An object with key/value pairs, the key being the 
* uppercase configuration property name and the value being an objec 
* literal with a key string property, and a value property, specifying the 
* default value of the property 
*/

/**
* The set of default Config property keys and values for the CalendarGroup
* @property YAHOO.widget.CalendarGroup._DEFAULT_CONFIG
* @deprecated Made public. See the public DEFAULT_CONFIG property for details
* @private
* @static
* @type Object
*/
CalendarGroup.DEFAULT_CONFIG = CalendarGroup._DEFAULT_CONFIG = Calendar.DEFAULT_CONFIG;
CalendarGroup.DEFAULT_CONFIG.PAGES = {key:"pages", value:2};

var DEF_CFG = CalendarGroup.DEFAULT_CONFIG;

CalendarGroup.prototype = {

    /**
    * Initializes the calendar group. All subclasses must call this method in order for the
    * group to be initialized properly.
    * @method init
    * @param {String} id optional The id of the table element that will represent the CalendarGroup widget. As of 2.4.0, this argument is optional.
    * @param {String | HTMLElement} container The id of the container div element that will wrap the CalendarGroup table, or a reference to a DIV element which exists in the document.
    * @param {Object} config optional The configuration object containing the initial configuration values for the CalendarGroup.
    */
    init : function(id, container, config) {

        // Normalize 2.4.0, pre 2.4.0 args
        var nArgs = this._parseArgs(arguments);

        id = nArgs.id;
        container = nArgs.container;
        config = nArgs.config;

        this.oDomContainer = Dom.get(container);

        if (!this.oDomContainer.id) {
            this.oDomContainer.id = Dom.generateId();
        }
        if (!id) {
            id = this.oDomContainer.id + "_t";
        }

        /**
        * The unique id associated with the CalendarGroup
        * @property id
        * @type String
        */
        this.id = id;

        /**
        * The unique id associated with the CalendarGroup container
        * @property containerId
        * @type String
        */
        this.containerId = this.oDomContainer.id;

        this.initEvents();
        this.initStyles();

        /**
        * The collection of Calendar pages contained within the CalendarGroup
        * @property pages
        * @type YAHOO.widget.Calendar[]
        */
        this.pages = [];

        Dom.addClass(this.oDomContainer, CalendarGroup.CSS_CONTAINER);
        Dom.addClass(this.oDomContainer, CalendarGroup.CSS_MULTI_UP);

        /**
        * The Config object used to hold the configuration variables for the CalendarGroup
        * @property cfg
        * @type YAHOO.util.Config
        */
        this.cfg = new YAHOO.util.Config(this);

        /**
        * The local object which contains the CalendarGroup's options
        * @property Options
        * @type Object
        */
        this.Options = {};

        /**
        * The local object which contains the CalendarGroup's locale settings
        * @property Locale
        * @type Object
        */
        this.Locale = {};

        this.setupConfig();

        if (config) {
            this.cfg.applyConfig(config, true);
        }

        this.cfg.fireQueue();

    },

    setupConfig : function() {

        var cfg = this.cfg;

        /**
        * The number of pages to include in the CalendarGroup. This value can only be set once, in the CalendarGroup's constructor arguments.
        * @config pages
        * @type Number
        * @default 2
        */
        cfg.addProperty(DEF_CFG.PAGES.key, { value:DEF_CFG.PAGES.value, validator:cfg.checkNumber, handler:this.configPages } );

        /**
        * The positive or negative year offset from the Gregorian calendar year (assuming a January 1st rollover) to 
        * be used when displaying or parsing dates.  NOTE: All JS Date objects returned by methods, or expected as input by
        * methods will always represent the Gregorian year, in order to maintain date/month/week values.
        *
        * @config year_offset
        * @type Number
        * @default 0
        */
        cfg.addProperty(DEF_CFG.YEAR_OFFSET.key, { value:DEF_CFG.YEAR_OFFSET.value, handler: this.delegateConfig, supercedes:DEF_CFG.YEAR_OFFSET.supercedes, suppressEvent:true } );

        /**
        * The date to use to represent "Today".
        *
        * @config today
        * @type Date
        * @default Today's date
        */
        cfg.addProperty(DEF_CFG.TODAY.key, { value: new Date(DEF_CFG.TODAY.value.getTime()), supercedes:DEF_CFG.TODAY.supercedes, handler: this.configToday, suppressEvent:false } );

        /**
        * The month/year representing the current visible Calendar date (mm/yyyy)
        * @config pagedate
        * @type String | Date
        * @default Today's date
        */
        cfg.addProperty(DEF_CFG.PAGEDATE.key, { value: DEF_CFG.PAGEDATE.value || new Date(DEF_CFG.TODAY.value.getTime()), handler:this.configPageDate } );

        /**
        * The date or range of dates representing the current Calendar selection
        *
        * @config selected
        * @type String
        * @default []
        */
        cfg.addProperty(DEF_CFG.SELECTED.key, { value:[], handler:this.configSelected } );

        /**
        * The title to display above the CalendarGroup's month header. The title is inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config title
        * @type HTML
        * @default ""
        */
        cfg.addProperty(DEF_CFG.TITLE.key, { value:DEF_CFG.TITLE.value, handler:this.configTitle } );

        /**
        * Whether or not a close button should be displayed for this CalendarGroup
        * @config close
        * @type Boolean
        * @default false
        */
        cfg.addProperty(DEF_CFG.CLOSE.key, { value:DEF_CFG.CLOSE.value, handler:this.configClose } );

        /**
        * Whether or not an iframe shim should be placed under the Calendar to prevent select boxes from bleeding through in Internet Explorer 6 and below.
        * This property is enabled by default for IE6 and below. It is disabled by default for other browsers for performance reasons, but can be 
        * enabled if required.
        * 
        * @config iframe
        * @type Boolean
        * @default true for IE6 and below, false for all other browsers
        */
        cfg.addProperty(DEF_CFG.IFRAME.key, { value:DEF_CFG.IFRAME.value, handler:this.configIframe, validator:cfg.checkBoolean } );

        /**
        * The minimum selectable date in the current Calendar (mm/dd/yyyy)
        * @config mindate
        * @type String | Date
        * @default null
        */
        cfg.addProperty(DEF_CFG.MINDATE.key, { value:DEF_CFG.MINDATE.value, handler:this.delegateConfig } );

        /**
        * The maximum selectable date in the current Calendar (mm/dd/yyyy)
        * @config maxdate
        * @type String | Date
        * @default null
        */
        cfg.addProperty(DEF_CFG.MAXDATE.key, { value:DEF_CFG.MAXDATE.value, handler:this.delegateConfig  } );

        /**
        * True if the Calendar should allow multiple selections. False by default.
        * @config MULTI_SELECT
        * @type Boolean
        * @default false
        */
        cfg.addProperty(DEF_CFG.MULTI_SELECT.key, { value:DEF_CFG.MULTI_SELECT.value, handler:this.delegateConfig, validator:cfg.checkBoolean } );

        /**
        * True if the Calendar should allow selection of out-of-month dates. False by default.
        * @config OOM_SELECT
        * @type Boolean
        * @default false
        */
        cfg.addProperty(DEF_CFG.OOM_SELECT.key, { value:DEF_CFG.OOM_SELECT.value, handler:this.delegateConfig, validator:cfg.checkBoolean } );

        /**
        * The weekday the week begins on. Default is 0 (Sunday).
        * @config START_WEEKDAY
        * @type number
        * @default 0
        */ 
        cfg.addProperty(DEF_CFG.START_WEEKDAY.key, { value:DEF_CFG.START_WEEKDAY.value, handler:this.delegateConfig, validator:cfg.checkNumber  } );
        
        /**
        * True if the Calendar should show weekday labels. True by default.
        * @config SHOW_WEEKDAYS
        * @type Boolean
        * @default true
        */ 
        cfg.addProperty(DEF_CFG.SHOW_WEEKDAYS.key, { value:DEF_CFG.SHOW_WEEKDAYS.value, handler:this.delegateConfig, validator:cfg.checkBoolean } );
        
        /**
        * True if the Calendar should show week row headers. False by default.
        * @config SHOW_WEEK_HEADER
        * @type Boolean
        * @default false
        */ 
        cfg.addProperty(DEF_CFG.SHOW_WEEK_HEADER.key,{ value:DEF_CFG.SHOW_WEEK_HEADER.value, handler:this.delegateConfig, validator:cfg.checkBoolean } );
        
        /**
        * True if the Calendar should show week row footers. False by default.
        * @config SHOW_WEEK_FOOTER
        * @type Boolean
        * @default false
        */
        cfg.addProperty(DEF_CFG.SHOW_WEEK_FOOTER.key,{ value:DEF_CFG.SHOW_WEEK_FOOTER.value, handler:this.delegateConfig, validator:cfg.checkBoolean } );
        
        /**
        * True if the Calendar should suppress weeks that are not a part of the current month. False by default.
        * @config HIDE_BLANK_WEEKS
        * @type Boolean
        * @default false
        */  
        cfg.addProperty(DEF_CFG.HIDE_BLANK_WEEKS.key,{ value:DEF_CFG.HIDE_BLANK_WEEKS.value, handler:this.delegateConfig, validator:cfg.checkBoolean } );

        /**
        * The image URL that should be used for the left navigation arrow. The image URL is inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config NAV_ARROW_LEFT
        * @type String
        * @deprecated You can customize the image by overriding the default CSS class for the left arrow - "calnavleft"
        * @default null
        */  
        cfg.addProperty(DEF_CFG.NAV_ARROW_LEFT.key, { value:DEF_CFG.NAV_ARROW_LEFT.value, handler:this.delegateConfig } );

        /**
        * The image URL that should be used for the right navigation arrow. The image URL is inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config NAV_ARROW_RIGHT
        * @type String
        * @deprecated You can customize the image by overriding the default CSS class for the right arrow - "calnavright"
        * @default null
        */  
        cfg.addProperty(DEF_CFG.NAV_ARROW_RIGHT.key, { value:DEF_CFG.NAV_ARROW_RIGHT.value, handler:this.delegateConfig } );
    
        // Locale properties
        
        /**
        * The short month labels for the current locale. The month labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config MONTHS_SHORT
        * @type HTML[]
        * @default ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        */
        cfg.addProperty(DEF_CFG.MONTHS_SHORT.key, { value:DEF_CFG.MONTHS_SHORT.value, handler:this.delegateConfig } );
        
        /**
        * The long month labels for the current locale. The month labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config MONTHS_LONG
        * @type HTML[]
        * @default ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
        */ 
        cfg.addProperty(DEF_CFG.MONTHS_LONG.key,  { value:DEF_CFG.MONTHS_LONG.value, handler:this.delegateConfig } );
        
        /**
        * The 1-character weekday labels for the current locale. The weekday labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config WEEKDAYS_1CHAR
        * @type HTML[]
        * @default ["S", "M", "T", "W", "T", "F", "S"]
        */ 
        cfg.addProperty(DEF_CFG.WEEKDAYS_1CHAR.key, { value:DEF_CFG.WEEKDAYS_1CHAR.value, handler:this.delegateConfig } );
        
        /**
        * The short weekday labels for the current locale. The weekday labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config WEEKDAYS_SHORT
        * @type HTML[]
        * @default ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
        */ 
        cfg.addProperty(DEF_CFG.WEEKDAYS_SHORT.key, { value:DEF_CFG.WEEKDAYS_SHORT.value, handler:this.delegateConfig } );
        
        /**
        * The medium weekday labels for the current locale. The weekday labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config WEEKDAYS_MEDIUM
        * @type HTML[]
        * @default ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
        */ 
        cfg.addProperty(DEF_CFG.WEEKDAYS_MEDIUM.key, { value:DEF_CFG.WEEKDAYS_MEDIUM.value, handler:this.delegateConfig } );
        
        /**
        * The long weekday labels for the current locale. The weekday labels are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source.
        * @config WEEKDAYS_LONG
        * @type HTML[]
        * @default ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
        */ 
        cfg.addProperty(DEF_CFG.WEEKDAYS_LONG.key, { value:DEF_CFG.WEEKDAYS_LONG.value, handler:this.delegateConfig } );
    
        /**
        * The setting that determines which length of month labels should be used. Possible values are "short" and "long".
        * @config LOCALE_MONTHS
        * @type String
        * @default "long"
        */
        cfg.addProperty(DEF_CFG.LOCALE_MONTHS.key, { value:DEF_CFG.LOCALE_MONTHS.value, handler:this.delegateConfig } );
    
        /**
        * The setting that determines which length of weekday labels should be used. Possible values are "1char", "short", "medium", and "long".
        * @config LOCALE_WEEKDAYS
        * @type String
        * @default "short"
        */ 
        cfg.addProperty(DEF_CFG.LOCALE_WEEKDAYS.key, { value:DEF_CFG.LOCALE_WEEKDAYS.value, handler:this.delegateConfig } );
    
        /**
        * The value used to delimit individual dates in a date string passed to various Calendar functions.
        * @config DATE_DELIMITER
        * @type String
        * @default ","
        */
        cfg.addProperty(DEF_CFG.DATE_DELIMITER.key,  { value:DEF_CFG.DATE_DELIMITER.value, handler:this.delegateConfig } );
    
        /**
        * The value used to delimit date fields in a date string passed to various Calendar functions.
        * @config DATE_FIELD_DELIMITER
        * @type String
        * @default "/"
        */ 
        cfg.addProperty(DEF_CFG.DATE_FIELD_DELIMITER.key,{ value:DEF_CFG.DATE_FIELD_DELIMITER.value, handler:this.delegateConfig } );
    
        /**
        * The value used to delimit date ranges in a date string passed to various Calendar functions.
        * @config DATE_RANGE_DELIMITER
        * @type String
        * @default "-"
        */
        cfg.addProperty(DEF_CFG.DATE_RANGE_DELIMITER.key,{ value:DEF_CFG.DATE_RANGE_DELIMITER.value, handler:this.delegateConfig } );
    
        /**
        * The position of the month in a month/year date string
        * @config MY_MONTH_POSITION
        * @type Number
        * @default 1
        */
        cfg.addProperty(DEF_CFG.MY_MONTH_POSITION.key, { value:DEF_CFG.MY_MONTH_POSITION.value, handler:this.delegateConfig, validator:cfg.checkNumber } );
        
        /**
        * The position of the year in a month/year date string
        * @config MY_YEAR_POSITION
        * @type Number
        * @default 2
        */ 
        cfg.addProperty(DEF_CFG.MY_YEAR_POSITION.key, { value:DEF_CFG.MY_YEAR_POSITION.value, handler:this.delegateConfig, validator:cfg.checkNumber } );
        
        /**
        * The position of the month in a month/day date string
        * @config MD_MONTH_POSITION
        * @type Number
        * @default 1
        */ 
        cfg.addProperty(DEF_CFG.MD_MONTH_POSITION.key, { value:DEF_CFG.MD_MONTH_POSITION.value, handler:this.delegateConfig, validator:cfg.checkNumber } );
        
        /**
        * The position of the day in a month/year date string
        * @config MD_DAY_POSITION
        * @type Number
        * @default 2
        */ 
        cfg.addProperty(DEF_CFG.MD_DAY_POSITION.key,  { value:DEF_CFG.MD_DAY_POSITION.value, handler:this.delegateConfig, validator:cfg.checkNumber } );
        
        /**
        * The position of the month in a month/day/year date string
        * @config MDY_MONTH_POSITION
        * @type Number
        * @default 1
        */ 
        cfg.addProperty(DEF_CFG.MDY_MONTH_POSITION.key, { value:DEF_CFG.MDY_MONTH_POSITION.value, handler:this.delegateConfig, validator:cfg.checkNumber } );
        
        /**
        * The position of the day in a month/day/year date string
        * @config MDY_DAY_POSITION
        * @type Number
        * @default 2
        */ 
        cfg.addProperty(DEF_CFG.MDY_DAY_POSITION.key, { value:DEF_CFG.MDY_DAY_POSITION.value, handler:this.delegateConfig, validator:cfg.checkNumber } );
        
        /**
        * The position of the year in a month/day/year date string
        * @config MDY_YEAR_POSITION
        * @type Number
        * @default 3
        */ 
        cfg.addProperty(DEF_CFG.MDY_YEAR_POSITION.key, { value:DEF_CFG.MDY_YEAR_POSITION.value, handler:this.delegateConfig, validator:cfg.checkNumber } );
    
        /**
        * The position of the month in the month year label string used as the Calendar header
        * @config MY_LABEL_MONTH_POSITION
        * @type Number
        * @default 1
        */
        cfg.addProperty(DEF_CFG.MY_LABEL_MONTH_POSITION.key, { value:DEF_CFG.MY_LABEL_MONTH_POSITION.value, handler:this.delegateConfig, validator:cfg.checkNumber } );
    
        /**
        * The position of the year in the month year label string used as the Calendar header
        * @config MY_LABEL_YEAR_POSITION
        * @type Number
        * @default 2
        */
        cfg.addProperty(DEF_CFG.MY_LABEL_YEAR_POSITION.key, { value:DEF_CFG.MY_LABEL_YEAR_POSITION.value, handler:this.delegateConfig, validator:cfg.checkNumber } );

        /**
        * The suffix used after the month when rendering the Calendar header
        * @config MY_LABEL_MONTH_SUFFIX
        * @type String
        * @default " "
        */
        cfg.addProperty(DEF_CFG.MY_LABEL_MONTH_SUFFIX.key, { value:DEF_CFG.MY_LABEL_MONTH_SUFFIX.value, handler:this.delegateConfig } );
        
        /**
        * The suffix used after the year when rendering the Calendar header
        * @config MY_LABEL_YEAR_SUFFIX
        * @type String
        * @default ""
        */
        cfg.addProperty(DEF_CFG.MY_LABEL_YEAR_SUFFIX.key, { value:DEF_CFG.MY_LABEL_YEAR_SUFFIX.value, handler:this.delegateConfig } );

        /**
        * Configuration for the Month/Year CalendarNavigator UI which allows the user to jump directly to a 
        * specific Month/Year without having to scroll sequentially through months.
        * <p>
        * Setting this property to null (default value) or false, will disable the CalendarNavigator UI.
        * </p>
        * <p>
        * Setting this property to true will enable the CalendarNavigatior UI with the default CalendarNavigator configuration values.
        * </p>
        * <p>
        * This property can also be set to an object literal containing configuration properties for the CalendarNavigator UI.
        * The configuration object expects the the following case-sensitive properties, with the "strings" property being a nested object.
        * Any properties which are not provided will use the default values (defined in the CalendarNavigator class).
        * </p>
        * <dl>
        * <dt>strings</dt>
        * <dd><em>Object</em> :  An object with the properties shown below, defining the string labels to use in the Navigator's UI. The strings are inserted into the DOM as HTML, and should be escaped by the implementor if coming from an external source. 
        *     <dl>
        *         <dt>month</dt><dd><em>HTML</em> : The markup to use for the month label. Defaults to "Month".</dd>
        *         <dt>year</dt><dd><em>HTML</em> : The markup to use for the year label. Defaults to "Year".</dd>
        *         <dt>submit</dt><dd><em>HTML</em> : The markup to use for the submit button label. Defaults to "Okay".</dd>
        *         <dt>cancel</dt><dd><em>HTML</em> : The markup to use for the cancel button label. Defaults to "Cancel".</dd>
        *         <dt>invalidYear</dt><dd><em>HTML</em> : The markup to use for invalid year values. Defaults to "Year needs to be a number".</dd>
        *     </dl>
        * </dd>
        * <dt>monthFormat</dt><dd><em>String</em> : The month format to use. Either YAHOO.widget.Calendar.LONG, or YAHOO.widget.Calendar.SHORT. Defaults to YAHOO.widget.Calendar.LONG</dd>
        * <dt>initialFocus</dt><dd><em>String</em> : Either "year" or "month" specifying which input control should get initial focus. Defaults to "year"</dd>
        * </dl>
        * <p>E.g.</p>
        * <pre>
        * var navConfig = {
        *   strings: {
        *    month:"Calendar Month",
        *    year:"Calendar Year",
        *    submit: "Submit",
        *    cancel: "Cancel",
        *    invalidYear: "Please enter a valid year"
        *   },
        *   monthFormat: YAHOO.widget.Calendar.SHORT,
        *   initialFocus: "month"
        * }
        * </pre>
        * @config navigator
        * @type {Object|Boolean}
        * @default null
        */
        cfg.addProperty(DEF_CFG.NAV.key, { value:DEF_CFG.NAV.value, handler:this.configNavigator } );

        /**
         * The map of UI strings which the CalendarGroup UI uses.
         *
         * @config strings
         * @type {Object}
         * @default An object with the properties shown below:
         *     <dl>
         *         <dt>previousMonth</dt><dd><em>HTML</em> : The markup to use for the "Previous Month" navigation label. Defaults to "Previous Month". The string is added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.</dd>
         *         <dt>nextMonth</dt><dd><em>HTML</em> : The markup to use for the "Next Month" navigation UI. Defaults to "Next Month". The string is added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.</dd>
         *         <dt>close</dt><dd><em>HTML</em> : The markup to use for the close button label. Defaults to "Close". The string is added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.</dd>
         *     </dl>
         */
        cfg.addProperty(DEF_CFG.STRINGS.key, { 
            value:DEF_CFG.STRINGS.value, 
            handler:this.configStrings, 
            validator: function(val) {
                return Lang.isObject(val);
            },
            supercedes: DEF_CFG.STRINGS.supercedes
        });
    },

    /**
    * Initializes CalendarGroup's built-in CustomEvents
    * @method initEvents
    */
    initEvents : function() {

        var me = this,
            strEvent = "Event",
            CE = YAHOO.util.CustomEvent;

        /**
        * Proxy subscriber to subscribe to the CalendarGroup's child Calendars' CustomEvents
        * @method sub
        * @private
        * @param {Function} fn The function to subscribe to this CustomEvent
        * @param {Object} obj The CustomEvent's scope object
        * @param {Boolean} bOverride Whether or not to apply scope correction
        */
        var sub = function(fn, obj, bOverride) {
            for (var p=0;p<me.pages.length;++p) {
                var cal = me.pages[p];
                cal[this.type + strEvent].subscribe(fn, obj, bOverride);
            }
        };

        /**
        * Proxy unsubscriber to unsubscribe from the CalendarGroup's child Calendars' CustomEvents
        * @method unsub
        * @private
        * @param {Function} fn The function to subscribe to this CustomEvent
        * @param {Object} obj The CustomEvent's scope object
        */
        var unsub = function(fn, obj) {
            for (var p=0;p<me.pages.length;++p) {
                var cal = me.pages[p];
                cal[this.type + strEvent].unsubscribe(fn, obj);
            }
        };

        var defEvents = Calendar._EVENT_TYPES;

        /**
        * Fired before a date selection is made
        * @event beforeSelectEvent
        */
        me.beforeSelectEvent = new CE(defEvents.BEFORE_SELECT);
        me.beforeSelectEvent.subscribe = sub; me.beforeSelectEvent.unsubscribe = unsub;

        /**
        * Fired when a date selection is made
        * @event selectEvent
        * @param {Array} Array of Date field arrays in the format [YYYY, MM, DD].
        */
        me.selectEvent = new CE(defEvents.SELECT); 
        me.selectEvent.subscribe = sub; me.selectEvent.unsubscribe = unsub;

        /**
        * Fired before a date or set of dates is deselected
        * @event beforeDeselectEvent
        */
        me.beforeDeselectEvent = new CE(defEvents.BEFORE_DESELECT); 
        me.beforeDeselectEvent.subscribe = sub; me.beforeDeselectEvent.unsubscribe = unsub;

        /**
        * Fired when a date or set of dates has been deselected
        * @event deselectEvent
        * @param {Array} Array of Date field arrays in the format [YYYY, MM, DD].
        */
        me.deselectEvent = new CE(defEvents.DESELECT); 
        me.deselectEvent.subscribe = sub; me.deselectEvent.unsubscribe = unsub;
        
        /**
        * Fired when the Calendar page is changed
        * @event changePageEvent
        */
        me.changePageEvent = new CE(defEvents.CHANGE_PAGE); 
        me.changePageEvent.subscribe = sub; me.changePageEvent.unsubscribe = unsub;

        /**
        * Fired before the Calendar is rendered
        * @event beforeRenderEvent
        */
        me.beforeRenderEvent = new CE(defEvents.BEFORE_RENDER);
        me.beforeRenderEvent.subscribe = sub; me.beforeRenderEvent.unsubscribe = unsub;
    
        /**
        * Fired when the Calendar is rendered
        * @event renderEvent
        */
        me.renderEvent = new CE(defEvents.RENDER);
        me.renderEvent.subscribe = sub; me.renderEvent.unsubscribe = unsub;
    
        /**
        * Fired when the Calendar is reset
        * @event resetEvent
        */
        me.resetEvent = new CE(defEvents.RESET); 
        me.resetEvent.subscribe = sub; me.resetEvent.unsubscribe = unsub;
    
        /**
        * Fired when the Calendar is cleared
        * @event clearEvent
        */
        me.clearEvent = new CE(defEvents.CLEAR);
        me.clearEvent.subscribe = sub; me.clearEvent.unsubscribe = unsub;

        /**
        * Fired just before the CalendarGroup is to be shown
        * @event beforeShowEvent
        */
        me.beforeShowEvent = new CE(defEvents.BEFORE_SHOW);
    
        /**
        * Fired after the CalendarGroup is shown
        * @event showEvent
        */
        me.showEvent = new CE(defEvents.SHOW);
    
        /**
        * Fired just before the CalendarGroup is to be hidden
        * @event beforeHideEvent
        */
        me.beforeHideEvent = new CE(defEvents.BEFORE_HIDE);
    
        /**
        * Fired after the CalendarGroup is hidden
        * @event hideEvent
        */
        me.hideEvent = new CE(defEvents.HIDE);

        /**
        * Fired just before the CalendarNavigator is to be shown
        * @event beforeShowNavEvent
        */
        me.beforeShowNavEvent = new CE(defEvents.BEFORE_SHOW_NAV);
    
        /**
        * Fired after the CalendarNavigator is shown
        * @event showNavEvent
        */
        me.showNavEvent = new CE(defEvents.SHOW_NAV);
    
        /**
        * Fired just before the CalendarNavigator is to be hidden
        * @event beforeHideNavEvent
        */
        me.beforeHideNavEvent = new CE(defEvents.BEFORE_HIDE_NAV);

        /**
        * Fired after the CalendarNavigator is hidden
        * @event hideNavEvent
        */
        me.hideNavEvent = new CE(defEvents.HIDE_NAV);

        /**
        * Fired just before the CalendarNavigator is to be rendered
        * @event beforeRenderNavEvent
        */
        me.beforeRenderNavEvent = new CE(defEvents.BEFORE_RENDER_NAV);

        /**
        * Fired after the CalendarNavigator is rendered
        * @event renderNavEvent
        */
        me.renderNavEvent = new CE(defEvents.RENDER_NAV);

        /**
        * Fired just before the CalendarGroup is to be destroyed
        * @event beforeDestroyEvent
        */
        me.beforeDestroyEvent = new CE(defEvents.BEFORE_DESTROY);

        /**
        * Fired after the CalendarGroup is destroyed. This event should be used
        * for notification only. When this event is fired, important CalendarGroup instance
        * properties, dom references and event listeners have already been 
        * removed/dereferenced, and hence the CalendarGroup instance is not in a usable 
        * state.
        *
        * @event destroyEvent
        */
        me.destroyEvent = new CE(defEvents.DESTROY);
    },
    
    /**
    * The default Config handler for the "pages" property
    * @method configPages
    * @param {String} type The CustomEvent type (usually the property name)
    * @param {Object[]} args The CustomEvent arguments. For configuration handlers, args[0] will equal the newly applied value for the property.
    * @param {Object} obj The scope object. For configuration handlers, this will usually equal the owner.
    */
    configPages : function(type, args, obj) {
        var pageCount = args[0],
            cfgPageDate = DEF_CFG.PAGEDATE.key,
            sep = "_",
            caldate,
            firstPageDate = null,
            groupCalClass = "groupcal",
            firstClass = "first-of-type",
            lastClass = "last-of-type";

        for (var p=0;p<pageCount;++p) {
            var calId = this.id + sep + p,
                calContainerId = this.containerId + sep + p,
                childConfig = this.cfg.getConfig();

            childConfig.close = false;
            childConfig.title = false;
            childConfig.navigator = null;

            if (p > 0) {
                caldate = new Date(firstPageDate);
                this._setMonthOnDate(caldate, caldate.getMonth() + p);
                childConfig.pageDate = caldate;
            }

            var cal = this.constructChild(calId, calContainerId, childConfig);

            Dom.removeClass(cal.oDomContainer, this.Style.CSS_SINGLE);
            Dom.addClass(cal.oDomContainer, groupCalClass);

            if (p===0) {
                firstPageDate = cal.cfg.getProperty(cfgPageDate);
                Dom.addClass(cal.oDomContainer, firstClass);
            }
    
            if (p==(pageCount-1)) {
                Dom.addClass(cal.oDomContainer, lastClass);
            }
    
            cal.parent = this;
            cal.index = p; 
    
            this.pages[this.pages.length] = cal;
        }
    },
    
    /**
    * The default Config handler for the "pagedate" property
    * @method configPageDate
    * @param {String} type The CustomEvent type (usually the property name)
    * @param {Object[]} args The CustomEvent arguments. For configuration handlers, args[0] will equal the newly applied value for the property.
    * @param {Object} obj The scope object. For configuration handlers, this will usually equal the owner.
    */
    configPageDate : function(type, args, obj) {
        var val = args[0],
            firstPageDate;

        var cfgPageDate = DEF_CFG.PAGEDATE.key;
        
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            if (p === 0) {
                firstPageDate = cal._parsePageDate(val);
                cal.cfg.setProperty(cfgPageDate, firstPageDate);
            } else {
                var pageDate = new Date(firstPageDate);
                this._setMonthOnDate(pageDate, pageDate.getMonth() + p);
                cal.cfg.setProperty(cfgPageDate, pageDate);
            }
        }
    },
    
    /**
    * The default Config handler for the CalendarGroup "selected" property
    * @method configSelected
    * @param {String} type The CustomEvent type (usually the property name)
    * @param {Object[]} args The CustomEvent arguments. For configuration handlers, args[0] will equal the newly applied value for the property.
    * @param {Object} obj The scope object. For configuration handlers, this will usually equal the owner.
    */
    configSelected : function(type, args, obj) {
        var cfgSelected = DEF_CFG.SELECTED.key;
        this.delegateConfig(type, args, obj);
        var selected = (this.pages.length > 0) ? this.pages[0].cfg.getProperty(cfgSelected) : []; 
        this.cfg.setProperty(cfgSelected, selected, true);
    },

    
    /**
    * Delegates a configuration property to the CustomEvents associated with the CalendarGroup's children
    * @method delegateConfig
    * @param {String} type The CustomEvent type (usually the property name)
    * @param {Object[]} args The CustomEvent arguments. For configuration handlers, args[0] will equal the newly applied value for the property.
    * @param {Object} obj The scope object. For configuration handlers, this will usually equal the owner.
    */
    delegateConfig : function(type, args, obj) {
        var val = args[0];
        var cal;
    
        for (var p=0;p<this.pages.length;p++) {
            cal = this.pages[p];
            cal.cfg.setProperty(type, val);
        }
    },

    /**
    * Adds a function to all child Calendars within this CalendarGroup.
    * @method setChildFunction
    * @param {String}  fnName  The name of the function
    * @param {Function}  fn   The function to apply to each Calendar page object
    */
    setChildFunction : function(fnName, fn) {
        var pageCount = this.cfg.getProperty(DEF_CFG.PAGES.key);
    
        for (var p=0;p<pageCount;++p) {
            this.pages[p][fnName] = fn;
        }
    },

    /**
    * Calls a function within all child Calendars within this CalendarGroup.
    * @method callChildFunction
    * @param {String}  fnName  The name of the function
    * @param {Array}  args  The arguments to pass to the function
    */
    callChildFunction : function(fnName, args) {
        var pageCount = this.cfg.getProperty(DEF_CFG.PAGES.key);

        for (var p=0;p<pageCount;++p) {
            var page = this.pages[p];
            if (page[fnName]) {
                var fn = page[fnName];
                fn.call(page, args);
            }
        } 
    },

    /**
    * Constructs a child calendar. This method can be overridden if a subclassed version of the default
    * calendar is to be used.
    * @method constructChild
    * @param {String} id   The id of the table element that will represent the calendar widget
    * @param {String} containerId The id of the container div element that will wrap the calendar table
    * @param {Object} config  The configuration object containing the Calendar's arguments
    * @return {YAHOO.widget.Calendar} The YAHOO.widget.Calendar instance that is constructed
    */
    constructChild : function(id,containerId,config) {
        var container = document.getElementById(containerId);
        if (! container) {
            container = document.createElement("div");
            container.id = containerId;
            this.oDomContainer.appendChild(container);
        }
        return new Calendar(id,containerId,config);
    },
    
    /**
    * Sets the calendar group's month explicitly. This month will be set into the first
    * page of the multi-page calendar, and all other months will be iterated appropriately.
    * @method setMonth
    * @param {Number} month  The numeric month, from 0 (January) to 11 (December)
    */
    setMonth : function(month) {
        month = parseInt(month, 10);
        var currYear;

        var cfgPageDate = DEF_CFG.PAGEDATE.key;

        for (var p=0; p<this.pages.length; ++p) {
            var cal = this.pages[p];
            var pageDate = cal.cfg.getProperty(cfgPageDate);
            if (p === 0) {
                currYear = pageDate.getFullYear();
            } else {
                pageDate.setFullYear(currYear);
            }
            this._setMonthOnDate(pageDate, month+p); 
            cal.cfg.setProperty(cfgPageDate, pageDate);
        }
    },

    /**
    * Sets the calendar group's year explicitly. This year will be set into the first
    * page of the multi-page calendar, and all other months will be iterated appropriately.
    * @method setYear
    * @param {Number} year  The numeric 4-digit year
    */
    setYear : function(year) {
    
        var cfgPageDate = DEF_CFG.PAGEDATE.key;
    
        year = parseInt(year, 10);
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            var pageDate = cal.cfg.getProperty(cfgPageDate);
    
            if ((pageDate.getMonth()+1) == 1 && p>0) {
                year+=1;
            }
            cal.setYear(year);
        }
    },

    /**
    * Calls the render function of all child calendars within the group.
    * @method render
    */
    render : function() {
        this.renderHeader();
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.render();
        }
        this.renderFooter();
    },

    /**
    * Selects a date or a collection of dates on the current calendar. This method, by default,
    * does not call the render method explicitly. Once selection has completed, render must be 
    * called for the changes to be reflected visually.
    * @method select
    * @param    {String/Date/Date[]}    date    The date string of dates to select in the current calendar. Valid formats are
    *                               individual date(s) (12/24/2005,12/26/2005) or date range(s) (12/24/2005-1/1/2006).
    *                               Multiple comma-delimited dates can also be passed to this method (12/24/2005,12/11/2005-12/13/2005).
    *                               This method can also take a JavaScript Date object or an array of Date objects.
    * @return {Date[]} Array of JavaScript Date objects representing all individual dates that are currently selected.
    */
    select : function(date) {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.select(date);
        }
        return this.getSelectedDates();
    },

    /**
    * Selects dates in the CalendarGroup based on the cell index provided. This method is used to select cells without having to do a full render. The selected style is applied to the cells directly.
    * The value of the MULTI_SELECT Configuration attribute will determine the set of dates which get selected. 
    * <ul>
    *    <li>If MULTI_SELECT is false, selectCell will select the cell at the specified index for only the last displayed Calendar page.</li>
    *    <li>If MULTI_SELECT is true, selectCell will select the cell at the specified index, on each displayed Calendar page.</li>
    * </ul>
    * @method selectCell
    * @param {Number} cellIndex The index of the cell to be selected. 
    * @return {Date[]} Array of JavaScript Date objects representing all individual dates that are currently selected.
    */
    selectCell : function(cellIndex) {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.selectCell(cellIndex);
        }
        return this.getSelectedDates();
    },
    
    /**
    * Deselects a date or a collection of dates on the current calendar. This method, by default,
    * does not call the render method explicitly. Once deselection has completed, render must be 
    * called for the changes to be reflected visually.
    * @method deselect
    * @param {String/Date/Date[]} date The date string of dates to deselect in the current calendar. Valid formats are
    *        individual date(s) (12/24/2005,12/26/2005) or date range(s) (12/24/2005-1/1/2006).
    *        Multiple comma-delimited dates can also be passed to this method (12/24/2005,12/11/2005-12/13/2005).
    *        This method can also take a JavaScript Date object or an array of Date objects. 
    * @return {Date[]}   Array of JavaScript Date objects representing all individual dates that are currently selected.
    */
    deselect : function(date) {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.deselect(date);
        }
        return this.getSelectedDates();
    },
    
    /**
    * Deselects all dates on the current calendar.
    * @method deselectAll
    * @return {Date[]}  Array of JavaScript Date objects representing all individual dates that are currently selected.
    *      Assuming that this function executes properly, the return value should be an empty array.
    *      However, the empty array is returned for the sake of being able to check the selection status
    *      of the calendar.
    */
    deselectAll : function() {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.deselectAll();
        }
        return this.getSelectedDates();
    },

    /**
    * Deselects dates in the CalendarGroup based on the cell index provided. This method is used to select cells without having to do a full render. The selected style is applied to the cells directly.
    * deselectCell will deselect the cell at the specified index on each displayed Calendar page.
    *
    * @method deselectCell
    * @param {Number} cellIndex The index of the cell to deselect. 
    * @return {Date[]} Array of JavaScript Date objects representing all individual dates that are currently selected.
    */
    deselectCell : function(cellIndex) {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.deselectCell(cellIndex);
        }
        return this.getSelectedDates();
    },

    /**
    * Resets the calendar widget to the originally selected month and year, and 
    * sets the calendar to the initial selection(s).
    * @method reset
    */
    reset : function() {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.reset();
        }
    },

    /**
    * Clears the selected dates in the current calendar widget and sets the calendar
    * to the current month and year.
    * @method clear
    */
    clear : function() {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.clear();
        }

        this.cfg.setProperty(DEF_CFG.SELECTED.key, []);
        this.cfg.setProperty(DEF_CFG.PAGEDATE.key, new Date(this.pages[0].today.getTime()));
        this.render();
    },

    /**
    * Navigates to the next month page in the calendar widget.
    * @method nextMonth
    */
    nextMonth : function() {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.nextMonth();
        }
    },
    
    /**
    * Navigates to the previous month page in the calendar widget.
    * @method previousMonth
    */
    previousMonth : function() {
        for (var p=this.pages.length-1;p>=0;--p) {
            var cal = this.pages[p];
            cal.previousMonth();
        }
    },
    
    /**
    * Navigates to the next year in the currently selected month in the calendar widget.
    * @method nextYear
    */
    nextYear : function() {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.nextYear();
        }
    },

    /**
    * Navigates to the previous year in the currently selected month in the calendar widget.
    * @method previousYear
    */
    previousYear : function() {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.previousYear();
        }
    },

    /**
    * Gets the list of currently selected dates from the calendar.
    * @return   An array of currently selected JavaScript Date objects.
    * @type Date[]
    */
    getSelectedDates : function() { 
        var returnDates = [];
        var selected = this.cfg.getProperty(DEF_CFG.SELECTED.key);
        for (var d=0;d<selected.length;++d) {
            var dateArray = selected[d];

            var date = DateMath.getDate(dateArray[0],dateArray[1]-1,dateArray[2]);
            returnDates.push(date);
        }

        returnDates.sort( function(a,b) { return a-b; } );
        return returnDates;
    },

    /**
    * Adds a renderer to the render stack. The function reference passed to this method will be executed
    * when a date cell matches the conditions specified in the date string for this renderer.
    * 
    * <p>NOTE: The contents of the cell set by the renderer will be added to the DOM as HTML. The custom renderer implementation should 
    * escape markup used to set the cell contents, if coming from an external source.<p>
    * @method addRenderer
    * @param {String} sDates  A date string to associate with the specified renderer. Valid formats
    *         include date (12/24/2005), month/day (12/24), and range (12/1/2004-1/1/2005)
    * @param {Function} fnRender The function executed to render cells that match the render rules for this renderer.
    */
    addRenderer : function(sDates, fnRender) {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.addRenderer(sDates, fnRender);
        }
    },

    /**
    * Adds a month renderer to the render stack. The function reference passed to this method will be executed
    * when a date cell matches the month passed to this method
    * 
    * <p>NOTE: The contents of the cell set by the renderer will be added to the DOM as HTML. The custom renderer implementation should 
    * escape markup used to set the cell contents, if coming from an external source.<p>
    * @method addMonthRenderer
    * @param {Number} month  The month (1-12) to associate with this renderer
    * @param {Function} fnRender The function executed to render cells that match the render rules for this renderer.
    */
    addMonthRenderer : function(month, fnRender) {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.addMonthRenderer(month, fnRender);
        }
    },

    /**
    * Adds a weekday renderer to the render stack. The function reference passed to this method will be executed
    * when a date cell matches the weekday passed to this method.
    *
    * <p>NOTE: The contents of the cell set by the renderer will be added to the DOM as HTML. The custom renderer implementation should 
    * escape HTML used to set the cell contents, if coming from an external source.<p>
    *
    * @method addWeekdayRenderer
    * @param {Number} weekday  The weekday (Sunday = 1, Monday = 2 ... Saturday = 7) to associate with this renderer
    * @param {Function} fnRender The function executed to render cells that match the render rules for this renderer.
    */
    addWeekdayRenderer : function(weekday, fnRender) {
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            cal.addWeekdayRenderer(weekday, fnRender);
        }
    },

    /**
     * Removes all custom renderers added to the CalendarGroup through the addRenderer, addMonthRenderer and 
     * addWeekRenderer methods. CalendarGroup's render method needs to be called to after removing renderers 
     * to see the changes applied.
     * 
     * @method removeRenderers
     */
    removeRenderers : function() {
        this.callChildFunction("removeRenderers");
    },

    /**
    * Renders the header for the CalendarGroup.
    * @method renderHeader
    */
    renderHeader : function() {
        // EMPTY DEFAULT IMPL
    },

    /**
    * Renders a footer for the 2-up calendar container. By default, this method is
    * unimplemented.
    * @method renderFooter
    */
    renderFooter : function() {
        // EMPTY DEFAULT IMPL
    },

    /**
    * Adds the designated number of months to the current calendar month, and sets the current
    * calendar page date to the new month.
    * @method addMonths
    * @param {Number} count The number of months to add to the current calendar
    */
    addMonths : function(count) {
        this.callChildFunction("addMonths", count);
    },
    
    /**
    * Subtracts the designated number of months from the current calendar month, and sets the current
    * calendar page date to the new month.
    * @method subtractMonths
    * @param {Number} count The number of months to subtract from the current calendar
    */
    subtractMonths : function(count) {
        this.callChildFunction("subtractMonths", count);
    },

    /**
    * Adds the designated number of years to the current calendar, and sets the current
    * calendar page date to the new month.
    * @method addYears
    * @param {Number} count The number of years to add to the current calendar
    */
    addYears : function(count) {
        this.callChildFunction("addYears", count);
    },

    /**
    * Subtcats the designated number of years from the current calendar, and sets the current
    * calendar page date to the new month.
    * @method subtractYears
    * @param {Number} count The number of years to subtract from the current calendar
    */
    subtractYears : function(count) {
        this.callChildFunction("subtractYears", count);
    },

    /**
     * Returns the Calendar page instance which has a pagedate (month/year) matching the given date. 
     * Returns null if no match is found.
     * 
     * @method getCalendarPage
     * @param {Date} date The JavaScript Date object for which a Calendar page is to be found.
     * @return {Calendar} The Calendar page instance representing the month to which the date 
     * belongs.
     */
    getCalendarPage : function(date) {
        var cal = null;
        if (date) {
            var y = date.getFullYear(),
                m = date.getMonth();

            var pages = this.pages;
            for (var i = 0; i < pages.length; ++i) {
                var pageDate = pages[i].cfg.getProperty("pagedate");
                if (pageDate.getFullYear() === y && pageDate.getMonth() === m) {
                    cal = pages[i];
                    break;
                }
            }
        }
        return cal;
    },

    /**
    * Sets the month on a Date object, taking into account year rollover if the month is less than 0 or greater than 11.
    * The Date object passed in is modified. It should be cloned before passing it into this method if the original value needs to be maintained
    * @method _setMonthOnDate
    * @private
    * @param {Date} date The Date object on which to set the month index
    * @param {Number} iMonth The month index to set
    */
    _setMonthOnDate : function(date, iMonth) {
        // Bug in Safari 1.3, 2.0 (WebKit build < 420), Date.setMonth does not work consistently if iMonth is not 0-11
        if (YAHOO.env.ua.webkit && YAHOO.env.ua.webkit < 420 && (iMonth < 0 || iMonth > 11)) {
            var newDate = DateMath.add(date, DateMath.MONTH, iMonth-date.getMonth());
            date.setTime(newDate.getTime());
        } else {
            date.setMonth(iMonth);
        }
    },
    
    /**
     * Fixes the width of the CalendarGroup container element, to account for miswrapped floats
     * @method _fixWidth
     * @private
     */
    _fixWidth : function() {
        var w = 0;
        for (var p=0;p<this.pages.length;++p) {
            var cal = this.pages[p];
            w += cal.oDomContainer.offsetWidth;
        }
        if (w > 0) {
            this.oDomContainer.style.width = w + "px";
        }
    },
    
    /**
    * Returns a string representation of the object.
    * @method toString
    * @return {String} A string representation of the CalendarGroup object.
    */
    toString : function() {
        return "CalendarGroup " + this.id;
    },

    /**
     * Destroys the CalendarGroup instance. The method will remove references
     * to HTML elements, remove any event listeners added by the CalendarGroup.
     * 
     * It will also destroy the Config and CalendarNavigator instances created by the 
     * CalendarGroup and the individual Calendar instances created for each page.
     *
     * @method destroy
     */
    destroy : function() {

        if (this.beforeDestroyEvent.fire()) {

            var cal = this;
    
            // Child objects
            if (cal.navigator) {
                cal.navigator.destroy();
            }
    
            if (cal.cfg) {
                cal.cfg.destroy();
            }
    
            // DOM event listeners
            Event.purgeElement(cal.oDomContainer, true);
    
            // Generated markup/DOM - Not removing the container DIV since we didn't create it.
            Dom.removeClass(cal.oDomContainer, CalendarGroup.CSS_CONTAINER);
            Dom.removeClass(cal.oDomContainer, CalendarGroup.CSS_MULTI_UP);
            
            for (var i = 0, l = cal.pages.length; i < l; i++) {
                cal.pages[i].destroy();
                cal.pages[i] = null;
            }
    
            cal.oDomContainer.innerHTML = "";
    
            // JS-to-DOM references
            cal.oDomContainer = null;
    
            this.destroyEvent.fire();
        }
    }
};

/**
* CSS class representing the container for the calendar
* @property YAHOO.widget.CalendarGroup.CSS_CONTAINER
* @static
* @final
* @type String
*/
CalendarGroup.CSS_CONTAINER = "yui-calcontainer";

/**
* CSS class representing the container for the calendar
* @property YAHOO.widget.CalendarGroup.CSS_MULTI_UP
* @static
* @final
* @type String
*/
CalendarGroup.CSS_MULTI_UP = "multi";

/**
* CSS class representing the title for the 2-up calendar
* @property YAHOO.widget.CalendarGroup.CSS_2UPTITLE
* @static
* @final
* @type String
*/
CalendarGroup.CSS_2UPTITLE = "title";

/**
* CSS class representing the close icon for the 2-up calendar
* @property YAHOO.widget.CalendarGroup.CSS_2UPCLOSE
* @static
* @final
* @deprecated Along with Calendar.IMG_ROOT and NAV_ARROW_LEFT, NAV_ARROW_RIGHT configuration properties.
*     Calendar's <a href="YAHOO.widget.Calendar.html#Style.CSS_CLOSE">Style.CSS_CLOSE</a> property now represents the CSS class used to render the close icon
* @type String
*/
CalendarGroup.CSS_2UPCLOSE = "close-icon";

YAHOO.lang.augmentProto(CalendarGroup, Calendar, "buildDayLabel",
                                                 "buildMonthLabel",
                                                 "renderOutOfBoundsDate",
                                                 "renderRowHeader",
                                                 "renderRowFooter",
                                                 "renderCellDefault",
                                                 "styleCellDefault",
                                                 "renderCellStyleHighlight1",
                                                 "renderCellStyleHighlight2",
                                                 "renderCellStyleHighlight3",
                                                 "renderCellStyleHighlight4",
                                                 "renderCellStyleToday",
                                                 "renderCellStyleSelected",
                                                 "renderCellNotThisMonth",
                                                 "styleCellNotThisMonth",
                                                 "renderBodyCellRestricted",
                                                 "initStyles",
                                                 "configTitle",
                                                 "configClose",
                                                 "configIframe",
                                                 "configStrings",
                                                 "configToday",
                                                 "configNavigator",
                                                 "createTitleBar",
                                                 "createCloseButton",
                                                 "removeTitleBar",
                                                 "removeCloseButton",
                                                 "hide",
                                                 "show",
                                                 "toDate",
                                                 "_toDate",
                                                 "_parseArgs",
                                                 "browser");

YAHOO.widget.CalGrp = CalendarGroup;
YAHOO.widget.CalendarGroup = CalendarGroup;

/**
* @class YAHOO.widget.Calendar2up
* @extends YAHOO.widget.CalendarGroup
* @deprecated The old Calendar2up class is no longer necessary, since CalendarGroup renders in a 2up view by default.
*/
YAHOO.widget.Calendar2up = function(id, containerId, config) {
    this.init(id, containerId, config);
};

YAHOO.extend(YAHOO.widget.Calendar2up, CalendarGroup);

/**
* @deprecated The old Calendar2up class is no longer necessary, since CalendarGroup renders in a 2up view by default.
*/
YAHOO.widget.Cal2up = YAHOO.widget.Calendar2up;

})();
/**
 * The CalendarNavigator is used along with a Calendar/CalendarGroup to 
 * provide a Month/Year popup navigation control, allowing the user to navigate 
 * to a specific month/year in the Calendar/CalendarGroup without having to 
 * scroll through months sequentially
 *
 * @namespace YAHOO.widget
 * @class CalendarNavigator
 * @constructor
 * @param {Calendar|CalendarGroup} cal The instance of the Calendar or CalendarGroup to which this CalendarNavigator should be attached.
 */
YAHOO.widget.CalendarNavigator = function(cal) {
    this.init(cal);
};

(function() {
    // Setup static properties (inside anon fn, so that we can use shortcuts)
    var CN = YAHOO.widget.CalendarNavigator;

    /**
     * YAHOO.widget.CalendarNavigator.CLASSES contains constants
     * for the class values applied to the CalendarNaviatgator's 
     * DOM elements
     * @property YAHOO.widget.CalendarNavigator.CLASSES
     * @type Object
     * @static
     */
    CN.CLASSES = {
        /**
         * Class applied to the Calendar Navigator's bounding box
         * @property YAHOO.widget.CalendarNavigator.CLASSES.NAV
         * @type String
         * @static
         */
        NAV :"yui-cal-nav",
        /**
         * Class applied to the Calendar/CalendarGroup's bounding box to indicate
         * the Navigator is currently visible
         * @property YAHOO.widget.CalendarNavigator.CLASSES.NAV_VISIBLE
         * @type String
         * @static
         */
        NAV_VISIBLE: "yui-cal-nav-visible",
        /**
         * Class applied to the Navigator mask's bounding box
         * @property YAHOO.widget.CalendarNavigator.CLASSES.MASK
         * @type String
         * @static
         */
        MASK : "yui-cal-nav-mask",
        /**
         * Class applied to the year label/control bounding box
         * @property YAHOO.widget.CalendarNavigator.CLASSES.YEAR
         * @type String
         * @static
         */
        YEAR : "yui-cal-nav-y",
        /**
         * Class applied to the month label/control bounding box
         * @property YAHOO.widget.CalendarNavigator.CLASSES.MONTH
         * @type String
         * @static
         */
        MONTH : "yui-cal-nav-m",
        /**
         * Class applied to the submit/cancel button's bounding box
         * @property YAHOO.widget.CalendarNavigator.CLASSES.BUTTONS
         * @type String
         * @static
         */
        BUTTONS : "yui-cal-nav-b",
        /**
         * Class applied to buttons wrapping element
         * @property YAHOO.widget.CalendarNavigator.CLASSES.BUTTON
         * @type String
         * @static
         */
        BUTTON : "yui-cal-nav-btn",
        /**
         * Class applied to the validation error area's bounding box
         * @property YAHOO.widget.CalendarNavigator.CLASSES.ERROR
         * @type String
         * @static
         */
        ERROR : "yui-cal-nav-e",
        /**
         * Class applied to the year input control
         * @property YAHOO.widget.CalendarNavigator.CLASSES.YEAR_CTRL
         * @type String
         * @static
         */
        YEAR_CTRL : "yui-cal-nav-yc",
        /**
         * Class applied to the month input control
         * @property YAHOO.widget.CalendarNavigator.CLASSES.MONTH_CTRL
         * @type String
         * @static
         */
        MONTH_CTRL : "yui-cal-nav-mc",
        /**
         * Class applied to controls with invalid data (e.g. a year input field with invalid an year)
         * @property YAHOO.widget.CalendarNavigator.CLASSES.INVALID
         * @type String
         * @static
         */
        INVALID : "yui-invalid",
        /**
         * Class applied to default controls
         * @property YAHOO.widget.CalendarNavigator.CLASSES.DEFAULT
         * @type String
         * @static
         */
        DEFAULT : "yui-default"
    };

    /**
     * Object literal containing the default configuration values for the CalendarNavigator
     * The configuration object is expected to follow the format below, with the properties being
     * case sensitive.
     * <dl>
     * <dt>strings</dt>
     * <dd><em>Object</em> :  An object with the properties shown below, defining the string labels to use in the Navigator's UI
     *     <dl>
     *         <dt>month</dt><dd><em>HTML</em> : The markup to use for the month label. Defaults to "Month".</dd>
     *         <dt>year</dt><dd><em>HTML</em> : The markup to use for the year label. Defaults to "Year".</dd>
     *         <dt>submit</dt><dd><em>HTML</em> : The markup to use for the submit button label. Defaults to "Okay".</dd>
     *         <dt>cancel</dt><dd><em>HTML</em> : The markup to use for the cancel button label. Defaults to "Cancel".</dd>
     *         <dt>invalidYear</dt><dd><em>HTML</em> : The markup to use for invalid year values. Defaults to "Year needs to be a number".</dd>
     *     </dl>
     * </dd>
     * <dt>monthFormat</dt><dd><em>String</em> : The month format to use. Either YAHOO.widget.Calendar.LONG, or YAHOO.widget.Calendar.SHORT. Defaults to YAHOO.widget.Calendar.LONG</dd>
     * <dt>initialFocus</dt><dd><em>String</em> : Either "year" or "month" specifying which input control should get initial focus. Defaults to "year"</dd>
     * </dl>
     * @property DEFAULT_CONFIG
     * @type Object
     * @static
     */
    CN.DEFAULT_CONFIG = {
        strings : {
            month: "Month",
            year: "Year",
            submit: "Okay",
            cancel: "Cancel",
            invalidYear : "Year needs to be a number"
        },
        monthFormat: YAHOO.widget.Calendar.LONG,
        initialFocus: "year"
    };

    /**
     * Object literal containing the default configuration values for the CalendarNavigator
     * @property _DEFAULT_CFG
     * @protected
     * @deprecated Made public. See the public DEFAULT_CONFIG property
     * @type Object
     * @static
     */
    CN._DEFAULT_CFG = CN.DEFAULT_CONFIG;


    /**
     * The suffix added to the Calendar/CalendarGroup's ID, to generate
     * a unique ID for the Navigator and it's bounding box.
     * @property YAHOO.widget.CalendarNavigator.ID_SUFFIX
     * @static
     * @type String
     * @final
     */
    CN.ID_SUFFIX = "_nav";
    /**
     * The suffix added to the Navigator's ID, to generate
     * a unique ID for the month control.
     * @property YAHOO.widget.CalendarNavigator.MONTH_SUFFIX
     * @static
     * @type String 
     * @final
     */
    CN.MONTH_SUFFIX = "_month";
    /**
     * The suffix added to the Navigator's ID, to generate
     * a unique ID for the year control.
     * @property YAHOO.widget.CalendarNavigator.YEAR_SUFFIX
     * @static
     * @type String
     * @final
     */
    CN.YEAR_SUFFIX = "_year";
    /**
     * The suffix added to the Navigator's ID, to generate
     * a unique ID for the error bounding box.
     * @property YAHOO.widget.CalendarNavigator.ERROR_SUFFIX
     * @static
     * @type String
     * @final
     */
    CN.ERROR_SUFFIX = "_error";
    /**
     * The suffix added to the Navigator's ID, to generate
     * a unique ID for the "Cancel" button.
     * @property YAHOO.widget.CalendarNavigator.CANCEL_SUFFIX
     * @static
     * @type String
     * @final
     */
    CN.CANCEL_SUFFIX = "_cancel";
    /**
     * The suffix added to the Navigator's ID, to generate
     * a unique ID for the "Submit" button.
     * @property YAHOO.widget.CalendarNavigator.SUBMIT_SUFFIX
     * @static
     * @type String
     * @final
     */
    CN.SUBMIT_SUFFIX = "_submit";

    /**
     * The number of digits to which the year input control is to be limited.
     * @property YAHOO.widget.CalendarNavigator.YR_MAX_DIGITS
     * @static
     * @type Number
     */
    CN.YR_MAX_DIGITS = 4;

    /**
     * The amount by which to increment the current year value,
     * when the arrow up/down key is pressed on the year control
     * @property YAHOO.widget.CalendarNavigator.YR_MINOR_INC
     * @static
     * @type Number
     */
    CN.YR_MINOR_INC = 1;

    /**
     * The amount by which to increment the current year value,
     * when the page up/down key is pressed on the year control
     * @property YAHOO.widget.CalendarNavigator.YR_MAJOR_INC
     * @static
     * @type Number
     */
    CN.YR_MAJOR_INC = 10;

    /**
     * Artificial delay (in ms) between the time the Navigator is hidden
     * and the Calendar/CalendarGroup state is updated. Allows the user
     * the see the Calendar/CalendarGroup page changing. If set to 0
     * the Calendar/CalendarGroup page will be updated instantly
     * @property YAHOO.widget.CalendarNavigator.UPDATE_DELAY
     * @static
     * @type Number
     */
    CN.UPDATE_DELAY = 50;

    /**
     * Regular expression used to validate the year input
     * @property YAHOO.widget.CalendarNavigator.YR_PATTERN
     * @static
     * @type RegExp
     */
    CN.YR_PATTERN = /^\d+$/;
    /**
     * Regular expression used to trim strings
     * @property YAHOO.widget.CalendarNavigator.TRIM
     * @static
     * @type RegExp
     */
    CN.TRIM = /^\s*(.*?)\s*$/;
})();

YAHOO.widget.CalendarNavigator.prototype = {

    /**
     * The unique ID for this CalendarNavigator instance
     * @property id
     * @type String
     */
    id : null,

    /**
     * The Calendar/CalendarGroup instance to which the navigator belongs
     * @property cal
     * @type {Calendar|CalendarGroup}
     */
    cal : null,

    /**
     * Reference to the HTMLElement used to render the navigator's bounding box
     * @property navEl
     * @type HTMLElement
     */
    navEl : null,

    /**
     * Reference to the HTMLElement used to render the navigator's mask
     * @property maskEl
     * @type HTMLElement
     */
    maskEl : null,

    /**
     * Reference to the HTMLElement used to input the year
     * @property yearEl
     * @type HTMLElement
     */
    yearEl : null,

    /**
     * Reference to the HTMLElement used to input the month
     * @property monthEl
     * @type HTMLElement
     */
    monthEl : null,

    /**
     * Reference to the HTMLElement used to display validation errors
     * @property errorEl
     * @type HTMLElement
     */
    errorEl : null,

    /**
     * Reference to the HTMLElement used to update the Calendar/Calendar group
     * with the month/year values
     * @property submitEl
     * @type HTMLElement
     */
    submitEl : null,
    
    /**
     * Reference to the HTMLElement used to hide the navigator without updating the 
     * Calendar/Calendar group
     * @property cancelEl
     * @type HTMLElement
     */
    cancelEl : null,

    /** 
     * Reference to the first focusable control in the navigator (by default monthEl)
     * @property firstCtrl
     * @type HTMLElement
     */
    firstCtrl : null,
    
    /** 
     * Reference to the last focusable control in the navigator (by default cancelEl)
     * @property lastCtrl
     * @type HTMLElement
     */
    lastCtrl : null,

    /**
     * The document containing the Calendar/Calendar group instance
     * @protected
     * @property _doc
     * @type HTMLDocument
     */
    _doc : null,

    /**
     * Internal state property for the current year displayed in the navigator
     * @protected
     * @property _year
     * @type Number
     */
    _year: null,
    
    /**
     * Internal state property for the current month index displayed in the navigator
     * @protected
     * @property _month
     * @type Number
     */
    _month: 0,

    /**
     * Private internal state property which indicates whether or not the 
     * Navigator has been rendered.
     * @private
     * @property __rendered
     * @type Boolean
     */
    __rendered: false,

    /**
     * Init lifecycle method called as part of construction
     * 
     * @method init
     * @param {Calendar} cal The instance of the Calendar or CalendarGroup to which this CalendarNavigator should be attached
     */
    init : function(cal) {
        var calBox = cal.oDomContainer;

        this.cal = cal;
        this.id = calBox.id + YAHOO.widget.CalendarNavigator.ID_SUFFIX;
        this._doc = calBox.ownerDocument;

        /**
         * Private flag, to identify IE Quirks
         * @private
         * @property __isIEQuirks
         */
        var ie = YAHOO.env.ua.ie;
        this.__isIEQuirks = (ie && ((ie <= 6) || (this._doc.compatMode == "BackCompat")));
    },

    /**
     * Displays the navigator and mask, updating the input controls to reflect the 
     * currently set month and year. The show method will invoke the render method
     * if the navigator has not been renderered already, allowing for lazy rendering
     * of the control.
     * 
     * The show method will fire the Calendar/CalendarGroup's beforeShowNav and showNav events
     * 
     * @method show
     */
    show : function() {
        var CLASSES = YAHOO.widget.CalendarNavigator.CLASSES;

        if (this.cal.beforeShowNavEvent.fire()) {
            if (!this.__rendered) {
                this.render();
            }
            this.clearErrors();

            this._updateMonthUI();
            this._updateYearUI();
            this._show(this.navEl, true);

            this.setInitialFocus();
            this.showMask();

            YAHOO.util.Dom.addClass(this.cal.oDomContainer, CLASSES.NAV_VISIBLE);
            this.cal.showNavEvent.fire();
        }
    },

    /**
     * Hides the navigator and mask
     * 
     * The show method will fire the Calendar/CalendarGroup's beforeHideNav event and hideNav events
     * @method hide
     */
    hide : function() {
        var CLASSES = YAHOO.widget.CalendarNavigator.CLASSES;

        if (this.cal.beforeHideNavEvent.fire()) {
            this._show(this.navEl, false);
            this.hideMask();
            YAHOO.util.Dom.removeClass(this.cal.oDomContainer, CLASSES.NAV_VISIBLE);
            this.cal.hideNavEvent.fire();
        }
    },
    

    /**
     * Displays the navigator's mask element
     * 
     * @method showMask
     */
    showMask : function() {
        this._show(this.maskEl, true);
        if (this.__isIEQuirks) {
            this._syncMask();
        }
    },

    /**
     * Hides the navigator's mask element
     * 
     * @method hideMask
     */
    hideMask : function() {
        this._show(this.maskEl, false);
    },

    /**
     * Returns the current month set on the navigator
     * 
     * Note: This may not be the month set in the UI, if 
     * the UI contains an invalid value.
     * 
     * @method getMonth
     * @return {Number} The Navigator's current month index
     */
    getMonth: function() {
        return this._month;
    },

    /**
     * Returns the current year set on the navigator
     * 
     * Note: This may not be the year set in the UI, if 
     * the UI contains an invalid value.
     * 
     * @method getYear
     * @return {Number} The Navigator's current year value
     */
    getYear: function() {
        return this._year;
    },

    /**
     * Sets the current month on the Navigator, and updates the UI
     * 
     * @method setMonth
     * @param {Number} nMonth The month index, from 0 (Jan) through 11 (Dec).
     */
    setMonth : function(nMonth) {
        if (nMonth >= 0 && nMonth < 12) {
            this._month = nMonth;
        }
        this._updateMonthUI();
    },

    /**
     * Sets the current year on the Navigator, and updates the UI. If the 
     * provided year is invalid, it will not be set.
     * 
     * @method setYear
     * @param {Number} nYear The full year value to set the Navigator to.
     */
    setYear : function(nYear) {
        var yrPattern = YAHOO.widget.CalendarNavigator.YR_PATTERN;
        if (YAHOO.lang.isNumber(nYear) && yrPattern.test(nYear+"")) {
            this._year = nYear;
        }
        this._updateYearUI();
    },

    /**
     * Renders the HTML for the navigator, adding it to the 
     * document and attaches event listeners if it has not 
     * already been rendered.
     * 
     * @method render
     */
    render: function() {
        this.cal.beforeRenderNavEvent.fire();
        if (!this.__rendered) {
            this.createNav();
            this.createMask();
            this.applyListeners();
            this.__rendered = true;
        }
        this.cal.renderNavEvent.fire();
    },

    /**
     * Creates the navigator's containing HTMLElement, it's contents, and appends 
     * the containg element to the Calendar/CalendarGroup's container.
     * 
     * @method createNav
     */
    createNav : function() {
        var NAV = YAHOO.widget.CalendarNavigator;
        var doc = this._doc;

        var d = doc.createElement("div");
        d.className = NAV.CLASSES.NAV;

        var htmlBuf = this.renderNavContents([]);

        d.innerHTML = htmlBuf.join('');
        this.cal.oDomContainer.appendChild(d);

        this.navEl = d;

        this.yearEl = doc.getElementById(this.id + NAV.YEAR_SUFFIX);
        this.monthEl = doc.getElementById(this.id + NAV.MONTH_SUFFIX);
        this.errorEl = doc.getElementById(this.id + NAV.ERROR_SUFFIX);
        this.submitEl = doc.getElementById(this.id + NAV.SUBMIT_SUFFIX);
        this.cancelEl = doc.getElementById(this.id + NAV.CANCEL_SUFFIX);

        if (YAHOO.env.ua.gecko && this.yearEl && this.yearEl.type == "text") {
            // Avoid XUL error on focus, select [ https://bugzilla.mozilla.org/show_bug.cgi?id=236791, 
            // supposedly fixed in 1.8.1, but there are reports of it still being around for methods other than blur ]
            this.yearEl.setAttribute("autocomplete", "off");
        }

        this._setFirstLastElements();
    },

    /**
     * Creates the Mask HTMLElement and appends it to the Calendar/CalendarGroups
     * container.
     * 
     * @method createMask
     */
    createMask : function() {
        var C = YAHOO.widget.CalendarNavigator.CLASSES;

        var d = this._doc.createElement("div");
        d.className = C.MASK;

        this.cal.oDomContainer.appendChild(d);
        this.maskEl = d;
    },

    /**
     * Used to set the width/height of the mask in pixels to match the Calendar Container.
     * Currently only used for IE6 or IE in quirks mode. The other A-Grade browser are handled using CSS (width/height 100%).
     * <p>
     * The method is also registered as an HTMLElement resize listener on the Calendars container element.
     * </p>
     * @protected
     * @method _syncMask
     */
    _syncMask : function() {
        var c = this.cal.oDomContainer;
        if (c && this.maskEl) {
            var r = YAHOO.util.Dom.getRegion(c);
            YAHOO.util.Dom.setStyle(this.maskEl, "width", r.right - r.left + "px");
            YAHOO.util.Dom.setStyle(this.maskEl, "height", r.bottom - r.top + "px");
        }
    },

    /**
     * Renders the contents of the navigator. NOTE: The contents of the array passed into this method are added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.
     * 
     * @method renderNavContents
     * 
     * @param {HTML[]} html The HTML buffer to append the HTML to.
     * @return {HTML[]} A reference to the buffer passed in.
     */
    renderNavContents : function(html) {
        var NAV = YAHOO.widget.CalendarNavigator,
            C = NAV.CLASSES,
            h = html; // just to use a shorter name

        h[h.length] = '<div class="' + C.MONTH + '">';
        this.renderMonth(h);
        h[h.length] = '</div>';
        h[h.length] = '<div class="' + C.YEAR + '">';
        this.renderYear(h);
        h[h.length] = '</div>';
        h[h.length] = '<div class="' + C.BUTTONS + '">';
        this.renderButtons(h);
        h[h.length] = '</div>';
        h[h.length] = '<div class="' + C.ERROR + '" id="' + this.id + NAV.ERROR_SUFFIX + '"></div>';

        return h;
    },

    /**
     * Renders the month label and control for the navigator. NOTE: The contents of the array passed into this method are added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.
     * 
     * @method renderNavContents
     * @param {HTML[]} html The HTML buffer to append the HTML to.
     * @return {HTML[]} A reference to the buffer passed in.
     */
    renderMonth : function(html) {
        var NAV = YAHOO.widget.CalendarNavigator,
            C = NAV.CLASSES;

        var id = this.id + NAV.MONTH_SUFFIX,
            mf = this.__getCfg("monthFormat"),
            months = this.cal.cfg.getProperty((mf == YAHOO.widget.Calendar.SHORT) ? "MONTHS_SHORT" : "MONTHS_LONG"),
            h = html;

        if (months && months.length > 0) {
            h[h.length] = '<label for="' + id + '">';
            h[h.length] = this.__getCfg("month", true);
            h[h.length] = '</label>';
            h[h.length] = '<select name="' + id + '" id="' + id + '" class="' + C.MONTH_CTRL + '">';
            for (var i = 0; i < months.length; i++) {
                h[h.length] = '<option value="' + i + '">';
                h[h.length] = months[i];
                h[h.length] = '</option>';
            }
            h[h.length] = '</select>';
        }
        return h;
    },

    /**
     * Renders the year label and control for the navigator. NOTE: The contents of the array passed into this method are added to the DOM as HTML, and should be escaped by the implementor if coming from an external source. 
     * 
     * @method renderYear
     * @param {Array} html The HTML buffer to append the HTML to.
     * @return {Array} A reference to the buffer passed in.
     */
    renderYear : function(html) {
        var NAV = YAHOO.widget.CalendarNavigator,
            C = NAV.CLASSES;

        var id = this.id + NAV.YEAR_SUFFIX,
            size = NAV.YR_MAX_DIGITS,
            h = html;

        h[h.length] = '<label for="' + id + '">';
        h[h.length] = this.__getCfg("year", true);
        h[h.length] = '</label>';
        h[h.length] = '<input type="text" name="' + id + '" id="' + id + '" class="' + C.YEAR_CTRL + '" maxlength="' + size + '"/>';
        return h;
    },

    /**
     * Renders the submit/cancel buttons for the navigator. NOTE: The contents of the array passed into this method are added to the DOM as HTML, and should be escaped by the implementor if coming from an external source.
     * 
     * @method renderButtons
     * @param {Array} html The HTML buffer to append the HTML to.
     * @return {Array} A reference to the buffer passed in.
     */
    renderButtons : function(html) {
        var C = YAHOO.widget.CalendarNavigator.CLASSES;
        var h = html;

        h[h.length] = '<span class="' + C.BUTTON + ' ' + C.DEFAULT + '">';
        h[h.length] = '<button type="button" id="' + this.id + '_submit' + '">';
        h[h.length] = this.__getCfg("submit", true);
        h[h.length] = '</button>';
        h[h.length] = '</span>';
        h[h.length] = '<span class="' + C.BUTTON +'">';
        h[h.length] = '<button type="button" id="' + this.id + '_cancel' + '">';
        h[h.length] = this.__getCfg("cancel", true);
        h[h.length] = '</button>';
        h[h.length] = '</span>';

        return h;
    },

    /**
     * Attaches DOM event listeners to the rendered elements
     * <p>
     * The method will call applyKeyListeners, to setup keyboard specific 
     * listeners
     * </p>
     * @method applyListeners
     */
    applyListeners : function() {
        var E = YAHOO.util.Event;

        function yearUpdateHandler() {
            if (this.validate()) {
                this.setYear(this._getYearFromUI());
            }
        }

        function monthUpdateHandler() {
            this.setMonth(this._getMonthFromUI());
        }

        E.on(this.submitEl, "click", this.submit, this, true);
        E.on(this.cancelEl, "click", this.cancel, this, true);
        E.on(this.yearEl, "blur", yearUpdateHandler, this, true);
        E.on(this.monthEl, "change", monthUpdateHandler, this, true);

        if (this.__isIEQuirks) {
            YAHOO.util.Event.on(this.cal.oDomContainer, "resize", this._syncMask, this, true);
        }

        this.applyKeyListeners();
    },

    /**
     * Removes/purges DOM event listeners from the rendered elements
     * 
     * @method purgeListeners
     */
    purgeListeners : function() {
        var E = YAHOO.util.Event;
        E.removeListener(this.submitEl, "click", this.submit);
        E.removeListener(this.cancelEl, "click", this.cancel);
        E.removeListener(this.yearEl, "blur");
        E.removeListener(this.monthEl, "change");
        if (this.__isIEQuirks) {
            E.removeListener(this.cal.oDomContainer, "resize", this._syncMask);
        }

        this.purgeKeyListeners();
    },

    /**
     * Attaches DOM listeners for keyboard support. 
     * Tab/Shift-Tab looping, Enter Key Submit on Year element,
     * Up/Down/PgUp/PgDown year increment on Year element
     * <p>
     * NOTE: MacOSX Safari 2.x doesn't let you tab to buttons and 
     * MacOSX Gecko does not let you tab to buttons or select controls,
     * so for these browsers, Tab/Shift-Tab looping is limited to the 
     * elements which can be reached using the tab key.
     * </p>
     * @method applyKeyListeners
     */
    applyKeyListeners : function() {
        var E = YAHOO.util.Event,
            ua = YAHOO.env.ua;

        // IE/Safari 3.1 doesn't fire keypress for arrow/pg keys (non-char keys)
        var arrowEvt = (ua.ie || ua.webkit) ? "keydown" : "keypress";

        // - IE/Safari 3.1 doesn't fire keypress for non-char keys
        // - Opera doesn't allow us to cancel keydown or keypress for tab, but 
        //   changes focus successfully on keydown (keypress is too late to change focus - opera's already moved on).
        var tabEvt = (ua.ie || ua.opera || ua.webkit) ? "keydown" : "keypress";

        // Everyone likes keypress for Enter (char keys) - whoo hoo!
        E.on(this.yearEl, "keypress", this._handleEnterKey, this, true);

        E.on(this.yearEl, arrowEvt, this._handleDirectionKeys, this, true);
        E.on(this.lastCtrl, tabEvt, this._handleTabKey, this, true);
        E.on(this.firstCtrl, tabEvt, this._handleShiftTabKey, this, true);
    },

    /**
     * Removes/purges DOM listeners for keyboard support
     *
     * @method purgeKeyListeners
     */
    purgeKeyListeners : function() {
        var E = YAHOO.util.Event,
            ua = YAHOO.env.ua;

        var arrowEvt = (ua.ie || ua.webkit) ? "keydown" : "keypress";
        var tabEvt = (ua.ie || ua.opera || ua.webkit) ? "keydown" : "keypress";

        E.removeListener(this.yearEl, "keypress", this._handleEnterKey);
        E.removeListener(this.yearEl, arrowEvt, this._handleDirectionKeys);
        E.removeListener(this.lastCtrl, tabEvt, this._handleTabKey);
        E.removeListener(this.firstCtrl, tabEvt, this._handleShiftTabKey);
    },

    /**
     * Updates the Calendar/CalendarGroup's pagedate with the currently set month and year if valid.
     * <p>
     * If the currently set month/year is invalid, a validation error will be displayed and the 
     * Calendar/CalendarGroup's pagedate will not be updated.
     * </p>
     * @method submit
     */
    submit : function() {
        if (this.validate()) {
            this.hide();

            this.setMonth(this._getMonthFromUI());
            this.setYear(this._getYearFromUI());

            var cal = this.cal;

            // Artificial delay, just to help the user see something changed
            var delay = YAHOO.widget.CalendarNavigator.UPDATE_DELAY;
            if (delay > 0) {
                var nav = this;
                window.setTimeout(function(){ nav._update(cal); }, delay);
            } else {
                this._update(cal);
            }
        }
    },

    /**
     * Updates the Calendar rendered state, based on the state of the CalendarNavigator
     * @method _update
     * @param cal The Calendar instance to update
     * @protected
     */
    _update : function(cal) {
        var date = YAHOO.widget.DateMath.getDate(this.getYear() - cal.cfg.getProperty("YEAR_OFFSET"), this.getMonth(), 1);
        cal.cfg.setProperty("pagedate", date);
        cal.render();
    },

    /**
     * Hides the navigator and mask, without updating the Calendar/CalendarGroup's state
     * 
     * @method cancel
     */
    cancel : function() {
        this.hide();
    },

    /**
     * Validates the current state of the UI controls
     * 
     * @method validate
     * @return {Boolean} true, if the current UI state contains valid values, false if not
     */
    validate : function() {
        if (this._getYearFromUI() !== null) {
            this.clearErrors();
            return true;
        } else {
            this.setYearError();
            this.setError(this.__getCfg("invalidYear", true));
            return false;
        }
    },

    /**
     * Displays an error message in the Navigator's error panel.
     * 
     * @method setError
     * @param {HTML} msg The markup for the error message to display. NOTE: The msg passed into this method is added to the DOM as HTML, and should be escaped by the implementor if coming from an external source. 
     */
    setError : function(msg) {
        if (this.errorEl) {
            this.errorEl.innerHTML = msg;
            this._show(this.errorEl, true);
        }
    },

    /**
     * Clears the navigator's error message and hides the error panel
     * @method clearError 
     */
    clearError : function() {
        if (this.errorEl) {
            this.errorEl.innerHTML = "";
            this._show(this.errorEl, false);
        }
    },

    /**
     * Displays the validation error UI for the year control
     * @method setYearError
     */
    setYearError : function() {
        YAHOO.util.Dom.addClass(this.yearEl, YAHOO.widget.CalendarNavigator.CLASSES.INVALID);
    },

    /**
     * Removes the validation error UI for the year control
     * @method clearYearError
     */
    clearYearError : function() {
        YAHOO.util.Dom.removeClass(this.yearEl, YAHOO.widget.CalendarNavigator.CLASSES.INVALID);
    },

    /**
     * Clears all validation and error messages in the UI
     * @method clearErrors
     */
    clearErrors : function() {
        this.clearError();
        this.clearYearError();
    },

    /**
     * Sets the initial focus, based on the configured value
     * @method setInitialFocus
     */
    setInitialFocus : function() {
        var el = this.submitEl,
            f = this.__getCfg("initialFocus");

        if (f && f.toLowerCase) {
            f = f.toLowerCase();
            if (f == "year") {
                el = this.yearEl;
                try {
                    this.yearEl.select();
                } catch (selErr) {
                    // Ignore;
                }
            } else if (f == "month") {
                el = this.monthEl;
            }
        }

        if (el && YAHOO.lang.isFunction(el.focus)) {
            try {
                el.focus();
            } catch (focusErr) {
                // TODO: Fall back if focus fails?
            }
        }
    },

    /**
     * Removes all renderered HTML elements for the Navigator from
     * the DOM, purges event listeners and clears (nulls) any property
     * references to HTML references
     * @method erase
     */
    erase : function() {
        if (this.__rendered) {
            this.purgeListeners();

            // Clear out innerHTML references
            this.yearEl = null;
            this.monthEl = null;
            this.errorEl = null;
            this.submitEl = null;
            this.cancelEl = null;
            this.firstCtrl = null;
            this.lastCtrl = null;
            if (this.navEl) {
                this.navEl.innerHTML = "";
            }

            var p = this.navEl.parentNode;
            if (p) {
                p.removeChild(this.navEl);
            }
            this.navEl = null;

            var pm = this.maskEl.parentNode;
            if (pm) {
                pm.removeChild(this.maskEl);
            }
            this.maskEl = null;
            this.__rendered = false;
        }
    },

    /**
     * Destroys the Navigator object and any HTML references
     * @method destroy
     */
    destroy : function() {
        this.erase();
        this._doc = null;
        this.cal = null;
        this.id = null;
    },

    /**
     * Protected implementation to handle how UI elements are 
     * hidden/shown.
     *
     * @method _show
     * @protected
     */
    _show : function(el, bShow) {
        if (el) {
            YAHOO.util.Dom.setStyle(el, "display", (bShow) ? "block" : "none");
        }
    },

    /**
     * Returns the month value (index), from the month UI element
     * @protected
     * @method _getMonthFromUI
     * @return {Number} The month index, or 0 if a UI element for the month
     * is not found
     */
    _getMonthFromUI : function() {
        if (this.monthEl) {
            return this.monthEl.selectedIndex;
        } else {
            return 0; // Default to Jan
        }
    },

    /**
     * Returns the year value, from the Navitator's year UI element
     * @protected
     * @method _getYearFromUI
     * @return {Number} The year value set in the UI, if valid. null is returned if 
     * the UI does not contain a valid year value.
     */
    _getYearFromUI : function() {
        var NAV = YAHOO.widget.CalendarNavigator;

        var yr = null;
        if (this.yearEl) {
            var value = this.yearEl.value;
            value = value.replace(NAV.TRIM, "$1");

            if (NAV.YR_PATTERN.test(value)) {
                yr = parseInt(value, 10);
            }
        }
        return yr;
    },

    /**
     * Updates the Navigator's year UI, based on the year value set on the Navigator object
     * @protected
     * @method _updateYearUI
     */
    _updateYearUI : function() {
        if (this.yearEl && this._year !== null) {
            this.yearEl.value = this._year;
        }
    },

    /**
     * Updates the Navigator's month UI, based on the month value set on the Navigator object
     * @protected
     * @method _updateMonthUI
     */
    _updateMonthUI : function() {
        if (this.monthEl) {
            this.monthEl.selectedIndex = this._month;
        }
    },

    /**
     * Sets up references to the first and last focusable element in the Navigator's UI
     * in terms of tab order (Naviagator's firstEl and lastEl properties). The references
     * are used to control modality by looping around from the first to the last control
     * and visa versa for tab/shift-tab navigation.
     * <p>
     * See <a href="#applyKeyListeners">applyKeyListeners</a>
     * </p>
     * @protected
     * @method _setFirstLastElements
     */
    _setFirstLastElements : function() {
        this.firstCtrl = this.monthEl;
        this.lastCtrl = this.cancelEl;

        // Special handling for MacOSX.
        // - Safari 2.x can't focus on buttons
        // - Gecko can't focus on select boxes or buttons
        if (this.__isMac) {
            if (YAHOO.env.ua.webkit && YAHOO.env.ua.webkit < 420){
                this.firstCtrl = this.monthEl;
                this.lastCtrl = this.yearEl;
            }
            if (YAHOO.env.ua.gecko) {
                this.firstCtrl = this.yearEl;
                this.lastCtrl = this.yearEl;
            }
        }
    },

    /**
     * Default Keyboard event handler to capture Enter 
     * on the Navigator's year control (yearEl)
     * 
     * @method _handleEnterKey
     * @protected
     * @param {Event} e The DOM event being handled
     */
    _handleEnterKey : function(e) {
        var KEYS = YAHOO.util.KeyListener.KEY;

        if (YAHOO.util.Event.getCharCode(e) == KEYS.ENTER) {
            YAHOO.util.Event.preventDefault(e);
            this.submit();
        }
    },

    /**
     * Default Keyboard event handler to capture up/down/pgup/pgdown
     * on the Navigator's year control (yearEl).
     * 
     * @method _handleDirectionKeys
     * @protected
     * @param {Event} e The DOM event being handled
     */
    _handleDirectionKeys : function(e) {
        var E = YAHOO.util.Event,
            KEYS = YAHOO.util.KeyListener.KEY,
            NAV = YAHOO.widget.CalendarNavigator;

        var value = (this.yearEl.value) ? parseInt(this.yearEl.value, 10) : null;
        if (isFinite(value)) {
            var dir = false;
            switch(E.getCharCode(e)) {
                case KEYS.UP:
                    this.yearEl.value = value + NAV.YR_MINOR_INC;
                    dir = true;
                    break;
                case KEYS.DOWN:
                    this.yearEl.value = Math.max(value - NAV.YR_MINOR_INC, 0);
                    dir = true;
                    break;
                case KEYS.PAGE_UP:
                    this.yearEl.value = value + NAV.YR_MAJOR_INC;
                    dir = true;
                    break;
                case KEYS.PAGE_DOWN:
                    this.yearEl.value = Math.max(value - NAV.YR_MAJOR_INC, 0);
                    dir = true;
                    break;
                default:
                    break;
            }
            if (dir) {
                E.preventDefault(e);
                try {
                    this.yearEl.select();
                } catch(err) {
                    // Ignore
                }
            }
        }
    },

    /**
     * Default Keyboard event handler to capture Tab 
     * on the last control (lastCtrl) in the Navigator.
     * 
     * @method _handleTabKey
     * @protected
     * @param {Event} e The DOM event being handled
     */
    _handleTabKey : function(e) {
        var E = YAHOO.util.Event,
            KEYS = YAHOO.util.KeyListener.KEY;

        if (E.getCharCode(e) == KEYS.TAB && !e.shiftKey) {
            try {
                E.preventDefault(e);
                this.firstCtrl.focus();
            } catch (err) {
                // Ignore - mainly for focus edge cases
            }
        }
    },

    /**
     * Default Keyboard event handler to capture Shift-Tab 
     * on the first control (firstCtrl) in the Navigator.
     * 
     * @method _handleShiftTabKey
     * @protected
     * @param {Event} e The DOM event being handled
     */
    _handleShiftTabKey : function(e) {
        var E = YAHOO.util.Event,
            KEYS = YAHOO.util.KeyListener.KEY;

        if (e.shiftKey && E.getCharCode(e) == KEYS.TAB) {
            try {
                E.preventDefault(e);
                this.lastCtrl.focus();
            } catch (err) {
                // Ignore - mainly for focus edge cases
            }
        }
    },

    /**
     * Retrieve Navigator configuration values from 
     * the parent Calendar/CalendarGroup's config value.
     * <p>
     * If it has not been set in the user provided configuration, the method will 
     * return the default value of the configuration property, as set in DEFAULT_CONFIG
     * </p>
     * @private
     * @method __getCfg
     * @param {String} Case sensitive property name.
     * @param {Boolean} true, if the property is a string property, false if not.
     * @return The value of the configuration property
     */
    __getCfg : function(prop, bIsStr) {
        var DEF_CFG = YAHOO.widget.CalendarNavigator.DEFAULT_CONFIG;
        var cfg = this.cal.cfg.getProperty("navigator");

        if (bIsStr) {
            return (cfg !== true && cfg.strings && cfg.strings[prop]) ? cfg.strings[prop] : DEF_CFG.strings[prop];
        } else {
            return (cfg !== true && cfg[prop]) ? cfg[prop] : DEF_CFG[prop];
        }
    },

    /**
     * Private flag, to identify MacOS
     * @private
     * @property __isMac
     */
    __isMac : (navigator.userAgent.toLowerCase().indexOf("macintosh") != -1)

};
YAHOO.register("calendar", YAHOO.widget.Calendar, {version: "2.9.0", build: "2800"});
// End of File include/javascript/yui/build/calendar/calendar.js
                                
