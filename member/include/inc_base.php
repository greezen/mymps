<?php
if(!defined('IN_MYMPS')) exit('Forbidden');
if($ac == 'nobind'){
	$db->query("UPDATE `{$db_mymps}member` SET openid = '' $where");
	write_msg('','index.php?m=base&success=15');
}
if(submit_check('base_submit')){
	$isemail = isset($_POST['isemail']) ? intval($_POST['isemail']) : '';
	$isqq = isset($_POST['isqq']) ? intval($_POST['isqq']) : '';
	$istel = isset($_POST['istel']) ? intval($_POST['istel']) : '';
	$mobile = isset($_POST['mobile']) ? trim(mhtmlspecialchars($_POST['mobile'])) : '';
	$cname = isset($_POST['cname']) ? trim(mhtmlspecialchars($_POST['cname'])) : '';
	$qq = isset($_POST['qq']) ? trim(mhtmlspecialchars($_POST['qq'])) : '';
	$email = isset($_POST['email']) ? trim(mhtmlspecialchars($_POST['email'])) : '';
	$url = isset($_POST['url']) ? trim(mhtmlspecialchars($_POST['url'])) : '';
	$sex = isset($_POST['sex']) ? trim(mhtmlspecialchars($_POST['sex'])) : '';
	
	$isemail == 1 && $db -> query("UPDATE `{$db_mymps}information` SET email = '$email' {$where}");
	$isqq == 1 && $db -> query("UPDATE `{$db_mymps}information` SET qq = '$qq' {$where}");
	$istel == 1 && $db -> query("UPDATE `{$db_mymps}information` SET tel = '$mobile' {$where}");
	
	if($email == '' && $qq == '' && $tel == '') write_msg('','?m=base&error=11');
	
	$db -> query("UPDATE `{$db_mymps}member` SET qq = '$qq', mobile = '$mobile' ,cname = '$cname', email = '$email' , sex = '$sex'  {$where}");
	write_msg('',$url ? $url : '?m=base&success=1');
} else {
	$location = location();
	include mymps_tpl('base');
}
?>