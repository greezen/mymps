<?php
if(!defined('IN_MYMPS')) exit('Forbidden');
$status	= !empty($_GET['status']) ? trim($_GET['status']) : 'N';

$act = isset($_GET['act']) ? trim($_GET['act']) : '';

require_once MEMBERDIR.'/include/common.func.php';
require_once MYMPS_ROOT .'/plugin/property/include/functions.php';
require_once MYMPS_ROOT .'/plugin/property/include/Constants.php';

if($act == 'address'){
	
	$room_id = empty($_POST['room_id'])?0:intval($_POST['room_id']);
	if (empty($room_id)) {
		echo 'error1';exit;
	}
	$uid = $db->getOne("SELECT id FROM ".$db_mymps."member WHERE userid='{$s_uid}'");
	$sql = "UPDATE ".$db_mymps."property SET uid='{$uid}' WHERE room_id={$room_id} AND uid=0";
	$sql1 = "UPDATE ".$db_mymps."member SET room_id='{$room_id}' WHERE id={$uid}";
	if ($db->query($sql) && $db->query($sql1)) {
		echo 'ok';exit;
	}
	echo 'error2';exit;
} elseif ($act == 'pay') {
    include mymps_tpl('pay');
}else {

	require_once MYMPS_DATA.'/info.level.inc.php';
	runcron();
	$user = $db->getRow("SELECT * FROM ".$db_mymps."member WHERE userid='{$s_uid}'");
	$uid = $user['id'];
	$room_id = $user['room_id'];
	
	if (empty($room_id)) {
		$province_list = $db->getall("SELECT * FROM `" . $db_mymps . "province` ORDER BY displayorder ASC");

	} else {
		$where = " WHERE status='{$status}' AND room_id={$room_id} AND uid={$uid}";

		$sql = "SELECT COUNT(*) total FROM ". $db_mymps . "property " . $where;
		$rows_num = $db->getOne($sql);
		$per_page = 20;
		$pages_num = ceil($rows_num / $per_page);
		$page = empty($page) ? 1 : $page;
		$offset = ($page - 1) * $per_page;
		$param = 'm=property&status='.$status.'&';

		$sql1 = "SELECT * FROM ". $db_mymps . "property {$where} LIMIT {$offset},{$per_page}";
		$list = $db->getAll($sql1);
	}

	//$location = location();
	include mymps_tpl('property');
	
}
?>