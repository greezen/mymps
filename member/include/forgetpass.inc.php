<?php
if($action == 'sendmail'){
	
	$email = isset($email) ? mhtmlspecialchars($email): '';
	if($authcodesettings['forgetpass'] == 1 && !$randcode = mymps_chk_randcode($checkcode)){write_msg('验证码输入错误，请返回重新输入');}
	empty($email)  && write_msg("请填写电子邮箱地址！");
	//if(mgetcookie('emailsended'.$email) == 1){write_msg("休息一会再发送邮件");}
	$user_info = $db ->getRow("SELECT * FROM `{$db_mymps}member` WHERE email = '$email'");
	if ($user_info['userid']){
		require MYMPS_INC.'/email.fun.php';
		$code = base64_encode($user_info['id'].".".md5($user_info['id'].'+'.$user_info['userpwd']).'.'.$timestamp);
		
		globalassign();
		if (send_pwd_email($user_info['id'], $user_info['userid'], $email, $code)){
			//msetcookie("emailsended".$userinfo['email'],1);
			$status = 'error2';
			include mymps_tpl($mod.'_2');
		}else{
			$status = 'error2';
			$msg = '发送邮件失败，请联系客服：'.$mymps_global["SiteTel"].'重设密码！';
			include mymps_tpl($mod.'_4');
		}
	
	}else{
	
		$status = 'error2';
		$msg = '该电子邮箱或用户名不存在！请联系客服：'.$mymps_global["SiteTel"].'！';
		globalassign();
		include mymps_tpl($mod.'_4');
	
	}
	
} elseif($action == 'resetpwd'){
	$uid = $uid ? intval($uid) : '';
	$userid = $userid ? mhtmlspecialchars($userid) : '';
	$userpwd = $userpwd ? mhtmlspecialchars($userpwd) : '';
	$email = $email ? mhtmlspecialchars($email) : '';
	if(empty($userpwd)) write_msg('请输入你的新密码！');
	if(PASSPORT_TYPE == 'phpwind'){
		//pw整合
		require MYMPS_ROOT.'/pw_client/uc_client.php';
		$pw_user = uc_user_get($userid);
		$result = uc_user_edit($pw_user['uid'], $pw_user['username'], '', md5($userpwd), '');
	} elseif(PASSPORT_TYPE == 'ucenter') {
		//UC整合
		require MYMPS_ROOT.'/uc_client/client.php';
		$result =  uc_user_edit($userid, $userpwd, $userpwd, $email, 1);
	}
	
	if (!empty($userpwd)){
		$db->query("UPDATE `{$db_mymps}member` SET userpwd='".md5($userpwd)."' WHERE id = '$uid'");
		$status = 'success';
	} else {
		$status = 'error';
		$msg = '未定义错误，密码修改失败！';
	}
	
	globalassign();
	include mymps_tpl($mod.'_4');
}
?>