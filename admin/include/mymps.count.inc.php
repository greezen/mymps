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
$ele = array( "information" => "信息", "member" => "会员", "certify" => "认证 ", "siteabout" => "站务", "plugin" => "插件" );
$element[information] = array( "信息" => array( "table" => "information", "url" => "information.php" ), "评论" => array( "table" => "comment", "where" => "WHERE type = 'information'", "url" => "comment.php?part=information" ), "举报" => array( "table" => "info_report", "url" => "information.php?part=report" ) );
$element[member] = array( "个人" => array( "table" => "member", "where" => "WHERE if_corp = '0' AND status = '1'", "url" => "member.php?if_corp=0" ), "商家" => array( "table" => "member", "where" => "WHERE if_corp = '1' AND status = '1'", "url" => "member.php?if_corp=1" ), "待审核" => array( "table" => "member", "where" => "WHERE `status` = '0'", "url" => "member.php?part=verify&do_action=default" ), "充值记录" => array( "table" => "payrecord", "url" => "payrecord.php" ) );
$element[certify] = array( "执照" => array( "table" => "certification", "where" => "WHERE typeid = '1'", "url" => "certification.php?typeid=1" ), "身份证" => array( "table" => "certification", "where" => "WHERE typeid = '2'", "url" => "certification.php?typeid=2" ) );
$element[siteabout] = array( "公告" => array( "table" => "announce", "url" => "announce.php" ), "帮助" => array( "table" => "faq", "url" => "faq.php" ), "友链" => array( "table" => "flink", "url" => "friendlink.php" ) );
$element[plugin] = array( "新闻" => array( "table" => "news", "url" => "news.php" ), "优惠券" => array( "table" => "coupon", "url" => "coupon_list.php" ), "团购" => array( "table" => "group", "url" => "group_list.php" ), "报名" => array( "table" => "group_signin", "url" => "group_signin.php" ), "商品" => array( "table" => "goods", "url" => "goods_list.php" ), "订单" => array( "table" => "goods_order", "url" => "goods_order.php" ) );
if ( $mymps_global['cfg_if_corp'] != 1 )
{
	unset( $element[plugin]['优惠券'] );
	unset( $element[plugin]['团购'] );
	unset( $element[plugin]['商品'] );
	unset( $element[plugin]['报名'] );
	unset( $element[plugin]['订单'] );
	unset( $element[member]['商家'] );
	unset( $element[certify]['执照'] );
}
?>
