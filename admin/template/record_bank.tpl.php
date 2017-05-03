<?php include mymps_tpl('inc_head');?>

<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <form name='form1' method='post' action='?do=<?=$do?>&part=<?=$part?>&type=<?=$type?>' onSubmit='return checkSubmit();'>
  <input name="url" type="hidden" value="<?=GetUrl()?>">
  <input name="action" type="hidden" value="delall">
   <tbody onmouseover="addMouseEvent(this);">
    <tr class="firstr">
      <td width="30">选择</td>
      <td width="30">编号</td>
   	  <td>用户名</td>
      <td>项目</td>
      <td>金额变化</td>
      <td>操作时间</td>
    </tr>
<?php foreach($get AS $v){?>
    <tr align="center" bgcolor="white">
      <td><input type='checkbox' name='id[]' value='<?=$v[id]?>' class='checkbox' id="<?=$v[id]?>"></td>
      <td><?=$v[id]?></td>
      <td><a href="javascript:void(0);" onclick="
setbg('Mymps会员中心',400,110,'/box.php?part=member&userid=<?=$v[userid]?>')"><?=$v[userid]?></a></td>
	  <td><?=$v[subject]?></td>
      <td><?=$v[paycost]?></td>
      <td><em><?=$v[pubtime]?></em></td>
    </tr>
<?php }?>
	</tbody>
    <tr bgcolor="#ffffff" height="28">
    <td align="center" style="border-right:1px #fff solid;"><input name="checkall" class="checkbox"  type="checkbox" id="checkall" onClick="CheckAll(this.form)"/></td>
    <td colspan="10">
      <input type="submit" onClick="javascript:if(!confirm('确定要删除吗？\n\n此操作不可以恢复！'))return false;" value="删除记录" class="mymps mini"/>
    </td>
    </tr>
  </form>
</table>
</div>
<div class="pagination"><?=page2()?></div>
<?php mymps_admin_tpl_global_foot();?>