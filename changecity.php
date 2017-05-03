<?php
define('IN_SMT',true);
define('CURSCRIPT','changecity');
define('IN_MYMPS', true);

require_once dirname(__FILE__).'/include/global.php';
require_once MYMPS_DATA.'/config.php';
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';
ifsiteopen();

if($cityname){
	$cityname = strip_tags(trim($cityname));
	if($city = $db -> getRow("SELECT domain,directory FROM `{$db_mymps}city` WHERE cityname = '$cityname'")){
		write_msg('',$city['domain'] ? $city['domain'] : $mymps_global['SiteUrl'].'/'.$mymps_global['cfg_citiesdir'].'/'.$city['directory']);
	} else {
		write_msg('目前尚未开通该分站，请选择其它分站浏览');
	}
	exit;
}

$cache = get_cache_config();
require_once MYMPS_INC.'/cachepages.class.php';
$cachepages = new cachepages($cache['changecity']['time'],'changecity');
$cachetime = $cache['changecity']['time'];
$cachepages->cacheCheck();
unset($cache);

if(in_array($mymps_global['cfg_redirectpage'],array('home','nchome'))) {
	$fromcity = array('domain'=>$mymps_global['SiteUrl'],'cityname'=>'总');
}else{
	$ip = GetIP();
	$fromcity = get_ip2city($ip);
}
$total = $db -> getOne("SELECT COUNT(cityid) FROM `{$db_mymps}city`");
$cities = $mymps_global['cfg_cityshowtype'] == 'province' ? get_changeprovince_cities() : get_changecity_cities();
$hotcities = get_hot_cities();
globalassign();
include mymps_tpl(CURSCRIPT);

$cachetime && $cachepages->caching();
?>