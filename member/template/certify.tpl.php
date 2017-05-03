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
        <h3 class="ptitle"><span>诚信认证</span></h3>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">
                <li><a href="?m=certify&ac=person" <?php if($ac == 'person') echo 'class="current"'; ?>><span>身份证认证</span></a></li>
                <?php if($if_corp == 1){?><li><a href="?m=certify&ac=com" <?php if($ac == 'com') echo 'class="current"'; ?>><span>执照认证</span></a></li><?php }?>
            </ul>
        </div>
        <div id="msg_success"></div>
        <?php if($certifylang){?><div id="msg_error" class="errormsg"><?php echo $certifylang; ?></div><?php } else {?>
        <div id="msg_error"></div>
        <?php }?>
        <form method="post" name="form1" action="?m=certify&ac=<?=$ac?>" enctype="multipart/form-data" onSubmit="return CertifySubmit();">
        <div class="formgroup section-setting">
        	<div class="formrow">
                <h3 class="label">当前状态：</h3>
                <div class="form-enter">
                    <?php if($per_certify == 1){?>
                    <img src="../images/person1.gif" alt="已通过身份证认证"/>
                    <?}else{?>
                    <img src="../images/person0.gif" alt="未通过身份证认证"/>
                    <?}?>
                    <?php if($com_certify == 1 && $if_corp == '1'){?>
                    <img src="../images/company1.gif" alt="已通过营业执照认证"/>
                    <?}else{?>
                    <img src="../images/company0.gif" alt="未通过营业执照认证"/>
                    <?}?>
                </div>
            </div>
            <div class="formrow">
                <h3 class="label">选择文件：</h3>
                <div class="form-enter">
                     <input name="certify_image" type="file" id="litpic" onChange="SeePic(document.picview,document.form1.litpic);"/><br />
        支持上传的类型：<?=$mymps_global[cfg_upimg_type]?>
                </div>
            </div>
            
            <div class="formrow">
                <h3 class="label">注意事项：</h3>
                <div class="form-enter">
                 请确保图片清晰。图片格式为 <?=$mymps_global[cfg_upimg_type]?> ，不超过 <?=$mymps_global[cfg_upimg_size]?>KB 。<br />
在上传过程中，如果长时间停止，请取消重传；或将图片缩小后重传。
                </div>
            </div>
        
            <div class="formrow formrow-action"><span class="minbtn-wrap"><span class="btn">
              <input type="submit" value="上 传" class="button" name="certify_submit" />
            </span></span></div>
        </div>
        </form>
        <?php if($ac == 'com'){ ?>
        <div class="topup-note">
            <p>
                <strong>营业执照审核注意事项： </strong>
            </p>
            <p>
                （1） 上传的营业执照需为加盖公司公章的副本复印件或扫描件； 
            </p>
            <p>
                （2） 证件要求完整、清晰； 
            </p>
            <p>
                （3） 证件上必须有工商部门的有效盖章；
            </p>
            <p>
                （4） 证件必须在有效期内，并有年检盖章； 
            </p>
            <p>
                （5） 用户填写联系人姓名要求是真实姓名，公司名称要求与证件信息一致。
            </p>
            <p>
                如果有任何疑问请联系<?=$mymps_global[SiteName]?>客服(周一至周五9:00 ~ 18:00 周六周日10:00 ~ 18:00)
            </p>
            <p>电话：<?=$mymps_global[SiteTel]?></p>
            <p>电子邮箱：<?=$mymps_global[SiteEmail]?></p>
        </div>
        <?php }?>
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