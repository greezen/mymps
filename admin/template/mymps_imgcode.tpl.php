<?php include mymps_tpl('inc_head');?>
<style>
.vbm td li{ margin:10px 0!important;}
</style>
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
 <li>为了让系统有更强的兼容性，如果你的空间不支持GD库，请关闭相关页面的验证码显示</li>
 <li>会员登录后发布信息和修改信息是不需要填写验证码的，这里无法对该功能修改</li>
 <li>如需更换验证码背景图，可将你的jpg背景图替换，路径为<font color="#666">/images/authcode/background1.jpg</font>等jpg文件</li>
    </td>
  </tr>
</table>
</div>
<form action="?part=imgcode" method="post">
<input name="action" type="hidden" value="do_post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td colspan="2" align="left">启用验证码</td>
    </tr>
	<tr bgcolor="#ffffff">
      <td align="left" width="200">
      <?php foreach(array('login'=>'用户登录/login','register'=>'用户注册/register','forgetpass'=>'找回密码/forgetpass','post'=>'游客发布信息/post','memberpost'=>'会员发布信息/memberpost','adminlogin'=>'后台管理员登录/adminlogin') as $key => $val){?>
        <li><label for="<?php echo $key; ?>"><input class="checkbox" type="checkbox" name="settingsnew[open][<?php echo $key; ?>]" value="1" id="<?php echo $key; ?>" <?php if($res[$key] == 1) echo 'checked'; ?>><?php echo $val; ?></label></li>
	  <?php }?>
       </td>
      <td align="left" valign="top">
      <div style="margin-top:20px; color:#999">
验证码可以避免恶意注册及恶意发布信息主题，请选择需要打开验证码的操作。注意: 启用验证码会使得部分操作变得繁琐，建议仅在必需时打开<br /><br />
<img src="../<?php echo $mymps_global['cfg_authcodefile']?>?action=preview" id="authcode" style="border:1px #ddd solid;"><br /><br />
<a href="#" onClick="$obj('authcode').src=$obj('authcode').src+'&'">[刷新]</a>
	  </div>
      </td>
    </tr>

</table>
</div>
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
    <tr class="firstr">
      <td colspan="2" align="left">验证码类型</td>
    </tr>
	<tr bgcolor="#ffffff">
      <td align="left" width="200">
      	<?php foreach(array('engber'=>'英文数字组合','english'=>'纯英文','number'=>'纯数字组合','plus'=>'数字求和') as $key => $val){?>
           <li><label for="<?php echo $key; ?>"><input <?php if($key == 'plus'){?>onClick="$obj('show').style.display='none';"<?php }else{?>onClick="$obj('show').style.display='';"<?php }?> class="radio" type="radio" name="settingsnew[type]" value="<?php echo $key; ?>" <?php if($res[type] == $key) echo 'checked'; ?> id="<?php echo $key; ?>"><?php echo $val; ?></label></li>
        <?php }?>
		<div class="clear"></div>
		</td>
      <td align="left" valign="top">
      <div style="margin-top:10px; color:#999">
      	设置验证码的类型，经常的手工更换验证码类型，可有效防止注册机。<br /><br />
选择随机所有类型，亦可有效杜绝注册机，发贴机
      </div>
      </td>
    </tr>
    <tr bgcolor="#ffffff" id="show" <?if ($res['type']=='plus') echo 'style="display:none;"';?>>
    	<td> 
        <li>验证码字符显示数量</li>
        <li><input name="settingsnew[number]" type="text" class="txt" value="<?php echo $res['number']; ?>"></li>
        </td>
        <td><div style="margin-top:10px; color:#999">设置1-5之间<br>数值越大，防范注册机、发帖机效果越好</div></td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td> 
        <li>背景干扰点数值</li>
        <li><input name="settingsnew[noise]" type="text" class="txt" value="<?php echo $res['noise']; ?>"></li>
        </td>
        <td><div style="margin-top:10px; color:#999">数值越大背景出现的杂点越多，防范发贴机效果越好，但是给普通用户带来不便<br /><br />一般设为0-30之间，设置0则无杂点干扰</div></td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td> 
        <li>背景干扰斜线数值</li>
        <li><input name="settingsnew[line]" type="text" class="txt" value="<?php echo $res['line']; ?>"></li>
        </td>
        <td><div style="margin-top:10px; color:#999">设为0-3，设置3时防范发贴机效果较好但也会给普通用户带来不便，设置0则无斜线干扰</div></td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td> 
        <li>验证码倾斜值</li>
        <li><input name="settingsnew[incline]" type="text" class="txt" value="<?php echo $res['incline']; ?>"></li>
        </td>
        <td><div style="margin-top:10px; color:#999">设为0-50，设置50时防范发贴机效果最好但也会给普通用户带来不便，设置0则不倾斜</div></td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td> 
        <li>验证码扭曲值</li>
        <li><input name="settingsnew[distort]" type="text" class="txt" value="<?php echo $res['distort']; ?>"></li>
        </td>
        <td><div style="margin-top:10px; color:#999">设为0-10，设置10时防范发贴机效果最好但也会给普通用户带来不便，设置0则不扭曲</div></td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td> 
        <li>验证码靠拢指数</li>
        <li><input name="settingsnew[close]" type="text" class="txt" value="<?php echo $res['close']; ?>"></li>
        </td>
        <td><div style="margin-top:10px; color:#999">设为0-8，数值越大排列越紧密，设置8时防范发贴机效果最好但也会给普通用户带来不便，设置0则不靠拢</div></td>
    </tr>
</table>
</div>

<center>
<input class="mymps large" value="提 交" type="submit" > &nbsp;
</center>
</form>
<?php mymps_admin_tpl_global_foot();?>