<?php if(!defined('IN_MYMPS')) exit('Access Denied');
/*Mymps分类信息系统
官方网站：http://zhideyao.cn*/

?><?php $index_cat = get_categories_tree(0,'category');
if(is_array($index_cat)){
    foreach($index_cat as $firstcatkey => $firstcatval){
        $incatids = NULL;
        $incatids = get_children($firstcatval['catid']);
        $query	= $db -> query("SELECT a.catname,a.dir_typename,a.id,a.userid,a.catid,a.title,a.ifred,a.ifbold,a.begintime,a.cityid FROM `{$db_mymps}information` AS a WHERE $incatids AND (a.info_level = 1 OR a.info_level = 2) $city_limit ORDER BY a.begintime DESC LIMIT 0,".$tpl_index['foreachinfo']);
        $index_cat[$firstcatval['catid']]['information'] = array();
        while($irow   = $db -> fetchRow($query)){
            $arr['id'] 	      = $irow['id'];
            $arr['title'] 	  = $irow['title'];
            $arr['begintime'] = $irow['begintime'];
            $arr['catname']	  = $irow['catname'];
            $arr['ifred']	  = $irow['ifred'];
            $arr['ifbold']	  = $irow['ifbold'];
            $arr['caturi']	  = Rewrite('category',array('dir_typename'=>$irow['dir_typename'],'catid'=>$irow['catid'],'domain'=>$city['domain']));
            $arr['uri']		  = Rewrite('info',array('id'=>$irow['id'],'cityid'=>$irow['cityid'],'dir_typename'=>$irow['dir_typename']));
            $index_cat[$firstcatval['catid']]['information'][] = $arr;
        }
    }
}
$tpl_index['classic']['cats'] = $tpl_index['classic']['cats'] ? $tpl_index['classic']['cats']+1 : '12'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/uaredirect.js" type="text/javascript"></script>
<script type="text/javascript">uaredirect("<?=$mymps_global['SiteUrl']?>/m/index.php?mod=index&cityid=<?=$cityid?>");</script>

<title><?=$city['title']?></title>
<meta name="keywords" content="<?=$city['keywords']?>"/>
<meta name="description" content="<?=$city['description']?>"/>
<link rel="shortcut icon" href="<?=$mymps_global['SiteUrl']?>/favicon.ico" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/global.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/style.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/style.head_<?=$mymps_global['head_style']?>.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/index.head_<?=$mymps_global['head_style']?>.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/index.css" />
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/global.js" type="text/javascript"></script>
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/jquery.min.js" type="text/javascript"></script>
</head>

<body class="<?=$mymps_global['cfg_tpl_dir']?> <?=$mymps_global['screen_index']?> bodybg<?=$mymps_global['cfg_tpl_dir']?><?=$mymps_global['bodybg']?>"><div class="bartop floater">
<div class="barcenter">
<div class="barleft">
<ul class="barcity"><span><? if($city['cityname']) { ?><?=$city['cityname']?><?php } else { ?>总站<?php } ?></span> [<a href="<?=$mymps_global['SiteUrl']?>/changecity.php">切换分站</a>]</ul> 
<ul class="line"><u></u></ul>
<ul class="barcang"><a href="<?=$mymps_global['SiteUrl']?>/desktop.php" target="_blank" title="点击右键，选择“目标另存为”，将此快捷方式保存到桌面即可">保存到桌面</a></ul>
<ul class="line"><u></u></ul>
<ul class="barpost"><a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>?cityid=<?=$cityid?>&catid=<? echo $catid?$catid:$info['catid']; ?>" rel="nofollow">快速发布信息</a></ul>
<ul class="line"><u></u></ul>
<ul class="bardel"><a href="<?=$mymps_global['SiteUrl']?>/delinfo.php" rel="nofollow">修改/删除信息</a></ul>
<ul class="line"><u></u></ul>
<ul class="barwap"><a href="<?=$mymps_global['SiteUrl']?>/mobile.php" target="_blank">手机浏览</a></ul>
</div>
<div class="barright">
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/javascript.php?part=iflogin&cityid=<?=$city['cityid']?>"></script>
</div>
</div>
</div>
<div class="clear"></div>
<div class="logosearchtel">
<!--顶部横幅广告开始-->
<div id="ad_topbanner"></div>
<!--顶部横幅广告结束-->
<div class="weblogo"><a href="<?=$city['domain']?>"><img src="<?=$mymps_global['SiteUrl']?><?=$mymps_global['SiteLogo']?>" title="<?=$mymps_global['SiteName']?>" border="0"/></a></div>
<div class="postedit">
<a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>?cityid=<?=$cityid?>&catid=<? echo $catid?$catid:$info['catid']; ?>" class="post" rel="nofollow">免费发布信息</a>
</div>
<div class="websearch">
<div class="sch_t_frm">
<form method="get" action="<?=$mymps_global['SiteUrl']?>/search.php?" id="searchForm" target="_blank">
<input name="cityid" value="<?=$city['cityid']?>" type="hidden">
<div class="sch_ct">
<input type="text" class="topsearchinput" name="keywords" id="searchheader" onmouseover="hiddennotice('searchheader');" x-webkit-speech lang="zh-CN"/>
</div>
<div>
<input type="submit" value="搜 索" class="btn-normal"/>
</div>
</form>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="daohang">
<ul>
<li><a href="<?=$city['domain']?>" id="index">首页</a></li>
        <?php $navurl_header = mymps_get_navurl('header',15); ?>        <?php if(is_array($navurl_header)){foreach($navurl_header as $k => $mymps) { ?><li><a <? if($mymps['flag'] == $cat['catid'] || $mymps['flag'] == $cat['parentid']) { ?>class="current"<?php } ?> target="<?=$mymps['target']?>" id="<?=$mymps['flag']?>" href="<? if($mymps['flag'] != 'outlink' && $mymps['flag'] != 'news') { ?><?=$city['domain']?><?php } ?><?=$mymps['url']?>"><font color="<?=$mymps['color']?>"><?=$mymps['title']?></font><sup class="<?=$mymps['ico']?>"></sup></a></li>
<?php }} ?>
</ul>
</div><?php $navurl_head = mymps_get_navurl('head',20); if($navurl_head) { ?>
<div class="subsearch">
<ul><?php $i = 1; ?>    <?php if(is_array($navurl_head)){foreach($navurl_head as $k => $mymps) { ?>    <li class="n<?=$i?>"><a href="<?=$mymps['url']?>" style="color:<?=$mymps['color']?>" target="<?=$mymps['target']?>" title="<?=$mymps['title']?>"><?=$mymps['title']?><sup class="<?=$mymps['ico']?>"></sup></a></li>
    <?php $i = $i+1; ?>    <?php }} ?>
</ul>
</div>
<?php } ?>
<div class="clearfix"></div>
<!--头部通栏广告开始-->
<div id="ad_header"></div>
<!--头部通栏广告结束-->
<div class="clearfix"></div><div class="body1000">
<div class="clear"></div>
<div class="wrapper">
        <div class="focushead">
            <div class="categories">
                <dl id="infomenu">
                <dt class="titup"><b>分类导航</b></dt>
                <dd class="cont">
                <ul>
                <?php $i =1; ?>                <?php if(is_array($index_cat)){foreach($index_cat as $mymps) { ?>                <? if($i < 11) { ?>
                <li>
                <em><a href="<?=$mymps['uri']?>" style="color:<?=$mymps['color']?>" target="_blank"><?=$mymps['catname']?></a></em>
                <dl>
                    <dt><b></b></dt>
                    <dd>
                    <?php if(is_array($mymps['children'])){foreach($mymps['children'] as $w) { ?>                    <a href="<?=$w['uri']?>" style="color:<?=$w['color']?>" target="_blank" title="<?=$w['catname']?>"><?=$w['catname']?></a>
                    <?php }} ?>
                    </dd>
                </dl>
                </li>
                <?php } ?>
                <?php $i=$i+1; ?>                <?php }} ?>
                </ul>
                </dd>
                </dd>
                </dl>
            </div>
            <div class="focustop">
                <div class="portalfocuslide" id="MainPromotionBanner">
                    <div class="container" id="idTransformView">
                        <ul class="slider" id="idSlider">
                            <?php $focus = mymps_get_focus('index',3,$city['cityid']); ?>                            <?php if(is_array($focus)){foreach($focus as $k => $mymps) { ?>                            <li><a href="<?=$mymps['url']?>" target="_blank"><img src="<?=$mymps_global['SiteUrl']?><?=$mymps['image']?>" alt="<?=$mymps['words']?>"/></a></li>
                            <?php }} ?>
                        </ul>
                        <ul class="num" id="idNum">
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                        </ul>
                    </div>
                </div>
                <div class="indextopcourse">
                    <div class="titleleft">
                        <span>首页置顶信息</span>
                    </div>
                    <div class="courseshow">
                        <ul>
                        <?php $index_topinfo = mymps_get_infos($tpl_index['indextopinfo'],NULL,3,NULL,NULL,NULL,NULL,NULL,$cityid); ?>                        <?php if(is_array($index_topinfo)){foreach($index_topinfo as $mymps) { ?>                        <li><span class="showtitle"><a title="<?=$mymps['title']?>" target="_blank" href="<?=$mymps['uri']?>" style="<? if($mymps['ifred'] == 1) { ?>color:red;<?php } if($mymps['ifbold'] == 1) { ?>font-weight:bold;<?php } ?>"><?=$mymps['title']?></a></span></li>
                        <?php }} ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="announcepost">
                <div class="announcenews">
                    <div id="tab1">
                        <ul>
                            <li onmouseover="setTab(1,0)" class="now">网站新闻</li>
                            <li onmouseover="setTab(1,1)">网站公告</li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div id="tablist1">
                        <div class="tablist block news">
                            <ul>
                            <?php $i=1;if(ifplugin('news')) $news = mymps_get_news($tpl_index['news']); ?>                            <?php if(is_array($news)){foreach($news as $mymps) { ?>                            <? if($i == 1) { ?>
                            <h1><a target="_blank" href="<?=$mymps['uri']?>" title="<?=$mymps['title']?>" <? if($mymps['iscommend'] ==1) { ?>style="color:red"<?php } ?>><?=$mymps['title']?></a></h1>
                            <p><?=$mymps['content']?></p> 
                            <?php } else { ?>
                            <li><span class="title"><a target="_blank" href="<?=$mymps['uri']?>" title="<?=$mymps['title']?>" <? if($mymps['iscommend'] ==1) { ?>style="color:red"<?php } ?>><? echo cutstr($mymps['title'],42); ?></a></span><span class="time">[<? echo GetTime($mymps['begintime'],'m-d'); ?>]</span></li>
                            <?php } ?>
                            <?php $i++; ?>                            <?php }} ?>
                            </ul>
                        </div>
                        <div class="tablist none announce">
                            <ul>
                            <?php $announce = mymps_get_announce($tpl_index['announce'],$city['cityid']); ?>                            <?php if(is_array($announce)){foreach($announce as $k => $mymps) { ?>                            <li><span class="announcetitle"><a style="color:<?=$mymps['titlecolor']?>" title="<?=$mymps['title']?>" href="<?=$mymps['uri']?>" target="_blank"><?=$mymps['title']?></a></span><span class="announcetime"><? echo GetTime($mymps['pubdate'],'m-d'); ?></span></li>
                            <?php }} ?>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="courseschool">
                    <a class="postinfo" href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>?cityid=<?=$city['cityid']?>" target="_blank">免费发布信息</a>
                    <a class="postmember" href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_member_logfile']?>?mod=register&action=store&cityid=<?=$city['cityid']?>" target="_blank">免费网上开店</a>
                    </div>
                </div>
            </div>
        </div>
<div class="clearfix"></div>
<div class="infolist">
        <?php $i=1; ?>        <?php if(is_array($index_cat)){foreach($index_cat as $fcat) { ?>        <? if($i < $tpl_index['classic']['cats']) { ?>
        <? if($i%2 != 0) { ?><div id="ad_indexcatad_<?=$fcat['catid']?>"></div><?php } ?>
        <div class="showbox <? if($i%2 != 0) { ?>sleft<?php } else { ?>sright<?php } ?>">
            <div class="hd">
                <div class="cattitle"><? if($fcat['icon']) { ?><img alt="<?=$fcat['catname']?>" src="<?=$mymps_global['SiteUrl']?><?=$fcat['icon']?>" align="absmiddle"/>&nbsp;&nbsp;<?php } ?><?=$fcat['catname']?>信息</div>
                <div class="postinfo"></div>
                <div class="moreinfo"><a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>?catid=<?=$fcat['catid']?>&cityid=<?=$city['cityid']?>" target="_blank">发信息</a> | <a href="<?=$fcat['uri']?>" target="_blank">更多</a></div>
            </div>
            <div class="bd">
                <ul>
                    <?php $t=1; ?>                    <?php if(is_array($fcat['information'])){foreach($fcat['information'] as $info) { ?>                    <li <? if($t%2 != 0) { ?>class="bg_gray"<?php } ?>>
                    <span class="time">[<? echo GetTime($info['begintime'],'m-d'); ?>]</span>
                    <span class="info"><a href="<?=$info['uri']?>" target="_blank" title="<?=$info['title']?>" style="<? if($info[ifred == 1]) { ?>color:red;<?php } ?> <? if($info['ifbold'] == 1) { ?>font-weight:bold;<?php } ?>"><?=$info['title']?></a></span>
                    <span class="catname"><a href="<?=$info['caturi']?>" target="_blank"><?=$info['catname']?></a></span>
                    </li>
                    <?php $t=$t+1; ?>                    <?php }} ?>
                </ul>
            </div>
        </div>
        <? if($i%2 == 0) { ?><div id="ad_indexcatad_<?=$fcat['catid']?>"></div><?php } ?>
        <?php } ?>
        <?php $i++; ?>        <?php }} ?>
</div>
<div class="clearfix"></div>
        <?php $members = mymps_get_members(!$cityid ? 14 : NULL,NULL,NULL,NULL,2,NULL,NULL,$cityid); ?>        <? if($members) { ?>
<div class="shoplist">
<div class="intershop">
<div class="hd">
<span class="more"><a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_member_logfile']?>?mod=register&action=store&cityid=<?=$city['cityid']?>" target="_blank"><img src="<?=$mymps_global['SiteUrl']?>/template/default/images/index/ruzhu.gif"></a> <a href="<?=$about['yp_uri']?>" target="_blank"><img src="<?=$mymps_global['SiteUrl']?>/template/default/images/index/gdsj.gif"></a>
</span>
            <span style="float:right;">
            <?php $shopclass = get_corp_tree(0,'corp'); ?>            <?php $i=1; ?>            <?php if(is_array($shopclass)){foreach($shopclass as $mymps) { ?>            <? if($i < 9) { ?><a href="<?=$mymps['uri']?>" target="_blank"><?=$mymps['corpname']?></a><?php } ?>
            <?php $i++; ?>            <?php }} ?>
            </span>
</div>
<div id="shop">
<div class="bd" id="shop1">
        <?php if(is_array($members)){foreach($members as $mymps) { ?><li class="item"><a href="<?=$mymps['uri']?>" target="_blank" ><img src="<?=$mymps_global['SiteUrl']?><?=$mymps['prelogo']?>"  alt="<?=$mymps['tname']?>"/></a> <span class="title"><a href="<?=$mymps['uri']?>" target="_blank"><? echo cutstr($mymps['tname'],16); ?></a></span><span  class="sale">店主:  <?=$mymps['userid']?></span></li>
        <?php }} ?>
 </div>
</div>
</div>
</div>
<div class="clear"></div>
<?php } ?><?php if(ifplugin('goods')){$goods = mymps_get_goods($tpl_index['goods'],1,NULL,NULL,NULL,NULL,$city['cityid']); ?><div class="goods">
<div class="hd">
<div class="span">商品网购</div>
<div class="more"><a href="<?=$city['domain']?>goods.php" target="_blank">更多</a></div>
</div>
<div class="bd">
<ul>
                <?php if(is_array($goods)){foreach($goods as $mymps) { ?><li>
<a href="<?=$mymps['uri']?>"  target=_blank><img src="<?=$mymps_global['SiteUrl']?>/<?=$mymps['pre_picture']?>" title="<?=$mymps['goodsname']?>"/>
<h3><?=$mymps['goodsname']?></h3>
</a>
<span class="price"><?=$mymps['nowprice']?></span>
</li>
                <?php }} ?>
              	</ul>
</div>
</div>
<div class="clear"></div>
<?php } ?>
        <?php if(ifplugin('group')){require_once MYMPS_ROOT.'/plugin/group/include/functions.php';$groups = mymps_get_groups(3,NULL,$city['cityid']);$groupclass = get_group_class(); ?><div class="group">
<div class="hd">
<div class="span">最新团购</div>
<div class="more">
        <?php if(is_array($groupclass)){foreach($groupclass as $mymps) { ?><a href="<?=$mymps['cate_uri']?>" target="_blank"><?=$mymps['cate_name']?></a>
        <?php }} ?>
<a href="<?=$city['domain']?>group.php" target="_blank" class="moree">更多</a>
</div>
</div>
<div class="bd">
        <?php if(is_array($groups)){foreach($groups as $mymps) { ?><ul>
<div class="img"><a href="<?=$mymps['uri']?>"><img src="<?=$mymps_global['SiteUrl']?><?=$mymps['pre_picture']?>"></a></div>
<div class="detail">
<span class="name">活动名称：<a href="<?=$mymps['uri']?>" target="_blank"><?=$mymps['gname']?></a></span>
<span>报名截止：<font color="#404040"><? echo GetTime($mymps['enddate'],'Y-m-d'); ?></font></span>
<span>集合时间：<font color="#404040"><? echo GetTime($mymps['meetdate'],'Y-m-d'); ?></font></span>
<span>活动地址：<font color="#404040"><?=$mymps['gaddress']?></font></span>
</div>
</ul>
<?php }} ?>
</div>
</div>
<div class="clear"></div>
<?php } ?>
        <?php $telephone = mymps_get_telephone($tpl_index['telephone'],$city['cityid']); ?>    	<? if($telephone) { ?>
<div class="telephone">
<div class="hd"><span class="hdleft">便民电话</span><span class="hdright">以下便民电话招商：<font color="red">300/年</font>，变色或加粗加100元。(可新增行业类别，每类别限一家，先占先得！)加盟电话：<font color="green"><?=$mymps_global['SiteTel']?></font></span></div>
<div class="clearfix"></div>
<div class="bd">
<ul>
                <?php if(is_array($telephone)){foreach($telephone as $k => $mymps) { ?><li><font style="color:<?=$mymps['color']?>;<? if($mymps['if_bold'] == 1) { ?>font-weight:bold<?php } ?>"><?=$mymps['telname']?><br /><?=$mymps['telnumber']?></font></li>
                    <?php }} ?>
</ul>
</div>
</div>
<div class="clear"></div>
<?php } ?>
        <?php $lifebox = mymps_get_lifebox($tpl_index['lifebox'],$city['cityid']); ?>        <? if($lifebox) { ?>
        <div class="lifebox">
        生活助手：
            <?php if(is_array($lifebox)){foreach($lifebox as $k => $mymps) { ?>            <a rel="nofollow" href="<?=$mymps_global['SiteUrl']?>/lifebox.php?id=<?=$mymps['id']?>" target="_blank"><?=$mymps['lifename']?></a>
            <?php }} ?>
        </div>
        <div class="clear"></div>
        <?php } ?>
<div class="flink">
        <div class="hd"><span class="hd1">友情链接</span><span class="hd2"><a href="<?=$about['friendlink_uri']?>">我要申请</a></span></div>
        <div class="bd">
<? if($friendlink['img']) { ?>
<ul class="image"><?php if(is_array($friendlink['img'])){foreach($friendlink['img'] as $mymps) { ?><li><a href="<?=$mymps['url']?>" target="_blank" title="<?=$mymps['name']?>"><img src="<?=$mymps['logo']?>" border="0" /></a></li>
<?php }} ?>
</ul>
<?php } ?>
        <? if($friendlink['txt']) { ?>
<ul class="text"><?php if(is_array($friendlink['txt'])){foreach($friendlink['txt'] as $mymps) { ?><li><a href="<?=$mymps['url']?>" target="_blank" title="<?=$mymps['name']?>"><?=$mymps['name']?></a></li>
<?php }} ?>
<li><a href="http://zhideyao.cn" target="_blank">值得要交易平台</a></li>
</ul>
        <?php } ?>
</div>
</div>
<div class="clear"></div><div class="footsearch <?=$mymps_global['head_style']?>">
<ul>
<form method="get" action="<?=$mymps_global['SiteUrl']?>/search.php?" name="footsearch" target="_blank">
<input name="cityid" value="<?=$city['cityid']?>" type="hidden">
<input name="mod" value="information" type="hidden">
<input name="keywords" type="text" class="footsearch_input" id="searchfooter" onmouseover="hiddennotice('searchfooter');" x-webkit-speech lang="zh-CN">
<input type="submit" value="信息快速搜索" class="footsearch_submit">
<input type="button" onclick="window.open('<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>?cityid=<?=$city['cityid']?>')" class="footsearch_post" value="免费发布信息">
</form>
</ul>
</div>
<div class="clear"></div>
<!-- 页尾通栏广告开始-->
<div id="ad_footerbanner"></div>
<!-- 页尾通栏广告结束-->
<!--广告处理部分开始-->
<? if($advertisement['type']['floatad'] || $advertisement['type']['couplead']) { ?>
<div align="left"  style="clear: both;">
    <script src="<?=$mymps_global['SiteUrl']?>/template/global/floatadv.js" type="text/javascript"></script>
<? if($advertisement['type']['couplead']) { ?>
    <script type="text/javascript">
<?=$adveritems[$advertisement['type']['couplead']['0']]?>theFloaters.play();
    </script>
    <?php } ?>
    <? if($advertisement['type']['floatad']) { ?>
    <script type="text/javascript">
        <?=$adveritems[$advertisement['type']['floatad']['0']]?>theFloaters.play();
    </script>
    <?php } ?>
</div>
<?php } ?>
<div style="display: none" id="ad_none">
<!--头部通栏广告-->
<? if($advertisement['type']['headerbanner']) { ?>
<div class="header" id="ad_header_none"><?php $countheaderbanner = count($advertisement['type']['headerbanner']);$i=1; ?><?php if(is_array($advertisement['type']['headerbanner'])){foreach($advertisement['type']['headerbanner'] as $mymps) { if($adveritems[$mymps]) { ?><div class="headerbanner" <? if($countheaderbanner == $i) { ?>style="margin-right:0;"<?php } ?>><?=$adveritems[$mymps]?></div><?php } ?><?php $i=$i+1; ?><?php }} ?>
</div>
<?php } ?>
<!--首页分类间广告--><?php if(is_array($advertisement['type']['indexcatad'])){foreach($advertisement['type']['indexcatad'] as $k => $mymps) { ?><div class="indexcatad" id="ad_indexcatad_<?=$k?>_none"><?=$adveritems[$mymps['0']]?></div>
<?php }} ?>
<!--栏目信息列表间广告-->
<? if($advertisement['type']['interlistad']['top']) { ?>
<div id="ad_interlistad_top_none">
<ul class="interlistdiv"><?php if(is_array($advertisement['type']['interlistad']['top'])){foreach($advertisement['type']['interlistad']['top'] as $mymps) { if($adveritems[$mymps]) { ?><li class="hover"><?=$adveritems[$mymps]?></li><?php } ?>
<?php }} ?>
</ul>
</div>
<?php } if($advertisement['type']['interlistad']['bottom']) { ?>
<div id="ad_interlistad_bottom_none">
<ul class="interlistdiv"><?php if(is_array($advertisement['type']['interlistad']['bottom'])){foreach($advertisement['type']['interlistad']['bottom'] as $mymps) { if($adveritems[$mymps]) { ?><li class="hover"><?=$adveritems[$mymps]?></li><?php } ?>
<?php }} ?>
</ul>
</div>
<?php } ?>
<!--栏目侧边广告-->
<? if($advertisement['type']['intercatad']) { ?>
<div class="intercatdiv" id="ad_intercatdiv_none"><?php if(is_array($advertisement['type']['intercatad'])){foreach($advertisement['type']['intercatad'] as $mymps) { ?><div class="intercatad"><?=$adveritems[$mymps]?></div>
<?php }} ?>
</div>
<?php } if($advertisement['type']['topbanner']) { ?>
<div class="topbanner" id="ad_topbanner_none"><?php if(is_array($advertisement['type']['topbanner'])){foreach($advertisement['type']['topbanner'] as $mymps) { ?><div class="topbannerad"><?=$adveritems[$mymps]?></div>
<?php }} ?>
</div>
<?php } if($advertisement['type']['footerbanner']) { ?>
<div class="footerbanner" id="ad_footerbanner_none"><?php if(is_array($advertisement['type']['footerbanner'])){foreach($advertisement['type']['footerbanner'] as $mymps) { ?><div class="footerbannerad"><?=$adveritems[$mymps]?></div>
<?php }} ?>
</div>
<?php } ?>
</div>
<!--广告处理部分结束-->
<div class="footabout">
<a href="http://zhideyao.cn/" target="_blank">值得要交易平台</a><?php $navurl_foot = mymps_get_navurl('foot',30); ?><?php $counturlnav = count($navurl_foot);$i=1; ?>    <?php if(is_array($navurl_foot)){foreach($navurl_foot as $k => $mymps) { ?><a <? if($counturlnav == $i) { ?>class="backnone"<?php } ?> href="<?=$mymps['url']?>" style="color:<?=$mymps['color']?>" target="<?=$mymps['target']?>"><?=$mymps['title']?><sup class="<?=$mymps['ico']?>"></sup></a><?php $i=$i+1; ?>    <?php }} ?>
</div>
<div class="debuginfo none_<?=$mymps_mymps['debuginfo']?>">
Powered by <i><strong><a href="http://zhideyao.cn" target="_blank">Mymps</a></strong></i> <em><a href="http://zhideyao.cn" target="_blank"><?=MPS_VERSION?></a></em> <?=$mymps_global['SiteStat']?> 
<? if($cachetime) { ?>
This page is cached at <? echo GetTime($timestamp,'Y-m-d H:i:s'); ?><?php } else { ?><?php $mtime = explode(' ', microtime());$totaltime = number_format(($mtime['1'] + $mtime['0'] - $mymps_starttime), 6); echo 'Processed in '.$totaltime.' second(s) , '.$db->query_num.' queries'; ?><?php } ?>
</div>
<div class="footcopyright">
&copy; <?=$mymps_global['SiteName']?> <a href="http://www.miibeian.gov.cn" target="_blank"><?=$mymps_global['SiteBeian']?></a>
</div>
<p id="back-to-top"><a href="#top"><span></span></a></p>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/addiv.js"></script>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/selectoption.js"></script>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/scrolltop.js"></script></div>
</div>
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/slide_portal.js" type="text/javascript"></script>
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/setTab.js" type="text/javascript"></script>
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/category.js" type="text/javascript"></script>
</body>
</html>