<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
require_once MYMPS_INC."/member.class.php";
$infoid = $_REQUEST['infoid'] ? intval($_REQUEST['infoid']) : '';
$if_view = $_REQUEST['if_view'] ? intval($_REQUEST['if_view']) : '';
!$infoid && write_msg('您提交的参数不正确!','olmsg');

if(!$member_log->chk_in()){
	@include MYMPS_DATA.'/caches/authcodesettings.php';
	$authcodesettings = $data;
	$data = NULL;
	$gourl = 'seecontact';
	include MYMPS_ROOT.'/template/box/login.html';
} else {
	if(!$row = $db -> getRow("SELECT a.*,b.usecoin FROM `{$db_mymps}information` AS a LEFT JOIN `{$db_mymps}category` AS b ON a.catid = b.catid WHERE a.id = '$infoid' AND a.info_level > 0")) write_msg('该信息不存在或者未经过审核！');
	
	if(mgetcookie('viewid') == $infoid || $row['userid'] == $s_uid){
		$view = 'yes';
	} else {
		$money_own = $db -> getOne("SELECT money_own FROM `{$db_mymps}member` WHERE userid = '$s_uid'");
		if($action == 'delmoney'){
			include MYMPS_ROOT.'/member/include/common.func.php';
			if($money_own >= $row['usecoin']){
				$db -> query("UPDATE `{$db_mymps}member` SET money_own = money_own - '$row[usecoin]' WHERE userid = '$s_uid'");
				write_money_use("查看编号为".$row[id]."的信息联系方式","<font color=red>扣除金币 ".$row[usecoin]." </font>");
			} else {
				write_msg('您当前拥有的金币不足，请先充值！',$mymps_global['SiteUrl'].'/member/index.php?m=pay&box=1');
			}
			$view = 'yes';
			$row['ip'] = $row['ip'] != '' ? part_ip($row['ip']) : '';
			msetcookie('viewid',$infoid,$timestamp+3600*24);//24小时后过期
		} else {
			$view = 'no';
		}
	}
		
	include MYMPS_ROOT.'/template/box/seecontact.html';
}

$row = $infoid = $db = $mymps_global = $if_view = NULL;
?>