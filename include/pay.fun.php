<?php

function topaymoney( $money, $orderid, $uid, $userid, $mymps_paytype, $relation_id )
{
    global $db;
    global $db_mymps;
    global $mymps_global;
    global $timestamp;
    $orderid = var_action( $orderid );
    if ( $money )
    {
        if ( $mymps_global['cfg_coin_fee'] )
        {
            $money *= $mymps_global['cfg_coin_fee'];
        }
        $payip = getip( );
        $db->query( "INSERT INTO ".$db_mymps."payrecord(id,uid,userid,orderid,money,posttime,paybz,type,payip,relation_id) values('','{$uid}','{$userid}','{$orderid}','{$money}','{$timestamp}','等待支付','{$mymps_paytype}','{$payip}','{$relation_id}');" );
        $db->query( "UPDATE `".$db_mymps."property` SET pay_type = '{$mymps_paytype}' WHERE id = '{$relation_id}';" );
    }
}

function updatepayrecord( $orderid, $paybz )
{
    global $db;
    global $db_mymps;
    global $mymps_global;
    global $timestamp;
    $orderid = var_action( $orderid );
    $r = $db->getrow( "SELECT money,userid,ifadd,relation_id FROM `".$db_mymps."payrecord` WHERE orderid = '{$orderid}'" );
    $money = $r['money'];
    $userid = $r['userid'];
    $ifadd = $r['ifadd'];
    if ( $money && $userid && $ifadd != 1 )
    {
        $db->query( "UPDATE `".$db_mymps."member` SET money_own = money_own + ".$money.( " WHERE userid = '".$userid."'" ) );
    }
    $db->query( "UPDATE `".$db_mymps."payrecord` SET paybz = '{$paybz}',ifadd = 1 WHERE orderid = '{$orderid}';" );

    if (in_array($paybz, array('支付成功', '支付完成'))) {
        $now = time();
        $db->query( "UPDATE `".$db_mymps."property` SET status = 'Y',pay_time='{$now}' WHERE id = '{$r['relation_id']}';" );
    }
}

function payapipaymoney( $money, $paybz, $orderid, $uid, $userid, $mymps_paytype )
{
    global $db;
    global $db_mymps;
    global $mymps_global;
    global $timestamp;
    $orderid = var_action( $orderid );
    $num = $db->getone( "SELECT count(id) FROM ".$db_mymps."payrecord WHERE orderid = '{$orderid}'" );
    if ( 0 < $num )
    {
        write_msg( "您已充值过 ".$money." 请不要重复刷新", $mymps_global[SiteUrl]."/member/index.php?m=pay&ac=record" );
    }
    else if ( $money )
    {
        if ( $mymps_global['cfg_coin_fee'] )
        {
            $money *= $mymps_global['cfg_coin_fee'];
        }
        $sql = $db->query( "UPDATE `".$db_mymps."member` SET money_own = money_own + ".$money.( " WHERE userid = '".$userid."'" ) );
        $payip = getip( );
        $db->query( "INSERT INTO ".$db_mymps."payrecord(id,uid,userid,orderid,money,ifadd,posttime,paybz,type,payip) values('','{$uid}','{$userid}','{$orderid}','{$money}',1,'{$timestamp}','{$paybz}','{$mymps_paytype}','{$payip}');" );
        write_msg( "您已成功充值 ".$money." 个金币", $mymps_global[SiteUrl]."/member/index.php?m=pay&ac=record" );
    }
    else
    {
        write_msg( "充值失败，请联系网站管理员以获得帮助。", $mymps_global[SiteUrl]."/member/index.php?m=pay&ac=record" );
    }
}

function var_action( $val )
{
    if ( $val != addslashes( $val ) )
    {
        exit( );
    }
    $val = str_replace( " ", "", $val );
    $val = str_replace( "%20", "", $val );
    $val = str_replace( "%27", "", $val );
    $val = str_replace( "*", "", $val );
    $val = str_replace( "'", "", $val );
    $val = str_replace( "\"", "", $val );
    $val = str_replace( "/", "", $val );
    $val = str_replace( ";", "", $val );
    $val = reppoststr( $val );
    $val = addslashes( $val );
    return $val;
}

function reppoststr( $val )
{
    $val = htmlspecialchars( $val, ENT_QUOTES );
    return $val;
}

?>
