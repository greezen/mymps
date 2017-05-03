<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "goods_order" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
$part = $part ? trim( $part ) : "list";
$id = isset( $id ) ? intval( $id ) : "";
chk_admin_purview( "purview_订单管理" );
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	if ( $part == "list" )
	{
		$oname = isset( $oname ) ? trim( $oname ) : "";
		$goodsid = isset( $goodsid ) ? trim( $goodsid ) : "";
		$userid = isset( $userid ) ? trim( $userid ) : "";
		$catid = isset( $catid ) ? intval( $catid ) : "";
		$where = " WHERE 1";
		$where .= $name != "" ? " AND a.oname LIKE '%".$oname."%'" : "";
		$where .= $userid != "" ? " AND b.userid = '".$userid."'" : "";
		$rows_num = $db->getone( "SELECT COUNT(id) FROM `".$db_mymps."goods_order` AS a LEFT JOIN `{$db_mymps}goods` AS b ON a.goodsid = b.goodsid {$where}" );
		$param = setparam( array( "part", "oname", "userid" ) );
		$goods = page1( "SELECT a.*,b.goodsname,b.userid FROM `".$db_mymps."goods_order` AS a LEFT JOIN `{$db_mymps}goods` AS b ON a.goodsid = b.goodsid {$where} ORDER BY dateline DESC" );
	}
	else if ( $part == "view" )
	{
		if ( empty( $id ) )
		{
			write_msg( "订单编号不能为空！" );
		}
		$view = $db->getrow( "SELECT a.*,b.goodsname FROM `".$db_mymps."goods_order` AS a LEFT JOIN `{$db_mymps}goods` AS b ON a.goodsid = b.goodsid WHERE a.id = '{$id}'" );
	}
	$here = "商品订单管理";
	include( mymps_tpl( "goods_order_".$part ) );
}
else
{
	if ( empty( $selectedids ) )
	{
		write_msg( "您没有选中任何一个订单记录！" );
	}
	$create_in = create_in( $selectedids );
	if ( !$action || !in_array( $action, array( "delall" ) ) )
	{
		write_msg( "您尚未指定处理动作！" );
	}
	if ( $action == "delall" )
	{
		$db->query( "DELETE FROM `".$db_mymps."goods_order` WHERE id ".$create_in );
	}
	write_msg( "操作成功！", $url ? $url : "??part=list" );
	unset( $create_in );
}
unset( $status );
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
