<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getupgradetype( $level = "", $formname = "upgrade_type" )
{
	$mymps .= "<select name='".$formname."' id='{$formname}'>";
	$info_upgrade_level = array( );
	$info_upgrade_level[1] = "不置顶";
	$info_upgrade_level[2] = "<font color=red>大类置顶</font>";
	foreach ( $info_upgrade_level as $k => $v )
	{
		if ( $k == $level )
		{
			$mymps .= "<option value='".$k."' selected style='background-color:#6EB00C;color:white'>{$v}</option>\r\n";
		}
		else
		{
			$mymps .= "<option value='".$k."'>{$v}</option>\r\n";
		}
	}
	$mymps .= "</select>\r\n";
	return $mymps;
}

function getupgradetypelist( $level = "", $formname = "upgrade_type_list" )
{
	$mymps .= "<select name='".$formname."' id='{$formname}'>";
	$info_upgrade_level = array( );
	$info_upgrade_level[1] = "不置顶";
	$info_upgrade_level[2] = "<font color=red>小类置顶</font>";
	foreach ( $info_upgrade_level as $k => $v )
	{
		if ( $k == $level )
		{
			$mymps .= "<option value='".$k."' selected style='background-color:#6EB00C;color:white'>{$v}</option>\r\n";
		}
		else
		{
			$mymps .= "<option value='".$k."'>{$v}</option>\r\n";
		}
	}
	$mymps .= "</select>\r\n";
	return $mymps;
}

function getupgradetypeindex( $level = "", $formname = "upgrade_type_index" )
{
	$mymps .= "<select name='".$formname."' id='{$formname}'>";
	$info_upgrade_level = array( );
	$info_upgrade_level[1] = "不置顶";
	$info_upgrade_level[2] = "<font color=red>首页置顶</font>";
	foreach ( $info_upgrade_level as $k => $v )
	{
		if ( $k == $level )
		{
			$mymps .= "<option value='".$k."' selected style='background-color:#6EB00C;color:white'>{$v}</option>\r\n";
		}
		else
		{
			$mymps .= "<option value='".$k."'>{$v}</option>\r\n";
		}
	}
	$mymps .= "</select>\r\n";
	return $mymps;
}

define( "CURSCRIPT", "information" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
require_once( MYMPS_DATA."/info.level.inc.php" );
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
if ( $do_action == "upgrade" )
{
	$upgrade_time['-1'] = "取消大类置顶";
}
if ( $do_action == "upgrade_list" )
{
	$upgrade_time['-1'] = "取消小类置顶";
}
if ( $do_action == "upgrade_index" )
{
	$upgrade_time['-1'] = "取消首页置顶";
}
$action = $action ? $action : "list";
switch ( $part )
{
	case "report" :
	require_once( MYMPS_DATA."/report.type.inc.php" );
	if ( $action == "list" )
	{
		chk_admin_purview( "purview_信息举报" );
		$here = "信息举报列表";
		$page = empty( $page ) ? 1 : intval( $page );
		$type = $_GET['report_type'];
		$where .= $type ? "WHERE report_type = '".$type."'" : "";
		$rows_num = mymps_count( "info_report", $where );
		$param = setparam( array( "part", "type" ) );
		$report = array( );
		$page1 = page1( "SELECT * FROM `".$db_mymps."info_report` {$where} ORDER BY pubtime DESC" );
		foreach ( $page1 as $k => $row )
		{
			$arr['id'] = $row['id'];
			$arr['infoid'] = $row['infoid'];
			$arr['infotitle'] = $row['infotitle'];
			$arr['content'] = $row['content'];
			$arr['type'] = "<a href=?part=report&report_type=".$row['report_type'].">".$report_type[$row['report_type']]."</a>";
			$arr['pubtime'] = gettime( $row['pubtime'] );
			$arr['ip'] = $row['ip'];
			$report[] = $arr;
		}
		include( mymps_tpl( "info_report" ) );
	}
	else if ( $action == "del" )
	{
		mymps_delete( "info_report", "WHERE id='".$id."'" );
		write_msg( "举报记录".$id."已成功删除！", $url, "MYMPS_record" );
	}
	else if ( $action == "delall" )
	{
		write_msg( "举报记录".mymps_del_all( "info_report", $id )."删除成功！", $url, "Mymps" );
	}
	break;
	default :
	if ( $action == "delall" )
	{
		require_once( MYMPS_MEMBER."/include/common.func.php" );
		if ( empty( $id ) )
		{
			write_msg( "您没有选择任何一条信息主题" );
		}
		foreach ( explode( ",", $id ) as $a => $w )
		{
			$get_row = $db->getrow( "SELECT a.*,b.modid FROM `".$db_mymps."information` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.catid = b.catid WHERE a.id = '{$w}'" );
			if ( 1 < $get_row['modid'] )
			{
				mymps_delete( "information_".$get_row[modid], "WHERE id = '".$w."'" );
			}
			if ( empty( $get_row['img_path'] ) )
			{
				$del = $db->getall( "SELECT path,prepath FROM `".$db_mymps."info_img` WHERE infoid='{$w}'" );
				foreach ( $del as $k => $v )
				{
					@unlink( @MYMPS_ROOT.@$v[path] );
					@unlink( @MYMPS_ROOT.@$v[prepath] );
				}
				mymps_delete( "info_img", "WHERE infoid = '".$w."'" );
			}
			mymps_delete( "comment", "WHERE type = 'information' AND typeid = '".$w."'" );
			if ( $get_row[ismember] == 1 )
			{
				$userid = $get_row['userid'];
				if ( $if_money == 1 )
				{
					$db->query( "UPDATE `".$db_mymps."member` SET money_own = money_own {$money_num} WHERE userid = '{$userid}'" );
				}
				if ( $if_pm == 1 )
				{
					$title = "你发布的信息主题已经被删除！";
					$msg = "您发布的 <b>".$get_row[title]."</b> 已经被删除，可能原因： <b>".$msg."</b>";
					$msg .= $if_money == 1 ? "<br />金币变化：<b style=color:red>".$money_num."</b>" : "";
					$result = sendpm( $admin_id, $userid, $title, $msg, 1 );
				}
			}
		}
		if ( mymps_delete( "information", " WHERE id IN (".$id.")" ) )
		{
			write_msg( "分类信息删除成功！", $url, "mymps" );
		}
	}
	else if ( $action == "upgrade_index" )
	{
		if ( empty( $id ) )
		{
			write_msg( "您没有选择任何一条信息主题" );
		}
		switch ( $upgrade_time )
		{
			case "-1" :
			$db->query( "UPDATE `".$db_mymps."information` SET upgrade_type_index = '1',upgrade_time_index='' WHERE id IN({$id})" );
			$cz = "取消首页置顶";
			break;
			default :
			$upgrade_time = $upgrade_time * 3600 * 24 + $timestamp;
			$db->query( "UPDATE `".$db_mymps."information` SET upgrade_type_index = '2',upgrade_time_index='{$upgrade_time}' WHERE id IN({$id})" );
			$cz = "首页置顶";
			break;
		}
		write_msg( "信息主题批量".$cz."操作成功!", $url, "write_record" );
	}
	else if ( $action == "upgrade" )
	{
		if ( empty( $id ) )
		{
			write_msg( "您没有选择任何一条信息主题" );
		}
		switch ( $upgrade_time )
		{
			case "-1" :
			$db->query( "UPDATE `".$db_mymps."information` SET upgrade_type = '1',upgrade_time='' WHERE id IN({$id})" );
			$cz = "取消大类置顶";
			break;
			default :
			$upgrade_time = $upgrade_time * 3600 * 24 + $timestamp;
			$db->query( "UPDATE `".$db_mymps."information` SET upgrade_type = '2',upgrade_time='{$upgrade_time}' WHERE id IN({$id})" );
			$cz = "大类置顶";
		}
		write_msg( "信息主题批量".$cz."操作成功!", $url, "write_record" );
	}
	else if ( $action == "upgrade_list" )
	{
		if ( empty( $id ) )
		{
			write_msg( "您没有选择任何一条信息主题" );
		}
		switch ( $upgrade_time )
		{
			case "-1" :
			$db->query( "UPDATE `".$db_mymps."information` SET upgrade_type_list = '1',upgrade_time_list='' WHERE id IN({$id})" );
			$cz = "取消小类置顶";
			break;
			default :
			$upgrade_time = $upgrade_time * 3600 * 24 + $timestamp;
			$db->query( "UPDATE `".$db_mymps."information` SET upgrade_type_list = '2',upgrade_time_list='{$upgrade_time}' WHERE id IN({$id})" );
			$cz = "小类置顶";
		}
		write_msg( "信息主题批量".$cz."操作成功!", $url, "write_record" );
	}
	else if ( $action == "ifred" )
	{
		if ( empty( $id ) )
		{
			write_msg( "您没有选择任何一条信息主题" );
		}
		$set = $ifred == 1 ? "SET ifred = '1'" : "SET ifred = '0'";
		$db->query( "UPDATE `".$db_mymps."information` {$set} WHERE id IN({$id})" );
		write_msg( "操作成功！", $url, "write_record" );
	}
	else if ( $action == "ifbold" )
	{
		if ( empty( $id ) )
		{
			write_msg( "您没有选择任何一条信息主题" );
		}
		$set = $ifbold == 1 ? "SET ifbold = '1'" : "SET ifbold = '0'";
		$db->query( "UPDATE `".$db_mymps."information` {$set} WHERE id IN({$id})" );
		write_msg( "操作成功！", $url, "write_record" );
	}
	else if ( $action == "certify_yes" )
	{
		if ( empty( $id ) )
		{
			write_msg( "您没有选择任何一条信息主题" );
		}
		$db->query( "UPDATE `".$db_mymps."information` SET certify = '1' WHERE id IN({$id})" );
		write_msg( "操作成功！", $url, "write_record" );
	}
	else if ( $action == "certify_no" )
	{
		if ( empty( $id ) )
		{
			write_msg( "您没有选择任何一条信息主题" );
		}
		$db->query( "UPDATE `".$db_mymps."information` SET certify = '0' WHERE id IN({$id})" );
		write_msg( "操作成功！", $url, "write_record" );
	}
	else if ( $action == "refresh" )
	{
		if ( empty( $id ) )
		{
			write_msg( "您没有选择任何一条信息主题" );
		}
		foreach ( explode( ",", $id ) as $kids => $vids )
		{
			$activetime = $db->getone( "SELECT activetime FROM `".$db_mymps."information` WHERE id = '{$vids}'" );
			$endtime = $activetime == 0 ? 0 : $activetime * 3600 * 24 + $timestamp;
			$db->query( "UPDATE `".$db_mymps."information` SET begintime = '{$timestamp}',endtime='{$endtime}' WHERE id = '{$vids}'" );
		}
		write_msg( "刷新分类信息成功！", $url, "write_record" );
	}
	else if ( $action == "list" )
	{
		chk_admin_purview( "purview_分类信息" );
		$admindir = getcwdol( );
		$showperpage = intval( $showperpage );
		$where = "WHERE 1";
		if (!empty($show))
		{
			switch ( $show )
			{
				case "title" :
				$where .= " AND a.title LIKE '%".$keywords."%'";
				break;
				case "idno" :
				$keywords = intval( $keywords );
				$where .= " AND a.id = '".$keywords."'";
				break;
				case "catidno" :
				$keywords = intval( $keywords );
				$where .= " AND ".get_children( intval( $keywords ) );
				break;
				case "userid" :
				$where .= " AND a.userid LIKE '%".$keywords."%'";
				break;
				case "tel" :
				$where .= " AND a.tel LIKE '%".$keywords."%'";
				break;
			}
		}
		$where .= $info_level != "" ? " AND a.info_level = '".$info_level."'" : "";
		switch ( $info_level )
		{
			case "0" :
			$here = "待审 ";
			break;
			case "1" :
			$here = "正常 ";
			break;
			case "2" :
			$here = "推荐 ";
			break;
		}
		if ( !empty($upgrade) )
		{
			switch ( $upgrade )
			{
				case "category" :
				$where .= " AND a.upgrade_type = '2'";
				$here .= "大类置顶 ";
				break;
				case "list" :
				$where .= " AND a.upgrade_type_list = '2'";
				$here .= "小类置顶 ";
				break;
				case "index" :
				$where .= " AND a.upgrade_type_index = '2'";
				$here .= "首页置顶 ";
				break;
			}
		}
		if ( !empty($ifred) )
		{
			$where .= " AND a.ifred = '1'";
			$here .= "标题套红 ";
		}
		if ( !empty($certify) )
		{
			$where .= " AND a.certify = '1'";
			$here .= "认证 ";
		}
		if ( !empty($ifbold) )
		{
			$where .= " AND a.ifbold = '1'";
			$here .= "标题加粗 ";
		}
		$here .= "分类信息列表";
		$where .= $admin_cityid ? " AND a.cityid = '".$admin_cityid."'" : $cityid ? " AND a.cityid = '".$cityid."'" : "";
		$rows_num = $db->getone( "SELECT COUNT(a.id) FROM `".$db_mymps."information` AS a {$where}" );
		$param = setparam( array( "part", "cityid", "show", "keywords", "info_level", "upgrade", "ifred", "ifbold", "certify" ) );
		$information = array( );
		$idin = get_page_idin( "id", "SELECT a.id FROM `".$db_mymps."information` AS a {$where} ORDER BY a.id DESC" );
		$page1 = $idin ? $db->getall( "SELECT a.* FROM `".$db_mymps."information` AS a WHERE a.id in ({$idin}) ORDER BY a.id DESC" ) : array( );
		foreach ( $page1 as $k => $row )
		{
			$arr['id'] = $row['id'];
			$arr['uri'] = rewrite( "info", array( "dir_typename" => $row['dir_typename'], "cityid" => $row['cityid'], "id" => $row['id'] ) );
			$arr['uri_cat'] = "?keywords=".$row[catid]."&show=catidno";
			$arr['levelid'] = $row['levelid'];
			$arr['ip'] = $row['ip'];
			$arr['certify'] = $row['certify'];
			$arr['ip2area'] = $row['ip2area'];
			if ($row['ismember'] == 1) {
				$member = $db->getRow("SELECT * FROM ".$db_mymps."member WHERE userid='{$row['userid']}'");
				if (!empty($member['openid'])) {
					$contact_who = "<a href=\"javascript:void(0);\" onclick=\"setbg('Mymps会员中心',400,110,'../box.php?part=member&userid=".$row['userid']."&admindir={$admindir}')\">".$member['nickname']."</a>";;
				} else {
					$contact_who = "<a href=\"javascript:void(0);\" onclick=\"setbg('Mymps会员中心',400,110,'../box.php?part=member&userid=".$row['userid']."&admindir={$admindir}')\">".$row['userid']."</a>";
				}
			} else {
				$contact_who = $row['contact_who'];
			}
			$arr['contact_who'] = $contact_who;
			$arr['title'] = $row['title'];
			$arr['catid'] = $row['catid'];
			$arr['catname'] = $row['catname'];
			$arr['img_path'] = $row['img_path'];
			$arr['img_count'] = $row['img_count'];
			$arr['ifred'] = $row['ifred'];
			$arr['ifbold'] = $row['ifbold'];
			$arr['begintime'] = $row['begintime'];
			$arr['ip'] = $row['ip'];
			$arr['info_level'] = $information_level[$row[info_level]];
			$arr['tel'] = $row['tel'];
			if ( $timestamp <= $row['upgrade_time'] )
			{
				if ( 1 < $row['upgrade_type'] )
				{
					$arr['upgrade_type'] = "<font color=red>置顶</font> ";
					$arr['upgrade_time'] = "<font color=red>大类置顶</font><br />至".date( "Y-m-d", $row['upgrade_time'] );
				}
				else
				{
					$arr['upgrade_type'] = "<font color=#585858>否</font>";
				}
			}
			else
			{
				$arr['upgrade_type'] = "<font color=#585858>否</font>";
				$arr['upgrade_time'] = "";
			}
			if ( $timestamp <= $row['upgrade_time_list'] )
			{
				if ( 1 < $row['upgrade_type_list'] )
				{
					$arr['upgrade_type_list'] = "<font color=red>置顶</font> ";
					$arr['upgrade_time_list'] = "<font color=red>小类置顶</font><br />至".date( "Y-m-d", $row['upgrade_time_list'] );
				}
				else
				{
					$arr['upgrade_type_list'] = "<font color=#585858>否</font>";
				}
			}
			else
			{
				$arr['upgrade_type_list'] = "<font color=#585858>否</font>";
				$arr['upgrade_time_list'] = "";
			}
			if ( $timestamp <= $row['upgrade_time_index'] )
			{
				if ( 1 < $row['upgrade_type_index'] )
				{
					$arr['upgrade_type_index'] = "<font color=red>置顶</font> ";
					$arr['upgrade_time_index'] = "<font color=red>首页置顶</font><br />至".date( "Y-m-d", $row['upgrade_time_index'] );
				}
				else
				{
					$arr['upgrade_type_index'] = "<font color=#585858>否</font>";
				}
			}
			else
			{
				$arr['upgrade_type_index'] = "<font color=#585858>否</font>";
				$arr['upgrade_time_index'] = "";
			}
			$information[] = $arr;
		}
		include( mymps_tpl( "information_list" ) );
		$idin = NULL;
	}
	else if ( $action == "edit" )
	{
		switch ( $do )
		{
			case "post" :
			require_once( MYMPS_INC."/upfile.fun.php" );
			mymps_check_upimage( "mymps_img_" );
			if ( empty( $cityid ) )
			{
				write_msg( "请选择发布所在分站！" );
			}
			$content = $mymps_global['cfg_post_editor'] == 1 ? $content : textarea_post_change( $content );
			$begintime = $timestamp;
			$activetime = $endtime ? intval( $endtime ) : "";
			$endtime = $endtime == 0 ? 0 : $endtime * 3600 * 24 + $begintime;
			$upgrade_type = intval( $upgrade_type );
			$upgrade_type_list = intval( $upgrade_type_list );
			$upgrade_type_index = intval( $upgrade_type_index );
			$upgrade_time = $upgrade_type == 1 ? "" : $upgrade_time * 3600 * 24 + $begintime;
			$upgrade_time_list = $upgrade_type == 1 ? "" : $upgrade_time_list * 3600 * 24 + $begintime;
			$upgrade_time_index = $upgrade_type_index == 1 ? "" : $upgrade_time_index * 3600 * 24 + $begintime;
			$mappoint = trim( $mappoint );
			if ( empty( $contact_who ) )
			{
				write_msg( "请填写联系人！" );
			}
			$sql = NULL;
			if ( is_array( $extra ) )
			{
				$modid = $db->getone( "SELECT modid FROM `".$db_mymps."category` WHERE catid = '{$catid}'" );
				if ( 1 < $modid )
				{
					foreach ( $extra as $k => $v )
					{
						$sql .= is_array( $v ) ? "`".$k."` = '".implode( ",", $v )."'," : "`".$k.( "` = '".$v."'," );
					}
					$sql = $sql ? substr( $sql, 0, -1 ) : NULL;
					if ( $sql )
					{
						$db->query( "UPDATE `".$db_mymps."information_{$modid}` SET {$sql} WHERE id = '{$id}'" );
						$sql = NULL;
					}
				}
			}
			$manage_pwd = $is_member == 0 && $manage_pwd ? "manage_pwd='".md5( $manage_pwd )."'," : "";
			$refreshtime = $refresh == 1 ? "begintime = '".$timestamp."'," : "begintime = '".strtotime( $begintimestr )."',";
			$userid = empty( $userid ) ? "" : "userid='".$userid."',";
			$d = $db->getrow( "SELECT catname,dir_typename FROM `".$db_mymps."category` WHERE catid = '{$catid}'" );
			$sql = "UPDATE `".$db_mymps."information` SET {$manage_pwd} {$refreshtime} {$userid} title = '{$title}',content = '{$content}',catid = '{$catid}',catname = '{$d['catname']}',dir_typename = '{$d['dir_typename']}', cityid = '{$cityid}', areaid = '{$areaid}', streetid = '{$streetid}', activetime = '{$activetime}', endtime = '{$endtime}', ismember = '{$ismember}' , info_level = '{$info_level}' , qq = '{$qq}' , email = '{$email}' , tel = '{$tel}' , contact_who = '{$contact_who}' , upgrade_type = '{$upgrade_type}' ,upgrade_type_list = '{$upgrade_type_list}' ,upgrade_type_index = '{$upgrade_type_index}' , upgrade_time = '{$upgrade_time}', upgrade_time_list = '{$upgrade_time_list}', upgrade_time_index = '{$upgrade_time_index}', ifred = '{$ifred}', ifbold = '{$ifbold}',mappoint = '{$mappoint}' WHERE id = '{$id}'";
			$db->query( $sql );
			if ( is_array( $_FILES ) )
			{
				$i = 0;
				for ( ;	$i < count( $_FILES );	++$i	)
				{
					$name_file = "mymps_img_".$i;
					if ( $_FILES[$name_file]['name'] )
					{
						$destination = "/information/".date( "Ym" )."/";
						$mymps_image = start_upload( $name_file, $destination, $mymps_global[cfg_upimg_watermark], $mymps_mymps[cfg_information_limit][width], $mymps_mymps[cfg_information_limit][height] );
						if ( $row = $db->getrow( "SELECT path,prepath FROM `".$db_mymps."info_img` WHERE infoid = '{$id}' AND image_id = '{$i}'" ) )
						{
							@unlink( @MYMPS_ROOT.@$row[path] );
							@unlink( @MYMPS_ROOT.@$row[prepath] );
							$db->query( "UPDATE `".$db_mymps."info_img` SET image_id = '{$i}' , path = '{$mymps_image['0']}' , prepath = '{$mymps_image['1']}' , uptime = '{$timestamp}' WHERE image_id = '{$i}' AND infoid = '{$id}'" );
						}
						else
						{
							$db->query( "INSERT INTO `".$db_mymps."info_img` (image_id,path,prepath,infoid,uptime) VALUES ('{$i}','{$mymps_image['0']}','{$mymps_image['1']}','{$id}','{$timestamp}')" );
						}
					}
				}
				if ( $mymps_image[1] )
				{
					$db->query( "UPDATE `".$db_mymps."information` SET img_path = '{$mymps_image['1']}' WHERE id = '{$id}'" );
				}
			}
			if ( is_array( $delinfoimg ) )
			{
				foreach ( $delinfoimg as $key => $val )
				{
					if ( $val == "on" )
					{
						$infoimgrow = $db->getrow( "SELECT id,path,prepath FROM `".$db_mymps."info_img` WHERE image_id = '{$key}' AND infoid = '{$id}'" );
						if ( $infoimgrow )
						{
							@unlink( @MYMPS_ROOT.@$infoimgrow['path'] );
							mymps_delete( "info_img", "WHERE id = '".$infoimgrow['id']."'" );
						}
						unset( $infoimgrow );
					}
				}
			}
			write_msg( "操作成功，您已经成功修改该信息！", "?action=edit&id=".$id );
			break;
			default :
			require_once( MYMPS_DATA."/info_lasttime.php" );
			require_once( MYMPS_DATA."/info.type.inc.php" );
			$post = is_member_info( $id, "admin" );
			$catid = $post['catid'];
			$areaid = $post['areaid'];
			$cat = $db->getrow( "SELECT a.if_upimg,a.if_mappoint,a.modid,b.catid FROM `".$db_mymps."category` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.parentid = b.catid WHERE a.catid = '{$catid}'" );
			if ( $mymps_global['cfg_post_editor'] == 1 )
			{
				$acontent = get_editor( "content", "information", $post[content], "100%", "400px" );
			}
			else
			{
				$acontent = "<textarea name=\"content\" style=\"width:100%;height:400px;\">".de_textarea_post_change( $post[content] )."</textarea>";
			}
			$now = $timestamp;
			$post['upgrade_time'] = $post['upgrade_time'] == 0 ? 0 : ( $post['upgrade_time'] - $post['begintime'] ) / 3600 / 24;
			$post['upgrade_time_list'] = $post['upgrade_time_list'] == 0 ? 0 : ( $post['upgrade_time_list'] - $post['begintime'] ) / 3600 / 24;
			$post['upgrade_time_index'] = $post['upgrade_time_index'] == 0 ? 0 : ( $post['upgrade_time_index'] - $post['begintime'] ) / 3600 / 24;
			$post['GetInfoLastTime'] = getinfolasttime( $post['activetime'] );
			$post['upgrade_type'] = getupgradetype( $post['upgrade_type'] );
			$post['upgrade_type_list'] = getupgradetypelist( $post['upgrade_type_list'] );
			$post['upgrade_type_index'] = getupgradetypeindex( $post['upgrade_type_index'] );
			$post['mymps_extra_value'] = return_category_info_options( $cat['modid'], $id );
			$post['upload_img'] = get_upload_image_edit( $cat['if_upimg'], $id, "MyMps" );
			$post['manage_pwd'] = $post['ismember'] == 1 ? "" : "<tr bgcolor=\"#f5fbff\"><td height=\"25\" width=\"19%\">管理密码</td><td><input type=\"text\" name=\"manage_pwd\" class=\"text\" />  若不修改请留空</td></tr>";
			$post['part'] = "edit";
			$post['submit'] = "修改";
			$here = "信息内容修改";
			include( mymps_tpl( "information_edit" ) );
			break;
		}
	}
	else if ( $action == "pm" )
	{
		if ( !is_array( $id ) || !$do_action )
		{
			write_msg( "您没有选中任何会话！" );
		}
		$id = !empty( $id ) ? join( ",", $id ) : 0;
		if ( empty( $id ) )
		{
			write_msg( "您没有选中任何一条信息记录" );
		}
		require_once( MYMPS_DATA."/pm_message.inc.php" );
		$here = "信息操作附加处理";
		$title = "您发布的 {title} 被管理员设置为 {action}";
		$msg = "可能原因： ".$msg;
		$msg .= $if_money == 1 ? "<br />金币变化：<b style=color:red>".$money_num."</b>" : "";
		include( mymps_tpl( "information_pm" ) );
	}
	else if ( strstr( $action, "level" ) )
	{
		require_once( MYMPS_MEMBER."/include/common.func.php" );
		$action = fileext( $action );
		$id = explode( ",", $id );
		if ( !is_array( $id ) )
		{
			write_msg( "您没有选中任何会话！" );
		}
		foreach ( $id as $k => $v )
		{
			$get_row = is_member_info( $v, "no_level_limit" );
			if ( $get_row['ismember'] == 1 )
			{
				$userid = $get_row['userid'];
				if ( $if_money == 1 )
				{
					$db->query( "UPDATE `".$db_mymps."member` SET money_own = money_own {$money_num} WHERE userid = '{$userid}'" );
				}
				if ( $if_pm == 1 )
				{
					$title = str_replace( "{title}", $get_row[title], $title );
					$title = str_replace( "{action}", $information_level[$action], $title );
					$result = sendpm( $admin_id, $userid, $title, $msg, 1 );
				}
			}
			$db->query( "UPDATE `".$db_mymps."information` SET info_level = '{$action}' WHERE id = '{$v}'" );
		}
		$id = empty( $id ) ? 0 : join( ",", $id );
		write_msg( "信息 ".$id." 状态转为 ".$information_level[$action]." 成功！", $url, "REcord" );
	}
}
if ( is_object( $db ) )
{
	$db->close( );
}
$mymps_global = $db = $db_mymps = $part = $idin = $rows_num = $page = $pages_num = $per_page = $per_screen = $startid = NULL;
?>
