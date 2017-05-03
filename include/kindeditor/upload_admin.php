<?php
define('IN_MYMPS',true);
define('IN_AJAX',true);
define("IN_JSON",true);

require_once 'JSON.php';

require_once dirname(__FILE__)."/../global.inc.php";
require_once MYMPS_INC."/global.php";
require_once MYMPS_DATA."/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/upfile.fun.php";
require_once MYMPS_INC."/admin.class.php";
require_once MYMPS_INC."/db.class.php";

if(!$mymps_admin -> mymps_admin_chk_getinfo()){
	alert("您尚未登录管理员，不能上传图片.");
}

$watermark	= isset($watermark) ? $watermark : '';
$dopost		= isset($dopost)	? $dopost	 : '';
$imgwidthValue = isset($imgwidthValue) ? $imgwidthValue : 400;
$imgheightValue = isset($imgheightValue) ? $imgheightValue : 300;
$urlValue	= isset($urlValue)	? $urlValue	 : '';
$imgsrcValue= isset($imgsrcValue)?$imgsrcValue:'';
$imgurl		= isset($imgurl)	? $imgurl 	 :'';
$small		= isset($small)		? $small	 :'';

//有上传文件时
if (empty($_FILES) === false) {
	$name_file = 'imgFile';
	
	$size=$mymps_global['cfg_upimg_size']*1024;
	$upimg_allow = explode(',',$mymps_global['cfg_upimg_type']);
	if($_FILES[$name_file]['size']>$size){
		alert('上传文件应小于'.$mymps_global['cfg_upimg_size'].'KB');
	}
	
	if(!in_array(FileExt($_FILES[$name_file]['name']),$upimg_allow)){
		alert('系统只允许上传'.$mymps_global['cfg_upimg_type'].'格式的图片！');
	}
	
	if(!preg_match('/^image\//i',$_FILES[$name_file]['type'])){
		alert('很抱歉，系统无法识别您上传的文件的格式，请换一张图片上传！');
	}
	
	$destination='/editor/'.date('Ym').'/';
	
	if($_FILES[$name_file]['name']){

		$mymps_image = start_upload($name_file,$destination,$mymps_global[cfg_upimg_watermark]);
		$imgsrcValue = $mymps_image;
		
		$full_litfilename = $full_filename = MYMPS_ROOT.$mymps_image;
		
		$sizes = getimagesize($full_filename);
		$imgwidthValue = $sizes[0];
		$imgheightValue = $sizes[1];
		$imgsize = filesize($full_litfilename);

		$db -> query ("INSERT INTO `{$db_mymps}upload` (title,url,width,height,filesize,uptime,adminid) VALUES ('{$mymps_image[0]}','$imgsrcValue','$imgwidthValue','$imgheightValue','{$imgsize}','{$nowtime}','{$admin_id}')");
		$file_url = $mymps_global[SiteUrl].$imgsrcValue;
	}
	
	header('Content-type: text/html; charset=utf-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	global $charset;
	header('Content-type: text/html; charset=utf-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
?>