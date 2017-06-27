<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "payapi" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
$part = $part ? $part : "list";
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
chk_admin_purview( "purview_管理支付接口" );
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	$here = "管理支付接口";
	$payapi = $db->getall( "SELECT * FROM `".$db_mymps."payapi` ORDER BY payid DESC" );
	if ( !empty( $payid ) )
	{
		$paydetail = $db->getrow( "SELECT * FROM `".$db_mymps."payapi` WHERE payid = '{$payid}'" );
	}
	include( mymps_tpl( CURSCRIPT ) );
}
else
{
	$db->query( "UPDATE `".$db_mymps."payapi` SET paytype= '{$paytype}',buytype= '{$buytype}',payuser='{$payuser}',payfee='{$payfee}',isclose='{$isclose}',payname='{$payname}',paysay='{$paysay}',payemail='{$payemail}',paykey='{$paykey}' WHERE payid = '{$payid}'" );
	write_msg( "支付接口设置更新成功！", $return_url, "write_record" );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
