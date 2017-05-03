<?php

function createtable( $sql, $dbcharset )
{
	$type = strtoupper( preg_replace( "/^\\s*CREATE TABLE\\s+.+\\s+\\(.+?\\).*(ENGINE|TYPE)\\s*=\\s*([a-z]+?).*\$/isU", "\\2", $sql ) );
	$type = in_array( $type, array( "MYISAM", "HEAP" ) ) ? $type : "MYISAM";
	return preg_replace( "/^\\s*(CREATE TABLE\\s+.+\\s+\\(.+?\\)).*\$/isU", "\\1", $sql ).( "4.1" < mysql_get_server_info( ) ? " ENGINE=".$type." DEFAULT CHARSET={$dbcharset}" : " TYPE=".$type );
}

function arraykeys2( $array, $key2 )
{
	$return = array( );
	foreach ( $array as $val )
	{
		$return[] = $val[$key2];
	}
	return $return;
}

function syntablestruct( $sql, $version, $dbcharset )
{
	if ( strpos( trim( substr( $sql, 0, 18 ) ), "CREATE TABLE" ) === false )
	{
		return $sql;
	}
	$sqlversion = strpos( $sql, "ENGINE=" ) === false ? false : TRUE;
	if ( $sqlversion === $version )
	{
		if ( $sqlversion && $dbcharset )
		{
			return preg_replace( array(
				"/ character set \\w+/i",
				"/ collate \\w+/i",
				"/DEFAULT CHARSET=\\w+/is"
				), array(
				"",
				"",
				"DEFAULT CHARSET=".$dbcharset
				), $sql );
		}
		return $sql;
	}
	if ( $version )
	{
		return preg_replace( array(
			"/TYPE=HEAP/i",
			"/TYPE=(\\w+)/is"
			), array(
			"ENGINE=MEMORY DEFAULT CHARSET=".$dbcharset,
			"ENGINE=\\1 DEFAULT CHARSET=".$dbcharset
			), $sql );
	}
	return preg_replace( array( "/character set \\w+/i", "/collate \\w+/i", "/ENGINE=MEMORY/i", "/\\s*DEFAULT CHARSET=\\w+/is", "/\\s*COLLATE=\\w+/is", "/ENGINE=(\\w+)(.*)/is" ), array( "", "", "ENGINE=HEAP", "", "", "TYPE=\\1\\2" ), $sql );
}

function sqldumptable( $table, $startfrom = 0, $currsize = 0 )
{
	global $db;
	global $sizelimit;
	global $startrow;
	global $extendins;
	global $sqlcompat;
	global $sqlcharset;
	global $dumpcharset;
	global $usehex;
	global $complete;
	global $excepttables;
	$offset = 300;
	$tabledump = "";
	$tablefields = array( );
	$query = $db->query( "SHOW FULL COLUMNS FROM ".$table, "SILENT" );
	if ( !$query )
	{
		if ( $db->errno( ) == 1146 )
		{
			return;
		}
		if ( !$query )
		{
			$usehex = false;
		}
	}
	else
	{
		while ( $fieldrow = $db->fetch_array( $query ) )
		{
			$tablefields[] = $fieldrow;
		}
	}
	if ( !$startfrom )
	{
		$createtable = $db->query( "SHOW CREATE TABLE ".$table, "SILENT" );
		if (!$db->error())
		{
			$tabledump = "DROP TABLE IF EXISTS ".$table.";\n";
		}
		else
		{
			return "";
		}
		$create = $db->fetch_row( $createtable );
		if ( strpos( $table, "." ) !== false )
		{
			$tablename = substr( $table, strpos( $table, "." ) + 1 );
			$create[1] = str_replace( "CREATE TABLE ".$tablename, "CREATE TABLE ".$table, $create[1] );
		}
		$tabledump .= $create[1];
		if ( $sqlcompat == "MYSQL41" && $db->version( ) < "4.1" )
		{
			$tabledump = preg_replace( "/TYPE\\=(.+)/", "ENGINE=\\1 DEFAULT CHARSET=".$dumpcharset, $tabledump );
		}
		if ( "4.1" < $db->version( ) && $sqlcharset )
		{
			$tabledump = preg_replace( "/(DEFAULT)*\\s*CHARSET=.+/", "DEFAULT CHARSET=".$sqlcharset, $tabledump );
		}
		$tablestatus = $db->fetch_first( "SHOW TABLE STATUS LIKE '".$table."'" );
		$tabledump .= ( $tablestatus['Auto_increment'] ? " AUTO_INCREMENT=".$tablestatus['Auto_increment'] : "" ).";\n\n";
		if ( $sqlcompat == "MYSQL40" && "4.1" <= $db->version( ) && $db->version( ) < "5.1" )
		{
			if ( $tablestatus['Auto_increment'] != "" )
			{
				$temppos = strpos( $tabledump, "," );
				$tabledump = substr( $tabledump, 0, $temppos )." auto_increment".substr( $tabledump, $temppos );
			}
			if ( $tablestatus['Engine'] == "MEMORY" )
			{
				$tabledump = str_replace( "TYPE=MEMORY", "TYPE=HEAP", $tabledump );
			}
		}
	}
	$tabledumped = 0;
	$numrows = $offset;
	$firstfield = $tablefields[0];
	if ( $extendins == "0" )
	{
		while ($numrows == $offset )
		{
			if ( $firstfield['Extra'] == "auto_increment" )
			{
				$selectsql = "SELECT * FROM ".$table." WHERE {$firstfield['Field']} > {$startfrom} LIMIT {$offset}";
			}
			else
			{
				$selectsql = "SELECT * FROM ".$table." LIMIT {$startfrom}, {$offset}";
			}
			$tabledumped = 1;
			$rows = $db->query( $selectsql );
			$numfields = $db->num_fields( $rows );
			$numrows = $db->num_rows( $rows );
			while ( $row = $db->fetch_row($rows))
			{
				$comma = $t = "";
				for ($i = 0; $i < $numfields; $i++ )
				{
					if ( 5.4 < $db->version( ) )
					{
						$t .= $comma.( $usehex && !empty( $row[$i] )? "0x".bin2hex( $row[$i] ) : "'".mysql_real_escape_string( $row[$i] )."'" );
					}
					else
					{
						$t .= $comma.( $usehex && !empty( $row[$i] )? "0x".bin2hex( $row[$i] ) : "'".mysql_escape_string( $row[$i] )."'" );
					}
					$comma = ",";
				}
				if ( $firstfield['Extra'] == "auto_increment" )
				{
					$startfrom = $row[0];
				}
				else
				{
					$startfrom++;
				}
				$tabledump .= "INSERT INTO ".$table." VALUES ({$t});\n";
			}
		}
		$startrow = $startfrom;
		$tabledump .= "\n";
	}
	return $tabledump;
}

function splitsql( $sql )
{
	$sql = str_replace( "\r", "\n", $sql );
	$ret = array( );
	$num = 0;
	$queriesarray = explode( ";\n", trim( $sql ) );
	unset( $sql );
	foreach ( $queriesarray as $query )
	{
		$queries = explode( "\n", trim( $query ) );
		foreach ( $queries as $query )
		{
			$ret[$num] .= $query[0] == "#" ? NULL : $query;
		}
		$num++;
	}
	return $ret;
}

function slowcheck( $type1, $type2 )
{
	$t1 = explode( " ", $type1 );
	$t1 = $t1[0];
	$t2 = explode( " ", $type2 );
	$t2 = $t2[0];
	$arr = array(
		$t1,
		$t2
		);
	sort( $arr );
	if ( $arr == array( "mediumtext", "text" ) )
	{
		return TRUE;
	}
	if ( substr( $arr[0], 0, 4 ) == "char" && substr( $arr[1], 0, 7 ) == "varchar" )
	{
		return TRUE;
	}
	return false;
}

function sizecount( $filesize )
{
	if ( 1073741824 <= $filesize )
	{
		$filesize = ( round( $filesize / 1073741824 * 100 ) / 100 )." GB";
		return $filesize;
	}
	if ( 1048576 <= $filesize )
	{
		$filesize = ( round( $filesize / 1048576 * 100 ) / 100 )." MB";
		return $filesize;
	}
	if ( 1024 <= $filesize )
	{
		$filesize = ( round( $filesize / 1024 * 100 ) / 100 )." KB";
		return $filesize;
	}
	$filesize .= " Bytes";
	return $filesize;
}

define( "CURSCRIPT", "database" );
error_reporting( 0 );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
$allowpart = array( "backup" => "数据库备份", "restore" => "数据库恢复", "optimize" => "数据库优化", "check" => "数据库检查", "repair" => "数据库修复" );
if ( !in_array( $part, array_keys( $allowpart ) ) )
{
	$part = "backup";
}
$here = $allowpart[$part];
$action = isset( $action ) ? trim( $action ) : "";
$tabletype = "4.1" < $db->version( ) ? "Engine" : "Type";
$version = MPS_VERSION;
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
$backupdir = $mymps_global['cfg_backup_dir'];
if ( $part == "backup" )
{
	chk_admin_purview( "purview_数据库备份" );
	if ( $action != "doaction" )
	{
		$mymps_tables = fetchtablelist( $db_mymps );
		$defaultfilename = date( "ymd" )."_".random( 8 );
		include( mymps_tpl( "db_".$part ) );
	}
	else
	{
		$db->query( "SET SQL_QUOTE_SHOW_CREATE=0", "SILENT" );
		if ( !$filename && preg_match( "/(\\.)(exe|jsp|asp|aspx|cgi|fcgi|pl|php)(\\.|\$)/i", $filename ) )
		{
			write_msg( "导出文件格式非法" );
		}
		$time = gettime( $timestamp );
		if ( $type == "mymps" )
		{
			$tables = arraykeys2( fetchtablelist( $db_mymps ), "Name" );
		}
		else if ( $type == "custom" )
		{
			$tables = array( );
			if ( empty( $setup ) )
			{
				if ( $tables = $db->fetch_first( "SELECT value FROM `".$db_mymps."config` WHERE description='custombackup'" ) )
				{
					$tables = $charset == "utf-8" ? utf8_unserialize( $tables['value'] ) : unserialize( $tables['value'] );
				}
			}
			else
			{
				$customtablesnew = empty( $customtables ) ? "" : addslashes( serialize( $customtables ) );
				$db->query( "DELETE FROM `".$db_mymps."config` WHERE description = 'custombackup' AND type = 'database'" );
				$db->query( "INSERT INTO `".$db_mymps."config` (description, value, type) VALUES ('custombackup', '{$customtablesnew}','database')" );
				$tables =& $customtables;
			}
			if ( !is_array( $tables ) && empty( $tables ) )
			{
				write_msg( "请选择你要备份的数据库表" );
			}
		}
		$volume = intval( $volume ) + 1;
		$idstring = "# Identify: ".base64_encode( $timestamp.",{$version},{$type},{$method},{$volume}" )."\n";
		$dumpcharset = $sqlcharset ? $sqlcharset : $db_charset;
		$setnames = $sqlcharset && "4.1" < $db->version( ) && ( !$sqlcompat && $sqlcompat == "MYSQL41" ) ? "SET NAMES '".$dumpcharset."';\n\n" : "";
		if ( "4.1" < $db->version( ) )
		{
			if ( $sqlcharset )
			{
				$db->query( "SET NAMES '".$sqlcharset."';\n\n" );
			}
			if ( $sqlcompat == "MYSQL40" )
			{
				$db->query( "SET SQL_MODE='MYSQL40'" );
			}
			else if ( $sqlcompat == "MYSQL41" )
			{
				$db->query( "SET SQL_MODE=''" );
			}
		}
		$backupfilename = MYMPS_ROOT.$backupdir."/".str_replace( array( "/", "\\", "." ), "", $filename );
		$sqldump = "";
		$startfrom = intval( $startfrom );
		$complete = true;
		for ( $tableid = intval( $tableid ); $complete && ($tableid<(count( $tables ))); $tableid++ )
		{
			$sqldump .= sqldumptable( $tables[$tableid], $startfrom, strlen( $sqldump ) );
			if ( $complete )
			{
				$startfrom = 0;
			}
		}
		$dumpfile = $backupfilename."-%s.sql";
		if ( !$complete )
		{
			$tableid--;
		}
		if ( trim( $sqldump ) )
		{
			$sqldump = $idstring."# <?exit();?>\n".( "# Mymps Multi-Volume Data Dump Vol.".$volume."\n" ).( "# Version: Mymps ".$version."\n" ).( "# Time: ".$time."\n" ).( "# Type: ".$type."\n" ).( "# Table Prefix: ".$db_mymps."\n" )."#\n# Mymps Home: http://zhideyao.cn\n# Please visit our website for newest infomation about Mymps\n# --------------------------------------------------------\n\n\n".( $setnames."" ).$sqldump;
			$dumpfilename = sprintf( $dumpfile, $volume );
			@$fp = @fopen( $dumpfilename, "wb" );
			@flock( $fp, 2 );
			if ( !@fwrite( $fp, $sqldump ) )
			{
				@fclose( $fp );
				write_msg( "数据库备份失败，请检查备份目录的读写权限" );
			}
			else
			{
				fclose( $fp );
				unset( $sqldump );
				unset( $content );
				write_msg( "数据文件 #".$volume." 备份成功，系统将自动继续...", "?part=backup&type=".rawurlencode( $type )."&filename=".rawurlencode( $filename )."&method=multivol&sizelimit=".rawurlencode( $sizelimit )."&volume=".rawurlencode( $volume )."&tableid=".rawurlencode( $tableid )."&startfrom=".rawurlencode( $startrow )."&extendins=".rawurlencode( $extendins )."&sqlcharset=".rawurlencode( $sqlcharset )."&sqlcompat=".rawurlencode( $sqlcompat )."&action=doaction" );
			}
		}
		else
		{
			--$volume;
			$i = 1;
			for ( ; $i <= $volume; ++$i )
			{
				$filename = sprintf( $dumpfile, $i );
				$filelist .= $filename."<br>";
			}
			$db->query( "DELETE FROM `".$db_mymps."config` WHERE description = 'latestbackup' AND type = 'database'" );
			$db->query( "INSERT INTO `".$db_mymps."config` (description, value, type) VALUES ('latestbackup', '{$timestamp}','database')" );
			write_msg( "恭喜您，全部 ".$volume." 个备份文件成功创建，备份完成。<br /><br />".$filelist, "olmsg" );
		}
	}
}
else if ( $part == "restore" )
{
	chk_admin_purview( "purview_数据库还原" );
	if ( $action == "dorestore" )
	{
		$readerror = 0;
		$datafile = "";
		if ( $from == "server" )
		{
			$datafile = $datafile_server;
		}
		if ( $fp = @fopen( $datafile, "rb" ) )
		{
			$sqldump = fgets( $fp, 256 );
			$identify = explode( ",", base64_decode( preg_replace( "/^# Identify:\\s*(\\w+).*/s", "\\1", $sqldump ) ) );
			$dumpinfo = array(
				"method" => $identify[3],
				"volume" => intval( $identify[4] )
				);
			$sqldump .= fread( $fp, filesize( $datafile ) );
			fclose( $fp );
		}
		else if ( $autoimport )
		{
			updatecaches( );
			write_msg( "恭喜，数据还原操作成功！", "olmsg" );
		}
		else
		{
			write_msg( "很遗憾，数据还原失败。", "olmsg" );
		}
		$sqlquery = splitsql( $sqldump );
		unset( $sqldump );
		foreach ( $sqlquery as $sql )
		{
			$sql = syntablestruct( trim( $sql ), "4.1" < $db->version( ), $dbcharset );
			if ( $sql != "" )
			{
				$db->query( $sql, "SILENT" );
				if ( !( $sqlerror = $db->error( ) ) && !( $db->errno( ) != 1062 ) )
				{
					$db->halt( "MySQL Query Error", $sql );
				}
			}
		}
		$datafile_next = preg_replace( "/-(".$dumpinfo['volume'].")(\\..+)\$/", ( "-".( $dumpinfo['volume'] + 1 ) )."\\2", $datafile_server );
		if ( $dumpinfo['volume'] == 1 )
		{
			write_msg( "分卷数据第一卷成功导入数据库。<br /><br />您需要自动导入本次备份的其他分卷吗？<br /><br /><center><input class=\"gray\" value=\"确定\" type=button onclick=\"location.href='?part=restore&from=server&datafile_server=".$datafile_next."&autoimport=yes&action=dorestore'\">&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"gray\" type=\"button\" onclick=\"location.href='?part=restore&from=server&datafile_server=".$datafile_next."&action=dorestore'\" value=\"取消\"></center>", "olmsg" );
		}
		else if ( $autoimport )
		{
			write_msg( "数据文件 ".$dumpinfo['volume']."# 成功导入，程序将自动继续。", "?part=restore&from=server&datafile_server=".$datafile_next."&autoimport=yes&action=dorestore" );
		}
		else
		{
			updatecaches( );
			write_msg( "恭喜，数据还原操作成功。", "olmsg" );
		}
	}
	else if ( $action == "dodelete" )
	{
		if ( is_array( $delete ) )
		{
			foreach ( $delete as $filename )
			{
				$file_path = MYMPS_ROOT.$backupdir."/".str_replace( array( "/", "\\" ), "", $filename );
				$file_paths = MYMPS_ROOT.$backupdir."/";
				if ( is_file( $file_path ) )
				{
					@unlink( $file_path );
				}
				else
				{
					$dir = @ dir($file_paths);
					$rpe='/'.$filename.'\-\d+\.sql$/sim';
					while (($file = $dir->read())!==false)  
					{
						$file_ = $file_paths.$file;
						if (preg_match($rpe,$file)){
							@unlink($file_);
						}
					}
				}
			}
			write_msg( "恭喜，成功删除指定备份文件。", "database.php?part=restore", "write_record" );
		}
		else
		{
			write_msg( "操作失败，请检查备份目录的文件读写权限。" );
		}
	}
	else
	{
		$backuptype = array( "mymps" => "Mymps全部数据表", "custom" => "自定义备份" );
		$exportlog = $exportsize = $exportziplog = array( );
		if ( is_dir( MYMPS_ROOT.$backupdir ) )
		{
			$dir = dir( MYMPS_ROOT.$backupdir );
			while ( $entry = $dir->read( ) )
			{
				$entry = MYMPS_ROOT.$backupdir."/".$entry;
				if ( is_file( $entry ) && preg_match( "/\\.sql\$/sim", $entry ) )
				{
					$filesize = filesize( $entry );
					$fp = fopen( $entry, "rb" );
					$identify = explode( ",", base64_decode( preg_replace( "/^# Identify:\\s*(\\w+).*/s", "\\1", fgets( $fp, 256 ) ) ) );
					fclose( $fp );
					$key = preg_replace( "/^(.+?)(\\-\\d+)\\.sql\$/i", "\\1", basename( $entry ) );
					$exportlog[$key][$identify[4]] = array(
						"version" => $identify[1],
						"type" => $identify[2],
						"method" => $identify[3],
						"volume" => $identify[4],
						"filename" => $entry,
						"dateline" => filemtime( $entry ),
						"size" => $filesize
						);
					$exportsize[$key] += $filesize;
				}
			}
			$dir->close( );
		}
		else
		{
			write_msg( "无法识别备份的数据库文件目录" );
		}
		include( mymps_tpl( "db_".$part ) );
	}
}
else if ( $part == "optimize" )
{
	chk_admin_purview( "purview_数据库维护" );
	@set_time_limit( 0 );
	$optimizetable = "";
	$totalsize = 0;
	$tablearray = array(
		0 => $db_mymps
		);
	include( !submit_check( "optimize_submit" ) ? mymps_tpl( "db_".$part ) : mymps_tpl( "db_result" ) );
}
else if ( $part == "check" )
{
	chk_admin_purview( "purview_数据库维护" );
	$optimizetable = "";
	$totalsize = 0;
	$tablearray = array(
		0 => $db_mymps
		);
	include( !submit_check( "check_submit" ) ? mymps_tpl( "db_".$part ) : mymps_tpl( "db_result" ) );
}
else if ( $part == "repair" )
{
	chk_admin_purview( "purview_数据库维护" );
	$optimizetable = "";
	$totalsize = 0;
	$tablearray = array(
		0 => $db_mymps
		);
	include( !submit_check( "repair_submit" ) ? mymps_tpl( "db_".$part ) : mymps_tpl( "db_result" ) );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
