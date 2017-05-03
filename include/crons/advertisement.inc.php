<?php
if(!defined('IN_MYMPS')) {
	exit('Access Denied');
}

$db->query("UPDATE `{$db_mymps}advertisement` SET available = '0' WHERE endtime < '$timestamp' AND endtime <> '0'");

foreach(array('index','category','info','other') as $ranges){
	clear_cache_files('adv_'.$ranges);
}
updateadvertisement();
?>