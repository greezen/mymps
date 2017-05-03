<?php
define('IN_MYMPS', true);
define('IN_AJAX', true);
define('CURSCRIPT', 'upfile');

include dirname(__FILE__)."/../../include/global.php";
require_once MYMPS_DATA."/config.inc.php";
require_once MYMPS_DATA."/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/admin.class.php";
require_once MYMPS_INC."/db.class.php";

if(!$mymps_admin -> mymps_admin_chk_getinfo()){
	exit('Access Denied!');
} else {
	define('IN_ADMIN' , true);
}

$destination = isset($destination) ? trim($destination) : '';
if($delfile){
	if($adv == 1) $delfile == str_replace($mymps_global['SiteUrl'],'',$delfile);
	@unlink(MYMPS_ROOT.trim($delfile));
}
$id			 = isset($id)	 ? trim($id) 		: 'imgsrc';
$adv		 = intval($adv);

if(is_array($_FILES) && submit_check(CURSCRIPT.'_submit')){
	!$destination && $destination = 'other';
	require_once(MYMPS_INC."/upfile.fun.php");
	$name_file = 'mymps_img';
	check_upimage($name_file);
	if($_FILES[$name_file]['name']){
		$watermark 	 = !empty($watermark) ? $mymps_global['cfg_upimg_watermark'] : 0;
		if($mymps_image = start_upload($name_file,"/".$destination."/".date('Ym')."/",$watermark,$width,$height)){
			$msg 	= '图片上传成功！';
			$path 	= $mymps_image;
		} else {
			$msg 	= '图片上传失败！';
			$path 	= '';
		}
	} else {
		$msg 	= '图片上传失败！';
		$path 	= '';
	}
	
	echo "<script laguage=javascript>alert('".$msg."');window.parent.document.getElementById(\"".$id."\").value='".($adv == 1 ? $mymps_global['SiteUrl'] : '').$path."';</script><a href='?adv=1&destination=$destination&watermark=$watermark&delfile=".$path."' style='font-size:12px'>点此重新上传图片</a>";

} else {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
		<title>upfile</title>
		<link href='../css/mymps.css' rel='stylesheet' type='text/css'>
		<script language="javascript" src="../js/vbm.js"></script>
		<body style=" margin:0; padding:0px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px #c5d8e8 solid; padding:22px; background-color:#f5fbff">
				<form name="form1" enctype="multipart/form-data" action="?" method="post">
					<input name="destination" value="<?=$destination?>" type="hidden">
					<input name="width" value="<?=$width?>" type="hidden">
					<input name="height" value="<?=$height?>" type="hidden">
					<input name="watermark" value="<?=$watermark?>" type="hidden">
					<input name="adv" value="1" type="hidden">
					<tr>
						<td rowspan="3" width="180"><img src="../template/images/pview.gif" width="150" id="picview" name="picview" /></td>
						<td valign="top"><input name="mymps_img" type="file" id="litpic" style="width:200px; border:1px #999 solid; float:left" onchange="SeePic(document.picview,document.form1.litpic);"/>
						</td>
					</tr>
					<tr>
						<td valign="bottom"><input name="upfile_submit" type="submit" value="开始上传" class="gray mini"/></td>
					</tr>
				</form>
			</table>
		</body>
		</html>
		<?
	}
	?>