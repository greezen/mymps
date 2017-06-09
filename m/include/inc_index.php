<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
$categories = $db->getAll('SELECT * FROM `my_category` WHERE parentid=0 AND if_view=2 ORDER BY catorder ASC');
if (mgetcookie('post') == 1) {
    msetcookie('post', '');
    $url = 'http://'.$_SERVER['HTTP_HOST'] . '/m/index.php?mod=post&cityid='.$cityid;
    header('Location:'.$url);exit;
}
include( mymps_tpl( "index" ) );
?>
