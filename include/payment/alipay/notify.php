<?php
define('IN_MYMPS', true);
define('IN_ADMIN',true);
define('CURSCRIPT','payend');

require_once dirname(__FILE__).'/../../../include/global.php';
require_once MYMPS_DATA.'/config.php';
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';

$paytype='alipay';
$payr=$db->getRow("SELECT * FROM {$db_mymps}payapi WHERE paytype='$paytype'");
$bargainor_id=$payr['payuser'];//商户号
$key=$payr['paykey'];//密钥
$seller_email=$payr['payemail'];//卖家支付宝帐户

$ddno = $_POST['out_trade_no'];//网站的订单号
$orderid = $_POST['trade_no'];//支付订单
$trade_status = $_POST['trade_status'];
$money=$_POST['total_fee'];

if($trade_status=="TRADE_FINISHED" || $trade_status== "TRADE_SUCCESS" || $trade_status == 'WAIT_BUYER_CONFIRM_GOODS'|| $trade_status == 'WAIT_SELLER_SEND_GOODS'){
	include MYMPS_INC.'/pay.fun.php';
	if($trade_status=="TRADE_FINISHED"){
		$paybz='支付完成';
	} elseif($trade_status=="TRADE_SUCCESS"){
		$paybz='支付成功';
	} elseif($trade_status=="WAIT_BUYER_CONFIRM_GOODS"){
		$paybz='充值确认中';
	}elseif($trade_status=="WAIT_SELLER_SEND_GOODS"){
		$paybz='充值成功';
	}
	UpdatePayRecord($ddno,$paybz);
	echo "success";
} else {
	echo "fail";
}

?>