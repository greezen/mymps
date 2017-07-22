<?php

if (CURSCRIPT != "wap") {
    exit("FORBIDDEN");
}
$returnurl = isset($_REQUEST['returnurl']) ? mhtmlspecialchars($_REQUEST['returnurl']) : "";
$act = isset($_GET['act']) ? trim($_GET['act']) : '';

if ($action == "logout") {
    if (PASSPORT_TYPE == "ucenter") {
        require(MYMPS_ROOT . "/uc_client/client.php");
        $ucsynlogout = uc_user_synlogout();
        echo $ucsynlogout;
    }
    $member_log->out("noredirect");
    echo mymps_goto($url ? $url : $mymps_global['SiteUrl'] . "/m/index.php?mod=member");
} else if ($action == "login") {
    $userid = isset($userid) ? trim($userid) : "";
    $userpwd = isset($userpwd) ? trim($userpwd) : "";
    $checkcode = isset($checkcode) ? trim($checkcode) : "";
    if ($mobile_settings['authcode'] == 1 && !mymps_chk_randcode($checkcode)) {
        redirectmsg("验证码输入错误，请返回重新输入", "index.php?mod=login&cityid=" . $cityid);
    }
    if ($userid == "" || $userpwd == "") {
        redirectmsg("用户帐号或密码不能为空", "index.php?mod=login&cityid=" . $cityid);
    }
    $s_uid = $db->getone("SELECT userid FROM `" . $db_mymps . "member` WHERE (userid='{$userid}' OR mobile='{$userid}') AND userpwd='" . md5($userpwd) . "'");
    if (PASSPORT_TYPE == "ucenter") {
        require_once(MYMPS_ROOT . "/member/include/common.func.php");
        require(MYMPS_ROOT . "/uc_client/client.php");
        list($uid, $username, $password, $email) = uc_user_login($userid, $userpwd);
        if (0 < $uid) {
            if (!$db->getone("SELECT count(*) FROM " . $db_mymps . "member WHERE userid='{$userid}'")) {
                member_reg($userid, md5($userpwd));
            } else {
                $db->query("UPDATE `" . $db_mymps . "member` SET userpwd = '" . md5($userpwd) . ("' WHERE userid = '" . $userid . "'"));
            }
            $s_uid = $userid;
        } else if ($uid == -1) {
            errormsg("用户不存在,或者被删除");
            exit();
        } else if ($uid == -2) {
            errormsg("密码输入错误");
            exit();
        } else {
            errormsg("未定义操作");
            exit();
        }
    }
    if ($s_uid) {
        $member_log->in($s_uid, md5($userpwd), "on", "noredirect");
        redirectmsg($s_uid . " 欢迎回来!", $returnurl ? $returnurl : "index.php?mod=member&cityid=" . $cityid);
    } else {
        redirectmsg("登录失败，您输入了错误的帐号或密码!", $returnurl ? $returnurl : "index.php?mod=login&cityid=" . $cityid);
    }
} else if ($act == 'wx') {
    $openid = isset($_REQUEST['openid']) ? trim($_REQUEST['openid']) : '';
    $nickname = isset($_REQUEST['nickname']) ? trim($_REQUEST['nickname']) : '';
    $nickname = array_iconv($nickname, "utf-8", "gbk");
    $headimg = isset($_REQUEST['headimg']) ? trim($_REQUEST['headimg']) : '';

    if (empty($openid) || empty($nickname) || empty($headimg) || !in_array(strlen($openid), [28, 29])) {
        redirectmsg("登录失败!", $returnurl ? $returnurl : "index.php?mod=login&cityid=" . $cityid);
    }

    include_once MYMPS_MEMBER . '/include/common.func.php';
    $userid = wx_member_reg($openid, $nickname, $headimg);
    if ($userid) {
        $userpwd = '';
        $member_log->in($userid, $userpwd, "on", "noredirect");
        redirectmsg($nickname . " 欢迎回来!", $returnurl ? $returnurl : "index.php?mod=member&cityid=" . $cityid);
    }
    redirectmsg("登录失败!", $returnurl ? $returnurl : "index.php?mod=login&cityid=" . $cityid);
} else if ($act == 'gzh') {
    if (isset($_GET['code'])) {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$gzh['appid'].'&secret='.$gzh['secret'].'&code='.trim($_GET['code']).'&grant_type=authorization_code';
        $res = curl_get($url);

        if (isset($res['access_token'])) {
            require_once MYMPS_MEMBER.'/include/common.func.php';
            $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'];
            $user_info = curl_get($url);

            $userid = wx_member_reg($user_info['unionid'], mb_convert_encoding($user_info['nickname'], 'gbk'), $user_info['headimgurl']);
            if ($userid) {
                $userpwd = '';
                $member_log -> in($userid,$userpwd,'','noredirect');
                redirectmsg($user_info['nickname'] . " 欢迎回来!", $returnurl ? $returnurl : "index.php?mod=member&cityid=" . $cityid);
            }
        }
    } else {
        $jump = 'http://' . $_SERVER['HTTP_HOST'] . '/m/index.php?mod=login&act=gzh';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$gzh['appid'].'&redirect_uri='.urlencode($jump).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('Location:'.$url);exit;
    }
} else if ($iflogin == 1) {
    redirectmsg("您已登录", $returnurl ? $returnurl : "index.php");
} else {
    $is_gzh = false;
    if (stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        $is_gzh = true;
    }
    include(mymps_tpl("member_login"));
}

/**
 * UTF-8编码 GBK编码相互转换/（支持数组）
 *
 * @param array $str 字符串，支持数组传递
 * @param string $in_charset 原字符串编码
 * @param string $out_charset 输出的字符串编码
 * @return array
 */
function array_iconv($str, $in_charset = "gbk", $out_charset = "utf-8")
{
    if (is_array($str)) {
        foreach ($str as $k => $v) {
            $str[$k] = array_iconv($v);
        }
        return $str;
    } else {
        if (is_string($str)) {
            // return iconv('UTF-8', 'GBK//IGNORE', $str);
            return mb_convert_encoding($str, $out_charset, $in_charset);
        } else {
            return $str;
        }
    }
}

function curl_get($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

?>
