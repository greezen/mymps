<?php

function custom( $flag = "", $js = "html" )
{
	global $db;
	global $db_mymps;
	global $jswizard_lists;
	global $jssettings;
	global $jscharset;
	global $mymps_global;
	global $charset;
	global $timestamp;
	if ( empty( $flag ) )
	{
		if ( $js == "js" )
		{
			exit( html2js( "Access Diened!" ) );
		}
		exit( "Access Diened!" );
	}
	$jswizard_lists = array( );
	$data = "";
	$allowflag = "";
	include( MYMPS_ROOT."/data/caches/jswizard_lists.php" );
	$jswizard_lists = $data;
	unset( $data );
	if ( !in_array( $flag, array_keys( $jswizard_lists ) ) )
	{
		exit( html2js( "NO flag exists!" ) );
	}
	require_once( MYMPS_ROOT."/include/cache.fun.php" );
	@include( MYMPS_ROOT."/data/caches/jswizard_settings.php" );
	$jssettings = $data;
	unset( $data );
	if ( empty( $jssettings['jsstatus'] ) )
	{
		exit( html2js( "<font color=red>The webmaster did not enable this feature.</font>" ) );
	}
	$nocache = empty( $jssettings['jscachelife'] ) ? TRUE : NULL;
	$jsrefdomains = isset( $jssettings['jsrefdomains'] ) ? $jssettings['jsrefdomains'] : preg_replace( "/([^\\:]+).*/", "\\1", isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : NULL );
	$REFERER = parse_url( $_SERVER['HTTP_REFERER'] );
	if ( $jsrefdomains && ( empty( $REFERER ) || !in_array( $REFERER['host'], explode( "\r\n", trim( $jsrefdomains ) ) ) ) )
	{
		if ( $js == "js" )
		{
			exit( html2js( "<font color=red>Referer restriction is taking effect.</font>" ) );
		}
		exit( "<font color=red>Referer restriction is taking effect.</font>" );
	}
	$cachefile = MYMPS_ROOT."/data/caches/custom_".$flag.".php";
	$expiration = NULL;
	@include( $cachefile );
	if ( !$expiration && $timestamp <= $expiration )
	{
		require_once( MYMPS_ROOT."/data/config.db.php" );
		require_once( MYMPS_ROOT."/include/db.class.php" );
		$customtag = customtag( $flag );
		$writedata = procdata( $customtag );
		if ( $js == "js" )
		{
			$datalist = procdata( "document.write(\"".$customtag."\");" );
		}
		else if ( $js == "html" )
		{
			$datalist = $writedata;
		}
		unset( $customtag );
		if ( !$nocache )
		{
			$writedata = "\$datalist = '".addcslashes( $writedata, "\\'" )."';";
			updatecache( $cachefile, $writedata );
		}
		if ( is_object( $db ) )
		{
			$db->close( );
		}
		$db = NULL;
		return $datalist;
	}
	if ( $js == "js" )
	{
		$datalist = procdata( "document.write(\"".$datalist."\");" );
	}
	return $datalist;
}

function customtag( $flag = "" )
{
	global $db;
	global $db_mymps;
	global $jswizard_lists;
	global $jssettings;
	global $jscharset;
	global $mymps_global;
	global $charset;
	global $timestamp;
	$parameter = $jswizard_lists[$flag]['parameter'];
	$customtype = $jswizard_lists[$flag]['customtype'];
	switch ( $customtype )
	{
		case "info" :
		$catid = is_array( $parameter['catid'] ) ? implode( "','", $parameter['catid'] ) : NULL;
		$cityid = is_array( $parameter['cityid'] ) ? implode( "','", $parameter['cityid'] ) : NULL;
		$newwindow = !empty( $parameter['newwindow'] ) ? $parameter['newwindow'] : 1;
		$items = !empty( $parameter['items'] ) ? intval( $parameter['items'] ) : 10;
		$maxlength = !empty( $parameter['maxlength'] ) ? intval( $parameter['maxlength'] ) : 50;
		$ids = !empty( $parameter['ids'] ) ? str_replace( ",", "','", trim( $parameter['ids'] ) ) : NULL;
		$keyword = !empty( $parameter['keyword'] ) ? $parameter['keyword'] : NULL;
		$special = is_array( $parameter['special'] ) ? $parameter['special'] : NULL;
		$orderby = !empty( $parameter['orderby'] ) ? $parameter['orderby'] == "views" ? "hit" : "begintime" : "begintime";
		$jstemplate = !empty( $parameter['jstemplate'] ) ? $parameter['jstemplate'] : "{title}<br />";
		$jscharset = !empty( $parameter['jscharset'] ) ? $parameter['jscharset'] : NULL;
		$target = $newwindow == 1 ? "target=_blank" : "target=_self";
		$jsdateformat = isset( $jssettings['jsdateformat'] ) ? $jssettings['jsdateformat'] : "Y-m-d";
		$datalist = array( );
		if ( $keyword )
		{
			if ( preg_match( "(AND|\\+|&|\\s)", $keyword ) && !preg_match( "(OR|\\|)", $keyword ) )
			{
				$andor = " AND ";
				$keywordsrch = "1";
				$keyword = preg_replace( "/( AND |&| )/is", "+", $keyword );
			}
			else
			{
				$andor = " OR ";
				$keywordsrch = "0";
				$keyword = preg_replace( "/( OR |\\|)/is", "+", $keyword );
			}
			$keyword = str_replace( "*", "%", addcslashes( $keyword, "%_" ) );
			foreach ( explode( "+", $keyword ) as $text )
			{
				$text = trim( $text );
				if ( $text )
				{
					$keywordsrch .= $andor;
					$keywordsrch .= "t.title LIKE '%".$text."%'";
				}
			}
			$keyword = " AND (".$keywordsrch.")";
		}
		else
		{
			$keyword = "";
		}
		require_once( MYMPS_ROOT."/data/info_special.inc.php" );
		break;
		default :
		$sql = ( $catid ? " AND t.catid IN ('".$catid."')" : "" ).$keyword.( $ids ? " AND t.id IN ('".$ids."')" : "" ).( $cityid ? " AND t.cityid IN ('".$cityid."')" : "" );
		if ( is_array( $special ) && $special != array( 0 => "1", 1 => "2", 2 => "3", 3 => "4", 4 => "5", 5 => "6", 6 => "7", 7 => "8", 8 => "9" ) )
		{

			foreach ( $special as $k => $v )
			{
				switch ( $v )
				{
					case 1 :
					$sql .= " AND t.upgrade_type = '2' AND t.upgrade_time > '\$timestamp'";
					break;
					case 2 :
					$sql .= " AND t.upgrade_type_list = '2' AND t.upgrade_time_list > '\$timestamp'";
					break;
					case 3 :
					$sql .= " AND t.upgrade_type_index = '2' AND t.upgrade_time_index > '\$timestamp'";
					break;
					case 4 :
					$sql .= " AND t.info_level = '0'";
					break;
					case 5 :
					$sql .= " AND t.info_level = '1'";
					break;
					case 6 :
					$sql .= " AND t.info_level = '2'";
					break;
					case 7 :
					$sql .= " AND t.ifred = '1'";
					break;
					case 8 :
					$sql .= " AND t.ifbold = '1'";
					break;
					case 9 :
					$sql .= " AND t.certify = '1'";
					break;
				}
			}
		}
		else
		{
			$sql .= " AND t.info_level > '0'";
		}
		$sqlfrom = ",t.catname,t.dir_typename FROM `".$db_mymps."information` AS t";
		$query = $db->query( "SELECT t.id,t.cityid,t.img_path,t.catid,t.title,t.content,t.userid,t.contact_who,t.ismember,t.begintime,t.hit,t.ifbold,t.ifred\r\n\t\t\t\t\t\t".$sqlfrom." WHERE 1\r\n\t\t\t\t\t\t{$sql}\r\n\t\t\t\t\t\tORDER BY t.{$orderby} DESC\r\n\t\t\t\t\t\tLIMIT 0,{$items};" );
		while ( $data = $db->fetchrow( $query ) )
		{
			$datalist[$data['id']]['catid'] = $data['catid'];
			$datalist[$data['id']]['catname'] = $data['catname'];
			$datalist[$data['id']]['caturl'] = rewrite( "category", array(
				"catid" => $data['catid'],
				"dir_typename" => $data['dir_typename'],
				"cityid" => $data['cityid']
				) );
			$datalist[$data['id']]['img_path'] = $data['img_path'];
			$datalist[$data['id']]['catnamelength'] = strlen( $datalist[$data['id']]['catname'] );
			$datalist[$data['id']]['title'] = isset( $data['title'] ) ? str_replace( "'", "&nbsp;", addslashes( $data['title'] ) ) : NULL;
			$datalist[$data['id']]['link'] = rewrite( "info", array(
				"id" => $data['id'],
				"dir_typename" => $data['dir_typename'],
				"cityid" => $data['cityid']
				) );
			$datalist[$data['id']]['begintime'] = date( $jsdateformat."", $data['begintime'] );
			$datalist[$data['id']]['hit'] = $data['hit'];
			$datalist[$data['id']]['ifbold'] = $data['ifbold'];
			$datalist[$data['id']]['ifred'] = $data['ifred'];
			$datalist[$data['id']]['introduce'] = str_replace( array( "'", "\n", "\r" ), array( "&nbsp;", "", "" ), addslashes( cutstr( mhtmlspecialchars( preg_replace( "/(\\[.+\\])/s", "", strip_tags( nl2br( $data['content'] ) ) ) ), 255 ) ) );
			if ( $data['userid'] && $data['ismember'] == 1 )
			{
				$datalist[$data['id']]['author'] = "<a href='".rewrite( "space", array(
					"user" => $data['userid']
					) )."' target='_blank'>".$data[userid]."</a>";
			}
			else
			{
				$datalist[$data['id']]['author'] = !empty( $data['contact_who'] ) ? $data['contact_who'] : "сн©м";
			}
		}
		$writedata = "";
		if ( !is_array( $datalist ) )
		{
			break;
		}
		foreach ( $datalist as $t => $val )
		{
			$SubjectStyles = "";
			$SubjectStyles .= " style='";
			$SubjectStyles .= $val['ifbold'] == 1 ? "font-weight: bold;" : NULL;
			$SubjectStyles .= $val['ifred'] == 1 ? "color: red;" : NULL;
			$SubjectStyles .= "'";
			$val['title'] = cutstr( $val['title'], $catnamelength ? $maxlength - $val['catnamelength'] : $maxlength );
			$replace['{link}'] = $val['link'];
			$replace['{title}'] = "<a title=".$val['title']." href='".$val['link']."' ".$SubjectStyles." ".$target.">".$val['title']."</a>";
			$replace['{title_nolink}'] = $val['title'];
			$replace['{catname}'] = "<a href='".$val['caturl']."'  ".$target.">".$val['catname']."</a>";
			$replace['{begintime}'] = $val['begintime'];
			$replace['{introduce}'] = $val['introduce'];
			$replace['{author}'] = $val['author'];
			$replace['{hit}'] = $val['hit'];
			$replace['{imgpath}'] = $mymps_global['SiteUrl'].( $val['img_path'] ? $val['img_path'] : "/images/nophoto.gif" );
			$writedata .= str_replace( array_keys( $replace ), $replace, $jstemplate );
		}
		break;
		case "news" :
		$catid = $parameter['catid'] ? $parameter['catid'] : NULL;
		$newwindow = !empty( $parameter['newwindow'] ) ? $parameter['newwindow'] : 1;
		$items = !empty( $parameter['items'] ) ? intval( $parameter['items'] ) : 10;
		$maxlength = !empty( $parameter['maxlength'] ) ? intval( $parameter['maxlength'] ) : 40;
		$special = $parameter['special'];
		$orderby = !empty( $parameter['orderby'] ) ? $parameter['orderby'] == "views" ? "hit" : "begintime" : "begintime";
		$jstemplate = !empty( $parameter['jstemplate'] ) ? $parameter['jstemplate'] : "<li>{title}</li>";
		$jscharset = !empty( $parameter['jscharset'] ) ? $parameter['jscharset'] : NULL;
		$target = $newwindow == 1 ? "target=_blank" : "target=_self";
		$jsdateformat = isset( $jssettings['jsdateformat'] ) ? $jssettings['jsdateformat'] : "Y-m-d";
		$if_img = $special[0];
		$if_commend = $special[1];
		$datalist = mymps_get_news( $items, $catid, $if_img, strexists( $jstemplate, "{catname}" ) ? 1 : 0, $if_commend, $orderby );
		$writedata = "";
		if ( !is_array( $datalist ) )
		{
			break;
		}
		foreach ( $datalist as $t => $val )
		{
			$SubjectStyles = "";
			$SubjectStyles .= " style='";
			$SubjectStyles .= $val['is_commend'] == 1 ? "font-weight: bold;" : NULL;
			$SubjectStyles .= $val['is_commend'] == 1 ? "color: red;" : NULL;
			$SubjectStyles .= "'";
			$val['title'] = cutstr( $val['title'], $maxlength );
			$replace['{link}'] = $val['uri'];
			$replace['{title}'] = "<a title=".$val['title']." href='".$val['uri']."' ".$SubjectStyles." ".$target.">".$val['title']."</a>";
			$replace['{title_nolink}'] = $val['title'];
			$replace['{catname}'] = "<a href='".$val['caturi']."'  ".$target.">".$val['catname']."</a>";
			$replace['{begintime}'] = date( $jsdateformat."", $val['begintime'] );
			$replace['{introduce}'] = str_replace( array( "'", "\n", "\r" ), array( "&nbsp;", "", "" ), addslashes( cutstr( mhtmlspecialchars( preg_replace( "/(\\[.+\\])/s", "", strip_tags( nl2br( $val['content'] ) ) ) ), 255 ) ) );
			$replace['{hit}'] = $val['hit'];
			$replace['{imgpath}'] = $mymps_global['SiteUrl'].( $val['imgpath'] ? $val['imgpath'] : "/images/nophoto.gif" );
			$writedata .= str_replace( array_keys( $replace ), $replace, $jstemplate );
		}
		break;
		case "store" :
		$catid = $parameter['catid'] ? $parameter['catid'] : NULL;
		$newwindow = !empty( $parameter['newwindow'] ) ? $parameter['newwindow'] : 1;
		$items = !empty( $parameter['items'] ) ? intval( $parameter['items'] ) : 10;
		$maxlength = !empty( $parameter['maxlength'] ) ? intval( $parameter['maxlength'] ) : 40;
		$special = $parameter['special'];
		$cityid = $parameter['cityid'];
		$levelid = $parameter['levelid'];
		$orderby = !empty( $parameter['orderby'] ) ? $parameter['orderby'] == "dateline" ? 0 : 1 : 0;
		$jstemplate = !empty( $parameter['jstemplate'] ) ? $parameter['jstemplate'] : "<li>{title}</li>";
		$jscharset = !empty( $parameter['jscharset'] ) ? $parameter['jscharset'] : NULL;
		$target = $newwindow == 1 ? "target=_blank" : "target=_self";
		$jsdateformat = isset( $jssettings['jsdateformat'] ) ? $jssettings['jsdateformat'] : "Y-m-d";
		$if_certify = $special[0];
		$ifindex = $special[1];
		$iflist = $special[2];
		$datalist = mymps_get_members( $items, $levelid, $orderby, 1, $if_certify, $ifindex, $iflist, $cityid, $catid );
		$writedata = "";
		if ( !is_array( $datalist ) )
		{
			break;
		}
		foreach ( $datalist as $t => $val )
		{
			$val['tname'] = cutstr( $val['tname'], $maxlength );
			$replace['{link}'] = $val['uri'];
			$replace['{tname}'] = "<a title=".$val['tname']." href='".$val['uri']."' ".$target.">".$val['tname']."</a>";
			$replace['{tname_nolink}'] = $val['tname'];
			$replace['{jointime}'] = date( $jsdateformat."", $val['jointime'] );
			$replace['{introduce}'] = str_replace( array( "'", "\n", "\r" ), array( "&nbsp;", "", "" ), addslashes( cutstr( mhtmlspecialchars( preg_replace( "/(\\[.+\\])/s", "", strip_tags( nl2br( $val['content'] ) ) ) ), 255 ) ) );
			$replace['{hit}'] = $val['hit'];
			$replace['{qq}'] = $val['qq'];
			$replace['{tel}'] = $val['tel'];
			$replace['{address}'] = $val['address'];
			$replace['{userid}'] = $val['userid'];
			$replace['{prelogo}'] = $mymps_global['SiteUrl'].$val['prelogo'];
			$writedata .= str_replace( array_keys( $replace ), $replace, $jstemplate );
		}
		break;
		case "goods" :
		$catid = $parameter['catid'] ? $parameter['catid'] : NULL;
		$newwindow = !empty( $parameter['newwindow'] ) ? $parameter['newwindow'] : 1;
		$items = !empty( $parameter['items'] ) ? intval( $parameter['items'] ) : 10;
		$maxlength = !empty( $parameter['maxlength'] ) ? intval( $parameter['maxlength'] ) : 40;
		$special = $parameter['special'];
		$cityid = $parameter['cityid'];
		$orderby = !empty( $parameter['orderby'] ) ? $parameter['orderby'] == "dateline" ? 0 : 1 : 0;
		$jstemplate = !empty( $parameter['jstemplate'] ) ? $parameter['jstemplate'] : "<li>{title}</li>";
		$jscharset = !empty( $parameter['jscharset'] ) ? $parameter['jscharset'] : NULL;
		$target = $newwindow == 1 ? "target=_blank" : "target=_self";
		$jsdateformat = isset( $jssettings['jsdateformat'] ) ? $jssettings['jsdateformat'] : "Y-m-d";
		if ( $special[0] == 1 )
		{
			$shuxing = "tuijian";
		}
		else if ( $special[1] == 1 )
		{
			$shuxing = "remai";
		}
		else if ( $special[2] == 1 )
		{
			$shuxing = "cuxiao";
		}
		$datalist = mymps_get_goods( $items, 1, $shuxing, $catid, $cityid, $orderby );
		$writedata = "";
		if ( !is_array( $datalist ) )
		{
			break;
		}
		foreach ( $datalist as $t => $val )
		{
			$val['uri'] = $mymps_global['SiteUrl']."/".$val['uri'];
			$val['goodsname'] = cutstr( $val['goodsname'], $maxlength );
			$replace['{link}'] = $val['uri'];
			$replace['{goodsname}'] = "<a title=".$val['goodsname']." href='".$val['uri']."' ".$target.">".$val['goodsname']."</a>";
			$replace['{goodsname_nolink}'] = $val['goodsname'];
			$replace['{jointime}'] = date( $jsdateformat."", $val['jointime'] );
			$replace['{introduce}'] = str_replace( array( "'", "\n", "\r" ), array( "&nbsp;", "", "" ), addslashes( cutstr( mhtmlspecialchars( preg_replace( "/(\\[.+\\])/s", "", strip_tags( nl2br( $val['content'] ) ) ) ), 255 ) ) );
			$replace['{oldprice}'] = $val['oldprice'];
			$replace['{nowprice}'] = $val['nowprice'];
			$replace['{userid}'] = $val['userid'];
			$replace['{picture}'] = $mymps_global['SiteUrl'].$val['picture'];
			$replace['{prepicture}'] = $mymps_global['SiteUrl'].$val['prepicture'];
			$writedata .= str_replace( array_keys( $replace ), $replace, $jstemplate );
		}
	}
	unset( $mymps_global );
	return parsenode( $writedata );
}

function parsenode( $data )
{
	global $jstemplate;
	if ( $jstemplate )
	{
		$data = preg_replace( "/\\[node\\](.+?)\\[\\/node\\]/is", $data, $jstemplate, 1 );
		$data = preg_replace( "/\\[node\\](.+?)\\[\\/node\\]/is", "", $data );
	}
	return $data;
}

function procdata( $data )
{
	global $jscharset;
	global $charset;
	if ( $jscharset && strtoupper( $charset ) == "GBK" )
	{
		$data = iconv( "GBK", "UTF-8", $data );
	}
	return $data;
}

function updatecache( $cachefile, $data = "" )
{
	global $timestamp;
	global $jscachelife;
	if ( !( $fp = @fopen( $cachefile, "wb" ) ) )
	{
		exit( "document.write(\"Unable to write to cache file!<br />Please chmod ./data/caches to 777 and try again.\");" );
	}
	$fp = @fopen( $cachefile, "wb" );
	$cachedata = "if(!defined('IN_MYMPS')) exit('Access Denied');\n\$expiration = '".( $timestamp + $jscachelife )."';\n".$data."\n";
	@fwrite( $fp, "<?php\n//Mymps cache file, DO NOT modify me!\n//Created: ".@date( "M j, Y, G:i" )."\n//Identify: ".@md5( basename( $cachefile ).$cachedata ).( "\n\n".$cachedata."?>" ) );
	@fclose( $fp );
}

?>
