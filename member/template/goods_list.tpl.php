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
        <h3 class="ptitle"><span>我发布的商品</span></h3>
        <p class="pextra addwebsite"><a href="?m=goods&ac=detail&type=corp"><span>发布商品</span></a></p>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">
                <li><a href="?m=goods&ac=list&type=corp" <?php if($ac == 'list') echo 'class="current"'; ?>><span>已发布商品</span></a></li>
                <li><a href="?m=goods&ac=order&type=corp" <?php if($ac == 'signin') echo 'class="current"'; ?>><span>订单管理</span></a></li>
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
                        <td width="100">商品编号</td>
                        <td>商品名称</td>
						<td>原价</td>
						<td>现价</td>
                        <td>发布时间</td>
			            <td>状态</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
					<?php if($rows_num == 0 ){?>
                    <tr>
                        <td colspan="8">
                        <div class="nodata">您尚未发布任何商品</div>
                        </td>
                    </tr>
					<?php } else {
					$i = 1;
					foreach($goods as $d){
					?>
                	<tr >
                        <td><input class="checkbox" type='checkbox' name='selectedids[]' value='<?=$d[goodsid]?>' id="<?=$d[goodsid]?>"></td>
                        <td>
                        <?=$d[goodsbh]?>
                        </td>
                        <td width="240">
                       <a href="../goods.php?id=<?=$d[goodsid]?>" target="_blank"><?=$d[goodsname]?></a>
                        </td>
                        <td style="text-decoration:line-through">
                       <?=$d[oldprice]?> <?php echo $moneytype; ?>
                        </td>
						<td style="color:red">
                       <?=$d[nowprice]?> <?php echo $moneytype; ?>
                        </td>
						<td>
                       <?=GetTime($d[dateline])?>
                        </td>
                        <td>
                        <?php echo $d[onsale] == 1 ? '<font color=green>已上架</font>':'<font color=green>已下架</font>'?>
                        </td>
                        <td>
                        <a href="?type=corp&m=goods&ac=detail&id=<?=$d[goodsid]?>">编辑</a>
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
                    <span class="minbtn-wrap"><span class="btn"><input type="submit" value="删除" class="button" name="goods_submit" onClick="if(!confirm('您确定要删除这些商品活动吗?一旦删除将不可恢复'))return false;"/></span></span> 
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