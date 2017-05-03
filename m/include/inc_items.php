<?php
if ( CURSCRIPT != "wap" )
{
	exit( "FORBIDDEN" );
}
define( "CURSCRIPT", "items" );
include( mymps_tpl( "member_items" ) );
?>
