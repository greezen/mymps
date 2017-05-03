<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
$userid = isset( $_GET['userid'] ) ? mhtmlspecialchars( $_GET['userid'] ) : "";
if ( !( $row = $db->getrow( "SELECT * FROM `".$db_mymps."member` WHERE userid = '{$userid}'" ) ) )
{
    errormsg( "您所访问的用户不存在或者未通过审核！" );
}
$where = " WHERE userid = '".$userid."' AND (info_level = 1 OR info_level = 2)";
$perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
$param = setparams( array( "mod", "userid" ) );
$rows_num = $db->getone( "SELECT COUNT(id) FROM `".$db_mymps."information` {$where}" );
$totalpage = ceil( $rows_num / $perpage );
$num = intval( $page - 1 ) * $perpage;
$info_list = page1( "SELECT * FROM `".$db_mymps."information` {$where} ORDER BY id DESC", $perpage );
$pageview = pager( );
include( mymps_tpl( "member_mypost" ) );
?>
