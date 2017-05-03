<?php
if(!defined('IN_MYMPS')) exit('Forbidden');
$ac = in_array($ac,array('list','detail','order')) ? $ac : 'list';
$id = isset($id) ? intval($id) : '';
$goodsid = $_REQUEST['goodsid'] ? intval($_REQUEST['goodsid']) : '';

if(submit_check('goods_submit')){
	
	$cityid = isset($_REQUEST['cityid']) ? intval($_REQUEST['cityid']) : '';
	if(is_array($selectedids)){
		$create_in = create_in($selectedids);
		$query = $db -> query("SELECT * FROM `{$db_mymps}goods` $where AND goodsid ".$create_in);
		while($row = $db -> fetchRow($query)){
			$delete[$row['id']]['picture'] = $row['picture'];
			$delete[$row['id']]['pre_picture'] = $row['pre_picture'];
		}
		foreach($delete as $k => $v){
			@unlink(MYMPS_ROOT.$v['picture']);
			@unlink(MYMPS_ROOT.$v['pre_picture']);
		}
		$db -> query("DELETE FROM `{$db_mymps}goods` {$where} AND goodsid ".$create_in);
		unset($delete,$row,$query,$create_in);
		write_msg('','?m=goods&success=3&status='.$status.'&page='.$page);
	}
	
	include MYMPS_DATA.'/config.inc.php';
	$name_file = 'goods_image';
	$goodsname = trim(mhtmlspecialchars($_POST['goodsname']));
	$content = trim($_POST['content']);
	$catid = intval($_POST['catid']);
	$oicq = trim(mhtmlspecialchars($_POST['oicq']));
	$oldprice = trim(mhtmlspecialchars($_POST['oldprice']));
	$nowprice = trim(mhtmlspecialchars($_POST['nowprice']));
	$oicq = trim(mhtmlspecialchars($_POST['oicq']));
	$tuihuan = intval($_POST['tuihuan']);
	$baozhang = intval($_POST['baozhang']);
	$jiayi = intval($_POST['jiayi']);
	$weixiu = intval($_POST['weixiu']);
	$fahuo = intval($_POST['fahuo']);
	$cuxiao = intval($_POST['cuxiao']);
	$gift = mhtmlspecialchars($_POST['gift']);
	$goodsbh = date('Ymd').random(3);
	$huoyuan = intval($_POST['huoyuan']);
	
	$picture = isset($_POST['picture_old']) ? mhtmlspecialchars($_POST['picture_old']) : '';
	$pre_picture = isset($_POST['pre_picture_old']) ? mhtmlspecialchars($_POST['pre_picture_old']) : '';
	
	if(empty($goodsname)) write_msg('','?m=goods&ac=detail&error=42&id='.$id);
	if(empty($content)) write_msg('','?m=goods&ac=detail&error=43&id='.$id);
	if(empty($catid)) write_msg('','?m=goods&ac=detail&error=44&id='.$id);
	if(empty($cityid)) write_msg('','?m=goods&ac=detail&error=40&id='.$id);
	
	if($_FILES[$name_file]['name']){
		require_once MYMPS_INC.'/upfile.fun.php';
		$destination = "/goods/".date('Ym')."/";
		$mymps_image = empty($id) ? start_upload($name_file,$destination,0,$mymps_mymps['cfg_goods_limit']['width'],$mymps_mymps['cfg_goods_limit']['height']) : start_upload($name_file,$destination,0,$mymps_mymps['cfg_goods_limit']['width'],$mymps_mymps['cfg_goods_limit']['height'],$picture,$pre_picture);
		$picture	 = $mymps_image[0];
		$pre_picture = $mymps_image[1];
		unset($mymps_image,$_FILES);
	}
	
	if(empty($id)){
		$db -> query("INSERT INTO `{$db_mymps}goods` (goodsname,goodsbh,cityid,catid,oicq,oldprice,nowprice,content,pre_picture,picture,userid,dateline,tuihuan,jiayi,weixiu,fahuo,cuxiao,baozhang,huoyuan,gift) VALUES ('$goodsname','$goodsbh','$cityid','$catid','$oicq','$oldprice','$nowprice','$content','$pre_picture','$picture','$s_uid','$timestamp','$tuihuan','$jiayi','$weixiu','$fahuo','$cuxiao','$baozhang','$huoyuan','$gift')");
		$id = $db->insert_id();
		/*积分变化*/
		$score_change = get_credit_score();
		$score_changer = $score_change['score']['rank']['goods'];
		$db->query("UPDATE `{$db_mymps}member` SET score = score".$score_changer." WHERE userid = '$s_uid'");
		$score_change = $score_changer = NULL;
		$url = '?m=goods&success=8&ac=detail&id='.$id.'&alert=4';
	} else {
		$db -> query("UPDATE `{$db_mymps}goods` SET cityid='$cityid',goodsname = '$goodsname',catid = '$catid',oicq='$oicq',oldprice = '$oldprice',nowprice = '$nowprice',content = '$content',pre_picture='$pre_picture',picture='$picture',dateline='$timestamp',tuihuan = '$tuihuan',jiayi = '$jiayi',weixiu='$weixiu',fahuo='$fahuo',cuxiao='$cuxiao',baozhang='$baozhang',huoyuan = '$huoyuan',gift='$gift' $where AND goodsid = '$id'");
	}
	
	write_msg('',$url?$url:'?m=goods&success=8&ac=detail&id='.$id);
	
	
} elseif (submit_check('goods_order_submit')){

	empty($selectids) && write_msg('','?m=goods&ac=order&error=1&page='.$page);
	$db -> query("DELETE FROM `{$db_mymps}goods_order` {$where} AND id ".create_in($selectedids));
	unset($selectedids);
	write_msg('','?m=goods&success=3&ac=order&page='.$page);
	
} else {
	
	@include_once MYMPS_DATA.'/moneytype.inc.php';
	
	if($ac == 'list') {
	
		$rows_num = mymps_count("goods",$where);
		$param	  = setParam(array('m','ac'));
		$goods    = page1("SELECT * FROM `{$db_mymps}goods` $where ORDER BY dateline DESC");
	
	} elseif ($ac == 'detail') {
		
		@require_once MYMPS_ROOT."/plugin/goods/include/functions.php";
		
		if($id) $edit = $db -> getRow("SELECT * FROM `{$db_mymps}goods` WHERE goodsid = '$id'");
		$acontent = get_editor('content','Member',$edit['content'],'90%','400px');
		
	} elseif ($ac == 'order') {
		
		//require_once MYMPS_DATA.'/goods_order_status.inc.php';
		
		if(empty($id)) {
			//订单列表
			
			$param = setParam('m','ac','id');
			$rows_num = $db -> getOne("SELECT COUNT(a.id) FROM `{$db_mymps}goods_order` AS a LEFT JOIN `{$db_mymps}goods` AS b ON a.goodsid = b.goodsid WHERE b.userid = '$s_uid'");
			$order = page1("SELECT a.*,b.goodsname FROM `{$db_mymps}goods_order` AS a LEFT JOIN `{$db_mymps}goods` AS b ON a.goodsid = b.goodsid  WHERE b.userid = '$s_uid' ORDER BY dateline DESC");
			
			
		} else {
			//订单详细
			$order = $db -> getRow("SELECT a.*,b.goodsname FROM `{$db_mymps}goods_order` AS a LEFT JOIN `{$db_mymps}goods` AS b ON a.goodsid = b.goodsid WHERE b.userid = '$s_uid' AND a.id = '$id'");
			$ac = $ac.'_view';
			
		}
		
	}
	
	$location = location('corp');
	include mymps_tpl('goods_'.$ac);
	unset($glevel);
}
?>