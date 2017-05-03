<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

define( "CURSCRIPT", "credit_set" );
require_once( dirname( __FILE__ )."/global.php" );
require_once( MYMPS_INC."/db.class.php" );
$defaultrank = array( 1 => 10, 2 => 20, 3 => 40, 4 => 70, 5 => 120, 6 => 200, 7 => 400, 8 => 700, 9 => 1200, 10 => 1800, 11 => 2600, 12 => 4000, 13 => 10000, 14 => 30000, 15 => 60000 );
if ( !submit_check( CURSCRIPT."_submit" ) )
{
	chk_admin_purview( "purview_积分信用等级" );
	$here = "信用等级管理";
	if ( $ac == "update_credits" )
	{
		$score_change = get_credit_score( );
		@set_time_limit( 0 );
		$query = $db->query( "SELECT id,credit FROM `".$db_mymps."member`" );
		while ( $row = $db->fetchrow( $query ) )
		{
			if ( $score_change )
			{
				foreach ( $score_change['credit_set']['rank'] as $level => $credi )
				{
					if ( $row['credit'] <= $credi )
					{
						$credits = $level;
					}
					else
					{
						$credits = 16;
					}
				}
				$credits -= 1;
			}
			$db->query( "UPDATE `".$db_mymps."member` SET credits = '{$credits}' WHERE id = '{$row['id']}'" );
		}
		write_msg( "会员积分信用等级图标已更新成功！", "credit_set.php", "write_mymps_records" );
		$score_change = $row = $credits = NULL;
		exit( );
	}
	$credit_set = $db->getone( "SELECT value FROM `".$db_mymps."config` WHERE type='credit_sco' AND description = 'credit_set'" );
	$credit_set = $credit_set ? $charset == "utf-8" ? utf8_unserialize( $credit_set ) : unserialize( $credit_set ) : array( "rank" => $defaultrank );
	include( mymps_tpl( CURSCRIPT ) );
}
else
{
	if ( is_array( $credit_setnew['rank'] ) )
	{
		foreach ( $credit_setnew['rank'] as $rank => $mincredits )
		{
			$mincredits = intval( $mincredits );
			if ( $rank == 1 && $mincredits <= 0 )
			{
				write_msg( "信用度必须大于 0 才能进行评级！请返回修改。" );
			}
			else if ( 1 < $rank && $mincredits <= $credit_setnew['rank'][$rank - 1] )
			{
				write_msg( "信用等级 ".$rank." 的信用度必须大于上一等级的信用度！请返回修改。" );
			}
			$credit_setnew['rank'][$rank] = $mincredits;
		}
	}
	else
	{
		$credit_setnew['rank'] = $defaultrank;
	}
	$db->query( "DELETE FROM `".$db_mymps."config` WHERE description = 'credit_set' AND type = 'credit_sco'" );
	$db->query( "INSERT INTO `".$db_mymps."config` (description,value,type) values ('credit_set','".serialize( $credit_setnew )."','credit_sco')" );
	clear_cache_files( "credit_score" );
	write_msg( "信用等级管理更新成功！", "credit_set.php", "WriteRecord" );
}
if ( is_object( $db ) )
{
	$db->close( );
}
$mymps_global = $db = $db_mymps = $part = NULL;
?>
