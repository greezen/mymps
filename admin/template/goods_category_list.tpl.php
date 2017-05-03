<? include mymps_tpl('inc_head')?>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a href="?part=list" class="current">商品分类</a></li>
                <li><a href="?part=add">增加分类</a></li>
            </ul>
        </div>
    </div>
</div>
<form name="form_mymps" action="?part=list" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td>编号</td>
      <td width="40">启用?</td>
      <td>分类名称</td>
      <td width="80">排列顺序</td>
      <td>操作</td>
      <td>&nbsp;</td>
    </tr>
<?php
foreach($f_cat AS $cat)
{
?>
  <tr <?php if($cat['level'] == 0){?>bgcolor="#f5fbff" <?}else{?>  bgcolor="#ffffff" <?}?>>
  <td width="40"><?=$cat[catid]?></td>
  <td><input class="checkbox" name="if_viewids[]" value="<?=$cat[catid]?>" type="checkbox" <?if ($cat[if_view] == 2) echo 'checked';?> /></td>
  <td><li style="margin-left:<?=$cat['level']?>em!important; color:<?=$cat['color']?>" <?php if($cat['parentid'] != '0') echo 'class="son"'?>><a href="../goods.php?catid=<?=$cat[catid]?> "<?php if($cat['level'] == 0){?>style="font-weight:bold" <?}?> target="_blank"><?=$cat[catname]?></a></li></td>
  <td width="80"><input name="catorder[<?=$cat[catid]?>]" value="<?=$cat[catorder]?>" class="txt" type="text"/></td>
  <td><a href="goods_category.php?part=edit&catid=<?=$cat[catid]?>">编辑</a> / <a href="goods_category.php?part=del&catid=<?=$cat[catid]?>" onClick="if(!confirm('确定要删除分类吗？\n\n该操作将删除隶属该分类的子分类以及商品！'))return false;">删除</a>      </td>
  <td width="30">&nbsp;<?php if($cat['level'] == 0){?><a onclick="window.scrollTo(0,0);" style="cursor:pointer" title="至页面顶端">TOP</a><?}?></td>
</tr>
<?}?>
</table>
</div>
<center><input name="<?=CURSCRIPT?>_submit" type="submit" value="提交" class="mymps large"/></center>
</form>
<?=mymps_admin_tpl_global_foot()?>