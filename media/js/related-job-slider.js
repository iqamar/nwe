// Related Job Slider Script Starts//
var q=null;window.PR_SHOULD_USE_CONTINUATION=!0;
(function(){function L(a){function m(a){var f=a.charCodeAt(0);if(f!==92)return f;var b=a.charAt(1);return(f=r[b])?f:"0"<=b&&b<="7"?parseInt(a.substring(1),8):b==="u"||b==="x"?parseInt(a.substring(2),16):a.charCodeAt(1)}function e(a){if(a<32)return(a<16?"\\x0":"\\x")+a.toString(16);a=String.fromCharCode(a);if(a==="\\"||a==="-"||a==="["||a==="]")a="\\"+a;return a}function h(a){for(var f=a.substring(1,a.length-1).match(/\\u[\dA-Fa-f]{4}|\\x[\dA-Fa-f]{2}|\\[0-3][0-7]{0,2}|\\[0-7]{1,2}|\\[\S\s]|[^\\]/g),a=
[],b=[],o=f[0]==="^",c=o?1:0,i=f.length;c<i;++c){var j=f[c];if(/\\[bdsw]/i.test(j))a.push(j);else{var j=m(j),d;c+2<i&&"-"===f[c+1]?(d=m(f[c+2]),c+=2):d=j;b.push([j,d]);d<65||j>122||(d<65||j>90||b.push([Math.max(65,j)|32,Math.min(d,90)|32]),d<97||j>122||b.push([Math.max(97,j)&-33,Math.min(d,122)&-33]))}}b.sort(function(a,f){return a[0]-f[0]||f[1]-a[1]});f=[];j=[NaN,NaN];for(c=0;c<b.length;++c)i=b[c],i[0]<=j[1]+1?j[1]=Math.max(j[1],i[1]):f.push(j=i);b=["["];o&&b.push("^");b.push.apply(b,a);for(c=0;c<
f.length;++c)i=f[c],b.push(e(i[0])),i[1]>i[0]&&(i[1]+1>i[0]&&b.push("-"),b.push(e(i[1])));b.push("]");return b.join("")}function y(a){for(var f=a.source.match(/\[(?:[^\\\]]|\\[\S\s])*]|\\u[\dA-Fa-f]{4}|\\x[\dA-Fa-f]{2}|\\\d+|\\[^\dux]|\(\?[!:=]|[()^]|[^()[\\^]+/g),b=f.length,d=[],c=0,i=0;c<b;++c){var j=f[c];j==="("?++i:"\\"===j.charAt(0)&&(j=+j.substring(1))&&j<=i&&(d[j]=-1)}for(c=1;c<d.length;++c)-1===d[c]&&(d[c]=++t);for(i=c=0;c<b;++c)j=f[c],j==="("?(++i,d[i]===void 0&&(f[c]="(?:")):"\\"===j.charAt(0)&&
(j=+j.substring(1))&&j<=i&&(f[c]="\\"+d[i]);for(i=c=0;c<b;++c)"^"===f[c]&&"^"!==f[c+1]&&(f[c]="");if(a.ignoreCase&&s)for(c=0;c<b;++c)j=f[c],a=j.charAt(0),j.length>=2&&a==="["?f[c]=h(j):a!=="\\"&&(f[c]=j.replace(/[A-Za-z]/g,function(a){a=a.charCodeAt(0);return"["+String.fromCharCode(a&-33,a|32)+"]"}));return f.join("")}for(var t=0,s=!1,l=!1,p=0,d=a.length;p<d;++p){var g=a[p];if(g.ignoreCase)l=!0;else if(/[a-z]/i.test(g.source.replace(/\\u[\da-f]{4}|\\x[\da-f]{2}|\\[^UXux]/gi,""))){s=!0;l=!1;break}}for(var r=
{b:8,t:9,n:10,v:11,f:12,r:13},n=[],p=0,d=a.length;p<d;++p){g=a[p];if(g.global||g.multiline)throw Error(""+g);n.push("(?:"+y(g)+")")}return RegExp(n.join("|"),l?"gi":"g")}function M(a){function m(a){switch(a.nodeType){case 1:if(e.test(a.className))break;for(var g=a.firstChild;g;g=g.nextSibling)m(g);g=a.nodeName;if("BR"===g||"LI"===g)h[s]="\n",t[s<<1]=y++,t[s++<<1|1]=a;break;case 3:case 4:g=a.nodeValue,g.length&&(g=p?g.replace(/\r\n?/g,"\n"):g.replace(/[\t\n\r ]+/g," "),h[s]=g,t[s<<1]=y,y+=g.length,
t[s++<<1|1]=a)}}var e=/(?:^|\s)nocode(?:\s|$)/,h=[],y=0,t=[],s=0,l;a.currentStyle?l=a.currentStyle.whiteSpace:window.getComputedStyle&&(l=document.defaultView.getComputedStyle(a,q).getPropertyValue("white-space"));var p=l&&"pre"===l.substring(0,3);m(a);return{a:h.join("").replace(/\n$/,""),c:t}}function B(a,m,e,h){m&&(a={a:m,d:a},e(a),h.push.apply(h,a.e))}function x(a,m){function e(a){for(var l=a.d,p=[l,"pln"],d=0,g=a.a.match(y)||[],r={},n=0,z=g.length;n<z;++n){var f=g[n],b=r[f],o=void 0,c;if(typeof b===
"string")c=!1;else{var i=h[f.charAt(0)];if(i)o=f.match(i[1]),b=i[0];else{for(c=0;c<t;++c)if(i=m[c],o=f.match(i[1])){b=i[0];break}o||(b="pln")}if((c=b.length>=5&&"lang-"===b.substring(0,5))&&!(o&&typeof o[1]==="string"))c=!1,b="src";c||(r[f]=b)}i=d;d+=f.length;if(c){c=o[1];var j=f.indexOf(c),k=j+c.length;o[2]&&(k=f.length-o[2].length,j=k-c.length);b=b.substring(5);B(l+i,f.substring(0,j),e,p);B(l+i+j,c,C(b,c),p);B(l+i+k,f.substring(k),e,p)}else p.push(l+i,b)}a.e=p}var h={},y;(function(){for(var e=a.concat(m),
l=[],p={},d=0,g=e.length;d<g;++d){var r=e[d],n=r[3];if(n)for(var k=n.length;--k>=0;)h[n.charAt(k)]=r;r=r[1];n=""+r;p.hasOwnProperty(n)||(l.push(r),p[n]=q)}l.push(/[\S\s]/);y=L(l)})();var t=m.length;return e}function u(a){var m=[],e=[];a.tripleQuotedStrings?m.push(["str",/^(?:'''(?:[^'\\]|\\[\S\s]|''?(?=[^']))*(?:'''|$)|"""(?:[^"\\]|\\[\S\s]|""?(?=[^"]))*(?:"""|$)|'(?:[^'\\]|\\[\S\s])*(?:'|$)|"(?:[^"\\]|\\[\S\s])*(?:"|$))/,q,"'\""]):a.multiLineStrings?m.push(["str",/^(?:'(?:[^'\\]|\\[\S\s])*(?:'|$)|"(?:[^"\\]|\\[\S\s])*(?:"|$)|`(?:[^\\`]|\\[\S\s])*(?:`|$))/,
q,"'\"`"]):m.push(["str",/^(?:'(?:[^\n\r'\\]|\\.)*(?:'|$)|"(?:[^\n\r"\\]|\\.)*(?:"|$))/,q,"\"'"]);a.verbatimStrings&&e.push(["str",/^@"(?:[^"]|"")*(?:"|$)/,q]);var h=a.hashComments;h&&(a.cStyleComments?(h>1?m.push(["com",/^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/,q,"#"]):m.push(["com",/^#(?:(?:define|elif|else|endif|error|ifdef|include|ifndef|line|pragma|undef|warning)\b|[^\n\r]*)/,q,"#"]),e.push(["str",/^<(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[\w-]+\.h|[a-z]\w*)>/,q])):m.push(["com",/^#[^\n\r]*/,
q,"#"]));a.cStyleComments&&(e.push(["com",/^\/\/[^\n\r]*/,q]),e.push(["com",/^\/\*[\S\s]*?(?:\*\/|$)/,q]));a.regexLiterals&&e.push(["lang-regex",/^(?:^^\.?|[!+-]|!=|!==|#|%|%=|&|&&|&&=|&=|\(|\*|\*=|\+=|,|-=|->|\/|\/=|:|::|;|<|<<|<<=|<=|=|==|===|>|>=|>>|>>=|>>>|>>>=|[?@[^]|\^=|\^\^|\^\^=|{|\||\|=|\|\||\|\|=|~|break|case|continue|delete|do|else|finally|instanceof|return|throw|try|typeof)\s*(\/(?=[^*/])(?:[^/[\\]|\\[\S\s]|\[(?:[^\\\]]|\\[\S\s])*(?:]|$))+\/)/]);(h=a.types)&&e.push(["typ",h]);a=(""+a.keywords).replace(/^ | $/g,
"");a.length&&e.push(["kwd",RegExp("^(?:"+a.replace(/[\s,]+/g,"|")+")\\b"),q]);m.push(["pln",/^\s+/,q," \r\n\t\xa0"]);e.push(["lit",/^@[$_a-z][\w$@]*/i,q],["typ",/^(?:[@_]?[A-Z]+[a-z][\w$@]*|\w+_t\b)/,q],["pln",/^[$_a-z][\w$@]*/i,q],["lit",/^(?:0x[\da-f]+|(?:\d(?:_\d+)*\d*(?:\.\d*)?|\.\d\+)(?:e[+-]?\d+)?)[a-z]*/i,q,"0123456789"],["pln",/^\\[\S\s]?/,q],["pun",/^.[^\s\w"-$'./@\\`]*/,q]);return x(m,e)}function D(a,m){function e(a){switch(a.nodeType){case 1:if(k.test(a.className))break;if("BR"===a.nodeName)h(a),
a.parentNode&&a.parentNode.removeChild(a);else for(a=a.firstChild;a;a=a.nextSibling)e(a);break;case 3:case 4:if(p){var b=a.nodeValue,d=b.match(t);if(d){var c=b.substring(0,d.index);a.nodeValue=c;(b=b.substring(d.index+d[0].length))&&a.parentNode.insertBefore(s.createTextNode(b),a.nextSibling);h(a);c||a.parentNode.removeChild(a)}}}}function h(a){function b(a,d){var e=d?a.cloneNode(!1):a,f=a.parentNode;if(f){var f=b(f,1),g=a.nextSibling;f.appendChild(e);for(var h=g;h;h=g)g=h.nextSibling,f.appendChild(h)}return e}
for(;!a.nextSibling;)if(a=a.parentNode,!a)return;for(var a=b(a.nextSibling,0),e;(e=a.parentNode)&&e.nodeType===1;)a=e;d.push(a)}var k=/(?:^|\s)nocode(?:\s|$)/,t=/\r\n?|\n/,s=a.ownerDocument,l;a.currentStyle?l=a.currentStyle.whiteSpace:window.getComputedStyle&&(l=s.defaultView.getComputedStyle(a,q).getPropertyValue("white-space"));var p=l&&"pre"===l.substring(0,3);for(l=s.createElement("LI");a.firstChild;)l.appendChild(a.firstChild);for(var d=[l],g=0;g<d.length;++g)e(d[g]);m===(m|0)&&d[0].setAttribute("value",
m);var r=s.createElement("OL");r.className="linenums";for(var n=Math.max(0,m-1|0)||0,g=0,z=d.length;g<z;++g)l=d[g],l.className="L"+(g+n)%10,l.firstChild||l.appendChild(s.createTextNode("\xa0")),r.appendChild(l);a.appendChild(r)}function k(a,m){for(var e=m.length;--e>=0;){var h=m[e];A.hasOwnProperty(h)?window.console&&console.warn("cannot override language handler %s",h):A[h]=a}}function C(a,m){if(!a||!A.hasOwnProperty(a))a=/^\s*</.test(m)?"default-markup":"default-code";return A[a]}function E(a){var m=
a.g;try{var e=M(a.h),h=e.a;a.a=h;a.c=e.c;a.d=0;C(m,h)(a);var k=/\bMSIE\b/.test(navigator.userAgent),m=/\n/g,t=a.a,s=t.length,e=0,l=a.c,p=l.length,h=0,d=a.e,g=d.length,a=0;d[g]=s;var r,n;for(n=r=0;n<g;)d[n]!==d[n+2]?(d[r++]=d[n++],d[r++]=d[n++]):n+=2;g=r;for(n=r=0;n<g;){for(var z=d[n],f=d[n+1],b=n+2;b+2<=g&&d[b+1]===f;)b+=2;d[r++]=z;d[r++]=f;n=b}for(d.length=r;h<p;){var o=l[h+2]||s,c=d[a+2]||s,b=Math.min(o,c),i=l[h+1],j;if(i.nodeType!==1&&(j=t.substring(e,b))){k&&(j=j.replace(m,"\r"));i.nodeValue=
j;var u=i.ownerDocument,v=u.createElement("SPAN");v.className=d[a+1];var x=i.parentNode;x.replaceChild(v,i);v.appendChild(i);e<o&&(l[h+1]=i=u.createTextNode(t.substring(b,o)),x.insertBefore(i,v.nextSibling))}e=b;e>=o&&(h+=2);e>=c&&(a+=2)}}catch(w){"console"in window&&console.log(w&&w.stack?w.stack:w)}}var v=["break,continue,do,else,for,if,return,while"],w=[[v,"auto,case,char,const,default,double,enum,extern,float,goto,int,long,register,short,signed,sizeof,static,struct,switch,typedef,union,unsigned,void,volatile"],
"catch,class,delete,false,import,new,operator,private,protected,public,this,throw,true,try,typeof"],F=[w,"alignof,align_union,asm,axiom,bool,concept,concept_map,const_cast,constexpr,decltype,dynamic_cast,explicit,export,friend,inline,late_check,mutable,namespace,nullptr,reinterpret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,where"],G=[w,"abstract,boolean,byte,extends,final,finally,implements,import,instanceof,null,native,package,strictfp,super,synchronized,throws,transient"],
H=[G,"as,base,by,checked,decimal,delegate,descending,dynamic,event,fixed,foreach,from,group,implicit,in,interface,internal,into,is,lock,object,out,override,orderby,params,partial,readonly,ref,sbyte,sealed,stackalloc,string,select,uint,ulong,unchecked,unsafe,ushort,var"],w=[w,"debugger,eval,export,function,get,null,set,undefined,var,with,Infinity,NaN"],I=[v,"and,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,is,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None"],
J=[v,"alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,module,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,until,when,yield,BEGIN,END"],v=[v,"case,done,elif,esac,eval,fi,function,in,local,set,then,until"],K=/^(DIR|FILE|vector|(de|priority_)?queue|list|stack|(const_)?iterator|(multi)?(set|map)|bitset|u?(int|float)\d*)/,N=/\S/,O=u({keywords:[F,H,w,"caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END"+
I,J,v],hashComments:!0,cStyleComments:!0,multiLineStrings:!0,regexLiterals:!0}),A={};k(O,["default-code"]);k(x([],[["pln",/^[^<?]+/],["dec",/^<!\w[^>]*(?:>|$)/],["com",/^<\!--[\S\s]*?(?:--\>|$)/],["lang-",/^<\?([\S\s]+?)(?:\?>|$)/],["lang-",/^<%([\S\s]+?)(?:%>|$)/],["pun",/^(?:<[%?]|[%?]>)/],["lang-",/^<xmp\b[^>]*>([\S\s]+?)<\/xmp\b[^>]*>/i],["lang-js",/^<script\b[^>]*>([\S\s]*?)(<\/script\b[^>]*>)/i],["lang-css",/^<style\b[^>]*>([\S\s]*?)(<\/style\b[^>]*>)/i],["lang-in.tag",/^(<\/?[a-z][^<>]*>)/i]]),
["default-markup","htm","html","mxml","xhtml","xml","xsl"]);k(x([["pln",/^\s+/,q," \t\r\n"],["atv",/^(?:"[^"]*"?|'[^']*'?)/,q,"\"'"]],[["tag",/^^<\/?[a-z](?:[\w-.:]*\w)?|\/?>$/i],["atn",/^(?!style[\s=]|on)[a-z](?:[\w:-]*\w)?/i],["lang-uq.val",/^=\s*([^\s"'>]*(?:[^\s"'/>]|\/(?=\s)))/],["pun",/^[/<->]+/],["lang-js",/^on\w+\s*=\s*"([^"]+)"/i],["lang-js",/^on\w+\s*=\s*'([^']+)'/i],["lang-js",/^on\w+\s*=\s*([^\s"'>]+)/i],["lang-css",/^style\s*=\s*"([^"]+)"/i],["lang-css",/^style\s*=\s*'([^']+)'/i],["lang-css",
/^style\s*=\s*([^\s"'>]+)/i]]),["in.tag"]);k(x([],[["atv",/^[\S\s]+/]]),["uq.val"]);k(u({keywords:F,hashComments:!0,cStyleComments:!0,types:K}),["c","cc","cpp","cxx","cyc","m"]);k(u({keywords:"null,true,false"}),["json"]);k(u({keywords:H,hashComments:!0,cStyleComments:!0,verbatimStrings:!0,types:K}),["cs"]);k(u({keywords:G,cStyleComments:!0}),["java"]);k(u({keywords:v,hashComments:!0,multiLineStrings:!0}),["bsh","csh","sh"]);k(u({keywords:I,hashComments:!0,multiLineStrings:!0,tripleQuotedStrings:!0}),
["cv","py"]);k(u({keywords:"caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END",hashComments:!0,multiLineStrings:!0,regexLiterals:!0}),["perl","pl","pm"]);k(u({keywords:J,hashComments:!0,multiLineStrings:!0,regexLiterals:!0}),["rb"]);k(u({keywords:w,cStyleComments:!0,regexLiterals:!0}),["js"]);k(u({keywords:"all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isnt,loop,new,no,not,null,of,off,on,or,return,super,then,true,try,unless,until,when,while,yes",
hashComments:3,cStyleComments:!0,multilineStrings:!0,tripleQuotedStrings:!0,regexLiterals:!0}),["coffee"]);k(x([],[["str",/^[\S\s]+/]]),["regex"]);window.prettyPrintOne=function(a,m,e){var h=document.createElement("PRE");h.innerHTML=a;e&&D(h,e);E({g:m,i:e,h:h});return h.innerHTML};window.prettyPrint=function(a){function m(){for(var e=window.PR_SHOULD_USE_CONTINUATION?l.now()+250:Infinity;p<h.length&&l.now()<e;p++){var n=h[p],k=n.className;if(k.indexOf("prettyprint")>=0){var k=k.match(g),f,b;if(b=
!k){b=n;for(var o=void 0,c=b.firstChild;c;c=c.nextSibling)var i=c.nodeType,o=i===1?o?b:c:i===3?N.test(c.nodeValue)?b:o:o;b=(f=o===b?void 0:o)&&"CODE"===f.tagName}b&&(k=f.className.match(g));k&&(k=k[1]);b=!1;for(o=n.parentNode;o;o=o.parentNode)if((o.tagName==="pre"||o.tagName==="code"||o.tagName==="xmp")&&o.className&&o.className.indexOf("prettyprint")>=0){b=!0;break}b||((b=(b=n.className.match(/\blinenums\b(?::(\d+))?/))?b[1]&&b[1].length?+b[1]:!0:!1)&&D(n,b),d={g:k,h:n,i:b},E(d))}}p<h.length?setTimeout(m,
250):a&&a()}for(var e=[document.getElementsByTagName("pre"),document.getElementsByTagName("code"),document.getElementsByTagName("xmp")],h=[],k=0;k<e.length;++k)for(var t=0,s=e[k].length;t<s;++t)h.push(e[k][t]);var e=q,l=Date;l.now||(l={now:function(){return+new Date}});var p=0,d,g=/\blang(?:uage)?-([\w.]+)(?!\S)/;m()};window.PR={createSimpleLexer:x,registerLangHandler:k,sourceDecorator:u,PR_ATTRIB_NAME:"atn",PR_ATTRIB_VALUE:"atv",PR_COMMENT:"com",PR_DECLARATION:"dec",PR_KEYWORD:"kwd",PR_LITERAL:"lit",
PR_NOCODE:"nocode",PR_PLAIN:"pln",PR_PUNCTUATION:"pun",PR_SOURCE:"src",PR_STRING:"str",PR_TAG:"tag",PR_TYPE:"typ"}})();

/*jshint browser:true, jquery:true, unused:false */
;(function($, win, doc) {
	$.anythingSlider = function(el, options) {

		var base = this, o, t;

		// Wraps the ul in the necessary divs and then gives Access to jQuery element
		base.el = el;
		base.$el = $(el).addClass('anythingBase').wrap('<div class="anythingSlider"><div class="anythingWindow" /></div>');

		// Add a reverse reference to the DOM object
		base.$el.data("AnythingSlider", base);

		base.init = function(){

			// Added "o" to be used in the code instead of "base.options" which doesn't get modifed by the compiler - reduces size by ~1k
			base.options = o = $.extend({}, $.anythingSlider.defaults, options);

			base.initialized = false;
			if ($.isFunction(o.onBeforeInitialize)) { base.$el.bind('before_initialize', o.onBeforeInitialize); }
			base.$el.trigger('before_initialize', base);

			// Add "as-oldie" class to body for css purposes
			$('<!--[if lte IE 8]><script>jQuery("body").addClass("as-oldie");</script><![endif]-->').appendTo('body').remove();

			// Cache existing DOM elements for later
			// base.$el = original ul
			// for wrap - get parent() then closest in case the ul has "anythingSlider" class
			base.$wrapper = base.$el.parent().closest('div.anythingSlider').addClass('anythingSlider-' + o.theme);
			base.$outer = base.$wrapper.parent();
			base.$window = base.$el.closest('div.anythingWindow');
			base.$win = $(win);

			base.$controls = $('<div class="anythingControls"></div>');
			base.$nav = $('<ul class="thumbNav"><li><a><span></span></a></li></ul>');
			base.$startStop = $('<a href="#" class="start-stop"></a>');

			if (o.buildStartStop || o.buildNavigation) {
				base.$controls.appendTo( (o.appendControlsTo && $(o.appendControlsTo).length) ? $(o.appendControlsTo) : base.$wrapper);
			}
			if (o.buildNavigation) {
				base.$nav.appendTo( (o.appendNavigationTo && $(o.appendNavigationTo).length) ? $(o.appendNavigationTo) : base.$controls );
			}
			if (o.buildStartStop) {
				base.$startStop.appendTo( (o.appendStartStopTo && $(o.appendStartStopTo).length) ? $(o.appendStartStopTo) : base.$controls );
			}

			// Figure out how many sliders are on the page for indexing
			base.runTimes = $('.anythingBase').length;
			// hash tag regex - fixes issue #432
			base.regex = (o.hashTags) ? new RegExp('panel' + base.runTimes + '-(\\d+)', 'i') : null;
			if (base.runTimes === 1) { base.makeActive(); } // make the first slider on the page active

			// Set up a few defaults & get details
			base.flag    = false; // event flag to prevent multiple calls (used in control click/focusin)
			if (o.autoPlayLocked) { o.autoPlay = true; } // if autoplay is locked, start playing
			base.playing = o.autoPlay; // slideshow state; removed "startStopped" option
			base.slideshow = false; // slideshow flag needed to correctly trigger slideshow events
			base.hovered = false; // actively hovering over the slider
			base.panelSize = [];  // will contain dimensions and left position of each panel
			base.currentPage = base.targetPage = o.startPanel = parseInt(o.startPanel,10) || 1; // make sure this isn't a string
			o.changeBy = parseInt(o.changeBy,10) || 1;

			// set slider type, but keep backward compatibility with the vertical option
			t = (o.mode || 'h').toLowerCase().match(/(h|v|f)/);
			t = o.vertical ? 'v' : (t || ['h'])[0];
			o.mode = t === 'v' ? 'vertical' : t === 'f' ? 'fade' : 'horizontal';
			if (t === 'f') {
				o.showMultiple = 1; // all slides are stacked in fade mode
				o.infiniteSlides = false; // no cloned slides
			}

			base.adj = (o.infiniteSlides) ? 0 : 1; // adjust page limits for infinite or limited modes
			base.adjustMultiple = 0;
			if (o.playRtl) { base.$wrapper.addClass('rtl'); }

			// Build start/stop button
			if (o.buildStartStop) { base.buildAutoPlay(); }

			// Build forwards/backwards buttons
			if (o.buildArrows) { base.buildNextBackButtons(); }

			base.$lastPage = base.$targetPage = base.$currentPage;

			// Initialize o.aspectRatio
			if (o.expand) {
				if (o.aspectRatio === true){
					// if aspectRatio = true calculate it
					o.aspectRatio = base.$el.width() / base.$el.height();
				} else if (typeof o.aspectRatio === 'string' && o.aspectRatio.indexOf(':') !== -1){
					// Calculate and set a float from a string e.g. '680:317'
					var f = o.aspectRatio.split(':');
					o.aspectRatio = f[0] / f[1];
				}
				// Adjust the aspectRatio according to showMultiple i.e. the more panels shown the wider the slider gets
				if (o.aspectRatio > 0 && o.showMultiple > 1) {
					o.aspectRatio = o.aspectRatio * o.showMultiple;
				}
			}

			base.updateSlider();

			// Expand slider to fit parent
			if (o.expand) {
				base.$window.css({ width: '100%', height: '100%' }); // needed for Opera
				base.checkResize();
			}

			// Make sure easing function exists.
			if (!$.isFunction($.easing[o.easing])) { o.easing = "swing"; }

			// If pauseOnHover then add hover effects
			if (o.pauseOnHover) {
				base.$wrapper.hover(function() {
					if (base.playing) {
						base.$el.trigger('slideshow_paused', base);
						base.clearTimer(true);
					}
				}, function() {
					if (base.playing) {
						base.$el.trigger('slideshow_unpaused', base);
						base.startStop(base.playing, true);
					}
				});
			}

			// Hide/Show navigation & play/stop controls
			base.slideControls(false);
			base.$wrapper.bind('mouseenter mouseleave', function(e){
				// add hovered class to outer wrapper
				$(this)[e.type === 'mouseenter' ? 'addClass' : 'removeClass']('anythingSlider-hovered');
				base.hovered = (e.type === 'mouseenter') ? true : false;
				base.slideControls(base.hovered);
			});

			// Add keyboard navigation
			$(doc).keyup(function(e){
				// Stop arrow keys from working when focused on form items
				if (o.enableKeyboard && base.$wrapper.hasClass('activeSlider') && !e.target.tagName.match('TEXTAREA|INPUT|SELECT')) {
					if (o.mode !== 'vertical' && (e.which === 38 || e.which === 40)) { return; }
					switch (e.which) {
						case 39: case 40: // right & down arrow
							base.goForward();
							break;
						case 37: case 38: // left & up arrow
							base.goBack();
							break;
					}
				}
			});

			// If a hash can not be used to trigger the plugin, then go to start panel - see issue #432
			base.currentPage = ((o.hashTags) ? base.gotoHash() : '') || o.startPanel || 1;
			base.gotoPage(base.currentPage, false, null, -1);

			// Binds events
			var triggers = "slideshow_resized slideshow_paused slideshow_unpaused slide_init slide_begin slideshow_stop slideshow_start initialized swf_completed".split(" ");
			$.each("onSliderResize onShowPause onShowUnpause onSlideInit onSlideBegin onShowStop onShowStart onInitialized onSWFComplete".split(" "), function(i,f){
				if ($.isFunction(o[f])){
					base.$el.bind(triggers[i], o[f]);
				}
			});
			if ($.isFunction(o.onSlideComplete)){
				// Added setTimeout (zero time) to ensure animation is complete... see this bug report: http://bugs.jquery.com/ticket/7157
				base.$el.bind('slide_complete', function(){
					setTimeout(function(){ o.onSlideComplete(base); }, 0);
					return false;
				});
			}
			base.initialized = true;
			base.$el.trigger('initialized', base);

			// trigger the slideshow
			base.startStop(o.autoPlay);

		};

		// called during initialization & to update the slider if a panel is added or deleted
		base.updateSlider = function(){

			// needed for updating the slider
			base.$el.children('.cloned').remove();
			base.navTextVisible = base.$nav.find('span:first').css('visibility') !== 'hidden';
			base.$nav.empty();
			// set currentPage to 1 in case it was zero - occurs when adding slides after removing them all
			base.currentPage = base.currentPage || 1;

			base.$items = base.$el.children();
			base.pages = base.$items.length;
			base.dir = (o.mode === 'vertical') ? 'top' : 'left';
			o.showMultiple = parseInt(o.showMultiple, 10) || 1; // only integers allowed
			o.navigationSize = (o.navigationSize === false) ? 0 : parseInt(o.navigationSize,10) || 0;

			// Fix tabbing through the page, but don't change the view if the link is in view (showMultiple = true)
			base.$items.find('a').unbind('focus.AnythingSlider').bind('focus.AnythingSlider', function(e){
				var panel = $(this).closest('.panel'),
					indx = base.$items.index(panel) + base.adj; // index can be -1 in nested sliders - issue #208
				base.$items.find('.focusedLink').removeClass('focusedLink');
				$(this).addClass('focusedLink');
				base.$window.scrollLeft(0).scrollTop(0);
				if ( ( indx !== -1 && (indx >= base.currentPage + o.showMultiple || indx < base.currentPage) ) ) {
					base.gotoPage(indx);
					e.preventDefault();
				}
			});
			if (o.showMultiple > 1) {
				if (o.showMultiple > base.pages) { o.showMultiple = base.pages; }
				base.adjustMultiple = (o.infiniteSlides && base.pages > 1) ? 0 : o.showMultiple - 1;
			}

			// Hide navigation & player if there is only one page
			base.$controls
				.add(base.$nav)
				.add(base.$startStop)
				.add(base.$forward)
				.add(base.$back)[(base.pages <= 1) ? 'hide' : 'show']();
			if (base.pages > 1) {
				// Build/update navigation tabs
				base.buildNavigation();
			}

			// Top and tail the list with 'visible' number of items, top has the last section, and tail has the first
			// This supports the "infinite" scrolling, also ensures any cloned elements don't duplicate an ID
			// Moved removeAttr before addClass otherwise IE7 ignores the addClass: http://bugs.jquery.com/ticket/9871
			if (o.mode !== 'fade' && o.infiniteSlides && base.pages > 1) {
				base.$el.prepend( base.$items.filter(':last').clone().addClass('cloned') );
				// Add support for multiple sliders shown at the same time
				if (o.showMultiple > 1) {
					base.$el.append( base.$items.filter(':lt(' + o.showMultiple + ')').clone().addClass('cloned multiple') );
				} else {
					base.$el.append( base.$items.filter(':first').clone().addClass('cloned') );
				}
				base.$el.find('.cloned').each(function(){
					// disable all focusable elements in cloned panels to prevent shifting the panels by tabbing
					$(this).find('a,input,textarea,select,button,area,form').attr({ disabled : 'disabled', name : '' });
					$(this).find('[id]')[ $.fn.addBack ? 'addBack' : 'andSelf' ]().removeAttr('id');
				});
			}

			// We just added two items, time to re-cache the list, then get the dimensions of each panel
			base.$items = base.$el.addClass(o.mode).children().addClass('panel');
			base.setDimensions();

			// Set the dimensions of each panel
			if (o.resizeContents) {
				base.$items.css('width', base.width);
				base.$wrapper
					.css('width', base.getDim(base.currentPage)[0])
					.add(base.$items).css('height', base.height);
			} else {
				base.$win.load(function(){
					// set dimensions after all images load
					base.setDimensions();
					// make sure the outer wrapper is set properly
					t = base.getDim(base.currentPage);
					base.$wrapper.css({ width: t[0], height: t[1] });
					base.setCurrentPage(base.currentPage, false);
				});
			}

			if (base.currentPage > base.pages) {
				base.currentPage = base.pages;
			}
			base.setCurrentPage(base.currentPage, false);
			base.$nav.find('a').eq(base.currentPage - 1).addClass('cur'); // update current selection

			if (o.mode === 'fade') {
				t = base.$items.eq(base.currentPage-1);
				if (o.resumeOnVisible) {
					// prevent display: none;
					t.css({ opacity: 1, visibility: 'visible' })
						.siblings().css({ opacity: 0, visibility: 'hidden' });
				} else {
					// allow display: none; - resets video
					base.$items.css('opacity',1);
					t.fadeIn(0).siblings().fadeOut(0);
				}
			}

		};

		// Creates the numbered navigation links
		base.buildNavigation = function() {
			if (o.buildNavigation && (base.pages > 1)) {
				var a, c, i, t, $li;
				base.$items.filter(':not(.cloned)').each(function(j){
					$li = $('<li/>');
					i = j + 1;
					c = (i === 1 ? ' first' : '') + (i === base.pages ? ' last' : '');
					a = '<a class="panel' + i + ( base.navTextVisible ? '"' : ' ' + o.tooltipClass + '" title="@"' ) + ' href="#"><span>@</span></a>';
					// If a formatter function is present, use it
					if ($.isFunction(o.navigationFormatter)) {
						t = o.navigationFormatter(i, $(this));
						if (typeof(t) === "string") {
							$li.html(a.replace(/@/g,t));
						} else {
							$li = $('<li/>', t);
						}
					} else {
						$li.html(a.replace(/@/g,i));
					}
					$li
					.appendTo(base.$nav)
					.addClass(c)
					.data('index', i);
				});
				base.$nav.children('li').bind(o.clickControls, function(e) {
					if (!base.flag && o.enableNavigation) {
						// prevent running functions twice (once for click, second time for focusin)
						base.flag = true; setTimeout(function(){ base.flag = false; }, 100);
						base.gotoPage( $(this).data('index') );
					}
					e.preventDefault();
				});

				// Add navigation tab scrolling - use !! in case someone sets the size to zero
				if (!!o.navigationSize && o.navigationSize < base.pages) {
					if (!base.$controls.find('.anythingNavWindow').length){
						base.$nav
							.before('<ul><li class="prev"><a href="#"><span>' + o.backText + '</span></a></li></ul>')
							.after('<ul><li class="next"><a href="#"><span>' + o.forwardText + '</span></a></li></ul>')
							.wrap('<div class="anythingNavWindow"></div>');
					}
					// include half of the left position to include extra width from themes like tabs-light and tabs-dark (still not perfect)
					base.navWidths = base.$nav.find('li').map(function(){
						return $(this).outerWidth(true) + Math.ceil(parseInt($(this).find('span').css('left'),10)/2 || 0);
					}).get();
					base.navLeft = base.currentPage;
					// add 25 pixels (old IE needs more than 5) to make sure the tabs don't wrap to the next line
					base.$nav.width( base.navWidth( 1, base.pages + 1 ) + 25 );
					base.$controls.find('.anythingNavWindow')
						.width( base.navWidth( 1, o.navigationSize + 1 ) ).end()
						.find('.prev,.next').bind(o.clickControls, function(e) {
							if (!base.flag) {
								base.flag = true; setTimeout(function(){ base.flag = false; }, 200);
								base.navWindow( base.navLeft + o.navigationSize * ( $(this).is('.prev') ? -1 : 1 ) );
							}
							e.preventDefault();
						});
				}

			}
		};

		base.navWidth = function(x,y){
			var i, s = Math.min(x,y),
				e = Math.max(x,y),
				w = 0;
			for (i = s; i < e; i++) {
				w += base.navWidths[i-1] || 0;
			}
			return w;
		};

		base.navWindow = function(n){
			if (!!o.navigationSize && o.navigationSize < base.pages && base.navWidths) {
				var p = base.pages - o.navigationSize + 1;
				n = (n <= 1) ? 1 : (n > 1 && n < p) ? n : p;
				if (n !== base.navLeft) {
					base.$controls.find('.anythingNavWindow').animate(
						{ scrollLeft: base.navWidth(1, n), width: base.navWidth(n, n + o.navigationSize) },
						{ queue: false, duration: o.animationTime });
					base.navLeft = n;
				}
			}
		};

		// Creates the Forward/Backward buttons
		base.buildNextBackButtons = function() {
			base.$forward = $('<span class="arrow forward"><a href="#"><span>' + o.forwardText + '</span></a></span>');
			base.$back = $('<span class="arrow back"><a href="#"><span>' + o.backText + '</span></a></span>');

			// Bind to the forward and back buttons
			base.$back.bind(o.clickBackArrow, function(e) {
				// prevent running functions twice (once for click, second time for swipe)
				if (o.enableArrows && !base.flag) {
					base.flag = true; setTimeout(function(){ base.flag = false; }, 100);
					base.goBack();
				}
				e.preventDefault();
			});
			base.$forward.bind(o.clickForwardArrow, function(e) {
				// prevent running functions twice (once for click, second time for swipe)
				if (o.enableArrows && !base.flag) {
					base.flag = true; setTimeout(function(){ base.flag = false; }, 100);
					base.goForward();
				}
				e.preventDefault();
			});
			// using tab to get to arrow links will show they have focus (outline is disabled in css)
			base.$back.add(base.$forward).find('a').bind('focusin focusout',function(){
				$(this).toggleClass('hover');
			});

			// Append elements to page
			base.$back.appendTo( (o.appendBackTo && $(o.appendBackTo).length) ? $(o.appendBackTo) : base.$wrapper );
			base.$forward.appendTo( (o.appendForwardTo && $(o.appendForwardTo).length) ? $(o.appendForwardTo) : base.$wrapper );

			base.arrowWidth = base.$forward.width(); // assuming the left & right arrows are the same width - used for toggle
			base.arrowRight = parseInt(base.$forward.css('right'), 10);
			base.arrowLeft = parseInt(base.$back.css('left'), 10);

		};

		// Creates the Start/Stop button
		base.buildAutoPlay = function(){
			base.$startStop
				.html('<span>' + (base.playing ? o.stopText : o.startText) + '</span>')
				.bind(o.clickSlideshow, function(e) {
					if (o.enableStartStop) {
						base.startStop(!base.playing);
						base.makeActive();
						if (base.playing && !o.autoPlayDelayed) {
							base.goForward(true, o.playRtl);
						}
					}
					e.preventDefault();
				})
				// show button has focus while tabbing
				.bind('focusin focusout',function(){
					$(this).toggleClass('hover');
				});
		};
		// Adjust slider dimensions on parent element resize
		base.checkResize = function(stopTimer){
			// checking document visibility
			var vis = !!(doc.hidden || doc.webkitHidden || doc.mozHidden || doc.msHidden);
			clearTimeout(base.resizeTimer);
			base.resizeTimer = setTimeout(function(){
				var w = base.$outer.width(),
					h = base.$outer[0].tagName === "BODY" ? base.$win.height() : base.$outer.height();
				// base.width = width of one panel, so multiply by # of panels; outerPad is padding added for arrows.
				// ignore changes if window hidden
				if (!vis && (base.lastDim[0] !== w || base.lastDim[1] !== h)) {

					base.setDimensions(); // adjust panel sizes

					//callback for slider resize
					base.$el.trigger('slideshow_resized', base);

					// make sure page is lined up (use -1 animation time, so we can differeniate it from when animationTime = 0)
					base.gotoPage(base.currentPage, base.playing, null, -1);

				}
				if (typeof(stopTimer) === 'undefined'){ base.checkResize(); }

				// increase time if page is hidden; but don't stop it completely
			}, vis ? 2000 : 500);
		};

		// Set panel dimensions to either resize content or adjust panel to content
		base.setDimensions = function(){

			// reset element width & height
			base.$wrapper.find('.anythingWindow, .anythingBase, .panel')[ $.fn.addBack ? 'addBack' : 'andSelf' ]().css({ width: '', height: '' });
			base.width = base.$el.width();
			base.height = base.$el.height();
			base.outerPad = [ base.$wrapper.innerWidth() - base.$wrapper.width(), base.$wrapper.innerHeight() - base.$wrapper.height() ];
			var w, h, c, t, edge = 0,
				fullsize = { width: '100%', height: '100%' },
				// determine panel width
				pw = (o.showMultiple > 1 && o.mode === 'horizontal') ? base.width || base.$window.width()/o.showMultiple : base.$window.width(),
				ph = (o.showMultiple > 1 && o.mode === 'vertical') ? base.height/o.showMultiple || base.$window.height()/o.showMultiple : base.$window.height();
			if (o.expand){
				base.lastDim = [ base.$outer.width(), base.$outer.height() ];
				w = base.lastDim[0] - base.outerPad[0];
				h = base.lastDim[1] - base.outerPad[1];

				// Rescale according to the aspectRatio if not null
				// We have already insured that (in init) o.aspectRatio contains a float.
				// make sure aspectRatio isn't infinity (divided by zero; so must be less than width, 3 might be a better number)
				if (o.aspectRatio && o.aspectRatio < base.width){
					var arW = h * o.aspectRatio;
					// Really: only one of these should be adjusted therefor the else ... if
					if (arW < w){
						w = arW;
					} else {
						var arH = w / o.aspectRatio;
						if (arH < h){
							h = arH;
						}
					}
				}
				base.$wrapper.add(base.$window).css({ width: w, height: h });
				base.height = h = (o.showMultiple > 1 && o.mode === 'vertical') ? ph : h;
				base.width = pw = (o.showMultiple > 1 && o.mode === 'horizontal') ? w/o.showMultiple : w;
				base.$items.css({ width: pw, height: ph });
			}
			base.$items.each(function(i){
				t = $(this);
				c = t.children();
				if (o.resizeContents){
					// resize panel
					w = base.width;
					h = base.height;
					t.css({ width: w, height: h });
					if (c.length) {
						if (c[0].tagName === "EMBED") { c.attr(fullsize); } // needed for IE7; also c.length > 1 in IE7
						if (c[0].tagName === "OBJECT") { c.find('embed').attr(fullsize); }
						// resize panel contents, if solitary (wrapped content or solitary image)
						if (c.length === 1){ c.css(fullsize); }
					}
				} else {
					// get panel width & height and save it
					if (o.mode === 'vertical') {
						w = t.css('display','inline-block').width();
						t.css('display','');
					} else {
						w = t.width() || base.width; // if image hasn't finished loading, width will be zero, so set it to base width instead
					}
					if (c.length === 1 && w >= pw){
						w = (c.width() >= pw) ? pw : c.width(); // get width of solitary child
						c.css('max-width', w);   // set max width for all children
					}
					t.css({ width: w, height: '' }); // set width of panel
					h = (c.length === 1 ? c.outerHeight(true) : t.height()); // get height after setting width
					if (h <= base.outerPad[1]) { h = base.height; } // if height less than the outside padding, then set it to the preset height
					t.css('height', h);
				}
				base.panelSize[i] = [w,h,edge];
				edge += (o.mode === 'vertical') ? h : w;
			});
			// Set total width of slider
			base.$el.css((o.mode === 'vertical' ? 'height' : 'width'), o.mode === 'fade' ? base.width : edge );
		};

		// get dimension of multiple panels, as needed
		base.getDim = function(page){
			var t, i, w = base.width, h = base.height;
			if (base.pages < 1 || isNaN(page)) { return [ w, h ]; } // prevent errors when base.panelSize is empty
			page = (o.infiniteSlides && base.pages > 1) ? page : page - 1;
			i = base.panelSize[page];
			if (i) {
				w = i[0] || w;
				h = i[1] || h;
			}
			if (o.showMultiple > 1) {
				for (i = 1; i < o.showMultiple; i++) {
					t = page + i;
					if (o.mode === 'vertical') {
						w = Math.max(w, base.panelSize[t][0]);
						h += base.panelSize[t][1];
					} else {
						w += base.panelSize[t][0];
						h = Math.max(h, base.panelSize[t][1]);
					}
				}
			}
			return [w,h];
		};
		base.goForward = function(autoplay, rtl) {
			// targetPage changes before animation so if rapidly changing pages, it will have the correct current page
			base.gotoPage(base[ o.allowRapidChange ? 'targetPage' : 'currentPage'] + o.changeBy * (rtl ? -1 : 1), autoplay);
		};
		base.goBack = function(autoplay) {
			base.gotoPage(base[ o.allowRapidChange ? 'targetPage' : 'currentPage'] - o.changeBy, autoplay);
		};
		base.gotoPage = function(page, autoplay, callback, time) {
			if (autoplay !== true) {
				autoplay = false;
				base.startStop(false);
				base.makeActive();
			}
			// check if page is an id or class name
			if (/^[#|.]/.test(page) && $(page).length) {
				page = $(page).closest('.panel').index() + base.adj;
			}

			// rewind effect occurs here when changeBy > 1
			if (o.changeBy !== 1){
				var adj = base.pages - base.adjustMultiple;
				if (page < 1) {
					page = o.stopAtEnd ? 1 : ( o.infiniteSlides ? base.pages + page : ( o.showMultiple > 1 - page ? 1 : adj ) );
				}
				if (page > base.pages) {
					page = o.stopAtEnd ? base.pages : ( o.showMultiple > 1 - page ? 1 : page -= adj );
				} else if (page >= adj) {
					// show multiple adjustments
					page = adj;
				}
			}
			if (base.pages <= 1) { return; } // prevents animation
			base.$lastPage = base.$currentPage;
			if (typeof(page) !== "number") {
				page = parseInt(page,10) || o.startPanel;
				base.setCurrentPage(page);
			}

			// pause YouTube videos before scrolling or prevent change if playing
			if (autoplay && o.isVideoPlaying(base)) { return; }
			if (o.stopAtEnd && !o.infiniteSlides && page > base.pages - o.showMultiple) { page = base.pages - o.showMultiple + 1; } // fixes #515
			base.exactPage = page;
			if (page > base.pages + 1 - base.adj) { page = (!o.infiniteSlides && !o.stopAtEnd) ? 1 : base.pages; }
			if (page < base.adj ) { page = (!o.infiniteSlides && !o.stopAtEnd) ? base.pages : 1; }
			if (!o.infiniteSlides) { base.exactPage = page; } // exact page used by the fx extension
			base.currentPage = ( page > base.pages ) ? base.pages : ( page < 1 ) ? 1 : base.currentPage;
			base.$currentPage = base.$items.eq(base.currentPage - base.adj);
			base.targetPage = (page === 0) ? base.pages : (page > base.pages) ? 1 : page;
			base.$targetPage = base.$items.eq(base.targetPage - base.adj);
			time = typeof time !== 'undefined' ? time : o.animationTime;
			// don't trigger events when time < 0 - to prevent FX from firing multiple times on page resize
			if (time >= 0) { base.$el.trigger('slide_init', base); }
			// toggle arrows/controls only if there is time to see it - fix issue #317
			if (time > 0 && o.toggleControls === true ) { base.slideControls(true); }

			// Set visual
			if (o.buildNavigation){
				base.setNavigation(base.targetPage);
			}

			// When autoplay isn't passed, we stop the timer
			if (autoplay !== true) { autoplay = false; }
			// Stop the slider when we reach the last page, if the option stopAtEnd is set to true
			if (!autoplay || (o.stopAtEnd && page === base.pages)) { base.startStop(false); }

			if (time >= 0) { base.$el.trigger('slide_begin', base); }

			// delay starting slide animation
			setTimeout(function(d){
				var t, p, empty = true;
				if (o.allowRapidChange) {
					base.$wrapper.add(base.$el).add(base.$items).stop(true, true);
				}
				// resize slider if content size varies
				if (!o.resizeContents) {
					// animating the wrapper resize before the window prevents flickering in Firefox
					// don't animate the dimension if it hasn't changed - fix for issue #264
					p = base.getDim(page); d = {};
					// prevent animating a dimension to zero
					if (base.$wrapper.width() !== p[0]) { d.width = p[0] || base.width; empty = false; }
					if (base.$wrapper.height() !== p[1]) { d.height = p[1] || base.height; empty = false; }
					if (!empty) {
						base.$wrapper.filter(':not(:animated)').animate(d, { queue: false, duration: (time < 0 ? 0 : time), easing: o.easing });
					}
				}

				if (o.mode === 'fade') {
					if (base.$lastPage[0] !== base.$targetPage[0]) {
						base.fadeIt( base.$lastPage, 0, time );
						base.fadeIt( base.$targetPage, 1, time, function(){ base.endAnimation(page, callback, time); });
					} else {
						base.endAnimation(page, callback, time);
					}
				} else {
					d = {};
					d[base.dir] = -base.panelSize[(o.infiniteSlides && base.pages > 1) ? page : page - 1][2];
					// resize width of base element (ul) if vertical & width of content varies
					if (o.mode === 'vertical' && !o.resizeContents) { d.width = p[0]; }
					// Animate Slider
					base.$el.filter(':not(:animated)').animate(
						d, { queue: false, duration: time < 0 ? 0 : time, easing: o.easing, complete: function(){ base.endAnimation(page, callback, time); } }
					);
				}
			}, parseInt(o.delayBeforeAnimate, 10) || 0);
		};

		base.endAnimation = function(page, callback, time){
			if (page === 0) {
				base.$el.css( base.dir, o.mode === 'fade' ? 0 : -base.panelSize[base.pages][2]);
				page = base.pages;
			} else if (page > base.pages) {
				// reset back to start position
				base.$el.css( base.dir, o.mode === 'fade' ? 0 : -base.panelSize[1][2]);
				page = 1;
			}
			base.exactPage = page;
			base.setCurrentPage(page, false);

			if (o.mode === 'fade') {
				// make sure non current panels are hidden (rapid slide changes)
				base.fadeIt( base.$items.not(':eq(' + (page - base.adj) + ')'), 0, 0);
			}

			if (!base.hovered) { base.slideControls(false); }

			if (o.hashTags) { base.setHash(page); }

			if (time >= 0) { base.$el.trigger('slide_complete', base); }
			// callback from external slide control: $('#slider').anythingSlider(4, function(slider){ })
			if (typeof callback === 'function') { callback(base); }

			// Continue slideshow after a delay
			if (o.autoPlayLocked && !base.playing) {
				setTimeout(function(){
					base.startStop(true);
				// subtract out slide delay as the slideshow waits that additional time.
				}, o.resumeDelay - (o.autoPlayDelayed ? o.delay : 0));
			}
		};

		base.fadeIt = function(el, toOpacity, time, callback){
			var f = el.filter(':not(:animated)'),
				t = time < 0 ? 0 : time;
			if (o.resumeOnVisible) {
				if (toOpacity === 1) {
					f.css('visibility', 'visible');
				}
				f.fadeTo(t, toOpacity, function(){
					if (toOpacity === 0) {
						f.css('visibility', 'hidden');
					}
					if ($.isFunction(callback)) {
						callback();
					}
				});
			} else {
				f[ toOpacity === 0 ? 'fadeOut' : 'fadeIn' ](t, callback);
			}
		};

		base.setCurrentPage = function(page, move) {
			page = parseInt(page, 10);

			if (base.pages < 1 || page === 0 || isNaN(page)) { return; }
			if (page > base.pages + 1 - base.adj) { page = base.pages - base.adj; }
			if (page < base.adj ) { page = 1; }

			// hide/show arrows based on infinite scroll mode
			if (o.buildArrows && !o.infiniteSlides && o.stopAtEnd){
				base.$forward[ page === base.pages - base.adjustMultiple ? 'addClass' : 'removeClass']('disabled');
				base.$back[ page === 1 ? 'addClass' : 'removeClass']('disabled');
				if (page === base.pages && base.playing) { base.startStop(); }
			}

			// Only change left if move does not equal false
			if (!move) {
				var d = base.getDim(page);
				base.$wrapper
					.css({ width: d[0], height: d[1] })
					.add(base.$window).scrollLeft(0).scrollTop(0); // reset in case tabbing changed this scrollLeft - probably overly redundant
				base.$el.css( base.dir, o.mode === 'fade' ? 0 : -base.panelSize[(o.infiniteSlides && base.pages > 1) ? page : page - 1][2] );
			}

			// Update local variable
			base.currentPage = page;
			base.$currentPage = base.$items.removeClass('activePage').eq(page - base.adj).addClass('activePage');

			if (o.buildNavigation){
				base.setNavigation(page);
			}

		};

		base.setNavigation = function(page){
			base.$nav
				.find('.cur').removeClass('cur').end()
				.find('a').eq(page - 1).addClass('cur');
		};

		base.makeActive = function(){
			// Set current slider as active so keyboard navigation works properly
			if (!base.$wrapper.hasClass('activeSlider')){
				$('.activeSlider').removeClass('activeSlider');
				base.$wrapper.addClass('activeSlider');
			}
		};

		// This method tries to find a hash that matches an ID and panel-X
		// If either found, it tries to find a matching item
		// If that is found as well, then it returns the page number
		base.gotoHash = function(){
			var h = win.location.hash,
				i = h.indexOf('&'),
				n = h.match(base.regex);
			// test for "/#/" or "/#!/" used by the jquery address plugin - $('#/') breaks jQuery
			if (n === null && !/^#&/.test(h) && !/#!?\//.test(h) && !/\=/.test(h)) {
				// #quote2&panel1-3&panel3-3
				h = h.substring(0, (i >= 0 ? i : h.length));
				// ensure the element is in the same slider
				n = ($(h).length && $(h).closest('.anythingBase')[0] === base.el) ? base.$items.index($(h).closest('.panel')) + base.adj : null;
			} else if (n !== null) {
				// #&panel1-3&panel3-3
				n = (o.hashTags) ? parseInt(n[1],10) : null;
			}
			return n;
		};
		base.setHash = function(n){
			var s = 'panel' + base.runTimes + '-',
				h = win.location.hash;
			if ( typeof h !== 'undefined' ) {
				win.location.hash = (h.indexOf(s) > 0) ? h.replace(base.regex, s + n) : h + "&" + s + n;
			}
		};
		// Slide controls (nav and play/stop button up or down)
		base.slideControls = function(toggle){
			var dir = (toggle) ? 'slideDown' : 'slideUp',
				t1 = (toggle) ? 0 : o.animationTime,
				t2 = (toggle) ? o.animationTime : 0,
				op = (toggle) ? 1 : 0,
				sign = (toggle) ? 0 : 1; // 0 = visible, 1 = hidden
			if (o.toggleControls) {
				base.$controls.stop(true,true).delay(t1)[dir](o.animationTime/2).delay(t2);
			}
			if (o.buildArrows && o.toggleArrows) {
				if (!base.hovered && base.playing) { sign = 1; op = 0; } // don't animate arrows during slideshow
				base.$forward.stop(true,true).delay(t1).animate({ right: base.arrowRight + (sign * base.arrowWidth), opacity: op }, o.animationTime/2);
				base.$back.stop(true,true).delay(t1).animate({ left: base.arrowLeft + (sign * base.arrowWidth), opacity: op }, o.animationTime/2);
			}
		};
		base.clearTimer = function(paused){
			// Clear the timer only if it is set
			if (base.timer) {
				win.clearInterval(base.timer);
				if (!paused && base.slideshow) {
					base.$el.trigger('slideshow_stop', base);
					base.slideshow = false;
				}
			}
		};
		// Pass startStop(false) to stop and startStop(true) to play
		base.startStop = function(playing, paused) {
			if (playing !== true) { playing = false; }  // Default if not supplied is false
			base.playing = playing;

			if (playing && !paused) {
				base.$el.trigger('slideshow_start', base);
				base.slideshow = true;
			}

			// Toggle playing and text
			if (o.buildStartStop) {
				base.$startStop.toggleClass('playing', playing).find('span').html( playing ? o.stopText : o.startText );
				// add button text to title attribute if it is hidden by text-indent
				if ( base.$startStop.find('span').css('visibility') === "hidden" ) {
					base.$startStop.addClass(o.tooltipClass).attr( 'title', playing ? o.stopText : o.startText );
				}
			}
			// Pause slideshow while video is playing
			if (playing){
				base.clearTimer(true); // Just in case this was triggered twice in a row
				base.timer = win.setInterval(function() {
					if ( !!(doc.hidden || doc.webkitHidden || doc.mozHidden || doc.msHidden) ) {
						// stop slideshow if the page isn't visible (issue #463)
						if (!o.autoPlayLocked) {
							base.startStop();
						}
					} else if ( !o.isVideoPlaying(base) ) {
						// prevent autoplay if video is playing
						base.goForward(true, o.playRtl);
					} else if (!o.resumeOnVideoEnd) {
						// stop slideshow if resume if false
						base.startStop();
					}
				}, o.delay);
			} else {
				base.clearTimer();
			}
		};
		// Trigger the initialization
		base.init();
	};
	$.anythingSlider.defaults = {
		// Appearance
		theme               : "default", // Theme name, add the css stylesheet manually
		mode                : "horiz",   // Set mode to "horizontal", "vertical" or "fade" (only first letter needed); replaces vertical option
		expand              : false,     // If true, the entire slider will expand to fit the parent element
		resizeContents      : true,      // If true, solitary images/objects in the panel will expand to fit the viewport
		// commented out as this will reduce the size of the minified version
		//aspectRatio       : null,      // Valid values: null, true, a float e.g. 1.5 (or as 3/2) or a ratio in a string e.g. '3:2'
		// If true calculate it from original width/height for slider element, if it is a number/ratio use that value
		showMultiple        : false,     // Set this value to a number and it will show that many slides at once
		easing              : "swing",   // Anything other than "linear" or "swing" requires the easing plugin or jQuery UI

		buildArrows         : true,      // If true, builds the forwards and backwards buttons
		buildNavigation     : false,      // If true, builds a list of anchor links to link to each panel
		buildStartStop      : false,      // ** If true, builds the start/stop button

/*
		// commented out as this will reduce the size of the minified version
		appendForwardTo     : null,      // Append forward arrow to a HTML element (jQuery Object, selector or HTMLNode), if not null
		appendBackTo        : null,      // Append back arrow to a HTML element (jQuery Object, selector or HTMLNode), if not null
		appendControlsTo    : null,      // Append controls (navigation + start-stop) to a HTML element (jQuery Object, selector or HTMLNode), if not null
		appendNavigationTo  : null,      // Append navigation buttons to a HTML element (jQuery Object, selector or HTMLNode), if not null
		appendStartStopTo   : null,      // Append start-stop button to a HTML element (jQuery Object, selector or HTMLNode), if not null
*/

		toggleArrows        : false,     // If true, side navigation arrows will slide out on hovering & hide @ other times
		toggleControls      : false,     // if true, slide in controls (navigation + play/stop button) on hover and slide change, hide @ other times

		startText           : "Start",   // Start button text
		stopText            : "Stop",    // Stop button text
		forwardText         : "&raquo;", // Link text used to move the slider forward (hidden by CSS, replaced with arrow image)
		backText            : "&laquo;", // Link text used to move the slider back (hidden by CSS, replace with arrow image)
		tooltipClass        : "tooltip", // Class added to navigation & start/stop button (text copied to title if it is hidden by a negative text indent)

		// Function
		enableArrows        : true,      // if false, arrows will be visible, but not clickable.
		enableNavigation    : true,      // if false, navigation links will still be visible, but not clickable.
		enableStartStop     : true,      // if false, the play/stop button will still be visible, but not clickable. Previously "enablePlay"
		enableKeyboard      : true,      // if false, keyboard arrow keys will not work for this slider.

		// Navigation
		startPanel          : 1,         // This sets the initial panel
		changeBy            : 1,         // Amount to go forward or back when changing panels.
		hashTags            : false,      // Should links change the hashtag in the URL?
		infiniteSlides      : true,      // if false, the slider will not wrap & not clone any panels
		navigationFormatter : null,      // Details at the top of the file on this use (advanced use)
		navigationSize      : false,     // Set this to the maximum number of visible navigation tabs; false to disable

		// Slideshow options
		autoPlay            : true,     // If true, the slideshow will start running; replaces "startStopped" option
		autoPlayLocked      : true,     // If true, user changing slides will not stop the slideshow
		autoPlayDelayed     : true,     // If true, starting a slideshow will delay advancing slides; if false, the slider will immediately advance to the next slide when slideshow starts
		pauseOnHover        : true,      // If true & the slideshow is active, the slideshow will pause on hover
		stopAtEnd           : false,     // If true & the slideshow is active, the slideshow will stop on the last page. This also stops the rewind effect when infiniteSlides is false.
		playRtl             : false,     // If true, the slideshow will move right-to-left
		// Times
		delay               : 3000,      // How long between slideshow transitions in AutoPlay mode (in milliseconds)
		resumeDelay         : 3000,     // Resume slideshow after user interaction, only if autoplayLocked is true (in milliseconds).
		animationTime       : 600,       // How long the slideshow transition takes (in milliseconds)
		delayBeforeAnimate  : 0,         // How long to pause slide animation before going to the desired slide (used if you want your "out" FX to show).

/*
		// Callbacks - commented out to reduce size of the minified version - they still work
		onSliderResize      : function(e, slider) {}, // Callback when slider resizes
		onBeforeInitialize  : function(e, slider) {}, // Callback before the plugin initializes
		onInitialized       : function(e, slider) {}, // Callback when the plugin finished initializing
		onShowStart         : function(e, slider) {}, // Callback on slideshow start
		onShowStop          : function(e, slider) {}, // Callback after slideshow stops
		onShowPause         : function(e, slider) {}, // Callback when slideshow pauses
		onShowUnpause       : function(e, slider) {}, // Callback when slideshow unpauses - may not trigger properly if user clicks on any controls
		onSlideInit         : function(e, slider) {}, // Callback when slide initiates, before control animation
		onSlideBegin        : function(e, slider) {}, // Callback before slide animates
		onSlideComplete     : function(slider) {},    // Callback when slide completes - no event variable!
*/
		// Interactivity
		clickForwardArrow   : "click",         // Event used to activate forward arrow functionality (e.g. add jQuery mobile's "swiperight")
		clickBackArrow      : "click",         // Event used to activate back arrow functionality (e.g. add jQuery mobile's "swipeleft")
		clickControls       : "click focusin", // Events used to activate navigation control functionality
		clickSlideshow      : "click",         // Event used to activate slideshow play/stop button
		allowRapidChange    : false,           // If true, allow rapid changing of the active pane, instead of ignoring activity during animation

		// Video
		resumeOnVideoEnd    : true,      // If true & the slideshow is active & a supported video is playing, it will pause the autoplay until the video is complete
		resumeOnVisible     : true,      // If true the video will resume playing, if previously paused; if false, the video remains paused.
		isVideoPlaying      : function(base){ return false; } // return true if video is playing or false if not - used by video extension

		// deprecated - use the video extension wmode option now
		// addWmodeToObject : "opaque"   // If your slider has a video supported by the extension, the script will automatically add a wmode parameter with this setting
	};
	$.fn.anythingSlider = function(options, callback) {
		return this.each(function(){
			var page, anySlide = $(this).data('AnythingSlider');
			// initialize the slider but prevent multiple initializations
			if ((typeof(options)).match('object|undefined')){
				if (!anySlide) {
					(new $.anythingSlider(this, options));
				} else {
					anySlide.updateSlider();
				}
			// If options is a number, process as an external link to page #: $(element).anythingSlider(#)
			} else if (/\d/.test(options) && !isNaN(options) && anySlide) {
				page = (typeof(options) === "number") ? options : parseInt($.trim(options),10); // accepts "  2  "
				// ignore out of bound pages
				if ( page >= 1 && page <= anySlide.pages ) {
					anySlide.gotoPage(page, false, callback); // page #, autoplay, one time callback
				}
			// Accept id or class name
			} else if (/^[#|.]/.test(options) && $(options).length) {
				anySlide.gotoPage(options, false, callback);
			}
		});
	};
})(jQuery, window, document);

		// Set up Sliders//
		$(function(){
			$('#slider1').anythingSlider({
				theme           : 'metallic',
				easing          : 'swing',
				onSlideComplete : function(slider){
					// alert('Welcome to Slide #' + slider.currentPage);
				}
			});
		});
		
// Related Job Slider Ends Here//