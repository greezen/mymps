<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function get_color_options( $tcolor = "" )
{
	global $color;
	foreach ( $color as $k => $v )
	{
		$mymps .= "<option value=".$k." style=background-color:".$k;
		if ( $k == $tcolor )
		{
			$mymps .= " selected";
		}
		$mymps .= ">".$v."</option>";
	}
	return $mymps;
}

$color = array( "#ff0000" => "红色", "#006ffd" => "深蓝", "#444444" => "浅蓝", "#000000" => "黑色", "#46a200" => "绿色", "#ff9900" => "黄色", "#ffffff" => "白色" );
?>
