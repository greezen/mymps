<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "comment" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
$part = $part ? trim( $part ) : "information";
$action = $action ? trim( $action ) : "list";
$id = isset( $id ) ? $id : "";
if ( in_array( $part, array( "information", "news", "coupon", "group" ) ) )
{
	$part = "information";
}
if ( $part == "information" )
{
	chk_admin_purview( "purview_信息评论" );
}
else if ( $part == "news" )
{
	chk_admin_purview( "purview_新闻评论" );
}
else if ( $part == "coupon" )
{
	chk_admin_purview( "purview_优惠券评论" );
}
else if ( $part == "group" )
{
	chk_admin_purview( "purview_团购评论" );
}
if ( $action == "del" )
{
	if ( empty( $id ) )
	{
		write_msg( "无效的评论参数提交！" );
	}
	$db->query( "DELETE FROM `".$db_mymps."comment` WHERE id = '{$id}' AND type = '{$part}'" );
	write_msg( "成功删除编号为".$id."的网友评论", "comment.php?part=".$part, "Mymps" );
}
else if ( $action == "delall" )
{
	if ( !is_array( $id ) )
	{
		write_msg( "您没有选中任何记录！" );
	}
	$db->query( "DELETE FROM `".$db_mymps."comment` WHERE id ".create_in( $id ).( " AND type = '".$part."'" ) );
	write_msg( "批量删除网友评论成功！", "comment.php?part=".$part, "write_record" );
}
else if ( $action == "level0" )
{
	if ( !is_array( $id ) )
	{
		write_msg( "您没有选中任何记录！" );
	}
	foreach ( $id as $k => $v )
	{
		$db->query( "UPDATE `".$db_mymps."comment` SET comment_level = 0 WHERE id = '{$v}' AND type = '{$part}'" );
	}
	write_msg( "更新评论状态为 待审状态 操作成功！", "comment.php?part=".$part, "RECORD" );
}
else if ( $action == "level1" )
{
	if ( !is_array( $id ) )
	{
		write_msg( "您没有选中任何记录！" );
	}
	foreach ( $id as $k => $v )
	{
		$db->query( "UPDATE `".$db_mymps."comment` SET comment_level = 1 WHERE id = '{$v}' AND type = '{$part}'" );
	}
	write_msg( "更新评论状态为 正常状态 操作成功！", "comment.php?part=".$part, "RECORD" );
}
else if ( $action == "list" )
{
	$admindir = getcwdol( );
	$comment_level = isset( $comment_level ) ? intval( $comment_level ) : "";
	require_once( MYMPS_DATA."/info.level.inc.php" );
	$part_arr = array( "information" => "分类信息评论", "news" => "新闻评论", "group" => "团购评论", "coupon" => "优惠券评论" );
	$here = $part_arr[$part];
	unset( $part_arr );
	$where = " WHERE type = '".$part."' ";
	$where .= $keywords != "" ? " AND a.content LIKE '%".$keywords."%'" : "";
	$where .= $commment_level != "" ? " AND a.comment_level = '0'" : "";
	$sql = "SELECT a.id,a.userid,a.content,a.pubtime,a.ip,a.typeid,a.type,b.title,a.comment_level FROM `".$db_mymps."comment` AS a LEFT JOIN `{$db_mymps}".$part.( "` AS b ON a.typeid = b.id ".$where." ORDER BY a.pubtime DESC" );
	$rows_num = $db->getone( "SELECT COUNT(*) FROM `".$db_mymps."comment` AS a {$where}" );
	$param = setparam( array( "part", "keywords", "comment_level" ) );
	$comment = array( );
	foreach ( page1( $sql ) as $k => $row )
	{
		$arr['id'] = $row['id'];
		$arr['content'] = $row['content'];
		switch ( $part )
		{
			case "information" :
			$arr['title'] = "<a href=../information.php?id=".$row[typeid]." target=_blank>".$row[title]."</a>";
			break;
			case "news" :
			$arr['title'] = "<a href=../news.php?id=".$row[typeid]." target=_blank>".$row[title]."</a>";
			break;
			case "group" :
			$arr['title'] = "<a href=../group.php?id=".$row[infoid]." target=_blank>".$row[title]."</a>";
			break;
			case "coupon" :
			$arr['title'] = "<a href=../coupon.php?id=".$row[infoid]." target=_blank>".$row[title]."</a>";
		}
		$arr['userid'] = $row[userid] ? "<a  href=\"javascript:void(0);\" onclick=\"\r\nsetbg('Mymps会员中心',400,110,'../box.php?part=member&userid=".$row['userid']."&admindir={$admindir}')\">".$row[userid]."</a>" : $row[ip];
		$arr['pubtime'] = gettime( $row['pubtime'] );
		$arr['ip'] = $row['ip'];
		$arr['comment_level'] = $information_level[$row[comment_level]];
		$comment[] = $arr;
	}
	include( mymps_tpl( "comment" ) );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
