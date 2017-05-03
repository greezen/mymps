$(function(){
    if(window.BLightApp){//判断如果是百度app还用旧的filter
		loadJS("/template/js/filter.js",function(){
			if($(".filter").length){
				var myfilter = new filter(filter_data);
				myfilter.drawList();
			}
		});
	}else{
		window.keyword_other = '';

		//已选项位置处理
		//$(".filter_item .selected").each(function(){
		//	$(this).insertBefore($(this).siblings());
		//});	
			
			//遍历所有筛选项 dl
		$(".filter_item").each(function(){
			var len=$(this).find("dd a").length;
			//如果a标签的长度大于4，并且数据类型是cmc或者cmcs
			if(len>3 && $(this).attr("type")=="cmc_cmcs"){
				$(this).find("dd").append("<div class='ico_more'></div>");
				$(this).find("dd").css("padding-right","30px");
			}
			//如果a标签的长度大于4，并且数据类型是商圈数据
			if(len>4 && $(this).attr("type")=="subarea"){
				$(this).find("dd").append("<div class='ico_more'></div>");
				$(this).find("dd").css("padding-right","30px");
			}
			//如果a标签的长度大于或等于5，并且数据类型是区域，设置ico位置和dd高度
			if(len>=5 && $(this).attr("type")=="area"){
				$(this).find("dd").append("<div class='ico_more'></div>");
				$(".ico_more").css("top","24px");
				$(this).find("dd").css({"padding-right":"30px","height":"56px"});
			}
			
		});
		
		//显示或隐藏更多子筛选项
			//isclick 记录是否触摸到a标签，解决同时触发两个事件的bug
			var isclick = false;
			$(".ico_more,.ico_more2").bind("touchstart",function(){isside=false});
			$(".ico_more,.ico_more2").bind("touchmove",function(){isside=true});
			$(".ico_more,.ico_more2").bind("touchend",function(){
				if(isside){return;}
				$('.filter').css({"height":"auto","-webkit-transition-duration":"0ms"});
				isclick=true;
				if($(this).hasClass("up")){
					if($(this).parent().parent().attr("type")=="area"){
						$(this).parent().css("height","56px");
					}else{
						$(this).parent().css("height","28px");
					}
					$(this).removeClass("up");
				}else{
					$(this).parent().css("height","auto");
					$(this).addClass("up");
				}
				setTimeout(function(){
					isclick=false;
				},500);
			});

			$(".filter_item a").bind("click",function(){
				var _a=$(this);
				var urls = _a.attr("href");
				if(isclick){
					isclick=false;
					_a.attr("href","javascript:;");
					setTimeout(function(){
						_a.attr("href",urls);
					},500);
				}
			});
		//显示或隐藏更多筛选项
		$(".filter_more").bind("click",function(){
			var btn_more = $(this);

			$(".filter .filter_item").each(function(){

				if($(this).css('display') == "none" ){
					$(this).css('display','block').addClass('none');
					btn_more.addClass("less").find("span").text("精简筛选条件");
				}else if($(this).hasClass("none") && $(this).css('display') != "none"){
					$(this).css('display','none');
					btn_more.removeClass("less").find("span").text("更多筛选条件");
				}
				
				
			});
			
		});	
	}
	
});
