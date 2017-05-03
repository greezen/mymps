<?php
if (!defined('IN_MYMPS'))
{
    die('FORBIDDEN');
}
/*信息发布的持续时间下拉框选项*/
//注意单位为天，一周则为7，一个月则为30，以此类推
//一般情况下，请保保持默认，勿修改
$info_lasttime = array();

$info_lasttime[0] = '长期有效';//该设置为信息发布或修改时是否允许长期有效，你可以根据自己的情况删除或保留，请不要修改

$info_lasttime[7] 	= '一周';
$info_lasttime[30] 	= '一个月';
$info_lasttime[60] 	= '二个月';
$info_lasttime[365] = '一年';


//以下不要修改
function GetInfoLastTime($lasttime='',$formname='endtime',$type='pc'){
	global $info_lasttime;
	$info_lasttime_form = "<select name='$formname' id='$formname' ".($type == 'pc'? 'class="input" require="true" datatype="limit"':'')." msg=\"请选择信息的有效期限\">";
	$info_lasttime_form .= "<option value=''>请选择有效期限</option>";
	foreach($info_lasttime as $k=>$v){
	 	if($k==$lasttime&&$k!='') $info_lasttime_form .= "<option value='$k' selected>$v</option>\r\n";
	 	else $info_lasttime_form .= "<option value='$k'>$v</option>\r\n";
	}
	$info_lasttime_form .= "</select>\r\n";
	return $info_lasttime_form;
}

?>