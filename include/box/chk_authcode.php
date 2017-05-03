<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
$value = isset($_GET['value']) ? strip_tags(trim($_GET['value'])) : '';
require_once MYMPS_DATA."/config.db.php";
@header("Content-type: text/html; charset=".$charset);

require_once MYMPS_INC."/db.class.php";
if(empty($value)){
	echo "ЧыЪфШыбщжЄТы";
} else {

	echo 'success';
	
}
?>