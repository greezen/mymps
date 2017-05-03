<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
$categories = get_categories_tree( 0, "category" );
include( mymps_tpl( "index" ) );
?>
