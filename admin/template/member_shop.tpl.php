<?php include mymps_tpl('inc_head');?>
<script language='javascript'>
function checkSubmit()
{
	 if(document.form1.userid.value==""){
	     alert("用户名不能为空！");
	     document.form1.userid.focus();
	     return false;
     }
     return true;
}
</script>
<div id="<?=MPS_SOFTNAME?>" style=" padding-bottom:0">
    <div class="mpstopic-category">
        <div class="panel-tab">
            <ul class="clearfix tab-list">
                <? if($part == 'add'){?>
                <li><a href="?part=add" <?php if(!$if_corp){?>class="current"<?php }?>>增加个人会员</a></li>
                <li><a href="?part=add&if_corp=1" <?php if($if_corp == 1){?>class="current"<?php }?>>增加商家会员</a></li>
                <? }else{?>
                <li><a href="?if_corp=0" <?php if(!$if_corp){?>class="current"<?php }?>>个人会员</a></li>
                <li><a href="?if_corp=1" <?php if($if_corp == 1){?>class="current"<?php }?>>商家会员</a></li>
                <? }?>
            </ul>
        </div>
    </div>
</div>
<div style="display:none;">
<iframe width=0 height=0 src='' id="iframe_area" name="iframe_area"></iframe> 
<iframe width=0 height=0 src='' id="iframe_street" name="iframe_street"></iframe> 
<form method="post" target="iframe_area" id="form_area"></form>
</div>
<form name="form1" action="member.php?do=member&part=<?=$action?>" method="post" onSubmit="return checkSubmit();">
<?if ($part == 'edit'){ ?>
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="if_corp" value="1" />
<?} ?>
<input name="reg_corp" value="1" type="hidden"/>
<div id="<?=MPS_SOFTNAME?>">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="vbm">
	<tr class="firstr">
		<td colspan="2">帐号信息</td>
	</tr>
     <tr bgcolor="#ffffff">
      <td height="30">用户帐号：</td>
      <td><input name="userid" type="text" class="text" value="<?=$edit[userid]?>"/> <?php if($edit){?>【非必要，请勿修改<font color="red"><b>特别是整合其他系统（如：ucenter）之后</b></font>】<?php }?></td>
     </tr>
      <tr bgcolor="#ffffff">
        <td width="16%" height="30">用户姓名：</td>
        <td width="84%">
        <input name="cname" type="text" class="text" value="<?=$edit[cname]?>"/>
        </td>
      </tr>

    <tr bgcolor="#ffffff">
        <td height="30">电子邮箱：</td>
        <td>
            <input name="email" type="text" class="text" value="<?=$edit[email]?>"/>
        </td>
    </tr>
    <tr bgcolor="#ffffff">
            <td height="30">所在用户组</td>
            <td>
				<?php echo get_member_level($edit[levelid]);?>
                【<a href="member.php?do=group">设置用户组权限</a>】
		    </td>
        </tr>
    <tr bgcolor="#ffffff">
      <td height="30">登录密码：</td>
      <td><input name="userpwd" type="text" class="text" /> <?if($part == 'edit'){?>【若不修改请留空】<?}?></td>
    </tr>
    <tr class="firstr">
      <td height="30" colspan="2">联系方式</td>
    </tr>
<?php if(!$admin_cityid){?>
  <tr bgcolor="#ffffff">
    <td>所属地区</td>
    <td>
		<?php echo select_where_option('/include/selectwhere.php',$edit['cityid'],$edit['areaid'],$edit['streetid']); ?>
	</td>
  </tr>
  <? }else{ ?>
  <input name="cityid" value="<?php echo $admin_cityid?>" type="hidden" />
  <? }?>
     <tr bgcolor="#ffffff">
      <td height="30">联系人性别：</td>
      <td><select name="sex">
        <?php echo get_sex_option($edit['sex']);?>
        </select></td>
     </tr>
 	<tr bgcolor="#ffffff">
      <td height="30">固定电话：</td>
      <td><input name="tel" type="text" class="text" value="<?=$edit[tel]?>"/> </td>
     </tr>
 	<tr bgcolor="#ffffff">
      <td height="30">移动电话：</td>
      <td><input name="mobile" type="text" class="text" value="<?=$edit[mobile]?>"/> </td>
     </tr>
 	<tr bgcolor="#ffffff">
      <td height="30">QQ号码：</td>
      <td><input name="qq" type="text" class="text" value="<?=$edit[qq]?>"/> </td>
     </tr>
 	<tr bgcolor="#ffffff">
      <td height="30">MSN：</td>
      <td><input name="msn" type="text" class="text" value="<?=$edit[msn]?>"/> </td>
     </tr>
 	<tr bgcolor="#ffffff">
      <td height="30">机构网址：</td>
      <td><input name="web" type="text" class="text" value="<?=$edit[web]?>"/> 请以 http:// 开始</td>
     </tr>
 	<tr bgcolor="#ffffff">
      <td height="30">详细地址：</td>
      <td><input name="address" type="text" class="text" value="<?=$edit[address]?>"/> </td>
     </tr>
 	<tr bgcolor="#ffffff">
      <td height="30">乘车路线：</td>
      <td>
      <textarea name="busway" style="height:100px; width:300px"><?=$edit[busway]?></textarea></td>
     </tr>
 	<tr bgcolor="#ffffff">
      <td height="30">地图标注：</td>
      <td><input id='mappoint' name='mappoint' type='text' maxLength='50' value="<?=$edit['mappoint']?>" class="text"> <input type="button" class="gray mini" value="我要标注" onclick="javascript:setbg('地图标注',500,300,'../map.php?action=markpoint&width=500&height=300')" />
	  </td>
	 </tr>
	<tr class="firstr">
	  <td height="30" colspan="2">其它信息</td>
	</tr>
    <tr bgcolor="#ffffff">
      <td height="30">个人身份证认证：</td>
      <td>
      <select name="per_certify">
      	<option value="1" <?php if($edit['per_certify'] == 1) echo 'selected style="background-color:#6EB00C;color:white"';?>>通过验证</option>
        <option value="0" <?php if(empty($edit['per_certify'])) echo 'selected style="background-color:#6EB00C;color:white"';?>>未通过验证</option>
      </select></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td height="30">营业执照认证：</td>
      <td>
      <select name="com_certify">
      	<option value="1" <?php if($edit['com_certify'] == 1) echo 'selected style="background-color:#6EB00C;color:white"';?>>通过验证</option>
        <option value="0" <?php if(empty($edit['com_certify'])) echo 'selected style="background-color:#6EB00C;color:white"';?>>未通过验证</option>
      </select></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td height="30">拥有金币：</td>
      <td><input name="money_own" type="text" class="txt" value="<?=$edit[money_own]?>"/> <img src="../member/images/mymps_icon_incomes.gif" align="absmiddle"></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td height="30">积分：</td>
      <td><input name="score" type="text" class="txt" value="<?=$edit[score]?>"/></td>
    </tr>
    <tr bgcolor="#ffffff">
      <td height="30">信用值：</td>
      <td><input name="credit" type="text" class="txt" value="<?=$edit[credit]?>"/> 
	  <?php if($edit[credits]){?>
	  <img src="../images/credit/<?=$edit[credits]?>.gif" align="absmiddle">
	  <?} ?>
	  </td>
    </tr>
	<tr class="firstr">
		<td colspan="2">网店信息</td>
	</tr>
 	<tr bgcolor="#ffffff">
      <td height="30">商家/机构名称：</td>
      <td><input name="tname" type="text" class="text" value="<?=$edit[tname]?>"/> </td>
     </tr>
    <tr bgcolor="#ffffff">
        <td height="30">商家/机构类型：</td>
        <td>
            <?php echo get_member_cat(explode(',',$edit[catid]));?>
        </td>
    </tr>
	<tr bgcolor="#ffffff">
		<td>空间使用模板</td>
		<td>
		<select name="template">
		<?=get_shop_tpl($edit['template'],$edit['userid']);?>
		</select>
		</td>
	</tr>
	<tr class="firstr">
		<td colspan="2">商家/机构简介：</td>
	</tr>
</table>
<div style="margin-top:3px;">
	<?=$acontent?>
</div>
</div>
<center><input type="submit" class="mymps mini" value="提 交">
                　<input type="button" onClick="location.href='member.php?if_corp=1'"  class="mymps mini" value="返 回"></center>
</form>
<?php mymps_admin_tpl_global_foot();?>