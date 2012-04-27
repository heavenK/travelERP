﻿/*
DezinerFolio.com Simple Accordians.

Author  : G.S.Navin Raj Kumar
Website : http://dezinerfolio.com

*/

/*
* The Variable names have been compressed to achive a higher level of compression.
*/

// Prototype Method to get the element based on ID
function $(d){
	return document.getElementById(d);
}

// set or get the current display style of the div
function dsp(d,v){
    if(d)
    {
	    if(v==undefined){
		    return d.style.display;
	    }else{
		    d.style.display=v;
	    }
	}
}

// set or get the height of a div.
function sh(d,v){
	// if you are getting the height then display must be block to return the absolute height
	if(v==undefined){
		if(dsp(d)!='none'&& dsp(d)!=''){
			return d.offsetHeight;
		}
		viz = d.style.visibility;
		d.style.visibility = 'hidden';
		o = dsp(d);
		dsp(d,'block');
		r = parseInt(d.offsetHeight);
		dsp(d,o);
		d.style.visibility = viz;
		return r;
	}else{
		d.style.height=v;
	}
}
/*
* Variable 'S' defines the speed of the accordian
* Variable 'T' defines the refresh rate of the accordian
*/
s=7;
t=10;

//Collapse Timer is triggered as a setInterval to reduce the height of the div exponentially.
function ct(d){
	d = $(d);
	if(d)
	{
	    if(sh(d)>0){
		    v = Math.round(sh(d)/d.s);
		    v = (v<1) ? 1 :v ;
		    v = (sh(d)-v);
		    sh(d,v+'px');
		    d.style.opacity = (v/d.maxh);
		    d.style.filter= 'alpha(opacity='+(v*100/d.maxh)+');';
	    }else{
		    sh(d,0);
		    dsp(d,'none');
		    clearInterval(d.t);
		    d.t=0;
		    $(d.id.replace('content','plus')).style.display='';
	    }
	}
}

//Expand Timer is triggered as a setInterval to increase the height of the div exponentially.
function et(d){
	d = $(d);
	if(sh(d)<d.maxh){
		v = Math.round((d.maxh-sh(d))/d.s);
		v = (v<1) ? 1 :v ;
		v = (sh(d)+v);
		sh(d,v+'px');
		d.style.opacity = (v/d.maxh);
		d.style.filter= 'alpha(opacity='+(v*100/d.maxh)+');';
	}else{
		sh(d,d.maxh);
		clearInterval(d.t);
		d.t=0;
	}
}

// Collapse Initializer
function cl(d){
	if(dsp(d)=='block'){
		clearInterval(d.t);
		d.t=setInterval('ct("'+d.id+'")',t);
	}
}

//Expand Initializer
function ex(d){
	if(dsp(d)=='none'){
		dsp(d,'block');
		d.style.height='0px';
		clearInterval(d.t);
		d.t=setInterval('et("'+d.id+'")',t);
	}
}

// Removes Classname from the given div.
function cc(n,v){
	s=n.className.split(/\s+/);
	for(p=0;p<s.length;p++){
		if(s[p]==v+n.tc){
			s.splice(p,1);
			n.className=s.join(' ');
			break;
		}
	}
}
//Accordian Initializer
function Accordian(d,s,tc){
	// get all the elements that have id as content
	l=$(d).getElementsByTagName('div');
	c=[];
	for(i=0;i<l.length;i++){
		h=l[i].id;
		if(h.substr(h.indexOf('-')+1,h.length)=='content'){c.push(h);}
	}
	sel=null;
	//then search through headers
	for(i=0;i<l.length;i++){
		h=l[i].id;
		if(h.substr(h.indexOf('-')+1,h.length)=='header'){
			d=$(h.substr(0,h.indexOf('-'))+'-content');
			if(d)
			{
			    d.style.display='none';
			    d.style.overflow='hidden';
			    d.maxh =sh(d);
			    d.s=(s==undefined)? 7 : s;
			}
			h=$(h);
			h.tc=tc;
			h.c=c;
			// set the onclick function for each header.
			if($(h.id.replace('-header','-plus')))
			{
			$(h.id.replace('-header','-plus')).onclick = function(){
                                var _this = $(this.id.replace('-plus','-header'));
				for(i=0;i<_this.c.length;i++){
					cn=_this.c[i];
					n=cn.substr(0,cn.indexOf('-'));
					if((n+'-header')==_this.id){
						ex($(n+'-content'));
						n=$(n+'-header');
						cc(n,'__');
						n.className=n.className+' '+n.tc;
					}else{
						//cl($(n+'-content'));
						//cc($(n+'-header'),'');
					}
				}
                                this.style.display='none';
                                //this.src="images/jjh-02.gif";
			}
			}
			if(h.className.match(/selected+/)!=undefined){ sel=h;}
		}
                h=l[i].id;
                if(h.substr(h.indexOf('-')+1,h.length)=='content')
                {
		            h=$(h.replace('-content','-minus'));
		            if(h)
		            {
                        h.onclick = function(){
                           var n = this.id.substr(0,this.id.indexOf('-'));
                           cl($(n+'-content'));
		           cc($(n+'-header'),'');
                        }
                    }
                }
	}
	if(sel!=undefined){sel.onclick();}
}