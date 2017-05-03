<?php
if(!defined('IN_MYMPS')){
	exit;
}

//------------------ 参数开始 ------------------

$agent="";

$service= $payr['buytype'] == 2 ? "trade_create_by_buyer" : "create_direct_pay_by_user";

//商户号
$partner=$payr['payuser'];

//密钥
$paykey=$payr['paykey'];

//卖家支付宝帐户
$seller_email=$payr['payemail'];

//字符编码格式
$_input_charset = $charset == 'utf-8' ? "UTF-8" : "GBK";

//加密方式
$sign_type="MD5";

//返回地址
$return_url=$PayReturnUrlQz."/include/payment/alipay/payend.php";
$notify_url=$PayReturnUrlQz."/include/payment/alipay/notify.php";

//支付方式
$payment_type=1;

//默认支付方式
$paymethod="";

//银行类型
$defaultbank="";

//------------------ 参数结束 ------------------

//支付金额
$price=$money;
$quantity=1;

$out_trade_no=$ddno?$ddno:$timestamp;	//订单号
msetcookie("checkpaysession",$out_trade_no,0);	//设置定单号

//产品信息
$subject=$productname;	//商品名称
$body=$out_trade_no;	//商品描述

//md5
if($payr['buytype'] == 2){
	$parameter=array(
	'service'           => $service,
	'partner'           => $partner,
	'seller_email'      => $seller_email,
	'_input_charset'    => $_input_charset,
	'return_url'        => $return_url,
	'notify_url'        => $notify_url,
	'subject'           => $subject,
	'body'				=> $body,
	'out_trade_no'      => $out_trade_no,
	'price'             => $price,
	'quantity'          => $quantity,
	'payment_type'      => $payment_type,
	'paymethod'			=> $paymethod,
	'defaultbank'		=> $defaultbank,
	'logistics_fee'		=> '0.00',
	'logistics_payment' => 'SELLER_PAY',
	'logistics_type'	=> 'EXPRESS'
	);
 }else{
	$parameter=array(
	'service'           => $service,
	'partner'           => $partner,
	'seller_email'      => $seller_email,
	'_input_charset'    => $_input_charset,
	'return_url'        => $return_url,
	'notify_url'        => $notify_url,
	'subject'           => $subject,
	'body'				=> $body,
	'out_trade_no'      => $out_trade_no,
	'price'             => $price,
	'quantity'          => $quantity,
	'payment_type'      => $payment_type,
	'paymethod'			=> $paymethod,
	'defaultbank'		=> $defaultbank
	);
}
ksort($parameter);
reset($parameter);

$param='';
$sign='';

foreach($parameter AS $key => $val){
	if(strlen($val)==0){
		continue;
	}
	$param.="$key=".urlencode($val)."&";
	$sign.="$key=$val&";
}

$param=substr($param,0,-1);
$sign=md5(substr($sign,0,-1).$paykey);
$gotopayurl='https://www.alipay.com/cooperate/gateway.do?'.$param.'&sign='.$sign.'&sign_type='.$sign_type;
ToPayMoney($money,$out_trade_no,$uid,$s_uid,'alipay');//写入等待支付记录
?>
<html>
<title>支付宝支付</title>
<meta http-equiv="Cache-Control" content="no-cache"/>
<body>
<script>
self.location.href='<?=$gotopayurl?>';
</script>
<input type="button" style="font-size: 9pt" value="支付宝支付" name="v_action" onClick="self.location.href='<?=$gotopayurl?>';">
</body>
</html>