<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $charset; ?>" />
<link type="text/css" rel="stylesheet" href="template/images/style.css" />
<title><?php echo $info;?> - 系统安装 - <?php echo MPS_SOFTNAME;?> <?php echo MPS_VERSION;?></title>
</head>
<body>
<div class="wrapA">
  <div class="wrapB">
	<div class="wrapC">
	  <div id="header">
		<div class="logo left"><img src="template/images/install-logo.jpg" /></div>
		<div class="right"> <a href="http://zhideyao.cn" target="_blank" class="linkA">官方论坛</a> | <a href="http://zhideyao.cn" target="_blank" class="linkA">使用手册</a></div>
	  </div>
      <div id="main">
        <h2><span class="step"><?php echo $step; ?></span> <?php echo $info;?></h2>
        <div class="installInfo">
        <?php echo $installinfo;?>
        </div>