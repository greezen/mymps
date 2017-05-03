<?php
if(!defined('IN_MYMPS')) exit('Forbidden');
require_once MEMBERDIR.'/include/common.func.php';
!in_array($ac,array('outbox','inbox','sendnew','view')) && $ac = 'inbox';
$touser 	= isset($_REQUEST['touser']) 	? mhtmlspecialchars($_REQUEST['touser']) : '';
if(submit_check('pm_submit')){
	$title 		= isset($_POST['title']) 	? mhtmlspecialchars($_POST['title']) 	: '';
	$content 	= isset($_POST['content']) 	? mhtmlspecialchars($_POST['content']) 	: '';
	if(is_array($deleteids)){
		$where = $ac == 'inbox' ? "touser = '$s_uid'" : "fromuser = '$s_uid'";
		$db -> query("DELETE FROM `{$db_mymps}member_pm` WHERE {$where} AND id ".create_in($deleteids));
		write_msg('','?m=pm&success=8&ac='.$ac.'&page='.$page);
	}else{
		if(empty($touser)) write_msg('','?m=pm&error=1&ac='.$ac.($id != '' ? '&id='.$id : ''));
		if(empty($title) && empty($content)) write_msg('','?m=pm&error=10&ac='.$ac);
		$content = textarea_post_change($content);
		$result	 = sendpm($s_uid,$touser,$title,$content);
		$url = $result['succ'] == 'yes' ? '?m=pm&success=7&ac='.$ac : '?m=pm&error=9&ac='.$ac;
		$url .= '&id='.$id;
		write_msg('',$url);
	}
} else {
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	if(!empty($id)){
		$db -> query("UPDATE `{$db_mymps}member_pm` SET `if_read` = '1' WHERE id = '$id'");
		$pm = $db -> getRow("SELECT * FROM `{$db_mymps}member_pm` WHERE id = '$id'");
		if($pm['id'] == '') write_msg('','?m=pm&error=12&ac='.$ac.'&page='.$page);
	}elseif(empty($id) && in_array($ac,array('inbox','outbox'))){
		$where = $ac == 'inbox' ? " WHERE touser = '$s_uid'" : " WHERE fromuser = '$s_uid'";
		$sql 	  = "SELECT * FROM `{$db_mymps}member_pm` $where ORDER BY pubtime DESC";
		$rows_num = mymps_count("member_pm",$where);
		$param	  = setParam(array('m','ac'));
		$pm 	  = page1($sql);
	}
	$location = location();
	include mymps_tpl('pm_'.($id != '' ? 'view' : $ac));
}
?>