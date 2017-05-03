<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
	<div class="mpstopic-category">
		<div class="panel-tab">
			<ul class="clearfix tab-list">
				<li><a href="config.php?part=imgcode" <?php if($part == 'imgcode'){?>class="current"<?php }?>>验证码控制</a></li>
				<li><a href="config.php?part=checkask" <?php if($part == 'checkask'){?>class="current"<?php }?>>验证问答设置</a></li>
				<li><a href="config.php?part=badwords" <?php if($part == 'badwords'){?>class="current"<?php }?>>过滤设置</a></li>
				<li><a href="config.php?part=commentsettings" <?php if($part == 'commentsettings'){?>class="current"<?php }?>>评论点评设置</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">相关说明</td>
  </tr>
  <tr bgcolor="#ffffff">
    <td id="menu_tip">
 <li>验证问题应该言简意赅，没有歧义，正常人都能够正确作答。请经常更新验证问答的问题及答案以防止被猜测！</li>
 <li>验证问答功能要求会员必须正确回答系统<font color=red>随机抽取</font>的问题才能继续操作，可以避免恶意注册或发布信息，请选择需要打开验证问答的操作。</li>
 <li>注意: 启用该功能会使得部分操作变得繁琐，建议仅在必需时打开</li>
    </td>
  </tr>
</table>
</div>
<div class="clear"></div>
<form action="?part=checkask" method="post">
<input name="action" type="hidden" value="do_post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
    	<td colspan="2">验证问答设置</td>
    </tr>
    <tr bgcolor="#ffffff">
        <td width="45%"><b>启用验证问答:</td>
        <td><label for="whenregister"><input class="checkbox" type="checkbox" name="whenregister" id="whenregister" value="1" <?php if($when['whenregister'] == '1') echo 'checked';?>> 新用户注册</label> <label for="whenpost"><input class="checkbox" type="checkbox" name="whenpost" value="1" <?php if($when['whenpost'] == '1') echo 'checked';?> id="whenpost"> 发布分类信息</label></td>
    </tr>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td colspan="3">验证问答及答案设置</td>
    </tr>
    <tr bgcolor="#f5f8ff" style="font-weight:bold">
      <td>删？</td>
      <td>问题</td>
      <td>答案</td>
    </tr>
    <?php foreach($c as $key => $val){?>
    <tr align="center" bgcolor="white">
        <td><input class="checkbox" type="checkbox" name="delete[]" value="<?php echo $val['id']; ?>"></td>
        <td><textarea name="question[<?php echo $val['id']; ?>]" rows="3" cols="60"><?php echo $val['question']; ?></textarea></td>
        <td><input type="text" name="answer[<?php echo $val['id']; ?>]" size="30" maxlength="50" value="<?php echo $val['answer']; ?>"></td>
    </tr>
    <?php }?>
   <tbody id="secqaabody" bgcolor="white">
   <tr align="center">
       <td>新增:<a href="###" onclick="newnode = $('secqaabodyhidden').firstChild.cloneNode(true); $('secqaabody').appendChild(newnode)">[+]</a></td>
       <td><textarea name="newquestion[]" rows="3" cols="60"></textarea></td>
       <td><input type="text" name="newanswer[]" size="30" maxlength="50"></td>
   </tr>
   </tbody>
   
   <tbody id="secqaabodyhidden" style="display:none">
       <tr align="center" bgcolor="white">
       <td>&nbsp;</td>
       <td><textarea name="newquestion[]" rows="3" cols="60"></textarea></td>
       <td><input type="text" name="newanswer[]" size="30" maxlength="50"></td>
       </tr>
   </tbody>
   
   <tr bgcolor="#f5f8ff">
   <td colspan=3>建议您设置 10 个以上验证问题及答案，验证问题越多，验证问答防止恶意注册或发布信息的效果越明显。问题支持 HTML 代码，答案长度不超过 50 字节</td>
   </tr>
</table>
</div>
<center>
<input class="mymps large" value="提 交" type="submit" > &nbsp;
</center>
</form>
<?php mymps_admin_tpl_global_foot();?>