<?php

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
$catid = isset( $catid ) ? intval( $catid ) : "";
$cityid = isset( $cityid ) ? intval( $cityid ) : "";
$areaid = isset( $areaid ) ? intval( $areaid ) : "";
$streetid = isset( $streetid ) ? intval( $streetid ) : "";
$page = isset( $page ) ? $page : 1;
if ( $catid )
{
    $corp = $db->getrow( "SELECT * FROM `".$db_mymps."corp` WHERE corpid = '{$catid}'" );
    if ( !$corp )
    {
        errormsg( "该机构分类不存在！" );
    }
    $ypcategory = get_corp_tree( $corp['parentid'] ? $corp['parentid'] : $catid, "corp" );
    $parentcats = get_parent_cats( "corp", $catid );
    $parentcats = is_array( $parentcats ) ? array_reverse( $parentcats ) : "";
    if ( !$city['cityid'] )
    {
        $hotcities = get_hot_cities( );
    }
    $where = " WHERE a.status = '1' AND a.if_corp = '1'  AND b.catid IN(".get_corp_children( $catid ).") ";
    $where .= !$cityid ? "" : " AND a.cityid = '".$cityid."'";
    $where .= !$areaid ? "" : " AND a.areaid = '".$areaid."'";
    $where .= !$streetid ? "" : " AND a.streetid = '".$streetid."'";
    $perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
    $param = setparams( array( "mod", "catid", "areaid", "streetid", "cityid" ) );
    $sql = "SELECT a.* FROM `".$db_mymps."member` AS a LEFT JOIN `{$db_mymps}member_category` AS b ON a.userid = b.userid {$where} ORDER BY a.levelid DESC,a.id DESC";
    $count_sql = "SELECT COUNT(b.id) FROM `".$db_mymps."member` AS a LEFT JOIN {$db_mymps}member_category AS b ON a.userid = b.userid {$where}";
    $rows_num = $db->getone( $count_sql );
    $totalpage = ceil( $rows_num / $perpage );
    $num = intval( $page - 1 ) * $perpage;
    $page1 = page1( $sql, $perpage );
    foreach ( $page1 as $k => $val )
    {
        $arr['id'] = $val['id'];
        $arr['userid'] = $val['userid'];
        $arr['per_certify'] = $val['per_certify'];
        $arr['com_certify'] = $val['com_certify'];
        $arr['jointime'] = $val['jointime'];
        $arr['credits'] = $val['credits'];
        $arr['credit'] = $val['credit'];
        $arr['if_list'] = $val['if_list'];
        $arr['prelogo'] = $val['prelogo'] ? $val['prelogo'] : "/images/nophoto.gif";
        $arr['tname'] = highlight( $val['tname'] ? $val['tname'] : $val['userid'], $keywords );
        $arr['address'] = $val['address'] ? $val['address'] : $val['busway'] ? $val['busway'] : "暂无地址";
        $arr['levelid'] = $val['levelid'];
        $arr['tel'] = $val['tel'] ? $val['tel'] : "暂无电话";
        $member[] = $arr;
    }
    $pageview = pager( );
    include( mymps_tpl( "corp_list" ) );
}
else
{
    $ypcategory = get_corp_tree( 0, "corp" );
    include( mymps_tpl( "corp_all" ) );
}
?>
