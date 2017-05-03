<?php
define('IN_MYMPS',true);

require_once dirname(__FILE__).'/global.php';
require_once MYMPS_DATA.'/config.php';
require_once MYMPS_DATA.'/config.db.php';
require_once MYMPS_INC.'/db.class.php';

$action 	= isset($action) 	? trim($action)		: '';
$parentid 	= isset($parentid) 	? intval($parentid)	: '';
$currentid 	= isset($currentid) ? intval($currentid): '';
$delstreet 	= isset($delstreet) ? intval($delstreet): '';

$mymps_global = NULL;

switch($action){
	case 'getarea':
		if($parentid){
			$view=select_where("area","'areaid' onChange=\"choose_where('getstreet',this.options[this.selectedIndex].value,'','')\"",$currentid,$parentid);
			$view=str_replace("\r","",$view);
			$view=str_replace("\n","",$view);
			$view=str_replace("'","\'",$view);
			echo "<script language=\"javascript\">
			<!--
			parent.document.getElementById(\"showarea\").innerHTML='$view';
			//-->
			</script>";
		}
		if($delstreet){
			echo "<script language=\"javascript\">
			<!--
			parent.document.getElementById(\"showstreet\").innerHTML='';
			//-->
			</script>";
			if(!$parentid){
				echo "<script language=\"javascript\">
				<!--
				parent.document.getElementById(\"showarea\").innerHTML='';
				//-->
				</script>";
			}
		}
	break;
	case 'getstreet':
		$view=select_where("street","'streetid'",$currentid,$parentid);
		$view=str_replace("\r","",$view);
		$view=str_replace("\n","",$view);
		$view=str_replace("'","\'",$view);
		echo "<script language=\"javascript\">
		<!--
		parent.document.getElementById(\"showstreet\").innerHTML='$view';
		//-->
		</script>";
	break;
}
is_object($db) && $db -> Close();
$db_mymps = $view = $parentid = $action = $currentid = $delstreet = $db = $db_mymps = NULL;
?>