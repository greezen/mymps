var browser=navigator.appName;
var b_version=navigator.appVersion;
var trim_Version=b_version.replace(/[ ]/g,"");
var msie6 = browser == "Microsoft Internet Explorer" && trim_Version.indexOf('MSIE6.0')>0;

var map = new BMap.Map( map_id );
var local = null;

map.addControl(new BMap.NavigationControl());
map.enableScrollWheelZoom();

if(p1 != '' && p2 != '') {
	var point = new BMap.Point(p1, p2); 
	map.centerAndZoom(point, 15);
	var marker = new BMap.Marker(point);  // 创建标注
	map.addOverlay(marker);              // 将标注添加到地图中
	marker.enableDragging();
	marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
} else {
	map.centerAndZoom(new BMap.Point(), view_level);
	var myCity = new BMap.LocalCity();
	myCity.get(myFun);
}

function myFun(result){
    var cityName = result.name;
    map.setCenter(cityName);
}

function markmap() { 
	map.clearOverlays();
	map.addEventListener("click", showInfo);
} 

function showInfo(e){
	//alert("您标注的坐标为：" + e.point.lng + "," + e.point.lat + "\r\n\r\n请点击确定按钮完成标注操作！");    
	document.getElementById('point1').value = e.point.lng;
	document.getElementById('point2').value = e.point.lat;
	var point = new BMap.Point(e.point.lng, e.point.lat); 
	//map.centerAndZoom(point, 15);
	var marker = new BMap.Marker(point);
	marker.enableDragging();
    map.addOverlay(marker);
}

function create_search_ui () {
	//搜索服务
	local = new BMap.LocalSearch(map, {
	  renderOptions:{map: map}
	});
	local.setInfoHtmlSetCallback(open_info);
	local.setSearchCompleteCallback(search_result);
	local.disableFirstResultSelection();
	local.enableAutoViewport();
	//搜索框
	var _abc= document.createElement('div');
	var p = document.getElementById(map_id);
	_abc.style.fontSize = '12px';
	_abc.style.padding = '2px 5px';
	document.body.appendChild(_abc);
	_abc.innerHTML = '请输入地点：<input type="text" id="k"> <input type="button" value="搜索" onclick="local_search();">';
	if(msie6) {
		p.style.height = p.offsetHeight - 40;
		_abc.style.left = '60px';
		_abc.style.width = "280px";
		_abc.style.margin = "0 auto";
	} else {
		_abc.style.position = 'absolute';
		_abc.style.backgroundColor = '#FFF';
		_abc.style.border ='1px solid #ccc';
		var top = p.offsetHeight-_abc.offsetHeight-5;
		var left = Math.round(p.offsetWidth/2-_abc.offsetWidth/2);
		_abc.style.top = '3px';
		_abc.style.left = left + 'px';
		_abc.style.zIndex = 999;
	}
}

function local_search(name) {
	var k = document.getElementById('k');
	if(k.value=='') return;
	local.clearResults();
	local.search(k.value);
}

function search_result(results) {
	if(results.getNumPois()==0) {
		alert('没找到符合的地点坐标。');
	}
}

function open_info (poi,html) {
	var content = '<input type="button" value="设置这里为标注点" onclick="set_location(this,'+poi.marker.getPoint().lng+','+poi.marker.getPoint().lat+');">';
	html.innerHTML = content;
}

function set_location(obj,lng,lat) {
	document.getElementById('point1').value = lng;
	document.getElementById('point2').value = lat;
	alert('标注点已设置，请按“确定”按钮关闭对话框。');
	var p = obj.parentNode;
	p.removeChild(obj);
	var info = document.createElement('div');
	info.innerHTML = '<span style="color:#808080;">已设置为这个坐标点</span>';
	p.appendChild(info);
}