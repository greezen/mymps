<?php
define('IN_SMT',true);
define('CURSCRIPT','search');
define('IN_MYMPS', true);

require_once dirname(__FILE__).'/include/global.php';
require_once dirname(__FILE__)."/data/config.php";
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';

ifsiteopen();

$catid    = isset($catid) 	 ? intval($catid) 	 	 : '';
$cityid   = isset($cityid) 	 ? intval($cityid) 	 	 : '';
$areaid   = isset($areaid) 	 ? intval($areaid) 	 	 : '';
$posttime = isset($posttime) ? intval($posttime) 	 : '';
$tel	  = isset($tel)		 ? checkhtml($tel)	 : '';
$keywords = checkhtml($keywords);
$keywords = str_replace(array('/','?'),array(' ',' '),$keywords);
$keywords = isset($keywords) ? trim(preg_replace("/(\s+)/",' ',$keywords)) : '';
$mod = isset($mod)	 ? trim(($mod)) : '';

if($keywords == '请输入关键词或分类名') $keywords = $_GET['keywords'] = '';

!in_array($mod,array('information','store','news','group','coupon','goods')) && $mod = 'information';

$pluginsettings = read_static_cache('plugin');

$allowplugin = array();
if(is_array($pluginsettings)){
	foreach($pluginsettings as $k => $v){
		if($v['disable'] != 1){
			$allowplugin[$k]['flag'] = $v['flag'];
			$allowplugin[$k]['name'] = $v['name'];
		}
	}
}

$city = get_city_caches($cityid);
if(!is_array($city)){
	$city = array('cityname'=>'总站','cityid'=>'0','cityname'=>$mymps_global['SiteUrl']);
}

$sql = $search = $where = $cat_children = $allow_identifier = '';
switch($mod){
	case 'information':
		if($keywords != '' || $tel != ''){
			require MYMPS_DATA."/info_posttime.php";
			//$document_domain = str_replace('http://www.','',$mymps_global['SiteUrl']);
			$search['page_title'] = ($keywords != '' ? $keywords.' - ' : '').'信息搜索 - '.$mymps_global['SiteName'];
			
				if($catid){
					$modid = $db -> getOne("SELECT modid FROM `{$db_mymps}category` WHERE catid = '$catid'");
					$cat_children	  =	get_cat_children($catid);
					$allow_identifier = allow_identifier();
					$allow_identifier = $allow_identifier[$modid]['identifier'];
					$mymps_extra_model = mod_identifier();
					$extra_model = $mymps_extra_model[$modid];
					$sq = $s = '';
					if($modid > 1 && is_array($allow_identifier)){
						$s = "LEFT JOIN `{$db_mymps}information_{$modid}` AS g ON a.id = g.id";
						foreach ($$_request as $key => $val){
							if(in_array($key,$allow_identifier) && !empty($$key)){
								$where .= " AND g.`$key` = '$val' ";
							}
						}
					}
				}
				if(is_array($keyword = explode(' ',$keywords))){
					$or = '';
					$sqlkeywords = '';
					foreach($keyword as $k => $v){
						$sqlkeywords .= " $or a.title LIKE '%".$v."%' OR a.content LIKE '%".$v."%' OR c.catname LIKE '%".$v."%'";
						$or = 'OR';
					}
					$where .= " AND ($sqlkeywords)";
				}
				$where .= $cityid != ''  ? " AND a.cityid = '$cityid'" : "";
				$where .= $areaid != ''  ? " AND a.areaid = '$areaid'" : "";
				$where .= $streetid != ''  ? " AND a.streetid = '$streetid'" : "";
				$where .= $tel != ''  ? " AND a.tel LIKE '%".$tel."%'" : "";
				$where .= $catid != ''  ? " AND a.catid IN (".$cat_children.")" : "";
				$where .= $posttime != '' ? "AND a.begintime >= (".$timestamp."-".$posttime."*3600*24)" : "";
				$where .= "AND (a.info_level = '1' OR a.info_level = '2')";
				
				$search['rows_num'] = $rows_num = $db -> getOne("SELECT COUNT(a.id) FROM `{$db_mymps}information` AS a LEFT JOIN `{$db_mymps}category` AS c ON a.catid = c.catid {$s} WHERE 1 {$where}");
				
				$param = $catid != '' && is_array($allow_identifier) ? setParam(array_merge(array('part','keywords','catid','cityid','streetid','areaid','posttime','tel'),$allow_identifier)) : setParam(array('mod','keywords','catid','cityid','streetid','areaid','posttime','tel'));
	
				$searchresult = page1("SELECT a.id,a.cityid,a.begintime,a.title,a.content,a.ismember,a.contact_who,a.begintime,a.catid,c.catname,a.dir_typename FROM `{$db_mymps}information` AS a LEFT JOIN `{$db_mymps}category` AS c ON a.catid = c.catid {$s} WHERE 1 {$where} ORDER BY a.id DESC");
				$ids = '';
				foreach($searchresult as $k => $val){
					$result['id']			= $val['id'];
					$result['uri'] 			= Rewrite('info',array('id'=>$val['id'],'cityid'=>$val['cityid'],'dir_typename'=>$val['dir_typename']));
					$result['begintime']	= $val['begintime'];
					$result['title']		= HighLight($val['title'],$keywords);
					$result['content']		= HighLight(substring(clear_html($val['content']),0,180),$keywords);
					$result['poster']		= $val['ismember'] == 1 ? '<a target="black" href='.Rewrite('space',array("userid"=>$val["userid"])).$val["userid"].'</a>' : $val['contact_who'] ? $val['contact_who'] : '游客';
					$result['catname']		= HighLight($val['catname'],$keywords);
					$result['caturi']		= Rewrite('category',array('catid'=>$val['catid'],'dir_typename'=>$val['dir_typename']));
					$search['result'][$val['id']] = $result;
					$ids .= $val['id'].',';
				}
				if($idin = substr($ids,0,-1)){
					$idin =	$idin = $idin ? " AND a.id IN (".$idin.") " : "";
				}
				
				$search['pagination'] = page2();
				if($search['result'] && $catid && $idin && is_array($allow_identifier)){
					$des = get_info_option_array();
					$extra = $db ->getAll("SELECT a.* FROM `{$db_mymps}information_{$modid}` AS a WHERE 1 {$idin}"); 
					foreach($extra as $k => $v){
						unset($v['iid']);
						unset($v['content']);
						foreach($v as $u => $w){
							$g = get_info_option_titval($des[$u],$w);
							if($u != 'id' && !is_numeric($u)){
								$search['result'][$v[id]]['extra'][$u] = $g['value'];
							}
						}
					}
				}
	
			$posttime_select = GetInfoPostTime($posttime);
			$catoption = get_categories_tree(0,'category');
			$select_where_option = select_where_option('/include/selectwhere.php',$cityid,$areaid,$streetid);
		}
	break;
	case 'store':
		if($keywords != ''){
			$document_domain = str_replace('http://www.','',$mymps_global['SiteUrl']);
			$search['page_title'] = ($keywords != '' ? $keywords.' - ' : '').'商家搜索 - '.$mymps_global['SiteName'];
			if($keywords != ''){
				if(is_array($keyword = explode(' ',$keywords))){
					$or = '';
					$sqlkeywords = '';
					foreach($keyword as $k => $v){
						$sqlkeywords .= " $or a.tname LIKE '%".$v."%' OR a.introduce LIKE '%".$v."%' OR a.userid LIKE '%".$v."%'";
						$or = 'OR';
					}
					$where .= " AND ($sqlkeywords)";
				}
				$where 	.= !empty($catid) 	? " AND b.catid IN(".get_corp_children($catid).") "  : "";
				$where 	.= !empty($cityid) 	? " AND a.cityid = '$cityid' "	: "";
				$where 	.= !empty($areaid) 	? " AND a.areaid = '$areaid' "	: "";
				$where 	.= !empty($streetid) 	? " AND a.areaid = '$streetid' "	: "";
				$where 	.= " AND a.levelid > '1' AND a.if_corp = '1'";
				$sql = empty($catid) ? "SELECT a.* FROM `{$db_mymps}member` AS a WHERE 1 {$where} ORDER BY a.jointime DESC" : "SELECT a.* FROM `{$db_mymps}member` AS a LEFT JOIN `{$db_mymps}member_category` AS b ON a.userid = b.userid WHERE 1 {$where} ORDER BY a.jointime DESC";
				$count_sql	= empty($catid) ? "SELECT COUNT(a.id) FROM `{$db_mymps}member` AS a WHERE 1 {$where}" : "SELECT COUNT(b.id) FROM `{$db_mymps}member` AS a LEFT JOIN {$db_mymps}member_category AS b ON a.userid = b.userid WHERE 1 $where";
				$search['rows_num']	=	$rows_num 	= $db -> getOne($count_sql);
				$param = setParam(array('mod','catid','cityid','streetid','areaid','keywords'));
				if(is_array($res = page1($sql))){
					foreach($res as $key => $val){
						$arr['userid']		= $val['userid'];
						$arr['tel']			= $val['tel'] ? $val['tel'] : '尚未填写电话信息';
						$arr['address']		= $val['address'] ? $val['address'] : '尚未填写地址信息';
						$arr['tname']		= $val['tname'] ? $val['tname'] : $val['userid'];
						$arr['prelogo']		= $val['prelogo'] ? $val['prelogo'] : '/images/nophoto.jpg';
						$arr['tname']		= HighLight($val['tname'] ? $val['tname'] : $val['userid'],$keyword ? $keyword : $keywords);
						$arr['uri'] 		= Rewrite('store',array('uid'=>$val['id']));
						$arr['uri_aboutus'] = Rewrite('store',array('uid'=>$val['id'],'part'=>'about'));
						$arr['uri_comment'] = Rewrite('store',array('uid'=>$val['id'],'part'=>'comment'));
						$arr['uri_album'] 	= Rewrite('store',array('uid'=>$val['id'],'part'=>'album'));
						$search['result'][]	= $arr;
					}
				}
				$search['pagination']	= page2();
			}
			
			$catoption = get_corp_tree(0,'corp');
			$select_where_option = select_where_option('/include/selectwhere.php',$cityid,$areaid,$streetid);
		}
	break;
	
	case 'news':
		if($keywords != ''){
			!ifplugin('news') && exit('管理员已禁用或未安装新闻插件...');
		
			$catoption = cat_list('channel',0,0,false,1);
			$area_list = get_cityoptions($cityid);
			
			if($keywords != ''){
				if(is_array($keyword = explode(' ',$keywords))){
					$or = '';
					$sqlkeywords = '';
					foreach($keyword as $k => $v){
						$sqlkeywords .= " $or n.title LIKE '%".$v."%' OR n.content LIKE '%".$v."%'";
						$or = 'OR';
					}
					$where .= " AND ($sqlkeywords)";
				}
				$where .= !empty($catid)  ? " AND n.catid IN (".get_cat_children($catid,'channel').")" : "";
				//$where .= " AND n.cityid = '$cityid'";
				
				$sql = "SELECT n.*,c.catname,c.html_dir FROM `{$db_mymps}news` AS n LEFT JOIN `{$db_mymps}channel` AS c ON n.catid = c.catid WHERE 1 $where";
				$search['rows_num'] = $rows_num = $db -> getOne("SELECT COUNT(n.id) FROM `{$db_mymps}news` AS n WHERE 1 $where");
				$param = setParam(array('mod','cityid','catid','keywords'));
				$searchresult = page1($sql);
				foreach($searchresult as $k => $val){
					$result['id']			= $val['id'];
					$result['hit']			= $val['hit'];
					$result['uri'] 			= Rewrite('news',array('id'=>$val['id'],'html_path'=>$val['html_path']));
					$result['begintime']	= $val['begintime'];
					$result['title']		= HighLight($val['title'],$keyword ? $keyword : $keywords);
					$result['content']		= HighLight(substring(clear_html($val['content']),0,300),$keyword ? $keyword : $keywords);
					$result['catname']		= $val['catname'];
					$result['caturi']		= Rewrite('news',array('catid'=>$val['catid'],'html_dir'=>$val['html_dir']));
					$search['result'][] 	= $result;
				}
				$search['pagination'] = page2();
			}
			$search['page_title'] = ($keywords != '' ? $keywords.' - ' : '').'网站新闻搜索 - '.$mymps_global['SiteName'];
		}
	break;
	
	case 'group':
		if($keywords != ''){
			require_once MYMPS_ROOT.'/plugin/group/include/functions.php';
			
			$group_class = get_group_class();
			$catoption = $group_class;
			$area_list = get_cityoptions($cityid);
			
			require_once MYMPS_DATA.'/grouplevel.inc.php';
			
			if($keywords != ''){
			
				$where = "WHERE glevel > '0'";
				
				if(is_array($keyword = explode(' ',$keywords))){
					$or = '';
					$sqlkeywords = '';
					foreach($keyword as $k => $v){
						$sqlkeywords .= " $or gname LIKE '%".$v."%'";
						$or = 'OR';
					}
					$where .= " AND ($sqlkeywords)";
				}		
			
				if($cate_id) $where .= " AND cate_id = '$cate_id'";
				if($cityid) $where .= " AND areaid = '$cityid'";
				
				$search['rows_num']	= $rows_num = $db -> getOne("SELECT COUNT(groupid) FROM `{$db_mymps}group` $where");
				$param = setParam(array('mod','cate_id','cityid','keywords'));
				$group = page1("SELECT * FROM `{$db_mymps}group` $where ORDER BY displayorder DESC");
				foreach($group as $k => $v){
					$result['groupid'] = $v['groupid'];
					$result['gname'] = $v['gname'];
					$result['des'] = clear_html($v['des']);
					$result['enddate'] = $v['enddate'];
					$result['meetdate'] = $v['meetdate'];
					$result['gaddress'] = $v['gaddress'];
					$result['glevel'] = $v['glevel'];
					$result['signintotal'] = $v['signintotal'];
					$result['commenturl'] = $v['commenturl'];
					$result['pre_picture'] = $v['pre_picture'];
					$result['uri'] = plugin_url('group',array('id'=>$v['groupid']));
					$search['result'][] 	= $result;
				}
				$search['pagination'] = page2();
			}
				
			$search['page_title'] = ($keywords != '' ? $keywords.' - ' : '').'团购活动搜索 - '.$mymps_global['SiteName'];
		}
	break;
	
	case 'coupon':
		if($keywords != ''){
			require_once MYMPS_ROOT.'/plugin/coupon/include/functions.php';
			
			$coupon_class = get_coupon_class();
			$catoption = $coupon_class;
			$area_list = get_cityoptions($cityid);
			
			if($keywords != ''){
					
				$where = "WHERE status = '1' AND grade > '0'";
				
				if(is_array($keyword = explode(' ',$keywords))){
					$or = '';
					$sqlkeywords = '';
					foreach($keyword as $k => $v){
						$sqlkeywords .= " $or title LIKE '%".$v."%'";
						$or = 'OR';
					}
					$where .= " AND ($sqlkeywords)";
				}		
			
				if($cate_id) $where .= " AND cate_id = '$cate_id'";
				if($cityid) $where .= " AND cityid = '$cityid'";
				
				$search['rows_num']	= $rows_num = $db->getOne("SELECT count(id) FROM {$db_mymps}coupon $where");
				$param = setParam(array('mod','cate_id','cityid'));
				$coupon = page1("SELECT * FROM `{$db_mymps}coupon` $where ORDER BY begindate DESC");
				foreach($coupon as $k => $v){
					$result['id'] = $v['id'];
					$result['title'] = $v['title'];
					$result['des'] = $v['des'];
					$result['enddate'] = $v['enddate'];
					$result['begindate'] = $v['begindate'];
					$result['prints'] = $v['prints'];
					$result['pre_picture'] = $v['pre_picture'];
					$result['sup'] = $v['sup'];
					$result['uri'] = plugin_url('coupon',array('id'=>$v['id']));
					$search['result'][] 	= $result;
				}
				$search['pagination'] = page2();
			}
			
			$search['page_title'] = ($keywords != '' ? $keywords.' - ' : '').'优惠券搜索 - '.$mymps_global['SiteName'];
		}
	break;
	
	case 'goods':
		if($keywords != ''){
			require_once MYMPS_ROOT.'/plugin/goods/include/functions.php';
			
			$goods_class = goods_category_tree(0);
			$catoption = $goods_class;
			$area_list = get_cityoptions($cityid);
			
			if($keywords != ''){
					
				$where = "WHERE onsale = '1'";
				
				if(is_array($keyword = explode(' ',$keywords))){
					$or = '';
					$sqlkeywords = '';
					foreach($keyword as $k => $v){
						$sqlkeywords .= " $or goodsname LIKE '%".$v."%'";
						$or = 'OR';
					}
					$where .= " AND ($sqlkeywords)";
				}		
			
				if($catid) $where .= " AND catid IN (".mymps_get_goods_children($catid).")";
				if($cityid) $where .= " AND cityid = '$cityid'";
				
				$search['rows_num'] = $rows_num = $db -> getOne("SELECT COUNT(goodsid) FROM `{$db_mymps}goods` $where");
				$param = setParam(array('mod','cate_id','cityid'));
				$goods = page1("SELECT * FROM `{$db_mymps}goods` $where ORDER BY dateline DESC",16);
				foreach($goods as $k => $v){
					$result['goodsid'] = $v['goodsid'];
					$result['goodsname'] = $v['goodsname'];
					$result['nowprice'] = $v['nowprice'];
					$result['pre_picture'] = $v['pre_picture'] ? $v['pre_picture'] : $mymps_global['SiteUrl'].'/images/nophoto.gif';
					$result['uri'] = plugin_url('goods',array('id'=>$v['goodsid']));
					$search['result'][] = $result;
				}
				$search['pagination'] = page2();
			}
			
			$search['page_title'] = ($keywords != '' ? $keywords.' - ' : '').'商品搜索 - '.$mymps_global['SiteName'];
		}
	break;
}

$mtime = explode(' ', microtime());
$totaltime = number_format(($mtime[1] + $mtime[0] - $mymps_starttime), 6);
$sitedebug = 'Processed in '.$totaltime.' second(s) , '.$db->query_num.' queries';
$search['keywords'] = $keywords;
$search['tel'] = $tel;

include ($keywords || $tel) ? mymps_tpl(CURSCRIPT.'_'.$mod) : mymps_tpl('search_index');
is_object($db) && $db -> Close();
$city = $maincity = NULL;
unset($city,$maincity);
?>