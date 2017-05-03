<?php include mymps_tpl('inc_head');?>
<form name="form_mymps" action="?part=list" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr style="background: #e1f2fc; font-weight: bold; text-align:center">
      <td width="40">编号</td>
      <td>分类名称</td>
      <td width="80">分类排序</td>
      <td>操作</td>
    </tr>

<?php 
if(is_array($corp)){foreach($corp AS $corp)
{
?>
	  <tr <?php if($corp[level] == 0){?>bgcolor="#f5fbff" <?}else{?>  bgcolor="#ffffff" <?}?>>
	  <td width="40"><label><?=$corp[corpid]?></label></td>
	  <td width="60%" align="left">
      <li style="margin-left:<?=$corp[level]?>em;" <?php if($corp['parentid'] != '0') echo 'class="son"'?>><a href="../corporation.php?catid=<?=$corp[corpid]?>" <?php if($corp[level] == 0){?>style="font-weight:bold" <?}?> target="_blank"><?=$corp[corpname]?></a></li></td>
      <td width="40"><input name="corporder[<?=$corp[corpid]?>]" value="<?=$corp[corporder]?>" class="txt" type="text"/></td>
	  <td><a href="corp.php?part=edit&corpid=<?=$corp[corpid]?>">编辑</a> / <a href="corp.php?part=del&corpid=<?=$corp[corpid]?>" onClick="if(!confirm('确定要删除该商家分类吗？\n\n该操作将删除隶属该商家分类的子分类！'))return false;">删除</a></td>
	</tr>
<?
} }
?>
</table>
</div>
<center><input name="<?=CURSCRIPT?>_submit" type="submit" value="提交" class="mymps large"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>