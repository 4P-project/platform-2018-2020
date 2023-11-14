"use strict";function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var _extends=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e},_createClass=function(){function e(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,n,r){return n&&e(t.prototype,n),r&&e(t,r),t}}(),_typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol?"symbol":typeof e};!function(e,t,n){"function"==typeof define&&define.amd?define(["jquery"],function(r){return e(t,n,r)}):"object"===("undefined"==typeof module?"undefined":_typeof(module))&&module.exports?module.exports=e(t,n,require("jquery")):e(t,n,jQuery)}(function(e,t,n){var r=function(){function n(e){_classCallCheck(this,n),this.ctx=e}return _createClass(n,[{key:"log",value:function(e){var t=arguments.length<=1||void 0===arguments[1]?"debug":arguments[1],n=this.opt.log;this.opt.debug&&"object"===(void 0===n?"undefined":_typeof(n))&&"function"==typeof n[t]&&n[t]("mark.js: "+e)}},{key:"escapeStr",value:function(e){return e.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&")}},{key:"createRegExp",value:function(e){return e=this.escapeStr(e),Object.keys(this.opt.synonyms).length&&(e=this.createSynonymsRegExp(e)),this.opt.diacritics&&(e=this.createDiacriticsRegExp(e)),e=this.createMergedBlanksRegExp(e),e=this.createAccuracyRegExp(e)}},{key:"createSynonymsRegExp",value:function(e){var t=this.opt.synonyms,n=this.opt.caseSensitive?"":"i";for(var r in t)if(t.hasOwnProperty(r)){var o=t[r],a=this.escapeStr(r),i=this.escapeStr(o);e=e.replace(new RegExp("("+a+"|"+i+")","gm"+n),"("+a+"|"+i+")")}return e}},{key:"createDiacriticsRegExp",value:function(e){var t=this.opt.caseSensitive?"":"i",n=this.opt.caseSensitive?["aàáâãäåāą","AÀÁÂÃÄÅĀĄ","cçćč","CÇĆČ","dđď","DĐĎ","eèéêëěēę","EÈÉÊËĚĒĘ","iìíîïī","IÌÍÎÏĪ","lł","LŁ","nñňń","NÑŇŃ","oòóôõöøō","OÒÓÔÕÖØŌ","rř","RŘ","sšś","SŠŚ","tť","TŤ","uùúûüůū","UÙÚÛÜŮŪ","yÿý","YŸÝ","zžżź","ZŽŻŹ"]:["aÀÁÂÃÄÅàáâãäåĀāąĄ","cÇçćĆčČ","dđĐďĎ","eÈÉÊËèéêëěĚĒēęĘ","iÌÍÎÏìíîïĪī","lłŁ","nÑñňŇńŃ","oÒÓÔÕÖØòóôõöøŌō","rřŘ","sŠšśŚ","tťŤ","uÙÚÛÜùúûüůŮŪū","yŸÿýÝ","zŽžżŻźŹ"],r=[];return e.split("").forEach(function(o){n.every(function(n){if(-1!==n.indexOf(o)){if(r.indexOf(n)>-1)return!1;e=e.replace(new RegExp("["+n+"]","gm"+t),"["+n+"]"),r.push(n)}return!0})}),e}},{key:"createMergedBlanksRegExp",value:function(e){return e.replace(/[\s]+/gim,"[\\s]*")}},{key:"createAccuracyRegExp",value:function(e){var t=this,n=this.opt.accuracy,r="string"==typeof n?n:n.value,o="string"==typeof n?[]:n.limiters,a="";switch(o.forEach(function(e){a+="|"+t.escapeStr(e)}),r){case"partially":return"()("+e+")";case"complementary":return"()([^\\s"+a+"]*"+e+"[^\\s"+a+"]*)";case"exactly":return"(^|\\s"+a+")("+e+")(?=$|\\s"+a+")"}}},{key:"getSeparatedKeywords",value:function(e){var t=this,n=[];return e.forEach(function(e){t.opt.separateWordSearch?e.split(" ").forEach(function(e){e.trim()&&-1===n.indexOf(e)&&n.push(e)}):e.trim()&&-1===n.indexOf(e)&&n.push(e)}),{keywords:n.sort(function(e,t){return t.length-e.length}),length:n.length}}},{key:"getTextNodes",value:function(e){var t=this,n="",r=[];this.iterator.forEachNode(NodeFilter.SHOW_TEXT,function(e){r.push({start:n.length,end:(n+=e.textContent).length,node:e})},function(e){return t.matchesExclude(e.parentNode,!0)?NodeFilter.FILTER_REJECT:NodeFilter.FILTER_ACCEPT},function(){e({value:n,nodes:r})})}},{key:"matchesExclude",value:function(e,t){var n=this.opt.exclude.concat(["script","style","title","head","html"]);return t&&(n=n.concat(["*[data-markjs='true']"])),o.matches(e,n)}},{key:"wrapRangeInTextNode",value:function(e,n,r){var o=this.opt.element?this.opt.element:"mark",a=e.splitText(n),i=a.splitText(r-n),c=t.createElement(o);return c.setAttribute("data-markjs","true"),this.opt.className&&c.setAttribute("class",this.opt.className),c.textContent=a.textContent,a.parentNode.replaceChild(c,a),i}},{key:"wrapRangeInMappedTextNode",value:function(e,t,n,r,o){var a=this;e.nodes.every(function(i,c){var s=e.nodes[c+1];if(void 0===s||s.start>t){var u=function(){var s=t-i.start,u=(n>i.end?i.end:n)-i.start;if(r(i.node)){i.node=a.wrapRangeInTextNode(i.node,s,u);var f=e.value.substr(0,i.start),l=e.value.substr(u+i.start);if(e.value=f+l,e.nodes.forEach(function(t,n){n>=c&&(e.nodes[n].start>0&&n!==c&&(e.nodes[n].start-=u),e.nodes[n].end-=u)}),n-=u,o(i.node.previousSibling,i.start),!(n>i.end))return{v:!1};t=i.end}}();if("object"===(void 0===u?"undefined":_typeof(u)))return u.v}return!0})}},{key:"wrapMatches",value:function(e,t,n,r,o){var a=this,i=t?0:2;this.getTextNodes(function(c){c.nodes.forEach(function(o){o=o.node;for(var c=void 0;null!==(c=e.exec(o.textContent));)if(n(c[i],o)){var s=c.index;t||(s+=c[i-1].length),o=a.wrapRangeInTextNode(o,s,s+c[i].length),r(o.previousSibling),e.lastIndex=0}}),o()})}},{key:"wrapMatchesAcrossElements",value:function(e,t,n,r,o){var a=this,i=t?0:2;this.getTextNodes(function(c){for(var s=void 0;null!==(s=e.exec(c.value));){var u=s.index;t||(u+=s[i-1].length);var f=u+s[i].length;a.wrapRangeInMappedTextNode(c,u,f,function(e){return n(s[i],e)},function(t,n){e.lastIndex=n,r(t)})}o()})}},{key:"unwrapMatches",value:function(e){for(var n=e.parentNode,r=t.createDocumentFragment();e.firstChild;)r.appendChild(e.removeChild(e.firstChild));n.replaceChild(r,e),n.normalize()}},{key:"markRegExp",value:function(e,t){var n=this;this.opt=t,this.log('Searching with expression "'+e+'"');var r=0,o=function(e){r++,n.opt.each(e)},a="wrapMatches";this.opt.acrossElements&&(a="wrapMatchesAcrossElements"),this[a](e,!0,function(e,t){return n.opt.filter(t,e,r)},o,function(){0===r&&n.opt.noMatch(e),n.opt.done(r)})}},{key:"mark",value:function(e,t){var n=this;this.opt=t;var r=this.getSeparatedKeywords("string"==typeof e?[e]:e),o=r.keywords,a=r.length,i=this.opt.caseSensitive?"":"i",c=0,s="wrapMatches";if(this.opt.acrossElements&&(s="wrapMatchesAcrossElements"),0===a)return void this.opt.done(c);!function e(t){var r=new RegExp(n.createRegExp(t),"gm"+i),u=0;n.log('Searching with expression "'+r+'"'),n[s](r,!1,function(e,r){return n.opt.filter(r,t,c,u)},function(e){u++,c++,n.opt.each(e)},function(){0===u&&n.opt.noMatch(t),o[a-1]===t?n.opt.done(c):e(o[o.indexOf(t)+1])})}(o[0])}},{key:"unmark",value:function(e){var t=this;this.opt=e;var n=this.opt.element?this.opt.element:"*";n+="[data-markjs]",this.opt.className&&(n+="."+this.opt.className),this.log('Removal selector "'+n+'"'),this.iterator.forEachNode(NodeFilter.SHOW_ELEMENT,function(e){t.unwrapMatches(e)},function(e){var r=o.matches(e,n),a=t.matchesExclude(e,!1);return!r||a?NodeFilter.FILTER_REJECT:NodeFilter.FILTER_ACCEPT},this.opt.done)}},{key:"opt",set:function(t){this._opt=_extends({},{element:"",className:"",exclude:[],iframes:!1,separateWordSearch:!0,diacritics:!0,synonyms:{},accuracy:"partially",acrossElements:!1,each:function(){},noMatch:function(){},filter:function(){return!0},done:function(){},debug:!1,log:e.console,caseSensitive:!1},t)},get:function(){return this._opt}},{key:"iterator",get:function(){return this._iterator||(this._iterator=new o(this.ctx,this.opt.iframes,this.opt.exclude)),this._iterator}}]),n}(),o=function(){function e(t){var n=arguments.length<=1||void 0===arguments[1]||arguments[1],r=arguments.length<=2||void 0===arguments[2]?[]:arguments[2];_classCallCheck(this,e),this.ctx=t,this.iframes=n,this.exclude=r}return _createClass(e,[{key:"getContexts",value:function(){var e=void 0;e=void 0!==this.ctx&&this.ctx?NodeList.prototype.isPrototypeOf(this.ctx)?Array.prototype.slice.call(this.ctx):Array.isArray(this.ctx)?this.ctx:[this.ctx]:[];var t=[];return e.forEach(function(e){var n=t.filter(function(t){return t.contains(e)}).length>0;-1!==t.indexOf(e)||n||t.push(e)}),t}},{key:"getIframeContents",value:function(e,t){var n=arguments.length<=2||void 0===arguments[2]?function(){}:arguments[2],r=void 0;try{var o=e.contentWindow;if(r=o.document,!o||!r)throw new Error("iframe inaccessible")}catch(e){n()}r&&t(r)}},{key:"onIframeReady",value:function(e,t,n){var r=this;try{!function(){var o=e.contentWindow,a="about:blank",i=function(){var t=e.getAttribute("src").trim();return o.location.href===a&&t!==a&&t},c=function(){var o=function o(){try{i()||(e.removeEventListener("load",o),r.getIframeContents(e,t,n))}catch(e){n()}};e.addEventListener("load",o)};"complete"===o.document.readyState?i()?c():r.getIframeContents(e,t,n):c()}()}catch(e){n()}}},{key:"waitForIframes",value:function(e,t){var n=this,r=0;this.forEachIframe(e,function(){return!0},function(e){r++,n.waitForIframes(e.querySelector("html"),function(){--r||t()})},function(e){e||t()})}},{key:"forEachIframe",value:function(t,n,r){var o=this,a=arguments.length<=3||void 0===arguments[3]?function(){}:arguments[3],i=t.querySelectorAll("iframe"),c=i.length,s=0;i=Array.prototype.slice.call(i);var u=function(){--c<=0&&a(s)};c||u(),i.forEach(function(t){e.matches(t,o.exclude)?u():o.onIframeReady(t,function(e){n(t)&&(s++,r(e)),u()},u)})}},{key:"createIterator",value:function(e,n,r){return t.createNodeIterator(e,n,r,!1)}},{key:"createInstanceOnIframe",value:function(t){return new e(t.querySelector("html"),this.iframes)}},{key:"compareNodeIframe",value:function(e,t,n){if(e.compareDocumentPosition(n)&Node.DOCUMENT_POSITION_PRECEDING){if(null===t)return!0;if(t.compareDocumentPosition(n)&Node.DOCUMENT_POSITION_FOLLOWING)return!0}return!1}},{key:"getIteratorNode",value:function(e){var t=e.previousNode(),n=void 0;return n=null===t?e.nextNode():e.nextNode()&&e.nextNode(),{prevNode:t,node:n}}},{key:"checkIframeFilter",value:function(e,t,n,r){var o=!1,a=!1;return r.forEach(function(e,t){e.val===n&&(o=t,a=e.handled)}),this.compareNodeIframe(e,t,n)?(!1!==o||a?!1===o||a||(r[o].handled=!0):r.push({val:n,handled:!0}),!0):(!1===o&&r.push({val:n,handled:!1}),!1)}},{key:"handleOpenIframes",value:function(e,t,n,r){var o=this;e.forEach(function(e){e.handled||o.getIframeContents(e.val,function(e){o.createInstanceOnIframe(e).forEachNode(t,n,r)})})}},{key:"iterateThroughNodes",value:function(e,t,n,r,o){for(var a=this,i=this.createIterator(t,e,r),c=[],s=void 0,u=void 0;function(){var e=a.getIteratorNode(i);return u=e.prevNode,s=e.node}();)this.iframes&&this.forEachIframe(t,function(e){return a.checkIframeFilter(s,u,e,c)},function(t){a.createInstanceOnIframe(t).forEachNode(e,n,r)}),n(s);this.iframes&&this.handleOpenIframes(c,e,n,r),o()}},{key:"forEachNode",value:function(e,t,n){var r=this,o=arguments.length<=3||void 0===arguments[3]?function(){}:arguments[3],a=this.getContexts(),i=a.length;i||o(),a.forEach(function(a){var c=function(){r.iterateThroughNodes(e,a,t,n,function(){--i<=0&&o()})};r.iframes?r.waitForIframes(a,c):c()})}}],[{key:"matches",value:function(e,t){var n="string"==typeof t?[t]:t,r=e.matches||e.matchesSelector||e.msMatchesSelector||e.mozMatchesSelector||e.oMatchesSelector||e.webkitMatchesSelector;if(r){var o=!1;return n.every(function(t){return!r.call(e,t)||(o=!0,!1)}),o}return!1}}]),e}();return n.fn.mark=function(e,t){return new r(this.get()).mark(e,t),this},n.fn.markRegExp=function(e,t){return new r(this.get()).markRegExp(e,t),this},n.fn.unmark=function(e){return new r(this.get()).unmark(e),this},n},window,document);