<?php include mymps_tpl('inc_header'); ?>
<link rel="Stylesheet" type="text/css" href="template/css/new.dialog.css" />
<link rel="stylesheet" type="text/css" href="template/css/new.my.css" />
<link rel="stylesheet" type="text/css" href="template/css/contribute.css" />
<link rel="stylesheet" type="text/css" href="template/css/new.exchange.css" />
<script language="javascript">
var current_domain = '<?php echo $mymps_global[SiteUrl]?>';
</script>
<script language="javascript" src="../template/global/messagebox.js"></script>
<script language="javascript" src="template/javascript.js"></script>
</head>
<body class="<?php echo $mymps_global['cfg_tpl_dir']; ?>">
<div class="container">

<?php include mymps_tpl('inc_head'); ?>

    <div id="main" class="main section-default">
        <div class="clearfix main-inner">
            <div class="content">
                <div class="clearfix content-inner">
                    <div class="content-main">
                        <div class="content-main-inner">
                            <div class="pwrap accountinfo">
                                <div class="phead"><div class="phead-inner"><div class="phead-inner">
                                    <h3 class="ptitle"><span>帐号信息</span></h3>

                                </div></div></div>
                                <div class="pbody">
                                    <div class="clearfix accountinfo-dock">
                                        <div class="account-avatar">
                                            <a href="index.php?t=index&m=avatar" title="更改头像">
                                                <?php if (!empty($row['openid']) && substr($row['logo'], 0, 4) == 'http') :?>
                                                    <img src="<?=$row['logo']?>" alt="更改头像" width="48" height="48" />
                                                <?php else:?>
                                                    <img src="<?php echo $mymps_global['SiteUrl'].($face != '' ? $face : '/images/noavatar_small.gif')?>" alt="更改头像" width="48" height="48" />
                                                <?php endif;?>

                                                <span class="avatar-change">更改头像</span>
                                            </a>
                                        </div>
                                        <div class="account-quicktools">
                                        	<?php if(!empty($score_changer)){?>
                                        	<?php if($qdtime != $nowtime){?>
                                            <a class="account-qiandao" onClick="this.className='account-qiandao-dis'" href="javascript:setbg('每日签到',520,270,'../box.php?part=qiandao');">每日签到</a>
                                            <?php }else{ ?>
                                            <a class="account-qiandao-dis">每日签到</a>
                                            <?php }?>
                                            <?php }?>
                                            <a class="account-topup" href="index.php?m=pay">金币充值</a>

                                            <span class="account-sum" title="金币余额:<?php echo $row['money_own']?>"><strong><?php echo $row['money_own']?></strong></span>

                                        </div>
                                        <div class="account-uesrinfo">
                                            <span class="account-name"><?php echo !empty($row['openid'])?$row['nickname']:$row['tname'].$s_uid; ?> <font color=red>[<?=$levelname?>]</font> <a target="_blank" style="font-size:12px; font-weight:100;" href="<?php echo Rewrite('space',array('user'=>$row['userid']))?>">查看个人主页</a></span>
                                            <span class="account-id">UID: <?php echo $uid; ?></span>
                                        </div>
                                        <div class="account-baseinfo">
                                            <span>Email地址: <?php echo $row['email']; ?></span>
                                            <span>注册时间: <?php echo GetTime($row['jointime']); ?></span>
                                        </div>
                                        <div class="account-track">
                                            <span>上次访问时间: <?php echo GetTime($row['logintime'])?></span>
                                            <span>上次访问IP: <?php echo $row['loginip']?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pfoot"><p><b>-</b></p></div>
                            </div>

							<div id="msg_success"></div>
							<div id="msg_error"></div>
							<div id="msg_alert"></div>

                            <div class="pwrap pwrap-simple">
                            <div class="phead"><div class="phead-inner"><div class="phead-inner">
                                <h3 class="ptitle"><span>统计信息</span></h3>
                            </div></div></div>
                            <div class="pbody">
                            <ul class="clearfix statistics-list">
								<div class="clearfix counttable">
									<div class="cli"><span class="label">分类信息</span> <span class="value"><a href="index.php?m=info"><?=$info_total?>条</a></span> <input name="postinfo" value="发布信息&raquo;" type="button" class="postinfo" onClick="window.open('<?php echo (!$row['tel'] && !$row['qq']) ? '?m=base&error=41' : '../'.$mymps_global['cfg_postfile'].'?cityid='.$cityid; ?>')"></div>
									<div class="cli"><span class="label">短消息</span> <span class="value"><a href="index.php?m=pm"><?=$pm_total?>条</a></span></div>
									<?php if($if_corp == 1){?>
									<div class="cli"><span class="label">店铺相片</span> <span class="value"><a href="index.php?m=album&type=corp"><?=$album_total?>张</a></span><input name="postinfo" value="上传相片&raquo;" type="button" class="postinfo" style="color:#12459c" onClick="location.href='index.php?m=album&ac=upload&type=corp'"></div>
									<div class="cli"><span class="label">我的点评</span> <span class="value"><a href="index.php?m=comment&type=corp"><?=$comment_total?>次</a></span></div>
									<div class="cli"><span class="label">店铺文章</span> <span class="value"><a href="index.php?m=document&type=corp"><?=$document_total?>篇</a></span><input name="postinfo" value="发布文章&raquo;" type="button" class="postinfo" style="color:#12459c" onClick="location.href='index.php?m=document&ac=detail&type=corp'"></div>
									<?php if($coupon_total){?><div class="cli"><span class="label">优惠券</span> <span class="value"><a href="index.php?m=coupon&type=corp"><?=$coupon_total?>张</a></span> <input name="postinfo" value="传优惠券&raquo;" type="button" class="postinfo" style="color:#12459c" onClick="location.href='index.php?m=coupon&ac=detail&type=corp'"></div><?php }?>
									<?php if($group_total){?><div class="cli"><span class="label">团购</span> <span class="value"><a href="index.php?m=group&type=corp"><?=$group_total?>起</a></span> <input name="postinfo" value="发起团购&raquo;" type="button" class="postinfo" style="color:#12459c" onClick="location.href='index.php?m=group&ac=detail&type=corp'"></div><?php }?>
									<?php if($group_signin_total){?><div class="cli"><span class="label">团购报名</span> <span class="value"><a href="index.php?m=group&ac=signin&type=corp"><?=$group_signin_total?>个</a></span></div><?php }?>
									<?php if($goods_total){?><div class="cli"><span class="label">商品</span> <span class="value"><a href="index.php?m=goods&type=corp"><?=$goods_total?>件</a></span><input name="postinfo" value="出售商品&raquo;" type="button" class="postinfo" style="color:#12459c" onClick="location.href='index.php?m=goods&ac=detail&type=corp'"></div><?php }?>
									<?php if($goods_order_total){?><div class="cli"><span class="label">商品订单</span> <span class="value"><a href="index.php?m=goods&ac=order&type=corp"><?=$goods_order_total?>个</a></span></div><?php }?>
									<?php }?>
                                </div>
                            </ul>

                            </div>
                            <div class="pfoot"><p><b>-</b></p></div>
                            </div>

                            <div class="pwrap pwrap-simple exchange-finance">
                            <div class="phead"><div class="phead-inner"><div class="phead-inner">
                                <h3 class="ptitle"><span>财务信息</span></h3>
                            </div></div></div>
                            <div class="pbody">
                                <ul class="financelist">
                                    <li>
                                        <span class="label">账户余额:</span>
                                        <span class="value"><strong><?php echo $money_own; ?></strong> 金币</span>
                                        <a class="topup" href="index.php?m=pay">充值</a>
                                        <a class="withdraw" href="index.php?m=pay&ac=use">消费明细</a>
                                    </li>
									<li>
                                        <span class="label">您的积分:</span>
                                        <span class="value"><strong><?php echo $row['score']; ?></strong> 分</span>
										<a class="detail" href="javascript:setbg('兑换金币',450,270,'../box.php?part=score_coin&userid=<?=$s_uid?>');">兑换金币</a>
										<a style="color:#ff3300;" href="javascript:setbg('如何获得积分',350,270,'../box.php?part=howtogetscore');">如何获得积分？</a>

                                    </li>
									<li class="noborder">
                                        <span class="label">信用等级:</span>
                                        <span class="value"><strong><img src="../images/credit/<?php echo $row['credits']; ?>.gif" alt="信用值：<?php echo $row['credit']?>"></strong></span>
                                        <a class="detail" href="javascript:setbg('提升信用等级',650,270,'../box.php?part=credits_up&userid=<?=$s_uid?>');">提升信用等级</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="pfoot"><p><b>-</b></p></div>
                            </div>
							<div class="pwrap pwrap-simple exchange-security">
                            <div class="phead"><div class="phead-inner"><div class="phead-inner">
                                <h3 class="ptitle"><span>认证情况<font style="font-weight:100; color:#585858; font-size:12px">(通过认证，可获得积分奖励哦~)</font></span></h3>
                            </div></div></div>
                            <div class="pbody">
                                <ul class="securitylist">
									<?php if($if_corp == 1){?>
                                    <li>
                                        <span class="label">营业执照认证:</span>
                                        <span class="value">
											<?php if($row['com_certify'] == 1){?>
											<img align="absmiddle" src="../images/company1.gif" alt="已通过营业执照认证"/>
											<?}else{?>
											<img align="absmiddle" src="../images/company0.gif" alt="未通过营业执照认证"/>
											<?}?>
										</span>
                                        <a href="?m=certify&ac=com">提交执照认证</a>
                                    </li>
									<?php }?>
                                    <li class="noborder">
                                        <span class="label">身份证认证:</span>
                                        <span class="value">
											<?php if($row['per_certify'] == 1){?>
											<img align="absmiddle" src="../images/person1.gif" alt="已通过身份证认证"/>
											<?}else{?>
											<img align="absmiddle" src="../images/person0.gif" alt="未通过身份证认证"/>
											<?}?></span>
                                        <a href="?m=certify&ac=per">提交身份证认证</a>
                                    </li>
                                    </ul>
                            </div>
                            <div class="pfoot"><p><b>-</b></p></div>
                            </div>

							<?php if($mymps_global['cfg_if_affiliate'] == 1){?>
							<div class="pwrap pwrap-simple exchange-security">
                            <div class="phead"><div class="phead-inner"><div class="phead-inner">
                                <h3 class="ptitle"><span>注册推广</span></h3>
                            </div></div></div>
                            <div class="pbody">
                                <ul class="statistics-list clearfix">
                                    <li class="myurl">
                                        本站为鼓励推荐新用户注册，现开展推荐注册分成活动，活动流程如下：<br>

										1.复制本站提供给您的推荐代码，粘贴发送到论坛、博客上或者QQ好友。<br>2.访问者点击链接，访问本站。<br>
										3.在访问者点击链接的24小时内，若该访问者在本站注册，您将获得积分 <font color="#ff3300;"><?php echo $mymps_global['cfg_affiliate_score']?></font> 的奖励。<br>
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd" style="margin-top:5px">
<tr>
<td width="20%" height="50" bgcolor="#ffffff">&nbsp;&nbsp;网页签名代码</td>
<td bgcolor="#ffffff">&nbsp;&nbsp;<input size="115" onClick="this.select();" type="text" value="&lt;a href=&quot;<?php echo $mymps_global['SiteUrl']?>/index.php?fromuid=<?=$row[id]?>&quot; target=&quot;_blank&quot;&gt;<?php echo $mymps_global['SiteName']?>&lt;/a&gt;" style="border:1px solid #ccc;padding:3px 5px" /></td>
</tr>
<tr>
<td bgcolor="#ffffff" height="50">&nbsp;&nbsp;论坛签名代码</td>
<td bgcolor="#ffffff">&nbsp;&nbsp;<input size="115" onClick="this.select();" type="text" value="[url=<?php echo $mymps_global['SiteUrl']?>/index.php?fromuid=<?=$row[id]?>]<?php echo $mymps_global['SiteName']?>[/url]" style="border:1px solid #ccc;padding:3px 5px" /></td>
</tr>
<tr>
<td bgcolor="#ffffff" height="50">&nbsp;&nbsp;直接将链接发给QQ好友</td>
<td bgcolor="#ffffff">&nbsp;&nbsp;<input size="115" onClick="this.select();" type="text" value="<?php echo $mymps_global['SiteUrl']?>/index.php?fromuid=<?=$row[id]?>" style="border:1px solid #ccc;padding:3px 5px" /></td>
</tr>
</table>

                                    </li>

                                 </ul>
                            </div>
                            <div class="pfoot"><p><b>-</b></p></div>
                            </div>
							<?php }?>

                            <!--<div class="pwrap pwrap-simple exchange-security">
                            <div class="phead"><div class="phead-inner"><div class="phead-inner">
                                <h3 class="ptitle"><span>安全信息</span></h3>
                            </div></div></div>
                            <div class="pbody">
                                <ul class="securitylist">
                                    <li class="noborder">
                                        <span class="label">登录密码:</span>
                                        <span class="value">******</span>
                                        <a href="index.php?m=password">修改登录密码</a>
                                    </li>
                                    </ul>
                            </div>
                            <div class="pfoot"><p><b>-</b></p></div>
                            </div>-->

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