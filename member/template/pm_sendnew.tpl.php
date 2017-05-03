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
        <h3 class="ptitle"><span>短消息管理</span></h3>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">                                                             
                <li><a href="?m=pm&ac=inbox"><span>收件箱</span></a></li>
                <li><a href="?m=pm&ac=outbox"><span>发件箱</span></a></li>
                <li><a href="?m=pm&ac=sendnew" class="current"><span>发短消息</span></a></li>
            </ul>
        </div>
        <div id="msg_success"></div>
<div id="msg_error"></div>
<div id="msg_alert"></div>
        <div class="datatablewrap">
			<form method="post" action="?m=<?=$m?>&ac=<?=$ac?>">
            <div class="formgroup">
                <div class="formrow">
                    <h3 class="label"><label>发送到</label></h3>
                    <div class="form-enter">
                        <input type="text" name="touser" style="width:400px" value="<?php echo $touser; ?>" class="text"/>（请填写会员用户名）
                    </div>
                </div>
                
                <div class="formrow">
                    <h3 class="label"><label>标题</label></h3>
                    <div class="form-enter">
                        <input type="text" name="title" style="width:400px" value="" class="text" />
                    </div>
                </div>
                
                <div class="formrow">
                    <h3 class="label"><label>内容</label></h3>
                    <div class="form-enter">
                        <textarea class="autosave" rows="15" cols="10" name="content" style="width: 95%;"></textarea>
                    </div>
                </div>
                <div class="formrow formrow-action">
                    <span class="minbtn-wrap"><span class="btn"><input type="submit" value="提交" class="button" name="pm_submit" /></span></span>
                </div>
            </div>
            </form>
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