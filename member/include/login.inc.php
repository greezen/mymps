<?php
if(!defined('IN_MYMPS')) exit('Forbidden');

$userid	 	= mhtmlspecialchars($userid);
$userpwd 	= trim($userpwd);
$loginip 	= GetIP();
$logintime  = $timestamp ? $timestamp : time();
$memory 	= isset($memory) ? trim($memory) : '';
$url 		= trim($url);

if($authcodesettings['login'] == 1 && !$randcode = mymps_chk_randcode($checkcode)){
	write_msg('验证码输入错误，请返回重新输入');
}

($userid == '' || $userpwd == '') && write_msg("用户帐号或密码不能为空");

$row  = $db -> getRow("SELECT userid,status FROM `{$db_mymps}member` WHERE (userid='$userid' OR email = '$userid' OR tel = '$userid' OR mobile = '$userid') AND userpwd='".md5($userpwd)."'");
$s_uid = $row['userid'];

$userid = $userid ? $userid : $s_uid;

if(PASSPORT_TYPE == 'phpwind'){
	//pw整合
	require MYMPS_ROOT.'/pw_client/uc_client.php';
	$user_login = uc_user_login($userid,md5($userpwd),0);
	if($user_login['status'] == '-2'){
		write_msg('您输入的登录密码错误!');
	} elseif($user_login['status'] == '-1') {
		write_msg('您输入的登录帐号不存在!');
	} elseif($user_login['status'] == '1' && !$i =$db -> getOne("SELECT COUNT(id) FROM `{$db_mymps}member` WHERE userid = '$userid'")){
		member_reg($userid,md5($userpwd),$userid.'@163.com');
	}

} elseif(PASSPORT_TYPE == 'ucenter') {
	//UC整合
	require MYMPS_ROOT.'/uc_client/client.php';
	list($uid, $username, $password, $email) = uc_user_login($userid, $userpwd);
	
	if($uid > 0) {
	
		if(!$db->getOne("SELECT count(*) FROM {$db_mymps}member WHERE userid='$userid'")) {
			member_reg($userid,md5($userpwd));
		}else{
			$db->query("UPDATE `{$db_mymps}member` SET userpwd = '".md5($userpwd)."' WHERE userid = '$userid'");
		}
		$s_uid = $userid;
		
	} else {
	
		if($uid == -1) {
			write_msg( '用户不存在,或者被删除');
		} elseif ($uid == -2) {
			write_msg( '密码输入错误');
		} else {
			write_msg( '未定义操作');
		}
		exit;
	}
} 

//mymps登录
if($s_uid){
	
	if(PASSPORT_TYPE == 'phpwind' && $user_login['synlogin']){
		echo $user_login['synlogin'];
	} elseif(PASSPORT_TYPE == 'ucenter'){
		echo uc_user_synlogin($uid);
	}
	
	if(empty($row['status'])){
		write_msg('您的账号 [<b>'.$s_uid.'</b>] 目前处于<font color=red>待审状态</font>！<br>请进入邮箱查收验证邮件或等待客服人员开通账号！');
	} else {
		$member_log -> in($s_uid,md5($userpwd),$memory,'noredirect');
		echo mymps_goto($url ? $url : $mymps_global['SiteUrl'].'/member/index.php');
	}
	
}else{
	//$db->query("INSERT INTO `{$db_mymps}member_record_login` (id,userid,userpwd,pubdate,ip,result) VALUES ('','$userid','$userpwd','$logintime','$loginip','0')");
	write_msg("登录失败，您输入了错误的账号或密码！");
}
?>