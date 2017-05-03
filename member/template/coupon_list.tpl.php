<?php include mymps_tpl('inc_header'); ?>
<link rel="stylesheet" type="text/css" href="template/css/new.exchange.css" />
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
    <div class="phead"><div class="phead-inner"><div class="phead-inner">
        <h3 class="ptitle"><span>我上传的优惠券</span></h3>
        <p class="pextra addwebsite"><a href="?m=coupon&ac=detail&type=corp"><span>上传优惠券</span></a></p>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">
                <li><a href="?m=coupon&status=yes&type=corp" <?php if($status == 'yes') echo 'class="current"'; ?>><span>可用</span></a></li>
                <li><a href="?m=coupon&status=no&type=corp" <?php if($status == 'no') echo 'class="current"'; ?>><span>失效</span></a></li>
            </ul>
        </div>
		<div id="msg_success"></div>
<div id="msg_error"></div>
<div id="msg_alert"></div>
        <form method="post" action="?m=<?=$m?>&ac=<?=$ac?>&page=<?=$page?>">
        <div class="datatablewrap">
            <table class="datatable">
                <thead>
                    <tr>
                        <td>
                            <input class="checkall" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/>
                        </td>
                        <td width="100">缩略图</td>
                        <td>名称</td>
                        <td>打印次数</td>
                        <td>浏览</td>
			            <td>上传时间</td>
                        <td>详情</td>
                    </tr>
                </thead>
                <tbody>
                <?php if($rows_num == 0 ){?>
                    <tr>
                        <td colspan="7">
                        <div class="nodata">您尚未上传优惠券</div>
                        </td>
                    </tr>
                <?php } else {
                $i = 1;
                foreach($coupon as $d){
                ?>
                	<tr <?php if($i%2 == 0) echo 'class="row-even"'?>>
                        <td><input class="checkbox" type='checkbox' name='selectedids[]' value='<?=$d[id]?>' id="<?=$d[id]?>'"></td>
                        <td>
                        <img src="<?php echo $d['pre_picture']; ?>" style="margin:5px 0" width="80">
                        </td>
                        <td width="200">
                        <a href="../coupon.php?id=<?=$d['id']?>" target="_blank" title="<?=$d['title']?>"><?=substring($d['title'],0,30)?></a>
                        </td>
                        <td>
                        <?=$d['prints']?>
                        </td>
                        <td>
                        <?=$d['hit']?>
                        </td>
                        <td>
                        <?=GetTime($d['dateline'])?>
                        </td>
                        <td>
                        <a href="?type=corp&m=coupon&ac=detail&id=<?=$d['id']?>">编辑</a>
                        </td>
                    </tr>
                <?php 
                	$i++;
                    }
                    unset($i);
                }
                ?>
                </tbody>
            </table>
            <div class="clearfix datacontrol">
                <div class="dataaction">
                    <span class="minbtn-wrap"><span class="btn"><input type="submit" value="删除" class="button" name="coupon_submit" onClick="if(!confirm('您确定要删除这些优惠券吗?一旦删除将不可恢复'))return false;"/></span></span> 
                </div>
                <div class="pagination"><?php echo page2(); ?></div>
            </div>
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