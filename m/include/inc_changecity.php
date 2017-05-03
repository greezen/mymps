<?php

if ( CURSCRIPT != "wap" )
{
	exit( "FORBIDDEN" );
}
$cities = $mymps_global['cfg_cityshowtype'] == "province" ? get_changeprovince_cities( ) : get_changecity_cities( );
$hotcities = get_hot_cities( );
include( mymps_tpl( "changecity" ) );
?>
