<?php 
error_reporting(E_ALL^E_NOTICE);
@header("Content-Type: text/html; charset=gbk");
define('IN_MYMPS',true);
define('QQLOGINDIR',dirname(__FILE__));
@define('MYMPS_ROOT', ereg_replace("[/\\]{1,}",'/',substr(QQLOGINDIR,0,-15)));
define('MYMPS_DATA',MYMPS_ROOT.'/data');
define('MYMPS_INC',MYMPS_ROOT.'include');
require_once MYMPS_DATA.'/config.php';
if(function_exists('date_default_timezone_set')) date_default_timezone_set('Hongkong');
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';
require_once MYMPS_INC.'/common.fun.php';
require_once MYMPS_INC.'/cache.fun.php';
require_once MYMPS_ROOT.'/member/include/common.func.php';

$timestamp = time();
if(!pcclient()){ 
	$_GET['mod'] = 'm';
} else{
	$_GET['mod'] = 'pc';
}
require_once("session.php");
require_once("config.php");

//QQ登录成功后的回调地址,主要保存access token
qq_callback();

//获取用户标示id
get_openid();
$openid = $_SESSION['openid'];
if(empty($openid)) write_msg('登录失败，请返回重新登陆！',$mymps_global[SiteUrl].'/include/qqlogin/qq_login.php');

$row = NULL;
$row = $db -> getRow("SELECT userid,userpwd FROM `{$db_mymps}member` WHERE openid = '$openid'");

//登录
require_once MYMPS_INC."/member.class.php";
if(is_array($row)){
	$userid = $row['userid'];
	$userpwd = $row['userpwd'];
	if(PASSPORT_TYPE == 'phpwind'){
		require MYMPS_ROOT.'/pw_client/uc_client.php';
		$user_login = uc_user_login($userid,$userpwd,0);
		$member_log -> in($userid,$userpwd,'off','noredirect');
		echo $user_login['synlogin'];
	} elseif(PASSPORT_TYPE == 'ucenter'){
		$member_log -> in($userid,$userpwd,'off','noredirect');
		require MYMPS_ROOT.'/uc_client/client.php';
		list($uid, $username, $password, $email) = uc_user_login($userid, $userpwd);
		echo uc_user_synlogin($uid);
	} else {
		$member_log -> in($userid,$userpwd,'off','noredirect');
	}
	
	if(!pcclient() && $view != 'pc'){
		echo mymps_goto($mymps_global['SiteUrl'].'/m/index.php?mod=member');
	} else{
		echo mymps_goto($mymps_global['SiteUrl'].'/member/index.php');
	}
} else{
	
	$qquser = get_qquser_info();

	//$_SESSION['nickname'] = $charset == 'gbk' ? iconv("UTF-8", "GBK",  $qquser['nickname']) :  $qquser['nickname'];
	$_SESSION['nickname'] = iconv("UTF-8", "GBK",  $qquser['nickname']);
	$_SESSION['figureurl_qq_1'] = $qquser['figureurl_qq_1'];

	$nickname = $_SESSION['nickname'];
	
	if($db->getOne("SELECT COUNT(id) FROM `{$db_mymps}member` WHERE userid = '$nickname'") < 1) member_reg($nickname,'','','','',$openid,'',1);
	$member_log -> in($nickname,'','off','noredirect');
	if(!pcclient() && $view != 'pc'){
		echo mymps_goto($mymps_global['SiteUrl'].'/m/index.php?mod=openlogin&action=reg');
	} else{
		echo mymps_goto($mymps_global['SiteUrl'].'/'.$mymps_global['cfg_member_logfile'].'?mod=openlogin&action=reg');
	}
}

function get_qquser_info()
{
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $_SESSION['access_token']
        . "&oauth_consumer_key=" . $_SESSION["appid"]
        . "&openid=" . $_SESSION["openid"]
        . "&format=json";

    $info = get_url_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}

function qq_callback()
{
    //debug
    //print_r($_REQUEST);
    //print_r($_SESSION);

    if($_REQUEST['state'] == $_SESSION['state']) //csrf
    {
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . $_SESSION["appid"]. "&redirect_uri=" . urlencode($_SESSION["callback"])
            . "&client_secret=" . $_SESSION["appkey"]. "&code=" . $_REQUEST["code"];

        $response = get_url_contents($token_url);
        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error))
            {
                echo "<h3>error:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                exit;
            }
        }

        $params = array();
        parse_str($response, $params);

        //debug
        //print_r($params);
		//exit;

        //set access token to session
        $_SESSION["access_token"] = $params["access_token"];

    }
    else 
    {
        echo("The state does not match. You may be a victim of CSRF.");
    }
}

function get_openid()
{
    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" 
        . $_SESSION['access_token'];

    $str  = get_url_contents($graph_url);
    if (strpos($str, "callback") !== false)
    {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
    }
	
    $user = json_decode($str);
    if (isset($user->error))
    {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
    }

    //debug
    //echo("Hello " . $user->openid);

    //set openid to session
    $_SESSION["openid"] = $user->openid;
}

if (!function_exists('json_decode')){
	function json_decode($json, $assoc=FALSE, /*emu_args*/$n=0,$state=0,$waitfor=0) {
		#-- result var
		$val = NULL;
		static $lang_eq = array("true" => TRUE, "false" => FALSE, "null" => NULL);
		static $str_eq = array("n"=>"\012", "r"=>"\015", "\\"=>"\\", '"'=>'"', "f"=>"\f", "b"=>"\b", "t"=>"\t", "/"=>"/");
		#-- flat char-wise parsing
		for (/*n*/; $n<strlen($json); /*n*/) {
		$c = $json[$n];
		#-= in-string
		if ($state==='"') {
		if ($c == '\\') {
		$c = $json[++$n];
		// simple C escapes
		if (isset($str_eq[$c])) {
		$val .= $str_eq[$c];
		}
		// here we transform \uXXXX Unicode (always 4 nibbles) references to UTF-8
		elseif ($c == "u") {
		// read just 16bit (therefore value can't be negative)
		$hex = hexdec( substr($json, $n+1, 4) );
		$n += 4;
		// Unicode ranges
		if ($hex < 0x80) {    // plain ASCII character
		$val .= chr($hex);
		}
		elseif ($hex < 0x800) {   // 110xxxxx 10xxxxxx
		$val .= chr(0xC0 + $hex>>6) . chr(0x80 + $hex&63);
		}
		elseif ($hex <= 0xFFFF) { // 1110xxxx 10xxxxxx 10xxxxxx
		$val .= chr(0xE0 + $hex>>12) . chr(0x80 + ($hex>>6)&63) . chr(0x80 + $hex&63);
		}
		// other ranges, like 0x1FFFFF=0xF0, 0x3FFFFFF=0xF8 and 0x7FFFFFFF=0xFC do not apply
		}
		// no escape, just a redundant backslash
		//@COMPAT: we could throw an exception here
		else {
		$val .= "\\" . $c;
		}
		}
		// end of string
		elseif ($c == '"') {
		$state = 0;
		}
		// yeeha! a single character found!!!!1!
		else/*if (ord($c) >= 32)*/ { //@COMPAT: specialchars check - but native json doesn't do it?
		$val .= $c;
		}
		}
		#-> end of sub-call (array/object)
		elseif ($waitfor && (strpos($waitfor, $c) !== false)) {
		return array($val, $n);  // return current value and state
		}
		#-= in-array
		elseif ($state===']') {
		list($v, $n) = json_decode($json, 0, $n, 0, ",]");
		$val[] = $v;
		if ($json[$n] == "]") { return array($val, $n); }
		}
		#-= in-object
		elseif ($state==='}') {
		list($i, $n) = json_decode($json, 0, $n, 0, ":");   // this allowed non-string indicies
		list($v, $n) = json_decode($json, $assoc, $n+1, 0, ",}");
		$val[$i] = $v;
		if ($json[$n] == "}") { return array($val, $n); }
		}
		#-- looking for next item (0)
		else {
		#-> whitespace
		if (preg_match("/\s/", $c)) {
		// skip
		}
		#-> string begin
		elseif ($c == '"') {
		$state = '"';
		}
		#-> object
		elseif ($c == "{") {
		list($val, $n) = json_decode($json, $assoc, $n+1, '}', "}");
		if ($val && $n && !$assoc) {
		$obj = new stdClass();
		foreach ($val as $i=>$v) {
		$obj->{$i} = $v;
		}
		$val = $obj;
		unset($obj);
		}
		}
		#-> array
		elseif ($c == "[") {
		list($val, $n) = json_decode($json, $assoc, $n+1, ']', "]");
		}
		#-> comment
		elseif (($c == "/") && ($json[$n+1]=="*")) {
		// just find end, skip over
		($n = strpos($json, "*/", $n+1)) or ($n = strlen($json));
		}
		#-> numbers
		elseif (preg_match("#^(-?\d+(?:\.\d+)?)(?:[eE]([-+]?\d+))?#", substr($json, $n), $uu)) {
		$val = $uu[1];
		$n += strlen($uu[0]) - 1;
		if (strpos($val, ".")) {  // float
		$val = (float)$val;
		}
		elseif ($val[0] == "0") {  // oct
		$val = octdec($val);
		}
		else {
		$val = (int)$val;
		}
		// exponent?
		if (isset($uu[2])) {
		$val *= pow(10, (int)$uu[2]);
		}
		}
		#-> boolean or null
		elseif (preg_match("#^(true|false|null)\b#", substr($json, $n), $uu)) {
		$val = $lang_eq[$uu[1]];
		$n += strlen($uu[1]) - 1;
		}
		#-- parsing error
		else {
		// PHPs native json_decode() breaks here usually and QUIETLY
		trigger_error("json_decode: error parsing '$c' at position $n", E_USER_WARNING);
		return $waitfor ? array(NULL, 1<<30) : NULL;
		}
		}//state
		#-- next char
		if ($n === NULL) { return NULL; }
		$n++;
		}//for
		#-- final result
		return ($val);
	}
}
?>
