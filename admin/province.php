<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "province" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	$here = "省份/直辖市管理";
	$province = $db->getall( "SELECT * FROM `".$db_mymps."province` ORDER BY displayorder ASC" );
	include( mymps_tpl( "province" ) );
}
else
{
	if ( is_array( $provincename ) )
	{
		foreach ( $provincename as $key => $val )
		{
			$province_name = trim( $val );
			$display_order = intval( $displayorder[$key] );
			if ( $province_name )
			{
				$db->query( "UPDATE `".$db_mymps."province` SET displayorder='{$display_order}',provincename='{$province_name}' WHERE provinceid='{$key}'" );
				unset( $province_name );
				unset( $display_order );
			}
		}
	}
	if ( is_array( $newdisplayorder ) && is_array( $newprovincename ) )
	{
		foreach ( $newprovincename as $key => $provincename )
		{
			$provincename = trim( $provincename );
			$displayorder = intval( $newdisplayorder[$key] );
			if ( $provincename )
			{
				$db->query( "INSERT INTO\t`".$db_mymps."province` (displayorder,provincename) VALUES ( '{$displayorder}','{$provincename}')" );
				unset( $displayorder );
				unset( $provincename );
				unset( $cate_view );
			}
		}
	}
	if ( is_array( $delete ) )
	{
		$db->query( "DELETE FROM `".$db_mymps."province` WHERE ".create_in( $delete, "provinceid" ) );
	}
	write_msg( "省份/直辖市设置更新成功", "?", "write_record" );
}
if ( is_object( $db ) )
{
	$db->Close();
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
