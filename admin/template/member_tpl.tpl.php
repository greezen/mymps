<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="member_tpl.php" class="current">空间模板</a></li>
				<li><a href="member_comment.php">空间点评</a></li>
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
  <li>模板尾部默认都含有五个文字链接导航【需要在模板里面修改】 关于我们 - 网站公告 - 帮助中心 - 友情链接 - 网站留言</li>
  <li>您可以在这里增加其他尾部导航，他们将与以上导航并列显示</li>
    </td>
  </tr>
</table>
</div>
<form name='form1' method='post' action='?'>
<input name="forward_url" value="<?=GetUrl()?>" type="hidden">
<div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/> 删?</td>
      <td>模板名称</td>
      <td>模板路径/标识</td>
      <td>显示顺序</td>
      <td>启用状态</td>
      <td>修改时间</td>
      <td>编辑</td>
    </tr>
    <tr bgcolor="#dff6ff">
      <td>&nbsp;</td>
      <td>个人会员模板</td>
      <td>/template/spaces/person</td>
      <td colspan="4" >&nbsp;</td>
      </tr>
    <?php foreach($list as $k =>$value){?>
        <tr bgcolor="white">
          <td><input class="checkbox" type='checkbox' name='delids[]' value='<?=$value[id]?>' id="<?=$value[id]?>"></td>
          <td><?=$value[tpl_name]?></td>
          <td><?=$value[tpl_path]?></td>
          <td><input name="displayorder[<?=$value[id]?>]" value="<?=$value[displayorder]?>" type="text" class="txt"/></td>
          <td><?=$if_view[$value[if_view]]?></td>
          <td><?=GetTime($value[edittime])?></td>
          <td><a href="?part=edit&id=<?=$value[id]?>">详情</a></td>
        </tr>
    <?}?>
    <tr bgcolor="#f5fbff">
      <td align="center"><b>新增</b></td>
      <td><input name="add[tpl_name]" value="" type="text" class="text"/></td>
      <td><input name="add[tpl_path]" value="" type="text" class="text"/></td>
      <td><input name="add[displayorder]" value="" type="text" class="txt"/></td>
      <td><select name="add[if_view]">
      <?=get_ifview_options('2')?>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </table>
</div>
<center>
<input type="submit" value="提 交" class="mymps large" name="<?=CURSCRIPT?>_submit"/>  
</center>
</form>
<?php mymps_admin_tpl_global_foot();?>