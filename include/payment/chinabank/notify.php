<?php
define('IN_MYMPS', true);
define('IN_ADMIN',true);
define('CURSCRIPT','payend');

require_once dirname(__FILE__).'/../../../include/global.php';
require_once MYMPS_DATA.'/config.php';
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';

$paytype='chinabank';
$payr=$db->getRow("SELECT * FROM {$db_mymps}payapi WHERE paytype='$paytype'");
$v_mid=$payr['payuser'];//商户号
$key=$payr['paykey'];//密钥
$v_oid     =trim($_POST['v_oid']);      
$v_pmode   =trim($_POST['v_pmode']);      
$v_pstatus =trim($_POST['v_pstatus']);      
$v_pstring =trim($_POST['v_pstring']);      
$v_amount  =trim($_POST['v_amount']);     
$v_moneytype  =trim($_POST['v_moneytype']);     
$remark1   =trim($_POST['remark1']);     
$remark2   =trim($_POST['remark2']);     
$v_md5str  =trim($_POST['v_md5str']);
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));
if ($v_md5str==$md5string){
	include MYMPS_INC.'/pay.fun.php';
	if($v_pstatus=="20"){
		$paybz='支付成功';
	}elseif($v_pstatus == "30"){
		$paybz='支付失败';
	}else{
		$paybz='支付完成';
	}
	UpdatePayRecord($remark1,$paybz);
  	echo "ok";
}else{
	echo "error";
}
?>