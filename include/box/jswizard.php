<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
$flag = isset($_GET['flag']) ? trim($_GET['flag']) : '';
$jscharset = isset($_GET['jscharset']) ? intval($_GET['jscharset']) : '';
empty($flag) && exit('非法的参数请求！');
echo '<style>body:font-size:12px</style><textarea style="width:520px; height:50px;">'.mhtmlspecialchars('<script language="javascript" src="'.$mymps_global["SiteUrl"].'/javascript.php?flag='.$flag.'" '.($jscharset==1?'charset="utf-8"':'').'></script>').'</textarea><br /><br /><font style="font-size:12px">将编辑框内的代码复制到调用HTML对应位置即可</font>';
exit;
?>