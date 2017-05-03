<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
require_once MYMPS_INC."/cache.fun.php";
require_once MYMPS_INC."/member.class.php";
$infoid = $_REQUEST['infoid'] ? intval($_REQUEST['infoid']) : '';
!$infoid && write_msg('收藏的信息主题ID不能为空!','olmsg');
$log = $member_log -> chk_in();

switch($log){
	case true:
	
	$msg = '
		<!DOCTYPE html>
		<html lang="zh-CN" class="index_page">
		<head>
			<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width" />
			<meta name="format-detection" content="telephone=no" />
			<meta name="format-detection" content="email=no" />
			<meta name="format-detection" content="address=no;">
			<meta name="apple-mobile-web-app-capable" content="yes" />
			<meta name="apple-mobile-web-app-status-bar-style" content="default" />
			<title>系统提示 - <?=$mymps_global[SiteName]?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>">
		</head>
		<body>
	';
	if($db->getOne("SELECT COUNT(id) FROM `{$db_mymps}shoucang` WHERE infoid = '$infoid' AND userid = '$s_uid'") > 0){
		$msg .= '<style>div{line-height:28px; font-size:12px; text-align:left; float:left; margin-bottom:30px; color:#585858;} span{margin-left:5px; margin-right:15px; display:block; float:left; height:64px; width:64px; background:url('.$mymps_global[SiteUrl].'/template/default/images/post/info_icons.png) 0 -128px no-repeat; margin-bottom:10px;}</style><span></span><div>您已经收藏过该信息，不能重复收藏！<br />查看 <a href=\''.$mymps_global[SiteUrl].'/m/index.php?mod=shoucang\' style=\'font-size:14px;\'>我的收藏>></a></div>';
	} else {
		$r		= $db -> getRow("SELECT title,id,cityid,dir_typename FROM `{$db_mymps}information` WHERE id = '$infoid'");
		$url	= Rewrite('info',array('id'=>$infoid,'cityid'=>$r['cityid'],'dir_typename'=>$r['dir_typename']));
		$url	= str_replace($mymps_global['SiteUrl'],'',$url);
		if(!$s_uid) exit('无效的登录用户，请重新登录！');
		$db->query("INSERT INTO `{$db_mymps}shoucang` (infoid,title,url,userid,intime)VALUES('$infoid','$r[title]','$url','$s_uid','$timestamp')");
		$msg .= '<style>div{line-height:28px; font-size:12px; text-align:left; float:left; margin-bottom:30px; color:#585858;} span{margin-left:5px; margin-right:15px; display:block; float:left; height:64px; width:64px; background:url('.$mymps_global[SiteUrl].'/template/default/images/post/info_icons.png) 0 0 no-repeat; margin-bottom:10px;}</style><span></span><div>信息收藏成功，登陆会员中心查看！<br />查看 <a href=\''.$mymps_global[SiteUrl].'/m/index.php?mod=shoucang\'style=\'font-size:14px;\'>我的收藏>></a>';
	}
	$msg .= '
		</body>
		</html>
	';
	
	echo $msg;
	$msg = $r = NULL;
	
	break;
	
	default:
	
		$mobile_settings = get_mobile_settings();
		$url = $mymps_global[SiteUrl]."/m/index.php?mod=member";  
		echo "<script language = 'javascript' type = 'text/javascript'>window.location.href = '$url' </script>"; 
		 
	break;
}

?>