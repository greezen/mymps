<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
define('IN_MYMPS',true);
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
$row = $db -> getRow("SELECT code FROM `{$db_mymps}advertisement` WHERE advid = '$id'");
echo '<style>body{font-size:12px;line-height:24px; padding:5px 0;}</style>'.$row[code].'</font>';
?>