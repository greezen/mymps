<?php

if ( !defined( "WAP" ) )
{
    exit( "FORBIDDEN" );
}
$userid = isset( $_GET['userid'] ) ? mhtmlspecialchars( $_GET['userid'] ) : "";
$row['prelogo'] = $row['prelogo'] ? $row['prelogo'] : "/images/noavatar_small.gif";
$row['prelogo'] = $mymps_global['SiteUrl'].$row['prelogo'];
if ( $iflogin == 1 )
{
    $loginfo = "<a class=\"u_name fl\">欢迎，</a><a href=\"index.php?mod=member&userid=".$s_uid."\" class=\"u_name fl\">".$s_uid."</a> <a href=\"index.php?mod=login&action=logout&returnurl=".$returnurl."\" class=\"exit58\">安全退出</a>";
    $loginfopost = "<a class=\"u_name fl\">欢迎,</a><a href=\"index.php?mod=member&userid=".$s_uid."\" class=\"u_name fl\"><b>".$s_uid."</b></a>   &nbsp;&nbsp;<a href=\"index.php?mod=login&action=logout&returnurl=".$returnurl."\" class=\"exit58\">退出</a>";
    $loginfomypost = "<a href=\"index.php?mod=mypost&userid=".$s_uid."\" class=\"my_publish\">".我的发布."</a>";
    $loginfomyshoucang = "<a href=\"index.php?mod=shoucang&userid=".$s_uid."\" class=\"my_collect\">".我的收藏."</a>";
}
else
{
    $loginfo = "<a href=\"index.php?mod=login&cityid=".$cityid."&returnurl=".$returnurl."\" class=\"logn_btn\">登录</a> <a href=\"index.php?mod=register&cityid=".$cityid."\" class=\"logn_btn\">注册</a>";
    $loginfopost = "<div class=\"d3\"><a href=\"index.php?mod=login&cityid=".$cityid."&returnurl=".$returnurl."\">登录</a></div> <div class=\"d4\"><a href=\"index.php?mod=register&cityid=".$cityid."\">注册</a></div>";
    $loginfomypost = "<a href=\"index.php?mod=login&returnurl=".$returnurl."\" class=\"my_publish\">我的发布</a>";
    $loginfomyshoucang = "<a href=\"index.php?mod=login&returnurl=".$returnurl."\" class=\"my_collect\">我的收藏</a>";
}
include( mymps_tpl( "member" ) );
?>
