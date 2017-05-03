<?php
function get_group_class(){
	global $db,$db_mymps;
	static $res = NULL;
	$data = read_static_cache('group_class');
	if($data === false){
		$query = $db -> query("SELECT * FROM `{$db_mymps}group_category` WHERE cate_view = '1' ORDER BY cate_order ASC");
		while($row = $db-> fetchRow($query)){
			$res[$row['cate_id']]['cate_id'] = $row['cate_id'];
			$res[$row['cate_id']]['cate_name'] = $row['cate_name'];
			$res[$row['cate_id']]['cate_uri'] = plugin_url('group',array('cate_id'=>$row['cate_id']));
		}
		write_static_cache('group_class',$res);
	} else {
		$res = $data;
	}
	return $res;
}

function get_groupclass_select($formname='cate_id',$cate_id='',$ifselect='yes'){
	global $db,$db_mymps;
	$data = get_group_class();
	$mymps .= $ifselect == 'yes' ? '<select name="'.$formname.'" id="'.$formname.'">' : '';
	foreach($data as $k => $v){
		$mymps .= '<option value="'.$v[cate_id].'"';
		$mymps .= $cate_id == $v['cate_id'] ? ' selected style="background-color:#6EB00C;color:white"' : '';
		$mymps .= '>'.$v[cate_name].'</option>';
	}
	$mymps .= $ifselect == 'yes' ?'</select>' : '';
	unset($data);
	return $mymps;
}

function get_address($id, $type = 'area') {
	global $db,$db_mymps;
	if ($type === 'area') {
		$area = $db->get_one("SELECT * FROM `" . $db_mymps . "area` WHERE `areaid` = " . $id);
		$city = $db->get_one("SELECT * FROM `" . $db_mymps . "city` WHERE `cityid` = " . $area['cityid']);
		$province = $db->get_one("SELECT * FROM `" . $db_mymps . "province` WHERE `provinceid` = " . $city['provinceid']);

		$addr = $province['provincename'] . ' ' . $city['cityname'] . ' ' . $area['areaname'];
	} elseif ($type === 'building') {
		$building = $db->get_one("SELECT * FROM `" . $db_mymps . "building` WHERE `building_id` = " . $id);
		$area = $db->get_one("SELECT * FROM `" . $db_mymps . "area` WHERE `areaid` = " . $building['area_id']);
		$city = $db->get_one("SELECT * FROM `" . $db_mymps . "city` WHERE `cityid` = " . $area['cityid']);
		$province = $db->get_one("SELECT * FROM `" . $db_mymps . "province` WHERE `provinceid` = " . $city['provinceid']);

		$addr = $province['provincename'] . ' ' . $city['cityname'] . ' ' . $area['areaname'] . ' ' . $building['name'];
	} elseif ($type === 'room') {
		$room = $db->get_one("SELECT * FROM `" . $db_mymps . "room` WHERE `room_id` = " . $id);
		$building = $db->get_one("SELECT * FROM `" . $db_mymps . "building` WHERE `building_id` = " . $room['building_id']);
		$area = $db->get_one("SELECT * FROM `" . $db_mymps . "area` WHERE `areaid` = " . $building['area_id']);
		$city = $db->get_one("SELECT * FROM `" . $db_mymps . "city` WHERE `cityid` = " . $area['cityid']);
		$province = $db->get_one("SELECT * FROM `" . $db_mymps . "province` WHERE `provinceid` = " . $city['provinceid']);

		$addr = $province['provincename'] . ' ' . $city['cityname'] . ' ' . $area['areaname'] . ' ' . $building['name'] . ' ' . $room['name'];
	}

	return $addr;
}
?>