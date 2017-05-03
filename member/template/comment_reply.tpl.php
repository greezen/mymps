<?php include mymps_tpl('inc_header'); ?>
<link rel="stylesheet" type="text/css" href="template/css/new.exchange.css" />
<script language="javascript" src="template/javascript.js"></script>
<style>
.start0 { background:url('../template/default/<?=$mymps_global[cfg_tpl_dir]?>/images/review_start.gif') no-repeat 0 -1px;  width:58px; height:15px; }
.start1 { background:url('../template/default/<?=$mymps_global[cfg_tpl_dir]?>/images/review_start.gif') no-repeat 0 -15px; width:58px; height:15px; }
.start2 { background:url('../template/default/<?=$mymps_global[cfg_tpl_dir]?>/images/review_start.gif') no-repeat 0 -29px; width:58px; height:15px; }
.start3 { background:url('../template/default/<?=$mymps_global[cfg_tpl_dir]?>/images/review_start.gif') no-repeat 0 -43px; width:58px; height:15px; }
.start4 { background:url('../template/default/<?=$mymps_global[cfg_tpl_dir]?>/images/review_start.gif') no-repeat 0 -57px; width:58px; height:15px; }
.start5 { background:url('../template/default/<?=$mymps_global[cfg_tpl_dir]?>/images/review_start.gif') no-repeat 0 -71px; width:58px; height:15px; }
</style>
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
        <h3 class="ptitle"><span>点评管理</span></h3>
    </div></div></div>
    <div class="pbody">

        <div class="cleafix pagetab-wrap">
            <ul class="pagetab">
            <?php foreach(array('all'=>'所有评价','good'=>'好评','middle'=>'中评','bad'=>'差评') as $key => $val){?>
                <li><a href="?m=comment&c=<?=$key?>" <?php if($c == $key){?>class="current"<?php }?>><span><?=$val?></span></a></li>
            <?php }?>
            </ul>
        </div>
        <div id="msg_success"></div>
<div id="msg_error"></div>
<div id="msg_alert"></div>
        <div class="datatablewrap">
            <table class="datatable">
               <tbody>
               <tr>
                    <td height="15" colspan="10">
                        <div class="dataline"><span class="l">来自：</span><span class="r"><a href="../space.php?user=<?=$comment['fromuser']?>" target="_blank"><?=$comment['fromuser']?></a></span></div>
                        <div class="dataline"><span class="l">质量：</span><span class="r"><div class="start<?=$comment[quality]?>"></div></span></div>
                        <div class="dataline"><span class="l">服务：</span><span class="r"><div class="start<?=$comment[service]?>"></div></span></div>
                        <div class="dataline"><span class="l">环境：</span><span class="r"></span><div class="start<?=$comment[environment]?>"></div></div>
                        <div class="dataline"><span class="l">性价比：</span><span class="r"><div class="start<?=$comment[price]?>"></div></span></div>
                        <div class="dataline"><span class="l">点评时间：</span><span class="r"><?=GetTime($comment['pubtime'])?></span></div>
                        <div class="dataline"><span class="l">喜欢程度：</span><span class="r"><?php if($comment[enjoy] == '0'){echo '不喜欢';}elseif($comment[enjoy] == '1'){echo '无所谓';}elseif($comment[enjoy] == '2'){echo '喜欢';}elseif($comment[enjoy] == '3'){echo '很喜欢';}?></span></div>
                        <div class="dataline" style="border-bottom:none"><span class="l">点评内容：</span><span class="r"><?=$comment['content']?></span></div>
                    </td>
                </tr>
                </tbody>
                <tbody id="reply">
                    <tr>
                    <td colspan="3">
                        <form method="post" id="postform" action="?m=comment&c=<?=$c?>&id=<?=$id?>&do_act=reply">
                        <div class="highlightborder">
                            <table summary="回复点评" cellspacing="0" cellpadding="0" class="highlightbox">
                            <tr>
                                <td colspan="2" style="font-weight:bold" ><font id="action"><?php echo $comment['reply'] ? '修改回复' : '回复该点评'; ?></font></td>
                            </tr>
                            
                            <?php if($comment['reply']){?>
                            <tr>
                            <td valign="top"><label for="content">您的回复</label></td>
                            <td>
                            <?=$comment['reply']?>
                            </td>
                            </tr>
                            
                            <tr>
                            <td valign="top"><label for="content">回复时间</label></td>
                            <td>
                            <?=GetTime($comment['retime'])?>
                            </td>
                            </tr>
                            <?php }?>
                            
                            <tr>
                            <td valign="top"><label for="content"><?php echo $comment[reply] ? '修改' : ''; ?>回复</label></td>
                            <td><textarea id="reply" name="reply" style="width: 400px; height:120px"></textarea>
                            </td>
                            </tr>
                            
                            <tr class="btns">
                            <td>&nbsp;</td>
                            <td>
                            <div class="clearfix datacontrol">
                            <div class="dataaction">
                                <span class="minbtn-wrap"><span class="btn">
                                <input name="reply_submit" type="submit" class="button" value="提 交">
                                </span>
                            </div>
                            </div>
                            </td>
                            </tr>
                            </table>
                        </div>
                        </form>
                    </td>
                    </tr>
                </tbody>
            </table>
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