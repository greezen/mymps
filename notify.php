<?php
define('IN_SMT', true);
define('IN_MYMPS', true);
define('CURSCRIPT','notify');

require_once dirname(__FILE__)."/include/global.php";
require_once MYMPS_DATA."/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
require_once MYMPS_INC.'/pay.fun.php';
$_POST = array (
    'gmt_create' => '2017-07-07 14:44:16',
    'charset' => 'UTF-8',
    'seller_email' => 'nmjgvj9956@sandbox.com',
    'subject' => '物业缴费',
    'sign' => 'K9wdak9jTgBAcydBYugBi9NK0g6/P10mrN4CxSdUWUwuc9DO6Qtq3IFqTO5x0eKWFeaQsfQTx539ILwvCS4G7ienWEY10pp17Ay9ehVBoofd/p8bpjBx/wrD8jWAQ+5oR3Xp6+TrRxvkhcjLZjB4Ga3epjnvhR/R4aKl9IFNkGNMp32AJTVnZP9nFs7EqWSVPwGDqdGftegOCgnLxeeqxnqFj0gY+7jIKeR7iPg2OIIlm6/c9b9wlmaLa/fiJfNkwhaq/LM6zJGHQkfYwMXwl+hoBbnNUgEExKUg70gIYQdP/JipZFmkihUIeh2vKah3QhVteen4wtpMZmUCXwaolQ==',
    'body' => '城盛惠民',
    'buyer_id' => '2088102172351442',
    'invoice_amount' => '0.01',
    'notify_id' => 'fdf5ad2298159a54558a002336c2f5fjea',
    'fund_bill_list' => '[{"amount":"0.01","fundChannel":"ALIPAYACCOUNT"}]',
    'notify_type' => 'trade_status_sync',
    'trade_status' => 'TRADE_SUCCESS',
    'receipt_amount' => '0.01',
    'app_id' => '2016080600184608',
    'buyer_pay_amount' => '0.01',
    'sign_type' => 'RSA2',
    'seller_id' => '2088102170281992',
    'gmt_payment' => '2017-07-07 14:44:17',
    'notify_time' => '2017-07-07 14:44:18',
    'version' => '1.0',
    'out_trade_no' => '20170707144132595f2d1c3f750',
    'total_amount' => '0.01',
    'trade_no' => '2017070721001004440200161336',
    'auth_app_id' => '2016080600184608',
    'buyer_logon_id' => 'ovp***@sandbox.com',
    'point_amount' => '0.00',
);
$xml = file_get_contents('php://input');

if (!empty($xml)) {//微信支付回调
    libxml_disable_entity_loader(true);
    $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

    require_once MYMPS_INC . '/payment/wxpay/lib/WxPay.Api.php';
    require_once MYMPS_INC . '/payment/wxpay/lib/WxPay.Notify.php';
    require_once MYMPS_INC . '/payment/wxpay/lib/PayNotifyCallBack.php';
    require_once MYMPS_INC . '/payment/wxpay/code/log.php';

    //初始化日志
    $logHandler= new CLogFileHandler(MYMPS_DATA."/logs/".date('Y-m-d').'.log');
    $log = Log::Init($logHandler, 15);
    Log::DEBUG($xml);
    if($data['return_code'] == "SUCCESS" && $data['result_code'] == 'SUCCESS'){
        $paybz='支付完成';
    } else {
        $paybz='支付失败';
    }
    updatepayrecord($data['out_trade_no'],$paybz);

    $recorde = $db->getRow("SELECT * FROM `{$db_mymps}payrecord` WHERE orderid='{$data['out_trade_no']}'");
    $property = $db->getRow("SELECT * FROM `{$db_mymps}property` WHERE id='{$recorde['relation_id']}'");
    if ($recorde['paybz'] == '支付完成' && $property['status'] == 'Y') {
        $notify = new PayNotifyCallBack();
        $notify->Handle(false);
    }

} else {
    require_once MYMPS_INC . '/payment/alipay_new/notify_url.php';
}