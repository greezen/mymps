<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "site_about" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
if ( !in_array( $part, array( "list", "edit" ) ) )
{
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	chk_admin_purview( "purview_栏目设置" );
	require_once( MYMPS_DATA."/html_type.inc.php" );
	$about = $db->getrow( "SELECT * FROM ".$db_mymps."about WHERE id = '{$id}'" );
	$acontent = $id ? get_editor( "content", "Default", $about['content'] ) : get_editor( "content", "Default", "" );
	$about[displayorder] = $id ? $about[displayorder] : $db->getone( "SELECT max(displayorder) FROM `".$db_mymps."about` " ) + 1;
	$about_type = $db->getall( "SELECT * FROM ".$db_mymps."about ORDER BY displayorder ASC" );
	$here = "关于我们设置";
	include( mymps_tpl( "site_about" ) );
}
else
{
	if ( $part == "list" )
	{
		if ( is_array( $delids ) )
		{
			$delids = implode( ",", $delids );
			mymps_delete( "about", "WHERE id IN(".$delids.")" );
		}
		if ( is_array( $displayorder ) )
		{
			foreach ( $displayorder as $key => $value )
			{
				$db->query( "UPDATE `".$db_mymps."about` SET displayorder = '{$value}' WHERE id = ".$key );
			}
		}
	}
	else if ( $part == "edit" )
	{
		require_once( dirname( __FILE__ )."/include/pinyin.inc.php" );
		$pubdate = $time;
		$content = trim( $content );
		if ( $id )
		{
			if ( empty( $typename ) )
			{
				write_msg( "栏目名称不能为空" );
			}
			if ( empty( $content ) )
			{
				write_msg( "栏目内容不能为空" );
			}
			$db->query( "INSERT INTO ".$db_mymps."about (typename,dir_type,content,pubdate,displayorder) VALUES ('{$typename}','{$dir_type}','{$content}','{$pubdate}','{$displayorder}')" );
			$id = $db->insert_id( );
			$dir_typename = get_htmlpath_type( $dir_type, $typename, $id, $mydir );
			$db->query( "UPDATE `".$db_mymps."about` SET dir_typename = '{$dir_typename}' WHERE id = '{$id}'" );
		}
		else
		{
			$dir_typename = get_htmlpath_type( $dir_type, $typename, $id, $mydir );
			$db->query( "UPDATE ".$db_mymps."about SET typename = '{$typename}', content='{$content}',pubdate='{$pubdate}', dir_type = '{$dir_type}' , dir_typename = '{$dir_typename}',displayorder = '{$displayorder}' WHERE id = '{$id}'" );
			$forward_url = "?part=edit&id=".$id;
		}
	}
	write_msg( "关于我们栏目更新或删除成功", $forward_url ? $forward_url : "?part=list", "write_sys_record" );
}
if ( is_object( $db ) )
{
	$db->close();
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
