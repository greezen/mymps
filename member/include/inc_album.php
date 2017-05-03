<?php
if(!defined('IN_MYMPS')) exit('Forbidden');

$ac = isset($_GET['ac']) ? trim($_GET['ac']) : (isset($_POST['ac']) ? trim($_POST['ac']) : '');
!in_array($ac,array('upload','list','edit','delete')) && $ac = 'list';
$mymps_image = '';

if(submit_check('album_submit')){
	
	$title = isset($_POST['title']) ? mhtmlspecialchars($_POST['title']) : '';
	include MYMPS_DATA.'/config.inc.php';
	require_once MYMPS_INC.'/upfile.fun.php';
	$name_file = 'album_up';
	
	if($ac == 'upload'){
		
		if(empty($title)) write_msg('','?m=album&type=corp&ac=upload&error=28');
		if ($_FILES[$name_file]['name']){
			check_upimage($name_file);
			$destination = "/album/".date('Ym')."/";
			$mymps_image = start_upload($name_file,$destination,$mymps_global['cfg_upimg_watermark'],$mymps_mymps['cfg_memberalbum_limit']['width'],$mymps_mymps['cfg_memberalbum_limit']['height']);
			$sql = "INSERT INTO `{$db_mymps}member_album` (id,title,path,prepath,pubtime,userid)
					Values('','$title','$mymps_image[0]','$mymps_image[1]','$timestamp','$s_uid')";
			$db->query($sql);
			unset($destination,$mymps_image);
		}else{
			write_msg('','?m=album&type=corp&ac=upload&error=29');
		}
		
		write_msg('','?m=album&type=corp&ac=upload&success=12');
		
	} elseif($ac == 'edit') {
		
		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
		$path = isset($_POST['path']) ? mhtmlspecialchars($_POST['path']) : '';
		$prepath = isset($_POST['prepath']) ? mhtmlspecialchars($_POST['prepath']) : '';
		if(empty($id)) write_msg('','?m=album&type=corp&ac=list&error=1');
		if(empty($title)) write_msg('','?m=album&type=corp&ac=edit&error=28&id='.$id);
		
		if ($_FILES[$name_file]['name']){
			check_upimage($name_file);
			$destination="/album/".date('Ym')."/";
			$mymps_image=start_upload($name_file,$destination,1,$mymps_mymps['cfg_memberalbum_limit']['width'],$mymps_mymps['cfg_memberalbum_limit']['height'],$path,$prepath);
			$path = $mymps_image[0];
			$prepath = $mymps_image[1];
			unset($destination,$mymps_image);
		}
		
		$db->query("UPDATE `{$db_mymps}member_album` SET title = '$title',path = '$path', prepath = '$prepath',pubtime = '$timestamp' $where AND id = '$id'");
		write_msg('','?m=album&type=corp&ac=edit&success=8&id='.$id);
		
	}
	
} else {
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	if($ac == 'upload'){
	
	} elseif($ac == 'list') {
		$sql 		= "SELECT * FROM {$db_mymps}member_album $where ORDER BY id DESC";
		$rows_num 	= mymps_count("member_album",$where);
		$param		= setParam(array('m','type','ac'));
		$album  	= page1($sql);
	} elseif($ac == 'edit') {
		if(empty($id)) write_msg('','?m=album&type=corp&error=1');
		$edit = $db->getRow("SELECT id,title,path,prepath FROM `{$db_mymps}member_album` $where AND id  = '$id'");
		if(empty($edit['id'])) write_msg('','?m=album&type=corp&ac=list&error=27');
	} elseif($ac == 'delete') {
		if(empty($id)) write_msg('','?m=album&type=corp&error=1');
		if(!$row = $db->getRow("SELECT path,prepath FROM `{$db_mymps}member_album` $where AND id  = '$id'")){
			write_msg('','?m=album&type=corp&ac=list&error=27');
		} else {
			@unlink(MYMPS_ROOT.$row['path']);
			@unlink(MYMPS_ROOT.$row['prepath']);
			$res = $db->query("DELETE FROM `{$db_mymps}member_album` $where AND id  = '$id'");
		}
		write_msg('','?m=album&type=corp&ac=list&success=8');
	}
	$location = location('corp');
	include mymps_tpl('album_'.(in_array($ac,array('upload','edit')) ? 'upload' : $ac));
	unset($album);
}
?>