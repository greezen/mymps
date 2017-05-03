<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "certification" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
$certify_arr = array( "1" => "营业执照", "2" => "个人身份证" );
$typeid = $typeid ? $typeid : "1";
$page = $page ? intval( $page ) : "1";
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	chk_admin_purview( "purview_实名认证" );
	$info_do_type = array( );
	$info_do_type['奖励相关'] = array( "证件属实" );
	$info_do_type['惩罚相关'] = array( "图片不够清晰", "虚假证件", "证件已过期" );
	if ( $part == "yes" && $userid )
	{
		$set = $typeid == 1 ? "com_certify = '1'," : "per_certify = '1',";
		$db->query( "UPDATE `".$db_mymps."information` SET certify = '1' WHERE userid = '{$userid}'" );
		$score_change = get_credit_score( );
		$score_changer = $typeid == 1 ? $score_change['score']['rank']['com_certify'] : $score_change['score']['rank']['per_certify'];
		$credit_changer = $typeid == 1 ? $score_change['credit']['rank']['com_certify'] : $score_change['credit']['rank']['per_certify'];
		$credit = $db->getone( "SELECT credit FROM `".$db_mymps."member` WHERE userid = '{$userid}'" );
		$credit .= $credit_changer;
		if ( $score_change )
		{
			foreach ( $score_change['credit_set']['rank'] as $level => $credi )
			{
				if ( $credit <= $credi )
				{
					$credits = $level;
					break;
				}
			}
			$credits -= 1;
		}
		$db->query( "UPDATE `".$db_mymps."member` SET ".$set." score = score".$score_changer." , credit = credit".$credit_changer.( ",credits = '".$credits."' WHERE userid = '{$userid}'" ) );
		$score_change = $credits = $score_changer = NULL;
		$here = "附加操作处理";
		$title = "尊敬的用户 ".$userid." ，您提交的实名认证审核已通过！";
		include( mymps_tpl( "information_pm" ) );
	}
	else
	{
		if ( $part == "no" && $userid )
		{
			if ( !$userid )
			{
				write_msg( "请指定会员用户名！" );
			}
			$set = $typeid == 1 ? "SET com_certify = '0'" : "SET per_certify = '0'";
			$db->query( "UPDATE `".$db_mymps."member` {$set} WHERE userid = '{$userid}'" );
			$db->query( "UPDATE `".$db_mymps."information` SET certify = '0' WHERE userid = '{$userid}'" );
			$here = "附加操作处理";
			$nummoney = "-2";
			$title = "尊敬的用户 ".$userid." ，您提交的实名认证审核未能通过！";
			include( mymps_tpl( "information_pm" ) );
		}
		else
		{
			$here = $certify_arr[$typeid]."验证";
			$sql = "SELECT a.*,b.per_certify,b.com_certify FROM `".$db_mymps."certification` AS a LEFT JOIN `{$db_mymps}member` AS b ON a.userid = b.userid WHERE a.typeid = '{$typeid}'";
			$rows_num = mymps_count( "certification", "WHERE typeid = '".$typeid."'" );
			$param = setparam( array( "typeid" ) );
			$certification = page1( $sql );
			include( mymps_tpl( CURSCRIPT ) );
		}
	}
}
else
{
	if ( is_array( $delids ) )
	{
		foreach ( $delids as $kids => $vids )
		{
			$delrow = $db->getrow( "SELECT img_path FROM `".$db_mymps."certification` WHERE id = '{$vids}'" );
			@unlink( @MYMPS_ROOT.@$delrow['img_path'] );
			unset( $delrow );
			mymps_delete( CURSCRIPT, "WHERE id = ".$vids );
		}
		$message = "成功更新或删除会员认证提交记录！";
	}
	if ( $part == "sendpm" )
	{
		require_once( MYMPS_MEMBER."/include/common.func.php" );
		if ( !$userid )
		{
			write_msg( "请指定会员用户名！" );
		}
		if ( $if_money == 1 )
		{
			$db->query( "UPDATE `".$db_mymps."member` SET money_own = money_own {$money_num} WHERE userid = '{$userid}'" );
		}
		if ( $if_pm == 1 )
		{
			$msg .= $if_money == 1 ? "<br />金币变化：<b style=color:red>".$money_num."</b>" : "";
			$result = sendpm( $admin_id, $userid, $title, $msg, 1 );
		}
		$message = "用户 ".$userid." 实名认证审核更新成功！";
	}
	write_msg( $message, "?typeid=".$typwid."&page=".$page, "write_record" );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$db = $mymps_global = $part = $action = $here = NULL;
?>
