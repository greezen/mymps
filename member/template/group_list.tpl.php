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
        <h3 class="ptitle"><span>我发起的团购活动</span></h3>
        <p class="pextra addwebsite"><a href="?m=group&ac=detail&type=corp"><span>发起团购</span></a></p>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">
                <li><a href="?m=group&ac=list&type=corp" <?php if($ac == 'list') echo 'class="current"'; ?>><span>已发起团购</span></a></li>
                <li><a href="?m=group&ac=signin&type=corp" <?php if($ac == 'signin') echo 'class="current"'; ?>><span>报名管理</span></a></li>
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
                        <td>活动名称</td>
                        <td>活动分类</td>
                        <td>发布时间</td>
			            <td>状态</td>
                        <td>报名</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                <?php if($rows_num == 0 ){?>
                    <tr>
                        <td colspan="8">
                        <div class="nodata">您尚未发起任何团购活动</div>
                        </td>
                    </tr>
                <?php } else {
                $i = 1;
                foreach($group as $d){
                ?>
                	<tr <?php if($i%2 == 0) echo 'class="row-even"'?>>
                        <td><input class="checkbox" type='checkbox' name='selectedids[]' value='<?=$d[groupid]?>' id="<?=$d[groupid]?>'"></td>
                        <td>
                        <img src="<?php echo $mymps_global['SiteUrl'].($d['pre_picture'] ? $d['pre_picture'] : '/images/nophoto.gif'); ?>" style="margin:5px 0" width="80">
                        </td>
                        <td width="200">
                        <a href="../group.php?id=<?=$d[groupid]?>" target="_blank"><?=$d['gname']?></a>
                        </td>
                        <td>
                        <?=$d['cate_name']?>
                        </td>
                        <td>
                        <?=GetTime($d['dateline'])?>
                        </td>
                        <td>
                        <?=$glevel[$d['glevel']]?>
                        </td>
                        <td>
                        <?=$d['signintotal']?>
                        </td>
                        <td>
                        <a href="?type=corp&m=group&ac=detail&id=<?=$d['groupid']?>">编辑</a>
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
                    <span class="minbtn-wrap"><span class="btn"><input type="submit" value="删除" class="button" name="group_submit" onClick="if(!confirm('您确定要删除这些团购活动吗?一旦删除将不可恢复'))return false;"/></span></span> 
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