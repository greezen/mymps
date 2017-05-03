<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function get_special_subject( $arr = "" )
{
	require_once( MYMPS_DATA."/info_special.inc.php" );
	foreach ( $specialarray as $key => $val )
	{
		$mymps .= "<label for=\"".$key."\">";
		$mymps .= "<input class=\"checkbox\" ";
		$mymps .= is_array( $arr ) ? in_array( $key, $arr ) ? "checked " : "" : "";
		$mymps .= "type=\"checkbox\" name=\"parameter[special][]\" value=\"".$key."\" id=\"".$key."\">".$val;
		$mymps .= "</label>";
		$mymps .= in_array( $key, array( 3, 6 ) ) ? "<hr style=\"height:1px; border:1px #C5D8E8 solid;\">" : "";
	}
	return $mymps;
}

function get_special_news( $arr = "" )
{
	$specialarray = array( );
	$specialarray[1] = "推荐新闻";
	$specialarray[2] = "图片新闻";
	foreach ( $specialarray as $key => $val )
	{
		$mymps .= "<label for=\"".$key."\">";
		$mymps .= "<input class=\"checkbox\" ";
		$mymps .= is_array( $arr ) ? in_array( $key, $arr ) ? "checked " : "" : "";
		$mymps .= "type=\"checkbox\" name=\"parameter[special][]\" value=\"".$key."\" id=\"".$key."\">".$val;
		$mymps .= "</label>";
	}
	return $mymps;
}

function get_special_store( $arr = "" )
{
	$specialarray = array( );
	$specialarray[1] = "列表推荐商家";
	$specialarray[2] = "首页推荐商家";
	$specialarray[3] = "执照认证商家";
	foreach ( $specialarray as $key => $val )
	{
		$mymps .= "<label for=\"".$key."\">";
		$mymps .= "<input class=\"checkbox\" ";
		$mymps .= is_array( $arr ) ? in_array( $key, $arr ) ? "checked " : "" : "";
		$mymps .= "type=\"checkbox\" name=\"parameter[special][]\" value=\"".$key."\" id=\"".$key."\">".$val;
		$mymps .= "</label>";
	}
	return $mymps;
}

function get_special_goods( $arr = "" )
{
	$specialarray = array( );
	$specialarray[1] = "推荐商品";
	$specialarray[2] = "热卖商品";
	$specialarray[3] = "促销商品";
	$mymps = "<select name=\"parameter[special][]\" class=\"select\">";
	$mymps .= "<option value=\"\">不限类型</option>";
	foreach ( $specialarray as $key => $val )
	{
		$mymps .= "<option value=\"".$key."\"";
		$mymps .= is_array( $arr ) ? in_array( $key, $arr ) ? "checked " : "" : "";
		$mymps .= "  >".$val;
		$mymps .= "</option>";
	}
	$mymps .= "</select>";
	return $mymps;
}

define( "CURSCRIPT", "jswizard" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
require_once( dirname( __FILE__ )."/include/customtype.inc.php" );
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
$part = $part ? trim( $part ) : "default";
$action = $action ? trim( $action ) : "";
if ( !defined( "IN_ADMIN" ) || !defined( "IN_MYMPS" ) )
{
	exit( "Access Denied" );
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	chk_admin_purview( "purview_数据调用" );
	switch ( $part )
	{
		case "settings" :
		$here = "数据调用 - 基本设置";
		$query = $db->query( "SELECT * FROM `".$db_mymps."config` WHERE type = 'jswizard'" );
		while ( $row = $db->fetchrow( $query ) )
		{
			$settings[$row['description']] = $row['value'];
		}
		include( mymps_tpl( CURSCRIPT."_".$part ) );
		break;
		case "add" :
		$here = "增加".$customtypearr[$customtype]."调用项目";
		include( mymps_tpl( $customtype == "info" ? CURSCRIPT : CURSCRIPT."_".$customtype ) );
		break;
		case "detail" :
		if ( empty( $id ) )
		{
			write_msg( "很抱歉，没有该数据调用项目！" );
		}
		$paramete = $db->getrow( "SELECT * FROM `".$db_mymps."jswizard` WHERE id = '{$id}'" );
		$flag = $paramete['flag'];
		$parameter = array( );
		$parameter = $charset == "utf-8" ? utf8_unserialize( $paramete['parameter'] ) : unserialize( $paramete['parameter'] );
		$parameter['jstemplate'] = stripslashes( $parameter['jstemplate'] );
		$customtype = $paramete['customtype'];
		$here = $customtypearr[$customtype]."调用项目管理";
		$customtype = !$customtype ? "info" : $customtype;
		include( mymps_tpl( $customtype == "info" ? CURSCRIPT : CURSCRIPT."_".$customtype ) );
		break;
		case "default" :
		$randam = $db->getone( "SELECT MAX(id) FROM ".$db_mymps."jswizard" ) + 1;
		$randam .= random( 3 );
		$here = "数据调用";
		$rows_num = mymps_count( "jswizard" );
		$param = setparam( array( "part" ) );
		$pagi = page1( "SELECT * FROM `".$db_mymps."jswizard` ORDER BY id DESC" );
		foreach ( $pagi as $key => $val )
		{
			$jswizard[$val['id']]['id'] = $val['id'];
			$jswizard[$val['id']]['customtype'] = $val['customtype'];
			$jswizard[$val['id']]['flag'] = $val['flag'];
			$jswizard[$val['id']]['edittime'] = $val['edittime'];
			$jswizard[$val['id']]['parameter'] = $charset == "utf-8" ? utf8_unserialize( $val['parameter'] ) : unserialize( $val['parameter'] );
			$jswizard[$val['id']]['jscharset'] = $jswizard[$val['id']]['parameter']['jscharset'];
		}
		include( mymps_tpl( CURSCRIPT."_".$part ) );
		break;
	}
}
else
{
	if ( is_array( $delids ) )
	{
		$db->query( "DELETE FROM `".$db_mymps."jswizard` WHERE ".create_in( $delids, "id" ) );
		$string = "删除数据调用项目";
		write_jswizard_cache( );
		write_msg( "成功".$string."", $return_url ? $return_url : "?part=default", "write_record" );
		exit( );
	}
	if ( is_array( $settingsnew ) )
	{
		mymps_delete( "config", "WHERE type = 'jswizard'" );
		foreach ( $settingsnew as $key => $val )
		{
			$db->query( "INSERT INTO `".$db_mymps."config` (`description`,`value`,`type`)VALUES('".$key."','".$val."','jswizard')" );
		}
		update_jswizard_settings( );
		write_msg( "成功更新信息调用基本设置！", $return_url, "write_record" );
	}
	if ( empty( $id ) )
	{
		if ( empty( $flag ) && !is_array( $parameter ) )
		{
			write_msg( "唯一标识不能为空！相关配置不能为空！" );
		}
		if ( empty( $parameter['jstemplate'] ) )
		{
			write_msg( "数据调用模板内容不能为空！" );
		}
		if ( 0 < $db->getone( "SELECT count(id) FROM `".$db_mymps."jswizard` WHERE flag = '{$flag}'" ) )
		{
			write_msg( "该标识已经存在，请更换一个唯一标识！" );
		}
		$parameter = addslashes( serialize( $parameter ) );
		$db->query( "INSERT INTO `".$db_mymps."jswizard` (`flag`,`customtype`,`parameter`,`edittime`)VALUES('{$flag}','{$customtype}','{$parameter}','{$timestamp}')" );
		$string = "添加数据调用";
		$return_url = "?part=detail&id=".$db->insert_id( );
	}
	else
	{
		if ( empty( $flag ) || !is_array( $parameter ) )
		{
			write_msg( "唯一标识不能为空！相关配置不能为空！" );
		}
		$parameter = addslashes( serialize( $parameter ) );
		$db->query( "UPDATE `".$db_mymps."jswizard` SET flag='{$flag}',parameter='{$parameter}',edittime = '{$timestamp}' WHERE id = '{$id}'" );
		$string = "修改数据调用";
		$return_url = "?part=detail&id=".$id;
		clear_cache_files( "javascript_".$flag );
	}
	write_jswizard_cache( );
	write_msg( "成功".$string."", $return_url ? $return_url : "?part=default", "write_record" );
}
if ( is_object( $db ) )
{
	$db->close();
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
