<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$admin_menu[siteabout][name] = "站 务";
$admin_menu[siteabout][style] = "home";
$admin_menu[siteabout][group][element]['首页焦点图']['焦点图列表'] = "focus.php";
$admin_menu[siteabout][group][element]['首页焦点图']['上传焦点图'] = "focus.php?part=add";
$admin_menu[siteabout][group][element]['网站公告']['已发布公告'] = "announce.php";
$admin_menu[siteabout][group][element]['网站公告']['发布公告'] = "announce.php?part=add";
$admin_menu[siteabout][group][element]['友情链接']['友情链接'] = "friendlink.php";
$admin_menu[siteabout][group][element]['友情链接']['增加链接'] = "friendlink.php?part=add";
$admin_menu[siteabout][group][element]['其他站务']['生活百宝箱'] = "lifebox.php";
$admin_menu[siteabout][group][element]['其他站务']['便民电话'] = "telephone.php";
$admin_menu[info][name] = "信 息";
$admin_menu[info][style] = "";
$admin_menu[info][group][element]['信息相关']['分类信息'] = "information.php";
$admin_menu[info][group][element]['信息相关']['批量管理'] = "infomanage.php";
$admin_menu[info][group][element]['信息相关']['信息举报'] = "information.php?part=report";
$admin_menu[member][name] = "会 员";
$admin_menu[member][style] = "";
$admin_menu[member][group][element]['成员管理']['个人会员'] = "member.php?if_corp=0";
$admin_menu[member][group][element]['成员管理']['商家会员'] = "member.php?if_corp=1";
$admin_menu[member][group][element]['成员管理']['增加会员'] = "member.php?part=add";
$admin_menu[member][group][element]['控制面板']['实名认证'] = "certification.php?typeid=1";
$admin_menu[member][group][element]['控制面板']['站内短消息'] = "pm.php";
$admin_menu[sitesys][name] = "系 统";
$admin_menu[sitesys][style] = "";
$admin_menu[sitesys][group][element]['管理员']['用户列表'] = "admin.php?do=user";
@include( dirname( __FILE__ )."/../../data/caches/pluginmenu_admin.php" );
if ( is_array( $data ) )
{
	$admin_menu[plugin][name] = "插 件";
	$admin_menu[plugin][style] = "";
	unset( $data['优惠券']['优惠券分类'] );
	unset( $data['团购']['团购分类'] );
	unset( $data['新闻资讯'] );
	unset( $data['商品']['商品分类'] );
	foreach ( $data as $key => $val )
	{
		$admin_menu[plugin][group][element][$key] = $val;
	}
	unset( $data );
}
$admin_menu[extend][name] = "扩 展";
$admin_menu[extend][style] = "";
$admin_menu[extend][group][element]['其它扩展']['管理广告位'] = "adv.php";
?>
