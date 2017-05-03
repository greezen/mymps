<?php include mymps_tpl('inc_head');?>
<script language='javascript'>
function CheckSubmit()
{
	if(document.form1.typename.value=="")
	{
   		document.form1.typename.focus();
   		alert("帮助问题类型不能为空！");
   		return false;
	}
	return true;
}
</script>
<div id="<?=MPS_SOFTNAME?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td width="40" align="center" valign="top">类型ID</td>
      <td align="center" valign="top">类型名称</td>
      <td width="36%" align="center">状态</td>
    </tr>
    <?php 
    foreach($links AS $row){
    ?>
    <form action="faq.php?do=type" method="post" name="form2";>
    <input name="part" value="update" type="hidden"/>
    <input name="id" value="<?=$row[id]?>" type="hidden"/>
    <tr bgcolor="#f5fbff">
      <td align="center"><?=$row[id]?></td>
      <td valign="top"><input name="typename" value="<?=$row[typename]?>" class="text" type="text" style="width:90%" /> </td>
      <td align="center">
	  <input type="submit" value="更 改" class="gray mini"/>　<input type="button" onClick="location.href='faq.php?do=type&part=delete&id=<?=$row[id]?>'" value="删 除" class="gray mini"/>	   </td>
    </tr>
    </form>
    <?php
	}
	?>
    <tr class="firstr">
      <td colspan="5" align="left"><strong>新增一个帮助类型：</strong></td>
    </tr>
    <form action="faq.php?do=type" method="post" name="form1" onSubmit="return CheckSubmit();";>
    <input name="part" value="insert" type="hidden"/>
    <tr bgcolor="#f5fbff">
      <td colspan="2" valign="top">
      <input name="typename" class="text" type="text" style="width:70%" />
      </td>
      <td align="center">
      <input type="submit" name="submit" value="新 增" class="mymps mini"/>
        </td>
    </tr>
   </form>
    <tr>
      <td height="34" colspan="5" align="center" bgcolor="white">
      　<input type="button" onClick=history.back() value="返 回" class="mymps mini">    </td>
    </tr>

</table>
</div>
<?php mymps_admin_tpl_global_foot();?>