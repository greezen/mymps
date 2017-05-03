<?php
if(!defined('IN_MYMPS')) exit('Forbidden');
//$if_corp != 1 && write_msg('您目前尚未开通商家管理后台，请联系管理员','olmsg');
$do_act = isset($_REQUEST['do_act']) ? trim($_REQUEST['do_act']) : '';
if(submit_check('comment_submit')){
	
	switch($do_act){
		case 'reply':
			empty($id) && write_msg('','?m=comment&type=corp&error=1&id='.$id);
			$reply = isset($_POST['reply']) ? textarea_post_change($_POST['reply']) : '';
			
			$db -> query("UPDATE `{$db_mymps}member_comment` SET reply = '$reply',retime = '$timestamp' $where AND id = '$id'");
			write_msg('','?m=comment&type=corp&success=8&c='.$c.'&id='.$id);
		break;
		default:
			empty($selectedids) && write_msg('','?m=comment&type=corp&error=1&page='.$page.'&t='.$t.'&c='.$c);
			$db -> query("DELETE FROM `{$db_mymps}member_comment` {$where} AND id ".create_in($selectedids));
			write_msg('','?m=comment&type=corp&success=3&page='.$page.'&t='.$t.'&c='.$c);
		break;
	}
	
} else {
	
	if(empty($id)){

		$t = isset($_GET['t']) ? trim($_GET['t']) : '';
		$c	  = isset($_GET['c'])	 ? trim($_GET['c'])	   : '';
		!in_array($c,array('good','middle','bad','all')) && $c = 'all';
		!in_array($t,array('lastweek','lastmonth','last3month','all')) && $t = 'all';
		
		$lastweek  	= $timestamp - 86400*7;
		$lastmonth	= $timestamp - 86400*30;
		$last3month = $timestamp - 86400*90;
		
		if($t == 'lastweek'){
			$where .= " AND pubtime >= '$lastweek'";
		} elseif($t == 'lastmonth') {
			$where .= " AND pubtime >= '$lastmonth'";
		} elseif($t == 'last3month') {
			$where .= " AND pubtime >= '$last3month'";
		}
		
		unset($lastweek,$lastmonth,$last3month);
		
		if($c == 'good'){
			$where .= " AND enjoy IN('2','3')";
		} elseif($c == 'middle'){
			$where .= " AND enjoy = '1'";
		} elseif($c == 'bad'){
			$where .= " AND enjoy = '0'";
		}
		
		$rows_num = mymps_count("member_comment",$where);
		$param	  = setParam(array('m','t','c','type'));
		$comment  = page1("SELECT * FROM `{$db_mymps}member_comment` {$where} ORDER BY id DESC");
		$count	  = get_comment_count();
		$location = location('corp');
		include mymps_tpl('comment');

	} else {
		
		$comment = $db -> getRow("SELECT * FROM `{$db_mymps}member_comment` {$where} AND id = '$id'");
		if(!$comment['id']){
			write_msg('操作失败！该评论并不存在！');
		}
		$c = $comment['enjoy'] == 1 ? 'middle' : ($comment['enjoy'] == 0 ? 'bad' : 'good');
		$location = location('corp');
		include mymps_tpl('comment_reply');
		
	}
	
}


function get_comment_count(){
	global $s_uid,$db,$db_mymps,$timestamp;
	$count  = array();
	$where 		= " WHERE userid = '$s_uid'";
	$lastweek 	= " AND pubtime >= '".($timestamp - 86400*7)."'";
	$lastmonth  = " AND pubtime >= '".($timestamp - 86400*30)."'";
	$last3month = " AND pubtime >= '".($timestamp - 86400*90)."'";
	$ago3month = " AND pubtime < '".($timestamp - 86400*90)."'";
	$wms		= " ";
	
	$good	= " AND enjoy IN('2','3')";
	$middle = " AND enjoy = '1'";
	$bad	= " AND enjoy = '0'";
	$gmb	= "";
	
	$sql 	= "SELECT COUNT(id) FROM `{$db_mymps}member_comment` {$where}";
	foreach(array('good','bad','middle') as $k => $v){
		foreach(array('lastweek','last3month','lastmonth','ago3month','wms') as $key => $val){
			$count[$v][$val] = $db -> getOne($sql.${$v}.${$val});
		}
	}
	unset($lastweek,$lastmonth,$last3month);
	return $count;
}
?>