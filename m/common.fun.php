<?php
function redirectmsg( $redirectmsg, $url )
{
    global $charset;
    global $mymps_global;
    global $cityid;
    echo "<?xml version=\"1.0\" encoding=\"".$charset."\"?>";
    include( mymps_tpl( "header_notify",'wap' ) );
    echo "<div>".$redirectmsg." <a href=\"".$url."\">µã´ËÌø×ª</a></div>";
    //echo "<script type='text/javascript'>location.href='".$url."'</script>";
    include( mymps_tpl( "footer_notify",'wap' ) );

    //header("location: ".$url);
    exit( );
}