<?php
define('IN_SMT', true);
define('IN_MYMPS', true);
define('CURSCRIPT','notify');

require_once dirname(__FILE__)."/include/global.php";
require_once MYMPS_DATA."/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
require_once MYMPS_INC.'/pay.fun.php';

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