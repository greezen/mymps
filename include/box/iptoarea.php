<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
$ip = isset($_GET['ip']) ? trim($_GET['ip']) : '';
$area 	= $address = $ipdata = '';
require_once MYMPS_INC.'/ip.class.php';
$ipdata  = new ip();
$address = $ipdata -> getaddress($ip);
$area = $address['area1'].$address['area2'];
include MYMPS_ROOT.'/template/box/iptoarea.html';
unset($ipdata,$address);
?>