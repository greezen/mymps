<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function api_write_config( $config, $file )
{
	$success = false;
	if ( is_array( $config ) )
	{
		foreach ( $config as $key => $val )
		{
			$$key = $val;
		}
	}
	if ( $content = file_get_contents( $file ) )
	{
		$uc_connect = $uc_connect == "NULL" ? "post" : $uc_connect;
		$content = trim( $content );
		$content = substr( $content, -2 ) == "?>" ? substr( $content, 0, -2 ) : $content;
		$content = api_insert_config( $content, "/define\\('PASSPORT_TYPE',\\s*'.*?'\\);/i", "define('PASSPORT_TYPE', '".$passport_type."');" );
		$content = api_insert_config( $content, "/define\\('UC_CONNECT',\\s*'.*?'\\);/i", "define('UC_CONNECT', '".$uc_connect."');" );
		$content = api_insert_config( $content, "/define\\('UC_DBHOST',\\s*'.*?'\\);/i", "define('UC_DBHOST', '".$uc_dbhost."');" );
		$content = api_insert_config( $content, "/define\\('UC_DBUSER',\\s*'.*?'\\);/i", "define('UC_DBUSER', '".$uc_dbuser."');" );
		$content = api_insert_config( $content, "/define\\('UC_DBPW',\\s*'.*?'\\);/i", "define('UC_DBPW', '".$uc_dbpwd."');" );
		$content = api_insert_config( $content, "/define\\('UC_DBNAME',\\s*'.*?'\\);/i", "define('UC_DBNAME', '".$uc_dbname."');" );
		$content = api_insert_config( $content, "/define\\('UC_DBCHARSET',\\s*'.*?'\\);/i", "define('UC_DBCHARSET', '".$uc_dbcharset."');" );
		$content = api_insert_config( $content, "/define\\('UC_DBTABLEPRE',\\s*'.*?'\\);/i", "define('UC_DBTABLEPRE', '`".$uc_dbname."`.{$uc_dbpre}');" );
		$content = api_insert_config( $content, "/define\\('UC_DBCONNECT',\\s*'.*?'\\);/i", "define('UC_DBCONNECT', '0');" );
		$content = api_insert_config( $content, "/define\\('UC_KEY',\\s*'.*?'\\);/i", "define('UC_KEY', '".$uc_key."');" );
		$content = api_insert_config( $content, "/define\\('UC_API',\\s*'.*?'\\);/i", "define('UC_API', '".$uc_api."');" );
		$content = api_insert_config( $content, "/define\\('UC_CHARSET',\\s*'.*?'\\);/i", "define('UC_CHARSET', '".$uc_charset."');" );
		$content = api_insert_config( $content, "/define\\('UC_IP',\\s*'.*?'\\);/i", "define('UC_IP', '".$uc_ip."');" );
		$content = api_insert_config( $content, "/define\\('UC_APPID',\\s*'?.*?'?\\);/i", "define('UC_APPID', '".$uc_appid."');" );
		$content = api_insert_config( $content, "/define\\('UC_PPP',\\s*'?.*?'?\\);/i", "define('UC_PPP', '20');" );
		$content .= "?>";
		if ( @file_put_contents( $file, $content ) )
		{
			$success = true;
		}
	}
	return $success;
}

function api_insert_config( $s, $find, $replace )
{
	if ( preg_match( $find, $s ) )
	{
		$s = preg_replace( $find, $replace, $s );
		return $s;
	}
	$s .= "\r\n".$replace;
	return $s;
}

define( "CURSCRIPT", "passport" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
chk_admin_purview( "purview_整合接口设置" );
if ( !in_array( $part, array( "bbs", "qqlogin" ) ) )
{
	$part = "bbs";
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	$here = "整合接口设置";
	if ( $part == "bbs" )
	{
		$query = $db->query( "SELECT * FROM `".$db_mymps."config` WHERE type = 'passport'" );
		while ( $row = $db->fetchrow( $query ) )
		{
			$ucsettings[$row['description']] = $row['value'];
		}
		if ( $ucsettings['passport_type'] == "ucenter" )
		{
			$selected = "ucenter";
		}
		else if ( $ucsettings['passport_type'] == "phpwind" )
		{
			$selected = "phpwind";
		}
		else
		{
			$selected = "none";
		}
	}
	else
	{
		$query = $db->query( "SELECT * FROM `".$db_mymps."config` WHERE type = 'qqlogin'" );
		while ( $row = $db->fetchrow( $query ) )
		{
			$qqsettings[$row['description']] = $row['value'];
		}
	}
	include( mymps_tpl( CURSCRIPT ) );
}
else
{
	if ( $part == "bbs" )
	{
		$db->query( "DELETE FROM `".$db_mymps."config` WHERE type = 'passport'" );
		if ( $passport_type == "none" )
		{
			$ucsettings = array( );
		}
		else if ( in_array( $passport_type, array( "ucenter", "phpwind", "NULL" ) ) && is_array( $ucsettings ) )
		{
			$ucsettings['passport_type'] = $passport_type;
			foreach ( $ucsettings as $key => $val )
			{
				$db->query( "INSERT INTO `".$db_mymps."config` (`description`,`value`,`type`)VALUES('{$key}','{$val}','passport');" );
			}
		}
		if ( !api_write_config( $ucsettings, MYMPS_DATA."/config.db.php" ) )
		{
			write_msg( MYMPS_DATA."/config.db.php 文件不可写，请设置可写权限" );
		}
		write_msg( "成功更新整合接口设置！", "passport.php" );
	}
	else
	{
		if ( is_array( $qqsettings ) )
		{
			$db->query( "DELETE FROM `".$db_mymps."config` WHERE type = 'qqlogin'" );
			foreach ( $qqsettings as $key => $val )
			{
				$db->query( "INSERT INTO `".$db_mymps."config` (`description`,`value`,`type`)VALUES('{$key}','{$val}','qqlogin');" );
			}
		}
		write_qqlogin_cache( );
		write_msg( "成功更新qq登录整合设置！", "passport.php?part=qqlogin" );
	}
}
if ( is_object( $db ) )
{
	$db->close( );
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
