<?php
define('IN_SMT', true);
define('IN_MYMPS', true);
define('CURSCRIPT','pay');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/include/global.php";
require_once MYMPS_DATA."/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";

$act = empty($act) ? 'pay' : $act;

if ($act == 'pay' && !empty($payid)) {
    //TODO:检测用户登录状态

    $pay_config = $db->getRow("SELECT * FROM `{$db_mymps}payapi` WHERE payid={$payid} AND isclose=0");

    if (empty($pay_config)) {
        die();
    }
    if ($pay_config['paytype'] == 'wxpay') {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $row = $db->getRow("SELECT * FROM `{$db_mymps}property` WHERE id={$id}");
        //TODO : 订单状态判断，防止重复支付
        if ($row['status'] == 'Y') {

        }
        $money = floatval($row['manage_fee']+$row['water_fee']+$row['electric_fee']+$row['other_fee']);
        if (!empty($id) && !empty($money)) {
            require_once MYMPS_INC.'/payment/wxpay/lib/WxPay.Api.php';
            require_once MYMPS_INC.'/payment/wxpay/code/WxPay.NativePay.php';
            require_once MYMPS_INC.'/payment/wxpay/code/log.php';


            $notify = new NativePay();
            $input = new WxPayUnifiedOrder();
            $body = iconv('gbk', 'utf-8', '物业缴费');
            $out_trade_no = date("YmdHis").uniqid();
            $input->SetBody($body);
            $input->SetAttach($body);
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($money * 100);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            //$input->SetGoods_tag($body);
            $input->SetNotify_url("http://www.cs0663.cn/notify.php");
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id($id);
            $result = $notify->GetPayUrl($input);
            $url = $result["code_url"];
            if (!empty($url)) {
                include_once MYMPS_INC.'/pay.fun.php';
                topaymoney($money,$out_trade_no,$uid,$s_uid,'wxpay', $id);//写入等待支付记录
            }
            $data = array(
                'no' => $out_trade_no,
                'url' => 'http://'.$_SERVER['HTTP_HOST'].'/pay.php?act=qr&url='.$url,
            );
            echo json_encode($data);
        }
    } elseif ($pay_config['paytype'] == 'alipay_new') {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';

        if(!empty($id)){
            $payr = $pay_config;
            $row = $db->getRow("SELECT * FROM {$db_mymps}property WHERE id={$id}");
            //TODO : 订单状态判断，防止重复支付
            if ($row['status'] == 'Y') {

            }
            $money = floatval($row['manage_fee']+$row['water_fee']+$row['electric_fee']+$row['other_fee']);
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
} elseif ($act == 'return') {
    $type = isset($_GET['type'])?trim($_GET['type']):null;
    if ($type == 'ant') {
        require_once MYMPS_INC . '/payment/alipay_new/return_url.php';
    } elseif($type == 'wx') {
        require_once MYMPS_ROOT."/m/common.fun.php";
        redirectmsg('支付成功', $mymps_global['SiteUrl']."/m/index.php?mod=member");
    }
} elseif ($act == 'qr') {
    $url = isset($_GET['url'])?urldecode(trim($_GET['url'])):null;
    if (!empty($url)) {
        require_once MYMPS_INC.'/payment/wxpay/code/phpqrcode/phpqrcode.php';
        QRcode::png($url);
        exit();
    }
}

is_object($db) && $db->Close();
$cachetime && $cachepages->caching();

$city = $maincity = $advertisement =NULL;
unset($city,$maincity,$advertisement);