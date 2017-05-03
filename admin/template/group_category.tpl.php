<? include mymps_tpl('inc_head')?>
<form name="form_mymps" action="?part=list" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td width="40">删除?</td>
      <td width="40">启用?</td>
      <td width="80">排列顺序</td>
      <td>分类名称</td>
    </tr>
<?php
foreach($cate AS $cat)
{
?>
  <tr <?php if($cat['level'] == 0){?>bgcolor="#f5fbff" <?}else{?>  bgcolor="#ffffff" <?}?>>
  <td width="60"><input class="checkbox" name="delete[]" value="<?=$cat[cate_id]?>" type="checkbox"/></td>
  <td><input class="checkbox" name="cate_view[<?=$cat[cate_id]?>]" value="1" type="checkbox" <?if ($cat[cate_view] == 1) echo 'checked';?> /></td>
  <td width="80"><input name="cate_order[<?=$cat[cate_id]?>]" value="<?=$cat[cate_order]?>" class="txt" type="text"/></td>
  <td><input name="cate_name[<?=$cat[cate_id]?>]" class="text" type="text" value="<?=$cat[cate_name]?>"></td>
</tr>
<?}?>
<tbody id="secqaabody" bgcolor="white">
<tr align="center">
   <td>新增:<a href="###" onclick="newnode = $('secqaabodyhidden').firstChild.cloneNode(true); $('secqaabody').appendChild(newnode)">[+]</a></td>
   <td><input type="checkbox" name="newcate_view[]" class="checkbox" value="1" checked="checked"></td>
   <td><input type="text" name="newcate_order[]" class="txt"></td>
   <td><input type="text" name="newcate_name[]" class="text"></td>
</tr>
</tbody>

<tbody id="secqaabodyhidden" style="display:none">
   <tr align="center" bgcolor="white">
   <td>&nbsp;</td>
   <td><input type="checkbox" name="newcate_view[]" class="checkbox" value="1" checked="checked"></td>
   <td><input type="text" name="newcate_order[]" class="txt"></td>
   <td><input type="text" name="newcate_name[]" class="text"></td>
   </tr>
</tbody>
</table>
</div>
<center><input name="<?=CURSCRIPT?>_submit" type="submit" value="提交" class="mymps large"/></center>
</form>
<?=mymps_admin_tpl_global_foot()?>