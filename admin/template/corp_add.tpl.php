<?php include mymps_tpl('inc_head');?>
<script language=javascript>
function chkform(){
	if(document.form.corpname.value==""){
		alert('请输入商家分类名称，多个分类以 | 隔开！');
		document.form.corpname.focus();
		return false;
	}
}
</script>
<form method=post onSubmit="return chkform()" name="form" action="?part=add">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr bgcolor="#f5fbff">
  <td >分类名称 </td>
  <td>
  <textarea rows="5" name="corpname" cols="50"></textarea><br />
<div style="margin-top:3px">支持商家分类批量添加，多个分类以 | 隔开 <br />
<font color="red">范例：分类1|分类2|分类3|分类4|分类5</font></div></td>
</tr>
<tr bgcolor="#f5fbff">
  <td >隶属分类 </td>
  <td><select name="parentid" id="parentid" >
    <option value="0">作为根分类...</option>
	<?=cat_list('corp',0,'',true,1)?>
  </select>  </td>
</tr>
<tr bgcolor="#f5fbff">
  <td >分类排序 </td>
  <td><input name="corporder" class="text" type="text" id="corporder" value="<?=$maxorder?>" size="14"></td>
</tr>
</table>
</div>
<center>
<input type="submit" name="<?=CURSCRIPT?>_submit" value="提交保存" class="mymps mini"/>
&nbsp;&nbsp;
<input type="button" onClick=history.back() value="返 回" class="mymps mini"></center>
</form>
<?php mymps_admin_tpl_global_foot();?>