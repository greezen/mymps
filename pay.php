<?php
define('IN_SMT', true);
define('IN_MYMPS', true);
define('CURSCRIPT','pay');

require_once dirname(__FILE__)."/include/global.php";
require_once MYMPS_DATA."/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";

if (empty($payid)) {
    die();
}

$pay_config = $db->getRow("SELECT * FROM `{$db_mymps}payapi` WHERE payid={$payid}");

if (empty($pay_config)) {
    die();
}

if ($pay_config['paytype'] == 'wxpay') {
    require_once MYMPS_INC.'/payment/wxpay/lib/WxPay.Api.php';
    require_once MYMPS_INC.'/payment/wxpay/example/WxPay.NativePay.php';
    require_once MYMPS_INC.'/payment/wxpay/example/log.php';
    require_once MYMPS_INC.'/payment/wxpay/example/phpqrcode/phpqrcode.php';

    $notify = new NativePay();
    $input = new WxPayUnifiedOrder();
    $input->SetBody("test");
    $input->SetAttach("test");
    $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
    $input->SetTotal_fee("1");
    $input->SetTime_start(date("YmdHis"));
    $input->SetTime_expire(date("YmdHis", time() + 600));
    $input->SetGoods_tag("test");
    $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
    $input->SetTrade_type("NATIVE");
    $input->SetProduct_id("123456789");
    $result = $notify->GetPayUrl($input);
    $url = $result["code_url"];
    QRcode::png($url);

}

is_object($db) && $db->Close();
$cachetime && $cachepages->caching();

$city = $maincity = $advertisement =NULL;
unset($city,$maincity,$advertisement);