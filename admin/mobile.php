<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "mobile" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	chk_admin_purview( "purview_手机访问设置" );
	$here = "手机版访问设置";
	$mobile = $db->getone( "SELECT value FROM `".$db_mymps."config` WHERE type='mobile' AND description = 'mobile'" );
	$mobile = $mobile ? $charset == "utf-8" ? utf8_unserialize( $mobile ) : unserialize( $mobile ) : array( );
	include( mymps_tpl( CURSCRIPT ) );
}
else
{
	$db->query( "DELETE FROM `".$db_mymps."config` WHERE description = 'mobile' AND type = 'mobile'" );
	$db->query( "INSERT INTO `".$db_mymps."config` (description,value,type) values ('mobile','".serialize( $settings )."','mobile')" );
	clear_cache_files( "mobile" );
	write_msg( "手机版访问设置更新成功！", "mobile.php", "WriteRecord" );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
