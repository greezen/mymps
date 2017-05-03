<?php

function get_root_channel( )
{
    global $db;
    global $db_mymps;
    $query = $db->query( "SELECT catid,catname FROM `".$db_mymps."channel` WHERE parentid = '0' AND if_view = '2' ORDER BY catorder ASC" );
    while ( $queryrow = $db->fetchrow( $query ) )
    {
        $_array['catid'] = $queryrow['catid'];
        $_array['catname'] = $queryrow['catname'];
        $channel[] = $_array;
    }
    return $channel;
}

if ( CURSCRIPT != "wap" )
{
    exit( "FORBIDDEN" );
}
$id = isset( $id ) ? intval( $id ) : "";
$catid = isset( $catid ) ? intval( $catid ) : "";
$page = isset( $page ) ? intval( $page ) : 1;
if ( $id )
{
    if ( !$id )
    {
        errormsg( "新闻ID不能为空！" );
    }
    if ( !( $news = $db->getrow( "SELECT * FROM ".$db_mymps."news WHERE id = '{$id}'" ) ) )
    {
        errormsg( "当前新闻不存在或者已经被删除！" );
    }
    $db->query( "UPDATE `".$db_mymps."news` SET hit = hit +1;" );
    $news['catname'] = $db->getone( "SELECT catname FROM `".$db_mymps."channel` WHERE catid = '{$news['catid']}'" );
    $parentcats = is_array( $parentcats ) ? array_reverse( $parentcats ) : "";
    $parentcats = get_parent_cats( "channel", $news['catid'] );
    include( mymps_tpl( "news" ) );
}
else if ( $catid )
{
    $cat = get_cat_info( $catid, "channel" );
    if ( !$cat )
    {
        errormsg( "您所指定的新闻栏目不存在或者已经删除！" );
    }
    $rootchannel = get_categories_tree( $catid, "channel" );
    $cat_children = get_cat_children( $catid, "channel" );
    $perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
    $param = setparams( array( "mod", "catid" ) );
    $rows_num = $db->getone( "SELECT COUNT(*) FROM `".$db_mymps."news` AS a WHERE catid IN({$cat_children})" );
    $totalpage = ceil( $rows_num / $perpage );
    $num = intval( $page - 1 ) * $perpage;
    $page1 = page1( "SELECT * FROM ".$db_mymps."news WHERE catid IN({$cat_children}) ORDER BY id DESC", $perpage );
    foreach ( $page1 as $kr => $r )
    {
        $arr['begintime'] = $r['begintime'];
        $arr['hit'] = $r['hit'];
        $arr['title'] = $r['title'];
        $arr['iscommend'] = $r['iscommend'];
        $arr['content'] = clear_html( $r['content'] );
        $arr['uri'] = $r['isjump'] ? $r['redirect_url'] : "index.php?mod=news&id=".$r['id']."&cityid=".$cityid;
        $arr['imgpath'] = $r['imgpath'];
        $news[] = $arr;
    }
    $pageview = pager( );
    $parentcats = get_parent_cats( "channel", $catid );
    $parentcats = is_array( $parentcats ) ? array_reverse( $parentcats ) : "";
    include( mymps_tpl( "news_list" ) );
}
else
{
    $rootchannel = get_root_channel( );
    $perpage = $mobile_settings['mobiletopicperpage'] ? $mobile_settings['mobiletopicperpage'] : 10;
    $param = setparams( array( "mod" ) );
    $rows_num = $db->getone( "SELECT COUNT(*) FROM `".$db_mymps."news` AS a ORDER BY id DESC" );
    $totalpage = ceil( $rows_num / $perpage );
    $num = intval( $page - 1 ) * $perpage;
    $page1 = page1( "SELECT * FROM ".$db_mymps."news ORDER BY id DESC", $perpage );
    foreach ( $page1 as $kr => $r )
    {
        $arr['begintime'] = $r['begintime'];
        $arr['hit'] = $r['hit'];
        $arr['title'] = $r['title'];
        $arr['iscommend'] = $r['iscommend'];
        $arr['content'] = clear_html( $r['content'] );
        $arr['uri'] = $r['isjump'] ? $r['redirect_url'] : "index.php?mod=news&id=".$r['id']."&cityid=".$cityid;
        $arr['imgpath'] = $r['imgpath'];
        $news[] = $arr;
    }
    $pageview = pager( );
    include( mymps_tpl( "news_index" ) );
}
?>
