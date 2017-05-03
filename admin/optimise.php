<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "optimise" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
$step = array( "1" => "删除过期分类信息", "2" => "删除待审分类信息", "3" => "只保留最近两个月的会员登录记录", "4" => "删除无金币消费的会员消费记录", "5" => "删除支付失败的会员支付记录", "6" => "删除QQ登录的冗余会员帐号", "7" => "只保留".$mymps_mymps['cfg_record_save']."条管理员登录记录", "8" => "只保留".$mymps_mymps['cfg_record_save']."条管理员操作记录", "9" => "删除会员已读短消息", "10" => "只保留一个月内的邮件发送记录", "11" => "Mysql数据库表优化" );
$here = "Mymps系统优化";
if ( $action == "dopost" )
{
	$steporder = $steporder ? mhtmlspecialchars( $steporder ) : array( );
	foreach ( $steporder as $k => $v )
	{
		$next .= $v == 1 ? $k."," : "";
	}
	$next = $next ? $next : ",";
}
else
{
	if ( $next && !intval( $next ) )
	{
		$finished = 1;
	}
}
include( mymps_tpl( CURSCRIPT ) );
if ( !empty( $next ) )
{
	$next = substr( $next, 0, -1 );
	$nextarr = explode( ",", $next );
	$nextid = $nextarr[0];
	$last .= $nextid.",";
	if ( !$nextarr[0] )
	{
		$finished = 1;
	}
	unset( $nextarr[0] );
	$next = implode( ",", $nextarr );
	$next .= ",";
	switch ( $nextid )
	{
		case "1" :
		$where = " WHERE endtime < '".$timestamp."' AND endtime != '0'";
		$query = $db->query( "SELECT id FROM ".$db_mymps."information {$where}" );
		while ( $post = $db->fetchrow( $query ) )
		{
			$ids .= $post['id'].",";
		}
		$selectedids = substr( $ids, 0, -1 );
		if ( $selectedids && $selectedids!=',')
		{
			$query = $db->query( "SELECT * FROM `".$db_mymps."information` WHERE id IN ({$selectedids})" );
			while ( $row = $db->fetchrow( $query ) )
			{
				@unlink( @MYMPS_ROOT.@$row['html_path'] );
			}
			mymps_delete( "information", "WHERE id IN(".$selectedids.")" );
			mymps_delete( "info_extra", "WHERE infoid IN (".$selectedids.")" );
			$query = $db->query( "SELECT * FROM `".$db_mymps."info_img` WHERE infoid IN ({$selectedids})" );
			while ( $row = $db->fetchrow( $query ) )
			{
				@unlink( @MYMPS_ROOT.@$row['imgpath'] );
				@unlink( @MYMPS_ROOT.@$row['pre_imgpath'] );
			}
			mymps_delete( "info_img", "WHERE infoid IN (".$selectedids.")" );
			mymps_delete( "comment", "WHERE typeid IN (".$selectedids.") AND type = 'information'" );
		}
		break;
		case "2" :
		$where = " WHERE info_level = '0'";
		$query = $db->query( "SELECT id FROM ".$db_mymps."information {$where}" );
		while ( $post = $db->fetchrow( $query ) )
		{
			$ids .= $post['id'].",";
		}
		$selectedids = substr( $ids, 0, -1 );
		if ( $selectedids && $selectedids!=',')
		{
			$query = $db->query( "SELECT * FROM `".$db_mymps."information` WHERE id IN ({$selectedids})" );
			while ( $row = $db->fetchrow( $query ) )
			{
				@unlink( @MYMPS_ROOT.@$row['html_path'] );
			}
			mymps_delete( "information", "WHERE id IN(".$selectedids.")" );
			mymps_delete( "info_extra", "WHERE infoid IN (".$selectedids.")" );
			$query = $db->query( "SELECT * FROM `".$db_mymps."info_img` WHERE infoid IN ({$selectedids})" );
			while ( $row = $db->fetchrow( $query ) )
			{
				@unlink( @MYMPS_ROOT.@$row['imgpath'] );
				@unlink( @MYMPS_ROOT.@$row['pre_imgpath'] );
			}
			mymps_delete( "info_img", "WHERE infoid IN (".$selectedids.")" );
			mymps_delete( "comment", "WHERE typeid IN (".$selectedids.") AND type = 'information'" );
		}
		break;
		case "3" :
		$monthdate = strtotime( "-2 month" );
		$db->query( "DELETE FROM `".$db_mymps."member_record_login` WHERE pubdate < '{$monthdate}'" );
		break;
		case "4" :
		$db->query( "DELETE FROM `".$db_mymps."member_record_use` WHERE paycost = '<font color=red>扣除金币 0 </font>'" );
		break;
		case "5" :
		$db->query( "DELETE FROM `".$db_mymps."payrecord` WHERE paybz = '等待支付'" );
		break;
		case "6" :
		$db->query( "DELETE FROM `".$db_mymps."member` WHERE openid != '' AND userid != '' AND userpwd = ''" );
		break;
		case "7" :
		if ( $mymps_mymps['cfg_record_save'] )
		{
			$mymps_mymps['cfg_record_save'] = 100;
		}
		$total_count = mymps_count( "admin_record_login" );
		if ( $mymps_mymps['cfg_record_save'] <= $total_count )
		{
			$delrecord = $db->getall( "SELECT id FROM `".$db_mymps."admin_record_login` ORDER BY ID DESC LIMIT 1,".$mymps_mymps['cfg_record_save'] );
			foreach ( $delrecord as $k => $value )
			{
				$id .= $value[id].",";
			}
			$id = substr( $id, 0, -1 );
			mymps_delete( "admin_record_login", "WHERE id NOT IN (".$id.")" );
		}
		break;
		case "8" :
		if ( $mymps_mymps['cfg_record_save'] )
		{
			$mymps_mymps['cfg_record_save'] = 100;
		}
		$total_count = mymps_count( "admin_record_action" );
		if ( $mymps_mymps['cfg_record_save'] <= $total_count )
		{
			$delrecord = $db->getall( "SELECT id FROM `".$db_mymps."admin_record_action` ORDER BY ID DESC LIMIT 1,".$mymps_mymps['cfg_record_save'] );
			foreach ( $delrecord as $k => $value )
			{
				$id .= $value[id].",";
			}
			$id = substr( $id, 0, -1 );
			mymps_delete( "admin_record_action", "WHERE id NOT IN (".$id.")" );
		}
		break;
		case "9" :
		$db->query( "DELETE FROM `".$db_mymps."member_pm` WHERE if_read = '1'" );
		break;
		case "10" :
		$monthdate = strtotime( "-1 month" );
		$db->query( "DELETE FROM `".$db_mymps."mail_sendlist` WHERE last_send < '{$monthdate}' " );
		break;
		case "11" :
		$query = $db->query( "SHOW TABLE STATUS LIKE '".$db_mymps."%'", "SILENT" );
		while ( $table = $db->fetchrow( $query ) )
		{
			$db->query( "OPTIMIZE TABLE ".$table['Name'] );
		}
		break;
	}
	if ( $finished != 1 )
	{
		echo mymps_goto( "?last=".$last."&next=".$next );
		ob_flush( );
		flush( );
		sleep( 1 );
	}
	else
	{
		ob_end_flush( );
	}
}
if ( is_object( $db ) )
{
	$db->close( );
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
