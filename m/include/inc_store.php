<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
$action = isset( $action ) ? trim( $action ) : "";
$id = isset( $id ) ? intval( $id ) : "";
$navi = array( "index" => "首页", "aboutus" => "简介", "info" => "信息", "album" => "相册", "contact" => "位置" );
if ( !in_array( $action, array_keys( $navi ) ) )
{
    $action = "index";
}
$store = $db->getrow( "SELECT * FROM `".$db_mymps."member` WHERE if_corp = 1 AND status = 1 AND id = '{$id}'" );
if ( !$store )
{
    errormsg( "该机构不存在或者未通过审核！" );
}
if ( !$city )
{
    $city = get_city_caches( $store['cityid'] );
}
if ( $action == "index" )
{
    $info_list = mymps_get_infos( "5", "", "", $store['userid'] );
    $album = $db->getall( "SELECT a.* FROM `".$db_mymps."member_album` AS a  WHERE a.userid='{$store['userid']}' ORDER BY a.id DESC LIMIT 0,2" );
    include( mymps_tpl( "store" ) );
    exit( );
}
if ( $action == "info" )
{
    $where = " WHERE userid = '".$store['userid']."' AND (info_level = 1 OR info_level = 2)";
    $perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
    $param = setparams( array( "mod", "action", "id" ) );
    $rows_num = $db->getone( "SELECT COUNT(id) FROM `".$db_mymps."information` {$where}" );
    $totalpage = ceil( $rows_num / $perpage );
    $num = intval( $page - 1 ) * $perpage;
    $info_list = page1( "SELECT * FROM `".$db_mymps."information` {$where} ORDER BY id DESC", $perpage );
    $pageview = pager( );
}
else if ( $action == "album" )
{
    $where = " WHERE userid = '".$store['userid']."'";
    $perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
    $param = setparams( array( "mod", "action", "id" ) );
    $rows_num = $db->getone( "SELECT COUNT(id) FROM `".$db_mymps."member_album` {$where}" );
    $totalpage = ceil( $rows_num / $perpage );
    $num = intval( $page - 1 ) * $perpage;
    $album = page1( "SELECT * FROM `".$db_mymps."member_album` {$where} ORDER BY id DESC", $perpage );
    $pageview = pager( );
}
include( mymps_tpl( "store_".$action ) );
?>
