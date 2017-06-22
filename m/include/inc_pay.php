<?php
if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
if ($iflogin == 0) {
    $url = 'http://'.$_SERVER["HTTP_HOST"].'/m/index.php?mod=login&returnurl='.$returnurl;
    header('Location:'.$url);
    exit;
}

$row = $db->get_one("SELECT * FROM ". $db_mymps . "property WHERE id='{$id}'");
$total = $row['manage_fee'] + $row['water_fee'] + $row['electric_fee'] + $row['other_fee'];

include( mymps_tpl( "member_pay" ) );
?>
