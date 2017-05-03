<?php include mymps_tpl('inc_head');?>
  <form action="?part=list" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/> 删?</td>
      <td valign="top">栏目名称</td>
      <td>栏目路径</td>
      <td valign="top">栏目顺序</td>
      <td valign="top">编辑</td>
    </tr>
    <?php 
    foreach($about_type AS $row){
    ?>
    <tr bgcolor="#f5fbff">
          <td><input class="checkbox" type='checkbox' name='delids[]' value='<?=$row[id]?>' id="<?=$row[id]?>"></td>
      <td valign="top" bgcolor="white"><?=$row[typename]?></td>
      <td align="center"><?=$row[dir_typename]?></td>
      <td align="center" bgcolor="white"><input name="displayorder[<?=$row[id]?>]" value="<?=$row[displayorder]?>" type="text" class="txt"/></td>
      <td align="center"><a href="?part=<?=$part?>&id=<?=$row[id]?>">详情</a></td>
    </tr>
    <?php
	}
	?>
</table>
</div>
<center><input type="submit" name="site_about_submit" value="提 交" class="mymps large"></center>
</form>
<form action="site_about.php?part=edit" method="post">
<input type="hidden" name="id" value="<?=$id?>">
<div id="<?=MPS_SOFTNAME?>" style="margin-top:10px; clear:both">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td colspan="2"><?php echo !$id ? '新增' : '修改' ;?>栏目</td>
</tr>
  <tr bgcolor="#f5fbff">
    <td width="12%" height="25">栏目名称：</td>
    <td>
    <input name="typename" value="<?=$about[typename]?>" class="text"/>
    </td>
  </tr>
  <tr bgcolor="#f5fbff">
    <td width="12%" height="25">栏目顺序：</td>
    <td>
    <input name="displayorder" value="<?=$about[displayorder]?>" class="txt"/>
    </td>
  </tr>
<tr bgcolor="#f5fbff">
  <td>路径存放形式：<br /><i style="color:#666">生成静态文件时生效</i> </td>
  <td><?=GetHtmlType($about[dir_type],'dir_type','edit',$about[dir_typename])?> </td>
</tr>
</table>
<div style="margin-top:3px;">
<?php echo $acontent; ?>
</div>
</div>
<center><input type="submit" name="site_about_submit" value="提 交" class="mymps large"/></center>
  </form>
<?php mymps_admin_tpl_global_foot();?>