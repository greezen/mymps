<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>">
  <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
     <td colspan="2">技巧提示</td>
   </tr>
   <tr bgcolor="#ffffff">
    <td id="menu_tip">
      <li>如果你的服务器支持mail函数（具体信息请咨询你的空间提供商），我们建议你使用系统的mail函数</li>
      <li>当您的服务器不支持mail函数的时候，您也可以选择SMTP作为邮件服务器。</li>
    </td>
  </tr>
</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
  <table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
     <td colspan="2">常用支持SMTP服务邮箱SMTP地址</td>
   </tr>
   <tr bgcolor="#ffffff">
    <td id="menu_tip">
      <li> <span>qq邮箱</span>=> SMTP.qq.com<font color="red">(推荐)</font>&nbsp;&nbsp;&nbsp;<span>163邮箱</span> => SMTP.163.com&nbsp;&nbsp;&nbsp;<span>188邮箱</span> => SMTP.188.com&nbsp;&nbsp;&nbsp;</li>
    </td>
  </tr>
</table>
</div>
<form method="post" action="mail.php?part=<?=$part?>">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr"><td colspan="2">配置邮件服务器设置</td></tr>
      <tr bgcolor="#ffffff">
        <td width="25%">
          邮件服务:  &nbsp;&nbsp;
        </td>
        <td>
          <label for="mail"><input name="mail_service" type="radio" class="radio" id="mail" value="mail" onclick='document.getElementById("smtp_div").style.display = "none";document.getElementById("mail_div").style.display = "";' <?php if($mail_config[mail_service] != 'smtp'){?>checked="checked"<?}?>>采用服务器内置的mail服务</label> 
          <label for="smtp"><input class="radio" name="mail_service" type="radio" id="smtp" value="smtp" onclick='document.getElementById("smtp_div").style.display = "";document.getElementById("mail_div").style.display = "none";' <?php if($mail_config[mail_service] == 'smtp'){?>checked="checked"<?}?>>采用其他的SMTP服务</label>
          <label for="no"><input class="radio" name="mail_service" type="radio" id="no" value="no" onclick='document.getElementById("smtp_div").style.display = "none";document.getElementById("mail_div").style.display = "none";' <?php if($mail_config[mail_service] == 'no'){?>checked="checked"<?}?>>不采用邮件服务</label>
        </td>
      </tr>
      <tbody id="smtp_div" <?php if($mail_config[mail_service] != 'smtp'){?> style="display:none"<?}?>>
        <!--<tr bgcolor="#ffffff">
        <td>
        邮件服务器是否要求SSL加密链接
        </td>
        <td>
        <label for="0"><input type="radio" name="ssl" value="0" id="0" class="radio" checked="checked">否</label>
        <label for="1"><input type="radio" class="radio" name="ssl" value="1" id="1" onclick="return confirm('此功能要求您的php必须支持OpenSSL模块, 如果您要使用此功能，请联系您的空间商确认支持此模块');">是</label>
        </td>
      </tr>-->
      <tr bgcolor="#ffffff">
        <td>
          SMTP服务器地址
        </td>
        <td>
          <input class="text" type="text" name="smtp_server" value="<?=$mail_config[smtp_server]?>">
          <div style="color:#666; margin-top:5px">需要你的邮箱帐号支持SMTP服务，例如SMTP.qq.com</div></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td>
            SMTP服务器端口
          </td>
          <td><input class="text" type="text" name="smtp_serverport" value="<?php echo $mail_config[smtp_serverport] ? $mail_config[smtp_serverport] : 25;?>"></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td>
            SMTP服务器的用户邮箱
          </td>
          <td><input class="text" type="text" name="smtp_mail" value="<?=$mail_config[smtp_mail]?>"></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td>
            您的邮箱帐号
          </td>
          <td><input class="text" type="text" name="mail_user" value="<?=$mail_config[mail_user]?>"></td>
        </tr>
        <tr bgcolor="#ffffff">
          <td>
            您的邮箱密码
          </td>
          <td><input class="text" type="password" name="mail_pass" value="<?=$mail_config[mail_pass]?>"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <center><input type="submit" value="提 交" class="mymps large" name="mail_submit"/>  </center>
</form>
<div class="clear" style="height:10px;"></div>
<form method="post" action="mail.php?part=test">
  <div id="<?=MPS_SOFTNAME?>">
    <table border="0" cellspacing="0" cellpadding="0" class="vbm">
      <tr class="firstr"><td colspan="2">测试邮件发送</td></tr>
      <tr bgcolor="#ffffff">
        <td width="25%">
          对方邮件地址
        </td>
        <td><input class="text" type="text" name="test_mail" value=""></td>
      </tr>
    </table>
  </div>
  <center><input type="submit" value="提 交" class="mymps large" name="mail_submit"/>  </center>
</form>
<?php mymps_admin_tpl_global_foot();?>