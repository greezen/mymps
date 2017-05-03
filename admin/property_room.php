<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define("CURSCRIPT", "property_room");
require_once(dirname(__FILE__) . "/global.php");
require_once(MYMPS_INC . "/db.class.php");
if (!defined("IN_ADMIN") || !defined("IN_MYMPS")) {
    exit("Access Denied");
}
require_once('../plugin/property/include/Constants.php');
require_once('../plugin/property/include/functions.php');
$part = $part ? trim($part) : "list";
$id = isset($id) ? intval($id) : "";
chk_admin_purview(Constants::PURVIEW_ROOM);

if (!submit_check(CURSCRIPT . "_submit")) {
    if ($part == "list") {
        $params = [];
        $where = ' WHERE 1=1 ';
        if (!empty($name)) {
            $where .= " AND name = '" . $name . "'";
            $params['name'] = $name;
        }

        if (!empty($params)) {
            $param = http_build_query($params) . '&';
        }

        $query = $db->query("SELECT * FROM `" . $db_mymps . "room` " . $where);
        $rows_num = $db->num_rows($query);
        $per_page = 20;
        $pages_num = ceil($rows_num / $per_page);
        $page = empty($page) ? 1 : $page;
        $offset = ($page - 1) * $per_page;
        $list = $db->getAll("SELECT * FROM `" . $db_mymps . "room` " . $where . " ORDER BY display_order ASC LIMIT $offset,{$per_page}");
    } elseif ($part == 'edit') {
        $room = $db->get_one('SELECT * FROM ' . $db_mymps . 'room WHERE room_id=' . $room_id);
        $building = $db->get_one('SELECT * FROM ' . $db_mymps . 'building WHERE building_id=' . $room['building_id']);
        $area = $db->get_one("SELECT * FROM `" . $db_mymps . "area` WHERE `areaid` = " . $building['area_id']);
        $city = $db->get_one("SELECT * FROM `" . $db_mymps . "city` WHERE `cityid` = " . $area['cityid']);
        $province = $db->get_one("SELECT * FROM `" . $db_mymps . "province` WHERE `provinceid` = " . $city['provinceid']);
        $area_list = $db->getAll("SELECT * FROM `" . $db_mymps . "area` WHERE `cityid` = " . $area['cityid'] . " ORDER BY displayorder ASC");
        $city_list = $db->getAll("SELECT * FROM `" . $db_mymps . "city` WHERE `provinceid` = " . $city['provinceid'] . " ORDER BY displayorder ASC");
        $building_list = $db->getAll("SELECT * FROM `" . $db_mymps . "building` WHERE `building_id` = " . $room['building_id'] . " ORDER BY display_order ASC");

    } elseif ($part == 'del') {

        $db->query('DELETE FROM ' . $db_mymps . 'building WHERE building_id=' . $building_id);
        $res = $db->affected_rows();
        if ($res > 0) {
            write_msg('操作成功', '??part=list');
        }

        write_msg('操作失败', '??part=list');

    }
    $here = "房号信息";
    $province_list = $db->getall("SELECT * FROM `" . $db_mymps . "province` ORDER BY displayorder ASC");
    include(mymps_tpl("property_room_" . $part));
} elseif ($part == 'add') {

    if (mb_strlen($name) > 16) {
        write_msg('小区名称不能超过16个字符');
    } elseif (empty($province_id)) {
        write_msg('请选择省份');
    } elseif (empty($city_id)) {
        write_msg('请选择市');
    } elseif (empty($area_id)) {
        write_msg('请选择区');
    }

    $room = $db->get_one('SELECT * FROM ' . $db_mymps . 'room WHERE building_id=' . $building_id . ' AND `name` = "' . $name . '"');
    if (!empty($room)) {
        write_msg('此房号已经存在');
    }

    $now = time();
    $db->query("INSERT INTO " . $db_mymps . "room (building_id,name,time_created,time_updated) VALUES ('{$building_id}','{$name}','{$now}','{$now}')");
    $res = $db->affected_rows();

    if ($res > 0) {
        write_msg("增加房号成功");
    } else {
        write_msg("增加房号失败");
    }

} elseif ($part == 'edit') {

    if (mb_strlen($name) > 16) {
        write_msg('小区名称不能超过16个字符');
    } elseif (empty($province_id)) {
        write_msg('请选择省份');
    } elseif (empty($city_id)) {
        write_msg('请选择市');
    } elseif (empty($area_id)) {
        write_msg('请选择区');
    }

    $room = $db->get_one('SELECT * FROM ' . $db_mymps . 'room WHERE building_id=' . $building_id . ' AND `name` = "' . $name . '"');
    if (!empty($room)) {
        write_msg('此房号已经存在');
    }

    $now = time();

    $db->query("UPDATE " . $db_mymps . "room SET `building_id`='{$building_id}',`name`='{$name}',`time_updated`={$now} WHERE `room_id` = " . $room_id);
    $res = $db->affected_rows();

    if ($res > 0) {
        write_msg("修改房号成功");
    } else {
        write_msg("修改房号失败");
    }

} else {

}
unset($status);
if (is_object($db)) {
    $db->close();
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
