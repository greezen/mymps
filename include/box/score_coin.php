<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
require_once MYMPS_INC."/member.class.php";
if(!$member_log->chk_in()) write_msg("对不起,您还没有登录！");

$row = $db -> getRow("SELECT score FROM `{$db_mymps}member` WHERE userid = '$s_uid'");

if($action == 'post'){
	$score = isset($_POST['score']) ? intval($_POST['score']) : '';
	if(!$score) write_msg('请输入您要兑换的积分数额。');
	
	if($score > $row['score']) write_msg('您输入的积分数额已经超过您的用户积分');
	$coin = floor($score/$mymps_global['cfg_score_fee']);
	if(empty($coin)) write_msg('兑换失败，请重新设置有效的兑换积分');
	$db -> query("UPDATE `{$db_mymps}member` SET score = score - ".$score.",money_own=money_own + ".$coin." WHERE userid = '$s_uid'");
	
	write_msg('兑换成功! 您的帐户已成功增加<font color=red>'.$coin.'</font>金币<br /><br /><input value="关闭窗口" type="button" onclick=\'parent.window.location.reload();parent.closeopendiv();\' style="margin-left:auto;margin-right:auto;" class="blue">','olmsg');
} else {
	include MYMPS_ROOT.'/template/box/score_coin.html';
}
$row = $coin = $score = NULL;
?>