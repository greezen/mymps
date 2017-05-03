<?php
$element = array(

	'信息'=>array(
			'style'=>'info',
			'url'=>'info.php?part=all',
			'table'=>'information',
			'type'=>''
			),
	
	'点评'=>array(
			'style'=>'com',
			'url'=>'comment.php',
			'table'=>'member_comment',
			'type'=>'',
			'where'=>' AND commentlevel = 1'
			),
			
	'短消息'=>array(
			'style'=>'pm',
			'url'=>'pm.php',
			'table'=>'member_pm',
			'type'=>'',
			'where'=>' AND if_read = 0'
			),
			
	'账户'=>array(
			'style'=>'incomes',
			'url'=>'bank.php',
			'table'=>'member',
			'type'=>'money'
			)
			
);

if($if_corp != 1){
	unset($element['留言']);
	unset($element['点评']);
};

function member_get_count()
{
	global $element,$s_uid,$money_own,$pm_total;
	foreach ($element as $k =>$value){
		if(empty($value[type])){
			$and = $value[where] ? $value[where] : ''; 
			if($value[style] == 'pm'){
				$mymps_member_count .= "<li class=\"".$value[style]."\"><a href=\"".$value[url]."\">".$k."(".$pm_total.")</a></li>";
			} else {
				$mymps_member_count .= "<li class=\"".$value[style]."\"><a href=\"".$value[url]."\">".$k."(".mymps_count($value[table],"WHERE userid = '$s_uid'$and").")</a></li>";
			}
		} else {
			$mymps_member_count .= "<li class=\"".$value[style]."\"><a href=\"".$value[url]."\">".$k."(".$money_own.")</a></li>";
		}
	}
	return $mymps_member_count;
}
?>