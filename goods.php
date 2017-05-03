<?php
define('IN_SMT',true);
define('CURSCRIPT','goods');
define('IN_MYMPS',TRUE);
define('DIR_NAV',dirname(__FILE__));

require_once DIR_NAV.'/include/global.php';
require_once MYMPS_DATA."/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";

ifsiteopen();

$id 		= isset($id) 		? intval($id) 		: '';
$catid 		= isset($catid) 	? intval($catid) 	: 0;
$cityid 	= isset($cityid) 	? intval($cityid) 	: 0;
$page	 	= isset($page)	   	? intval($page)	  	: 1;

!ifplugin(CURSCRIPT) && exit('管理员已禁用或未安装商品插件...');

if(!submit_check(CURSCRIPT.'_submit')){
	require_once DIR_NAV.'/plugin/goods/include/functions.php';
	
	if($id){

		$goods  = $db -> getRow("SELECT a.*,b.tname FROM `{$db_mymps}goods` AS a LEFT JOIN `{$db_mymps}member` AS b  ON a.userid = b.userid WHERE goodsid = '$id' AND onsale = '1'");
		$goods['tname'] = $goods['tname'] ? $goods['tname'] : $goods['userid'];
		$uid = $db -> getOne("SELECT id FROM `{$db_mymps}member` WHERE userid = '$goods[userid]'");
		$goods['tname_uri'] = Rewrite('store',array('uid'=>$uid,'action'=>'index'));
		if(!$goods['goodsid']) write_msg('该商品不存在或者已下架！','olmsg');
		$city = get_city_caches($goods['cityid'] ? $goods['cityid'] : $cityid);
		
		$db->query("UPDATE `{$db_mymps}goods` SET hit = hit + 1 WHERE goodsid = '$id'");
		
		$goods['picture'] = $goods['picture'] ? $goods['picture'] : $mymps_global['SiteUrl'].'/images/nophoto.gif';
		/*商品介绍内链处理*/
		$goods['content'] = replace_insidelink($goods['content'],'goods');
		
		$loc = mymps_get_goods_location($goods['catid'],$goods['goodsname']);
		$page_title = $loc['page_title'];
		$page_title = str_replace('{city}',$city['cityname'],$page_title);
		$location	= $loc['location'];

		$goods['quhuo'] = textarea_post_change($pluginsettings['goods']['quhuo']);
		$goods['fukuan'] = textarea_post_change($pluginsettings['goods']['fukuan']);
		$goods['service'] = textarea_post_change($pluginsettings['goods']['service']);
		unset($pluginsettings);
		
		$advertisement	= get_advertisement('other');
		$adveritems		= $city['advertisement'];
		$advertisement	= $advertisement['all'];
		
		$relategoods = mymps_get_goods(6,1,'',$goods['catid'],'','',$city['cityid']);
		globalassign();
		include mymps_tpl('view');
	
	}else{
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
		/*自动补充总站数据end*/
		
		$where = " WHERE onsale = '1'";
		$where .= $city[cityid] ? " AND cityid = '$city[cityid]'" : "";
		
		if($catid){
			$catid = intval($catid);
			$cat = $db -> getRow("SELECT * FROM `{$db_mymps}goods_category` WHERE catid = '$catid'");
			if(!$cat){
				$where = NULL;
				write_msg('该商品分类不存在或者已删除！','olmsg');
				exit;
			}
			$goods_children = mymps_get_goods_children($catid);
			$where .= " AND catid IN (".$goods_children.")";
		}
		$remai_goods = mymps_get_goods(5,1,'remai','','','',$city['cityid']);
		$tuijian_goods = mymps_get_goods(3,1,'tuijian','','','',$city['cityid']);

		$loc = mymps_get_goods_location($cat['catid']);
		$page_title = $loc['page_title'];
		$page_title = str_replace('{city}',$city['cityname'],$page_title);
		$location	= $loc['location'];
		$seo		= array();
		$seo['keywords'] 	= str_replace('{city}',$city['cityname'],$pluginsettings[CURSCRIPT]['seokeywords']);
		$seo['description'] = str_replace('{city}',$city['cityname'],$pluginsettings[CURSCRIPT]['seodescription']);
		
		$goods_cat = goods_category_tree(0);
		
		$advertisement	= get_advertisement('other');
		$adveritems		= $city['advertisement'];
		$advertisement	= $advertisement['all'];
		
		$where .= $tuijian == '1' ? " AND tuijian = '1'" : '';
		$where .= $cuxiao == '1' ? " AND cuxiao = '1'" : '';
		$orderby = in_array($orderby,array('dateline','hit')) ? $orderby : 'dateline';
		$rows_num = $db -> getOne("SELECT COUNT(goodsid) FROM `{$db_mymps}goods` $where");
		$param = setParam(array('catid','orderby','tuijian','cuxiao'));
		$goods = page1("SELECT * FROM `{$db_mymps}goods` $where ORDER BY ".$orderby." DESC",16);
		foreach($goods as $k => $v){
			$list[$v['goodsid']]['goodsid'] = $v['goodsid'];
			$list[$v['goodsid']]['goodsname'] = $v['goodsname'];
			$list[$v['goodsid']]['nowprice'] = $v['nowprice'];
			$list[$v['goodsid']]['pre_picture'] = $v['pre_picture'] ? $v['pre_picture'] : '/images/nophoto.gif';
			$list[$v['goodsid']]['picture'] = $v['picture'] ? $v['picture'] : '/images/nophoto.gif';
			$list[$v['goodsid']]['uri'] = plugin_url('goods',array('id'=>$v['goodsid']));
		}
		$page_view = page2();
		
		$uri = array();
		$uri['tuijian'] = plugin_url('goods',array('catid'=>$cat['catid'],'tuijian'=>'1','orderby'=>'dateline'));
		$uri['cuxiao']	= plugin_url('goods',array('catid'=>$cat['catid'],'cuxiao'=>'1','orderby'=>'dateline'));
		$uri['hit']     = plugin_url('goods',array('catid'=>$cat['catid'],'orderby'=>'hit'));
		$uri['dateline']= plugin_url('goods',array('catid'=>$cat['catid']));
		
		globalassign();
		include mymps_tpl('index');
		
	}
}else{

	$oname = $oname ? mhtmlspecialchars($oname) : '';
	$goodsid = isset($goodsid) ? intval($goodsid) : '';
	$ordernum = isset($ordernum) ? intval($ordernum) : '';
	$qq = isset($qq) ? mhtmlspecialchars($qq) : '';
	$tel =  isset($tel) ? mhtmlspecialchars($tel) : '';
	$mobile =  isset($mobile) ? mhtmlspecialchars($mobile) : '';
	$ip = GetIP();
	$msg = isset($msg) ? textarea_post_change($msg) : '';
	$address = isset($address) ? mhtmlspecialchars($address) : '';
	
	$_COOKIE['goodsorder'.$goodsid] == 1 && write_msg('该商品您已经下过订单了，看看别的商品吧...','olmsg');
	if(empty($goodsid)) write_msg('您要购买的商品不存在或已下架！');
	if(empty($oname)) write_msg('您的姓名不能为空！');
	
	$db -> query("INSERT INTO `{$db_mymps}goods_order` (goodsid,ordernum,oname,qq,tel,mobile,ip,address,msg,dateline) VALUES ('$goodsid','$ordernum','$oname','$qq','$tel','$mobile','$ip','$address','$msg','$timestamp')");
	
	setcookie('goodsorder'.$goodsid,1,$timestamp+180,'/');
	write_msg('您的订单已提交成功，我们会尽快与您取得联系！<br /><br /><input value="关闭窗口" type="button" onclick=\'parent.closeopendiv()\' style="margin-left:auto;margin-right:auto;" class="blue">','olmsg');

}
is_object($db) && $db->Close();
$city = $maincity = NULL;
unset($city,$maincity);

function mymps_get_goods_location($catid=0,$str=''){
	global $db,$db_mymps,$pluginsettings,$city;
	
	$cat_arr = goods_parent_cats($catid);
	$raquo = $GLOBALS['mymps_global']['cfg_raquo'];
	$location   = '当前位置：<a href="'.$GLOBALS['mymps_global']['SiteUrl'].'">'.$city['cityname'].$GLOBALS['mymps_global']['SiteName'].'</a>'.' <code>'.$raquo.'</code> '.' <a href="'.plugin_url(CURSCRIPT,array('catid'=>0)).'">'.$city[cityname].'商品网购</a>';
	$page_title = $pluginsettings['goods']['seotitle'] ? $pluginsettings['goods']['seotitle'] : $city['cityname'].'商品网购 - '.$GLOBALS['mymps_global']['SiteName'];
	
	if(!empty($catid)){
		/* 循环分类 */
		if (!empty($cat_arr)){
			krsort($cat_arr);
			foreach ($cat_arr as $val){
				$page_title =  htmlspecialchars($GLOBALS['cat']['title'] && $GLOBALS['catid'] == $val['catid'] ? $GLOBALS['cat']['title'] :($type == 'corp' ? $val['corpname'] : $val['catname'])) . ' - ' . $page_title;
				$location   .= ' <code> '.$raquo.' </code> <a href="' . $val['uri'] . '">' .
								htmlspecialchars($type == 'corp' ? $val['corpname'] : $val['catname']) . '</a>';
			}
		}
	}
	
	if (!empty($str)){
        $page_title = $str.' - '.$page_title;
        $location   .= ' <code>'.$raquo.'</code> &nbsp;' .$str;
    }
	
	$cur = array('page_title'=>$page_title,'location'=>$location);
	unset($page_title,$cat,$location,$type,$goods_class);
    return $cur;
}
?>