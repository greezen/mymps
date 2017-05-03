<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="?do=group" <?php if($part == 'list'){?>class="current"<?php }?>>会员组类型</a></li>
				<li><a href="?do=group&part=add" <?php if($part == 'add'){?>class="current"<?php }?>>增加会员组</a></li>
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
    <tr align="center" bgcolor="#f5fbff">
      <td> 
        <?=$row[id]?>
      </td>
      <td>
      	<?=$row[levelname]?>
      </td>
      <td>
      	<?if($row[ifsystem] == "1"){echo"<font color=red>系统组</font>";}else{echo "<font color=green>自定义组</font>";}?>
      </td>
      <td>
        <a href='member.php?do=group&part=edit&id=<?=$row[id]?>'>编辑</a> / 
      	<a href='member.php?do=member&levelid=<?=$row[id]?>'>组用户</a>
      <?php if($row[ifsystem]!=1){ ?> / <a href='?do=group&part=delete&id=<?=$row[id]?>' onClick="return confirm('您确定要删除该用户组吗，如不确定请点取消')">删除组</a><?php } ?>
      </td>
    </tr>
<?
}
?>
</table>
</div>
<form action="member.php?part=levelup" method="post">
<div id="<?=MPS_SOFTNAME?>" style="margin-top:10px; clear:both">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td colspan="2">会员自助升级页面提示信息</td>
</tr>
  <tr bgcolor="#f5fbff">
    <td width="12%" height="25">提示内容：</td>
    <td>
   	<textarea name="levelup_notice" style="width:250px; height:120px"><?php echo $levelup_notice; ?></textarea>
    </td>
  </tr>
</table>
</div>
<center><input type="submit" name="member_submit" value="提 交" class="mymps large"/></center>
  </form>
<?php mymps_admin_tpl_global_foot();?>