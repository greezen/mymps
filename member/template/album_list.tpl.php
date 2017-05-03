<?php include mymps_tpl('inc_header');?>
<link rel="stylesheet" type="text/css" href="template/css/new.exchange.css" />
<script language="javascript" src="template/javascript.js"></script>

</head>
<body class="<?php echo $mymps_global['cfg_tpl_dir']; ?>">
<div class="container">

	<?php include mymps_tpl('inc_head');?>
    <div id="main" class="main section-setting">
        <div class="clearfix main-inner">
            <div class="content">
                <div class="clearfix content-inner">
                    <div class="content-main">
                        <div class="content-main-inner">
                            
                            <div class="pwrap">
    <div class="phead"><div class="phead-inner"><div class="phead-inner">
        <h3 class="ptitle"><span>网点相册</span></h3>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">
                <li><a href="?m=album&ac=list&type=corp" class="current"><span>网点相册</span></a></li>
                <li><a href="?m=album&ac=upload&type=corp"><span>上传新相片</span></a></li>
            </ul>
        </div>
        <div id="msg_success"></div>
		<div id="msg_error"></div>
		<div id="msg_alert"></div>
        <div class="datatablewrap">
        <?php if($rows_num == 0){?>
        <div class="nodata">您还没有上传相片，<a href="?m=album&ac=upload">请点此上传 &raquo;</a><br><br><br></div>
        <?php } else {?>
        <div class="albumlist">
            <ul>
                <?php foreach($album AS $album){?>
                <li class="li">
                <a href="<?php echo $mymps_global[SiteUrl].$album['path'];?>" target="_blank" class="box" title="点击查看实际图片"><img src="<?php echo $mymps_global[SiteUrl].$album['prepath']?>" border="0"></a>
                <h4 align="center"><font title="<?=$album['title']?>"><?=substring($album['title'],0,15)?></font><br /><a href="?m=album&ac=edit&id=<?=$album['id']?>&type=corp">修改</a> <a href="?m=album&ac=delete&id=<?=$album['id']?>" onClick="if(!confirm('您确定要删除这张图片吗？一旦删除就不能恢复！'))return false;">删除</a></h4>
                </li>
                <?}?>
            </ul>
        </div>
        <div class="clearfix datacontrol">
            <div class="pagination"><?php echo page2(); ?></div>
        </div>
        <?php }?>
        </div>
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
</body>
</html>