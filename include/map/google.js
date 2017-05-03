var map = null;
if (GBrowserIsCompatible()) {
    map = new GMap2(document.getElementById(map_id));
    //缩放和移动控件
    map.addControl(new GSmallMapControl());
    map.addControl(new GScaleControl());
    map.addControl(new GMenuMapTypeControl());
}
if(p1 != '' && p2 != '') {
	var c = new GLatLng(p2, p1);
    map.setCenter(c, view_level);
	if(show > 0) {
        map.addOverlay(new GMarker(c, {title: title}));
	}
} else {
	map.setCenter(new GLatLng('30.2448','120.1519'), view_level);
}

function markmap() {
    var Center = map.getCenter();
    var lat = new String(Center.lat());
    var lng = new String(Center.lng());
    setLatLng(lat, lng);
    var marker = new GMarker(new GLatLng(lat, lng), {draggable: true});
    GEvent.addListener(marker, "dragstart", function() {
      map.closeInfoWindow();
    });
    GEvent.addListener(marker, "dragend", function() {
        var latlng = marker.getLatLng();
		lng = String(latlng.lng());
        lat = String(latlng.lat());
        setLatLng(lat,lng);
    });
    map.addOverlay(marker);
}

function setLatLng(lat,lng) {
    document.getElementById('point1').value = lng;
    document.getElementById('point2').value = lat;
}