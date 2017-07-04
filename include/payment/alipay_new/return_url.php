<?php
define('IN_MYMPS', true);
define('IN_ADMIN',true);
define('CURSCRIPT','payend');

require_once dirname(__FILE__).'/../../../include/global.php';
require_once MYMPS_DATA.'/config.php';
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';
require_once MYMPS_INC."/member.class.php";;
if(!$member_log->chk_in()) write_msg("",$mymps_global['SiteUrl']."/".$mymps_global['cfg_member_logfile']."?url=".urlencode(GetUrl()));
require_once("config.php");
require_once 'pagepay/service/AlipayTradeService.php';

if (!pcclient()) {
    define( "WAP", true );
    define( "CURSCRIPT", "wap" );
    define( "IN_MYMPS", true );
    define( "IN_SMT", true );
    require_once MYMPS_ROOT."/m/common.fun.php";
}

$arr=$_GET;
$alipaySevice = new AlipayTradeService($config); 
$result = $alipaySevice->check($arr);

/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
*/
if($result) {
	//商户订单号
	$out_trade_no = htmlspecialchars($_GET['out_trade_no']);

	//支付宝交易号
	$trade_no = htmlspecialchars($_GET['trade_no']);
    $row=$db->getRow("SELECT * FROM {$db_mymps}payrecord WHERE orderid='$out_trade_no'");
    if (!empty($row)) {
        if (pcclient()) {
            write_msg("支付成功",$mymps_global['SiteUrl']."/member/index.php?m=pay&ac=record");
        } else {
            redirectmsg('支付成功', $mymps_global['SiteUrl']."/m/index.php?mod=member");
        }
    }

}
if (pcclient()) {
    write_msg("支付失败",$mymps_global['SiteUrl']."/member/index.php?m=pay&ac=record");
} else {
    redirectmsg('支付失败', $mymps_global['SiteUrl']."/m/index.php?mod=member");
}


is_object($db) && $db->Close();
$mymps_global = NULL;
