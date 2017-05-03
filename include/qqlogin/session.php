<?php
$_GET['mod'] = $_GET['mod'] ? htmlspecialchars(trim($_GET['mod'])) : 'pc';
if($_GET['mod'] == 'pc'){
	session_save_path ("../../data/sessions");
}else{
	session_save_path ("../../m/sessions");	
}

session_start();
?>