<?php include mymps_tpl('inc_header'); ?>
<link rel="Stylesheet" type="text/css" href="template/css/new.dialog.css" />
<link rel="stylesheet" type="text/css" href="template/css/new.my.css" />
<link rel="stylesheet" href="../include/datepicker/ui.css">
<script type="text/javascript" src="template/jquery.172.min.js"></script>
<script type="text/javascript" src="../include/datepicker/datepicker.js"></script>
<script language='javascript'>
$(function(){
	$("#begindate").datepicker();
	$("#enddate").datepicker();
});
</script>
<script language="javascript" src="template/javascript.js"></script>
<script language="javascript">
function check_sub(){
	<?php if(!$id){?>
	if (document.form1.coupon_image.value=="") {
		alert('请上传优惠券图片！');
		document.form1.coupon_image.focus();
		return false;
	}
	<?php }?>
	if (document.form1.title.value=="") {
		alert('请填写优惠券名称');
		document.form1.title.focus();
		return false;
	}
	if (document.form1.des.value=="") {
		alert('请填写简短说明！');
		document.form1.des.focus();
		return false;
	}
	return true;
}
</script>
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
                                    <h3 class="ptitle"><span><?php echo $id ? '修改' : '发布'?>优惠券</span></h3>
                                    <p class="pextra"><a href="?m=coupon&type=corp"><span>&laquo; 返回我上传的优惠券</span></a></p>
                                </div></div></div>
                                <div class="pbody">
                                    
									<div id="msg_success"></div>
									<div id="msg_error"></div>
									<div id="msg_alert"></div>
                                    <div style="display:none;">
                                        <iframe width=0 height=0 src='' id="iframe_area" name="iframe_area"></iframe> 
                                        <iframe width=0 height=0 src='' id="iframe_street" name="iframe_street"></iframe> 
                                        <form method="post" target="iframe_area" id="form_area"></form>
                                    </div>
                                    <form action="?m=coupon&ac=detail" enctype="multipart/form-data" method="post" name="form1" onSubmit="return check_sub();">
                                    <?php if(!empty($id)){?>
                                    	<input name="id" value="<?=$id?>" type="hidden">
                                        <input name="picture_old" value="<?=$edit['picture']?>" type="hidden">
                                        <input name="pre_picture_old" value="<?=$edit['pre_picture']?>" type="hidden">
                                    <?php }?>
                                    <input name="tid" value="<?=$tid?>" type="hidden">
                                    <div class="formgroup">
                                        <div class="formrow">
                                            <h3 class="label"><label>优惠券名称<font color="red">*</font></label></h3>
                                            <div class="form-enter">
                                                <input name="title" type="text" class="text" value="<?=$edit['title']?>" style="width:300px">
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">优惠券分类<font color="red">*</font></h3>
                                            <div class="form-enter">
                                                <?php echo get_couponclass_select('cate_id',$edit['cate_id']); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">所属地区<font color="red">*</font></h3>
                                            <div class="form-enter">
                                                <?php echo select_where('area','areaid',$edit['areaid'],$edit['cityid'] ? $edit['cityid'] : $cityid); ?>
                                            </div>
                                        </div>
                                        
                                        <?php if($edit[pre_picture]){?>
                                        <div class="formrow">
                                            <h3 class="label">原来的图片</h3>
                                            <div class="form-enter">     
                                                <?php
                                                echo "<img src=".$mymps_global[SiteUrl]."".$edit[pre_picture]." style='_margin-top:expression(( 180 - this.height ) / 2);' />\r\n";
                                                ?>
                                            </div>
          								</div>
                                        <?php }?>
                                        
                                        <div class="formrow">
                                            <h3 class="label"><?php echo $id ? '更新图片' : '上传图片<font color=red>*</font>'; ?></h3>
                                            <div class="form-enter">
                                                <input type="file" name="coupon_image" size="30" id="litpic">
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">有效期</h3>
                                            <input name="begindate" readonly id="begindate" type="text" class="text" value="<?php echo $begindate; ?>" style="width:100px"/> - <input name="enddate" id="enddate" readonly type="text" class="text" value="<?php echo $enddate; ?>" style="width:100px" />
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">简短说明<font color="red">*</font></h3>
                                            <div class="form-enter">
                                            	<textarea name="des" class="texttarea" style="width:360px; height:100px"><?=$edit['des']?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">详细说明</h3>
                                           	<?php echo $acontent; ?>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">可用？</h3>
                                            <div class="form-enter">
                                            	<input type="radio" name="status" value="1" id="radio_status_1"  checked="checked" class="radio"/><label for="radio_status_1">可用</label>&nbsp;<input type="radio" name="status" value="2" id="radio_status_2" class="radio"/><label for="radio_status_2">失效</label>
                                            </div>
                                        </div>
                                        
                                        <div class="formrow">
                                            <h3 class="label">优惠券类型</h3>
                                            <label for="1"><input name="ctype" type="radio" id="1" onclick='$("sup").style.display = "block";' class="radio" <?php if($edit['ctype'] == '折扣券' || empty($edit['ctype'])) echo 'checked'; ?>>折扣券</label> <label for="2"><input name="ctype" onclick='$("sup").style.display = "none";' value="2" id="2" type="radio" <?php if($edit['ctype'] == '抵价券') echo 'checked'; ?>>抵价券</label>
                                        </div>
                                        
                                        
                                         <div class="formrow" id="sup" <?php if($edit['sup'] == '抵价券') echo 'style="display:none"'?>>
                                            <h3 class="label">折扣</h3>
                                            <input name="sup" type="text" class="text" style="width:60px" value="<?=$edit['sup']?>"> 折
                                        </div>

                                        <div class="formrow formrow-action">
                                            <span class="minbtn-wrap"><span class="btn"><input type="submit" value="提交<?php echo empty($id) ? '上传' : '保存'; ?>" class="button" name="coupon_submit" /></span></span>
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