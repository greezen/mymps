var map = null;
var myOptions = {
	zoom: view_level,
	mapTypeControl: true,
	mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
	navigationControl: true,
	mapTypeId: google.maps.MapTypeId.ROADMAP,
	center: new google.maps.LatLng('30.2448','120.1519')
}

function init_map() {
	map = new google.maps.Map(document.getElementById(map_id), myOptions);
	if(p1 != '' && p2 != '') {
		var c = new google.maps.LatLng(p2, p1);
		map.setCenter(c, view_level);
		if(show > 0) {
			var marker = new google.maps.Marker({
				position: c, 
				map: map,
				title:title
			});
		}
	}
}

function markmap() {
    var Center = map.getCenter();
    var lat = new String(Center.lat());
    var lng = new String(Center.lng());
    setLatLng(lat, lng);
	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat,lng),
		map: map,
		draggable: true
	});
	google.maps.event.addListener(marker, 'dragstart', function() {
		try {
			map.closeInfoWindow();
		}
		catch (err){
		}
	});
	google.maps.event.addListener(marker, 'dragend', function() {
		var latlng = marker.getPosition();
		lng = String(latlng.lng());
        lat = String(latlng.lat());
        setLatLng(lat,lng);
	});
}

function setLatLng(lat,lng) {
    document.getElementById('point1').value = lng;
    document.getElementById('point2').value = lat;
}

window.onload = function () {
	init_map();
}