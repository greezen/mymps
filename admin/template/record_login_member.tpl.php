<?php include mymps_tpl('inc_head');
$admindir = getcwdOL();
?>

<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">检索指定用户名的登录日志</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td>
<form action="?" name="form1" method="get">
     	<input name="keywords" class="text" value="<?=$keywords?>">
        <input name="do" value="<?=$do?>" type="hidden">
        <input name="part" value="login" type="hidden">
        <input type="submit" value="搜 索" class="gray mini">&nbsp;&nbsp;
		<input type="button" value="只保存最近两个月的记录" class="mymps mini" onclick="location.href='?do=member&part=login&action=savemonth'">&nbsp;&nbsp;  
		<input type="button" value="导出到excel" class="mymps mini" onclick="location.href='record.php?do=member&part=login&action=doexcel';">
     </form>
    </td>
  </tr>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <form name='form1' method='post' action='?do=<?=$do?>&part=<?=$part?>' onSubmit='return checkSubmit();'>
    <input type='hidden' name='action' value='delall'/>
    <input name="url" type="hidden" value="<?=GetUrl()?>">
    <tr class="firstr">
    <td width="30">选择</td>
    <td align="center">用户名</td>
    <td align="center">IP地址</td>
	<td align="center">地理位置</td>
	<td align="center">端口</td>
	<td align="center">浏览器</td>
	<td align="center">操作系统</td>
    <td align="center">登录时间</td>
	<td align="center">下线时间</td>
    </tr>
  	<tbody onmouseover="addMouseEvent(this);">
    <?
foreach($record AS $k)
{
?>
    <tr align="center" bgcolor="white">
    <td><input type='checkbox' class="checkbox" name='id[]' value='<?=$k[id]?>' id="<?=$k[id]?>"></td>
    <td><a href="javascript:
setbg('<?=MPS_SOFTNAME?>会员中心',400,110,'../box.php?part=member&userid=<?=$k[userid]?>&admindir=<?=$admindir?>')"><?=$k[userid]?></a></td>
    <td><?=$k[ip]?></td>
	<td><?=$k[ip2area]?></td>
	<td><?=$k[port]?></td>
	<td><?=$k[browser]?></td>
	<td><?=$k[os]?></td>
    <td><em><?=$k[pubdate]?></em></td>
	<td><em><?=$k[outdate]?></em></td>
  </tr>
    <?
}
?>	</tbody>
    <tr bgcolor="#ffffff" height="28">
    <td align="center" style="border-right:1px #fff solid;"><input name="checkall" type="checkbox" class="checkbox" id="checkall" onClick="CheckAll(this.form)"/></td>
    <td colspan="10"><input type="submit" onClick="javascript:if(!confirm('确定要操作吗？\n\n此操作不可以恢复！'))return false;" value="批量删除" class="mymps mini" <?php if($do == 'admin'){echo "disabled";}?>/>  
    </td>
    </tr>
    </form>
</table>
</div>
<div class="pagination"><?echo page2()?></div>
<?php mymps_admin_tpl_global_foot();?>