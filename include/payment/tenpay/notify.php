<?php
define('IN_MYMPS', true);
define('IN_ADMIN',true);
define('CURSCRIPT','payend');

require_once dirname(__FILE__).'/../../../include/global.php';
require_once MYMPS_DATA.'/config.php';
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';

$paytype='tenpay';
$payr=$db->getRow("SELECT * FROM {$db_mymps}payapi WHERE paytype='$paytype'");
$bargainor_id=$payr['payuser'];
$key=$payr['paykey'];
import_request_variables("gpc", "frm_");
$strCmdno			= $frm_cmdno;
$strPayResult		= $frm_pay_result;
$strPayInfo			= $frm_pay_info;
$strBillDate		= $frm_date;
$strBargainorId		= $frm_bargainor_id;
$strTransactionId	= $frm_transaction_id;
$strSpBillno		= $frm_sp_billno;
$strTotalFee		= $frm_total_fee;
$strFeeType			= $frm_fee_type;
$strAttach			= $frm_attach;
$strMd5Sign			= $frm_sign;
$strCreateIp		= $frm_spbill_create_ip;

if($bargainor_id!=$strBargainorId){
	echo "fail";
}elseif($strPayResult=="0"){
	include MYMPS_INC.'/pay.fun.php';
	$paybz='Ö§¸¶³É¹¦';
	UpdatePayRecord($strAttach,$paybz);
	echo "success";
} else {
	echo "fail";
}

?>