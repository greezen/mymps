<?php
if (!defined('IN_MYMPS')){
    die('FORBIDDEN');
}
//check ifreadable ifwriteable of the file
//需检测读写权限的文件
//一般情况下，请保保持默认，勿修改
$sp_testdirs = array(
	'/attachment',
	'/backup',
	'/city',
	'/data/pagesinfo',
	'/data/pageslist',
	'/data/pagesmymps',
	'/data/cron.cache.php',
	'/data/config.php',
	'/data/config.db.php',
	'/data/cron.cache.php',
	'/data/sessions'
);
?>