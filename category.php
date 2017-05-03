<?php

define( "IN_SMT", true );
define( "CURSCRIPT", "category" );
define( "IN_MYMPS", true );
require_once( dirname( __FILE__ )."/include/global.php" );
require_once( MYMPS_DATA."/config.php" );
require_once( MYMPS_DATA."/config.db.php" );
require_once( MYMPS_INC."/db.class.php" );
$catid = isset( $catid ) ? intval( $catid ) : 0;
$cityid = isset( $cityid ) ? intval( $cityid ) : 0;
$areaid = isset( $areaid ) ? intval( $areaid ) : 0;
$streetid = isset( $streetid ) ? intval( $streetid ) : 0;
$page = isset( $page ) ? intval( $page ) : 1;
ifsiteopen( );
runcron( );
$seo = $seo ? $seo : get_seoset( );
$rewrite = $seo['seo_force_category'];
if ( $Catid && $rewrite == "rewrite_py" )
{
	$detail = explode( "-", $Catid );
	$dir_typename = $detail[0];
	$cat_dir = array_flip( get_category_dir( ) );
	$catid = $cat_dir[$dir_typename];
	if ( $detail[1] )
	{
		for ($i = 1; $i < count( $detail ); ++$i )
		{
			$GLOBALS['_GET'][$detail[$i]] = $$detail[$i] = str_replace( array( "#@#", "#!#" ), array( "-", "/" ), $detail[++$i] );
		}
		extract( $_GET );
	}
	$cat_dir = $Catid = $detail = NULL;
}
else if ( $CAtid && $rewrite == "rewrite" )
{
	$detail = explode( "-", $CAtid );
	$catid = $detail[1];
	if ( $detail[2] )
	{
		for ($i = 2; $i < count( $detail ); ++$i )
		{
			$GLOBALS['_GET'][$detail[$i]] = $$detail[$i] = str_replace( array( "#@#", "#!#" ), array( "-", "/" ), $detail[++$i] );
		}
		extract( $_GET );
	}
	$CAtid = $detail = NULL;
}
if ( !( $cat = get_cat_info( $catid ) ) )
{
	write_msg( "您所指定的栏目不存在或者已被删除！", $mymps_global['SiteUrl'] );
}
$cache = get_cache_config( );
if ( 1 < $page )
{
	$cache['list']['time'] = false;
}
$sq = $s = "";
$allow_identifier = allow_identifier( );
$allow_identifier = $allow_identifier[$cat['modid']]['identifier'];
$allow_identifier = is_array( $allow_identifier ) ? $allow_identifier : array( );
$allow_identifiers = $rewrite == "rewrite_py" ? array_merge( array( "areaid", "streetid" ), $allow_identifier ) : array_merge( array( "catid", "areaid", "streetid" ), $allow_identifier );
if ( 1 < $cat['modid'] )
{
	$s = "";
	foreach ( $$_request as $key => $val )
	{
		if ( !in_array( $key, $allow_identifier ) && empty( $key ) )
		{
			$val = explode( "~", $val );
			if ( $val[1] )
			{
				$sq .= " AND g.`".$key."` <= '{$val['1']}'  AND g.`{$key}` >= '{$val['0']}'";
			}
			else if ( $val[0] && isset( $val[1] ) )
			{
				$sq .= " AND g.`".$key."` >= '{$val['0']}'";
			}
			else
			{
				$sq .= " AND g.`".$key."` = '{$val['0']}' ";
			}
			$s = " LEFT JOIN `".$db_mymps."information_{$cat['modid']}` AS g ON a.id = g.id";
			$cache['list']['time'] = false;
		}
	}
}
require_once( MYMPS_INC."/cachepages.class.php" );
$cachetime = $cache['list']['time'];
$cachepages = new cachepages( $cache['list']['time'], "list_".$catid."_".$cityid."_".$areaid."_".$streetid );
$cachepages->cachecheck( );
unset( $cache );
$cat['caturi'] = rewrite( "category", array(
	"catid" => $catid,
	"dir_typename" => $cat['dir_typename']
	) );
$city = get_city_caches( $cityid );
if ( $mymps_global['cfg_independency'] && $cityid )
{
	$maincity = get_city_caches( 0 );
	$independency = explode( ",", $mymps_global['cfg_independency'] );
	$independency = is_array( $independency ) ? $independency : array( );
	if ( in_array( "friendlink", $independency ) )
	{
		$city['flink'] = empty( $city['flink'] ) ? $maincity['flink'] : $city['flink'];
	}
	if ( in_array( "advertisement", $independency ) )
	{
		$city['advertisement'] = empty( $city['advertisement'] ) ? $maincity['advertisement'] : $city['advertisement'];
	}
	$maincity = NULL;
}
$cat['title'] = str_replace( "{city}", $city['cityname'], $cat['title'] );
$cat['keywords'] = str_replace( "{city}", $city['cityname'], $cat['keywords'] );
$cat['keywords'] = $cat['keywords'] ? $cat['keywords'] : $city['cityname'].$cat['catname']."信息";
$cat['description'] = str_replace( "{city}", $city['cityname'], $cat['description'] );
$cat['description'] = $cat['description'] ? $cat['description'] : $city['cityname'].$cat['catname']."频道为您提供{$city['cityname']}{$cat['catname']}信息，在此有大量{$city['cityname']}{$cat['catname']}信息供您选择，您可以免费查看和发布{$city['cityname']}{$cat['catname']}信息。";
$mymps_extra_model = mod_identifier( );
$mymps_extra_model = $mymps_extra_model[$cat['modid']];
$mymps_extra_model = is_array( $mymps_extra_model ) ? $mymps_extra_model : array( );
$page_title_extra .= $city['area'][$areaid]['areaname'].$city['area'][$areaid]['street'][$streetid]['streetname'];
$cat_list = get_categories_tree( $catid );
$where .= " WHERE ".get_children( $catid );
$where .= $sq ? $sq : "";
$where .= " AND (a.info_level = 1 OR a.info_level = 2)";
$where .= empty( $city['cityid'] ) ? "" : " AND a.cityid = '".$city['cityid']."'";
$where .= empty( $areaid ) ? "" : " AND a.areaid = '".$areaid."'";
$where .= empty( $streetid ) ? "" : " AND a.streetid = '".$streetid."'";
$orderby = $cat['parentid'] == 0 ? " ORDER BY a.upgrade_type DESC,a.begintime DESC" : " ORDER BY a.upgrade_type_list DESC,a.begintime DESC";
$param = setparam( $allow_identifiers, $rewrite, "category-", $city['domain'].$seo['seo_htmldir'].$cat['html_dir'] );
$rows_num = $db->getone( "SELECT COUNT(a.id) FROM `".$db_mymps."information` AS a {$s} {$where}" );
$idin = get_page_idin( "id", "SELECT a.id FROM `".$db_mymps."information` AS a {$s}{$where}{$orderby}", $mymps_global['cfg_list_page_line'] );
$sql = "SELECT a.id,a.title,a.cityid,a.userid,a.contact_who,a.content,a.img_path,a.img_count,a.upgrade_type,a.upgrade_type_list,a.upgrade_time,a.upgrade_time_list,a.begintime,a.endtime,a.info_level,a.certify,a.ifred,a.ifbold,a.dir_typename,b.areaname FROM ".$db_mymps."information AS a LEFT JOIN `{$db_mymps}area` AS b ON a.areaid = b.areaid WHERE a.id IN ({$idin}) {$orderby}";
$info_list = array( );
$page1 = $idin ? $db->getall( $sql ) : array( );
foreach ( $page1 as $key => $val )
{
	$infolist['id'] = $val['id'];
	$infolist['begintime'] = $val['begintime'];
	$infolist['title'] = $val['title'];
	$infolist['ifred'] = $val['ifred'];
	$infolist['ifbold'] = $val['ifbold'];
	$infolist['img_count'] = $val['img_count'];
	$infolist['content'] = clear_html( $val['content'] );
	$infolist['areaname'] = $val['areaname'];
	$infolist['poster'] = !empty( $val['userid'] ) ? "<a target=\"black\" href=".rewrite( "space", array("user" => $val['userid']) ).">".$val['userid']."</a>" : $val['contact_who'] ? $val['contact_who'] : "游客";
	$infolist['img_path'] = $val['img_path'];
	$infolist['uri'] = $cityid ? rewrite( "info", array("id" => $val['id'],"dir_typename" => $val['dir_typename'],"domain" => $city['domain']) ) : rewrite( "info", array("id" => $val['id'],"dir_typename" => $val['dir_typename'],"cityid" => $val['cityid']) );
	$infolist['info_level'] = $val['info_level'];
	$infolist['upgrade_type'] = !$cat['parentid'] ? $val['upgrade_type'] : $val['upgrade_type_list'];
	$infolist['certify'] = $val['certify'];
	$info_list[$val['id']] = $infolist;
	$ids = true;
}
$idin = $ids ? " AND a.id IN (".$idin.") " : "";
$pageline = NULL;
$pageview = page2( $rewrite );
$advertisement = get_advertisement( "category" );
$adveritems = $city['advertisement'];
if ( $adveritems )
{
	$advertisement['type'] = $advertisement['all'] ? is_array( $advertisement[$catid]['type'] ) ? array_merge( $advertisement['all']['type'], $advertisement[$catid]['type'] ) : $advertisement['all']['type'] : $advertisement[$catid]['type'];
}
switch ( $rewrite )
{
	case "rewrite" :
	foreach ( $mymps_extra_model as $key => $val )
	{
		if ( is_array( $val['list'] ) )
		{
			foreach ( $val['list'] as $k => $v )
			{
				$mymps_extra_model[$key]['list'][$k]['uri'] = "category";
				foreach ( $allow_identifiers as $keys )
				{
					if ( $v['identifier'] == $keys )
					{
						$mymps_extra_model[$key]['list'][$k]['uri'] .= $v[id] ? "-".$keys."-".$v[id] : "";
					}
					else
					{
						$mymps_extra_model[$key]['list'][$k]['uri'] .= $$keys ? "-".$keys."-".$$keys : "";
					}
				}
				$mymps_extra_model[$key]['list'][$k]['uri'] .= ".html";
				if ( $v['id'] == $$v['identifier'] )
				{
					$mymps_extra_model[$key]['list'][$k]['select'] .= "1";
					$page_title_extra .= $v[name] != "不限" ? $v[name] : "";
				}
				else
				{
					$mymps_extra_model[$key]['list'][$k]['select'] .= "0";
				}
			}
		}
	}
	if ( !$city['cityid'] )
	{
		break;
	}
	$area_list = $city['area'];
	if ( $areaid )
	{
		$street_list = $city['area'][$areaid]['street'];
		if ( $street_list && is_array( $street_list ) )
		{
			foreach ( $street_list as $key => $val )
			{
				$street_list[$key]['uri'] = "category";
				foreach ( $allow_identifiers as $keys )
				{
					if ( $keys == "streetid" )
					{
						$street_list[$key]['uri'] .= $val['streetid'] ? "-".$keys."-".$val[streetid] : "";
					}
					else
					{
						$street_list[$key]['uri'] .= $$keys ? "-".$keys."-".$$keys : "";
					}
				}
				$street_list[$key]['uri'] .= ".html";
				$street_list[$key]['select'] = $val['streetid'] == $streetid ? "1" : 0;
			}
		}
	}
	if ( !is_array( $area_list ) )
	{
		break;
	}
	$streetid = "";
	$area_list = array_merge( array(
		"0" => array( "areaid" => "0", "areaname" => "不限" )
		), $area_list );
	foreach ( $area_list as $key => $val )
	{
		$area_list[$key]['uri'] = "category";
		foreach ( $allow_identifiers as $keys )
		{
			if ( $keys == "areaid" )
			{
				$area_list[$key]['uri'] .= $val['areaid'] ? "-".$keys."-".$val[areaid] : "";
			}
			else
			{
				$area_list[$key]['uri'] .= $$keys ? "-".$keys."-".$$keys : "";
			}
		}
		$area_list[$key]['uri'] .= ".html";
		$area_list[$key]['select'] = $val['areaid'] == $areaid ? "1" : 0;
	}
	break;
	case "rewrite_py" :
	foreach ( $mymps_extra_model as $key => $val )
	{
		if ( is_array( $val['list'] ) )
		{
			foreach ( $val['list'] as $k => $v )
			{
				$mymps_extra_model[$key]['list'][$k]['uri'] = $dir_typename;
				foreach ( $allow_identifiers as $keys )
				{
					if ( $v['identifier'] == $keys )
					{
						$mymps_extra_model[$key]['list'][$k]['uri'] .= $v['id'] ? "-".$keys."-".$v[id] : "";
					}
					else
					{
						$mymps_extra_model[$key]['list'][$k]['uri'] .= $$keys ? "-".$keys."-".$$keys : "";
					}
				}
				$mymps_extra_model[$key]['list'][$k]['uri'] .= "/";
				if ( $v['id'] == $$v['identifier'] )
				{
					$mymps_extra_model[$key]['list'][$k]['select'] .= "1";
					$page_title_extra .= $v['name'] != "不限" ? $v['name'] : "";
				}
				else
				{
					$mymps_extra_model[$key]['list'][$k]['select'] .= "0";
				}
			}
		}
	}
	if ( !$city['cityid'] )
	{
		break;
	}
	$area_list = $city['area'];
	if ( $areaid )
	{
		$street_list = $city['area'][$areaid]['street'];
		if ( $street_list && is_array( $street_list ) )
		{
			foreach ( $street_list as $key => $val )
			{
				$street_list[$key]['uri'] = $dir_typename;
				foreach ( $allow_identifiers as $keys )
				{
					if ( $keys == "streetid" )
					{
						$street_list[$key]['uri'] .= $val['streetid'] ? "-".$keys."-".$val[streetid] : "";
					}
					else
					{
						$street_list[$key]['uri'] .= $$keys ? "-".$keys."-".$$keys : "";
					}
				}
				$street_list[$key]['uri'] .= "/";
				$street_list[$key]['select'] = $val['streetid'] == $streetid ? "1" : 0;
			}
		}
	}
	if ( !is_array( $area_list ) )
	{
		break;
	}
	$streetid = "";
	$area_list = array_merge( array(
		"0" => array( "areaid" => "0", "areaname" => "不限" )
		), $area_list );
	foreach ( $area_list as $key => $val )
	{
		$area_list[$key]['uri'] = $dir_typename;
		foreach ( $allow_identifiers as $keys )
		{
			if ( $keys == "areaid" )
			{
				$area_list[$key]['uri'] .= $val['areaid'] ? "-".$keys."-".$val[areaid] : "";
			}
			else
			{
				$area_list[$key]['uri'] .= $$keys ? "-".$keys."-".$$keys : "";
			}
		}
		$area_list[$key]['uri'] .= "/";
		$area_list[$key]['select'] = $val['areaid'] == $areaid ? "1" : 0;
	}
	break;
	foreach ( $mymps_extra_model as $key => $val )
	{
		if ( is_array( $val['list'] ) )
		{
			foreach ( $val['list'] as $k => $v )
			{
				$mymps_extra_model[$key]['list'][$k]['uri'] = "category.php?";
				foreach ( $allow_identifiers as $keys )
				{
					if ( $v['identifier'] == $keys )
					{
						$mymps_extra_model[$key]['list'][$k]['uri'] .= $v['id'] ? $keys."=".$v[id]."&" : "";
					}
					else
					{
						$mymps_extra_model[$key]['list'][$k]['uri'] .= $$keys ? $keys."=".$$keys."&" : "";
					}
				}
				$mymps_extra_model[$key]['list'][$k]['uri'] = substr( $mymps_extra_model[$key]['list'][$k]['uri'], 0, -1 );
				if ( $v[id] == $$v[identifier] )
				{
					$mymps_extra_model[$key]['list'][$k]['select'] .= "1";
					$page_title_extra .= $v[name] != "不限" ? $v[name] : "";
				}
				else
				{
					$mymps_extra_model[$key]['list'][$k]['select'] .= "0";
				}
			}
		}
	}
	if ( !$city['cityid'] )
	{
		break;
	}
	$area_list = $city['area'];
	if ( $areaid )
	{
		$street_list = $city['area'][$areaid]['street'];
		if ( $street_list && is_array( $street_list ) )
		{
			foreach ( $street_list as $key => $val )
			{
				$street_list[$key]['uri'] = "category.php?";
				foreach ( $allow_identifiers as $keys )
				{
					if ( $keys == "streetid" )
					{
						$street_list[$key]['uri'] .= $val['streetid'] ? $keys."=".$val[streetid]."&" : "";
					}
					else
					{
						$street_list[$key]['uri'] .= $$keys ? $keys."=".$$keys."&" : "";
					}
				}
				$street_list[$key]['uri'] = substr( $street_list[$key]['uri'], 0, -1 );
				$street_list[$key]['select'] = $val['streetid'] == $streetid ? "1" : 0;
			}
		}
	}
	if ( !is_array( $area_list ) )
	{
		break;
	}
	$streetid = "";
	$area_list = array_merge( array(
		"0" => array( "areaid" => "0", "areaname" => "不限" )
		), $area_list );
	foreach ( $area_list as $key => $val )
	{
		$area_list[$key]['uri'] = "category.php?";
		foreach ( $allow_identifiers as $keys )
		{
			if ( $keys == "areaid" )
			{
				$area_list[$key]['uri'] .= $val['areaid'] ? $keys."=".$val[areaid]."&" : "";
			}
			else
			{
				$area_list[$key]['uri'] .= $$keys ? $keys."=".$$keys."&" : "";
			}
		}
		$area_list[$key]['uri'] = substr( $area_list[$key]['uri'], 0, -1 );
		$area_list[$key]['select'] = $val['areaid'] == $areaid ? "1" : 0;
	}
	break;
}
$pdetail = $page_title_extra.( $cat['title'] ? $cat['title'] : $cat['catname'] );
$pdetail .= 1 < $page ? " - 第".$page."页" : "";
$pdetail .= " - ".$city['cityname'].$mymps_global['SiteName'];
$pdetail = $city['cityname'].$pdetail;
$loc = get_location( "category", $catid, "", "", $pdetail );
$page_title = $loc['page_title'];
$location = $loc['location'];
if ( 0 < $cat['parentid'] )
{
	$flag = array_reverse( get_parent_cats( "category", $catid ) );
	$cat['parentid'] = $flag[0]['catid'];
}
$hotcities = get_hot_cities( );
$allow_identifier = $allow_identifer[$cat['modid']]['identifier'];
$description = $cat['description'] ? strip_tags( $cat['description'] ) : $cat['catname'];
$keywords = $cat['keywords'] ? $cat['keywords'] : $cat['catname'];
$friendlink = $city['flink'][$cat['catid']];
globalassign( );
if ( $cat['template'] == "list" )
{
	if ( (1 < $cat['modid'] ) && $idin )
	{
		$des = get_info_option_array( );
		$extra = $db->getall( "SELECT a.* FROM `".$db_mymps."information_{$cat['modid']}` AS a WHERE 1 {$idin}" );
		foreach ( $extra as $k => $v )
		{
			unset( $v['iid'] );
			unset( $v['content'] );
			foreach ( $v as $u => $w )
			{
				$g = get_info_option_titval( $des[$u], $w );
				if ( !( $u != "id" ) && is_numeric( $u ) )
				{
					$info_list[$v['id']]['extra'][$u] = $g['value'];
				}
			}
		}
	}
}
else if ( $cat['template'] == "list_simple" || !( 1 < $cat['modid'] ) && !$idin )
{
	$des = get_info_option_array( );
	$extra = $db->getall( "SELECT a.* FROM `".$db_mymps."information_{$cat[modid]}` AS a WHERE 1 {$idin}" );
	foreach ( $extra as $k => $v )
	{
		unset( $v['iid'] );
		unset( $v['content'] );
		foreach ( $v as $u => $w )
		{
			$g = get_info_option_titval( $des[$u], $w );
			if ( !( $u != "id" ) && is_numeric( $u ) )
			{
				$info_list[$v['id']][$u] = $g['value'];
			}
		}
	}
}
include( mymps_tpl( $cat['template'] ? $cat['template'] : "list" ) );
if ( is_object( $db ) )
{
	$db->close( );
}
if ( $cachetime )
{
	$cachepages->caching( );
}
$city = $maincity = $info_list = $advertisement = NULL;
unset( $city );
unset( $maincity );
unset( $info_list );
unset( $advertisement );
?>
