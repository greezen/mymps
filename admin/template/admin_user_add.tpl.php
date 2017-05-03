<?php include mymps_tpl('inc_head');?>
<script language='javascript'>
	function checkSubmit()
  {
   if(document.form1.userid.value==""){
    alert("用户ID不能为空！");
    document.form1.userid.focus();
    return false;
  }
  if(document.form1.uname.value==""){
    alert("用户名不能为空！");
    document.form1.uname.focus();
    return false;
  }
  if(document.form1.pwd.value==""){
    alert("用户密码不能为空！");
    document.form1.pwd.focus();
    return false;
  }
  return true;
}
</script>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
  <div class="mpstopic-category">
    <div class="panel-tab">
      <ul class="clearfix tab-list">
        <li><a href="?do=user">管理员列表</a></li>
        <li><a href="?do=user&part=add" class="current">增加管理员</a></li>
      </ul>
    </div>
  </div>
</div>
<form name="form1" action="?do=user&part=insert" onSubmit="return checkSubmit();" method="post">
  <div id="<?=MPS_SOFTNAME?>">
    <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr">
        <td colspan="2">新增管理员</td>
      </tr>
      <?php if(!$admin_cityid){?>
      <tr bgcolor="#ffffff">
       <td>隶属分站<font color="red">(*)</font>：</td>
       <td>
        <select name="cityid">
          <option value="0">总站</option>
          <?php echo get_cityoptions($cityid); ?>
        </select>
      </td>
    </tr>
    <?}else{?>
    <input name="cityid" type="hidden" value="<?php echo $admin_cityid; ?>">
    <?php }?> 
    <tr bgcolor="#ffffff" >
      <td width="16%" height="30">用户登录ID<font color="red">(*)</font>：</td>
      <td width="84%"><input name="userid" class="text" type="text" id="userid" size="16" style="width:200px" />
        （只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'、'!'以内范围的字符）</td>
      </tr>
      <tr bgcolor="#ffffff" >
        <td height="30">用户笔名<font color="red">(*)</font>：</td>
        <td><input name="uname" class="text" type="text" id="uname" size="16" style="width:200px" /> &nbsp;（发布文章后显示责任编辑的名字）</td>
      </tr>
      <tr bgcolor="#ffffff" >
        <td height="30">用户密码<font color="red">(*)</font>：</td>
        <td><input name="pwd" type="password" id="pwd" size="16" style="width:200px" class="text"/> &nbsp;（只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'、'!'以内范围的字符）</td>
      </tr>
      <tr bgcolor="#ffffff" >
        <td height="30">用户组<font color="red">(*)</font>：</td>
        <td>
         <select name='typeid' style='width:200px'>
          <?php echo get_admin_group();?>
        </select>
        <?php if(!$admin_cityid){?> &nbsp;
        【<a href='admin.php?do=group'><u>用户组设定</u></a>】<?php }?>
      </td>
    </tr>
    <tr bgcolor="#ffffff" >
      <td height="30">真实姓名<font color="red">(*)</font>：</td>
      <td><input name="tname" class="text" type="text" id="tname" size="16" style="width:200px" /> &nbsp;</td>
    </tr>
    <tr bgcolor="#ffffff" >
      <td height="30">电子邮箱<font color="red">(*)</font>：</td>
      <td><input name="email" class="text" type="text" id="email" size="16" style="width:200px" /> &nbsp;</td>
    </tr>
  </table>
</div>
<center>
  <input type="submit" name="Submit" value="提 交" class="mymps large" />
</center>
</form>
<?php mymps_admin_tpl_global_foot();?>