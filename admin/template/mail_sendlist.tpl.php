<?php include mymps_tpl('inc_head');?>
<form action="?part=sendlist" method="post"/>
<div id="<?=MPS_SOFTNAME?>">
  <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/> 删?</td>
      <td>邮件主题</td>
      <td>发送至</td>
      <td>发送状态</td>
      <td>发送时间</td>
    </tr>
    <?php foreach($list as $list){?>
    <tr bgcolor="white">
      <td><input class="checkbox" type='checkbox' name='delids[]' value='<?=$list[id]?>' id="<?=$list[id]?>"></td>
      <td><?=$list[email_subject]?></td>
      <td><?=$list[email]?></td>
      <td><?php echo $list[error] == 1 ? '<font color=red>发送失败</font>' : '<font color=green>发送成功</font>' ;?></td>
      <td><em><?=GetTime($list[last_send])?></em></td>
    </tr>
    <?php }?>
  </table>
</div>
<center><input type="submit" value="提 交" class="mymps large" name="mail_submit"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>