<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
if ($iflogin == 0) {
    $url = 'http://'.$_SERVER["HTTP_HOST"].'/m/index.php?mod=login&returnurl='.$returnurl;
    header('Location:'.$url);
    exit;
}
require_once MYMPS_ROOT .'/plugin/property/include/functions.php';

$status = isset($_GET['status'])?trim($_GET['status']):'N';
$user = $db->get_one("SELECT id,room_id FROM ". $db_mymps . "member WHERE userid='{$s_uid}'");
$room_id = $user['room_id'];

if ($room_id) {
    $where = " WHERE room_id = {$room_id} AND status='{$status}'";
    $perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
    $param = setparams( array( "mod", "status" ) );
    $rows_num = $db->getone( "SELECT COUNT(id) FROM `".$db_mymps."property` {$where}" );
    $totalpage = ceil( $rows_num / $perpage );
    $num = intval( $page - 1 ) * $perpage;
    $list = page1( "SELECT * FROM `".$db_mymps."property` {$where} ORDER BY id DESC", $perpage );
    $pageview = pager();
    $total = $db->getOne("SELECT sum(manage_fee+water_fee+electric_fee+other_fee) total FROM `my_property` WHERE room_id={$user['room_id']} AND `status`='N'");
    if (empty($total)) {
        $total = 0;
    }
} else {
    $total = 0;
}
$province_list = $db->getall("SELECT * FROM `" . $db_mymps . "province` ORDER BY displayorder ASC");
include( mymps_tpl( "member_property" ) );
?>
