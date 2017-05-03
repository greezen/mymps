<?php include mymps_tpl('inc_head');?>
<div class="ccc2">
	<ul>
    <select name="typeid" onChange="location.href=(this.options[this.selectedIndex].value)">
        <option value="?">所有帮助主题</option>
        <?php foreach($faq_type as $k){?>
        <option value="?typeid=<?=$k[id]?>"<?php if($typeid == $k[id])echo "selected";?>>筛选&raquo;&nbsp;&nbsp;<?=$k[typename]?></option>
        <?}?>
    </select>
      &nbsp;&nbsp;
      <input class="gray mini" type="button" onClick="location.href='faq.php?do=type'" value="帮助主题分类">
&nbsp;&nbsp;&nbsp;&nbsp;
      <input class="mymps mini" type="button" onClick="location.href='faq.php?part=add'" value="发布帮助主题">
	</ul>
</div>
<form name='form1' method='post' action='?part=delall' onSubmit='return checkSubmit();'>
<input name="url" value="<?=GetUrl()?>" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td width="60"><input name="checkall" class="checkbox" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/>删?</td>
      <td width="60">编号</td>
      <td>帮助标题</td>
      <td>所属分类</td>
      <td>操作</td>
    </tr>
  <tbody onmouseover="addMouseEvent(this);">
<? foreach($faq AS $faq){?>
	<tr bgcolor="white">
   	  <td><input type='checkbox' name='id[]' value='<?=$faq[id]?>' id="<?=$faq[id]?>" class='checkbox'></td>
	  <td><label><?=$faq[id]?></label></td>
	  <td align="left"><a href="../about.php?part=faq&id=<?=$faq[id]?>" target="_blank"><?=$faq[title]?></a></td>
      <td align="left"><a href="?typeid=<?=$faq[typeid]?>"><?=$faq[typename]?></a></td>
	  <td align="center"><a href="faq.php?part=edit&id=<?=$faq[id]?>">编辑</a> / <a href="faq.php?part=delete&id=<?=$faq[id]?>" onClick="if(!confirm('确定要删除吗？\n\n此操作不可以恢复！'))return false;">删除</a>
	  </td>
	</tr>
	<?}?>
	</tbody>

</table>
</div>
<center><input type="submit" onClick="if(!confirm('确定要操作吗？\n\n此操作不可以恢复！'))return false;" value="提 交" class="mymps large"/></center>
</form>
<div class="pagination"><?php echo page2()?></div>  
<?php mymps_admin_tpl_global_foot();?>