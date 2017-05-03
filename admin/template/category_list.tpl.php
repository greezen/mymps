<? include mymps_tpl('inc_head'); ?>
<script type="text/javascript">
function showchildren(i){
	var c = document.getElementById('children_'+i);
	var g = document.getElementById('img_'+i);
	c.style.display = c.style.display == 'none' ? '' : 'none';
	g.style.src=g.style.src=='template/images/menu_add.gif'?'template/images/menu_reduce.gif':'template/images/menu_add.gif';
}
</script>
<style>
.categorybox{ border-left:1px #c5d8e8 solid;border-bottom:1px #c5d8e8 solid;border-right:1px #c5d8e8 solid; height:auto;}
.categorybox .first{font-weight:700;color:#069; background-color:#eaf7ff!important;}
.categoryli{ height:auto; overflow:auto;}
.categoryli ul{border-bottom:1px #c5d8e8 solid;}
.categoryli ul li{ display:block; text-align:left;padding:12px 0 12px 15px;}
.categoryli ul .column1{ width:80px; float:left;}
.categoryli ul .column2{ width:300px; float:left;}
.categoryli ul .column3{ width:200px; float:right;}
</style>
<form name="form_mymps" action="?part=list" method="post">
<div class="categorybox">
<div class="categoryli first">
	<ul>
        <li class="column1">编号</li>
        <li class="column1"><input name="chkall" type="checkbox" onclick="AllCheck('prefix', this.form, 'if_viewids')" class="checkbox"/>启用?</li>
        <li class="column2">名称</li>
        <li class="column3">操作</li>
        <li class="column1">排列顺序</li>
    </ul>
</div>
<div class="clear" style="height:0px!important;"></div>
<?php
$i=$t=1;
foreach($f_cat AS $cat)
{
	if($i == 1) $k =$cat['catid'];
	elseif($i > 1 && $cat['level']==0) $k=$cat[catid];
?>
<?php if($cat['level']==0){ $t=1;}?>
<? if($i>1 && $cat['level']==0){?></div><? }?>
<?
if($t == 2){?><div id="children_<?=$k?>" style="display:none;"><?php }?>
<div class="categoryli" <?php echo $cat[level] == 0 ? 'style ="background-color:#f5fbff"' : '';?>>
  <ul>
  <li class="column1"><?=$cat[catid]?></li>
  <li class="column1"><input id="<?=$cat[catid]?>" class="checkbox" name="if_viewids[]" value="<?=$cat[catid]?>" type="checkbox" <?php if ($cat[if_view] == 2) echo 'checked';?> /></li>
  <li class="column2"><span class="margin<?=$cat['level']?> <?php if($cat['parentid'] != '0') echo 'son'?>" style="color:<?=$cat['color']?>"><? if ($cat[level] == 0){?><a href="javascript:void(0);" onclick="showchildren(<?php echo $k; ?>);" style="font-weight:bold"><img id="img_<?=$cat[catid]?>" src="template/images/menu_add.gif" align="absmiddle"> <?=$cat[catname]?></a><? }else{?><a href="?part=edit&catid=<?=$cat[catid]?>"><?=$cat[catname]?></a><? }?></span></li>
  <li class="column3"><a href="category.php?part=edit&catid=<?=$cat[catid]?>">编辑</a> / <a href="category.php?part=del&catid=<?=$cat[catid]?>" onClick="if(!confirm('确定要删除栏目吗？\n\n该操作将删除隶属该栏目的子栏目以及分类信息！'))return false;">删除</a>      </li>
  <li class="column1"><input name="catorder[<?=$cat[catid]?>]" value="<?=$cat[catorder]?>" class="txt" type="text"/></li>
  </ul>
</div>
<div class="clear" style="height:0px!important;"></div>
<?php
$i++;
$t++;
}?>
</div>
</div>
<center><input name="<?=CURSCRIPT?>_submit" type="submit" value="提交" class="mymps large"/></center>
</form>
<?=mymps_admin_tpl_global_foot()?>