<?php

function check_upimage_wap( $file = "filename" )
{
    global $mymps_global;
    $size = $mymps_global['cfg_upimg_size'] * 1024;
    $upimg_allow = explode( ",", $mymps_global['cfg_upimg_type'] );
    if ( $size < $_FILES[$file]['size'] )
    {
        redirectmsg( "上传文件应小于".$mymps_global['cfg_upimg_size']."KB", "javascript:history.back()" );
    }
    if ( !in_array( fileext( $_FILES[$file]['name'] ), $upimg_allow ) )
    {
        redirectmsg( "系统只允许上传".$mymps_global['cfg_upimg_type']."格式的图片！", "javascript:history.back()" );
    }
    if ( !preg_match( "/^image\\//i", $_FILES[$file]['type'] ) )
    {
        //redirectmsg( "很抱歉，系统无法识别您上传的文件的格式，请换一张图片上传！", "javascript:history.back()" );
    }
    if ( !getimagesize($_FILES[$file]['tmp_name'])) {
        redirectmsg( "很抱歉，你上传的不是一张图片！", "javascript:history.back()" );
    }
    return true;
}

function mymps_check_upimage_wap( $file = "filename" )
{
    if ( is_array( $_FILES ) )
    {
        for ( $i = 0; $i < count( $_FILES ); $i++ )
        {
            if ( $_FILES[$file.$i]['name'] )
            {
                check_upimage_wap( $file.$i );
            }
        }
    }
}

function get_upload_image_view_wap( $if_upimg = 1 )
{
    global $mymps_global;
    global $db;
    global $db_mymps;
    if ( $if_upimg == 1 )
    {
        $cfg_upimg_number = $mymps_global[cfg_upimg_number] ? $mymps_global[cfg_upimg_number] : "3";
        
        for ( $i = 0; $i < $cfg_upimg_number; $i++ )
        {
            $mymps .= "<input class=\"input\" style=\"width:210px;overflow: hidden;padding:5px 0;\" type=\"file\" name=\"mymps_img_".$i."\" datatype=\"filter\" msg=\"图片文件格式不正确\">";
        }
    }
    return $mymps;
}

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
$catid = isset( $catid ) ? intval( $catid ) : "";
$areaid = isset( $areaid ) ? intval( $areaid ) : "";
$streetid = isset( $streetid ) ? intval( $streetid ) : "";
if ( !$cityid )
{
    //header('Location:index.php?mod=changecity');
    //exit();
    redirectmsg( "请先选择您所在的分站", "index.php?mod=changecity" );
    exit( );
}

require_once( MYMPS_DATA."/info_lasttime.php" );
 $street_list = $db->getall( "SELECT * FROM `".$db_mymps."street` WHERE areaid = '{$areaid}'" );
if ( $action == "post" )
{
    $content = isset( $content ) ? textarea_post_change( $content ) : "";
    $result = verify_badwords_filter( $mymps_global['cfg_if_info_verify'], $title, $content );
    $title = $result['title'];
    $content = $result['content'];
    $content = preg_replace( "/<a[^>]+>(.+?)<\\/a>/i", "\$1", $content );
    $info_level = $result['level'];
    $mixcode = isset( $mixcode ) ? trim( $mixcode ) : "";
    $manage_pwd = isset( $manage_pwd ) ? trim( $manage_pwd ) : "";
    $lat = isset( $lat ) ? ( double )$lat : "";
    $lng = isset( $lng ) ? ( double )$lng : "";
    $activetime = $endtime = intval( $endtime );
    $endtime = $endtime == 0 ? 0 : $endtime * 3600 * 24 + $begintime;
    $d = $db->getrow( "SELECT catname,dir_typename,modid FROM `".$db_mymps."category` WHERE catid = '{$catid}'" );
    $catname = $d['catname'];
    $dir_typename = $d['dir_typename'];

    if ( !$mixcode && $mixcode != md5( $cookiepre ) )
    {
        showJson('false', '系统判断您的来路不正确！');
    }
    $backurl = "javascript:history.back()";
    if ( empty( $catid ) )
    {
        showJson('false', '您选择发布的分类不存在!');
    }
    if ( !( $areaid = $db->getone( "SELECT areaid FROM `".$db_mymps."area` WHERE areaid = '{$areaid}'" ) ) )
    {
        showJson('false', '您选择发布的地区不存在!');
    }
    if ( empty( $cityid ) )
    {
        showJson('false', '请选择您要发布的分站!');
    }
    if ( empty( $areaid ) )
    {
        showJson('false', '请选择您要发布的地区!');
    }
    if ( empty( $title ) )
    {
        showJson('false', '请输入信息标题!');
    }
    if ( empty( $content ) )
    {
        showJson('false', '您还没有输入信息描述!');
    }
    if ( empty( $contact_who ) )
    {
        showJson('false', '联系人不能为空!');
    }
    if ( empty( $tel ) )
    {
        showJson('false', '联系电话不能为空!');
    }
    if ( $iflogin == 0 && empty( $manage_pwd ) )
    {
        showJson('false', '管理密码不能为空，该密码用于修改/删除该信息，请谨记!');
    }
    require_once( MYMPS_INC."/upfile.fun.php" );
    require_once( MYMPS_DATA."/config.inc.php" );
    mymps_check_upimage_wap( "mymps_img_" );
    $checkcode = isset( $_POST['checkcode'] ) ? mhtmlspecialchars( $_POST['checkcode'] ) : "";
    if ( $mobile_settings['authcode'] == 1 && !( $randcode = mymps_chk_randcode( $checkcode ) ) )
    {
        showJson('false', '验证码输入错误，请返回重新输入');
    }
    if ( !empty( $mymps_global['cfg_disallow_post_tel'] ) || !empty( $tel ) )
    {
        $disallow_tel = array( );
        $disallow_tel = explode( "=", $mymps_global['cfg_disallow_post_tel'] );
        $disallow_telarray = explode( ",", $disallow_tel[0] );
        if ( $disallow_tel[1] == -1 )
        {
            if ( in_array( $tel, $disallow_telarray ) )
            {
                showJson('false', "您的电话号码<b style='color:red'>".$tel."</b> 已被管理员加入黑名单!<br />如果您要继续操作，请联系客服。");
                //redirectmsg( "您的电话号码<b style='color:red'>".$tel."</b> 已被管理员加入黑名单!<br />如果您要继续操作，请联系客服。", "index.php?mod=post&catid=".$catid."&cityid=".$cityid."&areaid=".$areaid );
            }
        }
        else if ( $disallow_tel[1] == 0 )
        {
            if ( in_array( $tel, $disallow_telarray ) )
            {
                $info_level = 0;
            }
        }
        unset( $disallow_tel );
        unset( $disallow_telarray );
    }
    $ip = getip( );

    if ( !empty( $mymps_global['cfg_forbidden_post_ip'] ) )
    {
        foreach ( explode( ",", $mymps_global['cfg_forbidden_post_ip'] ) as $ctrlip )
        {
            if ( !preg_match( "/^(".preg_quote( $ctrlip = trim( $ctrlip ), "/" ).")/", $ip ) )
            {
                continue;
            }
            $ctrlip .= "%";
            showJson('false', "您当前的IP <b style='color:red'>".$ip."</b> 已被管理员加入黑名单，不允许发布信息！<br />如果您要继续操作，请联系客服。");
            //redirectmsg( "您当前的IP <b style='color:red'>".$ip."</b> 已被管理员加入黑名单，不允许发布信息！<br />如果您要继续操作，请联系客服。", "index.php?mod=post&catid=".$catid."&areaid=".$areaid );
            exit( );
        }
    }
    if ( $mymps_global['cfg_if_post_othercity'] == 0 && $cityid && is_array( $cityarr = get_ip2city( $ip ) ) && $cityid != $cityarr[cityid] )
    {
        //errormsg( "您的IP不属于该分站，请不要在该分站下发布信息^_^" );
    }
    $post_time = 1;
    if ( !empty( $post_time ) )
    {
        $count = mymps_count( "information", "WHERE ip = '".$ip."' AND begintime > (".time( )." - 1*60)" );
        if ( $post_time <= $count )
        {
            showJson('false', '您的发布时间太快了，休息一会儿。');
        }
    }
    $img_count = upload_img_num( "mymps_img_" );
	
    if ( $iflogin == 1 )
    {
        if ( $db->getone( "SELECT id FROM `".$db_mymps."information` WHERE title = '{$title}' AND userid = '{$s_uid}'" ) )
        {
            showJson('false', '本信息标题已经存在，本站禁止发布重复信息！请更换标题。或者您已经发过同样信息想重复发布，可到帐号管理后台进行刷新操作即可。');
        }
        $per = $db->getrow( "SELECT b.perday_maxpost FROM `".$db_mymps."member` AS a LEFT JOIN `{$db_mymps}member_level` AS b ON a.levelid = b.id WHERE a.userid = '{$s_uid}'" );
        $perday_maxpost = $per['perday_maxpost'];
        if ( !empty( $perday_maxpost ) )
        {
            $count = mymps_count( "information", "WHERE userid LIKE '".$s_uid."' AND begintime > '".mktime( 0, 0, 0 )."'" );
            if ( $perday_maxpost <= $count )
            {
                showJson('false', "很抱歉！您当前的会员级别每天只能发布 <b style='color:red'>".$perday_maxpost."</b> 条信息<br />如果您要继续操作，请联系客服。");
                //redirectmsg( "很抱歉！您当前的会员级别每天只能发布 <b style='color:red'>".$perday_maxpost."</b> 条信息<br />如果您要继续操作，请联系客服。", "index.php?mod=post&catid=".$catid."&areaid=".$areaid );
            }
        }
        $userid = trim( $s_uid );
        $perpost_money_cost = $mymps_global['cfg_member_perpost_consume'] ? $mymps_global['cfg_member_perpost_consume'] : 0;
        if ( $userid )
        {
            $row = $db->getrow( "SELECT per_certify,com_certify FROM `".$db_mymps."member` WHERE userid = '{$userid}'" );
            if ( $row['per_certify'] == 1 || $row['com_certify'] == 1 )
            {
                $certify = 1;
            }
            else
            {
                $certify = 0;
            }
            unset( $row );
        }
        $sql = "INSERT INTO `".$db_mymps."information` (title,content,begintime,activetime,endtime,catid,catname,dir_typename,cityid,areaid,streetid,userid,ismember,info_level,qq,email,tel,contact_who,img_count,certify,ip,ip2area,latitude,longitude) VALUES ('{$title}','{$content}','{$timestamp}','0','0','{$catid}','{$catname}','{$dir_typename}','{$cityid}','{$areaid}','{$streetid}','{$userid}','1','{$info_level}','{$qq}','{$email}','{$tel}','{$contact_who}','{$img_count}','{$certify}','{$ip}','wap','{$lat}','{$lng}')";
        if ( !empty( $perpost_money_cost ) )
        {
            $db->query( "UPDATE `".$db_mymps."member` SET money_own = money_own - '{$perpost_money_cost}' WHERE userid = '{$userid}'" );
        }
    }
    else
    {
        if ( $mymps_global['cfg_if_nonmember_info'] == 1 && 0 < $mymps_global['cfg_nonmember_perday_post'] )
        {
            $count = mymps_count( "information", "WHERE ip = '".$ip."' AND begintime > '".mktime( 0, 0, 0 )."' AND ismember = '0'" );
            if ( $mymps_global[cfg_nonmember_perday_post] <= $count )
            {
                showJson('false', "很抱歉！游客每天只能发布 <b style='color:red'>".$mymps_global[cfg_nonmember_perday_post]."</b> 条信息<br />如果您要继续操作，请联系客服。");
                //redirectmsg( "很抱歉！游客每天只能发布 <b style='color:red'>".$mymps_global[cfg_nonmember_perday_post]."</b> 条信息<br />如果您要继续操作，请联系客服。", "index.php?mod=post&catid=".$catid."&areaid=".$areaid );
            }
        }
        $sql = "INSERT INTO `".$db_mymps."information` (title,content,begintime,activetime,endtime,catid,catname,dir_typename,cityid,areaid,streetid,info_level,qq,email,tel,contact_who,img_count,certify,ip,ip2area,manage_pwd,latitude,longitude) VALUES ('{$title}','{$content}','{$timestamp}','0','0','{$catid}','{$catname}','{$dir_typename}','{$cityid}','{$areaid}','{$streetid}','{$info_level}','{$qq}','{$email}','{$tel}','{$contact_who}','{$img_count}','{$certify}','{$ip}','wap','{$manage_pwd}','{$lat}','{$lng}')";
    }
    $db->query( $sql );
    $id = $db->insert_id( );
    $k = $v = NULL;
    if ( is_array( $extra ) && 1 < $d['modid'] )
    {
        foreach ( $extra as $k => $v )
        {
            $v = is_array( $v ) ? implode( ",", $v ) : $v;
            $sql1 .= ",`".$k."`";
            $sql2 .= ",'".$v."'";
        }
        $sql = "(id.".$sql1.")VALUES('{$id}','','')";
        $db->query( "INSERT INTO `".$db_mymps."information_{$d[modid]}` (`id`{$sql1})VALUES('{$id}'{$sql2})" );
        unset( $sql1 );
        unset( $sql2 );
    }
    if ( 0 < $img_count )
    {
        $i = 0;
        for ( ; $i < $img_count; ++$i )
        {
            $name_file = "mymps_img_".$i;
            if ( $_FILES[$name_file]['name'] )
            {
                $destination = "/information/".date( "Ym" )."/";
                $mymps_image = start_upload( $name_file, $destination, $mymps_global['cfg_upimg_watermark'], $mymps_mymps['cfg_information_limit']['width'], $mymps_mymps['cfg_information_limit']['height'] );
                $db->query( "INSERT INTO `".$db_mymps."info_img` (image_id,path,prepath,infoid,uptime) VALUES ('{$i}','{$mymps_image['0']}','{$mymps_image['1']}','{$id}','{$timestamp}')" );
            }
        }
        $db->query( "UPDATE `".$db_mymps."information` SET img_path = '{$mymps_image['1']}' WHERE id = '{$id}'" );
    }
    $msg = 0 < $info_level ? "成功发布一条信息!" : "您的信息审核通过后将显示在网站上!";
    showJson('true', $msg);
    //redirectmsg( $msg, "index.php?mod=category&catid=".$catid );
}
else if ( !$catid )
{
    $categories = get_categories_tree( 0, "category" );
    include( mymps_tpl( "post_cat" ) );
    exit( );
}
else if ( ((!$areaid && $cityid)))
{
    $area_list = $db->getall( "SELECT * FROM `".$db_mymps."area` WHERE cityid = '{$cityid}'" );
 
    if ( !empty( $area_list ) )
    {	 	 
        include( mymps_tpl( "post_area" ) );
        exit( );
    }
}
else if (   !$streetid &&!empty( $street_list )  )
{
        include( mymps_tpl( "post_street" ) );
        exit( );
}
else
{
    require_once( MYMPS_DATA."/wap_info.type.inc.php" );
    $cat = $db->getrow( "SELECT catid,catname,parentid,modid,if_upimg FROM `".$db_mymps."category` WHERE catid = '{$catid}'" );
    $cat['parentname'] = $db->getone( "SELECT catname FROM `".$db_mymps."category` WHERE catid = '{$cat['parentid']}'" );
    if ( $cat['parentid'] == 0 )
    {
        $categories = get_categories_tree( $catid, "category" );
        include( mymps_tpl( "post_cat" ) );
    }
    else if ( 0 < $cat['parentid'] )
    {
        if ( $iflogin != 1 )
        {
            if ( $mymps_global['cfg_if_nonmember_info'] != 1 )
            {
                $returnurl = "index.php?mod=post&cityid=".$cityid."&areaid=".$areaid."&streetid=".$streetid;
                $returnurl = urlencode( $returnurl );
                redirectmsg( "游客不能发布信息！请您登录后再发布！", "index.php?mod=login&returnurl=".$returnurl );
            }
        }
        else if ( $user = $db->getrow( "SELECT qq,email,mobile,cname FROM `".$db_mymps."member` WHERE userid = '{$s_uid}'" ) )
        {
            $tel = $user['mobile'];
            $contact_who = $user['cname'];
            $qq = $user['qq'];
        }
        $areaname = $streetid ? $db->getone( "SELECT streetname FROM `".$db_mymps."street` WHERE streetid = '{$streetid}'" ) : $db->getone( "SELECT areaname FROM `".$db_mymps."area` WHERE areaid = '{$areaid}'" );
        if ( $child = $db->getall( "SELECT catid,catname FROM `".$db_mymps."category` WHERE parentid = '{$catid}'" ) )
        {
            $catname = "<select name=\"catid\" style=\"width:60%\">";
            foreach ( $child as $k => $v )
            {
                $catname .= "<option value=\"".$v[catid]."\">".$v[catname]."</option>";
            }
            $catname .= "</select>";
        }
        else
        {
            $catname = $db->getone( "SELECT catname FROM `".$db_mymps."category` WHERE catid = '{$catid}'" );
        }
        $return_url = "index.php?mod=post&catid=".$catid."&areaid=".$areaid."&cityid=".$cityid;
        $show_mod_option = return_category_info_options( $cat['modid'] );
        $upload_img = $cat['if_upimg'] == 1 ? get_upload_image_view_wap( 1 ) : "";
        $max_img_num = $mymps_global['cfg_upimg_number'] ? $mymps_global[cfg_upimg_number] : "3";
        $mixcode = md5( $cookiepre );
        include( mymps_tpl( "post" ) );
    }
}