<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<form name="form1" action="test_same.php?" method="get" target='stafrm'>
<input name="part" value="do_list" type="hidden">
  <tr class="firstr">
  	<td colspan="2">搜索重复的分类信息主题</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8; width:100px">删除选项:</td>
    <td>&nbsp;<select name="deltype">
    <option value="delold">保留最近的一条</option>
    <option value="delnew" selected="selected">保留最早的一条</option>
    </select></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="background-color:#f1f5f8">每排列出记录:</td>
    <td>&nbsp;<input name="pagesize" type="text" class="txt" value="100">条</td>
  </tr>
 <tr bgcolor="#ffffff">
 	<td>&nbsp;</td>
    <td colspan="2">&nbsp;<input name="test_same_submit" type="submit" value="分析重复的信息主题" class="gray mini"></td>
  </tr>
</form>
<?php include mymps_tpl('html_runbox');?>
</table>
</div>
<div class="clear"></div>
<?php mymps_admin_tpl_global_foot();?>