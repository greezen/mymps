<html><head><meta http-equiv="Content-Type" content="text/html; charset=gbk" /><link href="template/css/head.css" rel="stylesheet" type="text/css">


<title>管理中心</title>



<script type="text/javascript" src="js/menu.js"></script>

<script>var menus = new Array('index','info', 'member', 'category', 'news', 'siteabout', 'sitesys','plugin','extend');function togglemenu(id) {if(parent.framLeft) {for(k in menus) {if(parent.framLeft.document.getElementById(menus[k])) {parent.framLeft.document.getElementById(menus[k]).style.display = menus[k] == id ? '' : 'none';}}}}function sethighlight(n) {var lis = document.getElementsByTagName('li');for(var i = 0; i < lis.length; i++) {lis[i].id = '';}lis[n].id = 'menuon';}var framRight=window.parent.window.document.getElementById("framRight"); </script>

<style>body {background-color:#EAF7FF;margin:0;padding:0;overflow:visible;}.nav{font-size:14px;}img{ padding:0; margin:0}li{ list-style:none;}</style></head>

<body class="top" onLoad="sethighlight('0')"><div class="logonav"><div class="logo"><img src="template/images/3_01.jpg" border="0" alt="mymps 4.0i"/></div>

<div class="nav"><?php echo $mymps_admin_menu; ?><li><a href="http://zhideyao.cn" target="_blank">检查更新</a></li>

<li class="more"><a href="javascript:;" onClick="framRight.contentWindow.setbg('<?php echo MPS_SOFTNAME; ?>功能菜单',670,545,'../box.php?part=adminmenu&admindir=<?php echo $admindir;?>');">全 部&nbsp;</a></li></div><div class="sitenav"><?=$admin['cityname']?>管理中心</div></div><div class="afterlogonav"><div class="left1"><a href="../" target="_blank">网站首页</a></div><div class="left2"><a href="#" onClick="parent.framRight.location='?do=manage&part=right'">后台首页</a></div>

<div class="left3"><span>您好! <font color="#FF6600"><?php echo $admin_name?></font>。您的IP是：<font color="#FF6600"><?php echo GetIP(); ?></font>，管理员级别是<font color="#FF6600"><?php echo $level?></font>，管理员帐号是<font color="#FF6600"><?php echo $admin_id?></font> [<a target="framRight" href="admin.php?do=user&part=edit&userid=<?php echo $admin_id?>" style="text-decoration:underline;">改密</a>，<a href="index.php?part=out" style="text-decoration:underline;" target="_top">注销</a>]</span></div></div></body></html>