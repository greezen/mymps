<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
if ( $mobile_settings['register'] != 1 )
{
    errormsg( "本站手机版已关闭注册功能！如需注册，请打开 ".$mymps_global[SiteUrl]." 网页后再进行注册！" );
}
if ( $action == "register" )
{
    include( MYMPS_ROOT."/member/include/common.func.php" );
    $userid = isset( $_POST['userid'] ) ? mhtmlspecialchars( $_POST['userid'] ) : "";
    $userpwd = isset( $_POST['userpwd'] ) ? mhtmlspecialchars( $_POST['userpwd'] ) : "";
    $reuserpwd = isset( $_POST['reuserpwd'] ) ? mhtmlspecialchars( $_POST['reuserpwd'] ) : "";
    $email = isset( $_POST['email'] ) ? mhtmlspecialchars( $_POST['email'] ) : "";
    $agreergpermit = isset( $_POST['agreergpermit'] ) ? mhtmlspecialchars( $_POST['agreergpermit'] ) : "";
    $mixcode = isset( $_POST['mixcode'] ) ? mhtmlspecialchars( $_POST['mixcode'] ) : "";
    if ( !$mixcode && $mixcode != md5( $cookiepre ) )
    {
        errormsg( "系统判断您的来路不正确！" );
    }
    $checkcode = isset( $_POST['checkcode'] ) ? mhtmlspecialchars( $_POST['checkcode'] ) : "";
    if ( $mobile_settings['authcode'] == 1 && !mymps_chk_randcode( $checkcode ) )
    {
        redirectmsg( "验证码输入错误，请返回重新输入", "index.php?mod=register" );
    }
    if ( $agreergpermit != 1 )
    {
        redirectmsg( "您必须同意条款内容方可注册", "index.php?mod=register" );
    }
    if ( PASSPORT_TYPE == "ucenter" )
    {
        require( MYMPS_ROOT."/uc_client/client.php" );
        if ( $activation && ( $activeuser = uc_get_user( $activation ) ) )
        {
            list( $uid, $userid ) = $activeuser;
        }
        else
        {
            $user = $db->getrow( "SELECT id,userid FROM `".$db_mymps."member` WHERE userid = '{$userid}'" );
            if ( uc_get_user( $userid ) && !$user['userid'] )
            {
                redirectmsg( "该用户无需注册，请重新登录", $mymps_global[SiteUrl]."/m/index.php?m=login" );
            }
            $uid = uc_user_register( $userid, $userpwd, $email );
            if ( $uid <= 0 )
            {
                if ( $uid == -1 )
                {
                    errormsg( "用户名不合法" );
                }
                else if ( $uid == -2 )
                {
                    errormsg( "包含不允许注册的词语" );
                }
                else if ( $uid == -3 )
                {
                    errormsg( "用户名已经存在" );
                }
                else if ( $uid == -4 )
                {
                    errormsg( "Email 格式有误" );
                }
                else if ( $uid == -5 )
                {
                    errormsg( "Email 不允许注册" );
                }
                else if ( $uid == -6 )
                {
                    errormsg( "该 Email 已经被注册" );
                }
                else
                {
                    errormsg( "未定义" );
                }
            }
            else
            {
                $userid = trim( $userid );
                $userpwd = trim( $userpwd );
                $email = trim( $email );
            }
        }
    }
    $rs = checkuserid( $userid, "手机号" );
    if ( $rs != "ok" )
    {
        redirectmsg( $rs, "index.php?mod=register" );
    }
    if ( $userpwd != $reuserpwd )
    {
        redirectmsg( "您两次输入的密码不相同，请返回重新输入", "index.php?mod=register" );
    }
    if ( 20 < strlen( $userid ) )
    {
       // redirectmsg( "您的用户名多于20个字符，不允许注册!", "index.php?mod=register" );
    }
    if ( 11 != strlen( $userid ) )
    {
        redirectmsg( "手机号码不正确!", "index.php?mod=register" );
    }
    if ( strlen( $userpwd ) < 5 )
    {
        redirectmsg( "你的用户名或密码过短(不能少于3个字符)，不允许注册!", "index.php?mod=register" );
    }
    if ( !is_email( $email ) )
    {
        redirectmsg( "Email格式不正确！", "index.php?mod=register" );
    }
    if ( $db->getone( "SELECT id FROM `".$db_mymps."member` WHERE userid = '{$userid}' " ) )
    {
        redirectmsg( "你指定的用户名 ".$userid." 已存在，请使用别的用户名!", "index.php?mod=register" );
    }
    member_reg( $userid, md5( $userpwd ), $email, $safequestion, $safeanswer );
    $member_log->in( $userid, md5( $userpwd ), "on", "noredirect" );
    redirectmsg( "恭喜! 您已经注册成功", "index.php?mod=index" );
} elseif ($action == 'code') {
    echo 'ok';exit;
    require_once  MYMPS_ROOT.'/include/Sms.php';
    $msg = sprintf('【城盛惠民】『【%s】』，为您的手机验证码。如非本人操作，请忽略。', mt_rand(100000, 999999));
    $r=Sms::send('15989589725', '666');
    var_dump($r);exit;
}
else
{
    $mixcode = md5( $cookiepre );
    include( mymps_tpl( "member_register" ) );
}
?>
