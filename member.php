<?php
define('CURSCRIPT','login');
define('IN_SMT',true);
define('IN_MYMPS', true);
define('IN_MANAGE',true);

require_once dirname(__FILE__)."/include/global.php";
require_once dirname(__FILE__)."/data/config.php";
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";

ifsiteopen();
if($mymps_global['cfg_if_member_log_in'] != 1) write_msg("操作失败！系统管理员关闭了会员功能！");

@include MYMPS_DATA.'/caches/authcodesettings.php';
$authcodesettings = $data;
$data = NULL;
require_once MYMPS_MEMBER.'/include/common.func.php';

if(!in_array($mod,array(CURSCRIPT,'register','forgetpass','out','openlogin','validate'))){
	$mod = $_REQUEST['mod'] = CURSCRIPT;
}
require_once MYMPS_DATA."/config.inc.php";
require_once MYMPS_INC."/member.class.php";

$url   = isset($url) ? checkhtml($url) : '';
$action = isset($action) ? $action : '';
$action = ($mymps_global['cfg_if_corp'] != 1 && $action == 'store') ? 'person' : $action;
$cityid = isset($cityid) ? intval($cityid) : '';

if(!submit_check('log_submit')){

	if($mod != 'out' && $mod != 'openlogin'){
		$member_log -> chk_in() && write_msg('','member/index.php');
	}
	
	switch($mod){
		case 'validate':
			if($code){
				$arr = explode('.',base64_decode($code));
				$uid = $arr[0];
				$user_info = $db -> getRow("SELECT id,userid,userpwd,email FROM `{$db_mymps}member` WHERE id = '$uid'");
				
				if(($timestamp - $arr[2] < 1800) && $arr[1] == md5($user_info['id'].'+'.$user_info['userpwd'])){
					$db->query("UPDATE `{$db_mymps}member` SET `status` = 1 WHERE id = '$user_info[id]'");
					$userid = $user_info['userid'];
					$uid = $user_info['id'];
					$email = $user_info['email'];
					$error = 4;
					globalassign();
					include mymps_tpl('register_2');
				} else {
					$error = 5;
					globalassign();
					include mymps_tpl('register_2');
				}
			}
		break;
		case 'out':
			if(PASSPORT_TYPE == 'ucenter'){
				$member_log -> out('noredirect');
				require MYMPS_ROOT.'/uc_client/client.php';
				$ucsynlogout = uc_user_synlogout();
				echo $ucsynlogout;
				echo mymps_goto($url ? $url : $mymps_global['SiteUrl'].'/'.$mymps_global['cfg_member_logfile']);
			} elseif(PASSPORT_TYPE == 'phpwind'){
				$member_log -> out('noredirect');
				require MYMPS_ROOT.'/pw_client/uc_client.php';
				$ucsynlogout = uc_user_synlogout();
				echo $ucsynlogout;
				echo mymps_goto($url ? $url : $mymps_global['SiteUrl'].'/'.$mymps_global['cfg_member_logfile']);
			} else {
				$member_log -> out(trim($url));
			}
		break;
		
		case 'login':
			$data = NULL;
			@require MYMPS_DATA.'/caches/qqlogin.php';
			$mymps_global['ifqqlogin'] = $data['open'];
			$data = NULL;
			
			$url = trim($url);
			$city = get_city_caches($cityid);
			$loc 		= get_location('login',0,'会员登录');
			$page_title = $loc['page_title'];
			$location 	= $loc['location'];
			$mymps_imgcode = $authcodesettings['login'];
			globalassign();
			include mymps_tpl(CURSCRIPT);
			
		break;
		
		case 'register':

			$mymps_global['cfg_if_member_register'] != 1 && write_msg("操作失败！系统管理员关闭了新会员注册！");
			
			@require MYMPS_DATA.'/caches/qqlogin.php';
			$mymps_global['ifqqlogin'] = $data['open'];
			$data = NULL;
			
			$city = get_city_caches($cityid);
			$loc 		= get_location('register',0,'会员注册');
			$page_title = $loc['page_title'];
			$location	= $loc['location'];
			
			if(in_array($action,array('store','person'))){
				require MYMPS_DATA.'/safequestions.php';
				$safequestion = GetSafequestion(0,'safequestion');
				$mymps_imgcode = $authcodesettings['register'];
				$submit = '立即注册';
				if($action == 'store') $get_area_options = select_where_option('/include/selectwhere.php',$city['cityid'],$areaid,$streetid);
				if($action == 'store') $get_member_cat = get_member_cat();
				$mixcode = md5($cookiepre);
				
				$whenregister = '';
				$whenregister = $db -> getOne("SELECT value FROM `{$db_mymps}config` WHERE description = 'whenregister' AND type = 'checkanswe'");
				if($whenregister == '1' && $checkanswer = read_static_cache('checkanswer')){
					$checkquestion['id']		= $randid = array_rand($checkanswer,1);
					$checkquestion['question']  = $checkanswer[$randid]['question'];
					$checkquestion['answer']	= $checkanswer[$randid]['answer'];
				}
				include mymps_tpl($mod.'_'.$action);
			}else{
				include mymps_tpl($mod);
			}
		break;
		
		case 'forgetpass':
			$uid = $uid ? intval($uid) : '';
			$code = $code ? mhtmlspecialchars($code) : '';
			$city = get_city_caches($cityid);
			if($code){
				$arr = explode('.',base64_decode($code));
				$uid = $arr[0];
				$user_info = $db -> getRow("SELECT id,userid,userpwd,email FROM `{$db_mymps}member` WHERE id = '$uid'");
				
				if(($timestamp - $arr[2] < 1800) && $arr[1] == md5($user_info['id'].'+'.$user_info['userpwd'])){
					$userid = $user_info['userid'];
					$uid = $user_info['id'];
					$email = $user_info['email'];
					globalassign();
					include mymps_tpl($mod.'_3');
				} else {
					$status = 'error';
					$msg = '该密码重设链接已失效！';
					globalassign();
					include mymps_tpl(mymps_tpl($mod.'_4'));
				}
			} else {
				$mymps_imgcode = $authcodesettings['forgetpass'];
				globalassign();
				include mymps_tpl($mod);
			}
			
		break;
		
		case 'openlogin':
			!in_array($action,array('bind','reg')) && $action = 'reg';
			session_start();
			
			if(empty($_SESSION['nickname']) || empty($_SESSION['openid'])) write_msg('session会话失效，请重新登陆！',$mymps_global[SiteUrl].'/include/qqlogin/qq_login.php');
			$nickname = $_SESSION['nickname'];
			
			$loc 		= get_location('login',0,'会员登录');
			$page_title = $loc['page_title'];
			$location 	= $loc['location'];
			$figureurl_qq_1 = $_SESSION['figureurl_qq_1'];
			$mixcode = md5($cookiepre);
			
			globalassign();
			include mymps_tpl('openlogin');
		break;
	}
}else{

	if($mod == 'openlogin'){
		define('QQLOGIN',1);//开启应用QQ登录接口
		!in_array($action,array('bind','reg')) && write_msg('您请求的来路不正确!','olmsg');
		session_start();
		$openid = mhtmlspecialchars($_SESSION['openid']);
		$cname  = mhtmlspecialchars($_SESSION['nickname']);
		
		if($action == 'bind'){
			if(empty($cname) || empty($openid)) write_msg('登录状态已超时，请重新登陆！',$mymps_global[SiteUrl].'/include/qqlogin/qq_login.php');
			$userid  = mhtmlspecialchars(trim($bind_userid));
			$userpwd = mhtmlspecialchars(trim($bind_userpwd));

			if(!$mixcode || $mixcode != md5($cookiepre)){
				die('您请求的来路不正确');
				exit();
			}
			if(empty($bind_userid) || empty($bind_userpwd)){
				write_msg('原用户名和原密码输入不能为空!');
			}
		
			if(!$db -> getOne("SELECT id  FROM `{$db_mymps}member` WHERE userid = '$userid' AND userpwd = '".md5($userpwd)."'")){
				write_msg('原帐号或密码输入不正确，请返回重新输入!');
			}
			$db -> query("DELETE FROM `{$db_mymps}member` WHERE openid = '$openid'");
			$db -> query("UPDATE `{$db_mymps}member` SET openid = '$openid' WHERE userid = '$userid'");

			$bind_userid = $bind_userpwd = $qqlogin = NULL;
			
			if(PASSPORT_TYPE == 'phpwind'){
				require MYMPS_ROOT.'/pw_client/uc_client.php';
				$user_login = uc_user_login($userid,md5($userpwd),0);
				echo $user_login['synlogin'];
			} elseif(PASSPORT_TYPE == 'ucenter'){
				require MYMPS_ROOT.'/uc_client/client.php';
				list($uid, $username, $password, $email) = uc_user_login($userid, $userpwd);
				echo uc_user_synlogin($uid);
			}
			
			$member_log -> in($userid,md5($userpwd),'off','noredirect');
			
			/*
			@session_unregister('openid');
			@session_unregister('nickname');
			@session_unregister('access_token');
			@session_unregister('appid');
			*/
			session_unset();
			echo mymps_goto($mymps_global['SiteUrl'].'/member/index.php');
			
		} elseif($action == 'reg'){
			$userid  = mhtmlspecialchars(trim($userid));
			$userpwd = mhtmlspecialchars(trim($userpwd));
			$email 	 = mhtmlspecialchars(trim($email));
			
			if(!$userid){
				write_msg('请填写您的登录用户名!');
				exit;
			}
			
			if(!$userpwd){
				write_msg('请填写您的登录密码!');
				exit;
			}
			
			if(!$email){
				write_msg('请填写您的电子邮箱帐号!');
				exit;
			}
			
			$reg_corp = 0;
			
			if(PASSPORT_TYPE == 'phpwind'){
				
				require MYMPS_ROOT.'/pw_client/uc_client.php';
				$checkuser = uc_check_username($userid);
				if($checkuser == -2){
					write_msg('用户名重复，请换一个用户名注册');
				} elseif($checkuser == -1){
					write_msg('用户名不符合规范，请换一个用户名注册');
				} elseif($checkuser == 1){
				
				} else {
					write_msg('未知错误，请换一个用户名注册');
				}
				
				$checkemail = uc_check_email($email);
				if($checkemail == -3){
					write_msg('EMAIL格式不正确，请填写正确的email');
				}
				
				uc_user_register($userid,md5($userpwd),$email);
				
			} elseif(PASSPORT_TYPE == 'ucenter'){
				
				require MYMPS_ROOT.'/uc_client/client.php';
				
				if($activation && ($activeuser = uc_get_user($activation))) {
					list($uid, $userid) = $activeuser;
				} else {
					$user = $db -> getRow("SELECT id,userid FROM `{$db_mymps}member` WHERE userid = '$userid'");
					if(uc_get_user($userid) && !$user['userid']) {
						
						write_msg("该用户无需注册，请重新登录",$mymps_global[SiteUrl]."/".$mymps_global['cfg_member_logfile']);
					}
					$uid = uc_user_register($userid,$userpwd, $email);
					if($uid <= 0) {
						if($uid == -1) {
							write_msg('用户名不合法');
						} elseif($uid == -2) {
							write_msg( '包含不允许注册的词语');
						} elseif($uid == -3) {
							write_msg( '用户名已经存在');
						} elseif($uid == -4) {
							write_msg( 'Email 格式有误');
						} elseif($uid == -5) {
							write_msg( 'Email 不允许注册');
						} elseif($uid == -6) {
							write_msg( '该 Email 已经被注册');
						} else {
							write_msg( '未定义');
						}
					} else {
						$userid  = trim($userid);
						$userpwd = trim($userpwd);
						$email 	 = trim($email);
					}
				}
				
			} else {
				
				$openlogin_uri = $mymps_global[SiteUrl]."/".$mymps_global[cfg_member_logfile]."?mod=openlogin";
				$rs	= CheckUserID($userid,'用户名');
				$rs != 'ok' && write_msg($rs);
				//strlen($userid) > 40 && write_msg("您的用户名多于40个字符，不允许注册！");
				strlen($userid) < 4 && write_msg("你的用户名或密码过短(不能少于4个字符)，不允许注册！",$openlogin_uri);
				!is_email($email) && write_msg("Email格式不正确！");
				$db->getOne("SELECT id FROM `{$db_mymps}member` WHERE userid = '$userid' AND openid = ''") && write_msg("你指定的用户名 {$userid} 已存在，请使用别的用户名！",$openlogin_uri);
			}
			
			
			$userpwd = md5($userpwd);
			$money_own	=	$db -> getOne("SELECT money_own FROM `{$db_mymps}member_level` WHERE id = '1'");
			$money_own	=	$money_own ? $money_own : 0;
			
			$db -> query("UPDATE `{$db_mymps}member` SET jointime='$timestamp',logintime='$timestamp',userpwd = '$userpwd',email='$email',money_own = '$money_own'  WHERE userid = '$userid' ");
			//member_reg($userid,md5($userpwd),$email,$safequestion,$safeanswer,$openid,$cname);
			
			
			if($mymps_global['cfg_member_reg_title'] && $mymps_global['cfg_member_reg_content']){
				$title 	 = str_replace('{username}',$userid,$mymps_global['cfg_member_reg_title']);
				$content = str_replace('{sitename}',$mymps_global['SiteName'],$mymps_global['cfg_member_reg_content']);
				$content = str_replace('{time}',GetTime($timestamp),$content);
				$content = str_replace('{username}',$userid,$content);
				sendpm('admin',$userid,$title,$content,1);
			}
			
			if(mgetcookie('fromuid') && $mymps_global['cfg_if_affiliate'] == 1){
				$fromuid = intval(mgetcookie('fromuid'));
				$fromip = trim(mgetcookie('fromip'));
				$score_changer = "+".$mymps_global['cfg_affiliate_score'];
				$db -> query("UPDATE `{$db_mymps}member` SET score = score".$score_changer." WHERE id = '$fromuid'");
			
			}
			/*
			@session_unregister('openid');
			@session_unregister('nickname');
			@session_unregister('access_token');
			@session_unregister('appid');
			*/
			session_unset();
			if(PASSPORT_TYPE == 'phpwind'){
				$member_log -> in($userid,md5($userpwd),'off','noredirect');
				$user_login = uc_user_login($userid,md5($userpwd),0);
				$ucsynlogin = $user_login['synlogin'];
				echo $ucsynlogin;
				echo mymps_goto($url ? $url : $mymps_global['SiteUrl'].'/member/index.php');
			}elseif(PASSPORT_TYPE == 'ucenter'){
				$member_log -> in($userid,$userpwd,$memory,'noredirect');
				list($uid, $username, $password, $email) = uc_user_login($userid, $userpwd);
				echo uc_user_synlogin($uid);
				echo mymps_goto($url ? $url : $mymps_global['SiteUrl'].'/member/index.php');
			} else {
				$member_log -> in($userid,$userpwd,$memory,'noredirect');
				write_msg("现在转入用户管理中心，请稍候...",$mymps_global['SiteUrl']."/member/index.php");
			}
			
			
		}
		
	} else{
		include MYMPS_MEMBER.'/include/'.$mod.'.inc.php';
	}
}

is_object($db) && $db->Close();
$city = $maincity = NULL;
unset($city,$maincity);
?>