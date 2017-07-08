<?php include mymps_tpl('inc_header'); ?>
<link rel="stylesheet" type="text/css" href="template/css/new.exchange.css"/>
<script language="javascript" src="template/javascript.js"></script>

</head>
<body class="<?php echo $mymps_global['cfg_tpl_dir']; ?>">
<div class="container">
    <style type="text/css">
        select{
            width: auto !important;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            vertical-align: middle;
            border: 1px solid #ccc;
            background: #fff;
            padding: 3px 5px;
            margin-left: 2px;
        }
        .select-list{
            margin: 1rem auto;
        }
        #address{
            margin: 1rem;
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
                                            <?php if (empty($room_id)) :?>
                                                <div class="select-list">
                                                    <div>请选择您的地址：</div>
                                                    <div id="address">
                                                        <select name="province_id" id="province_id">
                                                            <option value="0">请选择</option>
                                                            <?php foreach ($province_list as $item) : ?>
                                                                <option value="<?=$item['provinceid']?>"><?=$item['provincename']?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                    <div class="formrow formrow-action">
                                                        <span class="minbtn-wrap"><span class="btn"><input type="button" id="set_address" value="提交" class="button" name="base_submit"></span></span>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                            <?php if (!empty($list)) :?>
                                            <div class="xinxi-guanli-box">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                       class="xinfabu prico datatable">
                                                    <thead>
                                                        <tr>
                                                            <td>期号</td>
                                                            <td>地址</td>
                                                            <td>金额(元)</td>
                                                            <?php if ($status == 'N') :?>
                                                                <td></td>
                                                            <?php else : ?>
                                                                <td>缴费时间</td>
                                                                <td>缴费方式</td>
                                                            <?php endif;?>
                                                        </tr>
                                                    </thead>
                                                    <?php  foreach ($list as $item) :
                                                        $total_fee = ($item['manage_fee'] + $item['water_fee'] + $item['electric_fee'] + $item['other_fee'])
                                                    ?>
                                                    <tr>
                                                        <td><?= $item['period'] ?></td>
                                                        <td><?= get_address($item['room_id'], 'room') ?></td>
                                                        <td><?= $total_fee ?></td>
                                                        <?php if ($status == 'N') :?>
                                                            <td><a href="#">立即缴费</a></td>
                                                        <?php else : ?>
                                                            <td><?=date('Y-m-d H:i:s',$item['pay_time'])?></td>
                                                            <td><?=Constants::map_pay_type[$item['pay_type']]?></td>
                                                        <?php endif;?>
                                                    </tr>
                                                    <?php  endforeach;?>
                                                </table>
                                            </div>
                                                <?php endif;?>
                                            <?php if ($rows_num > 0) { ?>
                                                <div class="clearfix datacontrol">
                                                    <div class="dataaction">
                                                    </div>
                                                    <div class="pagination"><?php echo page2(); ?></div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="nodata">暂无记录</div>
                                            <?php } ?>
                                            <?php endif;?>
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
    <?php //include mymps_tpl('inc_foot'); ?>

    <script type="text/javascript" src="/m/template/js/jq_min.211.js"></script>
    <script type="application/javascript">
        $(function () {
            $('#province_id').change(function () {
                var that = $(this);
                var data = {"do" : "city", "province_id" : $('#province_id').val()};
                $.post('/address.php', data, function (rsp) {
                    var str = select_tpl('city', rsp);
                    that.nextAll().remove();
                    $('#address').append(str);
                }, 'json')
            });

            $(document).on('change', '#city_id', function () {
                var that = $(this);
                var data = {"do" : "area", "city_id" : $(this).val()};
                $.post('/address.php', data, function (rsp) {
                    var str = select_tpl('area', rsp);
                    that.nextAll().remove();
                    $('#address').append(str);
                }, 'json')
            });

            $(document).on('change', '#area_id', function () {
                var that = $(this);
                var data = {"do": "building", "area_id": $(this).val()};
                $.post('/address.php', data, function (rsp) {
                    var str = select_tpl('building', rsp);
                    that.nextAll().remove();
                    $('#address').append(str);
                }, 'json')
            });

            $(document).on('change', '#building_id', function () {
                var that = $(this);
                var data = {"do": "room", "building_id": $(this).val()};
                $.post('/address.php', data, function (rsp) {
                    var str = select_tpl('room', rsp);
                    that.nextAll().remove();
                    $('#address').append(str);
                }, 'json')
            });

            $('#set_address').click(function () {
                var room_id = $('#room_id').val();
                if (room_id == undefined || room_id < 1) {
                    window.alert('您还未选择房间号哦');
                    return false;
                }
                var url = '/member/index.php?m=property&act=address';
                var data = {"room_id": room_id};
                $.post(url, data, function (rsp) {
                    if (rsp == 'ok') {
                        window.location.href = '/member/index.php?m=property&type=user';
                    } else {
                        window.alert('设置失败');
                    }
                });
            });

            function select_tpl(type, data) {
                var tpl = '<select name="'+type+'_id" id="'+type+'_id">';
                tpl += '<option value="">请选择</option>';
                $.each(data, function (i,v) {
                    tpl += '<option value="'+ v.id+'">'+ v.name+'</option>';
                });
                tpl += '</select>';
                return tpl;
            }
        })
    </script>

</div>
</body>
</html>