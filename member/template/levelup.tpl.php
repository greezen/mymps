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
                                    
                                    <div class="formcaption-note">
                                       <?php if(is_array($memberlevel_array)){?><div class="alertmsg"><?php echo $levelup_notice; ?></div><?php }?>
                                    </div>
                                    
                                    <div id="msg_success"></div>
<div id="msg_error"></div>
<div id="msg_alert"></div>
                                    
                                    <form method="post" name="form1" action="?m=levelup&ac=step2" onSubmit="return AvatarSubmit();">
                                    <div class="formgroup section-setting">
                                	<div class="formrow">
                                            <?php if(is_array($memberlevel_array)){?>
                                            <h3 class="label">选择级别：</h3>
                                            <div class="form-enter">
                                              <select name="forwardlevel">
                                                <?php foreach($memberlevel_array as $key => $val){?>
                                                <option value="<?=$val[levelid]?>">
                                                  <?=$val[levelname]?>
                                                </option>
                                                <?php }?>
                                              </select> 
                                     	 </div>
                                       <?php }?>
                                        </div>
										<?php if(is_array($memberlevel_array)){?>
                                        <div class="formrow formrow-action"><span class="minbtn-wrap"><span class="btn">
                                          <input type="submit" value="进入下一步" class="button" name="levelup_submit" />
                                        </span></span></div>
                                        <?php } else {?>
                                        <div class="nodata">您当前已经是最高级别不能再升级！<br><br><br></div>
                                        <?php }?>
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