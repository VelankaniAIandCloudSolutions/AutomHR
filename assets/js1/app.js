(function(h,j,e){var a="placeholder"in j.createElement("input");var f="placeholder"in j.createElement("textarea");var k=e.fn;var d=e.valHooks;var b=e.propHooks;var m;var l;if(a&&f){l=k.placeholder=function(){return this};l.input=l.textarea=true}else{l=k.placeholder=function(){var n=this;n.filter((a?"textarea":":input")+"[placeholder]").not(".placeholder").bind({"focus.placeholder":c,"blur.placeholder":g}).data("placeholder-enabled",true).trigger("blur.placeholder");return n};l.input=a;l.textarea=f;m={get:function(o){var n=e(o);var p=n.data("placeholder-password");if(p){return p[0].value}return n.data("placeholder-enabled")&&n.hasClass("placeholder")?"":o.value},set:function(o,q){var n=e(o);var p=n.data("placeholder-password");if(p){return p[0].value=q}if(!n.data("placeholder-enabled")){return o.value=q}if(q==""){o.value=q;if(o!=j.activeElement){g.call(o)}}else{if(n.hasClass("placeholder")){c.call(o,true,q)||(o.value=q)}else{o.value=q}}return n}};if(!a){d.input=m;b.value=m}if(!f){d.textarea=m;b.value=m}e(function(){e(j).delegate("form","submit.placeholder",function(){var n=e(".placeholder",this).each(c);setTimeout(function(){n.each(g)},10)})});e(h).bind("beforeunload.placeholder",function(){e(".placeholder").each(function(){this.value=""})})}function i(o){var n={};var p=/^jQuery\d+$/;e.each(o.attributes,function(r,q){if(q.specified&&!p.test(q.name)){n[q.name]=q.value}});return n}function c(o,p){var n=this;var q=e(n);if(n.value==q.attr("placeholder")&&q.hasClass("placeholder")){if(q.data("placeholder-password")){q=q.hide().next().show().attr("id",q.removeAttr("id").data("placeholder-id"));if(o===true){return q[0].value=p}q.focus()}else{n.value="";q.removeClass("placeholder");n==j.activeElement&&n.select()}}}function g(){var r;var n=this;var q=e(n);var p=this.id;if(n.value==""){if(n.type=="password"){if(!q.data("placeholder-textinput")){try{r=q.clone().attr({type:"text"})}catch(o){r=e("<input>").attr(e.extend(i(this),{type:"text"}))}r.removeAttr("name").data({"placeholder-password":q,"placeholder-id":p}).bind("focus.placeholder",c);q.data({"placeholder-textinput":r,"placeholder-id":p}).before(r)}q=q.removeAttr("id").hide().prev().attr("id",p).show()}q.addClass("placeholder");q[0].value=q.attr("placeholder")}else{q.removeClass("placeholder")}}}(this,document,jQuery));;window.Modernizr=function(a,b,c){function w(a){j.cssText=a}function x(a,b){return w(m.join(a+";")+(b||""))}function y(a,b){return typeof a===b}function z(a,b){return!!~(""+a).indexOf(b)}function A(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:y(f,"function")?f.bind(d||b):f}return!1}var d="2.6.2",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m=" -webkit- -moz- -o- -ms- ".split(" "),n={},o={},p={},q=[],r=q.slice,s,t=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},u={}.hasOwnProperty,v;!y(u,"undefined")&&!y(u.call,"undefined")?v=function(a,b){return u.call(a,b)}:v=function(a,b){return b in a&&y(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=r.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(r.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(r.call(arguments)))};return e}),n.touch=function(){var c;return"ontouchstart"in a||a.DocumentTouch&&b instanceof DocumentTouch?c=!0:t(["@media (",m.join("touch-enabled),("),h,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(a){c=a.offsetTop===9}),c};for(var B in n)v(n,B)&&(s=B.toLowerCase(),e[s]=n[B](),q.push((e[s]?"":"no-")+s));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)v(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},w(""),i=k=null,e._version=d,e._prefixes=m,e.testStyles=t,g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+q.join(" "):""),e}(this,this.document);Modernizr.addTest('android',function(){return!!navigator.userAgent.match(/Android/i)});Modernizr.addTest('chrome',function(){return!!navigator.userAgent.match(/Chrome/i)});Modernizr.addTest('firefox',function(){return!!navigator.userAgent.match(/Firefox/i)});Modernizr.addTest('iemobile',function(){return!!navigator.userAgent.match(/IEMobile/i)});Modernizr.addTest('ie',function(){return!!navigator.userAgent.match(/MSIE/i)});Modernizr.addTest('ie10',function(){return!!navigator.userAgent.match(/MSIE 10/i)});Modernizr.addTest('ios',function(){return!!navigator.userAgent.match(/iPhone|iPad|iPod/i)});(function(a,b){"use strict";var c="undefined"!=typeof Element&&"ALLOW_KEYBOARD_INPUT"in Element,d=function(){for(var a,c,d=[["requestFullscreen","exitFullscreen","fullscreenElement","fullscreenEnabled","fullscreenchange","fullscreenerror"],["webkitRequestFullscreen","webkitExitFullscreen","webkitFullscreenElement","webkitFullscreenEnabled","webkitfullscreenchange","webkitfullscreenerror"],["webkitRequestFullScreen","webkitCancelFullScreen","webkitCurrentFullScreenElement","webkitCancelFullScreen","webkitfullscreenchange","webkitfullscreenerror"],["mozRequestFullScreen","mozCancelFullScreen","mozFullScreenElement","mozFullScreenEnabled","mozfullscreenchange","mozfullscreenerror"]],e=0,f=d.length,g={};f>e;e++)if(a=d[e],a&&a[1]in b){for(e=0,c=a.length;c>e;e++)g[d[0][e]]=a[e];return g}return!1}(),e={request:function(a){var e=d.requestFullscreen;a=a||b.documentElement,/5\.1[\.\d]* Safari/.test(navigator.userAgent)?a[e]():a[e](c&&Element.ALLOW_KEYBOARD_INPUT)},exit:function(){b[d.exitFullscreen]()},toggle:function(a){this.isFullscreen?this.exit():this.request(a)},onchange:function(){},onerror:function(){},raw:d};return d?(Object.defineProperties(e,{isFullscreen:{get:function(){return!!b[d.fullscreenElement]}},element:{enumerable:!0,get:function(){return b[d.fullscreenElement]}},enabled:{enumerable:!0,get:function(){return!!b[d.fullscreenEnabled]}}}),b.addEventListener(d.fullscreenchange,function(a){e.onchange.call(e,a)}),b.addEventListener(d.fullscreenerror,function(a){e.onerror.call(e,a)}),a.screenfull=e,void 0):a.screenfull=!1})(window,document);+function($){"use strict";var Shift=function(element){this.$element=$(element)
this.$prev=this.$element.prev()
!this.$prev.length&&(this.$parent=this.$element.parent())}
Shift.prototype={constructor:Shift,init:function(){var $el=this.$element,method=$el.data()['toggle'].split(':')[1],$target=$el.data('target')
$el.hasClass('in')||$el[method]($target).addClass('in')},reset:function(){this.$parent&&this.$parent['prepend'](this.$element)
!this.$parent&&this.$element['insertAfter'](this.$prev)
this.$element.removeClass('in')}}
$.fn.shift=function(option){return this.each(function(){var $this=$(this),data=$this.data('shift')
if(!data)$this.data('shift',(data=new Shift(this)))
if(typeof option=='string')data[option]()})}
$.fn.shift.Constructor=Shift}(jQuery);Date.now=Date.now||function(){return+new Date;};+function($){$(function(){$(document).on('click',"[data-toggle=fullscreen]",function(e){if(screenfull.enabled){screenfull.request();}});$('input[placeholder], textarea[placeholder]').placeholder();$("[data-toggle=popover]").popover();$(document).on('click','.popover-title .close',function(e){var $target=$(e.target),$popover=$target.closest('.popover').prev();$popover&&$popover.popover('hide');});$(document).on('click','[data-toggle="ajaxModal"]',function(e){$('#ajaxModal').remove();e.preventDefault();var $this=$(this),$remote=$this.data('remote')||$this.attr('href'),$modal=$('<div class="modal fade" id="ajaxModal"><div class="modal-body"></div></div>');$('body').append($modal);$modal.modal();$modal.load($remote);});$.fn.dropdown.Constructor.prototype.change=function(e){e.preventDefault();var $item=$(e.target),$select,$checked=false,$menu,$label;!$item.is('a')&&($item=$item.closest('a'));$menu=$item.closest('.dropdown-menu');$label=$menu.parent().find('.dropdown-label');$labelHolder=$label.text();$select=$item.find('input');$checked=$select.is(':checked');if($select.is(':disabled'))return;if($select.attr('type')=='radio'&&$checked)return;if($select.attr('type')=='radio')$menu.find('li').removeClass('active');$item.parent().removeClass('active');!$checked&&$item.parent().addClass('active');$select.prop("checked",!$select.prop("checked"));$items=$menu.find('li > a > input:checked');if($items.length){$text=[];$items.each(function(){var $str=$(this).parent().text();$str&&$text.push($.trim($str));});$text=$text.length<4?$text.join(', '):$text.length+' selected';$label.html($text);}else{$label.html($label.data('placeholder'));}}
$(document).on('click.dropdown-menu','.dropdown-select > li > a',$.fn.dropdown.Constructor.prototype.change);$("[data-toggle=tooltip]").tooltip();$(document).on('click','[data-toggle^="class"]',function(e){e&&e.preventDefault();var $this=$(e.target),$class,$target,$tmp,$classes,$targets;!$this.data('toggle')&&($this=$this.closest('[data-toggle^="class"]'));$class=$this.data()['toggle'];$target=$this.data('target')||$this.attr('href');$class&&($tmp=$class.split(':')[1])&&($classes=$tmp.split(','));$target&&($targets=$target.split(','));$targets&&$targets.length&&$.each($targets,function(index,value){($targets[index]!='#')&&$($targets[index]).toggleClass($classes[index]);});$this.toggleClass('active');});$(document).on('click','.panel-toggle',function(e){e&&e.preventDefault();var $this=$(e.target),$class='collapse',$target;if(!$this.is('a'))$this=$this.closest('a');$target=$this.closest('.panel');$target.find('.panel-body').toggleClass($class);$this.toggleClass('active');});$('.carousel.auto').carousel();$(document).on('click.button.data-api','[data-loading-text]',function(e){var $this=$(e.target);$this.is('i')&&($this=$this.parent());$this.button('loading');});var scrollToTop=function(){!location.hash&&setTimeout(function(){if(!pageYOffset)window.scrollTo(0,0);},1000);};var $window=$(window);var mobile=function(option){if(option=='reset'){$('[data-toggle^="shift"]').shift('reset');return;}
scrollToTop();$('[data-toggle^="shift"]').shift('init');return true;};$window.width()<768&&mobile();var $resize;$window.resize(function(){clearTimeout($resize);$resize=setTimeout(function(){$window.width()<767&&mobile();$window.width()>=768&&mobile('reset');},500);});$('.vbox > footer').prev('section').addClass('w-f');$(document).on('click','.sidebar-menu a',function(e){var $this=$(e.target),$active;$this.is('a')||($this=$this.closest('a'));if($('.nav-vertical').length){return;}
$active=$this.parent().siblings(".active");$active&&$active.find('> a').toggleClass('active')&&$active.toggleClass('active').find('> ul:visible').slideUp(200);($this.hasClass('active')&&$this.next().slideUp(200))||$this.next().slideDown(200);$this.toggleClass('active').parent().toggleClass('active');$this.next().is('ul')&&e.preventDefault();});$(document).on('click.bs.dropdown.data-api','.dropdown .on, .dropup .on',function(e){e.stopPropagation()});});}(jQuery);!function($){$(function(){var sr,sparkline=function($re){$(".sparkline").each(function(){var $data=$(this).data();if($re&&!$data.resize)return;($data.type=='pie')&&$data.sliceColors&&($data.sliceColors=eval($data.sliceColors));($data.type=='bar')&&$data.stackedBarColor&&($data.stackedBarColor=eval($data.stackedBarColor));$data.valueSpots={'0:':$data.spotColor};$(this).sparkline('html',$data);});};$(window).resize(function(e){clearTimeout(sr);sr=setTimeout(function(){sparkline(true)},500);});sparkline(false);$('.easypiechart').each(function(){var $this=$(this),$data=$this.data(),$step=$this.find('.step'),$target_value=parseInt($($data.target).text()),$value=0;$data.barColor||($data.barColor=function($percent){$percent/=100;return"rgb("+Math.round(200*$percent)+", 200, "+Math.round(200*(1-$percent))+")";});$data.onStep=function(value){$value=value;$step.text(parseInt(value));$data.target&&$($data.target).text(parseInt(value)+$target_value);}
$data.onStop=function(){$target_value=parseInt($($data.target).text());$data.update&&setTimeout(function(){$this.data('easyPieChart').update(100-$value);},$data.update);}
$(this).easyPieChart($data);});$(".combodate").each(function(){$(this).combodate();$(this).next('.combodate').find('select').addClass('form-control');});$(".datepicker-input").each(function(){$(this).datepicker({ language: locale});});$('.dropfile').each(function(){var $dropbox=$(this);if(typeof window.FileReader==='undefined'){$('small',this).html('File API & FileReader API not supported').addClass('text-danger');return;}
this.ondragover=function(){$dropbox.addClass('hover');return false;};this.ondragend=function(){$dropbox.removeClass('hover');return false;};this.ondrop=function(e){e.preventDefault();$dropbox.removeClass('hover').html('');var file=e.dataTransfer.files[0],reader=new FileReader();reader.onload=function(event){$dropbox.append($('<img>').attr('src',event.target.result));};reader.readAsDataURL(file);return false;};});var addPill=function($input){var $text=$input.val(),$pills=$input.closest('.pillbox'),$repeat=false,$repeatPill;if($text=="")return;$("li",$pills).text(function(i,v){if(v==$text){$repeatPill=$(this);$repeat=true;}});if($repeat){$repeatPill.fadeOut().fadeIn();return;};$item=$('<li class="label bg-dark">'+$text+'</li> ');$item.insertBefore($input);$input.val('');$pills.trigger('change',$item);};$('.pillbox input').on('blur',function(){addPill($(this));});$('.pillbox input').on('keypress',function(e){if(e.which==13){e.preventDefault();addPill($(this));}});$('.slider').each(function(){$(this).slider();});var $nextText;$(document).on('click','[data-wizard]',function(e){var $this=$(this),href;var $target=$($this.attr('data-target')||(href=$this.attr('href'))&&href.replace(/.*(?=#[^\s]+$)/,''));var option=$this.data('wizard');var item=$target.wizard('selectedItem');var $step=$target.next().find('.step-pane:eq('+(item.step-1)+')');!$nextText&&($nextText=$('[data-wizard="next"]').html());if($(this).hasClass('btn-next')&&$step.find('input, select, textarea').data('required')&&!$step.find('input, select, textarea').parsley('validate')){return false;}else{$target.wizard(option);var activeStep=(option=="next")?(item.step+1):(item.step-1);var prev=($(this).hasClass('btn-prev')&&$(this))||$(this).prev();var next=($(this).hasClass('btn-next')&&$(this))||$(this).next();prev.attr('disabled',(activeStep==1)?true:false);next.html((activeStep<$target.find('li').length)?$nextText:next.data('last'));}});if($.fn.sortable){$('.sortable').sortable();}
$('.no-touch .slim-scroll').each(function(){var $self=$(this),$data=$self.data(),$slimResize;$self.slimScroll($data);$(window).resize(function(e){clearTimeout($slimResize);$slimResize=setTimeout(function(){$self.slimScroll($data);},500);});});if($.support.pjax){$(document).on('click','a[data-pjax]',function(event){event.preventDefault();var container=$($(this).data('target'));$.pjax.click(event,{container:container});})};$('.portlet').each(function(){$(".portlet").sortable({connectWith:'.portlet',iframeFix:false,items:'.portlet-item',opacity:0.8,helper:'original',revert:true,forceHelperSize:true,placeholder:'sortable-box-placeholder round-all',forcePlaceholderSize:true,tolerance:'pointer'});});$('#docs pre code').each(function(){var $this=$(this);var t=$this.html();$this.html(t.replace(/</g,'&lt;').replace(/>/g,'&gt;'));});$(document).on('click','.fontawesome-icon-list a',function(e){e&&e.preventDefault();});$(document).on('change','table thead [type="checkbox"]',function(e){e&&e.preventDefault();var $table=$(e.target).closest('table'),$checked=$(e.target).is(':checked');$('tbody [type="checkbox"]',$table).prop('checked',$checked);});$(document).on('click','[data-toggle^="progress"]',function(e){e&&e.preventDefault();$el=$(e.target);$target=$($el.data('target'));$('.progress',$target).each(function(){var $max=50,$data,$ps=$('.progress-bar',this).last();($(this).hasClass('progress-xs')||$(this).hasClass('progress-sm'))&&($max=100);$data=Math.floor(Math.random()*$max)+'%';$ps.css('width',$data).attr('data-original-title',$data);});});function addMsg($msg){var $el=$('.nav-user'),$n=$('.count:first',$el),$v=parseInt($n.text());$('.count',$el).fadeOut().fadeIn().text($v+1);$($msg).hide().prependTo($el.find('.list-group')).slideDown().css('display','block');}
var $msg='<a href="#" class="media list-group-item">'+'<span class="pull-left thumb-sm text-center">'+'<i class="fa fa-envelope-o fa-2x text-success"></i>'+'</span>'+'<span class="media-body block m-b-none">'+'Sophi sent you a email<br>'+'<small class="text-muted">1 minutes ago</small>'+'</span>'+'</a>';setTimeout(function(){addMsg($msg);},1500);$('[data-ride="datatables"]').each(function(){var oTable=$(this).dataTable({"bProcessing":true,"sAjaxSource":"js/data/datatable.json","sDom":"<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>","sPaginationType":"full_numbers","aoColumns":[{"mData":"engine"},{"mData":"browser"},{"mData":"platform"},{"mData":"version"},{"mData":"grade"}]});});if($.fn.select2){$("#select2-option").select2();$("#select2-tags").select2({tags:["red","green","blue"],tokenSeparators:[","," "]});}});}(window.jQuery);(function(f){jQuery.fn.extend({slimScroll:function(h){var a=f.extend({width:"auto",height:"250px",size:"7px",color:"#000",position:"right",distance:"1px",start:"top",opacity:0.4,alwaysVisible:!1,disableFadeOut:!1,railVisible:!1,railColor:"#333",railOpacity:0.2,railDraggable:!0,railClass:"slimScrollRail",barClass:"slimScrollBar",wrapperClass:"slimScrollDiv",allowPageScroll:!1,wheelStep:20,touchScrollStep:200,borderRadius:"7px",railBorderRadius:"7px"},h);this.each(function(){function r(d){if(s){d=d||window.event;var c=0;d.wheelDelta&&(c=-d.wheelDelta/120);d.detail&&(c=d.detail/3);f(d.target||d.srcTarget||d.srcElement).closest("."+a.wrapperClass).is(b.parent())&&m(c,!0);d.preventDefault&&!k&&d.preventDefault();k||(d.returnValue=!1)}}function m(d,f,h){k=!1;var e=d,g=b.outerHeight()-c.outerHeight();f&&(e=parseInt(c.css("top"))+d*parseInt(a.wheelStep)/100*c.outerHeight(),e=Math.min(Math.max(e,0),g),e=0<d?Math.ceil(e):Math.floor(e),c.css({top:e+"px"}));l=parseInt(c.css("top"))/(b.outerHeight()-c.outerHeight());e=l*(b[0].scrollHeight-b.outerHeight());h&&(e=d,d=e/b[0].scrollHeight*b.outerHeight(),d=Math.min(Math.max(d,0),g),c.css({top:d+"px"}));b.scrollTop(e);b.trigger("slimscrolling",~~e);v();p()}function C(){window.addEventListener?(this.addEventListener("DOMMouseScroll",r,!1),this.addEventListener("mousewheel",r,!1),this.addEventListener("MozMousePixelScroll",r,!1)):document.attachEvent("onmousewheel",r)}function w(){u=Math.max(b.outerHeight()/b[0].scrollHeight*b.outerHeight(),D);c.css({height:u+"px"});var a=u==b.outerHeight()?"none":"block";c.css({display:a})}function v(){w();clearTimeout(A);l==~~l?(k=a.allowPageScroll,B!=l&&b.trigger("slimscroll",0==~~l?"top":"bottom")):k=!1;B=l;u>=b.outerHeight()?k=!0:(c.stop(!0,!0).fadeIn("fast"),a.railVisible&&g.stop(!0,!0).fadeIn("fast"))}function p(){a.alwaysVisible||(A=setTimeout(function(){a.disableFadeOut&&s||(x||y)||(c.fadeOut("slow"),g.fadeOut("slow"))},1E3))}var s,x,y,A,z,u,l,B,D=30,k=!1,b=f(this);if(b.parent().hasClass(a.wrapperClass)){var n=b.scrollTop(),c=b.parent().find("."+a.barClass),g=b.parent().find("."+a.railClass);w();if(f.isPlainObject(h)){if("height"in h&&"auto"==h.height){b.parent().css("height","auto");b.css("height","auto");var q=b.parent().parent().height();b.parent().css("height",q);b.css("height",q)}if("scrollTo"in h)n=parseInt(a.scrollTo);else if("scrollBy"in h)n+=parseInt(a.scrollBy);else if("destroy"in h){c.remove();g.remove();b.unwrap();return}m(n,!1,!0)}}else{a.height="auto"==a.height?b.parent().height():a.height;n=f("<div></div>").addClass(a.wrapperClass).css({position:"relative",overflow:"hidden",width:a.width,height:a.height});b.css({overflow:"hidden",width:a.width,height:a.height});var g=f("<div></div>").addClass(a.railClass).css({width:a.size,height:"100%",position:"absolute",top:0,display:a.alwaysVisible&&a.railVisible?"block":"none","border-radius":a.railBorderRadius,background:a.railColor,opacity:a.railOpacity,zIndex:90}),c=f("<div></div>").addClass(a.barClass).css({background:a.color,width:a.size,position:"absolute",top:0,opacity:a.opacity,display:a.alwaysVisible?"block":"none","border-radius":a.borderRadius,BorderRadius:a.borderRadius,MozBorderRadius:a.borderRadius,WebkitBorderRadius:a.borderRadius,zIndex:99}),q="right"==a.position?{right:a.distance}:{left:a.distance};g.css(q);c.css(q);b.wrap(n);b.parent().append(c);b.parent().append(g);a.railDraggable&&c.bind("mousedown",function(a){var b=f(document);y=!0;t=parseFloat(c.css("top"));pageY=a.pageY;b.bind("mousemove.slimscroll",function(a){currTop=t+a.pageY-pageY;c.css("top",currTop);m(0,c.position().top,!1)});b.bind("mouseup.slimscroll",function(a){y=!1;p();b.unbind(".slimscroll")});return!1}).bind("selectstart.slimscroll",function(a){a.stopPropagation();a.preventDefault();return!1});g.hover(function(){v()},function(){p()});c.hover(function(){x=!0},function(){x=!1});b.hover(function(){s=!0;v();p()},function(){s=!1;p()});b.bind("touchstart",function(a,b){a.originalEvent.touches.length&&(z=a.originalEvent.touches[0].pageY)});b.bind("touchmove",function(b){k||b.originalEvent.preventDefault();b.originalEvent.touches.length&&(m((z-b.originalEvent.touches[0].pageY)/a.touchScrollStep,!0),z=b.originalEvent.touches[0].pageY)});w();"bottom"===a.start?(c.css({top:b.outerHeight()-c.outerHeight()}),m(0,!0)):"top"!==a.start&&(m(f(a.start).position().top,null,!0),a.alwaysVisible||c.hide());C()}});return this}});jQuery.fn.extend({slimscroll:jQuery.fn.slimScroll})})(jQuery);


$(document).ready(function($) {

    // Sidebar overlay
	
    var $sidebarOverlay = $(".sidebar-overlay");
    $("#mobile_btn, .task-chat").on("click", function(e) {
        var $target = $($(this).attr("href"));
        if ($target.length) {
            $target.toggleClass("opened");
            $sidebarOverlay.toggleClass("opened");
            $("html").toggleClass("menu-opened");
            $sidebarOverlay.attr("data-reff", $(this).attr("href"));
        }
        e.preventDefault();
    });

    $sidebarOverlay.on("click", function(e) {
        var $target = $($(this).attr("data-reff"));
        if ($target.length) {
            $target.removeClass("opened");
            $("html").removeClass("menu-opened");
            $(this).removeClass("opened");
            $(".main-wrapper").removeClass("slide-nav");
        }
        e.preventDefault();
    });
	
    // Mobile Menu

    if ($('.main-wrapper').length > 0) {
        var $wrapper = $(".main-wrapper");
        $('#mobile_btn').click(function() {
            $wrapper.toggleClass('slide-nav');
            $('#chat_sidebar').removeClass('opened');
            $(".dropdown.open > .dropdown-toggle").dropdown("toggle");
            return false;
        });
        $('#open_msg_box').click(function() {
            $wrapper.toggleClass('open-msg-box');
            $('.themes').removeClass('active');
            $('.dropdown').removeClass('open');
            return false;
        });
    }
	
	// Select 2
	
	if($('.select').length > 0) {
		$('.select').select2({
			minimumResultsForSearch: -1,
			width: '100%'
		});
	}
	
    // Floating Label

    if ($('.floating').length > 0) {
        $('.floating').on('focus blur', function(e) {
            $(this).parents('.form-focus').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
    }
	
    // Page wrapper height

    if ($('.page-wrapper').length > 0) {
        var height = $(window).height();
        $(".page-wrapper").css("min-height", height);
    }

    $(window).resize(function() {
        if ($('.page-wrapper').length > 0) {
            var height = $(window).height();
            $(".page-wrapper").css("min-height", height);
        }
    });
	
    // Left Sidebar Scroll

    if ($('.slimscroll').length > 0) {
        $('.slimscroll').slimScroll({
            height: 'auto',
            width: '100%',
            position: 'right',
            size: "7px",
            color: '#ccc',
            wheelStep: 10,
            touchScrollStep: 100
        });
        var hei = $(window).height() - 60;
        $('.slimscroll').height(hei);
        $('.sidebar .slimScrollDiv').height(hei);

        $(window).resize(function() {
            var hei = $(window).height() - 60;
            $('.slimscroll').height(hei);
            $('.sidebar .slimScrollDiv').height(hei);
        });
    }
	
    // Dropdown in Table responsive 

    $('.table-responsive').on('shown.bs.dropdown', function(e) {
        var $table = $(this),
            $dropmenu = $(e.target).find('.dropdown-menu'),
            tableOffsetHeight = $table.offset().top + $table.height(),
            menuOffsetHeight = $dropmenu.offset().top + $dropmenu.outerHeight(true);

        if (menuOffsetHeight > tableOffsetHeight)
            $table.css("padding-bottom", menuOffsetHeight - tableOffsetHeight);
    });
	
    $('.table-responsive').on('hide.bs.dropdown', function() {
        $(this).css("padding-bottom", 0);
    });
	
	$('a[data-toggle="modal"]').on('click',function(){
		setTimeout(function(){ if($(".modal.custom-modal").hasClass('in')){ 
		$(".modal-backdrop").addClass('custom-backdrop');
		$("body").addClass('custom-modal-open');
		
		} },500);
    });
	
	// Multiselect

	if($('#customleave_select').length > 0) {
		$('#customleave_select').multiselect();
	}

	
  $(document).on({
    'show.bs.modal': function() {
      var zIndex = 1040 + (10 * $('.modal:visible').length);
      $(this).css('z-index', zIndex);
      setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
      }, 0);
    },
    'hidden.bs.modal': function() {
      if ($('.modal:visible').length > 0) {
        // restore the modal-open class to the body element, so that scrolling works
        // properly after de-stacking a modal.
        setTimeout(function() {
          $(document.body).addClass('modal-open');
        }, 0);
      }
    }
  }, '.modal');
	
	// Leave Settings button show
	
	$(document).on('click', '.leave-edit-btn', function() {
	    var type_form = $(this).data('typ');
		$(this).removeClass('leave-edit-btn').addClass('btn btn-white leave-cancel-btn').text('Cancel');
		$(this).closest("div.leave-right").append('<button class="btn btn-primary leave-save-btn" type="submit" id="'+type_form+'">Save</button>');
		$(this).parent().parent().find("input").prop('disabled', false);
		return false;
	});
	$(document).on('click', '.leave-cancel-btn', function() {
		$(this).removeClass('btn btn-white leave-cancel-btn').addClass('leave-edit-btn').text('Edit');
		$(this).closest("div.leave-right").find(".leave-save-btn").remove();
		$(this).parent().parent().find("input").prop('disabled', true);
		return false;
	});
	
	$(document).on('change', '.leave-box .onoffswitch-checkbox', function() {
		var id = $(this).attr('id').split('_')[1];
		if ($(this).prop("checked") == true) {
			$("#leave_"+id+" .leave-edit-btn").prop('disabled', false);
			$("#leave_"+id+" .leave-action .btn").prop('disabled', false);
		}
	    else {
			$("#leave_"+id+" .leave-action .btn").prop('disabled', true);	
			$("#leave_"+id+" .leave-cancel-btn").parent().parent().find("input").prop('disabled', true);
			$("#leave_"+id+" .leave-cancel-btn").closest("div.leave-right").find(".leave-save-btn").remove();
			$("#leave_"+id+" .leave-cancel-btn").removeClass('btn btn-white leave-cancel-btn').addClass('leave-edit-btn').text('Edit');
			$("#leave_"+id+" .leave-edit-btn").prop('disabled', true);
		}
	});
	
	$('.leave-box .onoffswitch-checkbox').each(function() {
		var id = $(this).attr('id').split('_')[1];
		if ($(this).prop("checked") == true) {
			$("#leave_"+id+" .leave-edit-btn").prop('disabled', false);
			$("#leave_"+id+" .leave-action .btn").prop('disabled', false);
		}
	    else {
			$("#leave_"+id+" .leave-action .btn").prop('disabled', true);	
			$("#leave_"+id+" .leave-cancel-btn").parent().parent().find("input").prop('disabled', true);
			$("#leave_"+id+" .leave-cancel-btn").closest("div.leave-right").find(".leave-save-btn").remove();
			$("#leave_"+id+" .leave-cancel-btn").removeClass('btn btn-white leave-cancel-btn').addClass('leave-edit-btn').text('Edit');
			$("#leave_"+id+" .leave-edit-btn").prop('disabled', true);
		}
	});
	
	// Small Sidebar

	if(screen.width >= 992) {
		$(document).on('click', '#toggle_btn', function() {
			if($('body').hasClass('mini-sidebar')) {
				$('body').removeClass('mini-sidebar');
				$('.subdrop + ul').slideDown();
			} else {
				$('body').addClass('mini-sidebar');
				$('.subdrop + ul').slideUp();
			}
			return false;
		});
		$(document).on('mouseover', function(e) {
			e.stopPropagation();
			if($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
				var targ = $(e.target).closest('.sidebar').length;
				if(targ) {
					$('body').addClass('expand-menu');
					$('.subdrop + ul').slideDown();
				} else {
					$('body').removeClass('expand-menu');
					$('.subdrop + ul').slideUp();
				}
				return false;
			}
		});
	}
    
});