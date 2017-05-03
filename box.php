<?php
error_reporting(E_ALL^E_NOTICE);
@set_magic_quotes_runtime(0);
@header("Content-Type: text/html; charset=gbk");

__FILE__ == '' && die('Fatal error code: 0');

define("IN_MYMPS",true);
define('MAGIC_QUOTES_GPC', @get_magic_quotes_gpc());
define("MYMPS_ROOT",dirname(__FILE__));
define('MYMPS_DATA',MYMPS_ROOT.'/data');
define('MYMPS_INC',MYMPS_ROOT.'/include');
define('MYMPS_TPL',MYMPS_ROOT.'/template');
define('MYMPS_ASS',MYMPS_ROOT.'/include/assign');

if(function_exists('date_default_timezone_set')) date_default_timezone_set('Hongkong');
$timestamp = time();

if (!MAGIC_QUOTES_GPC && $_FILES) $_FILES = addslashes($_FILES);

if(PHP_VERSION < '4.1.0') {
	$_GET		=	&$HTTP_GET_VARS;
	$_SERVER	=	&$HTTP_SERVER_VARS;
	unset($HTTP_GET_VARS,$HTTP_SERVER_VARS);
}

require_once MYMPS_DATA."/config.php";
require_once MYMPS_ROOT."/version.php";
require_once MYMPS_ROOT."/include/common.fun.php";

$_GET = mhtmlspecialchars($_GET);
$part = isset($_REQUEST['part']) ? trim(mhtmlspecialchars($_REQUEST['part'])) : '';
$action = isset($_REQUEST['action']) ? trim(mhtmlspecialchars($_REQUEST['action'])) : '';
$ac  = isset($_REQUEST['ac']) ? trim(mhtmlspecialchars($_REQUEST['ac'])) : '';
$url = isset($_REQUEST['url']) ? trim(mhtmlspecialchars($_REQUEST['url'])) : '';
$userid = isset($_REQUEST['userid']) ? trim(mhtmlspecialchars($_REQUEST['userid'])) : '';
$password = isset($_GET['password']) ? trim($_GET['password']) : '';
$admindir = isset($_GET['admindir']) ? trim($_GET['admindir']) : '/admin';
$report_type = isset($_POST['report_type']) ? trim(mhtmlspecialchars($_POST['report_type'])) : '';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
$uid = isset($_GET['uid']) ? intval($_GET['uid']) : '';

!in_array($part,array('upgrade','shoucang','wap_shoucang','report','do_report','information','checkmemberinfo','sp_testdirs','adminmenu','member','memberinfopost','advertisement','advertisementview','jswizard','custom','iptoarea','goodsorder','score_coin','credits_up','howtogetscore','seecontact','delinfo','qiandao')) && exit('FORBIDDEN');

include MYMPS_INC.'/box/'.$part.'.php';

is_object($db) && $db->Close();
?>