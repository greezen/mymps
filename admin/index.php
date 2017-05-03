<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

error_reporting( E_ALL ^ E_NOTICE );
$do = isset( $_GET['do'] ) ? htmlspecialchars( trim( $_GET['do'] ) ) : "login";
$go = isset( $_GET['go'] ) ? htmlspecialchars( trim( $_GET['go'] ) ) : "mymps_right";
$part = isset( $_GET['part'] ) ? htmlspecialchars( trim( $_GET['part'] ) ) : "default";
if ( $do == "login" )
{
	define( "IN_MYMPS", true );
	include( dirname( __FILE__ )."/../include/global.php" );
	require_once( MYMPS_DATA."/config.php" );
	require_once( MYMPS_DATA."/config.db.php" );
	require_once( MYMPS_INC."/db.class.php" );
	require_once( MYMPS_INC."/admin.class.php" );
	@include( MYMPS_DATA."/caches/authcodesettings.php" );
	$authcodesettings = $data;
	$data = NULL;
	$url = trim( $url );
	if ( $part == "chk" )
	{
		define( CURSCRIPT, "admin_login" );
		$url = $url ? $url : "index.php?do=manage&go=".$go;
		if ( $authcodesettings['adminlogin'] == 1 && !( $randcode = mymps_chk_randcode( $checkcode ) ) )
		{
			write_msg( "验证码输入错误，请返回重新输入" );
			exit( );
		}
		$username = trim( $username );
		$password = trim( $password );
		$pubdate = $timestamp ? $timestamp : time( );
		$ip = getip( );
		$row = $db->getrow( "SELECT id,userid,cityid,pwd,uname FROM ".$db_mymps."admin WHERE userid='".$username."' AND pwd='".md5( $password )."'" );
		if ( $row )
		{
			$admin_id = $row['userid'];
			$admin_name = $row['uname'];
			$admin_cityid = $row['cityid'];
			$mymps_admin->mymps_admin_login( $admin_id, $admin_name, $admin_cityid );
			$db->query( "UPDATE ".$db_mymps."admin SET loginip='".getip( ).( "',logintime='".$timestamp."' WHERE userid='{$row['userid']}'" ) );
			$db->query( "INSERT INTO `".$db_mymps."admin_record_login` (id,adminid,adminpwd,pubdate,ip,result) VALUES ('','{$username}','".md5( $password ).( "','".$pubdate."','{$ip}','1')" ) );
			write_msg( $admin_name."您已成功登陆系统管理中心", $url );
		}
		else
		{
			$db->query( "INSERT INTO `".$db_mymps."admin_record_login` (id,adminid,adminpwd,pubdate,ip,result) VALUES ('','{$username}','{$password}','{$pubdate}','{$ip}','0')" );
			write_msg( "您输入的用户名或密码错误，请返回重新输入" );
		}
	}
	else if ( $part == "out" )
	{
		define( "IN_MYMPS", true );
		$mymps_admin->mymps_admin_logout( );
		write_msg( "您已经安全退出系统管理中心", "index.php" );
	}
	else if ( $part == "default" )
	{
		define( "IN_MYMPS", true );
		$url = trim($url);
		if ( $mymps_admin->mymps_admin_chk_getinfo( ) )
		{
			write_msg( "", "index.php?do=manage" );
		}
		else
		{
			include( mymps_tpl( "login" ) );
		}
	}
	else
	{
		define( "IN_MYMPS", true );
		write_msg( "", "index.php?do=manage" );
	}
}
else if ( $do == "manage" )
{
	require_once( dirname( __FILE__ )."/global.php" );
	if ( $part == "left" )
	{
		require_once( dirname( __FILE__ )."/include/".( $admin_cityid ? "mymps.citymenu.inc.php" : "mymps.menu.inc.php" ) );
		$part = $part ? $part : "info";
		$mymps_admin_menu = mymps_admin_menu( "left" );
		include( mymps_tpl( "admin_left" ) );
	}
	else if ( $part == "default" )
	{
		include( mymps_tpl( "admin_default" ) );
	}
	else if ( $part == "top" )
	{
		require_once( MYMPS_INC."/db.class.php" );
		require_once( dirname( __FILE__ )."/include/".( $admin_cityid ? "mymps.citymenu.inc.php" : "mymps.menu.inc.php" ) );
		$mymps_admin_menu = mymps_admin_menu( "top" );
		$admindir = getcwdol( );
		$width = $admin_cityid ? "575" : "670";
		if ( $admin_cityid )
		{
			$www = get_city_caches( $admin_cityid );
			$www = $www['domain'];
		}
		else
		{
			$www = "../";
		}
		$admin = get_admin_info( );
		include( mymps_tpl( "admin_top" ) );
	}
	else if ( $part == "right" )
	{
		require_once( MYMPS_INC."/db.class.php" );
		require_once( MYMPS_DATA."/config.inc.php" );
		require_once( dirname( __FILE__ ).( $admin_cityid ? "/include/mymps.citycount.inc.php" : "/include/mymps.count.inc.php" ) );
		foreach ( $ele as $w => $v )
		{
			$mymps_count_str .= $w == "siteabout" ? "<div class=\"clear\"></div>" : "";
			$mymps_count_str .= "<div class=\"countsquare\">\r\n\t\t\t<div class=\"ab\">\r\n\t\t\t";
			foreach ( $element[$w] as $k => $u )
			{
				$mymps_count_str .= "<div class=\"b\">";
				$mymps_count_str .= $u[where] ? "<a href=\"#\" onclick=\"parent.framRight.location='".$u['url']."';\">".$k."<br><div class=\"c\">".mymps_count( $u[table], $u[where] )."</div></a>" : "<a href=\"#\" onclick=\"parent.framRight.location='".$u['url']."';\">".$k."<br><div class=\"c\">".mymps_count( $u[table] )."</div></a>";
				$mymps_count_str .= "</div>";
			}
			$mymps_count_str .= "</div>\r\n\t\t\t<div class=\"a\">".$v."</div>\r\n\t\t\t</div>";
		}
		$gd_info = @gd_info( );
		$gd_version = is_array( $gd_info ) ? $gd_info['GD Version'] : "<font color=red>不支持GD库</font>";
		$cfg_if_tpledit = $mymps_mymps[cfg_if_tpledit] == 0 ? "<font color=green>关闭</font>" : "<font color=red>开启</font>";
		$if_del_install = !is_file( MYMPS_ROOT."/install/index.php" ) ? "<font color=green>已删除</font>" : "<font color=red>未删除</font>";
		$Register_Globals = ini_get( "Register_Globals" ) ? "on" : "off";
		$Magic_Quotes_Gpc = MAGIC_QUOTES_GPC ? "on" : "off";
		$expose_php = ini_get( "expose_php" ) ? "on" : "off";
		$cur_dir = getcwdol( );
		$cur_dir = $cur_dir == "/admin" ? "<font color=red title=不建议使用admin作为目录名>/admin</font>" : "<font color=green>".$cur_dir."</font>";
		$latestbackup = $db->getone( "SELECT value FROM `".$db_mymps."config` WHERE description = 'latestbackup' AND type = 'database'" );
		$parttime = round( ( 0 < $latestbackup ? $timestamp - $latestbackup : 0 ) / 86400 );
		if ( !$latestbackup )
		{
			$message = "<font color=red>您尚未备份过系统全部数据</font>";
		}
		else if ( 14 < $parttime )
		{
			$message = "<font color=red>您已经超过两周没有备份系统全部数据了</font>";
		}
		else if ( $parttime == 0 )
		{
			$message = "<font color=green>您今天已经备份过全部数据</font>";
		}
		else
		{
			$message = "您在 <font color=green>".$parttime."</font> 天前备份过系统数据，上次备份：<font color=green>".gettime( $latestbackup )."</font>";
		}
		$message .= "，<a href=\"database.php?part=backup\" style=\"text-decoration:underline\">点此备份系统数据</a>";
		$welcome['数据统计'] = $mymps_count_str;
		$welcome['常用操作'] = "<div><span><input value=\"发分类信息\" onclick=\"window.open('../".$mymps_global[cfg_postfile]."'); target='_blank'\" type=\"button\" class=\"mymps large\"></span><span><input value=\"清除缓存\" onclick=\"location.href='config.php?part=cache_sys&return_url=".urlencode( "index.php?do=manage&part=right" )."'\" type=\"button\" class=\"mymps large\"></span><span><input value=\"系统优化\" onclick=\"location.href='optimise.php'\" type=\"button\" class=\"mymps large\"></span><span><input value=\"备份数据库\" onclick=\"location.href='database.php?part=backup'\" type=\"button\" class=\"mymps large\"></span></div>";
		$welcome['快捷操作'] = "<div class=\"mainnav\">\r\n\t\t<ul>\r\n\t\t<li><a href=\"".$mymps_global[SiteUrl]."\" target=\"_blank\"><img border=\"0\" src=\"template/images/default/home.gif\" />网站首页</a></li>\r\n\t\t<li><a href=\"#\" onclick=\"parent.framRight.location='member.php'\"><img border=\"0\" src=\"template/images/default/user.png\" alt=\"审核注册\" />审核注册</a></li>\r\n\t\t<li><a href=\"#\" onclick=\"parent.framRight.location='announce.php?part=add'\"><img border=\"0\" src=\"template/images/default/tpc.png\" alt=\"审核主题\" />发布公告</a></li>\r\n\t\t<li><a href=\"#\" onclick=\"parent.framRight.location='information.php'\"><img border=\"0\" src=\"template/images/default/post.png\"/>分类信息</a></li>\r\n\t\t<li><a href=\"#\" onclick=\"parent.framRight.location='friendlink.php'\"><img border=\"0\" src=\"template/images/default/share.png\" />审核链接</a></li>\r\n\t\t</ul>\r\n\t\t</div>";
		if ( !$admin_cityid )
		{
			$welcome['安全建议'] = "<span>在线编辑模板功能</span> 当前：".$cfg_if_tpledit."。建议您只有在十分必要的时候才开启它。请修改 /data/config.inc.php 关闭此功能<br />\r\n\t\t<span>系统 install目录</span> 当前：".$if_del_install."。为防止站外人员利用，建议您安装完成后，删除该目录<br />\r\n\t\t<span>系统管理目录</span> 当前：".$cur_dir."。建议您安装完成后，修改目录名（可直接修改）。<br />\r\n\t\t<span>数据安全</span>".$message;
			$welcome['服务器相关'] = "<div><span>服务器环境:</span>".$_SERVER['SERVER_SOFTWARE']."</div>\r\n\t\t<div><span>服务器系统:</span>".PHP_OS."</div>\r\n\t\t<div><span>当前时间:</span>".gettime( $timestamp )." ".date( "星期N", $timestamp )."</div>\r\n\t\t<div><span>PHP程式版本:</span>".PHP_VERSION."</div>\r\n\t\t<div><span>Register_Globals:</span>".$Register_Globals." &nbsp;&nbsp;<font color=red>[荐off]</font></div>\r\n\t\t<div><span>Magic_Quotes_Gpc:</span>".$Magic_Quotes_Gpc." &nbsp;&nbsp;<font color=red>[荐on]</font></div>\r\n\t\t<div><span>expose_php:</span>".$expose_php." &nbsp;&nbsp;<font color=red>[荐off]</font></div>\r\n\t\t<div><span>MYSQL版本:</span>".$db->version( )."</div>\r\n\t\t<div><span>mymps目录: </span>".MYMPS_ROOT."</div>\r\n\t\t<div><span>使用域名: </span>".$_SERVER['SERVER_NAME']."</div>\r\n\t\t<div><span>脚本超时时间：</span>".ini_get( "max_execution_time" )."</div>\r\n\t\t<div><span>附件上传上限</span>".ini_get( "upload_max_filesize" )."</div>\r\n\t\t<div><span>GD库版本</span>".$gd_version."</div>\r\n\t\t<div><span>检测文件读写权限</span><a href='javascript:setbg(\"检测文件读写权限\",305,380,\"../box.php?part=sp_testdirs\")' class=\"icon_open\" id=\"spanmymsg\" >点此检测</a>";
		}
		foreach ( $welcome as $k => $value )
		{
			$mymps_welcome_str .= "<tr bgcolor=\"#f5fbff\"><td width=\"15\" bgcolor=\"#F6FBFF\" style=\"\">".$k."</td><td bgcolor=\"white\" style=\"padding:15px;\" class=\"other\">".$value."</td></tr>";
		}
		$here = "系统管理首页";
		mylicense( "imayang.com" );
		include( mymps_tpl( "inc_head" ) );
		include( mymps_tpl( "admin_index" ) );
		unset( $ele );
		unset( $element );
		echo mymps_admin_tpl_global_foot( );
	}
}
else if ( $do == "power" )
{
	require_once( dirname( __FILE__ )."/global.php" );
	require_once( MYMPS_INC."/member.class.php" );
	$s_uid = trim($userid);
	$s_pwd = trim($userid);
	$member_log->in( $s_uid, $s_pwd, "off", $url );
}
else
{
	define( "IN_MYMPS", true );
	write_msg( "未知错误，请重新登录后台操作", "index.php?do=login&part=out" );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
