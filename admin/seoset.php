<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getseotype( $seo_type = "", $formname = "seo_type" )
{
	global $mymps_mymps;
	$seo_arr = array( "active" => "动态", "rewrite" => "伪静态" );
	if ( in_array( $formname, array( "seo_force_category", "seo_force_info" ) ) && $mymps_mymps['cfg_if_rewritepy'] == 1 )
	{
		$seo_arr = array( "active" => "动态", "rewrite" => "伪静态", "rewrite_py" => "拼音伪静态" );
	}
	$seo_type_form = "<select name='".$formname."' id='{$formname}'>";
	foreach ( $seo_arr as $k => $v )
	{
		if ( $k == $seo_type && $k != "" )
		{
			$seo_type_form .= "<option value='".$k."' selected style='background-color:#6EB00C;color:white'>{$v}/{$k}</option>\r\n";
		}
		else
		{
			$seo_type_form .= "<option value='".$k."'>{$v}/{$k}</option>\r\n";
		}
	}
	$seo_type_form .= "</select>\r\n";
	return $seo_type_form;
}

define( "CURSCRIPT", "seoset" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
$admdir = getcwdol( );
$admdir = $admdir ? substr( $admdir, 1 ) : "admin";
if ( $admin_cityid )
{
	write_msg( "您没有权限访问该页！" );
}
if ( $action == "makeapacherewrite" )
{
	$seo = get_seoset( );
	$allcities = get_allcities( );
	$documentroots = "";
	$conf = "";
	if ( is_array( $allcities ) )
	{
		$documentroots = str_replace( "\\", "/", dirname( dirname( __FILE__ ) ) );
		foreach ( $allcities as $k => $v )
		{
			$ServerName = preg_replace( "/^http:\\/\\/(.*)/is", "\\1", $v[domain] );
			$documentroot = $documentroots.$mymps_global[cfg_citiesdir].( "/".$v['directory'] );
			if ( substr( $ServerName, -1 ) == "/" )
			{
				$ServerName = substr( $ServerName, 0, -1 );
			}
			$conf .= "\r\n<VirtualHost *:80>\r\nDocumentRoot \"".$documentroot."\"\r\nServerName ".$ServerName."\r\nDirectoryIndex index.php\r\n<Directory \"".$documentroot."\">\r\nOptions FollowSymLinks\r\nAllowOverride All\r\nOrder allow,deny\r\nAllow from all\r\n</Directory>\r\n<IfModule mod_rewrite.c>\r\nRewriteEngine On\r\nRewriteRule ^(.*)/space/([a-z0-9\\-\\_]+)/$ $1/space\\.php\\?user=$2\r\nRewriteRule ^(.*)/store-([0-9]+)/$ $1/store\\.php\\?uid=$2\r\nRewriteRule ^(.*)/store-([0-9]+)/([^\\/]+).html$ $1/store\\.php\\?uid=$2&Uid=$3";
			if ( $seo['seo_force_category'] == "rewrite_py" )
			{
				$conf .= "\r\nRewriteRule ^(.*)/([^\\/]+)/$ $1/category\\.php\\?Catid=$2";
			}
			else if ( $seo['seo_force_category'] == "rewrite" )
			{
				$conf .= "\r\nRewriteRule ^(.*)/category-([^\\/]+)\\.html$ $1/category\\.php\\?CAtid=$2";
			}
			if ( $seo['seo_force_info'] == "rewrite_py" )
			{
				$conf .= "\r\nRewriteRule ^(.*)/([^\\/]+)/([0-9]+)\\.html$ $1/information\\.php\\?id=$3";
			}
			else if ( $seo['seo_force_info'] == "rewrite" )
			{
				$conf .= "\r\nRewriteRule ^(.*)/information-id-([0-9]+)\\.html$ $1/information\\.php\\?id=$2";
			}
			$conf .= "\r\nRewriteRule ^(.*)/news\\.html$ $1/news\\.php\r\nRewriteRule ^(.*)/news-id-([0-9]+)\\.html$ $1/news\\.php\\?id=$2\r\nRewriteRule ^(.*)/news-catid-([0-9]+)\\.html$ $1/news\\.php\\?catid=$2\r\nRewriteRule ^(.*)/news-catid-([0-9]+)-page-([0-9]+)\\.html$ $1/news\\.php\\?catid=$2&page=$3\r\nRewriteRule ^(.*)/corporation\\.html$ $1/corporation\\.php\r\nRewriteRule ^(.*)/corporation-([^\\/]+)\\.html$ $1/corporation\\.php\\?Catid=$2\r\nRewriteRule ^(.*)/sitemap\\.html$ $1/about\\.php\\?part=sitemap\r\nRewriteRule ^(.*)/aboutus\\.html$ $1/about\\.php\\?part=aboutus\r\nRewriteRule ^(.*)/aboutus-id-([0-9]+)\\.html$ $1/about\\.php\\?part=aboutus&id=$2\r\nRewriteRule ^(.*)/announce\\.html$ $1/about\\.php\\?part=announce&id=$2\r\nRewriteRule ^(.*)/faq\\.html$ $1/about\\.php\\?part=faq\r\nRewriteRule ^(.*)/faq-id-([0-9]+)\\.html$ $1/about\\.php\\?part=faq&id=$2\r\nRewriteRule ^(.*)/friendlink\\.html$ $1/about\\.php\\?part=friendlink\r\n</IfModule>\r\n</VirtualHost>\r\n";
		}
	}
	if ( !createfile( MYMPS_ROOT."/apache.txt", $conf ) )
	{
		write_msg( MYMPS_ROOT."/apache.txt 文件不可写，请检查根目录权限！" );
	}
	else
	{
		write_msg( "apache.txt文件更新成功！", "seoset.php" );
	}
	unset( $conf );
	unset( $cities );
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	$here = MPS_SOFTNAME."SEO优化设置";
	chk_admin_purview( "purview_SEO伪静态" );
	$res = $db->query( "SELECT description,value FROM ".$db_mymps."config WHERE type='seo'" );
	while ( $row = $db->fetchrow( $res ) )
	{
		$seo[$row['description']] = $row['value'];
	}
	include( mymps_tpl( CURSCRIPT ) );
}
else
{
	$seo_setarr = array( "seo_sitename", "seo_keywords", "seo_description", "seo_htmldir", "seo_htmlnewsdir", "seo_htmlext", "seo_force_about", "seo_force_category", "seo_force_info", "seo_force_news", "seo_force_yp", "seo_force_space", "seo_force_store", "seo_html_make" );
	mymps_delete( "config", "WHERE type = 'seo'" );
	foreach ( $seo_setarr as $key )
	{
		if ( $key == "keywords" )
		{
			$key = str_replace( "，", ",", $key );
		}
		$db->query( "INSERT ".$db_mymps."config (description,value,type) VALUES ('{$key}','{$$key}','seo')" );
	}
	foreach ( array( "category_tree", "corp_tree", "seoset" ) as $range )
	{
		clear_cache_files( $range );
	}
	updateadvertisement( );
	if ( $updatefile == 1 )
	{
		$rules['iis'] .= "[ISAPI_Rewrite]\r\nCacheClockRate 3600\r\nRepeatLimit 32\r\n";
		$rules['apache'] .= "RewriteEngine On\r\n";
		$rules['iis7'] .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<configuration>\r\n<system.webServer>\r\n<rewrite>\r\n<rules>\r\n";
		if ( $seo_force_space == "rewrite" )
		{
			$rules['iis'] .= "RewriteRule ^(.*)/space/([a-z0-9\\-\\_]+)/$ $1/space\\.php\\?user=$2\r\n";
			$rules['apache'] .= "RewriteRule ^(.*)space/([a-z0-9\\-\\_]+)\\/$ $1/space\\.php\\?user=$2\r\n";
			$rules['iis7'] .= "<rule name=\"space\">\r\n<match url=\"^space/([a-z0-9A-Z]+)/$\" />\r\n<action type=\"Rewrite\" url=\"space.php?user={R:1}\" />\r\n</rule>\r\n";
			$rules['nginx'] .= "rewrite ^/space/(.+)\\/$ /space.php?user=$1    last;\r\n";
		}
		if ( $seo_force_store == "rewrite" )
		{
			$rules['iis'] .= "RewriteRule ^(.*)/store-([0-9]+)/$ $1/store\\.php\\?uid=$2\r\nRewriteRule ^(.*)/store-([0-9]+)/([^\\/]+).html$ $1/store\\.php\\?uid=$2&Uid=$3\r\n";
			$rules['apache'] .= "RewriteRule ^(.*)store-([0-9]+)\\/$ $1/store\\.php\\?uid=$2\r\nRewriteRule ^(.*)store-([0-9]+)/([^\\/]+).html$ $1/store\\.php\\?uid=$2&Uid=$3\r\n";
			$rules['iis7'] .= "<rule name=\"store\">\r\n<match url=\"^store-([0-9]+)/$\" />\r\n<action type=\"Rewrite\" url=\"store.php?uid={R:1}\" />\r\n</rule>\r\n<rule name=\"store2\">\r\n<match url=\"^store-([0-9]+)/([^\\/]+).html$\" />\r\n<action type=\"Rewrite\" url=\"store.php?uid={R:1}&amp;Uid={R:2}\" />\r\n</rule>\r\n";
			$rules['nginx'] .= "rewrite ^/store-([0-9]+)\\/$ /store.php?uid=$1    last;\r\nrewrite ^/store-([0-9]+)\\/([^\\/]+).html$ /store.php?uid=$1&Uid=$2    last;\r\n";
		}
		if ( $seo_force_category == "rewrite" )
		{
			$rules['iis'] .= "RewriteRule ^(.*)/category-([^\\/]+)\\.html$ $1/category\\.php\\?CAtid=$2\r\n";
			$rules['apache'] .= "RewriteRule ^(.*)category-([^\\/]+)\\.html$ $1/category\\.php\\?CAtid=$2\r\n";
			$rules['iis7'] .= "<rule name=\"category\">\r\n<match url=\"^category-([^\\/]+).html$\" />\r\n<action type=\"Rewrite\" url=\"category.php?CAtid={R:1}\" />\r\n</rule>\r\n";
			$rules['nginx'] .= "rewrite ^/category-([^\\/]+)\\.html$ /category.php?CAtid=$1  last;\r\n";
		}
		else if ( $seo_force_category == "rewrite_py" )
		{
			$rules['iis'] .= "RewriteRule ^(.*)/(?!\\m\\b|".$admdir.")([^\\/]+)/$ $1/category\\.php\\?Catid=$2\r\n";
			$rules['apache'] .= "RewriteRule ^(.*)(?!\\m\\b|".$admdir.")([^\\/]+)/$ $1/category\\.php\\?Catid=$2\r\n";
			$rules['iis7'] .= "<rule name=\"category\">\r\n<match url=\"^(?!\\m\\b|".$admdir.")([^\\/]+)/$\" />\r\n<action type=\"Rewrite\" url=\"category.php?Catid={R:1}\" />\r\n</rule>\r\n";
			$rules['nginx'] .= "rewrite ^/(?!\\m\\b)([^\\/]+)/$ /category.php?Catid=$1  last;\r\n";
		}
		if ( $seo_force_info == "rewrite" )
		{
			$rules['iis'] .= "RewriteRule ^(.*)/information-id-([0-9]+)\\.html$ $1/information\\.php\\?id=$2\r\n";
			$rules['apache'] .= "RewriteRule ^(.*)information-id-([0-9]+)\\.html$ $1/information\\.php\\?id=$2\r\n";
			$rules['iis7'] .= "<rule name=\"information\">\r\n<match url=\"^information-id-([0-9]+).html$\" />\r\n<action type=\"Rewrite\" url=\"information.php?id={R:1}\" />\r\n</rule>\r\n";
			$rules['nginx'] .= "rewrite ^/information-id-([0-9]+)\\.html$ /information.php?id=$1  last;\r\n";
		}
		else if ( $seo_force_info == "rewrite_py" )
		{
			$rules['iis'] .= "RewriteRule ^(.*)/([^\\/]+)/([0-9]+)\\.html$ $1/information\\.php\\?id=$3\r\n";
			$rules['apache'] .= "RewriteRule ^(.*)([^\\/]+)/([0-9]+)\\.html$ $1/information\\.php\\?id=$3\r\n";
			$rules['iis7'] .= "<rule name=\"information\">\r\n<match url=\"^([^\\/]+)/([0-9]+).html$\" />\r\n<action type=\"Rewrite\" url=\"information.php?id={R:2}\" />\r\n</rule>\r\n";
			$rules['nginx'] .= "rewrite ^/([^\\/]+)/([0-9]+)\\.html$ /information.php?id=$2  last;\r\n";
		}
		if ( $seo_force_news == "rewrite" )
		{
			$rules['iis'] .= "RewriteRule ^(.*)/news\\.html$ $1/news\\.php\r\nRewriteRule ^(.*)/news-id-([0-9]+)\\.html$ $1/news\\.php\\?id=$2\r\nRewriteRule ^(.*)/news-catid-([0-9]+)\\.html$ $1/news\\.php\\?catid=$2\r\nRewriteRule ^(.*)/news-catid-([0-9]+)-page-([0-9]+)\\.html$ $1/news\\.php\\?catid=$2&page=$3\r\n";
			$rules['apache'] .= "RewriteRule ^news\\.html$ news\\.php\r\nRewriteRule ^news-id-([0-9]+)\\.html$ news\\.php\\?id=$1\r\nRewriteRule ^news-catid-([0-9]+)\\.html$ news\\.php\\?catid=$1\r\nRewriteRule ^news-catid-([0-9]+)-page-([0-9]+)\\.html$ news\\.php\\?catid=$1&page=$2\r\n";
			$rules['iis7'] .= "<rule name=\"news\">\r\n<match url=\"^news.html$\" />\r\n<action type=\"Rewrite\" url=\"news.php\" />\r\n</rule>\r\n<rule name=\"news2\">\r\n<match url=\"^news-id-([0-9]+).html$\" />\r\n<action type=\"Rewrite\" url=\"news.php?id={R:1}\" />\r\n</rule>\r\n<rule name=\"news3\">\r\n<match url=\"^news-catid-([0-9]+).html$\" />\r\n<action type=\"Rewrite\" url=\"news.php?catid={R:1}\" />\r\n</rule>\r\n<rule name=\"news4\">\r\n<match url=\"^news-catid-([0-9]+)-page-([0-9]+).html$\" />\r\n<action type=\"Rewrite\" url=\"news.php?catid={R:1}&amp;page={R:2}\" />\r\n</rule>\r\n";
			$rules['nginx'] .= "rewrite ^/news\\.html$ /news.php    last;\r\nrewrite ^/news-id-([0-9]+)\\.html$ /news.php?id=$1    last;\r\nrewrite ^/news-catid-([0-9]+)\\.html$ /news.php?catid=$1    last;\r\nrewrite ^/news-catid-([0-9]+)-page-([0-9]+)\\.html$ /news.php?catid=$1&page=$2    last;\r\n";
		}
		if ( $seo_force_yp == "rewrite" )
		{
			$rules['iis'] .= "RewriteRule ^(.*)/corporation\\.html$ $1/corporation\\.php\r\nRewriteRule ^(.*)/corporation-([^\\/]+)\\.html$ $1/corporation\\.php\\?Catid=$2\r\n";
			$rules['apache'] .= "RewriteRule ^(.*)corporation\\.html$ $1/corporation\\.php\r\nRewriteRule ^(.*)corporation-([^\\/]+)\\.html$ $1/corporation\\.php\\?Catid=$2\r\n";
			$rules['iis7'] .= "<rule name=\"corporation\">\r\n<match url=\"^corporation.html$\" />\r\n<action type=\"Rewrite\" url=\"corporation.php\" />\r\n</rule>\r\n<rule name=\"corporation2\">\r\n<match url=\"^corporation-([^\\/]+).html$\" />\r\n<action type=\"Rewrite\" url=\"corporation.php?Catid={R:1}\" />\r\n</rule>\r\n";
			$rules['nginx'] .= "rewrite ^/corporation\\.html$ /corporation.php    last;\r\nrewrite ^/corporation-([^\\/]+)\\.html$ /corporation.php?Catid=$1    last;\r\n";
		}
		if ( $seo_force_about == "rewrite" )
		{
			$rules['iis'] .= "RewriteRule ^(.*)/sitemap\\.html$ $1/about\\.php\\?part=sitemap\r\nRewriteRule ^(.*)/aboutus\\.html$ $1/about\\.php\\?part=aboutus\r\nRewriteRule ^(.*)/aboutus-id-([0-9]+)\\.html$ $1/about\\.php\\?part=aboutus&id=$2\r\nRewriteRule ^(.*)/announce\\.html$ $1/about\\.php\\?part=announce&id=$2\r\nRewriteRule ^(.*)/faq\\.html$ $1/about\\.php\\?part=faq\r\nRewriteRule ^(.*)/faq-id-([0-9]+)\\.html$ $1/about\\.php\\?part=faq&id=$2\r\nRewriteRule ^(.*)/friendlink\\.html$ $1/about\\.php\\?part=friendlink\r\n";
			$rules['apache'] .= "RewriteRule ^(.*)aboutus\\.html$ $1/about\\.php\\?part=aboutus\r\nRewriteRule ^(.*)sitemap\\.html$ $1/about\\.php\\?part=sitemap\r\nRewriteRule ^(.*)aboutus-id-([0-9]+)\\.html$ $1/about\\.php\\?part=aboutus&id=$2\r\nRewriteRule ^(.*)announce\\.html$ $1/about\\.php\\?part=announce&id=$2\r\nRewriteRule ^(.*)faq\\.html$ $1/about\\.php\\?part=faq\r\nRewriteRule ^(.*)faq-id-([0-9]+)\\.html$ $1/about\\.php\\?part=faq&id=$2\r\nRewriteRule ^(.*)friendlink\\.html$ $1/about\\.php\\?part=friendlink\r\n";
			$rules['iis7'] .= "<rule name=\"sitemap\">\r\n<match url=\"^sitemap.html$\" />\r\n<action type=\"Rewrite\" url=\"about.php?part=sitemap\" />\r\n</rule>\r\n<rule name=\"aboutus\">\r\n<match url=\"^aboutus.html$\" />\r\n<action type=\"Rewrite\" url=\"about.php?part=aboutus\" />\r\n</rule>\r\n<rule name=\"aboutusid\">\r\n<match url=\"^aboutus-id-([0-9]+).html$\" />\r\n<action type=\"Rewrite\" url=\"about.php?part=aboutus&amp;id={R:1}\" />\r\n</rule>\r\n<rule name=\"announce\">\r\n<match url=\"^announce.html$\" />\r\n<action type=\"Rewrite\" url=\"about.php?part=announce\" />\r\n</rule>\r\n<rule name=\"faq\">\r\n<match url=\"^faq.html$\" />\r\n<action type=\"Rewrite\" url=\"about.php?part=faq\" />\r\n</rule>\r\n<rule name=\"faqid\">\r\n<match url=\"^faq-id-([0-9]+).html$\" />\r\n<action type=\"Rewrite\" url=\"about.php?part=faq&amp;id={R:1}\" />\r\n</rule>\r\n<rule name=\"friendlink\">\r\n<match url=\"^friendlink.html$\" />\r\n<action type=\"Rewrite\" url=\"about.php?part=friendlink\" />\r\n</rule>\r\n";
			$rules['nginx'] .= "rewrite ^/sitemap\\.html$ /about.php?part=sitemap    last;\r\nrewrite ^/aboutus\\.html$ /about.php?part=aboutus    last;\r\nrewrite ^/aboutus-id-([0-9]+)\\.html$ /about.php?part=aboutus&id=$1    last;\r\nrewrite ^/announce\\.html$ /about.php?part=announce&id=$1    last;\r\nrewrite ^/faq\\.html$ /about.php?part=faq    last;\r\nrewrite ^/faq-id-([0-9]+)\\.html$ /about.php?part=faq&id=$1    last;\r\nrewrite ^/friendlink\\.html$ /about.php?part=friendlink    last;\r\n";
		}
		$rules['iis7'] .= "</rules>\r\n</rewrite>\r\n</system.webServer>\r\n</configuration>\r\n";
		if ( !createfile( MYMPS_ROOT."/rewrite/httpd.ini", $rules['iis'] ) )
		{
			$notice .= MYMPS_ROOT."/rewrite/httpd.ini 请设置为777属性或者写入修改权限<br><br>";
		}
		if ( !createfile( MYMPS_ROOT."/rewrite/.htaccess", $rules['apache'] ) )
		{
			$notice .= MYMPS_ROOT."/rewrite/.htaccess 请设置为777属性或者写入修改权限<br><br>";
		}
		if ( !createfile( MYMPS_ROOT."/rewrite/web.config", $rules['iis7'] ) )
		{
			$notice .= MYMPS_ROOT."/rewrite/web.config 请设置为777属性或者写入修改权限<br><br>";
		}
		if ( !createfile( MYMPS_ROOT."/rewrite/nginx.conf", $rules['nginx'] ) )
		{
			$notice .= MYMPS_ROOT."/rewrite/nginx.conf 请设置为777属性或者写入修改权限<br><br>";
		}
	}
	write_msg( ( $notice ? $notice : "" )."系统SEO设置更新成功！", "seoset.php", "WriteRecord" );
}
if ( is_object( $db ) )
{
	$db->Close();
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
