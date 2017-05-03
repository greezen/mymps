<?php include mymps_tpl('inc_head');?>
<script language='javascript'>
	function checkSubmit()
  {
   if(document.form1.uname.value==""){
    alert("用户名不能为空！");
    document.form1.uname.focus();
    return false;
  }
  return true;
}
</script>
<div id="<?=MPS_SOFTNAME?>">
  <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="vbm">
    <form name="form1" action="?do=user" method="post" onSubmit="return checkSubmit();">
      <input type="hidden" name="part" value="update" />
      <input type="hidden" name="id" value="<?=$id?>" />
      <?php if(!$admin_cityid){?>
      <tr>
        <td>隶属分站<font color="red">(*)</font>：</td>
        <td><select name="cityid">
          <option value="0">总站</option>
          <?php echo get_cityoptions($admin[cityid]); ?>
        </select></td>
      </tr>
      <?php }?>
      <tr>
        <td width="16%" height="30">用户登录ID<font color="red">(*)</font>：</td>
        <td width="84%"><input name="userid" class="text" type="text" id="userid" size="16" value="<?=$admin[userid]?>" style="width:200px" /></td>
      </tr>
      <tr>
        <td height="30">用户笔名<font color="red">(*)</font>：</td>
        <td><input name="uname" class="text" type="text" id="uname" size="16" value="<?=$admin[uname]?>" style="width:200px" />
          &nbsp;（回答网站留言时显示的名字） </td>
        </tr>
        <tr>
          <td height="30">真实姓名<font color="red">(*)</font>：</td>
          <td><input name="tname" class="text" type="text" id="tname" size="16" style="width:200px" value="<?= $admin[tname]?>" />
            &nbsp;（不对外显示，只用于方便后台记录显示） </td>
          </tr>
          <tr>
            <td height="30">用户密码<font color="red">(*)</font>：</td>
            <td><input name="pwd" class="text" type="text" id="pwd" size="16" style="width:200px" />
              &nbsp;（留空则不修改，只能用'0-9a-zA-Z.@_-!'以内范围的字符） </td>
            </tr>
            <?php if(!$admin_cityid && $admin[typeid] == 1){?>
            <tr>
              <td height="30">用户组<font color="red">(*)</font>：</td>
              <td>
               <select name='typeid' style='width:200px'>
                <?php echo get_admin_group($admin[typeid]);?>
              </select>
              &nbsp;
              【<a href='admin.php?do=group'><u>用户组设定</u></a>】
            </td>
          </tr>
          <? }else{?>
          <input name="typeid" value="<?=$admin[typeid]?>" type="hidden">
          <?php }?>
          <tr>
            <td height="30">电子邮箱<font color="red">(*)</font>：</td>
            <td><input name="email" class="text" type="text" id="email" size="16" style="width:200px" value="<?= $admin[email]?>" />
              &nbsp;</td>
            </tr>
            <tr>
              <td height="60">&nbsp;</td>
              <td><input type="submit" name="Submit" value="保存用户" class="mymps mini" />
                　<input type="button" onClick=history.back() value="返 回" class="mymps mini">
              </td>
            </tr>
          </form>
        </table>
      </div>
      <?php mymps_admin_tpl_global_foot();?>