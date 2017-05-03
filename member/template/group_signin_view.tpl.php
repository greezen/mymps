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
                                    <h3 class="ptitle"><span>报名详细信息</span></h3>
                                </div></div></div>
                                <div class="pbody">
                                    
                                    <div class="formgroup">
                                    
                                        <div class="formrow">
                                            <h3 class="label"><label>所报活动</label></h3>
                                            <div class="form-enter">
                                                <a href="../group.php?id=<?$id?>" target="_blank"><?php echo $signin['gname']?></a>
                                            </div>
                                        </div>
                                    
                                        <div class="formrow">
                                            <h3 class="label"><label>真实姓名</label></h3>
                                            <div class="form-enter">
                                                <?php echo $signin['sname']?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">性别</h3>
                                            <div class="form-enter">
                                                <?php echo $signin['sex']?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">年龄</h3>
                                            <div class="form-enter">
                                                <?php echo $signin['age']?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">参加人数</h3>
                                            <div class="form-enter">
                                                <?php echo $signin['totalnumber']?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">简短附言</h3>
                                            <div class="form-enter">
                                                <?php echo $signin['message']?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">联系QQ </h3>
                                        	<div class="form-enter">
                                                <?php echo $signin['qqmsn']?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">联系电话 </h3>
                                        	<div class="form-enter">
                                                <?php echo $signin['tel']?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">报名时间 </h3>
                                        	<div class="form-enter">
                                                <?php echo GetTime($signin['dateline'])?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">报名IP </h3>
                                        	<div class="form-enter">
                                                <?php echo $signin['signinip']?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow formrow-action">
                                            <span class="minbtn-wrap"><span class="btn"><input type="button" value="返回" class="button" onClick="history.back();" /></span></span>
                                        </div>

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
<?php include mymps_tpl('inc_foot'); ?>
</div>
</body>
</html>