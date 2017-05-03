<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define("CURSCRIPT", "property_add");
require_once(dirname(__FILE__) . "/global.php");
require_once(MYMPS_INC . "/db.class.php");
if (!defined("IN_ADMIN") || !defined("IN_MYMPS")) {
    exit("Access Denied");
}
require_once('../plugin/property/include/Constants.php');
require_once('../plugin/property/include/functions.php');
$part = $part ? trim($part) : "list";
$id = isset($id) ? intval($id) : "";
chk_admin_purview(Constants::PURVIEW_ADD);

if (!submit_check(CURSCRIPT . "_submit")) {
    if ($part == "list") {
        $query = $db->query("SELECT * FROM `" . $db_mymps . "property_price`");
        $rows_num = $db->num_rows($query);
        $per_page = 20;
        $pages_num = ceil($rows_num / $per_page);
        $page = empty($page) ? 1 : $page;
        $offset = ($page - 1) * $per_page;
        $list = $db->getAll("SELECT * FROM `" . $db_mymps . "property_price` ORDER BY time_created DESC LIMIT $offset,{$per_page}");
    } else if ($part == "edit") {
        $row = $db->get_one('SELECT * FROM ' . $db_mymps . 'property_price WHERE `id` = ' . $id);
        $province = $db->get_one('SELECT * FROM ' . $db_mymps . 'province WHERE `provinceid` = ' . $row['province_id']);
        $city = $db->get_one('SELECT * FROM ' . $db_mymps . 'city WHERE `cityid` = ' . $row['city_id']);
        $city_list = $db->getAll('SELECT * FROM ' . $db_mymps . 'city  WHERE `provinceid` = ' . $row['province_id'] . ' ORDER BY displayorder ASC');
        $area = $db->get_one('SELECT * FROM ' . $db_mymps . 'area WHERE `areaid` = ' . $row['area_id']);
        $area_list = $db->getAll('SELECT * FROM ' . $db_mymps . 'area WHERE `cityid` = ' . $row['city_id'] . ' ORDER BY displayorder ASC');
        $building = $db->get_one('SELECT * FROM ' . $db_mymps . 'building WHERE `building_id` = ' . $row['building_id']);
        $building_list = $db->getAll('SELECT * FROM ' . $db_mymps . 'building WHERE `area_id` = ' . $row['area_id'] . ' ORDER BY display_order ASC');
        $room = $db->get_one('SELECT * FROM ' . $db_mymps . 'room WHERE `room_id` = ' . $row['room_id']);
        $room_list = $db->getAll('SELECT * FROM ' . $db_mymps . 'room WHERE `building_id` = ' . $row['building_id'] . ' ORDER BY display_order ASC');

    } elseif ($part == 'del') {
        $now = time();
        $db->query("DELETE FROM " . $db_mymps . "property_price WHERE `id` = " . $id);
        $res = $db->affected_rows();

        if ($res > 0) {
            write_msg("信息删除成功");
        } else {
            write_msg("信息删除失败");
        }
    }
    $here = "物业信息录入";
    $province_list = $db->getall("SELECT * FROM `" . $db_mymps . "province` ORDER BY displayorder ASC");
    include(mymps_tpl("property_" . $part));
} elseif ($part == 'add') {
    if (empty($province_id)) {
        write_msg('请选择省份');
    } elseif (empty($city_id)) {
        write_msg('请选择市');
    } elseif (empty($area_id)) {
        write_msg('请选择区/县');
    } elseif (empty($building_id)) {
        write_msg('请选择小区');
    } elseif (empty($room_id)) {
        write_msg('请选择房号');
    } elseif (empty($price)) {
        write_msg('请输入金额');
    }

    $res = $db->get_one('SELECT * FROM '. $db_mymps . 'property_price WHERE `room_id` = '. $room_id);
    if (!empty($res)) {
        write_msg('该房号信息已经存在,请勿重复添加');
    }

    $now = time();
    $db->query("INSERT INTO " . $db_mymps .
        "property_price (province_id,city_id,area_id,building_id,room_id,price,time_created,time_updated) 
		VALUES ('{$province_id}','{$city_id}','{$area_id}','{$building_id}','{$room_id}','{$price}','{$now}','{$now}')");
    $res = $db->affected_rows();

    if ($res > 0) {
        write_msg("信息录入成功");
    } else {
        write_msg("信息录入失败");
    }
} elseif ($part == 'edit') {
    if (empty($province_id)) {
        write_msg('请选择省份');
    } elseif (empty($city_id)) {
        write_msg('请选择市');
    } elseif (empty($area_id)) {
        write_msg('请选择区/县');
    } elseif (empty($building_id)) {
        write_msg('请选择小区');
    } elseif (empty($room_id)) {
        write_msg('请选择房号');
    } elseif (empty($price)) {
        write_msg('请输入金额');
    }

    $now = time();
    $db->query("UPDATE " . $db_mymps . "property_price SET province_id='{$province_id}',city_id='{$city_id}',area_id='{$area_id}',building_id='{$building_id}',room_id='$room_id}',price='{$price}',time_updated='{$now}' WHERE `id`=" . $id);
    $res = $db->affected_rows();

    if ($res > 0) {
        write_msg("信息修改成功");
    } else {
        write_msg("信息修改失败");
    }
} else {

}
unset($status);
if (is_object($db)) {
    $db->close();
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
