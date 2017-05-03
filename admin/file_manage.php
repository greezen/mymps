<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "file_manage" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_DATA."/config.inc.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
$part = $part ? $part : "template";
if ( $downfile )
{
	if ( !is_file( $downfile ) )
	{
		write_msg( "您要下载的文件不存在！" );
	}
	if ( fileext( $downfile ) == "php" )
	{
		write_msg( "该文件不允许下载!" );
	}
	$filename = basename( $downfile );
	$filename_info = explode( ".", $filename );
	$fileext = $filename_info[count( $filename_info ) - 1];
	header( "Content-type: application/x-".$fileext );
	header( "Content-Disposition: attachment; filename=".$filename );
	header( "Content-Description: PHP3 Generated Data" );
	readfile( $downfile );
	exit( );
}
if ( !empty($delfile))
{
	if ( $part == "template" )
	{
		write_msg( "模板文件不能删除，请手动在FTP目录中将其删除！" );
	}
	if ( fileext( $delfile ) == "html" )
	{
		write_msg( "该文件不允许删除，请在FTP目录中手动删除！" );
	}
	if ( file_exists( $delfile ) )
	{
		@unlink( $delfile );
		$msgs[] = "成功删除文件<br /><br />".$delfile;
		$msgs[] = "<a href=\"".$url."\">点此返回 &raquo;</a>";
		show_msg( $msgs );
		exit( );
	}
	write_msg( "文件已不存在！" );
	exit( );
}
$cfg_if_tpledit = $mymps_mymps['cfg_if_tpledit'] == 0 ? "<font color=green>已关闭</font>" : "<font color=red>已开启</font>";
switch ( $part )
{
	case "template" :
	chk_admin_purview( "purview_模板管理" );
	$here = "模板在线管理";
	$mulu = "Mymps模板目录";
	$showdir = MYMPS_TPL."/default";
	if ( $editfile )
	{
		if ( $do == "update" )
		{
			if ( $mymps_mymps['cfg_if_tpledit'] == "0" )
			{
				write_msg( "操作失败！系统管理员关闭了在线编辑风格的功能!<br /><br />您可以修改/dat/config.inc.php来开启它" );
			}
			$content = str_replace( "&amp;", "&", trim( $content ) );
			$content = str_replace( "&quot;", "\"", trim( $content ) );
			$nowfile = trim( $editfile );
			if ( !is_file( $nowfile ) )
			{
				write_msg( "对不起，该文件不存在！" );
			}
			$norootfile = str_replace( MYMPS_ROOT."/template", "", $nowfile );
			if ( $db->getone( "SELECT content FROM `".$db_mymps."template` WHERE filepath LIKE '{$norootfile}'" ) )
			{
				$update_sql = $db->query( "UPDATE `".$db_mymps."template` SET content = '{$content}' WHERE filepath = '{$norootfile}'" );
			}
			else
			{
				$db->query( "INSERT INTO `".$db_mymps."template` (filepath,content) VALUES ('{$norootfile}','{$content}')" );
			}
			$row = $db->getrow( "SELECT filepath,content FROM `".$db_mymps."template` WHERE filepath = '{$norootfile}'" );
			if ( !$row )
			{
				write_msg( "操作失败！" );
				exit( );
			}
			$create_c = createfile( $nowfile, $row[content] );
			if ( $create_c )
			{
				write_msg( "模板文件".$nowfile."<br /><br />修改成功", $url, "MyMps" );
				break;
			}
			else
			{
				write_msg( "模板文件".$nowfile."无法修改<br /><br />请检查template目录的操作权限!" );
				break;
			}
		}
		else if ( $editfile || !empty( $do ) )
		{
			$ext = fileext( $editfile );
			if ( $ext != "html" && $ext != "css" && $ext != "htm" && $ext != "js" )
			{
				write_msg( "该文件不能在线编辑!" );
			}
			if ( !$edit = file_get_contents( $editfile ) )
			{
				write_msg( "该文件不可读，请检查该文件的操作权限" );
			}
			$path = str_replace( "/".end( explode( "/", $editfile ) ), "", $editfile );
			$edit = htmlspecialchars( $edit );
			$acontent = "<textarea name=\"content\" cols=\"110\" rows=\"25\">".$edit."</textarea>";
			include( mymps_tpl( "template_edit" ) );
			exit();
		}
	}
	break;
	case "upload" :
	chk_admin_purview( "purview_附件管理" );
	$here = "系统上传附件管理";
	$mulu = "系统附件目录";
	$showdir = MYMPS_UPLOAD;
	break;
}
$path = trim( $path ) ? trim( $path ) : $showdir;
$LastPath = str_replace( "/".end( explode( "/", $path ) ), "", $path );
$con = explode( $showdir, $CurrentPath );
include( mymps_tpl( CURSCRIPT ) );
if ( is_object( $db ) )
{
	$db->close();
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
