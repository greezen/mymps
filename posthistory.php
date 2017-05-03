<?php 
define('IN_SMT', true);
define('IN_MYMPS', true);
define('CURSCRIPT','posthistory');

require_once dirname(__FILE__)."/include/global.php";
require_once dirname(__FILE__)."/data/config.php";

ifsiteopen();
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";

if(!is_file(MYMPS_DATA."/install.lock")) write_msg('','install/index.php');

if(!$tel) write_msg('您要查找的电话不能为空！','olmsg');
$tel_decode = addslashes(base64_decode($tel));

$info = mymps_get_infos('20',NULL,NULL,NULL,NULL,NULL,NULL,$tel_decode);
$numtotal = $db -> getOne("SELECT COUNT(id) FROM `{$db_mymps}information` WHERE tel = '$tel_decode'");
$numtotal = $numtotal < 20 ? $numtotal : 20;

$loc 		= get_location('posthistory','','查看发贴记录');
$page_title = $loc['page_title'];

globalassign();
include mymps_tpl(CURSCRIPT);

is_object($db) && $db->Close();
?>