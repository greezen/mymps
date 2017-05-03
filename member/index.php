<?php
define('CURSCRIPT','index');
define('IN_MYMPS',true);
define('IN_MEMBERADMIN',true);
define('MEMBERDIR',dirname(__FILE__));

require_once MEMBERDIR.'./../include/global.php';
require_once MEMBERDIR.'./../data/config.php';
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';
require_once MYMPS_INC.'/cache.fun.php';

$uid = $s_uid = $s_pwd = $mymps_image = '';

require_once MYMPS_INC."/member.class.php";
if(!$log = $member_log->chk_in()) write_msg("","../".$mymps_global['cfg_member_logfile']."?url=".urlencode(GetUrl()));

$box= isset($_REQUEST['box']) ? intval($_REQUEST['box']) : 0;
$type = isset($_GET['type']) ? mhtmlspecialchars($_GET['type']) : '';
$type = in_array($type,array('user','corp')) ? $type : 'user';
$m  = isset($_REQUEST['m']) ? trim(mhtmlspecialchars($_REQUEST['m'])) : '';
$ac = isset($_REQUEST['ac']) ? trim(mhtmlspecialchars($_REQUEST['ac'])) : '';
$success = isset($_GET['success']) ? intval($_GET['success']) : '';
$error = isset($_GET['error']) ? intval($_GET['error']) : '';
$alert = isset($_GET['alert']) ? intval($_GET['alert']) : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$selectedids = isset($_POST['selectedids']) ? mhtmlspecialchars($_POST['selectedids']) : '';
$deleteids = isset($_POST['deleteids']) ? mhtmlspecialchars($_POST['deleteids']) : '';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
$userpwd = isset($_POST['userpwd']) ? mhtmlspecialchars($_POST['userpwd']) : '';
$reuserpwd = isset($_POST['reuserpwd']) ? mhtmlspecialchars($_POST['reuserpwd']) : '';
$safequestion = isset($_POST['safequestion']) ? mhtmlspecialchars($_POST['safequestion']) : '';
$safeanswer = isset($_POST['safeanswer']) ? mhtmlspecialchars($_POST['safeanswer']) : '';

$where = 'WHERE userid = \''.$s_uid.'\'';
$wherea = 'WHERE a.userid = \''.$s_uid.'\'';

$row = '';
$row = $db -> getRow("SELECT * FROM `{$db_mymps}member` $where");
$face = $row['prelogo'];
$normalface = $row['logo'];
$money_own = $row['money_own'];
$pm_total = mymps_count("member_pm","WHERE touser = '$s_uid' AND if_read = '0'");
$levelid = $row['levelid'];
$group = get_member_group($levelid);
$levelname = $group['levelname'];
$per_certify = $row['per_certify'];
$com_certify = $row['com_certify'];
$if_corp	 = $row['if_corp'];
$uid		= $row['id'];
$cityid		= $row['cityid'];

$allowm = $mymps_global['cfg_if_corp'] == 1 ? array('info','pm','base','avatar','levelup','certify','pay','password','album','comment','document','certifycorp','shop','goods','shoucang') : array('info','pm','base','avatar','levelup','certify','pay','password','shoucang');

require_once MEMBERDIR.'/include/mymps.menu.inc.php';
is_array($data) && $allowm = array_merge(array_keys($data),$allowm);

if(!in_array($m,$allowm)) $m = 'index';
unset($data,$allowm);

$m != 'index' && chk_member_purview('purview_'.$m);

if($alert){
	/*积分变化提醒*/
	$score_change = get_credit_score();
	if($alert == 1){
		$score_changer = $score_change['score']['rank']['login'];
	} elseif ($alert == 2){
		$score_changer = $score_change['score']['rank']['coupon'];
	} elseif ($alert == 3) {
		$score_changer = $score_change['score']['rank']['group'];
	} elseif ($alert == 4) {
		$score_changer = $score_change['score']['rank']['goods'];
	}
	if(empty($score_changer)) $alert = NULL;
	$score_changer = ' <font color=red><b>'.$score_changer.'</font></b>';
}

if($if_corp != 1 && in_array($m,array('goods','coupon','group','document','certifycorp','album','comment'))) write_msg('您非商铺会员，请先申请网上店铺再进行操作！','index.php?m=shop');

include MEMBERDIR.'/include/inc_'.$m.'.php';

is_object($db) && $db -> Close();
$mymps_global = $m = $ac = $success = $error = $where = $page = $timestamp = $log = $member_log = $face = $money_own = NULL;
$levelid = $pm_total = $row = NULL;
unset($row);
if($selectedids) unset($selectedids);

function location($type='user',$str=''){
	global $mymps_global,$member_menu,$m;
	$raquo = '<span class="separator">&raquo;</span>';
	$return = '<a href="index.php"><span>用户中心</span></a> '.$raquo;
	$return .= $str != '' ?  ' <a href="index.php?m='.$m.'">'.($member_menu[$type][$m] != "" ? $member_menu[$type][$m] : "首页").'</a> '.$raquo.' <span>'.$str.'</span>' : ' '.($member_menu[$type][$m] != "" ? $member_menu[$type][$m] : "首页");
	return $return;
	unset($raquo,$return);
}
?>