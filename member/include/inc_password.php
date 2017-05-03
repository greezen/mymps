<?php
if(!defined('IN_MYMPS')) exit('Forbidden');
if(submit_check('password_submit')){
	
	$curuserpwd = $_POST['curuserpwd'] ? mhtmlspecialchars($_POST['curuserpwd']) : '';
	$userpwd = $_POST['userpwd'] ? mhtmlspecialchars($_POST['userpwd']) : '';
	$reuserpwd = $_POST['reuserpwd'] ? mhtmlspecialchars($_POST['reuserpwd']) : '';
	if(empty($curuserpwd)) write_msg('','?m=password&error=48');
	if(md5($curuserpwd) != $row['userpwd']) write_msg('','?m=password&error=47');
	if(!empty($userpwd) && ($userpwd != $reuserpwd)) write_msg('','?m=password&error=20');
	
	if(PASSPORT_TYPE == 'phpwind'){
		//pw整合
		require MYMPS_ROOT.'/pw_client/uc_client.php';
		$pw_user = uc_user_get($s_uid);
		$result = uc_user_edit($pw_user['uid'], $pw_user['username'], '', md5($userpwd), '');
		if($result == 1){

		} elseif ($result == -3) {
			write_msg('','?m=password&error=21');
		} elseif ($result == -4) {
			write_msg('','?m=password&error=23');
		} elseif ($result == -2) {
			write_msg('','?m=password&error=24');
		} elseif ($result == -1) {
			write_msg('','?m=password&error=24');
		} else {
			write_msg('','?m=password&error=26');
		}
	
	} elseif(PASSPORT_TYPE == 'ucenter') {
		//UC整合
		require MYMPS_ROOT.'/uc_client/client.php';
		$result =  uc_user_edit($s_uid, $userpwd, $userpwd, $email, 1);
		if($result == 1) {

		} elseif ($result == -4) {
			write_msg('','?m=password&error=21');
		} elseif ($result == -5) {
			write_msg('','?m=password&error=22');
		} elseif ($result == -6) {
			write_msg('','?m=password&error=23');
		} elseif ($result == -8) {
			write_msg('','?m=password&error=24');
		} elseif ($result == -1) {
			write_msg('','?m=password&error=25');
		} else {
			write_msg('','?m=password&error=26');
		}
	}
	
	if (!empty($userpwd)){
		$sql = "UPDATE `{$db_mymps}member` SET userpwd='".md5($userpwd)."' WHERE userid = '$s_uid'";
	} else {
		write_msg('','?m=password&error=13');
	}
	
	$db->query($sql);
	write_msg('','?m=password&success=8');

}else{
	$location = location();
	include mymps_tpl('password');
}
?>