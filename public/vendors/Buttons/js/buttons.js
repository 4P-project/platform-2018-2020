!function(t,n,i,e){"use strict";function o(n,i){this.options=t.extend({},u,i),this._defaults=u,this._name=s,this.$element=t(n),this.init()}var s="menuButton",u={propertyName:"value"};o.prototype={constructor:o,init:function(){this.toggle()},toggle:function(t,n){"show"===this.$element.data("dropdown")?this.hideMenu():this.showMenu()},showMenu:function(){this.$element.data("dropdown","show"),this.$element.find("ul").show(),this.$element.find(".button:first").addClass("is-active")},hideMenu:function(){this.$element.data("dropdown","hide"),this.$element.find("ul").hide(),this.$element.find(".button:first").removeClass("is-active")}},t.fn[s]=function(n){return this.each(function(){t.data(this,"plugin_"+s)?t.data(this,"plugin_"+s).toggle():t.data(this,"plugin_"+s,new o(this,n))})},t(i).on("click",function(n){t.each(t("[data-buttons=dropdown]"),function(i,e){t(n.target.offsetParent)[0]!=t(this)[0]&&t.data(this,"plugin_"+s)&&(t.data(this,"plugin_"+s).hideMenu(),t(this).find("ul").hide())})}),t(i).on("click","[data-buttons=dropdown]",function(n){t(n.currentTarget).menuButton()}),t(i).on("click","[data-buttons=dropdown] > a",function(t){t.preventDefault()})}(jQuery,window,document);