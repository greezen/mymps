<?php
define('IN_MYMPS', true);
define('IN_ADMIN',true);
define('CURSCRIPT','payend');

require_once dirname(__FILE__).'/../../../include/global.php';
require_once MYMPS_DATA.'/config.php';
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';

require_once 'config.php';
$pay_type = substr($_POST['out_trade_no'], 0, 3);
if ($pay_type == 'web') {
    require_once 'web/pagepay/service/AlipayTradeService.php';
} else {
    require_once 'wap/pagepay/service/AlipayTradeService.php';
}

$arr=$_POST;
$alipaySevice = new AlipayTradeService($config);
$alipaySevice->writeLog(var_export($_POST,true));
$result = $alipaySevice->check($arr);

if($result) {
	//商户订单号
	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号
	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];


    if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
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
        updatepayrecord($out_trade_no,$paybz);
    }

	echo "success";	//请不要修改或删除
}else {
    //验证失败
    echo "fail";

}

is_object($db) && $db->Close();
$mymps_global = NULL;