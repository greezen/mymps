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
                                    <h3 class="ptitle"><span>会员自助升级</span></h3>
                                </div></div></div>
                                <div class="pbody">
                                
                                    <div class="formcaption-note">
                                       您当前的会员级别：<b style="color:#FF3300"><?=$levelname?></b>，目前拥有金币<img src="template/images/coins.gif" align="absmiddle"> <b style="color:#FF3300"><?=$money_own?></b>
                                    </div>
                                    
                                    <div id="msg_success"></div>
<div id="msg_error"></div>
<div id="msg_alert"></div>
                                    
                                    <form method="post" name="form1" action="?m=levelup&ac=step3" enctype="multipart/form-data" onSubmit="return AvatarSubmit();">
                                    <input name="forwardlevel" value="<?php echo $forwardlevel; ?>" type="hidden">
                                    <div class="formgroup section-setting">
                                <div class="formrow">
                                            <h3 class="label">已选级别：</h3>
                                            <div class="form-enter">
                                              <strong style="color:#ff3300"><?php echo $forwardlevelname; ?></strong> <a href="?m=levelup">返回重选</a>
                                      		</div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">升级时长：</h3>
                                            <div class="form-enter">
                                             	<?php echo GetUplevelTime('leveluptime',$forwardlevel); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">将扣金币：</h3>
                                            <div class="form-enter" style="color:#ff3300">
                                             	<img src="template/images/coins.gif" align="absmiddle"> <font id="total">0</font>
                                            </div>
                                        </div>

                                        <div class="formrow formrow-action"><span class="minbtn-wrap"><span class="btn">
                                          <input type="submit" value="确认升级" class="button" name="levelup_submit" />
                                        </span></span></div>
                                    </div>
                                    </form>
									<script language="javascript">                                    
									function calculate() 
                                    {
										var ID1 = $obj('leveluptime').value;
										if(ID1 == 'halfyear'){
											$obj('total').innerHTML = '<?=$forwardlevelmoney[halfyear]?>';
										} else if(ID1 == 'year') {
											$obj('total').innerHTML = '<?=$forwardlevelmoney[year]?>';
										} else if(ID1 == 'forever') {
											$obj('total').innerHTML = '<?=$forwardlevelmoney[forever]?>';
										} else if(ID1 == 'month') {
											$obj('total').innerHTML = '<?=$forwardlevelmoney[month]?>';
										}
										setTimeout("calculate()",30);
                                    }
									calculate();
                                    </script>
                                    
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