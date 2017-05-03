<?php include mymps_tpl('inc_header');?>
<link rel="Stylesheet" type="text/css" href="template/css/new.dialog.css" />
<link rel="stylesheet" type="text/css" href="template/css/new.my.css" />
<script language="javascript" src="template/javascript.js"></script>
</head>
<body class="<?php echo $mymps_global['cfg_tpl_dir']; ?>" <?php if($box == 1){?>style="background:none"<?}?>>
<div class="container">
    
    <?php include mymps_tpl('inc_head');?>
    
    <div id="main" class="main section-setting">
            <div class="clearfix main-inner" >
                <div class="content">
                    <div class="clearfix content-inner" <?php if($box == 1) echo 'style="margin:13px!important;"';?>>
                        <div class="content-main">
                            <div class="content-main-inner">
                                
                                <div class="pwrap">
                                    <div class="phead"><div class="phead-inner"><div class="phead-inner">
                                        <h3 class="ptitle"><span>金币充值</span></h3>
                                    </div></div></div>
                                    <div class="pbody">
    
                                        <div class="clearfix pagetab-wrap">
                                            <ul class="pagetab">
                                                <li><a href="?m=pay&ac=pay" <?php if($ac == 'pay') echo 'class="current"'; ?>><span>金币充值</span></a></li>
												<?php if($box != 1){?>
                                                <li><a href="?m=pay&ac=record" <?php if($ac == 'record') echo 'class="current"'; ?>><span>充值明细</span></a></li>
                                                <li><a href="?m=pay&ac=use" <?php if($ac == 'user') echo 'class="current"'; ?>><span>消费记录</span></a></li>
												<?php }?>
                                            </ul>
                                        </div>
										<div id="msg_success"></div>
										<div id="msg_error"></div>
										<div id="msg_alert"></div>
                                        <form action="?m=pay&ac=pay" target="_blank" method="post">
                                        <div class="formgroup topupform">
                                            
                                            <div class="errormsg" id="error" style="display:none"></div>
                                          
                                            <div class="formrow">
                                                <h3 class="label"><label for="value">请输入要充值的<span id="pointname">金币</span>数 <span class="note">(一次最少需要充值<span id="minvalue" style="color:red">0</span>个金币)</span></label></h3>
                                                <div class="formrow-enter">
                                                    <input type="hidden" name="currentPointType" id="currentPointType" value="Point8" />
                                                    <input type="text" class="text number" name="money" id="payvalue" value="" onKeyUp="value=value.replace(/[^\d]/g,'');if(value>2147483647)value=2147483647;setMustPay()" />
                                                    <span id="pointunit"></span>
                                                    <span class="surplus">(当前金币为: <img src="template/images/coins.gif" align="absmiddle"><?=$money_own?>)</span>
                                                </div>
                                            </div>
                                            <div class="formrow">
                                                <h3 class="label">实际应付</h3>
                                                <div class="formrow-enter">
                                                    <span class="pay" id="mustpay">0</span> <?php echo $moneytype; ?>
                                                    <span class="note" id="paytype"></span>
                                                </div>
                                            </div>
                                            <div class="formrow">
                                                <h3 class="label">请选择付款方式</h3>
                                                <div class="formrow-enter">
                                                    <ul class="clearfix paymentlist">
                                                     <?php 
                                                     if(is_array($opened_pay_api)){
                                                     foreach($opened_pay_api as $k => $v){?>
                                                        <li id="li<?=$v['paytype']?>" <?php if($v['payid'] == 1){?>class="selected"<?php }?>>
                                                            <label for="payment_<?=$v['paytype']?>" class="image">
                                                                <img src="template/images/<?=$v['paytype']?>.png" alt="<?=$v['payname']?>" width="160" height="40" onClick="$obj('payment_<?=$v['paytype']?>').checked = true;selPayment();" />
                                                            </label>
                                                            <input id="payment_<?=$v['paytype']?>" class="radio" type="radio" name="payid" onClick="selPayment()" value="<?=$v['payid']?>"  <?php if($v['payid'] == 1) echo 'checked="checked"'; ?> />
                                                            <label for="payment_<?=$v['paytype']?>" class="title"><?=$v['payname']?></label>
                                                        </li>
                                                     <?php
                                                     	}}else{
                                                        ?>
                                                        <font color="red">请联系网站客服为您充值</font>
                                                     <?
                                                     }
                                                     ?>
                                                     
                                                    </ul>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                function selPayment() {
                                                    var varPayment = document.getElementsByName("payid");
                                                    for (i = 0; i < varPayment.length; i++) {
                                                        if (varPayment[i].checked) {
                                                            switch (varPayment[i].value) {
                                                                case "3":
                                                                    setCssClass("lialipay", "selected");
                                                                    setCssClass("litenpay", "");
                                                                    setCssClass("lichinabank", "");
                                                                    $obj('paytype').innerHTML = '(你选择了支付宝支付)';
                                                                    break;
                                                                case "1":
                                                                    setCssClass("lialipay", "");
                                                                    setCssClass("litenpay", "selected");
                                                                    setCssClass("lichinabank", "");
                                                                    $obj('paytype').innerHTML = '(你选择了财付通支付)';
                                                                    break;
                                                                case "2":
                                                                    setCssClass("lialipay", "");
                                                                    setCssClass("litenpay", "");
                                                                    setCssClass("lichinabank", "selected");
                                                                    $obj('paytype').innerHTML = '(你选择了网银在线支付)';
                                                                    break;
                                                                default:
                                                                    break;
                                                            }
                                                        }
                                                    }
                                                }
    
                                                function setCssClass(id, className) {
                                                    var element = document.getElementById(id);
                                                    if (element != null)
                                                        element.className = className;
                                                }
                                             
                                            </script>
                                            <div class="formrow formrow-action"> 
                                                <span class="minbtn-wrap"><span class="btn">
                                                <input class="button" type="submit" name="pay_submit" id="confirmResult" onClick="return checkInput();" value="确认充值" <?php if(!is_array($opened_pay_api)){?>disabled<?}?>/>
                                                </span>
                                                </span>
                                            </div>
                                        </div>
                                        </form>
                                		<?php if($box != 1){?>
                                        <div class="topup-note">
                                            <p>1、充值费用与金币比例为1:<?php echo $mymps_global['cfg_coin_fee']; ?>，即充值1<?php echo $moneytype; ?>可购买<?php echo $mymps_global['cfg_coin_fee']; ?>个金币</p>
											<p>2、若出现已成功充值的提示，但金额未到帐，可能是网络或系统繁忙导致，我们会在2个工作日内核对后为您充值。 </p>
                                            <p> 3、在充值时请仔细确认充值的金额和账户，以免为充值错误；</p>
                                            <p>4、在充值过程中如出现网页错误或打开缓慢时，请先查询银行或者相关支付方式的交易记录，检查扣款是否成功；然后查看帐户是否已成功充值。若没有确认，请不要反复刷新页面，以防止重复购买； </p>
                                            <p>5、如有任何疑问也可直接联系客服：<strong><?=$mymps_global['SiteTel']?></strong></p>
                                        </div>
										<?php }?>
                                    
                                    </div>
                                    <div class="pfoot"><p><b>-</b></p></div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
                <?php include mymps_tpl('inc_sidebar');?>
            </div>
        </div>
        
    <?php include mymps_tpl('inc_foot');?>
    
</div>
<script type="text/javascript">
    function checkInput() {
        var messages = {
            //
            'Point1': ['一次最少需要充值0经验'],
            //
            'Point2': ['一次最少需要充值0魅力'],
            //
            'Point4': ['一次最少需要充值0金币'],
            //
            'Point8': ['一次最少需要充值<?=$mymps_global['cfg_pay_min']?>金币'],
            //
            '-1': ['', '']
        };
        var pointType = $obj('currentPointType').value;
        var pavValue = $obj('payvalue').value;
        if (pavValue == '' || minvalues[pointType] > pavValue) {
            $obj('error').style.display = '';
            $obj('error').innerHTML = messages[pointType][0];
            location.href = '#error';
            setButtonDisable('confirmResult', false);
            return false;
        }
        else {
            $obj('error').style.display = 'none';
            return true;
        }
    }

    var moneys = {};
    var points = {};
    var minvalues = {};
    //
    moneys['Point8'] = 1;
    points['Point8'] = 10;
    minvalues['Point8'] = <?php echo $mymps_global['cfg_pay_min'] ? $mymps_global['cfg_pay_min'] : 1 ;?>;
    //
    //
    function setMustPay() {
        var type = $obj('currentPointType').value;
        var payvalue = $obj('payvalue').value;
        $obj('minvalue').innerHTML = minvalues[type];
        if (payvalue == '') {
            $obj('mustpay').value = '0';
            return;
        }
        var pay = moneys[type] * payvalue;
        var payStr = pay + '';
        var dotIndex = payStr.indexOf('.');
        if (dotIndex > 0) {
            var temp = payStr.substring(dotIndex + 1);
            if (temp.length > 2) {
                var t = parseInt(temp.substring(0, 2)) + 1;
                pay = parseInt(payStr.substring(0, dotIndex)) + t / 100;
            }
        }
        $obj('mustpay').innerHTML = Math.ceil(pay/<?php echo $mymps_global["cfg_coin_fee"];?>);
    }
    setMustPay();
    //
</script>
</body>
</html>