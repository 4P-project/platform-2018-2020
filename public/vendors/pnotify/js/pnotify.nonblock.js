!function(o,e){"function"==typeof define&&define.amd?define("pnotify.nonblock",["jquery","pnotify"],e):"object"==typeof exports&&"undefined"!=typeof module?module.exports=e(require("jquery"),require("./pnotify")):e(o.jQuery,o.PNotify)}("undefined"!=typeof window?window:this,function(o,e){var n,t=function(e,n){var t;if(e=e.toLowerCase(),document.createEvent&&this.dispatchEvent){if(e=e.replace(/^on/,""),e.match(/^(dbl)?click$|^mouse(move|down|up|over|out|enter|leave)$|^contextmenu$/)?(o(this).offset(),t=document.createEvent("MouseEvents"),t.initMouseEvent(e,n.bubbles,n.cancelable,n.view,n.detail,n.screenX,n.screenY,n.clientX,n.clientY,n.ctrlKey,n.altKey,n.shiftKey,n.metaKey,n.button,n.relatedTarget)):e.match(/^(focus|blur|select|change|reset)$|^key(press|down|up)$/)?(t=document.createEvent("UIEvents"),t.initUIEvent(e,n.bubbles,n.cancelable,n.view,n.detail)):e.match(/^(scroll|resize|(un)?load|abort|error)$/)&&(t=document.createEvent("HTMLEvents"),t.initEvent(e,n.bubbles,n.cancelable)),!t)return;this.dispatchEvent(t)}else e.match(/^on/)||(e="on"+e),t=document.createEventObject(n),this.fireEvent(e,t)},i=function(e,i,c){e.elem.addClass("ui-pnotify-nonblock-hide");var l=document.elementFromPoint(i.clientX,i.clientY);e.elem.removeClass("ui-pnotify-nonblock-hide");var s=o(l),a=s.css("cursor");"auto"===a&&"A"===l.tagName&&(a="pointer"),e.elem.css("cursor","auto"!==a?a:"default"),n&&n.get(0)==l||(n&&(t.call(n.get(0),"mouseleave",i.originalEvent),t.call(n.get(0),"mouseout",i.originalEvent)),t.call(l,"mouseenter",i.originalEvent),t.call(l,"mouseover",i.originalEvent)),t.call(l,c,i.originalEvent),n=s};return e.prototype.options.nonblock={nonblock:!1},e.prototype.modules.nonblock={init:function(o,e){var t=this;o.elem.on({mouseenter:function(e){t.options.nonblock&&e.stopPropagation(),t.options.nonblock&&o.elem.addClass("ui-pnotify-nonblock-fade")},mouseleave:function(e){t.options.nonblock&&e.stopPropagation(),n=null,o.elem.css("cursor","auto"),t.options.nonblock&&"out"!==o.animating&&o.elem.removeClass("ui-pnotify-nonblock-fade")},mouseover:function(o){t.options.nonblock&&o.stopPropagation()},mouseout:function(o){t.options.nonblock&&o.stopPropagation()},mousemove:function(e){t.options.nonblock&&(e.stopPropagation(),i(o,e,"onmousemove"))},mousedown:function(e){t.options.nonblock&&(e.stopPropagation(),e.preventDefault(),i(o,e,"onmousedown"))},mouseup:function(e){t.options.nonblock&&(e.stopPropagation(),e.preventDefault(),i(o,e,"onmouseup"))},click:function(e){t.options.nonblock&&(e.stopPropagation(),i(o,e,"onclick"))},dblclick:function(e){t.options.nonblock&&(e.stopPropagation(),i(o,e,"ondblclick"))}})}},e});