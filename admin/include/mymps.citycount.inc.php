<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( !defined( "IN_MYMPS" ) )
{
	exit( "FORBIDDEN" );
}
$ele = array( "information" => "信息", "member" => "会员", "siteabout" => "站务", "plugin" => "插件" );
$element[information] = array( "信息" => array( "table" => "information", "url" => "information.php", "where" => $admin_cityid ? "WHERE cityid = '{$admin_cityid}'" : "" ) );
$element[member] = array( "个人" => array( "table" => "member", "where" => "WHERE if_corp = '0' AND status = '1'", "url" => "member.php?if_corp=0" ), "商家" => array( "table" => "member", "where" => $admin_cityid ? "WHERE cityid = '{$admin_cityid}' AND if_corp = '1' AND status = '1'" : "WHERE if_corp = '1' AND status = '1'", "url" => "member.php?if_corp=1" ), "待审核" => array( "table" => "member", "where" => $admin_cityid ? "WHERE cityid = '{$admin_cityid}' AND `status` = '0'" : "WHERE `status` = '0'", "url" => "member.php?part=verify&do_action=default" ) );
$element[siteabout] = array( "公告" => array( "table" => "announce", "url" => "announce.php", "where" => $admin_cityid ? "WHERE cityid = '{$admin_cityid}'" : "" ), "友链" => array( "table" => "flink", "url" => "friendlink.php", "where" => $admin_cityid ? "WHERE cityid = '{$admin_cityid}'" : "" ) );
$element[plugin] = array( "优惠券" => array( "table" => "coupon", "url" => "coupon_list.php", "where" => $admin_cityid ? "WHERE cityid = '{$admin_cityid}'" : "" ), "团购" => array( "table" => "group", "url" => "group_list.php", "where" => $admin_cityid ? "WHERE cityid = '{$admin_cityid}'" : "" ), "商品" => array( "table" => "goods", "url" => "goods_list.php", "where" => $admin_cityid ? "WHERE cityid = '{$admin_cityid}'" : "" ) );
?>
