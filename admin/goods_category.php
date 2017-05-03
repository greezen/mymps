<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "goods_category" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
require_once( dirname( __FILE__ )."/include/color.inc.php" );
require_once( dirname( __FILE__ )."/include/ifview.inc.php" );
@require_once( MYMPS_ROOT."/plugin/goods/include/functions.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
$part = $part ? $part : "list";
$cat_color = $color;
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	if ( $part == "list" )
	{
		chk_admin_purview( "purview_商品分类" );
		$f_cat = goods_cat_list( "category", 0, 0, false );
		$here = "商品分类列表";
		include( mymps_tpl( "goods_category_list" ) );
	}
	else if ( $part == "edit" )
	{
		include( MYMPS_DATA."/category_tpl.inc.php" );
		$cat = $db->getrow( "SELECT * FROM ".$db_mymps."goods_category WHERE catid = '{$catid}'" );
		$here = "编辑商品分类";
		include( mymps_tpl( "goods_category_edit" ) );
	}
	else if ( $part == "add" )
	{
		include( MYMPS_DATA."/category_tpl.inc.php" );
		$maxorder = $db->getone( "SELECT MAX(catorder) FROM ".$db_mymps."goods_category" );
		$maxorder += 1;
		$here = "添加商品分类";
		include( mymps_tpl( "goods_category_add" ) );
	}
	else if ( $part == "del" )
	{
		if ( empty( $catid ) )
		{
            write_msg( "没有选择记录" );
		}
		mymps_delete( "goods_category", "WHERE catid = '".$catid."'" );
		mymps_delete( "goods_category", "WHERE parentid = '".$catid."'" );
		mymps_delete( "goods", "WHERE catid IN (".mymps_get_goods_children( $catid ).")" );
		clear_cache_files( "goods_category_option_static" );
		clear_cache_files( "goods_category_pid_releate" );
		clear_cache_files( "goods_category_tree" );
		write_msg( "删除商品分类 ".$catid." 成功", "goods_category.php?part=list", "Mymps" );
	}
}
else if ( $part == "list" )
{
	if ( is_array( $catorder ) )
	{
		foreach ( $catorder as $key => $value )
		{
			$db->query( "UPDATE `".$db_mymps."goods_category` SET catorder = '{$value}' WHERE catid = ".$key );
		}
	}
	if ( is_array( $if_viewids ) )
	{
		$db->query( "UPDATE `".$db_mymps."goods_category` SET if_view = '1' " );
		foreach ( $if_viewids as $key )
		{
			$db->query( "UPDATE `".$db_mymps."goods_category` SET if_view = '2' WHERE catid = ".$key );
		}
	}
	else
	{
		$db->query( "UPDATE `".$db_mymps."goods_category` SET if_view = '1' " );
	}
	foreach ( array( "option_static", "pid_releate", "tree" ) as $range )
	{
		clear_cache_files( "goods_category_".$range );
	}
	write_msg( "商品分类更新成功！", "?part=list", "record" );
}
else if ( $part == "add" )
{
	$catname = explode( "|", trim( $catname ) );
	$template = empty( $template ) ? "list" : trim( $template );
	if ( empty( $catname ) || !is_array( $catname ) )
	{
        write_msg( "请填写商品分类名称" );
	}
	if ( empty( $catorder ) )
	{
		$sql = "SELECT MAX(catorder) FROM ".$db_mymps."goods_category";
		$maxorder = $db->getone( $sql );
		$catorder += 1;
	}
	if ( is_array( $catname ) )
	{
		foreach ( $catname as $key => $value )
		{
			$value = trim( $value );
			++$catorder;
			$len = strlen( $value );
			if ( 30 < $len )
			{
			}
			$db->query( "INSERT INTO ".$db_mymps."goods_category (catname,if_view,title,keywords,description,parentid,catorder) VALUES ('{$value}','{$isview}','{$value}','{$value}','{$value}','{$parentid}','{$catorder}')" );
		}
		foreach ( array( "option_static", "pid_releate", "tree" ) as $range )
		{
			clear_cache_files( "goods_category_".$range );
		}
		$nav_path = "商品分类管理 &raquo 增加商品分类";
		$message = "成功增加商品分类";
		$after_action = "<a href='?part=add'><u>继续增加商品分类</u></a>\r\n\t\t\t&nbsp;&nbsp;<a href='?part=list'><u>已增加商品分类管理</u></a>";
		show_message( $nav_path, $message, $after_action );
	}
	else
	{
		write_msg( "商品分类分类添加失败，请按格式填写" );
	}
}
else if ( $part == "edit" )
{
	$template = empty( $template ) ? "list" : trim( $template );
	if ( empty( $catname ) )
	{
        write_msg( "请填写商品分类名称" );
	}
	if ( $catid == $parentid )
	{
        write_msg( "隶属商品分类不能为自己！" );
	}
	$len = strlen( $catname );
	if (2>$len || 30 < $len )
	{
        write_msg( "商品分类名必须在2个至30个字符之间" );
	}
	$sql = "UPDATE ".$db_mymps."goods_category SET catname='{$catname}',if_view = '{$isview}',color='{$fontcolor}',title='{$title}',keywords='{$keywords}',description='{$description}',parentid='{$parentid}',catorder='{$catorder}' WHERE catid = '{$catid}'";
	$res = $db->query( $sql );
	foreach ( array( "option_static", "pid_releate", "tree" ) as $range )
	{
		clear_cache_files( "goods_category_".$range );
	}
	$nav_path = "商品分类管理 &raquo 编辑商品分类";
	$message = "成功编辑商品分类 ".$catname;
	$after_action = "<a href='?part=add'><u>继续增加商品分类</u></a>\r\n\t\t&nbsp;&nbsp;<a href='?part=edit&catid=".$catid."'><u>重新编辑该商品分类</u></a>&nbsp;&nbsp;<a href='?part=list#{$catid}'><u>已增加商品分类管理</u></a>";
	show_message( $nav_path, $message, $after_action );
}
if ( is_object( $db ) )
{
    $db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
