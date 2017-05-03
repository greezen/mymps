<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');

require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
$row = $db -> getRow("SELECT userpwd,if_corp,id FROM `{$db_mymps}member` WHERE userid = '$userid'");
$password = $row['userpwd'];
$uid = $row['if_corp'] == 1 ? $row['id'] : false;

include MYMPS_ROOT.'/template/box/member.html';
?>