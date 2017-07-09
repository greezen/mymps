<?php include mymps_tpl('inc_header'); ?>
<link rel="stylesheet" type="text/css" href="template/css/new.exchange.css"/>
<script language="javascript" src="template/javascript.js"></script>

</head>
<body class="<?php echo $mymps_global['cfg_tpl_dir']; ?>">
<div class="container">
    <style type="text/css">
        .pay-type-list{
           padding: 1rem;
        }
        .pay-type-list span{
            display: inline-block;
            margin-right: 1rem;
        }
        .pay-type-list span img{
            vertical-align: middle;
        }
    </style>
    <?php include mymps_tpl('inc_head'); ?>
    <div id="main" class="main section-setting">
        <div class="clearfix main-inner">
            <div class="content">
                <div class="clearfix content-inner">
                    <div class="content-main">
                        <div class="content-main-inner">

                            <div class="pwrap">
                                <div class="phead">
                                    <div class="phead-inner">
                                        <div class="phead-inner">
                                            <h3 class="ptitle"><span>请选择支付方式</span></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pbody">
                                    <div class="pay-type-list">
                                        <span>
                                            <label>
                                                <input type="radio" name="pay_type" value="4">
                                                <img src="/m/template/images/alipay.jpg" alt="支付宝" width="20rem">
                                                支付宝
                                            </label>
                                        </span>
                                        <span>
                                            <label>
                                                <input type="radio" name="pay_type" value="5">
                                                <img src="/m/template/images/wxpay.jpg" alt="微信支付" width="20rem">
                                                微信支付
                                            </label>
                                        </span>
                                    </div>

                                    <div class="formrow formrow-action" style="padding: 1rem">
                                        <span class="minbtn-wrap"><span class="btn"><input type="button" id="pay" value="支付" class="button" name="base_submit"></span></span>
                                    </div>
                                </div>
                                <div class="pfoot"><p><b>-</b></p></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php include mymps_tpl('inc_sidebar'); ?>
        </div>
    </div>

    <script type="text/javascript" src="/m/template/js/jq_min.211.js"></script>
    <script type="text/javascript" src="/template/default/js/layer/layer.js"></script>
    <script type="application/javascript">
        $(function () {
            $('#pay').click(function () {
                var pay_type = $('input[name=pay_type]').filter(':checked').val();
                if (pay_type == 4) {
                    window.location.href = '/pay.php?payid=4&id=<?=$id?>';
                } else if (pay_type == 5) {
                    $.get('/pay.php?payid=5&id=<?=$id?>',function (rsp) {
                        var content = '<img src="'+rsp.url+'" style="margin: auto;width: 100%">'
                        layer.confirm(content, {
                            title : '微信支付-扫码支付',
                            btn: ['支付完成','支付不成功'] //按钮
                        }, function(){
                            window.location.href = '/member/index.php?m=property&status=Y';
                        }, function(){
                            window.location.href = '/member/index.php?m=property&status=N';
                        });
                    }, 'json');
                }
            });
        })
    </script>

</div>
</body>
</html>