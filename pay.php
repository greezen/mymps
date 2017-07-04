<?php
define('IN_SMT', true);
define('IN_MYMPS', true);
define('CURSCRIPT','pay');

require_once dirname(__FILE__)."/include/global.php";
require_once MYMPS_DATA."/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";

$act = empty($act) ? 'pay' : $act;

if ($act == 'pay' && !empty($payid)) {

    $pay_config = $db->getRow("SELECT * FROM `{$db_mymps}payapi` WHERE payid={$payid} AND isclose=0");

    if (empty($pay_config)) {
        die();
    }
    if ($pay_config['paytype'] == 'wxpay') {
        $id = isset($_REQUEST['id']) ? floatval($_REQUEST['id']) : 0;
        $money = $db->getOne("SELECT SUM(manage_fee+water_fee+electric_fee+other_fee) money FROM {$db_mymps}property WHERE id={$id}");
        if (!empty($id) && !empty($money)) {
            require_once MYMPS_INC.'/payment/wxpay/lib/WxPay.Api.php';
            require_once MYMPS_INC.'/payment/wxpay/code/WxPay.NativePay.php';
            require_once MYMPS_INC.'/payment/wxpay/code/log.php';
            require_once MYMPS_INC.'/payment/wxpay/code/phpqrcode/phpqrcode.php';

            $notify = new NativePay();
            $input = new WxPayUnifiedOrder();
            $body = '物业缴费';
            $out_trade_no = date("YmdHis").uniqid();
            $input->SetBody($body);
            $input->SetAttach($body);
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($money * 100);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            //$input->SetGoods_tag($body);
            $input->SetNotify_url("http://www.cs0663.cn/pay.php?act=notify&type=wx");
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id($id);
            $result = $notify->GetPayUrl($input);
            $url = $result["code_url"];
            if (!empty($url)) {
                include_once MYMPS_INC.'/pay.fun.php';
                ToPayMoney($money,$out_trade_no,$uid,$s_uid,'wxpay');//写入等待支付记录
            }
            QRcode::png($url);
        }
    } elseif ($pay_config['paytype'] == 'alipay_new') {
        $id = isset($_REQUEST['id']) ? floatval($_REQUEST['id']) : '';

        if(!empty($id)){
            $payr = $pay_config;
            $money = $db->getOne("SELECT SUM(manage_fee+water_fee+electric_fee+other_fee) money FROM {$db_mymps}property WHERE id={$id}");
            $relation_id = $id;
            $productname = '物业缴费';
            include MYMPS_INC.'/pay.fun.php';
            msetcookie("pay_type",$pay_type,0);
            //返回地址前缀
            $PayReturnUrlQz=$mymps_global['SiteUrl'];
            if($charset=='utf-8'){
                @header('Content-Type: text/html; charset=utf-8');
            }
            include MYMPS_INC.'/payment/'.$payr['paytype'].'/to_pay.php';
        }
    }
} elseif ($act == 'notify') {

} elseif ($act == 'return') {

}





is_object($db) && $db->Close();
$cachetime && $cachepages->caching();

$city = $maincity = $advertisement =NULL;
unset($city,$maincity,$advertisement);