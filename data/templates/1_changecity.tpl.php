<?php if(!defined('IN_MYMPS')) exit('Access Denied');
/*Mymps分类信息系统
官方网站：http://zhideyao.cn*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/uaredirect.js" type="text/javascript"></script>
<script type="text/javascript">uaredirect("<?=$mymps_global['SiteUrl']?>/m/index.php?mod=changecity&cityid=<?=$cityid?>");</script>
<title>切换分站 - <?=$mymps_global['SiteName']?></title>
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/global.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/style.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/post.css" />
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/changecity.css" />
<script src="<?=$mymps_global['SiteUrl']?>/template/global/noerr.js" type="text/javascript"></script>
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/global.js" type="text/javascript"></script>
<script src="<?=$mymps_global['SiteUrl']?>/template/default/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/jquery.autocomplete.min.js"></script> 
<link rel="stylesheet" href="<?=$mymps_global['SiteUrl']?>/template/default/css/jquery.autocomplete.css" /><?php $allcities = get_allcities(); ?><script type="text/javascript"> 
var cities = [<?php $i=1; ?><?php if(is_array($allcities)){foreach($allcities as $k => $mymps) { if($i > 1) { ?>,<?php } ?>{ name1: "<?=$mymps['citypy']?>",name: "<?=$mymps['directory']?>", to: "<?=$mymps['cityname']?>" }<?php $i=$i+1; ?><?php }} ?>
]; 
$(function() {
$('#cityname').autocomplete(cities, { 
max: 20,
minChars: 0,
width: 166,
scrollHeight: 300,
matchContains: true,
autoFill: false,
formatItem: function(row, i, max) { 
return row.to; 
}, 
formatMatch: function(row, i, max) { 
return row.name1 + row.name + row.to; 
}, 
formatResult: function(row) { 
return row.to; 
} 
}); 
}); 
</script>
</head>

<body class="<?=$mymps_global['cfg_tpl_dir']?> bodybg<?=$mymps_global['cfg_tpl_dir']?><?=$mymps_global['bodybg']?>"><div class="bartop">
<div class="barcenter">
<div class="barleft">
<ul class="barcity"><span><? if($city['cityname']) { ?><?=$city['cityname']?><?php } else { ?>总站<?php } ?></span> [<a href="<?=$mymps_global['SiteUrl']?>/changecity.php">切换分站</a>]</ul> 
<ul class="line"><u></u></ul>
<ul class="barcang"><a href="<?=$mymps_global['SiteUrl']?>/desktop.php" target="_blank" title="点击右键，选择“目标另存为”，将此快捷方式保存到桌面即可">保存到桌面</a></ul>
<ul class="line"><u></u></ul>
<ul class="barpost"><a href="<?=$mymps_global['SiteUrl']?>/<?=$mymps_global['cfg_postfile']?>?cityid=<?=$cityid?>">快速发布信息</a></ul>
<ul class="line"><u></u></ul>
<ul class="bardel"><a href="<?=$mymps_global['SiteUrl']?>/delinfo.php" rel="nofollow">修改/删除信息</a></ul>
<ul class="line"><u></u></ul>
<ul class="barwap"><a href="<?=$mymps_global['SiteUrl']?>/mobile.php">手机浏览</a></ul>
</div>
<div class="barright">
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/javascript.php?part=iflogin&cityid=<?=$city['cityid']?>"></script>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="mhead">
<div class="logo"><a href="<? echo $city['domain']?$city['domain']:$mymps_global['SiteUrl']; ?>" target="_blank"><img src="<?=$mymps_global['SiteUrl']?><?=$mymps_global['SiteLogo']?>" title="<?=$mymps_global['SiteName']?>"/></a></div>
<div class="font">
<span>
        <? if(CURSCRIPT == 'posthistory') { ?>发帖记录<?php } elseif(CURSCRIPT == 'space') { ?>用户中心<?php } elseif(CURSCRIPT == 'mobile') { ?>手机版<?php } elseif(CURSCRIPT == 'login') { ?>帐号升级<?php } elseif(CURSCRIPT == 'delinfo') { ?>修改/删除信息<?php } elseif(CURSCRIPT == 'changecity') { ?>切换分站<?php } else { ?>发布信息<?php } ?>
</span>
</div>
</div>
<div class="cleafix"></div><div class="body1000">
<div class="clear15"></div>
<div id="main" class="wrapper">
<div class="changecitydiv">
<div class="vhd">
<form id="changcityForm" action="?" method="post">
目前<?=$mymps_global['SiteName']?>已经开通<font color="#ff3300"><?=$total?></font>个分站，立刻选择你所关心的分站，或直接输入分站名称
<input type="text" class="focus2" onBlur="this.className='focus2'" onFocus="this.className='focus1'" id="cityname" name="cityname" value=""/>
<input type="submit" value="进入分站" class="vsubmit"/>
</form>
</div>
<div class="clear"></div>
<div id="blist">
热门分站：
<? if($fromcity) { ?><a href="<?=$fromcity['domain']?>" style="color:#ff3300;">进入<?=$fromcity['cityname']?>站 &raquo;</a><?php } ?>
                <?php if(is_array($hotcities)){foreach($hotcities as $mymps) { ?>                    <a href="<?=$mymps['domain']?>"><strong><?=$mymps['cityname']?></strong></a>
                <?php }} ?>
</div>
<div class="clear"></div>
<dl id="clist" class="<?=$mymps_global['cfg_cityshowtype']?>">
            <?php if(is_array($cities)){foreach($cities as $k => $citie) { ?><div>
<dt><?=$k?></dt>
<dd>
                <?php if(is_array($citie)){foreach($citie as $u => $w) { ?><a href="<?=$w['domain']?>" <? if($w['ifhot'] == 1) { ?>style="color:red;text-decoration:underline;"<?php } ?>><?=$w['cityname']?></a>
<?php }} ?>
</dd>
</div>
<div class="clearfix"></div>
<?php }} ?>
</dl>
</div>
</div>
    <div class="clear"></div><div class="footer">
&copy; <?=$mymps_global['SiteName']?> <a href="<?=$about['aboutus_uri']?>" target="_blank">关于我们</a> <a href="http://www.miibeian.gov.cn" target="_blank"><?=$mymps_global['SiteBeian']?></a> <?=$mymps_global['SiteStat']?> 
<span class="none_<?=$mymps_mymps['debuginfo']?>">
<? if($cachetime) { ?>
This page is cached at <? echo GetTime($timestamp,'Y-m-d H:i:s'); ?><?php } else { ?><?php $mtime = explode(' ', microtime());$totaltime = number_format(($mtime['1'] + $mtime['0'] - $mymps_starttime), 6); echo 'Processed in '.$totaltime.' second(s) , '.$db->query_num.' queries'; ?><?php } ?>
</span>
<span class="none">Powered by <strong><a href="http://zhideyao.cn" target="_blank">mymps</a></strong> <em><a href="http://zhideyao.cn" target="_blank"><?=MPS_VERSION?></a></em></span>
</div>
<p id="back-to-top"><a href="#top"><span></span></a></p>
<script type="text/javascript" src="<?=$mymps_global['SiteUrl']?>/template/default/js/scrolltop.js"></script></div>
</body>
</html>