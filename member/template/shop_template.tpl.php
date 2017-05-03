<?php include mymps_tpl('inc_header'); ?>
<link rel="Stylesheet" type="text/css" href="template/css/new.dialog.css" />
<link rel="stylesheet" type="text/css" href="template/css/new.my.css" />
<script language="javascript" src="template/javascript.js"></script>
<script type="text/javascript" src="../template/global/messagebox.js"></script>
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
                                    <h3 class="ptitle"><span>商家店铺资料</span></h3>
                                </div></div></div>
                                <div class="pbody">
                                    <div class="cleafix pagetab-wrap">
                                        <ul class="pagetab">
                                            <li><a href="?m=shop&ac=base&type=corp" <?php if($ac == 'base'){?>class="current"<?php }?>><span><?php echo $if_corp != 1 ? '申请开通网上店铺' : '基本信息修改'; ?></span></a></li>
                                            <li><a href="?m=shop&ac=templat&type=corpe" <?php if($ac == 'template'){?>class="current"<?php }?>><span>店铺模板修改</span></a></li>
                                        </ul>
                                    </div>
									
									<div id="msg_success"></div>
									<div id="msg_error"></div>
									<div id="msg_alert"></div>
                                    
                                    <form action="?m=shop" method="post" name="form1" enctype="multipart/form-data" >
									<input name="ac" value="template" type="hidden">
									<input name="oldbanner" value="<?=$row[banner]?>" type="hidden">
                                    <div class="formgroup">
                                        
                                        <div class="formrow">
                                            <h3 class="label">空间风格</h3>
                                            <div class="form-enter">     
                                            <select name="template">
                                            <?=get_shop_tpl($row['template'],$s_uid);?>
                                            </select>
                                            </div>
                                        </div>
										
										<div class="formrow">
										<h3 class="label">顶部背景</h3>
										<div class="form-enter">
											 <?php if($row['banner'] != ''){?><img src="<?=$row[banner]?>" onload="if(this.width > 728) this.width = 728"><br><font style="color:#666">重新更换上传背景图片后，请<a href="javascript:window.location.reload();">刷新</a>浏览器</font><br>
<?php }else{?>尚未上传<?php }?> 
										</div>
										</div>
										
										<div class="formrow">
										<h3 class="label"><?php echo $row[banner] ? '更换' : '上传'; ?>背景</h3>
										<div class="form-enter">
											 <input name="banner" type="file" style="width:250px;"/> 
											 图片尺寸<?php echo $mymps_mymps['cfg_banner_limit']['width'];?>×<?php echo $mymps_mymps['cfg_banner_limit']['height'];?><br />
										支持上传的类型<?=$mymps_global[cfg_upimg_type]?>
										</div>
										</div>
										
										<div class="formrow">
										<h3 class="label">注意事项</h3>
										<div class="form-enter">
										 请确保图片清晰。图片格式为 <?=$mymps_global['cfg_upimg_type']?> ，不超过 <?=$mymps_global[cfg_upimg_size]?>KB 。<br />
										在上传过程中，如果长时间停止，请取消重传；或将图片缩小后重传。
										</div>
										</div>

                                        <div class="formrow formrow-action">
                                            <span class="minbtn-wrap"><span class="btn"><input type="submit" value="提交" class="button" name="shop_submit" /></span></span>
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