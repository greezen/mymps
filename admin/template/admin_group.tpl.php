<? include mymps_tpl('inc_head')?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="?do=group" <?php if($part == 'list'){?>class="current"<?php }?>>用户组</a></li>
				<li><a href="?do=group&part=add" <?php if($part == 'add'){?>class="current"<?php }?>>增加用户组</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="<?=MPS_SOFTNAME?>">
  <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td width="60">组编号</td>
      <td width="80">组名称</td>
      <td width="80">属性</td>
      <td>管理</td>
    </tr>
    <?
    foreach($group AS $row)
    {
      ?>
      <tr bgcolor="#f5fbff">
        <td height="24"> 
          <?=$row[id]?>
        </td>
        <td height="24">
         <?=$row[typename]?>
       </td>
       <td height="24">
         <?if($row[ifsystem]=="1"){echo "<font color=red>系统组</font>";}else{echo "<font color=green>自定义组</font>";}?>
       </td>
       <td>
        <a href='admin.php?do=group&part=edit&id=<?=$row[id]?>'>权限设定</a> / 
        <a href='admin.php?do=user&typeid=<?=$row[id]?>'>组用户</a>
        <?php if($row[ifsystem]!="1"){ ?> / <a href='admin.php?do=group&part=delete&id=<?=$row[id]?>' onClick="return confirm('您确定要删除该用户组吗，如不确定请点取消')">删除组</a><?php } ?>
      </td>
    </tr>
    <?
  }
  ?>
</table>
</div>
<?=mymps_admin_tpl_global_foot()?>