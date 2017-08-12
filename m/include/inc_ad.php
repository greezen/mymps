<?php

if ( CURSCRIPT != "wap" )
{
	exit( "FORBIDDEN" );
}

$timestamp = time( );
define( CURSCRIPT, "ad" );

include( mymps_tpl( "ad" ) );
?>
