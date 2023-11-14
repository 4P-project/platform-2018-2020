!function(){var t=window.AmCharts;t.AmSerialChart=t.Class({inherits:t.AmRectangularChart,construct:function(e){this.type="serial",t.AmSerialChart.base.construct.call(this,e),this.cname="AmSerialChart",this.theme=e,this.createEvents("changed"),this.columnSpacing=5,this.columnSpacing3D=0,this.columnWidth=.8,this.updateScrollbar=!0;var i=new t.CategoryAxis(e);i.chart=this,this.categoryAxis=i,this.zoomOutOnDataUpdate=!0,this.mouseWheelZoomEnabled=this.mouseWheelScrollEnabled=this.rotate=this.skipZoom=!1,this.minSelectedTime=0,t.applyTheme(this,e,this.cname)},initChart:function(){t.AmSerialChart.base.initChart.call(this),this.updateCategoryAxis(this.categoryAxis,this.rotate,"categoryAxis"),this.dataChanged&&(this.updateData(),this.dataChanged=!1,this.dispatchDataUpdated=!0);var e=this.chartCursor;e&&e.updateData&&(e.updateData(),e.fullWidth&&(e.fullRectSet=this.cursorLineSet));var i,e=this.countColumns(),a=this.graphs;for(i=0;i<a.length;i++)a[i].columnCount=e;this.updateScrollbar=!0,this.drawChart(),this.autoMargins&&!this.marginsUpdated&&(this.marginsUpdated=!0,this.measureMargins())},handleWheelReal:function(t,e){if(!this.wheelBusy){var i=this.categoryAxis,a=i.parseDates,s=i.minDuration(),h=i=1;this.mouseWheelZoomEnabled?e||(i=-1):e&&(i=-1);var r=this.chartData.length,o=this.lastTime,n=this.firstTime;0>t?a?(r=this.endTime-this.startTime,a=this.startTime+i*s,s=this.endTime+h*s,0<h&&0<i&&s>=o&&(s=o,a=o-r),this.zoomToDates(new Date(a),new Date(s))):(0<h&&0<i&&this.end>=r-1&&(i=h=0),a=this.start+i,s=this.end+h,this.zoomToIndexes(a,s)):a?(r=this.endTime-this.startTime,a=this.startTime-i*s,s=this.endTime-h*s,0<h&&0<i&&a<=n&&(a=n,s=n+r),this.zoomToDates(new Date(a),new Date(s))):(0<h&&0<i&&1>this.start&&(i=h=0),a=this.start-i,s=this.end-h,this.zoomToIndexes(a,s))}},validateData:function(e){this.marginsUpdated=!1,this.zoomOutOnDataUpdate&&!e&&(this.endTime=this.end=this.startTime=this.start=NaN),t.AmSerialChart.base.validateData.call(this)},drawChart:function(){if(0<this.realWidth&&0<this.realHeight){t.AmSerialChart.base.drawChart.call(this);var e=this.chartData;if(t.ifArray(e)){var i=this.chartScrollbar;i&&i.draw();var a,e=e.length-1,i=this.categoryAxis;i.parseDates&&!i.equalSpacing?(i=this.startTime,a=this.endTime,(isNaN(i)||isNaN(a))&&(i=this.firstTime,a=this.lastTime)):(i=this.start,a=this.end,(isNaN(i)||isNaN(a))&&(i=0,a=e)),this.endTime=this.startTime=this.end=this.start=void 0,this.zoom(i,a)}}else this.cleanChart();this.dispDUpd()},cleanChart:function(){t.callMethod("destroy",[this.valueAxes,this.graphs,this.categoryAxis,this.chartScrollbar,this.chartCursor])},updateCategoryAxis:function(e,i,a){e.chart=this,e.id=a,e.rotate=i,e.axisRenderer=t.RecAxis,e.guideFillRenderer=t.RecFill,e.axisItemRenderer=t.RecItem,e.setOrientation(!this.rotate),e.x=this.marginLeftReal,e.y=this.marginTopReal,e.dx=this.dx,e.dy=this.dy,e.width=this.plotAreaWidth-1,e.height=this.plotAreaHeight-1,e.viW=this.plotAreaWidth-1,e.viH=this.plotAreaHeight-1,e.viX=this.marginLeftReal,e.viY=this.marginTopReal,e.marginsChanged=!0},updateValueAxes:function(){t.AmSerialChart.base.updateValueAxes.call(this);var e,i=this.valueAxes;for(e=0;e<i.length;e++){var a=i[e],s=this.rotate;a.rotate=s,a.setOrientation(s),s=this.categoryAxis,s.startOnAxis&&!s.parseDates||(a.expandMinMax=!0)}},updateData:function(){this.parseData();var t,e=this.graphs,i=this.chartData;for(t=0;t<e.length;t++)e[t].data=i;0<i.length&&(this.firstTime=this.getStartTime(i[0].time),this.lastTime=this.getEndTime(i[i.length-1].time))},getStartTime:function(e){var i=this.categoryAxis;return t.resetDateToMin(new Date(e),i.minPeriod,1,i.firstDayOfWeek).getTime()},getEndTime:function(e){var i=t.extractPeriod(this.categoryAxis.minPeriod);return t.changeDate(new Date(e),i.period,i.count,!0).getTime()-1},updateMargins:function(){t.AmSerialChart.base.updateMargins.call(this);var e=this.chartScrollbar;e&&(this.getScrollbarPosition(e,this.rotate,this.categoryAxis.position),this.adjustMargins(e,this.rotate))},updateScrollbars:function(){t.AmSerialChart.base.updateScrollbars.call(this),this.updateChartScrollbar(this.chartScrollbar,this.rotate)},zoom:function(t,e){var i=this.categoryAxis;i.parseDates&&!i.equalSpacing?this.timeZoom(t,e):this.indexZoom(t,e),this.updateLegendValues()},timeZoom:function(e,i){var a=this.maxSelectedTime;isNaN(a)||(i!=this.endTime&&i-e>a&&(e=i-a,this.updateScrollbar=!0),e!=this.startTime&&i-e>a&&(i=e+a,this.updateScrollbar=!0));var s=this.minSelectedTime;if(0<s&&i-e<s){var h=Math.round(e+(i-e)/2),s=Math.round(s/2);e=h-s,i=h+s}var r=this.chartData,h=this.categoryAxis;if(t.ifArray(r)&&(e!=this.startTime||i!=this.endTime)){var o=h.minDuration(),s=this.firstTime,n=this.lastTime;e||(e=s,isNaN(a)||(e=n-a)),i||(i=n),e>n&&(e=n),i<s&&(i=s),e<s&&(e=s),i>n&&(i=n),i<e&&(i=e+o),i-e<o/5&&(i<n?i=e+o/5:e=i-o/5),this.startTime=e,this.endTime=i,a=r.length-1,o=this.getClosestIndex(r,"time",e,!0,0,a),r=this.getClosestIndex(r,"time",i,!1,o,a),h.timeZoom(e,i),h.zoom(o,r),this.start=t.fitToBounds(o,0,a),this.end=t.fitToBounds(r,0,a),this.zoomAxesAndGraphs(),this.zoomScrollbar(),e!=s||i!=n?this.showZB(!0):this.showZB(!1),this.updateColumnsDepth(),this.dispatchTimeZoomEvent()}},updateAfterValueZoom:function(){this.zoomAxesAndGraphs(),this.zoomScrollbar(),this.updateColumnsDepth()},indexZoom:function(t,e){var i=this.maxSelectedSeries;if(isNaN(i)||(e!=this.end&&e-t>i&&(t=e-i,this.updateScrollbar=!0),t!=this.start&&e-t>i&&(e=t+i,this.updateScrollbar=!0)),t!=this.start||e!=this.end){var a=this.chartData.length-1;isNaN(t)&&(t=0,isNaN(i)||(t=a-i)),isNaN(e)&&(e=a),e<t&&(e=t),e>a&&(e=a),t>a&&(t=a-1),0>t&&(t=0),this.start=t,this.end=e,this.categoryAxis.zoom(t,e),this.zoomAxesAndGraphs(),this.zoomScrollbar(),0!==t||e!=this.chartData.length-1?this.showZB(!0):this.showZB(!1),this.updateColumnsDepth(),this.dispatchIndexZoomEvent()}},updateGraphs:function(){t.AmSerialChart.base.updateGraphs.call(this);var e,i=this.graphs;for(e=0;e<i.length;e++){var a=i[e];a.columnWidthReal=this.columnWidth,a.categoryAxis=this.categoryAxis,t.isString(a.fillToGraph)&&(a.fillToGraph=this.getGraphById(a.fillToGraph))}},updateColumnsDepth:function(){var e,i,a=this.graphs;for(t.remove(this.columnsSet),this.columnsArray=[],e=0;e<a.length;e++){i=a[e];var s=i.columnsArray;if(s){var h;for(h=0;h<s.length;h++)this.columnsArray.push(s[h])}}if(this.columnsArray.sort(this.compareDepth),0<this.columnsArray.length){for(a=this.container.set(),this.columnSet.push(a),e=0;e<this.columnsArray.length;e++)a.push(this.columnsArray[e].column.set);i&&a.translate(i.x,i.y),this.columnsSet=a}},compareDepth:function(t,e){return t.depth>e.depth?1:-1},zoomScrollbar:function(){var t=this.chartScrollbar,e=this.categoryAxis;t&&this.updateScrollbar&&t.enabled&&t.dragger&&(t.dragger.stop(),e.parseDates&&!e.equalSpacing?t.timeZoom(this.startTime,this.endTime):t.zoom(this.start,this.end),this.updateScrollbar=!0)},updateTrendLines:function(){var e,i=this.trendLines;for(e=0;e<i.length;e++){var a=i[e],a=t.processObject(a,t.TrendLine,this.theme);i[e]=a,a.chart=this,a.id||(a.id="trendLineAuto"+e+"_"+(new Date).getTime()),t.isString(a.valueAxis)&&(a.valueAxis=this.getValueAxisById(a.valueAxis)),a.valueAxis||(a.valueAxis=this.valueAxes[0]),a.categoryAxis=this.categoryAxis}},zoomAxesAndGraphs:function(){if(!this.scrollbarOnly){var t,e=this.valueAxes;for(t=0;t<e.length;t++)e[t].zoom(this.start,this.end);for(e=this.graphs,t=0;t<e.length;t++)e[t].zoom(this.start,this.end);this.zoomTrendLines(),(t=this.chartCursor)&&t.zoom&&t.zoom(this.start,this.end,this.startTime,this.endTime)}},countColumns:function(){var t,e,i,a,s=0,h=this.valueAxes.length,r=this.graphs.length,o=!1;for(a=0;a<h;a++){e=this.valueAxes[a];var n=e.stackType;if("100%"==n||"regular"==n)for(o=!1,i=0;i<r;i++)t=this.graphs[i],t.tcc=1,t.valueAxis==e&&"column"==t.type&&(!o&&t.stackable&&(s++,o=!0),(!t.stackable&&t.clustered||t.newStack)&&s++,t.columnIndex=s-1,t.clustered||(t.columnIndex=0));if("none"==n||"3d"==n){for(o=!1,i=0;i<r;i++)t=this.graphs[i],t.valueAxis==e&&"column"==t.type&&(t.clustered?(t.tcc=1,t.newStack&&(s=0),t.hidden||(t.columnIndex=s,s++)):t.hidden||(o=!0,t.tcc=1,t.columnIndex=0));o&&0===s&&(s=1)}if("3d"==n){for(e=1,a=0;a<r;a++)t=this.graphs[a],t.newStack&&e++,t.depthCount=e,t.tcc=s;s=e}}return s},parseData:function(){t.AmSerialChart.base.parseData.call(this),this.parseSerialData(this.dataProvider)},getCategoryIndexByValue:function(t){var e,i,a=this.chartData;for(i=0;i<a.length;i++)a[i].category==t&&(e=i);return e},handleCursorChange:function(t){this.updateLegendValues(t.index)},handleCursorZoom:function(t){this.updateScrollbar=!0,this.zoom(t.start,t.end)},handleScrollbarZoom:function(t){this.updateScrollbar=!1,this.zoom(t.start,t.end)},dispatchTimeZoomEvent:function(){if(this.prevStartTime!=this.startTime||this.prevEndTime!=this.endTime){var e={type:"zoomed"};e.startDate=new Date(this.startTime),e.endDate=new Date(this.endTime),e.startIndex=this.start,e.endIndex=this.end,this.startIndex=this.start,this.endIndex=this.end,this.startDate=e.startDate,this.endDate=e.endDate,this.prevStartTime=this.startTime,this.prevEndTime=this.endTime;var i=this.categoryAxis,a=t.extractPeriod(i.minPeriod).period,i=i.dateFormatsObject[a];e.startValue=t.formatDate(e.startDate,i,this),e.endValue=t.formatDate(e.endDate,i,this),e.chart=this,e.target=this,this.fire(e.type,e)}},dispatchIndexZoomEvent:function(){if(this.prevStartIndex!=this.start||this.prevEndIndex!=this.end){this.startIndex=this.start,this.endIndex=this.end;var e=this.chartData;if(t.ifArray(e)&&!isNaN(this.start)&&!isNaN(this.end)){var i={chart:this,target:this,type:"zoomed"};i.startIndex=this.start,i.endIndex=this.end,i.startValue=e[this.start].category,i.endValue=e[this.end].category,this.categoryAxis.parseDates&&(this.startTime=e[this.start].time,this.endTime=e[this.end].time,i.startDate=new Date(this.startTime),i.endDate=new Date(this.endTime)),this.prevStartIndex=this.start,this.prevEndIndex=this.end,this.fire(i.type,i)}}},updateLegendValues:function(t){var e,i=this.graphs;for(e=0;e<i.length;e++){var a=i[e];isNaN(t)?a.currentDataItem=void 0:a.currentDataItem=this.chartData[t].axes[a.valueAxis.id].graphs[a.id]}this.legend&&this.legend.updateValues()},getClosestIndex:function(t,e,i,a,s,h){0>s&&(s=0),h>t.length-1&&(h=t.length-1);var r=s+Math.round((h-s)/2),o=t[r][e];return i==o?r:1>=h-s?a?s:(a=t[h][e],Math.abs(t[s][e]-i)<Math.abs(a-i)?s:h):i==o?r:i<o?this.getClosestIndex(t,e,i,a,s,r):this.getClosestIndex(t,e,i,a,r,h)},zoomToIndexes:function(t,e){this.updateScrollbar=!0;var i=this.chartData;if(i){var a=i.length;0<a&&(0>t&&(t=0),e>a-1&&(e=a-1),a=this.categoryAxis,a.parseDates&&!a.equalSpacing?this.zoom(i[t].time,this.getEndTime(i[e].time)):this.zoom(t,e))}},zoomToDates:function(e,i){this.updateScrollbar=!0;var a=this.chartData;if(this.categoryAxis.equalSpacing){var s=this.getClosestIndex(a,"time",e.getTime(),!0,0,a.length);i=t.resetDateToMin(i,this.categoryAxis.minPeriod,1),a=this.getClosestIndex(a,"time",i.getTime(),!1,0,a.length),this.zoom(s,a)}else this.zoom(e.getTime(),i.getTime())},zoomToCategoryValues:function(t,e){this.updateScrollbar=!0,this.zoom(this.getCategoryIndexByValue(t),this.getCategoryIndexByValue(e))},formatPeriodString:function(e,i){if(i){var a=["value","open","low","high","close"],s="value open low high close average sum count".split(" "),h=i.valueAxis,r=this.chartData,o=i.numberFormatter;o||(o=this.nf);for(var n=0;n<a.length;n++){for(var d,l,c,u,m,g,p,f,x,v,D=a[n],T=0,b=0,y=0,A=0,C=this.start;C<=this.end;C++){var N=r[C];if(N&&(N=N.axes[h.id].graphs[i.id])){if(N.values){var S=N.values[D];if(this.rotate?(0>N.x||N.x>N.graph.height)&&(S=NaN):(0>N.x||N.x>N.graph.width)&&(S=NaN),!isNaN(S)){isNaN(d)&&(d=S),l=S,(isNaN(c)||c>S)&&(c=S),(isNaN(u)||u<S)&&(u=S),m=t.getDecimals(T);var w=t.getDecimals(S),T=T+S,T=t.roundTo(T,Math.max(m,w));b++,m=T/b}}N.percents&&(N=N.percents[D],!isNaN(N))&&(isNaN(g)&&(g=N),p=N,(isNaN(f)||f>N)&&(f=N),(isNaN(x)||x<N)&&(x=N),v=t.getDecimals(y),S=t.getDecimals(N),y+=N,y=t.roundTo(y,Math.max(v,S)),A++,v=y/A)}}y={open:g,close:p,high:x,low:f,average:v,sum:y,count:A},e=t.formatValue(e,{open:d,close:l,high:u,low:c,average:m,sum:T,count:b},s,o,D+"\\.",this.usePrefixes,this.prefixesOfSmallNumbers,this.prefixesOfBigNumbers),e=t.formatValue(e,y,s,this.pf,"percents\\."+D+"\\.")}}return e=t.cleanFromEmpty(e)},formatString:function(e,i,a){var s=i.graph;if(-1!=e.indexOf("[[category]]")){var h=i.serialDataItem.category;if(this.categoryAxis.parseDates){var r=this.balloonDateFormat,o=this.chartCursor;o&&(r=o.categoryBalloonDateFormat),-1!=e.indexOf("[[category]]")&&(r=t.formatDate(h,r,this),-1!=r.indexOf("fff")&&(r=t.formatMilliseconds(r,h)),h=r)}e=e.replace(/\[\[category\]\]/g,String(h))}return h=s.numberFormatter,h||(h=this.nf),r=i.graph.valueAxis,(o=r.duration)&&!isNaN(i.values.value)&&(o=t.formatDuration(i.values.value,o,"",r.durationUnits,r.maxInterval,h),e=e.replace(RegExp("\\[\\[value\\]\\]","g"),o)),"date"==r.type&&(r=t.formatDate(new Date(i.values.value),s.dateFormat,this),o=RegExp("\\[\\[value\\]\\]","g"),e=e.replace(o,r),r=t.formatDate(new Date(i.values.open),s.dateFormat,this),o=RegExp("\\[\\[open\\]\\]","g"),e=e.replace(o,r)),s="value open low high close total".split(" "),r=this.pf,e=t.formatValue(e,i.percents,s,r,"percents\\."),e=t.formatValue(e,i.values,s,h,"",this.usePrefixes,this.prefixesOfSmallNumbers,this.prefixesOfBigNumbers),e=t.formatValue(e,i.values,["percents"],r),-1!=e.indexOf("[[")&&(e=t.formatDataContextValue(e,i.dataContext)),-1!=e.indexOf("[[")&&i.graph.customData&&(e=t.formatDataContextValue(e,i.graph.customData)),e=t.AmSerialChart.base.formatString.call(this,e,i,a)},addChartScrollbar:function(e){t.callMethod("destroy",[this.chartScrollbar]),e&&(e.chart=this,this.listenTo(e,"zoomed",this.handleScrollbarZoom)),this.rotate?void 0===e.width&&(e.width=e.scrollbarHeight):void 0===e.height&&(e.height=e.scrollbarHeight),this.chartScrollbar=e},removeChartScrollbar:function(){t.callMethod("destroy",[this.chartScrollbar]),this.chartScrollbar=null},handleReleaseOutside:function(e){t.AmSerialChart.base.handleReleaseOutside.call(this,e),t.callMethod("handleReleaseOutside",[this.chartScrollbar])},update:function(){t.AmSerialChart.base.update.call(this),this.chartScrollbar&&this.chartScrollbar.update&&this.chartScrollbar.update()}})}(),function(){var t=window.AmCharts;t.Cuboid=t.Class({construct:function(t,e,i,a,s,h,r,o,n,d,l,c,u,m,g,p,f){this.set=t.set(),this.container=t,this.h=Math.round(i),this.w=Math.round(e),this.dx=a,this.dy=s,this.colors=h,this.alpha=r,this.bwidth=o,this.bcolor=n,this.balpha=d,this.dashLength=m,this.topRadius=p,this.pattern=g,this.rotate=u,this.bcn=f,u?0>e&&0===l&&(l=180):0>i&&270==l&&(l=90),this.gradientRotation=l,0===a&&0===s&&(this.cornerRadius=c),this.draw()},draw:function(){var e=this.set;e.clear();var i=this.container,a=i.chart,s=this.w,h=this.h,r=this.dx,o=this.dy,n=this.colors,d=this.alpha,l=this.bwidth,c=this.bcolor,u=this.balpha,m=this.gradientRotation,g=this.cornerRadius,p=this.dashLength,f=this.pattern,x=this.topRadius,v=this.bcn,D=n,T=n;"object"==typeof n&&(D=n[0],T=n[n.length-1]);var b,y,A,C,N,S,w,M,I,R=d;f&&(d=0);var W,P,L,z,O=this.rotate;if(0<Math.abs(r)||0<Math.abs(o))if(isNaN(x))w=T,T=t.adjustLuminosity(D,-.2),T=t.adjustLuminosity(D,-.2),b=t.polygon(i,[0,r,s+r,s,0],[0,o,o,0,0],T,d,1,c,0,m),0<u&&(I=t.line(i,[0,r,s+r],[0,o,o],c,u,l,p)),y=t.polygon(i,[0,0,s,s,0],[0,h,h,0,0],T,d,1,c,0,m),y.translate(r,o),0<u&&(A=t.line(i,[r,r],[o,o+h],c,u,l,p)),C=t.polygon(i,[0,0,r,r,0],[0,h,h+o,o,0],T,d,1,c,0,m),N=t.polygon(i,[s,s,s+r,s+r,s],[0,h,h+o,o,0],T,d,1,c,0,m),0<u&&(S=t.line(i,[s,s+r,s+r,s],[0,o,h+o,h],c,u,l,p)),T=t.adjustLuminosity(w,.2),w=t.polygon(i,[0,r,s+r,s,0],[h,h+o,h+o,h,h],T,d,1,c,0,m),0<u&&(M=t.line(i,[0,r,s+r],[h,h+o,h+o],c,u,l,p));else{var B,F,V;O?(B=h/2,T=r/2,V=h/2,F=s+r/2,P=Math.abs(h/2),W=Math.abs(r/2)):(T=s/2,B=o/2,F=s/2,V=h+o/2+1,W=Math.abs(s/2),P=Math.abs(o/2)),L=W*x,z=P*x,.1<W&&.1<W&&(b=t.circle(i,W,D,d,l,c,u,!1,P),b.translate(T,B)),.1<L&&.1<L&&(w=t.circle(i,L,t.adjustLuminosity(D,.5),d,l,c,u,!1,z),w.translate(F,V))}for(d=R,1>Math.abs(h)&&(h=0),1>Math.abs(s)&&(s=0),!isNaN(x)&&(0<Math.abs(r)||0<Math.abs(o))?(n=[D],n={fill:n,stroke:c,"stroke-width":l,"stroke-opacity":u,"fill-opacity":d},O?(d="M0,0 L"+s+","+(h/2-h/2*x),l=" B",0<s&&(l=" A"),t.VML?(d+=l+Math.round(s-L)+","+Math.round(h/2-z)+","+Math.round(s+L)+","+Math.round(h/2+z)+","+s+",0,"+s+","+h,d=d+" L0,"+h+(l+Math.round(-W))+","+Math.round(h/2-P)+","+Math.round(W)+","+Math.round(h/2+P)+",0,"+h+",0,0"):(d+="A"+L+","+z+",0,0,0,"+s+","+(h-h/2*(1-x))+"L0,"+h,d+="A"+W+","+P+",0,0,1,0,0"),W=90):(l=s/2-s/2*x,d="M0,0 L"+l+","+h,t.VML?(d="M0,0 L"+l+","+h,l=" B",0>h&&(l=" A"),d+=l+Math.round(s/2-L)+","+Math.round(h-z)+","+Math.round(s/2+L)+","+Math.round(h+z)+",0,"+h+","+s+","+h,d+=" L"+s+",0",d+=l+Math.round(s/2+W)+","+Math.round(P)+","+Math.round(s/2-W)+","+Math.round(-P)+","+s+",0,0,0"):(d+="A"+L+","+z+",0,0,0,"+(s-s/2*(1-x))+","+h+"L"+s+",0",d+="A"+W+","+P+",0,0,1,0,0"),W=180),i=i.path(d).attr(n),i.gradient("linearGradient",[D,t.adjustLuminosity(D,-.3),t.adjustLuminosity(D,-.3),D],W),O?i.translate(r/2,0):i.translate(0,o/2)):i=0===h?t.line(i,[0,s],[0,0],c,u,l,p):0===s?t.line(i,[0,0],[0,h],c,u,l,p):0<g?t.rect(i,s,h,n,d,l,c,u,g,m,p):t.polygon(i,[0,0,s,s,0],[0,h,h,0,0],n,d,l,c,u,m,!1,p),s=isNaN(x)?0>h?[b,I,y,A,C,N,S,w,M,i]:[w,M,y,A,C,N,b,I,S,i]:O?0<s?[b,i,w]:[w,i,b]:0>h?[b,i,w]:[w,i,b],t.setCN(a,i,v+"front"),t.setCN(a,y,v+"back"),t.setCN(a,w,v+"top"),t.setCN(a,b,v+"bottom"),t.setCN(a,C,v+"left"),t.setCN(a,N,v+"right"),b=0;b<s.length;b++)(y=s[b])&&(e.push(y),t.setCN(a,y,v+"element"));f&&i.pattern(f,NaN,a.path)},width:function(t){isNaN(t)&&(t=0),this.w=Math.round(t),this.draw()},height:function(t){isNaN(t)&&(t=0),this.h=Math.round(t),this.draw()},animateHeight:function(e,i){var a=this;a.easing=i,a.totalFrames=Math.round(1e3*e/t.updateRate),a.rh=a.h,a.frame=0,a.height(1),setTimeout(function(){a.updateHeight.call(a)},t.updateRate)},updateHeight:function(){var e=this;e.frame++;var i=e.totalFrames;e.frame<=i&&(i=e.easing(0,e.frame,1,e.rh-1,i),e.height(i),setTimeout(function(){e.updateHeight.call(e)},t.updateRate))},animateWidth:function(e,i){var a=this;a.easing=i,a.totalFrames=Math.round(1e3*e/t.updateRate),a.rw=a.w,a.frame=0,a.width(1),setTimeout(function(){a.updateWidth.call(a)},t.updateRate)},updateWidth:function(){var e=this;e.frame++;var i=e.totalFrames;e.frame<=i&&(i=e.easing(0,e.frame,1,e.rw-1,i),e.width(i),setTimeout(function(){e.updateWidth.call(e)},t.updateRate))}})}(),function(){var t=window.AmCharts;t.CategoryAxis=t.Class({inherits:t.AxisBase,construct:function(e){this.cname="CategoryAxis",t.CategoryAxis.base.construct.call(this,e),this.minPeriod="DD",this.equalSpacing=this.parseDates=!1,this.position="bottom",this.startOnAxis=!1,this.firstDayOfWeek=1,this.gridPosition="middle",this.markPeriodChange=this.boldPeriodBeginning=!0,this.safeDistance=30,this.centerLabelOnFullPeriod=!0,t.applyTheme(this,e,this.cname)},draw:function(){t.CategoryAxis.base.draw.call(this),this.generateDFObject();var e=this.chart.chartData;if(this.data=e,this.labelRotationR=this.labelRotation,t.ifArray(e)){var i,a=this.chart;"scrollbar"!=this.id?(t.setCN(a,this.set,"category-axis"),t.setCN(a,this.labelsSet,"category-axis"),t.setCN(a,this.axisLine.axisSet,"category-axis")):this.bcn=this.id+"-";var s,h,r,o,n,d=this.start,l=this.labelFrequency,c=0,u=this.end-d+1,m=this.gridCountR,g=this.showFirstLabel,p=this.showLastLabel,f="",f=t.extractPeriod(this.minPeriod),x=t.getPeriodDuration(f.period,f.count);h=this.rotate,i=this.firstDayOfWeek,s=this.boldPeriodBeginning,n=t.resetDateToMin(new Date(e[e.length-1].time+1.05*x),this.minPeriod,1,i).getTime(),this.firstTime=a.firstTime,this.endTime>n&&(this.endTime=n),n=this.minorGridEnabled;var v=this.gridAlpha;if(this.parseDates&&!this.equalSpacing)this.lastTime=e[e.length-1].time,this.maxTime=t.resetDateToMin(new Date(this.lastTime+1.05*x),this.minPeriod,1,i).getTime(),this.timeDifference=this.endTime-this.startTime,this.parseDatesDraw();else if(this.parseDates){if(this.parseDates&&this.equalSpacing){if(c=this.start,this.startTime=this.data[this.start].time,this.endTime=this.data[this.end].time,this.timeDifference=this.endTime-this.startTime,d=this.choosePeriod(0),l=d.period,h=d.count,e=t.getPeriodDuration(l,h),e<x&&(l=f.period,h=f.count,e=x),r=l,"WW"==r&&(r="DD"),this.stepWidth=this.getStepWidth(u),m=Math.ceil(this.timeDifference/e)+1,f=t.resetDateToMin(new Date(this.startTime-e),l,h,i).getTime(),this.cellWidth=this.getStepWidth(u),u=Math.round(f/e),d=-1,u/2==Math.round(u/2)&&(d=-2,f-=e),u=this.start,u/2==Math.round(u/2)&&u--,0>u&&(u=0),v=this.end+2,v>=this.data.length&&(v=this.data.length),D=!1,D=!g,this.previousPos=-1e3,20<this.labelRotationR&&(this.safeDistance=5),T=u,this.data[u].time!=t.resetDateToMin(new Date(this.data[u].time),l,h,i).getTime())for(e=0,b=f,i=u;i<v;i++)x=this.data[i].time,this.checkPeriodChange(l,h,x,b)&&(e++,2<=e&&(T=i,i=v),b=x);if(n&&1<h&&(x=this.chooseMinorFrequency(h),t.getPeriodDuration(l,x)),0<this.gridCountR)for(i=u;i<v;i++)x=this.data[i].time,this.checkPeriodChange(l,h,x,f)&&i>=T&&(u=this.getCoordinate(i-this.start),n=!1,this.nextPeriod[r]&&(n=this.checkPeriodChange(this.nextPeriod[r],1,x,f,r)),e=!1,n&&this.markPeriodChange?(n=this.dateFormatsObject[this.nextPeriod[r]],e=!0):n=this.dateFormatsObject[r],f=t.formatDate(new Date(x),n,a),(i==d&&!g||i==m&&!p)&&(f=" "),D?D=!1:(s||(e=!1),u-this.previousPos>this.safeDistance*Math.cos(this.labelRotationR*Math.PI/180)&&(this.labelFunction&&(f=this.labelFunction(f,new Date(x),this,l,h,o)),this.boldLabels&&(e=!0),o=new this.axisItemRenderer(this,u,f,void 0,void 0,void 0,void 0,e),n=o.graphics(),this.pushAxisItem(o),n=n.getBBox().width,t.isModern||(n-=u),this.previousPos=u+n)),o=f=x)}}else if(this.cellWidth=this.getStepWidth(u),u<m&&(m=u),c+=this.start,this.stepWidth=this.getStepWidth(u),0<m){m=Math.floor(u/m),x=this.chooseMinorFrequency(m),u=c,u/2==Math.round(u/2)&&u--,0>u&&(u=0);var D=0;for(this.end-u+1>=this.autoRotateCount&&(this.labelRotationR=this.autoRotateAngle),i=u;i<=this.end+2;i++){if(s=!1,0<=i&&i<this.data.length?(r=this.data[i],f=r.category,s=r.forceShow):f="",n&&!isNaN(x)){if(i/x!=Math.round(i/x)&&!s)continue;i/m==Math.round(i/m)||s||(this.gridAlpha=this.minorGridAlpha,f=void 0)}else if(i/m!=Math.round(i/m)&&!s)continue;u=this.getCoordinate(i-c),o=0,"start"==this.gridPosition&&(u-=this.cellWidth/2,o=this.cellWidth/2),s=!0;var T=o;"start"==this.tickPosition&&(T=0,s=!1,o=0),(i==d&&!g||i==this.end&&!p)&&(f=void 0),Math.round(D/l)!=D/l&&(f=void 0),D++;var b=this.cellWidth;h&&(b=NaN,this.ignoreAxisWidth||!a.autoMargins)&&(b="right"==this.position?a.marginRight:a.marginLeft,b-=this.tickLength+10),this.labelFunction&&r&&(f=this.labelFunction(f,r,this)),f=t.fixBrakes(f),e=!1,this.boldLabels&&(e=!0),i>this.end&&"start"==this.tickPosition&&(f=" "),this.rotate&&this.inside&&(o=-2),o=new this.axisItemRenderer(this,u,f,s,b,o,void 0,e,T,!1,r.labelColor,r.className),o.serialDataItem=r,this.pushAxisItem(o),this.gridAlpha=v}}for(i=0;i<this.data.length;i++)(g=this.data[i])&&(p=this.parseDates&&!this.equalSpacing?Math.round((g.time-this.startTime)*this.stepWidth+this.cellWidth/2):this.getCoordinate(i-c),g.x[this.id]=p);for(g=this.guides.length,i=0;i<g;i++)p=this.guides[i],s=o=o=m=n=NaN,d=p.above,p.toCategory&&(o=a.getCategoryIndexByValue(p.toCategory),isNaN(o)||(n=this.getCoordinate(o-c),p.expand&&(n+=this.cellWidth/2),o=new this.axisItemRenderer(this,n,"",!0,NaN,NaN,p),this.pushAxisItem(o,d))),p.category&&(s=a.getCategoryIndexByValue(p.category),isNaN(s)||(m=this.getCoordinate(s-c),p.expand&&(m-=this.cellWidth/2),o=(n-m)/2,o=new this.axisItemRenderer(this,m,p.label,!0,NaN,o,p),this.pushAxisItem(o,d))),s=a.dataDateFormat,p.toDate&&(p.toDate=t.getDate(p.toDate,s,this.minPeriod),this.equalSpacing?(o=a.getClosestIndex(this.data,"time",p.toDate.getTime(),!1,0,this.data.length-1),isNaN(o)||(n=this.getCoordinate(o-c))):n=(p.toDate.getTime()-this.startTime)*this.stepWidth,o=new this.axisItemRenderer(this,n,"",!0,NaN,NaN,p),this.pushAxisItem(o,d)),p.date&&(p.date=t.getDate(p.date,s,this.minPeriod),this.equalSpacing?(s=a.getClosestIndex(this.data,"time",p.date.getTime(),!1,0,this.data.length-1),isNaN(s)||(m=this.getCoordinate(s-c))):m=(p.date.getTime()-this.startTime)*this.stepWidth,o=(n-m)/2,s=!0,p.toDate&&(s=!1),o="H"==this.orientation?new this.axisItemRenderer(this,m,p.label,s,2*o,NaN,p):new this.axisItemRenderer(this,m,p.label,!1,NaN,o,p),this.pushAxisItem(o,d)),(0<n||0<m)&&(n<this.width||m<this.width)&&(n=new this.guideFillRenderer(this,m,n,p),s=n.graphics(),this.pushAxisItem(n,d),p.graphics=s,s.index=i,p.balloonText&&this.addEventListeners(s,p))}this.axisCreated=!0,a=this.x,c=this.y,this.set.translate(a,c),this.labelsSet.translate(a,c),this.labelsSet.show(),this.positionTitle(),(a=this.axisLine.set)&&a.toFront(),a=this.getBBox().height,2<a-this.previousHeight&&this.autoWrap&&!this.parseDates&&(this.axisCreated=this.chart.marginsUpdated=!1),this.previousHeight=a},xToIndex:function(e){var i=this.data,a=this.chart,s=a.rotate,h=this.stepWidth;this.parseDates&&!this.equalSpacing?(e=this.startTime+Math.round(e/h)-this.minDuration()/2,a=a.getClosestIndex(i,"time",e,!1,this.start,this.end+1)):(this.startOnAxis||(e-=h/2),a=this.start+Math.round(e/h));var r,a=t.fitToBounds(a,0,i.length-1);return i[a]&&(r=i[a].x[this.id]),s?r>this.height+1&&a--:r>this.width+1&&a--,0>r&&a++,a=t.fitToBounds(a,0,i.length-1)},dateToCoordinate:function(t){return this.parseDates&&!this.equalSpacing?(t.getTime()-this.startTime)*this.stepWidth:this.parseDates&&this.equalSpacing?(t=this.chart.getClosestIndex(this.data,"time",t.getTime(),!1,0,this.data.length-1),this.getCoordinate(t-this.start)):NaN},categoryToCoordinate:function(t){return this.chart?(t=this.chart.getCategoryIndexByValue(t),this.getCoordinate(t-this.start)):NaN},coordinateToDate:function(t){return this.equalSpacing?(t=this.xToIndex(t),new Date(this.data[t].time)):new Date(this.startTime+t/this.stepWidth)},getCoordinate:function(t){return t*=this.stepWidth,this.startOnAxis||(t+=this.stepWidth/2),Math.round(t)}})}();