<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
define( "CURSCRIPT", "history" );
include( mymps_tpl( "member_history" ) );
?>
