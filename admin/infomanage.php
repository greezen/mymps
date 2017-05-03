<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "infomanage" );
define( "IN_AJAX", true );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !submit_check( CURSCRIPT."_submit" ) && $action != "viewresult" )
{
	chk_admin_purview( "purview_批量管理" );
	$here = "批量管理";
	include( mymps_tpl( CURSCRIPT ) );
}
else
{
	if ( $step != "submit" && !$catid && !$userid && !$cityid && !$starttime && !$endtime && !$ip && !$keywords && !$ismember && !istimed )
	{
		write_msg( "您没有指定任何搜索条件，无法完成此次操作！" );
	}
	$where = " WHERE 1";
	$where .= $catid ? " AND ".get_children( $catid, "a.catid" ) : "";
	$where .= $areaid ? " AND a.areaid IN (".get_area_children( $areaid ).")" : "";
	$where .= $tel ? " AND a.tel LIKE '%".$tel."%'" : "";
	$where .= " AND (a.endtime > '".$timestamp."' OR endtime = '0')";
	$where .= "";
	if ( trim( $userid ) )
	{
		$where .= " AND a.userid IN ('".str_replace( ",", "','", str_replace( " ", "", $userid ) )."')";
	}
	$starttime = 0;
	$where .= "";
	$where .= "";
	$endtime = 0;
	$where .= "";
	if ( $keywords != "" )
	{
		$keyword = $keywords;
		$sqlkeywords = "";
		$or = "";
		$keywords = explode( ",", str_replace( " ", "", $keywords ) );
		$i = 0;
		for ( ;	$i < count( $keywords );	++$i	)
		{
			if ( preg_match( "/\\{(\\d+)\\}/", $keywords[$i] ) )
			{
				$keywords[$i] = preg_replace( "/\\\\{(\\d+)\\\\}/", ".{0,\\1}", preg_quote( $keywords[$i], "/" ) );
				$sqlkeywords .= " ".$or." a.title REGEXP '".$keywords[$i]."' OR a.content REGEXP '".$keywords[$i]."'";
			}
			else
			{
				$sqlkeywords .= " ".$or." a.title LIKE '%".$keywords[$i]."%' OR a.content LIKE '%".$keywords[$i]."%'";
			}
			$or = "OR";
		}
		$where .= " AND (".$sqlkeywords.")";
		$keywords = $keyword;
	}
	$where .= "";
	if ( $lengthlimit != "" )
	{
		$lengthlimit = intval( $lengthlimit );
		$where .= " AND a.LENGTH(content) < ".$lengthlimit;
	}
	if ( $detail == "yes" )
	{
		require_once( MYMPS_DATA."/info.level.inc.php" );
		$here = "批量主题管理";
		$starttime = "";
		$endtime = "";
		$rows_num = $db->getone( "SELECT COUNT(a.id) FROM `".$db_mymps."information` AS a {$where}" );
		$param = setparam( array( "part", "detail", "action", "istimed", "ismember", "userid", "starttime", "endtime", "catid", "cityid", "ip", "keywords", "lengthlimit", "info_level", "tel" ) );
		$information = page1( "SELECT a.*,b.dir_typename FROM `".$db_mymps."information` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.catid=b.catid {$where} ORDER BY a.id DESC", 10 );
		include( mymps_tpl( CURSCRIPT ) );
	}
	else
	{
		if ( empty( $part ) )
		{
			write_msg( "您没有选择要进行的操作，无法完成此次操作！" );
		}
		if ( $step == "submit" )
		{
			$count = count( $optionids );
			if ( empty( $count ) )
			{
				write_msg( "您没有选中需要执行操作的信息记录！" );
			}
			foreach ( $optionids as $key => $val )
			{
				$ids .= $val.",";
			}
			$selectedids = substr( $ids, 0, -1 );
		}
		else if ( $step != "submit" )
		{
			$count = $db->getone( "SELECT count(id) FROM `".$db_mymps."information` {$where}" );
			$query = $db->query( "SELECT id FROM ".$db_mymps."information {$where}" );
			while ( $post = $db->fetchrow( $query ) )
			{
				$ids .= $post['id'].",";
			}
			$selectedids = substr( $ids, 0, -1 );
		}
		else
		{
			write_msg( "您没有选择要进行操作的信息记录！" );
		}
		$starttime = "";
		$endtime = "";
		if ( $selectedids == "," )
		{
			write_msg( "没有找到符合搜索条件的相关分类信息主题！" );
		}
		switch ( $part )
		{
			case "delinfo" :
			$query = $db->query( "SELECT a.*,b.modid FROM `".$db_mymps."information` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.catid = b.catid WHERE a.id IN ({$selectedids})" );
			while ( $row = $db->fetchrow( $query ) )
			{
				if ( 1 < $row['modid'] )
				{
					@unlink( MYMPS_ROOT.@$row['html_path'] );
				}
			}
			mymps_delete( "information", "WHERE id IN(".$selectedids.")" );
			$query = $db->query( "SELECT * FROM `".$db_mymps."info_img` WHERE infoid IN ({$selectedids})" );
			while ( $row = $db->fetchrow( $query ) )
			{
				@unlink( @MYMPS_ROOT.@$row['imgpath'] );
				@unlink( @MYMPS_ROOT.@$row['pre_imgpath'] );
			}
			mymps_delete( "info_img", "WHERE infoid IN (".$selectedids.")" );
			mymps_delete( "comment", "WHERE typeid IN (".$selectedids.") AND type = 'information'" );
			$act = "删除信息";
			break;
			case "delcomment" :
			$count = mymps_count( "info_comment", "WHERE infoid IN (".$selectedids.")" );
			mymps_delete( "info_comment", "WHERE infoid IN (".$selectedids.")" );
			$act = "删除信息评论";
			break;
			case "delattach" :
			$query = $db->query( "SELECT * FROM `".$db_mymps."info_img` WHERE infoid IN ({$selectedids})" );
			$count = 0;
			while ( $row = $db->fetchrow( $query ) )
			{
				@unlink( @MYMPS_ROOT.@$row['imgpath'] );
				@unlink( @MYMPS_ROOT.@$row['pre_imgpath'] );
				++$count;
			}
			mymps_delete( "info_img", "WHERE infoid IN (".$selectedids.")" );
			$db->query( "UPDATE `".$db_mymps."information` SET img_path = '' WHERE id IN ({$selectedids})" );
			$act = "删除信息图片";
			break;
			case "refresh" :
			foreach ( explode( ",", $selectedids ) as $kids => $vids )
			{
				$activetime = $db->getone( "SELECT activetime FROM `".$db_mymps."information` WHERE id = '{$vids}'" );
				$endtime = $activetime * 3600 * 24 + $timestamp;
				$db->query( "UPDATE `".$db_mymps."information` SET begintime = '{$timestamp}',endtime='{$endtime}' WHERE id = '{$vids}'" );
			}
			$act = "刷新信息";
			break;
			case "level0" :
			$db->query( "UPDATE `".$db_mymps."information` SET info_level = '0' WHERE id IN ({$selectedids})" );
			$act = "设为待审信息";
			break;
			case "level1" :
			$db->query( "UPDATE `".$db_mymps."information` SET info_level = '1' WHERE id IN ({$selectedids})" );
			$act = "设为正常信息";
			break;
			case "level2" :
			$db->query( "UPDATE `".$db_mymps."information` SET info_level = '2' WHERE id IN ({$selectedids})" );
			$act = "设置推荐信息";
			break;
			case "ifred" :
			$db->query( "UPDATE `".$db_mymps."information` SET ifred = '1' WHERE id IN ({$selectedids})" );
			$act = "信息标题套红";
			break;
			case "ifbold" :
			$db->query( "UPDATE `".$db_mymps."information` SET ifbold = '1' WHERE id IN ({$selectedids})" );
			$act = "信息标题加粗";
		}
	}
	if ( !empty( $act ) )
	{
		write_msg( "共 ".$act." ".$count." 条", $return_url, "write_record" );
	}
}
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = $where = $selectedids = $step = NULL;
?>
