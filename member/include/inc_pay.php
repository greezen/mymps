<?php
if(!defined('IN_MYMPS')) exit('Forbidden');
$ac = in_array($ac,array('pay','record','use')) ? trim($ac) : 'pay';
$mymps_global['cfg_coin_fee'] = $mymps_global['cfg_coin_fee'] ? $mymps_global['cfg_coin_fee'] : 1;
require_once MYMPS_DATA.'/moneytype.inc.php';

if(submit_check('pay_submit')){
	$money = isset($_POST['money']) ? intval($_POST['money']) : '';
	if($ac == 'record' && empty($recordids)) write_msg('','?m=pay&ac=record&error=1&page='.$page);
	if($ac == 'use' && empty($useids)) write_msg('','?m=pay&ac=use&error=1&page='.$page);
	if(is_array($recordids)){
		$db -> query("DELETE FROM `{$db_mymps}payrecord` $where AND id ".create_in($recordids));
		write_msg('','?m=pay&ac=record&success=10');
	}
	if(is_array($useids)){
		$db -> query("DELETE FROM `{$db_mymps}member_record_use` $where AND id ".create_in($useids));
		write_msg('','?m=pay&ac=use&success=11');
	}
	if(!empty($money) && $ac == 'pay'){
		$money=(float)$money;
		$money = ceil($money/$mymps_global['cfg_coin_fee']);
		if($money <= 0) write_msg('','?m=pay&error=17');
		$payid=(int)$_POST['payid'];
		if(!$payid) write_msg('','?m=pay&error=18');
		$payr = $db->getRow("SELECT * FROM {$db_mymps}payapi WHERE payid='$payid' AND isclose=0");
		if(!$payr['payid']) write_msg('','?m=pay&error=18');
		$ddno=$timestamp;
		$pay_type 	 = 'PayToMoney';
		$productname = '金币充值';
		include MYMPS_INC.'/pay.fun.php';
		msetcookie("pay_type",$pay_type,0);
		//返回地址前缀
		$PayReturnUrlQz=$mymps_global['SiteUrl'];
		if($charset=='utf-8'){
			@header('Content-Type: text/html; charset=utf-8');
		}
		include MYMPS_INC.'/payment/'.$payr['paytype'].'/to_pay.php';
	}
}elseif (isset($_GET['is_new'])){
    $money = isset($_REQUEST['money']) ? floatval($_REQUEST['money']) : '';

    if(!empty($money) && $ac == 'pay'){
        if($money <= 0) write_msg('','?m=pay&error=17');
        $payid=(int)$_REQUEST['payid'];
        if(!$payid) write_msg('','?m=pay&error=18');
        $payr = $db->getRow("SELECT * FROM {$db_mymps}payapi WHERE payid='$payid' AND isclose=0");
        if(!$payr['payid']) write_msg('','?m=pay&error=18');
        $ddno=$timestamp;
        $pay_type 	 = 'PayToMoney';
        $productname = $payid == 4 ? '物业缴费' : '金币充值';
        include MYMPS_INC.'/pay.fun.php';
        msetcookie("pay_type",$pay_type,0);
        //返回地址前缀
        $PayReturnUrlQz=$mymps_global['SiteUrl'];
        if($charset=='utf-8'){
            @header('Content-Type: text/html; charset=utf-8');
        }
        include MYMPS_INC.'/payment/'.$payr['paytype'].'/to_pay.php';
    }
}else{
	$begindate	= isset($_GET['begindate']) ? intval(strtotime($_GET['begindate'])) : '';
	$enddate	= isset($_GET['enddate']) ? intval(strtotime($_GET['enddate'])) : '';
	if($ac == 'record'){
		$where .= !empty($begindate) ? " AND posttime >= '$begindate'"  : "";
		$where .= !empty($enddate) 	 ? " AND posttime <= '$enddate'" 	: "";
		$rows_num = mymps_count('payrecord',$where);
		$param	  = setParam(array('m','ac','begindate','enddate'));
		$record   = page1("SELECT * FROM `{$db_mymps}payrecord` $where ORDER BY posttime DESC");
	} elseif($ac == 'use') {
		$where .= !empty($begindate) ? " AND pubtime >= '$begindate'" 	: "";
		$where .= !empty($enddate) 	 ? " AND pubtime <= '$enddate'" 	: "";
		$rows_num = mymps_count('member_record_use',$where);
		$param	  = setParam(array('m','ac','begindate','enddate'));
		$record	  = page1("SELECT * FROM `{$db_mymps}member_record_use` $where ORDER BY pubtime DESC");
	} elseif($ac == 'pay') {
		$opened_pay_api = get_opened_payapi();
	}
	$begindate	= $begindate ? date('Y-m-d',$begindate) : '';
	$enddate	= $enddate ? date('Y-m-d',$enddate) : '';
	$location = location();
	include mymps_tpl('pay_'.$ac);
	unset($record,$rows_num,$param,$begindate,$enddate,$opened_pay_api);
}

function get_opened_payapi(){
	global $db,$db_mymps;
	$paysql	= $db -> query("select payid,paytype,payname FROM  `{$db_mymps}payapi` WHERE isclose=0 order by payid DESC");
	$pays='';
	while($payr = $db->fetchRow($paysql)){
		$pays[$payr['payid']]['payid'] 	 = $payr['payid'];
		$pays[$payr['payid']]['paytype'] = $payr['paytype'];
		$pays[$payr['payid']]['payname'] = $payr['payname'];
	}
	unset($payr,$paysql);
	return $pays;
}
?>