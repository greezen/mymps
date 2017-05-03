<?php
if(!defined('IN_MYMPS')) {
	exit('Access Denied');
}
$db->query("UPDATE `{$db_mymps}information` SET upgrade_type = '1',upgrade_time = '0' WHERE upgrade_time < '$timestamp'");
$db->query("UPDATE `{$db_mymps}information` SET upgrade_type_list = '1',upgrade_time_list = '0' WHERE upgrade_time_list < '$timestamp'");
$db->query("UPDATE `{$db_mymps}information` SET upgrade_type_index = '1',upgrade_time_index = '0' WHERE upgrade_time_index < '$timestamp'");
?>