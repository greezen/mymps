<?php
if(file_exists(MYMPS_ROOT.$admindir."/global.php")){
	require_once MYMPS_ROOT.$admindir."/global.php";
}else{
	exit('ACCESS DENIED!');
}
require_once MYMPS_ROOT.$admindir."/include/".($admin_cityid ? 'mymps.citymenu.inc.php' : 'mymps.menu.inc.php');
include MYMPS_ROOT.'/template/box/adminmenu.html';
unset($admindir);
?>