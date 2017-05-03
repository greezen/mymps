<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$adv_target = array( "全部" => "all", "网站首页" => "index" );
$vbm_adv_type = array( );
$vbm_adv_type[normalad][name] = "[自定义] 普通广告";
$vbm_adv_type[normalad][notice] = "<li><strong>调用方式：</strong>采用JS调用的方式,增加完广告后,将获得的JS代码粘贴至模板相应位置即可\r\n</li>";
$vbm_adv_type[topbanner][name] = "[系统] 顶部横幅广告";
$vbm_adv_type[topbanner][notice] = "<li><strong>展现方式：</strong> 顶部横幅广告位于网站顶部，通常使用 1000(宽屏1200)*60 图片或 Flash 的形式。\r\n</li><li><strong>价值分析：</strong> 由于能够在页面打开的第一时间将广告内容展现于最醒目的位置，因此成为了网页中价位最高、最适合进行商业宣传或品牌推广的广告类型之一。</li>";
$vbm_adv_type[headerbanner][name] = "[系统] 页头通栏广告";
$vbm_adv_type[headerbanner][notice] = "<li><strong>展现方式：</strong> 页头通栏广告显示于导航栏下方，可使用7张134*72 图片或 Flash 的形式也可使用1张或多张 1000(宽屏1200)*60的横幅图片或flash。\r\n</li><li><strong>价值分析：</strong> 由于能够在页面打开的第一时间将广告内容展现于最醒目的位置，因此成为了网页中价位最高、最适合进行商业宣传或品牌推广的广告类型之一。</li>";
$vbm_adv_type[footerbanner][name] = "[系统] 页尾通栏广告";
$vbm_adv_type[footerbanner][notice] = "<li><strong>展现方式：</strong>  页尾通栏广告显示于网站页面中下方，通常使用 1000(宽屏1200)x60 或其它尺寸图片、Flash 的形式。\r\n</li><li><strong>价值分析：</strong> 与页面头部和中部相比，页面尾部的展现机率相对较低，通常不会引起访问者的反感，同时又基本能够覆盖所有对广告内容感兴趣的受众，因此适合中性而温和的推广。</li>";
$vbm_adv_type[floatad][name] = "[系统] 漂浮广告";
$vbm_adv_type[floatad][notice] = "<li>\r\n<strong>展现方式：</strong>  漂浮广告展现于页面右下角，当页面滚动时广告会自行移动以保持原来的位置，通常使用小图片或 Flash 的形式。当前页面有多个漂浮广告时，系统会随机选取其中之一显示。</li><li><strong>价值分析：</strong> 漂浮广告是进行强力商业推广的有效手段，其在页面中的浮动性，使其与固定的图片和文字相比，更容易被关注，正因为如此，这种强制性的关注也可能招致对此广告内容不感兴趣的访问者的反感。请注意不要将过大的图片或 Flash 以漂浮广告的形式显示，以免影响页面阅读。</li>";
$vbm_adv_type[couplead][name] = "[系统] 对联广告";
$vbm_adv_type[couplead][notice] = "<li><strong>展现方式：</strong> 对联广告以长方形图片的形式显示于页面顶部两侧，形似一幅对联，通常使用宽小高大的长方形图片或 Flash   的形式。对联广告一般只在使用像素约定主表格宽度的情况下使用，如使用超过 90% 以上的百分比约定主表格宽度时，可能会影响访问者的正常流量。当访问者浏览器宽度小于   800 像素时，自动不显示此类广告。当前页面有多个对联广告时，系统会随机选取其中之一显示。</li><li><strong>价值分析：</strong>对联广告由于只展现于高分辨率(1024x768   或更高)屏幕的两侧，只占用页面的空白区域，因此不会招致访问者反感，能够良好的突出推广内容。但由于对分辨率和主表格宽度的特殊要求，使得广告的受众比例无法达到100%。</li>";
$vbm_adv_type[intercatad][name] = "[系统] 栏目侧边广告";
$vbm_adv_type[intercatad][notice] = "<li><strong>展现方式：</strong> 栏目侧边广告显示于每个信息栏目列表页的侧边，可使用 宽度为165像素的尺寸图片和 Flash 的形式。\r\n</li><li><strong>价值分析：</strong>在不同栏目列表页面展示不同的广告，使得广告展示更具针对性，更易为用户接受</li>";
$vbm_adv_type[interlistad][name] = "[系统] 栏目列表间广告";
$vbm_adv_type[interlistad][notice] = "<li><strong>展现方式：</strong> 栏目侧边广告显示于每个信息栏目信息列表的头部或尾部，可使用 文字，代码，图片和 Flash 的形式。\r\n</li><li><strong>价值分析：</strong>与信息标题融为一体，在栏目列表页最具迷惑性的广告位置，可增加广告的点击率</li>";
$vbm_adv_type[indexcatad][name] = "[系统] 首页分类间广告";
$vbm_adv_type[indexcatad][notice] = "<li><strong>展现方式：</strong> 分类间广告显示于网站首页相邻的两个根分类之间，可使用 629*88 或其它尺寸图片和 Flash 的形式。\r\n</li><li><strong>价值分析：</strong>由于出现在网站首页比较明显的位置，广告展示效果较好，但是过多过大的首页广告可能会招致访问者反感。</li>";
$vbm_adv_type[infoad][name] = "[系统] 信息阅读页内广告";
$vbm_adv_type[infoad][notice] = "<li><strong>展现方式：</strong> 信息阅读页内广告显示于信息内容介绍的正下方。\r\n</li><li><strong>价值分析：</strong> 嵌入信息内容内部的广告，可在用户浏览信息内容时自然的被接受，适合于特定内容的有效推广，也可用于网站自身的宣传和公告之用。</li>";
$vbm_adv_style = array( );
$vbm_adv_style['code'] = "代码";
$vbm_adv_style['text'] = "文字";
$vbm_adv_style['image'] = "图片";
$vbm_adv_style['flash'] = "flash";
?>
