<?php include mymps_tpl('inc_head');?>
<form action="?part=template" method="post"/>
<div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td><input class="checkbox" name="checkall" type="checkbox" id="checkall" onClick="CheckAll(this.form)"/> 删?</td>
      <td>模板主题</td>
      <td>标识码</td>
      <td>邮件类型</td>
      <td>模板类型</td>
      <td>修改时间</td>
      <td>编辑</td>
    </tr>
	<?php foreach($tpl as $tpl){?>
        <tr bgcolor="white">
          <td><input class="checkbox" type='checkbox' name='delids[]' value='<?=$tpl[template_id]?>' id="<?=$tpl[template_id]?>" <?php if($tpl[is_sys] == 1){?> disabled<?}?>></td>
          <td><?=$tpl[template_subject]?></td>
          <td><?=$tpl[template_code]?></td>
          <td><?php echo $tpl[is_html] == 1 ? 'HTML' : '文本' ;?></td>
          <td><?php echo $tpl[is_sys] == 1 ? '<font color=red>系统模板</font>' : '<font color=#006acd>自定义模板</font>' ;?></td>
          <td><?=GetTime($tpl[last_modify])?></td>
          <td><a href="?part=template&template_id=<?=$tpl[template_id]?>">详情</a></td>
        </tr>
	<?php }?>
    <tr bgcolor="#f5fbff">
      <td><b>新增</b></td>
      <td><input name="add[template_subject]" value="" type="text" class="text"/></td>
      <td><input name="add[template_code]" value="" type="text" class="text"/>
      </td>
      <td>
      <select name="add[is_html]">
      <option value="1">HTML</option>
      <option value="0">文本</option>
      </select></td>
      <td>
      <select name="add[is_sys]">
      <!--<option value="1">系统模板</option>-->
      <option value="0">自定义模板</option>
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </table>
</div>
<center><input type="submit" value="提 交" class="mymps large" name="mail_submit"/>  </center>
</form>
<?php if($template_id){?>
<br />
<form method="post" action="?part=template&edit_id=<?=$edit[template_id]?>">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<input name="edit[template_id]" type="hidden" value="<?=$template_id?>" />
<tr class="firstr">
<td colspan="2">修改邮件模板</td>
</tr>
<tr bgcolor="#ffffff">
<td>
模板主题
</td>
<td><input class="text" type="text" name="edit[template_subject]" value="<?=$edit[template_subject]?>"></td>
</tr>
<tr bgcolor="#ffffff">
<td>
模板标识码
</td>
<td><input class="text" type="text" name="edit[template_code]" value="<?=$edit[template_code]?>"><br />
<div style="margin-top:5px">一般情况下请保持默认勿修改此项</div>
</td>
</tr>
<tr bgcolor="#ffffff">
<td>
邮件类型
</td>
<td><select name="edit[is_html]">
      <option value="1" <?php if($edit[is_html] == '1') echo 'selected style="background-color:#6EB00C;color:white"' ;?>>HTML</option>
      <option value="0" <?php if($edit[is_html] == '0') echo 'selected style="background-color:#6EB00C;color:white"' ;?>>文本</option>
      </select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td>
模板内容
</td>
<td><textarea name="edit[template_content]" style="width:400px; height:300px"><?=$edit[template_content]?></textarea></td>
</tr>
</table>
</div>
<center><input type="submit" value="提 交" class="mymps large" name="mail_submit"/>  </center>
</form>
<?php }?>
<?php mymps_admin_tpl_global_foot();?>