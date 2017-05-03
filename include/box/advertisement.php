<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
echo '<style>body:font-size:12px</style><textarea style="width:520px; height:50px;">'.mhtmlspecialchars('<script language="javascript" src="'.$mymps_global["SiteUrl"].'/javascript.php?part=advertisement&id='.$id.'"></script>').'</textarea><br /><br /><font style="font-size:12px">将编辑框内的代码复制到模板对应位置即可</font>';
exit;
?>