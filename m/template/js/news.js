$.fn.imagesLoaded=function(callback){var $this=$(this),$images=$this.find('img').add($this.filter('img')),len=$images.length,blank='data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';function triggerCallback(){callback.call($this,$images)}function imgLoaded(event){if(--len<=0&&event.target.src!==blank){setTimeout(triggerCallback);$images.unbind('load error',imgLoaded)}}if(!len){triggerCallback()}$images.bind('load error',imgLoaded).each(function(){if(this.complete||typeof this.complete==="undefined"){var src=this.src;this.src=blank;this.src=src}});return $this};
if(typeof document!=="undefined"&&!("classList" in document.createElement("a"))){(function(j){var a="classList",f="prototype",m=(j.HTMLElement||j.Element)[f],b=Object,k=String[f].trim||function(){return this.replace(/^\s+|\s+$/g,"")},c=Array[f].indexOf||function(q){var p=0,o=this.length;for(;p<o;p++){if(p in this&&this[p]===q){return p}}return -1},n=function(o,p){this.name=o;this.code=DOMException[o];this.message=p},g=function(p,o){if(o===""){throw new n("SYNTAX_ERR","An invalid or illegal string was specified")}if(/\s/.test(o)){throw new n("INVALID_CHARACTER_ERR","String contains an invalid character")}return c.call(p,o)},d=function(s){var r=k.call(s.className),q=r?r.split(/\s+/):[],p=0,o=q.length;for(;p<o;p++){this.push(q[p])}this._updateClassName=function(){s.className=this.toString()}},e=d[f]=[],i=function(){return new d(this)};n[f]=Error[f];e.item=function(o){return this[o]||null};e.contains=function(o){o+="";return g(this,o)!==-1};e.add=function(o){o+="";if(g(this,o)===-1){this.push(o);this._updateClassName()}};e.remove=function(p){p+="";var o=g(this,p);if(o!==-1){this.splice(o,1);this._updateClassName()}};e.toggle=function(o){o+="";if(g(this,o)===-1){this.add(o)}else{this.remove(o)}};e.toString=function(){return this.join(" ")};if(b.defineProperty){var l={get:i,enumerable:true,configurable:true};try{b.defineProperty(m,a,l)}catch(h){if(h.number===-2146823252){l.enumerable=false;b.defineProperty(m,a,l)}}}else{if(b[f].__defineGetter__){m.__defineGetter__(a,i)}}}(self))};

(function(global){var time=Date.now||function(){return+new Date()};var desiredFrames=60;var millisecondsPerSecond=1000;var running={};var counter=1;if(!global.core){global.core={effect:{}}}else if(!core.effect){core.effect={}}core.effect.Animate={requestAnimationFrame:(function(){var requestFrame=global.requestAnimationFrame||global.webkitRequestAnimationFrame||global.mozRequestAnimationFrame||global.oRequestAnimationFrame;var isNative=!!requestFrame;if(requestFrame&&!/requestAnimationFrame\(\)\s*\{\s*\[native code\]\s*\}/i.test(requestFrame.toString())){isNative=false}if(isNative){return function(callback,root){requestFrame(callback,root)}}var TARGET_FPS=60;var requests={};var requestCount=0;var rafHandle=1;var intervalHandle=null;var lastActive=+new Date();return function(callback,root){var callbackHandle=rafHandle++;requests[callbackHandle]=callback;requestCount++;if(intervalHandle===null){intervalHandle=setInterval(function(){var time=+new Date();var currentRequests=requests;requests={};requestCount=0;for(var key in currentRequests){if(currentRequests.hasOwnProperty(key)){currentRequests[key](time);lastActive=time}}if(time-lastActive>2500){clearInterval(intervalHandle);intervalHandle=null}},1000/TARGET_FPS)}return callbackHandle}})(),stop:function(id){var cleared=running[id]!=null;if(cleared){running[id]=null}return cleared},isRunning:function(id){return running[id]!=null},start:function(stepCallback,verifyCallback,completedCallback,duration,easingMethod,root){var start=time();var lastFrame=start;var percent=0;var dropCounter=0;var id=counter++;if(!root){root=document.body}if(id%20===0){var newRunning={};for(var usedId in running){newRunning[usedId]=true}running=newRunning}var step=function(virtual){var render=virtual!==true;var now=time();if(!running[id]||(verifyCallback&&!verifyCallback(id))){running[id]=null;completedCallback&&completedCallback(desiredFrames-(dropCounter/((now-start)/millisecondsPerSecond)),id,false);return}if(render){var droppedFrames=Math.round((now-lastFrame)/(millisecondsPerSecond/desiredFrames))-1;for(var j=0;j<Math.min(droppedFrames,4);j++){step(true);dropCounter++}}if(duration){percent=(now-start)/duration;if(percent>1){percent=1}}var value=easingMethod?easingMethod(percent):percent;if((stepCallback(value,now,render)===false||percent===1)&&render){running[id]=null;completedCallback&&completedCallback(desiredFrames-(dropCounter/((now-start)/millisecondsPerSecond)),id,percent===1||duration==null)}else if(render){lastFrame=now;core.effect.Animate.requestAnimationFrame(step,root)}};running[id]=true;core.effect.Animate.requestAnimationFrame(step,root);return id}}})(this);

var Scroller;(function(){Scroller=function(callback,options){this.__callback=callback;this.options={__content:document.getElementById('content'),scrollingX:true,scrollingY:true,animating:true,animationDuration:250,bouncing:true,locking:true,paging:false,snapping:false,zooming:false,minZoom:0.5,maxZoom:3};for(var key in options){this.options[key]=options[key]}};var easeOutCubic=function(pos){return(Math.pow((pos-1),3)+1)};var easeInOutCubic=function(pos){if((pos/=0.5)<1){return 0.5*Math.pow(pos,3)}return 0.5*(Math.pow((pos-2),3)+2)};var members={__isSingleTouch:false,__isTracking:false,__isGesturing:false,__isDragging:false,__isDecelerating:false,__isAnimating:false,__clientLeft:0,__clientTop:0,__clientWidth:0,__clientHeight:0,__contentWidth:0,__contentHeight:0,__snapWidth:100,__snapHeight:100,__refreshHeight:null,__refreshActive:false,__refreshActivate:null,__refreshDeactivate:null,__refreshStart:null,__zoomLevel:1,__scrollLeft:0,__scrollTop:0,__maxScrollLeft:0,__maxScrollTop:0,__scheduledLeft:0,__scheduledTop:0,__scheduledZoom:0,__lastTouchLeft:null,__lastTouchTop:null,__lastTouchMove:null,__positions:null,__minDecelerationScrollLeft:null,__minDecelerationScrollTop:null,__maxDecelerationScrollLeft:null,__maxDecelerationScrollTop:null,__decelerationVelocityX:null,__decelerationVelocityY:null,setDimensions:function(clientWidth,clientHeight,contentWidth,contentHeight){var self=this;if(clientWidth){self.__clientWidth=clientWidth}if(clientHeight){self.__clientHeight=clientHeight}if(contentWidth){self.__contentWidth=contentWidth}if(contentHeight){self.__contentHeight=contentHeight}self.__computeScrollMax();self.scrollTo(self.__scrollLeft,self.__scrollTop,true)},setPosition:function(left,top){var self=this;self.__clientLeft=left||0;self.__clientTop=top||0},setSnapSize:function(width,height){var self=this;self.__snapWidth=width;self.__snapHeight=height},activatePullToRefresh:function(height,activateCallback,deactivateCallback,startCallback){var self=this;self.__refreshHeight=height;self.__refreshActivate=activateCallback;self.__refreshDeactivate=deactivateCallback;self.__refreshStart=startCallback},finishPullToRefresh:function(){var self=this;self.__refreshActive=false;if(self.__refreshDeactivate){self.__refreshDeactivate()}self.scrollTo(self.__scrollLeft,self.__scrollTop,true)},getValues:function(){var self=this;return{left:self.__scrollLeft,top:self.__scrollTop,zoom:self.__zoomLevel}},getScrollMax:function(){var self=this;return{left:self.__maxScrollLeft,top:self.__maxScrollTop}},zoomTo:function(level,animate,originLeft,originTop){var self=this;if(!self.options.zooming){throw new Error("Zooming is not enabled!")}if(self.__isDecelerating){core.effect.Animate.stop(self.__isDecelerating);self.__isDecelerating=false}var oldLevel=self.__zoomLevel;if(originLeft==null){originLeft=self.__clientWidth/2}if(originTop==null){originTop=self.__clientHeight/2}level=Math.max(Math.min(level,self.options.maxZoom),self.options.minZoom);self.__computeScrollMax(level);var left=((originLeft+self.__scrollLeft)*level/oldLevel)-originLeft;var top=((originTop+self.__scrollTop)*level/oldLevel)-originTop;if(left>self.__maxScrollLeft){left=self.__maxScrollLeft}else if(left<0){left=0}if(top>self.__maxScrollTop){top=self.__maxScrollTop}else if(top<0){top=0}self.__publish(left,top,level,animate)},zoomBy:function(factor,animate,originLeft,originTop){var self=this;self.zoomTo(self.__zoomLevel*factor,animate,originLeft,originTop)},scrollTo:function(left,top,animate,zoom){var self=this;if(self.__isDecelerating){core.effect.Animate.stop(self.__isDecelerating);self.__isDecelerating=false}if(zoom!=null&&zoom!==self.__zoomLevel){if(!self.options.zooming){throw new Error("Zooming is not enabled!")}left*=zoom;top*=zoom;self.__computeScrollMax(zoom)}else{zoom=self.__zoomLevel}if(!self.options.scrollingX){left=self.__scrollLeft}else{if(self.options.paging){left=Math.round(left/self.__clientWidth)*self.__clientWidth}else if(self.options.snapping){left=Math.round(left/self.__snapWidth)*self.__snapWidth}}if(!self.options.scrollingY){top=self.__scrollTop}else{if(self.options.paging){top=Math.round(top/self.__clientHeight)*self.__clientHeight}else if(self.options.snapping){top=Math.round(top/self.__snapHeight)*self.__snapHeight}}left=Math.max(Math.min(self.__maxScrollLeft,left),0);top=Math.max(Math.min(self.__maxScrollTop,top),0);if(left===self.__scrollLeft&&top===self.__scrollTop){animate=false}self.__publish(left,top,zoom,animate)},scrollBy:function(left,top,animate){var self=this;var startLeft=self.__isAnimating?self.__scheduledLeft:self.__scrollLeft;var startTop=self.__isAnimating?self.__scheduledTop:self.__scrollTop;self.scrollTo(startLeft+(left||0),startTop+(top||0),animate)},doMouseZoom:function(wheelDelta,timeStamp,pageX,pageY){var self=this;var change=wheelDelta>0?0.97:1.03;return self.zoomTo(self.__zoomLevel*change,false,pageX-self.__clientLeft,pageY-self.__clientTop)},doTouchStart:function(touches,timeStamp){if(touches.length==null){throw new Error("Invalid touch list: "+touches)}if(timeStamp instanceof Date){timeStamp=timeStamp.valueOf()}if(typeof timeStamp!=="number"){throw new Error("Invalid timestamp value: "+timeStamp)}var self=this;if(self.__isDecelerating){core.effect.Animate.stop(self.__isDecelerating);self.__isDecelerating=false}if(self.__isAnimating){core.effect.Animate.stop(self.__isAnimating);self.__isAnimating=false}var currentTouchLeft,currentTouchTop;var isSingleTouch=touches.length===1;if(isSingleTouch){currentTouchLeft=touches[0].pageX;currentTouchTop=touches[0].pageY}else{currentTouchLeft=Math.abs(touches[0].pageX+touches[1].pageX)/2;currentTouchTop=Math.abs(touches[0].pageY+touches[1].pageY)/2}self.__initialTouchLeft=currentTouchLeft;self.__initialTouchTop=currentTouchTop;self.__zoomLevelStart=self.__zoomLevel;self.__lastTouchLeft=currentTouchLeft;self.__lastTouchTop=currentTouchTop;self.__lastTouchMove=timeStamp;self.__lastScale=1;self.__enableScrollX=!isSingleTouch&&self.options.scrollingX;self.__enableScrollY=!isSingleTouch&&self.options.scrollingY;self.__isTracking=true;self.__isDragging=!isSingleTouch;self.__isSingleTouch=isSingleTouch;self.__positions=[]},doTouchMove:function(touches,timeStamp,scale){if(touches.length==null){throw new Error("Invalid touch list: "+touches)}if(timeStamp instanceof Date){timeStamp=timeStamp.valueOf()}if(typeof timeStamp!=="number"){throw new Error("Invalid timestamp value: "+timeStamp)}var self=this;if(!self.__isTracking){return}var currentTouchLeft,currentTouchTop;if(touches.length===2){currentTouchLeft=Math.abs(touches[0].pageX+touches[1].pageX)/2;currentTouchTop=Math.abs(touches[0].pageY+touches[1].pageY)/2}else{currentTouchLeft=touches[0].pageX;currentTouchTop=touches[0].pageY}var positions=self.__positions;if(self.__isDragging){var moveX=currentTouchLeft-self.__lastTouchLeft;var moveY=currentTouchTop-self.__lastTouchTop;var scrollLeft=self.__scrollLeft;var scrollTop=self.__scrollTop;var level=self.__zoomLevel;if(scale!=null&&self.options.zooming){var oldLevel=level;level=level/self.__lastScale*scale;level=Math.max(Math.min(level,self.options.maxZoom),self.options.minZoom);if(oldLevel!==level){var currentTouchLeftRel=currentTouchLeft-self.__clientLeft;var currentTouchTopRel=currentTouchTop-self.__clientTop;scrollLeft=((currentTouchLeftRel+scrollLeft)*level/oldLevel)-currentTouchLeftRel;scrollTop=((currentTouchTopRel+scrollTop)*level/oldLevel)-currentTouchTopRel;self.__computeScrollMax(level)}}if(self.__enableScrollX){scrollLeft-=moveX;var maxScrollLeft=self.__maxScrollLeft;if(scrollLeft>maxScrollLeft||scrollLeft<0){if(self.options.bouncing){scrollLeft+=(moveX/2)}else if(scrollLeft>maxScrollLeft){scrollLeft=maxScrollLeft}else{scrollLeft=0}}}if(self.__enableScrollY){scrollTop-=moveY;var maxScrollTop=self.__maxScrollTop;if(scrollTop>maxScrollTop||scrollTop<0){if(self.options.bouncing){scrollTop+=(moveY/2);if(!self.__enableScrollX&&self.__refreshHeight!=null){if(!self.__refreshActive&&scrollTop<=-self.__refreshHeight){self.__refreshActive=true;if(self.__refreshActivate){self.__refreshActivate()}}else if(self.__refreshActive&&scrollTop>-self.__refreshHeight){self.__refreshActive=false;if(self.__refreshDeactivate){self.__refreshDeactivate()}}}}else if(scrollTop>maxScrollTop){scrollTop=maxScrollTop}else{scrollTop=0}}}if(positions.length>60){positions.splice(0,30)}positions.push(scrollLeft,scrollTop,timeStamp);self.__publish(scrollLeft,scrollTop,level)}else{var minimumTrackingForScroll=self.options.locking?20:0;var minimumTrackingForDrag=5;var distanceX=Math.abs(currentTouchLeft-self.__initialTouchLeft);var distanceY=Math.abs(currentTouchTop-self.__initialTouchTop);self.__enableScrollX=self.options.scrollingX&&distanceX>=minimumTrackingForScroll;self.__enableScrollY=self.options.scrollingY&&distanceY>=minimumTrackingForScroll;positions.push(self.__scrollLeft,self.__scrollTop,timeStamp);self.__isDragging=(self.__enableScrollX||self.__enableScrollY)&&(distanceX>=minimumTrackingForDrag||distanceY>=minimumTrackingForDrag)}self.__lastTouchLeft=currentTouchLeft;self.__lastTouchTop=currentTouchTop;self.__lastTouchMove=timeStamp;self.__lastScale=scale},doTouchEnd:function(timeStamp){if(timeStamp instanceof Date){timeStamp=timeStamp.valueOf()}if(typeof timeStamp!=="number"){throw new Error("Invalid timestamp value: "+timeStamp)}var self=this;if(!self.__isTracking){return}self.__isTracking=false;if(self.__isDragging){self.__isDragging=false;if(self.__isSingleTouch&&self.options.animating&&(timeStamp-self.__lastTouchMove)<=100){var positions=self.__positions;var endPos=positions.length-1;var startPos=endPos;for(var i=endPos;i>0&&positions[i]>(self.__lastTouchMove-100);i-=3){startPos=i}if(startPos!==endPos){var timeOffset=positions[endPos]-positions[startPos];var movedLeft=self.__scrollLeft-positions[startPos-2];var movedTop=self.__scrollTop-positions[startPos-1];self.__decelerationVelocityX=movedLeft/timeOffset*(1000/60);self.__decelerationVelocityY=movedTop/timeOffset*(1000/60);var minVelocityToStartDeceleration=self.options.paging||self.options.snapping?4:1;if(Math.abs(self.__decelerationVelocityX)>minVelocityToStartDeceleration||Math.abs(self.__decelerationVelocityY)>minVelocityToStartDeceleration){if(!self.__refreshActive){self.__startDeceleration(timeStamp)}}}}}if(!self.__isDecelerating){if(self.__refreshActive&&self.__refreshStart){self.__publish(self.__scrollLeft,-self.__refreshHeight,self.__zoomLevel,true);if(self.__refreshStart){self.__refreshStart()}}else{self.scrollTo(self.__scrollLeft,self.__scrollTop,true,self.__zoomLevel);if(self.__refreshActive){self.__refreshActive=false;if(self.__refreshDeactivate){self.__refreshDeactivate()}}}}self.__positions.length=0},__publish:function(left,top,zoom,animate){var self=this;var wasAnimating=self.__isAnimating;if(wasAnimating){core.effect.Animate.stop(wasAnimating);self.__isAnimating=false}if(animate&&self.options.animating){self.__scheduledLeft=left;self.__scheduledTop=top;self.__scheduledZoom=zoom;var oldLeft=self.__scrollLeft;var oldTop=self.__scrollTop;var oldZoom=self.__zoomLevel;var diffLeft=left-oldLeft;var diffTop=top-oldTop;var diffZoom=zoom-oldZoom;var step=function(percent,now,render){if(render){self.__scrollLeft=oldLeft+(diffLeft*percent);self.__scrollTop=oldTop+(diffTop*percent);self.__zoomLevel=oldZoom+(diffZoom*percent);if(self.__callback){self.__callback(self.__scrollLeft,self.__scrollTop,self.__zoomLevel,self.options.__content)}}};var verify=function(id){return self.__isAnimating===id};var completed=function(renderedFramesPerSecond,animationId,wasFinished){if(animationId===self.__isAnimating){self.__isAnimating=false}if(self.options.zooming){self.__computeScrollMax()}};self.__isAnimating=core.effect.Animate.start(step,verify,completed,self.options.animationDuration,wasAnimating?easeOutCubic:easeInOutCubic)}else{self.__scheduledLeft=self.__scrollLeft=left;self.__scheduledTop=self.__scrollTop=top;self.__scheduledZoom=self.__zoomLevel=zoom;if(self.__callback){self.__callback(left,top,zoom,self.options.__content)}if(self.options.zooming){self.__computeScrollMax()}}},__computeScrollMax:function(zoomLevel){var self=this;if(zoomLevel==null){zoomLevel=self.__zoomLevel}self.__maxScrollLeft=Math.max((self.__contentWidth*zoomLevel)-self.__clientWidth,0);self.__maxScrollTop=Math.max((self.__contentHeight*zoomLevel)-self.__clientHeight,0)},__startDeceleration:function(timeStamp){var self=this;if(self.options.paging){var scrollLeft=Math.max(Math.min(self.__scrollLeft,self.__maxScrollLeft),0);var scrollTop=Math.max(Math.min(self.__scrollTop,self.__maxScrollTop),0);var clientWidth=self.__clientWidth;var clientHeight=self.__clientHeight;self.__minDecelerationScrollLeft=Math.floor(scrollLeft/clientWidth)*clientWidth;self.__minDecelerationScrollTop=Math.floor(scrollTop/clientHeight)*clientHeight;self.__maxDecelerationScrollLeft=Math.ceil(scrollLeft/clientWidth)*clientWidth;self.__maxDecelerationScrollTop=Math.ceil(scrollTop/clientHeight)*clientHeight}else{self.__minDecelerationScrollLeft=0;self.__minDecelerationScrollTop=0;self.__maxDecelerationScrollLeft=self.__maxScrollLeft;self.__maxDecelerationScrollTop=self.__maxScrollTop}var step=function(percent,now,render){self.__stepThroughDeceleration(render)};var minVelocityToKeepDecelerating=self.options.snapping?4:0.1;var verify=function(){return Math.abs(self.__decelerationVelocityX)>=minVelocityToKeepDecelerating||Math.abs(self.__decelerationVelocityY)>=minVelocityToKeepDecelerating};var completed=function(renderedFramesPerSecond,animationId,wasFinished){self.__isDecelerating=false;self.scrollTo(self.__scrollLeft,self.__scrollTop,self.options.snapping)};self.__isDecelerating=core.effect.Animate.start(step,verify,completed)},__stepThroughDeceleration:function(render){var self=this;var scrollLeft=self.__scrollLeft+self.__decelerationVelocityX;var scrollTop=self.__scrollTop+self.__decelerationVelocityY;if(!self.options.bouncing){var scrollLeftFixed=Math.max(Math.min(self.__maxDecelerationScrollLeft,scrollLeft),self.__minDecelerationScrollLeft);if(scrollLeftFixed!==scrollLeft){scrollLeft=scrollLeftFixed;self.__decelerationVelocityX=0}var scrollTopFixed=Math.max(Math.min(self.__maxDecelerationScrollTop,scrollTop),self.__minDecelerationScrollTop);if(scrollTopFixed!==scrollTop){scrollTop=scrollTopFixed;self.__decelerationVelocityY=0}}if(render){self.__publish(scrollLeft,scrollTop,self.__zoomLevel)}else{self.__scrollLeft=scrollLeft;self.__scrollTop=scrollTop}if(!self.options.paging){var frictionFactor=0.95;self.__decelerationVelocityX*=frictionFactor;self.__decelerationVelocityY*=frictionFactor}if(self.options.bouncing){var scrollOutsideX=0;var scrollOutsideY=0;var penetrationDeceleration=0.03;var penetrationAcceleration=0.08;if(scrollLeft<self.__minDecelerationScrollLeft){scrollOutsideX=self.__minDecelerationScrollLeft-scrollLeft}else if(scrollLeft>self.__maxDecelerationScrollLeft){scrollOutsideX=self.__maxDecelerationScrollLeft-scrollLeft}if(scrollTop<self.__minDecelerationScrollTop){scrollOutsideY=self.__minDecelerationScrollTop-scrollTop}else if(scrollTop>self.__maxDecelerationScrollTop){scrollOutsideY=self.__maxDecelerationScrollTop-scrollTop}if(scrollOutsideX!==0){if(scrollOutsideX*self.__decelerationVelocityX<=0){self.__decelerationVelocityX+=scrollOutsideX*penetrationDeceleration}else{self.__decelerationVelocityX=scrollOutsideX*penetrationAcceleration}}if(scrollOutsideY!==0){if(scrollOutsideY*self.__decelerationVelocityY<=0){self.__decelerationVelocityY+=scrollOutsideY*penetrationDeceleration}else{self.__decelerationVelocityY=scrollOutsideY*penetrationAcceleration}}}}};for(var key in members){Scroller.prototype[key]=members[key]}})();

var render=(function(global){var docStyle=document.documentElement.style;var engine;if(global.opera&&Object.prototype.toString.call(opera)==='[object Opera]'){engine='presto'}else if('MozAppearance'in docStyle){engine='gecko'}else if('WebkitAppearance'in docStyle){engine='webkit'}else if(typeof navigator.cpuClass==='string'){engine='trident'}var vendorPrefix={trident:'ms',gecko:'Moz',webkit:'Webkit',presto:'O'}[engine];var helperElem=document.createElement("div");var undef;var perspectiveProperty=vendorPrefix+"Perspective";var transformProperty=vendorPrefix+"Transform";if(helperElem.style[perspectiveProperty]!==undef){return function(left,top,zoom,icontent){icontent.style[transformProperty]='translate3d('+(-left)+'px,'+(-top)+'px,0) scale('+zoom+')'}}else if(helperElem.style[transformProperty]!==undef){return function(left,top,zoom,icontent){icontent.style[transformProperty]='translate('+(-left)+'px,'+(-top)+'px) scale('+zoom+')'}}else{return function(left,top,zoom,icontent){icontent.style.marginLeft=left?(-left/zoom)+'px':'';icontent.style.marginTop=top?(-top/zoom)+'px':'';icontent.style.zoom=zoom||''}}})(this);


function C_Scroll(options){
	this.options = {
		container:'container',
		content:'content',
		ct:'indicator',
		next:'slide_next',
		prev:'slide_prev',
		size:'320',
		intervalTime:null,
		lazyIMG:false,
		rewriteHeight:false
	}
	for (var key in options){
		this.options[key] = options[key];
	}
	this.container = document.getElementById(this.options.container);
	this.content = document.getElementById(this.options.content);
	this.ct = document.getElementById(this.options.ct);
	this.next = document.getElementById(this.options.next);
	this.prev = document.getElementById(this.options.prev);
	this.size = this.options.size;
	this.intervalTime = this.options.intervalTime;
	this.lazyIMG = this.options.lazyIMG;
	this.rewriteHeight = this.options.rewriteHeight;
	
	this.ctList = this.ct.querySelectorAll('li');
	this.cell = this.content.querySelectorAll('.cell')
	this.len = this.ctList.length;
	
	if(typeof this.init !== 'undefined'){
		this.init.apply(this,arguments);
	}
}
C_Scroll.prototype = {
	scroller:{},
	timer:{},
	SL:0,
	showIndex:0,
	__lastTouchLeft:0,
	__lastTouchTop:0,
	__timer:null,
	imgLazyLoad:function(index,bool){
		var index2=index;
		if(!bool && (index + 1 < this.len)){
			index2 = index+1;
		}
		
		
		var that = this;
		var imgs = this.cell[index2].querySelectorAll('img');
		var attr = '';
		var e;
		for(var i=0,len=imgs.length;i<len;i++){
			e = imgs[i];
			attr = e.getAttribute('lazysrc');
			e.setAttribute('src',attr);
			
			if (e.complete || e.readyState && (e.readyState == "loaded" || e.readyState == "complete")) that.rewriteHeight && that.resetHeight(index);
			e.onload = function() {
				that.rewriteHeight && that.resetHeight(index);
			},
			e.onerror = function() {}
		}
	},
	resetHeight:function(index){
		var that = this;
		var imgs = this.cell[index].querySelectorAll('img');
		that.content.style.height = (imgs[0].height+26)+'px';
	},
	setIndicator:function(index){
		var that = this;
		for(var j=0;j<that.len;j++){
			that.ctList[j].classList.remove('active');
		}
		that.ctList[index].classList.add('active');
		that.lazyIMG&&that.imgLazyLoad(index);
		that.rewriteHeight&&(function(){that.content.style.height = (that.cell[index].querySelectorAll('img')[0].height+26)+'px';})();
	},
	setIndicatorS:function(){
		var that = this;
		that.timer = window.setInterval(function(){
			that.SL = that.scroller.getValues().left;
			(that.SL%that.size) ===0&&(function(){
				that.showIndex = Math.floor(that.SL/that.size);
				that.setIndicator(that.showIndex);
				that.timer&&clearInterval(that.timer);
			})();
		},50);
	},
	scrollTo:function(index){
		var that = this;
		that.scroller.scrollTo(index*that.size,0,true);
		that.lazyIMG&&that.imgLazyLoad(index,!0);
		that.setIndicator(index);
	},
	autoPlay:function(){
		var that = this;
		that.__timer = window.setInterval(function(){
			that.showIndex = that.showIndex<that.len-1? that.showIndex+1:0;
			that.scrollTo(that.showIndex);
		}, that.intervalTime);
	},
	init:function(){
		var that = this;
		$(window).resize(function(){
			if(that.size !== '320'){init_scroller();}
		});
		
		this.content.style.width = that.size*that.len + 'px';
		for(var i=0;i<that.len;i++){
			that.cell[i].style.width = that.size + 'px';
		}
		that.scroller = new Scroller(render, {
			__content:that.content,
			scrollingY: false,
			bouncing:true,
			paging: true
		});
		function init_scroller(){
			if(that.size !== '320'){
				that.size = document.body.clientWidth;
				that.container.style.width = that.size+'px';
			}else{
				that.container.style.width = '320px';
			}
			var rect = that.container.getBoundingClientRect();
			that.scroller.setPosition(rect.left+that.container.clientLeft, rect.top+that.container.clientTop);
			that.scroller.setDimensions(that.size, that.container.clientHeight, that.size*that.len, that.content.offsetHeight);
			that.content.style.width = that.size*that.len + 'px';
			for(var i=0;i<that.len;i++){
				that.cell[i].style.width = that.size + 'px';
			}
		}
		init_scroller();
		
		for(var i=0;i<that.len;i++){
			(function(num){
				that.ctList[num].addEventListener('click',function(event){
					that.scrollTo(num);
					event.preventDefault();
				},false);
			})(i);
		}
		that.lazyIMG && that.imgLazyLoad(0);
		
		that.next.addEventListener('click',function(event){
			that.__timer&&clearInterval(that.__timer);
			that.showIndex = that.showIndex<that.len-1? that.showIndex+1:0;
			that.scrollTo(that.showIndex);
			that.intervalTime&&that.autoPlay();
			event.preventDefault();
		},false);
		that.prev.addEventListener('click',function(event){
			that.__timer&&clearInterval(that.__timer);
			that.showIndex = that.showIndex>0? that.showIndex-1:that.len-1;
			that.scrollTo(that.showIndex);
			that.intervalTime&&that.autoPlay();
			event.preventDefault();
		},false);
		
		// Event Handler
		if ('ontouchstart' in window) {
			that.container.addEventListener("touchstart", function(e) {
				that.__timer&&clearInterval(that.__timer);
				that.isMoving = !1;
				if (e.touches.length === 2) {
					that.__lastTouchLeft = Math.abs(e.touches[0].pageX + e.touches[1].pageX) / 2;
					that.__lastTouchTop = Math.abs(e.touches[0].pageY + e.touches[1].pageY) / 2;
				} else {
					that.__lastTouchLeft = e.touches[0].pageX;
					that.__lastTouchTop = e.touches[0].pageY;
				}
				that.scroller.doTouchStart(e.touches, e.timeStamp);
			}, false);
			that.container.addEventListener("touchmove", function(e) {
				var currentTouchLeft, currentTouchTop,if_Y = false;
				if (e.touches.length === 2){
					currentTouchLeft = Math.abs(e.touches[0].pageX + e.touches[1].pageX) / 2;
					currentTouchTop = Math.abs(e.touches[0].pageY + e.touches[1].pageY) / 2;
				} else {
					currentTouchLeft = e.touches[0].pageX;
					currentTouchTop = e.touches[0].pageY;
				}
				var moveX = currentTouchLeft - that.__lastTouchLeft;
				var moveY = currentTouchTop - that.__lastTouchTop;
				
				if(!that.isMoving){
					that.doScrollX = Math.abs(moveY) < Math.abs(moveX),
					that.isMoving = !0,
					that.doScrollX && e.preventDefault();
				}
				else if(that.doScrollX){
					that.scroller.doTouchMove(e.touches, e.timeStamp);
					e.preventDefault();
				}
			}, false);
			that.container.addEventListener("touchend", function(e) {
				that.scroller.doTouchEnd(e.timeStamp);
				that.setIndicatorS();
				that.intervalTime&&that.autoPlay();
			}, false);
		} else {
			var mousedown = false;
			that.container.addEventListener("mousedown", function(e) {
				// Don't react if initial down happens on a form element
				that.__timer&&clearInterval(that.__timer);
				that.isMoving = !1;
				
				that.__lastTouchLeft = e.pageX;
				that.__lastTouchTop = e.pageY;
				that.scroller.doTouchStart([{
					pageX: e.pageX,
					pageY: e.pageY
				}], e.timeStamp);
				
				mousedown = true;
			}, false);
			that.container.addEventListener("mousemove", function(e) {
				if (!mousedown) {
					return;
				}
				var currentTouchLeft, currentTouchTop;
				
				currentTouchLeft = e.pageX;
				currentTouchTop = e.pageY;
				var moveX = currentTouchLeft - that.__lastTouchLeft;
				var moveY = currentTouchTop - that.__lastTouchTop;
				if(!that.isMoving){
					that.doScrollX = Math.abs(moveY) < Math.abs(moveX);
					that.isMoving = !0;
					that.doScrollX && e.preventDefault();
				}
				else if(that.doScrollX){
					that.scroller.doTouchMove([{
						pageX: e.pageX,
						pageY: e.pageY
					}], e.timeStamp);
					e.preventDefault();
				}
				mousedown = true;
			}, false);
			that.container.addEventListener("mouseup", function(e){
				if (!mousedown) {
					return;
				}
				that.scroller.doTouchEnd(e.timeStamp);
				that.setIndicatorS();
				mousedown = false;
				that.intervalTime&&that.autoPlay();
			}, false);
		}
		this.intervalTime&&that.autoPlay();
	}
}

var IDC = (function(){
	jQuery.extend(jQuery.easing,{easeOutCubic:function(t,e,i,n,o){return n*((e=e/o-1)*e*e+1)+i}});
	var resizeIMG = function(node,width,height){
		var imgList = $(node).find('img');
		var len = imgList.length,i=0;
		if(len>0){
			imgList.each(function(i,item){
				$(item).imagesLoaded(function(){
					AutoResizeImage(width,height,item);
				});
			});
		}
		function AutoResizeImage(maxWidth,maxHeight,objImg){
			var img = new Image();
			img.src = objImg.src;
			var hRatio;
			var wRatio;
			var Ratio = 1;
			var w = img.width;
			var h = img.height;
			wRatio = maxWidth / w;
			hRatio = maxHeight / h;
			if (maxWidth ==0 && maxHeight==0){
			Ratio = 1;
			}else if (maxWidth==0){//
			if (hRatio<1) Ratio = hRatio;
			}else if (maxHeight==0){
			if (wRatio<1) Ratio = wRatio;
			}else if (wRatio<1 || hRatio<1){
			Ratio = (wRatio<=hRatio?wRatio:hRatio);
			}
			if (Ratio<1){
			w = w * Ratio;
			h = h * Ratio;
			}
			objImg.height = h;
			objImg.width = w;
		}
	}
	
	return {
		resizeIMG:resizeIMG,
	}
})();
function MSGwindowShow(action,showid,str,url,formcode){
	if(action === "pay"){
		$('#have_login').hide();
		if(showid=="2"){
			document.getElementById('formcode').value=formcode;//赋值code
			document.forms['submitpay'].submit();//提交支付
			//这里添加支付中信息提示窗口
			//$('#pay_tips').show();
		}else if(showid=="1"){
			if(url.length > 5){window.location.href=url;}
		}else if(showid=="0"){
			alert(str);
			if(url.length > 5){window.location.href=url;}
		}else{
			alert(str);
		}
		document.getElementById('formcode').value="payok";//设置默认值防止二次提交
	}
}	