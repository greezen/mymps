<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
require_once MYMPS_ROOT .'/plugin/property/include/functions.php';

$status = isset($_GET['status'])?trim($_GET['status']):'N';
$uid = $db->getOne("SELECT id FROM ". $db_mymps . "member WHERE userid='{$s_uid}'");
$where = " WHERE uid = {$uid} AND status='{$status}'";
$perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
$param = setparams( array( "mod", "status" ) );
$rows_num = $db->getone( "SELECT COUNT(id) FROM `".$db_mymps."property` {$where}" );
$totalpage = ceil( $rows_num / $perpage );
$num = intval( $page - 1 ) * $perpage;
$list = page1( "SELECT * FROM `".$db_mymps."property` {$where} ORDER BY id DESC", $perpage );
$pageview = pager( );
include( mymps_tpl( "member_property" ) );
?>
