<?php
define('IN_SMT',true);
define('CURSCRIPT','mobile');
define('IN_MYMPS', true);

require_once dirname(__FILE__)."/include/global.php";
require_once dirname(__FILE__)."/data/config.php";
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';
ifsiteopen();
if(pcclient()){
	$mobile_settings = get_mobile_settings();
	$mobile_settings['mdomain'] = $mobile_settings['mobiledomain'] ? $mobile_settings['mobiledomain'] : $mymps_global['SiteUrl'].'/m/';
	globalassign();
	include mymps_tpl(CURSCRIPT);
} else{
	write_msg('',$mymps_global['SiteUrl'].'/m/index.php');
}
?>