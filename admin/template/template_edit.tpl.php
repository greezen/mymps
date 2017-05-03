<?php include mymps_tpl('inc_head');?>
<script type="text/javascript" src="js/mymps_tpl.js"></script>
<div class="ccc2">
    <ul>
        <img src="../images/warn.gif" align="absmiddle"> 安全提示：当前在线编辑模板功能</span>：<?=$cfg_if_tpledit?>。建议您只有在十分必要的时候才开启它。您可以修改 /dat/config.inc.php 关闭此功能
    </ul>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr" align="left">
    <td>当前所在目录<b style="color:red">【<?=$path?>】</b></td>
  </tr>

  <tr align="center" bgcolor="#ffffff">
    <td style="padding-bottom:10px">
    <div align="left" style="border-bottom:#e1f2fc 1px solid; margin:5px 0 5px 0; padding:0 5px 10px 5px">
    <a href="?path=<?=$LastPath?>">
    <img src="template/images/file_topdir.gif" border="0" align="absmiddle">上级目录</a>
    </div>
<?php
$fso=@opendir($path);
while ($file=@readdir($fso)) 
{
	$fullpath	= "$path/$file";
	$is_dir		= @is_dir($fullpath);
	if($is_dir=="0")
    {
        if($file!=".."&&$file!=".")	
        {?>
        <li style="float:left; margin:5px;" <?php if($fullpath==$editfile){echo "class=on";}?>><img src="<?=FileImage($fullpath)?>" border="0" align="absmiddle"> <a href="?editfile=<?=$fullpath?>" ><?=$file?></a>
        </li>
        <?} 
    }
}
@closedir($fso); 
?>
    </td>
  </tr>
</table>
</div>
<div class="clear"></div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<form method="post" action="?editfile=<?=$editfile?>" onsubmit="return confirm('如果您没有html基础，不建议您在线编辑模板风格\n否则可能造成页面排版错乱甚至无法显示！\n您确定要提交修改该文件吗？')">
<input name="do" value="update" type="hidden">
<input name="url" value="<?=getUrl()?>" type="hidden">
<tr class="firstr">
  <td colspan="4">在线编辑模板文件</td>
</tr>
<tr bgcolor="#f5fbff">
  <td width="80">当前修改： </td>
  <td colspan="3">
	<b style="color:red"><?=$editfile?></b>
  </td>
</tr>
<tr bgcolor="#f5fbff">
  <td width="80">模板内容： </td>
  <td colspan="3">
  <div>
  <?php echo $acontent; ?>
  </div>
  </td>
</tr>
<tr bgcolor="#f5fbff">
  <td width="80">&nbsp;</td>
  <td colspan="3">
  <input name="search" type="text" class="text' accesskey="t" size="20" onChange="n=0;" <?=$disabled?>>
    <input class="mymps mini" type="button" value="搜 索" accesskey="f" onClick="findInPage(this.form.content, this.form.search.value)">　
    <input type="button" value="预 览" accesskey="p" onClick="displayHTML(this.form.content)" class="mymps mini">
    <input type="button" value="复 制" accesskey="c" onClick="HighlightAll(this.form.content)" class="mymps mini">
 </td>
</tr>
<tr bgcolor="#f5fbff" >
	<td align="right">&nbsp;</td>
    <td colspan="3">
        <input type="submit" value="提交修改" class="mymps mini"/> 
        <input type="reset" value="重 置" class="mymps mini"/> 
    </td>
</tr>
</form>
</table>
</div>
<?php mymps_admin_tpl_global_foot();?>