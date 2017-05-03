<?php
if(!defined('IN_MYMPS')) exit('Forbidden');

$levelname = $db -> getOne("SELECT levelname FROM `{$db_mymps}member_level` WHERE id = '$levelid'");
$info_total = $db -> getOne("SELECT COUNT(id) FROM `{$db_mymps}information` $where");
if($if_corp == 1) {
	$document_total = $db -> getOne("SELECT COUNT(*) FROM `{$db_mymps}member_docu` $where");
	$album_total = $db -> getOne("SELECT COUNT(*) FROM `{$db_mymps}member_album` $where");
	$comment_total = $db -> getOne("SELECT COUNT(*) FROM `{$db_mymps}member_comment` $where");
	
	if(ifplugin('group')){
		$group_total  = $db -> getOne("SELECT COUNT(*) FROM `{$db_mymps}group` $where");
		$group_signin_total = $db -> getOne("SELECT COUNT(*) FROM `{$db_mymps}group_signin` AS a LEFT JOIN `{$db_mymps}group` AS b ON a.groupid = b.groupid  WHERE b.userid = '$s_uid'");
	}
	
	if(ifplugin('goods')){
		$goods_total  = $db -> getOne("SELECT COUNT(*) FROM `{$db_mymps}goods` $where");
		$goods_order_total = $db -> getOne("SELECT COUNT(*) FROM `{$db_mymps}goods_order` AS a LEFT JOIN `{$db_mymps}goods` AS b ON a.goodsid = b.goodsid  WHERE b.userid = '$s_uid'");
	}
	
	ifplugin('coupon') && $coupon_total  = $db -> getOne("SELECT COUNT(*) FROM `{$db_mymps}coupon` $where");
	
}
$location = location();
$spacestore = $row['if_corp'] == 1 ? Rewrite('store',array('uid'=>$uid)) : Rewrite('space',array('user'=>$s_uid));
$qdtime = GetTime($row['qdtime'],'ymd');
$nowtime = GetTime($timestamp,'ymd');

$score_change = get_credit_score();
$score_changer = intval($score_change['score']['rank']['login']);
include mymps_tpl('index');
unset($data,$levelname,$document_total,$album_total,$comment_total,$coupon_total,$group_total,$group_singin_total,$creditrank,$credit_score,$spacestore);
?>