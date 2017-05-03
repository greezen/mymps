<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
class mymps_member_log
{
	var $cookiepre;

    function __construct($cookiepre)
    {
		$this->cookiepre=$cookiepre;
    }

    function mymps_member_log($cookiepre)
    {
		$this->__construct($cookiepre);
    }
	
	function PutLogin($s_uid='',$s_pwd='',$memory='')
	{
		global $cookiepre,$cookiedomain,$cookiepath,$timestamp;
		$timestamp = $timestamp ? $timestamp : time();
		if ($memory == "on"){
			msetcookie('s_uid',$s_uid,3600*24*30);
			msetcookie('s_pwd',mmd5($s_pwd,'EN'),3600*24*30);
		}else{
			msetcookie('s_uid',$s_uid,0);
			msetcookie('s_pwd',mmd5($s_pwd,'EN'));
		}
	}

	function in($s_uid='',$s_pwd='',$memory="",$url="",$type="")
	{
		global $mymps_global,$uid,$db_mymps,$db,$timestamp,$do,$mymps_mymps;
		if(!empty($s_uid)){
			$this->PutLogin($s_uid,$s_pwd,$memory);
			if($do != 'power' && !defined('WAP')){
				//成功登陆的会员记录保存|IP地址|端口|地理位置|用户端|浏览器
				$timestamp = $timestamp ? $timestamp : time();
				$loginip = GetIP();
				if($mymps_mymps['cfg_iflogin_port'] == 1){
					if($loginip){
						require_once 'ip.class.php';
						$ipdata  = new ip();
						$a = $ipdata -> getaddress($loginip);
						$ip2area = $a['area1'].$a['area2'];
					} else {
						$ip2area = '';
					}
					$browser = getbrowser();
					$os		 = getos();
					$port	 = getport();
				} else {
					$ip2area = $browser = $os = $port = '';
				}
				$db->query("DELETE FROM `{$db_mymps}member_record_login` WHERE userid = '$s_uid'");
				$db->query("INSERT INTO `{$db_mymps}member_record_login` (id,userid,userpwd,pubdate,ip,ip2area,browser,os,port,result) VALUES ('','$s_uid','$userpwd','$timestamp','$loginip','$ip2area','$browser','$os','$port','1')");
			}
			if($url != 'noredirect'){
				if(empty($url)&&empty($type)){
					echo mymps_goto($mymps_global['SiteUrl']."/member/index.php");
				}elseif(!empty($url)&&empty($type)){
					echo mymps_goto($url);
				}
			}
		}
	}

	function out($url='')
	{
		global $mymps_global,$db,$db_mymps,$timestamp,$s_uid;
		$s_uid = mgetcookie('s_uid');
		$s_uid = isset($s_uid) ? addslashes($s_uid) : '';
		$timestamp = $timestamp ? $timestamp : time();
		if($s_uid && !defined('WAP')) $db->query("UPDATE `{$db_mymps}member_record_login` SET outdate = '$timestamp' WHERE userid = '$s_uid'");
		msetcookie('s_uid','');
		msetcookie('s_pwd','');
		if($url == 'noredirect'){
		}elseif (empty($url)){
			echo mymps_goto('../'.$mymps_global['cfg_member_logfile']);
		} else {
			echo mymps_goto($url);
		}
	}

	function chk_in()
	{
		global $db,$db_mymps,$s_uid,$cookie;

		$s_uid = mgetcookie('s_uid');
		$s_pwd = mgetcookie('s_pwd');
		if(empty($s_uid)){
			msetcookie('s_uid','');
			msetcookie('s_pwd','');
			return false;
		}else{
			$m = $db -> getRow("SELECT userpwd,openid FROM `{$db_mymps}member` WHERE userid = '$s_uid'");
			if($m['openid'] && !$m['userpwd']){
				return true;
			}else{
				return mmd5($m['userpwd'],'EN','',$this->cookiepre) == $s_pwd ? true : false;
			}
		}

	}

	function get_info()
	{
		global $s_uid,$db,$db_mymps;
		$s_uid = mgetcookie('s_uid');
		return $db->getRow("SELECT * FROM {$db_mymps}member WHERE userid = '$s_uid'");
	}
}
$member_log = new mymps_member_log($cookiepre);
?>