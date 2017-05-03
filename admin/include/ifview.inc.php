<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function get_ifview_options( $isview = "" )
{
	global $if_view;
	foreach ( $if_view as $key => $value )
	{
		$mymps .= "<option value=".$key;
		$mymps .= $isview == $key ? " style = \"background-color:#6EB00C;color:white\" selected>" : ">";
		$mymps .= $value."</option>";
	}
	return $mymps;
}

$if_view = array( "2" => "<font color=green>∆Ù”√</font>", "1" => "<font color=red>≤ª∆Ù”√</font>" );
?>
