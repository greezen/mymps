<?php include mymps_tpl('inc_head');?>
<script language="javascript" src="js/vbm.js"></script>
<script language="javascript">
function do_copy(){
  ff = document.form1;
  ff.keywords.value=document.getElementById("title").value;
}
function NewsAdd(){
	if(document.form1.title.value==""){
		alert('请填写新闻标题！');
		document.form1.title.focus();
		return false;
	}
	if(document.form1.catid.value==""){
		alert('请选择所属栏目！');
		document.form1.catid.focus();
		return false;
	}
	if(document.form.catname.value.length<2){
		alert('栏目标题请控制在2个字节以上!');
		document.form1.catname.focus();
		return false;
	}
}
</script>
<title><?php echo $part == 'edit' ? '修改文章' : '增加文章'?></title>
</head>
<body <?php if($row[isjump] == 1){?>onload='HidUrlTr()'<?php }?>>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="news.php" <?php if($part == 'list'){?>class="current"<?php }?>>新闻列表</a></li>
				<li><a href="news.php?part=add" <?php if($part == 'add'){?>class="current"<?php }?>>添加新闻</a></li>
				
				<?php if($part == 'edit' && $row[id]){?><li><a href="news.php?part=edit&id=<?=$row[id]?>" class="current">编辑新闻</a></li><?php }?>
			</ul>
		</div>
	</div>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">技巧提示</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip">
  <li>若选择了焦点图轮显，请务必上传或指定缩略图路径，否则将无法成功发布新闻</li>
  <li>注意：正文内容添加时(特殊情况外)请勿直接从word拷贝！！！</li>
  <li>分段，文章的段首空两格，与传统格式保持一致，因网上看文章较费眼睛，段与段之间空一行可以使文章更清晰易看。</li>
    </td>
  </tr>
</table>
</div>
<form name="form1" action="?part=<?php echo $part; ?>" method="post" onSubmit="return NewsAdd();">
<input type="hidden" name="id" value="<?=$row[id]?>">
<input type="hidden" name="html_path" value="<?php echo $row[html_path] == '/html/news'? '' : $row['html_path']?>">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
	<td colspan="2">常规内容</td>
</tr>
<tr style=" background-color:#FFF">
  <td width="135">&nbsp;文章标题：</td>
  <td><input name="title" type="text" class="text" id="title" style="width:300px" value="<?=$row[title]?>"/>    </td>
  </tr>
<tr style=" background-color:#FFF">
  <td width="135" height="20">&nbsp;文章主栏目：</td>
  <td>
  <select name='catid' style='width:300px'>
  <option value=''>请选择主分类...</option>
  <?php echo cat_list('channel',0,$row[catid]);?>
</select></td>
  </tr>
<tr style="background-color:#FFF;" >
  <td width="135">&nbsp;作者：</td>
  <td colspan="2"><input name="author" type="text" class="text" value="<?=$row[author]?$row[author]:$admin_uname?>" style="width:300px"/>
  </td>
</tr>
<tr style="background-color:#FFF;" >
  <td width="135">&nbsp;来源：</td>
  <td colspan="2"><input name="from" type="text" class="text" value="<?=$row[source]?$row[source]:$mymps_global[SiteName]?>" style="width:300px"/>
  </td>
</tr>
<tr style=" background-color:#FFF"> 
<td width="135">&nbsp;关键词：</td>
<td>
  <input name="keywords" type="text" class="text" id="keywords" style="width:300px" value="<?=$row[keywords]?>">      若与标题相同请<a href="javascript:do_copy();">点此复制</a>(多个词用,分开)</td>
</tr>
<tr class="firstr">
	<td colspan="2">附加设置</td>
</tr>
<tr style="background-color:#FFF;">
  <td width="135">&nbsp;附加参数：</td>
  <td colspan="2">
    <label for="iscommend"><input name="iscommend" type="checkbox" class="checkbox" id="iscommend" value="1"  <?php if($row[iscommend] == 1) echo 'checked';?>/>推荐</label>
    <label for="isbold"><input name="isbold" type="checkbox" class="checkbox" id="isbold" value="1" <?php if($row[isbold] == 1) echo 'checked';?>/>加粗</label>
    <label for="isactive"><input name="isactive" type="checkbox" class="checkbox" id="isactive" value="1" checked/>仅动态浏览</label>
    <label for="isjump"><input name="isjump" type="checkbox" class="checkbox" id="isjump" value="1" onClick="ShowUrlTr()" <?php if($row[isjump] == 1) echo 'checked';?>/>跳转网址</label>
  </td>
</tr>
<tr style="background-color:#FFF;">
  <td width="135">&nbsp;焦点图轮显：</td>
  <td colspan="2">
    <label for="indexfocus"><input name="isfocus[]" type="checkbox" class="checkbox" id="indexfocus" value="index"  <?php if($row[isfocus] == 'index') echo 'checked';?>/>首页</label>
    <label for="newsfocus"><input name="isfocus[]" type="checkbox" class="checkbox" id="newsfocus" value="news"  <?php if($row[isfocus] == 'news') echo 'checked';?>/>新闻页</label>
  </td>
</tr>
<?php if($part == 'add'){?>
<tr id="pictable" style=" background-color:#FFF">
    <td width="135" height="81">&nbsp;缩略图路径：</td>
    <td>
        <label><input type="radio" onclick='
        document.getElementById("iframe").style.display = "none";
        document.getElementById("imgsrc").style.display = "none";
        ' name="ifout" value="bodyimg" class="radio" checked="checked" />自动提取[提取文章第一张图片]</label>
        <label><input type="radio" onclick='
        document.getElementById("iframe").style.display = "none";
        document.getElementById("imgsrc").style.display = "block";' name="ifout" value="no" class="radio"/>远程图片</label>
        <label><input type="radio" onclick='
        document.getElementById("iframe").style.display = "block";
        document.getElementById("imgsrc").style.display = "block";' name="ifout" value="yes" class="radio"/>本地上传</label>
        <input name=imgpath id="imgsrc" type="text" class="text" value="<?=$row[imgpath]?>" style=" margin:10px 0; display:none; width:300px"/>
         
        <iframe src="include/upfile.php?destination=news&watermark=0" width="450" frameborder="0" scrolling="no" onload="this.height=iFrame1.document.body.scrollHeight" id="iframe" style="display:none; margin-top:10px"></iframe>
    </td>
</tr>
<?php } else {?>
<tr id="pictable" style=" background-color:#FFF">
    <td width="135" height="81">&nbsp;缩略图路径：</td>
    <td>
        <label><input type="radio" onclick='
        document.getElementById("iframe").style.display = "none";
        document.getElementById("imgsrc").style.display = "none";
        ' name="ifout" value="bodyimg" class="radio"/>自动提取[提取文章第一张图片]</label>
        <label><input type="radio" onclick='
        document.getElementById("iframe").style.display = "none";
        document.getElementById("imgsrc").style.display = "block";' name="ifout" value="no" class="radio"  checked="checked"/>远程图片</label>
        <label><input type="radio" onclick='
        document.getElementById("iframe").style.display = "block";
        document.getElementById("imgsrc").style.display = "block";' name="ifout" value="yes" class="radio"/>本地上传</label><br>
        <input name=imgpath id=imgsrc type="text" class="text" value="<?=$row[imgpath]?>" style=" margin:10px 0; width:300px"/>
         
        <iframe src="include/upfile.php?destination=news&watermark=0" width="450" frameborder="0" scrolling="no" onload="this.height=iFrame1.document.body.scrollHeight" id="iframe" style="display:none; margin-top:10px"></iframe>
    </td>
</tr>
<?php }?>
<tr style="background-color:#FFF; display:none" id="redirecturltr">
  <td width="135">&nbsp;跳转网址：</td>
  <td colspan="2"><input name="redirect_url" type="text" class="text" id="redirecturl" style="width:300px" value="<?=$row[redirect_url]?>" />
  </td>
</tr>

<tbody id="detail">
<tr style="background-color:#FFF;" >
  <td width="135">&nbsp;起始点击：</td>
  <td colspan="2"><input name="hit" type="text" class="txt" value="<?=$row[hit]?$row[hit]:0?>" />
  </td>
</tr>
<tr style="background-color:#FFF;" >
  <td width="135">&nbsp;浏览一次增加点击：</td>
  <td colspan="2"><input name="perhit" type="text" class="txt" value="<?=$row[perhit]?$row[perhit]:1?>" />
  </td>
</tr>
<tr style="background-color:#FFF;">
	<td width="135">文章摘要（可不填写）：</td>
	<td colspan="2"><textarea name="introduction" style="width:500px; height:100px"><?php echo $row['introduction']; ?></textarea></td>
</tr>
</tbody>
</table>
<div style="margin-top:3px">
<?=$acontent?>
</div>
</div>
<center style='margin-bottom:10px'><input name="news_submit" value="<?php echo $part == 'edit'? '保存修改' : '提交发布'?>" type="submit" class="mymps"/>&nbsp;&nbsp;<input name="news_submit" value="返 回" type="button" onClick="location.href='?part=list'" class="mymps"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>