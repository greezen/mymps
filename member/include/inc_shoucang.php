<?php
if(!defined('IN_MYMPS')) exit('Forbidden');
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : '';

require_once MEMBERDIR.'/include/common.func.php';

if($ac == 'del'){

	empty($selectedids) && write_msg('','?m=shoucang&error=1&page='.$page);
	$db -> query("DELETE FROM `{$db_mymps}shoucang` {$where} AND id ".create_in($selectedids));
	write_msg('','?m=shoucang&success=3&page='.$page);

}elseif($ac == 'delthis'){
	
	if(!$id) write_msg('','?m=shoucang&error=1&page='.$page);
	$db->query("DELETE FROM `{$db_mymps}shoucang` WHERE id = '$id' AND userid = '$s_uid'");
	write_msg('','?m=shoucang&success=3&page='.$page);
	
} else {
	
	$sql = "SELECT * FROM {$db_mymps}shoucang $where ORDER BY id DESC";
	
	$rows_num = mymps_count("shoucang",$where);
	$param	  = setParam(array("m"));
	$list     = array();
	
	foreach(page1($sql) as $k => $row){
		$arr['id']          = $row['id'];
		$arr['title']  	    = SpHtml2Text($row['title']);
		$arr['intime']   	= get_format_time($row['intime']);
		$arr['url']  		= $row['url'];
	
		$list[]= $arr;
	}
	$location = location();
	include mymps_tpl('shoucang');
	
}
?>