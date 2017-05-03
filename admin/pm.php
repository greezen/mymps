<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function member_groups( )
{
	global $db;
	global $db_mymps;
	$all = $db->getall( "SELECT * FROM `".$db_mymps."member_level`" );
	foreach ( $all as $k => $v )
	{
		$mymps .= "<option value=".$v[id].">".$v[levelname]."</option>";
	}
	return $mymps;
}

define( "CURSCRIPT", "pm" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
require_once( MYMPS_MEMBER."/include/common.func.php" );
if ( !in_array( $part, array( "outbox", "send", "del" ) ) )
{
	$part = "send";
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	chk_admin_purview( "purview_站内短消息" );
	$here = $part == "send" ? "群发短消息" : "已发送短消息";
	if ( $part == "outbox" )
	{
		$sql = "SELECT * FROM `".$db_mymps."member_pm` WHERE if_sys = '1' AND if_del = '0' ORDER BY id DESC";
		$rows_num = mymps_count( "member_pm", "WHERE if_sys = '1'" );
		$param = setparam( array( "part" ) );
		$pm = page1( $sql );
	}
	else if ( $part == "send" && $id )
	{
		$pm_row = $db->getrow( "SELECT title,content FROM `".$db_mymps."member_pm` WHERE id = '{$id}'" );
		$title = de_textarea_post_change( $pm_row['title'] );
		$content = de_textarea_post_change( $pm_row['content'] );
	}
	else if ( $part == "del" )
	{
		mymps_delete( "member_pm", "WHERE id = '".$id."'" );
		write_msg( "编号为".$id."的短消息已成功删除！", $url, "writerecord" );
	}
	include( mymps_tpl( CURSCRIPT."_".$part ) );
}
else
{
	if ( is_array( $delids ) )
	{
		foreach ( $delids as $kids => $vids )
		{
			mymps_delete( "member_pm", "WHERE id = ".$vids );
		}
		write_msg( "指定的短消息已成功删除！", $url );
	}
	set_time_limit( 0 );
	$content = textarea_post_change( $content );
	if ( empty( $touser ) || empty( $group ) )
	{
		exit( "请指定发送用户名！" );
	}
	echo "<style>*{font-size:12px}</style>";
	if ( is_array( $group ) )
	{
		foreach ( $group as $kid => $vid )
		{
			if ( !($rgrow = $db->getall( "SELECT userid FROM `".$db_mymps."member` WHERE levelid = '{$vid}'" ) ))
			{
				echo "该会员组下尚没有会员！";
			}
			else
			{
				foreach ( $rgrow as $row )
				{
					$result = sendpm( $admin_id, $row[userid], $title, $content, 1 );
					if ( $result[succ] == "yes" )
					{
						echo "发送状态：<font color=green>发送成功！</font> 接收用户：".$result[member]."<br>";
					}
					else
					{
						echo "发送状态：<font color=red>发送失败！</font> 接收用户：".$result[member]."<br>";
					}
					ob_flush( );
					flush( );
				}
			}
		}
	}
	else
	{
		$touser = str_replace( "，", ",", $touser );
		$touser = explode( ",", $touser );
		foreach ( $touser as $kuser => $vuser )
		{
			$result = sendpm( $admin_id, $vuser, $title, $content, 1 );
			echo "<style>*{font-size:12px}</style>";
			if ( $result[succ] == "yes" )
			{
				echo "发送状态：<font color=green>发送成功！</font> 接收用户：".$result[member]."<br>";
			}
			else
			{
				echo "发送状态：<font color=red>发送失败！</font> 接收用户：".$result[member]."<br>";
			}
			ob_flush( );
			flush( );
		}
	}
	write_msg( "短消息发送结束", "olmsg", "record" );
}
if ( is_object( $db ) )
{
	$db->Close();
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
