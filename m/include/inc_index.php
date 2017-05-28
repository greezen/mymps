<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
$categories = $db->getAll('SELECT * FROM `my_category` WHERE parentid=0 AND if_view=2 ORDER BY catorder ASC');

include( mymps_tpl( "index" ) );
?>
