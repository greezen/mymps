<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function get_docuarr_options( $arrid = "" )
{
	global $docu_arr;
	foreach ( $docu_arr as $key => $value )
	{
		$mymps .= "<option value=".$key."";
		$mymps .= $arrid == $key ? " style = \"background-color:#6EB00C;color:white\" selected>" : ">";
		$mymps .= $value."</option>";
	}
	return $mymps;
}

define( "CURSCRIPT", "document" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
require_once( dirname( __FILE__ )."/include/ifview.inc.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
$docu_arr = array( "1" => "文章", "2" => "图文" );
$do = $do ? $do : "type";
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	if ( $do == "type" )
	{
		chk_admin_purview( "purview_会员文档" );
		$here = "会员文档模型管理";
		if ( $part == "edit" )
		{
			$typeid = intval( $typeid );
			$edit = $db->getrow( "SELECT * FROM `".$db_mymps."member_docutype` WHERE typeid = ".$typeid );
			include( mymps_tpl( CURSCRIPT."_".$do."_".$part ) );
			exit( );
		}
		$notice = "<li>如果你原有的模型已正式投入使用，请谨慎删除原模型</li>";
		$docu = $db->getall( "SELECT * FROM `".$db_mymps."member_docutype` ORDER BY displayorder ASC" );
	}
	else
	{
		chk_admin_purview( "purview_会员文档" );
		$here = "会员文档管理";
		$doc_level = array( "0" => "待审", "1" => "正常" );
		$rows_num = $db->getone( "SELECT COUNT(*) FROM `".$db_mymps."member_docu`" );
		$param = setparam( array( "do", "part" ) );
		$docu = page1( "SELECT * FROM `".$db_mymps."member_docu` ORDER BY pubtime DESC" );
	}
	include( $do == "document" ? mymps_tpl( CURSCRIPT ) : mymps_tpl( CURSCRIPT."_type" ) );
}
else
{
	if ( $part == "edit" )
	{
		$forward_url = "?part=edit&typeid=".$typeid;
		if ( empty( $typename ) )
		{
			write_msg( "请填写完整模型相关信息！" );
		}
		$db->query( "UPDATE `".$db_mymps."member_docutype` SET typename='{$typename}',arrid='{$arrid}',ifview='{$ifview}',displayorder='{$displayorder}' WHERE typeid = '{$typeid}'" );
		$i = 1;
	}
	else
	{
		if ( is_array( $delids ) )
		{
			$i = 1;
			foreach ( $delids as $kids => $vids )
			{
				if ( $do == "type" )
				{
					mymps_delete( "member_docutype", "WHERE typeid = ".$vids );
				}
				else
				{
					mymps_delete( "member_docu", "WHERE id = ".$vids );
				}
			}
		}
		if ( is_array( $displayorder ) )
		{
			$i = 1;
			foreach ( $displayorder as $keyorder => $vorder )
			{
				$db->query( "UPDATE `".$db_mymps."member_docutype` SET displayorder = '{$vorder}' WHERE typeid = ".$keyorder );
			}
		}
		if ( is_array( $add ) && $add[typename] && $add[displayorder] )
		{
			$i = 1;
			$do_insert = $db->query( "INSERT INTO `".$db_mymps."member_docutype` (typename,arrid,ifview,displayorder) VALUES ('{$add['typename']}','{$add['arrid']}','{$add['ifview']}','{$add['displayorder']}')" );
			if ( !$do_insert )
			{
				write_msg( "文档模型增加失败!" );
			}
		}
	}
	if ( $i != 1 || !$i )
	{
		write_msg( "您没有进行任何操作！" );
	}
	else
	{
		clear_cache_files( "document_type" );
		write_msg( $do == "type" ? "会员文档模型设置更新成功！" : "会员文档更新成功！", $forward_url, "MympsRecord" );
	}
}
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
