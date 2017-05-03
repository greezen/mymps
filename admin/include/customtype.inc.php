<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$customtypearr = array( );
$customtypearr['info'] = "分类信息";
if ( ifplugin( "news" ) )
{
	$customtypearr['news'] = "网站新闻";
}
if ( $mymps_global['cfg_if_corp'] == 1 )
{
	$customtypearr['store'] = "商家店铺";
}
if ( ifplugin( "goods" ) )
{
	$customtypearr['goods'] = "商品";
}
?>
