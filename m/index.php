<?php

function errormsg( $error_msg )
{
    global $charset;
    global $mymps_global;
    global $cityid;
    echo "<?xml version=\"1.0\" encoding=\"".$charset."\"?>";
    include( mymps_tpl( "header_error" ) );
    echo "<div>".$error_msg."</div>";
    include( mymps_tpl( "footer_error" ) );
    exit( );
}

function redirectmsg( $redirectmsg, $url )
{
    global $charset;
    global $mymps_global;
    global $cityid;
    echo "<?xml version=\"1.0\" encoding=\"".$charset."\"?>";
    include( mymps_tpl( "header_error" ) );
    echo "<div>".$redirectmsg." <a href=\"".$url."\">点此跳转</a></div>";
	//echo "<script type='text/javascript'>location.href='".$url."'</script>";
    include( mymps_tpl( "footer_error" ) );

	//header("location: ".$url);
    exit( );
}

function setparams( $param )
{
    foreach ( $param as $k => $v )
    {
        global $$v;
        $params .= $$v ? urlencode( $v )."=".$$v."&" : "";
    }
    return $params;
}

function showJson($state, $msg = '', $data = [], $option = 0){
    $ret = array(
        'state' => $state,
        'msg' => urlencode($msg),
        'data' => $data,
    );
    die(urldecode(json_encode($ret, $option)));
}


function pager( )
{
    global $page;
    global $totalpage;
    global $rows_num;
    global $param;
    if ( $totalpage == 1 && $page == 1 )
    {
        $nav = $rows_num."条记录";
        return $nav;
    }
    if ( $page - 1 < 1 )
    {
        $nav .= "<a href=\"javascript:void();\" class=\"pageprev pagedisable\">上一页</a>";
        $nav .= "<a class=\"pageno pagecur\">".$page."</a>";
        $nav .= ( ( "<a href=\"?".$param."page=".( $page + 1 ) )."\" class=\"pageno\">".( $page + 1 ) )."</a>";
        if ( $page + 1 < $totalpage )
        {
            $nav .= ( ( "<a href=\"?".$param."page=".( $page + 2 ) )."\" class=\"pageno\">".( $page + 2 ) )."</a>";
        }
    }
    else
    {
        $nav .= "<a href=\"?".$param."page=".( $page - 1 < 1 ? 1 : $page - 1 )."\" class=\"pageprev\">上一页</a>";
        if ( $totalpage == 3 && $page == 3 )
        {
            $nav .= ( ( "<a href=\"?".$param."page=".( $page - 2 ) )."\" class=\"pageno\">".( $page - 2 ) )."</a>";
        }
        $nav .= ( "<a href=\"?".$param."page=".( $page - 1 ) )."\" class=\"pageno\">".( $page - 1 < 1 ? 1 : $page - 1 )."</a>";
        $nav .= "<a class=\"pageno pagecur\">".$page."</a>";
        if ( $page < $totalpage )
        {
            $nav .= ( ( "<a href=\"?".$param."page=".( $page + 1 ) )."\" class=\"pageno\">".( $page + 1 ) )."</a>";
        }
    }
    if ( $page < $totalpage )
    {
        $nav .= ( "<a href=\"?".$param."page=".( $page + 1 ) )."\" class=\"pagenext\">下一页</a>";
        return $nav;
    }
    $nav .= "<a href=\"javascript:void();\" class=\"pagenext pagedisable\">下一页</a>";
    return $nav;
}

define( "WAP", true );
define( "CURSCRIPT", "wap" );
define( "IN_MYMPS", true );
define( "IN_SMT", true );
require_once( dirname( __FILE__ )."/../include/global.php" );
require_once( MYMPS_DATA."/config.php" );
require_once( MYMPS_DATA."/config.db.php" );
require_once( MYMPS_INC."/db.class.php" );
$mobile_settings = get_mobile_settings( );
if ( $mobile_settings['allowmobile'] != 1 )
{
    errormsg( "本站手机版暂停访问！" );
}
if ( pcclient( ) )
{
    //write_msg( "", $mymps_global['SiteUrl'] );
}
$lat = isset( $lat ) ? ( double )$lat : "";
$lng = isset( $lng ) ? ( double )$lng : "";
if ( $lat && $lng )
{
    //$cityid = get_latlng2cityid( $lat, $lng );
}
$cityid = isset( $cityid ) ? intval( $cityid ) : mgetcookie( "cityid" );
$allow = array(
    "category",
    "index",
    "items",
    "information",
    "login",
    "openlogin",
    "myhome",
    "register",
    "mypost",
    "post",
    "search",
    "member",
    "shoucang",
    "history",
    "delete",
    "about",
    "changecity",
    "news",
    "corp",
    "store",
    "property",
    'pay',
    'ad',
);
if ( !in_array( $mod,  $allow) )
{
    $mod = "index";
}
if ( $cityid )
{
    if ( !( $city = $db->getrow( "SELECT * FROM `".$db_mymps."city` WHERE cityid = '{$cityid}'" ) ) )
    {
        redirectmsg( "当前分站不存在，请前往选择您的分站！", "index.php?mod=changecity" );
    }
    $city = get_city_caches( $cityid );
    msetcookie( "cityid", $cityid , 8640000);
}
$s_uid = $iflogin = NULL;
include( MYMPS_INC."/member.class.php" );
$returnurl = urlencode( geturl( ) );
if ( $member_log->chk_in( ) )
{
    $iflogin = 1;
}
else
{
    $iflogin = 0;
}
include( MYMPS_ROOT."/m/include/inc_".$mod.".php" );
if ( is_object( $db ) )
{
    $db->close( );
}
$parent_cats = $loginfo = $newinfo = $mod = $ac = $mymps_global = $catid = $areaid = $db = $db_mymps = $mobile_settings = $member_log = NULL;
?>
