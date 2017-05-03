<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "announce" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
$part = $part ? $part : "all";
$cityid = $cityid ? intval( $cityid ) : 0;
if ( $part == "add" || $part == "edit" )
{
	require_once( dirname( __FILE__ )."/include/color.inc.php" );
	$mymps_title_color = $color;
}
if ( $part == "add" )
{
	chk_admin_purview( "purview_发布公告" );
	$acontent = get_editor( "content", "Normal" );
	$here = "发布网站公告";
	include( mymps_tpl( "announce_add" ) );
}
else if ( $part == "insert" )
{
	$db->query( "Insert Into `".$db_mymps."announce` (id,cityid,title,titlecolor,content,pubdate,begintime,endtime,author,redirecturl) Values ('','{$cityid}','{$title}','{$titlecolor}','{$content}','{$timestamp}','".strtotime( $begintime )."','".strtotime( $endtime ).( "','".$author."','{$redirecturl}')" ) );
	$inid = $db->insert_id( );
	clear_cache_files( "city_".$cityid );
	$nav_path = "网站公告管理 &raquo 发布网站公告";
	$message = "成功增加一篇公告 <<".$title.">>";
	$after_action = "<a href='../about.php?part=announce#".$inid."' target=\"_blank\"><u>查看该公告</u></a>&nbsp;&nbsp;<a href='?part=add'><u>继续增加公告</u></a>&nbsp;&nbsp;<a href='?part=edit&id={$inid}'><u>重新编辑该公告</u></a>&nbsp;&nbsp;<a href='announce.php'><u>已增加公告管理</u></a>";
	show_message( $nav_path, $message, $after_action );
}
else if ( $part == "edit" )
{
	if ( trim( $_POST[action] ) == "dopost" )
	{
		$sql = "UPDATE `".$db_mymps."announce` SET cityid = '{$cityid}',title='{$title}',titlecolor ='{$titlecolor}',content='{$content}',author='{$author}',pubdate='{$timestamp}',begintime='".strtotime( $begintime )."',endtime='".strtotime( $endtime ).( "',redirecturl='".$redirecturl."' WHERE id = '{$id}'" );
		$res = $db->query( $sql );
		clear_cache_files( "city_".$cityid );
		$nav_path = "网站公告管理 &raquo 修改网站公告";
		$message = "成功修改公告 <<".$title.">>";
		$after_action = "<a href='../about.php?part=announce#".$id."' target=\"_blank\"><u>查看该公告</u></a>&nbsp;&nbsp;<a href='?part=add'><u>我要增加一篇公告</u></a>&nbsp;&nbsp;<a href='?part=edit&id={$id}'><u>重新编辑该公告</u></a>&nbsp;&nbsp;<a href='announce.php'><u>已增加公告管理</u></a>";
		show_message( $nav_path, $message, $after_action );
	}
	else
	{
		$id = intval( $id );
		$here = "修改网站公告";
		$edit = $db->getrow( "SELECT * FROM ".$db_mymps."announce WHERE id = '{$id}'" );
		$acontent = get_editor( "content", "Normal", $edit['content'] );
		include( mymps_tpl( "announce_edit" ) );
	}
}
else if ( $part == "delete" )
{
	$id = intval( $id );
	if ( empty( $id ) )
	{
		write_msg( "没有选择记录" );
	}
	else
	{
		mymps_delete( "announce", "WHERE id = '".$id."'" );
		clear_cache_files( "city_".$cityid );
		write_msg( "删除公告 ".$id." 成功", $url, "Mymps_record" );
	}
}
else if ( $part == "all" )
{
	chk_admin_purview( "purview_已发布公告" );
	$page = empty( $page ) ? 1 : intval( $page );
	$where = $title ? " AND title like '%".$title."%'" : "";
	$where .= $author ? " AND author like '%".$author."%'" : "";
	$where .= $admin_cityid ? " AND cityid = '".$admin_cityid."'" : $cityid ? " AND cityid = '".$cityid."'" : " AND cityid = '0'";
	$sql = "SELECT * FROM ".$db_mymps."announce WHERE 1 {$where} ORDER BY id DESC";
	$rows_num = mymps_count( "announce", "WHERE 1".$where );
	$param = setparam( array( "id", "title", "author", "cityid" ) );
	$announce = page1( $sql );
	$here = "公告列表";
	include( mymps_tpl( "announce_all" ) );
}
else if ( $part == "delall" )
{
	clear_cache_files( "city_".$cityid );
	write_msg( "删除公告 ".mymps_del_all( "announce", $_POST[id] )." 成功", $url, "Mymps_record" );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
