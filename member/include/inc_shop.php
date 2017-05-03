<?php
if(!defined('IN_MYMPS')) exit('Forbidden');

require_once MYMPS_INC.'/class.fun.php';

if(submit_check('shop_submit')){

	$tname = isset($_POST['tname']) ? trim(mhtmlspecialchars($_POST['tname'])) : '';
	$introduce = trim($_POST['introduce']);
	$introduce = maddslashes($introduce);
	$catid = $_POST['catid'];
	$cityid = isset($_POST['cityid']) ? intval($_POST['cityid']) : '';
	$areaid = isset($_POST['areaid']) ? intval($_POST['areaid']) : '';
	$streetid = isset($_POST['streetid']) ? intval($_POST['streetid']) : '';
	$msn = trim(mhtmlspecialchars($_POST['msn']));
	$mappoint = trim(mhtmlspecialchars($_POST['mappoint']));
	$address = trim(mhtmlspecialchars($_POST['address']));
	$busway = trim(mhtmlspecialchars($_POST['busway']));
	$busway = textarea_post_change($busway);
	$template = trim(mhtmlspecialchars($_POST['template']));
	$web = trim(mhtmlspecialchars($_POST['web']));
	$banner = isset($_POST['banner']) ? mhtmlspecialchars($_POST['banner']) : '';
	$oldbanner = isset($_POST['oldbanner']) ? mhtmlspecialchars($_POST['oldbanner']) : '';
	$name_file = 'banner';
	$tel = trim(mhtmlspecialchars($_POST['tel']));
	$ac = $ac ? $ac : 'base';
	
	if(is_array($catid) && $if_corp == 1){
		mymps_delete("member_category","WHERE userid = '$s_uid'");
		foreach($catid as $kids => $vids){
			$db->query("INSERT `{$db_mymps}member_category` (userid,catid)VALUES('$s_uid','$vids')");
		}
		$catids = implode(',',$catid);
	}
	
	if($if_corp == 1){
		//保存店铺资料
		if($ac == 'base'){
			if(empty($tname)) write_msg('','?m=shop&error=39');
			//if(empty($areaid)) write_msg('','?m=shop&error=40');
			$db -> query("UPDATE `{$db_mymps}member` SET tname='$tname',catid='$catids',cityid='$cityid',areaid='$areaid',streetid='$streetid',introduce='$introduce',tel='$tel',address='$address',busway='$busway',mappoint='$mappoint',msn='$msn',web='$web' $where AND if_corp = '1'");
			write_msg('','?m=shop&success=13');
		} elseif($ac == 'template') {
			if($_FILES[$name_file]['name']){
				require_once MYMPS_INC.'/upfile.fun.php';
				$destination = "/banner/".date('Ym')."/";
				$mymps_image = start_upload($name_file,$destination,0,'','',$oldbanner,'');
				$picture	 = $mymps_image;
				unset($mymps_image,$_FILES);
			} else {
				$picture = $oldbanner ? $oldbanner : '';
			}
			$db->query("UPDATE `{$db_mymps}member` SET template='$template',banner='$picture' $where AND if_corp = '1'");
			write_msg('','?m=shop&success=8&ac=template');
		}
	} else {
		//申请开通网上店铺
		if(empty($tname)) write_msg('','?m=shop&error=39');
		if(empty($areaid)) write_msg('','?m=shop&error=40');
		if(empty($address)) write_msg('','?m=shop&error=45');
		if(empty($introduce)) write_msg('','?m=shop&error=46');
		
		$db -> query("UPDATE `{$db_mymps}member` SET tname='$tname',levelid='1',catid='$catids',areaid='$areaid',introduce='$introduce',address='$address',tel='$tel',busway='$busway',mappoint='$mappoint',msn='$msn',template='$template',template='$template',web='$web',if_corp='1' $where");
		write_msg('','?m=shop&success=14');
	}
	
} else {

	$ac = $ac ? trim($ac) : 'base';
	if($ac == 'base'){
		$r = $db -> getRow("SELECT citypy,mappoint FROM `{$db_mymps}city` WHERE cityid = '$cityid'");
		$row['citypy'] = $r['citypy'];
		$mappoint = $row['mappoint'] ? $row['mappoint'] : $r['mappoint'];
		$acontent 	= get_editor('introduce','Member',$row['introduce'],'100%','300px');
		$get_member_cat = get_member_cat(explode(',',$row['catid']));
		$row['busway'] = de_textarea_post_change($row['busway']);
		$city = $row['cityid'] ? get_city_caches($row['cityid']) : '';
		if(is_array($city)){
			$cityname = $city['directory'];
			unset($city);
		}
		$location = location('corp');
		include mymps_tpl('shop');
	} else {
		chk_member_purview('purview_banner');
		require_once MYMPS_DATA.'/config.inc.php';
		$location = location('corp');
		include mymps_tpl('shop_template');
	}
	
}
?>