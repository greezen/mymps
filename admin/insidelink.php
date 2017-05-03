<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "insidelink" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
$part = isset( $part ) ? $part : "list";
$id = isset( $id ) ? intval( $id ) : 0;
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	$here = "文字内链设置";
	chk_admin_purview( "purview_文字内链设置" );
	$insidelink_forward = array( "information" => "分类信息", "news" => "新闻资讯", "goods" => "商品", "group" => "团购", "coupon" => "优惠券" );
	$rows_num = mymps_count( "insidelink" );
	$param = setparam( array( "part" ) );
	$insidelink = page1( "SELECT * FROM `".$db_mymps."insidelink` ORDER BY id DESC" );
	$settings = $db->getone( "SELECT value FROM `".$db_mymps."config` WHERE type = 'insidelink' AND description = 'insidelink'" );
	$settings = $charset == "gb2312" ? unserialize( $settings ) : utf8_unserialize( $settings );
	include( mymps_tpl( CURSCRIPT ) );
}
else
{
	if ( is_array( $settings ) )
	{
		$db->query( "DELETE FROM `".$db_mymps."config` WHERE type = 'insidelink'" );
		$value = serialize( $settings );
		$db->query( "INSERT INTO `".$db_mymps."config` (type,description,value)VALUES('insidelink','insidelink','{$value}')" );
	}
	if ( is_array( $word ) )
	{
		foreach ( $word as $key => $val )
		{
			$words = trim( $val );
			$urls = trim( $url[$key] );
			if ( $words )
			{
				$db->query( "UPDATE `".$db_mymps."insidelink` SET url='{$urls}', word='{$words}' WHERE id='{$key}'" );
			}
		}
	}
	if ( is_array( $newword ) && is_array( $newurl ) )
	{
		foreach ( $newword as $key => $val )
		{
			$word = trim( $val );
			$url = trim( $newurl[$key] );
			if ( $word )
			{
				$db->query( "INSERT INTO\t`".$db_mymps."insidelink` (word,url) VALUES ('{$word}', '{$url}')" );
			}
		}
	}
	if ( is_array( $delete ) )
	{
		$db->query( "DELETE FROM `".$db_mymps."insidelink` WHERE ".create_in( $delete, "id" ) );
	}
	write_insidelink_cache( );
	unset( $word );
	unset( $url );
	unset( $words );
	unset( $urls );
	unset( $newword );
	unset( $newurl );
	write_msg( "内链文字设置更新成功！", "insidelink.php", "write_record" );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
