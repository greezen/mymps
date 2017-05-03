<?php
if(!defined('IN_MYMPS')) exit('Forbidden');
$ac = !in_array($ac,array('person','com')) ? 'person' : trim($ac) ;

if(submit_check('certify_submit')){
	require_once MYMPS_INC.'/upfile.fun.php';
	$name_file = 'certify_image';
	$typeid = $ac == 'person' ? 2 : 1;
	if ($_FILES[$name_file]["name"]){
		check_upimage($name_file);
		$destination = '/certification/'.date("Ym").'/';
		$mymps_image = start_upload($name_file,$destination,0);
		$db->query("INSERT INTO `{$db_mymps}certification` SET typeid='$typeid',userid='$s_uid',img_path='$mymps_image',pubtime = '$timestamp'");
	} else {
		write_msg('','?m=certify&error=13');
	}
	write_msg('','?m=certify&success=9');
} else {
	if($pubtime = $db -> getOne("SELECT pubtime FROM `{$db_mymps}certification` $where ORDER BY pubtime DESC")) {
		$certifylang = '您已经于'.GetTime($pubtime).'提交过认证图片，确认要重新提交吗?';
	}
	$location = location();
	include mymps_tpl('certify');
}
?>