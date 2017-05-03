<?php
if(!defined('IN_MYMPS')) exit('FORBIDDEN');
include MYMPS_DATA.'/config.inc.php';
if(submit_check('avatar_submit')){
	require_once MYMPS_INC."/upfile.fun.php";
	$name_file = "mymps_member_logo";
	if ($_FILES[$name_file]["name"]){
		check_upimage($name_file);
		$destination = "/face/".date('Ym')."/";
		$mymps_image = start_upload($name_file,$destination,0,$mymps_mymps['cfg_memberlogo_limit']['width'],$mymps_mymps['cfg_memberlogo_limit']['height']);
		@unlink(MYMPS_ROOT.$face);
		@unlink(MYMPS_ROOT.$normalface);
		$db->query("UPDATE `{$db_mymps}member` SET logo='$mymps_image[0]',prelogo='$mymps_image[1]' $where");
		unset($mymps_mymps,$destination,$name_file,$mymps_image);
		write_msg('','?m=avatar&success=8');
	} else {
		write_msg('','?m=avatar&error=13');
	}
}else{
	$location = location();
	include mymps_tpl('avatar');
}
?>