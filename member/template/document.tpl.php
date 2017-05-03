<?php include mymps_tpl('inc_header'); ?>
<link rel="Stylesheet" type="text/css" href="template/css/new.dialog.css" />
<link rel="stylesheet" type="text/css" href="template/css/new.my.css" />
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
                            <div class="pwrap setting-userinfo">
                                <div class="phead"><div class="phead-inner"><div class="phead-inner">
                                    <h3 class="ptitle"><span><?php echo ($ac == 'edit' ? '修改' : '发布').$documenttype[$tid]['typename']; ?></span></h3>
                                    <p class="pextra"><a href="?m=document&tid=<?=$tid?>&type=corp"><span>&laquo; 返回<?=$documenttype[$tid]['typename']?></span></a></p>
                                </div></div></div>
                                <div class="pbody">
                                    
                                    <div id="msg_success"></div>
<div id="msg_error"></div>
<div id="msg_alert"></div>
                                    
                                    <form action="?m=document&ac=<?=$ac?>" enctype="multipart/form-data" method="post" name="form1">
                                    <?php if($ac == 'edit'){?>
                                    	<input name="id" value="<?=$id?>" type="hidden">
                                    <?php }?>
                                    <input name="tid" value="<?=$tid?>" type="hidden">
                                    <div class="formgroup">
                                        <div class="formrow">
                                            <h3 class="label"><label>标题</label></h3>
                                            <div class="form-enter">
                                                <input name="title" type="text" class="text" value="<?=$edit['title']?>" style="width:300px">
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">作者</h3>
                                            <div class="form-enter">
                                                <input name="author" type="text" class="text" value="<?=$edit['author']?$edit['author']:$s_uid?>" style="width:300px">
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">来源</h3>
                                            <div class="form-enter">
                                                <input name="source" type="text" class="text" value="<?=$edit['source']?$edit['source']:$s_uid?>" style="width:300px">
                                            </div>
                                        </div>
                                        
                                        <?php if($documenttype[$tid]['arrid'] == '2'){?>
                                        <div class="formrow">
                                            <h3 class="label">相关图片</h3>
                                            <div class="form-enter">
                                                <input type="file" name="docu_image" size="30" id="litpic" onChange="SeePic(document.picview,document.form1.litpic);">
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">预览区</h3>
                                            <div class="form-enter">     
												<img src="images/mpview.gif" width="150" id="picview" name="picview" />
                                            </div>
                                        </div>
                                        
                                        <?php if($edit[imgpath] != ""){?>
                                        <div class="formrow">
                                            <h3 class="label">原来的图片</h3>
                                            <div class="form-enter">     
                                                <?php
                                                echo "<img src=".$mymps_global[SiteUrl]."".$edit[pre_imgpath]." style='_margin-top:expression(( 180 - this.height ) / 2);' />\r\n";
                                                ?>
                                            </div>
          								</div>
                                        <?php }
                                        }
                                        ?>
                                        
                                        <div class="formrow">
                                            <h3 class="label">详细内容</h3>
                                            <?php echo $acontent?>
                                        </div>

                                        <div class="formrow formrow-action">
                                            <span class="minbtn-wrap"><span class="btn"><input type="submit" value="提交保存" class="button" name="document_submit" /></span></span>
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