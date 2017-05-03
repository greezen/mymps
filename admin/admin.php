<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function get_admin_group( $typeid = "" )
{
	global $db;
	global $db_mymps;
	$admin = $db->getall( "SELECT * FROM `".$db_mymps."admin_type` ORDER BY id desc" );
	foreach ( $admin as $row )
	{
		$mymps .= "<option value=\"".$row[id]."\"";
		$mymps .= $typeid == $row[id] ? "selected style=\"background-color:#6EB00C;color:white\"" : "";
		$mymps .= ">".$row[typename]."</option>";
	}
	return $mymps;
}

define( "CURSCRIPT", "admin" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
switch ( $do )
{
	case "user" :
	$part = $part ? $part : "list";
	if ( $part == "list" )
	{
		chk_admin_purview( "purview_用户列表" );
		var_dump($typeid);
		$where = $typeid ? "WHERE typeid = ".$typeid."" : "";
		$where .= $admin_cityid ? " AND a.cityid = '".$admin_cityid."'" : ($cityid ? " AND a.cityid = '".$cityid."'" : "");
		$sql = "SELECT a.id,a.userid,a.cityid,a.uname,a.tname,a.logintime,a.loginip,a.typeid,b.typename FROM `".$db_mymps."admin` AS a LEFT JOIN `{$db_mymps}admin_type` AS b ON a.typeid = b.id {$where} ORDER BY a.typeid Asc";
		$admin = $db->getall( $sql );
		$allcities = get_allcities( );
		$here = "管理员帐号管理";
		include( mymps_tpl( "admin_user" ) );
		break;
	}
	else
	{
		if ( $part == "add" )
		{
			chk_admin_purview( "purview_用户列表" );
			$here = "新增网站管理员帐号";
			include( mymps_tpl( "admin_user_add" ) );
			break;
		}
		else if ( $part == "insert" )
		{
			$pwd = md5( trim( $pwd ) );
			if ( !is_email( $email ) )
			{
				write_msg( "电子邮件格式不正确。" );
				exit( );
			}
			if ( 0 < mymps_count( "admin", "WHERE userid LIKE '".$userid."'" ) )
			{
			}
			$db->query( "INSERT INTO `".$db_mymps."admin`(userid,cityid,uname,tname,pwd,typeid,email)\r\n\t\t\t\tVALUES('{$userid}','{$cityid}','{$uname}','{$tname}','{$pwd}','{$typeid}','{$email}'); " );
			write_admin_cache( );
			write_msg( "添加管理员 ".$userid." 成功", "?do=user", "record" );
			break;
		}
		else if ( $part == "edit" )
		{
			$id = $id ? $id : $db->getone( "SELECT id FROM `".$db_mymps."admin` WHERE userid = '{$userid}'" );
			$sql = "SELECT * FROM ".$db_mymps."admin WHERE id = '{$id}'";
			$admin = $db->getrow( $sql );
			if ( !$admin )
			{
				write_msg( "该管理员帐号不存在！" );
			}
			if ( $admin_cityid && $admin['cityid'] != $admin_cityid )
			{
				write_msg( "该管理员并非隶属您的分站管理之下" );
			}
			$here = "修改管理员帐号";
			include( mymps_tpl( "admin_user_edit" ) );
			break;
		}
		else if ( $part == "update" )
		{
			if ( !is_email( $email ) )
			{
				write_msg( "电子邮件格式不正确。" );
				exit( );
			}
			$pwd = !empty( $pwd ) ? "pwd='".md5( $pwd )."'," : "";
			$db->query( "UPDATE ".$db_mymps."admin SET {$pwd} userid='{$userid}',cityid='{$cityid}',uname='{$uname}',typeid='{$typeid}',tname='{$tname}',email='{$email}' WHERE id = '{$id}'" );
			write_admin_cache( );
			write_msg( "网站管理员 ".$uname." 更改成功", "admin.php?do=user&part=edit&id=".$id, "record" );
			break;
		}
		else if ( $part == "delete" )
		{
			if ( empty( $id ) )
			{
				write_msg( "没有选择记录" );
				break;
			}
			else if ( mymps_delete( "admin", "WHERE id = '".$id."'" ) )
			{
				write_admin_cache( );
				write_msg( "删除管理员 ".$id." 成功", "?do=user", "record" );
				break;
			}
			else
			{
				write_msg( "管理员删除失败！" );
				break;
			}
		}
	}
	case "group" :
	if ( $admin_cityid )
	{
		write_msg( "您没有权限访问该页！" );
	}
	require_once( dirname( __FILE__ )."/include/mymps.menu.inc.php" );
	$part = $part ? $part : "list";
	if ( $part == "list" )
	{
		chk_admin_purview( "purview_用户组" );
		$sql = "SELECT * FROM ".$db_mymps."admin_type ORDER BY id desc";
		$group = $db->getall( $sql );
		$here = "系统用户组管理";
		include( mymps_tpl( "admin_group" ) );
	}
	else if ( $part == "add" )
	{
		chk_admin_purview( "purview_用户组" );
		$here = "新增用户组";
		include( mymps_tpl( "admin_group_add" ) );
	}
	else if ( $part == "insert" )
	{
		$purview = is_array( $purview ) ? implode( ",", $purview ) : "";
		$typename = trim( $typename );
		$ifsystem = trim( $ifsystem );
		if ( empty( $typename ) )
		{
			$sql = "select count(*) from ".$db_mymps."admin_type where typename = '{$typename}'";
			if ( $db->getone( $sql ) )
			{
			}
		}
		$res = $db->query( "Insert Into `".$db_mymps."admin_type`(id,typename,ifsystem,purviews)\r\n\t\t\t\tValues('','{$typename}','{$ifsystem}','{$purview}')" );
		write_admin_cache( );
		write_msg( "添加用户组 ".$typename." 成功", "?do=group", "record" );
	}
	else if ( $part == "edit" )
	{
		$sql = "SELECT * FROM ".$db_mymps."admin_type WHERE id = '{$id}'";
		$group = $db->getrow( $sql );
		$purview = explode( ",", $group['purviews'] );
		$here = "修改用户组权限";
		include( mymps_tpl( "admin_group_edit" ) );
	}
	else if ( $part == "update" )
	{
		$purview = is_array( $purview ) ? implode( ",", $purview ) : "";
		$sql = "UPDATE `".$db_mymps."admin_type` SET typename='{$typename}',ifsystem='{$ifsystem}',purviews='{$purview}' WHERE id = '{$id}'";
		if ( $res = $db->query( $sql ) )
		{
			write_admin_cache( );
			write_msg( "用户组 ".$typename." 修改成功", "?do=group&part=edit&id=".$id, "record" );
		}
	}
	else if ( $part == "delete" )
	{
		if ( empty( $id ) )
		{
			write_msg( "没有选择记录" );
		}
		else if ( 0 < mymps_count( "admin", "WHERE typeid = '".$id."'" ) )
		{
			write_msg( "该用户组下尚有成员，不能删除！" );
		}
		else if ( mymps_delete( "admin_type", "WHERE id = '".$id."'" ) )
		{
			write_admin_cache( );
			write_msg( "删除用户组 ".$id." 成功", "?do=group", "record" );
		}
		else
		{
			write_msg( "管理员用户组删除失败！" );
		}
	}
}
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
