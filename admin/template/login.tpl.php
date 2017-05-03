<!doctype html>
<html>

<head>
	<meta charset="gb2312" />
	<title>系统后台</title>
	<meta name="robots" content="noindex,nofollow">
	<link href="template/css/login.css" rel="stylesheet" />
	<script type="text/javascript" src="js/login.js"></script>
</head>

<body>
	<div class="topbg">
		<span class="left"><a href="<?php echo $mymps_global[SiteUrl]?>" target="_blank">访问网站首页</a></span>
		<span class="right"><a href="#" onClick="var strHref=window.location.href;this.style.behavior='url(#default#homepage)';this.setHomePage('<?php echo GetUrl();?>');" style="cursor: hand">设为首页</a> <a href="#" onClick="collect();">加入收藏</a></span>
	</div>
	<div class="wrap">
		<h1>Mymps 后台管理中心</h1>
		<form name="Login" action="index.php?part=chk&url=<?=$url?>&go=<?=$go?>" method="post" onSubmit="return CheckForm();">
			<input name="do" value="login" type="hidden">
			<div class="login">
				<ul>
					<li>
						<input class="input" required name="username" type="text" placeholder="帐号" title="管理员帐号" />
					</li>

					<li>
						<input class="input" type="password" required name="password" placeholder="密码" title="管理员密码" />
					</li>
					<?php if ($authcodesettings['adminlogin'] == 1){?>
					<li>
						<img style="float:right;" src="../<?php echo $mymps_global[cfg_authcodefile]; ?>" alt="看不清，请点击刷新" class="authcode" onClick="this.src=this.src+'?'" align="absmiddle"/> <input style="float:left; width:55px; height:40px;" class="input" type="text" required name="checkcode" placeholder="验证码" title="验证码" />
					</li>
					
					<?php }?>
				</ul>
				<button type="submit" name="submit" class="btn">登录管理</button>
			</div>
		</form>
	</div>
	<div class="foot">
		Powered by <a href="http://zhideyao.cn/" target="_blank">Mymps</a> <?php echo MPS_VERSION; ?>	</div>
</body>
</html>
