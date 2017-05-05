<?php include mymps_tpl('inc_header'); ?>
<link rel="stylesheet" type="text/css" href="template/css/new.exchange.css"/>
<script language="javascript" src="template/javascript.js"></script>

</head>
<body class="<?php echo $mymps_global['cfg_tpl_dir']; ?>">
<div class="container">

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
                                            <h3 class="ptitle"><span>物业缴费</span></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="pbody">

                                    <div class="cleafix pagetab-wrap">
                                        <ul class="pagetab">
                                            <li><a href="?m=property&status=N"
                                                   <?php if ($status == 'N'){ ?>class="current"<?php } ?>><span>待缴费用</span></a>
                                            </li>
                                            <li><a href="?m=property&status=Y"
                                                   <?php if ($status == 'Y'){ ?>class="current"<?php } ?>><span>缴费明细</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="msg_success"></div>
                                    <div id="msg_error"></div>
                                    <div id="msg_alert"></div>
                                    <form method="post" action="?m=<?= $m ?>&l=<?= $l ?>&page=<?= $page ?>"
                                          name="form1">
                                        <div class="datatablewrap">
                                            <div class="xinxi-guanli-box">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                       class="xinfabu prico">
                                                    <tr>
                                                        <td>期号</td>
                                                        <td>地址</td>
                                                        <td>金额</td>
                                                        <td>缴费时间</td>
                                                        <td>支付方式</td>
                                                    </tr>
                                                    <?php  foreach ($list as $item) :
                                                        $total_fee = ($item['manager_fee'] + $item['water_fee'] + $item['electric_fee'] + $item['other_fee'])
                                                    ?>
                                                    <tr>
                                                        <td><?= $item['period'] ?></td>
                                                        <td><?= get_address($item['room_id'], 'room') ?></td>
                                                        <td><?= $total_fee ?></td>
                                                        <td><?= date('Y-m-d H:i:s', $item['pay_time']) ?></td>
                                                        <td><?= Constants::map_pay_type[$item['pay_type']] ?></td>
                                                    </tr>
                                                    <?php  endforeach;?>
                                                </table>
                                            </div>
                                            <?php if ($rows_num > 0) { ?>
                                                <div class="clearfix datacontrol">
                                                    <div class="dataaction">
                                                    </div>
                                                    <div class="pagination"><?php echo page2(); ?></div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="nodata">暂无记录</div>
                                            <?php } ?>
                                        </div>
                                    </form>

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
    <?php include mymps_tpl('inc_foot'); ?>

</div>
</body>
</html>