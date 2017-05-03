<?php
@define('MYMPS_ROOT'	, ereg_replace("[/\\]{1,}",'/',substr(dirname(__FILE__),0,-8)));
define('MYMPS_INC'		, MYMPS_ROOT.'/include');
define('MYMPS_DATA'		, MYMPS_ROOT.'/data');
define('MYMPS_MEMBER'	, MYMPS_ROOT.'/member');
define('MYMPS_UPLOAD'	, MYMPS_ROOT.'/attachment');
define('MYMPS_TPL'		, MYMPS_ROOT.'/template');
define('MYMPS_ASS'		, MYMPS_INC.'/assign');
define('MYMPS_CACHE'	, MYMPS_ROOT.'/cache');
define('TEMPLATEID'		,'1');
define('TPLDIR'			,'default');
?>