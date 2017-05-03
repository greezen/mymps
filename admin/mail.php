<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "mail" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
require_once( MYMPS_INC."/email.fun.php" );
if ( !in_array( $part, array( "setting", "template", "sendlist" ) ) || !$part )
{
    $part = "setting";
}
if ( !submit_check( CURSCRIPT."_submit" ) )
{	
	switch ( $part )
	{
		case "setting" :
		chk_admin_purview( "purview_邮件服务器" );
		$here = "邮件服务器设置";
		$res = $db->query( "SELECT description,value FROM ".$db_mymps."config WHERE type='mail'" );
		while ( $row = $db->fetchrow( $res ) )
		{
			$mail_config[$row['description']] = $row['value'];
		}
		break;
		case "sendlist" :
		chk_admin_purview( "purview_邮件发送记录" );
		$here = "邮件发送记录";
		$list = $db->getall( "SELECT * FROM `".$db_mymps."mail_sendlist` ORDER BY last_send DESC" );
		break;
		default :
		chk_admin_purview( "purview_邮件模板" );
		$here = "邮件模板管理";
		$tpl = mail_template_list( );
		if ( $template_id )
		{
			$edit = $db->getrow( "SELECT * FROM `".$db_mymps."mail_template` WHERE template_id = '{$template_id}'" );
		}
		break;
	}
	include( mymps_tpl( CURSCRIPT."_".$part ) );
}
else
{
	if ($part == "test" )
	{
		if ( !empty( $test_mail )) {

			$test_mail = trim( $test_mail );
			if ( !send_email( $test_mail, "来自".$mymps_global[SiteName]."的测试邮件", "如果你收到了这封邮件，则表明你已经成功配置了邮箱服务器，发送时间：".gettime( time( ) ) ) )
			{
				write_msg( "测试邮件发出失败！请仔细配置好邮箱服务信息", "?part=setting" );
			}
			else
			{
				write_msg( "恭喜，您已经成功发出测试邮件", "?part=setting", "write_record" );
			}
		}else{
			write_msg( "请填写邮件地址", "?part=setting", "write_record" );
		}
	}
	if ( $part == "setting" )
	{
		$des = array( "mail_service", "smtp_server", "smtp_serverport", "smtp_mail", "mail_user", "mail_pass" );
		mymps_delete( "config", "WHERE type = 'mail'" );
		foreach ( $des as $key )
		{
			$db->query( "INSERT ".$db_mymps."config (description,value,type) VALUES ('{$key}','".trim( $$key )."','mail')" );
		}
		clear_cache_files( "mail_config" );
		write_msg( "邮件服务器配置设置成功！", "?part=".$part, "WriteRecord" );
	}
	else if ( $part == "template" )
	{
		$return_url = "?part=template";
		if ( is_array( $delids ) )
		{
			foreach ( $delids as $kids => $vids )
			{
				mymps_delete( "mail_template", "WHERE template_id = ".$vids );
			}
		}
		if ( is_array( $add ) && $add[template_subject] && $add[template_code] )
		{
			if ( $db->getone( "SELECT template_id FROM `".$db_mymps."mail_template` WHERE template_code = '{$add['template_code']}'" ) )
			{
				write_msg( "您填写的模板标识码重复了！" );
			}
			else
			{
				$db->query( "INSERT `".$db_mymps."mail_template` (template_subject,template_code,is_html,is_sys,last_modify)VALUES('{$add['template_subject']}','{$add['template_code']}','{$add['is_html']}','{$add['is_sys']}','".time( )."')" );
			}
		}
		if ( is_array( $edit ) && $edit[template_id] && $edit[template_subject] && $edit[template_code] && $edit[template_content] )
		{
			$db->query( "UPDATE `".$db_mymps."mail_template` SET template_subject = '{$edit['template_subject']}', template_code = '{$edit['template_code']}' , is_html  = '{$edit['is_html']}' , template_content = '{$edit['template_content']}' , last_modify = '".time( ).( "'  WHERE template_id = '".$edit['template_id']."'" ) );
			$return_url = "?part=template&template_id=".$edit[template_id];
		}
		clear_cache_files( "mail_template" );
		write_msg( "邮件模板增加或更新成功！", $return_url, "write_record" );
	}
	else if ( $part == "sendlist" )
	{
		$return_url = "?part=sendlist";
		if ( is_array( $delids ) )
		{
			foreach ( $delids as $kids => $vids )
			{
				mymps_delete( "mail_sendlist", "WHERE id = ".$vids );
			}
		}
		write_msg( "成功删除邮件发送记录！", $return_url, "write_record" );
	}
}
if ( is_object( $db ) )
{
	$db->Close();
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
