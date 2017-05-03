<?php if(!defined('IN_MYMPS')) exit('Access Denied');
/*Mymps分类信息系统
官方网站：http://zhideyao.cn*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="shortcut icon" href="<?=$mymps_global['SiteUrl']?>/favicon.ico" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/global.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/style.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/login.css" />
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/global.js" type="text/javascript"></script>
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/validator.common.js"></script> 
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/validator.js"></script> 
<title><?=$page_title?></title>
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
<div class="registerpart">
<div class="step2">
<span>1. 选择注册类型<a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_member_logfile']?>?mod=register&cityid=<?=$city['cityid']?>">（点此重选）</a></span>
<span class="cur">2. 注册个人会员</span>
<span>3. 登录会员中心</span>
</div>
<div class="regdetail">
<div class="partname">
<div class="li1">帐号信息</div>
<div class="li2">(带<font color="red">*</font>为必填项)</div>
</div>
<form method="post" action="<?=$mymps_global['cfg_member_logfile']?>" name="registerform" id="registerform">
<div class="partinput">

<input name="mod" value="register" type="hidden"/>
<input name="reg_corp" value="0" type="hidden"/>
<input name="mixcode" value="<?=$mixcode?>" type="hidden">
<table class="formlogin" cellpadding="0" cellspacing="0">
<tr>
<td class="tdright"><font color=red>*</font>用户名：</td>
<td>
<input name="userid" id="reg_username" type="text" class="input input-large" require="true" datatype="userName|limit|ajax" url="<?=$mymps_global['SiteUrl']?>/javascript.php?part=chk_remember" min="5" max="20" msg="5到20个字母或数字，不能以数字开头||">&nbsp;
</td>
</tr>
<tr>
<td class="tdright"><font color=red>*</font>电子邮箱：</td>
<td><input name="email" type="text" class="input input-large" require="true" datatype="email|limit|ajax" url="<?=$mymps_global['SiteUrl']?>/javascript.php?part=chk_remail" id="email" msg="用于找回密码，邮箱格式不正确">
</td>
</tr>
<tr>
<td class="tdright"><font color=red>*</font>密码：</td>
<td>
<input id="reg_password" name="userpwd" type="password" class="input input-large" require="true" datatype="limitB" min="6" max="16" msg="密码不得少于6个字符或超过16个字符！" maxlength="16">
</td>
</tr>
<tr>
<td scope="row" class="tdright">密码强度：</td>
<td>
<div id="pw_check_1" class="pw_check">
<span><strong class="c_orange">弱</strong></span>
<span>中</span>
<span>强</span>
</div>
<div id="pw_check_2" class="pw_check" style="display:none;">
<span>弱</span>
<span><strong class="c_orange">中</strong></span>
<span>强</span>
</div>
<div id="pw_check_3" class="pw_check" style="display:none;">
<span>弱</span>
<span>中</span>
<span><strong class="c_orange">强</strong></span>
</div>
</td>
</tr>
<tr>
<td class="tdright"><font color=red>*</font>确认密码：</td>
<td><input name="reuserpwd" type="password" to="userpwd" class="input input-large" msg="两次输入的密码不一致" id="pwdconfirm" require="true" datatype="repeat">
</td>
</tr>
<? if($mymps_imgcode == 1) { ?>
<tr>
<td class="tdright"><font color=red>*</font>验证码：</td>
<td><input type="text" name="checkcode" datatype="limit|ajax" require="true" class="input" id="checkcode" min="1" msgid="code" msg="请输入验证码" url="<?=$mymps_global['SiteUrl']?>/javascript.php?part=chk_authcode"> <span id="code"></span>
</td>
</tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td><img src="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_authcodefile']?>" id="checkcode" align="absmiddle" title="看不清，请点击刷新" onClick="this.src=this.src+'?'" class="authcode"/></td>
                    </tr>
<?php } ?>
                    <? if($checkquestion) { ?>
<tr>
<td class="tdright"><font color=red>*</font>验证回答：</td>
<td><input name="checkquestion[answer]" id="checkanswer" msgid="wer" value="" type="text" class="input" datatype="limit|ajax" require="true" msg="请填写验证答案" url="<?=$mymps_global['SiteUrl']?>/javascript.php?part=chk_answer&id=<?=$checkquestion['id']?>"/>
<div class="qfont"><?=$checkquestion['question']?></div>
<input name="checkquestion[id]" type="hidden" value="<?=$checkquestion['id']?>"/>
<span id="wer"></span>
</td>
</tr>
                    <?php } ?>
<tr>
<td class="tdright" style="height: 44px"></td>
<td style="height: 44px"><input type="submit" name="log_submit" value="同意协议，完成注册" onclick="return AllInputCheck();" id="agreereg" class="go_reg" />
</td>
</tr>
</table>
</div>
</form>
<div class="xiyi">
<div id="xieyi">
<div class="xieye_nr">
<p>欢迎光临<?=$mymps_global['SiteName']?>网站。<?=$mymps_global['SiteName']?>致力于为您提供最优质、最便捷的服务。在访问<?=$mymps_global['SiteName']?>的同时，也请您仔细阅读我们的协议条款。您需要同意该条款才能注册成为我们的用户。一经注册，将视为接受并遵守该条款的所有约定。<br /></p>
<p>
1．用户应按照<?=$mymps_global['SiteName']?>的注册、登陆程序和相应规则进行注册、登陆，注册信息应真实可靠，信息内容如有变动应及时更新。<br />
<br />
2．用户应在适当的栏目或地区发布信息，所发布信息内容必须真实可靠，不得违反<?=$mymps_global['SiteName']?>对发布信息的禁止性规定。用户对其自行发表、上传或传送的内容负全部责任。<br />
<br />
3．遵守中华人民共和国相关法律法规，包括但不限于《中华人民共和国计算机信息系统安全保护条例》、《计算机软件保护条例》、《最高人民法院关于审理涉及计算机网络著作权纠纷案件适用法律若干问题的解释(法释[2004]1号)》、《互联网电子公告服务管理规定》、《互联网新闻信息服务管理规定》、《互联网著作权行政保护办法》和《信息网络传播权保护条例》等有关计算机互联网规定和知识产权的法律和法规、实施办法。<br />
<br />
4．所有用户不得在<?=$mymps_global['SiteName']?>任何版块发布、转载、传送含有下列内容之一的信息，否则<?=$mymps_global['SiteName']?>有权自行处理并不通知用户：<br />
(1)违反宪法确定的基本原则的； (2)危害国家安全，泄漏国家机密，颠覆国家政权，破坏国家统一的； (3)损害国家荣誉和利益的； (4)煽动民族仇恨、民族歧视，破坏民族团结的； (5)破坏国家宗教政策，宣扬邪教和封建迷信的；  (6)散布淫秽、色情、赌博、暴力、恐怖或者教唆犯罪的； (7)侮辱或者诽谤他人，侵害他人合法权益的；  (8)含有法律、行政法规禁止的其他内容的。<br />
</p>
</div>
</div>
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
<script language="javascript" type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/validator2.js"></script> 