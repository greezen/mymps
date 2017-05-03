<?php
!defined('IN_MYMPS') && die('FORBIDDEN');

$member_menu = array();
$member_menu['user']['info']		= '分类信息';
$member_menu['user']['pay']			= '充值金币';
if($if_corp == 1){
	$member_menu['corp']['avatar']	= '店铺头像';
}else{
	$member_menu['user']['avatar']	= '个人头像';
}
$member_menu['user']['base']		= '基本资料';
$member_menu['user']['shoucang']	= '我的收藏';
$member_menu['user']['certify']		= '实名认证';
$member_menu['user']['pm']			= '短消息';
if($if_corp == 1){
	$member_menu['corp']['levelup']	= '店铺升级';
}else{
	$member_menu['user']['levelup']	= '帐号升级';
}
$member_menu['user']['password']	= '密码';

/*corp menu*/
if($mymps_global['cfg_if_corp'] == 1){
	$member_menu['corp']['shop']		= '店铺资料';
	$member_menu['corp']['comment']		= '店铺点评';
	$member_menu['corp']['album']		= '店铺相册';
	$member_menu['corp']['document']	= '店铺文章';
	/*plugin menu*/
	@include MYMPS_DATA.'/caches/pluginmenu_member.php';
	if(is_array($data)){
		foreach($data as $key => $val){
			$key != 'news' && $member_menu['corp'][$key]  = $val;
		}
	}
}

function mymps_member_purview($purview='')
{
	global $member_menu;
	$member_menu['corp']['banner']		= '上传商铺banner';
    foreach($member_menu as $k => $v){
		$mymps_member_purview .="<tr bgcolor=\"#f5fbff\"><td>".($k=='user'?'个人会员菜单':'商家会员菜单')."</td><td>";
		foreach($member_menu[$k] as $w => $y){
			$mymps_member_purview .= "<label for=\"purview_".$w."\" style=\"width:110px\"><input type=\"checkbox\" class=\"checkbox\" name=\"purview[]\" id=\"purview_".$w."\" value=\"purview_".$w."\"";
			$mymps_member_purview .= ((is_array($purview)&&in_array('purview_'.$w,$purview))||empty($purview))? "checked":"";
			$mymps_member_purview .= ">".$y."</label> ";
		}
		$mymps_member_purview .="</td></tr>";
	}
	return $mymps_member_purview;
}

function cur_purviews($purview = ''){
	global $member_menu;
    foreach($member_menu as $k => $v){
		$mymps_member_purview .="<tr><td align=\"center\" width=\"10%\">".($k=='user'?'个人会员菜单':'商家会员菜单')."</td><td>";
		foreach($member_menu[$k] as $w => $y){
			$mymps_member_purview .= "<label for=\"purview_".$w."\" style=\"width:110px\"><input type=\"checkbox\" class=\"checkbox\" name=\"purview[]\" id=\"purview_".$w."\" value=\"purview_".$w."\"";
			$mymps_member_purview .= ((is_array($purview)&&in_array('purview_'.$w,$purview))||empty($purview))? "checked":"";
			$mymps_member_purview .= ">".$y."</label> ";
		}
		$mymps_member_purview .="</td></tr>";
	}
	return $mymps_member_purview;
}
?>