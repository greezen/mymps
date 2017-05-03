<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
$url = $url ? $url : htmlspecialchars_decode($url);
echo "<div style=\"font-size:12px; font-weight:100; margin:10px;\">您还没有登录会员管理,本站并不强制要求你必须登录会员后才能发布信息<br /><br />但是注册会员后，您可以更方便地管理自己发布的信息，这就<a href=\"".$mymps_global['SiteUrl']."/".$mymps_global['cfg_member_logfile']."?url=".$url."\" target=_top>试试 &raquo;</a></div>";
?>