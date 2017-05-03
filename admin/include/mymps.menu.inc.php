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
$admin_menu[siteabout][group][element]['关于我们']['栏目设置'] = "site_about.php?part=list";
$admin_menu[siteabout][group][element]['网站公告']['已发布公告'] = "announce.php";
$admin_menu[siteabout][group][element]['网站公告']['发布公告'] = "announce.php?part=add";
$admin_menu[siteabout][group][element]['帮助中心']['问题帮助'] = "faq.php";
$admin_menu[siteabout][group][element]['帮助中心']['发布帮助主题'] = "faq.php?part=add";
$admin_menu[siteabout][group][element]['友情链接']['友情链接'] = "friendlink.php";
$admin_menu[siteabout][group][element]['友情链接']['增加链接'] = "friendlink.php?part=add";
$admin_menu[siteabout][group][element]['其他站务']['链接导航'] = "navurl.php";
$admin_menu[siteabout][group][element]['其他站务']['生活百宝箱'] = "lifebox.php";
$admin_menu[siteabout][group][element]['其他站务']['便民电话'] = "telephone.php";
$admin_menu[info][name] = "信 息";
$admin_menu[info][style] = "";
$admin_menu[info][group][element]['信息相关']['分类信息'] = "information.php";
$admin_menu[info][group][element]['信息相关']['删除重复'] = "test_same.php";
$admin_menu[info][group][element]['信息相关']['批量管理'] = "infomanage.php";
$admin_menu[info][group][element]['信息相关']['信息评论'] = "comment.php";
$admin_menu[info][group][element]['信息相关']['信息举报'] = "information.php?part=report";
$admin_menu[info][group][element]['信息模型']['模型管理'] = "info_type.php?part=mod";
$admin_menu[info][group][element]['信息模型']['字段管理'] = "info_type.php";
$admin_menu[member][name] = "会 员";
$admin_menu[member][style] = "";
$admin_menu[member][group][element]['会员管理']['网站会员'] = "member.php";
$admin_menu[member][group][element]['会员管理']['审核会员'] = "member.php?part=verify&do_action=default";
$admin_menu[member][group][element]['会员管理']['增加会员'] = "member.php?part=add";
$admin_menu[member][group][element]['控制面板']['会员组'] = "member.php?do=group";
$admin_menu[member][group][element]['控制面板']['实名认证'] = "certification.php?typeid=1";
$admin_menu[member][group][element]['控制面板']['会员文档'] = "document.php?do=document";
$admin_menu[member][group][element]['控制面板']['站内短消息'] = "pm.php";
$admin_menu[member][group][element]['控制面板']['模板点评'] = "member_tpl.php";
$admin_menu[member][group][element]['会员日志']['会员登录记录'] = "record.php?do=member&part=login";
$admin_menu[member][group][element]['会员日志']['会员支付记录'] = "payrecord.php";
$admin_menu[member][group][element]['会员日志']['会员消费记录'] = "record.php?do=member&part=money&type=use";
$admin_menu[category][name] = "分 类";
$admin_menu[category][style] = "";
$admin_menu[category][group][element]['信息分类']['信息分类'] = "category.php";
$admin_menu[category][group][element]['信息分类']['添加分类'] = "category.php?part=add";
$admin_menu[category][group][element]['分站划分']['已建分站'] = "area.php";
$admin_menu[category][group][element]['分站划分']['添加分站'] = "area.php?part=area_city_add";
$admin_menu[category][group][element]['分站划分']['添加地区'] = "area.php?part=area_add";
$admin_menu[category][group][element]['分站划分']['添加路段'] = "area.php?part=area_street_add";
$admin_menu[category][group][element]['商家分类']['商家分类'] = "corp.php";
$admin_menu[category][group][element]['商家分类']['增加分类'] = "corp.php?part=add";
$admin_menu[sitesys][name] = "系 统";
$admin_menu[sitesys][style] = "";
$admin_menu[sitesys][group][element]['管理员']['用户列表'] = "admin.php?do=user";
$admin_menu[sitesys][group][element]['管理员']['用户组'] = "admin.php?do=group";
$admin_menu[sitesys][group][element]['管理员']['管理记录'] = "record.php?do=admin&part=login";
$admin_menu[sitesys][group][element]['数据库操作']['数据库备份'] = "database.php?part=backup";
$admin_menu[sitesys][group][element]['数据库操作']['数据库还原'] = "database.php?part=restore";
$admin_menu[sitesys][group][element]['数据库操作']['数据库维护'] = "database.php?part=optimize";
$admin_menu[sitesys][group][element]['核心设置']['系统配置'] = "config.php";
$admin_menu[sitesys][group][element]['核心设置']['分站设置'] = "city.php";
$admin_menu[sitesys][group][element]['核心设置']['模板管理'] = "template.php";
$admin_menu[sitesys][group][element]['核心设置']['SEO伪静态'] = "seoset.php";
$admin_menu[sitesys][group][element]['核心设置']['验证过滤点评'] = "config.php?part=imgcode";
$admin_menu[sitesys][group][element]['核心设置']['积分信用等级'] = "score.php";
$admin_menu[sitesys][group][element]['核心设置']['缓存设置'] = "config.php?part=cache_sys";
$admin_menu[sitesys][group][element]['核心设置']['文字内链设置'] = "insidelink.php";
$admin_menu[sitesys][group][element]['核心设置']['附件管理'] = "file_manage.php?part=upload";
$admin_menu[sitesys][group][element]['核心设置']['手机访问设置'] = "mobile.php";
$admin_menu[plugin][name] = "插 件";
$admin_menu[plugin][style] = "";
$admin_menu[plugin][group][element]['插件管理'] = array( "已安装插件" => "plugin.php" );
@include( dirname( __FILE__ )."/../../data/caches/pluginmenu_admin.php" );
if ( is_array( $data ) )
{
	foreach ( $data as $key => $val )
	{
		$admin_menu[plugin][group][element][$key] = $val;
	}
	unset( $data );
}
$admin_menu[extend][name] = "扩 展";
$admin_menu[extend][style] = "";
$admin_menu[extend][group][element]['邮件设置']['邮件服务器'] = "mail.php?part=setting";
$admin_menu[extend][group][element]['邮件设置']['邮件模板'] = "mail.php?part=template";
$admin_menu[extend][group][element]['邮件设置']['邮件发送记录'] = "mail.php?part=sendlist";
$admin_menu[extend][group][element]['在线支付']['管理支付接口'] = "payapi.php";
$admin_menu[extend][group][element]['其它扩展']['管理广告位'] = "adv.php";
$admin_menu[extend][group][element]['其它扩展']['数据调用'] = "jswizard.php";
$admin_menu[extend][group][element]['其它扩展']['整合接口设置'] = "passport.php";
$admin_menu[extend][group][element]['系统帮助']['系统环境'] = "config.php?part=phpinfo";
?>
