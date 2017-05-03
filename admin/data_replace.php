<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "data_replace" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
$part = isset( $part ) ? $part : "default";
if ( $part == "default" )
{
	$here = "数据库内容替换";
	chk_admin_purview( "purview_数据库维护" );
	include( mymps_tpl( "data_replace" ) );
}
else
{
	if ( $part == "do_action" )
	{
		if ( empty($exptable) || empty($rpfield) )
		{
			write_msg( "请指定数据表和字段！", "olmsg" );
			exit( );
		}
		if ( empty($rpstring) )
		{
			write_msg( "请指定被替换内容！", "olmsg" );
			exit( );
		}
		$rs = $db->query( "UPDATE ".$exptable." SET {$rpfield}=REPLACE({$rpfield},'{$rpstring}','{$tostring}')" );
		$db->query( "OPTIMIZE TABLE `".$exptable."`" );
		if ( $rs )
		{
			write_msg( "成功完成数据替换！", "olmsg", "write_mymps_record" );
			exit( );
		}
		write_msg( "数据替换失败！", "olmsg", "write_mymps_record" );
		exit( );
	}
}
if ( is_object( $db ) )
{
	$db->close( );
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
