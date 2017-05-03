<?php
define('CURSCRIPT','desktop');
define('IN_MYMPS', true);
require_once dirname(__FILE__).'/include/global.php';
require_once dirname(__FILE__).'/data/config.php';

$Shortcut = "[InternetShortcut]
URL=$mymps_global[SiteUrl]/
IDList= 
[{000214A0-0000-0000-C000-000000000046}] 
Prop3=19,2 
"; 
header("Content-type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=$mymps_global[SiteName].url;"); 
echo $Shortcut;
?>