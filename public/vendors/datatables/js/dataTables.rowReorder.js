!function(t){"function"==typeof define&&define.amd?define(["jquery","datatables.net"],function(e){return t(e,window,document)}):"object"==typeof exports?module.exports=function(e,o){return e||(e=window),o&&o.fn.dataTable||(o=require("datatables.net")(e,o).$),t(o,e,e.document)}:t(jQuery,window,document)}(function(t,e,o,r){"use strict";var n=t.fn.dataTable,s=function(e,o){if(!n.versionCheck||!n.versionCheck("1.10.8"))throw"DataTables RowReorder requires DataTables 1.10.8 or newer";this.c=t.extend(!0,{},n.defaults.rowReorder,s.defaults,o),this.s={bodyTop:null,dt:new n.Api(e),getDataFn:n.ext.oApi._fnGetObjectDataFn(this.c.dataSrc),middles:null,scroll:{},scrollInterval:null,setDataFn:n.ext.oApi._fnSetObjectDataFn(this.c.dataSrc),start:{top:0,left:0,offsetTop:0,offsetLeft:0,nodes:[]},windowHeight:0,documentOuterHeight:0,domCloneOuterHeight:0},this.dom={clone:null,dtScroll:t("div.dataTables_scrollBody",this.s.dt.table().container())};var r=this.s.dt.settings()[0],i=r.rowreorder;if(i)return i;r.rowreorder=this,this._constructor()};t.extend(s.prototype,{_constructor:function(){var e=this,o=this.s.dt,r=t(o.table().node());"static"===r.css("position")&&r.css("position","relative"),t(o.table().container()).on("mousedown.rowReorder touchstart.rowReorder",this.c.selector,function(r){if(e.c.enable){var n=t(this).closest("tr"),s=o.row(n);return s.any()?(e._emitEvent("pre-row-reorder",{node:s.node(),index:s.index()}),e._mouseDown(r,n),!1):void 0}}),o.on("destroy.rowReorder",function(){t(o.table().container()).off(".rowReorder"),o.off(".rowReorder")})},_cachePositions:function(){var r=this.s.dt,n=t(r.table().node()).find("thead").outerHeight(),s=t.unique(r.rows({page:"current"}).nodes().toArray()),i=t.map(s,function(e,o){return t(e).position().top-n}),d=t.map(i,function(e,o){return i.length<o-1?(e+i[o+1])/2:(e+e+t(r.row(":last-child").node()).outerHeight())/2});this.s.middles=d,this.s.bodyTop=t(r.table().body()).offset().top,this.s.windowHeight=t(e).height(),this.s.documentOuterHeight=t(o).outerHeight()},_clone:function(e){var o=this.s.dt,r=t(o.table().node().cloneNode(!1)).addClass("dt-rowReorder-float").append("<tbody/>").append(e.clone(!1)),n=e.outerWidth(),s=e.outerHeight(),i=e.children().map(function(){return t(this).width()});r.width(n).height(s).find("tr").children().each(function(t){this.style.width=i[t]+"px"}),r.appendTo("body"),this.dom.clone=r,this.s.domCloneOuterHeight=r.outerHeight()},_clonePosition:function(t){var e,o=this.s.start,r=this._eventToPage(t,"Y")-o.top,n=this._eventToPage(t,"X")-o.left,s=this.c.snapX,i=r+o.offsetTop;e=!0===s?o.offsetLeft:"number"==typeof s?o.offsetLeft+s:n+o.offsetLeft,i<0?i=0:i+this.s.domCloneOuterHeight>this.s.documentOuterHeight&&(i=this.s.documentOuterHeight-this.s.domCloneOuterHeight),this.dom.clone.css({top:i,left:e})},_emitEvent:function(e,o){this.s.dt.iterator("table",function(r,n){t(r.nTable).triggerHandler(e+".dt",o)})},_eventToPage:function(t,e){return-1!==t.type.indexOf("touch")?t.originalEvent.touches[0]["page"+e]:t["page"+e]},_mouseDown:function(r,n){var s=this,i=this.s.dt,d=this.s.start,a=n.offset();d.top=this._eventToPage(r,"Y"),d.left=this._eventToPage(r,"X"),d.offsetTop=a.top,d.offsetLeft=a.left,d.nodes=t.unique(i.rows({page:"current"}).nodes().toArray()),this._cachePositions(),this._clone(n),this._clonePosition(r),this.dom.target=n,n.addClass("dt-rowReorder-moving"),t(o).on("mouseup.rowReorder touchend.rowReorder",function(t){s._mouseUp(t)}).on("mousemove.rowReorder touchmove.rowReorder",function(t){s._mouseMove(t)}),t(e).width()===t(o).width()&&t(o.body).addClass("dt-rowReorder-noOverflow");var l=this.dom.dtScroll;this.s.scroll={windowHeight:t(e).height(),windowWidth:t(e).width(),dtTop:l.length?l.offset().top:null,dtLeft:l.length?l.offset().left:null,dtHeight:l.length?l.outerHeight():null,dtWidth:l.length?l.outerWidth():null}},_mouseMove:function(e){this._clonePosition(e);for(var o=this._eventToPage(e,"Y")-this.s.bodyTop,r=this.s.middles,n=null,s=this.s.dt,i=s.table().body(),d=0,a=r.length;d<a;d++)if(o<r[d]){n=d;break}if(null===n&&(n=r.length),null===this.s.lastInsert||this.s.lastInsert!==n){if(0===n)this.dom.target.prependTo(i);else{var l=t.unique(s.rows({page:"current"}).nodes().toArray());n>this.s.lastInsert?this.dom.target.insertAfter(l[n-1]):this.dom.target.insertBefore(l[n])}this._cachePositions(),this.s.lastInsert=n}this._shiftScroll(e)},_mouseUp:function(e){var r,n,s=this,i=this.s.dt,d=this.c.dataSrc;this.dom.clone.remove(),this.dom.clone=null,this.dom.target.removeClass("dt-rowReorder-moving"),t(o).off(".rowReorder"),t(o.body).removeClass("dt-rowReorder-noOverflow"),clearInterval(this.s.scrollInterval),this.s.scrollInterval=null;var a=this.s.start.nodes,l=t.unique(i.rows({page:"current"}).nodes().toArray()),h={},c=[],u=[],f=this.s.getDataFn,w=this.s.setDataFn;for(r=0,n=a.length;r<n;r++)if(a[r]!==l[r]){var p=i.row(l[r]).id(),g=i.row(l[r]).data(),m=i.row(a[r]).data();p&&(h[p]=f(m)),c.push({node:l[r],oldData:f(g),newData:f(m),newPosition:r,oldPosition:t.inArray(l[r],a)}),u.push(l[r])}var v=[c,{dataSrc:d,nodes:u,values:h,triggerRow:i.row(this.dom.target)}];this._emitEvent("row-reorder",v);var b=function(){if(s.c.update){for(r=0,n=c.length;r<n;r++){var t=i.row(c[r].node),e=t.data();w(e,c[r].newData),i.columns().every(function(){this.dataSrc()===d&&i.cell(c[r].node,this.index()).invalidate("data")})}s._emitEvent("row-reordered",v),i.draw(!1)}};this.c.editor?(this.c.enable=!1,this.c.editor.edit(u,!1,t.extend({submit:"changed"},this.c.formOptions)).multiSet(d,h).one("submitUnsuccessful.rowReorder",function(){i.draw(!1)}).one("submitSuccess.rowReorder",function(){b()}).one("submitComplete",function(){s.c.enable=!0,s.c.editor.off(".rowReorder")}).submit()):b()},_shiftScroll:function(t){var e,r,n=this,s=(this.s.dt,this.s.scroll),i=!1,d=t.pageY-o.body.scrollTop;d<65?e=-5:d>s.windowHeight-65&&(e=5),null!==s.dtTop&&t.pageY<s.dtTop+65?r=-5:null!==s.dtTop&&t.pageY>s.dtTop+s.dtHeight-65&&(r=5),e||r?(s.windowVert=e,s.dtVert=r,i=!0):this.s.scrollInterval&&(clearInterval(this.s.scrollInterval),this.s.scrollInterval=null),!this.s.scrollInterval&&i&&(this.s.scrollInterval=setInterval(function(){if(s.windowVert&&(o.body.scrollTop+=s.windowVert),s.dtVert){var t=n.dom.dtScroll[0];s.dtVert&&(t.scrollTop+=s.dtVert)}},20))}}),s.defaults={dataSrc:0,editor:null,enable:!0,formOptions:{},selector:"td:first-child",snapX:!1,update:!0};var i=t.fn.dataTable.Api;return i.register("rowReorder()",function(){return this}),i.register("rowReorder.enable()",function(t){return t===r&&(t=!0),this.iterator("table",function(e){e.rowreorder&&(e.rowreorder.c.enable=t)})}),i.register("rowReorder.disable()",function(){return this.iterator("table",function(t){t.rowreorder&&(t.rowreorder.c.enable=!1)})}),s.version="1.2.3",t.fn.dataTable.RowReorder=s,t.fn.DataTable.RowReorder=s,t(o).on("init.dt.dtr",function(e,o,r){if("dt"===e.namespace){var i=o.oInit.rowReorder,d=n.defaults.rowReorder;if(i||d){var a=t.extend({},i,d);!1!==i&&new s(o,a)}}}),s});