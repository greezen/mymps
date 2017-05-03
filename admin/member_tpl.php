<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "member_tpl" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
require_once( dirname( __FILE__ )."/include/ifview.inc.php" );
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	chk_admin_purview( "purview_模板点评" );
	if ( $part == "edit" )
	{
		$here = "会员模板设置修改";
		if ( $edit = $db->getrow( "SELECT * FROM ".$db_mymps."member_tpl WHERE id = ".$id ) )
		{
			include( mymps_tpl( CURSCRIPT."_edit" ) );
		}
		else
		{
			write_msg( "您所指定的模板不存在或者已被删除！" );
		}
	}
	else
	{
		$here = "会员模板设置";
		$list = $db->getall( "SELECT * FROM ".$db_mymps.CURSCRIPT." ORDER BY displayorder ASC" );
		include( mymps_tpl( CURSCRIPT ) );
	}
}
else
{
	if ( $part == "edit" )
	{
		$forward_url = "?part=edit&id=".$id;
		if ( empty( $displayorder ) )
		{
            write_msg( "模板名称和模板路径不能为空！" );
		}
		$db->query( "UPDATE `".$db_mymps."member_tpl` SET tpl_name='{$tpl_name}',tpl_path='{$tpl_path}',if_view='{$isview}',displayorder='{$displayorder}',edittime='".time( ).( "' WHERE id = '".$id."'" ) );
		$i = 1;
	}
	else
	{
		if ( is_array( $delids ) )
		{
			$i = 1;
			foreach ( $delids as $kids => $vids )
			{
				mymps_delete( CURSCRIPT, "WHERE id = ".$vids );
			}
		}
		if ( is_array( $displayorder ) )
		{
			$i = 1;
			foreach ( $displayorder as $keyorder => $vorder )
			{
				$db->query( "UPDATE `".$db_mymps."member_tpl` SET displayorder = '{$vorder}' WHERE id = ".$keyorder );
			}
		}
		if ( is_array( $add ) && $add[tpl_name] && $add[tpl_path] )
		{
			$i = 1;
			$do_insert = $db->query( "INSERT INTO `".$db_mymps."member_tpl` (tpl_name,tpl_path,if_view,displayorder,edittime) VALUES ('{$add['tpl_name']}','{$add['tpl_path']}','{$add['if_view']}','{$add['displayorder']}','".time( )."')" );
			if ( !$do_insert )
			{
                write_msg( "会员模板增加失败!" );
			}
		}
	}
	if ( $i != 1 || !$i )
	{
		write_msg( "您没有进行任何操作！" );
	}
	else
	{
		write_msg( "会员模板设置更新成功！", $forward_url, "MympsRecord" );
	}
}
if ( is_object( $db ) )
{
	$db->Close();
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
