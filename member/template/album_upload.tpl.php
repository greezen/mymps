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
        <h3 class="ptitle"><span>网点相册</span></h3>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">
                <li><a href="?m=album&ac=list&type=corp"><span>网点相册</span></a></li>
                <li><a href="?m=album&ac=upload&type=corp" <?php if($ac == 'upload') echo 'class="current"'; ?>><span>上传新相片</span></a></li>
                <?php if($ac == 'edit'){?>
                <li><a href="?m=album&ac=edit&id=<?=$id?>&type=corp" class="current"><span>编辑相片</span></a></li>
                <? }?>
            </ul>
        </div>
		<div id="msg_success"></div>
		<div id="msg_error"></div>
		<div id="msg_alert"></div>        
        <form method="post" name="form1" action="?m=album&ac=<?=$ac?>&type=corp" enctype="multipart/form-data" <?php if($ac == 'upload'){?>onSubmit="return AlbumSubmit();"<?php }?>>
        <?php if($ac == 'edit'){?>
        <input name="id" value="<?=$edit['id']?>" type="hidden">
        <input name="path" value="<?=$edit['path']?>" type="hidden">
        <input name="prepath" value="<?=$edit['prepath']?>" type="hidden">
        <?php }?>
        <div class="formgroup section-setting">
            <div class="formrow">
                <h3 class="label">相片标题：</h3>
                <div class="form-enter">
                      <input name="title" type="text" class="text" value="<?=$edit['title']?>"/>
                </div>
            </div>
            <?php if($ac == 'edit' && $edit['prepath'] != ''){?>
            <div class="formrow">
                <h3 class="label">原来相片：</h3>
                <div class="form-enter">
                      <img src="<?=$edit['prepath']?>"/>
                </div>
            </div>
            <?php }?>
            <div class="formrow">
                <h3 class="label">上传新图片：</h3>
                <div class="form-enter">
                     <input name="album_up" type="file" id="litpic"/> <?php echo $ac == 'edit' ? '若不上传新相片请勿选择' : ''; ?><br />
        支持上传的类型：<?=$mymps_global[cfg_upimg_type]?>
                </div>
            </div>
            
            <div class="formrow">
                <h3 class="label">注意事项：</h3>
                <div class="form-enter">
                 请确保图片清晰。图片格式为 <?=$mymps_global['cfg_upimg_type']?> ，不超过 <?=$mymps_global[cfg_upimg_size]?>KB 。<br />
在上传过程中，如果长时间停止，请取消重传；或将图片缩小后重传。
                </div>
            </div>
        
            <div class="formrow formrow-action"><span class="minbtn-wrap"><span class="btn">
              <input type="submit" value="<?php echo $ac == 'edit' ? '提交修改' : '上 传'; ?>" class="button" name="album_submit" />
            </span></span></div>
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