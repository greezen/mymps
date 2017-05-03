var maps = new LTMaps( map_id );
var control = new LTStandMapControl(); 
maps.addControl(control);
maps.handleMouseScroll(false);

if(p1 != '' && p2 != '') {
	p1 = p1 * 100000;
	p2 = p2 * 100000;
	var point = new LTPoint (p1, p2);
	maps.cityNameAndZoom ( point , view_level );

	if(show > 0) {
		var marker = new LTMarker( point );
		maps.addOverLay ( marker );

		var maptxt = new LTMapText( point );
		maptxt.setLabel ( title );
		maps.addOverLay ( maptxt );
	}

} else {
	maps.cityNameAndZoom( cityname , view_level );
}

var mkctrl = new LTMarkControl();
mkctrl.setVisible ( false );
maps.addControl ( mkctrl );

LTEvent.addListener( mkctrl , "mouseup" , getPoi );

var np1 = np2 = '';

function markmap() {
	//ÒÆ³ý×ø±ê
	maps.clearOverLays();
	mkctrl.btnClick();
}

function getPoi() {
    var poi = mkctrl.getMarkControlPoint();
    document.getElementById('point1').value = poi.getLongitude() / 100000;
    document.getElementById('point2').value = poi.getLatitude() / 100000;
}