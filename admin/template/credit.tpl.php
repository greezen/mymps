<?php include mymps_tpl('inc_head');?>
<div id="<?=MPS_SOFTNAME?>" style="padding-bottom:0">
<div class="mpstopic-category">
	<div class="panel-tab">
		<ul class="clearfix tab-list">
		<li><a href="score.php">积分增减设置</a></li>
		<li><a href="credit.php" class="current">信用值增减设置</a></li>
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
 <li>扣除请在前面加“-”，如扣除1点信用值请填写“-1” </li>
 <li>增加请在前面加“+”，如增加1点信用值请填写“+1” </li>
    </td>
  </tr>
</table>
</div>
<form action="?" method="post">
<div id="<?=MPS_SOFTNAME?>">
<table border="0" cellspacing="0" cellpadding="0" class="vbm">
  <tr class="firstr">
  	<td colspan="2">信用值被动设置</td>
  </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">通过营业执照认证，信用值变化</td>
 <td bgcolor="#ffffff"><input name="credit_new[rank][com_certify]" value="<?php echo $credit[rank]['com_certify']?>" class="txt"/> <i> 初始值:<font color="red">+50</font></i></td>
 </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">通过身份证认证，信用值变化</td>
 <td bgcolor="#ffffff"><input name="credit_new[rank][per_certify]" value="<?php echo $credit[rank]['per_certify']?>" class="txt"/> <i> 初始值:<font color="red">+50</font></i></td>
 </tr>
  <tr class="firstr">
  	<td colspan="2">信用值主动设置</td>
  </tr>
 <tr bgcolor="#f1f5f8">
 <td style="width:35%; line-height:22px">消费1个金币，信用值变化</td>
 <td bgcolor="#ffffff"><input name="credit_new[rank][coin_credit]" value="<?php echo $credit[rank]['coin_credit']?>" class="txt"/> <i> 初始值:<font color="red">+10</font></i></td>
 </tr>
</table>
</div>
<center><input name="seoset_submit" value="提 交" class="mymps large" type="submit"/></center>
</form>
<?php mymps_admin_tpl_global_foot();?>