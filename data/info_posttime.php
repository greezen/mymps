<?php
if (!defined('IN_MYMPS'))
{
    die('FORBIDDEN');
}
$info_posttime = array();
/*信息检索的发布时间下拉框选项*/
//注意单位为天，一周则为7，一个月则为30，以此类推
$info_posttime[0] = '不限';
$info_posttime[3] = '3天内';
$info_posttime[7] = '一周内';
$info_posttime[30] = '一个月以内';
$info_posttime[90] = '三个月以内';
?>