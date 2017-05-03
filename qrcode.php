<?php
	define('CURSCRIPT','qrcode');
	define('IN_MYMPS', true);
	require_once dirname(__FILE__)."/include/global.php";
    require_once MYMPS_INC."/qrcode/phpqrcode.php";  
    $value = isset($value) ? $value : "";
	$size = isset($size)? $size : "5";
    $errorCorrectionLevel = "L";
    QRcode::png($value, false, $errorCorrectionLevel, $size);
    exit;
?> 