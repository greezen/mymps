<?php
error_reporting(E_ALL^E_NOTICE);
__FILE__ == '' && die('Fatal error code: 0');

define('IN_MYMPS',true);
define('CURRENTDIR',dirname(__FILE__));
define('MYMPS_DATA',dirname(__FILE__).'/data');
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());

if (isset($_REQUEST['GLOBALS']) OR isset($_FILES['GLOBALS'])) {
	exit('Request tainting attempted.');
}

@set_magic_quotes_runtime(0);
if(function_exists('date_default_timezone_set')) date_default_timezone_set('Hongkong');

if (defined('DEBUG_MODE') == false) define('DEBUG_MODE', 0);

if(PHP_VERSION < '4.1.0') {
	$_GET =	&$HTTP_GET_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	unset($HTTP_GET_VARS,$HTTP_SERVER_VARS);
}

$timestamp	= time();
$part = isset($_GET['part']) ? trim($_GET['part']) : 'authcode';
$wid = isset($_GET['wid']) ? intval($_GET['wid']) : '180';
$mod = isset($_GET['mod']) ? trim($_GET['mod']) : '';
!in_array($part,array('authcode','contact')) && exit('Access Denied');
if($part == 'authcode') {
	include CURRENTDIR.'/include/common.fun.php';
	include CURRENTDIR.'/include/cache.fun.php';
	include CURRENTDIR.'/include/MympsVerify.fun.php';
	$action = isset($_GET['action']) ? trim($_GET['action']) : 'action';
	if($action =='action'){
		if($mod != 'm'){
			session_save_path(CURRENTDIR.'/data/sessions');
		}else{
			session_save_path(CURRENTDIR.'/m/sessions');
		}
		session_start();
	}
	$data = read_static_cache('authcodesettings');
	$Line = $data['line'] ? $data['line']  : false;
	$Noise = $data['noise'] ? $data['noise'] : false;
	$Type  = $data['type'];
	$Distort = $data['distort'];
	$Incline = $data['incline'];
	$Close = $data['close'];
	$Number = $data['number'];
	
	if($action =='action'){
		$_SESSION['chkcode'] = GetMympsVerify($Type,$Noise,$Line,$Distort,$Incline,true,$Close,$Number);
	}else{
		GetMympsVerify($Type,$Noise,$Line,$Distort,$Incline,false,$Close,$Number);
	}
} elseif($part == 'contact') {
	$height = "24";
	$fontfile = CURRENTDIR.'/data/ttf/number.ttf';
	$strings = base64_decode(trim($_GET['strings']));
	$image  = imagecreatetruecolor($wid,$height);
	imagefilledrectangle($image,0,0,$wid,$height,imagecolorallocate($image,255,255,255));
	$fontcolor = imagecolorallocate($image,255,0,0);
	imagettftext($image, 12, 0, 0, $height*0.7, $fontcolor, $fontfile, $strings);
	header("Content-type: image/png");
	imagepng($image);
	imagedestroy($image);
	unset($wid,$height,$strings,$image,$black,$white);
}
?>