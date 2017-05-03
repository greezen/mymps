<?php include mymps_tpl('inc_head');?>
<style>
.ttip{ color:#666; margin-top:5px; text-align:left}
</style>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
<div class="mpstopic-category">
	<div class="panel-tab">
		<ul class="clearfix tab-list">
			<li><a href="?part=bbs" <?php if($part == 'bbs'){?>class="current"<?php }?>>论坛整合</a></li>
			<li><a href="?part=qqlogin" <?php if($part == 'qqlogin'){?>class="current"<?php }?>>QQ登录整合</a></li>
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
<li><?php if($part == 'bbs'){?>如果启用第三方系统整合服务，请正确的进行配置，否则会导致用户不能正常的注册、登录Mymps<?php }else {?>在你开通QQ帐号登录整合之前请到 <a href="http://opensns.qq.com/login?from=http://connect.opensns.qq.com/apply" target="_blank" style="text-decoration:underline">http://opensns.qq.com/login?from=http://connect.opensns.qq.com/apply</a>申请appid, appkey, 并注册callback地址<?}?></li>
    </td>
  </tr>
</table>
</div>

<form method="post" action="?">
<input name="part" value="<?=$part?>" type="hidden">
<?php if($part == 'bbs'){?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr"><td colspan="2">配置<?php echo $here; ?></td></tr>
<tr bgcolor="#ffffff" style="font-weight:bold">
<td width="25%" style=" text-align:right;">
选择整合服务:  &nbsp;&nbsp;
</td>
<td>
<label for="none"><input name="passport_type" type="radio" class="radio" id="none" value="none" onclick='$obj("uc_div").style.display = "none";' <?php if($selected == 'none'){echo 'checked';}?>>不整合第三方论坛</label> 
<label for="ucenter"><input class="radio" name="passport_type" type="radio" id="ucenter" value="ucenter" onclick='$obj("uc_div").style.display = "";$obj("client").innerHTML=$obj("server").innerHTML="ucenter";' <?php if($selected == 'ucenter'){echo 'checked';}?>>整合ucenter1.6</label>
<label for="phpwind"><input class="radio" name="passport_type" type="radio" id="phpwind" value="phpwind" onclick='$obj("uc_div").style.display = "";$obj("client").innerHTML=$obj("server").innerHTML="phpwind";' <?php if($selected == 'phpwind'){echo 'checked';}?>>整合phpwind 8.x</label>
</td>
</tr>
<tbody id="uc_div" <?php if($selected == 'none'){echo 'style="display:none"';}?>>
<tr style="background-color:#f1f5f8;">
  <td height=25 style="text-align:right"><b><span id="client"><?php echo $selected; ?></span>应用设置：</b></td>
  <td>&nbsp;</td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height="25" style="text-align:right">服务端API URL：</td>
  <td><input name="ucsettings[uc_api]" type=text id="uc_api" value="<?=$ucsettings[uc_api]?>" class="text">
  <font color="red"> *</font><div class="ttip">在您 服务端地址或者目录改变的情况下，修改此项，一般情况请不要改动<br />例如: http://www.site.com/ucenter (最后不要加'/')。</div></td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">通信密钥：</div>
  </td>
  <td><input name="ucsettings[uc_key]" type=text id="uc_key" value="<?=$ucsettings[uc_key]?>" class="text">
    <font color="red"> *</font><div class="ttip">只允许使用英文字母及数字，限 64 字节。<br />应用端的通信密钥必须与此设置保持一致，否则该应用将无法与 UCenter 正常通信。</div></td>
</tr>
<tr bgcolor=#FFFFFF>
	<td height=25><div align="right">ucenter和mymps在：</div></td>
    <td>      
    <select name="ucsettings[uc_connect]">
        <option value="mysql" selected="selected"> 同一服务器 </option>
		<option value="NULL" selected="selected"> 不同服务器 </option>
    </select>
    <font color="red">*</font>    </td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">本地客户端应用ID：</div></td>
  <td><input name="ucsettings[uc_appid]" type=text id="uc_appid" value="<?=$ucsettings[uc_appid]?>" class="text"> <font color="red">*</font></td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">本地客户端IP：</div>
  </td>
  <td><input name="ucsettings[uc_ip]" type=text id="uc_ip" value="<?=$ucsettings[uc_ip]?>" class="text"><div class="ttip">
正常情况下留空即可。如果由于域名解析问题导致服务端与该应用通信失败，请尝试设置为该应用所在服务器的 IP 地址。</div></td>
</tr>
<tr style="background-color:#f1f5f8;">
  <td height=25 style="text-align:right"><b><span id="server"><?php echo $selected; ?></span>数据库参数设置：</b></td>
  <td>&nbsp;</td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">数据库主机名：</div>
    </td>
  <td><input name="ucsettings[uc_dbhost]" type=text id="uc_dbhost" value="<?=$ucsettings[uc_dbhost] ? $ucsettings[uc_dbhost] : 'localhost'?>" class="text">
    <font color="red">*</font><div class="ttip">默认:localhost。如果 MySQL 端口不是默认的 3306，请填写如下形式：127.0.0.1:6033。</div></td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">数据库名：</div></td>
  <td><input name="ucsettings[uc_dbname]" type=text id="uc_dbname" value="<?=$ucsettings[uc_dbname]?>" class="text">
    <font color="red">*</font></td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">数据库用户名：</div></td>
  <td><input name="ucsettings[uc_dbuser]" type=text id="uc_dbuser" value="<?=$ucsettings[uc_dbuser]?>" class="text">
    <font color="red">*</font></td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">数据库密码：</div></td>
  <td><input name="ucsettings[uc_dbpwd]" type=password id="uc_dbpwd" value="<?=$ucsettings[uc_dbpwd]?>" class="text">
    <font color="red">*</font></td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">数据表前缀：</div></td>
  <td><input name="ucsettings[uc_dbpre]" type=text id="uc_dbpre" value="<?=$ucsettings[uc_dbpre]?>" class="text">
    <font color="red">*</font>
    <div class="ttip">uc服务端使用的数据库表前缀,一般为 uc_ <br />
      phpwind服务端使用的数据库表前缀,一般为 pw_ </div></td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">数据库字符集：</div></td>
  <td><input name="ucsettings[uc_charset]" type=text id="uc_charset" value="<?=$ucsettings[uc_charset]?>" class="text">
    <font color="red">*</font><div class="ttip">请填写服务端数据库的编码 gbk或ut8</div></td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">UCenter/phpwind 字符编码：</div></td>
  <td><input name="ucsettings[uc_dbcharset]" type=text id="uc_dbcharset" value="<?=$ucsettings[uc_dbcharset]?>" class="text">
    <font color="red">*</font><div class="ttip">请填写数据库的编码 gbk或ut8</div></td>
</tr>
</tbody>
</table>
</div>
<?php } else {?>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
<tr class="firstr"><td colspan="2">配置QQ登录参数</td></tr>
<tr bgcolor="#ffffff" style="font-weight:bold">
<td width="25%" style=" text-align:right; background-color:#f7f7f7">
是否开启QQ登录整合：
</td>
<td style="background-color:#f7f7f7">
<label for="open"><input name="qqsettings[open]" type="radio" class="radio" id="open" value="1" onclick='$obj("qqdetail").style.display = "";' <?php if($qqsettings['open'] == 1){echo 'checked';}?>>开启</label> 
<label for="close"><input class="radio"  name="qqsettings[open]" type="radio" id="close" value="0" onclick='$obj("qqdetail").style.display = "none";' <?php if(!$qqsettings['open']){echo 'checked';}?>>关闭</label>
</td>
</tr>
<tbody id="qqdetail" <?php if(!$qqsettings['open']){?>style="display:none;"<?php }?>>
<tr bgcolor=#FFFFFF>
  <td height=25 width="25%" ><div align="right">申请到的appid：</div></td>
  <td><input name="qqsettings[appid]" type=text id="appid" value="<?=$qqsettings[appid]?>" class="text">
  <font color="red"> *</font></td>
</tr>
<tr bgcolor=#FFFFFF>
  <td height=25><div align="right">申请到的appkey：</div></td>
  <td><input name="qqsettings[appkey]" type=text id="appkey" value="<?=$qqsettings[appkey]?>" class="text">
    <font color="red"> *</font></td>
</tr>
<tr bgcolor=#FFFFFF>
	<td height=25><div align="right">callback地址：</div><div class="ttip">QQ登录成功后跳转的地址，请确保地址真实可用，否则会导致登录失败。</div></td>
    <td>      
    <input name="qqsettings[callback]" type=text id="callback" value="<?=$qqsettings[callback] ? $qqsettings[callback] : $mymps_global[SiteUrl].'/include/qqlogin/qq_callback.php'?>" class="text">
    <font color="red"> *</font></td>
</tr>
</tbody>
</table>
</div>
<?php }?>
<center><input type="submit" value="提 交" class="mymps large" name="passport_submit"/>  </center>
</form>
<?php mymps_admin_tpl_global_foot();?>