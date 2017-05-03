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
                                    <h3 class="ptitle"><span>联系方式</span></h3>
                                </div></div></div>
                                <div class="pbody">

                                    <div class="formcaption-note">
                                        填写完善的联系方式, 可以帮助用户更容易找到你.
                                    </div>
                                    
									<div id="msg_success"></div>
									<div id="msg_error"></div>
									<div id="msg_alert"></div>
                                    
                                    <form action="?m=base" method="post">
                                    <?php if($error == '41'){?><input name="url" value="../<?=$mymps_global['cfg_postfile']?>" type="hidden"><?}?>
                                    <div class="formgroup">
                                        <div class="formrow">
                                            <h3 class="label"><label>用户名</label></h3>
                                            <div class="form-enter">
                                                <div style="font-weight:bold; margin-top:3px"><?php echo $s_uid; ?> <?php if($row['openid']){?><a style="margin-left:10px;" href="index.php?m=base&ac=nobind" title="解除QQ账号绑定"><img src="../include/qqlogin/noqq_login.png" align="absmiddle"></a><?php }?></div>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">真实姓名</h3>
                                            <div class="form-enter">
                                                <input type="text" name="cname" class="text" value="<?php echo $row['cname']; ?>"/>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">性别</h3>
                                            <div class="form-enter">
                                                <label for="gender1"><input type="radio" value="男" name="sex"  id="gender1" <?php if($row['sex'] == '男') echo 'checked'; ?> />男</label>
                                                <label for="gender2"><input type="radio" value="女" name="sex"  id="gender2" <?php if($row['sex'] == '女') echo 'checked'; ?> />女</label>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">手机号码</h3>
                                            <div class="form-enter">
                                                
<input type="text" class="text" name="mobile" value="<?php echo $row['mobile']?>" maxlength="" /> <label for="istel"><input type="checkbox" name="istel" value="1" id="istel">同步更新全部信息的联系电话</label>
                                            </div>
                                            <div class="form-note">如: 18888888888</div>
                                            
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">QQ </h3>
                                            <div class="form-enter">
                                                <input type="text" class="text" name="qq" value="<?php echo $row['qq']?>" maxlength="" />
                                                <label for="isqq"><input type="checkbox" name="isqq" value="1" id="isqq">同步更新全部信息的QQ号码</label></div>
                                            
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">EMAIL</h3>
                                            <div class="form-enter">     
												<input type="text" class="text" name="email" value="<?php echo $row['email']?>" maxlength="" />
                                                <label for="isemail"><input type="checkbox" name="isemail" value="1" id="isemail">同步更新全部信息的EMAIL</label></div>
                                        </div>

                                        <div class="formrow formrow-action">
                                            <span class="minbtn-wrap"><span class="btn"><input type="submit" value="提交" class="button" name="base_submit" /></span></span>
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