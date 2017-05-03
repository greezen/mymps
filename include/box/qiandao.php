<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
require_once MYMPS_INC."/cache.fun.php";
require_once MYMPS_INC."/member.class.php";
if(!$member_log->chk_in()) write_msg("对不起,您还没有登录！");

$row = $db -> getRow("SELECT id,score,qdtime FROM `{$db_mymps}member` WHERE userid = '$s_uid'");
$score_change = get_credit_score();
$score_changer = $score_change['score']['rank']['login'];
if(!empty($score_changer)){
	$qdtime = GetTime($row['qdtime'],'ymd');
	$nowtime = GetTime($timestamp,'ymd');
	
	if($qdtime != $nowtime){
		
		if(!empty($score_changer)){
			$db->query("UPDATE `{$db_mymps}member` SET score = score".$score_changer.",qdtime='$timestamp' WHERE userid = '$s_uid'");
		}
		$score = $db->getOne("SELECT score FROM `{$db_mymps}member` WHERE userid = '$s_uid'");
		include MYMPS_ROOT.'/template/box/qiandao.html';
		
	}else{
		echo '<p style="font-size:12px;margin:30px 10px;">今天您已经签到过了，明天再来吧！</p>';
	}
}
$row = $score = NULL;
?>