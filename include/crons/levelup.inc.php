<?php
if(!defined('IN_MYMPS')) {
	exit('Access Denied');
}
$db->query("UPDATE `{$db_mymps}member` SET levelid = '2',levelup_time='0' WHERE levelup_time < '$timestamp' AND levelup_time > '0'");
?>