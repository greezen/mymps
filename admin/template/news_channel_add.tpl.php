<?php include mymps_tpl('inc_head');?>
<script language=javascript>
function chkform(){
	if(document.form1.catname.value==""){
		alert('请输入栏目标题！');
		document.form1.catname.focus();
		return false;
	}
}
</script>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <li><a title="已添加的新闻类别" href="channel.php" <?php if($part == 'list'){?>class="current"<?php }?>>已添加的新闻类别</a></li>
                <li><a title="新增新闻类别" href="channel.php?part=add" <?php if($part == 'add'){?>class="current"<?php }?>>新增新闻类别</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">技巧提示</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip">
  <li>栏目不设置为启用时，仅作为一个分类方案保存，你可以在启用的时候开启它</li>
    </td>
  </tr>
</table>
</div>
<form method=post onSubmit="return chkform()" name="form1" action="?part=add">
<div id="<?=MPS_SOFTNAME?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr">
<td colspan="2">
栏目基本信息
</td>
</tr>
<tbody id="menu_1">
<tr bgcolor="#f5fbff">
  <td width="15%">栏目名称： </td>
  <td><textarea rows="5" name="catname" cols="50"></textarea><br />
<div style="margin-top:3px">支持新闻分类批量添加，多个分类以 | 隔开 <br />
<font color="red">范例：分类1|分类2|分类3|分类4|分类5</font></div></td>
</tr>
<tr bgcolor="#f5fbff">
  <td>隶属栏目： </td>
  <td><select name="parentid" id="parentid" >
    <option value="0">作为根栏目...</option>
<?php echo cat_list('channel');?>
  </select>  </td>
</tr>
<tr bgcolor="#f5fbff">
  <td>栏目排序： </td>
  <td><input name="catorder" type="text" class="txt" id="catorder" value="<?=$maxorder?>" size="13"></td>
</tr>
<tr bgcolor="#f5fbff">
  <td>是否启用： </td>
  <td><select name="isview">
      <?=get_ifview_options($cat[if_view])?>
      </select></td>
</tr>
<tr bgcolor="#f5fbff">
  <td>目录存放形式：<br /><i style="color:#666">生成静态目录时生效</i> </td>
  <td><?=GetHtmlType('3','dir_type','add')?></td>
</tr>
</tbody>
</table>
</div>
<center>
<input type="submit" value="确认提交" name="<?=CURSCRIPT?>_submit" class="mymps mini" />　
<input type="button" onClick=history.back() value="返 回" class="mymps mini">
</center>
</form>
<?php mymps_admin_tpl_global_foot();?>