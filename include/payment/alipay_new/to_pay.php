<?php
require_once dirname(__FILE__).'/config.php';
    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = date('YmdHis').uniqid();

    //订单名称，必填
    $subject = iconv('GBK','UTF-8',$productname);

    //付款金额，必填
    $total_amount = $money;

    //商品描述，可空
    $body = '城盛惠民';

	//构造参数

	if (pcclient()) {
        $out_trade_no = 'web_' . $out_trade_no;
        require_once dirname(__FILE__).'/web/pagepay/service/AlipayTradeService.php';
        require_once dirname(__FILE__).'/web/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
    } else {
        $out_trade_no = 'wap_' . $out_trade_no;
        require_once dirname(__FILE__).'/wap/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
        require_once dirname(__FILE__).'/wap/wappay/service/AlipayTradeService.php';
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
    }
	$payRequestBuilder->setBody($body);
	$payRequestBuilder->setSubject($subject);
	$payRequestBuilder->setTotalAmount($total_amount);
	$payRequestBuilder->setOutTradeNo($out_trade_no);

	$aop = new AlipayTradeService($config);

	/**
	 * pagePay 电脑网站支付请求
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @param $return_url 同步跳转地址，公网可以访问
	 * @param $notify_url 异步通知地址，公网可以访问
	 * @return $response 支付宝返回的信息
 	*/
	if (pcclient()) {
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
        //输出表单
        var_dump($response);
    } else {
        $response = $aop->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
    }
	topaymoney($total_amount,$out_trade_no,$uid,$s_uid,'alipay_new', $relation_id);//写入等待支付记录

