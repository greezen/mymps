<?php
define( "IN_SMT", true );
define( "CURSCRIPT", "address" );
define( "IN_MYMPS", true );
require_once( dirname( __FILE__ )."/include/global.php" );
require_once( MYMPS_DATA."/config.php" );
require_once( MYMPS_DATA."/config.db.php" );
require_once( MYMPS_INC."/db.class.php" );

if (isset($_POST['do'])){
    $do = trim($_POST['do']);

    $data = [];
    if ($do === 'city') {
        $provinceid = isset($_POST['province_id'])?intval($_POST['province_id']):0;
        $db->query('set names utf8');
        $rows  = $db->getall( "SELECT * FROM `".$db_mymps."city` WHERE `provinceid` = " . $provinceid . "  ORDER BY displayorder ASC" );
        foreach ($rows as $row) {
            $temp = array(
                'id' => $row['cityid'],
                'name' => $row['cityname'],
            );
            array_push($data, $temp);
            unset($temp);
        }
    } elseif ($do === 'area') {
        $cityid = isset($_POST['city_id'])?intval($_POST['city_id']):0;
        $db->query('set names utf8');
        $rows  = $db->getall( "SELECT * FROM `".$db_mymps."area` WHERE `cityid` = " . $cityid . "  ORDER BY displayorder ASC" );
        foreach ($rows as $row) {
            $temp = array(
                'id' => $row['areaid'],
                'name' => $row['areaname'],
            );
            array_push($data, $temp);
            unset($temp);
        }
    } elseif ($do === 'building') {
        $area_id = isset($_POST['area_id'])?intval($_POST['area_id']):0;
        $db->query('set names utf8');
        $rows  = $db->getall( "SELECT * FROM `".$db_mymps."building` WHERE `area_id` = " . $area_id . "  ORDER BY display_order ASC" );
        foreach ($rows as $row) {
            $temp = array(
                'id' => $row['building_id'],
                'name' => $row['name'],
            );
            array_push($data, $temp);
            unset($temp);
        }
    } elseif ($do === 'room') {
        $building_id = isset($_POST['building_id'])?intval($_POST['building_id']):0;
        $db->query('set names utf8');
        $rows  = $db->getall( "SELECT * FROM `".$db_mymps."room` WHERE `building_id` = " . $building_id . "  ORDER BY display_order ASC" );
        foreach ($rows as $row) {
            $temp = array(
                'id' => $row['room_id'],
                'name' => $row['name'],
            );
            array_push($data, $temp);
            unset($temp);
        }
    } else {
       $data = [];
    }
    echo json_encode($data);exit;
}

return false;