<?php
define('IN_SMT',true);
define ('CURSCRIPT','information');
define('IN_MYMPS', true);

require_once dirname(__FILE__)."/include/global.php";
$id	= isset($id) ? intval($id) 	: 0;

require_once dirname(__FILE__)."/data/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";

ifsiteopen();
runcron();

$cache = get_cache_config();
require_once MYMPS_INC.'/cachepages.class.php';
$cachepages = new cachepages($cache['info']['time'],'info_'.$id);
$cachetime = $cache['info']['time'];
$cachepages->cacheCheck();
unset($cache);

$seo	 		= $seo ? $seo : get_seoset();
$rewrite	 	= $seo['seo_force_info'];

if(!$info = $db->getRow("SELECT a.*,b.areaname,c.streetname FROM `{$db_mymps}information` AS a LEFT JOIN  `{$db_mymps}area` AS b ON a.areaid = b.areaid LEFT JOIN `{$db_mymps}street` AS c ON a.streetid = c.streetid WHERE a.id = '$id' AND a.info_level > 0")) write_msg('该信息不存在，或者未通过审核！','olmsg');

if($cat_cache = read_static_cache('category_option_static')){
	$info['parentid']		= $cat_cache[$info['catid']]['parentid'];
	$info['template_info']	= $cat_cache[$info['catid']]['template_info'];
	$info['usecoin']		= $cat_cache[$info['catid']]['usecoin'];
	$info['catname']		= $cat_cache[$info['catid']]['catname'];
	$info['dir_typename']	= $cat_cache[$info['catid']]['dir_typename'];
	$info['modid']			= $cat_cache[$info['catid']]['modid'];
	$info['caturi']			= $rewrite == 'rewrite_py' ?  $info['dir_typename'].'/' : Rewrite('category',array('catid'=>$info['catid'],'dir_typename'=>$info['dir_typename']));
	$cat_cache = NULL;
} else {
	$getrow = $db -> getRow("SELECT parentid,template_info,usecoin,catname,dir_typename,modid FROM `{$db_mymps}category` WHERE catid = '$info[catid]'");
	$info['parentid'] 		= $getrow['parentid'];
	$info['template_info'] 	= $getrow['template_info'];
	$info['usecoin'] 		= $getrow['usecoin'];
	$info['catname'] 		= $getrow['catname'];
	$info['modid'] 			= $getrow['modid'];
	$info['dir_typename'] 	= $getrow['dir_typename'];
	$info['caturi']			= $rewrite == 'rewrite_py' ?  $info['dir_typename'].'/' : Rewrite('category',array('catid'=>$info['catid'],'dir_typename'=>$info['dir_typename']));
	$getrow = NULL;
}

$city = get_city_caches($cityid ? $cityid : $info['cityid']);
if(!$cityid) write_msg('',Rewrite('info',array('id'=>$info['id'],'catid'=>$info['catid'],'domain'=>$city['domain'])));

if($mymps_global['cfg_independency'] && $cityid){
	$maincity = get_city_caches(0);
	$independency = explode(',',$mymps_global['cfg_independency']);
	$independency = is_array($independency) ? $independency : array();
	if(in_array('advertisement',$independency)){
		$city['advertisement'] = empty($city['advertisement']) ? $maincity['advertisement'] : $city['advertisement'];
	}
	$maincity = NULL;
}

$info['description'] = mhtmlspecialchars(clear_html($info['content']));
$info['areaname']	 = get_areaname($info['areaid']);
$info['zhiding']	 = ($info['upgrade_type'] > 1 || $info['upgrade_type_index'] > 1) ? 1 : 0;
$info['endtime']	 = get_info_life_time($info['endtime']);
$info['contactview'] = ($info['endtime'] == '<font color=red>已过期</font>' && $mymps_global['cfg_info_if_gq'] != 1) ? 0 : 1;
$info['posthistory'] = $mymps_global['SiteUrl'].'/posthistory.php?tel='.base64_encode($info['tel']);

$info['content'] = replace_insidelink($info['content'],'information');

if($info['ismember']==1 && $info['userid']){
	$member = get_member_info($info['userid']);
	$member['if_corp'] = $mymps_global['cfg_if_corp'] != 1 ? 0 : $member['if_corp'];
	$group  = get_member_group('',$info['userid']);
	if($member['userid'] && $group['member_contact'] == 0 && $info['ismember'] == '1'){
		$info['tel'] 		 = $mymps_global['SiteTel'];
		$info['qq'] 		 = $mymps_global['SiteQQ'];
		$info['email'] 		 = $mymps_global['SiteEmail'];
	}
	$info['userid'] = '<a target=_blank href="'.Rewrite('space',array('user'=>$info['userid'])).'">'.($member['tname'] ? $member['tname'] : $info['userid']).'</a>';
} elseif($info['userid']) {
	$info['userid'] = '<a href="'.Rewrite('space',array('user'=>$info['userid'])).'" target=_blank>'.$info[userid].'</a>';
} else{
	$info['userid'] = '';
}

if(function_exists("gd_info") && $mymps_global['cfg_info_if_img'] == 1){
	$info['email'] 		= $info['email']?	"<img src=\"".$mymps_global['SiteUrl']."/".$mymps_global['cfg_authcodefile']."?part=contact&wid=200&strings=".base64_encode($info['email'])."\">":$info['email'];
	$info['telephone'] 	= $info['tel']	?	"<img src=\"".$mymps_global['SiteUrl']."/".$mymps_global['cfg_authcodefile']."?part=contact&wid=130&strings=".base64_encode($info['tel'])."\">":$info['tel'];
	$info['qq'] 		= $info['qq']	?	"<img src=\"".$mymps_global['SiteUrl']."/".$mymps_global['cfg_authcodefile']."?part=contact&wid=120&strings=".base64_encode($info['qq'])."\">":$info['qq'];
} else {
	$info['telephone'] 	= $info['tel'];
}

$info['ip'] = $info['ip'] != '' ? part_ip($info['ip']) : '';

if($info['modid'] > 1){
	$extr = $db ->getRow("SELECT * FROM `{$db_mymps}information_{$info[modid]}` WHERE id ='$id'");

	if(is_array($extr)){
		$des = get_info_option_array();
		unset($extr['iid'],$extr['id'],$extr['content']);
		foreach($extr as $k =>$v){
			$val = get_info_option_titval($des[$k],$v);
			$arr['title'] = $val['title'];
			$arr['value'] = $val['value'];
			$info['extra'][]=$arr;
			$info[$k] = $val['value'];
		}
		$des = NULL;
	}
}

$info['image'] = $info['img_path'] != '' ? $db -> getAll("SELECT prepath,path FROM `{$db_mymps}info_img` WHERE infoid = '$id' ORDER BY id DESC") : false;

$advertisement	= get_advertisement('info');
$adveritems		= $city['advertisement'];
$advertisement['type']	= $advertisement['all'] ? (is_array($advertisement[$info['catid']]['type']) ? array_merge($advertisement['all']['type'],$advertisement[$info['catid']]['type']) : $advertisement['all']['type']): $advertisement[$info['catid']]['type'];

$pdetail = ($info['img_path'] != '' ? '【图】':'').$info['title'].' - '.$city['cityname'].$info['areaname'].$info['streetname'].$info['catname'].' - '.$mymps_global['SiteName'];
$loc 		= get_location('category',$info['catid'],'','',$pdetail);
$location 	= $loc['location'];
$page_title = $loc['page_title'];

$cat = array();
$cat['catid'] = $info['catid'];
$cat['parentid'] = $info['parentid'];
if($cat['parentid'] > 0){
	$flag = array_reverse(get_parent_cats('category',$cat['parentid']));
	$cat['parentid'] = $flag[0]['catid'];
}
$navurl_head = $city['topnav'];
$info['img_path'] = $info['img_path'] ? $info['img_path'] : '/images/nopic.gif';
$relate_cat = get_categories_tree($info['parentid']);
$latest_info = mymps_get_infos(10,'','','',$info['catid']);
$hotcities = get_hot_cities();

globalassign();
include mymps_tpl($info['template_info']?$info['template_info']:'info');
is_object($db) && $db->Close();
$cachetime && $cachepages->caching();

$city = $maincity = $advertisement = NULL;
unset($city,$maincity,$advertisement);
?>