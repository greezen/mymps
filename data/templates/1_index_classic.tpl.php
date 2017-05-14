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
    <link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/style.head_<?=$mymps_global['head_style']?>.css" />
    <link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/index.head_<?=$mymps_global['head_style']?>.css" />
    <link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/index.css" />
    <script src="<?=$mymps_global['SiteUrl']?>/template/default/js/global.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/jquery1.42.min.js">
    </script><script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/jquery.SuperSlide.2.1.1.js"></script>

</head>

<body class="<?=$mymps_global['cfg_tpl_dir']?> <?=$mymps_global['screen_index']?> bodybg<?=$mymps_global['cfg_tpl_dir']?><?=$mymps_global['bodybg']?>"><link href="<?=$mymps_global['SiteUrl']?>/template/default/css/home.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.current{
background-color: #00AFF0;
}
</style>
<div class="header">
<div class="head">
<div class="head_top">
<ul>
<a href="<?=$mymps_global['SiteUrl']?>/desktop.php" target="_blank" title="点击右键，选择“目标另存为”，将此快捷方式保存到桌面即可">保存到桌面</a>　
</ul>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/javascript.php?part=iflogin&cityid=<?=$city['cityid']?>"></script>
</div>
<div class="logo"><img src="<?=$mymps_global['SiteUrl']?><?=$mymps_global['SiteLogo']?>" title="<?=$mymps_global['SiteName']?>" width="180" height="70" /></div>
<div class="area">
<a href="<?=$mymps_global['SiteUrl']?>/changecity.php">
<? if($city['cityname']) { ?><h1><?=$city['cityname']?></h1><?php } else { ?><h1>总站</h1><?php } ?>
<span><img src="<?=$mymps_global['SiteUrl']?>/template/default/images/index/up.png" width="20" height="20" /></span>
</a>
</div>
<div class="search">
<form method="get" action="<?=$mymps_global['SiteUrl']?>/search.php?" id="searchForm" target="_blank">
<input name="cityid" value="<?=$city['cityid']?>" type="hidden"/>
<input style="padding: 0;" type="text" class="ser_txt" name="keywords" id="searchheader" onmouseover="hiddennotice('searchheader');" x-webkit-speech lang="zh-CN" />
<input type="submit" name="button" id="button" value="提交"  class="ser_btn"/>
</form>
</div>
<div class="head_btn">
<h1><a href="<?=$mymps_global['SiteUrl']?>/delinfo.php">修改/删除信息</a></h1>
<h2><a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>?cityid=<?=$cityid?>&catid=<? echo $catid?$catid:$info['catid']; ?>">免费发布信息</a></h2>

</div>

</div>
<div class="nav">
<ul>
<li><a href="<?=$city['domain']?>" id="index" <? if(empty($cat['catid'])) { ?>class="current"<?php } ?>>首页</a></li><?php $navurl_header = mymps_get_navurl('header',9); ?><?php if(is_array($navurl_header)){foreach($navurl_header as $k => $mymps) { ?><li><a <? if($mymps['flag'] == $cat['catid'] || $mymps['flag'] == $cat['parentid']) { ?>class="current"<?php } ?> target="<?=$mymps['target']?>" id="<?=$mymps['flag']?>" href="<? if($mymps['flag'] != 'outlink' && $mymps['flag'] != 'news') { ?><?=$city['domain']?><?php } ?><?=$mymps['url']?>"><font color="<?=$mymps['color']?>"><?=$mymps['title']?></font><sup class="<?=$mymps['ico']?>"></sup></a></li>
<?php }} ?>
<li id="mob"><a href="#" >手机APP下载</a></li>
</ul>

</div>
</div>


<link href="/template/default/css/adanimated.css" rel="stylesheet" type="text/css" />
<div id="dialogBg"></div>
<div id="dialog" class="animated">
<div style="height:18px"></div>
<div class="dialogTop" style="position:absolute;height:8px;right:5px; top:-10px;">

<a href="javascript:;" class="claseDialogBtn" ><strong><b>×</b></strong></a>
</div>
<div class="index_view_ad" id="ad_view"></div>
</div>

<script type="text/javascript">
$('#mob').click(function(){
$('#dialogBg').fadeIn(300);
$('#dialog').removeAttr('class').addClass('animated bounceIn').fadeIn();
$('#ad_view').html("<div style='text-align:center'><img src='/images/QRcodexx.png' alt='' style='text-align:center'/></div><br /><br /><div style='text-align:center'>请用手机扫描二维码 <a href='/app/download.php' target='_blank'>下载APP</a></div>");
    });
    //关闭弹窗
$('.dialogTop').click(function(){
$('#dialogBg').fadeOut(300,function(){
$('#dialog').addClass('bounceOutUp').fadeOut();
});
});





</script><div class="index_main">
    <div class="index_div">
        <div class="focusBox" >
            <ul class="pic">
                <?php $focus = mymps_get_focus('index',3,$city['cityid']); ?>                <?php if(is_array($focus)){foreach($focus as $k => $mymps) { ?>                <li><a href="<?=$mymps['url']?>" target="_blank"><img src="<?=$mymps_global['SiteUrl']?><?=$mymps['image']?>" alt="<?=$mymps['words']?>"/></a></li>
                <?php }} ?>
            </ul>

            <ul class="hd">
                <?php if(is_array($focus)){foreach($focus as $k => $mymps) { ?>                <li></li>
                <?php }} ?>
            </ul>
        </div>
        <script type="text/javascript">
            /*鼠标移过，左右按钮显示*/

            /*SuperSlide图片切换*/
            jQuery(".focusBox").slide({ mainCell:".pic",effect:"left", autoPlay:true, delayTime:600, trigger:"click"});
        </script>
        <div class="top_news">
            <ul>
                <?php $index_topinfo = mymps_get_infos($tpl_index['indextopinfo'],NULL,3,NULL,NULL,NULL,NULL,NULL,$cityid); ?>                <?php if(is_array($index_topinfo)){foreach($index_topinfo as $mymps) { ?>                <li><span class="showtitle"><a title="<?=$mymps['title']?>" target="_blank" href="<?=$mymps['uri']?>" style="<? if($mymps['ifred'] == 1) { ?>color:red;<?php } if($mymps['ifbold'] == 1) { ?>font-weight:bold;<?php } ?>"><? echo mb_substr($mymps['title'],0,16,'gbk'); ?></a></span></li>
                <?php }} ?>
            </ul>
        </div>
        <div class="slideTxtBox">
            <div class="hd">
                <ul><li>网站新闻</li><li>网站公告</li></ul>
            </div>
            <div class="bd">
                <ul >
                    <div id="content">
                        <?php if(ifplugin('news')) $news = mymps_get_news($tpl_index['news']); ?>                        <?php if(is_array($news)){foreach($news as $mymps) { ?>                        <li><span class="date"><? echo GetTime($mymps['begintime'],'m-d'); ?></span><a target="_blank" href="<?=$mymps['uri']?>" title="<?=$mymps['title']?>" <? if($mymps['iscommend'] ==1) { ?>style="color:red"<?php } ?>><? echo mb_substr($mymps['title'],0,13,'gbk'); ?></a></li>
                        <?php }} ?>
                    </div>

                </ul>

                <ul>  <div id="content">
                    <?php $announce = mymps_get_announce($tpl_index['announce'],$city['cityid']); ?>                    <?php if(is_array($announce)){foreach($announce as $k => $mymps) { ?>                    <li><span class="date"><? echo GetTime($mymps['pubdate'],'m-d'); ?></span><a style="color:<?=$mymps['titlecolor']?>" title="<?=$mymps['title']?>" href="<?=$mymps['uri']?>" target="_blank" ><? echo mb_substr($mymps['title'],0,14,'gbk'); ?></a></li>
                    <?php }} ?>
                </div>

                </ul>

            </div>
        </div>
        <script type="text/javascript">jQuery(".slideTxtBox").slide();</script>
        <div class="index_btn">
            <h1><a href="#">免费发布信息</a></h1>
            <h2><a href="#">免费网上开店</a></h2>
        </div>

    </div>

    <?php $i=1; ?>    <?php if(is_array($index_cat)){foreach($index_cat as $fcat) { ?>    <? if($i < $tpl_index['classic']['cats']) { ?>
    <div class="index_list <? if($i%2 == 0) { ?>iright<?php } ?>">
        <div class="index_list_title">
            <? if($fcat['icon']) { ?><img alt="<?=$fcat['catname']?>" src="<?=$mymps_global['SiteUrl']?><?=$fcat['icon']?>" align="absmiddle" width="48" height="48" /><?php } ?>
            <h1><?=$fcat['catname']?></h1>
            <h2><a href="<?=$fcat['uri']?>" target="_blank">更多>></a></h2>
            <h3><a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>?catid=<?=$fcat['catid']?>&cityid=<?=$city['cityid']?>" target="_blank">发信息</a></h3>
        </div>
        <div class="index_list_type">
            <ul>
                <?php if(is_array($fcat['children'])){foreach($fcat['children'] as $child) { ?>                <li><a href="<?=$child['uri']?>"><?=$child['catname']?></a></li>
                <?php }} ?>
            </ul>
        </div>
        <div class="index_list_con">
            <ul>
                <?php if(is_array($fcat['information'])){foreach($fcat['information'] as $info) { ?>                <li > <span class="itime">[<? echo GetTime($info['begintime'],'m-d'); ?>]</span>
                    <span class="info"><a href="<?=$info['uri']?>" title="<?=$info['title']?>"><?=$info['title']?></a></span>
                </li>
                <?php }} ?>
            </ul>

        </div>
    </div>
    <?php } ?>
    <?php $i++; ?>    <?php }} ?>
    <?php $telephone = mymps_get_telephone($tpl_index['telephone'],$city['cityid']); ?>    <div class="bbdh">
        <div class="cdiv">
            <div class="index_title"><h1>便民电话</h1><h2><span>以下便民电话招商：300/年，变色或加粗加100元。(可新增行业类别，每类别限一家，先占先得！)</span>　加盟电话：<?=$mymps_global['SiteTel']?></h2></div>
            <ul>
                <?php if(is_array($telephone)){foreach($telephone as $k => $mymps) { ?>                <li><font style="color:<?=$mymps['color']?>;<? if($mymps['if_bold'] == 1) { ?>font-weight:bold<?php } ?>"><?=$mymps['telname']?><br /><?=$mymps['telnumber']?></font></li>
                <?php }} ?>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    <div class="bbdh">
        <div class="cdiv">
            <div class="index_title">
                <h1>友情链接</h1>
                <h2><a href="<?=$about['friendlink_uri']?>">我要申请</a></h2>
            </div>

            <? if($friendlink['txt']) { ?>
            <div class="index_link">
                <?php if(is_array($friendlink['txt'])){foreach($friendlink['txt'] as $mymps) { ?>                <li><a href="<?=$mymps['url']?>" target="_blank" title="<?=$mymps['name']?>"><?=$mymps['name']?></a></li>
                <?php }} ?>
                <li><a href="http://zhideyao.cn" target="_blank">值得要交易平台</a></li>
            </div>
            <?php } ?>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div class="foot">
    <p>
        <?php $navurl_foot = mymps_get_navurl('foot',30); ?>        <?php $counturlnav = count($navurl_foot);$i=1; ?>        <?php if(is_array($navurl_foot)){foreach($navurl_foot as $k => $mymps) { ?>        <a <? if($counturlnav == $i) { ?>class="backnone"<?php } ?> href="<?=$mymps['url']?>" style="color:<?=$mymps['color']?>" target="<?=$mymps['target']?>"><?=$mymps['title']?><sup class="<?=$mymps['ico']?>"></sup></a>
        <?php $i=$i+1; ?>        <?php }} ?>
    </p>
    <p> Copyright ◎<? echo GetTime($timestamp,'Y'); ?> <?=$mymps_global['SiteName']?>, All Rights Reserved. </p>
    <p><img src="<?=$mymps_global['SiteUrl']?>/template/default/images/index/foot.jpg" width="473" height="62" /></p>
</div>
</body>
</html>
