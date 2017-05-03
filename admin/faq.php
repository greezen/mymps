<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "faq" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
$do = $do ? $do : "faq";
switch ( $do )
{
	case "faq" :
	$part = $part ? $part : "all";
	if ( $part == "add" )
	{
		chk_admin_purview( "purview_发布帮助主题" );
		$acontent = get_editor( "content", "Default" );
		$here = "帮助主题发布";
		$faq_type = $db->getall( "SELECT id,typename FROM `".$db_mymps."faq_type`" );
		include( mymps_tpl( CURSCRIPT."_add" ) );
		break;
	}
	else if ( $part == "insert" )
	{
		$db->query( "INSERT INTO `".$db_mymps."faq` (id,typeid,title,content) Values ('','{$typeid}','{$title}','{$content}')" );
		$inid = $db->insert_id( );
		write_msg( "恭喜您，问题帮助发布成功！<br /><br /><a href='".$db_mymps_global['SiteUrl']."/public/about.php?part=faq&id={$inid}' target=_blank>点此查看</a> | \r\n\t\t\t<a href='faq.php?part=edit&id={$inid}'>重新编辑</a> |  \r\n\t\t\t<a href='faq.php?part=all'>返回帮助列表</a>\t\t\t\r\n\t\t\t<br /><br />\r\n\t\t\t<a href='faq.php?part=add'>>>我要继续发布帮助</a>", "olmsg" );
		clear_cache_files( "cache" );
		show_msg( $msgs, "问题帮助 <b>".$title."</b> 发布成功" );
		break;
	}
	else if ( $part == "edit" )
	{
		if ( trim( $action ) == "dopost" )
		{
			$update = $db->query( "UPDATE `".$db_mymps."faq` SET title='{$title}',content='{$content}',typeid='{$typeid}' WHERE id = '{$id}'" );
			if ( $update )
			{
				write_msg( "恭喜您，问题帮助修改成功！<br /><br /><a href='".$db_mymps_global['SiteUrl']."/public/about.php?part=faq&id={$id}' target=_blank>点此查看</a> | \r\n\t\t\t\t\t<a href='faq.php?part=edit&id={$id}'>重新编辑</a> |  \r\n\t\t\t\t\t<a href='faq.php?part=all'>返回帮助列表</a>\t\t\t\r\n\t\t\t\t\t<br /><br />\r\n\t\t\t\t\t<a href='faq.php?part=add'>>>我要继续发布帮助</a>", "olmsg" );
				clear_cache_files( "faq" );
				break;
			}
		}
		else
		{
			$id = intval( $id );
			$here = "修改问题帮助";
			$faq_type = $db->getall( "SELECT id,typename FROM `".$db_mymps."faq_type`" );
			$edit = $db->getrow( "SELECT * FROM ".$db_mymps."faq WHERE id = '{$id}'" );
			$acontent = get_editor( "content", "Normal", $edit['content'] );
			include( mymps_tpl( CURSCRIPT."_edit" ) );
			break;
		}
	}
	else if ( $part == "delete" )
	{
		if ( empty( $id ) )
		{
			write_msg( "没有选择记录" );
			break;
		}
		else
		{
			mymps_delete( "faq", "WHERE id = '".$id."'" );
			clear_cache_files( "faq" );
			write_msg( "删除帮助 ".$id." 成功", $url, "mymps" );
			break;
		}
	}
	else if ( $part == "all" )
	{
		chk_admin_purview( "purview_问题帮助" );
		$faq_type = $db->getall( "SELECT id,typename FROM `".$db_mymps."faq_type`" );
		$page = empty( $page ) ? "1" : intval( $page );
		$where = "WHERE a.typeid like '%".$typeid."%'";
		$sql = "SELECT a.id,a.title,b.typename,a.typeid FROM ".$db_mymps."faq AS a LEFT JOIN {$db_mymps}faq_type AS b ON a.typeid = b.id {$where} ORDER BY a.id DESC";
		$rows_num = $db->getone( "SELECT COUNT(*) FROM ".$db_mymps."faq AS a {$where}" );
		$param = setparam( array( "typeid" ) );
		$faq = array( );
		foreach ( page1( $sql ) as $k => $row )
		{
			$arr['id'] = $row['id'];
			$arr['title'] = $row['title'];
			$arr['typeid'] = $row['typeid'];
			$arr['typename'] = $row['typename'];
			$faq[] = $arr;
		}
		$here = "帮助主题";
		include( mymps_tpl( CURSCRIPT."_all" ) );
		break;
	}
	else if ( $part == "delall" )
	{
		$id = mymps_del_all( "faq", $_POST['id'] );
		clear_cache_files( "faq" );
		write_msg( "删除帮助 ".$id." 成功", $url, "mymps_record" );
		break;
	}
	case "type" :
	$part = $part ? $part : "list";
	$here = "<b>帮助中心类别管理</b>";
	if ( $part == "list" )
	{
		$links = $db->getall( "SELECT * FROM ".$db_mymps."faq_type ORDER BY id Asc" );
		include( mymps_tpl( "faq_type" ) );
	}
	else if ( $part == "insert" )
	{
		$sql = "Insert Into `".$db_mymps."faq_type`(id,typename)\r\n\t\t\t\tValues('','{$typename}');";
		$res = $db->query( $sql );
		clear_cache_files( "faq" );
		write_msg( "添加帮助分类 ".$typename." 成功", "faq.php?do=type", "mymps" );
	}
	else if ( $part == "update" )
	{
		$sql = "UPDATE ".$db_mymps."faq_type SET typename='{$typename}' WHERE id = '{$id}'";
		$res = $db->query( $sql );
		clear_cache_files( "faq" );
		write_msg( "分类 ".$typename." 更改成功", "faq.php?do=type" );
	}
	else if ( $part == "delete" )
	{
		if ( empty( $id ) )
		{
			write_msg( "没有选择记录" );
		}
		else
		{
			$url = "?do=type";
			$db->query( "DELETE FROM `".$db_mymps."faq` WHERE typeid = ".$id."" );
			mymps_delete( CURSCRIPT."_type", "WHERE id='".$id."'" );
			clear_cache_files( "faq" );
			write_msg( "删除分类 ".$id." 成功", $url, "mymps" );
		}
	}
}
if ( is_object( $db ) )
{
    $db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
