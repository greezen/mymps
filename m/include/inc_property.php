<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
require_once MYMPS_ROOT .'/plugin/property/include/functions.php';

$status = isset($_GET['status'])?trim($_GET['status']):'N';
$uid = $db->getOne("SELECT id FROM ". $db_mymps . "member WHERE userid='{$s_uid}'");
$room_id = $db->getOne("SELECT room_id FROM ".$db_mymps."property WHERE uid={$uid}");
if ($room_id) {
    $where = " WHERE room_id = {$room_id} AND status='{$status}'";
    $perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
    $param = setparams( array( "mod", "status" ) );
    $rows_num = $db->getone( "SELECT COUNT(id) FROM `".$db_mymps."property` {$where}" );
    $totalpage = ceil( $rows_num / $perpage );
    $num = intval( $page - 1 ) * $perpage;
    $list = page1( "SELECT * FROM `".$db_mymps."property` {$where} ORDER BY id DESC", $perpage );
    $pageview = pager( );
} else {
    $province_list = $db->getall("SELECT * FROM `" . $db_mymps . "province` ORDER BY displayorder ASC");
}

include( mymps_tpl( "member_property" ) );
?>
