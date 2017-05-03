<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
$url = isset( $url ) ? strip_tags( $url ) : "";
$action = isset( $action ) ? trim( $action ) : "";
if ( !submit_check( "log_submit" ) )
{
    if ( !in_array( $action, array( "bind", "reg" ) ) )
    {
        $action = "reg";
    }
    session_start( );
    if ( empty( $_SESSION['nickname'] ) || empty( $_SESSION['openid'] ) )
    {
        redirectmsg( "session会话失效，请重新登陆！", $mymps_global[SiteUrl]."/include/qqlogin/qq_login.php" );
    }
    $nickname = $_SESSION['nickname'];
    $figureurl_qq_1 = $_SESSION['figureurl_qq_1'];
    $mixcode = md5( $cookiepre );
}
else
{
    if ( !in_array( $action, array( "bind", "reg" ) ) )
    {
        redirectmsg( "您请求的来路不正确!", "olmsg" );
    }
    session_start( );
    $openid = mhtmlspecialchars( $_SESSION['openid'] );
    $cname = mhtmlspecialchars( $_SESSION['nickname'] );
    if ( $action == "bind" )
    {
        if ( empty( $cname ) || empty( $openid ) )
        {
            redirectmsg( "登录状态已超时，请重新登陆！", $mymps_global[SiteUrl]."/include/qqlogin/qq_login.php" );
        }
        $userid = isset( $_POST['bind_userid'] ) ? mhtmlspecialchars( trim( $_POST['bind_userid'] ) ) : "";
        $userpwd = isset( $_POST['bind_userpwd'] ) ? mhtmlspecialchars( trim( $_POST['bind_userpwd'] ) ) : "";
        $bind_userid = isset( $_POST['bind_userid'] ) ? mhtmlspecialchars( $_POST['bind_userid'] ) : "";
        $bind_userpwd = isset( $_POST['bind_userpwd'] ) ? mhtmlspecialchars( $_POST['bind_userpwd'] ) : "";
        $mixcode = isset( $_POST['mixcode'] ) ? mhtmlspecialchars( $_POST['mixcode'] ) : "";
        if ( !$mixcode && $mixcode != md5( $cookiepre ) )
        {
            errormsg( "系统判断您的来路不正确！！" );
        }
        if ( empty( $bind_userid ) || empty( $bind_userpwd ) )
        {
            redirectmsg( "原用户名和原密码输入不能为空", "index.php?mod=openlogin&action=bind" );
        }
        if ( !$db->getone( "SELECT id  FROM `".$db_mymps."member` WHERE userid = '{$userid}' AND userpwd = '".md5( $userpwd )."'" ) )
        {
            redirectmsg( "原帐号或密码输入不正确，请返回重新输入!", "index.php?mod=openlogin&action=bind" );
        }
        $db->query( "DELETE FROM `".$db_mymps."member` WHERE openid = '{$openid}'" );
        $db->query( "UPDATE `".$db_mymps."member` SET openid = '{$openid}' WHERE userid = '{$userid}'" );
        $bind_userid = $bind_userpwd = $qqlogin = NULL;
        $member_log->in( $userid, md5( $userpwd ), "off", "noredirect" );
        @session_unregister( "openid" );
        @session_unregister( "nickname" );
        @session_unregister( "access_token" );
        @session_unregister( "appid" );
        redirectmsg( "恭喜! 绑定成功", "index.php?mod=member" );
    }
    else if ( $action == "reg" )
    {
        $userid = isset( $_POST['userid'] ) ? mhtmlspecialchars( trim( $_POST['userid'] ) ) : "";
        $email = isset( $_POST['email'] ) ? mhtmlspecialchars( trim( $_POST['email'] ) ) : "";
        $userpwd = isset( $_POST['userpwd'] ) ? mhtmlspecialchars( md5( trim( $_POST['userpwd'] ) ) ) : "";
        if ( $userid == "" )
        {
            redirectmsg( "请填写您的登录用户名", "index.php?mod=openlogin" );
        }
        if ( $email == "" )
        {
            redirectmsg( "请填写您的电子邮箱帐号", "index.php?mod=openlogin" );
        }
        if ( $userpwd == "" )
        {
            redirectmsg( "请填写您的登录密码", "index.php?mod=openlogin" );
        }
        $reg_corp = 0;
        $rs = checkuserid( $userid, "用户名" );
        if ( $rs != "ok" )
        {
            redirectmsg( $rs, "index.php?mod=openlogin" );
        }
        if ( 20 < strlen( $userid ) )
        {
            redirectmsg( "您的用户名多于20个字符，不允许注册!", "index.php?mod=openlogin" );
        }
        if ( strlen( $userpwd ) < 5 )
        {
            redirectmsg( "你的用户名或密码过短(不能少于3个字符)，不允许注册!", "index.php?mod=openlogin" );
        }
        if ( !is_email( $email ) )
        {
            redirectmsg( "Email格式不正确！", "index.php?mod=openlogin" );
        }
        if ( $db->getone( "SELECT id FROM `".$db_mymps."member` WHERE userid = '{$userid}' AND openid = ''" ) )
        {
            redirectmsg( "你指定的用户名 {\$userid} 已存在，请使用别的用户名!", "index.php?mod=openlogin" );
        }
        $userpwd = md5( $userpwd );
        $db->query( "UPDATE `".$db_mymps."member` SET jointime='{$timestamp}',logintime='{$timestamp}',userpwd = '{$userpwd}',email='{$email}' WHERE userid = '{$userid}' " );
        @session_unregister( "openid" );
        @session_unregister( "nickname" );
        @session_unregister( "access_token" );
        @session_unregister( "appid" );
        $member_log->in( $userid, $userpwd, "off", "noredirect" );
        redirectmsg( "恭喜! 您已经注册成功", "index.php?mod=member" );
    }
}
include( mymps_tpl( "member_openlogin" ) );
?>
