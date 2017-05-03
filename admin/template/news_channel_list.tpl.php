<? include mymps_tpl('inc_head')?>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a title="已添加的新闻类别" href="channel.php" <?php if($part == 'list'){?>class="current"<?php }?>>已添加的新闻类别</a></li>
                <li><a title="新增新闻类别" href="channel.php?part=add" <?php if($part == 'add'){?>class="current"<?php }?>>新增新闻类别</a></li>
            </ul>
        </div>
    </div>
</div>

<form name="form_mymps" action="?part=list" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td width="40">编号</td>
      <td width="40">启用?</td>
      <td>名称</td>
      <td width="80">排列顺序</td>
      <td>操作</td>
      <td>&nbsp;</td>
    </tr>
<?php
foreach($f_cat AS $cat)
{
?>
	  <tr <?php if($cat[level] == 0){?>bgcolor="#f5fbff" <?}else{?>  bgcolor="#ffffff" <?}?>>
	  <td width="40"><?=$cat[catid]?></td>
      <td><input name="if_viewids[]" value="<?=$cat[catid]?>" type="checkbox" <?if ($cat[if_view] == 2) echo 'checked';?> class="checkbox"/></td>
  <td><li style="margin-left:<?=$cat['level']>1?$cat[level]*3:$cat[level]?>em;" <?php if($cat['parentid'] != '0') echo 'class="son"'?>><a <?php if($cat[level] == 0){?>style="font-weight:bold" <?}?> href="../news.php?catid=<?=$cat[catid]?>" target="_blank"><?=$cat[catname]?></a></li></td>
      <td width="80"><input name="catorder[<?=$cat[catid]?>]" value="<?=$cat[catorder]?>" class="txt"/></td>
	  <td><a href="channel.php?part=edit&catid=<?=$cat[catid]?>">编辑</a> / <a href="channel.php?part=del&catid=<?=$cat[catid]?>" onClick="if(!confirm('确定要删除该新闻栏目吗？\n\n该操作将删除隶属该栏目的子栏目以及新闻文章！'))return false;">删除</a></td>
      <td width="30"><a onclick="window.scrollTo(0,0);" style="cursor:pointer" title="至页面顶端">TOP</a></td>
    </tr>
<?}?>
</table>
</div>
<center><input name="<?=CURSCRIPT?>_submit" type="submit" value="提交" class="mymps large"/></center>
</form>
<?=mymps_admin_tpl_global_foot()?>