<?php
define('IN_SMT',true);
define('CURSCRIPT','coupon');
define('IN_MYMPS',TRUE);
define('DIR_NAV',dirname(__FILE__));

require_once DIR_NAV.'/include/global.php';
require_once MYMPS_DATA."/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";

ifsiteopen();

$cate_id = isset($cate_id) ? intval($cate_id) : '';
$areaid  = isset($areaid)  ? intval($areaid)  : '';
$cityid  = isset($cityid)  ? intval($cityid)  : 0;
$id  	 = isset($id)  	   ? intval($id)	  : '';
$orderby = isset($orderby) ? trim($orderby)	  : '';
$data 	 = $pluginsettings	=	'';
$action  = isset($action)  ? trim($action)	  : '';

if(!in_array($orderby,array('prints','dateline','hit'))) $orderby = 'hit';

$city = get_city_caches($cityid);
/*自动补充总站数据start*/
if($mymps_global['cfg_independency'] && $cityid){
	$maincity = get_city_caches(0);
	$independency = explode(',',$mymps_global['cfg_independency']);
	$independency = is_array($independency) ? $independency : array();
	if(in_array('advertisement',$independency)){
		$city['advertisement'] = empty($city['advertisement']) ? $maincity['advertisement'] : $city['advertisement'];
	}
	$maincity = NULL;
}

!ifplugin(CURSCRIPT) && exit('管理员已禁用或未安装优惠券插件...');

require_once DIR_NAV.'/plugin/coupon/include/functions.php';

$couponclass  = $coupon_class = get_coupon_class();
$coupon_class = is_array($coupon_class) ? array_merge(
							array(
								  0=>array(
										   'cate_id'=>0,
										   'cate_name'=>'全部',
										   'cate_uri'=>plugin_url(CURSCRIPT,array('cate_id'=>0))
										   )
								  )
							,$coupon_class
							) : array();

if($city['cityid']){
	$area_class = $city['area'];
	if(is_array($area_class)){
		//$area_class	= array_merge(array('0'=>array('areaid'=>'','areaname'=>'全部')),$area_class);
		if(is_array($area_class)){
			foreach($area_class as $areakey => $areaval){
				$area_class[$areakey]['uri'] = plugin_url(CURSCRIPT,array('cate_id'=>$cate_id,'areaid'=>$areaval['areaid']));
				$area_class[$areakey]['select'] = $areaval['areaid'] == $areaid ? '1' : 0;
			}
		}
	}
}

$advertisement	= get_advertisement('other');
$adveritems		= $city['advertisement'];
$advertisement	= $advertisement['all'];

$where .= $city[cityid] ? " AND cityid = '$city[cityid]'" : "";

$counts = $db -> getAll("SELECT cate_id,count(id) AS num FROM {$db_mymps}coupon AS i WHERE status = '1' AND grade > '0' {$where} GROUP BY cate_id ");
$count = array();
$count['total'] = $db->getOne("SELECT count(id) FROM {$db_mymps}coupon WHERE status = '1' AND grade > '0' {$where}");
foreach($counts as $k=>$v){
	$count[$v['cate_id']] = !empty($v['num']) ? $v['num'] : 0 ;
}

if($id) {
	
	$coupon  = $db -> getRow("SELECT * FROM `{$db_mymps}coupon` WHERE id = '$id' AND status = '1' AND grade > '0'");
	if(!$coupon['id']) write_msg('该优惠券已失效或者尚未通过审核！','olmsg');
	
	if($action == 'print'){
		
		$db -> query("UPDATE `{$db_mymps}coupon` SET prints = prints + 1 WHERE id = '$id'");
		
		globalassign();
		include mymps_tpl('print');
	
	} else {

		$db -> query("UPDATE `{$db_mymps}coupon` SET hit = hit + 1 WHERE id = '$id'");
		
		$coupon['content'] = replace_insidelink($coupon['content'],'coupon');
		
		$space = $db -> getRow("SELECT tname,address,busway,tel FROM `{$db_mymps}member` WHERE userid = '$coupon[userid]'");
		$uid = $db -> getOne("SELECT id FROM `{$db_mymps}member` WHERE userid = '$coupon[userid]'");
		$space['uri'] = Rewrite('store',array('uid'=>$uid,'action'=>'index'));
		$space['tname'] = $space['tname'] ? $space['tname'] : $space['userid'];
		$space['address'] = $space['address'] ?  $space['address'] : $space['busway'];
		
		$loc = get_coupon_location($coupon['cate_id'],$coupon['title']);
		$page_title = $loc['page_title'];
		$location	= $loc['location'];
		
		globalassign();
		include mymps_tpl('view');
		
	}
	
} else {
	
	$where = "WHERE status = '1' AND grade > '0'";
	if($cate_id) $where .= " AND cate_id = '$cate_id'";
	if($cityid) $where .= " AND cityid = '$cityid'";
	if($areaid) $where .= " AND areaid = '$areaid'";
	if($streetid) $where .= " AND streetid = '$streetid'";
	
	$rows_num = $db->getOne("SELECT count(id) FROM {$db_mymps}coupon $where");
	$param = setParam(array('cateid','areaid','orderby'));
	$coupon = page1("SELECT * FROM `{$db_mymps}coupon` $where ORDER BY $orderby DESC");
	$list = array();
	foreach($coupon as $k => $v){
		$list[$v['id']]['id'] = $v['id'];
		$list[$v['id']]['title'] = $v['title'];
		$list[$v['id']]['des'] = $v['des'];
		$list[$v['id']]['enddate'] = $v['enddate'];
		$list[$v['id']]['begindate'] = $v['begindate'];
		$list[$v['id']]['prints'] = $v['prints'];
		$list[$v['id']]['pre_picture'] = $v['pre_picture'];
		$list[$v['id']]['sup'] = $v['sup'];
		$list[$v['id']]['uri'] = plugin_url('coupon',array('id'=>$v['id']));
	}
	
	foreach(array('hit'=>'默认','prints'=>'打印','dateline'=>'最新') as $k => $v){
		$orderby_url[$k]['selected'] = $orderby == $k ? 1 : 0;
		$orderby_url[$k]['name'] = $v;
		$orderby_url[$k]['url'] = plugin_url(CURSCRIPT,array('cate_id'=>$cate_id,'areaid'=>$areaid,'orderby'=>$k));
	}

	$page_view = page2();
	
	$loc = get_coupon_location($cate_id);
	$page_title = (empty($cate_id) && empty($areaid)) ? ($pluginsettings[CURSCRIPT]['seotitle'] ? $pluginsettings[CURSCRIPT]['seotitle'] : $loc['page_title']) : $loc['page_title'];
	$page_title = str_replace('{city}',$city['cityname'],$page_title);
	$location	= $loc['location'];
	
	$seo = array();
	$seo['keywords'] 	= str_replace('{city}',$city['cityname'],$pluginsettings[CURSCRIPT]['seokeywords']);
	$seo['description'] = str_replace('{city}',$city['cityname'],$pluginsettings[CURSCRIPT]['seodescription']);
	
	$currentlocate = $areaname.$couponclass[$cate_id]['cate_name'].'优惠券';
	
	globalassign();
	include mymps_tpl('index');
}

is_object($db) && $db->Close();

function get_coupon_location($cate_id=0,$str=''){
	global $db,$db_mymps,$couponclass,$areaid,$areaname,$mymps_global,$city;
	
	$raquo = $mymps_global['cfg_raquo'];
	$location   = '当前位置：<a href="'.$mymps_global['SiteUrl'].'">'.$city['cityname'].$GLOBALS['mymps_global']['SiteName'].'</a>'.' <code>'.$raquo.'</code> '.' <a href="'.plugin_url(CURSCRIPT,array('cate_id'=>0)).'">'.$city[cityname].'优惠券</a>';
	$page_title = $city['cityname'].'优惠券 - '.$mymps_global['SiteName'];
	
	if(!empty($cate_id)){
		$page_title =  htmlspecialchars($couponclass[$cate_id]['cate_name']) . ' - ' . $page_title;
		$location   .= ' <code> '.$raquo.' </code> <a href="' . $couponclass[$cate_id]['cate_uri'] . '">' .
		htmlspecialchars($couponclass[$cate_id]['cate_name']).'</a>';
	}
	
	$areaname = $mymps_global['SiteCity'].($areaid ? get_areaname($areaid) : '');
	$page_title = $areaname.$page_title;
	
	if (!empty($str)){
        $page_title = $str.' - '.$page_title;
        $location   .= ' <code>'.$raquo.'</code> &nbsp;' .$str;
    }
	
	$cur = array('page_title'=>$page_title,'location'=>$location);
	unset($page_title,$cat,$location,$type,$couponclass);
    return $cur;
}
?>