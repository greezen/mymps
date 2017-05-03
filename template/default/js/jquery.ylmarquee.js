(function($) { 
 $.fn.jMarquee = function(o) {
    o = $.extend({
    speed:30,
    step:1,//滚动步长
    direction:"up",//滚动方向
    visible:3//可见元素数量
    }, o || {});
    //获取滚动内容内各元素相关信息
    var i=0;
    var div=$(this);
    var ul=$("ul",div);
    var tli=$("li",ul);
    var liSize=tli.size();
    if(o.direction=="left")
        tli.css("float","left");
    var liWidth=tli.innerWidth();
    var liHeight=tli.height();
    var ulHeight=liHeight*liSize;
    var ulWidth=liWidth*liSize;
  
    //如果对象元素个数大于指定的显示元素则进行滚动，否则不滚动。
    if(liSize>o.visible){
        ul.append(tli.slice(0,o.visible).clone())  //复制前o.visible个li，并添加到ul的最后
        li=$("li",ul);
        liSize=li.size();
        
          //给滚动内容添加相关CSS样式
        div.css({"position":"relative",overflow:"hidden"});
        ul.css({"position":"relative",margin:"0",padding:"0","list-style":"none"});
        li.css({margin:"0",padding:"0","position":"relative"});
        
        switch(o.direction){
            case "left":
                div.css("width",(liWidth*o.visible)+"px");
                ul.css("width",(liWidth*liSize)+"px");
                li.css("float","left");
                break;
            case "up":
                div.css({"height":(liHeight*o.visible)+"px"});
                ul.css("height",(liHeight*liSize)+"px");
                break;
        }
        
       
        var MyMar=setInterval(ylMarquee,o.speed);
        ul.hover(
            function(){clearInterval(MyMar);},
            function(){MyMar=setInterval(ylMarquee,o.speed);}
        );
    };
    function ylMarquee(){
         
        if(o.direction=="left"){
            if(div.scrollLeft()>=ulWidth){
                div.scrollLeft(0);
            }
            else
            {
                var leftNum=div.scrollLeft();
                leftNum+=parseInt(o.step);
                div.scrollLeft(leftNum)
            }
        }
        
        if(o.direction=="up"){
            if(div.scrollTop()>=ulHeight){
               div.scrollTop(0);
                
            }
            else{
               var topNum=div.scrollTop();
               topNum+=parseInt(o.step);
               div.scrollTop(topNum);
            }
        }
        
    };
   
}; 
     
})(jQuery);