<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "telephone" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
$part = isset( $part ) ? $part : "list";
$id = isset( $id ) ? intval( $id ) : 0;
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	chk_admin_purview( "purview_便民电话" );
	$here = "便民电话设置";
	require_once( dirname( __FILE__ )."/include/ifview.inc.php" );
	require_once( dirname( __FILE__ )."/include/color.inc.php" );
	if ( $part == "edit" && empty( $id ) )
	{
		write_msg( "您未指定要修改的ID编号！" );
	}
	$city_limit = $admin_cityid ? "WHERE cityid = '".$admin_cityid."'" : $cityid ? "WHERE cityid = '".$cityid."'" : " WHERE cityid = '0'";
	$rows_num = mymps_count( "telephone", $city_limit );
	$param = setparam( array( "part", "cityid" ) );
	$telephone = page1( "SELECT * FROM `".$db_mymps."telephone` {$city_limit} ORDER BY displayorder DESC" );
	include( mymps_tpl( CURSCRIPT ) );
}
else
{
	if ( is_array( $newtelname ) && is_array( $newtelnumber ) )
	{
		foreach ( $newtelname as $key => $q )
		{
			$telname = trim( $q );
			$telnumber = mhtmlspecialchars( trim( $newtelnumber[$key] ) );
			$color = mhtmlspecialchars( trim( $newcolor[$key] ) );
			$displayorder = mhtmlspecialchars( trim( $newdisplayorder[$key] ) );
			$if_view = mhtmlspecialchars( trim( $newif_view[$key] ) );
			$if_bold = mhtmlspecialchars( trim( $newif_bold[$key] ) );
			$cityid = intval( $newcityid[$key] );
			if ( $telname && $telnumber )
			{
				$db->query( "INSERT `".$db_mymps."telephone` (telname,telnumber,color,if_bold,displayorder,if_view,cityid) VALUES ('{$telname}','{$telnumber}','{$color}','{$if_bold}','{$displayorder}','{$if_view}',{$cityid})" );
			}
		}
	}
	if ( is_array( $edit ) )
	{
		foreach ( $edit as $kedit => $vedit )
		{
			$db->query( "UPDATE `".$db_mymps."telephone` SET telname='{$vedit['telname']}',cityid='{$vedit['cityid']}',telnumber='{$vedit['telnumber']}',color='{$vedit['color']}',if_bold='{$vedit['if_bold']}',displayorder='{$vedit['displayorder']}',if_view='{$vedit['if_view']}' WHERE id = '{$kedit}'" );
		}
	}
	if ( is_array( $delids ) )
	{
		$db->query( "DELETE FROM `".$db_mymps."telephone` WHERE ".create_in( $delids, "id" ) );
	}
	clear_cache_files( "city_".$cityid );
	write_msg( "便民电话设置更新成功！", $forward_url ? $forward_url : "telephone.php?cityi=".$cityid, "write_record" );
}
if ( is_object( $db ) )
{
	$db->close();
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
