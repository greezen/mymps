<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "coupon" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
$part = $part ? trim( $part ) : "list";
$id = isset( $id ) ? intval( $id ) : "";
chk_admin_purview( "purview_已上传优惠券" );
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	require_once( MYMPS_ROOT."/plugin/coupon/include/functions.php" );
	$here = ( $part == "edit" ? "修改" : "" )."已发布的优惠券";
	if ( $part == "edit" )
	{
		if ( empty( $id ) )
		{
			write_msg( "优惠券编号不能为空！" );
		}
		$edit = $db->getrow( "SELECT * FROM `".$db_mymps."coupon` WHERE id = '{$id}'" );
		if ( empty( $edit['id'] ) )
		{
			write_msg( "该优惠券已不存在！" );
		}
		$edit['des'] = de_textarea_post_change( $edit['des'] );
		$acontent = get_editor( "content", "", $edit['content'], "100%", "300px" );
		$begindate = $edit['begindate'] ? date( "Y-m-d", $edit['begindate'] ) : "";
		$enddate = $edit['enddate'] ? date( "Y-m-d", $edit['enddate'] ) : "";
	}
	else
	{
		$title = isset( $title ) ? trim( $title ) : "";
		$userid = isset( $userid ) ? trim( $userid ) : "";
		$begindate = isset( $begindate ) ? intval( strtotime( $begindate ) ) : "";
		$enddate = isset( $enddate ) ? intval( strtotime( $enddate ) ) : "";
		$cate_id = isset( $cate_id ) ? intval( $cate_id ) : "";
		$cityid = isset( $cityid ) ? intval( $cityid ) : "";
		$status = !$status == "yes" || !$status ? 1 : 0;
		$where = " WHERE 1";
		$where .= $title != "" ? " AND title LIKE '%".$title."%'" : "";
		$where .= $userid != "" ? " AND userid = '".$userid."'" : "";
		$where .= $begindate != "" ? " AND begindate >= '".$begindate."'" : "";
		$where .= $enddate != "" ? " AND enddate <= '".$enddate."'" : "";
		$where .= $cate_id ? " AND cate_id = '".$cate_id."'" : "";
		$where .= $admin_cityid ? " AND cityid = '".$admin_cityid."'" : $cityid ? " AND cityid = '".$cityid."'" : "";
		$where .= " AND status = '".$status."'";
		$coupon = page1( "SELECT * FROM `".$db_mymps."coupon` {$where} ORDER BY dateline DESC" );
		$rows_num = $db->getone( "SELECT COUNT(id) FROM `".$db_mymps."coupon` {$where}" );
		$param = setparam( array( "part", "title", "userid", "begindate", "enddate", "cate_id", "cityid", "status" ) );
		$begindate = !$begindate ? "" : date( "Y-m-d", $begindate );
		$enddate = !$enddate ? "" : date( "Y-m-d", $enddate );
		$status = empty( $status ) ? "no" : "yes";
	}
	include( mymps_tpl( "coupon_".$part ) );
}
else
{
	if ( $part == "list" )
	{
		if ( empty( $selectedids ) )
		{
			write_msg( "您没有选中任何一个优惠券！" );
		}
		$create_in = create_in( $selectedids );
		if ( !$action || !in_array( $action, array( "delall", "grade0", "grade1", "grade2" ) ) )
		{
			echo $action;
			write_msg( "您尚未指定处理动作！" );
		}
		if ( $action == "delall" )
		{
			$query = $db->query( "SELECT * FROM `".$db_mymps."coupon` WHERE id ".$create_in );
			while ( $row = $db->fetchrow( $query ) )
			{
				$delete[$row['id']]['picture'] = $row['picture'];
				$delete[$row['id']]['pre_picture'] = $row['pre_picture'];
			}
			foreach ( $delete as $k => $v )
			{
				@unlink( @MYMPS_ROOT.@$v['picture'] );
				@unlink( @MYMPS_ROOT.@$v['pre_picture'] );
			}
			$db->query( "DELETE FROM `".$db_mymps."coupon` WHERE id ".$create_in );
			unset( $delete );
			unset( $row );
			unset( $query );
			unset( $create_in );
		}
		else
		{
			if ( in_array( $action, array( "grade0", "grade1", "grade2" ) ) )
			{
				switch ( $action )
				{
					case "grade0" :
					$action = 0;
					break;
					case "grade1" :
					$action = 1;
					break;
					case "grade2" :
					$action = 2;
				}
				$db->query( "UPDATE `".$db_mymps."coupon` SET grade = '{$action}' WHERE id ".$create_in );
				unset( $create_in );
			}
		}
	}
	else if ( $part == "edit" )
	{
		if ( empty( $id ) )
		{
			write_msg( "优惠券编号不能为空！" );
		}
		if ( empty( $title ) )
		{
			write_msg( "优惠券标题不能为空！" );
		}
		$name_file = "coupon_image";
		$begindate = intval( strtotime( $begindate ) );
		$enddate = intval( strtotime( $enddate ) );
		$des = textarea_post_change( $des );
		if ( $_FILES[$name_file]['name'] )
		{
			require_once( MYMPS_INC."/upfile.fun.php" );
			$destination = "/coupon/".date( "Ym" )."/";
			$mymps_image = start_upload( $name_file, $destination, 0, $mymps_mymps['cfg_coupon_limit']['width'], $mymps_mymps['cfg_coupon_limit']['height'], $picture, $pre_picture );
			$picture = $mymps_image[0];
			$pre_picture = $mymps_image[1];
			unset( $mymps_image );
		}
		unset( $name_file );
		$db->query( "UPDATE `".$db_mymps."coupon` SET title = '{$title}',des = '{$des}',content = '{$content}',cate_id = '{$cate_id}',areaid='{$areaid}',picture='{$picture}',pre_picture='{$pre_picture}',begindate = '{$begindate}',enddate = '{$enddate}',dateline = '{$timestamp}' , ctype = '{$ctype}' , sup = '{$sup}' , status = '{$status}',grade='{$grade}' WHERE id = '{$id}'" );
		$url = "?part=edit&id=".$id;
	}
	write_msg( "操作成功！", $url ? $url : "?part=list" );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$mymps_global = $db = $db_mymps = $part = NULL;

?>
