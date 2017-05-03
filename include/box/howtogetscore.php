<?php
!defined('IN_MYMPS') && exit('FORBIDDEN');
require_once MYMPS_DATA."/config.db.php";
require_once MYMPS_INC."/db.class.php";
require_once MYMPS_INC."/cache.fun.php";

/*积分变化参数配置*/
$score_change = get_credit_score();
$array = array(
		'注册成功'=>'register',
		'登录签到'=>'login',
		'发布分类信息'=>'information',
		'营业执照认证'=>'com_certify',
		'身份证认证'=>'per_certify'
		
);

@include MYMPS_DATA.'/caches/plugin.php';
$pluginsettings = $data;
unset($data);

if(is_array($pluginsettings)){
	foreach($pluginsettings as $k => $v){
		if($v['disable'] != 1 && $v['flag'] != 'news'){
			$array['发布'.$v['name']] = $v['flag'];
		}
	}
}

include MYMPS_ROOT.'/template/box/howtogetscore.html';
$score_change=$array=$pluginsettings=NULL;
?>