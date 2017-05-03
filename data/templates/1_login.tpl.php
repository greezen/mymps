<?php if(!defined('IN_MYMPS')) exit('Access Denied');
/*Mymps分类信息系统
官方网站：http://zhideyao.cn*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?=$page_title?></title>
<link rel="shortcut icon" href="<?=$mymps_global['SiteUrl']?>/favicon.ico" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/global.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/style.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/login.css" />
<script src="<?=$mymps_global['SiteUrl']?>/template/global/noerr.js" type="text/javascript"></script>
<script language="javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/login.js"></script>
</head>

<body class="<?=$mymps_global['cfg_tpl_dir']?> bodybg<?=$mymps_global['cfg_tpl_dir']?><?=$mymps_global['bodybg']?>"><div class="bartop">
<div class="barcenter">
<div class="barleft">
<ul class="barcity"><span><? if($city['cityname']) { ?><?=$city['cityname']?><?php } else { ?>总站<?php } ?></span> [<a href="<?=$mymps_global['SiteUrl']?>/changecity.php">切换分站</a>]</ul> 
<ul class="line"><u></u></ul>
<ul class="barcang"><a href="<?=$mymps_global['SiteUrl']?>/desktop.php" target="_blank" title="点击右键，选择“目标另存为”，将此快捷方式保存到桌面即可">保存到桌面</a></ul>
<ul class="line"><u></u></ul>
<ul class="barpost"><a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>">快速发布信息</a></ul>
<ul class="line"><u></u></ul>
<ul class="bardel"><a href="<?=$mymps_global['SiteUrl']?>/delinfo.php" rel="nofollow">修改/删除信息</a></ul>
<ul class="line"><u></u></ul>
<ul class="barwap"><a href="<?=$mymps_global['SiteUrl']?>/mobile.php">手机浏览</a></ul>
</div>
<div class="barright">
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/javascript.php?part=iflogin"></script>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="mhead">
<div class="logo"><a href="<?=$city['domain']?>" target="_blank"><img src="<?=$mymps_global['SiteUrl']?><?=$mymps_global['SiteLogo']?>" title="<?=$mymps_global['SiteName']?>"/></a></div>
<div class="navigation">
<a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_member_logfile']?>?cityid=<?=$city['cityid']?>" <? if($mod == 'login' || !$mod) { ?>class="current"<?php } ?>>用户登录</a>
<a href="<?=$mymps_global['cfg_member_logfile']?>?mod=register&cityid=<?=$city['cityid']?>" <? if($mod == 'register' || $mod == 'validate') { ?>class="current"<?php } ?>>立即注册</a>
<a href="<?=$mymps_global['cfg_member_logfile']?>?mod=forgetpass&cityid=<?=$city['cityid']?>" <? if($mod == 'forgetpass') { ?>class="current"<?php } ?>>找回密码</a>
</div>
</div><div class="clearfix"></div>
<div class="inner">
<div class="body">
<div class="log">
<form name="formLogin" method="post" action="<?=$mymps_global['cfg_member_logfile']?>" onSubmit="return submitForm();">
<input name="mod" type="hidden" value="login">
<input name="action" type="hidden" value="dopost">
<input name="url" type="hidden" value="<?=$url?>">
<table class="formlogin" cellpadding="0" cellspacing="0">
<tr>
<td class="tdright">帐号/邮箱/手机</td>
<td colspan="2">
<input name="userid" type="text" class="input input-large" placeholder="帐号/邮箱/手机"/></td>
</tr>
<tr>
<td class="tdright">登录密码</td>
<td colspan="2"><input name="userpwd" type="password" class="input input-large" placeholder="密码"/></td>
</tr>
            <? if($mymps_imgcode == 1) { ?>
<tr>
<td class="tdright">验证码</td>
<td colspan="2"><input type="text" name="checkcode" class="input input-small" placeholder="验证码"></td>
</tr>
            <tr>
<td class="tdright">&nbsp;</td>
<td colspan="2"><img src="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_authcodefile']?>" alt="看不清，请点击刷新" class="authcode" align="absmiddle" onClick="this.src=this.src+'?'"/>			</td>
</tr>
<?php } ?>
<tr>
<td>&nbsp;</td>
<td class="font12">&nbsp;<label for="remember"><input id="remember" name="memory" value="on" type="checkbox" class="checkbox" checked="checked"/> 下次自动登录</label></td>
<td class="font12right"><a href="?mod=forgetpass">忘记密码？</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
<td class="tdright"></td>
<td align="left" colspan="2">
<input type="submit" name="log_submit"  class="typebtn" value="立即登录"/>
</td>
</tr>
            <? if($mymps_global['ifqqlogin'] == 1) { ?>
<tr>
<td class="tdright qqlogin" style="height:60px"></td>
<td colspan="2" class="qqlogin"><br />
您也可以通过以下方式登录：
<br /><br />
<a href="<?=$mymps_global['SiteUrl']?>/include/qqlogin/qq_login.php"><img src="/include/qqlogin/qq_login.png" align="absmiddle"></a>
</td>
</tr>
<?php } ?>
</table>
</form>
</div>
<div class="reg">
<div class="cont">
<div class="font">还没有帐号？</div>
<div class="register_submit">
<a href="?mod=register&cityid=<?=$city['cityid']?>" class="registerbutton">注册帐号</a>
</div>
</div>
</div>
</div>
<div class="clear"></div><div class="footer">
&copy; <?=$mymps_global['SiteName']?> <a href="<?=$about['aboutus_uri']?>" target="_blank">关于我们</a> <a href="http://www.miibeian.gov.cn" target="_blank"><?=$mymps_global['SiteBeian']?></a> <?=$mymps_global['SiteStat']?> 
<span class="none_<?=$mymps_mymps['debuginfo']?>">
<? if($cachetime) { ?>
This page is cached at <? echo GetTime($timestamp,'Y-m-d H:i:s'); ?><?php } else { ?><?php $mtime = explode(' ', microtime());$totaltime = number_format(($mtime['1'] + $mtime['0'] - $mymps_starttime), 6); echo 'Processed in '.$totaltime.' second(s) , '.$db->query_num.' queries'; ?><?php } ?>
</span>
<span class="none">Powered by <strong><a href="http://zhideyao.cn" target="_blank">mymps</a></strong> <em><a href="http://zhideyao.cn" target="_blank"><?=MPS_VERSION?></a></em></span>
</div>
<p id="back-to-top"><a href="#top"><span></span></a></p>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/scrolltop.js"></script></div>

</body>
</html>
