<?php

if ( CURSCRIPT != "wap" )
{
	exit( "FORBIDDEN" );
}
$keywords = isset( $_GET['keywords'] ) ? addslashes( $_GET['keywords'] ) : "";
if ( $keywords != "" && strlen( $keywords ) < 7 )
{
	redirectmsg( "请输入正确的手机号或电话号码！", "index.php?mod=delete" );
}
$timestamp = time( );
define( CURSCRIPT, "delete" );
$perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
$page = isset( $_GET['page'] ) ? intval( $_GET['page'] ) : "";
$page = empty( $page ) ? 1 : $page;
$where = " WHERE a.info_level > 0 ";
$where .= $keywords ? " AND (tel LIKE '%".$keywords."%') " : "";
$rows_num = $db->getone( "SELECT COUNT(a.id) FROM `".$db_mymps."information` AS a {$where}" );
$totalpage = ceil( $rows_num / $perpage );
$num = intval( $page - 1 ) * $perpage;
$param = setparams( array( "mod", "keywords" ) );
$info_list = $db->getall( "SELECT a.* FROM `".$db_mymps."information` AS a {$where} ORDER BY a.id DESC LIMIT {$num},{$perpage}" );
include( mymps_tpl( "member_delete" ) );
?>
