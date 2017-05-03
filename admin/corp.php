<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "corp" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
$part = $part ? $part : "list";
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	if ( $part == "list" )
	{
		chk_admin_purview( "purview_商家分类" );
		$corp = cat_list( "corp", 0, 0, false );
		$here = "商家分类";
		include( mymps_tpl( "corp_list" ) );
	}
	else if ( $part == "add" )
	{
		chk_admin_purview( "purview_增加分类" );
		$maxorder = $db->getone( "SELECT MAX(corporder) FROM ".$db_mymps."corp" );
		$maxorder += 1;
		$here = "增加分类";
		include( mymps_tpl( "corp_add" ) );
	}
	else if ( $part == "edit" )
	{
		$corp = $db->getrow( "SELECT * FROM ".$db_mymps."corp WHERE corpid = '{$corpid}'" );
		$here = "编辑商家分类";
		include( mymps_tpl( "corp_edit" ) );
	}
	else if ( $part == "del" )
	{
		if ( empty( $corpid ) )
		{
			write_msg( "没有选择记录" );
		}
		mymps_delete( "corp", "WHERE corpid = '".$corpid."'" );
		mymps_delete( "corp", "WHERE parentid = '".$corpid."'" );
		clear_cache_files( "corp_option_static" );
		clear_cache_files( "corp_pid_releate" );
		write_msg( "删除商家分类 ".$corpid." 成功", "?part=list", "Mymps_record" );
	}
}
else if ( $part == "add" )
{
	if ( empty( $corpname ) )
	{
		write_msg( "请填写商家分类名称" );
	}
	$corpname = explode( "|", trim( $corpname ) );
	if ( empty( $corporder ) )
	{
		$maxorder = $db->getone( "SELECT MAX(corporder) FROM ".$db_mymps."corp" );
		$corporder = $maxorder + 1;
	}
	if ( is_array( $corpname ) )
	{
		foreach ( $corpname as $key => $value )
		{
			$value = trim( $value );
			++$corporder;
			$len = strlen( $value );
			if ( $len < 2 || 30 < $len )
			{
				write_msg( "分类名必须在2个至30个字符之间" );
				exit( );
			}
			$db->query( "INSERT INTO ".$db_mymps."corp (corpname,parentid,corporder) VALUES ('{$value}','{$parentid}','{$corporder}')" );
		}
	}
	foreach ( array( "option_static", "pid_releate" ) as $range )
	{
		clear_cache_files( "corp_".$range );
	}
	write_msg( "成功更新商家分类！", "corp.php?part=list", "write_record" );
}
else if ( $part == "edit" )
{
	if ( empty( $corpname ) )
	{
		write_msg( "请填写商家分类名称" );
	}
	$len = strlen( $corpname );
	if ( $corpid == $parentid )
	{
		write_msg( "隶属分类不能为自己！" );
	}
	if ( $len < 2 || 30 < $len )
	{
		write_msg( "类别名称必须在2个至30个字符之间" );
	}
	$sql = "UPDATE ".$db_mymps."corp SET corpname='{$corpname}',\r\n\t\tparentid='{$parentid}',\r\n\t\tcorporder='{$corporder}'\r\n\t\tWHERE corpid = '{$corpid}'";
	$res = $db->query( $sql );
	foreach ( array( "option_static", "pid_releate" ) as $range )
	{
		clear_cache_files( "corp_".$range );
	}
	$nav_path = "地区管理 &raquo 编辑地区";
	$message = "成功编辑商家分类 ".$corpname;
	$after_action = "<a href='?part=add'><u>继续增加商家分类</u></a>\r\n\t\t&nbsp;&nbsp;<a href='?part=edit&corpid=".$corpid."'><u>重新编辑该分类</u></a>&nbsp;&nbsp;<a href='?part=list#{$catid}'><u>已增加分类管理</u></a>";
	show_message( $nav_path, $message, $after_action );
}
else if ( $part == "list" && is_array( $corporder ) )
{
	foreach ( $corporder as $key => $value )
	{
		$db->query( "UPDATE `".$db_mymps."corp` SET corporder = '{$value}' WHERE corpid = ".$key );
	}
	foreach ( array( "option_static", "pid_releate" ) as $range )
	{
		clear_cache_files( "corp_".$range );
	}
	write_msg( "成功更新商家分类！", "corp.php?part=list", "write_record" );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
