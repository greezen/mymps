<?php if(!defined('IN_MYMPS')) exit('Access Denied');
/*Mymps分类信息系统
官方网站：http://zhideyao.cn*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/uaredirect.js" type="text/javascript"></script>
<script type="text/javascript">uaredirect("<?=$mymps_global['SiteUrl']?>/m/index.php?mod=news");</script>
<title><?=$page_title?></title>
<meta name="keywords" content="<?=$s['keywords']?>" />
<meta name="description" content="<?=$s['description']?>" />
<link rel="shortcut icon" href="<?=$mymps_global['SiteUrl']?>/favicon.ico" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/global.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/style.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/style.head_<?=$mymps_global['head_style']?>.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/news.head_<?=$mymps_global['head_style']?>.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/newstyle.css" />
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/global.js" type="text/javascript"></script>
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/jquery.min.js" type="text/javascript"></script>
</head>

<body class="<?=$mymps_global['cfg_tpl_dir']?> <?=$mymps_global['screen_search']?> bodybg<?=$mymps_global['cfg_tpl_dir']?><?=$mymps_global['bodybg']?>"><div class="bartop floater">
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
<div class="clearfix"></div><script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/jquery.jcarousel.pack.js"></script>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/jquery.flashSlider-1.0.min.js"></script>
<div class="clear"></div>
    <div class="body1000">
<div class="location"><?=$location?></div>
<div class="clear"></div>
<div class="column">
<div class="col3">
<div class="newsfocus">
<div id="slider">
<ul>
                    <?php $focus = mymps_get_focus('news',3); ?>                    <?php if(is_array($focus)){foreach($focus as $mymps) { ?><li><a href="<?=$mymps['url']?>" title="<?=$mymps['words']?>" target="_blank"><img src="<?=$mymps['image']?>" alt="<?=$mymps['words']?>" width="333" height="226" border="0" /></a></li>
<?php }} ?>
</ul>
</div>
<script type="text/javascript">
$(document).ready(function() {
$("#slider").flashSlider();
});
</script>
</div>
<div class="clear"></div>
<div class="newinfo">
<div class="hd">最新发布信息</div>
<div class="bd">
<div id="indextop">
<div id="indextop1">
                            <?php $latest_info = mymps_get_infos(10); ?><?php if(is_array($latest_info)){foreach($latest_info as $mymps) { ?><div class="li"><span class="tm">[<? echo GetTime($mymps['begintime'],'y-m-d'); ?>]</span><span class="tt"><a href="<?=$mymps['uri']?>" title="<?=$mymps['title']?>" target="_blank"  style="<? if($mymps['ifred'] == 1) { ?>color:red;<?php } ?> <? if($mymps['ifbold'] == 1) { ?>font-weight:bold;<?php } ?>"><?=$mymps['title']?></a></span></div>
<?php }} ?>
</div>
<div id="indextop2"></div>
</div>
</div>
<div class="postinfo">
<input type="button" value="马上发布信息" class="footsearch_post" onclick="window.open('<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>')" style="margin-left:43px;">
<input type="button" value="修改/删除信息" class="footsearch_submit" onclick="window.open('<?=$mymps_global['SiteUrl']?>/delinfo.php')">
</div>
</div>
</div>
<div class="col4">
<div class="todaynews">
<ul>
                    <?php $i=1;$top_news	= mymps_get_news(18); ?>                        <?php if(is_array($top_news)){foreach($top_news as $mymps) { ?>                        <? if($i ==1) { ?>
 <div class="head">
 <h1><a href="<?=$mymps['uri']?>" target="_blank" ><?=$mymps['title']?></a></h1>
 <p><? echo cutstr($mymps['content'],254); ?><a href="<?=$mymps['uri']?>" style="margin-left:20px" target="_blank">查看全文>></a></p>
</div>
<?php } else { ?>
<div class="li"><span class="date"><? echo GetTime($mymps['begintime'],'y-m-d'); ?></span><a href="<?=$mymps['caturi']?>" class="catname"><?=$mymps['catname']?></a><a href="<?=$mymps['uri']?>" title="<?=$mymps['title']?>" target="_blank"><?=$mymps['title']?></a></div>
<?php } ?>
                        <?php $i++; ?>                        <?php }} ?>
</ul>
</div>
</div>
<div class="col5">
<div class="top10">
<h3 class="top_tips">热门机构推荐榜</h3>
<ul>
                <?php $i=1; ?>                    <?php $hot_member = mymps_get_members(12,3); ?>                    <?php if(is_array($hot_member)){foreach($hot_member as $mymps) { ?><li class="stitle" id="s_tle_<?=$i?>" onmouseover="show_top10(<?=$i?>);" <? if($i==1) { ?>style="display:none;"<?php } ?>><span><?=$i?></span><a href="<?=$mymps['uri']?>" target="_blank"><? echo cutstr($mymps['tname'],28); ?></a></li>
<li class="ithumb" id="i_img_<?=$i?>" <? if($i >1) { ?>style="display:none;"<?php } ?>>
<div class="ithumb_c">
<p class="i_num"><?=$i?></p>
<p class="i_img"><a href="<?=$mymps['uri']?>" target="_blank"><img src="<?=$mymps_global['SiteUrl']?><?=$mymps['prelogo']?>" width="78" height="58" alt="<?=$mymps['tname']?>" border="0" /></a></p>
<p class="i_tle"><a href="<?=$mymps['uri']?>" target="_blank"><?=$mymps['tname']?></a></p>
</div>
</li>
                    <?php $i++; ?>                    <?php }} ?>
<script type="text/javascript" language="javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/news.js"></script>
</ul>
<p class="top_more"><a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_member_logfile']?>?mod=register&action=store" target="_blank">立即注册商家会员>></a></p>
</div>
</div>
</div>
<div class="clear"></div>
<div class="column2">
<div class="tuwen">
<div class="hd">精彩图文</div>
<div class="bd">
<ul>
                    <?php $image_news = mymps_get_news(7,NULL,1); ?>                    <?php if(is_array($image_news)){foreach($image_news as $mymps) { ?><li><a href="<?=$mymps['uri']?>" target="_blank"><img src="<?=$mymps['imgpath']?>" alt="<?=$mymps['title']?>"/></a><span><a href="<?=$mymps['uri']?>" title="<?=$mymps['title']?>" <? if($mymps['iscommend'] == 1) { ?>style="color:red"<?php } ?>><?=$mymps['title']?></a></span></li>
<?php }} ?>
</ul>
</div>
</div>
</div>
<div class="clear"></div>
<div class="column3">
<div class="news_daohang">
<div class="bd">
<ul>
                    <?php $i=1; ?>                    <?php if(is_array($channel)){foreach($channel as $mymps) { ?><div class="square <? if($i%2 != 0) { ?>fl<?php } else { ?>fr<?php } ?>">
<div class="hc">
<span class="cate"><?=$mymps['catname']?></span>
<span class="more"><a href="<?=$mymps['uri']?>" target="_blank">更多</a></span>
</div>
<div class="bc">
                            <?php if(is_array($mymps['news'])){foreach($mymps['news'] as $w) { ?><div class="li"><span class="title"><a href="<?=$w['uri']?>" title="<?=$w['title']?>" target="_blank" <? if($w['iscommend'] == 1) { ?>style="color:red"<?php } ?>><?=$w['title']?></a></span><span class="time"><? echo GetTime($w['begintime'],'y-m-d'); ?></span></div>
<?php }} ?>
</div>
</div>
                    <?php $i++; ?>                    <?php }} ?>

</ul>
</div>
</div>
<div class="read">
<div class="hd"><span>热门阅读排行</span></div>
<div class="bd">
<ul>
                    <?php $hot_news	= mymps_get_news(20,NULL,NULL,NULL,1); ?>                    <?php if(is_array($hot_news)){foreach($hot_news as $mymps) { ?><div class="li"><a target="_blank" href="<?=$mymps['uri']?>" title="<?=$mymps['title']?>" <? if($mymps['iscommend'] == 1) { ?>style="color:red"<?php } ?>><? echo cutstr($mymps['title'],28); ?></a></div>
<?php }} ?>
</ul>
</div>
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
</body>
</html>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/ppRoll.js"></script>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/newsppRoll.js"></script>