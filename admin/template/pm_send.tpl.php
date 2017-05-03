<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="pm.php?part=send" <?php if($part == 'send'){?>class="current"<?php }?>>群发短消息</a></li>
				<li><a href="pm.php?part=outbox" <?php if($part == 'outbox'){?>class="current"<?php }?>>已发送短消息</a></li>
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
  <li>若需发送短消息至指定会员组，则指定会员一栏请留空</li>
  <li>若须发送短消息至指定会员，则指定会员组请不要选择选项</li>
    </td>
  </tr>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<form name="form1" action="pm.php?" method="post" target='stafrm'>
    <tr class="firstr">
      <td colspan="4">填写短消息内容</td>
      </tr>
      <tr bgcolor="#f5fbff" >
        <td width="80" >会员组：</td>
        <td><select name="group[]" size="5"  style="width:100px" multiple="multiple">
        <?=member_groups()?>
        </select><br /><br />若须发送短消息至指定会员，则不要选择会员组选项</td>
      </tr>
      <tr bgcolor="#f5fbff" >
        <td width="80" >指定会员：</td>
        <td ><input name="touser" style="width:300px" class="text" type="text" value="<?=$userid?>"/> 多个会员用户名用 , 隔开</td>
      </tr>
      <tr bgcolor="#f5fbff" >
        <td width="80" >标题：</td>
        <td ><input name="title" style="width:300px" class="text" type="text" value="<?=$title?>"/></td>
      </tr>
      <tr bgcolor="#f5fbff" >
        <td width="80" >内容：</td>
        <td ><textarea name="content" style="width:400px; height:200px"/><?=$content?></textarea></td>
      </tr>
    <tr> 
      <td bgcolor="#f5f8ff">&nbsp;</td>
      <td bgcolor="#f5f8ff"><input name="pm_submit" style="margin:10px;" class="mymps large" type="submit" value="提交发送"></td>
    </tr>
    </form>
  <?php include mymps_tpl('html_runbox');?>
</table>
</div>
<?php mymps_admin_tpl_global_foot();?>