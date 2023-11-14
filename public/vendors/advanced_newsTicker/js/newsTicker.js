!function(t,i,s,o){"use strict";function n(i,s){this.element=i,this.$el=t(i),this.options=t.extend({},h,s),this._defaults=h,this._name=e,this.moveInterval,this.state=0,this.paused=0,this.moving=0,(this.$el.is("ul")||this.$el.is("ol"))&&this.init()}var e="newsTicker",h={row_height:20,max_rows:3,speed:400,duration:2500,direction:"up",autostart:1,pauseOnHover:1,nextButton:null,prevButton:null,startButton:null,stopButton:null,hasMoved:function(){},movingUp:function(){},movingDown:function(){},start:function(){},stop:function(){},pause:function(){},unpause:function(){}};n.prototype={init:function(){this.$el.height(this.options.row_height*this.options.max_rows).css({overflow:"hidden"}),this.checkSpeed(),this.options.nextButton&&void 0!==this.options.nextButton[0]&&this.options.nextButton.click(function(t){this.moveNext(),this.resetInterval()}.bind(this)),this.options.prevButton&&void 0!==this.options.prevButton[0]&&this.options.prevButton.click(function(t){this.movePrev(),this.resetInterval()}.bind(this)),this.options.stopButton&&void 0!==this.options.stopButton[0]&&this.options.stopButton.click(function(t){this.stop()}.bind(this)),this.options.startButton&&void 0!==this.options.startButton[0]&&this.options.startButton.click(function(t){this.start()}.bind(this)),this.options.pauseOnHover&&this.$el.hover(function(){this.state&&this.pause()}.bind(this),function(){this.state&&this.unpause()}.bind(this)),this.options.autostart&&this.start()},start:function(){this.state||(this.state=1,this.resetInterval(),this.options.start())},stop:function(){this.state&&(clearInterval(this.moveInterval),this.state=0,this.options.stop())},resetInterval:function(){this.state&&(clearInterval(this.moveInterval),this.moveInterval=setInterval(function(){this.move()}.bind(this),this.options.duration))},move:function(){this.paused||this.moveNext()},moveNext:function(){"down"===this.options.direction?this.moveDown():"up"===this.options.direction&&this.moveUp()},movePrev:function(){"down"===this.options.direction?this.moveUp():"up"===this.options.direction&&this.moveDown()},pause:function(){this.paused||(this.paused=1),this.options.pause()},unpause:function(){this.paused&&(this.paused=0),this.options.unpause()},moveDown:function(){this.moving||(this.moving=1,this.options.movingDown(),this.$el.children("li:last").detach().prependTo(this.$el).css("marginTop","-"+this.options.row_height+"px").animate({marginTop:"0px"},this.options.speed,function(){this.moving=0,this.options.hasMoved()}.bind(this)))},moveUp:function(){if(!this.moving){this.moving=1,this.options.movingUp();var t=this.$el.children("li:first");t.animate({marginTop:"-"+this.options.row_height+"px"},this.options.speed,function(){t.detach().css("marginTop","0").appendTo(this.$el),this.moving=0,this.options.hasMoved()}.bind(this))}},updateOption:function(t,i){void 0!==this.options[t]&&(this.options[t]=i,"duration"!=t&&"speed"!=t||(this.checkSpeed(),this.resetInterval()))},getState:function(){return paused?2:this.state},checkSpeed:function(){this.options.duration<this.options.speed+25&&(this.options.speed=this.options.duration-25)},destroy:function(){this._destroy()}},t.fn[e]=function(i){var s=arguments;return this.each(function(){var o=t(this),h=t.data(this,"plugin_"+e),p="object"==typeof i&&i;h||o.data("plugin_"+e,h=new n(this,p)),"string"==typeof i&&h[i].apply(h,Array.prototype.slice.call(s,1))})}}(jQuery,window,document);