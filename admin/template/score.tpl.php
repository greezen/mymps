<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
<div class="mpstopic-category">
	<div class="panel-tab">
		<ul class="clearfix tab-list">
		<li><a href="score.php" class="current">积分增减设置</a></li>
		<li><a href="credit.php">信用值增减设置</a></li>
		<li><a href="credit_set.php">信用等级管理</a></li>
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
 <li>扣除请在前面加“-”，如扣除1点积分请填写“-1” </li>
 <li>增加请在前面加“+”，如增加1点积分请填写“+1” </li>
 <li>所有的积分操作都是在整个过程完成之后，如认证增加积分，是要后台审核通过后才会增加 </li>
    </td>
  </tr>
</table>
</div>
<form action="?" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">会员积分设置管理</td>
  </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">注册成功</td>
 <td bgcolor="#ffffff"><input name="score_new[rank][register]" value="<?php echo $score[rank]['register']?>" class="txt"/>
 <i> 初始值:<font color="red">+10</font></i></td>
 </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">登录签到</td>
 <td bgcolor="#ffffff"><input name="score_new[rank][login]" value="<?php echo $score[rank]['login']?>" class="txt"/>
 <i> 初始值:<font color="red">+2</font></i></td>
 </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">发布分类信息</td>
 <td bgcolor="#ffffff"><input name="score_new[rank][information]" value="<?php echo $score[rank]['information']?>" class="txt"/>
 <i> 初始值:<font color="red">+2</font></i></td>
 </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">发布优惠券</td>
 <td bgcolor="#ffffff"><input name="score_new[rank][coupon]" value="<?php echo $score[rank]['coupon']?>" class="txt"/>
 <i> 初始值:<font color="red">+2</font></i></td>
 </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">发起团购</td>
 <td bgcolor="#ffffff"><input name="score_new[rank][group]" value="<?php echo $score[rank]['group']?>" class="txt"/>
 <i> 初始值:<font color="red">+2</font></i></td>
 </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">发布商品</td>
 <td bgcolor="#ffffff"><input name="score_new[rank][goods]" value="<?php echo $score[rank]['goods']?>" class="txt"/>
 <i> 初始值:<font color="red">+2</font></i></td>
 </tr>
  <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">营业执照认证</td>
 <td bgcolor="#ffffff"><input name="score_new[rank][com_certify]" value="<?php echo $score[rank]['com_certify']?>" class="txt"/>
 <i> 初始值:<font color="red">+10</font></i></td>
 </tr>
  <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">个人身份证认证</td>
 <td bgcolor="#ffffff"><input name="score_new[rank][per_certify]" value="<?php echo $score[rank]['per_certify']?>" class="txt"/>
 <i> 初始值:<font color="red">+10</font></i></td>
 </tr>
</table>
</div>
<center><input name="seoset_submit" value="提 交" class="mymps large" type="submit"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>