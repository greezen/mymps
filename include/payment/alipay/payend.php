<?php
define('IN_MYMPS', true);
define('IN_ADMIN',true);
define('CURSCRIPT','payend');

require_once dirname(__FILE__).'/../../../include/global.php';
require_once MYMPS_DATA.'/config.php';
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';
require_once MYMPS_INC."/member.class.php";
if(!$member_log->chk_in()) write_msg("",$mymps_global['SiteUrl']."/".$mymps_global['cfg_member_logfile']."?url=".urlencode(GetUrl()));

$editor=1;

//订单号
/*if(!mgetcookie('checkpaysession')){
	write_msg('非法操作！','olmsg');
}else{
	msetcookie("checkpaysession","",0);
}*/

//操作事件
$pay_type = mgetcookie('pay_type');
/*
if($pay_type=='PayToMoney')//金币充值
{
	
}else{
	write_msg('您来自的链接不存在','olmsg');
}*/

$paytype='alipay';
$payr=$db->getRow("SELECT * FROM {$db_mymps}payapi WHERE paytype='$paytype'");
$bargainor_id=$payr['payuser'];//商户号
$key=$payr['paykey'];//密钥

$seller_email=$payr['payemail'];//卖家支付宝帐户

//----------------------------------------------返回信息

if(!empty($_POST)){
	foreach($_POST as $key => $data){
		$_GET[$key]=$data;
	}
}

$get_seller_email=rawurldecode($_GET['seller_email']);

//支付验证
ksort($_GET);
reset($_GET);

$sign='';
foreach($_GET AS $key=>$val){
	if($key!='sign'&&$key!='sign_type'&&$key!='code'){
		$sign.="$key=$val&";
	}
}
/*
$sign=md5(substr($sign,0,-1).$paykey);

if($sign!=$_GET['sign']){
	write_msg('验证MD5签名失败.','olmsg');
}
*/

if($_GET['trade_status']=="TRADE_FINISHED" || $_GET['trade_status']== "TRADE_SUCCESS" || $_GET['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS'|| $_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS'){
	include MYMPS_INC.'/pay.fun.php';
	
	$orderid=$_GET['trade_no'];	//支付订单
	$ddno=$_GET['out_trade_no'];	//网站的订单号
	$money=$_GET['total_fee'];
	
	if($_GET['trade_status']=="TRADE_FINISHED"){
		$paybz='支付完成';
	} elseif($_GET['trade_status']=="TRADE_SUCCESS"){
		$paybz='支付成功';
	} elseif($_GET['trade_status']=="WAIT_BUYER_CONFIRM_GOODS"){
		$paybz='充值确认中';
	} elseif($_GET['trade_status']=="WAIT_SELLER_SEND_GOODS"){
		$paybz='充值成功';
	}

	UpdatePayRecord($ddno,$paybz);//修改支付状态
	write_msg("您已成功充值 ".($money*$mymps_global['cfg_coin_fee'])." 个金币",$mymps_global['SiteUrl']."/member/index.php?m=pay&ac=record");
	//PayApiPayMoney($money,$paybz,$orderid,$uid,$s_uid,$paytype);
}

is_object($db) && $db -> Close();
$mymps_global = NULL;
?>