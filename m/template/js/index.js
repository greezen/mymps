var IDC = (function(){
	jQuery.extend(jQuery.easing,{easeOutCubic:function(t,e,i,n,o){return n*((e=e/o-1)*e*e+1)+i}});
	
	var tabADS = function(node){
		var obj = node;
		var currentClass = "current";
		var tabs = obj.find(".tab-hd").find(".item");
		var conts = obj.find(".tab-cont");
		var t;
		tabs.eq(0).addClass(currentClass);
		conts.eq(0).nextAll().hide();
		tabs.each(function(i){
			$(this).bind("click",function(){
				 t = setTimeout(function(){
					conts.hide().eq(i).show();
					tabs.removeClass(currentClass).eq(i).addClass(currentClass);
				},300);
			});
		});
	}
	return {
		tabADS:tabADS
	}
})();