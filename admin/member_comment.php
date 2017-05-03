<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "member_comment" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
$where = $userid ? "WHERE userid = '".$userid."'" : "";
$where .= $commentlevell ? " AND commentlevel = '".$commentlevel."'" : "";
$mlevel = array( );
$mlevel[0] = "<font color=red>待审</font>";
$mlevel[1] = "<font color=#006acd>正常</font>";
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	chk_admin_purview( "purview_模板点评" );
	$here = "网友点评";
	$rows_num = mymps_count( "member_comment", $where );
	$param = setparam( array( "part" ) );
	$comment = page1( "SELECT * FROM `".$db_mymps."member_comment` {$where} ORDER BY id DESC" );
	include( mymps_tpl( CURSCRIPT ) );
}
else if ( is_array( $ids ) )
{
	if ( $part == "delall" )
	{
		foreach ( $ids as $kids => $vids )
		{
			mymps_delete( "member_comment", "WHERE id = ".$vids );
		}
		write_msg( "成功删除指定点评信息！", $url, "writerecord" );
	}
	else
	{
		if ( strstr( $part, "level" ) )
		{
			$part = fileext( $part );
			foreach ( $ids as $kids => $vids )
			{
				$db->query( "UPDATE `".$db_mymps."member_comment` SET commentlevel = '{$part}' WHERE id = ".$vids );
			}
			write_msg( "成功修改指定点评的信息状态为".$mlevel[$part]."！", $url, "writerecord" );
		}
		else
		{
			write_msg( "Undefined Action!" );
		}
	}
}
else
{
	write_msg( "请选定您要操作处理的点评！" );
}
if ( is_object( $db ) )
{
	$db->Close();
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
