<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
class mymps_admin_log
{
	var $db_mixcode;

    function __construct($db_mixcode)
    {
		$this->db_mixcode=$db_mixcode;
    }

    function mymps_member_log($db_mixcode)
    {
		$this->__construct($db_mixcode);
    }
	
	function PutLogin($admin_id,$admin_name,$admin_cityid='')
	{
		session_start();
		//put sessions
		$_SESSION['admin_id']  = $admin_id;
		$_SESSION['admin_name'] = $admin_name;
		$_SESSION['admin_cityid'] = $admin_cityid;
		//put cookies
		/*
		setcookie("admin_id", $this->GetValue($admin_id) ,"0" , "/");
		setcookie("admin_name", $this->GetValue($admin_name) ,"0" , "/");
		*/
	}
	
	/*admin_login*/
	function mymps_admin_login($admin_id,$admin_name,$admin_cityid)
	{
		global $admin_id,$admin_name,$admin_cityid;
		if(!empty($admin_id)&&!empty($admin_name)){
			$this->PutLogin($admin_id,$admin_name,$admin_cityid);
		}
	}
	
	/*admin_out*/
	function mymps_admin_logout()
	{
		//session protected
		session_start();
		session_destroy();
		//cookies protected
		/*
		setcookie("admin_id", "",0,"/");
		setcookie("admin_name", "",0,"/");
		*/
	}
	
	/*chk admin login and get the info of admin*/
	function mymps_admin_chk_getinfo()
	{
		session_start();
		global $admin_id,$admin_name,$admin_cityid,$url;
		/*$id = explode("_",$_COOKIE['admin_id']);
		$name = explode("_",$_COOKIE['admin_name']);
		$id_pre = $id[0];
		$name_pre = $name[0];
		*/
		if(empty($_SESSION['admin_name'])||empty($_SESSION['admin_id']))
		{
			$this -> mymps_admin_logout();
			return false;
		}
		else
		{
			$admin_id 	= $_SESSION['admin_id'];
			$admin_name = $_SESSION['admin_name'];
			$admin_cityid = $_SESSION['admin_cityid'];
			return true;
		}
	}
}

$mymps_admin = new mymps_admin_log($db_mixcode);
?>